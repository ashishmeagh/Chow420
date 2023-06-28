 
<?php $__env->startSection('main_content'); ?>
 <link href="<?php echo e(url('/')); ?>/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />


<style>
.list-order-list {
    padding: 20px;
}
.classordermain .productnames.prodct-nms-slr{color: #000}
.list-order-list-left {
    height: auto;
}
.order-id-main-left {
    float: none;
}
.list-order-list-right {
    margin-left: 140px;
}
.productnames {
    float: left;
}
.classordermain .ordr-id-nm{
    margin-left: 110px;
}
.classordermain{margin-bottom:20px;}
.classordermain .productnames{margin-top:6px; margin-right: 5px; color: #9b9b9b;}
.classordermain .productnames span{color: #000;}
.classordermain .price-order-my{ margin-left: 80px; margin-top:0px;}
.order-id-main-right.activeposin{
position: absolute; top:10px; right:10px;
}
.classordermain .ordr-id-nm{font-size: 16px;}
.classordermain .price-order-my{font-size: 23px;}
.morecontent span {
  display: none;
}
.morelink {
    display: block;
     color: #887d7d;
}
.morelink:hover,.morelink:focus{
  color: #887d7d;
}
.morelink.less
{
   color: #887d7d;
}
.whitecol{
  color:white!important;
}
</style> 

<div class="my-profile-pgnm">
<?php echo e($page_title); ?>

<ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="<?php echo e(url('/')); ?>/seller/product"> Products</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>View Product</li>
    </ul>
</div>
    <div class="new-wrapper">
        <div class="order-main-dvs">
            <div class="buyer-order-details ">
                <div class="order-id-main-right activeposin">
                <?php if($arr_product_data['is_active']==1): ?>
                <div class="status-completed">Active</div>
                <?php else: ?>          
                <div class="status-shipped">Block</div>
                <?php endif; ?>
            </div>
        <div class="order-id-main">
            <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Product Name:</div>   <div class="ordr-id-nm"><?php echo e(isset($arr_product_data['product_name']) ? $arr_product_data['product_name'] : 'NA'); ?></div>
                <!-- <div class="location-nms"><i class="fa fa-map-marker"></i> Johnson Heights,110 Street, New York</div> <div class="ordertimedate">05 Nov 2019   |   10:20pm</div> -->
                <div class="clearfix"></div>
            </div>

            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Sku:</span> <?php echo e(isset($arr_product_data['sku']) ? $arr_product_data['sku'] : 'NA'); ?></div> 
                <div class="clearfix"></div>
            </div>
            
            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Seller Name:</span> <?php echo e(isset($arr_product_data['user_details']['first_name']) ? $arr_product_data['user_details']['first_name'] : 'NA'); ?></div> 
                <div class="clearfix"></div>
            </div>

            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Unit Price:</span>
                  <?php if($arr_product_data['unit_price']): ?>
                   $<?php echo e(round($arr_product_data['unit_price'],2)); ?>

                   <?php else: ?>
                     NA
                   <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>

              <?php
               if(isset($arr_product_data['percent_price_drop']) && $arr_product_data['percent_price_drop']=='0.000000') 
               {
                 $percent_price_drop = calculate_percentage_price_drop($arr_product_data['id'],$arr_product_data['unit_price'],$arr_product_data['price_drop_to']); 
                 $percent_price_drop = floor($percent_price_drop);
               }
               else
               { 
                $percent_price_drop = floor($arr_product_data['percent_price_drop']);
               }
              ?>

             <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Price Drop: </span>
                    <?php if(isset($arr_product_data['price_drop_to']) && (!empty($arr_product_data['price_drop_to']))): ?>
                    $<?php echo e(num_format($arr_product_data['price_drop_to'],2)); ?> <?php if($arr_product_data['price_drop_to']>0): ?> (<?php echo e($percent_price_drop); ?>% off) <?php endif; ?>
                    <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>

            
            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Category:</span> <?php if($arr_product_data['first_level_category_details']['product_type']): ?> <span class="badge badge-warning"><?php echo e($arr_product_data['first_level_category_details']['product_type']); ?> <?php else: ?>
                  NA
                  <?php endif; ?></span></div> 
                <div class="clearfix"></div>
            </div>

            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Sub category:</span> <?php if($arr_product_data['second_level_category_details']['name']): ?> <span class="badge badge-warning"><?php echo e($arr_product_data['second_level_category_details']['name']); ?> <?php else: ?> NA <?php endif; ?> </span></div> 
                <div class="clearfix"></div>
            </div>

            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Remaining Stock:</span> <?php echo e($arr_product_data['inventory_details']['remaining_stock']); ?></div> 
                <div class="clearfix"></div>
            </div>


            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Shipping Type:</span> 
                    <?php if($arr_product_data['shipping_type']=="0"): ?>
                     Free Shipping 
                    <?php elseif($arr_product_data['shipping_type']=="1"): ?> 
                     Flat Shipping
                    <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>

             <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Shipping Charges:</span> 
                    <?php if($arr_product_data['shipping_type']=="1" && isset($arr_product_data['shipping_charges'])): ?>
                     <?php echo e(num_format($arr_product_data['shipping_charges'],2)); ?>

                    <?php else: ?>      
                    NA             
                    <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>

                 <?php
                      $full_day = $str_shipping_duration = ""; 
                      if(isset($arr_product_data['shipping_duration']) && $arr_product_data['shipping_duration']!="" && filter_var($arr_product_data['shipping_duration'], FILTER_VALIDATE_FLOAT)==true && $arr_product_data['shipping_duration']!=0.500000) 
                      {
                         $full_day = floor($arr_product_data['shipping_duration']); 
                         $fraction = $arr_product_data['shipping_duration'] - $full_day;
                         if(isset($full_day) && $full_day!="")
                         { 
                            if(isset($fraction) && $fraction!=0)
                            {  
                             $str_shipping_duration = $full_day." & Half Day";  
                            }
                            else if(isset($fraction) && $fraction==0 && $full_day==1) 
                            {
                             $str_shipping_duration = $full_day." Day"; 
                            }
                            else if(isset($fraction) && $fraction==0 && $full_day!=1) 
                            {
                             $str_shipping_duration = $full_day." Days"; 
                            }
                         }
                      }
                      else if(isset($arr_product_data['shipping_duration']) && $arr_product_data['shipping_duration']!="" && filter_var($arr_product_data['shipping_duration'], FILTER_VALIDATE_FLOAT)==true && $arr_product_data['shipping_duration']== 0.500000)
                      {
                          $str_shipping_duration = "Half Day";  
                      }
                  ?> 


             <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Shipping Duration:</span> 
                    <?php if(isset($str_shipping_duration) && $str_shipping_duration!=""): ?>
                        <?php echo e($str_shipping_duration); ?>

                    <?php else: ?>
                      NA
                    <?php endif; ?>  
                </div> 
                <div class="clearfix"></div>
            </div>


              <div class="order-id-main-left classordermain"> 
                <div class="productnames disapprove-reason" style="color:red"> <span>Disapproved Reason:</span> 
                    <?php if($arr_product_data['is_approve']=="2" && isset($arr_product_data['reason']) && ($arr_product_data['reason']!="")): ?>
                     <?php echo e($arr_product_data['reason']); ?>  
                    <?php elseif($arr_product_data['is_approve']=="0" || $arr_product_data['is_approve']=="1" ): ?>
                     NA   
                    <?php else: ?>      
                    NA             
                    <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>


             <?php if(isset($arr_product_data['first_level_category_details']['product_type']) && !empty($arr_product_data['first_level_category_details']['product_type']) && $arr_product_data['first_level_category_details']['product_type']=="Accessories" || $arr_product_data['first_level_category_details']['product_type']=="Essential Oils"): ?>
            <?php else: ?>
            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Concentration(mg):</span> 
                    <?php if(isset($arr_product_data['per_product_quantity'])): ?>
                     <?php echo e($arr_product_data['per_product_quantity']); ?>

                    <?php else: ?>      
                    NA             
                    <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>
            <?php endif; ?>

            <!---------------start-product-dimension---------------------------->
           
            <!---------end product-dimension----------------------------------->


            <?php
             $arr_dropshipper_details = [];
            if(isset($arr_product_data['drop_shipper']) && $arr_product_data['drop_shipper']!="")
            {  
              $arr_dropshipper_details = get_product_dropshipper($arr_product_data['drop_shipper']);
            }  
            ?>

            <?php if(isset($arr_dropshipper_details) && sizeof($arr_dropshipper_details)>0): ?>
               <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Dropshipper Name:</span> 
                    <?php echo e(isset($arr_dropshipper_details['name'])?ucfirst($arr_dropshipper_details['name']):''); ?>

                </div> 
                <div class="clearfix"></div>
               </div>
               <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Dropshipper Email ID:</span> 
                     <?php echo e(isset($arr_dropshipper_details['email'])?$arr_dropshipper_details['email']:''); ?>

                </div> 
                <div class="clearfix"></div>
            </div>
               <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Dropshipper Price:</span> 
                 $<?php echo e(isset($arr_dropshipper_details['product_price'])?num_format($arr_dropshipper_details['product_price'],2):''); ?>

                 </div>
              <div class="clearfix"></div>

          </div>
            <?php endif; ?>


             <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Admin Approval Status:</span> 
                    <?php if($arr_product_data['is_approve']=='0'): ?>
                      <span class='status-dispatched whitecol'>Pending Approval</span>
                    <?php elseif($arr_product_data['is_approve']=='1'): ?>
                       <span class='status-completed whitecol'>Approved</span>
                    <?php elseif($arr_product_data['is_approve']=='2'): ?>
                      <span class='status-shipped whitecol'>Disapproved </span>     
                         
                    <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>


            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Product Video Source:</span> 
                   <?php if(isset($arr_product_data['product_video_source'])): ?>
                      <span class=''>
                       <?php
                       if(isset($arr_product_data['product_video_source']) && !empty($arr_product_data['product_video_source']))
                        echo ucfirst($arr_product_data['product_video_source']);
                       else
                         echo 'NA';
                       ?>  
                      </span>
                   <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>



            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Rating:</span> 
                      <span class=''>
                         <?php
                          if(isset($arr_product_data['avg_rating']) && !empty($arr_product_data['avg_rating']))
                             echo ucfirst($arr_product_data['avg_rating']);
                         else
                           echo 'NA';
                         ?>  
                      </span>
                 
                </div> 
                <div class="clearfix"></div>
            </div>


            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Review:</span> 
                      <span class=''>
                         <?php
                          if(isset($arr_product_data['avg_review']) && !empty($arr_product_data['avg_review']))
                             echo ucfirst($arr_product_data['avg_review']);
                         else
                           echo 'NA';
                         ?>  
                      </span>
                 
                </div> 
                <div class="clearfix"></div>
            </div>


             <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Spectrum Type:</span> 
                   <?php
                    if(isset($arr_product_data['spectrum']) && !empty($arr_product_data['spectrum']))
                    {
                      $get_spectrum_val = get_spectrum_val($arr_product_data['spectrum']);
                    }
                   ?>
                   <?php echo e(isset($get_spectrum_val['name'])?$get_spectrum_val['name']:'NA'); ?>

                   
                </div> 
                <div class="clearfix"></div>
            </div> 


            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Terpenes:</span> 
                   <?php
                    if(isset($arr_product_data['terpenes']) && !empty($arr_product_data['terpenes']))
                    {
                      $get_terpenes_val = $arr_product_data['terpenes'];
                    }
                   ?>
                   <?php echo e(isset($get_terpenes_val)?$get_terpenes_val:'NA'); ?>

                 
                </div> 
                <div class="clearfix"></div>
            </div>


            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Additional Product Image:</span> 
                   <?php

                    $product_img = '';
                   
                    if(isset($arr_product_data['additional_product_image']) && !empty($arr_product_data['additional_product_image']))
                    {
                      $product_img = url('/uploads/additional_product_image/'.$arr_product_data['additional_product_image']);
                    }
                   ?>
                    <img src="<?php echo e($product_img); ?>" alt="Additional Product Image" width="100"> 
                 
                </div> 
                <div class="clearfix"></div>
            </div>      
          


          <div class="order-id-main-left classordermain">
                <div class="productnames"> 
                    <?php
                      $arr_cannabinoids = get_product_cannabinoids($arr_product_data['id']);
                    ?>

                    <?php if(isset($arr_cannabinoids) && count($arr_cannabinoids) > 0): ?>
                      <?php $__currentLoopData = $arr_cannabinoids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $canName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="oil-category-cannabinoids"><?php echo e($canName['name']); ?> <?php echo e(floatval($canName['percent'])); ?>%</span>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div> 
                <div class="clearfix"></div>
            </div>   
          


             <?php if(isset($arr_product_data['product_video_source']) && !empty($arr_product_data['product_video_source'])): ?>
                   <a href="javascript:void(0)"  class="btn btn-info" style="background-color: #873dc8;border-color: #873dc8;" id="product_video_popup" data-video-source="<?php echo e($arr_product_data['product_video_source']); ?>" data-video-id="<?php echo e($arr_product_data['product_video_url']); ?>" data-video-title="<?php echo e(isset($arr_product_data['product_name'])? $arr_product_data['product_name']: ''); ?>" onclick="openProductVideoModal(this);">
                      View Video 
                    </a>
             <?php endif; ?>

            
 
            <!-- <div class="order-id-main-left classordermain">
                <div class="productnames"> Product Stock :</div> <div class="price-order-my"><?php echo e($arr_product_data['product_stock']); ?></div>
                <div class="clearfix"></div>
            </div> -->
            <div class="clearfix"></div>
        </div> 

     <div class="ordered-products-mns">
        <div class="ordered-products-titles">Other Details: </div> 
     <div class="list-order-list">
 
      <!-- <div class="age-limited">18+ Age</div> -->
      <!-- <div class="pricetbsls">$ 20.25</div> -->
            <div class="list-order-list-left" id="lightgallery2">
                <?php

                  $product_title_slug = str_slug($arr_product_data['product_name']);


                  if(isset($arr_product_data['product_images_details'][0]['image']) && $arr_product_data['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/thumb/'.$arr_product_data['product_images_details'][0]['image']))
                  {
                    $product_img = url('/uploads/product_images/'.$arr_product_data['product_images_details'][0]['image']);
                  
                  // else
                  // {                  
                  //   $product_img = url('/assets/images/default-product-image.png');
                  // }
                ?>
            

                 <a href="" data-responsive="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product_data['product_images_details'][0]['image']); ?>" data-src="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product_data['product_images_details'][0]['image']); ?>">
                  
                  <img src="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product_data['product_images_details'][0]['image']); ?>" alt="Product Image" width="100"> 
                </a>

              <?php
               }
             ?>   



         </div>

         





        <div class="list-order-list-right">
            <div class="humidifier-title">Description: </div> 

                <?php
                    $brands_name = isset($arr_product_data['get_brand_detail']['name'])?$arr_product_data['get_brand_detail']['name']:'';
                    if(isset($brands_name)){
                      $brandName = str_replace(' ','-',$brands_name); 
                    }
                ?>



            <div class="qty-prc">Brand: <a href="<?php echo e(url('/')); ?>/search?brands=<?php echo e($brandName); ?>"><?php echo e($arr_product_data['get_brand_detail']['name']); ?></a></div>

              <!-----------------start of show rating-------------------------------->

                <?php

                  $total_review = get_total_reviews($arr_product_data['id']);
                  $avg_rating  = get_avg_rating($arr_product_data['id']);
                  if(isset($avg_rating) && $avg_rating > 0)
                  {
                    $img_avg_rating = "";
                    if($avg_rating=='1') $img_avg_rating = "star-rate-one.png";
                    else if($avg_rating=='2')  $img_avg_rating = "star-rate-two.png";
                    else if($avg_rating=='3')  $img_avg_rating = "star-rate-three.png";
                    else if($avg_rating=='4')  $img_avg_rating = "star-rate-four.png";
                    else if($avg_rating=='5')  $img_avg_rating = "star-rate-five.png";
                    else if($avg_rating=='0.5')  $img_avg_rating = "star-rate-zeropointfive.png";
                    else if($avg_rating=='1.5')  $img_avg_rating = "star-rate-onepointfive.png";
                    else if($avg_rating=='2.5')  $img_avg_rating = "star-rate-twopointfive.png";
                    else if($avg_rating=='3.5')  $img_avg_rating = "star-rate-threepointfive.png";
                    else if($avg_rating=='4.5')  $img_avg_rating = "star-rate-fourpointfive.png";
                  }

                ?>
                <?php if($avg_rating>0): ?>
                              <div class="stars" <?php if($avg_rating>0): ?> title="<?php echo e($avg_rating); ?> Avg. rating" <?php endif; ?>> 
                             
                                <img src="<?php echo e(url('/')); ?>/assets/front/images/<?php echo e(isset($img_avg_rating)?$img_avg_rating:''); ?>" alt=""> 
                                 <?php if($total_review > 0): ?>
                                 <span href="#" class="str-links starcounts" 
                                    title=" <?php if($total_review==1): ?>  
                                            <?php echo e($total_review); ?> Review 
                                            <?php elseif($total_review>1): ?>  
                                            <?php echo e($total_review); ?> Reviews 
                                            <?php endif; ?>
                                          ">
                                    <?php echo e($total_review); ?>

                                  </span>
                                 <?php endif; ?>
                              </div>
                       <?php endif; ?> 


              <!-----------------end of show rating------------------>



 
            <!------------------show age restriction----------------------------->                             
              <?php if(isset($arr_product_data['age_restriction_detail']['age'])): ?>
              <div class="age-img-plus small-size-age">

                <?php  

                    if(isset($arr_product_data['age_restriction_detail']['age']))
                     $age_restrict = $arr_product_data['age_restriction_detail']['age'];
                   else
                     $age_restrict = '';
                 ?>

                 <?php if($age_restrict=="18+"): ?>
                  <div class="age-img-inline" title="18+ Age restriction">
                    <img src="<?php echo e(url('/')); ?>/assets/front/images/product-age-mini.png" alt=""> 
                  </div>
                  <?php endif; ?>

                  <?php if($age_restrict=="21+"): ?>
                    <div class="age-img-inline" title="21+ Age restriction">
                      <img src="<?php echo e(url('/')); ?>/assets/front/images/product-age-max.png" alt=""> 
                    </div>
                  <?php endif; ?>

             </div>
            <?php endif; ?>
        <!------------------end of show age restriction----------------------------->


           


<!--------start-product description------------------->
           <div class="content"> 
              <div id="hidecontent">
                <?php if(strlen($arr_product_data['description'])>50): ?>
                 <?php echo substr($arr_product_data['description'],0,50) ?>
                <span id="show-more" style="color: #887d7d;cursor: pointer;">...Show more</span>
                <?php else: ?>
                   <?php echo $arr_product_data['description'] ?>
                <?php endif; ?>
              </div>
                 <span id="show-more-content">
                  <?php echo $arr_product_data['description'] ?>
                  <span id="show-less" style="color:#887d7d;cursor: pointer;">Show less</span>
                </span>
           </div>
<script>
 $('#show-more-content').hide();
$('#show-more').click(function(){
  $('#show-more-content').show();
  $('#show-less').show();
  $(this).hide();
  $("#hidecontent").hide();
});
$('#show-less').click(function(){
  $('#show-more-content').hide();
  $('#show-more').show();
  $(this).hide();
   $('#hidecontent').show();
});
</script>
<!-----------end product description------------------>

        </div>
        
        <div class="clearfix"></div>
        </div>
     <!--  -->
       <div class="clearfix"></div>
     </div>

     <!--------------------show COA Image------------------------------->
  
    <?php 

     if(isset($arr_product_data['product_certificate']) && $arr_product_data['product_certificate'] != '' && file_exists(base_path().'/uploads/product_images/'.$arr_product_data['product_certificate'])){

    ?>

    <?php if(isset($arr_product_data['first_level_category_details']['product_type']) && !empty($arr_product_data['first_level_category_details']['product_type']) && $arr_product_data['first_level_category_details']['product_type']=="Accessories" || $arr_product_data['first_level_category_details']['product_type']=="Essential Oils"): ?>
    <?php else: ?>

     <div class="ordered-products-mns">
      <div class="ordered-products-titles">Certificate Of Analysis: </div> 
        <div class="list-order-list">
         

         <?php

          $prod_certificate = $arr_product_data['product_certificate'];
          $ext = pathinfo($prod_certificate, PATHINFO_EXTENSION);
          if($ext=="pdf"){
          ?>
             <div class="disv-zooms">
               <a href="<?php echo e(url('/')); ?>/uploads/product_images/<?php echo e($arr_product_data['product_certificate']); ?>" target="_blank">
                View certificate
               </a>
             </div>
         <?php
            }else{ 
         ?>  

         NA
        
       
         
         <?php } ?>
        

        <div class="clearfix"></div>
      </div>
       <div class="clearfix"></div>
     </div>
     <?php endif; ?>

    <?php
      }
   ?>

     <!----------------end of coa image------------------------------------->




     <div class="button-subtotal">
        
       <div class="button-subtotal-right">
         <a href="<?php echo e(url('/')); ?>/seller/product" class="butn-def cancelbtnss">Back</a>
       </div>
       <!-- <div class="button-subtotal-right">
         <div class="gsttotal">
           <div class="gst-left">Subtotal</div>
           <div class="gst-right">$ 60.50</div>
           <div class="clearfix"></div>
         </div>
         <div class="gsttotal">
           <div class="gst-left">GST</div>
           <div class="gst-right">3%</div>
           <div class="clearfix"></div>
         </div>
         <div class="gsttotal">
           <div class="gst-left">Total</div>
           <div class="gst-right">$ 75.50</div>
           <div class="clearfix"></div>
         </div>
       </div> -->
       <div class="clearfix"></div>
     </div>
     </div>
   </div>
</div>
</div>



<!----------------videomodal-------------------------->

<div  class="modal fade" id="productVideoModal" tabindex="-1" role="dialog" aria-labelledby="productVideoModalTitle1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header borderbottom">
        <div class="video-modal-title" id="productVideoModalTitle"></div>
        
        <button type="button" id="close_product_video" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="yt-player" style="height: 400px;">
        <iframe class="youtube-video" id="youtube-video" width="100%" height="100%" frameborder="0" allowfullscreen
            src="">
        </iframe>

      </div>
    </div>
  </div>
</div>
<!---------------end videomodal------------>


  <script>
    function openProductVideoModal(ref){

      let videoID = $(ref).attr('data-video-id');
      
      let video_source = $(ref).attr('data-video-source');

      let title = $(ref).attr('data-video-title');
      let videoUrl ='';
      if(video_source=="youtube")
      {
        videoUrl = 'https://www.youtube.com/embed/'+videoID/*+'?autoplay=1'*/;
      }
      if(video_source=="vimeo")
      {
        videoUrl = 'https://player.vimeo.com/video/'+videoID/*+'?autoplay=1'*/;
      }

      $("#yt-player iframe.youtube-video").attr("src",videoUrl);

      $(".modal-footer").html('');  
      $("#productVideoModalTitle").html(title);     

      $("#productVideoModal").modal();
    }

  </script>







<script type="text/javascript">
  $(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 200;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";
    

    $('.decs-p').each(function() {
        var content = $(this).html().trim();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
  
    $('.disapprove-reason').each(function() {
        var content = $(this).html().trim();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses" style="color:red">' + ellipsestext+ '&nbsp;</span><span class="morecontent" style="color:red"><span style="color:red">' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>'; 
            $(this).html(html);
        }
 
    });
  

    


    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
</script>



 <script type="text/javascript">
    $(document).ready(function(){
        $('#lightgallery').lightGallery();
        $('#lightgallery2').lightGallery();
    });
    </script>
    <script type="text/javascript"  src="<?php echo e(url('/')); ?>/assets/front/js/lightgallery-all.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>