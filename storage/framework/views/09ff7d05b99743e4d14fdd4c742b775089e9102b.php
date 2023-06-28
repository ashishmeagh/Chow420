                
<?php $__env->startSection('main_content'); ?>
<style>
th.bgnm-change {
    background-color: #fff;
}
</style>
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">

        <?php
          $user = Sentinel::check();
        ?>

        <?php if(isset($user) && $user->inRole('admin')): ?>
          <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
        <?php endif; ?>
         
         <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/transaction')); ?>">Transactions</a></li>
         <li class="active"><?php echo e(isset($page_title) ? $page_title : ''); ?></li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>

<?php 
 //dd($arr_transaction_detail);
?>



<!-- .row -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box">
         <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <div class="row">
            <div class="col-sm-12 col-xs-12">
                 <h3>
                    <span 
                       class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action" >
                    </span>
                 </h3>
            </div>
          </div>

                <?php if(!empty($arr_transaction_detail)): ?>
                  <div class="row-class bottom-space-margn">
                     <div class="row">
                       <?php if(!empty($arr_transaction_detail[0]['order_no'])): ?>
                        <div class="col-md-6">
                          <div class="h-four-class">
                        <h4>Order No : <span><?php echo e(isset($arr_transaction_detail[0]['order_no'])?$arr_transaction_detail[0]['order_no']:''); ?> </span></h4>
                          </div>
                        </div>
                        <?php endif; ?>

                         <?php if(!empty($arr_transaction_detail[0]['transaction_status'])): ?>
                        <div class="col-md-6">  
                                
                                <?php
                                  if($arr_transaction_detail[0]['transaction_status']=="0")
                                    $status = "<label class='label label-warning'>Pending</label>";
                                  else if($arr_transaction_detail[0]['transaction_status']=="1")
                                    $status = "<label class='label label-success'>Success</label>";
                                  else if($arr_transaction_detail[0]['transaction_status']=="2")
                                    $status = "<label class='label label-danger'>Failed</label>";
                                ?>
                                                           
                        <h4>Transaction Status : <?php echo $status; ?></h4>
                        </div>
                        <?php endif; ?>


                        <?php if(!empty($arr_transaction_detail[0]['buyer_details']) && count($arr_transaction_detail[0]['buyer_details'])>0): ?>
                           <div class="col-md-6">
                            <div class="h-four-class">
                             <h4>Buyer : <span><?php echo e($arr_transaction_detail[0]['buyer_details']['first_name'].' '.$arr_transaction_detail[0]['buyer_details']['last_name']); ?></span></h4> 
                             </div>
                          </div>
                        <?php endif; ?> 
                    </div>
                  </div>
                <?php endif; ?>
                                       

                      <?php if(!empty($arr_transaction_detail[0]['order_details']) && count($arr_transaction_detail[0]['order_details'])>0): ?>

 
                       <div class="table-responsive">           
                           <table class="table table-striped table-bordered">
                            <tr>
                              <th colspan="4" class="bgnm-change"><h3>Shipping Details:</h3></th>
                            </tr>
                            <tr>
                           
                            
                         
                            
                            <th><b>Email</b></th>
                            <td>
                                <?php if(isset($arr_transaction_detail[0]['buyer_details']['email']) && $arr_transaction_detail[0]['buyer_details']['email']!=""): ?>
                                <?php echo e($arr_transaction_detail[0]['buyer_details']['email']); ?>

                                <?php else: ?>
                                 NA
                                <?php endif; ?>
                            </td>
                          </tr>
                          <tr>
                             <th><b>Address</b></th>
                            <td colspan="3">
                                 <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_address1']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_address1']!=""): ?>
                                <?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_address1']); ?> 
                                <?php endif; ?>

                                <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_city']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_city']!=""): ?>
                                 ,<?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_city']); ?>

                                <?php endif; ?>

                                <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingstatedetail']['name']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingstatedetail']['name']!=""): ?>
                                 ,<?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingstatedetail']['name']); ?>

                                <?php endif; ?>


                                <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingcountrydetail']['name']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingcountrydetail']['name']!=""): ?>
                                 ,<?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingcountrydetail']['name']); ?>

                                <?php endif; ?>
                              

                                <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_zipcode']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_zipcode']!=""): ?>
                                 ,<?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_zipcode']); ?>

                                <?php endif; ?>

                           
                           </td>
                          </tr>
                         
                          
                           <tr>
                              <th colspan="4"><h3>Billing Details:</h3></th>
                            </tr>
                            
                           <tr>
                            
                            <th><b>Email</b></th>
                            <td>
                                <?php if(isset($arr_transaction_detail[0]['buyer_details']['email']) && $arr_transaction_detail[0]['buyer_details']['email']!=""): ?>
                                <?php echo e($arr_transaction_detail[0]['buyer_details']['email']); ?>

                                <?php else: ?>
                                NA
                                <?php endif; ?>
                            </td>
                          </tr>
                           <tr>
                            <th><b>Address</b></th>
                            <td colspan="3">
                                 <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_address1']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_address1']!=""): ?>
                                   <?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_address1']); ?> 
                                <?php endif; ?>

                                <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_city']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_city']!="" ): ?>
                                 ,<?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_city']); ?>

                                <?php endif; ?> 

                                <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingstatedetail']['name']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingstatedetail']['name']!=""): ?>
                                 ,<?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingstatedetail']['name']); ?>

                                <?php endif; ?> 

                                <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingcountrydetail']['name']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingcountrydetail']['name']!=""): ?>
                                 ,<?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingcountrydetail']['name']); ?>

                                <?php endif; ?> 

                                <?php if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_zipcode']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_zipcode']!=""): ?>
                                 ,<?php echo e($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_zipcode']); ?>

                                <?php endif; ?> 

                             
                           </td>
                          </tr>
                         

                           </table>
                       </div>
                     <?php endif; ?> 

                      <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                               <th>Product Name</th>
                               <th>Dispensary Name</th>                             
                               <th>Quantity</th>
                               <th>Unit Price($)</th>
                               <th>Shipping Charges($)</th>
                               <th>Total Amount($)</th>
                            </tr>
                          </thead>
                      

                      <tbody> 

                      <?php if(!empty($arr_transaction_detail[0]['order_details']) && count($arr_transaction_detail[0]['order_details'])>0): ?>

                           <?php $late ='';  $shippingcharges =0; ?>

                           <?php $__currentLoopData = $arr_transaction_detail[0]['order_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                              <?php
                                $couponcode = isset($order_detail['couponcode'])?$order_detail['couponcode']:'';
                                $discount = isset($order_detail['discount'])?$order_detail['discount']:'';
                                $seller_discount_amt = isset($order_detail['seller_discount_amt'])?$order_detail['seller_discount_amt']:'';
                                $sellername = get_seller_details($order_detail['seller_id']);
                              ?>

  
                              <?php $__currentLoopData = $order_detail['order_product_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order_product_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

                                <?php
                                      $order_status= $order_detail['order_status'];
                                      $createdatdate= $order_detail['created_at'];
                                      $orderdate =  date ( 'Y-m-d' , strtotime ( 
                                      $order_detail['created_at'] . ' + 7 days' ));
                                      $currentdate = date('Y-m-d');

                                     if($currentdate>$orderdate && $order_detail['order_status']=="2")
                                     {
                                      $late = '<span class="status-shipped">Late</span>';
                                     }
                                     else
                                     {
                                      $late ='';
                                     }
                                ?>



                                  <tr>
                                      <td><?php echo e(isset($order_product_detail['product_details']['product_name'])?$order_product_detail['product_details']['product_name']:''); ?></td>
                                      <td>
                                         

                                         <?php echo e(isset($order_detail['seller_details']['seller_detail']['business_name'])?$order_detail['seller_details']['seller_detail']['business_name']:$order_detail['seller_details']['first_name']); ?>


                                          <?php echo $late; ?>
                                       </td>
                                      <td><?php echo e($order_product_detail['quantity']); ?></td>                            
                                      <td> <?php if(isset($order_product_detail['unit_price'])): ?> $<?php echo e(num_format($order_product_detail['unit_price'])); ?> <?php endif; ?></td>

                                      <td> <?php if(isset($order_product_detail['shipping_charges'])): ?> $<?php echo e(num_format($order_product_detail['shipping_charges'])); ?> <?php endif; ?></td>
                                       <td> 

                                          <?php 
                                            $shippingcharges =0;
                                            if(isset($order_product_detail['shipping_charges']) && !empty($order_product_detail['shipping_charges']))
                                            {
                                              $shippingcharges = $order_product_detail['shipping_charges'];
                                            }
                                          ?>
                                          <?php if(isset($order_product_detail['unit_price'])): ?> 

                                           $<?php echo e(num_format($order_product_detail['unit_price']*$order_product_detail['quantity']+$shippingcharges)); ?> 
                                          
                                          <?php endif; ?>
                                        </td>

                                        
                                  </tr> 

                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?> 

                        <?php if(!empty($arr_transaction_detail[0]['order_details']) && count($arr_transaction_detail[0]['order_details'])>0): ?>
                        <?php $__currentLoopData = $arr_transaction_detail[0]['order_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                              <?php
                                $couponcode = isset($order_detail['couponcode'])?$order_detail['couponcode']:'';
                                $discount = isset($order_detail['discount'])?$order_detail['discount']:'';
                                $seller_discount_amt = isset($order_detail['seller_discount_amt'])?$order_detail['seller_discount_amt']:'';
                                $sellername = get_seller_details($order_detail['seller_id']);

                              if(isset($couponcode) && !empty($couponcode) && isset($seller_discount_amt) && !empty($seller_discount_amt))
                              {
                              ?>
                             <tr>
                                 <td colspan="5"><b>Couponcode (<?php echo e($couponcode); ?>) (<?php echo e($discount); ?>)% </b> : </td>
                               
                                 <td> <?php echo e(isset($seller_discount_amt)? '-$'.number_format($seller_discount_amt,2):'-'); ?></td>
                             </tr>
                             <?php 
                              } //end couponcode
                             ?>



                             <?php
                                $sellername = '';
                                $delivery_title = isset($order_detail['delivery_title'])?$order_detail['delivery_title']:'';
                                $delivery_day = isset($order_detail['delivery_day'])?$order_detail['delivery_day']:'';
                                $delivery_cost = isset($order_detail['delivery_cost'])?$order_detail['delivery_cost']:'';
                                $sellername = get_seller_details($order_detail['seller_id']);

                              if(isset($delivery_title) && !empty($delivery_title) && isset($delivery_cost) && !empty($delivery_cost))
                              {


                                  // $deliverday = isset($order_detail['delivery_day'])? date('l jS \, F Y', strtotime($order_detail['created_at']. ' + '.$order_detail['delivery_day'].' days')):'';

                                 $deliverday = isset($order_detail['delivery_day'])? date('l, M. d Y', strtotime($order_detail['created_at']. ' + '.$order_detail['delivery_day'].' days')):'';

                              ?>
                             <tr>
                                 <td colspan="5">
                                     Dispensary : <?php echo e(isset($sellername) ? $sellername : ''); ?>

                                     <br/>
                                     Delivery Option Title : <?php echo e($delivery_title); ?>   
                                     <br/>
                                     Delivery Option Date : <?php echo e(isset($deliverday) ? $deliverday : ''); ?>

                                    
                                  </td>
                               
                                 <td> <?php echo e(isset($delivery_cost)? '$'.number_format($delivery_cost,2):'-'); ?></td>
                             </tr>
                             <?php 
                              } //end couponcode
                             ?>


                            <!---------------tax------------------------------>

                            <?php
                                $sellername = '';
                                $tax = isset($order_detail['tax'])?$order_detail['tax']:'';
                                $sellername = get_seller_details($order_detail['seller_id']);

                              if(isset($tax) && !empty($tax))
                              {

                             ?>
                             <tr>
                                 <td colspan="5">
                                     Dispensary : <?php echo e(isset($sellername) ? $sellername : ''); ?> (Tax)
                                 </td>
                               
                                 <td> <?php echo e(isset($tax)? '$'.number_format($tax,2):'-'); ?></td>
                             </tr>
                             <?php 
                              } //end couponcode
                             ?>


                             
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   

                            <tr>
                            <th colspan="5">Wallet Amount Used</th>
                            <?php
                                $get_wallet_amountused_fororder = get_wallet_amountused_fororder($arr_transaction_detail[0]['user_id'],$arr_transaction_detail[0]['order_no']);
                             ?>
                            <th>$ <?php echo e(isset($get_wallet_amountused_fororder) ? $get_wallet_amountused_fororder : ''); ?></th>
                          </tr>

                             <tr>
                                 <td colspan="5"> <b>Total : </b> </td>
                               
                                 <td> $<?php echo e(isset($arr_transaction_detail[0]['total_price'])? number_format($arr_transaction_detail[0]['total_price'],2):'-'); ?></td>
                             </tr>
                         <?php endif; ?> 


                        </tbody>

                     </table>

                     <div class="form-group row">
                        <div class="col-10">
                           <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                     </div>
                                             
                  </div>
               </div>
            </div>
         </div>
      </div>
<!-- END Main Content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>