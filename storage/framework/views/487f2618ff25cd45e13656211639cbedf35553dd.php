                
<?php $__env->startSection('main_content'); ?>

 <link href="<?php echo e(url('/')); ?>/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />

<style type="text/css">
  .morecontent span {display: none;}
  .morelink {display: block;color: #887d7d;}
  .morelink:hover,.morelink:focus{color: #887d7d;}
  .morelink.less{color: #887d7d;}
  .show-h3{margin-top: 0px;}
  .comments-mains.sub-reply{border-radius: 5px;}
  .txt-commnts{color: #888888;}
  .comments-mains-right.move-top-mrg {margin-top: 11px;}
</style>
<!-- Page Content -->
<div id="page-wrapper"> 
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
          <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
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
                 <h3>
                    <span 
                       class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action" >
                    </span>
                 </h3>
            </div>
          </div>
          
                    
            <div class="row">
                  <div class="col-sm-12">
                  <div class="myprofile-main">
                       <div class="myprofile-lefts">State Name</div>
                       <div class="myprofile-right">
                          <?php if(isset($arr_data['name']) && $arr_data['name']!=""): ?>
                          <?php echo e(ucfirst($arr_data['name'])); ?>

                          <?php else: ?>
                           NA
                          <?php endif; ?>
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Country Name</div>
                       <div class="myprofile-right">
                        <?php if(isset($arr_data['country_details']['name']) && $arr_data['country_details']['name']): ?>
                        <?php echo e(ucfirst($arr_data['country_details']['name'])); ?>

                        <?php else: ?>
                        NA
                        <?php endif; ?>
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts"> Restricted Categories </div>
                       <div class="myprofile-right">
                         <?php if(isset($restrict_categories) && $restrict_categories!=""): ?>
                          <?php echo e($restrict_categories); ?>

                         <?php else: ?>
                          NA 
                         <?php endif; ?> 
                        </div>
                       <div class="clearfix"></div>
                  </div>


                    <div class="myprofile-main">
                       <div class="myprofile-lefts">State Law</div>
                       <div class="myprofile-right">
                         <?php if(isset($arr_data['text']) && $arr_data['text']!=""): ?>
                          <?php echo e($arr_data['text']); ?>

                         <?php else: ?>
                          NA 
                         <?php endif; ?> 
                        </div>
                       <div class="clearfix"></div>
                  </div>

                  

                </div>

               </div><!--end of row--->
             
</div><!--end of class=white-box--->



  <div class="form-group row">
    <div class="col-10">
       <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>/view_states/<?php echo e(base64_encode($arr_data['country_id'])); ?>"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  </div>

</div>
</div>      
</div>
</div>



<!-- END Main Content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>