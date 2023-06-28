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
        {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/images/faviconnew.ico"> --}}
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

<style type="text/css">
  .passworderror{
        padding-top: 8px;
    }
</style>


@php
    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }

@endphp 


<div class="login-12"> 
    <div class="container">
        <div class="col-md-12 pad-0">
          <div class="logo-chow">
                {{-- <a href="{{url('/')}}"> <img src="{{url('/')}}/assets/front/images/chow-logo.png" alt="" /></a> --}}

                <a href="{{url('/')}}"> <img src="{{$sitelogo or ''}}" alt="" /></a>

              </div>
            <div class="row login-box-12">
               @include('front.layout.flash_messages')
                <div id="status_msg"></div>
                <div class="col-lg-11 col-sm-12 col-pad-0 align-self-center">
                    <div class="login-inner-form">
                        <div class="details">
                            <h3>Reset Password</h3>
                            <form id="frm-change-pwd" method="post" action="{{ url('/process_reset_password') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="code" value="{{$code or ''}}">
                                {{ csrf_field() }}
                                <div class="form-group password-form">
                                    <label for="new_password">New Password <i class="red" style="color:red">*</i></label>
                                    <input type="password" class="input-text" placeholder="Enter new password" data-parsley-required="true" data-parsley-required-message="Please enter new password"
                                    data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character" data-parsley-minlength="8" name="new_password" id="new_password" data-parsley-errors-container=".passworderror"/>
                                    <div class="passworderror"></div>
                                </div>
                                <div class="form-group password-form">
                                    <label for="cnfm_new_password">Confirm Password <i class="red" style="color:red">*</i></label>
                                    <input type="password" class="input-text" placeholder="Enter confirm password "  data-parsley-equalto="#new_password" data-parsley-equalto-message="Confirm password should be same as new password" 
                                        data-parsley-required="true" data-parsley-required-message="Please enter confirm password"
                                    name="cnfm_new_password" id="cnfm_new_password" data-parsley-errors-container="#cnfm_new_password_err"/>
                                    <div id="cnfm_new_password_err"></div>
                                </div>

                                <div class="form-group">
                                  <button type="submit" class="btn-md btn-theme btn-block" id="btn-change-pwd">Reset password</button>
                                </div>
                            </form>
                            <p>If your password remembered. <a href="{{url('/').'/login'}}" style="color:#873dc8">Back to Login</a></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $('#btn-change-pwd').click(function(){

      if($('#frm-change-pwd').parsley().validate()==false) return;

     /* var form_data = $('#frm-change-pwd').serialize();
      $.ajax({
        url:SITE_URL+'/process_reset_password',
        data:form_data,
        method:'POST',        
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-change-pwd').prop('disabled',true);
          $('#btn-change-pwd').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn-change-pwd').prop('disabled',false);
          $('#btn-change-pwd').html('Reset password');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg').html(success_HTML);
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                
                $('#status_msg').html(error_HTML);
            }
          }
        }
      });*/
  });
</script>

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
            <i class="fa fa-copyright"></i> {{ config('app.project.footer_link_year') }}   <a href="{{url('/')}}">{{ config('app.project.footer_link') }}</a>   
            @php 
                 $href='';  
            @endphp
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
                      else if($cms_terms_privacy->page_slug=="seller-policy")
                        $href = url('/').'/seller-policy';
                      else if($cms_terms_privacy->page_slug=="refund-policy")
                        $href = url('/').'/refund-policy';  
                        
                    @endphp  
                    <a href="{{ $href }}" class="terms-links terms-links-footer">{{ $cms_terms_privacy->page_title }}</a> 
                 @endforeach 
              @endif  


           {{--  <a href="{{ url('/') }}/terms" class="terms-links terms-links-footer">Terms of Use</a> 
            <a href="{{ url('/') }}/privacy" class="terms-links">Privacy Policy</a> --}}
            <a href="{{ url('/') }}/faq" class="terms-links terms-links-footer">FAQs</a> 



            <ul class="social-footer">
                <!-- <li><a href="{{ isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:'' }}"><i class="fa fa-facebook"></i></a></li>
                <li><a href="{{ isset($site_setting_arr['twitter_url'])?$site_setting_arr['twitter_url']:'' }}"><i class="fa fa-twitter"></i></a></li>
                <li><a href="{{ isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:'' }}"><i class="fa fa-instagram"></i></a></li> -->
                <li><a href="{{ isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:'' }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <!-- <li><a href="{{ isset($site_setting_arr['twitter_url'])?$site_setting_arr['twitter_url']:'' }}" target="_blank"><i class="fa fa-twitter"></i></a></li> -->
                <li><a href="{{ isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:'' }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
    </div>



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


