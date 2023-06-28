<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NotificationsModel;
use App\Models\UserModel;
use App\Common\Services\UserService;
use DB;
use Datatables;
use Sentinel;
use Flash;

class NotificationController extends Controller
{
    public function __construct(NotificationsModel $NotificationsModel,
                                UserModel $UserModel,
                                UserService $UserService
                               )
    {
    	$this->NotificationsModel = $NotificationsModel;
    	$this->UserModel          = $UserModel;
        $this->UserService        = $UserService;
    	$this->module_view_folder = 'admin/notification';
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/notification");
    	$this->module_title       = "Notifications";
    	$this->arr_view_data      = [];
    }

    public function index()
    {	
    	$this->arr_view_data['module_url_path'] = $this->module_url_path;
    	$this->arr_view_data['module_title'] = $this->module_title;
        $this->arr_view_data['page_title']   = "Manage ".$this->module_title;

    	$user = Sentinel::getUser();

    	if ($user->inRole('admin') || $user->inRole('sub_admin'))
        {	
        	$user_id = $user->id;
            //$update_read_status = $this->NotificationsModel->where('to_user_id',$user_id)
    		$update_read_status = $this->NotificationsModel->where('to_user_id',1)
    													   ->update(['is_read'=>'1']);
    	}
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_all_notification(Request $request)
    {
    	$user = Sentinel::getUser();

    	if($user->inRole('admin') || $user->inRole('sub_admin'))
        {	
        	$user_id = $user->id;

			$notification_table           = $this->NotificationsModel->getTable();

	        $prefixed_notification_table  = DB::getTablePrefix().$this->NotificationsModel->getTable();
	       
	        $user_table           = $this->UserModel->getTable();
	        $prefixed_user_table  = DB::getTablePrefix().$this->UserModel->getTable();
	      
	        $obj_notification = DB::table($notification_table)
	                                ->select(DB::raw($prefixed_notification_table.".*,".
                                        
	                                				 "CONCAT(".$prefixed_user_table.".first_name,' ',"
			                                          .$prefixed_user_table.".last_name) as user_name"
	                                                 ))
	                                ->leftjoin($prefixed_user_table,$prefixed_user_table.'.id' ,'=', $prefixed_notification_table.'.from_user_id')
	                                ->orderBy($prefixed_notification_table.'.created_at','DESC')
	                              //  ->where($prefixed_notification_table.'.to_user_id',$user_id);
	                               ->where($prefixed_notification_table.'.to_user_id',1);

	        /* ---------------- Filtering Logic ----------------------------------*/                    

	        $arr_search_column = $request->input('column_filter');


	       if(isset($arr_search_column['q_user_name']) && $arr_search_column['q_user_name']!="")
	        {
	            $search_term  = $arr_search_column['q_user_name'];
	            // $obj_notification  = $obj_notification->having('first_name','LIKE', '%'.$search_term.'%');
                $obj_notification  = $obj_notification->where($prefixed_user_table.'.first_name','LIKE', '%'.$search_term.'%')->orWhere('last_name', 'LIKE', '%'.$search_term.'%');

	        }


	        $json_result     = Datatables::of($obj_notification);
	        $current_context = $this;
	   		
	   		 /* Modifying Columns */
	        $json_result =  $json_result->editColumn('user_name',function($data) use ($current_context)
	                      {
                            if(strlen($data->user_name)>1){
                               return $data->user_name;
                            }
                            else{
                               return 'NA';
                            }
                                
	                        // return $user_name = isset($data->user_name) ? $data->user_name : 'NA';
	                         
	                      })

	                     ->editColumn('message',function($data) use($current_context)
	                      {
	                         return $message = isset($data->message) ? $data->message : 'NA';
	                      })


	                      ->editColumn('build_action_btn',function($data) use ($current_context)
	                        {   

                                $confirm_delete = 'onclick="confirm_delete(this,event);"';

	                            $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);

	                            $build_edit_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';

	                            return $build_action = $build_edit_action;
	                        })
	                      ->make(true);

	                      $build_result = $json_result->getData();
	        
	        			  return response()->json($build_result);	
        }
    }

    public function delete_notification($enc_notification_id)
    {
        $user = Sentinel::check();

    	$notification_id = isset($enc_notification_id)?base64_decode($enc_notification_id):false;

    	if($enc_notification_id)
    	{
    		$delete_notification = $this->NotificationsModel->where('id',$notification_id)->delete();
    		
    		if($delete_notification)
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted notification.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }


                /*----------------------------------------------------------------------*/

    			Flash::success(str_singular($this->module_title).' deleted successfully!');
    		}
    		else
    		{
    			Flash::error('Problem Occurred, While Deleting '.str_singular($this->module_title));	
    		}
       		return redirect()->back();
    	}
    }
}
