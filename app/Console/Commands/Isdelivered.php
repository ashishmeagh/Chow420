<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Sentinel;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\UserModel;


class Isdelivered extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Isdelivered:seller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alert to seller if seller enters invalid shipping company while shipping order.';

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
        
        $get_ongoing_orders =\DB::table('order_details')->where('order_status','3')->get();
        if(isset($get_ongoing_orders) && !empty($get_ongoing_orders))
        {
           $get_ongoing_orders = $get_ongoing_orders->toArray(); 

          
           $tracking_number    = $shipping_company_name = ""; 
           $arr_valid_shipping_companies = [];


           foreach($get_ongoing_orders as $order)
           {
               $orderid                = $order->id;
               $tracking_number        =  $order->tracking_no;
               $shipping_company_name  =  $order->shipping_company_name;
               $arr_valid_shipping_companies = array('usps','stamps_com','fedex','ups','dhl_express','canada_post','australia_post','firstmile','asendia','ontrac','apc','newgistics','globegistics','rr_donnelley','imex','access_worldwide','purolator_ca','sendle');

               if($tracking_number!="" && $shipping_company_name!="")
               {    
                    if(in_array($shipping_company_name, $arr_valid_shipping_companies)==false)
                    {    
                        $admin_role = Sentinel::findRoleBySlug('admin');  

                        $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                        $admin_id   = 0;
                        if($admin_obj)
                        {
                            $admin_id = $admin_obj->user_id;            
                        }
                         
                        $user_name='';

                        $getsellername     = $this->UserModel->with('seller_detail')
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
                                // $user_name = $getsellername['first_name'].' '.$getsellername['last_name'];
                                $user_name = get_seller_details($getsellername['id']);
                            }                      
                        }

                         $order_details_url     = url('/').'/seller/order/view/'.base64_encode($order->id);

                        /*********Send Notification*to*Seller***************/

                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $admin_id; 
                        $arr_event['to_user_id']   = $order->seller_id;;
                        $arr_event['type']         = 'seller';
                        $arr_event['description']  = 'Has <a href="'.$order_details_url.'">'.$order->order_no.'</a> been delivered ? Click delivered in the ongoing orders section if your product has been delivered.';                 
                        $arr_event['title']        = 'Has '.$order->order_no.' been delivered ?';                    
                        $this->GeneralService->save_notification($arr_event);

                        /************End*Send*Notification****************/

                        $seller_details = Sentinel::findById($order->seller_id);


                        /*$msg          = html_entity_decode('Click delivered in the ongoing orders section if your product has been delivered.');

                        $subject        = 'Has '.$order->order_no.' been delivered ?';*/

                        $url            = url('/').'/seller/order/ongoing';

                        $arr_built_content = [
                            'USER_NAME'     => $user_name,
                            'APP_NAME'      => config('app.project.name'),
                           /* 'MESSAGE'       => $msg,*/
                            'ORDER_No'      => $order->order_no,
                            'URL'           => $url
                        ];

                        $arr_built_subject =  [
                                               'ORDER_NO'      => $order->order_no
                                            ];    


                        $arr_mail_data['email_template_id'] = '49';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                        $arr_mail_data['user']              = Sentinel::findById($order->seller_id);


                        $this->EmailService->send_mail_section_order($arr_mail_data);


                    /**************end send email**********************/

               }//if invalid shipping comp name
            }   

           }//foreach
        }//if isset

    }//handle
}
