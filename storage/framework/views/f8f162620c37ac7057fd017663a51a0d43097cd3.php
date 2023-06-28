<?php $__env->startSection('main_content'); ?>

<style type="text/css">
  .referalbutton
  {
    color:white;
    background-color: #873dc8;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
  }
   /*.refer_link {float:none; margin:0 auto;}*/
  /*.refer_link .myodr-icn-byr {background:none;}*/
  .add-cart {
    background-color: #873dc8;
    color: #fff;
    font-weight: 600;
    vertical-align: top;
    font-size: 12px;
    padding: 8px 28px;
    text-transform: uppercase;
    display: inline-block;
    border: 1px solid #873dc8;
    letter-spacing: 0.7px;
    border-radius: 3px;                                                                                                                                                                                                                               
}
.my-order-buyr-main {
    background-color: #fff;
    border-radius: 5px;
    text-align: center;
    padding: 67px 30px 30px;
    border: 1px solid #d2d2d2;
    position: relative;
    min-height: 290px;
    margin-bottom: 30px;
}
.add-cart:hover {
    color: #873dc8;
    background-color: #fff;
    transition: 0.3s;
}
.my-order-buyr-main.ord-my-blue.earn-bx {
    padding: 30px 16px 5px;
}
.my-order-buyr-main{ min-height: 290px;}



</style>


<div class="my-profile-pgnm">
Dashboard

  <ul class="breadcrumbs-my">
    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Dashboard</li>
  </ul>
</div>
<?php 
  
  $referalcode = $referalcode;
//  dd($user_subscriptiondata);


?>

<div class="new-wrapper">
<div class="dashboardbuyr-dash">



<!-----------div class row---------------------------->
  <div class="row">
    
      <?php if($user_subscribed=="1" && isset($user_subscriptiondata) && !empty($user_subscriptiondata) && isset($user_subscriptiondata[0]['membership']) && $user_subscriptiondata[0]['membership']=="2"): ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-6 refer_link">
        <div class="my-order-buyr-main ord-my-blue earn-bx">
            <div class="myodr-icn-byr referalindex-icon">
              <img src="<?php echo e(url('/')); ?>/assets/seller/images/referal.png" alt="">
            </div>
            <div class="content">
             <h3>Earn <?php 
                         echo "$". config('app.project.seller_referal'); 
                        ?>!
              </h3>
              <p>Invite other dispensaries and get
                        <?php 
                         echo "$". config('app.project.seller_referal'); 
                        ?>
               in your wallet when they register using your link </p>
              <p id="urlLink" style="display: none;"><?php echo e(url('/')); ?>/refer?referalcode=<?php echo e($referalcode); ?></p>

             
              <a href="<?php echo e(url('/')); ?>/refer?referalcode=<?php echo e($referalcode); ?>" class="add-cart" target="_blank"> Invite</a>

              <div class="copeid-sms" id="copy_txt" style="display:none;"> Link Copied!</div>
            </div>
          </div>
        </div>
      <?php endif; ?>


    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 inx-iconsublime">
    <a href="<?php echo e(url('/')); ?>/seller/product">
      <div class="my-order-buyr-main ord-my-blue">
        <div class="myodr-icn-byr">
          <img src="<?php echo e(url('/')); ?>/assets/seller/images/my-order-icns-buyer.png" alt="" />
        </div>
        <div class="totl-cnts-nm"><?php echo e(isset($total_product) ? $total_product : 0); ?></div>
        <div class="my-odr-grey">My Products</div>
        <!-- <a href="#" class="viewall-lnk">View All</a> -->
      </div>
      </a>
    </div>


    <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class="my-order-buyr-main ord-my-review-tr">
        <div class="myodr-icn-byr">
          <img src="<?php echo e(url('/')); ?>/assets/seller/images/review-rating-icn-buyer.png" alt="" />
        </div>
        <div class="totl-cnts-nm">0</div>
        <div class="my-odr-grey">Review and Ratings</div>
        <a href="#" class="viewall-lnk">View All</a>
      </div>
    </div> -->
    <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class="my-order-buyr-main ord-my-wishlist-tr">
        <div class="myodr-icn-byr">
          <img src="<?php echo e(url('/')); ?>/assets/seller/images/wishlist-icn-buyer.png" alt="" />
        </div>
        <div class="totl-cnts-nm">0</div>
        <div class="my-odr-grey"><b>My Wishlist</b></div>
        <a href="#" class="viewall-lnk">View All</a>
      </div>
    </div> -->
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 inx-iconsublime">
    <a href="<?php echo e(url('/')); ?>/seller/notifications">
      <div class="my-order-buyr-main ord-notification-tr">
        <div class="myodr-icn-byr">
          <img src="<?php echo e(url('/')); ?>/assets/seller/images/notification-icn-buyer.png" alt="" />
        </div>
        <div class="totl-cnts-nm"><?php echo e(isset($total_notification) ? $total_notification : 0); ?></div>
        <div class="my-odr-grey">Notifications</div>
        <!-- <a href="#" class="viewall-lnk">View All</a> -->
      </div>
    </a>
    </div>

      <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 inx-iconsublime">
        
            <div class="my-order-buyr-main ord-notification-tr">
              <div class="myodr-icn-byr">
                <img src="<?php echo e(url('/')); ?>/assets/seller/images/my-order-icns-buyer.png" alt="" />
              </div>
              <div class="totl-cnts-nm" style="font-size: 31px">$<?php echo e(isset($total_soldprice) ? $total_soldprice : 0); ?></div>
              <div class="my-odr-grey">Sold Total Price</div>
              <!-- <a href="#" class="viewall-lnk">View All</a> -->
            </div>
        
       </div>

       <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 inx-iconsublime">
         
            <div class="my-order-buyr-main ord-notification-tr">
              <div class="myodr-icn-byr">
                <img src="<?php echo e(url('/')); ?>/assets/seller/images/my-order-icns-buyer.png" alt="" />
              </div>
              <div class="totl-cnts-nm" style="font-size: 31px"> $<?php echo e(isset($total_productsum) ? $total_productsum : 0); ?></div>
              <div class="my-odr-grey">All Product Cost</div>
              <!-- <a href="#" class="viewall-lnk">View All</a> -->
            </div>
         
       </div>


  </div>
 <!-------end-row-class------------------------->
 


  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
      <div class="dashboard-myprofile">
        <div class="myporfiledash-byr">
         <!-- <?php if(!empty($arr_seller_details['profile_image']) && file_exists(base_path().'/uploads/profile_image/'.$arr_seller_details['profile_image'])): ?>
         
            <img src="<?php echo e(url('/')); ?>/uploads/profile_image/<?php echo e($arr_seller_details['profile_image']); ?>" alt="" />
         
         <?php else: ?>
            <img src="<?php echo e(url('/')); ?>/assets/images/avatar.png" alt="" />
         <?php endif; ?> -->
         <img src="<?php echo e(url('/')); ?>/assets/seller/images/storeicon.png" alt="" />


        </div>
        <div class="byrdashbrd">
          <div class="title-profls-byrs">
            <?php
                $set_name ='';
                if(isset($seller_arr) && !empty($seller_arr)){
                  if($arr_seller_details['first_name']=="" && $arr_seller_details['last_name']=="")
                  {
                    $set_name = $seller_arr['business_name']; 
                  }
                  else
                  {
                    $set_name =  $arr_seller_details['first_name'].' '.$arr_seller_details['last_name'];
                  } 
                }else{
                   $set_name =  $arr_seller_details['first_name'].' '.$arr_seller_details['last_name'];
                }

            ?>


            <?php echo e($set_name); ?>

            

          </div>
          
          <div class="buyertxts">Dispensary</div>

          <?php if(isset($arr_seller_details['street_address']) && !empty($arr_seller_details['street_address'])): ?>
          <div class="address-pfl-byr">
              <i class="fa fa-map-marker"></i> <?php echo e(ucfirst($arr_seller_details['street_address'])); ?>

          </div>
          <?php endif; ?>

        
          
        </div>
         <?php if(isset($arr_seller_details['email']) && !empty($arr_seller_details['email'])): ?>
          <div class="email-profile-byr">
            <i class="fa fa-envelope"></i> <?php echo e($arr_seller_details['email']); ?>

          </div>
        <?php endif; ?>

      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
      <div class="paymenthistory-dash ptm-hisry">
        <div class="paymenthistory-dash-header ">
          <div class="titlepay-dash">Payment History</div>
          <a href="<?php echo e(url('/')); ?>/seller/payment-history" class="viewall-dash-pay">View All</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="table-order">
           <div class="table-responsive">
                    <div class="rtable">
                    <div class="rtablerow none-boxshdow">
                    <div class="rtablehead"><strong>Order ID</strong></div>
                    <div class="rtablehead"><strong>Transaction ID</strong></div>
                    <div class="rtablehead"><strong>Total Price</strong></div>                    
                    <div class="rtablehead"><strong>Status</strong></div>
               
                    </div>
                     <?php if(isset($arr_payment_list) && count($arr_payment_list)>0): ?>
                            <?php $__currentLoopData = $arr_payment_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rtablerow">
                       
                            <div class="rtablecell"><a href="<?php echo e(url('/').'/seller/order/view/'.base64_encode($payment_list->id)); ?>"> <?php echo e(isset($payment_list->order_no) ? $payment_list->order_no : ''); ?></a></div>
                            <div class="rtablecell"><?php echo e(isset($payment_list->transaction_id) ? $payment_list->transaction_id : ''); ?></div>
                            <div class="rtablecell">$<?php echo e(round($payment_list->total_amount,2)); ?></div>
                            <!-- <div class="rtablecell"><div class="decsp-byrs">Lorem ipsum dolor sit amet consectetur adipiscing elit</div></div> -->
                            <!-- <div class="rtablecell"><?php echo e(isset($payment_list->order_status) ? $payment_list->order_status : ''); ?></div> -->
                            <?php if($payment_list->order_status == 0): ?>
                                <div class="rtablecell">
                                    <div class="status-shipped">Cancelled</div>
                                </div>
                            <?php elseif($payment_list->order_status == 1): ?>
                                <div class="rtablecell">
                                    <div class="status-completed">Completed</div>
                                </div>
                            <?php elseif($payment_list->order_status == 2): ?>
                                <div class="rtablecell">
                                    <div class="status-dispatched">Ongoing</div>
                                </div>
                            <?php endif; ?>
                           
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                      <div class="rtablerow">No Record Found</div>
                    <?php endif; ?>
                    <!-- <div class="rtablerow">
                        <div class="rtablecell">O346544790</div>
                        <div class="rtablecell">11 Nov 2019</div>
                        <div class="rtablecell"><div class="decsp-byrs">Lorem ipsum dolor sit amet consectetur adipiscing elit</div></div>
                        <div class="rtablecell">$ 70.50</div>
                        <div class="rtablecell">
                          <div class="status-completed">Completed</div>
                        </div>
                    </div>
                    <div class="rtablerow">
                        <div class="rtablecell">94654790</div>
                        <div class="rtablecell">12 Nov 2019</div>
                        <div class="rtablecell"><div class="decsp-byrs">Lorem ipsum dolor sit amet consectetur adipiscing elit</div></div>
                        <div class="rtablecell">$ 20.50</div>
                        <div class="rtablecell">
                          <div class="status-completed">Completed</div>
                        </div>
                    </div> -->
                    </div>
                </div>
              </div>
        </div>
    </div>
  </div>
</div>
</div>

<script>
  function shareLink(element)
{
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $("#copy_txt").fadeIn(400);
    $("#copy_txt").fadeOut(2000);
}

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>