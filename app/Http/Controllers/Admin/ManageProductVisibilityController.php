<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\FirstLevelCategoryModel; 
use App\Common\Services\UserService;
use App\Models\ProductModel; 
use App\Models\UserModel;



use Validator;
use Sentinel;
use DB;
use Datatables;
use Flash;

class ManageProductVisibilityController extends Controller
{
    /*
    | Author : Akshay Nair
	| Date   : 31 Dec 2019
    */

    public function __construct(
                                    CountriesModel $CountriesModel,
                                    StatesModel $StatesModel,
                                    FirstLevelCategoryModel $FirstLevelCategoryModel,
                                    UserService $UserService,
                                    ProductModel $ProductModel,
                                    UserModel $UserModel
                                ) 
    {

        $this->CountriesModel          = $CountriesModel;
        $this->StatesModel             = $StatesModel;
        $this->FirstLevelCategoryModel = $FirstLevelCategoryModel;
        $this->UserService             = $UserService;
        $this->ProductModel            = $ProductModel;
        $this->UserModel               = $UserModel;


        $this->arr_view_data      = [];
        $this->module_title       = "Product Visibility";
        $this->module_view_folder = "admin.manage_product_visibility";
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/manage_product_visibility");
    }

    public function index()
    {
        
        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title)." (By Country)";
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug');


        // dd($this->module_view_folder . '.index', $this->arr_view_data);
        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }
    
    public function view_states($enc_id)
    {
        $id   = base64_decode($enc_id);
        $this->arr_view_data['enc_id']            = $enc_id;
        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title)." (By State)";
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug');


        // dd($this->module_view_folder . '.index', $this->arr_view_data);
        return view($this->module_view_folder. '.view_states', $this->arr_view_data);
    }    
    
    public function delete_country($enc_id)
    {
        $id   = base64_decode($enc_id);
        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title)." (By State)";
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug');


        // dd($this->module_view_folder . '.index', $this->arr_view_data);
        return view($this->module_view_folder. '.view_states', $this->arr_view_data);
    }

    public function get_countries(Request $request)
    {
       
        $obj_country = $this->get_country_records($request);

        $current_context = $this;

        $json_result = Datatables::of($obj_country);

        $json_result =   $json_result->editColumn('enc_id', function ($data) use ($current_context) {
            return base64_encode($data->id);
        })

        ->editColumn('name', function ($data) use ($current_context) {
            if ($data->name != "") {
                return $data->name;
            } else {
                return "N/A";
            }
        })
             

        ->editColumn('build_status_btn', function ($data) use ($current_context) {
            $build_status_btn = "";

            if ($data->is_active == '0') {

                $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="' . base64_encode($data->id) . '"  class="js-switch toggleSwitch" data-type="activate_country" data-color="#99d683" data-secondary-color="#f96262" />';
            } elseif ($data->is_active == '1') {

                $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="' . base64_encode($data->id) . '"  id="status_' . $data->id . '" class="js-switch toggleSwitch" data-type="deactivate_country" data-color="#99d683" data-secondary-color="#f96262"/>';
            }

            return $build_status_btn;
        })


        ->editColumn('build_action_btn', function ($data) use ($current_context) {
            $view_state_href =  $this->module_url_path . '/view_states/' . base64_encode($data->id);
            $build_view_state_action = '<a class="eye-actn" href="' . $view_state_href . '" title="View States">View State</a>';
            
            $edit_href =  $this->module_url_path . '/edit/' . base64_encode($data->id);
            $build_edit_action = '<a class="eye-actn" href="' . $edit_href . '" title="Edit">Edit</a>';

            // $delete_href =  $this->module_url_path . '/delete/' . base64_encode($data->id);
            // $confirm_delete = 'onclick="confirm_delete(this,event);"';

            // $build_delete_action = '<a class="btns-removes" ' . $confirm_delete . ' href="' . $delete_href . '" title="Delete">Delete</a>';

            return $build_action = $build_view_state_action.' '.$build_edit_action ;
        })

        ->make(true);

        $build_result = $json_result->getData();

        return response()->json($build_result);
    }



    public function multi_action(Request $request)
    {
        $user = Sentinel::check();

        $flag = "";

        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('Please Select '.str_plural($this->module_title) .' to perform multi actions');  
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

       
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','problem occured, while doing multi action');
            return redirect()->back();

        }
        
        foreach ($checked_record as $key => $record_id) 
        {  
            
            if($multi_action=="activate")
            {
                $flag = "activate";

                $this->perform_activate(1,base64_decode($record_id),$flag); 
                Flash::success(ucfirst(strtolower($this->module_title)).' activated successfully.'); 
            }
            elseif($multi_action=="deactivate")
            {
                $flag = "deactivate";
               
                $this->perform_deactivate(1,base64_decode($record_id),$flag);    
                Flash::success(ucfirst(strtolower($this->module_title)).' blocked successfully'); 

            }
        }

        if($multi_action=="activate")
        {
           /*--------- ----------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on countries.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                
                /*----------------------------------------------------------------------*/
        }

        if($multi_action=="deactivate")
        {
            /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DEACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on countries.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                
                /*----------------------------------------------------------------------*/
        }

        return redirect()->back();
    }

    public function perform_activate($flag,$id,$action_flag=false)
    {
        $user = Sentinel::check();

        if($flag==1)
        {

                $entity = $this->CountriesModel->where('id',$id)->first();

                if($entity)
                {   
                    $entity_arr = $entity->toArray();

                    if($action_flag == false)
                    {
                        /*-------------------------------------------------------
                        |   Activity log Event
                        --------------------------------------------------------*/
                          
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'ACTIVATE';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated country '.$entity_arr['name'].'.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }
                       /*----------------------------------------------------------------------*/
                    }
                    

                    $this->CountriesModel->where('id',$id)->update(['is_active'=>'1']);
                    return TRUE;
                }
                return FALSE;
        }
        if($flag==2)
        {

            $entity = $this->StatesModel->where('id',$id)->first();

            if($entity)
            {   
                $entity_arr = $entity->toArray();

                if($action_flag == false)
                {
                   /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'ACTIVATE';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated state '.$entity_arr['name'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }
                   /*----------------------------------------------------------------------*/
                     
                }
                

                $this->StatesModel->where('id',$id)->update(['is_active'=>'1']);
                return TRUE;
            }

            return FALSE;
        }


    }

    public function perform_deactivate($flag,$id,$action_flag=false)
    {
        $user = Sentinel::check();

        if($flag==1){

            $entity = $this->CountriesModel->where('id',$id)->first();

            if($entity)
            {   
                $entity_arr = $entity->toArray();

                if($action_flag == false)
                {
                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'DEACTIVATE';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated country '.$entity_arr['name'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }
                    /*----------------------------------------------------------------------*/

                }
               

                $this->CountriesModel->where('id',$id)->update(['is_active'=>'0']);
                return TRUE;
            }
            return FALSE;
        }
         
        if($flag==2){
            
            $entity = $this->StatesModel->where('id',$id)->first();

            if($entity)
            {   
                $entity_arr = $entity->toArray();

                if($action_flag == false)
                {
                   

                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'DEACTIVATE';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated state '.$entity_arr['name'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }
                    /*----------------------------------------------------------------------*/

                }

                $this->StatesModel->where('id',$id)->update(['is_active'=>'0']);
                return TRUE;
            }

            return FALSE;
        }


    }
    
    public function get_states(Request $request, $country_id)
    {
        $country_id = base64_decode($country_id);
        $obj_states = $this->get_states_records($request, $country_id);

        $current_context = $this;

        $json_result = Datatables::of($obj_states);


        $json_result =   $json_result->editColumn('enc_id', function ($data) use ($current_context) {
            return base64_encode($data->id);
        })

        ->editColumn('name', function ($data) use ($current_context) {
            if ($data->name != "") {
                return $data->name;
            } else {
                return "N/A";
            }
        })
        ->editColumn('tax_percentage', function ($data) use ($current_context) {
            if ($data->tax_percentage != "NULL" && $data->tax_percentage!="") {
                return number_format($data->tax_percentage,2)." %";
            } else {
                return "N/A";
            }
        })
        ->editColumn('build_status_btn', function ($data) use ($current_context) {
            $build_status_btn = "";

            if ($data->is_active == '0') {

                $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="' . base64_encode($data->id) . '"  class="js-switch toggleSwitch" data-type="activate_state" data-color="#99d683" data-secondary-color="#f96262" />';
            } elseif ($data->is_active == '1') {

                $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="' . base64_encode($data->id) . '"  id="status_' . $data->id . '" class="js-switch toggleSwitch" data-type="deactivate_state" data-color="#99d683" data-secondary-color="#f96262"/>';
            }

            return $build_status_btn;
        })
        ->editColumn('build_documents_required_btn', function ($data) use ($current_context) {
            $build_documents_required_btn = "";

            if ($data->is_documents_required == '0') {

                $build_documents_required_btn = '<input type="checkbox" data-size="small" data-enc_id="' . base64_encode($data->id) . '"  class="js-switch toggleSwitch_doc" data-type="documents_required" data-color="#99d683" data-secondary-color="#f96262" />';
            } elseif ($data->is_documents_required == '1') {

                $build_documents_required_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="' . base64_encode($data->id) . '"  id="status_' . $data->id . '" class="js-switch toggleSwitch_doc" data-type="documents_not_required" data-color="#99d683" data-secondary-color="#f96262"/>';
            }

            return $build_documents_required_btn;
        })

          ->editColumn('build_buyer_restricted_btn', function ($data) use ($current_context) {
            $build_buyer_restricted_btn = "";

            if ($data->is_buyer_restricted == '0') {

                $build_buyer_restricted_btn = '<input type="checkbox" data-size="small" data-enc_id="' . $data->id . '"  class="js-switch toggleSwitch_buyerrestricted" data-type="buyer_restricted" data-color="#99d683" data-secondary-color="#f96262" />';
            } elseif ($data->is_buyer_restricted == '1') {

                $build_buyer_restricted_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="' . $data->id . '"  id="status_' . $data->id . '" class="js-switch toggleSwitch_buyerrestricted" data-type="buyer_unrestricted" data-color="#99d683" data-secondary-color="#f96262"/>';
            }

            return $build_buyer_restricted_btn;
        })


        ->editColumn('build_action_btn', function ($data) use ($current_context) {
            
            $edit_href =  $this->module_url_path . '/edit_state/' . base64_encode($data->id);
            $build_edit_action = '<a class="eye-actn" href="' . $edit_href . '" title="Edit">Edit</a>';

            $view_href =  $this->module_url_path . '/view_state/' . base64_encode($data->id);
            $build_view_btn = '<a class="eye-actn" href="' . $view_href . '" title="View">View</a>'; 

            $build_view_documents_action = "";


           // if(isset($data->is_documents_required) && $data->is_documents_required == '1')
            if(isset($data->required_documents) && $data->required_documents!="")
            {
             /* $build_view_documents_action = '<a class="eye-actn viewRequiredDocuments"  title="View Required Documents" data-id="'.$data->id.'" data-doc_list="'.$data->required_documents.'">View Required Documents</a>';*/

               $build_view_documents_action =
              '<a href="javascript:void(0);" class="eye-actn" data-id="'.$data->id.'" data-doc_list="'.$data->required_documents.'" onclick="get_documents_list('.$data->id.')">View Required Documents</a>';
            }

            // $delete_href =  $this->module_url_path . '/delete/' . base64_encode($data->id);
            // $confirm_delete = 'onclick="confirm_delete(this,event);"';

            // $build_delete_action = '<a class="btns-removes" ' . $confirm_delete . ' href="' . $delete_href . '" title="Delete">Delete</a>';


            return $build_action = $build_edit_action.' '.$build_view_btn.' '.$build_view_documents_action ;
        })

 
        ->make(true);

        $build_result = $json_result->getData();


        return response()->json($build_result);
    }

    public function multi_action_state(Request $request)
    {
        $user = Sentinel::check();
        $flag= "";

        $arr_rules = array();
        $arr_rules['multi_action']   = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('Please Select '.str_plural($this->module_title) .' to perform multi actions');  
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action   = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

       
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','problem occured, while doing multi action');
            return redirect()->back();

        }
        
        foreach ($checked_record as $key => $record_id) 
        {  
            
            if($multi_action=="activate")
            {
                $flag = "activate";

               $this->perform_activate(2,base64_decode($record_id),$flag); 
               Flash::success(ucfirst(strtolower($this->module_title)).' (by state) activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $flag = "deactivate";

               $this->perform_deactivate(2,base64_decode($record_id),$flag);    
               Flash::success(ucfirst(strtolower($this->module_title)).' (by state) blocked successfully');  
            }
        }

        if($multi_action=="activate")
        {
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
            //save sub admin activity log 

            if(isset($user) && $user->inRole('sub_admin'))
            {
                $arr_event                 = [];
                $arr_event['action']       = 'ACTIVATE';
                $arr_event['title']        = $this->module_title;
                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on states.';

                $result = $this->UserService->save_activity($arr_event); 
            }
            /*----------------------------------------------------------------------*/
        }

        if($multi_action=="deactivate")
        {
             /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DEACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on states.';

                    $result = $this->UserService->save_activity($arr_event); 
                }
                /*----------------------------------------------------------------------*/
        }

        return redirect()->back();
    }


        function get_required_documents(Request $request)
        {
             $state_id = $request->input('id');
             if(isset($state_id) && !empty($state_id))
             {
                $obj_state = $this->StatesModel->where('id',$state_id)->select('required_documents')->first();
                if(isset($obj_state) && !empty($obj_state))
                {
                  $arr_response['data']   = $obj_state['required_documents'];
                  $arr_response['status'] = 'SUCCESS';
            } else {
                $arr_response['status'] = 'ERROR';
            }

            }

        return response()->json($arr_response);  
         }






    function get_country_records(Request $request)
    {
               

        $countries_table           = $this->CountriesModel->getTable();
        $prefixed_countries_table  = DB::getTablePrefix() . $this->CountriesModel->getTable();

        $obj_country             = DB::table($countries_table)
            ->select(DB::raw(
                $prefixed_countries_table . ".id," .
                    $prefixed_countries_table . ".is_active," .
                    $prefixed_countries_table . ".name" 
            ))
            ->orderBy($countries_table . '.name', 'ASC');
        /* ---------------- Filtering Logic ----------------------------------*/

        $arr_search_column = $request->input('column_filter');

        if (isset($arr_search_column['q_name']) && $arr_search_column['q_name'] != "") {
            $search_term      = $arr_search_column['q_name'];
            $obj_country   = $obj_country->where($prefixed_countries_table . '.name', 'LIKE', '%' . $search_term . '%');
            
        }

        if (isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != "") {
            $search_term       = $arr_search_column['q_status'];
            $obj_country   = $obj_country->where($prefixed_countries_table . '.is_active', 'LIKE', '%' . $search_term . '%');
                                        
        }

        return $obj_country;
    }
    
    function get_states_records(Request $request, $country_id)
    {
               

        $states_table           = $this->StatesModel->getTable();
        $prefixed_states_table  = DB::getTablePrefix() . $this->StatesModel->getTable();

        $obj_country             = DB::table($states_table)
            ->select(DB::raw(
                $prefixed_states_table . ".id," .
                    $prefixed_states_table . ".is_active," .
                    $prefixed_states_table . ".is_documents_required," .
                     $prefixed_states_table . ".is_buyer_restricted," .
                    $prefixed_states_table . ".required_documents," .
                    $prefixed_states_table . ".name,".
                    $prefixed_states_table . ".shortname,".
                    $prefixed_states_table . ".tax_percentage"  
            ))
            ->where('country_id', $country_id)
            ->orderBy($states_table . '.name', 'ASC');
        /* ---------------- Filtering Logic ----------------------------------*/

        $arr_search_column = $request->input('column_filter');

        if (isset($arr_search_column['q_name']) && $arr_search_column['q_name'] != "") {
            $search_term      = $arr_search_column['q_name'];
            $obj_country   = $obj_country->where($prefixed_states_table . '.name', 'LIKE', '%' . $search_term . '%');
            
        }

        if (isset($arr_search_column['q_tax_percentage']) && $arr_search_column['q_tax_percentage'] != "") {
            $search_term       = $arr_search_column['q_tax_percentage'];
            $obj_country   = $obj_country->where($prefixed_states_table . '.tax_percentage', 'LIKE', '%' . $search_term . '%');
        }

        if (isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != "") {
            $search_term       = $arr_search_column['q_status'];
            $obj_country   = $obj_country->where($prefixed_states_table . '.is_active', 'LIKE', '%' . $search_term . '%');
        }

        if (isset($arr_search_column['q_documents_required']) && $arr_search_column['q_documents_required'] != "") {
            $search_term       = $arr_search_column['q_documents_required'];
            $obj_country   = $obj_country->where($prefixed_states_table . '.is_documents_required', 'LIKE', '%' . $search_term . '%');
        }
         if (isset($arr_search_column['q_buyer_restricted']) && $arr_search_column['q_buyer_restricted'] != "") {
            $search_buyerterm       = $arr_search_column['q_buyer_restricted'];
            $obj_country   = $obj_country->where($prefixed_states_table . '.is_buyer_restricted', 'LIKE', '%' . $search_buyerterm . '%');
        }

        return $obj_country;
    }

    public function create()
    {
        $this->arr_view_data['page_title']      = "Create " . str_singular($this->module_title) . " (By Country)";
        $this->arr_view_data['module_title']    = str_singular($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder . '.create', $this->arr_view_data);
    }
    
    public function create_state($country_id)
    {
        $arr_category      = [];
        $arr_category      = $this->FirstLevelCategoryModel->where('is_active','1')
                                                           ->get()
                                                           ->toArray(); 
        $this->arr_view_data['country_id']      = base64_Decode($country_id);
        $this->arr_view_data['arr_category']    = isset($arr_category)?$arr_category:'';
        $this->arr_view_data['page_title']      = "Create " . str_singular($this->module_title) . " (By State)";
        $this->arr_view_data['module_title']    = str_singular($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder . '.create_state', $this->arr_view_data);
    }

    public function edit($enc_id)
    {
        $arr_data = [];
        $id = base64_decode($enc_id);

        $obj_country= $this->CountriesModel->where('id', $id)
            ->first();
        if ($obj_country) {
            $arr_data = $obj_country->toArray();
        }


        $this->arr_view_data['arr_data']          = isset($arr_data) ? $arr_data : [];
        $this->arr_view_data['page_title']        = "Manage " . str_plural($this->module_title) . " (By Country)";
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug');
        // dd($this->module_view_folder . '.index', $this->arr_view_data);
        return view($this->module_view_folder . '.edit', $this->arr_view_data);
    } 
    
    public function edit_state($enc_id)
    {
        $arr_data   = $arr_category = $arr_restrict_categories = [];
        $restrict_categories = "";
        $id = base64_decode($enc_id);

        $obj_states = $this->StatesModel->where('id', $id)
            ->first();
        if ($obj_states) {
            $arr_data = $obj_states->toArray();
        }

        $obj_category      = $this->FirstLevelCategoryModel->where('is_active','1')
                                                       ->get();
        if($obj_category){
            $arr_category  = $obj_category->toArray();
        } 

       if(isset($arr_data) && sizeof($arr_data)>0 && isset($arr_data['category_ids']) && $arr_data['category_ids']!="")
        {
           $arr_restrict_categories  =  explode(',',$arr_data['category_ids']);
           $restrict_categories      =  get_restrict_category_names($arr_restrict_categories); 
        }  
     

        $this->arr_view_data['arr_data']          = isset($arr_data) ? $arr_data : [];
        $this->arr_view_data['arr_category']      = isset($arr_category)?$arr_category:'';
        $this->arr_view_data['arr_restrict_categories'] = isset($arr_restrict_categories)?$arr_restrict_categories:'';
        $this->arr_view_data['arr_data']          = isset($arr_data) ? $arr_data : [];
        $this->arr_view_data['page_title']        = "Manage " . str_plural($this->module_title) . " (By State)";
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug');
        // dd($this->module_view_folder . '.index', $this->arr_view_data);
        return view($this->module_view_folder . '.edit_state', $this->arr_view_data);
    }

    public function view_state($enc_id)
    {
        $arr_data   = $arr_restrict_categories = [];
        $id         = base64_decode($enc_id);
        $restrict_categories = "";

        $obj_states = $this->StatesModel->where('id', $id)
            ->with('country_details')->first();
        if ($obj_states) {
            $arr_data = $obj_states->toArray();
        }
        

        if(isset($arr_data) && sizeof($arr_data)>0 && isset($arr_data['category_ids']) && $arr_data['category_ids']!="")
        {
           $arr_restrict_categories  =  explode(',',$arr_data['category_ids']);
           $restrict_categories      =  get_restrict_category_names($arr_restrict_categories); 
        }  
     

        $this->arr_view_data['arr_data']          = isset($arr_data) ? $arr_data : [];
        $this->arr_view_data['restrict_categories'] = isset($restrict_categories)?$restrict_categories:'';
        $this->arr_view_data['page_title']        = "View " . str_plural($this->module_title) . " (By State)";
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug');
        // dd($this->module_view_folder . '.index', $this->arr_view_data);
        return view($this->module_view_folder . '.show_state', $this->arr_view_data);
    }

    public function update_country(Request $request)
    {
        $user = Sentinel::check();

        $form_data = $request->all();

        $is_update_process = false;

        $id = $request->input('id', false);

        if ($request->has('id')) {
            $is_update_process = true;
        }

        $arr_rules = [
            'name'            => 'required'
        ];

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }

        /* Duplication Check */
        $obj_dup_check = $this->CountriesModel->where('name', $request->input('name'));

        if ($is_update_process) {
            $obj_dup_check = $obj_dup_check->where('id', '<>', $request->input("id"));
        }

        $does_exists = $obj_dup_check->count();

        if ($does_exists) {
            $response['status']      = 'warning';
            $response['description'] = str_singular($this->module_title) . ' already exists.';

            return response()->json($response);
        }

        /* Main Model Entry */
        $update_country_details = $this->CountriesModel->firstOrNew(['id' => $id]);
        $update_country_details->name                    = ucwords($request->input('name'));
        
        if (isset($form_data['country_status']) && !empty($form_data['country_status'])) {
            $country_status = $form_data['country_status'];
        } else {
            $country_status = '0';
        }

        $update_country_details->is_active = $country_status;

 
        $update_country_details->save();

        if ($update_country_details) {

            if ($is_update_process == false) 
            {
                
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ADD';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added country '.$update_country_details->name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['link']        = $this->module_url_path;
                $response['status']      = "success";
                $response['description'] = "Country saved successfully.";

            } 
            else
            {
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'EDIT';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated country '.$update_country_details->name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['link']        = $this->module_url_path . '/edit/' . base64_encode($id);
                $response['status']      = "success";
                $response['description'] = "Country updated successfully.";
            }

        } else {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding category.";
        }

        return response()->json($response);
    }
    
    public function update_state(Request $request)
    {
        $form_data = $request->all();

        $user = Sentinel::check();


        if (isset($form_data['country_id']) && $form_data['country_id']==0) {
            $response['status']      = 'warning';
            $response['description'] = 'Please add the state under any country..!';

            return response()->json($response);
        }
        $is_update_process = false;

        $id = $request->input('id', false);

        if ($request->has('id')) {
            $is_update_process = true;
        }

        $arr_rules = [ 
            'name'            => 'required'
        ];

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }

        /* Duplication Check */

        if(isset($form_data['country_id']))
        {
         $obj_dup_check = $this->StatesModel->where('name', $request->input('name'))->where('country_id',$form_data['country_id']);
        }else{
         $obj_dup_check = $this->StatesModel->where('name', $request->input('name'));
        }


        if ($is_update_process) {
            $obj_dup_check = $obj_dup_check->where('id', '<>', $request->input("id"));
        }

        $does_exists = $obj_dup_check->count();

        if ($does_exists) {
            $response['status']      = 'warning';
            $response['description'] = 'This state already exists.';

            return response()->json($response);
        }

        /* Main Model Entry */
        $update_state_details = $this->StatesModel->firstOrNew(['id' => $id]);
        $update_state_details->name   = ucwords($request->input('name'));
        
        
        if (isset($form_data['state_status']) && !empty($form_data['state_status'])) {
            $state_status = $form_data['state_status'];
        } else {
            $state_status = '0';
        }

        $str_categories = $tax_percentage = "";


        if(isset($form_data['category_id']) && sizeof($form_data['category_id'])>0)
        {
            //get sellers of this state 
            // $seller_arr = [];
            // $get_sellers = $this->UserModel->where('state',$id)->get()->toArray();
            // if(isset($get_sellers) && !empty($get_sellers))
            // {
            //      $seller_arr = [];
            //      foreach($get_sellers as $v)
            //      {
            //          $seller_arr[] = $v['id'];
            //      }
                
            // }
          

            $str_categories = implode(',',$form_data['category_id']);

            /*foreach($form_data['category_id'] as $k=>$v)
            {
              
                //get approved products of that categories
               $get_approved_products = $this->ProductModel
                            ->where('first_level_category_id',$v)
                            ->where('is_approve',1)
                            ->select('id','first_level_category_id','product_name','user_id');

                  if(isset($seller_arr) && !empty($seller_arr))
                  {
                   
                    $get_approved_products = $get_approved_products->whereIn('user_id',$seller_arr);
                    
                  }          

                 $get_approved_products = $get_approved_products->get(); 
                 

                if(isset($get_approved_products) && !empty($get_approved_products))
                {
                    $get_approved_products = $get_approved_products->toArray();

                     $update_approve_status =[];
                    foreach($get_approved_products as $kk=>$vv)
                    {
                        $update_approve_status['is_approve'] = 2;
                        $update_approve_status['reason'] = 'These products are not allowed in your state anymore';

                        //disapprove products if category is restricted
                        $this->ProductModel->where('id',$vv['id'])
                                           ->where('is_approve',1)
                                           ->update($update_approve_status);


                    }// foreach get_approved_products

                }//if isset get_approved_products

                
            }//foreach 
            */
        }

        if(isset($form_data['tax_percentage']) && !empty($form_data['tax_percentage']) && $form_data['tax_percentage']!=null)
        {
            $update_state_details->tax_percentage = $form_data['tax_percentage'];
        }
         else 
        {
            $update_state_details->tax_percentage = 'NULL';
        }  
        // else if($form_data['tax_percentage']==null)
        // {
        //     $update_state_details->tax_percentage = 'NULL';
        // }    


        $update_state_details->country_id            = $form_data['country_id'];
        $update_state_details->shortname            = $form_data['shortname'];
        $update_state_details->category_ids          = $str_categories;
        $update_state_details->is_active             = $state_status;
        $update_state_details->text                  = $form_data['state_restricted_text'];


        $update_state_details->save();

        if ($update_state_details) {

            if ($is_update_process == false) 
            {

                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ADD';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added state '.$update_state_details->name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                    
                $response['link'] = $this->module_url_path."/view_states/". base64_encode($form_data['country_id']);
                $response['status']      = "success";
                $response['description'] = "State saved successfully.";

            } 
            else
            {
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'EDIT';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated state '.$update_state_details->name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['link'] = $this->module_url_path . "/view_states/" . base64_encode($form_data['country_id']);
                $response['status']      = "success";
                $response['description'] = "State updated successfully.";

            }
        } 
        else 
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding category.";
        }

        return response()->json($response);
    }

    public function activate_country(Request $request)
    {
        $enc_id = $request->input('id');

        if (!$enc_id) {
            return redirect()->back();
        }

        if ($this->perform_activate_country(base64_decode($enc_id))) {
            $arr_response['status'] = 'SUCCESS';
        } else {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'ACTIVE';
        return response()->json($arr_response);
    }

    public function deactivate_country(Request $request)
    {
        $enc_id = $request->input('id');

        if (!$enc_id) {
            return redirect()->back();
        }

        if ($this->perform_deactivate_country(base64_decode($enc_id))) {
            $arr_response['status'] = 'SUCCESS';
        } else {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }

    public function perform_activate_country($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity = $this->CountriesModel->where('id', $id)->first();

        if ($entity) 
        {
            $entity_arr = $entity->toArray();

            if($flag==false)
            {
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated country '.$entity_arr['name'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }


                /*----------------------------------------------------------------------*/
            }
            

            $this->CountriesModel->where('id', $id)->update(['is_active' => '1']);            
            return TRUE;

        }

        return FALSE;
    }

    public function perform_deactivate_country($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity = $this->CountriesModel->where('id', $id)->first();

        if($entity) 
        {
            $entity_arr = $entity->toArray();

            if($flag==false)
            {
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DEACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated country '.$entity_arr['name'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }


                /*----------------------------------------------------------------------*/  
            }
          

            $this->CountriesModel->where('id', $id)->update(['is_active' => '0']);            

            return TRUE;
        }

        return FALSE;
    }
    
    public function activate_state(Request $request)
    {
        $enc_id = $request->input('id');

        if (!$enc_id) {
            return redirect()->back();
        }

        if ($this->perform_activate_state(base64_decode($enc_id))) {
            $arr_response['status'] = 'SUCCESS';
        } else {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'ACTIVE';
        return response()->json($arr_response);
    }

    public function deactivate_state(Request $request)
    {
        $enc_id = $request->input('id');

        if (!$enc_id) {
            return redirect()->back();
        }

        if ($this->perform_deactivate_state(base64_decode($enc_id))) {
            $arr_response['status'] = 'SUCCESS';
        } else {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }

    public function perform_activate_state($id,$flag=false)
    {
        
        $user = Sentinel::check();

        $entity = $this->StatesModel->where('id', $id)->first();

        if($entity) 
        {
            $entity_arr = $entity->toArray();


            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated state '.$entity_arr['name'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }


            /*----------------------------------------------------------------------*/

            $this->StatesModel->where('id', $id)->update(['is_active' => '1']);            
            return TRUE;
        }

        return FALSE;
    }

    public function perform_deactivate_state($id,$flag=false)
    {

        $user = Sentinel::check();

        $entity = $this->StatesModel->where('id', $id)->first();

        if($entity) 
        {
            $entity_arr = $entity->toArray();


             //get sellers of this state 
            $seller_arr = [];
            $get_sellers = $this->UserModel->where('state',$id)->get()->toArray();
            if(isset($get_sellers) && !empty($get_sellers))
            {
                 $seller_arr = [];
                 foreach($get_sellers as $v)
                 {
                     $seller_arr[] = $v['id'];
                 }
                   

                if(isset($seller_arr) && !empty($seller_arr))
               { 
                    //get approved products of that categories
                    $get_approved_products = $this->ProductModel                          
                           // ->where('is_approve',1)
                            ->select('id','product_name','user_id')
                            ->whereIn('user_id',$seller_arr)
                            ->get(); 

                    if(isset($get_approved_products) && !empty($get_approved_products))
                    {
                        $get_approved_products = $get_approved_products->toArray();

                        $update_approve_status =[];

                        foreach($get_approved_products as $kk=>$vv)
                        {
                            $update_approve_status['is_approve'] = 2;
                            $update_approve_status['reason']     = "Changes to your state laws, state registeration requirements or Chow420's policies may have affected this product";

                            //disapprove products if category is restricted
                            $this->ProductModel->where('id',$vv['id'])
                                               //->where('is_approve',1)
                                               ->update($update_approve_status);


                        }// foreach get_approved_products

                    }//if isset get_approved_products
                 }//seller_arr

            }//if isset sellers






            if($flag==false)
            {
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                   //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'DEACTIVATE';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated state '.$entity_arr['name'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }


                /*----------------------------------------------------------------------*/
            }
            

            $this->StatesModel->where('id', $id)->update(['is_active' => '0']);            

            return TRUE;
        }

        return FALSE;
    }


/*    public function documents_required(Request $request)
    {
        $enc_id = $request->input('id');

        if (!$enc_id) {
            return redirect()->back();
        }

        if ($this->perform_documents_required(base64_decode($enc_id))) {
            $arr_response['status'] = 'SUCCESS';
        } else {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'REQUIRED';
        return response()->json($arr_response);
    }*/

    public function documents_not_required(Request $request)
    {
        $enc_id = $request->input('id');

        if (!$enc_id) {
            return redirect()->back();
        }

        if ($this->perform_documnets_not_required(base64_decode($enc_id))) {
            $arr_response['status'] = 'SUCCESS';
        } else {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'NOT REQUIRED';

        return response()->json($arr_response);
    }

    public function save_required_documents(Request $request)
    {
        $state_id = $request->input('state_id');
        $req_doc  = $request->input('req_doc');


        if (!$state_id || ! $req_doc) {
            return redirect()->back();
        }

        if ($this->perform_documents_required(base64_decode($state_id),$req_doc)) {
            $arr_response['status'] = 'SUCCESS';
        } else {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'REQUIRED';
        return response()->json($arr_response);
    }

    public function perform_documents_required($id,$req_doc)
    {
        $entity = $this->StatesModel->where('id', $id)->first();

        if ($entity) {
            
            $this->StatesModel->where('id', $id)->update(['is_documents_required' => '1','required_documents' => $req_doc ]);            
            return TRUE;
        }
        return FALSE;
    }

    public function perform_documnets_not_required($id)
    {
        $entity = $this->StatesModel->where('id', $id)->first();
        if ($entity) {
            
            $this->StatesModel->where('id', $id)->update(['is_documents_required' => '0']);            

            return TRUE;
        }
        return FALSE;
    }//end

     public function buyer_restricted(Request $request)
    {
         $arr_response =[];
         $id = $request->input('id');
         $user = Sentinel::check();

        $entity = $this->StatesModel->where('id', $id)->first();

        if($entity) 
        {
            $entity_arr = $entity->toArray();
            $this->StatesModel->where('id', $id)->update(['is_buyer_restricted' => '1']);
            $arr_response['status'] = 'SUCCESS';            
          //  return TRUE;
        }else
        {
             $arr_response['status'] = 'ERROR';
        }
         return response()->json($arr_response);
       // return FALSE;
    }//buyer_restricted

    public function buyer_unrestricted(Request $request)
    {
        $arr_response =[];
        $id = $request->input('id');
        $user = Sentinel::check();

        $entity = $this->StatesModel->where('id', $id)->first();

        if($entity) 
        {
            $entity_arr = $entity->toArray();

            $this->StatesModel->where('id', $id)->update(['is_buyer_restricted' => '0','text'=>NULL]);            
             $arr_response['status'] = 'SUCCESS';
             $arr_response['data'] = 'Restricted';
             //return TRUE;
        }else{
             $arr_response['status'] = 'ERROR';
             $arr_response['data'] = 'Unrestricted';
        }
         return response()->json($arr_response);
        //return FALSE;
    }//buyer_unrestricted


    public function add_restricted_text(Request $request)
    {  
        $form_data = $request->all();

        $response = [];

        $text      = $form_data['state_restricted_text'];
        $state_id  = $form_data['restricted_state_id'];

        //update text against state

        $result = $this->StatesModel->where('id',$state_id)->update(['text'=>$text]);

        if($result == 1)
        {

            //restrict buyer
              
            $entity = $this->StatesModel->where('id',$state_id)->first();

            if($entity) 
            {
                $entity_arr = $entity->toArray();

                $this->StatesModel->where('id',$state_id)->update(['is_buyer_restricted' => '1']);
              
            }else
            {
                $response['status'] = "error";
            }

            $response['status']         = "success";
            $response['description']    = "Text added successfully";       

        }
        else{
            $response['status']       = "error";
            $response['description']  = "Error occurred while adding text";

        }

        return response()->json($response);

    }

}//class
