@extends('seller.layout.master')
@section('main_content')

<div class="my-profile-pgnm">
  Payment History
    <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{ url('/') }}/seller/payment-history">Payment History</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li> View Payment History</li>
    </ul>
</div>
<div class="new-wrapper">
<div class="order-main-dvs">
   <div class="buyer-order-details">
    @php
      if ($product_arr['transaction_details']['transaction_status'] == 0) {

        $transaction_status = 'Pending';
      }
      elseif ($product_arr['transaction_details']['transaction_status'] == 1) {

        $transaction_status = 'Completed';
      }
      else{

        $transaction_status = 'Failed';
      }
    @endphp
    <div class="completed-label-page">{{$transaction_status}}</div>
     <div class="order-id-main space-slrs">
      <div class="order-id-main-left">
        <div class="ordr-id-nm">{{isset($product_arr['order_no'])?$product_arr['order_no']:'N/A'}}</div>
       
        <div class="ordertimedate">{{isset($product_arr['created_at'])?us_date_format($product_arr['created_at']):'N/A'}}     |    {{isset($product_arr['created_at'])?time_format($product_arr['created_at']):'N/A'}}</div>
      </div>
      <div class="order-id-main-right">
       <div class="seller-ord-dtls-right">
           <div class="usr-slr-order"> 


            @php
              if(isset($product['buyer_details']['profile_image']) && $product['buyer_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$product['buyer_details']['profile_image']))
              {
                $buyer_profile_img = url('/uploads/profile_image/'.$product['buyer_details']['profile_image']);
              }
              else
              {                  
                $buyer_profile_img = url('/assets/images/default-product-image.png');
              }
            @endphp
              <img src="{{$buyer_profile_img}}" alt="" />
           </div>
           <div class="usr-slr-order-right">
               <div class="emma-thomas-txt">{{isset($product_arr['buyer_details']['first_name'])?$product_arr['buyer_details']['first_name']:''}} {{isset($product_arr['buyer_details']['last_name'])?$product_arr['buyer_details']['last_name']:''}}</div>
              
               <div class="sml-txt-slrs">
               {{--  {{isset($product_arr['buyer_details']['phone']) ? $product_arr['buyer_details']['phone'] : '-'}} | --}}
                Buyer
               </div>
               <div class="sml-txt-slrs">{{isset($product_arr['buyer_details']['email']) ? $product_arr['buyer_details']['email'] : '-'}}</div>
           </div>
           <div class="clearfix"></div>
       </div>
      </div>
      <div class="clearfix"></div>
     </div>


     <div class="ordered-products-mns">
     <div class="ordered-products-titles">Product Description</div> 
      @if(isset($product_arr['order_product_details']) && count($product_arr['order_product_details']) > 0)
        @foreach($product_arr['order_product_details'] as $product)
          <div class="list-order-list">
            {{-- <div class="age-limited">18+ Age</div> --}}
            <div class="pricetbsls">${{isset($product['unit_price']) || isset($product['quantity'])? num_format($product['unit_price']*$product['quantity']): '00.00'}}</div>
              <div class="list-order-list-left">
                @php
                  if(isset($product['product_details']['product_images_details'][0]['image']) && $product['product_details']['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_details']['product_images_details'][0]['image']))
                  {
                    $product_img = url('/uploads/product_images/'.$product['product_details']['product_images_details'][0]['image']);
                  } 
                  else
                  {                  
                    $product_img = url('/assets/images/default-product-image.png');
                  }
                @endphp
                <img src="{{$product_img}}" alt="" />
              </div>
              <div class="list-order-list-right">
                <div class="humidifier-title">{{isset($product['product_details']['product_name'])?$product['product_details']['product_name']:'N/A'}}</div> 
                <div class="decs-p">{{isset($product['product_details']['description'])?$product['product_details']['description']:'N/A'}} </div>
              </div>
            <div class="clearfix"></div>
          </div>
        @endforeach
      @endif
     <div class="button-subtotal"> 
       
       <div class="button-subtotal-left">
         <div class="gsttotal slrs-ttl-hitory">
           <div class="gst-left">Transaction Amount</div>
           <div class="gst-right">${{isset($product_arr['total_amount'])?num_format($product_arr['total_amount']):'00'}}</div>
           <div class="clearfix"></div>
         </div>
       </div>
       <div class="button-subtotal-right">
       <a href="{{ url('/') }}/seller/payment-history" class="butn-def cancelbtnss">Back</a>
       </div>
       <div class="clearfix"></div>
     </div>
     </div>
   </div>
</div>
</div>
@endsection