<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WithdrawRequestModel;
use App\Models\AdminCommissionModel;
use App\Models\OrderModel;
use App\Models\UserModel;

use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\SiteSettingModel;
use App\Models\WithdrawalBalanceModel;

use App\Common\Services\CommisionService;
use App\Models\UserReferedModel;
use App\Models\UserReferWalletModel;
use App\Models\SellerModel;

 use App\Common\Services\UserService;


use DB;
use Sentinel;
use Datatables;


class WithdrawRequestController extends Controller
{
    //
    public function __construct(WithdrawRequestModel $WithdrawRequestModel,
    							AdminCommissionModel $AdminCommissionModel,
    							OrderModel $OrderModel,
    							GeneralService $GeneralService,
    							EmailService $EmailService,
    							UserModel $UserModel,
                                SiteSettingModel $SiteSettingModel,
                                WithdrawalBalanceModel $WithdrawalBalanceModel,
                                CommisionService $CommisionService,
                                UserReferedModel $UserReferedModel,
                                UserReferWalletModel $UserReferWalletModel,
                                UserService $UserService,
                                SellerModel $SellerModel
    							)
    {
        $this->WithdrawRequestModel    	= $WithdrawRequestModel;
        $this->BaseModel     			= $this->WithdrawRequestModel;
        $this->AdminCommissionModel 	= $AdminCommissionModel;
        $this->OrderModel 				= $OrderModel;

        $this->UserModel                = $UserModel;
        $this->WithdrawalBalanceModel   = $WithdrawalBalanceModel;

        $this->GeneralService           = $GeneralService;
        $this->EmailService             = $EmailService;
        $this->SiteSettingModel         = $SiteSettingModel;
        $this->CommisionService         = $CommisionService;
        $this->UserReferedModel         = $UserReferedModel;
        $this->UserReferWalletModel     = $UserReferWalletModel;
        $this->UserService              = $UserService;
        $this->SellerModel              = $SellerModel;

        $this->arr_view_data = [];
        
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/withdraw-request");
       // $this->seller_commission = url(config('app.project.seller_commision'));
        $this->module_title       = "Withdraw Requests";
        $this->module_url_slug    = "withdraw-request";
        $this->module_view_folder = "admin.withdraw_request";

        /**************start of site setting array************************/
        /*$site_setting_arr = [];
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
 
    public function index()
    { 
        // $arr_lang = array();
        // $arr_data = array();

        // $obj_data = $this->BaseModel->with(['seller_details'])->orderBy('id','desc')->get();
        // if($obj_data != FALSE)
        // {
        //     $arr_data = $obj_data->toArray();
        // }

        // $this->arr_view_data['arr_data'] = $arr_data;

        // dd($arr_data);

        $this->arr_view_data['page_title']      = "Manage ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        // dd($this->arr_view_data);
        
        return view($this->module_view_folder.'.manage',$this->arr_view_data);
    }
 
    public function get_records(Request $request)
    {
    	$withdraw_request_table           = $this->BaseModel->getTable();
        $prefixed_withdraw_request_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $user_table           = $this->UserModel->getTable();
        $prefixed_user_table  = DB::getTablePrefix().$this->UserModel->getTable();


        $seller_table           = $this->SellerModel->getTable();
        $prefixed_seller_table  = DB::getTablePrefix().$this->SellerModel->getTable();



        $obj_withdraw_request = DB::table($withdraw_request_table)
                                ->select(DB::raw($prefixed_withdraw_request_table.".id as id,".
                                                $prefixed_withdraw_request_table.".seller_id, ".
                                                $prefixed_withdraw_request_table.".request_amt , ".
                                                $prefixed_withdraw_request_table.".previous_uncleared_balance , ".
                                                $prefixed_withdraw_request_table.".received_amt , ".
                                                $prefixed_withdraw_request_table.".referal_amount , ".
                                                $prefixed_withdraw_request_table.".status , ".
                                                $prefixed_seller_table.".business_name , ".
                                                
                                                "CONCAT(".$prefixed_user_table.".first_name,' ',"
                                                          .$prefixed_user_table.".last_name) as seller_name"
                                    ))

                                ->leftjoin($prefixed_user_table,$prefixed_user_table.'.id','=',$prefixed_withdraw_request_table.'.seller_id')

                                ->leftjoin($prefixed_seller_table,$prefixed_seller_table.'.user_id','=',$withdraw_request_table.'.seller_id')
                            
                                ->whereNull($withdraw_request_table.'.deleted_at')

                                ->orderBy($withdraw_request_table.'.status','ASC');
                                
                                //->orderBy($withdraw_request_table.'.created_at','DESC');

        $arr_search_column = $request->input('column_filter');

        if(isset($arr_search_column['q_seller_name']) && $arr_search_column['q_seller_name']!="")
        {
            $search_term      	  = $arr_search_column['q_seller_name'];
            $obj_withdraw_request = $obj_withdraw_request->having('business_name','LIKE', '%'.$search_term.'%');

        }

        if(isset($arr_search_column['q_request_amt']) && $arr_search_column['q_request_amt']!="")
        {
            $search_term 		   = $arr_search_column['q_request_amt'];
            $obj_withdraw_request  = $obj_withdraw_request->where($prefixed_withdraw_request_table.'.request_amt','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_receive_amt']) && $arr_search_column['q_receive_amt']!="")
        {
            $search_term 		   = $arr_search_column['q_receive_amt'];
            $obj_withdraw_request  = $obj_withdraw_request->where($prefixed_withdraw_request_table.'.received_amt','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status']!="")
        {
            $search_term 		  = $arr_search_column['q_status'];
            $obj_withdraw_request = $obj_withdraw_request->where($prefixed_withdraw_request_table.'.status','LIKE', '%'.$search_term.'%');
        }

        $current_context = $this;

        $json_result     = Datatables::of($obj_withdraw_request);

        $json_result     = $json_result
        					->editColumn('request_amt',function($data) use ($current_context)
                            {
                                $request_amt ='--';
                                if($data->request_amt)
                                {   
                                    $request_amt = isset($data->request_amt)?'$'.$data->request_amt:'--';
                                }
                                
                                return $request_amt;
                            })
                            ->editColumn('previous_uncleared_balance',function($data) use ($current_context)
                            {
                                $previous_uncleared_balance ='--';
                                if($data->previous_uncleared_balance)
                                {   
                                    $previous_uncleared_balance = isset($data->previous_uncleared_balance)?'$'.$data->previous_uncleared_balance:'--';
                                }
                                
                                return $previous_uncleared_balance;
                            })
                            ->editColumn('received_amt',function($data) use ($current_context)
                            {
                                $received_amt ='--';
                                if($data->received_amt)
                                {   
                                    $request_amt = isset($data->request_amt)?$data->request_amt:'0';
                                    $previous_uncleared_balance = isset($data->previous_uncleared_balance)?$data->previous_uncleared_balance:'0';
                                    $received_amt = $request_amt - $previous_uncleared_balance;

                                     if($data->referal_amount)
                                    {
                                      $received_amt = $received_amt+$data->referal_amount;
                                    }    

                                    $received_amt = isset($received_amt)?'$'.$received_amt:'--';
                                }
                                
                                return $received_amt;
                            })
                            
                            ->editColumn('build_status_label',function($data) use ($current_context)
                            {
                                $build_status_label ='';
                                if($data->status == '0')
                                {   
                                    $build_status_label = "<span class='status-dispatched'>Pending</span>";
                                }
                                elseif($data->status == '1')
                                {
                                    $build_status_label = "<span class='status-completed'>Completed</span>";
                                }
                                elseif($data->status == '2')
                                {
                                    $build_status_label = "<span class='status-shipped'>Cancelled</span>";
                                }
                                return $build_status_label;
                            })    
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                            	$build_action_btn = ' <a class="eye-actn" href="'.$view_href.'" title="View withdraw request">View</a>';

                                return $build_action_btn;
                            })
                            
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);

    }



    public function view($enc_id = FALSE)
    {


    	$order_total = '';
    	$arr_withdraw_request = [];
    	if(isset($enc_id) && !empty($enc_id) && $enc_id != FALSE)
    	{
    		$withdraw_id = base64_decode($enc_id);
    		$obj_withdraw_request = $this->WithdrawRequestModel
    								->where('id',$withdraw_id)
    								->with(['order_details','seller_details','seller_table_details'])
    								->first();
    								// $obj_withdraw_request = $this->WithdrawRequestModel
    								// ->where('id',$withdraw_id)
    								// ->with(['order_details'=>function($q){
    								// 			return $q->
    								// 		},'seller_details'])
    								// ->first();

    		if($obj_withdraw_request)
    		{
    			$arr_withdraw_request = $obj_withdraw_request->toArray();

                $refund_balance_amount = $this->WithdrawalBalanceModel
                                    ->where('seller_id',$arr_withdraw_request['seller_id'])
                                    ->where('withdraw_request_id',$arr_withdraw_request['id'])
                                    ->where('refund_balance_status',"1")
                                    ->sum('balance_amount');
                if($refund_balance_amount==0)
                {
                    $refund_balance_amount = $this->WithdrawalBalanceModel
                                    ->where('seller_id',$arr_withdraw_request['seller_id'])
                                    ->where('refund_balance_status',"0")
                                    ->sum('balance_amount');
                }
                // dd($refund_balance_amount);
                                    // ->toSql();
                                    // ->first();
    			/* sum of order amount */
    			$order_total = array_sum(array_column($arr_withdraw_request['order_details'],'total_amount'));

                $seller_discount_amt = array_sum(array_column($arr_withdraw_request['order_details'],'seller_discount_amt'));

                $seller_delivery_cost = array_sum(array_column($arr_withdraw_request['order_details'],'delivery_cost'));


                $tax = array_sum(array_column($arr_withdraw_request['order_details'],'tax'));

                if(isset($seller_discount_amt) && $seller_discount_amt>0)
                {
                    $order_total = (float)$order_total - (float)$seller_discount_amt;
                }else{
                    $order_total = $order_total;
                }

                 if(isset($seller_delivery_cost) && $seller_delivery_cost>0)
                {
                    $order_total = (float)$order_total + (float)$seller_delivery_cost;
                }else{
                    $order_total = $order_total;
                }

                //  if(isset($tax) && $tax>0)
                // {
                //     $order_total = (float)$order_total + (float)$tax;
                // }else{
                //     $order_total = $order_total;
                // }


    			/*end*/
                $referalwallet_total = $arr_withdraw_request['referal_amount'];


    		}//if objwithdrwa request

    		// $this->arr_view_data['arr_withdraw_request'] = $arr_withdraw_request;

	     	$this->arr_view_data['enc_id']                  = $enc_id;
	     	$this->arr_view_data['order_total']             = $order_total;
	      	$this->arr_view_data['module_url_path']         = $this->module_url_path;
	      	$this->arr_view_data['arr_withdraw_request']   	= isset($arr_withdraw_request) ? $arr_withdraw_request : [];  
            $this->arr_view_data['refund_balance_amount']    = isset($refund_balance_amount) ? $refund_balance_amount : '0';  


             $this->arr_view_data['referalwallet_total']    = isset($referalwallet_total) ? $referalwallet_total : '0';  

	      	$this->arr_view_data['page_title']              = "View ";
	      	$this->arr_view_data['module_title']            = $this->module_title;


            /************************************************/
            //$this->arr_view_data['seller_commission'] = isset($this->seller_commission)?$this->seller_commission:'87';
            //$this->arr_view_data['admin_commission']  = isset($this->admin_commission)?$this->admin_commission:'13';

            

             //commented below code for seller and admin commision maintained
             // $commision_arr = $this->CommisionService->get_commision();
             // if( ($commision_arr!=false) && isset($commision_arr) && isset($commision_arr['admin_commission']) && (isset($commision_arr['seller_commission'])))
             // {
             //     $this->arr_view_data['admin_commission'] = (float)$commision_arr['admin_commission'];
             //     $this->arr_view_data['seller_commission'] = (float)$commision_arr['seller_commission'];
             // }





            /**************************************************/

	      	
	      	return view($this->module_view_folder.'.view',$this->arr_view_data);   
    	}
    }



    /*store admin commission*/
    public function store_admin_commission(Request $request)
    {
        $frm_data         = $request->all();
        $seller_receivedamt=0;

        $user = Sentinel::check();

        $referalwallet_total = isset($frm_data['referalwallet_total'])?$frm_data['referalwallet_total']:'0';

        $arr_order_detail = $arr_response = [];

    	try{

            DB::beginTransaction();


		        if(isset($frm_data['withdraw_table_id']) && !empty($frm_data['withdraw_table_id']) && (isset($frm_data['order_total']) && !empty($frm_data['order_total'])) || (isset($referalwallet_total) && $referalwallet_total>0) )
		        {
		        	$withdraw_id = base64_decode($frm_data['withdraw_table_id']);

		            $obj_withdraw_data = $this->WithdrawRequestModel
						            		  ->with(['seller_details'])
						                      ->where('id', $withdraw_id)
						                      ->first();



		            if($obj_withdraw_data)
		            {
		               $arr_withdraw_data = $obj_withdraw_data->toArray();

		               $seller_id    = isset($arr_withdraw_data['seller_id'])?$arr_withdraw_data['seller_id']:0;
		               $seller_fname = isset($arr_withdraw_data['seller_details']['first_name'])?$arr_withdraw_data['seller_details']['first_name']:'';
		               $seller_lname = isset($arr_withdraw_data['seller_details']['last_name'])?$arr_withdraw_data['seller_details']['last_name']:'';
		               $user_name    = $seller_fname.' '.$seller_lname;
		               // dd($arr_withdraw_data);
                        $ordettotalamt=0;
		               if(isset($arr_withdraw_data) && count($arr_withdraw_data) > 0)
		               {
                            $ordettotalamt = isset($frm_data['order_total'])?$frm_data['order_total']:'0';
		                    // $total_amount         = isset($frm_data['order_total'])?$frm_data['order_total']:'0';

                             if($referalwallet_total>0){   
                                $total_amount  = $ordettotalamt+$referalwallet_total;
                             }
                             else{
                                $total_amount  = $ordettotalamt;    
                             }
                            //added this cond 15-may-20
                            // $admin_commission_amt=0;
                            // if($total_amount>0){
                            //     $admin_commission_amt = num_format($total_amount - $arr_withdraw_data['request_amt']);
                            // }

		                   // $admin_commission_amt = num_format($total_amount - $arr_withdraw_data['request_amt']);
                             $admin_commission_amt = num_format($ordettotalamt - $arr_withdraw_data['request_amt']);



			                    // $seller_commission 	= num_format($this->seller_commission);
			                    // $admin_commission 	= 100 - $seller_commission;                    
			                    // $admin_com_amt = num_format($admin_commission * (10/100));
			                    // $seller_com_amt = num_format($total_amount - $admin_com_amt);


		                    /*Update Withdraw Request table*/

                            $seller_receivedamt  = isset($arr_withdraw_data['request_amt'])?$arr_withdraw_data['request_amt']:'0';
                            if(isset($referalwallet_total) && $referalwallet_total>0)
                            {
                                $seller_receivedamt = $seller_receivedamt+$referalwallet_total;
                            }
                            else{
                                $seller_receivedamt = $seller_receivedamt;
                            }

		                    $arr_update_withdraw_request = 
                               array('received_amt'=>$seller_receivedamt,
		                    		'status'=>1
		                    	);

		                    $update_withdraw = $this->WithdrawRequestModel
		                    					->where('id',$withdraw_id)
		                    					->update($arr_update_withdraw_request);

		                    if($update_withdraw)
		                    {

		                    	/*update order detail table */
		                    	$arr_update_order_status = array(
		                    								'withdraw_reqeust_status'=>2
		                    									);
		                    	$update_order_status = $this->OrderModel
		                    							->where('seller_id', $arr_withdraw_data['seller_id'])
		                    							->where('withdraw_request_id',$withdraw_id)
					                                	->where('order_status','1')
					                                	->update($arr_update_order_status);

                                  /*****update referal wallet****15-may-20**************/

                                  $update_referal_wallet = $this->UserReferWalletModel
                                     ->where('user_id', $arr_withdraw_data['seller_id'])
                                     ->where('withdraw_request_id',$withdraw_id)
                                     ->update($arr_update_order_status);

                                  /*****end referal wallet********************/   



		                       // if($update_order_status)
                                if($update_order_status || $update_referal_wallet)     
		                        {

                                     $seller_receivedamt  = isset($arr_withdraw_data['request_amt'])?$arr_withdraw_data['request_amt']:'0';
                                    if(isset($referalwallet_total) && $referalwallet_total>0)
                                    {
                                        $seller_receivedamt = $seller_receivedamt+$referalwallet_total;
                                    }
                                    else{
                                        $seller_receivedamt = $seller_receivedamt;
                                    }

		                        	/*Store Admin Commission*/
				                    $arr_admin_commission = 
                                    array(
				                      'withdraw_request_id'   =>$withdraw_id,
				                      'seller_id'   =>$arr_withdraw_data['seller_id'],
				                      'total_pay_amt'         =>$total_amount,
				                      'admin_commission_amt'  =>$admin_commission_amt,
				                      // 'seller_commission_amt' =>$arr_withdraw_data['request_amt']
                                     'seller_commission_amt' => $seller_receivedamt
				                     );
				                    
				                    $insert = $this->AdminCommissionModel->create($arr_admin_commission);
				                    if($insert)
				                    {
                                        $withdraw_bal_status =  $this
                                            ->WithdrawalBalanceModel
                                            ->where('seller_id',$arr_withdraw_data['seller_id'])
                                            ->where('refund_balance_status',"0")
                                            ->sum('balance_amount');  

                                        if(($withdraw_bal_status!=0) || ($withdraw_bal_status!=''))
                                        {     
                                            $arr_withdrawal_balance_data =[];
                                            $arr_withdrawal_balance_data['refund_balance_status'] = "1";
                                            $arr_withdrawal_balance_data['withdraw_request_id']   = $arr_withdraw_data['id'];

                                            $update_withdraw_refund_balance = $this
                                                ->WithdrawalBalanceModel
                                                ->where('seller_id',$arr_withdraw_data['seller_id'])
                                                ->where('refund_balance_status',"0")
                                                ->update($arr_withdrawal_balance_data);

                                            $arr_update_withdraw_request = array(
                                                                    'previous_uncleared_balance'=>$withdraw_bal_status
                                                                );

                                            $update_withdraw = $this->WithdrawRequestModel
                                                ->where('id',$withdraw_id)
                                                ->update($arr_update_withdraw_request);
                                        } //if withdraw bal status
				                    	/***********Send Notification to seller (START)*********************/
				                    		$withdrawal_url = url('/').'/seller/wallet';

				                    		$admin_id = 0;
							                								                
							                $admin_role = Sentinel::findRoleBySlug('admin');        
							                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
							                if($admin_obj)
							                {
							                    $admin_id = $admin_obj->user_id;            
							                }


							                $arr_event                 = [];
							                $arr_event['from_user_id'] = $admin_id;
							                $arr_event['to_user_id']   = $seller_id;

                                            if(($withdraw_bal_status!=0) || ($withdraw_bal_status!=''))
                                            { 
                                                $rem_with_bal = $arr_withdraw_data['request_amt']+$referalwallet_total - $withdraw_bal_status;


							                    $arr_event['description']  = html_entity_decode(config('app.project.admin_name').' has completed <a target="_blank" href="'.$withdrawal_url.'">withdrawal request</a> for amount <b>$'.$arr_withdraw_data['request_amt'].'</b> with deduction of previous refund amount of <b>$'.$withdraw_bal_status.'</b> Amount Received: <b>$'.$rem_with_bal.'</b>'); 
                                            }
                                            else
                                            {
                                                 $selamt = 0;
                                            
                                                 $selamt = $arr_withdraw_data['request_amt']+$referalwallet_total;

                                                // $arr_event['description']  = html_entity_decode(config('app.project.admin_name').' has completed <a target="_blank" href="'.$withdrawal_url.'">withdrawal request</a> for amount <b>$'.$arr_withdraw_data['request_amt'].'</b> .'); 

                                                 $arr_event['description']  = html_entity_decode(config('app.project.admin_name').' has completed <a target="_blank" href="'.$withdrawal_url.'">withdrawal request</a> for amount <b>$'.$selamt.'</b> .'); 


                                            }
							                $arr_event['type']         = '';
							                $arr_event['title']        = 'Withdrawal Request Completion';

							                $this->GeneralService->save_notification($arr_event);

										/***********Send Notification to seller (END)***********************/

										/****************Send Mail Notification to Seller (START)***********/

                                        if(($withdraw_bal_status!=0) || ($withdraw_bal_status!=''))
                                        { 
                                            $rem_with_bal = $arr_withdraw_data['request_amt']+$referalwallet_total - $withdraw_bal_status;
											$msg    = html_entity_decode(config('app.project.admin_name').' has completed withdrawal request for amount <b>$'.$arr_withdraw_data['request_amt'].'</b> with deduction of previous refund amount of <b>$'.$withdraw_bal_status.'</b> Amount Received: <b>$'.$rem_with_bal.'</b>. ');
                                        }
                                        else
                                        {   

                                            $selamt = 0;

                                            $selamt = $arr_withdraw_data['request_amt']+$referalwallet_total;

                                            // $msg    = html_entity_decode(config('app.project.admin_name').' has completed withdrawal request for amount <b>$'.$arr_withdraw_data['request_amt'].'</b>');

                                            //$msg    = html_entity_decode(config('app.project.admin_name').' has completed withdrawal request for amount <b>$'.$selamt.'</b>');
                                        }
							                
							                //$subject     = 'Withdrawal Request Completion';

							                $arr_built_content = ['SELLER_NAME'   => $user_name,
							                                      'APP_NAME'      => config('app.project.name'),
							                                      //'MESSAGE'     => $msg,
                                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                                  'AMOUNT'        => '$'.$selamt,
							                                      'URL'           => $withdrawal_url
							                                     ];

							                $arr_mail_data['email_template_id'] = '113';
							                $arr_mail_data['arr_built_content'] = $arr_built_content;
							                $arr_mail_data['arr_built_subject'] = '';
							                $arr_mail_data['user']              = Sentinel::findById($seller_id);

							                $this->EmailService->send_mail_section($arr_mail_data);

										/****************Send Mail Notification to Seller (END)*************/



                                        /*-------------------------------------------------------
                                        |   Activity log Event
                                        --------------------------------------------------------*/
                                          
                                        //save sub admin activity log 

                                        if(isset($user) && $user->inRole('sub_admin'))
                                        {
                                            $arr_event                 = [];
                                            $arr_event['action']       = 'COMPLETE';
                                            $arr_event['title']        = $this->module_title;
                                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has completed withdraw request of '.$user_name.'.';

                                            $result = $this->UserService->save_activity($arr_event); 
                                        }

                                        /*--------------------------------------------------------------*/

    				                    $arr_response['status']      = 'success';
    				                    $arr_response['description'] = 'Withdraw request completed successfully';
				        
				                    }//if insert
				                    else
				                    {
				                        $arr_response['status'] = 'error';
				                        $arr_response['description'] = 'Unable to complete withdraw request, Please try again';
				                    }
		                        }//if update order status
		                        else
		                        {
		                        	$arr_response['status'] = 'error';
		                        	$arr_response['description'] = 'Unable to complete withdraw request, Please try again';

		                        }

		                        /*end*/
		                    }//if $update_withdraw
		                    else
		                    {
		                    	$arr_response['status'] = 'error';
		                    	$arr_response['description'] = 'Unable to complete withdraw request, Please try again';
		                    }
		                    /*end*/                    
		               }//if $arr_withdraw_data
		               else
		               {
		                    $arr_response['status'] = 'error';
		                    $arr_response['description'] = 'Unable to complete withdraw request, Please try again';
		               }
		            } //if obj withdraw
		            else
		            {
		                $arr_response['status'] = 'error';
		                $arr_response['description'] = 'Unable to complete withdraw request, Please try again';
		            }
		        }//if order total 
		        else
		        {
		            $arr_response['status'] = 'error';
		            $arr_response['description'] = 'Unable to complete withdraw request, Please try again';
		        }
		        DB::commit();
		    }
            catch(\Exception $e)
            {
                DB::rollback();
                // $e->getMessage();

                $arr_response['status']      = 'error';
                $arr_response['description'] = 'Something went wrong while complete withdraw request, Please try agian.';

            }
        return response()->json($arr_response);
    }
}
