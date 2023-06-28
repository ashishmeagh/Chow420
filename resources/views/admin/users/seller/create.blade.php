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
            
         <li><a href="{{$module_url_path}}">{{$module_title or ''}}</a></li>
         <li class="active">Create Dispensary</li>
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
              {{ csrf_field() }} 


              {{--  <input type="hidden" name="lat"  required="" id="lat" value="-34.397" class="clearField">
                <input type="hidden" name="lng"  required="" id="lng"  value="150.644" class="clearField"> 
                <input type="hidden" name="city" id="city" class="clearField">
                <input type="hidden" name="state" id="state" class="clearField">
                <input type="hidden" name="post_code" id="post_code" class="clearField">

               </div> --}}
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">First Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$"
                    value="{{ old('first_name') }}" data-parsley-required-message="Please enter first name" />
                     <span class="red">{{ $errors->first('first_name') }}</span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Last Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="last_name" placeholder="Enter Lastname" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" value="{{ old('last_name') }}" data-parsley-required-message="Please enter last name" />
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



              {{--   <div class="form-group row">
                  <label class="col-md-2 col-form-label">Mobile<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter Mobile no" data-parsley-required="true" data-parsley-required-message="Please enter mobile number" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="number" value="{{ old('phone') }}" />
                     <span class="red">{{ $errors->first('mobile_no') }}</span>
                  </div>
               </div> --}}


{{--              
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Country<i class="red">*</i></label>
                  <div class="col-md-10">
                     <select class="form-control" data-parsley-required="true" id="country" name="country">
                      @if(isset($countries_arr) && count($countries_arr)>0)
                      <option value="">Select Country</option>
                      @foreach($countries_arr as $country)
                       <option data-iso="{{$country['iso']}}" value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
                      @endforeach
                      @else
                      <option>Countries Not Available</option>
                      @endif
                     </select>
                     <span class="red">{{ $errors->first('confirm_password') }}</span>
                  </div>
               </div> --}}
               
               

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Address<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="street_address" id="address" placeholder="Enter address" data-parsley-required="true" value="{{ old('location') }}" data-parsley-required-message="Please enter address" />
                     <span class="red">{{ $errors->first('street_address') }}</span>
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
                  <label class="col-md-2 col-form-label">Business Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="business_name" id="business_name" placeholder="Enter Business Name" data-parsley-required="true" value="{{ old('business_name') }}" data-parsley-required-message="Please enter business name" 
                     data-parsley-pattern="/^([A-Za-z0-9]+ )+[A-Za-z0-9]+$|^[A-Za-z0-9]+$/" data-parsley-pattern-message="Please remove special characters from business name"/>
                     <span class="red">{{ $errors->first('business_name') }}</span>
                  </div>
               </div>

               {{--  <div class="form-group row">
                  <label class="col-md-2 col-form-label">Tax Id<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="tax_id" id="tax_id" placeholder="Enter Tax Id" data-parsley-required="true" data-parsley-type="digits" data-parsley-maxlength="9" data-parsley-minlength="9"  value="{{ old('tax_id') }}" data-parsley-required-message="Please enter tax id" />
                     <span class="red">{{ $errors->first('tax_id') }}</span>
                  </div>
               </div> --}}
 
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Registered Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="registered_name" id="registered_name" placeholder="Enter registered name" data-parsley-required="true" value="{{ old('registered_name') }}" data-parsley-required-message="Please enter registered name" data-parsley-pattern="/^[a-zA-Z ]*$/" />
                     <span class="red">{{ $errors->first('registered_name') }}</span>
                  </div>
               </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Account Number<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="account_no" id="account_no" placeholder="Enter account number" data-parsley-required="true" value="{{ old('account_no') }}" data-parsley-required-message="Please enter account number" />
                     <span class="red">{{ $errors->first('account_no') }}</span>
                  </div>
               </div> 


               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Routing Number<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="routing_no" id="routing_no" placeholder="Enter routing number" data-parsley-required="true" value="{{ old('routing_no') }}" data-parsley-required-message="Please enter routing number" />
                     <span class="red">{{ $errors->first('routing_no') }}</span>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Swift Number<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="switft_no" id="switft_no" placeholder="Enter swift number" data-parsley-required="true" value="{{ old('switft_no') }}" data-parsley-required-message="Please enter swift number" />
                     <span class="red">{{ $errors->first('switft_no') }}</span>
                  </div>
               </div>


               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Paypal Email <i class="red"></i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="paypal_email" id="paypal_email" placeholder="Enter paypal email"  data-parsley-type="email" value="{{ old('paypal_email') }}" data-parsley-required-message="Please enter paypal email" />
                     <span class="red">{{ $errors->first('paypal_email') }}</span>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Is Featured</label>
                    <div class="col-sm-6 col-lg-8 controls">
                       <input type="checkbox" name="is_featured" id="is_featured" value="0" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_featured();" />
                    </div>    
                </div> 

 

              {{--  <div class="col-md-2"></div>
               <div id="draggable_map" style="height:300px;width: 735px"></div>
               <br> --}}
              <!--  <div class="form-group row">
                  <label class="col-2 col-form-label">Country<i class="red">*</i></label>
                  <div class="col-10">
                     <select class="form-control"  name="country" data-parsley-required="true" onchange="changeCountryRestriction(this)" >
                        <option value="">--Select Country--</option>
                        @if(isset($arr_country) && count($arr_country)>0)
                        @foreach($arr_country as $key => $value)
                        <option value="{{ $value['country_code'] }}">{{ $value['country_name'] }}</option>
                        @endforeach
                        @endif
                     </select>
                     <span class="red">{{ $errors->first('role') }}</span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">Street Address<i class="red">*</i></label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="street_address" placeholder="Enter Street Address" data-parsley-required="true"  value="{{ old('street_address') }}" />
                     <span class="red">{{ $errors->first('street_address') }}</span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">State</label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="state" placeholder="State" id="administrative_area_level_1" readonly=""  value="{{ old('state') }}" />
                     <span class="red">{{ $errors->first('state') }}</span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">City</label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="city" placeholder="City" id="administrative_area_level_1" id="locality" readonly=""  value="{{ old('city') }}" />
                     <span class="red">{{ $errors->first('city') }}</span>
                  </div>
               </div> 
               <div class="form-group row">
                  <label class="col-2 col-form-label">Zip Code</label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="zipcode" id="postal_code" placeholder="Enter Zip Code" data-parsley-length="[4, 12]" value="{{ old('zipcode') }}" />
                     <span class="red">{{ $errors->first('zipcode') }}</span>
                  </div>
               </div> -->


               
              {{--  <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="profile_image">Id Proof <i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="file" name="id_proof" id="id_proof" class="dropify"  data-max-file-size="2M" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" data-parsley-required="true" data-parsley-required-message="Id Proof is Required" />
                  </div>
               </div>
 
               <span>{{ $errors->first('id_proof') }}</span> --}}




              {{--  
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Is Active</label>
                      <div class="col-sm-6 col-lg-8 controls">
                         <input type="checkbox" name="is_active" id="is_active" value="1" checked="checked" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
                      </div>    
                </div>  --}}


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
{{-- <script src="https://maps.googleapis.com/maps/api/js?v=3&key={{$google_api_key_arr['data_value'] or ''}}&libraries=places&callback=initAutocomplete"
   async defer></script> --}}
{{-- <script src="http://maps.googleapis.com/maps/api/js?key={{$google_api_key_arr['data_value'] or ''}}&libraries=places" type="text/javascript"></script> --}}
{{-- <script type="text/javascript" src="{{ url('/assets/admin/module_js/user.js') }}"></script> --}}
{{-- <script type="text/javascript" src="{{url('/')}}/assets/js/autocomplete_js.js"></script> --}}
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
                           title:'Success' ,
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
       

    //var incr = 1;
   // var glob_options = {};
   // glob_options.types = [];
  
  //$("#country").on('change',function(){      
  //    $('.clearField').val('');          
  //    handlerchangeCountryRestriction($(this),'selected');
  //    var country_id = ($('select[name=country]').val());
 // });

   // $('#address').on('keyup keypress', function(e) 
   // {
   //  var keyCode = e.keyCode || e.which;
   //  if (keyCode === 13) { 
    //   e.preventDefault();
    //   return false;
   //  }
  //  });
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


   function toggle_featured()
  {
      var is_featured = $('#is_featured').val();
      if(is_featured=='1')
      {
        $('#is_featured').val('0');
      }
      else
      {
        $('#is_featured').val('1');
      }
  }

  //  function toggle_status()
  // {
  //     var is_active = $('#is_active').val();
  //     if(is_active==0)
  //     {
  //       $('#is_active').val('1');
  //     }
  //     else
  //     {
  //       $('#is_active').val('0');
  //     }
  // }

</script>
@stop