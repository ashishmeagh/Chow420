<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Common\Services\GeneralService;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\BuyerModel;
use App\Models\NotificationsModel;

use Validator;
use Flash;
use Sentinel;
use Hash; 
 
class NotificationController extends Controller
{

    public function __construct(
                                
                                UserModel $user,
                                BuyerModel $BuyerModel,
                                ActivityLogsModel $activity_logs,
                                GeneralService $GeneralService,
                                NotificationsModel $NotificationsModel
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;
        $this->ActivityLogsModel  = $activity_logs;
        $this->BuyerModel         = $BuyerModel;
        $this->NotificationsModel = $NotificationsModel;
        $this->GeneralService     = $GeneralService;
        
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        $this->profile_img_public_path = url('/').config('app.project.img_path.user_profile_image');
        $this->profile_img_base_path   = base_path().config('app.project.img_path.user_profile_image');

        $this->module_title       = "Notifications";
        $this->module_view_folder = "buyer/notifications";

        $this->id_proof_public_path = url('/').config('app.project.id_proof');
        $this->id_proof_base_path   = base_path().config('app.project.id_proof');
        
        $this->module_icon        = "fa-cogs";
    }


    public function index(Request $request)
    {
        $buyer_arr = $notification_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();


        if($user_details->inRole('buyer'))
        {       
            /*Update notification as is_read = 1 for buyer (START)*/
              
                $update_read_status = $this->NotificationsModel
                                            ->where('to_user_id',$user_details->id)
                                            ->update(['is_read'=>'1']);
            
            /*Update notification as is_read = 1 for buyer (END)*/

            $notification_obj   =   $this->NotificationsModel
                                         ->where('to_user_id',$user_details->id)
                                         ->orderBy('created_at','desc')
                                         ->get();
            if($notification_obj)
            {
                $notification_arr = $notification_obj->toArray(); 
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
            
                $arr_user_pagination            = $paginator;  
                $notification_arr               = $paginator->items();
                $arr_data                       = $notification_arr;
                $arr_view_data['arr_data']      = $arr_data;
                $arr_view_data['total_results'] = $total_results;
                $arr_pagination                 = $paginator;

                $this->arr_view_data['arr_pagination'] = $arr_pagination;
                $this->arr_view_data['total_results']  = $total_results;
            }

            $this->arr_view_data['notification_arr']     = $notification_arr;
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

}
