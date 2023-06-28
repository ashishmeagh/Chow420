@extends('seller.layout.master')
@section('main_content')
        
<style>
  .whitespace-norwap{white-space: nowrap;}
  .rw-location-nms span.location-nms-right-content {
    width: auto;
   /* margin-left: 8%;*/
}
  .subtotl-min .gsttotal.slrs-ttl-hitory {
    font-size: 20px;
}
.note-view {display: block;clear: both;color: #f50000;font-size: 14px;margin-bottom: 40px;}
.note-view span{font-weight: 600;}
.subtotl-min {
    text-align: right;
    background-color: #ececec;
    padding: 10px;
}
 .subtotl-min .gsttotal.slrs-ttl-hitory .gst-right {
        margin-right: 0px;
    margin-left: 0px;
    display: inline-block;
    width: 110px;
    text-align: left;
}
.subtotl-min .gst-left{float: none; display: inline-block;}

.morecontent span {
    display: none;
} 
.morelink {
    display: block;
    color: red;
}
.morelink:hover,.morelink:focus{
  color: red;
}
.morelink.less
{
  color: red;
}
.qty-bld{
  font-weight: bold;
}


@media all and (max-width:767px){
 .whitespace-norwap{white-space: nowrap;}
  .rw-location-nms span.location-nms-right-content {
    width: auto;
    margin-left: 0;
}
}

.ordernoteclass{
  color:#873dc8;
}
</style>

<div class="my-profile-pgnm">
  Order Details
  <ul class="breadcrumbs-my">
  <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
  <li><i class="fa fa-angle-right"></i></li>

  @if(Request::segment(2) == "age_restricted_order")

    <li><a href="{{ url('/') }}/seller/age_restricted_order">Pending Age Verification Orders</a></li>

  {{-- @elseif(Request::segment(2) == "age_restricted_cancelled_order")

    <li><a href="{{ url('/') }}/seller/age_restricted_cancelled_order">Age Restricted Cancelled Orders</a></li>
 --}}
  @else

     <li><a href="{{ url('/') }}/seller/order/{{$product_status}}">{{ ucfirst($product_status) }} Order</a></li>

  @endif  
    <li><i class="fa fa-angle-right"></i></li>
    <li>Order Details</li>
  </ul>
</div>
<div class="new-wrapper">
   @include('front.layout.flash_messages')
<div class="order-main-dvs">
   <div class="buyer-order-details">
    @php


      if ($product_arr['transaction_details']['transaction_status'] == 0) {

        $transaction_status = 'Pending';
      }
      elseif ($product_arr['transaction_details']['transaction_status'] == 1) {

        $transaction_status = 'Complete';
      }
      else{

        $transaction_status = 'Failed';
      }

    @endphp
    <!-- <div class="completed-label-page">{{$transaction_status}}</div> -->
     <div class="order-id-main space-slrs">
      <div class="order-id-main-left">
        <div class="ordr-id-nm">{{isset($product_arr['order_no'])?$product_arr['order_no']:'N/A'}}</div>
       
        <div class="ordertimedate">{{isset($product_arr['created_at'])?us_date_format($product_arr['created_at']):'N/A'}}     |    {{isset($product_arr['created_at'])?time_format($product_arr['created_at']):'N/A'}}</div>

        @if(isset($product_arr['buyer_age_restrictionflag']) && $product_arr['buyer_age_restrictionflag'] ==1)
         {{--  <div>Please do not ship yet, the user is going through our age verification process</div> --}}

         <a href="javascript:void(0);" class="age-verificationbtns">Please do not ship yet, the user is going through our age verification process</a>
        @endif

      </div>



       
      <div class="order-id-main-right">
        @if(isset($product_arr['buyer_age_restrictionflag']) && $product_arr['buyer_age_restrictionflag'] ==1)
          <div class="status-dispatched">Pending Age Verification</div>
       @endif  
        

      </div>
      <div class="clearfix"></div>
     </div>

    

      <!----------buyer------------------>
      <hr>
       <div class="seller-ord-dtls-right">
           <div class="usr-slr-order">
              @php
                if(isset($product['buyer_details']['profile_image']) && $product['buyer_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$product['buyer_details']['profile_image']))
                {
                  $buyer_profile_img = url('/uploads/profile_image/'.$product['buyer_details']['profile_image']);
                }
                else
                {                  
                  $buyer_profile_img = url('/assets/images/user-degault-img.jpg');
                }
              @endphp
                <img src="{{$buyer_profile_img}}" alt="" />
           </div>
           <div class="usr-slr-order-right">
               <div class="emma-thomas-txt">{{isset($product_arr['buyer_details']['first_name'])?$product_arr['buyer_details']['first_name']:''}} {{isset($product_arr['buyer_details']['last_name'])?$product_arr['buyer_details']['last_name']:''}}</div>
               
               <div class="sml-txt-slrs">
                {{-- {{isset($product_arr['buyer_details']['phone']) ? $product_arr['buyer_details']['phone'] : '-'}} |  --}}
                Buyer
               </div>
               <div class="sml-txt-slrs">{{isset($product_arr['buyer_details']['email']) ? $product_arr['buyer_details']['email'] : '-'}}</div>
           </div>
           <div class="clearfix"></div>
       </div>
        <hr>
       <!------------end of buyer------------------>

      


    <div class="location-nms rw-location-nms">

                @php

                  
                  $address = isset($product_arr['address_details']['shipping_address1'])? $product_arr['address_details']['shipping_address1']:'';

                  $state = isset($product_arr['address_details']['state_details']['name'])? $product_arr['address_details']['state_details']['name']:'';

                  $country = isset($product_arr['address_details']['country_details']['name'])? $product_arr['address_details']['country_details']['name']:'';

                  $zipcode = isset($product_arr['address_details']['shipping_zipcode'])? $product_arr['address_details']['shipping_zipcode']:'';

                  $city = isset($product_arr['address_details']['shipping_city'])? $product_arr['address_details']['shipping_city']:'';

                  $billing_address = isset($product_arr['address_details']['billing_address1'])? $product_arr['address_details']['billing_address1']:'';

                  $billing_state =  isset($product_arr['address_details']['billing_state_details']['name'])? $product_arr['address_details']['billing_state_details']['name']:'';
                 
                  $billing_country = isset($product_arr['address_details']['billing_country_details']['name'])?$product_arr['address_details']['billing_country_details']['name']:'';

                  $billing_zipcode = isset($product_arr['address_details']['billing_zipcode'])? $product_arr['address_details']['billing_zipcode']:'';

                  $billing_city = isset($product_arr['address_details']['billing_city'])? $product_arr['address_details']['billing_city']:'';

    
                @endphp


            @if(isset($address) && $address!="")
                <span><b>Shipping Address: </b> <!-- <i class="fa fa-map-marker"></i>  --></span>
               

                @if(isset($product_arr['address_details']['shipping_address1']) && (!empty($product_arr['address_details']['shipping_address1'])))
                      {{ $product_arr['address_details']['shipping_address1'].', ' }}
                @endif  

                 @if(isset($product_arr['address_details']['shipping_city']) && (!empty($product_arr['address_details']['shipping_city'])))
                    {{ $product_arr['address_details']['shipping_city'].', ' }}
                @endif  

                @if(isset($product_arr['address_details']['state_details']['name']) && (!empty($product_arr['address_details']['state_details']['name'])))
                    {{ $product_arr['address_details']['state_details']['name'].', ' }}
                @endif  

                 @if(isset($product_arr['address_details']['country_details']['name']) && (!empty($product_arr['address_details']['country_details']['name'])))
                    {{ $product_arr['address_details']['country_details']['name'] }}
                @endif  

                  @if(isset($product_arr['address_details']['shipping_zipcode']) && (!empty($product_arr['address_details']['shipping_zipcode'])))
                      - {{ $product_arr['address_details']['shipping_zipcode'] }}
                @endif  
            @endif

          </div>
           <div class="location-nms rw-location-nms">
             
          @if(isset($product_arr['note']) && $product_arr['note'] != '')
            <span class="whitespace-norwap">
              <b style="color:#873dc8">Order Note:  </b> 
              {{-- <i class="fa fa-sticky-note-o"></i> --}}
               </span>
               <span class="location-nms-right-content" style="color:#873dc8">
              {{$product_arr['note']}}
              </span>
          @endif
           </div>


          {{-- <div class="location-nms">
            @if(isset($billing_address) && $billing_address!="")
                <span>Billing Address: </span><i class="fa fa-map-marker"></i>{{isset($product_arr['address_details']['billing_address1'])?$product_arr['address_details']['billing_address1']:''}},{{$billing_state}},{{$billing_country}} - {{$billing_zipcode}}.
            @endif
          </div> --}}
  
     <div class="ordered-products-mns">
     <div class="ordered-products-titles">Product Description</div> 
    
      @if(isset($product_arr['order_product_details']) && count($product_arr['order_product_details']) > 0)
        @php $shippingtotal=0; @endphp
        @foreach($product_arr['order_product_details'] as $product)
        @php
         $shippingtotal += $product['shipping_charges']; 

        
        @endphp

          <div class="list-order-list">
               @if(isset($product['age_restriction_detail']) && $product['age_restriction_detail']!="")
                  <div class="age-limited">                    
                        {{isset($product['age_restriction_detail']['age'])?$product['age_restriction_detail']['age']:''}}
                  </div>
                @endif



            {{-- <div class="age-limited">18+ Age</div> --}}
            <div class="pricetbsls">
                  ${{isset($product['unit_price']) || isset($product['quantity'])? num_format($product['unit_price']*$product['quantity']): '00.00'}}
            </div>
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
                <img src="{{$product_img}}" alt="{{isset($product['product_details']['product_name'])?$product['product_details']['product_name']:''}}" />
              </div>
              <div class="list-order-list-right">
                <div class="humidifier-title">{{isset($product['product_details']['product_name'])?$product['product_details']['product_name']:'N/A'}}</div> 
                <div class="qty-prc qty-divspan">
                  <span class="qty-bld">Qty:</span> <span class="qty-bld">{{isset($product['quantity'])?$product['quantity']:''}} </span> <br/>
                  <span>Unit Price : {{isset($product['unit_price'])? num_format($product['unit_price'],2):''}} </span>

                </div>

               {{--  <div class="decs-p">
                  @php echo $product['product_details']['description'] @endphp    
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


      @if($product_arr['order_status']==0)

        <div class="viewbuyr">
          <div class="gst-left">Order Status : &nbsp;&nbsp; </div>
          <div class="gst-right">   <div class="status-shipped">Cancelled</div>
          </div>
        </div>
     
        <br/>
        <div class="viewbuyr">
          <div class="gst-left">Cancellation Time : &nbsp;&nbsp; </div>
          <div class="gst-right">   {{isset($product_arr['order_cancel_time'])?date("d M Y",strtotime($product_arr['order_cancel_time'])):''}}   |   {{isset($product_arr['order_cancel_time'])?date("g:i a",strtotime($product_arr['order_cancel_time'])):''}}
          </div>
        </div>
        <br/>

        <div class="viewbuyr">
          <div class="gst-left">Cancellation Reason : &nbsp;&nbsp; </div>
          <div class="gst-right">   {{isset($product_arr['order_cancel_reason'])?$product_arr['order_cancel_reason']:'N/A'}}
          </div>
        </div>
        <br/>

      @endif

    {{-- @if(isset($product_arr['buyer_age_restrictionflag']) && $product_arr['buyer_age_restrictionflag']==0) --}}
      
      <div class="subtotl-min text-left-price">

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

           @if(isset($sellername) && isset($seller_discount_amt) && !empty($seller_discount_amt) && $seller_discount_amt>0)

            <div class="gsttotal slrs-ttl-hitory">
                <div class="gst-right">{{ isset($seller_discount_amt)? '-$'.number_format($seller_discount_amt,2):'-' }}</div>
             <div class="gst-left">Coupon : ({{ $couponcode }}) ({{ $discount}}) %: <br/> </div>
           
             <div class="clearfix"></div>
            </div>

          @endif 

          <div class="gsttotal slrs-ttl-hitory">
            <div class="gst-left">Shippping Charges : </div>
              <div class="gst-right">${{isset($shippingtotal)?num_format($shippingtotal,2):'00'}}</div>
            
            
            <div class="clearfix"></div>
          </div>
          

          @php
          // $day = date('l jS \, F Y', strtotime($product_arr['created_at']. ' + '.$product_arr['delivery_day'].' days'));

          $day = date('l, M. d Y', strtotime($product_arr['created_at']. ' + '.$product_arr['delivery_day'].' days'));
          @endphp

          @if(isset($product_arr['delivery_option_id']) && $product_arr['delivery_option_id'] != '' && isset($sellername))

           {{--  <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Delivery Option Amount : </div>
              <div class="gst-right">${{ isset($product_arr['delivery_cost'])? number_format($product_arr['delivery_cost'],2):'-' }}</div>
            </div>

            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Delivery Option Title : </div>
              <div class="gst-right">{{ isset($product_arr['delivery_title'])? $product_arr['delivery_title']:'-' }} </div>
            </div>

            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Delivery Option Day : </div>
            <div class="gst-right">{{ isset($day)? $day:'-' }}</div>
            </div> --}}

            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Delivery Option : </div>
              <div class="gst-right">
                <div class="titledeliverytxt">({{ isset($product_arr['delivery_title'])? $product_arr['delivery_title']:'-' }})  </div>
                <div class="date-calndr">{{ isset($day)? $day:'-' }}  </div>
              ${{ isset($product_arr['delivery_cost'])? number_format($product_arr['delivery_cost'],2):'-' }}
            </div>
             <div class="clearfix"></div>
            </div>
          @endif

           @php 
              $get_wallet_amountused_fororder =0;
              $get_wallet_amountused_fororder = get_wallet_amountused_fororder($product_arr['buyer_id'],$product_arr['order_no']);
            @endphp
            <div class="gsttotal slrs-ttl-hitory">
               <div class="gst-left">Wallet Amount Used: </div>
                <div class="gst-right">${{isset($get_wallet_amountused_fororder)?num_format($get_wallet_amountused_fororder):'-'}}</div>
                <div class="clearfix"></div>
            </div>
         {{--  @endif --}}



          @if(isset($product_arr['tax']) && $product_arr['tax'] != '')
            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Tax : </div>
              <div class="gst-right">
              ${{ isset($product_arr['tax'])? number_format($product_arr['tax'],2):'-' }}
            </div>
             <div class="clearfix"></div>
            </div>

          @endif





         <div class="gsttotal slrs-ttl-hitory">
            <div class="gst-left">Transaction Amount : </div>
            <div class="gst-right">${{isset($final_amount)?num_format($final_amount):'-'}}</div>
           <div class="clearfix"></div>
         </div>

      </div>

   {{--  @endif   --}} 

      <div class="button-subtotal">

      @if(isset($product_arr['buyer_age_restrictionflag']) && $product_arr['buyer_age_restrictionflag']==0)
      

        @if($product_arr['refund_status']=="2" && $product_arr['order_status']=="0")

        @else
     
          <div class="ordr-tracking-div orderinpumaindiv" id="shipping_details">
            <div class="form-group">
                <label for="">Order Tracking # <span>*</span></label>
                <input type="text" name="tracking_no" id="tracking_no" class="input-text decimal" placeholder="Enter Order Tracking No." data-parsley-required ='true' value="{{isset($product_arr['tracking_no'])?$product_arr['tracking_no']:'0'}}">
            </div>

             <div class="form-group">
                <label for="">Shipping Company Name<span>*</span></label>
                <input type="text" name="shipping_company_name" id="shipping_company_name" class="input-text decimal" placeholder="Enter shipping company name" data-parsley-required ='true' value="{{isset($product_arr['shipping_company_name'])?$product_arr['shipping_company_name']:''}}">
            </div>


            <div class="button">
              <a href="javascript:void(0)" class="butn-def update-btns-slr" onclick="updateTracking()">Update</a>
            </div>
            
            <div class="note-view"><span>Note:</span> Please enter valid tracking number and shipping company name</div>

            <input type="hidden" name="seller_id" id="seller_id" value="{{isset($product_arr['seller_id'])?$product_arr['seller_id']:'0'}}">

            <input type="hidden" name="order_id" id="order_id" value="{{isset($product_arr['order_no'])?$product_arr['order_no']:'0'}}">
          </div>

        @endif  

      @endif  

  
        <div class="clearfix"></div>
         <div class="button-subtotal-right">
   
          @if($product_arr['buyer_age_restrictionflag'] == 0)
            
           {{--  @if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2'))
               <a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="{{url('/')}}/seller/order/shipped/{{base64_encode($product_arr['id'])}}" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="{{$product_arr['tracking_no']}}" data-shipping_company_name="{{$product_arr['shipping_company_name']}}" data-enc_id="{{base64_encode($product_arr['id'])}}">Mark as Shipped</a>
            @endif --}}

            <!-------if order is ongoing then show payment status--------------->

            @if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2'))

                 @if(isset($product_arr['payment_gateway_used']) && ($product_arr['payment_gateway_used']=='square'))


                   @if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2'))
                     <a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="{{url('/')}}/seller/order/shipped/{{base64_encode($product_arr['id'])}}" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="{{$product_arr['tracking_no']}}" data-shipping_company_name="{{$product_arr['shipping_company_name']}}" data-enc_id="{{base64_encode($product_arr['id'])}}">Mark as Shipped</a>
                   @endif

                @elseif(isset($product_arr['payment_gateway_used']) && ($product_arr['payment_gateway_used']=='authorizenet') && isset($product_arr['authorize_transaction_status']) && $product_arr['authorize_transaction_status']=="settledSuccessfully")

                     @if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2'))
                     <a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="{{url('/')}}/seller/order/shipped/{{base64_encode($product_arr['id'])}}" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="{{$product_arr['tracking_no']}}" data-shipping_company_name="{{$product_arr['shipping_company_name']}}" data-enc_id="{{base64_encode($product_arr['id'])}}">Mark as Shipped</a>
                    @endif
                 @else
                     <a href="javascript:void(0)" class="btn btn-info" id="ship-order" title="Payment for this order is still being processed. You will receive a notification as soon as the payment is settled" onclick="payment_pending_status()">Payment Pending</a>
                
                 @endif   
             @endif     
             <!-------if order is ongoing then show payment status--end------>

          @endif



          @if(isset($product_arr['order_status']) && ($product_arr['order_status']=='3'))
            <!----------commented delivered button for shipengine------------------->
            {{-- <a href="javascript:void(0)" class="btn btn-info" id="deliver-order" data-href="{{url('/')}}/seller/order/delivered/{{base64_encode($product_arr['id'])}}" data-id="deliver" onclick="confirm_order_status($(this))" data-tracking_no="{{$product_arr['tracking_no']}}" data-shipping_company_name="{{$product_arr['shipping_company_name']}}" data-enc_id="{{base64_encode($product_arr['id'])}}">Delivered</a> --}}
          @endif
              
            
            @php
              if(isset($product_arr['created_at']))
              {
               $order_date = date("Y-m-d",strtotime($product_arr['created_at']));
               $request_date = date('Y-m-d', strtotime($order_date. ' + 3 days'));
               $current_date =date("Y-m-d");

              // if($current_date<$request_date) {
              @endphp
                @if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2'))

                  <a data-order_id="{{$product_arr['id']}}"  class="butn-def cancel_order_btn" id="btn_cancel_order">Cancel Order</a>   

                @endif 
              @php
              // }
            }
            @endphp
            <a href="javascript:history.go(-1);" class="butn-def cancelbtnss">Back</a>
        </div>

       <div class="clearfix"></div>
       
     </div>


     </div>
   </div>
      <br>
      @php 
     //   dd($tracking_info);
      @endphp
      @if(isset($tracking_info) && !empty($tracking_info))
      <div class="buyer-order-details"><span><b>Order Tracking Status : </b> </span>  

                <div class="location-nms">
                <span><b>Order Status Code: </b> </span>
                  @if(isset($tracking_info['carrier_status_code']) && (!empty($tracking_info['carrier_status_code'])))
                     {{$tracking_info['carrier_status_code']}}
                  @else
                   - 
                  @endif 
                  </div>
                  <div class="location-nms">
                <span><b>Order Status: </b> </span>
                  @if(isset($tracking_info['status_description']) && (!empty($tracking_info['status_description'])))
                     {{$tracking_info['status_description']}}
                  @else
                    -  
                  @endif 
                  </div>
                  <div class="location-nms">
                   <span><b>Shipped At : </b> </span>  
                  @if(isset($tracking_info['ship_date']) && (!empty($tracking_info['ship_date'])))
                     {{date('d M Y H:i:s A',strtotime($tracking_info['ship_date']))}}
                  @else
                    -   
                  @endif
                  </div>  
                  <div class="location-nms">
                   <span><b>Delivered Date : </b> </span>  
                  @if(isset($tracking_info['actual_delivery_date']) && (!empty($tracking_info['actual_delivery_date'])))
                     {{date('d M Y H:i:s A',strtotime($tracking_info['actual_delivery_date']))}}
                  @else
                    -   
                  @endif
                  </div>

                   <div class="location-nms">
                     <span><b>Expected Delivery Date : </b> </span>  
                    @if(isset($tracking_info['estimated_delivery_date']) && (!empty($tracking_info['estimated_delivery_date'])))
                       {{date('d M Y H:i:s A',strtotime($tracking_info['estimated_delivery_date']))}}
                    @else
                      -   
                    @endif
                  </div>  


        </div> 
      @endif
      <br>
      @if(isset($lable_info) && sizeof($lable_info)>0) 
         <div class="buyer-order-details"><span><b>You can download the lable from following :</b> </span>  
                <div class="location-nms">
                  @if(isset($lable_info['label_download']) && (sizeof($lable_info['label_download'])>0))
                    @foreach($lable_info['label_download'] as $label) 
                    <a href="{{$label}}" target="blank">{{$label}}</a><br/>
                    @endforeach 
                  @else
                    -   
                  @endif 
                </div>
        </div>
      @endif  

</div>
</div>

<!--------------------start of modal-------------------------------------->
<div class="modal fade" id="cancel_order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="model_order_id" id="model_order_id" value="">
    <div class="modal-content">
      <div class="modal-header mdl-boder-btm">
        <h3 class="modal-title" id="exampleModalLabel" align="center">Cancel Order</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cancel_order_modal_body">
        <div class="mainbody-mdls">        
          {{-- 
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"> <b>Cancel Dat : </b></div>
             <div class="mainbody-mdls-fd-right" id="to"></div>
             <div class="clearfix"></div>
          </div>

          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"><b>Product Link :</b></div>
             <div class="mainbody-mdls-fd-right link-http" id="link"></div>
             <div class="clearfix"></div>
          </div> --}}

          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"> <b>Cancellation Reason :</b></div>
             <div class="mainbody-mdls-fd-right">
               <textarea id="model_order_cancel_reason" rows="5" class="form-control" placeholder="Please enter your order cancellation reason..." maxlength="300"></textarea>

               <div class="report-note">Note: Only 300 characters allowed.</div>  

               <span id="msg_err"></span>

             </div>
             <div class="clearfix"></div>
          </div>

        </div>
      
      </div>
      <div class="modal-footer">
        <div class="sre-product">
        
          <img src="{{ url('/') }}/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" />
          <a  class="butn-def" id="cancel_order_model_btn" onclick="cancelOrder($(this));">Confirm Cancellation</a>

        </div>
      </div>
    </div>
  </div>
</div>
<!-----------------end of modal---------------------->

<script>
// onclick="cancelOrder($(this));"
$(document).on('click','#btn_cancel_order',function(){
  $("#cancel_order_modal").modal('show'); 
  var order_id = $(this).attr('data-order_id');
  $('#model_order_id').val(order_id);
     
});


function payment_pending_status()
  {
      swal({
          title:'Payment Processing',
          text: 'Payment for this order is still being processed. You will receive a notification as soon as the payment is settled',
         // type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            //window.location.reload();             
          }           
       });

      return false;
  }


</script>




<script>


 function cancelOrder(ref)
{
  if($('#model_order_cancel_reason').val()=='')
  {
    $('<span>Please enter the cancellation reason.. </span>').css('color','red').insertAfter('#model_order_cancel_reason').fadeOut(5000);
    return false;
  }
  swal({
    title: 'Do you really want to cancel this order?',
    type: "warning",
    showCancelButton: true,
    // confirmButtonColor: "#DD6B55",
    confirmButtonColor: "#8d62d5",
    confirmButtonText: "Yes, do it!",
    closeOnConfirm: false
  },
  function(isConfirm,tmp)
  {    
    if(isConfirm==true)
    {
      var order_id   = $('#model_order_id').val();
      var order_cancel_reason =  $('#model_order_cancel_reason').val();
      var csrf_token = "{{ csrf_token()}}";

      var logged_in_user  = "{{Sentinel::check()}}";


      if(logged_in_user)
      {

        $.ajax({
          url: SITE_URL+'/seller/order/cancel',
          type:"POST",
          data: {order_id:order_id,order_cancel_reason:order_cancel_reason,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){     
          showProcessingOverlay();
            $('#btn_cancel_order').prop('disabled',true);
            $('#btn_cancel_order').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');       
          },
          success:function(response)
          {
            hideProcessingOverlay();
            $('#btn_cancel_order').prop('disabled',false);
            $('#btn_cancel_order').html('Cancel Order');

            if(response.status == 'SUCCESS')
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
                      $(this).addClass('active');

                    }

                  });
            }
            else
            {                
              swal('Error',response.description,'error');
            }  
          }  

        }); 

      }
    }
  })
}

  function confirm_order_status(ref)
  {
    var tracking_no           = $(ref).data('tracking_no');
    var shipping_company_name = $(ref).data('shipping_company_name');
    var enc_id                = $(ref).data('enc_id');

    if(tracking_no == '' && shipping_company_name == '')
    {
      swal({
          title:'Alert!',
          text: 'Please add tracking # & shipping company name first!',
         // type: "warning",
          // showCancelButton: true,
          confirmButtonColor: "#8d62d5",
          // confirmButtonText: "Go to order detail page",
          closeOnConfirm: true
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            // window.location = module_url_path+'/view/'+enc_id+'#shipping_details';             
          }           
       });

      return false;
    }
    else
    { 
        var actionname = $(ref).data('id');
        var actionlink = $(ref).data('href');

        var msgtitle = 'Do you really want to '+actionname+' this order?';
        if(actionname=="ship"){
          var msgtitle = "Ship Now?";
             swal({
            //  title: 'Do you really want to '+actionname+' this order?',
              title: msgtitle,
              type: "warning",
              showCancelButton: true,
            //   confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: false
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                //showProcessingOverlay();
                window.location= actionlink;
                 
              }           
           });


        }
        else if(actionname=="deliver")
        {
          var msgtitle ='Has this item been delivered?';
           window.location= actionlink;
        }
        else{
          var msgtitle ='Do you really want to '+actionname+' this order?';
             swal({
            //  title: 'Do you really want to '+actionname+' this order?',
              title: msgtitle,
              type: "warning",
              showCancelButton: true,
            //   confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: false
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                //showProcessingOverlay();
                window.location= actionlink;
                 
              }           
           });


        }//else
    
       
    }

  }

</script>
<script>
 
 /* function showFunction(diva, divb) {
      var x = document.getElementById(diva);
      var y = document.getElementById(divb);
          x.style.display = 'block';
          y.style.display = 'none';
    }
 */

  function updateTracking() 
  {
    var tracking_no = $('#tracking_no').val();
    var seller_id = $('#seller_id').val();
    var order_id = $('#order_id').val();
    var shipping_company_name = $("#shipping_company_name").val();

    if(tracking_no == '')
    {
       $('#tracking_no').after('<div class="red">Please enter tracking no.</div>');
        return false;
    }
     if(shipping_company_name == '')
    {
       $('#shipping_company_name').after('<div class="red">Please enter shipping company name</div>');
        return false;
    }

    $.ajax({
          url: SITE_URL+'/seller/order/updateTracking',
          type:'POST',         
          data: {tracking_no:tracking_no,shipping_company_name:shipping_company_name,seller_id:seller_id, order_id:order_id,
                      _token: '{{csrf_token()}}'},         
          dataType:'json',
        beforeSend : function()
        { 
          showProcessingOverlay();        
        },
        success:function(data){
          hideProcessingOverlay();
          // console.log(response);
          if(data.status == 'success')
          {
            swal({
                   title: 'Success',
                   text: data.description,
                   type: data.status,
                   confirmButtonText: "OK",
                   closeOnConfirm: false
                },
               function(isConfirm,tmp)
               {
                 if(isConfirm==true)
                 {
                    window.location.reload();
                    // window.location.href=SITE_URL+'/seller/order/ongoing';

                 }
               });
          }
          else{
              // swal('warning',data.description,data.status);
               swal('Alert!',data.description); 
            } 
        }
    })
  }

  $(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 100;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";
    

    $('.decs-p').each(function() {
        var content = $(this).html().trim();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});


</script>  
@endsection