 
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


 <?php if(!empty($arr_product_news) && count($arr_product_news)>0): ?>
    <div class="watch-and-learn-txt nonmrg eql-heightbox-main chowwatchtitleset">
        <div class="border-home-brfands"></div>
        <div class="toprtd viewall-btns-idx viewalls smallfonts chowwatchtitle">
           <span>Chow Watch</span>

              <?php
              if(isset($arr_product_news) && count($arr_product_news)<=$chowwatch_device_count)
              $class = 'butn-def viewall-product';
              else
              $class = 'butn-def';
              ?>

           <a href="<?php echo e(url('/')); ?>/chowwatch" class="<?php echo e($class); ?>">View All </a>
         </div>




           <div class="featuredbrands-flex">

              <ul
                <?php if(isset($arr_product_news) && count($arr_product_news)<=$chowwatch_device_count): ?>
                class="f-cat-below7 watch-four-div"
                
                 <?php elseif(isset($arr_product_news) && count($arr_product_news)>$chowwatch_device_count): ?>
                id="flexiselDemo5"
                <?php endif; ?>
              >

                  <?php $__currentLoopData = $arr_product_news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class="rw-slide-li">
                        <div class="hover-img">
                          <!-- <img src="http://img.youtube.com/vi/<?php echo e($news['url_id']); ?>/0.jpg"> -->
                        </div>
                       


                          <div class="watch-video-lrns updated-watch-v">
                              <div class="video-idx-cw" >

                        <a urlid="<?php echo e($news['url_id']); ?>" href="#" class="vides-idx preview" onclick="openVideo(this);" primaryid="<?php echo e($news['id']); ?>"
                         data-video-id="<?php echo e(isset($news['url_id']) ? $news['url_id'] : ''); ?>"
                         <?php if(isset($news['button_title']) && ($news['button_title']!='')): ?>
                          data-video-btn_title="<?php echo e($news['button_title']); ?>"
                        <?php endif; ?>
                        <?php if(isset($news['button_url']) && ($news['button_url']!='')): ?>
                         data-video-btn_url="<?php echo e($news['button_url']); ?>"
                        <?php endif; ?>

                        <?php if(isset($news['title']) && ($news['title']!='')): ?>
                          data-video-title="<?php echo e($news['title']); ?>"
                        <?php endif; ?>

                        data-video-autoplay="1" data-video-url="<?php echo e($news['video_url']); ?>">
                        <i class="fa fa-play" aria-hidden="true"></i>

                        </a>

                        <?php
                         
                         $chow_watch_image = image_resize('/uploads/product_news/'.$news['image'],290,220);

                        ?>

                          

                             <img src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($chow_watch_image); ?>" alt="<?php echo e(ucfirst($news['title'])); ?>" class="lozad"/>

                              </div>
                              <div class="watch-main-cnts">
                                  <div class="title-vdo-wtch"><?php echo e(ucfirst($news['title'])); ?></div>
                                  <div class="shop-pharmacy-sub brandviodeodes">

                                    <p> <?php echo e(strlen($news['subtitle'])>42 ? wordwrap(substr($news['subtitle'],0,130),26,"\n",TRUE)."..." : $news['subtitle']); ?></p>

                                 </div>
                              </div>
                          </div>
                      </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </ul>
             </div>

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
        
        $("#flexiselDemo5").removeAttr('id');

        $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

      }


  });

  $("#flexiselDemo5").flexisel({
       visibleItems: 4,
       /*infinite: false,*/
       infinite: true,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      },

  });

</script>  