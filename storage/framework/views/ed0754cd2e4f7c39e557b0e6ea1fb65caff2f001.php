
  <?php



  if(isset($arr_featured_category) && count($arr_featured_category)<=7)
  $class = 'butn-def viewall-product';
  else
  $class = 'butn-def';
  ?>
  <div class="featuredcategories-four">

    <div class="featuredbrands-flex trendingproducts-section tprtd-procudt">
      <ul id="flexiselDemo86">
         <?php $__currentLoopData = $arr_featured_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
        <div class="categories-four-list">
          <?php
            $category_name = isset($featured_category['product_type'])?$featured_category['product_type']:'';
            $category_name = str_replace(" ", "-", $category_name);
            $category_name = str_replace("-&-", "-and-", $category_name);

            ?>
            <a href="<?php echo e(url('/')); ?>/search?category_id=<?php echo e($category_name); ?>" class="promotionslist whitefont">
            
            <div class="image-queres-box">

              <?php if(file_exists(base_path().'/uploads/first_category/'.$featured_category['image']) && isset($featured_category['image'])): ?>

              <?php
               $shop_by_category_image = image_resize('/uploads/first_category/'.$featured_category['image'],238,238);
              ?>

             

              <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($shop_by_category_image); ?>"  alt="<?php echo e($featured_category['product_type']); ?>" />

              <?php endif; ?>

            </div>
            <div class="promo-block--content-wrapper">

          </div>
          </a>
          <div class="content-brands">
                <div class="titlebrds"> <?php echo e($featured_category['product_type']); ?></div>
            </div>
        </div>
         </li>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>

      <div class="clearfix"></div>
  </div>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();


      var screenWidth = window.screen.availWidth;
            
      if(parseInt(screenWidth) < parseInt(768)){
          $("#flexiselDemo86").removeAttr('id');

          $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

        }

     
  })


  $("#flexiselDemo86").flexisel({
    visibleItems: 4,
    itemsToScroll: 1,
    infinite: true,
    slide:true,
    animationSpeed: 200,
    autoPlay: {
    enable: false,
    interval: 5000,
    pauseOnHover: true
    },
    responsiveBreakpoints: {
    portrait: {
    changePoint:480,
    visibleItems: 2,
    itemsToScroll: 1
    },
    landscape: {
    changePoint:640,
    visibleItems: 2,
    itemsToScroll: 1
    },
    tablet: {
    changePoint:768,
    visibleItems: 3,
    itemsToScroll: 1
    },
   ipad: {
    changePoint:1024,
    visibleItems: 3,
    itemsToScroll: 1
    },
    ipadpro: {
    changePoint:1199,
    visibleItems: 4,
    itemsToScroll: 1
    },
  laptop: {
      changePoint: 1370,
      visibleItems: 4
  }
  }
});


</script> 