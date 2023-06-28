@extends('admin.layout.master')                

@section('main_content')
<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    @php
                      $user = Sentinel::check();
                    @endphp

                    @if(isset($user) && $user->inRole('admin'))
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                    @endif
                      
                    <li><a href="{{$module_url_path}}">{{$module_title or ''}}</a></li>
                    <li class="active">{{$page_title or ''}}</li>
                    
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
    <!-- .row -->
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

           @if(isset($arr_data) && count($arr_data) > 0)   

           {!! Form::hidden('user_id',isset($arr_data['id']) ? $arr_data['id']: "")!!}

            <input type="hidden" name="lat"  required="" id="lat" value="{{$address_arr['lat'] or ''}}" class="clearField">
            <input type="hidden" name="lng"  required="" id="lng"  value="{{$address_arr['lat'] or ''}}" class="clearField"> 
            <input type="hidden" name="city" id="city" class="clearField" value="{{$address_arr['city'] or ''}}">
            {{-- <input type="hidden" name="state" id="state" class="clearField" value="{{$address_arr['state'] or ''}}"> --}}
            <input type="hidden" name="post_code" id="post_code" class="clearField" value="{{$address_arr['post_code'] or ''}}">

            <input type="hidden" name="old_id_proof" id="old_id_proof" value="{{ $arr_data['seller_detail']['id_proof']}}"> 

         
             <div class="form-group row">
                  <label class="col-md-2 col-form-label">First Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" data-parsley-required="true" data-parsley-required-message="Please enter first name" data-parsley-pattern="^[a-zA-Z]+$"  value="{{ $arr_data['first_name'] or ''}}" />
                     <span class="red">{{ $errors->first('first_name') }}</span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Last Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" data-parsley-required="true" data-parsley-required-message="Please enter last name"  data-parsley-pattern="^[a-zA-Z]+$"  value="{{ $arr_data['last_name'] or ''}}" />
                     <span class="red">{{ $errors->first('last_name') }}</span>
                  </div>
               </div>

            <div class="form-group row">
                  <label class="col-md-2 col-form-label">Email<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="email" placeholder="Enter Email" data-parsley-required="true" data-parsley-type="email" data-parsley-required-message="Please enter email"  value="{{ $arr_data['email'] or ''}}" />
                     <span class="red">{{ $errors->first('email') }}</span>
                  </div>
            </div>



           {{--  <div class="form-group row">
                  <label class="col-md-2 col-form-label">Mobile<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter Mobile no" data-parsley-required="true" data-parsley-required-message="Please enter mobile number" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="number" value="{{ $arr_data['phone'] }}" />
                     <span class="red">{{ $errors->first('mobile_no') }}</span>
                  </div>
            </div> --}}



{{-- 
            <div class="form-group row">
              @php
                $country_id = isset($arr_data['country'])?$arr_data['country']:0;
                @endphp
                  <label class="col-md-2 col-form-label">Country<i class="red">*</i></label>
                  <div class="col-md-10">
                     <select class="form-control" data-parsley-required="true" id="country" name="country">
                      @if(isset($countries_arr) && count($countries_arr)>0)
                      <option value="">Select Country</option>
                      @foreach($countries_arr as $country)
                       <option data-iso="{{$country['iso']}}" @if($country['id']==$country_id) selected="selected" @endif value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
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
                       <input type="text" class="form-control" name="street_address" placeholder="Enter Address" data-parsley-required="true" data-parsley-required-message="Please enter address" value="{{ $arr_data['street_address'] or ''}}" />
                       <span class="red">{{ $errors->first('street_address') }}</span>
                    </div>
              </div>



              <div class="form-group row">
                  <label class="col-2 col-form-label">City<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="city" placeholder="City" id="city" id="locality" value="{{ $arr_data['city'] }}" data-parsley-required="true" data-parsley-required-message="Please enter city"/>
                     <span class="red">{{ $errors->first('city') }}</span>
                  </div>
              </div> 
              

               <div class="form-group row">
                @php
                $country_id = isset($arr_data['country'])?$arr_data['country']:0;
                @endphp
                  <label class="col-md-2 col-form-label">Country<i class="red">*</i></label>
                  <div class="col-md-10">
                     <select class="form-control" data-parsley-required="true" id="country" name="country" onchange="get_states()">
                      @if(isset($countries_arr) && count($countries_arr)>0)
                      <option value="">Select Country</option>
                      @foreach($countries_arr as $country)
                       <option @if($country['id']==$country_id) selected="selected" @endif value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
                      @endforeach
                      @else
                      <option>Countries Not Available</option>
                      @endif
                     </select>

                       


                     <span class="red">{{ $errors->first('country') }}</span>
                  </div>
              </div>
              <div class="form-group row">
                @php
                $state_id = isset($arr_data['state'])?$arr_data['state']:0;
                
                @endphp
                <label class="col-md-2 col-form-label" for="state">State <i class="red">*</i></label>
                <div class="col-md-10">
                  <select class="form-control" data-parsley-required="true" data-parsley-required-message="Please select state " id="state" name="state">
                    @if(isset($states_arr) && count($states_arr)>0)
                    <option value="">Select State</option>
                    @foreach($states_arr as $state)
                      <option  @if($state['id']==$state_id) selected @endif value="{{$state['id']}}">{{isset($state['name'])?ucfirst(strtolower($state['name'])):'--' }}</option>
                    @endforeach
                    @else
                    <option>State Not Available</option>
                    @endif
                    
                  </select> 
                </div> 
              </div> 
   



               <div class="form-group row">
                  <label class="col-2 col-form-label">Zip Code<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="zipcode" id="postal_code" placeholder="Enter Zip Code" value="{{ $arr_data['zipcode'] }}" data-parsley-required="true" data-parsley-required-message="Please enter zipcode"  data-parsley-length="[1,6]" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-pattern-message="Only alphanumeric are allowed."/>
                     <span class="red">{{ $errors->first('zipcode') }}</span>
                  </div>
               </div>




             <div class="form-group row">
                  <label class="col-md-2 col-form-label">Business Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="business_name" id="business_name" placeholder="Enter Business Name" data-parsley-required="true" data-parsley-required-message="Please enter business name" value="{{ $arr_data['seller_detail']['business_name'] or ''}}" 
                     data-parsley-pattern="/^([A-Za-z0-9]+ )+[A-Za-z0-9]+$|^[A-Za-z0-9]+$/"  data-parsley-pattern-message="Please remove special characters from business name"/>
                     <span class="red">{{ $errors->first('business_name') }}</span>
                  </div>
               </div>

               {{--  <div class="form-group row">
                  <label class="col-md-2 col-form-label">Tax Id<i class="red"></i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="tax_id" id="tax_id" placeholder="Enter Tax Id"  data-parsley-required-message="Please enter tax id" data-parsley-type="digits" data-parsley-maxlength="9" data-parsley-minlength="9" value="{{ $arr_data['seller_detail']['tax_id'] or ''}}" />
                  </div>
               </div>  --}}

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Registered Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="registered_name" id="registered_name" placeholder="Enter registered name" data-parsley-required="true" value="{{ $arr_data['seller_detail']['registered_name'] }}" data-parsley-required-message="Please enter registered name" data-parsley-pattern="/^[a-zA-Z ]*$/" />
                     <span class="red">{{ $errors->first('registered_name') }}</span>
                  </div>
               </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Account Number<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="account_no" id="account_no" placeholder="Enter account number" data-parsley-required="true" value="{{ $arr_data['seller_detail']['account_no'] }}" data-parsley-required-message="Please enter account number" />
                     <span class="red">{{ $errors->first('account_no') }}</span>
                  </div>
               </div> 


               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Routing Number<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="routing_no" id="routing_no" placeholder="Enter routing number" data-parsley-required="true" value="{{ $arr_data['seller_detail']['routing_no'] }}" data-parsley-required-message="Please enter routing number" />
                     <span class="red">{{ $errors->first('routing_no') }}</span>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Swift Number<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="switft_no" id="switft_no" placeholder="Enter swift number" data-parsley-required="true" value="{{ $arr_data['seller_detail']['switft_no'] }}" data-parsley-required-message="Please enter swift number" />
                     <span class="red">{{ $errors->first('switft_no') }}</span>
                  </div>
               </div>


               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Paypal Email <i class="red"></i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="paypal_email" id="paypal_email" placeholder="Enter paypal email"  data-parsley-type="email" value="{{ $arr_data['seller_detail']['paypal_email'] }}" data-parsley-required-message="Please enter paypal email" />
                     <span class="red">{{ $errors->first('paypal_email') }}</span>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Is Featured</label>
                    <div class="col-md-10">
                        @php
                          if(isset($arr_data['is_featured'])&& $arr_data['is_featured']!='')
                          {
                            $is_featured = $arr_data['is_featured'];
                          } 
                          else
                          {
                            $is_featured = 0;
                          }

                        @endphp
                        <input type="checkbox" name="is_featured" id="is_featured" value="{{ $is_featured }}" data-size="small" class="js-switch " @if($is_featured =='1') checked="checked" @endif data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_featured();" />
                    </div>    
               </div> 
 


             
     {{--        <div class="form-group row">
               <label class="col-md-2 col-form-label" for="state">Profile Image</label>
                <div class="col-md-10">
                  <input type="file" name="profile_image" id="profile_image" class="dropify" data-default-file="{{ $user_profile_public_img_path.$arr_data['profile_image']}}" />
                </div>
            </div> --}}
 
           {{--  <div class="form-group row">

               <label class="col-md-2 col-form-label" for="state">Id Proof</label>
                <div class="col-md-10">
                  <input type="file" name="id_proof" id="id_proof" class="dropify" data-default-file="{{ $user_id_proof.$arr_data['seller_detail']['id_proof']}}"  data-max-file-size="2M" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" />
                </div>
            </div> --}}



            <div class="form-group row">
              <div class="col-md-10">
                <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_add">Update</button>
                <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
              </div>
            </div>
            @else 
              <div class="form-group row">
                <div class="col-md-10">
                  <h3><strong>No Record found..</strong></h3>     
                </div>
              </div>
            @endif
    
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
        async defer>
</script> --}}
{{-- <script type="text/javascript" src="{{ url('/assets/admin/module_js/user.js') }}"></script> --}}
{{-- <script type="text/javascript" src="{{url('/')}}/assets/js/autocomplete_js.js"></script> --}}
<script>  
  $(document).ready(function(){

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


    {{-- handlerchangeCountryRestriction($('#country'),'selected');
    var country_id = ($('select[name=country]').val());

    var incr = 1;
    var glob_options = {};
    glob_options.types = [];
  
    $("#country").on('change',function(){      
        $('.clearField').val('');          
        handlerchangeCountryRestriction($(this),'selected');
        var country_id = ($('select[name=country]').val());
    });

    $('#address').on('keyup keypress', function(e) 
    {
     var keyCode = e.keyCode || e.which;
     if (keyCode === 13) { 
       e.preventDefault();
       return false;
     }
    }); --}}
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
    }//end


  function toggle_featured()
  {
      var is_featured = $('#is_featured').val();
      if(is_featured=='1')
      {
        $('#is_featured').val('0');
      }
      else if(is_featured=='0')
      {
        $('#is_featured').val('1');
      }
  } 



  /*var glob_autocomplete;
  var glob_component_form = 
  {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    postal_code: 'short_name'
  };

  var glob_options = {};
  glob_options.types = ['address'];

  function changeCountryRestriction(ref)
  {
    var country_code = $(ref).val();
    destroyPlaceChangeListener(autocomplete);
    // load states function
    // loadStates(country_code);  

    glob_options.componentRestrictions = {country: country_code}; 

    initAutocomplete(country_code);

    glob_autocomplete = false;
    glob_autocomplete = initGoogleAutoComponent($('#autocomplete')[0],glob_options,glob_autocomplete);
  }


  function initAutocomplete(country_code) 
  {
    glob_options.componentRestrictions = {country: country_code}; 

    glob_autocomplete = false;
    glob_autocomplete = initGoogleAutoComponent($('#autocomplete')[0],glob_options,glob_autocomplete);
  }


  function initGoogleAutoComponent(elem,options,autocomplete_ref)
  {
    autocomplete_ref = new google.maps.places.Autocomplete(elem,options);
    autocomplete_ref = createPlaceChangeListener(autocomplete_ref,fillInAddress);

    return autocomplete_ref;
  }
  

  function createPlaceChangeListener(autocomplete_ref,fillInAddress)
  {
    autocomplete_ref.addListener('place_changed', fillInAddress);
    return autocomplete_ref;
  }

  function destroyPlaceChangeListener(autocomplete_ref)
  {
    google.maps.event.clearInstanceListeners(autocomplete_ref);
  }

  function fillInAddress() 
  {
    // Get the place details from the autocomplete object.
    var place = glob_autocomplete.getPlace();
    console.log(place)  ;
    for (var component in glob_component_form) 
    {
        $("#"+component).val("");
        $("#"+component).attr('disabled',false);
    }
    
    if(place.address_components.length > 0 )
    {
      $.each(place.address_components,function(index,elem)
      {
          var addressType = elem.types[0];
          if(glob_component_form[addressType])
          {
            var val = elem[glob_component_form[addressType]];
            $("#"+addressType).val(val) ;  
          }
      });  
    }
  }
*/
</script>     
@stop                    
