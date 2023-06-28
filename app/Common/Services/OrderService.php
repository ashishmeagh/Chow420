<?php

namespace App\Common\Services;


use App\Models\TempBagModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\EmailTemplateModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use App\Common\Services\GeneralService;
use App\Common\Services\ProductService;
use Carbon\Carbon;
use Sentinel;
use App\Models\OrderAddressModel;
use App\Models\SiteSettingModel;
use App\Models\DisputeModel;
use App\Models\EventModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\DropShipperModel;
use App\Models\SellerModel;
use App\Common\Services\EmailService;
use App\Models\CouponModel;
use App\Models\BuyerCouponModel;
use App\Models\DeliveryOptionsModel;
use App\Models\BuyerRegisteredReferModel;
use App\Models\BuyerWalletModel;




use Omnipay\Common\Exception\InvalidCreditCardException;

 

use Mail;
use DB;
use PDF,Storage;
use Excel;
use Session;

use Omnipay\Omnipay;
use App\Payment;

class OrderService 
{

	public function __construct(TempBagModel $TempBagModel,
								ProductModel $ProductModel,
								OrderProductModel $OrderProductModel,
								GeneralService $GeneralService,
								OrderModel $OrderModel,
								EmailTemplateModel $EmailTemplateModel,
								UserModel $UserModel,
								TransactionModel $TransactionModel,
								ProductService $ProductService,
								OrderAddressModel $OrderAddressModel,
								SiteSettingModel $SiteSettingModel,
								 DisputeModel $DisputeModel,
								 EventModel $EventModel,
								  CountriesModel $country,
								  StatesModel $StatesModel,
								  DropShipperModel $DropShipperModel,
								  SellerModel $SellerModel,
								  EmailService $EmailService,
								  CouponModel $CouponModel,
								  BuyerCouponModel $BuyerCouponModel,
								  DeliveryOptionsModel $DeliveryOptionsModel,
								  BuyerRegisteredReferModel $BuyerRegisteredReferModel,
								  BuyerWalletModel $BuyerWalletModel
								)
	{	
		$this->TempBagModel = $TempBagModel ; 
		$this->ProductModel = $ProductModel ; 
		$this->OrderModel = $OrderModel ; 
		$this->UserModel = $UserModel ; 
		$this->EmailTemplateModel = $EmailTemplateModel ; 
		$this->TransactionModel = $TransactionModel ; 

		$this->OrderProductModel = $OrderProductModel ; 
		$this->GeneralService = $GeneralService ; 
		$this->ProductService = $ProductService ; 

		$this->OrderAddressModel = $OrderAddressModel ; 
		$this->SiteSettingModel = $SiteSettingModel;
		$this->DisputeModel         = $DisputeModel;
		$this->EventModel     = $EventModel;
		$this->CountriesModel  = $country;
		$this->StatesModel     = $StatesModel;
		$this->DropShipperModel = $DropShipperModel;
		$this->SellerModel = $SellerModel;
		$this->EmailService = $EmailService;
		$this->CouponModel  = $CouponModel;
		$this->BuyerCouponModel = $BuyerCouponModel;
		$this->DeliveryOptionsModel = $DeliveryOptionsModel;
		$this->BuyerRegisteredReferModel = $BuyerRegisteredReferModel;
		$this->BuyerWalletModel  = $BuyerWalletModel;

		$this->location_id = config('app.project.square_Location_id');
		$this->access_token = config('app.project.square_access_token');

		$this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        //$this->gateway->setAuthName('4u83vQGH5');
        //$this->gateway->setTransactionKey('332t2CEmcNS54GpD');
       // $this->gateway->setAuthName('22EDggQ84mb');
       // $this->gateway->setTransactionKey('4Sv9AQcsp8A938zh');
       // $this->gateway->setTestMode(true); //comment this line when move to 'live'

	}			
 
 
	public function process_payment($from_data)
	{
		
		$site_setting_arr = [];

        $site_setting_obj = SiteSettingModel::first();  

        if(isset($site_setting_obj))
        {
            $site_setting_arr = $site_setting_obj->toArray();            
        }

		if(isset($site_setting_arr) && count($site_setting_arr)>0)
		{
		     $payment_mode = $site_setting_arr['payment_mode'];
		     $sandbox_url = $site_setting_arr['sandbox_url'];
		     $live_url = $site_setting_arr['live_url'];
		     $sandbox_access_token = $site_setting_arr['sandbox_access_token'];
		     $live_access_token = $site_setting_arr['live_access_token'];
		     $sandbox_location_id = $site_setting_arr['sandbox_location_id'];
		     $live_location_id = $site_setting_arr['live_location_id'];

		     $payment_gateway_switch = $site_setting_arr['payment_gateway_switch'];


		     /*********authorizenet credentail*****************/
		      $sandbox_api_loginid = $site_setting_arr['sandbox_api_loginid'];
		      $sandbox_transactionkey = $site_setting_arr['sandbox_transactionkey'];

		      $live_api_loginid = $site_setting_arr['live_api_loginid'];
		      $live_transactionkey = $site_setting_arr['live_transactionkey'];

		     /*********authorizenet credentail*****************/

		}

      	if($from_data)
      	{

      	   if(isset($from_data['testval']) && isset($from_data['amount']) && ($from_data['amount']==base64_decode($from_data['testval'])) )
      	   {

      		if($payment_gateway_switch=="square")
      		{
      			$api_config = new \SquareConnect\Configuration();


		       	if(isset($sandbox_url) && $payment_mode=='0') 
		        	$api_config->setHost($sandbox_url);	      	
		        else if(isset($live_url) && $payment_mode=='1')  
		        	$api_config->setHost($live_url);
		        
		        if(isset($sandbox_access_token) && $payment_mode=='0')
		        	$api_config->setAccessToken($sandbox_access_token);
		         elseif(isset($live_access_token) && $payment_mode=='1')
		         	$api_config->setAccessToken($live_access_token);


		      	$api_client = new \SquareConnect\ApiClient($api_config);

		      	$payments_api = new \SquareConnect\Api\PaymentsApi($api_client);
		      	

		      	$nonce = $from_data['nonce'];

		      	$body = new \SquareConnect\Model\CreatePaymentRequest();

		      	$amountMoney = new \SquareConnect\Model\Money();

	      
		      	$amountMoney->setAmount(100*ceil($from_data['amount']));
		      	$amountMoney->setCurrency("USD");

		      	$body->setSourceId($nonce);
		      	$body->setAmountMoney($amountMoney);


	         	if(isset($sandbox_location_id) && $payment_mode=='0')
		      		$body->setLocationId($sandbox_location_id);
		      	elseif(isset($live_location_id) && $payment_mode=='1')
		      		$body->setLocationId($live_location_id);


	         	$body->setIdempotencyKey(uniqid());

	      
		      	try {
		          	$result = $payments_api->createPayment($body);
		          	

			        if($result['payment']['id']){
			          	$response['status'] = "SUCCESS";
			          	$response['msg'] = "Payment Successfully Done.";
			          	$response['transaction_id'] = $result['payment']['id'];
			          	$response['authorize_transaction_status'] = '';
			          	$response['result'] = $result;
			        }
		      	} catch (\SquareConnect\ApiException $e) {
		      			$response['status'] = "failure";
			          	$response['msg'] = $e->getResponseBody();
		          	
		      	}
      		} //if payment_gateway_switch is square
      		else if($payment_gateway_switch=="authorizenet")
      		{
	      	


			       if(isset($sandbox_api_loginid) && $payment_mode=='0') 
			       {
			        	$this->gateway->setAuthName($sandbox_api_loginid);
			       }
			        if(isset($sandbox_transactionkey) && $payment_mode=='0') 
			       {
			        	$this->gateway->setTransactionKey($sandbox_transactionkey);
			       }
			        if(isset($live_api_loginid) && $payment_mode=='1') 
			       {
			        	$this->gateway->setAuthName($live_api_loginid);
			       }
			        if(isset($live_transactionkey) && $payment_mode=='1') 
			       {
			        	$this->gateway->setTransactionKey($live_transactionkey);
			       }

			       if($payment_mode=='0') 
			       {
			        	$this->gateway->setTestMode(true);
			       }
	       
	      	      if(isset($from_data['cardNumber']) && isset($from_data['expMonth']) && isset($from_data['expYear']) && isset($from_data['cardCode']) && isset($from_data['amount']))
	      	       {
				      	 try
				      	 {
				            $creditCard = new \Omnipay\Common\CreditCard([
				                'number' => $from_data['cardNumber'],
				                'expiryMonth' => $from_data['expMonth'],
				                'expiryYear' => $from_data['expYear'],
				                'cvv' => $from_data['cardCode'],
				            ]);

		                    // Generate a unique merchant site transaction ID.
		                    $transactionId = rand(100000000, 999999999);
		 				
		 				   try{

		 					  $payresponse = $this->gateway->authorize([
				                'amount' => $from_data['amount'],
				                'currency' => 'USD',
				                'transactionId' => $transactionId,
				                'card' => $creditCard,
				               ])->send();
		 					 

		 					   if($payresponse->isSuccessful()) 
					            {
					 
					                $transactionReference = $payresponse->getTransactionReference();
					               
					 
					                $payresponse = $this->gateway->capture([
					                    'amount' => $from_data['amount'],
					                    'currency' => 'USD',
					                    'transactionReference' => $transactionReference,
					                    ])->send();
					                    
			                    
					                $transaction_id = $payresponse->getTransactionReference();
									 if($transaction_id)
									 {

									 	/***************fetch transaction responce************/
									 	$authorized_transaction_status ='';
									 	$getresponse = $this->gateway->fetchTransaction([
								            'transactionReference' => $transaction_id,
								        ])->send();
								        if($getresponse)
								        {
									        $parsedata = $getresponse->getParsedData();
									        if(isset($parsedata) && !empty($parsedata)){
									        	$authorized_transaction_status = isset($parsedata->data['transaction']['transactionStatus'])?$parsedata->data['transaction']['transactionStatus']:'';
									        }//if parsedata								        
									      
								        }//if getresponse
										/***************fetch transaction responce*****/

										$response['authorize_transaction_status'] = $authorized_transaction_status;
							          	$response['status'] = "SUCCESS";
							          	$response['msg'] = "Payment Successfully Done.";
							          	$response['transaction_id'] = $transaction_id;
							          	$response['result'] = '';
						            }		               
					 
					            } else {
					            	//dd($payresponse->getMessage());
					                $response['status'] = "cardmonthfailure";
				                    $response['msg'] = $payresponse->getMessage();
					            }
			 				}//try
			 				catch(\Exception $e)
					        {
					          	
					              $response['status'] = "cardyearfailure";
					              $response['msg'] = $e->getMessage();

					        }

			           }//try 
			           catch(\Exception $e)
			           {
			           	
			              $response['status'] = "failure";
			              $response['msg'] = $e->getMessage();

			           }
		          
	               }//if all payment fields
	               else
	               {
	            	   $response['status'] = "failure";
	      		       $response['msg'] = 'Please enter all payment details';
	               }
            }//else if pyament gateway swtich if authorizenet
          }//if amount matched

      	}//if form data
      	else{
      		
	      	$response['status'] = "failure";
      	    //$response['msg'] = 'Payment not processing';
      		$response['msg'] = $e->getMessage();
      	}
      	return $response;
      	
	}

	/*Description: After payment success bag should be empty*/
	public function clear_bag($buyer_id)
	{
		if ($buyer_id) {
			
			$clear_bag = $this->TempBagModel->where('buyer_id',$buyer_id)->delete();

			if ($clear_bag) {
				$response['status'] = "SUCCESS";

			}
			else {
				$response['status'] = "failure";
			}

		}
		else{

			$response['status'] = "failure";
		}
		return $response;
	}

	public function generate_order($transaction_id=false,$order_addr_data,$payment_status,$authorize_transaction_status)
	{
		$buyer_profile_url='';
        $loggedInUserId = $order_id = 0;
        $user = \Sentinel::check();

        if($user && $user->inRole('buyer'))
        {
           $loggedInUserId = $user->id;
           $first_name = isset($user->first_name)?$user->first_name:"";
	       $last_name  = isset($user->last_name)?$user->last_name:"";  

	       $setname='';
	       if($first_name==" " || $last_name==" "){
	       	$setname = $user->email;
	       }	       	
	       else
	       {
	       	$setname = $user->first_name;
	       }
        }
        else
        {
        	$response_arr['status']   = 'failure';        		
        	return $response_arr;
        }       
        
        //check ip_address and user_session_id
    	$bag_data = $this->TempBagModel->where('buyer_id',$loggedInUserId)                                       
    								   ->first(['product_data']);	
    	
    	$bag_data  = isset($bag_data['product_data'])?$bag_data['product_data']:"";
        $bag_arr   = json_decode($bag_data,true);
       	
       	$arr_product = $bag_arr['product_id'];
       	
        $result = [];

        // dd($arr_product);



        $site_setting_arr = [];

        $site_setting_obj = SiteSettingModel::first();  

        if(isset($site_setting_obj))
        {
            $site_setting_arr = $site_setting_obj->toArray();            
        }

		if(isset($site_setting_arr) && count($site_setting_arr)>0)
		{
		    $payment_mode = $site_setting_arr['payment_mode'];
		    $payment_gateway_switch = $site_setting_arr['payment_gateway_switch'];
		}





        if(isset($arr_product) && count($arr_product) > 0)
        {
        	foreach ($arr_product as $key => $value) 
	        {
	        	$result[$value['seller_id']][$key]['product_id'] = $value['product_id'];
	        	$result[$value['seller_id']][$key]['item_qty'] = $value['item_qty'];
	        	$result[$value['seller_id']][$key]['seller_id'] = $value['seller_id'];
	        	// $result[$value['seller_id']][$key]['product_data'] = $this->ProductModel->with(['user_details'])->where('id',$value['product_id'])->first();

	        	$result[$value['seller_id']][$key]['product_data'] = $this->ProductModel->with(['user_details','product_images_details'])->where('id',$value['product_id'])->first();
	        	
	        	if($result[$value['seller_id']][$key]['product_data']['price_drop_to']>0){

	        		$result[$value['seller_id']][$key]['total_price'] = $result[$value['seller_id']][$key]['product_data']['price_drop_to'] * $result[$value['seller_id']][$key]['item_qty'];	  

	        	}else{

	        		$result[$value['seller_id']][$key]['total_price'] = $result[$value['seller_id']][$key]['product_data']['unit_price'] * $result[$value['seller_id']][$key]['item_qty'];

	        	}

	        	if($result[$value['seller_id']][$key]['product_data']['shipping_type']==1){

	        		$result[$value['seller_id']][$key]['shipping_type'] = $result[$value['seller_id']][$key]['product_data']['shipping_type'];	  
	        		$result[$value['seller_id']][$key]['shipping_charges'] = $result[$value['seller_id']][$key]['product_data']['shipping_charges'];	  

	        	}else{

	        		$result[$value['seller_id']][$key]['shipping_charges'] = 0;	    
	        		$result[$value['seller_id']][$key]['shipping_type'] = 0;	    

	        	}

	        }
        }

        


        try
        {
        	DB::beginTransaction();
        	if(count($result)>0)
        	{

        		$order_no = str_pad('CH',  10, rand('1234567890',10)); 

        		$total_tax_amount = 0; $tax_amt = 0; $shipping_amt = 0; $total_shipping_amount = 0;
    
        		
        		foreach ($result as $key => $product_arr) 
		        {

		        	$checkcouponcodeforseller = $setproductids = $checkcouponproduct = $sessioncoupon_data = [];
                    $get_total_amountofsellers = []; $totalpriceofseller = [];

                    // code for coupon code
                    if(is_array(Session::get('sessioncoupon_data')) && !empty(Session::get('sessioncoupon_data')))
                    {
                      $sessioncoupon_data =  Session::get('sessioncoupon_data');
                    }

                    // code for delivery option

                    $sessiondeliveryoption_data = $totalpriceof_optionseller = [];
                   if(is_array(Session::get('sessiondeliveryoption_data')) && !empty(Session::get('sessiondeliveryoption_data')))
                   {
                     $sessiondeliveryoption_data =  Session::get('sessiondeliveryoption_data');
                   // dd($sessiondeliveryoption_data);
                   }
                   


                     // code for wallet amount
                    if(is_array(Session::get('sessionwallet_data')) && !empty(Session::get('sessionwallet_data')))
                    {
                      $sessionwallet_data =  Session::get('sessionwallet_data');
                    }
   	  			  

		        	
		        	$total_retail_price = 0;
		        	$shipping_charges_total = 0;
		        	$dropshipperprice = '';
		        	$age_restriction ='';
		        	$buyerageverificationflag =0;
		        	$getbuyerdetails =[];
		        	$update_buyerage = [];
		        	
		        	$total_price = array_sum(array_column($product_arr,'total_price'));
		        	$shipping_charges_total = array_sum(array_column($product_arr,'shipping_charges'));

		        	//calculate tax
		           $calculate_tax = 0;
                   $calculate_tax = calculate_tax_getting_details($key,$loggedInUserId,$total_price,$shipping_charges_total);
                   $tax_amt = isset($calculate_tax)?$calculate_tax:0;
                   $total_tax_amount = $total_tax_amount+$tax_amt;


                   $shipping_amt = isset($shipping_charges_total)?$shipping_charges_total:0;
                   $total_shipping_amount = $total_shipping_amount+ $shipping_amt;
				   //tax calculation according seller

				   // $seller_taxes = [];
				   // $seller_taxes[$key] = $key;
				   // $seller_taxes['tax'] = isset($calculate_tax)?$calculate_tax:0;	                       

		        	$order_arr = [];
		        	$order_arr['seller_id']              = $key;
		        	$order_arr['order_no']              = $order_no;
				    $order_arr['buyer_id']           	= $loggedInUserId;
				    $order_arr['status']                = 0;
				    $order_arr['transaction_id']        = $transaction_id or '';
				    $order_arr['order_status']       	 = '2'; //Order is ongoing				    
				    $order_arr['total_amount'] = $total_price + $shipping_charges_total;

				    $order_arr['card_last_four'] = isset($order_addr_data['cardNumber'])?substr($order_addr_data['cardNumber'], -4):'';

				    $order_arr['authorize_transaction_status'] = isset($authorize_transaction_status)?$authorize_transaction_status:''; 

				    $order_arr['payment_gateway_used'] = isset($payment_gateway_switch)?$payment_gateway_switch:'';

				    $order_arr['tax'] = isset($calculate_tax)?$calculate_tax:'';

		        	$create_order = $this->OrderModel->create($order_arr); // create order


		          



		        	//update order id and order no for referer user
                    $is_refered_buyer = $user->is_refered_buyer;
                    if(isset($is_refered_buyer) && $is_refered_buyer==1 && 
                    	$user->is_refered_buyer_order_placed==0)
                    {
                    	$arr_buyer_refered = [];
				        $arr_buyer_refered['order_id'] = $create_order->id;
				        $arr_buyer_refered['order_no'] = $create_order->order_no;
				       	$this->BuyerRegisteredReferModel->where('referal_id',$loggedInUserId)->update($arr_buyer_refered);

				       	$is_refered_buyer_order_placed =[];
				       	$is_refered_buyer_order_placed['is_refered_buyer_order_placed'] =1;
				       	$this->UserModel->where('id',$loggedInUserId)->update($is_refered_buyer_order_placed);

                    }//if is buyer refered and order place


                    if(isset($sessionwallet_data['buyer']) && isset($sessionwallet_data['amount']))
   	  			    {       
   	  			    	$buyer_wallet_tbl = [];
   	  			    	$buyer_wallet_tbl['user_id'] = $user->id;
   	  			    	$buyer_wallet_tbl['type'] = 'OrderPlaced';
   	  			    	$buyer_wallet_tbl['typeid'] = $create_order->order_no;
   	  			    	$buyer_wallet_tbl['amount'] = isset($sessionwallet_data['amount'])?'-'.$sessionwallet_data['amount']:'';
   	  			    	$buyer_wallet_tbl['status'] = 2; //withdraw


   	  			    	$create_wallet = $this->BuyerWalletModel->create($buyer_wallet_tbl);


   	  			        if($create_wallet)
   	  			        {
   	  			        	
   	  			        	 $update_order_walletid = [];		
		        	         $update_order_walletid['buyer_wallet_id'] = isset($create_wallet->id)?$create_wallet->id:0;

		        		     $update_order_wallet = $this->OrderModel->where('order_no',$create_order->order_no)->update($update_order_walletid);
   	  			        } //create_wallet		
   	  			    } // sessionwallet_data

		        	
		        	
		        	foreach($product_arr as $product)
		        	{
		        	
		        		$order_product_arr = [];
		        		$order_product_arr['order_id'] 		= $create_order->id;
		        		$order_product_arr['product_id']    = $product['product_id'];
		        		$order_product_arr['quantity']      = $product['item_qty'];
		        		    
		        		$getdropshipperid = $this->ProductModel->where('id',$product['product_id'])->first();
		        		if(isset($getdropshipperid) && !empty($getdropshipperid))
		        		{
		        			$getdropshipperid = $getdropshipperid->toArray();
		        			$dropshipid       = isset($getdropshipperid['drop_shipper'])?$getdropshipperid['drop_shipper']:'';
		        			$order_product_arr['dropshipper_id'] = $dropshipid;

		        			    if(isset($dropshipid) && isset($product['product_id']))
                                {
                                  $getdropshipperinfo = get_dropshipper_info($dropshipid,$product['product_id']);

                                   $dropshipperprice ='';
                                  if(isset($getdropshipperinfo) && !empty($getdropshipperinfo))
                                  {
                                     $dropshipperprice = isset($getdropshipperinfo['unit_price'])?$getdropshipperinfo['unit_price']:'';

                                     $order_product_arr['dropshipper_price'] = $dropshipperprice;

                                  }//if getdropshipperinfo 
                                }//if dropshipper id and product id

 							$get_catinfo = $this->ProductModel
 							     ->with('first_level_category_details','first_level_category_details.age_restriction_detail')
 							    ->where('id',$product['product_id'])->first();	

                            // if(isset($getdropshipperid['is_age_limit']) && !empty($getdropshipperid['is_age_limit']))
                            // {
                            // 	 $age_restriction = isset($getdropshipperid['age_restriction'])?$getdropshipperid['age_restriction']:''; 
                            // 	 $order_product_arr['age_restriction'] = $age_restriction;
                            // }     

 							if(isset($get_catinfo) && !empty($get_catinfo)) 
 							{   
 								$get_catinfo = $get_catinfo->toArray();

	 						     if(isset($get_catinfo['first_level_category_details']['is_age_limit']) && !empty($get_catinfo['first_level_category_details']['is_age_limit']))
	                            {
	                            	 $age_restriction = isset($get_catinfo['first_level_category_details']['age_restriction'])?$get_catinfo['first_level_category_details']['age_restriction']:''; 
	                            	 $order_product_arr['age_restriction'] = $age_restriction;
	                            }     	
                            }//if isset getcatinfo    

		        		} //if product info     

		        		if($product['shipping_type']==1)
		        		{
		        			$order_product_arr['shipping_charges']=$product['shipping_charges'];
		        		}
		        		else{
		        			$order_product_arr['shipping_charges']=0;

		        		}
		        		if($product['product_data']['price_drop_to']>0){
		        			$order_product_arr['unit_price']    = $product['product_data']['price_drop_to'];	        			
		        		}else{
		        			$order_product_arr['unit_price']    = $product['product_data']['unit_price'];
		        		}




		        		/**********coupon code start*****************************/

			    			if(isset($sessioncoupon_data[$key])){             
		                        foreach($sessioncoupon_data as $ks=>$val){
		                           if($ks==$product['product_data']['user_id'])  {
		                             

		                           	 // $totalpriceofseller[$ks][$product['product_id']]['total'] = 
		                             // $order_product_arr['unit_price']*$order_product_arr['quantity'] + $order_product_arr['shipping_charges'];

		                           	$totalpriceofseller[$ks][$product['product_id']]['total'] = 
		                             $order_product_arr['unit_price']*$order_product_arr['quantity'];

		                             $totalpriceofseller[$ks][$product['product_id']]['couponid'] = $val['couponcodeId'];
		                             $totalpriceofseller[$ks][$product['product_id']]['productid'] = 
		                                $product['product_data']['id'];

		                             $totalpriceofseller[$ks][$product['product_id']]['couponcode'] = $val['couponcode'];
		                             $totalpriceofseller[$ks][$product['product_id']]['discount'] = $val['discount'];

		                             $totalpriceofseller[$ks][$product['product_id']]['type'] = $val['type'];
		                           
		                           }//if userid
		                        }//if sessiondata
		                    }//if sessioncoupondata

		                  
		                 /**********delivery option start*****************************/   

		                 if(isset($sessiondeliveryoption_data[$key])){             
		                        foreach($sessiondeliveryoption_data as $ks1=>$val1){
		                           if($ks1==$product['product_data']['user_id'])  {
		                             
	                          
		                             $totalpriceof_optionseller[$ks1][$product['product_id']]['id'] = $val1['delivery_option_id'];
		                             $totalpriceof_optionseller[$ks1][$product['product_id']]['productid'] = 
		                                $product['product_data']['id'];

		                             $totalpriceof_optionseller[$ks1][$product['product_id']]['day'] = $val1['day'];
		                             $totalpriceof_optionseller[$ks1][$product['product_id']]['cost'] = $val1['cost'];

		                             $totalpriceof_optionseller[$ks1][$product['product_id']]['title'] = $val1['title'];
		                           
		                           }//if userid
		                        }//if sessiondata
		                    }//if session deliverydata

		                /**********delivery option end*****************************/       




		        		$create_order_product = $this->OrderProductModel->create($order_product_arr);

		        		$update_stock = $this->ProductService->update_remaining_stock($product['product_id'],$product['item_qty']);


		        		/******Add Event on order place*********/
		        			  
		        			 if(!empty($product['product_data']['product_images_details']) 
                                                 && count($product['product_data']['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$product['product_data']['product_images_details'][0]['image']) &&  $product['product_data']['product_images_details'][0]['image']!='')
                               {
                                 /* $imgsrc = url('/').'/uploads/product_images/'.$product['product_data']['product_images_details'][0]['image'];*/

                                  //image_resize

                                 $imgsrc = image_resize('/uploads/product_images/'.$product['product_data']['product_images_details'][0]['image'],35,35);


                               }else{
                                $imgsrc = url('/').'/assets/front/images/chow.png';
                               }  	

 
	                      $arr_eventdata             = [];
	                      $arr_eventdata['user_id']  = $loggedInUserId;
	                      $arr_eventdata['message']  = '<div class="discription-marq">
                           <div class="mainmarqees-image">
                             <img src="'.$imgsrc.'" alt="">
                           </div><b> Someone </b> just purchased '.$product['product_data']['product_name'].'. <div class="clearfix"></div></div><a target="_blank" href="'.url('/').'/search/product_detail/'.base64_encode($product['product_data']['id']).'" class="viewcls">View</a>';
	                      $arr_eventdata['title']    = 'New Order Placed';                       
	                      $this->EventModel->create($arr_eventdata);
			    		/******end of event*****************/

			    		/**********add*age flag**********************/
			    			$getbuyerdetails = get_buyer_details($loggedInUserId);
			    			if(isset($getbuyerdetails['buyer_detail']) && !empty($getbuyerdetails['buyer_detail']))
			    			{
			    				$buyerage_verificationstatus = $getbuyerdetails['buyer_detail']['approve_status'];
			    			}

			    			// if(isset($getdropshipperid['is_age_limit']) && !empty($getdropshipperid['is_age_limit']) && isset($getdropshipperid['age_restriction']) && !empty($getdropshipperid['age_restriction']) && isset($buyerage_verificationstatus) && $buyerage_verificationstatus!="1")
          //                   {
          //                   	 $buyerageverificationflag++;
          //                   }     

			    			if(isset($get_catinfo) && !empty($get_catinfo)) 
 							{   
 								//$get_catinfo = $get_catinfo->toArray();
 								
	 						     if(isset($get_catinfo['first_level_category_details']['is_age_limit']) && !empty($get_catinfo['first_level_category_details']['is_age_limit'])  && isset($get_catinfo['first_level_category_details']['age_restriction']) && !empty($get_catinfo['first_level_category_details']['age_restriction']) && isset($buyerage_verificationstatus) && $buyerage_verificationstatus!="1")
	                            {
	                            	 $buyerageverificationflag++;
	                            }     	
                            }//if isset getcatinfo    



			    		/**********end of age flag****************/





		                    


		                     $newarr = [];  $seller_totalall_amt =0;
		                      if(isset($totalpriceofseller) && !empty($totalpriceofseller)){
			                      foreach($totalpriceofseller as $k2=>$v2)
			                      {

			                         $newarr[$k2]['seller'] = $k2;
			                         $newarr[$k2]['sellername'] = get_seller_details($key);

			                          foreach($v2 as $prd=>$data)
			                          {
			                            $newarr[$k2]['discount'] = $data['discount'];
			                            $newarr[$k2]['couponcode'] = $data['couponcode'];
			                            $newarr[$k2]['couponid'] = $data['couponid'];
			                            $newarr[$k2]['total'][] = $data['total'];
			                            $newarr[$k2]['type'] = $data['type'];
			                         }

			                         $newarr[$k2]['seller_total_amt'] = array_sum($newarr[$k2]['total']);

			                         if(isset($newarr[$k2]['discount']))
			                         {
			                            $newarr[$k2]['seller_discount_amt'] = $newarr[$k2]['seller_total_amt']*$newarr[$k2]['discount']/100;

			                             $seller_totalall_amt += $newarr[$k2]['seller_discount_amt'];
			                         }

			                      }//foreach
			                      
		                     }//if totalpriceofseller for coupon

		                    
			    		/*********coupon code end*************************************/	


			    		/****************delivery option start****************/
			    			  $newarr_options = [];  $seller_totalall_option_amt =0;
		                      if(isset($totalpriceof_optionseller) && !empty($totalpriceof_optionseller)){
			                      foreach($totalpriceof_optionseller as $k22=>$v22)
			                      {

			                         $newarr_options[$k22]['seller'] = $k22;
			                         $newarr_options[$k22]['sellername'] = get_seller_details($key);

			                          foreach($v22 as $prd=>$data)
			                          {
			                            $newarr_options[$k22]['id'] = $data['id'];
			                            $newarr_options[$k22]['cost'] = $data['cost'];
			                            $newarr_options[$k22]['title'] = $data['title'];
			                            $newarr_options[$k22]['day'] = $data['day'];
			                         }

			                         if(isset($newarr_options[$k22]['cost']))
			                         {
			                            $newarr_options[$k22]['seller_option_amt'] = $newarr_options[$k22]['cost'];

			                             $seller_totalall_option_amt += $newarr_options[$k22]['cost'];
			                         }

			                      }//foreach
			                      
		                     }//if totalpriceofseller for coupon

			    		/****************delivery option end*****************/



		        	}//end of foreach

		        	$order_id = $create_order->id;


		        	//if isset new arr of coupon code data

		        	 $total_coupoun_amount = 0; $coupon_amount = 0;
		        	 if(isset($newarr) && !empty($newarr))
		        	 {
		        		$update_coupon = []; $buyerusedcoupon = [];
		        		foreach($newarr as $k=>$v)
		        		{
		        			if($key==$v['seller']){

		        		     $coupon_amount = $v['seller_discount_amt'];	
		        		     $total_coupoun_amount =$total_coupoun_amount+$coupon_amount;	

		        			$update_coupon['couponid'] = $v['couponid'];
		        			$update_coupon['couponcode'] = $v['couponcode'];
		        			$update_coupon['discount'] = $v['discount'];
		        		    $update_coupon['seller_discount_amt'] = $v['seller_discount_amt'];
		        		    $update_coupon['coupontype'] =  $v['type'];
		        		    $update_couponorders = $this->OrderModel->where('id',$order_id)
		        	               ->update($update_coupon);

		        	        $buyerusedcoupon['code'] = $v['couponcode']; 
		        	        $buyerusedcoupon['type'] = $v['type']; 
		        	        $buyerusedcoupon['seller_id'] = $v['seller'];    
		        	        $buyerusedcoupon['buyer_id'] = $loggedInUserId;    

		        	        $check_exists_couponcode = $this->BuyerCouponModel->where('code',$v['couponcode'])->where('buyer_id',$loggedInUserId)->where('seller_id',$v['seller'])->where('type',$v['type'])->get();   

		        	        if(isset($check_exists_couponcode) && !empty($check_exists_couponcode))
		        	        {
		        	        	$check_exists_couponcode = $check_exists_couponcode->toArray();
		        	        } 

		        	       

		        	        if(isset($check_exists_couponcode) && !empty($check_exists_couponcode))
		        	        {
		        	        	
		        	        }else{
		        	        	
		        	          $updateentryinusedcoupon = $this->BuyerCouponModel->insert(
		        	        	$buyerusedcoupon);
		        	        }//else
	        	       
                                                   

		        		   }//if key is same as seller		        			
		        		} // if foreach        			        		

		        	  }// if newarr of coupon code data



		        	 /************isset delivery option***********/

		        	   $total_delivery_option_amount = 0; $delivery_cost = 0;
		        	     if(isset($newarr_options) && !empty($newarr_options))
		        	   {
		        		  $update_deliveryoption = [];
		        		  foreach($newarr_options as $k3=>$v3)
		        		  {
		        			if($key==$v3['seller'])
		        			{
		        				$delivery_cost = isset($v3['cost'])?$v3['cost']:0;
		        				$total_delivery_option_amount = $total_delivery_option_amount+$delivery_cost;

			        			$update_deliveryoption['delivery_option_id'] = isset($v3['id'])?$v3['id']:'';
			        			$update_deliveryoption['delivery_cost'] = isset($v3['cost'])?$v3['cost']:'';
			        			$update_deliveryoption['delivery_title'] = isset($v3['title'])?$v3['title']:'';
			        		   // $update_deliveryoption['seller_discount_amt'] = $v3['seller_discount_amt'];
			        		    $update_deliveryoption['delivery_day'] = isset($v3['day'])?$v3['day']:'';
			        		    $update_optionsorders = $this->OrderModel->where('id',$order_id)
			        	               ->update($update_deliveryoption);

      	        		    }//if key is same as seller		        			
		        		  } // if foreach        			        		

		        	     }// if newarr_options of delivery data

						/*************end delivery option****************/


		        
		        	$is_deleted = $this->TempBagModel->where('buyer_id',$loggedInUserId)->delete();

		        	/************update*buyer*age*flag********************/
		        	if(isset($buyerageverificationflag) && $buyerageverificationflag>0)
		        	{
		        	     $update_buyerage = [];		
		        	     $update_buyerage['buyer_age_restrictionflag'] = 1;
		        		 $update_order_buyerageflag = $this->OrderModel->where('id',$order_id)
		        	               ->update($update_buyerage);
		        	}
		        	 /***********end*update*buyer*age*flag********************/  



		        	/********************Send Notification to Seller (START)**************************/
		        	
		        	    //get order details 

		        	    $order_details = $this->OrderModel->where('id',$order_id)->first();

		        	    if(isset($order_details))
		        	    {
                           $order_details_arr = $order_details->toArray();
		        	    }

                        if(isset($order_details_arr['buyer_age_restrictionflag']) && $order_details_arr['buyer_age_restrictionflag'] == 1)
                        {
                            
                            $seller_order_url = url('/').'/seller/age_restricted_order/view/'.base64_encode($create_order->id);
                        }
                        else
                        {
                           $seller_order_url = url('/').'/seller/order/view/'.base64_encode($create_order->id);
                        }
		        		

			        	$arr_event                 = [];
				        $arr_event['from_user_id'] = $loggedInUserId;
				        $arr_event['to_user_id']   = $key;
				        $arr_event['description']  = 'New order placed from '.$first_name.' '.$last_name.'. Order No : <a target="_blank" href="'.$seller_order_url.'">'. $order_no.'</a>';
				        $arr_event['title']        = 'New Order Placed';
				        $arr_event['type']         = 'seller'; 	

			          	$this->GeneralService->save_notification($arr_event);

			        /********************Send Notification to Seller (END)**************************/             

		     	 
		        }//end of foreach

		        	// cashback percentage code starts
		            $cashback_amount =0;
                   if(isset($site_setting_arr['cashback_percentage']) && !empty($site_setting_arr['cashback_percentage']))
		           {
		           	 

		           	    $cashback_amount = (($order_addr_data['amount']-$total_tax_amount-$total_shipping_amount)*$site_setting_arr['cashback_percentage'])/100;


		           	   	if(isset($cashback_amount) && $cashback_amount>0)
		           	   	{



		           	    $buyer_wallet_tbl = [];
   	  			    	$buyer_wallet_tbl['user_id'] = $user->id;
   	  			    	$buyer_wallet_tbl['type']   = 'Cashback';
   	  			    	$buyer_wallet_tbl['typeid'] = $create_order->order_no;
   	  			    	$buyer_wallet_tbl['amount'] = isset($cashback_amount)?'+'.number_format($cashback_amount,2):'';
   	  			    	$buyer_wallet_tbl['status'] = 0; //pending
  	  			    	$create_wallet = $this->BuyerWalletModel->create($buyer_wallet_tbl);

  	  			    	//send notification to buyer for cashback

  	  			    	$buyer_wallet_url = url('/').'/buyer/wallet';
  	  			    	$admin_id = get_admin_id();

  	  			    	$arr_event                 = [];
				        $arr_event['from_user_id'] = $admin_id;
				        $arr_event['to_user_id']   = $loggedInUserId;
				        $arr_event['description']  = 'Buyer '.$first_name.' '.$last_name.' you will get cashback of amount $'.number_format($cashback_amount,2).' when order get completed having Order No : <a target="_blank" href="'.$buyer_wallet_url.'">'. $order_no.'</a>';
				        $arr_event['title']        = 'Cashback';
				        $arr_event['type']         = 'buyer'; 	

			          	$this->GeneralService->save_notification($arr_event);

			          	//SEND EMAIL TO USER

		          	    $arr_built_content = 
	                    ['USER_NAME'     => $first_name.' '.$last_name,
	                    'APP_NAME'      => config('app.project.name'),
	                    //  'MESSAGE'       => $msg,
	                    'AGE_URL'       => $buyer_wallet_url,
	                    'ORDER_NO'      => $order_no,
	                    'CASHBACK_AMOUNT'=> '$'.number_format($cashback_amount,2)
	                    ];
	                    $arr_built_subject =  [
	                    'ORDER_NO'      => $order_no
	                    ];    

	                    $arr_mail_data['email_template_id'] = '156';
	                    $arr_mail_data['arr_built_content'] = $arr_built_content;
	                    $arr_mail_data['arr_built_subject'] = $arr_built_subject;
	                    $arr_mail_data['user']              = Sentinel::findById($loggedInUserId);
	                    $this->EmailService->send_mail_section_order($arr_mail_data);  

	                 }//if cashback amount


		           }//cashback_percentage code end



		        $save_address = $this->checkout_order_address($order_addr_data,$order_no);


		        if(isset($sessionwallet_data['buyer']) && isset($sessionwallet_data['amount']))
   	  			 {       

   	  			   	 $transaction_arr['buyer_wallet_amount'] = $sessionwallet_data['amount'];
   	  			 }


		        $transaction_arr['user_id'] 			= $loggedInUserId;
	        	$transaction_arr['order_no']			= $order_no or '';
	        	$transaction_arr['transaction_id'] 		= $transaction_id;
	        	$transaction_arr['total_price'] 		= $order_addr_data['amount'];
	        	$transaction_arr['transaction_status'] 	= $payment_status or '2';
	        	$transaction_arr['cashback']            =  (isset($cashback_amount) && $cashback_amount>0)?number_format($cashback_amount,2):''; 
	        	$transaction_arr['cashback_percentage']  =  (isset($site_setting_arr['cashback_percentage']) && !empty($site_setting_arr['cashback_percentage']))?$site_setting_arr['cashback_percentage']:''; 
	        	
		        $this->store_transaction_details($transaction_arr);
		       		
		       	/********************Send Notification to Admin(START)*************************/
		       		$admin_id = get_admin_id();

			        $first_name = isset($user->first_name)?$user->first_name:"";
			        $last_name  = isset($user->last_name)?$user->last_name:"";  

			        $admin_order_placed_url = url('/').'/'.config('app.project.admin_panel_slug').'/order/view/'.base64_encode($order_no).'/'.base64_encode($order_id);

			        $arr_event                 = [];
			        $arr_event['from_user_id'] = $loggedInUserId;
			        $arr_event['to_user_id']   = $admin_id;
			        $arr_event['description']  = 'New order placed from '.$first_name.' '.$last_name.'. Order No : <a target="_blank" href="'.$admin_order_placed_url.'">'.$order_no.'</a>';
			        $arr_event['title']        = 'New Order Placed';
			        $arr_event['type']         = 'admin'; 	

			    	$this->GeneralService->save_notification($arr_event);
			    /********************Send Notification to Admin(END)***********/

			    /*****send notification and email to buyer for age link******/
			    	 $buyerdetails = get_buyer_details($loggedInUserId);	
			    	 
			    	 if(isset($buyerdetails['buyer_detail']) && !empty($buyerdetails['buyer_detail']))
			    	 {
			    		$buyerage_verifystatus = $buyerdetails['buyer_detail']['approve_status'];
			    		if($buyerage_verifystatus!=1 &&  isset($buyerageverificationflag) && $buyerageverificationflag>0)
			    		{

			    			$buyer_profile_url = url('/').'/buyer/age-verification';
			    			

			    			/*old code for send mail and notification to the buyer for age verification*/
			    			//start noti
			    /*			$arr_event                 = [];
					        $arr_event['from_user_id'] = $admin_id;
					        $arr_event['to_user_id']   = $loggedInUserId;
					        $arr_event['description']  = ' Please <a target="_blank" href="'.$buyer_profile_url.'">click here</a> to further verify your age for the order to be shipped. This is the only time you will be required to verify your age on Chow420. ';
					        $arr_event['title']        = 'Age verification Link';
					        $arr_event['type']         = 'buyer'; 
					    	$this->GeneralService->save_notification($arr_event);

					    	//start email
		                   $arr_built_content = ['USER_NAME'     => $buyerdetails['first_name'].' '.$buyerdetails['last_name'],
			                                      'APP_NAME'      => config('app.project.name'),
			                                    //  'MESSAGE'       => $msg,
			                                      'AGE_URL'       => $buyer_profile_url
			                                     ];
			                 

			                $arr_mail_data['email_template_id'] = '134';
			                $arr_mail_data['arr_built_content'] = $arr_built_content;
			                $arr_mail_data['arr_built_subject'] = '';
			                $arr_mail_data['user']              = Sentinel::findById($loggedInUserId);

			                $this->EmailService->send_mail_section($arr_mail_data);  
*/


			                /*-----------------------------------------------------*/
                            /*new code for send mail and notification to the buyer for age verification*/

			                //send noti
		                    $arr_event                 = [];
		                    $arr_event['from_user_id'] = $admin_id;
		                    $arr_event['to_user_id']   = $loggedInUserId;
		                    $arr_event['description']  = ' Please <a target="_blank" href='.$buyer_profile_url.'>click here</a> to further verify your age for the order '.$order_no.' to be shipped. This is the only time you will be required to verify your age on Chow420.';
		                    $arr_event['title']        = 'Pending age-verification for order '.$order_no.'';
		                    $arr_event['type']         = 'buyer';   
		                    $this->GeneralService->save_notification($arr_event);

		                    
		                    //send email
		                    $arr_built_content = 
		                    ['USER_NAME'     => $buyerdetails['first_name'].' '.$buyerdetails['last_name'],
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
		                    $arr_mail_data['user']              = Sentinel::findById($loggedInUserId);
		                    $this->EmailService->send_mail_section_order($arr_mail_data);  




							$site_setting_arr = [];

					        $site_setting_obj = SiteSettingModel::first();  

					        if(isset($site_setting_obj))
					        {
					            $site_setting_arr = $site_setting_obj->toArray();            
					        }

							if(isset($site_setting_arr) && count($site_setting_arr)>0)
							{
							     $twilio_account_sid = isset($site_setting_arr['twilio_account_sid'])?$site_setting_arr['twilio_account_sid']:'';
							     $twilio_auth_token = isset($site_setting_arr['twilio_auth_token'])?$site_setting_arr['twilio_auth_token']:'';
							     $twilio_from_number = isset($site_setting_arr['twilio_from_number'])?$site_setting_arr['twilio_from_number']:'';

							}//isset site setting arr
		






		                    	$phonecode ='';
		                       //send text notification
		                      if(isset($buyerdetails['phone']) && $buyerdetails['phone']!='')
		                      {	

		                      	$getbuyercountry = isset($buyerdetails['country'])? get_countryDetails($buyerdetails['country']):'';
		                      	if(isset($getbuyercountry) && !empty($getbuyercountry))
		                      	{
		                      		$phonecode = isset($getbuyercountry['phonecode'])?$getbuyercountry['phonecode']:'';

		                      		$account_sid = isset($twilio_account_sid)?$twilio_account_sid: config('app.project.account_sid');
						            $auth_token = isset($twilio_auth_token)?$twilio_auth_token:config('app.project.auth_token');

						            $url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/SMS/Messages";
						            $to = "+".$phonecode.$buyerdetails['phone'];

						            $from = isset($twilio_from_number)?$twilio_from_number:config('app.project.from'); // twilio trial 

						            // $body = "Please click here ".$buyer_profile_url." for order ".$order_no." to shipped.";

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


			    		}//if age verification flag not approved

			    	 }//if isset buyerdetails


			    /******send notification and email to buyer for age link****/ 			


			          $buyer_email_id = $this->UserModel->where('id',$loggedInUserId)->pluck('email')->first();

			          $email_status = $this->send_email_to_users($result,$order_no,$buyer_email_id,$user);

			            $admin_email = 0;

                    	$admin_details = $this->UserModel->where('id',1)->first();

	                    if(isset($admin_details))
	                    {
	                       $admin_email = $admin_details->email;
	                    }


                    	$email_status = $this->send_email_to_users($result,$order_no,$admin_email,$user);  
                    	$seller_email = $this->send_email_to_seller($result,$order_no,$user);
        			    $seller_dropship_email = $this->send_email_to_sellerfordropshipper($result,$order_no,$user);
        			    $dropship_send_email = $this->send_email_to_dropshipper($result,$order_no,$user);
			          //$this->send_buyer_email($order_addr_data,$order_no);

		       
		    	DB::commit();
		    	$response_arr['status']   = 'success';
		    	$response_arr['order_no'] = $order_no;
		    	$response_arr['total_amt'] = isset($order_addr_data['amount'])?$order_addr_data['amount']:'';

		    	 Session::forget('sessioncoupon_data');
 				 Session::forget('sessiondeliveryoption_data');
 				 Session::forget('sessionwallet_data');
		    	
		    	return $response_arr;
        	}
        	else
        	{	
        		$response_arr['status']   = 'failure';
        		
        		return $response_arr;
        	}

        }catch(Exception $e)
        {
        	//DB::roleback();
        	DB::rollback();
        	$response_arr['status']   = 'failure';
        	
        	return $response_arr;
        }
	}	


	public function checkout_order_address($form_data,$order_no)
	{

		if($form_data)
		{
         	$shipping_streetaddress1  = isset($form_data['shipping_addr'])?$form_data['shipping_addr']:'';
         	$shipping_country1  = isset($form_data['country'])?$form_data['country']:'';
         	$shipping_state1  = isset($form_data['state'])?$form_data['state']:'';
         	$shipping_zipcode1  = isset($form_data['zipcode'])?$form_data['zipcode']:'';
         	$shipping_city1  = isset($form_data['city'])?$form_data['city']:'';



         	$billing_streetaddress1  = isset($form_data['billing_addr'])?$form_data['billing_addr']:'';
         	$billing_country1  = isset($form_data['billing_country'])?$form_data['billing_country']:'';
         	$billing_state1  = isset($form_data['billing_state'])?$form_data['billing_state']:'';
         	$billing_zipcode1  = isset($form_data['billing_zipcode'])?$form_data['billing_zipcode']:'';
        	$billing_city1  = isset($form_data['billing_city'])?$form_data['billing_city']:'';


          	$loginuser_id     = Sentinel::Check()->id;

            $insertdata = array(
                            'user_id'=>$loginuser_id,
                            'order_id'=>$order_no,
                    
                            'shipping_address1'=>$shipping_streetaddress1,
                            'shipping_country'=>$shipping_country1,
                            'shipping_state'=>$shipping_state1,
                            'shipping_zipcode'=>$shipping_zipcode1,
                            'shipping_city'=>$shipping_city1,

                           
                            'billing_address1'=>$billing_streetaddress1,
                            'billing_country'=>$billing_country1,
                            'billing_state'=>$billing_state1,
                            'billing_zipcode'=>$billing_zipcode1,
                            'billing_city'=>$billing_city1,

                          
                            ); 
            if(!empty($insertdata))
        	{
	          	$insert = $this->OrderAddressModel->insert($insertdata);

	            if($insert){

	            	$response['status'] = "SUCCESS";
	            	
	            }else{

	            	$response['status'] = "failure";
	            	
	            }
          	}
        } 
      
        else{
			$response['status'] = "failure";
			
		}
		return $response;

	}

	public function send_buyer_email($product_arr,$order_no)
	{
		$user = Sentinel::check();
				
		$loggedIn_userId = 0;

		if($user)
		{
		    $loggedIn_userId = $user->id;
		}   

		$arr_product = $product_arr;
		$order_no = $order_no;
		$order_summary=[];
		     	 
     	if(isset($arr_product) && sizeof($arr_product)>0)
     	{
     	   	foreach ($arr_product as $key2 => $product) 
     	   	{
     	   		$product_details = get_product_details($product['product_id']);
     	   		$product_name = $product_details['product_name'];
     	   		$order[$key2]['product_name'] = $product_name;
     	   		$order[$key2]['order_no']= $order_no or '';
     	   		$order[$key2]['item_qty']     = $product['item_qty'];
     	   		$order[$key2]['unit_price']   = $product['unit_price'];


     	   		array_push($order_summary,$order[$key2]);
     	   	}

     	}

 	    $email_arr = [$user->email];
 	  	
 	  	$arr_built_content = [
 	  						'EMAIL'          => $email_arr[0],
                            'order_details'  =>  $order_summary
                           ];

        $arr_mail_data['arr_built_content']   = $arr_built_content;
        $arr_mail_data['user']                = $user;
       
        $html_build = view('front.email_template.purchase_order',$arr_mail_data)->render(); 


       
    	$content = html_entity_decode($html_build);

    	
    	
    	$send_mail = Mail::send(array(),array(), function($message) use($content,$email_arr)
        {
          	$message->from('chow420@getnada.com');
          	$message->to($email_arr)
		          ->subject('Purchase order')
		          ->setBody($content, 'text/html');
        });
	}

	public function store_transaction_details($transaction_arr)
	{
		$arr_data = $transaction_arr;

		if ($arr_data) {
			
			$store_data = $this->TransactionModel->create($transaction_arr);

			if ($store_data) {
				$response['status'] = 'success';
			}
			else
			{
				$response['status'] = 'success';
			}
		}
		else{

			$response['status'] = 'success';
		}
		return $response;
	}

	/*
		Author: Bhagyashri
		Start Date: 31-12-2019
		Invoice Email send to the buyer and Admin*/

	public function send_email_to_users($order_arr=false,$order_no,$to_mail_id=false,$user=NULL)
	{

		$arr_email = $product_name = $arr_email_template = [];
		$seller_couponcode = $seller_coupontype = '';
		$calculated_discountamt = $seller_ordertotal =$seller_totalall_amt =$seller_coupondiscount=0;
		
		$order_coupondata = [];  $order_deliveryoptiondata = []; 
		$seller_taxarr = [];

		foreach ($order_arr as $key1 => $product_data) 
		{			

			$get_orderdetailcoupondata = $this->OrderModel->where('order_no',$order_no)->where('seller_id',$key1)->first();
			
			
			if(isset($get_orderdetailcoupondata) && !empty($get_orderdetailcoupondata))
			{
				$get_orderdetailcoupondata = $get_orderdetailcoupondata->toArray();

				$order_id = isset($get_orderdetailcoupondata['id'])?$get_orderdetailcoupondata['id']:'';

				$get_orderproducts = $this->OrderProductModel->where('order_id',$order_id)->sum('shipping_charges');



				$seller_couponcode = isset($get_orderdetailcoupondata['couponcode'])?$get_orderdetailcoupondata['couponcode']:'';
				$seller_coupondiscount = isset($get_orderdetailcoupondata['discount'])?$get_orderdetailcoupondata['discount']:'0';
				$seller_coupontype = isset($get_orderdetailcoupondata['coupontype'])?$get_orderdetailcoupondata['coupontype']:'';

				if(isset($get_orderproducts) && !empty($get_orderproducts))
				{
					$seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']-$get_orderproducts:'';
				}
				else{
					$seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']:'';	
				}
				

				if(isset($seller_ordertotal) && $seller_ordertotal>0 && isset($seller_coupondiscount) && $seller_coupondiscount>0){
				   $calculated_discountamt = $seller_ordertotal*$seller_coupondiscount/100;
				}

				$seller_totalall_amt =0;
				if(isset($seller_couponcode) && isset($seller_coupondiscount) && isset($seller_coupontype) && isset($calculated_discountamt))
				{
					$order_coupondata[$key1]['couponcode'] = $seller_couponcode;
					$order_coupondata[$key1]['discount'] = $seller_coupondiscount;
					$order_coupondata[$key1]['seller_coupontype'] = $seller_coupontype;
					$order_coupondata[$key1]['seller_ordertotal'] = $seller_ordertotal;
					$order_coupondata[$key1]['seller_discount_amt'] = $calculated_discountamt;
					$order_coupondata[$key1]['sellername'] = get_seller_details($key1);
					$seller_totalall_amt += $order_coupondata[$key1]['seller_discount_amt'];
			   }//if isseet


			   // code for getting delivery option data

			   $delivery_title   = isset($get_orderdetailcoupondata['delivery_title'])?$get_orderdetailcoupondata['delivery_title']:'';
  			   $delivery_cost    = isset($get_orderdetailcoupondata['delivery_cost'])?$get_orderdetailcoupondata['delivery_cost']:'';
 			   $delivery_day     = isset($get_orderdetailcoupondata['delivery_day'])?$get_orderdetailcoupondata['delivery_day']:'';
 			   $delivery_option_id = isset($get_orderdetailcoupondata['delivery_option_id'])?$get_orderdetailcoupondata['delivery_option_id']:'';

 			   $delivery_date = isset($get_orderdetailcoupondata['created_at'])?$get_orderdetailcoupondata['created_at']:'';


 			    if(isset($delivery_title) && isset($delivery_cost) && isset($delivery_day) && isset($delivery_option_id))
				{
					$order_deliveryoptiondata[$key1]['delivery_option_id'] = $delivery_option_id;
					$order_deliveryoptiondata[$key1]['delivery_day'] = $delivery_day;
					$order_deliveryoptiondata[$key1]['delivery_title'] = $delivery_title;
					$order_deliveryoptiondata[$key1]['delivery_cost'] = $delivery_cost;
					$order_deliveryoptiondata[$key1]['sellername'] = get_seller_details($key1);
					$order_deliveryoptiondata[$key1]['delivery_date'] = $delivery_date;

				}//if isset 

 			   $get_wallet_data = $this->BuyerWalletModel->where('id',$get_orderdetailcoupondata['buyer_wallet_id'])->first();

 			   if(isset($get_wallet_data))
 			   {

 			   	 $get_wallet_data = $get_wallet_data->toArray();

 			   	 $wallet_amount_used = isset($get_wallet_data['amount'])?$get_wallet_data['amount']:'';
 			   }//get_wallet_data

				//get tax


				$tax = isset($get_orderdetailcoupondata['tax'])?$get_orderdetailcoupondata['tax']:0;
				if(isset($tax) && !empty($tax))
				{
					$seller_taxarr[$key1]['sellername'] =  get_seller_details($key1);
					$seller_taxarr[$key1]['tax'] =  $tax;
				}

			}//get_orderdetailcoupondata

			
			
		
        	foreach ($product_data as $key2 => $product) 
			{

              



	 	   		$arr_email[$key1] = $product['product_data']['user_details']['email'];

	 	   		$product_name 				  = isset($product['product_data']['product_name'])?$product['product_data']['product_name']:'';
	 	   		$order[$key2]['order_no']     = $order_no or '';
	 	   		$order[$key2]['product_name'] = $product_name;
	 	   		$order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;


	 	   		$order[$key2]['seller_name']     = get_seller_details($product['seller_id']);
	 	   		$order[$key2]['seller_email']     = get_seller_email($product['seller_id']);

	 	   		if($product['product_data']['price_drop_to']>0)
	 	   		{
	 	   			$order[$key2]['unit_price']   = isset($product['product_data']['price_drop_to'])?$product['product_data']['price_drop_to']:0;
	 	   			$order[$key2]['total_wholesale_price'] = $product['product_data']['price_drop_to']*$product['item_qty'];
	 	   		}else{

	 	   			$order[$key2]['unit_price']   = isset($product['product_data']['unit_price'])?$product['product_data']['unit_price']:0;
	 	   			$order[$key2]['total_wholesale_price'] = $product['product_data']['unit_price']*$product['item_qty'];

	 	   		}

	 	   		if($product['product_data']['shipping_type']==1)
	 	   		{
	 	   			$order[$key2]['shipping_charges']   = isset($product['product_data']['shipping_charges'])?$product['product_data']['shipping_charges']:0;
	 	   		}else{

	 	   			$order[$key2]['shipping_charges']   = 0;
	 	   		}


	 	   		
 	   		
	 	   	}//end foreach


	 	  			 	
	 	  	
	 	    $seller[$key1]['email_id'] = $arr_email;
	 	    $address = [];

	 	    $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$order_no)->first();

	 	    if ($address_details) {
	 	    	// dd($address_details);

	 	    	$address['shipping'] = isset($address_details['shipping_address1'])?$address_details['shipping_address1']:'';
	 	    	$address['shipping_state'] = isset($address_details['state_details']['name'])?$address_details['state_details']['name']:'';
	 	    	$address['shipping_country'] = isset($address_details['country_details']['name'])?$address_details['country_details']['name']:'';
	 	    	$address['shipping_zipcode'] = isset($address_details['shipping_zipcode'])?$address_details['shipping_zipcode']:'';
	 	    	$address['shipping_city'] = isset($address_details['shipping_city'])?$address_details['shipping_city']:'';

	 	    	$address['billing'] = isset($address_details['billing_address1'])?$address_details['billing_address1']:'';
	 	    	$address['billing_state'] = isset($address_details['billing_state_details']['name'])?$address_details['billing_state_details']['name']:'';
	 	    	$address['billing_country'] = isset($address_details['billing_country_details']['name'])?$address_details['billing_country_details']['name']:'';
	 	    	$address['billing_zipcode'] = isset($address_details['billing_zipcode'])?$address_details['billing_zipcode']:'';
	 	        $address['billing_city'] = isset($address_details['billing_city'])?$address_details['billing_city']:'';

	 	    }


	 	    $site_setting_arr = [];
	        $site_setting_obj = SiteSettingModel::first();  
	        if(isset($site_setting_obj))
	        {
	            $site_setting_arr = $site_setting_obj->toArray();            
	        }

	 	    	
 
	 	    
		    $sum = 0;
		    $total_amount = 0;
		    $shipping_charges_sum = 0;
		    $sn_no = 0; 

			foreach ($order as $key => $order_data) 
			{ 
				$sum += $order_data['total_wholesale_price'];
				$shipping_charges_sum += $order_data['shipping_charges'];
				
				$order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
			}


			
		

	 	  	$pdf = PDF::loadView('front/invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address','site_setting_arr','user','order_coupondata','seller_totalall_amt','order_deliveryoptiondata','wallet_amount_used','seller_taxarr'));


	 	  	
           	$currentDateTime = $order_no.date('H:i:s').'.pdf';
			
			Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
     	 	$pdfpath = Storage::url($currentDateTime);

     	 	$user_id = $this->UserModel->where('email',$to_mail_id)->first();

     	 	if($user_id['id'] == 1)
	        {
	          	$obj_email_template = $this->EmailTemplateModel->where('id','37')->first();

	          	if($obj_email_template)
		      	{
		        	$arr_email_template = $obj_email_template->toArray();
		        	$content 			= $arr_email_template['template_html'];
	 	        }

	 	        //Get Buyer name from order no 
	 	        $obj_buyer = $this->OrderModel->where('order_no',$order_no)
	 	        				  ->with(['buyer_details'])
	 	        				  ->first();

	 	        $buyer_name = '--';
	 	        $app_name   = '';
	 	        $buyer_fname = $buyer_lname ="";

	 	        if($obj_buyer)
	 	        {
	 	        	$arr_buyer   = $obj_buyer->toArray();
	 	        	$buyer_fname = isset($arr_buyer['buyer_details']['first_name'])?$arr_buyer['buyer_details']['first_name']:'';
	 	        	$buyer_lname = isset($arr_buyer['buyer_details']['last_name'])?$arr_buyer['buyer_details']['last_name']:'';

	 	        	if($buyer_fname=="" || $buyer_lname=="")
	 	        	{
	 	        	    $buyer_name = isset($arr_buyer['buyer_details']['email'])?$arr_buyer['buyer_details']['email']:'';	
	 	        	}else{
	 	        		$buyer_name  = $buyer_fname.' '.$buyer_lname;
	 	        	}

	 	        	
	 	        }

	 	        $app_name = config('app.project.name');

		       
				$dynamic_arr =  [
                                    '##ADMIN_NAME##',
                                    '##BUYER_NAME##',
                                    '##APP_NAME##'
                                ];

                $replace_arr =  [
                                    config('app.project.admin_name'),
                                    $buyer_name,
                                    $app_name
                                ];
               
                $content = str_replace($dynamic_arr,$replace_arr,$content);

				// $content = str_replace("##ADMIN_NAME##",$user_id['first_name'].' '.$user_id['last_name'],$content);
	        }
	        else
	        {
	          	$obj_email_template = $this->EmailTemplateModel->where('id','35')->first();

	          	if($obj_email_template)
	  			{
	    			$arr_email_template = $obj_email_template->toArray();
	    			$content = $arr_email_template['template_html'];
	    		}
	    		$content = str_replace("##BUYER_NAME##",$user_id['first_name'].' '.$user_id['last_name'],$content);
	    		$content = str_replace("##APP_NAME##",config('app.project.name'),$content);
		
	        }

	        $content = view('email.front_general',compact('content'))->render();
	        $content = html_entity_decode($content);

	    	$file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

		}//foreach
		
		$send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
        {

        	if(isset($arr_email_template) && count($arr_email_template) > 0)
        	{	
        		$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
        		$message->to($to_mail_id);
        		//$message->subject($arr_email_template['template_subject']);
        		$dysubject = str_replace("##order_no##",$order_no,$arr_email_template['template_subject']);
        		$message->subject($dysubject);
        	}
        	else
        	{	
        		
        		$admin_email = 'notify@chow420.com';
		       
        		$message->from($admin_email);
        		$message->to($to_mail_id);
        		$message->subject('New Order '.$order_no.' Placed');
        	}

			    $message->setBody($content, 'text/html');
			  	$message->attach($file_to_path);


		       
        });
		
	}//end function

	/*
		Author: Bhagyashri
		Start Date: 31-12-2019
		Invoice Email send to the seller*/

	public function send_email_to_seller($order_arr=false,$order_no,$user=NULL)
	{
		
		$sn_no = 0;

		$arr_email = $product_name = $arr_email_template = [];

		foreach ($order_arr as $key1 => $product_data) 
		{
			$order = [];

			$arr_email = Sentinel::findById($key1)->email;
			$seller[$key1]['seller_id'] = Sentinel::findById($key1);


            /***********************couponcode*start**************************/
            $seller_couponcode = $seller_coupontype = '';
		    $calculated_discountamt = $seller_ordertotal =$seller_totalall_amt =$seller_coupondiscount=0;
		
		    $order_coupondata = $order_deliveryoptiondata = [];

		    $get_orderdetailcoupondata = $this->OrderModel->where('order_no',$order_no)->where('seller_id',$key1)->first();		
			
			if(isset($get_orderdetailcoupondata) && !empty($get_orderdetailcoupondata))
			{
				$get_orderdetailcoupondata = $get_orderdetailcoupondata->toArray();

				$order_id = isset($get_orderdetailcoupondata['id'])?$get_orderdetailcoupondata['id']:'';

				$get_orderproducts = $this->OrderProductModel->where('order_id',$order_id)->sum('shipping_charges');

				$seller_couponcode = isset($get_orderdetailcoupondata['couponcode'])?$get_orderdetailcoupondata['couponcode']:'';
				$seller_coupondiscount = isset($get_orderdetailcoupondata['discount'])?$get_orderdetailcoupondata['discount']:'0';
				$seller_coupontype = isset($get_orderdetailcoupondata['coupontype'])?$get_orderdetailcoupondata['coupontype']:'';


				// $seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']:'';

				if(isset($get_orderproducts) && !empty($get_orderproducts))
				{
					$seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']-$get_orderproducts:'';
				}
				else{
					$seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']:'';	
				}


				if(isset($seller_ordertotal) && $seller_ordertotal>0 && isset($seller_coupondiscount) && $seller_coupondiscount>0){
				   $calculated_discountamt = $seller_ordertotal*$seller_coupondiscount/100;
				}


				if(isset($seller_couponcode) && isset($seller_coupondiscount) && isset($seller_coupontype) && isset($calculated_discountamt)){
				$order_coupondata[$key1]['couponcode'] = $seller_couponcode;
				$order_coupondata[$key1]['discount'] = $seller_coupondiscount;
				$order_coupondata[$key1]['seller_coupontype'] = $seller_coupontype;
				$order_coupondata[$key1]['seller_ordertotal'] = $seller_ordertotal;
				$order_coupondata[$key1]['seller_discount_amt'] = $calculated_discountamt;
				$order_coupondata[$key1]['sellername'] = get_seller_details($key1);
				$seller_totalall_amt += $order_coupondata[$key1]['seller_discount_amt'];
			   }//if isseet


			    // code for getting delivery option data

			   $delivery_title   = isset($get_orderdetailcoupondata['delivery_title'])?$get_orderdetailcoupondata['delivery_title']:'';
  			   $delivery_cost    = isset($get_orderdetailcoupondata['delivery_cost'])?$get_orderdetailcoupondata['delivery_cost']:'';
 			   $delivery_day     = isset($get_orderdetailcoupondata['delivery_day'])?$get_orderdetailcoupondata['delivery_day']:'';
 			   $delivery_option_id = isset($get_orderdetailcoupondata['delivery_option_id'])?$get_orderdetailcoupondata['delivery_option_id']:'';

 			   $delivery_date = isset($get_orderdetailcoupondata['created_at'])?$get_orderdetailcoupondata['created_at']:'';

 			    if(isset($delivery_title) && isset($delivery_cost) && isset($delivery_day) && isset($delivery_option_id))
				{
					$order_deliveryoptiondata[$key1]['delivery_option_id'] = $delivery_option_id;
					$order_deliveryoptiondata[$key1]['delivery_day'] = $delivery_day;
					$order_deliveryoptiondata[$key1]['delivery_title'] = $delivery_title;
					$order_deliveryoptiondata[$key1]['delivery_cost'] = $delivery_cost;
					$order_deliveryoptiondata[$key1]['sellername'] = get_seller_details($key1);
					$order_deliveryoptiondata[$key1]['delivery_date'] = $delivery_date;

				}//if isset 


				//get tax

				$seller_taxarr = [];

				$tax = isset($get_orderdetailcoupondata['tax'])?$get_orderdetailcoupondata['tax']:0;
				if(isset($tax) && !empty($tax))
				{
					$seller_taxarr[$key1]['sellername'] =  get_seller_details($key1);
					$seller_taxarr[$key1]['tax'] =  $tax;
				}


			}//get_orderdetailcoupondata
			

			/*********************couponcode*end********************************/
			

			foreach ($product_data as $key2 => $product) 
			{
	 	   		$product_name 				  = isset($product['product_data']['product_name'])?$product['product_data']['product_name']:'';
	 	   		$order[$key2]['order_no']     = $order_no or '';
	 	   		$order[$key2]['product_name'] = $product_name;
	 	   		$order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;


	 	   		$order[$key2]['seller_name']  = get_seller_name($product['seller_id']);

	 	   		if($product['product_data']['price_drop_to']>0)
	 	   		{
	 	   			$order[$key2]['unit_price']= isset($product['product_data']['price_drop_to'])?$product['product_data']['price_drop_to']:0;
	 	   			$order[$key2]['total_wholesale_price'] = $product['product_data']['price_drop_to']*$product['item_qty'];
	 	   			
	 	   		}else{

	 	   			$order[$key2]['unit_price']= isset($product['product_data']['unit_price'])?$product['product_data']['unit_price']:0;
	 	   			$order[$key2]['total_wholesale_price'] = $product['product_data']['unit_price']*$product['item_qty'];
	 	   		}

	 	   		if($product['product_data']['shipping_type']==1)
	 	   		{
	 	   			$order[$key2]['shipping_charges']   = isset($product['product_data']['shipping_charges'])?$product['product_data']['shipping_charges']:0;
	 	   		}else{

	 	   			$order[$key2]['shipping_charges']   = 0;
	 	   		}

	 	   		
	 	   	}

	 	   	// dd($a);
	 	   	
	 	    $seller[$key1]['email_id'] = $arr_email;
	 	    $address = [];

	 	    
	 	    $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$order_no)->first();

	 	    if ($address_details) {
	 	    	// dd($address_details);

	 	    	$address['shipping'] = isset($address_details['shipping_address1'])?$address_details['shipping_address1']:'';
	 	    	$address['shipping_state'] = isset($address_details['state_details']['name'])?$address_details['state_details']['name']:'';
	 	    	$address['shipping_country'] = isset($address_details['country_details']['name'])?$address_details['country_details']['name']:'';
	 	    	$address['shipping_zipcode'] = isset($address_details['shipping_zipcode'])?$address_details['shipping_zipcode']:'';
	 	        $address['shipping_city'] = isset($address_details['shipping_city'])?$address_details['shipping_city']:'';


	 	    	$address['billing'] = isset($address_details['billing_address1'])?$address_details['billing_address1']:'';
	 	    	$address['billing_state'] = isset($address_details['billing_state_details']['name'])?$address_details['billing_state_details']['name']:'';
	 	    	$address['billing_country'] = isset($address_details['billing_country_details']['name'])?$address_details['billing_country_details']['name']:'';
	 	    	$address['billing_zipcode'] = isset($address_details['billing_zipcode'])?$address_details['billing_zipcode']:'';
	 	    	$address['billing_city'] = isset($address_details['billing_city'])?$address_details['billing_city']:'';


	 	    }

	 	    $site_setting_arr = [];
	        $site_setting_obj = SiteSettingModel::first();  
	        if(isset($site_setting_obj))
	        {
	            $site_setting_arr = $site_setting_obj->toArray();            
	        }


	 	    
		    $sum = 0;
		    $total_amount = 0;
		    $shipping_charges_sum = 0;

			foreach ($order as $key => $order_data) 
			{ 
				$sum += $order_data['total_wholesale_price'];
				$shipping_charges_sum += $order_data['shipping_charges'];
				
				$order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
			}

			$user_id = $this->UserModel->where('email',$seller[$key1]['email_id'])->first();


			$obj_buyer_age_verification_details = $this->OrderModel->where('order_no',$order_no)->where('seller_id',$user_id['id'])->first();

		   	if($obj_buyer_age_verification_details!=null)
		   	{
		   	  $buyer_age_restrictionflag = $obj_buyer_age_verification_details->buyer_age_restrictionflag;
		   	}


		   if(isset($buyer_age_restrictionflag) && $buyer_age_restrictionflag=="0")
		   {	

		   $seluser_info = $this->UserModel->where('email',$seller[$key1]['email_id'])->with('seller_detail')->first();

	 	  	$pdf = PDF::loadView('front/seller_invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address','site_setting_arr','user','seluser_info','order_coupondata','seller_totalall_amt','order_deliveryoptiondata','seller_taxarr'));
	 	  	
	 	  	
           	$currentDateTime = $order_no.date('H:i:s').'.pdf';
			

			Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
     	 	$pdfpath = Storage::url($currentDateTime);

     	 	$loggedInUserId = 0;
     	 	if ($userId = Sentinel::check()) {
     	 		
     	 		$loggedInUserId = $userId->id;
     	 	}

     	 	$user_id = $this->UserModel->where('email',$seller[$key1]['email_id'])->first();

     	 	$buyer_details = $this->UserModel->where('id',$loggedInUserId)->first();

          	$obj_email_template = $this->EmailTemplateModel->where('id','36')->first();

          	if($obj_email_template)
  			{
    			$arr_email_template = $obj_email_template->toArray();
    			$content = $arr_email_template['template_html'];
    		}
    		$content = str_replace("##SELLER_NAME##",$user_id['first_name'].' '.$user_id['last_name'],$content);
    		$content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
    		$content = str_replace("##APP_NAME##",config('app.project.name'),$content);
    		

	        $content = view('email.front_general',compact('content'))->render();
	        $content = html_entity_decode($content);

	    	$file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

	    	$to_mail_id = $seller[$key1]['email_id'];

	    	$send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
	        {
	          	
		        if(isset($arr_email_template) && count($arr_email_template) > 0)
		        {		
		        	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
	          		$message->to($to_mail_id);

	          		$dynamicsubject = str_replace("##order_no##", $order_no, $arr_email_template['template_subject']);
 					$message->subject($dynamicsubject);
			       // $message->subject($arr_email_template['template_subject']);
		        }
		        else
		        {
		        	$admin_email = 'notify@chow420.com';

		        	$message->from($admin_email);
	          		$message->to($to_mail_id);
			        $message->subject('New Order '.$order_no.' Placed');
		        }	          	
	          	
			    $message->setBody($content, 'text/html');
			  	$message->attach($file_to_path);
			       
	        });
	      } 

	      else if(isset($buyer_age_restrictionflag) && $buyer_age_restrictionflag=="1")
	      {


		   $seluser_info = $this->UserModel->where('email',$seller[$key1]['email_id'])->with('seller_detail')->first();

/*	 	  	$pdf = PDF::loadView('front/seller_invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address','site_setting_arr','user','seluser_info'));
	 	  	
	 	  	
           	$currentDateTime = $order_no.date('H:i:s').'.pdf';
			

			Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
     	 	$pdfpath = Storage::url($currentDateTime);*/

     	 	$loggedInUserId = 0;
     	 	if ($userId = Sentinel::check()) {
     	 		
     	 		$loggedInUserId = $userId->id;
     	 	}

     	 	$user_id = $this->UserModel->where('email',$seller[$key1]['email_id'])->first();

     	 	$buyer_details = $this->UserModel->where('id',$loggedInUserId)->first();

          	$obj_email_template = $this->EmailTemplateModel->where('id','140')->first();

          	if($obj_email_template)
  			{
    			$arr_email_template = $obj_email_template->toArray();
    			$content = $arr_email_template['template_html'];
    		}
    		$content = str_replace("##SELLER_NAME##",$user_id['first_name'].' '.$user_id['last_name'],$content);
    		$content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
    		$content = str_replace("##APP_NAME##",config('app.project.name'),$content);
    		

	        $content = view('email.front_general',compact('content'))->render();
	        $content = html_entity_decode($content);

	    	//$file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

	    	$to_mail_id = $seller[$key1]['email_id'];

	    	$send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$arr_email_template,$order_no)
	        {
	          	
		        if(isset($arr_email_template) && count($arr_email_template) > 0)
		        {		
		        	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
	          		$message->to($to_mail_id);

	          		$dynamicsubject = str_replace("##order_no##", $order_no, $arr_email_template['template_subject']);
 					$message->subject($dynamicsubject);
			       // $message->subject($arr_email_template['template_subject']);
		        }
		        else
		        {
		        	$admin_email = 'notify@chow420.com';

		        	$message->from($admin_email);
	          		$message->to($to_mail_id);
			        $message->subject('New Order '.$order_no.' Placed');
		        }	          	
	          	
			    $message->setBody($content, 'text/html');
	        });

	      } 
 
		}
		
	}	

	/******************************************************/

	//function export_orders($from_date,$to_date,$completedflag,$seller_user_id=NULL)
	function export_orders($from_date,$to_date,$excelorderstatus,$seller_user_id=NULL,$buyer_age_restrictionflag = false)
    {

      //  if($from_date && $to_date && ($completedflag==0 || $completedflag==1))
        if($from_date && $to_date && $excelorderstatus=="0" || $excelorderstatus=="ongoing" || $excelorderstatus=="delivered" || $excelorderstatus=="cancelled")
       {
       

        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));

        $from_date = $from_date.' 00:00:00';
        $to_date   = $to_date.' 23:59:59';

        $order_detail_table         = $this->OrderModel->getTable();
        $prefixed_orderdetail_table = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_detailtable = $this->OrderProductModel->getTable();
        $prefix_orderproductdetail_table = DB::getTablePrefix().$this->OrderProductModel->getTable();


        $user_table            = $this->UserModel->getTable();
        $prefixed_user_table   = DB::getTablePrefix().$this->UserModel->getTable();

        $order_product_table   = $this->OrderProductModel->getTable();
        $prefixed_orderproduct_table = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $dispute_tbl_name      = $this->DisputeModel->getTable();
        $prefixed_dispute_tbl  = DB::getTablePrefix().$this->DisputeModel->getTable();


        $country_details = $this->CountriesModel->getTable();
        $prefixed_country_details  = DB::getTablePrefix().$this->CountriesModel->getTable();

        $state_details = $this->StatesModel->getTable();
        $prefix_state_details =  DB::getTablePrefix().$this->StatesModel->getTable();

        $sellertable  = $this->SellerModel->getTable();
        $prefix_sellertable = DB::getTablePrefix().$this->SellerModel->getTable();

          $obj_orderdetail = DB::table($order_detail_table)
           ->select(DB::raw('transaction_id,order_status,           
            total_amount as total_amount, 
            '.$order_detail_table.'.id as id,
            '.$order_detail_table.'.seller_id, 
            '.$order_detail_table.'.buyer_id, 
            '.$order_detail_table.'.refund_status,
            '.$order_detail_table.'.order_no as order_no,
            '.$order_detail_table.'.created_at as created_at,
            '.$order_detail_table.'.buyer_age_restrictionflag,
            '.$order_detail_table.'.couponid as couponid,
            '.$order_detail_table.'.couponcode as couponcode,
            '.$order_detail_table.'.discount as discount,
            '.$order_detail_table.'.seller_discount_amt as seller_discount_amt,
            '.$order_detail_table.'.tax as tax,

            '.$order_detail_table.'.delivery_title as delivery_title,
            '.$order_detail_table.'.delivery_cost as delivery_cost,
            '.$order_detail_table.'.delivery_day as delivery_day,
            '.$order_detail_table.'.delivery_option_id as delivery_option_id,

            '.$prefixed_dispute_tbl.'.dispute_status,
            '.$prefixed_dispute_tbl.'.dispute_reason,


             '.$prefixed_user_table.'.country,
             '.$prefixed_user_table.'.state,
             '.$prefixed_user_table.'.city,
             '.$prefixed_user_table.'.street_address,
             '.$prefixed_user_table.'.zipcode,
 			 '.$prefixed_user_table.'.billing_country,
 			  '.$prefixed_user_table.'.billing_state,
             '.$prefixed_user_table.'.billing_city,
             '.$prefixed_user_table.'.billing_street_address,
             '.$prefixed_user_table.'.billing_zipcode,






            
             '.$prefixed_dispute_tbl.'.is_dispute_finalized,'
             ."CONCAT(".$prefixed_user_table.".first_name,' ',".$prefixed_user_table.".last_name) as buyername,".
              "CONCAT(seller_table.first_name,' ',seller_table.last_name) as sellername,seller_business_table.business_name as business_name"
             ))

        
         ->leftJoin($prefixed_dispute_tbl,$prefixed_dispute_tbl.'.order_id',$order_detail_table.'.id')
         ->leftJoin($prefixed_user_table,$prefixed_user_table.'.id',$order_detail_table.'.buyer_id')
         ->leftJoin($prefixed_user_table.' as seller_table','seller_table.id',$order_detail_table.'.seller_id')
          ->leftJoin($prefix_sellertable.' as seller_business_table','seller_business_table.user_id',$order_detail_table.'.seller_id');

         //->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);



         /****************added on 14july20******************/	

         $set_sheetname ='orders_'.date('Y-m-d');
         if($excelorderstatus=="0")
         {
         	 $set_sheetname ='orders_'.date('Y-m-d');
         	 $obj_orderdetail = $obj_orderdetail->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
         }
         elseif($excelorderstatus=="ongoing")
         {
         //	$obj_orderdetail = $obj_orderdetail->where($order_detail_table.'.order_status','2')->orWhere($order_detail_table.'.order_status','3');
         	 if($seller_user_id)
	         {
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','2']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);

	         	//this condition for restricted orders
	         	
	         	if(isset($buyer_age_restrictionflag) && $buyer_age_restrictionflag == 1 && $buyer_age_restrictionflag!=false)
                { 
                	
                	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.buyer_age_restrictionflag',$buyer_age_restrictionflag]]);
                }
                else
                {
                	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.buyer_age_restrictionflag',0]]);

                	$obj_orderdetail = $obj_orderdetail->orwhere([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','3']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);

                }



	         /*	$obj_orderdetail = $obj_orderdetail->orwhere([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','3']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);*/

               

	    
	         }
	         else
	         {
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.order_status','2']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	         	$obj_orderdetail = $obj_orderdetail->orwhere([[$order_detail_table.'.order_status','3']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	         }

         	$set_sheetname = 'ongoing_shipped_'.date('Y_m_d').'_orders';

         }elseif($excelorderstatus=="delivered")
         {
         	//$obj_orderdetail = $obj_orderdetail->where($order_detail_table.'.order_status','1');
         	if($seller_user_id)
	         {
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','1']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	         }
	         else
	         {
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.order_status','1']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	         }

         	$set_sheetname = 'delivered_'.date('Y_m_d').'_orders';

         }elseif($excelorderstatus=="cancelled")
         {
         	//$obj_orderdetail = $obj_orderdetail->where($order_detail_table.'.order_status','0');

         	if($seller_user_id)
	        {
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','0']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);

	         	
	        }
	        else{
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.order_status','0']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	        }

         	$set_sheetname = 'cancelled_'.date('Y_m_d').'_orders';

         }

         /***************added on 14 july 20***********************/


         /* if($seller_user_id)
         {
         	$obj_orderdetail = $obj_orderdetail->where($order_detail_table.'.seller_id',$seller_user_id);
         }*/

         

         $obj_orderdetail = $obj_orderdetail->orderBy('id','desc')->get();

       

         if(!empty($obj_orderdetail))
         {
            $obj_orderdetail = $obj_orderdetail->toArray();
         }

             // $order_array[] = array( 'Order No.', 'Order Date','Seller Name','Dispensary','Buyer','Buyer Shipping Address','Buyer Billing Address','Coupon Code','Coupon Discount',
             // 	'Coupon Discount Amount','Amount','Product Ordered Information', 'Transaction Id', 'Status');

               $order_array[] = array( 'Order No.', 'Order Date','Seller Name','Dispensary','Buyer','Buyer Shipping Address','Buyer Billing Address','Coupon Code','Coupon Discount',
             	'Coupon Discount Amount','Delivery Option Title','Delivery Option Cost','Delivery Option Day','Amount','Product Name','Quantity','SKU','Transaction Id','Wallet Amount Used','Tax','Status');

             

             foreach($obj_orderdetail as $order)
             {

             	


                $orderstatus = $order->order_status;

                /*if($orderstatus==0)
                    $order_status ="Cancelled";
                if($orderstatus==1)
                    $order_status ="Delivered";
                if($orderstatus==2)
                    $order_status ="Ongoing";
                if($orderstatus==3)
                    $order_status ="Shipped";
                if($orderstatus==4)
                    $order_status ="Dispatched";*/

                if($orderstatus==0)
                {
                    if($order->buyer_age_restrictionflag == 1)
                	{
                	  $order_status ="Cancelled (Pending age verification)";
                	}
                	else
                	{
                      $order_status ="Cancelled";
                	}	
                    
                  
                }
              
                	
                    
                if($orderstatus==1)
                {
                    $order_status ="Delivered";
                }

                if($orderstatus==2)
                {
                	if($order->buyer_age_restrictionflag == 1)
                	{
                	   $order_status ="Ongoing (Pending age verification)";	 
                    }
                    else
                    {
                       $order_status ="Ongoing";
                    }

                }
                		
                    
                if($orderstatus==3)
                {
                    $order_status ="Shipped";
                }

                if($orderstatus==4)
                {
                    $order_status ="Dispatched";
                }


                $shippingcountryname='';


                if(isset($order->country)){
                 $shippingcountryname = get_countrydata($order->country);
                }
                $billingcountryname='';
                if(isset($order->billing_country)){
                 $billingcountryname = get_countrydata($order->billing_country);
                }

                $shippingstatename='';
                if(isset($order->state)){
                 $shippingstatename = get_statedata($order->state);
                }

                $billingstatename='';
                if(isset($order->billing_state)){
                 $billingstatename = get_statedata($order->billing_state);
                }

                /*$shipping_address='';
                if($order->street_address)
                {
                	$shipping_address = $order->street_address;
                }
                  if($order->city)
                {
                	$shipping_address .= ','.$order->city;
                }
                 if($shippingstatename)
                {
                	$shipping_address .= ','.$shippingstatename;
                }
                if($shippingcountryname)
                {
                	$shipping_address .=  ','.$shippingcountryname;
                }
                 if($order->zipcode)
                {
                	$shipping_address .= ','.$order->zipcode;
                }


                $billing_address='';
                if($order->street_address)
                {
                	$billing_address = $order->billing_street_address;
                }
                  if($order->city)
                {
                	$billing_address .= ','.$order->billing_city;
                }
                if($shippingstatename)
                {
                	$billing_address .= ','.$billingstatename;
                }
                if($shippingcountryname)
                {
                	$billing_address .=  ','.$billingcountryname;
                }                
                  if($order->zipcode)
                {
                	$billing_address .= ','.$order->billing_zipcode;
                }*/
                
                $getproduct = $this->OrderProductModel->where('order_id',$order->id)->get();
                if(isset($getproduct) && !empty($getproduct))
                {
                	$getproduct = $getproduct->toArray();
                	$productarr =[];
                	$html = '';
                	$i=1;
                	foreach($getproduct as $kk=>$vv)
                	{
                		
                		$productid = $vv['product_id'];
                		$productinfo = get_product_info($productid);
                		$productname = $productinfo['product_name'];

                		//$html .= $i.') '.'Product Name : '.$productname.', Qty :'.$vv['quantity'].'  ';
                		$i++;
                	}



                }//if getproduct of orders





                /************couponcode********************************/
                    if($order->total_amount>0){

                        if(isset($order->couponid) && isset($order->couponcode) && $order->couponcode!='' && isset($order->discount) && $order->discount!='' 
                            && isset($order->seller_discount_amt) 
                            && $order->seller_discount_amt!='')
                        {

                          $total_amount = (float)$order->total_amount - (float)$order->seller_discount_amt;  

                           if(isset($order->delivery_title) && isset($order->delivery_cost) && isset($order->delivery_day) && $order->delivery_cost!='')
                           {
                           	 $total_amount = (float)$total_amount + (float)$order->delivery_cost;  
                           }


                          $total_amount = number_format($total_amount, 2, '.', ''); 
                        }
                        else
                        {

                        	$total_amount = $order->total_amount;

                        	  if(isset($order->delivery_title) && isset($order->delivery_cost) && isset($order->delivery_day) && $order->delivery_cost!='')
                              {
                           	     $total_amount = (float)$total_amount + (float)$order->delivery_cost;  
                              }

                          $total_amount = number_format($total_amount, 2, '.', '');  
                        }
                    }
                    else{
                        $total_amount = $order->total_amount;
                    }
                /**************couponcode******************************/

                /****************Address details**************/
                    $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$order->order_no)->first();

                     $shipping_address='';
                     $billing_address='';
                    
			 	    if($address_details) 
			 	    {
			 	    	
			 	    	    $shipping_address='';
			                if(isset($address_details['shipping_address1']) && !empty($address_details['shipping_address1']))
			                {
			                	$shipping_address = $address_details['shipping_address1'];
			                }
			                  if(isset($address_details['shipping_city']) && !empty($address_details['shipping_city']))
			                {
			                	$shipping_address .= ','.$address_details['shipping_city'];
			                }
			                 if(isset($address_details['state_details']['name']) && !empty($address_details['state_details']['name']))
			                {
			                	$shipping_address .= ','.$address_details['state_details']['name'];
			                }
			                if(isset($address_details['country_details']['name']) && !empty($address_details['country_details']['name']))
			                {
			                	$shipping_address .=  ','.$address_details['country_details']['name'];
			                }
			                 if(isset($address_details['shipping_zipcode']) && !empty($address_details['shipping_zipcode']))
			                {
			                	$shipping_address .= ','.$address_details['shipping_zipcode'];
			                }

			                 $billing_address='';
			                if(isset($address_details['billing_address1']) && !empty($address_details['billing_address1']))
			                {
			                	$billing_address = $address_details['billing_address1'];
			                }
			                  if(isset($address_details['billing_city']) && !empty($address_details['billing_city']))
			                {
			                	$billing_address .= ','.$address_details['billing_city'];
			                }
			                if(isset($address_details['billing_state_details']['name']) && !empty($address_details['billing_state_details']['name']))
			                {
			                	$billing_address .= ','.$address_details['billing_state_details']['name'];
			                }
			                if(isset($address_details['billing_country_details']['name']) && !empty($address_details['billing_country_details']['name']))
			                {
			                	$billing_address .=  ','.$address_details['billing_country_details']['name'];
			                }                
			                  if(isset($address_details['billing_zipcode']) && !empty($address_details['billing_zipcode']))
			                {
			                	$billing_address .= ','.$address_details['billing_zipcode'];
			                }
			 	  
			 	    } //if address_details

                /****************Address details***************/

               $wallet_amount_used = 0;
               $wallet_amount_used = get_wallet_amountused_fororder($order->buyer_id,$order->order_no); 

              $order_array[] = array(
               'Order No'  => $order->order_no,
               'Order Date'   => date('d M Y H:i',strtotime($order->created_at)),
               'Seller'   => $order->sellername,
               'Seller Business Name' => isset($order->business_name)?$order->business_name:'NA',
               'Buyer'    => $order->buyername,
               'Buyer Shipping Address'=>$shipping_address,
               'Buyer Billing Address'=>$billing_address,
               'Coupon Code'   => isset($order->couponcode)?$order->couponcode:'',
               'Coupon Discount' => (isset($order->discount) && $order->discount>0)?$order->discount.'%':'',
               'Coupon Discount Amount'=> (isset($order->seller_discount_amt) && $order->seller_discount_amt>0)?'$'.num_format($order->seller_discount_amt,2):'',

               'Delivery Option Title'=>isset($order->delivery_title)?$order->delivery_title:'',
               'Delivery Option Cost' =>isset($order->delivery_cost)?$order->delivery_cost:'',
               'Delivery Option Day' => isset($order->delivery_day)? date('l jS \, F Y', strtotime($order->created_at. ' + '.$order->delivery_day.' days')):'', 	
               'Amount'   => '$'.num_format($total_amount,2),
              // 'Product Ordered Information'=> $html,
              
               'Product Name'=> '',
               'Quantity'=> '',
               'SKU'=> '',
               'Transaction Id'   => $order->transaction_id,
               'Wallet Amount Used' => isset($wallet_amount_used)? '$'.num_format($wallet_amount_used):'-',
               'Tax'   => '$'.$order->tax,
               'Order Status' => $order_status
              );
             // dd($order_array);


              	$emptyrowarr = [];

             	 $getproduct = $this->OrderProductModel->where('order_id',$order->id)->get();
                if(isset($getproduct) && !empty($getproduct))
                {
                	$getproduct = $getproduct->toArray();
                	$productarr =[];
                	$html = '';
                	$i=1;
                	 $wallet_amount_used = 0;
                	foreach($getproduct as $kk=>$vv)
                	{
                		
                		
                        $wallet_amount_used = get_wallet_amountused_fororder($order->buyer_id,$order->order_no); 

                		$productid = $vv['product_id'];
                		$productinfo = get_product_info($productid);
                		$productname = $productinfo['product_name'];
                		$sku = isset($productinfo['sku'])?$productinfo['sku']:'';

                		$productarr['Order No'] ='';
                		$productarr['Order Date'] =date('d M Y H:i',strtotime($order->created_at));
                		$productarr['Seller'] =$order->sellername;
                		$productarr['Seller Business Name'] =isset($order->business_name)?$order->business_name:'NA';
                		$productarr['Buyer'] =$order->buyername;
                		$productarr['Buyer Shipping Address'] =$shipping_address;
                		$productarr['Buyer Billing Address'] =$billing_address;
                		$productarr['Coupon Code'] =isset($order->couponcode)?$order->couponcode:'';
                		$productarr['Coupon Discount'] =(isset($order->discount) && $order->discount>0)?$order->discount.'%':'';
                		$productarr['Coupon Discount Amount'] =(isset($order->seller_discount_amt) && $order->seller_discount_amt>0)?'$'.num_format($order->seller_discount_amt,2):'';

                		 $productarr['Delivery Option Title'] = isset($order->delivery_title)?$order->delivery_title:'';
                         $productarr['Delivery Option Cost'] = isset($order->delivery_cost)?$order->delivery_cost:'';
                        $productarr['Delivery Option Day'] = isset($order->delivery_day)? date('l jS \, F Y', strtotime($order->created_at. ' + '.$order->delivery_day.' days')):'';

                		$productarr['Amount'] ='$'.num_format($total_amount,2);
                		$productarr['Product Name'] = isset($productname)?$productname:'';
                		$productarr['Quantity'] =isset($vv['quantity'])?$vv['quantity']:'';
                		$productarr['SKU'] =isset($productinfo['sku'])?$productinfo['sku']:'';
                		$productarr['Transaction Id'] =$order->transaction_id;

                		$productarr['Wallet Amount Used']   = isset($wallet_amount_used)? '$'.num_format($wallet_amount_used):'-';
                		$productarr['Tax'] ='$'.$order->tax;
                		$productarr['Order Status'] =$order_status;
                		/*if(isset($productinfo['sku']))
                		{
                			$productarr['name'] =  'Product Name : '.$productname.' , Qty :'.$vv['quantity'].' , SQU : '.$sku;
                		}else
                		{
                			$productarr['name'] =  'Product Name : '.$productname.' , Qty :'.$vv['quantity'];
                		}*/
                		

                		array_push($order_array,$productarr);
                		$i++;
                	}

                }//if getproduct of orders
           

                array_push($order_array,$emptyrowarr);

             }
             Excel::create($set_sheetname, function($excel) use ($order_array)
             {
                $excel->setTitle('Orders');
                $excel->sheet('Orders', function($sheet) use ($order_array)
                {
                   $sheet->fromArray($order_array, null, 'A1', false, false);
                   //$sheet->getStyle('I')->getAlignment()->setWrapText(true);
				   //$sheet->getColumnDimension('I')->setWidth(5);


                });

             })->download('xlsx');

        }//if form date and to date
            
    }// end of function

	/*****************************************************/
	function export_orders_csv($from_date,$to_date,$excelorderstatus,$seller_user_id=NULL,$buyer_age_restrictionflag = false)
    {

      //  if($from_date && $to_date && ($completedflag==0 || $completedflag==1))
        if($from_date && $to_date && $excelorderstatus=="0" || $excelorderstatus=="ongoing" || $excelorderstatus=="delivered" || $excelorderstatus=="cancelled")
       {
       
       
        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));

        $from_date = $from_date.' 00:00:00';
        $to_date   = $to_date.' 23:59:59';

        $order_detail_table         = $this->OrderModel->getTable();
        $prefixed_orderdetail_table = DB::getTablePrefix().$this->OrderModel->getTable();

        $user_table            = $this->UserModel->getTable();
        $prefixed_user_table   = DB::getTablePrefix().$this->UserModel->getTable();

        $order_product_table   = $this->OrderProductModel->getTable();
        $prefixed_orderproduct_table = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $dispute_tbl_name      = $this->DisputeModel->getTable();
        $prefixed_dispute_tbl  = DB::getTablePrefix().$this->DisputeModel->getTable();

        $sellertable  = $this->SellerModel->getTable();
        $prefix_sellertable = DB::getTablePrefix().$this->SellerModel->getTable();

        

          $obj_orderdetail = DB::table($order_detail_table)
           ->select(DB::raw('transaction_id,order_status,           
            total_amount as total_amount, 
            '.$order_detail_table.'.id as id,
            '.$order_detail_table.'.seller_id,
            '.$order_detail_table.'.buyer_id,
            '.$order_detail_table.'.refund_status,
            '.$order_detail_table.'.order_no as order_no,
            '.$order_detail_table.'.created_at as created_at,
            '.$order_detail_table.'.buyer_age_restrictionflag,

            '.$order_detail_table.'.couponid as couponid,
            '.$order_detail_table.'.couponcode as couponcode,
            '.$order_detail_table.'.discount as discount,
            '.$order_detail_table.'.seller_discount_amt as seller_discount_amt,

            '.$order_detail_table.'.delivery_title as delivery_title,
            '.$order_detail_table.'.delivery_cost as delivery_cost,
            '.$order_detail_table.'.delivery_day as delivery_day,
            '.$order_detail_table.'.delivery_option_id as delivery_option_id,
            '.$order_detail_table.'.tax as tax,

            '.$prefixed_dispute_tbl.'.dispute_status,
            '.$prefixed_dispute_tbl.'.dispute_reason,

             '.$prefixed_user_table.'.country,
             '.$prefixed_user_table.'.state,
             '.$prefixed_user_table.'.city,
             '.$prefixed_user_table.'.street_address,
             '.$prefixed_user_table.'.zipcode,
 			 '.$prefixed_user_table.'.billing_country,
 			  '.$prefixed_user_table.'.billing_state,
             '.$prefixed_user_table.'.billing_city,
             '.$prefixed_user_table.'.billing_street_address,
             '.$prefixed_user_table.'.billing_zipcode,

            '.$prefixed_dispute_tbl.'.is_dispute_finalized,'
             ."CONCAT(".$prefixed_user_table.".first_name,' ',".$prefixed_user_table.".last_name) as buyername,".
              "CONCAT(seller_table.first_name,' ',seller_table.last_name) as sellername,seller_business_table.business_name as business_name "
             ))

         ->leftJoin($prefixed_dispute_tbl,$prefixed_dispute_tbl.'.order_id',$order_detail_table.'.id')
         ->leftJoin($prefixed_user_table,$prefixed_user_table.'.id',$order_detail_table.'.buyer_id')
         ->leftJoin($prefixed_user_table.' as seller_table','seller_table.id',$order_detail_table.'.seller_id')
          ->leftJoin($prefix_sellertable.' as seller_business_table','seller_business_table.user_id',$order_detail_table.'.seller_id');
        //->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);



         /****************added on 14july20******************/	

         $set_sheetname ='orders_'.date('Y-m-d');
         if($excelorderstatus=="0")
         { 
         	 $set_sheetname ='orders_'.date('Y-m-d');
         	 $obj_orderdetail = $obj_orderdetail->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
         }
         elseif($excelorderstatus=="ongoing")
         {  
         	//$obj_orderdetail = $obj_orderdetail->where($order_detail_table.'.order_status','2')->orWhere($order_detail_table.'.order_status','3');

         	if($seller_user_id)
	        {

	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','2']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);

                //this condition for restricted orders
	         	if(isset($buyer_age_restrictionflag) && $buyer_age_restrictionflag == 1 && $buyer_age_restrictionflag!=false)
                { 
                	
                	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.buyer_age_restrictionflag',$buyer_age_restrictionflag]]);
                }
                else
                {
                	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.buyer_age_restrictionflag',0]]);

                	$obj_orderdetail = $obj_orderdetail->orwhere([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','3']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
                }
               

	         	/*$obj_orderdetail = $obj_orderdetail->orwhere([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','3']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);*/

	         	

	        }
	         
	        else
	        {
	        	
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.order_status','2']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	         	$obj_orderdetail = $obj_orderdetail->orwhere([[$order_detail_table.'.order_status','3']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	        }


         	$set_sheetname = 'ongoing_shipped_'.date('Y_m_d').'_orders';

         }elseif($excelorderstatus=="delivered")
         { 
         	//$obj_orderdetail = $obj_orderdetail->where($order_detail_table.'.order_status','1');

         	 if($seller_user_id)
	         {
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','1']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	         }
	         else
	         {
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.order_status','1']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	         }


         	$set_sheetname = 'delivered_'.date('Y_m_d').'_orders';

         }elseif($excelorderstatus=="cancelled")
         { 
         	//$obj_orderdetail = $obj_orderdetail->where($order_detail_table.'.order_status','0');

         	if($seller_user_id)
	        {
	         	$obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.seller_id',$seller_user_id],[$order_detail_table.'.order_status','0']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);



	        }
	        else
	        {
	         	
	          $obj_orderdetail = $obj_orderdetail->where([[$order_detail_table.'.order_status','0']]) ->whereBetween($order_detail_table.'.created_at',[ $from_date,$to_date ]);
	        }

         	$set_sheetname = 'cancelled_'.date('Y_m_d').'_orders';

         }

         /***************added on 14 july 20***********************/

         /* if($seller_user_id)
         {
         	$obj_orderdetail = $obj_orderdetail->where($order_detail_table.'.seller_id',$seller_user_id);
         }*/

         

         $obj_orderdetail = $obj_orderdetail->orderBy('id','desc')->get();
         

         if(!empty($obj_orderdetail))
         {
            $obj_orderdetail = $obj_orderdetail->toArray();
         }

             // $order_array[] = array( 'Order No.', 'Order Date','Seller Name','Dispensary','Buyer','Buyer Shipping Address','Buyer Billing Address','Coupon Code','Coupon Discount',
             // 	'Coupon Discount Amount','Amount','Product Ordered Information','Transaction Id', 'Status');

             $order_array[] = array( 'Order No.', 'Order Date','Seller Name','Dispensary','Buyer','Buyer Shipping Address','Buyer Billing Address','Coupon Code','Coupon Discount',
             	'Coupon Discount Amount','Delivery Option Title','Delivery Option Cost','Delivery Option Day','Amount','Product Name','Quantity','SKU','Transaction Id','Wallet Amount Used','Tax','Status');		

            

             foreach($obj_orderdetail as $order)
             {

                 $orderstatus = $order->order_status;

               /* if($orderstatus==0)
                    $order_status ="Cancelled";
                if($orderstatus==1)
                    $order_status ="Delivered";
                if($orderstatus==2)
                    $order_status ="Ongoing";
                if($orderstatus==3)
                    $order_status ="Shipped";
                if($orderstatus==4)
                    $order_status ="Dispatched";*/

                if($orderstatus==0)
                {
                    if($order->buyer_age_restrictionflag == 1)
                	{
                	  $order_status ="Cancelled (Pending age verification)";
                	}
                	else
                	{
                      $order_status ="Cancelled";
                	}	
                  
                }
                	
                    
                if($orderstatus==1)
                {
                    $order_status ="Delivered";
                }

                if($orderstatus==2)
                {
                	if($order->buyer_age_restrictionflag == 1)
                	{
                	   $order_status ="Ongoing (Pending age verification)";	 
                    }
                    else
                    {
                    	$order_status ="Ongoing";
                    }
  
                }
                		
                    
                if($orderstatus==3)
                {
                    $order_status ="Shipped";
                }

                if($orderstatus==4)
                {
                    $order_status ="Dispatched";
                }
    

                /*************start*buyer*address*************/
                   $shippingcountryname='';
	                if(isset($order->country)){
	                 $shippingcountryname = get_countrydata($order->country);
	                }
	                $billingcountryname='';
	                if(isset($order->billing_country)){
	                 $billingcountryname = get_countrydata($order->billing_country);
	                }

	                $shippingstatename='';
	                if(isset($order->state)){
	                 $shippingstatename = get_statedata($order->state);
	                }

	                $billingstatename='';
	                if(isset($order->billing_state)){
	                 $billingstatename = get_statedata($order->billing_state);
	                }

	               /* $shipping_address='';
	                if($order->street_address)
	                {
	                	$shipping_address = $order->street_address;
	                }
	                  if($order->city)
	                {
	                	$shipping_address .= ','.$order->city;
	                }
	                 if($shippingstatename)
	                {
	                	$shipping_address .= ','.$shippingstatename;
	                }
	                if($shippingcountryname)
	                {
	                	$shipping_address .=  ','.$shippingcountryname;
	                }
	                 if($order->zipcode)
	                {
	                	$shipping_address .= ','.$order->zipcode;
	                }


	                $billing_address='';
	                if($order->street_address)
	                {
	                	$billing_address = $order->billing_street_address;
	                }
	                  if($order->city)
	                {
	                	$billing_address .= ','.$order->billing_city;
	                }
	                if($shippingstatename)
	                {
	                	$billing_address .= ','.$billingstatename;
	                }
	                if($shippingcountryname)
	                {
	                	$billing_address .=  ','.$billingcountryname;
	                }                
	                  if($order->zipcode)
	                {
	                	$billing_address .= ','.$order->billing_zipcode;
	                }*/
                	
                /***************end*buyer*address*************/

                $getproduct = $this->OrderProductModel->where('order_id',$order->id)->get();
                if(isset($getproduct) && !empty($getproduct))
                {
                	$getproduct = $getproduct->toArray();
                	$productarr =[];
                	$html = '';
                	$i=1;
                	foreach($getproduct as $kk=>$vv)
                	{
                		
                		$productid = $vv['product_id'];
                		$productinfo = get_product_info($productid);
                		$productname = $productinfo['product_name'];

                		//$html .= $i.') '.'Product Name : '.$productname.', Qty :'.$vv['quantity'].'  ';
                		$i++;
                	}

                }//if getproduct of orders

                 /************couponcode********************************/
                    if($order->total_amount>0){

                        if(isset($order->couponid) && isset($order->couponcode) && $order->couponcode!='' && isset($order->discount) && $order->discount!='' 
                            && isset($order->seller_discount_amt) 
                            && $order->seller_discount_amt!='')
                        {

                          $total_amount = (float)$order->total_amount - (float)$order->seller_discount_amt;  

                            if(isset($order->delivery_cost) && $order->delivery_cost!='' && isset($order->delivery_day) && $order->delivery_day!='' && isset($order->delivery_title) && $order->delivery_title!='')
                            {
                            	 $total_amount = (float)$total_amount + (float)$order->delivery_cost;  	
                            }


                          $total_amount = number_format($total_amount, 2, '.', ''); 
                        }
                        else
                        {
                        	 $total_amount = $order->total_amount;  

                        	 if(isset($order->delivery_cost) && $order->delivery_cost!='' && isset($order->delivery_day) && $order->delivery_day!='' && isset($order->delivery_title) && $order->delivery_title!='')
                            {
                            	 $total_amount = (float)$total_amount + (float)$order->delivery_cost;  	
                            }

                           $total_amount = number_format($total_amount, 2, '.', '');  
                        }//else
                    } //if
                    else{
                        $total_amount = $order->total_amount;
                    }
                /**************couponcode******************************/


                 /****************Address details**************/
                    $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$order->order_no)->first();

                     $shipping_address='';
                     $billing_address='';
                    
			 	    if($address_details) 
			 	    {
			 	    	
			 	    	    $shipping_address='';
			                if(isset($address_details['shipping_address1']) && !empty($address_details['shipping_address1']))
			                {
			                	$shipping_address = $address_details['shipping_address1'];
			                }
			                  if(isset($address_details['shipping_city']) && !empty($address_details['shipping_city']))
			                {
			                	$shipping_address .= ','.$address_details['shipping_city'];
			                }
			                 if(isset($address_details['state_details']['name']) && !empty($address_details['state_details']['name']))
			                {
			                	$shipping_address .= ','.$address_details['state_details']['name'];
			                }
			                if(isset($address_details['country_details']['name']) && !empty($address_details['country_details']['name']))
			                {
			                	$shipping_address .=  ','.$address_details['country_details']['name'];
			                }
			                 if(isset($address_details['shipping_zipcode']) && !empty($address_details['shipping_zipcode']))
			                {
			                	$shipping_address .= ','.$address_details['shipping_zipcode'];
			                }

			                 $billing_address='';
			                if(isset($address_details['billing_address1']) && !empty($address_details['billing_address1']))
			                {
			                	$billing_address = $address_details['billing_address1'];
			                }
			                  if(isset($address_details['billing_city']) && !empty($address_details['billing_city']))
			                {
			                	$billing_address .= ','.$address_details['billing_city'];
			                }
			                if(isset($address_details['billing_state_details']['name']) && !empty($address_details['billing_state_details']['name']))
			                {
			                	$billing_address .= ','.$address_details['billing_state_details']['name'];
			                }
			                if(isset($address_details['billing_country_details']['name']) && !empty($address_details['billing_country_details']['name']))
			                {
			                	$billing_address .=  ','.$address_details['billing_country_details']['name'];
			                }                
			                  if(isset($address_details['billing_zipcode']) && !empty($address_details['billing_zipcode']))
			                {
			                	$billing_address .= ','.$address_details['billing_zipcode'];
			                }
			 	  
			 	    } //if address_details

                /****************Address details***************/

               $wallet_amount_used = 0;
               $wallet_amount_used = get_wallet_amountused_fororder($order->buyer_id,$order->order_no); 


              $order_array[] = array(
               'Order No'  => $order->order_no,
               'Order Date'   => date('d M Y H:i',strtotime($order->created_at)),
               'Seller'   => $order->sellername,
               'Seller Business Name'   => isset($order->business_name)?$order->business_name:'NA',
               'Buyer'    => $order->buyername,
               'Buyer Shipping Address'=>$shipping_address,
               'Buyer Billing Address'=>$billing_address,
               'Coupon Code'   => isset($order->couponcode)?$order->couponcode:'',
               'Coupon Discount' => (isset($order->discount) && $order->discount>0)?$order->discount.'%':'',
               'Coupon Discount Amount'=> (isset($order->seller_discount_amt) && $order->seller_discount_amt>0)?'$'.num_format($order->seller_discount_amt,2):'',

               'Delivery Option Title'=>isset($order->delivery_title)?$order->delivery_title:'' ,
               'Delivery Option Cost' =>isset($order->delivery_cost)?$order->delivery_cost:'',
               'Delivery Option Day' => isset($order->delivery_day)? date('l jS \, F Y', strtotime($order->created_at. ' + '.$order->delivery_day.' days')):'', 

               'Amount'   => '$'.num_format($total_amount,2),
               //'Product Ordered Information'=> $html,
               'Product Name'=> '',
               'Quantity'=> '',
               'SKU'=> '',
               'Transaction Id'   => $order->transaction_id,
               'Wallet Amount Used'=> isset($wallet_amount_used)?'$'.num_format($wallet_amount_used):'-',
               'Tax'   => '$'.$order->tax,
               'Order Status' => $order_status
              );

              $emptyrowarr = [];

               $getproduct = $this->OrderProductModel->where('order_id',$order->id)->get();
                if(isset($getproduct) && !empty($getproduct))
                {
                	$getproduct = $getproduct->toArray();
                	$productarr =[];
                	$html = '';
                	$i=1;
                	$wallet_amount_used = 0;
                	foreach($getproduct as $kk=>$vv)
                	{

                		
                        $wallet_amount_used = get_wallet_amountused_fororder($order->buyer_id,$order->order_no); 

                		
                		$productid = $vv['product_id'];
                		$productinfo = get_product_info($productid);
                		$productname = $productinfo['product_name'];
                		$sku = isset($productinfo['sku'])?$productinfo['sku']:'';

                		$productarr['Order No'] ='';
                		$productarr['Order Date'] =date('d M Y H:i',strtotime($order->created_at));
                		$productarr['Seller'] = $order->sellername;
                		$productarr['Seller Business Name'] =isset($order->business_name)?$order->business_name:'NA';
                		$productarr['Buyer'] = $order->buyername;
                		$productarr['Buyer Shipping Address'] =$shipping_address;
                		$productarr['Buyer Billing Address'] =$billing_address;
                		$productarr['Coupon Code'] =isset($order->couponcode)?$order->couponcode:'';
                		$productarr['Coupon Discount'] =(isset($order->discount) && $order->discount>0)?$order->discount.'%':'';
                		$productarr['Coupon Discount Amount'] =(isset($order->seller_discount_amt) && $order->seller_discount_amt>0)?'$'.num_format($order->seller_discount_amt,2):'';

                		$productarr['Delivery Option Title']=isset($order->delivery_title)?$order->delivery_title:'';
                        $productarr['Delivery Option Cost'] =isset($order->delivery_cost)?$order->delivery_cost:'';
                        $productarr['Delivery Option Day'] = isset($order->delivery_day)? date('l jS \, F Y', strtotime($order->created_at. ' + '.$order->delivery_day.' days')):''; 


                		$productarr['Amount'] ='$'.num_format($total_amount,2);
                		$productarr['Product Name'] = isset($productname)?$productname:'';
                		$productarr['Quantity'] =isset($vv['quantity'])?$vv['quantity']:'';
                		$productarr['SKU'] =isset($productinfo['sku'])?$productinfo['sku']:'';
                		$productarr['Transaction Id'] =$order->transaction_id;

                		$productarr['Wallet Amount Used'] = isset($wallet_amount_used)?'$'.num_format($wallet_amount_used):'-';
                		$productarr['Tax'] = '$'.$order->tax;
                		$productarr['Order Status'] =$order_status;


                		/*if(isset($productinfo['sku']))
                		{
                			$productarr['name'] =  'Product Name : '.$productname.' , Qty :'.$vv['quantity'].' , SQU : '.$sku;
                		}else
                		{
                			$productarr['name'] =  'Product Name : '.$productname.' , Qty :'.$vv['quantity'];
                		}*/
                		

                		array_push($order_array,$productarr);
                		$i++;
                	}

                }//if getproduct of orders

                array_push($order_array,$emptyrowarr);

              
             }
             Excel::create($set_sheetname, function($excel) use ($order_array)
             {
                $excel->setTitle('Orders');
                $excel->sheet('Orders', function($sheet) use ($order_array)
                {
                   $sheet->fromArray($order_array, null, 'A1', false, false);
                   $sheet->getColumnDimension('F')->setAutoSize(true) ;

                });

             })->download('csv');

        }//if form date and to date
            
    }// end of function csv



    // send email to seller for dropshipper
    public function send_email_to_sellerfordropshipper($order_arr=false,$order_no,$user=NULL)
	{
		
		$sn_no = 0;

		$arr_email = $product_name = $arr_email_template = [];
		$busineenames='';


		foreach ($order_arr as $key1 => $product_data) 
		{
			$order = [];

			$arr_email = Sentinel::findById($key1)->email;
			$seller[$key1]['seller_id'] = Sentinel::findById($key1);
			$seller[$key1]['email_id'] = $arr_email;

			$dropshiparr = [];

			foreach ($product_data as $key2 => $product) 
			{

				$product_id = isset($product['product_data']['id'])?$product['product_data']['id']:'';
				$dropshipper_id = isset($product['product_data']['drop_shipper'])?$product['product_data']['drop_shipper']:'';

				if(isset($dropshipper_id) && !empty($dropshipper_id))
				{
					
						
					$product_name 				  = isset($product['product_data']['product_name'])?$product['product_data']['product_name']:'';
		 	   		$order[$key2]['order_no']     = $order_no or '';
		 	   		$order[$key2]['product_name'] = $product_name;
		 	   		$order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;


		 	   		$order[$key2]['seller_name']  = get_seller_name($product['seller_id']);

		 	   		// if($product['product_data']['price_drop_to']>0)
		 	   		// {
		 	   		// 	$order[$key2]['unit_price']= isset($product['product_data']['price_drop_to'])?$product['product_data']['price_drop_to']:0;
		 	   		// 	$order[$key2]['total_wholesale_price'] = $product['product_data']['price_drop_to']*$product['item_qty'];

		 	   		// 	$order[$key2]['dropshipper']= '-';
		 	   		// }
		 	   		// else{
		 	   		
		 	   			$dropinfo = get_dropshipper_info($product['product_data']['drop_shipper'],$product['product_data']['id']);
		 	   			if(isset($dropinfo) && !empty($dropinfo))
		 	   			{
		 	   				
		 	   				$order[$key2]['dropshipper']= isset($dropinfo['email'])?$dropinfo['email']:'';
			 	   			$order[$key2]['unit_price']= $dropinfo['unit_price'];
			 	   			$order[$key2]['total_wholesale_price'] = $dropinfo['unit_price']*$product['item_qty'];
			 	   			$dropshiparr[] = $dropinfo['email'];

		 	   		   }//if dropshipinfo
		 	   		  

		 	   		//}

		 	   		if($product['product_data']['shipping_type']==1)
		 	   		{
		 	   			$order[$key2]['shipping_charges']   = isset($product['product_data']['shipping_charges'])?$product['product_data']['shipping_charges']:0;
		 	   		}else{

		 	   			$order[$key2]['shipping_charges']   = 0;
		 	   		}

				}// if isset dropshipper id	
				else{
					unset($order[$key1]);
				}
	 	   		
	 	   	}//foreach productdata



	 	    $address = [];	 	    
	 	    $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$order_no)->first();

	 	    if ($address_details) {

	 	    	$address['shipping'] = isset($address_details['shipping_address1'])?$address_details['shipping_address1']:'';
	 	    	$address['shipping_state'] = isset($address_details['state_details']['name'])?$address_details['state_details']['name']:'';
	 	    	$address['shipping_country'] = isset($address_details['country_details']['name'])?$address_details['country_details']['name']:'';
	 	    	$address['shipping_zipcode'] = isset($address_details['shipping_zipcode'])?$address_details['shipping_zipcode']:'';
	 	        $address['shipping_city'] = isset($address_details['shipping_city'])?$address_details['shipping_city']:'';


	 	    	$address['billing'] = isset($address_details['billing_address1'])?$address_details['billing_address1']:'';
	 	    	$address['billing_state'] = isset($address_details['billing_state_details']['name'])?$address_details['billing_state_details']['name']:'';
	 	    	$address['billing_country'] = isset($address_details['billing_country_details']['name'])?$address_details['billing_country_details']['name']:'';
	 	    	$address['billing_zipcode'] = isset($address_details['billing_zipcode'])?$address_details['billing_zipcode']:'';
	 	    	$address['billing_city'] = isset($address_details['billing_city'])?$address_details['billing_city']:'';


	 	    }

	 	    $site_setting_arr = [];
	        $site_setting_obj = SiteSettingModel::first();  
	        if(isset($site_setting_obj))
	        {
	            $site_setting_arr = $site_setting_obj->toArray();            
	        }

	        
		    $sum = 0;
		    $total_amount = 0;
		    $shipping_charges_sum = 0;


		    if(isset($order) && !empty($order)){
		    	foreach ($order as $key => $order_data) 
				{ 
					$sum += $order_data['total_wholesale_price'];
					$shipping_charges_sum += $order_data['shipping_charges'];				
					$order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
				}	
		    }

		
		   if(isset($order) && !empty($order)){

		    $user_id = $this->UserModel->where('email',$seller[$key1]['email_id'])->first();

            $obj_buyer_age_verification_details = $this->OrderModel->where('order_no',$order_no)->where('seller_id',$user_id['id'])->first();


		   	if($obj_buyer_age_verification_details!=null)
		   	{
		   	  $buyer_age_restrictionflag = $obj_buyer_age_verification_details->buyer_age_restrictionflag;
		   	}


		   	if(isset($buyer_age_restrictionflag) && $buyer_age_restrictionflag == "0") 
            {	

		    $seluser_info = $this->UserModel->where('email',$seller[$key1]['email_id'])->with('seller_detail')->first();

	 	  	$pdf = PDF::loadView('front/dropship_invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address','site_setting_arr','user','seluser_info'));
	 	  	
	 	  	
           	$currentDateTime = $order_no.date('H:i:s').'.pdf';
			

			Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
     	 	$pdfpath = Storage::url($currentDateTime);

     	 	$loggedInUserId = 0;
     	 	if ($userId = Sentinel::check()) {
     	 		
     	 		$loggedInUserId = $userId->id;
     	 	}

     	 	$user_id = $this->UserModel->where('email',$seller[$key1]['email_id'])->first();

     	 	$buyer_details = $this->UserModel->where('id',$loggedInUserId)->first();

          	$obj_email_template = $this->EmailTemplateModel->where('id','110')->first();

          	if($obj_email_template)
  			{
    			$arr_email_template = $obj_email_template->toArray();
    			$content = $arr_email_template['template_html'];
    		}
    		$content = str_replace("##SELLER_NAME##",$user_id['first_name'].' '.$user_id['last_name'],$content);
    		$content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
		    $content = str_replace("##APP_NAME##",config('app.project.name'),$content);


	        $content = view('email.front_general',compact('content'))->render();
	        $content = html_entity_decode($content);

	    	$file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

	    	$to_mail_id = $seller[$key1]['email_id'];


	    	$send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
	        {
	          		
	              $getsellerbusinessinfo = $this->UserModel->with('seller_detail')->where('email',$to_mail_id)->first();
			 	    $busineenames ='';
			 	    if(isset($getsellerbusinessinfo) && !empty($getsellerbusinessinfo))
			 	    {
			 	    	$getsellerbusinessinfo = $getsellerbusinessinfo->toArray();

			 	    	if(isset($getsellerbusinessinfo['seller_detail']['business_name'])){
			 	    	 $busineenames = $getsellerbusinessinfo['seller_detail']['business_name'];
				 	    }else{
				 	     $busineenames = $getsellerbusinessinfo['first_name'].' '.$getsellerbusinessinfo['last_name'];
				 	    }
			 	    }	
			 	    




		        if(isset($arr_email_template) && count($arr_email_template) > 0)
		        {		

		        	 $subj  = str_replace('##order_no##',$order_no,$arr_email_template['template_subject']);  
			 	     $subj  = str_replace('##BUSINESS_NAME##',$busineenames,$subj);  

		        	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
	          		$message->to($to_mail_id);
			        $message->subject($subj);
			        // $message->subject('Dropship Order '.$order_no.' for '.$busineenames);
		        }
		        else
		        {
		        	$admin_email = 'notify@chow420.com';

		        	$message->from($admin_email);
	          		$message->to($to_mail_id);
			        $message->subject('Dropship Order '.$order_no.' for '.$busineenames);
		        }	          	
	          	
			    $message->setBody($content, 'text/html');
			  	$message->attach($file_to_path);
			       
	        });

	       }//if buyer age restriction completed


	       else if(isset($buyer_age_restrictionflag) && $buyer_age_restrictionflag == "1")
	       {
				       	$loggedInUserId = 0;
			     	 	if ($userId = Sentinel::check()) {
			     	 		
			     	 		$loggedInUserId = $userId->id;
			     	 	}

			     	 	$user_id = $this->UserModel->where('email',$seller[$key1]['email_id'])->first();

			     	 	$buyer_details = $this->UserModel->where('id',$loggedInUserId)->first();

			          	$obj_email_template = $this->EmailTemplateModel->where('id','138')->first();

			          	if($obj_email_template)
			  			{
			    			$arr_email_template = $obj_email_template->toArray();
			    			$content = $arr_email_template['template_html'];
			    		}
			    		$content = str_replace("##SELLER_NAME##",$user_id['first_name'].' '.$user_id['last_name'],$content);
			    		$content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
					    $content = str_replace("##APP_NAME##",config('app.project.name'),$content);


				        $content = view('email.front_general',compact('content'))->render();
				        $content = html_entity_decode($content);
				    

				    	$to_mail_id = $seller[$key1]['email_id'];


				    	$send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$arr_email_template,$order_no)
				        {
				          		
				              $getsellerbusinessinfo = $this->UserModel->with('seller_detail')->where('email',$to_mail_id)->first();
						 	    $busineenames ='';
						 	    if(isset($getsellerbusinessinfo) && !empty($getsellerbusinessinfo))
						 	    {
						 	    	$getsellerbusinessinfo = $getsellerbusinessinfo->toArray();

						 	    	if(isset($getsellerbusinessinfo['seller_detail']['business_name'])){
						 	    	 $busineenames = $getsellerbusinessinfo['seller_detail']['business_name'];
							 	    }else{
							 	     $busineenames = $getsellerbusinessinfo['first_name'].' '.$getsellerbusinessinfo['last_name'];
							 	    }
						 	    }	
						 	    
					        if(isset($arr_email_template) && count($arr_email_template) > 0)
					        {		

					        	 $subj  = str_replace('##order_no##',$order_no,$arr_email_template['template_subject']);  
						 	     $subj  = str_replace('##BUSINESS_NAME##',$busineenames,$subj);  

					        	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
				          		$message->to($to_mail_id);
						        $message->subject($subj);
						        // $message->subject('Dropship Order '.$order_no.' for '.$busineenames);
					        }
					        else
					        {
					        	$admin_email = 'notify@chow420.com';

					        	$message->from($admin_email);
				          		$message->to($to_mail_id);
						        $message->subject('Dropship Order '.$order_no.' for '.$busineenames);
					        }	          	
				          	
						    $message->setBody($content, 'text/html');
						       
				        });

	       }

	       }//if isset order array

		}//foreach
		
	}//end function	

	/***************end function to send email to seller for dropshipper********/

	 // send email to dropshipper
    public function send_email_to_dropshipper($order_arr=false,$order_no,$user=NULL)
	{

		$sn_no = 0;

		$arr_email = $product_name = $arr_email_template = [];
		$busineenames='';
		$result = [];

		foreach ($order_arr as $key1 => $product_data) 
		{
			$order = [];

			$arr_email = Sentinel::findById($key1)->email;
			$seller[$key1]['seller_id'] = Sentinel::findById($key1);
			$seller[$key1]['email_id'] = $arr_email;

			$dropshiparr = [];

			foreach ($product_data as $key2 => $product) 
			{

				$product_id = isset($product['product_data']['id'])?$product['product_data']['id']:'';
				$dropshipper_id = isset($product['product_data']['drop_shipper'])?$product['product_data']['drop_shipper']:'';

				if(isset($dropshipper_id) && !empty($dropshipper_id))
				{


					$product_name 				  = isset($product['product_data']['product_name'])?$product['product_data']['product_name']:'';
		 	   		$order[$key2]['order_no']     = $order_no or '';
		 	   		$order[$key2]['product_name'] = $product_name;
		 	   		$order[$key2]['product_id']   = $product_id;
		 	   		$order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;
		 	   		$order[$key2]['seller_id']    = $product['seller_id'];

		 	   		$order[$key2]['seller_name']  = get_seller_name($product['seller_id']);

		 	   		// if($product['product_data']['price_drop_to']>0)
		 	   		// {
		 	   		// 	$order[$key2]['unit_price']= isset($product['product_data']['price_drop_to'])?$product['product_data']['price_drop_to']:0;
		 	   		// 	$order[$key2]['total_wholesale_price'] = $product['product_data']['price_drop_to']*$product['item_qty'];

		 	   		// 	$order[$key2]['dropshipper']= '-';
		 	   		// }
		 	   		// else{
		 	   			$dropinfo = get_dropshipper_info($product['product_data']['drop_shipper'],$product['product_data']['id']);
		 	   			if(isset($dropinfo) && !empty($dropinfo))
		 	   			{
		 	   				
		 	   				$order[$key2]['dropshipper']= isset($dropinfo['email'])?$dropinfo['email']:'';
		 	   				$order[$key2]['dropshipperid']= isset($dropinfo['id'])?$dropinfo['id']:'';
			 	   			$order[$key2]['unit_price']= $dropinfo['unit_price'];
			 	   			$order[$key2]['total_wholesale_price'] = $dropinfo['unit_price']*$product['item_qty'];
			 	   			$dropshiparr[] = $dropinfo['email'];

		 	   		   }//if dropshipinfo
		 	   		  

		 	   		//}

		 	   		if($product['product_data']['shipping_type']==1)
		 	   		{
		 	   			$order[$key2]['shipping_charges']   = isset($product['product_data']['shipping_charges'])?$product['product_data']['shipping_charges']:0;
		 	   		}else{

		 	   			$order[$key2]['shipping_charges']   = 0;
		 	   		}

				}// if isset dropshipper id	
				else{
					unset($order[$key1]);
				}
	 	   		
	 	   	}//foreach productdata



	 	    $address = [];	 	    
	 	    $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$order_no)->first();

	 	    if ($address_details) {

	 	    	$address['shipping'] = isset($address_details['shipping_address1'])?$address_details['shipping_address1']:'';
	 	    	$address['shipping_state'] = isset($address_details['state_details']['name'])?$address_details['state_details']['name']:'';
	 	    	$address['shipping_country'] = isset($address_details['country_details']['name'])?$address_details['country_details']['name']:'';
	 	    	$address['shipping_zipcode'] = isset($address_details['shipping_zipcode'])?$address_details['shipping_zipcode']:'';
	 	        $address['shipping_city'] = isset($address_details['shipping_city'])?$address_details['shipping_city']:'';


	 	    	$address['billing'] = isset($address_details['billing_address1'])?$address_details['billing_address1']:'';
	 	    	$address['billing_state'] = isset($address_details['billing_state_details']['name'])?$address_details['billing_state_details']['name']:'';
	 	    	$address['billing_country'] = isset($address_details['billing_country_details']['name'])?$address_details['billing_country_details']['name']:'';
	 	    	$address['billing_zipcode'] = isset($address_details['billing_zipcode'])?$address_details['billing_zipcode']:'';
	 	    	$address['billing_city'] = isset($address_details['billing_city'])?$address_details['billing_city']:'';


	 	    }

	 	    $site_setting_arr = [];
	        $site_setting_obj = SiteSettingModel::first();  
	        if(isset($site_setting_obj))
	        {
	            $site_setting_arr = $site_setting_obj->toArray();            
	        }

	        
		    $sum = 0;
		    $total_amount = 0;
		    $shipping_charges_sum = 0;


		 
		    if(isset($order) && !empty($order)){
		    	foreach ($order as $key => $order_data) 
				{ 
					$sum += $order_data['total_wholesale_price'];
					$shipping_charges_sum += $order_data['shipping_charges'];				
					$order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
				}	
		    }
		    // echo "<pre>";print_r($order);

		   
			if(isset($order) && !empty($order))
			{
				
				$sumamt = $shipping_charges_sumamt=0;
				foreach($order as $key6 => $value6)
				{
					// $result[] = $value6;
					 if (in_array($value6['dropshipper'], $result))
					 {
					 	$result[] = $value6;
					 }else{
					 	$result[] = $value6;
					 }

				}//foreach on order
		    
		     }//if isset order array

		}//foreach order array



		 if(isset($result) && !empty($result))
		 {	
		 	$dropshipporderarr = [];
		 	foreach($result as $k=>$v)
		 	{
		 		$dropshipporderarr[$v['dropshipper']][$k]['order_no'] = $v['order_no'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['product_name'] = $v['product_name'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['product_id'] = $v['product_id'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['item_qty'] = $v['item_qty'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['seller_name'] = $v['seller_name'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['seller_id'] = $v['seller_id'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['dropshipper'] = $v['dropshipper'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['unit_price'] = $v['unit_price'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['total_wholesale_price'] = $v['total_wholesale_price'];
		 		$dropshipporderarr[$v['dropshipper']][$k]['shipping_charges'] = $v['shipping_charges'];


		 	}//foreach $result
		 }//if isset result
	

	    if(isset($dropshipporderarr))
	    {	
	    	
	    	foreach($dropshipporderarr as $kk=>$vv)
	    	{	
	    		$ordsum = 0;$shipping_charges_sumord=0;
	    		foreach($vv as $data){
	    			//echo "====".$data['total_wholesale_price'];
	    			$ordsum += $data['total_wholesale_price'];
	    			$shipping_charges_sumord += $data['shipping_charges'];	
	    		}
	    		
	    	}
	    }		



	   	 if(isset($dropshipporderarr) && !empty($dropshipporderarr))
	    {	

	       foreach($dropshipporderarr as $k1=>$order)
	       {
	       	  $dropinfoarr = $this->DropShipperModel->where('email',$k1)->first();
	       	  if(isset($dropinfoarr) && !empty($dropinfoarr))
	       	  {
	       	  	$dropinfoarr = $dropinfoarr->toArray();
	       	  }

	       	  $arr_email = $dropinfoarr['email'];
	       	  $dropship[$k1]['email_id'] = $dropinfoarr['email'];

	       	  $dropuser_info = $this->DropShipperModel->where('email',$dropship[$k1]['email_id'])->first();
	       	  if(isset($dropuser_info) && !empty($dropuser_info))
	       	  {
	       	  	$dropuser_info = $dropuser_info->toArray();
	       	  	$drop_sellerid = $dropuser_info['seller_id'];

	       	  	$seluser_info  = $this->UserModel->with('seller_detail')->where('id',$drop_sellerid)->first();
	       	  	if(isset($seluser_info) && !empty($seluser_info))
	       	  	{
	       	  		$seluser_info = $seluser_info->toArray();
	       	  	}
	       	  }
 
           
            $obj_buyer_age_verification_details = $this->OrderModel->where('order_no',$order_no)->where('seller_id',$drop_sellerid)->first();


		   	if($obj_buyer_age_verification_details!=null)
		   	{
		   		$buyer_age_restrictionflag = $obj_buyer_age_verification_details->buyer_age_restrictionflag;
		   	}




            if(isset($buyer_age_restrictionflag) && $buyer_age_restrictionflag == "0") 
            {	
			       	$pdf = PDF::loadView('front/dropshipperemail_invoice',compact('order','order_no','sn_no','address','site_setting_arr','user','seluser_info'));
			       	

		               $currentDateTime = $order_no.date('H:i:s').'.pdf';
					

					Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
		     	 	$pdfpath = Storage::url($currentDateTime);

		     	 	$loggedInUserId = 0;
		     	 	if ($userId     = Sentinel::check()) {
		     	 		
		     	 		$loggedInUserId = $userId->id;
		     	 	}

		     	 	$user_id = $this->DropShipperModel->where('email',$dropship[$k1]['email_id'])->first();

		     	 	$buyer_details = $this->UserModel->where('id',$loggedInUserId)->first();

		          	$obj_email_template = $this->EmailTemplateModel->where('id','47')->first();

		          	if($obj_email_template)
		  			{
		    			$arr_email_template = $obj_email_template->toArray();
		    			$content            = $arr_email_template['template_html'];
		    		}
		    		$content = str_replace("##DROPSHIPPER_NAME##",$user_id['name'],$content);
		    		$content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
		    		$content = str_replace("##APP_NAME##",config('app.project.name'),$content);
				

			        $content = view('email.front_general',compact('content'))->render();
			        $content = html_entity_decode($content);

			    	$file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

			    	$to_mail_id = $dropship[$k1]['email_id'];

			    	$send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
			        {

				        if(isset($arr_email_template) && count($arr_email_template) > 0)
				        {		
				        	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
			          		$message->to($to_mail_id);

			          		$dynamicsubject = $arr_email_template['template_subject'];
			          		$dynamicsubject = str_replace("##order_no##",$order_no, $dynamicsubject);
					       // $message->subject($arr_email_template['template_subject']);
					        $message->subject($dynamicsubject);
					        // $message->subject('Dropship Order');
				        }
				        else
				        {
				        	$admin_email = 'notify@chow420.com';

				        	$message->from($admin_email);
			          		$message->to($to_mail_id);
					        $message->subject('Dropship Order');
				        }	          	
			          	
					    $message->setBody($content, 'text/html');
					  	$message->attach($file_to_path);
					       
			        });

	           }//if buyer age verification completed   


	         /* commented pending age verification email of dropshipper
	         if(isset($buyer_age_restrictionflag) && $buyer_age_restrictionflag == "1") 
	          {
	           	    $loggedInUserId = 0;
		     	 	if ($userId = Sentinel::check()) {
		     	 		
		     	 		$loggedInUserId = $userId->id;
		     	 	}

		     	 	$user_id = $this->DropShipperModel->where('email',$dropship[$k1]['email_id'])->first();

		     	 	$buyer_details = $this->UserModel->where('id',$loggedInUserId)->first();

		          	$obj_email_template = $this->EmailTemplateModel->where('id','139')->first();

		          	if($obj_email_template)
		  			{
		    			$arr_email_template = $obj_email_template->toArray();
		    			$content = $arr_email_template['template_html'];
		    		}
		    		$content = str_replace("##DROPSHIPPER_NAME##",$user_id['name'],$content);
		    		$content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
		    		$content = str_replace("##APP_NAME##",config('app.project.name'),$content);
				

			        $content = view('email.front_general',compact('content'))->render();
			        $content = html_entity_decode($content);
			        	$to_mail_id = $dropship[$k1]['email_id'];

			    	$send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$arr_email_template,$order_no)
			        {

				        if(isset($arr_email_template) && count($arr_email_template) > 0)
				        {		
				        	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
			          		$message->to($to_mail_id);

			          		$dynamicsubject = $arr_email_template['template_subject'];
			          		$dynamicsubject = str_replace("##order_no##",$order_no, $dynamicsubject);
					       // $message->subject($arr_email_template['template_subject']);
					        $message->subject($dynamicsubject);
					        // $message->subject('Dropship Order');
				        }
				        else
				        {
				        	$admin_email = 'notify@chow420.com';

				        	$message->from($admin_email);
			          		$message->to($to_mail_id);
					        $message->subject('Dropship Order');
				        }	          	
			          	
					    $message->setBody($content, 'text/html');
			        });
	           }//else of buyer age verificaiton not completed
				*/

	       }//foreach dropshipper	
	    }//if isset dropshipper	



	
	}//end function	to send email to dropshipper

	/***************end function to send email to dropshipper********/
	
}