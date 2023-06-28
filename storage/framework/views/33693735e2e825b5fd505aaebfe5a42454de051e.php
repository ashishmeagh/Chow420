

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



  //get state user ids and catdata
  $checkuser_locationdata = checklocationdata(); 
  if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
  {
     $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
     $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
  } 
          
?>


 <?php if(isset($chow_choice_product_arr) && count($chow_choice_product_arr)>0): ?>
      <div class="toprtd non-mgts viewall-btns-idx toprated-view">Chow's Choice

          <?php
          if(isset($chow_choice_product_arr) && count($chow_choice_product_arr)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';
          ?>

         <a href="<?php echo e(url('/')); ?>/search?chows_choice=true" class="<?php echo e($class); ?>" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>

        <div class="featuredbrands-flex trendingproducts-section ">
          <ul <?php if(isset($chow_choice_product_arr) && count($chow_choice_product_arr)<=$device_count): ?>
             class="f-cat-below7"

            <?php elseif(isset($chow_choice_product_arr) && count($chow_choice_product_arr)>$device_count): ?>
              id="flexiselDemo4"
           <?php endif; ?>
         >
            <?php

                $chows_brandname='';
                $chows_sellername ='';
                $is_besesellercc ='';
                $pageclick=[];
                $checkfirstcat_flag = 0;
                $avg_rating = $rating = '';


            ?>
            <?php $__currentLoopData = $chow_choice_product_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php

                        $avg_rating = get_avg_rating($trend_product['id']);

                        // if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}else
                        // if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}
                        $rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';


                        $total_reviews = get_total_reviews($trend_product['id']);
                        if($total_reviews>0)
                          $total_reviews = $total_reviews;
                        else
                           $total_reviews = '';


                     $is_besesellercc = check_isbestseller($trend_product['id']);

                     $choice_prod_concentration  = isset($trend_product['per_product_quantity']) ? $trend_product['per_product_quantity']. 'mg' : '' ;



                     /****************for restriction and out of stock icon*********/

                        $firstcat_id = isset($trend_product['first_level_category_id'])?$trend_product['first_level_category_id']:'';
                        $checkfirstcat_flag = 0;
                         if(isset($catdata) && !empty($catdata))
                         {
                            if(in_array($firstcat_id, $catdata))
                            {
                              $checkfirstcat_flag = 1;
                            }
                            else{
                              $checkfirstcat_flag = 0;
                            }
                         }

                       $restrictseller_id   = isset($trend_product['user_id'])?$trend_product['user_id']:'';

                       // condition added for buyer state restriction
                        if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers))
                       {
                          if(in_array($restrictseller_id,
                            $restricted_state_sellers))
                          {
                           //$checkfirstcat_flag = 0;
                          }
                          else
                          {
                            $checkfirstcat_flag = 1;
                          }
                       }
                       elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($restricted_state_sellers))
                       {
                         $checkfirstcat_flag = 1;
                       }
                       else
                       {
                         //$checkfirstcat_flag = 0;
                       }

                       /***********for restriction and out of stock icon************/

                     $isblur=0;

              ?>


             <li>

               <?php if(isset($login_user) && $login_user == true && $login_user->inRole('buyer')): ?>
                   <?php if($checkfirstcat_flag==0): ?>
                  
                   <?php endif; ?>
               <?php else: ?>
                   
               <?php endif; ?>


                <?php if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1): ?>

                        <div class="out-of-stock trending-left" >
                          <span class="b-class-hide"><img src="<?php echo e(url('/')); ?>/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                        </div>
                   <?php endif; ?>



               <?php if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 ): ?>

                       <?php if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0): ?>

                           <?php if($checkfirstcat_flag==1): ?>
                            <?php $isblur=1; ?>
                              

                           <?php endif; ?>
                      <?php else: ?>
                        

                            <?php if($checkfirstcat_flag==1): ?>
                             <?php $isblur=1; ?>
                               
                            <?php else: ?>
                              <?php $isblur=1; ?>
                              
                            <?php endif; ?>

                         
                      <?php endif; ?>

                  <?php else: ?>
                    

                        <?php if($checkfirstcat_flag==1): ?>
                         <?php $isblur=1; ?>
                           
                        <?php else: ?>
                          <?php $isblur=1; ?>
                          
                        <?php endif; ?>

                    
                  <?php endif; ?>

                <div class="top-rated-brands-list">
                   <?php
                      $product_title = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                      $product_title_slug = str_slug($product_title);

                      $chows_brandname = isset($trend_product['get_brand_detail']['name'])?str_slug($trend_product['get_brand_detail']['name']):'';
                       $chows_sellername = isset($trend_product['get_seller_additional_details']['business_name'])?str_slug($trend_product['get_seller_additional_details']['business_name']):'';


                        $pageclick['name'] = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                       $pageclick['id'] = isset($trend_product['id']) ? $trend_product['id'] : '';
                       $pageclick['brand'] = isset($trend_product['brand']) ? get_brand_name($trend_product['brand']) : '';
                       $pageclick['category'] = isset($trend_product['first_level_category_id']) ? get_first_levelcategorydata($trend_product['first_level_category_id']) : '';

                       if(isset($trend_product['price_drop_to']))
                        {
                          if($trend_product['price_drop_to']>0)
                          {
                              $pageclick['price'] = isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '';
                          }else{
                             $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                          }

                        }else{
                          $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                        }


                      // $pageclick['position'] = $i;
                       // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug.'/'.$chows_brandname.'/'.$chows_sellername ;
                       $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug;


                    ?>

                   
                   <a href="<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($trend_product['id'])?base64_encode($trend_product['id']):'0'); ?>/<?php echo e($product_title_slug); ?>" title="<?php echo e(ucfirst($trend_product['product_name'])); ?>"  onclick="return productclick(<?php echo e(isset($pageclick)?json_encode($pageclick):''); ?>)">
                      <div class="img-rated-brands">


                          



                          <div <?php if(isset($isblur) && $isblur==1): ?> class="thumbnailss blurclass" <?php else: ?> class="thumbnailss" <?php endif; ?>>

                              <!--------show restricted or out of stock for blur product------->

                                  <?php if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 ): ?>

                                       <?php if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0): ?>

                                           <?php if($checkfirstcat_flag==1): ?>
                                               <div class="chow-outofstock-hm">Restricted</div>
                                           <?php endif; ?>
                                      <?php else: ?>

                                            <?php if($checkfirstcat_flag==1): ?>
                                               <div class="chow-outofstock-hm">Restricted</div>
                                            <?php else: ?>
                                               <div class="chow-outofstock-hm">Out of stock</div>
                                            <?php endif; ?>

                                      <?php endif; ?>

                                  <?php else: ?>

                                        <?php if($checkfirstcat_flag==1): ?>
                                          <div class="chow-outofstock-hm">Restricted</div>
                                        <?php else: ?>
                                          <div class="chow-outofstock-hm">Out of stock</div>
                                        <?php endif; ?>

                                  <?php endif; ?>
                              <!-----show restricted or out of stock for blur product------>





                                <?php if(file_exists(base_path().'/uploads/product_images/'.$trend_product['product_images_details'][0]['image']) && isset($trend_product['product_images_details'][0]['image'])): ?>

                              <?php
                              
                               $final_product_image = image_resize('/uploads/product_images/'.$trend_product['product_images_details'][0]['image'],190,190);
                              ?>

                               
                              <img src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($final_product_image); ?>" class="portrait lozad" alt="<?php echo e($product_title); ?>" />

                                <?php else: ?>
                                  <img src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e(url('/assets/images/default-product-image.png')); ?>" class="portrait lozad" alt="<?php echo e($product_title); ?>" />

                                <?php endif; ?>
                            </div>
                        <div class="content-brands">
                           <?php
                                  // $connabinoids_name = get_product_cannabinoids_name($trend_product['id']);
                                  $connabinoids_name = get_product_cannabinoids($trend_product['id']);

                                  ?>
                                  <?php if(isset($connabinoids_name) && count($connabinoids_name) > 0): ?>
                                        <div class="inlineblock-view-cannabionoids">
                                           <span class="inline-trend-product">
                                                <?php
                                                  $i = 0;
                                                  // $numItems = count($connabinoids_name);
                                                ?>
                                                  <?php $__currentLoopData = $connabinoids_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cann): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="oil-category-cannabinoids"> <?php echo e($cann['name']); ?> <?php echo e(floatval($cann['percent'])); ?>%</span>

                                                    

                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </span>
                                        </div>
                                  <?php endif; ?>

                            <div class="title-chw-list">
                              

                                    

                                <span class="titlename-list" asas >
                                <?php echo e(isset($trend_product['id'])?get_product_name($trend_product['id']):''); ?>

                                </span>

                            </div>



                            

                            

                              <div class="price-listing pricestatick viewinlineblock">
                                    <?php if(isset($trend_product['price_drop_to'])): ?>
                                      <?php if($trend_product['price_drop_to']>0): ?>
                                         <?php
                                           if(isset($trend_product['percent_price_drop']) && $trend_product['percent_price_drop']=='0.000000')
                                           {
                                           $percent_price_drop = calculate_percentage_price_drop($trend_product['id'],$trend_product['unit_price'],$trend_product['price_drop_to']);
                                           $percent_price_drop = floor($percent_price_drop);
                                           }
                                           else
                                           {
                                            $percent_price_drop = floor($trend_product['percent_price_drop']);
                                           }
                                       ?>
                                       <span>$<?php echo e(isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '0'); ?> </span>
                                        <del class="pricevies inline-del">

                                        $<?php echo e(isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'); ?>

                                      </del>
                                     


                                      <?php else: ?>
                                      <span>$<?php echo e(isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'); ?> </span>
                                        <del class="pricevies hidepricevies"></del>

                                      <?php endif; ?>
                                    <?php else: ?>
                                    <span>$<?php echo e(isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'); ?> </span>
                                       <del class="pricevies hidepricevies"></del>


                                    <?php endif; ?>
                               </div>
                               <!-----------truck---------------->
                                        <?php if(isset($trend_product['shipping_type']) && $trend_product['shipping_type']==0): ?>
                                         <?php
                                              $setshippingcc = "";
                                              if($trend_product['shipping_type']==0)
                                              { $setshippingcc = "Free Shipping";
                                              }
                                              else{
                                                $setshippingcc = "Flat Shipping";
                                              }
                                         ?>
                                         <div class="freeshipping-class" title="<?php echo e($setshippingcc); ?>">
                                          Free Shipping
                                        </div>
                                        <?php endif; ?>
                                      <!----------truck----------------->

                            <div class="starthomlist "  <?php if($avg_rating>0): ?> title="<?php echo e(isset($avg_rating)?$avg_rating:''); ?> Rating is a combination of all ratings on chow in addition to ratings on vendor site."
                           <?php endif; ?>>
                              <?php if($avg_rating>0 && isset($rating)): ?>
                               

                                <img class="lozad" src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e($rating); ?>.svg" alt="<?php echo e($rating); ?>.svg"  title="<?php echo e(isset($avg_rating)?$avg_rating:''); ?> Rating is a combination of all ratings on chow in addition to ratings on vendor site."/>

                                 <!-------review------------>

                                 <span class="str-links starcounts" title="<?php if($total_reviews==1): ?><?php echo e($total_reviews); ?> Rating <?php elseif($total_reviews>1): ?><?php echo e($total_reviews); ?> Ratings <?php endif; ?>">
                                  
                                  <?php echo e($avg_rating); ?>

                                  <?php if(isset($total_reviews)): ?> (<?php echo e($total_reviews); ?>) <?php endif; ?>
                                 </span>
                                 <!--------review--------------->
                              <?php endif; ?>
                            </div><!--end div of rating--->


                            <!--coupon code text div-->

                                <?php
                                  $get_available_coupon = [];
                                  $get_available_coupon = get_coupon_details($trend_product['user_id']);
                                ?>

                                <?php if(isset($get_available_coupon) && count($get_available_coupon)>0): ?>

                                <div class="couponsavailable">Coupons Available</div>

                                <?php endif; ?>


                            <!------------------------>




                            <!--------------cc-and best seller------------------->
                                 <div class="inlineblock-view">
                                   

                                    


                                      <!-----------truck---------------->
                                       
                                      <!----------truck----------------->

                                        <!-- Lab results available Start -->
                                       <!--  <?php if(isset($trend_product['product_certificate']) && !empty($trend_product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$trend_product['product_certificate']) ): ?>
                                          <div class="labresults-class" style="margin-left: 0px">
                                           <span class="b-class-hide">Lab Results Available</span>
                                          </div>
                                        <?php endif; ?>   -->
                                      <!-- Lab results available End -->



                                 </div>


                                <!-----------end cc and best seller--------------->

                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
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
        
        $("#flexiselDemo4").removeAttr('id');

        $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

      }


  });

    $("#flexiselDemo4").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
      animationSpeed: 200,
   
      infinite: true,
      navigationTargetSelector: null,
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
      itemsToScroll: 1,
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
      }
      }
      });

  </script>