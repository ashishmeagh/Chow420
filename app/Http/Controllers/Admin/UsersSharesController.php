<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\UsersSharesModel;
use App\Models\EventModel;


use App\Common\Traits\MultiActionTrait;
use App\Common\Services\UserService;


use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;
use Excel;

class UsersSharesController extends Controller
{       
    use MultiActionTrait;

    public function __construct(
                                UsersSharesModel $UsersSharesModel,
                                EventModel $EventModel,
                                UserService $UserService

                               ) 
    {
    	$this->BaseModel          = $UsersSharesModel;
        $this->EventModel         = $EventModel;
        $this->UserService        = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->module_title       = "Investor Tracker";
        $this->module_view_folder = "admin.users_shares";
        $this->module_url_path    = $this->admin_url_path."/investortracker";
    } 
 

    public function index()
    {
        $users_shares_table          = $this->BaseModel->getTable();

        $this->arr_view_data['page_title']        = "Manage ".$this->module_title;
        $this->arr_view_data['module_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_users_share_details(Request $request)
    {
        $users_shares_table          = $this->BaseModel->getTable();
        $prefixed_users_shares_table = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_users_shares_table = DB::table($users_shares_table)
                                    ->select(
                                        DB::raw(
                                            $prefixed_users_shares_table.".id,".
                                            $prefixed_users_shares_table.".email, ".
                                            "CONCAT(".$prefixed_users_shares_table.".first_name,' ', ".$prefixed_users_shares_table.".last_name) as full_name, ".
                                            $prefixed_users_shares_table.".shares_owned, ".
                                            $prefixed_users_shares_table.".price_per_share, ".
                                            $prefixed_users_shares_table.".percent_change, ".
                                            $prefixed_users_shares_table.".share_value, ".
                                            $prefixed_users_shares_table.".description, ".
                                            $prefixed_users_shares_table.".created_at, ".
                                            $prefixed_users_shares_table.".updated_at, ".
                                            $prefixed_users_shares_table.".is_active"
                                        )
                                    )                           
                                    ->orderBy($users_shares_table.'.created_at','DESC');


        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_full_name']) && $arr_search_column['q_full_name']!="")
        {
            $search_term      = $arr_search_column['q_full_name'];
            $obj_users_shares_table = $obj_users_shares_table->having('full_name','LIKE', '%'.$search_term.'%');
            // $obj_users_shares_table = $obj_users_shares_table->having($users_shares_table.'.last_name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_term      = $arr_search_column['q_email'];
            $obj_users_shares_table = $obj_users_shares_table->where($users_shares_table.'.email','LIKE', '%'.$search_term.'%');
        }

        return $obj_users_shares_table;

    }

    public function get_records(Request $request)
    {
        $obj_users_shares_table     = $this->get_users_share_details($request);

        $current_context = $this;

        $json_result = Datatables::of($obj_users_shares_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
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
                            
                            
                            return $build_action = $build_edit_action." ".$build_delete_action;
                        })

                        ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }


    public function create()
    {
    	$this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = "Manage ".str_singular($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$form_data = $request->all();

        $user = Sentinel::check();

        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
        if($is_update_process == false)
        {
        	$arr_rules = [
                            'first_name'        => 'required',
                            'last_name'         => 'required',
                            'email'             => 'required',
                            'shares_owned'      => 'required',
                            'price_per_share'   => 'required',
                            'percent_change'    => 'required',
                            'share_value'       => 'required',
                            'description'       => 'required'
                         ];
        }

        $validator = Validator::make($request->all(),$arr_rules);

        // dd($validator);
        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
       
    	if($is_update_process == false)
        {
            $check_email_exists = $this->BaseModel->where(['email' => $form_data['email']])->first();

            if($check_email_exists !== null)
            {
                $response['status']      = 'warning';
                $response['description'] = 'The user with email <b>'.$form_data['email'].'</b> already exists';

                return response()->json($response);
            }
        }
        
        /* Main Model Entry */
        $users_shares_instance = $this->BaseModel->firstOrNew(['id' => $id]);

        
        $users_shares_instance->first_name          =  isset($form_data['first_name'])?$form_data['first_name']:'';
        $users_shares_instance->last_name           =  isset($form_data['last_name'])?$form_data['last_name']:'';
        $users_shares_instance->email               =  isset($form_data['email'])?$form_data['email']:'';
        $users_shares_instance->shares_owned        =  isset($form_data['shares_owned'])?$form_data['shares_owned']:'';
        $users_shares_instance->price_per_share     =  isset($form_data['price_per_share'])?$form_data['price_per_share']:'';
        $users_shares_instance->percent_change      =  isset($form_data['percent_change'])?$form_data['percent_change']:'';
        $users_shares_instance->share_value         =  isset($form_data['share_value'])?$form_data['share_value']:'';
        $users_shares_instance->description         =  isset($form_data['description'])?$form_data['description']:'';
        

        if($request->is_active!='' && !empty($request->is_active)){
            $is_active  =  isset($form_data['is_active'])?$form_data['is_active']:'';  
        }else{
            $is_active = '0';
        }
        $users_shares_instance->is_active           =  $is_active;


      
        $users_shares_instance->save();

        if($users_shares_instance)
        {

            
            if($is_update_process == false)
            {                
                $response['link'] = $this->module_url_path;
            }
            else
            {
                $response['link'] = $this->module_url_path.'/edit/'.base64_encode($id);
            }

            if($is_update_process == false)
            {
                $response['status']      = "success";
                $response['description'] = "Record added successfully."; 

            }
            else
            {     
                $response['status']      = "success";
                $response['description'] = "Record updated successfully.";

            }

          
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding trending on chow.";
        }

        return response()->json($response);
    }

    public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_users_shares = [];
        if($obj_data)
        {
           $arr_users_shares = $obj_data->toArray(); 
        }
    
      	
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_users_shares']   		 = isset($arr_users_shares) ? $arr_users_shares : [];  
      	$this->arr_view_data['page_title']               = "Edit ".str_singular($this->module_title);
      	$this->arr_view_data['module_title']             = "Manage ".str_singular($this->module_title);
  
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
                // Flash::success(str_plural($this->module_title).' Deleted Successfully'); 
                Flash::success('Record deleted successfully'); 

            } 
            elseif($multi_action=="activate")
            {  
                $flag = "activate";
                 
                $this->perform_activate(base64_decode($record_id),$flag); 
                //Flash::success(str_plural($this->module_title).' Activated Successfully'); 
                Flash::success('Record activated successfully'); 

            }
            elseif($multi_action=="deactivate")
            {
                $flag = "deactivate";

                $this->perform_deactivate(base64_decode($record_id),$flag);    
                //Flash::success(str_plural($this->module_title).' Blocked Successfully');  
                Flash::success(' Record deactivated successfully');  

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on users shares.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on users shares.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on users shares.';

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
          
           // Flash::success(str_singular($this->module_title).' Deleted Successfully');
             Flash::success(' Record deleted successfully');

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted the users shares of '.$entity_arr['first_name'].' '.$entity_arr['last_name'];

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
           

            //Flash::success(str_plural($this->module_title).' Deleted Successfully');
            Flash::success('Record deleted successfully');

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

    public function perform_activate($id,$flag = false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();
        
        if($entity)
        {
            $entity_arr = $entity->toArray();

            if($flag == false)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated the users shares of '.$entity_arr['first_name'].' '.$entity_arr['last_name'];

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated the users shares of '.$entity_arr['first_name'].' '.$entity_arr['last_name'];

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
           

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

        }
        return FALSE;
    }//deactivate


    public function export_excel(Request $request)
    {
        $header =['user_email','first_name','last_name','shares_owned','price_per_share','percent_change','share_value','description'];

        $filename   = 'Investor tracker excel template';
        \Excel::create($filename, function ($excel) use($header) {
            $excel->sheet('Users Shares', function ($sheet) use($header) {
                require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
                require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");
                
                $data = $header;
                $sheet->fromArray(array($data), null, 'A1', false, false);
                $sheet->cells('A1:H1', function($cells) {
                    $cells->setBorder('thick', 'thick', 'thick', 'thick');
                    $cells->setAlignment('left');
                    $cells->setFontWeight('bold');
                });
                $sheet->setWidth(array(
                    'A'     =>  20,
                    'B'     =>  20,
                    'C'     =>  20,
                    'D'     =>  20,
                    'E'     =>  20,
                    'F'     =>  20,
                    'G'     =>  20,
                    'H'     =>  30
                ));
            });
        })->download('xlsx');
    }


    public function bulk_upload(Request $request)
    {
        $insert_data = $response = [];
        $form_data = $request->all();

        $request->validate([
            'users_shares_excel_file' => 'required'
        ]);

        $extension_array = ['xlsx'];

        if($request->hasFile('users_shares_excel_file'))
        {           
            $path = $request->file('users_shares_excel_file')->getRealPath(); 
            $extenstion = $request->file('users_shares_excel_file')->getClientOriginalExtension();
            if(!in_array($extenstion,$extension_array)){

               $response['status'] = "warning";        
               $response['description'] ='Please select valid file,Allowed only xlsx file type'; 

            }else
            {
                $data = Excel::selectSheetsByIndex(0)->load($path)->get();
                if(!empty($data) && $data->count())
                {
                    $erromsg = [];
                    foreach ($data as $key => $value)
                    {
                        // dump($value);
                        $individual_data['email']              = isset($value->user_email)? $value->user_email : ''; 
                        $individual_data['first_name']         = isset($value->first_name)? $value->first_name : ''; 
                        $individual_data['last_name']          = isset($value->last_name)? $value->last_name : ''; 
                        $individual_data['shares_owned']       = isset($value->shares_owned)? $value->shares_owned : ''; 
                        $individual_data['price_per_share']    = isset($value->price_per_share)? $value->price_per_share : ''; 
                        $individual_data['percent_change']     = isset($value->percent_change)? $value->percent_change : ''; 
                        $individual_data['share_value']        = isset($value->share_value)? $value->share_value : ''; 
                        $individual_data['description']        = isset($value->description)? $value->description : '';

                        $check_email_exists = $this->BaseModel->where(['email' => $individual_data['email']])->first();

                        if($check_email_exists == null)
                        {
                            array_push($insert_data,$individual_data);                           
                        } 

                    }
                    $insert_shares = $this->BaseModel->insert($insert_data);
                    
                    // dd($insert_shares);
                    if($insert_shares)
                    {
                        $response['status'] = "success";   
                        $response['description'] = "Inventor tracker import completed successfully ";
                    }
                    else
                    {
                        $response['status'] = "warning";        
                        $response['description'] ='Something went wrong in bulk import';     
                    }
                }
                else
                {
                    $response['status'] = "warning";        
                    $response['description'] ='Something went wrong in bulk import';  
                }
            }
        }
        return response()->json($response);
        
    }//bulk_upload

}
