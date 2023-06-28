
<!DOCTYPE html>
<html class="openNav">

<?php
  
    if(isset($site_setting_arr['site_name']))
    {
      $meta_project_name = $site_setting_arr['site_name'];
    }
    else
    {
      $meta_project_name = config("app.project.name");
    }

?>

 

<head>

<!---Google analytics-header------>
<?php
if(isset($site_setting_arr['pixelcode']) && !empty($site_setting_arr['pixelcode'])) {
  echo $site_setting_arr['pixelcode'];
}
?>    

<!-- Google Tag Manager -->

<!-- End Google Tag Manager -->


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />


    <title><?php echo e(isset($page_title)?$page_title:''); ?> | <?php echo e(isset($meta_project_name) ? $meta_project_name : ""); ?></title>


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
    <link href="<?php echo e(url('/')); ?>/assets/seller/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--font-awesome-css-start-here-->
    <link href="<?php echo e(url('/')); ?>/assets/seller/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--Custom Css-->
    <link href="<?php echo e(url('/')); ?>/assets/seller/css/chow.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('/')); ?>/assets/seller/css/afterlogin-css.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">

      <!-- switechery css-->
    <link href="<?php echo e(url('/')); ?>/assets/admin/plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />
    <!--Main JS-->
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/seller/js/jquery-1.11.3.min.js"></script>
    <!--[if lt IE 9]>-->
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>


    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/buyer/js/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/buyer/js/loader.js"></script>
       <script src="<?php echo e(url('/')); ?>/assets/buyer/js/responsivetabs.js"></script>

    <script type="text/javascript">
      var SITE_URL = '<?php echo e(url('/')); ?>';
    </script>

   

        
  
        <?php if(Sentinel::check()): ?>
          <?php
            $user = Sentinel::getUser();
          ?>
         
        <?php endif; ?>

        <style>

.wallet-totl.header-wallet .price-wallet{
    margin-left: 30px; font-weight: 600;
    font-size: 16px; padding-left: 10px;
}

.wallet-totl.header-wallet .price-wallet span{font-weight: 600;}

.wallet-totl.header-wallet .icon-wallets {
    float: left;
    width: 20px;
}
.wallet-totl.header-wallet {
    padding: 7px 10px;
}
.favoirt-main{float: right;}
.zindx-sbr {
    z-index: 1;
    position: relative;
}
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
    font-size: 24px; font-weight: 600; color: #333;margin: 10px 0;
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
    background-color: #333;
    color: #fff; border: 1px solid #333;
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

 </style>
</head>

<body>


<?php
if(isset($site_setting_arr['body_content']) && !empty($site_setting_arr['body_content'])) {
  echo $site_setting_arr['body_content'];
}
?>   
    

<div id="main"></div>
<!-- Google Tag Manager (noscript) -->

<!-- End Google Tag Manager (noscript) -->

    
  <!-- <div class="blackdiv-for-header"></div> -->
      <?php 
        $login_user = Sentinel::check(); 

        $total_noti_cnt = 0;

        if($login_user == true && $login_user->inRole('seller') == true)
        {
            $user_profile_image = get_user_image();   
           
            $logUser_id     = $login_user->id;
            $total_noti_cnt = get_notifications_count($logUser_id);
        }


        /***********code for user subscription********/

        $user_subscriptiondata =[];
        $user_subscribed_flag = 0;
         $referalcode  = 0;

        $user_subscription = get_usersubscription_data();
        if(isset($user_subscription) && !empty($user_subscription))
        {
          $user_subscribed_flag   =   $user_subscription['user_subscried_flag'];
          $user_subscriptiondata =   $user_subscription['user_subscription_data'];
          $referalcode            =   $login_user->referal_code;

        }
       /***********end of code for user subscription*******/ 

      ?>   




 <div class="header-afterlogin">
    <span class="buttonclose">
    <button href="#" class="hamburger open-panel nav-toggle"> <span class="screen-reader-text">Menu</span> </button>
    </span>
    <div class="logo-after-login">

        <?php if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])): ?>
         <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(url('/')); ?>/uploads/profile_image/<?php echo e($site_setting_arr['site_logo']); ?>" alt="" /></a>
        <?php else: ?>
         <a href="<?php echo e(url('/')); ?>"> <img src="<?php echo e(url('/')); ?>/assets/seller/images/chow-logo.png" alt="" /></a>
        <?php endif; ?>
    </div>

    

    <div class="businessnamecls">
        <?php
            $business_name='';
            if(isset($seller_info_arr) && !empty($seller_info_arr))
            {
               $business_name = $seller_info_arr[0]['business_name'];
               $business_name = str_replace(' ','-',$business_name); 
            }
            ?>
            
             <?php if(isset($seller_info_arr[0]['business_name']) && !empty($seller_info_arr[0]['business_name'])): ?>
             <a href="<?php echo e(url('/')); ?>/search?sellers=<?php echo e($business_name); ?>" target="_blank">
             <?php echo e(url('/')); ?>/search?sellers=<?php echo e($business_name); ?></a>
             <?php endif; ?>
             <a href="<?php echo e(url('/')); ?>/search?sellers=<?php echo e($business_name); ?>" target="_blank" class="viewstorecls btn btn-default" style="background-color: #873dc8;color: #fff;border: 1px solid #873dc8;text-decoration: none;">View Store</a>
    </div>

     <div class="afterlns-right">
         
         <div class="dropdown-new hover-new">
            <a href="#"> 
                <span class="avatar-head"><img src="<?php echo e(url('/')); ?>/assets/buyer/images/chow-user.svg" alt=""></span>
               

                     <?php 

                       /* $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                        if($totallength>10)
                        {
                            $user_name =  $login_user['first_name'];
                        }else{
                           $user_name =  $login_user['first_name'].' '.$login_user['last_name'];
                        }*/
                        $set_name ='';
                        
                        if(isset($seller_arr) && !empty($seller_arr)){
                            if($login_user['first_name']=="" && $login_user['last_name']=="")
                            {
                              $set_name = $login_user['email']; 
                            }
                            else
                            {
                             
                                $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                if($totallength>10)
                                {
                                   $set_name =  $login_user['first_name'];
                                }else{
                                   $set_name =  $login_user['first_name'].' '.$login_user['last_name'];
                                }

                            } 
                        }


                    ?>                    
                  <?php echo e($set_name); ?>


                    
            

          </a><i class="fa fa-angle-down"></i>
            <ul>
                <li><a href="<?php echo e(url('/')); ?>/seller/change_password">Change Password</a></li>
                <li><a href="<?php echo e(url('/')); ?>/logout">Logout</a></li>
            </ul>
        </div>


        <!---------Add View your store link here---------------------->

            
 
        <!-------end of---Add View your store link here--------------->



    

      
        <div class="favoirt-main notification-head-li">

           
              <?php if($user_subscribed_flag==1 && isset($user_subscriptiondata) && !empty($user_subscriptiondata) && $user_subscriptiondata[0]['membership']=="2"): ?>

            <div class="favoirt-main-li">
             <div class="notification">
                 
                    <a class="btn btn-info showreferaldropdown" style="width: 100%; min-width: 93px; background-color: #873dc8;color: #fff;border: 1px solid #873dc8;"> 
                       <div class="zindx-sbr"> Earn  <?php 
                         echo "$". config('app.project.seller_referal'); 
                        ?>    </div>
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
                        <img src="<?php echo e(url('/')); ?>/assets/seller/images/referal.png" alt="">
                    </div>
                    <div class="h3-earn">
                         Earn 
                        <?php 
                         echo "$". config('app.project.seller_referal'); 
                        ?> 
                    </div>
                    <div class="invite-p-drop">
                        Invite other sellers and get  
                        <?php 
                         echo "$". config('app.project.seller_referal'); 
                        ?>  
                        in your wallet when they register using your link
                    </div>
                    <a href="<?php echo e(url('/')); ?>/refer?referalcode=<?php echo e($referalcode); ?>" class="invitebtn-lnks-ab" target="_blank">Invite</a>

                </div>
                <div class="clearfix"></div>
                  </div>
                </div>
            </div>
             <?php endif; ?> 

                <!--------start of wallet------------->
                <div class="wallet-totl header-wallet">
                      <div class="icon-wallets">
                         <img src="<?php echo e(url('/')); ?>/assets/seller/images/wallet-icon-slrs.png" alt="">
                      </div> 
                       <?php
                       $get_header_wallet = get_header_wallet();
                        $showamt ='00.00';$wallet_amount=0;

                       if(isset($get_header_wallet) && !empty($get_header_wallet))
                       {

                        $referal_wallet_amount = $get_header_wallet['referal_wallet_amount'];
                        $wallet_amount = $get_header_wallet['wallet_amount'];
                       if(isset($referal_wallet_amount) && $referal_wallet_amount>0)
                       {
                         $showamt = $wallet_amount + $referal_wallet_amount;
                       }
                       else if(isset($wallet_amount))
                       {
                        $showamt = $wallet_amount;
                       } 

                       }//if isset
                      
                      
                    ?>
                       
                      <div class="price-wallet"><span>$ </span> <?php echo e(isset($showamt)?num_format($showamt):'00.00'); ?></div>
                      <div class="clearfix"></div>
                </div>
                <!--------end of wallet------------->

              <div class="favoirt-main-li notificationicon-seller">
                <a href="<?php echo e(url('/')); ?>/seller/notifications"><span id="seller_notify"><?php echo e($total_noti_cnt); ?></span><img src="<?php echo e(url('/')); ?>/assets/seller/images/notificationicon.png" class="notification-head" alt=""></a>
            </div>

        </div>
      




     </div>
     <div class="clearfix"></div>
 </div>


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