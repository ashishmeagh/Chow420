                
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
                      <li><a href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
                      <li class="active">Edit Country</li>
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
                                    <?php echo Form::open([ 'url' => "<?php echo e(url(config('app.project.admin_panel_slug').'/second_level_categories/store')); ?>",
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal',
                                 'id'=>'validation-form' 

                                ]); ?> 
                              
                                  
                                
                                <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_data['id']) ? $arr_data['id'] : ''); ?>" />
                                                               

                                 <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Country Name <i class="red">*</i></label>
                                    <div class="col-md-10">
                                       
                                       <input type="text" name="name" id="name" class="form-control" data-parsley-required="true" placeholder="Enter Country Name" data-parsley-required-message="Please enter country name" value="<?php echo e(isset($arr_data['name']) ? $arr_data['name'] : ''); ?>">
                                    </div>
                                      <span><?php echo e($errors->first('name')); ?></span>
                                  </div>

                                  
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is active</label>
                                      <div class="col-md-10">
                                          <?php
                                            if(isset($arr_data['is_active'])&& $arr_data['is_active']!='')
                                            {
                                              $status = $arr_data['is_active'];
                                            } 
                                            else
                                            {
                                              $status = '';
                                            }
                
                                          ?>
                                          <input type="checkbox" name="country_status" id="country_status" value="1" data-size="small" class="js-switch " <?php if($status =='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" />
                                      </div>    
                                  </div> 

                                                      
                                    <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_add">Update</button>
                                   <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                                        
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
                  
          url: module_url_path+'/update_country',
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
                         title: "Success",
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>