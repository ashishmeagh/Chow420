 



<?php $__env->startSection('main_content'); ?>



 <link href="<?php echo e(url('/')); ?>/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />




<style>
  .collapse.in{
    display: inline-block;
}
.panel-default > .panel-heading + .panel-collapse > .panel-body {
    border-top-color: #fff;
}
   .label-list{
  display: none !important;
}
 .seller-banner-img-listpage {
    position: relative;
    margin-bottom: 0px;
}
 .listing-page-main.nonepaddingtop {
    padding-top: 40px;
}
 .heart-icn{display: none;}
 .product-holder-list .add_to_cart {
    left: auto;
    right: 20px;
    bottom: 20px;
    z-index: 9999;
    background-color: #444;
    padding: 5px;
    border-radius: 0;
    color: #fff;
}
 .product-holder-list .add_to_cart img{
  filter: brightness(0) invert(1);
}
 .img-cntr {
    margin: 0px auto 7px;
    display: block; padding: 16px 0px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
 .results-products .img-cntr {
  position: relative;
  max-width: 200px;
  overflow: hidden;
}
 .results-products .img-cntr img {
  position: absolute;
  left: 50%;
  top: 50%;
  height: 100%;
  width: auto;
  -webkit-transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);
}
 .results-products .img-cntr img.portrait {
     width: auto;
    height: 150px;
}
 h1 {
    font-size: 17px;
    font-weight: normal;
    margin-bottom: 5px;
    position: relative;
    padding-right: 75px;
}
@media (max-width: 767px){
  .product-holder-list:hover .add_to_cart {
    opacity: 1;
    display: block !important;
}
}
@media (max-width: 650px){
  .headerchnagesmobile .logo-block.mobileviewlogo{
        width: 55vw;
  }
}
@media (max-width: 520px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 53vw;
}
}
@media (max-width: 450px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 45%;
}
}
@media (max-width: 414px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 35%;
}
}
@media (max-width: 350px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 30%;
}
.main-logo {
    width: 70px;
    margin-top: 11px !important;
}
}
</style>
<?php
      
      $stateofuser='';
      $useris='guestuser';
      $login_user = Sentinel::check();  
     if(isset($login_user) && $login_user==true && $login_user->inRole('seller') == true) 
     {
      $useris ="seller";
     }
     else if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true) {
      $useris ="buyer";
      $user_shipping_state  = $login_user->state;
       if(isset($user_shipping_state))
       {
         $stateofuser = get_statedata($user_shipping_state);
       }else{
           $stateofuser = '';
       }
     }

?>

<?php 

if(isset($catdata) && !empty($catdata))
{
  $catdata = $catdata;
}else{
  $catdata =[];
}

if(isset($state_user_ids) && !empty($state_user_ids))
{
  $state_user_ids = array_column($state_user_ids,'id');
 }else{
  $state_user_ids ='';
}



$loggedinuser = 0;
$loged_user = Sentinel::check();

if(isset($loged_user) && $loged_user==true)
{
  $loggedinuser = $loged_user->id;
}
else{
  $loggedinuser = 0;
}

//echo "==".$loggedinuser;


 /*******************Restricted states seller id***********************************/

 $check_buyer_restricted_states =  get_buyer_restricted_sellers();
 $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];
$restricted_state_sellers = [];
if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids)){

      $restricted_state_sellers = [];
      foreach($restricted_state_user_ids as $sellers) {
        $restricted_state_sellers[] = $sellers['id'];
      }
   }
  // dd($restricted_state_sellers);

$is_buyer_restricted_forstate = is_buyer_restricted_forstate();

/********************Restricted states seller id***********************/

 $isMobileDevice =0; $device_count =0;
 $isMobileDevice= isMobileDevice();
 
if($isMobileDevice==1){

    $device_count = 2;
}
else {
    $device_count = 4;
}
?>


<input type="hidden" name="autocompletestate" id="autocompletestate" value="">




<?php
  $category_id     = Request::input('category_id');
  $price           = Request::input('price'); 
  $rating          = Request::input('rating');
  $age_restrictions  = Request::input('age_restrictions');
  $seller   = Request::input('seller');
  $brands   = Request::input('brands');
  $sellers  = Request::input('sellers');
  $brand = Request::input('brand');
  $mg    = Request::input('mg');
  $filterby_price_drop    = Request::input('filterby_price_drop');
  $pdrop_filt_stat =  isset($filterby_price_drop)?$filterby_price_drop:'false';
  $product_search =  Request::input('product_search');
  $state = Request::input('state');
  $city = Request::input('city');

  $chows_choice    = Request::input('chows_choice');
  $chowchoice_filt_stat =  isset($chows_choice)?$chows_choice:'false';

  $best_seller    = Request::input('best_seller');
  $bestseller_filt_stat =  isset($best_seller)?$best_seller:'false';

  $spectrum = Request::input('spectrum');
  $statelaw = Request::input('statelaw');

  $reported_effects = Request::input('reported_effects');
  $cannabinoids = Request::input('cannabinoids');

  $featured = Request::input('featured');
  $cannabinoids = Request::input('cannabinoids');

?>
<input type="hidden" name="category" id="category" value="<?php echo e(isset($category_id) ? $category_id : ''); ?>">
<input type="hidden" name="price" id="price" value="<?php echo e(isset($price) ? $price : ''); ?>">
<input type="hidden" id="lowest_price" value="<?php echo e(isset($lowest_price) ? $lowest_price : 0); ?>" >
<input type="hidden" id="highest_price" value="<?php echo e(isset($highest_price) ? $highest_price : 0); ?>" >
<input type="hidden" id="age_restrictions" placeholder="Age" value="<?php echo e(isset($age_restrictions) ? $age_restrictions : ''); ?>" >
<input type="hidden" id="rating" placeholder="Rating" value="<?php echo e(isset($rating) ? $rating : ''); ?>" >
<input type="hidden" id="seller" placeholder="Seller" value="<?php echo e(isset($seller) ? $seller : ''); ?>" >
<input type="hidden" id="brand" placeholder="Brand" value="<?php echo e(isset($brand) ? $brand : ''); ?>" >
<input type="hidden" id="brands" placeholder="Search Brand" value="<?php echo e(isset($brands) ? $brands : ''); ?>" >
<input type="hidden" id="sellers" placeholder="Search By Seller" value="<?php echo e(isset($sellers) ? $sellers : ''); ?>" >
<input type="hidden" name="mg" id="mg" value="<?php echo e(isset($mg) ? $mg : ''); ?>">
<input type="hidden" id="lowest_mg" value="<?php echo e(isset($lowest_mg) ? $lowest_mg : 0); ?>" >
<input type="hidden" id="highest_mg" value="<?php echo e(isset($highest_mg) ? $highest_mg : 0); ?>" >
<input type="hidden" id="price_drop" value="<?php echo e($pdrop_filt_stat); ?>" />
<input type="hidden" id="product_search" value="<?php echo e($product_search); ?>" />
<input type="hidden" id="state" value="<?php echo e(isset($state) ? $state : ''); ?>" />
<input type="hidden" id="city" value="<?php echo e(isset($city) ? $city : ''); ?>" />   

<input type="hidden" id="spectrum" value="<?php echo e(isset($spectrum) ? $spectrum : ''); ?>" />
<input type="hidden" id="statelaw" value="<?php echo e(isset($statelaw) ? $statelaw : ''); ?>" />
<input type="hidden" id="best_sellerval" value="<?php echo e($bestseller_filt_stat); ?>" />
<input type="hidden" id="chows_choiceval" value="<?php echo e($chowchoice_filt_stat); ?>" />


<input type="hidden" id="reported_effects" name="reported_effects" value="<?php echo e(isset($reported_effects)?$reported_effects:''); ?>" />
<input type="hidden" id="cannabinoids" name="cannabinoids" value="<?php echo e(isset($cannabinoids)?$cannabinoids:''); ?>" />

<input type="hidden" id="featured_option" name="featured_option" value="<?php echo e(isset($featured)?$featured:''); ?>" />



<?php
 $login_user = Sentinel::check();


?>

  <?php if(isset($sellers) || isset($seller)): ?>
     
      <div class="seller-banner-img-listpage spacetop-inx">
        <div class="container">
        <div class="seller-banner-imgmains">
        
          <?php
           
       
            if(isset($arr_seller_banner) && !empty($arr_seller_banner) && file_exists(base_path().'/uploads/seller_banner/'.$arr_seller_banner['image_name']) && $arr_seller_banner['image_name']!="")
            {             
              $banner_img = $arr_seller_banner['image_name'];              
              $img_path =url('/uploads/seller_banner/'.$arr_seller_banner['image_name']);
            }
            else
            {
              $banner_img = 'chow-bnr-img-large.jpg';
              $img_path =url('/').'/assets/front/images/chow-bnr-img-large.jpg';
            }

           

        ?>
          <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($img_path); ?>" alt="Image">

        </div>
        
        <div class="seller-body-content-text"> 
          <?php
          $count = $total_rating = 0;

          if(!empty($seller_details) && isset($seller_details)){
                 $fname = $seller_details['first_name']; 
                 $lname = $seller_details['last_name'];   
                 $seller_state_name = isset($seller_details['get_state_detail']['name'])?$seller_details['get_state_detail']['name']:'';
                 $seller_city = isset($seller_details['city'])?$seller_details['city']:'';    


          }
           if(isset($arr_reviews_products) && isset($arr_reviews_products)){
                $count = count($arr_reviews_products);  
          }

       
          if((isset($admin_product_rating) && $admin_product_rating!=0)  && isset($avg_rating) && $avg_rating > 0)
          {

              

              if(isset($admin_product_review) && $admin_product_review!=0)
              {
                 $count = $count + $admin_product_review;

              }
              else
              {
                $count = $count;
              }

              $total_rating = floatval($avg_rating) + floatval($admin_product_rating);


              $avg_rating = $total_rating/2;

              $avg_rating = round_rating_in_half($avg_rating);     
              

          }else if(isset($admin_product_rating) && $admin_product_rating!=0){

              if(isset($admin_product_review)&& $admin_product_review!=0)
              {
                  $count = $count + $admin_product_review;
              }else{
                  $count = $count;
               }

             

              $total_rating = floatval($admin_product_rating);

              $avg_rating = $total_rating;

              $avg_rating = round_rating_in_half($avg_rating);      


          }
          else
          {
               if(isset($avg_rating)){
                 $avg_rating = round_rating_in_half($avg_rating);
               }
               else
               {
                  $avg_rating = '0';
               }
         }



          if(isset($avg_rating) && $avg_rating > 0)
          {
            
            $img_avg_rating = "";
            
            // if($avg_rating=='1') $img_avg_rating = "star-rate-one.svg";
            // else if($avg_rating=='2')  $img_avg_rating = "star-rate-two.svg";
            // else if($avg_rating=='3')  $img_avg_rating = "star-rate-three.svg";
            // else if($avg_rating=='4')  $img_avg_rating = "star-rate-four.svg";
            // else if($avg_rating=='5')  $img_avg_rating = "star-rate-five.svg";
            // else if($avg_rating=='0.5')  $img_avg_rating = "star-rate-zeropointfive.svg";
            // else if($avg_rating=='1.5')  $img_avg_rating = "star-rate-onepointfive.svg";
            // else if($avg_rating=='2.5')  $img_avg_rating = "star-rate-twopointfive.svg";
            // else if($avg_rating=='3.5')  $img_avg_rating = "star-rate-threepointfive.svg";
            // else if($avg_rating=='4.5')  $img_avg_rating = "star-rate-fourpointfive.svg";
             $img_avg_rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';
 
          }
          
          ?>

          <div class="title-slrtxtmns">
               <?php echo e(isset($business_details['business_name'])?$business_details['business_name']:''); ?>

          </div>

          <div class="sbtitlreview">
                <?php if((isset($seller_city) && !empty($seller_city)) && (isset($seller_state_name) && !empty($seller_state_name) )): ?>
                 <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo e(ucfirst($seller_city)); ?>, <?php echo e(ucfirst($seller_state_name)); ?>

                <?php elseif((empty($seller_city)) && (isset($seller_state_name) && !empty($seller_state_name) )): ?>
                <i class="fa fa-map-marker" aria-hidden="true"></i>  <?php echo e(ucfirst($seller_state_name)); ?>

                <?php elseif((isset($seller_city) && !empty($seller_city)) && (empty($seller_state_name) )): ?>
                <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo e(ucfirst($seller_city)); ?> 
                <?php elseif(isset($seller_city) && !empty($seller_city)): ?>
                <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo e(ucfirst($seller_city)); ?>

                <?php elseif(isset($seller_state_name) && !empty($seller_state_name)): ?>
               <i class="fa fa-map-marker" aria-hidden="true"></i>  <?php echo e(ucfirst($seller_state_name)); ?>

                <?php endif; ?>
          </div>

          <div class="reviewratingslr star-chow-review">
            
            <?php
              if( isset($img_avg_rating)){
            ?>
             
             <img <?php if($avg_rating>0): ?> title="<?php echo e(isset($avg_rating)?$avg_rating:''); ?> Rating is a combination of all ratings on chow in addition to ratings on vendor site." <?php endif; ?> src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_avg_rating)?$img_avg_rating.'.svg':''); ?>" alt="Rating">  
             <?php 
                }
            ?>

            


            <?php
              if($count>0){
            ?>
            <span <?php if($count>0): ?> title="<?php echo e($count); ?> Ratings" <?php endif; ?> class="count-rw-seller"><?php echo e(isset($count)?$count:'0'); ?></span>
            <?php
              }
            ?>

          </div>
          <div class="following-btn-main">

            <?php 
             // dd($follow_seller_arr);
            $follow_arr    = array();
             if(count($follow_seller_arr)>0)
            {
             foreach($follow_seller_arr as $key=>$value)
             {
               $follow_arr[] = $value['seller_id'];
             }

            }
            ?>


            <?php if(isset($login_user) && $login_user == true): ?>
               <?php if($login_user->inRole('buyer') == true && isset($get_loginuserinfo) && !empty($get_loginuserinfo)): ?>

                  <?php if(isset($sellers) || isset($seller)): ?>  
                    <?php if(isset($seller_details) && !empty($seller_details)): ?>

                      <?php 
                        if(isset($follow_arr) && in_array($seller_details['id'], $follow_arr)){
                      ?>
                         <a href="javascript:void(0)" class="followsr-btns" data-id="<?php echo e(isset($get_loginuserinfo['id'])?base64_encode($get_loginuserinfo['id']):0); ?>" data-type="buyer" data-seller-id="<?php echo e(isset($seller_details['id'])?base64_encode($seller_details['id']):0); ?>" onclick="unfollow($(this));">Following</a>
                      <?php 
                        }else{
                      ?>

                     <a href="javascript:void(0)" class="followsr-btns" data-id="<?php echo e(isset($get_loginuserinfo['id'])?base64_encode($get_loginuserinfo['id']):0); ?>" data-type="buyer" data-seller-id="<?php echo e(isset($seller_details['id'])?base64_encode($seller_details['id']):0); ?>"  onclick="addToFollow($(this));" ><img src="<?php echo e(url('/')); ?>/assets/front/images/user-plus-follow.svg" alt="Follow"> Follow</a>
                     <?php } ?>

                     <?php endif; ?>
                   <?php endif; ?>  
               <?php endif; ?>
            <?php else: ?>
               <a href="<?php echo e(url('/')); ?>/login" class="followsr-btns"><img src="<?php echo e(url('/')); ?>/assets/front/images/user-plus-follow.svg" alt="Follow"> Follow</a>
            <?php endif; ?>



            <?php if(isset($login_user) && $login_user == true): ?>
            <?php if($login_user->inRole('seller') == true && isset($get_loginuserinfo) && !empty($get_loginuserinfo) && isset($get_loginuserinfo['seller_detail']['business_name']) && $get_loginuserinfo['seller_detail']['business_name']==$sellers): ?>

              <a href="<?php echo e(url('/')); ?>/seller/dispensary-image" class="follow-usr-btns upld-inx" title="Update dispensary image"><img src="<?php echo e(url('/')); ?>/assets/front/images/upload-usr-fwl.svg" alt="Dispensary Image"></a>
            <?php endif; ?>
            <?php endif; ?>
          </div>
        </div> 
         <div class="clearfix"></div>   
        <div class="line-brd"></div> 
        </div> 
        <div class="clearfix"></div>       
      </div>
     
   <?php endif; ?>



<div class="shoppage">
<div class="listing-page-main nonepaddingtop">
    <div class="container">
     


        <div id="wrapper">
            <div class="">


            <!-----------------start of shop by reviews---hide shop by reviews if chows choice,best seller or seller search is active---------------------------->

            <!-----------------end of shop by reviews--------------------->


            <!-----------------shop by spectrum------------------------------->



        



 <?php if(isset($arr_shop_by_effect) && count($arr_shop_by_effect)>0): ?> 
    <div class="top-rated-brands-main homepagenewlistings trending-products-cls-home shopbyreviewslider">
        <div class="toprtd non-mgts viewall-btns-idx toprated-view">Shop by Reviews 
            <div class="clearfix"></div>
        </div>

        <div class="featuredbrands-flex trendingproducts-section">
          <div class="nbs-flexisel-container">
            <div class="nbs-flexisel-inner">
              <ul <?php if(isset($arr_shop_by_effect) && count($arr_shop_by_effect)<=$device_count): ?>    
                 class="f-cat-below7"              
                 <?php elseif(isset($arr_shop_by_effect) && count($arr_shop_by_effect)>$device_count): ?>
                  id="flexisel792"    
                 <?php endif; ?> >
               <?php $__currentLoopData = $arr_shop_by_effect; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop_by_effect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <div class="shop-by-effect-main-parnts li-review-none">  
                            <div class="shop-by-effect-main">
                              <a href="<?php echo e(isset( $shop_by_effect['link_url'])?ucwords($shop_by_effect['link_url']):''); ?>" target="_blank">
                                <div class="shop-by-effect-img">
                                  <?php if(file_exists(base_path().'/uploads/shop_by_effect/'.$shop_by_effect['image']) && isset($shop_by_effect['image'])): ?>
                                  <img src="<?php echo e(url('/')); ?>/uploads/shop_by_effect/<?php echo e($shop_by_effect['image']); ?>" 
                                  alt="<?php echo e(isset( $shop_by_effect['title'])?$shop_by_effect['title']:''); ?>" />
                                  <?php endif; ?>
                                  
                                </div>
                                <div class="shop-by-effect-content">                       
                                    <div class="titlebrds"><?php echo e(isset( $shop_by_effect['title'])?ucwords($shop_by_effect['title']):''); ?></div>                           
                                    <span><?php echo e(isset( $shop_by_effect['subtitle'])?$shop_by_effect['subtitle']:''); ?></span>                           
                                  </div>
                              </a>
                            </div> 
                      </div> 
                </li>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          </div>
        </div>
    </div>
  <?php endif; ?> 

<!-----------------end of shop by spectrum------------------------------->

              

                <!-------------------banner start--------------------------------------->
                <?php if(isset($brands) || (isset($filterby_price_drop) && $filterby_price_drop==true ) || isset($category_id) || isset($price) || isset($mg) ||  isset($spectrum) || isset($statelaw) || isset($rating) || (isset($best_seller) && $best_seller==true) || (isset($chows_choice) && $chows_choice==true) || (isset($featured) && 
                $featured == true) || isset($reported_effects) && !empty($reported_effects) || isset($cannabinoids) && !empty($cannabinoids)): ?>

                <?php else: ?>
                 
                     <?php if(isset($banner_images_data) && !empty($banner_images_data)): ?>
                     <?php

                     if (isset($banner_images_type) && $banner_images_type != "" && $banner_images_type == "chows_choice") {
                       
                        $banner_image_desktop = $banner_images_data['banner_image9_desktop'];
                        $banner_image_mobile  = $banner_images_data['banner_image9_mobile'];
                     }
                     elseif (isset($banner_images_type) && $banner_images_type != "" && $banner_images_type == "best_seller") {
                       
                        $banner_image_desktop = $banner_images_data['banner_image10_desktop'];
                        $banner_image_mobile  = $banner_images_data['banner_image10_mobile'];

                     } 
                     elseif (isset($banner_images_type) && $banner_images_type != "" && $banner_images_type == "both") {
                       
                        $banner_image_desktop = $banner_images_data['banner_image5_desktop'];
                        $banner_image_mobile  = $banner_images_data['banner_image5_mobile'];
                     }
                     else {

                        $banner_image_desktop = $banner_images_data['banner_image5_desktop'];
                        $banner_image_mobile  = $banner_images_data['banner_image5_mobile'];
                     }

                     ?>

                       <?php if(isset($banner_images_type) && $banner_images_type != "" && $banner_images_type == "sellers"): ?> 
                       <?php else: ?>


                       <?php if(isset($banner_image_desktop) && !empty($banner_image_desktop) && isset($banner_image_mobile) && !empty($banner_image_mobile)): ?> 
                         <div class="clearfix"></div>
                         <div class="space100"></div>
                         <div class="clearfix"></div>
                          <div class="adclass-maindiv">

                             <a <?php if(isset($banner_images_data['banner_image5_link5'])): ?>  href="<?php echo e($banner_images_data['banner_image5_link5']); ?>" target="_blank" 
                             <?php else: ?>  href="#" <?php endif; ?>>

                              <figure class="cw-image__figure">
                                 <picture>

                                   <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_image_mobile) && isset($banner_image_mobile)): ?> 

                                   <?php
                                      $banner_mobile_img = image_resize('/uploads/banner_images/'.$banner_image_mobile,345,88);
                                   ?>

                                    

                                    <source type="image/png" srcset="<?php echo e($banner_mobile_img); ?>" media="(max-width: 621px)">
                                    <source type="image/jpg" srcset="<?php echo e($banner_mobile_img); ?>" media="(max-width: 621px)">
                                     <source type="image/jpeg" srcset="<?php echo e($banner_mobile_img); ?>" media="(max-width: 621px)">  

                                   <?php endif; ?>
                                   
                                   <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_image_desktop) && isset($banner_image_desktop)): ?>   
                                     
                                    <?php
                                      $banner_desktop_img = '';
                                      $banner_desktop_img = image_resize('/uploads/banner_images/'.$banner_image_desktop,1210,350);
                                    ?> 

                                  


                                    <source type="image/png" srcset="<?php echo e($banner_desktop_img); ?>" media="(min-width: 622px) and (max-width: 834px)">
                                    <source type="image/jpg" srcset="<?php echo e($banner_desktop_img); ?>" media="(min-width: 622px) and (max-width: 834px)">
                                    <source type="image/jpeg" srcset="<?php echo e($banner_desktop_img); ?>" media="(min-width: 622px) and (max-width: 834px)">
                                     
                                   <?php endif; ?>

                                    <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_image_desktop) && isset($banner_image_desktop)): ?> 

                                      <?php

                                         $banner_img_desktop = '';
                                         $banner_img_desktop = image_resize('/uploads/banner_images/'.$banner_image_desktop,1210,350);
                                      ?> 

                                     
                                     

                                      <img class="cw-image cw-image--loaded obj-fit-polyfill lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" alt="slider image" aria-hidden="false" data-src="<?php echo e($banner_img_desktop); ?>">

                                    <div class="clearfix"></div>
                                    <div class="space100"></div>   
                                    <div class="clearfix"></div>
                                    <?php endif; ?>  

                                  </picture>
                                 </figure>
                                </a>

                              </div>  
                                   
                              <?php endif; ?>
                             <?php endif; ?>  
                            <?php endif; ?>  

                          <?php endif; ?>  
                                              
                      <!----------------banner end------------------------->

                           <!-- Mobile view Filter button start -->
                           <div class="container">
                                     
  <div class="maininlinefitelr">
 <?php if(isset($brands) || (isset($filterby_price_drop) && $filterby_price_drop==true ) || isset($category_id) || isset($price) || isset($mg) ||  isset($spectrum) || isset($statelaw) || isset($rating) || (isset($best_seller) && $best_seller==true) || (isset($chows_choice) && $chows_choice==true) || (isset($featured) && $featured == true) || (isset($cannabinoids) && $cannabinoids == true)): ?>
                   <div class="clearallfiter">
                      <span class="filterbutton"><a href="<?php echo e(url('/')); ?>/search"><i class="fa fa-filter"></i> Clear All Filters</a></span>
                   </div>
                 <?php endif; ?>
                 <div class="closebtnslist filternw">
                    <span class="toggle-button">
                      <span class="filterbutton filtermobilebtn"><i class="fa fa-filter"></i> Filter</span>
                      <div class="menu-bar menu-bar-top"></div>
                      <div class="menu-bar menu-bar-middle"></div>
                      <div class="menu-bar menu-bar-bottom"></div>
                    </span>
                 </div> 


                      <!--   <div class="inlinefiter">
                           <div class="form-group dropdown-state">

                            <?php if(isset($featured)): ?>
                                <a href="javascript:void(0)" class="clearfiltr" id="spectrumfilter" onclick="return clearfilter('featured');">Clear Filter</a>
                            <?php endif; ?> 
                           
                            <div class="select-style">
                              <select class="frm-select" id="featured" name="featured" onchange="changeFeatured($(this));">

                                 <option value="">Sort By</option>

                                 <option value="hight_to_low" <?php if(isset($featured) && $featured=="hight_to_low"): ?> selected <?php endif; ?>>Price: High to Low</option>

                                 <option value="low_to_high" <?php if(isset($featured) && $featured=="low_to_high"): ?> selected <?php endif; ?>>Price: Low to High</option>

                                    

                                 <option value="new_arrivals" <?php if(isset($featured) && $featured=="new_arrivals"): ?> selected <?php endif; ?>>Newest Arrivals</option>    

                              </select> 
                            </div>
                          </div>
                        </div> -->
                <div class="clearfix none-clearfix"></div>
                </div>

                           </div>
                           <!-- Mobile view Filter button End -->


                            <!-- start you may like -->

                          


                      <!-- end you may like -->

          





<?php if(isset($brands) || (isset($filterby_price_drop) && $filterby_price_drop==true ) || isset($category_id) || isset($price) || isset($mg) ||  isset($spectrum) || isset($statelaw) || isset($rating) || (isset($best_seller) && $best_seller==true) || (isset($chows_choice) && $chows_choice==true ) || (isset($featured) && $featured == true)|| (isset($cannabinoids) && $cannabinoids == true)): ?> 

  

<?php endif; ?>



                <?php echo $__env->make('front.product.front_sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="none-div">
                 <?php if(isset($brands) || (isset($filterby_price_drop) && $filterby_price_drop==true ) || isset($category_id) || isset($price) || isset($mg) ||  isset($spectrum) || isset($statelaw) || isset($rating) || (isset($best_seller) && $best_seller==true) || (isset($chows_choice) && $chows_choice==true) || (isset($featured) && $featured == true) || (isset($cannabinoids) && $cannabinoids == true)): ?>
                   <div class="clearallfiter">
                      <span class="filterbutton"><a href="<?php echo e(url('/')); ?>/search"><i class="fa fa-filter"></i> Clear All Filters</a></span>
                   </div>
                 <?php endif; ?>
                 <div class="closebtnslist filternw">
                    <span class="toggle-button">
                      <span class="filterbutton filtermobilebtn"><i class="fa fa-filter"></i> Filter</span>
                      <div class="menu-bar menu-bar-top"></div>
                      <div class="menu-bar menu-bar-middle"></div>
                      <div class="menu-bar menu-bar-bottom"></div>
                    </span>
                 </div> 
                 </div>


                  <div class="col-9-list">
                  
                 
                     <div class="col-md-12">
                           <div class="form-group dropdown-state">

                            <?php if(isset($featured)): ?>
                                <a href="javascript:void(0)" class="clearfiltr" id="spectrumfilter" onclick="return clearfilter('featured');">Clear Filter</a>
                            <?php endif; ?> 
                           
                            <div class="select-style">
                              <select class="frm-select" id="featured" name="featured" onchange="changeFeatured($(this));">

                                 <option value="">Sort By</option>

                                 <option value="hight_to_low" <?php if(isset($featured) && $featured=="hight_to_low"): ?> selected <?php endif; ?>>Price: High to Low</option>

                                 <option value="low_to_high" <?php if(isset($featured) && $featured=="low_to_high"): ?> selected <?php endif; ?>>Price: Low to High</option>

                                    

                                 <option value="new_arrivals" <?php if(isset($featured) && $featured=="new_arrivals"): ?> selected <?php endif; ?>>Newest Arrivals</option>    

                              </select> 
                            </div>
                          </div>
                        </div>
                <div class="clearfix none-clearfix"></div>


                <!-- show error message if data not found -->


                <?php if(isset($error_msg) && $error_msg!=''): ?>

                 <div class="col-md-12">
                   <span class="purple-strip"><?php echo e(isset($error_msg)?$error_msg:''); ?></span>
                 </div>
                 
                <?php endif; ?> 

                <!-------------------------------------------->

                <?php if(count($arr_data) > 0): ?>  

                       
                      <div class="tablinks-btn-main">
                        
                    
                      </div>
                        <div class="main-selectslist pd-o" style="display: none">
                          <div class="title-listingpages"> 
                            
                            
                          </div>
        
                         
                            <div class="clearfix"></div>
                        </div>
                            
                            
                        <div id="grid">
                            <div class="results-products prodtlist-update">

                              <!-----------start---show active filters------------------>

                              <?php if(isset($brands) || isset($brand) || isset($category_id) || isset($reported_effects) && !empty($reported_effects) || isset($cannabinoids) && !empty($cannabinoids) || isset($price) || isset($mg) || isset($spectrum) || isset($statelaw) || (isset($best_seller) && $best_seller==true) || (isset($chows_choice) && $chows_choice==true) || (isset($filterby_price_drop) && $filterby_price_drop==true) || isset($featured) && $featured == true ||isset($rating) && $rating == true): ?>


                               <div class="tags-section-index-div diplay-block">
                                <div class="tags-section-div">
                                  <?php if(isset($brands) && isset($brand_details[0]['name'])): ?> 
                                     <span>  <a> <?php echo e($brand_details[0]['name']); ?> <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('brands');"/></a> </span>
                                  <?php elseif(isset($brand)): ?> 
                                     <span>   <a> <?php echo e($brand_details[0]['name']); ?> <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('brand');"/></a> </span>

                                  <?php endif; ?>

                                  
                                    
                                  




                                   <?php if(isset($category_id)): ?>

                                   <span> <a><?php echo e(get_first_levelcategorydata_by_name($category_id)); ?> 
                                    <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('category');"/></a></span>

                                    
                                   <?php endif; ?>


                                  <?php if(isset($reported_effects) && !empty($reported_effects)): ?>
                                   <span> <a> <?php echo e(rtrim($reported_effects,"- ")); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('reported_effects');" /></a> </span>
                                  <?php endif; ?>

                                  <?php if(isset($cannabinoids) && !empty($cannabinoids)): ?>
                                   <span> <a> <?php echo e(rtrim($cannabinoids,"- ")); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('cannabinoids');" /></a> </span>
                                  <?php endif; ?>

                                  <?php if(isset($price) && !empty($price)): ?>

                                    <?php
                                       $imploded_price =''; 
                                       if(isset($price) && !empty($price))
                                       {
                                         $exp_price = explode("-",$price);
                                         if(isset($exp_price[0]) && isset($exp_price[1]))
                                         {
                                            $imploded_price = "$ ".$exp_price[0].' - '."$ ".$exp_price[1];
                                         }//if exp
                                       } 
                                    ?>

                                  <span><a> <?php echo e($imploded_price); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('price');" /> </a></span>
                                  <?php endif; ?>

                                   <?php if(isset($mg) && !empty($mg)): ?>

                                   <?php
                                       $imploded_mg =''; 
                                       if(isset($mg) && !empty($mg))
                                       {
                                         $exp_mg = explode("-",$mg);
                                         if(isset($exp_mg[0]) && isset($exp_mg[1]))
                                         {
                                            $imploded_mg = $exp_mg[0].' mg - '.$exp_mg[1].' mg';
                                         }//if exp
                                       } 
                                    ?>


                                  <span><a> <?php echo e($imploded_mg); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('mg');" /> </a></span>
                                  <?php endif; ?>

                                   <?php if(isset($spectrum)): ?>
                                  <span><a> <?php echo e($spectrum); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('spectrum');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($statelaw)): ?>
                                  <span><a><?php echo e($statelaw); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('statelaw');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($best_seller) && $best_seller==true): ?> 
                                  <span><a>Best Seller <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('best_sellerval');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($chows_choice) && $chows_choice==true): ?> 
                                  <span><a> Chow's Choice <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('chows_choiceval');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($filterby_price_drop) && $filterby_price_drop==true): ?> 
                                  <span><a> Todays Deals <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('price_drop');" /></a></span>
                                  <?php endif; ?>


                                  <?php if(isset($featured) && $featured == true): ?> 

                                  <?php
                                    
                                    
                                    if($featured == 'low_to_high')
                                    {
                                       $featured = 'Low To High';
                                    }

                                    if($featured == 'hight_to_low')
                                    {
                                      $featured = 'High To Low';
                                    }

                                    if($featured == 'avg_customer_review')
                                    {
                                        $featured = 'Avg Customer Rating';
                                    }

                                    if($featured == 'new_arrivals')
                                    {
                                       $featured = 'Newest Arrivals';
                                    }

                                  ?>


                                  <span><a><?php echo e($featured); ?><img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('featured');" /></a></span>
                                  <?php endif; ?>


                                  <?php 
                                   $ratingval = $img_avg_ratingval ='';

                                  ?>

                                  <?php if(isset($rating) && !empty($rating)): ?>
                                    <?php 
                                      $ratingval = base64_decode($rating);

                                      // if($ratingval=='1') $img_avg_ratingval = "star-rate-one.svg";
                                      // else if($ratingval=='2')  $img_avg_ratingval = "star-rate-two.svg";
                                      // else if($ratingval=='3')  $img_avg_ratingval = "star-rate-three.svg";
                                      // else if($ratingval=='4')  $img_avg_ratingval = "star-rate-four.svg";
                                      // else if($ratingval=='5')  $img_avg_ratingval = "star-rate-five.svg";
                                      // else if($ratingval=='0.5')  $img_avg_ratingval = "star-rate-zeropointfive.svg";
                                      // else if($ratingval=='1.5')  $img_avg_ratingval = "star-rate-onepointfive.svg";
                                      // else if($ratingval=='2.5')  $img_avg_ratingval = "star-rate-twopointfive.svg";
                                      // else if($ratingval=='3.5')  $img_avg_ratingval = "star-rate-threepointfive.svg";
                                      // else if($ratingval=='4.5')  $img_avg_ratingval = "star-rate-fourpointfive.svg";
                                      $img_avg_ratingval = isset($ratingval)?get_avg_rating_image($ratingval):'';

                                    ?>

                                     <span><a> 

                                      <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_avg_ratingval)?$img_avg_ratingval.'.svg':''); ?> " width="80px" /> 

                                      <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('rating');" /></a></span>

                                  <?php endif; ?>

                                </div> <!---tags-section-div----->
                              </div> <!---tags-section-index-div----->
                              <?php endif; ?>

                              <!--------------end show active filters--------------->
                              <?php if(isset($category_id)): ?>
                              <div class="brand-category-headercateg">
                                <h1><?php echo e(get_first_levelcategorydata_by_name($category_id)); ?></h1>
                              <span> <?php echo get_first_levelcategory_description($category_id) ?></span>
                              </div>
                              <?php elseif(isset($brands) && isset($brand_details[0]['name'])): ?>

                                <div class="brand-category-headercateg space-left-image-brand">

                                    <!--------start----Show brand image------------------>

                                     <?php
                                     $brandimg_path= $brand_img ='';
                                     if(isset($brand_details[0]['image']) && !empty($brand_details[0]['image']) && file_exists(base_path().'/uploads/brands/'.$brand_details[0]['image']) && $brand_details[0]['image']!="")
                                      {             
                                        $brand_img = $brand_details[0]['image'];              
                                        $brandimg_path =url('/uploads/brands/'.$brand_details[0]['image']);
                                      }                                    
                                    ?>
                                    <?php if(isset($brandimg_path) && !empty($brandimg_path)): ?>
                                      <div class="show-brand-image">
                                        <img class="lozad" data-src="<?php echo e($brandimg_path); ?>" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" alt="Image"> 
                                      </div>  
                                     <?php endif; ?>
                                     <!--------end show brand image---------------->



                                  <h1><?php echo e($brand_details[0]['name']); ?></h1>
                                  <?php
                                  $arr_aggregate_rating = get_aggregate_rating('brands',Request::all());
                                  if(isset($arr_aggregate_rating['average_rating_value']) && $arr_aggregate_rating['average_rating_value'] > 0)
                                  {
                                    $img_avg_rating_brand = "";

                                    // if($arr_aggregate_rating['average_rating_value']=='1') $img_avg_rating_brand = "star-rate-one.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='2')  $img_avg_rating_brand = "star-rate-two.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='3')  $img_avg_rating_brand = "star-rate-three.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='4')  $img_avg_rating_brand = "star-rate-four.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='5')  $img_avg_rating_brand = "star-rate-five.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='0.5')  $img_avg_rating_brand = "star-rate-zeropointfive.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='1.5')  $img_avg_rating_brand = "star-rate-onepointfive.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='2.5')  $img_avg_rating_brand = "star-rate-twopointfive.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='3.5')  $img_avg_rating_brand = "star-rate-threepointfive.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='4.5')  $img_avg_rating_brand = "star-rate-fourpointfive.svg";

                                    $img_avg_rating_brand = isset($arr_aggregate_rating['average_rating_value'])?get_avg_rating_image($arr_aggregate_rating['average_rating_value']):'';
 
                                  
                                  ?>
                                    <div class="starthomlist posinbottoms" <?php if($arr_aggregate_rating['average_rating_value']>0): ?> title="<?php echo e(isset($arr_aggregate_rating['average_rating_value'])?$arr_aggregate_rating['average_rating_value']:''); ?> Rating is a combination of all ratings on chow in addition to ratings on vendor site." <?php endif; ?>> 
                                      

                                        <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_avg_rating_brand)?$img_avg_rating_brand.'.svg':''); ?>" alt="<?php echo e(isset($img_avg_rating_brand)?$img_avg_rating_brand:''); ?>" width="80px">  

                                         <?php if($arr_aggregate_rating['review_count'] > 0): ?>
                                         <span href="#" class="str-links starcounts" 
                                            title=" <?php if($arr_aggregate_rating['review_count']==1): ?>  
                                                    <?php echo e($arr_aggregate_rating['review_count']); ?> Rating 
                                                    <?php elseif($arr_aggregate_rating['review_count']>1): ?>  
                                                    <?php echo e($arr_aggregate_rating['review_count']); ?> Ratings 
                                                    <?php endif; ?>
                                                  ">
                                            <?php if($arr_aggregate_rating['review_count']==1): ?>       
                                            <?php echo e($arr_aggregate_rating['review_count']); ?> Rating
                                            <?php elseif($arr_aggregate_rating['review_count']>1): ?>  
                                             <?php echo e($arr_aggregate_rating['review_count']); ?> Ratings
                                            <?php endif; ?> 
                                          </span>
                                         <?php endif; ?>
                                      </div>
                                  <?php
                                  }
                                  ?>

                                  <span><?php echo $brand_details[0]['description'] ?></span>
                                </div>
                              <?php endif; ?>

                                

                            <?php
                              $login_user = Sentinel::check();
                              if(isset($fav_product_arr)){
                              $fav_arr    = array();
                               if(count($fav_product_arr)>0)
                              {
                               foreach($fav_product_arr as $key=>$value)
                               {
                                 $fav_arr[] = $value['product_id'];
                               }

                              }
                            }

                            $shop_brandname ='';
                            $shop_sellername ='';
                            $pageclick = [];

                            $k=1;

                            ?>

                             
                            <?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kv=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                 <?php  
                                  
                                   $firstcat_id = $product['first_level_category_id'];
                                   $restrictseller_id   = $product['user_id'];


                                      $avg_rating = get_avg_rating($product['id']);

                                      // if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}else
                                      // if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}

                                       $rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';

                                      $total_review = get_total_reviews($product['id']);  
                                      if($total_review>0)
                                        $total_review = $total_review;
                                      else
                                         $total_review = '';

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

                                       $checkseller_flag = 0;
                                       if(isset($state_user_ids) && !empty($state_user_ids))
                                       {
                                          if(in_array($restrictseller_id, $state_user_ids))
                                          { 

                                            $checkseller_flag = 1;
                                          }
                                          else
                                          {
                                            $checkseller_flag = 0;
                                          }
                                       }

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


                                    $shop_brandname = isset($product['get_brand_detail']['name'])?str_slug($product['get_brand_detail']['name']):'';  

                                    $shop_sellername = isset($product['get_seller_additional_details']['business_name'])?str_slug($product['get_seller_additional_details']['business_name']):'';   

                                     $is_besesellershop = check_isbestseller($product['id']);

                                     $shop_seller_concentration = isset($product['per_product_quantity']) ? $product['per_product_quantity'].'mg' : '' ;


                                     

                                  ?>

                                  

                                  <div   <?php if($checkfirstcat_flag==1): ?> class="product-holder-list checkrestrictionclass" <?php else: ?> class="product-holder-list" <?php endif; ?>>

                                  <?php if(isset($login_user) && $login_user == true && $login_user->inRole('buyer')): ?>
                                     <?php if($checkfirstcat_flag==0): ?> 
                                      
                                     <?php endif; ?>
                                   <?php else: ?>
                                       
                                   <?php endif; ?> 


                                    <?php if(isset($product['is_chows_choice']) && $product['is_chows_choice']==1): ?>
                                       <div class="out-of-stock trending-left">
                                          <span class="b-class-hide"><img src="<?php echo e(url('/')); ?>/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                                        </div>
                                    <?php endif; ?>  



                                    <div class="reltv-div">
                                      <div class="">

                                            <?php if($login_user == true): ?>
                                            <?php if($login_user->inRole('buyer')): ?>
                                                 <?php if(isset($fav_arr) && in_array($product['id'],$fav_arr)): ?>
                                                 
                                                  <a href="javascript:void(0)" class="heart-icn active" data-id="<?php echo e(isset($product['id'])?base64_encode($product['id']):0); ?>" data-type="buyer" onclick="removeFromFavorite($(this));">
                                                     <i class="fa fa-heart"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="javascript:void(0)" class="heart-icn" data-id="<?php echo e(isset($product['id'])?base64_encode($product['id']):0); ?>" data-type="buyer" onclick="addToFavorite($(this));">
                                                        <i class="fa fa-heart"></i>
                                                    </a>
                                                <?php endif; ?>    
                                            <?php endif; ?>
                                            <?php else: ?>
                                              <a href="javascript:void(0)" class="heart-icn" data-id="<?php echo e(isset($product['id'])?base64_encode($product['id']):0); ?>" data-type="product" onclick="addToFavorite($(this));">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            <?php endif; ?>

                                         

                                            <?php  $isblur =0; ?>

                                             <?php if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0 ): ?>

                                                       <?php if(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] > 0): ?>   

                                                           <?php if($checkfirstcat_flag==1): ?>
                                                           <?php  $isblur =1; ?>
                                                              
                                                                          
                                                           <?php endif; ?>
                                                      <?php else: ?>
                                                         

                                                            <?php if($checkfirstcat_flag==1): ?>
                                                              <?php  $isblur =1; ?>
                                                            
                                                            <?php else: ?>
                                                               <?php  $isblur =1; ?>
                                                              
                                                            <?php endif; ?>

                                                         
                                                      <?php endif; ?>  
                                                    
                                              <?php else: ?>
                                                   

                                                        <?php if($checkfirstcat_flag==1): ?>
                                                          <?php  $isblur =1; ?>
                                                           
                                                        <?php else: ?>
                                                           <?php  $isblur =1; ?>
                                                            
                                                        <?php endif; ?>

                                                    
                                              <?php endif; ?>




                                          <div class="make3D">
                                              <div class="product-front">
                                                <?php
                                                  $product_title = isset($product['product_name']) ? $product['product_name'] : '';
                                                  $product_title_slug = str_slug($product_title);


                                                   $pageclick['name'] = isset($product['product_name']) ? $product['product_name'] : '';
                                                   $pageclick['id'] = isset($product['id']) ? $product['id'] : '';
                                                   $pageclick['brand'] = isset($product['brand']) ? get_brand_name($product['brand']) : '';
                                                   $pageclick['category'] = isset($product['first_level_category_id']) ? get_first_levelcategorydata($product['first_level_category_id']) : '';

                                                    if(isset($product['price_drop_to']))
                                                    {
                                                       if($product['price_drop_to']>0)
                                                       {
                                                         $pageclick['price'] = isset($product['price_drop_to']) ? num_format($product['price_drop_to']) : '';
                                                       }else
                                                       {
                                                        $pageclick['price'] = isset($product['unit_price']) ? num_format($product['unit_price']) : '';
                                                       }
                                                     
                                                    }
                                                    else
                                                    {
                                                      $pageclick['price'] = isset($product['unit_price']) ? num_format($product['unit_price']) : '';
                                                    }

                                                   //$pageclick['position'] = $i;
                                                   // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($product['id']).'/'.$product_title_slug.'/'.$shop_brandname.'/'.$shop_sellername ;
                                                   $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($product['id']).'/'.$product_title_slug;



                                                ?>
                                                  
                                                  <a href="<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($product['id'])?base64_encode($product['id']):''); ?>/<?php echo e($product_title_slug); ?>" title="<?php echo e(isset($product['product_name']) ? $product['product_name'] : ''); ?>"  onclick="return productclick(<?php echo e(isset($pageclick)?json_encode($pageclick):''); ?>)">
                                                   <div class="owl-carousel owl-theme">
                                                    <div <?php if(isset($isblur) && $isblur==1): ?> class="img-cntr item blurclass" <?php else: ?> class="img-cntr item" <?php endif; ?>>

                                                      <!------------For blur product----------->
                                                      <?php if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0 ): ?>

                                                         <?php if(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] > 0): ?>   

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
                                                        <!--------For blur product------------>


                                                     


                                                    <?php
                                                       if(isset($product['product_images_details'][0]['image']) && $product['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_images_details'][0]['image']))
                                                          {
                                                                $product_img = url('/uploads/product_images/'.$product['product_images_details'][0]['image']);

                                                                //resize img

                                                                $final_product_image = image_resize('/uploads/product_images/'.$product['product_images_details'][0]['image'],150,150);  
                                                          }
                                                          else
                                                          {                  
                                                              $final_product_image = url('/assets/images/default-product-image.png');
                                                          }


                                                 ?>

                                                      <img  data-src="<?php echo e($final_product_image); ?>" class="portrait lozad" alt="<?php echo e(isset($product['product_name']) ? $product['product_name'] : ''); ?>" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>"/>
                                                      
                                                  </div>
                                                  </div>

                                                   <!---------------show brand name here----------->
                                                    </a> 
                                                    
                                                     <?php    
                                              $connabinoids_name = get_product_cannabinoids($product['id']);

                                              // $connabinoids_name = get_product_cannabinoids_name($product['id']);
                                              ?>
                                              <?php if(isset($connabinoids_name) && count($connabinoids_name) > 0): ?>
                                                    <div class="inlineblock-view-cannabionoids">
                                                       <span class="inline-trend-product">
                                                            <?php
                                                              $i = 0;
                                                              // $numItems = count($connabinoids_name);
                                                            ?>

                                                            <span class="oil-category-cannabinoids concentration-color"><?php echo e(isset($product['per_product_quantity'])?$product['per_product_quantity']:''); ?>mg</span>

                                                              <?php $__currentLoopData = $connabinoids_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cann): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                                  <span class="oil-category-cannabinoids"> <?php echo e($cann['name']); ?> <?php echo e(floatval($cann['percent'])); ?>%</span>
                                                               
                                                              
                                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </span>
                                                    </div>
                                              <?php endif; ?>

                                                   
                                                   <a href="<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($product['id'])?base64_encode($product['id']):''); ?>/<?php echo e($product_title_slug); ?>" title="<?php echo e(isset($product['product_name']) ? $product['product_name'] : ''); ?>" onclick="return productclick(<?php echo e(isset($pageclick)?json_encode($pageclick):''); ?>)">
                                                  <div class="content-pro-img">
                                                    <?php
                                                      $prod_name = isset($product['product_name']) ? ucwords($product['product_name']): '';   
                                                      $prod_desc = isset($product['description']) ? ucfirst($product['description']): '';   
                                                      
                                                      $prod_name_limited = str_limit($prod_name,42);
                                                      
                                                    ?> 
                                                      

                                                      <div class="title-chw-list">
                                                         <?php
                                                          $brand_name = isset($product['get_brand_detail']['name'])?$product['get_brand_detail']['name']:'';
                                                          if(isset($brand_name)){
                                                            $brandname = str_replace(' ','-',$brand_name); 
                                                          }

                                                         ?>

                                                       

                                                         <span class="titlename-list"> 
                                                          <?php echo e(isset($product['id'])?get_product_name($product['id']):''); ?>

                                                         </span>

                                                      </div>


                                                  </div>
                                                 </a>


                                                    <p class="bybrandbylink"> 
                                                      <span>
                                                     
                                                         <?php
                                                          $brand_name = isset($product['get_brand_detail']['name'])?$product['get_brand_detail']['name']:'';
                                                          if(isset($brand_name)){
                                                            $brandname = str_replace(' ','-',$brand_name); 
                                                          }

                                                         ?>

                                                      </span>
                                                    </p> 

                                                 

                                                    <div class="price-listing"> 
                                                      <?php if(isset($product['price_drop_to'])): ?>
                                                        <?php if($product['price_drop_to']>0): ?>
                                                            <?php
                                                             if(isset($product['percent_price_drop']) && $product['percent_price_drop']=='0.000000') 
                                                             {
                                                             $percent_price_drop = calculate_percentage_price_drop($product['id'],$product['unit_price'],$product['price_drop_to']); 
                                                             $percent_price_drop = floor($percent_price_drop);
                                                             }
                                                             else
                                                             { 
                                                              $percent_price_drop = floor($product['percent_price_drop']);
                                                             }
                                                             ?>
                                                             <span>$<?php echo e(isset($product['price_drop_to']) ? num_format($product['price_drop_to']) : '0'); ?> </span> 
                                                          <del class="pricevies inline-del">$<?php echo e(isset($product['unit_price']) ? num_format($product['unit_price']) : '0'); ?></del>
                                                            
                                                           <br>
                                                          
                                                        <?php else: ?>
                                                        <span>$<?php echo e(isset($product['unit_price']) ? num_format($product['unit_price']) : '0'); ?> </span>
                                                        <del class="pricevies hidepricevies"></del>
                                                          
                                                        <?php endif; ?>
                                                      <?php else: ?>
                                                      <span>$<?php echo e(isset($product['unit_price']) ? num_format($product['unit_price']) : '0'); ?> </span>
                                                      <del class="pricevies hidepricevies"></del>
                                                        
                                                      <?php endif; ?>  
                                                   </div>

                                                   <!-------------end of brand name---------->
                                                <!-----------truck---------------->
                                                <?php if(isset($product['shipping_type']) && $product['shipping_type']==0): ?>
                                                 <?php 
                                                      $setshippingtop = "";
                                                      if($product['shipping_type']==0)
                                                      { $setshippingtop = "Free Shipping";
                                                      }
                                                      else{
                                                        $setshippingtop = "Flat Shipping";
                                                      }
                                                 ?>
                                                 <div class="freeshipping-class" title="<?php echo e($setshippingtop); ?>">
                                                  Free Shipping
                                                </div>
                                                <?php endif; ?>
                                              <!----------truck----------------->
                                               <!------------rating div start--------------->    
                                              <div <?php if($avg_rating>0): ?> class="starthomlist posinbottoms"                                       
                                                title="<?php echo e(isset($avg_rating)?$avg_rating:''); ?> Rating is a combination of all ratings on chow in addition to ratings on vendor site."
                                              <?php else: ?>
                                              
                                              <?php endif; ?> >
                                                   <?php if($avg_rating>0): ?>      
                                                   

                                                    <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e($rating); ?>.svg" alt="<?php echo e($rating); ?>.svg" />

                                                    <a href="#" class="str-links starcounts" title="<?php if($total_review==1): ?><?php echo e($total_review); ?> Rating <?php elseif($total_review>1): ?> <?php echo e($total_review); ?> Ratings <?php endif; ?>">

                                                    
                                                     <?php echo e($avg_rating); ?>

                                                     <?php if(isset($total_review)): ?> (<?php echo e($total_review); ?>) <?php endif; ?>

                                                    </a>
                                                  
                                                  
                                                   
                                                  <?php if(isset($product['get_seller_additional_details']['approve_verification_status']) && $product['get_seller_additional_details']['approve_verification_status']!=0): ?>                                                
                                                  <?php endif; ?>
                                              <?php else: ?>
                                              <?php endif; ?>      
                                          </div> 
                                          <!---------------rating-div-end---------->

                                          <!--coupon code text div-->
                                            <?php
                                            $get_available_coupon = [];
                                            $get_available_coupon = get_coupon_details($product['user_id']);
                                            ?>
                                             
                                            <?php if(isset($get_available_coupon) && count($get_available_coupon)>0): ?>

                                            <div class="couponsavailable">Coupons Available</div>

                                            <?php endif; ?>
                                          <!------------------------>


                                               <!-------------cc and best seller---------------> 
                                             


                                               

                                               

 

                                              

                                               <!-- Lab results available Start -->
                                               <!--  <?php if(isset($product['product_certificate']) && !empty($product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$product['product_certificate']) ): ?>
                                                  <div class="labresults-class" style="margin-left: 0px">
                                                    <span class="b-class-hide">Lab Results Available</span>
                                                  </div>                                   
                                                <?php endif; ?>  --> 
                                              <!-- Lab results available End -->  



                                             

                                             
                                           
                                             
                                             <!----------------ebd cc and best seller--------->


                                                
                                                  <div class="clearfix"></div>
                                              </div>
                                          </div>


                                         
                                       
                                      </div>
                                    
                                                    <?php if($login_user == true): ?>

                                                      <?php if($login_user->inRole('seller') == true || $login_user->inRole('admin') == true): ?>

                                                    


                                                    <?php elseif($login_user->inRole('buyer') == true): ?>

                                                      <?php if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0): ?>
                                                   
                                                        <a class="addcart-btns" 
                                                                <?php if(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] > 0 && $checkfirstcat_flag==0): ?> 
                                                                style="display: block;" 
                                                                <?php elseif(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] > 0 && $checkfirstcat_flag==1): ?> 
                                                                style="display: none;" 
                                                                <?php elseif(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] <= 0 && $checkfirstcat_flag==0): ?> 
                                                                style="display: none;" 
                                                                 <?php elseif(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] <= 0 && $checkfirstcat_flag==1): ?> 
                                                                style="display: none;" 
                                                                
                                                                 <?php endif; ?>   
                                                                  href="javascript:void(0)" data-type="buyer" data-id="<?php echo e(isset($product['id'])?base64_encode($product['id']):0); ?>" data-type="buyer" data-qty="1" 

                                                                               

                                                                                  <?php if($checkfirstcat_flag==1): ?>

                                                                                  <?php else: ?> 
                                                                                    onclick="add_to_cart($(this))"
                                                                                  <?php endif; ?>

                                                                  
                                                             > 
                                                            
                                                              <div class="add_to_cart" id="prd_<?php echo e(isset($product['id'])?$product['id']:0); ?>">
                                                                 Add to cart
                                                               </div> 
                                                            </a>
                                                      <?php endif; ?>

                                                                                            
                                                      <?php endif; ?>

                                                  <?php else: ?>
                                                    
                                                  <?php if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0): ?>
                                                      <?php if(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] > 0): ?>

                                                             <?php if($checkfirstcat_flag==1): ?>

                                                             <?php else: ?>
                                                                

                                                                 <a href="javascript:void(0)"  data-id="<?php echo e(isset($product['id'])?base64_encode($product['id']):0); ?>" data-type="buyer" data-qty="1" onclick="add_to_cart($(this))">
                                                                     <div class="add_to_cart"  id="prd_<?php echo e(isset($product['id'])?$product['id']:0); ?>">
                                                                           Add to cart
                                                                      </div> 
                                                                 </a>
                                                                

                                                             <?php endif; ?>
                                                          <?php else: ?>
                                                               <?php if($checkfirstcat_flag==1): ?>

                                                               <?php else: ?>

                                                                   
                                                                     <div class="add_to_cart" onclick="return buyer_redirect_login_product('<?php echo e(isset($product['id'])?base64_encode($product['id']):0); ?>')"  
                                                                       <?php if(isset($product['inventory_details']['remaining_stock']) &&
                                                                        $product['inventory_details']['remaining_stock'] > 0): ?> style="display: block;" <?php else: ?> style="display: none" <?php endif; ?>> 
                                                                      Add to cart
                                                                    </div>
                                                                    
                                                               <?php endif; ?>
                                                        <?php endif; ?>  
                                                    <?php endif; ?>  

                                                    <?php endif; ?>

                                                    <?php
                                                        //dd($product['is_outofstock']);   // cbd skin care

                                                    $isblur=0;

                                                    ?>



                                                  <?php if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0 ): ?>

                                                       <?php if(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] > 0): ?>   

                                                           <?php if($checkfirstcat_flag==1): ?>
                                                           <?php  $isblur =1; ?>
                                                            
                                                           <?php endif; ?>
                                                      <?php else: ?>
                                                        

                                                            <?php if($checkfirstcat_flag==1): ?>
                                                              <?php  $isblur =1; ?>
                                                               
                                                            <?php else: ?>
                                                               <?php  $isblur =1; ?>
                                                               
                                                            <?php endif; ?>

                                                        
                                                      <?php endif; ?>  
                                                    
                                                  <?php else: ?>
                                                   

                                                        <?php if($checkfirstcat_flag==1): ?>
                                                          <?php  $isblur =1; ?>
                                                          
                                                        <?php else: ?>
                                                           <?php  $isblur =1; ?>
                                                           
                                                        <?php endif; ?>

                                                   
                                                  <?php endif; ?>

                                         
                                         
                                           
                                    </div>
                                    <div class="clearfix"></div>
                                  </div>
                                  <?php 
                                  if($kv==7){
                                 ?> 





                                 <?php 
                                     }
                                  $k++;
                                 ?> 

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                   

                                  

                            </div>
                                 <div class="pagination-chow">                                        
                                    <?php if(!empty($arr_pagination)): ?>
                                      <?php echo e($arr_pagination->render()); ?>    
                                     <?php endif; ?> 
                                  </div>

                        

                    <?php if(isset($category_id) && $category_id !=''): ?>
                      <?php
                      $arr_category_faq = get_category_faqs($category_id);

                      ?>
                      <?php if(isset($arr_category_faq) && (!empty($arr_category_faq))): ?>
                      <div class="our-mission-abts detail-faq">
                       <!--  <h1>Frequently Asked Questions</h1> -->

                        <h1>Help Center</h1> 
                        
                      </div>

                      <section class="faqsec details-faqpage">
                        <div class="">
                          <div class="">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                  
                           
                            <?php
                              $i=0;
                            ?>
                              <?php $__currentLoopData = $arr_category_faq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="heading-<?php echo e($faq['id']); ?>">
                                    <h4 class="panel-title">
                                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo e($faq['id']); ?>" <?php if($i==0): ?> aria-expanded="true" <?php else: ?> aria-expanded="false" <?php endif; ?> aria-controls="collapse-<?php echo e($faq['id']); ?>"   
                                         <?php if($i==0): ?> <?php else: ?> class="collapsed" <?php endif; ?>>
                                        <span><?php echo  $faq['question']  ?></span>
                                      </a>
                                    </h4> 
                                  </div>
                                  
                                  <div id="collapse-<?php echo e($faq['id']); ?>"  <?php if($i==0): ?> class="panel-collapse collapse in" <?php else: ?> class="panel-collapse collapse" <?php endif; ?>  role="tabpanel" aria-labelledby="heading-<?php echo e($faq['id']); ?>">
                                    <div class="panel-body">
                                     <?php echo  $faq['answer'] ?>
                                    </div>
                                  </div>
                                </div>

                              <?php
                                $i++;
                              ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
<div class="clearfix"></div>
                                   
                            </div>
                          </div> 

                         
<div class="clearfix"></div>
                        </div> 
                      </section>
                      <?php endif; ?>
                    <?php endif; ?>
                 <div class="clearfix"></div>
            </div></div>
                <?php else: ?>
                <div class="col-md-9">


                    <!---------------start---show active filters-------------------------------->

                           <?php if(isset($brands) || isset($brand) || isset($category_id) || isset($reported_effects) && !empty($reported_effects) || isset($cannabinoids) && !empty($cannabinoids) || isset($price) || isset($mg) || isset($spectrum) || isset($statelaw) || (isset($best_seller) && $best_seller==true) || (isset($chows_choice) && $chows_choice==true) || (isset($filterby_price_drop) && $filterby_price_drop==true) || isset($featured) && $featured == true ||isset($rating) && $rating == true): ?>

                              <div class="tags-section-index-div diplay-block">
                                <div class="tags-section-div">
                                  <?php if(isset($brands) && isset($brand_details[0]['name'])): ?> 
                                    <span>  <a> <?php echo e($brand_details[0]['name']); ?> <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('brands');"/></a> </span>
                                  <?php elseif(isset($brand)): ?> 
                                      <span>   <a> <?php echo e($brand_details[0]['name']); ?> <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('brand');"/></a> </span>

                                  <?php endif; ?>

                                   <?php if(isset($category_id)): ?>
                                   <span> <a><?php echo e(get_first_levelcategorydata_by_name($category_id)); ?> 
                                    <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('category');"/></a></span>
                                   <?php endif; ?>


                                  <?php if(isset($reported_effects) && !empty($reported_effects)): ?>
                                   <span> <a> <?php echo e(rtrim($reported_effects,"- ")); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('reported_effects');" /></a> </span>
                                  <?php endif; ?> 

                                  <?php if(isset($cannabinoids) && !empty($cannabinoids)): ?>
                                   <span> <a> <?php echo e(rtrim($cannabinoids,"- ")); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('cannabinoids');" /></a> </span>
                                  <?php endif; ?>

                                  <?php if(isset($price) && !empty($price)): ?>

                                   <?php
                                       $imploded_price =''; 
                                       if(isset($price) && !empty($price))
                                       {
                                         $exp_price = explode("-",$price);
                                         if(isset($exp_price[0]) && isset($exp_price[1]))
                                         {
                                            $imploded_price = "$ ".$exp_price[0].' - '."$ ".$exp_price[1];
                                         }//if exp
                                       } 
                                    ?>

                                  <span><a> <?php echo e($imploded_price); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('price');" /> </a></span>
                                  <?php endif; ?>

                                   <?php if(isset($mg) && !empty($mg)): ?>

                                    <?php
                                       $imploded_mg =''; 
                                       if(isset($mg) && !empty($mg))
                                       {
                                         $exp_mg = explode("-",$mg);
                                         if(isset($exp_mg[0]) && isset($exp_mg[1]))
                                         {
                                            $imploded_mg = $exp_mg[0].' mg - '.$exp_mg[1].' mg';
                                         }//if exp
                                       } 
                                    ?>

                                  <span><a> <?php echo e($imploded_mg); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('mg');" /> </a></span>
                                  <?php endif; ?>

                                   <?php if(isset($spectrum)): ?>
                                  <span><a> <?php echo e($spectrum); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('spectrum');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($statelaw)): ?>
                                  <span><a><?php echo e($statelaw); ?>  <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('statelaw');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($best_seller) && $best_seller==true): ?> 
                                  <span><a>Best Seller <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('best_sellerval');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($chows_choice) && $chows_choice==true): ?> 
                                  <span><a> Chow's Choice <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('chows_choiceval');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($filterby_price_drop) && $filterby_price_drop==true): ?> 
                                  <span><a> Todays Deals <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilterf('price_drop');" /></a></span>
                                  <?php endif; ?>

                                  <?php if(isset($featured) && $featured == true): ?> 

                                   <?php
                                    //$featured = '';

                                    if($featured == 'low_to_high')
                                    {
                                       $featured = 'Low To High';
                                    }

                                    if($featured == 'hight_to_low')
                                    {
                                      $featured = 'High To Low';
                                    }

                                    if($featured == 'avg_customer_review')
                                    {
                                        $featured = 'Avg Customer Rating';
                                    }

                                    if($featured == 'new_arrivals')
                                    {
                                       $featured = 'Newest Arrivals';
                                    }

                                  ?>

                                  <span><a><?php echo e($featured); ?><img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('featured');" /></a></span>
                                  <?php endif; ?>

                                  <?php 
                                   $ratingval = $img_avg_ratingval ='';
                                  ?>

                                  <?php if(isset($rating) && !empty($rating)): ?>
                                    <?php 


                                      $ratingval = base64_decode($rating);

                                      // if($ratingval=='1') 
                                      //   $img_avg_ratingval = "star-rate-one.svg";
                                      // else if($ratingval=='2')  $img_avg_ratingval = "star-rate-two.svg";
                                      // else if($ratingval=='3')  $img_avg_ratingval = "star-rate-three.svg";
                                      // else if($ratingval=='4')  $img_avg_ratingval = "star-rate-four.svg";
                                      // else if($ratingval=='5')  $img_avg_ratingval = "star-rate-five.svg";
                                      // else if($ratingval=='0.5')  $img_avg_ratingval = "star-rate-zeropointfive.svg";
                                      // else if($ratingval=='1.5')  $img_avg_ratingval = "star-rate-onepointfive.svg";
                                      // else if($ratingval=='2.5')  $img_avg_ratingval = "star-rate-twopointfive.svg";
                                      // else if($ratingval=='3.5')  $img_avg_ratingval = "star-rate-threepointfive.svg";
                                      // else if($ratingval=='4.5')  $img_avg_ratingval = "star-rate-fourpointfive.svg";

                                    $img_avg_ratingval = isset($ratingval)?get_avg_rating_image($ratingval):'';

                                    ?>

                                     <span><a> 
                                     
                                       <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_avg_ratingval)?$img_avg_ratingval.'.svg':''); ?> " width="80px" /> 
                                      <img src="<?php echo e(url('/')); ?>/assets/front/images/close-d.svg"  onclick="return clearfilter('rating');" /></a></span>
                                   <?php endif; ?>

                              </div><!-----tags-section-div-------------->
                              </div><!-----tags-section-index-div-------------->
                              <?php endif; ?>
                              <!------------------end show active filters----------------->
                              <?php if(isset($category_id)): ?>
                              <div class="brand-category-headercateg center-span">
                                <h1><?php echo e(get_first_levelcategorydata_by_name($category_id)); ?></h1>
                              <span> <?php echo get_first_levelcategory_description($category_id) ?></span>
                              </div>
                              <?php elseif(isset($brands) && isset($brand_details[0]['name'])): ?>
                                <div class="brand-category-headercateg center-span">
                                  <h1><?php echo e($brand_details[0]['name']); ?></h1>
                                  <?php
                                  $arr_aggregate_rating = get_aggregate_rating('brands',Request::all());
                                  if(isset($arr_aggregate_rating['average_rating_value']) && $arr_aggregate_rating['average_rating_value'] > 0)
                                  {
                                    $img_avg_rating_brand = "";
                                    // if($arr_aggregate_rating['average_rating_value']=='1') $img_avg_rating_brand = "star-rate-one.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='2')  $img_avg_rating_brand = "star-rate-two.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='3')  $img_avg_rating_brand = "star-rate-three.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='4')  $img_avg_rating_brand = "star-rate-four.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='5')  $img_avg_rating_brand = "star-rate-five.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='0.5')  $img_avg_rating_brand = "star-rate-zeropointfive.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='1.5')  $img_avg_rating_brand = "star-rate-onepointfive.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='2.5')  $img_avg_rating_brand = "star-rate-twopointfive.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='3.5')  $img_avg_rating_brand = "star-rate-threepointfive.svg";
                                    // else if($arr_aggregate_rating['average_rating_value']=='4.5')  $img_avg_rating_brand = "star-rate-fourpointfive.svg";

                                     $img_avg_rating_brand = isset($arr_aggregate_rating['average_rating_value'])?get_avg_rating_image($arr_aggregate_rating['average_rating_value']):'';
                                  
                                  ?>
                                    <div class="starthomlist posinbottoms" <?php if($arr_aggregate_rating['average_rating_value']>0): ?> title="This rating is a combination of all ratings on chow in addition to ratings on vendor site." <?php endif; ?>> 
                                        

                                         <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_avg_rating_brand)?$img_avg_rating_brand.'.svg':''); ?>" alt="<?php echo e(isset($img_avg_rating_brand)?$img_avg_rating_brand:''); ?>"> 

                                         <?php if($arr_aggregate_rating['review_count'] > 0): ?>
                                         <span href="#" class="str-links starcounts" 
                                            title=" <?php if($arr_aggregate_rating['review_count']==1): ?>  
                                                    <?php echo e($arr_aggregate_rating['review_count']); ?> Rating 
                                                    <?php elseif($arr_aggregate_rating['review_count']>1): ?>  
                                                    <?php echo e($arr_aggregate_rating['review_count']); ?> Ratings 
                                                    <?php endif; ?>
                                                  ">
                                            <?php if($arr_aggregate_rating['review_count']==1): ?>       
                                            <?php echo e($arr_aggregate_rating['review_count']); ?> Rating
                                            <?php elseif($arr_aggregate_rating['review_count']>1): ?>  
                                             <?php echo e($arr_aggregate_rating['review_count']); ?> Ratings
                                            <?php endif; ?> 
                                          </span>
                                         <?php endif; ?>
                                      </div>
                                  <?php
                                  }
                                  ?>
                                  <span><?php echo $brand_details[0]['description'] ?></span>
                                </div>
                              <?php endif; ?>
                  
                     <div class="empty-product-main">
                         <div class="empty-prodct">
                             <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e(url('/')); ?>/assets/front/images/empty-product.jpg" alt="Product" />
                         </div>
                         <div class="empty-product-title">
                            <?php if(isset($product_search)): ?>
                              We could not find exact matches for "<?php echo e($product_search); ?>"
                            <?php else: ?>
                               Sorry, no results found!
                            <?php endif; ?>
                            
                         </div>
                         <div class="spelling-searching">Please check the spelling or try searching for something else </div>
                     </div>
                </div>
                <?php endif; ?>


            </div>
        </div>        
    </div>
</div>
<div id="myProductModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>
      Product Name :
      <div id="prod_name">
        
      </div> 
    </p>

    <p>
      Product Quantity :
      <div id="prod_item_qty">
        
      </div> 
    </p>
    <p>
      Product Price :
      <div id="prod_price">
        
      </div> 
    </p>
    <p>
      Product image :
      <div id="product_image">
        
      </div> 
    </p>
  </div>

</div>
</div>


<?php $__env->stopSection(); ?>





<!-- start scripting part -->

<?php $__env->startSection("page_script"); ?>


  <script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/newjquery.flexisel.js"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
  <script type="text/javascript"  src="<?php echo e(url('/')); ?>/assets/front/js/lightgallery-all.min.js"></script>

  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->

  <!-- <script src="<?php echo e(url('/')); ?>/assets/front/js/owl.carousel.js"></script> -->


<script type="text/javascript">

  var useris = "<?php echo e($useris); ?>";
  var stateofuser = "<?php echo e($stateofuser); ?>";

  var _learnq = _learnq || [];
  var dataLayer = dataLayer || [];

  var loggedinuser="<?php echo e($loggedinuser); ?>";

  var _learnq = _learnq || [];

  var modal = document.getElementById("myProductModal");


  var lowest_price = $('#lowest_price').val();
  var highest_price = $('#highest_price').val();
  var min = $("#min").val(); 
  var max = $("#max").val();

  var category = $('#category').val();
  var price = $('#price').val();
  var min_selected_price = price.split('-')[0] || lowest_price;
  var max_selected_price = price.split('-')[1] || highest_price;

  var lowest_price = min_selected_price || min;   
  var highest_price = max_selected_price || max;  

  var age_restrictions = $("#age_restrictions").val();
  var brands = $("#brands").val();
  var sellers = $("#sellers").val();
  var rating = $("#rating").val();
  var brand = $("#brand").val();
  var mg = $("#mg").val();


  if ($('#filterby_price_drop').is(":checked"))
  {
    var filterby_price_drop = true;
  }
  else{
    var filterby_price_drop = false;
  } 

  var product_search = $("#product_search").val();
  var state = $("#state").val();
  var city = $("#city").val();
  var spectrum= $("#spectrum").val();
  var statelaw = $("#statelaw").val();
  var reported_effects = $("#reported_effects").val();
  var cannabinoids = $("#cannabinoids").val();
  var featured = $("#featured").val();

  if ($('#best_seller').is(":checked"))
  {
    var best_seller = true;
  }
  else{
    var best_seller = false;
  } 

   if ($('#chows_choice').is(":checked"))
  {
    var chows_choice = true;
  }
  else{
    var chows_choice = false;
  } 


  $(document).ready(function(){

 
        /*code to stop video after modal closed*/
        $('#videoModal').on('hide.bs.modal', function(e) {
            var $if = $(e.delegateTarget).find('iframe');
            var src = $if.attr("src");
            $if.attr("src", '/empty.html');
            $if.attr("src", src);
        });

        /* var screenWidth = document.documentElement.clientWidth;*/
        var screenWidth = window.screen.availWidth;
        if(parseInt(screenWidth) < parseInt(768)){
          $("#flexiselDemo1, #flexiselDemo2, #flexiselDemo5, #flexiselDemo379,#flexiselDemo125, #flexiselDemo86,#flexiselDemo121,#flexiselDemo4,#flexiselDemo44,#flexisel792").removeAttr('id');
         
          $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

        }

        $('.lightgallery').lightGallery();
 

       /*if(useris=="guestuser"){
          useCurrentlocation();
        }else if(useris=="buyer")
        {
          $("#autocompletestate").val(stateofuser);
        }*/
 });



function useCurrent_location()
  {
     navigator.geolocation.getCurrentPosition(function(position) {

      var latlng = position.coords.latitude+ ","+position.coords.longitude;

      $.ajax({
      url: "https://maps.googleapis.com/maps/api/geocode/json",
      dataType: "json",
      data: {'latlng':latlng, 'sensor':true, 'key':"AIzaSyBYfeB69IwOlhuKbZ1pAOwcjEAz3SYkR-o"},
      type: "GET",
      success: function (data) {

          
          $.each(data.results[0].address_components, function( key, value ) {
            var short_names = value.short_name;

            switch(value.types[0])
            {
              case "postal_code": $("#postal_code").val(short_names);
                                  break;
              case "locality": $("#locality").val(short_names);
                                  break;
              case "administrative_area_level_1": $("#administrative_area_level_1").val(short_names);
                                  break;
              case "country": $("#country").val(short_names);
                                  break;
            }
          });
           if(data.plus_code.compound_code)
           {
              var addressarr = data.plus_code.compound_code.split(",");
              $("#autocompletestate").val(addressarr[1]);
           }
          
      
        return false;
       },
      error: function (data) {
        $("#err_autocomplete").fadeIn(1000);
        $("#err_autocomplete").html("&#9888 Oops, Something went wrong!");
        return false;
      }
    });
    });
     return false;
  }

    
function addToFollow(ref)
{   

    var guest_url = "<?php echo e(url('/')); ?>";
    var guest_redirect_url = window.location.href;

    var id   = $(ref).attr('data-id');
    var type = $(ref).attr('data-type');
    var sellerid = $(ref).attr('data-seller-id');
    var csrf_token = "<?php echo e(csrf_token()); ?>";

    var logged_in_user  = "<?php echo e(Sentinel::check()); ?>";


    if(logged_in_user == '')
    {
        
         $.ajax({
                url:guest_url+'/set_guest_url',
                method:'GET',
                data:{guest_link:guest_redirect_url},
                dataType:'json',
           
                
                success:function(response)
                {
                  if(response.status=="success")
                  {
                  /* $(location).attr('href', guest_url+'/signup/guest')
                   $(location).attr('href', guest_url+'/login')*/
                    $(location).attr('href', guest_url+'/login/'+id);
                    $(this).addClass('guest_url_btn');

                  }

                }
            }); 



    }
    else
    {
       
        $.ajax({
            url: SITE_URL+'/favorite/add_to_follow',
            type:"POST",
            data: {id:id,type:type,sellerid:sellerid,_token:csrf_token},             
            dataType:'json',
            beforeSend: function(){    
            $(ref).prop('disabled',true);          
            $(ref).html('Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i>');        
            },
            success:function(response)
            {
              if(response.status == 'SUCCESS')
              { 
                $(ref).prop('disabled',false);          
                $(ref).html('Following');
                
                $(ref).addClass('heart-o-actv');
              /* $(location).attr('href', SITE_URL+'/buyer/my-favourite')*/
               window.location.reload();

                
              }
              else
              {                
                swal('Alert!',response.description);
              }  
            }  

        }); 
  } 

}/*end function add to follow*/


function unfollow(ref)
{
    var id         = $(ref).attr('data-id');
    var type       = $(ref).attr('data-type');
    var sellerid   = $(ref).attr('data-seller-id');
    var csrf_token = "<?php echo e(csrf_token()); ?>";

    $.ajax({
              url: SITE_URL+'/favorite/unfollow',
              type:"POST",
              data: {id:id,type:type,sellerid:sellerid,_token:csrf_token},             
              dataType:'json',
              beforeSend: function(){   
                $(ref).prop('disabled',true);          
                $(ref).html('Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i>');         
              },
              success:function(response)
              {
                if(response.status == 'SUCCESS')
                { 
                  
                  $(ref).html('Follow');
                  $(ref).removeClass('heart-o-actv').addClass('deactive');
                  $(ref).prop('disabled',false);          
                  window.location.reload();
                       
                }
                else
                {                
                  swal('Error',response.description,'error');
                }  
              }  
      }); 
}/*unfollow*/


  $(".centered").show();
  $(window).load(function() {

     $(".centered").hide();
  });



  
  $(window).load(function() {
  $("#flexisel792").flexisel({
          visibleItems: 4,
          itemsToScroll: 1,
          infinite: false,
        /* infinite: true,*/
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      }
      });

  $("#flexiselDemo379").flexisel({
          visibleItems: 4,
          itemsToScroll: 1,
          infinite: false,
        /* infinite: true,*/
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      }
      });
});


 


 /*price range slider*/
         $(function() {
           $("#slider-price-range").slider({
               range: true,
               min: 1,
             /* min: parseInt(lowest_price),*/
               max: parseInt(highest_price),
               values: [parseInt(min_selected_price), parseInt(max_selected_price)],
               slide: function(event, ui) {
                  
                   $("#slider_price_range_txt").html("<span class='slider_price_min'><input type='text' name='min' id='min' onkeypress='return ValidNumeric()' onkeyup='changeminprice(this.value)' value='" + ui.values[0] + " '/></span>  <span class='slider_price_max'><input type='text' name='max' id='max' onkeypress='return ValidNumeric()' onkeyup='changemaxprice(this.value)' value='" + ui.values[1] + " '/> </span>");
               },
                stop: function (event, ui) {
                
                var min = ui.values[0];
                var max = ui.values[1];
                 var link ='';

                if(min!='' && max!=''){
                   link = SITE_URL+'/search?price='+min+'-'+max;
                  }       
                  if(brands)
                 {
                   link += '&brands='+brands;
                 }
                   if(sellers)
                 {
                   link += '&sellers='+sellers;
                 }
                  if(category)
                 {
                   link += '&category_id='+category;
                 }
                   if(mg)
                 {
                   link += '&mg='+mg;
                 }
                   if(age_restrictions)
                 {
                   link += '&age_restrictions='+age_restrictions;
                 }
                   if(rating)
                 {
                   link += '&rating='+rating;
                 }
                   if(filterby_price_drop)
                 {
                   link += '&filterby_price_drop='+filterby_price_drop;
                 }

                 if(product_search)
                 {
                   link += '&product_search='+product_search;
                 }
                 if(state)
                 {
                   link += '&state='+state;
                 }
                 if(city)
                 {
                   link += '&city='+city;
                 }
                 if(spectrum)
                 {
                   link += '&spectrum='+spectrum;
                 }
                 if(chows_choice)
                 {
                   link += '&chows_choice='+chows_choice;
                 }
                 if(best_seller)
                 {
                   link += '&best_seller='+best_seller;
                 }
                  if(statelaw)
                 {
                   link += '&statelaw='+statelaw;
                 }
                  if(reported_effects)
                 {
                   link += '&reported_effects='+reported_effects;
                 } 

                 if(cannabinoids)
                 {
                   link += '&cannabinoids='+cannabinoids;
                 }
                 if(featured)
                 {
                   link += '&featured='+featured;
                 }

                 window.location.href = link;
       

               }

           });
           $("#slider_price_range_txt").html("<span class='slider_price_min'><input type='text' name='min' id='min' onkeypress='return ValidNumeric()' onkeyup='changeminprice(this.value)' value='" + $("#slider-price-range").slider("values", 0) + " '/></span>  <span class='slider_price_max'><input type='text' name='max' id='max' onkeypress='return ValidNumeric()' onkeyup='changemaxprice(this.value)' value='" + $("#slider-price-range").slider("values", 1) + " '/></span>");
         }); 



function ValidNumeric() {    
    
    var charCode = (event.which) ? event.which : event.keyCode;    
    if (charCode >= 48 && charCode <= 57)    
    { return true; }    
    else    
    { return false; }    
}/*validnumeric*/   

function changeminprice(min)
{
  var max = $("#max").val();

   if(min!='' && min!=0 && max!='' && max!=0 && parseInt(min)<=parseInt(max))
   {
     $( "#slider-price-range" ).slider('values',0,min);
     $("#min").val(min);
      
    
      var link ='';

       if(min!='' && max!=''){
         link = SITE_URL+'/search?price='+min.trim()+'-'+max.trim();
        }       
        if(brands)
       {
         link += '&brands='+brands;
       }
         if(sellers)
       {
         link += '&sellers='+sellers;
       }
        if(category)
       {
         link += '&category_id='+category;
       }
         if(mg)
       {
         link += '&mg='+mg;
       }
         if(age_restrictions)
       {
         link += '&age_restrictions='+age_restrictions;
       }
         if(rating)
       {
         link += '&rating='+rating;
       }
         if(filterby_price_drop)
       {
         link += '&filterby_price_drop='+filterby_price_drop;
       }

       if(product_search)
       {
         link += '&product_search='+product_search;
       }
       if(state)
       {
         link += '&state='+state;
       }
       if(city)
       {
         link += '&city='+city;
       }
       if(spectrum)
       {
         link += '&spectrum='+spectrum;
       }
       if(chows_choice)
       {
         link += '&chows_choice='+chows_choice;
       }
       if(best_seller)
       {
         link += '&best_seller='+best_seller;
       }
        if(statelaw)
       {
         link += '&statelaw='+statelaw;
       }
         if(reported_effects)
       {
         link += '&reported_effects='+reported_effects;
       }
      if(cannabinoids)
       {
         link += '&cannabinoids='+cannabinoids;
       }

       if(featured)
       {
         link += '&featured='+featured;
       }

       
       window.location.href = link;

    }/*if min*/
}/*changeminprice*/



function changemaxprice(max)
{
   var min = $("#min").val();

   if(max!='' && max!=0 && min!='' && min!=0 && parseInt(max)>=parseInt(min))
   {
     $( "#slider-price-range" ).slider('values',1,max);
     $("#max").val(max);
     

       var link ='';
       if(min!='' && max!=''){
         link = SITE_URL+'/search?price='+min.trim()+'-'+max.trim();
        }       
        if(brands)
       {
         link += '&brands='+brands;
       }
         if(sellers)
       {
         link += '&sellers='+sellers;
       }
        if(category)
       {
         link += '&category_id='+category;
       }
         if(mg)
       {
         link += '&mg='+mg;
       }
         if(age_restrictions)
       {
         link += '&age_restrictions='+age_restrictions;
       }
         if(rating)
       {
         link += '&rating='+rating;
       }
         if(filterby_price_drop)
       {
         link += '&filterby_price_drop='+filterby_price_drop;
       }

       if(product_search)
       {
         link += '&product_search='+product_search;
       }
       if(state)
       {
         link += '&state='+state;
       }
       if(city)
       {
         link += '&city='+city;
       }
       if(spectrum)
       {
         link += '&spectrum='+spectrum;
       }
       if(chows_choice)
       {
         link += '&chows_choice='+chows_choice;
       }
       if(best_seller)
       {
         link += '&best_seller='+best_seller;
       }
        if(statelaw)
       {
         link += '&statelaw='+statelaw;
       }
       if(reported_effects)
       {
         link += '&reported_effects='+reported_effects;
       } 

       if(cannabinoids)
       {
         link += '&cannabinoids='+cannabinoids;
       }
       if(featured)
       {
         link += '&featured='+featured;
       }

       window.location.href = link;

   }/*max*/
}/*changemaxprice*/



   /*price range slider*/


  function add_to_cart(ref) {
    var id   = $(ref).attr('data-id');
    var quantity = $(ref).attr('data-qty');
    var type  = $(ref).attr('data-type');

    var csrf_token = "<?php echo e(csrf_token()); ?>";
    var $this = $(this);
    
    var prdid = atob(id);
   
    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){     
            $(ref).attr('disabled');          
             
           $('#prd_'+prdid).html('Added To Cart <i class="fa fa-spinner fa-pulse fa-fw"></i>');

          },
          success:function(cart_response)
          {
            
            $(".add_to_cart").html('Add to Cart');      
            if(cart_response.status == 'SUCCESS')
            { 
              $('#prd_'+prdid).css('background-color','#18ca44');
              $('#prd_'+prdid).css('border','#18ca44');
              $('#prd_'+prdid).css('color','#fff');

         /*      swal('Success',cart_response.description,'success');
               if(loggedinuser.trim()=='0' || loggedinuser.trim()==0){
               window.location.reload();  */
               /*}else{
                 window.location.href = SITE_URL+'/my_bag';   
               } */       
                $( "#mybag_div" ).load(window.location.href + " #mybag_div" );  
                 _learnq.push(["track", "Added to Cart",cart_response.klaviyo_addtocart]);

                gettrackingproductidinfo(id,quantity);


                /*-------------------Cart Pop-up ----------------------*/

                
                 var product_name   = cart_response.product_details.product_name ? cart_response.product_details.product_name : '';
                 var product_image  = cart_response.product_details.product_image ? cart_response.product_details.product_image : '';
                 var item_qty       = cart_response.product_details.item_qty ? cart_response.product_details.item_qty : '';
                 var price          = cart_response.product_details.price ? cart_response.product_details.price : '';
                 var shipping_type  = cart_response.product_details.shipping ? cart_response.product_details.shipping : '';
                 var seller_type    = cart_response.product_details.seller_type ? cart_response.product_details.seller_type : '';

                 var is_price_drop        = cart_response.product_details.is_price_drop ? cart_response.product_details.is_price_drop : '';
                 var unit_price           = cart_response.product_details.unit_price ? cart_response.product_details.unit_price : '';
                 var percent_price_drop   = cart_response.product_details.percent_price_drop ? cart_response.product_details.percent_price_drop : '';

                 $('#add_to_cart_pop_up').addClass('open-cart-box'); // Show pop-up

                 var prod_name_div      = document.getElementById('prod_name');
                 var item_qty_div       = document.getElementById('prod_item_qty');
                 var price_div          = document.getElementById('prod_price');
               
                 var product_image_div  = document.getElementById('product_image');
                 var seller             = document.getElementById('seller');

                 prod_name_div.innerHTML      = product_name;
                 item_qty_div.innerHTML       = item_qty;
             
                 if (is_price_drop) {

                  price_div.innerHTML = "$"+Number(price).toFixed(2)+" <del class='pricevies inline-del'> $"+Number(unit_price).toFixed(2)+"</del> <div class='inlineoff-div'>("+Number(percent_price_drop)+"% off)</div>";
                 }
                 else {

                  price_div.innerHTML = "$"+Number(price).toFixed(2);
                 }

                 product_image_div.innerHTML  = "<img class='lozad' src='"+SITE_URL+"/assets/images/Pulse-1s-200px.svg' data-src='"+product_image+"' id='add_cart_product' alt='Girl in a jacket' width='100' height='100'>";



                setTimeout(() => {

                    $('#add_to_cart_pop_up').removeClass('open-cart-box');

                    $('#prod_name').empty();
                    $('#prod_item_qty').empty();
                    $('#prod_price').empty();

                    var myobj = document.getElementById("add_cart_product");
                    myobj.remove();

                }, 5000);

               /*-------------------Cart Pop-up ----------------------*/

            }
            else if(cart_response.status=="FAILURE")
            { /* added new*/
                     swal('Alert!',cart_response.description);  
                                      
            }
            else
            {                
              swal('Error',response.description,'error');
            }  
          }  

      });

  }


  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";

      $('#prod_name').empty();
      $('#prod_item_qty').empty();
      $('#prod_price').empty();
      $('#product_image').empty();

    }
  }

var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
  modal.style.display = "none";   

}



 function addToFavorite(ref)
{   
    var guest_url = "<?php echo e(url('/')); ?>";
    var guest_redirect_url = window.location.href;

    var id   = $(ref).attr('data-id');
    var type = $(ref).attr('data-type');
    var csrf_token = "<?php echo e(csrf_token()); ?>";

    var logged_in_user  = "<?php echo e(Sentinel::check()); ?>";


    if(logged_in_user == '')
    {
        
         $.ajax({
                url:guest_url+'/set_guest_url',
                method:'GET',
                data:{guest_link:guest_redirect_url},
                dataType:'json',
           
                
                success:function(response)
                {
                  if(response.status=="success")
                  {

                    $(location).attr('href', guest_url+'/signup/guest')
                  }

                }
            });
    }
    else
    {      
        $.ajax({
            url: SITE_URL+'/favorite/add_to_favorite',
            type:"POST",
            data: {id:id,type:type,_token:csrf_token},             
            dataType:'json',
            beforeSend: function(){            
            },
            success:function(response)
            {
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


function removeFromFavorite(ref)
{
    var id         = $(ref).attr('data-id');
    var type       = $(ref).attr('data-type');
    var csrf_token = "<?php echo e(csrf_token()); ?>";

    $.ajax({
              url: SITE_URL+'/favorite/remove_from_favorite',
              type:"POST",
              data: {id:id,type:type,_token:csrf_token},             
              dataType:'json',
              beforeSend: function(){            
              },
              success:function(response)
              {
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
                            $(this).removeClass('active');
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




/*search by featured filter*/
function changeFeatured(ref)
{
      var selected_option = $('#featured').val();
      var link ='';
      var price = $("#price").val();

      if(selected_option)
      {

          if(selected_option!='')
          {
              link = SITE_URL+'/search?featured='+selected_option;
          }
          else{

            link += SITE_URL+'/search?';
          }


          if(price)
          {
             link += '&price='+price;
          }     
            
          if(brands)
          {
             link += '&brands='+brands;
          }
            
          if(sellers)
          {
             link += '&sellers='+sellers;
          }
            
          if(category)
          {
             link += '&category_id='+category;
          }
             
          if(mg)
          {
             link += '&mg='+mg;
          }
             
          if(age_restrictions)
          {
             link += '&age_restrictions='+age_restrictions;
          }
             
          if(rating)
          {
             link += '&rating='+rating;
          }
             
          if(filterby_price_drop)
          {
             link += '&filterby_price_drop='+filterby_price_drop;
          }

          if(product_search)
          {
             link += '&product_search='+product_search;
          }
           
          if(state)
          {
             link += '&state='+state;
          }
           
          if(city)
          {
             link += '&city='+city;
          }
           
          if(spectrum)
          {
             link += '&spectrum='+spectrum;
          }
          if(chows_choice)
          {
             link += '&chows_choice='+chows_choice;
          }
          if(best_seller)
          {
             link += '&best_seller='+best_seller;
          }
          if(statelaw)
          {
             link += '&statelaw='+statelaw;
          }
             
          if(reported_effects)
          {
             link += '&reported_effects='+reported_effects;
          }

          if(cannabinoids)
          {
             link += '&cannabinoids='+cannabinoids;
          }

        
          window.location.href = link;

      }   

}


function buyer_redirect_login_product(val)
{
  if(val){
      window.location.href = SITE_URL+"/login/"+val;

  }else{
      window.location.href = SITE_URL+"/login";

  }
}


  function gettrackingproductidinfo(productid,quantity)
  {
     
    if(productid)
    {
       var csrf_token = "<?php echo e(csrf_token()); ?>";
       var productid = atob(productid);



         $.ajax({
                url:SITE_URL+'/gettrackingproduct',
                method:'GET',
                data:{productid:productid,quantity:quantity},
     
                success:function(response)
                {
                 
                   /*_learnq.push(["track", "Added to Cart", {
                    "ProductName": response.AddedItemProductName,
                   "ProductID": response.AddedItemProductID,
                   "Categories": response.AddedItemCategories,
                   "ImageURL": response.AddedItemImageURL,
                   "URL": response.AddedItemURL,
                   "Brand": response.Brand,
                   "Price": response.Price,
                   "CompareAtPrice": response.CompareAtPrice,
                   "Dispensary": response.Dispensary
                   }]);*/


                    var item = {
                     "ProductName": response.AddedItemProductName,
                     "ProductID": response.AddedItemProductID,
                     "Categories":response.AddedItemCategories,
                     "ImageURL": response.AddedItemImageURL,
                     "URL": response.AddedItemURL,
                     "Brand": response.Brand,
                     "Price":response.Price,
                     "CompareAtPrice": response.CompareAtPrice,
                     "Dispensary": response.Dispensary
                   };

                        dataLayer.push({
                        'event': 'GA - Add To Cart',
                        'ecommerce': {
                          'currencyCode': 'USD',
                          'add': {                                
                            'products': [{                        
                              'name': response.AddedItemProductName,
                              'id':  response.AddedItemProductID,
                              'price': response.Price,
                              'brand': response.Brand,
                              'category': response.AddedItemCategory,                            
                              'quantity': 1
                             }]
                          }
                        }
                      });




                }/*success*/
            });


    }/*if productid*/
    
  }/*end function*/


function productclick(productObj) { 

  dataLayer.push({
    'event': 'Click',
    'ecommerce': {
      'click': {
        'actionField': {'list': 'Search Results'},      
        'products': [{
          'name': productObj.name,                      
          'id': productObj.id,
          'price': productObj.price,
          'brand': productObj.brand,
          'category': productObj.category,
         
          'position': productObj.position
         }]
       }
     },
     'eventCallback': function() {
       document.location = productObj.url
     }
  });
  
}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>