<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserModel;
use App\Common\Services\EmailService;
use App\Common\Services\GeneralService;


use DB;
use Sentinel;
use App\Models\OrderModel;


class buyeragelink extends Command
{ 
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buyeragelink:buyer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to buyer for age verification link';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserModel $UserModel,EmailService $EmailService,OrderModel $OrderModel,GeneralService $GeneralService)
    {
        parent::__construct();
        $this->UserModel = $UserModel;
        $this->EmailService = $EmailService;
        $this->OrderModel = $OrderModel;
        $this->GeneralService = $GeneralService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       
   

                /*$get_orders = $this->OrderModel->where('buyer_age_restrictionflag','1')->where('order_status','!=','0')->get();*/

                $get_orders = $this->OrderModel->where('buyer_age_restrictionflag','1')->where('order_status','=','2')->get();

                if(isset($get_orders) && !empty($get_orders))
                {
                    $get_orders = $get_orders->toArray();

                    foreach($get_orders as $getorders)
                    {
 
                          //check 7 days
                                  
                          $new_date   = date('Y-m-d', strtotime($getorders['created_at']. '+7 day')); 
                          $order_date = date('Y-m-d', strtotime($getorders['created_at']));

                         
                          if($order_date <= $new_date)
                          {

                                $admin_id = get_admin_id();
                                $sellerid = $getorders['seller_id'];
                                $buyerid = $getorders['buyer_id'];
                                $order_no = $getorders['order_no'];

                                 $buyer_profile_url = url('/').'/buyer/age-verification';

                                


                                $buyer_obj = $this->UserModel->where('id',$buyerid)->first();

                                if(isset($buyer_obj))
                                {
                                  $buyer_arr = $buyer_obj->toArray();

                                  $buyer_nameemail = $buyer_arr['first_name'].' '.$buyer_arr['last_name'];
                                }


                                //send noti
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $admin_id;
                                $arr_event['to_user_id']   = $buyerid;
                                $arr_event['description']  = ' Please <a target="_blank" href='.$buyer_profile_url.'>click here</a> to further verify your age for the order '.$order_no.' to be shipped. This is the only time you will be required to verify your age on Chow420.';
                                $arr_event['title']        = 'Pending age-verification for order '.$order_no.'';
                                $arr_event['type']         = 'buyer';   
                                $this->GeneralService->save_notification($arr_event);
             
                                
                                //send email
                                $arr_built_content = 
                                ['USER_NAME'     => $buyer_nameemail,
                                'APP_NAME'      => config('app.project.name'),
                                //  'MESSAGE'       => $msg,
                                'AGE_URL'       => $buyer_profile_url,
                                'ORDER_NO'      => $order_no,
                                ];
                                $arr_built_subject =  [
                                'ORDER_NO'      => $order_no
                                ];    


                                $arr_mail_data['email_template_id'] = '134';
                                $arr_mail_data['arr_built_content'] = $arr_built_content;
                                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                $arr_mail_data['user']              = Sentinel::findById($buyerid);
                                $this->EmailService->send_mail_section_order($arr_mail_data);  


                                //send notification via sms

                                  $phonecode ='';                    
                                  if(isset($buyer_arr['phone']) && $buyer_arr['phone']!='')
                                  { 

                                    $getbuyercountry = isset($buyer_arr['country'])? get_countryDetails($buyer_arr['country']):'';
                                    if(isset($getbuyercountry) && !empty($getbuyercountry))
                                    {
                                        $phonecode = isset($getbuyercountry['phonecode'])?$getbuyercountry['phonecode']:'';

                                        $account_sid = isset($twilio_account_sid)?$twilio_account_sid: config('app.project.account_sid');
                                        $auth_token = isset($twilio_auth_token)?$twilio_auth_token:config('app.project.auth_token');

                                        $url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/SMS/Messages";
                                        $to = "+".$phonecode.$buyer_arr['phone'];

                                        $from = isset($twilio_from_number)?$twilio_from_number:config('app.project.from'); // twilio trial 

                                        $body = "Verify your age on Chow420 for your order ".$order_no." to be shipped: ".$buyer_profile_url."";

                                        $data = array (
                                            'From' => $from,
                                            'To' => $to,
                                            'Body' => $body,
                                        );
                                        $post = http_build_query($data);
                                        $x = curl_init($url );
                                        curl_setopt($x, CURLOPT_POST, true);
                                        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                                        curl_setopt($x, CURLOPT_USERPWD, "$account_sid:$auth_token");
                                        curl_setopt($x, CURLOPT_POSTFIELDS, $post);
                                        $y = curl_exec($x);
                                        curl_close($x);
                                      // var_dump($post);
                                      // var_dump($y);

                                    }//if getcountry        
                                  }//if isset phone
                              
                          }

                    }//foreach

                }//if get orers
                  
           
    }//public
}
