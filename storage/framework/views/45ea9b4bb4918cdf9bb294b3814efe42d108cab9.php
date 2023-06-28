                

<?php $__env->startSection('main_content'); ?>
<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                      <li><a href="<?php echo e($module_url_path); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
                      <li class="active"><?php echo e(isset($page_title) ? $page_title : ''); ?></li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
    <!-- .row --> 
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

           <?php if(isset($arr_data) && count($arr_data) > 0): ?>   

           <?php echo Form::hidden('user_id',isset($arr_data['id']) ? $arr_data['id']: ""); ?>


            <input type="hidden" name="lat"  required="" id="lat" value="<?php echo e(isset($address_arr['lat']) ? $address_arr['lat'] : ''); ?>" class="clearField">
            <input type="hidden" name="lng"  required="" id="lng"  value="<?php echo e(isset($address_arr['lat']) ? $address_arr['lat'] : ''); ?>" class="clearField"> 
            <input type="hidden" name="city" id="city" class="clearField" value="<?php echo e(isset($address_arr['city']) ? $address_arr['city'] : ''); ?>">
            
            <input type="hidden" name="post_code" id="post_code" class="clearField" value="<?php echo e(isset($address_arr['post_code']) ? $address_arr['post_code'] : ''); ?>">

         
             <div class="form-group row">
                  <label class="col-md-2 col-form-label">First Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$"  value="<?php echo e(isset($arr_data['first_name']) ? $arr_data['first_name'] : ''); ?>" data-parsley-required-message="Please enter first name"/>
                     <span class="red"><?php echo e($errors->first('first_name')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-md-2 col-form-label">Last Name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$"  value="<?php echo e(isset($arr_data['last_name']) ? $arr_data['last_name'] : ''); ?>" data-parsley-required-message="Please enter last name"/>
                     <span class="red"><?php echo e($errors->first('last_name')); ?></span>
                  </div>
               </div>

            <div class="form-group row">
                  <label class="col-md-2 col-form-label">Email<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="email" placeholder="Enter Email" data-parsley-required="true" data-parsley-type="email" value="<?php echo e(isset($arr_data['email']) ? $arr_data['email'] : ''); ?>" data-parsley-required-message="Please enter email"/>
                     <span class="red"><?php echo e($errors->first('email')); ?></span>
                  </div>
            </div>

              <div class="form-group row">
                  <label class="col-2 col-form-label">City<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="city" placeholder="City" id="city" id="locality" value="<?php echo e(isset($arr_data['city']) ? $arr_data['city'] : ''); ?>" data-parsley-required="true" data-parsley-required-message="Please enter city"/>
                     <span class="red"><?php echo e($errors->first('city')); ?></span>
                  </div>
               </div> 

 
            <div class="form-group row">
                <?php
                $country_id = isset($arr_data['country'])?$arr_data['country']:0;
                ?>
                  <label class="col-md-2 col-form-label">Country<i class="red">*</i></label>
                  <div class="col-md-10">
                     <select class="form-control" data-parsley-required="true" id="country" name="country" onchange="get_states()">
                      <?php if(isset($countries_arr) && count($countries_arr)>0): ?>
                      <option value="">Select Country</option>
                      <?php $__currentLoopData = $countries_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <option <?php if($country['id']==$country_id): ?> selected="selected" <?php endif; ?> value="<?php echo e($country['id']); ?>"><?php echo e(isset($country['name'])?ucfirst(strtolower($country['name'])):'--'); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                      <option>Countries Not Available</option>
                      <?php endif; ?>
                     </select>

                       


                     <span class="red"><?php echo e($errors->first('country')); ?></span>
                  </div>
              </div>
              <div class="form-group row">
                <?php
                $state_id = isset($arr_data['state'])?$arr_data['state']:0;
                
                ?>
                <label class="col-md-2 col-form-label" for="state">State <i class="red">*</i></label>
                <div class="col-md-10">
                  <select class="form-control" data-parsley-required="true" data-parsley-required-message="Please select state " id="state" name="state">
                    <?php if(isset($states_arr) && count($states_arr)>0): ?>
                    <option value="">Select State</option>
                    <?php $__currentLoopData = $states_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option  <?php if($state['id']==$state_id): ?> selected <?php endif; ?> value="<?php echo e($state['id']); ?>"><?php echo e(isset($state['name'])?ucfirst(strtolower($state['name'])):'--'); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <option>State Not Available</option>
                    <?php endif; ?>
                    
                  </select> 
                </div> 
              </div> 


               <div class="form-group row">
                  <label class="col-2 col-form-label">Zip Code<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="zipcode" id="postal_code" placeholder="Enter Zip Code" value="<?php echo e(isset($arr_data['zipcode']) ? $arr_data['zipcode'] : ''); ?>" data-parsley-required="true" data-parsley-required-message="Please enter zipcode" data-parsley-length="[1,6]" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-pattern-message="Only alphanumeric are allowed." />
                     <span class="red"><?php echo e($errors->first('zipcode')); ?></span>
                  </div>
               </div>



            <div class="form-group row">
                  <label class="col-md-2 col-form-label">Address<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="street_address" id="street_address" placeholder="Enter address" data-parsley-required="true" data-parsley-required-message="Please enter address" value="<?php echo e(isset($arr_data['street_address']) ? $arr_data['street_address'] : ''); ?>" />
                     <span class="red"><?php echo e($errors->first('street_address')); ?></span>
                  </div>
            </div>
           
           

            <div class="form-group row">
              <div class="col-md-10">
                <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_add">Update</button>
                <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
              </div>
            </div>
            <?php else: ?> 
              <div class="form-group row">
                <div class="col-md-10">
                  <h3><strong>No Record found..</strong></h3>     
                </div>
              </div>
            <?php endif; ?>
    
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
   //  handlerchangeCountryRestriction($('#country'),'selected');
    //var country_id = ($('select[name=country]').val());

    //var incr = 1;
    //ar glob_options = {};
    //  glob_options.types = [];
  
    /*$("#country").on('change',function(){      
        $('.clearField').val('');          
        handlerchangeCountryRestriction($(this),'selected');
        var country_id = ($('select[name=country]').val());
    });*/

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
<?php $__env->stopSection(); ?>                    

<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>