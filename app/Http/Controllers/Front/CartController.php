<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProductCommentModel;
use App\Models\ProductModel;
use App\Models\TempBagModel; 
use App\Models\SellerModel;
use App\Models\UserModel;
use Anam\Phpcart\Cart;
use App\Models\ProductInventoryModel;
use App\Models\BuyerCouponModel;


use Validator;
use Sentinel;
use DB;
use Flash;
use Session;

class CartController extends Controller
{
    public function __construct(
                                 ProductCommentModel $ProductCommentModel,
                                 ProductModel $ProductModel,
                                 TempBagModel $TempBagModel,
                                 UserModel $UserModel,
                                 SellerModel $SellerModel,
                                 Cart $Cart,
                                 ProductInventoryModel $ProductInventoryModel,
                                 BuyerCouponModel $BuyerCouponModel
                               )
    {
        $this->ProductCommentModel     = $ProductCommentModel;
        $this->ProductModel            = $ProductModel;
        $this->TempBagModel            = $TempBagModel;
        $this->UserModel            = $UserModel;
        $this->SellerModel            = $SellerModel;
    	$this->cart                    = $Cart;
        $this->ProductInventoryModel   = $ProductInventoryModel;
        $this->BuyerCouponModel        = $BuyerCouponModel; 

        $this->module_view_folder      = 'front.cart';  
    	$this->module_title              = 'My Cart';
        $this->back_path               = url('/');  
        $this->arr_view_data           = [];
        $this->product_image_base_img_path   = base_path().config('app.project.img_path.product_images');
        $this->product_image_public_img_path = url('/').config('app.project.img_path.product_images');
    }

    public function get_ip_address()
    {
         $ip_address = \Request::ip();
         return $ip_address;
    }
    public function get_session_id()
    {
         $session_id = session()->getId();
         return $session_id;
    }
    public function check_auth()
    {
        return \Sentinel::check();
    }


    public function index()
    {
        $bag_arr  = $product_data_arr = $product_arr = $cart_product_arr = $maker_details_arr = [];
        $arr_final_data = [];
        $subtotal       = 0;
        $maintotal      = 0;
        $shippingsubtotal      = 0;
        $wholesale_subtotal = 0;

        $user = Sentinel::check();
        $loggedIn_Id =0;
        if($user)
        {
          $loggedIn_Id = $user->id;
        }
        $session_id = $this->get_session_id();
        $ip_address = $this->get_ip_address();
      

       // $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();

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


        if($bag_obj)
        {
            $bag_arr          = $bag_obj->toArray();

            $data_arr = json_decode($bag_arr['product_data'],true);
            $product_data_arr = $data_arr['product_id'];
            
            $product_ids_arr  = array_column($product_data_arr, 'product_id');

            $product_arr = $this->ProductModel->whereIn('id',$product_ids_arr)->with('product_images_details','age_restriction_detail','get_brand_detail','get_seller_details.seller_detail','first_level_category_details','first_level_category_details.age_restriction_detail')->get()->toArray(); 

 
            
            
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
                    $cart_product_arr[$key]['age_restriction']    = $product['age_restriction'];
                    /*$cart_product_arr[$key]['product_image']  = get_sku_image($sku_no);*/
                    $cart_arr[$key]['total_price']    = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'0';
                    
                    
                    $cart_product_arr[$key]['unit_price']    = $product['unit_price'];
                    $cart_product_arr[$key]['price_drop_to']    = $product['price_drop_to'];
                    $cart_product_arr[$key]['shipping_charges']    = $product['shipping_charges'];
                    if($cart_product_arr[$key]['price_drop_to']>0)
                    {
                        $cart_product_arr[$key]['total_price']    = $product['price_drop_to'] * $cart_arr[$key]['total_price'];
                    }else{
                        $cart_product_arr[$key]['total_price']    = $product['unit_price'] * $cart_arr[$key]['total_price'];
                    }

                    $cart_product_arr[$key]['item_qty']       = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'';

                    $cart_product_arr[$key]['product_seller_detail']  = $product['get_seller_details'];

                    $cart_product_arr[$key]['is_chows_choice']    = $product['is_chows_choice'];
                    $cart_product_arr[$key]['product_certificate']    = $product['product_certificate'];
                    $cart_product_arr[$key]['spectrum']    = $product['spectrum'];
                   
                    $cart_product_arr[$key]['first_level_category_details']    = isset($product['first_level_category_details'])?$product['first_level_category_details']:[];
                   
                    $cart_product_arr[$key]['is_outofstock'] = isset($product['is_outofstock'])?$product['is_outofstock']:[];


                    
                }       
                
                $maintotal = array_sum((array_column($cart_product_arr,'total_price')));
                $shippingsubtotal = array_sum((array_column($cart_product_arr,'shipping_charges')));
                //$wholesale_subtotal = array_sum((array_column($cart_product_arr,'total_wholesale_price')));  
            }        
           
            $arr_prefetch_user_id = array_unique(array_column($cart_product_arr, 'user_id'));
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
                                            ->whereIn('id',$arr_prefetch_user_id)->get()->toArray(); 
           
            $arr_prefetch_user_ref = array_column($arr_prefetch_user_ref,null, 'id');
            
            $product_sequence     = ""; 
            $arr_product_sequence = $arr_sequence = [];
            $arr_sequence         = $data_arr['sequence'];
           // dd($arr_prefetch_user_ref);
            if(isset($cart_product_arr) && sizeof($cart_product_arr)>0)
            {
                foreach($cart_product_arr as $key => $value) 
                {

                    $arr_final_data[$value['user_id']]['product_details'][$value['product_id']] = $value;
                    $arr_final_data[$value['user_id']]['seller_details'] = isset($arr_prefetch_user_ref[$value['user_id']]) ? $arr_prefetch_user_ref[$value['user_id']] : [];

                    //$arr_product_sequence[$product_sequence] = $arr_final_data;   
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
                    
                    //array_reverse($arr_relavant_sequence);
                    $arr_final_data[$_key]['product_details'] = $arr_relavant_sequence;                    
                }
            }  
        }

  


        $this->arr_view_data['arr_final_data']   = $arr_final_data;
        $this->arr_view_data['product_data']    = isset($bag_arr['product_data'])?$bag_arr['product_data']:[];
        $this->arr_view_data['bag_id']          = isset($bag_arr['id'])?$bag_arr['id']:0;
        $this->arr_view_data['maintotal']        = $maintotal; 
        $this->arr_view_data['subtotal']        = $maintotal + $shippingsubtotal; 
        $this->arr_view_data['shippingsubtotal']  = $shippingsubtotal; 
        $this->arr_view_data['wholesale_subtotal'] = isset($wholesale_subtotal)?$wholesale_subtotal:"0";     
        $this->arr_view_data['cart_product_arr']= $cart_product_arr;      
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        // dd($this->arr_view_data);
        return view($this->module_view_folder.'.my_bag',$this->arr_view_data);

    }

  
     public function add_item_into_cart(Request $request)
    {
        $klaviyo_res =[];


        $request_product_id = $request->product_id;

        $loggedIn_Id = 0;
      //  $user = Sentinel::check();
      //  $loggedIn_Id = $user->id;


        
        $ip_address = $this->get_ip_address();
        $session_id = $this->get_session_id();
        $user = $this->check_auth();

        if($user)
        {
          $loggedIn_Id = $user->id;  
        }

       
        //$bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();

        if($loggedIn_Id==0)
        {
          $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
          ->where('user_session_id',$session_id)
           ->where('ip_address',$ip_address)
          ->first();
           
        }else{
           $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
        }    
        

        if($bag_obj)
        {
             
            $bag_arr = $bag_obj->toArray();   

            $data_arr = json_decode($bag_arr['product_data'],true);
            $product_data_arr = $data_arr['product_id'];
              
            $product_ids_arr  = array_column($product_data_arr, 'product_id');

            if(!empty($product_ids_arr))
            {
                
                
                if( in_array(base64_decode($request->product_id) ,$product_ids_arr ) )
                {
                    
                    // $product_arr = $this->ProductModel->whereIn('id',$product_ids_arr)->with('product_images_details')->get()->toArray();

                    $product_arr = $this->ProductModel->where('id',base64_decode($request_product_id))->with('product_images_details')->get()->toArray();
                  

                    if(isset($product_arr) && count($product_arr)>0)
                    {   


                        foreach ($product_arr as $key => $product) 
                        {
                         //echo "====".$product['id'];
                            $cart_product_arr[$key]['user_id']        = $product['user_id'];
                            $cart_product_arr[$key]['product_id']     = $product['id'];
                            $cart_product_arr[$key]['product_name']   = $product['product_name'];
                            $cart_product_arr[$key]['item_qty']       = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'';

                            $tempbagqty = $product_data_arr[$product['id']]['item_qty'];
                            $get_remaining_stock = get_remaining_stock($product['id']);
                            //  dd($get_remaining_stock);

                            // return response()->json($get_remaining_stock);
                           
                            if($get_remaining_stock==0)
                            {
                                $response['status']      = 'FAILURE';
                                $response['description'] = 'Product is out of stock';
                                return response()->json($response);
                            }
                            elseif($request->item_qty > $get_remaining_stock)
                            {
                                $response['status']      = 'FAILURE';
                                // $response['description'] = 'Only ' . $get_remaining_stock . ' items left in stock';
                                $response['description'] = 'Only ' . $get_remaining_stock . ' item is left in stock';
                                return response()->json($response);
                            }
                            elseif(($get_remaining_stock <= $tempbagqty) || ($get_remaining_stock < $request->item_qty) || ($get_remaining_stock < ($request->item_qty + $tempbagqty)))
                            {
                                $totalnewolditems = $request->item_qty + $tempbagqty;
                                // return response()->json($totalnewolditems);
                                if($get_remaining_stock < $totalnewolditems)
                                {
                                    $canaddstock= $get_remaining_stock - $tempbagqty;
                                    $response['status']      = 'FAILURE';
                                    if ($get_remaining_stock == $tempbagqty) {
                                        // $response['description'] = 'You already have added the maximum quantity of this product in cart, please go to cart for checkout';
                                         $response['description'] = 'The last piece of this item is in a customers cart, the product is now out of stock';
                                    }else{
                                        $response['description'] = 'You already have '. $tempbagqty. ' items of this product in cart. You can add ' . $canaddstock . ' more items.';

                                    }
                                        return response()->json($response);
                                }
                                else
                                {
                                    $response['status']      = 'FAILURE';
                                    // $response['description'] = 'Only ' . $get_remaining_stock . ' items left in stock';
                                    $response['description'] = 'Only ' . $get_remaining_stock . ' item is left in stock';
                                    
                                    return response()->json($response);
                                }
                                
                            }  
                        }       
                    }  
                } else {


                    $item_quantity    = $request->item_qty;
                    $item_product_id  = $request->product_id;


                    $res_inventory = $this->ProductInventoryModel->where('product_id', base64_decode($item_product_id))->get()->toArray();


                    if (!empty($res_inventory) && isset($item_quantity)) {
                        if (!empty($res_inventory[0]['remaining_stock'])) {
                            $remaining_stock = $res_inventory[0]['remaining_stock'];

                            if ($remaining_stock == 0) {
                                $response['status']      = 'FAILURE';
                                $response['description'] = 'Product is out of stock';
                                return response()->json($response);
                            } else if ($remaining_stock < $item_quantity) {
                                $response['status']      = 'FAILURE';
                                // $response['description'] = 'Only ' . $res_inventory[0]['remaining_stock'] . ' items left in stock';
                                 $response['description'] = 'Only ' . $res_inventory[0]['remaining_stock'] . ' item is left in stock';
                                return response()->json($response);
                            }
                        }
                    }
                }

            }else{

                    $item_quantity    = $request->item_qty;         
                    $item_product_id  = $request->product_id;


                     $res_inventory = $this->ProductInventoryModel->where('product_id',base64_decode($item_product_id))->get()->toArray();

                     
                     if(!empty($res_inventory) && isset($item_quantity))
                     {
                          if(!empty($res_inventory[0]['remaining_stock']))
                          {   
                            $remaining_stock = $res_inventory[0]['remaining_stock'];

                            if($remaining_stock==0)
                            {
                                 $response['status']      = 'FAILURE';
                                 $response['description'] = 'Product is out of stock';
                                return response()->json($response);
                            }
                            else if($remaining_stock < $item_quantity)
                            {
                                 $response['status']      = 'FAILURE';
                                 // $response['description'] = 'Only '.$res_inventory[0]['remaining_stock']. ' items left in stock';
                                  $response['description'] = 'Only '.$res_inventory[0]['remaining_stock']. ' item is left in stock';
                                return response()->json($response);
                            }
                          }
                     }




              }    
             
        }
        else
        {
            

            $item_quantity    = $request->item_qty;         
            $item_product_id  = $request->product_id;


            $res_inventory = $this->ProductInventoryModel->where('product_id',base64_decode($item_product_id))->get()->toArray();

            
            if(!empty($res_inventory) && isset($item_quantity))
            {
                if(!empty($res_inventory[0]['remaining_stock']))
                {   
                    $remaining_stock = $res_inventory[0]['remaining_stock'];

                    if($remaining_stock==0)
                    {
                        $response['status']      = 'FAILURE';
                        $response['description'] = 'Product is out of stock';
                        return response()->json($response);
                    }
                    else if($remaining_stock < $item_quantity)
                    {
                        $response['status']      = 'FAILURE';
                        // $response['description'] = 'Only '.$res_inventory[0]['remaining_stock']. ' items left in stock';
                        $response['description'] = 'Only '.$res_inventory[0]['remaining_stock']. ' item is left in stock';
                        return response()->json($response);
                    }
                }
            }
        }    

             


        /************************************************************/
       /* $item_quantity    = $request->item_qty;         
        $item_product_id  = $request->product_id;


         $res_inventory = $this->ProductInventoryModel->where('product_id',base64_decode($item_product_id))->get()->toArray();

         
         if(!empty($res_inventory) && isset($item_quantity))
         {
              if(!empty($res_inventory[0]['remaining_stock']))
              {   
                $remaining_stock = $res_inventory[0]['remaining_stock'];

                if($remaining_stock==0)
                {
                     $response['status']      = 'FAILURE';
                     $response['description'] = 'product stock is not avaliable';
                    return response()->json($response);
                }
                else if($remaining_stock < $item_quantity)
                {
                     $response['status']      = 'FAILURE';
                     $response['description'] = 'stock is '.$res_inventory[0]['remaining_stock'].' only';
                    return response()->json($response);
                }
              }
         }*/
        /******************************************************************/ 

        

      $product_arr = $new_arr = [];

        $arr_rules = [  
                        'product_id'      => 'required',  
                        'item_qty'        => 'required'                            
                    ];

        $validator = Validator::make($request->all(),$arr_rules); 

        if($validator->fails())
        {        
           $response['status'] = 'FAILURE';
           $response['description'] = 'Please check all the required fields';
           return response()->json($response);
        }

        $product_id = $request->input('product_id',null);
        $product_id = base64_decode($product_id);
        $item_qty   = $request->input('item_qty',null);
        //$sku_no     = $request->input('sku_no',null);
        $user = Sentinel::check();

        // $bag_obj = TempBagModel::where('buyer_id',$user->id)->first();
         if($loggedIn_Id==0)
        {
             $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
             ->where('user_session_id',$session_id)
             ->where('ip_address',$ip_address)
             ->first();
         
        }else{
              $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
        } 


        $bag_count = get_bag_count();
       
        //find is any product added from this ip if yes then push new data to same row
        try
        {
          DB::beginTransaction();


          //$exist_obj = $this->TempBagModel->where('buyer_id',$user->id)->first();

            if($loggedIn_Id==0)
            {
                $exist_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
                ->where('user_session_id',$session_id)
                 ->where('ip_address',$ip_address)
                ->first();
             
            }else{
                $exist_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
            } 

          
          $product_obj = $this->ProductModel->where('id',$product_id)->first();
            $new_arr = [];

          

          if($product_obj)
          {
            $product_arr = $product_obj->toArray();

            $new_arr['product_id']    = $product_id;           
            $new_arr['item_qty']      = $item_qty;    
            $new_arr['seller_id']     = $product_arr['user_id'];    
            
          }

          if(isset($new_arr['product_id']) == false)
          {
            $response['status'] = 'FAILURE';
            $response['description'] = 'Something went wrong';
            return response()->json($response);
          }
            
            if($exist_obj)
            {
               // dd($exist_obj);
                $exist_arr = $exist_obj->toArray();
                $json_data = [];            
                $json_decoded_data = json_decode($exist_arr['product_data'],true);

                /* Update product details, if product are already available on cart */
                $data = isset($json_decoded_data['product_id'][$new_arr['product_id']])?$json_decoded_data['product_id'][$new_arr['product_id']]:false;

                if(isset($data) && !empty($data))
                {
                    $qty = $data['item_qty'] + $item_qty;

                    
                    
                    $new_arr['item_qty'] = $qty;
                    
                }
                
                /* -------------- End --------------------- */
                $json_decoded_data['product_id'][$new_arr['product_id']] = $new_arr;
                array_push($json_decoded_data['sequence'],$product_id);

               $update_arr['product_data']            = json_encode($json_decoded_data,true);  

               // $is_updated = $this->TempBagModel->where('buyer_id',$user->id)->update($update_arr);
                if($loggedIn_Id==0)
                {
                      $is_updated = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
                      ->where('user_session_id',$session_id)
                       ->where('ip_address',$ip_address)
                      ->update($update_arr);
                }
                else
                {
                      $is_updated = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->update($update_arr);
                }


            

              if($is_updated)
              {  
                   DB::commit();

                   $klaviyo_res =  $this->klaviyo_addtocart($product_id);

                   $product_details = $this->get_product_details($product_id, $request->input('item_qty'));

                  $response['status']      = 'SUCCESS';
                  $response['bag_count']   = $bag_count;
                  $response['description'] = 'Product added to cart succcessfully';
                  $response['klaviyo_addtocart']   = isset($klaviyo_res)?$klaviyo_res:[];
                  $response['product_details']   = $product_details;
              }
              else
              {
                  DB::rollback();
                  $response['status']      = 'FAILURE';
                  $response['description'] = 'Something went wrong please try again later';                   
              }
            }//if exists obj
            else
            {
              //create
                $arr_cart_data = [];
                $arr_sequence  = [];
                $arr_final     = [];

                //change key product id to sku id
                $arr_cart_data[$new_arr['product_id']] = $new_arr;

                $arr_sequence[0] = $product_id;      

                $arr_final['product_id']      = $arr_cart_data;                  
                $arr_final['sequence']        = $arr_sequence;   
                   

              $encoded_new_arr = json_encode($arr_final);
              
              $insert_arr['product_data']    = $encoded_new_arr;
              $insert_arr['buyer_id']      = $loggedIn_Id;
              $insert_arr['user_session_id'] = $session_id;
              $insert_arr['ip_address'] = $ip_address;
              
               // dd($insert_arr);
              $is_created = $this->TempBagModel->create($insert_arr);

              if($is_created)
              {
                  DB::commit();

                  $klaviyo_res =  $this->klaviyo_addtocart($product_id);

                  $product_details = $this->get_product_details($product_id, $request->input('item_qty'));

                  $response['status']      = 'SUCCESS';
                  $response['bag_count']   = $bag_count;
                  $response['description'] = 'Product added to cart succcessfully';

                  $response['klaviyo_addtocart']   = isset($klaviyo_res)?$klaviyo_res:[];
                   $response['product_details']   = $product_details;

              }
              else
              {
                DB::rollback();
                  $response['status']      = 'FAILURE';
                  $response['description'] = 'Something went wrong please try again later';
              }
          }//else existis obj

        }catch(Exception $e)
        {
          DB::rollback();
          $response['status']      = 'FAILURE';
          $response['description'] = $e->getMessage();
        }

        return response()->json($response);

    }

    public function add_item_into_cart_old19aug(Request $request)
    {
        $request_product_id = $request->product_id;


        $user = Sentinel::check();
        $loggedIn_Id = $user->id;
       
        $bag_obj = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();

        if($bag_obj)
        {
            
            $bag_arr = $bag_obj->toArray();   

            $data_arr = json_decode($bag_arr['product_data'],true);
            $product_data_arr = $data_arr['product_id'];
              
            $product_ids_arr  = array_column($product_data_arr, 'product_id');

            if(!empty($product_ids_arr))
            {
                
                
                if( in_array(base64_decode($request->product_id) ,$product_ids_arr ) )
                {
                    
                    // $product_arr = $this->ProductModel->whereIn('id',$product_ids_arr)->with('product_images_details')->get()->toArray();

                    $product_arr = $this->ProductModel->where('id',base64_decode($request_product_id))->with('product_images_details')->get()->toArray();
                  

                    if(isset($product_arr) && count($product_arr)>0)
                    {   


                        foreach ($product_arr as $key => $product) 
                        {
                         //echo "====".$product['id'];
                            $cart_product_arr[$key]['user_id']        = $product['user_id'];
                            $cart_product_arr[$key]['product_id']     = $product['id'];
                            $cart_product_arr[$key]['product_name']   = $product['product_name'];
                            $cart_product_arr[$key]['item_qty']       = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'';

                            $tempbagqty = $product_data_arr[$product['id']]['item_qty'];
                            $get_remaining_stock = get_remaining_stock($product['id']);
                            //  dd($get_remaining_stock);

                            // return response()->json($get_remaining_stock);
                           
                            if($get_remaining_stock==0)
                            {
                                $response['status']      = 'FAILURE';
                                $response['description'] = 'Product is out of stock';
                                return response()->json($response);
                            }
                            elseif($request->item_qty > $get_remaining_stock)
                            {
                                $response['status']      = 'FAILURE';
                                // $response['description'] = 'Only ' . $get_remaining_stock . ' items left in stock';
                                 $response['description'] = 'Only ' . $get_remaining_stock . ' item is left in stock';
                                return response()->json($response);
                            }
                            elseif(($get_remaining_stock <= $tempbagqty) || ($get_remaining_stock < $request->item_qty) || ($get_remaining_stock < ($request->item_qty + $tempbagqty)))
                            {
                                $totalnewolditems = $request->item_qty + $tempbagqty;
                                // return response()->json($totalnewolditems);
                                if($get_remaining_stock < $totalnewolditems)
                                {
                                    $canaddstock= $get_remaining_stock - $tempbagqty;
                                    $response['status']      = 'FAILURE';
                                    if ($get_remaining_stock == $tempbagqty) {
                                        $response['description'] = 'You already have added the maximum quantity of this product in cart, please go to cart for checkout';
                                    }else{
                                        $response['description'] = 'You already have '. $tempbagqty. ' items of this product in cart. You can add ' . $canaddstock . ' more items.';

                                    }
                                        return response()->json($response);
                                }
                                else
                                {
                                    $response['status']      = 'FAILURE';
                                    // $response['description'] = 'Only ' . $get_remaining_stock . ' items left in stock';
                                    $response['description'] = 'Only ' . $get_remaining_stock . ' item is left in stock';
                                    return response()->json($response);
                                }
                                
                            }  
                        }       
                    }  
                } else {


                    $item_quantity    = $request->item_qty;
                    $item_product_id  = $request->product_id;


                    $res_inventory = $this->ProductInventoryModel->where('product_id', base64_decode($item_product_id))->get()->toArray();


                    if (!empty($res_inventory) && isset($item_quantity)) {
                        if (!empty($res_inventory[0]['remaining_stock'])) {
                            $remaining_stock = $res_inventory[0]['remaining_stock'];

                            if ($remaining_stock == 0) {
                                $response['status']      = 'FAILURE';
                                $response['description'] = 'Product is out of stock';
                                return response()->json($response);
                            } else if ($remaining_stock < $item_quantity) {
                                $response['status']      = 'FAILURE';
                                // $response['description'] = 'Only ' . $res_inventory[0]['remaining_stock'] . ' items left in stock';
                                $response['description'] = 'Only ' . $res_inventory[0]['remaining_stock'] . ' item is left in stock';
                                return response()->json($response);
                            }
                        }
                    }
                }

            }else{

                    $item_quantity    = $request->item_qty;         
                    $item_product_id  = $request->product_id;


                     $res_inventory = $this->ProductInventoryModel->where('product_id',base64_decode($item_product_id))->get()->toArray();

                     
                     if(!empty($res_inventory) && isset($item_quantity))
                     {
                          if(!empty($res_inventory[0]['remaining_stock']))
                          {   
                            $remaining_stock = $res_inventory[0]['remaining_stock'];

                            if($remaining_stock==0)
                            {
                                 $response['status']      = 'FAILURE';
                                 $response['description'] = 'Product is out of stock';
                                return response()->json($response);
                            }
                            else if($remaining_stock < $item_quantity)
                            {
                                 $response['status']      = 'FAILURE';
                                 // $response['description'] = 'Only '.$res_inventory[0]['remaining_stock']. ' items left in stock';
                                 $response['description'] = 'Only '.$res_inventory[0]['remaining_stock']. ' item is left in stock';
                                return response()->json($response);
                            }
                          }
                     }




              }    
             
        }
        else
        {
            

            $item_quantity    = $request->item_qty;         
            $item_product_id  = $request->product_id;


            $res_inventory = $this->ProductInventoryModel->where('product_id',base64_decode($item_product_id))->get()->toArray();

            
            if(!empty($res_inventory) && isset($item_quantity))
            {
                if(!empty($res_inventory[0]['remaining_stock']))
                {   
                    $remaining_stock = $res_inventory[0]['remaining_stock'];

                    if($remaining_stock==0)
                    {
                        $response['status']      = 'FAILURE';
                        $response['description'] = 'Product is out of stock';
                        return response()->json($response);
                    }
                    else if($remaining_stock < $item_quantity)
                    {
                        $response['status']      = 'FAILURE';
                        // $response['description'] = 'Only '.$res_inventory[0]['remaining_stock']. ' items left in stock';
                         $response['description'] = 'Only '.$res_inventory[0]['remaining_stock']. ' item is left in stock';
                        return response()->json($response);
                    }
                }
            }
        }    

             


        /************************************************************/
       /* $item_quantity    = $request->item_qty;         
        $item_product_id  = $request->product_id;


         $res_inventory = $this->ProductInventoryModel->where('product_id',base64_decode($item_product_id))->get()->toArray();

         
         if(!empty($res_inventory) && isset($item_quantity))
         {
              if(!empty($res_inventory[0]['remaining_stock']))
              {   
                $remaining_stock = $res_inventory[0]['remaining_stock'];

                if($remaining_stock==0)
                {
                     $response['status']      = 'FAILURE';
                     $response['description'] = 'product stock is not avaliable';
                    return response()->json($response);
                }
                else if($remaining_stock < $item_quantity)
                {
                     $response['status']      = 'FAILURE';
                     $response['description'] = 'stock is '.$res_inventory[0]['remaining_stock'].' only';
                    return response()->json($response);
                }
              }
         }*/
        /******************************************************************/ 

        

      $product_arr = $new_arr = [];

        $arr_rules = [  
                        'product_id'      => 'required',  
                        'item_qty'        => 'required'                            
                    ];

        $validator = Validator::make($request->all(),$arr_rules); 

        if($validator->fails())
        {        
           $response['status'] = 'warning';
           $response['description'] = 'Please check all the required fields';
        }

        $product_id = $request->input('product_id',null);
        $product_id = base64_decode($product_id);
        $item_qty   = $request->input('item_qty',null);
        //$sku_no     = $request->input('sku_no',null);
        $user = Sentinel::check();
        $bag_obj = TempBagModel::where('buyer_id',$user->id)->first();

        $bag_count = get_bag_count();
       
        //find is any product added from this ip if yes then push new data to same row
        try
        {
          DB::beginTransaction();
          $exist_obj = $this->TempBagModel->where('buyer_id',$user->id)->first();
          
          $product_obj = $this->ProductModel->where('id',$product_id)->first();
            $new_arr = [];

          

          if($product_obj)
          {
            $product_arr = $product_obj->toArray();

            $new_arr['product_id']    = $product_id;           
            $new_arr['item_qty']      = $item_qty;    
            $new_arr['seller_id']     = $product_arr['user_id'];    
            
          }
            
            if($exist_obj)
            {
               // dd($exist_obj);
                $exist_arr = $exist_obj->toArray();
                $json_data = [];            
                $json_decoded_data = json_decode($exist_arr['product_data'],true);

                /* Update product details, if product are already available on cart */
                $data = isset($json_decoded_data['product_id'][$new_arr['product_id']])?$json_decoded_data['product_id'][$new_arr['product_id']]:false;

                if(isset($data) && !empty($data))
                {
                    $qty = $data['item_qty'] + $item_qty;

                    
                    
                    $new_arr['item_qty'] = $qty;
                    
                }
                
                /* -------------- End --------------------- */
                $json_decoded_data['product_id'][$new_arr['product_id']] = $new_arr;
                array_push($json_decoded_data['sequence'],$product_id);

              $update_arr['product_data']            = json_encode($json_decoded_data,true);  

              $is_updated = $this->TempBagModel->where('buyer_id',$user->id)->update($update_arr);

              if($is_updated)
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
            else
            {
              //create
                $arr_cart_data = [];
                $arr_sequence  = [];
                $arr_final     = [];

                //change key product id to sku id
                $arr_cart_data[$new_arr['product_id']] = $new_arr;

                $arr_sequence[0] = $product_id;      

                $arr_final['product_id']      = $arr_cart_data;                  
                $arr_final['sequence']        = $arr_sequence;   
                   

              $encoded_new_arr = json_encode($arr_final);
              
              $insert_arr['product_data']    = $encoded_new_arr;
              $insert_arr['buyer_id']      = $user->id;
              
               // dd($insert_arr);
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

    }

    
    public function remove_product(Request $request,$enc_prod_id = 0)
    {

        $bag_arr    = $update_arr = [];
        $is_update  = false;
        $key        = false;
        //$product_id = base64_decode($enc_prod_id);
        $product_id = base64_decode($enc_prod_id);

        $user = Sentinel::check();
       // $loggedIn_Id = $user->id;
        $loggedIn_Id =0;
        if($user)
        {
          $loggedIn_Id = $user->id;  
        }
        $session_id = $this->get_session_id();
        $ip_address = $this->get_ip_address();

       // $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
        if($loggedIn_Id==0)
        {
             $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
             ->where('user_session_id',$session_id)
              ->where('ip_address',$ip_address)
             ->first();
        }else{
             $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
        }

        if($bag_obj)
        {
            $bag_arr = $bag_obj->toArray();         

            $product_bag_data = $bag_arr['product_data'];
            $product_bag_data = json_decode($product_bag_data,true);
            $product_sequence = $product_bag_data['sequence'];
            $product_data     = $product_bag_data['product_id'];
       
            if(isset($product_data[$product_id]))
            {
                unset($product_data[$product_id]);
            }

            // $key = array_search($product_id, $product_sequence); 
           
            // if(isset($key) && !empty($key))
            // {    
            //    unset($product_sequence[$key]);
            // }

           $product_sequence = array_values(array_diff($product_sequence, array($product_id)));
           


            // $update_arr['product_data'] = json_encode(array_values($product_data),true);
            $arr_sequence = [];
            $arr_sequence['product_id'] = $product_data;    
            $arr_sequence['sequence']   = $product_sequence;   

            $update_arr['product_data'] = json_encode($arr_sequence,true);
              //  dd($update_arr);

           // $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->update($update_arr);
            if($loggedIn_Id==0)
            {
              $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->where('buyer_id',$loggedIn_Id)->update($update_arr);

            }else{
             $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->update($update_arr);
            }
            
        }

        if($is_update)
        {
            Flash::success('Product deleted from bag succcessfully');
        }
        else
        {
            Flash::error('Problem occured while deleting product from bag');
        }

        return redirect()->back();
    }

    public function empty_cart(Request $request)
    {

        $user = Sentinel::check();
        $loggedIn_Id = 0;
       // if ($user) 
       // {
             if($user){
               $loggedIn_Id = $user->id;    
             }
              
       

            $session_id = $this->get_session_id();
            $ip_address = $this->get_ip_address();


           /* if($loggedIn_Id==0)
            {
                 $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
                 ->where('user_session_id',$session_id)
                  ->where('ip_address',$ip_address)
                 ->first();
            }else{
                 $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
            } 

           if($bag_obj)
           {
            $bag_arr          = $bag_obj->toArray();

            $data_arr = json_decode($bag_arr['product_data'],true);
            $product_data_arr = $data_arr['product_id'];
            
            $product_ids_arr  = array_column($product_data_arr, 'product_id');

            $product_arr = $this->ProductModel->whereIn('id',$product_ids_arr)->with('product_images_details','age_restriction_detail','get_brand_detail','get_seller_details.seller_detail') ->get()->toArray(); 

            
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
                    $cart_product_arr[$key]['age_restriction']    = $product['age_restriction'];
                    $cart_arr[$key]['total_price']    = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'0';
                    
                    
                    $cart_product_arr[$key]['unit_price']    = $product['unit_price'];
                    $cart_product_arr[$key]['price_drop_to']    = $product['price_drop_to'];
                    $cart_product_arr[$key]['shipping_charges']    = $product['shipping_charges'];
                    if($cart_product_arr[$key]['price_drop_to']>0)
                    {
                        $cart_product_arr[$key]['total_price']    = $product['price_drop_to'] * $cart_arr[$key]['total_price'];
                    }else{
                        $cart_product_arr[$key]['total_price']    = $product['unit_price'] * $cart_arr[$key]['total_price'];
                    }

                    $cart_product_arr[$key]['item_qty']       = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'';

                    $cart_product_arr[$key]['product_seller_detail']  = $product['get_seller_details'];

                    $cart_product_arr[$key]['is_chows_choice']    = $product['is_chows_choice'];
                    $cart_product_arr[$key]['product_certificate']    = $product['product_certificate'];
                    $cart_product_arr[$key]['spectrum']    = $product['spectrum'];
                   
                }//foreach       
                
                $maintotal = array_sum((array_column($cart_product_arr,'total_price')));
                $shippingsubtotal = array_sum((array_column($cart_product_arr,'shipping_charges')));

             }//if productarr        
         
           }//if bag obj
            */


           // $is_delete  = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->delete();
            if($loggedIn_Id==0)
            {
                $is_delete  = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
                ->where('user_session_id',$session_id)
                ->where('ip_address',$ip_address)
                ->delete();
            }else{
                $is_delete  = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->delete();
            }

            if($is_delete)
            {
                /**************** Delivery Option Clear ****************/

                    $delivery_option        = Session::get('sessiondeliveryoption_data');

                    $delivery_option_data   = is_array($delivery_option) ? $delivery_option: [];

                    foreach ($delivery_option_data as $key => $value) {
                        unset($delivery_option_data[$key]);
                    }

                    Session::put('sessiondeliveryoption_data',$delivery_option_data);

                /**************** Delivery Option Clear ****************/

                $response['status']   = 'success';
                $response['next_url'] = url('/my_bag');
            }
            else
            {
                $response['status'] = 'failure'; 
                $response['next_url'] = url('/my_bag');   
            }  
       /* }                   
        else
        {
            $response['status'] = 'failure'; 
            $response['next_url'] = url('/my_bag');   
        }*/
        return response()->json($response);
      
    }

    public function update_qty(Request $request)
    {
        $formData   = [];
        $formData   = $request->all(); 
        $loggedIn_Id = 0;

        $bag_arr    = $update_arr = $product_data = [];
        $is_update  = false;
        
        $product_id = base64_decode($formData['pro_id']);

        $update_qty = isset($formData['qty'])?$formData['qty']:""; 

        /*****************************************************************/ 

         $res_inventory = $this->ProductInventoryModel->where('product_id',$product_id)->get()->toArray();
        
         if(!empty($res_inventory) && isset($update_qty))
         {
              if(!empty($res_inventory[0]['remaining_stock']))
              {   
                $remaining_stock = $res_inventory[0]['remaining_stock'];

                if($remaining_stock==0)
                {
                     $response['status']      = 'FAILURE';
                     $response['description'] = 'This product is out of stock';
                    return response()->json($response);
                }
                else if($remaining_stock < $update_qty)
                {
                     $response['status']      = 'FAILURE';
                     // $response['description'] = 'Only '.$res_inventory[0]['remaining_stock'].' items are left in stock';
                     $response['description'] = 'Only '.$res_inventory[0]['remaining_stock'].' item is left in stock';
                    return response()->json($response);
                }
              }
         }



        /*****************************************************************/
           
        $user = Sentinel::check();

        if ($user) 
        {

            $loggedIn_Id = $user->id;
        }

        $ip_address = $this->get_ip_address();
        $session_id = $this->get_session_id();

        //$bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();

        if($loggedIn_Id==0)
        {
            $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
            ->where('user_session_id',$session_id)
            ->where('ip_address',$ip_address)
            ->first();
        }else{
            $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
        }

        // dd($bag_obj);
       
        if($bag_obj)
        {
            $bag_arr = $bag_obj->toArray();      
            //dd($bag_arr); 
           
            $product_bag_data = json_decode($bag_arr['product_data'],true);
            $product_data     = $product_bag_data['product_id'];
            $product_sequence = $product_bag_data['sequence'];


            if(isset($product_data) && sizeof($product_data)>0)
            {   
                foreach($product_data as $key=> $product)
                {

                    if($product_id==$key)
                    {
                        //dd($product_id,$product_data);
                        $subtotal = 0;
                        unset($product_data[$key]);    
                         
                        //$product_details = get_product_details($product_id);
                        $product_details = $this->ProductModel->where('id',$product_id)->first();
                        
                        

                        $new_arr['product_id']    = $product['product_id'];           
                        $new_arr['item_qty']      = $update_qty;    
                        
                        $new_arr['seller_id']      = $product['seller_id']; 
                        
                        //dd($new_arr);
                        $product_data[$product_id]    =  $new_arr;
                        
                        $subtotal = array_sum((array_column($product_data,'total_price'))); 

                        $wholesale_subtotal = array_sum((array_column($product_data,'total_wholesale_price'))); 
                        
                        $arr_sequence = [];
                        $arr_sequence['product_id'] = $product_data;    
                        $arr_sequence['sequence'] = $product_sequence;    

                        $update_arr['product_data'] = json_encode($arr_sequence,true);

                        
                       
                        // $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->update($update_arr);

                        if($loggedIn_Id==0)
                        {
                            $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->where('user_session_id',$session_id)->update($update_arr);
                        }else{
                            $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->update($update_arr);
                        }


                        if($is_update)
                        {
                            // $response['subtotal'] = $subtotal;
                            // $response['wholesale_subtotal'] = $wholesale_subtotal;
                            // $response['total_price'] = isset($new_arr['total_price'])?$new_arr['total_price']:"";
                            // $response['total_wholesale_price'] = isset($new_arr['total_wholesale_price'])?$new_arr['total_wholesale_price']:"";
                            $response['status'] = 'SUCCESS';
                        }

                    }    
                }
            }    
        }
        else
        {
            $response['status'] = 'FAILURE';    
        }

        return response()->json($response);
    } //end update qty


    // function applycouponcode(Request $request)
    // {
    //     $formData   = $request->all(); 
    //     $loggedIn_Id = 0;


    //     $product_ids = $formData['product_id'];
    //     $code = isset($formData['code'])?$formData['code']:""; 

    //     if(isset($product_ids) && isset($code))
    //     {

    //         $explodedids = explode(",", $product_ids);

    //         if(isset($explodedids) && !empty($explodedids))
    //         {
    //            foreach($explodedids as $productid)
    //            {
    //               $productinfo = get_product_info($productid);
                   
    //               if(isset($productinfo) && !empty($productinfo))
    //               {
    //                 $sellerid = $productinfo['user_id'];

    //                 $checksellercouponcode = check_seller_couponcode($sellerid);
    //                 if(isset($checksellercouponcode) && $checksellercouponcode==1)
    //                 {

    //                     $getcouponcodeinfo = get_seller_couponcode($sellerid);
    //                     echo "<pre>";print_r($getcouponcodeinfo);

    //                 }//if checksellercouponcode    


    //               }//if iset productinfo  


    //            }//foreach
    //         }//if isset
    //     }
    //     else{
    //         $response['status'] = 'FAILURE'; 
    //         $response['description'] = "Please enter coupon code";
    //         return response()->json($response);
    //     }//else isset

    // }//end applycouponcode



    function applycouponcodecommon(Request $request)
    {
        $formData   = $request->all(); 
        $loggedIn_Id = 0;

         $loginuser = Sentinel::check();

        if ($loginuser) 
        {

            $loggedIn_Id = $loginuser->id;
        }

        
        $code = isset($formData['code'])?$formData['code']:""; 
        

        if(isset($code))
        {

            $getcouponcodeinfo = check_coupon_exists($code);


            if(isset($getcouponcodeinfo) && !empty($getcouponcodeinfo))
            {

                if($getcouponcodeinfo['code']==$code)
                {

                    $couponid = $getcouponcodeinfo['id'];
                    $discount = $getcouponcodeinfo['discount'];
                    $type     = $getcouponcodeinfo['type'];
                    $dbsellerid   = $getcouponcodeinfo['user_id'];
                    $start_date   = $getcouponcodeinfo['start_date'];
                    $end_date     = $getcouponcodeinfo['end_date'];
                    $currentdate  = date("Y-m-d");

                    $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();

                    if($bag_obj)
                    {
                        $arr_bag = $bag_obj->toArray();
                        $arr_bag_product =  json_decode($arr_bag['product_data'],true);
                        $arr_product_ids = array_column($arr_bag_product['product_id'],'seller_id');
                        
                        if(!in_array($dbsellerid,$arr_product_ids))
                        {
                            $response['status']      = 'FAILURE'; 
                            //$response['description'] = "This coupon is not valid for this dispensary.";
                            $response['description'] = "This coupon is not valid for this product or seller.";
                            return response()->json($response);
                        }
                        
                    }

                    if($type=='0')
                    {
                        $checkalreadyused = $this->BuyerCouponModel
                                            ->where('code',$code)
                                            ->where('type',$type)
                                           // ->where('seller_id',$seller_id)
                                            ->where('buyer_id',$loggedIn_Id)
                                            ->first();


                        if(isset($checkalreadyused) && !empty($checkalreadyused))
                        {
                            $checkalreadyused = $checkalreadyused->toArray();
                            
                             $response['status']      = 'FAILURE'; 
                             $response['description'] = "Coupon code already used.";
                             return response()->json($response);
                        }//if already used
                        else
                        {
                            $exisiting_coupon_data = Session::get('sessioncoupon_data');
                            $exisiting_coupon_data = is_array($exisiting_coupon_data) ? $exisiting_coupon_data: [];

                            $exisiting_coupon_data[$dbsellerid]['couponcode'] = $code;
                            $exisiting_coupon_data[$dbsellerid]['couponcodeId'] = $couponid;
                             $exisiting_coupon_data[$dbsellerid]['seller'] = $dbsellerid;
                            $exisiting_coupon_data[$dbsellerid]['discount'] = $discount;
                            $exisiting_coupon_data[$dbsellerid]['type'] = $type;



                             
                            Session::put('sessioncoupon_data',$exisiting_coupon_data);

                             $response['status']      = 'SUCCESS'; 
                             $response['description'] = "Copon Applied Succcessfully";
                             return response()->json($response);

                            

                        }//else not already used

                    }
                    
                    if($type=='1')
                    {

                        if($end_date>=$currentdate)
                        {
                            $exisiting_coupon_data = Session::get('sessioncoupon_data');
                            $exisiting_coupon_data = is_array($exisiting_coupon_data) ? $exisiting_coupon_data: [];

                            $exisiting_coupon_data[$dbsellerid]['couponcode'] = $code;
                            $exisiting_coupon_data[$dbsellerid]['couponcodeId'] = $couponid;
                             $exisiting_coupon_data[$dbsellerid]['seller'] = $dbsellerid;
                            $exisiting_coupon_data[$dbsellerid]['discount'] = $discount;           
                            $exisiting_coupon_data[$dbsellerid]['type'] = $type;

                            Session::put('sessioncoupon_data',$exisiting_coupon_data);
                             $response['status']      = 'SUCCESS'; 
                             $response['description'] = "Coupon Applied Succcessfully";
                             return response()->json($response);
                            
                        }
                        else
                        {

                             $response['status']      = 'FAILURE'; 
                             $response['description'] = "Coupon code expired.";
                             return response()->json($response);

                        }



                    }//if type 1

        
                }
                else
                {
                     $response['status']     = 'FAILURE'; 
                     //$response['description'] = "This coupon is not valid for this dispensary.";
                     $response['description'] = "This coupon is not valid for this product or seller.";
                     return response()->json($response);

                }//else

            }//if checksellercouponcode    
            else
            {
                 $response['status']      = 'FAILURE'; 
                 $response['description'] = "This coupon is not valid for this product or seller.";
                 return response()->json($response);

             }//else

                 
        }
        else{
            $response['status']      = 'FAILURE'; 
            $response['description'] = "Something went wrong";
            return response()->json($response);
        }//else isset

    }//end applycouponcode

 function applycouponcode(Request $request)
    {
        $formData   = $request->all(); 
        $loggedIn_Id = 0;

         $loginuser = Sentinel::check();

        if ($loginuser) 
        {

            $loggedIn_Id = $loginuser->id;
        }

        $product_id = $formData['product_id'];
        $code = isset($formData['code'])?$formData['code']:""; 
        $seller_id = isset($formData['seller_id'])?$formData['seller_id']:""; 

        if(isset($product_id) && isset($code) && isset($seller_id))
        {

              // dd(Session::get('sessioncoupon_data'));

            $checksellercouponcode = check_seller_couponcode($seller_id);


            if(isset($checksellercouponcode) && $checksellercouponcode==1)
            {


                $getcouponcodeinfo = get_seller_couponcode($seller_id,$code);


                if(isset($getcouponcodeinfo) && !empty($getcouponcodeinfo))
                {

                    if($getcouponcodeinfo['code']==$code)
                    {

                    $couponid = $getcouponcodeinfo['id'];
                    $discount = $getcouponcodeinfo['discount'];
                    $type     = $getcouponcodeinfo['type'];
                    $dbsellerid   = $getcouponcodeinfo['user_id'];
                    $start_date   = $getcouponcodeinfo['start_date'];
                    $end_date     = $getcouponcodeinfo['end_date'];
                    $currentdate  = date("Y-m-d");

                    if($type=='0')
                    {
                        $checkalreadyused = $this->BuyerCouponModel
                                            ->where('code',$code)
                                            ->where('type',$type)
                                           // ->where('seller_id',$seller_id)
                                            ->where('buyer_id',$loggedIn_Id)
                                            ->first();


                        if(isset($checkalreadyused) && !empty($checkalreadyused))
                        {
                            $checkalreadyused = $checkalreadyused->toArray();
                            
                             $response['status'] = 'FAILURE'; 
                             $response['description'] = "Coupon code already used.";
                             return response()->json($response);
                        }//if already used
                        else
                        {
                            $exisiting_coupon_data = Session::get('sessioncoupon_data');
                            $exisiting_coupon_data = is_array($exisiting_coupon_data) ? $exisiting_coupon_data: [];

                            $exisiting_coupon_data[$dbsellerid]['couponcode'] = $code;
                            $exisiting_coupon_data[$dbsellerid]['couponcodeId'] = $couponid;
                             $exisiting_coupon_data[$dbsellerid]['seller'] = $seller_id;
                            $exisiting_coupon_data[$dbsellerid]['discount'] = $discount;
                            $exisiting_coupon_data[$dbsellerid]['type'] = $type;



                             
                            Session::put('sessioncoupon_data',$exisiting_coupon_data);

                             $response['status'] = 'SUCCESS'; 
                             $response['description'] = "Copon Applied Succcessfully";
                             return response()->json($response);

                            

                        }//else not already used

                    }
                    elseif($type=='1')
                    {

                        if($end_date>=$currentdate)
                        {
                            $exisiting_coupon_data = Session::get('sessioncoupon_data');
                            $exisiting_coupon_data = is_array($exisiting_coupon_data) ? $exisiting_coupon_data: [];

                            $exisiting_coupon_data[$dbsellerid]['couponcode'] = $code;
                            $exisiting_coupon_data[$dbsellerid]['couponcodeId'] = $couponid;
                             $exisiting_coupon_data[$dbsellerid]['seller'] = $seller_id;
                            $exisiting_coupon_data[$dbsellerid]['discount'] = $discount;           
                            $exisiting_coupon_data[$dbsellerid]['type'] = $type;

                            Session::put('sessioncoupon_data',$exisiting_coupon_data);
                             $response['status'] = 'SUCCESS'; 
                             $response['description'] = "Copon Applied Succcessfully";
                             return response()->json($response);
                            
                        }
                        else
                        {

                             $response['status']      = 'FAILURE'; 
                             $response['description'] = "Coupon code expired.";
                             return response()->json($response);

                        }



                    }//else if type 1

                    }//else
                    else
                    {
                         $response['status']      = 'FAILURE'; 
                         $response['description'] = "This coupon is not valid for this product.";
                         return response()->json($response);

                    }//else

                }
                else
                {
                     $response['status']      = 'FAILURE'; 
                     $response['description'] = "This coupon is not valid for this product.";
                     return response()->json($response);

                }//else

            }//if checksellercouponcode    
            else
            {
                 $response['status']      = 'FAILURE'; 
                 $response['description'] = "This coupon is not valid for this product";
                 return response()->json($response);

             }//else

                 
        }
        else{
            $response['status']      = 'FAILURE'; 
            $response['description'] = "Something went wrong";
            return response()->json($response);
        }//else isset

    }//end applycouponcode



    public function clearcoupon_code(Request $request)
    {

        $seller_id = $request['seller_id'];


        if ($seller_id) {

            $getsessiondata = is_array(Session::get('sessioncoupon_data')) ? Session::get('sessioncoupon_data') : [];

           
           
            if (isset($getsessiondata) && sizeof($getsessiondata)>0) 
            {
                $products = session()->pull('sessioncoupon_data', []); // Second argument is a default value
                    

                
                if(($key = array_search($getsessiondata[$seller_id], $products)) !== false) {

                   
                    unset($getsessiondata[$key]);

                    Session::put('sessioncoupon_data',$getsessiondata);
                   

                    $response['status']      = 'success';
                    $response['description'] = 'Coupon code has been removed.';
                    return response()->json($response);
                }
               
                
            }
            else
            {
                $response['status']      = 'error';
                $response['description'] = 'Something went wrong, please try again.';
                return response()->json($response);
            }

           }
           else
           {
            $response['status']      = 'error';
            $response['description'] = 'Something went wrong, please try again.';
            return response()->json($response);
           }  

    }//end


   
      public function remove_product_cart(Request $request,$enc_prod_id = 0)
    {

        $bag_arr    = $update_arr =  $response = [];
        $is_update  = false;
        $key        = false;
        //$product_id = base64_decode($enc_prod_id);
        $product_id = base64_decode($enc_prod_id);

        $user = Sentinel::check();
       // $loggedIn_Id = $user->id;
        $loggedIn_Id =0;
        if($user)
        {
          $loggedIn_Id = $user->id;  
        }
        $session_id = $this->get_session_id();
        $ip_address = $this->get_ip_address();

       // $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
        if($loggedIn_Id==0)
        {
             $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)
             ->where('user_session_id',$session_id)
              ->where('ip_address',$ip_address)
             ->first();
        }else{
             $bag_obj    = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->first();
        }

        if($bag_obj)
        {
            $bag_arr = $bag_obj->toArray();         

            $product_bag_data = $bag_arr['product_data'];
            $product_bag_data = json_decode($product_bag_data,true);
            $product_sequence = $product_bag_data['sequence'];
            $product_data     = $product_bag_data['product_id'];
       
            if(isset($product_data[$product_id]))
            {
                unset($product_data[$product_id]);
            }

            // $key = array_search($product_id, $product_sequence); 
           
            // if(isset($key) && !empty($key))
            // {    
            //    unset($product_sequence[$key]);
            // }

           $product_sequence = array_values(array_diff($product_sequence, array($product_id)));
           


            // $update_arr['product_data'] = json_encode(array_values($product_data),true);
            $arr_sequence = [];
            $arr_sequence['product_id'] = $product_data;    
            $arr_sequence['sequence']   = $product_sequence;   

            $update_arr['product_data'] = json_encode($arr_sequence,true);
              //  dd($update_arr);

           // $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->update($update_arr);
            if($loggedIn_Id==0)
            {
              $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->where('buyer_id',$loggedIn_Id)->update($update_arr);

            }else{
             $is_update = $this->TempBagModel->where('buyer_id',$loggedIn_Id)->update($update_arr);
            }
            
        }

        if($is_update)
        {
             Session::forget('sessionwallet_data');
            //Flash::success('Product deleted from bag succcessfully');
             $response['status'] = 'SUCCESS';
             $response['description']    = 'Product removed from cart succcessfully.';

        }
        else
        {
           // Flash::error('Problem occured while deleting product from bag');
             $responresponsese['status'] = 'FAILURE'; 
             $response['description']    = 'Error occured while removing product from cart';
        }

        return response()->json($response);
    }//end


   public function klaviyo_addtocart($product_id="")
    {
        $loggedIn_Id = 0;
      
        $ip_address = $this->get_ip_address();
        $session_id = $this->get_session_id();
        $user = $this->check_auth();

        if($user)
        {
          $loggedIn_Id = $user->id;  
        }



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


        if($bag_obj)
        {
            $bag_arr          = $bag_obj->toArray();

            $data_arr = json_decode($bag_arr['product_data'],true);
            $product_data_arr = $data_arr['product_id'];
            
            $product_ids_arr  = array_column($product_data_arr, 'product_id');

            $product_arr = $this->ProductModel->whereIn('id',$product_ids_arr)->with('product_images_details','age_restriction_detail','get_brand_detail','get_seller_details.seller_detail') ->get()->toArray(); 

           
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
                    $cart_product_arr[$key]['age_restriction']    = $product['age_restriction'];
                    /*$cart_product_arr[$key]['product_image']  = get_sku_image($sku_no);*/
                    $cart_arr[$key]['total_price']    = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'0';
                    
                    
                    $cart_product_arr[$key]['unit_price']    = $product['unit_price'];
                    $cart_product_arr[$key]['price_drop_to']    = $product['price_drop_to'];
                    $cart_product_arr[$key]['shipping_charges']    = $product['shipping_charges'];
                    if($cart_product_arr[$key]['price_drop_to']>0)
                    {
                        $cart_product_arr[$key]['total_price']    = $product['price_drop_to'] * $cart_arr[$key]['total_price'];
                    }else{
                        $cart_product_arr[$key]['total_price']    = $product['unit_price'] * $cart_arr[$key]['total_price'];
                    }

                    $cart_product_arr[$key]['item_qty']       = isset($product_data_arr[$product['id']]['item_qty'])?$product_data_arr[$product['id']]['item_qty']:'';

                    $cart_product_arr[$key]['product_seller_detail']  = $product['get_seller_details'];

                    $cart_product_arr[$key]['is_chows_choice']    = $product['is_chows_choice'];
                    $cart_product_arr[$key]['product_certificate']    = $product['product_certificate'];
                    $cart_product_arr[$key]['spectrum']    = $product['spectrum'];


                    
                }       
                
                $maintotal = array_sum((array_column($cart_product_arr,'total_price')));
                $shippingsubtotal = array_sum((array_column($cart_product_arr,'shipping_charges')));
                //$wholesale_subtotal = array_sum((array_column($cart_product_arr,'total_wholesale_price')));  
            }        
           
            $arr_prefetch_user_id = array_unique(array_column($cart_product_arr, 'user_id'));
            $arr_prefetch_user_ref =  $this->UserModel
                                            ->with('seller_detail')
                                            ->whereIn('id',$arr_prefetch_user_id)->get()->toArray();

           
            $arr_prefetch_user_ref = array_column($arr_prefetch_user_ref,null, 'id');
            
            $product_sequence     = ""; 
            $arr_product_sequence = $arr_sequence = [];
            $arr_sequence         = $data_arr['sequence'];
           // dd($arr_prefetch_user_ref);
            if(isset($cart_product_arr) && sizeof($cart_product_arr)>0)
            {
                foreach($cart_product_arr as $key => $value) 
                {

                    $arr_final_data[$value['user_id']]['product_details'][$value['product_id']] = $value;
                    $arr_final_data[$value['user_id']]['seller_details'] = isset($arr_prefetch_user_ref[$value['user_id']]) ? $arr_prefetch_user_ref[$value['user_id']] : [];

                    //$arr_product_sequence[$product_sequence] = $arr_final_data;   
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
                    
                    //array_reverse($arr_relavant_sequence);
                    $arr_final_data[$_key]['product_details'] = $arr_relavant_sequence;                    
                }
            }
           
        }


  $shippingtotal  = 0;
  $total_amount   = 0;
  $fulltotal_amount   = 0;
  $category_array = [];
  $name           = [];
  $category_name = '';
  $product_array = $product_array_googleapi = $product_array_googleapi1 = [];
  $sellername ='';
  $producturl='';
  $imgurl='';
  $brand_name='';
  
  $res = [];


/*build array for klavio tracking*/
  if(isset($arr_final_data) && count($arr_final_data))
  {
      foreach($arr_final_data as $key => $product) 
      { 

 
          if(isset($product['product_details']) && count($product['product_details'])>0)
          {

            foreach ($product['product_details'] as $key => $value)
            {
               
                $product_title_slug = str_slug($value['product_name']);
                $urlbrands_name = isset($value['product_brand_detail']['name'])?str_slug($value['product_brand_detail']['name']):'';

                $sellername = get_seller_details($value['user_id']);
                   
                if(isset($sellername))
                {
                    $urlsellername = str_slug($sellername);
                }

                $producturl = url('/').'/search/product_detail/'.$value['product_id'].'/'.$product_title_slug.'/'.$urlbrands_name.'/'.$urlsellername;

                if(isset($value['product_image'][0]['image']) && !empty($value['product_image'][0]['image']))
                {
                   $imgurl = url('/').'/uploads/product_images/'.$value['product_image'][0]['image'];
                }


                $product_array[$key]['ProductID']           = $value['product_id'];
                //$product_array['SKU'] = $value[''];
                $product_array[$key]['ProductName']         = isset($value['product_name'])?$value['product_name']:'';
                $product_array[$key]['Quantity']            = isset($value['item_qty'])?$value['item_qty']:'';
                $product_array[$key]['ItemPrice']           = isset($value['total_price'])?$value['total_price']:'';
                $product_array[$key]['RowTotal']            = isset($value['total_price'])?$value['total_price']:'';
                $product_array[$key]['ProductURL']          = isset($producturl)?$producturl:'';
                $product_array[$key]['ImageURL']            = isset($imgurl)?$imgurl:'';
                $product_array[$key]['ProductCategories']   = isset($value['first_level_category_id'])?get_first_levelcategorydata($value['first_level_category_id']):'';

                $shippingtotal    += $value['shipping_charges'];
                $total_amount     += $value['total_price'];

                $fulltotal_amount  = $shippingtotal+$total_amount;

                $name[]           =  $value['product_name'];
                $category_name    =  get_first_levelcategorydata($value['first_level_category_id']);

                if(!in_array($category_name,$category_array))
                {
                  $category_array [] = $category_name;
                }//if

            }//foreach
           

          }//if product details
       
      }//foreach
      
  }//if final data

    $klaviyo_productarr = $klaviyo_arr = $lastarr = [];

    if(isset($product_array) && !empty($product_array))
    {   
        $i=1;
        foreach($product_array as $k=>$v)
        {
            $klaviyo_productarr['ProductID'] = $i;

            $klaviyo_productarr['ProductName'] = isset($v['ProductName'])?$v['ProductName']:'';
            $klaviyo_productarr['Quantity'] = isset($v['Quantity'])?$v['Quantity']:'';
            $klaviyo_productarr['ItemPrice'] = isset($v['ItemPrice'])?$v['ItemPrice']:'';
            $klaviyo_productarr['RowTotal'] = isset($v['RowTotal'])?$v['RowTotal']:'';
            $klaviyo_productarr['ProductURL'] = isset($v['ProductURL'])?$v['ProductURL']:'';
            $klaviyo_productarr['ImageURL'] = isset($v['ImageURL'])?$v['ImageURL']:'';
            $klaviyo_productarr['ProductCategories'] = isset($v['ProductCategories'])?$v['ProductCategories']:'';
            $klaviyo_arr[] = $klaviyo_productarr;

            $i++;

        }//foreach product_array
    }



    $lastarr = isset($klaviyo_arr)?end($klaviyo_arr):[];
    $res['value'] =  isset($fulltotal_amount)?$fulltotal_amount:'';
    $res['AddedItemProductName'] =  isset($lastarr['ProductName'])?$lastarr['ProductName']:'';
    $res['AddedItemPrice'] =  isset($lastarr['RowTotal'])?$lastarr['RowTotal']:'';
    $res['AddedItemQuantity'] =  isset($lastarr['Quantity'])?$lastarr['Quantity']:'';
    $res['AddedItemImageURL'] =  isset($lastarr['ImageURL'])?$lastarr['ImageURL']:'';
    $res['AddedItemURL'] =  isset($lastarr['ProductURL'])?$lastarr['ProductURL']:'';
    $res['CheckoutURL'] = url('/').'/checkout';
    $res['ItemNames'] =  isset($name)?json_encode($name):[];
    $res['AddedItemCategories'] =  isset($category_array)?json_encode($category_array):[];
    $res['Items'] =  isset($klaviyo_arr)? json_encode($klaviyo_arr):[];
 
   
    return $res;

    
 }//end klaviyo_addtoart function

    public function get_product_details($product_id, $item_qty) {

        $product_data = [];

        $product_obj = $this->ProductModel
                            ->select('id','product_name','price_drop_to', 'unit_price','product_image','shipping_type','price_drop_to','percent_price_drop')
                            ->with(['product_images_details' => function($product_images_details) {

                                $product_images_details->select('product_id' , 'image');
                            }])
                            ->where('id' , $product_id)
                            ->first();

        if ($product_obj) {

           $product_arr = $product_obj->toArray();

           $product_data['product_name']    = $product_arr['product_name'];

            if ($product_arr['shipping_type'] == 0) {

                $product_data['shipping']    = " Free Shipping";
            } 
            else {

                $product_data['shipping']    = " Flat Shipping";
            }

            $product_data['seller_type'] = check_isbestseller($product_id);

            if (isset($product_arr['price_drop_to']) && $product_arr['price_drop_to'] > 0) {

                $product_data['price']  = $product_arr['price_drop_to'] * $item_qty; 
            }
            else {
                $product_data['price']  = $product_arr['unit_price'] * $item_qty; 
            }

            if (sizeof($product_arr['product_images_details']) > 0) {

                if (file_exists($this->product_image_base_img_path.$product_arr['product_images_details'][0]['image']) && isset($product_arr['product_images_details'][0]['image'])) {

                    $product_data['product_image']   = $this->product_image_public_img_path.$product_arr['product_images_details'][0]['image']; 

                } else {

                    $product_data['product_image']   = url('/assets/images/default-product-image.png'); 
                }
            }
            else {

                $product_data['product_image']   = url('/assets/images/default-product-image.png'); 
            }

           $product_data['item_qty']        = $item_qty; 
        }

        if(isset($product_arr['percent_price_drop']) && $product_arr['percent_price_drop']=='0.000000')  {

            $percent_price_drop = calculate_percentage_price_drop($product_arr['id'],$product_arr['unit_price'],$product_arr['price_drop_to']); 
            $percent_price_drop = floor($percent_price_drop);
        }
        else {

            $percent_price_drop = floor($product_arr['percent_price_drop']);
        }

        $product_data['unit_price']     = $product_arr['unit_price'];

        $product_data['percent_price_drop'] = $percent_price_drop;

        if ($product_arr['price_drop_to'] > 0) {
            
            $product_data['is_price_drop'] = 1;
        }
        else {
            $product_data['is_price_drop'] = 0;   
        }

        return $product_data;
    }

    public function apply_delivery_optionold(Request $request) {

        //Session::flush('delivery_options_data');

        $delivery_options = Session::get('delivery_options');

        $seller_id = $request->input("seller_id");

        $delivery_options = is_array($delivery_options) ? $delivery_options: [];

        $delivery_options[$seller_id]["amount"]                 = $request->input("amount");
        $delivery_options[$seller_id]["delivery_option_id"]     = $request->input("delivery_option_id");

        Session::put('delivery_options',$delivery_options);

        $response['status'] = 'SUCCESS';
        $response['description'] = "Delivery Option applied Succcessfully";

        return response()->json($response);
    }





    function apply_delivery_option(Request $request)
    {
        $formData   = $request->all(); 
        $loggedIn_Id = 0;

         $loginuser = Sentinel::check();

        if ($loginuser) 
        {

            $loggedIn_Id = $loginuser->id;
        }

       // $product_id = $formData['product_id'];
        $amount = isset($formData['amount'])?$formData['amount']:""; 
        $seller_id = isset($formData['seller_id'])?$formData['seller_id']:""; 
        $delivery_option_id = isset($formData['delivery_option_id'])?$formData['delivery_option_id']:""; 

        if(isset($amount) && isset($seller_id) && isset($delivery_option_id))
        {

              // dd(Session::get('sessioncoupon_data'));

            $check_seller_deliveryoption = check_seller_deliveryoption($seller_id);


            if(isset($check_seller_deliveryoption) && $check_seller_deliveryoption==1)
            {


                $getoptioninfo = get_seller_deliver_options($seller_id,$delivery_option_id);


                if(isset($getoptioninfo) && !empty($getoptioninfo))
                {

                    if($getoptioninfo['id']==$delivery_option_id)
                    {

                            $id       = $getoptioninfo['id'];
                            $title = $getoptioninfo['title'];
                            $day     = $getoptioninfo['day'];
                            $dbsellerid   = $getoptioninfo['seller_id'];
                            $cost   = $getoptioninfo['cost'];

                                     
                       
                            $exisiting_option_data = Session::get('sessiondeliveryoption_data');
                            $exisiting_option_data = is_array($exisiting_option_data) ? $exisiting_option_data: [];

                            $exisiting_option_data[$dbsellerid]['delivery_option_id'] = $delivery_option_id;
                            $exisiting_option_data[$dbsellerid]['title'] = $title;
                             $exisiting_option_data[$dbsellerid]['seller'] = $seller_id;
                            $exisiting_option_data[$dbsellerid]['day'] = $day;           
                            $exisiting_option_data[$dbsellerid]['cost'] = $cost;

                            Session::put('sessiondeliveryoption_data',$exisiting_option_data);

                           // dd(Session::get('sessiondeliveryoption_data'));

                             $response['status'] = 'SUCCESS'; 
                             $response['description'] = "Delivery option Applied Succcessfully";
                             return response()->json($response);
                            

                      

                    }//else
                    else
                    {
                         $response['status'] = 'FAILURE'; 
                         $response['description'] = "Delivery options is not applicable for this dispensary.";
                         return response()->json($response);

                    }//else

                }
                else
                {
                     $response['status'] = 'FAILURE'; 
                     $response['description'] = "Delivery options is not applicable for this dispensary.";
                     return response()->json($response);

                }//else

            }//if check_seller_deliveryoption    
            else
            {
                 $response['status'] = 'FAILURE'; 
                 $response['description'] = "Invalid Delivery options";
                 return response()->json($response);

             }//else

                 
        }
        else{
            $response['status'] = 'FAILURE'; 
            $response['description'] = "Something went wrong";
            return response()->json($response);
        }//else isset

    }//end applycouponcode

    public function clear_delivery_option(Request $request) {

        $seller_id          = $request->input('seller_id');

        $seller_obj = $this->UserModel
                            ->where('id' , $seller_id)
                            ->first();
        if ($seller_obj) {
            $seller_arr = $seller_obj->toArray();
        }
        else {

            $response['status'] = 'FAILURE'; 
            $response['description'] = "Something went wrong";
            return response()->json($response);
        }

        $delivery_option    = Session::get('sessiondeliveryoption_data');

        $delivery_option_data   = is_array($delivery_option) ? $delivery_option: [];

        unset($delivery_option_data[$seller_arr['id']]);

        Session::put('sessiondeliveryoption_data',$delivery_option_data);

        $response['status']         = 'SUCCESS';
        $response['description']    = "Delivery Option applied Succcessfully";

        return response()->json($response);
    }
}
