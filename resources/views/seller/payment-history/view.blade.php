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


     <div class="ordered-products-mns payment-view-history-pmt">
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


               {{--  <div class="decs-p">
                     {{isset($product['product_details']['description'])?$product['product_details']['description']:'N/A'}} 
                </div> --}}

<!--------start-product description------------------->
                 <div class="content"> 
                    <div class="hidecontent" id="hidecontent_{{ $product['product_details']['id'] }}">
                      @if(strlen($product['product_details']['description'])>50)
                       @php echo substr($product['product_details']['description'],0,50) @endphp
                      <span class="show-more" style="color: red;cursor: pointer;" onclick="return showmore({{ $product['product_details']['id'] }})">Show more</span>
                      @else
                         @php echo $product['product_details']['description'] @endphp
                      @endif
                    </div>
                       <span class="show-more-content" style="display: none" id="show-more-content_{{ $product['product_details']['id'] }}">
                        @php echo $product['product_details']['description'] @endphp
                        <span class="show-less" style="color:red;cursor: pointer;" onclick="return showless({{ $product['product_details']['id'] }})"  id="show-less_{{ $product['product_details']['id'] }}">Show less</span>
                      </span>
                 </div>
<script>

  function showmore(id)
  {
    $('#show-more-content_'+id).show();
     $('#show-less_'+id).show();
     $("#hidecontent_"+id).hide();
  }

   function showless(id)
  {
     $('#show-more-content_'+id).hide();
     $('#show-less_'+id).hide();
     $("#hidecontent_"+id).show();
  }

</script>
<!-----------end product description------------------>


              </div>
            <div class="clearfix"></div>
          </div>
        @endforeach
      @endif
     <div class="button-subtotal"> 

          @php 

           $final_amount = isset($product_arr['total_amount'])?$product_arr['total_amount']:'';


          $couponcode = isset($product_arr['couponcode'])?$product_arr['couponcode']:'';
          $discount = isset($product_arr['discount'])?$product_arr['discount']:'';
          $seller_discount_amt = isset($product_arr['seller_discount_amt'])?$product_arr['seller_discount_amt']:'';
          $sellername = get_seller_details($product_arr['seller_id']);
          $final_amount = (float)$final_amount - (float)$seller_discount_amt;

          if (isset($product_arr['delivery_option_id']) && $product_arr['delivery_option_id'] != '') {
            
            $final_amount = (float)$final_amount + (float)$product_arr['delivery_cost'];
          }

          if (isset($product_arr['tax']) && $product_arr['tax'] != '') {
            
            $final_amount = (float)$final_amount + (float)$product_arr['tax'];
          }

          @endphp 

          @if(isset($couponcode) && !empty($couponcode) && isset($seller_discount_amt) && 
          $seller_discount_amt>0)
             <div class="">
               <div class="gsttotal slrs-ttl-hitory">
                 <div class="gst-left">Couponcode ({{ $couponcode }}) ({{ $discount}})% : </div>
               
                 <div class="gst-right"> {{ isset($seller_discount_amt)? '-$'.number_format($seller_discount_amt,2):'-' }}</div>
                 <div class="clearfix"></div>
               </div>
             </div>
         @endif

         @if(isset($product_arr['delivery_option_id']) && $product_arr['delivery_option_id'] != '')
          <div class="">
           <div class="gsttotal slrs-ttl-hitory">
             <div class="gst-left">Delivery Option Cost : </div>
             <div class="gst-right">${{isset($product_arr['delivery_cost'])?num_format($product_arr['delivery_cost'] , 2):'00'}}</div>
             <div class="clearfix"></div>
           </div>
         </div>
         @endif

         @if(isset($product_arr['tax']) && $product_arr['tax'] != '')
          <div class="">
           <div class="gsttotal slrs-ttl-hitory">
             <div class="gst-left">Tax : </div>
             <div class="gst-right">${{isset($product_arr['tax'])?num_format($product_arr['tax'] , 2):'00'}}</div>
             <div class="clearfix"></div>
           </div>
         </div>
         @endif
       
       {{-- <div class="button-subtotal-left"> --}}
        <div class="">
         <div class="gsttotal slrs-ttl-hitory">
           <div class="gst-left">Transaction Amount : </div>
           {{-- <div class="gst-right">${{isset($product_arr['total_amount'])?num_format($product_arr['total_amount']):'00'}}</div> --}}
           <div class="gst-right">${{isset($final_amount)?num_format($final_amount):'00'}}</div>
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