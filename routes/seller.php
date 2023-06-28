<?php
Route::group(['middleware'=> ['front']],function(){

    $route_slug        = "account_setting_";
    $module_controller = "Front\AuthController@";

    Route::get('/does_emailid_exist',[ 'as'   =>$route_slug.'does_emailid_exist',
												 'uses' => $module_controller.'does_emailid_exist']);

    // Route::get('/does_businessname_exist',[ 'as'   =>$route_slug.'does_businessname_exist',
				// 								 'uses' => $module_controller.'does_businessname_exist']);


	Route::group(['prefix'=>'/seller','middleware'=>'seller'],function()
	{
		$route_slug        = "account_setting_";
        $module_controller = "Front\AuthController@";
		Route::get('/change_password',['as'=>$route_slug.'change_password','uses'=>$module_controller.'change_password']);
		Route::post('/update_password',['as'  =>$route_slug.'change_password',
										 'uses' => $module_controller.'update_password']);
		Route::post('/does_old_password_exist',[ 'as'   =>$route_slug.'does_old_password_exist','uses' => $module_controller.'does_old_password_exist']);	

        

		Route::group(['prefix' => 'profile/'],function ()
		{
			$route_slug        = "profile";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/',    [ 'as'   => $route_slug.'index',
								'uses' => $module_controller.'index']);

		  	Route::get('/get_states',    ['as'   => $route_slug. 'get_states', 'uses' => $module_controller. 'get_states']);
		  	Route::post('/update',    ['as'   => $route_slug.'update', 'uses' => $module_controller.'update']);
		    Route::get('edit',    ['as'   => $route_slug.'edit', 'uses' => $module_controller.'edit_profile']);
		    Route::get('/get_countryid',    ['as'   => $route_slug. 'get_countryid', 'uses' => $module_controller. 'get_countryid']);
		    
		
        });
        
        Route::group(['prefix' => 'dashboard/'],function ()
		{
			$route_slug        = "dashboard";
			$module_controller = "Seller\DashboardController@";

			Route::get('/',    [ 'as'   => $route_slug.'dashboard',
								'uses' => $module_controller.'dashboard']);

		});
 
			Route::group(['prefix' => 'business-profile/'],function ()
		{
			$route_slug        = "business-profile";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/',    [ 'as'   => $route_slug.'business_profile',
								'uses' => $module_controller.'business_profile']);
			Route::post('/update',    [ 'as'   => $route_slug.'update_business_profile',
								'uses' => $module_controller.'update_business_profile']);

			Route::post('/does_tax_id_exist',   [ 'as'   => $route_slug.'does_tax_id_exist',
								'uses' => $module_controller.'does_tax_id_exist']);

		});


	    Route::group(['prefix' => 'upload-documents/'],function ()
		{
			$route_slug        = "upload-documents";
			$module_controller = "Seller\AccountSettingsController@";
			
			Route::post('/update',    [ 'as'   => $route_slug.'upload_documents',
								'uses' => $module_controller.'upload_documents']);

			Route::get('/remove',    [ 'as'   => $route_slug.'remove_uploaded_documents',
								'uses' => $module_controller.'remove_uploaded_documents']);
			
		});		

	   	Route::group(['prefix' => 'id_verification/'],function ()
		{
			$route_slug        = "id_verification";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/', [ 'as'   => $route_slug.'id_verification',
								'uses' => $module_controller.'id_verification']);
			Route::post('/update',    [ 'as'   => $route_slug.'update_idproof',
								'uses' => $module_controller.'update_idproof']);


		});
		 

		Route::group(['prefix' => 'bank_detail/'],function ()
		{
			$route_slug        = "bank_detail";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/', [ 'as'   => $route_slug.'bank_detail',
								'uses' => $module_controller.'bank_detail']);
			Route::post('/update',    [ 'as'   => $route_slug.'update_bankdetail',
								'uses' => $module_controller.'update_bankdetail']);

		}); 

			Route::group(['prefix' => 'wholesale/'],function ()
		{
			$route_slug        = "wholesale";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/', [ 'as'   => $route_slug.'wholesale',
								'uses' => $module_controller.'wholesale']);
		

		}); 




		Route::group(['prefix' => 'membership_detail/'],function ()
		{
			$route_slug        = "membership_detail";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/', [ 'as'   => $route_slug.'membership_detail',
								'uses' => $module_controller.'membership_detail']);

		
		}); 

		Route::group(['prefix' => 'membership/'],function ()
		{

			$route_slug        = "membership";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/', [ 'as'   => $route_slug.'membership',
								'uses' => $module_controller.'membership']);
		
		}); 

		Route::group(['prefix' => 'membership_selection/'],function ()
		{

			$route_slug        = "membership_selection";
			$module_controller = "Seller\AccountSettingsController@";

			Route::post('/', [ 'as'   => $route_slug.'membership_selection',
								'uses' => $module_controller.'membership_selection']);
		
		}); 

		Route::group(['prefix' => 'membership_cancel/'],function ()
		{

			$route_slug        = "membership_cancel";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/', [ 'as'   => $route_slug.'membership_cancel',
								'uses' => $module_controller.'membership_cancel']);
		
		}); 

		Route::group(['prefix' => 'updatecard/'],function ()
		{

			$route_slug        = "updatecard";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/', [ 'as'   => $route_slug.'updatecard',
								'uses' => $module_controller.'updatecard']);
		
		}); 
         
        	Route::group(['prefix' => 'membership_updatecard/'],function ()
		{

			$route_slug        = "membership_updatecard";
			$module_controller = "Seller\AccountSettingsController@";

			Route::post('/', [ 'as'   => $route_slug.'membership_updatecard',
								'uses' => $module_controller.'membership_updatecard']);
		
		}); 
 
			

		
		Route::group(['prefix' => 'checkmethodworking/'],function ()
		{
			$route_slug        = "checkmethodworking";
			$module_controller = "Seller\AccountSettingsController@";

			Route::get('/', [ 'as'   => $route_slug.'checkmethodworking',
								'uses' => $module_controller.'checkmethodworking']);

		
		}); 





		Route::group(['prefix' => 'dispensary-image/'],function ()
		{
			$route_slug        = "dispensary-image";
			$module_controller = "Seller\BannerImageController@";

			Route::get('/',    [ 'as'   => $route_slug.'banner_image',
								'uses' => $module_controller.'index']);	

			Route::post('store',['as'=> $route_slug.'store',
								'uses'=> $module_controller.'store']);		

		});		

		$module_controller = "Front\Seller\HomeController@";
		Route::get('/save_seller_questions',['uses'=>$module_controller.'update_seller_question']);


		$module_controller = "Front\Seller\ProductController@";
		// Route::get('/escrow-authorization',['uses'=>$module_controller.'escrow_authorization']);




		Route::group(['prefix' => 'product/'],function () use($module_controller)
		{
			$module_controller = "Seller\ProductController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('create',['uses'=>$module_controller.'create']);
		  	Route::get('get_second_level_category',['uses'=>$module_controller.'get_second_level_category']);
		  	
		  	Route::post('save',['uses'=>$module_controller.'save']);
		  	Route::get('edit/{enc_id}',['uses'=>$module_controller.'edit']);
		  	Route::get('get_records',['uses'=>$module_controller.'get_records']);
		  	Route::get('view/{enc_id}',['uses'=>$module_controller.'view']);

		  	Route::get('/delete/{id}',['uses' => $module_controller.'delete']);
		  	Route::get('/edit/{id}',['uses' => $module_controller.'edit']);
		  	Route::get('/exportExcel',['uses'=>$module_controller.'exportExcel']);
		  	Route::post('/importExcel',['uses'=>$module_controller.'importExcel']);
		  	Route::post('/get_records',['uses'=>$module_controller.'get_records']);
  			Route::get('/delete_images/{enc_id}',['uses'=> $module_controller.'delete_images']);
            Route::post('/autosuggest',['uses' => $module_controller.'autosuggest']);
            Route::post('/autosuggest_dropshipper',['uses' => $module_controller.'autosuggest_dropshipper']);
            Route::post('/chk_dropshipper_email_duplication',['uses' => $module_controller.'chk_dropshipper_email_duplication']);
            Route::post('/get_dropshipper_details',['uses' => $module_controller.'get_dropshipper_details']);
            Route::get('/copy_product/{id}',['uses' => $module_controller.'copy_product']);
            Route::post('/copy_product_save',['uses' => $module_controller.'copy_product_save']);
    
            Route::get('activate', ['uses' => $module_controller.'activate']);	

			Route::get('deactivate',['uses' => $module_controller.'deactivate']);

			Route::get('/toggleOutofstock',['uses' => $module_controller.'toggleOutofstock']);

			Route::post('/changed_drop_price',['uses' => $module_controller.'changed_drop_price']);

			Route::any('/addnewrow',['uses' => $module_controller.'addnewrow']);
            Route::any('/removerow',['uses' => $module_controller.'removerow']);

		  	// Route::get('interested-buyers/{enc_id}',['uses'=>$module_controller.'interested_buyers']);
		  	// Route::get('/get_interested_buyers',['uses'=>$module_controller.'get_interested_buyers']);
		  	// Route::get('/interested-buyer-details/{enc_id}',['uses'=>$module_controller.'interested_buyer_details']);
		  	// Route::get('/accept-trade/{enc_id}',['uses'=>$module_controller.'accept_trade']);
		  	// Route::post('store_handling_charge',['uses'=>$module_controller.'store_handling_charge']);
		  	//Route::post('save_',['uses'=>$module_controller.'store']);
		  	// Route::post('store_shipment_proof',['uses'=>$module_controller.'store_shipment_proof']);
		  	// Route::post('dispute-trade',['uses'=>$module_controller.'dispute_trade']);
		  	// Route::get('delete_trade/{enc_id}',['uses'=>$module_controller.'delete_trade']);
		});


		Route::group(['prefix' => 'coupon/'],function () use($module_controller)
		{
			$module_controller = "Seller\CouponController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('create',['uses'=>$module_controller.'create']);
		  	Route::get('get_second_level_category',['uses'=>$module_controller.'get_second_level_category']);
		  	
		  	Route::post('save',['uses'=>$module_controller.'save']);
		  	Route::get('edit/{enc_id}',['uses'=>$module_controller.'edit']);
		  	Route::get('get_records',['uses'=>$module_controller.'get_records']);
		  	Route::get('view/{enc_id}',['uses'=>$module_controller.'view']);

		  	Route::get('/delete/{id}',['uses' => $module_controller.'delete']);
		  	Route::get('/edit/{id}',['uses' => $module_controller.'edit']);
		  	Route::get('/exportExcel',['uses'=>$module_controller.'exportExcel']);
		  	Route::post('/importExcel',['uses'=>$module_controller.'importExcel']);
		  	Route::post('/get_records',['uses'=>$module_controller.'get_records']);
  			Route::get('/delete_images/{enc_id}',['uses'=> $module_controller.'delete_images']);
            Route::post('/autosuggest',['uses' => $module_controller.'autosuggest']);
            Route::post('/autosuggest_dropshipper',['uses' => $module_controller.'autosuggest_dropshipper']);
            Route::post('/chk_dropshipper_email_duplication',['uses' => $module_controller.'chk_dropshipper_email_duplication']);
            Route::post('/get_dropshipper_details',['uses' => $module_controller.'get_dropshipper_details']);
            Route::get('/copy_product/{id}',['uses' => $module_controller.'copy_product']);
            Route::post('/copy_product_save',['uses' => $module_controller.'copy_product_save']);
    
            Route::get('activate', ['uses' => $module_controller.'activate']);	

			Route::get('deactivate',['uses' => $module_controller.'deactivate']);

			Route::get('coupon_private', ['uses' => $module_controller.'coupon_private']);	

			Route::get('coupon_public',['uses' => $module_controller.'coupon_public']);

	 
		});


		 Route::group(['prefix' => 'notifications/'],function () use($module_controller)
		{
			$module_controller = "Seller\NotificationController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::post('/delete',['uses' => $module_controller.'DeleteNotification']);

		});


		Route::group(['prefix' => 'report/{type}'],function () use($module_controller)
		{
			$module_controller = "Seller\ReportController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);

		}); 

		
		Route::group(['prefix' => 'wallet/'],function () use($module_controller)
		{
			$module_controller = "Seller\WalletController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('/get_wallet_details',['uses'=>$module_controller.'get_wallet_details']);
		  	Route::post('/withdraw_request',['uses'=>$module_controller.'withdraw_request']);
  	

		});

		Route::group(['prefix' => 'userrefered/'],function () use($module_controller)
		{
			$module_controller = "Seller\UserReferedController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('/get_user_details',['uses'=>$module_controller.'get_user_details']);
		  
  	

		});


		


		Route::group(['prefix' => 'payment-history/'],function () use($module_controller)
		{
			$module_controller = "Seller\PaymentHistoryController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('/view/{enc_id}',['uses'=>$module_controller.'view']);
		  	Route::get('/get_payment_history',['uses'=>$module_controller.'get_payment_history']);

		});

		Route::group(['prefix' => 'membership-history/'],function () use($module_controller)
		{
			$module_controller = "Seller\SubscriptionHistoryController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('/view/{enc_id}',['uses'=>$module_controller.'view']);
		  	Route::get('/get_payment_history',['uses'=>$module_controller.'get_payment_history']);

		});


		Route::group(['prefix' => 'followers/'],function () use($module_controller)
		{
			$module_controller = "Seller\FollowersController@";
		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('/get_followers',['uses'=>$module_controller.'get_followers']);

		});


		Route::group(['prefix' => 'order/'],function () use($module_controller)
		{
			$module_controller = "Seller\OrderController@";

		  	Route::get('/{type}',['uses'=>$module_controller.'index']);
		  	Route::get('{type}/get_order_details',['uses'=>$module_controller.'get_order_details']);
		  	Route::get('view/{enc_id}',['uses'=>$module_controller.'view']);
		  	Route::get('/delivered/{end_id}',['uses'=>$module_controller.'complete']);
		  	Route::get('/shipped/{end_id}',['uses'=>$module_controller. 'shipped']);
		  	Route::get('/dispatched/{end_id}',['uses'=>$module_controller. 'dispatched']);
		  	Route::post('updateTracking',['uses'=>$module_controller.'updateTracking']);
		  	Route::post('cancel',['uses'=>$module_controller.'cancel']);
		  	Route::any('/export/{from}/{to}/{excelorderstatus}', [ 'uses'=>$module_controller.'export']);
		  	Route::any('/exportcsv/{from}/{to}/{excelorderstatus}', [ 'uses'=>$module_controller.'exportcsv']);

		  	 
		  	Route::post('submit_order_note',['uses'=>$module_controller.'submit_order_note']);

		}); 


        /*restricted orders route*/
		Route::group(['prefix' => 'age_restricted_order/'],function () use($module_controller)
		{
			$module_controller = "Seller\AgeRestrictedOrdersController@";
  	
  	        Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('get_order_details',['uses'=>$module_controller.'get_order_details']);
		  	Route::get('view/{enc_id}',['uses'=>$module_controller.'view']);
		  	
		  	//Route::get('/delivered/{end_id}',['uses'=>$module_controller.'complete']);
		  	//Route::get('/shipped/{end_id}',['uses'=>$module_controller. 'shipped']);
		  	//Route::get('/dispatched/{end_id}',['uses'=>$module_controller. 'dispatched']);
		  	//Route::post('updateTracking',['uses'=>$module_controller.'updateTracking']);

		  	Route::post('cancel',['uses'=>$module_controller.'cancel']);
		  	Route::any('/export/{from}/{to}/{excelorderstatus}', [ 'uses'=>$module_controller.'export']);
		  	Route::any('/exportcsv/{from}/{to}/{excelorderstatus}', [ 'uses'=>$module_controller.'exportcsv']);
	  	 

		});




        /*restricted orders cancelled order route*/
		Route::group(['prefix' => 'age_restricted_cancelled_order/'],function () use($module_controller)
		{
			$module_controller = "Seller\AgeRestrictedCancelOrderController@";
  	
  	        Route::get('/',['uses'=>$module_controller.'index']);

		  	Route::get('get_order_details',['uses'=>$module_controller.'get_order_details']);

		  	Route::get('view/{enc_id}',['uses'=>$module_controller.'view']);
		  	
		  	Route::any('/export/{from}/{to}/{excelorderstatus}', [ 'uses'=>$module_controller.'export']);

		  	Route::any('/exportcsv/{from}/{to}/{excelorderstatus}', [ 'uses'=>$module_controller.'exportcsv']);
	  	 

		});



		Route::group(['prefix' => 'dispute/'],function ()
			{

			$route_slug        = "dispute";
			$module_controller = "Seller\DisputeController@";

			Route::get('/{enc_id}',		         ['as'  =>$route_slug.'index',
												 'uses' => $module_controller.'index']);

			Route::get('/view/{enc_id}',	['as'   =>$route_slug.'view',
												 'uses' => $module_controller.'view']);

			Route::post('/raise',		    ['as'  =>$route_slug.'raise',
												 'uses' => $module_controller.'raise']);

			Route::post('/SendMessage',		['as'  =>$route_slug.'send_message',
												 'uses' => $module_controller.'send_message']);
			Route::post('/getchatmessages',	['as' =>$route_slug.'getchatmessages',
												 'uses' => $module_controller.'getchatmessages']);
            
            });


		
		/*----------------------Seller Chating START--------------------------------*/
		$module_controller = "Front\Seller\ChatController@";

		Route::get('/chat/getMessage', ['as'=>'getMessage','uses'=>$module_controller.'get_message']);
		Route::get('/chat/{enc_trade_id}/{enc_buyer_id}', ['uses'=>$module_controller.'index']);
		Route::post('/chat/SendMessage', ['as'=>'SendMessage','uses'=>$module_controller.'send_message']);

		Route::get('/chat', ['as'=>'chat','uses'=>$module_controller.'general_chat']);
		Route::get('/getFullChat', ['as'=>'getFullChat','uses'=>$module_controller.'getFullChat']);			

		// Route::get('/chat/download_chat', ['as'=>'download-file','uses'=>$module_controller.'download_file']);			
		/*----------------------Seller Chating END----------------------------------*/

		/*--------------------Seller Transaction History START------------------------*/
		Route::group(['prefix' => 'transaction/'],function ()
		{
			$route_slug        = "seller_";
			$module_controller = "Front\Seller\TransactionController@";

			Route::get('/',    [ 'as'   => $route_slug.'index',
								'uses' => $module_controller.'index']);
			
		  	Route::get('buyer_list/{enc_id}',[ 
		  						'as'   =>$route_slug.'buyer_list',
		  						'uses' =>$module_controller.'buyer_list']);
		  	
		  	Route::get('view/{enc_id}',[ 
		  						'as'   =>$route_slug.'view',
		  						'uses' =>$module_controller.'view']);

		  	Route::post('save_transaction',[ 
	  						'as'   =>$route_slug.'save_transaction',
	  						'uses' =>$module_controller.'save_transaction']);
		
		});
		/*--------------------Seller Transaction History END--------------------------*/




		Route::group(['prefix' => 'posts/'],function () use($module_controller)
		{
			$module_controller = "Seller\ForumPostController@";

		  	Route::get('/',['uses'=>$module_controller.'index']);
		  	Route::get('create',['uses'=>$module_controller.'create']);
		  	
		  	Route::post('save',['uses'=>$module_controller.'save']);
		  	Route::get('edit/{enc_id}',['uses'=>$module_controller.'edit']);
		  	Route::get('get_records',['uses'=>$module_controller.'get_records']);
		  	Route::get('view/{enc_id}',['uses'=>$module_controller.'view']);

		  	Route::get('/delete/{id}',['uses' => $module_controller.'delete']);
		  	Route::get('/edit/{id}',['uses' => $module_controller.'edit']);
		  	Route::post('/get_records',['uses'=>$module_controller.'get_records']);
    

		  	
		});


		Route::group(['prefix' => 'delivery_options/'],function () use($module_controller) {

			$module_controller = "Seller\DeliveryOptionsController@";

		  	Route::get('/',				['uses'=>$module_controller.'index']);

		  	Route::get('/create',		['uses'=>$module_controller.'create']);
		  	
		  	Route::post('/store',		['uses'=>$module_controller.'store']);

		  	Route::get('/get_records',	['uses'=>$module_controller.'get_records']);

		  	Route::get('/deactivate',	['uses'=>$module_controller.'deactivate']);

		  	Route::get('/deactivate',	['uses'=>$module_controller.'deactivate']);

		  	Route::get('/activate',		['uses'=>$module_controller.'activate']);

		  	Route::get('/delete/{id}',	['uses'=>$module_controller.'delete']);

		  	Route::get('/view/{id}',	['uses'=>$module_controller.'view']);
		  	
		  	Route::get('/edit/{id}',	['uses'=>$module_controller.'edit']);

		  	Route::post('/update',		['uses'=>$module_controller.'update']);
		});

		Route::post('stripe/webhook', '\Laravel\Cashier\WebhookController@handleWebhook');

	});
});


Route::group(['prefix'=>'/seller','middleware'=>'seller'],function(){

	
	
	
});


