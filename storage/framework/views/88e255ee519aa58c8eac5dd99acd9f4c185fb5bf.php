<!DOCTYPE html>
<html>
<style>
.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, 
.bootstrap-iso form{color: black}
.bootstrap-iso form button,
.bootstrap-iso form button:hover{color: white !important;}
.asteriskField{color: red;}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
    border: 1px solid #fff !important;
    background: #ffffff;
    font-weight: normal;
    color: #454545 !important;
}
.ui-datepicker td span, .ui-datepicker td a {
    padding: 0.4em .2em;
}
.userdetaild-modal{margin-top: 25%;}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active,
a.ui-button:active,
.ui-button:active,
.ui-button.ui-state-active:hover {
  border: 1px solid #873dc8 !important;
  background: #873dc8 !important;
  font-weight: normal;
  color: #ffffff !important; border-radius: 4px;
}
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
  padding: 2px 5px;
}
.ui-datepicker .ui-datepicker-next {
    right: 1px;
}
.ui-datepicker .ui-datepicker-prev {
    left: 1px;
}
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next {
    top: 1px;
}

/*css added for making h3 to h1*/
.login-20 .form-section h1 {
    font-size: 22px;
    margin-bottom: 40px;
    font-weight: 400;
    color: #222;
}
</style>

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
    <meta name="description" content="<?php echo e(isset($site_setting_arr['meta_desc'])?$site_setting_arr['meta_desc']:''); ?>" />
    <meta name="keywords" content="<?php echo e(isset($site_setting_arr['meta_keyword'])?$site_setting_arr['meta_keyword']:''); ?>" />
    <meta name="author" content="" />
   
   <title>Start buying the best hemp CBD derived products right here</title>
    <!-- ======================================================================== -->
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(url('/')); ?>/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--Custom Css-->
    <link href="<?php echo e(url('/')); ?>/assets/front/css/sellersignup-css.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.css" rel="stylesheet">
    <link href="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.css" rel="stylesheet">
 
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




   <!--Main JS-->
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/front/js/jquery-1.11.3.min.js"></script>

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

  
<?php
    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }



 if(isset($referal_code) && !empty($referal_code))
 {
   $referal_code = $referal_code;
 }
 else
 {
   $referal_code='';

 }

 if(isset($refered_email) && !empty($refered_email))
 {
   $refered_email = base64_decode($refered_email);
 }else
 {
   $refered_email='';
 }
 //echo"=====".$referal_code."----".$refered_email;

?> 

<div class="login-20">
    <div class="container">
      <div class="row">
        <div class="hidden-overflow">
            
           

              <div class="col-xl-6 col-lg-6 col-md-6 bg-img rw-signup rw-buyer-signup" >
                <div class="info">
                    <div class="logo-seller-lgns">
                        <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(url('/')); ?>/assets/front/images/chowlogos-white.png" alt="Logo" /></a>
                    </div>
                     <!-- <div class="sell-chow-signup">Shop from the best CBD stores and brands</div> -->
                     <div class="sell-chow-signup">The compliant way to buy CBD online</div>
                     <ul class="list-sellersignupleft">
                         <li><img src="<?php echo e(url('/')); ?>/assets/front/images/check-sellers-icn-whites.png" alt="Trust the CBD products you buy" /> Trust the CBD products you buy</li>
                         <li><img src="<?php echo e(url('/')); ?>/assets/front/images/check-sellers-icn-whites.png" alt="Comply with your state CBD laws" /> Comply with your state CBD laws</li>
                         <li><img src="<?php echo e(url('/')); ?>/assets/front/images/check-sellers-icn-whites.png" alt="Review the certificate of analysis of products" /> Review the certificate of analysis of products</li>
                         <li><img src="<?php echo e(url('/')); ?>/assets/front/images/check-sellers-icn-whites.png" alt="Interact with retailers and ask questions" /> Interact with retailers and ask questions</li>
                         <li><img src="<?php echo e(url('/')); ?>/assets/front/images/check-sellers-icn-whites.png" alt="Share and review products you’ve purchased" /> Share and review products you’ve purchased</li>
                     </ul>
                </div>
                
            </div>


            <div class="col-xl-6 col-lg-6 col-md-6  bg-color-10">
                
                <!-- step 1 Start -->
                <div class="form-section">
                    
                    
                    <h1><b>Create Buyer Account</b></h1>
                    <div class="login-inner-form">
                       <div id="status_msg"></div>
                        <?php echo $__env->make('front.layout.flash_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php if(Session::has('message')): ?>
                    
                            <p class="alert <?php echo e(Session::get('alert-class', 'alert-warning')); ?>" id ="alert_container">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-times" aria-hidden="true" class="close" data-dismiss="alert" aria-label="close"></i>
                                </a><?php echo Session::get('message'); ?>

                            </p>

                        <?php endif; ?> 

                        <?php 
                            if(isset($productid))
                            {
                              $productid = $productid;
                            }else{
                              $productid ='';
                            }
                        ?>


                        <form id="signup-form">
                          <?php echo e(csrf_field()); ?>


                          

                          <input type="hidden" name="refered_email" id="refered_email" value="<?php echo e($refered_email); ?>">
                          <input type="hidden" name="referal_code" id="referal_code" value="<?php echo e($referal_code); ?>">


                           <input type="hidden" name="hidden_productid" id="hidden_productid" value="<?php echo e($productid); ?>">


                             <input type="hidden" name="role" id="role" value="buyer">

                            <div class="form-group form-box">
                                <input type="email" name="email" id="email" class="input-text" placeholder="Email Address" data-parsley-required="true" data-parsley-type="email" data-parsley-type-message="Please enter valid email address" value="<?php echo e(isset($email) ? $email : ''); ?>" data-parsley-required-message="Please enter email"/>
                                <div id="user_exist_error_message"></div>
                                <div class="clearfix"></div>
                            </div> 
                            <div class="form-group form-box passwords-error">
                                <input type="password" name="password" class="input-text" placeholder="Password" data-parsley-errors-container=".passworderror"  data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character" data-parsley-minlength="8" name="password" id="password" data-parsley-required-message="Please enter password" />
                                 <div class="passworderror" id="password_error_message"></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group form-box">
                                <input type="password" name="confirm_password" class="input-text"  id="confirm_password" placeholder="Confirm Password" data-parsley-required="true" data-parsley-required-message="Please enter confirm password" data-parsley-equalto="#password" data-parsley-equalto-message="Confirm password and password should be the same"/>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">

                                  <div class="form-group form-box">
                                      <div class="select-style">

                                        <?php
                                            $country_id = isset($user_details_arr['country'])?$user_details_arr['country']:0;
                                        ?>


                                         <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select country" id="country" name="country" onchange="get_states()">

                                        <?php if(isset($countries_arr) && count($countries_arr)>0): ?>
                                        <option value="">Select Country</option>
                                        <?php $__currentLoopData = $countries_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option  <?php if($country['id']==$country_id): ?> selected="selected" <?php endif; ?> value="<?php echo e($country['id']); ?>"><?php echo e(isset($country['name'])?ucfirst(strtolower($country['name'])):'--'); ?></option>                                        
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <option>Countries Not Available</option>
                                        <?php endif; ?>
                                        </select> 
                                        </div>
                                        
                                         <div class="countryerror" id="country_error_message"></div>
                                         <div class="clearfix"></div>
                                  </div>

                                </div>
                                <div class="col-md-6">
                                  <div class="form-group form-box">
                                      <div class="select-style">
                                          <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state " id="state" name="state">                                        
                                            <option value="">Select State</option>                                                                                
                                        </select> 
                                      </div>

                                      <div class="stateerror" id="state_error_message"></div>
                                      <div class="clearfix"></div>

                                  </div>
                                </div>
                            </div>

                         

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group form-box">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"> </i>
                                  </div>
                                  <input class="input-text" id="date" onchange="age_calculation(this)" onkeypress="return validateNumberAndForwardSlash(event);" autocomplete="off" name="date_of_birth"data-parsley-required="true" data-parsley-required-message="Please enter Date of birth"  placeholder="DOB - MM/DD/YYYY" type="text"/>   
                                  <div class="countryerror"></div>
                                  <div class="clearfix"></div>
                                  <ul class="parsley-errors-list filled" id="parsley-id-5">
                                    <li  class="parsley-required" id="age_error"> </li>
                                  </ul>
                                 <div class="stateerror" id="age_error_message"></div>
                                </div>

                              </div>
                              <div class="col-md-6">
                                <div class="form-group form-box">
                                  
                                  <div class="select-style">
                                    <select name="hear_about" id="hear_about"  class="frm-select"  data-parsley-required="true" data-parsley-required-message="Please select how did you hear about us">
                                      <option value="">How did you hear about us</option>
                                      <option value="Search Engine">Search Engine</option>
                                      <option value="Social Media">Social Media</option>
                                      <option value="Press or News">Press or News</option>
                                      <option value="TV">TV</option>
                                      <option value="Podcast or Radio">Podcast or Radio</option>
                                      <option value="In the Mail">In the Mail</option>
                                      <option value="ChowPods/Chow Machine">ChowPods/Chow Machine</option>
                                      <option value="Other">Other</option>
                                    </select>
                                  </div>
                                  <div id="hear_error_message"></div>
                                  <div class="clearfix"></div>
                                </div>
                              </div>
                            </div>







                           <!--  <div class="form-group form-box">
                              <div class="checkbox clearfix">
                                  <div class="form-check checkbox-theme">
                                      <input class="form-check-input" type="checkbox" value="" checked id="rememberMe" data-parsley-required="true" data-parsley-required-message="Please accept terms and conditions">
                                      <label class="form-check-label" for="rememberMe"> I Accept <a href="<?php echo e($terms_condition_url); ?>" target="_blank"> Terms and Conditions <span class="asteric_mark">*</span></a></label>
                                  </div>
                              </div>
                           </div>

                             <div class="form-group form-box">
                              <div class="checkbox clearfix">
                                  <div class="form-check checkbox-theme rw-checkbox-theme-age-verification">
                                      <input class="form-check-input" type="checkbox" value="" checked id="ageverfication" data-parsley-required="true" data-parsley-required-message="Please accept age verification term">
                                      <label class="form-check-label" for="ageverfication"> By registering on Chow420, I hereby represent that I am over 21 years of age and agree to be age verified.<span class="asteric_mark">*</span></label>
                                  </div>
                              </div>
                           </div> -->

                           <div class="form-group form-box">
                              <div class="checkbox clearfix">
                                  <div class="form-check checkbox-theme rw-checkbox-theme-age-verification">
                                      <input class="form-check-input" type="checkbox" value="" checked id="ageverfication" data-parsley-required="true" data-parsley-required-message="Please accept age verification term">
                                      <label class="form-check-label" for="ageverfication"> You must be (21) years or older to use this website and to purchase goods or services on this website . If you are under (21) years of age, you are not permitted to access this website for any reason. <u><b>By clicking this box, you represent that you are  twenty-one (21) years or older.</b></u><span class="asteric_mark">*</span></label>
                                  </div>
                              </div>
                           </div>
                          <!--  <div class="form-group form-box">
                              <div class="checkbox clearfix">
                                  <div class="form-check checkbox-theme rw-checkbox-theme-age-verification">
                                      <input class="form-check-input" type="checkbox" value="" checked id="purchaseproduct" data-parsley-required="true" data-parsley-required-message="Please accept this term">
                                      <label class="form-check-label" for="purchaseproduct"> Prior to purchasing any product(s) on this website, you agree to verify the legality of products on Chow in the jurisdiction where you requested shipment. We shall not be responsible for any liability arising from the alleged illegality of products sold to you on this website. <u><b>By clicking this box, you represent that you have verified the legality of our products in the jusrisdiction where you request shipment.</b></u><span class="asteric_mark">*</span></label>
                                  </div>
                              </div>
                           </div> -->

                           <div class="form-group form-box">
                              <div class="checkbox clearfix">
                                  <div class="form-check checkbox-theme rw-checkbox-theme-age-verification">
                                      <input class="form-check-input" type="checkbox" value="" checked id="terms" data-parsley-required="true" data-parsley-required-message="Please accept terms & conditions">
                                      <label class="form-check-label" for="terms"> By clicking this box, you represent that you have read and agree to our <u><b><a href="<?php echo e(url('/')); ?>/terms-conditions" class="pull-left" target="_blank">Terms and Conditions</b></u></a><span class="asteric_mark">.*</span></label>
                                  </div>
                              </div>
                           </div>

                           <div class="form-group form-box">
                              <div class="checkbox clearfix">
                                  <div class="form-check checkbox-theme rw-checkbox-theme-age-verification">
                                      <input class="form-check-input" type="checkbox" value="" checked id="privacyterms" data-parsley-required="true" data-parsley-required-message="Please accept privacy terms">
                                      <label class="form-check-label" for="privacyterms"> By clicking this box, you represent that you have read and agree to our <u><b><a href="<?php echo e(url('/')); ?>/privacy-policy" class="pull-left" target="_blank">Privacy Policy</b></u></a><span class="asteric_mark">.*</span></label>
                                  </div>
                              </div>
                           </div>

                            <div class="buttonsection-bottom">
                                <a href="<?php echo e(url('/')); ?>" class="btn-md btn-theme backbtn-prv">Back</a>
                                <a href="#" class="btn-md btn-theme next-right" id="btn-sign-up">Sign Up</a>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                    <p>Already have an Account? <a href="<?php echo e(url('/').'/login'); ?>" class="thembo">Sign In</a></p>
                </div>
                <!-- step 1 End -->
              

            </div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.min.js"></script>
<script type="text/javascript">
  
  $('#btn-sign-up').click(function(){

    if($('#signup-form').parsley().validate()==false) return;

        var date_of_birth = document.getElementById("date").value;

        var split_dob = date_of_birth.split("/");

        var month = split_dob[0];
        var date  = split_dob[1];
        var year  = split_dob[2];

        var date1 = new Date();
        var date2 = new Date(""+month+"/"+date+"/ "+year+""); 

        var Difference_In_Time = date1.getTime() - date2.getTime(); 
          
        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 

        if (Difference_In_Days < 7671) { // days in 21 years

          document.getElementById("age_error").innerHTML = "You must be 21+ and above to use chow420";

          event.preventDefault();
          return false;
        }
        else {

          document.getElementById("age_error").innerHTML = "";
        }

        
        var form_data = $('#signup-form').serialize();      

        if($('#signup-form').parsley().isValid() == true )
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
             
              hideProcessingOverlay();
              $('#btn-sign-up').prop('disabled',false);
              $('#btn-sign-up').html('SIGN UP');

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                    $("#signup-form")[0].reset();
                    $('#user_exist_error_message').html('');

                    

                    

                   // swal('Success!', response.msg, 'success');
                     
                   //   window.location.href = SITE_URL+'/welcome';
                  //  window.location.href = SITE_URL+'/login/1/'+btoa(email);
                 
                  // window.location.href = SITE_URL+'/activationcode/'+btoa(email);
                    window.location.href = SITE_URL+'/activationcode';
 
                }
                else if(response.status="ERROR")
                {
                    if(response.password_msg!=""){
                        $('#password_error_message').css('color','red').html(response.password_msg);
                    }else{
                        $('#password_error_message').html('');
                    }   

                    if(response.msg!=""){
                        $('#user_exist_error_message').css('color','red').html(response.msg);
                    }else{
                        $('#user_exist_error_message').html('');    
                    }

                    if(response.countrymsg!=""){
                    $('#country_error_message').css('color','red').html(response.countrymsg);
                    }
                    else{
                    $('#country_error_message').html('');
                    }

                    if(response.statemsg!=""){
                    $('#state_error_message').css('color','red').html(response.statemsg);
                    }
                    else{
                    $('#state_error_message').html('');
                    }

                    if(response.age_msg!=""){
                    $('#age_error_message').css('color','red').html(response.age_msg);
                    }
                    else{
                    $('#age_error_message').html('');
                    }

                     
                }
                // else if(response.status=="ERROR" && response.msg!="")
                // {
                       
                //     

                //     // $('#user_exist_error_message').css('color','red').html(response.msg).fadeOut(7000);
                //     $('#user_exist_error_message').css('color','red').html(response.msg);

                // }//else
                

              }// end of if type object           
            }//end of success
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

<!-- <script>



<!-- End Facebook Pixel Code -->





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
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.js"></script>
   
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/bootstrap.min.js"></script>


<!---Google analytics-footer------>
<?php
if(isset($site_setting_arr['pixelcode2']) && !empty($site_setting_arr['pixelcode2'])) {
  echo $site_setting_arr['pixelcode2'];
}
?>

<!--- -------------------------------------------- DATAPICKER -------------------------------------------- ------>




<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '1950:2020'
    });
  } );
  </script>

<!--- -------------------------------------------- DATAPICKER -------------------------------------------- ------>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
  function age_calculation(ref) { 

    var list = document.getElementById("parsley-id-15");

    /*REMOVE EXISTING VALIDATION MSG*/

    var ul = document.querySelector('#parsley-id-15');

    if (ul) {

      var listLength = ul.children.length;

      if (list) {

        for (i = 0; i < listLength; i++) {
          list.removeChild(list.childNodes[0]);  
        }
      }
    }
    
    /*REMOVE EXISTING VALIDATION MSG*/

    var split_dob = ref.value.split("/");

    var month = split_dob[0];
    var date = split_dob[1];
    var year = split_dob[2];

    var date1 = new Date();
    var date2 = new Date(""+month+"/"+date+"/ "+year+""); 

    var Difference_In_Time = date1.getTime() - date2.getTime(); 
      
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 

    if (Difference_In_Days < 7671) { // days in 21 years

      document.getElementById("age_error").innerHTML = "You must be 21+ and above to use chow420";
    }
    else {

      document.getElementById("age_error").innerHTML = "";
    }
  }

  function validateNumberAndForwardSlash(event) {

    var key = window.event ? event.keyCode : event.which;

    if (event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 47) {

      return true;
    } 
    else {
      return false;
    }
  };

</script>
</body>
</html>

