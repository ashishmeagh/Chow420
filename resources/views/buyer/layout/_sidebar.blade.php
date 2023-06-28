<!-- After Login Sidebar Buyer Start -->
<div class="primary-nav">
  <!-- <button href="#" class="hamburger open-panel nav-toggle"> <span class="screen-reader-text">Menu</span> </button> -->

  <nav role="navigation" class="menu"> 
    <div class="overflow-container">
        {{-- <div class="buyers-btn-mn"><div class="buyerbuttons">Buyer</div></div> --}}
      <ul class="menu-dropdown">
       <!-- <li><a href="#">Dashboard</a><span class="icon dashboard-icn"></span></li>-->

        <li><a href="{{url('/')}}/search" target="_blank">Shop Now</a><span class="icon cart-buyer-icn"></span></li>

        <li @if(Request::segment(2)!="" && Request::segment(2)=='profile') class="active" @endif><a href="{{url('/')}}/buyer/profile">Profile</a><span class="icon myprofile-icn"></span></li>

        <li @if(Request::segment(2)!="" && Request::segment(2)=='age-verification') class="active" @endif><a href="{{url('/')}}/buyer/age-verification">Age Verification</a><span class="icon age-vrification-icn"></span></li>

        <li  @if(Request::segment(2)!="" && Request::segment(2)=='order') class="active" @endif><a href="{{url('/')}}/buyer/order">Orders</a><span class="icon orders-icn"></span></li>

        <li @if(Request::segment(2)!="" && Request::segment(2)=='my-favourite') class="active" @endif><a href="{{url('/')}}/buyer/my-favourite">Wishlist</a><span class="icon wishlist-icn"></span></li>

        <li @if(Request::segment(2)!="" && Request::segment(2)=='payment-history') class="active" @endif><a href="{{url('/')}}/buyer/payment-history">Payment History</a><span class="icon payhistory-icn"></span></li>

       {{--  <li  @if(Request::segment(2)!="" && Request::segment(2)=='dispute') class="active" @endif><a href="{{url('/')}}/buyer/dispute">Dispute</a><span class="icon dispute-icn"></span></li> --}}

        <li  @if(Request::segment(2)!="" && Request::segment(2)=='review-ratings') class="active" @endif><a href="{{url('/')}}/buyer/review-ratings">Reviews & Ratings</a><span class="icon ratings-icn"></span></li>

         <li  @if(Request::segment(2)!="" && Request::segment(2)=='posts') class="active" @endif><a href="{{url('/')}}/buyer/posts">Forum Posts</a><span class="icon orders-icn forumicon"></span></li>

         <li  @if(Request::segment(2)!="" && Request::segment(2)=='refered-users') class="active" @endif><a href="{{url('/')}}/buyer/refered-users">Refered Users</a><span class="icon orders-icn forumicon"></span></li>

          <li  @if(Request::segment(2)!="" && Request::segment(2)=='wallet') class="active" @endif><a href="{{url('/')}}/buyer/wallet">Wallet (Chowcash)</a><span class="icon orders-icn forumicon"></span></li>

          <li  @if(Request::segment(2)!="" && Request::segment(2)=='reported_issues') class="active" @endif><a href="{{url('/')}}/buyer/reported_issues">Reported Issues</a><span class="icon orders-icn forumicon"></span></li>

        <li  @if(Request::segment(2)!="" && Request::segment(2)=='notifications') class="active" @endif><a href="{{url('/')}}/buyer/notifications">Notifications</a><span class="icon notifications-icn"></span></li>
      </ul>
      <div class="logout-link-main">
         <a href="{{url('/logout')}}" class="logout-link">Logout</a>
      </div>
    </div>
  </nav>
</div>
<!-- After Login Sidebar Buyer End -->