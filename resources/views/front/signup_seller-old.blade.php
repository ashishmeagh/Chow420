
<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="{{ isset($site_setting_arr['meta_desc'])?$site_setting_arr['meta_desc']:'' }}" />
        <meta name="keywords" content="{{ isset($site_setting_arr['meta_keyword'])?$site_setting_arr['meta_keyword']:'' }}" />
        <meta name="author" content="" />
        <title>{{isset($page_title)?$page_title:""}} : {{ config('app.project.name') }}</title>
        <!-- ======================================================================== -->
        <!-- <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/images/faviconnew.ico"> -->

        <!-- Favicon -->

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
        <!-- Bootstrap CSS -->
        <link href="{{url('/')}}/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!--font-awesome-css-start-here-->
        <link href="{{url('/')}}/assets/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> 
        <!--Custom Css-->

        <link href="{{url('/')}}/assets/front/css/flexslider.css" rel="stylesheet" type="text/css" />

        <link href="{{url('/')}}/assets/front/css/chow.css" rel="stylesheet" type="text/css" />
        <link href="{{url('/')}}/assets/front/css/listing.css" rel="stylesheet" type="text/css" />
        <link href="{{url('/')}}/assets/front/css/range-slider.css" rel="stylesheet" type="text/css" />
        <!-- parsley validation css -->
        <link href="{{url('/')}}/assets/common/Parsley/dist/parsley.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/common/sweetalert/sweetalert.css" rel="stylesheet">
        
        <!--Main JS-->
        <script type="text/javascript"  src="{{url('/')}}/assets/front/js/jquery-1.11.3.min.js"></script>
        <!--[if lt IE 9]>-->
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

        <!-- loader js -->
        <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loadingoverlay.min.js"></script>
        <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>
    
        <script type="text/javascript">
          var SITE_URL = '{{url('/')}}';
        </script>
    </head>
     <body>

<style>
    .login-12 .login-inner-form .seller_question_chk {margin-top:24px;}
    .checkbox-rememberMe {margin-top:24px !important;}
    .asteric_mark{
        color:red;
    }
    .seller-signup-phase2, .btn-back, .btn-sign-up{
        display: none;
    }
    .passworderror{
        padding-top: 8px;
    }

    .login-12 .bg-img {
        top: 110px;
    }
    .login-12 .login-inner-form .checkbox a{
          color: #873dc8;
    }
    .login-12 .login-inner-form .checkbox a:hover{
          color: #333333;
    }
    .form-group.emailaddres-eror{
        position: relative;
    }
    .form-group.emailaddres-eror .parsley-errors-list {
        position: absolute;
        bottom: auto;
        line-height: 15px;
        left: 0px;
        top: 70px;
        text-align: left;
        font-size: 15px !important;
    }
</style>

<div class="login-12">

 @php

    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }
@endphp 


    <div class="container container-login">
        <div class="row">
        <div class="logo-chow">
                <a href="{{url('/')}}"> 
                     <img src="{{$sitelogo}}" alt="Signup" />
                    {{-- <img src="{{url('/')}}/assets/front/images/chow-logo.png" alt="" /> --}}
                </a>
              </div>
        <div class="col-md-12 pad-0">
            <div class="login-box-12">
                <div id="status_msg"></div>
                    <form id="signup-form">
                        {{ csrf_field() }}


                        <div class="login-inner-form">
                       
                            <input type="hidden" name="role" id="role" value="seller">
                            <div class="details">
                                <h3>Create seller account</h3>
                                <div class="seller-signup-phase1">
                                    {{-- <div class="form-group">

                                        <label for="first_name">First Name <span class="asteric_mark">*<span></label>
                                        <input type="text" name="first_name" class="input-text" placeholder="First Name" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" data-parsley-required-message="Please enter first name">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name <span class="asteric_mark">*<span></label>
                                        <input type="text" class="input-text" placeholder="Last Name" name="last_name" id="last_name" data-parsley-whitespace="trim" data-parsley-required="true"  data-parsley-pattern="^[a-zA-Z]+$" data-parsley-required-message="Please enter last name"/>
 
                                        <div class="error"></div>
                                    </div> --}}
                                    <div class="form-group emailaddres-eror">
                                        <label for="email">Email Address <span class="asteric_mark">*<span></label>
                                        <input type="email" class="input-text" placeholder="Email Address" name="email" id="email" data-parsley-required="true" data-parsley-type="email" value="{{$email or ''}}" data-parsley-required-message="Please enter email" data-parsley-remote="{{ url('/does_emailid_exist') }}"
                                            data-parsley-remote-options='{ "type": "GET", "dataType": "jsonp", "data": { "_token": "{{ csrf_token() }}" } }' data-parsley-remote-message="This email already exists. Please try with diffrent email ID">
                                        
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="">Mobile Number <span class="asteric_mark">*<span></label>
                                        <input type="text" class="input-text" placeholder="Mobile Number" name="mobile_no" id="mobile_no" data-parsley-required="true" data-parsley-type="number" data-parsley-length="[10,10]" data-parsley-length-message="Mobile number should be 10 digit" value="{{$mobile_no or ''}}" data-parsley-required-message="Mobile Number is Required">
                                    </div> -->


                                     <div class="form-group">
                                        <label for="business_name">Business Name <span class="asteric_mark">*<span></label>
                                        <input type="text" class="input-text" placeholder="Business Name" name="business_name" id="business_name" data-parsley-whitespace="trim" data-parsley-required="true"  {{-- data-parsley-pattern="^[a-zA-Z\s]+$" --}} data-parsley-required-message="Please enter business name"/>
 
                                        <div class="error"></div>
                                        <div id="user_exist_error_message"></div>
                                    </div>



 
                                    <div class="form-group password-form">
                                        <label for="password">Password <span class="asteric_mark">*<span></label>
                                        <input type="password" class="input-text" placeholder="Password" data-parsley-errors-container=".passworderror" data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character" data-parsley-minlength="8" name="password" id="password" data-parsley-required-message="Please enter password" >
                                        <div class="passworderror" id="password_error_message"></div>
                                    </div>

                                    <div class="form-group">
                                      <label for="confirm_password">Confirm Password <span class="asteric_mark">*</span></label>
                                      <input type="password" class="input-text" name="confirm_password" id="confirm_password" placeholder="Confirm Password" data-parsley-required="true" data-parsley-required-message="Please enter confirm password" data-parsley-equalto="#password" data-parsley-equalto-message="Confirm password and password should be the same">
                                    </div>

                                    
                                  {{--  <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                      <div class="form-group ">
                                        <label for="country">Country <span>*</span></label>
                                        @php
                                            $country_id = isset($user_details_arr['country'])?$user_details_arr['country']:0;
                                        @endphp
                                        <div class="select-style">
                                        <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select country" id="country" name="country" onchange="get_states()">

                                        @if(isset($countries_arr) && count($countries_arr)>0)
                                        <option value="">Select Country</option>
                                        @foreach($countries_arr as $country)
                                            <option  @if($country['id']==$country_id) selected="selected" @endif value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>                                        
                                        @endforeach
                                        @else
                                            <option>Countries Not Available</option>
                                        @endif
                                        </select> 
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                      <div class="form-group">
                                        <label for="state">State <span>*</span></label> 
                                        <div class="select-style">                                       
                                        <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state " id="state" name="state">                                        
                                            <option value="">Select State</option>                                                                                
                                        </select> 
                                        </div>
                                      </div> 
                                    </div>
                                 </div> --}}

                                    
                                </div>
                                <div class="seller-signup-phase2">
                                    <p>Please Accept the Terms Below</p>
                                    <hr>
                                    
                                    
                                    @if($arr_seller_quests >0)
                                    <?php $cnt=0; ?>
                                    @foreach($arr_seller_quests as $arr_seller_quest)
                                    <?php $cnt++; ?>
                                        <div class="checkbox clearfix seller_question_chk">   
                                            <div class="form-check checkbox-theme">
                                                <input type="hidden" name="seller_question{{ $cnt }}" id="seller_question{{ $cnt }}" value="{!! $arr_seller_quest['question'] !!}">
                                                <input class="form-check-input seller_answer" type="checkbox" id="seller_answer{{ $cnt }}" name="seller_answer{{ $cnt }}" data-parsley-errors-container=".seller_answer_eror{{ $cnt }}" data-parsley-required-message="Please agree the above term" >
                                                <label class="form-check-label" for="seller_answer{{ $cnt }}">
                                                    {!! $arr_seller_quest['question'] !!} <span class="asteric_mark">*<span>
                                                </label>
                                                <div class"seller_answer_eror{{ $cnt }}"></div>
                                            </div>
                                                
                                            {{--  <div class="form-group">
                                                <label class="seller_question_label" for="seller_answer{{ $cnt }}"> </label>
                                                <input type="hidden" name="seller_question{{ $cnt }}" id="seller_question{{ $cnt }}" value="{!! $arr_seller_quest['question'] !!}">
                                                <textarea class="input-text seller_answer" placeholder="Enter Answer" name="seller_answer{{ $cnt }}" id="seller_answer{{ $cnt }}" data-parsley-required-message="Answer is Required"></textarea>
                                            </div>  --}}
                                        </div>
                                    @endforeach
                                    @endif

                                    <div class="checkbox clearfix checkbox-rememberMe">
                                        <div class="form-check checkbox-theme">
                                            <input class="form-check-input" type="checkbox" checked id="rememberMe"
                                            data-parsley-required="true">
                                            <label class="form-check-label" for="rememberMe">
                                                Accept&nbsp;<a href="{{$terms_condition_url}}" target="_blank">Terms and Conditions <span class="asteric_mark">*</span></a>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                    <div class="form-group sellersigup-button">
                                        <button type="button" class="btn-md btn-theme btn-back" id="btn-back">Back</button>
                                        <div class="wrapper">
                                            <button type="button" class="btn-md btn-theme btn-block btn-next" id="btn-next">Next</button>   
                                        </div>

                                         <a href="{{ url('/') }}" class="btn-md btn-theme btn-block btn-next" id="btn-back" style="width: 49% !important;">Back</a>
                                        <button type="button" class="btn-md btn-theme btn-sign-up" id="btn-sign-up">Sign Up</button>
                                        <div class="clearfix"></div>
                                    </div>
                                <p>Already have an Account?<a href="{{url('/')}}/login" style="color:#873dc8;">Sign In</a></p>
                            </div>
                        </div>                        
                    </form> 
                    
                <!-- <div class="col-lg-5 col-md-12 col-sm-12 col-pad-0 bg-img align-self-center none-992">
                    <a href="#" class="chw-login">
                        @php 
                          $logo = url('/').'/assets/front/images/chow-logo.png';

                          if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!="" && file_exists($site_setting_arr['site_logo'])){
                            $logo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
                          }else{
                            $logo = url('/').'/assets/front/images/chow-logo.png';
                          }

                        @endphp
                        <img src="{{ $logo }}" class="logo" alt="logo" />
                    </a>
                    <p> {{ isset($site_setting_arr['site_short_description'])?
                              substr($site_setting_arr['site_short_description'],0,100):'' }} </p>
                    <ul class="social-list clearfix">
                        <li><a href="{{ isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:'' }}" target="blank"><i class="fa fa-facebook"></i></a></li>
                        
                        <li><a href="{{ isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:'' }}" target="blank"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div> -->
            </div>
        </div>
       </div>
    </div>
</div>

<script type="text/javascript">
  
    $('#btn-next').click(function(){
        if($('#signup-form').parsley().validate()==false) return;
        if($('#signup-form').parsley().isValid() == true )
        {
            showProcessingOverlay();
            $(".seller_question_label").children().append("<span class='asteric_mark'>&nbsp;*</span>");
            $(".seller_answer").attr("data-parsley-required","true");
            $(".seller-signup-phase1").hide();
            $(".btn-next").hide();
            $(".seller-signup-phase2").show();
            $(".btn-back").show();
            $(".btn-sign-up").show();
            hideProcessingOverlay();
        }

    });
    
    $('#btn-back').click(function(){
        
        
        showProcessingOverlay();
        $(".seller_question_label").children().children(".asteric_mark").remove();
        $(".seller_answer").removeAttr("data-parsley-required");
        $(".seller-signup-phase1").show();
        $(".btn-next").show();
        $(".seller-signup-phase2").hide();
        $(".btn-back").hide();
        $(".btn-sign-up").hide();
        hideProcessingOverlay();

    });

  $('#btn-sign-up').click(function(){

    if($('#signup-form').parsley().validate()==false) return;
        
        var form_data = $('#signup-form').serialize();      

        if($('#signup-form').parsley().isValid() == true )
        {
                     

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
             
              hideProcessingOverlay();
              $('#btn-sign-up').prop('disabled',false);
              $('#btn-sign-up').html('SIGN UP');
              $(".seller_question_label").children().children(".asteric_mark").remove();
              $(".seller_answer").removeAttr("data-parsley-required");
              $(".seller-signup-phase1").show();
              $(".btn-next").show();
              $(".seller-signup-phase2").hide();
              $(".btn-back").hide();
              $(".btn-sign-up").hide();

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                    $("#signup-form")[0].reset();

                    {{-- var success_HTML = '';
                    success_HTML +='<div class="alert alert-success alert-dismissible">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>'+response.msg+'</div>';

                        $('#status_msg').html(success_HTML).focus(); --}}

                    swal('Success!', response.msg, 'success');
                    
                     // window.setTimeout(function(){ location.href = SITE_URL+'/login' },1000);
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
                // else
                // {                    
                //     {{-- var error_HTML = '';   
                //     error_HTML+='<div class="alert alert-danger alert-dismissible">\
                //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                //             <span aria-hidden="true">&times;</span>\
                //         </button>'+response.msg+'</div>';                    
                //     $('#status_msg').html(error_HTML).focus(); --}}
                //     // swal('Error', response.msg, 'warning');
                //    // $('#user_exist_error_message').css('color','red').html(response.msg).fadeOut(7000);
                //  $('#user_exist_error_message').css('color','red').html(response.msg);

                // }//else
                
              }// if type object
            }//success
          });
        }
  });

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




<!-- footer -->

<div class="footer-blueslines" style="display: none;">
  <div class="sfw-container">
    <ul class="sfw-footer">
      <li>
          Our experts are available 24/7:
      </li>
      <li>
        <a href="#"><i class="fa fa-phone"></i> 1-000-300-7656</a>
      </li>
      <li>
         <a href="#"><i class="fa fa-comments"></i> <span>chat now</span></a>
      </li>
      <li>
         <a href="#"><i class="fa fa-envelope emailicnss"></i> <span>email us</span></a>
      </li>
      <li>
        <a href="#" class="bacbtnsfooter">back to top <i class="fa fa-angle-up"></i></a>
      </li>
    </ul>
  </div>
</div>
<div class="footer-main-block">
   {{--  <ul class="fter-links">
       @if(!empty($cms_staticpages_arr) && count($cms_staticpages_arr)>0)
       @foreach($cms_staticpages_arr as $cms)
          @php
             if($cms->page_slug=="home")
              $href = url('/');
            else if($cms->page_slug=="contact-us")
              $href = url('/').'/contact-us';
            else if($cms->page_slug=="about-us")
              $href = url('/').'/about-us';
          @endphp  
          <li><a href="{{ $href }}">{{ $cms->page_title }}</a></li>
       @endforeach 
      @endif  
      {{-- <li> <a href="{{ url('/') }}/about">About Us</a></li>
      <li> <a href="{{ url('/') }}/contact_us">Contact Us</a></li>
      <li> <a href="{{ url('/') }}">Home</a></li> --}}
   {{--  </ul> --}} 
    
</div> 
<div class="copyright-block"> 
            <i class="fa fa-copyright"></i> {{ config('app.project.footer_link_year') }}   <a href="{{url('/')}}">{{ config('app.project.footer_link') }}</a>, Inc.   
            
             @if(!empty($cms_terms_privacy_arr) && count($cms_terms_privacy_arr)>0)
                 @foreach($cms_terms_privacy_arr as $cms_terms_privacy)
                    @php
                      
                      if($cms_terms_privacy->page_slug=="terms-conditions")
                        $href = url('/').'/terms-conditions';
                      else if($cms_terms_privacy->page_slug=="privacy-policy")
                        $href = url('/').'/privacy-policy';
                      else if($cms_terms_privacy->page_slug=="contact-us")
                        $href = url('/').'/contact-us';
                      else if($cms_terms_privacy->page_slug=="about-us")
                        $href = url('/').'/about-us';
                    @endphp  
                    <a href="{{ $href }}" class="terms-links terms-links-footer">{{ $cms_terms_privacy->page_title }}</a> 
                 @endforeach 
              @endif  


           {{--  <a href="{{ url('/') }}/terms" class="terms-links terms-links-footer">Terms of Use</a> 
            <a href="{{ url('/') }}/privacy" class="terms-links">Privacy Policy</a> --}}

             <a href="{{ url('/') }}/faqs" class="terms-links terms-links-footer">FAQs</a> 

            <ul class="social-footer">
                <!-- <li><a href="{{ isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:'' }}"><i class="fa fa-facebook"></i></a></li>
                <li><a href="{{ isset($site_setting_arr['twitter_url'])?$site_setting_arr['twitter_url']:'' }}"><i class="fa fa-twitter"></i></a></li>
                <li><a href="{{ isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:'' }}"><i class="fa fa-instagram"></i></a></li> -->
                <li><a href="{{ isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:'' }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <!-- <li><a href="{{ isset($site_setting_arr['twitter_url'])?$site_setting_arr['twitter_url']:'' }}" target="_blank"><i class="fa fa-twitter"></i></a></li> -->
                <li><a href="{{ isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:'' }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
    </div>


<style>
    .disabled:hover {
      cursor: not-allowed;
    }
</style>

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

<!-- parsley validationjs-->
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert.js"></script>

<!-- data table js-->
<script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>
    
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/listing.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/customjs.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/bootstrap.min.js"></script>


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
       // alert(country);
      //  alert(state);

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
       // alert(country);
      //  alert(state);

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


</script>
