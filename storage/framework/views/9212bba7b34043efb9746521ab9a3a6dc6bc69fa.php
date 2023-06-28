                

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
                      <li class="active">Edit Brands</li>
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
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    <?php echo e(csrf_field()); ?>


                                    <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_brands['id']) ? $arr_brands['id'] : ''); ?>" />


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="<?php echo e(isset($arr_brands['name'])?$arr_brands['name']:''); ?>" data-parsley-required="true" data-parsley-required-message="Please enter name"> 
                                    </div>
                                      
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Subheader / Description</label>
                                    <div class="col-md-10">                                       
                                       <textarea type="text" name="description" id="description" class="form-control" placeholder="Enter Subheader / Description"><?php echo e(isset($arr_brands['description'])?$arr_brands['description']:''); ?></textarea>
                                    </div>
                                    <script>
                                        CKEDITOR.replace( 'description' );
                                    </script> 
                                     
                                  </div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="image">Image <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_img" value="<?php echo e(isset($arr_brands['image'])?$arr_brands['image']:''); ?>">
                                    <input type="file" name="image" id="image" class="dropify" 
                                     data-default-file="<?php echo e($brand_public_img_path); ?>/<?php echo e(isset($arr_brands['image']) ? $arr_brands['image'] : ''); ?>"  >
                                     <span id="image_error"></span>
                                    </div>
                                  </div>  
                                      
                                
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="is_active" id="is_active"
                                         <?php if($arr_brands['is_active']=="0"): ?> value="0"
                                         <?php elseif($arr_brands['is_active']==1): ?> value="1" 
                                         <?php endif; ?> data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();"  <?php if($arr_brands['is_active'] =='1'): ?> checked="checked" <?php endif; ?> />
                                      </div>    
                                  </div>   
                              

                                <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Is Featured</label>
                                          <div class="col-md-10">
                                              <?php
                                                if(isset($arr_brands['is_featured'])&& $arr_brands['is_featured']!='')
                                                {
                                                  $is_featured = $arr_brands['is_featured'];
                                                } 
                                                else
                                                {
                                                  $is_featured = 0;
                                                }
                    
                                              ?>
                                              <input type="checkbox" name="is_featured" id="is_featured" value="<?php echo e($is_featured); ?>" data-size="small" class="js-switch " <?php if($is_featured =='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_featured();" />
                                          </div>    
                               </div> 
                                                  
                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Update</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                                              
                                        <!-- form-group -->
                                   </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
</div>
<!-- END Main Content -->


<script type="text/javascript"> 
  $(document).ready(function()
  {
    var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

    var csrf_token = $("input[name=_token]").val(); 
 
    $('#btn_add').click(function()
    {

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
          beforeSend: function() {
                showProcessingOverlay();
          },
          success:function(data)
          {

            hideProcessingOverlay(); 
             if('success' == data.status)
             {
                $('#validation-form')[0].reset();

                  swal({
                         title:'Success',
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
              }else if(data.status=="ImageFAILURE")
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
   
      var is_active = $('#is_active').val();
      if(is_active=='0')
      {
        $('#is_active').val('1');
      }
      else
      {
        $('#is_active').val('0');
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