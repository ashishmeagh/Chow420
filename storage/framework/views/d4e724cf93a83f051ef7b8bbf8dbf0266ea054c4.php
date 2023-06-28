                

<?php $__env->startSection('main_content'); ?>
<!-- Page Content -->

<style type="text/css">
 
  .size-img{
    display: block;text-align: left; font-size: 13px; color: #099c29;
  }
  .form-group.errorcread .error-img-size .parsley-errors-list{ 
  display: block; position: static;
  }
  .dropify-wrapper~.dropify-errors-container ul{margin-top: 0px  !important;margin-bottom: 0px  !important;}
  .dropify-wrapper~.dropify-errors-container ul li {
    margin-left: 0 !important;
    color: #F34141;
    font-weight: 100  !important;
    font-size: 15px;
} 
</style>

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
                    <li class="active">Edit Slider Image</li>
                    
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


                                    <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_slider_image['id']) ? $arr_slider_image['id'] : ''); ?>" />


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Title</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" value="<?php echo e(isset($arr_slider_image['title'])?$arr_slider_image['title']:''); ?>">
                                    </div>
                                      
                                  </div>

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Sub Title</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Enter Sub Title" value="<?php echo e(isset($arr_slider_image['subtitle'])?$arr_slider_image['subtitle']:''); ?>" >
                                    </div>
                                      
                                  </div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Image( Large Size) <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_img" value="<?php echo e(isset($arr_slider_image['slider_image'])?$arr_slider_image['slider_image']:''); ?>">
                                    <input type="file" name="slider_image" id="slider_image" class="dropify" 
                                    
                                     data-default-file="<?php echo e($slider_public_img_path); ?><?php echo e(isset($arr_slider_image['slider_image']) ? $arr_slider_image['slider_image'] : ''); ?>">
                                    <span id="image_error" class="error-img-size"><?php echo e($errors->first('slider_image')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b> 1920px X 775px )   </span>
                                    </div>
                                  </div>  


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Image( Medium Size) <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_img_medium" value="<?php echo e(isset($arr_slider_image['slider_medium'])?$arr_slider_image['slider_medium']:''); ?>">
                                    <input type="file" name="slider_medium" id="slider_medium" class="dropify" 
                                    
                                     data-default-file="<?php echo e($slider_public_img_path); ?><?php echo e(isset($arr_slider_image['slider_medium']) ? $arr_slider_image['slider_medium'] : ''); ?>">
                                    <span id="image_error_medium" class="error-img-size"><?php echo e($errors->first('slider_medium')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b> 700px X 400px )   </span>
                                    </div>
                                  </div>     



                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Image( Small Size) <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_img_small" value="<?php echo e(isset($arr_slider_image['slider_small'])?$arr_slider_image['slider_small']:''); ?>">
                                    <input type="file" name="slider_small" id="slider_small" class="dropify" 
                                    
                                     data-default-file="<?php echo e($slider_public_img_path); ?><?php echo e(isset($arr_slider_image['slider_small']) ? $arr_slider_image['slider_small'] : ''); ?>">
                                    <span id="image_error_small" class="error-img-size"><?php echo e($errors->first('slider_medium')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b> 621px X 300px )   </span>
                                    </div>
                                  </div>     



                                      
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="image_url1"> Image URL <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="image_url" id="image_url" class="form-control" placeholder="Enter Image URL" value="<?php echo e(isset($arr_slider_image['image_url'])?$arr_slider_image['image_url']:''); ?>"  data-parsley-required="true" data-parsley-type="url" data-parsley-required-message="Please enter image url">
                                    </div>
                                      
                                  </div>


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Button Title</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="slider_button" id="slider_button" class="form-control" placeholder="Enter button title" value="<?php echo e(isset($arr_slider_image['slider_button'])?$arr_slider_image['slider_button']:''); ?>">
                                    </div>
                                      
                                  </div>


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Title Color</label>
                                    <div class="col-md-10">                                       
                                       <input type="color" name="title_color" id="title_color" class="form-control" placeholder="Select title color" value="<?php echo e(isset($arr_slider_image['title_color'])?$arr_slider_image['title_color']:''); ?>">
                                    </div>
                                     
                                  </div> 
 
                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Subtitle Color</label>
                                    <div class="col-md-10">                                       
                                       <input type="color" name="subtitle_color" id="subtitle_color" class="form-control" placeholder="Select sub title color"  value="<?php echo e(isset($arr_slider_image['subtitle_color'])?$arr_slider_image['subtitle_color']:''); ?>">
                                    </div>
                                     
                                  </div> 

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Button Text Color</label>
                                    <div class="col-md-10">                                       
                                       <input type="color" name="button_color" id="button_color" class="form-control" placeholder="Select button title color" value="<?php echo e(isset($arr_slider_image['button_color'])?$arr_slider_image['button_color']:''); ?>">
                                    </div>
                                     
                                  </div> 


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Button Background Color</label>
                                    <div class="col-md-10">                                       
                                       <input type="color" name="button_back_color" id="button_back_color" class="form-control" placeholder="Select button background color" value="<?php echo e(isset($arr_slider_image['button_back_color'])?$arr_slider_image['button_back_color']:''); ?>">
                                    </div>
                                     
                                  </div> 
 


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is active</label>
                                      <div class="col-md-10">
                                          <?php
                                            if(isset($arr_slider_image['is_active'])&& $arr_slider_image['is_active']!='')
                                            {
                                              $status = $arr_slider_image['is_active'];
                                            } 
                                            else
                                            {
                                              $status = 0;
                                            }
                
                                          ?>
                                          <input type="checkbox" name="is_active" id="is_active" value="<?php echo e($status); ?>" data-size="small" class="js-switch " <?php if($status =='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
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

   function toggle_status()
  {
      var is_active = $('#is_active').val();
      if(is_active=='1')
      {
        $('#is_active').val('0');
      }
      else
      {
        $('#is_active').val('1');
      }
  }


  $(document).ready(function()
  {
    var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

    var csrf_token = $("input[name=_token]").val(); 
 
    $('#btn_add').click(function()
    {
      if($('#validation-form').parsley().validate()==false) return;
   
      $.ajax({
                  
          url: module_url_path+'/store',
          data: new FormData($('#validation-form')[0]),
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
           beforeSend : function()
          {  
            showProcessingOverlay();        
          },
          success:function(data)
          {
             hideProcessingOverlay(); 
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
              else if(data.status =='ImageFAILURE_medium')
              { 
                 $("#image_error_medium").html(data.description);
                 $("#image_error_medium").css('color','red');

              }
              else if(data.status =='ImageFAILURE_small')
              { 
                 $("#image_error_small").html(data.description);
                 $("#image_error_small").css('color','red');

              }
              else{
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   

    });

  });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>