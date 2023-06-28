    @extends('seller.layout.master')
@section('main_content')

<div class="my-profile-pgnm">
My Profile

  <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>My Profile</li>
  </ul>

</div>
<div class="new-wrapper">

<div class="main-my-profile">
   <div class="innermain-my-profile paddingnones">


@php
 
$user_profile_status = isset($user_details_arr['approve_status'])?$user_details_arr['approve_status']:'';

@endphp
  
 

   @if(isset($user_details_arr['user_details']['approve_verification_status']) && ($user_details_arr['user_details']['approve_verification_status']==1 ) && ($user_profile_status==1))

    <div class="text-right">
     

       <a href="mailto:{{ $admin_arr['email'] }}" class="eye-actn" title="mailto:{{isset($admin_arr['email'])?$admin_arr['email']:''}}">
        Request Change
      </a>


     </div>
    @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && ($user_details_arr['user_details']['approve_verification_status']==2 ))
      <a href="{{url('/')}}/seller/profile/edit" class="editmyprofiles" title="Edit Profile">
        <img src="{{url('/')}}/assets/seller/images/edit-profile.png" alt="" /> Edit Profile
      </a> 
    @else
       <a href="{{url('/')}}/seller/profile/edit" class="editmyprofiles" title="Edit Profile">
        <img src="{{url('/')}}/assets/seller/images/edit-profile.png" alt="" /> Edit Profile
       </a> 
    @endif


                 <div class="myprofile-main">
                     <div class="myprofile-lefts">First Name</div>
                     <div class="myprofile-right">{{isset($user_details_arr['first_name'])?$user_details_arr['first_name']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Last Name</div>
                     <div class="myprofile-right">{{isset($user_details_arr['last_name'])?$user_details_arr['last_name']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Email Address</div>
                     <div class="myprofile-right">{{isset($user_details_arr['email'])?$user_details_arr['email']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>
                <div class="myprofile-main">
                     <div class="myprofile-lefts">Mobile Number</div>
                     <div class="myprofile-right">{{isset($user_details_arr['phone'])?$user_details_arr['phone']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">Address</div>
                     <div class="myprofile-right">{{isset($user_details_arr['street_address'])?ucwords($user_details_arr['street_address']):'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">City</div>
                     <div class="myprofile-right">{{isset($user_details_arr['city'])?ucwords($user_details_arr['city']):'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">State</div>
                     <div class="myprofile-right">{{isset($user_details_arr['get_states_arr']['name'])?$user_details_arr['get_states_arr']['name']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>

                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Country</div>
                     <div class="myprofile-right">{{isset($user_details_arr['get_countries_arr']['name'])?$user_details_arr['get_countries_arr']['name']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>

                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Zip Code</div>
                     <div class="myprofile-right">{{isset($user_details_arr['zipcode'])?$user_details_arr['zipcode']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>
               
                {{--  <div class="myprofile-main">
                     <div class="myprofile-lefts">Country Code</div>
                     <div class="myprofile-right">{{isset($user_details_arr['country'])?$user_details_arr['country']:''}}</div>
                     <div class="clearfix"></div>
                 </div>  --}}
                

                <div class="myprofile-main">
                  <div class="myprofile-lefts">ID Proof Verification</div>


                 @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']=='0' && $user_details_arr['user_details']['front_image']=="" &&  $user_details_arr['user_details']['back_image']=="" &&  $user_details_arr['user_details']['selfie_image']=="")

                  <div class="myprofile-right"><div class="status-dispatched">Id proof details not uploaded</div></div>

                  @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']=='3' && $user_details_arr['user_details']['front_image']!="" &&  $user_details_arr['user_details']['back_image']!="" &&  $user_details_arr['user_details']['selfie_image']!="")

                  <div class="myprofile-right">
                    {{-- <div class="status-dispatched">Pending</div> --}}
                    <div class="status-dispatched">Submitted</div>
                  </div>  
                  

                 @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
                  <div class="myprofile-right">
                    <div class="status-completed">Approved</div>
                  </div>

                 @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==2)

                   
                  <div class="myprofile-right">
                      <div class="status-shipped">Rejected</div>
                  </div>
                  <div class="main-rejects">
                    <div class="myprofile-lefts">Reject Reason</div>
                      <div class="myprofile-right">{{isset($user_details_arr['user_details']['note'])?$user_details_arr['user_details']['note']:''}}</div>
                  </div>
                  <div class="clearfix"></div>
               
                 @endif    
             </div>

             <!-------------------------------------------------------------------->

             <div class="myprofile-main">
                  <div class="myprofile-lefts">Profile Verification</div>


                 @if(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='0' && ($user_details_arr['first_name']=="" ||  $user_details_arr['last_name']=="" || $user_details_arr['email']=="" || $user_details_arr['phone']=="" || $user_details_arr['street_address']=="" || $user_details_arr['country']=="" || $user_details_arr['state']=="" || $user_details_arr['zipcode']=="" || $user_details_arr['city']==""))

                  <div class="myprofile-right"><div class="status-dispatched">Profile details not uploaded</div></div>

                  @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='0' && $user_details_arr['first_name']!="" &&  $user_details_arr['last_name']!="" &&  $user_details_arr['email']!="" &&  $user_details_arr['phone']!="" &&  $user_details_arr['street_address']!="" &&  $user_details_arr['country']!="" &&  $user_details_arr['state']!="" &&  $user_details_arr['zipcode']!="" &&  $user_details_arr['city']!="")

                  <div class="myprofile-right">
                    <div class="status-dispatched">Pending</div>
                  </div>  

                   @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='3' && $user_details_arr['first_name']!="" &&  $user_details_arr['last_name']!="" &&  $user_details_arr['email']!="" &&  $user_details_arr['phone']!="" &&  $user_details_arr['street_address']!="" &&  $user_details_arr['country']!="" &&  $user_details_arr['state']!="" &&  $user_details_arr['zipcode']!="" &&  $user_details_arr['city']!="")

                  <div class="myprofile-right">
                    <div class="status-dispatched">Submitted</div>
                  </div>  
                  

                 @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']==1)
                  <div class="myprofile-right">
                    <div class="status-completed">Approved</div>
                  </div>

                 @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']==2)

                   
                  <div class="myprofile-right">
                      <div class="status-shipped">Rejected</div>
                  </div>
                  <div class="main-rejects">
                    <div class="myprofile-lefts">Reject Reason</div>
                      <div class="myprofile-right">{{isset($user_details_arr['note'])?$user_details_arr['note']:''}}</div>
                  </div>
                  <div class="clearfix"></div>
               
                 @endif    
             </div>



             <!-------------------------------------------------------------------->







        
   </div>
</div>
</div>
@endsection