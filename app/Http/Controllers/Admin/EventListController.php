<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

use App\Models\EventModel;
use App\Models\BuyerModel;
use App\Models\UserModel;
use App\Common\Services\UserService;

use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;
 
class EventListController extends Controller
{       
    use MultiActionTrait;

    public function __construct(EventModel $EventModel,
                                BuyerModel $BuyerModel,
                                UserModel $UserModel,
                                UserService $UserService
                                ) 
    {
    	$this->BaseModel          = $EventModel;
        $this->BuyerModel         = $BuyerModel;
        $this->UserModel          = $UserModel;
        $this->UserService        = $UserService;
  
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));


        $this->module_title       = "Events";
        $this->module_view_folder = "admin.eventlist";
        $this->module_url_path    = $this->admin_url_path."/event_list";
    }


    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title);

        $this->arr_view_data['module_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$event_table          = $this->BaseModel->getTable();
        $prefixed_event_table  = DB::getTablePrefix().$this->BaseModel->getTable();


        $obj_event_table = DB::table($prefixed_event_table)   


                                        ->select(DB::raw($prefixed_event_table.".id as id,".
                                            $prefixed_event_table.".message as message,".
                                            $prefixed_event_table.".status as status,".

                                            $prefixed_event_table.".created_at as created_at"
                                          ))
        							 ->orderBy($prefixed_event_table.'.id','DESC');

        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');    
  
           if(isset($arr_search_column['q_message']) && $arr_search_column['q_message'] != '')
            {

                $search_message_term       = $arr_search_column['q_message'];
                
                $obj_event_table  = $obj_event_table->where($prefixed_event_table.'.message','LIKE', '%'.$search_message_term.'%');
            }
              if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
            {
                $search_status_term       = $arr_search_column['q_status'];
                
                $obj_event_table  = $obj_event_table->where($prefixed_event_table.'.status','LIKE', '%'.$search_status_term.'%');
            }

            if(isset($arr_search_column['q_createdat']) && $arr_search_column['q_createdat'] != '')
            {
                $search_createdat_term       = date("Y-m-d",strtotime($arr_search_column['q_createdat']));
                
                $obj_event_table  = $obj_event_table->where($prefixed_event_table.'.created_at','LIKE', '%'.$search_createdat_term.'%');
            }

            
          	
           
 

    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_event_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })
                        ->editColumn('message',function($data) use ($current_context)
                        {
                           return $data->message;

                        })
                        ->editColumn('created_at',function($data) use ($current_context)
                        {
                           return date('d M Y H:i',strtotime($data->created_at));

                        })                       
                        ->editColumn('build_status_btn',function($data) use ($current_context)
                            {

                                $build_status_btn ='';


                                if($data->status == 0)
                                {   
                                  
                                    $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->status == 1)
                                {
                                   
                                    $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_status_btn;
                            })      

                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                           
                            $build_delete_action ='';


                            $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                            $confirm_delete = 'onclick="confirm_delete(this,event);"';
                            $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';

                            return $build_action = $build_delete_action;
                        })
                        ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
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
                Flash::success(str_plural($this->module_title).' activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            { 
                $flag = "deactivate";

                $this->perform_deactivate(base64_decode($record_id),$flag);    
                Flash::success(str_plural($this->module_title).' blocked successfully');  
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on events.';

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on events.';

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on events.';

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

        $entity = $this->BaseModel->where('id',$id)->first();
    
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted events '.$entity_arr['title'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }


                /*----------------------------------------------------------------------*/ 
            } 
            


            Flash::success(str_singular($this->module_title).' deleted successfully');
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
            $arr_response['msg']   = 'Sorry, you can not deactivate this event';
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated events '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
       
            return $this->BaseModel->where('id',$id)->update(['status'=>1]);
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
                    /*------ -------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'DEACTIVATE';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated events '.$entity_arr['title'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                    /*----------------------------------------------------------------------*/
                 } 

                return $this->BaseModel->where('id',$id)->update(['status'=>0]);
                        
            }

            return FALSE;
     
    } //deactivate

}
