<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Sentinel;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\UserModel;
use App\Models\EmailTemplateModel;
use Mail;


class Ordershipalert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Ordershipalert:seller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alert to admin if order not ship within 7 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GeneralService $GeneralService,UserModel $UserModel,EmailService $EmailService,EmailTemplateModel $EmailTemplateModel)
    {
        parent::__construct();
        $this->GeneralService     = $GeneralService;
        $this->EmailService       = $EmailService;
        $this->UserModel          = $UserModel;
        $this->EmailTemplateModel = $EmailTemplateModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $get_ongoing_orders =\DB::table('order_details')->where('order_status','2')->get();
        if(isset($get_ongoing_orders) && !empty($get_ongoing_orders))
        {
           $get_ongoing_orders = $get_ongoing_orders->toArray(); 
           foreach($get_ongoing_orders as $order)
           {
               $orderid = $order->id;
               $created_at = date($order->created_at);
               $orderdate =  date ( 'Y-m-d' , strtotime ( $created_at . ' + 7 days' ));
               $current_date = date('Y-m-d');     

               if($current_date>$orderdate)
               {    
                   
                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }
                    
                    $user_name='';

                    $getsellername = $this->UserModel->with('seller_detail')
                                        ->where('id',$order->seller_id)
                                        ->first();
                    if(isset($getsellername) && !empty($getsellername))
                    {
                        $getsellername = $getsellername->toArray();
                        if($getsellername['first_name']=="" || $getsellername['last_name']=="")
                        {
                            $user_name = $getsellername['email'];
                        }
                        else
                        {
                            $user_name = $getsellername['first_name'].' '.$getsellername['last_name'];
                        }                      
                    }

                    /*********Send Notification*to*Admin***************/

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $order->seller_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['type']         = 'admin';
                    $arr_event['description']  = 'Seller <b>'.$user_name.'</b></a> has not ship the order <b>'.$order->order_no.'</b>.';                 
                    $arr_event['title']        = 'Seller Order '.$order->order_no.' Shipping Remaining';                    
                    $this->GeneralService->save_notification($arr_event);

                    /************End*Send*Notification****************/

                    //$msg  = html_entity_decode('Seller <b>'.$user_name.'</b></a> has not ship the order <b>'.$order->order_no.'</b>.');

                   // $subject = 'Seller Order '.$order->order_no.' Shipping Remaining';


                    $obj_email_template = $this->EmailTemplateModel->where('id','114')->first();

                   /* if($obj_email_template)
                    {
                        $arr_email_template = $obj_email_template->toArray();
                        $content = $arr_email_template['template_html'];
                        $subject = $arr_email_template['template_subject'];
                        $subject = str_replace('##ORDER_NO##', $order->order_no, $subject);

                        $content = str_replace("##SELLER_NAME##",$user_name,$content);
                        $content = str_replace("##ORDER_NO##",$order->order_no,$content);
                        $content = str_replace("##USER_NAME##",config('app.project.admin_name'),$content);


                        $content = view('email.front_general',compact('content'))->render();
                        $content = html_entity_decode($content);

                       $to_mail_id = Sentinel::findById($admin_id);
                       $to_mail_id = $to_mail_id['email'];


                        $send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$arr_email_template,$subject)
                        {
                                                       
                            if(isset($arr_email_template) && count($arr_email_template) > 0)
                            {       
                                $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                $message->to($to_mail_id);
                                $message->subject($subject);
                            }
                            $message->setBody($content, 'text/html');
                           
                        });


                    }//if templated id
                    */

                    $url  = url('/').'/'.config('app.project.admin_panel_slug').'/order';

                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $url,
                        'SELLER_NAME'   => $user_name,
                        'ORDER_NO'      => $order->order_no
                    ];

                     $arr_built_subject = [                       
                        'ORDER_NO'      => $order->order_no
                    ];

                    $arr_mail_data['email_template_id'] = '114';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);
                    $this->EmailService->send_mail_section_order($arr_mail_data);

                    /**************end send email**********************/



               }//if currentdate is greater

           }//foreach
        }//if isset

    }//handle
}
