<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\KeywordsModel;
use App\Common\Traits\MultiActionTrait;
use App\Common\Services\UserService;

use Sentinel;
use Validator;
use Datatables;
use Flash; 
use DB; 

class KeywordsController extends Controller
{
    use MultiActionTrait;
    public function __construct(KeywordsModel $KeywordsModel,
                                UserService $UserService) 
    {
        $this->BaseModel          = $KeywordsModel;
        $this->UserService        = $UserService;
        
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->module_title       = "Health Claims";
        $this->module_view_folder = "admin.keywords";
        $this->module_url_path    = $this->admin_url_path."/health_claims";
    }

    public function index()
    {
        $keywords_table          = $this->BaseModel->getTable();

        $keywords_content_count = DB::table($keywords_table)
                                     ->count();
                                 
        $this->arr_view_data['page_title']        = "Manage ".$this->module_title;
        $this->arr_view_data['module_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        $this->arr_view_data['keywords_content_count']  = $keywords_content_count;
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
    public function get_records(Request $request)
    {
        $keywords_table          = $this->BaseModel->getTable();
        $prefixed_keywords_table = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_keywords_table = DB::table($keywords_table)                           
        							->orderBy($keywords_table.'.created_at','DESC');

       
        $current_context = $this;

        $json_result = Datatables::of($obj_keywords_table);  

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
                        'name'             => 'required'
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

        $keywords_instance                  = $this->BaseModel->firstOrNew(['id' => $id]);
        $keywords_instance->keyword_name    =  isset($form_data['name'])?$form_data['name']:'';

        if($request->is_active!='' && !empty($request->is_active))
        {
            $is_active  =  isset($form_data['is_active'])?$form_data['is_active']:'';  
        }
        else
        {
            $is_active = '0';
        }
        $keywords_instance->is_active = $is_active;
        
        $keywords_instance->save();

        if($keywords_instance)
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
    
        $arr_keyword = [];
        if($obj_data)
        {
           $arr_keyword = $obj_data->toArray(); 
        }
    
      	
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_keyword']   		     = isset($arr_keyword) ? $arr_keyword : [];  
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on health claim.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on health claim.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on health claim.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
        }

        return redirect()->back();
    }

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted the health claim '.$entity_arr['title'].'.';

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
    }

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
    public function perform_activate($id,$flag=false)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated an keyword: '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
          

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        }

        return FALSE;
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated an keyword:  '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
           

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

        }
        return FALSE;
    }
}