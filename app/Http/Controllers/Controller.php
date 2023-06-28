<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Events\ActivityLogEvent;
use App\Events\NotificationEvent;
use App\Common\Services\EmailService;
use Session;
use App;
use Sentinel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct(EmailService $EmailService)
    {
        $this->EmailService = $EmailService;
    }

    /*---------------------------------------------------------
    |Activity Log
    ---------------------------------------------------------*/
    public function save_activity($ARR_DATA = [])
    {  
        
        if(isset($ARR_DATA) && sizeof($ARR_DATA)>0)
        {
            if(\Request::segment(2)!='')
            {
                $ARR_EVENT_DATA                 = [];
                $ARR_EVENT_DATA['module_title'] = $ARR_DATA['MODULE_TITLE'];
                $ARR_EVENT_DATA['module_action']= $ARR_DATA['ACTION'];
                event(new ActivityLogEvent($ARR_EVENT_DATA));

                return true;
            }
            return false;    
        }
        return false;
    }
    /*-------------------------------------------------------*/


    /************************Notification Event START**************************/

    public function save_notification($ARR_DATA = [])
    {   
        if(isset($ARR_DATA) && sizeof($ARR_DATA)>0)
        {
            $ARR_EVENT_DATA                 = [];
            $ARR_EVENT_DATA['from_user_id'] = $ARR_DATA['from_user_id'];
            $ARR_EVENT_DATA['to_user_id']   = $ARR_DATA['to_user_id'];
            $ARR_EVENT_DATA['message']      = $ARR_DATA['message'];
            $ARR_EVENT_DATA['url']          = $ARR_DATA['url'];
            event(new NotificationEvent($ARR_EVENT_DATA));

            $to_user = Sentinel::findById($ARR_DATA['to_user_id']);

            $arr_built_content = ['USER_NAME'     => $to_user->user_name,
                                  'APP_NAME'      => config('app.project.name'),
                                  'MESSAGE'       => $ARR_DATA['message'],
                                  'URL'           => $ARR_DATA['url']
                                 ];

            $arr_mail_data['email_template_id'] = '31';
            $arr_mail_data['arr_built_content'] = $arr_built_content;
            $arr_mail_data['arr_built_subject'] = isset($ARR_DATA['subject'])?$ARR_DATA['subject']:'';
            $arr_mail_data['user']              = Sentinel::findById($ARR_DATA['to_user_id']);

            $this->EmailService->send_notification_mail($arr_mail_data);

            return true;
        }
        return false;
    }

    /************************Notification Event END  **************************/

}
