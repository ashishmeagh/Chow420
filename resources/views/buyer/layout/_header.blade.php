
<!DOCTYPE html>

<html class="openNav">


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

<!---Google analytics-header------>
@php
if(isset($site_setting_arr['pixelcode']) && !empty($site_setting_arr['pixelcode'])) {
  echo $site_setting_arr['pixelcode'];
}
@endphp
  

<!-- Google Tag Manager -->
{{-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KQJTL5N');</script> --}}
<!-- End Google Tag Manager -->

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
   {{--  <title>{{isset($page_title)?$page_title:""}} : {{ config('app.project.name') }}</title> --}}

    <title>{{isset($page_title)?$page_title:""}} | {{ $meta_project_name or "" }}</title>


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
    <link href="{{url('/')}}/assets/buyer/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--font-awesome-css-start-here-->
    <link href="{{url('/')}}/assets/buyer/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--Custom Css-->
    <link href="{{url('/')}}/assets/buyer/css/chow.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/')}}/assets/buyer/css/afterlogin-css.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/')}}/assets/common/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/buyer/css/jquery.mCustomScrollbar.css" rel="stylesheet" />



    
    <!--Main JS-->
    <script type="text/javascript" src="{{url('/')}}/assets/buyer/js/jquery-1.11.3.min.js"></script>
    <!--[if lt IE 9]>-->
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

        <!-- loader js -->
    <script type="text/javascript" src="{{url('/')}}/assets/buyer/js/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/assets/buyer/js/loader.js"></script>
   <script src="{{url('/')}}/assets/buyer/js/responsivetabs.js"></script>

    <script type="text/javascript"> 
      var SITE_URL = '{{url('/')}}';
    </script>

    {{-- <script src="https://cdn.lr-ingest.io/LogRocket.min.js" crossorigin="anonymous"></script>
    <script>window.LogRocket && window.LogRocket.init('a4czv7/chow420');</script> --}}

        
  
        @if(Sentinel::check())
          @php
            $user = Sentinel::getUser();
          @endphp
         {{--  <script type="text/javascript">
            LogRocket.identify('{{ $user->id or '--'}}', {
              name: '{{ $user->first_name or '--'}} {{ $user->last_name or '--'}}',
              email: '{{ $user->email or '--'}}',
              // Add your own custom user variables here, ie:
              subscriptionType: 'None'
            });
          </script> --}}
        @endif
        <style type="text/css">

.notify {
    position: relative;
}
.notify .heartbit {
    position: absolute;
    top: -32px;
    left: 14px;
    height: 25px;
    width: 25px;
    z-index: 10;
    border: 5px solid #873dc8;
    border-radius: 70px;
    -moz-animation: heartbit 1s ease-out;
    -moz-animation-iteration-count: infinite;
    -o-animation: heartbit 1s ease-out;
    -o-animation-iteration-count: infinite;
    -webkit-animation: heartbit 1s ease-out;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
}

.notify .point {
       width: 6px;
    height: 6px;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
    background-color: #873dc8;
    position: absolute;
    left: 23px;
    top: -23px;
}

@-moz-keyframes heartbit {
    0% {
        -moz-transform: scale(0);
        opacity: 0
    }
    25% {
        -moz-transform: scale(.1);
        opacity: .1
    }
    50% {
        -moz-transform: scale(.5);
        opacity: .3
    }
    75% {
        -moz-transform: scale(.8);
        opacity: .5
    }
    100% {
        -moz-transform: scale(1);
        opacity: 0
    }
}

@-webkit-keyframes heartbit {
    0% {
        -webkit-transform: scale(0);
        opacity: 0
    }
    25% {
        -webkit-transform: scale(.1);
        opacity: .1
    }
    50% {
        -webkit-transform: scale(.5);
        opacity: .3
    }
    75% {
        -webkit-transform: scale(.8);
        opacity: .5
    }
    100% {
        -webkit-transform: scale(1);
        opacity: 0
    }
}
.notification {
  position: relative;
}
.notification-menu {
      position: absolute;
    top: 50px;
    right: 0;
    background-color: #fff;
    padding: 20px;
    list-style: none;
    width: 250px;
    display: none;
    text-align: left;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 1px 0 #ccc;
    text-align: center;
    z-index: 9;
}

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



.h3-earn{
    font-size: 24px; font-weight: 600; color: #020202;margin: 10px 0;
}
.invitebtn-lnks-ab{
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
    width: 100% !important;
}
.invitebtn-lnks-ab:hover, .invitebtn-lnks-ab:focus{
    background-color: #020202;
    color: #fff; border: 1px solid #020202;
} 

.invite-p-drop {
    margin-bottom: 20px;
}
.icon-referal-abt-cw {
    width: 60px;
    margin: 0px auto 0;
}


.notification-menu:after{
    bottom: 100%;
    right: 10px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}

.notification-menu:after {
        border-color: rgba(136, 183, 213, 0);
    border-bottom-color: #ffffff;
    border-width: 13px;
    margin-left: 0;
}

 .seatch-header-seller-main {
        float: left;
        width: 42%;
        margin-top: 7px;
        margin-left: 10%;
    }
    .seatch-header-seller-left {
        position: relative;
        padding-right: 100px;
    }
    .seatch-header-seller-left input {
        width: 100%;
        height: 44px;
        padding: 10px;
        border: 1px solid #dedede;
        font-size: 13px;
    }
    .seatch-header-seller-left a {
        background-color: #873dc8;
        display: inline-block;
        padding: 7px 15px;
        position: absolute;
        right: 0;
        color: #f8d82a;
        font-size: 12px;
        line-height: 15px;
        border-radius: 2px; 
        text-align: center;
    }
    .referseller-link-v span {
        display: block;
        font-size: 15px;
        color: #fff;
    }


          .btnsubscribe:hover, .btnsubscribe:focus{background: #fff;
          border: 1px solid #222;
          color: #222;}
          .btnsubscribe {
          cursor: pointer;
          padding: 10px 5px 8px 5px;
          letter-spacing: 1px;
          font-size: 13px;
          font-weight: bold;
          text-shadow: none;
          border-radius: 3px;
          text-transform: uppercase;
          background: #222;
          border: 1px solid #222;
          color: #fff;
          display: block;
          width: 100%;
          line-height: 30px;
      }
.modal-dialog.dialogauto{
width: 620px;
    height: 620px;
    position: absolute;
    right: 0;
    bottom: 0;
    top: 0;
    left: 0;
    margin: auto;
    padding: 0;
}
.subscribe-title {
    font-size: 30px;
    margin-bottom: 32px;
    text-align: center;
    /* font-weight: 600; */
    line-height: 39px;
    /* text-transform: uppercase; */
    color: #873dc8;
}
.modal-dialog.dialogauto .modal-content {
    width: 620px;
    height: 620px;
    border-radius: 50%;
    padding: 10% 16% 14% 16%;
}
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


@media all and (max-width:767px){


.modal-dialog.dialogauto {
    width: 310px;
    height: 310px;
}
.modal-dialog.dialogauto .modal-content {
    width: 310px;
    height: 310px;
}
.userdetaild-modal {
    margin-top: 2%;
}
.subscribe-title {
    font-size: 20px;
    margin-bottom: 2px;
  }
  .btnsubscribe {
      cursor: pointer;
      padding: 7px 5px 5px 5px;
      letter-spacing: 1px;
      font-size: 12px;
      line-height: normal;
  }
}
        </style>
</head>

<body>

 
@php
if(isset($site_setting_arr['body_content']) && !empty($site_setting_arr['body_content'])) {
  echo $site_setting_arr['body_content'];
}
@endphp
 

  <div id="main"></div>
<!-- Google Tag Manager (noscript) -->
{{-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KQJTL5N"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> --}}
<!-- End Google Tag Manager (noscript) -->


    @php    
        $total_noti_cnt = 0;
        $login_user     = Sentinel::check(); 
        
        if($login_user == true)
        {
            $logUser_id     = $login_user->id;
            $total_noti_cnt = get_notifications_count($logUser_id);
        }
    @endphp   

<!-- After Login Header Start -->
 <div class="header-afterlogin">
  <span class="buttonclose">
    <button href="#" class="hamburger open-panel nav-toggle"> <span class="screen-reader-text">Menu</span> </button>
</span>

    <div class="logo-after-login">

      @if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo']))
         <a href="{{url('/')}}"><img src="{{ url('/') }}/uploads/profile_image/{{ $site_setting_arr['site_logo'] }}" alt="" /></a>
      @else 
        <a href="{{url('/')}}"><img src="{{url('/')}}/assets/buyer/images/chow-logo.png" alt="" /></a>
      @endif 

    </div>
    
     <div class="afterlns-right">
        <div class="linewallet-head">
            <div class="icon-wallets">
            <img src="{{ url('/') }}/assets/seller/images/wallet-icon-seller-pg.png" alt="">
          </div>
          <div class="price-wallet"><span>$</span><a  style="color: #0ea31c;" href="{{url('/')}}/buyer/wallet">{{ $remain_wallet_amount or '' }}</a>
          </div>
        </div>
         <div class="dropdown-new hover-new">
           @if($login_user == true && $login_user->inRole('buyer') == true)

               @php $user_profile_image = get_user_image(); @endphp
 

            <a href="#">
                <span class="avatar-head"><img src="{{ url('/') }}/assets/buyer/images/chow-user.svg" alt=""></span>
              <!-- <i class="fa fa-user-circle"></i> -->
               {{-- <span class="profl-em"><img src="{{ url('/') }}/assets/images/avatar.png" alt="" />
               </span> --}}
               
                    @php 
                    $user_name ='';
                    if($login_user['first_name']=="" || $login_user['last_name']==""){
                      $user_name= 'Buyer';
                    }
                    else
                    {
                        $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                        if($totallength>10)
                        {
                            $user_name =  $login_user['first_name'];
                        }else{
                           $user_name =  $login_user['first_name'].' '.$login_user['last_name'];
                        }
                    }


                    

                       /* if( isset($login_user['first_name']) && strlen($login_user['first_name'])>5)
                            $firstname  = substr($login_user['first_name'], 0,5);
                        else if(isset($login_user['first_name']))
                             $firstname  = $login_user['first_name'];
                         else
                             $firstname ='';


                          if( isset($login_user['last_name']) && strlen($login_user['last_name'])>5)
                            $lastname  = substr($login_user['last_name'], 0,5);
                        else if(isset($login_user['last_name']))
                             $lastname  = $login_user['last_name'];
                         else
                             $lastname ='';*/


                    @endphp


                       <span class="nameuser-byrs"> {{ $user_name or ''}} </span>
                        

             </a>
            <i class="fa fa-angle-down"></i>
            <ul>
                <li><a href="{{url('/')}}/buyer/change_password">Change Password</a></li>
                <li><a href="{{url('/logout')}}">Logout</a></li>
            </ul>
          @endif  
        </div>


        <!--------------earn-15------------------------------------>
          @php
             $referalcode = '';
             $get_buyer_referal_code = get_buyer_referal_code();
             if(isset($get_buyer_referal_code))
             {
               $referalcode = $get_buyer_referal_code;
             }
              $buyer_referal_amount = $buyer_refered_amount = '';
              $buyer_referal_amountarr =get_buyer_referal_amount_details();

              if(isset($buyer_referal_amountarr) && !empty($buyer_referal_amountarr))
              {
                 $buyer_referal_amount = isset($buyer_referal_amountarr)?$buyer_referal_amountarr:'';
              }

              $buyer_refered_amountarr =get_buyer_refered_amount_details();

              if(isset($buyer_refered_amountarr) && !empty($buyer_refered_amountarr))
              {
                 $buyer_refered_amount = isset($buyer_refered_amountarr)?$buyer_refered_amountarr:'';
              } 


          @endphp
             <div class="favoirt-main-li">
             <div class="notification">
                 {{--  <img src="{{ url('/') }}/assets/seller/images/referail-icon-link.png" alt=""> --}}
                    <a class="btn btn-info showreferaldropdown" style="width: 100%; min-width: 93px; background-color: #fff;color: #020202;border: 1px solid #fff;"> 
                       <div class="zindx-sbr"> Earn  @php 
                         echo "$". $buyer_referal_amount; 
                        @endphp    </div>
                        <div class="notify">
                              <div class="heartbit"></div>
                              <div class="point"></div>
                          </div>
                    </a>

                   <div class="notify">
                    <span class="heartbit1"></span>
                    <span class="point123"></span>
                   </div>

                  <div class="notification-menu">
                       <div class="width-drop" >
                    <div class="icon-referal-abt-cw">
                        <img src="{{ url('/') }}/assets/seller/images/referal.png" alt="">
                    </div>
                    <div class="h3-earn">
                         Earn 
                        @php 
                         echo "$". $buyer_referal_amount; 
                        @endphp 
                    </div>
                    <div class="invite-p-drop">
                        {{-- Invite other buyers and get  
                        @php 
                         echo "$". $buyer_referal_amount; 
                        @endphp  
                        in your wallet when they register using your link --}}

                     {{--   Give {{ '$'.$buyer_refered_amount }} for {{ '$'.$buyer_referal_amount }}. Gift friends {{ '$'.$buyer_refered_amount }} and get {{ '$'.$buyer_referal_amount }} in your wallet when they purchase a product on Chow  --}}

                    {{--  Gift a friend {{ '$'.$buyer_refered_amount }} in Chowcash when you invite them to Chow. Also, get {{ '$'.$buyer_referal_amount }} in Chowcash credits when they make their first purchase. --}}

                     Gift a friend {{ '$'.$buyer_refered_amount }} in Chowcash when you invite them to Chow and get {{ '$'.$buyer_referal_amount }} in Chowcash credits when they make their first purchase.

                    </div>
                    <a href="{{ url('/')}}/referbuyer?referalcode={{ $referalcode }}" class="invitebtn-lnks-ab" target="_blank">Invite</a>

                </div>
                <div class="clearfix"></div>
                  </div>
                </div>
            </div>
         

        <!--------------earn 15-------------------------------------->




        
        <div class="favoirt-main icon-favoirt-mains byer-icons-right">
            <div class="favoirt-main-li buyer-notification-icon">
                <a href="{{url('/')}}/buyer/notifications"><span id="buyer_notify">{{ $total_noti_cnt }}</span> <img src="{{url('/')}}/assets/buyer/images/chow-bell.svg" class="notification-head" alt=""></a>
            </div>
            {{-- <div class="favoirt-main-li">
                @if($login_user == true && $login_user->inRole('buyer'))
                <a href="{{url('/')}}/buyer/my-favourite"><span>{{isset($fav_product_count)?$fav_product_count:'0'}}</span> <img src="{{url('/')}}/assets/front/images/chow-heart.svg" alt="" /></a>
                @endif
            </div> --}}
            <div class="favoirt-main-li">
                @if($login_user == true && $login_user->inRole('buyer'))
                {{--  <a href="#"><span>0</span> <img src="{{url('/')}}/assets/buyer/images/cart-icon-header.svg" alt="" /></a> --}}
                <a href="{{url('/')}}/my_bag" id="mybag_div"><span>{{$cart_count or ''}}</span> <img class="width-head-byr" src="{{url('/')}}/assets/front/images/cart-icon-header.svg" alt="" /></a>
                @endif
            </div>
        </div> 
     </div>
     <div class="clearfix"></div>
 </div>


<!-----------------start of dob modal-------------------------------------------->


<div id="myiploadModal" class="modal fade modalauto">
    <div class="modal-dialog dialogauto">
        <div class="modal-content">          
            <div class="modal-body userdetaild-modal">
              
              <div class="subscribe-title">User Details</div>
              <span id="showiperr"></span>
                 <form id="modalform"> 
                    {{ csrf_field() }}
                    <div class="form-group form-box">
                       
                           <input class="input-text" id="date" onchange="age_calculation(this)" onkeypress="return validateNumberAndForwardSlash(event);" autocomplete="off" name="date_of_birth" data-parsley-required="true" data-parsley-required-message="Please enter date of birth"
                           @if($login_user == true && $login_user->inRole('buyer') && $login_user->date_of_birth != '')
                            value="{{$login_user->date_of_birth}}" 
                           @endif
                             placeholder="MM/DD/YYYY" type="text"/>   
                          {{--  <ul class="parsley-errors-list filled" id="parsley-id-5">
                                    <li  class="parsley-required" id="age_error"> </li>
                                  </ul> --}}
                           <div class="ageerr" id="age_error"></div>
                        
                           <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group form-box">
                        
                           <input type="text" name="phone" id="phone" class="input-text" data-parsley-required="true" data-parsley-required-message="Please enter phone number" placeholder="Please enter phone number" data-parsley-pattern="^[0-9]*$" data-parsley-pattern-message="Please enter valid phone number" data-parsley-minlength="10" data-parsley-maxlength="12">
                       
                           <div class="clearfix"></div>
                    </div>
                     <div class="clearfix"></div>
                        
                    <div class="text-center">
                   {{--  <button type="submit" class="btnsubscribe">Continue</button> --}}
                    <a href="#" class="btn-md btn-theme next-right btnsubscribe"  id="Continue" >Continue</a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>

<!-------------------end of dob modal--------------------------------------->




<div id="mypasswordModal" class="modal fade modalauto change-buyerpass-mpdal">
    <div class="modal-dialog dialogauto">
        <div class="modal-content">          
            <div class="modal-body userdetaild-modal">
              
              <div class="subscribe-title">Change Password</div>
              <span id="showiperr"></span>
                 <form id="frm-change-password"> 
                    <span id="status_msg"></span>
                    {{ csrf_field() }}
                    <div class="form-group form-box">
                       
                            <input type="password" id="current_password" name="current_password" class="input-text" placeholder="Old Password" data-parsley-required="true" data-parsley-required-message="Enter current password"
                                    data-parsley-remote="{{ url('/does_old_password_exist') }}"
                               data-parsley-remote-options='{ "type": "POST", "dataType": "jsonp", "data": { "_token": "{{ csrf_token() }}" } }'
                            data-parsley-remote-message="Please enter valid old password">
                        
                           <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group form-box">
                        
                          <input type="password" id="new_password" name="new_password" class="input-text" placeholder="New Password" data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-required-message="Enter new password" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}"  data-parsley-pattern-message="Password field must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters" data-parsley-minlength="8">
                       
                           <div class="clearfix"></div>
                     </div>
                     <div class="clearfix"></div>



                      <div class="form-group form-box">
                        
                          <input type="password" name="cnfm_new_password" id="cnfm_new_password" class="input-text" placeholder="Confirm Password" data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-required-message="Enter confirm password"  data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters" data-parsley-minlength="8" data-parsley-equalto="#new_password" data-parsley-equalto-message="Confirm password should be match with new password">
                       
                           <div class="clearfix"></div>
                     </div>
                     <div class="clearfix"></div>

                        
                    <div class="text-center">
                    <a href="#" class="btn-md btn-theme next-right btnsubscribe"  id="btn-change-password" >Change Password</a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>





@php
 $showmodal = $showpasswordmodal = 0;
 $login_user = Sentinel::check();  
 if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true) 
 {
    $date_of_birth = $login_user->date_of_birth;
    $phone = $login_user->phone;
    if($date_of_birth=="" || $phone=="")
    {
      $showmodal = 1;
    }
    else
    {
       $showmodal = 0;
    }

    $is_checkout_signup = $login_user->is_checkout_signup;
    $is_guest_user = $login_user->is_guest_user;
    $show_passwordmodal_afterlogin = $login_user->show_passwordmodal_afterlogin;
    $is_password_changed = $login_user->is_password_changed;



    if((isset($is_checkout_signup) && $is_checkout_signup==1 && isset($is_guest_user) && $is_guest_user==1 && isset($show_passwordmodal_afterlogin) && $show_passwordmodal_afterlogin==1 && isset($is_password_changed) && $is_password_changed==0) || (isset($is_checkout_signup) && $is_checkout_signup==1 && isset($is_guest_user) && $is_guest_user==1 && isset($show_passwordmodal_afterlogin) && $show_passwordmodal_afterlogin==0 && isset($is_password_changed) && $is_password_changed==0))
    {
      $showpasswordmodal = 1;
    }else
    {
       $showpasswordmodal = 0;
    }


 }
@endphp

<script type="text/javascript">
$(document).ready(function(){
    $("#myiploadModal").modal({
    show:false,
    backdrop:'static'
    });
});
</script>


<script>


  
  $(document).ready(function(){

     var showmodal = "{{ $showmodal }}";
     var showpasswordmodal = "{{ $showpasswordmodal }}";
      
     if(showmodal==1)
     {
       $("#myiploadModal").modal('show');
     }else{
       $("#myiploadModal").modal('hide');
     } 

     //  if(showpasswordmodal==1 && showmodal==0)
     // {
     //   $("#mypasswordModal").modal('show');
     // }else{
     //   $("#mypasswordModal").modal('hide');
     // } 
    
 });//show modal for buyer

</script>

{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
  $(document).ready(function(){
    var date_input=$('input[name="date_of_birth"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

    date_input.datepicker({
      format: 'mm/dd/yyyy',
      container: container,
      todayHighlight: true,
      autoclose: true,
    })
  })
</script> --}}



<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 
  <link rel="stylesheet" href="/resources/demos/style.css">
{{--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 --}}  
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


{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "1050:2050"
    });
  } );
  </script> --}}

<!--- -------------------------------------------- DATAPICKER -------------------------------------------- ------>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
  function age_calculation(ref) { 
    

     var list = document.getElementById("parsley-id-5");

    // if (list) {
    //   //list.removeChild(list.childNodes[0]);    
    //   $("#date").removeAttr('data-parsley-required');  
    // }

    

    if (list) {
       var ul = document.querySelector('#parsley-id-5');
     var listLength = ul.children.length;

      for (i = 0; i < listLength; i++) {
        list.removeChild(list.childNodes[0]);  
      }
    }


    var split_dob = ref.value.split("/");

    var month = split_dob[0];
    var date = split_dob[1];
    var year = split_dob[2];

    var date1 = new Date();
    var date2 = new Date(""+month+"/"+date+"/ "+year+""); 

    var Difference_In_Time = date1.getTime() - date2.getTime(); 
      
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 


    if (Difference_In_Days < 7671) { // days in 21 years

      document.getElementById("age_error").innerHTML = " You must be 21+ and above to use chow420.";
       document.getElementById("age_error").style="color:red;font-size:13px";
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

<script>
  var SITE_URL = "{{ url('/') }}";

   $('#Continue').click(function(){
           


           if($('#modalform').parsley().validate()==false) return;

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
                
                $("#date").removeAttr('data-parsley-required');

                document.getElementById("age_error").innerHTML = " You must be 21+ and above to use chow420.";
                 document.getElementById("age_error").style="color:red;font-size:13px";

                

                event.preventDefault();
                return false;
              }
              else {

                document.getElementById("age_error").innerHTML = "";
              }



                var isValid = isValidDate($("#date").val());
                if (isValid) {
                   document.getElementById("age_error").innerHTML = "";
                } else {
                  document.getElementById("age_error").innerHTML = "Date of Birth entered Incorrectly";
                  document.getElementById("age_error").style="color:red;font-size:13px";
                    event.preventDefault();
                        return false;

               }

        
              var form_data = $('#modalform').serialize();      

                  if($('#modalform').parsley().isValid() == true )
                  {

                    $.ajax({
                      url:SITE_URL+'/buyer/process_modal_ofbuyer',
                      data:form_data,
                      method:'POST',
                      
                      beforeSend : function()
                      {
                       // showProcessingOverlay();
                        $('#Continue').prop('disabled',true);
                        $('#Continue').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                      },
                      success:function(response)
                      { 
                       
                        console.log(response);
                        //hideProcessingOverlay();

                        if(typeof response =='object')
                        {
                          if(response.status && response.status=="success")
                          {
                             swal({
                                 title: 'Success',
                                 text: response.msg,
                                 type: response.status,
                                 confirmButtonText: "OK",
                                 closeOnConfirm: false
                              },
                             function(isConfirm,tmp)
                             {
                               if(isConfirm==true)
                               {
                                  window.location.reload();

                               }
                             });                      
                          }
                          else if(response.status=="ERROR"){
                           //  $("#showiperr").html(response.msg);
                           //  $("#showiperr").css('color','red');
                              swal('Alert!',response.msg);    
                          }
                        }// if type object
                      }//success
                    });
                  }

  });//end contirnue oclick function


function isValidDate(input) 
{
        var regexes = [
          /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/,
          /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/
        ];

        for (var i = 0; i < regexes.length; i++) {
          var r = regexes[i];
          if(!r.test(input)) {
            continue;
          }
          var a = input.match(r), d = new Date(a[3],a[1] - 1,a[2]);
          if(d.getFullYear() != a[3] || d.getMonth() + 1 != a[1] || d.getDate() != a[2]) {
            continue;
          }
          // All checks passed:
          return true;
        }

        return false;
}



</script>




  <script type="text/javascript">

    $('#btn-change-password').click(function(){

      //alert('clicked');
      
      /*Check all validation is true*/
      if($('#frm-change-password').parsley().validate()==false) return;

      $.ajax({
        url:SITE_URL+'/buyer/update_password',
        data:new FormData($('#frm-change-password')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-change-password').prop('disabled',true);
          $('#btn-change-password').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {

          hideProcessingOverlay();
          $('#btn-change-password').prop('disabled',false);
          $('#btn-change-password').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg').html(response.message);
                    $('#status_msg').css('color','green');
                    window.location.reload();
            }
            else
            {   
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                
                $('#status_msg').html(response.message);
                $('#status_msg').css('color','red');
            }
          }
        }
      });
    });
</script>


<script type="text/javascript">
// var main = function() {
//   $('.notification img').click(function() {
//     $('.notification-menu').toggle(); 
//   }); 
  
// }; 

var main = function() {
  $('.notification .showreferaldropdown').click(function() {
    $('.notification-menu').toggle(); 
  }); 
  
}; 


$(document).ready(main); 
</script>
<!-- After Login Header End -->