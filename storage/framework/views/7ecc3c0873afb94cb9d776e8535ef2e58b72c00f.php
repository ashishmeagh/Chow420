<?php $__env->startSection('main_content'); ?>
<div class="my-profile-pgnm">
  <?php echo e(isset($page_title)?$page_title:''); ?>

  
  <ul class="breadcrumbs-my">
    <li><a href="<?php echo e(url('/')); ?>">Home</a> </li>
    <li><i class="fa fa-angle-right"></i></li>
    <li> Profile </li>
  </ul>

</div>


<style>
  .myprofile-main .profile {
    margin-left: 125px;
    width: 100px;
}
.note-show-abtform.bgnone {
    background-color: transparent;
    padding: 0;
}
  .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
    border: 1px solid #fff !important;
    background: #ffffff;
    font-weight: normal;
    color: #454545 !important;
}
.ui-datepicker td span, .ui-datepicker td a {
    padding: 0.4em .2em;
}
.userdetaild-modal{margin-top: 25%;}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active,
a.ui-button:active,
.ui-button:active,
.ui-button.ui-state-active:hover {
  border: 1px solid #873dc8 !important;
  background: #873dc8 !important;
  font-weight: normal;
  color: #ffffff !important; border-radius: 4px;
}
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
  padding: 2px 5px;
}
.ui-datepicker .ui-datepicker-next {
    right: 1px;
}
.ui-datepicker .ui-datepicker-prev {
    left: 1px;
}
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next {
    top: 1px;
}
</style>



<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">
<div class="main-my-profile">
   <div class="innermain-my-profile">
    <div id="status_msg"></div> 
   <?php echo $__env->make('front.layout.flash_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
       <form id="frm-profile">
        <?php echo e(csrf_field()); ?>


   <div class="profile-img-block">


        

    </div>  

       <div class="row"> 


           <div class="col-md-6">
                 <div class="form-group">
                    <label for="">First Name <span>*</span></label>
                    <input type="text" id="first_name" name="first_name"  value="<?php echo e(isset($user_details_arr['first_name']) ? $user_details_arr['first_name'] : ''); ?>" data-parsley-required="true" class="input-text" placeholder="First Name" data-parsley-pattern="^[a-zA-Z]+$" data-parsley-required-message="Please enter first name">
                </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Last Name <span>*</span></label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo e(isset($user_details_arr['last_name']) ? $user_details_arr['last_name'] : ''); ?>" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" class="input-text" placeholder="Last Name"  data-parsley-required-message="Please enter last name">
                </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Email Address <span>*</span></label>
                    <input type="email" id="email" name="email"  value="<?php echo e(isset($user_details_arr['email']) ? $user_details_arr['email'] : ''); ?>" data-parsley-required="true" class="input-text disbl-input" placeholder="Email Address" readonly="">
                </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Mobile Number <span>*</span></label>
                    <input type="text" id="mobile_no" name="mobile_no" value="<?php echo e(isset($user_details_arr['phone']) ? $user_details_arr['phone'] : ''); ?>" data-parsley-required="true" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="number" class="input-text" placeholder="Mobile Number"  data-parsley-required-message="Please enter mobile number">
                </div>
            </div>

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Date Of Birth <span>*</span></label>
                    <?php
                      $setdate = '';
                      if(isset($user_details_arr['date_of_birth']) && !empty($user_details_arr['date_of_birth']))
                      {
                        $setdate = date("m/d/Y",strtotime($user_details_arr['date_of_birth']));
                      }
                      else
                      {
                        $setdate = '';
                      }

                    ?>
                    <input type="text" id="date_age" class="input-text dob_change_input"  name="date_of_birth" value="<?php echo e(isset($setdate) ? $setdate : ''); ?>"  onchange="age_calculation(this)" onkeypress="return validateNumberAndForwardSlash(event);" data-parsley-required="true" data-parsley-required-message="Please enter date of birth"  placeholder="MM/DD/YYYY" type="text"   >
                      <div class="ageerr" id="age_error_profile"></div>
                </div>
            </div>





            <div class="col-md-12">
              <hr>
              <h4>Shipping Address</h4>
            </div>

             <div class="col-md-12">
                <div class="form-group">
                   <div id="locationField">
                    <input class="input-text search-address" id="autocomplete" placeholder="Search your address" onFocus="geolocate()" type="text" />
                  </div>
              </div>
            </div> 

            
            <div class="col-md-12">
                 <div class="form-group">
                    <label for="">Address <span>*</span></label>
                     <input class="field" id="street_number" disabled="true" type="hidden" />
                    <input type="text" id="route" name="address" data-parsley-required="true" class="input-text" placeholder="Please Enter the Address"  data-parsley-required-message="Please enter address" value="<?php echo e(isset($user_details_arr['street_address']) ? $user_details_arr['street_address'] : ''); ?>">
                    <span class="add_note">(Please enter full address, This address will be used as your shipping address.)</span>
                </div>
            </div> 

             <div class="col-md-6">
                 <div class="form-group">
                    <label for="">City <span>*</span></label>
                    <input type="text" id="locality" name="city" value="<?php echo e(isset($user_details_arr['city']) ? $user_details_arr['city'] : ''); ?>" data-parsley-required="true" class="input-text" placeholder="City"  data-parsley-required-message="Please enter city">
                </div>
            </div>    

                       

            <div class="col-md-6">
                <div class="form-group">
                  
                  <label for="">Country <span>*</span></label>
                    <?php
                        $country_id = isset($user_details_arr['country'])?$user_details_arr['country']:0;
                  ?>
                  <div class="select-style">
                  <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select country" id="country" name="country" onchange="get_states()">

                    <?php if(isset($countries_arr) && count($countries_arr)>0): ?>
                    <option value="">Select Country</option>
                    <?php $__currentLoopData = $countries_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                      <option  <?php if($country['id']==$country_id): ?> selected="selected" <?php endif; ?> value="<?php echo e($country['id']); ?>"><?php echo e(isset($country['name'])?ucfirst(strtolower($country['name'])):'--'); ?></option>
                    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <option>Countries Not Available</option>
                    <?php endif; ?>
                    </select> 
                  </div>
              </div>
            </div> 

            <div class="col-md-6">
                 <div class="form-group">
                   
                    <label for="">State <span>*</span></label>
                    <?php
                         $state_id = isset($user_details_arr['state'])?$user_details_arr['state']:0;
                          //dump($states_arr);
                    ?>
                    <div class="select-style">
                    <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state " id="administrative_area_level_1" name="state">
                      <?php if(isset($states_arr) && count($states_arr)>0): ?>
                      <option value="">Select State</option>
                      <?php $__currentLoopData = $states_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                       <option  <?php if($state['id']==$state_id): ?> selected="selected" <?php endif; ?> value="<?php echo e($state['id']); ?>"><?php echo e(isset($state['name'])?ucfirst(strtolower($state['name'])):'--'); ?></option>
                     
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                      <option>State Not Available</option>
                      <?php endif; ?>
                      
                     </select> 
                    </div>
                    
                </div> 
            </div>  

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Zip Code <span>*</span></label>
                    <input type="text" id="postal_code" name="zipcode" value="<?php echo e(isset($user_details_arr['zipcode']) ? $user_details_arr['zipcode'] : ''); ?>" data-parsley-required="true" data-parsley-minlength="4" data-parsley-maxlength="12" data-parsley-type="number" class="input-text" placeholder="Zip Code"  data-parsley-required-message="Please enter zip code">
                </div>
            </div>         


       <script>
      // This sample uses the Autocomplete widget to help the user select a
      // place, then it retrieves the address components associated with that
      // place, and then it populates the form fields with those details.
      // This sample requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script
      // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      let placeSearch;
      let autocomplete;
      const componentForm = {
        street_number: "short_name",
        route: "long_name",
        locality: "long_name",
        administrative_area_level_1: "long_name",
        country: "long_name",
        postal_code: "short_name",
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
          document.getElementById("autocomplete"),
          { types: ["geocode"] }
        );
        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        autocomplete.setFields(["address_component"]);
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();

        for (const component in componentForm) {
          document.getElementById(component).value = "";
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        for (const component of place.address_components) {
          const addressType = component.types[0];

          if (componentForm[addressType]) {
            const val = component[componentForm[addressType]];

            
            if(addressType=="country")
            { 

                $("#country option").filter(function() 
                { 
                  if($(this).text() == val)
                  {
                    var states_selected_val = $('#administrative_area_level_1 option:selected').val();
                     get_country_id(val,states_selected_val);
                     

                   return $(this).text() == val;
                  }
                
                }).prop('selected', true);

            }           
            else
            { 
              if(addressType=="administrative_area_level_1")
              { 
                 
                   $("#administrative_area_level_1 option").filter(function() {

                     return $(this).text() == val;
                    
                    }).prop('selected', true);

              }else
              {

                  if(addressType=="route")
                  {
                     const street_number = $("#street_number").val();
                      
                      if(street_number.trim()!='')
                      {
                         document.getElementById(addressType).value = street_number + " " + val;
                      }
                      else
                      {
                         document.getElementById(addressType).value = val;
                      }
                   
                  }
                  else
                  {
                     document.getElementById(addressType).value = val;
                  }

              }              

             }//else
            
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition((position) => {
            const geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };
            const circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy,
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }

   
</script>      



      <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwEKBOzIn5iOO4_0VuFcCldDziZn0cYbc&callback=initAutocomplete&libraries=places&v=weekly"
      async ></script>

    <script>
        $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){

              var address = $("#route").val();
              var city = $("#locality").val();
              var state = $("#administrative_area_level_1").val();
              var country = $("#country").val();
              var zipcode = $("#postal_code").val();

              $("#billing_street_address").val(address);
              $("#billing_city").val(city);
              $("#billing_state").val(state);
              $("#billing_country").val(country);
              $("#billing_zipcode").val(zipcode);

              var billing_street_address = $("#billing_street_address").val();
              var billing_city = $("#billing_city").val();
              var billing_state = $("#billing_state").val();
              var billing_country = $("#billing_country").val();
              var billing_zipcode = $("#billing_zipcode").val();

              $("#billing_country").trigger('change');
               setTimeout(function(){
                //  var states = $('#state option:selected').val();
                  var states = $('#administrative_area_level_1 option:selected').val();
                  $('#billing_state option[value=' + states + ']').attr('selected','selected');
              },1000);
            }else{
              $("#billing_street_address").val('');
              $("#billing_city").val('');
              $("#billing_state").val('');
              $("#billing_country").val('');
              $("#billing_zipcode").val('');
            }
           
        });
    });
    </script>       


    <script>
    
    

//get selected country id for address form
function get_country_id(countryname,states_selected_val)
{
   $.ajax({
              url:SITE_URL+'/buyer/profile/get_countryid',
              type:'GET',
              data:{
                      countryname:countryname
                    },
             // dataType:'JSON',
              beforeSend: function() {
               // showProcessingOverlay();
              },
              success:function(countryid)
              { 
                  
                //  hideProcessingOverlay();            
                
                  if(countryid)
                  {
                    get_country_states(countryid,states_selected_val);
                  }

                 // $("#state").html(html);
                 // $("#administrative_area_level_1").html(html);
              }
      });
}//function get_country_id

//get selected countries state for address form
function get_country_states(country_id,states_selected_val)
{
     // var country_id  = $('#country').val();

      $.ajax({
              url:SITE_URL+'/buyer/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
               // showProcessingOverlay();
              },
              success:function(response)
              { 
                  
                //  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                 // $("#state").html(html);
                  $("#administrative_area_level_1").html(html);
                  $("#administrative_area_level_1").val(states_selected_val);
              }
      });
  }//end get_country_states


</script>



            

            <div class="col-md-12">
              <hr>
              <h4>Billing Address</h4>
            </div>

            <div class="col-md-12">
              <div class="checkbox clearfix">
                    <div class="form-check checkbox-theme">
                        <input class="form-check-input" type="checkbox" value="" id="sameasabove"   name="sameasabove">
                        <label class="form-check-label" for="sameasabove">
                           Same as shipping address
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                 <div class="form-group">
                    <label for="">Address <span>*</span></label>
                    <input type="text" id="billing_street_address" name="billing_street_address" data-parsley-required="true" class="input-text" placeholder="Please enter the Billing Address"  data-parsley-required-message="Please enter the billing address" value="<?php echo e(isset($user_details_arr['billing_street_address']) ? $user_details_arr['billing_street_address'] : ''); ?>">
                    <span class="add_note">(Please enter full address, This address will be used as your shipping address.)</span>
                </div>
            </div>             
            

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Billing City <span>*</span></label>
                    <input type="text" id="billing_city" name="billing_city" value="<?php echo e(isset($user_details_arr['billing_city']) ? $user_details_arr['billing_city'] : ''); ?>" data-parsley-required="true" class="input-text" placeholder="Billing City"  data-parsley-required-message="Please enter billing city">
                </div>
            </div>         


            <div class="col-md-6">
                <div class="form-group">
                  
                  <label for="">Country <span>*</span></label>
                    <?php
                        $billing_country_id = isset($user_details_arr['billing_country'])?$user_details_arr['billing_country']:0;
                  ?>
                  <div class="select-style">
                  <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select country" id="billing_country" name="billing_country" onchange="get_billing_states()">

                    <?php if(isset($countries_arr) && count($countries_arr)>0): ?>
                    <option value="">Select Country</option>
                    <?php $__currentLoopData = $countries_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                      <option  <?php if($country['id']==$billing_country_id): ?> selected="selected" <?php endif; ?> value="<?php echo e($country['id']); ?>"><?php echo e(isset($country['name'])?ucfirst(strtolower($country['name'])):'--'); ?></option>
                    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <option>Countries Not Available</option>
                    <?php endif; ?>
                    </select> 
                  </div>
              </div>
            </div> 

            <div class="col-md-6">
                 <div class="form-group">
                   
                    <label for="">State <span>*</span></label>
                    <?php
                         $billing_state_id = isset($user_details_arr['billing_state'])?$user_details_arr['billing_state']:0;
                          //dump($states_arr);
                    ?>
                    <div class="select-style">
                    <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state for billing" id="billing_state" name="billing_state">
                      <?php if(isset($billing_states_arr) && count($billing_states_arr)>0): ?>
                      <option value="">Select State</option>
                      <?php $__currentLoopData = $billing_states_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $billing_state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                       <option  <?php if($billing_state['id']==$billing_state_id): ?> selected="selected" <?php endif; ?> value="<?php echo e($billing_state['id']); ?>"><?php echo e(isset($billing_state['name'])?ucfirst(strtolower($billing_state['name'])):'--'); ?></option>
                     
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                      <option>State Not Available</option>
                      <?php endif; ?>
                      
                     </select> 
                    </div>
                    
                </div>  
            </div>  

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Zip Code <span>*</span></label>
                    <input type="text" id="billing_zipcode" name="billing_zipcode" value="<?php echo e(isset($user_details_arr['billing_zipcode']) ? $user_details_arr['billing_zipcode'] : ''); ?>" data-parsley-required="true" data-parsley-minlength="4" data-parsley-maxlength="12" data-parsley-type="number" class="input-text" placeholder="Please enter Zip Code"  data-parsley-required-message="Please enter zip code for billing">
                </div>
            </div> 

           
             
             
              
            <div class="col-md-12">
              
              <input type="hidden" name="old_front_image" value="<?php echo e(isset($user_details_arr['user_details']['front_image']) ? $user_details_arr['user_details']['front_image'] : ''); ?>"> 
              <input type="hidden" name="old_back_image" value="<?php echo e(isset($user_details_arr['user_details']['back_image']) ? $user_details_arr['user_details']['back_image'] : ''); ?>"> 
            </div> 
          
            <div class="col-md-12">
                <div class="button-list-dts">
                    <a class="butn-def" id="btn-profile">Save</a>
                    <a href="javascript:window.history.go(-1)" class="butn-def cancelbtnss">Back</a>
                  
                </div>
            </div>
            <div class="clearfix"></div>
       </div> 
     </form>
   </div>
</div>
</div> 



  <script type="text/javascript">

    $('#btn-profile').click(function(){
      
      /*Check all validation is true*/
      if($('#frm-profile').parsley().validate()==false) return;


              var date_of_birth = document.getElementById("date_age").value;

              var split_dob = date_of_birth.split("/");

              var month = split_dob[0];
              var date  = split_dob[1];
              var year  = split_dob[2];

              var date1 = new Date();
              var date2 = new Date(""+month+"/"+date+"/ "+year+""); 

              var Difference_In_Time = date1.getTime() - date2.getTime(); 
                
              var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 

              if (Difference_In_Days < 7671) { // days in 21 years
                
                $("#date_age").removeAttr('data-parsley-required');

                document.getElementById("age_error_profile").innerHTML = " You must be 21+ and above to use chow420.";
                 document.getElementById("age_error_profile").style="color:red;font-size:13px";

                event.preventDefault();
                return false;
              }
              else {

                document.getElementById("age_error_profile").innerHTML = "";
              }


               var isValid = isValidDate($("#date_age").val());
      
                if (isValid) {
                } else {
                  document.getElementById("age_error_profile").innerHTML = "Date of Birth entered Incorrectly";
                  document.getElementById("age_error_profile").style="color:red;font-size:13px";
                   event.preventDefault();
                   return false;

                }





      $.ajax({
        url:SITE_URL+'/buyer/profile/update',
        data:new FormData($('#frm-profile')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          //showProcessingOverlay();
          $('#btn-profile').prop('disabled',true);
          $('#btn-profile').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          console.log(response.status);
         // hideProcessingOverlay();
          $('#btn-profile').prop('disabled',false);
          $('#btn-profile').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="success")
            {
              
              
                   swal({
                         title: "Success",
                         text: response.msg,
                         type: response.status,
                         confirmButtonText: "OK",
                         closeOnConfirm: false
                      },
                     function(isConfirm,tmp)
                     {
                       if(isConfirm==true)
                       {
                          window.location.href=SITE_URL+'/buyer/profile';
                       }
                     });
            
            }
            else
            {                    
              swal('', response.msg, 'warning');
            }
          }
        }
      });
    });



    function get_states()
    {
      
      var country_id  = $('#country').val();
    
        
      $.ajax({
              url:SITE_URL+'/buyer/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
                //showProcessingOverlay();
              },
              success:function(response)
              { 
                  console.log(response);
               //   hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                  $("#administrative_area_level_1").html(html);
              }
      });
  }

  function get_billing_states()
    {
      var country_id  = $('#billing_country').val();
        
      $.ajax({
              url:SITE_URL+'/buyer/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
               // showProcessingOverlay();
              },
              success:function(response)
              { 
                  
               //   hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                  $("#billing_state").html(html);
              }
      });
  }

</script>



<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#date_age" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '1950:2020'
    });
  } );
  </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
  function age_calculation(ref) { 
    

     var list = document.getElementById("parsley-id-5");

    // if (list) {
    //   //list.removeChild(list.childNodes[0]);    
    //   $("#date").removeAttr('data-parsley-required');  
    // }

    

    if (list) {
       var ul = document.querySelector('#parsley-id-5');
     var listLength = ul.children.length;

      for (i = 0; i < listLength; i++) {
        list.removeChild(list.childNodes[0]);  
      }
    }


    var split_dob = ref.value.split("/");

    var month = split_dob[0];
    var date = split_dob[1];
    var year = split_dob[2];

    var date1 = new Date();
    var date2 = new Date(""+month+"/"+date+"/ "+year+""); 

    var Difference_In_Time = date1.getTime() - date2.getTime(); 
      
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 


    if (Difference_In_Days < 7671) { // days in 21 years

      document.getElementById("age_error_profile").innerHTML = " You must be 21+ and above to use chow420";
       document.getElementById("age_error_profile").style="color:red;font-size:13px";
    }
    else {

      document.getElementById("age_error_profile").innerHTML = "";
    }
  }

  function validateNumberAndForwardSlash(event) {

    var key = window.event ? event.keyCode : event.which;

    if (event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 47) {

      return true;
    } 
    else {
      return false;
    }
  };


   $(document).on('blur','.dob_change_input',function(){ 
      var isValid = isValidDate($("#date_age").val());
      
      if (isValid) {
      } else {
        document.getElementById("age_error_profile").innerHTML = "Date of Birth entered Incorrectly";
        document.getElementById("age_error_profile").style="color:red;font-size:13px";

      }
   }); 


function isValidDate(input) 
{
        var regexes = [
          /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/,
          /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/
        ];

        for (var i = 0; i < regexes.length; i++) {
          var r = regexes[i];
          if(!r.test(input)) {
            continue;
          }
          var a = input.match(r), d = new Date(a[3],a[1] - 1,a[2]);
          if(d.getFullYear() != a[3] || d.getMonth() + 1 != a[1] || d.getDate() != a[2]) {
            continue;
          }
          // All checks passed:
          return true;
        }

        return false;
}//is valid date







</script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>