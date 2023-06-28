
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


      <?php
      if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';
      ?>


        <?php if(isset($arr_featured_brands) && count($arr_featured_brands)>0): ?>
        <div class="toprtd viewall-btns-idx">Top Brands
          <a href="<?php echo e(url('/')); ?>/shopbrand" class="<?php echo e($class); ?>" title="View all">View All</a>
          <div class="clearfix"></div>
        </div>
        <div class="featuredbrands-flex smallsize-brand-img brand-imgsection-class">

       <ul
        <?php if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count): ?>
        class="f-cat-below7"
        
         <?php elseif(isset($arr_featured_brands) && count($arr_featured_brands)>$device_count): ?>
        id="flexiselDemo3"
        <?php endif; ?>
        >

          <?php $__currentLoopData = $arr_featured_brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured_brands): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>

              <div class="top-rated-brands-list">
                 <?php
                  $brand_name = isset($featured_brands['name'])?$featured_brands['name']:'';
                  $brandname = str_replace(" ", "-", $brand_name);

                 ?>


                <a href="<?php echo e(url('/')); ?>/search?brands=<?php echo e(isset($brandname)?
                           $brandname:''); ?>" class="brands-citcles">
                  <div class="img-rated-brands">
                      <?php if(file_exists(base_path().'/uploads/brands/'.$featured_brands['image']) && isset($featured_brands['image'])): ?>

                    <?php
                     $top_brand_image = image_resize('/uploads/brands/'.$featured_brands['image'],294,182);
                    ?>  

              

                    <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($top_brand_image); ?>"
                      alt="<?php echo e(isset($brandname)?$brandname:''); ?>" />

                      <?php endif; ?>
                      
                    <div class="content-brands">
                        <div class="titlebrds"><?php echo e(isset( $featured_brands['name'])?ucwords($featured_brands['name']):''); ?></div>
                    </div>
                </div>
              </a>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>


  <?php endif; ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">
 
  /*--global variable declaration--*/
  var screenWidth = window.screen.availWidth;

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();
  
      if(parseInt(screenWidth) < parseInt(768)){
        
        $("#flexiselDemo3").removeAttr('id');

        $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

      }


  });

  $("#flexiselDemo3").flexisel({
    visibleItems: 4,
    itemsToScroll: 1,
    infinite: true,
    animationSpeed: 200,
    autoPlay: {
    enable: false,
    interval: 5000,
    pauseOnHover: true
}

});

</script>  


