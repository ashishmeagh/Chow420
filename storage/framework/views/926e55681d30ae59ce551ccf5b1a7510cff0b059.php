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
         
          <li class="active"><?php echo e(isset($page_title) ? $page_title : ''); ?></li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>
<!-- BEGIN Main Content --> 
<div class="row">
   <div class="col-md-12">
      <div class="white-box">
         <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
         <div class="row">
            <div class="col-sm-12 col-xs-12">
               <?php echo Form::open([ 'url' => $admin_panel_slug.'/update_password',
               'method'=>'POST',
               'id'=>'validation-form',
               'class'=>'form-horizontal' 
               ]); ?> 
               <?php echo e(csrf_field()); ?>

               <div class="form-group row">
                  <label class="col-2 col-form-label">Current Password<i class="red">*</i></label>
                  <div class="col-10">
                     

                        <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Please enter current password" data-parsley-required="true" data-parsley-required-message="Please enter current password"  data-parsley-remote="<?php echo e(url('/does_old_password_exist')); ?>"
                        data-parsley-remote-options='{ "type": "POST", "dataType": "jsonp", "data": { "_token": "<?php echo e(csrf_token()); ?>" } }'
                        data-parsley-remote-message="Please enter valid current password">

                     <span class='red'><?php echo e($errors->first('current_password')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">New Password<i class="red">*</i></label>
                  <div class="col-10">
                     <?php echo Form::password('new_password',['class'=>'form-control',
                     'data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter new password',
                     'data-parsley-minlength'=>'8',
                     'data-parsley-pattern'=>"(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}",
                     'data-parsley-pattern-message'=>"Password field must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters",
                     'id'=>'new_password',
                     'placeholder'=>'Please enter new password']); ?>

                     <span class='red'><?php echo e($errors->first('new_password')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-2 col-form-label">Re-type New Password<i class="red">*</i></label>
                  <div class="col-10">
                     <?php echo Form::password('new_password_confirmation',['class'=>'form-control',
                     'data-parsley-required'=>'true',
                     'data-parsley-required-message'=>'Please Re-type new password',
                     'data-parsley-equalto'=>'#new_password',
                     'data-parsley-equalto-message'=>'Confirm password should be same as new password',
                     'data-parsley-errors-message'=>"Confirm password should be same as new password",
                     'id'=>'new_password_confirmation',
                     'placeholder'=>'Please Re-type New password']); ?>

                     <span class='red'><?php echo e($errors->first('new_password_confirmation')); ?></span>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-10">
                     <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Save">Save</button>
                  </div>
               </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
</div>
<!-- END Main Content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>