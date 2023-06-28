                

<?php $__env->startSection('main_content'); ?> 
<!-- Page Content -->
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
                    <li class="active"> <?php echo e(isset($page_title) ? $page_title : ''); ?></li>
                    
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
                                    <?php echo Form::open([ 'url' => "<?php echo e(url(config('app.project.admin_panel_slug').'/container/store')); ?>",
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal',
                                 'id'=>'validation-form' 

                                ]); ?> 

                                  <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_container['id']) ? $arr_container['id'] : ''); ?>" />
                                     

                                      <div class="form-group row">
                                          <label class="col-md-2 col-form-label" for="title"> Name <i class="red">*</i></label>
                                          <div class="col-md-10">
                                              <input type="text" name="title" class="form-control" data-parsley-required="true" placeholder="Enter forum container name" value="<?php echo e(isset($arr_container['title']) ? $arr_container['title'] : ''); ?>" data-parsley-required-message="Please enter forum container name"  data-parsley-maxlength='25' data-parsley-maxlength-message="Provided forum container name should be 25 characters or fewer">
                                          </div>
                                            <span><?php echo e($errors->first('title')); ?></span>
                                      </div>



                                    <div class="form-group row">
                                      <label class="col-md-2 col-form-label" for="images">Image <i class="red">*</i></label>
                                      <div class="col-md-10">
                                      <input type="hidden" name="old_img" value="<?php echo e(isset($arr_container['image'])?$arr_container['image']:''); ?>">
                                      <input type="file" name="image" id="image" class="dropify" 
                                       data-default-file="<?php echo e($container_public_img_path); ?>/<?php echo e(isset($arr_container['image']) ? $arr_container['image'] : ''); ?>"  >
                                      
                                       <span id="image_error"></span>
                                      </div>
                                  </div>  

                                    
                                      <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Is active</label>
                                          <div class="col-md-10">
                                              <?php
                                                if(isset($arr_container['is_active'])&& $arr_container['is_active']!='')
                                                {
                                                  $status = $arr_container['is_active'];
                                                } 
                                                else
                                                {
                                                  $status = 0;
                                                }
                    
                                              ?>
                                              <input type="checkbox" name="is_active" id="is_active" value="<?php echo e($status); ?>" data-size="small" class="js-switch " <?php if($status =='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
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
   
      $.ajax({
                  
          url: module_url_path+'/store',
          data: new FormData($('#validation-form')[0]),
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