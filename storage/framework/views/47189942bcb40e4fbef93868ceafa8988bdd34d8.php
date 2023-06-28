<?php $__env->startSection('main_content'); ?>

<div class="my-profile-pgnm">
  Payment History
    <ul class="breadcrumbs-my">
    <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
      <li><a href="<?php echo e(url('/')); ?>/seller/payment-history">Payment History</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li> View Payment History</li>
    </ul>
</div>
<div class="new-wrapper">
<div class="order-main-dvs">
   <div class="buyer-order-details">
    <?php
      if ($product_arr['transaction_details']['transaction_status'] == 0) {

        $transaction_status = 'Pending';
      }
      elseif ($product_arr['transaction_details']['transaction_status'] == 1) {

        $transaction_status = 'Completed';
      }
      else{

        $transaction_status = 'Failed';
      }
    ?>
    <div class="completed-label-page"><?php echo e($transaction_status); ?></div>
     <div class="order-id-main space-slrs">
      <div class="order-id-main-left">
        <div class="ordr-id-nm"><?php echo e(isset($product_arr['order_no'])?$product_arr['order_no']:'N/A'); ?></div>
       
        <div class="ordertimedate"><?php echo e(isset($product_arr['created_at'])?us_date_format($product_arr['created_at']):'N/A'); ?>     |    <?php echo e(isset($product_arr['created_at'])?time_format($product_arr['created_at']):'N/A'); ?></div>
      </div>
      <div class="order-id-main-right">
       <div class="seller-ord-dtls-right">
           <div class="usr-slr-order"> 


            <?php
              if(isset($product['buyer_details']['profile_image']) && $product['buyer_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$product['buyer_details']['profile_image']))
              {
                $buyer_profile_img = url('/uploads/profile_image/'.$product['buyer_details']['profile_image']);
              }
              else
              {                  
                $buyer_profile_img = url('/assets/images/default-product-image.png');
              }
            ?>
              <img src="<?php echo e($buyer_profile_img); ?>" alt="" />
           </div>
           <div class="usr-slr-order-right">
               <div class="emma-thomas-txt"><?php echo e(isset($product_arr['buyer_details']['first_name'])?$product_arr['buyer_details']['first_name']:''); ?> <?php echo e(isset($product_arr['buyer_details']['last_name'])?$product_arr['buyer_details']['last_name']:''); ?></div>
              
               <div class="sml-txt-slrs">
               
                Buyer
               </div>
               <div class="sml-txt-slrs"><?php echo e(isset($product_arr['buyer_details']['email']) ? $product_arr['buyer_details']['email'] : '-'); ?></div>
           </div>
           <div class="clearfix"></div>
       </div>
      </div>
      <div class="clearfix"></div>
     </div>


     <div class="ordered-products-mns payment-view-history-pmt">
     <div class="ordered-products-titles">Product Description</div> 
      <?php if(isset($product_arr['order_product_details']) && count($product_arr['order_product_details']) > 0): ?>
        <?php $__currentLoopData = $product_arr['order_product_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="list-order-list">
            
            <div class="pricetbsls">$<?php echo e(isset($product['unit_price']) || isset($product['quantity'])? num_format($product['unit_price']*$product['quantity']): '00.00'); ?></div>
              <div class="list-order-list-left">
                <?php
                  if(isset($product['product_details']['product_images_details'][0]['image']) && $product['product_details']['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_details']['product_images_details'][0]['image']))
                  {
                    $product_img = url('/uploads/product_images/'.$product['product_details']['product_images_details'][0]['image']);
                  } 
                  else
                  {                  
                    $product_img = url('/assets/images/default-product-image.png');
                  }
                ?>
                <img src="<?php echo e($product_img); ?>" alt="" />
              </div>
              <div class="list-order-list-right">
                <div class="humidifier-title"><?php echo e(isset($product['product_details']['product_name'])?$product['product_details']['product_name']:'N/A'); ?></div> 


               

<!--------start-product description------------------->
                 <div class="content"> 
                    <div class="hidecontent" id="hidecontent_<?php echo e($product['product_details']['id']); ?>">
                      <?php if(strlen($product['product_details']['description'])>50): ?>
                       <?php echo substr($product['product_details']['description'],0,50) ?>
                      <span class="show-more" style="color: red;cursor: pointer;" onclick="return showmore(<?php echo e($product['product_details']['id']); ?>)">Show more</span>
                      <?php else: ?>
                         <?php echo $product['product_details']['description'] ?>
                      <?php endif; ?>
                    </div>
                       <span class="show-more-content" style="display: none" id="show-more-content_<?php echo e($product['product_details']['id']); ?>">
                        <?php echo $product['product_details']['description'] ?>
                        <span class="show-less" style="color:red;cursor: pointer;" onclick="return showless(<?php echo e($product['product_details']['id']); ?>)"  id="show-less_<?php echo e($product['product_details']['id']); ?>">Show less</span>
                      </span>
                 </div>
<script>

  function showmore(id)
  {
    $('#show-more-content_'+id).show();
     $('#show-less_'+id).show();
     $("#hidecontent_"+id).hide();
  }

   function showless(id)
  {
     $('#show-more-content_'+id).hide();
     $('#show-less_'+id).hide();
     $("#hidecontent_"+id).show();
  }

</script>
<!-----------end product description------------------>


              </div>
            <div class="clearfix"></div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
     <div class="button-subtotal"> 

          <?php 

           $final_amount = isset($product_arr['total_amount'])?$product_arr['total_amount']:'';


          $couponcode = isset($product_arr['couponcode'])?$product_arr['couponcode']:'';
          $discount = isset($product_arr['discount'])?$product_arr['discount']:'';
          $seller_discount_amt = isset($product_arr['seller_discount_amt'])?$product_arr['seller_discount_amt']:'';
          $sellername = get_seller_details($product_arr['seller_id']);
          $final_amount = (float)$final_amount - (float)$seller_discount_amt;

          if (isset($product_arr['delivery_option_id']) && $product_arr['delivery_option_id'] != '') {
            
            $final_amount = (float)$final_amount + (float)$product_arr['delivery_cost'];
          }

          if (isset($product_arr['tax']) && $product_arr['tax'] != '') {
            
            $final_amount = (float)$final_amount + (float)$product_arr['tax'];
          }

          ?> 

          <?php if(isset($couponcode) && !empty($couponcode) && isset($seller_discount_amt) && 
          $seller_discount_amt>0): ?>
             <div class="">
               <div class="gsttotal slrs-ttl-hitory">
                 <div class="gst-left">Couponcode (<?php echo e($couponcode); ?>) (<?php echo e($discount); ?>)% : </div>
               
                 <div class="gst-right"> <?php echo e(isset($seller_discount_amt)? '-$'.number_format($seller_discount_amt,2):'-'); ?></div>
                 <div class="clearfix"></div>
               </div>
             </div>
         <?php endif; ?>

         <?php if(isset($product_arr['delivery_option_id']) && $product_arr['delivery_option_id'] != ''): ?>
          <div class="">
           <div class="gsttotal slrs-ttl-hitory">
             <div class="gst-left">Delivery Option Cost : </div>
             <div class="gst-right">$<?php echo e(isset($product_arr['delivery_cost'])?num_format($product_arr['delivery_cost'] , 2):'00'); ?></div>
             <div class="clearfix"></div>
           </div>
         </div>
         <?php endif; ?>

         <?php if(isset($product_arr['tax']) && $product_arr['tax'] != ''): ?>
          <div class="">
           <div class="gsttotal slrs-ttl-hitory">
             <div class="gst-left">Tax : </div>
             <div class="gst-right">$<?php echo e(isset($product_arr['tax'])?num_format($product_arr['tax'] , 2):'00'); ?></div>
             <div class="clearfix"></div>
           </div>
         </div>
         <?php endif; ?>
       
       
        <div class="">
         <div class="gsttotal slrs-ttl-hitory">
           <div class="gst-left">Transaction Amount : </div>
           
           <div class="gst-right">$<?php echo e(isset($final_amount)?num_format($final_amount):'00'); ?></div>
           <div class="clearfix"></div>
         </div>
       </div>

       <div class="button-subtotal-right">
       <a href="<?php echo e(url('/')); ?>/seller/payment-history" class="butn-def cancelbtnss">Back</a>
       </div>
       <div class="clearfix"></div>
     </div>
     </div>
   </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>