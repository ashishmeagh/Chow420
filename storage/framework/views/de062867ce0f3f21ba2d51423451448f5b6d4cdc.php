<!-- After Login Sidebar Buyer Start -->
<div class="primary-nav">
  <!-- <button href="#" class="hamburger open-panel nav-toggle"> <span class="screen-reader-text">Menu</span> </button> -->

  <nav role="navigation" class="menu"> 
    <div class="overflow-container">
        
      <ul class="menu-dropdown">
       <!-- <li><a href="#">Dashboard</a><span class="icon dashboard-icn"></span></li>-->

        <li><a href="<?php echo e(url('/')); ?>/search" target="_blank">Shop Now</a><span class="icon cart-buyer-icn"></span></li>

        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='profile'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/profile">Profile</a><span class="icon myprofile-icn"></span></li>

        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='age-verification'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/age-verification">Age Verification</a><span class="icon age-vrification-icn"></span></li>

        <li  <?php if(Request::segment(2)!="" && Request::segment(2)=='order'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/order">Orders</a><span class="icon orders-icn"></span></li>

        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='my-favourite'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/my-favourite">Wishlist</a><span class="icon wishlist-icn"></span></li>

        <li <?php if(Request::segment(2)!="" && Request::segment(2)=='payment-history'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/payment-history">Payment History</a><span class="icon payhistory-icn"></span></li>

       

        <li  <?php if(Request::segment(2)!="" && Request::segment(2)=='review-ratings'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/review-ratings">Reviews & Ratings</a><span class="icon ratings-icn"></span></li>

         <li  <?php if(Request::segment(2)!="" && Request::segment(2)=='posts'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/posts">Forum Posts</a><span class="icon orders-icn forumicon"></span></li>

         <li  <?php if(Request::segment(2)!="" && Request::segment(2)=='refered-users'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/refered-users">Refered Users</a><span class="icon orders-icn forumicon"></span></li>

          <li  <?php if(Request::segment(2)!="" && Request::segment(2)=='wallet'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/wallet">Wallet (Chowcash)</a><span class="icon orders-icn forumicon"></span></li>

          <li  <?php if(Request::segment(2)!="" && Request::segment(2)=='reported_issues'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/reported_issues">Reported Issues</a><span class="icon orders-icn forumicon"></span></li>

        <li  <?php if(Request::segment(2)!="" && Request::segment(2)=='notifications'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/')); ?>/buyer/notifications">Notifications</a><span class="icon notifications-icn"></span></li>
      </ul>
      <div class="logout-link-main">
         <a href="<?php echo e(url('/logout')); ?>" class="logout-link">Logout</a>
      </div>
    </div>
  </nav>
</div>
<!-- After Login Sidebar Buyer End -->