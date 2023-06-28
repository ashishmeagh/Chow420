@extends('seller.layout.master')
@section('main_content')

<style type="text/css">

.uplaod-edit-img {
    width: 100px;
    height: 100px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-top: 10px;
 overflow: hidden;
 padding: 5px;
}
.profl-em img{width: 100%; height: 100%;}
.yprofiles{position: relative; margin-bottom: 25px;}
.yprofiles .form-control{height: 45px;padding: 0;}
.yprofiles input[type=file]::-webkit-file-upload-button {
     background-color: #333;
     padding: 5px 20px; border: none; height: 45px; color: #ffff;
     position: absolute; left: 0px; top: 0px;
}
</style>

<div class="my-profile-pgnm">Edit Profile
     <ul class="breadcrumbs-my">
     <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
     <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/seller/profile">My Profile</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Edit Profile</li>
    </ul>
</div>
<div class="new-wrapper">

<div class="main-my-profile">

    <form id="frm-profile">
        {{ csrf_field() }}
   <div class="innermain-my-profile">

     <input type="hidden" name="old_front_image" value="{{$user_details_arr['user_details']['front_image'] or ''}}"> 
     <input type="hidden" name="old_back_image" value="{{$user_details_arr['user_details']['back_image'] or ''}}"> 

     <div id="status_msg"></div>
{{-- 
   <div class="profile-img-block">
        <div class="pro-img">
            @if(isset($user_details_arr['profile_image']) && $user_details_arr['profile_image']!=''&& file_exists(base_path().'/uploads/profile_image/'.$user_details_arr['profile_image']))

              <img src="{{ $profile_img_path}}/{{$user_details_arr['profile_image']}}" class="img-responsive img-preview" alt="" id="upload-f" />
            @else
              <img src="{{url('/assets/images/user-degault-img.jpg')}}" class="img-responsive img-preview" alt="" id="upload-f" />
            @endif
        </div>                            
        <div class="update-pic-btns">
            <button class="up-btn"> <span><i class="fa fa-camera"></i></span></button>

            <input style="height: 100%; width: 100%; z-index: 99;" id="profile-image" name="profile-image"  type="file" class="attachment_upload"> 

            <input type="hidden" name="old_profile_img" value="{{$user_details_arr['profile_image'] or ''}}">
        </div>                            
    </div>  --}}

    
       <div class="row">
           <div class="col-md-6">
                 <div class="form-group">
                    <label for="">First Name <span>*</span></label>
                     <input type="text" class="input-text" placeholder="Enter First Name" value="{{$user_details_arr['first_name'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter first name" data-parsley-pattern="^[a-zA-Z]+$" id="first_name" name="first_name" />
                </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Last Name <span>*</span></label>
                    <input type="text" placeholder="Enter Last Name"  class="input-text" value="{{$user_details_arr['last_name'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter last name" data-parsley-pattern="^[a-zA-Z]+$" id="last_name" name="last_name" />
                </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Email Address <span>*</span></label>
                     <input type="email" placeholder="Enter Email Address" class="input-text disbl-input" value="{{$user_details_arr['email'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter email" id="email" name="email" readonly=""/>
                </div>
            </div> 

             <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Mobile Number <span>*</span></label>
                     <input type="text" placeholder="Enter Mobile No"  class="input-text" data-parsley-required="true" data-parsley-required-message="Please enter mobile number" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="number" id="mobile_no" name="mobile_no" value="{{$user_details_arr['phone'] or ''}}"/>
                </div>
            </div>

             <div class="col-md-12">
                 <div class="form-group">
                    <label for="">Address <span>*</span></label>
                   {{--  <input type="text" placeholder="Enter Address" value="{{$user_details_arr['street_address'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter address" id="street_address" name="street_address" class="input-text" /> --}}

                   <textarea data-parsley-required="true" data-parsley-required-message="Please enter address" id="street_address" name="street_address" placeholder="Enter Address" class="input-text">{{$user_details_arr['street_address'] or ''}}</textarea>

                </div>
            </div> 

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">City <span>*</span></label>
                    <input type="text" id="city" name="city" value="{{$user_details_arr['city'] or ''}}" data-parsley-required="true" class="input-text" placeholder="City"  data-parsley-required-message="Please enter city">
                </div>
            </div>    


             <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Country <span>*</span></label>
                     @php
                         $country_id = isset($user_details_arr['country'])?$user_details_arr['country']:0;
                    @endphp
                    <div class="select-style">
                    <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select country" id="country" name="country" onchange="get_states()">

                      @if(isset($countries_arr) && count($countries_arr)>0)
                      <option value="">Select Country</option>
                      @foreach($countries_arr as $country)


                       <option  @if($country['id']==$country_id) selected="selected" @endif value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
                     
                      @endforeach
                      @else
                      <option>Countries Not Available</option>
                      @endif
                     </select> 
                    </div>
                    </div>
                
            </div>

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">State <span>*</span></label>
                    @php
                         $state_id = isset($user_details_arr['state'])?$user_details_arr['state']:0;
                        
                    @endphp
                    <div class="select-style">
                    <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state " id="state" name="state">
                      @if(isset($states_arr) && count($states_arr)>0)
                      <option value="">Select State</option>
                      @foreach($states_arr as $state)
                      
                       <option  @if($state['id']==$state_id) selected="selected" @endif value="{{$state['id']}}">{{isset($state['name'])?ucfirst(strtolower($state['name'])):'--' }}</option>
                     
                      @endforeach
                      @else
                      <option>State Not Available</option>
                      @endif
                      
                     </select> 
                </div>
                </div>
            </div>



            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Zip Code <span>*</span></label>
                     <input type="text" placeholder="Enter Zip Code"  class="input-text" value="{{$user_details_arr['zipcode'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter zip code " id="post_code" name="zipcode" data-parsley-type="number" data-parsley-type-message="Please enter valid zip code"/>
                </div>
            </div>
                                
            {{--  <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Country Code<span>*</span></label>
                     <input type="text" placeholder="Enter Country Code"  class="input-text" data-parsley-required="true" data-parsley-required-message="Country code is required" data-parsley-type="number" id="country" name="country" value="{{$user_details_arr['country'] or '1'}}"/>
                </div>
            </div>  --}} 

            

           

            <div class="col-md-12">
                <div class="button-list-dts">
                    <a href="#" class="butn-def" id="btn-profile">Save</a>
                    <a href="{{ url('/') }}/seller/profile" class="butn-def cancelbtnss">Cancel</a>
                </div>
            </div>
       </div>
   </div>
  </form>
</div>
</div>
<script type="text/javascript">


    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $('#upload-f')
                    .attr('src', e.target.result)
                    .width(160)
                    .height(160);
            };
    
            reader.readAsDataURL(input.files[0]);
        }
    } 
    $('#btn-profile').click(function(){
      
      /*Check all validation is true*/
      if($('#frm-profile').parsley().validate()==false) return;

      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/profile/update',

        data:new FormData($('#frm-profile')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-profile').prop('disabled',true);
          $('#btn-profile').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
            
          hideProcessingOverlay();
          $('#btn-profile').prop('disabled',false);
          $('#btn-profile').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg').html(success_HTML);
                    // window.location.reload();
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                
                $('#status_msg').html(error_HTML);
            }
          }
        }
      });
    });





     function get_states()
  {
      var country_id  = $('#country').val();
        
      $.ajax({
              url:SITE_URL+'/seller/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(response)
              { 
                  
                  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                  $("#state").html(html);
              }
      });
  }

</script>    
@endsection
