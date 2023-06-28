<?php $__env->startSection('main_content'); ?>

<style>
  .faqsec .panel-title > a,.faqsec .panel-title > a:focus {
  display: block;
  position: relative;
  outline:none;
}
.faqsec .panel-title > a:after {
  content: "\f067"; /* fa-chevron-down */
  font-family: 'FontAwesome';
  position: absolute;
  right: 0;
  top:-6px;

  width: 30px;
  height: 30px;
  border-radius: 50%;
  text-align: center;
  line-height: 30px;
  border:1px solid #e6e5eb;
  color:#333;
}
.faqsec .panel-title > a[aria-expanded="true"]:after {
  content: "\f068"; /* fa-chevron-up */
  background-color:#873dc8;
  color:#fff;
}

.faqsec {margin-top:0px; margin-bottom: 30px;}
/*.faqsec .panel-group {
 border: 1px solid #ccc;
}*/
.faqsec .panel-group .panel {border:none; box-shadow:none;}
.faqsec .panel-heading {background:#fff; padding:15px; border-bottom:1px solid #e6e5eb}
.faqsec .panel-body {background-color:#f8f8fa; border-left:3px solid #873dc8; border-bottom:1px solid #e6e5eb; line-height:25px; font-weight:normal; font-size:14px;}
.faqsec .panel-default {margin-top:0px;}
.faqttl {font-weight:normal;}
/*h2.resp-accordion:first-child:after{
  content: "\f068";
    background-color: #873dc8;
    color: #fff !important;
    top: 6px;
}*/
/*
.collapse.in{
    display: block;
}
.panel-default > .panel-heading + .panel-collapse > .panel-body {
    border-top-color: #fff;
}*/
.star-processs div {
    position:relative;
    margin:10px;
    width:220px; height:220px;
}
.star-processs canvas {
    display: block;
    position:absolute;
    top:0;
    left:0;
}
.star-processs span {
    color:#555;
    display:block;
    line-height:220px;
    text-align:center;
    width:220px;
    font-family:sans-serif;
    font-size:40px;
    font-weight:100;
    margin-left:5px; display: none;
}

.star-processs input {
    width: 200px;
}


.star-processs div.review-count {
        width: 70px;
    height: 60px;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    margin: auto;
    z-index: 99;
    font-size: 50px;
}



.desc-inner-div {
  margin-top:5px;
}

.desc-inner-div .desc-inner-title{ 
  font-weight: bold;
}



.popup-add {margin-top:10px;}
.parsley-errors-list {position:inherit;}
.productdetailspage .thumbnail {position:relative;}
.hover-img {
  /*opacity:0; position:absolute; bottom:0px; right:0; z-index:1; width:250px;*/
display: none;
    position: absolute;
    top: 90px;
    left: 0;
    z-index: 1;
    width: 250px;
}
/*.productdetailspage .thumbnail:hover .hover-img {opacity:1;}*/
.productdetailspage .thumbnail:hover .hover-img{display: block;}

.pro-detail-video-button {
  /*width: 60px;
    height: 60px;
    position: absolute;
    top: 140px;
    left: 10%;
    margin: -21px 0 0 -30px;
    display: block;
    background-color: rgba(0,0,0,.5);
    -webkit-box-shadow: 0 0 0 2px #fff;
    box-shadow: 0 0 0 2px #fff;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    -webkit-transition: all .4s ease;
    transition: all .4s ease;
    -webkit-transform: scale(.8);
    -ms-transform: scale(.8);
    transform: scale(.8);
    z-index: 9;*/
    width: 60px;
    height: 60px;
    position: relative;
    padding-top: 1px;
    top: 24px;
    left: 29px;
    margin: -21px 0 0 -30px;
    display: block;
    background-color: rgba(0,0,0,.5);
    -webkit-box-shadow: 0 0 0 2px #fff;
    box-shadow: 0 0 0 2px #fff;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    -webkit-transition: all .4s ease;
    transition: all .4s ease;
    -webkit-transform: scale(.8);
    -ms-transform: scale(.8);
    transform: scale(.8);
    z-index: 9;
}


.pro-detail-video-button img {
    width: 30px;
    height: auto;
    margin-top: 15px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.modal-dialog {
    margin: 10px auto 0;
}
/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 100%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
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
@media  all and (max-width:550px){
 .main-logo {
    width: 60px;
}
}

</style>


 
 <link href="<?php echo e(url('/')); ?>/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />
 


 


 <!--tab css start-->
 <link href="<?php echo e(url('/')); ?>/assets/front/css/easy-responsive-tabs-v.css" rel="stylesheet" type="text/css" />

 <!--for Rating half star -->


<link href="<?php echo e(url('/')); ?>/assets/buyer/css/star-rating.css" rel="stylesheet" />


<link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/front/css/jquery-ui-tab.css">


<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php 
 $category_id = ""; 
 if(isset($arr_product['first_level_category_id']))
 {
   // $category_id = base64_encode($arr_product['first_level_category_id']);

  
    $category_name = isset($arr_product['first_level_category_details']['product_type'])?$arr_product['first_level_category_details']['product_type']:'';
    $category_name = str_replace(" ", "-", $category_name);  
    $category_id = str_replace("-&-", "-and-", $category_name);    
 }
if(isset($arr_product['is_active']) || isset($arr_product['is_approve']))
{
  if($arr_product['is_active']==0 || $arr_product['is_approve']==0)
  {
    echo "<script>window.location='".url('/')."';</script>";
  }

}

$product_id = base64_decode(Request::segment(3));
$avg_rating  = get_avg_rating($product_id);
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

$firstcat_id = isset($arr_product['first_level_category_id'])?$arr_product['first_level_category_id']:'';
$restrictseller_id   = isset($arr_product['user_id'])?$arr_product['user_id']:'';

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


$loggedinuser = 0;
$loged_user = Sentinel::check();

if(isset($loged_user) && $loged_user==true)
{
  $loggedinuser = $loged_user->id;
}
else{
  $loggedinuser = 0;
}



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




// condition added for buyer state restriction
if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers))
{
  if(in_array($restrictseller_id, $restricted_state_sellers))
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



/********************Restricted states seller id***********************/



?>


<div class="productdetailspage">
<!--------------------start of modal-------------------------------------->
<div class="modal fade" id="reportproduct_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


  <div class="modal-dialog" role="document">



    <input type="hidden" name="buyer_id" id="buyer_id" value="">
   <input type="hidden" name="hidden_product_id" id="hidden_product_id" value="">
   <input type="hidden" name="to_id" id="to_id" value="">
   <input type="hidden" name="from_email" id="from_email" value="">


    <div class="modal-content">

      <div class="modal-header mdl-boder-btm">
        <h3 class="modal-title" id="exampleModalLabel" align="center">Report Product</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="report_body">
        <div class="mainbody-mdls">
        
          
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"> <b>To : </b></div>
             <div class="mainbody-mdls-fd-right" id="to"></div>
             <div class="clearfix"></div>
          </div>
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"><b>Product Link :</b></div>
             <div class="mainbody-mdls-fd-right link-http" id="link"></div>
             <div class="clearfix"></div>
          </div>

          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"> <b>Message :</b></div>
             <div class="mainbody-mdls-fd-right">
               <textarea id="message" rows="5" class="form-control" placeholder="Please enter your message here..." maxlength="300"></textarea>

               <div class="report-note">Note: Only 300 characters allowed.</div>  

               <span id="msg_err"></span>

             </div>
             <div class="clearfix"></div>
          </div>

        </div>
      
      </div>
      <div class="modal-footer">
        <div class="sre-product">
        
 <img src="<?php echo e(url('/')); ?>/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" / alt="loader">
        <a  class="shdebtns sendbuttons" id="sendreport">Send</a>

        </div>
      </div>
    </div>
  </div>
</div>
<!-----------------end of modal---------------------->
<?php

if(Sentinel::Check())
{
 $login_user = Sentinel::getUser();
 $login_id = $login_user['id'];
 $login_email = $login_user['email']; 
}
?>



<div class="listing-page-main prodetailpage">
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <div class="top-breadcrum-list space-bottns">
                    <a href="<?php echo e(url('/')); ?>">Home</a> <span>/</span> <a href="<?php echo e(url('/')); ?>/search?category_id=<?php echo e($category_id); ?>"><?php echo e(isset($arr_product['first_level_category_details']['product_type'])?$arr_product['first_level_category_details']['product_type']:''); ?></a> <span>/</span> <div class="breadcm-span"><?php echo e(isset($arr_product['product_name'])? $arr_product['product_name']: ''); ?></div>
                </div>
                <?php
                          $login_user = Sentinel::check();
                          $fav_arr    = array();
                           if(count($fav_product_arr)>0)
                          {
                           foreach($fav_product_arr as $key=>$value)
                           {
                             $fav_arr[] = $value['product_id'];
                           }

                          }

                          /*if(isset($arr_product['product_image']) && $arr_product['product_image'] != '' && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_image']))
                          {
                            $product_img        = url('/uploads/product_images/'.$arr_product['product_image']);
                          }
                          else
                          {                  
                            $product_img        = url('/assets/images/no-product-img-found.jpg');
                          }*/

                          $product_id = 0;
                          $seller_product_ids = [];
                          if(Request::segment(3)!='')
                          {

                            $product_id = base64_decode(Request::segment(3));
                            if(count($seller_products)>0)
                            {
                               foreach($seller_products as $key=>$value)
                               {
                                 $seller_product_ids[] = $value['id']; 
                               }
                            }

                          }

                        ?>

            

                <!-------------------new demo of image zoom------------------->

               

               <div id="container-all" class="img-demo-zoom">
              

                  <!----------------div added for coa----------------------->

                  <?php 

                      $show_labresulttab = 1;
                      if(isset($arr_product['first_level_category_id']))
                      {
                         $get_categoryinfo = get_first_levelcategorydata($arr_product['first_level_category_id']);
                         if(isset($get_categoryinfo) && $get_categoryinfo=="Essential Oils" || $get_categoryinfo=="Accessories"){
                            $show_labresulttab = 0;
                           }
                         else
                         {
                             $show_labresulttab = 1;
                         } 
                      }//if isset firstlevelcategory data


                     if(isset($arr_product['spectrum']))
                    {
                         $get_spectruminfo = get_spectrum_val($arr_product['spectrum']);
                         if(isset($get_spectruminfo) && !empty($get_spectruminfo))
                         {
                           if($get_spectruminfo['name']=="Hemp Seed"){
                             $show_labresulttab = 0;
                           }else{
                             $show_labresulttab = 1;
                           }         
                         }
                         else
                         {
                             $show_labresulttab = 1;
                         } 
                    }//if isset spectrum data
                  ?>



                    <div class="view-icon-details">
                      
                     <?php

                     if(isset($show_labresulttab) && $show_labresulttab==1){

                     if(isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate']))
                     {
                      $ext = pathinfo($arr_product['product_certificate'], PATHINFO_EXTENSION);
                      if($ext=="pdf"){ 
                     ?>

                      <div class="disv-zooms">
                         
                          <a href="<?php echo e(url('/')); ?>/uploads/product_images/<?php echo e($arr_product['product_certificate']); ?>" target="_blank"><img src="<?php echo e(url('/')); ?>/assets/front/images/coa.png" alt="COA">
                          </a>
                          
                      </div>


                     <?php
                        }else{
                       if(!empty($arr_product['product_certificate']) && count($arr_product['product_images_details']) && file_exists(base_path().'/uploads/product_images/thumb/'.$arr_product['product_certificate'])){
                         $certificate_val = $arr_product['product_certificate'];
                      ?>
                      <div class="disv-zooms" id="lightgallery">
                          
                          <a href="" data-responsive="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_certificate']); ?>" data-src="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_certificate']); ?>" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>"><img src="<?php echo e(url('/')); ?>/assets/front/images/coa.png" alt="COA" class="lozad"> </a>
                          
                          </div>

                      <?php   
                         }//else
                       }
                      }//if isset certificate
                     }//if lab results is 1 
                     ?>

                  <!-----------------end of div of coa----------------------->


                       



                        <?php if(isset($arr_product['first_level_category_details']['is_age_limit']) && $arr_product['first_level_category_details']['is_age_limit'] == 1 && isset($arr_product['first_level_category_details']['age_restriction']) && $arr_product['first_level_category_details']['age_restriction'] != ''): ?>
                          <div class="age-img-plus">

                            <?php
                                if(isset($arr_product['first_level_category_details']['age_restriction_detail']['age']))
                                 $age_restrict = $arr_product['first_level_category_details']['age_restriction_detail']['age'];
                               else
                                 $age_restrict = '';
                             ?>

                             <?php if($age_restrict=="18+"): ?>
                              <div class="age-img-inline" title="18+ Age restriction">
                                <img src="<?php echo e(url('/')); ?>/assets/front/images/product-age-mini.png" alt="Chow420"> 
                              </div>
                              <?php endif; ?>

                              <?php if($age_restrict=="21+"): ?>
                                <div class="age-img-inline" title="21+ Age restriction">
                                  <img src="<?php echo e(url('/')); ?>/assets/front/images/product-age-max.png" alt="Chow420"> 
                                </div>
                              <?php endif; ?>

                         </div>
                        <?php endif; ?>


                    <!------tag-details-pg--------------> 



                    <!-- Video Start-->
                     <?php if(isset($arr_product['product_images_details'][0]['image']) && !empty($arr_product['product_images_details'][0]['image'])): ?>
                  <div class="big-img">
                    <div class="row">
                      <article class="col-md-12">
                        <div class="thumbnail ">
                        <div class="hover-img">
                          <?php if(isset($arr_product['product_video_url']) && !empty($arr_product['product_video_url'])): ?>
                            <?php
                            if($arr_product['product_video_source']=="vimeo")
                            {
                            ?>                            
                              <img data-src="<?php echo e(isset($arr_product['url_id']) ? $arr_product['url_id'] : ''); ?>" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" class="lozad">
                            <?php
                            }else{
                            ?>
                              <img data-src="http://img.youtube.com/vi/<?php echo e(isset($arr_product['url_id']) ? $arr_product['url_id'] : ''); ?>/0.jpg" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" class="lozad">
                            <?php
                            }
                            ?>
                          <?php endif; ?>
                        </div>
                          <?php if(isset($arr_product['product_video_url']) && !empty($arr_product['product_video_url'])): ?>
                            <a href="javascript:void(0)"  class="pro-detail-video-button" id="product_video_popup" data-video-source="<?php echo e($arr_product['product_video_source']); ?>" data-video-id="<?php echo e($arr_product['product_video_url']); ?>" data-video-title="<?php echo e(isset($arr_product['product_name'])? $arr_product['product_name']: ''); ?>" onclick="openProductVideoModal(this);">
                              <img src="<?php echo e(url('/')); ?>/assets/front/images/video-camera-icons.svg" alt=""> 
                            </a>
                          <?php endif; ?>
                          <!-- <div class="ex-thumbnail-zoom">
                            <div class="ex-thumbnail-zoom-img" data-scale="3" 
                               data-image="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_images_details'][0]['image']); ?>" ></div>
                          </div> -->
                        </div>
                      </article>
                    </div>
                  </div>
                  <?php endif; ?>
                    <!-- Video End -->


                  <!-----------------end of div of coa----------------------->
                  
                  <?php
                    if(!empty($arr_product['product_video_source']))
                    {                    
                  ?>
                  
                  <?php   
                    }
                  ?>
                  </div>
                 <!--  <?php if(isset($arr_product['product_images_details'][0]['image']) && !empty($arr_product['product_images_details'][0]['image'])): ?>
                  <div class="big-img">
                    <div class="row">
                      <article class="col-md-12">
                        <div class="thumbnail ">
                        <div class="hover-img">
                          <?php if(isset($arr_product['product_video_url']) && !empty($arr_product['product_video_url'])): ?>
                            <?php
                            if($arr_product['product_video_source']=="vimeo")
                            {
                            ?>                            
                              <img src="<?php echo e(isset($arr_product['url_id']) ? $arr_product['url_id'] : ''); ?>">
                            <?php
                            }else{
                            ?>
                              <img src="http://img.youtube.com/vi/<?php echo e(isset($arr_product['url_id']) ? $arr_product['url_id'] : ''); ?>/0.jpg">
                            <?php
                            }
                            ?>
                          <?php endif; ?>
                        </div>
                          <?php if(isset($arr_product['product_video_url']) && !empty($arr_product['product_video_url'])): ?>
                            <a href="javascript:void(0)"  class="pro-detail-video-button" id="product_video_popup" data-video-source="<?php echo e($arr_product['product_video_source']); ?>" data-video-id="<?php echo e($arr_product['product_video_url']); ?>" data-video-title="<?php echo e(isset($arr_product['product_name'])? $arr_product['product_name']: ''); ?>" onclick="openProductVideoModal(this);">
                              <img src="<?php echo e(url('/')); ?>/assets/front/images/video-camera-icons.svg" alt=""> 
                            </a>
                          <?php endif; ?>
                          <div class="ex-thumbnail-zoom">
                            <div class="ex-thumbnail-zoom-img" data-scale="3" 
                               data-image="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_images_details'][0]['image']); ?>" ></div>
                          </div>
                        </div>
                      </article>
                    </div>
                  </div>
                  <?php endif; ?> -->
                  <?php if(isset($arr_product['product_images_details'][0]['image']) && !empty($arr_product['product_images_details'][0]['image'])): ?>
                         <div class="ex-thumbnail-zoom">

                          <?php
                            $final_product_image = image_resize('/uploads/product_images/thumb/'.$arr_product['product_images_details'][0]['image'],390,350);
                          ?>

                            <div class="ex-thumbnail-zoom-img" data-scale="3" 
                               data-image="<?php echo e($final_product_image); ?>" ></div>

                            
                                  
                          </div>
                          <?php endif; ?>
                  
                  <div class="container-selection" style="display: none !important;">
                     <?php if(!empty($arr_product['product_images_details'][0]['image']) && count($arr_product['product_images_details']) && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_images_details'][0]['image'])): ?>
                    <label onclick='changePreviewProduct("<?php echo e(url('/')); ?>/uploads/product_images/<?php echo e($arr_product['product_images_details'][0]['image']); ?>")'>
                      <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e(url('/')); ?>/uploads/product_images/<?php echo e($arr_product['product_images_details'][0]['image']); ?>" alt="Chow420">
                    </label> 
                    <?php endif; ?>

                    <?php if(!empty($arr_product['product_certificate']) && count($arr_product['product_images_details']) && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate'])): ?>
                    <label onclick='changePreviewProduct("<?php echo e(url('/')); ?>/uploads/product_images/<?php echo e($arr_product['product_certificate']); ?>")'>
                      <img data-src="<?php echo e(url('/')); ?>/uploads/product_images/<?php echo e($arr_product['product_certificate']); ?>" alt="Certificate" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" class="lozad">
                    </label>
                    <?php endif; ?>
                   
                  </div><!------container-selection------------>

                  


               </div>
                <!----------------end of new demo of image zoom------------->







                 <?php 
                    $total_review = get_total_reviews($product_id);
                    $getavg_rating  = get_avg_rating($product_id);   
                 ?>
                
                <div class="listing-details">
                    
                     


                    <div class="title-chw-list">
                       <?php
                        $brand_name = isset($arr_product['get_brand_detail']['name'])?$arr_product['get_brand_detail']['name']:'';
                        if(isset($brand_name)){
                          $brandname = str_replace(' ','-',$brand_name); 
                        }
                       ?>

                       

                                 

                       <h1 class="titlename-list">
                        <?php echo e(isset($arr_product['id'])?get_product_name($arr_product['id']):''); ?>

                       </h1>

                    </div>
                    
                     
                       
                        <!----------------------show by brand here--------------------->

                         <p class="bybrandlink-details inline-p"> by 
                          <h1 class="h1-p">
                            <span>
                               <?php
                                $brand_name = isset($arr_product['get_brand_detail']['name'])?$arr_product['get_brand_detail']['name']:'';
                                if(isset($brand_name)){
                                  $brandname = str_replace(' ','-',$brand_name); 
                                }

                               ?>
                               <a  href="<?php echo e(url('/')); ?>/search?brands=<?php echo e($brandname); ?>">
                                 <?php echo e(isset($arr_product['get_brand_detail']['name'])?ucfirst($arr_product['get_brand_detail']['name']):''); ?>

                              </a>
                            </span>
                            </h1>
                          </p> 

                        <!--------------------end of-show by brand here----------------->

                        <!-----------------show---rating----------------------------->

                              <?php if($avg_rating>0): ?>
                                  <div class="stars" id="start_rating_review" <?php if($avg_rating>0): ?> title="<?php echo e(isset($avg_rating)?$avg_rating:''); ?> Rating is a combination of all ratings on chow in addition to ratings on vendor site." <?php endif; ?>> 
                                  
                                    <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_avg_rating)?$img_avg_rating.'.svg':''); ?>" alt="<?php echo e(isset($img_avg_rating)?$img_avg_rating:''); ?>"> 

                                     <!-- <span style=" color: #3e3e3e;"> <?php echo e(isset($getavg_rating)? $getavg_rating:''); ?></span> -->

                                     <?php if($total_review > 0): ?>
                                     <span href="#" class="str-links starcounts" 
                                        title=" <?php if($total_review==1): ?>  
                                                <?php echo e($total_review); ?> Rating 
                                                <?php elseif($total_review>1): ?>  
                                                <?php echo e($total_review); ?> Ratings 
                                                <?php endif; ?>
                                              ">
                                       

                                         <?php echo e($avg_rating); ?>

                                         <?php if(isset($total_review)): ?> (<?php echo e($total_review); ?>) <?php endif; ?>

                                      </span>
                                     <?php endif; ?>
                                  </div>
                           <?php endif; ?> 

                        <!--------------end rating----------------------------------->

                        <!-------------------show price--------------------------------->
                               <div class="price-block prilbls priceviewschow">
                                  <div class="pricevies">Price:</div>
                                  
                                  <?php if(isset($arr_product['price_drop_to'])): ?>
                                    <?php if($arr_product['price_drop_to']>0): ?>
                                     <?php
                                     if(isset($arr_product['percent_price_drop']) && $arr_product['percent_price_drop']=='0.000000') 
                                     {
                                     $percent_price_drop = calculate_percentage_price_drop($arr_product['id'],$arr_product['unit_price'],$arr_product['price_drop_to']); 
                                     $percent_price_drop = floor($percent_price_drop);
                                     }
                                     else
                                     { 
                                      $percent_price_drop = floor($arr_product['percent_price_drop']);
                                     }
                                     ?>
                                    <h2>$<?php echo e(isset($arr_product['price_drop_to']) ? num_format($arr_product['price_drop_to']) : '0'); ?> </h2>
                                      <del class="pricevies pricevies">$<?php echo e(isset($arr_product['unit_price']) ? num_format($arr_product['unit_price']) : '0'); ?></del> <span class="detailpage-pricedrop">(<?php echo e($percent_price_drop); ?>% off) </span>
                                      
                                    <?php else: ?>
                                    <h2>$<?php echo e(isset($arr_product['unit_price']) ? num_format($arr_product['unit_price']) : '0'); ?> </h2>
                                    <?php endif; ?>
                                  <?php else: ?>
                                    <h2>$<?php echo e(isset($arr_product['unit_price']) ? num_format($arr_product['unit_price']) : '0'); ?> </h2>
                                  <?php endif; ?> 
                                                            
                                  
                                  <div class="clearfix"></div>
                              </div>     
                        <!----------------end-price------------------------------------>


                        <!--------show--shipping-days-------------------->
                        <div class="delivr-class">
                          <?php 
                             $str_delivery_durationfrom = $str_delivery_durationto = "";
                             if(isset($arr_product['shipping_duration']) && $arr_product['shipping_duration']!="")
                             { 
                               /*$str_delivery_duration = get_shipping_duration_in_days($arr_product['shipping_duration']); */

                               //$str_delivery_durationfrom = get_shipping_duration_in_date($arr_product['shipping_duration'],date('m-d-Y'));
                               $str_delivery_durationfrom = get_shipping_duration_in_date_new($arr_product['shipping_duration'],date('m-d-Y'));

                               // $str_delivery_durationto = date("D. M d",strtotime( $str_delivery_durationfrom.' +2 days'));
                               $str_delivery_durationto = date("F d",strtotime( $str_delivery_durationfrom.' +2 days'));

                             }
                          ?>

                            <p class="delivr-class-p deliverydates">

                               
     
                              Arrives <?php echo e(isset($str_delivery_durationfrom)?$str_delivery_durationfrom:''); ?> - <?php echo e(isset($str_delivery_durationto)?$str_delivery_durationto:''); ?>



                               
                            </p>
                        </div>
                       


                        <!---------end-show-shipping-days------------->

                        
                         <!--Show Shipping charges if available-->
                          <?php if(isset($arr_product['shipping_type']) && $arr_product['shipping_type'] == 1): ?>
                            <div class="shippingtype-div">
                             Shipping Charges: <b>$<?php echo e(isset($arr_product['shipping_charges'])?number_format($arr_product['shipping_charges'],2):'0'); ?></b>
                            </div>
                          <?php elseif(isset($arr_product['shipping_type']) && $arr_product['shipping_type'] == 0): ?>
                              <div class="shippingtype-div">
                                 Free Shipping 
                              </div>
                          <?php endif; ?>

                         




                        <!------------start of seller name --------------------->
                          
                            <?php
                            $firstname = $lastname =  $full_name ='';
                            if( isset($arr_product['user_details']['first_name']) && $arr_product['user_details']['first_name']!="")
                              $firstname = $arr_product['user_details']['first_name'];
                            if(isset($arr_product['user_details']['last_name']) && $arr_product['user_details']['last_name']!="")
                              $lastname = $arr_product['user_details']['last_name'];  

                             $full_name = $firstname.'-'.$lastname;

                           ?>
                            


                        <div class="ext-deatails bortdernone-ext rw-ext-deatails none-space-cncentration">
                         <?php if(isset($arr_product['per_product_quantity']) && $arr_product['per_product_quantity'] != 0): ?>


                              <?php 
                               if(isset($arr_product['spectrum']) && !empty($arr_product['spectrum']))
                               {
                                 $get_spectrum_val = get_spectrum_val($arr_product['spectrum']);
                                 if(isset($get_spectrum_val) && !empty($get_spectrum_val) && $get_spectrum_val['name']=="Hemp Seed")
                                 {
                                 }
                                 else
                                 {
                              ?>
                          
                              <p>Concentration:  <span><?php echo e(isset($arr_product['per_product_quantity'])?$arr_product['per_product_quantity']:'0'); ?>mg</span></p>
                             
                              <?php 
                                  }
                               }//isset spectrum
                               else
                               {
                              ?>
                                <p>Concentration:  <span><?php echo e(isset($arr_product['per_product_quantity'])?$arr_product['per_product_quantity']:'0'); ?>mg</span></p>         
                              <?php
                                } //else
                              ?>   
                           <?php endif; ?>      
                         
                        </div>
                        <div>
                          <?php if(isset($arr_product['spectrum'])): ?>

                             <?php 
                               $get_spectrum_val = get_spectrum_val($arr_product['spectrum']);
                             ?>

                            <div class="ext-deatails noneborders"> 
                              
                             


                              

                              <?php
                                  $arr_cannabinoids = get_product_cannabinoids($arr_product['id']);
                              ?>

                             <?php

                              if(isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate']))
                              {
                                  $ext = pathinfo($arr_product['product_certificate'], PATHINFO_EXTENSION);

                                  if($ext=="pdf")
                                  { 

                                      if(!empty($arr_product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate']))
                                      {
                                        $certificate_val = $arr_product['product_certificate'];
                                  

                                        $url = url('/').'/uploads/product_images/'.$arr_product['product_certificate'];
                                
                                  
                                      }//if exists

                                  }//if pdf

                                  else{

                                      if(!empty($arr_product['product_certificate']) && count($arr_product['product_images_details']) && file_exists(base_path().'/uploads/product_images/thumb/'.$arr_product['product_certificate']))
                                      {

                                        $certificate_val = $arr_product['product_certificate'];
                                  
                                                    
                                        $url = url('/').'/uploads/product_images/thumb/'.$arr_product['product_certificate'];

                                      }//else
                                      else
                                      {
                                        echo 'NA';
                                      }
                                  }//else

                                }//if certificate

                            ?>

                        <?php if(isset($arr_cannabinoids) && count($arr_cannabinoids) > 0): ?>
                          <?php $__currentLoopData = $arr_cannabinoids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $canName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <a href="<?php echo e(isset($url) ? $url : ''); ?>" target="_blank"><span class="oil-category-cannabinoids"><?php echo e($canName['name']); ?> <?php echo e(floatval($canName['percent'])); ?>%</span></a>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                      </div>
                    <?php endif; ?> 

                  </div>

                        




                        <!--------show-product-dimensions-------------------->
                       
                        <!--------show-product-dimensions-------------------->



                        
                                             
                     


               

                        <?php
                          $login_user = Sentinel::check();
                          $fav_arr    = array();
                           if(count($fav_product_arr)>0)
                          {
                           foreach($fav_product_arr as $key=>$value)
                           {
                             $fav_arr[] = $value['product_id'];
                           }

                          }

                         

                          $product_id = 0;
                          $seller_product_ids = [];
                          if(Request::segment(3)!='')
                          {

                            $product_id = base64_decode(Request::segment(3));
                            if(count($seller_products)>0)
                            {
                               foreach($seller_products as $key=>$value)
                               {
                                 $seller_product_ids[] = $value['id']; 
                               }
                            }

                          }

                         $remaining_stock = $product_availability = $brand = ""; 
                         $remaining_stock = isset($arr_product['inventory_details']['remaining_stock'])?$arr_product['inventory_details']['remaining_stock']:''; 
                         if(isset($remaining_stock) && $remaining_stock > 0) $product_availability = 'In Stock';
                         else $product_availability = 'Out Of Stock';

                         $brand = isset($arr_product['user_details']['seller_detail']['business_name'])?$arr_product['user_details']['seller_detail']['business_name']:'';

                        ?>
                         
 
                      <div  <?php if(isset($arr_product['inventory_details']['remaining_stock']) && $arr_product['inventory_details']['remaining_stock']>0): ?> class="ext-deatails" <?php else: ?> class="ext-deatails" <?php endif; ?>> 

                       
                          



                           <!--------------Report Product link added------>
                             <?php if($login_user == true): ?>
                              <?php if($login_user->inRole('buyer')): ?> 
                               
                                 <a href="javascript:void(0)" title="Report Product" class="report-product">Report Product</a>

                              <?php endif; ?>
                             <?php endif; ?> 
                           <!------------------------------------------->



                   <!--------------top reported effects-------------->
                        <?php
                           $get_top_reported_effects = isset($arr_product['id'])? get_top_reported_effects($arr_product['id']):'';
                            if(isset($get_top_reported_effects) && !empty($get_top_reported_effects)){
                        ?>        
                          <div class="top-rated-div"> 
                           <div class="view-strain-effects-div">Reported to help with <span class="colorbk" data-toggle="tooltip" data-html="true" title="Disclaimer: Effects and flavors are reported by users on our site. This is for informational purposes only and not intended as medical advice. Please consult with your physician before changing medical treatments.  These statements have not been evaluated by the Food and Drug Administration. These products are not intended to diagnose, treat, cure or prevent any disease."><i class="fa fa-info-circle" aria-hidden="true"></i></span> 
                               </div>

                              <?php /* ?> 
                              <ul class="list-inline">
                                <?php
                                
                                  foreach($get_top_reported_effects as $k4=>$v4){

                                    $exploded_effects = explode(".",$k4);
                               ?>
                                <li>
                                  <img src='<?php echo url('/'); ?>/assets/images/<?php echo e($k4); ?>' title="<?php echo e(isset($exploded_effects[0])?$exploded_effects[0]:''); ?>"  width="32px"/>
                                <label><?php echo e(isset($exploded_effects[0])?ucfirst(str_replace("_"," ",$exploded_effects[0] )):''); ?></label>
                                </li>
                                 <?php 
                                  }//foreach
                                 ?> 
                              </ul> 
                              <?php */ ?>

                               <ul class="list-inline redirect-to-reviews">
                                <?php
                                   $show_reported_effects=[];
                                  foreach($get_top_reported_effects as $k4=>$v4){

                                    $show_reported_effects = get_effect_name($k4);
                                     if(isset($show_reported_effects) && !empty($show_reported_effects)){
                               ?>
                                <li>
                                  <?php if(file_exists(base_path().'/uploads/reported_effects/'.$show_reported_effects['image']) && isset($show_reported_effects['image']) && !empty($show_reported_effects['image'])): ?>
                                      <img src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e(url('/')); ?>/uploads/reported_effects/<?php echo e($show_reported_effects['image']); ?>" width="32px" class="lozad"> 
                                    <?php endif; ?>
                                    <label><?php echo e(isset($show_reported_effects['title'])?$show_reported_effects['title']:''); ?></label>
                                </li>
                                 <?php 
                                      }//if
                                  }//foreach
                                 ?> 
                              </ul>



                             </div> <!-------sre-product---------------->    
                          <?php 
                            } //if
                          ?>       

                               
                               
                                
                               
                             
                        
                   <!--------------top reported effects-------------->




                   <!--------------Add to cart button-------------->

                       <?php
                       $get_remaining_stock = isset($arr_product['id'])?get_remaining_stock($arr_product['id']):'';
                      ?>

                       <?php if(isset($arr_product['is_outofstock']) && $arr_product['is_outofstock'] == 0): ?>
                              

                      <div <?php if($checkfirstcat_flag==1): ?> class="qty-block detail-locationcls" <?php else: ?> class="qty-block" <?php endif; ?>>


                        <?php if(isset($arr_product['inventory_details']['remaining_stock']) && $arr_product['inventory_details']['remaining_stock']>0): ?>  
                          <!-- <label>Qty:</label>  -->
                          <input type="text" class="form-control" name="item_qty" id="item_qty" onkeypress="return isNumberKey(event)" value="1">
                        <?php endif; ?>  


                          <?php if($login_user == true): ?>
                            <?php if($login_user->inRole('seller') == true || $login_user->inRole('admin') == true): ?>

                              <!--- if seller login is there then hide add to cart button ---->

                              <a href="javascript::void(0)" class="add-cart sp-rightend" onclick="swal('Alert!','If you want to buy a product, then please login as a buyer')">
                                Add to cart
                              </a>
                   
                            <?php elseif($login_user->inRole('buyer') == true): ?>

                             

                              <a  
                                <?php if(isset($arr_product['inventory_details']['remaining_stock']) 
                                &&  $arr_product['inventory_details']['remaining_stock'] > 0 && $checkfirstcat_flag==1): ?>
                                  style="display: none;"
                                <?php elseif(isset($arr_product['inventory_details']['remaining_stock']) && $arr_product['inventory_details']['remaining_stock'] > 0 && $checkfirstcat_flag==0): ?>
                                 style="display: inline-block;"
                                <?php elseif(isset($arr_product['inventory_details']['remaining_stock']) && $arr_product['inventory_details']['remaining_stock'] <= 0 && $checkfirstcat_flag==1): ?>
                                 style="display: none;"
                                <?php elseif(isset($arr_product['inventory_details']['remaining_stock']) && $arr_product['inventory_details']['remaining_stock'] <= 0 && $checkfirstcat_flag==0): ?>
                                 style="display: none;"
                                <?php endif; ?>
                                class="search-link-a-product " href="javascript:void(0)" data-id="<?php echo e(isset($product_id)?base64_encode($product_id):0); ?>" data-qty="1"         

                                    <?php if($checkfirstcat_flag==1): ?>
                                    
                                    <?php else: ?>
                                       onclick="add_to_cart($(this))"
                                    <?php endif; ?> >
                                  <div class="add-cart">
                                     Add to cart
                                  </div>

                              </a>


                                <!---------location--start-------------> 
                                    <?php if($checkfirstcat_flag==1): ?>

                                     
                                    <?php else: ?>      
                                                                  

                                    <?php endif; ?>
                               <!-------location-end------------>
                                                                         
                            <?php endif; ?>
                          <?php else: ?>

                         
                              <!---------location--start---withoutlogin----------> 

                             

                              <?php if(isset($arr_product['is_outofstock']) && $arr_product['is_outofstock'] == 0): ?>

                                <?php if(isset($arr_product['inventory_details']['remaining_stock'])
                                 && $arr_product['inventory_details']['remaining_stock'] > 0): ?>

                                    <?php if($checkfirstcat_flag==1): ?>
                                    
                                    <?php else: ?>
                                      <a href="javascript:void(0)" class="add-cart" data-id="<?php echo e(isset($product_id)?base64_encode($product_id):0); ?>" data-qty="1" onclick="add_to_cart($(this))"> Add to cart</a>
                                    <?php endif; ?> 

                                <?php else: ?>
                                    <?php if($checkfirstcat_flag==1): ?>
                                    <?php else: ?>
                                        
                                    <?php endif; ?>

                                <?php endif; ?>
                              <?php endif; ?>

                             <!-------location-end--without-login--------->


                          <?php endif; ?>

                          
                          <!-- -----in-stock condition-->

                           <?php if(isset($arr_product['is_outofstock']) && $arr_product['is_outofstock'] == 0): ?>

                              <?php if($product_availability=="In Stock" && $checkfirstcat_flag==0): ?> 


                                  <?php if(isset($arr_product['inventory_details']['remaining_stock']) && $arr_product['inventory_details']['remaining_stock']!='' && $arr_product['inventory_details']['remaining_stock']<10): ?>

                                      <p class="space-top-padding view-top-spc">
                                       
                                        <span class='availability-outstock none-bold availability-span'>
                                         Only <?php echo e('('.$arr_product['inventory_details']['remaining_stock'].')'); ?> left in stock - order soon
                                       </span>
                                      </p>

                                  <?php elseif(isset($arr_product['inventory_details']['remaining_stock']) && $arr_product['inventory_details']['remaining_stock']!='' && $arr_product['inventory_details']['remaining_stock']>=10): ?>

                                        <p class="space-top-padding view-top-spc">
                                        Availability: 
                                          <span class='availability-outstock none-bold availability-span'>
                                            <?php echo e($product_availability); ?>

                                         </span>
                                        </p>
                                       
                                  <?php endif; ?>     
                               


                              <?php elseif($product_availability=="In Stock" && $checkfirstcat_flag==1): ?>
                               <p class="space-top-padding view-top-spc">
                                Availability:
                                 <span class='availability-outstock none-bold availability-span'>
                                      Restricted, Based on your state laws, you're not allowed to purchase this product.
                                 </span>
                              </p>
                               <?php elseif($product_availability=="Out Of Stock" && $checkfirstcat_flag==1): ?>
                               <p class="space-top-padding view-top-spc">
                                Availability: <span class='availability-outstock none-bold availability-span'>
                                Restricted, Based on your state laws, you're not allowed to purchase this product.</span>
                              </p> 
                              <?php elseif($product_availability=="Out Of Stock" && $checkfirstcat_flag==0): ?>
                               <p class="space-top-padding view-top-spc">
                                Availability: <span class='availability-outstock none-bold availability-span'> <?php echo e($product_availability); ?></span>
                              </p>
                              <?php endif; ?>

                          <?php else: ?>

                               <?php if($checkfirstcat_flag==1): ?>
                                 <p class="view-top-spc"> 
                                  Availability: <span class='availability-outstock none-bold'>  Restricted, Based on your state laws, you're not allowed to purchase this product.</span>
                                </p>
                               <?php else: ?>

                                <p class="view-top-spc"> 
                                  Availability: <span class='availability-outstock none-bold'> Out Of Stock</span>
                                </p>
                                <?php endif; ?>

                          <?php endif; ?>

                        <!-- --end instock section---------- -->


                        <?php if(isset($arr_product['inventory_details']['remaining_stock']) && $arr_product['inventory_details']['remaining_stock'] > 0): ?>  
                        <?php else: ?>
                        <?php endif; ?>



                           
                      </div>
                      <?php endif; ?>
                      <div id="qtyerr"></div>
                     


              <!--------------end add to cart button------------------------->

                           <div class="view-btns-pro-dls">
                            <div class="sre-product">

                                <?php if($login_user == true): ?>
                                   <?php if($login_user->inRole('buyer')): ?> 
                                      <?php if(isset($fav_arr) && isset($arr_product['id']) && in_array($arr_product['id'],$fav_arr)): ?>
                                         <a href="javascript:void(0)" class="shdebtns heart-o-actv" data-id="<?php echo e(isset($arr_product['id'])?base64_encode($arr_product['id']):0); ?>" data-type="buyer" onclick="removeFromFavorite($(this));" title="Remove from wishlist"><i class="fa fa-heart"></i>Remove from wishlist</a>
                                     <?php else: ?>
                                        <a href="javascript:void(0)" class="shdebtns deactive" data-id="<?php echo e(isset($arr_product['id'])?base64_encode($arr_product['id']):0); ?>" data-type="buyer" onclick="addToFavorite($(this));" title="Add to wishlist">
                                        <i class="fa fa-heart"></i>Add to WishList
                                        </a>
                                      <?php endif; ?>    

                                  <?php endif; ?>
                                  <?php else: ?>
                                  
                                    <a href="javascript:void(0)" class="shdebtns deactive" data-id="bG9jYXRpb24" data-type="product" onclick="addToFavorite($(this));" title="Add to wishlist">
                                         <i class="fa fa-heart"></i>Add to WishList
                                      </a>  

                                  <?php endif; ?>

                           

                             </div><!-------sre-product---------------->
                             <div class="sre-product">
                                
                                <p id="urlLink" style="display: none;"></p>
                                <button class="shdebtns" onclick="shareLink('#urlLink')" title="Share this product"><i class="fa fa-share-alt-square"></i> Share</button>
                                <div class="copeid-sms" id="copy_txt" style="display:none;"> Link Copied!</div>
                             </div>  <!-------sre-product---------------->


                           </div> <!--------view-btns-pro-dls----------------->

                        <?php
                              $coupon_details = isset($arr_product['user_id'])?get_coupon_details($arr_product['user_id']):[];
                        ?>

                       <?php if(isset($coupon_details) && count($coupon_details)>0): ?>
                          <div class="coupons-available">

                           
                           
                              
                              <span class="coupons-font-abl">Coupons Available</span>
             
                                <?php $__currentLoopData = $coupon_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                  <div class="border-radius-coupons">

                                    <div class="usecode-avail"><?php echo e("'".$coupon['code']."'".' '.'for '.$coupon['discount']); ?>% off</div>

                                    <?php if(isset($coupon['type']) && $coupon['type'] == 1): ?> 

                                     <div class="code-date-use"><?php echo e(isset($coupon['start_date'])? date('d M Y',strtotime($coupon['start_date'])):''); ?> to <?php echo e(isset($coupon['end_date'])? date('d M Y',strtotime($coupon['end_date'])):''); ?> </div>
                                    <?php else: ?>
                                     <div class="code-date-use">One Time</div>
                                     
                                    <?php endif; ?>
                                     
                                  </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                           
 
                          </div>
                           <?php endif; ?> 

                      </div> <!------ext-deatails---------------->



                      <!-----------category-best seller chow choice---------->
                         <div class="tag-details-pg">

                            <div class="oil-category sk-oil"> 
                               <?php echo e(isset($arr_product['first_level_category_details']['product_type'])? $arr_product['first_level_category_details']['product_type']: ''); ?>

                             </div>

                              <?php if(isset($arr_product['is_chows_choice']) && $arr_product['is_chows_choice']==1): ?>
                                
                                
                                  <span class="b-class-hide"><img src="<?php echo e(url('/')); ?>/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                                 
                              <?php endif; ?>  

                              <?php if(isset($is_best_seller) && $is_best_seller!="" && $is_best_seller==1): ?>
                                
                                <span class="b-class-hide"><img src="<?php echo e(url('/')); ?>/assets/front/images/best-seller-icon-chow.svg" alt=""> Best Seller </span>

                                
                              <?php endif; ?>

                               <?php if(isset($arr_product['is_trending']) && $arr_product['is_trending']!="" && $arr_product['is_trending']==1): ?>
                                
                                <span class="red-text"><img src="<?php echo e(url('/')); ?>/assets/front/images/trending-icon-chow.svg" alt=""> Trending</span>
                              <?php endif; ?>

                        </div>

                      <!-----------category best seller chow choice------------>





                      
                      <?php
                       /*$get_remaining_stock = get_remaining_stock($arr_product['id']);
                      ?>

                       <?php if(isset($arr_product['is_outofstock']) && $arr_product['is_outofstock'] == 0): ?>
                              

                      <div <?php if($checkfirstcat_flag==1): ?> class="qty-block detail-locationcls" <?php else: ?> class="qty-block" <?php endif; ?>>


                        <?php if($arr_product['inventory_details']['remaining_stock']>0): ?>  
                          <!-- <label>Qty:</label>  -->
                          <input type="text" class="form-control" name="item_qty" id="item_qty" onkeypress="return isNumberKey(event)" value="1">
                        <?php endif; ?>  


                          <?php if($login_user == true): ?>
                            <?php if($login_user->inRole('seller') == true || $login_user->inRole('admin') == true): ?>

                              <!--- if seller login is there then hide add to cart button ---->

                              <a href="javascript::void(0)" class="add-cart" onclick="swal('Alert!','If you want to buy a product, then please login as a buyer')">
                                Add to cart
                              </a>
                   
                            <?php elseif($login_user->inRole('buyer') == true): ?>

                             

                              <a  
                                <?php if($arr_product['inventory_details']['remaining_stock'] > 0 && $checkfirstcat_flag==1): ?>
                                  style="display: none;"
                                <?php elseif($arr_product['inventory_details']['remaining_stock'] > 0 && $checkfirstcat_flag==0): ?>
                                 style="display: inline-block;"
                                <?php elseif($arr_product['inventory_details']['remaining_stock'] <= 0 && $checkfirstcat_flag==1): ?>
                                 style="display: none;"
                                <?php elseif($arr_product['inventory_details']['remaining_stock'] <= 0 && $checkfirstcat_flag==0): ?>
                                 style="display: none;"
                                <?php endif; ?>
                                class="search-link-a-product " href="javascript:void(0)" data-id="<?php echo e(isset($product_id)?base64_encode($product_id):0); ?>" data-qty="1"         

                                    <?php if($checkfirstcat_flag==1): ?>
                                    
                                    <?php else: ?>
                                       onclick="add_to_cart($(this))"
                                    <?php endif; ?> >
                                  <div class="add-cart">
                                     Add to cart
                                  </div>

                              </a>

                                <!---------location--start-------------> 
                                    <?php if($checkfirstcat_flag==1): ?>

                                     
                                    <?php else: ?>      
                                                                  

                                    <?php endif; ?>
                               <!-------location-end------------>
                                                                         
                            <?php endif; ?>
                          <?php else: ?>

                         
                              <!---------location--start---withoutlogin----------> 

                             

                              <?php if(isset($arr_product['is_outofstock']) && $arr_product['is_outofstock'] == 0): ?>

                                <?php if($arr_product['inventory_details']['remaining_stock'] > 0): ?>

                                    <?php if($checkfirstcat_flag==1): ?>
                                    
                                    <?php else: ?>
                                      <a href="javascript:void(0)" class="add-cart" data-id="<?php echo e(isset($product_id)?base64_encode($product_id):0); ?>" data-qty="1" onclick="add_to_cart($(this))"> Add to cart</a>
                                    <?php endif; ?> 

                                <?php else: ?>
                                    <?php if($checkfirstcat_flag==1): ?>
                                    <?php else: ?>
                                        
                                    <?php endif; ?>

                                <?php endif; ?>
                              <?php endif; ?>

                             <!-------location-end--without-login--------->


                          <?php endif; ?>


                        <?php if($arr_product['inventory_details']['remaining_stock'] > 0): ?>  
                        <?php else: ?>
                        <?php endif; ?>
                      </div>
                      <?php endif; ?>
                      <div id="qtyerr"></div> 
                      <?php */ ?>


                     
                  </div> <!----listing-details-------->
                  <div class="clearfix"></div>  
            </div>
                    
  <!-- end of col-md-12------>

  <!-- The Modal -->
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

 </div> <!-----end of div class row----------->


  
 


<body>

  <?php
  $total_reviews  =  $total_ques_ans = 0; 
  $total_reviews  = get_total_reviews($product_id);
  $total_ques_ans = get_total_ques_ans_of_product($product_id);

  // $show_labresulttab = 1;
  // if(isset($arr_product['first_level_category_id']))
  // {
  //    $get_categoryinfo = get_first_levelcategorydata($arr_product['first_level_category_id']);
  //    if(isset($get_categoryinfo) && $get_categoryinfo=="Essential Oils" || $get_categoryinfo=="Accessories"){
  //       $show_labresulttab = 0;
  //      }
  //    else
  //    {
  //        $show_labresulttab = 1;
  //    } 
  // }//if isset firstlevelcategory data

  // if(isset($arr_product['spectrum']))
  // {
  //    $get_spectruminfo = get_spectrum_val($arr_product['spectrum']);
  //      if(isset($get_spectruminfo) && !empty($get_spectruminfo))
  //      {
  //        if($get_spectruminfo['name']=="Hemp Seed"){
  //          $show_labresulttab = 0;
  //        }else{
  //          $show_labresulttab = 1;
  //        }         
  //      }
  //      else
  //      {
  //          $show_labresulttab = 1;
  //      } 
  // }//if isset spectrum data


  ?> 


<!-------------------------------------------------------->
<div class="main-tab-chow-details">
<div class="row">
  <div class="col-md-12">


   <!------------new design start-------------------------------->
    <div class="faqsec">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                   
             <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="heading-1">
                <h4 class="panel-title">
                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="true"aria-controls="collapse-1" class="collapsed">
                    <span>Description</span>
                  </a>
                </h4> 
              </div>
              <div id="collapse-1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-1">
                <div class="panel-body">
                   <!--------------start of product description-------------------------------------->


                   <div class="hidecontent" id="hidecontent_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                    <?php if(isset($arr_product['description']) && strlen($arr_product['description'])>300): ?>
                     <?php echo substr($arr_product['description'],0,300) ?>
                    <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore(<?php echo e(isset($arr_product['id'])?
                    $arr_product['id']:''); ?>)">See more</span>
                    <?php else: ?>
                       <?php 
                         if(isset($arr_product['description']))
                         echo $arr_product['description']; 
                         else
                          echo '';
                       ?>
                    <?php endif; ?>
                  </div>
                  <span class="show-more-content" style="display: none" id="show-more-content_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                      <?php
                        if(isset($arr_product['description']))
                         echo $arr_product['description']; 
                         else
                          echo ''; 
                      ?>
                      <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>)"  id="show-less_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                  </span>


                  <!------------end of product description----------------------->
                </div>
              </div>
            </div>

            <?php if(isset($arr_product['ingredients']) && $arr_product['ingredients'] != ""): ?> 
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="heading-2">
                <h4 class="panel-title">
                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-2" aria-expanded="false"aria-controls="collapse-2" class="collapsed">
                    <span>Ingredients</span>
                  </a>
                </h4> 
              </div>
              <div id="collapse-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-2">
                <div class="panel-body">
                           <div class="hidecontent" id="hidecontent_ingredients_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                                <?php if(isset($arr_product['ingredients']) && strlen($arr_product['ingredients'])>300): ?>
                                 <?php echo substr($arr_product['ingredients'],0,300) ?>
                                <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore_all_(<?php echo e(isset($arr_product['id'])?
                                $arr_product['id']:''); ?>,'ingredients')">See more</span>
                                <?php else: ?>
                                   <?php 
                                     if(isset($arr_product['ingredients']))
                                     echo $arr_product['ingredients']; 
                                     else
                                      echo '';
                                   ?>
                                <?php endif; ?>
                          </div>
                          <span class="show-more-content" style="display: none" id="show-more-content_ingredients_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                                <?php
                                  if(isset($arr_product['ingredients']))
                                   echo $arr_product['ingredients']; 
                                   else
                                    echo ''; 
                                ?>
                                <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless_all_(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>,'ingredients')"  id="show-less_ingredients_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                          </span>


                      
                </div>
              </div>
            </div>
            <?php endif; ?>


              <?php if(isset($arr_product['suggested_use']) && $arr_product['suggested_use'] != ""): ?> 
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading-3">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-3" aria-expanded="false"aria-controls="collapse-3" class="collapsed">
                        <span>Suggested Use</span>
                      </a>
                    </h4> 
                  </div>
                  <div id="collapse-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-3">
                    <div class="panel-body">

                          <div class="hidecontent" id="hidecontent_suggested_use_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                                  <?php if(isset($arr_product['suggested_use']) && strlen($arr_product['suggested_use'])>300): ?>
                                   <?php echo substr($arr_product['suggested_use'],0,300) ?>
                                  <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore_all_(<?php echo e(isset($arr_product['id'])?
                                  $arr_product['id']:''); ?>,'suggested_use')">See more</span>
                                  <?php else: ?>
                                     <?php 
                                       if(isset($arr_product['suggested_use']))
                                       echo $arr_product['suggested_use']; 
                                       else
                                        echo '';
                                     ?>
                                  <?php endif; ?>
                          </div>
                          <span class="show-more-content" style="display: none" id="show-more-content_suggested_use_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                                  <?php
                                    if(isset($arr_product['suggested_use']))
                                     echo $arr_product['suggested_use']; 
                                     else
                                      echo ''; 
                                  ?>
                                  <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless_all_(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>,'suggested_use')"  id="show-less_suggested_use_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                          </span>

                          
                    </div>
                  </div>
                </div>
             <?php endif; ?>




              <?php if(isset($arr_product['amount_per_serving']) && $arr_product['amount_per_serving'] != ""): ?> 
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading-4">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-4" aria-expanded="false"aria-controls="collapse-4" class="collapsed">
                        <span>Amount per serving</span>
                      </a>
                    </h4> 
                  </div>
                  <div id="collapse-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-4">
                    <div class="panel-body">

                           <div class="hidecontent" id="hidecontent_amount_per_serving_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                                  <?php if(isset($arr_product['amount_per_serving']) && strlen($arr_product['amount_per_serving'])>300): ?>
                                   <?php echo substr($arr_product['amount_per_serving'],0,300) ?>
                                  <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore_all_(<?php echo e(isset($arr_product['id'])?
                                  $arr_product['id']:''); ?>,'amount_per_serving')">See more</span>
                                  <?php else: ?>
                                     <?php 
                                       if(isset($arr_product['amount_per_serving']))
                                       echo $arr_product['amount_per_serving']; 
                                       else
                                        echo '';
                                     ?>
                                  <?php endif; ?>
                            </div>
                            <span class="show-more-content" style="display: none" id="show-more-content_amount_per_serving_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                                  <?php
                                    if(isset($arr_product['amount_per_serving']))
                                     echo $arr_product['amount_per_serving']; 
                                     else
                                      echo ''; 
                                  ?>
                                  <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless_all_(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>,'amount_per_serving')"  id="show-less_amount_per_serving_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                            </span>

                         
                    </div>
                  </div>
                </div>
             <?php endif; ?>



              <?php if(isset($arr_product['terpenes']) && $arr_product['terpenes'] != ""): ?> 
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading-5">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-5" aria-expanded="false"aria-controls="collapse-5" class="collapsed">
                        <span>Terpenes</span>
                      </a>
                    </h4> 
                  </div>
                  <div id="collapse-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-5">
                    <div class="panel-body">


                  <!--------------start terpenes-------------------------------------->

                         <div class="hidecontent" id="hidecontent1_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                          <?php if(isset($arr_product['terpenes']) && strlen($arr_product['terpenes'])>300): ?>
                           <?php echo substr($arr_product['terpenes'],0,300) ?>
                          <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore1(<?php echo e(isset($arr_product['id'])?
                          $arr_product['id']:''); ?>)">See more</span>
                          <?php else: ?>

                             <?php 
                               
                              if(isset($arr_product['terpenes']))
                                echo $arr_product['terpenes']; 
                              else
                                echo '';
             
                             ?>

                          <?php endif; ?>
                        </div>
                        <span class="show-more-content" style="display: none" id="show-more-content1_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                            <?php
                               if(isset($arr_product['terpenes']))

                               echo $arr_product['terpenes']; 
                               else
                                echo ''; 

                            ?>
                            <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless1(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>)"  id="show-less1_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                        </span>


                  <!------------end of terpens----------------------->

                          
                    </div>
                  </div>
                </div>
             <?php endif; ?>


              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading-6">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-6" aria-expanded="false"aria-controls="collapse-6" class="collapsed">
                        <span>
                           Q&A <span id="ques_div">
                              <?php if(isset($total_ques_ans) && $total_ques_ans > 0): ?>
                               
                              <?php endif; ?>
                           </span>
                        </span>
                      </a>
                    </h4> 
                  </div>
                  <div id="collapse-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-6">
                    <div class="panel-body showtabcomments">
                          
                    </div>
                  </div>
              </div>

             <?php if(isset($show_labresulttab) && $show_labresulttab==1): ?> 
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading-7">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-7" aria-expanded="false"aria-controls="collapse-7" class="collapsed">
                        <span>Lab Results</span>
                      </a>
                    </h4> 
                  </div>
                  <div id="collapse-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-7">
                    <div class="panel-body">


                             <?php
                             if(isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate']))
                             {
                              $ext = pathinfo($arr_product['product_certificate'], PATHINFO_EXTENSION);
                              if($ext=="pdf"){ 

                                 if(!empty($arr_product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate'])){
                                 $certificate_val = $arr_product['product_certificate'];
                             ?>
                           
                                 
                             <div class="lab-results-txt">
                               <a href="<?php echo e(url('/')); ?>/uploads/product_images/<?php echo e($arr_product['product_certificate']); ?>" target="_blank">View Lab  Results
                              </a> 
                             </div>
                            


                             <?php
                                 }//if exists
                                }//if pdf
                                else{
                               if(!empty($arr_product['product_certificate']) && count($arr_product['product_images_details']) && file_exists(base_path().'/uploads/product_images/thumb/'.$arr_product['product_certificate'])){
                                 $certificate_val = $arr_product['product_certificate'];
                              ?>
                             
                                 <div class="lab-results-txt"> <a  data-responsive="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_certificate']); ?>" href="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_certificate']); ?>" target="_blank">View Lab  Results</a>  </div>
                                  
                              <?php   
                                 }//else
                                 else
                                 {
                                   echo 'NA';
                                 }
                               }//else
                             }//if certificate
                             ?>

                          <!-----------------end of div of coa----------------------->  

                          <?php 
                            $lab_res_header = '';
                            $get_labresult_header = get_lab_result_header();
                            if(isset($get_labresult_header) && !empty($get_labresult_header))
                            {
                              $lab_res_header = $get_labresult_header;
                            }

                          ?>

                          <div class="lab-results-txt">
                                 Information on how to read lab test results
                           </div> 

                      <div class="hidecontent" id="hidecontent2_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">

                        <?php if(isset($lab_res_header) && strlen($lab_res_header)>300): ?>

                          <?php echo substr($lab_res_header,0,300) ?>

                          <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore2(<?php echo e(isset($arr_product['id'])?
                          $arr_product['id']:''); ?>)">See more</span>

                        <?php else: ?>

                             <?php 
                               
                              if(isset($lab_res_header))
                                echo $lab_res_header; 
                              else
                                echo '';
             
                             ?>

                        <?php endif; ?>
                      </div>

                        <span class="show-more-content" style="display: none" id="show-more-content2_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                            <?php
                               
                              if(isset($lab_res_header))
                                echo $lab_res_header; 
                              else
                                echo ''; 

                            ?>
                            <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless2(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>)"  id="show-less2_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                        </span>

                   

                          
                    </div>
                  </div>
                </div>
             <?php endif; ?>


             <?php
              $get_faq =[];
              $get_faq = get_product_category_faq($arr_product['first_level_category_id']);
             ?>
              <?php if(isset($get_faq) && !empty($get_faq)): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading-8">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-8" aria-expanded="false"aria-controls="collapse-8" class="collapsed">
                        <span>FAQ</span>
                      </a>
                    </h4> 
                  </div>
                  <div id="collapse-8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-8">
                    <div class="panel-body">

                            <div class="ul-div-faq">
                              <?php $__currentLoopData = $get_faq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kk=>$vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="li-faq-q"><?php if(isset($vv['question'])): ?> <?php echo $vv['question'] ?> <?php endif; ?></div>
                                <div class="li-faq-answer"><?php if(isset($vv['answer'])): ?> <?php echo $vv['answer'] ?> <?php endif; ?></div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>

                          
                    </div>
                  </div>
                </div>
             <?php endif; ?>



        </div>
    </div>
<!---------new design end----------------------------------->




<?php /* ?>
<div class="tabbing_area">
  <div id="horizontalTab">
      <ul class="resp-tabs-list">
         <li>Description</li>
          <?php if(isset($arr_product['ingredients']) && $arr_product['ingredients'] != ""): ?>
          <li>Ingredients</li>
           <?php endif; ?>
          <?php if(isset($arr_product['suggested_use']) && $arr_product['suggested_use'] != ""): ?>
          <li>Suggested Use</li>
         <?php endif; ?>
         <?php if(isset($arr_product['amount_per_serving']) && $arr_product['amount_per_serving'] != ""): ?>
          <li>Amount per serving</li>
          <?php endif; ?>
         <?php if(isset($arr_product['terpenes']) && $arr_product['terpenes'] != ""): ?>
           <li>Terpenes</li>
         <?php endif; ?>
          <li class="bdg-add" >
              Q&A <span id="ques_div">
                    <?php if(isset($total_ques_ans) && $total_ques_ans > 0): ?>
                    <?php endif; ?>
                 </span>
          </li>
          <?php if(isset($show_labresulttab) && $show_labresulttab==1): ?>
            <li>Lab Results</li>
          <?php endif; ?>   

          <?php
            $get_faq =[];
            $get_faq = get_product_category_faq($arr_product['first_level_category_id']);
          ?>
          <?php if(isset($get_faq) && !empty($get_faq)): ?>
          <li>FAQ</li>
          <?php endif; ?>
      </ul>
      <div class="resp-tabs-container">
            <div class="tb-actv" style="display: block;"><!----product desc div--------------->
                 
                  <!--------------start of product description-------------------------------------->


                   <div class="hidecontent" id="hidecontent_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                    <?php if(isset($arr_product['description']) && strlen($arr_product['description'])>300): ?>
                     <?php echo substr($arr_product['description'],0,300) ?>
                    <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore(<?php echo e(isset($arr_product['id'])?
                    $arr_product['id']:''); ?>)">See more</span>
                    <?php else: ?>
                       <?php 
                         if(isset($arr_product['description']))
                         echo $arr_product['description']; 
                         else
                          echo '';
                       ?>
                    <?php endif; ?>
                  </div>
                  <span class="show-more-content" style="display: none" id="show-more-content_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                      <?php
                        if(isset($arr_product['description']))
                         echo $arr_product['description']; 
                         else
                          echo ''; 
                      ?>
                      <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>)"  id="show-less_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                  </span>

     
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

                  <!------------end of product description----------------------->

            </div> <!----product desc div--------------->

            <?php if(isset($arr_product['ingredients']) && $arr_product['ingredients'] != ""): ?>

            <div> <!---start-ingrediant div--------------->
                
                  
                  <div class="hidecontent" id="hidecontent_ingredients_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                        <?php if(isset($arr_product['ingredients']) && strlen($arr_product['ingredients'])>300): ?>
                         <?php echo substr($arr_product['ingredients'],0,300) ?>
                        <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore_all_(<?php echo e(isset($arr_product['id'])?
                        $arr_product['id']:''); ?>,'ingredients')">See more</span>
                        <?php else: ?>
                           <?php 
                             if(isset($arr_product['ingredients']))
                             echo $arr_product['ingredients']; 
                             else
                              echo '';
                           ?>
                        <?php endif; ?>
                  </div>
                  <span class="show-more-content" style="display: none" id="show-more-content_ingredients_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                        <?php
                          if(isset($arr_product['ingredients']))
                           echo $arr_product['ingredients']; 
                           else
                            echo ''; 
                        ?>
                        <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless_all_(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>,'ingredients')"  id="show-less_ingredients_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                  </span>
            </div> <!---end-ingrediant div--------------->
            <?php endif; ?>

            <?php if(isset($arr_product['suggested_use']) && $arr_product['suggested_use'] != ""): ?>
             <div> <!---start-suggested use div--------------->
                
                  <div class="hidecontent" id="hidecontent_suggested_use_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                        <?php if(isset($arr_product['suggested_use']) && strlen($arr_product['suggested_use'])>300): ?>
                         <?php echo substr($arr_product['suggested_use'],0,300) ?>
                        <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore_all_(<?php echo e(isset($arr_product['id'])?
                        $arr_product['id']:''); ?>,'suggested_use')">See more</span>
                        <?php else: ?>
                           <?php 
                             if(isset($arr_product['suggested_use']))
                             echo $arr_product['suggested_use']; 
                             else
                              echo '';
                           ?>
                        <?php endif; ?>
                  </div>
                  <span class="show-more-content" style="display: none" id="show-more-content_suggested_use_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                        <?php
                          if(isset($arr_product['suggested_use']))
                           echo $arr_product['suggested_use']; 
                           else
                            echo ''; 
                        ?>
                        <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless_all_(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>,'suggested_use')"  id="show-less_suggested_use_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                  </span>
                
             </div><!---end-suggested use div--------------->
             <?php endif; ?>

            <?php if(isset($arr_product['amount_per_serving']) && $arr_product['amount_per_serving'] != ""): ?> 
             <div> <!---start-amount per serving div--------------->
                 
                  <div class="hidecontent" id="hidecontent_amount_per_serving_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                        <?php if(isset($arr_product['amount_per_serving']) && strlen($arr_product['amount_per_serving'])>300): ?>
                         <?php echo substr($arr_product['amount_per_serving'],0,300) ?>
                        <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore_all_(<?php echo e(isset($arr_product['id'])?
                        $arr_product['id']:''); ?>,'amount_per_serving')">See more</span>
                        <?php else: ?>
                           <?php 
                             if(isset($arr_product['amount_per_serving']))
                             echo $arr_product['amount_per_serving']; 
                             else
                              echo '';
                           ?>
                        <?php endif; ?>
                  </div>
                  <span class="show-more-content" style="display: none" id="show-more-content_amount_per_serving_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                        <?php
                          if(isset($arr_product['amount_per_serving']))
                           echo $arr_product['amount_per_serving']; 
                           else
                            echo ''; 
                        ?>
                        <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless_all_(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>,'amount_per_serving')"  id="show-less_amount_per_serving_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                  </span>
                
             </div><!---end-amount per serving div--------------->
            <?php endif; ?>



              <?php if(isset($arr_product['terpenes']) && $arr_product['terpenes'] != ""): ?> 
              <div><!----terpenes div--------------->
              
                  <!--------------start terpenes-------------------------------------->

                   <div class="hidecontent" id="hidecontent1_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                    <?php if(isset($arr_product['terpenes']) && strlen($arr_product['terpenes'])>300): ?>
                     <?php echo substr($arr_product['terpenes'],0,300) ?>
                    <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore1(<?php echo e(isset($arr_product['id'])?
                    $arr_product['id']:''); ?>)">See more</span>
                    <?php else: ?>

                       <?php 
                         
                        if(isset($arr_product['terpenes']))
                          echo $arr_product['terpenes']; 
                        else
                          echo '';
       
                       ?>

                    <?php endif; ?>
                  </div>
                  <span class="show-more-content" style="display: none" id="show-more-content1_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">
                      <?php
                         if(isset($arr_product['terpenes']))

                         echo $arr_product['terpenes']; 
                         else
                          echo ''; 

                      ?>
                      <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless1(<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>)"  id="show-less1_<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>">See less</span>
                  </span>

     
                  <script>

                    function showmore1(id)
                    { 
                       $('#show-more-content1_'+id).show();
                       $('#show-less1_'+id).show();
                       $("#hidecontent1_"+id).hide();
                    }

                    function showless1(id)
                    { 
                       $('#show-more-content1_'+id).hide();
                       $('#show-less1_'+id).hide();
                       $("#hidecontent1_"+id).show();
                    }
                  </script>

                  <!------------end of terpens----------------------->

              </div> <!----product terpens--------------->
              <?php endif; ?>

            

             <div class="showtabcomments"><!---start-Q&A div--------------->
               
             </div><!---end-Q&A div--------------->
             <div> <!----start lab results-------------------------->
                   
                
                         
                       <?php
                       if(isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate']))
                       {
                        $ext = pathinfo($arr_product['product_certificate'], PATHINFO_EXTENSION);
                        if($ext=="pdf"){ 

                           if(!empty($arr_product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate'])){
                           $certificate_val = $arr_product['product_certificate'];
                       ?>
                     
                           
                       <div class="lab-results-txt">
                         <a href="<?php echo e(url('/')); ?>/uploads/product_images/<?php echo e($arr_product['product_certificate']); ?>" target="_blank">Lab Results
                        </a> 
                       </div>
                            


                       <?php
                           }//if exists
                          }//if pdf
                          else{
                         if(!empty($arr_product['product_certificate']) && count($arr_product['product_images_details']) && file_exists(base_path().'/uploads/product_images/thumb/'.$arr_product['product_certificate'])){
                           $certificate_val = $arr_product['product_certificate'];
                        ?>
                       
                           <div class="lab-results-txt"> <a  data-responsive="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_certificate']); ?>" href="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_certificate']); ?>" target="_blank">Lab Results</a>  </div>
                            
                        <?php   
                           }//else
                           else
                           {
                             echo 'NA';
                           }
                         }//else
                       }//if certificate
                       ?>

                   <!-----------------end of div of coa----------------------->  

                    <?php 
                      $lab_res_header = '';
                      $get_labresult_header = get_lab_result_header();
                      if(isset($get_labresult_header) && !empty($get_labresult_header))
                      {
                        $lab_res_header = $get_labresult_header;
                      }

                    ?>

                    <div class="lab-results-txt">
                           Information on how to read lab test results
                     </div> 

                    <?php if(isset($lab_res_header)): ?>
                     <?php echo $lab_res_header ?>
                    <?php endif; ?>

                  
             </div> <!----end lab results------------------------->
             
                <?php
                  $get_faq =[];
                  $get_faq = get_product_category_faq($arr_product['first_level_category_id']);
                ?>
                <?php if(isset($get_faq) && !empty($get_faq)): ?>
                
                <div> <!------start faq div------------------->
  
                   <div class="ul-div-faq">
                      <?php $__currentLoopData = $get_faq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kk=>$vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="li-faq-q"><?php if(isset($vv['question'])): ?> <?php echo $vv['question'] ?> <?php endif; ?></div>
                        <div class="li-faq-answer"><?php if(isset($vv['answer'])): ?> <?php echo $vv['answer'] ?> <?php endif; ?></div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>

                     
              </div> <!------end faq div-------------------->
               <?php endif; ?>
          


            



      </div>
   </div>

</div><!--tabbing area div------->

<?php */ ?>


</div><!--col-md-12 div------->


<!--   <div class="col-md-6">
    <div class="img-right-side-view">

      <?php if(isset($arr_product['additional_product_image']) && $arr_product['additional_product_image']!=''): ?>
        <img src="<?php echo e(url('/')); ?>/uploads/additional_product_image/<?php echo e($arr_product['additional_product_image']); ?>" alt="">
      <?php endif; ?>
    </div>
  </div> -->
</div>
</div>

<!-------------End new structure of tab area------------------>






 

             
    
     






















<?php /* ?>
  <div id="tabs-3">

  <?php 
                    $total_reviews = get_total_reviews($product_id);
                    $avg_rating  = get_avg_rating($product_id);
                    if(isset($avg_rating) && $avg_rating > 0)
                    {
                      $img_avg_rating = "";

                      $img_avg_rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';
                    }
                    ?> 

                   <!---------------start--------------------------------->
                    <div class="comment-view-only" id="showreviewdiv">
                    </div>
                    <!-------------------end----------------------------->

                    <div id="reviewform">
                    <?php if($login_user==true && $login_user->inRole('buyer') && $is_review_added==0 && $product_purchased_by_user==1): ?>

                   
                   

                     <form id="frm-add-review" method="post">
                      <?php echo e(csrf_field()); ?>

                      <div class="whitebox-list paddingtop-o">
                          <div class="titledetailslist">Rate This Product</div>

                          <input type="hidden" name="product_id" id="product_id" value="<?php echo e(isset($product_id)?$product_id:''); ?>">

                          <div class="ratings-frms view-rating-comments viewcommits">                            
                            <div class="starrr text-left">
                                 <input class="star required" type="radio" name="rating" id="rating_star" value="1"/>
                              </div>
                              <div id="err_rating"></div>
                          </div>
                             <!-- <input type="hidden" id="rating" name="rating"> -->
                            <div class="titledetailslist">Comments</div>
                              <div class="form-group">
                                  <label for="">Title</label>
                                  <input type="text" name="title" id="title" class="input-text  reviewtitle" placeholder="Title" >
                                  <span id="titleerr"></span>
                              </div>
                              <div class="form-group">
                                  <label for="">Write Comment</label>
                                  <textarea class="input-text reviewdesc" placeholder="Write Comment" name="review" id="review"></textarea>
                                  <span id="reviewerr"></span>
                              </div>

                              <div class="checkbox-dropdown">
                                      Helped with 
                                      <ul class="checkbox-dropdown-list">
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
                                  
                                    <span id="helpedwitherr"></span>


                              

                              <div class="button-list-dts">
                                
                                  <button type="button" class="butn-def btnsendreviw" id="btn_send_review">Send Review</button>      
                                  
                              </div>
                      </div> 
                     </form> 
                    <?php endif; ?>

                    <?php if($login_user==true && $login_user->inRole('buyer') && $product_purchased_by_user==1): ?>
                     
                      <?php if(isset($request_status) && $request_status == 0): ?>
                       
                        <div class="button-list-dts"> 
                           <button type="button" class="butn-def btnsendreviw send-money-back"  id="btn_money_back_request" style="cursor: not-allowed;">Reported</button>

                        </div>

                      <?php elseif(isset($request_status) && $request_status == 2): ?>

                          <div class="button-list-dts"> 
                             <div class="mney-rejected">Corrected</div>
                           <button type="button" product_id="<?php echo e(isset($product_id)?$product_id:0); ?>" class="butn-def btnsendreviw send-money-back"  id="btn_money_back_request" onclick="showModel($(this));">Report Issue</button>

                          </div>

                         


                      <?php elseif(isset($request_status) && $request_status == 1): ?>

                          <div class="button-list-dts"> 
                            <button type="button" class="butn-def btnsendreviw send-money-back"  id="btn_money_back_request" style="cursor: not-allowed;">Refunded to wallet</button>

                          </div>

                      <?php else: ?>
                          
                          <div class="button-list-dts"> 
                           <button type="button" product_id="<?php echo e(isset($product_id)?$product_id:0); ?>" class="butn-def btnsendreviw send-money-back"  id="btn_money_back_request" onclick="showModel($(this));">Report Issue</button>

                          </div>

                      <?php endif; ?>
                    

                    <?php endif; ?>


                    
                  </div> <!--------end of div of review form---------------------->
   </div>
<?php */ ?>

 

 <!-------start tab 5---------------->

  
 <!-------end tab 5---------------->

 
   <!------end of div tabs-------------->

<!--------end of div class 12------------------->





<!---------------Rating progress bar div--------------------------------->


<?php 
  $percentage_avg_rating=0;
  $total_review_count = get_total_reviews($product_id);
  $getavg_rating  = get_avg_rating($product_id);   
  if(isset($getavg_rating) && $getavg_rating > 0)
  {
    $img_avg_rating = ""; 
    $img_avg_rating = isset($getavg_rating)?get_avg_rating_image($getavg_rating):'';
    $percentage_avg_rating = ($getavg_rating*100)/5;
  }
?>
<?php if(isset($getavg_rating) && $getavg_rating>0): ?>


<div class="main-reviewstar" id="main-reviewstar">
  <div class="container">

    <div class="card-products review-padd">
        <div class="row justify-content-left d-flex">
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="rating-bar0 justify-content-center">
                  <div class="title-customer-reviews">Reviews</div>
                  <div class="filter-reviews-show">
                    <div class="star-review-fa"> 
                      <?php if(isset($getavg_rating) && $getavg_rating>0): ?>
                       <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_avg_rating)?$img_avg_rating.'.svg':''); ?>" alt="<?php echo e(isset($img_avg_rating)?$img_avg_rating:''); ?>"> 
                      <?php endif; ?> 
                      <span class="class-lft-ratings"><?php echo e(isset($total_review_count)?$total_review_count.' Ratings':''); ?></span>
                   </div>
                   <div class="num-star-review">
                      <?php if(isset($getavg_rating) && $getavg_rating>0): ?> 
                        <?php echo e($getavg_rating); ?>  out of 5 Stars
                      <?php endif; ?>
                  </div>
                  </div>

                  
                  <div class="filter-review-txt">Reported effects from customers</div>
                     <table class="text-left mx-auto">

                         <?php
                           $show_reported_effects=[]; $get_effect_count= $percentage_effects = 0;
                          foreach($get_top_reported_effects as $k4=>$v4){

                            $show_reported_effects = get_effect_name($k4);
                             if(isset($show_reported_effects) && !empty($show_reported_effects))
                             {
                               $get_effect_count = get_reportedeffect_count($show_reported_effects['id'],$product_id);
                               if(isset($get_effect_count) && $get_effect_count>0 && isset($total_review_count) && $total_review_count>0)
                               {
                                  $percentage_effects = number_format($get_effect_count/$total_review_count *100,2);
                               }
                          ?>
                          <tr>
                              <td class="rating-label"><?php echo e(isset($show_reported_effects['title'])?ucwords($show_reported_effects['title']):''); ?></td>
                              <td class="rating-bar">
                                  <div class="bar-container">
                                      <div class="bar-5" style="width: 100%; max-width: <?php echo e($percentage_effects); ?>%;"></div>
                                  </div> 
                              </td>
                              <td class="text-right"><?php echo e($percentage_effects); ?>%</td>
                          </tr>
                          <?php 
                            }//if
                        }//foreach
                       ?> 
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<?php endif; ?>
<!------------------------------------------------------------->

<!---------start---Show reviews here---------------------------->

<?php 

//dd($arr_product['review_details']);
 
?>

 <div class="container">
<div class="comment-view-details-page" id="showreviewdiv">
    <?php if(isset($arr_product['review_details']) && sizeof($arr_product['review_details']) ): ?>
    <?php $__currentLoopData = $arr_product['review_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
       
            $review_at = "";
            $review_at = date('h:i - M d, Y', strtotime($review['updated_at']));
            if(isset($review['user_details']['profile_image']) && $review['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$review['user_details']['profile_image'])) {

                $user_profile_img = url('/uploads/profile_image/'.$review['user_details']['profile_image']);
            }
            else {                  
                $user_profile_img = url('/assets/images/no_image_available.jpg');
            }  
            if(isset($review['rating']) && $review['rating'] > 0) {

                $img_rating = "";
                $img_rating = isset($review['rating'])?get_avg_rating_image($review['rating']):'';
            } 
        ?>
        <div class="comment-view-only-white prfileimgnone">
            <?php 
                $setname = '';
                if(isset($review['user_details']) && ($review['user_details']['first_name']=="" || $review['user_details']['last_name']==""))  {

                    if($review['user_details']['user_type']=="seller") {

                        $setname = "Seller";
                    }
                    else {

                        $setname = "Buyer";
                    }
                }
                else if(isset($review['user_details']) && ($review['user_details']['first_name']!="" || $review['user_details']['last_name']!=""))  {

                   // $setname = $review['user_details']['first_name']." ".$review['user_details']['last_name'];
                    $setname = $review['user_details']['first_name'];
                }
                else  if(isset($review['user_name']) && $review['user_name']!="")  {
                    $setname = isset($review['user_name'])?$review['user_name']:'';
                }
                else {
                    $setname ='User';
                }
            ?>

            
            <div class="review-main-avatar">
                <div class="review-main-avatar-left">
                    <div class="rvw-circle-cw"><img src="<?php echo e(url('/')); ?>/assets/front/images/check-buyer-icon.svg" /></div>
                    
                    <?php
                       $initate_latter =  strtoupper($setname[0]);
                    ?>
                    <?php echo e($initate_latter); ?>

                </div>
                <div class="review-main-avatar-right">
                    <div class="namereviews">
                        <span>
                            <?php echo e(isset($setname)?ucwords(strtolower($setname)):''); ?>


                            <?php if($login_user == true && $review['buyer_id']==$login_user->id): ?>
                                <?php 
                                $star = isset($review['rating'])?get_avg_rating_image($review['rating']):'';

                                ?>
                                <a title="Edit Review" class="fa fa-edit editreviews " id="editreviews_<?php echo e($review['id']); ?>" reviewuser="<?php echo e($review['buyer_id']); ?>" reviewproduct="<?php echo e($review['product_id']); ?>"  reviewid="<?php echo e($review['id']); ?>" reviewtitle="<?php echo e($review['title']); ?>" reviewdesc="<?php echo e($review['review']); ?>" reviewrating="<?php echo e($review['rating']); ?>" star="<?php echo e($star); ?>" emoji="<?php echo e(isset($review['emoji'])?$review['emoji']:''); ?>">
                                </a>
                            <?php endif; ?> 
                        </span>
                       
                    </div>
                      <div class="namereviews"> <span>Verified Buyer</span></div>
                    <div class="lisitng-detls-rate" title="<?php echo e($review['rating']); ?> Rating">
                        <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_rating)?$img_rating.'.svg':''); ?>" alt="">                  
                    </div>
                    <div class="titleofsub">
                        <?php
                        $reviwe_title = isset($review['title']) ? $review['title'] : '-';
                        ?>
                        <?php echo e($reviwe_title); ?>

                    </div>
                    <div class="commentofsub" id="hidecontent_<?php echo e($review['id']); ?>">
                        <?php if(isset($review['review']) && strlen($review['review'])>100): ?>
                            <?php echo substr($review['review'],0,100) ?>
                            <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore(<?php echo e(isset($review['id'])?$review['id']:''); ?>)">See more</span>
                        <?php else: ?>
                        <?php 
                            if(isset($review['review']))
                            echo $review['review']; 
                            else
                            echo '';
                        ?>
                        <?php endif; ?>
                    </div>
                    <span class="show-more-content" style="display: none" id="show-more-content_<?php echo e(isset($review['id'])?$review['id']:''); ?>">
                    <?php
                        if(isset($review['review']))
                        echo $review['review']; 
                        else
                        echo ''; 
                    ?>
                    <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless(<?php echo e(isset($review['id'])?$review['id']:''); ?>)"  id="show-less_<?php echo e(isset($review['id'])?$review['id']:''); ?>">See less</span>
                </span>

           
                <div class="showemoji">
                    <?php if(isset($review['emoji']) && !empty($review['emoji'])): ?>
                    <div class="top-rated-div">
                        This helped with my:
                         <ul class="list-inline">
                               <?php 
                                $get_reported_effects1=[];
                                $emoji1 = explode(",",$review['emoji']);
                                $exploded = [];
                                foreach($emoji1 as $kk=>$vv1)
                                {
                                  $get_reported_effects1 = get_effect_name($vv1);
                                  if(isset($get_reported_effects1) && !empty($get_reported_effects1)){
                               ?>
                                <li>
                                     <?php if(file_exists(base_path().'/uploads/reported_effects/'.$get_reported_effects1['image']) && isset($get_reported_effects1['image']) && !empty($get_reported_effects1['image'])): ?>
                                      <img data-src="<?php echo e(url('/')); ?>/uploads/reported_effects/<?php echo e($get_reported_effects1['image']); ?>" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" width="32px" class="lozad"> 
                                    <?php endif; ?>
                                    <label><?php echo e(isset($get_reported_effects1['title'])?$get_reported_effects1['title']:''); ?></label>
                                </li>
                                <?php 
                                   }//if
                                 }//foreach
                                ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                </div>
                <div class="clearfix"></div>
            </div>
            

            
            <div class="comment-view-only-white-right">
                <div class="title-user-name username-review"> 
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"></div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="whitebox-list space-o-padding">
        <div class="titledetailslist pull-left">No Reviews (0)</div>
    </div>
    <?php endif; ?>
    <div class="clearfix"></div>
    <div class="mainrbutton review-btn-padd">
    <?php if(isset($arr_product['review_details']) && sizeof($arr_product['review_details']) ): ?>
     <div class="inineview">
        <a href="<?php echo e(url('/')); ?>/search/show_all_review_list/<?php echo e(base64_encode($productid)); ?>" class="btn-view-product">View All Reviews</a>
      </div>
    <?php endif; ?> 

      <?php if($login_user==true && $login_user->inRole('buyer') && $is_review_added==0 && $product_purchased_by_user==1): ?>     
           <div class="white-review-div-full inineview">
                <a href="<?php echo e(url('/')); ?>/search/add_review/<?php echo e(base64_encode($product_id)); ?>" class="write-a-review-btn">Write a Review</a>
           </div>
      <?php endif; ?>

      <?php if($login_user==true && $login_user->inRole('buyer') && $product_purchased_by_user==1): ?>     
        <?php if(isset($request_status) && $request_status == 0): ?>
          <div class="button-list-dts inineview"> 
             <button type="button" class="butn-def btnsendreviw send-money-back btn-view-product"  id="btn_money_back_request" style="cursor: not-allowed;">Reported</button>

          </div>
        <?php elseif(isset($request_status) && $request_status == 2): ?>

            <div class="button-list-dts inineview"> 
               <div class="mney-rejected">Corrected</div>
             <button type="button" product_id="<?php echo e(isset($product_id)?$product_id:0); ?>" class="butn-def btnsendreviw send-money-back btn-view-product"  id="btn_money_back_request" onclick="showModel($(this));">Report Issue</button>

            </div>
        
        <?php elseif(isset($request_status) && $request_status == 1): ?>

            <div class="button-list-dts inineview"> 
              <button type="button" class="butn-def btnsendreviw send-money-back btn-view-product"  id="btn_money_back_request" style="cursor: not-allowed;">Refunded to wallet</button>

            </div>
        <?php else: ?>
            
            <div class="button-list-dts inineview"> 
             <button type="button" product_id="<?php echo e(isset($product_id)?$product_id:0); ?>" class="butn-def btnsendreviw send-money-back btn-view-product"  id="btn_money_back_request" onclick="showModel($(this));">Report Issue</button>

            </div>

        <?php endif; ?>             
      <?php endif; ?>
</div>

 <div class="clearfix"></div>

</div>
</div>
<!----------end show reviews here-------------------------------->









 <?php
    if($isMobileDevice==1){

        $device_count = 2;
    }
    else {
        $device_count = 5;
    }
?>


<!---------------------start of similar product------------------------------>
 <!-- loader -->
  <div class="" id="similar-product-view-loader" style="display: none;">
        <ul class="f-cat-below7">  
          <?php for($i=0;$i<4;$i++): ?>
            <li>
               <div class="top-rated-brands-list">
                 <div class="ph-item">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                        <div class="ph-row">
                            <div class="ph-col-4"></div>
                            <div class="ph-col-8 empty"></div>
                            <div class="ph-col-12"></div>
                        </div>
                    </div>
                </div>
              </div>
            </li>            
          <?php endfor; ?>         
        </ul>
 </div>
 <div id="show_similar_products" style="display: none;"></div>
<!-------------------end of similar product--------------------------------->



<!---------------------start of recently viewed product------------------------------>
  <?php 

    $login_user = '';
    $login_user = Sentinel::check();  
  ?>

   <!-- loader -->
      <div class="" id="recently-view-loader" style="display: none;">
        <ul class="f-cat-below7">  
          <?php for($i=0;$i<4;$i++): ?>
            <li>
               <div class="top-rated-brands-list">
                 <div class="ph-item">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                        <div class="ph-row">
                            <div class="ph-col-4"></div>
                            <div class="ph-col-8 empty"></div>
                            <div class="ph-col-12"></div>
                        </div>
                    </div>
                </div>
              </div>
            </li>            
          <?php endfor; ?>         
        </ul>
   </div>

   <div id="recently_viewed_id" style="display: none;"> </div> 

           
<!-------end of recently viewed product-------------------------->  


<!-------------------start buy again--------------------------------->

<!-- loader -->
<div class="" id="buy-again-view-loader" style="display: none;">
        <ul class="f-cat-below7">  
          <?php for($i=0;$i<4;$i++): ?>
            <li>
               <div class="top-rated-brands-list">
                 <div class="ph-item">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                        <div class="ph-row">
                            <div class="ph-col-4"></div>
                            <div class="ph-col-8 empty"></div>
                            <div class="ph-col-12"></div>
                        </div>
                    </div>
                </div>
              </div>
            </li>            
          <?php endfor; ?>         
        </ul>
</div> 
<div id="buy_again_id" style="display: none;"> </div> 

           
<!-------------------end buy again--------------------------------->

<!-------------------start product you may like-------------------------------------->
<!-- loader -->
<div class="" id="you-may-like-view-loader" style="display: none;">
        <ul class="f-cat-below7">  
          <?php for($i=0;$i<4;$i++): ?>
            <li>
               <div class="top-rated-brands-list">
                 <div class="ph-item">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                        <div class="ph-row">
                            <div class="ph-col-4"></div>
                            <div class="ph-col-8 empty"></div>
                            <div class="ph-col-12"></div>
                        </div>
                    </div>
                </div>
              </div>
            </li>            
          <?php endfor; ?>         
        </ul>
</div> 
<div id="you_may_likes_id" style="display: none;"> </div>
<!----------------end---product you may like---------------------------------->


</div>

</div>
</div>


<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>


<div  class="modal fade" id="productVideoModal" tabindex="-1" role="dialog" aria-labelledby="productVideoModalTitle1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header borderbottom">
        <div class="video-modal-title" id="productVideoModalTitle"></div>
        
        <button type="button" id="close_product_video" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="yt-player" style="height: 400px;">

        <iframe class="youtube-video" id="youtube-video" width="100%" height="100%" frameborder="0" allowfullscreen
            src="">
        </iframe>

      </div>

      

    </div>
  </div>
</div>
</div>






<!-----------Start---Show catgory image section--------------------------------->

 

<?php 
$get_category_product_details = get_category_product_details($arr_product['first_level_category_id']);
?>

<?php if(isset($get_category_product_details) && !empty($get_category_product_details)): ?>

<div class="newsection-details-pg">
  <div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <?php if(isset($get_category_product_details['image']) && !empty($get_category_product_details['image']) && file_exists(base_path().'/uploads/first_level_category_productdetail/'.$get_category_product_details['image'])): ?>
         <div class="view-image-newsection">
              <img src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e(url('/')); ?>/uploads/first_level_category_productdetail/<?php echo e($get_category_product_details['image']); ?>" alt="Product detail view image" class="lozad">
         </div>
         <?php endif; ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="view-text-newsection-main">
           
            <div class="content-new-sect">
             <?php if(isset($get_category_product_details['description'])): ?>     
             <?php echo $get_category_product_details['description']; ?>
             <?php endif; ?>
            </div>
          </div>
    </div>
  </div>
</div>
</div>

<?php endif; ?>
 

<!--------End----Show catgory image section------------------------------------->


<!-- Modal -->
<div id="myModalCOA" class="modal fade" role="dialog">
  <div class="modal-dialog coa-mdl">
  <button type="button" class="close" data-dismiss="modal">
    <img src="<?php echo e(url('/')); ?>/assets/front/images/closbtns.png" alt="Image"/>
  </button>
  <div class="cbdimg">
    
  </div> 
  </div>
</div>



<div id="ReviewRatingsAddModal" class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo e(url('/')); ?>/assets/buyer/images/closbtns.png" alt="Chow420" /> </button>
            <div class="ordr-calltnal-title">Edit Review & Ratings</div>
            
            <form id="frm-add-review-modal" method="post" onsubmit="return false;">
              <?php echo e(csrf_field()); ?>


             <div class="ratings-frms">
              <input type="hidden" name="product_id_modal" id="product_id_modal" value="">
              <input type="hidden" name="review_id" id="review_id" value="">   
               <input type="hidden" name="rating_modal" id="rating_modal" value="">   




              

            </div>
             <div class="form-group">
               <label for="">Previous Ratings :  <span><img id="show_prev_rating" src="" alt="Previous Ratings" class="reviewsize" /></span></label>
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
                            <input class="form-check-input" type="checkbox" value="<?php echo e($v['id']); ?>" id="rememberMe11<?php echo e($v['id']); ?>"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe11<?php echo e($v['id']); ?>">
                              <?php echo e(isset($v['title']) ? $v['title'] : ''); ?>

                               <?php if(file_exists(base_path().'/uploads/reported_effects/'.$v['image']) && isset($v['image']) && !empty($v['image'])): ?>
                               <img src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src='<?php echo e(url('/')); ?>/uploads/reported_effects/<?php echo e($v['image']); ?>' class="lozad" width="32px" title="<?php echo e($v['title']); ?>" />
                               <?php endif; ?> 
                            </label>
                        </div>
                      </div>
                     </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   <?php endif; ?>  
                  
                  
                </ul>
              </div>


            <div class="button-list-dts btn-order-cnls submits-button">
                <button class="butn-def btn_send_review_modal" id="btn_send_review_modal">Save</button>
            </div>
          </form>  
            <div class="clr"></div>
        </div>
    </div>
</div>
<!-- Modal My-Review-Ratings-Add End -->


<!----------------------------model for reported issue note--------------------------------->

<div class="modal fade" id="reported_note_model" tabindex="-1" role="dialog" aria-labelledby="StateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <form id="reported_note_form">
    <?php echo e(csrf_field()); ?>


    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="StateModalLabel" align="center">Report Issue Note</h5>
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
        <button type="button" class="btn btn-info popup-add" id="btn_text_add" onclick="sendMoneyBackRequest($(this));">Add</button>
      </div>
  </div>
  </form>
</div>
</div>


<!-- ---------------------------------------------------------------------------------------->



<?php 
 
$price = $urlbrands_name = $urlseller_name = $product_title_slug = $product_title = $dispensary_name =  $url = '';
if(isset($arr_product['price_drop_to']) && $arr_product['price_drop_to']>0)
{
   $price = num_format($arr_product['price_drop_to']);
}else{
   $price = isset($arr_product['unit_price'])?num_format($arr_product['unit_price']):'';
}

 $urlbrands_name = isset($arr_product['get_brand_detail']['name'])?str_slug($arr_product['get_brand_detail']['name']):'';

 $urlseller_name = isset($arr_product['user_details']['seller_detail']['business_name'])?str_slug($arr_product['user_details']['seller_detail']['business_name']):'';


  $product_title = isset($arr_product['product_name']) ? $arr_product['product_name'] : '';
  $product_title_slug = str_slug($product_title);

if(isset($arr_product['product_images_details'][0]['image']) && !empty($arr_product['product_images_details'][0]['image'])){
    $url = url('/').'/uploads/product_images/'.$arr_product['product_images_details'][0]['image'];
  }else{
    $url ='';
  }

  $dispensary_name = isset($arr_product['user_details']['seller_detail']['business_name'])?$arr_product['user_details']['seller_detail']['business_name']:'';

?>




<?php 
  $product_view=[];
 if(isset($arr_product) && !empty($arr_product))
 {
   
     $product_view['name'] = isset($arr_product['product_name'])?$arr_product['product_name']:'';
     $product_view['id'] = isset($arr_product['id'])?$arr_product['id']:'';
     $product_view['brand'] = isset($arr_product['brand'])?get_brand_name($arr_product['brand']):''; 
     $product_view['category'] = isset($arr_product['first_level_category_id'])?get_first_levelcategorydata($arr_product['first_level_category_id']):''; 
     $product_view['position'] = 1;
     $product_view['list'] =  'Search Results';
      if(isset($arr_product['price_drop_to']))
      {
         if($arr_product['price_drop_to']>0)
         {
           $product_view['price'] = isset($arr_product['price_drop_to']) ? num_format($arr_product['price_drop_to']) : '';
         }else
         {
          $product_view['price'] = isset($arr_product['unit_price']) ? num_format($arr_product['unit_price']) : '';
         }       
      }
      else
      {
        $product_view['price'] = isset($arr_product['unit_price']) ? num_format($arr_product['unit_price']) : '';
      }

  

 }//if isset arrproduct
  
?>

<?php $__env->stopSection(); ?>



<?php
  $product_title = isset($arr_product['product_name']) ? $arr_product['product_name'] : '';
  $product_title_slug = str_slug($product_title);
?>  


<!-- page script start -->

<?php $__env->startSection("page_script"); ?>
    

  
  

  
  

 <!--rating demo-->
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/buyer/js/jquery.rating.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/buyer/js/star-rating.js" type="text/javascript"></script>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="<?php echo e(url('/')); ?>/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>

 <script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/newjquery.flexisel.js"></script>

<script type="text/javascript"  src="<?php echo e(url('/')); ?>/assets/front/js/lightgallery-all.min.js"></script>




<script type="text/javascript">

   /*global variable declaration*/ 

  var productid = "<?php echo e($productid); ?>";
  var first_level_category_id = "<?php echo e($first_level_category_id); ?>";
  var loggedinuser ="<?php echo e($loggedinuser); ?>";
  var _learnq = _learnq || [];
  var _learnq = _learnq || [];
  var dataLayer = dataLayer || [];
  var modal = document.getElementById("myProductModal");

  var span = document.getElementsByClassName("close")[0];


  $( function() {
    $( "#tabs" ).tabs({
      event: "click"
    });
  } );

/*---------------start script for product report-------------------*/

var product_link = "<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($arr_product['id'])?base64_encode($arr_product['id']):''); ?>/<?php echo e($product_title_slug); ?>";
var admin_email = "<?php echo e(isset($admin_arr['email']) ? $admin_arr['email']:''); ?>";
var admin_id = "<?php echo e(isset($admin_arr['id']) ? $admin_arr['id']:''); ?>";

var login_id = "<?php echo e(isset($login_id) ? $login_id : ''); ?>";
var login_email = "<?php echo e(isset($login_email) ? $login_email : ''); ?>";
var product_id = "<?php echo e(isset($arr_product['id']) ? $arr_product['id'] : ''); ?>";


  $(document).on('click','.report-product',function(){
    $("#reportproduct_modal").modal('show');
    $("#link").html(product_link);
    $("#to").html(admin_email);
    $("#to_id").html(admin_id);
    $("#buyer_id").val(login_id);
    $("#hidden_product_id").val(product_id);
    $("#to_id").val(admin_id);
    $("#from_email").val(login_email);
     
  });

  $(document).on('click','#sendreport',function(){

    var link = $("#link").html();
    var to = $("#to").html();
    var from = $("#buyer_id").val();
    var message = $("#message").val();
    var product_id = $("#hidden_product_id").val();
    var to_id = $("#to_id").val();
    var from_email = $("#from_email").val();
    if(message.trim()=="")
    {
      $("#msg_err").html('Please enter message');
      $('#msg_err').css('color','red');
      return false;
    }else{
      $("#msg_err").html('');
    }

    if(link && to && to_id && from && from_email && message && product_id)
    {

         $.ajax({
              url: SITE_URL+'/send_reportproduct',
              type:"GET",
              data: {link:link,to:to,from:from,message:message,product_id:product_id,from_email:from_email,to_id:to_id},             
              dataType:'json',
              beforeSend: function(){    
             /* showProcessingOverlay();  */   
                $("#loaderimg").show();
                $("#sendreport").hide();
              },  
              success:function(response)
              {
                $("#loaderimg").hide();
                $("#sendreport").show();
               /* hideProcessingOverlay(); */
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
                          }

                        });
                  }
                  else
                  {                
                    swal('Error',response.description,'error');
                  }  
               }/*success*/  
           }); 



    }else{
      return false;
    }  
    
  });



                    

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



  function showmore1(id)
  { 
     $('#show-more-content1_'+id).show();
     $('#show-less1_'+id).show();
     $("#hidecontent1_"+id).hide();
  }

  function showless1(id)
  { 
     $('#show-more-content1_'+id).hide();
     $('#show-less1_'+id).hide();
     $("#hidecontent1_"+id).show();
  }
       
  function showmore2(id)
  { 
     $('#show-more-content2_'+id).show();
     $('#show-less2_'+id).show();
     $("#hidecontent2_"+id).hide();
  }

  function showless2(id)
  { 
     $('#show-more-content2_'+id).hide();
     $('#show-less2_'+id).hide();
     $("#hidecontent2_"+id).show();
  }
 
 
function buyer_redirect_login_product(val)
{
  if(val){
      window.location.href = SITE_URL+"/login/"+val;

  }else{
      window.location.href = SITE_URL+"/login";

  }


}


  $(document).ready(function(){
  
     showcomments(productid);
  
     $('#urlLink').html(window.location.href);


    /*Configure/customize these variables.*/
      var showChar = 400;  /* How many characters are shown by default*/
      var ellipsestext = "...";
      var moretext = "Show more >";
      var lesstext = "Show less";
      

      $('.prod-desc').each(function() {
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


       var screenWidth = window.screen.availWidth;
        if(parseInt(screenWidth) < parseInt(768)){
          $("#flexiselDemo1,#flexiselDemo1222,#flexiselDemo1223,#flexiselDemo68").removeAttr('id');
        }

        /* To show review and its graph as well*/
        $("#start_rating_review").click(function (){
              $('html, body').animate({
                    scrollTop: $("#main-reviewstar").offset().top
                }, 2000);
        });


         /* To redirect user to reviews section when click on the effects*/
        $(".redirect-to-reviews").click(function (){
              $('html, body').animate({
                    scrollTop: $("#main-reviewstar").offset().top
                }, 2000);
        });



        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function(){
          var onStar = parseInt($(this).data('value'), 10); /*The star currently mouse on*/
         
          /*Now highlight all the stars that's not after the current hovered star*/
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
          var onStar = parseInt($(this).data('value'), 10); /* The star currently selected*/
          var stars = $(this).parent().children('li.star');
          
          for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
          }
          
          for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
          }
          
          /*JUST RESPONSE (Not needed)*/
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
    
        $('#lightgallery').lightGallery();

        get_similar_products(first_level_category_id,productid);
        recentlyViewedProduct(productid);
        buyAgainProduct(productid);
        getyoumayLikesProduct(productid);
    
  });


  /*on click ofcomment tab show comments html function*/
  $(document).on('click','#commentsli',function(){
    showcomments(productid);
    $(".showtabcomments").show();
   
   /*$("#showreviewdiv").show();*/

  });


  function showcomments(productid) {
    
    var id   = productid;
    var csrf_token = "<?php echo e(csrf_token()); ?>";

    $.ajax({
          url: SITE_URL+'/showcomments',
          type:"POST",
          data: {product_id:id,_token:csrf_token},             
         /*dataType:'json',*/
          beforeSend: function(){            
          },
          success:function(response)
          {
            $(".showtabcomments").html(response);
          }  

      });
  }

    function showreviews(productid) {
    
    var id   = productid;
    var csrf_token = "<?php echo e(csrf_token()); ?>";

    $.ajax({
          url: SITE_URL+'/showreviews',
          type:"POST",
          data: {product_id:id,_token:csrf_token},             
        /* dataType:'json',*/
          beforeSend: function(){            
          },
          success:function(response)
          {
            $("#showreviewdiv").html(response);

          }  

      });
  }


function isNumberKey(evt)
{
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
}

$('input[name="item_qty"]').keyup(function(e)
{
  if(parseInt($(this).val())==0)
  { 
    $("#qtyerr").html('Please enter the quantity.').css('color','red'); 
  }
  else if(parseInt($(this).val())>1000)
  { 
    $("#qtyerr").html('You can add only upto 1000 items in the cart').css('color','red'); 
    $(this).focus().val(1);
  }
  else if (/\D/g.test(this.value))
  {
    this.value = this.value.replace(/\D/g, '');
  }
  else
  {
    $("#qtyerr").html('');
  }
});


    $(".reply").click(function()
    {
        var comment_id = $(this).attr('id');
        $("#reply_div_for_"+comment_id).addClass('show-comment');
    }); 
    

      $('#btn_add_comment').click(function()
      { 

       if($('#validation-form').parsley().validate()==false) return;
     
         var productid = "<?php echo e($productid); ?>";

         var csrf_token = "<?php echo e(csrf_token()); ?>";
         var product_id = $("#product_id").val();
         var comment    = $("#comment").val();

        $.ajax({
            url: SITE_URL+'/comment/store',
            type:"POST",
            data: {product_id:product_id,comment:comment,_token:csrf_token},             
            dataType:'json',
            beforeSend: function(){   
            showProcessingOverlay();
            $('#btn_add_comment').prop('disabled',true);
            $('#btn_add_comment').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');         
            },
            success:function(response)
            {
              hideProcessingOverlay();
              $('#btn_add_comment').prop('disabled',false);
              $('#btn_add_comment').html('Send');
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
                         
                          $(this).addClass('active');


                        /* showcomments(productid);                      
                         $("#commentsli").addClass('resp-tab-item resp-tab-active');
                         $("#descli").addClass("resp-tab-item");
                         $("#.showtabcomments").addClass('resp-tab-content resp-tab-content-active');
                         $("#showtabdesc").addClass('resp-tab-content resp-tab-content-active');*/

                        
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

      $('.btn_send_reply').click(function()
      {   

   
         var csrf_token = "<?php echo e(csrf_token()); ?>";
         var comment_id = $(this).attr('comment_id');
         var reply      = $(".reply-for-"+comment_id).val();

          if(reply.trim()==""){

            $("#err_reply_"+comment_id).html('Please enter comment');
            $("#err_reply_"+comment_id).css('color','red');
            return false;
         }else{
            $("#err_reply_"+comment_id).html(' ');

          $.ajax({
            url: SITE_URL+'/comment/send_reply',
            type:"POST",
            data: {comment_id:comment_id,reply:reply,_token:csrf_token},             
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
                        $(this).removeClass('show-comment');

                      }

                    });
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 

          } /*else*/
           return false;
       
     }); 


      $('#stars li').click(function(){
         var rating = $(this).data('value'); 
         $("#err_rating").html("");
         $("#rating").val(rating);
      });

      /*send review and rating function*/
      $('#btn_send_review').click(function()
      {       
        
        var flag1= 0; var flag2= 0;var flag3=0;
        var rating = $("#rating").val();        
        var title = $("#title").val();
        var review = $("#review").val();
        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          flag1 = 1;
          return false; 
        }else{
          $("#err_rating").html(''); 
          flag1 =0;           
        }

        if(title=='')
         {
           $("#titleerr").html('Please enter title');
           $("#titleerr").css('color','red');
            return false; 
           flag2= 1;

         }
         else{
            $("#titleerr").html(''); 
            flag2 =0;
         } 

         if(review=='')
         {
           $("#reviewerr").html('Please enter title');
           $("#reviewerr").css('color','red');
           return false; 
           flag3=1;
         }
         else{
            $("#reviewerr").html(''); 
            flag3 =0;
         } 

         
         var form_data   = $('#frm-add-review').serializeArray();      
         form_data.push({name: 'rating', value: rating});

         var csrf_token = "<?php echo e(csrf_token()); ?>";
        
     
        if(flag1==0 && flag2==0 && flag3==0){
   


          $.ajax({
            url: SITE_URL+'/buyer/review-ratings/store',
            type:"POST",
            data: form_data,             
            dataType:'json',
           /* beforeSend: function(){ 
             showProcessingOverlay();
             $('#btn_send_review').prop('disabled',true);
             $('#btn_send_review').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');

            },*/
            success:function(response)
            {
             
              /*hideProcessingOverlay();*/
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

                       
                        $("#reviewform").hide();
                         showreviews(productid);
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
        }/*if flag*/ 
        else{
           return false;
        }

      
       
     }); 

        



   $('#stars li').click(function(){
         var rating = $(this).data('value'); 
         $("#err_rating").html("");
         $("#rating").val(rating);
      });



function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
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
            url: SITE_URL+'/favorite/add_to_favorite',
            type:"POST",
            data: {id:id,type:type,_token:csrf_token},             
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
                $(ref).html('<i class="fa fa-heart-o"></i>Add to WishList');
                
                $(ref).addClass('heart-o-actv');
               /*$(location).attr('href', SITE_URL+'/buyer/my-favourite')*/
               window.location.reload();

                
              }
              else
              {                
                swal('Alert!',response.description);
              }  
            }  

        }); 
  } 

}

  function showFunction(diva, divb) {
    var x = document.getElementById(diva);
    var y = document.getElementById(divb);
          x.style.display = 'block';
          y.style.display = 'none';
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
                $(ref).prop('disabled',true);          
                $(ref).html('Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i>');         
              },
              success:function(response)
              {
                if(response.status == 'SUCCESS')
                { 
                  
                  $(ref).html('<i class="fa fa-heart-o"></i>Add to WishList');
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
}

function shareLink(element)
{
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    /*$('#copy_txt').display('block');
    $("#copy_txt").css("display", "block");*/
    $("#copy_txt").fadeIn(400);
    $("#copy_txt").fadeOut(2000);
}


$('#horizontalTab').easyResponsiveTabs({
  
 type: 'default', /*Types: default, vertical, accordion*/           
 width: 'auto', /*auto or any width like 600px*/
 fit: true, /*100% fit in a container*/
 closed: 'accordion', /*Start closed if in accordion view*/
 activate: function(event) { /*Callback function if tab is switched*/
     var $tab = $(this);
     var $info = $('#tabInfo');
     var $name = $('span', $info);         
     $name.text($tab.text());         
     $info.show();
       

 }
});


        
    $(window).load(function() {
    $("#flexiselDemo1").flexisel();
    $("#flexiselDemo68").flexisel();
    $("#flexiselDemo1222").flexisel();
    $("#flexiselDemo1223").flexisel();
    $("#flexiselDemo2").flexisel({
    visibleItems: 7,
    itemsToScroll: 1,
    animationSpeed: 200,
    infinite: true,
    navigationTargetSelector: null,
    autoPlay: {
    enable: false,
    interval: 5000,
    pauseOnHover: true
    },
    
    responsiveBreakpoints: {
    portrait: {
    changePoint:480,
    visibleItems: 1,
    itemsToScroll: 1
    },
    landscape: {
    changePoint:640,
    visibleItems: 3,
    itemsToScroll: 2
    },
    tablet: {
    changePoint:768,
    visibleItems: 7,
    itemsToScroll: 3
    },
    laptop: {
        changePoint: 1370,
        visibleItems: 6
    }
    }
    });

    
    });
   

/*------------start of script of image zoom demo------------------*/

  function changePreviewProduct(img){
  document.getElementById("img").style.backgroundImage = "url("+img+")";
}

var elementThumbnailPhoto = 'ex-thumbnail-zoom-img';
var elementPhoto = 'ex-zoom-photo';

$('.' + elementThumbnailPhoto)

  .each(function() {
    $(this)
      /*add a photo container*/
      .append('<div id="img" class="' + elementPhoto + '"></div>')
     /* set up a background image for each tile based on data-image attribute*/
      .children('.' + elementPhoto).css({
        'background-image': 'url(' + $(this).attr('data-image') + ')'
      });
  })

   $(document).on('click','#setcoaimage',function(){
    $("#myModalCOA").hide();
     var coa_image = $(this).attr('coaimage');
      if(coa_image.trim()==""){
          $(".cbdimg").html('No Image Avaliable');
          $("#myModalCOA").hide();
      }else{
        $("#myModalCOA").show();
        var img     = "<?php echo e(url('/')); ?>/uploads/product_images/thumb/"+coa_image;
        var img_src = "<?php echo e(url('/')); ?>/assets/images/Pulse-1s-200px.svg";

        var imgsrc ="<img src="+img_src+" data-src="+img+" class='lozad'/>";

        $(".cbdimg").html(imgsrc);
      }
    
   });
  

   $(document).on('click','#close_product_video',function(){
   /* youtube-video
    document.getElementById('youtube-video').contentWindow.location.reload();*/
    $("#yt-player iframe.youtube-video").attr("src",'');
    /*$("#youtube-video").reload();*/
    
   });
  



  

  


    function openProductVideoModal(ref){

      let videoID = $(ref).attr('data-video-id');
      
      let video_source = $(ref).attr('data-video-source');

      let title = $(ref).attr('data-video-title');
      let videoUrl ='';
      if(video_source=="youtube")
      {
        videoUrl = 'https://www.youtube.com/embed/'+videoID/*+'?autoplay=1'*/;
      }
      if(video_source=="vimeo")
      {
        videoUrl = 'https://player.vimeo.com/video/'+videoID/*+'?autoplay=1'*/;
      }

      $("#yt-player iframe.youtube-video").attr("src",videoUrl);

      $(".modal-footer").html('');  
      $("#productVideoModalTitle").html(title);     

      $("#productVideoModal").modal();
    }

  
  



/*send money back guarantee request to admin*/

function sendMoneyBackRequest(ref){

  var product_id = $("#reported_product_id").val();
  var note       = $("#reported_note").val();

  var csrf_token = "<?php echo e(csrf_token()); ?>";

  if($('#reported_note_form').parsley().validate()==false) return;

  $.ajax({
            url: SITE_URL+'/buyer/review-ratings/money_back_request',
            type:"POST",
            data: {product_id:product_id,_token:csrf_token,note:note},             
            dataType:'json',
            beforeSend: function(){ 
             /* showProcessingOverlay();*/
              $('#btn_text_add').prop('disabled',true);
              $('#btn_text_add').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
               /* hideProcessingOverlay();*/

                $('#btn_text_add').prop('disabled',false);
                $('#btn_text_add').html('Send');
              
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
                        }

                      });
                }
                else
                {                
                  swal('Error',response.description,'error');
                }  

            }  

    }); 

}/*end*/




  /*function for update review modal*/

  $(document).on('click','.editreviews',function(){

      var reviewid = $(this).attr('reviewid');
      var reviewuser = $(this).attr('reviewuser');
      var reviewproduct = $(this).attr('reviewproduct');
      var reviewrating = $(this).attr('reviewrating');
       var prev_rating = $(this).attr('star');

      var reviewtitle = $(this).attr('reviewtitle');
      var reviewdesc = $(this).attr('reviewdesc');

      var emoji = $(this).attr('emoji');

      $("#ReviewRatingsAddModal #product_id_modal").val(reviewproduct);
      $("#ReviewRatingsAddModal #review_id").val(reviewid);

      $("#ReviewRatingsAddModal").modal('show');

      $("#title").val(reviewtitle);
      $("#review").val(reviewdesc);
      $("#rating_modal").val(reviewrating);

     /* $("#show_prev_rating").attr('src',SITE_URL+'/assets/buyer/images/star-rate-'+prev_rating+'.svg');*/
      $("#show_prev_rating").attr('src',SITE_URL+'/assets/buyer/images/star/'+prev_rating+'.svg');

      $.each(emoji.split(","), function(i,e){
          $('input:checkbox[name="emoji[]"][value="' + e + '"]').prop('checked',true);
      });

     /* $(document).click(function() {
         $(".checkbox-dropdown").removeClass('is-active');
      }); 
*/
      $("#modalchkboxes").click(function(event) {
        $("#modalchkboxes").toggleClass('checkbox-dropdown is-active');
         /* event.stopPropagation();*/
      });


      
  }); 



/*function for update review modal*/
$('.btn_send_review_modal').click(function()
      { 
        /*var rating = $("#rating_modal").val();*/

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

        if($('#frm-add-review-modal').parsley().validate()==false) return;

        var form_data   = $('#frm-add-review-modal').serializeArray(); 
        form_data.push({name: 'rating_modal', value: rating});

        
         var csrf_token = "<?php echo e(csrf_token()); ?>";
         
        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/update',
            type:"POST",
            data: form_data,             
            dataType:'json',
            beforeSend: function(){ 
            /*showProcessingOverlay();*/
             $('.btn_send_review_modal').prop('disabled',true);
             $('.btn_send_review_modal').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');

            },
            success:function(response)
            {
            /*  hideProcessingOverlay();*/
              $('.btn_send_review_modal').prop('disabled',false);
              $('.btn_send_review_modal').html('Save');
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
                       /*window.location.reload();*/
                        $(this).addClass('active');
                        showreviews(productid);
                        $("#ReviewRatingsAddModal").modal('hide');

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




   var item = {
     "ProductName": "<?php echo e(isset($arr_product['product_name'])?$arr_product['product_name']:''); ?>",
     "ProductID": "<?php echo e(isset($arr_product['id'])?$arr_product['id']:''); ?>",
     "Categories": ["<?php echo e(isset($arr_product['first_level_category_details']['product_type'])? $arr_product['first_level_category_details']['product_type']: ''); ?>"],
     "ImageURL": "<?php echo e($url); ?>",
     "URL": "<?php echo e(url('/')); ?>/search/product_detail/<?php echo e(isset($arr_product['id'])?base64_encode($arr_product['id']):''); ?>/<?php echo e($product_title_slug); ?>/<?php echo e($urlbrands_name); ?>/<?php echo e($urlseller_name); ?>",
     "Brand": "<?php echo e(isset($arr_product['get_brand_detail']['name'])?$arr_product['get_brand_detail']['name']:''); ?>",
     "Price": <?php echo e(isset($price) ? $price : ''); ?>,
     "CompareAtPrice": <?php echo e(isset($arr_product['unit_price'])?num_format($arr_product['unit_price']):''); ?>,
     "Dispensary":"<?php echo e(isset($dispensary_name) ? $dispensary_name : ''); ?>"
   };
 
   _learnq.push(["track", "Viewed Product", item]);
 
   _learnq.push(["trackViewedItem", {
     "Title": item.ProductName,
     "ItemId": item.ProductID,
     "Categories": item.Categories,
     "ImageUrl": item.ImageURL,
     "Url": item.URL,
     "Metadata": {
       "Brand": item.Brand,
       "Price": item.Price,
       "CompareAtPrice": item.CompareAtPrice
     }
   }]);

    

   function add_to_cart(ref) {
     
    var id   = $(ref).attr('data-id');
    var quantity = $('#item_qty').val();
    var csrf_token = "<?php echo e(csrf_token()); ?>";

    if(quantity==""){
      $("#qtyerr").html('Please enter the quantity.');
      $("#qtyerr").css('color','red');   
      return false;
    }
    if(quantity>1000){
      $("#qtyerr").html('You can add only upto 1000 items in the cart');
      $("#qtyerr").css('color','red'); 
      $('#item_qty').focus().val(1);  
      return false;
    }
    else if(quantity=="0"){
      $("#qtyerr").html('Please add atleast 1 quantity to cart.');
      $("#qtyerr").css('color','red');   
      return false;
    }
    else{
      $("#qtyerr").html(''); 
    }

    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){  
            $(ref).attr('disabled');          
           
           $(".add-cart").html('Added To Cart <i class="fa fa-spinner fa-pulse fa-fw"></i>');
          },
          success:function(response)
          {   
            $(".add-cart").html('Add to Cart');
            if(response.status == 'SUCCESS')
            {   
               $(".add-cart").css('background-color','#18ca44');
               $(".add-cart").css('border','#18ca44');
               $(".add-cart").css('color','#fff');
             
                

               $( "#mybag_div" ).load(window.location.href + " #mybag_div" );
            
               _learnq.push(["track", "Added to Cart",response.klaviyo_addtocart]);


                 dataLayer.push({
                        'event': 'GA - Add To Cart',
                        'ecommerce': {
                          'currencyCode': 'USD',
                          'add': {                                
                            'products': [{                       
                              'name': item.ProductName,
                              'id':  item.ProductID,
                              'price': item.Price,
                              'brand': item.Brand,
                              'category': item.Categories,                             
                              'quantity': quantity
                             }]
                          }
                        }
                  });

                 /*-------------------Cart Pop-up ----------------------*/

                 var product_name   = response.product_details.product_name ? response.product_details.product_name : '';
                 var product_image  = response.product_details.product_image ? response.product_details.product_image : '';
                 var item_qty       = response.product_details.item_qty ? response.product_details.item_qty : '';
                 var price          = response.product_details.price ? response.product_details.price : '';
                 var shipping_type  = response.product_details.shipping ? response.product_details.shipping : '';
                 var seller_type    = response.product_details.seller_type ? response.product_details.seller_type : '';

                 var is_price_drop        = response.product_details.is_price_drop ? response.product_details.is_price_drop : '';
                 var unit_price           = response.product_details.unit_price ? response.product_details.unit_price : '';
                 var percent_price_drop   = response.product_details.percent_price_drop ? response.product_details.percent_price_drop : '';

                 $('#add_to_cart_pop_up').addClass('open-cart-box');/* Show pop-up*/

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

                 var image_src = "<?php echo e(url('/')); ?>/assets/images/Pulse-1s-200px.svg";

                 product_image_div.innerHTML  = "<img class='lozad' src='"+image_src+"' data-src='"+product_image+"' id='add_cart_product' alt='Girl in a jacket' width='100' height='100'>";

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
            else
            {                
              
              $("#qtyerr").css('color','red').html(response.description);
            }  
          }  

      });


  }/*add to cart*/


  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";

      $('#prod_name').empty();
      $('#prod_item_qty').empty();
      $('#prod_price').empty();
      $('#product_image').empty();

    }
  }


span.onclick = function() {
  modal.style.display = "none";   

}


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
          'position': productObj.position
         }]
       }
     },
     'eventCallback': function() {
       document.location = productObj.url
     }
  });

}

/*show report issue model*/

function showModel(ref)
{
  var product_id = $(ref).attr('product_id');

  $("#reported_product_id").val(product_id);
  $("#reported_note_model").modal('show');
}


$(".checkbox-dropdown").click(function () {
    $(this).toggleClass("is-active");
});

$(".checkbox-dropdown ul").click(function(e) {
    e.stopPropagation();
});


 $(window).load(function() { 
    dataLayer.push({
       'event': 'PageViews',
      'ecommerce': {
        'detail': {
          'actionField': {'list': 'Search Results'},    
          'products': [<?php echo json_encode($product_view) ?>]
         }
       }
    });

 });



var el = document.getElementById('graph'); /*get canvas*/

var options = {
    percent:  el.getAttribute('data-percent') || 25,
    size: el.getAttribute('data-size') || 220,
    lineWidth: el.getAttribute('data-line') || 15,
    rotate: el.getAttribute('data-rotate') || 0
}

var canvas = document.createElement('canvas');
var span = document.createElement('span');
span.textContent = options.percent + '%';
    
if (typeof(G_vmlCanvasManager) !== 'undefined') {
    G_vmlCanvasManager.initElement(canvas);
}

var ctx = canvas.getContext('2d');
canvas.width = canvas.height = options.size;

el.appendChild(span);
el.appendChild(canvas);

ctx.translate(options.size / 2, options.size / 2); /*change center*/
ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI); /*rotate -90 deg*/


var radius = (options.size - options.lineWidth) / 2;

var drawCircle = function(color, lineWidth, percent) {
    percent = Math.min(Math.max(0, percent || 1), 1);
    ctx.beginPath();
    ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, false);
    ctx.strokeStyle = color;
        ctx.lineCap = 'round'; /*butt, round or square*/
    ctx.lineWidth = lineWidth
    ctx.stroke();
};

drawCircle('#efefef', options.lineWidth, 100 / 100);
drawCircle('#f7982f', options.lineWidth, options.percent / 100);

  function showmore_all_(id,from_where)
  {
     $('#show-more-content_'+from_where+'_'+id).show();
     $('#show-less_'+from_where+'_'+id).show();
     $("#hidecontent_"+from_where+"_"+id).hide();
  }

   function showless_all_(id,from_where)
  {
     $('#show-more-content_'+from_where+'_'+id).hide();
     $('#show-less_'+from_where+'_'+id).hide();
     $("#hidecontent_"+from_where+"_"+id).show();
  }



/* get similar products */
function get_similar_products(first_level_category_id,productid)
{
    $.ajax({
              url:SITE_URL+'/get_similar_products/'+first_level_category_id+'/'+productid,
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
                $("#similar-product-view-loader").show();
                $("#show_similar_products").hide();
              },
            
              success:function(response)
              {
                 $("#similar-product-view-loader").hide();
                 $("#show_similar_products").show();
                 $("#show_similar_products").html(response);

              }/*success*/
    });

} /* end function */

/*function for get recently viewed product*/

function recentlyViewedProduct(productid)
{
    $.ajax({
              url:SITE_URL+'/recently_viewed_products',
              method:'GET',
              data:{productid:productid},
              beforeSend: function(){
                 $("#recently-view-loader").show();
                 $("#recently_viewed_id").hide();
              },
            
              success:function(response)
              {
                 $("#recently-view-loader").hide();
                 $("#recently_viewed_id").show();
                 $("#recently_viewed_id").html(response);

              }/*success*/
      });

}/*end*/


/* get buy again products*/
function buyAgainProduct(productid)
{
    $.ajax({
              url:SITE_URL+'/buy_again_products',
              method:'GET',
              data:{productid:productid},
             //dataType:'json',
              beforeSend: function(){
                //showProcessingOverlay();
                $("#buy-again-view-loader").show();
                $("#buy_again_id").hide();
              },
            
              success:function(response)
              {
                  $("#buy-again-view-loader").hide();
                  $("#buy_again_id").show();
                  $("#buy_again_id").html(response);

              }/*success*/
    });

} /* end buy again */

/* get you may likes products */
function getyoumayLikesProduct(productid)
{
  
    $.ajax({
              url:SITE_URL+'/you_may_likes_products',
              data:{productid:productid},
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
                $("#you-may-like-view-loader").show();
                $("#you_may_likes_id").hide();
              },
            
              success:function(response)
              {
                 $("#you-may-like-view-loader").hide();
                 $("#you_may_likes_id").show();
                 $("#you_may_likes_id").html(response);

              }/*success*/
    });

}/* end you may like */


</script>


<?php $__env->stopSection(); ?>







<!-- <script>
  function gettrackingproductidinfo(productid,quantity)
  {
    if(productid)
    {
       var csrf_token = "<?php echo e(csrf_token()); ?>";

         $.ajax({
                url:SITE_URL+'/gettrackingproduct',
                method:'GET',
                data:{productid:productid,quantity:quantity},
               // dataType:'json',
         
                success:function(response)
                {
                  
                   var _learnq = _learnq || [];
                   _learnq.push(["track", "Added to Cart", {
                   "value": response.value,
                   "AddedItemProductName": response.AddedItemProductName,
                   "AddedItemProductID": response.AddedItemProductID,
                   //"AddedItemSKU": "TALEOFTWO",
                   "AddedItemCategories": response.AddedItemCategories,
                   "AddedItemImageURL": response.AddedItemImageURL,
                   "AddedItemURL": response.AddedItemURL,
                   "AddedItemPrice": response.AddedItemPrice,
                   "AddedItemQuantity": response.AddedItemQuantity,
                   "ItemNames": response.ItemNames,
                   "CheckoutURL": response.CheckoutURL,
                    "Items":response.items
                 }]);

                }//success
            });


    }//if productid
    
  }//end function
</script> -->


          





<?php echo $__env->make('front.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>