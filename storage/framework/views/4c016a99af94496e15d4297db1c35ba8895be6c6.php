

<?php if(isset($arr_shop_by_spectrum) && count($arr_shop_by_spectrum)>0): ?>
<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>
  <div class="toprtd viewall-btns-idx">Shop by Spectrum
    
  </div>
<div class="shop-by-effect-main-parnts">
      <?php $__currentLoopData = $arr_shop_by_spectrum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop_by_spectrum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="shop-by-effect-cols shop-by-spectrum">

          <div class="shop-by-effect-main">
            <a href="<?php echo e(isset( $shop_by_spectrum['link_url'])?ucwords($shop_by_spectrum['link_url']):''); ?>" >
              <div class="shop-by-effect-img">
                <?php if(file_exists(base_path().'/uploads/shop_by_spectrum/'.$shop_by_spectrum['image']) && isset($shop_by_spectrum['image'])): ?>
                <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e(url('/')); ?>/uploads/shop_by_spectrum/<?php echo e($shop_by_spectrum['image']); ?>"
                alt="<?php echo e(isset( $shop_by_spectrum['title'])?ucwords($shop_by_spectrum['title']):''); ?>" />
                <?php endif; ?>

              </div>
              <div class="shop-by-effect-content">
                  <div class="titlebrds"><?php echo e(isset( $shop_by_spectrum['title'])?ucwords($shop_by_spectrum['title']):''); ?></div>
                  <span><?php echo e(isset( $shop_by_spectrum['subtitle'])?$shop_by_spectrum['subtitle']:''); ?></span>
                </div>
            </a>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();

      
  });

</script>