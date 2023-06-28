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
</style>

</head>

<body>

@php
if(isset($site_setting_arr) && count($site_setting_arr)>0)
{
     $payment_mode = $site_setting_arr['payment_mode'];
     $sandbox_js_url = $site_setting_arr['sandbox_js_url'];
     $live_js_url = $site_setting_arr['live_js_url'];

     $sandbox_application_id = $site_setting_arr['sandbox_application_id'];
     $live_application_id = $site_setting_arr['live_application_id'];
}
@endphp

<script type="text/javascript"
 @if($payment_mode=='0' && isset($sandbox_js_url)) src="{{ $sandbox_js_url }}" 
 @elseif($payment_mode=='1' && isset($live_js_url)) src="{{ $live_js_url }}" @endif>
  
</script>

 @php

    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }
@endphp 	



<input type="hidden" id="appId" 
@if($payment_mode=='0' && isset($sandbox_application_id))
value="{{ $sandbox_application_id }}"
@elseif($payment_mode=='1' && isset($live_application_id))
value="{{ $live_application_id }}" @endif>


<div class="login-20 mainsignupnewclass">
    <div class="container">
        <div class="row">
        <div class="hidden-overflow">

            <form id="nonce-form">
                {{ csrf_field() }}
                <input type="hidden" name="role" id="role" value="seller">

           {{--  <div class="col-xl-6 col-lg-6 col-md-6 bg-img" style="background: rgba(0, 0, 0, 0.04) url(images/bg-image-14.jpg) top left repeat;">
                <div class="info">
                     <div class="sell-chow-signup">Why Sell on Chow?</div>
                     <div class="video-chow-seller">
                         <iframe src="https://www.youtube.com/embed/jssO8-5qmag" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                     </div>
                </div>
            </div> --}}

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
                   {{--  <div class="logo clearfix">
                        <a href="{{ url('/') }}">
                            <img src="{{$sitelogo}}" alt="logo" />
                        </a>
                    </div> --}}
                    <h3><b>Create Seller Account</b></h3>
                    <div class="login-inner-form">
                        {{-- <form id="signup-form">
                            {{ csrf_field() }} --}} 

                            <div class="form-group form-box">

                             {{--   <input type="email" class="input-text" placeholder="Email Address" name="email" id="email"
                                data-parsley-required="true" data-parsley-type="email" data-parsley-type-message="Please enter valid email address" value="{{$email or ''}}" 
                                data-parsley-required-message="Please enter email" data-parsley-remote="{{ url('/does_emailid_exist') }}"
                                            data-parsley-remote-options='{ "type": "GET", "dataType": "jsonp", "data": { "_token": "{{ csrf_token() }}" } }' data-parsley-remote-message="Provided email already exists in system, you may try different email"> --}}

                                


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
                    

                       <div class="radio-sections">
                        


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


                                 <div class="radio-btn">
                                    <input type="radio" id="membership_{{ $membership['id'] }}" name="membership" amt="{{ $membership['price'] }}" 
                                    membership_type="{{ $membership['membership_type'] }}" class="membership"  value="{{ $membership['id'] }}"   @if($i==0)checked @endif/>
                                    <label for="membership_{{ $membership['id'] }}">
                                      
                                        <span class="main-header-price {{ $box_color }}">
                                        <div class="titlepricelrm free-color">{{ $membership['name'] }} </div>
                                        <span class="decs-txt-bsc">{{ $membership['description'] }}</span>
                                        </span>
                                            <div class="pricingtable price-title">
                                              @if($membership['price']>0)
                                                ${{ number_format($membership['price']) }}/month
                                               {{-- ${{ rtrim(rtrim(strval($membership['price']), "0"), ".") }} --}}
                                              @else
                                                Free
                                              @endif
                                            </div>
                                          <span class="img-signup-slrs-viw">
                                            @if($i==0)
                                              <img src="{{url('/')}}/assets/front/images/free-online-store.jpg" alt="" />
                                            @elseif($i==1)
                                              <img src="{{url('/')}}/assets/front/images/online-and-physical-store.jpg" alt="" />
                                            @endif
                                            
                                          </span>  
                                        <div class="main-count-product" style="display: none;">
                                            <div class="left-counts-plan" >0</div>
                                            <div class="right-counts-plan" id="demo_{{ $membership['id'] }}">{{ $membership['product_count']  }}</div>

                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="priceslider-mns-div" style="display: none;">
                                            <input type="range" step="1" min="0" max="5000" value="{{ $membership['product_count']  }}" class="slider" id="myRange_{{ $membership['id'] }}" disabled>
                                            {{-- <div class="progressbars" style="left: {{ $membership['product_count']  }}%;">
                                                
                                                <div class="counts-mmrs">{{ $membership['product_count']  }}</div>
                                            </div> --}}
                                        </div>
                                       {{--  <div class="email-font-sml">{{ $membership['product_count'] }} Products</div> --}}
                                        
                                    
                                    
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

 
                        @endphp
                      @endif

                    {{--   <input type="text" id="amount" name="amount" value="0">
                      <input type="text" id="subscription" name="subscription" value="1">
                      <input type="text" id="membership_type" name="membership_type" value="1"> --}}

                      <input type="hidden" id="amount" name="amount" value="{{ $default_amount }}">
                      <input type="hidden" id="subscription" name="subscription" value="{{ $default_subscription }}">
                      <input type="hidden" id="membership_type" name="membership_type" value="{{  $default_memtype }}">



 
                      <!-------start of payment detail form---------------->
                       <div class="form-section paymentdetails-frms" id="paydetailform" 
                       @if($default_memtype==2) style="display:block" @else style="display:none" @endif>
                               <div class="login-inner-form">
                                <div class="title-p-details select-sub-pln">Payment Details</div>
                                   <div class="row">

                                     <div class="col-md-6">
                                        <div class="form-group form-box">
                                            <input type="tel" class="form-control input-text" id="sq-card-number" name="cardNumber" placeholder="Please enter card number" />
                                              <span class="input-group-addon"><img src="{{ url('/') }}/assets/front/images/signupcredit-card.svg" alt="" /></span>
                                              <span id='cardNumber_error'></span>
                                            <div class="clearfix"></div>

                                        </div>
                                    </div> 

                     

                                    <div class="col-md-6">
                                        <div class="form-group form-box">
                                           <input type="tel" class="form-control input-text" id="sq-expiration-date" name="cardExpiry" placeholder="MM / YY" />
                                           <span class="input-group-addon"><img src="{{ url('/') }}/assets/front/images/signupcalendar.svg" alt="" /></span>
                                            <span id='expirationDate_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-box">
                                            <input type="text" id="sq-cvv" class="form-control input-text" name="CVV" placeholder="CVV" />
                                            <span class="input-group-addon"><img src="{{ url('/') }}/assets/front/images/signuplock.svg" alt="" /></span>
                                             <span id='cvv_error'></span>
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
                                           <input type="text" class="form-control" name="text" placeholder="Card holder’s name" 
                                          {{--  data-parsley-required="true" data-parsley-pattern="^[A-Za-z]*$" data-required-message="Please enter card holder's name" --}}
                                           />
                                           <span class="input-group-addon"><img src="{{ url('/') }}/assets/front/images/signupuser.svg" alt="" /></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>



                                  
                                  <input type="hidden" id="card-nonce" name="nonce">

                                <div class="buttonsection-bottom">
                                    <a href="{{ url('/') }}" class="btn-md btn-theme backbtn-prv" id="btn-back3">Back</a>
                                    <a href="#" class="btn-md btn-theme next-right"  id="sq-creditcard" onclick="onGetCardNonce(event)">Submit</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                       </div>
                    <!---end of payment detail form------->

                     <!----------start of -button div------------------------>
                        <div class="form-section topspaceclr">
                        <div class="login-inner-form">
                           <div class="buttonsection-bottom" id="buttonsection"  @if($default_memtype==2) style="display:none" @else style="display:block" @endif>
                                                <a href="{{ url('/') }}" class="btn-md btn-theme backbtn-prv" id="btn-back4">Back</a>
                                                <a href="#" class="btn-md btn-theme next-right"  id="btn-sign-up">Submit</a>
                                                <div class="clearfix"></div>
                                            </div>

                        </div>
                        </div>
                      <!-----------end of button div------------------------>


                  </div>
                <!-- step 3 End -->
            </div>
        </div>
        </div>
    </div> 
</div>
 </form>


<script>
    
 $('input[name=membership]').change(function(){
    var membership = $( 'input[name=membership]:checked' ).val();
    $("#subscription").val(membership);

    var amt = $(this).attr('amt');
    $("#amount").val(amt);

    var membership_type = $(this).attr('membership_type');
 
    $("#membership_type").val(membership_type);

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
      
        if($('#nonce-form').parsley().validate()==false) return;
        //if($('#signup-form').parsley().isValid() == true )
        //{
           
             showProcessingOverlay();
             $("#step1").hide();
             $("#step2").show();
             $("#step3").hide();

             $( "#chw-logo" ).removeClass( "setchowlogo" );

             hideProcessingOverlay();
             return false;
       //

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

            hideProcessingOverlay();
              return false;

    });


    $('#btn-back2').click(function(){
         showProcessingOverlay();

          $("#step1").show();
          $("#step2").hide();
          $("#step3").hide();
        $( "#chw-logo" ).removeClass( "setchowlogo" );
         hideProcessingOverlay();
         return false;
     
    });
    
    $('#btn-back3').click(function(){
        
        showProcessingOverlay();

          $("#step1").hide();
          $("#step2").show();
          $("#step3").hide();
        $( "#chw-logo" ).removeClass( "setchowlogo" );  
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
                    window.location.href = SITE_URL+'/login/2/'+btoa(email);
                    
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
    } 
});

paymentForm.build();


function onGetCardNonce(event) 
{
   var subscription = $("#subscription").val();
   
   if(subscription=="")
   {
      swal('Warning!', 'Please select membership plan', 'warning');
   }else{


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



               // Don't submit the form until SqPaymentForm returns with a nonce
               event.preventDefault();
               // Request a nonce from the SqPaymentForm object
               paymentForm.requestCardNonce();

           } 
          else{
              
          }
       })//if confirm box    


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


</script>



</body>

</html>

