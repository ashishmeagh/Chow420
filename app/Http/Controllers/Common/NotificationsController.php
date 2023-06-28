<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\NotificationsModel;
use Sentinel;
use DB;
use Flash;

class NotificationsController extends Controller
{
    //Author : Sagar B. Jadhav
    //Date   : 21 March 2019

    public function __construct(UserModel $UserModel,
    							NotificationsModel $NotificationsModel)
    {	

    	$this->UserModel 			   = $UserModel;
    	$this->NotificationsModel      = $NotificationsModel;
        $this->profile_img_public_path = url('/').config('app.project.img_path.user_profile_image');
        $this->arr_view_data           = [];
        $this->module_title            = 'Notification';

    }

   /* public function get_notifications(Request $request)
    {

    	$loggedIn_usder_id = 0;
    	if(Sentinel::check())
    	{
	    	$loggedIn_usder_id  = Sentinel::check()->id;
    	}

    	$last_retrieved_id = $request->last_retrieved_id;
    	// dd($last_retrieved_id);
    	$notifications_arr = $this->NotificationsModel->with(['sender_details'])
    												  ->where('is_read','0')
    												  ->where('to_user_id',$loggedIn_usder_id);

    	if(isset($last_retrieved_id) && $last_retrieved_id!='')
    	{  
            $last_retrieved_id = $last_retrieved_id+1;
    		$notifications_arr = $notifications_arr->where('id','>',$last_retrieved_id);
    	}

    	$notifications_arr = $notifications_arr->orderBy('id','DESC')->get()->toArray();
    												  
    	if(count($notifications_arr)>0)
    	{
    		$response['status'] 		 	      = 'SUCCESS';
            $response['notifications_arr']        = $notifications_arr;
    		$response['profile_img_path']         = $this->profile_img_public_path;
            $response['default_profile']          = url('/').'/assets/images/Profile-img-new.jpg';
    	}
    	else
    	{
    		$response['status'] 			= 'FAILURE';	
    		$response['notifications_arr']  = [];
    	}

    	return response()->json($response);
    }*/


    public function get_notifications(Request $request)
    {
        $loggedIn_user_id = 0;
        if(Sentinel::check())
        {
            $loggedIn_user_id  = Sentinel::check()->id;
        }
        
        $loguser = Sentinel::check();
        if(($loguser->inRole('admin')) || ($loguser->inRole('sub_admin')))
        {
               $notifications_arr_cnt = $this->NotificationsModel->where('is_read','0')
                                                          ->where('to_user_id',1)
                                                          ->count();
        }
        else{
               $notifications_arr_cnt = $this->NotificationsModel->where('is_read','0')
                                                          ->where('to_user_id',$loggedIn_user_id)
                                                          ->count();
        }


        // $notifications_arr_cnt = $this->NotificationsModel->where('is_read','0')
        //                                                   ->where('to_user_id',$loggedIn_user_id)
        //                                                   ->count();
                                                      
        if($notifications_arr_cnt > 0)
        {
            $response['status']                 = 'SUCCESS';
            $response['notifications_arr_cnt']  = $notifications_arr_cnt;
        }
        else
        {
            $response['status']                 = 'FAILURE';    
            $response['notifications_arr_cnt']  = [];
        }

        return response()->json($response);
    }


    public function get_all_notifications()
    {
        $loggedIn_usder_id = 0;

        if(Sentinel::check())
        {
            $loggedIn_usder_id  = Sentinel::check()->id;
        }    
        
        $notification_table           = $this->NotificationsModel->getTable();

        $prefixed_notification_table  = DB::getTablePrefix().$this->NotificationsModel->getTable();
       
        $user_table           = $this->UserModel->getTable();
        $prefixed_user_table  = DB::getTablePrefix().$this->UserModel->getTable();
      
        $obj_notification = DB::table($notification_table)
                                ->select(DB::raw($prefixed_notification_table.".*,".
                                                 $prefixed_user_table.'.user_name'))
                                                 // "CONCAT(".$prefixed_user_table.".first_name,' ',"
                                                 //  .$prefixed_user_table.".last_name) as user_name"
                                                 // ))
                                ->leftjoin($prefixed_user_table,$prefixed_user_table.'.id' ,'=', $prefixed_notification_table.'.from_user_id')
                                ->orderBy($prefixed_notification_table.'.created_at','DESC')
                                ->where($prefixed_notification_table.'.to_user_id',$loggedIn_usder_id)
                                ->paginate(10);
    
        if($obj_notification)                               
        {
             $obj_notification =$obj_notification->withPath('?page=');

             $update_read_status = $this->NotificationsModel->where('to_user_id',$loggedIn_usder_id)
                                                            ->update(['is_read'=>'1']);
        }

        $this->arr_view_data['arr_notification'] = $obj_notification;  
        $this->arr_view_data['module_url_path']  = url('notifications');  

        return view('front.notification',$this->arr_view_data);
    }

    public function delete_notification($enc_notification_id)
    {
        $notification_id = isset($enc_notification_id)?base64_decode($enc_notification_id):false;
     
        if($enc_notification_id)
        {
            $delete_notification = $this->NotificationsModel->where('id',$notification_id)->delete();
            
            if($delete_notification)
            {
                Flash::success(str_singular($this->module_title).' Deleted Successfully');
            }
            else
            {
                Flash::error('Problem Occurred, While Deleting '.str_singular($this->module_title));    
            }
            return redirect()->back();
        }
    }

    public function read_notification(Request $request)
    {
        $notification_id = $request->input('notification_id');
        
        if($notification_id)                               
        {
             $obj_notification = $this->NotificationsModel->where('id',$notification_id)->first();
             
             if($obj_notification)
             {
                $update_read_status = $this->NotificationsModel->where('id',$notification_id)
                                                               ->update(['is_read'=>'1']);
                
                return $response = ['status'=>'success'];                                                               
             }
            
        }
        return $response = ['status'=>'error'];
    }
}
