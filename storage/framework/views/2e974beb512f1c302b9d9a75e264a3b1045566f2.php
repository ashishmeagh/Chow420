<?php $__env->startSection('main_content'); ?>
<style>
  .parsley-errors-list {position:inherit;}
  .popup-add {margin-top:10px;}
  .err_rating
 {
    font-size: 0.9em;
    line-height: 0.9em;
    color:red; 
 } 
 .top-rated-brands-list.favoiritelist{
        padding: 15px 10px 12px; width: 100%; margin-bottom: 0;
}

.rating-container .label.label-default{
  padding-top: 4px;
    display: inline-block;
    line-height: 52px;
}

</style>

<!--for Rating half star -->
<!--rating demo-->
      <script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/buyer/js/jquery.rating.js"></script>
      <script src="<?php echo e(url('/')); ?>/assets/buyer/js/star-rating.js" type="text/javascript"></script>
<link href="<?php echo e(url('/')); ?>/assets/buyer/css/star-rating.css" rel="stylesheet" />

<div class="my-profile-pgnm">
  <?php echo e(isset($page_title)?$page_title:''); ?>

    <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Reviews & Ratings</li>
    </ul>
</div> 
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper my-review-ratings-mns">
<div class="row">

  <?php 

  //dd($product_arr);

  ?>

    <?php if(isset($product_arr) && count($product_arr)>0): ?>

      <?php 
        $review_brandname ='';
        $review_sellername ='';
        $product_slug ='';
        $pageclick =[];

      ?>

      <?php $__currentLoopData = $product_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php

 

            $user_id = $review_str = "";
            $login_user = Sentinel::check();
            $user_id    = $login_user->id;

            if(isset($product['product_images_details'][0]['image']) && $product['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_images_details'][0]['image']))
            {
              $product_img = url('/uploads/product_images/'.$product['product_images_details'][0]['image']);
            }
            else
            {                  
              $product_img = url('/assets/images/default-product-image.png');
            }

             $is_review_added = is_review_added($product['id'],$user_id);
            if($is_review_added==1) $review_str = 'View Review';else $review_str = 'Add Review';

            $review_brandname = isset($product['get_brand_detail']['name'])?str_slug($product['get_brand_detail']['name']):'';

            $review_sellername = isset($product['get_seller_details']['seller_detail']['business_name'])?str_slug($product['get_seller_details']['seller_detail']['business_name']):'';

            $product_slug = isset($product['product_name'])?str_slug($product['product_name']):'';




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
               // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($product['id']).'/'.$product_slug.'/'.$review_brandname.'/'.$review_sellername ; 
               $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($product['id']).'/'.$product_slug; 
  


           ?>     



           <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 rating-cal">

             <div class="top-rated-brands-list favoiritelist my-review-ratings money-back-link-main-bx">

                

                <?php if(isset($product['first_level_category_details']['age_restriction']) && $product['first_level_category_details']['age_restriction']!="" && isset($product['first_level_category_details']['age_restriction_detail']['age']) && $product['first_level_category_details']['age_restriction_detail']['age']!=""): ?>
                  <div class="label-list">
                   <?php echo e($product['first_level_category_details']['age_restriction_detail']['age']); ?>

                  </div>
                <?php endif; ?>

                
                <a title="<?php echo e(isset($product['product_name'])?$product['product_name']:''); ?>" href="<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($product['id'])?base64_encode($product['id']):''); ?>/<?php echo e($product_slug); ?>" >



                <div class="img-rated-brands">
                    <div class="thumbnailss">
                        <img src="<?php echo e($product_img); ?>" class="portrait" alt="<?php echo e(isset($product['product_name'])?$product['product_name']:''); ?>"  onclick="return productclick(<?php echo e(isset($pageclick)?json_encode($pageclick):''); ?>)"/>
                    </div>
                    <div class="content-brands">
                          <div class="title-sub-list"><?php echo e(isset($product['first_level_category_details']['product_type'])?$product['first_level_category_details']['product_type']:''); ?>

                          </div>

                        

                         <!---------------show price here------------------>


                         </a>

                           <!-------------end of brand name----------------------->
                           
                           <a title="<?php echo e(isset($product['product_name'])?$product['product_name']:''); ?>" href="<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($product['id'])?base64_encode($product['id']):''); ?>/<?php echo e($product_slug); ?>"  onclick="return productclick(<?php echo e(isset($pageclick)?json_encode($pageclick):''); ?>)">


                        <div class="titlebrds"><?php echo e(isset($product['product_name'])?$product['product_name']:''); ?></div>


                            <p class="byr-review-rate"> 
                              <span>
                                 <?php
                                  $brand_name = isset($product['get_brand_detail']['name'])?$product['get_brand_detail']['name']:'';
                                  if(isset($brand_name)){
                                    $brandname = str_replace(' ','-',$brand_name); 
                                  }

                                 ?>

                                 <a href="<?php echo e(url('/')); ?>/search?brands=<?php echo e($brandname); ?>">
                                   <?php echo e(isset($product['get_brand_detail']['name'])?$product['get_brand_detail']['name']:''); ?>

                                </a>
                              </span>
                            </p> 



                        <div class="price-listing flotnon"> 
                            <?php if(isset($product['price_drop_to'])): ?>
                              <?php if($product['price_drop_to']>0): ?>
                                <del class="pricevies">$<?php echo e(isset($product['unit_price']) ? num_format($product['unit_price']) : '0'); ?></del>
                                <span>$<?php echo e(isset($product['price_drop_to']) ? num_format($product['price_drop_to']) : '0'); ?> </span>
                              <?php else: ?>
                              <del class="pricevies hidepricevies"></del>
                                <span>$<?php echo e(isset($product['unit_price']) ? num_format($product['unit_price']) : '0'); ?> </span>
                              <?php endif; ?>
                            <?php else: ?>
                            <del class="pricevies hidepricevies"></del>
                              <span>$<?php echo e(isset($product['unit_price']) ? num_format($product['unit_price']) : '0'); ?> </span>
                            <?php endif; ?>  
                         </div>   
                       

                    <?php if($review_str=='Add Review'): ?> 
                      
                      <?php
                      
                      $review_amount     = isset($site_setting_arr['buyer_review_amount'])?$site_setting_arr['buyer_review_amount']:'';
      
                      $add_review_str    = "Add a review to get $".$review_amount." in Chowcash";


                      ?>

                      <a product_id="<?php echo e(isset($product['id'])?$product['id']:''); ?>"  onclick="LoadAddReviewModal($(this));" class="view-review-links"><?php echo e(isset($add_review_str) ? $add_review_str : ''); ?></a>

                    <?php else: ?>
                      <a product_id="<?php echo e(isset($product['id'])?$product['id']:''); ?>"  onclick="LoadViewReviewModal($(this));"  class="view-review-links"><?php echo e($review_str); ?></a> 


                      <a product_id="<?php echo e(isset($product['id'])?$product['id']:''); ?>"  onclick="LoadEditReviewModal($(this));"  class="view-review-links edit_review pull-left"> Edit Review</a>

                      <div class="clearfix"></div>
                    <?php endif; ?> 



                    <!-- money back guarantee -->
                    <?php

                     $request_arr = isset($product['id'])?get_product_request_status($product['id']):'';

                    ?>

                    <?php if(isset($request_arr['status']) && $request_arr['status'] == 0): ?> 
                      
                      <div class="money-back-pendding">Reported</div> 
                    
                    <?php elseif(isset($request_arr['status']) && $request_arr['status'] == 2): ?>
                      
                      <a href="javascript:void(0);" product_id="<?php echo e(isset($product['id'])?$product['id']:''); ?>" id="btn_money_back_request" class="view-review-links money-back-link" onclick="showModel($(this));">Report Issue</a>

                      <div class="clearfix"></div>

                      <div class="money-back-requested" title="<?php echo e(isset($request_arr['note']) ? $request_arr['note'] : ''); ?>">Corrected</div>

                    <?php elseif(isset($request_arr['status']) && $request_arr['status'] == 1): ?>  
                       
                        <div class="money-back-approved">Refunded to wallet</div>
                    
                    <?php else: ?>
                    
                     <a href="javascript:void(0);" product_id="<?php echo e(isset($product['id'])?$product['id']:''); ?>" id="btn_money_back_request" class="view-review-links money-back-link" onclick="showModel($(this));">Report Issue</a>
                     
                    <?php endif; ?>
                    <!---->


                    </a>

                </div>
                </div>
                
                <div class="clearfix"></div>
            </div>
        </div>



     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

     <div class="clearfix"></div>
     <div class="pagination-chow"> 
            <?php if(!empty($arr_pagination)): ?>
                <?php echo e($arr_pagination->render()); ?>    
            <?php endif; ?> 
        </div>
  


     <?php else: ?>
       <div class="empty-product-main">
           <div class="empty-prodct">
               <img src="<?php echo e(url('/')); ?>/assets/front/images/empty-product.jpg" alt="">
           </div>
           <div class="empty-product-title">You didn't purchase any product yet</div>
           <div class="buyers-btn-mn">
                    <a href="<?php echo e(url('/')); ?>/search" class="butn-def">Continue Shopping</a>
                </div>
       </div>
     <?php endif; ?>
  





</div>
</div>

<div id="ReviewRatingsAddModal" class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo e(url('/')); ?>/assets/buyer/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">Add Review & Ratings</div>
            
            <form id="frm-add-review">
              <?php echo e(csrf_field()); ?>


             <div class="ratings-frms rating-space-top">
              <input type="hidden" name="product_id" id="product_id" value="">
              <div class="starrr text-left">
                   <input class="star required" type="radio" name="rating" id="rating" value="1"/>
                </div>
            </div>

            <!-- <div class="ratings-frms">
                <input type="hidden" name="product_id" id="product_id" value="">
                <div class="titledetailslist">Ratings</div>
                <div class='rating-stars'>
                    <ul id='stars'>
                      <li class='star' title='Poor' data-value='1'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                      <li class='star' title='Fair' data-value='2'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                      <li class='star' title='Good' data-value='3'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                      <li class='star' title='Excellent' data-value='4'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                      <li class='star' title='WOW!!!' data-value='5'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                    </ul>
                    <div id="err_rating"></div>
                  </div>
                   <input type="hidden" id="rating" name="rating">

                 </div> -->
              <div class="form-group">
                  <label for="">Title <span>*</span></label>
                  <input type="text" name="title" id="title" class="input-text" placeholder="Enter title" data-parsley-required="true" data-parsley-required-message="Please enter title">
              </div>
              <div class="form-group">
                  <label for="">Write Comment <span>*</span></label>
                  <textarea class="input-text" placeholder="Write your comment" name="review" id="review" data-parsley-required="true" data-parsley-minlength='20' data-parsley-required-message="Please enter comment"></textarea>
              </div>

              <?php /* ?> <div class="checkbox-dropdown" >
                Helped with
                <ul class="checkbox-dropdown-list" id="modalchkboxes">
                  <li>
                     <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="anxiety.svg" id="rememberMe11"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe11">
                              Anxiety
                               <img src='<?php echo url('/'); ?>/assets/images/anxiety.svg' width="32px"/>
                            </label>
                        </div>
                      </div>
                    </li>
                    <li>
                     <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="focus.svg" id="rememberMe12"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe12">
                              Focus
                               <img src='<?php echo url('/'); ?>/assets/images/focus.svg' width="32px">
                            </label>
                        </div>
                      </div>
                    </li>
                    <li>
                     <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="pain.svg" id="rememberMe13"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe13">
                              Pain
                               <img src='<?php echo url('/'); ?>/assets/images/pain.svg' width="32px">
                            </label>
                        </div>
                      </div>
                    </li>
                    <li>
                     <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="sleep.svg" id="rememberMe14"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe14">
                              Sleep
                               <img src='<?php echo url('/'); ?>/assets/images/sleep.svg' width="32px">
                            </label>
                        </div>
                      </div>
                    </li>       
                    <li>
                     <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="skin.svg" id="rememberMe15"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe15">
                              Skin
                               <img src='<?php echo url('/'); ?>/assets/images/skin.svg' width="32px">
                            </label>
                        </div>
                      </div>
                    </li>                               
                 </ul>
                </div> <?php */ ?>

                 <div class="checkbox-dropdown" >
                Helped with
                <ul class="checkbox-dropdown-list" id="modalchkboxes">
                  <?php if(isset($get_reported_effects) && !empty($get_reported_effects)): ?>
                   <?php $__currentLoopData = $get_reported_effects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li>
                     <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="<?php echo e($v['id']); ?>" id="rememberMe<?php echo e($v['id']); ?>"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe<?php echo e($v['id']); ?>">
                              <?php echo e(isset($v['title']) ? $v['title'] : ''); ?>

                              <?php if(file_exists(base_path().'/uploads/reported_effects/'.$v['image']) && isset($v['image']) && !empty($v['image'])): ?>
                               <img src='<?php echo e(url('/')); ?>/uploads/reported_effects/<?php echo e($v['image']); ?>' width="32px" title="<?php echo e($v['title']); ?>" />
                              <?php endif; ?> 
                            </label>
                        </div>
                      </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>  
                                                
                 </ul>
                </div>

                



            <div class="button-list-dts btn-order-cnls">
                <button class="butn-def" id="btn_send_review">Submit</button>
            </div>
          </form>  
            <div class="clr"></div>
        </div>
    </div>
</div>
<!-- Modal My-Review-Ratings-Add End -->




<!-- Modal My-Review-Ratings-View Start -->
<div id="ReviewRatingsViewModal" class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo e(url('/')); ?>/assets/buyer/images/closbtns.png" alt="" /> </button>
           
           <input type="hidden" id="product_id" value="">
           <div class="product-view-review-ratings">
               <div class="product-view-review-ratings-left">
                   <img id="product_img" src="" alt="" />
               </div>
               <div class="product-view-review-ratings-right">
                   <div class="title-view-ratings" id="product_name"></div>
                   <div class="title-sub-list" id="category_name"></div>
                   <div class="price-listing none-spadings" id="product_price"></div>
                   <div class="review-tgns"><img id="rating" src="" alt="" /></div>
               </div>
               <div class="clearfix"></div>
           </div>
           <hr>
           <div class="title-buyers-review-views-rw" id="title"></div>

            <div class="rvw-rtings" id="review"> </div>
            <div class="rvw-rtings" id="less_review"> </div>
            <div class="rvw-rtings" id="more_review"> </div>
            <div id="topreportedlabelid" style="display: none"> This helped with my:  

             </div> 
             <div class="rvw-rtings top-rated-div" id="emojis"></div>

            <div class="button-list-dts btn-order-cnls" data-dismiss="modal">
                <a class="butn-def">Close</a>
            </div>
            <div class="clr"></div>
        </div>
    </div>
</div>


<!----------------------------model for reported issue note--------------------------------->

<div class="modal fade" id="reported_note_model" tabindex="-1" role="dialog" aria-labelledby="StateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <form id="reported_note_form">
    <?php echo e(csrf_field()); ?>


    
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="StateModalLabel" align="center">Report Issue Note</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body admin-modal-new">
          <div class="title-imgd">
            
            <input type="hidden" name="reported_product_id" id="reported_product_id" value="">

            <label>Add Note</label>
             
            <textarea rows="5" name="reported_note" id="reported_note" class="form-control" placeholder="Enter note" data-parsley-required-message="Please enter note" data-parsley-required="true"></textarea>

            <span id="reported_note_error" style="color: red;"></span>

          </div>  <!------row div end here------------->         
      <!------body div end here------------->
      <div class="clearfix"></div>
        <button type="button" class="butn-def popup-add mrg-tp-cow" id="btn_text_add" onclick="sendMoneyBackRequest($(this));">Add</button>
      </div>
  </div>
  </form>
</div>
</div>


<!-- ---------------------------------------------------------------------------------------->

<script type="text/javascript">
  $(document).ready(function(){

  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    responseMessage(msg);
    
  });
  
});

      $('#stars li').click(function(){
         var rating = $(this).data('value'); 
         $("#err_rating").html("");
         $("#rating").val(rating);
      });


      $('#btn_send_review').click(function()
      { 
        var rating = $("#rating").val();
        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          return false; 
        }

        if($('#frm-add-review').parsley().validate()==false) return;

        var form_data   = $('#frm-add-review').serializeArray(); 
        form_data.push({name: 'rating', value: rating});
        
         var csrf_token = "<?php echo e(csrf_token()); ?>";
     
        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/store',
            type:"POST",
            data: form_data,             
            dataType:'json',
            beforeSend: function(){ 
             showProcessingOverlay();
             $('#btn_send_review').prop('disabled',true);
             $('#btn_send_review').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');

            },
            success:function(response)
            {
               hideProcessingOverlay();
              $('#btn_send_review').prop('disabled',false);
              $('#btn_send_review').html('Send Review');
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
           return false;
     }); 


   function LoadAddReviewModal(ref)
   {
    
      var product_id   = $(ref).attr('product_id');
      $("#ReviewRatingsAddModal #product_id").val(product_id);
      $("#ReviewRatingsAddModal").modal('show');

      $("input[name='emoji[]']:checkbox").prop('checked',false);

   }

   function LoadViewReviewModal(ref)
   {
      var emojiimg = '';
      var emoji_arr = '';
      var product_id   = $(ref).attr('product_id');
      var csrf_token   = "<?php echo e(csrf_token()); ?>";

        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/get_review_details',
            type:"POST", 
            data: {product_id:product_id,_token:csrf_token},             
            dataType:'json',
            beforeSend: function(){ 
              showProcessingOverlay();
            },
            success:function(response)
            {

              function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
              }
               hideProcessingOverlay();
              if(response.status == 'SUCCESS') 
              { 
                if(response.emoji)
                {
                   // var emoji_arr = response.emoji.split(','); 
                   // if(emoji_arr)
                   // {
                   //   var emojiimg = '<ul class="list-inline">';
                   //   for (i = 0; i < emoji_arr.length; i++) {
                   //    var em = emoji_arr[i].split('.');
                   //       emojiimg += '<li><img src=<?php echo e(url('/')); ?>/assets/images/'+emoji_arr[i]+'  width="32px"/> <label>'+capitalizeFirstLetter(em[0].replace('_',' '))+'</label> </li>' ;
                   //    } 
                   //    emojiimg +='</ul>';
                   // }

                   var emoji_arr = JSON.parse(response.emoji); 
                   if(emoji_arr)
                   {

                     var emojiimg = '<ul class="list-inline">';
                     for (i = 0; i < emoji_arr.length; i++) {
                         emojiimg += '<li><img src=<?php echo e(url('/')); ?>/uploads/reported_effects/'+emoji_arr[i]['image']+'  width="32px"/> <label>'+emoji_arr[i]['title']+'</label> </li>' ;
                      } 
                      emojiimg +='</ul>';
                   }


                }
                if(emojiimg)
                {
                  
                  $("#ReviewRatingsViewModal #topreportedlabelid").show();
                }
                $("#ReviewRatingsViewModal #emojis").html(emojiimg);

                var product_price =  parseFloat(response.product_price);

                if (response.review.length < 100) {

                  $("#ReviewRatingsViewModal #less_review").html('');
                  $("#ReviewRatingsViewModal #more_review").html('');
                  $("#ReviewRatingsViewModal #review").html(response.review);
                  $("#ReviewRatingsViewModal #review").show();
                }
                else {
                  
                  $("#ReviewRatingsViewModal #review").hide();
                  $("#ReviewRatingsViewModal #less_review").show();
                  $("#ReviewRatingsViewModal #less_review").html(response.review.substring(0, 100)+"<span class='show-more' style='color: #873dc8;cursor: pointer;' onclick='return showmore()'> See more</span>");
                  $("#ReviewRatingsViewModal #more_review").html(response.review+"<span class='show-more' style='color: #873dc8;cursor: pointer;' onclick='return showless()'> See less</span>").hide();
                }
                $("#ReviewRatingsViewModal #title").html(response.title);
                $("#ReviewRatingsViewModal #product_name").html(response.product_name);
                $("#ReviewRatingsViewModal #product_price").html('$'+product_price.toFixed(2));
                $("#ReviewRatingsViewModal #category_name").html(response.category_name);
                // $("#ReviewRatingsViewModal #rating").attr('src',SITE_URL+'/assets/buyer/images/star-rate-'+response.rating+'.png');

                 $("#ReviewRatingsViewModal #rating").attr('src',SITE_URL+'/assets/buyer/images/star/'+response.rating+'.svg');

                $("#ReviewRatingsViewModal #rating").attr('title',response.ratingval+' Rating');

                if(response.product_image!="")
                { 
                  $.ajax({
                      url:SITE_URL+'/uploads/product_images/'+response.product_image,
                      type:'HEAD',
                      error: function()
                      {
                        $("#ReviewRatingsViewModal #product_img").attr('src',SITE_URL+'/assets/images/default-product-image.png');
                      },
                      success: function()
                      {
                         $("#ReviewRatingsViewModal #product_img").attr('src',SITE_URL+'/uploads/product_images/'+response.product_image);
                      }
                  }); 
                
                }
                else
                {
                   $("#ReviewRatingsViewModal #product_img").attr('src',SITE_URL+'/assets/images/default-product-image.png');
                }

              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 
      $("#ReviewRatingsViewModal #product_id").val(product_id);
      $("#ReviewRatingsViewModal").modal('show');
   }

   function showmore() {
    $("#ReviewRatingsViewModal #less_review").hide();
    $("#ReviewRatingsViewModal #more_review").show();
   }
   function showless() {
    $("#ReviewRatingsViewModal #more_review").hide();
    $("#ReviewRatingsViewModal #less_review").show();
   }


</script>






<!-- Modal My-Review-Ratings-View Start -->
<div id="ReviewRatingEditModal" class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <div class="modal-content">

           <form id="frm-edit-review-modal" method="post" onsubmit="return false;">
              <?php echo e(csrf_field()); ?>


            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo e(url('/')); ?>/assets/buyer/images/closbtns.png" alt="" /> </button>
           
           <input type="hidden" id="product_id_modal" name="product_id_modal" value="">
            <input type="hidden" name="review_id" id="review_id" value="">   
            <input type="hidden" name="rating_modal" id="rating_modal" value="">   

               <div class="form-group">             
                <label for="">Previous Ratings : <span> <img id="rating" src="" alt="" /> </span></label>
              </div>

            <div class="ratings-frms">

              <div class="starrr text-left">
                   New Ratings : 
                   <input class="star required" type="radio" name="ratingnew" id="ratingnew" value=""/>
                </div>
            </div>

             <div class="form-group">
                  <label for="">Title <span>*</span></label>
                  <input type="text" name="title" id="title" class="input-text" placeholder="Enter title" data-parsley-required="true" data-parsley-required-message="Please enter title">
              </div>
              <div class="form-group">
                  <label for="">Comment <span>*</span></label>
                  <textarea class="input-text" placeholder="Write your comment" name="review" id="review" data-parsley-required="true" data-parsley-minlength='20' data-parsley-required-message="Please enter comment"></textarea>
              </div>

               <div class="checkbox-dropdown" >
                Helped with
                <ul class="checkbox-dropdown-list" id="modalchkboxes">

                 <?php if(isset($get_reported_effects) && !empty($get_reported_effects)): ?>
                   <?php $__currentLoopData = $get_reported_effects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                     <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="<?php echo e($v['id']); ?>" id="rememberMe1<?php echo e($v['id']); ?>"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe1<?php echo e($v['id']); ?>">
                              <?php echo e(isset($v['title']) ? $v['title'] : ''); ?>

                               <?php if(file_exists(base_path().'/uploads/reported_effects/'.$v['image']) && isset($v['image']) && !empty($v['image'])): ?>
                               <img src='<?php echo e(url('/')); ?>/uploads/reported_effects/<?php echo e($v['image']); ?>' width="32px" title="<?php echo e($v['title']); ?>" />
                               <?php endif; ?> 
                            </label>
                        </div>
                      </div>
                     </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   <?php endif; ?>  
                 </ul>
                </div>
 

            <div class="button-list-dts btn-order-cnls" data-dismiss="modal">
                <a class="butn-def btn_send_review_editmodal" id="btn_send_review_editmodal">Save</a>
            </div>
            <div class="clr"></div>

          </form>
        </div>
    </div>
</div>



<script>
  
   function LoadEditReviewModal(ref)
   {
    
         var emoji ='';
    
      var product_id   = $(ref).attr('product_id');
      var csrf_token   = "<?php echo e(csrf_token()); ?>";

        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/get_review_details',
            type:"POST", 
            data: {product_id:product_id,_token:csrf_token},             
            dataType:'json',
            beforeSend: function(){ 
              showProcessingOverlay();
            },
            success:function(response)
            {
               hideProcessingOverlay();
              if(response.status == 'SUCCESS') 
              { 
                // $("#ReviewRatingEditModal #ratingnew").val(response.ratingval);
                $("#ReviewRatingEditModal #review_id").val(response.review_id);
                $("#ReviewRatingEditModal #rating_modal").val(response.ratingval);
                $("#ReviewRatingEditModal #review").val(response.review);
                $("#ReviewRatingEditModal #title").val(response.title);
                // $("#ReviewRatingEditModal #rating").attr('src',SITE_URL+'/assets/buyer/images/star-rate-'+response.rating+'.png');
                $("#ReviewRatingEditModal #rating").attr('src',SITE_URL+'/assets/buyer/images/star/'+response.rating+'.svg');
                $("#ReviewRatingEditModal #rating").attr('title',response.ratingval+' Rating');
            
                  var emoji = response.emoji;
                  //  $.each(emoji.split(","), function(i,e){

                  //     $('input:checkbox[name="emoji[]"][value="' + e + '"]').prop('checked',true);
                  //     console.log(e);
                  // });
                   var emoji_arr = JSON.parse(response.emoji); 
                   if(emoji_arr)
                   {
                     $.each(emoji_arr, function(i,e){
                     
                        $('input:checkbox[name="emoji[]"][value="' + e.id + '"]').prop('checked',true);
                        console.log(e);
                      });
                   }//if emoji_arr

              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 
      $("#ReviewRatingEditModal #product_id_modal").val(product_id);
      $("#ReviewRatingEditModal").modal('show');
   }
   


//function for update review modal
$('.btn_send_review_editmodal').click(function()
      { 

         var rating_new = $("#ratingnew").val();
         if(rating_new>0){

          var rating = rating_new;
         }
         else{
           var rating = $("#rating_modal").val();
         }
         
        var productid = $("#product_id_modal").val();

        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          return false; 
        }

        if($('#frm-edit-review-modal').parsley().validate()==false) return;

        var form_data   = $('#frm-edit-review-modal').serializeArray(); 
        form_data.push({name: 'rating_modal', value: rating});

         var csrf_token = "<?php echo e(csrf_token()); ?>";
         
        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/update',
            type:"POST",
            data: form_data,             
            dataType:'json',
            beforeSend: function(){ 
            // showProcessingOverlay();
             $('.btn_send_review_editmodal').prop('disabled',true);
             $('.btn_send_review_editmodal').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');

            },
            success:function(response)
            {
             //  hideProcessingOverlay();
              $('.btn_send_review_editmodal').prop('disabled',false);
              $('.btn_send_review_editmodal').html('Send Review');
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
                        
                        $("#ReviewRatingEditModal").modal('hide');

                      }

                    });
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 
           return false;
     }); 



</script>

<script>

function productclick(productObj) {

 var dataLayer = dataLayer || []; 


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

<script type="text/javascript">
  $(".checkbox-dropdown").click(function () {
    $(this).toggleClass("is-active");
});

$(".checkbox-dropdown ul").click(function(e) {
    e.stopPropagation();
});


/*show report issue model*/

function showModel(ref)
{
  var product_id = $(ref).attr('product_id');
  $("#reported_product_id").val(product_id);
  $("#reported_note_model").modal('show');
}



/*send reported issue request to admin*/

function sendMoneyBackRequest(ref){

  //var product_id = $(ref).attr('product_id');



  var product_id = $("#reported_product_id").val();

  var note = $("#reported_note").val();

  var csrf_token = "<?php echo e(csrf_token()); ?>";


  if($('#reported_note_form').parsley().validate()==false) return;

  $.ajax({
            url: SITE_URL+'/buyer/review-ratings/money_back_request',
            type:"POST",
            data: {product_id:product_id,_token:csrf_token,note:note},             
            dataType:'json',
            beforeSend: function(){ 
               showProcessingOverlay();
            },
            success:function(response)
            {
                hideProcessingOverlay();

                $("#reported_note_model").modal('hide');
               
                $('#reported_note_form')[0].reset();

              
                if(response.status == 'success')
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

                          //$("#btn_money_back_request").
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

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>