<?php $__env->startSection('main_content'); ?>

<?php if(isset($order_no) && !empty($order_no) && isset($total_amt) && !empty($total_amt)): ?>
<div class="cart-section-block">
    <a href="javascript:void(0)" class="cart-step-one">
        <div class="step-one step-active complited-act">
            <span class="num-step num-step-hide">1</span>
            <span class="step-tick"> </span>
            <span class="name-step-confirm">Shipping Cart</span>
        </div>
        <div class="clearfix"></div>
    </a>
    <a href="javascript:void(0)" class="cart-step-one">
        <div class="step-one step-active complited-act">
            <span class="num-step font-style"> </span>
            <span class="name-step-confirm">Payment & Billing </span>
        </div>
        <div class="clearfix"></div>
    </a>
    <a href="#" class="cart-step-one">
        <div class="step-one step-active last-cart-step">
            <span class="num-step font-style"> </span>
            <span class="name-step-confirm">Order Placed</span>
        </div>
        <div class="clearfix"></div>
    </a>
    <div class="clearfix"></div>
</div>
<?php else: ?>

<?php endif; ?>
<div class="container">
<div class="age-verification-div">
 <?php if(isset($buyeragerestrictionflag) && !empty($buyeragerestrictionflag) && $buyeragerestrictionflag>0): ?>
   <a href="<?php echo e(url('/')); ?>/buyer/age-verification" target="_blank">
     <div class="fnt-clr">Age Verification Needed </div>
     <div class="fnt-clr-content">
       You need to add your age-verification details for your order to be shipped. Click this button to add your age-verification details
     </div>
   </a>
 <?php endif; ?>
 </div>
</div>

<?php if(isset($order_no) && !empty($order_no)): ?>
<div class="container">
    <div class="ordts-checkots">
         <?php if(isset($buyeragerestrictionflag) && !empty($buyeragerestrictionflag) && $buyeragerestrictionflag>0): ?>
            <div class="confirmation-tx"><a href="<?php echo e(url('/')); ?>/buyer/age-verification" target="_blank">Click here</a> to get age-verified, so the dispensary can ship your order to you on time.</div>
        <?php endif; ?>  

        <div class="order-yours-txs">Order Details!</div>
        <div class="succefully-tx">Your order has been successfully placed.</div>
        <div class="order-nums">Order No: <span><?php echo e($order_no); ?></span></div>
       <div class="confirmation-tx">You will receive the confirmation shortly</div> 
       <div class="order-nums"><a href="<?php echo e(url('/')); ?>/search" type="button" class="butn-def" >Continue Shopping</a> </div>
    </div>
</div>
<?php else: ?>
 
  <div class="container">
    <div class="ordts-checkots">
         <div class="order-yours-txs">No such order Available.</div>
    </div>
 </div>

<?php endif; ?>




<?php if(isset($order_no) && !empty($order_no) && isset($total_amt) && !empty($total_amt)): ?>


<?php endif; ?>



<?php

$time = $address = $state = $country = $zipcode = $city = $billing_address = $billing_state = $billing_country = $billing_state = $billing_zipcode = $billing_city = $buyerfname = $buyerlname = $buyeremail = $buyerzip = $buyerstreetaddr = $buyerphone = $category_name = $orderno = $sellername = '';

$get_total_amount =  $shippingtotal =0;
$name = $category_array = $product_array1 = $product_array = [];

$google_api_arr = $google_api_arr1 = $google_api_arr_products = []; $total_shipping_charge_api = 0;

if(isset($order_details_arr) && !empty($order_details_arr))
{
      foreach($order_details_arr as $product_list){
      $get_total_amount =  number_format($get_total_amount+$product_list['total_amount'],2);

      }

      $orderno = isset($order_details_arr[0]['order_no'])?$order_details_arr[0]['order_no']:'';
  
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

      $buyerfname = isset($order_details_arr[0]['buyer_details']['first_name'])?$order_details_arr[0]['buyer_details']['first_name']:'';

      $buyerlname = isset($order_details_arr[0]['buyer_details']['last_name'])?$order_details_arr[0]['buyer_details']['last_name']:'';

      $buyeremail = isset($order_details_arr[0]['buyer_details']['email'])?$order_details_arr[0]['buyer_details']['email']:'';

      $buyerzip = isset($order_details_arr[0]['buyer_details']['zipcode'])?$order_details_arr[0]['buyer_details']['zipcode']:'';

      $buyerstreetaddr = isset($order_details_arr[0]['buyer_details']['street_address'])?$order_details_arr[0]['buyer_details']['street_address']:'';

      $buyerphone = isset($order_details_arr[0]['buyer_details']['phone'])?$order_details_arr[0]['buyer_details']['phone']:'';


      foreach($order_details_arr as $kk=>$product_list)
      {

       foreach($product_list['order_product_details'] as $k=>$product_details_arr)
       {
         
         $price = 0;
         $shippingtotal =  isset($product_details_arr['shipping_charges'])?number_format($shippingtotal+$product_details_arr['shipping_charges'],2):'';

         if($product_details_arr['quantity']==1)
         {
            $price = $product_details_arr['unit_price'];
         }
         else{
            $price = $product_details_arr['unit_price']*$product_details_arr['quantity']; 
         }   
         $name[] = isset($product_details_arr['product_details']['product_name'])?$product_details_arr['product_details']['product_name']:'';
         
          $category_name    =  isset($product_details_arr['product_details']['first_level_category_id'])?get_first_levelcategorydata($product_details_arr['product_details']['first_level_category_id']):'';
          if(!in_array($category_name,$category_array))
          {
              $category_array [] = $category_name;
          }

        $product_array['ProductID']   = $product_details_arr['product_details']['id'];
        $product_array['ProductName']  = $product_details_arr['product_details']['product_name'];
        $product_array['Quantity']     = $product_details_arr['quantity'];
        $product_array['ItemPrice']    = num_format($product_details_arr['unit_price']);
        $product_array['RowTotal']     = $product_details_arr['quantity'] *$product_details_arr['unit_price'];
         $product_array['Shipping Charges']  = num_format($product_details_arr['shipping_charges']);
         $sellername = get_seller_details($product_details_arr['product_details']['user_id']);         
         $product_array['Dispensary']  = isset($sellername)?$sellername:'';       
         $product_array1[] = $product_array;

         $total_shipping_charge_api = $total_shipping_charge_api+ num_format($product_details_arr['shipping_charges']);





         $google_api_arr_products['id'] = isset($product_details_arr['product_details']['id'])?$product_details_arr['product_details']['id']:'';
         $google_api_arr_products['name'] = isset($product_details_arr['product_details']['product_name'])?$product_details_arr['product_details']['product_name']:'';
         $google_api_arr_products['quantity'] = isset($product_details_arr['quantity'])?$product_details_arr['quantity']:'';
          $google_api_arr_products['category'] = isset($product_details_arr['product_details']['first_level_category_id'])?get_first_levelcategorydata($product_details_arr['product_details']['first_level_category_id']):'';

          $google_api_arr_products['category'] = isset($product_details_arr['product_details']['brand'])?get_first_levelcategorydata($product_details_arr['product_details']['brand']):'';

          $google_api_arr_products['price'] = $product_details_arr['quantity'] *$product_details_arr['unit_price'];
           $google_api_arr[]= isset($google_api_arr_products)?$google_api_arr_products:[];

              

     }//foreach

        $transaction_id = isset($order_details_arr[0]['transaction_id'])?$order_details_arr[0]['transaction_id']:'';
        $revenue = isset($get_total_amount)?$get_total_amount:'';
        $shipping = isset($total_shipping_charge_api)?$total_shipping_charge_api:'';
        $google_api_arr1 = isset($google_api_arr)?$google_api_arr:[];

   }//foreach
    


$time = time();

}//foreach

//dd($google_api_arr1);


?>


<?php 
if(isset($order_details_arr) && !empty($order_details_arr))
{
?>

<script>
    var _learnq = _learnq || [];
     _learnq.push(["track", "Placed Order", {

             "event_id": "<?php echo e(isset($time) ? $time : ''); ?>",
              "event": "Placed Order",
              "Order No" : "<?php echo e($orderno); ?>",
             "customer_properties": {
             "email": "<?php echo e(isset($buyeremail) ? $buyeremail : ''); ?>",
             "first_name": "<?php echo e(isset($buyerfname) ? $buyerfname : ''); ?>",
             "last_name": "<?php echo e(isset($buyerlname) ? $buyerlname : ''); ?>",
             //"phone_number": "<?php echo e(isset($buyerphone) ? $buyerphone : ''); ?>",
             "address1": "<?php echo e(isset($buyerstreetaddr) ? $buyerstreetaddr : ''); ?>"          
             },
             "value": <?php echo e(isset($get_total_amount) ? $get_total_amount : ''); ?>,
             "Shipping Charges": <?php echo e(isset($shippingtotal) ? $shippingtotal : ''); ?>,
             "ItemNames": <?php echo json_encode($name); ?>,
             "Categories": <?php echo json_encode($category_array); ?>,
             "Items":  [<?php echo json_encode($product_array1);?>] ,
              "ShippingAddress": {
               "FirstName": "<?php echo e(isset($buyerfname) ? $buyerfname : ''); ?>",
               "LastName": "<?php echo e(isset($buyerlname) ? $buyerlname : ''); ?>",
               "Address1": "<?php echo e(isset($buyerstreetaddr) ? $buyerstreetaddr : ''); ?>",
               //"Phone": "<?php echo e(isset($buyerphone) ? $buyerphone : ''); ?>",
                "City": "<?php echo e(isset($city) ? $city : ''); ?>",
                "Country": "<?php echo e(isset($country) ? $country : ''); ?>",
                "Zip": "<?php echo e(isset($zipcode) ? $zipcode : ''); ?>"
               
             },
              "BillingAddress": {
               "FirstName": "<?php echo e(isset($buyerfname) ? $buyerfname : ''); ?>",
               "LastName": "<?php echo e(isset($buyerlname) ? $buyerlname : ''); ?>",
               "Address1": "<?php echo e(isset($buyerstreetaddr) ? $buyerstreetaddr : ''); ?>",
               // "Phone": "<?php echo e(isset($buyerphone) ? $buyerphone : ''); ?>",
               "City": "<?php echo e(isset($billing_city) ? $billing_city : ''); ?>",
               "Country": "<?php echo e(isset($billing_country) ? $billing_country : ''); ?>",
               "Zip":  "<?php echo e(isset($billing_zipcode) ? $billing_zipcode : ''); ?>"              
             },
        }]);


           dataLayer.push({
              'event': 'Purchase',
              'ecommerce': {
                'purchase': {
                  'actionField': {
                    'id': '<?php echo e(isset($transaction_id) ? $transaction_id : ''); ?>',  
                    'revenue': '<?php echo e(isset($revenue) ? $revenue : ''); ?>',              
                    'shipping': '<?php echo e(isset($shipping) ? $shipping : ''); ?>',
                    //'coupon': 'SUMMER_SALE'
                  },
                  'products': <?php echo json_encode($google_api_arr1) ?>
                }
              }
            });


</script>


<?php
}
?>




<?php $__env->stopSection(); ?> 
<?php echo $__env->make('front.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>