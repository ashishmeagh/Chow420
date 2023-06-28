                
<?php $__env->startSection('main_content'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">

        <?php
            $user = Sentinel::check();
        ?>

        <?php if(isset($user) && $user->inRole('admin')): ?>
          <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
        <?php endif; ?> 

        <li><a href="<?php echo e($module_url_path); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
        <li class="active">Create Buyer</li>

      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>
<!-- BEGIN Main Content -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box">
         <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         <div class="row">
            <div class="col-sm-12 col-xs-12">

                <?php echo Form::open([
               'method'=>'POST',
               'enctype' =>'multipart/form-data',   
               'class'=>'form-horizontal', 
               'id'=>'validation-form' 
               ]); ?> 
               <!-- <?php echo e(csrf_field()); ?> --> 


                <input type="hidden" name="lat"  required="" id="lat" value="-34.397" class="clearField">
                <input type="hidden" name="lng"  required="" id="lng"  value="150.644" class="clearField"> 
                <input type="hidden" name="city" id="city" class="clearField">
                
                <input type="hidden" name="post_code" id="post_code" class="clearField">


               
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">First Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" value="<?php echo e(old('first_name')); ?>" data-parsley-required-message="Please enter first name" />
                     <span class="red"><?php echo e($errors->first('first_name')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Last Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" value="<?php echo e(old('last_name')); ?>" data-parsley-required-message="Please enter last name" />
                     <span class="red"><?php echo e($errors->first('last_name')); ?></span>
                  </div>
               </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Date of birth<i class="red">*</i></label>
                  <div class="col-md-10">
                       <input type="text" class="form-control" id="datepicker"onchange="age_calculation(this)"  onkeypress="return validateNumberAndForwardSlash(event);"  data-type="dateIso" name="date_of_birth" autocomplete="off" placeholder="MM/DD/YYYY" data-parsley-required="true" value="" data-parsley-required-message="Please enter date of birth" />
                       <ul class="parsley-errors-list filled" id="parsley-id-5">
                        <li  class="parsley-required" id="age_error"> </li>
                      </ul>
                  </div>
               </div>

               

                 <div class="form-group row">
                  <label class="col-md-2 col-form-label">Mobile No.<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" id="number" class="form-control"   onkeypress="return isNumber(event)" name="phone" placeholder="Mobile No." data-parsley-required="true" 
                     data-parsley-type="number" data-parsley-type-message="please input valid mobile number"
                     data-parsley-length="[10, 12]"  data-parsley-length-message="Mobile number should be between 10 and 12 digits long."
                      data-parsley-required-message="Please enter Mobile No." data-parsley-type="number" />
                     <span class="red"><?php echo e($errors->first('number')); ?></span>
                  </div>
               </div>


               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Email<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="email" placeholder="Enter Email" data-parsley-required="true" data-parsley-type="email" value="<?php echo e(old('email')); ?>" data-parsley-required-message="Please enter email" />
                     <span class="red"><?php echo e($errors->first('email')); ?></span>
                  </div>
               </div>
             
               <!-- <div class="form-group row">
                  <label class="col-2 col-form-label">Phone<i class="red">*</i></label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="phone" placeholder="Enter Phone No" data-parsley-required="true" data-parsley-length="[6, 16]" value="<?php echo e(old('phone')); ?>" />
                     <span class="red"><?php echo e($errors->first('phone')); ?></span>
                  </div>
               </div> -->
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">New Password<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New password" data-parsley-required="true" data-parsley-length="[6, 16]" value="<?php echo e(old('new_password')); ?>" data-parsley-required-message="Please enter password" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character" data-parsley-minlength="8"/>
                     <span class="red"><?php echo e($errors->first('new_password')); ?></span>
                  </div>
               </div>  
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Confirm Password<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="password" class="form-control" name="confirm_password" placeholder="Enter confirm password" data-parsley-required="true" data-parsley-equalto="#new_password" data-parsley-error-message="Confirm password should be the same as new password" value="<?php echo e(old('confirm_password')); ?>" />
                     <span class="red"><?php echo e($errors->first('confirm_password')); ?></span>
                  </div>
               </div>
                
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Country<i class="red">*</i></label>
                  <div class="col-md-10">
                     <select class="form-control" data-parsley-required="true" id="country" name="country" data-parsley-required-message="Please Select the Country" onchange="get_states()">
                      <?php if(isset($countries_arr) && count($countries_arr)>0): ?>
                      <option value="">Select Country</option>
                      <?php $__currentLoopData = $countries_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <option value="<?php echo e($country['id']); ?>"><?php echo e(isset($country['name'])?ucfirst(strtolower($country['name'])):'--'); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                      <option>Countries Not Available</option>
                      <?php endif; ?> 
                     </select>
                     <span class="red"><?php echo e($errors->first('country')); ?></span>
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
                  <label class="col-md-2 col-form-label">Address<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control clearField" name="street_address" id="address" placeholder="Enter address" data-parsley-required="true" value="" data-parsley-required-message="Please enter address" />
                     <span class="red"><?php echo e($errors->first('street_address')); ?></span>
                  </div>
               </div>

              
              <!--  <div class="form-group row">
                  <label class="col-2 col-form-label">Country<i class="red">*</i></label>
                  <div class="col-10">
                     <select class="form-control"  name="country" data-parsley-required="true" onchange="changeCountryRestriction(this)" >
                        <option value="">--Select Country--</option>
                        <?php if(isset($arr_country) && count($arr_country)>0): ?>
                        <?php $__currentLoopData = $arr_country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value['country_code']); ?>"><?php echo e($value['country_name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                     </select>
                     <span class="red"><?php echo e($errors->first('role')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">Street Address<i class="red">*</i></label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="street_address" placeholder="Enter Street Address" data-parsley-required="true"  value="<?php echo e(old('street_address')); ?>" />
                     <span class="red"><?php echo e($errors->first('street_address')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">State</label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="state" placeholder="State" id="administrative_area_level_1" readonly=""  value="<?php echo e(old('state')); ?>" />
                     <span class="red"><?php echo e($errors->first('state')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">City</label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="city" placeholder="City" id="administrative_area_level_1" id="locality" readonly=""  value="<?php echo e(old('city')); ?>" />
                     <span class="red"><?php echo e($errors->first('city')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">Zip Code</label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="zipcode" id="postal_code" placeholder="Enter Zip Code" data-parsley-length="[4, 12]" value="<?php echo e(old('zipcode')); ?>" />
                     <span class="red"><?php echo e($errors->first('zipcode')); ?></span>
                  </div>
               </div> -->



              

             <div class="form-group row">
                  <label class="col-2 col-form-label">Zip Code<i class="red">*</i></label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="zipcode" id="postal_code" data-parsley-required="true" data-parsley-minlength="4" data-parsley-maxlength="12" data-parsley-type="number" class="input-text" placeholder="Zip Code"  data-parsley-required-message="Please enter zip code" value="<?php echo e(old('zipcode')); ?>" />
                     <span class="red"><?php echo e($errors->first('zipcode')); ?></span>
                  </div>
               </div>   


               <div class="form-group row">
                  <label class="col-2 col-form-label">City<i class="red">*</i></label>
                  <div class="col-10">
                     <input type="text" class="form-control" name="city" id="locality" data-parsley-required="true" class="form-control" placeholder="City"  data-parsley-required-message="Please enter city" value="<?php echo e(old('city')); ?>" />
                     <span class="red"><?php echo e($errors->first('city')); ?></span>
                  </div>
               </div>   
 

               <div class="form-group row">
                  <div class="col-md-10">
                     <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Save" id="btn_add">Save</button>
                        <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                  </div>
               </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
  var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";
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
    //var incr = 1;
    //var glob_options = {};
    //glob_options.types = [];
  
    //$("#country").on('change',function(){      
     //   $('.clearField').val('');          
    //    handlerchangeCountryRestriction($(this),'selected');
       // var country_id = ($('select[name=country]').val());
    //});

    /*$('#address').on('keyup keypress', function(e) 
    {
     var keyCode = e.keyCode || e.which;
     if (keyCode === 13) { 
       e.preventDefault();
       return false;
     }
    });*/

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
<script type="text/javascript">
  function isNumber(evt) {

    var value  = document.getElementById("number").value;

    if (value.length > 11) {

        return false;
    }

    evt = (evt) ? evt : window.event;

    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }

    return true;
  }
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
   var j = jQuery.noConflict();
    j( function() {
        j( "#datepicker" ).datepicker(
            { dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1950:2020' }
         );
    });
</script>
<script>
  function age_calculation(ref) { 

    var list = document.getElementById("parsley-id-9");

    /*REMOVE EXISTING VALIDATION MSG*/

    var ul = document.querySelector('#parsley-id-9');

    if (ul) {

      var listLength = ul.children.length;

      if (list) {

        for (i = 0; i < listLength; i++) {
          list.removeChild(list.childNodes[0]);  
        }
      }
    }
    
    /*REMOVE EXISTING VALIDATION MSG*/

    var split_dob = ref.value.split("/");

    var month = split_dob[0];
    var date = split_dob[1];
    var year = split_dob[2];

    var date1 = new Date();
    var date2 = new Date(""+month+"/"+date+"/ "+year+""); 

    var Difference_In_Time = date1.getTime() - date2.getTime(); 
      
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 

    if (Difference_In_Days < 7671) { // days in 21 years

      document.getElementById("age_error").innerHTML = "You must be 21+ and above to use chow420";
    }
    else {

      document.getElementById("age_error").innerHTML = "";
    }
  }

  function validateNumberAndForwardSlash(event) {

    return false;

    var key = window.event ? event.keyCode : event.which;

    if (event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 47) {

      return true;
    } 
    else {
      return false;
    }
  };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>