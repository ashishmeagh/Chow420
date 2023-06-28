<style>
.sidebarprdct-sells {
    position: absolute;
    left: 83px;
    top: 37px;
}
.notification .notify .heartbit {
    position: absolute;
    top: -25px;
    left: 36px;
    height: 31px;
    width: 31px;
    z-index: 10;
    border: 6px solid #f8d82a;
    border-radius: 70px;
    -moz-animation: heartbit 1s ease-out;
    -moz-animation-iteration-count: infinite;
    -o-animation: heartbit 1s ease-out;
    -o-animation-iteration-count: infinite;
    -webkit-animation: heartbit 1s ease-out;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
} 

.notification .notify .point {
    width: 6px;
    height: 6px;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
    background-color: #f8d82a;
    position: absolute;
    left: 61px;
    top: -13px; display: none;
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
    border: 5px solid #AE47DD;
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
    background-color: #AE47DD;
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
</style>

<div class="primary-nav">
  <!-- <span class="buttonclose">
  <button href="#" class="hamburger open-panel nav-toggle"> <span class="screen-reader-text">Menu</span> </button>
  </span> -->

  <nav role="navigation" class="menu"> 
    <div class="overflow-container">

        

    <?php

    if(isset($seller_info_arr) && !empty($seller_info_arr))
    {
       $business_name = $seller_info_arr[0]['business_name'];
      
    }

      $user_details = false;
      $user_details = Sentinel::getUser();       
      if(isset($user_details) && !empty($user_details))
      {

         $user_details_arr = $user_details->toArray();
         $loginuserid = $user_details_arr['id'];

         $user_subscribed = 0;
         if ($user_details->subscribed('main')) {
            $user_subscribed = 1;

         }else{
          $user_subscribed =0;
         }
      }
     

    ?>


      <ul class="menu-dropdown">
         <?php if(isset($seller_info_arr[0]['business_name']) && !empty($seller_info_arr[0]['business_name'])): ?>
         <li><a href="<?php echo e(url('/')); ?>/search?sellers=<?php echo e($seller_info_arr[0]['business_name']); ?>" target="_blank" >Storefront</a><span class="icon my-shop-icn"></span></li>
         <?php endif; ?>


        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='dashboard'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a><span class="icon dashboard-icn"></span></li>
        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='profile'): ?> class="active" <?php endif; ?>><a href="  <?php echo e(url('/')); ?>/seller/profile">Profile</a><span class="icon myprofile-icn"></span></li>
        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='dispensary-image'): ?> class="active" <?php endif; ?>><a href="  <?php echo e(url('/')); ?>/seller/dispensary-image">Dispensary Image</a><span class="icon bannerimgs-icn"></span></li>
        

         <li <?php if(Request::segment(2)!="" && (Request::segment(2)=='membership_detail' || Request::segment(2)=='membership')): ?> class="active" <?php endif; ?>><a href="  <?php echo e(url('/')); ?>/seller/membership_detail">Membership Details </a><span class="icon idproof-verification-icn"></span></li>

       

       

          <li <?php if(Request::segment(2)!="" && Request::segment(2)=='bank_detail'): ?> class="active" <?php endif; ?>><a href="  <?php echo e(url('/')); ?>/seller/bank_detail">Bank Details Verification</a><span class="icon idproof-verification-icn"></span></li>

      

        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='product'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/product">Sell Products</a><div class="sidebarprdct-sells">
          <div class="notify">
              <span class="heartbit"></span>
              <span class="point"></span>
          </div>
        </div>   
        <span class="icon sellerproducts-icn"></span></li>

          <li <?php if(Request::segment(2)!="" && Request::segment(2)=='posts'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/posts">Forum Posts</a><span class="icon sellerproducts-icn"></span></li>
 
       
          <?php 
              $order_type=['ongoing','completeddelivered','cancelled','age_restricted_order']; 

              $active_class = '';
              if(Request::segment(2)=='order' && 
                 (Request::segment(3)=='ongoing' || Request::segment(3)=='delivered' || Request::segment(3)=='order' || Request::segment(3)=='cancelled')){
                  $active_class = 'active-checked';
              }


              if(Request::segment(2)=='age_restricted_order')
              {
                 $active_class = 'active-checked';
              }

          ?>
         <li class="menu-hasdropdown <?php echo e(isset($active_class) ? $active_class : ''); ?>" >

            <a href="#" >Manage Orders</a><span class="icon manage-ords-icn"></span>
            <label for="settings"> <span class="downarrow"><i class="fa fa-caret-down"></i></span> </label>
            <input type="checkbox" class="sub-menu-checkbox" id="settings" />
            <ul class="sub-menu-dropdown ">

            <li <?php if(Request::segment(2)!="" && Request::segment(2)=='age_restricted_order'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/age_restricted_order">Pending Age Verification Orders</a></li>  

            <li <?php if(Request::segment(2)=='order' && Request::segment(3)=='ongoing'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/order/ongoing">Ongoing Orders</a></li>

            <li <?php if((Request::segment(2)!="" && Request::segment(2)=='order') && (Request::segment(3)!="" && Request::segment(3)=='delivered')): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/order/delivered">Delivered Orders</a></li>

            <li  <?php if((Request::segment(2)!="" && Request::segment(2)=='order') && (Request::segment(3)!="" && Request::segment(3)=='cancelled')): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/order/cancelled">Cancelled Orders</a></li>

            

          </ul>
        </li>

        


        


        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='wallet'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/wallet"> Wallet (Chowcash)</a><span class="icon seller-wallet-icn"></span></li>


        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='payment-history'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/payment-history">Payment History</a><span class="icon payhistory-icn"></span></li>

       
        <!-- <li><a href="#">Analytics</a><span class="icon analytics-icn"></span></li> -->


        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='notifications'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/notifications">Notifications</a><span class="icon notifications-icn"></span></li>

        

         <li <?php if(Request::segment(2)!="" && Request::segment(2)=='userrefered'): ?> class="active" <?php endif; ?>><a href="  <?php echo e(url('/')); ?>/seller/userrefered" title="Refered Users">Refered Users</a><span class="icon refered-access-icn"></span></li>

         <li <?php if(Request::segment(2)!="" && Request::segment(2)=='membership-history'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/membership-history">Membership History</a><span class="icon payhistory-icn"></span></li>

          <li <?php if(Request::segment(2)!="" && Request::segment(2)=='coupon'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/coupon">Coupon Codes</a><span class="icon sellerproducts-icn"></span></li>

          <li <?php if(Request::segment(2)!="" && Request::segment(2)=='followers'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/followers">Followers</a><span class="icon myprofile-icn"></span></li>

          <li <?php if(Request::segment(2)!="" && Request::segment(2)=='delivery_options'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/seller/delivery_options">Delivery Options</a><span class="icon myprofile-icn"></span></li>
      </ul>
      <div class="logout-link-main">
         <a href="<?php echo e(url('/')); ?>/logout" class="logout-link">Logout</a>
      </div>
    </div>
  </nav>
</div>