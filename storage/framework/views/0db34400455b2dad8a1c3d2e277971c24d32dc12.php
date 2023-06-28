                

<?php $__env->startSection('main_content'); ?>  
<!-- Page Content -->
  <script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script>  

  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?> (<?php echo e(isset($arr_category['product_type']) ? $arr_category['product_type'] : ''); ?>)</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    <?php
                      $user = Sentinel::check();
                    ?>

                    <?php if(isset($user) && $user->inRole('admin')): ?>
                        <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                    <?php endif; ?>
                      
                    <li><a href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
                    <li class="active"><?php echo e($page_title); ?> </li>

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

                                    <input type="hidden" name="category_id" value="<?php echo e($enc_category_id); ?>">

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Question<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                      
                                       <textarea rows="5" name="question" id="question" class="form-control" data-parsley-required-message="Please enter question"  ></textarea>
                                        <script>
                                       // CKEDITOR.replace( 'answer' );
                                        CKEDITOR.replace( 'question', {
                                        height: 300,                                       
                                         filebrowserUploadUrl: "<?php echo e(route('faq.uploadimage', ['_token' => csrf_token() ])); ?>",
                                         filebrowserUploadMethod: 'form'

                                     } );
                                    </script> 
                                    </div>
                                  </div>
 
                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Answer<i class="red">*</i></label>
                                    <div class="col-md-10">                                      
                                       <textarea rows="5" name="answer" id="answer"  class="form-control" data-parsley-required-message="Please enter answer"></textarea>
                                       <script>
                                       // CKEDITOR.replace( 'answer' );
                                        CKEDITOR.replace( 'answer', {
                                        height: 300,                                       
                                         filebrowserUploadUrl: "<?php echo e(route('faq.uploadimage', ['_token' => csrf_token() ])); ?>",
                                         filebrowserUploadMethod: 'form'

                                     } );
                                    </script> 
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

      var ckeditor_question = CKEDITOR.instances['question'].getData();
      var ckeditor_answer = CKEDITOR.instances['answer'].getData();

      formdata = new FormData($('#validation-form')[0]);
      formdata.set('answer',ckeditor_answer); 
      formdata.set('question',ckeditor_question); 

      $.ajax({
                  
          url: module_url_path+'/store',
         // data: new FormData($('#validation-form')[0]),
          data:formdata,
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
      if(is_active=='0')
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