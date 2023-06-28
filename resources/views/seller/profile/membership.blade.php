@extends('seller.layout.master')
@section('main_content')
<!DOCTYPE html>
<link href="{{url('/')}}/assets/front/css/sellersignup-css.css" rel="stylesheet" type="text/css" />
 <link href="{{url('/')}}/assets/front/css/plan-css.css" rel="stylesheet" type="text/css" />
    
 <script type="text/javascript">
          var SITE_URL = '{{url('/')}}';
 </script>
<style type="text/css">
  .radio-sections.membership-radio{

  }

  .calcelled-membrship {
    font-size: 15px;
    margin-bottom: 40px;
    text-align: center;
}
.calcelled-membrship-innerr {
    font-weight: 600;
    display: inline-block;
}
.calcelled-membrship-right {
    display: inline-block;
    color: #873dc8;
}
.main-count-product{display: block;font-size: 11px;margin-bottom: 12px;}
.left-counts-plan{float: left;}
.right-counts-plan{float: right;}
    
 
  .form-section.topspaceclr{
    margin-top: 30px
  }
.radio-sections .slidecontainer {
  width: 100%;
}
.priceslider-mns-div input.parsley-success{
border: none !important;
}
.radio-sections .slider { 
  -webkit-appearance: none;
  width: 100%;
  height: 6px;
  border-radius: 5px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.radio-sections .slider:hover {
  opacity: 1;
}

.radio-sections .slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background: #ce4cf1;
  cursor: pointer;
}

.radio-sections .slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #ce4cf1;
  cursor: pointer;
}
.login-20.mainsignupnewclass.membrsp-div-class .input-group-addon{
      position: absolute;
    right: 0;
    top: 0;
    height: 43px;
    width: 39px;
    line-height: 36px;
    padding: 4px;
    vertical-align: top;
    display: block;
}
@media (max-width: 991px){
  .mainwhite-plan ul li{ font-size: 12px; margin-bottom: 2px;}
}
@media (max-width: 767px)
{
  .radio-sections .radio-btn label{min-height: 340px;}
  .innermain-my-profile{
    box-shadow: none;
    border: none;
    border-radius: 0;
  }
  .showprocessingvrly{margin-top: 0px;}
  .innermain-my-profile.membership-plan-width{padding: 0;}
  .radio-sections {
    margin: 0;
    display: block;
   }
  .login-20.mainsignupnewclass.membrsp-div-class .radio-sections .radio-btn 
  {
    width: 100%;
    max-width: 240px;
    float: none;
    display: inline-block !important; 
    margin: 0 auto 10px !important;
  }
}


.showprocessingvrly {
    max-width: 1030px;
}
.btn-info {
    color: #fff;
    background-color: #873dc8;
    border-color: #873dc8;
}
.btn-info:hover, .btn-info:focus {
    color: #fff;
    background-color: #873dc8;
    border-color: #873dc8;
}

/*.radio-sections {
    margin: 0 -0.5%;
    display: flex;
    align-items: center;
    justify-content: center;
}*/

.radio-sections {
    justify-content: center;
}
</style>
 
</head>

<body>
 
@php

 $user_subscribed = isset($user_subscribed)?$user_subscribed:'';
 $dbmembership_type ='';$dbmembership_id=''; $dbmembership_amount='';  $dbmembership_status='';
 $dbmembership_cancelstatus='';
 if(isset($get_membershipdata) && !empty($get_membershipdata))
 {

    $dbmembership_type = $get_membershipdata['membership'];
    $dbmembership_id = $get_membershipdata['membership_id'];
    $dbmembership_amount = $get_membershipdata['membership_amount'];
    $dbmembership_status = $get_membershipdata['membership_status'];
    $dbmembership_cancelstatus = $get_membershipdata['is_cancel'];

 }


$loginuserid ='';

if(isset($user_details_arr) && !empty($user_details_arr))
{
  $loginuserid = $user_details_arr['id'];
}

// if(isset($site_setting_arr) && count($site_setting_arr)>0)
// {
//      $payment_mode = $site_setting_arr['payment_mode'];
//      $sandbox_js_url = $site_setting_arr['sandbox_js_url'];
//      $live_js_url = $site_setting_arr['live_js_url'];

//      $sandbox_application_id = $site_setting_arr['sandbox_application_id'];
//      $live_application_id = $site_setting_arr['live_application_id'];
// }
@endphp

{{-- <script type="text/javascript"
 @if($payment_mode=='0' && isset($sandbox_js_url)) src="{{ $sandbox_js_url }}" 
 @elseif($payment_mode=='1' && isset($live_js_url)) src="{{ $live_js_url }}" @endif>
  
</script>
 --}}
 @php

    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }

    $publik_key ='';
    if(isset($site_setting_arr) && count($site_setting_arr)>0)
    {
         $payment_mode = $site_setting_arr['payment_mode'];

         if($payment_mode=='0' && isset($site_setting_arr['sandbox_stripe_public_key']))
         {
            $publik_key = $site_setting_arr['sandbox_stripe_public_key'];

         }
         elseif($payment_mode=='1' && isset($site_setting_arr['live_stripe_public_key']))
         {
             $publik_key = $site_setting_arr['live_stripe_public_key'];
         }
    }

   // $publik_key = config('app.project.stripe_publish_key');

@endphp   


{{-- 
<input type="hidden" id="appId" 
@if($payment_mode=='0' && isset($sandbox_application_id))
value="{{ $sandbox_application_id }}"
@elseif($payment_mode=='1' && isset($live_application_id))
value="{{ $live_application_id }}" @endif> --}}

<div class="my-profile-pgnm">
Membership Plan

  <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Membership Plan</li>
  </ul>
</div>


<div class="new-wrapper main-my-profile">
<div class="innermain-my-profile membership-plan-width">
<div class="login-20 mainsignupnewclass membrsp-div-class">
        <div class="">
          <div class="col-md-12">

            {{--  <a href="{{ url('/')}}/seller/updatecard" id="updatecard" class="pull-right btn btn-info">Update Card</a> --}}
              
              <div class="calcelled-membrship none-margin-bottom">
               {{--  @if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata['get_membership_details'])) --}}

               @if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata['get_membership_details']) && empty($get_membershipdata))
                
                  <div class="calcelled-membrship-innerr">Cancelled membership : </div>
                  <div class="calcelled-membrship-right">{{ isset($get_cancelmembershipdata['get_membership_details']['name'])?$get_cancelmembershipdata['get_membership_details']['name']:'' }}</div>
                  <br>

               {{--    @if($get_cancelmembershipdata['is_cancel']=='1' && isset($get_cancelmembershipdata['current_period_enddate']) && $get_cancelmembershipdata['membership']=="2")
                   <div class="calcelled-membrship-innerr"> Cancelled membership end date : </div>
                   <div class="calcelled-membrship-right">{{ isset(
                     $get_cancelmembershipdata['current_period_enddate'])?
                     date("Y-m-d H:i A",strtotime($get_cancelmembershipdata['current_period_enddate'])):'' }}</div>
                  @endif --}}

                @endif
                <div class="clearfix"></div>
              </div>
          </div>



          @if($user_subscribed=='1' && isset($get_membershipdata) && !empty($get_membershipdata))
          <a href="javascript:void(0)" id="cancel_subscription" class="pull-right btn btn-info cancel-subcrb">Cancel Subscription</a>
         
         <!----else condition added for free mem thenc cancel it----->
          @elseif(isset($get_membershipdata) && !empty($get_membershipdata) && $get_membershipdata['membership']=='1')     
          <a href="javascript:void(0)" id="cancel_subscription" class="pull-right btn btn-info cancel-subcrb">Cancel Subscription</a>
          @endif

        <div class="hidden-overflow">

            <form id="nonce-form">
                {{ csrf_field() }}
                <input type="hidden" name="loginuserid" id="loginuserid" value="{{ $loginuserid }}">
                <input type="hidden" name="dbmembership_type" id="dbmembership_type" value="{{ $dbmembership_type }}">
                <input type="hidden" name="dbmembership_id" id="dbmembership_id" value="{{ $dbmembership_id }}">
                <input type="hidden" name="dbmembership_status" id="dbmembership_status" value="{{ $dbmembership_status }}">
                <input type="hidden" name="dbmembership_cancelstatus" id="dbmembership_cancelstatus" value="{{ $dbmembership_cancelstatus }}">
                

             <div class="col-xl-6 col-lg-6 col-md-6  bg-color-10">

                <div id="status_msg"></div>
                <div id="error_message"></div>
        

                <!-- step 3 Start -->
                <div class="sub-plan-section seller-signup-phase3"  id="step3">
                     
                     @if(isset($get_membershipdata) && (!empty($get_membershipdata)) 
                     && $get_membershipdata['membership']=='2' && $user_subscribed=='1') 
                      <div class="title-p-details select-sub-pln">
                        Your Membership Plan
                      </div>
                      @else
                      <div class="title-p-details select-sub-pln">
                          Select Membership Plan
                      </div>
                      @endif


                       <div class="radio-sections membership-radio">
                      
                          @if(isset($arr_membership) && !empty($arr_membership))  
                             @php
                              $i=0; 
                              $box_color = '';
                             @endphp
                              @foreach($arr_membership as $membership)

                                @php 

                                    if($i==0)
                                        $box_color ='free-bg-color';
                                    elseif($i==1)
                                        $box_color ='essentials-bg-color';
                                    elseif($i==2)
                                        $box_color ='pro-bg-color';

                                      $membership_id = $membership['id'];

                                @endphp

                                <script type="text/javascript">
                                    $(document).ready(function(){

                                        var mem_id = {{ $membership['id'] }};
                                        
                                        var slider = $("#myRange_"+mem_id).val();
                                        var output = $("#demo_"+mem_id).val();
                                        output = slider;
                                         $("#myRange_"+mem_id).change(function(){
                                            
                                           $("#demo_"+mem_id).html(this.value);
                                        });
                                     });
                                    
                                 </script>
                                
                                 @php 
                                    $m_price = $membership['price'];
                                    if(isset($dbmembership_amount) && $dbmembership_amount>0)
                                    {
                                      // mprice not o cond added if free box then it shows
                                       if($m_price<$dbmembership_amount && $m_price!="0")
                                       // $style ="display:none";
                                        $style ="display:block"; //26june20
                                        else
                                        $style="display:block";    
                                    }
                                    else
                                    {
                                        $style="display:block"; 
                                    }
                                 @endphp


                                 <div class="radio-btn" style="{{ $style  }}">
                                     <input type="radio" id="membership_{{ $membership['id'] }}" name="membership" amt="{{ $membership['price'] }}" 
                                    membership_type="{{ $membership['membership_type'] }}" stripe_plan_id="{{ $membership['plan_id'] }}" class="membership"  value="{{ $membership['id'] }}"   
                                    @if(isset($dbmembership_id) && ($dbmembership_id==$membership_id))
                                       checked 
                                    @else   
                                      @if($i==0)
                                       checked 
                                      @endif 
                                    @endif/>
                                    <label for="membership_{{ $membership['id'] }}">
                                       <div class="form-plan-main-list">
                                        <div class="header-membr" style="background-image: url({{ url('/')  }}/uploads/membership/{{ $membership['image']  }});">
                                            <div class="productnms-plan">{{ $membership['product_count'] }} Products</div>

                                              <div class="product-month-plan">
                                                  @if($membership['membership_type']=='2')
                                                  ${{ $membership['price'] }}/month
                                                  @else
                                                  {{ 'Free' }}
                                                  @endif
                                              </div> 

                                            <div class="product-no-fee">No listing fees</div>
                                            <div class="button-signupnow">
                                                {{-- <a href="javascript:void(0)" class="signupnow">Sign up now</a> --}}
                                            </div>
                                        </div>
                                        <div class="mainwhite-plan">
                                            <div class="title-features">{{ $membership['name'] }}</div>
                                                @php 
                                                  echo $membership['description']
                                                @endphp
                                        </div>
                                    </div>
                                    </label>
                                    <div class="check"></div>
                                </div>


                                @php 

                                $i++;

                                @endphp
                             @endforeach                        
                            @endif 

                         <div class="clearfix"></div>
                     </div><!--end of radio section-->


                      @if(isset($arr_membership) && !empty($arr_membership))
                        @php 
                             
                        $default_amount = isset($arr_membership[0]['price'])?$arr_membership[0]['price']:''; 
                        $default_subscription = isset($arr_membership[0]['id'])?$arr_membership[0]['id']:'';  
                        $default_memtype = isset($arr_membership[0]['membership_type'])?$arr_membership[0]['membership_type']:'';  

                        
                         $defstripe_plan_id = isset($arr_membership[0]['plan_id'])?$arr_membership[0]['plan_id']:''
                        @endphp
                      @endif


                      <input type="hidden" id="amount" name="amount" value="{{ $default_amount }}">
                      <input type="hidden" id="subscription" name="subscription" value="{{ $default_subscription }}">
                      <input type="hidden" id="membership_type" name="membership_type" value="{{  $default_memtype }}">

                        <input type="hidden" id="stripe_plan_id" name="stripe_plan_id" value="{{  $defstripe_plan_id }}">

 
                      <!-------start of payment detail form---------------->
                      {{--  <div class="form-section paymentdetails-frms" id="paydetailform" style="display:none"> --}}

                        <div class="clearfix"></div>


                      <div class="form-section paymentdetails-frms" id="paydetailform"  @if($default_memtype==2 && empty($get_membershipdata) && $user_subscribed!='1')  style="display:block" @else style="display:none" @endif>   



                               <div class="login-inner-form">
                                <div class="title-p-details select-sub-pln">Payment Details</div>
                                   <div class="row">
                                       <div class="card-errors"></div>

  
                                     <div class="col-md-6">
                                        <div class="form-group form-box">
                                             <input type="text" class="form-control stripeclass" id="name" name="name" autofocus="" placeholder="Card holder’s name"   data-parsley-required-message="Please enter card holder name"
                                           />
                                              <span id='cardName_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div> 

                     

                                    <div class="col-md-6">
                                        <div class="form-group form-box">
                                            <input type="password" name="card_number" id="card_number" placeholder="1234 1234 1234 1234"  class="form-control input-text stripeclass"maxlength="16" autocomplete="off" data-parsley-required-message="Please enter card number" >
                                            <div class="eye-btn-ps">
                                            <span toggle="#card_number" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                            <span id='cardNumber_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group form-box">
                                            <input type="text" name="card_exp_month" id="card_exp_month" placeholder="MM" maxlength="2"  class="form-control stripeclass" data-parsley-required-message="Please enter card expiry month" >                                           
                                             <span id='card_exp_month_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>


                                     <div class="col-md-3">
                                        <div class="form-group form-box">
                                            <input type="text" name="card_exp_year" id="card_exp_year" placeholder="YYYY" maxlength="4"  class="form-control stripeclass" data-parsley-required-message="Please enter year" >                                           
                                             <span id='card_exp_year_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>


                                    {{--  <div class="col-md-6">
                                        <div class="form-group form-box">
                                            <input type="text" id="sq-postal-code" class="form-control input-text" name="CVV" placeholder="Postal" />
                                             <span id='postal_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div> --}} 

                                    <div class="col-md-6">
                                        <div class="form-group form-box">
                                            <input type="password" name="card_cvc" id="card_cvc" placeholder="CVC" maxlength="3" class="form-control input-text stripeclass" autocomplete="off" data-parsley-required-message="Please enter cvv" >
                                            <div class="eye-btn-ps">
                                            <span toggle="#card_cvc" class="fa fa-fw fa-eye field-icon toggle-cvc"></span>
                                            </div>
                                           <span id='card_cvc_error'></span>       
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                 
                                <input type="hidden" id="card-nonce" name="nonce">


                                 <!----------start of -button div------------------------>
                                <div class="buttonsection-bottom">                                   
                                    <a href="javascript:void(0)" class="btn-md btn-theme next-right"  id="payBtn" onclick="onGetCardNonce(event)">Submit</a>
                                    <div class="clearfix"></div>
                                </div>
                                 <!-----------end of button div------------------------>


                            </div>
                       </div>
                    <!---end of payment detail form------->


                    <!----------start of upgradebtn -button div------------------------>
                      @if(isset($dbmembership_type) && ($dbmembership_type=='2') && $user_subscribed=='1')
                        <div class="form-section topspaceclr" style="display: none" id="upgradebtndiv">
                        <div class="login-inner-form">
                           <div class="buttonsection-bottom" id="upgradebtnsection">
                                <a href="#" class="btn-md btn-theme next-right"  id="upgradebtn">Switch</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        </div>
                      @endif  
                      <!-----------end of upgradebtn button div------------------------>


                     <!----------start of -button div------------------------>
                     {{--   @if(isset($dbmembership_type) && ($dbmembership_type=='1')) --}}
                        @if(isset($dbmembership_type) && ($dbmembership_type=='1'))
                        <div class="form-section topspaceclr" style="display: none" >
                        <div class="login-inner-form">
                           <div class="buttonsection-bottom" id="buttonsection">
                                <a href="#" class="btn-md btn-theme"  id="btn-sign-up">Submit</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        </div>
                        <!--below-already--user subscribed --and want to select free membership-23-june-20--->
                      @elseif(isset($dbmembership_type) && ($dbmembership_type=='2') && $user_subscribed=="1")
                        <div class="form-section topspaceclr" style="display: block" >
                        <div class="login-inner-form">
                           <div class="buttonsection-bottom" id="buttonsection">
                                <a href="#" class="btn-md btn-theme next-right"  id="btn-sign-up">Switch</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        </div>   
                  <!--else condition added for if cancel membership then he can select free membership-->
                        @elseif(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata) && empty($get_membershipdata))
                           
                           <!--if seller cancel memebship and free memebrship inactive from admin side then double submit button shown-------------------->
                            @if(isset($default_memtype) && $default_memtype==2)
                            @else
                            <div class="form-section topspaceclr" style="display: block" >
                            <div class="login-inner-form">
                               <div class="buttonsection-bottom" id="buttonsection">
                                    <a href="#" class="btn-md btn-theme next-right"  id="btn-sign-up">Submit</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            </div>                            
                            @endif


                      @endif  
                      <!-----------end of button div------------------------>
                  </div>
                <!-- step 3 End -->
            </div>
        </div>
        </div>

</div>
</div>
 <!---------------------show membership detail---------------------------->
 @php

  @endphp
        @if(isset($get_membershipdata) && (!empty($get_membershipdata)) && $get_membershipdata['membership']=='2' && $user_subscribed=='1')
                  <div class="showprocessingvrly" id="Showmemershipdetailsection">
                    <div >
                  
                     

                        @if($get_membershipdata['membership']=='2')
                            {{-- <div class="myprofile-main">
                               <div class="myprofile-lefts">Transaction Id</div>
                               <div class="myprofile-right">
                                  @if(isset($get_membershipdata['transaction_id']))
                                      {{ $get_membershipdata['transaction_id'] }}
                                  @else
                                   NA
                                  @endif
                               </div>
                               <div class="clearfix"></div>
                           </div> --}}
                       @endif


                         @if($get_membershipdata['membership']=='2')
                          <div class="myprofile-main">
                             <div class="myprofile-lefts">Amount($)</div>
                             <div class="myprofile-right">
                                @if(isset($get_membershipdata['membership_amount'])  && !empty($get_membershipdata['membership_amount']))
                                    @php
                                     echo '$'.number_format($get_membershipdata['membership_amount']);
                                    @endphp
                                @else
                                 NA
                                @endif
                             </div>
                             <div class="clearfix"></div>
                         </div>
                        @endif

                        @if($get_membershipdata['membership']=='2')
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Date</div>
                           <div class="myprofile-right">
                            @if(isset($get_membershipdata['created_at'])  && !empty($get_membershipdata['created_at']))

                                  {{ date("M d Y H:i A",strtotime($get_membershipdata['created_at'])) }}

                                  
                           @else
                               NA
                           @endif
                           </div>
                           <div class="clearfix"></div>
                       </div>
                       @endif

                      {{--  @if($get_membershipdata['membership']=='2')
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Payment Status</div>
                           <div class="myprofile-right">
                                  @php
                                     $paystatus ='';
                                      if($get_membershipdata['payment_status']=='1')
                                     {
                                        $paystatus = '<span class="status-completed">Completed</span>';
                                     }      
                                     else if($get_membershipdata['payment_status']=='0')
                                     {
                                       $paystatus = '<span class="status-dispatched">Ongoing</span>';
                                     }    
                                     else if($get_membershipdata['payment_status']=='2')
                                     {
                                      $paystatus = '<span class="status-shipped">Failed</span>';
                                     }
                                     echo $paystatus;
                                  @endphp
                                                          
                           
                           </div>
                           <div class="clearfix"></div>
                       </div>
                      @endif  --}}

                    

                    </div>
                  </div>

              @endif     
          <!-------------end of memberhip detail----------------------------->
</div>
 </form>

<script src="https://js.stripe.com/v2/"></script>

<script>
    
 $('input[name=membership]').change(function(){

    var dbmembership_id = "{{ $dbmembership_id }}"
    var dbmembership_type = " {{$dbmembership_type}}"
    var user_subscribed="{{ $user_subscribed }}"
    var dbmembership_cancelstatus = "{{ $dbmembership_cancelstatus }}"
    var dbmembership_status = "{{ $dbmembership_status }}"


    var membership = $( 'input[name=membership]:checked' ).val();
    $("#subscription").val(membership);

    var amt = $(this).attr('amt');
    $("#amount").val(amt);

    var membership_type = $(this).attr('membership_type'); 
    $("#membership_type").val(membership_type);

     var stripe_plan_id = $(this).attr('stripe_plan_id');
    $("#stripe_plan_id").val(stripe_plan_id);

    if(membership_type==1)
    {
        // new condition added on 25 june 20 for if user has paid then show free submit button
        if(user_subscribed=="1" && dbmembership_status==1 && dbmembership_cancelstatus==0)
        {
            $("#btn-sign-up").show();
            $("#paydetailform").hide();
            $("#buttonsection").show();
            $("#upgradebtn").hide();           
            $("#upgradebtndiv").hide();
        }
        else
        {
            $("#paydetailform").hide();
            $("#buttonsection").show();
            $("#upgradebtn").hide();           
            $("#upgradebtndiv").hide();
        }
          
          //commneted on 25 june 20
         /* $("#paydetailform").hide();
          $("#buttonsection").show();
          $("#upgradebtn").hide();           
          $("#upgradebtndiv").hide();*/

    }
    else
    {

      if((dbmembership_id==membership)) // idb and selected box same then show memebrship details below
      {
        $("#paydetailform").hide();
        $("#Showmemershipdetailsection").show();
        $("#upgradebtndiv").hide();

      }else{

          if(user_subscribed=='1'){ 
            $("#Showmemershipdetailsection").hide();
             $("#upgradebtn").show();
             $("#upgradebtndiv").show();

              
          }
          else{

            //if free membership then hide other paid form submit btn without cancelled mem cant see other forms submit button
            //commneted at 25 june 20
          /*  if(dbmembership_type==1 && dbmembership_status==1 && dbmembership_cancelstatus==0)
            {
               $("#paydetailform").hide();
               $("#Showmemershipdetailsection").hide();
               $("#upgradebtn").hide();

            }else{
               $("#paydetailform").show();
               $("#Showmemershipdetailsection").hide();
               $("#upgradebtn").hide();
            }*/

                //commneted at 22 june 20
                $("#paydetailform").show();
                $("#Showmemershipdetailsection").hide();
                $("#upgradebtn").hide();

          }//else
      }
     // $("#paydetailform").show();
      $("#buttonsection").hide();
    }
     
 }); 

</script>


<!-- parsley validationjs-->
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert.js"></script>

<!-- data table js-->
<script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>
    
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/bootstrap.min.js"></script>

 <!--
<script type="text/javascript">
  
  var applicationId = $('#appId').val();
  // Create and initialize a payment form object
  const paymentForm = new SqPaymentForm({
  postalCode: false,

    // Initialize the payment form elements
    
    //TODO: Replace with your sandbox application ID
    applicationId: applicationId,
    inputClass: 'sq-input',
    autoBuild: false,
    // Customize the CSS for SqPaymentForm iframe elements
    inputStyles: [{
        fontSize: '16px',
        lineHeight: '24px',
        padding: '0px',
        placeholderColor: '#a0a0a0',
        backgroundColor: 'transparent',
    }],
    // Initialize the credit card placeholders
    
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
     // postalCode: {
     //       elementId: 'sq-postal-code',
     //       placeholder: 'Postal'
     //   },
    // SqPaymentForm callback functions
    callbacks: {
        /*
        * callback function: cardNonceResponseReceived
        * Triggered when: SqPaymentForm completes a card nonce request
        */
        cardNonceResponseReceived: function (errors, nonce, cardData) {
         
          if (errors) {
              errors.forEach(function (error) {
                  swal('Oops..!',error.message,'error');
              });
              return;
          }
      
           // Assign the nonce value to the hidden form field
            document.getElementById('card-nonce').value = nonce;

            if($('#nonce-form').parsley().validate()==false) return;
   
           $.ajax({
            url:SITE_URL+'/seller/membership_selection',
            data:new FormData($('#nonce-form')[0]),
            processData: false,
            method:'POST',
            contentType: false,
            dataType:'json',
            beforeSend : function() 
            {
              showProcessingOverlay();
              $('#btn-sign-up').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
              console.log(response);
              hideProcessingOverlay();
           

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                    $("#nonce-form")[0].reset();
                    $('#btn-sign-up').html('Submit');
                    swal('Success!', response.msg, 'success');
                    setTimeout(function(){
                       window.location.href=SITE_URL+'/seller/membership_detail';

                    },2000);
                    
                }
                else if(response.status=="ERROR")
                {
                    if(response.msg!=""){
                        $('#error_message').css('color','red').html(response.msg);
                    }else{
                        $('#error_message').html('');
                    }
                
                }
               
                
              }// if type object
            }//success
          });
        }
    } 
});

//paymentForm.build();
</script>
-->

<script>
function onGetCardNonce(event) 
{
   var subscription = $("#subscription").val();
   
   var name = $("#name").val();
   var card_number = $("#card_number").val();
   var card_exp_month = $("#card_exp_month").val();
   var card_exp_year = $("#card_exp_year").val();
   var card_cvc = $("#card_cvc").val();



   if(subscription=="")
   {
      swal('Warning!', 'Please select membership plan', 'warning');
   }else{

      
       $(".stripeclass").attr("data-parsley-required","true");
       if($('#nonce-form').parsley().validate()==false) return;

      // swal({
      //     title: 'Do you really want to purchase this membership plan?',
      //     type: "warning",
      //     showCancelButton: true,
      //   //   confirmButtonColor: "#DD6B55",
      //     confirmButtonColor: "#8d62d5",
      //     confirmButtonText: "Yes, do it!",
      //     closeOnConfirm: false
      //   },
      //   function(isConfirm,tmp)
      //   {
      //     if(isConfirm==true)
      //     { 

               event.preventDefault();

                 $('#payBtn').attr("disabled", "disabled");
        
                // Create single-use token to charge the user
                Stripe.createToken({
                    number: $('#card_number').val(),
                    exp_month: $('#card_exp_month').val(),
                    exp_year: $('#card_exp_year').val(),
                    cvc: $('#card_cvc').val()
                }, stripeResponseHandler);
                
                // Submit from callback
                return false;





               // Don't submit the form until SqPaymentForm returns with a nonce
              // event.preventDefault();
               // Request a nonce from the SqPaymentForm object
              // paymentForm.requestCardNonce();
       //   } 
       //    else{
              
       //    }
       // })
   }
}  //end of function 
 


   $('#btn-sign-up').click(function(){

    swal({
          title: 'Confirm purchase?',
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
              $("#card_exp_month").removeAttr("data-parsley-required");
              $("#card_exp_year").removeAttr("data-parsley-required");
              $("#card_cvc").removeAttr("data-parsley-required");
              $("#name").removeAttr("data-parsley-required");
              $("#card_number").removeAttr("data-parsley-required");

               if($('#nonce-form').parsley().validate()==false) return;
        
               var form_data = $('#nonce-form').serialize();      

                  if($('#nonce-form').parsley().isValid() == true )
                  {
                    $.ajax({
                      url:SITE_URL+'/seller/membership_selection',
                      data:form_data,
                      method:'POST',
                      
                      beforeSend : function()
                      {
                        showProcessingOverlay();
                        $('#btn-sign-up').prop('disabled',true);
                        $('#btn-sign-up').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                      },
                      success:function(response)
                      {
                       
                      //  console.log(response);
                        hideProcessingOverlay();

                        if(typeof response =='object')
                        {
                          if(response.status && response.status=="SUCCESS")
                          {
                              $("#nonce-form")[0].reset();
                               $('#btn-sign-up').html('Submit');
                              swal('Success!', response.msg, 'success');
                              setTimeout(function(){
                                  window.location.href=SITE_URL+'/seller/membership_detail';
                              },1000);
                              
                          }
                          else if(response.status=="ERROR"){
                              if(response.msg!=""){
                                  $('#error_message').css('color','red').html(response.msg);
                              }else{
                                  $('#error_message').html('');
                              }

                             
                          }
                        }// if type object
                      }//success
                    });
                  }//if validated

          } 
          else{
             return false; 
          }
       })


  });


</script>

<script>
  var publickey = "{{ $publik_key }}";
 // console.log(publickey);
// Set your publishable key
Stripe.setPublishableKey(publickey);


// Callback to handle the response from stripe
function stripeResponseHandler(status, response) { 

    if (response.error) {
        // Enable the submit button
        $('#payBtn').removeAttr("disabled");

        // Display the errors on the form

        $(".card-errors").html('<p>'+response.error.message+'</p>');

    } else {
        var form$ = $("#nonce-form");
        // Get token id
        var token = response.id;
        // Insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // Submit form to the server
        //form$.get(0).submit();

        if(token && $("#card_number").val()!='' && $("#card_exp_month").val()!='' && $("#card_exp_year").val()!='' && $("#card_cvc").val()!='')
        {
          $(".card-errors").html('');

          swal({
          title: 'Confirm purchase?',
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




                   if($('#nonce-form').parsley().validate()==false) return;
           
                   $.ajax({
                    url:SITE_URL+'/seller/membership_selection',
                    data:new FormData($('#nonce-form')[0]),
                    processData: false,
                    method:'POST',
                    contentType: false,
                    dataType:'json',
                    beforeSend : function() 
                    {
                      showProcessingOverlay();
                      $('#btn-sign-up').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                    },
                    success:function(response)
                    {
                     // console.log(response);
                      hideProcessingOverlay();
                   

                      if(typeof response =='object')
                      {
                        if(response.status && response.status=="SUCCESS")
                        {
                            $("#nonce-form")[0].reset();
                            $('#btn-sign-up').html('Submit');
                            swal('Success!', response.msg, 'success');
                            setTimeout(function(){
                               window.location.href=SITE_URL+'/seller/membership_detail';

                            },1000);
                            
                        }
                        else if(response.status=="ERROR")
                        {
                          //  swal.close() 
                            if(response.msg!=""){
                                $('#error_message').css('color','red').html(response.msg);
                            }else{
                                $('#error_message').html('');
                            }

                            if(response.cardmsg!=""){
                                // $('.card-errors').css('color','red').html('Please contact to your bank');
                                 //swal("Error", "Please contact to your bank", "error");

                                 swal({
                                  title: 'Error',
                                  text: 'Something went wrong, please contact to your bank',
                                  type: 'error',
                                  showCancelButton: false,
                                  showConfirmButton:false,
                                  closeOnConfirm: false,
                                  closeOnCancel: false
                                });

                                 setTimeout(function(){
                                   window.location.reload();
                                 },8000);


                            }else{
                                $('.card-errors').html('');
                            }  
                        
                        }//else if error
                       
                        
                      }// if type object
                    }//success
                  });





            } //confirmbox             
           })//if confirm box        
        }//if token
    }//end of else
}//end of stripe token handler




   $('#upgradebtn').click(function(){

    swal({
          title: 'Confirm purchase?',
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

              // if($('#nonce-form').parsley().validate()==false) return;
        
               var form_data = $('#nonce-form').serialize();      

                 // if($('#nonce-form').parsley().isValid() == true )
                 // {
                    $.ajax({
                      url:SITE_URL+'/seller/membership_selection',
                      data:form_data,
                      method:'POST',
                      
                      beforeSend : function()
                      {
                        showProcessingOverlay();
                        $('#upgradebtn').prop('disabled',true);
                        $('#upgradebtn').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                      },
                      success:function(response)
                      {
                       
                       // console.log(response);
                        hideProcessingOverlay();

                        if(typeof response =='object')
                        {
                          if(response.status && response.status=="SUCCESS")
                          {
                              $("#nonce-form")[0].reset();
                               $('#upgradebtn').html('Submit');
                              swal('Success!', response.msg, 'success');
                              setTimeout(function(){
                                  window.location.href=SITE_URL+'/seller/membership_detail';
                              },1000);
                              
                          }
                          else if(response.status=="ERROR"){
                              if(response.msg!=""){
                                  $('#error_message').css('color','red').html(response.msg);
                              }else{
                                  $('#error_message').html('');
                              }

                             
                          }
                        }// if type object
                      }//success
                    });
                  //}//if validated

          } 
          else{
              
          }
       })


  }); //end of upgradebtn function


   var loginuserid = "{{ $loginuserid }}";

  /* $('#cancel_subscription').click(function(){

    swal({
          title: 'This may affect the number of products in your store. <br/> Confirm cancel?',
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
                   $.ajax({
                      url:SITE_URL+'/seller/membership_cancel',
                      data:{userid:loginuserid},
                      method:'GET',
                      
                      beforeSend : function()
                      {
                        showProcessingOverlay();
                        $('#cancel_subscription').prop('disabled',true);
                        $('#cancel_subscription').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                      },
                      success:function(response)
                      {
                       
                        console.log(response);
                        hideProcessingOverlay();

                        if(typeof response =='object')
                        {
                          if(response.status && response.status=="SUCCESS")
                          {
                              $("#nonce-form")[0].reset();
                               $('#cancel_subscription').hide();
                              swal('Success!', response.msg, 'success');
                              setTimeout(function(){
                                  window.location.href=SITE_URL+'/seller/membership_detail';
                              },1000);
                              
                          }
                          else if(response.status=="ERROR"){
                              if(response.msg!=""){
                                  $('#error_message').css('color','red').html(response.msg);
                              }else{
                                  $('#error_message').html('');
                              }

                             
                          }
                        }// if type object
                      }//success
                    });//ajax


          }//if confirm 
          else{
             return false; 
          }
       })


  }); //end of cancel subscription
*/
</script>

<script type="text/javascript">
  $(document).ready(function(){
    var dbmembership_id = $("#dbmembership_id").val();
    var membership = $( 'input[name=membership]:checked' ).val();
    if(dbmembership_id==membership)
    {
      $("#btn-sign-up").hide();
    }

  });
</script>


<script>
    
$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

$(".toggle-cvc").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>



<!--------------------start of modal-------------------------------------->
<div class="modal fade" id="cancel_membership_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="model_membership_id" id="model_membership_id" value="">
    <div class="modal-content">
      <div class="modal-header mdl-boder-btm">
        <h3 class="modal-title" id="exampleModalLabel" align="center">Cancel Membership</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cancel_order_modal_body">
        <div class="mainbody-mdls">        
        
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"> <b>Cancellation Reason :</b></div>
             <div class="mainbody-mdls-fd-right">
               <textarea id="model_membership_cancel_reason" rows="5" class="form-control" placeholder="Please enter your membership cancellation reason..." maxlength="300"></textarea>

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
          <a  class="butn-def" id="cancel_order_model_btn" onclick="cancelMembership($(this));">Confirm Cancellation</a>

        </div>
      </div>
    </div>
  </div>
</div>
<!-----------------end of modal---------------------->
<script>

$(document).on('click','#cancel_subscription',function(){
  $("#cancel_membership_modal").modal('show'); 
});

function cancelMembership(ref)
{
  if($('#model_membership_cancel_reason').val()=='')
  {
    $('<span>Please enter the cancellation reason.. </span>').css('color','red').insertAfter('#model_membership_cancel_reason').fadeOut(5000);
    return false;
  }

     swal({
          title: 'This may affect the number of products in your store. <br/> Confirm cancel?',
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
               var loginuserid = "{{ $loginuserid }}";
               var cancel_reason =  $('#model_membership_cancel_reason').val();
             
                   $.ajax({
                      url:SITE_URL+'/seller/membership_cancel',
                      data:{userid:loginuserid,cancel_reason:cancel_reason},
                      method:'GET',
                      
                      beforeSend : function()
                      {
                        showProcessingOverlay();
                        $('#cancel_subscription').prop('disabled',true);
                        $('#cancel_subscription').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                      },
                      success:function(response)
                      {
                       
                       // console.log(response);
                        hideProcessingOverlay();

                        if(typeof response =='object')
                        {
                          if(response.status && response.status=="SUCCESS")
                          {
                              $("#nonce-form")[0].reset();
                               $('#cancel_subscription').hide();
                              swal('Success!', response.msg, 'success');
                              setTimeout(function(){
                                  window.location.href=SITE_URL+'/seller/membership_detail';
                              },1000);
                              
                          }
                          else if(response.status=="ERROR"){
                              if(response.msg!=""){
                                  $('#error_message').css('color','red').html(response.msg);
                              }else{
                                  $('#error_message').html('');
                              }

                             
                          }
                        }// if type object
                      }//success
                    });//ajax


          }//if confirm 
          else{
             return false; 
          }
       });


}//end cancel membership function

</script>




</body>

</html>


@endsection                  