<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\FirstLevelCategoryModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\CountriesModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\TempBagModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderAddressModel;
use App\Models\OrderProductModel;
use App\Models\EmailTemplateModel;
use App\Models\UserModel;
use App\Models\SellerModel;
use App\Models\SendNewsletterModel;


use App\Common\Services\EmailService;

use Sentinel;
use DB;
use PDF,Storage;
use Mail;
use EmailValidation\EmailValidatorFactory;


class CommonController extends Controller
{
    //Author : Sagar B. Jadhav
    //Date   : 18 April 2019
    public function __construct(FirstLevelCategoryModel $FirstLevelCategoryModel,
    							SecondLevelCategoryModel $SecondLevelCategoryModel,
    							TempBagModel $TempBagModel,
    							ProductModel $ProductModel,
                                CountriesModel $CountriesModel,
                                StateModel $StateModel,
                                CityModel $CityModel,
                                OrderModel $OrderModel,
                                OrderAddressModel $OrderAddressModel,
                                OrderProductModel $OrderProductModel,
                                EmailTemplateModel $EmailTemplateModel,
                                UserModel $UserModel,
                                EmailService $EmailService,
                                SellerModel $SellerModel,
                                SendNewsletterModel $SendNewsletterModel
    )
    {

        $this->FirstLevelCategoryModel  = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
        $this->TempBagModel             = $TempBagModel;
        $this->ProductModel             = $ProductModel;
        $this->CountriesModel           = $CountriesModel;
        $this->StateModel               = $StateModel;
        $this->CityModel                = $CityModel;
        $this->OrderModel               = $OrderModel;
        $this->OrderAddressModel        = $OrderAddressModel; 
        $this->OrderProductModel        = $OrderProductModel; 
        $this->EmailTemplateModel       = $EmailTemplateModel;
        $this->UserModel                = $UserModel; 
        $this->EmailService             = $EmailService;
        $this->SellerModel              = $SellerModel;
        $this->SendNewsletterModel      = $SendNewsletterModel;

    }

    public function get_subcategories($category_id)
    {
    	$subcategories_arr = $this->SecondLevelCategoryModel->with(['unit_details'])
    														->where('first_level_category_id',$category_id)
                                                            ->where('is_active','1')
    														->get()->toArray();

    	if(count($subcategories_arr)>0)
    	{
    		$response['status']            = 'SUCCESS';
    		$response['subcategories_arr'] = $subcategories_arr;
    	}
    	else
    	{
    		$response['status']            = 'ERROR';
    		$response['subcategories_arr'] = [];	
    	}
        return response()->json($response);
    }

    public function get_states($country_id)
    {

        $states_arr = $this->StateModel->with(['state_translation' 
                                                /*function($q){
                                                 $q->where('locale','en')
                                                }*/
                                             ])
                                            ->where('country_id',$country_id)
                                            ->where('is_active','1')
                                            ->get()->toArray();

        if(count($states_arr)>0)
        {
            $response['status']     = 'SUCCESS';
            $response['states_arr'] = $states_arr;
        }
        else
        {
            $response['status']     = 'ERROR';
            $response['states_arr'] = [];    
        }
        return response()->json($response);
    }
     public function get_cities($countryid,$state_id)
    {

        $cities_arr = $this->CityModel->with(['city_translation'])
                                            ->where('state_id',$state_id)
                                            ->where('country_id',$countryid)
                                            ->where('is_active','1')
                                            ->get()->toArray();
        //   dd($cities_arr);                                 
        if(count($cities_arr)>0)
        {
            $response['status']     = 'SUCCESS';
            $response['cities_arr'] = $cities_arr;
        }
        else
        {
            $response['status']     = 'ERROR';
            $response['cities_arr'] = [];    
        }
        return response()->json($response);
    }

    public function verify_cart_products()
    {

        /**************check location data**************************/
         $checkuser_locationdata = checklocationdata(); 
         if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
         {
           $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
           $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
         } 

      /**************end check location data*********************/


        $loggedIn_userdet = 0;

        if (Sentinel::check()) {
            $loggedIn_userdet  = Sentinel::getUser();

            if ($loggedIn_userdet->user_type == 'buyer') {
                $bag_obj = $this->TempBagModel->where('buyer_id', $loggedIn_userdet->id)->first();

                if ($bag_obj) {

                    $bag_arr = $bag_obj->toArray();

                    $data_arr = json_decode($bag_arr['product_data'], true);
                    $data_arr['sequence'] = array_unique($data_arr['sequence']);

                    $product_data_arr = $data_arr['product_id'];

                    $product_ids_arr  = array_column($product_data_arr, 'product_id');

                    if (!empty($product_ids_arr)) {  
                        $product_arr = $this->ProductModel->whereIn('id', $product_ids_arr)
                            ->with([
                                'first_level_category_details',
                                'second_level_category_details',
                                'user_details.get_country_detail',
                                'user_details.get_state_detail',
                                'get_brand_detail',
                                'inventory_details'
                            ]);
                          /* if(isset($state_user_ids) && !empty($state_user_ids))
                           {
                             $product_arr = $product_arr->whereIn('user_id',$state_user_ids);
                           }  
                          if(isset($catdata) && !empty($catdata))
                           {
                            $product_arr = $product_arr->whereNotIn('first_level_category_id',$catdata);
                           }  */
                           $product_arr =  $product_arr->get();

                        if ($product_arr) {
                            $product_arr->toArray();

                            $response = array();
                            $removed_products = array();
                            $response['status'] = "false";
                            foreach ($product_arr as $key => $product) {


                                if (($product->is_active == 0)
                                    || ($product->first_level_category_details['is_active'] == 0)
                                    || ($product->second_level_category_details['is_active'] == 0)
                                    || ($product->user_details['get_country_detail']['is_active'] == 0)
                                    || ($product->user_details['get_state_detail']['is_active'] == 0)
                                    || ($product->get_brand_detail['is_active'] == 0)
                                    || ($product->is_outofstock == 1)
                                    || ($product->inventory_details['remaining_stock']<=0)
                                    || ($product->user_details['is_active'] == 0)
                                ) {
                                    $response['status'] = "true";
                                    $response['prostatus'] = $product->is_active;
                                    $response['first_level_category_detailsstatus'] = $product->first_level_category_details['is_active'];
                                    $response['get_country_detail'] = $product->user_details['get_country_detail']['is_active'];
                                    $response['get_state_detail'] = $product->user_details['get_state_detail']['is_active'];
                                    array_push($removed_products, $product->id);
                                    unset($data_arr['product_id'][$product->id]);
                                    if (($key = array_search($product->id, $data_arr['sequence'])) !== false) {
                                        unset($data_arr['sequence'][$key]);
                                    }

                                    // $data_arr['sequence'] = array_values(array_diff($data_arr['sequence'], array($product->id)));

                                }
                            }

                            if (count($removed_products) > 0) {
                                $update_arr['product_data'] = json_encode($data_arr, true);
                                $is_update = $this->TempBagModel->where('buyer_id', $loggedIn_userdet->id)->update($update_arr);
                                return response()->json('true');
                            } else {
                                return response()->json('false');
                            }
                        }
                    } else {
                        return response()->json('false');
                    }
                } else {
                    return response()->json('false');
                }
            } else {
                return response()->json('false');
            }
        } else {
            return response()->json('false');
        }        
       
    }


    public function verify_loginattempt()
    {
        DB::table('throttle')->truncate();
        $getuser = $this->UserModel->where([['login_attempt','4'],['is_active','0'],['id','1']])->first();
        if(!empty($getuser))
        {
            $getuser = $getuser->toArray();
            $timeout = $getuser['timeout'];
            $timeoutafter10minutes = date("Y-m-d H:i:s", strtotime($getuser['timeout'] . "+10 minutes"));

            $currentdate = date("Y-m-d H:i:s");
            if($currentdate>$timeoutafter10minutes){
                 $this->UserModel->where('email',$getuser['email'])->update(['is_active'=>'1','timeout'=>"",'login_attempt'=>'0']);
                 return response()->json('true');
             }else{
                return response()->json('false');
             }

        }else{
            return response()->json('false');
        }
    }

       public function verify_loginattemptfront()
    {
        DB::table('throttle')->truncate();

        $getuser = $this->UserModel->where([['login_attempt','4'],['is_active','0']])->get();
        if(!empty($getuser))
        {
            $getuser = $getuser->toArray();

             foreach($getuser as $user){
                $timeout = $user['timeout'];
                $timeoutafter10minutes = date("Y-m-d H:i:s", strtotime($user['timeout'] . "+10 minutes"));

                $currentdate = date("Y-m-d H:i:s");
                if($currentdate>$timeoutafter10minutes){
                     $this->UserModel->where('email',$user['email'])->update(['is_active'=>'1','timeout'=>"",'login_attempt'=>'0']);
                     return response()->json('true');
                 }else{
                    return response()->json('false');
                 }
             }   
        }else{
            return response()->json('false');
        }
    }




    /*
       send_invoice - Send Invoice to Buyer, Admin and seller after refund.
                      Admin refunds after buyer cancel the order. 
    */
    public function send_invoice($order_id=false,$order_no=false,$buyer_id=false)
    {   
        
        if($order_id!=false && $order_no!=false && $buyer_id!=false)
        {   
            $arr_cancel_order = $product_name_arr = [];
            $refunded_amount  = $seller_id = 0;
            $seller_fullname  = $buyer_fullname = $buyer_email = '';
           
            //Get Orders by Order No Except Cancel Order ID
            $arr_order = $this->OrderModel
                              ->where('id','!=',$order_id)
                              ->where('order_no','=',$order_no)
                              ->where('order_status','!=','0')
                              ->with([
                                        'order_product_details.product_details'
                                    ])
                              ->get()
                              ->toArray();


            /******************Get Cancel Order Details(START)********************/
                $obj_cancel_order = $this->OrderModel
                                        ->where('id',$order_id)
                                        ->with([
                                                 'order_product_details.product_details',
                                                 'seller_details',
                                                 'buyer_details'
                                               ])
                                        ->first();

                if($obj_cancel_order)
                {
                    $arr_cancel_order = $obj_cancel_order->toArray();

                    //Get Seller ID
                    $seller_id = isset($arr_cancel_order['seller_id'])?$arr_cancel_order['seller_id']:0;

                    //Get Seller Name
                    $seller_fname    = isset($arr_cancel_order['seller_details']['first_name'])?$arr_cancel_order['seller_details']['first_name']:'';
                    $seller_lname    = isset($arr_cancel_order['seller_details']['last_name'])?$arr_cancel_order['seller_details']['last_name']:'';
                    $seller_fullname = $seller_fname.' '.$seller_lname;

                    //Get Buyer Name
                    $buyer_fname    = isset($arr_cancel_order['buyer_details']['first_name'])?$arr_cancel_order['buyer_details']['first_name']:'';
                    $buyer_lname    = isset($arr_cancel_order['buyer_details']['last_name'])?$arr_cancel_order['buyer_details']['last_name']:'';
                    $buyer_fullname = $buyer_fname.' '.$buyer_lname;

                    //Get Refunded Amount
                    $refunded_amount  = isset($arr_cancel_order['total_amount'])? number_format($arr_cancel_order['total_amount'], 2, '.', ''):0;

                    /******************couponcode****************************/

                     if($arr_cancel_order['total_amount']>0){

                                if(isset($arr_cancel_order['couponid']) && isset($arr_cancel_order['couponcode']) && $arr_cancel_order['couponcode']!='' && isset($arr_cancel_order['discount']) && $arr_cancel_order['discount']!='' 
                                    && isset($arr_cancel_order['seller_discount_amt']) 
                                    && $arr_cancel_order['seller_discount_amt']!='')
                                {

                                  $refunded_amount1 = (float)$arr_cancel_order['total_amount'] - (float)$arr_cancel_order['seller_discount_amt'];  


                                    if(isset($arr_cancel_order['delivery_cost']) && $arr_cancel_order['delivery_cost']!='')
                                    {
                                      $refunded_amount1 = (float)$refunded_amount1 + (float)$arr_cancel_order['delivery_cost'];     
                                    }

                                    if(isset($arr_cancel_order['tax']) && $arr_cancel_order['tax']!='')
                                    {
                                      $refunded_amount1 = (float)$refunded_amount1 + (float)$arr_cancel_order['tax'];     
                                    }



                                  $refunded_amount = number_format($refunded_amount1, 2, '.', ''); 
                                }else{

                                      if(isset($arr_cancel_order['delivery_cost']) && $arr_cancel_order['delivery_cost']!='')
                                    {
                                      $refunded_amount = (float)$refunded_amount + (float)$arr_cancel_order['delivery_cost'];     
                                    }

                                     if(isset($arr_cancel_order['tax']) && $arr_cancel_order['tax']!='')
                                    {
                                      $refunded_amount = (float)$refunded_amount + (float)$arr_cancel_order['tax'];     
                                    }


                                    $refunded_amount = $refunded_amount;  
                                }
                            }
                            else{
                                $refunded_amount = $refunded_amount;
                            }


                    
                    /*******************couponcode***************************/
                    
                    //Get Cancel Product Name Array
                    $arr_product_details = isset($arr_cancel_order['order_product_details'])?$arr_cancel_order['order_product_details']:[];

                    if(isset($arr_product_details) && count($arr_product_details) > 0)
                    {
                        foreach ($arr_product_details as $key => $data_product) 
                        {
                           $product_name_arr[] = isset($data_product['product_details']['product_name'])?$data_product['product_details']['product_name']:'';
                        }
                    }

                    //Get Buyer Email
                    $buyer_email = isset($arr_cancel_order['buyer_details']['email'])?$arr_cancel_order['buyer_details']['email']:'';
                    
                }


            /******************Get Cancel Order Details(END)********************/


            /*********************Send Mail to Seller (START)****************************/
                //Here, we are sending email to that seller whose order is cancelled
                $arr_built_content = [
                                        'SELLER_NAME'     => $seller_fullname,
                                        'BUYER_NAME'      => $buyer_fullname,
                                        'REFUNDED_AMOUNT' => $refunded_amount,
                                        'ORDER_NO'        => $order_no
                                     ];

                $arr_mail_data['email_template_id'] = '44';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['user']              = Sentinel::findById($seller_id);

                $this->EmailService->send_mail($arr_mail_data);

            /*********************Send Mail to Seller (END)*******************************/

            
            if(isset($arr_order) && count($arr_order) > 0) 
            {
                //Send invoice with refund mail to Buyer and Admin
                 
                //Get Cancel Order Address Details (Here, we are taking address details of buyer using order no)   
                $address = [];

                $address_details = $this->OrderAddressModel
                                        ->with([
                                                'state_details',
                                                'country_details',
                                                'billing_state_details',
                                                'billing_country_details'
                                        ])
                                        ->where('order_id',$order_no)
                                        ->first();

                if($address_details) 
                {
                    $address['shipping']         = $address_details['shipping_address1'];
                    $address['shipping_state']   = $address_details['state_details']['name'];
                    $address['shipping_country'] = $address_details['country_details']['name'];
                    $address['shipping_zipcode'] = $address_details['shipping_zipcode'];
                    $address['billing']          = $address_details['billing_address1'];
                    $address['billing_state']    = $address_details['billing_state_details']['name'];
                    $address['billing_country']  = $address_details['billing_country_details']['name'];
                    $address['billing_zipcode']  = $address_details['billing_zipcode'];
                }


                foreach ($arr_order as $key => $order_details) 
                {   
                    //Get Product Details
                    $arr_product = isset($order_details['order_product_details'])?$order_details['order_product_details']:[];


                    if(isset($arr_product) && count($arr_product) > 0)
                    {
                        foreach ($arr_product as $key => $product) 
                        {
                            // dd($product);

                            $order[$key]['product_name'] = isset($product['product_details']['product_name'])?$product['product_details']['product_name']:'';
                            $order[$key]['order_no']     = $order_no;
                            $order[$key]['item_qty']     = isset($product['quantity'])?$product['quantity']:0;
                            $order[$key]['seller_name']  = $seller_fullname;

                            $order[$key]['unit_price']   = isset($product['unit_price'])?$product['unit_price']:0;

                            $order[$key]['total_wholesale_price'] = $product['unit_price']*$product['quantity'];

                            $order[$key]['shipping_charges']      = isset($product['shipping_charges'])?$product['shipping_charges']:0;
                        }

                        $sum                  = 0;
                        $total_amount         = 0;
                        $shipping_charges_sum = 0;
                        $sn_no                = 0;

                        foreach ($order as $key => $order_data) 
                        { 
                            $sum += $order_data['total_wholesale_price'];
                            $shipping_charges_sum += $order_data['shipping_charges'];
                            
                            $order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
                        }
                    }
                }   


                /***********************Generate PDF (START)********************************/
                    $pdf = PDF::loadView('front/invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address'));
              
                    $currentDateTime = $order_no.date('H:i:s').'.pdf';
            
                    Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
                    $pdfpath = Storage::url($currentDateTime);

                /***********************Generate PDF (END)**********************************/

                /*-------------Send Mail to Buyer (START)--------------------------*/

                    $obj_email_template = $this->EmailTemplateModel->where('id','42')->first();

                    if($obj_email_template)
                    {
                        $arr_email_template = $obj_email_template->toArray();
                        $content            = $arr_email_template['template_html'];
                    }

                    $dynamic_arr =  [
                                        '##BUYER_NAME##',
                                        '##REFUNDED_AMOUNT##',
                                        '##ORDER_NO##',
                                        '##PRODUCT_NAME_ARR##'
                                    ];

                    $replace_arr =  [
                                        $buyer_fullname,
                                        $refunded_amount,
                                        $order_no,
                                        implode(', ',$product_name_arr)
                                    ];
                   
                    $content = str_replace($dynamic_arr,$replace_arr,$content);

                    $content = view('email.front_general',compact('content'))->render();
                    $content = html_entity_decode($content);

                    $file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

                    $send_mail = Mail::send(array(),array(), function($message) use($content,$buyer_email,$file_to_path,$arr_email_template)
                    {
                      
                        $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                        $message->to($buyer_email)
                              ->subject($arr_email_template['template_subject'])
                              ->setBody($content, 'text/html');
                        $message->attach($file_to_path);
                           
                    });

                /*-------------Send Mail to Buyer (END)--------------------------*/
               
                /**************Send Mail to Admin (START)***************************/
                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj  = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id      = $admin_obj->user_id;            
                        $admin_details = Sentinel::findById($admin_id);
                        $admin_email   = isset($admin_details->email)?$admin_details->email:'';  
                    }

                    
                    $obj_email_template = $this->EmailTemplateModel->where('id','43')->first();

                    if($obj_email_template)
                    {
                        $arr_email_template = $obj_email_template->toArray();
                        $content            = $arr_email_template['template_html'];
                    }

                    $dynamic_arr =  [
                                        '##ADMIN_NAME##',
                                        '##REFUNDED_AMOUNT##',
                                        '##BUYER_NAME##',
                                        '##ORDER_NO##'
                                    ];

                    $replace_arr =  [
                                        config('app.project.admin_name'),
                                        $refunded_amount,
                                        $buyer_fullname,
                                        $order_no
                                    ];
                   
                    $content = str_replace($dynamic_arr,$replace_arr,$content);

                    $content = view('email.front_general',compact('content'))->render();
                    $content = html_entity_decode($content);

                    $file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

                    $send_mail = Mail::send(array(),array(), function($message) use($content,$admin_email,$file_to_path,$arr_email_template)
                    {
                        $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                        $message->to($admin_email)
                              ->subject($arr_email_template['template_subject'])
                              ->setBody($content, 'text/html');
                        $message->attach($file_to_path);  
                    });
                    
                /**************Send Mail to Admin (END)*****************************/
                
            }
            else
            {
                //Send refund mail to buyer and admin without invoice

                /*******************Send Mail to Buyer (START)**************/

                    $arr_built_content = ['BUYER_NAME'       => $buyer_fullname,
                                          'REFUNDED_AMOUNT'  => $refunded_amount,
                                          'ORDER_NO'         => $order_no,
                                          'PRODUCT_NAME_ARR' => implode(', ',$product_name_arr)
                                         ];

                    $arr_mail_data['email_template_id'] = '42';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['user']              = Sentinel::findById($buyer_id);

                    $this->EmailService->send_mail($arr_mail_data);

                /*******************Send Mail to Buyer (END)****************/

                /*******************Send Mail to Admin (START)**************/
                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj  = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id      = $admin_obj->user_id;              
                    }

                    $arr_built_content = ['ADMIN_NAME'       => config('app.project.admin_name'),
                                          'REFUNDED_AMOUNT'  => $refunded_amount,
                                          'BUYER_NAME'       => $buyer_fullname,
                                          'ORDER_NO'         => $order_no
                                         ];

                    $arr_mail_data['email_template_id'] = '43';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_mail($arr_mail_data);

                /*******************Send Mail to Admin (END)****************/

            }
        }
    }


     public function get_business_name($business_name)
    {
        $user   = Sentinel::check();
        if(isset($user->id))
        {
             $businessname_already_exists  = $this->SellerModel->where('business_name',$business_name)->where('user_id','!=',$user->id)->get()->toArray();
         }else{
             $businessname_already_exists  = $this->SellerModel->where('business_name',$business_name)->get()->toArray();
         }
     
        if(!empty($businessname_already_exists))
        {
             $response['status'] = 'ERROR';
             $response['msg'] = 'This business name already exists.';
            return response()->json($response); 
        }else{
             $response['status']  = 'SUCCESS';
             $response['msg']     = '';
             return response()->json($response);
        }
       
    }


      public function check_email_exists($email)
    {
        $user   = Sentinel::check();


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
                    return response()->json($arr_response);
                 }  

              }//if arrayresult

            /***********Email validation library code*end****************/



                if(isset($user->id))
                {
                     $email_already_exists  = $this->UserModel->where('email',$email)->where('user_id','!=',$user->id)->get()->toArray();
                 }else{
                     $email_already_exists  = $this->UserModel->where('email',$email)->get()->toArray();
                 }
             
                if(!empty($email_already_exists))
                {
                     $response['status'] = 'ERROR';
                     $response['msg'] = 'Provided email already exists in system, you may try different email.';
                    return response()->json($response); 
                }else{
                     $response['status']  = 'SUCCESS';
                     $response['msg']     = '';
                     return response()->json($response);
                }
       
    }//end of function


    public function send_queueemails()
    {   
        $get_queue_emails =[];

        $get_queue_emails = $this->SendNewsletterModel->where('status','queue')->limit(50)->get();
        if(isset($get_queue_emails) && !empty($get_queue_emails))
        {
            $get_queue_emails = $get_queue_emails->toArray();
           // dd( $get_queue_emails);

           // $email ='';
            foreach($get_queue_emails as $v)
            {   
                $id = $v['id'];
                $email = $v['email'];
                $template_id = $v['template_id'];
                $newsletter_subject = $v['subject'];
                $newsletter_desc = $v['description'];

                // $this->sendemail($id,$template_id,$email,$newsletter_desc,$newsletter_subject);

                 $send_mail = Mail::send(array(),array(), function($message) use($email,$newsletter_subject,$newsletter_desc,$template_id)
                {
                  
                    
                    $message->from('notify@chow420.com');
                    $message->to($email)
                          ->subject($newsletter_subject)
                          ->setBody($newsletter_desc, 'text/html');
                });

                $updateemaildbarr = [];
                $updateemaildbarr['status'] = 'sent'; 
                $update = $this->SendNewsletterModel->where('id',$id)->where('template_id',$template_id)->update($updateemaildbarr);
                if($update)
                {
                    echo "sent";
                }


            } //foreach

        }//if
    }//end of function

    public function sendemail($id,$template_id,$email,$newsletter_desc,$newsletter_subject)
    {
               $send_mail = Mail::send(array(),array(), function($message) use($email,$newsletter_subject,$newsletter_desc,$template_id)
                {
                  
                    
                    $message->from('notify@chow420.com');
                    $message->to($email)
                          ->subject($newsletter_subject)
                          ->setBody($newsletter_desc, 'text/html');
                });
                $updateemaildbarr = [];
                $updateemaildbarr['status'] = 'sent'; 
                $update = $this->SendNewsletterModel->where('id',$id)->where('template_id',$template_id)->update($updateemaildbarr);
                if($update)
                {
                    echo "sent";
                }


      }//end of function
      public function removerestricted_products()
      {
         /**************check location data**************************/
         $checkuser_locationdata = checklocationdata(); 
         if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
         {
           $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
           $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
         } 


         /**************end check location data*********************/

         if (Sentinel::check()) {
            $loggedIn_userdet  = Sentinel::getUser();
             if ($loggedIn_userdet->user_type == 'buyer') {
                $bag_obj = $this->TempBagModel->where('buyer_id', $loggedIn_userdet->id)->first();
                 if ($bag_obj) 
                 {
                     $bag_arr = $bag_obj->toArray();

                     $data_arr = json_decode($bag_arr['product_data'], true);
                     $data_arr['sequence'] = array_unique($data_arr['sequence']);
                     $product_data_arr = $data_arr['product_id'];
                     $product_ids_arr  = array_column($product_data_arr, 'product_id');

                       if (!empty($product_ids_arr)) {  
                        $product_arr = $this->ProductModel->whereIn('id', $product_ids_arr)
                            ->with([
                                'first_level_category_details',
                                'second_level_category_details',
                                'user_details.get_country_detail',
                                'user_details.get_state_detail',
                                'get_brand_detail',
                                'inventory_details'
                            ]);
                           $product_arr =  $product_arr->get();


                        if ($product_arr) {
                            $product_arr->toArray();

                            $response = array();
                            $removed_products = array();
                            $response['status'] = "false";
                            foreach ($product_arr as $key => $product) {


                                if ((in_array($product->first_level_category_id, $catdata) && ($product->inventory_details['remaining_stock']>0)) || (in_array($product->first_level_category_id, $catdata) && ($product->inventory_details['remaining_stock']<=0)) ) 
                                {
                                  
                                    $response['status'] = "true";
                                    $response['prostatus'] = $product->is_active;
                                    $response['first_level_category_detailsstatus'] = $product->first_level_category_details['is_active'];
                                    $response['get_country_detail'] = $product->user_details['get_country_detail']['is_active'];
                                    $response['get_state_detail'] = $product->user_details['get_state_detail']['is_active'];
                                    array_push($removed_products, $product->id);
                                    unset($data_arr['product_id'][$product->id]);

                                    // if (($key = array_search($product->id, $data_arr['sequence'])) !== false) {
                                    //     unset($data_arr['sequence'][$key]);
                                    // }

                                   $data_arr['sequence'] = array_values(array_diff($data_arr['sequence'], array($product->id)));


                                }
                            }//foreach
                           

                            if (count($removed_products) > 0) {
                                $update_arr['product_data'] = json_encode($data_arr, true);
                                $is_update = $this->TempBagModel->where('buyer_id', $loggedIn_userdet->id)->update($update_arr);
                                return response()->json('true');
                            } else {
                                return response()->json('false');
                            }
                        }
                    } 
                    else 
                    {
                        return response()->json('false');
                    }   


                 }else{
                    return response()->json('false');
                 }

             }
             else
             {
                return response()->json('false');
             }
          }
          else{
            return response()->json('false');
         }   

      }//end function removerestricted_products




     public function remove_state_restricted_products()
      {
        /*******************Restricted states seller id***********************************/

       $check_buyer_restricted_states =  get_buyer_restricted_sellers();
       $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];
        $restricted_state_sellers = [];
       if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids)){

          $restricted_state_sellers = [];
          foreach($restricted_state_user_ids as $sellers) {
            $restricted_state_sellers[] = $sellers['id'];
          }
       }
       $is_buyer_restricted_forstate = is_buyer_restricted_forstate();

       /********************Restricted states seller id***********************/

         if (Sentinel::check()) {
            $loggedIn_userdet  = Sentinel::getUser();
             if ($loggedIn_userdet->user_type == 'buyer') {
                $bag_obj = $this->TempBagModel->where('buyer_id', $loggedIn_userdet->id)->first();
                 if ($bag_obj) 
                 {
                     $bag_arr = $bag_obj->toArray();

                     $data_arr = json_decode($bag_arr['product_data'], true);
                     $data_arr['sequence'] = array_unique($data_arr['sequence']);
                     $product_data_arr = $data_arr['product_id'];
                     $product_ids_arr  = array_column($product_data_arr, 'product_id');

                       if (!empty($product_ids_arr)) {  
                        $product_arr = $this->ProductModel->whereIn('id', $product_ids_arr)
                            ->with([
                                'first_level_category_details',
                                'second_level_category_details',
                                'user_details.get_country_detail',
                                'user_details.get_state_detail',
                                'get_brand_detail',
                                'inventory_details'
                            ]);
                           $product_arr =  $product_arr->get();


                        if ($product_arr) {
                            $product_arr->toArray();

                            $response = array();
                            $removed_products = array();
                            $response['status'] = "false";
                            foreach ($product_arr as $key => $product) {



                                // condition added for buyer state restriction
                               /* if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers) && isset($product->user_id))
                               {
                                  if(in_array($product->user_id,$restricted_state_sellers))
                                  { 
                                  
                                  }
                                  else
                                  {
                                    $buyer_state_restricted_flag++; 
                                  }
                               }
                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($restricted_state_sellers))
                               {
                                $buyer_state_restricted_flag++; 
                               }
                               else
                               {
                                 //$checkfirstcat_flag = 0;
                               }*/

                                if (isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers) && isset($product->user_id)) 
                                {
                                  
                                    if(in_array($product->user_id, $restricted_state_sellers))
                                    {

                                    }else{
                                        $response['status'] = "true";
                                        $response['prostatus'] = $product->is_active;
                                        $response['first_level_category_detailsstatus'] = $product->first_level_category_details['is_active'];
                                        $response['get_country_detail'] = $product->user_details['get_country_detail']['is_active'];
                                        $response['get_state_detail'] = $product->user_details['get_state_detail']['is_active'];
                                        array_push($removed_products, $product->id);
                                        unset($data_arr['product_id'][$product->id]);
                                        $data_arr['sequence'] = array_values(array_diff($data_arr['sequence'], array($product->id)));
                                    }

                               }
                               elseif (isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && empty($restricted_state_sellers) && isset($product->user_id)) 
                                {
                                  
                                    $response['status'] = "true";
                                    $response['prostatus'] = $product->is_active;
                                    $response['first_level_category_detailsstatus'] = $product->first_level_category_details['is_active'];
                                    $response['get_country_detail'] = $product->user_details['get_country_detail']['is_active'];
                                    $response['get_state_detail'] = $product->user_details['get_state_detail']['is_active'];
                                    array_push($removed_products, $product->id);
                                    unset($data_arr['product_id'][$product->id]);
                                    $data_arr['sequence'] = array_values(array_diff($data_arr['sequence'], array($product->id)));


                                }


                            }//foreach
                           

                            if (count($removed_products) > 0) {
                                $update_arr['product_data'] = json_encode($data_arr, true);
                                $is_update = $this->TempBagModel->where('buyer_id', $loggedIn_userdet->id)->update($update_arr);
                                return response()->json('true');
                            } else {
                                return response()->json('false');
                            }
                        }
                    } 
                    else 
                    {
                        return response()->json('false');
                    }   


                 }else{
                    return response()->json('false');
                 }

             }
             else
             {
                return response()->json('false');
             }
          }
          else{
            return response()->json('false');
         }   

     }//end function remove_state_restricted_products  



}//class
