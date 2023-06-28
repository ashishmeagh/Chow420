<!DOCTYPE html>
<html lang="en">


@php    

    if(isset($site_setting_arr['site_name']))
    {
      $meta_project_name = $site_setting_arr['site_name'];
    }
    else
    {
      $meta_project_name = config("app.project.name");
    }

@endphp


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- {{-- <link rel="icon" type="image/png" sizes="16x16" href="../assets/admin/plugins/images/favicon.png"> --}} -->
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/images/faviconnew.ico"> -->
   {{--  <title>{{$page_title or ''}}-{{config('app.project.name')}}</title> --}}

    <title>{{$page_title or ''}} | {{ $meta_project_name or "" }}</title>


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
    <!-- Menu CSS -->
    <link href="{{url('/')}}/assets/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{url('/')}}/assets/admin/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    {{-- <link href="{{url('/')}}/assets/admin/plugins/bower_components/morrisjs/morris.css" rel="stylesheet"> --}}
    <!-- animation CSS -->
    <link href="{{url('/')}}/assets/admin/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('/')}}/assets/admin/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{url('/')}}/assets/admin/css/colors/blue.css" id="theme" rel="stylesheet">

    <link href="{{url('/')}}/assets/common/sweetalert/sweetalert.css" rel="stylesheet">

    <link href="{{url('/')}}/assets/admin/js/Parsley/dist/parsley.css" rel="stylesheet">

    <link href="{{url('/')}}/assets/admin/css/custom.css" rel="stylesheet">

    <!-- switechery css-->
    <link href="{{url('/')}}/assets/admin/plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />

    <!-- Datepicker css-->
    <link href="{{url('/')}}/assets/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
   
   
    <script type="text/javascript" src="{{url('/')}}/assets/admin/js/jquery.min.js"></script>

    <!--Datepicker js-->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    
    <!-- Dropify -->
    <link rel="stylesheet" href="{{url('/')}}/assets/admin/plugins/bower_components/dropify/dist/css/dropify.min.css">
   <script src="{{url('/')}}/assets/buyer/js/responsivetabs.js"></script>
   <link href="{{url('/')}}/assets/buyer/css/jquery.mCustomScrollbar.css" rel="stylesheet">

{{--    <script src="https://cdn.lr-ingest.io/LogRocket.min.js" crossorigin="anonymous"></script>
   <script>window.LogRocket && window.LogRocket.init('a4czv7/chow420');</script>
   --}}
        @if(Sentinel::check())
          @php
            $user = Sentinel::getUser();
          @endphp
          {{-- <script type="text/javascript">
            LogRocket.identify('{{ $user->id or '--'}}', {
              name: '{{ $user->first_name or '--'}} {{ $user->last_name or '--'}}',
              email: '{{ $user->email or '--'}}',
              // Add your own custom user variables here, ie:
              subscriptionType: 'None'
            });
          </script> --}}
        @endif




   <!---------------tinymce script added-------------------------->
   
   <script src="https://cdn.tiny.cloud/1/4ey986qzaoq9vyzd2ouqnt51bxz71u6o75m7hcrnnzoffekm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
   {{-- <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });
   </script> --}}
   <!---------------tinymce script added-------------------------->

</head>

<body>

   
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">

