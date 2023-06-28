                

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
                    <li class="active"><?php echo e($page_title); ?></li>
                    
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


                                    <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_faqs['id']) ? $arr_faqs['id'] : ''); ?>" />


                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Category<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                      
                                      <select class="form-control" id="category" name="category" data-parsley-required-message="Please select category" data-parsley-required="true">
                                        
                                        <option value="">Select category</option>

                                       <?php if(isset($faq_category_arr) && count($faq_category_arr)>0): ?>

                                        <?php $__currentLoopData = $faq_category_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option value="<?php echo e($category['id']); ?>" <?php if($arr_faqs['faq_category'] == $category['id']): ?> selected <?php endif; ?>><?php echo e(isset($category['faq_category']) ? $category['faq_category'] : ''); ?></option>
                                       
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                       <?php endif; ?>

                                      </select>
                                    </div>
                                  </div>   


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Question<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       
                                       <textarea rows="5" name="question" id="question"  class="form-control"  data-parsley-required-message="Please enter question" >
                                         <?php if(isset($arr_faqs['question']) && !empty($arr_faqs['question'])): ?>
                                          <?php echo $arr_faqs['question']; ?>
                                        <?php endif; ?> 
                                   
                                       </textarea>

                                          <script>
                                          var allowedContent = true; 
                                         // CKEDITOR.replace( 'answer' );
                                          CKEDITOR.replace( 'question', {
                                          height: 300,                                       
                                           filebrowserUploadUrl: "<?php echo e(route('faq.uploadimage', ['_token' => csrf_token() ])); ?>",
                                           filebrowserUploadMethod: 'form',
                                            allowedContent

                                       } );
                                      </script> 

                                    </div>
                                  </div>

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Answer<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       
                                       <textarea rows="5" name="answer" id="answer"  class="form-control" data-parsley-required-message="Please enter answer" >
                                        <?php if(isset($arr_faqs['answer']) && !empty($arr_faqs['answer'])): ?>
                                          <?php echo $arr_faqs['answer']; ?>
                                        <?php endif; ?>  
                                     
                                       </textarea>
                                      <script>
                                        var allowedContent = true; 
                                       // CKEDITOR.replace( 'answer' );
                                        CKEDITOR.replace( 'answer', {
                                        height: 300,                                       
                                         filebrowserUploadUrl: "<?php echo e(route('faq.uploadimage', ['_token' => csrf_token() ])); ?>",
                                         filebrowserUploadMethod: 'form',
                                         allowedContent


                                     } );
                                    </script> 
                                    </div>
                                  </div>


                                
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="is_active" id="is_active"
                                         <?php if($arr_faqs['is_active']=="0"): ?> value="0"
                                         <?php elseif($arr_faqs['is_active']==1): ?> value="1" 
                                         <?php endif; ?> data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();"  <?php if($arr_faqs['is_active'] =='1'): ?> checked="checked" <?php endif; ?> />
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
      var ckeditor_question = CKEDITOR.instances['question'].getData();
      var ckeditor_answer = CKEDITOR.instances['answer'].getData();
      formdata = new FormData($('#validation-form')[0]);
      formdata.set('answer',ckeditor_answer); 
      formdata.set('question',ckeditor_question); 

      $.ajax({
                  
          url: module_url_path+'/store',
       //   data: new FormData($('#validation-form')[0]),
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