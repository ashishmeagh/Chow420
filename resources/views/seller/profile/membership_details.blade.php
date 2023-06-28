    @extends('seller.layout.master')
@section('main_content')
<style type="text/css">
  .div-icon{
      width: 16px;
    margin-right: 2px;
    margin-top: -3px;
}
.membershipbtn{
 background-color: #873dc8;
 color:white;
}
.membershipbtn:hover{
 background-color: #222;
 color:white;
}
.membershipbtn:focus{
 background-color: #222;
 color:white;
}

</style>
<div class="my-profile-pgnm">
Membership Details

  <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Membership Details</li>
  </ul>
</div>
<div class="new-wrapper">

<div class="main-my-profile">
   <div class="innermain-my-profile paddingnones nonepaddingmmbrs">


@php
 
  if(isset($user_subscription_details) && (!empty($user_subscription_details)))
  {

@endphp
  
 

                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Membership Type</div>
                     <div class="myprofile-right">
                        @if(isset($user_subscription_details['subscription_arr'][0]['membership']) && 
                        !empty($user_subscription_details['subscription_arr'][0]['membership']))
                            @php 
                              if($user_subscription_details['subscription_arr'][0]['membership']==1)
                               {
                                 $set_membership = 'Free';
                               }else{
                                 $set_membership = 'Paid';
                               } 
                            @endphp

                            {{ $set_membership }}

                        @else
                         NA
                        @endif
                     </div>
                     <div class="clearfix"></div>
                 </div>
                
                   <div class="myprofile-main">
                     <div class="myprofile-lefts">Plan Name</div>
                     <div class="myprofile-right">
                        @if(isset($user_subscription_details['subscription_arr'][0]['membership_id']) &&  isset($user_subscription_details['membership_arr']['name']) && 
                        !empty($user_subscription_details['membership_arr']['name']))
                            {{ $user_subscription_details['membership_arr']['name'] }}
                        @else
                         NA
                        @endif
                     </div>
                     <div class="clearfix"></div>
                 </div>
                
                 @if($user_subscription_details['subscription_arr'][0]['membership']=='2')

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">Amount($)</div>
                     <div class="myprofile-right">
                        @if(isset($user_subscription_details['subscription_arr'][0]['membership_amount'])  && !empty($user_subscription_details['subscription_arr'][0]['membership_amount']))

                            @php

                            // if($user_subscription_details['subscription_arr'][0]['membership_amount']>0)
                            //  {
                            //    $set_amount =  '$'.rtrim(rtrim(strval($user_subscription_details['subscription_arr'][0]['membership_amount']), "0"), ".");
                            //  }else{
                            //      $set_amount =  '$'.$user_subscription_details['subscription_arr'][0]['membership_amount'];
                            //  } 

                             echo '$'.number_format($user_subscription_details['subscription_arr'][0]['membership_amount']);


                            @endphp

                          {{--   ${{ number_format($user_subscription_details['subscription_arr'][0]['membership_amount']) }} --}}
                        @else
                         NA
                        @endif
                     </div>
                     <div class="clearfix"></div>
                 </div>

                 @endif

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">Date</div>
                     <div class="myprofile-right">
                      @if(isset($user_subscription_details['subscription_arr'][0]['created_at'])  && !empty($user_subscription_details['subscription_arr'][0]['created_at']))

                            {{ date("M d Y H:i",strtotime($user_subscription_details['subscription_arr'][0]['created_at'])) }}
                     @else
                         NA
                     @endif
                     </div>
                     <div class="clearfix"></div>
                 </div>


                @if($user_subscription_details['subscription_arr'][0]['membership']=='2')

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">Payment Status</div>
                     <div class="myprofile-right">
                            @php
                               $paystatus ='';
                                if($user_subscription_details['subscription_arr'][0]['payment_status']=='1')
                               {
                                  $paystatus = '<span class="status-completed">Completed</span>';
                               }      
                               else if($user_subscription_details['subscription_arr'][0]['payment_status']=='0' && $user_subscription_details['subscription_arr'][0]['membership']=='2')
                               {
                                 $paystatus = '<span class="status-dispatched">Ongoing</span>';
                               }    
                                else if($user_subscription_details['subscription_arr'][0]['payment_status']=='0' && $user_subscription_details['subscription_arr'][0]['membership']=='1')
                               {
                                 $paystatus = 'NA';
                               }                         
                               else if($user_subscription_details['subscription_arr'][0]['payment_status']=='2')
                               {
                                $paystatus = '<span class="status-shipped">Failed</span>';
                               }
                               echo $paystatus;
                            @endphp
                                                    
                     
                     </div>
                     <div class="clearfix"></div>
                 </div>
                
                  <div class="myprofile-main">
                     <div class="myprofile-lefts">Transaction Id</div>
                     <div class="myprofile-right">
                        @if(isset($user_subscription_details['subscription_arr'][0]['transaction_id'])  && !empty($user_subscription_details['subscription_arr'][0]['transaction_id']))
                            {{ $user_subscription_details['subscription_arr'][0]['transaction_id'] }}
                        @else
                         NA
                        @endif
                     </div>
                     <div class="clearfix"></div>
                 </div>
              @endif

@php
   }
   else
   {
@endphp

                 <div class="myprofile-main membership-type-class">
                     <div class="myprofile-lefts">You have not selected any membership plan.</div>
                      <a href="{{ url('/') }}/seller/membership" class="btn pull-right membershipbtn" title="Purchase new membership plan">New Membership</a>
                     <div class="clearfix"></div>
                 </div>

@php
   } 
@endphp
        
   </div>
</div>
</div>
@endsection