<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TradeModel;
use App\Models\ChatModel;
use App\Models\DisputeModel;
use App\Models\GeneralSettingsModel;
use App\Models\TransactionModel;
use App\Models\BlockchainTransactionModel;
use App\Common\Services\TradeService;
use App\Common\Services\EmailService;
use App\Common\Services\UserService;

use Sentinel;

class ChatController extends Controller
{
    /*
	|  	Author : Sagar B. Jadhav
    |  	Date   : 05 March 2019
    */

    public function __construct(TradeModel $TradeModel,
    							ChatModel $ChatModel,
                                DisputeModel $DisputeModel,
                                GeneralSettingsModel $GeneralSettingsModel,
                                TransactionModel $TransactionModel,
                                BlockchainTransactionModel $BlockchainTransactionModel,
                                TradeService $TradeService,
                                EmailService $EmailService,
                                UserService $UserService
                            ) 
    {	
    	$this->TradeModel         = $TradeModel;
    	$this->BaseModel          = $ChatModel;
        $this->DisputeModel       = $DisputeModel;
        $this->GeneralSettingsModel  = $GeneralSettingsModel;
        $this->BlockchainTransactionModel = $BlockchainTransactionModel;
        $this->TransactionModel   = $TransactionModel;
        $this->TradeService       = $TradeService;
        $this->EmailService       = $EmailService;
        $this->UserService        = $UserService;
        $this->module_title       = "Seller And Buyer Chat";
        $this->module_view_folder = "admin.trades";
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/trades/chat"); 
        $this->module_crypto_url_path    = url(config('app.project.admin_panel_slug')."/CashMarkets/chat"); 
        $this->profile_img_public_path = url('/').config('app.project.img_path.user_profile_image');
        $this->chat_attachment_img_base_path = base_path().config('app.project.chat_attachment');
        $this->chat_attachment_img_public_path = url('/').config('app.project.chat_attachment');
        $this->arr_view_data      = [];
    }

    public function index($enc_trade_id = false,$enc_user_id)
    {
    	$trade_arr = $seller_trade_arr = [];
    	$trade_id = base64_decode($enc_trade_id);
    	$user_id = base64_decode($enc_user_id);

    	if(Sentinel::check())
    	{
    		$admin_id = Sentinel::check()->id;
    	}

    	$trade_obj = $this->TradeModel->with(['product_details',
    										 'category_details',
    										 'user_details',
    										 'unit_data',
    										 'seller_details.user_details',
                                             'user_details.buyer_detail'])
    								  ->where('id',$trade_id)->first();

    	if($trade_obj)
    	{
    		$trade_arr = $trade_obj->toArray();
    	}

    	$seller_id   = $trade_arr['seller_details']['user_details']['id'];
    	$buyer_id 	 = $trade_arr['user_details']['id'];
    	
     	$msg_id_arr  = [$admin_id,$seller_id,$buyer_id];

        // $msg_id_arr  = [$user_id,$admin_id];

        $seller_trade_id = $trade_arr['linked_to'];

    	$chat_arr = $this->BaseModel->with(['sender_details','receiver_details'])
    								// ->where('trade_id',$trade_id)
                                    ->where('seller_trade_id',$seller_trade_id)
    								->whereIn('receiver_id',$msg_id_arr)
     								->whereIn('sender_id',$msg_id_arr)
    								->get()->toArray();

        /****************get seller trade details*************************************/
        $seller_trade_obj = $this->TradeModel->where('id',$trade_arr['linked_to'])->first();

        if($seller_trade_obj)
        {
            $seller_trade_arr = $seller_trade_obj->toArray();
        }

        /*******************************************************************************/

        /**************************Dispute START***********************************/
            $usdc_contract_address   = GeneralSettingsModel::where('data_id','USDC_CONTACT_ADDRESS')
                                                        ->first();

            $escrow_contract_address = GeneralSettingsModel::where('data_id','ESCROW_CONTRACT_ADDRESS')->first();

            $escrow_contract_address_for_crypto = GeneralSettingsModel::where('data_id','ESCROW_CONTRACT_ADDRESS_FOR_CRYPTO')->first();

            $arr_dispute = [];
            $obj_dispute =$this->DisputeModel->with(['user_detail'])
                                              ->whereHas('trade_detail',function($q){
                                                return $q->where('trade_status','3');
                                              })
                                             ->where('trade_id',$trade_id)
                                             ->where('is_dispute_finalized','0')
                                             ->first();

            if($obj_dispute)
            {
                $arr_dispute = $obj_dispute->toArray();
            }
            
            $this->arr_view_data['escrow_contract_address_for_crypto'] = $escrow_contract_address_for_crypto;
            $this->arr_view_data['usdc_contract_address']   = $usdc_contract_address;
            $this->arr_view_data['escrow_contract_address'] = $escrow_contract_address;
            $this->arr_view_data['arr_dispute'] = isset($arr_dispute)?$arr_dispute:[];
        /**************************Dispute END ************************************/

        /****************************USDC Dispute START*****************************/
            $arr_usdc_dispute = [];
            $obj_usdc_dispute = $this->DisputeModel->with(['user_detail'])
                                              ->whereHas('trade_detail',function($q){
                                                return $q->where('crypto_trade_status','2');
                                              })
                                             ->where('trade_id',$trade_id)
                                             ->where('is_dispute_finalized','0')
                                             ->first();
            if($obj_usdc_dispute)
            {
                $arr_usdc_dispute = $obj_usdc_dispute->toArray();
            }

            $this->arr_view_data['arr_usdc_dispute'] = isset($arr_usdc_dispute)?$arr_usdc_dispute:[];
        /****************************USDC Dispute END*******************************/


 		$this->arr_view_data['page_title']               = "View ".str_plural($this->module_title);        
        $this->arr_view_data['module_title']             = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['module_crypto_url_path']   = $this->module_crypto_url_path;
        $this->arr_view_data['trade_id']          		 = $trade_id;
        $this->arr_view_data['user_id']          		 = $user_id;
        $this->arr_view_data['trade_arr']          		 = $trade_arr;
        $this->arr_view_data['chat_arr']          		 = $chat_arr;
        $this->arr_view_data['admin_id']          		 = $admin_id;
        $this->arr_view_data['buyer_id']          		 = $buyer_id;
        $this->arr_view_data['seller_trade_arr']         = $seller_trade_arr;
        $this->arr_view_data['attachment_img_public_path']   = $this->chat_attachment_img_public_path;
        $this->arr_view_data['attachment_img_base_path']   = $this->chat_attachment_img_base_path;

        return view($this->module_view_folder.'.chat',$this->arr_view_data);
    }

    public function send_message(Request $request)
    {
    	$sender_id = $admin_id = $receiver_id = $seller_id = 0;
        $file_name= Null;

    	if(Sentinel::check()==true)
    	{
    		$sender_id = Sentinel::check()->id;    		
    	}

    	//here sender is admin and receiver is buyer
    	$trade_id    = $request->input('trade_id');
    	$receiver_id = $request->input('receiver_id');
    	$message     = $request->input('message');    

        //attachment upload        
        if($request->hasFile('attachment'))
        {
            $file_extension = strtolower($request->file('attachment')->getClientOriginalExtension());          

            if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $file_name = time().uniqid().'.'.$file_extension;                    
                $request->file('attachment')->move($this->chat_attachment_img_base_path, $file_name);
            }
            else
            {
                $response['status']  = 'ERROR';
                $response['message'] = 'Please select valid profile image, only jpg,png and jpeg file are alowed';

                return response()->json($response);
            }            
        } 


        $obj_trade = $this->TradeModel->with(['seller_details'])
                                ->where('id',$trade_id)->first();

        $seller_trade_id = 0;
        if($obj_trade)
        {
            $seller_trade_id = $obj_trade->linked_to;
            $seller_id       = $obj_trade->seller_details->user_id;
        }

        // $message_data['trade_id']       = $trade_id;    
    	
        $message_data['seller_trade_id']  = $seller_trade_id;	
    	$message_data['receiver_id']      = $receiver_id;
    	$message_data['sender_id']        = $sender_id;
    	$message_data['message']          = $message;
        $message_data['role']             = 'Checker';
    	$message_data['is_viewed']        = '0';
        $message_data['attachment']       = $file_name or Null;

    	$is_store = $this->BaseModel->create($message_data);	

    	if($is_store)
    	{
            /*********************Send Email Notification START***********************/
                //Send Email to Buyer
                $trade_ref = '';
                $obj_trade = $this->TradeModel->where('id',$seller_trade_id)->first();
                if($obj_trade)
                {
                   $trade_ref = $obj_trade->trade_ref;
                }

                $buyer_chat_url       = url('/').'/buyer/chat';

                if(isset($file_name) && $file_name != Null){
                    $chat_msg = 'Checker has uploaded file for trade '.$trade_ref;
                }else{
                    $chat_msg = html_entity_decode('Checker sent message for trade <b>'.$trade_ref.'</b><br> Message : '.$message);
                }

                $arr_event                 = [];
                $arr_event['from_user_id'] = $sender_id;
                $arr_event['to_user_id']   = $receiver_id; // Buyer
                $arr_event['message']      = $chat_msg;
                $arr_event['url']          = $buyer_chat_url;
                $arr_event['subject']      = 'Chat';

                $this->save_notification($arr_event);

                //Send Email to Seller
                $seller_chat_url       = url('/').'/seller/chat';

                $arr_event                 = [];
                $arr_event['from_user_id'] = $sender_id;
                $arr_event['to_user_id']   = $seller_id;
                $arr_event['message']      = $chat_msg;
                $arr_event['url']          = $seller_chat_url;
                $arr_event['subject']      = 'Chat';

                $this->save_notification($arr_event);


         /*********************Send Email Notification END*************************/

    		return response()->json(['status'=>'success']);
    	}
    	else
    	{
    		return response()->json(['status'=>'error']);
    	}
    }

    public function get_message(Request $request)
    {
    	$trade_id           = $request->input('trade_id');
    	$retrieved_id 		= $request->input('last_retrieved_id');
    	$last_retrieved_id  = '';

    	if($retrieved_id!=null)
        {
            $last_retrieved_id = $retrieved_id;
        }

    	$trade_obj = $this->TradeModel->with(['seller_details.user_details'])->where('id',$trade_id)->first();

    	if($trade_obj)
    	{
    		$trade_arr = $trade_obj->toArray();
    	}
    	   
        $seller_trade_id = $trade_arr['linked_to'];

    	//this admin id getting logic work only if there is one admin,if multiple admin come then logic will be diffrent    	
    	$admin_role = Sentinel::findRoleBySlug('admin');   		
    	$admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();

    	if($admin_obj)
    	{
   			$admin_id = $admin_obj->user_id;    		
    	}

    	$sender_id   = $trade_arr['user_id'];
    	$receiver_id = $trade_arr['seller_details']['user_details']['id'];

        $msg_id_arr  = [$admin_id,$sender_id,$receiver_id];

     	// dd($request->all(),$msg_id_arr);

    	$chat_arr = $this->BaseModel->with(['sender_details','receiver_details'])
    								->where('id','>',$last_retrieved_id)
    								->whereIn('receiver_id',$msg_id_arr)
     								->where('sender_id','!=',$admin_id)
                                    // ->where('trade_id',$trade_id)
     								->where('seller_trade_id',$seller_trade_id)
     								->get()->toArray();


     	if(count($chat_arr)>0)
     	{
     		$response['status'] 	=	'SUCCESS';
     		$response['chat_arr'] 	= 	$chat_arr;     		
     		$response['profile_img_public_path']         = $this->profile_img_public_path;
            $response['chat_attachment_img_base_path']   = $this->chat_attachment_img_base_path;
            $response['chat_attachment_img_public_path'] = $this->chat_attachment_img_public_path;
     	}
     	else
     	{
     		$response['status'] 	=	'FAILURE';
     		$response['chat_arr'] 	= 	[];     		
     		$response['profile_img_public_path'] =$this->profile_img_public_path;
     	}

     	return response()->json($response);
    }


    //Store transaction in transaction table and also store settlement amount of seller and buyer in trade table
    public function store_transaction(Request $request)
    {       
        $user = Sentinel::check();

        $admin_id = 0;
        if(Sentinel::check())
        {
            $admin_id = Sentinel::check()->id;
        }

        $form_data = $request->all();

        $trade_seller_amount = isset($form_data['disputeSellerAmount'])?$form_data['disputeSellerAmount']:0;

        $trade_buyer_amount = isset($form_data['disputeBuyerAmount'])?$form_data['disputeBuyerAmount']:0;

        $transaction_ref = isset($form_data['txHash'])?$form_data['txHash']:'';

        $trade_id = isset($form_data['trade_id'])?$form_data['trade_id']:'';

        $total_price = isset($form_data['total_price'])?$form_data['total_price']:0;

        $update_trade = $this->TradeModel->where('id',$trade_id)
                                         ->update(['trade_settlement_seller'=>$trade_seller_amount,
                                                   'trade_settlement_buyer' =>$trade_buyer_amount,
                                                   'is_disputed'            => '1',
                                                   'trade_status'           => '4'
                                            ]);

        /*Update is_dispute_finalized = 1 in trade_dispute table*/
        $this->DisputeModel->where('trade_id',$trade_id)
                           ->update(['is_dispute_finalized'=>'1']);

        //update order status
        $this->TradeService->update_order_status($trade_id);


        /*Store data into transaction table*/

        $trans_data = [ 
                            'trade_id'        => $trade_id,
                            'transaction_ref' => $transaction_ref,
                            'total_price'     => $total_price,
                            'payment_status'  => '1', // Complete
                            'user_id'         => $admin_id
                      ];

        $transaction = $this->TransactionModel->create($trans_data);

        if($transaction)
        {   
            $blockchain_data['user_id']      = $admin_id;
            $blockchain_data['trans_hash']   = $transaction_ref;
            $blockchain_data['trade_id']     = $trade_id;
            $blockchain_data['action']       = 'dispute_settlement';

            $this->BlockchainTransactionModel->create($blockchain_data);   

            /*************Notification START*********************/ 

                /************Send Notification to Buyer START*******/
                    $from_user_id  = 0;
                    $buyer_user_id = 0;
                    $user_name     = "";
                    $trade_ref     = "";

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        $user_name    = 'Checker';
                    }

                    $obj_trade = $this->TradeModel->where('id',$trade_id)
                                                  ->first();

                    if($obj_trade)
                    {
                        $arr_trade     = $obj_trade->toArray();
                        $buyer_user_id = $arr_trade['user_id'];
                        $trade_ref     = $arr_trade['trade_ref'];
                    }

                    $buyer_link = url('/').'/buyer/trade/view/'.base64_encode($trade_id);

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $buyer_user_id;
                    $arr_event['message']      = html_entity_decode($user_name.' settled dispute for trade <b>'.$trade_ref.'</b>');
                    $arr_event['url']          = $buyer_link;
                    $arr_event['subject']      = 'Dispute Settlement';

                    $this->save_notification($arr_event);

                /************Send Notification to Buyer END*******/

                /*******Send Notification to Seller START*********/
                    $seller_user_id = 0;
                    $obj2_trade = $this->TradeModel->where('id',$trade_id)
                                         ->with(['seller_details'])
                                         ->first();

                    if($obj2_trade)
                    {
                        $arr_trade      = $obj2_trade->toArray();
                        $seller_user_id = $arr_trade['seller_details']['user_id'];
                    }

                    $seller_link = url('/').'/seller/trade/interested-buyer-details/'.base64_encode($trade_id);

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $seller_user_id;
                    $arr_event['message']      = html_entity_decode($user_name.' settled dispute for trade <b>'.$trade_ref.'</b>');
                    $arr_event['url']          = $seller_link;
                    $arr_event['subject']      = 'Dispute Settlement';

                    $this->save_notification($arr_event);

                /*******Send Notification to Seller END*********/

            /*************Notification END***********************/ 


            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DISPUT SETTLEMENT';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has dispute settlement.';

                    $result = $this->UserService->save_activity($arr_event); 
                }


            /*----------------------------------------------------------------------*/

            $response['status']      = 'success';
            $response['description'] = 'Dispute Settlement Successfully.';
        }
        else
        {
            $response['status']      = 'error';
            $response['description'] = 'Error while doing dispute settlement.';
        }

        return response()->json($response);
    }

    public function store_usdc_transaction(Request $request)
    {
        $user = Sentinel::check();

        $admin_id = 0;
        if(Sentinel::check())
        {
            $admin_id = Sentinel::check()->id;
        }

        $form_data       = $request->all();
        

        $transaction_ref = isset($form_data['txHash'])?$form_data['txHash']:'';

        $trade_id        = isset($form_data['trade_id'])?$form_data['trade_id']:'';

        $total_price     = isset($form_data['total_price'])?$form_data['total_price']:0;
       
        $action          = isset($form_data['action'])?$form_data['action']:'';

        $update_trade = $this->TradeModel->where('id',$trade_id)
                                         ->update([
                                                   'is_disputed'         => '1',
                                                   'crypto_trade_status' => '4'
                                            ]);

        /*Update is_dispute_finalized = 1 in trade_dispute table*/
        $this->DisputeModel->where('trade_id',$trade_id)
                           ->update(['is_dispute_finalized'=>'1']);

        //update order status
        //$this->TradeService->update_usdc_order_status($trade_id);
        $this->TradeService->update_trades_status($trade_id);


        /*Store data into transaction table*/

        $trans_data = [ 
                            'trade_id'        => $trade_id,
                            'transaction_ref' => $transaction_ref,
                            'total_price'     => $total_price,
                            'payment_status'  => '1', // Complete
                            'user_id'         => $admin_id,
                            'payment_data'    => json_encode($form_data)
                      ];

        $transaction = $this->TransactionModel->create($trans_data);

        if($transaction)
        {   
            $blockchain_data['user_id']      = $admin_id;
            $blockchain_data['trans_hash']   = $transaction_ref;
            $blockchain_data['trade_id']     = $trade_id;
            $blockchain_data['action']       = $action;

            $this->BlockchainTransactionModel->create($blockchain_data);   

            /*************Notification START*********************/ 

                /************Send Notification to Buyer START*******/
                    $from_user_id  = 0;
                    $buyer_user_id = 0;
                    $user_name     = "";
                    $trade_ref     = "";

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        $user_name    = 'Checker';
                    }

                    $obj_trade = $this->TradeModel->where('id',$trade_id)
                                                  ->first();

                    if($obj_trade)
                    {
                        $arr_trade     = $obj_trade->toArray();
                        $buyer_user_id = $arr_trade['user_id'];
                        $trade_ref     = $arr_trade['trade_ref'];
                    }

                    $buyer_link = url('/').'/buyer/CashMarkets/view/'.base64_encode($trade_id);

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $buyer_user_id;
                    $arr_event['message']      = html_entity_decode($user_name.' settled dispute for trade <b>'.$trade_ref.'</b>');
                    $arr_event['url']          = $buyer_link;
                    $arr_event['subject']      = 'Dispute Settlement';

                    $this->save_notification($arr_event);

                /************Send Notification to Buyer END*******/

                /*******Send Notification to Seller START*********/
                    $seller_user_id = 0;
                    $obj2_trade = $this->TradeModel->where('id',$trade_id)
                                         ->with(['seller_details'])
                                         ->first();

                    if($obj2_trade)
                    {
                        $arr_trade      = $obj2_trade->toArray();
                        $seller_user_id = $arr_trade['seller_details']['user_id'];
                    }

                    $seller_link = url('/').'/seller/CashMarkets/interested-buyer-details/'.base64_encode($trade_id);

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $seller_user_id;
                    $arr_event['message']      = html_entity_decode($user_name.' settled dispute for trade <b>'.$trade_ref.'</b>');
                    $arr_event['url']          = $seller_link;
                    $arr_event['subject']      = 'Dispute Settlement';

                    $this->save_notification($arr_event);

                /*******Send Notification to Seller END*********/

            /*************Notification END***********************/ 

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DISPUT SETTLEMENT';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has dispute settlement.';

                    $result = $this->UserService->save_activity($arr_event); 
                }


            /*----------------------------------------------------------------------*/


            $response['status']      = 'success';
            $response['description'] = 'Dispute Settlement Successfully.';
        }
        else
        {
            $response['status']      = 'error';
            $response['description'] = 'Error while doing dispute settlement.';
        }

        return response()->json($response);

    }

    public function cancel_trade(Request $request)
    {   
        $user = Sentinel::check();
        
        $admin_id = 0;
        if(Sentinel::check())
        {
            $admin_id = Sentinel::check()->id;
        }

        $form_data = $request->all();

        $trade_id = isset($form_data['trade_id'])?$form_data['trade_id']:'';

        $update_trade = $this->TradeModel->where('id',$trade_id)
                                         ->update([
                                                   'is_disputed'            => '1',
                                                   // 'crypto_trade_status'    => '4',
                                                   'is_cancelled'           => '1'
                                            ]);

        /*Update is_dispute_finalized = 1 in trade_dispute table*/
        $update_status =  $this->DisputeModel->where('trade_id',$trade_id)
                           ->update(['is_dispute_finalized'=>'1']);

        

        if($update_status)
        {       
            $from_user_id  = 0;
            $buyer_user_id = 0;
            $user_name     = "";
            $trade_ref     = "";

            /***********Update the sold out quantity for seller***********/
                //Get trade details
                $obj_trade = $this->TradeModel->where('id',$trade_id)
                                                      ->first();

                if($obj_trade)
                {
                    $arr_trade     = $obj_trade->toArray();
                    $buyer_user_id = $arr_trade['user_id'];
                    $trade_ref     = $arr_trade['trade_ref'];
                }

               //Get seller trade details
                $obj_seller_trade = $this->TradeModel
                                          ->where('id',$arr_trade['linked_to'])
                                          ->first();

                if($obj_seller_trade)
                {
                    $arr_seller_trade = $obj_seller_trade->toArray();
                }

                $buyer_quantity = isset($arr_trade['quantity'])?$arr_trade['quantity']:0;
                $seller_sold_out_quantity = isset($arr_seller_trade['sold_out_qty'])?$arr_seller_trade['sold_out_qty']:0;

                $updated_sold_out_qty = $seller_sold_out_quantity - $buyer_quantity;

                //Update the sold out quantity of seller
                $this->TradeModel->where('id',$arr_trade['linked_to'])
                             ->update(['sold_out_qty'=>$updated_sold_out_qty]);


            /**************************************************************/

            //update order status
            // $this->TradeService->update_usdc_order_status($trade_id);

            /*************Notification START*********************/ 

                /************Send Notification to Buyer START*******/
                    

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        $user_name    = 'Checker';
                    }

                    $buyer_link = url('/').'/buyer/CashMarkets/view/'.base64_encode($trade_id);

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $buyer_user_id;
                    $arr_event['message']      = html_entity_decode($user_name.' settled dispute for trade <b>'.$trade_ref.'</b>');
                    $arr_event['url']          = $buyer_link;
                    $arr_event['subject']      = 'Dispute Settlement';

                    $this->save_notification($arr_event);

                /************Send Notification to Buyer END*******/

                /*******Send Notification to Seller START*********/
                    $seller_user_id = 0;
                    $obj2_trade = $this->TradeModel->where('id',$trade_id)
                                         ->with(['seller_details'])
                                         ->first();

                    if($obj2_trade)
                    {
                        $arr_trade      = $obj2_trade->toArray();
                        $seller_user_id = $arr_trade['seller_details']['user_id'];
                    }

                    $seller_link = url('/').'/seller/CashMarkets/interested-buyer-details/'.base64_encode($trade_id);

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $seller_user_id;
                    $arr_event['message']      = html_entity_decode($user_name.' settled dispute for trade <b>'.$trade_ref.'</b>');
                    $arr_event['url']          = $seller_link;
                    $arr_event['subject']      = 'Dispute Settlement';

                    $this->save_notification($arr_event);

                /*******Send Notification to Seller END*********/

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DISPUT SETTLEMENT';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has dispute settlement.';

                    $result = $this->UserService->save_activity($arr_event); 
                }


            /*----------------------------------------------------------------------*/



            /*************Notification END***********************/ 

            $response['status']      = 'success';
            $response['description'] = 'Dispute Settlement Successfully.';
        }
        else
        {
            $response['status']      = 'error';
            $response['description'] = 'Error while doing dispute settlement.';
        }

        return response()->json($response);
    }

    

}
