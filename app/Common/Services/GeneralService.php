<?php
namespace App\Common\Services;

//use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;

use App\Models\UserModel;
use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Models\ShippingAddressModel;

use App\Models\RoleModel;
use App\Models\RoleUsersModel;

use App\Models\EmailTemplateModel;

use App\Common\Services\EmailService;


use Mail;
use Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Events\NotificationEvent;
use Session, Sentinel, DB,Storage;

class GeneralService
{
	public function __construct(
									//CountryModel $CountryModel,
									StateModel $StateModel,
									CityModel $CityModel,
                                    EmailService $EmailService,
									
									BuyerModel $BuyerModel,
									ShippingAddressModel $ShippingAddressModel,
									
									SellerModel $SellerModel,
									EmailTemplateModel $EmailTemplateModel,
									UserModel $UserModel
								)
	{
		//$this->CountryModel                    = $CountryModel;
		$this->UserModel 					   = $UserModel;
		$this->BuyerModel                      = $BuyerModel;
		$this->SellerModel                     = $SellerModel;		
		$this->EmailTemplateModel			   = $EmailTemplateModel;		
        $this->EmailService                    = $EmailService;
        $this->ShippingAddressModel            = $ShippingAddressModel;
        
	}
	

	/************************Notification Event START**************************/

    public function save_notification($ARR_DATA = [])
    {  
        if(isset($ARR_DATA) && sizeof($ARR_DATA)>0)
        {
            $ARR_EVENT_DATA                 = [];
            $ARR_EVENT_DATA['from_user_id'] = $ARR_DATA['from_user_id'];
            $ARR_EVENT_DATA['to_user_id']   = $ARR_DATA['to_user_id'];
            $ARR_EVENT_DATA['message']      = $ARR_DATA['description'];
            $ARR_EVENT_DATA['title']        = $ARR_DATA['title'];
           	$ARR_EVENT_DATA['type']         = $ARR_DATA['type'];
           	$ARR_EVENT_DATA['status']       = isset($ARR_DATA['status'])?$ARR_DATA['status']:'0';	

            event(new NotificationEvent($ARR_EVENT_DATA));

            return true;
        }
        return false;
    }

    /************************Notification Event END  **************************/

    public function is_profile_complete($user_arr=[])
    {
    	$user_arr = $user_arr->toArray();
    	
	    if(count($user_arr)>0 && isset($user_arr))
	    {
	    	

	    	if(count($user_arr)>0)
	    	{
		    	if($user = Sentinel::findById($user_arr['id']))
		    	{
		    	   if($user->inRole('seller'))
		    	    {
		    			$seller_data = $this->SellerModel->where('user_id','=',$user_arr['id'])->first();
		    	        
		    	         
		    	        if(empty($seller_data['business_name'])||empty($seller_data['tax_id'])||empty($seller_data['id_proof']))
		    	  		{   
		    	  			
		    	  			return 'business_profile';
		    	  		}
		    	  		elseif ($user_arr['country'] == null) 
		    	  		{
		    	  			
		    	  			return 'account_setting';
		    	  		}
		    	  		else
		    	  		{   
		    	  			
		    				return true;
		    	  		} 
		    	    }
		    	    elseif($user->inRole('buyer'))
		    	    {
		    			if(isset($user_arr['id']) && $user_arr['id']!='')
		    			{		
		    			    //$buyer_data = $this->ShippingAddressModel->where('user_id','=',$user_arr['id'])->first();
		    				
		    			
		    			    if(empty($user_arr['street_address'])||empty($user_arr['country'])||empty($user_arr['profile_image']))
		    		  		{     
		    		  			return false;
		    		  		}
		    		  		else
		    		  		{   
		    					return true;
		    		  		}
		    		  	} 
		    	    }
		    	}
		    	    
		    }
	    	else
	    	{   
	    		return true;
	    	} 
	    }

    }

    public function store_order_items($transaction_id,$order_addr_data)
    {
    	// dd($order_addr_data);
		
        $loggedInUserId = $quote_id = 0;
        $user = Sentinel::check();

        if($user && $user->inRole('buyer'))
        {
           $loggedInUserId = $user->id;
        }
        else
        {
        	$response_arr['status']   = 'failure';        		
        	return $response_arr;
        }       
        
        //check ip_address and user_session_id
    	$data_arr = $this->TempBagModel->where('buyer_id',$loggedInUserId)                                       
    								   ->first(['product_data']);	


            $product_data_arr = $data_arr['product_id'];
            
            $product_ids_arr  = array_column($product_data_arr, 'product_id');
            //dd($product_ids_arr);
            $product_arr = $this->ProductModel->whereIn('id',$product_ids_arr)
                               
                               ->get()->toArray();

    	
    	$bag_data  = isset($bag_data['product_data'])?$bag_data['product_data']:"";
        $bag_arr   = json_decode($bag_data,true);
       	
       	$arr_product = $bag_arr['sku'];
        	
        $result = [];

        if(isset($arr_product) && count($arr_product) > 0)
        {
        	foreach ($arr_product as $key => $value) 
	        {
	        	$result[$value['seller_id']][] = $value;
	        }
        }
        dd($result);
        try
        {
        	DB::beginTransaction();
        	if(count($result)>0)
        	{

        		$order_no = str_pad('J2',  10, rand('1234567890',10)); 
        		
        		foreach ($result as $key => $product_arr) 
		        {
		        	
		        	$total_retail_price = 0;
		        	
		        	$total_retail_price = array_sum(array_column($product_arr,'total_price'));

		        	$total_wholesale_price = array_sum(array_column($product_arr,'total_wholesale_price'));
		        	//dd($total_retail_price,$total_wholesale_price);
		        	$quotes_arr = [];
		        	$quotes_arr['seller_id']              = $key;
		        	$quotes_arr['order_no']              = $order_no;
				    $quotes_arr['retailer_id']           = $loggedInUserId;
				    $quotes_arr['status']                = 0;
				    $quotes_arr['transaction_id']        = $transaction_id or '';
				    $quotes_arr['total_retail_price']    = $total_retail_price;
				    $quotes_arr['total_wholesale_price'] = $total_wholesale_price;

				    $quotes_arr['shipping_addr']			 = $order_addr_data['shipping_addr'];
				    $quotes_arr['shipping_addr_zip_code'] = $order_addr_data['shipping_zip_code'];
				    $quotes_arr['billing_addr']			 = $order_addr_data['billing_addr'];
				    $quotes_arr['billing_addr_zip_code']	 = $order_addr_data['billing_zip_code'];

				  

		        	$create_quote = $this->OrderModel->create($quotes_arr);


		        	
		        	foreach($product_arr as $product)
		        	{ 
		        		$quote_product_arr = [];
		        		$quote_product_arr['retailer_quotes_id'] = $create_quote->id;
		        		$quote_product_arr['product_id']         = $product['product_id'];
		        		$quote_product_arr['sku_no']             = $product['sku_no'];
		        		$quote_product_arr['qty']                = $product['item_qty'];
		        		$quote_product_arr['retail_price']       = $product['retail_price'];
		        		$quote_product_arr['wholesale_price']    = $product['wholesale_price'];
		        		$quote_product_arr['description']  		 = '';
		        	
		        		$create_quote_product = $this->RetailerQuotesProductModel->create($quote_product_arr);
		        	}

		        	$quote_id = $create_quote->id;


		         /******************Notification to Admin START*******************************/

		          
		          /* Get Admin Id */

			          $admin_id = get_admin_id();

			          $first_name = isset($user->first_name)?$user->first_name:"";
			          $last_name  = isset($user->last_name)?$user->last_name:"";  

			          $arr_event                 = [];
			          $arr_event['from_user_id'] = $loggedInUserId;
			          $arr_event['to_user_id']   = $admin_id;
			          $arr_event['description']  = 'New Order Placed from '.$first_name.' '.$last_name.' . Order No : '.$order_no;
			          $arr_event['title']        = 'New Order';
			          $arr_event['type']         = 'admin'; 	

			          $this->save_notification($arr_event);

		     	 
		     	 /* send admin mail */

		     	 $this->send_mail($result,$order_no);

		     	 //send order mail to retailer
		     	 
		     	 $this->send_retailer_mail($arr_product,$order_no);

		     	 
		        }

		        $is_deleted = $this->TempBagModel->where('ip_address',$ip_address)->delete();

		    	DB::commit();
		    	$response_arr['status']   = 'success';
		    	$response_arr['quote_id'] = $quote_id;
		    	
		    	return $response_arr;
        	}
        	else
        	{	
        		$response_arr['status']   = 'failure';
        		
        		return $response_arr;
        	}

        }catch(Exception $e)
        {
        	DB::roleback();
        	$response_arr['status']   = 'failure';
        	
        	return $response_arr;
        }       
	}

	/*--------Pagination function----------------*/
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
}

?>