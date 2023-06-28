<?php $__env->startSection('main_content'); ?>

<style>
  .subtotl-min .gsttotal.slrs-ttl-hitory {
    font-size: 20px;
}

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
.ordernoteclass{
  color:#873dc8;
}
</style>
<div class="my-profile-pgnm">
  <?php echo e(isset($page_title)?$page_title:''); ?>

   <ul class="breadcrumbs-my">
   <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
   <li><i class="fa fa-angle-right"></i></li>
    <li><a href="<?php echo e(url('/')); ?>/buyer/order">Order</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Order Detail</li>
  </ul>
</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">
  <div class="order-main-dvs paddingnone-view">
    <div class="buyer-order-details">
      <div class="order-id-main">
      
        <div class="order-id-main-left">
          <div class="ordr-id-nm"><?php echo e(isset($order_details_arr[0]['order_no'])?$order_details_arr[0]['order_no']:''); ?></div>
          <div class="location-nms">

                <?php

                   //dd($order_details_arr[0]['note']);

                  $address = isset($order_details_arr[0]['address_details']['shipping_address1'])?$order_details_arr[0]['address_details']['shipping_address1']:'';

                  $state = isset($order_details_arr[0]['address_details']['state_details']['name'])?$order_details_arr[0]['address_details']['state_details']['name']:'';

                  $country = isset($order_details_arr[0]['address_details']['country_details']['name'])?$order_details_arr[0]['address_details']['country_details']['name']:'';

                  $zipcode = isset($order_details_arr[0]['address_details']['shipping_zipcode'])?$order_details_arr[0]['address_details']['shipping_zipcode']:'';

                  $city = isset($order_details_arr[0]['address_details']['shipping_city'])?$order_details_arr[0]['address_details']['shipping_city']:'';


                  $billing_address = isset($order_details_arr[0]['address_details']['billing_address1'])?$order_details_arr[0]['address_details']['billing_address1']:'';

                  $billing_state = isset($order_details_arr[0]['address_details']['billing_state_details']['name'])?$order_details_arr[0]['address_details']['billing_state_details']['name']:'';

                  $billing_country = isset($order_details_arr[0]['address_details']['billing_country_details']['name'])?$order_details_arr[0]['address_details']['billing_country_details']['name']:'';

                  $billing_zipcode = isset($order_details_arr[0]['address_details']['billing_zipcode'])?$order_details_arr[0]['address_details']['billing_zipcode']:'';

                  $billing_city = isset($order_details_arr[0]['address_details']['billing_city'])?$order_details_arr[0]['address_details']['billing_city']:'';

    
                ?>

            <?php if(isset($address) && $address!=""): ?>
                <span>Shipping Address: </span><!-- <i class="fa fa-map-marker"></i> -->
                <?php echo e(isset($order_details_arr[0]['address_details']['shipping_address1'])?$order_details_arr[0]['address_details']['shipping_address1'].', ':''); ?>


                  <?php if(isset($order_details_arr[0]['address_details']['shipping_city']) && (!empty($order_details_arr[0]['address_details']['shipping_city']))): ?>

                  <?php echo e($order_details_arr[0]['address_details']['shipping_city'].', '); ?>

                  <?php endif; ?>


                 <?php if(isset($order_details_arr[0]['address_details']['state_details']['name']) && (!empty($order_details_arr[0]['address_details']['state_details']['name']))): ?>

                 <?php echo e($order_details_arr[0]['address_details']['state_details']['name'].', '); ?>

                 <?php endif; ?>

                
                 <?php if(isset($order_details_arr[0]['address_details']['country_details']['name']) && (!empty($order_details_arr[0]['address_details']['country_details']['name'])) ): ?>
                 <?php echo e($order_details_arr[0]['address_details']['country_details']['name']); ?>

                 <?php endif; ?>

                <?php if(isset($order_details_arr[0]['address_details']['shipping_zipcode']) && (!empty($order_details_arr[0]['address_details']['shipping_zipcode']))): ?>

                    - <?php echo e($order_details_arr[0]['address_details']['shipping_zipcode']); ?>


                <?php endif; ?>
                

            <?php endif; ?>
          </div>
          <div class="location-nms">
            <?php if(isset($billing_address) && $billing_address!=""): ?>
                <span>Billing Address: </span><!-- <i class="fa fa-map-marker"></i> -->

                    <?php if(isset($order_details_arr[0]['address_details']['billing_address1']) && (!empty($order_details_arr[0]['address_details']['billing_address1']))): ?>
                        <?php echo e($order_details_arr[0]['address_details']['billing_address1'].', '); ?>

                    <?php endif; ?>

                    <?php if(isset($order_details_arr[0]['address_details']['billing_city']) && (!empty($order_details_arr[0]['address_details']['billing_city'])) ): ?>
                      <?php echo e($order_details_arr[0]['address_details']['billing_city'].', '); ?>

                    <?php endif; ?>

                    <?php if(isset($order_details_arr[0]['address_details']['billing_state_details']['name']) && (!empty($order_details_arr[0]['address_details']['billing_state_details']['name'])) ): ?>
                      <?php echo e($order_details_arr[0]['address_details']['billing_state_details']['name'].', '); ?>

                    <?php endif; ?>

                    <?php if(isset($order_details_arr[0]['address_details']['billing_country_details']['name']) && (!empty($order_details_arr[0]['address_details']['billing_country_details']['name'])) ): ?>
                      <?php echo e($order_details_arr[0]['address_details']['billing_country_details']['name']); ?>

                    <?php endif; ?>

                    <?php if(isset($order_details_arr[0]['address_details']['billing_zipcode']) && (!empty($order_details_arr[0]['address_details']['billing_zipcode']))): ?>
                      - <?php echo e($order_details_arr[0]['address_details']['billing_zipcode']); ?>

                    <?php endif; ?>
                    
            <?php endif; ?>

          </div>



          <div class="ordertimedate"><?php echo e(isset($order_details_arr[0]['created_at'])?date("d M Y",strtotime($order_details_arr[0]['created_at'])):''); ?>   |   <?php echo e(isset($order_details_arr[0]['created_at'])?date("g:i A",strtotime($order_details_arr[0]['created_at'])):''); ?>

          </div>
          <?php if(isset($order_details_arr[0]['note']) && $order_details_arr[0]['note'] != ''): ?> 
            <div class="location-nms">
              <span class="ordernoteclass">Order Note:- </span>
              
                  <span class="ordernoteclass"><?php echo e($order_details_arr[0]['note']); ?></span>
            </div>
          <?php endif; ?>

          <?php if(isset($order_details_arr[0]['buyer_age_restrictionflag']) && $order_details_arr[0]['buyer_age_restrictionflag']==1): ?>
          

            <a href="javascript:void(0);" class="age-verificationbtns"> This order is pending user age-verification</a>

          <?php endif; ?>

        </div>
        <div class="order-id-main-right">
          <?php
            $order_status = ""; $status_class="";
            if(isset($order_details_arr[0]['order_status']))
            {
              if($order_details_arr[0]['order_status']==0)
              {

                $order_status = "Cancelled";  $status_class  = "status-shipped";
              }
              elseif($order_details_arr[0]['order_status']==1)
              {

                $order_status = "Delivered";$status_class  = "status-completed";
              }
              elseif($order_details_arr[0]['order_status']==2)
              {

                  if(isset($order_details_arr[0]['buyer_age_restrictionflag']) && $order_details_arr[0]['buyer_age_restrictionflag']==1)
                  {
                     $order_status = "Pending Age Verification";
                  }
                  else 
                  {
                     $order_status = "Ongoing";
                  }

                
                 $status_class  = "status-dispatched";
              }
              elseif($order_details_arr[0]['order_status']==3)
              {
                $order_status = "Shipped";$status_class  = "status-dispatched";
              }
               elseif($order_details_arr[0]['order_status']==4)
              {
                $order_status = "Ongoing";$status_class  = "status-dispatched";
              }
            }

            $refundstatus= $refund_class = '';
            $refundstyle = 'display:none';

            if(isset($order_details_arr[0]['order_status']) && $order_details_arr[0]['order_status']==0)
            {
               if(isset($order_details_arr[0]['refund_status']) && $order_details_arr[0]['refund_status']==1)
               {
                 $refund_class  = "status-dispatched";
                 $refundstatus = " In progress";
                 $refundstyle ='display:inline-block';
               }else if(isset($order_details_arr[0]['refund_status']) && $order_details_arr[0]['refund_status']==2){
                  $refund_class="status-completed";
                  $refundstatus = " Amount Refunded";
                   $refundstyle ='display:inline-block';
               }else if(isset($order_details_arr[0]['refund_status']) && $order_details_arr[0]['refund_status']==0){
                  $refund_class="";
                  $refundstatus = "";
                  $refundstyle ='display:none';
               }

            }  
 
          ?>
          <div class="<?php echo e($status_class); ?>"><?php echo e($order_status); ?></div>
          <div class="<?php echo e($refund_class); ?>" style="<?php echo e($refundstyle); ?>">Refund Status : <?php echo e($refundstatus); ?></div>
          <div class="price-order-my">
            

              <?php if(isset($order_details_arr) && sizeof($order_details_arr)): ?>
               <?php
                $get_sumtotal_amount =0;
               ?>
                <?php $__currentLoopData = $order_details_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <?php
                /*******************************************/
                  $get_sumtotal_amount =  $get_sumtotal_amount+$product_list['total_amount'];
                /******************************************/
                ?> 
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
               



          </div>
        </div>
        <div class="clearfix"></div>
       
      </div>

      <div class="ordered-products-mns">
        <div class="ordered-products-titles">Ordered Products </div> 

        <?php if(isset($order_details_arr) && sizeof($order_details_arr)): ?>
           <?php
            $get_total_amount =0;
            $shippingtotal =0; 
           // dd($order_details_arr);
           ?>
          <?php $__currentLoopData = $order_details_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <?php
                /*******************************************/
                  $get_total_amount =  $get_total_amount+$product_list['total_amount'];
                
                /******************************************/
                ?> 
            
            <?php $__currentLoopData = $product_list['order_product_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_details_arr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $price = 0;
                $shippingtotal =  $shippingtotal+$product_details_arr['shipping_charges'];
                  // dump($$product_details_arr['shipping_charges']);

                if(isset($product_details_arr['quantity']))
                if($product_details_arr['quantity']==1){

                  $price = $product_details_arr['unit_price'];
                }
                
                else{

                  $price = $product_details_arr['unit_price']*$product_details_arr['quantity']; 
                }   
 
               
               // dd($product_details_arr);

              ?>  
              <div class="list-order-list">


               

                 <?php if(isset($product_details_arr['age_restriction']) && $product_details_arr['age_restriction']!=""): ?>
                  <div class="age-limited">
                      
                        <?php echo e(isset($product_details_arr['age_restriction_detail']['age'])?$product_details_arr['age_restriction_detail']['age']:''); ?>

                  </div>
                <?php endif; ?>

                <div class="pricetbsls">$<?php echo e(number_format($price,2)); ?></div>
                <div class="list-order-list-left">

                  <?php if(isset($product_details_arr['product_details']['product_images_details'][0]['image']) && $product_details_arr['product_details']['product_images_details'][0]['image']!='' && file_exists(base_path().'/uploads/product_images/'.$product_details_arr['product_details']['product_images_details'][0]['image'])): ?> 

                    <img src="<?php echo e($product_img_path.$product_details_arr['product_details']['product_images_details'][0]['image']); ?>" alt="<?php echo e(isset($product_details_arr['product_details']['product_name'])?$product_details_arr['product_details']['product_name']:''); ?>">

                  <?php else: ?>
                    <img src="<?php echo e(url('/')); ?>/assets/images/default-product-image.png" alt="<?php echo e(isset($product_details_arr['product_details']['product_name'])?$product_details_arr['product_details']['product_name']:''); ?>">
                  <?php endif; ?> 
                </div>
                <div class="list-order-list-right">
                  <div class="humidifier-title"><?php echo e(isset($product_details_arr['product_details']['product_name'])?$product_details_arr['product_details']['product_name']:''); ?></div> 
                  <div class="qty-bld"> Qty: <?php echo e(isset($product_details_arr['quantity'])?$product_details_arr['quantity']:''); ?></div>

                   <div class="qty-prc"> Unit Price: <?php echo e(isset($product_details_arr['unit_price'])?num_format($product_details_arr['unit_price'],2):''); ?></div>



                  <div class="qty-prc"> Sold By:
                        <?php
                          // if(isset($order_details_arr[0]['seller_details']['first_name']))
                          //   $firstname = $order_details_arr[0]['seller_details']['first_name'];
                          // else
                          //   $firstname ='';

                          //  if(isset($order_details_arr[0]['seller_details']['last_name']))
                          //   $lastname = $order_details_arr[0]['seller_details']['last_name'];
                          // else 
                          //   $lastname ='';

                        $bunessname='';
                        if(isset($order_details_arr[0]['seller_details']['seller_detail']
                          ['business_name']) && !empty($order_details_arr[0]['seller_details']['seller_detail']['business_name'])){
                           $bunessname = $order_details_arr[0]['seller_details']['seller_detail']['business_name'];
                          }                         
                         else{
                           $bunessname = '';
                         }
                         
                        ?>
                         <?php echo e($bunessname); ?>  
                       
                  </div>

                  


<!--------start-product description------------------->
                 <div class="content"> 
                    <div class="hidecontent" id="hidecontent_<?php echo e($product_details_arr['product_details']['id']); ?>">
                      <?php if(strlen($product_details_arr['product_details']['description'])>50): ?>
                       <?php echo substr($product_details_arr['product_details']['description'],0,50) ?>
                      <span class="show-more" style="color: red;cursor: pointer;" onclick="return showmore(<?php echo e($product_details_arr['product_details']['id']); ?>)">Show more</span>
                      <?php else: ?>
                         <?php echo $product_details_arr['product_details']['description'] ?>
                      <?php endif; ?>
                    </div>
                       <span class="show-more-content" style="display: none" id="show-more-content_<?php echo e($product_details_arr['product_details']['id']); ?>">
                        <?php echo $product_details_arr['product_details']['description'] ?>
                        <span class="show-less" style="color:red;cursor: pointer;" onclick="return showless(<?php echo e($product_details_arr['product_details']['id']); ?>)"  id="show-less_<?php echo e($product_details_arr['product_details']['id']); ?>">Show less</span>
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
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>   


  
    <?php if($order_details_arr[0]['order_status']==0): ?>
    <div class="viewbuyr">
      <div class="gst-left">Cancellation Time : &nbsp;&nbsp; </div>
      <div class="gst-right">   <?php echo e(isset($order_details_arr[0]['order_cancel_time'])?date("d M Y",strtotime($order_details_arr[0]['order_cancel_time'])):''); ?>   |   <?php echo e(isset($order_details_arr[0]['order_cancel_time'])?date("g:i a",strtotime($order_details_arr[0]['order_cancel_time'])):''); ?>

      </div>
    </div>
    <br/>

    <div class="viewbuyr">
      <div class="gst-left">Cancellation Reason : &nbsp;&nbsp; </div>
      <div class="gst-right">   <?php echo e(isset($order_details_arr[0]['order_cancel_reason'])?$order_details_arr[0]['order_cancel_reason']:'N/A'); ?>

      </div>
    </div>
    <br/>

    <?php endif; ?>


   <?php if(isset($order_details_arr[0]['order_status']) && $order_details_arr[0]['order_status']!=2): ?>
    <div class="viewbuyr">
      <div class="gst-left">Tracking # : &nbsp;&nbsp; </div>
      <div class="gst-right">   <?php echo e(isset($order_details_arr[0]['tracking_no'])?$order_details_arr[0]['tracking_no']:'N/A'); ?>

      </div>
    </div>
    <br/>
    <div class="viewbuyr">
      <div class="gst-left">Shipping Company Name : &nbsp;&nbsp; </div>
      <div class="gst-right">  
        <?php 
          if($order_details_arr[0]['shipping_company_name'])
            $shipping_comapnyname = $order_details_arr[0]['shipping_company_name'];
          else
            $shipping_comapnyname = 'NA';
        ?>
       <?php echo e($shipping_comapnyname); ?>

      </div>
    </div>
   <?php endif; ?>  




  <br/>

      <div class="subtotl-min text-left-price">

            <?php 
              $couponcode = isset($order_details_arr[0]['couponcode'])?$order_details_arr[0]['couponcode']:'';
              $discount = isset($order_details_arr[0]['discount'])?$order_details_arr[0]['discount']:'';
              $seller_discount_amt = isset($order_details_arr[0]['seller_discount_amt'])?$order_details_arr[0]['seller_discount_amt']:'';

              $tax = isset($order_details_arr[0]['tax'])?$order_details_arr[0]['tax']:0;

              $sellername = get_seller_details($order_details_arr[0]['seller_id']);

              $get_total_amount = (float)$get_total_amount - (float)$seller_discount_amt;

              foreach ($order_details_arr as $key => $order_details) {

                $get_total_amount = (float)$get_total_amount + (float)$order_details['delivery_cost'];
              }

              if(isset($tax))
              {
                  $get_total_amount = (float)$get_total_amount + (float)$tax;

              }
            ?>

            <?php if(isset($sellername) && !empty($sellername) && isset($seller_discount_amt) && !empty($seller_discount_amt) && !empty($seller_discount_amt) && $seller_discount_amt>0): ?>
            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">
               Coupon : (<?php echo e($couponcode); ?>) (<?php echo e($discount); ?>) %: <br/>
              
              </div>
              <div class="gst-right"><?php echo e(isset($seller_discount_amt)? '-$'.number_format($seller_discount_amt,2):'-'); ?>


              </div>
             <div class="clearfix"></div>
            </div>
            <?php endif; ?>


            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Shipping Charges : </div>
              <div class="gst-right">$<?php echo e(isset($shippingtotal)? number_format($shippingtotal,2):'-'); ?>


              </div>
            </div>

            <?php if(isset($order_details_arr[0]['delivery_cost']) && $order_details_arr[0]['delivery_cost'] != '' ): ?>
            <?php
              $bunessname='';

              if(isset($order_details_arr[0]['seller_details']['seller_detail'] ['business_name']) && !empty($order_details_arr[0]['seller_details']['seller_detail']['business_name'])){
                 $bunessname = $order_details_arr[0]['seller_details']['seller_detail']['business_name'];
              }                         
              else {
                $bunessname = '';
              }

              // $day = date('l jS \, F Y', strtotime($order_details_arr[0]['created_at']. ' + '.$order_details_arr[0]['delivery_day'].' days'));
               $day = date('l, M. d Y', strtotime($order_details_arr[0]['created_at']. ' + '.$order_details_arr[0]['delivery_day'].' days'));
            ?>

            

            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Delivery Option : </div>
              <div class="gst-right">
                 <div class="titledeliverytxt" > <?php echo e(isset($order_details_arr[0]['delivery_title'])? $order_details_arr[0]['delivery_title']:'-'); ?> </div>
                  <div class="date-calndr"> <?php echo e(isset($day)? $day:'-'); ?>  </div>
                  $<?php echo e(isset($order_details_arr[0]['delivery_cost'])? number_format($order_details_arr[0]['delivery_cost'],2):'-'); ?>


              </div>              
            </div>            
            <?php endif; ?>

            <?php 
              $get_wallet_amountused_fororder =0;
              $get_wallet_amountused_fororder = get_wallet_amountused_fororder($order_details_arr[0]['buyer_id'],$order_details_arr[0]['order_no']);
            ?>
             <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Wallet Amount Used : </div>
              <div class="gst-right">$<?php echo e(isset($get_wallet_amountused_fororder)? num_format($get_wallet_amountused_fororder):''); ?>


              </div>
              <div class="clearfix"></div>
            </div> 

            



             <?php if(isset($order_details_arr[0]['tax']) && $order_details_arr[0]['tax'] != '' ): ?>
             <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Tax : </div>
              <div class="gst-right">
                 <div class="titledeliverytxt" >  </div>
                
                  $<?php echo e(isset($order_details_arr[0]['tax'])? number_format($order_details_arr[0]['tax'],2):'-'); ?>

              </div>              
              </div>            
              <?php endif; ?>





            <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Total Order Amount : </div>
              <div class="gst-right">$<?php echo e(isset($get_total_amount)? number_format($get_total_amount,2):''); ?>


              </div>
              <div class="clearfix"></div>
            </div>

            <?php 
              $get_cashback_data = get_cashback_data($order_details_arr[0]['order_no']);
            ?>

            <?php 
              $cashback_status = '';
              $getcashback_status = get_user_wallet_cashback($order_details_arr[0]['order_no'],$order_details_arr[0]['buyer_id']);
               if(isset($getcashback_status) && !empty($getcashback_status) && $getcashback_status=='Cancel Cashback')
                {
                              
                      $cashback_status = '<div class="status-completed get-cashback">Cashback Credited</div>';
            
                }//
                else if(isset($getcashback_status) && !empty($getcashback_status) && $getcashback_status=='Cashback Cancelled')
                {
        
                      $cashback_status = '<div class="status-shipped get-cashback">'.$getcashback_status.'</div>';
            
                }

           ?>

            <?php if(isset($get_cashback_data) && !empty($get_cashback_data)): ?>
             <div class="gsttotal slrs-ttl-hitory">
              <div class="gst-left">Cashback Amount : </div>
              <div class="gst-right">$<?php echo e(isset($get_cashback_data['cashback'])? number_format($get_cashback_data['cashback'],2):''); ?>


              </div>
              <?php echo $cashback_status ?>
              <div class="clearfix"></div>
            </div>
           <?php endif; ?> 

           

           
            


      </div>
       
      </div>
       <div class="button-subtotal">
          
          <div class="button-subtotal-left">
      
            
          </div>
          <div class="button-subtotal-right backbtnright">     

            <?php

              if(isset($order_details_arr[0]['created_at']))
              {
               $order_date = date("Y-m-d",strtotime($order_details_arr[0]['created_at']));
               $request_date = date('Y-m-d', strtotime($order_date. ' + 3 days'));
               $current_date =date("Y-m-d");

              // if($current_date<$request_date) {
              ?>

               <?php if(isset($order_details_arr[0]['buyer_age_restrictionflag']) && $order_details_arr[0]['buyer_age_restrictionflag']==1): ?>
               <?php else: ?> 
                    <?php if(isset($order_details_arr[0]['order_status']) && $order_details_arr[0]['order_status']=='2'): ?>
                      <a data-order_id="<?php echo e($order_details_arr[0]['id']); ?>"  class="butn-def cancel_order_btn" id="btn_cancel_order">Cancel Order</a>            
                    <?php endif; ?> 
               <?php endif; ?>


              <?php
              // }
            }
            ?>

            <a href="javascript:window.history.go(-1)" class="butn-def cancelbtnss">Back</a>
            
          </div>          
          <div class="clearfix"></div>
        </div>
    </div>

    <br>
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
   
      <?php if(isset($lable_info) && !empty($lable_info)): ?> 
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
          url: SITE_URL+'/buyer/order/cancel',
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
<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>