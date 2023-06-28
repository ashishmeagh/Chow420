                

<?php $__env->startSection('main_content'); ?> 
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
                    
                <li><a href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
                <li class="active"><?php echo e(isset($page_title) ? $page_title : ''); ?></li>
                
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                            <?php echo e(csrf_field()); ?>


                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Suggestion Title<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                        <select name="suggestion_title" id="suggestion_title" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select suggestion title">
                                            <option value="">Select Suggestion</option>
                                            <?php $__currentLoopData = $arr_search_suggestion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e(isset($suggestion['id']) ? $suggestion['id'] : ''); ?>"><?php echo e(isset($suggestion['title']) ? $suggestion['title'] : ''); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div> 
                                
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Title<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                    <input name="title" id="title" class="form-control" placeholder="Enter Title" data-parsley-required="true" data-parsley-required-message="Please enter title">
                                    </div>
                                    
                                </div>  

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Suggestion Link<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                    <input typ="url" name="suggestion_url" id="suggestion_url" class="form-control" placeholder="Enter suggestion url" data-parsley-required="true" data-parsley-required-message="Please enter suggestion url">
                                    </div>
                                    
                                </div> 



                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                    <div class="col-sm-6 col-lg-8 controls">
                                       <input type="checkbox" name="is_active" id="is_active" value="0" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
                                    </div>    
                                </div>

                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Add</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                                
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
            
      var formdata = new FormData($('#validation-form')[0]);
    //   formdata.set('name'); 

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
                         title: data.status,
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
    if(is_active == 0)
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