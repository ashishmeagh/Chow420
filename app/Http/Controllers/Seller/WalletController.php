<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\SellerModel;
use App\Models\OrderModel;
use App\Models\WithdrawRequestModel;
use App\Models\WithdrawalBalanceModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\SiteSettingModel;
use App\Common\Services\CommisionService;

use App\Models\UserReferedModel;
use App\Models\UserReferWalletModel;

use Sentinel;
use Datatables;
use DB;
 
class WalletController extends Controller
{

    public function __construct(
                                SellerModel $SellerModel,                        
                                OrderModel $OrderModel,
                                WithdrawRequestModel $WithdrawRequestModel,
                                WithdrawalBalanceModel $WithdrawalBalanceModel,
                                GeneralService $GeneralService,
                                EmailService $EmailService,
                                SiteSettingModel $SiteSettingModel,
                                CommisionService $CommisionService,
                                UserReferedModel $UserReferedModel,
                                UserReferWalletModel $UserReferWalletModel
                               ) 
    {

        $this->SellerModel          = $SellerModel;
        $this->OrderModel           = $OrderModel;
        $this->WithdrawRequestModel = $WithdrawRequestModel;
        $this->WithdrawalBalanceModel = $WithdrawalBalanceModel;
        $this->SiteSettingModel     = $SiteSettingModel;
        $this->arr_view_data        = [];

        $this->module_title         = "Wallet";
        $this->module_view_folder   = "seller/wallet";
        $this->module_url_path      = url('/')."/seller/wallet";
        $this->GeneralService       = $GeneralService;
        $this->EmailService         = $EmailService;
        $this->CommisionService     = $CommisionService;
        $this->UserReferedModel     = $UserReferedModel;
        $this->UserReferWalletModel = $UserReferWalletModel;



        /**************start of site setting array************************/

       /* $site_setting_arr = [];

        $site_setting_obj = SiteSettingModel::first();  

        if(isset($site_setting_obj))
        {
            $site_setting_arr = $site_setting_obj->toArray();  
            if(isset($site_setting_arr) && count($site_setting_arr)>0)
           {
                $admin_commission = $site_setting_arr['admin_commission'];
                $seller_commission = $site_setting_arr['seller_commission'];

                $this->admin_commission  = $admin_commission;
                $this->seller_commission = $seller_commission;

           }

        }*/


        /***************end of site setting array***********************/




    }

    // function for listing of wallet
    public function index(Request $request)
    {
        $arr_pending_wallet = $transaction_arr = [];

        $logginId = 0;
        $user = Sentinel::check();

        if ($user) {
            
            $logginId = $user->id;
        }

        $seller_details_arr = $this->SellerModel->where('user_id',$logginId)->first();
       
        if(!empty($seller_details_arr))
        {
            $seller_details = $seller_details_arr->toArray();
        }


       // $obj_wallet_details = $this->OrderModel->where([['seller_id',$logginId],['is_transfer',0]])->get();
        /*Completed Order*/
        $obj_wallet_details = $this->OrderModel->where([['seller_id',$logginId],['order_status','1']])->get();

        if ($obj_wallet_details) {

            $transaction_arr = $obj_wallet_details->toArray();
        }
        /*end*/

        /*completed order with pending request */
        $obj_pending_wallet_details = $this->OrderModel->where([['seller_id',$logginId],['order_status','1'],['withdraw_reqeust_status','0']])->get();

        if ($obj_pending_wallet_details) {

            $arr_pending_wallet = $obj_pending_wallet_details->toArray();
        }
 
        /*end*/

        
        
        $apppend_data = url()->current();
        $wallet_amount = array_sum((array_column($arr_pending_wallet,'total_amount')));
        $seller_coupon_discount_amt = array_sum((array_column($arr_pending_wallet,'seller_discount_amt')));

        $seller_delivered_delivery_option_amt = array_sum((array_column($arr_pending_wallet , 'delivery_cost')));

        $seller_tax_amt = array_sum((array_column($arr_pending_wallet , 'tax')));

        /***********************************************/
         // $wallt_amt = $wallet_amount* config('app.project.seller_commision')/100;
         $wallt_amt =0;
         $commision_arr = $this->CommisionService->get_commision();
        
         if((!$commision_arr==false) &&isset($commision_arr) && (isset($commision_arr['seller_commission'])))
         {

            if (isset($seller_delivered_delivery_option_amt) && !empty($seller_delivered_delivery_option_amt)) {

              $wallet_amount = (float)$wallet_amount + (float)$seller_delivered_delivery_option_amt;
            }   

            //  if (isset($seller_tax_amt) && !empty($seller_tax_amt)) {

            //   $wallet_amount = (float)$wallet_amount + (float)$seller_tax_amt;
            // }   


             
              $seller_commission = (float)$commision_arr['seller_commission'];

              //if seller discounted amount of coupon

              if(isset($seller_coupon_discount_amt) && !empty($seller_coupon_discount_amt))
              {
                 $wallt_amt = ((float)$wallet_amount-(float)$seller_coupon_discount_amt)*($seller_commission)/100;
              }
              else
              {

                 $wallt_amt = $wallet_amount*($seller_commission)/100;
                 
              }


             // $wallt_amt = $wallet_amount*($seller_commission)/100;
              $wallt_amt = num_format($wallt_amt);

         }

        /**********************************************/



        /*-------------get shipp order total amount------------------------------------*/

        /*completed order with pending request */

        $obj_ship_orders = $this->OrderModel->where([['seller_id',$logginId],['order_status','3'],['withdraw_reqeust_status','0']])->get();

        $commision_arr = $this->CommisionService->get_commision();

        $ship_wallet_amount = 0;

        if($obj_ship_orders)
        {
           $arr_ship_orders = $obj_ship_orders->toArray();
        }

        // $total_sum_shipped_orders =0;
        // if(isset($arr_ship_orders) && !empty($arr_ship_orders))
        // {
        //   foreach ($arr_ship_orders as $key => $value) {
        //      $total_order_amount = $value['total_amount'];
        //      $seller_discount_amt = $value['seller_discount_amt'];
        //       if(isset($seller_discount_amt) && $seller_discount_amt>0)
        //       {
        //         $total_sum_shipped_orders = (float)$total_order_amount-(float)$seller_discount_amt;
        //       }else
        //       {
        //         $total_sum_shipped_orders = $total_order_amount;
        //       }
              
        //   }
        // } 

        $ship_wallet_amount = array_sum((array_column($arr_ship_orders,'total_amount')));

        $seller_coupon_ship_discount_amt    = array_sum((array_column($arr_ship_orders,'seller_discount_amt')));

        $shipped_seller_delivery_option_amt = array_sum((array_column($arr_ship_orders,'delivery_cost')));  // Total Delivery Option Amount

        $shipped_tax_amt = array_sum((array_column($arr_ship_orders,'tax')));  // Total Delivery Option Amount

        if((!$commision_arr==false) &&isset($commision_arr) && (isset($commision_arr['seller_commission'])))
        {

          if (isset($shipped_seller_delivery_option_amt) && !empty($shipped_seller_delivery_option_amt) ) {

            $ship_wallet_amount = ((float)$ship_wallet_amount + (float)$shipped_seller_delivery_option_amt);  // Total Delivery Option Amount Added
          }

          // if (isset($shipped_tax_amt) && !empty($shipped_tax_amt) ) {

          //   $ship_wallet_amount = ((float)$ship_wallet_amount + (float)$shipped_tax_amt);  // Total Delivery Option Amount Added
          // }

          

 
            $seller_commission  = (float)$commision_arr['seller_commission'];

            //if seller discounted amount of coupon
            if(isset($seller_coupon_ship_discount_amt) && !empty($seller_coupon_ship_discount_amt))
            {
                 $ship_wallet_amount = ((float)$ship_wallet_amount - (float)$seller_coupon_ship_discount_amt)*($seller_commission)/100;
            }else
            {
                 $ship_wallet_amount = $ship_wallet_amount*($seller_commission)/100;
            }

           // $ship_wallet_amount = $ship_wallet_amount*($seller_commission)/100;
            $ship_wallet_amount = num_format($ship_wallet_amount);

        }

        /*--------------------------------------------------------------------------------*/

       /* if(isset($this->seller_commission))
        {
           $wallt_amt = $wallet_amount*($this->seller_commission)/100;
           $wallt_amt = num_format($wallt_amt);
        }*/
        $refund_balance_amount = $this->WithdrawalBalanceModel
                                    ->where('seller_id',$logginId)
                                    ->where('refund_balance_status',"0")
                                    ->sum('balance_amount');

        /****************Referal code conditions*************/
        $referal_wallet_amount = $this->UserReferWalletModel
                                ->where('withdraw_reqeust_status','0')
                                ->where('user_id',$logginId)
                                ->sum('amount');          

         /*******************************************/                                     
        
        
        if($request->has('page'))
        {   
            $pageStart = $request->input('page'); 
        }
        else
        {
            $pageStart = 1; 
        }
        
        $total_results = count($transaction_arr);


        $paginator = $this->get_pagination_data($transaction_arr, $pageStart, 10 , $apppend_data);

        if($paginator)
        {
        
            $arr_user_pagination   =  $paginator;  
   
            $arr_view_data['arr_data']=  $paginator->items();
            $arr_view_data['total_results'] = $total_results;
            $arr_pagination = $paginator;

            $this->arr_view_data['transaction_arr'] =  $arr_view_data['arr_data'];
            $this->arr_view_data['arr_pagination'] = $paginator;
            $this->arr_view_data['total_results'] = $total_results;
           // $this->arr_view_data['wallet_amount']  = $wallet_amount;
            $this->arr_view_data['refund_balance_amount']  = $refund_balance_amount?$refund_balance_amount:'0';
            $this->arr_view_data['referal_wallet_amount']  = $referal_wallet_amount?$referal_wallet_amount:'0';
            

            $this->arr_view_data['wallet_amount']       = (float)$wallt_amt;
            $this->arr_view_data['ship_wallet_amount']  = (float)$ship_wallet_amount;
            $this->arr_view_data['seller_id']           = $logginId;
            $this->arr_view_data['page_title']          = $this->module_title;
            $this->arr_view_data['module_url_path']     = $this->module_url_path;
            $this->arr_view_data['seller_details']      = isset($seller_details)?$seller_details:[];

            // dd($this->arr_view_data);
            return view($this->module_view_folder.'.index',$this->arr_view_data);
            
        }
    }

    // ajax function to get wallet details 

    public function get_wallet_details(Request $request)
    {  
        $loggedInUserId = 0;
        $user = Sentinel::check();

        if($user)
        {
            $loggedInUserId = $user->id;
        }
       
        $order_tbl_name              = $this->OrderModel->getTable();
        $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

        $obj_qutoes = DB::table($order_tbl_name)                             
                        ->select(DB::raw($order_tbl_name.".*"))                     
                        ->where($order_tbl_name.'.seller_id',$loggedInUserId)
                        ->where($order_tbl_name.'.order_status','1')
                        ->orderBy('id','desc');
                        
                       // ->where($order_tbl_name.'.is_transfer','0');
                       // ->get();
                   
        
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
              
        if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
        {
            $search_term      = $arr_search_column['q_order_no'];
            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.order_no','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_transaction_id']) && $arr_search_column['q_transaction_id']!="")
        {
            $search_trans_term      = $arr_search_column['q_transaction_id'];
            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.transaction_id','LIKE', '%'.$search_trans_term.'%');
        }

         if(isset($arr_search_column['q_withdrawrequest']) && $arr_search_column['q_withdrawrequest']!="")
        {
            $search_withdraw  = $arr_search_column['q_withdrawrequest'];
            $obj_qutoes    = $obj_qutoes->where($order_tbl_name.'.withdraw_reqeust_status','LIKE', '%'.$search_withdraw.'%');
        }
       
       /* if(isset($arr_search_column['q_price']) && $arr_search_column['q_price']!="")
        {
            $search_term      = $arr_search_column['q_price'];            
            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.total_amount','LIKE', '%'.$search_term.'%');
        }*/
     
        $current_context = $this;

        $json_result  = Datatables::of($obj_qutoes);
        
        $json_result  = $json_result->editColumn('transaction_id',function($data) use ($current_context)
                        {
                            return $data->transaction_id;
                        })
                        ->editColumn('total_amount',function($data) use ($current_context)
                        {
                             $total_amount = $data->total_amount;
                            
                             $total_amt =0;
                             // $commision_arr = $this->CommisionService->get_commision();
                             // if(isset($commision_arr) && (isset($commision_arr['seller_commission'])))
                             // {
                                 
                             //      $seller_commission = (float)$commision_arr['seller_commission'];
                             //      $total_amt = (float)$total_amount*($seller_commission)/100;

                             // }
                            //return $total_amt;


                            $withdraw_status = $data->withdraw_reqeust_status;
                            if(isset($withdraw_status) && ($withdraw_status==1 || $withdraw_status==2))
                            {
                                $withdraw_request_id = $data->withdraw_request_id;

                                $sellercommision ='';

                                $get_withdrawcomision = $this->WithdrawRequestModel->where('id',$withdraw_request_id)->first();
                                if(isset($get_withdrawcomision) && !empty($get_withdrawcomision))
                                {
                                    $sellercommision = $get_withdrawcomision['seller_commission'];
                                   // $total_amt = (float)$total_amount*($sellercommision)/100;


                                    if (isset($data->delivery_cost) && $data->delivery_cost != null) {

                                      $total_amount = (float)$total_amount + (float)$data->delivery_cost;
                                      
                                    }


                                    // if (isset($data->tax) && $data->tax != null) {

                                    //   $total_amount = (float)$total_amount + (float)$data->tax;
                                      
                                    // }



                                    //if seller discounted amount of coupon
                                     if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!='' && isset($data->seller_discount_amt) 
                                            && $data->seller_discount_amt!='')
                                    {

                                      $total_amount = ((float)$total_amount - (float)
                                               $data->seller_discount_amt)*($sellercommision)/100;
                                    }else{
                                        
                                      $total_amount = (float)$total_amount*($sellercommision)/100;

                                    }//else


                                }//if isset withdraw request
                            }
                            else
                            {
                                $commision_arr = $this->CommisionService->get_commision();
                                 if(isset($commision_arr) && (isset($commision_arr['seller_commission'])))
                                 {
                                     
                                      $seller_commission = (float)$commision_arr['seller_commission'];
                                      //$total_amt = (float)$total_amount*($seller_commission)/100;

                                      if (isset($data->delivery_cost) && $data->delivery_cost != null) {

                                      $total_amount = (float)$total_amount + (float)$data->delivery_cost;
                                      
                                      }


                                      // if (isset($data->tax) && $data->tax != null) {

                                      // $total_amount = (float)$total_amount + (float)$data->tax;
                                      
                                      // }


                                      //if seller discounted amount of coupon
                                       if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!='' && isset($data->seller_discount_amt) 
                                            && $data->seller_discount_amt!='')
                                        {

                                          $total_amount = ((float)$total_amount- (float)
                                               $data->seller_discount_amt)*($seller_commission)/100;
                                        }else{
                                          $total_amount = (float)$total_amount*($seller_commission)/100;
                                        }

                                 }//if commisssion
                            }//else

                            return $total_amount;
                        })
                        ;                     
                      
        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
    }



 
    public function get_pagination_data($arr_data = [], $pageStart = 1, $per_page = 0, $apppend_data = [])
    {
        
        $perPage  = $per_page; /* Indicates how many to Record to paginate */
        $offSet   = ($pageStart * $perPage) - $perPage; /* Start displaying Records from this No.;*/        
        $count    = count($arr_data);
        /* Get only the Records you need using array_slice */
        $itemsForCurrentPage = array_slice($arr_data, $offSet, $perPage, true);

        /* Pagination to an Array() */
         $paginator =  new LengthAwarePaginator($itemsForCurrentPage, $count, $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));      

        $paginator->appends($apppend_data); /* Appends all input parameter to Links */
        
        return $paginator;
    }

    public function withdraw_request(Request $request)
    {
        $arr_response = [];
        $frm_data = $request->all();

        try{

            DB::beginTransaction();

                if(isset($frm_data) && count($frm_data) > 0 && isset($frm_data['seller_id']) && !empty($frm_data['seller_id']) 
                    && ((isset($frm_data['wallet_amount'])) && !empty($frm_data['wallet_amount'])) 
                    || ((isset($frm_data['referal_wallet_amount']))
                     && !empty($frm_data['referal_wallet_amount'])) )
                {
                  


                    $seller_details_arr = $this->SellerModel->where('user_id',$frm_data['seller_id'])->first();
       
                    if(!empty($seller_details_arr))
                    {
                        $seller_details = $seller_details_arr->toArray();
                    } 

                    $site_setting_arr = [];

                    $site_setting_obj = SiteSettingModel::first();  

                    if(isset($site_setting_obj))
                    {
                        $site_setting_arr = $site_setting_obj->toArray();  

                        if(isset($site_setting_arr) && count($site_setting_arr)>0)
                       {
                            $admin_commission = $site_setting_arr['admin_commission'];
                            $seller_commission = $site_setting_arr['seller_commission'];
                       }

                    } 
 

                  
                    if(!empty($seller_details) && count($seller_details)>0)
                    {

                          $arr_withdraw_request = array( 
                                                        'seller_id'=>$frm_data['seller_id'],
                                                        'request_amt'=>$frm_data['wallet_amount'],
                                                        'registered_name'=>$seller_details['registered_name'],
                                                        'account_no'=>$seller_details['account_no'],
                                                        'routing_no'=>$seller_details['routing_no'],
                                                        'switft_no'=>$seller_details['switft_no'],
                                                        'paypal_email'=>$seller_details['paypal_email'],
                                                        'referal_amount'=>$frm_data['referal_wallet_amount'],
                                                         'admin_commission'=> $admin_commission,
                                                        'seller_commission'=>$seller_commission
                                                 );

                       
                    }


                    $insert = $this->WithdrawRequestModel->create($arr_withdraw_request);

                    if($insert)
                    {
                        $update_arr = array(
                                                'withdraw_reqeust_status'=>'1',
                                                'withdraw_request_id'    =>$insert->id
                                            );

                        $update = $this->OrderModel->where('seller_id', $frm_data['seller_id'])
                                        ->where('order_status','1')
                                        ->where('withdraw_request_id',NULL)
                                        ->update($update_arr);

                        /****************************************/
                        $update_referalwallet = $this->UserReferWalletModel->where('user_id',$frm_data['seller_id'])
                                        ->where('withdraw_reqeust_status','0')
                                        ->where('withdraw_request_id',NULL)
                                        ->update($update_arr);
                        /****************************************/  



                       // if($update)
                       if($update || $update_referalwallet)
                        {
                            $withdraw_request_url     = url('/').'/'.config('app.project.admin_panel_slug').'/withdraw-request/view/'.base64_encode($insert->id);

                            /*****************Notification START* For Admin***************************/

                                $from_user_id = 0;
                                $admin_id     = 0;
                                $user_name    = "";

                                if(Sentinel::check())
                                {
                                    $user_details = Sentinel::getUser();
                                    $from_user_id = $user_details->id;
                                    $user_name    = $user_details->first_name.' '.$user_details->last_name;
                                }

                                $admin_role = Sentinel::findRoleBySlug('admin');        
                                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                                if($admin_obj)
                                {
                                    $admin_id = $admin_obj->user_id;            
                                }
                                 
                                 $set_email_amount=0;   
                                 if(isset($frm_data['referal_wallet_amount']) && $frm_data['referal_wallet_amount']>0)
                                 {
                                    $set_email_amount = $frm_data['wallet_amount']+$frm_data['referal_wallet_amount'];
                                 }else{
                                    $set_email_amount = $frm_data['wallet_amount'];
                                 }    


                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $from_user_id;
                                $arr_event['to_user_id']   = $admin_id;
                                // $arr_event['description']  = html_entity_decode('Seller <b>'.$user_name.'</b> has sent a <a target="_blank" href="'.$withdraw_request_url.'">withdrawal request</a> of amount <b>$'.$frm_data['wallet_amount'].'</b>.');

                                 $arr_event['description']  = html_entity_decode('Dispensary <b>'.$user_name.'</b> has sent a <a target="_blank" href="'.$withdraw_request_url.'">withdrawal request</a> of amount <b>$'.$set_email_amount.'</b>.');
                                $arr_event['type']         = '';
                                $arr_event['title']        = 'Withdrawal Request';

                 
                                $this->GeneralService->save_notification($arr_event);

                            /************Notification END For Admin   *************************/

                            /************Send Mail Notication to Admin (START)********************/
                                // $msg    = html_entity_decode('Seller <b>'.$user_name.'</b> has sent a withdrawal request of amount <b>$'.$frm_data['wallet_amount'].'</b>.');

                                 //$msg    = html_entity_decode('Dispensary <b>'.$user_name.'</b> has sent a withdrawal request of amount <b>$'.$set_email_amount.'</b>.');

                                //$subject     = 'Withdrawal Request';

                                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                      'APP_NAME'      => config('app.project.name'),
                                                      //'MESSAGE'       => $msg,
                                                      'SELLER_NAME'   => $user_name,
                                                      'AMOUNT'        => '$'.$set_email_amount,
                                                      'URL'           => $withdraw_request_url
                                                     ];

                                $arr_mail_data['email_template_id'] = '71';
                                $arr_mail_data['arr_built_content'] = $arr_built_content;
                                $arr_mail_data['arr_built_subject'] = '';
                                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                                $this->EmailService->send_mail_section($arr_mail_data);

                            /************Send Mail Notication to Admin (END)**********************/


                            $arr_response['status']      = "success";
                            $arr_response['description'] = "Withdrawal request sent successfully.";
                        }
                        else
                        {
                            $arr_response['status']      = "error";
                            $arr_response['description'] = "Unable to send withdrawal request";
                        }
                    }
                }//if first if
                else
                {
                    $arr_response['status']      = "error";
                    $arr_response['description'] = "Unable to Send Withdrawal Request";
                }
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollback();
                // $e->getMessage();

                $arr_response['status']      = 'error';
                $arr_response['description'] = 'Something went wrong while send Withdraw Request, Please try agian.';

            }

        return response()->json($arr_response);
    }

}
