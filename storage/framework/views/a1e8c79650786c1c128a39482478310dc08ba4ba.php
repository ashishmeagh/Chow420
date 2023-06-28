                

<?php $__env->startSection('main_content'); ?> 
<!-- Page Content -->
 <script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script> 
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                    <?php
                     $user = Sentinel::check();
                    ?>

                    <?php if(isset($user) && $user->inRole('admin')): ?>

                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                    <?php endif; ?>
                      
                    <li><a href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
                    <li class="active">Edit <?php echo e(isset($module_title) ? $module_title : ''); ?></li>
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
                                    <?php echo Form::open([ 'url' => "<?php echo e(url(config('app.project.admin_panel_slug').'/first_level_categories/store')); ?>",
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal',
                                 'id'=>'validation-form' 

                                ]); ?> 

                                  <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_category['id']) ? $arr_category['id'] : ''); ?>" />
                                      <div class="form-group row">
                                          <label class="col-md-2 col-form-label" for="product_type"> Category Name <i class="red">*</i></label>
                                          <div class="col-md-10">
                                              <input type="text" name="product_type" class="form-control" data-parsley-required="true" placeholder="Enter Category Name" value="<?php echo e(isset($arr_category['product_type']) ? $arr_category['product_type'] : ''); ?>" data-parsley-required-message="Please enter category name">
                                          </div>
                                            <span><?php echo e($errors->first('product_type')); ?></span>
                                      </div>

                                      <div class="form-group row">
                                        <label class="col-md-2 col-form-label" for="name">Subheader / Description</label>
                                        <div class="col-md-10">                                       
                                           <textarea type="text" name="description" id="description" class="form-control" placeholder="Enter Subheader / Description"><?php echo e(isset($arr_category['description'])?$arr_category['description']:''); ?></textarea>
                                        </div>
                                        <script>
                                            CKEDITOR.replace( 'description' );
                                        </script> 
                                         
                                      </div>

                                      <div class="form-group row">
                                        <label class="col-md-2 col-form-label" for="image"> Image <i class="red">*</i></label>
                                        <div class="col-md-10">
                                          <input type="hidden" name="old_img" value="<?php echo e(isset($arr_category['image'])?$arr_category['image']:''); ?>">
                                          <input type="file" name="image" id="image" class="dropify" 
                                            
                                             data-default-file="<?php echo e($cat_public_img_path); ?><?php echo e(isset($arr_category['image']) ? $arr_category['image'] : ''); ?>">
                                          <span id="image_error"><?php echo e($errors->first('image')); ?></span> 
                                        </div>
                                      </div>  


                                     <div class="form-group row">
                                      <label class="col-md-2 col-form-label" for="product_stock"> Is Age Restriction <i class="red">*</i></label>
                                      <div class="col-md-10">  
                                        <div class="radio-btns">
                                          <div class="radio-btn">
                                            <input type="radio" name="is_age_limit" class="is_age_limit" id="is_age_limit" data-parsley-required="true" value="1" data-parsley-errors-container=".age_restriction_err" data-parsley-required-message="Please check the age restriction" <?php echo e($arr_category['is_age_limit']=='1'?"checked":""); ?>>
                                            <label for="is_age_limit">Yes</label>
                                            <div class="check"></div>
                                          </div>
                                          <div class="radio-btn">
                                            <input type="radio" name="is_age_limit" class="is_age_limit" id="is_age_limit1" data-parsley-required="true" value="0" data-parsley-errors-container=".age_restriction_err" data-parsley-required-message="Please check the age restriction" <?php echo e($arr_category['is_age_limit']=='0'?"checked":""); ?>> 
                                            <label for="is_age_limit1">No</label>
                                            <div class="check"></div>
                                          </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="age_restriction_err"></div>
                                      </div>
                                        
                                        <span><?php echo e($errors->first('is_age_limit')); ?></span>
                                    </div>   
                                  

                                    
                                      <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Is active</label>
                                          <div class="col-md-10">
                                              <?php
                                                if(isset($arr_category['is_active'])&& $arr_category['is_active']!='')
                                                {
                                                  $status = $arr_category['is_active'];
                                                } 
                                                else
                                                {
                                                  $status = 0;
                                                }
                    
                                              ?>
                                              <input type="checkbox" name="product_type_status" id="product_type_status" value="<?php echo e($status); ?>" data-size="small" class="js-switch " <?php if($status =='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
                                          </div>    
                                      </div> 

                                       <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Is Featured</label>
                                          <div class="col-md-10">
                                              <?php
                                                if(isset($arr_category['is_featured'])&& $arr_category['is_featured']!='')
                                                {
                                                  $is_featured = $arr_category['is_featured'];
                                                } 
                                                else
                                                {
                                                  $is_featured = 0;
                                                }
                    
                                              ?>
                                              <input type="checkbox" name="is_featured" id="is_featured" value="<?php echo e($is_featured); ?>" data-size="small" class="js-switch " <?php if($is_featured =='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_featured();" />
                                          </div>    
                                      </div> 
       
                                        <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_update">Update</button>
                                        <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                                        <!-- form-group -->
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
  $(document).ready(function(){

  var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

  $('#btn_update').click(function(){

  if($('#validation-form').parsley().validate()==false) return;

      var ckeditor_description = CKEDITOR.instances['description'].getData();
      formdata = new FormData($('#validation-form')[0]);
      formdata.set('description',ckeditor_description); 
   
      $.ajax({
                  
          url: module_url_path+'/store',
          data: formdata,
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
          success:function(data)
          {

              if('success' == data.status)
              {
                
                $('#validation-form')[0].reset();

                  swal({
                         title: "Success!",
                         text: data.description,
                         type: data.status,
                         confirmButtonText: "OK",
                         closeOnConfirm: false
                      },
                     function(isConfirm,tmp)
                     {
                       if(isConfirm==true)
                       {
                          window.location = data.link;
                       }
                     });
              }
                else if(data.status =='ImageFAILURE')
              { 
                 $("#image_error").html(data.description);
                 $("#image_error").css('color','red');

              }
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   

      });


  });

  function toggle_status()
  {
      var product_type_status = $('#product_type_status').val();
      if(product_type_status=='1')
      {
        $('#product_type_status').val('0');
      }
      else
      {
        $('#product_type_status').val('1');
      }
  }


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

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>