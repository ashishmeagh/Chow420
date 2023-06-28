<?php $__env->startSection('main_content'); ?>
        
<style>
  .whitespace-norwap{white-space: nowrap;}
  .rw-location-nms span.location-nms-right-content {
    width: auto;
    margin-left: 8%;
}
  .subtotl-min .gsttotal.slrs-ttl-hitory {
    font-size: 20px;
}
.note-view {display: block;clear: both;color: #f50000;font-size: 14px;margin-bottom: 40px;}
.note-view span{font-weight: 600;}
.subtotl-min {
    text-align: right;
    background-color: #ececec;
    padding: 10px;
}
 .subtotl-min .gsttotal.slrs-ttl-hitory .gst-right {
        margin-right: 0px;
    margin-left: 0px;
    display: inline-block;
    width: 110px;
    text-align: left;
}
.subtotl-min .gst-left{float: none; display: inline-block;}

.morecontent span {
    display: none;
} 
.morelink {
    display: block;
    color: red;
}
.morelink:hover,.morelink:focus{
  color: red;
}
.morelink.less
{
  color: red;
}
.qty-bld{
  font-weight: bold;
}


@media  all and (max-width:767px){
 .whitespace-norwap{white-space: nowrap;}
  .rw-location-nms span.location-nms-right-content {
    width: auto;
    margin-left: 0;
}
}
</style>

<div class="my-profile-pgnm">
  Order Details
  <ul class="breadcrumbs-my">
  <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
  <li><i class="fa fa-angle-right"></i></li>

  <?php if(Request::segment(2) == "age_restricted_order"): ?>

    <li><a href="<?php echo e(url('/')); ?>/seller/age_restricted_order">Pending Age Verification Orders</a></li>

  
  <?php else: ?>

     <li><a href="<?php echo e(url('/')); ?>/seller/order/<?php echo e($product_status); ?>"><?php echo e(ucfirst($product_status)); ?> Order</a></li>

  <?php endif; ?>  
    <li><i class="fa fa-angle-right"></i></li>
    <li>Order Details</li>
  </ul>
</div>
<div class="new-wrapper">
   <?php echo $__env->make('front.layout.flash_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="order-main-dvs">
   <div class="buyer-order-details">
    <?php


      if ($product_arr['transaction_details']['transaction_status'] == 0) {

        $transaction_status = 'Pending';
      }
      elseif ($product_arr['transaction_details']['transaction_status'] == 1) {

        $transaction_status = 'Complete';
      }
      else{

        $transaction_status = 'Failed';
      }

    ?>
    <!-- <div class="completed-label-page"><?php echo e($transaction_status); ?></div> -->
     <div class="order-id-main space-slrs">
      <div class="order-id-main-left">
        <div class="ordr-id-nm"><?php echo e(isset($product_arr['order_no'])?$product_arr['order_no']:'N/A'); ?></div>
       
        <div class="ordertimedate"><?php echo e(isset($product_arr['created_at'])?us_date_format($product_arr['created_at']):'N/A'); ?>     |    <?php echo e(isset($product_arr['created_at'])?time_format($product_arr['created_at']):'N/A'); ?></div>

        <?php if(isset($product_arr['buyer_age_restrictionflag']) && $product_arr['buyer_age_restrictionflag'] ==1): ?>
         

         <a href="javascript:void(0);" class="age-verificationbtns">Please do not ship yet, the user is going through our age verification process</a>
        <?php endif; ?>

      </div>



       
      <div class="order-id-main-right">
        <?php if(isset($product_arr['buyer_age_restrictionflag']) && $product_arr['buyer_age_restrictionflag'] ==1): ?>
          <div class="status-dispatched">Pending Age Verification</div>
       <?php endif; ?>  
        

      </div>
      <div class="clearfix"></div>
     </div>

    

      <!----------buyer------------------>
      <hr>
       <div class="seller-ord-dtls-right">
           <div class="usr-slr-order">
              <?php
                if(isset($product['buyer_details']['profile_image']) && $product['buyer_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$product['buyer_details']['profile_image']))
                {
                  $buyer_profile_img = url('/uploads/profile_image/'.$product['buyer_details']['profile_image']);
                }
                else
                {                  
                  $buyer_profile_img = url('/assets/images/user-degault-img.jpg');
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
        <hr>
       <!------------end of buyer------------------>

      


    <div class="location-nms rw-location-nms">

                <?php

                  
                  $address = isset($product_arr['address_details']['shipping_address1'])? $product_arr['address_details']['shipping_address1']:'';

                  $state = isset($product_arr['address_details']['state_details']['name'])? $product_arr['address_details']['state_details']['name']:'';

                  $country = isset($product_arr['address_details']['country_details']['name'])? $product_arr['address_details']['country_details']['name']:'';

                  $zipcode = isset($product_arr['address_details']['shipping_zipcode'])? $product_arr['address_details']['shipping_zipcode']:'';

                  $city = isset($product_arr['address_details']['shipping_city'])? $product_arr['address_details']['shipping_city']:'';

                  $billing_address = isset($product_arr['address_details']['billing_address1'])? $product_arr['address_details']['billing_address1']:'';

                  $billing_state =  isset($product_arr['address_details']['billing_state_details']['name'])? $product_arr['address_details']['billing_state_details']['name']:'';
                 
                  $billing_country = isset($product_arr['address_details']['billing_country_details']['name'])?$product_arr['address_details']['billing_country_details']['name']:'';

                  $billing_zipcode = isset($product_arr['address_details']['billing_zipcode'])? $product_arr['address_details']['billing_zipcode']:'';

                  $billing_city = isset($product_arr['address_details']['billing_city'])? $product_arr['address_details']['billing_city']:'';

    
                ?>


            <?php if(isset($address) && $address!=""): ?>
                <span><b>Shipping Address: </b> <i class="fa fa-map-marker"></i> </span>
               

                <?php if(isset($product_arr['address_details']['shipping_address1']) && (!empty($product_arr['address_details']['shipping_address1']))): ?>
                      <?php echo e($product_arr['address_details']['shipping_address1']); ?>

                <?php endif; ?>  

                 <?php if(isset($product_arr['address_details']['shipping_city']) && (!empty($product_arr['address_details']['shipping_city']))): ?>
                      ,<?php echo e($product_arr['address_details']['shipping_city']); ?>

                <?php endif; ?>  

                <?php if(isset($product_arr['address_details']['state_details']['name']) && (!empty($product_arr['address_details']['state_details']['name']))): ?>
                      ,<?php echo e($product_arr['address_details']['state_details']['name']); ?>

                <?php endif; ?>  

                 <?php if(isset($product_arr['address_details']['country_details']['name']) && (!empty($product_arr['address_details']['country_details']['name']))): ?>
                      ,<?php echo e($product_arr['address_details']['country_details']['name']); ?>

                <?php endif; ?>  

                  <?php if(isset($product_arr['address_details']['shipping_zipcode']) && (!empty($product_arr['address_details']['shipping_zipcode']))): ?>
                      - <?php echo e($product_arr['address_details']['shipping_zipcode']); ?>

                <?php endif; ?>  
            <?php endif; ?>

          </div>
           <div class="location-nms rw-location-nms">
             
          <?php if(isset($product_arr['note']) && $product_arr['note'] != ''): ?>
            <span class="whitespace-norwap">
              <b>Order Note:  </b> 
              
               </span>
               <span class="location-nms-right-content">
              <?php echo e($product_arr['note']); ?>

              </span>
          <?php endif; ?>
           </div>


          
  
     <div class="ordered-products-mns">
     <div class="ordered-products-titles">Product Description</div> 
    
      <?php if(isset($product_arr['order_product_details']) && count($product_arr['order_product_details']) > 0): ?>
        <?php $shippingtotal=0; ?>
        <?php $__currentLoopData = $product_arr['order_product_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
         $shippingtotal += $product['shipping_charges']; 

        
        ?>

          <div class="list-order-list">
               <?php if(isset($product['age_restriction_detail']) && $product['age_restriction_detail']!=""): ?>
                  <div class="age-limited">                    
                        <?php echo e(isset($product['age_restriction_detail']['age'])?$product['age_restriction_detail']['age']:''); ?>

                  </div>
                <?php endif; ?>



            
            <div class="pricetbsls">
                  $<?php echo e(isset($product['unit_price']) || isset($product['quantity'])? num_format($product['unit_price']*$product['quantity']): '00.00'); ?>

            </div>
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
                <img src="<?php echo e($product_img); ?>" alt="<?php echo e(isset($product['product_details']['product_name'])?$product['product_details']['product_name']:''); ?>" />
              </div>
              <div class="list-order-list-right">
                <div class="humidifier-title"><?php echo e(isset($product['product_details']['product_name'])?$product['product_details']['product_name']:'N/A'); ?></div> 
                <div class="qty-prc qty-divspan">
                  <span class="qty-bld">Qty:</span> <span class="qty-bld"><?php echo e(isset($product['quantity'])?$product['quantity']:''); ?> </span> <br/>
                  <span>Unit Price : <?php echo e(isset($product['unit_price'])? num_format($product['unit_price'],2):''); ?> </span>

                </div>

               


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


      <?php if($product_arr['order_status']==0): ?>

        <div class="viewbuyr">
          <div class="gst-left">Order Status : &nbsp;&nbsp; </div>
          <div class="gst-right">   <div class="status-shipped">Cancelled</div>
          </div>
        </div>
     
        <br/>
        <div class="viewbuyr">
          <div class="gst-left">Cancellation Time : &nbsp;&nbsp; </div>
          <div class="gst-right">   <?php echo e(isset($product_arr['order_cancel_time'])?date("d M Y",strtotime($product_arr['order_cancel_time'])):''); ?>   |   <?php echo e(isset($product_arr['order_cancel_time'])?date("g:i a",strtotime($product_arr['order_cancel_time'])):''); ?>

          </div>
        </div>
        <br/>

        <div class="viewbuyr">
          <div class="gst-left">Cancellation Reason : &nbsp;&nbsp; </div>
          <div class="gst-right">   <?php echo e(isset($product_arr['order_cancel_reason'])?$product_arr['order_cancel_reason']:'N/A'); ?>

          </div>
        </div>
        <br/>

      <?php endif; ?>

    
      
      <div class="subtotl-min text-left-price">

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

          ?> 

           <?php if(isset($sellername) && isset($seller_discount_amt) && !empty($seller_discount_amt) && $seller_discount_amt>0): ?>

            <div class="gsttotal slrs-ttl-hitory">
                <div class="gst-right"><?php echo e(isset($seller_discount_amt)? '-$'.number_format($seller_discount_amt,2):'-'); ?></div>
             <div class="gst-left">Coupon : (<?php echo e($couponcode); ?>) (<?php echo e($discount); ?>) %: <br/> </div>
           
             <div class="clearfix"></div>
            </div>

          <?php endif; ?> 

          <div class="gsttotal slrs-ttl-hitory">
            <div class="gst-left">Shippping Charges : </div>
              <div class="gst-right">$<?php echo e(isset($shippingtotal)?num_format($shippingtotal,2):'00'); ?></div>
            
            
            <div class="clearfix"></div>
          </div>
        

          <?php
          // $day = date('l jS \, F Y', strtotime($product_arr['created_at']. ' + '.$product_arr['delivery_day'].' days'));

          $day = date('l, M. d Y', strtotime($product_arr['created_at']. ' + '.$product_arr['delivery_day'].' days'));
          ?>

          <?php if(isset($product_arr['delivery_option_id']) && $product_arr['delivery_option_id'] != '' && isset($sellername)): ?>

           

            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Delivery Option : </div>
              <div class="gst-right">
                <div class="titledeliverytxt">(<?php echo e(isset($product_arr['delivery_title'])? $product_arr['delivery_title']:'-'); ?>)  </div>
                <div class="date-calndr"><?php echo e(isset($day)? $day:'-'); ?>  </div>
              $<?php echo e(isset($product_arr['delivery_cost'])? number_format($product_arr['delivery_cost'],2):'-'); ?>

            </div>
             <div class="clearfix"></div>
            </div>

          <?php endif; ?>

         <div class="gsttotal slrs-ttl-hitory">
            <div class="gst-left">Transaction Amount : </div>
            <div class="gst-right">$<?php echo e(isset($final_amount)?num_format($final_amount):'-'); ?></div>
         
         
           <div class="clearfix"></div>
         </div>

      </div>

    

      <div class="button-subtotal">

      <?php if(isset($product_arr['buyer_age_restrictionflag']) && $product_arr['buyer_age_restrictionflag']==0): ?>
      

        <?php if($product_arr['refund_status']=="2" && $product_arr['order_status']=="0"): ?>

        <?php else: ?>
     
          <div class="ordr-tracking-div orderinpumaindiv" id="shipping_details">
            <div class="form-group">
                <label for="">Order Tracking # <span>*</span></label>
                <input type="text" name="tracking_no" id="tracking_no" class="input-text decimal" placeholder="Enter Order Tracking No." data-parsley-required ='true' value="<?php echo e(isset($product_arr['tracking_no'])?$product_arr['tracking_no']:'0'); ?>">
            </div>

             <div class="form-group">
                <label for="">Shipping Company Name<span>*</span></label>
                <input type="text" name="shipping_company_name" id="shipping_company_name" class="input-text decimal" placeholder="Enter shipping company name" data-parsley-required ='true' value="<?php echo e(isset($product_arr['shipping_company_name'])?$product_arr['shipping_company_name']:''); ?>">
            </div>


            <div class="button">
              <a href="javascript:void(0)" class="butn-def update-btns-slr" onclick="updateTracking()">Update</a>
            </div>
            
            <div class="note-view"><span>Note:</span> Please enter valid tracking number and shipping company name</div>

            <input type="hidden" name="seller_id" id="seller_id" value="<?php echo e(isset($product_arr['seller_id'])?$product_arr['seller_id']:'0'); ?>">

            <input type="hidden" name="order_id" id="order_id" value="<?php echo e(isset($product_arr['order_no'])?$product_arr['order_no']:'0'); ?>">
          </div>

        <?php endif; ?>  

      <?php endif; ?>  

  
        <div class="clearfix"></div>
         <div class="button-subtotal-right">
   
          <?php if($product_arr['buyer_age_restrictionflag'] == 0): ?>
            
           

            <!-------if order is ongoing then show payment status--------------->

            <?php if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2')): ?>

                 <?php if(isset($product_arr['payment_gateway_used']) && ($product_arr['payment_gateway_used']=='square')): ?>


                   <?php if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2')): ?>
                     <a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="<?php echo e(url('/')); ?>/seller/order/shipped/<?php echo e(base64_encode($product_arr['id'])); ?>" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="<?php echo e($product_arr['tracking_no']); ?>" data-shipping_company_name="<?php echo e($product_arr['shipping_company_name']); ?>" data-enc_id="<?php echo e(base64_encode($product_arr['id'])); ?>">Mark as Shipped</a>
                   <?php endif; ?>

                <?php elseif(isset($product_arr['payment_gateway_used']) && ($product_arr['payment_gateway_used']=='authorizenet') && isset($product_arr['authorize_transaction_status']) && $product_arr['authorize_transaction_status']=="settledSuccessfully"): ?>

                     <?php if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2')): ?>
                     <a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="<?php echo e(url('/')); ?>/seller/order/shipped/<?php echo e(base64_encode($product_arr['id'])); ?>" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="<?php echo e($product_arr['tracking_no']); ?>" data-shipping_company_name="<?php echo e($product_arr['shipping_company_name']); ?>" data-enc_id="<?php echo e(base64_encode($product_arr['id'])); ?>">Mark as Shipped</a>
                    <?php endif; ?>
                 <?php else: ?>
                     <a href="javascript:void(0)" class="btn btn-info" id="ship-order" title="Payment for this order is still being processed. You will receive a notification as soon as the payment is settled" onclick="payment_pending_status()">Payment Pending</a>
                
                 <?php endif; ?>   
             <?php endif; ?>     
             <!-------if order is ongoing then show payment status--end------>

          <?php endif; ?>



          <?php if(isset($product_arr['order_status']) && ($product_arr['order_status']=='3')): ?>
            <!----------commented delivered button for shipengine------------------->
            
          <?php endif; ?>
              
            
            <?php
              if(isset($product_arr['created_at']))
              {
               $order_date = date("Y-m-d",strtotime($product_arr['created_at']));
               $request_date = date('Y-m-d', strtotime($order_date. ' + 3 days'));
               $current_date =date("Y-m-d");

              // if($current_date<$request_date) {
              ?>
                <?php if(isset($product_arr['order_status']) && ($product_arr['order_status']=='2')): ?>

                  <a data-order_id="<?php echo e($product_arr['id']); ?>"  class="butn-def cancel_order_btn" id="btn_cancel_order">Cancel Order</a>   

                <?php endif; ?> 
              <?php
              // }
            }
            ?>
            <a href="javascript:history.go(-1);" class="butn-def cancelbtnss">Back</a>
        </div>

       <div class="clearfix"></div>
       
     </div>


     </div>
   </div>
      <br>
      <?php 
     //   dd($tracking_info);
      ?>
      <?php if(isset($tracking_info) && !empty($tracking_info)): ?>
      <div class="buyer-order-details"><span><b>Order Tracking Status : </b> </span>  

                <div class="location-nms">
                <span><b>Order Status Code: </b> </span>
                  <?php if(isset($tracking_info['carrier_status_code']) && (!empty($tracking_info['carrier_status_code']))): ?>
                     <?php echo e($tracking_info['carrier_status_code']); ?>

                  <?php else: ?>
                   - 
                  <?php endif; ?> 
                  </div>
                  <div class="location-nms">
                <span><b>Order Status: </b> </span>
                  <?php if(isset($tracking_info['status_description']) && (!empty($tracking_info['status_description']))): ?>
                     <?php echo e($tracking_info['status_description']); ?>

                  <?php else: ?>
                    -  
                  <?php endif; ?> 
                  </div>
                  <div class="location-nms">
                   <span><b>Shipped At : </b> </span>  
                  <?php if(isset($tracking_info['ship_date']) && (!empty($tracking_info['ship_date']))): ?>
                     <?php echo e(date('d M Y H:i:s A',strtotime($tracking_info['ship_date']))); ?>

                  <?php else: ?>
                    -   
                  <?php endif; ?>
                  </div>  
                  <div class="location-nms">
                   <span><b>Delivered Date : </b> </span>  
                  <?php if(isset($tracking_info['actual_delivery_date']) && (!empty($tracking_info['actual_delivery_date']))): ?>
                     <?php echo e(date('d M Y H:i:s A',strtotime($tracking_info['actual_delivery_date']))); ?>

                  <?php else: ?>
                    -   
                  <?php endif; ?>
                  </div>

                   <div class="location-nms">
                     <span><b>Expected Delivery Date : </b> </span>  
                    <?php if(isset($tracking_info['estimated_delivery_date']) && (!empty($tracking_info['estimated_delivery_date']))): ?>
                       <?php echo e(date('d M Y H:i:s A',strtotime($tracking_info['estimated_delivery_date']))); ?>

                    <?php else: ?>
                      -   
                    <?php endif; ?>
                  </div>  


        </div> 
      <?php endif; ?>
      <br>
      <?php if(isset($lable_info) && sizeof($lable_info)>0): ?> 
         <div class="buyer-order-details"><span><b>You can download the lable from following :</b> </span>  
                <div class="location-nms">
                  <?php if(isset($lable_info['label_download']) && (sizeof($lable_info['label_download'])>0)): ?>
                    <?php $__currentLoopData = $lable_info['label_download']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <a href="<?php echo e($label); ?>" target="blank"><?php echo e($label); ?></a><br/>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                  <?php else: ?>
                    -   
                  <?php endif; ?> 
                </div>
        </div>
      <?php endif; ?>  

</div>
</div>

<!--------------------start of modal-------------------------------------->
<div class="modal fade" id="cancel_order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="model_order_id" id="model_order_id" value="">
    <div class="modal-content">
      <div class="modal-header mdl-boder-btm">
        <h3 class="modal-title" id="exampleModalLabel" align="center">Cancel Order</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cancel_order_modal_body">
        <div class="mainbody-mdls">        
          

          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"> <b>Cancellation Reason :</b></div>
             <div class="mainbody-mdls-fd-right">
               <textarea id="model_order_cancel_reason" rows="5" class="form-control" placeholder="Please enter your order cancellation reason..." maxlength="300"></textarea>

               <div class="report-note">Note: Only 300 characters allowed.</div>  

               <span id="msg_err"></span>

             </div>
             <div class="clearfix"></div>
          </div>

        </div>
      
      </div>
      <div class="modal-footer">
        <div class="sre-product">
        
          <img src="<?php echo e(url('/')); ?>/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" />
          <a  class="butn-def" id="cancel_order_model_btn" onclick="cancelOrder($(this));">Confirm Cancellation</a>

        </div>
      </div>
    </div>
  </div>
</div>
<!-----------------end of modal---------------------->

<script>
// onclick="cancelOrder($(this));"
$(document).on('click','#btn_cancel_order',function(){
  $("#cancel_order_modal").modal('show'); 
  var order_id = $(this).attr('data-order_id');
  $('#model_order_id').val(order_id);
     
});


function payment_pending_status()
  {
      swal({
          title:'Payment Processing',
          text: 'Payment for this order is still being processed. You will receive a notification as soon as the payment is settled',
         // type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            //window.location.reload();             
          }           
       });

      return false;
  }


</script>




<script>


 function cancelOrder(ref)
{
  if($('#model_order_cancel_reason').val()=='')
  {
    $('<span>Please enter the cancellation reason.. </span>').css('color','red').insertAfter('#model_order_cancel_reason').fadeOut(5000);
    return false;
  }
  swal({
    title: 'Do you really want to cancel this order?',
    type: "warning",
    showCancelButton: true,
    // confirmButtonColor: "#DD6B55",
    confirmButtonColor: "#8d62d5",
    confirmButtonText: "Yes, do it!",
    closeOnConfirm: false
  },
  function(isConfirm,tmp)
  {    
    if(isConfirm==true)
    {
      var order_id   = $('#model_order_id').val();
      var order_cancel_reason =  $('#model_order_cancel_reason').val();
      var csrf_token = "<?php echo e(csrf_token()); ?>";

      var logged_in_user  = "<?php echo e(Sentinel::check()); ?>";


      if(logged_in_user)
      {

        $.ajax({
          url: SITE_URL+'/seller/order/cancel',
          type:"POST",
          data: {order_id:order_id,order_cancel_reason:order_cancel_reason,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){     
          showProcessingOverlay();
            $('#btn_cancel_order').prop('disabled',true);
            $('#btn_cancel_order').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');       
          },
          success:function(response)
          {
            hideProcessingOverlay();
            $('#btn_cancel_order').prop('disabled',false);
            $('#btn_cancel_order').html('Cancel Order');

            if(response.status == 'SUCCESS')
            { 
              swal({
                      title: 'Success',
                      text: response.description,
                      type: 'success',
                      confirmButtonText: "OK",
                      closeOnConfirm: true
                  },
                  function(isConfirm,tmp)
                  {                       
                    if(isConfirm==true)
                    {
                      window.location.reload();
                      $(this).addClass('active');

                    }

                  });
            }
            else
            {                
              swal('Error',response.description,'error');
            }  
          }  

        }); 

      }
    }
  })
}

  function confirm_order_status(ref)
  {
    var tracking_no           = $(ref).data('tracking_no');
    var shipping_company_name = $(ref).data('shipping_company_name');
    var enc_id                = $(ref).data('enc_id');

    if(tracking_no == '' && shipping_company_name == '')
    {
      swal({
          title:'Alert!',
          text: 'Please add tracking # & shipping company name first!',
         // type: "warning",
          // showCancelButton: true,
          confirmButtonColor: "#8d62d5",
          // confirmButtonText: "Go to order detail page",
          closeOnConfirm: true
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            // window.location = module_url_path+'/view/'+enc_id+'#shipping_details';             
          }           
       });

      return false;
    }
    else
    { 
        var actionname = $(ref).data('id');
        var actionlink = $(ref).data('href');

        var msgtitle = 'Do you really want to '+actionname+' this order?';
        if(actionname=="ship"){
          var msgtitle = "Ship Now?";
             swal({
            //  title: 'Do you really want to '+actionname+' this order?',
              title: msgtitle,
              type: "warning",
              showCancelButton: true,
            //   confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: false
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                //showProcessingOverlay();
                window.location= actionlink;
                 
              }           
           });


        }
        else if(actionname=="deliver")
        {
          var msgtitle ='Has this item been delivered?';
           window.location= actionlink;
        }
        else{
          var msgtitle ='Do you really want to '+actionname+' this order?';
             swal({
            //  title: 'Do you really want to '+actionname+' this order?',
              title: msgtitle,
              type: "warning",
              showCancelButton: true,
            //   confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: false
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                //showProcessingOverlay();
                window.location= actionlink;
                 
              }           
           });


        }//else
    
       
    }

  }

</script>
<script>
 
 /* function showFunction(diva, divb) {
      var x = document.getElementById(diva);
      var y = document.getElementById(divb);
          x.style.display = 'block';
          y.style.display = 'none';
    }
 */

  function updateTracking() 
  {
    var tracking_no = $('#tracking_no').val();
    var seller_id = $('#seller_id').val();
    var order_id = $('#order_id').val();
    var shipping_company_name = $("#shipping_company_name").val();

    if(tracking_no == '')
    {
       $('#tracking_no').after('<div class="red">Please enter tracking no.</div>');
        return false;
    }
     if(shipping_company_name == '')
    {
       $('#shipping_company_name').after('<div class="red">Please enter shipping company name</div>');
        return false;
    }

    $.ajax({
          url: SITE_URL+'/seller/order/updateTracking',
          type:'POST',         
          data: {tracking_no:tracking_no,shipping_company_name:shipping_company_name,seller_id:seller_id, order_id:order_id,
                      _token: '<?php echo e(csrf_token()); ?>'},         
          dataType:'json',
        beforeSend : function()
        { 
          showProcessingOverlay();        
        },
        success:function(data){
          hideProcessingOverlay();
          // console.log(response);
          if(data.status == 'success')
          {
            swal({
                   title: 'Success',
                   text: data.description,
                   type: data.status,
                   confirmButtonText: "OK",
                   closeOnConfirm: false
                },
               function(isConfirm,tmp)
               {
                 if(isConfirm==true)
                 {
                    window.location.reload();
                    // window.location.href=SITE_URL+'/seller/order/ongoing';

                 }
               });
          }
          else{
              // swal('warning',data.description,data.status);
               swal('Alert!',data.description); 
            } 
        }
    })
  }

  $(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 100;  // How many characters are shown by default
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>