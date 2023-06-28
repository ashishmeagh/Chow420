                
<?php $__env->startSection('main_content'); ?>
<style type="text/css">
  .colorbuttonfs {
    background-color: #873dc8 !important;
    color: #fff !important;
    border: 1px solid #873dc8 !important;
}
.colorbuttonfs:hover {
    background-color: #fff !important;
    color: #873dc8 !important;
    border: 1px solid #873dc8 !important;
}
.colorbuttonfs:focus {
    background-color: #fff !important;
    color: #873dc8 !important;
    border: 1px solid #873dc8 !important;
}
.qty-bld{
  color: #000000 !important;
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
           
         <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/order')); ?>">Order</a></li>
         <li class="active"><?php echo e(isset($page_title) ? $page_title : ''); ?></li>
      </ol>
   </div>
   <!-- /.col-lg-12 --> 
</div>

<?php
$late = '';
 if(isset($arr_order_detail) && !empty($arr_order_detail))
 {
     $created_at  = date($arr_order_detail[0]['created_at']);
     $orderdate =  date ( 'Y-m-d' , strtotime ( $created_at . ' + 7 days' ));
     $currentdate = date('Y-m-d');
     if($currentdate>$orderdate && $arr_order_detail[0]['order_status']=="2")
     {
        $late='<span class="status-shipped">Late</span>';
     }
     else
     {
       $late='';
     }
 }
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
          <?php // dd($arr_order_detail); ?>

                <?php if(!empty($arr_order_detail) && count($arr_order_detail)>0): ?>
                     <div class="row-class">
                       <?php if(!empty($arr_order_detail[0]['seller_details']) && count($arr_order_detail[0]['seller_details'])>0): ?>
                        <div class="h-four-class">
                        <h4>Order No : <span><?php echo e(isset($arr_order_detail[0]['order_no'])?$arr_order_detail[0]['order_no']:''); ?> </span></h4>

                          <!----------pending age verificaiton tag added-------------->
                          <?php if($arr_order_detail[0]['order_status']==2): ?>
                            <?php if(isset($arr_order_detail[0]['buyer_age_restrictionflag']) && $arr_order_detail[0]['buyer_age_restrictionflag']==1): ?>
                              <div class="status-dispatched pull-right"> Pending Age Verification</div>
                            <?php endif; ?>
                          <?php endif; ?> 
                          <!--------end of pending age vierificaiton tag---------------->

 

                         <h4>Order Date : <span><?php echo e(isset($arr_order_detail[0]['created_at'])? date('d M Y',strtotime($arr_order_detail[0]['created_at'])):''); ?> |   <?php echo e(isset($arr_order_detail[0]['created_at'])?date("g:i A",strtotime($arr_order_detail[0]['created_at'])):''); ?></span> </h4>
                         <?php if($arr_order_detail[0]['order_status']==0): ?>

                          <h4>Order Status : <div class="status-shipped">Cancelled</div> </h4>
                          <h4>Cancellation Time : <span><?php echo e(isset($arr_order_detail[0]['order_cancel_time'])?date("d M Y",strtotime($arr_order_detail[0]['order_cancel_time'])):''); ?>   |   <?php echo e(isset($arr_order_detail[0]['order_cancel_time'])?date("g:i a",strtotime($arr_order_detail[0]['order_cancel_time'])):''); ?></span> </h4>
                          <h4>Cancellation Reason : <span> <?php echo e(isset($arr_order_detail[0]['order_cancel_reason'])?$arr_order_detail[0]['order_cancel_reason']:'N/A'); ?></span> </h4>

                        <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($arr_order_detail[0]['buyer_details']) && count($arr_order_detail[0]['buyer_details'])>0): ?>
                           <div class="h-four-class">
                             <h4 class="spc-mrgns">Buyer : <span><?php echo e($arr_order_detail[0]['buyer_details']['first_name'].' '.$arr_order_detail[0]['buyer_details']['last_name']); ?></span></h4> 
                          </div>
                        <?php endif; ?>


                        <?php if(!empty($arr_order_detail[0]['buyer_details']) && count($arr_order_detail[0]['buyer_details'])>0): ?>
                           <div class="h-four-class">
                            <h4 class="spc-mrgns">Buyer Age : <span>
                              <?php
                                if (isset($arr_order_detail[0]['buyer_details']['date_of_birth']) && $arr_order_detail[0]['buyer_details']['date_of_birth'] != "")
                                {
                                    $dob = $arr_order_detail[0]['buyer_details']['date_of_birth'];
                                    $age = (date('Y') - date('Y',strtotime($dob))) . " Years";
                                }
                                else {
                                    $age = " NA";
                                }
                              ?>
                                  
                              <?php echo e($age); ?> 

                            </span></h4> 
                          </div>
                        <?php endif; ?>

                        <?php if(isset($arr_order_detail[0]['buyer_details']['email']) && $arr_order_detail[0]['buyer_details']['email']!=''): ?>

                          <div class="h-four-class">
                            <h4 class="spc-mrgns">Email : <span>
                              <?php
                              
                                if (isset($arr_order_detail[0]['buyer_details']['email']) && $arr_order_detail[0]['buyer_details']['email'] != "")
                                {
                                    $email = $arr_order_detail[0]['buyer_details']['email'];
                                }
                                else {
                                    $email = " NA";
                                }
                              ?>
                                  
                              <?php echo e($email); ?> 

                            </span></h4> 
                          </div>

                        <?php endif; ?>


                    </div>
                <?php endif; ?>

             <?php if(!empty($arr_order_detail[0]['address_details']) && count($arr_order_detail[0]['address_details'])>0): ?>






                <div class="row">
                  <div class="col-md-12">
                    <div class="title-chow-sw bordershipping">Shipping Details:</div>
                  </div>
                  
                
                  <div class="col-md-6">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Email</div>
                           <div class="myprofile-right">
                            <?php if(isset($arr_order_detail[0]['buyer_details']['email'])): ?>
                            <?php echo e($arr_order_detail[0]['buyer_details']['email']); ?>

                            <?php else: ?>
                            NA
                            <?php endif; ?>
                           </div>
                           <div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Address</div>
                           <div class="myprofile-right">



                                <?php if(isset($arr_order_detail[0]['address_details']['shipping_address1']) && $arr_order_detail[0]['address_details']['shipping_address1']!=""): ?>
                                <?php echo e($arr_order_detail[0]['address_details']['shipping_address1'].', '); ?> 
                                <?php endif; ?>

                                <?php if(isset($arr_order_detail[0]['address_details']['shipping_city']) && $arr_order_detail[0]['address_details']['shipping_city']!=""): ?>
                                 <?php echo e($arr_order_detail[0]['address_details']['shipping_city'].', '); ?>

                                <?php endif; ?> 

                                <?php if(isset($arr_order_detail[0]['address_details']['get_shippingstatedetail']['name']) && $arr_order_detail[0]['address_details']['get_shippingstatedetail']['name']!=""): ?>
                                 <?php echo e($arr_order_detail[0]['address_details']['get_shippingstatedetail']['name'].', '); ?>

                                <?php endif; ?>   


                                <?php if(isset($arr_order_detail[0]['address_details']['get_shippingcountrydetail']['name']) && $arr_order_detail[0]['address_details']['get_shippingcountrydetail']['name']!=""): ?>
                                 <?php echo e($arr_order_detail[0]['address_details']['get_shippingcountrydetail']['name'].', '); ?>

                                <?php endif; ?>  

                               
                                <?php if(isset($arr_order_detail[0]['address_details']['shipping_zipcode']) && $arr_order_detail[0]['address_details']['shipping_zipcode']!=""): ?>
                                 <?php echo e($arr_order_detail[0]['address_details']['shipping_zipcode']); ?>

                                <?php endif; ?> 
                              
                               
                           </div>
                           <div class="clearfix"></div>
                      </div>
                  </div>
         
                 
                  <?php if($arr_order_detail[0]['order_status']!=2): ?>                  
                    <div class="col-md-6">
                        <div class="myprofile-main">
                             <div class="myprofile-lefts">Tracking #</div>
                             <div class="myprofile-right"><?php echo e(isset($arr_order_detail[0]['tracking_no']) ? $arr_order_detail[0]['tracking_no'] : 'N/A'); ?></div>
                             <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="myprofile-main">
                             <div class="myprofile-lefts">Shipping Company <br/> Name </div>
                             <?php
                              if($arr_order_detail[0]['shipping_company_name'])
                                $shippingcompany_name = $arr_order_detail[0]['shipping_company_name'];
                              else
                                $shippingcompany_name = 'NA';
                             ?>
                             <div class="myprofile-right"> <?php echo e($shippingcompany_name); ?></div>
                             <div class="clearfix"></div>
                        </div>
                    </div> 
                  <?php endif; ?>


                </div>



                <div class="mrgs-styls">
                <div class="row">
                  <div class="col-md-12">
                    <div class="title-chow-sw bordershipping">Billing Details:</div>
                  </div>
                 
                  
                  <div class="col-md-12">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Address</div>
                           <div class="myprofile-right">
                              <?php if(isset($arr_order_detail[0]['address_details']['billing_address1']) && $arr_order_detail[0]['address_details']['billing_address1']!=""): ?>
                                <?php echo e($arr_order_detail[0]['address_details']['billing_address1'].', '); ?> 
                                <?php endif; ?>

                                 <?php if(isset($arr_order_detail[0]['address_details']['billing_city']) && $arr_order_detail[0]['address_details']['billing_city']!=""): ?>
                                 <?php echo e($arr_order_detail[0]['address_details']['billing_city'].', '); ?>

                                <?php endif; ?>

                                <?php if(isset($arr_order_detail[0]['address_details']['get_billingstatedetail']['name']) && $arr_order_detail[0]['address_details']['get_billingstatedetail']['name']!=""): ?>
                                 <?php echo e($arr_order_detail[0]['address_details']['get_billingstatedetail']['name'].', '); ?>

                                <?php endif; ?>   

                                 <?php if(isset($arr_order_detail[0]['address_details']['get_billingcountrydetail']['name']) && $arr_order_detail[0]['address_details']['get_billingcountrydetail']['name']!=""): ?>
                                 <?php echo e($arr_order_detail[0]['address_details']['get_billingcountrydetail']['name'].', '); ?>

                                <?php endif; ?>  
                             

                                 <?php if(isset($arr_order_detail[0]['address_details']['billing_zipcode']) && $arr_order_detail[0]['address_details']['billing_zipcode']!=""): ?>
                                 <?php echo e($arr_order_detail[0]['address_details']['billing_zipcode']); ?>

                                <?php endif; ?>
                             
                           </div>
                         
                           <div class="clearfix"></div>
                      </div>
                        <div class="myprofile-main">
                        <?php if(isset($arr_order_detail[0]['note']) && $arr_order_detail[0]['note'] != ''): ?>
                           <div class="myprofile-lefts">Order note</div>
                             <div class="myprofile-right">
                                <?php echo e($arr_order_detail[0]['note']); ?>

                             </div>
                           <?php endif; ?>
                         </div>
                  </div>
                </div>
               </div>

               <?php endif; ?>

 

                <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                               <th>Product Name</th>
                                  
                                <th>Dropshipper Email </th> 
                                <th>Dropshipper Price </th>   
                                 <th>Dispensary Name </th>                        
                               <th>Quantity</th>
                               <th>Unit Price($)</th>
                               <th>Subtotal Amount($)</th>
                            </tr>
                          </thead>
                          <tbody>

                      <?php if(!empty($arr_order_detail) && count($arr_order_detail)>0): ?>
                        <?php
                         $subtotal = $shippingtotal=0;  
                         $orderdropshipper_id = $orderproduct_id=$dropshippername= $dropshipperemail= $dropshipperprice='';
                         $getdropshipperinfo =[];
                        ?>
                           <?php $__currentLoopData = $arr_order_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          

                            <?php 
                               $orderdropshipper_id = $orderproduct_id=$dropshippername= $dropshipperemail= $dropshipperprice='';
                               $getdropshipperinfo =[];


                              $subtotal  += $product_detail['total_amount']; 
                            ?>

                            <?php $__currentLoopData = $product_detail['order_product_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                               $shippingtotal  += $product['shipping_charges']; 

                                 $orderdropshipper_id = isset($product['dropshipper_id'])?$product['dropshipper_id']:'';

                                $orderproduct_id = isset($product['product_id'])?$product['product_id']:'';

                                if(isset($orderdropshipper_id) && isset($orderproduct_id))
                                {
                                  $getdropshipperinfo = get_dropshipper_info($orderdropshipper_id,$orderproduct_id);
                                  if(isset($getdropshipperinfo) && !empty($getdropshipperinfo))
                                  {
                                       $dropshippername = isset($getdropshipperinfo['name'])?$getdropshipperinfo['name']:'';
                                       $dropshipperemail = isset($getdropshipperinfo['email'])?$getdropshipperinfo['email']:'';
                                       // $dropshipperprice = isset($getdropshipperinfo['unit_price'])?$getdropshipperinfo['unit_price']:'';
                                  }//if getdropshipperinfo 

                                  $dropshipperprice = isset($product['dropshipper_price'])?$product['dropshipper_price']:''; 
                                  
                                }//if dropshipper id and product id






                            ?>
                            <tr>
                                <td><?php echo e($product['product_details']['product_name']); ?></td>
                                <td> 
                                   <?php if(isset($dropshipperemail) && !empty($dropshipperemail)): ?>
                                      <?php echo e($dropshipperemail); ?>

                                   <?php else: ?>
                                      <?php echo e('NA'); ?>

                                   <?php endif; ?>  
                                </td>
                                <td>
                                    <?php if(isset($dropshipperprice) && !empty($dropshipperprice)): ?>
                                      <?php echo e(num_format($dropshipperprice)); ?>

                                   <?php else: ?>
                                      <?php echo e('NA'); ?>

                                   <?php endif; ?>  
                                   
                                </td>
                                <td>
                                  

                                  <?php echo e(isset($product_detail['seller_details']['seller_detail'])?$product_detail['seller_details']['seller_detail']['business_name']:$product_detail['seller_details']['first_name']); ?>


                                  <?php echo $late ?>
                                </td>

                                 <td><b class="qty-bld"><?php echo e($product['quantity']); ?></b></td>                            
                                 <td> $<?php echo e(num_format($product['unit_price'])); ?></td>
                                 <td> $<?php echo e(num_format($product['unit_price']*$product['quantity'])); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?> 
                        </tbody>
                        <tfoot>

                            <?php 

                            $order_id = isset($order_id)?$order_id:'';
                            $orderno = isset($orderno)?$orderno:'';

                            if(isset($orderno) && isset($order_id))
                            {
                              $get_coupncodedata_order = get_coupncodedata_order($orderno,$order_id);
                            }
                            else
                            {
                               $get_coupncodedata_order = get_coupncodedata_order($orderno);
                            }
                            
                            $seller_discounted_amt = 0;



                            if(isset($orderno) && isset($order_id))
                            {
                              $get_deliveryoptiondata_order = get_deliveryoptiondata_order($orderno,$order_id);

                              $get_taxdata_order = get_taxdata_order($orderno,$order_id);
                            }
                            else
                            {
                               $get_deliveryoptiondata_order = get_deliveryoptiondata_order($orderno);
                               $get_taxdata_order = get_taxdata_order($orderno);
                            }
                             $seller_deliveryoption_amt = 0;
                             $seller_tax_amt = 0;






                            // $couponcode = isset($arr_order_detail[0]['couponcode'])?$arr_order_detail[0]['couponcode']:'';
                            // $discount = isset($arr_order_detail[0]['discount'])?$arr_order_detail[0]['discount']:'';
                            // $seller_discount_amt = isset($arr_order_detail[0]['seller_discount_amt'])?$arr_order_detail[0]['seller_discount_amt']:'';

                            // $sellername = get_seller_details($arr_order_detail[0]['seller_id']);
                           // $subtotal = (float)$subtotal - (float)$seller_discount_amt;
                            ?> 
                            

                           <?php if(isset($get_coupncodedata_order) && !empty($get_coupncodedata_order)): ?>
                              <?php $__currentLoopData = $get_coupncodedata_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k1=>$v1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if(isset($v1['couponcode']) && !empty($v1['couponcode']) && isset($v1['seller_discount_amt']) && !empty($v1['seller_discount_amt']) && isset($v1['discount']) && !empty($v1['discount'])): ?>
                                <tr>
                                  <th colspan="6">Coupon : (<?php echo e($v1['couponcode']); ?>) (<?php echo e($v1['discount']); ?>) %: <br/></th>
                                  <th><?php echo e(isset($v1['seller_discount_amt'])? '-$'.number_format($v1['seller_discount_amt'],2):'-'); ?></th>
                                </tr>
                                <?php endif; ?>

                                <?php
                                  $seller_discounted_amt = $seller_discounted_amt+$v1['seller_discount_amt'];
                                ?>

                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>


                           <!----------code for delivery option data---------------------->

                            <?php if(isset($get_deliveryoptiondata_order) && !empty($get_deliveryoptiondata_order)): ?>
                              <?php $__currentLoopData = $get_deliveryoptiondata_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k1=>$v1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if(isset($v1['title']) && !empty($v1['title']) && isset($v1['cost']) && !empty($v1['cost']) && isset($v1['day']) && !empty($v1['day'])): ?>

                                 <?php 
                                   $sellername ='';

                                   // $deliverday = isset($v1['day'])? date('l jS \, F Y', strtotime($arr_order_detail[0]['created_at']. ' + '.$v1['day'].' days')):'';

                                   $deliverday = isset($v1['day'])? date('l, M. d Y', strtotime($arr_order_detail[0]['created_at']. ' + '.$v1['day'].' days')):'';



                                  $sellername = isset($arr_order_detail[0]['seller_id'])? get_seller_details($arr_order_detail[0]['seller_id']):'';

                                 ?>

                                <tr>
                                  <th colspan="6"> 
                                     Dispensary : <?php echo e(isset($sellername) ? $sellername : ''); ?>

                                     <br/>
                                     Delivery Option Title : <?php echo e(isset($v1['title']) ? $v1['title'] : ''); ?>  
                                      <br/>
                                      Delivery Option Date : <?php echo e(isset($deliverday) ? $deliverday : ''); ?>

                                  </th>
                                  <th>
                                    <?php echo e(isset($v1['cost'])? '$'.number_format($v1['cost'],2):'-'); ?>

                                  </th>
                                </tr>
                                <?php endif; ?>

                                <?php
                                  $seller_deliveryoption_amt = $seller_deliveryoption_amt+ (float)$v1['cost'];
                                ?>

                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>
                           <!----------code for delivery option data---------------------->

                           


                           <!----------code for tax data---------------------->

                            <?php if(isset($get_taxdata_order) && !empty($get_taxdata_order)): ?>
                              <?php $__currentLoopData = $get_taxdata_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k1=>$v1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if(isset($v1['tax']) && !empty($v1['tax'])): ?>

                                 <?php 
                                   $sellername ='';
                                   $sellername = isset($arr_order_detail[0]['seller_id'])? get_seller_details($arr_order_detail[0]['seller_id']):'';

                                 ?>

                                <tr>
                                  <th colspan="6"> 
                                     Dispensary : <?php echo e(isset($sellername) ? $sellername : ''); ?> (Tax)
                                 
                                  </th>
                                  <th>
                                    <?php echo e(isset($v1['tax'])? '$'.number_format($v1['tax'],2):'-'); ?>

                                  </th>
                                </tr>
                                <?php endif; ?>

                                <?php
                                  $seller_tax_amt = $seller_tax_amt+ (float)$v1['tax'];
                                ?>

                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>
                           <!----------code for tax data----------------------> 




                          <tr>
                            <th colspan="6">Shipping Charges</th>
                            <th>$<?php echo e(num_format($shippingtotal,2)); ?></th>
                          </tr>
                          <tr>
                            <th colspan="6">Wallet Amount Used</th>
                            <?php
                                $get_wallet_amountused_fororder = get_wallet_amountused_fororder($arr_order_detail[0]['buyer_id'],$orderno);
                             ?>
                            <th>$ <?php echo e(isset($get_wallet_amountused_fororder) ? $get_wallet_amountused_fororder : ''); ?></th>
                          </tr>
                          <tr>
                            <th colspan="6" style="font-weight:600;">Total Amount($)</th>
                            <?php 
                              if(isset($seller_discounted_amt) && !empty($seller_discounted_amt)){
                                $subtotal = (float)$subtotal - (float)$seller_discounted_amt;
                              }else{
                                $subtotal = $subtotal;
                              }


                              // code for delivery option data

                              if(isset($seller_deliveryoption_amt) && !empty($seller_deliveryoption_amt)){
                                $subtotal = (float)$subtotal + (float)$seller_deliveryoption_amt;
                              }else{
                                $subtotal = $subtotal;
                              }

                                // code for tax data

                              if(isset($seller_tax_amt) && !empty($seller_tax_amt)){
                                $subtotal = (float)$subtotal + (float)$seller_tax_amt;
                              }else{
                                $subtotal = $subtotal;
                              }



                            ?>
                            <th style="font-weight:600;">$<?php echo e(num_format($subtotal,2)); ?></th>
                          </tr>
                          <?php if(isset($transaction_data['cashback']) && !empty($transaction_data['cashback'])): ?>
                          <tr>
                            <th colspan="6">Cashback Amount</th>
                            <th><?php echo e(isset($transaction_data['cashback']) ? $transaction_data['cashback'] : ''); ?></th>
                          </tr>
                          <?php endif; ?>
                        </tfoot>
                     </table>
                </div>

                     <div class="form-group row">
                        <div class="col-6">
                          <?php
                            if(isset($arr_order_detail[0]['created_at']))
                            {
                             $order_date = date("Y-m-d",strtotime($arr_order_detail[0]['created_at']));
                             $request_date = date('Y-m-d', strtotime($order_date. ' + 3 days'));
                             // $current_date =date("Y-m-d");

                            // if($current_date<$request_date) {
                            ?>
                            
                              <?php if(isset($arr_order_detail[0]['order_status']) && ($arr_order_detail[0]['order_status']!='0' && $arr_order_detail[0]['order_status']!='1')): ?>

                                <a data-order_id="<?php echo e($arr_order_detail[0]['id']); ?>"  class="btn btn-success waves-effect waves-light m-r-10" id="btn_cancel_order">Cancel Order</a>            
                              <?php endif; ?> 
                            <?php
                            // }
                          }
                          ?>
                           <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-6 text-right">
                           <?php if(isset($arr_order_detail[0]['transaction_details']['transaction_status']) && !empty($arr_order_detail[0]['transaction_details']['transaction_status']) && $arr_order_detail[0]['transaction_details']['transaction_status'] == 1 && isset($arr_order_detail[0]['order_status']) && !empty($arr_order_detail[0]['order_status']) && $arr_order_detail[0]['order_status'] == 1): ?> 


                          


                         <?php endif; ?>
                        </div>
                     </div>
                    
                                             
                  </div>
               </div>
            </div>
         </div>
      </div>
<!-- END Main Content -->



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
             <div class="form-group"> 
                <label>Cancellation Reason :</label>
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
          <a  class="btn btn-success waves-effect waves-light m-r-10" id="cancel_order_model_btn" onclick="cancelOrder($(this));">Confirm Cancellation</a>

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
      var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";
      // alert(module_url_path);
      var order_id   = $('#model_order_id').val();
      var order_cancel_reason =  $('#model_order_cancel_reason').val();
      var csrf_token = "<?php echo e(csrf_token()); ?>";

      var logged_in_user  = "<?php echo e(Sentinel::check()); ?>";


      if(logged_in_user)
      {

        $.ajax({
          url: module_url_path+'/cancel',
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

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>