<?php

use App\Models\TempBagModel;
use App\Models\SiteSettingModel;
use App\Models\UserModel;
use App\Models\DisputeModel;
use App\Models\ProductInventoryModel;
use App\Models\UserSubscriptionsModel;
use App\Common\Services\CommisionService;
use App\Models\OrderModel;
use App\Models\UserReferWalletModel;
use App\Models\ProductDimensionsModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\DropShipperModel;
use App\Models\FirstLevelCategoryModel;
use App\Models\FirstLevelCategoryFaqModel;
use App\Models\ProductModel;
use App\Models\OrderProductModel;
use App\Models\ReviewRatingsModel;
use App\Models\ProductCommentModel;
use App\Models\IpDataModel; 
use App\Models\StateModel;
use App\Models\BrandModel;
use App\Models\CannabinoidsModel;
use App\Models\ProductCannabinoidsModel;
use App\Models\SellerModel;
use App\Models\CouponModel;
use App\Models\SpectrumModel;

use App\Models\DeliveryOptionsModel;
use App\Models\AnnouncementsModel;
use App\Models\BannerImagesModel;

use App\Models\MoneyBackModel;




use App\Models\BuyerWalletModel;
use App\Models\LabResultModel;

use TaxJar\Client;
use App\Models\ReportedEffectsModel;
use App\Models\FirstLevelCategoryProductDetailModel;
use App\Models\TransactionModel;


function cancel_cashback($orderno)
{
	     $get_wallet_data = BuyerWalletModel::select('status')
										->where('typeid',$orderno)
										->where('type','Cashback')
										->where('status',0)											
										->first();	
		if(isset($get_wallet_data) && !empty($get_wallet_data))
		{
			//if cancelled then we have to show that cashback is cancelled

			$get_wallet_data = $get_wallet_data->toArray();
			BuyerWalletModel::where('typeid',$orderno)->where('type','Cashback')->delete();

			$transaction_data = TransactionModel::select('cashback')->where('order_no',$orderno)->first();
	        if(isset($transaction_data) && !empty($transaction_data))
	        {

				$update_transaction_entry = [];
				$update_transaction_entry['cashback'] ='';
				$update_transaction_entry['cashback_percentage']='';

				$update_transaction_entry = TransactionModel::where('order_no',$orderno)->update($update_transaction_entry);
			}
		}
}

function get_cashback_data($orderno)
{ 
	$transaction_data = [];
	if($orderno)
	{
		$transaction_data = TransactionModel::select('cashback')->where('order_no',$orderno)->first();
        if(isset($transaction_data) && !empty($transaction_data))
        {
            $transaction_data = $transaction_data->toArray();
        }
	}
	   
    return $transaction_data;  
}// end get_cashback_data

function get_user_wallet_cashback($orderno,$userid)
{ 
	$wallet_data = []; $status = '';
	if($orderno)
	{

	   $cancelled_wallet_data = BuyerWalletModel::select('status')
										->where('typeid',$orderno)
										->where('type','Cashback')
										->where('status',2)
										->where('user_id',$userid)	
										->first();	
		if(isset($cancelled_wallet_data) && !empty($cancelled_wallet_data))
		{
			//if cancelled then we have to show that cashback is cancelled

			$cancelled_wallet_data = $cancelled_wallet_data->toArray();
			$status = $cancelled_wallet_data['status'];
			if($status==2)
			{
				$status = 'Cashback Cancelled';
			}
		}
		else
		{
			$wallet_data = BuyerWalletModel::select('status')
										->where('typeid',$orderno)
										->where('type','Cashback')
										->where('status',1)
										->where('user_id',$userid)	
											->first();
	        if(isset($wallet_data) && !empty($wallet_data))
	        {
	            $wallet_data = $wallet_data->toArray();
	            $status = $wallet_data['status'];
				if($status==1)
				{
					$status = 'Cancel Cashback';
				}
	        }
		}								
	
	}//if orderno
	   
    return $status;  
}// end get_cashback_data

function get_category_product_details($categoryid)
{	
	$get_product_details_view = [];

	if(isset($categoryid))
	{
		$get_product_details_view = FirstLevelCategoryProductDetailModel::where('category_id',$categoryid)->first();

		if(isset($get_product_details_view) && !empty($get_product_details_view))
		{

			$get_product_details_view = $get_product_details_view->toArray();

		} //get_product_details_view
	}// categoryid

	return $get_product_details_view;
	
}//get_category_product_details



//generate the trade ref including trade id, seller or buyer wallet address, current timestamp
function get_reportedeffect_count($effectid,$product_id)
{
	$sameids = []; $effectcount = 0;
  if(isset($effectid) && !empty($effectid))
  {	
  	     $effects = ReviewRatingsModel::where('emoji','!=','')->where('product_id',$product_id)->get();
        if(isset($effects) && !empty($effects))
        {
        	$effects = $effects->toArray();
        	 foreach($effects as $k=>$v)
            {
        		if(isset($v['emoji']) && !empty($v['emoji']))
                {
                	 $exploded_ids = explode(",",$v['emoji']);
                	 foreach($exploded_ids as $k1=>$v1)
                     {
                     	 if($v1==$effectid)
                     	 {
                     	 	$sameids[] = $v1;
                     	 }
                     }//foreach
                }//if

            }//foreach effects
        }//if effects

     if(isset($sameids) && !empty($sameids))
     {
     	$effectcount = count($sameids);
     }   
    return $effectcount;

  }//if effectid 
}//get_reportedeffect_count
function get_effect_name($effectid)
{	 
	 $get_reported_effects =[];
	 $get_reported_effects = ReportedEffectsModel::where('id',$effectid)->first(); 
     if(isset($get_reported_effects) && !empty($get_reported_effects))
     {
       $get_reported_effects = $get_reported_effects->toArray();
     }  
    return $get_reported_effects; 
}//get_effect_name



function get_lab_result_header()
{
	$lab_result = []; $lab_res_header ='';

	$lab_result = LabResultModel::first();
	if(isset($lab_result) && !empty($lab_result))
	{
		$lab_result = $lab_result->toArray(); 
		$lab_res_header = $lab_result['lab_result'];
	}
    return $lab_res_header;
}

function get_highlight_header()
{
	$highlight = []; $highlight_header ='';

	$highlight = SiteSettingModel::first();
	if(isset($highlight) && !empty($highlight))
	{
		$highlight = $highlight->toArray(); 
		$highlight_header = $highlight['highlight_header'];
	}
    return $highlight_header;
}
function get_highlight_subheader()
{
	$highlight = []; $highlight_subheader ='';

	$highlight = SiteSettingModel::first();
	if(isset($highlight) && !empty($highlight))
	{
		$highlight = $highlight->toArray(); 
		$highlight_subheader = $highlight['highlight_sub_header'];
	}
    return $highlight_subheader;
}//end

function get_product_category_faq($category)
{
	$get_category_faq = []; $get_category_faqarr =[];
	$get_category_faq = FirstLevelCategoryFaqModel::where('category_id',$category)->where('is_active',1)->get();
	if(isset($get_category_faq) && !empty($get_category_faq))
	{	
		$get_category_faqarr = $get_category_faq->toArray();
	}
	return $get_category_faqarr;
}//end


function get_remaining_stock($product_id)
{
	$res_inventory = ProductInventoryModel::where('product_id',$product_id)->get()->toArray();

	    if(!empty($res_inventory))
        {
            if(!empty($res_inventory[0]['remaining_stock']))
            {   
                $remaining_stock = $res_inventory[0]['remaining_stock'];
                return $remaining_stock;

                // if($remaining_stock==0)
                // {
                //      $response['status']      = 'FAILURE';
                //      $response['description'] = 'product stock is not avaliable';
                //     return response()->json($response);
                // }
                // else if($remaining_stock < $item_quantity)
                // {
                //      $response['status']      = 'FAILURE';
                //      $response['description'] = 'stock is '.$res_inventory[0]['remaining_stock'].' only';
                //     return response()->json($response);
                // }
              }
         }


}	


function generate_trade_ref($trade_user_id = false)
{
	return str_random(32);

}
function us_date_format($date = false)
{
  return date('d M Y',strtotime($date));
  //date("d M Y",strtotime($order['created_at'])
}

function get_seller_name($seller_id=false)
{
 	$obj_seller = UserModel::where('id',$seller_id)->first();
 	if(isset($obj_seller))
 	{
  		$seller_name = $obj_seller['first_name'].' '.$obj_seller['last_name'];

  		return $seller_name;
 	}
}
function get_seller_email($seller_id=false)
{
 	$obj_seller = UserModel::where('id',$seller_id)->first();
 	if(isset($obj_seller))
 	{
  		$seller_email = $obj_seller['email'];

  		return $seller_email;
 	}
}

function time_format($date = false)
{
	return date('g:i A', strtotime($date));
}

function get_site_logo()
{
  $site_logo =  SiteSettingModel::first(['site_logo'])->toArray();
  return $site_logo;
}

function shipping_charges($subtotal)
{	
	
	if ($subtotal <= 49) {
		
		$shipping_charges = 4.50;
		
	}
	else{
		$shipping_charges = 0;

	}
	return $shipping_charges;
}

function get_bag_count_old19aug()
{
  $bag_arr = [];
  
  $product_count = 0;

  $user = \Sentinel::check();
  if($user)
  {
  	
  	$bag_obj = TempBagModel::where('buyer_id',$user->id)->first();
  	if($bag_obj)
  	{
	    $bag_arr = $bag_obj->toArray();
	        
	    $product_data_arr = json_decode($bag_arr['product_data'],true);

	    $product_data_arr = isset($product_data_arr['product_id'])?$product_data_arr['product_id']:"0";
	   
	    $product_count = count($product_data_arr);
  	}
  }

  return $product_count;  
}



function get_bag_count()
{
  $bag_arr = [];
  
  $product_count = 0;
  $user = \Sentinel::check();
  $loginId = 0;
  if($user)
  {
  	$loginId = $user->id;
  }

   $session_id = session()->getId();
   $ip_address = \Request::ip();

	    if($user)
	    {
	  	  $bag_obj = TempBagModel::where('buyer_id',$loginId)->first();
	    }else{
	  	  $bag_obj = TempBagModel::where('buyer_id',$loginId)
	  	            ->where('user_session_id',$session_id)
	  	            ->where('ip_address',$ip_address)
	  	             ->first();
	    }
	  	if($bag_obj)
	  	{
		    $bag_arr = $bag_obj->toArray();
		        
		    $product_data_arr = json_decode($bag_arr['product_data'],true);

		    $product_data_arr = isset($product_data_arr['product_id'])?$product_data_arr['product_id']:"0";
		   
		    $product_count = count($product_data_arr);


		  
	  	}

  return $product_count;  
}

//this function for get cart count qty wise
function get_cart_count()
{
  $bag_arr = [];
  
  $product_count = 0;
  $count = 0;
  $user = \Sentinel::check();
  $loginId = 0;
  if($user)
  {
  	$loginId = $user->id;
  }

   $session_id = session()->getId();
   $ip_address = \Request::ip();

	    if($user)
	    {
	  	  $bag_obj = TempBagModel::where('buyer_id',$loginId)->first();
	    }else{
	  	  $bag_obj = TempBagModel::where('buyer_id',$loginId)
	  	            ->where('user_session_id',$session_id)
	  	            ->where('ip_address',$ip_address)
	  	             ->first();
	    }
	  	if($bag_obj)
	  	{
		    $bag_arr = $bag_obj->toArray();
		        
		    $product_data_arr = json_decode($bag_arr['product_data'],true);

		    $product_data_arr = isset($product_data_arr['product_id'])?$product_data_arr['product_id']:"0";
		   
	  
		    //count product according to qty.
           

		    if(isset($product_data_arr) && count($product_data_arr)>0)
		    {
               foreach ($product_data_arr as $key => $product) 
               {
                  $count += $product['item_qty'];  	  
               }

		    }

		    $product_count = $count; 
	  	}

  return $product_count;  
}




function getProfileImage($image_name = false)
{
	$image = url('/').'/assets/images/Profile-img-new.jpg';

	if(isset($image_name) && $image_name!="" && $image_name!=false)
	{	
		if(file_exists(base_path('/uploads/profile_image').'/'.$image_name)==true)
		{	
			$image = url('/uploads/profile_image').'/'.$image_name;
		}
	}	
	
	return $image; 
}

function getIdProof($image_name = false)
{
	$image = url('/').'/assets/images/Profile-img-new.jpg';

	if(isset($image_name) && $image_name!="" && $image_name!=false)
	{	
		if(file_exists(base_path('/uploads/id_proof').'/'.$image_name)==true)
		{	
			$image = url('/uploads/id_proof').'/'.$image_name;
		}
	}	
	
	return $image; 
}

function num_format($number)
{
  $num = '';
  if($number || $number == '0')
  {
    $num = number_format((float)$number, 2, '.', '');
  }

  return $num ;
}

function check_is_order_placed($trade_id,$user_id)
{
	$order_count = App\Models\TradeModel::where('linked_to',$trade_id)
										->where('user_id',$user_id)
										->count();
	return $order_count;
}

function get_crypto_symbol_details()
{

   $obj_crypto_symbol =  \App\Models\GeneralSettingsModel::where('data_id','CRYPTO_SYMBOL')->first();

   $obj_crypto_symbol = isset($obj_crypto_symbol->data_value)?$obj_crypto_symbol->data_value : '';
   
   return  $obj_crypto_symbol;

}

//get interested buyer count of perticular trade id
function get_interested_buyers_count($trade_id =false,$user_id = false)
{
	$interested_buyers_count = \App\Models\TradeModel::where('user_id','!=',$user_id)
													->where('linked_to',$trade_id)
													->where('trade_type','0')
													->count();

	return $interested_buyers_count;
}
function get_firstlevel_category()
{
	$res_cat = \App\Models\FirstLevelCategoryModel::where('is_active',1)->get()->toArray();
	return $res_cat;
}



function get_admin_id()
{
  $admin_role = \Sentinel::findRoleBySlug('admin');        
  $admin_obj  = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
  $admin_id   = 0;

  if($admin_obj)
  {
    $admin_id = $admin_obj->user_id;            
  }

  return $admin_id;
}

function is_review_added($product_id = '',$user_id = '')
{
	$add_review_count  = \App\Models\ReviewRatingsModel::where('buyer_id',$user_id)
													->where('product_id',$product_id)
													->count();
	return $add_review_count;
}

function get_total_reviews_old($product_id = '')
{
	$review_count     =  \App\Models\ReviewRatingsModel::where('product_id',$product_id)
													   ->count();
													   
	return $review_count; 
}

function get_total_reviews($product_id = '')
{
	$review_count  =  \App\Models\ReviewRatingsModel::where('product_id',$product_id)
													 ->count();
    
    $admin_product_review = ProductModel::where('id',$product_id)->pluck('avg_review')->first();	

    if(isset($admin_product_review))
    {
       $review_count = $admin_product_review + $review_count;	
    }
    else
    {
    	$review_count = $review_count; 
    }
    

	return $review_count; 
}

function get_avg_rating($product_id = '')
{
	
	$new_avg_rating  = "";
   
    //$review_count   = get_total_reviews($product_id);

	$review_count  =  \App\Models\ReviewRatingsModel::where('product_id',$product_id)
													 ->count();

	$sum_of_reviews =  \App\Models\ReviewRatingsModel::where('product_id',$product_id)
													   ->sum('rating');

    //get admin rating
	$admin_product_rating = ProductModel::where('id',$product_id)->pluck('avg_rating')->first();			

    if($review_count > 0 && $sum_of_reviews > 0 )
    {	
	  // $avg_rating     = round($sum_of_reviews/$review_count) ;
	  $avg_rating   = floatval($sum_of_reviews)/floatval($review_count);


      if(isset($admin_product_rating) && $admin_product_rating!='' && $admin_product_rating!=null)
      {
         $total_rating = floatval($admin_product_rating)+$avg_rating;

         $total_product_rating = $total_rating/2;
      }
      else
      {
         $total_product_rating = $avg_rating;
      }

	  $new_avg_rating = round_rating_in_half($total_product_rating);

    }
    else
    {
      if(isset($admin_product_rating) && $admin_product_rating!='' && $admin_product_rating!=null)
      {
      	 $new_avg_rating = round_rating_in_half($admin_product_rating);
      }
    }
	
	return $new_avg_rating;												   
}

function get_avg_rating_image($avg_rating = '')
{ 
	    $rating ='';

		if($avg_rating==0.5)
	  	{
	  		$rating = '0-5';
	  	}
	    else if($avg_rating==1)
	  	{
	  		$rating = '1';
	  	}
	  	 else if($avg_rating==1.1)
	  	{
	  		$rating = '1-1';
	  	}
	  	 else if($avg_rating==1.2)
	  	{
	  		$rating = '1-2';
	  	}
	  	 else if($avg_rating==1.3)
	  	{
	  		$rating = '1-3';
	  	}
	  	 else if($avg_rating==1.4)
	  	{
	  		$rating = '1-4';
	  	}
	  	 else if($avg_rating==1.5)
	  	{
	  		$rating = '1-5';
	  	}
	  	 else if($avg_rating==1.6)
	  	{
	  		$rating = '1-6';
	  	}
	  	 else if($avg_rating==1.7)
	  	{
	  		$rating = '1-7';
	  	}
	  	 else if($avg_rating==1.8)
	  	{
	  		$rating = '1-8';
	  	}
	  	else if($avg_rating==1.9)
	  	{
	  		$rating = '1-9';
	  	}
	    else if($avg_rating==2)
	  	{
	  		$rating = '2';
	  	}
	  	else if($avg_rating==2.1)
	  	{
	  		$rating = '2-1';
	  	}
	  	else if($avg_rating==2.2)
	  	{
	  		$rating = '2-2';
	  	}
	  	else if($avg_rating==2.3)
	  	{
	  		$rating = '2-3';
	  	}
	  	else if($avg_rating==2.4)
	  	{ 
	  		$rating = '2-4';
	  	}
	  	else if($avg_rating==2.5)
	  	{
	  		$rating = '2-5';
	  	}
	  	else if($avg_rating==2.6)
	  	{
	  		$rating = '2-6';
	  	}
	  	else if($avg_rating==2.7)
	  	{
	  		$rating = '2-7';
	  	}
	  	else if($avg_rating==2.8)
	  	{
	  		$rating = '2-8';
	  	}
	  	else if($avg_rating==2.9)
	  	{
	  		$rating = '2-9';
	  	}
	    else if($avg_rating==3)
	  	{
	  		$rating = '3';
	  	}
	    else if($avg_rating==3.1)
	  	{
	  		$rating = '3-1';
	  	}	
	    else if($avg_rating==3.2)
	  	{
	  		$rating = '3-2';
	  	}	
	    else if($avg_rating==3.3)
	  	{
	  		$rating = '3-3';
	  	}		 	
	    else if($avg_rating==3.4)
	  	{
	  		$rating = '3-4';
	  	}
	    else if($avg_rating==3.5)
	  	{
	  		$rating = '3-5';
	  	}	
	  	else if($avg_rating==3.6)
	  	{
	  		$rating = '3-6';
	  	}	
	  	else if($avg_rating==3.7)
	  	{
	  		$rating = '3-7';
	  	}	
	  	else if($avg_rating==3.8)
	  	{
	  		$rating = '3-8';
	  	}	
	  	else if($avg_rating==3.9)
	  	{
	  		$rating = '3-9';
	  	}		 	
	    else if($avg_rating==4)
	  	{
	  		$rating = '4';
	  	}
	    else if($avg_rating==4.1)
	  	{
	  		$rating = '4-1';
	  	}	
	    else if($avg_rating==4.2)
	  	{
	  		$rating = '4-2';
	  	}	
	    else if($avg_rating==4.3)
	  	{
	  		$rating = '4-3';
	  	}		 	
	    else if($avg_rating==4.4)
	  	{
	  		$rating = '4-4';
	  	}		
	    else if($avg_rating==4.5)
	  	{
	  		$rating = '4-5';
	  	} 
	    else if($avg_rating==4.6)
	  	{
	  		$rating = '4-6';
	  	} 
	  	 else if($avg_rating==4.7)
	  	{
	  		$rating = '4-7';
	  	} 
	  	 else if($avg_rating==4.8)
	  	{
	  		$rating = '4-8';
	  	}  
	   else if($avg_rating==4.9)
	  	{
	  		$rating = '4-9';
	  	}  			
	    else if($avg_rating==5)
	  	{
	  		$rating = '5';
	  	}
	    else
    	{
    		$rating = '5';
	  	}

	  // switch ($avg_rating) {
	  // 		case '0.5':
	  // 			$rating = '0-5';
	  // 			break;
	  // 	    case '1':
	  // 			$rating = '1';
	  // 			break;		
	  // 		case '1.1':
	  // 			$rating = '1-1';
	  // 			break;	
	  // 	    case '1.2':
	  // 			$rating = '1-2';
	  // 			break;	
	  // 	    case '1.3':
	  // 			$rating = '1-3';
	  // 			break;			
	  // 	   case '1.4':
	  // 			$rating = '1-4';
	  // 			break;
	  // 	   case '1.5':
	  // 			$rating = '1-5';
	  // 			break;								
	  // 		default:
	  // 			# code...
	  // 			break;
	  // 	}	
	 
	 return $rating;
	 
	 

} //get_avg_rating_image

function get_admin_rating($product_id)
{
   //get admin rating
   $admin_product_rating = ProductModel::where('id',$product_id)->pluck('avg_rating')->first();

   return  $admin_product_rating;
}

function get_avg_rating_old($product_id = '')
{
	// $avg_rating     = "";
	$new_avg_rating  = "";

	$review_count   = get_total_reviews($product_id);
	$sum_of_reviews =  \App\Models\ReviewRatingsModel::where('product_id',$product_id)
													   ->sum('rating');
  
    if($review_count > 0 && $sum_of_reviews > 0 )
    {	
	  // $avg_rating  = round($sum_of_reviews/$review_count) ;
	  $avg_rating     = floatval($sum_of_reviews)/floatval($review_count);
 
	  $new_avg_rating = round_rating_in_half($avg_rating);	  
    }
	
	return $new_avg_rating;												   
}

function round_rating_in_half($avg_rating)
{
	if(isset($avg_rating) && $avg_rating > 0)
	{
		if($avg_rating > 0 && $avg_rating <= 0.5)
		{
			$avg_rating = 0.5;
		}
		else if($avg_rating > 0.5 && $avg_rating <= 1)
		{
			$avg_rating = 1;
		}
		// else if($avg_rating > 1 && $avg_rating <= 1.5)
		// {
		// 	$avg_rating = 1.5;
		// }
		// else if($avg_rating > 1.5 && $avg_rating <= 2)
		// {
		// 	$avg_rating = 2;
		// }
		// else if($avg_rating > 2 && $avg_rating <= 2.5)
		// {
		// 	$avg_rating = 2.5;
		// }
		// else if($avg_rating > 2.5 && $avg_rating <= 3)
		// {
		// 	$avg_rating = 3;
		// }
		// else if($avg_rating > 3 && $avg_rating <= 3.5)
		// {
		// 	$avg_rating = 3.5;
		// }
		// else if($avg_rating > 3.5 && $avg_rating <= 4)
		// {
		// 	$avg_rating = 4;
		// }
		// else if($avg_rating > 4 && $avg_rating <= 4.5)
		// {
		// 	$avg_rating = 4.5;
		// }
		// else if($avg_rating > 4.5 && $avg_rating <= 5)
		// {
		// 	$avg_rating = 5;
		// }
		else if($avg_rating >=5)
		{
			$avg_rating = 5;
		}
		$avg_rating = number_format($avg_rating,1);
	}
	return $avg_rating;	
	
}  

function get_sum_of_rating($product_id = '')
{
	$total_of_ratings = '';	
	$sum_of_ratings =  \App\Models\ReviewRatingsModel::where('product_id',$product_id)
													   ->sum('rating');
	if($sum_of_ratings>0)
	{
		$total_of_ratings = $sum_of_ratings;
	}
	return $total_of_ratings;

}	


function get_user_image()
{
	$user  =  Sentinel::check();
	$image =  url('/').'/assets/images/Profile-img-new.jpg';
	if($user)
	{
		 $user_id       = $user->id;
		 $image_obj     = \App\Models\UserModel::where('id',$user_id)->select('profile_image')->first();
		 $image_name    = $image_obj->profile_image;
		 if(isset($image_name) && $image_name!="" && $image_name!=false)
		 {
		 	if(file_exists(base_path('/uploads/profile_image').'/'.$image_name)==true)
			{	
				$image = url('/uploads/profile_image').'/'.$image_name;
			}
		 }
	}

	return $image;
}

function get_dispute_status($order_id = "")
{
   $arr_dispute_status = "";	
   if($order_id!="")
   {
         $obj_dispute_status = \App\Models\DisputeModel::where('order_id',$order_id)->select('is_dispute_finalized')->first();
         
         if($obj_dispute_status)
         {
			 $arr_dispute_status =$obj_dispute_status->toArray();
			 
            if($arr_dispute_status && count($arr_dispute_status) > 0)
            {				
                return $arr_dispute_status['is_dispute_finalized'];
            }
            else
            {
                return false;
            }
         }

         return false;
   }	
   return false;
}

function get_notifications_count($user_id)
{
	$notifications_arr_cnt = \App\Models\NotificationsModel::where('is_read','0')
                                  ->where('to_user_id',$user_id)
                                  ->count();

    return $notifications_arr_cnt;
}
 function get_aggregaterating()
{
	$review_count =0;$sum_of_reviews=0;
	$avg_rating=0;$get_aggregaterating=0;

	$arr = [];

	$review_count     =  \App\Models\ReviewRatingsModel::count();
	$sum_of_reviews   =  \App\Models\ReviewRatingsModel::sum('rating');
    if($review_count > 0 && $sum_of_reviews > 0 )
    {	
	  $avg_rating     = floatval($sum_of_reviews)/floatval($review_count);
	  $get_aggregaterating = round_rating_in_half($avg_rating);	  
    }
	$arr['Average'] = $get_aggregaterating;
	$arr['Reviewcount'] = $review_count;

	$get_product = \App\Models\ReviewRatingsModel::where('rating','5')->with('product_details','product_details.get_brand_detail','user_details')->orderby('id','desc')->limit(1)->first();
	if(isset($get_product) && !empty($get_product))
	{
		$get_product = $get_product->toArray();
		$arr['Productarr'] = $get_product;
	}
	return $arr;				
}//end of function

function get_aggregate_rating($url_segment = '',$arr_data = '')
{
	$arr_aggregate_rating = array();

	$arr_aggregate_rating['brand_name'] = '';
	$arr_aggregate_rating['average_rating_value'] = '';
	$arr_aggregate_rating['review_count'] = '';
	$arr_aggregate_rating['product_name'] = '';
	$arr_aggregate_rating['image'] = "https://chow420.com/assets/front/images/open-graph-image.jpg";
	$arr_aggregate_rating['sku'] = '';
	$arr_aggregate_rating['availability'] = 'https://schema.org/InStock';
	$arr_aggregate_rating['price'] = '';
	$arr_aggregate_rating['price_valid_until'] = '';
	$arr_aggregate_rating['mpn'] = '';
	// $arr_aggregate_rating['review'] = array();

	// $arr_aggregate_rating['@type'] = 'Review';
	$arr_aggregate_rating['author'] = '';
	$arr_aggregate_rating['datePublished'] = '';
	$arr_aggregate_rating['reviewBody'] = '';
	$arr_aggregate_rating['name'] = '';
	// $arr_aggregate_rating['reviewRating']['@type'] = 'Rating';
	$arr_aggregate_rating['reviewRating']['bestRating'] = 5;
	$arr_aggregate_rating['reviewRating']['ratingValue'] = 0;
	$arr_aggregate_rating['reviewRating']['worstRating'] = 1;

	
	// dd($reviews_info);

	if($url_segment == "product_detail")
	{
		if(isset($arr_data) && count($arr_data) > 0)
		{
			$arr_aggregate_rating['brand_name'] = isset($arr_data['get_brand_detail']['name'])? $arr_data['get_brand_detail']['name']: '';

			$total_review = get_total_reviews($arr_data['id']);
            $getavg_rating  = get_avg_rating($arr_data['id']);   
			$arr_aggregate_rating['average_rating_value'] = isset($getavg_rating)? $getavg_rating: '';
			$arr_aggregate_rating['review_count'] =  isset($total_review)? $total_review: '';
			$arr_aggregate_rating['product_name'] = isset($arr_data['product_name'])? $arr_data['product_name']: '';

			if(!empty($arr_data['product_images_details'][0]['image']) && count($arr_data['product_images_details']) && file_exists(base_path().'/uploads/product_images/'.$arr_data['product_images_details'][0]['image']))
			{
				$arr_aggregate_rating['image'] = url('/')."/uploads/product_images/".$arr_data['product_images_details'][0]['image'];
			}
			$arr_aggregate_rating['sku'] = isset($arr_data['sku'])? $arr_data['sku']: '';
			$arr_aggregate_rating['availability'] = isset($arr_data['inventory_details']['remaining_stock']) && $arr_data['inventory_details']['remaining_stock'] > 0 ? 'https://schema.org/InStock': 'https://schema.org/OutOfStock';

			$arr_aggregate_rating['price'] =  isset($arr_data['price_drop_to']) && $arr_data['price_drop_to'] > 0 ? num_format($arr_data['price_drop_to']): num_format($arr_data['unit_price']);
			$arr_aggregate_rating['price_valid_until'] = '2021-12-31';
			$arr_aggregate_rating['mpn'] = '';

			if(isset($arr_data['review_details']) && count($arr_data['review_details'])> 0 )
			{
				$temp_ratings = $arr_data['review_details'];
				$keys = array_column($temp_ratings, 'rating');

    			
    			array_multisort($keys, SORT_DESC, $temp_ratings);
    			
				// $arr_aggregate_rating['@type'] = 'Review';

				$reviewer_first_name = (isset($temp_ratings[0]['user_details']['first_name']) && $temp_ratings[0]['user_details']['first_name'] !='') ? $temp_ratings[0]['user_details']['first_name'] : '';
				$reviewer_last_name = (isset($temp_ratings[0]['user_details']['last_name']) && $temp_ratings[0]['user_details']['last_name'] !='') ? $temp_ratings[0]['user_details']['last_name'] : '';


				$reviewer_name = '';

				if($reviewer_first_name !='' || $reviewer_last_name!='')
				{
					$reviewer_name = $reviewer_first_name.' '.$reviewer_last_name;

				}
				elseif(isset($temp_ratings[0]['user_name']) && $temp_ratings[0]['user_name'] !='')
				{
					$reviewer_name = $temp_ratings[0]['user_name'];
				}
				else
				{
					$reviewer_name = '';
				}

				$arr_aggregate_rating['author'] = $reviewer_name;
				$arr_aggregate_rating['datePublished'] = isset($temp_ratings[0]['created_at']) ? $temp_ratings[0]['created_at'] : '';
				$arr_aggregate_rating['reviewBody'] = isset($temp_ratings[0]['review']) ? $temp_ratings[0]['review'] : ''; 
				$arr_aggregate_rating['name'] = isset($temp_ratings[0]['title']) ? $temp_ratings[0]['title'] : ''; 
				// $arr_aggregate_rating['reviewRating']['@type'] = 'Rating';
				$arr_aggregate_rating['reviewRating']['bestRating'] = 5;
				$arr_aggregate_rating['reviewRating']['ratingValue'] = isset($temp_ratings[0]['rating']) ? $temp_ratings[0]['rating'] : 0; 
				$arr_aggregate_rating['reviewRating']['worstRating'] = 1;

			}
			// array_push($arr_aggregate_rating['review'],json_encode($reviews_info));
		}

	}
	elseif($url_segment == "brands")
	{
     	$brand_name = str_replace('-',' ',$arr_data['brands']); 

		$brand_details = \App\Models\BrandModel::select(['id','name'])
											   ->where('name',$brand_name)
											   ->first();

        if(isset($brand_details))
        {
        	$brand_details = $brand_details->toArray();
        	$arr_aggregate_rating['brand_name'] = isset($brand_details['name'])? $brand_details['name']: '';

			$products_obj = \App\Models\ProductModel::with([
													'review_details',
													'get_rating_detail',
													'get_seller_details.get_country_detail', 
                                            		'get_seller_details.get_state_detail', 
													])
													->where('is_active',1)
													->where('is_approve',1)
												  	->whereHas('get_seller_details.get_country_detail',function($q){
		                                                $q->where('is_active','1');
		                                            })
		                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
		                                                $q->where('is_active', '1');
		                                            })
	                                              	->whereHas('get_seller_details', function ($q) {
		                                                $q->where('is_active', '1');
		                                            })
													->where('brand',$brand_details['id'])
													->get();        	
            if($products_obj)
            {
            	$arr_products = $products_obj->toArray();
            	
            	if($arr_products &&  count($arr_products) > 0)
            	{
	            	$arr_product_ids = array_column($arr_products,'id');
	            	$admin_review = array_sum(array_column($arr_products,'avg_review'));
	            	$admin_rating = array_sum(array_column($arr_products,'avg_rating'));
	            	

	                $review_count = \App\Models\ReviewRatingsModel::whereIn('product_id',$arr_product_ids)
	                											  ->count(); 

	                $sum_of_reviews = \App\Models\ReviewRatingsModel::whereIn('product_id',$arr_product_ids)											->sum('rating');   


	                if($review_count > 0 && $sum_of_reviews > 0 )
				    {	
					  $avg_rating     = floatval($sum_of_reviews)/floatval($review_count);

					  $avg_rating_comnbined = 0;
					  if($admin_rating > 0)
					  {
					  	$avg_rating_comnbined = ($avg_rating + $admin_rating)/2;
					  }
					  else
					  {
					  	$avg_rating_comnbined = $avg_rating;	
					  }
					  $get_aggregaterating = round_rating_in_half($avg_rating_comnbined);	 
					     

					  $arr_aggregate_rating['average_rating_value'] = isset($get_aggregaterating)? $get_aggregaterating: '';
					  $arr_aggregate_rating['review_count'] =  isset($review_count)? $review_count + $admin_review: ''; 
				    }

				   $max_rating_obj = \App\Models\ReviewRatingsModel::whereIn('product_id',$arr_product_ids)
		    												->with([
		    													'user_details',
		    													'product_details.product_images_details',
		    													'product_details.inventory_details'
		    												])
    														->orderBy('rating','desc')
    														->first(); 
				    if($max_rating_obj)
				    {
				    	$arr_max_rating = $max_rating_obj->toArray();
				    	
				    	$arr_aggregate_rating['product_name'] = isset($arr_max_rating['product_details']['product_name'])? $arr_max_rating['product_details']['product_name']: '';

						if(!empty($arr_max_rating['product_details']['product_images_details'][0]['image']) && count($arr_max_rating['product_details']['product_images_details']) && file_exists(base_path().'/uploads/product_images/'.$arr_max_rating['product_details']['product_images_details'][0]['image']))
						{
							$arr_aggregate_rating['image'] = url('/')."/uploads/product_images/".$arr_max_rating['product_details']['product_images_details'][0]['image'];
						}
						$arr_aggregate_rating['sku'] = isset($arr_max_rating['product_details']['sku'])? $arr_max_rating['product_details']['sku']: '';
						$arr_aggregate_rating['availability'] = isset($arr_max_rating['product_details']['inventory_details']['remaining_stock']) && $arr_max_rating['product_details']['inventory_details']['remaining_stock'] > 0 ? 'https://schema.org/InStock': 'https://schema.org/OutOfStock';

						$arr_aggregate_rating['price'] =  isset($arr_max_rating['product_details']['price_drop_to']) && $arr_max_rating['product_details']['price_drop_to'] > 0 ? num_format($arr_max_rating['product_details']['price_drop_to']): num_format($arr_max_rating['product_details']['unit_price']);
						$arr_aggregate_rating['price_valid_until'] = '2021-12-31';
						$arr_aggregate_rating['mpn'] = '';

						
			    			
						$reviewer_first_name = (isset($arr_max_rating['user_details']['first_name']) && $arr_max_rating['user_details']['first_name'] !='') ? $arr_max_rating['user_details']['first_name'] : '';
						$reviewer_last_name = (isset($arr_max_rating['user_details']['last_name']) && $arr_max_rating['user_details']['last_name'] !='') ? $arr_max_rating['user_details']['last_name'] : '';

						$reviewer_name = '';

						if($reviewer_first_name !='' || $reviewer_last_name!='')
						{
							$reviewer_name = $reviewer_first_name.' '.$reviewer_last_name;

						}
						elseif(isset($arr_max_rating['user_name']) && $arr_max_rating['user_name'] !='')
						{
							$reviewer_name = $arr_max_rating['user_name'];
						}
						else
						{
							$reviewer_name = '';
						}
						
						
						$arr_aggregate_rating['author'] = $reviewer_name;
						
						$arr_aggregate_rating['datePublished'] = $arr_max_rating['created_at'];
						$arr_aggregate_rating['reviewBody'] = isset($arr_max_rating['review'])? $arr_max_rating['review']: "";
						$arr_aggregate_rating['name'] = isset($arr_max_rating['title'])? $arr_max_rating['title']: "";
						// $arr_aggregate_rating['reviewRating']['@type'] = 'Rating';
						$arr_aggregate_rating['reviewRating']['bestRating'] = 5;
						$arr_aggregate_rating['reviewRating']['ratingValue'] = isset($arr_max_rating['rating'])? $arr_max_rating['rating']: 0;
						$arr_aggregate_rating['reviewRating']['worstRating'] = 1;

				    }

				}
		
			}
		}

	}elseif($url_segment == "sellers")
	{
     	$seller_name = str_replace('-',' ',$arr_data['sellers']); 

		$seller_details = \App\Models\SellerModel::select(['id','user_id','business_name'])
												  ->with(['user_details'])
												  ->where('business_name',$seller_name)
												  ->first();
												  // dd($seller_details);
        if(isset($seller_details))
        {
        	$seller_details = $seller_details->toArray();

			$products_obj = \App\Models\ProductModel::with([
													'review_details',
													'get_rating_detail',
													'get_seller_details.get_country_detail', 
                                            		'get_seller_details.get_state_detail', 
                                            		'get_brand_detail'
													])
													->where('is_active',1)
													->where('is_approve',1)
												  	->whereHas('get_seller_details.get_country_detail',function($q){
		                                                $q->where('is_active','1');
		                                            })
		                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
		                                                $q->where('is_active', '1');
		                                            })
	                                              	 ->whereHas('get_brand_detail', function ($q) {
		                                                $q->where('is_active', '1');
		                                            })
													->where('user_id',$seller_details['user_id'])
													->get();        	
            if($products_obj)
            {
            	$arr_products = $products_obj->toArray();
            	
            	if($arr_products &&  count($arr_products) > 0)
            	{
	            	$arr_product_ids = array_column($arr_products,'id');

	            	$admin_review = array_sum(array_column($arr_products,'avg_review'));
	            	$admin_rating = array_sum(array_column($arr_products,'avg_rating'));

	                $review_count = \App\Models\ReviewRatingsModel::whereIn('product_id',$arr_product_ids)
            													  ->count();      	 

	                $sum_of_reviews = \App\Models\ReviewRatingsModel::whereIn('product_id',$arr_product_ids)
	                											  ->sum('rating');      	      
	                if($review_count > 0 && $sum_of_reviews > 0 )
				    {	
					  $avg_rating     = floatval($sum_of_reviews)/floatval($review_count);
					  
					  $avg_rating_comnbined = 0; 
					  if($admin_rating > 0)
					  {
					  	$avg_rating_comnbined = ($avg_rating + $admin_rating)/2;
					  }
					  else
					  {
					  	$avg_rating_comnbined = $avg_rating;	
					  }
					  $get_aggregaterating = round_rating_in_half($avg_rating_comnbined);	

					  $arr_aggregate_rating['average_rating_value'] = isset($get_aggregaterating)? $get_aggregaterating: '';
					  $arr_aggregate_rating['review_count'] =  isset($review_count)? $review_count + $admin_review: ''; 
				    }

				    $max_rating_obj = \App\Models\ReviewRatingsModel::whereIn('product_id',$arr_product_ids)
				    												->with([
				    													'user_details',
				    													'product_details.product_images_details',
				    													'product_details.get_brand_detail',
				    													'product_details.inventory_details'
				    												])
				    												->orderBy('rating','desc')
				    												->first(); 
				    if($max_rating_obj)
				    {
				    	$arr_max_rating = $max_rating_obj->toArray();
				    	
				    	$arr_aggregate_rating['brand_name'] = isset($arr_max_rating['product_details']['get_brand_detail']['name'])? $arr_max_rating['product_details']['get_brand_detail']['name']: '';

				    	$arr_aggregate_rating['product_name'] = isset($arr_max_rating['product_details']['product_name'])? $arr_max_rating['product_details']['product_name']: '';

						if(!empty($arr_max_rating['product_details']['product_images_details'][0]['image']) && count($arr_max_rating['product_details']['product_images_details']) && file_exists(base_path().'/uploads/product_images/'.$arr_max_rating['product_details']['product_images_details'][0]['image']))
						{
							$arr_aggregate_rating['image'] = url('/')."/uploads/product_images/".$arr_max_rating['product_details']['product_images_details'][0]['image'];
						}
						$arr_aggregate_rating['sku'] = isset($arr_max_rating['product_details']['sku'])? $arr_max_rating['product_details']['sku']: '';

						$arr_aggregate_rating['availability'] = isset($arr_max_rating['product_details']['inventory_details']['remaining_stock']) && $arr_max_rating['product_details']['inventory_details']['remaining_stock'] > 0 ? 'https://schema.org/InStock': 'https://schema.org/OutOfStock';

						$arr_aggregate_rating['price'] =  isset($arr_max_rating['product_details']['price_drop_to']) && $arr_max_rating['product_details']['price_drop_to'] > 0 ? num_format($arr_max_rating['product_details']['price_drop_to']): num_format($arr_max_rating['product_details']['unit_price']);
						$arr_aggregate_rating['price_valid_until'] = '2021-12-31';
						$arr_aggregate_rating['mpn'] = '';

						
			    			
						// $arr_aggregate_rating['@type'] = 'Review';
						$reviewer_first_name = (isset($arr_max_rating['user_details']['first_name']) && $arr_max_rating['user_details']['first_name'] !='') ? $arr_max_rating['user_details']['first_name'] : '';
						$reviewer_last_name = (isset($arr_max_rating['user_details']['last_name']) && $arr_max_rating['user_details']['last_name'] !='') ? $arr_max_rating['user_details']['last_name'] : '';
						
						$reviewer_name = '';

						if($reviewer_first_name !='' || $reviewer_last_name!='')
						{
							$reviewer_name = $reviewer_first_name.' '.$reviewer_last_name;

						}
						elseif(isset($arr_max_rating['user_name']) && $arr_max_rating['user_name'] !='')
						{
							$reviewer_name = $arr_max_rating['user_name'];
						}
						else
						{
							$reviewer_name = '';
						}

						$arr_aggregate_rating['author'] = $reviewer_name;
						$arr_aggregate_rating['datePublished'] = isset($arr_max_rating['created_at'])?$arr_max_rating['created_at']:"";
						$arr_aggregate_rating['reviewBody'] = isset($arr_max_rating['review'])?$arr_max_rating['review']:"";
						$arr_aggregate_rating['name'] = isset($arr_max_rating['title'])?$arr_max_rating['title']:"";
						// $arr_aggregate_rating['reviewRating']['@type'] = 'Rating';
						$arr_aggregate_rating['reviewRating']['bestRating'] = 5;
						$arr_aggregate_rating['reviewRating']['ratingValue'] = isset($arr_max_rating['rating'])?$arr_max_rating['rating']:0;
						$arr_aggregate_rating['reviewRating']['worstRating'] = 1;

				    }

				}
		
			}
		}

	}
	else
	{
		$review_count =0;$sum_of_reviews=0;
		$avg_rating=0;$get_aggregaterating=0;
	    

		$get_product = \App\Models\ReviewRatingsModel::with(
														'product_details.inventory_details',
														'product_details.get_brand_detail',
														'product_details.product_images_details',
														'user_details'
													)
													->orderby('rating','desc')
													->first();

													
		if(isset($get_product) && !empty($get_product))
		{
			$arr_product = $get_product->toArray();

			$arr_aggregate_rating['brand_name'] = isset($arr_product['product_details']['get_brand_detail']['name'])? $arr_product['product_details']['get_brand_detail']['name']: '';

            $getavg_rating  = get_avg_rating($arr_product['product_details']);   
			$total_review = get_total_reviews($arr_product['product_details']);
			$arr_aggregate_rating['average_rating_value'] = isset($getavg_rating)? $getavg_rating: '';
			$arr_aggregate_rating['review_count'] =  isset($total_review)? $total_review: '';

		
			$arr_aggregate_rating['product_name'] = isset($arr_product['product_details']['product_name'])? $arr_product['product_details']['product_name']: '';

			if(!empty($arr_product['product_details']['product_images_details'][0]['image']) 
				&& count($arr_product['product_details']['product_images_details']) 
				&& file_exists(base_path().'/uploads/product_images/'.$arr_product['product_details']['product_images_details'][0]['image']))
			{
				$arr_aggregate_rating['image'] = url('/')."/uploads/product_images/".$arr_product['product_details']['product_images_details'][0]['image'];
			}

			$arr_aggregate_rating['sku'] =  isset($arr_product['product_details']['sku'])? $arr_product['product_details']['sku']: '';
			

			$arr_aggregate_rating['availability'] = isset($arr_product['product_details']['inventory_details']['remaining_stock']) && $arr_product['product_details']['inventory_details']['remaining_stock'] > 0 ? 'https://schema.org/InStock': 'https://schema.org/OutOfStock';

			$arr_aggregate_rating['price'] =  isset($arr_product['product_details']['price_drop_to']) && $arr_product['product_details']['price_drop_to'] > 0 ? num_format($arr_product['product_details']['price_drop_to']): num_format($arr_product['product_details']['unit_price']);

			$arr_aggregate_rating['price_valid_until'] = '2021-12-31';
			$arr_aggregate_rating['mpn'] = '';

			
    			
			// $arr_aggregate_rating['@type'] = 'Review';
			$reviewer_first_name = (isset($arr_product['user_details']['first_name']) && $arr_product['user_details']['first_name'] !='') ? $arr_product['user_details']['first_name'] : '';
			$reviewer_last_name = (isset($arr_product['user_details']['last_name']) && $arr_product['user_details']['last_name'] !='') ? $arr_product['user_details']['last_name'] : '';

			$reviewer_name = '';

			if($reviewer_first_name !='' || $reviewer_last_name!='')
			{
				$reviewer_name = $reviewer_first_name.' '.$reviewer_last_name;

			}
			elseif(isset($arr_product['user_name']) && $arr_product['user_name'] !='')
			{
				$reviewer_name = $arr_product['user_name'];
			}
			else
			{
				$reviewer_name = '';
			}
			

			$arr_aggregate_rating['author'] = $reviewer_name;
			$arr_aggregate_rating['datePublished'] = isset($arr_product['created_at'])?$arr_product['created_at']:""; 
			$arr_aggregate_rating['reviewBody'] = isset($arr_product['review'])?$arr_product['review']:""; 
			$arr_aggregate_rating['name'] = isset($arr_product['title'])?$arr_product['title']:""; 
			// $arr_aggregate_rating['reviewRating']['@type'] = 'Rating';
			$arr_aggregate_rating['reviewRating']['bestRating'] = 5;
			$arr_aggregate_rating['reviewRating']['ratingValue'] = isset($arr_product['rating'])?$arr_product['rating']:0; 
			$arr_aggregate_rating['reviewRating']['worstRating'] = 1;
		}
		
	}
	
	return $arr_aggregate_rating;		
}//end of function


/*function number_format_short( $n ) {
	$n_format='';$suffix='';
	if ($n > 0 && $n < 1000) {
		// 1 - 999
		$n_format = floor($n);
		$suffix = '';
	} else if ($n >= 1000 && $n < 1000000) {
		// 1k-999k
		$n_format = floor($n / 1000);
		$suffix = 'K+';
	} else if ($n >= 1000000 && $n < 1000000000) {
		// 1m-999m
		$n_format = floor($n / 1000000);
		$suffix = 'M+';
	} else if ($n >= 1000000000 && $n < 1000000000000) {
		// 1b-999b
		$n_format = floor($n / 1000000000);
		$suffix = 'B+';
	} else if ($n >= 1000000000000) {
		// 1t+
		$n_format = floor($n / 1000000000000);
		$suffix = 'T+';
	}

	return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
}*/

function number_format_short( $n, $precision = 1 ) {
	$n_format='';
	$suffix ='';


	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}

  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}

	return $n_format . $suffix;
}//end of function


function unique_code($limit)
{
  return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
}

function get_usersubscription_data()
{
	 $user_subscriptiondata=[];

	    $user = Sentinel::getUser();
	    $user_subscried = 0;
	    if(!empty($user))
	    {
	        $seller_id = $user->id;
     
	        if ($user->subscribed('main')) {
	            $user_subscried = 1;

	        }else{
	          $user_subscried =0;
	        }

	   }


     $user_subscriptiondata = UserSubscriptionsModel::where('user_id',$seller_id)->where('membership_status','1')->get();
     if(isset($user_subscriptiondata) && !empty($user_subscriptiondata))
     {
      $user_subscriptiondata = $user_subscriptiondata->toArray();
     }

     $user_subscription = [];
     $user_subscription['user_subscried_flag'] = $user_subscried;	
     $user_subscription['user_subscription_data'] = isset($user_subscriptiondata)?$user_subscriptiondata:[];	

     return $user_subscription;


}//end of function get_usersubscription_data

function get_header_wallet()
{
	$arr_pending_wallet = $transaction_arr = [];
	$walletarr = [];
    $logginId = 0;
    $user = Sentinel::check();

    if ($user)
    {
        $logginId = $user->id;
    }
    $obj_pending_wallet_details = OrderModel::where([['seller_id',$logginId],['order_status','1'],['withdraw_reqeust_status','0']])->get();

    if ($obj_pending_wallet_details) 
    {
        $arr_pending_wallet = $obj_pending_wallet_details->toArray();
    }
    $wallet_amount = array_sum((array_column($arr_pending_wallet,'total_amount')));
    $seller_delivered_delivery_option_amt = array_sum((array_column($arr_pending_wallet , 'delivery_cost')));
    $seller_coupon_discount_amt = array_sum((array_column($arr_pending_wallet,'seller_discount_amt')));

     $wallt_amt =0;
     $commision_arr = get_commision();
    
     if((!$commision_arr==false) &&isset($commision_arr) && (isset($commision_arr['seller_commission'])))
     {

     	  if (isset($seller_delivered_delivery_option_amt) && !empty($seller_delivered_delivery_option_amt)) 
     	  {

              $wallet_amount = (float)$wallet_amount + (float)$seller_delivered_delivery_option_amt;
          }   

          if(isset($seller_coupon_discount_amt) && !empty($seller_coupon_discount_amt))
          {
            $wallet_amount = ((float)$wallet_amount-(float)$seller_coupon_discount_amt);
          }
         
          $seller_commission = (float)$commision_arr['seller_commission'];
          $wallt_amt = $wallet_amount*($seller_commission)/100;
          $wallt_amt = num_format($wallt_amt);

     }
     /****************Referal code conditions*************/
        $referal_wallet_amount = UserReferWalletModel::
                                where('withdraw_reqeust_status','0')
                                ->where('user_id',$logginId)
                                ->sum('amount');          

     /*******************************************/

       $walletarr['referal_wallet_amount']  
       = isset($referal_wallet_amount)?$referal_wallet_amount:'0';
       $walletarr['wallet_amount']  = (float)$wallt_amt;

       return $walletarr;
}//end of function


 function get_commision()
{
	
    $site_setting_arr = [];
    $commision_arr = [];
    $site_setting_obj = SiteSettingModel::first();  
    if(isset($site_setting_obj))
    {
        $site_setting_arr = $site_setting_obj->toArray();  
        if(isset($site_setting_arr) && count($site_setting_arr)>0)
       {
            $admin_commission = $site_setting_arr['admin_commission'];
            $seller_commission = $site_setting_arr['seller_commission'];

            $commision_arr['admin_commission']  = isset($admin_commission)?$admin_commission:'13';
            $commision_arr['seller_commission'] = isset($seller_commission)?$seller_commission:'87';
            return $commision_arr;
            

       }else{
       	return false;
       }
    }else{
    	return false;
    }
}//end of function of get commision 



function get_shipping_duration_in_days($shipping_duration="")
{
  $full_day = $str_shipping_duration = ""; 
  if(isset($shipping_duration) && $shipping_duration!="" && filter_var($shipping_duration, FILTER_VALIDATE_FLOAT)==true && $shipping_duration!=0.500000) 
  {
     $full_day = floor($shipping_duration); 
     $fraction = $shipping_duration - $full_day;
     if(isset($full_day) && $full_day!="")
     { 
        if(isset($fraction) && $fraction!=0)
        {  
         $str_shipping_duration = $full_day." & Half Day";  
        }
        else if(isset($fraction) && $fraction==0 && $full_day==1) 
        {
         $str_shipping_duration = $full_day." Day"; 
        }
        else if(isset($fraction) && $fraction==0 && $full_day!=1) 
        {
         $str_shipping_duration = $full_day." Days"; 
        }
     }
  }
  else if(isset($shipping_duration) && $shipping_duration!="" && filter_var($shipping_duration, FILTER_VALIDATE_FLOAT)==true && $shipping_duration== 0.500000)
  {
      $str_shipping_duration = "Half Day";  
  }

  return $str_shipping_duration;
}

//Function for getting product dimensions
function get_product_dimensions($product_id=false)
{
   $arr_product_dimensions = "";	
   if($product_id)
   {
   	  $obj_product_dimensions = ProductDimensionsModel::where('product_id',$product_id)->get();
   	  if(isset($obj_product_dimensions))
   	  {
   	  	 $arr_product_dimensions = $obj_product_dimensions->toArray();
   	  }

   	  return $arr_product_dimensions;
   }
}

//function for getting seller details
function get_seller_details($seller_id=false)
{
 	$obj_seller = UserModel::where('id',$seller_id)->with('seller_detail')->first();

 	if(isset($obj_seller))
 	{	

 		if(isset($obj_seller['seller_detail']) && $obj_seller['seller_detail']['business_name']!='')
 		{
 			$seller_name = $obj_seller['seller_detail']['business_name'];
 		}
 		else
 		{
 			$seller_name = $obj_seller['first_name'].' '.$obj_seller['last_name'];
 		}

  		//$seller_name = $obj_seller['first_name'].' '.$obj_seller['last_name'];

  		return $seller_name;
 	} //if isset
}//end function


function get_countrydata($countryid=false)
{	  $countryname ='';
	  $getcountry = CountriesModel::where('id',$countryid)->first(); 
      if(isset($getcountry) && !empty($getcountry))
      {
      	$getcountry = $getcountry->toArray();
      	$countryname = $getcountry['name'];
      }
      return $countryname; 
}

function get_statedata($stateid=false)
{	  $statename ='';
	  $getstate = StatesModel::where('id',$stateid)->first(); 
      if(isset($getstate) && !empty($getstate))
      {
      	$getstate  = $getstate->toArray();
      	$statename = $getstate['name'];
      }
      return $statename; 
}


 function words($str, $words = 100, $end = '...')
 {
        return \Illuminate\Support\Str::words($str, $words, $end);
 }
 
 function get_dropshipper_info($dropshipperid=false,$productid=NULL)
 {
 	$dropshipper = [];
 	$dropshipperinfo = DropShipperModel::where('id',$dropshipperid)->where('product_id',$productid)->first();
	if(isset($dropshipperinfo) && !empty($dropshipperinfo))
	{
		$dropshipperinfo = $dropshipperinfo->toArray();
		$dropshipper_id = $dropshipperinfo['id'];
		$dropshipper_name = $dropshipperinfo['name'];
		$dropshipper_email = $dropshipperinfo['email'];
		$dropshipper_price = $dropshipperinfo['product_price'];
		$dropshipper['id'] = isset($dropshipper_id)?$dropshipper_id:'';
		$dropshipper['email'] = isset($dropshipper_email)?$dropshipper_email:'';
		$dropshipper['name'] = isset($dropshipper_name)?$dropshipper_name:'';
		$dropshipper['unit_price']= isset($dropshipper_price)?$dropshipper_price:0;
		return $dropshipper;
	}
 }

 // function get_restrict_category_names($arr_restrict_categories=false)
 // {
 // 	$category_name = $str_categories = "";
 // 	$arr_categories_names = [];

 // 	if(isset($arr_restrict_categories) && sizeof($arr_restrict_categories)>0)
 // 	{
 // 		foreach($arr_restrict_categories as $category)
 // 		{
 // 			$category_name           = FirstLevelCategoryModel::where('id',$category)->first()->product_type;
 // 			$arr_categories_names[]  = $category_name;
 // 		} 

 //       if(isset($arr_categories_names) && sizeof($arr_categories_names)>0)
 //       {	
 // 	      $str_categories = implode(',',$arr_categories_names);
 // 	   }

 // 	   return rtrim($str_categories, ',');
 // 	} 
 // }
 function get_restrict_category_names($arr_restrict_categories=false)
 {
 	$category_name = $str_categories = "";
 	$arr_categories_names = [];
 	if(isset($arr_restrict_categories) && !empty($arr_restrict_categories))
 	{
 		foreach($arr_restrict_categories as $category)
 		{
 			$category_name           = FirstLevelCategoryModel::where('id',$category)->select('product_type')->first();
 			if($category_name)
 			{
 				$category_name = $category_name->toArray();
 				$arr_categories_names[]  = $category_name['product_type'];
 			}	
 		}
       if(isset($arr_categories_names) && !empty($arr_categories_names))
       {
 	       $str_categories = implode(',',$arr_categories_names);
 	   }
 	   return rtrim($str_categories, ',');
 	}
 }


 function get_product_dropshipper($droppshipper_id="")
 {
 	$arr_dropshipper_details = [];
 	if($droppshipper_id!="")
 	{
 		$obj_dropshipper_details = DropShipperModel::where('id',$droppshipper_id)->first();
 		if($obj_dropshipper_details)
 		{
 			 $arr_dropshipper_details = $obj_dropshipper_details->toArray();
 		}
 	}

 	return $arr_dropshipper_details;
 }

 function get_shipping_duration_in_date($shipping_duration="",$date="")
 {
 	$shipping_duration_in_date = $formatted_date = $timestamp = "";

 	if($shipping_duration!="")
 	{
 	 
 	   if($date=="")
 	   {	
         $date = date('m-d-Y');
       }
       else 
       {
         $date = $date;
       }
       list($m,$d,$y) = explode("-",$date);
       $timestamp = mktime(0,0,0,$m,$d,$y);
       $formatted_date = date("Y-m-d",$timestamp);

       $shipping_duration_in_date = date('D. F d', strtotime($formatted_date. ' + ' .round($shipping_duration).' days'));
 	} 

 	return $shipping_duration_in_date;
 }

 /* Created seperate helper function to get specific date format */
 function get_shipping_duration_in_date_new($shipping_duration="",$date="")
 {
 	$shipping_duration_in_date = $formatted_date = $timestamp = "";

 	if($shipping_duration!="")
 	{
 	 
 	   if($date=="")
 	   {	
         $date = date('m-d-Y');
       }
       else 
       {
         $date = $date;
       }
       list($m,$d,$y) = explode("-",$date);
       $timestamp = mktime(0,0,0,$m,$d,$y);
       $formatted_date = date("Y-m-d",$timestamp);

       $shipping_duration_in_date = date('F d', strtotime($formatted_date. ' + ' .round($shipping_duration).' days'));
 	} 

 	return $shipping_duration_in_date;
 }


 function get_product_info($productid)
 {
 	 $productinfo = ProductModel::where('id',$productid)->first();
 	 if(isset($productinfo) && !empty($productinfo))
 	 {
 	 	$productinfo = $productinfo->toArray();
 	 	return $productinfo;
 	 }
 }
function get_total_reviews_of_order($order_id="")
{
   $product_review_count = $total_review_count =  0;
   if($order_id!="")
   {
   	  $order_products = OrderProductModel::where('order_id',$order_id)->select('product_id')->get();
   	  if(isset($order_products) && !empty($order_products))
   	  {
   	  	 $order_products = $order_products->toArray();
   	  	 foreach($order_products as $product)
   	  	 {
   	  	 	$product_review_count =  ReviewRatingsModel::where('product_id',$product['product_id'])->count();
   	  	 	$total_review_count   = $product_review_count + $total_review_count;
   	  	 } 
   	  }
   }
  return $total_review_count;
}

function get_total_ques_ans_of_order($order_id="")
{
   $ques_ans_count = $total_ques_ans_count =  0;
   if($order_id!="")
   {
   	  $order_products = OrderProductModel::where('order_id',$order_id)->select('product_id')->get();
   	  if(isset($order_products) && !empty($order_products))
   	  {
   	  	 $order_products = $order_products->toArray();
   	  	 foreach($order_products as $product)
   	  	 {
   	  	 	$ques_ans_count         =  ProductCommentModel::where('product_id',$product['product_id'])->count();
   	  	 	$total_ques_ans_count   = $ques_ans_count + $total_ques_ans_count;
   	  	 } 
   	  }
   }
  return $total_ques_ans_count;
}

function get_total_ques_ans_of_product($product_id="")
{
   $total_ques_ans_count =  0;
   if($product_id!="")
   {
   	 $total_ques_ans_count =  ProductCommentModel::where('product_id',$product_id)->count();
   }
  return $total_ques_ans_count;
}

/*
function get_user_current_location()
{
	$lat="18.5401344";
	$long ="73.8295808";

	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($long).'&sensor=false&key=AIzaSyBYfeB69IwOlhuKbZ1pAOwcjEAz3SYkR-o';
    $json = @file_get_contents($url);
    $data = json_decode($json);
   
    $status = $data->status;
    
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
        $location =  '';
    }
    
    //return address to ajax 
  //  echo $location;
}
*/
/*
function get_categoriesonshop($stateparameter="")
{
	    $category_ids='';       
        if(isset($stateparameter))
        {
            $statenam = str_replace('-',' ',$stateparameter); 
           // $get_categoryids = $this->StatesModel->where('name',$search_request['state'])->first();
            $get_categoryids = $this->StatesModel->where('name',$statenam)->first();
            if(isset($get_categoryids) && !empty($get_categoryids))
            {
                $get_categoryids = $get_categoryids->toArray();
                $category_ids = $get_categoryids['category_ids'];
            }
        }

        $category_arr = [];
        $obj_category = $this->FirstLevelCategoryModel
                                ->where('is_active',1)
                                ->orderBy('product_type');
         if(isset($category_ids) && !empty($category_ids)) 
        {   
            $catdata =[];
            $category_ids = explode(",",$category_ids);
             foreach ($category_ids as $ids) {
                $catdata[] = $ids;
            }
           $obj_category = $obj_category->whereNotIn('id',$catdata);
        }                             
           $obj_category = $obj_category->get();


        if (isset($obj_category) && count($obj_category) > 0) {
            
            $category_arr = $obj_category->toArray();
        }
        return $category_arr;
}*/

function checklocationdata()
{
	$returndata =[];		

	     $ipcountry  = '';
         $ipstate  = '';
         $state_user_ids='';
         $catdata =[];
         $login_user = Sentinel::check();  
         if(isset($login_user) && $login_user==true && $login_user->inRole('seller') == true) 
         {

         }
         else if(isset($login_user) && $login_user==true && $login_user->inRole('admin') == true) {

         }
        else if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true)
         {
               $ipcountry  = $login_user->country;
               $ipstate  = $login_user->state;
              
         }//else if user is buyer
         else{
            // $myip = $_SERVER['SERVER_ADDR'];
             $myip = $_SERVER['REMOTE_ADDR'];
             $get_ipdata = IpDataModel::where('ip',$myip)->first();
             if(isset($get_ipdata) && !empty($get_ipdata))
             {
               $get_ipdata = $get_ipdata->toArray(); 
               $ipcountry  = $get_ipdata['country'];
               $ipstate    = $get_ipdata['state'];
               $ipdb       = $get_ipdata['ip'];
             }
         }

        if(isset($ipstate) && !empty($ipstate) && isset($ipcountry) && !empty($ipcountry))
        { 
          
                $category_ids='';
                $get_categoryids = StatesModel::where('id',$ipstate)->where('is_active','1')->where('country_id',$ipcountry)->first();
                if(isset($get_categoryids) && !empty($get_categoryids))
                {
                    $get_categoryids = $get_categoryids->toArray();
                    $category_ids = $get_categoryids['category_ids'];

                }
          
               // $getusers_ofstate = UserModel::select('id')->where('state',$ipstate)->where('user_type','seller')->where('is_active','1')->get();
                // if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                // {
                   // $getusers_ofstate = $getusers_ofstate->toArray();
                   // $state_user_ids =  array_values($getusers_ofstate);//get user ids from 
                		
                        if(isset($category_ids) && !empty($category_ids)) 
                        {   
                            $catdata =[];
                            $category_ids = explode(",",$category_ids);

                             if(isset($category_ids) && !empty($category_ids)){
                                foreach ($category_ids as $ids) {
                                $catdata[] = $ids;                           
                                }    
                             }//isset
                        }      
                // }//if getusersofstate
              
        } // if ipstate

      //  $returndata['state_user_ids'] = isset($state_user_ids)?$state_user_ids:[];
        $returndata['catdata'] = isset($catdata)?$catdata:[];

        return $returndata;

}

function admin_locationdata($country='',$state='')
{
	$returndata =[];		
   

        if(isset($state) && !empty($state) && isset($country) && !empty($country))
        { 
          
                $category_ids='';


              	$checkcountry = CountriesModel::where('is_active','1')->where('id',$country)->first();  

              	if(isset($checkcountry) && !empty($checkcountry)){

		                $get_categoryids = StatesModel::where('id',$state)->where('is_active','1')->where('country_id',$country)->first();
		                if(isset($get_categoryids) && !empty($get_categoryids))
		                {
		                    $get_categoryids = $get_categoryids->toArray();
		                    $category_ids = $get_categoryids['category_ids'];

		                }
               }
          
               // $getusers_ofstate = UserModel::select('id')->where('state',$state)->where('user_type','seller')->where('is_active','1')->get();
                // if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                // {
                   // $getusers_ofstate = $getusers_ofstate->toArray();
                   // $state_user_ids =  array_values($getusers_ofstate);

                        if(isset($category_ids) && !empty($category_ids)) 
                        {   
                            $catdata =[];
                            $category_ids = explode(",",$category_ids);

                             if(isset($category_ids) && !empty($category_ids)){
                                foreach ($category_ids as $ids) {
                                $catdata[] = $ids;                           
                                }    
                             }//isset
                        }      
                 //}//if getusersofstate
              
        } // if state

       // $returndata['state_user_ids'] = isset($state_user_ids)?$state_user_ids:[];
        $returndata['catdata'] = isset($catdata)?$catdata:[];

        return $returndata;

}

function get_first_levelcategorydata($catid="")
{
	  $catname ='';
	  $getcategory = FirstLevelCategoryModel::where('id',$catid)->first(); 
      if(isset($getcategory) && !empty($getcategory))
      {
      	$getcategory = $getcategory->toArray();
      	$catname = $getcategory['product_type'];
      }
      return $catname; 	
}

function get_first_levelcategorydata_by_name($catname="")
{
	$description = '';
	  $category_name = str_replace('-and-','-&-',$catname);             
      $category_name = str_replace('-',' ',$category_name); 
	  $getcategory = FirstLevelCategoryModel::where('product_type',$category_name)->first(); 
	  
      if(isset($getcategory) && !empty($getcategory))
      {
      	$getcategory = $getcategory->toArray();
      	$catname = $getcategory['product_type'];
      }
      return $catname; 	
}

function get_first_levelcategory_description($catname="")
{
	$description = '';
	  $category_name = str_replace('-and-','-&-',$catname);             
      $category_name = str_replace('-',' ',$category_name); 
	  $getcategory = FirstLevelCategoryModel::where('product_type',$category_name)->first(); 
      if(isset($getcategory) && !empty($getcategory))
      {
      	$getcategory = $getcategory->toArray();
      	$description = $getcategory['description'];
      }
      // dd($getcategory);
      
      return $description; 	
}


function get_post_title($title)
{
	 $set_title='';
   if(isset($title))
   {  
   	   $title = strip_tags($title);
   	 
   	   $set_title = str_slug($title);
   	     
   }		
   return $set_title;
}

function check_isbestseller($productid=NULL)
{	
	 $isbestseller = 0;
	if(isset($productid)){
   
        $prodmodel           =  (new \App\Models\ProductModel)->getTable(); 
       
        $order_table         =  (new \App\Models\OrderModel)->getTable();

        $order_product_table  =  (new \App\Models\OrderProductModel)->getTable();

        $reviewmodel          = (new \App\Models\ReviewRatingsModel)->getTable();

        /* $arr_trending_productids = DB::table($order_table)
                                       ->select(DB::raw($order_table.'.*,'
                                         .$order_product_table.'.product_id'
                                    ))

                                    ->leftJoin($order_product_table,$order_product_table.'.order_id','=',$order_table.'.id')    
                                    ->where($order_table.'.order_status','1')  
                                    ->get()
                                    ->toArray(); 	

         if(isset($arr_trending_productids) && !empty($arr_trending_productids))
         {
         	$productids   = array_column($arr_trending_productids, 'product_id');

         	if(in_array($productid, $productids))
         	{

         		$high_ratings =  ReviewRatingsModel::
                                      with([
                                          'product_details',
                                          'product_details.age_restriction_detail',
                                          'product_details.get_brand_detail',
                                          'product_details.product_images_details',
                                      'product_details.get_seller_details.get_country_detail',
                                      'product_details.get_seller_details.get_state_detail'
                                      ])
                                     
                                      ->whereHas('product_details',function($q){
                                               $q->where('is_active','1');
                                               $q->where('is_approve','1');
                                             
                                      })
                                      ->whereHas('product_details.get_seller_details',function($q){
                                              $q->where('is_active','1');
                                      })

                                      ->whereHas('product_details.get_brand_detail',function($q){
                                              $q->where('is_active','1');
                                      })
                                      ->whereHas('product_details.get_seller_details.get_country_detail',function($q){
                                              $q->where('is_active','1');
                                      })
                                      ->whereHas('product_details.get_seller_details.get_state_detail',function($q){
                                              $q->where('is_active','1');
                                      })
                                      ->addSelect(DB::raw('AVG(product_rating_review.rating) 
                                                    as avg_rating,product_id'
                                                  ))
                                      ->havingRaw('AVG(product_rating_review.rating) >= ?', [4])
                                      ->havingRaw('AVG(product_rating_review.rating) <= ?', [5])

                                      ->where('product_id',$productid)
                                      ->first();   


         	  	    if(isset($high_ratings))
		            {
		               $isbestseller = "1";
		            }
		            else
		            {
		              $isbestseller = 0; 
		            }


         	}//if inarray
         	
         }//if isset trending product ids      
         */

       // new query added for best seller
        
         $productids = $avgproductids = [];
         $arr = []; $mostsolded ='';

         $arr_trending_productids =  DB::table($order_table)->select(DB::raw(
                                        $order_product_table.'.product_id,count('.$order_product_table.'.product_id) as mostsold'
                                    ))
                                  ->leftJoin($order_product_table,$order_product_table.'.order_id','=',$order_table.'.id')    
                                 ->where($order_table.'.order_status','1')  
                                 ->groupBy($order_product_table.'.product_id')
                                 ->orderBy('mostsold','desc')
                                 //->limit(50)
                                 ->get()->toArray();    	
        
         if(isset($arr_trending_productids) &&!empty($arr_trending_productids))
         {  
                 $productidssold   = array_column($arr_trending_productids, 'product_id');
                 $mostsold         = array_unique(array_column($arr_trending_productids, 'mostsold'));
                 $arr = []; $mostsolded ='';
                 foreach($mostsold as $v)
                 {
                    $arr[] = $v;
                 }
                 
                 $mostsolded = implode(",", $arr);

          }//if isset arr_mostsold_productids


             if(isset($arr_trending_productids) && !empty($arr_trending_productids) && isset($mostsolded) &&  !empty($mostsolded))
            {
                $productids   = array_column($arr_trending_productids, 'product_id');

                $arr_eloq_trending_data =  ProductModel::with([
                                'first_level_category_details',
                                'second_level_category_details',
                                'inventory_details',
                                'product_images_details',
                                'age_restriction_detail',
                                'get_seller_details.get_country_detail', 
                                'get_seller_details.get_state_detail', 
                                'get_seller_additional_details',
                                'get_brand_detail',
                                'review_details'
                                ])
                    ->whereHas('get_seller_details',function($q){
                        $q->where('is_active','1');
                    })
                    ->whereHas('get_seller_details.get_country_detail',function($q){
                        $q->where('is_active','1');
                    })
                    ->whereHas('get_seller_details.get_state_detail', function ($q) {
                        $q->where('is_active', '1');
                    })
                    ->whereHas('get_brand_detail', function ($q) {
                        $q->where('is_active', '1');
                    })
                 
                    ->whereIn('id',$productids)    
                    ->where([['is_active',1],['is_approve',1]])
                   // ->orderByRaw('FIELD(id,'.$mostsolded.')')
                    ->get();

 
                if(isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data))
                {
                    $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
                    $avgproductids   = array_column($arr_eloq_trending_data, 'id');
                    if(in_array($productid,$avgproductids))
                    {
                        $isbestseller = "1";
                    }else
                    {
                        $isbestseller = 0;
                    }
                } //if isset arr_eloq_trending_data                                    

            } // if isset arr trending & most solded



   }//if isset productid
   return $isbestseller;

}//check is best seller


//get country name
function get_country($id)
{
    $country_name = CountriesModel::where('id',$id)->pluck('name')->first();

    return $country_name;
}

//get state name
function get_state($id)
{
	
	$state_name = "";
	$state_name = StatesModel::where('id',$id)->pluck('name')->first();

    return $state_name;	
}


//function for getting buyer details
function get_buyer_details($buyer_id=false)
{
	$buyer_info =[];
 	$obj_buyer = UserModel::where('id',$buyer_id)->with('buyer_detail')->first();

 	if(isset($obj_buyer) && !empty($obj_buyer))
 	{	
        $obj_buyer = $obj_buyer->toArray();			
 		if(isset($obj_buyer['buyer_detail']) && !empty($obj_buyer['buyer_detail']))
 		{
 			$buyer_info = $obj_buyer;
 		}

  		return $buyer_info;
 	} //if isset
}//end function

//fubction for checking whether documents required for seller or not
function is_documents_required($seller_id=false)
{
	$documents_verification_status = "";
	if(isset($seller_id) && !empty($seller_id))
	{
		$obj_seller = UserModel::where('id',$seller_id)->with('seller_detail')->first();
		if(isset($obj_seller) && !empty($obj_seller))
		{
			$arr_seller   = $obj_seller->toArray();
			if(isset($arr_seller) && !empty($arr_seller))
			{	
			  $seller_state = $arr_seller['state'];
			  if(isset($seller_state) && !empty($seller_state))
			  {
			  	$is_restricted_state = StatesModel::where('id',$seller_state)->select('is_documents_required')->first();
			  	if(isset($is_restricted_state['is_documents_required']) && $is_restricted_state['is_documents_required']=='1')
			  	{
			  		 $documents_verification_status = isset($arr_seller['seller_detail']['documents_verification_status'])?$arr_seller['seller_detail']['documents_verification_status']:'';
			  		 return $documents_verification_status;
			  	}

			  	else
			  	{
			  		return 1;
			  	}
			  }

			  else
			  {	
			    return 1;
			  }  


		    }
		}
	}

	return $documents_verification_status;
}

function get_brand_name($brandid=false)
{
   	$obj_brand = BrandModel::where('id',$brandid)->first();
 	if(isset($obj_brand))
 	{
  		$brandname = $obj_brand['name'];

  		return $brandname;
 	}
}//end

function get_brand_description($brand_slug=false)
{	
	$brand_desc = '';
	$brand_name = str_replace('-and-','-&-',$brand_slug);
	$brand_name = str_replace('-',' ',$brand_name);
   	$obj_brand = BrandModel::where('name',$brand_name)->first();

   	
 	if(isset($obj_brand))
 	{
 		$arr_brand = $obj_brand->toArray();
  		$brand_desc = $arr_brand['description'];

  		return $brand_desc;
 	}
}//end

function check_seller_couponcode($seller_id=false)
{
	$sellercoupon = [];
	if(isset($seller_id) && !empty($seller_id))
	{
		$check = CouponModel::where('user_id',$seller_id)->where('is_active',1)->get();
		
		if(isset($check) && !empty($check))
		{	
			$sellercoupon = $check->toArray();
			if(isset($sellercoupon) && !empty($sellercoupon))
		    {	
			  return 1;
		    }else
		    {
		    	return 0;
		    }
		}//if
		else{
			$sellercoupon = [];
			return 0;
		}
	}
	
}//end


function check_coupon_exists($code=false)
{
	$sellercoupon = [];
	
	$check = CouponModel::where('code',$code)->where('is_active',1)->first();
	
	if(isset($check) && !empty($check))
	{	
		$sellercoupon = $check->toArray();
		
	}//if
		
	

	return $sellercoupon;
	
}//end

function get_seller_couponcode($seller_id=false,$code=false)
{
	$sellercoupon = [];
	if(isset($seller_id) && !empty($seller_id))
	{
		$check = CouponModel::where('user_id',$seller_id)->where('code',$code)->where('is_active',1)->first();
		
		if(isset($check) && !empty($check))
		{	
			$sellercoupon = $check->toArray();
			
		}//if
		
	}

	return $sellercoupon;
	
}//end


function get_coupncodedata_order($orderno=NULL,$orderid=NULL)
{	
	$coupondata = [];

	if(isset($orderno) && isset($orderid) && !empty($orderno)  && !empty($orderid))
	{
		$getorder= OrderModel::where('order_no',$orderno)->where('id',$orderid)->first();
		if(isset($getorder) && !empty($getorder))
		{
			   $getorder = $getorder->toArray();



			  $couponcode = isset($getorder['couponcode'])?$getorder['couponcode']:'';
              $discount = isset($getorder['discount'])?$getorder['discount']:'';
              $seller_discount_amt = isset($getorder['seller_discount_amt'])?$getorder['seller_discount_amt']:'';
              $sellername = get_seller_details($getorder['seller_id']);
              $coupondata[$getorder['seller_id']]['couponcode'] = $couponcode;
              $coupondata[$getorder['seller_id']]['discount'] = $discount;
              $coupondata[$getorder['seller_id']]['seller_discount_amt'] = $seller_discount_amt;
              $coupondata[$getorder['seller_id']]['sellername'] = $sellername;

              //echo "<pre>";print_r($coupondata);

		}	
	}else{
		$getorder= OrderModel::where('order_no',$orderno)->get();
		if(isset($getorder) && !empty($getorder))
		{
			   $getorder = $getorder->toArray();

			  

			   foreach($getorder as $kk=>$vv)
			   {
			   		$couponcode = isset($vv['couponcode'])?$vv['couponcode']:'';
              		$discount = isset($vv['discount'])?$vv['discount']:'';
             	    $seller_discount_amt = isset($vv['seller_discount_amt'])?$vv['seller_discount_amt']:'';
              		$sellername = get_seller_details($vv['seller_id']);

              		  $coupondata[$vv['seller_id']]['couponcode'] = $couponcode;
		              $coupondata[$vv['seller_id']]['discount'] = $discount;
		              $coupondata[$vv['seller_id']]['seller_discount_amt'] = $seller_discount_amt;
		              $coupondata[$vv['seller_id']]['sellername'] = $sellername;
			   }

			 
             

            //  echo "<pre>";print_r($coupondata);

		}	
	}//else
	return $coupondata;
}//function get_coupncodedata_order


function calculate_percentage_price_drop($product_id="",$unit_price="",$price_drop_to="")
{
	if(!empty($product_id) && !empty($unit_price) && !empty($price_drop_to))
	{
		$percent = (($unit_price - $price_drop_to)*100) /$unit_price ;
		if($percent > 0)
		{	
		   $update_percent_price_drop = ProductModel::where('id',$product_id)->update(array('percent_price_drop'=>$percent));	
		   $percent = number_format((float)$percent,2);
		   return $percent;
		   
	    }
	}
}//end


function get_spectrums($spectrumid=false)
{ 

	$spectrumarr = [];
	$obj_spectrum = SpectrumModel::where('is_active',1)->orderBy('name')->get();
	  
 	if(isset($obj_spectrum) && !empty($obj_spectrum))
 	{
 		$spectrumarr = $obj_spectrum->toArray();
 		
 	}
 	return $spectrumarr;
}//end


function get_cannabinoids($cannabinoidsid=false)
{ 

	$spectrumarr = [];
	$obj_cannabinoids = CannabinoidsModel::whereHas('get_products_canabinoids',function($q){

                                     })->where('is_active',1)->orderBy('name')->get();
	  
 	if(isset($obj_cannabinoids) && !empty($obj_cannabinoids))
 	{
 		$cannabinoids_arr = $obj_cannabinoids->toArray();
 		
 	}
 	return $cannabinoids_arr;
}//end

function get_cannabinoids_more($cannabinoidsid=false)
{ 

	$spectrumarr = [];
	$obj_cannabinoids = CannabinoidsModel::where('is_active',1)->orderBy('name')->get();
	  
 	if(isset($obj_cannabinoids) && !empty($obj_cannabinoids))
 	{
 		$cannabinoids_arr = $obj_cannabinoids->toArray();
 		
 	}
 	return $cannabinoids_arr;
}//end

/* Get Product wise cannabinoids name for listing of products only  */
function get_product_cannabinoids_name($product_id=false)
{ 

	$cannabinoids_arr = [];

	$cannabinoid_table  =  (new \App\Models\CannabinoidsModel)->getTable();
	$product_cannabinoid_table  =  (new \App\Models\ProductCannabinoidsModel)->getTable();

	/*$arr_product_cannabinoid_name =  ProductCannabinoidsModel::select(DB::raw(
                                       'GROUP_CONCAT('.$cannabinoid_table.'.name SEPARATOR " . ") as cannabinoids_name'
                                    ))
                                  ->leftJoin($cannabinoid_table,$cannabinoid_table.'.id','=',$product_cannabinoid_table	.'.cannabinoids_id')    
                                 ->where($product_cannabinoid_table.'.product_id',$product_id)  
                                 
                                 ->orderBy($product_cannabinoid_table.'.percent','desc')
                                 ->limit(3)
                                 ->get()->toArray(); */   

    $arr_product_cannabinoid_name =  ProductCannabinoidsModel::select(DB::raw(
                                       $cannabinoid_table.'.name as cannabinoids_name'
                                    ))
                                  ->leftJoin($cannabinoid_table,$cannabinoid_table.'.id','=',$product_cannabinoid_table	.'.cannabinoids_id')    
                                 ->where($product_cannabinoid_table.'.product_id',$product_id)  
                                 
                                 ->orderBy($product_cannabinoid_table.'.percent','desc')
                                 ->limit(3)
                                 ->get()->toArray(); 	

                             // dump($arr_product_cannabinoid_name);

	/*  
 	if(isset($arr_product_cannabinoid_name) && !empty($arr_product_cannabinoid_name))
 	{
 		$arr_product_cannabinoid_name = isset($arr_product_cannabinoid_name[0]['cannabinoids_name']) ?  $arr_product_cannabinoid_name[0]['cannabinoids_name'] : ""; 		
 	}*/
 	return $arr_product_cannabinoid_name;
}


/* Get Product wise cannabinoids */
function get_product_cannabinoids($product_id=false)
{ 

	$cannabinoids_arr = [];

	$cannabinoid_table  =  (new \App\Models\CannabinoidsModel)->getTable();
	$product_cannabinoid_table  =  (new \App\Models\ProductCannabinoidsModel)->getTable();

	$arr_product_cannabinoid_name =  ProductCannabinoidsModel::select(DB::raw(
                                       $cannabinoid_table.'.name,'.$product_cannabinoid_table.'.percent'
                                    ))
                                  ->leftJoin($cannabinoid_table,$cannabinoid_table.'.id','=',$product_cannabinoid_table	.'.cannabinoids_id')    
                                 ->where($product_cannabinoid_table.'.product_id',$product_id)  
                                 ->where($product_cannabinoid_table.'.percent','!=',0)  
                                 
                                 ->orderBy($product_cannabinoid_table.'.percent','desc')
                                 ->limit(5)
                                 ->get()->toArray();    	
                                 
 	return $arr_product_cannabinoid_name;
}




function get_spectrum_val($spectrumid=false)
{ 

	$spectrumarr = [];
	$obj_spectrum = SpectrumModel::where('is_active',1)->where('id',$spectrumid)->first();
	  
 	if(isset($obj_spectrum) && !empty($obj_spectrum))
 	{
 		$spectrumarr = $obj_spectrum->toArray();
 		
 	}
 	return $spectrumarr;
}//end

 function get_product_name($productid)
 {
 	 $get_product_name = '';
 	 $productname = ProductModel::where('id',$productid)->select('product_name')->first();
 	 if(isset($productname) && !empty($productname))
 	 {
 	 	$get_product_name = isset($productname['product_name'])?$productname['product_name']:'';
 	 	
 	 }
 	 return $get_product_name;
 }//end



function get_buyer_restricted_sellers()
{
	     $returndata =[];		

	     $country  = '';
         $state  = '';
         $state_user_ids='';
         $catdata =[];
         $login_user = Sentinel::check();  
         if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true)
         {
               $country  = $login_user->country;
               $state  = $login_user->state;
              
         }//else if user is buyer
         
        if(isset($state) && !empty($state) && isset($country) && !empty($country))
        { 
          
                $category_ids='';
                $get_state = StatesModel::where('id',$state)->where('is_active','1')->where('country_id',$country)->first();
                if(isset($get_state) && !empty($get_state))
                {
                    $get_state = $get_state->toArray();
                    $is_buyer_restricted = $get_state['is_buyer_restricted'];

                    if(isset($is_buyer_restricted) && $is_buyer_restricted==1)
                    {
                    		$getusers_ofstate = UserModel::select('id')->where('state',$state)->where('user_type','seller')->where('is_active','1')->get();
			                if(isset($getusers_ofstate) && !empty($getusers_ofstate))
			                {

			                   $getusers_ofstate = $getusers_ofstate->toArray();
			                   $state_user_ids =  array_values($getusers_ofstate);

			                }//if getusersofstate
                    }
           
               }//if getstate
              
        } // if ipstate

        $returndata['restricted_state_user_ids'] = isset($state_user_ids)?$state_user_ids:[];
        return $returndata;

}//check_buyer_restricted




function is_buyer_restricted_forstate()
{
		 $is_buyer_restricted =0;
	     $returndata =[];		

	     $country  = '';
         $state  = '';
         $state_user_ids='';
         $login_user = Sentinel::check();  
         if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true)
         {
               $country  = $login_user->country;
               $state  = $login_user->state;
              
         }//else if user is buyer
         
        if(isset($state) && !empty($state) && isset($country) && !empty($country))
        { 
          
                $category_ids='';
                $get_state = StatesModel::where('id',$state)->where('is_active','1')->where('country_id',$country)->first();
                if(isset($get_state) && !empty($get_state))
                {
                    $get_state = $get_state->toArray();
                    $is_buyer_restricted = $get_state['is_buyer_restricted'];
                }
         }
         return $is_buyer_restricted;
 }//check is buyer is restricted for state


function check_is_category_exists($catid="")
{

	  $categorydata =[];
	  $getcategory = FirstLevelCategoryModel::where('id',base64_decode($catid))->first(); 
      if(isset($getcategory) && !empty($getcategory))
      {
     
      	$categorydata = $getcategory->toArray();
      	 	
      }
      return $categorydata; 	
}//check_is_category_exists

function check_is_category_exists_by_name($cat_name="")
{

	  $categorydata =[];

	  $category_name = str_replace('-and-','-&-',$cat_name);             
		$category_name = str_replace('-',' ',$category_name); 
	  $getcategory = FirstLevelCategoryModel::where('product_type',$category_name)->first(); 
      if(isset($getcategory) && !empty($getcategory))
      {
     
      	$categorydata = $getcategory->toArray();
      	 	
      }
      return $categorydata; 	
}//check_is_category_exists

function get_top_reported_effects($productid=NULL)
{
   $get_effects = $allemoji = $allemojiarr  = $arr_count = [];
   $get_effects = DB::table('product_rating_review')->where('product_id',$productid)
                ->where('emoji','!=','')->get();

  // $get_effects = ReviewRatingsModel::where('product_id',$productid)->select('emoji')->get();
   if(isset($get_effects) && !empty($get_effects))
   {	
     $get_effects = $get_effects->toArray();
   
   	  $allemojiarr = [];
            
            foreach($get_effects as $kk=>$vv)
            {
            
               $allemoji =  explode(",",$vv->emoji);
               if(isset($allemoji) && !empty($allemoji)){
              	 foreach($allemoji as $k1=>$v1)
               	 {
                    $allemojiarr[] = $v1;
                  }
              }//isset all emoji

            }//foreach
   }//if get effects	
   		

   if(isset($allemojiarr))
   {	
   	 $arr_count = array_count_values(array_filter($allemojiarr));

   	 arsort($arr_count);

   }
  return $arr_count;

}//get top_reported_effects



function get_countryDetails($countryid=false)
{	  $getcountry ='';
	  $getcountry = CountriesModel::where('id',$countryid)->first(); 
      if(isset($getcountry) && !empty($getcountry))
      {
      	$getcountry = $getcountry->toArray();
      }
      return $getcountry; 
}

function check_seller_deliveryoption($seller_id=false)
{
	$deliveryoption = [];
	if(isset($seller_id) && !empty($seller_id))
	{
		$check = DeliveryOptionsModel::where('seller_id',$seller_id)->where('status','1')->get();
		
		if(isset($check) && !empty($check))
		{	
			$deliveryoption = $check->toArray();
			if(isset($deliveryoption) && !empty($deliveryoption))
		    {	
			  return 1;
		    }else
		    {
		    	return 0;
		    }
		}//if
		else{
			$deliveryoption = [];
			return 0;
		}
	}
	
}//end


function get_seller_deliver_options($seller_id=false,$option=false)
{
	$deliveryoption = [];
	if(isset($seller_id) && !empty($seller_id))
	{
		$check = DeliveryOptionsModel::where('seller_id',$seller_id)->where('id',$option)->where('status','1')->first();
		
		if(isset($check) && !empty($check))
		{	
			$deliveryoption = $check->toArray();
			
		}//if
		
	}

	return $deliveryoption;
	
}//end get_seller_deliver_options


function get_deliveryoptiondata_order($orderno=NULL,$orderid=NULL)
{	

	$delivery_option_data = [];

	if(isset($orderno) && isset($orderid) && !empty($orderno)  && !empty($orderid))
	{
		$getorder= OrderModel::where('order_no',$orderno)->where('id',$orderid)->first();
		if(isset($getorder) && !empty($getorder))
		{
			   $getorder = $getorder->toArray();


			  $title = isset($getorder['delivery_title'])?$getorder['delivery_title']:'';
              $cost = isset($getorder['delivery_cost'])?$getorder['delivery_cost']:'';
              $day = isset($getorder['delivery_day'])?$getorder['delivery_day']:'';
              $sellername = get_seller_details($getorder['seller_id']);
              $delivery_option_data[$getorder['seller_id']]['title'] = $title;
              $delivery_option_data[$getorder['seller_id']]['cost'] = $cost;
              $delivery_option_data[$getorder['seller_id']]['day'] = $day;
              $delivery_option_data[$getorder['seller_id']]['sellername'] = $sellername;

              //echo "<pre>";print_r($coupondata);

		}	

	}
	else
	{
		$getorder= OrderModel::where('order_no',$orderno)->get();
		if(isset($getorder) && !empty($getorder))
		{
			   $getorder = $getorder->toArray();

			  

			   foreach($getorder as $kk=>$vv)
			   {
			   		$title = isset($vv['delivery_title'])?$vv['delivery_title']:'';
              		$cost = isset($vv['delivery_cost'])?$vv['delivery_cost']:'';
             	    $day = isset($vv['delivery_day'])?$vv['delivery_day']:'';
              		$sellername = get_seller_details($vv['seller_id']);

              		  $delivery_option_data[$vv['seller_id']]['title'] = $title;
		              $delivery_option_data[$vv['seller_id']]['cost'] = $cost;
		              $delivery_option_data[$vv['seller_id']]['day'] = $day;
		              $delivery_option_data[$vv['seller_id']]['sellername'] = $sellername;
			   }


		}	
	}//else


	return $delivery_option_data;
}//function get_deliveryoptiondata_order





function get_deliverycost_fromorderno($orderno=NULL)
{	

	$delivery_cost_title = [];
	$totalcost = 0;

	if(isset($orderno) && !empty($orderno))
	{
		

	    $getorder= OrderModel::where('order_no',$orderno)->get();
	   
		if(isset($getorder) && !empty($getorder))
		{
			   $getorder = $getorder->toArray();

			  

			   foreach($getorder as $kk=>$vv)
			   {
			   		$title = isset($vv['delivery_title'])?$vv['delivery_title']:'';
              		$cost = isset($vv['delivery_cost'])?$vv['delivery_cost']:0;
             	    $day = isset($vv['delivery_day'])?$vv['delivery_day']:'';
              		$sellername = get_seller_details($vv['seller_id']);

		            $totalcost  = $totalcost + $cost;
		            
			   }


		}	
	}//else


	return $totalcost;
}//function get_deliveryoptiondata_order



	
function get_announcements()
{	

	$arr_announcements = [];

    $announcements_obj = AnnouncementsModel::select(
    										'id',
    										'title',
    										'title_color',
    										'background_color',
    										'title_url_color',
    										'background_url'
											)
    										->where('is_active','1')
    										->get();
   		
	if(isset($announcements_obj) && !empty($announcements_obj))
	{
		$arr_announcements = $announcements_obj->toArray();
	}	
	
	return $arr_announcements;
}


function get_category_faqs($category_id=NULL)
{	

	$arr_category_faq = [];

	if(isset($category_id) && !empty($category_id))
	{
		
		$category_name = str_replace('-and-','-&-',$category_id);             
		$category_name = str_replace('-',' ',$category_name); 
		$getcategory = FirstLevelCategoryModel::where('product_type',$category_name)->first(); 
	    
	    if(isset($getcategory) && !empty($getcategory))
		{	
			$getcategory = $getcategory->toArray();
		    $get_faq_list= FirstLevelCategoryFaqModel::where('category_id',$getcategory['id'])->where('is_active',1)->get();
			if(isset($get_faq_list) && !empty($get_faq_list))
			{
			   	$arr_category_faq = $get_faq_list->toArray();

			}	
		}
	}//else


	return $arr_category_faq;
}




function parse_to_plain_text($content=NULL)
{	
	$plain_text = '';
	$plain_text = str_replace(
						['"','&#34;','&#39;','&#65287;','&#65282;'],
						'\'',
						html_entity_decode(
							strip_tags(
								$content
							)
						)
					);
	return $plain_text;
}

function isMobileDevice()
 {

     //  $useragent = $_SERVER["HTTP_USER_AGENT"];
        $is_mobile_device = '';
       
       if(isset($_SERVER["HTTP_USER_AGENT"]) && !empty($_SERVER["HTTP_USER_AGENT"]))
       {
            $is_mobile_device =  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
            if($is_mobile_device)
            {   
                return 1;
            }else{
                return 0;
            }
       }else{
         return 0;
       }

 } //is mobile device

 function get_no_of_ratings_count($product_id = '')
{

	$review_count = 0;
	if($product_id)
	{
		$review_count  =  \App\Models\ReviewRatingsModel::where('product_id',$product_id)
													 ->count();
													 
		$admin_product_review = ProductModel::where('id',$product_id)->pluck('avg_review')->first();	

	    if(isset($admin_product_review))
	    {
	       $review_count = $admin_product_review + $review_count;	
	    }
	    else
	    {
	    	$review_count = $review_count; 
	    }											 


													 
	}
	return $review_count; 
}// get_no_of_ratings_count


function get_seller_restricted_categories()
{
	     $returndata =[];		

	     $country  = '';
         $state  = '';
         $state_user_ids='';
         $catdata =[];
         $login_user = Sentinel::check();  
         if(isset($login_user) && $login_user==true && $login_user->inRole('seller') == true)
         {
               $country  = $login_user->country;
               $state  = $login_user->state;


              
         }//else if user is buyer
         
        if(isset($state) && !empty($state) && isset($country) && !empty($country))
        { 
          
                $category_ids='';
                $get_state = StatesModel::where('id',$state)->where('is_active','1')->where('country_id',$country)->first();
                if(isset($get_state) && !empty($get_state))
                {
                    $get_state = $get_state->toArray();
                    $category_ids = $get_state['category_ids'];
           
               }//if getstate
              
        } // if ipstate

        $returndata['restricted_state_category_ids'] = isset($category_ids)?$category_ids:[];
        return $returndata;

}//get_seller_restricted_categories

function get_buyer_referal_code()
{
	 $referalcode='';
	 $user_details =  Sentinel::check();
	 if(isset($user_details) && $user_details==true && !empty($user_details))
	 {
	      $buyr_id = $user_details->id;
	      $referalcode = $user_details->referal_code;
	 }      
	 return $referalcode;

}//get_buyer_referal_code

function get_buyer_referal_amount_details()
{    
	  $buyer_referal_amount ='';
	  $site_setting_arr = [];

	  $site_setting_obj = SiteSettingModel::first();  

	  if(isset($site_setting_obj))
	  {
	    $site_setting_arr = $site_setting_obj->toArray();            
	  }
	  if(isset($site_setting_arr) && count($site_setting_arr)>0)
      {
      	   $buyer_referal_amount = isset($site_setting_arr['buyer_referal_amount'])?$site_setting_arr['buyer_referal_amount']:config('app.project.buyer_referal');
      }
      return $buyer_referal_amount;
}//get_buyer_referal_amount_details

function get_price($product_id)
{
	$product_arr = [];

	if(isset($product_id) && $product_id!='')
	{
		$product_obj = ProductModel::where('id',$product_id)->first();

        if(isset($product_obj))
        {
          $product_arr = $product_obj->toArray();
        }

	    if(isset($product_arr['price_drop_to']) && $product_arr['price_drop_to']!='' && $product_arr['price_drop_to']!= 0)
        {
            $product_price = $product_arr['price_drop_to'];
        }
        else
        {
           $product_price = $product_arr['unit_price'];
        }

         return $product_price;
	}

	return false;
}



function get_seller_address_details($sellerid=false)
{
	$seller_info =[];
 	$obj_seller = UserModel::where('id',$sellerid)->with('seller_detail')->first();

 	if(isset($obj_seller) && !empty($obj_seller))
 	{	
        $obj_seller = $obj_seller->toArray();		        	
 		if(isset($obj_seller['seller_detail']) && !empty($obj_seller['seller_detail']))
 		{
 			$seller_info = $obj_seller;
 		}

  		return $seller_info;
 	} //if isset
}//end function

//get country name
function get_iso_country($id)
{
    $country_name = CountriesModel::where('id',$id)->pluck('sortname')->first();

    return $country_name;
}//end

//get country name
function get_iso_state($id)
{
	$state_name ='';
    $state_name = StatesModel::where('id',$id)->pluck('shortname')->first();
    return $state_name;
}//end

    function convert_state_to_abbreviation($state_name) {
    switch ($state_name) {
      case "Alabama":
        return "AL";
        break;
      case "Alaska":
        return "AK";
        break;
      case "Arizona":
        return "AZ";
        break;
      case "Arkansas":
        return "AR";
        break;
      case "California":
        return "CA";
        break;
      case "Colorado":
        return "CO";
        break;
      case "Connecticut":
        return "CT";
        break;
      case "Delaware":
        return "DE";
        break;
      case "Florida":
        return "FL";
        break;
      case "Georgia":
        return "GA";
        break;
      case "Hawaii":
        return "HI";
        break;
      case "Idaho":
        return "ID";
        break;
      case "Illinois":
        return "IL";
        break;
      case "Indiana":
        return "IN";
        break;
      case "Iowa":
        return "IA";
        break;
      case "Kansas":
        return "KS";
        break;
      case "Kentucky":
        return "KY";
        break;
      case "Louisana":
        return "LA";
        break;
      case "Maine":
        return "ME";
        break;
      case "Maryland":
        return "MD";
        break;
      case "Massachusetts":
        return "MA";
        break;
      case "Michigan":
        return "MI";
        break;
      case "Minnesota":
        return "MN";
        break;
      case "Mississippi":
        return "MS";
        break;
      case "Missouri":
        return "MO";
        break;
      case "Montana":
        return "MT";
        break;
      case "Nebraska":
        return "NE";
        break;
      case "Nevada":
        return "NV";
        break;
      case "New Hampshire":
        return "NH";
        break;
      case "New Jersey":
        return "NJ";
        break;
      case "New Mexico":
        return "NM";
        break;
      case "New York":
        return "NY";
        break;
      case "North Carolina":
        return "NC";
        break;
      case "North Dakota":
        return "ND";
        break;
      case "Ohio":
        return "OH";
        break;
      case "Oklahoma":
        return "OK";
        break;
      case "Oregon":
        return "OR";
        break;
      case "Pennsylvania":
        return "PA";
        break;
      case "Rhode Island":
        return "RI";
        break;
      case "South Carolina":
        return "SC";
        break;
      case "South Dakota":
        return "SD";
        break;
      case "Tennessee":
        return "TN";
        break;
      case "Texas":
        return "TX";
        break;
      case "Utah":
        return "UT";
        break;
      case "Vermont":
        return "VT";
        break;
      case "Virginia":
        return "VA";
        break;
      case "Washington":
        return "WA";
        break;
      case "Washington D.C.":
        return "DC";
        break;
      case "West Virginia":
        return "WV";
        break;
      case "Wisconsin":
        return "WI";
        break;
      case "Wyoming":
        return "WY";
        break;
      case "Alberta":
        return "AB";
        break;
      case "British Columbia":
        return "BC";
        break;
      case "Manitoba":
        return "MB";
        break;
      case "New Brunswick":
        return "NB";
        break;
      case "Newfoundland & Labrador":
        return "NL";
        break;
      case "Northwest Territories":
        return "NT";
        break;
      case "Nova Scotia":
        return "NS";
        break;
      case "Nunavut":
        return "NU";
        break;
      case "Ontario":
        return "ON";
        break;
      case "Prince Edward Island":
        return "PE";
        break;
      case "Quebec":
        return "QC";
        break;
      case "Saskatchewan":
        return "SK";
        break;
      case "Yukon Territory":
        return "YT";
        break;
      default:
        return $state_name;
    }
  }//end

function calculate_tax($seller_wise_total_order_amountarr=[])
{	
    $tax_api_key ='6c10498ae1c7900d788c01b3669729c6';
    $API_URL = 'https://api.sandbox.taxjar.com';

    $site_setting_arr = [];

    $site_setting_obj = SiteSettingModel::first();  

    if(isset($site_setting_obj))
    {
        $site_setting_arr = $site_setting_obj->toArray();            
    }

	 if(isset($site_setting_arr) && count($site_setting_arr)>0)
	 {
		 $payment_mode = $site_setting_arr['payment_mode'];
		 $sandbox_tax_api_key = $site_setting_arr['sandbox_tax_api_key'];
	     $sandbox_tax_url = $site_setting_arr['sandbox_tax_url'];
	     $live_tax_api_key = $site_setting_arr['live_tax_api_key'];
	     $live_tax_url = $site_setting_arr['live_tax_url'];  

	     if(isset($payment_mode) && $payment_mode=='0')
	     {
	     	 if(isset($sandbox_tax_api_key) && !empty($sandbox_tax_api_key))
	     	 {
	     	 	 $tax_api_key = $sandbox_tax_api_key;
	     	 }
	     	  if(isset($sandbox_tax_url) && !empty($sandbox_tax_url))
	     	 {
	     	 	 $API_URL = $sandbox_tax_url;
	     	 }

	     }
	      if(isset($payment_mode) && $payment_mode=='1')
	     {
	     	 if(isset($live_tax_api_key) && !empty($live_tax_api_key))
	     	 {
	     	 	 $tax_api_key = $live_tax_api_key;
	     	 }
	     	  if(isset($live_tax_url) && !empty($live_tax_url))
	     	 {
	     	 	 $API_URL = $live_tax_url;
	     	 }

	     }
	 
     }


	 // $sandbox_API_URL = 'https://api.sandbox.taxjar.com';
     // $client = Client::withApiKey('6c10498ae1c7900d788c01b3669729c6');
     // $client->setApiConfig('api_url',Client::SANDBOX_API_URL);
     //  $client->setApiConfig('api_url',$sandbox_API_URL);

       $client = Client::withApiKey($tax_api_key);
       $client->setApiConfig('api_url',$API_URL);

	$tax =0; $customerrmsg = '';
	$arr_responce = [];
	//dd($seller_wise_total_order_amountarr);

	foreach($seller_wise_total_order_amountarr as $k=>$v)
	{
	  $seller_wise_total_order_amount = $v;

	  $sellername = isset($seller_wise_total_order_amount['sellername'])?$seller_wise_total_order_amount['sellername']:'';
	  try {

      // Invalid request
      $order = $client->taxForOrder([

       
        'from_country' => isset($seller_wise_total_order_amount['from_country'])? $seller_wise_total_order_amount['from_country']:'',
        'from_zip' => isset($seller_wise_total_order_amount['from_zip'])?$seller_wise_total_order_amount['from_zip']:'',
        'from_state' =>  isset($seller_wise_total_order_amount['from_state'])? 
        $seller_wise_total_order_amount['from_state']:'',
        'from_city' => isset($seller_wise_total_order_amount['from_city'])? $seller_wise_total_order_amount['from_city']:'',
        'from_street' => isset($seller_wise_total_order_amount['from_street'])?
                    $seller_wise_total_order_amount['from_street']:'',
        'to_country' => isset($seller_wise_total_order_amount['to_country'])? $seller_wise_total_order_amount['to_country']:'',
        'to_zip' => isset($seller_wise_total_order_amount['to_zip'])? $seller_wise_total_order_amount['to_zip']:'',
        'to_state' => isset($seller_wise_total_order_amount['to_state'])? $seller_wise_total_order_amount['to_state']:'',
        'to_city' => isset($seller_wise_total_order_amount['to_city'])? $seller_wise_total_order_amount['to_city']:'',
        'to_street' => isset($seller_wise_total_order_amount['to_street'])? $seller_wise_total_order_amount['to_street']:'',
        'amount' => isset($seller_wise_total_order_amount['amount'])?$seller_wise_total_order_amount['amount']:0,
        'shipping' => isset($seller_wise_total_order_amount['shipping'])?$seller_wise_total_order_amount['shipping']:0

         // "to_city"=> "Kansas City",
         //  "to_state"=> "MO",
         //  "to_zip"=> "64155",
         //  "to_country"=> "US",
         //  "from_city"=> "Philadelphia",
         //  "from_state"=> "PA",
         //  "from_zip"=> "19147",
         //  "from_country"=> "US",
         //  "amount"=> '29.94',
         //  "shipping"=> '7.99'
       
      ]);

      if(isset($order))
      {
         $tax =  $order->amount_to_collect;
         $arr_responce['tax'] = $tax;
         $arr_responce['status'] = 'success';
         $arr_responce['message'] = '';
      }

    } catch (\Exception $e) {

      //dd($e->getStatusCode());
    //  dd($e->getMessage());
    	$customerrmsg = '';
    	if($e->getMessage())
    	{
    		$errmsg = explode("400 Bad Request –", $e->getMessage());
    		//dd($errmsg);
    		if(is_array($errmsg))
    		{
    			 $customerrmsg = isset($errmsg[1])?str_replace('to_zip','Buyer zipcode',$errmsg[1]):'';
    			 $customerrmsg = str_replace('to_state','state',$customerrmsg);
    			 $customerrmsg = str_replace('To zip','Buyer zipcode',$customerrmsg);
    			 $customerrmsg = str_replace('From zip','Dispensary '.$sellername.' zipcode',$customerrmsg);
    			 $customerrmsg = str_replace('from_zip','Dispensary '.$sellername.' zipcode',$customerrmsg);
    			 $customerrmsg = str_replace('from_state','Dispensary '.$sellername.' state',$customerrmsg);

    		}
    		else
    		{
    			 $customerrmsg = $e->getMessage();
    		}
    		
    	}

       $arr_responce['tax'] = '';
       $arr_responce['status'] = 'error';
       $arr_responce['message'] = $customerrmsg;
    
    }
  }//foreach
   //  dd($arr_responce);
    return $arr_responce;
}//end calculate tax


function calculate_tax_getting_details($seller_id,$buyer_id,$amount,$shipping)
{

	//echo "===".$seller_id."----".$buyer_id."----".$amount.'--'.$shipping;

	$return_tax = 0;

	  // $sANDBOX_API_URL = 'https://api.sandbox.taxjar.com';
   //    $client = Client::withApiKey('6c10498ae1c7900d788c01b3669729c6');
   //    $client->setApiConfig('api_url',Client::SANDBOX_API_URL);

    $tax_api_key ='6c10498ae1c7900d788c01b3669729c6';
    $API_URL = 'https://api.sandbox.taxjar.com';
    
    $site_setting_arr = [];

    $site_setting_obj = SiteSettingModel::first();  

    if(isset($site_setting_obj))
    {
        $site_setting_arr = $site_setting_obj->toArray();            
    }

	 if(isset($site_setting_arr) && count($site_setting_arr)>0)
	 {
		 $payment_mode = $site_setting_arr['payment_mode'];
		 $sandbox_tax_api_key = $site_setting_arr['sandbox_tax_api_key'];
	     $sandbox_tax_url = $site_setting_arr['sandbox_tax_url'];
	     $live_tax_api_key = $site_setting_arr['live_tax_api_key'];
	     $live_tax_url = $site_setting_arr['live_tax_url'];  

	     if(isset($payment_mode) && $payment_mode=='0')
	     {
	     	 if(isset($sandbox_tax_api_key) && !empty($sandbox_tax_api_key))
	     	 {
	     	 	 $tax_api_key = $sandbox_tax_api_key;
	     	 }
	     	  if(isset($sandbox_tax_url) && !empty($sandbox_tax_url))
	     	 {
	     	 	 $API_URL = $sandbox_tax_url;
	     	 }

	     }
	      if(isset($payment_mode) && $payment_mode=='1')
	     {
	     	 if(isset($live_tax_api_key) && !empty($live_tax_api_key))
	     	 {
	     	 	 $tax_api_key = $live_tax_api_key;
	     	 }
	     	  if(isset($live_tax_url) && !empty($live_tax_url))
	     	 {
	     	 	 $API_URL = $live_tax_url;
	     	 }

	     }
	 
     }// site_setting_arr


      // $sANDBOX_API_URL = 'https://api.sandbox.taxjar.com';
       $client = Client::withApiKey($tax_api_key);
       $client->setApiConfig('api_url',$API_URL);

	if(isset($seller_id) && isset($buyer_id) && isset($amount) && (isset($shipping) || $shipping>='0'))
	{	
		  $buyer_address = get_buyer_details($buyer_id);

          $to_country = isset($buyer_address['country'])? get_iso_country($buyer_address['country']):'';
          $to_zip = isset($buyer_address['zipcode'])? $buyer_address['zipcode']:'';
          $to_city = isset($buyer_address['city'])? $buyer_address['city']:'';
          $to_state= isset($buyer_address['state'])? get_iso_state($buyer_address['state']):'';
          $to_street = isset($buyer_address['street_address'])? $buyer_address['street_address']:'';


            $seller_address = get_seller_address_details($seller_id); 

	        $from_country = isset($seller_address['country'])? get_iso_country($seller_address['country']):'';
	        $from_zip = isset($seller_address['zipcode'])? $seller_address['zipcode']:'';
	        $from_city = isset($seller_address['city'])? $seller_address['city']:'';
	        $from_state = isset($seller_address['state'])? get_iso_state($seller_address['state']):'';
	        $from_street = isset($seller_address['street_address'])? $seller_address['street_address']:'';
	       
	          // try {
			      // Invalid request
			         $order = $client->taxForOrder([
			       
			        'from_country' => isset($from_country)? $from_country:'',
			        'from_zip' => isset($from_zip)?$from_zip:'',
			        'from_state' =>  isset($from_state)? $from_state:'',
			        'from_city' => isset($from_city)? $from_city:'',
			        'from_street' => isset($from_street)? $from_street:'',
			        'to_country' => isset($to_country)? $to_country:'',
			        'to_zip' => isset($to_zip)? $to_zip:'',
			        'to_state' => isset($to_state)? $to_state:'',
			        'to_city' => isset($to_city)? $to_city:'',
			        'to_street' => isset($to_street)? $to_street:'',
			        'amount' => isset($amount)?$amount:0,
			        'shipping' => isset($shipping)?$shipping:0

		       
			        ]);

			         $return_tax =  $order->amount_to_collect; 	

			    // } catch (\Exception $e) {			   
				    	
				// }	
	}//if isset	

	return $return_tax;
}//calculate tax getting details



function get_taxdata_order($orderno=NULL,$orderid=NULL)
{	

	$tax_data = [];

	if(isset($orderno) && isset($orderid) && !empty($orderno)  && !empty($orderid))
	{
		$getorder= OrderModel::where('order_no',$orderno)->where('id',$orderid)->first();
		if(isset($getorder) && !empty($getorder))
		{
			   $getorder = $getorder->toArray();


			  $tax = isset($getorder['tax'])?$getorder['tax']:'';
              $sellername = get_seller_details($getorder['seller_id']);
              $tax_data[$getorder['seller_id']]['tax'] = $tax;
              $tax_data[$getorder['seller_id']]['sellername'] = $sellername;

              //echo "<pre>";print_r($coupondata);

		}	

	}
	else
	{
		$getorder= OrderModel::where('order_no',$orderno)->get();
		if(isset($getorder) && !empty($getorder))
		{
			   $getorder = $getorder->toArray();

			  

			   foreach($getorder as $kk=>$vv)
			   {
			   		$tax = isset($vv['tax'])?$vv['tax']:'';
              		$sellername = get_seller_details($vv['seller_id']);

              		  $tax_data[$vv['seller_id']]['tax'] = $tax;
		              $tax_data[$vv['seller_id']]['sellername'] = $sellername;
			   }


		}	
	}//else


	return $tax_data;
}//function get_deliveryoptiondata_order




function get_taxcost_fromorderno($orderno=NULL)
{	

	$delivery_cost_title = [];
	$totalcost = 0;

	if(isset($orderno) && !empty($orderno))
	{
		

	    $getorder= OrderModel::where('order_no',$orderno)->get();
	   
		if(isset($getorder) && !empty($getorder))
		{
			   $getorder = $getorder->toArray();

			  

			   foreach($getorder as $kk=>$vv)
			   {
              		$cost = isset($vv['tax'])?$vv['tax']:0;
              		$sellername = get_seller_details($vv['seller_id']);

		            $totalcost  = $totalcost + $cost;
		            
			   }


		}	
	}//else


	return $totalcost;
}//function get_taxcost_fromorderno



//get country name
function get_country_id($countryname)
{
    $country_id = CountriesModel::where('id',$id)->pluck('id')->first();

    return $country_id;
}//end

     

function get_product_request_status($product_id)
{
    $request_arr = [];   
	$user_id = $status = '';

    $user = \Sentinel::check();

    if($user)
    {
       $user_id = $user->id; 
    } 

    $request_obj = MoneyBackModel::where('buyer_id',$user_id)
                   ->where('product_id',$product_id)
                   ->select('status','note')
                   ->first();
    
    if(isset($request_obj))
    {
       $request_arr = $request_obj->toArray();
    }
   
    return $request_arr;               
}


function get_buyer_wallet_total($userid=NULL)
{
	$total_amount =0;
	if(isset($userid))
	{
		$get_wallet_total = BuyerWalletModel::where('user_id',$userid)->sum('amount');
		if(isset($get_wallet_total) && !empty($get_wallet_total))
		{
			$total_amount = $get_wallet_total;
		}
		return $total_amount;
	}
	
}//get_buyer_wallet_total

function get_wallet_amountused_fororder($userid=NULL,$orderno=NULL)
{
	$get_wallet_amount_used = [];
	$total_amount =0;
	if(isset($userid) && isset($orderno))
	{
		$get_wallet_amount_used = BuyerWalletModel::where('user_id',$userid)->where('type','OrderPlaced')->where('typeid',$orderno)->first();
		if(isset($get_wallet_amount_used) && !empty($get_wallet_amount_used))
		{
			$get_wallet_amount_used= $get_wallet_amount_used->toArray() ;
			$total_amount = str_replace('-','',$get_wallet_amount_used['amount']);
		}
	}
  return $total_amount;

	
}//get_wallet_amountused_fororder

function get_buyer_refered_amount_details()
{    
	  $buyer_refered_amount ='';
	  $site_setting_arr = [];

	  $site_setting_obj = SiteSettingModel::first();  

	  if(isset($site_setting_obj))
	  {
	    $site_setting_arr = $site_setting_obj->toArray();            
	  }
	  if(isset($site_setting_arr) && count($site_setting_arr)>0)
      {
      	   $buyer_refered_amount = isset($site_setting_arr['buyer_refered_amount'])?$site_setting_arr['buyer_refered_amount']:config('app.project.buyer_refered');
      }
      return $buyer_refered_amount;
}//get_buyer_referal_amount_details

function get_buyer_name($buyer_id=false)
{
	$buyer_name ='';
 	$obj_buyer = UserModel::where('id',$buyer_id)->first();
 	if(isset($obj_buyer))
 	{
  		$buyer_name = $obj_buyer['first_name'].' '.$obj_buyer['last_name'];

  		return $buyer_name;
 	}
}

function get_buyer_wallet_amount($loginuser=false)
{
	$remain_wallet_amount ='';
	$remain_wallet_amount = BuyerWalletModel::where('user_id',$loginuser)
                                ->sum('amount');

    if(isset($remain_wallet_amount) && !empty($remain_wallet_amount))
    {
         $remain_wallet_amount = num_format($remain_wallet_amount);
    }
    return $remain_wallet_amount;
}//get_buyer_wallet_amount

function get_seller_restricted_category_admin($seller_id)
{
	     $returndata =[];		

	     $country  = '';
         $state  = '';
         $state_user_ids='';
         $catdata =[];
        
         if(isset($seller_id) && !empty($seller_id))
         {
         	   $get_country_state = UserModel::where('id',$seller_id)->first();
         	   if(isset($get_country_state) && !empty($get_country_state))
         	   {
         	   		$country  = $get_country_state->country;
                    $state  = $get_country_state->state;
         	   }
               


              
         }//else if user is buyer
         
        if(isset($state) && !empty($state) && isset($country) && !empty($country))
        { 
          
                $category_ids='';
                $get_state = StatesModel::where('id',$state)->where('is_active','1')->where('country_id',$country)->first();
                if(isset($get_state) && !empty($get_state))
                {
                    $get_state = $get_state->toArray();
                    $category_ids = $get_state['category_ids'];
           
               }//if getstate
              
        } // if ipstate

        $returndata['restricted_state_category_ids'] = isset($category_ids)?$category_ids:[];
        return $returndata;

}//get_seller_restricted_categories


function get_coupon_details($user_id)
{
	$coupon_arr = [];

    $coupon_details_obj = CouponModel::where('user_id',$user_id)
                                     ->where('coupon_availability_status',1)
                                     ->get();

    if($coupon_details_obj)
    {
    	$coupon_arr = $coupon_details_obj->toArray();
    }
 
    return $coupon_arr;

}


//this function for get the banner images
function get_banner_images()
{
    $get_banner_images = [];
    
    $get_banner_images = BannerImagesModel::first();
   
    if(isset($get_banner_images) && !empty($get_banner_images))
    {
      $get_banner_images = $get_banner_images->toArray();
    }
     
    return $get_banner_images;

}

?>