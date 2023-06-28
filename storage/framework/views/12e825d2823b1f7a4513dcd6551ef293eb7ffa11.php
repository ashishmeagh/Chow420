<!DOCTYPE html>
<html> 
    <head>

<!---Google analytics-header------>
<?php
if(isset($site_setting_arr['pixelcode']) && !empty($site_setting_arr['pixelcode'])) {
  echo $site_setting_arr['pixelcode'];
}
?>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
       
         
        
         <meta name="title" content="Sign in to your Chow Account">

       

        <meta name="description" content="Welcome to Chow, where CBD happens" />

        <meta name="keywords" content="<?php echo e(isset($site_setting_arr['meta_keyword'])?$site_setting_arr['meta_keyword']:''); ?>" />
        <meta name="author" content="" />
        
        <title>Sign in to your account and start buying and selling products</title>
        <!-- ======================================================================== -->
        <!-- <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(url('/')); ?>/assets/images/faviconnew.ico"> -->

        <!-- Favicon -->

    <!--  Apple -->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-180x180.png">


    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Chow420">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">

    <link rel="mask-icon" href="<?php echo e(url('/')); ?>/assets/favicon/safari-pinned-tab.svg" color="#873dc8">

    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <!--  Generic -->
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo e(url('/')); ?>/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(url('/')); ?>/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(url('/')); ?>/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(url('/')); ?>/assets/favicon/favicon-16x16.png">
    

    <!--  MS -->
    <meta name="msapplication-TileImage" content="<?php echo e(url('/')); ?>/assets/favicon/ms-icon-144x144.png">
        <!-- Bootstrap CSS -->
        <link href="<?php echo e(url('/')); ?>/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!--font-awesome-css-start-here-->
        <link href="<?php echo e(url('/')); ?>/assets/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> 
        <!--Custom Css-->

        <link href="<?php echo e(url('/')); ?>/assets/front/css/flexslider.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo e(url('/')); ?>/assets/front/css/chow.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('/')); ?>/assets/front/css/listing.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('/')); ?>/assets/front/css/range-slider.css" rel="stylesheet" type="text/css" />
        <!-- parsley validation css -->
        <link href="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.css" rel="stylesheet">
        <link href="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.css" rel="stylesheet">
        
        <!--Main JS-->
        <script type="text/javascript"  src="<?php echo e(url('/')); ?>/assets/front/js/jquery-1.11.3.min.js"></script>
        <!--[if lt IE 9]>-->
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

        <!-- loader js -->
        <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/loader/loadingoverlay.min.js"></script>
        <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/loader/loader.js"></script>
    
        <script type="text/javascript">
          var SITE_URL = '<?php echo e(url('/')); ?>';
        </script>
</head>
<body>


<?php
if(isset($site_setting_arr['body_content']) && !empty($site_setting_arr['body_content'])) {
  echo $site_setting_arr['body_content'];
}
?>
  

<style>

.login-12{
      height: 78vh;
}
.logo-chow{margin: 0;}
.rw-login-row{margin-top: 0;}

  .copyright-block a.terms-links.terms-links-footer {
    margin-left: 1%;
}
    .asteric_mark{
        color:red;
    }
    .login-box-12 {
    min-height: 470px;
}
.copyright-block{position: absolute;}
.butn-def{
    cursor: pointer;
    padding: 10px 50px 8px 50px;
    height: 45px;
    letter-spacing: 1px;
    font-size: 14px; text-decoration: none;
    font-weight: 600;
    font-family: 'Open Sans', sans-serif;
    border-radius: 3px;
    background: #873dc8;
    border: none;
    color: #fff;
}
.butn-def:hover {
    background: #3a3a3a;color: #fff;
    box-shadow: 0 0 35px rgba(0, 0, 0, 0.1);
}
.form-group.forgotpass-error .parsley-errors-list
{ 
    top: 71px;
    bottom: auto;
}
@media  all and (max-width:1199px){
    ul.social-footer {
        float: none;
        margin-top: 7px;
    }
}
@media  all and (max-width:767px){
.login-box-12 {min-height: 350px;}
body {
    padding-bottom: 150px;
}
}

</style>


<?php
    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }

$registration_parameter1 = Request::segment(2);
$registration_parameter2 = Request::segment(3);

$buyer_age_verification_url = Session::get('buyer_age_verification_url');

?> 



<div class="login-12">
    <div class="container container-login rw-container-login">
      <div class="row">
        <div class="col-md-10 rw-login-float">
               <div class="logo-chow">
                <a href="<?php echo e(url('/')); ?>"> 
                  
                  
                </a>
              </div>
              <!-- <div align="text-center" class="logo-chow">The compliant way to buy or sell CBD</div> -->
              <div class="row rw-login-row">
              <div class="col-sm-6 rw-login-left">
                   <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e($sitelogo); ?>" alt="Login" /></a>
                   <!-- <h1>Where CBD happens</h1> -->

                   <h1>Where wellness takes a new meaning</h1> 
                   
                 
              </div>
            <div class="login-box-12 col-sm-6 rw-login-right">
              <?php if(isset($registration_parameter1) && $registration_parameter1=="1" && isset($registration_parameter2) && $registration_parameter2==$registration_parameter2): ?>
                  <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>You have successfully registered as a buyer. please check your email account <b><?php echo e(base64_decode($registration_parameter2)); ?></b> to complete the verification.</div>
              <?php endif; ?> 
               <?php if(isset($registration_parameter1) && $registration_parameter1=="2" && isset($registration_parameter2) && $registration_parameter2==$registration_parameter2): ?>
                 
                 <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>You have successfully registered as a dispensary.</div>
              <?php endif; ?> 

                <div id="status_msg"></div>
                <?php echo $__env->make('front.layout.flash_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="login-inner-form">
                      
                        <div class="details">

                          
                            

                            <?php
                             // $CSRFToken = csrf_token();
                             // $sessiontoken = Session::token();


                            if(isset($productid))
                            {
                              $productid = $productid;
                            }else{
                              $productid ='';
                            }


                            ?>

                            <div id="qtyerr"></div>

                            <form id="login-form" onsubmit="return false;">
                                <?php echo e(csrf_field()); ?>


                                <input type="hidden" name="hidden_productid" id="hidden_productid" value="<?php echo e($productid); ?>">

                                 <input type="hidden" name="hidden_buyagainurl" id="hidden_buyagainurl" value="<?php echo e(isset($registration_parameter1)? $registration_parameter1:''); ?>">
 
                                 <input type="hidden" name="hidden_forumurl" id="hidden_forumurl" value="<?php echo e(isset($registration_parameter1)? $registration_parameter1:''); ?>">
                                  <input type="hidden" name="hidden_buyerageurl" id="hidden_buyerageurl" value="<?php echo e(isset($buyer_age_verification_url)? $buyer_age_verification_url:''); ?>">

                                <div class="form-group" id="email-div">
                                    
                                    <input type="email" name="email" class="input-text" placeholder="Enter email address" data-parsley-required="true" data-parsley-required-message="Email is required" value="<?php echo e(isset($_COOKIE["email"])?$_COOKIE["email"]:''); ?>" id="user_email">
                                </div>
                                <div class="form-group password-form" id="password-div">
                                    
                                    <input type="password" name="password" class="input-text" id="user_password"placeholder="Enter your password" data-parsley-required="true" data-parsley-required-message="Password is required" value="<?php echo e(isset($_COOKIE['password'])?$_COOKIE['password']:''); ?>">
                                </div>


                               <div id="otp_msg"></div>

             
                               <div class="form-group password-form" id="otp-div" style="display: none;">

                                    <input type="text" id="otp" class="input-text" name="otp" placeholder="Enter otp"/>
                                    
                                </div>

                                


                                <div class="checkbox clearfix">
                                    <div class="form-check checkbox-theme">
                                        <input class="form-check-input" type="checkbox" value="" id="rememberMe" checked="checked" <?php if(isset($_COOKIE["rememberd"])&& $_COOKIE["rememberd"]=='rememberd'): ?> checked="checked" <?php endif; ?> name="remember_me">
                                        <label class="form-check-label" for="rememberMe">
                                            Remember me
                                        </label>
                                    </div>
                                  

                                     <a href="#" data-toggle="modal" onclick="return showmodal()" style="color:#873dc8;">Forgot Password?</a>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn-md btn-theme btn-block" id="button_login">Login</button>
                                </div>
                            </form>


                           

                             <p>Don't have an account? Register  
                             


                             <?php if(isset($productid) && !empty($productid)): ?>
                              <a href="<?php echo e(url('/').'/signup/buyer/'.$productid); ?>" style="color:#873dc8"> here</a>
                              <?php else: ?>
                               <a href="<?php echo e(url('/').'/signup/buyer'); ?>" style="color:#873dc8"> here</a>
                              <?php endif; ?>


                             
                            </p>


                            <hr style="margin:10px 0px;">
                             <p>If your email is not verified please  <a href="<?php echo e(url('/').'/activationcode'); ?>" style="color:#873dc8">click here </a>  
                             </p>

                        </div>
                    </div>
                <!-- <div class="col-lg-5 col-md-12 col-sm-12 col-pad-0 bg-img align-self-center none-992">
                    <a href="#" class="chw-login">

                        
                        <?php 

                          if(isset($site_setting_arr['site_logo'])  && $site_setting_arr['site_logo']!="" && file_exists($site_setting_arr['site_logo'])){
                            $logo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
                          }else{
                            $logo = url('/').'/assets/front/images/chow-logo.png';
                          }

                        ?>

                        <img src="<?php echo e($logo); ?>" class="logo" alt="logo" />
                    </a>
                    <p> <?php echo e(isset($site_setting_arr['site_short_description'])?
                              substr($site_setting_arr['site_short_description'],0,100):''); ?> </p>
                    <ul class="social-list clearfix">
                        <li><a href="<?php echo e(isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:''); ?>" target="blank"><i class="fa fa-facebook"></i></a></li>                        
                        <li><a href="<?php echo e(isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:''); ?>" target="blank"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div> -->
            </div>
           <div class="clearfix"></div>
          </div>
        </div>
         </div>
    </div>
</div>

<!-- Forgot password Modal -->
<div class="modal" id="ForgotPasswordModal">
  <div class="modal-dialog forgot-small-modal"> 
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Forgot your password?</h4>
        <button type="button" class="close" id="closemodal" data-dismiss="modal" onclick="return closemodal();">
            <img src="<?php echo e(url('/')); ?>/assets/front/images/closbtns.png" alt="Forgot Password" />
        </button>
      </div>
      <div id="status_msg"></div>
      <!-- Modal body -->
      <form id="frm-forgot-password" onsubmit="return false;">
      <?php echo e(csrf_field()); ?>

        <div class="modal-body">
         <div class="form-group forgotpass-error">
              <label for="">Email Address <span class="asteric_mark">*</span></label>
              <input type="email" name="email" id="email" class="input-text" placeholder="Enter your email address" data-parsley-required="true" data-parsley-required-message="Please enter your email address" data-parsley-type-message="Email must be in a valid email format (e.g. username@coolexample.com), please try again." data-parsley-errors-container="#wrong_email_error_div">
            <div id="wrong_email_error_div"></div>
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="butn-def" id="btn-forgot-password">Submit</button>
            
        </div>
      </form>
      
    </div>
  </div>
</div>

<script type="text/javascript">
  function showmodal()
  {
    $("#email").val('');
    $('#frm-forgot-password').parsley().destroy();

    $("#ForgotPasswordModal").modal('show');
  }
  function closemodal()
  {
    $("#email").val('');
    $('#frm-forgot-password').parsley().destroy();
  }
  $('#button_login').click(function()
  {

    var hidden_productid = $("#hidden_productid").val();
    var urls = "<?php echo e(URL::previous()); ?>";

    
    var hidden_forumurl = $("#hidden_forumurl").val();
    var hidden_buyerageurl = $("#hidden_buyerageurl").val();

    var hidden_buyagainurl = $("#hidden_buyagainurl").val();

      if($('#login-form').parsley().validate()==false) return;
        
      var form_data = $('#login-form').serialize();   

      if($('#login-form').parsley().isValid() == true )
      {         
         $.ajax({
            url:SITE_URL+'/process_login',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            { 
                showProcessingOverlay();
                $('#button_login').prop('disabled',true);
                $('#button_login').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {


              hideProcessingOverlay();
              $('#button_login').prop('disabled',false);
              $('#button_login').html('SIGN IN');


               if(typeof response =='object')
               {

                  if(response.status && response.status=="SUCCESS")
                  {
                    $("#login-form")[0].reset();

                     var success_HTML = '';
                     success_HTML +='<div class="alert alert-success alert-dismissible">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>'+response.message+'</div>';

                        $('#status_msg').html(success_HTML);
                       
                       
                        if(response.user_redirection=='-1')
                        {
                          
                        
                          var segments = urls.split( '/' );
                          if(segments[2]!="" && segments[2]=="getnada.com")
                          { 

                               if(hidden_productid!='bG9jYXRpb24')
                               {  

                                   add_to_cart(hidden_productid);
                                 // setTimeout(function(){
                                 //   window.location.href="<?php echo e(url('/')); ?>";
                                 // },1000);
                                  window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/profile"  },1000);
                               }
                               else if(hidden_productid=='bG9jYXRpb24')
                               {  

                                window.setTimeout(function(){ location.href = urls },1000);
                               }
                               else{

                                   //window.location.href="<?php echo e(url('/')); ?>";
                                    window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/profile"  },1000);
                               }
                              
                              
                          }
                          else
                          { 


                              if(hidden_productid!='bG9jYXRpb24'){

                                  add_to_cart(hidden_productid);
                                 // window.setTimeout(function(){ location.href = urls },1000);
                                 window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/profile"  },1000);

                              }
                               else if(hidden_productid=='bG9jYXRpb24')
                               {  
                                window.setTimeout(function(){ location.href = urls },1000);
                               }
                              else{

                                // window.setTimeout(function(){ location.href = urls },1000);
                                  window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/profile"  },1000);
                              }

                            

                          }//else

                              if(hidden_buyerageurl!='')
                              {
                                
                                 window.setTimeout(function(){ location.href = hidden_buyerageurl },1000);

                              }

                              if(hidden_buyagainurl!='')
                              {
                                  window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/review-ratings" },1000);
                              }


                        }//if user redirection 
                        else if(response.user_redirection=='-2')
                        {
                         
                           if(hidden_productid!='bG9jYXRpb24'){  
                                 add_to_cart(hidden_productid);
                                 window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/profile" },1000);

                                 // window.setTimeout(function(){ 
                                 //   location.href = "<?php echo e(url('/')); ?>";
                                 //    },1000);
                               
                           }
                            else if(hidden_productid=='bG9jYXRpb24')
                               {  
                                window.setTimeout(function(){ location.href = urls },1000);
                               //window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/profile" },1000);
   
                               }
                           else{
                                window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/profile" },1000);
                              // window.setTimeout(function(){ location.href = urls },2000);
                           }

                              if(hidden_buyerageurl!='')
                              {
                                
                                 window.setTimeout(function(){ location.href = hidden_buyerageurl },1000);

                              }
                             if(hidden_buyagainurl!='')
                              {
                                  window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/buyer/review-ratings" },1000);
                              }
                           
                        }
                        else
                        {

                          if(hidden_forumurl!='' && hidden_forumurl=="forum")
                          {
                             window.setTimeout(function(){ location.href = "<?php echo e(url('/')); ?>/forum" },1000);

                          }else{
                              window.setTimeout(function(){ location.href = response.user_redirection },1000);
                          }
                        
 
                        }//else
                   //  window.setTimeout(function(){ location.href = response.user_redirection },1000);



                  }
                  else if(response.status && response.status=="Warning")
                  {
                      //$("#myModal-OTP").modal('show');

                      $("#otp-div").show();
                      $("#otp_msg").show();
                     
                      var html = '';
                      html+= '<div class="alert alert-success">OTP has sent on your mobile number and email id.</div>';

                       $("#otp_msg").append(html);



                      $("#otp").attr('data-parsley-required','true');
                      $("#otp").attr('data-parsley-required-message','Please enter otp');
                      $("#otp").attr('data-parsley-type','digits');
                      $("#otp").attr('data-parsley-type-message','Only digits are allowed');

                      $("#email-div").hide();
                      $("#password-div").hide();

                      $("#user_email").removeAttr('data-parsley-required');
                      $("#user_email").removeAttr('data-parsley-required-message');
              
                      $("#user_password").removeAttr('data-parsley-required');
                      $("#user_password").removeAttr('data-parsley-required-message');
                      

                  }
                  else
                  {                    
                   
                      var error_HTML = '';   
                      if(response.message){
                         error_HTML+='<div class="alert alert-danger alert-dismissible">\
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>'+response.message+'</div>';
                        
                         $('#status_msg').html(error_HTML);
                         setInterval('autoRefresh()', 2000);
                     }// if msg
                  }
               }
            }
         });
      }
  });

    function autoRefresh()
    {
        window.location = window.location.href;
    }
   


  // Forgot password
    $('#btn-forgot-password').click(function(){

        if($('#frm-forgot-password').parsley().validate()==false) return;

        var form_data = $('#frm-forgot-password').serialize();
        $.ajax({
          url:SITE_URL+'/forgot_password',
          data:form_data,
          method:'POST',        
          dataType:'json',
          beforeSend : function()
          {
            showProcessingOverlay();
            $('#btn-forgot-password').prop('disabled',true);
            $('#btn-forgot-password').html('Please Wait... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
          },
          success:function(response)
          {
            hideProcessingOverlay();
            $('#btn-forgot-password').prop('disabled',false);
            $('#btn-forgot-password').html('Submit');

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
                      $('#ForgotPasswordModal').modal('hide');
              }
              else
              {                    
                  var error_HTML = '';   
                  error_HTML+='<div class="alert alert-danger alert-dismissible">\
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                      </button>'+response.message+'</div>';
                  $('#ForgotPasswordModal').modal('hide');
                  $('#status_msg').html(error_HTML);
              }
            }
          }
        });
    });
</script>
<!-- Facebook Pixel Code -->

<!-- <script>



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
   
    
    
</div>
<div class="copyright-block"> 
            <i class="fa fa-copyright"></i> <?php echo e(config('app.project.footer_link_year')); ?>   <a href="<?php echo e(url('/')); ?>"><?php echo e(config('app.project.footer_link')); ?></a>, Inc.   
            <?php 
                $staticms = $href='';  
            ?>

             <?php if(!empty($cms_terms_privacy_arr) && count($cms_terms_privacy_arr)>0): ?>
                 <?php $__currentLoopData = $cms_terms_privacy_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cms_terms_privacy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                      
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
                       else if($cms_terms_privacy->page_slug=="partner-with-chow")
                      {
                        $staticms = strip_tags($cms_terms_privacy->page_desc);
                        $staticms = str_replace('&nbsp;', '', $staticms);
                        $href= $staticms ;
                      }

                    ?>  
                    <a href="<?php echo e($href); ?>" class="terms-links terms-links-footer" target="_blank"><?php echo e($cms_terms_privacy->page_title); ?></a> 
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
              <?php endif; ?>  
 

           

             <a href="<?php echo e(url('/')); ?>/helpcenter" class="terms-links terms-links-footer">Help Center</a> 

             
              <div class="socail-chow">
                      <a href="<?php echo e(isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:''); ?>" target="_blank">
                          <img width="30px" src="<?php echo e(url('/')); ?>/assets/front/images/facebook-icon-n1.png" alt="" />
                      </a>
                      <a href="<?php echo e(isset($site_setting_arr['youtube_url'])?$site_setting_arr['youtube_url']:''); ?>" target="_blank">
                          <img width="30px" src="<?php echo e(url('/')); ?>/assets/front/images/youtube-icon-n2.png" alt="" />
                      </a>
                      <a href="<?php echo e(isset($site_setting_arr['twitter_url'])?$site_setting_arr['twitter_url']:''); ?>" target="_blank">
                          <img width="30px" src="<?php echo e(url('/')); ?>/assets/front/images/twitter-icon-n3.png" alt="" />
                      </a>
                      
                      <a href="<?php echo e(isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:''); ?>" target="_blank">
                          <img width="30px" src="<?php echo e(url('/')); ?>/assets/front/images/instagram-icon-n5.png" alt="" />
                      </a>

                      <?php if(isset($site_setting_arr['tiktok_url']) && !empty($site_setting_arr['tiktok_url'])): ?>
                       <a href="<?php echo e(isset($site_setting_arr['tiktok_url'])?$site_setting_arr['tiktok_url']:''); ?>" target="_blank">
                          <img  width="30px" src="<?php echo e(url('/')); ?>/assets/front/images/tiktok-icon.png" alt="" />
                      </a>
                      <?php endif; ?>

                    </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="myModal-OTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog otp-dialog" role="document">
    <div class="modal-content otpmodalset">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <div id="error_message"></div>

        <div class="titlemodal-mdl">OTP</div>
        <div class="subtitle-mdl">A One-Time Password has been sent to your phone number</div>
      </div>
      <form id="otp-form">
        <?php echo e(csrf_field()); ?>

      <div class="modal-body">
         <div class="otp-main-div-login">
           <input type="text" id="otp" name="otp" data-parsley-required="true" data-parsley-required-message="Please enter otp" data-parsley-type="digits"  data-parsley-type-message="Only digits are alowed"/>
           
         </div>
         <div class="validate-button">
           <a class="btn-validate-txt" href="javascript:void(0)" id="btn_validate_otp" name="btn_validate_otp" onclick="verifyOTP();">Validate</a>
         </div>
      </div>
    </form>
      
    </div>
  </div>
</div>


<script type="text/javascript">
   $(document).ready(function(){
          var guest_url = "<?php echo e(url('/')); ?>";
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
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.js"></script>

<!-- data table js-->
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>
    
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/listing.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/customjs.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/bootstrap.min.js"></script>


<script type="text/javascript">


      var guest_url = "<?php echo e(url('/')); ?>";

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

</script>

<script>

  
  setInterval(function(){ 
    $.ajax({
      url:'<?php echo e(url('/')); ?>'+'/check_loginattempt/verify_loginattemptfront',            
      data:{
        checkstat:1,              
      },
      dataType:'json',
      success:function(response)
      { 
          
      }  
    });
  }, 1000);
  // END Check Buyer Cart Product, Whether every possible status of the product is active or deactive 
</script>

<!--------function to add to cart------------->
<script>
  
  function add_to_cart(productid) {

    if(productid && productid!='forum' && productid!='buy'){
    
    var id   = productid;
    var quantity = 1;
    var csrf_token = "<?php echo e(csrf_token()); ?>";

    
    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){  
           // $(ref).attr('disabled');          
           // $(ref).html('Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i>');
          },
          success:function(response)
          {   
            
           // $(ref).html('Add to Cart');
            if(response.status == 'SUCCESS')
            {               
              window.location.href = SITE_URL+'/my_bag';              
            }
            else
            {                
              
              $("#qtyerr").css('color','red').html(response.description);
            }  
          }  

      });

    }//if productid 
  }//add item


var SITE_URL ="<?php echo e(url('/')); ?>";

function verifyOTP()
{
    if($('#otp-form').parsley().validate()==false) return;

        var form_data = $('#otp-form').serialize();

        if($('#otp-form').parsley().isValid() == true )
        {
          var email    = $("#user_email").val();
          var password = $("#user_password").val();
          var otp      = $("#otp").val();

          var csrf_token = "<?php echo e(csrf_token()); ?>";


          $.ajax({
            url:SITE_URL+'/otp_verification',
            data: {otp:otp,email:email,password:password,_token:csrf_token},     
            method:'POST',
            beforeSend : function()
            {
              showProcessingOverlay();
              
            },
            success:function(response)
            {
              hideProcessingOverlay();

                if(response.status == 'SUCCESS')
                {               
                    //window.location.href = response.user_redirection;

                    $( "#login-form" ).submit();              
                }
                else
                {                
                    $("#error_message").css('color','red').html(response.message);
                    return false;
                }  
             
            }//end of success
          });
        }//if validation true
 
}




</script>


<!---Google analytics-footer------>
<?php
if(isset($site_setting_arr['pixelcode2']) && !empty($site_setting_arr['pixelcode2'])) {
  echo $site_setting_arr['pixelcode2'];
}
?>

</body>
</html>