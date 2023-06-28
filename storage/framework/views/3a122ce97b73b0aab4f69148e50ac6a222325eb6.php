<?php $__env->startSection('main_content'); ?>

<style type="text/css">
  .top-rated-brands-list.favoiritelist{margin-bottom: 0px;}
  .imgcheck-chow {
    width: 60px;
    margin-left: 10px;
  }
  .pricevies.inline-del{display: inline-block;}
  .inlineoff-div{
    display: inline-block; color: #9b9b9b !important; font-size: 15px !important;
}
.spectrum {
    display: block;
}
.line-vertical{
    display: inline-block;
    font-weight: bold;
    /*padding: 0 10px;*/
    vertical-align: top;
    line-height: 17px
}
.sellernm-text-left {
    font-weight: normal;
    color: #222;
    display: block;
    float: left;
    margin-right: 4px;
}
.sellernm-text-right {
    color: #222;
}
.font-sizesmall{
  display:inline-block; font-size:12px;
}

h1{
    font-size: 18px;
    font-weight: 600;
    background-color: #f1f5f8;
    padding: 10px 10px 10px 70px;
    color: #222;
}
</style>

<div class="my-profile-pgnm">
  <?php echo e(isset($page_title)?$page_title:''); ?>

     <ul class="breadcrumbs-my">
        <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
        <li><i class="fa fa-angle-right"></i></li>
        <li>Wishlist</li>
      </ul>
     
</div>
<div class="chow-homepg">Chow420 Home Page</div>

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



 /*******************Restricted states seller id*********************/

  $check_buyer_restricted_states =  get_buyer_restricted_sellers();
  $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];

  $restricted_state_sellers = [];
   if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids)){

      $restricted_state_sellers = [];
      foreach($restricted_state_user_ids as $sellers) {
        $restricted_state_sellers[] = isset($sellers['id'])?$sellers['id']:'';
      }
   }
    $is_buyer_restricted_forstate = is_buyer_restricted_forstate();
   
/********************Restricted states seller id***********************/



?>



<div class="new-wrapper favouritepgs">
<div class="row-flex">
    <?php 
     // dd($arr_data);
    $pageclick=[];
    ?>

        <?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
          <?php
            $wishlist_brandname ='';
            $wishlist_sellername ='';
            $wishlist_productname ='';
          ?>
         <?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php

            $login_user = Sentinel::check();

            if(isset($fav_product['get_product_details']['product_images_details'][0]['image']) && $fav_product['get_product_details']['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$fav_product['get_product_details']['product_images_details'][0]['image']))
            {
              $product_img = url('/uploads/product_images/'.$fav_product['get_product_details']['product_images_details'][0]['image']);
            } 
            else
            {                  
              $product_img = url('/assets/images/default-product-image.png');
            }


             $firstcat_id = $fav_product['get_product_details']['first_level_category_id'];
             $restrictseller_id   = $fav_product['get_product_details']['user_id']; 


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
              if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers) 
                && isset($restrictseller_id))
             {
                if(in_array($restrictseller_id,$restricted_state_sellers))
                { 
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



              //echo "==".$firstcat_id.'--'.$restrictseller_id.'--'.$checkfirstcat_flag.'--'.$checkseller_flag;

             $wishlist_brandname = isset($fav_product['get_product_details']['get_brand_detail']['name'])?str_slug($fav_product['get_product_details']['get_brand_detail']['name']):'';

             $wishlist_sellername = isset($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name'])?str_slug($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name']):'';

             $wishlist_productname = isset($fav_product['get_product_details']['product_name'])?str_slug($fav_product['get_product_details']['product_name']):'';

              $wishlist_product_title_slug = str_slug($wishlist_productname);


               $pageclick['name'] = isset($fav_product['get_product_details']['product_name']) ? $fav_product['get_product_details']['product_name'] : '';
               $pageclick['id'] = isset($fav_product['get_product_details']['id']) ? $fav_product['get_product_details']['id'] : '';
               $pageclick['brand'] = isset($fav_product['get_product_details']['brand']) ? get_brand_name($fav_product['get_product_details']['brand']) : '';
               $pageclick['category'] = isset($fav_product['get_product_details']['first_level_category_id']) ? get_first_levelcategorydata($fav_product['get_product_details']['first_level_category_id']) : '';

                if(isset($fav_product['get_product_details']['price_drop_to']))
                {
                   if($fav_product['get_product_details']['price_drop_to']>0)
                   {
                     $pageclick['price'] = isset($fav_product['get_product_details']['price_drop_to']) ? num_format($fav_product['get_product_details']['price_drop_to']) : '';
                   }else
                   {
                    $pageclick['price'] = isset($fav_product['get_product_details']['unit_price']) ? num_format($fav_product['get_product_details']['unit_price']) : '';
                   }
                 
                }
                else
                {
                  $pageclick['price'] = isset($fav_product['get_product_details']['unit_price']) ? num_format($fav_product['get_product_details']['unit_price']) : '';
                }

               //$pageclick['position'] = $i;
               // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($fav_product['get_product_details']['id']).'/'.$wishlist_product_title_slug.'/'.$wishlist_brandname.'/'.$wishlist_sellername ; 
               $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($fav_product['get_product_details']['id']).'/'.$wishlist_product_title_slug; 







             ?>     

            <div <?php if($checkfirstcat_flag==1): ?> class="col-my-fav my-favourite-col-fav checkrestrictionclass" 
            <?php else: ?> class="col-my-fav my-favourite-col-fav" <?php endif; ?>>
             <div class="top-rated-brands-list favoiritelist">

               

                 <?php if(isset($fav_product['get_product_details']['first_level_category_details']['age_restriction']) && $fav_product['get_product_details']['first_level_category_details']['age_restriction']!=""): ?>

                <div class="label-list"><?php echo e(isset($fav_product['get_product_details']['first_level_category_details']['age_restriction_detail']['age'])?$fav_product['get_product_details']['first_level_category_details']['age_restriction_detail']['age']:''); ?></div>

                <?php endif; ?>


                 <?php if($login_user == true && $login_user->inRole('buyer')): ?>
                       <a href="javascript:void(0)" class="view-favoirite" data-id="<?php echo e(isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):0); ?>" data-type="buyer" onclick="removeFromFavorite($(this));" title="Remove from wishlist"><i class="fa fa-trash-o"></i></a>

                        
                 <?php endif; ?>  



                <div class="img-rated-brands">
                    <div class="thumbnailssnew">
                        
                        <a href="<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):''); ?>/<?php echo e($wishlist_productname); ?>"  title="View Product Detail" target="_blank" onclick="return productclick(<?php echo e(isset($pageclick)?json_encode($pageclick):''); ?>)">
                          <img src="<?php echo e($product_img); ?>" class="" alt="<?php echo e(isset($fav_product['get_product_details']['product_name'])?ucwords($fav_product['get_product_details']['product_name']):''); ?>" />
                        </a>
                    </div>
                    <div class="content-brands">
                         <?php

                                    
                              $total_review   = get_total_reviews($fav_product['product_id']);
                              $avg_rating     = get_avg_rating($fav_product['product_id']); 
                              $img_avg_rating = "";  
                              if(isset($avg_rating) && $avg_rating > 0)
                              {
                                $img_avg_rating = "";

                                // if($avg_rating=='1') $img_avg_rating = "star-rate-one.png";
                                // else if($avg_rating=='2')  $img_avg_rating = "star-rate-two.png";
                                // else if($avg_rating=='3')  $img_avg_rating = "star-rate-three.png";
                                // else if($avg_rating=='4')  $img_avg_rating = "star-rate-four.png";
                                // else if($avg_rating=='5')  $img_avg_rating = "star-rate-five.png";
                                // else if($avg_rating=='0.5') $img_avg_rating = "star-rate-zeropointfive.png";
                                // else if($avg_rating=='1.5')  $img_avg_rating = "star-rate-onepointfive.png";
                                // else if($avg_rating=='2.5')  $img_avg_rating = "star-rate-twopointfive.png";
                                // else if($avg_rating=='3.5')  $img_avg_rating = "star-rate-threepointfive.png";
                                // else if($avg_rating=='4.5')  $img_avg_rating = "star-rate-fourpointfive.png";
                                 $img_avg_rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';
                              }  

                            ?>

                            <?php
                                $busines_name = isset($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name'])?$fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name']:'';
                                if(isset($busines_name)){
                                  $busines_names = str_replace(' ','-',$busines_name); 
                                }
                            ?>

                            <?php
                                $brand_name = isset($fav_product['get_product_details']['get_brand_detail']['name'])?$fav_product['get_product_details']['get_brand_detail']['name']:'';
                                if(isset($brand_name)){
                                  $brandname = str_replace(' ','-',$brand_name); 
                                }
                            ?>



                    
                        


                          <div class="title-chw-list">
                            
                            <a href="<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):''); ?>/<?php echo e($wishlist_productname); ?>" onclick="return productclick(<?php echo e(isset($pageclick)?json_encode($pageclick):''); ?>)">
                            

                            
                                      

                              <span class="titlename-list">
                                 <?php echo e(isset($fav_product['product_id'])?get_product_name($fav_product['product_id']):''); ?>

                              </span>
                           </a>
                          </div>


                          <!-------------------------- Start Extra Data------------------------->
                            
                           


                            <div class="sellernm-text">
                              <div class="sellernm-text-left">By:</div>
                              <div class="sellernm-text-right">
                               
                                  <?php echo e(isset($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name'])?$fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name']:''); ?> 
                                </a> 

                                <a class="by-sellernmlink" target="_blank" href="<?php echo e(url('/')); ?>/search?sellers=<?php echo e(isset($busines_names)?$busines_names:''); ?>"> 
                                  <?php echo e(isset($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name'])?$fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name']:''); ?> 
                                </a>
                              </div>
                            </div>



                            <?php if(isset($fav_product['get_product_details']['per_product_quantity']) && $fav_product['get_product_details']['per_product_quantity'] != 0): ?>
                            <div class="sellernm-text">
                              <div class="sellernm-text-left">Concentration :</div>
                              <div class="sellernm-text-right">
                               <?php echo e(isset($fav_product['get_product_details']['per_product_quantity'])?$fav_product['get_product_details']['per_product_quantity']:0); ?>mg
                                 

                              </div>

                               <?php if(isset($fav_product['get_product_details']['spectrum'])): ?>

                                  <?php 
                                   $get_spectrum_val = get_spectrum_val($fav_product['get_product_details']['spectrum']);
                                  ?>                                
                                 <div class="spectrum"> 
                                    <span class="inlineblock-details">
                                      <b>

                                    

                                      <?php echo e(isset($get_spectrum_val['name'])?$get_spectrum_val['name']:''); ?> 

                                     </b>
                                  </span>

                                  <a target='_blank'  class="font-sizesmall" href="https://chow420.com/forum/view_post/MTg=">What's this?</a>
                                  </div> 
                               <?php endif; ?>

                            </div>
                               <?php endif; ?>


                             <?php

                             //dd();
                              $remaining_stock = $product_availability = ""; 
                              $remaining_stock = $fav_product['get_product_details']['inventory_details']['remaining_stock']; 
                              if(isset($remaining_stock) && $remaining_stock > 0) 
                              {
                                $product_availability = 'In Stock';
                              }
                              else
                              {
                                $product_availability = 'Out Of Stock';
                              }

                             // if($product_availability=='Out Of Stock'){
                              //dd($fav_product['get_product_details']['is_outofstock']);
                            ?>

                              

                               <?php if(isset($fav_product['get_product_details']['is_outofstock']) && $fav_product['get_product_details']['is_outofstock'] == 0): ?>
                                 <?php if($remaining_stock>0 && $checkfirstcat_flag==1): ?>
                                     <div class="sellernm-text">
                                     <div class="sellernm-text-left">Availability:</div>
                                     <div class="sellernm-text-right"> 
                                       
                                        Restricted, This product is not allowed for you to purchase based on your location.
                                      </div>
                                    </div>
                                 <?php elseif($remaining_stock>0 && $checkfirstcat_flag==0): ?>
                                     <div class="sellernm-text">
                                     <div class="sellernm-text-left">Availability:</div>
                                     <div class="sellernm-text-right"> 
                                        <?php echo e($product_availability); ?>

                                      </div>
                                    </div>
                                  <?php elseif($remaining_stock<=0 && $checkfirstcat_flag==1): ?>
                                     <div class="sellernm-text">
                                     <div class="sellernm-text-left">Availability:</div>
                                     <div class="sellernm-text-right"> 
                                          Restricted, This product is not allowed for you to purchase based on your location.
                                      </div>
                                    </div>   
                                   <?php elseif($remaining_stock<=0 && $checkfirstcat_flag==0): ?>
                                     <div class="sellernm-text">
                                     <div class="sellernm-text-left">Availability:</div>
                                     <div class="sellernm-text-right"> 
                                          <?php echo e($product_availability); ?>

                                      </div>
                                    </div>     

                                 <?php endif; ?>
                               <?php else: ?>
                                 <div class="sellernm-text">
                                 <div class="sellernm-text-left">Availability:</div>
                                 <div class="sellernm-text-right"> 
                                      Out Of Stock
                                  </div>
                                </div>     
                               <?php endif; ?>






                            <?php
                             // }
                            ?>

                            <?php echo e(isset($fav_product['get_product_details']['first_level_category_details']['product_type'])?$fav_product['get_product_details']['first_level_category_details']['product_type']:''); ?>


                          <!-------------------------- End Extra Data------------------------->


                        <div class="price-listing">
                          <?php if(isset($fav_product['get_product_details']['price_drop_to'])): ?>
                            <?php if($fav_product['get_product_details']['price_drop_to']>0): ?>
                             <?php
                               if(isset($fav_product['get_product_details']['percent_price_drop']) && $fav_product['get_product_details']['percent_price_drop']=='0.000000') 
                               {
                               $percent_price_drop = calculate_percentage_price_drop($fav_product['get_product_details']['id'],$fav_product['get_product_details']['unit_price'],$fav_product['get_product_details']['price_drop_to']); 
                               $percent_price_drop = floor($percent_price_drop);
                               }
                               else
                               { 
                                $percent_price_drop = floor($fav_product['get_product_details']['percent_price_drop']);
                               }
                             ?>
                              <del class="pricevies black-font-clr inline-del">$<?php echo e(isset($fav_product['get_product_details']['unit_price'])? num_format($fav_product['get_product_details']['unit_price']):'0'); ?></del><div class="inlineoff-div"> (<?php echo e($percent_price_drop); ?>% off)</div><br>
                              <span>$<?php echo e(isset($fav_product['get_product_details']['price_drop_to']) ? num_format($fav_product['get_product_details']['price_drop_to']) : '0'); ?> </span>
                            <?php else: ?>
                            <span>$<?php echo e(isset($fav_product['get_product_details']['unit_price'])? num_format($fav_product['get_product_details']['unit_price']):'0'); ?></span>
                            <?php endif; ?>
                          <?php else: ?>
                            <span>$<?php echo e(isset($fav_product['get_product_details']['unit_price'])? num_format($fav_product['get_product_details']['unit_price']):'0'); ?></span>
                          <?php endif; ?>
                        </div>

                         <div class="title-sub-list subtitlewishlist">
                        
                            <!-----------------start of---rating div-------------->

                            <?php if(isset($avg_rating) && $avg_rating>0): ?>
                            <div class="stars"> 
                               

                               <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_avg_rating)?$img_avg_rating.'.svg':''); ?>" alt="<?php echo e(isset($img_avg_rating)?$img_avg_rating:''); ?>" title="<?php echo e(isset($avg_rating)?$avg_rating:''); ?> rating is a combination of all ratings on chow in addition to ratings on vendor site.">

                               <span style=" color: #3e3e3e;"> <?php echo e(isset($avg_rating)? $avg_rating:''); ?></span>
                               <span href="#" class="str-links">
                                  

                                  
                                  <?php if(isset($total_review)): ?> (<?php echo e($total_review); ?>) <?php endif; ?>

                               </span>
                            </div>
                           <?php endif; ?> 
                           <!-----------------end of rating div----------------------->
                        </div>

                       

                      <?php if(isset($fav_product['get_product_details']['is_outofstock']) && $fav_product['get_product_details']['is_outofstock'] == 0): ?>

                          <?php if(isset($fav_product['get_product_details']['inventory_details']['remaining_stock']) && ($fav_product['get_product_details']['inventory_details']['remaining_stock']>0)): ?>
                              
                              <a 
                                             <?php if($remaining_stock>0 && $checkfirstcat_flag==0): ?>
                                             style="display: inline-block;"
                                             <?php elseif($remaining_stock>0 && $checkfirstcat_flag==1): ?>
                                             style="display: none"
                                             <?php elseif($remaining_stock<=0 && $checkfirstcat_flag==1): ?>
                                             style="display: none"
                                             <?php elseif($remaining_stock<=0 && $checkfirstcat_flag=0): ?>
                                             style="display: none"
                                             <?php endif; ?>

                                            href="javascript:void(0)" data-type="buyer" data-id="<?php echo e(isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):0); ?>" data-qty="1" 
                                                        
                                                                          

                                                                <?php if($checkfirstcat_flag==1): ?>
                                                                  
                                                                <?php else: ?>
                                                                   onclick="add_to_cart($(this))"
                                                                <?php endif; ?>


                                                               
                                                             
                                  >
                                    <div class="add_to_cart" id="<?php echo e(isset($fav_product['product_id'])?$fav_product['product_id']:0); ?>"> 
                                       Add to cart
                                    </div>

                                  </a>

                                                    


                             
                          <?php endif; ?>
                      <?php endif; ?>
                      
                              
                    </div><!-- end of content brand class----->
                    <div class="clearfix"></div>
                </div>
                <div><div class="clearfix"></div></div>
            </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <div class="empty-product-main">
                         <div class="empty-prodct">
                             <img src="<?php echo e(url('/')); ?>/assets/front/images/empty-product.jpg" alt="Product" />
                         </div>
                         <div class="empty-product-title">Empty Wishlist</div>
                         <span>You have no items in your wishlist. Start adding!</span>
                     </div>
                </div>

    <?php endif; ?>  

      <div class="col-md-12">
        <div class="pagination-chow">

             
          <?php if(!empty($arr_pagination)): ?>
            <?php echo e($arr_pagination->render()); ?>    
           <?php endif; ?> 

        </div>
      </div>
</div>
</div>

<script type="text/javascript">

    var _learnq = _learnq || [];


    function add_to_cart(ref) {

    
    var id   = $(ref).attr('data-id');
    var quantity = $(ref).attr('data-qty');
    var type  = $(ref).attr('data-type');

    var csrf_token = "<?php echo e(csrf_token()); ?>";

     var prdid = atob(id);

    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){     
            // $(ref).html('<div class="add_to_cart">Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i></div>');    
            //$(".add_to_cart").html('Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i>');   

            $(ref).html('<div class="add_to_cart" id="'+prdid+'">Added To Cart <i class="fa fa-spinner fa-pulse fa-fw"></i></div>');
          },
          success:function(cart_response)
          {
            if(cart_response.status == 'SUCCESS')
            { 
                 
                  
                  
                   $(ref).html('<div class="add_to_cart" id="'+prdid+'">Add to cart</div>');

                   $('#'+prdid).css('background-color','#18ca44');
                   $('#'+prdid).css('border','#18ca44');
                   $('#'+prdid).css('color','#fff');
 

                  // window.location.href = SITE_URL+'/my_bag';
                  $( "#mybag_div" ).load(window.location.href + " #mybag_div" );

                  _learnq.push(["track", "Added to Cart",cart_response.klaviyo_addtocart]);
                    gettrackingproductidinfo(id,quantity);  



                  


            }
            else if(cart_response.status=="FAILURE"){ // added new
              $(ref).html('<div class="add_to_cart">Add to cart</div>');
               swal('Alert!',cart_response.description);  
               //setTimeout(function(){ location.reload(); }, 1000);
                     
            }
            else
            {                
              swal('Error',response.description,'error');
            }  
          }  

      });

  }

function removeFromFavorite(ref)
{
  swal({
      title: 'Do you really want to remove this product from wishlist?',
      type: "warning",
      showCancelButton: true,
      // confirmButtonColor: "#DD6B55",
      confirmButtonColor: "#873dc8",
      confirmButtonText: "Yes, do it!",
      closeOnConfirm: false
    },
    function(isConfirm,tmp)
    {

       if(isConfirm==true)
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
                    showProcessingOverlay();          
                  },
                  success:function(response)
                  {
                    hideProcessingOverlay();
                    if(response.status == 'SUCCESS')
                    { 
                      swal({
                              title: 'Success',
                              text: response.description,
                              type: 'success',
                              confirmButtonText: "OK",
                              confirmButtonColor: "#873dc8",
                              iconColor: "#873dc8",
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
    });

}

function buyer_id_proof_warning()
{
    swal({
      title: "Alert!",
      text: "Your age verification process not completed yet, please upload your id proof documents.",
     // type: "warning",
      confirmButtonText: "OK"
    },
    function(isConfirm){
      if (isConfirm) {
        window.location.href = SITE_URL+"/buyer/age-verification";
      }
  }); 
}

</script>

<script>
  var _learnq = _learnq || [];
  window.dataLayer = window.dataLayer || [];

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
               
                  /* _learnq.push(["track", "Added to Cart", {
                    "ProductName": response.AddedItemProductName,
                   "ProductID": response.AddedItemProductID,
                   "Categories": response.AddedItemCategories,
                   "ImageURL": response.AddedItemImageURL,
                   "URL": response.AddedItemURL,
                   "Brand": response.Brand,
                   "Price": response.Price,
                   "CompareAtPrice": response.CompareAtPrice,
                   "Dispensary": response.Dispensary
                   }]);
                   */

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

                 //  _learnq.push(["track", "Added to Cart",item]);


                     dataLayer.push({
                        'event': 'GA - Add To Cart',
                        'ecommerce': {
                          'currencyCode': 'USD',
                          'add': {                                
                            'products': [{                       
                              'name':  response.AddedItemProductName,
                              'id':  response.AddedItemProductID,
                              'price': response.Price,
                              'brand': response.Brand,
                              'category': response.AddedItemCategories,
                             // 'variant': 'Gray',
                              'quantity': 1
                             }]
                          }
                        }
                     }); 




                }//success
            });


    }//if productid
    
  }//end function
</script>


<script>

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
          //'variant': productObj.variant,
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


<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>