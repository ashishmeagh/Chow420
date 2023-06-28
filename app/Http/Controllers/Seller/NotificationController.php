<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Common\Services\GeneralService;
use App\Models\SellerModel;
use App\Models\NotificationsModel;


use Sentinel;

 
class NotificationController extends Controller
{

    public function __construct(
                                SellerModel $SellerModel,
                                GeneralService $GeneralService,
                                NotificationsModel $NotificationsModel
                               )
    {
 
        $this->SellerModel           = $SellerModel;
        $this->NotificationsModel    = $NotificationsModel;
        $this->GeneralService        = $GeneralService;
        
        $this->arr_view_data      = [];


        $this->module_title       = "Notifications";
        $this->module_view_folder = "seller/notifications";
    }


    public function index(Request $request)
    {
        $user = Sentinel::check();

        $loggedIn_Id = 0;
        $notification_arr = [];
        if ($user) {

            $loggedIn_Id = $user->id;
        }

        /*Update notification as is_read = 1 for seller (START)*/
            if($user->inRole('seller'))
            {   
                $update_read_status = $this->NotificationsModel
                                            ->where('to_user_id',$loggedIn_Id)
                                            ->update(['is_read'=>'1']);
            }

        /*Update notification as is_read = 1 for seller (END)*/

        $obj_notification = $this->NotificationsModel
                                 ->where('to_user_id',$loggedIn_Id)
                                 ->orderBy('created_at','desc')
                                 ->get();

        if ($obj_notification) {

            $notification_arr = $obj_notification->toArray();
            
        }

        if($request->has('page'))
        {   
            $pageStart = $request->input('page'); 
        }
        else
        {
            $pageStart = 1; 
        }
        
        $apppend_data = url()->current();
        $total_results = count($notification_arr);


        $paginator = $this->GeneralService->get_pagination_data($notification_arr, $pageStart, 9 , $apppend_data);


        if($paginator)
        {
            $pagination_links    =  $paginator;  
            $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 
        }   

        if($paginator)
        {
        
            $arr_user_pagination   =  $paginator;  
            $notification_arr       =  $paginator->items();
            $arr_data               = $notification_arr;
            $arr_view_data['arr_data']=  $arr_data;
            $arr_view_data['total_results'] = $total_results;
            $arr_pagination = $paginator;

            $this->arr_view_data['arr_pagination'] = $arr_pagination;
            $this->arr_view_data['total_results'] = $total_results;
            $this->arr_view_data['page_title'] = $this->module_title;


            $this->arr_view_data['notification_arr']     = $arr_data;
            $this->arr_view_data['page_title']           = 'Notifications';
        
            return view($this->module_view_folder.'.index',$this->arr_view_data);
            
        }

        
    }


    
    public function DeleteNotification(Request $request)
   {
      $data      = [];
      $user_id   = 0;
      $form_data = $request->all();


      $user = Sentinel::check();
      if(isset($user))
      {
        $user_id = $user->id;
      }

      $id     = base64_decode($form_data['id']);

      $result = $this->NotificationsModel->where('to_user_id',$user_id)->where('id',$id)->delete();


      if($result)
      {  
         
            $response['status']      = 'SUCCESS';
            $response['description'] = 'Notification deleted successfully'; 
         
            return response()->json($response);
      }
  
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
                Flash::error('Problem occurred while deleting '.str_singular($this->module_title));    
            }
            return redirect()->back();
        }
    }

}
