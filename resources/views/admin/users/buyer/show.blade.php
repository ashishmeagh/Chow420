@extends('admin.layout.master')                
@section('main_content')
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">{{$page_title or ''}}</h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">

        @php
            $user = Sentinel::check();
        @endphp

        @if(isset($user) && $user->inRole('admin'))
           <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
        @endif
         
         <li><a href="{{ url(config('app.project.admin_panel_slug').'/buyers') }}">Buyers</a></li>
         <li class="active">{{$page_title or ''}}</li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>

<!-- .row -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box white-gray-bx-mn">
         @include('admin.layout._operation_status')
          <div class="row">
            <div class="col-sm-12 col-xs-12">
                 <h3>
                    <span 
                       class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action" >
                    </span>
                 </h3>
            </div>
          </div>
          
                     <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label" ></label>
                        <div class="col-sm-3 col-lg-3 controls">
                         {{--   <h4><b>{{$page_title or ''}}</b></h4> --}}
                        </div>

                     </div>

                     <div class="col-sm-12">
<div class="profile-view-seller">
  {{-- <div class="profile-view-seller-img">
    <img id="admin-profile-img" src="{{ getProfileImage($user_arr['profile_image'])}}" alt="user-img" width="100" class="img-circle">
  </div> --}}



 {{--   <div class="title-profiles-slrs">

   {{ $user_arr['first_name'] or '' }} {{ $user_arr['last_name'] or '' }}

   </div>
 --}}

    <div class="main-prfl-conts">
     <div class="myprofile-main">
         <div class="myprofile-lefts">Name </div>
         <div class="myprofile-right">
          {{ $user_arr['first_name'] or '' }} 
          {{ $user_arr['last_name'] or '' }}
         </div>
         <div class="clearfix"></div>
    </div>


   <div class="main-prfl-conts">
     {{-- <div class="myprofile-main">
         <div class="myprofile-lefts">Contact</div>
         <div class="myprofile-right">
          @php
              if($user_arr['phone'])
                $phone = $user_arr['phone'];
              else
                $phone = 'NA';
          @endphp
             {{ $phone }}
         </div>
         <div class="clearfix"></div>
    </div> --}}
    <div class="myprofile-main">
         <div class="myprofile-lefts">Email</div>
         <div class="myprofile-right">
             @php
              if($user_arr['email'])
                $email = $user_arr['email'];
              else
                $email = 'NA';
             @endphp
                {{ $email}}
         </div>
         <div class="clearfix"></div>
    </div>

    <div class="myprofile-main">
         <div class="myprofile-lefts">Phone Number</div>
         <div class="myprofile-right">
             @php
              if($user_arr['phone'])
                $phone = $user_arr['phone'];
              else
                $phone = 'NA';
             @endphp
                {{ $phone}}
         </div>
         <div class="clearfix"></div>
    </div>

    <div class="myprofile-main">
         <div class="myprofile-lefts">Age</div>
         <div class="myprofile-right">
             @php
             if (isset($user_arr['date_of_birth']) && $user_arr['date_of_birth'] != "") {
                $dob = $user_arr['date_of_birth'];
                $age = (date('Y') - date('Y',strtotime($dob))) . " Years";
             }
             else {
                $age = " NA";
             }
             @endphp
                {{$age}} 
         </div>
         <div class="clearfix"></div>
    </div>

     <div class="myprofile-main">
         <div class="myprofile-lefts">Date of birth</div>
         <div class="myprofile-right">
             @php
             if (isset($user_arr['date_of_birth']) && $user_arr['date_of_birth'] != "") {
                $dob = $user_arr['date_of_birth'];
                
             }
             else {
                $dob = " NA";
             }
             @endphp
                {{$dob}} 
         </div>
         <div class="clearfix"></div>
    </div>



    <div class="myprofile-main">
         <div class="myprofile-lefts">Address</div>
         <div class="myprofile-right">
             @php
              if($user_arr['street_address'])
                $street_address = $user_arr['street_address'];
              else
                $street_address = 'NA';
             @endphp
                {{ $street_address}}
         </div>
         <div class="clearfix"></div>
    </div> 
     <div class="myprofile-main">
         <div class="myprofile-lefts">City</div>
         <div class="myprofile-right">
             @php

              if($user_arr['city'])
                $city = $user_arr['city'];
              else
                $city = 'NA';
             @endphp
                {{ $city}}
         </div>
         <div class="clearfix"></div>
    </div> 


    <div class="myprofile-main">
         <div class="myprofile-lefts">State</div>
         <div class="myprofile-right">
             @php
              if($user_arr['get_state_detail']['name'])
                $state = $user_arr['get_state_detail']['name'];
              else
                $state = 'NA';
             @endphp
                {{ $state}}
         </div>
         <div class="clearfix"></div>
    </div>  
    <div class="myprofile-main">
         <div class="myprofile-lefts">Country</div>
         <div class="myprofile-right">
             @php
              if($user_arr['get_country_detail']['name'])
                $country = $user_arr['get_country_detail']['name'];
              else
                $country = 'NA';
             @endphp
                {{ $country}}
         </div>
         <div class="clearfix"></div>
    </div> 

      <div class="myprofile-main">
         <div class="myprofile-lefts">Zipcode</div>
         <div class="myprofile-right">
             @php
          
              if($user_arr['zipcode'])
                $zipcode = $user_arr['zipcode'];
              else
                $zipcode = 'NA';
             @endphp
                {{ $zipcode}}
         </div>
         <div class="clearfix"></div>
    </div> 
    



     <div class="myprofile-main">
         <div class="myprofile-lefts">Age verification</div>
         <div class="myprofile-right">
             @php
             if(($user_arr['get_buyer_detail']['approve_status']==0) && ($user_arr['get_buyer_detail']['front_image']=='') && ($user_arr['get_buyer_detail']['back_image']=='') && ($user_arr['get_buyer_detail']['selfie_image']=='') ) {
                $age_vefificationstatus = '<span class="status-dispatched">Age verification details not uploaded</span>';
             }
              elseif($user_arr['get_buyer_detail']['approve_status']=='0' && ($user_arr['get_buyer_detail']['front_image']!='') && ($user_arr['get_buyer_detail']['back_image']!='') && ($user_arr['get_buyer_detail']['selfie_image']!='') ){
                $age_vefificationstatus = '<span class="status-dispatched">Pending</span>';
              }

              elseif($user_arr['get_buyer_detail']['approve_status']=='3' && ($user_arr['get_buyer_detail']['front_image']!='') && ($user_arr['get_buyer_detail']['back_image']!='') && ($user_arr['get_buyer_detail']['selfie_image']!='') ){
                $age_vefificationstatus = '<span class="status-dispatched">Submitted</span>';
              }

              elseif($user_arr['get_buyer_detail']['approve_status']==1){
                $age_vefificationstatus = '<span class="status-completed">Approved</span>';
              }
              elseif($user_arr['get_buyer_detail']['approve_status']==2){
                $age_vefificationstatus = '<span class="status-shipped">Rejected</span>';
              }

              echo $age_vefificationstatus;
            
             @endphp
                
         </div>
         <div class="clearfix"></div>
    </div>

     <div class="myprofile-main">
         <div class="myprofile-lefts">Profile verification</div>
         <div class="myprofile-right">
             @php
             if($user_arr['approve_status']=='0')
                $profile_vefificationstatus = '<span class="status-dispatched">Pending</span>';
              elseif($user_arr['approve_status']=='3')
                $profile_vefificationstatus = '<span class="status-dispatched">Submitted</span>';               
              elseif($user_arr['approve_status']==1)
                $profile_vefificationstatus = '<span class="status-completed">Approved</span>';
              elseif($user_arr['approve_status']==2)
                $profile_vefificationstatus = '<span class="status-shipped">Rejected</span>';

              echo $profile_vefificationstatus;
            
             @endphp
                
         </div>
         <div class="clearfix"></div>
    </div>



        <div class="myprofile-main">
         <div class="myprofile-lefts">How did you hear about us?</div>
         <div class="myprofile-right">{{ isset($user_arr['hear_about'])?$user_arr['hear_about']:'NA' }}</div>
         <div class="clearfix"></div>
        </div>





  {{--   <div class="myprofile-main">
         <div class="myprofile-lefts">Location</div>
         <div class="myprofile-right">{{ $address_arr['street_address1'] or '' }}</div>
         <div class="clearfix"></div>
    </div> --}}
   {{--  <div class="myprofile-main">
         <div class="myprofile-lefts">Country</div>
         <div class="myprofile-right">{{ isset($address_arr['country_details']['name'])?ucfirst(strtolower($address_arr['country_details']['name'])):'--' }}</div>
         <div class="clearfix"></div>
    </div> --}}
    <div class="myprofile-main">
         <div class="myprofile-lefts">Last Login Time</div>
         <div class="myprofile-right">{{ isset($user_arr['last_login'])?date('d-M-Y H:i A',strtotime($user_arr['last_login'])):'Not Login Yet!' }}</div>
         <div class="clearfix"></div>
    </div>


      {{--  @if(isset( $user_arr['get_buyer_detail']['id_proof']) && $user_arr['get_buyer_detail']['id_proof']!='' && $user_arr['get_buyer_detail']['approve_status']==1)
          <div class="myprofile-main">
               <div class="myprofile-lefts">Identity Proof</div>
               <div class="myprofile-right">
                  <label>Approved</label>
                @if(file_exists(base_path().'/uploads/id_proof/'.$user_arr['get_buyer_detail']['id_proof']))
                  <a href="{{$user_id_proof_public_path}}{{$user_arr['get_buyer_detail']['id_proof']}}" target="_blank">View Proof</a>
                @endif


              </div>
               <div class="clearfix"></div>
          </div>
       @endif --}}




   </div>
</div>



                     
                     </div>
                     <div class="form-group row">
                        <div class="col-12 text-center">
                           <a class="btn btn-inverse waves-effect waves-light show-btns" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
<!-- END Main Content -->
@stop