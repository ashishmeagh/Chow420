<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Sentinel;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\UserModel;
class Shipalert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Shipalert:seller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Seller an automatic reminder every day to ship the product if the order has not been shipped';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GeneralService $GeneralService,UserModel $UserModel,EmailService $EmailService)
    {
        parent::__construct();
        $this->GeneralService     = $GeneralService;
        $this->EmailService       = $EmailService;
        $this->UserModel          = $UserModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         $get_ongoing_orders =\DB::table('order_details')->where('order_status','2')->where('buyer_age_restrictionflag',0)->get();
        if(isset($get_ongoing_orders) && !empty($get_ongoing_orders))
        {
           $get_ongoing_orders = $get_ongoing_orders->toArray(); 
           
           foreach($get_ongoing_orders as $order)
           {
               $orderid = $order->id;
                   
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
                    $arr_event['from_user_id'] = $admin_id;
                    $arr_event['to_user_id']   = $order->seller_id;
                    $arr_event['type']         = 'seller';
                    $arr_event['description']  = 'Order with having order number <b>'.$order->order_no.' </b> is pending please ship this order.';                 
                    $arr_event['title']        = 'Ship Order '.$order->order_no.' Reminder';                    
                    $this->GeneralService->save_notification($arr_event);

                    /************End*Send*Notification****************/

                   // $msg  = html_entity_decode('Order with having order number <b>'.$order->order_no.' </b> is pending please ship this order.');

                   // $subject = 'Ship Order '.$order->order_no.' Reminder';

                    $url  = url('/').'/seller/order/ongoing';

                    $arr_built_content = [
                        'USER_NAME'     => $user_name,
                        'APP_NAME'      => config('app.project.name'),
                        //'MESSAGE'       => $msg,
                        'URL'           => $url,
                        'ORDER_NO'      => $order->order_no
                    ];

                    $arr_built_subject = [                       
                        'ORDER_NO'      => $order->order_no
                    ];

                    $arr_mail_data['email_template_id'] = '115';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                    $arr_mail_data['user']              = Sentinel::findById($order->seller_id);

                    $this->EmailService->send_mail_section_order($arr_mail_data);
                    

                    /**************end send email**********************/




           }//foreach
        }//if isset

    }
}
