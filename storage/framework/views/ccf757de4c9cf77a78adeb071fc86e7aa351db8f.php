  
  <?php
      
    $slider_image_count =0;

    if(isset($arr_slider_images) && !empty($arr_slider_images) && count($arr_slider_images)>0){
      $slider_image_count =  count($arr_slider_images[0]);
    }

    if($slider_image_count>1){
  ?>
  
    <!-- Indicators -->
    <ol class="carousel-indicators">
         <?php if(!empty($arr_slider_images) && count($arr_slider_images)>0): ?>

           <?php $__currentLoopData = $arr_slider_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1=>$slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php $__currentLoopData = $slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php
                        if($key==0)
                         $active = "active";
                        else
                        $active = '';
                    ?>

                <li data-target="#carousel-example-generic" data-slide-to="<?php echo e($key); ?>" class="<?php echo e($active); ?>"></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

    </ol>

    <?php
      }
    ?>

    <?php $i=0; ?>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php if(!empty($arr_slider_images) && count($arr_slider_images)>0): ?>
           <?php $__currentLoopData = $arr_slider_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        if($k=='0')
                         $active = 'item active';
                        else
                         $active = 'item';
                    ?>

              
               <div class="<?php echo e($active); ?>" style="background-position: center center; margin: 0px; padding: 0;">

           
              <?php if(isset($slide['slider_image']) && isset($slide['slider_medium']) && isset($slide['slider_small'])): ?>


                <figure class="cw-image__figure">
                   <picture>

                     <?php if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_small']) && isset($slide['slider_small'])): ?>

                      <?php
                       $slider_small = image_resize('/uploads/slider_images/'.$slide['slider_small'],375,152);
                      ?>

                   
                      <source  type="image/png" src="<?php echo e($slider_small); ?>" media="(max-width: 621px)">

                     <?php endif; ?>

                     <?php if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_medium']) && isset($slide['slider_medium'])): ?>

                     <?php
                      $slider_medium = image_resize('/uploads/slider_images/'.$slide['slider_medium'],1358,548);
                     ?>

                      
                      <source  type="image/png" src="<?php echo e($slider_medium); ?>" media="(min-width: 622px) ">  

                     <?php endif; ?>

                      <?php if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_image']) && isset($slide['slider_image'])): ?>

                      <?php

                        $slider_image = image_resize('/uploads/slider_images/'.$slide['slider_image'],1358,548);

                      ?>

                    
                      <source  type="image/png" src="<?php echo e($slider_image); ?>" media="(min-width: 835px)"> 

                      <?php endif; ?>

                      <?php if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_image']) && isset($slide['slider_image'])): ?>

                      <?php

                        $default_slider_img = image_resize('/uploads/slider_images/'.$slide['slider_image'],1358,548);
                      ?>

                     
                      <img  class="cw-image cw-image--loaded obj-fit-polyfill" alt="slider image" aria-hidden="false" src="<?php echo e($default_slider_img); ?>">

                      <?php endif; ?>

                    </picture>
                </figure>

              <?php endif; ?>


              <a href="<?php echo e($slide['image_url']); ?>" class="carousel-caption">
                <div class="container">
                  <div class="row">
                    <div class="col-md-7">
                        <div class="banner-text-block">
                           <div class="modarn-hm" <?php if(isset($slide['title_color']) && !empty($slide['title_color'])): ?> style="color:<?php echo e($slide['title_color']); ?>" <?php endif; ?> ><?php echo e(isset($slide['title'])?$slide['title']:''); ?></div>
                                <?php if($k==0): ?>
                                <h1 <?php if(isset($slide['subtitle_color']) && !empty($slide['subtitle_color'])): ?> style="color:<?php echo e($slide['subtitle_color']); ?>" <?php endif; ?>>
                                     <?php echo e(isset($slide['subtitle']) ? $slide['subtitle'] : ''); ?>

                                 </h1>
                                 <?php else: ?>
                                  <h2 <?php if(isset($slide['subtitle_color']) && !empty($slide['subtitle_color'])): ?> style="color:<?php echo e($slide['subtitle_color']); ?>" <?php endif; ?>>
                                     <?php echo e(isset($slide['subtitle']) ? $slide['subtitle'] : ''); ?>

                                 </h2>
                                 <?php endif; ?>
                                <div class="button-rev homts">
                                  <?php if(isset($slide['slider_button']) && (!empty($slide['slider_button']))): ?>
                                    <div class="butn-def" <?php if(isset($slide['button_color']) && !empty($slide['button_color'])): ?> style="color:<?php echo e($slide['button_color']); ?>  <?php if(isset($slide['button_back_color']) && !empty($slide['button_back_color'])): ?>; background-color:<?php echo e($slide['button_back_color']); ?> <?php endif; ?>" <?php endif; ?>><?php echo e($slide['slider_button']); ?></div>
                                 <?php endif; ?>
                           </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                       <div id="wrapper-id">
                        <div class="chat">
                          <div class="chat-container">
                            <div class="chat-listcontainer">
                              <ul class="chat-message-list">
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </a>
          
        </div>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>
</div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
  </a>
