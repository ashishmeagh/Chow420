<?php

namespace App\Common\Services;

use App\Models\UserModel;

use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Common\Services\EmailService;
use App\Common\Services\GeneralService;
use App\Models\SiteSettingModel;
use App\Models\UserSubscriptionsModel;
use App\Models\MembershipModel;

use App\Models\StripeCustomersModel;
use App\Models\StripeSubscriptionsModel;
use App\Models\UserReferedModel;
use App\Models\UserReferWalletModel;
use App\Models\EventModel;
use App\Models\SubAdminActivityModel;
use App\Models\BuyerReferedModel;
use App\Models\BuyerRegisteredReferModel;
use App\Models\BuyerWalletModel;


 
use \Session;
use \Sentinel;
use \Activation;
use \DB;
use EmailValidation\EmailValidatorFactory;


class UserService 
{
	public function __construct(EmailService $EmailService,
								UserModel $UserModel,
								GeneralService $GeneralService,
								BuyerModel $BuyerModel,
								SiteSettingModel $SiteSettingModel,
								UserSubscriptionsModel $UserSubscriptionsModel,
								MembershipModel $MembershipModel,
								StripeCustomersModel $StripeCustomersModel,
								StripeSubscriptionsModel $StripeSubscriptionsModel,
								UserReferedModel $UserReferedModel,
								UserReferWalletModel $UserReferWalletModel,
								EventModel $EventModel,
								SellerModel $SellerModel,
                                SubAdminActivityModel $SubAdminActivityModel,
                                BuyerReferedModel $BuyerReferedModel,
                                BuyerRegisteredReferModel $BuyerRegisteredReferModel,
                                BuyerWalletModel $BuyerWalletModel
							)
	{

		$this->EmailService   		  = $EmailService;
		$this->UserModel      		  = $UserModel;	
		$this->BuyerModel     		  = $BuyerModel;		
		//$this->AddressModel   	  = $AddressModel;
		$this->SellerModel    		  = $SellerModel;
		$this->GeneralService 		  = $GeneralService;
		$this->SiteSettingModel       = $SiteSettingModel;
		$this->UserSubscriptionsModel	= $UserSubscriptionsModel;
		$this->MembershipModel			= $MembershipModel;
		$this->StripeCustomersModel   = $StripeCustomersModel;
		$this->StripeSubscriptionsModel = $StripeSubscriptionsModel;
		$this->UserReferedModel       = $UserReferedModel;
		$this->UserReferWalletModel   = $UserReferWalletModel;
		$this->EventModel             = $EventModel;
		$this->SubAdminActivityModel  = $SubAdminActivityModel;
		$this->BuyerReferedModel      = $BuyerReferedModel;
		$this->BuyerRegisteredReferModel = $BuyerRegisteredReferModel;
		$this->BuyerWalletModel       = $BuyerWalletModel;

	}

 
	public function user_registration($arr_data = [])
	{   

		$arr_response = [];
			
		if(isset($arr_data) && count($arr_data)>0){

		$hear_about = isset($arr_data['hear_about'])?$arr_data['hear_about']:'';

		$referal_code = isset($arr_data['referal_code'])?$arr_data['referal_code']:'';
		$refered_email = isset($arr_data['refered_email'])?$arr_data['refered_email']:'';

			$hidden_productid = isset($arr_data['hidden_productid'])?$arr_data['hidden_productid']:'';

			$membership_id = isset($arr_data['subscription'])?$arr_data['subscription']:'';
			$membership_amount = isset($arr_data['amount'])?$arr_data['amount']:'';
			$membership_type = isset($arr_data['membership_type'])?$arr_data['membership_type']:'';

			$stripeToken = isset($arr_data['stripeToken'])?$arr_data['stripeToken']:'';
			$stripe_plan_id = isset($arr_data['stripe_plan_id'])?$arr_data['stripe_plan_id']:'';
			$stripeToken2 = isset($arr_data['stripeToken'])?$arr_data['stripeToken']:'';


			$email          = isset($arr_data['email'])?$arr_data['email']:'';
			$password       = isset($arr_data['password'])?$arr_data['password']:'';
			$first_name     = isset($arr_data['first_name'])?$arr_data['first_name']:'';
			$last_name      = isset($arr_data['last_name'])?$arr_data['last_name']:'';
			$country   		= isset($arr_data['country'])?$arr_data['country']:'';
			$state         = isset($arr_data['state'])?$arr_data['state']:'';
			$mobile_no     = isset($arr_data['mobile_no'])?$arr_data['mobile_no']:'';	
			$user_role_slug = isset($arr_data['role'])?$arr_data['role']:'';
			$seller_qa['seller_question1'] = isset($arr_data['seller_question1'])?$arr_data['seller_question1']:'';
			$seller_qa['seller_question2'] = isset($arr_data['seller_question2'])?$arr_data['seller_question2']:'';
			$seller_qa['seller_question3'] = isset($arr_data['seller_question3'])?$arr_data['seller_question3']:'';
			$seller_qa['seller_answer1'] = isset($arr_data['seller_answer1']) ? "I AGREE" : 'I DISAGREE';
			$seller_qa['seller_answer2'] = isset($arr_data['seller_answer2']) ? "I AGREE" : 'I DISAGREE';
			$seller_qa['seller_answer3'] = isset($arr_data['seller_answer3']) ? "I AGREE" : 'I DISAGREE';

			$business_name      = isset($arr_data['business_name'])?$arr_data['business_name']:'';

			$date_of_birth = isset($arr_data['date_of_birth']) ? $arr_data['date_of_birth'] : '' ;
			$domain_source = isset($arr_data['domain_source']) ? $arr_data['domain_source'] : '' ;


 			

			/*Check provided email is natcasesort(array)ot blank or invaild*/	
			if(!isset($email) || (isset($email) && $email == '')){
				$arr_response['status'] = 'ERROR';
				$arr_response['msg']    = 'Provided email should not be blank or invalid';

				return $arr_response;
			}	
		
			/*Check provided password is not blank or invaild*/
			if(!isset($password) || (isset($password) && $password == '')){
				$arr_response['status'] = 'ERROR';
				$arr_response['msg']    = 'Provided password should not be blank or invalid';

				return $arr_response;
			}
			
			/***************Email*valiation library code*******/
			  $validator = EmailValidatorFactory::create($email);
              $arrayResult = $validator->getValidationResults()->asArray();
              
             
              if(isset($arrayResult) && !empty($arrayResult))
              {
                $valid_format = isset($arrayResult['valid_format'])?$arrayResult['valid_format']:'';
                $valid_mx_records = isset($arrayResult['valid_mx_records'])?$arrayResult['valid_mx_records']:'';
                $possible_email_correction = isset($arrayResult['possible_email_correction'])?$arrayResult['possible_email_correction']:'';
                $free_email_provider = isset($arrayResult['free_email_provider'])?$arrayResult['free_email_provider']:'';
                $role_or_business_email = isset($arrayResult['role_or_business_email'])?$arrayResult['role_or_business_email']:'';
                $valid_host = isset($arrayResult['valid_host'])?$arrayResult['valid_host']:'';
                $disposable_email_provider = isset($arrayResult['disposable_email_provider'])?$arrayResult['disposable_email_provider']:'';
                 if($valid_format==true && $valid_mx_records==true && $disposable_email_provider==false)
                 {

                 }else{
                 	$arr_response['status'] = 'ERROR';
					$arr_response['msg']    = 'Please use valid email this email is not supported.';
					return $arr_response;
                 } 	

              }

			/***********Email validation library code*end****************/





			/*Check provided role is not blank or invaild*/
			if(Sentinel::findRoleBySlug($user_role_slug)==null){
				
				$arr_response['status'] = 'ERROR';
				$arr_response['msg']    = 'Provided role is not valid';

				return $arr_response;
			}
			else
			{

				/*check email duplication*/
				if(Sentinel::findByCredentials(['email'=>$email,'deleted_at!'=>NULL ]) != null)
				{

					$arr_response['status'] = 'ERROR';
					$arr_response['msg']    = 'Provided email already exists in system, you may try different email';
					
					return $arr_response;
				}
				// dd($arr_response);

				/* check email validation */
				$recheck_user = DB::table('users')->select('email')->where('email', $email)->where('user_type', 'buyer')->where('deleted_at','!=',NULL)->first();
				// $recheck_user = $this->UserModel->where('email',$email)->first();
				if($recheck_user){
					$arr_response['status'] = 'ERROR';
					$arr_response['msg']    = 'Provided email has been deactivated, please contact the admin to reactivate it. ';

					return $arr_response;
				}
				
				/* end */

				/*Register user with provided credentials*/
				$credentials                   = [];
				$credentials['email']          = $email;
				$credentials['password']       = $password;
				$credentials['first_name']     = ucfirst($first_name);
				$credentials['last_name']      = ucfirst($last_name);
				$credentials['user_type']      = $user_role_slug;
				$credentials['country']   	   = $country;
				$credentials['state']          = $state;
				$credentials['phone']          = trim($mobile_no);	

				//$credentials['country_id']     = $country_id;
				$credentials['is_trusted']      = 1;
				$credentials['is_active']       = '1';

				$credentials['hear_about']          = $hear_about;

				$credentials['date_of_birth']        = $date_of_birth;

			    //$credentials['domain_source'] = $domain_source;

				 
				/*$credentials['ref_no']         = md5(uniqid(rand().time(), true));*/


				  $site_setting_arr = [];

		          $site_setting_obj = SiteSettingModel::first();  

		          if(isset($site_setting_obj))
		          {
		            $site_setting_arr = $site_setting_obj->toArray();            
		          }


				$arr_subscription =[]; 
				if($user_role_slug == 'seller')							
			    {
			    	//if($domain_source=="https://chow420.com/")
			        if(isset($domain_source) && $domain_source=="beta.chow420.com") 		
			    	{
			    		$credentials['domain_source'] = 1;
			    	}
			    	else{
			    		$credentials['domain_source'] = 2;
			    	}
							    	
						/*$site_setting_arr = [];

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

						}*/




					  $stripe_secret_key ='';
			         

			          if(isset($site_setting_arr) && count($site_setting_arr)>0)
			          {
			               $payment_mode = $site_setting_arr['payment_mode'];
			               $sandbox_stripe_public_key = $site_setting_arr['sandbox_stripe_public_key'];
			               $sandbox_stripe_secret_key = $site_setting_arr['sandbox_stripe_secret_key'];
			               $live_stripe_public_key = $site_setting_arr['live_stripe_public_key'];
			               $live_stripe_secret_key = $site_setting_arr['live_stripe_secret_key'];

			               if($payment_mode=='0' && isset($site_setting_arr['sandbox_stripe_secret_key']))
			               {
			                  $stripe_secret_key =  $site_setting_arr['sandbox_stripe_secret_key'];
			               }
			               else if($payment_mode=='1' && isset($site_setting_arr['live_stripe_secret_key']))
			               {
			                   $stripe_secret_key = $site_setting_arr['live_stripe_secret_key'];
			               }

			          }


						/****************commented square code*****************/
						# setup authorization
				       /* $api_config = new \SquareConnect\Configuration();

						if(isset($sandbox_url) && $payment_mode=='0') 
	        			    $api_config->setHost($sandbox_url);	      	
	        			else if(isset($live_url) && $payment_mode=='1')  
	        			    $api_config->setHost($live_url);
				        
				        if(isset($sandbox_access_token) && $payment_mode=='0')
				        	$api_config->setAccessToken($sandbox_access_token);
				         elseif(isset($live_access_token) && $payment_mode=='1')
				         	$api_config->setAccessToken($live_access_token);


	      				$api_client = new \SquareConnect\ApiClient($api_config);

	      					# create an instance of the Transaction API class
				      	$payments_api = new \SquareConnect\Api\PaymentsApi($api_client);
				      	

				      	$nonce = $arr_data['nonce'];

				      	$body = new \SquareConnect\Model\CreatePaymentRequest();

				      	$amountMoney = new \SquareConnect\Model\Money();
				      	
				      	$amountMoney->setAmount(100*ceil($membership_amount));
				      	$amountMoney->setCurrency("USD");

				      	$body->setSourceId($nonce);
				      	$body->setAmountMoney($amountMoney);
				      //	$body->setBuyerEmailAddress($email);

				      	if(isset($sandbox_location_id) && $payment_mode=='0')
				      		$body->setLocationId($sandbox_location_id);
				      	elseif(isset($live_location_id) && $payment_mode=='1')
				      		$body->setLocationId($live_location_id);
	      				$body->setIdempotencyKey(uniqid());*/
				     /*************end of**commented square code*****************/


			    }// if role is seller

			    if($user_role_slug=="seller" && $membership_type=="2")
			    { 	
			    	$user = Sentinel::register($credentials);

			    	       /****************commented square code*****************/

				    	   /*try {
					          	$result = $payments_api->createPayment($body);
						        if($result['payment']['id']){
						         
						          	$arr_subscription['transaction_id'] = $result['payment']['id'];
						          	$arr_subscription['payment_status'] = '1';
						          	$user = Sentinel::register($credentials);
						        }
					      	} catch (\SquareConnect\ApiException $e) {
					      			$arr_response['status'] = "failure";
						          	$arr_response['msg'] = $e->getResponseBody();
	                    			return $arr_response;
					          	
					      	}*/

					      /****************commented square code*****************/

					    



			    }else
			    {
			       $user = Sentinel::register($credentials);
			    }



			
				/*dd($user->id);*/
				if($user)
				{ 

					/****************check activation code*********/

					    $check_user_exists = $this->UserModel->where('id',$user->id)->first();
                                   
	                    if(isset($check_user_exists) && !empty($check_user_exists))
	                    {
	                      $check_user_exists = $check_user_exists->toArray();

	                      if(isset($check_user_exists['activationcode']) && !empty($check_user_exists['activationcode']))
	                      {

	                      }
	                      else
	                      {
	                          $create_activationcode = unique_code(8);
	                          $check_actcode_exists = $this->UserModel->where('activationcode',$create_activationcode)->get();
	                          if(isset($check_actcode_exists) && !empty($check_actcode_exists))
	                          {
	                            $check_actcode_exists = $check_actcode_exists->toArray();
	                          }
	                          if(isset($check_actcode_exists) && !empty($check_actcode_exists))
	                          {
	                            $create_actcode = unique_code(8);
	                          }else{
	                            $create_actcode = $create_activationcode;
	                          }
	                          $update_activationcode =[];
	                          $update_activationcode['activationcode'] = $create_actcode;

	                          $this->UserModel->where('id',$user->id)->update($update_activationcode);
	                      }//else of user activation code exists
	                   }//if user code exists		



					/***************check activation code******/
					
					$arr_maker = [];
					$msg2 ='';
					$user_membership_url ='';

					if($user_role_slug == 'buyer')							
					{
						$arr_buyer['user_id']           = $user->id;
						$arr_buyer['sorting_order_by']  = date('Y-m-d H:i:s');				
						$store_buyer_details = $this->BuyerModel->create($arr_buyer);



						/*************Referal code check* for buyer*********/

						    if(isset($site_setting_arr) && count($site_setting_arr)>0)
			               {
			                   $buyer_referal_amount = isset($site_setting_arr['buyer_referal_amount'])?$site_setting_arr['buyer_referal_amount']:config('app.project.buyer_referal');

			                   $buyer_refered_amount = isset($site_setting_arr['buyer_refered_amount'])?$site_setting_arr['buyer_refered_amount']:config('app.project.buyer_referal');


			               } // if site_setting_arr


							$getbuyeridofcode = $this->UserModel->where('referal_code',$referal_code)->where('is_active','1')->first();
				            if(isset($getbuyeridofcode) && !empty($getbuyeridofcode))
				            {
				                $getbuyeridofcode   = $getbuyeridofcode->toArray();
				                $refereral_buyer_id = $getbuyeridofcode['id'];
				            }

				            $get_buyer_refered = $this->BuyerReferedModel
				            						->where('code',$referal_code)
				            						->where('email',$refered_email)
				            						->first();
				            if(isset($get_buyer_refered) && !empty($get_buyer_refered))
				            {
				            	$get_buyer_refered = $get_buyer_refered->toArray();
				            }  	

				            if(isset($get_buyer_refered) && !empty($get_buyer_refered) && $email==$refered_email)
				            {
				               $check_buyer_refered_exists = $this->BuyerRegisteredReferModel->where('email',$email)->where('code',$referal_code)->where('referal_id',$user->id)->get();

				                if(isset($check_buyer_refered_exists) && !empty($check_buyer_refered_exists)){
				                	$check_buyer_refered_exists = $check_buyer_refered_exists->toArray();
				                }


				               if(isset($check_buyer_refered_exists) && !empty($check_buyer_refered_exists)){

				               }
				               else
				               {

				               	 //buyer refered registered insert record
				               	 $create_refered_regis_buyer  = [];
				               	 $create_refered_regis_buyer['user_id'] = $get_buyer_refered['user_id'];
				               	 $create_refered_regis_buyer['user_refered_id'] = $get_buyer_refered['id'];
				               	 $create_refered_regis_buyer['email'] = $get_buyer_refered['email'];
				               	 $create_refered_regis_buyer['code'] = $get_buyer_refered['code'];
				               	 $create_refered_regis_buyer['amount'] = '';
				               	 $create_refered_regis_buyer['referal_id'] = $user->id;

				               	 $create_refered_regis_buyer['order_id'] = '';
 								 $create_refered_regis_buyer['order_no'] = '';
 								 $create_refered_regis_buyer['is_shipped'] = 0;
				               	 $buyer_regisered_pk = $this->BuyerRegisteredReferModel->create($create_refered_regis_buyer);


				               	 	//update user table field for is this a refered user
				               	    $arr_buyer_refered = [];
				               	    $arr_buyer_refered['is_refered_buyer'] = 1; 
				               	 	$this->UserModel->where('id',$user->id)->update($arr_buyer_refered);

                                    
                                    // add entry of refered buyer in wallet

                                    $buyer_wallet_tbl = [];
			   	  			    	$buyer_wallet_tbl['user_id'] = $user->id;  // to referd
			   	  			    	$buyer_wallet_tbl['type'] = 'Refered';
			   	  			    	$buyer_wallet_tbl['typeid'] = $get_buyer_refered['user_id'];// from who refer
			   	  			    	$buyer_wallet_tbl['amount'] = isset($buyer_refered_amount)? 
			   	  			    	'+'.$buyer_refered_amount:'';
			   	  			    	$buyer_wallet_tbl['status'] = 1;   //in wallet
			   	  			    	$create_wallet = $this->BuyerWalletModel->create($buyer_wallet_tbl);



			   	  			    	//Add entry of referal (who refer) user 

			   	  			    	$buyer_who_referwallet_tbl = [];
			   	  			    	$buyer_who_referwallet_tbl['user_id'] = $get_buyer_refered['user_id'];  // from who refer
			   	  			    	$buyer_who_referwallet_tbl['type'] = 'Referal';
			   	  			    	$buyer_who_referwallet_tbl['typeid'] = $buyer_regisered_pk->id;
			   	  			    	$buyer_who_referwallet_tbl['amount'] = isset($buyer_referal_amount)? 
			   	  			    	'+'.$buyer_referal_amount:'';
			   	  			    	$buyer_who_referwallet_tbl['status'] = 0; //pending
			   	  			    	$create_wallet = $this->BuyerWalletModel->create($buyer_who_referwallet_tbl);

			   	  			    	

                                    /***************send noti to referal(who refer)************/

                                    	// $user_reg_url1 = url('/').'/'.config('app.project.admin_panel_slug').'/buyers/view/'.base64_encode($user->id);

                                        $user_reg_url1 = url('/').'/buyer/wallet';

                                    	$arr_event                 = [];
						               	$arr_event['from_user_id'] = $user->id;
						                $arr_event['to_user_id']   = $get_buyer_refered['user_id'];
						                $arr_event['type']         = 'Buyer';
						                $arr_event['description']  = 'A new user  <a target="_blank" href="'.$user_reg_url1.'"><b>'.$email.'</b></a> signup in the chow, $'.$buyer_referal_amount.' successfully credited to wallet if his order is shipped.';
						                $arr_event['title']        = 'New Referal Buyer Registration';
						                
						                $this->GeneralService->save_notification($arr_event);

						                 $user_detal_arr = $this->UserModel->where('id',$get_buyer_refered['user_id'])->first();
									      if($user_detal_arr)
									      {
									        $arr_user = $user_detal_arr->toArray();
									        $user_reg_url1 = url('/').'/buyer/wallet';

									        $msg3     = 'A new user  <a target="_blank" href="'.$user_reg_url1.'"><b>'.$email.'</b></a> signup in the chow, $'.$buyer_referal_amount.' successfully credited to wallet if his order is shipped.';
									       
				                            $subject3 = 'New Referal Buyer Registration';
				                            $arr_built_content = ['USER_NAME'     => $arr_user['email'],
				                                                  'APP_NAME'      => config('app.project.name'),
				                                                 // 'MESSAGE'       => $msg3,
				                                                  'URL'           => $user_reg_url1,
				                                                  'EMAIL'=>$email,
				                                                  'AMOUNT'=>$buyer_referal_amount
				                                                 ];

				                            $arr_mail_data2['email_template_id'] = '116';
				                            $arr_mail_data2['arr_built_content'] = $arr_built_content;
				                            $arr_mail_data2['arr_built_subject'] = '';
				                            $arr_mail_data2['user']              = $arr_user;

				                            $this->EmailService->send_mail_section($arr_mail_data2);
				                        }// if user_detal_arr


				                        $user_reg_url1 = url('/').'/buyer/wallet';
                                    	$arr_event                 = [];
						               	$arr_event['from_user_id']= $get_buyer_refered['user_id'];
						                $arr_event['to_user_id']   = $user->id;
						                $arr_event['type']         = 'Buyer';
						                $arr_event['description']  = '  <a target="_blank" href="'.$user_reg_url1.'"><b>'.$email.'</b></a> successfully signup in the chow, $'.$buyer_refered_amount.' successfully credited to wallet.';
						                $arr_event['title']        = 'Refered Buyer Registration Wallet Credited';
						                
						                $this->GeneralService->save_notification($arr_event);


                                    /****************end of refered*buyer********/

				               }//else refered buyer entry


				            }//if isset refer
				          


						/***********end of referal code check*for buyer****/








					}//if user is buyer	

					if($user_role_slug == 'seller')							
					{
						$arr_seller['user_id']          = $user->id;
						$arr_seller['seller_question_answer']     = json_encode($seller_qa);
						$arr_seller['business_name']    = $business_name;	
						$arr_seller['approve_status']   = '1';  //auto approved
						$arr_seller['sorting_order_by'] = date('Y-m-d H:i:s');	
						$store_seller_details = $this->SellerModel->create($arr_seller);

						 $businessname = str_replace(' ','-',$business_name);  


		                  /* $arr_eventdata             = [];
		                   $arr_eventdata['user_id']  =  $user->id;
		                   $arr_eventdata['message']  = '<div class="discription-marq">
		                        <div class="mainmarqees-image">
		                         <img src="'.url('/').'/assets/front/images/chow.png" alt="">
		                         </div>
		                      <b>'.$business_name.'</b> just joined chow.<div class="clearfix"></div></div><a target="_blank" class="viewcls" href="search?sellers='.$businessname.'">View</a>';

		                   $arr_eventdata['title']    = 'Business Name';                        
		                   $this->EventModel->create($arr_eventdata);*/


						/*************create strip customer*********/

						if($membership_type=="2"){

				
						 /*************create subscription*************/  
						    	//if($stripe_customer_id)
						    	//{

						    	    try { 
							           
						    	    	$usersubscribe = UserModel::find($user->id);
							            $subscriptiondata = $usersubscribe->newSubscription('main', $stripe_plan_id)->create($stripeToken, [
										    'email' => $email,
										]);

							           
							        }
							        catch(\Stripe\Error\Card $e) {
							        	
									    $arr_response['status'] = "ERROR";
							          	$arr_response['cardmsg'] = $e->getMessage();

							          	$update_emailarr = [];
							          	$update_emailarr['email'] = 'decline_'.$email;
							          	$this->UserModel->where('id',$user->id)->update($update_emailarr);

							          	$this->UserModel->where('id',$user->id)->delete();
							          	$this->SellerModel->where('user_id',$user->id)->delete();
							          	return $arr_response;

							          	/*try
										{
											dd($user->stripe_id);	
								          	\Stripe\Stripe::setApiKey($stripe_secret_key);

											$customer = \Stripe\Customer::retrieve(
											  $user->stripe_id
											);
											$customer->delete();

											return $arr_response;

										}
										catch(Exception $e)
										{ 
		                                   
							      			$arr_response['status'] = "ERROR";
								          	$arr_response['msg'] = $e->getMessage();
			                    			return $arr_response;
		                                } */	
		                    			
									} 
							        catch (Exception $e)
							        { 
							        	
						      			$arr_response['status'] = "ERROR";
							          	$arr_response['msg'] = $e->getMessage();
		                    			return $arr_response;
						          	
							        }
							        //catch
							        /* catch (IncompletePayment $e) {
									    if ($e instanceof \Laravel\Cashier\Exceptions\PaymentActionRequired) {
									        return redirect()->route('confirm_payment', [$e->payment->id, 'redirect' => route('home')]);
									    } else {
									        dump($e); die;
									    }
									}*/

							         if($subscriptiondata)
                                    {
                                        $subscriptiondata = $subscriptiondata->jsonSerialize(); 

                                       /**************check status of subscripiton*****************/ 
							          

							           $subscribe_status='';

                                        try
										{
	                                        \Stripe\Stripe::setApiKey($stripe_secret_key);

										    $subscibedata = \Stripe\Subscription::retrieve     (
													  $subscriptiondata['stripe_id']
													);

										    $subscribe_status = $subscibedata['status'];
										   
										}
										catch(Exception $e)
										{ 
		                                   
							      			$arr_response['status'] = "ERROR";
								          	$arr_response['msg'] = $e->getMessage();
			                    			return $arr_response;
		                                } 	

		                                /***************************************/

                                        $subsrc_arr =[
                                                         'subscription_id'=>$subscriptiondata['stripe_id'],
                                                         'customer_id'=>$subscriptiondata['user_model_id'],
                                                         'plan_id'=>$subscriptiondata['stripe_plan'],
                                                         'membership_id'=>$membership_id,
                                                         'status'=>$subscribe_status
                                                        ];    
                                                   
                                        $stripe_subscrinsert_id = $this->StripeSubscriptionsModel->create($subsrc_arr);    
                                        $stripe_subscription_id = $subscriptiondata['id'];
                                        
                                        $arr_subscription['transaction_id'] = $stripe_subscription_id;	
                                        $arr_subscription['payment_status'] = '1';
                                        $arr_subscription['subscribe_status']=$subscribe_status;


                                           $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();

                                		    $product_count='';
                                		    
			                                if(!empty($get_panname))
			                                {
			                                    $get_panname = $get_panname->toArray();
			                                    $product_count = $get_panname['product_count'];

			                                    $pcountarr = [];
			                                    $pcountarr['product_limit']=$product_count;
			                                }
                                            $this->UserModel->where('id',$user->id)->update($pcountarr);


                                        
                                   }//if subscription data

						    	//}//if stripe customer id

						    /*************end of create subscription******/

					  //  }//else customerid

					 }//if paid memerbship
					 else if($membership_type=="1")
					 {
					 	$get_panname  = $this->MembershipModel->where('id',$membership_id)->first();

            		    $product_count='';
            		    
                        if(!empty($get_panname))
                        {
                            $get_panname = $get_panname->toArray();
                            $product_count = $get_panname['product_count'];

                            $pcountarr = [];
                            $pcountarr['product_limit']=$product_count;
                        }
                        $this->UserModel->where('id',$user->id)->update($pcountarr);

					 }//else if type 1

				   /*****************************************/
						

				   			$get_panname  = $this->MembershipModel->where('id',$membership_id)->first();
				   	         $product_count='';
            		    
	                        if(!empty($get_panname))
	                        {
	                            $get_panname = $get_panname->toArray();
	                            $product_count = $get_panname['product_count'];
						        $arr_subscription['product_limit'] = $product_count;
                            
	                        }		


						$arr_subscription['user_id']     = $user->id;
						$arr_subscription['membership_id'] = $membership_id ;
						$arr_subscription['membership'] = $membership_type;
						$arr_subscription['membership_amount'] = $membership_amount;
						$arr_subscription['membership_status'] = '1';
						
						$store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);

						/*************Referal code check**********/
							$getuseridofcode = $this->UserModel->where('referal_code',$referal_code)->where('is_active','1')->first();
				            if(isset($getuseridofcode) && !empty($getuseridofcode))
				            {
				                $getuseridofcode   = $getuseridofcode->toArray();
				                $refereral_user_id = $getuseridofcode['id'];
				            }

				            $get_user_refered = $this->UserReferedModel
				            						->where('code',$referal_code)
				            						->where('email',$refered_email)
				            						->first();
				            if(isset($get_user_refered) && !empty($get_user_refered))
				            {
				            	$get_user_refered = $get_user_refered->toArray();
				            }  	

				            if(isset($get_user_refered) && !empty($get_user_refered) && $email==$refered_email)
				            {
				               $check_userwallet_exists = $this->UserReferWalletModel->where('email',$email)->where('code',$referal_code)->where('referal_id',$user->id)->get();

				                if(isset($check_userwallet_exists) && !empty($check_userwallet_exists)){
				                	$check_userwallet_exists = $check_userwallet_exists->toArray();
				                }


				               if(isset($check_userwallet_exists) && !empty($check_userwallet_exists)){

				               }else{

				               	 //user wallet insert record
				               	 $create_walletarr  = [];
				               	 $create_walletarr['user_id'] = $get_user_refered['user_id'];
				               	 $create_walletarr['user_refered_id'] = $get_user_refered['id'];
				               	 $create_walletarr['email'] = $get_user_refered['email'];
				               	 $create_walletarr['code'] = $get_user_refered['code'];
				               	 $create_walletarr['amount'] = config('app.project.seller_referal');
				               	 $create_walletarr['referal_id'] = $user->id;
				               	 $this->UserReferWalletModel->create($create_walletarr);
                                    /*****************************************/

                                    	$user_reg_url1 = url('/').'/'.config('app.project.admin_panel_slug').'/sellers/view/'.base64_encode($user->id);

                                    	$arr_event                 = [];
						               	$arr_event['from_user_id'] = $user->id;
						                $arr_event['to_user_id']   = $get_user_refered['user_id'];
						                $arr_event['type']         = 'Seller';
						                $arr_event['description']  = 'A new user  <a target="_blank" href="'.$user_reg_url1.'"><b>'.$email.'</b></a> signup in the chow, $'.config('app.project.seller_referal').' successfully credited to wallet.';
						                $arr_event['title']        = 'New Referal User Registration';
						                
						                $this->GeneralService->save_notification($arr_event);

						                 $user_detal_arr = $this->UserModel->where('id',$get_user_refered['user_id'])->first();
									      if($user_detal_arr)
									      {
									        $arr_user = $user_detal_arr->toArray();
									         $user_reg_url1 = url('/');

									        $msg3     = 'A new user  <a target="_blank" href="'.$user_reg_url1.'"><b>'.$email.'</b></a> signup in the chow, $'.config('app.project.seller_referal').' successfully credited to wallet.';
									       
				                            $subject3 = 'New Referal User Registration';
				                            $arr_built_content = ['USER_NAME'     => $arr_user['email'],
				                                                  'APP_NAME'      => config('app.project.name'),
				                                                 // 'MESSAGE'       => $msg3,
				                                                  'URL'           => $user_reg_url1,
				                                                  'EMAIL'=>$email,
				                                                  'AMOUNT'=>config('app.project.seller_referal')
				                                                 ];

				                            $arr_mail_data2['email_template_id'] = '116';
				                            $arr_mail_data2['arr_built_content'] = $arr_built_content;
				                            $arr_mail_data2['arr_built_subject'] = '';
				                            $arr_mail_data2['user']              = $arr_user;

				                            $this->EmailService->send_mail_section($arr_mail_data2);
				                        }


                                    /****************end of referalwallet*********/

				               }//else


				            }//if isset refer
				          


						/***********end of referal code check*****/


    				}//if seller

					$activation = Activation::create($user);

					if($activation)
          			{	
          					if($user_role_slug=='buyer')
                            {
                            	$user_reg_url = url('/').'/'.config('app.project.admin_panel_slug').'/buyers/view/'.base64_encode($user->id);
                            }
                            else if($user_role_slug=='seller')
                            {
                            	$user_reg_url = url('/').'/'.config('app.project.admin_panel_slug').'/sellers/view/'.base64_encode($user->id);
                            }
                            else
                            {
                            	$user_reg_url = url('/').'/'.config('app.project.admin_panel_slug');
                            }

          				/******************Notification to admin START*******************************/
			                $admin_role = Sentinel::findRoleBySlug('admin');  

			                $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
			                $admin_id   = 0;
			                if($admin_obj)
			                {
			                    $admin_id = $admin_obj->user_id;            
			                }
			                

			                if($user_role_slug=='buyer')
                            {
                            	$arr_event                 = [];
				               	$arr_event['from_user_id'] = $user->id;
				                $arr_event['to_user_id']   = $admin_id;
				                $arr_event['type']         = 'admin';
				                $arr_event['description']  = 'A new user <a target="_blank" href="'.$user_reg_url.'"><b>'.$email.'</b></a> has been registered successfully as a <b>'.$user_role_slug.'</b>.';
				                $arr_event['title']        = 'New User Registration';
				                
				                $this->GeneralService->save_notification($arr_event);

				                //$msg     = 'A new user <b>'.$email.'</b> has been registered successfully as a <b>'.$user_role_slug.'</b>.';

				                //$subject = 'New User Registration';

                                $arr_built_content = ['USER_NAME' => config('app.project.admin_name'),
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'EMAIL'         => $email,
                                                  'USER_ROLE'     => $user_role_slug, 
                                                  'URL'           => $user_reg_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '117';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($admin_id);

                             //dd($arr_built_content);

                            $this->EmailService->send_mail_section($arr_mail_data);


                            }
                            else if($user_role_slug=='seller')
                            {


                            	$plan_name ='';

                               $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();
                                
                                if(!empty($get_panname)){
                                    $get_panname = $get_panname->toArray();
                                    $plan_name = $get_panname['name'];
                                }


                                // send noti to admin
                            	$arr_event                 = [];
				               	$arr_event['from_user_id'] = $user->id;
				                $arr_event['to_user_id']   = $admin_id;
				                $arr_event['type']         = 'admin';

				                

				                if($membership_type==1)
				                {
				               
				                	  $arr_event['description']  = 'A new user <a target="_blank" href="'.$user_reg_url.'"><b>'.$email.'</b></a> has been registered successfully as a dispensary having <b> '.$plan_name.' </b> membership plan .';
				                }
				                else
				                {
				                	  $set_amount =  '$'.number_format($membership_amount);
				                	  $arr_event['description']  = 'A new user <a target="_blank" href="'.$user_reg_url.'"><b>'.$email.'</b></a> has been registered successfully as a  dispensary having <b> '.$plan_name.' </b> membership plan of amount '.$set_amount.' .';
				                	
			                 	}	

				              
				                $arr_event['title']        = 'New User Registration';
				                
				                $this->GeneralService->save_notification($arr_event);

				                // send noti to user
				                $arr_event                 = [];
				               	$arr_event['from_user_id'] = $admin_id;
				                $arr_event['to_user_id']   = $user->id;
				                $arr_event['type']         = 'Seller';
				                if($membership_type==1)
				                {

				                	$arr_event['description']  = 'You have successfully selected the <b> '.$plan_name.' </b> membership plan.';
				                }
				                else
				                {

				                	$set_amount =0;

                                    // if($membership_amount>0){
                                    //    $set_amount =  '$'.rtrim(rtrim(strval($membership_amount), "0"), ".");
                                    // }else{
                                    //    $set_amount =  '$'.$membership_amount;
                                    // }

                                       $set_amount =  '$'.number_format($membership_amount);

				                	$arr_event['description']  = 'You have successfully selected the <b> '.$plan_name.' </b> membership plan of amount '.$set_amount.'.';

				                }
				                $arr_event['title']        = 'Membership Purchase';
				                
				                $this->GeneralService->save_notification($arr_event);



				                if($membership_type==1)
				                {
				                	$set_amount = 0;
				                	$msg     = 'A new user <b>'.$email.'</b> has been registered successfully as a dispensary having <b> '.$plan_name.'  </b>membership plan.';

				                 	$msg2     = 'You have successfully selected the <b> '.$plan_name.' </b> membership plan.';

				                }
				                else
				                {

				                	$set_amount = 0;

                                    // if($membership_amount>0){
                                    //    $set_amount =  '$'.rtrim(rtrim(strval($membership_amount), "0"), ".");
                                    // }else{
                                    //    $set_amount =  '$'.$membership_amount;
                                    // }
                                       $set_amount =  '$'.number_format($membership_amount);
                                    


				                 	$msg     = 'A new user <b>'.$email.'</b> has been registered successfully as a dispensary having <b> '.$plan_name.'  </b>membership plan of amount '.$set_amount.' .';

				                 	$msg2     = 'You have successfully selected the <b> '.$plan_name.' </b> membership plan of amount '.$set_amount.'.';
			                 	}


                                $arr_built_content = ['USER_NAME' => config('app.project.admin_name'),
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'EMAIL'         => $email,
                                                  'PLAN_NAME'     => $plan_name,
                                                  'AMOUNT'        => $set_amount,  
                                                  'URL'           => $user_reg_url
                                                 ];

                 
	                            $arr_mail_data['email_template_id'] = '118';
	                            $arr_mail_data['arr_built_content'] = $arr_built_content;
	                            $arr_mail_data['arr_built_subject'] = '';
	                            $arr_mail_data['user']              = Sentinel::findById($admin_id);


	                            $this->EmailService->send_mail_section($arr_mail_data);
                            }



			              
		            	/*************Notification to admin END*******************/

		            	/***********Send Notification Mail to Admin (START)*********/
		            		//$msg     = 'A new user <b>'.$email.'</b> has been registered successfully as a <b>'.$user_role_slug.' having '.$membership.' membership plan of 3 months starts from '.$membership_startdate.' to '.$membership_endate.' </b>.';

                          	// email to admin                         
                           

                            if($user_role_slug=='seller'){

		                            // email to user        

		                              $user_detal_arr = $this->get_user_details($email);
								      if($user_detal_arr)
								      {
								        $arr_user = $user->toArray();

								        $user_membership_url = url('/').'/seller/membership_detail';

			                            //$subject2 = 'Membership Purchase';
			                            $arr_built_content = ['USER_NAME'     => $email,
			                                                  'APP_NAME'      => config('app.project.name'),
			                                                  //'MESSAGE'       => $msg2,
			                                                  'AMOUNT'        => $set_amount,
			                                                  'PLAN_NAME'     => $plan_name, 
			                                                  'URL'           => $user_membership_url
			                                                 ];

			                            $arr_mail_data2['email_template_id'] = '119';
			                            $arr_mail_data2['arr_built_content'] = $arr_built_content;
			                            $arr_mail_data2['arr_built_subject'] = '';
			                            $arr_mail_data2['user']              = $arr_user;

			                            $this->EmailService->send_mail_section($arr_mail_data2);
			                        }
			                }// if seller then send email of membership 

                    	/*********************Send Notification Mail to Admin (END)*****************/


          				$role = Sentinel::findRoleBySlug($user_role_slug);

						$role->users()->attach($user);



						//this code below line commented added condition for buyer redirection
						//$arr_mail_data = $this->registration_activation_built_mail_data($email, $activation->code); 
						 if(isset($user_role_slug) && $user_role_slug == "buyer")
                         {
                         	$arr_mail_data = $this->registration_activation_built_mail_data($email, $activation->code,$hidden_productid);
                         }
                         else{
                         	$arr_mail_data = $this->registration_activation_built_mail_data($email, $activation->code);
                         }




		                $email_status  = $this->EmailService->send_mail($arr_mail_data);


		                if(\Mail::failures())
		                {
		                    $arr_response['status']   = 'ERROR';
		                    $arr_response['msg']      = 'Error occured while sending email of account verification.';

		                    return $arr_response;
		                }
		                else
		                { 
                            if(isset($user_role_slug) && $user_role_slug == "seller")
                            {

                            	/*$arr_eventdata                 = [];
				               	$arr_eventdata['user_id']      = $user->id;
				                $arr_eventdata['message']  = '<div class="discription-marq">
				                  <div class="mainmarqees-image">
              						<img src="'.url('/').'/assets/front/images/chow.png" alt="">
                                   </div>A new user has been registered successfully as a <b>seller</b>.<div class="clearfix"></div></div>';

				                $arr_eventdata['title']        = 'New User Seller Registration';
				                
				                $this->EventModel->create($arr_eventdata);*/


                                $arr_response['status'] = 'SUCCESS';
                                $arr_response['msg']    = 'You have successfully registered as a dispensary. please check your email account <b>'.$email.'</b> for the verification.';    
                                
                               // Session::put('welcomeusertype', '1');
                                 Session::put('welcomeusertype', '2');
    		                    Session::put('welcomeuseremail', $email);
                            }
                            else
                            {
                            	/*$arr_eventdata             = [];
				               	$arr_eventdata['user_id']  = $user->id;     
				               	$arr_eventdata['message']  = '<div class="discription-marq">
				                  <div class="mainmarqees-image">
              						<img src="'.url('/').'/assets/front/images/chow.png" alt="">
                                   </div>A new user has been registered successfully as a <b>buyer</b>. <div class="clearfix"></div></div>';

				                $arr_eventdata['title']    = 'New User Registration';
				                
				                $this->EventModel->create($arr_eventdata);*/


    		                    $arr_response['status'] = 'SUCCESS';
    		                    $arr_response['msg']    = 'You have successfully registered as a buyer. please check your email account <b>'.$email. '</b> for the verification.';

    		                    Session::put('welcomeusertype', '1');
    		                    Session::put('welcomeuseremail', $email);

                            }    

		                    return $arr_response;
		                }

          			}
          			else
          			{
          				$arr_response['status'] = 'ERROR';
	                    $arr_response['msg']    = 'Error occured while doing user activation';

	                    return $arr_response;
          			}
				}

			}
		}		
		else{
				$arr_response['status'] = 'ERROR';
				$arr_response['msg']    = 'Not valid array input to service';

				return $arr_response;
		}
	}

	private function registration_activation_built_mail_data($email, $activation_code,$hidden_productid=NULL)
    {
      $user = $this->get_user_details($email);
      	
      if($user)
      {
        $arr_user = $user->toArray();
       	
       	// this code commented for product cart redirection condition and new condition added.
       	/* $activation_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url('/').'/activate_account/'.$activation_code.'">Activate Now</a><br/>' ;*/



        /*if(isset($hidden_productid))
        {
        	 $activation_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url('/').'/activate_account/'.$activation_code.'/'.$hidden_productid.'">Activate Now</a><br/>' ;
        }else{
        	 $activation_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url('/').'/activate_account/'.$activation_code.'">Activate Now</a><br/>' ;
        }*/

        $activation_url = '<span style="font-size:20px">'.$arr_user['activationcode'].'</span>';



       

        $email_name ='';
        if($arr_user['user_type']=="seller"){
        	$email_name = '';
        	$get_seller_detail = $this->SellerModel->where('user_id',$arr_user['id'])->first();
        	if(!empty($get_seller_detail)){
        		$get_seller_detail = $get_seller_detail->toArray();
        		$email_name = $get_seller_detail['business_name'];
        	}

        	
        }
        else if($arr_user['user_type']=="buyer"){
        	$email_name = 'Buyer';
        }
        else{
        	$email_name = $arr_user['first_name'];
        }



        $arr_built_content = [
        					 // 'USER_FNAME'   => $arr_user['first_name'],
        					  'USER_FNAME'     => $email_name,
                              'ACTIVATION_URL' => $activation_url,
                              'APP_NAME'       => config('app.project.name')];

        $arr_mail_data                      = [];
        $arr_mail_data['email_template_id'] = '6';
        $arr_mail_data['arr_built_content'] = $arr_built_content;
        $arr_mail_data['arr_built_subject'] = '';
        $arr_mail_data['user']              = $arr_user;

        return $arr_mail_data;
      }
      return false;
    }

    private function  get_user_details($email)
    {
        $credentials = ['email' => $email];
        $user = Sentinel::findByCredentials($credentials); // check if user exists

        if($user)
        {
          return $user;
        }
        return false;
    }



    public function save_activity($event_arr)
    {
        $result = $this->SubAdminActivityModel->create($event_arr);

        if($result)
        {
           $response['status']       = 'success';
           $response['description']  = 'Activity saved successfully.';

        }
        else
        {
           $response['status']       = 'error';
           $response['description']  = 'Something went wrong,please try again.';
        }

        return  response()->json($response);
    }

}