<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Sentinel;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\SiteSettingModel;
use App\Models\BuyerWalletModel;



class Trackpackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Trackpackage:seller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Seller an automatic tracking response of package every day.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GeneralService $GeneralService,UserModel $UserModel,OrderModel $OrderModel,SiteSettingModel $SiteSettingModel, EmailService $EmailService,BuyerWalletModel $BuyerWalletModel)
    {
        parent::__construct();
        $this->GeneralService     = $GeneralService;
        $this->EmailService       = $EmailService;
        $this->UserModel          = $UserModel;
        $this->OrderModel         = $OrderModel;
        $this->SiteSettingModel   = $SiteSettingModel;
        $this->BuyerWalletModel   = $BuyerWalletModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         $get_shipped_orders = $this->OrderModel->where('order_status','3')->with('buyer_details','seller_details','seller_details.seller_detail')->get();
        if(isset($get_shipped_orders) && !empty($get_shipped_orders))
        {


           $tracking_no = $shipping_company_name = ""; $get_cashack_amount = [];
           $get_shipped_orders = $get_shipped_orders->toArray(); 

           foreach($get_shipped_orders as $order)
           {

               $orderno = $order['order_no'];
               $orderid = $order['id'];

               $tracking_no           = $order['tracking_no'];
               $shipping_company_name = $order['shipping_company_name'];

               $get_cashack_amount = get_cashback_data($orderno);

               if(isset($tracking_no) && !empty($tracking_no) && isset($shipping_company_name) && !empty($shipping_company_name))
               { 

                     $res = $this->tracking($tracking_no,$shipping_company_name);

                    if(isset($res) && !empty($res))
                    {
                       if(isset($res['status_code']) && !empty($res['status_code']) && $res['status_code']=="DE" && isset($res['status_description']) && !empty($res['status_description']) && $res['status_description']=="Delivered")
                       {
                          $order_id = $order['id'];

                               if(isset($order_id))
                               {

                                        $from_user_id = 0;
                                        $from_user_id = $order['seller_id']; 

                                        $update = $this->OrderModel
                                                     ->where('id',$order_id)
                                                     ->where('seller_id',$order['seller_id'])
                                                     ->update(['order_status'=>'1']);
                                      if($update)
                                      {


                                           if(isset($get_cashack_amount['cashback']) && $get_cashack_amount['cashback']>0)
                                           {



                                                $to_user = Sentinel::findById($order['buyer_id']);
                                                $fname   = $l_name = ""; 

                                                if(isset($to_user) && !empty($to_user))
                                                {  
                                                 $first_name  = isset($to_user->first_name)?$to_user->first_name:'';
                                                 $last_name  = isset($to_user->last_name)?$to_user->last_name:'';
                                                }

                                                  $update_wallet_darr = [];
                                                  $update_wallet_darr['status'] = 1; 
                                                  $this->BuyerWalletModel
                                                        ->where('user_id',$order['buyer_id'])
                                                        ->where('typeid',$orderno)
                                                        ->where('type','Cashback')
                                                        ->where('status',0)
                                                        ->update($update_wallet_darr);

                                                //send notification to buyer for cashback

                                                $buyer_wallet_url = url('/').'/buyer/wallet';
                                                $admin_id = get_admin_id();

                                                $arr_event                 = [];
                                                $arr_event['from_user_id'] = $admin_id;
                                                $arr_event['to_user_id']   = $order['buyer_id'];
                                                $arr_event['description']  = 'You get cashback of amount $'.number_format($get_cashack_amount['cashback'],2).' having Order No : <a target="_blank" href="'.$buyer_wallet_url.'">'. $orderno.'</a>';
                                                $arr_event['title']        = 'Cashback';
                                                $arr_event['type']         = 'buyer';   

                                                $this->GeneralService->save_notification($arr_event);

                                                //SEND EMAIL TO USER

                                                $arr_built_content = 
                                                ['USER_NAME'     => $first_name.' '.$last_name,
                                                'APP_NAME'      => config('app.project.name'),
                                                //  'MESSAGE'       => $msg,
                                                'AGE_URL'       => $buyer_wallet_url,
                                                'ORDER_NO'      => $orderno,
                                                'CASHBACK_AMOUNT'=> '$'.number_format($get_cashack_amount['cashback'],2)
                                                ];
                                                $arr_built_subject =  [
                                                'ORDER_NO'      => $orderno
                                                ];    

                                                $arr_mail_data['email_template_id'] = '157';
                                                $arr_mail_data['arr_built_content'] = $arr_built_content;
                                                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                                $arr_mail_data['user']              = Sentinel::findById($order['buyer_id']);
                                                $this->EmailService->send_mail_section_order($arr_mail_data);  

                                             }//if cashback amount



                                        /********* Notification START* For Buyer  ***/
                                            $buyer_order_url   = url('/').'/buyer/order/view/'.base64_encode($order_id);

                                            $review_product_url = url('/').'/buyer/review-ratings';

                                            $admin_id     = $to_user_id = 0;
                                            $user_name    = "";

                                            $to_user_id       = $order['buyer_id'];  
                                          
                                            if(isset($order['seller_details']['seller_detail']['business_name']))
                                            {
                                              $user_name  = $order['seller_details']['seller_detail']['business_name'];
                                            }else{
                                              $user_name   = $order['seller_details']['first_name'];
                                            }


                                            $arr_event                 = [];
                                            $arr_event['from_user_id'] = $from_user_id;
                                            $arr_event['to_user_id']   = $to_user_id;
                                            $arr_event['description']  = html_entity_decode('Your order with order ID <a target="_blank" href="'.$buyer_order_url.'"><b>'.$order['order_no'].'</a></b> has been <b>delivered</b> successfully by <b>'.$user_name.'</b>.');
                                            $arr_event['type']         = '';
                                            $arr_event['title']        = 'Order '.$order['order_no'].' Delivered';

                                            $this->GeneralService->save_notification($arr_event);

                                        /******Notification END For Buyer   **************/

                                        /*********Send Delivered Mail to Buyer (START)**********/
                                            $to_user = Sentinel::findById($to_user_id);
                                            $fname   = $l_name = ""; 

                                            if(isset($to_user) && !empty($to_user))
                                            {  
                                             $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                                             $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
                                            }

                                            //$msg     = html_entity_decode('Your order with order ID '.$order['order_no'].' has been delivered successfully by <b>'.$user_name.'</b>.');

                                            
                                            //$subject = 'Order '.$order['order_no'].' Delivered';

                                            $arr_built_content = [
                                                'USER_NAME'     => $f_name.' '.$l_name,
                                                'APP_NAME'      => config('app.project.name'),
                                                //'MESSAGE'       => $msg,
                                                'SELLER_NAME'   => $user_name,
                                                'ORDER_NO'      => $order['order_no'],
                                                'URL'           => $review_product_url
                                            ];

                                             $arr_built_subject =  [
                                               'ORDER_NO'      => $order['order_no']
                                            ];    

                                            $arr_mail_data['email_template_id'] = '77';
                                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                            $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                                            $this->EmailService->send_mail_section_order($arr_mail_data);

                                        /*****Send delivered Mail to Buyer (END)************/

                                        /****** Notification START* For Admin  *************/
                                            $admin_order_url     = url('/').'/'.config('app.project.admin_panel_slug').'/order/view/'.base64_encode($order['order_no']).'/'.base64_encode($order['id']);

                                            $from_user_id = 0;
                                            $admin_id     = 0;
                                            $user_name    = "";

                                          
                                                $from_user_id = $order['seller_id'];

                                                 if(isset($order['seller_details']['seller_detail']['business_name']))
                                                {
                                                  $user_name  = $order['seller_details']['seller_detail']['business_name'];
                                                }else{
                                                  $user_name   = $order['seller_details']['first_name']." ".$order['seller_details']['last_name'];
                                                }


                                                // $user_name    = $order['seller_details']['first_name']." ".$order['seller_details']['last_name'];  

                                            $admin_role = Sentinel::findRoleBySlug('admin');        
                                            $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                                            if(isset($admin_obj) && !empty($admin_obj))
                                            {
                                                $admin_id = $admin_obj->user_id;            
                                            }


                                            $arr_event                 = [];
                                            $arr_event['from_user_id'] = $from_user_id;
                                            $arr_event['to_user_id']   = $admin_id;
                                            $arr_event['description']  = html_entity_decode('Order with order ID <a target="_blank" href="'.$admin_order_url.'"><b>'.$order['order_no'].'</b></a> has been delivered successfully by <b>'.$user_name.'</b>.');
                                            $arr_event['type']         = '';
                                            $arr_event['title']        = 'Order '.$order['order_no'].' Delivered';



                                            $this->GeneralService->save_notification($arr_event);

                                        /*****Notification END For Admin   ************/

                                 
                                        /*****Send Delivered Mail to Admin (START)*******/
                                            $to_user = Sentinel::findById($admin_id);
                                            $f_name = $l_name = ""; 

                                            if(isset($to_user) && !empty($to_user))
                                            {  
                                            $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                                            $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';
                                            }

                                           /* $msg     = html_entity_decode('Order with order ID <b>'.$order['order_no'].'</b> has been delivered successfully by <b>'.$user_name.'</b>.');*/

                                           
                                            //$subject = 'Order '.$order['order_no'].' Delivered';

                                            $arr_built_content = [
                                                'USER_NAME'     => config('app.project.admin_name'),
                                                'APP_NAME'      => config('app.project.name'),
                                                //'MESSAGE'       => $msg,
                                                'SELLER_NAME'   => $user_name,
                                                'ORDER_NO'      => $order['order_no'],
                                                'URL'           => $admin_order_url
                                            ];

                                            $arr_built_subject =  [
                                               'ORDER_NO'      => $order['order_no']
                                            ];  

                                            $arr_mail_data['email_template_id'] = '78';
                                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                            $arr_mail_data['user']              = Sentinel::findById($admin_id);



                                            $this->EmailService->send_mail_section_order($arr_mail_data);

                                        /*******Send Deliverd Mail to Admin (END)*******/


                                        /********* Notification START* For Seller  ***/

                                            $seller_order_url   = url('/').'/seller/order/view/'.base64_encode($order_id);

                                            $admin_id     = $to_user_id = 0;

                                            $to_user_id   = $order['seller_id'];  
                                            $admin_role   = Sentinel::findRoleBySlug('admin');        
                                            $admin_obj    = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                                            if(isset($admin_obj) && !empty($admin_obj))
                                            {
                                                $admin_id = $admin_obj->user_id;            
                                            }

                                            $arr_event                 = [];
                                            $arr_event['from_user_id'] = $admin_id;
                                            $arr_event['to_user_id']   = $to_user_id;
                                            $arr_event['description']  = html_entity_decode('Order with order ID <a target="_blank" href="'.$seller_order_url.'"><b>'.$order['order_no'].'</a></b> has been <b>delivered</b> successfully.');
                                            $arr_event['type']         = '';
                                            $arr_event['title']        = 'Order '.$order['order_no'].' Delivered';

                                            $this->GeneralService->save_notification($arr_event);

                                        /****** Notification END For Seller   **************/


                                        /*********Send Delivered Mail to Seller (START)**********/
                                        
                                            $to_user = Sentinel::findById($to_user_id);
                                            $fname   = $l_name = $userfullname = ""; 

                                            if(isset($to_user) && !empty($to_user))
                                            {  
                                                 $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                                                 $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                                                  $userfullname = get_seller_details($to_user->id);

                                                 if(isset($userfullname) && !empty($userfullname))
                                                 {
                                                   $userfullname = $userfullname;
                                                 }else
                                                 {
                                                    $userfullname = $f_name." ".$l_name;
                                                 }
                                            }

                                           /* $msg     = html_entity_decode('Order with order ID '.$order['order_no'].' has been delivered successfully.');*/

                                            
                                            //$subject = 'Order '.$order['order_no'].' Delivered';

                                            $arr_built_content = [
                                                'USER_NAME'     => $userfullname,
                                                'APP_NAME'      => config('app.project.name'),
                                                //'MESSAGE'       => $msg,
                                                'ORDER_NO'      => $order['order_no'], 
                                                'URL'           => $seller_order_url
                                            ];

                                            $arr_built_subject =  [
                                               'ORDER_NO'      => $order['order_no']
                                            ];  

                                            $arr_mail_data['email_template_id'] = '79';
                                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                            $arr_mail_data['user']              = Sentinel::findById($to_user_id);


                                            $this->EmailService->send_mail_section_order($arr_mail_data);



                                        /*****Send delivered Mail to Seller (END)************/
                                     
                                      }//update if end
                                      else
                                      {
                                      // Flash::error('Problem occured while updating the order status');

                                      }

                                   }//order_id if end
                                   else
                                   {
                                       // Flash::error('Record does not exists');
                                   }
                                }// status deliverd if end
                               /* else
                                {
                                    return redirect()->back();
                                }*/

                    }//not empty res if end
                   
               }//tracking no not null if end
           }//foreach  
        }//if isset
    }//func end

    function tracking($tracking_no="",$shipping_company_name)
    {
                    $curl    = curl_init();
                    $api_key = "";
                    $api_key_details = $this->SiteSettingModel->first()->sandbox_tracking_api_key; 
                    if(isset($api_key_details) && !empty($api_key_details))
                    {
                     $api_key = $api_key_details;
                    } 


                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://api.shipengine.com/v1/tracking?carrier_code=".$shipping_company_name."&tracking_number=".$tracking_no,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "GET",
                      CURLOPT_HTTPHEADER => array(
                        "Host: api.shipengine.com",
                        "API-Key: ".$api_key
                      ),
                    ));
 
                    $response = curl_exec($curl);

                    curl_close($curl);
                    $res =  json_decode($response,true);
                    return $res;
    }//end function

}
