    

<?php $__env->startSection('main_content'); ?>
<style type="text/css">
    .error{
        color: red;
    }
</style>

<script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script> 
 
<!-- Page Content -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><?php echo e(isset($module_title) ? $module_title : ''); ?></h4>
         </div>
         <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
              
              <?php
                $user = Sentinel::check();
              ?>

              <?php if(isset($user) && $user->inRole('admin')): ?>
                <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
              <?php endif; ?>

              <li class="active"><?php echo e(isset($module_title) ? $module_title : ''); ?></li>

            </ol>
         </div>
         <!-- /.col-lg-12 --> 
      </div>
      <!-- BEGIN Main Content -->
      <div class="row"> 
         <div class="col-sm-12">
            <div class="white-box">
               <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


              <?php if(isset($arr_data['id'])): ?>
                <?php echo Form::open([ 


                     'url' => $module_url_path.'/update/'.base64_encode($arr_data['id']),
                     'method'=>'POST',   
                     'class'=>'form-horizontal', 
                     'id'=>'validation-form',
                     'enctype' =>'multipart/form-data'
                     ]); ?>

              <?php else: ?> 
                  <?php echo Form::open([ 

                     'url' => $module_url_path.'/update/0',
                     'method'=>'POST',   
                     'class'=>'form-horizontal', 
                     'id'=>'validation-form',
                     'enctype' =>'multipart/form-data'
                     ]); ?>

              <?php endif; ?>

               <div class="row"> 
                    <div class="col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="description">Lab result<i class="red">*</i></label>
                        <div class="col-md-10">                                       
                           <textarea name="description" id="description" class="form-control" placeholder="Enter Information on how to read lab results"  ><?php echo e(isset($arr_data['lab_result']) ? $arr_data['lab_result'] : ''); ?></textarea>
                           <script>
                              CKEDITOR.replace( 'description' );
                          </script> 
                          <span class="error_title red"></span>
                        </div>
                          
                      </div>
                    </div>    
               </div>

               <div class="input-group">
                          <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_update">Update</button>
                     </div>
                     <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
</div>
<!-- END Main Content --> 
    <script type="text/javascript">
    $(document).ready(function(){

       $("#btn_update").click(function(event) {        
            var ckeditor_title = CKEDITOR.instances['description'].getData();
            var formdata = new FormData($('#validation-form')[0]);
            formdata.set('description',ckeditor_title); 


            if(ckeditor_title == ""){
                $(".error_title").html("Please enter lab result");
               return false;
            } else {
              return true;
            }
        
      
      });

     });


    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>