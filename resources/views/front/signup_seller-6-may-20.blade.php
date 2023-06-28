<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  {{--   <meta name="description" content="{{ isset($site_setting_arr['meta_desc'])?$site_setting_arr['meta_desc']:'' }}" /> --}}
    <meta name="title" content="Sell on Chow">
    <meta name="description" content="Launch your online CBD dispensary or store in seconds. Get all the help you need for your online business. White labelling service, age-verification, and payment processing." />

    <meta name="keywords" content="{{ isset($site_setting_arr['meta_keyword'])?$site_setting_arr['meta_keyword']:'' }}" />
    <meta name="author" content="" />
{{--     <title>{{isset($page_title)?$page_title:""}} : {{ config('app.project.name') }}</title>
 --}}
    <title>Sell on Chow</title> 
    <meta name="csrf-token" content="{{ csrf_token() }}">

 

    <!-- ======================================================================== -->


      <!--  Apple -->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="{{url('/')}}/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{url('/')}}/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{url('/')}}/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('/')}}/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{url('/')}}/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('/')}}/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('/')}}/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('/')}}/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/')}}/assets/favicon/apple-icon-180x180.png">

 
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Chow420">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">

    <link rel="mask-icon" href="{{url('/')}}/assets/favicon/safari-pinned-tab.svg" color="#873dc8">

    <link href="{{url('/')}}/assets/splash/apple/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <!--  Generic -->
    <link rel="icon" type="image/png" sizes="192x192"  href="{{url('/')}}/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/')}}/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{url('/')}}/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/favicon/favicon-16x16.png">
        <!--  MS -->
    <meta name="msapplication-TileImage" content="{{url('/')}}/assets/favicon/ms-icon-144x144.png"> 


    <link href="{{url('/')}}/assets/front/css/range-slider.css" rel="stylesheet" type="text/css" />
        <!-- parsley validation css -->
    <link href="{{url('/')}}/assets/common/Parsley/dist/parsley.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/common/sweetalert/sweetalert.css" rel="stylesheet">
     <link href="{{url('/')}}/assets/front/css/plan-css.css" rel="stylesheet" type="text/css" />



    <!-- Bootstrap CSS -->
    <link href="{{url('/')}}/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--Custom Css-->
    <link href="{{url('/')}}/assets/front/css/sellersignup-css.css" rel="stylesheet" type="text/css" />
    <!--Main JS-->
    <script type="text/javascript" src="{{url('/')}}/assets/front/js/jquery-1.11.3.min.js"></script>

     <!-- loader js -->
    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>
    <script type="text/javascript">
          var SITE_URL = '{{url('/')}}';
    </script>
<style type="text/css">
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

input[type=radio] {
    margin-right: 3px;
     visibility: visible;
}
</style>

</head>

<body>

@php
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
  
</script> --}}

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



{{-- <input type="hidden" id="appId" 
@if($payment_mode=='0' && isset($sandbox_application_id))
value="{{ $sandbox_application_id }}"
@elseif($payment_mode=='1' && isset($live_application_id))
value="{{ $live_application_id }}" @endif> --}}


<div class="login-20 mainsignupnewclass">
    <div class="container">
        <div class="row">
        <div class="hidden-overflow" id="sethiddenoverflowclass">

            <form id="nonce-form" >
                {{ csrf_field() }}
                <input type="hidden" name="role" id="role" value="seller">

           

              <div class="col-xl-6 col-lg-6 col-md-6 bg-img" style="background: rgba(0, 0, 0, 0.04) url(images/seller-page-singup.jpg) top left repeat;" id="chw-logo">
                <div class="info">
                    <div class="logo-seller-lgns">
                        <a href="{{ url('/') }}"><img src="{{ url('/') }}/assets/front/images/chowlogos-white.png" alt="" /></a>
                    </div>
                     <div class="sell-chow-signup">Grow your CBD business seamlessly</div>
                     <ul class="list-sellersignupleft">
                         <li><img src="{{ url('/') }}/assets/front/images/check-sellers-icn-whites.png" alt="" /> Experience Frictionless payments and never worry about getting shutdown</li>
                         <li><img src="{{ url('/') }}/assets/front/images/check-sellers-icn-whites.png" alt="" /> Age-verify your customers and stay compliant with  federal and state regulations</li>
                         <li><img src="{{ url('/') }}/assets/front/images/check-sellers-icn-whites.png" alt="" /> Command traffic to your store. Let us do the marketing for you!</li>
                         <li><img src="{{ url('/') }}/assets/front/images/check-sellers-icn-whites.png" alt="" /> Operate and own a Chow automated dispensary </li>
                     </ul>
                    
                </div>
            </div>



            <div class="col-xl-6 col-lg-6 col-md-6  bg-color-10">

                <div id="status_msg"></div>
                
                <!-- step 1 Start -->
                <div class="form-section seller-signup-phase1" style="display: block;" id="step1">
                    <div class="buying-process-main">
                        <div class="cart-section-block">
                            <div class="cart-step-one">
                                <div class="step-one step-active">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 1</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="cart-step-one">
                                <div class="step-one">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 2</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="cart-step-one">
                                <div class="step-one last-cart-step">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 3</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                 
                    <h3><b>Create Seller Account</b></h3>
                    <div class="login-inner-form">
                        {{-- <form id="signup-form">
                            {{ csrf_field() }} --}} 

                            <div class="form-group form-box">

                              <input type="email" class="input-text" placeholder="Email Address" name="email" id="email"
                                data-parsley-required="true" data-parsley-type="email" data-parsley-type-message="Please enter valid email address" value="{{$email or ''}}" 
                                data-parsley-required-message="Please enter email" >          
                                  <div class="error"></div>
                                  <div id="user_exist_error_message"></div>           
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group form-box passwords-error">
                                <input type="password" name="password" id="password"  class="input-text" placeholder="Password" data-parsley-errors-container=".passworderror" data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character" data-parsley-minlength="8" name="password" id="password" data-parsley-required-message="Please enter password" >

                                 <div class="passworderror" id="password_error_message"></div>


                                <div class="clearfix"></div>
                            </div>


                            <div class="form-group form-box">
                               <input type="password" class="input-text" name="confirm_password" id="confirm_password" placeholder="Confirm Password" data-parsley-required="true" data-parsley-required-message="Please enter confirm password" data-parsley-equalto="#password" data-parsley-equalto-message="Confirm password and password should be the same">
                               <div class="clearfix"></div>
                            </div>  


                            <div class="form-group wrapper">
                                <button type="submit" class="btn-md btn-theme btn-block" id="btn-next">Continue</button>                                
                            </div>

                        {{-- </form> --}}
                    </div>
                   <p>Already have an Account? <a href="{{ url('/') }}/login" class="thembo">Sign In</a></p>
                </div>
                <!-- step 1 End -->
                <!-- step 2 Start -->
                <div class="form-section seller-signup-phase2" style="display: none;" id="step2">
                    <div class="buying-process-main">
                        <div class="cart-section-block">
                            <div class="cart-step-one">
                                <div class="step-one step-active">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 1</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="cart-step-one">
                                <div class="step-one step-active">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 2</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="cart-step-one">
                                <div class="step-one last-cart-step">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 3</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div> 
                    {{-- <div class="logo clearfix">
                        <a href="{{ url('/') }}">
                            <img src="{{ $sitelogo }}" alt="logo" />
                        </a>
                    </div> --}}
                    <h3>Create Seller Account</h3>
                    <div class="login-inner-form">
                       {{--  <form id="question-form"> --}}

                             @if($arr_seller_quests >0)
                             <?php $cnt=0; ?>
                                @foreach($arr_seller_quests as $arr_seller_quest)
                             <?php $cnt++; ?>

                              <input type="hidden" name="seller_question{{ $cnt }}" id="seller_question{{ $cnt }}" value="{!! $arr_seller_quest['question'] !!}">

                            <div class="form-group form-box">
                              <div class="checkbox clearfix">
                                  <div class="form-check checkbox-theme">
                                      <input class="form-check-input seller_answer" type="checkbox" value="{!! $arr_seller_quest['question'] !!}" id="seller_answer{{ $cnt }}" name="seller_answer{{ $cnt }}" data-parsley-errors-container=".seller_answer_eror{{ $cnt }}" data-parsley-required-message="Please agree to the above terms"                                       >
                                      <label class="form-check-label" for="seller_answer{{ $cnt }}"> {!! $arr_seller_quest['question'] !!}<span class="asteric_mark">*<span> </label>
                                        <div class"seller_answer_eror{{ $cnt }}"></div>
                                  </div>
                              </div>
                           </div>

                             @endforeach 
                           @endif



                            <div class="buttonsection-bottom">
                                <a href="{{ url('/') }}" class="btn-md btn-theme backbtn-prv" id="btn-back2">Back</a>
                                <a href="#" class="btn-md btn-theme next-right" id="btn-next2">Next</a>
                                <div class="clearfix"></div>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>
                <!-- step 2 End -->

                <!-- step 3 Start -->
                <div class="sub-plan-section seller-signup-phase3" style="display: none;" id="step3">
                     <div class="buying-process-main">
                        <div class="cart-section-block">
                            <div class="cart-step-one">
                                <div class="step-one step-active">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 1</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="cart-step-one">
                                <div class="step-one step-active">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 2</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="cart-step-one">
                                <div class="step-one step-active last-cart-step">
                                    <span class="num-step font-style"></span>
                                    <span class="name-step-confirm">Step 3</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div> 
                    </div> 
                    <div class="title-p-details select-sub-pln">Select Membership Plan</div>
                    <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 bg-color-10">
                    <div class="radio-sections">
                                                      
                          @if(isset($arr_membership) && !empty($arr_membership))  
                             @php
                              $i=0; 
                              $box_color = '';
                             @endphp
                              @foreach($arr_membership as $membership)

                                                             
                      
                                 <div class="radio-btn">
                                    <input type="radio" id="membership_{{ $membership['id'] }}" name="membership" amt="{{ $membership['price'] }}" 
                                    membership_type="{{ $membership['membership_type'] }}"  stripe_plan_id="{{ $membership['plan_id'] }}"  class="membership"  value="{{ $membership['id'] }}"   />
                                    <label for="membership_{{ $membership['id'] }}">
                                       <div class="form-plan-main-list">
                                        <div class="header-membr" style="background-image: url({{ url('/')  }}/uploads/membership/{{ $membership['image']  }});">
                                            <div class="productnms-plan">{{ $membership['product_count'] }} Products</div>
                                            <div class="product-month-plan">
                                              @if($membership['membership_type']=="2")
                                              ${{ $membership['price'] }}/month
                                              @else
                                              {{ 'Free' }}
                                              @endif
                                           </div>
                                            <div class="product-no-fee">no listing fees</div>
                                            <div class="button-signupnow">
                                                <a href="javascript:void(0)" class="signupnow">Sign up now</a>
                                            </div>
                                        </div>
                                        <div class="mainwhite-plan">
                                            <div class="title-features">{{ $membership['name'] }}</div>
                                                @php echo $membership['description'] @endphp
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

                      @if(isset($arr_membership) && !empty($arr_membership))
                        @php 
                             
                        $default_amount = isset($arr_membership[0]['price'])?$arr_membership[0]['price']:''; 
                        $default_subscription = isset($arr_membership[0]['id'])?$arr_membership[0]['id']:'';  
                        $default_memtype = isset($arr_membership[0]['membership_type'])?$arr_membership[0]['membership_type']:'';  

                         $defstripe_plan_id = isset($arr_membership[0]['plan_id'])?$arr_membership[0]['plan_id']:'';  
 
                        @endphp
                      @endif

                     </div> <!--end of radio section div----> 

                      <input type="text" id="amount" name="amount" value="{{ $default_amount }}">
                      <input type="text" id="subscription" name="subscription" value="{{ $default_subscription }}">
                      <input type="text" id="membership_type" name="membership_type" value="{{  $default_memtype }}">

                      <input type="text" id="stripe_plan_id" name="stripe_plan_id" value="{{  $defstripe_plan_id }}">

 
                      <!-------start of payment detail form---------------->
                       <div class="form-section paymentdetails-frms" id="paydetailform" >

                         

                               <div class="login-inner-form">
                                <div class="title-p-details select-sub-pln">Payment Details
                                </div>
                                   <div class="row">
                                      <div class="card-errors"></div>

                                    <div class="col-md-6">
                                        <div class="form-group form-box pay-form">
                                           <input type="text" class="form-control stripeclass" id="name" name="name" autofocus="" placeholder="Card holder’s name" data-parsley-required-message="Please enter card holder name"
                                           />
                                          
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group form-box pay-form">
                                           
                                            <input type="text" name="card_number" id="card_number" placeholder="1234 1234 1234 1234"  class="form-control input-text stripeclass"maxlength="16" autocomplete="off" data-parsley-required-message="Please enter card number">
                                            <div class="clearfix"></div>

                                        </div>
                                    </div> 
                                    </div>
                                    <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group form-box pay-form">
                                           <input type="text" name="card_exp_month" id="card_exp_month" placeholder="MM" maxlength="2"  class="form-control stripeclass" data-parsley-required-message="Please enter card expiry month">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group form-box pay-form">
                                           <input type="text" name="card_exp_year" id="card_exp_year" placeholder="YYYY" maxlength="4"  class="form-control stripeclass" data-parsley-required-message="Please enter year">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group form-box pay-form">
                                          
                                            <input type="text" name="card_cvc" id="card_cvc" placeholder="CVC" maxlength="3" class="form-control input-text stripeclass" autocomplete="off" data-parsley-required-message="Please enter cvv">
                                            
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                  

                                </div>

                                

                                <div class="buttonsection-bottom">
                                    <a href="{{ url('/') }}" class="btn-md btn-theme backbtn-prv" id="btn-back3">Back</a>
                                    <a href="#" class="btn-md btn-theme next-right"  id="payBtn" onclick="onGetCardNonce(event)">Submit</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                       </div>
                    <!---end of payment detail form------->

                   <div class="clearfix"></div>


                 

                </div></div> <!--end of membership boxes-->


                <!-- step 3 End -->
            </div>
        </div>
        </div>
    </div> 
</div>
 </form>

<style>
  .paydetailform .card-errors p{
    color:red;
  }
</style>

<script src="https://js.stripe.com/v2/"></script>

<script>
  var publickey = "{{ $publik_key }}";
  console.log(publickey);
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
          title: 'Do you really want to purchase this membership plan?',
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

                    var email = $("#email").val();
           
                   $.ajax({
                    url:SITE_URL+'/process_signup',
                    data:new FormData($('#nonce-form')[0]),
                    processData: false,
                    method:'POST',
                    contentType: false,
                    dataType:'json',
                    beforeSend : function() 
                    {
                      showProcessingOverlay();
                      $('#btn-login').prop('disabled',true);
                      $('#btn-login').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
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
                            // swal('Success!', response.msg, 'success');
                            // setTimeout(function(){
                            //     window.location.reload();
                            // },5000);
                           // window.location.href = SITE_URL+'/login/2/'+btoa(email);
                             window.location.href = SITE_URL+'/welcome';
                            
                        }
                        else if(response.status=="ERROR"){
                            if(response.msg!=""){
                                $('#user_exist_error_message').css('color','red').html(response.msg);
                            }else{
                                $('#user_exist_error_message').html('');
                            }

                            if(response.password_msg!=""){
                                $('#password_error_message').css('color','red').html(response.password_msg);
                            }else{
                                $('#password_error_message').html('');
                            }  

                        }
                       
                        
                      }// if type object
                    }//success
                  });

              } //confirmbox             
           })//if confirm box        


        }//if token



    }//end of else
}//end of stripe token handler

</script>
<script>
    
 $('input[name=membership]').change(function(){
    var membership = $( 'input[name=membership]:checked' ).val();
    $("#subscription").val(membership);

    var amt = $(this).attr('amt');
    $("#amount").val(amt);

    var membership_type = $(this).attr('membership_type');
     $("#membership_type").val(membership_type);

    var stripe_plan_id = $(this).attr('stripe_plan_id');
    $("#stripe_plan_id").val(stripe_plan_id);

    if(membership_type==1){
      $("#paydetailform").hide();
      $("#buttonsection").show();
      $(".mainsignupnewclass").removeClass('paymentdetailsclass');
    }else{
      $("#paydetailform").show();
      $("#buttonsection").hide();
      $(".mainsignupnewclass").addClass('paymentdetailsclass');

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

 
<script type="text/javascript">
  
    $('#btn-next').click(function(){
         $(".seller_answer").removeAttr("data-parsley-required");
         $(".stripeclass").removeAttr("data-parsley-required");

         
        // alert($('#nonce-form').parsley().validate());
        if($('#nonce-form').parsley().validate()==false) return;
        
           
             showProcessingOverlay();
             $("#step1").hide();
             $("#step2").show();
             $("#step3").hide();

             $( "#chw-logo" ).removeClass( "setchowlogo" );
             $( "#sethiddenoverflowclass" ).removeClass( "third-subscription" );


             hideProcessingOverlay();
             return false;

    });

     $('#btn-next2').click(function(){ 
         $(".seller_question_label").children().append("<span class='asteric_mark'>&nbsp;*</span>");
         $(".seller_answer").attr("data-parsley-required","true");

        if($('#nonce-form').parsley().validate()==false) return;
        //if($('#signup-form').parsley().isValid() == true )
        //{
           
             showProcessingOverlay();
             $("#step1").hide();
             $("#step2").hide();
             $("#step3").show();

             $("#chw-logo").addClass('setchowlogo');
             $(".mainsignupnewclass").addClass('thirdstepclass');
             $( "#sethiddenoverflowclass" ).addClass( "third-subscription" );

            hideProcessingOverlay();
              return false;

    });


    $('#btn-back2').click(function(){

     $(".stripeclass").removeAttr("data-parsley-required");

         showProcessingOverlay();

          $("#step1").show();
          $("#step2").hide();
          $("#step3").hide();
        $( "#chw-logo" ).removeClass( "setchowlogo" );
        $( "#sethiddenoverflowclass" ).removeClass( "third-subscription" );

         hideProcessingOverlay();
         return false;
     
    });
    
    $('#btn-back3').click(function(){
   $(".stripeclass").removeAttr("data-parsley-required");

        showProcessingOverlay();

          $("#step1").hide();
          $("#step2").show();
          $("#step3").hide();
        $( "#chw-logo" ).removeClass( "setchowlogo" );  
        $( "#sethiddenoverflowclass" ).removeClass( "third-subscription" );

         hideProcessingOverlay();
         return false;

    });

    $('#btn-back4').click(function(){
        
        showProcessingOverlay();

        $("#step1").hide();
        $("#step2").show();
        $("#step3").hide();
        $( "#chw-logo" ).removeClass( "setchowlogo" );  
        $(".mainsignupnewclass").removeClass('thirdstepclass');

        hideProcessingOverlay();
        return false;

    });


     $('#payBtn').click(function(){ 
         $(".seller_answer").removeAttr("data-parsley-required");
        $(".stripeclass").attr("data-parsley-required","true");
         
        if($('#nonce-form').parsley().validate()==false) return;
      
           
             showProcessingOverlay();
             $("#step1").hide();
             $("#step2").hide();
             $("#step3").show();

            $( "#chw-logo" ).removeClass( "setchowlogo" );  
        $(".mainsignupnewclass").removeClass('thirdstepclass');
        $( "#sethiddenoverflowclass" ).addClass( "third-subscription" );

            hideProcessingOverlay();
            return false;

    });





function onGetCardNonce(event) 
{
   var subscription = $("#subscription").val();
   if(subscription=="")
   {
      swal('Warning!', 'Please select membership plan', 'warning');
   }else{


       // swal({
       //    title: 'Do you really want to purchase this membership plan?',
       //    type: "warning",
       //    showCancelButton: true,
       //  //   confirmButtonColor: "#DD6B55",
       //    confirmButtonColor: "#8d62d5",
       //    confirmButtonText: "Yes, do it!",
       //    closeOnConfirm: false
       //  },
       //  function(isConfirm,tmp)
       //  {
       //    if(isConfirm==true)
       //    {
            // Don't submit the form until SqPaymentForm returns with a nonce
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

       //     } 
       //    else{
              
       //    }
       // })//if confirm box    


   }
}  //end of function 
 

   $('#btn-sign-up').click(function(){

    swal({
          title: 'Do you really want to purchase this membership plan?',
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
        
              var form_data = $('#nonce-form').serialize();      

                  if($('#nonce-form').parsley().isValid() == true )
                  {

                    var email = $("#email").val();


                    $.ajax({
                      url:SITE_URL+'/process_signup',
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
                       
                        console.log(response);
                        hideProcessingOverlay();

                        if(typeof response =='object')
                        {
                          if(response.status && response.status=="SUCCESS")
                          {
                              $("#nonce-form")[0].reset();
                              //swal('Success!', response.msg, 'success');
                             // setTimeout(function()
                             // {
                                 // window.location.reload();
                                   window.location.href = SITE_URL+'/login/2/'+btoa(email);
                               
                             // },5000);
                              
                          }
                          else if(response.status=="ERROR"){
                              if(response.msg!=""){
                                  $('#user_exist_error_message').css('color','red').html(response.msg);
                              }else{
                                  $('#user_exist_error_message').html('');
                              }

                              if(response.password_msg!=""){
                                  $('#password_error_message').css('color','red').html(response.password_msg);
                              }else{
                                  $('#password_error_message').html('');
                              }  
                          }
                        }// if type object
                      }//success
                    });
                  }

             }//if confirm 
          else{
              
          }
       })//if confirm box       


  });//end





  function get_states()
    {
      var country_id  = $('#country').val();
        
      $.ajax({
              url:SITE_URL+'/get_states',
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
                  
                  $("#state").html(html);
              }
      });
  }


</script>




<!-- Facebook Pixel Code -->
<script>
 !function(f,b,e,v,n,t,s)
 {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
 n.callMethod.apply(n,arguments):n.queue.push(arguments)};
 if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
 n.queue=[];t=b.createElement(e);t.async=!0;
 t.src=v;s=b.getElementsByTagName(e)[0];
 s.parentNode.insertBefore(t,s)}(window, document,'script',
 'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '572854193518164');
 fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
 src="https://www.facebook.com/tr?id=572854193518164&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->



<script type="text/javascript">
   $(document).ready(function(){
          var guest_url = "{{url('/')}}";
          var guest_redirect_url = window.location.href;

          $(".guest_url_btn").click(function(){

            
            $.ajax({
                    url:guest_url+'/set_guest_url',
                    method:'GET',
                    data:{guest_link:guest_redirect_url},
                    dataType:'json',            
                    
                    success:function(response)
                    {
                        //alert(response);
                      if(response.status=="success")
                      {
                        //
                        $(location).attr('href', guest_url+'/signup/guest')
                        

                      }

                    }
                });
          });
    });
</script>


<script type="text/javascript">


      var guest_url = "{{url('/')}}";

    $(".country").change(function(){

        var country = $(this).val();

              $.ajax({
                    url:guest_url+'/common/get_states/'+country,
                    method:'GET',
                    dataType:'json',                         
                    success:function(response)
                    {
                                 if(typeof(response)=='object') {

                                  if(response.status=='SUCCESS') {
                                      var option = '<option value="">Please Select States</option>';
                                      
                                      $(response.states_arr).each(function(index,state)
                                      {
                                       
                                        option+='<option value="'+state.id+'">'
                                                         +state.state_title+'</option>';
                                      });

                                      $(".state").html(option);
                                  }
                                  else
                                  {
                                   $(".state").html('<option>States Not Found</option>');
                                  }
                              }


                    }
                });
    });

    $(".state").change(function(){

        var country = $('.country').val();
        var state = $(this).val();
    
              $.ajax({
                    url:guest_url+'/common/get_cities/'+country+'/'+state,
                    method:'GET',
                    dataType:'json',                         
                    success:function(response)
                    {
                                 if(typeof(response)=='object') {

                                  if(response.status=='SUCCESS') {
                                      var option = '<option value="">Please Select city</option>';
                                      
                                      $(response.cities_arr).each(function(index,city)
                                      {
                                       
                                        option+='<option value="'+city.id+'">'
                                                         +city.city_title+'</option>';
                                      });

                                      $(".city").html(option);
                                  }
                                  else
                                  {
                                   $(".city").html('<option>City Not Found</option>');
                                  }
                              }


                    }
                });

    });//end state function

    $(".country_billing").change(function(){

        var country = $(this).val();

              $.ajax({
                    url:guest_url+'/common/get_states/'+country,
                    method:'GET',
                    dataType:'json',                         
                    success:function(response)
                    {
                                 if(typeof(response)=='object') {

                                  if(response.status=='SUCCESS') {
                                      var option = '<option value="">Please Select States</option>';
                                      
                                      $(response.states_arr).each(function(index,state)
                                      {
                                       
                                        option+='<option value="'+state.id+'">'
                                                         +state.state_title+'</option>';
                                      });

                                      $(".state_billing").html(option);
                                  }
                                  else
                                  {
                                   $(".state_billing").html('<option>States Not Found</option>');
                                  }
                              }


                    }
                });
    });//end of country function

    $(".state_billing").change(function(){

        var country = $('.country_billing').val();
        var state = $(this).val();
  

              $.ajax({
                    url:guest_url+'/common/get_cities/'+country+'/'+state,
                    method:'GET',
                    dataType:'json',                         
                    success:function(response)
                    {
                                 if(typeof(response)=='object') {

                                  if(response.status=='SUCCESS') {
                                      var option = '<option value="">Please Select city</option>';
                                      
                                      $(response.cities_arr).each(function(index,city)
                                      {
                                       
                                        option+='<option value="'+city.id+'">'
                                                         +city.city_title+'</option>';
                                      });

                                      $(".city_billing").html(option);
                                  }
                                  else
                                  {
                                   $(".city_billing").html('<option>City Not Found</option>');
                                  }
                              }


                    }
                });

    });//end state function

  $("#business_name").change(function(){
    var business_name = $(this).val();
   
     $.ajax({
        url:guest_url+'/common/get_business_name/'+business_name,
        method:'GET',
        dataType:'json',                         
        success:function(response)
        {       
              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                 $('#user_exist_error_message').html('');
                 document.getElementById("btn-next").style.pointerEvents="auto";
                   $("#btn-next").css('background-color','#666');
                   $(".wrapper").css('cursor','pointer');

                }else if(response.status && response.status=="ERROR"){
                   
                  $('#user_exist_error_message').css('color','red').html(response.msg);
                  document.getElementById("btn-next").style.pointerEvents="none";
                  $("#btn-next").css('background-color','#aaa');
                  $(".wrapper").css('cursor','not-allowed');
   


                  return false;

                }
              }// if object
        } //success 
      });    
  });//end business_name function


 $("#email").change(function(){ 
    var email = $(this).val();
   
     $.ajax({
        url:guest_url+'/common/check_email_exists/'+email,
        method:'GET',
        dataType:'json',                         
        success:function(response)
        {       
              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                 $('#user_exist_error_message').html('');
                 document.getElementById("btn-next").style.pointerEvents="auto";
                   $("#btn-next").css('background-color','#7d36bb');
                   $(".wrapper").css('cursor','pointer');

                }else if(response.status && response.status=="ERROR"){
                   
                  $('#user_exist_error_message').css('color','red').html(response.msg);
                  document.getElementById("btn-next").style.pointerEvents="none";
                  $("#btn-next").css('background-color','#7d36bb99');
                  $(".wrapper").css('cursor','not-allowed');
   
                  return false;

                }
              }// if object
        } //success 
      });    
  });//end email exists function


/*
 $("#email").blue(function(){ 
    var email = $(this).val();
   
     $.ajax({
        url:guest_url+'/common/check_email_exists/'+email,
        method:'GET',
        dataType:'json',                         
        success:function(response)
        {       
              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                 $('#user_exist_error_message').html('');
                 document.getElementById("btn-next").style.pointerEvents="auto";
                   $("#btn-next").css('background-color','#7d36bb');
                   $(".wrapper").css('cursor','pointer');

                }else if(response.status && response.status=="ERROR"){
                   
                  $('#user_exist_error_message').css('color','red').html(response.msg);
                  document.getElementById("btn-next").style.pointerEvents="none";
                  $("#btn-next").css('background-color','#7d36bb99');
                  $(".wrapper").css('cursor','not-allowed');
   
                  return false;

                }
              }// if object
        } //success 
      });    
  });//end email exists function

*/
</script>



</body>

</html>

