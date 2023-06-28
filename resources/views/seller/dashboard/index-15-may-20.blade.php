@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
  .referalbutton
  {
    color:white;
    background-color: #873dc8;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
  }
   /*.refer_link {float:none; margin:0 auto;}*/
  .refer_link .myodr-icn-byr {background:none;}
  .add-cart {
    background-color: #873dc8;
    color: #fff;
    font-weight: 600;
    vertical-align: top;
    font-size: 12px;
    padding: 8px 28px;
    text-transform: uppercase;
    display: inline-block;
    border: 1px solid #873dc8;
    letter-spacing: 0.7px;
    border-radius: 3px;                                                                                                                                                                                                                               
}

.add-cart:hover {
    color: #873dc8;
    background-color: #fff;
    transition: 0.3s;
}
</style>


<div class="my-profile-pgnm">
Dashboard

  <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}">Home</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Dashboard</li>
  </ul>
</div>
@php 
  
  $referalcode = $referalcode;
//  dd($user_subscriptiondata);


@endphp

<div class="new-wrapper">
<div class="dashboardbuyr-dash">

  @if($user_subscribed=="1" && isset($user_subscriptiondata) && !empty($user_subscriptiondata) && isset($user_subscriptiondata[0]['membership']) && $user_subscriptiondata[0]['membership']=="2")
   <div class="row"> 
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 refer_link">
    <div class="my-order-buyr-main ord-my-blue">
        <div class="myodr-icn-byr" style="background: bottom;">
          <img src="https://beta.chow420.com/assets/seller/images/referal.png" alt="">
        </div>
        <div class="content">
         <h3>Earn $7!</h3>
          <p>Invite other sellers and get $7 in your wallet when they do the registration using this link </p>
          <p id="urlLink" style="display: none;">{{ url('/')}}/refer?referalcode={{ $referalcode }}</p>
          <a href="javascript:void(0)" class="add-cart" onclick="shareLink('#urlLink')"> Invite</a>
          <div class="copeid-sms" id="copy_txt" style="display:none;"> Link Copied!</div>
        </div>
        <!-- <a href="#" class="viewall-lnk">View All</a> -->
      </div>
    </div>
   </div>
  @endif


  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <a href="{{ url('/') }}/seller/product">
      <div class="my-order-buyr-main ord-my-blue">
        <div class="myodr-icn-byr">
          <img src="{{url('/')}}/assets/seller/images/my-order-icns-buyer.png" alt="" />
        </div>
        <div class="totl-cnts-nm">{{$total_product or 0}}</div>
        <div class="my-odr-grey">My Products</div>
        <!-- <a href="#" class="viewall-lnk">View All</a> -->
      </div>
      </a>
    </div>


    <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class="my-order-buyr-main ord-my-review-tr">
        <div class="myodr-icn-byr">
          <img src="{{url('/')}}/assets/seller/images/review-rating-icn-buyer.png" alt="" />
        </div>
        <div class="totl-cnts-nm">0</div>
        <div class="my-odr-grey">Review and Ratings</div>
        <a href="#" class="viewall-lnk">View All</a>
      </div>
    </div> -->
    <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class="my-order-buyr-main ord-my-wishlist-tr">
        <div class="myodr-icn-byr">
          <img src="{{url('/')}}/assets/seller/images/wishlist-icn-buyer.png" alt="" />
        </div>
        <div class="totl-cnts-nm">0</div>
        <div class="my-odr-grey"><b>My Wishlist</b></div>
        <a href="#" class="viewall-lnk">View All</a>
      </div>
    </div> -->
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <a href="{{ url('/') }}/seller/notifications">
      <div class="my-order-buyr-main ord-notification-tr">
        <div class="myodr-icn-byr">
          <img src="{{url('/')}}/assets/seller/images/notification-icn-buyer.png" alt="" />
        </div>
        <div class="totl-cnts-nm">{{$total_notification or 0}}</div>
        <div class="my-odr-grey">Notifications</div>
        <!-- <a href="#" class="viewall-lnk">View All</a> -->
      </div>
    </a>
    </div>
  </div>


  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
      <div class="dashboard-myprofile">
        <div class="myporfiledash-byr">
         <!-- @if(!empty($arr_seller_details['profile_image']) && file_exists(base_path().'/uploads/profile_image/'.$arr_seller_details['profile_image']))
         
            <img src="{{url('/')}}/uploads/profile_image/{{$arr_seller_details['profile_image']}}" alt="" />
         
         @else
            <img src="{{url('/')}}/assets/images/avatar.png" alt="" />
         @endif -->
         <img src="{{url('/')}}/assets/seller/images/storeicon.png" alt="" />


        </div>
        <div class="byrdashbrd">
          <div class="title-profls-byrs">
            @php
                $set_name ='';
                if(isset($seller_arr) && !empty($seller_arr)){
                  if($arr_seller_details['first_name']=="" && $arr_seller_details['last_name']=="")
                  {
                    $set_name = $seller_arr['business_name']; 
                  }
                  else
                  {
                    $set_name =  $arr_seller_details['first_name'].' '.$arr_seller_details['last_name'];
                  } 
                }else{
                   $set_name =  $arr_seller_details['first_name'].' '.$arr_seller_details['last_name'];
                }

            @endphp


            {{ $set_name }}
            {{-- {{$arr_seller_details['first_name']}} {{$arr_seller_details['last_name']}} --}}

          </div>
          <div class="buyertxts">{{ucfirst($arr_seller_details['user_type'])}}</div>

          @if(isset($arr_seller_details['street_address']) && !empty($arr_seller_details['street_address']))
          <div class="address-pfl-byr">
              <i class="fa fa-map-marker"></i> {{ucfirst($arr_seller_details['street_address'])}}
          </div>
          @endif

        {{--   @if(isset($arr_seller_details['phone']) && !empty($arr_seller_details['phone']))
          <div class="phone-pfl-byr">
            <i class="fa fa-phone"></i> {{$arr_seller_details['phone']}}
          </div>
          @endif --}}
          
        </div>
         @if(isset($arr_seller_details['email']) && !empty($arr_seller_details['email']))
          <div class="email-profile-byr">
            <i class="fa fa-envelope"></i> {{$arr_seller_details['email']}}
          </div>
        @endif

      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
      <div class="paymenthistory-dash ptm-hisry">
        <div class="paymenthistory-dash-header ">
          <div class="titlepay-dash">Payment History</div>
          <a href="{{ url('/') }}/seller/payment-history" class="viewall-dash-pay">View All</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="table-order">
           <div class="table-responsive">
                    <div class="rtable">
                    <div class="rtablerow none-boxshdow">
                    <div class="rtablehead"><strong>Order ID</strong></div>
                    <div class="rtablehead"><strong>Transaction ID</strong></div>
                    <div class="rtablehead"><strong>Total Price</strong></div>                    
                    <div class="rtablehead"><strong>Status</strong></div>
               
                    </div>
                     @if(isset($arr_payment_list) && count($arr_payment_list)>0)
                            @foreach($arr_payment_list as $payment_list)
                    <div class="rtablerow">
                       
                            <div class="rtablecell"><a href="{{url('/').'/seller/order/view/'.base64_encode($payment_list->id)}}"> {{$payment_list->order_no or ''}}</a></div>
                            <div class="rtablecell">{{$payment_list->transaction_id or ''}}</div>
                            <div class="rtablecell">${{ round($payment_list->total_amount,2) }}</div>
                            <!-- <div class="rtablecell"><div class="decsp-byrs">Lorem ipsum dolor sit amet consectetur adipiscing elit</div></div> -->
                            <!-- <div class="rtablecell">{{$payment_list->order_status or ''}}</div> -->
                            @if($payment_list->order_status == 0)
                                <div class="rtablecell">
                                    <div class="status-shipped">Cancelled</div>
                                </div>
                            @elseif($payment_list->order_status == 1)
                                <div class="rtablecell">
                                    <div class="status-completed">Completed</div>
                                </div>
                            @elseif($payment_list->order_status == 2)
                                <div class="rtablecell">
                                    <div class="status-dispatched">Ongoing</div>
                                </div>
                            @endif
                           
                    </div>
                    @endforeach
                    @else
                      <div class="rtablerow">No Record Found</div>
                    @endif
                    <!-- <div class="rtablerow">
                        <div class="rtablecell">O346544790</div>
                        <div class="rtablecell">11 Nov 2019</div>
                        <div class="rtablecell"><div class="decsp-byrs">Lorem ipsum dolor sit amet consectetur adipiscing elit</div></div>
                        <div class="rtablecell">$ 70.50</div>
                        <div class="rtablecell">
                          <div class="status-completed">Completed</div>
                        </div>
                    </div>
                    <div class="rtablerow">
                        <div class="rtablecell">94654790</div>
                        <div class="rtablecell">12 Nov 2019</div>
                        <div class="rtablecell"><div class="decsp-byrs">Lorem ipsum dolor sit amet consectetur adipiscing elit</div></div>
                        <div class="rtablecell">$ 20.50</div>
                        <div class="rtablecell">
                          <div class="status-completed">Completed</div>
                        </div>
                    </div> -->
                    </div>
                </div>
              </div>
        </div>
    </div>
  </div>
</div>
</div>

<script>
  function shareLink(element)
{
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $("#copy_txt").fadeIn(400);
    $("#copy_txt").fadeOut(2000);
}

</script>


@endsection