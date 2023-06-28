@extends('buyer.layout.master')
@section('main_content')
<style type="text/css">
    .editmyprofiles.edtspro{
    width: auto;
    height: auto;
    color: #787878;
    right: 30px;
  }
</style> 
<div class="my-profile-pgnm">
    {{isset($page_title)?$page_title:''}}

      <ul class="breadcrumbs-my">
        <li><a href="{{url('/')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i></li>
        <li>Profile</li>
      </ul>   
</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">
    <div class="main-my-profile">
        <div class="innermain-my-profile paddingnones">
            {{--
            <div class="profile-img-block myprofile-view">
                @if(isset($user_details_arr['profile_image']) && $user_details_arr['profile_image']!='' && file_exists(base_path().'/uploads/profile_image/'.$user_details_arr['profile_image']))
                <img alt="" class="profile" id="upload-f" src="{{$profile_img_path.'/'.$user_details_arr['profile_image']}}">
                    @else
                    <img alt="" class="profile" id="upload-f" src="{{url('/')}}/assets/images/Profile-img-new.jpg">
                        @endif
                    </img>
                </img>
            </div>
            --}}
            <!--------- if one of them approved then  request change button --------------------->
            {{--   @if(isset($user_details_arr['user_details']['approve_status']) && ($user_details_arr['user_details']['approve_status']=='1' )) --}}

  
@php 
 
 //$user_details_arr['user_details']['approve_status']; // age verification approved
 //$user_details_arr['approve_status']; // profile approved

@endphp




            @if(isset($user_details_arr['user_details']['approve_status']) && ($user_details_arr['user_details']['approve_status']=='1' ) && ($user_details_arr['approve_status']==1) )
            {{-- <div class="text-right">
                <a class="eye-actn" href="mailto:{{ $admin_arr['email'] }}" title="mailto:{{isset($admin_arr['email'])?$admin_arr['email']:''}}">
                    Request Change 
                </a>
            </div> --}}

                @if(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']=='1' )

                   <a class="editmyprofiles edtspro" href="{{url('/')}}/buyer/profile/update" title="Edit Profile" onclick="return changepassword()">
                    <img alt="" src="{{url('/')}}/assets/buyer/images/edit-profile.png"  />
                    Edit Profile
                   </a>
                @endif



            @elseif(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']=='2' )
            <a class="editmyprofiles edtspro" href="{{url('/')}}/buyer/profile/update" title="Edit Profile">
                <img alt="" src="{{url('/')}}/assets/buyer/images/edit-profile.png"/>
                Edit Profile
            </a>
            @else
            <a class="editmyprofiles edtspro" href="{{url('/')}}/buyer/profile/update" title="Edit Profile">
                <img alt="" src="{{url('/')}}/assets/buyer/images/edit-profile.png"/>
                Edit Profile
            </a>
            @endif



            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    First Name
                </div>
                @php
                      if($user_details_arr['first_name']!='')
                        $firstname = $user_details_arr['first_name'];
                      else 
                        $firstname = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{$firstname}}
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Last Name
                </div>
                @php
                      if($user_details_arr['last_name']!='')
                        $lastname = $user_details_arr['last_name'];
                      else 
                        $lastname = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{$lastname}}
                </div>
                <div class="clearfix">
                </div>
            </div>

            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Age
                </div>
                @php
                    $dob = isset($user_details_arr['date_of_birth']) ? $user_details_arr['date_of_birth'] : '';
                    $age = (date('Y') - date('Y',strtotime($dob))) . " Years";
                @endphp
                <div class="myprofile-right">
                    {{$age}} 
                </div>
                <div class="clearfix">
                </div>
            </div>

             <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Date of birth
                </div>
                @php
                    $dob = isset($user_details_arr['date_of_birth']) ? $user_details_arr['date_of_birth'] : 'NA';
                @endphp
                <div class="myprofile-right">
                    {{$dob}} 
                </div>
                <div class="clearfix">
                </div>
            </div>
            


             @if(isset($user_details_arr['phone']) && $user_details_arr['phone'] != '')
                <div class="myprofile-main">
                    <div class="myprofile-lefts">
                        Phone
                    </div>
                    @php
                        $phone = $user_details_arr['phone'];
                    @endphp
                    <div class="myprofile-right">
                        {{$phone}} 
                    </div>
                    <div class="clearfix">
                    </div>
                </div>
            @endif




            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Email Address
                </div>
                @php
                      if($user_details_arr['email']!='')
                        $email = $user_details_arr['email'];
                      else 
                        $email = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ $email }}
                </div>
                <div class="clearfix">
                </div>
            </div>
           {{--  <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Mobile Number
                </div>
                @php
                      if($user_details_arr['phone']!='')
                        $phone = $user_details_arr['phone'];
                      else 
                        $phone = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{$phone}}
                </div>
                <div class="clearfix">
                </div>
            </div> --}}
            <div class="myprofile-main">
                <div class="">
                    <u>
                        Shipping Details
                    </u>
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Shipping Address
                </div>
                @php
                      if($user_details_arr['street_address']!='')
                        $street_address = $user_details_arr['street_address'];
                      else 
                        $street_address = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($street_address)}}
                </div>
                <div class="clearfix">
                </div>
            </div>

            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Shipping City
                </div>
                @php
                      if($user_details_arr['city']!='')
                        $city = $user_details_arr['city'];
                      else 
                        $city = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($city)}}
                </div>
                <div class="clearfix">
                </div>
            </div> 


            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Shipping State
                </div>
                @php
                      if(isset($user_details_arr['get_states_arr']['name']))
                        $state_name = isset($user_details_arr['get_states_arr']['name'])?$user_details_arr['get_states_arr']['name']:'';
                      else 
                        $state_name = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($state_name)}}
                </div>
                <div class="clearfix">
                </div>
            </div> 
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Shipping Country
                </div>
                @php
                      if(isset($user_details_arr['get_countries_arr']['name']))
                        $country_name = isset($user_details_arr['get_countries_arr']['name'])?$user_details_arr['get_countries_arr']['name']:'';
                      else 
                        $country_name = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($country_name)}}
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Shipping Zipcode
                </div>
                @php
                      if($user_details_arr['zipcode']!='')
                        $zipcode = $user_details_arr['zipcode'];
                      else 
                        $zipcode = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($zipcode)}}
                </div>
                <div class="clearfix">
                </div>
            </div>


          



            <div class="myprofile-main">
                <div class="">
                    <u>
                        Billing Details
                    </u>
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Billing Address
                </div>
                @php
                      if($user_details_arr['billing_street_address']!='')
                        $billing_street_address = $user_details_arr['billing_street_address'];
                      else 
                        $billing_street_address = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($billing_street_address)}}
                </div>
                <div class="clearfix">
                </div>
            </div>

             <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Billing City
                </div>
                @php
                      if($user_details_arr['billing_city']!='')
                        $billing_city = $user_details_arr['billing_city'];
                      else 
                        $billing_city = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($billing_city)}}
                </div>
                <div class="clearfix">
                </div>
            </div>
            
            
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Billing State
                </div>
                @php
                      if(isset($user_details_arr['get_billing_states_arr']['name']))
                        $billing_state_name = isset($user_details_arr['get_billing_states_arr']['name'])?$user_details_arr['get_billing_states_arr']['name']:'';
                      else 
                        $billing_state_name = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($billing_state_name)}}
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Billing Country
                </div>
                @php
                      if(isset($user_details_arr['get_billing_countries_arr']['name']))
                        $billing_country_name = isset($user_details_arr['get_billing_countries_arr']['name'])?$user_details_arr['get_billing_countries_arr']['name']:'';
                      else 
                        $billing_country_name = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($billing_country_name)}}
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Billing Zipcode
                </div>
                @php
                      if($user_details_arr['billing_zipcode']!='')
                        $billing_zipcode = $user_details_arr['billing_zipcode'];
                      else 
                        $billing_zipcode = 'NA';
                     @endphp
                <div class="myprofile-right">
                    {{ucfirst($billing_zipcode)}}
                </div>
                <div class="clearfix">
                </div>
            </div>


            
 



            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Age Verification
                </div>
                @if(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']=='0' && $user_details_arr['user_details']['front_image']=="" &&  $user_details_arr['user_details']['back_image']==""    
                   &&  $user_details_arr['user_details']['selfie_image']=="" 
                   && $user_details_arr['user_details']['age_address']=="")
                <div class="myprofile-right">
                    <div class="status-dispatched">
                        Age details not uploaded
                    </div>
                </div>
                @elseif(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']=='3' && $user_details_arr['user_details']['front_image']!="" &&  $user_details_arr['user_details']['back_image']!="" 
                    &&  $user_details_arr['user_details']['selfie_image']!=""
                      && $user_details_arr['user_details']['age_address']!="")
                <div class="myprofile-right">
                    <div class="status-dispatched">
                      {{--   Pending --}}
                      Submitted
                    </div>
                </div>
                @elseif(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']==1)
                <div class="myprofile-right">
                    <div class="status-completed">
                        Approved
                    </div>
                </div>
                @elseif(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']==2)
                <div class="myprofile-right">
                    <div class="status-shipped">
                        Rejected
                    </div>
                </div>
                <div class="main-rejects">
                    <div class="myprofile-lefts">
                        Reject Reason
                    </div>
                    <div class="myprofile-right">
                        {{isset($user_details_arr['user_details']['note'])?$user_details_arr['user_details']['note']:''}}
                    </div>
                </div>
                <div class="clearfix">
                </div>
                @else
                <div>
                    --
                </div>
                {{--   @if(isset($user_details_arr['user_details']['id_proof']) && $user_details_arr['user_details']['id_proof']!='')
                <img alt="" class="profile" id="upload-f" src="{{$id_proof_path.'/'.$user_details_arr['user_details']['id_proof']}}">
                    @else
                    <img alt="" class="profile" id="upload-f" src="{{url('/')}}/assets/images/Profile-img-new.jpg">
                        @endif    --}}
                 @endif
                    </img>
                </img>
            </div>  
            <!--------------------------start of profile section------------------------------------------>
            <div class="myprofile-main">
                <div class="myprofile-lefts">
                    Profile Verification
                </div>
                @if(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='0' && ($user_details_arr['first_name']=="" ||  $user_details_arr['last_name']=="" || $user_details_arr['email']=="" || $user_details_arr['phone']=="" || $user_details_arr['street_address']=="" || $user_details_arr['country']=="" || $user_details_arr['state']=="" || $user_details_arr['zipcode']=="" || $user_details_arr['city']==""  || $user_details_arr['billing_street_address']=="" || $user_details_arr['billing_state']=="" || $user_details_arr['billing_country']=="" || $user_details_arr['billing_zipcode']=="" || $user_details_arr['billing_city']==""))
                <div class="myprofile-right">
                    <div class="status-dispatched">
                        Profile details not uploaded
                    </div>
                </div>
                @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['first_name']!="" &&  $user_details_arr['last_name']!="" &&  $user_details_arr['email']!="" &&  $user_details_arr['phone']!="" &&  $user_details_arr['street_address']!="" &&  $user_details_arr['country']!="" &&  $user_details_arr['state']!="" 
                   && $user_details_arr['zipcode']!='' && $user_details_arr['city']!='' 
                   && $user_details_arr['billing_street_address']!='' && $user_details_arr['billing_state']!='' && $user_details_arr['billing_country']!='' && $user_details_arr['billing_zipcode']!='' && $user_details_arr['billing_city']!='' && $user_details_arr['approve_status']=='3')
                <div class="myprofile-right">
                    <div class="status-dispatched">
                        {{-- Pending --}}
                        Submitted
                    </div>
                </div>
                @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']==1)
                <div class="myprofile-right">
                    <div class="status-completed">
                        Approved
                    </div>
                </div>
                @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']==2)
                <div class="myprofile-right">
                    <div class="status-shipped">
                        Rejected
                    </div>
                </div>
                <div class="main-rejects">
                    <div class="myprofile-lefts">
                        Reject Reason
                    </div>
                    @php
                        if($user_details_arr['note'])
                          $reject_reason = $user_details_arr['note'];
                        else
                          $reject_reason = 'NA';

                      @endphp
                    <div class="myprofile-right">
                        {{$reject_reason}}
                    </div> 
                </div>
                <div class="clearfix">
                </div>
                @else
                <div class="myprofile-right">
                    <div class="">
                      NA
                    </div>
                </div>
                @endif
            </div>
            <!---------------------------------------------------------------------->
            <div class="myprofile-main">
                <a href="{{url('/')}}/buyer/review-ratings">
                    <h4>
                        <b>
                            Reviews & Ratings
                        </b>
                    </h4>
                </a>
            </div>
        </div>
    </div>
</div>



<!---ShowConfirmPasswordModal-when buyer update profile--if age verified----------->


<div class="modal fade" id="ShowConfirmPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <form id="frm-change-passwordmodal">   
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel" align="center">Confirm Your Password</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <span id="status_msg"></span>
                {{ csrf_field() }}
                <div class="form-group form-box">
                   
                   <input type="password" id="current_password_profile" name="current_password" class="input-text" placeholder="Password" data-parsley-required="true" data-parsley-required-message="Enter current password">
                    
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <a href="#" class="btn-md btn btn-primary next-right confirmpasswordbtn"  id="btn-confirm-password" >Confirm Password</a>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
    function changepassword()
    {

        $("#ShowConfirmPasswordModal").modal('show');
        event.preventDefault();
    }

    $(document).on('click','.confirmpasswordbtn',function(){

    if($('#frm-change-passwordmodal').parsley().validate()==false) return;
   
    var current_password =  $("#current_password_profile").val();
    if(current_password)
    {

        $.ajax({
        url: SITE_URL+'/buyer/confirm_current_password',
        type:"GET",
        data: {
          current_password : current_password
        },             
        dataType:'json',
        beforeSend: function(){    
         showProcessingOverlay();     
          $("#loaderimg").show();
          $(".confirmpasswordbtn").hide();
        },  
        success:function(response)
        {
          $("#loaderimg").hide();
          $(".confirmpasswordbtn").show();
           hideProcessingOverlay(); 
          if(response.status == 'success')
          { 
            swal({
                    title: 'Success',
                    text: response.description,
                    type: 'success',
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                  },
                function(isConfirm,tmp)
                {                       
                  if(isConfirm==true)
                  {
                      window.location.href=SITE_URL+'/buyer/profile/update';
                  }

                });
          }
          else
          {                
            swal('Error',response.description,'error');
          }  
        }//success  
      }); 

    }else{
      return false;
    }  
    
  });
</script>




@endsection
