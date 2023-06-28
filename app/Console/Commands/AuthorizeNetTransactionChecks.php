<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserModel;
use App\Common\Services\EmailService;
use App\Common\Services\GeneralService;


use DB;
use Sentinel;
use Omnipay\Omnipay;

use App\Models\OrderModel;
use App\Models\SiteSettingModel;


class AuthorizeNetTransactionChecks extends Command
{ 
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'authorize_net_transaction:check';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Check and update the order status and refund status for the unsettled transactions in authorize.net payment gateway';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(
    EmailService $EmailService,
    GeneralService $GeneralService,
    UserModel $UserModel,
    OrderModel $OrderModel,
    SiteSettingModel $SiteSettingModel
  )
  {
    parent::__construct();

    $this->UserModel            = $UserModel;
    $this->EmailService         = $EmailService;
    $this->OrderModel           = $OrderModel;
    $this->GeneralService       = $GeneralService;
    $this->SiteSettingModel     = $SiteSettingModel;

    $this->gateway              = Omnipay::create('AuthorizeNetApi_Api');

    $this->admin_id             = get_admin_id();
    $this->admin_path           = config('app.project.admin_panel_slug');
    $this->seller_path           = config('app.project.seller_panel_slug');

    $this->payment_gateway_used = "authorizenet";
    $this->transaction_status   = "capturedPendingSettlement";
    $this->transaction_status_success   = "settledSuccessfully";

  }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

      $connection_flag = 0;
      $site_settings_obj = $this->SiteSettingModel->select(
                                                    'site_setting_id',
                                                    'payment_mode',
                                                    'sandbox_api_loginid',
                                                    'sandbox_transactionkey',
                                                    'live_api_loginid',
                                                    'live_transactionkey',
                                                    'payment_gateway_switch'
                                                  )
                                                  ->first();

      if($site_settings_obj)
      {
        $arr_site_settings = $site_settings_obj->toArray();    
        

        if($arr_site_settings['payment_mode'] == 1)
        {
          if(($arr_site_settings['live_api_loginid'] != '' && $arr_site_settings['live_api_loginid'] != null) && ($arr_site_settings['live_transactionkey'] != '' && $arr_site_settings['live_transactionkey'] != null))
          {
            $this->gateway->setAuthName($arr_site_settings['live_api_loginid']);
            $this->gateway->setTransactionKey($arr_site_settings['live_transactionkey']);

            $connection_flag = 1;

          }
          else
          {
            echo "Unable to get the authorize.net payment gateway live credentials, please set it from Site Settings\n";

            $admin_profile_url = url('/').'/'.$this->admin_path.'/site_settings';
            //send notification to admin
            $arr_event                 = [];
            $arr_event['from_user_id'] = $this->admin_id;
            $arr_event['to_user_id']   = $this->admin_id;
            $arr_event['title']        = 'Authorize.net gateway credentials';
            $arr_event['description']  = 'Unable to get the authorize.net payment gateway live credentials, please set it from <a target="_blank" href='.$admin_profile_url.'> Site Settings</a>.';
            $arr_event['type']         = 'payment_gateway';   
            $this->GeneralService->save_notification($arr_event);

          }
         
        }
        else
        {
          if(($arr_site_settings['sandbox_api_loginid'] != '' && $arr_site_settings['sandbox_api_loginid'] != null) && ($arr_site_settings['sandbox_transactionkey'] != '' && $arr_site_settings['sandbox_transactionkey'] != null))
          {

            $this->gateway->setAuthName($arr_site_settings['sandbox_api_loginid']);
            $this->gateway->setTransactionKey($arr_site_settings['sandbox_transactionkey']);
            $this->gateway->setTestMode(true); //comment this line when move to 'live'

            $connection_flag = 1;


          }
          else
          {

            echo "Unable to get the authorize.net payment gateway sandbox credentials, please set it from Site Settings\n";

            $admin_profile_url = url('/').'/'.$this->admin_path.'/site_settings';
            //send notification to admin
            $arr_event                 = [];
            $arr_event['from_user_id'] = $this->admin_id;
            $arr_event['to_user_id']   = $this->admin_id;
            $arr_event['title']        = 'Authorize.net gateway credentials';
            $arr_event['description']  = 'Unable to get the authorize.net payment gateway sandbox credentials, please set it from <a target="_blank" href='.$admin_profile_url.'> Site Settings</a>.';
            $arr_event['type']         = 'payment_gateway';   
            $this->GeneralService->save_notification($arr_event);

          }
          
        }
        

        if($connection_flag == 1)
        {          
          $this->check_main_order_status();    
          $this->check_refund_order_status();    
        }

        
      }
      else
      {
        echo "Unable to get the authorize.net payment gateway credentials, please set it from Site Settings\n";

        $admin_profile_url = url('/').'/'.$this->admin_path.'/site_settings';
        //send notification to admin
        $arr_event                 = [];
        $arr_event['from_user_id'] = $this->admin_id;
        $arr_event['to_user_id']   = $this->admin_id;
        $arr_event['title']        = 'Authorize.net gateway credentials';
        $arr_event['description']  = 'Unable to get the authorize.net payment gateway credentials, please set it from <a target="_blank" href='.$admin_profile_url.'> Site Settings</a>.';
        $arr_event['type']         = 'payment_gateway';   
        $this->GeneralService->save_notification($arr_event);
      }
      
      
                  
           
    }//public

    function check_main_order_status()
    {
      
      $get_unsettled_orders = $this->OrderModel->where('payment_gateway_used',$this->payment_gateway_used)
                                               ->where('authorize_transaction_status','=',$this->transaction_status)
                                               ->with('seller_details.seller_detail','buyer_details')
                                               ->get();

      if(isset($get_unsettled_orders) && !empty($get_unsettled_orders))
      {
        $get_unsettled_orders = $get_unsettled_orders->toArray();

        foreach($get_unsettled_orders as $order_info)
        {

          if($order_info['transaction_id'] != '' && $order_info['transaction_id'] != null)
          {
            $response = $this->gateway->fetchTransaction([
                'transactionReference' => $order_info['transaction_id']
            ])->send();

            $transaction_info = $response->getParsedData();
            
            if($transaction_info->data['transaction']['transactionStatus'] == "settledSuccessfully")
            {

              $update_data = [
                'authorize_transaction_status' => 'settledSuccessfully'
              ];

              $update_transaction_status = $this->OrderModel->where('id',$order_info['id'])
                                                            ->update($update_data);
              if($update_transaction_status)
              {
                echo "The payment for order, Order No. ".$order_info['order_no']." has been settled successfully.\n";

                //send notification to admin

                $admin_profile_url = url('/').'/'.$this->admin_path.'/order/view/'.base64_encode($order_info['order_no']).'/'.base64_encode($order_info['id']);


                $seller_name = $order_info['seller_details']['seller_detail']['business_name'] !='' ?$order_info['seller_details']['seller_detail']['business_name']: 'seller';
                $arr_event                 = [];
                $arr_event['from_user_id'] = $this->admin_id;
                $arr_event['to_user_id']   = $this->admin_id;
                $arr_event['title']        = 'Order payment settled';
                $arr_event['description']  = 'The payment for order number <a target="_blank" href='.$admin_profile_url.'> '.$order_info['order_no'].'</a>  has been settled successfully. Now <b>'.$seller_name.'</b> can process the order further.';
                $arr_event['type']         = 'payment_gateway';   

                $this->GeneralService->save_notification($arr_event);


                //send email to admin
                $arr_built_content = 
                ['USER_NAME'         => config('app.project.name'),
                'APP_NAME'           => config('app.project.name'),
                'URL'                => $admin_profile_url,
                'SELLER_NAME'        => $seller_name,
                'ORDER_NO'           => $order_info['order_no'],
                ];
                $arr_built_subject =  [
                'ORDER_NO'           => $order_info['order_no']
                ];    


                $arr_mail_data['email_template_id'] = '143';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($this->admin_id);
                $this->EmailService->send_mail_section_order($arr_mail_data);  


                //send notification to seller

                $seller_profile_url = url('/').'/'.$this->seller_path.'/order/view/'.base64_encode($order_info['id']);


                $seller_name = $order_info['seller_details']['seller_detail']['business_name'] !='' ?$order_info['seller_details']['seller_detail']['business_name']: 'seller';
                $arr_event                 = [];
                $arr_event['from_user_id'] = $this->admin_id;
                $arr_event['to_user_id']   = $order_info['seller_id'];
                $arr_event['title']        = 'Order payment settled';
                $arr_event['description']  = 'The payment for order number <a target="_blank" href='.$seller_profile_url.'> '.$order_info['order_no'].'</a>  has been settled successfully. Now you can process the order further.';
                $arr_event['type']         = 'payment_gateway';   

                $this->GeneralService->save_notification($arr_event);


                //send email to seller
                $arr_built_content = 
                ['USER_NAME'         => $seller_name,
                'APP_NAME'           => config('app.project.name'),
                'URL'                => $seller_profile_url,
                'SELLER_NAME'        => 'you',
                'ORDER_NO'           => $order_info['order_no'],
                ];
                $arr_built_subject =  [
                'ORDER_NO'           => $order_info['order_no']
                ];    


                $arr_mail_data['email_template_id'] = '143';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($order_info['seller_id']);
                $this->EmailService->send_mail_section_order($arr_mail_data);  

              }
            }
          }


        }//foreach
      }//if get orers
      
    }

    function check_refund_order_status()
    {
      
      $get_unsettled_orders = $this->OrderModel->where('payment_gateway_used',$this->payment_gateway_used)
                                               ->where('refund_status','=',1)
                                               ->where('authorize_transaction_status','=',$this->transaction_status_success)
                                               ->with('seller_details.seller_detail','buyer_details')
                                               ->get();

      if(isset($get_unsettled_orders) && !empty($get_unsettled_orders))
      {
        $get_unsettled_orders = $get_unsettled_orders->toArray();

        foreach($get_unsettled_orders as $order_info)
        {

          if($order_info['refund_id'] != '' && $order_info['refund_id'] != null)
          {
            $response = $this->gateway->fetchTransaction([

                'transactionReference' => intval($order_info['refund_id'])
            ])->send();

            $transaction_info = $response->getParsedData();
            // dd(intval($order_info['refund_id']),$transaction_info);


            
            if(isset($transaction_info->data['transaction']) && $transaction_info->data['transaction']['transactionStatus'] == "refundSettledSuccessfully")
            {
              $update_data = [
                'authorize_transaction_status' => 'refundSettledSuccessfully',
                'refund_status' => 2
              ];

              $update_transaction_status = $this->OrderModel->where('id',$order_info['id'])
                                                            ->update($update_data);
              if($update_transaction_status)
              {
                echo "The refund payment for order, Order No. ".$order_info['order_no']." has been settled successfully.\n";

                //send notification to admin

                $admin_profile_url = url('/').'/'.$this->admin_path.'/order/view/'.base64_encode($order_info['order_no']).'/'.base64_encode($order_info['id']);


                $seller_name = $order_info['seller_details']['seller_detail']['business_name'] !='' ?$order_info['seller_details']['seller_detail']['business_name']: 'seller';
                $arr_event                 = [];
                $arr_event['from_user_id'] = $this->admin_id;
                $arr_event['to_user_id']   = $this->admin_id;
                $arr_event['title']        = 'Order payment settled';
                $arr_event['description']  = 'The refund payment for order number <a target="_blank" href='.$admin_profile_url.'> '.$order_info['order_no'].'</a>  has been settled successfully.';
                $arr_event['type']         = 'payment_gateway';   

                $this->GeneralService->save_notification($arr_event);


                //send email to admin
                $arr_built_content = 
                ['USER_NAME'         => config('app.project.name'),
                'APP_NAME'           => config('app.project.name'),
                'URL'                => $admin_profile_url,
                'SELLER_NAME'        => $seller_name,
                'ORDER_NO'           => $order_info['order_no'],
                ];
                $arr_built_subject =  [
                'ORDER_NO'           => $order_info['order_no']
                ];    


                $arr_mail_data['email_template_id'] = '144';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($this->admin_id);
                $this->EmailService->send_mail_section_order($arr_mail_data);  


                


              }// if update_transaction_status
            } //if transaction_info
          } //if order_info



        }//foreach
      }//if get orers
      

    }//end check_refund_order_status


    
}
