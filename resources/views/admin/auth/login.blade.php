<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/images/faviconnew.ico"> -->
    <title>Login - {{config('app.project.name')}}</title>
    
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

    <!-- Bootstrap Core CSS -->
    <link href="{{url('/')}}/assets/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/admin/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{url('/')}}/assets/admin/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('/')}}/assets/admin/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{url('/')}}/assets/admin/css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- Parsley css-->
    <link href="{{url('/')}}/assets/admin/js/Parsley/dist/parsley.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .setbtnclr{
        background-color: #873dc8;
    }
    .setbtnclr:hover {
       background-color: #873dc8;
    }
</style>
</head>

<body>
    <!-- Preloader -->

@php
    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }
@endphp  


    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
             <form class="form-horizontal form-material" id="loginform" action="{{ url(config('app.project.admin_panel_slug').'/process_login') }}" method="POST" id="loginform">
               
                    @include('admin.layout._operation_status')  
                 
                 {{ csrf_field() }}
                 <div class="lgo-admin">

                   
                    <img src="{{$sitelogo}}" alt="Login" />


                     {{-- <img src="{{url('/')}}/assets/images/chow-logo.png" alt=""> --}}
                 </div>
                    <h3 class="box-title m-b-20">Sign In</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" value="{{isset($_COOKIE["email"])?$_COOKIE["email"]:''}}" name="email" data-parsley-required="true" data-parsley-type="email" placeholder="Enter email" data-parsley-required-message="Please enter email">
                             <span class="red">{{ $errors->first('email') }} </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                          
                            <input type="password" name="password" data-parsley-required="true" placeholder="Enter password" data-parsley-minlength="6" data-parsley-maxlength="16"  class="form-control" value="{{isset($_COOKIE['password'])?$_COOKIE['password']:''}}" data-parsley-required-message="Please enter password">
                            <span class="red">{{ $errors->first('password') }} </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox" @if(isset($_COOKIE["rememberd"])&& $_COOKIE["rememberd"]=='rememberd') checked="checked" @endif name="remember_me">
                                <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot Password?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                   
                    
                </form>
                <form class="form-horizontal" method="post" id="recoverform" action="{{ url($admin_panel_slug.'/process_forgot_password') }}">
                    {{ csrf_field() }}
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="lgo-admin">
                              <img src="{{$sitelogo}}" alt="Login" />
                               {{-- <img src="{{url('/')}}/assets/images/chow-logo.png" alt=""> --}}
                         </div>
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" data-parsley-required="true" data-parsley-type="email" placeholder="Enter email" data-parsley-required-message="Please enter your email address." data-parsley-type-message="Email must be in a valid email format (e.g. username@coolexample.com), please try again.">
                            <span class="red" style="color:red">{{$errors->first('email')}}</span>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light setbtnclr" type="submit">Reset</button>
                            <button class="btn btn-light btn-lg btn-block text-uppercase waves-effect waves-light back_btn">Back</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{url('/')}}/assets/admin/bootstrap/dist/js/tether.min.js"></script>
    <script src="{{url('/')}}/assets/admin/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="{{url('/')}}/assets/admin/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{url('/')}}/assets/admin/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{url('/')}}/assets/admin/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!--Parsley js-->
    <script type="text/javascript" src="{{url('/')}}/assets/admin/js/Parsley/dist/parsley.min.js"></script>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function(){
    $('#loginform').parsley();
    $('#recoverform').parsley();
   
  });

  $('.back_btn').on('click',function(){
    $('#recoverform').css("display", "none");
    $("#loginform").css("display", "block");
  });
</script>

<script>

  
  setInterval(function(){ 
    $.ajax({
      url:'{{url('/')}}'+'/check_loginattempt/verify_loginattempt',            
      data:{
        checkstat:1,              
      },
      dataType:'json',
      success:function(response)
      { 
          
      }  
    });
  }, 5000);
  // END Check Buyer Cart Product, Whether every possible status of the product is active or deactive 
</script>