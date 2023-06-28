@extends('seller.layout.master')
@section('main_content')

<div class="my-profile-pgnm">
My Wallet
   <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>My Wallet</li>
    </ul>
</div>
  <div class="new-wrapper">
    <div class="order-main-dvs table-order">
      
      <div class="selr-wlts-head">
        <div class="wallet-totl">
          <div class="icon-wallets">
            <img src="{{url('/')}}/assets/seller/images/wallet-icon-seller-pg.png" alt="" />
          </div>
          <div class="price-wallet"><span>$</span>{{isset($wallet_amount)?num_format($wallet_amount):'00.00'}}</div>
          <div class="clearfix"></div>
        </div>
      </div>


      <div class="table-responsive">
        <div class="rtable">
          <div class="rtablerow none-boxshdow">
            <div class="rtablehead"><strong>Order No</strong></div>
            <div class="rtablehead"><strong>Transaction ID</strong></div>
            <div class="rtablehead"><strong>Amount</strong></div>
            {{-- <div class="rtablehead"><strong>Days Left</strong></div> --}}
          </div>
          @if(isset($transaction_arr) && count($transaction_arr) > 0)
            @foreach($transaction_arr as $transaction)
              <div class="rtablerow">
                <div class="rtablecell">{{isset($transaction['order_no'])?$transaction['order_no']:''}}</div>
                <div class="rtablecell">{{isset($transaction['transaction_id'])?$transaction['transaction_id']:''}}</div>
                <div class="rtablecell">${{isset($transaction['total_amount'])?num_format($transaction['total_amount']):'0.00'}}</div>
                {{-- <div class="rtablecell">5 Days</div> --}}
              </div>
            @endforeach
          @endif
        </div>
      </div>

      <div class="pagination-chow pagination-center">
        {{$arr_pagination->render()}}
      </div>
    </div>
  </div>
</div>
@endsection