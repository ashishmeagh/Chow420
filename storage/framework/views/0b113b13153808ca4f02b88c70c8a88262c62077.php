                
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
            <li class="active">Edit CMS</li>
         </ol>
      </div>
      <!-- /.col-lg-12 -->
   </div>
   <!-- .row -->
   <div class="row">
      <div class="col-sm-12">
         <div class="white-box">
            <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo Form::open([ 'url' => $module_url_path.'/update/'.$enc_id,
            'method'=>'POST',
            'enctype' =>'multipart/form-data',   
            'class'=>'form-horizontal', 
            'id'=>'validation-form' 
            ]); ?> 
            <ul  class="nav nav-tabs">
               <?php echo $__env->make('admin.layout._multi_lang_tab', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </ul>
            <div id="myTabContent1" class="tab-content">
               <?php 
                  $page_slug =''; 
               ?>

               <?php if(isset($arr_lang) && sizeof($arr_lang)>0): ?>
               <?php $__currentLoopData = $arr_lang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php 

              

                  /* Locale Variable */  
                  $locale_page_title = "";
                  $locale_meta_keyword = "";
                  $locale_meta_desc = "";
                  $locale_page_desc = "";
                  $page_slug ='';
                 // $locale_menuinfooter ="";
                  

                  if(isset($arr_static_page['translations'][$lang['locale']]))
                  {
                      $locale_page_title = $arr_static_page['translations'][$lang['locale']]['page_title'];
                      $locale_meta_keyword = $arr_static_page['translations'][$lang['locale']]['meta_keyword'];
                      $locale_meta_desc = $arr_static_page['translations'][$lang['locale']]['meta_desc'];
                      $locale_page_desc = $arr_static_page['translations'][$lang['locale']]['page_desc'];

                      $page_slug = isset($arr_static_page['page_slug'])?$arr_static_page['page_slug']:'';

                      $about_us_img = isset($arr_static_page['translations'][$lang['locale']]['about_us_image'])?$arr_static_page['translations'][$lang['locale']]['about_us_image']:'';

                      // $locale_menuinfooter = isset($arr_static_page['translations'][$lang['locale']]['menuin_footer'])?$arr_static_page['translations'][$lang['locale']]['menuin_footer']:'';

                  }
                  ?>
                  <input type="hidden" name="pageslug" value="<?php echo e($page_slug); ?>">
               <div class="tab-pane fade <?php echo e($lang['locale']=='en'?'in active':''); ?>"
                  id="<?php echo e($lang['locale']); ?>">
                  <div class="form-group row">
                     <label class="col-md-2 col-form-label" for="page_title">Page Title
                     <?php if($lang['locale'] == 'en'): ?> 
                     <i class="red">*</i>
                     <?php endif; ?>
                     </label>
                     <div class="col-md-10">
                        <?php if($lang['locale'] == 'en'): ?>        
                        <?php echo Form::text('page_title_'.$lang['locale'],$locale_page_title,['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Page Title']); ?>

                        <?php else: ?>
                        <?php echo Form::text('page_title_'.$lang['locale'],$locale_page_title,['class'=>'form-control','placeholder'=>'Page Title']); ?>

                        <?php endif; ?>    
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-md-2 col-form-label" for="meta_keyword">Meta Keyword
                     <?php if($lang['locale'] == 'en'): ?> 
                     <i class="red">*</i>
                     <?php endif; ?>
                     </label>
                     <div class="col-md-10">
                        <?php if($lang['locale'] == 'en'): ?>        
                        <?php echo Form::text('meta_keyword_'.$lang['locale'],$locale_meta_keyword,['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Meta Keyword']); ?>

                        <?php else: ?>
                        <?php echo Form::text('meta_keyword_'.$lang['locale'],$locale_meta_keyword,['class'=>'form-control','placeholder'=>'Meta Keyword']); ?>

                        <?php endif; ?>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-md-2 col-form-label" for="meta_desc">Meta Description
                     <?php if($lang['locale'] == 'en'): ?> 
                     <i class="red">*</i>
                     <?php endif; ?>
                     </label>
                     <div class="col-md-10">
                        <?php if($lang['locale'] == 'en'): ?>        
                        <?php echo Form::textarea('meta_desc_'.$lang['locale'],$locale_meta_desc,['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Meta Description']); ?>

                        <?php else: ?>
                        <?php echo Form::textarea('meta_desc_'.$lang['locale'],$locale_meta_desc,['class'=>'form-control','placeholder'=>'Meta Description']); ?>

                        <?php endif; ?>
                       
                     </div>
                  </div>

                <!--   <div class="form-group row">
                        <label class="col-md-2 col-form-label">Menu In Footer</label>
                          <div class="col-md-10">
                              <?php
                                if(isset($locale_menuinfooter) && $locale_menuinfooter!='')
                                {
                                  $locale_menuinfooter= $locale_menuinfooter;
                                } 
                                else
                                {
                                  $locale_menuinfooter = '0';
                                }
                              ?>
                              <?php if($lang['locale'] == 'en'): ?>
                              <input type="checkbox" name="menuin_footer_<?php echo e($lang['locale']); ?>" id="menuin_footer" value="<?php echo e($locale_menuinfooter); ?>" data-size="small" class="js-switch " <?php if($locale_menuinfooter =='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_footer();" />
                              <?php else: ?>
                                <input type="checkbox" name="menuin_footer_<?php echo e($lang['locale']); ?>" id="menuin_footer" value="<?php echo e($locale_menuinfooter); ?>" data-size="small" class="js-switch " <?php if($locale_menuinfooter =='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_footer();" />
                              <?php endif; ?>
                          </div>    
                     </div>  -->
 


                  <?php if($page_slug=="chowcms"): ?>

                     <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="page_desc">Page URL
                        <?php if($lang['locale'] == 'en'): ?> 
                        <i class="red">*</i>
                        <?php endif; ?>
                        </label>
                        <div class="col-md-10">
                           <?php if($lang['locale'] == 'en'): ?>        
                           <?php echo Form::text('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Page URL']); ?>

                           <?php else: ?>
                           <?php echo Form::text('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','placeholder'=>'Page URL']); ?>

                           <?php endif; ?>    
                        </div>
                  </div>


                  <?php else: ?>

                  <div class="form-group row">
                     <label class="col-md-2 col-form-label" for="page_desc">Page Content
                     <?php if($lang['locale'] == 'en'): ?> 
                     <i class="red">*</i>
                     <?php endif; ?>
                     </label>
                     <div class="col-md-10">
                        <?php if($lang['locale'] == 'en'): ?>        
                        <?php echo Form::textarea('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','data-parsley-required'=>'true','rows'=>'20','placeholder'=>'Page Content']); ?>

                        <?php else: ?>
                        <?php echo Form::textarea('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','placeholder'=>'Page Content']); ?>

                        <?php endif; ?>
                      
                     </div>
                  </div>
                 <?php endif; ?> 

                
                <?php if($page_slug=="about-us"): ?>

                  <div class="form-group row">

                    <label class="col-md-2 col-form-label" for="">Image</label>
                    <div class="col-md-10">
                    <input type="hidden" name="old_img" value="<?php echo e(isset($about_us_img)?$about_us_img:''); ?>">

                    <input type="file" name="about_image" id="about_image" class="dropify" 
                     data-default-file="<?php echo e(url('/')); ?>/uploads/<?php echo e($about_us_img); ?>" data-allowed-file-extensions="png jpg JPG jpeg JPEG gif">
                     
                    <span id="image_error" class="error-img-size"><?php echo e($errors->first('about_image')); ?></span>
                    
                    </div>

                  </div>

                <?php endif; ?>
              
                

               </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
            </div>
            <br>
            <div class="form-group row">
               <div class="col-md-10">
                  <button type="submit" onclick="saveTinyMceContent();" class="btn btn-success waves-effect waves-light m-r-10" value="Update">Update</button>
                  <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
               </div>
            </div>
            <?php echo Form::close(); ?>

         </div>
      </div>
   </div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
  
   function saveTinyMceContent()
   {
     if($('#validation-form').parsley().validate()==false) return;
 
    // tinyMCE.triggerSave(); 
     tinymce.triggerSave();

   }
</script>
<script>
    // tinymce.init({
    //   selector: 'textarea',
    //   plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
    //   toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
    //   toolbar_mode: 'floating',
    //   tinycomments_mode: 'embedded',
    //   tinycomments_author: 'Author name',
    // });

     // tinymce.init({
     //   selector: 'textarea',
     //   relative_urls: false,
     //   remove_script_host:false,
     //   convert_urls:false,
     //   plugins: [
     //     'link',
     //     'fullscreen',
     //     'contextmenu '
     //   ],
     //   toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
     //   content_css: [
     //     // '//www.tinymce.com/css/codepen.min.css'
     //   ]
     // });
 </script>
 <script type="text/javascript" src="<?php echo e(url('/assets/admin/js/tiny.js')); ?>"></script>



 






<!-- 
<script>
   function toggle_footer()
  {
      var menuin_footer = $('#menuin_footer').val();
      if(menuin_footer=='1')
      {
        $('#menuin_footer').val('0');
      }
      else if(menuin_footer=='0')
      {
        $('#menuin_footer').val('1');
      }
  } 
</script> -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>