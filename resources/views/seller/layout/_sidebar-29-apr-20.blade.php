

<div class="primary-nav">
  <button href="#" class="hamburger open-panel nav-toggle"> <span class="screen-reader-text">Menu</span> </button>

  <nav role="navigation" class="menu"> 
    <div class="overflow-container">

        {{-- <div class="buyers-btn-mn">
          <a href="{{url('/')}}"><div class="buyerbuttons">Marketplace</div></a>
        </div> --}}

    @php

    if(isset($seller_info_arr) && !empty($seller_info_arr))
    {
       $business_name = $seller_info_arr[0]['business_name'];
      
    }

    @endphp


      <ul class="menu-dropdown">
         @if(isset($seller_info_arr[0]['business_name']) && !empty($seller_info_arr[0]['business_name']))
         <li><a href="{{ url('/') }}/search?sellers={{$seller_info_arr[0]['business_name']}}" target="_blank" >My Storefront</a><span class="icon my-shop-icn"></span></li>
         @endif


        <li @if(Request::segment(2)!="" && Request::segment(2)=='dashboard') class="active" @endif><a href="{{ url('/') }}/seller/dashboard">Dashboard</a><span class="icon dashboard-icn"></span></li>
        <li @if(Request::segment(2)!="" && Request::segment(2)=='profile') class="active" @endif><a href="  {{ url('/') }}/seller/profile">My Profile</a><span class="icon myprofile-icn"></span></li>

         <li @if(Request::segment(2)!="" && Request::segment(2)=='wholesale') class="active" @endif><a href="  {{ url('/') }}/seller/wholesale" title="Wholesale Access">Wholesale Access</a><span class="icon idproof-verification-icn"></span></li>

         <li @if(Request::segment(2)!="" && (Request::segment(2)=='membership_detail' || Request::segment(2)=='membership')) class="active" @endif><a href="  {{ url('/') }}/seller/membership_detail">Membership Details </a><span class="icon idproof-verification-icn"></span></li>

       {{--   <li @if(Request::segment(2)!="" && Request::segment(2)=='id_verification') class="active" @endif><a href="  {{ url('/') }}/seller/id_verification">ID Proof Verification</a><span class="icon idproof-verification-icn"></span></li> --}}

       {{--  <li @if(Request::segment(2)!="" && Request::segment(2)=='business-profile') class="active" @endif><a href="  {{ url('/') }}/seller/business-profile">Business Profile</a><span class="icon bussiness-myprofile-icn"></span></li> --}}

          <li @if(Request::segment(2)!="" && Request::segment(2)=='bank_detail') class="active" @endif><a href="  {{ url('/') }}/seller/bank_detail">Bank Details Verification</a><span class="icon idproof-verification-icn"></span></li>

        <li @if(Request::segment(2)!="" && Request::segment(2)=='banner-image') class="active" @endif><a href="  {{ url('/') }}/seller/banner-image">Cover Image</a><span class="icon bannerimgs-icn"></span></li>

        <li @if(Request::segment(2)!="" && Request::segment(2)=='product') class="active" @endif><a href="{{ url('/') }}/seller/product">My Products</a><span class="icon sellerproducts-icn"></span></li>

          <li @if(Request::segment(2)!="" && Request::segment(2)=='posts') class="active" @endif><a href="{{ url('/') }}/seller/posts">My Forum Posts</a><span class="icon sellerproducts-icn"></span></li>
 
       {{-- <li @if(Request::segment(2)!="" && Request::segment(2)=='product') class="active" @endif><a href="{{ url('/') }}/seller/product">My Products</a><span class="icon sellerproducts-icn"></span></li> --}}
          @php 
              $order_type=['ongoing','completeddelivered','cancelled']; 

              $active_class = '';
              if(Request::segment(2)=='order' && 
                 (Request::segment(3)=='ongoing' || Request::segment(3)=='delivered' || Request::segment(3)=='order' || Request::segment(3)=='cancelled')){
                  $active_class = 'active-checked';
              }



          @endphp
         <li class="menu-hasdropdown {{ $active_class or '' }}" >

            <a href="#" >Manage Orders</a><span class="icon manage-ords-icn"></span>
            <label for="settings"> <span class="downarrow"><i class="fa fa-caret-down"></i></span> </label>
            <input type="checkbox" class="sub-menu-checkbox" id="settings" />
            <ul class="sub-menu-dropdown ">

            <li @if(Request::segment(2)=='order' && Request::segment(3)=='ongoing') class="active" @endif><a href="{{url('/')}}/seller/order/ongoing">Ongoing Orders</a></li>

            <li @if((Request::segment(2)!="" && Request::segment(2)=='order') && (Request::segment(3)!="" && Request::segment(3)=='delivered')) class="active" @endif><a href="{{url('/')}}/seller/order/delivered">Delivered Orders</a></li>

            <li  @if((Request::segment(2)!="" && Request::segment(2)=='order') && (Request::segment(3)!="" && Request::segment(3)=='cancelled')) class="active" @endif><a href="{{url('/')}}/seller/order/cancelled">Cancelled Orders</a></li>

          </ul>
        </li>

        <li @if(Request::segment(2)!="" && Request::segment(2)=='wallet') class="active" @endif><a href="{{url('/')}}/seller/wallet">My Wallet</a><span class="icon seller-wallet-icn"></span></li>

        <li @if(Request::segment(2)!="" && Request::segment(2)=='payment-history') class="active" @endif><a href="{{url('/')}}/seller/payment-history">Payment History</a><span class="icon payhistory-icn"></span></li>

       {{--  <li class="menu-hasdropdown">
            <a href="#">Report</a><span class="icon reports-icn"></span>
            <label title="toggle menu" for="settings2"> <span class="downarrow"><i class="fa fa-caret-down"></i></span> </label>
            <input type="checkbox" class="sub-menu-checkbox" id="settings2" />

            <ul class="sub-menu-dropdown">
                <li><a href="{{url('/')}}/seller/report/sales">Sales</a></li>
                <li><a href="{{url('/')}}/seller/report/inventory">Inventory</a></li>
                <li><a href="{{url('/')}}/seller/report/earnings">Earnings</a></li>
            </ul>

        </li>
 --}}
        <!-- <li><a href="#">Analytics</a><span class="icon analytics-icn"></span></li> -->


        <li @if(Request::segment(2)!="" && Request::segment(2)=='notifications') class="active" @endif><a href="{{url('/')}}/seller/notifications">Notifications</a><span class="icon notifications-icn"></span></li>
        
        
      </ul>
      <div class="logout-link-main">
         <a href="{{url('/')}}/logout" class="logout-link">Logout</a>
      </div>
    </div>
  </nav>
</div>