
<?php if(isset($arr_highlights) && count($arr_highlights) > 0): ?>
<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>
<?php
  $highlight_res_header='';
  $get_highlight_header = get_highlight_header();
  if(isset($get_highlight_header) && !empty($get_highlight_header))
  {
    $highlight_res_header = $get_highlight_header;
  }
?>

<?php if(isset($highlight_res_header) && !empty($highlight_res_header)): ?>
 <div class="header-txt-chow"> <?php echo $highlight_res_header ?></div>
<?php endif; ?>
<!-------------end--highlight header-------------------------->

<!-------------start--highlight subheader------------------------>

<?php
  $highlight_res_subheader='';
  $get_highlight_subheader = get_highlight_subheader();
  if(isset($get_highlight_subheader) && !empty($get_highlight_subheader))
  {
    $highlight_res_subheader = $get_highlight_subheader;
  }
?>

<?php if(isset($highlight_res_subheader) && !empty($highlight_res_subheader)): ?>
 <div class="subheader-txt-chow"> <?php echo $highlight_res_subheader ?></div>
<?php endif; ?>

<?php endif; ?>
<!-------------end--highlight subheader-------------------------->

</div>
<!-------------start highlight------------------------------------>
<?php if(isset($arr_highlights) && count($arr_highlights) > 0): ?>
<div class="boxhomepage-bnr highlight-sec">
  <div class="container">
    <div class="row">
      <?php $__currentLoopData = $arr_highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xd-6 col-sm-4 col-md-4 col-lg-4">
          <div class="categry-main-topview">
            <div class="categry-main-topview-icon">
              <?php if(file_exists(base_path().'/uploads/highlights/'.$highlight['hilight_image']) && isset($highlight['hilight_image'])): ?>
                 
                <?php
                  $highlight_image = '';
                  $highlight_image = image_resize('/uploads/highlights/'.$highlight['hilight_image'],100,100);
                ?>

                

                <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($highlight_image); ?>"
                  alt="<?php echo e(isset( $highlight['title'])?ucwords($highlight['title']):''); ?>" />  

              <?php endif; ?>

              
            </div>
            <div class="categry-main-topview-title"><?php echo e(isset( $highlight['title'])? ucwords($highlight['title']):''); ?></div>
            <div class="categry-main-topview-contant"><?php echo e(isset( $highlight['description'])?$highlight['description']:''); ?></div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</div>
<?php endif; ?>