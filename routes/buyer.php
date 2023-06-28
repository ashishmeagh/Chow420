<?php
Route::group(['middleware'=> ['front']],function(){
	Route::group(['prefix'=>'/buyer','middleware'=>'buyer'],function()
		{


		   Route::post('/process_modal_ofbuyer',      ['uses'	=>'Buyer\AccountSettingsController@process_modal_ofbuyer']);


		    Route::get('/confirm_current_password',      ['uses'	=>'Buyer\AccountSettingsController@confirm_current_password']);
 

			$module_controller = "Front\FavoriteProductController@";
			Route::get('/my-favourite', ['uses'=>$module_controller.'view']);

              
            $route_slug        = "account_setting_";
            $module_controller = "Front\AuthController@";
            Route::get('/change_password/',				 ['as'  =>$route_slug.'change_password',
												 'uses' => $module_controller.'change_password']);
            Route::post('/update_password/',				 ['as'  =>$route_slug.'change_password',
												 'uses' => $module_controller.'update_password']);

            Route::post('/does_old_password_exist',[ 'as'   =>$route_slug.'does_old_password_exist','uses' => $module_controller.'does_old_password_exist']);	
           
            Route::group(['prefix' => 'profile/'],function ()
			{

			$route_slug        = "account_setting_";
			$module_controller = "Buyer\AccountSettingsController@";

			Route::get('/',		            ['as'  =>$route_slug.'view_profile',
												 'uses' => $module_controller.'view_profile']);

			Route::get('/get_states',    ['as'   => $route_slug . 'get_states', 'uses' => $module_controller . 'get_states']);

			Route::post('/update/',			['as'   =>$route_slug.'update_profile',
												 'uses' => $module_controller.'update']);

			Route::get('/update/',			['as'   =>$route_slug.'update',
												 'uses' => $module_controller.'index']);
		    Route::get('/get_countryid/',			['as'   =>$route_slug.'get_countryid',
												 'uses' => $module_controller.'get_countryid']);

			
            
            }); 
            /*---------------------Age Verification Comment START----------------------------- */
            Route::group(['prefix' => 'age-verification/'],function (){

                $route_slug        = "account_setting_";
                $module_controller = "Buyer\AccountSettingsController@";
                Route::get('/',		            ['as'  =>$route_slug.'age_verification',
												 'uses' => $module_controller.'age_verification']);
                Route::post('/updateage/',			['as'   =>$route_slug.'updateage',
												 'uses' => $module_controller.'updateage']);

            });

            /*---------------------Age Verification Comment END----------------------------- */

			$module_controller = "Front\HomeController@";
			Route::get('/get_trade_detail', ['uses'=>$module_controller.'get_trade_detail']);
			Route::post('/store_trade',    	['uses'=>$module_controller.'store_trade']);
			Route::get('/escrow-authorization',    	['uses'=>$module_controller.'escrow_authorization']);

			/*----------------------Buyer Product Comment START--------------------------------*/
			Route::group(['prefix' => 'comment/'],function ()
			{
				$route_slug        = "buyer_";
				$module_controller = "Front\CommentController@";

				Route::get('create/{enc_id}',['uses'=>$module_controller.'create']);
				
				Route::post('store',['uses'=>$module_controller.'store']);
		
			});


            /*----------------------Buyer Orders START--------------------------------*/
			Route::group(['prefix' => 'order/'],function ()
			{

			$route_slug        = "order";
			$module_controller = "Buyer\OrderController@";

			Route::get('/',		            ['as'  =>$route_slug.'index',
												 'uses' => $module_controller.'index']);

			Route::get('/view/{enc_id}',	['as'   =>$route_slug.'view',
												 'uses' => $module_controller.'view']);

			Route::post('cancel',['uses'=>$module_controller.'cancel']);

			Route::get('/get_myorders',   ['as'  =>$route_slug.'get_myorders',
												 'uses' => $module_controller.'get_myorders']);

            
            });
			/*----------------------Buyer Orders END--------------------------------*/



            /*----------------------Buyer Payment History START--------------------------------*/
			Route::group(['prefix' => 'payment-history/'],function ()
			{

			$route_slug        = "payment-history";
			$module_controller = "Buyer\PaymentHistoryController@";

			Route::get('/',		            ['as'  =>$route_slug.'index',
												 'uses' => $module_controller.'index']);

			Route::get('/get_payment_history',		            ['as'  =>$route_slug.'payment_history',
												 'uses' => $module_controller.'get_payment_details']);

			Route::get('/view/{enc_id}',	['as'   =>$route_slug.'view',
												 'uses' => $module_controller.'view']);
            
            });
			/*----------------------Buyer Payment History END--------------------------------*/



            /*----------------------Buyer Payment wallet START--------------------------------*/
			Route::group(['prefix' => 'wallet/'],function ()
			{

			$route_slug        = "wallet";
			$module_controller = "Buyer\BuyerWalletController@";

			Route::get('/',	 ['as'  =>$route_slug.'index',
						'uses' => $module_controller.'index']);

			Route::get('/get_buyer_wallet', ['as'  =>$route_slug.'get_buyer_wallet',
								'uses' => $module_controller.'get_buyer_wallet']);

			Route::get('/view/{enc_id}',	['as'   =>$route_slug.'view',
								'uses' => $module_controller.'view']);
            
            });
			/*----------------------Buyer Payment wallet END--------------------------------*/

			 /*----------------------Buyer refered user START--------------------------------*/
			Route::group(['prefix' => 'refered-users/'],function ()
			{

			$route_slug        = "refered-users";
			$module_controller = "Buyer\BuyerReferedController@";

			Route::get('/',	 ['as'  =>$route_slug.'index',
						'uses' => $module_controller.'index']);

			Route::get('/get_buyer_refered', ['as'  =>$route_slug.'get_buyer_refered',
								'uses' => $module_controller.'get_buyer_refered']);

			Route::get('/view/{enc_id}',	['as'   =>$route_slug.'view',
								'uses' => $module_controller.'view']);
            
            });
			/*----------------------Buyer refered users END--------------------------------*/


			/*----------------------Buyer Dispute START--------------------------------*/
			Route::group(['prefix' => 'dispute/'],function ()
			{

			$route_slug        = "dispute";
			$module_controller = "Buyer\DisputeController@";

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
			/*----------------------Buyer Payment History END--------------------------------*/


			/*----------------------Buyer Review-Ratings START--------------------------------*/
			Route::group(['prefix' => 'review-ratings/'],function ()
			{

			$route_slug        = "review-ratings";
			$module_controller = "Buyer\ReviewRatingsController@";

			Route::get('/{order_id?}',		['as'  =>$route_slug.'index',
												 'uses' => $module_controller.'index']);

			Route::post('/store',		    ['as'  =>$route_slug.'store',
												 'uses' => $module_controller.'store']);

			Route::post('/get_review_details',	['as'  =>$route_slug.'get_review_details',
												 'uses' => $module_controller.'get_review_details']);


			Route::post('/update',		    ['as'  =>$route_slug.'update',
												 'uses' => $module_controller.'update']);


			Route::post('/money_back_request',  ['as'  =>$route_slug.'send_money_back_request',
												 'uses' => $module_controller.'send_money_back_request']);

            
            });


            /*----------------------Money back request --------------------------------*/

			Route::group(['prefix' => 'reported_issues'],function ()
			{

			$route_slug        = "reported_issues";

			$module_controller = "Buyer\MoneyBackRequestController@";

			Route::get('/',		    ['as'  =>$route_slug.'index',
									'uses' => $module_controller.'index']);

			Route::get('/get_request',	['as'  =>$route_slug.'get_request',
										 'uses' => $module_controller.'get_request']);

            
            });


			/*----------------------Buyer Review-Ratings END--------------------------------*/


				/*----------------------Buyer Review-Ratings START--------------------------------*/
			Route::group(['prefix' => 'notifications/'],function ()
			{

			$route_slug        = "notifications";
			$module_controller = "Buyer\NotificationController@";

			Route::get('/',		            ['as'  =>$route_slug.'index', 
												 'uses' => $module_controller.'index']);

			Route::post('/delete',		    ['as'  =>$route_slug.'DeleteNotification',
												 'uses' => $module_controller.'DeleteNotification']);
            
            });
			/*----------------------Buyer Review-Ratings END--------------------------------*/

			

			/*----------------------Buyer Chating START--------------------------------*/
			$module_controller = "Front\Buyer\ChatController@";
			
			Route::get('/chat/getMessage', ['as'=>'getMessage','uses'=>$module_controller.'get_message']);
			Route::get('/chat/{enc_trade_id}', ['uses'=>$module_controller.'index']);
			Route::post('/chat/SendMessage', ['as'=>'SendMessage','uses'=>$module_controller.'send_message']);

			Route::get('/chat', ['as'=>'chat','uses'=>$module_controller.'general_chat']);
			Route::get('/getFullChat', ['as'=>'getFullChat','uses'=>$module_controller.'getFullChat']);
			/*----------------------Buyer Chating END----------------------------------*/


			/*--------------------Buyer Transaction History START------------------------*/
			Route::group(['prefix' => 'transaction/'],function ()
			{
				$route_slug        = "buyer_";
				$module_controller = "Front\Buyer\TransactionController@";

				Route::get('/',    [ 'as'   => $route_slug.'index',
									'uses' => $module_controller.'index']);

			  	Route::get('get_transaction_records',['as'   => $route_slug.'get_transaction_records','uses' => $module_controller.'get_transaction_records']);

			  	Route::get('view/{enc_id}',[ 
			  						'as'   =>$route_slug.'view',
			  						'uses' =>$module_controller.'view']);

			  	Route::post('save_transaction',[ 
		  						'as'   =>$route_slug.'save_transaction',
		  						'uses' =>$module_controller.'save_transaction']);
			  	
			  	Route::post('complete_trade',[ 
		  						'as'   =>$route_slug.'complete_trade',
		  						'uses' =>$module_controller.'complete_trade']);
			  	
			});

			/*--------------------Buyer Transaction History END--------------------------*/


				Route::group(['prefix' => 'posts/'],function () use($module_controller)
				{
					$module_controller = "Buyer\ForumPostController@";

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




		});
});


Route::group(['prefix'=>'/buyer','middleware'=>'buyer'],function(){

	
});


