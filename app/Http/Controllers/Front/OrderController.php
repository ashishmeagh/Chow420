<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\UserModel;
use App\Common\Services\OrderService;
use App\Models\ProductModel;
use App\Models\UserAddressesModel;
use App\Models\TempBagModel;
use Anam\Phpcart\Cart;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\CityModel;
use App\Models\OrderAddressModel;
use App\Models\StateTranslationModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\TransactionModel;

use EmailValidation\EmailValidatorFactory;
use App\Models\BuyerModel;
use App\Common\Services\EmailService;
use App\Models\BuyerWalletModel;

use TaxJar\Client;


use Validator;
use Sentinel;
use DB;
use Activation; 
use Session;
use Flash;
 
class OrderController extends Controller
{
    public function __construct(
                                 UserModel $UserModel,
                                 UserAddressesModel $UserAddressesModel,
                                 ProductModel $ProductModel,
                                 TempBagModel $TempBagModel,
                                 Cart $Cart,
                                 CountriesModel $CountriesModel,
                                 OrderService $OrderService,
                                 StatesModel $StatesModel,
                                 CityModel $CityModel,
                                 OrderAddressModel $OrderAddressModel,
                                 StateTranslationModel $StateTranslationModel,
                                 OrderModel $OrderModel,
                                 OrderProductModel $OrderProductModel,
                                 TransactionModel $TransactionModel,
                                 BuyerModel $BuyerModel,
                                 EmailService $EmailService,
                                 BuyerWalletModel $BuyerWalletModel

                               )
    {
        $this->UserModel               = $UserModel;
        $this->ProductModel            = $ProductModel;
        $this->TempBagModel            = $TempBagModel;
        $this->UserAddressesModel      = $UserAddressesModel;
    	  $this->cart                    = $Cart;
        $this->CountriesModel          = $CountriesModel;
        $this->OrderService            = $OrderService;
        $this->StatesModel              = $StatesModel;
        $this->CityModel               = $CityModel;
        $this->OrderAddressModel       = $OrderAddressModel;
        $this->StateTranslationModel   = $StateTranslationModel;
        $this->OrderModel              = $OrderModel;
        $this->OrderProductModel       = $OrderProductModel;
        $this->TransactionModel        = $TransactionModel;
        $this->BuyerModel              = $BuyerModel;  
        $this->EmailService            = $EmailService;
        $this->BuyerWalletModel        = $BuyerWalletModel;

        $this->module_view_folder      = 'front';  
    	  $this->module_title            = 'Checkout';
        $this->back_path               = url('/');  
        $this->arr_view_data           = [];
    }

    public function guest_signup()
    { 
       $loginuser =  Sentinel::check();

       if($loginuser==false)
       {

          $this->arr_view_data['module_title']    = $this->module_title;
          $this->arr_view_data['page_title']      = 'Guest Signup';
          return view($this->module_view_folder.'.guest_signup', $this->arr_view_data);  
       }
       else
       {
         return redirect('/');
       }
     
    }

    public function checkout()
    { 
      $bag_arr  = $product_data_arr = $product_arr = $cart_product_arr = $maker_details_arr = $buyer_details = $out_of_stock_arr = [];
      $arr_final_data = [];
      $subtotal       = 0;
      $maintotal      = 0;
      $shippingsubtotal  = 0;
      $wholesale_subtotal = 0;

     // $user = Sentinel::check();
      // $loggedIn_Id = $user->id;

       /***************************************/
        $user = Sentinel::check();
        $loggedIn_Id = 0;
        if($user)
        {
          $loggedIn_Id = $user->id;

          //get buyer wallet amount total
          $buyer_wallet_amt =0;

          $buyer_wallet_amt = $this->BuyerWalletModel
                                               ->where('user_id',$loggedIn_Id)
                                               ->where('status','!=',0) 
                                               ->sum('amount');
          $this->arr_view_data['buyer_wallet_amt'] = isset($buyer_wallet_amt)?$buyer_wallet_amt:'0';


        }
        $session_id = $this->get_session_id();
        $ip_address = $this->get_ip_address();


        if($loggedIn_Id==0)
        {
             $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
             ->where('user_session_id',$session_id)
             ->where('ip_address',$ip_address)
             ->first();
        }
        else{
             $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
        }


      
        /***************************************/

      
      $has_age_verified_product_in_cart=0;   



      if($user)
      {
            $obj_buyer = $this->UserModel->with('buyer_detail','get_country_detail','get_state_detail','get_billing_country_detail','get_billing_state_detail')->where('id',$loggedIn_Id)->first();

            if ($obj_buyer) {
              
              $buyer_details = $obj_buyer->toArray();

            }
       }//if user

      // $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first(); //commented

      if($bag_obj)
      {
          $bag_arr          = $bag_obj->toArray();

          $data_arr = json_decode($bag_arr['product_data'],true);
          $product_data_arr = $data_arr['product_id'];
          
          $product_ids_arr  = array_column($product_data_arr, 'product_id');

          $product_arr = $this->ProductModel
                               ->whereIn('id',$product_ids_arr)
                               ->with( 'product_images_details',
                                       'age_restriction_detail',
                                       'get_brand_detail',
                                       'get_seller_details.seller_detail',
                                       'first_level_category_details',
                                       'first_level_category_details.age_restriction_detail',
                                       'inventory_details')
                               ->get()
                               ->toArray();
         
  
          /*create out of stock array from cart data*/

          if(isset($product_arr) && count($product_arr)>0)
          {   
              foreach ($product_arr as $key => $product) 
              {
                  if(isset($product['is_outofstock']) && $product['is_outofstock'] == 1 ||
                    isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] == 0
                  )
                  {
                    $out_of_stock_arr[] = $product['id'];
                  }

              }

              if(count($out_of_stock_arr)>0)
              {
                 Flash::error("Please remove out of stock product from cart");
                 return redirect('/my_bag');
              }

          }    

        
          /*-----------------------------------------*/



         // $has_age_verified_product_in_cart=0; 
          
          if(isset($product_arr) && count($product_arr)>0)
          {   
              foreach ($product_arr as $key => $product) 
              {
                  $cart_product_arr[$key]['user_id']        = $product['user_id'];
                  $cart_product_arr[$key]['product_id']     = $product['id'];
                  $cart_product_arr[$key]['product_name']   = $product['product_name'];
                  $cart_product_arr[$key]['product_image']  = $product['product_images_details'];
                  $cart_product_arr[$key]['product_age_detail']    = $product['age_restriction_detail'];
                  $cart_product_arr[$key]['product_brand_detail']  = $product['get_brand_detail'];
                   $cart_product_arr[$key]['shipping_duration']    = $product['shipping_duration'];
                   $cart_product_arr[$key]['shipping_type']    = $product['shipping_type'];
                    $cart_product_arr[$key]['first_level_category_id']    = $product['first_level_category_id'];
                    $cart_product_arr[$key]['is_age_limit']    = $product['is_age_limit'];
                    $cart_product_arr[$key]['age_restriction']  = $product['age_restriction'];

                  // if($product['age_restriction_detail']!=null){
                  //   $has_age_verified_product_in_cart++;
                  // }

                 if(isset($product['first_level_category_details']['is_age_limit']) && $product['first_level_category_details']['is_age_limit']==1){
                    $has_age_verified_product_in_cart++;
                  }

                  $cart_arr[$key]['total_price']    = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'';

                  $cart_product_arr[$key]['unit_price']    = $product['unit_price'];
                  $cart_product_arr[$key]['price_drop_to']    = $product['price_drop_to'];
                  $cart_product_arr[$key]['shipping_charges']    = $product['shipping_charges'];
                  if ($cart_product_arr[$key]['price_drop_to'] > 0) {
                    $cart_product_arr[$key]['total_price']    = $product['price_drop_to'] * $cart_arr[$key]['total_price'];
                  } else {
                    $cart_product_arr[$key]['total_price']    = $product['unit_price'] * $cart_arr[$key]['total_price'];
                  }

                  $cart_product_arr[$key]['item_qty']       = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'';

                  $cart_product_arr[$key]['product_seller_detail']  = $product['get_seller_details'];
                  $cart_product_arr[$key]['is_chows_choice']    = $product['is_chows_choice'];
                  $cart_product_arr[$key]['product_certificate']    = $product['product_certificate'];
                  $cart_product_arr[$key]['spectrum']    = $product['spectrum'];
                  
                  $cart_product_arr[$key]['first_level_category_details']    = isset($product['first_level_category_details'])?$product['first_level_category_details']:[];
                  
                  $cart_product_arr[$key]['is_outofstock']    = isset($product['is_outofstock'])?$product['is_outofstock']:[];

              }

              $maintotal = array_sum((array_column($cart_product_arr,'total_price')));
              $shippingsubtotal = array_sum((array_column($cart_product_arr, 'shipping_charges')));
          }        
         
          $arr_prefetch_user_id = array_unique(array_column($cart_product_arr, 'user_id'));
          // $arr_prefetch_user_ref =  $this->UserModel->with('seller_detail')->whereIn('id',$arr_prefetch_user_id)->get()->toArray();

          // cdoe added for delivery option 
           $arr_prefetch_user_ref =  $this->UserModel
                                            ->with(['seller_detail' => function($seller_detail) {

                                                $seller_detail->with(['delivery_options' => function($delivery_options) {

                                                    $delivery_options->select( 'id',
                                                                                'seller_id',
                                                                                'title',
                                                                                'day',
                                                                                'cost',
                                                                                'status'
                                                                            );
                                                    $delivery_options->where('status' , '1');
                                                }]);
                                            }])
                                            ->whereIn('id',$arr_prefetch_user_id)
                                            ->get()->toArray(); 

                                            
         
          $arr_prefetch_user_ref = array_column($arr_prefetch_user_ref,null, 'id');
          
          $product_sequence     = ""; 
          $arr_product_sequence = $arr_sequence = [];
          $arr_sequence         = $data_arr['sequence'];
         
          if(isset($cart_product_arr) && sizeof($cart_product_arr)>0)
          {
              foreach($cart_product_arr as $key => $value) 
              {

                  $arr_final_data[$value['user_id']]['product_details'][$value['product_id']] = $value;
                  $arr_final_data[$value['user_id']]['seller_details'] = isset($arr_prefetch_user_ref[$value['user_id']]) ? $arr_prefetch_user_ref[$value['user_id']] : []; 
              }
          } 
          
          /* Rearrange sequence */
          if(sizeof($arr_final_data)>0)
          {
              foreach ($arr_final_data as $_key => $_data) 
              {   
                  $arr_relavant_sequence = array_flip(array_intersect($arr_sequence,array_keys($_data['product_details'])));
                  if(sizeof($arr_relavant_sequence)>0)
                  {
                      foreach ($arr_relavant_sequence as $sequence_attrib => $sequence_tmp) 
                      {
                          $arr_relavant_sequence[$sequence_attrib] = isset($_data['product_details'][$sequence_attrib]) ? $_data['product_details'][$sequence_attrib] : [];
                      }
                  }
                  
                  $arr_final_data[$_key]['product_details'] = $arr_relavant_sequence;                    
              }
          }//if sizeof
         
      }//if bag obj 


        $countries_obj = $this->CountriesModel->where('is_active',1)->get();
        if ($countries_obj) {
            $countries_arr = $countries_obj->toArray();

            $this->arr_view_data['countries_arr']         = $countries_arr;
        }


        if(isset($buyer_details['country']))
        {
          // commented country id condition here for the state array
            $states_obj = $this->StatesModel
                           // ->where('country_id', $buyer_details['country'])
                            ->where('is_active',1)
                            ->get();
            if ($states_obj) {
                $states_arr = $states_obj->toArray();
                // dd($states_arr);
                //$this->arr_view_data['states_arr']         = $states_arr;
            }
        } //if isset buyer_details of country
        $this->arr_view_data['states_arr']   = isset($states_arr)?$states_arr:[];


        if(isset($buyer_details['billing_country'])){
              $billing_states_obj = $this->StatesModel
                                      //->where('country_id', $buyer_details['billing_country'])
                                      ->where('is_active',1)
                                      ->get();
              if (isset($billing_states_obj)) {
                  $billing_states_arr = $billing_states_obj->toArray();
                 // $this->arr_view_data['billing_states_arr']         = $billing_states_arr;
              }//if billing states obj
       }// if isset buyer details of billing country




       //get restricated state text
      
      $buyer_state = '';
      $buyer_state = isset($buyer_details['state'])?$buyer_details['state']:0;

      $restricted_state_text = $this->StatesModel
                                ->where('id',$buyer_state)
                                ->pluck('text')
                                ->first();

         // get seller wise total amount of order and shipping

        if(isset($arr_final_data) && !empty($arr_final_data))
        {

            // $sANDBOX_API_URL = 'https://api.sandbox.taxjar.com';
            // $client = Client::withApiKey('6c10498ae1c7900d788c01b3669729c6');
            // $client->setApiConfig('api_url',Client::SANDBOX_API_URL);

             $seller_wise_total_order_amount = [];

            
            foreach ($arr_final_data as $product_arr) 
            {
                $error_flag = 0;
                $seller_total_amount= $seller_shipping_total_amount = 0;
                $seller_address = $buyer_address = [];
                foreach($product_arr['product_details'] as $product)
                {
                    $seller_total_amount += isset($product['total_price'])?$product['total_price']:0;
                    $seller_shipping_total_amount += isset($product['shipping_charges'])?$product['shipping_charges']:0;

                    $seller_wise_total_order_amount[$product['user_id']]['amount'] = isset($seller_total_amount)?$seller_total_amount:0;

                    $seller_wise_total_order_amount[$product['user_id']]['shipping'] = isset($seller_shipping_total_amount)?$seller_shipping_total_amount:0;

                    $seller_wise_total_order_amount[$product['user_id']]['sellername'] = get_seller_details($product['user_id']);

                    $seller_wise_total_order_amount[$product['user_id']]['seller_address_details'] = get_seller_address_details($product['user_id']);

                    $seller_address = get_seller_address_details($product['user_id']); 

                    $seller_wise_total_order_amount[$product['user_id']]['from_country'] = isset($seller_address['country'])? get_iso_country($seller_address['country']):'';
                    $seller_wise_total_order_amount[$product['user_id']]['from_zip'] = isset($seller_address['zipcode'])? $seller_address['zipcode']:'';
                    $seller_wise_total_order_amount[$product['user_id']]['from_city'] = isset($seller_address['city'])? $seller_address['city']:'';
                    $seller_wise_total_order_amount[$product['user_id']]['from_state'] = isset($seller_address['state'])? get_iso_state($seller_address['state']):'';
                    $seller_wise_total_order_amount[$product['user_id']]['from_street'] = isset($seller_address['street_address'])? $seller_address['street_address']:'';

                   
                    $buyer_address = get_buyer_details($user->id);

                     $seller_wise_total_order_amount[$product['user_id']]['to_country'] = isset($buyer_address['country'])? get_iso_country($buyer_address['country']):'';
                    $seller_wise_total_order_amount[$product['user_id']]['to_zip'] = isset($buyer_address['zipcode'])? $buyer_address['zipcode']:'';
                    $seller_wise_total_order_amount[$product['user_id']]['to_city'] = isset($buyer_address['city'])? $buyer_address['city']:'';
                    $seller_wise_total_order_amount[$product['user_id']]['to_state'] = isset($buyer_address['state'])? get_iso_state($buyer_address['state']):'';
                    $seller_wise_total_order_amount[$product['user_id']]['to_street'] = isset($buyer_address['street_address'])? $buyer_address['street_address']:'';


                    if(isset($seller_wise_total_order_amount[$product['user_id']]['to_country'])
                    && !empty($seller_wise_total_order_amount[$product['user_id']]['to_country'])
                     && isset($seller_wise_total_order_amount[$product['user_id']]['to_zip']) 
                     && !empty($seller_wise_total_order_amount[$product['user_id']]['to_zip']) 
                      && isset($seller_wise_total_order_amount[$product['user_id']]['to_city']) 
                      && !empty($seller_wise_total_order_amount[$product['user_id']]['to_city'])
                      && isset($seller_wise_total_order_amount[$product['user_id']]['to_state'])
                      && !empty($seller_wise_total_order_amount[$product['user_id']]['to_state'])
                      && isset($seller_wise_total_order_amount[$product['user_id']]['to_street'])
                      && !empty($seller_wise_total_order_amount[$product['user_id']]['to_street'])
                      && isset($seller_wise_total_order_amount[$product['user_id']]['from_country']) 
                      && !empty($seller_wise_total_order_amount[$product['user_id']]['from_country'])
                      && isset($seller_wise_total_order_amount[$product['user_id']]['from_zip'])
                      && !empty($seller_wise_total_order_amount[$product['user_id']]['from_zip']) 
                      && isset($seller_wise_total_order_amount[$product['user_id']]['from_city'])
                      && !empty($seller_wise_total_order_amount[$product['user_id']]['from_city']) && isset($seller_wise_total_order_amount[$product['user_id']]['from_state']) && !empty($seller_wise_total_order_amount[$product['user_id']]['from_state'])
                      && isset($seller_wise_total_order_amount[$product['user_id']]['from_street']) 
                      && !empty($seller_wise_total_order_amount[$product['user_id']]['from_street'])
                      && isset($seller_wise_total_order_amount[$product['user_id']]['amount']) 
                      && isset($seller_wise_total_order_amount[$product['user_id']]['shipping']) )
                    {


                       $calculate_tax = calculate_tax($seller_wise_total_order_amount);

                       if(isset($calculate_tax) && isset($calculate_tax['tax']) && isset($calculate_tax['status']) && $calculate_tax['status']=='success')
                       {
                           $seller_wise_total_order_amount[$product['user_id']]['tax'] = $calculate_tax['tax'];
                           $seller_wise_total_order_amount[$product['user_id']]['error_flag'] =0;
                             $seller_wise_total_order_amount[$product['user_id']]['message'] = '';

                       }//isset calculate_tax
                       else if(isset($calculate_tax) && $calculate_tax['status']=='error')
                       {
                          $seller_wise_total_order_amount[$product['user_id']]['tax'] = 0;
                          $seller_wise_total_order_amount[$product['user_id']]['status'] =
                             $calculate_tax['status'];
                          $seller_wise_total_order_amount[$product['user_id']]['error_flag'] = 1;
                          $seller_wise_total_order_amount[$product['user_id']]['message'] = $calculate_tax['message'];

                       }

                    }//isset all fields
                    else
                    {
                          $seller_wise_total_order_amount[$product['user_id']]['tax'] = 0;
                          $seller_wise_total_order_amount[$product['user_id']]['status'] =
                             'error';
                          $seller_wise_total_order_amount[$product['user_id']]['error_flag'] = 1;
                          $seller_wise_total_order_amount[$product['user_id']]['message'] = 'country,state,zipcode,street address is mandatory.';
                    }


                  

                }//foreach
            }//foreach

             // dump($seller_wise_total_order_amount);
        } // get seller wise total amount of order and shipping





        $this->arr_view_data['billing_states_arr'] = isset($billing_states_arr)?$billing_states_arr:[];

        $this->arr_view_data['restrcited_state_text'] = isset($restricted_state_text)?$restricted_state_text:'';

        $this->arr_view_data['arr_final_data']  = isset($arr_final_data)?$arr_final_data:[];
        $this->arr_view_data['product_data']    = isset($bag_arr['product_data'])?$bag_arr['product_data']:[];
        $this->arr_view_data['bag_id']          = isset($bag_arr['id'])?$bag_arr['id']:0;
        $this->arr_view_data['maintotal']        = $maintotal;
        $this->arr_view_data['subtotal']        = $maintotal + $shippingsubtotal;
        $this->arr_view_data['shippingsubtotal']  = $shippingsubtotal; 
        $this->arr_view_data['wholesale_subtotal'] = isset($wholesale_subtotal)?$wholesale_subtotal:"0";     
        $this->arr_view_data['cart_product_arr']= $cart_product_arr;      
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['buyer_details']   = isset($buyer_details)?$buyer_details:[];
        $this->arr_view_data['has_age_verified_product_in_cart']   = $has_age_verified_product_in_cart;

        $this->arr_view_data['seller_wise_total_order_amount'] = isset($seller_wise_total_order_amount)?$seller_wise_total_order_amount:[];

        // dd($this->arr_view_data);
        return view($this->module_view_folder.'.checkout', $this->arr_view_data);       
       
    }

    public function add_item_into_cart(Request $request)
    {
      $product_arr = $new_arr = [];

        $arr_rules = [  
                        'product_id'      => 'required',  
                        'item_qty'        => 'required'                            
                    ];

        $validator = Validator::make($request->all(),$arr_rules); 

        if($validator->fails())
        {        
           $response['status'] = 'warning';
           $response['description'] = 'Form validations fails, Please check all fields';
        }

        $product_id = $request->input('product_id',null);
        $product_id = base64_decode($product_id);
        $item_qty   = $request->input('item_qty',null);
        $sku_no     = $request->input('sku_no',null);
        $bag_count  = get_bag_count();
        //get retailer ip address
        $ip_address = $request->ip();
        $session_id = session()->getId();
       
        //find is any product added from this ip if yes then push new data to same row
        try
        {
          DB::beginTransaction();
          $exist_obj = $this->TempBagModel->where('ip_address',$ip_address)
                              ->where('user_session_id',$session_id)->first();
          
          $product_obj = $this->ProductsModel->where('id',$product_id)->first();
            $new_arr = [];

          if($product_obj)
          {
            $product_arr = $product_obj->toArray();

            $new_arr['product_id']    = $product_id;           
            $new_arr['item_qty']      = $item_qty;    
            $new_arr['maker_id']      = $product_arr['user_id'];    
                $new_arr['sku_no']        = $sku_no;
                
                $new_arr['retail_price'] = $product_arr['retail_price'];                
                $new_arr['total_price']  = $item_qty * $product_arr['retail_price'];    

                $new_arr['wholesale_price'] = $product_arr['unit_wholsale_price'];
                $new_arr['total_wholesale_price'] = $item_qty * $product_arr['unit_wholsale_price']; 

          }
            
          if($exist_obj)
          {
              $exist_arr = $exist_obj->toArray();
                $json_data = [];            
                $json_decoded_data = json_decode($exist_arr['product_data'],true);

                /* Update product details, if product are already available on cart */
                $data = isset($json_decoded_data['sku'][$new_arr['sku_no']])?$json_decoded_data['sku'][$new_arr['sku_no']]:false;

                if(isset($data) && !empty($data))
                {
                    $qty = $data['item_qty'] + $item_qty;

                    $retail_price      = $qty * $product_arr['retail_price'];
                    $whole_sale_price  = $qty * $product_arr['unit_wholsale_price'];
                    
                    $new_arr['item_qty'] = $qty;
                    $new_arr['total_price'] = $retail_price;
                    $new_arr['total_wholesale_price'] = $whole_sale_price; 
                }
                
                /* -------------- End --------------------- */
                $json_decoded_data['sku'][$new_arr['sku_no']] = $new_arr;
                array_push($json_decoded_data['sequence'],$sku_no);

              $update_arr['product_data']            = json_encode($json_decoded_data,true);  

              $is_updated = $this->TempBagModel->where('ip_address',$ip_address)
                                   ->where('user_session_id',$session_id)->update($update_arr);

              if($is_updated)
              {  
                DB::commit();
                  $response['status']      = 'SUCCESS';
                    $response['bag_count']   = get_bag_count();
                  $response['description'] = 'Product added to cart succcessfully';
              }
              else
              {
                DB::rollback();
                  $response['status']      = 'FAILURE';
                  $response['description'] = 'Something went wrong please try again later';                   
              }
          }
          else
          {
              //create
            $arr_cart_data = [];
                $arr_sequence  = [];
                $arr_final     = [];

                //change key product id to sku id
                $arr_cart_data[$new_arr['sku_no']] = $new_arr;
                $arr_sequence[0] = $sku_no;      

                $arr_final['sku']      = $arr_cart_data;                  
                $arr_final['sequence'] = $arr_sequence;   
                     
            // array_push($arr_cart_data, $new_arr);
              $encoded_new_arr = json_encode($arr_final);
              //dd($encoded_new_arr);
              $insert_arr['product_data']    = $encoded_new_arr;
              $insert_arr['ip_address']      = $ip_address;
                $insert_arr['user_session_id'] = $session_id;
                
              $is_created = $this->TempBagModel->create($insert_arr);

              if($is_created)
              {
                DB::commit();
                  $response['status']      = 'SUCCESS';
                    $response['bag_count']   = $bag_count;
                  $response['description'] = 'Product added to cart succcessfully';
              }
              else
              {
                DB::rollback();
                  $response['status']      = 'FAILURE';
                  $response['description'] = 'Something went wrong please try again later';
              }
          }

        }catch(Exception $e)
        {
          DB::rollback();
          $response['status']      = 'FAILURE';
          $response['description'] = $e->getMessage();
        }

        return response()->json($response);

        if (isset($enc_id) && $enc_id != '') {
            
            $product_id = base64_decode($enc_id);
        }
        if ($product_id) {

            $product_details = $this->ProductModel->where('id',$product_id)->first();

            if ($product_details) {

                $quantity = 1;

                $cart = new Cart();

                $cart->add([
                    'id'       => $product_id,
                    'name'     => $product_details['product_name'],
                    'quantity' => $quantity,
                    'price'    => $quantity * $product_details['unit_price']
                ]);

                if ($cart) {

                    $bag_data = [];
                    $user = Sentinel::check();

                    /*Check duplication of item*/
                    $is_item = $this->TempBagModel->where([['product_id',$product_id],['buyer_id',$user->id]])->first();


                    if (count($is_item) > 0) {

                        $bag_data['quantity'] = $is_item['quantity']+1;

                        $update_item = $this->TempBagModel->where([['product_id',$product_id],['buyer_id',$user->id]])->update($bag_data);

                        if ($update_item) {
                            return redirect('/my_bag');
                        }
                    }
                  
                    else{

                        $bag_data['buyer_id'] = $user->id;
                        $bag_data['product_id'] = $product_id;
                        $bag_data['quantity'] = 1;

                        $add_item = $this->TempBagModel->create($bag_data);
                        if ($add_item) {
                            return redirect('/my_bag');
                        }
                    }
                    
                    
                }
            }
        }
        
       
    }

    public function remove_product($enc_id)
    {
        if (isset($enc_id) && $enc_id != '') {
            
            $product_id = base64_decode($enc_id);
        }
        if ($product_id) {

            $user = Sentinel::check();

            $remove_item = $this->cart->remove($product_id); //from cart
            $remove_item = $this->TempBagModel->where([['product_id',$product_id],['buyer_id',$user->id]])->delete(); // From table

            if ($remove_item) {
                return redirect()->back();
            }
        }
    }

    public function checkout_order(Request $request)
    {
       $form_data = $request->all();
       $order_placed = $this->OrderService->checkout_order_address($form_data);
       if($order_placed['status']=='SUCCESS'){
        return $order_placed;
       }else{
        return $order_placed;
       }

    }
    
    public function change_shipping_address(Request $request)
    {
      $form_data = $request->all();

      $current_password = $request->current_password;

      if(isset($current_password) && !empty($current_password))
      {
        $existsornot =   $this->does_old_password_exist($current_password);

        if($existsornot==1)
        {

        }else
        {
           $response['status'] = 'error';
           $response['description'] = 'Please provide valid password';
           return response()->json($response); 
        }
      }

      $shipping_details['first_name']= $request->new_first_name;
      $shipping_details['last_name']= $request->new_last_name;
      $shipping_details['street_address']= $request->new_shipping_address;
      $shipping_details['state']= $request->new_shipping_state;
      $shipping_details['country']= $request->new_shipping_country;
      $shipping_details['zipcode']= $request->new_shipping_zipcode;
      $shipping_details['city']= $request->new_shipping_city;
      $shipping_details['billing_street_address']= $request->new_billing_address;
      $shipping_details['billing_state']= $request->new_billing_state;
      $shipping_details['billing_country']= $request->new_billing_country;
      $shipping_details['billing_zipcode']= $request->new_billing_zipcode;
      $shipping_details['billing_city']= $request->new_billing_city;

      $shipping_details['date_of_birth']= $request->shipping_dob_change_input;
      $shipping_details['phone']= $request->phone;


      $shipping_details['approve_status']= "1";

         /*************chk country*state**************************/

          $countries_obj = $this->CountriesModel->where('id',$request->new_shipping_country)->first();
          if ($countries_obj) {
              $countries_arr = $countries_obj->toArray();
              if( $countries_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['description'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }

          }//if country obj

           $states_obj = $this->StatesModel->where('id', $request->new_shipping_state)->first();
           if ($states_obj) {
            $states_arr = $states_obj->toArray();
             if( $states_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['description'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }
          }//if state obj

           $countries_obj = $this->CountriesModel->where('id',$request->new_billing_country)->first();
          if ($countries_obj) {
              $countries_arr = $countries_obj->toArray();
              if( $countries_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['description'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }

          }//if country obj

           $states_obj = $this->StatesModel->where('id', $request->new_billing_state)->first();
           if ($states_obj) {
            $states_arr = $states_obj->toArray();
             if( $states_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['description'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }
          }//if state obj
          
        /*************chk country**state*************************/





      $getaddress = $this->UserModel->where('id',$request->shippingaddresschange_buyer_id)->update($shipping_details);

      if($getaddress)
      {
        $response['status']="success";
        $response['description']="Shipping & Billing address updated successfully.";
      }else{
        $response['status']="failed";
      }
      return response()->json($response);      

    }


    public function place_order(Request $request)
    {
       $loggedinId = '';

       $out_of_stock_arr = [];

       $user = Sentinel::check();

       if(isset($user))
       {
          $loggedinId = $user->id; 
       }
      
       $form_data = $request->all();
      

      if ($form_data) 
      {

              
          if(isset($form_data['amount']) && !empty($form_data['amount']) && $form_data['amount']<=0)
          {
             $response_arr['status']  = 'failure';
             $response_arr['msg']     = 'You can apply a minimum of $1 amount from card detail to this order';
             return $response_arr;
          }
          
     
        /*------check out of stock product---------*/
        
        $cart_item_arr = $product_arr = [];

        $cart_item = $this->TempBagModel->where('buyer_id',$loggedinId)->first();
 
        if($cart_item)
        {

           $bag_arr = $cart_item->toArray();
          
           $data_arr = json_decode($bag_arr['product_data'],true);
           $product_data_arr = $data_arr['product_id'];
            
           $product_ids_arr  = array_column($product_data_arr, 'product_id');

        } //if

   
         $product_arr = $this->ProductModel
                            ->whereIn('id',$product_ids_arr)
                            ->with(['inventory_details'])
                            ->get()
                            ->toArray();
      
          if(isset($product_arr) && count($product_arr)>0)
          {
              foreach($product_arr as $key => $product)
              {
                 if(isset($product['is_outofstock']) && $product['is_outofstock'] == 1 ||
                      isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] == 0
                    )
                  {
                      $out_of_stock_arr[] = $product['id'];
                  }
              }


              if(count($out_of_stock_arr)>0)
              {
                  $response_arr['status']  = 'failure';
                  $response_arr['msg']     = 'Please remove out of stock product from cart';
                  return $response_arr;
              }


          }//if


        /*-----------end-of---check out of stock product------------------------*/


        $payment_status = $this->OrderService->process_payment($form_data);

             
      }
      try
      {
        if ($payment_status['status']=='SUCCESS') 
        {

          $authorize_transaction_status = $payment_status['authorize_transaction_status'];
           
          $order_data = $this->OrderService->generate_order($payment_status['transaction_id'],$form_data,$payment_status=1,$authorize_transaction_status);

          if ($order_data['status'] == 'success') {
            $response_arr['status']   = 'success';
            $response_arr['order_no']   = $order_data['order_no'];
            $response_arr['total_amt']   = $order_data['total_amt'];
            $response_arr['msg']   = 'Order placed successfully.';
        
            return $response_arr;
          } 
        }
        elseif ($payment_status['status']=='PENDING') 
        {
          $authorize_transaction_status = $payment_status['authorize_transaction_status'];

          $order_data = $this->OrderService->generate_order($payment_status['transaction_id'],$form_data,$payment_status=0,$authorize_transaction_status);
          
          if ($order_data['status'] == 'success') {
            $response_arr['status']   = 'success';
            $response_arr['order_no']   = $order_data['order_no'];
            $response_arr['total_amt']   = $order_data['total_amt'];
            $response_arr['msg']   = 'Order placed successfully.';
        
            return $response_arr;
          } 
        }
        else if($payment_status['status']=="cardyearfailure")
        {
           $response_arr['status']  = 'failure';
           $response_arr['msg'] = $payment_status['msg'];
           return $response_arr;
        }
         else if($payment_status['status']=="cardmonthfailure")
        {
           $response_arr['status']  = 'failure';
           $response_arr['msg'] = $payment_status['msg'];
           return $response_arr;
        }
        else 
        {
          $response_arr['status']  = 'failure';
        //  $response_arr['msg']   = 'Your order can not be placed.';
          $response_arr['msg']     = 'Check with your bank.';
          $response_arr['notplacedmsg'] = 1;
          // $response_arr['data']   = json_encode($payment_status);
         
          return $response_arr;
        }
      }
      catch(Exception $e)
      {
        
        $response_arr['status']   = 'failure';
        $response_arr['msg']   = $e->getMessage();
        
        return $response_arr;
      }
      
      
    }

   // public function order_final_step($enc_id)
     public function order_final_step($thankyouforshopping,$enc_id,$total_amt=NULL)
    {

      $chekorderexists = $this->TransactionModel->where('order_no',$enc_id)
      //->where('total_price',$total_amt)
      ->first();
      if(isset($chekorderexists) && !empty($chekorderexists))
      {
        $chekorderexists = $chekorderexists->toArray();
       

         $total_amt = isset($chekorderexists['total_price'])?$chekorderexists['total_price']:'';
      


        $get_order_details = $this->OrderModel->with('buyer_details.buyer_detail'
          ,'order_product_details.product_details','order_product_details.product_details.first_level_category_details.age_restriction_detail')
           ->where('order_no',$enc_id)->get();
        if(isset($get_order_details) && !empty($get_order_details))
        {
          $get_order_details = $get_order_details->toArray();
          // dd($get_order_details);
           $buyeragerestrictionflag =0;
            foreach($get_order_details as $order_details)
            {
               $order_product_details = isset($order_details['order_product_details'])?
                 $order_details['order_product_details']:[];  
                  

                 foreach($order_product_details as $product)
                 {    
                     
                      
                     // $is_age_limit = isset($product['product_details']['is_age_limit'])?$product['product_details']['is_age_limit']:'';

                     //  $age_restriction = isset($product['product_details']['age_restriction'])?$product['product_details']['age_restriction']:'';

                    $is_age_limit = isset($product['product_details']['first_level_category_details']['is_age_limit'])?$product['product_details']['first_level_category_details']['is_age_limit']:'';

                     $age_restriction = isset($product['product_details']['first_level_category_details']['age_restriction'])?$product['product_details']['first_level_category_details']['age_restriction']:'';

                      $buyer_age_approvestatus = isset($order_details['buyer_details']['buyer_detail']['approve_status'])?$order_details['buyer_details']['buyer_detail']['approve_status']:'';

                     if(isset($is_age_limit) && !empty($is_age_limit) && isset($age_restriction)
                       && isset($buyer_age_approvestatus) && $buyer_age_approvestatus!="1")
                     {
                        $buyeragerestrictionflag++;
                     }
                 }//foreach 
            }
              
        }//if isset

        // get order data for place order event

          
            $order_obj = $this->OrderModel->with('buyer_details','seller_details','address_details.state_details','address_details.country_details','address_details.billing_state_details','address_details.billing_country_details',
                'order_product_details.product_details.product_images_details','order_product_details.product_details.age_restriction_detail','transaction_details','seller_details.seller_detail')
            ->where('order_no',$enc_id)->get();

            if(isset($order_obj) && !empty($order_obj))
            {
                $order_details_arr    = $order_obj->toArray();
            } 








       // $order_no = isset($enc_id)?base64_decode($enc_id):'#0000000000';
        $order_no = isset($enc_id)?$enc_id:'#0000000000';
        $this->arr_view_data['page_title'] = 'Order';
        $this->arr_view_data['order_no'] = $order_no;
        $this->arr_view_data['total_amt'] = $total_amt;
        $this->arr_view_data['buyeragerestrictionflag'] = $buyeragerestrictionflag;
       
        $this->arr_view_data['order_details_arr']    = isset($order_details_arr)?$order_details_arr:[];

        return view($this->module_view_folder.'.final_order',$this->arr_view_data);  
      }
      else
      {
        $this->arr_view_data['order_no'] = '';
        $this->arr_view_data['total_amt'] = '';
        $this->arr_view_data['buyeragerestrictionflag'] = '';
        $this->arr_view_data['page_title'] = 'No Order Available';
        return view($this->module_view_folder.'.final_order',$this->arr_view_data);
      }//else

    }//end function

    public function get_ip_address()
    {
         $ip_address = \Request::ip();
         return $ip_address;
    }
    public function get_session_id()
    {
         $session_id = session()->getId();
         return $session_id;
    }//get_session_id


    public function process_signup_checkout(Request $request)
    { 
        $status = false; 
        $response = [];

        $form_data = $request->all();

         $loguser = Sentinel::check();  


        $user_role = isset($form_data['role'])?$form_data['role']:'';
        $email   = isset($form_data['email'])?$form_data['email']:'';
        $password   = isset($form_data['password'])?$form_data['password']:'';


        $arr_rules = [
                        'email' => 'required|email',
                        'password' => 'required'
                     ];


        if(Validator::make($form_data,$arr_rules)->fails())
        {   
            $msg = Validator::make($form_data,$arr_rules)->errors()->first();

            $response = [
                           'status' =>'ERROR',
                           'msg'    => $msg
                        ];
            //Flash::success(str_singular($this->module_title).' Saved Successfully');
            return response()->json($response);     
        }             



       /*Check provided email is natcasesort(array)ot blank or invaild*/ 
        if(!isset($email) || (isset($email) && $email == '')){
          $response['status'] = 'ERROR';
          $response['msg']    = 'Provided email should not be blank or invalid';
          $response['type']   = 'Invalid'; 
         // return $response;
            return response()->json($response); 
        } 


        if(!isset($password) || (isset($password) && $password == '')){
            $response['status'] = 'ERROR';
            $response['password_msg']    = 'Provided password should not be blank or invalid';

            return response()->json($response); 
         }


         if(isset($form_data['password'])){
           if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}$/', $form_data['password']))
           {
               $response['status'] = 'ERROR';
               $response['password_msg'] = 'Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character.';
               return response()->json($response); 
           }
        }//if password


        /*check email duplication*/
          if(Sentinel::findByCredentials(['email'=>$email,'user_type'=>'buyer','deleted_at!'=>NULL ]) != null)
          {

            $response['status'] = 'ERROR';
            $response['msg']    = 'Provided email already exists in system, Please sign in';
            $response['type'] = 'activated';  
            return response()->json($response);
          }//if sentinel email


          /* check email validation */
           $recheck_user = DB::table('users')->select('email')->where('email', $email)->where('user_type', 'buyer')->where('deleted_at','!=',NULL)->first();
           if($recheck_user)
           {
              $response['status'] = 'ERROR';
              $response['msg']    = 'Provided email has been deactivated, please contact the admin to reactivate it. ';
              $response['type'] = 'deactivated';

            return response()->json($response);
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
                      $response['status'] = 'ERROR';
                      $response['msg']    = 'Please use valid email this email is not supported.';
                      $response['type']   = 'Notsuppored';  
                      return response()->json($response);
                 }  

              }//arrayResult
              
      /***********Email validation library code*end****************/

     



      try{

          DB::beginTransaction();

          $hasher      = Sentinel::getHasher();
          $data        = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
          //$password    =  substr(str_shuffle($data), 0, 8);
        
          $user =  Sentinel::createModel()->firstOrNew(['email' => $email]);
          $create_actcode = unique_code(8);

          $credentials      = [];
          $user->email      = $email;
          if(isset($password) && !empty($password))
          {
            $user->password  = $hasher->hash($password);
          }
          //$user->password   = $password;
          $user->user_type  = 'buyer';
          $user->is_active  = '1';
          $user->is_trusted = '1';
          $user->activationcode = $create_actcode;
          $user->is_checkout_signup = 1;
          $user->is_guest_user = 1;
          $user->is_password_changed=0;
          $user_details     = $user->save();

          if($user_details)
          {

                // create activation table entry
                $activation = Activation::create($user);    
                if($activation)
                {
                  Activation::complete($user,$activation->code);
                }

                //create buyer table entry
                $arr_buyer = [];        
                $arr_buyer['user_id']           = $user->id;
                $arr_buyer['sorting_order_by']  = date('Y-m-d H:i:s');              
                $store_buyer_details = $this->BuyerModel->create($arr_buyer); 
                

                // Attach role to user
                $role = Sentinel::findRoleBySlug('buyer');
                $role->users()->attach($user);


                $remember_me = false;
                $credentials = [
                    'email'    => $email,
                    'password' => $password,
                ];


                //check user details
                $user = Sentinel::findByCredentials($credentials);

                //make autologin
                $chk_auth = Sentinel::login($user);

                if($chk_auth){

                  $session_id = $this->get_session_id();
                  $ip_address = $this->get_ip_address();

                   $checkcartdata_atlogin=[];

                   $checkcartdata_atlogin = $this->checkcartdata_atlogin($session_id,$ip_address);
                   if(isset($checkcartdata_atlogin) && !empty($checkcartdata_atlogin))
                   {
                      $update_cartdataat_login =  $this->update_cartdataat_login($checkcartdata_atlogin);
                   }

                    $admin_role = Sentinel::findRoleBySlug('admin');  
                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }
                  
                  //send email to user with login credentials
                  $arr_mail_data    = $this->built_mail_data($email,$password);   
                  $email_status     = $this->EmailService->send_mail_section($arr_mail_data);

                   DB::commit();
                  $response['status'] = 'SUCCESS';
                  $response['msg']    = 'You have successfully registered as a buyer.';
                  $response['type']   = 'loggedin';  

                }
                else
                {
                    DB::rollback();
                    $response['status'] = 'ERROR';
                    $response['msg']    = 'Something went wrong.';
                }

          }//if userdetails
          else
          {
              DB::rollback();
              $response['status'] = 'ERROR';
              $response['msg']    = 'Something went wrong.';
          }

        }//try
        catch(Exception $e){
            DB::rollback();
           $response['status'] = 'ERROR';
           $response['msg']    = $e->getMessage();
        }
         
          return response()->json($response);

    }//process_signup_checkout

     public function built_mail_data($email,$password)
    {
      $user = $this->get_user_details($email);
      
      if($user)
      {
        $arr_user = $user->toArray();

        $login_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url("/login").'">Login Now</a><br/>' ;


        $arr_built_content = [
                                'FIRST_NAME'   => $arr_user['first_name'],
                                'APP_URL'      => config('app.project.name'),
                                'LOGIN_URL'    => $login_url,
                                'EMAIL'        => $email,
                               // 'PASSWORD'     => $password
                             ];

        $arr_mail_data                      = [];
        $arr_mail_data['email_template_id'] = '146';
        $arr_mail_data['arr_built_content'] = $arr_built_content;
        $arr_mail_data['arr_built_subject'] = '';
        $arr_mail_data['user']              = $arr_user;

        return $arr_mail_data;
      }
      return FALSE;
    }

    public function  get_user_details($email)
    {

        $credentials = ['email' => $email];
        $user = Sentinel::findByCredentials($credentials); // check if user exists

        if($user)
        {
          return $user;
        }
        return FALSE;
    }


    public function checkcartdata_atlogin($session_id="",$ip_address="")
    {

       $bag_obj=[];
       if(isset($session_id) && isset($ip_address)){
         $session_id = $session_id;
         $ip_address = $ip_address;
         $user = Sentinel::check();
         $loggedIn_Id = 0;

          if($user)
          {
            $loggedIn_Id = $user->id;  
          }

           $bag_obj = $this->TempBagModel->where('buyer_id',0)
               ->where('user_session_id',$session_id)
               ->where('ip_address',$ip_address)
               ->first();
           if(isset($bag_obj) && !empty($bag_obj))
           {
             $bag_obj = $bag_obj->toArray();
           }    
           
          return $bag_obj;
        }//isset session id and ip address

    }//end check cart data

     public function get_items()
    {
            
      $loginuser_id = 0;

      $user = Sentinel::check();

      if($user)
      {
        $loginuser_id = $user->id;
      }

      $ip_address = $this->get_ip_address();
      $session_id = $this->get_session_id();
        
        if($user)
        {
         $bag_obj =  $this->TempBagModel
                        ->where('user_session_id',$session_id)
                        ->where('ip_address',$ip_address)
                        ->where('buyer_id',0)
                        ->orderBy('id','desc')->first();
        }
       // }else{
       //    $bag_obj =  $this->TempBagModel
       //                ->where('buyer_id',$loginuser_id)
       //                ->orderBy('id','desc')->first();
       // }//else 


       return $bag_obj;

    }//get_items function


    public function get_both_items()
    {
            
      $loginuser_id = 0;

      $user = Sentinel::check();

      if($user)
      {
        $loginuser_id = $user->id;
      }

      $ip_address = $this->get_ip_address();
      $session_id = $this->get_session_id();
        
        if($loginuser_id==0)
        {
         $bag_obj =  $this->TempBagModel
                        ->where('user_session_id',$session_id)
                        ->where('ip_address',$ip_address)
                        ->where('buyer_id',$loginuser_id)
                        ->orderBy('id','desc')->first();
        
       }else{
          $bag_obj =  $this->TempBagModel
                      ->where('buyer_id',$loginuser_id)
                      ->orderBy('id','desc')->first();
       }//else 


       return $bag_obj;

    }//get_items function

     public function update_cartdataat_login($cartdataatlogin)
    { 

       //if(isset($cartdataatlogin) && !empty($cartdataatlogin))
       //{

            $user = Sentinel::check();

            if($user)
            {
              $user_id = $user->id;
            }

            $ip_address = $this->get_ip_address();
            $session_id = $this->get_session_id();

            $get_sessioncart_data = $this->get_items();
            $get_usercartdata    = $this->get_both_items();



            if(isset($get_usercartdata) && !empty($get_usercartdata))
            {

                $get_usercartdata = $get_usercartdata->toArray();

                $user_cart_json_data = [];            
                $user_cart_json_decoded_data = isset($get_usercartdata['product_data'])? json_decode($get_usercartdata['product_data'],true):[];
                
                $get_sessioncart_data = $get_sessioncart_data->toArray();



                $session_cart_json_data = [];            
                $session_cart_json_decoded_data = isset($get_sessioncart_data['product_data'])? json_decode($get_sessioncart_data['product_data'],true):[];
                      
                                         
                $update_arr =  $new_arr = $seq = $final=[];
                $update_arr =  array_merge($user_cart_json_decoded_data['product_id'],$session_cart_json_decoded_data['product_id']);


                if(isset($update_arr) && !empty($update_arr))
                {
                    foreach($update_arr as $kk=>$val)
                     {
                     
                        $new_arr['product_id'][$val['product_id']] = $val;
                        $seq[] = $val['product_id'];
                        $new_arr['sequence'] = $seq;
                     }
                   $final['product_data'] = json_encode($new_arr,true);     
                }
              
                    $is_updated = $this->update($final);

                    if($is_updated)
                    {
                      $delete_session_cart_data = $this->TempBagModel->where('user_session_id',$session_id)->where('id',$get_sessioncart_data['id'])->delete();
                    }
                    return true;
            }
            else
            {
                $update_arr = array(
                  'buyer_id'=> $user_id
                );
                $update_cart_data = $this->TempBagModel->where('user_session_id',$session_id)->where('id',$get_sessioncart_data['id'])->update($update_arr);

                return true;
            }//else


      // }
     
    }//end function update_cartdataat_login


     public function update($prduct_arr)
    {
      $user_id = 0; $bag_obj=[];

      $user = Sentinel::check();

      if($user)
      {
        $user_id = $user->id;
      }

      $ip_address = $this->get_ip_address();
      $session_id = $this->get_session_id();

      $arr_criteria = [
        'buyer_id' => $user_id
      ];

      if($user_id == 0)
      {
        $arr_criteria['user_session_id'] = $session_id;
      }

      if(isset($prduct_arr) && !empty($prduct_arr))
      {
        return $bag_obj = $this->TempBagModel->where($arr_criteria)->update($prduct_arr);
      }else{
        return $bag_obj;
      }

    }//if update function


    // start of forgot_password function
    public function forgot_password(Request $request)
    {
            $email = $request->input('email');
            if(isset($email) && !empty($email)){

            $credentials['email'] = $request->input('email');
            $user = Sentinel::findByCredentials($credentials);
            if($user)
            {
                      /***************Email*valiation library code*******/
                      $validator = EmailValidatorFactory::create($request->input('email'));
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
                            $response['status'] = 'ERROR';
                            $response['message']    = 'Please use valid email this email is not supported.';
                            return response()->json($response);
                         }//else  

                      }//if arrayResult

                     /***********Email validation library code*end****************/


                      $setname ='';
                      if($user->inRole('seller')==true)
                      {
                           $get_seller_detail = SellerModel::where('user_id',$user->id)->first();
                           if(!empty($get_seller_detail)){
                             $get_seller_detail = $get_seller_detail->toArray();
                             if($user->first_name=="" && $user->last_name==""){
                               $setname =    $user->email; 
                             }else{
                               $setname = $user->first_name;
                             }
                           }
                      }
                      else if($user->inRole('buyer')==true)
                      {
                          if($user->first_name=="" || $user->last_name==""){
                              $setname = "Buyer";
                          }else{
                               $setname = $user->first_name;
                          }
                      }


                      if ($user->inRole('admin') == false) 
                      {
                          $reminder = Reminder::create($user);

                          $password_reset_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url('/').'/reset_password/'.$reminder->code.'">Reset Password</a><br/>';
                     
                          $arr_built_content = [
                                               // 'FIRST_NAME'     => $user->first_name,
                                                'FIRST_NAME'     => $setname,
                                                'REMINDER_URL'   => $password_reset_url,
                                                'EMAIL'          => $user->email,
                                                'SITE_URL'       => config('app.project.name')];

                          $arr_mail_data['email_template_id'] = '7';
                          $arr_mail_data['arr_built_content'] = $arr_built_content;
                          $arr_mail_data['arr_built_subject'] = '';
                          $arr_mail_data['user']              = $user;

                          try{                
                              $is_mail_sent = $this->EmailService->send_mail_section($arr_mail_data);
                       
                          }catch(\Exception $e){
                              $response['status']   = 'ERROR';
                              $response['message']  = $e->getMessage();

                              return response()->json($response);
                          }

                          $response['status']  = 'SUCCESS';
                          $response['message'] = 'Email sent to '.$user->email.', please check your email account for further instructions.';

                          return response()->json($response);
                      }//if admin role false
                      else{

                          $response['status']   = 'ERROR';
                          $response['message']  = "Please enter user email id";

                          return response()->json($response);
                      }//else of amin 


                
            }//if user
            else{

                $response['status']   = 'ERROR';
                $response['message']  = "Account does not exist with this <b>".$credentials['email']."</b>, please try another one.";

                return response()->json($response);
            }           

          }else{

                $response['status']   = 'ERROR';
                $response['message']  = "Something went wrong.";
                return response()->json($response);
          } //if isset email 
       
       
    }//end forgot_password

     public function does_old_password_exist($password)
    {
        $user = Sentinel::check();

        $credentials['password'] = $password;
        if(Sentinel::validateCredentials($user,$credentials)==true) 
        {
            return 1;            
        }
        else
        {
            return 0;
        }

    }//end 


    function applywalletamount(Request $request)
    {
       $response =[];
       $wallet_amount = $request->wallet_amount;
       $order_amount = $request->amount;


       if(isset($wallet_amount) && !empty($wallet_amount) && isset($order_amount) && !empty($order_amount))
       {
          $loggedIn_Id = 0;
          $loginuser = Sentinel::check();
          if ($loginuser) 
          {
              $loggedIn_Id = $loginuser->id;
          }

          $check_total_wallet_amount = $this->BuyerWalletModel->where('user_id',$loggedIn_Id)
          ->sum('amount');

          if(isset($check_total_wallet_amount) && $check_total_wallet_amount>0)
          {

             if(isset($wallet_amount) && $wallet_amount>0)
             {
              if($wallet_amount<=$check_total_wallet_amount)
              {

                  if($wallet_amount>=$order_amount)
                  {
                    $total_amount = (float)$order_amount-(float)1;

                     if(isset($total_amount) && $total_amount>0)
                     {
                          $response['status'] = 'ERROR'; 
                          $response['message'] = "You can only apply a maximum of (".'$'.$total_amount.") to this order";
                          return response()->json($response);
                     }// isset total_amount

                  
                  }
                  else
                  {
                      $exisiting_wallet_data = Session::get('sessionwallet_data');
                      $exisiting_wallet_data = is_array($exisiting_wallet_data) ? $exisiting_wallet_data: [];
                      $exisiting_wallet_data['amount'] = $wallet_amount;
                      $exisiting_wallet_data['buyer'] = $loggedIn_Id;
                      Session::put('sessionwallet_data',$exisiting_wallet_data);
                      $response['status'] = 'SUCCESS'; 
                      $response['description'] = "Wallet Amount Applied Succcessfully";
                      return response()->json($response);

                  }//else
              }
              else
              {
                 $response['status']   = 'ERROR';
                 $response['message']  = "Your reedem amount is greater than wallet amount.";
                 return response()->json($response);
              }
            } // wallet_amount
            else
            {
                $response['status']   = 'ERROR';
                $response['message']  = "Something went wrong.";
                return response()->json($response);
            }
          }
          else
          {   

             $response['status']   = 'ERROR';
             $response['message']  = "You dont have sufficient balance in your wallet.";
             return response()->json($response);

          }//else of wallet amount is 0


       }//isset wallet_amount
       else
       {
          $response['status']   = 'ERROR';
          $response['message']  = "Something went wrong.";
          return response()->json($response);
       }

    }//end applywalletamount


   function clearwallet_amount(Request $request)
   {
     $response =[];
     $buyerid = $request->buyerid;
     if(isset($buyerid))
     {

         $buyer_wallet    = Session::get('sessionwallet_data');

              $buyer_wallet_data   = is_array($buyer_wallet) ? $buyer_wallet: [];

              unset($buyer_wallet_data['buyer']);
              unset($buyer_wallet_data['amount']);

              Session::put('sessionwallet_data',$buyer_wallet_data);


              $response['status']         = 'SUCCESS';
              $response['description']    = "Wallet amount cleared succcessfully";
              return response()->json($response);

     }
     else
     {
          $response['status']   = 'ERROR';
          $response['description']  = "Something went wrong.";
          return response()->json($response);
     }

   } // clearwallet_amount


 

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


             

}//class
