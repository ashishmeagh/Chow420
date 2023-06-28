
<?php

$login_user = Sentinel::check();

$isMobileDevice=0;
$isMobileDevice= isMobileDevice();

if($isMobileDevice==1){

    $device_count = 2;
    $chowwatch_device_count = '';
}
else {
    $device_count = 4;
    $chowwatch_device_count = 3;
}

?>



<?php if(isset($arr_shop_by_effect) && count($arr_shop_by_effect)>0): ?>
<div class="top-rated-brands-main homepagenewlistings trending-products-cls-home shopbyreviewslider">
    <div class="toprtd non-mgts viewall-btns-idx toprated-view">Shop by Reviews
        <div class="clearfix"></div>
    </div>

    <div class="featuredbrands-flex trendingproducts-section">
      <div class="nbs-flexisel-container">
        <div class="nbs-flexisel-inner">
          <ul
            <?php if(isset($arr_shop_by_effect) && count($arr_shop_by_effect)<=$device_count): ?>
             class="f-cat-below7"
            <?php elseif(isset($arr_shop_by_effect) && count($arr_shop_by_effect)>$device_count): ?>
              id="flexisel792"
            <?php endif; ?>
            >
    <?php $__currentLoopData = $arr_shop_by_effect; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop_by_effect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <div class="shop-by-effect-main-parnts li-review-none">
                        <div class="shop-by-effect-main">
                          <a href="<?php echo e(isset( $shop_by_effect['link_url'])?ucwords($shop_by_effect['link_url']):''); ?>" >
                            <div class="shop-by-effect-img">
                              <?php if(file_exists(base_path().'/uploads/shop_by_effect/'.$shop_by_effect['image']) && isset($shop_by_effect['image'])): ?>

                              <?php
                                   
                                $shop_by_reviews_image = image_resize('/uploads/shop_by_effect/'.$shop_by_effect['image'],283,220);

                              ?>

                             

                              <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($shop_by_reviews_image); ?>"
                              alt="<?php echo e(isset( $shop_by_effect['title'])?$shop_by_effect['title']:''); ?>" />

                              <?php endif; ?>

                            </div>
                            <div class="shop-by-effect-content">
                                <div class="titlebrds"><?php echo e(isset( $shop_by_effect['title'])?ucwords($shop_by_effect['title']):''); ?></div>
                                <span><?php echo e(isset( $shop_by_effect['subtitle'])?$shop_by_effect['subtitle']:''); ?></span>
                              </div>
                          </a>
                        </div>
                  </div>
            </li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      </div>
    </div>
</div>
<?php endif; ?>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();

      var screenWidth = window.screen.availWidth;
            
      if(parseInt(screenWidth) < parseInt(768)){

        $("#flexisel792").removeAttr('id');

        $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

      }

     
  });


  $("#flexisel792").flexisel({
        visibleItems: 4,
        itemsToScroll: 1,
        infinite: false,
    
        animationSpeed: 200,
        autoPlay: {
        enable: false,
        interval: 5000,
        pauseOnHover: true
    }
  });

</script>