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
         <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
         <li><a href="{{$module_url_path}}">{{$module_title or ''}}</a></li>
         <li class="active">Create Sub Admin</li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>
<!-- BEGIN Main Content -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box">
         @include('admin.layout._operation_status')
         <div class="row">
            <div class="col-sm-12 col-xs-12">

                {!! Form::open([
               'method'=>'POST',
               'enctype' =>'multipart/form-data',   
               'class'=>'form-horizontal', 
               'id'=>'validation-form' 
               ]) !!} 
               <!-- {{ csrf_field() }} --> 


                <input type="hidden" name="lat"  required="" id="lat" value="-34.397" class="clearField">
                <input type="hidden" name="lng"  required="" id="lng"  value="150.644" class="clearField"> 
                <input type="hidden" name="city" id="city" class="clearField">
                {{-- <input type="hidden" name="state" id="state" class="clearField"> --}}
                <input type="hidden" name="post_code" id="post_code" class="clearField">


               {{-- <div class="form-group row">
                  <label class="col-md-2 col-form-label">User Role<i class="red">*</i></label>
                  <div class="col-md-10">                  
                      <select class="form-control"  name="user_role" data-parsley-required="true">
                        <option value="">--Select Role--</option>                       
                        @if(isset($role_arr) && count($role_arr)>0)
                          @foreach($role_arr as $key => $value)
                          <option value="{{ $value['slug'] }}">{{ $value['name'] }}</option>
                          @endforeach
                        @endif
                     </select>
                  </div>
               </div> --}}
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">First Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" value="{{ old('first_name') }}" data-parsley-required-message="Please enter first name" />
                     <span class="red">{{ $errors->first('first_name') }}</span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Last Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" value="{{ old('last_name') }}" data-parsley-required-message="Please enter last name" />
                     <span class="red">{{ $errors->first('last_name') }}</span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Email<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="email" placeholder="Enter Email" data-parsley-required="true" data-parsley-type="email" value="{{ old('email') }}" data-parsley-required-message="Please enter email" />
                     <span class="red">{{ $errors->first('email') }}</span>
                  </div>
               </div>
             
               <!-- <div class="form-group row">
                  <label class="col-2 col-form-label">Phone<i class="red">*</i></label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="phone" placeholder="Enter Phone No" data-parsley-required="true" data-parsley-length="[6, 16]" value="{{ old('phone') }}" />
                     <span class="red">{{ $errors->first('phone') }}</span>
                  </div>
               </div> -->
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">New Password<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New password" value="{{ old('new_password') }}" data-parsley-required-message="Please enter password" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character" data-parsley-minlength="8"/>
                     <span class="red">{{ $errors->first('new_password') }}</span>
                  </div>
               </div>  
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Confirm Password<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="password" class="form-control" name="confirm_password" placeholder="Enter confirm password" data-parsley-required="true" data-parsley-equalto="#new_password" data-parsley-error-message="Confirm password should be the same as new password" value="{{ old('confirm_password') }}" />
                     <span class="red">{{ $errors->first('confirm_password') }}</span>
                  </div>
               </div>

                <div class="form-group row">
                  <label class="col-2 col-form-label">City<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="city" placeholder="City" id="city" id="locality" value="{{ old('city') }}" data-parsley-required="true" data-parsley-required-message="Please enter city"/>
                     <span class="red">{{ $errors->first('city') }}</span>
                  </div>
               </div> 

                
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Country<i class="red">*</i></label>
                  <div class="col-md-10">
                     <select class="form-control" data-parsley-required="true" id="country" name="country" data-parsley-required-message="Please Select the Country" onchange="get_states()">
                      @if(isset($countries_arr) && count($countries_arr)>0)
                      <option value="">Select Country</option>
                      @foreach($countries_arr as $country)
                       <option value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
                      @endforeach
                      @else
                      <option>Countries Not Available</option>
                      @endif 
                     </select>
                     <span class="red">{{ $errors->first('country') }}</span>
                  </div>
               </div>

               <div class="form-group row">                
                <label class="col-md-2 col-form-label" for="state">State <i class="red">*</i></label>
                <div class="col-md-10">
                  <select class="form-control" data-parsley-required="true" data-parsley-required-message="Please select state " id="state" name="state">
                     <option value="">Select State</option>
                  </select> 
                </div> 
              </div> 

              <div class="form-group row">
                  <label class="col-2 col-form-label">Zip Code<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="zipcode" id="postal_code" placeholder="Enter Zip Code" value="{{ old('zipcode') }}" data-parsley-required="true" data-parsley-required-message="Please enter zipcode" data-parsley-length="[1,6]" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-pattern-message="Only alphanumeric are allowed." />
                     <span class="red">{{ $errors->first('zipcode') }}</span>
                  </div>
               </div>

              <div class="form-group row">
                  <label class="col-md-2 col-form-label">Address<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="street_address" id="address" placeholder="Enter address" data-parsley-required="true" value="" data-parsley-required-message="Please enter address" />
                     <span class="red">{{ $errors->first('street_address') }}</span>
                  </div>
               </div>

          
               <div class="form-group row">
                  <div class="col-md-10">
                     <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Save" id="btn_add">Save</button>
                        <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                  </div>
               </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
  var module_url_path  = "{{ $module_url_path or ''}}";
</script>

<script type="text/javascript">
  $(document).ready(function()
  {
    $('#btn_add').click(function()
    {
        if($('#validation-form').parsley().validate()==false) return;
        $.ajax({
                    
            url: module_url_path+'/save',
            data: new FormData($('#validation-form')[0]),
            contentType:false,
            processData:false,
            method:'POST',
            cache: false,
            dataType:'json',
            beforeSend: function () {
              showProcessingOverlay();
            },
            success:function(data)
            {
               hideProcessingOverlay();  
                if('success' == data.status)
                {
                                  
                  $('#validation-form')[0].reset();

                    swal({
                           title: 'Success',
                           text: data.description,
                           type: data.status,
                           confirmButtonText: "OK",
                           closeOnConfirm: false
                        },
                       function(isConfirm,tmp)
                       {
                         if(isConfirm==true)
                         {  
                            window.location.href = data.link;
                         }
                       });
                }
                else
                {
                   swal('Alert!',data.description,data.status);
                }  
            }
            
        });   

    });
    

  });

  function get_states()
    {
      var country_id  = $('#country').val();
        
      $.ajax({
              url:module_url_path+'/get_states',
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
@stop