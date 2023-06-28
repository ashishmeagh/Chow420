                
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

         <li><a href="<?php echo e($module_url_path); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
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
            <?php echo Form::open([ 'url' => $module_url_path.'/update/'.base64_encode($arr_data['id']),
            'method'=>'POST',
            'enctype' =>'multipart/form-data',   
            'class'=>'form-horizontal', 
            'id'=>'validation-form' 
            ]); ?> 
            <?php echo e(csrf_field()); ?>

            <div class="tab-content">
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email"> Template Name<i class="red">*</i> 
                  </label>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">       
                     <?php echo Form::text('template_name',$arr_data['template_name'],['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255', 'placeholder'=>'Email Template Name']); ?>  
                  </div>
                  <span class='red'> <?php echo e($errors->first('template_name')); ?> </span>  
               </div>
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email"> From 
                  <i class="red">*</i> 
                  </label>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">      
                     <?php echo Form::text('template_from',$arr_data['template_from'],['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255', 'placeholder'=>'Email Template From']); ?>  
                  </div>
                  <span class='help-block'> <?php echo e($errors->first('template_from')); ?> </span>  
               </div>
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email">  From Email 
                  <i class="red">*</i> 
                  </label>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">     
                     <?php echo Form::text('template_from_mail',$arr_data['template_from_mail'],['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','data-parsley-type'=>'email', 'placeholder'=>'Email Template From Email']); ?>  
                  </div>
                  <span class='help-block'> <?php echo e($errors->first('template_from_mail')); ?> </span>  
               </div>
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email"> Subject 
                  <i class="red">*</i> 
                  </label>
                  <?php
                      $readonly = false;

                     if($arr_data['id'] == '31')
                     {
                        $readonly = 'true';
                     }
                  ?>

                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">      
                     <?php echo Form::text('template_subject',$arr_data['template_subject'],['class'=>'form-control','data-parsley-required'=>'true','readonly'=>$readonly,'data-parsley-maxlength'=>'255', 'placeholder'=>'Email Template Subject']); ?>  
                  </div>
                  <span class='help-block'> <?php echo e($errors->first('template_subject')); ?> </span>  
               </div>
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email">  Body 
                  <i class="red">*</i> 
                  </label>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">   
                     <?php echo Form::textarea('template_html',$arr_data['template_html'],['class'=>'form-control', 'class'=>'form-control','id' => 'template_html', 'rows'=>'25', 'data-parsley-required'=>'true', 'placeholder'=>'Email Template Body']); ?>  
                     <span class='red'> <?php echo e($errors->first('template_html')); ?> </span> 
                     <span class="text-info"> Variables </span>
                     
                     <?php if(sizeof($arr_variables)>0): ?>
                     <?php $__currentLoopData = $arr_variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <br> <label> <?php echo e($variable); ?> </label> 
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php endif; ?> 
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                     <button type="submit" class="btn btn-success waves-effect waves-light" value="Update">Update</button>
                     <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                     <a class="btn btn-danger" target="_blank" href="<?php echo e(url(config('app.project.admin_panel_slug').'/email_template').'/view/'.base64_encode($arr_data['id'])); ?>"  title="Preview">Preview</a>
                     
                  </div>
               </div>

               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
   $('#validation-form').submit(function(){
       //tinyMCE.triggerSave();
       tinymce.triggerSave();
    });
   
   $(document).ready(function()
   {
    $('#validation-form').parsley(); 

   });
</script>





 <script type="text/javascript" src="<?php echo e(url('/assets/admin/js/tiny.js')); ?>"></script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>