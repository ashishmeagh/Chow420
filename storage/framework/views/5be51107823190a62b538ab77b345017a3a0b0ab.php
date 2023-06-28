                

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
                                 
                                       
                                <div class="form-group row">
                                  <label class="col-md-2 col-form-label" for="title">Name<i class="red">*</i></label>
                                  <div class="col-md-10">
                                     <input type="text" name="title" class="form-control" data-parsley-required="true" data-parsley-required-message="Please enter forum container name" placeholder="Enter forum container name" data-parsley-maxlength='25' data-parsley-maxlength-message="Provided forum container name should be 25 characters or fewer">
                                  </div>
                                </div>
                              

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="images">Image <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="file" name="image" id="image" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" data-parsley-required="true" data-parsley-required-message="Please select forum container image">
                                     <span id="image_error"><?php echo e($errors->first('image')); ?></span> 
                                    </div>
                                  </div>  
                                             
                                 <div class="form-group row">
                                  <label class="col-md-2 col-form-label">Is Active</label>
                                    <div class="col-sm-6 col-lg-8 controls">
                                       <input type="checkbox" name="is_active" id="is_active" value="1" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
                                    </div>    
                                </div> 
                                

                                    <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Save" id="btn_add">Add</button>
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

  $('#btn_add').click(function(){

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
              console.log(data);
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
        $('#is_active').val('1');
      }
      else
      {
        $('#is_active').val('0');
      }
  }

 

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>