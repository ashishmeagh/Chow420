
<?php

// $site_logo = get_site_logo();
// $site_logo = url('/uploads/profile_image/'.$site_logo['site_logo']);
// if(file_exists($site_logo)==true && $site_logo!='')

// if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists($site_setting_arr['site_logo']))
if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo']))
{
    // $site_logo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    $path = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
}
else
{
    // $site_logo = url('/').'/assets/front/images/chow-logo.png';
    $path = url('/').'/assets/front/images/chow-logo.png';
}

$type      = pathinfo($path, PATHINFO_EXTENSION);
$data      = file_get_contents($path);
$site_logo = 'data:image/'.$type.';base64,'.base64_encode($data);
 
//$site_logo = url('/')."/assets/front/images/chow-logo.png";    
        

?>
<body style="background-color: #fff;">
<style type="text/css">
 .data_container {
  width: 200px;
  word-wrap: break-word;
}

.data_container2 {
  word-wrap: break-word;

} 
</style>
<div style="margin:0 auto; width:100%;">
<table width="100%" bgcolor="#fff" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ddd;font-family:Arial, Helvetica, sans-serif;">
    <tr>
        <td colspan="2" style="padding: 10px 18px;">
            <table bgcolor="#fff" width="100%" border="0" cellspacing="10" cellpadding="0">
                <tr>
                    <td width="40%" style="font-size:40px; color: #fff;"> <img src="<?php echo e(isset($site_logo) ? $site_logo : ''); ?>" width="150px" alt=""/></td>
                    <td width="60%" style="text-align:right; color: #333;">
                        <h3 style="line-height:25px;margin:0px;padding:0px;">Chow420</h3>
                        
                    </td>
                </tr>
            </table>
        </td>
    </tr>
   
    <tr>
        <td colspan="2" style="background-color: #d3d7de;padding:10px 10px 10px 30px;font-size:12px;">
           
            
            <table width="100%">
                <tr>
                    <td width="50%">
                         <h3 style="font-size:18px;padding:0;margin:0px;">Order ID: <?php echo e(isset($order_no)?$order_no:$order_no); ?> </h3>
                    </td>
                    <td width="50%" style="background-color: #d3d7de;padding:10px;font-size:16px; text-align: right;">
                       <b>Order Date:</b> <?php echo e(us_date_format(date("Y/m/d"))); ?>

                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
    <tr>
        <td colspan="2" style="height:10px;">
            &nbsp;
        </td>
    </tr>
    <tr>

        <td colspan="2" style="padding:10px 30px 10px 30px; font-size:12px;">
            <table width="100%">
             <tbody>
                
                <tr>
                    <td colspan="3">
                        <table width="100%">
                             <tr>
                               
                                <td>
                                  <b>Customer Name : </b>
                                    <?php if(isset($user) && !empty($user)): ?>
                                       <?php if($user->first_name || $user->last_name): ?>
                                        <?php 
                                            $first_name = isset($user->first_name)?$user->first_name:"";
                                           $last_name  = isset($user->last_name)?$user->last_name:"";  
                                         ?> 
                                         <?php echo e($first_name); ?> <?php echo e($last_name); ?>                                    
                                       <?php else: ?>
                                         <?php echo e($user->email); ?>

                                      <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                 <td style="vertical-align: top">
                                 
                                     <?php if(isset($seluser_info['seller_detail']) && !empty($seluser_info['seller_detail']['business_name'])): ?>

                                       <b> Dispensary Name</b> : <?php echo e($seluser_info['seller_detail']['business_name']); ?>

                                      <?php else: ?>
                                       <b> Dispensary Name</b> : <?php echo e($seluser_info['first_name']); ?> <?php echo e($seluser_info['last_name']); ?>

                                     
                                    <?php endif; ?>

                                </td>
                                
                              </tr>
                            
                               <tr>
                                      
                                        <td>  <b>Customer Address :</b>
                                        <div class="data_container">
                                          <?php if(isset($address['shipping']) && !empty($address['shipping'])): ?>
                                            <?php echo e($address['shipping']); ?>

                                          <?php endif; ?>

                                           <?php if(isset($address['shipping_city']) && !empty($address['shipping_city'])): ?>
                                            ,<?php echo e($address['shipping_city']); ?>

                                          <?php endif; ?>

                                           <?php if(isset($address['shipping_state']) && !empty($address['shipping_state'])): ?>
                                            ,<?php echo e($address['shipping_state']); ?>

                                          <?php endif; ?>

                                          <?php if(isset($address['shipping_country']) && !empty($address['shipping_country'])): ?>
                                            ,<?php echo e($address['shipping_country']); ?>

                                          <?php endif; ?>

                                           <?php if(isset($address['shipping_zipcode']) && !empty($address['shipping_zipcode'])): ?>
                                            ,<?php echo e($address['shipping_zipcode']); ?>.
                                          <?php endif; ?>


                                            
                                        </div>
                                     </td>
                                     <td style="vertical-align: top">
                                        <?php if(isset($seluser_info) && !empty($seluser_info)): ?>
                                          <?php if($seluser_info['email']): ?>
                                           <b> Dispensary Email </b> : <?php echo e($seluser_info['email']); ?>

                                          <?php endif; ?>
                                        <?php endif; ?>
                                     </td>
                              </tr>
                              
                        </table>
                       
                    </td>
                   
                </tr>
                

             </tbody>
            </table>
        </td>
    </tr>

   
    
     <tr>

        <td colspan="2">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">S.No.</th>
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Product Name</th>

                     <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Dropshipper</th>

                     <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Seller</th>
               
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Unit Price</th>

                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Qty.</th>

                     
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Total</th>
                </tr>
               <?php
                  $sum =0;       
                  $shipping_charges_sum = 0;

               ?>
              <?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php

                  $sum += $ord['total_wholesale_price'];
                  $shipping_charges_sum += $ord['shipping_charges'];
                 ?>

                <tr>
                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><?php echo e(++$sn_no); ?></td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b><?php echo e(isset($ord['product_name']) ? $ord['product_name'] : '-'); ?></td> 

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b><?php echo e(isset($ord['dropshipper']) ? $ord['dropshipper'] : '-'); ?></td>    

                      <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b><?php echo e(isset($ord['seller_name']) ? $ord['seller_name'] : '-'); ?></td>                       

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$<?php echo e(isset($ord['unit_price'])?num_format($ord['unit_price']):0); ?></td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><?php echo e(isset($ord['item_qty']) ? $ord['item_qty'] : 0); ?></td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$<?php echo e(isset($ord['total_wholesale_price'])?num_format($ord['total_wholesale_price']):0); ?></td>
 
                     
                </tr>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
               
            </table>
        </td>
    </tr>
  <tr>
    <td colspan="2" style="background-color: #eeeff1" height="10px"></td>
</tr>
    <tr>
        <td width="80%" style="text-align: right; font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Subtotal
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            $<?php echo e(isset($sum)?num_format($sum):''); ?>

        </td>
    </tr>
     <tr>
        <td width="80%" style="text-align: right; font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Shipping Charges
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            $<?php echo e(isset($shipping_charges_sum)?num_format($shipping_charges_sum):''); ?>

        </td>
    </tr>
   <tr>
        <td width="80%" style="text-align: right;font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Total
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            $<?php echo e(isset($sum) && isset($shipping_charges_sum)?num_format($sum + $shipping_charges_sum):''); ?>

        </td>
    </tr>
     
    <tr>
    <td colspan="2" style="background-color: #eeeff1" height="10px"></td>
</tr>
    <tr>
        <td colspan="2" style="padding: 20px 20px 5px; color: #fff; background-color: #b833cc; text-align: center;"> If you have any questions about this invoice, please contact
        </td>
    </tr>
    <tr>
        
    </tr>
    <tr>
        <td colspan="2" style="padding: 5px 10px 20px; color: #fff; text-align: center; font-size: 20px; background-color: #b833cc;">
           <b>Thank You For Your Business!</b>
        </td>
    </tr>



</table>
</div>
</body>
