@extends('front.layout.master')
 @section('main_content') 



@php 
if(isset($site_setting_arr) && count($site_setting_arr)>0)
{
     $payment_mode = $site_setting_arr['payment_mode'];
     $sandbox_js_url = $site_setting_arr['sandbox_js_url'];
     $live_js_url = $site_setting_arr['live_js_url'];

     $sandbox_application_id = $site_setting_arr['sandbox_application_id'];
     $live_application_id = $site_setting_arr['live_application_id'];

     $payment_gateway_switch = $site_setting_arr['payment_gateway_switch'];

}
@endphp



<style>
  .checkout-wallet{
    background-color: #873dc8;
    color: white;
    padding: 10px;
  }
  .pac-container{z-index: 9999;}
  .mybaglists.list-checkout-item .list-serv-itms.mybag-listpage .itm-left-list{
        margin: 0 0 10px;
  }
  .checkoutphone-err .parsley-errors-list{bottom: -32px;}
  .sweet-alert h3 {
    color: #575757;
    font-size: 21px;
    text-align: center;
    font-weight: lighter;
    text-transform: none;
    position: relative;
    margin: 10px 0;
    padding: 0;
    line-height: 27px;
    display: block;
}
.age-img-plus.small-size-age {
    display: inline-block;
    vertical-align: middle;
}
  .shippingtype-div.showshippingdiv {
    display: inline-block;
    /*margin-left: 20px;*/
}
.shippingtype-div.showshippingdiv {
    display: inline-block;

    background-color: #873dc8;
    padding: 4px 10px;
    font-size: 12px;
    border-radius: 30px;
    color: #fff;
    font-weight: 600;
}
  
  .colorbk{display: inline-block; color: #333 !important;}
.age-img-plus.small-size-age {width: 30px;margin-bottom: 6px;}
  .form-group.zip-errorm .parsley-errors-list{top: 71px; bottom: auto;}
  .quantity-tx span{font-size: 14px;}
  ul.social-footer li a {
    padding-top: 8px !important;
}
.error.erorsms-checkout{margin-bottom: 30px; display: block;width: 100%;}

/*input{font-size: 14px !important;}*/
.back-to-cart {
    background-color: #666;
    color: #fff;
    display: block;
    border: 1px solid #666;
    text-align: center;
    padding: 8px 10px;
    border-radius: 4px;
    font-size: 15px;
}
.inlineblock-view {
    display: inline-block; margin-left: 5px;padding-left: 0px;
}
.back-to-cart:hover{
    background-color: #fff;
    color: #444;
    border: 1px solid #666;
}
.error.erorsms-checkout li{
font-size: 13px;
    color: #ca1212;
    display: block;
    padding: 5px 10px;
    background-color: #ffefef;
    margin-bottom: 5px;
    border-radius: 3px;
    width: 100%;
}
.modal-hr{
  margin-top: 0px !important;
  margin-bottom: 16px !important;
}

 .shipaddr {
    display: inline-block;
    max-width: none !important;
    margin-top: 4px;
}




.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
    border: 1px solid #fff !important;
    background: #ffffff;
    font-weight: normal;
    color: #454545 !important;
}
.ui-datepicker td span, .ui-datepicker td a {
    padding: 0.4em .2em;
}
.userdetaild-modal{margin-top: 25%;}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active,
a.ui-button:active,
.ui-button:active,
.ui-button.ui-state-active:hover {
  border: 1px solid #873dc8 !important;
  background: #873dc8 !important;
  font-weight: normal;
  color: #ffffff !important; border-radius: 4px;
}
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
  padding: 2px 5px;
}
.ui-datepicker .ui-datepicker-next {
    right: 1px;
}
.ui-datepicker .ui-datepicker-prev {
    left: 1px;
}
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next {
    top: 1px;
}

.clearwalletamount{
      background-color: #873dc8 !important;
    color: #fff !important;
    position: absolute;
    right: 0;
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
    top:0;
        width: 100px;
}

@media (max-width: 650px){
  .headerchnagesmobile .logo-block.mobileviewlogo{
        width: 55vw;
  }
}
@media (max-width: 520px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 53vw;
}
}
@media (max-width: 450px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 45%;
}
}
@media (max-width: 414px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 35%;
}
}
@media (max-width: 350px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 30%;
}
.main-logo {
    width: 70px;
    margin-top: 11px !important;
}
}
</style> 
@php

 $login_user = Sentinel::check();


if(isset($arr_final_data)){
   if(count($arr_final_data) > 0){
    $product_ids='';
    foreach($arr_final_data as $product_arr)
    {    
        $product_id_arr =[];
        foreach($product_arr['product_details'] as $product)
        {
              $product_id_arr[] =   $product['product_id'];
        }
    }     
   $product_ids = implode(",", $product_id_arr);  
  }
}

 if(isset($cart_product_arr))
 {
   if(count($cart_product_arr)<=0)
   {
     echo "<script>window.location='".url('/')."';</script>";
   }

 }

$buyer_age_verification_status ='';
if(isset($buyer_details['buyer_detail']) && count($buyer_details['buyer_detail']) > 0) 
{
   $buyer_age_verification_status = $buyer_details['buyer_detail']['approve_status'];
}


 $user_details = false;
 $user_details = Sentinel::getUser();  
 if(isset($user_details)){      
 $user_details_arr = $user_details->toArray();
}//if isset user details

 if(isset($user_details_arr) && count($user_details_arr)>0)
 {
  $user_street_address = preg_replace("/\r|\n/", "", $user_details_arr['street_address']);
  $user_state = $user_details_arr['state'];
  $user_country = $user_details_arr['country'];
  $user_zipcode = $user_details_arr['zipcode'];
  $user_city = $user_details_arr['city'];
  $user_billing_street_address = preg_replace("/\r|\n/", "",$user_details_arr['billing_street_address']);
  $user_billing_state = $user_details_arr['billing_state'];
  $user_billing_country = $user_details_arr['billing_country'];
  $user_billing_zipcode = $user_details_arr['billing_zipcode'];
  $user_billing_city = $user_details_arr['billing_city'];

  $user_approve_status = $user_details_arr['approve_status'];

  $user_fname = $user_details_arr['first_name'];
  $user_lname = $user_details_arr['last_name'];
  $phone = $user_details_arr['phone'];
  $date_of_birth = $user_details_arr['date_of_birth'];


 }


 $checkuser_locationdata = checklocationdata(); 
 if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
 {
   $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
 } 

if(isset($catdata) && !empty($catdata))
{
  $catdata = $catdata;
}else{
  $catdata =[];
}


 /*******************Restricted states seller id*********************/

  $check_buyer_restricted_states =  get_buyer_restricted_sellers();
  $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];

  $restricted_state_sellers = [];
   if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids)){

      $restricted_state_sellers = [];
      foreach($restricted_state_user_ids as $sellers) {
        $restricted_state_sellers[] = isset($sellers['id'])?$sellers['id']:'';
      }
   }
    $is_buyer_restricted_forstate = is_buyer_restricted_forstate();
   
/********************Restricted states seller id***********************/


@endphp 


{{-- <input type="hidden" id="appId" value="{{config('app.project.square_application_id')}}">
 --}}

<input type="hidden" id="appId" 
@if($payment_mode=='0' && isset($sandbox_application_id))
value="{{ $sandbox_application_id }}"
@elseif($payment_mode=='1' && isset($live_application_id))
value="{{ $live_application_id }}" @endif>






@if( isset($arr_final_data) && count($arr_final_data)>0)
<div class="cart-section-block">
    <a href="{{url('/')}}/my_bag" class="cart-step-one">
        <div class="step-one">
            <span class="num-step num-step-hide">1</span>
            <span class="step-tick"> </span>
            <span class="name-step-confirm">Shopping Cart</span>
        </div>
        <div class="clearfix"></div>
    </a>

    @if(count($arr_final_data) > 0)
        {{-- <a href="{{url('/')}}/checkout" class="cart-step-one"> --}}
        <a href="javascript:void(0)" class="cart-step-one">
    @else
        <a href="javascript:void(0)" class="cart-step-one">
    @endif 

        <div class="step-one step-active">
          <span class="num-step font-style"> </span>
          <span class="name-step-confirm">Payment & Billing </span>
        </div>
        <div class="clearfix"></div>
    </a>
    <a href="javascript:void(0)" class="cart-step-one">
        <div class="step-one last-cart-step">
            <span class="num-step font-style"> </span>
            <span class="name-step-confirm">Order Placed</span>
        </div>
      <div class="clearfix"></div>
    </a>
    <div class="clearfix"></div>
</div>
@endif



 <div class="checkout-new-pg-main checkoutupdate">
  <div class="container">

<!---------------------age-verification message------------------->


@php
  $checkflag = 0;
  $buyerage_flag = 0;
  $remainingstock=0;


  $checkcouponcodeforseller = $checkcouponcodeforseller1 = $setproductids = $checkcouponproduct = $sessioncoupon_data = [];
  $get_total_amountofsellers = []; $totalpriceofseller = [];

  $check_deliveryoptforseller1 = $sessiondeliveryoption_data = $totalpriceof_optionseller = [];

 @endphp
@if(count($arr_final_data) > 0)

  @foreach($arr_final_data as $keys=>$product_arr)   
     
     @php 
        if(is_array(Session::get('sessioncoupon_data')) && !empty(Session::get('sessioncoupon_data')))
        {
          $sessioncoupon_data =  Session::get('sessioncoupon_data');
        }       

        

         if(!in_array($keys,$checkcouponcodeforseller1))
        {
           array_push($checkcouponcodeforseller1,$keys);
           
        }
     @endphp       

     @php 

        // code for session delivery data 
        if(is_array(Session::get('sessiondeliveryoption_data')) && !empty(Session::get('sessiondeliveryoption_data')))
        {
          $sessiondeliveryoption_data =  Session::get('sessiondeliveryoption_data');
        }       
        if(!in_array($keys,$check_deliveryoptforseller1))
        {
           array_push($check_deliveryoptforseller1,$keys);
        }
     @endphp    



    @foreach($product_arr['product_details'] as $product)

      @if(isset($sessioncoupon_data[$keys]))
        @php 
        foreach($sessioncoupon_data as $ks=>$val){
           if($ks==$product['user_id'])  {
             // $totalpriceofseller[$ks][$product['product_id']]['total'] = $product['total_price']+$product['shipping_charges'];
             $totalpriceofseller[$ks][$product['product_id']]['total'] = $product['total_price'];
             $totalpriceofseller[$ks][$product['product_id']]['couponid'] = $val['couponcodeId'];
             $totalpriceofseller[$ks][$product['product_id']]['productid'] = $product['product_id'];

             $totalpriceofseller[$ks][$product['product_id']]['couponcode'] = $val['couponcode'];
             $totalpriceofseller[$ks][$product['product_id']]['discount'] = $val['discount'];
       
            
           }//if userid is same
        }//if session coupondata                
        @endphp
        @endif  


        @if(isset($sessiondeliveryoption_data[$keys]))
        @php 
        foreach($sessiondeliveryoption_data as $ks1=>$val1){
           if($ks1==$product['user_id'])  {
              $totalpriceof_optionseller[$ks1][$product['product_id']]['total'] = $product['shipping_charges'];
            // $totalpriceof_optionseller[$ks1][$product['product_id']]['total'] = $product['total_price'];
             $totalpriceof_optionseller[$ks1][$product['product_id']]['id'] = isset($val1['delivery_option_id'])?$val1['delivery_option_id']:'';
             $totalpriceof_optionseller[$ks1][$product['product_id']]['productid'] = $product['product_id'];

             $totalpriceof_optionseller[$ks1][$product['product_id']]['day'] = isset($val1['day'])?$val1['day']:'';
             $totalpriceof_optionseller[$ks1][$product['product_id']]['cost'] = isset($val1['cost'])?$val1['cost']:'';
             $totalpriceof_optionseller[$ks1][$product['product_id']]['title'] = isset($val1['title'])?$val1['title']:'';
            
           }//if userid is same
        }//if session delivery data                
        @endphp
        @endif  



           @php


                 $firstcat_id = $product['first_level_category_id'];
                 // $is_age_limit = isset($product['is_age_limit'])?$product['is_age_limit']:'';
                 // $age_restriction = isset($product['age_restriction'])?$product['age_restriction']:'';


                 $is_age_limit = isset($product['first_level_category_details']['is_age_limit'])?$product['first_level_category_details']['is_age_limit']:'';
                 $age_restriction = isset($product['first_level_category_details']['age_restriction'])?$product['first_level_category_details']['age_restriction']:'';

                 $remainingstock = get_remaining_stock($product['product_id']); 
                 if(isset($catdata) && !empty($catdata))
                 {
                    // if(in_array($firstcat_id, $catdata))
                    if((in_array($firstcat_id, $catdata) && isset($remainingstock) && $remainingstock>0) || (in_array($firstcat_id, $catdata) && isset($remainingstock) && $remainingstock<=0))
                    { 
                      $checkflag++; 
                      // echo "==".$checkflag;
                     // break;
                    }
                    else if(isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) && !empty($age_restriction) && 
                      $buyer_age_verification_status!="1")
                    {
                     
                       $buyerage_flag++; 
                    }
                    else{
                      //$checkflag = 0;
                    }
                 }
      @endphp
    @endforeach
 @endforeach    
@endif  

@php


       // code for coupon code


     $newarr = [];  $seller_totalall_amt =0;
    if(isset($totalpriceofseller) && !empty($totalpriceofseller)){
    foreach($totalpriceofseller as $k2=>$v2)
    {

     
       $newarr[$k2]['seller'] = $k2;
       $newarr[$k2]['sellername'] = get_seller_details($k2);

        foreach($v2 as $prd=>$data)
        {
          $newarr[$k2]['discount'] = $data['discount'];
          $newarr[$k2]['couponcode'] = $data['couponcode'];
          $newarr[$k2]['couponid'] = $data['couponid'];
          $newarr[$k2]['total'][] = $data['total'];
       }

       $newarr[$k2]['seller_total_amt'] = array_sum($newarr[$k2]['total']);

       if(isset($newarr[$k2]['discount']))
       {
          $newarr[$k2]['seller_discount_amt'] = $newarr[$k2]['seller_total_amt']*$newarr[$k2]['discount']/100;

           $seller_totalall_amt += $newarr[$k2]['seller_discount_amt'];
       }

     }//foreach              
   }//if totalpriceofseller
   
@endphp



@php 
    // code for delivery options

     $newarr_options = [];  $seller_totalall_option_amt =0;
    if(isset($totalpriceof_optionseller) && !empty($totalpriceof_optionseller)){
    foreach($totalpriceof_optionseller as $k22=>$v22)
    {

     
       $newarr_options[$k22]['seller'] = $k22;
       $newarr_options[$k22]['sellername'] = get_seller_details($k22);

        foreach($v22 as $prd=>$data)
        {
          $newarr_options[$k22]['id'] = $data['id'];
          $newarr_options[$k22]['cost'] = $data['cost'];
          $newarr_options[$k22]['title'] = $data['title'];
          $newarr_options[$k22]['day'] = $data['day'];
          //$newarr_options[$k22]['total'][] = $data['total'];
       }

       //$newarr[$k22]['seller_total_amt'] = array_sum($newarr[$k22]['total']);

       if(isset($newarr_options[$k22]['cost']))
       {
          $newarr_options[$k22]['seller_option_amt'] = $newarr_options[$k22]['cost'];

           $seller_totalall_option_amt += $newarr_options[$k22]['cost'];
       }

     }//foreach              
   }//if totalpriceof_optionseller

@endphp





 @php 


     // code for coupon code amount 
     if(isset($seller_totalall_amt) && !empty($seller_totalall_amt)){
        $subtotal = $subtotal- $seller_totalall_amt;
     }
     else{
        $subtotal = $subtotal;  
     }

     // code for delivery option amount
      if(isset($seller_totalall_option_amt) && !empty($seller_totalall_option_amt)){
        $subtotal = $subtotal+ $seller_totalall_option_amt;
     }
     else{
        $subtotal = $subtotal;  
     }


     //code for session wallet amount
     
    if(is_array(Session::get('sessionwallet_data')) && !empty(Session::get('sessionwallet_data')))
     {
          $sessionwallet_data =  Session::get('sessionwallet_data');
          if(isset($sessionwallet_data['amount']))
          {
            $subtotal = $subtotal - $sessionwallet_data['amount'];  
          }
          else
          {
            $subtotal = $subtotal;
          }

     }       

     
      $current_wallet_amt =0;

              
          

    $tax_amount_to_pay = 0; $tax_err_arr =[];
    if(isset($seller_wise_total_order_amount) && !empty($seller_wise_total_order_amount))
    {
      foreach($seller_wise_total_order_amount as $k7=>$v7)
      {
        
          if(isset($v7['tax']) && $v7['tax']>=0)
           {
             $tax_amount_to_pay += $v7['tax'];
           }

          if(isset($v7['message']) && !empty($v7['message']))  
          {
             $tax_err_arr[$v7['message']] = $v7['message'];
          }
       
     
      }//foreach
   }//if
               
    // code for taxjar amount
      if(isset($tax_amount_to_pay) && !empty($tax_amount_to_pay)){
        $subtotal = $subtotal+ $tax_amount_to_pay;
     }
     else{
        $subtotal = $subtotal;  
     }             
               


 @endphp

<!-------------------age verification message end-------------------->

   
 


   <div class="checkout-new-pg-main-left">


    <div class="checkout-walletpbox-walt">
             <div class="yourwalt-amt"><span>Settled Wallet Amount:</span> {{ isset($buyer_wallet_amt)? '$'.$buyer_wallet_amt:'0' }} </div>

              @if(is_array(Session::get('sessionwallet_data')) && !empty(Session::get('sessionwallet_data')))
               @php
              $current_wallet_amt =0;
              $sessionwallet_data =  Session::get('sessionwallet_data');
              if(isset($sessionwallet_data['amount']) && isset($buyer_wallet_amt) && $buyer_wallet_amt>0)
              {

                $current_wallet_amt = $buyer_wallet_amt - $sessionwallet_data['amount'];  
              }
              else if(isset($buyer_wallet_amt) && $buyer_wallet_amt>0)
              {
                $current_wallet_amt = $buyer_wallet_amt;  
              }
              @endphp
            @else
                @php
                 $current_wallet_amt = isset($buyer_wallet_amt)?$buyer_wallet_amt:0; 
                 @endphp
            @endif 
            {{--  <div class="yourwalt-amt"><span>Current Wallet Amount:</span>{{ isset($current_wallet_amt)? ' $'.$current_wallet_amt:'0' }}</div> --}}


             @php  

                $referalcode = '';          
                $get_buyer_referal_code = get_buyer_referal_code();
                if(isset($get_buyer_referal_code))
                {
                  $referalcode = $get_buyer_referal_code;
                }
                $buyer_referal_amount = $buyer_refered_amount = '';
                $buyer_referal_amountarr =get_buyer_referal_amount_details();

                if(isset($buyer_referal_amountarr) && !empty($buyer_referal_amountarr))
                {
                   $buyer_referal_amount = isset($buyer_referal_amountarr)?$buyer_referal_amountarr:'';
                }

                $buyer_refered_amountarr =get_buyer_refered_amount_details();

                if(isset($buyer_refered_amountarr) && !empty($buyer_refered_amountarr))
                {
                   $buyer_refered_amount = isset($buyer_refered_amountarr)?$buyer_refered_amountarr:'';
                } 
             @endphp


             <div class="yourwalt-amt"><a target="_blank" href="{{ url('/')}}/referbuyer?referalcode={{ $referalcode }}" class="btn btn-default">Give {{ '$'.$buyer_refered_amount }} for {{ '$'.$buyer_referal_amount }}. Refer a friend now</a></div>

         <br/>

         <div class="wallet-form">
               @if(is_array(Session::get('sessionwallet_data')) && !empty(Session::get('sessionwallet_data')))
                 @php
                      $sessionwallet_data =  Session::get('sessionwallet_data');
                 @endphp

                   <input type="text" class="form-control" placeholder="Please enter wallet amount to reedem" name="wallet_amount" id="wallet_amount" value="{{ isset($sessionwallet_data['amount'])?$sessionwallet_data['amount']:'' }}">
                   <span id="walleterr"></span>

                    <a href="#" class="btn clearwalletamount" onclick="clearwalletamount({{$sessionwallet_data['buyer'] or '' }});"><i class="fa fa-times"> </i> Clear</a>

                @else  
                   <input type="text" class="form-control" placeholder="Please enter wallet amount to reedem" name="wallet_amount" id="wallet_amount">
                   <span id="walleterr"></span>
                   <a href="#" class="btn applywallet" >Apply</a>                 
                @endif   


         </div>
    </div>
     
     


      <!------------show signup and signin forms-for guest user----------->
          @if(isset($login_user) && $login_user==true)
          @else
          @endif  
      <!-----------end-of-show signup and signin forms-for guest user----------> 
    <div class="showinmobile-btn">

          @if(isset($login_user) && $login_user==true)
          <button type="button" class="linksbuttons" id="sq-creditcard" onclick="onGetCardNonce(event);">Place your order</button>
          @endif


     </div>
      <div class="shipping-address-address none-prdinght">
        <form method="POST" id="nonce-form">
                    {{csrf_field()}}
          

          {{-- @php dump($has_age_verified_product_in_cart) @endphp --}}
          <div class="shippingaddress-check"><div class="cout-one">1.</div> Shipping Address</div>
           <span class="fullname-shipping">
             @if(isset($user_fname) && !empty($user_fname)) {{ ucfirst($user_fname) }} @endif
             @if(isset($user_lname) && !empty($user_lname)) {{ ucfirst($user_lname) }} @endif
           </span>
           

          @if(isset($buyer_details['buyer_detail']) && count($buyer_details['buyer_detail']) > 0)

            <!------If age approved and in cart there are age verified products----and not any add or edit address button here-------->

           {{--  @if(isset($buyer_details['buyer_detail']['approve_status']) && $buyer_details['buyer_detail']['approve_status'] == 1 && $has_age_verified_product_in_cart!=0)

              
                <div class="shippingaddress-chow shipaddr">{{isset($buyer_details['buyer_detail']['age_address'])?$buyer_details['buyer_detail']['age_address']:'-'}}</div>
                <input type="hidden" name="shipping_addr" value="{{isset($buyer_details['buyer_detail']['age_address'])?$buyer_details['buyer_detail']['age_address']:'-'}}">


            @else --}}
            <!------If in cart there are age verified products------------>

              
              <div class="shippingaddress-chow shipaddr">
              {{isset($buyer_details['street_address'])?$buyer_details['street_address'].', ':''}}{{isset($buyer_details['city'])?$buyer_details['city'].', ':''}} 

              @if(isset($buyer_details['get_state_detail']['name']) && (isset($buyer_details['city'])))
                {{isset($buyer_details['get_state_detail']['name'])?$buyer_details['get_state_detail']['name'].',':''}}
              @else
                {{isset($buyer_details['get_state_detail']['name'])?$buyer_details['get_state_detail']['name'].',':''}}
              @endif


              {{isset($buyer_details['get_country_detail']['name'])?$buyer_details['get_country_detail']['name'].',':''}}
              {{isset($buyer_details['zipcode'])?$buyer_details['zipcode']:''}}
              </div>  


              <input type="hidden" id="shipping_addr_preage" name="shipping_addr" value="{{isset($buyer_details['street_address'])?$buyer_details['street_address']:'-'}}">
             {{--  <input type="hidden" id="country" name="country" value="{{isset($buyer_details['country'])?$buyer_details['country']:'-'}}"> --}}
              <input type="hidden" id="shipp_country" name="country" value="{{isset($buyer_details['country'])?$buyer_details['country']:'-'}}">
              <input type="hidden" id="state" name="state" value="{{isset($buyer_details['state'])?$buyer_details['state']:'-'}}">
              <input type="hidden" id="zipcode" name="zipcode" value="{{isset($buyer_details['zipcode'])?$buyer_details['zipcode']:'-'}}">
               <input type="hidden" id="city" name="city" value="{{isset($buyer_details['city'])?$buyer_details['city']:'-'}}">
               
              @if($buyer_details['street_address']=="" || $buyer_details['city']=="" || $buyer_details['zipcode']=="" || $buyer_details['state']=="" || $buyer_details['country']=="") 
              <div class="shippingaddress-changebtn editaddress">
                <a class="" id="shippingaddress-btn"><i class="fa fa-edit"></i> Add Address</a>
              </div>
              @else
              <div class="shippingaddress-changebtn editaddress">
                <a class="" id="shippingaddress-btn"><i class="fa fa-edit"></i> Edit Address</a>
              </div>
              <div class="clearfix"></div>

              @endif

            {{-- @endif --}}
          @else
               <!-------------if guest user------------------>

              {{--   @if(isset($login_user) && $login_user==true)
                @else
                    <div class="shippingaddress-changebtn editaddress">
                      <a class="" id="shippingaddress-btn"><i class="fa fa-edit"></i> Add Address</a>
                    </div>
                @endif --}}

          @endif
          
          <div class="clearfix"></div>
      </div>
          
          {{-- <div class="shippingaddress-check"><div class="cout-one">2.</div> Payment Method</div> --}}
          <div class="payment-method-inlineblock">
              <div class="billingaddress-chow billingadrs shipping-address-address"><b>Billing Address:</b> 
                
                <span class="fullname-shipping">
                 @if(isset($user_fname) && !empty($user_fname)) {{ ucfirst($user_fname) }} @endif
                 @if(isset($user_lname) && !empty($user_lname)) {{ ucfirst($user_lname) }} @endif
                </span>
               


                @if(isset($buyer_details['buyer_detail']) && count($buyer_details['buyer_detail']) > 0)
                   {{-- @if(isset($buyer_details['buyer_detail']['approve_status']) && $buyer_details['buyer_detail']['approve_status'] == 1  && $has_age_verified_product_in_cart!=0)

                    <div class="shippingaddress-chow">{{isset($buyer_details['buyer_detail']['age_address'])?$buyer_details['buyer_detail']['age_address']:'-'}}</div>
                    <input type="hidden" name="billing_addr" value="{{isset($buyer_details['buyer_detail']['age_address'])?$buyer_details['buyer_detail']['age_address']:'-'}}">

                   @else
                   --}}
                    <div class="shippingaddress-chow">
                    {{isset($buyer_details['billing_street_address'])?$buyer_details['billing_street_address'].',':'-'}}
                    {{isset($buyer_details['billing_city'])?$buyer_details['billing_city'].',':''}}
                    {{isset($buyer_details['get_billing_state_detail']['name'])?$buyer_details['get_billing_state_detail']['name'].',':''}}
                     {{isset($buyer_details['get_billing_country_detail']['name'])?$buyer_details['get_billing_country_detail']['name'].',':''}}
                     {{isset($buyer_details['billing_zipcode'])?$buyer_details['billing_zipcode'].',':''}}
                    </div> 


                    <input type="hidden" name="billing_addr" value="{{isset($buyer_details['billing_street_address'])?$buyer_details['billing_street_address']:'-'}}"> 
                    <input type="hidden" id="billing_country" name="billing_country" value="{{isset($buyer_details['billing_country'])?$buyer_details['billing_country']:'-'}}">
                    <input type="hidden" id="billing_state" name="billing_state" value="{{isset($buyer_details['billing_state'])?$buyer_details['billing_state']:'-'}}">
                    <input type="hidden" id="billing_zipcode" name="billing_zipcode" value="{{isset($buyer_details['billing_zipcode'])?$buyer_details['billing_zipcode']:'-'}}">
                    <input type="hidden" id="billing_city" name="billing_city" value="{{isset($buyer_details['billing_city'])?$buyer_details['billing_city']:'-'}}">


                    @if($buyer_details['billing_street_address']=="" || $buyer_details['billing_country']=="" || $buyer_details['billing_state']=="" || $buyer_details['billing_zipcode']=="" || $buyer_details['billing_city']=="")
                     <div class="shippingaddress-changebtn editaddress">
                      <a class="" id="shippingaddress-btn"><i class="fa fa-edit"></i> Add Address</a>
                    </div>
                    
                    @else

                     <div class="shippingaddress-changebtn editaddress">
                      <a class="" id="shippingaddress-btn"><i class="fa fa-edit"></i> Edit Address</a>
                    </div>
                    <div class="clearfix"></div>

                    @endif


               {{--    @endif --}}

                 @else
                     <!-------------if guest user------------------>

                    {{--   @if(isset($login_user) && $login_user==true)
                      @else
                          <div class="shippingaddress-changebtn editaddress">
                            <a class="" id="shippingaddress-btn"><i class="fa fa-edit"></i> Add Address</a>
                          </div>
                      @endif   --}}

                @endif
              </div> <!------billingaddress-chow ----------------->

              <div class="shippingaddress-check"><div class="cout-one">2.</div> Payment Method</div>
              {{-- <a href="#" class="linkchangestext">Change</a> --}}
              <div class="add-giftcardmain">
                  
              <!-- CREDIT CARD FORM STARTS HERE -->
              <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                  <div class="row display-tr" >
                    <h3 class="panel-title display-td" >Payment Details</h3>
                    <div class="display-td" >
                      
                    </div>
                  </div>
                </div> 
                <div class="panel-body">
                   <input type="hidden" id="testval" name="testval" value="{{isset($subtotal)? base64_encode(num_format($subtotal)):0}}">

                  @if(isset($payment_gateway_switch) && !empty($payment_gateway_switch))

                    @if($payment_gateway_switch=="square")
                  
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="form-group">
                          <label for="cardNumber">Card Number <span>*</span></label>
                          <div class="input-group">
                            <input type="tel" class="form-control" id="sq-card-number" name="cardNumber" placeholder="Please enter card number" />
                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                          </div>
                          <span id='cardNumber_error'></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-7 col-md-7">
                        <div class="form-group">
                          <label for="cardExpiry">Expiry Date <span>*</span></label>
                          <input type="tel" class="form-control" id="sq-expiration-date" name="cardExpiry" placeholder="MM / YY" />
                          <span id='expirationDate_error'></span>
                        </div>
                      </div>
                      <div class="col-xs-5 col-md-5 pull-right">
                        <div class="form-group">
                          <label for="cardCVC">CVV <span>*</span>

                            <span class="colorbk" data-toggle="tooltip" data-html="true" title="What is CVV? <br> The CVV number is the last three digits on the back of your card. "><i class="fa fa-info-circle" aria-hidden="true"></i></span>

                           

                          </label>
                          <input type="text" id="sq-cvv" class="form-control" name="CVV" placeholder="CVV" />
                          <span id='cvv_error'></span>
           
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="form-group">
                          <label for="couponCode">Name on Card </label>
                          <input type="text" class="form-control" name="text" placeholder="Card holder’s name" data-parsley-required="true" data-parsley-pattern="^[A-Za-z]*$" data-required-message="Please enter card holder's name"/>
                        </div>
                      </div>
                    </div>

                    @elseif($payment_gateway_switch=="authorizenet")
               
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="cardNumber">Card Number <span>*</span></label>
                          <input class="form-control" type="text" name="cardNumber" id="cardNumber" placeholder="Card Number" required="required" onkeypress="return isNumberKey(event)"/> <div id="carderr"></div>
                      </div>
                      </div>

                       <div class="col-md-6">
                         <div class="form-group">
                          <label for="cardCVC">CVV <span>*</span>
                            <span class="colorbk" data-toggle="tooltip" data-html="true" title="What is CVV? <br> The CVV number is the last three digits on the back of your card. "><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                           <input class="form-control" type="text" name="cardCode" id="cardCode" placeholder="CVV" required="required" onkeypress="return isNumberKey(event)" maxlength="4"/> <div id="cvverr"></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="cardExpiry">Expiry Month <span>*</span></label>
                        <input class="form-control" type="text" name="expMonth" id="expMonth" placeholder="MM" required="required" onkeypress="return isNumberKey(event)" maxlength="2" />  <div id="montherr"></div>
                      </div>
                      </div>
                      <div class="col-md-6">
                         <div class="form-group">
                            <label for="cardExpiry">Expiry Year <span>*</span></label>

                             <input class="form-control" type="text" name="expYear" id="expYear" placeholder="YY" required="required" onkeypress="return isNumberKey(event)" maxlength="4"/> <div id="yearerr"></div>
                          </div>
                      </div>
                     

                    </div>

                    @endif
                 
                 @endif

                 
                  <input type="hidden" id="amount" name="amount" value="{{isset($subtotal)?num_format($subtotal):0}}">
                  @php
                      $login_user = Sentinel::check();
                      if($login_user){

                          $user_id = $login_user->id;
                      }
                  @endphp
                  <input type="hidden" id="buyer_id" name="buyer_id" value="{{isset($user_id)?$user_id:0}}">
                  <input type="hidden" id="card-nonce" name="nonce">
                </div>
              </div>
              <!-- CREDIT CARD FORM ENDS HERE -->

              </div>
          </div>
          {{-- <a href="#" class="changebuttons">Change</a> --}}
          <div class="clearfix"></div>

              <div class="mobileview-visible">
                 @if(isset($login_user) && $login_user==true)
                <a type="button" class="placeyourorder" id="sq-creditcard" onclick="onGetCardNonce(event)">Place your order</a>
             @else
                <a type="button" class="placeyourorder" id="sq-creditcard" onclick="return gobacktosignup()">Place your order</a>
             @endif
              </div>
      <div class="review-itemsshipngs">
          
          <div class="shippingaddress-check"><div class="cout-one">3.</div> Review items and shipping</div>
      </div>

      <div class="listing-checkouts-prime">
        <input type="hidden" name="hidden_product_ids" id="hidden_product_ids" value="{{ isset($product_ids)?$product_ids:'' }}" />
     

          @php 
              $remaining_stock =0;
              $checkout_brandname ='';
              $checkout_sellername ='';

              $pageclick=[];

         
          @endphp
           <div class="apply-coupon-div checkoutapply">

                @if(isset($sessioncoupon_data) && count($sessioncoupon_data) > 0)
                  @php $coupon_codes_in_session = array_values($sessioncoupon_data); @endphp
               
                  <input type="text" placeholder="Please enter coupon code" name="coupon_code" class="form-control" readonly="" value="{{ $coupon_codes_in_session[0]['couponcode'] or ''}}" seller_id="{{ $coupon_codes_in_session[0]['seller'] }}"/>

                      <a href="#" class="btn" onclick="clearCouponCode({{$coupon_codes_in_session[0]['seller'] }});"><i class="fa fa-times"> </i> Clear</a>

                @else
                  @if(isset($login_user) && $login_user==true)
                    <input type="text" class="form-control" placeholder="Please enter coupon code" name="coupon_code" id="coupon_code">
                    <a href="#" class="btn applycoupon-common" >Apply</a>
                  @endif                                  
                @endif 
                <span class="errorcoupn" ></span>

          </div>

          @if(count($arr_final_data) > 0)
            @foreach($arr_final_data as $keys=>$product_arr)

            @php 
               $checkseller_hascoupons = check_seller_couponcode($keys);
               
            @endphp

             @if(in_array($keys,$checkcouponcodeforseller1))

             <div @if(isset($checkseller_hascoupons) && $checkseller_hascoupons==1) 
                @if(isset($sessioncoupon_data[$keys]))
                 class="maincls " 
                @else
                 class="maincls " 
                @endif
              @else class="maincls no-couponcls" @endif>  

              @php
                $product_arr_key = 0;
              @endphp
              
              @foreach($product_arr['product_details'] as $product)

              @php
                $product_arr_key++;
              @endphp


                 @if(isset($product_arr['seller_details']['seller_detail']['delivery_options']) && sizeof($product_arr['seller_details']['seller_detail']['delivery_options']) > 0)
                @if($product_arr_key == 1)  {{--  delivery-option --}}

                  <div class="prime-delivery-option-div">
                    <div class="choose-prime-div">Choose your delivery option:</div>
                      <div class="radio-btns">
                        @foreach($product_arr['seller_details']['seller_detail']['delivery_options'] as $delivery_options_key => $delivery_options )
                            <div class="radio-btn">
                                @php
                                    // $day = date('l jS \, F Y', strtotime('now + '.$delivery_options['day'].'day'));
                                 $day = date('l, M. d', strtotime('now + '.$delivery_options['day'].'day'));
                                @endphp

                                @if(isset($sessiondeliveryoption_data) && sizeof($sessiondeliveryoption_data) > 0)

                                    {{-- **********************  Input Field  ********************** --}}

                                    <input type="radio" id="{{$delivery_options['id']}}"
                                    @foreach($sessiondeliveryoption_data as $key => $deliveryOption_data)
                                        @if($deliveryOption_data['delivery_option_id'] == $delivery_options['id'] )
                                            checked="true"
                                        @endif
                                    @endforeach
                                    seller_id="{{$product_arr['seller_details']['id']}}"  onclick="delivery_options_click(this);" value="{{$delivery_options['id']}}" amount="{{$delivery_options['cost']}}" delivery_option_id="{{$delivery_options['id']}}"   name="selector_{{$delivery_options['id']}}">
                                  
                                    {{-- **********************  Input Field  ********************** --}}

                                    {{-- **********************  Label Field  ********************** --}}
                                    
                                    <label for="{{$delivery_options['id']}}"> {{$day}}
                                        @foreach($sessiondeliveryoption_data as $key => $deliveryOption_data)
                                            @if($deliveryOption_data['delivery_option_id'] == $delivery_options['id'] )
                                             <a href="javascript:void(0)" class="clearbutton-a" key="{{$delivery_options['id']}}" id="clear_{{$delivery_options['id']}}" seller_id="{{$product_arr['seller_details']['id']}}"   onclick="clear_radio_button(this)"  >Clear</a>
                                            @endif
                                        @endforeach
                                    </label>

                                    {{-- **********************  Label Field  ********************** --}}
                                    <div class="check"><div class="inside"></div></div>
                                    <div class="free-text-p-semi">{{$delivery_options['title']}}</div>
                                @else

                                <input type="radio" id="{{$delivery_options['id']}}" seller_id="{{$product_arr['seller_details']['id']}}"  onclick="delivery_options_click(this);" value="{{$delivery_options['id']}}" amount="{{$delivery_options['cost']}}" delivery_option_id="{{$delivery_options['id']}}"   name="selector">
                                <label for="{{$delivery_options['id']}}"> {{$day}} </label> 
                                <div class="check"><div class="inside"></div></div>
                                <div class="free-text-p-semi">{{$delivery_options['title']}}</div>

                                @endif
                            </div>
                        @endforeach
                      </div>
                  </div>
                  @endif
                @endif


                @php 

                 $remaining_stock =0;
                 $str_delivery_duration =  $str_delivery_durationto = "";
                /* if(isset($product['shipping_duration']) && $product['shipping_duration']!="")
                 { 
                   $str_delivery_duration = get_shipping_duration_in_days($product['shipping_duration']); 
                 }*/
                  if(isset($product['shipping_duration']) && $product['shipping_duration']!="")
                 { 
                   // $str_delivery_duration = get_shipping_duration_in_date($product['shipping_duration'],date('m-d-Y'));  // Commented by Harshada
                   $str_delivery_duration = get_shipping_duration_in_date_new($product['shipping_duration'],date('m-d-Y')); 
                   // $str_delivery_durationto = date("D. M d",strtotime($str_delivery_duration.' +2 days')); // Commented by Harshada
                    $str_delivery_durationto = date("F d",strtotime($str_delivery_duration.' +2 days'));
                 }

                  $firstcat_id = $product['first_level_category_id'];
                    $checkfirstcat_flag = 0;
                     if(isset($catdata) && !empty($catdata))
                     {
                        if(in_array($firstcat_id, $catdata))
                        { 
                          $checkfirstcat_flag = 1;
                        }
                        else{
                          $checkfirstcat_flag = 0;
                        }
                     }
                   //  echo "==".$checkfirstcat_flag;



                     // condition added for buyer state restriction
                      if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers) && isset($product['user_id']))
                     {
                        if(in_array($product['user_id'],$restricted_state_sellers))
                        { 
                        }
                        else
                        {
                          $checkfirstcat_flag = 1;
                        }
                     }
                     elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($restricted_state_sellers))
                     {
                       $checkfirstcat_flag = 1;
                     }
                     else
                     {
                       //$checkfirstcat_flag = 0;
                     }





                     $remaining_stock = get_remaining_stock($product['product_id']);


                      $checkseller_hascoupon = check_seller_couponcode($product['user_id']);

                      $j=0;
                      if(isset($checkseller_hascoupon) && $checkseller_hascoupon==1)
                      {
                          if(!in_array($keys,$checkcouponcodeforseller))
                          {
                             array_push($checkcouponcodeforseller,$product['user_id']);
                             $j++;
                          }
                          //$checkcouponproduct[] = $product['product_id'];
                      }
                      if(isset($checkcouponcodeforseller) && !empty($checkcouponcodeforseller))
                      {
                        $checkcouponcodeforseller = array_unique($checkcouponcodeforseller);
                      }
                 @endphp


                 <div class="mybaglistmain">
                 <div class="mybaglists" @if(in_array($product['user_id'],$checkcouponcodeforseller) && $j==1) style="" @endif>

                     <div class="list-serv-itms">


                            <div class="clearfix"></div>





                        <div class="itm-left-list">
                          @php
                            if(isset($product['product_image'][0]['image']) && $product['product_image'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_image'][0]['image']))
                            {
                              $product_img = url('/uploads/product_images/'.$product['product_image'][0]['image']);
                            }
                            else
                            {                   
                              $product_img = url('/assets/images/default-product-image.png');
                            }
                          @endphp
                          @php
                            $product_title = isset($product['product_name']) ? $product['product_name'] : '';
                            $product_title_slug = str_slug($product_title);

                            $checkout_brandname = isset($product['product_brand_detail']['name'])?str_slug($product['product_brand_detail']['name']):'';

                            $checkout_sellername = isset($product['product_seller_detail']['seller_detail']['business_name'])?str_slug($product['product_seller_detail']['seller_detail']['business_name']):'';  


                            $is_besesellersimilar = check_isbestseller($product['product_id']); 

                            // $is_age_limit = isset($product['is_age_limit'])?$product['is_age_limit']:'';
                            // $age_restriction = isset($product['age_restriction'])?$product['age_restriction']:''; 

                            $is_age_limit = isset($product['first_level_category_details']['is_age_limit'])?$product['first_level_category_details']['is_age_limit']:'';
                            $age_restriction = isset($product['first_level_category_details']['age_restriction'])?$product['first_level_category_details']['age_restriction']:''; 


                             $pageclick['name'] = isset($product['product_name']) ? $product['product_name'] : '';
                             $pageclick['id'] = isset($product['product_id']) ? $product['product_id'] : '';
                             $pageclick['brand'] = isset($product['product_brand_detail']['name']) ? $product['product_brand_detail']['name'] : '';
                             $pageclick['category'] = isset($product['first_level_category_id']) ? get_first_levelcategorydata($product['first_level_category_id']) : '';
                             
                            $pageclick['price'] = isset($product['total_price']) ? num_format($product['total_price']) : '';
                              
                             $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($product['product_id']).'/'.$product_title_slug;
                             // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($product['product_id']).'/'.$product_title_slug.'/'.$checkout_brandname.'/'.$checkout_sellername ;





                          @endphp
                            <a href="{{url('/')}}/search/product_detail/{{isset($product['product_id'])?base64_encode($product['product_id']):''}}/{{ $product_title_slug }}"  title="{{isset($product['product_name'])?$product['product_name']:''}}">

                              <img class="lozad"  src="{{url('/assets/images/Pulse-1s-200px.svg')}}"  data-src="{{$product_img}}" alt="{{isset($product['product_name'])?$product['product_name']:''}}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})"/></a>
                          
                        </div>
                        <div class="itm-right-list">
                          @php
                            $prod_name = isset($product['product_name']) ? ucwords($product['product_name']): '';   
                            if(strlen($prod_name)>42)
                            {
                            $prod_name= substr($prod_name,0,35)."..." ;
                            }
                            else
                            {
                                $prod_name;
                            }     
                          @endphp

                          

                            <div class="title-chw-list">

                                 <a href="{{url('/')}}/search/product_detail/{{isset($product['product_id'])?base64_encode($product['product_id']):''}}/{{ $product_title_slug }}"  title="{{isset($product['product_name'])?$product['product_name']:''}}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">
                                 {{-- <a href="{{url('/')}}/search/product_detail/{{isset($product['product_id'])?base64_encode($product['product_id']):''}}/{{ $product_title_slug }}/{{ $checkout_brandname }}/{{ $checkout_sellername }}"  title="{{isset($product['product_name'])?$product['product_name']:''}}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})"> --}}

                                   {{-- {{isset($product['product_brand_detail']['name'])?$product['product_brand_detail']['name']:""}} 
                                   @if(isset($product['spectrum']))


                                      {{-- @if($product['spectrum']=="0")
                                       <span class="line-vertical"></span><span class="space-spetm">Full Spectrum </span>
                                      @elseif($product['spectrum']=="1") 
                                       <span class="lvertical"></span><span class="space-spetm">Broad Spectrum </span>
                                      @elseif($product['spectrum']=="2") 
                                       <span class="line-vertical"></span><span class="space-spetm">Isolate  </span>
                                       @endif           --}}      

                                     {{-- @php 
                                      $get_spectrum_val = get_spectrum_val($product['spectrum']);
                                     @endphp   
                                     <span class="space-spetm">
                                      {{ isset($get_spectrum_val['name'])?$get_spectrum_val['name']:'' }} 
                                     </span>  
                                    CBD <span class="titlename-list">
                                      {{ $prod_name }}
                                    </span>  --}}

                                    <span class="titlename-list">
                                      {{ isset($product['product_id'])?get_product_name($product['product_id']):''  }}
                                    </span>

                                  </a>
                            </div>


                          {{--  <div class="clearfix"></div> --}}
                            <div class="soldby unitpricesold"><span>Unit Price:</span>
                              @php
                              $unit_price ='';
                               if($product['price_drop_to']>0){
                                $unit_price = $product['price_drop_to'];
                               }else
                               {
                                 $unit_price = $product['unit_price'];

                               } 
                              @endphp

                             ${{ num_format($unit_price,2) }} 
                            </div>


                            <!------------------show age restriction----------------------------->  
                            {{--   @if(isset($product['is_age_limit']) && $product['is_age_limit'] == 1 && isset($product['age_restriction']) && $product['age_restriction'] != '') --}}

                               {{--  @if(isset($product['product_age_detail']['age']))
                                <div class="age-img-plus small-size-age">
 
                                  @php  

                                      if(isset($product['product_age_detail']['age']))
                                       $age_restrict = $product['product_age_detail']['age'];
                                     else
                                       $age_restrict = '';
                                   @endphp

                                   @if($age_restrict=="18+")
                                    <div class="age-img-inline" title="18+ Age restriction">
                                      <img src="{{url('/')}}/assets/front/images/product-age-mini.png" alt="18+ Age restriction"> 
                                    </div>
                                    @endif

                                    @if($age_restrict=="21+")
                                      <div class="age-img-inline" title="21+ Age restriction">
                                        <img src="{{url('/')}}/assets/front/images/product-age-max.png" alt="21+ Age restriction"> 
                                      </div>
                                    @endif

                               </div>
                              @endif --}}


                              @if(isset($product['first_level_category_details']['is_age_limit']) && $product['first_level_category_details']['is_age_limit']==1)

                                <div class="age-img-plus small-size-age">
 
                                  @php  
                                    if(isset($product['first_level_category_details']['age_restriction_detail']['age']))
                                     $age_restrict = $product['first_level_category_details']['age_restriction_detail']['age'];
                                   else
                                     $age_restrict = '';
                                   @endphp

                                   @if($age_restrict=="18+")
                                    <div class="age-img-inline" title="18+ Age restriction">
                                      <img src="{{url('/')}}/assets/front/images/product-age-mini.png" alt="18+ Age restriction"> 
                                    </div>
                                    @endif

                                    @if($age_restrict=="21+")
                                      <div class="age-img-inline" title="21+ Age restriction">
                                        <img src="{{url('/')}}/assets/front/images/product-age-max.png" alt="21+ Age restriction"> 
                                      </div>
                                    @endif

                               </div>
                              @endif


                           <!--------end of show age restriction-------------->

                             <!--------------outofstock--Restricted------------->   
                              @if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0 )

                                  @if(isset($remaining_stock) && $remaining_stock > 0)   

                                       @if($checkfirstcat_flag==1)
                                        <div class="out-of-stock static-stock"> 
                                         <span class="red-text">
                                           Restricted
                                         </span>
                                       </div>
                                        @else                                                         
                                       @endif
                                  @else
                                    <div class="out-of-stock static-stock"> 

                                        @if($checkfirstcat_flag==1)
                                         <span class="red-text">
                                           Restricted
                                         </span>
                                        @else
                                          <span class="red-text">Out of stock</span>
                                        @endif

                                     </div>

                                  @endif  

                              @else

                                  @if($checkfirstcat_flag==1)
                                    <div class="">Restricted</div>
                                  @else
                                    <div class="chow-hm-out-stock">Out of stock</div>
                                  @endif
                                    
                              @endif   
                                    
                              <!---------------outofstock--Restricted------------>

                              <!-------------cc and best seller---------------> 
                                   @if( (isset($product['is_chows_choice']) && $product['is_chows_choice']==1) || (isset($is_besesellersimilar) && $is_besesellersimilar!="" && $is_besesellersimilar==1))

                                      <div class="inlineblock-view">
                                        @if(isset($product['is_chows_choice']) && $product['is_chows_choice']==1)
                                          

                                           {{-- <div class="chow_choice-orange best-sller-view trending-choice" > --}}
                                            <span class="b-class-hide">
                                              <img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Chow's Choice
                                            </span>
                                            {{-- </div>  --}}

                                        @endif  

                                        {{-- @if(isset($is_besesellersimilar) && $is_besesellersimilar!="" && $is_besesellersimilar==1)
                                          <div class="home_bestseller chow_choice-orange font-small circle-font-small" >
                                            <span class="b-class-hide">Best Seller</span>
                                          </div>
                                        @endif --}}



                                       

                                       <!-- Lab results available Start -->
                                          <!-- @if(isset($product['product_certificate']) && !empty($product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$product['product_certificate']) )
                                            <div class="labresults-class" style="margin-left: 0px">
                                              <span class="b-class-hide">Lab Results Available</span>
                                            </div>                                   
                                          @endif   -->
                                       <!-- Lab results available End --> 

                                      </div>  
                                    @endif  
                                   <!----------------ebd cc and best seller--------->







                             <div class="bundletotal"><span>Total:</span> ${{isset($product['total_price'])?num_format($product['total_price']):0}} {{-- <span>Item 1 of 2</span> --}}</div>

                              <!-----------truck---------------->
                                @if(isset($product['shipping_type']) && $product['shipping_type']==0)
                                 @php 
                                      $setshippingsimilar = "";
                                      if($product['shipping_type']==0)
                                      { $setshippingsimilar = "Free Shipping";
                                      }
                                      else{
                                        $setshippingsimilar = "Flat Shipping";
                                      }
                                 @endphp
                                 <div class="freeshipping-class" title="{{ $setshippingsimilar }}">
                                      Free Shipping
                                </div>
                                @endif
                              <!----------truck----------------->

                            {{--  <div class="soldby dtls-color">By <span>{{isset($product['product_brand_detail']['name'])?$product['product_brand_detail']['name']:""}} </span>
                            </div> --}}


                            <div class="soldby soldby-txt">Sold by: <span>{{isset($product_arr['seller_details']['first_name'])?$product_arr['seller_details']['seller_detail']['business_name']:""}}</span>
                            </div>

                             <div class="soldby soldby-txt">

                              {{-- Delivery: Estimated between 
                              <span>{{isset($str_delivery_duration)?$str_delivery_duration:''}} and {{ isset($str_delivery_durationto)?$str_delivery_durationto:'' }}
                              </span> --}}

                              Arrives
                              <span>{{isset($str_delivery_duration)?$str_delivery_duration:''}} - {{ isset($str_delivery_durationto)?$str_delivery_durationto:'' }}
                              </span>

                            </div>

                            <!--------------start-product-dimension------------>
                            {{-- @php 
                               $arr_product_dimensions = "";
                               if(isset($product['product_id']) && $product['product_id']!="")
                               { 
                                 $arr_product_dimensions = get_product_dimensions($product['product_id']);
                               }
                             @endphp

                             @if(isset($arr_product_dimensions) && sizeof($arr_product_dimensions)>0)
                              <div class="soldby soldby-txt">Dimensions:
                               @foreach($arr_product_dimensions as $product_dimension)
                                    <div class="soldby soldby-txt">{{isset($product_dimension['option'])?ucfirst($product_dimension['option_type']):''}}: <span>{{isset($product_dimension['option'])?ucfirst($product_dimension['option']):''}}</span>
                                    </div>
                               @endforeach 
                               </div> 
                             @endif --}}
                              <!--------------end-product-dimension------------>

                            <div class="quantity-tx ">
                              <span>Quantity:</span>
                              <span class="fadeclor">{{ $product['item_qty'] }}</span>
                              {{-- <div class="select-style"> --}}
                               {{--  <select name="item_qty" id="item_qty" data-pro-id="{{base64_encode($product['product_id'])}}" class="item_qty frm-select">
                                  @for($i=1; $i <= 12; $i++)
                                    <option value="{{$i}}" {{$product['item_qty'] == $i ? 'selected' : ''}}>{{$i}}</option>
                                  @endfor 
                                </select> --}}
                                <!-------------input box added for product quantity------->

                                    {{-- <input type="text" name="item_qty" id="item_qty_{{ $product['product_id'] }}"   data-pro-id="{{base64_encode($product['product_id'])}}" class="item_qty form-control"  value="{{ $product['item_qty'] }}" product_id={{ $product['product_id'] }} onkeypress="return isNumberKey(event)"/> --}}
                                    


                                <!--------------end of input box--------------------->

                              {{-- </div>  --}}
                             {{-- <a href="{{url('/my_bag/remove_product/'.base64_encode($product['product_id']))}}" onclick="confirm_action(this,event,'Do you really want to delete this product from the bag ?');">Remove</a>  --}}
                             <span class="error-qtys" style="display: block;" id="qtyerr_{{ $product['product_id'] }}"></span>
                           </div>
                            {{-- <div class="options-gift-available"><i class="fa fa-gift"></i> Gift options not available</div> --}}


                             <!-----------show age verification msg-------->
                            @if(isset($is_age_limit) && !empty($is_age_limit) && isset($age_restriction) && !empty($age_restriction) 
                            && $buyer_age_verification_status!=1)
                              {{--   <span class="btn btn-default btn-ageneeded" style="color: #fff;background-color: #873dc8;border-color:#fff">Age-verification needed after checkout</span> --}}
                                {{-- <a href="#" class="age-verificationbtns">Age-verification needed after checkout</a> --}}
                            @endif
                           <!-----------end show age verification msg-->




                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
               </div><!------mybag list main------------>
              @endforeach 
               </div><!----maincls-------->
               @endif
            @endforeach 
          @endif
           
        {{-- </div> --}} <!------mybag list main------------>
      </div>

          @php
            $check_flag = 0;
            $buyeragestatus_flag = 0;
            $remaining_stock=0;
            $buyer_state_restricted_flag =0;
           @endphp
         @if(count($arr_final_data) > 0)
         
            @foreach($arr_final_data as $product_arr)              
              @foreach($product_arr['product_details'] as $product)
                 @php
                           $seller_id   = isset($product['user_id'])?$product['user_id']:'';
                           $firstcat_id = $product['first_level_category_id'];


                           // $is_age_limit = isset($product['is_age_limit'])?$product['is_age_limit']:'';
                           // $age_restriction = isset($product['age_restriction'])?$product['age_restriction']:'';

                            $is_age_limit = isset($product['first_level_category_details']['is_age_limit'])?$product['first_level_category_details']['is_age_limit']:'';
                           $age_restriction = isset($product['first_level_category_details']['age_restriction'])?$product['first_level_category_details']['age_restriction']:'';


                           $remaining_stock = get_remaining_stock($product['product_id']); 
                           if(isset($catdata) && !empty($catdata))
                           {
                              // if(in_array($firstcat_id, $catdata))
                              if((in_array($firstcat_id, $catdata) && isset($remaining_stock) && $remaining_stock>0) || (in_array($firstcat_id, $catdata) && isset($remaining_stock) && $remaining_stock<=0))
                              { 
                                $check_flag++; 
                                // echo "==".$check_flag;
                               // break;
                              }
                              /*else if(isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) && !empty($age_restriction) && 
                                $buyer_age_verification_status!="1")
                              {
                               
                                 $buyeragestatus_flag++; 
                              }
                              else{
                                //$check_flag = 0;
                              }*/
                           }//if catdata

                            if(isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) && !empty($age_restriction) && 
                                $buyer_age_verification_status!="1")
                              {
                               
                                 $buyeragestatus_flag++; 
                              }
                              else{
                                //$check_flag = 0;
                              }


                           // if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids) && isset($seller_id))
                           // {
                           //    if(!in_array($seller_id, $restricted_state_user_ids))
                           //    { 
                           //      $buyer_state_restricted_flag++; 
                           //      //echo "====".$buyer_state_restricted_flag;
                           //    }
                           // }//if restricted_state_user_ids


                             // condition added for buyer state restriction
                            if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers) && isset($seller_id))
                           {
                              if(in_array($seller_id,$restricted_state_sellers))
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
                           }    



                @endphp
              @endforeach
           @endforeach    
         @endif  


   {{--  @if(isset($restrcited_state_text) && $restrcited_state_text!='') 
       
      <div class="note-nxt-tt">{{$restrcited_state_text or ''}}</div>

    @endif --}}


  @if(isset($restrcited_state_text) && $restrcited_state_text!='')                     
    <section class="faqsec details-faqpage">
        <div class="">
          <div class="">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          
              @php
                $i=0;
              @endphp

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse" aria-expanded="false"  aria-controls="collapse" class="collapsed">
                        <span>State Law</span>
                      </a>
                    </h4> 
                  </div>
                  
                  <div id="collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                    <div class="panel-body">
                     <span>@php echo  $restrcited_state_text @endphp</span>
                    </div>
                  </div>
                </div>

               
            <div class="clearfix"></div>
                   
            </div>
          </div> 

          <div class="clearfix"></div>
        </div> 
      </section>

      <div class="clearfix"></div>

    @endif  

        

   @php 
    $hide_placeorder_btn = 0;
   // dd($seller_wise_total_order_amount);
   @endphp

    @if(isset($tax_err_arr) && !empty($tax_err_arr))
      @foreach($tax_err_arr as $k7=>$message)

       @if(isset($message) && !empty($message))  
        @php 

           $hide_placeorder_btn = 1; 
        @endphp
       <div class="errormessage-checkout">
         {{ isset($message)?$message:'' }}
       </div>
       @endif
      @endforeach
    @endif
    

      @php //echo "==". $hide_placeorder_btn 
       //dd($tax_err_arr);
      @endphp


      <div class="odrspng hideinmobilebutton">
          <div class="button-odrspng hidebtns">
             @if(isset($login_user) && $login_user==true)

               @if(isset($hide_placeorder_btn) && $hide_placeorder_btn==1)
                  <button type="button" class="linksbuttons" id="sq-creditcard" onclick="swal('Error','Something went wrong with the seller or buyer address for calculating tax you can not place the order.','error')">Place your order</button>
               @else
                  <button type="button" class="linksbuttons" id="sq-creditcard" onclick="onGetCardNonce(event);">Place your order</button>
               @endif
              
             @else
               <button type="button" class="linksbuttons" id="sq-creditcard" onclick="return gobacktosignup()">Place your order</button>
             @endif  

          </div>
          <div class="right-button-odrspng">




             <div class="odrspng-right-title">Order Total: ${{isset($subtotal)?num_format($subtotal):0}}</div>
            <div class="privacy-notice-by"> By placing your order, you agree to Chow420's <a target="_blank" href="{{url('/')}}/privacy-policy">privacy notice</a> and <a target="_blank" href="{{url('/')}}/terms-conditions">conditions of use</a>. </div>
          </div>
          <div class="clearfix"></div>
      </div>


   </div> 
   <div class="checkout-new-pg-main-right">
       {{-- <a href="#" class="placeyourorder">Place your order</a> --}}

        @if(isset($login_user) && $login_user==true)
          <a type="button" class="placeyourorder" id="sq-creditcard" onclick="onGetCardNonce(event)">Place your order</a>
       @else
          <a type="button" class="placeyourorder" id="sq-creditcard" onclick="return gobacktosignup()">Place your order</a>
       @endif

       <div class="by-order-tx-sml">By placing your order, you agree to Chow420's <a target="_blank" href="{{url('/')}}/privacy-policy">privacy notice</a> and <a target="_blank" href="{{url('/')}}/terms-conditions">conditions</a> of use.</div>
       <div class="order-linechow"></div>
       <div class="ordersummary-txts">Order Summary</div>
       <div class="items-shippings-smry">
           <div class="items-lefttp">Items @if(isset($cart_product_arr) && count($cart_product_arr)>0) ({{count($cart_product_arr)}}) @endif:</div>
           <div class="items-righttp">${{isset($maintotal)?num_format($maintotal):0}}</div>
           <div class="clearfix"></div>
       </div>
       <div class="items-shippings-smry">
           <div class="items-lefttp">Shipping & handling:</div>
           <div class="items-righttp">${{isset($shippingsubtotal)?num_format($shippingsubtotal):0}}</div>
           <div class="clearfix"></div>
       </div>

       @php

          // code for apply coupon code

          if(isset($newarr) && !empty($newarr))
          {
            foreach($newarr as $kk1=>$vv1)
            {

              @endphp
                 <div class="border-tlts"></div>
                 <div class="items-shippings-smry">
                    <div class="items-lefttp">
                          {{isset($vv1['sellername'])?$vv1['sellername']:''}} 
                         ({{isset($vv1['couponcode'])?$vv1['couponcode']:''}})
                    </div>       
                    <div> Discount : {{ isset($vv1['discount'])?$vv1['discount']:''}}%</div>   
                    <div> Total Amount : ${{ isset($vv1['seller_total_amt'])?$vv1['seller_total_amt']:''}}</div>                      
               
                    <div class="items-righttp">{{ isset($vv1['seller_discount_amt'])? '-$'.$vv1['seller_discount_amt']:''}}</div>
                    
                    <div class="clearfix"></div>
                </div> 
              @php

            }//foreach newarr
          }//if newarr 
 
      @endphp



       @php
        // code for delivery options
          if(isset($newarr_options) && !empty($newarr_options))
          {
            foreach($newarr_options as $kk11=>$vv11)
            {

              @endphp
                 <div class="border-tlts"></div>
                 <div class="items-shippings-smry">
                    <div class="items-lefttp">
                          {{isset($vv11['sellername'])?$vv11['sellername']:''}} 
                         ({{isset($vv11['title'])?$vv11['title']:''}})
                    </div>       
                    <div> Cost : {{ isset($vv11['cost'])? '$'.$vv11['cost']:''}}</div>   
                   {{--  <div> Total Amount : ${{ isset($vv1['seller_total_amt'])?$vv1['seller_total_amt']:''}}</div> --}}               
                    <div class="items-righttp">{{ isset($vv11['cost'])? '+$'.$vv11['cost']:''}}
                    </div>                    
                    <div class="clearfix"></div>
                </div> 
              @php

            }//foreach newarr
          }//if newarr 
 
      @endphp


       @if(is_array(Session::get('sessionwallet_data')) && !empty(Session::get('sessionwallet_data')))
        @php
          $reedem_wallet_amt =0;
          $sessionwallet_data =  Session::get('sessionwallet_data');
          if(isset($sessionwallet_data['amount']))
          {
            $reedem_wallet_amt = $sessionwallet_data['amount'];  
          }
          
       @endphp   
           <div class="border-tlts"></div>
           <div class="items-shippings-smry">
              <div class="items-lefttp">Reedem Wallet Amount : </div>
              <div class="items-righttp">{{ isset($reedem_wallet_amt)? '-$'.$reedem_wallet_amt:''}}
              </div>                    
              <div class="clearfix"></div>
          </div> 
        @endif  
     

       @if(isset($seller_wise_total_order_amount) && !empty($seller_wise_total_order_amount))
           @php $tax = 0; @endphp
            @foreach($seller_wise_total_order_amount as $k7=>$v7)
             @if(isset($v7['sellername']) && $v7['sellername']!='' && isset($v7['tax']))  
               @php 
               
               if(isset($v7['tax']) && $v7['tax']>=0)
               {
                $tax = $v7['tax'];
               }else
               {
                 $tax = 0;
               }
               @endphp
               <div class="border-tlts"></div>

               <div class="items-shippings-smry">
                 <div class="items-lefttp">{{ isset($v7['sellername'])?$v7['sellername'].'(tax)':'' }} </div>
                 <div class="items-righttp">{{ $tax }}</div> 
               </div>
             @endif
            @endforeach
         @endif


       <div class="border-tlts"></div>
       <div class="items-shippings-smry">
           <div class="items-lefttp">Total:</div>
           
           <div class="items-righttp">${{isset($subtotal)?num_format($subtotal):0}}</div>
           <div class="clearfix"></div>
       </div>

     </form>
       
       <div class="items-shippings-smry totls-amouttotal">
           <div class="items-lefttp">Order Total:</div>
           <div class="items-righttp">${{isset($subtotal)?num_format($subtotal):0}}</div>
           <div class="clearfix"></div>
       </div>
      
       
   </div> 
   <div class="checkout-new-pg-main-right-back">
       <a type="button" class="back-to-cart" onclick="showProcessingOverlay();" href="{{url('/')}}/my_bag">Back to cart</a>
        
   </div>
   
   <div class="clearfix"></div> 
</div>
</div>


<form id="frm-verifyaddresses" onsubmit= "return false">
<!--------------------start of modal-------------------------------------->
<div class="modal fade" id="shippingaddresschange-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


  <div class="modal-dialog" role="document">

    <input type="hidden" name="shippingaddresschange-buyer_id" id="shippingaddresschange-buyer_id" value="">
   
    <div class="modal-content">

      <div class="modal-header">
        <h3 class="modal-title relative-div" id="exampleModalLabel" align="center">Change Shipping & Billing Address
        <div class="divchekcoutupdated">
           <input type="submit" class="shdebtns" id="change_ship_address_submit" value="Update">
         </div>
        </h3>
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="shippingaddresschange-body">
        <div class="mainbody-mdls">  
          <div class="mainbody-mdls-fd">

              @if(isset($buyer_age_verification_status) && $buyer_age_verification_status=='1')
             <div class="row">
                <div class=" col-md-6">
                 <div class="form-group zip-errorm">
                   <label for="">Password <span>*</span></label>
                 <input type="password" id="user_current_password" name="current_password" class="input-text" placeholder="Password" data-parsley-required="true" data-parsley-required-message="Enter current password">
                  </div>
                </div>
             </div><!-----end row---------->
             @endif


            <div class="row">

              <div class="col-md-12">
                <h4 class="space-shipping-adrs">Basic Details</h4>
                <hr class="modal-hr">
              </div>
              <div class="col-md-6">
                <div class="form-group">
                <label>First Name <span>*</span></label>             
                <input type="text" id="shipping_firstname_change-input" name="shipping_firstname_change-input" value="{{$user_details_arr['first_name'] or ''}}" data-parsley-required="true"  class="input-text" placeholder="First Name"  data-parsley-required-message="Please enter your firstname">
                {{-- <span id="address_msg_err"></span> --}}
                </div>
              </div> 
              <div class="col-md-6">
                <div class="form-group">
                <label>Last Name <span>*</span></label>             
                <input type="text" id="shipping_lastname_change-input" name="shipping_lastname_change-input" value="{{$user_details_arr['last_name'] or ''}}" data-parsley-required="true"  class="input-text" placeholder="Last Name"  data-parsley-required-message="Please enter your lastname">
                {{-- <span id="address_msg_err"></span> --}}
                </div>
              </div>

               <div class="col-md-6">
                <div class="form-group checkoutphone-err">
                <label>Phone <span>*</span></label>             
                <input type="text" id="shipping_phone_change-input" name="shipping_phone_change-input" value="{{$user_details_arr['phone'] or ''}}" data-parsley-required="true"  class="input-text" placeholder="Phone"  data-parsley-required-message="Please enter your phone" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-pattern="^[0-9]*$" data-parsley-pattern-message="Please enter valid phone number">
                {{-- <span id="address_msg_err"></span> --}}
                </div>
              </div>

               <div class="col-md-6">
                <div class="form-group">
                <label>Date Of Birth <span>*</span></label>             
                <input type="text" id="shipping_dob_change-input" name="shipping_dob_change-input" value="{{$user_details_arr['date_of_birth'] or ''}}" data-parsley-required="true"  class="input-text" placeholder="Date of birth MM/DD/YYYY""  data-parsley-required-message="Please select date of birth" onchange="age_calculation(this)" onkeypress="return validateNumberAndForwardSlash(event);"   >
                 <div class="ageerr" id="age_error"></div>

                {{-- <span id="address_msg_err"></span> --}}
                </div>
              </div>

              <div class="col-md-12">
                <h4 class="space-shipping-adrs">Shipping Address</h4>
                <hr class="modal-hr">
              </div>

            <div class="col-md-12">
                <div class="form-group">
                   <div id="locationField">
                    <input class="input-text search-address" id="autocomplete" placeholder="Search your address here" onFocus="geolocate()" type="text" />
                  </div>
              </div>
            </div> 



              <div class="col-md-12">
                <div class="form-group">
                <label>Address :</label>   


               {{--  <textarea id="shippingaddresschange-input" rows="3" class="form-control" placeholder="Please enter your new shipping address" data-parsley-required="true" data-parsley-required-message="Please enter address" data-parsley-errors-container="#address_msg_err">{{$user_details_arr['street_address'] or ''}}</textarea>   --}}
                  <input class="field" id="street_number" disabled="true" type="hidden" /> 

                <input type="text" id="route" data-parsley-required="true" data-parsley-required-message="Please enter address" data-parsley-errors-container="#address_msg_err" value="{{$user_details_arr['street_address'] or ''}}"   class="input-text" placeholder="Please enter your new shipping address" >


                <span id="address_msg_err"></span>
                </div>
              </div>

              <div class=" col-md-4">
                <div class="form-group city-errorm">
                    <label for="">City <span>*</span></label>
                    <input type="text" id="locality" name="shippingcitychange-input" value="{{$user_details_arr['city'] or ''}}" data-parsley-required="true"  class="input-text" placeholder="City"  data-parsley-required-message="Please enter city">
                  </div>
              </div>

              <div class="col-md-4">  
              <div class="form-group">                
                <label for="">Country <span>*</span></label>
                  @php
                      $country_id = isset($user_details_arr['country'])?$user_details_arr['country']:0;
                @endphp
                <div class="select-style">
                <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select country" data-parsley-errors-container="#country_msg_err" id="country" name="shippingcountrychange-input" onchange="get_states()">

                  @if(isset($countries_arr) && count($countries_arr)>0)
                  <option value="">Select Country</option>
                  @foreach($countries_arr as $country)


                    <option  @if($country['id']==$country_id) selected="selected" @endif value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
                  
                  @endforeach
                  @else
                  <option>Countries Not Available</option>
                  @endif
                  </select> 
                  <span id="country_msg_err"></span>
                </div>
              </div>
              </div>
              
               <div class="col-md-4">
                 <div class="form-group">
                  <label for="">State <span>*</span></label>
                  @php
                       $state_id = isset($user_details_arr['state'])?$user_details_arr['state']:0;
                        //dump($states_arr);
                  @endphp
                  <div class="select-style">
                  <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state " id="administrative_area_level_1" name="shippingstatechange-input">
                    @if(isset($states_arr) && count($states_arr)>0)
                    <option value="">Select State</option>
                    @foreach($states_arr as $state)


                     <option  @if($state['id']==$state_id) selected="selected" @endif value="{{$state['id']}}">{{isset($state['name'])?ucfirst(strtolower($state['name'])):'--' }}</option>
                   
                    @endforeach
                    @else
                    <option>State Not Available</option>
                    @endif
                    
                   </select> 
                  </div>
                  </div>
              </div> 

              <div class=" col-md-4">
                <div class="form-group zip-errorm">
                    <label for="">Zip Code <span>*</span></label>
                    <input type="text" id="postal_code" name="shippingzipcodechange-input" value="{{$user_details_arr['zipcode'] or ''}}" data-parsley-required="true" data-parsley-minlength="4" data-parsley-maxlength="12" data-parsley-type="number" class="input-text" placeholder="Zip Code"  data-parsley-required-message="Please enter zip code">
                  </div>
              </div>

              <div class="col-md-12">
              <div class="checkbox clearfix">
                    <div class="form-check checkbox-theme">
                        <input class="form-check-input" type="checkbox" value="" id="sameasabove"   name="sameasabove">
                        <label class="form-check-label" for="sameasabove">
                           Same as shipping address
                        </label>
                    </div>
                </div>
            </div>
             
              <div class="col-md-12">
                <h4 class="space-shipping-adrs">Billing Address</h4>
                <hr class="modal-hr">
              </div>
              <div class="col-md-12 ">
                <div class="form-group">
                <label>Address :</label>      

                <input type="text" id="billingaddresschange-input"  value="{{$user_details_arr['billing_street_address'] or ''}}" data-parsley-required="true"  class="input-text" placeholder="Address"  data-parsley-required-message="Please enter billing address" data-parsley-errors-container="#billing_address_msg_err" >


                <span id="billing_address_msg_err"></span>
              </div>
              </div>

               <div class=" col-md-4">
                <div class="form-group city-errorm">
                    <label for="">City <span>*</span></label>
                    <input type="text" id="billingcitychange-input" name="billingcitychange-input" value="{{$user_details_arr['billing_city'] or ''}}" data-parsley-required="true"  class="input-text" placeholder="City"  data-parsley-required-message="Please enter city">
                  </div>
              </div>


              <div class="col-md-4"> 
                 <div class="form-group">              
                <label for="">Country <span>*</span></label>
                  @php
                      $billing_country_id = isset($user_details_arr['billing_country'])?$user_details_arr['billing_country']:0;
                @endphp
                <div class="select-style">
                <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select country" id="billingcountrychange-input" name="billingcountrychange-input" onchange="get_billing_states()">

                  @if(isset($countries_arr) && count($countries_arr)>0)
                  <option value="">Select Country</option>
                  @foreach($countries_arr as $country)


                    <option  @if($country['id']==$billing_country_id) selected="selected" @endif value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
                  
                  @endforeach
                  @else
                  <option>Countries Not Available</option>
                  @endif
                  </select> 
                </div>
                <span id="country_msg_err"></span>
              </div>
              </div>
              
               <div class="col-md-4">
                 <div class="form-group">
                  <label for="">State <span>*</span></label>
                  @php
                       $billing_state_id = isset($user_details_arr['billing_state'])?$user_details_arr['billing_state']:0;
                        //dump($states_arr);
                  @endphp
                  <div class="select-style">
                  <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state " id="billingstatechange-input" name="billingstatechange-input">
                    @if(isset($billing_states_arr) && count($billing_states_arr)>0)
                    <option value="">Select State</option>
                    @foreach($billing_states_arr as $billing_state)


                     <option  @if($billing_state['id']==$billing_state_id) selected="selected" @endif value="{{$billing_state['id']}}">{{isset($billing_state['name'])?ucfirst(strtolower($billing_state['name'])):'--' }}</option>
                   
                    @endforeach
                    @else
                    <option>State Not Available</option>
                    @endif
                    
                   </select> 
                  </div>
                  </div>
              </div> 

              <div class=" col-md-4">
                <div class="form-group zip-errorm">
                    <label for="">Zip Code <span>*</span></label>
                    <input type="text" id="billingzipcodechange-input" name="billingzipcodechange-input" value="{{$user_details_arr['billing_zipcode'] or ''}}" data-parsley-required="true" data-parsley-minlength="4" data-parsley-maxlength="12" data-parsley-type="number" class="input-text" placeholder="Zip Code"  data-parsley-required-message="Please enter zip code">
                  </div>
              </div>

          
            </div><!-----end row---------->
             <div class="clearfix"></div>

            

          </div>

        </div>
      
      </div>
      <div class="modal-footer">
        <div class="sre-product">       
        <img src="{{ url('/') }}/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" alt="Loader"/>
        <input type="submit" class="shdebtns" id="change_ship_address_submit" value="Update">

        </div>
      </div>
    </div>
  </div>
</div>
</form>
<!-----------------end of modal---------------------->

<!--------------start singin modal----------------------------------------->


<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


  <form id="login-form" onsubmit="return false;">
      {{ csrf_field() }}

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel" align="center">Login</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <span id="status_msg"></span>
      </div>
      <div class="modal-body" id="shippingaddresschange-body">
        <div class="mainbody-mdls">  
          <div class="mainbody-mdls-fd">
            <div class="row">
             

              <div class="col-md-12">
                <div class="form-group">
                <label>Email <span>*</span></label>             
                <input type="email" id="email-input" class="form-control" name="email" placeholder="Enter email address" data-parsley-required="true" data-parsley-required-message="Email is required">
                {{-- <span id="address_msg_err"></span> --}}
                </div>
              </div> 

              <div class="col-md-12">
                <div class="form-group">
                <label>Password <span>*</span></label>             
                <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" data-parsley-required="true" data-parsley-required-message="Password is required">
                {{-- <span id="address_msg_err"></span> --}}
                </div>
              </div>
           
          
            </div>
             <div class="clearfix"></div>
          </div>

        </div>
      
      </div>
      <div class="modal-footer">
        <div class="sre-product">       
        <img src="{{ url('/') }}/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" alt="Loader"/>
        <input type="submit" class="shdebtns" id="button_login" value="Login">

        </div>
      </div>
    </div>
  </div>
 </form>
</div>


<!-------------end signin modal------------------------------------------>

@php

 $login_user = Sentinel::getUser();
 $login_id = $login_user['id'];
 $login_email = $login_user['email']; 

@endphp

@endsection


@section('page_script')

<script type="text/javascript"
 @if($payment_mode=='0' && isset($sandbox_js_url)) src="{{ $sandbox_js_url }}" 
 @elseif($payment_mode=='1' && isset($live_js_url)) src="{{ $live_js_url }}" @endif>
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript">
  var URL = "{{ url('/') }}";

  var payment_gateway_switch = "{{ $payment_gateway_switch }}"

 

      var applicationId = $('#appId').val();

      const paymentForm = new SqPaymentForm({
      postalCode: false,
      applicationId: applicationId,
      inputClass: 'sq-input',
      autoBuild: false,
      inputStyles: [{
          lineHeight: '24px',
          padding: '0px',
          placeholderColor: '#a0a0a0',
          backgroundColor: 'transparent',
      }],
     
      cvv: {
          elementId: 'sq-cvv',
          placeholder: 'CVV'
      },
      expirationDate: {
          elementId: 'sq-expiration-date',
          placeholder: 'MM/YY'
      },
      cardNumber: {
          elementId: 'sq-card-number',
          placeholder: 'Please enter card number'
      },
      callbacks: {
      
           cardNonceResponseReceived: function (errors, nonce, cardData) 
           {
             
            if (errors) {
                errors.forEach(function (error) {
                    swal('Oops..!',error.message,'error');
                });
                return;
            }
           
            document.getElementById('card-nonce').value = nonce;

            if($('#nonce-form').parsley().validate()==false) return;

             var amount = $("#amount").val();
           
         
         
             $.ajax({              
                url: SITE_URL+'/checkout/place_order',
                data: new FormData($('#nonce-form')[0]),
                processData: false,
                method:'POST',
                contentType: false,
                dataType:'json',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success:function(data)
                {   
                                  
                    console.log(data);
                    
                    hideProcessingOverlay();
                    if( data.status == 'success')
                    {            
                        $('#nonce-form')[0].reset();
                      
                        location.href = SITE_URL+'/checkout/order/'+'thankyouforshopping/'+data.order_no;
                     
                    }
                    else
                    {
                       if(data.notplacedmsg=='1'){
                        swal('Payment unsuccessful!',data.msg,"warning");
                       }else{
                        swal('Warning!',data.msg,"warning");
                       }
                       
                    }  
                }      
             });
         }/* cardNonceResponseReceived */
      }/* callbacks */ 
  }); /* paymentForm */
  paymentForm.build(); 


     var check_flag = "{{ $check_flag }}"; 
     var buyeragestatus_flag = "{{ $buyeragestatus_flag or '' }}"; 
     var buyer_state_restricted_flag = "{{ $buyer_state_restricted_flag or '' }}"

     $(document).ready(function(){
        if(check_flag>0){
         restrictcheckout();      
        }
        else if(buyer_state_restricted_flag>0)
        {
         restrict_buyerstate_checkout();
        }
     });


    function onGetCardNonce(event) 
    {
    
     
        if(check_flag>0)
        {
           restrictcheckout();
        }
        else if(buyer_state_restricted_flag>0)
        {
           restrict_buyerstate_checkout();
        }
        else
        {

                  var has_age_verified_product_in_cart = "{{ $has_age_verified_product_in_cart }}";

                  console.log(has_age_verified_product_in_cart); 
                  var buyer_age_verification_status = "{{ $buyer_age_verification_status }}";
                  var user_street_address = "{{ $user_street_address or '' }}"; 
                  var user_state= "{{$user_state or ''}}"; 
                  var user_country= "{{$user_country or ''}}"; 
                  var user_zipcode= "{{$user_zipcode or ''}}"; 
                   var user_city= "{{$user_city or ''}}"; 
                  var user_billing_street_address= "{{$user_billing_street_address or ''}}"; 
                  var user_billing_state= "{{$user_billing_state or ''}}"; 
                  var user_billing_country= "{{$user_billing_country or ''}}"; 
                  var user_billing_zipcode= "{{$user_billing_zipcode or ''}}"; 
                  var user_billing_city= "{{$user_billing_city or ''}}"; 
                 
                  var user_approve_status = "{{ $user_approve_status or '' }}";

                  var firstname = "{{ $user_fname or '' }}";
                  var lastname = "{{ $user_lname or '' }}";
                   var phone = "{{ $phone or '' }}";
                   var dateofbirth = "{{ $date_of_birth or '' }}";

              
                 if( 
                    ( (buyer_age_verification_status=='0' || buyer_age_verification_status=='2' || buyer_age_verification_status=='3') 
                  && ((user_street_address.trim()=="") || (user_state.trim()=="") || (user_country.trim()=="") || (user_zipcode.trim()=="") 
                  || (user_city.trim()=="") || (user_billing_street_address.trim()=="") || (user_billing_state.trim()=="") || (user_billing_country.trim()=="") || (user_billing_zipcode.trim()=="") || (user_billing_city.trim()=="") || (firstname.trim()=="") || (lastname.trim()=="") || (phone.trim()=="") || (dateofbirth.trim()=="") )) 
                    || 
                    ((buyer_age_verification_status=='1') && ((user_street_address.trim()=="") || (user_state.trim()=="") || (user_country.trim()=="") || (user_zipcode.trim()=="") 
                     || (user_city.trim()=="") || (user_billing_street_address.trim()=="") || (user_billing_state.trim()=="") || (user_billing_country.trim()=="") || (user_billing_zipcode.trim()=="") || (user_billing_city.trim()=="") || (firstname.trim()=="") || (lastname.trim()=="") || (phone.trim()=="") || (dateofbirth.trim()=="")))

                   ) //if



                 {

                      swal({

                          
                            title: 'Please complete your shipping and billing details.',
                            type: "warning",
                            showCancelButton: false,
                            // confirmButtonColor: "#DD6B55",
                            confirmButtonColor: "#8d62d5",
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                          },
                          function(isConfirm,tmp)
                          {
                            if(isConfirm==true)
                            {

                               $('#shippingaddress-btn').trigger('click');
                            }
                          })

                 }
                 else
                 {

                    /* give here swal alert for age restricted product notifce */
                    /* commented age restricted popup */

                     if(buyeragestatus_flag>0){
                      swal({                       
                         title:'By proceeding with this order, you represent that you are twenty-one (21) years or older and agree to be age-verified after purchase.',
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#873dc8",
                          confirmButtonText: "Ok",
                          closeOnConfirm: false,
                          showCancelButton: true
                      },
                      function(isConfirm,tmp)
                      {
                          if(isConfirm==true)
                          {
                            if(payment_gateway_switch=="square")
                             {
                                event.preventDefault();
                                paymentForm.requestCardNonce();
                             }
                             else
                             {
                                 paymentFormUpdate();
                             }
                          }
                      })     

                    }
                    else
                    {
                            if(payment_gateway_switch=="square")
                             {
                                event.preventDefault();
                                paymentForm.requestCardNonce();
                             }
                             else
                             {
                                 paymentFormUpdate();
                             }
                    }/* else */

                 }/* else of profile conditions */

             }
      // }/* else of card no,exp mont,year */
      
    }/* end of function ongetcardnonce */





function paymentFormUpdate() 
{


  var cardNumber = $("#cardNumber").val();
  var expMonth = $("#expMonth").val();
  var expYear = $("#expYear").val();
  var cardCode = $("#cardCode").val();

  if(cardNumber.trim()=="" || expMonth.trim()=="" || expYear.trim()=="" || cardCode.trim()=="")
  {

         swal('Warning!','Please enter payment details',"warning");

  }
  else
  {
     if($('#nonce-form').parsley().validate()==false) return;
          
          var amount = $("#amount").val();
                
   
            $.ajax({              
                url: SITE_URL+'/checkout/place_order',
                data: new FormData($('#nonce-form')[0]),
                processData: false,
                method:'POST',
                contentType: false,
                dataType:'json',
                beforeSend: function() {
                    showProcessingOverlay();
                     
                },
                success:function(data)
                {   
                                  
                    console.log(data);
                    
                    hideProcessingOverlay();
                    if( data.status == 'success')
                    {            
                        $('#nonce-form')[0].reset();
                       
                       
                        location.href = SITE_URL+'/checkout/order/'+'thankyouforshopping/'+data.order_no;

                      
                    }
                    else
                    {
                       if(data.notplacedmsg=='1'){
                        swal('Payment unsuccessful!',data.msg,"warning");
                       }else{
                        swal('Warning!',data.msg,"warning");
                       }
                       
                    }  
                }      
            });
  }/* else */
    
    
}/* end function paymentFormUpdate authorizenet */


/* function for quantity */
  $('select.item_qty').on('change', function(evt) 
  {       
    var qty = this.value;
    var pro_id = $(this).attr("data-pro-id");
    var url = '{{url('/')}}/my_bag/update_qty';
    
    $.ajax({
        url: url,
        data: {
            pro_id: pro_id,
            qty: qty,
        },
        method: 'GET',
        beforeSend: function() {
            showProcessingOverlay();
        },
        success: function(response) {
            hideProcessingOverlay();
            if (response.status == "SUCCESS") {

                location.reload();
                
            }
            else if(response.status=="FAILURE"){ 

                swal({
                  title: response.description,
                  type: "warning",
                  showCancelButton: false,
                  // confirmButtonColor: "#DD6B55",
                  confirmButtonColor: "#8d62d5",
                  confirmButtonText: "ok",
                  closeOnConfirm: false
                },
                function(isConfirm,tmp)
                {
                  if(isConfirm==true)
                  {
                     location.reload();
                  }
                })
                     
            }
        }
    })
  });




$(document).on('click','#checkout_btn',function(){    
    var hidden_product_ids = $("#hidden_product_ids").val();
    var productids = hidden_product_ids.split(",");
    var flag=0;
    for(var i=0;i<productids.length;i++){       
        var product_id = productids[i];
        var item_qty = '#item_qty_'+product_id;
        if($('#item_qty_'+product_id).val().trim()==""){
           var flag=1; 
           break;
          
        }
        else if($('#item_qty_'+product_id).val().trim()=="0"){
           var flag=1;            
           break;
          
        }
        else{
           var flag=0; 
        }
    }
   if(flag=='1'){
       swal('warning','Please enter valid quantity','warning');  
       return false;
    }else{
     return true;
    }  
  return false;
});  
    

  function isNumberKey(evt)
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
       return false;

    return true;
  } 

$('input[name="item_qty"]').keyup(function(e)
 {
  if (/\D/g.test(this.value))
  {
    this.value = this.value.replace(/\D/g, '');
  }
});

  $(".item_qty").focusout(function(){
     var qty = this.value;
     var pro_id = $(this).attr("data-pro-id");
     var url = '{{url('/')}}/my_bag/update_qty';
     var product_id = $(this).attr('product_id');

     if(qty==""){
      $("#qtyerr_"+product_id).html('Please enter quantity');
      $("#qtyerr_"+product_id).css('color','red');   

      $(".placeyourorder").hide();
      $(".linksbuttons").hide();


      return false;
     }else if(qty<=0){
         $("#qtyerr_"+product_id).html('Quantity should be greater than 0');
         $("#qtyerr_"+product_id).css('color','red');   
         $(".placeyourorder").hide();
         $(".linksbuttons").hide();
         return false;
     }
     else{
       $("#qtyerr_"+product_id).html(''); 
       $(".placeyourorder").show();
       $(".linksbuttons").show();
     }
        
    $.ajax({
        url: url,
        data: {
            pro_id: pro_id,
            qty: qty,
        },
        method: 'GET',
        beforeSend: function() {
            showProcessingOverlay();
        },
        success: function(response) {
            hideProcessingOverlay();
            if (response.status == "SUCCESS") {

                location.reload();
                
            }else if(response.status=="FAILURE"){ // added new
                 swal('warning',response.description,'warning');  
                 
            }
        }
    });
});  


$(".item_qty").blur(function () {
     var qty = this.value;
     var pro_id = $(this).attr("data-pro-id");
     var url = '{{url('/')}}/my_bag/update_qty';
     var product_id = $(this).attr('product_id');

     if(qty==""){
      $("#qtyerr_"+product_id).html('Please enter quantity');
      $("#qtyerr_"+product_id).css('color','red');   
      $(".placeyourorder").hide();  
      $(".linksbuttons").hide();
      return false;
     }else if(qty<=0){
         $("#qtyerr_"+product_id).html('Quantity should be greater than 0');
         $("#qtyerr_"+product_id).css('color','red'); 
         $(".placeyourorder").hide();  
         $(".linksbuttons").hide();
         return false;
     }
     else{
       $("#qtyerr_"+product_id).html(''); 
       $(".placeyourorder").show();  
       $(".linksbuttons").show();
     }
        
    $.ajax({
        url: url,
        data: {
            pro_id: pro_id,
            qty: qty,
        },
        method: 'GET',
        beforeSend: function() {
            showProcessingOverlay();
        },
        success: function(response) {
            hideProcessingOverlay();
            if (response.status == "SUCCESS") {

                location.reload();
                
            }else if(response.status=="FAILURE"){ // added new
                 swal('warning',response.description,'warning');  
                 setTimeout(function(){ location.reload(); }, 1000);
                 
            }
        }
    });
});

  /* Change Shipping Address Model START */
  $(document).on('click','#shippingaddress-btn',function(){
    var login_id = "{{ $login_id }}";
    
  
    $("#shippingaddresschange-modal").modal('show');
    
    $("#shippingaddresschange-buyer_id").val(login_id);
     
  });



  /* Change Shipping Address Request START */

  $(document).on('click','#change_ship_address_submit',function(){

    if($('#frm-verifyaddresses').parsley().validate()==false) return;

    var buyer_age_verification_status = "{{ $buyer_age_verification_status }}";

    var new_first_name = $("#shipping_firstname_change-input").val();
    var new_last_name = $("#shipping_lastname_change-input").val();
    var new_shipping_address = $("#route").val();
    var new_shipping_state = $("#administrative_area_level_1").val();
    var new_shipping_country = $("#country").val();
    var new_shipping_zipcode = $("#postal_code").val();
    var new_shipping_city = $("#locality").val();


    var new_billing_address = $("#billingaddresschange-input").val();
    var new_billing_state = $("#billingstatechange-input").val();
    var new_billing_country = $("#billingcountrychange-input").val();
    var new_billing_zipcode = $("#billingzipcodechange-input").val();
    var new_billing_city = $("#billingcitychange-input").val();

    var shipping_dob_change_input = $("#shipping_dob_change-input").val(); 
    var shipping_phone_change_input = $("#shipping_phone_change-input").val(); 
    var shippingaddresschange_buyer_id = $("#shippingaddresschange-buyer_id").val();
    var current_password =  $("#user_current_password").val();
      
  
         

              var date_of_birth = document.getElementById("shipping_dob_change-input").value;

              var split_dob = date_of_birth.split("/");

              var month = split_dob[0];
              var date  = split_dob[1];
              var year  = split_dob[2];

              var date1 = new Date();
              var date2 = new Date(""+month+"/"+date+"/ "+year+""); 

              var Difference_In_Time = date1.getTime() - date2.getTime(); 
                
              var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 

              if (Difference_In_Days < 7671) 
              { // days in 21 years
                
                $("#shipping_dob_change-input").removeAttr('data-parsley-required');

                document.getElementById("age_error").innerHTML = " You must be 21+ and above to use chow420.";
                 document.getElementById("age_error").style="color:red;font-size:13px";

                event.preventDefault();
                return false;
              }
              else {

                document.getElementById("age_error").innerHTML = "";
              }

              var isValid = isValidDate(shipping_dob_change_input);
              if (isValid) {
              } else {
                document.getElementById("age_error").innerHTML = "Date of Birth entered Incorrectly";
                document.getElementById("age_error").style="color:red;font-size:13px";
                  event.preventDefault();
                      return false;

             }

            if(new_shipping_address && shippingaddresschange_buyer_id)
            {

                $.ajax({
                url: SITE_URL+'/checkout/change_shipping_address',
                type:"GET",
                data: {
                  new_first_name:new_first_name,
                  new_last_name:new_last_name,
                  new_shipping_address:new_shipping_address,
                  new_shipping_state:new_shipping_state,
                  new_shipping_country:new_shipping_country,
                  new_shipping_zipcode:new_shipping_zipcode,
                  new_shipping_city:new_shipping_city,
                  new_billing_address:new_billing_address,
                  new_billing_state:new_billing_state,
                  new_billing_country:new_billing_country,
                  new_billing_zipcode:new_billing_zipcode,
                  new_billing_city:new_billing_city,
                  shippingaddresschange_buyer_id:shippingaddresschange_buyer_id,
                  shipping_dob_change_input:shipping_dob_change_input,
                  phone:shipping_phone_change_input,
                  current_password : current_password
                },             
                dataType:'json',
                beforeSend: function(){    
                 showProcessingOverlay();     
                  $("#loaderimg").show();
                  $("#change_ship_address_submit").hide();
                },  
                success:function(response)
                {
                  $("#loaderimg").hide();
                  $("#change_ship_address_submit").show();
                   hideProcessingOverlay(); 
                  if(response.status == 'success')
                  { 
                    swal({
                            title: 'Success',
                            text: response.description,
                            type: 'success',
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                          },
                        function(isConfirm,tmp)
                        {                       
                          if(isConfirm==true)
                          {
                              window.location.reload();
                          }

                        });
                  }
                  else
                  {                
                    swal('Error',response.description,'error');
                  }  
                }//success  
              }); 

            }else{
              return false;
            }  
    
  });
  /* Change Shipping Address Request END */


    function get_states()
    {
      var country_id  = $('#country').val();
        
      $.ajax({
              url:SITE_URL+'/buyer/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(response)
              { 
                  
                  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                  $("#administrative_area_level_1").html(html);
              }
      });
  }

  function get_billing_states()
    {
      var country_id  = $('#billingcountrychange-input').val();
        
      $.ajax({
              url:SITE_URL+'/buyer/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(response)
              { 
                  
                  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                  $("#billingstatechange-input").html(html);
              }
      });
  }




   showProcessingOverlay();
   $(window).load(function() {       
     hideProcessingOverlay();
   });




  
  function restrictcheckout()
{

    swal({
       title: 'You are not allowed to purchase a product or products in your cart based on your state laws. Please click continue to be in compliance',
        type: "warning",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonColor: "#873dc8",
        confirmButtonText: "Automate Compliance",
        closeOnConfirm: false,
        showCancelButton: false
    },
    function(isConfirm,tmp)
    {
        if(isConfirm==true)
        {
             $.ajax({
                url:'{{url('/')}}'+'/check_cart/removerestricted_products',            
                data:{
                  checkstat:1,              
                },
                dataType:'json',
                success:function(response)
                { 
                   
                   if(response==true)
                   {
                      window.location.reload();
                   }else{
                     window.location.reload();
                   } 
                }  
              });
        }//if confirm
    });
}/*end restrictcheckout */



/* function for if buyer state if restricted then he can not allow to purchase product */

function restrict_buyerstate_checkout()
{
    swal({

         title: 'You are not allowed to buy a product or products in your cart based on your state. Please click continue to be in compliance',
        
        type: "warning",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonColor: "#873dc8",
        confirmButtonText: "Automate Compliance",
        closeOnConfirm: false,
        showCancelButton: false
    },
    function(isConfirm,tmp)
    {
        if(isConfirm==true)
        {
             $.ajax({
                url:'{{url('/')}}'+'/check_cart/remove_state_restricted_products',            
                data:{
                  checkstat:1,              
                },
                dataType:'json',
                success:function(response)
                { 
                   //  alert(response);
                   if(response==true)
                   {
                      window.location.reload();
                   }else{
                     window.location.reload();
                   } 
                }  
              });
        }/* if confirm */
    });
}/* end restrict_state_checkout */



   
function restrictcheckoutforage()
{
    swal({

        title: 'Your age verification profile is still incomplete, If you want to purchase this product please fill your age verification detail',
    
        type: "warning",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonColor: "#873dc8",
        confirmButtonText: "Continue",
        closeOnConfirm: false,
        showCancelButton: true
    },
    function(isConfirm,tmp)
    {
        if(isConfirm==true)
        {
            window.location.href=SITE_URL+'/buyer/age-verification';
        }/* if confirm */
    });
}/* end restrictcheckout for age  */  




/* function for apply coupon */
  $(".applycoupon-common").click(function(){ 
    

    var code = $('#coupon_code').val();

    var URL = "{{ url('/') }}";

    if(code==""){

      $(".errorcoupn").html('Please enter coupon code');
      $(".errorcoupn").css('color','red');   
      return false;
    }
    else
    {
        $(".errorcoupn").html(''); 

          $.ajax({
                url: URL+'/my_bag/applycouponcodecommon',
                data: {
                    code: code
                },
                method: 'GET',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success: function(response) {
                    hideProcessingOverlay();
                    if (response.status == "SUCCESS") {

                        window.location.reload();
                        
                    }else if(response.status=="FAILURE"){ 
                        swal('Sorry!',response.description,'warning');  
                        $(".errorcoupn").val(''); 
                        
                    }
                }
            });

    }//else

  });

/* function for apply coupon code single */
  $(".applycoupon").click(function(){
  
    var product_id = $(this).attr('product_id');
    var seller_id = $(this).attr('seller_id');

    var code = $('#code_'+product_id).val();

    var URL = "{{ url('/') }}";

    if(code==""){

      $("#codeerr_"+product_id).html('Please enter coupon code');
      $("#codeerr_"+product_id).css('color','red');   
      return false;
    }
    else
    {
        $("#codeerr_"+product_id).html(''); 

          $.ajax({
                url: URL+'/my_bag/applycouponcode',
                data: {
                    product_id: product_id,
                    code: code,
                    seller_id:seller_id

                },
                method: 'GET',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success: function(response) {
                    hideProcessingOverlay();
                    if (response.status == "SUCCESS") {

                        window.location.reload();
                        
                    }else if(response.status=="FAILURE"){ // added new
                        swal('Sorry!',response.description,'warning');  
                        $("#code_"+product_id).val(''); 
                        
                    }
                }
            });

    }//else

  });


/* function for clear coupon code */
  function clearCouponCode(seller_id)
  {
    if(seller_id){

         swal({
            title: "Need Confirmation",
            text: "Are you sure? Do you want to remove coupon code.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK",
            closeOnConfirm: false
        },
        function(isConfirm, tmp)
        {
          
             if (isConfirm == true) 
            {

             $.ajax({
                    url: URL+'/my_bag/clearcoupon_code',
                    data: {
                       seller_id:seller_id
                    },
                    method: 'GET',
                    beforeSend: function() {
                        showProcessingOverlay();
                    },
                    success: function(response) 
                    {
                        hideProcessingOverlay();
                            if (response.status == 'error') 
                          {

                              swal({
                                      title: "Error",
                                      text: response.description,
                                      type: response.status,
                                      confirmButtonText: "OK",
                                      closeOnConfirm: false
                                  },
                              function(isConfirm, tmp) 
                              {
                                  if (isConfirm == true) 
                                  {
                                      location.href = SITE_URL+'/my_bag';
                                  }
                              });
                             
                          }

                          if (response.status == 'success') 
                          {
                              swal({ 
                                  title: 'Success',
                                  text: response.description,
                                  type: 'success'
                              },
                                function(){
                                  location.href = SITE_URL+'/checkout';
                              });
                             
                          }
                    }
                });
           }
           else{
            
           }

       });
    }


  }/* end */


/* function for calculation of age */
  function age_calculation(ref) {    

     var list = document.getElementById("parsley-id-11");
   

    if (list) {
       var ul = document.querySelector('#parsley-id-11');
     var listLength = ul.children.length;

      for (i = 0; i < listLength; i++) {
        list.removeChild(list.childNodes[0]);  
      }
    }
    var split_dob = ref.value.split("/");

    var month = split_dob[0];
    var date = split_dob[1];
    var year = split_dob[2];

    var date1 = new Date();
    var date2 = new Date(""+month+"/"+date+"/ "+year+""); 

    var Difference_In_Time = date1.getTime() - date2.getTime(); 
      
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 


    if (Difference_In_Days < 7671) { 

      document.getElementById("age_error").innerHTML = "You must be 21+ and above to use chow420";
       document.getElementById("age_error").style="color:red;font-size:13px";
    }
    else {

      document.getElementById("age_error").innerHTML = "";
    }
  }

  function validateNumberAndForwardSlash(event) {

    var key = window.event ? event.keyCode : event.which;

    if (event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 47) {

      return true;
    } 
    else {
      return false;
    }
  };




  $('#btn-sign-up').click(function(){

    if($('#signup-form').parsley().validate()==false) return;

        
        var form_data = $('#signup-form').serialize();      

        if($('#signup-form').parsley().isValid() == true )
        {
                     
          var email = $("#email").val();

          $.ajax({
            url:SITE_URL+'/process_signup_checkout',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            {
              showProcessingOverlay();
              $('#btn-login').prop('disabled',true);
              $('#btn-login').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
            
              hideProcessingOverlay();
              $('#btn-sign-up').prop('disabled',false);
              $('#btn-sign-up').html('SIGN UP');

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                   if(response.type=="loggedin"){
                        $("#signup-form")[0].reset();
                        $('#user_exist_error_message').html('');
                        setTimeout(function(){
                           window.location.reload();
                        },1000);
                   }
                    
                   
                 }
                else if(response.status="ERROR")
                {
                      
                    if(response.msg!=""){
                        $('#user_exist_error_message').css('color','red').html(response.msg);
                        setTimeout(function(){
                          $("#email").val('');
                          $('#user_exist_error_message').html('');  
                        },5000);
                    }else{
                        $('#user_exist_error_message').html('');    
                    }

                                    
                }                       

              }           
            }/* end of success */
          });
        }
  });


 /* Signin Model START */
  $(document).on('click','#login-btn',function(){
    $("#login-modal").modal('show');
  });


 /* login function */
  $('#button_login').click(function()
  {

      if($('#login-form').parsley().validate()==false) return;
        
      var form_data = $('#login-form').serialize();   

      if($('#login-form').parsley().isValid() == true )
      {         
         $.ajax({
            url:SITE_URL+'/process_login',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            { 
                showProcessingOverlay();
                $('#button_login').prop('disabled',true);
                $('#button_login').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
              hideProcessingOverlay();
              $('#button_login').prop('disabled',false);
              $('#button_login').html('SIGN IN');

               if(typeof response =='object')
               {

                  if(response.status && response.status=="SUCCESS")
                  {
                    $("#login-form")[0].reset();

                     var success_HTML = '';
                     success_HTML +='<div class="alert alert-success alert-dismissible">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>'+response.message+'</div>';

                     $('#status_msg').html(success_HTML);
                     window.location.reload();
                       
                  }
                  else
                  {                    
                   
                      var error_HTML = '';   
                      if(response.message){
                         error_HTML+='<div class="alert alert-danger alert-dismissible">\
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>'+response.message+'</div>';
                        
                         $('#status_msg').html(error_HTML);

                     }
                  }
               }
            }
         });
      }
  }); /* end of login */


function gobacktosignup()
{
   swal({
          title: "!",
          text: "Please signin first",
         // type: "warning",
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = SITE_URL+"/guest_signup";
          }
      }); 
}/* END */



/* FUNCITON FOR GOOGLE TAG MANAGER PRODUCT CLICKS */
function productclick(productObj) {

  var dataLayer = dataLayer || []; 

  dataLayer.push({
    'event': 'Click',
    'ecommerce': {
      'click': {
        'actionField': {'list': 'Search Results'},      
        'products': [{
          'name': productObj.name,                      
          'id': productObj.id,
          'price': productObj.price,
          'brand': productObj.brand,
          'category': productObj.category,
          //'variant': productObj.variant,
          'position': productObj.position
         }]
       }
     },
     'eventCallback': function() {
       document.location = productObj.url
     }
  });
}/* END */



/* FUNCTION FOR APPLY DEVELIERY OPTION */
  function delivery_options_click(ref) {

    var URL     = "{{ url('/') }}";
    var _token  = "{{csrf_token()}}";

    var amount              = $(ref).attr('amount');
    var seller_id           = $(ref).attr('seller_id');
    var delivery_option_id  = $(ref).attr('id');

    $.ajax({
      url: URL+'/my_bag/apply_delivery_option',
      data: {
          _token:_token,
          amount:amount,
          seller_id:seller_id,
          delivery_option_id:delivery_option_id
      },
      method: 'POST',
      beforeSend: function() {

        showProcessingOverlay();
      },
      success: function(response) {

       

        if (response.status == "SUCCESS") {

          window.location.reload();
           hideProcessingOverlay();
            
        }else if(response.status=="FAILURE"){ 
           hideProcessingOverlay();
          swal('Sorry!',response.description,'warning');  
        }
      }
    });
  }

/* FUNCTION FOR CLEAR DELIVERY OPTION */
  function clear_radio_button(ref) {

    var key           = $(ref).attr('key');
    var seller_id     = $(ref).attr('seller_id');
    var URL           = "{{ url('/') }}";
    var _token        = "{{csrf_token()}}";
    var id            = $(ref).attr('id');
     

    swal({
            title: "Need Confirmation",
            text: "Are you sure? Do you want to remove delivery option?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK",
            closeOnConfirm: false
        },
        function(isConfirm, tmp)
        {
          
             if (isConfirm == true) 
            {


                $.ajax({
                  url: URL+'/my_bag/clear_delivery_option',
                  data: {
                      _token:_token,
                      seller_id:seller_id
                  },
                  method: 'POST',
                  beforeSend: function() {

                    showProcessingOverlay();
                  },
                  success: function(response) {
                   

                    if (response.status == "SUCCESS") {
                      swal.close();
                      $("#"+key).attr('checked', false);
                      $("#"+id).hide();
                      hideProcessingOverlay();
                      window.location.reload();
                        
                    }else if(response.status=="FAILURE"){ 
                      hideProcessingOverlay();
                      swal('Sorry!',response.description,'warning');  
                    }
                  }
                });
            }
            else
            {

            }
        });    


  }/*end */


function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
       return false;

    return true;
}


function isValidDate(input) 
{
        var regexes = [
          /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/,
          /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/
        ];

        for (var i = 0; i < regexes.length; i++) {
          var r = regexes[i];
          if(!r.test(input)) {
            continue;
          }
          var a = input.match(r), d = new Date(a[3],a[1] - 1,a[2]);
          if(d.getFullYear() != a[3] || d.getMonth() + 1 != a[1] || d.getDate() != a[2]) {
            continue;
          }
          
          return true;
        }

        return false;
}

/*function to apply wallet amount */
  $(".applywallet").click(function(){
  
    var wallet_amount = $('#wallet_amount').val();
    var URL = "{{ url('/') }}";

    if(wallet_amount==""){

      $("#walleterr").html('Please enter wallet amount');
      $("#walleterr").css('color','red');   
      return false;
    }
    else
    {
        $("#walleterr").html(''); 

          var amount = $("#amount").val();

          $.ajax({
                url: URL+'/checkout/applywalletamount',
                data: {
                    wallet_amount: wallet_amount,amount:amount
                },
                method: 'GET',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success: function(response) {                  
                    hideProcessingOverlay();
                    if (response.status == "SUCCESS") {

                        window.location.reload();
                        
                    }else if(response.status=="ERROR"){ 
                         swal('',response.message,'warning');  
                        $("#wallet_amount").val(''); 
                        
                    }
                }
            });

    }/* else */

  }); /*applywallet */



/*FUNCTION FOR CLEAR WALLET AMOUNT */
  function clearwalletamount(buyerid)
  {
    if(buyerid){

         swal({
            title: "Need Confirmation",
            text: "Are you sure? Do you want to remove wallet amount.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK",
            closeOnConfirm: false
        },
        function(isConfirm, tmp)
        {
          
             if (isConfirm == true) 
            {

             $.ajax({
                    url: URL+'/checkout/clearwallet_amount',
                    data: {
                       buyerid:buyerid
                    },
                    method: 'GET',
                    beforeSend: function() {
                        showProcessingOverlay();
                    },
                    success: function(response) 
                    {
                        hideProcessingOverlay();
                            if (response.status == 'ERROR') 
                          {

                              swal({
                                      title: "Error",
                                      text: response.description,
                                      type: response.status,
                                      confirmButtonText: "OK",
                                      closeOnConfirm: false
                                  },
                              function(isConfirm, tmp) 
                              {
                                  if (isConfirm == true) 
                                  {
                                      location.href = SITE_URL+'/checkout';
                                  }
                              });
                             
                          }

                          if (response.status == 'SUCCESS') 
                          {
                              swal({ 
                                  title: 'Success',
                                  text: response.description,
                                  type: 'success'
                              },
                                function(){
                                  location.href = SITE_URL+'/checkout';
                              });
                             
                          }
                    }
                });
           }
           else{
            
           }

       });
    }


  }/*end clearwalletamount */

</script>




<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwEKBOzIn5iOO4_0VuFcCldDziZn0cYbc&callback=initAutocomplete&libraries=places&v=weekly" async >
</script>
<script>
      // This sample uses the Autocomplete widget to help the user select a
      // place, then it retrieves the address components associated with that
      // place, and then it populates the form fields with those details.
      // This sample requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script
      // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      let placeSearch;
      let autocomplete;
      const componentForm = {
        street_number: "short_name",
        route: "long_name",
        locality: "long_name",
        administrative_area_level_1: "long_name",
        country: "long_name",
        postal_code: "short_name",
      };

      function initAutocomplete() { 
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
          document.getElementById("autocomplete"),
          { types: ["geocode"] }
        );
        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        autocomplete.setFields(["address_component"]);
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
      }

      function fillInAddress() {
        
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();

        for (const component in componentForm) {
          document.getElementById(component).value = "";
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        for (const component of place.address_components) {
          const addressType = component.types[0];

          if (componentForm[addressType]) {
            const val = component[componentForm[addressType]];


            if(addressType=="country")
            { 
               $("#country option").filter(function() { 
                 if($(this).text() == val)
                 {
                    var states_selected_val = $('#administrative_area_level_1 option:selected').val();
                    
                    get_country_id(val,states_selected_val);

                   return $(this).text() == val;    
                 }
                }).prop('selected', true);

            }
            else
            { 
              if(addressType=="administrative_area_level_1")
              { 
                 
                   $("#administrative_area_level_1 option").filter(function() {

                     return $(this).text() == val;
                    
                    }).prop('selected', true);

              }else
              {
                  if(addressType=="route")
                  {
                     const street_number = $("#street_number").val();
                      
                      if(street_number.trim()!='')
                      {
                         document.getElementById(addressType).value = street_number + " " + val;
                      }
                      else
                      {
                         document.getElementById(addressType).value = val;
                      }
                   
                  }
                  else
                  {
                    document.getElementById(addressType).value = val;
                  }
              }

              

             }/* else */
            
          }
        }
      }

      function geolocate() { 
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition((position) => {
            const geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };
            const circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy,
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }/* end geolocate */


 
/* get selected country id for address form */
function get_country_id(countryname,states_selected_val)
{
   $.ajax({
              url:SITE_URL+'/buyer/profile/get_countryid',
              type:'GET',
              data:{
                      countryname:countryname
                    },
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(countryid)
              { 
                  
                  hideProcessingOverlay();                   
                
                  if(countryid)
                  {
                    get_country_states(countryid,states_selected_val);
                  }

              }
      });
}/* function get_country_id */

/* get selected countries state for address form */
function get_country_states(country_id,states_selected_val)
{

      $.ajax({
              url:SITE_URL+'/buyer/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(response)
              { 
                  
                  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                  $("#administrative_area_level_1").html(html);
                  $("#administrative_area_level_1").val(states_selected_val);
              }
      });
  }/*end get_country_states */


/*Function for datepicker */
  $( function() {
    $( "#shipping_dob_change-input" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '1950:2020'
    });
  } );


                 
    
   $(document).on('blur','#shipping_dob_change-input',function(){ 
      var isValid = isValidDate($(this).val());
      if (isValid) {
      } else {
        document.getElementById("age_error").innerHTML = "Date of Birth entered Incorrectly";
        document.getElementById("age_error").style="color:red;font-size:13px";

      }
   }); 

  


$(document).ready(function(){


    $('[data-toggle="tooltip"]').tooltip();

     $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){

              var address = $("#route").val();
              var city = $("#locality").val();
              var state = $("#administrative_area_level_1").val();
              var country = $("#country").val();
              var zipcode = $("#postal_code").val();

              $("#billingaddresschange-input").val(address);
              $("#billingcitychange-input").val(city);
              $("#billingstatechange-input").val(state);
              $("#billingcountrychange-input").val(country);
              $("#billingzipcodechange-input").val(zipcode);

              var billing_street_address = $("#billingaddresschange-input").val();
              var billing_city = $("#billingcitychange-input").val();
              var billing_state = $("#billingstatechange-input").val();
              var billing_country = $("#billingcountrychange-input").val();
              var billing_zipcode = $("#billingzipcodechange-input").val();

              $("#billingcountrychange-input").trigger('change');
               setTimeout(function(){
                  var states = $('#administrative_area_level_1 option:selected').val();
                  $('#billingstatechange-input option[value=' + states + ']').attr('selected','selected');
              },1000);
            }else{
                $("#billingaddresschange-input").val('');
                $("#billingcitychange-input").val('');
                $("#billingzipcodechange-input").val('');
                $("#billingstatechange-input").val('');
                $("#billingcountrychange-input").val('');
            }
           
        });
    });
</script>    


@endsection


<!---------COMMNETED CODE STARTS HERE----------------------->

{{-- <script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script> 
 --}}
{{--  <script type="text/javascript" src="https://js.squareupsandbox.com/v2/paymentform"></script>
 --}}

{{-- $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
 --}}

 {{--   <link rel="stylesheet" href="/resources/demos/style.css">
 --}}  {{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
{{--   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 --}}  



{{-- @if(in_array($product['user_id'],$checkcouponcodeforseller) && $j==1)
   <div class="apply-coupon-div">

        @if(isset($sessioncoupon_data[$keys]))

       
          <input type="text" placeholder="Please enter coupon Code" name="code" class="form-control" readonly="" value="{{ $sessioncoupon_data[$keys]['couponcode'] or ''}}"   product_id="{{ $product['product_id'] }}" seller_id="{{ $product['user_id'] }}"/>

              <a href="#" class="btn" id="apply_code_{{ $product['product_id'] }}" name="apply_code"  product_id="{{ $product['product_id'] }}" seller_id="{{ $product['user_id'] }}" onclick="clearCouponCode({{$keys}});"><i class="fa fa-times"> </i> Clear</a>

        @else
          @if(isset($login_user) && $login_user==true)
            <input type="text" class="form-control"  name="code" id="code_{{ $product['product_id'] }}" placeholder="Enter coupon code" data-pro-id="{{base64_encode($product['product_id'])}}"  product_id="{{ $product['product_id'] }}" seller_id="{{ $product['user_id'] }}">                                   
           <a href="#" class="btn applycoupon" id="apply_code_{{ $product['product_id'] }}" name="apply_code"  product_id="{{ $product['product_id'] }}" seller_id="{{ $product['user_id'] }}">Apply</a>
          @endif                                  
        @endif 
        <span class="errorcoupn" id="codeerr_{{$product['product_id']}}"></span>

  </div>
  @else                            
  @endif --}}