@extends('front.layout.master')
@section('main_content')

@if(isset($order_no) && !empty($order_no) && isset($total_amt) && !empty($total_amt))
<div class="cart-section-block">
    <a href="javascript:void(0)" class="cart-step-one">
        <div class="step-one step-active complited-act">
            <span class="num-step num-step-hide"></span>
            <span class="step-tick"> </span>
            <span class="name-step-confirm">Shipping Cart</span>
        </div>
        <div class="clearfix"></div>
    </a>
    <a href="javascript:void(0)" class="cart-step-one">
        <div class="step-one step-active complited-act">
            <span class="num-step font-style"> </span>
            <span class="name-step-confirm">Payment & Billing </span>
        </div>
        <div class="clearfix"></div>
    </a>
    <a href="#" class="cart-step-one">
        <div class="step-one step-active last-cart-step">
            <span class="num-step font-style"> </span>
            <span class="name-step-confirm">Order Placed</span>
        </div>
        <div class="clearfix"></div>
    </a>
    <div class="clearfix"></div>
</div>
@else

@endif
<div class="container">
<div class="age-verification-div">
 @if(isset($buyeragerestrictionflag) && !empty($buyeragerestrictionflag) && $buyeragerestrictionflag>0)
   <a href="{{ url('/') }}/buyer/age-verification" target="_blank">
     <div class="fnt-clr">Age Verification Needed </div>
     <div class="fnt-clr-content">
       You need to add your age-verification details for your order to be shipped. Click this button to add your age-verification details
     </div>
   </a>
 @endif
 </div>
</div>

@if(isset($buyeragerestrictionflag) && !empty($buyeragerestrictionflag) && $buyeragerestrictionflag>0)
<div class="passport-main-margin">
   <div class="container">
    <div class="passportmain-flex">
         <div class="passport-front-list">
             <div class="passport-front-txt">ID/Passport Front</div>
             <div class="passport-front-top">
              <a href="{{ url('/') }}/buyer/age-verification" target="_blank">
               <img src="{{ url('/') }}/assets/front/images/passport-front-card.png" />
             </a>
             </div>
             <div class="passport-front-button">
                <a href="{{ url('/') }}/buyer/age-verification" class="uplaod-cw-btn" target="_blank">Upload</a>
             </div>
         </div>
         <div class="passport-front-list">
            <div class="passport-front-txt">ID/Passport Back</div>
             <div class="passport-front-top">
              <a href="{{ url('/') }}/buyer/age-verification" target="_blank">
               <img src="{{ url('/') }}/assets/front/images/passport-back-card.png" />
              </a>
             </div>
             <div class="passport-front-button">
                <a href="{{ url('/') }}/buyer/age-verification" class="uplaod-cw-btn" target="_blank">Upload</a>
             </div>
         </div>
         <div class="passport-front-list">
          <div class="passport-front-txt">ID/Passport Hands-Held</div>
             <div class="passport-front-top">
              <a href="{{ url('/') }}/buyer/age-verification" target="_blank">
               <img src="{{ url('/') }}/assets/front/images/passport-hand-held.png" />
              </a>
             </div>
             <div class="passport-front-button">
                <a href="{{ url('/') }}/buyer/age-verification" class="uplaod-cw-btn" target="_blank">Upload</a>
             </div>
         </div>
      </div>
   </div>
  </div>
@endif




@if(isset($order_no) && !empty($order_no))
<div class="container">
    <div class="ordts-checkots">
         @if(isset($buyeragerestrictionflag) && !empty($buyeragerestrictionflag) && $buyeragerestrictionflag>0)
            <div class="confirmation-tx"><a href="{{ url('/') }}/buyer/age-verification" target="_blank">Click here</a> to get age-verified, so the dispensary can ship your order to you on time.</div>
        @endif  

        <div class="order-yours-txs">Order Details!</div>
        <div class="succefully-tx">Your order has been successfully placed.</div>
        <div class="order-nums">Order No: <span>{{$order_no}}</span></div>
       <div class="confirmation-tx">You will receive the confirmation shortly</div> 
       <div class="order-nums"><a href="{{url('/')}}/search" type="button" class="butn-def" >Continue Shopping</a> </div>
    </div>
</div>
@else
 
  <div class="container">
    <div class="ordts-checkots">
         <div class="order-yours-txs">No such order Available.</div>
    </div>
 </div>

@endif




@if(isset($order_no) && !empty($order_no) && isset($total_amt) && !empty($total_amt))

{{-- <img src="https://www.shareasale.com/sale.cfm?tracking={{ $order_no }}&amount={{ $total_amt}}&merchantID=101178&transtype=sale" width="1" height="1">
<script src="https://www.dwin1.com/19038.js" type="text/javascript" defer="defer"></script> --}}
@endif



@php

$time = $address = $state = $country = $zipcode = $city = $billing_address = $billing_state = $billing_country = $billing_state = $billing_zipcode = $billing_city = $buyerfname = $buyerlname = $buyeremail = $buyerzip = $buyerstreetaddr = $buyerphone = $category_name = $orderno = $sellername = '';

$get_total_amount =  $shippingtotal =0;
$name = $category_array = $product_array1 = $product_array = [];

$google_api_arr = $google_api_arr1 = $google_api_arr_products = []; $total_shipping_charge_api = 0;

if(isset($order_details_arr) && !empty($order_details_arr))
{
      foreach($order_details_arr as $product_list){
      $get_total_amount =  number_format($get_total_amount+$product_list['total_amount'],2);

      }

      $orderno = isset($order_details_arr[0]['order_no'])?$order_details_arr[0]['order_no']:'';
  
      $address = isset($order_details_arr[0]['address_details']['shipping_address1'])?$order_details_arr[0]['address_details']['shipping_address1']:'';

      $state = isset($order_details_arr[0]['address_details']['state_details']['name'])?$order_details_arr[0]['address_details']['state_details']['name']:'';

      $country = isset($order_details_arr[0]['address_details']['country_details']['name'])?$order_details_arr[0]['address_details']['country_details']['name']:'';

      $zipcode = isset($order_details_arr[0]['address_details']['shipping_zipcode'])?$order_details_arr[0]['address_details']['shipping_zipcode']:'';

      $city = isset($order_details_arr[0]['address_details']['shipping_city'])?$order_details_arr[0]['address_details']['shipping_city']:'';


      $billing_address = isset($order_details_arr[0]['address_details']['billing_address1'])?$order_details_arr[0]['address_details']['billing_address1']:'';

      $billing_state = isset($order_details_arr[0]['address_details']['billing_state_details']['name'])?$order_details_arr[0]['address_details']['billing_state_details']['name']:'';

      $billing_country = isset($order_details_arr[0]['address_details']['billing_country_details']['name'])?$order_details_arr[0]['address_details']['billing_country_details']['name']:'';

      $billing_zipcode = isset($order_details_arr[0]['address_details']['billing_zipcode'])?$order_details_arr[0]['address_details']['billing_zipcode']:'';

      $billing_city = isset($order_details_arr[0]['address_details']['billing_city'])?$order_details_arr[0]['address_details']['billing_city']:'';

      $buyerfname = isset($order_details_arr[0]['buyer_details']['first_name'])?$order_details_arr[0]['buyer_details']['first_name']:'';

      $buyerlname = isset($order_details_arr[0]['buyer_details']['last_name'])?$order_details_arr[0]['buyer_details']['last_name']:'';

      $buyeremail = isset($order_details_arr[0]['buyer_details']['email'])?$order_details_arr[0]['buyer_details']['email']:'';

      $buyerzip = isset($order_details_arr[0]['buyer_details']['zipcode'])?$order_details_arr[0]['buyer_details']['zipcode']:'';

      $buyerstreetaddr = isset($order_details_arr[0]['buyer_details']['street_address'])?$order_details_arr[0]['buyer_details']['street_address']:'';

      $buyerphone = isset($order_details_arr[0]['buyer_details']['phone'])?$order_details_arr[0]['buyer_details']['phone']:'';


      foreach($order_details_arr as $kk=>$product_list)
      {

       foreach($product_list['order_product_details'] as $k=>$product_details_arr)
       {
         
         $price = 0;
         $shippingtotal =  isset($product_details_arr['shipping_charges'])?number_format($shippingtotal+$product_details_arr['shipping_charges'],2):'';

         if($product_details_arr['quantity']==1)
         {
            $price = $product_details_arr['unit_price'];
         }
         else{
            $price = $product_details_arr['unit_price']*$product_details_arr['quantity']; 
         }   
         $name[] = isset($product_details_arr['product_details']['product_name'])?$product_details_arr['product_details']['product_name']:'';
         
          $category_name    =  isset($product_details_arr['product_details']['first_level_category_id'])?get_first_levelcategorydata($product_details_arr['product_details']['first_level_category_id']):'';
          if(!in_array($category_name,$category_array))
          {
              $category_array [] = $category_name;
          }

        $product_array['ProductID']   = $product_details_arr['product_details']['id'];
        $product_array['ProductName']  = $product_details_arr['product_details']['product_name'];
        $product_array['Quantity']     = $product_details_arr['quantity'];
        $product_array['ItemPrice']    = num_format($product_details_arr['unit_price']);
        $product_array['RowTotal']     = $product_details_arr['quantity'] *$product_details_arr['unit_price'];
         $product_array['Shipping Charges']  = num_format($product_details_arr['shipping_charges']);
         $sellername = get_seller_details($product_details_arr['product_details']['user_id']);         
         $product_array['Dispensary']  = isset($sellername)?$sellername:'';       
         $product_array1[] = $product_array;

         $total_shipping_charge_api = $total_shipping_charge_api+ num_format($product_details_arr['shipping_charges']);





         $google_api_arr_products['id'] = isset($product_details_arr['product_details']['id'])?$product_details_arr['product_details']['id']:'';
         $google_api_arr_products['name'] = isset($product_details_arr['product_details']['product_name'])?$product_details_arr['product_details']['product_name']:'';
         $google_api_arr_products['quantity'] = isset($product_details_arr['quantity'])?$product_details_arr['quantity']:'';
          $google_api_arr_products['category'] = isset($product_details_arr['product_details']['first_level_category_id'])?get_first_levelcategorydata($product_details_arr['product_details']['first_level_category_id']):'';

          $google_api_arr_products['category'] = isset($product_details_arr['product_details']['brand'])?get_first_levelcategorydata($product_details_arr['product_details']['brand']):'';

          $google_api_arr_products['price'] = $product_details_arr['quantity'] *$product_details_arr['unit_price'];
           $google_api_arr[]= isset($google_api_arr_products)?$google_api_arr_products:[];

              

     }//foreach

        $transaction_id = isset($order_details_arr[0]['transaction_id'])?$order_details_arr[0]['transaction_id']:'';
        $revenue = isset($get_total_amount)?$get_total_amount:'';
        $shipping = isset($total_shipping_charge_api)?$total_shipping_charge_api:'';
        $google_api_arr1 = isset($google_api_arr)?$google_api_arr:[];

   }//foreach
    


$time = time();

}//foreach

//dd($google_api_arr1);


@endphp


@php 
if(isset($order_details_arr) && !empty($order_details_arr))
{
@endphp

<script>
    var _learnq = _learnq || [];
     _learnq.push(["track", "Placed Order", {

             "event_id": "{{$time or ''}}",
              "event": "Placed Order",
              "Order No" : "{{ $orderno }}",
             "customer_properties": {
             "email": "{{ $buyeremail or '' }}",
             "first_name": "{{ $buyerfname or '' }}",
             "last_name": "{{ $buyerlname or '' }}",
             //"phone_number": "{{ $buyerphone or '' }}",
             "address1": "{{ $buyerstreetaddr or '' }}"          
             },
             "value": {{$get_total_amount or ''}},
             "Shipping Charges": {{ $shippingtotal or ''}},
             "ItemNames": <?php echo json_encode($name); ?>,
             "Categories": <?php echo json_encode($category_array); ?>,
             "Items":  [<?php echo json_encode($product_array1);?>] ,
              "ShippingAddress": {
               "FirstName": "{{ $buyerfname or '' }}",
               "LastName": "{{ $buyerlname or '' }}",
               "Address1": "{{ $buyerstreetaddr or '' }}",
               //"Phone": "{{ $buyerphone or '' }}",
                "City": "{{ $city or '' }}",
                "Country": "{{ $country or '' }}",
                "Zip": "{{ $zipcode or '' }}"
               
             },
              "BillingAddress": {
               "FirstName": "{{ $buyerfname or '' }}",
               "LastName": "{{ $buyerlname or '' }}",
               "Address1": "{{ $buyerstreetaddr or '' }}",
               // "Phone": "{{ $buyerphone or '' }}",
               "City": "{{ $billing_city or '' }}",
               "Country": "{{ $billing_country or '' }}",
               "Zip":  "{{ $billing_zipcode or '' }}"              
             },
        }]);

         var dataLayer = dataLayer || []; 
           dataLayer.push({
              'event': 'Purchase',
              'ecommerce': {
                'purchase': {
                  'actionField': {
                    'id': '{{ $transaction_id or '' }}',  
                    'revenue': '{{ $revenue or '' }}',              
                    'shipping': '{{ $shipping or '' }}',
                    //'coupon': 'SUMMER_SALE'
                  },
                  'products': <?php echo json_encode($google_api_arr1) ?>
                }
              }
            });


</script>


@php
}
@endphp




@endsection 