                

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

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                            <?php echo e(csrf_field()); ?>


                            <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_search_suggestion['id']) ? $arr_search_suggestion['id'] : ''); ?>" />

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="name">User Search<i class="red">*</i></label>
                                <div class="col-md-10">                                       
                                    <input name="user_search" id="user_search" class="form-control" placeholder="User Search" data-parsley-required="true" data-parsley-required-message="Please enter user search" value="<?php echo e(isset($arr_search_suggestion['title'])?$arr_search_suggestion['title']:''); ?>">
                                </div>
                            </div> 

                            
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="name">If User Search Contains<i class="red">*</i></label>
                                <div class="col-md-10">                                       
                                    <input name="search_category" id="search_category" class="form-control" placeholder="If user search contains" data-parsley-required="true" data-parsley-required-message="Please enter If user search contains" value="<?php echo e(isset($arr_search_suggestion['search_suggestion_id'])?$arr_search_suggestion['search_suggestion_id']:''); ?>">
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="title">Show Suggestion<i class="red">*</i></label>
                                <div class="col-md-10">                                       
                                <input name="title" id="title" class="form-control" placeholder="Enter Title" data-parsley-required="true" data-parsley-required-message="Please enter title" value="<?php echo e(isset($arr_search_suggestion['front_suggession_title'])?$arr_search_suggestion['front_suggession_title']:''); ?>">
                                
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="name">Suggestion Link<i class="red">*</i></label>
                                <div class="col-md-10">                                       
                                <input typ="url" name="suggestion_url" id="suggestion_url" class="form-control" placeholder="Enter suggestion url" data-parsley-required="true" data-parsley-required-message="Please enter suggestion url" value="<?php echo e(isset($arr_search_suggestion['suggession_link'])?$arr_search_suggestion['suggession_link']:''); ?>">
                                </div>
                                
                            </div> 



                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Is Active</label>
                                <div class="col-sm-6 col-lg-8 controls">
                                    <input type="checkbox" name="is_active" id="is_active"
                                    <?php if(isset($arr_search_suggestion['is_active']) && $arr_search_suggestion['is_active']=="0"): ?> value="0"
                                    <?php elseif(isset($arr_search_suggestion['is_active']) && $arr_search_suggestion['is_active']==1): ?> value="1" 
                                    <?php endif; ?> data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();"  <?php if(isset($arr_search_suggestion['is_active']) && $arr_search_suggestion['is_active'] =='1'): ?> checked="checked" <?php endif; ?> />
                                </div>    
                            </div>   

                                
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Update</button>
                            <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                                        
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function()
{
    var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

    var csrf_token = $("input[name=_token]").val(); 
 
    $('#btn_add').click(function()
    {
      if($('#validation-form').parsley().validate()==false) return;

      var formdata = new FormData($('#validation-form')[0]);
       
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
    if(is_active==0)
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