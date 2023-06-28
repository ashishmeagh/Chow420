<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FaqCategoryModel;
use App\Common\Services\UserService;
use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;

class FaqCategoryController extends Controller
{
    use MultiActionTrait;


    public function __construct(FaqCategoryModel $FaqCategoryModel,
                                UserService $UserService  
                               
                               ) 
    {
    	$this->BaseModel          = $FaqCategoryModel;
        $this->UserService        = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->module_title       = "Help Center Category";
        $this->module_view_folder = "admin.faq_category";
        $this->module_url_path    = $this->admin_url_path."/help_center_category";
    }


    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".str_singular($this->module_title);
        $this->arr_view_data['module_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$faq_category_table         = $this->BaseModel->getTable();
        $prefix_faq_category_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_faq_category_table = DB::table($faq_category_table)                           
        					         ->orderBy($prefix_faq_category_table.'.created_at','DESC');

        $arr_search_column = $request->input('column_filter');    

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
        {
            $search_status            = $arr_search_column['q_status'];
            $obj_faq_category_table   = $obj_faq_category_table->where('is_active','LIKE','%'.$search_status.'%');
        }


        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
        {
            $search_status            = $arr_search_column['q_status'];
            $obj_faq_category_table   = $obj_faq_category_table->where('is_active','LIKE','%'.$search_status.'%');
        }

        if(isset($arr_search_column['q_category']) && $arr_search_column['q_category'] != '')
        {
            $search_status            = $arr_search_column['q_category'];
            $obj_faq_category_table   = $obj_faq_category_table->where('faq_category','LIKE','%'.$search_status.'%');
        }

    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_faq_category_table);  

        $json_result =  $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })

                        ->editColumn('category',function($data) use ($current_context)
                        {

                           return isset($data->faq_category)?$data->faq_category:'';
                        })   
                       
                        ->editColumn('build_status_btn',function($data) use ($current_context)
                        {

                            $build_status_btn ='';


                            if($data->is_active == '0')
                            {   

                                $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                            }
                            elseif($data->is_active == 1)
                            {
                               
                                $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                            }
                            return $build_status_btn;
                        })      

                     
                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                            $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                            $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                            $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                            $confirm_delete = 'onclick="confirm_delete(this,event);"';

                            $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                            
                            
                            return $build_action = $build_edit_action.' '.$build_delete_action;
                        })

                        ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }


    public function create()
    {
    	$this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $user = Sentinel::check();

    	$form_data = $request->all();
    
        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
      
        $arr_rules = [
                       'faq_category'  => 'required'
                           
                    ];
     


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
       
    	$is_duplicate = $this->BaseModel->where('faq_category','=',$request->input('faq_category'));  
        
        
        if($is_update_process)
        { 
           
            $is_duplicate = $is_duplicate->where('id','<>',$id);
        }

        $does_exists = $is_duplicate->count(); 

        if($does_exists)
        {
            $response['status']      = "error";
            $response['description'] = "Help Center category is already exists.";
            return response()->json($response);
        } 


        
        /* Main Model Entry */
        $faq_category = $this->BaseModel->firstOrNew(['id' => $id]);

        $faq_category->faq_category  =  isset($form_data['faq_category'])?$form_data['faq_category']:'';
       
        if($request->is_active!='' && !empty($request->is_active))
        {
          $is_active  =  isset($form_data['is_active'])?$form_data['is_active']:'';  
        }
        else{

            $is_active =0;
        }


        $faq_category->is_active = $is_active;

        $faq_category->save();

        if($faq_category)
        {

            if($is_update_process == false)
            {
                $response['link'] = $this->module_url_path;
            }
            else
            {
               
                $response['link'] = $this->module_url_path;

            }

            if($is_update_process == false)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added help center category '.'"'.strip_tags($faq_category->faq_category).'"'.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                $response['status']      = "success";
                $response['description'] = "Help Center category added successfully."; 

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated help center category '.'"'.strip_tags($faq_category->faq_category).'"'.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                $response['status']      = "success";
                $response['description'] = "Help Center category updated successfully."; 
            }

          
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding help center category.";
        }

        return response()->json($response);
    }

    public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_faqs = [];
        if($obj_data)
        {
           $arr_faq_category = $obj_data->toArray(); 
        }
    
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_faq_category']   		 = isset($arr_faq_category) ? $arr_faq_category : [];  
      	$this->arr_view_data['page_title']               = "Edit ".$this->module_title;
      	$this->arr_view_data['module_title']             = str_plural($this->module_title);
  
      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

    public function multi_action(Request $request)
    {
        $user = Sentinel::check();
        $flag = "";
        /*Check Validations*/
        $input = request()->validate([
                'multi_action' => 'required',
                'checked_record' => 'required'
            ], [
                'multi_action.required' => 'Please  select record required',
                'checked_record.required' => 'Please select record required'
            ]);

        $multi_action   = $request->input('multi_action');
        $checked_record = $request->input('checked_record');


        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Flash::error('Problem occurred, while doing multi action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
                $flag = "del";     

               $this->perform_delete(base64_decode($record_id),$flag);    
               Flash::success(str_plural($this->module_title).' deleted successfully'); 
            } 
            elseif($multi_action=="activate")
            {
               $flag = "activate";

               $this->perform_activate(base64_decode($record_id),$flag); 
               Flash::success(str_singular($this->module_title).' activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $flag = "deactivate";

               $this->perform_deactivate(base64_decode($record_id),$flag);    
               Flash::success(str_singular($this->module_title).' blocked successfully');  
            }
        }

        if($multi_action=="delete")
        {
            /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
              
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'Delete';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on help center category.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

               /*----------------------------------------------------------------------*/
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on help center category.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on help center category.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

               /*----------------------------------------------------------------------*/
        } 
              

        return redirect()->back();
    }

    public function delete($enc_id = FALSE)
    {
        

        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {
            Flash::success(str_singular($this->module_title).' deleted Successfully');
        }
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }//single delete

    public function perform_delete($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity  = $this->BaseModel->where('id',$id)->first();
    
        if($entity)
        {
            $entity_arr = $entity->toArray();

            $this->BaseModel->where('id',$id)->delete();

            if($flag==false)
            {
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
              
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'Delete';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted help center category';

                    $result = $this->UserService->save_activity($arr_event); 
                }

               /*----------------------------------------------------------------------*/ 
            }

    
            Flash::success(str_plural($this->module_title).' deleted successfully');
            return true; 
        }
        else
        {
          Flash::error('Problem occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }//delete function


    public function activate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_activate(base64_decode($enc_id)))
        {
             $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'ACTIVE';
        return response()->json($arr_response);
    }

    public function deactivate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_deactivate(base64_decode($enc_id)))
        {
            $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }

    public function perform_activate($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();
        
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
                    $arr_event['action']       = 'ACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated help center category.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
            

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        }

        return FALSE;
    }//activate

 
    public function perform_deactivate($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated help center category.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
           

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

        }

        return FALSE;
    }//deactivate

}
