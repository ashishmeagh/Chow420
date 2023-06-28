<!DOCTYPE html>
<html lang="en"> 

<style type="text/css">
 .notify {
    position: relative;
}
.notify .heartbit {
    position: absolute;
    top: -32px;
    left: 14px;
    height: 25px;
    width: 25px;
    z-index: 10;
    border: 5px solid #873dc8;
    border-radius: 70px;
    -moz-animation: heartbit 1s ease-out;
    -moz-animation-iteration-count: infinite;
    -o-animation: heartbit 1s ease-out;
    -o-animation-iteration-count: infinite;
    -webkit-animation: heartbit 1s ease-out;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
}

.notify .point {
       width: 6px;
    height: 6px;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
    background-color: #873dc8;
    position: absolute;
    left: 23px;
    top: -23px;
}

@-moz-keyframes heartbit {
    0% {
        -moz-transform: scale(0);
        opacity: 0
    }
    25% {
        -moz-transform: scale(.1);
        opacity: .1
    }
    50% {
        -moz-transform: scale(.5);
        opacity: .3
    }
    75% {
        -moz-transform: scale(.8);
        opacity: .5
    }
    100% {
        -moz-transform: scale(1);
        opacity: 0
    }
}

@-webkit-keyframes heartbit {
    0% {
        -webkit-transform: scale(0);
        opacity: 0
    }
    25% {
        -webkit-transform: scale(.1);
        opacity: .1
    }
    50% {
        -webkit-transform: scale(.5);
        opacity: .3
    }
    75% {
        -webkit-transform: scale(.8);
        opacity: .5
    }
    100% {
        -webkit-transform: scale(1);
        opacity: 0
    }
}
.notification {
  position: relative;
}
.notification-menu {
      position: absolute;
    top: 50px;
    right: 0;
    background-color: #fff;
    padding: 20px;
    list-style: none;
    width: 250px;
    display: none;
    text-align: left;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 1px 0 #ccc;
    text-align: center;
    z-index: 999;
}

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

.h3-earn{
    font-size: 24px; font-weight: 600; color: #020202;margin: 10px 0;
}
.invitebtn-lnks-ab{
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
    width: 100% !important;
}
.invitebtn-lnks-ab:hover, .invitebtn-lnks-ab:focus{
    background-color: #020202;
    color: #fff; border: 1px solid #020202;
} 

.invite-p-drop {
    margin-bottom: 20px;
}
.icon-referal-abt-cw {
    width: 60px;
    margin: 0px auto 0;
}
</style>





<?php
   $currenturl = ''; 
   $currenturl =  Request::fullUrl(); 

  if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo'] != '' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo']))
  {
    $logo = url('/uploads/profile_image/'.$site_setting_arr['site_logo']);
  }
  else
  {                  
    $logo = url('/assets/front/images/chow-logo.png');
  }
 
  /* Meta Tags */

    $meta_url          = url('/');
    $meta_title        = isset($page_title)?$page_title:"";
    $meta_desc         = isset($site_setting_arr['meta_desc'])?$site_setting_arr['meta_desc']:'';
    $meta_keywords     = isset($site_setting_arr['meta_keyword'])?$site_setting_arr['meta_keyword']:'';
    $meta_project_name = config("app.project.name");
    $meta_keywords_details = isset($arr_product['description']) ? $arr_product['description'] : '';

    if(isset($site_setting_arr['site_name']))
    {
      $meta_project_name = $site_setting_arr['site_name'];
    }
    else
    {
      $meta_project_name = config("app.project.name");
    }

    if(isset($meta_desc) && !empty($meta_desc) && strlen($meta_desc)>160)
    {
       $meta_desc = substr($meta_desc,0,165);   
    }

    else if(isset($meta_desc) && !empty($meta_desc) && strlen($meta_desc)<=150)
    {
      $meta_desc = $meta_desc;
    }

    if(isset($meta_title) && !empty($meta_title) && strlen($meta_title)>60)
    {
      $meta_title = substr($meta_title,0,65);
    }

    else if(isset($meta_title) && !empty($meta_title) && strlen($meta_title)<=50)
    {
      $meta_title = $meta_title;
    }
  

 $controller_name =  Request::segment(1);  
 $method_name =  Request::segment(2); 
 $page_name =  Request::segment(3); 
 $seller_param =  app('request')->input('sellers'); 
 //dd($arr_seller_banner);
 $desc_privacy_policy = $desc_terms_conditions = $dec_signup_seller = $desc_login = "";

?>
<?php if($controller_name == "search" && Request::get('category_id')!==null): ?> 
  <?php 

    $category_name_title = Request::get('category_id'); 
    $category_name_title = str_replace("and","&",$category_name_title);
    $category_name_title = str_replace("-"," ",$category_name_title);
    $page_title          = $category_name_title;
    $meta_title          = isset($page_title)?$page_title:"";
  ?>
<?php elseif($controller_name == "search" && Request::get('brands')!==null): ?> 
  <?php 

    $brand_name_title = Request::get('brands'); 
    $brand_name_title = str_replace("and","&",$brand_name_title);
    $brand_name_title = str_replace("-"," ",$brand_name_title);
    $page_title       = $brand_name_title;
    $meta_title       = isset($page_title)?$page_title:"";
  ?>
<?php elseif($controller_name == "search" && Request::get('chows_choice')!==null): ?> 
  <?php  
    $page_title       = "Chow's Choice";
    $meta_title       = isset($page_title)?$page_title:"";
  ?>
<?php endif; ?>

<!-------start-head part-------------->
<head>



<?php echo e($cat_segment =   Request::get('category')); ?>

<?php
    if(isset($cat_segment)){
     $catidurl = base64_decode($cat_segment);
    }else{
        $catidurl ='';
     }
   
    $cat_arr = get_firstlevel_category();

     if(isset($_POST['category_search']))
     {
       $category_search = $_POST['category_search']; 
     }
     else if($catidurl){
        $category_search = $catidurl;
     }else
     {
         $category_search ='';
     }
?>



<?php if(isset($currenturl) && !empty($currenturl)): ?>
  <?php 

  // code for canonical tags seo

  $sellers = app('request')->input('sellers');
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
  $state =  Request::input('state');
  $city =  Request::input('city');
  $chows_choice =  Request::input('chows_choice');
  $chowchoice_filt_stat =  isset($chows_choice)?$chows_choice:'false';
  $best_seller =  Request::input('best_seller');
  $best_seller_filt_stat =  isset($best_seller)?$best_seller:'false';
  $spectrum =  Request::input('spectrum');
  $featured  = Request::input('featured');
  ?>

   <?php if(isset($mg) && !empty($mg) && isset($category_id) && !empty($category_id) && isset($price) && !empty($price) ): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search?category_id=<?php echo e($category_id); ?>" /> 

    <?php elseif(isset($category_id) && !empty($category_id) && isset($price) && !empty($price) ): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search?category_id=<?php echo e($category_id); ?>" /> 

    <?php elseif(isset($brands) && !empty($brands) && isset($price) && !empty($price) ): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search?brands=<?php echo e($brands); ?>" />

    <?php elseif(isset($brands) && !empty($brands) && isset($category_id) && !empty($category_id) ): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search?brands=<?php echo e($brands); ?>&category_id=<?php echo e($category_id); ?>" />

     <?php elseif(isset($category_id) && !empty($category_id)): ?>
      <?php 
          $cats_id='';
          $check_is_category_exists = check_is_category_exists_by_name($category_id);          
          if(isset($check_is_category_exists) && !empty($check_is_category_exists)){

            $cats_id = $check_is_category_exists['product_type'];
      ?>
           <link rel="canonical" href="<?php echo e(url('/')); ?>/search?category_id=<?php echo e($category_id); ?>" /> 
      <?php 
          }else{
      ?>
       <link rel="canonical" href="<?php echo e(url('/')); ?>/search" /> 
      <?php 
         }
      ?>  

    <?php elseif(isset($price) && !empty($price)): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search" />
     <?php elseif(isset($rating) && !empty($rating)): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search" />
     <?php elseif(isset($mg) && !empty($mg)): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search" />
     <?php elseif(isset($chows_choice) && !empty($chows_choice)): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search" />
     <?php elseif(isset($filterby_price_drop) && !empty($filterby_price_drop)): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search" />
     <?php elseif(isset($age_restrictions)  && !empty($age_restrictions)): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search" />
    <?php elseif(isset($best_seller) && !empty($best_seller)): ?>
    <link rel="canonical" href="<?php echo e(url('/')); ?>/search" />    
    <?php else: ?>

      <?php
          if( $controller_name=="search" && $method_name=="product_detail" )
          {      
                
            if(isset($arr_product['id']) && !empty($arr_product['id']) && isset($arr_product['product_name']) && !empty($arr_product['product_name']))
             {  
              
               $product_url = url('/')."/search/product_detail/".base64_encode($arr_product['id'])."/".str_slug($arr_product['product_name']);
             ?>
               <link rel="canonical" href="<?php echo e(isset($product_url) ? $product_url : ''); ?>" />
             <?php  
             }
          }else{
      ?>
       <link rel="canonical" href="<?php echo e(Request::fullUrl()); ?>" />
       <?php } ?>
    <?php endif; ?>
<?php endif; ?>



<!---Google analytics-header------>
<?php
if(isset($site_setting_arr['pixelcode']) && !empty($site_setting_arr['pixelcode'])) {
  echo $site_setting_arr['pixelcode'];
}

//Google ads-header

if(isset($site_setting_arr['google_ads_script']) && !empty($site_setting_arr['google_ads_script'])) {
  echo $site_setting_arr['google_ads_script'];
}

?>

<?php if(isset($controller_name) && isset($method_name) && isset($page_name) && $controller_name == "checkout" && $method_name == "order" && $page_name == "thankyouforshopping"): ?>
  <?php if(isset($order_details_arr) && count($order_details_arr) > 0): ?>
    <!-- Event snippet for Google Ads Pixel Purchase conversion page --> 
    <script> gtag('event', 'conversion', { 'send_to': 'AW-699362218/32FoCJv58-sBEKrXvc0C', 'value': <?php echo e(num_format($order_details_arr[0]['total_amount'])); ?>, 'currency': 'USD', 'transaction_id': '<?php echo e($order_details_arr[0]['order_no']); ?>' }); </script>
  <?php endif; ?>
<?php endif; ?>

  

 <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <?php 
        if(isset($controller_name) && !empty($controller_name)){
       ?> 
          <?php if($controller_name=="chowwatch"): ?>
            <meta name="title" content="Chow Watch | The compliant way to buy hemp-derived products" />
        
          <?php elseif($controller_name=="search" && Request::get('filterby_price_drop')!==null): ?>
            <meta name="title" content="Product | The compliant way to buy hemp-derived products" />
           
          <?php elseif($controller_name=="search" && Request::get('category_id')!==null): ?>
            <meta name="title" content=" <?php echo e($page_title); ?> | The compliant way to buy hemp-derived products" />
          
          <?php elseif($controller_name=="search" && Request::get('brands')!==null): ?>
            <meta name="title" content=" <?php echo e($page_title); ?> | The compliant way to buy hemp-derived products" />
          
          <?php elseif($controller_name=="search" && Request::get('chows_choice')!==null): ?>
            <meta name="title" content="Chow's choice | The compliant way to buy hemp-derived products" />
         
          <?php elseif($controller_name=="search" && Request::get('filterby_price_drop')==null): ?>
            <meta name="title" content="Product | The compliant way to buy hemp-derived products" />

          <?php elseif($controller_name=="forum"): ?>
             <meta name="title" content="Forum | The compliant way to buy hemp-derived products" />

          <?php elseif($controller_name=="signup_seller"): ?>           
             <meta name="title" content="Partner with Chow" />           

          <?php elseif($controller_name=="signup"): ?>
             <meta name="title" content="Start buying the best hemp CBD derived products right here" />  
             
          <?php elseif($controller_name=="login"): ?>
             <meta name="title" content="Sign in to your account and start buying and selling products" />      
          <?php else: ?>
             <meta name="title" content="<?php echo e(isset($meta_title) ? $meta_title : ''); ?>" />
          <?php endif; ?>

       <?php
        }else{
       ?>
        <meta name="title" content="Chow420 | <?php echo e(isset($meta_title) ? $meta_title : ''); ?>" />
       <?php
          }
       ?> 

<meta name="theme-color" content="#ffffff">
<meta name="msapplication-TileColor" content="#9f00a7">
<link rel="manifest" href="<?php echo e(url('/')); ?>/manifest.json">
<meta property="og:type" content="website">  
<meta property="fb:app_id" content="537697573532220" />
 

       <?php 
       $currenturl_path = Request::url();

        if(isset($controller_name) && !empty($controller_name)){
       ?> 
            <?php if($controller_name=="chowwatch"): ?>
              <?php
              $defaultchow =''; $defaultimage='';
              if(isset($news_arr) && !empty($news_arr)){
                  $defaultchow = isset($news_arr[0]['title'])?$news_arr[0]['title']:'';
                  $defaultimage = isset($news_arr[0]['image'])?$news_arr[0]['image']:'';
              }

              ?>
              <meta property="og:url" content="<?php echo e(url('/')); ?>/chowwatch">
              <meta property="og:title" content='Chow Watch | The compliant way to buy hemp-derived products'>
           
             <meta property="og:description" content="Share your CBD story and experience with the world. Get featured on Chow watch and all our social channels. Your story deserves to be heard by the world.">

               <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg"> 
            <?php elseif($controller_name=="shopbrand"): ?>  
                <?php
                $defaultchow =''; $defaultimage='';
                if(isset($arr_featured_brands) && !empty($arr_featured_brands)){
                    $defaultchow = isset($arr_featured_brands[0]['name'])?$arr_featured_brands[0]['name']:'';
                    $defaultimage = isset($arr_featured_brands[0]['image'])?$arr_featured_brands[0]['image']:'';
                }

              ?>
               <meta property="og:url" content="<?php echo e(url('/')); ?>/shopbrand">            
               <meta property="og:title" content='Shop By Brand | The compliant way to buy hemp-derived products'> 
               <meta property="og:description" content="Chow420.com, Welcome to the marketplace for hemp-derived products, built to automate compliance for customers and brands. Choose your brand's products right here.">           
               <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">

            <?php elseif($controller_name=="shopdispensary"): ?>  
                <?php
                $defaultchow =''; $defaultimage='';
                if(isset($arr_featuredseller) && !empty($arr_featuredseller)){
                    $defaultchow = isset($arr_featuredseller[0]['seller_detail']['business_name'])?$arr_featuredseller[0]['seller_detail']['business_name']:'';
                }

              ?>
              <meta property="og:url" content="<?php echo e(url('/')); ?>/shopdispensary">
              <meta property="og:title" content='Shop By Dispensary | The compliant way to buy hemp-derived products'>
               <meta property="og:description" content="Welcome to the marketplace for hemp-derived products, built to automate compliance for customers and dispensaries. Get the best of the products from your dispensary."> 
            
              <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">

            <?php elseif($controller_name=="forum"): ?>  
                <?php
                $defaultchow =''; $defaultimage='';$defaultchowdesc='';
                $postedby ='';
                if(isset($forum_posts) && !empty($forum_posts)){
                    $defaultchow = isset($forum_posts[0]['title'])?$forum_posts[0]['title']:'Chow420';
                    $defaultchowdesc = isset($forum_posts[0]['description'])?$forum_posts[0]['description']:'Chow420';
                    if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                      $defaultchowdesc = substr($defaultchowdesc,0,165);
                    }

                    $defaultimage = isset($forum_posts[0]['image'])?$forum_posts[0]['image']:'';


                    if(isset($forum_posts[0]['user_details']['first_name']) || isset($forum_posts[0]['user_details']['last_name'])){
                        $postedby = $forum_posts[0]['user_details']['first_name'].' '.$forum_posts[0]['user_details']['last_name'];
                      }
                    else{
                        $postedby = isset($forum_posts[0]['user_details']['email'])?$forum_posts[0]['user_details']['email']:'';
                    }
                  
                }//if isset forum post

              ?>
               <meta property="og:url" content="<?php echo e(url('/')); ?>/forum">
               <meta property="og:title" content='Forum | The compliant way to buy hemp-derived products'>
               <meta property="og:description" content="<?php echo e(ucfirst(parse_to_plain_text($defaultchowdesc)) or ''); ?>">
               <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">

            <?php elseif($controller_name=="search" && Request::get('category_id')!==null): ?> 
              <?php 
                $category_description =''; $category_image='';    

                $category_description = get_first_levelcategory_description(Request::get('category_id'));   
                
                if(isset($category_description) && strlen($category_description)>160)
                {
                  $category_description = substr($category_description,0,165);

                }
               
              ?>
                <meta property="og:url" content="<?php echo e(url('/')); ?>/search?category_id=<?php echo e(Request::get('category_id')); ?>">         
                <meta property="og:title" content='<?php echo e($meta_title); ?> | The compliant way to buy hemp-derived products'>
                <meta property="og:description" 
                content="<?php echo ucfirst(parse_to_plain_text($category_description)); ?>">
      
                <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">


            <?php elseif($controller_name=="search" && Request::get('brands')!==null): ?> 
              <?php 
                  
                $brand_description =''; $brand_image='';    

                $brand_description = get_brand_description(Request::get('brands'));   
                
                if(isset($brand_description) && strlen($brand_description)>160)
                {
                  $brand_description = substr($brand_description,0,165);

                }
              ?>
                <meta property="og:url" content="<?php echo e(url('/')); ?>/search?brands=<?php echo e(Request::get('brands')); ?>">         
                <meta property="og:title" content='<?php echo e($meta_title); ?> | The compliant way to buy hemp-derived products'>
                <meta property="og:description" 
                content="<?php echo ucfirst(parse_to_plain_text($brand_description)); ?>">
                <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">


            <?php elseif($controller_name=="search" && Request::get('filterby_price_drop')!==null): ?> 
              <?php 
                  $defaultchow =''; $defaultimage='';$defaultchowdesc='';
                  if(isset($arr_data) && !empty($arr_data))
                  {
                     $defaultchow = isset($arr_data[0]['product_name'])?$arr_data[0]['product_name']:'Chow420';
                     $defaultchowdesc = isset($arr_data[0]['description'])?$arr_data[0]['description']:'Chow420';
                     if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                       $defaultchowdesc =  substr($defaultchowdesc,0,165);
                    }
                  
                  } 
              ?>

                  <meta property="og:url" content="<?php echo e(url('/')); ?>/search?filterby_price_drop=true">
                  <meta property="og:title" content='Todays Deals | The compliant way to buy hemp-derived products'>
                 
                  <meta property="og:description" 
                  content="<?php echo ucfirst(parse_to_plain_text($defaultchowdesc)); ?>">
                  <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">



            <?php elseif($controller_name=="search" && Request::get('chows_choice')!==null): ?> 
              <?php 
                  $defaultchow =''; $defaultimage='';$defaultchowdesc='';
                  if(isset($arr_data) && !empty($arr_data))
                   {
                     $defaultchow = isset($arr_data[0]['product_name'])?$arr_data[0]['product_name']:'Chow420';
                     $defaultchowdesc = isset($arr_data[0]['description'])?$arr_data[0]['description']:'Chow420';
                    if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                      $defaultchowdesc = substr($defaultchowdesc,0,165);
                    }
                  
                   } 
              ?>

                  <meta property="og:url" content="<?php echo e(url('/')); ?>/search?chows_choice=true">
                  <meta property="og:title" content='Chows choice | The compliant way to buy hemp-derived products'>
                  <meta property="og:description" 
                  content="<?php echo ucfirst(parse_to_plain_text($defaultchowdesc)); ?>">
                  <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">
                 


             <?php elseif($controller_name=="search" && Request::get('age_restrictions')!==null): ?> 
              <?php 
                  $defaultchow =''; $defaultimage='';$defaultchowdesc='';$setage='';
                  if(isset($arr_data) && !empty($arr_data))
                  {
                     $defaultchow = isset($arr_data[0]['product_name'])?$arr_data[0]['product_name']:'Chow420';
                    $defaultchowdesc = isset($arr_data[0]['description'])?$arr_data[0]['description']:'Chow420';
                    if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                      $defaultchowdesc = substr($defaultchowdesc,0,165);
                      // $defaultchowdesc = str_replace("&nbsp"," ", $defaultchowdesc);
                      // $defaultchowdesc = str_replace("&rsquo"," ", $defaultchowdesc);
                    }
                     $ageid = base64_decode(Request::get('age_restrictions'));
                     if($ageid=='1')
                      $setage = 'Over 18';
                     elseif($ageid=='2')
                      $setage = 'Over 21';
                  } 
              ?>
                  <meta property="og:title" content='Product | <?php echo e($setage); ?> | <?php echo e(ucfirst($defaultchow)); ?>'>
                  <meta property="og:description" 
                  content="<?php echo ucfirst(parse_to_plain_text($defaultchowdesc)); ?>">
                  <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">


              <?php elseif( $controller_name=="search" && empty($seller_param) && $method_name!="product_detail" ): ?> 
              <?php 
                  $defaultchow =''; $defaultimage='';$defaultchowdesc='';
                  if(isset($arr_data) && !empty($arr_data))
                  {
                     $defaultchow     = isset($arr_data[0]['product_name'])?$arr_data[0]['product_name']:'Chow420';
                     $defaultchowdesc = isset($arr_data[0]['description'])?$arr_data[0]['description']:'Chow420';
                     if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                      $defaultchowdesc = strip_tags(html_entity_decode(substr($defaultchowdesc,0,165)));
                      $defaultchowdesc = str_replace("&nbsp;", '', $defaultchowdesc);
                      $defaultchowdesc = str_replace("&rsquo;", '', $defaultchowdesc);
                    }
                  } 

              ?>
                  <meta property="og:url" content="<?php echo e(url('/')); ?>/search">              
                  <meta property="og:title" content='Shop | <?php echo e(ucfirst($defaultchow)); ?>'>
                  <meta property="og:description" 
                  content="<?php echo ucfirst(parse_to_plain_text($defaultchowdesc)); ?>">
                  <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">

               <?php elseif( $controller_name=="search" && empty($seller_param) && $method_name=="product_detail" ): ?>      
                  <?php 
                    if(isset($arr_product['id']) && !empty($arr_product['id']) && isset($arr_product['product_name']) && !empty($arr_product['product_name']) && isset($arr_product['get_brand_detail']['name']) && !empty($arr_product['get_brand_detail']['name']) && isset($arr_product['user_details']['seller_detail']['business_name']) && !empty($arr_product['user_details']['seller_detail']['business_name']))
                     {  

                     $str_seller = str_slug($arr_product['user_details']['seller_detail']['business_name']);
                     $product_url = "/search/product_detail/".base64_encode($arr_product['id'])."/".$arr_product['product_name'];
                     }
                     else
                     {
                       $product_url = ""; 
                     }

                  ?> 

                     <?php if(!empty($arr_product['product_images_details']) 
                      && count($arr_product['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_images_details'][0]['image'])): ?>
                        <meta property="og:url" content="<?php echo e(url('/')); ?><?php echo e($product_url); ?>">
                        <meta property="og:title" content='Chow420'>
                      

                        <?php 
                           $prod_descr=$match='';
                           if(isset($arr_product['description']) && !empty($arr_product['description']) && strlen($arr_product['description'])>160)
                           {
                             
                              $str_strip_tag =$arr_product['description'];
                              // $str_strip_tag = str_replace("&rsquo;", ' ', $str_strip_tag);
                              // $str_strip_tag = str_replace("&nbsp;", ' ', $str_strip_tag);

                              //$product_desc  = substr($str_strip_tag, 0, 165);
                              preg_match('/^.{1,165}\b/s', $str_strip_tag, $match);
                              $product_desc  = $match[0];
                           }

                           if(isset($product_desc))
                           {
                             $prod_descr = $product_desc;
                           }else
                           {
                               $prod_descr = '';
                           }

                        ?>                
                       <?php endif; ?> 
  
                   <?php elseif( $controller_name=="search" && isset($seller_param) && isset($arr_seller_banner) && $method_name!="product_detail" ): ?> 
                       <?php 
                          $img_path ='';
                          if(isset($arr_seller_banner) && !empty($arr_seller_banner) && file_exists(base_path().'/uploads/seller_banner/'.$arr_seller_banner['image_name']) && $arr_seller_banner['image_name']!="")
                          {             
                            $banner_img = $arr_seller_banner['image_name'];              
                            $img_path =url('/uploads/seller_banner/'.$arr_seller_banner['image_name']);
                          }
                          else
                          {
                            $banner_img = 'chow-bnr-img-large.jpg';
                            $img_path =url('/').'/assets/front/images/open-graph-image.jpg';
                          }
                           $fullname ='';
                           if(!empty($seller_details) && isset($seller_details)){
                             $fname = $seller_details['first_name']; 
                             $lname = $seller_details['last_name'];  
                             $fullname = $fname.' '.$lname; 
                           }
                           
                       ?>   
                      <meta property="og:title" content='<?php echo e(isset($business_details['business_name'])?$business_details['business_name']:'Chow420'); ?> | Explore Products'>   
                     <meta property="og:image" content="<?php echo e($img_path); ?>">

               <?php elseif($controller_name=="signup_seller" ): ?> 
                  <?php
                  $dec_signup_seller     = "Automate your compliance and more with Chow. Run your CBD business the right way!";

                  $dec_signup_seller     = substr($dec_signup_seller,0,165);
                  ?>
                  <meta property="og:url" content="<?php echo e(url('/')); ?>/signup_seller">                
                  <meta property="og:title" content='Partner with Chow'>
                  
                  <meta property="og:description" content="<?php echo e($dec_signup_seller); ?>">   
                   <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">
               <?php elseif($controller_name=="signup" ): ?> .
                  <meta property="og:url" content="<?php echo e(url('/')); ?>/signup/buyer">  
                  <meta property="og:title" content='Start buying the best hemp CBD derived products right here'>
                  <meta property="og:description" content="Chow420.com, Welcome to the marketplace for hemp-derived products, built to automate compliance for customers and dispensaries. Register now for the best products">     
                  <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">   

               <?php elseif($controller_name=="login" ): ?> 
                <?php

                   $desc_login           = "Sign in as a seller or buyer on Chow CBD Marketplace. Thanks for being part of the most trusted CBD community online. Please let us know if you have any questions or concerns.";
                   $desc_login           = substr($desc_login,0,165);
                ?>
                  <meta property="og:url" content="<?php echo e(url('/')); ?>/login">   
                  <meta property="og:title" content='Sign in to your account and start buying and selling products'>
                  <meta property="og:description" content="<?php echo e($desc_login); ?>"> 
                   <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">

                <?php elseif($controller_name=="about-us" ): ?> 
                  <meta property="og:url" content="<?php echo e(url('/')); ?>/about-us"> 
                  <meta property="og:title" content='About | The compliant way to buy hemp-derived products'>
                  <meta property="og:description" content="Get to know more about chow420 products and services. We provide the best online services to the hemp CBD based industry following all the state laws and regulation."> 
                   <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg"> 

                <?php elseif($controller_name=="terms-conditions" ): ?> 
                <?php
                 $desc_terms_conditions = "We offer a wide range of Services, and sometimes additional terms may apply. When you use any Chow Service you also will be subject to the guidelines, terms and agreements on this page. If these Conditions of Use are inconsistent with the Service Terms, those Service Terms will control.";
                 $desc_terms_conditions = substr($desc_terms_conditions,0,165);

                         
                  ?>
                  <meta property="og:url" content="<?php echo e(url('/')); ?>/terms-conditions">  
                  <meta property="og:title" content='Terms Of Use | The compliant way to buy hemp-derived products'>
                  <meta property="og:description" content="<?php echo e($desc_terms_conditions); ?>">
                   <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">

                 <?php elseif($controller_name=="privacy-policy" ): ?> 
                 <?php
                   $desc_privacy_policy   =  "We know that you care how information about you is used and shared, and we appreciate your trust that we will do so carefully and sensibly. This Privacy Notice describes how Chow collects and process your personal information through Chow's websites, devices, products, services, online and physical stores, and applications that reference this Privacy Notice. By using Chow, you are consenting to the practices described in this Privacy Notice.";
                   $desc_privacy_policy  = substr($desc_privacy_policy,0,165);
                           
                  ?>
                  <meta property="og:url" content="<?php echo e(url('/')); ?>/privacy-policy"> 
                  <meta property="og:title" content='Privacy Policy | The compliant way to buy hemp-derived products'>
                  <meta property="og:description" content="<?php echo e($desc_privacy_policy); ?>">  
                   <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">

                 <?php elseif($controller_name=="faq" ): ?>
                  <?php 
                    $defaultchow =''; $defaultimage='';$defaultchowdesc=''; 
                    if(isset($faq_arr) && !empty($faq_arr))
                    {
                      $defaultchow = isset($faq_arr[0]['question'])?$faq_arr[0]['question']:'';
                       if(isset($defaultchow) && !empty($defaultchow) && strlen($defaultchow)>160)
                           {
                              $defaultchow = substr($defaultchow, 0, 165);
                           }

                    }
                  ?>
                  <meta property="og:url" content="<?php echo e(url('/')); ?>/faq"> 
                  <meta property="og:title" content='FAQ | The compliant way to buy hemp derived products'>
                  <meta property="og:description" content="<?php echo e(ucfirst(parse_to_plain_text($defaultchow)) or 'Chow420:FAQ'); ?>">   
                   <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg">

                 <?php else: ?>
                  <meta property="og:url" content="<?php echo e(url('/')); ?>"> 
                  <meta property="og:title" content='Product | The compliant way to buy hemp derived products'>
                  <meta property="og:description" content="Welcome to the number 1 CBD marketplace online Shop from the best quality and top-rated CBD products. Review the products you’ve used and share your thoughts.">  
                   <meta property="og:image" content="<?php echo e(url('/')); ?>/assets/front/images/open-graph-image.jpg"> 
            <?php endif; ?> <!-----end of controller if else---------------->
        <?php
        }
       ?> 

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(isset($meta_url) ? $meta_url : ''); ?>">
    <meta property="twitter:title" content='<?php echo e(isset($meta_title) ? $meta_title : ""); ?> | <?php echo e(isset($meta_project_name) ? $meta_project_name : ""); ?>'>        

    <?php if(!empty($arr_product['product_images_details']) 
           && count($arr_product['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_images_details'][0]['image'])): ?>

     
               <?php 
                   $prod_desc=$match='';
                   if(isset($arr_product['description']) && !empty($arr_product['description']) && strlen($arr_product['description'])>160)
                   {
                      $str_strip_tag = $arr_product['description'];
                      preg_match('/^.{1,165}\b/s', $str_strip_tag, $match);
                      $product_desc  = $match[0];
                   }

                   if(isset($product_desc))
                   {
                     $prod_desc = $product_desc;
                   }else
                   {
                       $prod_desc = '';
                   }

                ?>

      <meta name="description" content="<?php echo ucfirst(parse_to_plain_text($prod_desc)); ?>" />
      <meta name="keywords" content="<?php echo e(meta_keywords_transform($meta_keywords_details)); ?>" />


      <meta property="og:image" content="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_images_details'][0]['image']); ?>"> 

      <meta property="og:description" content="<?php echo ucfirst(parse_to_plain_text($prod_desc)) ?>">

      <meta property="twitter:image" content="<?php echo e(url('/')); ?>/uploads/product_images/thumb/<?php echo e($arr_product['product_images_details'][0]['image']); ?>">
      <meta property="twitter:description" content=" <?php echo htmlspecialchars($arr_product['description']); ?> ">
    
    <?php else: ?>
       
             <?php 
              if(isset($controller_name) && !empty($controller_name)){

                $meta_desc_filter_price_drop = " ";

                 $meta_desc_filter_price_drop = substr("Welcome to the number 1 CBD marketplace online Shop from the best quality and top-rated CBD products. Review products you’ve used and share your thoughts with the community",0,165);

                 $meta_desc_search           = "Welcome to the number 1 CBD marketplace online Shop from the best quality and top-rated CBD products. Review the products you’ve used and share your thoughts.";

             ?> 
                <?php if($controller_name=="chowwatch"): ?>
               
                <?php elseif($controller_name=="search" && Request::get('category_id')!==null): ?>
                  <?php 
                    $category_description ='';     

                    $category_description = get_first_levelcategory_description(Request::get('category_id'));   
                    if(isset($category_description) && strlen($category_description)>160)
                    {
                      $category_description = substr($category_description,0,165);

                    }
                    
                  ?>
                  <meta name="description" content="<?php echo ucfirst(parse_to_plain_text($category_description)) ?>" />
                <?php elseif($controller_name=="search" && Request::get('brands')!==null): ?>
                  <?php 
                    $brand_description ='';    

                    $brand_description = get_brand_description(Request::get('brands'));   
                    if(isset($brand_description) && strlen($brand_description)>160)
                    {
                      $brand_description = substr($brand_description,0,165);

                    }
                  ?>
                  <meta name="description" content="<?php echo ucfirst(parse_to_plain_text($brand_description)) ?>" />
                
                <?php elseif($controller_name=="search" && Request::get('filterby_price_drop')!==null): ?>
                   <meta name="description" content="<?php echo e($meta_desc_filter_price_drop); ?>" />
                <?php elseif($controller_name=="search" && Request::get('filterby_price_drop')==null): ?>
                  <meta name="description" content="<?php echo e($meta_desc_search); ?>" />

                 
                <?php elseif($controller_name=="forum"): ?>
                  <meta name="description" content="Ask, Learn, Share, and Teach about CBD. Utilize our Forum to know more about CBD from experts, sellers, and consumers about their CBD experiences." />
                <?php else: ?>
                   <meta name="description" content="<?php echo $meta_desc ?>" />
                <?php endif; ?>

             <?php
              }//if controller name
              else
              {
             ?>
                <meta name="description" content="<?php echo $meta_desc ?>" />
             <?php
              }
             ?> 
    
            <meta name="keywords" content="<?php echo e(meta_keywords_transform($meta_desc)); ?>" />

            <!-------if controller is search---------------->
             <?php if(isset($controller_name) && isset($seller_param) && $controller_name=="search" && isset($arr_seller_banner)): ?>
                  <?php 
                    if(isset($arr_seller_banner) && !empty($arr_seller_banner) && file_exists(base_path().'/uploads/seller_banner/'.$arr_seller_banner['image_name']) && $arr_seller_banner['image_name']!="")
                    {             
                      $banner_img = $arr_seller_banner['image_name'];              
                      $img_path = url('/uploads/seller_banner/'.$arr_seller_banner['image_name']);
                    }
                    else
                    {
                      $banner_img = 'chow-bnr-img-large.jpg';
                      $img_path =url('/').'/assets/front/images/open-graph-image.jpg';
                    }
                     $fullname ='';
                     if(!empty($seller_details) && isset($seller_details)){
                       $fname = $seller_details['first_name']; 
                       $lname = $seller_details['last_name'];  
                       $fullname = $fname.' '.$lname; 
                     }

                 ?>   
                <meta property="og:title" content='<?php echo e(isset($business_details['business_name'])?$business_details['business_name']:'Chow420'); ?> | Explore Products'>   
               <meta property="og:image" content="<?php echo e($img_path); ?>">
                <!-------else of controller is search---------------->
               <?php else: ?>
           
                     <?php if(!empty($arr_slider_images) && count($arr_slider_images)>0): ?>
                   
                              <?php if(isset($arr_slider_images[0][0]['slider_image']) && file_exists(base_path().'/uploads/slider_images/'.$arr_slider_images[0][0]['slider_image']) && isset($arr_slider_images[0][0]['slider_image'])): ?> 
                          <meta property="og:url" content="<?php echo e(url('/')); ?>">

                          <meta property="og:title" content='Chow420 | The compliant way to buy hemp-derived products.'>
                          <meta property="og:description" content="Welcome to the number 1 CBD marketplace online Shop from the best quality and top-rated CBD products. Review the products you’ve used and share your thoughts.">

                          <meta property="og:image" content="<?php echo e(url('/')); ?>/uploads/slider_images/<?php echo e($arr_slider_images[0][0]['slider_image']); ?>">
                     <?php else: ?>
                       <meta property="og:image" content="<?php echo e(url('/assets/front/images/open-graph-image.jpg')); ?>">
                     <?php endif; ?>

         
                <?php endif; ?>  

      <?php endif; ?>
  
      <meta property="twitter:image"  content="<?php echo e($logo); ?>">
    <?php endif; ?>  
  
    <title><?php echo e(isset($page_title) ? $page_title : ''); ?> | <?php echo e(isset($meta_project_name) ? $meta_project_name : ""); ?></title>


    <!--  Apple -->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(url('/')); ?>/assets/favicon/apple-icon-180x180.png">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Chow420">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">

    <link rel="mask-icon" href="<?php echo e(url('/')); ?>/assets/favicon/safari-pinned-tab.svg" color="#873dc8">
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo e(url('/')); ?>/assets/splash/apple/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <!--  Generic -->
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo e(url('/')); ?>/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(url('/')); ?>/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(url('/')); ?>/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(url('/')); ?>/assets/favicon/favicon-16x16.png">
    
    <!--  MS -->
    <meta name="msapplication-TileImage" content="<?php echo e(url('/')); ?>/assets/favicon/ms-icon-144x144.png">
        
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(url('/')); ?>/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--font-awesome-css-start-here-->
    <link href="<?php echo e(url('/')); ?>/assets/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> 
    <!--Custom Css-->

    <link href="<?php echo e(url('/')); ?>/assets/front/css/flexslider.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo e(url('/')); ?>/assets/front/css/chow.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('/')); ?>/assets/front/css/listing.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('/')); ?>/assets/front/css/range-slider.css" rel="stylesheet" type="text/css" />
    <!-- parsley validation css -->
    <link href="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.css" rel="stylesheet">
    <link href="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,900,900i" rel="stylesheet">

   <link href="<?php echo e(url('/')); ?>/assets/front/css/front_header.css" rel="stylesheet" type="text/css" />
    <?php
     $login_user = Sentinel::check();  
     if ( $login_user==true && $login_user->inRole('seller') == true) 
     {
    ?>
    <link href="<?php echo e(url('/')); ?>/assets/front/css/addtocart.css" rel="stylesheet">
    <?php  
     }
    ?>

    <!--Main JS-->
    <script type="text/javascript"  src="<?php echo e(url('/')); ?>/assets/front/js/jquery-1.11.3.min.js"></script>
    <!--[if lt IE 9]>-->
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

    <!-- loader js -->
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/loader/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/loader/loader.js"></script>
 
     
<!-- Scription Inclusions Ends -->



<script type="text/javascript">
$(document).ready(function(){
    $("#myiploadModal").modal({
    show:false,
    backdrop:'static'
    });
});

  /* Install Service Worker */
  var SITE_URL = '<?php echo e(url('/')); ?>';
  (function() {
    if (!('serviceWorker' in navigator)) {
      console.log('Service worker not supported');
      return;
    }
    navigator.serviceWorker.register('service-worker.js')
    .then(function(registration) {
      console.log('SW successfully registered');
    })
    .catch(function(error) {
      console.log('registration failed', error);
    });
  })();
</script>

<!-----------start of review snippet code--------->
<?php 

  $brandname ='';
  $average ='';
  $reviewcount ='';
  $sku ='';

  $current_segment1 = Request::segment(1);
  $current_segment2 = Request::segment(2);

  $arr_parameters = array_keys(Request::all());
  if(isset($current_segment2) && $current_segment2 == "product_detail")
  {
    $arr_aggregate_rating = get_aggregate_rating($current_segment2,$arr_product);

  }
  else if(isset($current_segment1) && $current_segment1 == "search" && in_array('brands',$arr_parameters))
  {
    $arr_aggregate_rating = get_aggregate_rating('brands',Request::all());

  }else if(isset($current_segment1) && $current_segment1 == "search" && in_array('sellers',$arr_parameters))
  {
    $arr_aggregate_rating = get_aggregate_rating('sellers',Request::all());

  }
  else
  {
    $arr_aggregate_rating = get_aggregate_rating('','');

  }//else

?>


 <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Product",
   "brand": {
        "@type": "Brand",
        "name": "<?php echo e($arr_aggregate_rating['brand_name']); ?>"
      },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo e($arr_aggregate_rating['average_rating_value']); ?>",
    "reviewCount": "<?php echo e($arr_aggregate_rating['review_count']); ?>"
  },
  "description": "Chow420",
  "name": "<?php echo e($arr_aggregate_rating['product_name']); ?>",
  "image": "<?php echo e($arr_aggregate_rating['image']); ?>",
  "sku": "<?php echo e($arr_aggregate_rating['sku']); ?>",
  "mpn": "<?php echo e($arr_aggregate_rating['mpn']); ?>",
  "offers": {
    "@type": "Offer",
    "availability": "<?php echo e($arr_aggregate_rating['availability']); ?>",
    "price": "<?php echo e($arr_aggregate_rating['price']); ?>",
    "priceCurrency": "USD",
     "url": "http://chow420.com",
     "priceValidUntil": "<?php echo e($arr_aggregate_rating['price_valid_until']); ?>"
  },
  "review": [
    {
      "@type": "Review",
      "author": "<?php echo e($arr_aggregate_rating['author']); ?>",
      "datePublished": "<?php echo e($arr_aggregate_rating['datePublished']); ?>",
      "reviewBody": "<?php echo e($arr_aggregate_rating['reviewBody']); ?>",
      "name": "<?php echo e($arr_aggregate_rating['name']); ?>",
      "description": "Chow420",
      "reviewRating": {
        "@type": "Rating",
        "bestRating": "<?php echo e($arr_aggregate_rating['reviewRating']['bestRating']); ?>",
        "ratingValue":"<?php echo e($arr_aggregate_rating['reviewRating']['ratingValue']); ?>",
        "worstRating": "<?php echo e($arr_aggregate_rating['reviewRating']['worstRating']); ?>"
      }
    }    
  ]
}
</script>
<!-----------end of review snippet code--------->
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "url": "https://chow420.com/",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://chow420.com/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
</script>

</head> <!---end header-------->
<body> <!---start body------------->


<?php

// code for setting google tag manager in the body section

if(isset($site_setting_arr['body_content']) && !empty($site_setting_arr['body_content'])) {
  echo $site_setting_arr['body_content'];
}
?>

   

        

<!-- Back to top button -->
<a id="scroll-to-top"></a>
<div id="main"></div>   
<div <?php if(isset($login_user) && $login_user == false): ?> class="header header-home" <?php else: ?> class="header header-home searchcentralize" <?php endif; ?>>
   <?php
   $arr_announcements =  get_announcements();
  ?>
  <?php if(isset($arr_announcements) && count($arr_announcements) > 0): ?>    
  <style>
  .link-announment .announcements-holder .announcements-title p{
    display: initial;
  }
  </style>    
                        
<div id="carouselexamplegeneric" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner mrnon" role="listbox">
    <?php $__currentLoopData = $arr_announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
        
            if($k=='0')
              $active = 'item active';
            else
              $active = 'item';

          if($announcement['background_color'] !=''){ 
            $bgcolor = ($announcement['background_color']!=''?'background-color:'.$announcement['background_color'].';':''); 
          } 
          if($announcement['title_color'] !=''){ 
            $title_color = ($announcement['title_color']!=''?'color:'.$announcement['title_color'].';':''); 
          } 
        ?>
        <div onclick="window.open('<?php if($announcement['background_url'] !=''): ?><?php echo e($announcement['background_url']); ?><?php endif; ?>');" class="announcements-holder <?php echo e($active); ?>" style="<?php echo e($bgcolor); ?><?php echo e($title_color); ?>">
          <div class="announcements-title"><?php echo $announcement['title']; ?></div>
        </div>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   
 </div>
</div>
<?php endif; ?>
        
                    
<div class="header-contnr">
  <div class="headerchnagesmobile">           
      <div class="logo-block decstopview" >
          <a href="<?php echo e(url('/')); ?>">

              <img src="<?php echo e($logo); ?>" alt="Logo" class="main-logo"/>
          </a>
      </div> 
      <?php if(Route::getCurrentRoute()->uri() != '/'): ?>  
        <div class="mobile-arrow-re" >
          <a href="javascript:history.back();"> <img src="<?php echo e(url('/')); ?>/assets/front/images/chow-chevron-left.svg" alt="Chow420"></a>
        </div> 
      <?php endif; ?>  
          
     <span class="menu-icon leftsidemenuin" onclick="openNav()">  </span>
      <?php

          $login_user = Sentinel::check(); 
        
          if($login_user == false)
             $cls ='search-home-header search-ovely';
           else
              $cls ='search-home-header afterloginsearch search-ovely';
      ?>

            
    <div class="<?php echo e($cls); ?>">
         <form method="get" id="searchform" autocomplete="off" onsubmit="return false">

            <div class="select-style" id="someSelect" style="display: none;">
             <select name="category_search" class="resizeselect" id="category_search">
                <option value="All" 
                <?php if($category_search=="All"): ?>) selected="selected" <?php endif; ?>></option>
                <?php if(count($cat_arr)>0 && !empty($cat_arr)): ?>
                  <?php $__currentLoopData = $cat_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <option value="<?php echo e(base64_encode($category['id'])); ?>"  <?php echo e($category_search==$category['id']?'selected':''); ?>>
                        <?php echo e($category['product_type']); ?>

                   </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                <?php endif; ?>
            </select> 
           </div>

           <?php

          $product_search_url = Request::input('product_search');
          if(isset($product_search_url))
          {
            $header_product_search = $product_search_url;
          }else{
            $header_product_search = '';
          }
          
           ?>

            <input type="text" name="product_search" id="product_search" placeholder="Search" value="<?php echo e($header_product_search); ?>" onkeyup="searchAutocomplete();"/>
            <input type="button" class="btnsinuts" id="btn_search" name="btn_search" value="">


          <div id="productList"></div>
          <span id="product_list_error"></span>


       </form>
    </div>
    <?php

        $login_user = Sentinel::check();    

    ?>
    <div class="droupdownmenuright">
             
          <!-------------------------referal user-------------------------------->
                 
          <?php
             $referalcode = '';

             $user = Sentinel::check();

             $get_buyer_referal_code = get_buyer_referal_code();
             if(isset($get_buyer_referal_code))
             {
               $referalcode = $get_buyer_referal_code;
             }
              $buyer_referal_amount = $buyer_refered_amount = '';
              $buyer_referal_amountarr =get_buyer_referal_amount_details();

              if(isset($buyer_referal_amountarr) && !empty($buyer_referal_amountarr))
              {
                 $buyer_referal_amount = isset($buyer_referal_amountarr)?$buyer_referal_amountarr:'';
              }

              $buyer_refered_amountarr =get_buyer_refered_amount_details();

              if(isset($buyer_refered_amountarr) && !empty($buyer_refered_amountarr))
              {
                 $buyer_refered_amount = isset($buyer_refered_amountarr)?$buyer_refered_amountarr:'';
              } 


          ?>
          

            <div class="aboutlink hidenmobile-link">
              <a href="<?php echo e(url('/')); ?>/helpcenter" <?php if(Request::segment(1) == 'helpcenter'){ echo 'class="terms-links active"'; }else { echo 'class="terms-links"'; } ?> target="_blank">Help Center</a>
            </div>

          
             <div class="favoirt-main-li">
             <div class="notification">
                  <?php 
                    
                    $amount = 0;  
             
                    if($user!=false && $user->inRole('buyer'))
                    {
                      $amount = $buyer_referal_amount;
                    }
                    elseif($user!=false && $user->inRole('seller'))
                    { 
                      $amount = config('app.project.seller_referal');
                    }
                    else
                    {
                      $amount = $buyer_referal_amount;
                    }
                    
                  ?>
                
                  <a class="btn btn-info showreferaldropdown" style="width: 100%; min-width: 93px; background-color: transparent; color: #020202; border: transparent;"> 
                     <div class="zindx-sbr"> Earn  <?php 
                       echo "$". $amount; 
                      ?>    </div>
                      <div class="notify">
                        <div class="heartbit"></div>
                        <div class="point"></div>
                      </div>
                  </a>

                  

                   <div class="notify">
                    <span class="heartbit1"></span>
                    <span class="point123"></span>
                   </div>

                  <div class="notification-menu">
                      <div class="width-drop" >
                    <div class="icon-referal-abt-cw">

                    <?php
                      //image resize
                      $resize_referal_img = image_resize('/assets/seller/images/referal.png',60,60);
                    ?>

                    

                      <img class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($resize_referal_img); ?>"  alt="">

                    </div>

                  <?php if($user!=false && $user->inRole('buyer')): ?>  

                    <div class="h3-earn">
                         Earn 
                        <?php 
                         echo "$". $buyer_referal_amount; 
                        ?> 
                    </div>
                    <div class="invite-p-drop">
              
                      Gift friends and family <?php echo e('$'.$buyer_refered_amount); ?> in Chowcash when you invite them to Chow and get <?php echo e('$'.$buyer_referal_amount); ?> in Chowcash credits when they make their first purchase.

                    </div>

                    <a href="<?php echo e(url('/')); ?>/referbuyer?referalcode=<?php echo e($referalcode); ?>" class="invitebtn-lnks-ab" target="_blank">Invite</a>

                  <?php elseif($user!=false && $user->inRole('seller')): ?>

                   <div class="h3-earn">
                         Earn 
                        <?php 
                         echo "$".config('app.project.seller_referal'); 
                        ?> 
                    </div>
                    <div class="invite-p-drop">
              
                      Invite other sellers and get <?php 
                         echo "$".config('app.project.seller_referal'); 
                        ?>  in your wallet when they register using your link

                    </div>

                    <a href="<?php echo e(url('/')); ?>/refer?referalcode=<?php echo e($referalcode); ?>" class="invitebtn-lnks-ab" target="_blank">Invite</a>

                  <?php else: ?>
         
                    <div class="h3-earn">
                         Earn 
                        <?php 
                         echo "$". $buyer_referal_amount; 
                        ?> 
                    </div>
                    <div class="invite-p-drop">
              
                     Gift friends and family <?php echo e('$'.$buyer_refered_amount); ?> in Chowcash when you invite them to Chow and get <?php echo e('$'.$buyer_referal_amount); ?> in Chowcash credits when they make their first purchase.
                     

                    </div>

                      <a href="<?php echo e(url('/')); ?>/login" class="invitebtn-lnks-ab" target="_blank">Login to Refer</a>  

                  <?php endif; ?>  
                    
                 

                </div>
                <div class="clearfix"></div>
                  </div>
                </div>
            </div>
         

              <!------------------------------refer user-------------------------------------->
                <?php if($login_user == false): ?>
                   
                <?php endif; ?>

                <div class="dropdown-new hover-new linkhover desktopviewnone">
                      <?php if($login_user == true): ?>

                        <a href="javascript:void(0)" class="usershowmobile">
                           <?php 
                            

                              $set_user_name ='';

                             if($login_user->inRole('buyer') == true)
                              {
                                  $url = url('/')."/buyer";

                                  if($login_user['first_name']==" " || $login_user['last_name']==""){
                                    $set_user_name ='New User';
                                  }else{

                                        $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                        if($totallength>10)
                                        {
                                           $set_user_name =  $login_user['first_name'];
                                        }else{
                                           $set_user_name =  $login_user['first_name'].' '.$login_user['last_name'];
                                        }

                                  }

                              }// if role is buyer
                              elseif ($login_user->inRole('seller') == true) {
                                  $url = url('/')."/seller";


                                  if(isset($seller_arr) && !empty($seller_arr)){
                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_user_name = $login_user['email']; 
                                      }
                                      else
                                      {
                                        
                                          $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                          if($totallength>10)
                                          {
                                              $set_user_name =  $login_user['first_name'];
                                          }else{
                                             $set_user_name =  $login_user['first_name'].' '.$login_user['last_name'];
                                          }
                                      }//else 
                                  }// if isset seller array
                              }// if role is seller
                              if($login_user->inRole('admin') == true)
                              {
                                  $url = url('/');

                                  if($login_user['first_name']==" " || $login_user['last_name']==""){
                                    $set_user_name ='Admin';
                                  }else{

                                        $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                        if($totallength>10)
                                        {
                                           $set_user_name =  $login_user['first_name'];
                                        }else{
                                           $set_user_name =  $login_user['first_name'].' '.$login_user['last_name'];
                                        }

                                  }

                              }// if role is admin

                           ?>
                           
                           <span class="mobileviewnond short-name newhr"><span class="avatar-head"><img src="<?php echo e(url('/')); ?>/assets/front/images/chow-user.svg" alt=""></span> <div class="nameinlinecws"><?php echo e($set_user_name); ?></div></span>
                        </a>
                        <i class="fa fa-angle-down"></i>
                    <?php else: ?>
                        <a href="javascript:void(0)" class="usershowmobile leftavatr">
                          <span class="avatar-head mobileviewnond"><img src="<?php echo e(url('/')); ?>/assets/front/images/chow-user.svg" alt=""></span>
                          <span class="mobileviewnond">Your Account</span></a><i class="fa fa-angle-down"></i>
                    <?php endif; ?>
                    
                    <ul>
                           <?php if($login_user == false): ?>

                            <li class="signin-header">
                                <a href="<?php echo e(url('/').'/login'); ?>">Sign In</a>                          
                            <div class="signuplogins donthave-acnt"><span></span><div class="donthvct">Don't have an account?</div>
                            <div class="byr-center-lnks">                           
                              <a href="<?php echo e(url('/').'/login'); ?>" class="widthauto">Register </a>
                              </div>
                            </div>                            
                            </li>
                        <?php else: ?>

                            <?php
                              $set_name = $url = '';
                              if($login_user->inRole('buyer') == true)
                              {
                                  $url = url('/')."/buyer";

                                  if($login_user['first_name']=="" || $login_user['last_name']==""){
                                    $set_name = 'New User';
                                  }else{
                                   $set_name = $login_user['first_name'].' '.$login_user['last_name']; 
                                  }


                              }
                              elseif ($login_user->inRole('seller') == true) {
                                  $url = url('/')."/seller";

                                  if(isset($seller_arr) && !empty($seller_arr)){
                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_name = $login_user['email']; 
                                      }else{
                                        $set_name = $login_user['first_name'].' '.$login_user['last_name']; 
                                      } 
                                  }
                              }
                               elseif ($login_user->inRole('admin') == true) {
                                        $url = url('/');

                                  
                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_name = $login_user['email']; 
                                      }else{
                                        $set_name = $login_user['first_name'].' '.$login_user['last_name']; 
                                      } 
                              }
                            ?>

                            <li class="signin-header">
                              
                                <?php if($login_user==true  && $login_user->inRole('admin') == true): ?>
                                <a href="#">
                                    <!-- <?php echo e(isset($set_name) ? $set_name : ''); ?> -->
                                    Account
                                 </a>  
                                <?php else: ?>
                                  <a href="<?php echo e($url); ?>/profile">
                                     <!-- <?php echo e(isset($set_name) ? $set_name : ''); ?> -->
                                     Account
                                  </a>
                                <?php endif; ?>

                            </li>
                            <?php if($login_user==true  && $login_user->inRole('admin') == true): ?>
                            <?php else: ?>
                            <li><a href="<?php echo e($url); ?>/profile">My Profile </a></li>
                            <li><a href="<?php echo e($url); ?>/notifications">Notification</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo e(url('/logout')); ?>">Log Out</a></li>
                        <?php endif; ?>

                        
                    </ul>
                </div>
              
              
                <div class="favoirt-main">                  

                    <div class="favoirt-main-li " id="add_to_cart_pop_up" >  
                        <?php if($login_user == false): ?>                          
                            <a href="<?php echo e(url('/')); ?>/my_bag" id="mybag_div"><span><?php echo e(isset($cart_count) ? $cart_count : ''); ?></span> <img src="<?php echo e(url('/')); ?>/assets/front/images/cart-icon-header.svg"  alt="Shopping Cart" /></a>

                        <?php elseif($login_user == true && $login_user->inRole('buyer')): ?>

                            <a href="<?php echo e(url('/')); ?>/my_bag" id="mybag_div"><span><?php echo e(isset($cart_count) ? $cart_count : ''); ?></span> <img src="<?php echo e(url('/')); ?>/assets/front/images/cart-icon-header.svg"  alt="Shopping Cart" /></a>

                        <?php elseif($login_user == true && ($login_user->inRole('seller') || $login_user->inRole('admin'))): ?>

                            <a href="javascript:void(0)" onclick="swal('Alert!','If you want to buy a product, then please login as a buyer.');"><span>0</span> <img src="<?php echo e(url('/')); ?>/assets/front/images/cart-icon-header.svg"  alt="Shopping Cart" /></a>
                   
                        <?php endif; ?>

                        <a class="classlink" href="<?php echo e(url('/')); ?>/my_bag" >
                        <div class="box-addtocard-box">
                            <div class="left-addtocard-box">
                            <div id="product_image"></div> 
                            </div>
                            <div class="right-addtocard-box">
                                <div class="productnametitles"><div id="prod_name"></div></div>
                                  <div class="view-modal-div-main">
                                    <div class="view-modal-div-left">Quantity:</div>
                                    <div class="view-modal-div-right">
                                       <div id="prod_item_qty"></div> 
                                    </div>
                                  </div>

                                  <div class="view-modal-div-main">
                                    <div class="view-modal-div-left">Price:</div>
                                    <div class="view-modal-div-right">
                                       <div id="prod_price">
                                       </div> 
                                    </div>
                                  </div>
                               
                                  <div class="view-modal-div-main">
                                    <div class="view-modal-div-right">
                                       <div id="seller"></div> 
                                    </div>
                                  </div>

                            </div>
                             <div class="clearfix"></div>
                          
                        </div>
                          <div class="clearfix"></div>
                      </a>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="logo-block mobileviewlogo" >
                <a href="<?php echo e(url('/')); ?>" class="logocentermo">
                    <img src="<?php echo e($logo); ?>" alt="Logo" class="main-logo" />
                </a>
            </div>
            <div class="clearfix"></div>
            <span class="menu-icon" onclick="openNav()">&#9776;</span>
            <!--Menu Start-->
            <div  class="sidenav" id="mySidenav">
                <a href="javascript:void(0);" class="closebtn" onclick="closeNav()">&times;</a>
                <div class="banner-img-block activedropdown">
                    <div class="img-responsive-logo">
                      <img src="<?php echo e(url('/')); ?>/assets/front/images/chow-logo-mobile.png" alt="Logo" />
                    </div>

                     <div class="dropdown-new hover-new dropclick" id = "sign_in_dropdown">

                      <?php if($login_user == true): ?>

                        <a href="javascript:void(0)" class="usershowmobile">
                           <?php
                            /*******************set name in mobile view****************/

                             $set_user_name_mobile ='';
                             if($login_user->inRole('buyer') == true)
                              {
                                  $url = url('/')."/buyer";

                                  if($login_user['first_name']=="" || $login_user['last_name']==""){
                                    $set_user_name_mobile ='New User';
                                  }else{

                                      $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                      if($totallength>10)
                                      {
                                         $set_user_name_mobile =  $login_user['first_name'];
                                      }else{
                                         $set_user_name_mobile =  $login_user['first_name'].' '.$login_user['last_name'];
                                      }
                                 }

                              }// if role is buyer
                              elseif ($login_user->inRole('seller') == true) {
                                  $url = url('/')."/seller";


                                  if(isset($seller_arr) && !empty($seller_arr)){
                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_user_name_mobile = $login_user['email']; 
                                      }
                                      else
                                      {
                                        
                                          $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                          if($totallength>10)
                                          {
                                              $set_user_name_mobile =  $login_user['first_name'];
                                          }else{
                                             $set_user_name_mobile =  $login_user['first_name'].' '.$login_user['last_name'];
                                          }
                                      }//else 
                                  }// if isset seller array
                              }// if role is seller

                               elseif ($login_user->inRole('admin') == true) {
                                  $url = url('/');


                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_user_name_mobile = $login_user['email']; 
                                      }
                                      else
                                      {
                                        
                                          $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                          if($totallength>10)
                                          {
                                              $set_user_name_mobile =  $login_user['first_name'];
                                          }else{
                                             $set_user_name_mobile =  $login_user['first_name'].' '.$login_user['last_name'];
                                          }
                                      }//else 
                              }// if role is admin

                              /*********************end of name in mobile view**************/

                            ?>
                          
                          <span class="mobileviewnond short-name"> <?php echo e($set_user_name_mobile); ?></span>
                        </a>
                        <i class="fa fa-angle-down"></i>
                      <?php else: ?>
                         <a href="#" class="drpdown-sidenav leftavatr"><span class="avatar-head"><img src="<?php echo e(url('/')); ?>/assets/front/images/chow-user.svg" alt=""></span> Your Account</a><i class="fa fa-angle-down"></i>
                      <?php endif; ?>

                        <ul class="mobileul-head-mn blockclick">

                          <?php if($login_user == false): ?>

                            <li class="signin-header">
                                <a href="<?php echo e(url('/').'/login'); ?>" class="signinbtn">Sign In</a>
                             <div class="signuplogins">                             
                                Don't have an account? 
                                  <a href="<?php echo e(url('/').'/login'); ?>" >Register </a>
                               </div>

                            </li>
                          <?php else: ?>

                            <?php
                              $set_name ='';
                              if($login_user->inRole('buyer') == true)
                              {
                                  $url = url('/')."/buyer";
                                  if($login_user['first_name']=="" || $login_user['last_name']==""){
                                    $set_name ='New User';
                                  }else{
                                    $set_name = $login_user['first_name'].' '.$login_user['last_name']; 

                                  }

                              }
                              elseif ($login_user->inRole('seller') == true) {
                                  $url = url('/')."/seller";


                                  if(isset($seller_arr) && !empty($seller_arr)){
                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_name = $login_user['email']; 
                                      }else{
                                        $set_name = $login_user['first_name'].' '.$login_user['last_name']; 
                                      } 
                                  }
                              }//else if seller
                              elseif ($login_user->inRole('admin') == true) {
                                      $url = url('/');


                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_name = $login_user['email']; 
                                      }else{
                                        $set_name = $login_user['first_name'].' '.$login_user['last_name']; 
                                      } 
                              }//else if admin

                            ?>

                            <li class="signin-header">
                                <a href="<?php echo e($url); ?>/profile"><?php echo e(isset($set_name) ? $set_name : ''); ?></a>
                            </li>
                            <li><a href="<?php echo e($url); ?>/profile">My Profile </a></li>
                            <li><a href="<?php echo e($url); ?>/notifications">Notification</a></li>
                            <li><a href="<?php echo e(url('/logout')); ?>">Log Out</a></li>
                        <?php endif; ?>

                        </ul>
                    </div>

                      <?php if($login_user == false || $login_user->inRole('admin')): ?>
                    
                      <!-- <li class="mobileviewblock">
                         <a href="<?php echo e(url('/').'/signup_seller'); ?>" class="headermobilelink">Sell on Chow</a>
                      </li> -->
                     <?php endif; ?>
                     <div class="clearfix"></div>
                </div>

                  <ul class="min-menu">   
                    <li <?php  if(Request::segment(1) == ''){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>">Home</a>
                    </li>

                    <li  
                        <?php  
                        if(Request::segment(1) == 'search' && Request::get('filterby_price_drop')!==null){

                        }
                        elseif(Request::segment(1) == 'search' && Request::get('best_seller')!==null){
                          
                        }
                        elseif(Request::segment(1) == 'search' && Request::get('chows_choice')!==null){
                          
                        }
                        elseif(Request::segment(1) == 'search')
                        { echo 'class="active sub-menu"'; } 
                        ?> 
                        class="sub-menu"><a href="#" class="sp-category">Shop<i class="fa fa-angle-down"></i></a>
                      <ul class="su-menu" id="ul-su-menu"> 

                          <li><a href="<?php echo e(url('/')); ?>/search">Shop All</a></li> 

                          <li class="sub-menu-new"><a href="javascript:void(0);">Effects</a>
                             
                                <?php if(isset($effects_arr) && count($effects_arr)>0): ?>

                                    <ul class="inner-su-menu"> 

                                    <?php $__currentLoopData = $effects_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$effects): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                     $effect_name = '';
                                     $effect_name = str_replace(' ','_',$effects['title']);
                                    ?>

                                     <li><a href="<?php echo e(url('/')); ?>/search?reported_effects=<?php echo e($effect_name); ?>"><?php echo e($effects['title']); ?></a></li> 

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     
                                    </ul>
                                <?php else: ?>
                                 <ul class="inner-su-menu"> 
                                   <li><a href="#">No Records Found</a></li>
                                 </ul>    
                                <?php endif; ?>

                             
                            </li> 

                            <li class="sub-menu-new"><a href="javascript:void(0);">Category</a>
                             
                                <?php if(isset($category_arr) && count($category_arr)>0): ?>

                                    <ul class="inner-su-menu"> 

                                    <?php $__currentLoopData = $category_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                     $category_name = '';

                                     $category_name = str_replace(' ','-',str_replace('&','and',$category['product_type']));

                                    ?>

                                     <li><a href="<?php echo e(url('/')); ?>/search?category_id=<?php echo e($category_name); ?>"><?php echo e(isset($category['product_type']) ? $category['product_type'] : ''); ?></a></li> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>

                                <?php else: ?>
                                 <ul class="inner-su-menu"> 
                                   <li><a href="#">No Records Found</a></li>
                                 </ul> 

                                <?php endif; ?>
                                                     
                             
                            </li> 

                            <li class="sub-menu-new"><a href="javascript:void(0);">Spectrum</a>

                              
                                <?php if(isset($spectrum_arr) && count($spectrum_arr)>0): ?>

                                  <ul class="inner-su-menu"> 

                                    <?php $__currentLoopData = $spectrum_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$spectrum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                    $spectrum_name = '';
                                    $spectrum_name = str_replace(' ','-',$spectrum['name']);
                                    ?>

                                     <li><a href="<?php echo e(url('/')); ?>/search?spectrum=<?php echo e($spectrum_name); ?>"><?php echo e($spectrum['name']); ?></a></li> 

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                  </ul>
                                <?php else: ?>
                                 <ul class="inner-su-menu"> 
                                   <li><a href="#">No Records Found</a></li>
                                 </ul>   
               
                                <?php endif; ?>

                              
                            </li> 


                            <li class="sub-menu-new"><a href="javascript:void(0);">Cannabinoids</a>
   
                                <?php if(isset($cannabinoids_arr) && count($cannabinoids_arr)>0): ?>

                                  <ul class="inner-su-menu"> 

                                    <?php $__currentLoopData = $cannabinoids_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$cannabinoids): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                    $cannabinoid_name = '';
                                    $cannabinoid_name = str_replace(' ','-',$cannabinoids['name']);
                                    ?>

                                    <li><a href="<?php echo e(url('/')); ?>/search?cannabinoids=<?php echo e($cannabinoid_name); ?>"><?php echo e($cannabinoids['name']); ?></a></li> 

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                  </ul>
                                <?php else: ?>
                                 <ul class="inner-su-menu"> 
                                   <li><a href="#">No Records Found</a></li>
                                 </ul>   
               
                                <?php endif; ?>
     
                            </li> 


                            <li><a href="<?php echo e(url('/')); ?>/search?best_seller=true">Best Sellers</a>
                            </li>

                            <li class="sale-link"><a href="<?php echo e(url('/')); ?>/search?filterby_price_drop=true">SALE</a>
                            </li>

                      </ul>
                    </li>

                     
                     <li <?php  if(Request::segment(1) == 'search'  && Request::get('chows_choice')!==null){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/search?chows_choice=true">Chow's Choice</a></li>


                     <li class="sale-link" <?php  if(Request::segment(1) == 'filterby_price_drop'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/search?filterby_price_drop=true">SALE</a></li> 


                     <li <?php  if(Request::segment(1) == 'shopbrand'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/shopbrand">Brands</a></li> 

                    <?php if(isset($cms_arr) && !empty($cms_arr)): ?>
                       <?php $__currentLoopData = $cms_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php
                           
                          if($cms->page_slug == "cashback")
                          {
                           
                          $href = strip_tags($cms->page_desc);
                          $href = str_replace('&nbsp;', '', $href);
         
                          ?>
                            <li <?php  if(Request::segment(1) == $cms->page_slug){ echo 'class="active"'; } ?>>
                              <a href="<?php echo e(url('/')); ?>/cashback" target="_blank"><?php echo e($cms->page_title); ?></a>
                            </li>   
                          <?php
                          }
                          ?>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>  

                    <li <?php  if(Request::segment(1) == 'about-us'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/about-us">About Us</a></li> 



              <li class="hideondesks">
           
              <?php
                  $staticms = '';

                ?>

                <?php if(isset($cms_arr) && !empty($cms_arr)): ?>

                  <?php $__currentLoopData = $cms_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   
                      <?php

                      if($cms->page_slug=="buy-again")
                      {
                          $staticms = strip_tags($cms->page_desc);
                          $staticms = str_replace('&nbsp;', '', $staticms);
                          ?>

                            <?php if($login_user == false): ?>
                           
                              <a href="<?php echo e(url('/')); ?>/login/buy" target="_blank" ><?php echo e($cms->page_title); ?></a>

                            <?php else: ?>
                             
                                <a href="<?php echo e($staticms); ?>" target="_blank"><?php echo e($cms->page_title); ?></a> 
                            <?php endif; ?>
                          <?php

                      } 

                      ?>

                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php endif; ?>  


                </li>
                <li class="hideondesks">
                    <a href="<?php echo e(url('/')); ?>/buyer/my-favourite">Wishlist</a>
                </li> 
              </ul>


            <div class="clr"></div>
        </div>
        <div class="borderhere"></div>
        <div class="rightnavbar-home">
                <?php if($login_user == false): ?>
                   
                <?php endif; ?>

                <div class="dropdown-new hover-new linkhover mobileviewnone-dropdown">
                   
                      <?php if($login_user == true): ?>

                        <a href="javascript:void(0)" class="usershowmobile">
                           <?php 
                            

                              $set_user_name ='';

                             if($login_user->inRole('buyer') == true)
                              {
                                  $url = url('/')."/buyer";

                                  if($login_user['first_name']==" " || $login_user['last_name']==""){
                                    $set_user_name ='New User';
                                  }else{

                                        $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                        if($totallength>10)
                                        {
                                           $set_user_name =  $login_user['first_name'];
                                        }else{
                                           $set_user_name =  $login_user['first_name'].' '.$login_user['last_name'];
                                        }

                                  }

                              }// if role is buyer
                              elseif ($login_user->inRole('seller') == true) {
                                  $url = url('/')."/seller";


                                  if(isset($seller_arr) && !empty($seller_arr)){
                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_user_name = $login_user['email']; 
                                      }
                                      else
                                      {
                                        
                                          $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                          if($totallength>10)
                                          {
                                              $set_user_name =  $login_user['first_name'];
                                          }else{
                                             $set_user_name =  $login_user['first_name'].' '.$login_user['last_name'];
                                          }
                                      }//else 
                                  }// if isset seller array
                              }// if role is seller
                              if($login_user->inRole('admin') == true)
                              {
                                  $url = url('/');

                                  if($login_user['first_name']==" " || $login_user['last_name']==""){
                                    $set_user_name ='Admin';
                                  }else{

                                        $totallength = strlen($login_user['first_name'])+strlen($login_user['last_name']);

                                        if($totallength>10)
                                        {
                                           $set_user_name =  $login_user['first_name'];
                                        }else{
                                           $set_user_name =  $login_user['first_name'].' '.$login_user['last_name'];
                                        }

                                  }

                              }// if role is admin

                           ?>
                          
                           <span class="mobileviewnond short-name newhr"><span class="avatar-head"><img src="<?php echo e(url('/')); ?>/assets/front/images/chow-user.svg" alt=""></span> <div class="nameinlinecws"><?php echo e($set_user_name); ?></div></span>
                        </a>
                        <i class="fa fa-angle-down"></i>
                    <?php else: ?>
                        <a href="javascript:void(0)" class="usershowmobile leftavatr"><span class="mobileviewnond"><span class="avatar-head"><img src="<?php echo e(url('/')); ?>/assets/front/images/chow-user.svg" alt=""></span>Your Account</span></a><i class="fa fa-angle-down"></i>
                    <?php endif; ?>
                    
                    <ul>
                           <?php if($login_user == false): ?>

                            <li class="signin-header">
                                <a href="<?php echo e(url('/').'/login'); ?>">Sign In</a>                         
                            <div class="signuplogins donthave-acnt"><span></span><div class="donthvct">Don't have an account?</div>
                            <div class="byr-center-lnks">                           
                              <a href="<?php echo e(url('/').'/login'); ?>" class="widthauto">Register </a>
                              </div>
                            </div>                            
                            </li>
                        <?php else: ?>

                            <?php
                              $set_name = $url = '';
                              if($login_user->inRole('buyer') == true)
                              {
                                  $url = url('/')."/buyer";

                                  if($login_user['first_name']=="" || $login_user['last_name']==""){
                                    $set_name = 'New User';
                                  }else{
                                   $set_name = $login_user['first_name'].' '.$login_user['last_name']; 
                                  }


                              }
                              elseif ($login_user->inRole('seller') == true) {
                                  $url = url('/')."/seller";

                                  if(isset($seller_arr) && !empty($seller_arr)){
                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_name = $login_user['email']; 
                                      }else{
                                        $set_name = $login_user['first_name'].' '.$login_user['last_name']; 
                                      } 
                                  }
                              }
                               elseif ($login_user->inRole('admin') == true) {
                                        $url = url('/');

                                  
                                      if($login_user['first_name']=="" && $login_user['last_name']=="")
                                      {
                                        $set_name = $login_user['email']; 
                                      }else{
                                        $set_name = $login_user['first_name'].' '.$login_user['last_name']; 
                                      } 
                              }
                            ?>

                            <li class="signin-header">
                             
                                <?php if($login_user==true  && $login_user->inRole('admin') == true): ?>
                                <a href="#">
                                    <!-- <?php echo e(isset($set_name) ? $set_name : ''); ?> -->
                                    Account
                                 </a>  
                                <?php else: ?>
                                  <a href="<?php echo e($url); ?>/profile">
                                     <!-- <?php echo e(isset($set_name) ? $set_name : ''); ?> -->
                                     Account
                                  </a>
                                <?php endif; ?>

                            </li>
                            <?php if($login_user==true  && $login_user->inRole('admin') == true): ?>
                            <?php else: ?>
                            <li><a href="<?php echo e($url); ?>/profile">My Profile </a></li>
                            <li><a href="<?php echo e($url); ?>/notifications">Notification</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo e(url('/logout')); ?>">Log Out</a></li>
                        <?php endif; ?>

                        
                    </ul>
                </div>
                <div class="buy-again hidenmobile-link">
                
                <?php
                  $staticms = '';

                ?>

                <?php if(isset($cms_arr) && !empty($cms_arr)): ?>

                  <?php $__currentLoopData = $cms_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   
                      <?php

                      if($cms->page_slug=="buy-again")
                      {
                          $staticms = strip_tags($cms->page_desc);
                          $staticms = str_replace('&nbsp;', '', $staticms);
                          ?>

                            <?php if($login_user == false): ?>
                              <a href="<?php echo e(url('/')); ?>/login/buy" target="_blank" ><?php echo e($cms->page_title); ?></a>

                            <?php else: ?>
                                <a href="<?php echo e($staticms); ?>" target="_blank"><?php echo e($cms->page_title); ?></a> 
                            <?php endif; ?>
                          <?php

                      } 

                      ?>

                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php endif; ?>  


                <a href="<?php echo e(url('/')); ?>/buyer/my-favourite">Wishlist</a>
                
              </div>

        </div>
  <!-- new  mobile view code -->
       <div class="sidenav mobileviewmenu">
          <ul class="min-menu">

                  <li>
                    <li <?php  if(Request::segment(1) == ''){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>">Home</a></li>
                  </li>
            
                  <li class="sub-menu"><a href="#" class="sp-category">Shop<i class="fa fa-angle-down"></i></a>
                      <ul class="su-menu" id="ul-su-menu" > 

                          <li class="noclicks"><a href="<?php echo e(url('/')); ?>/search">Shop All</a></li> 

                          <li class="sub-menu-new"><a href="javascript:void(0);">Effects</a>
                             
                                <?php if(isset($effects_arr) && count($effects_arr)>0): ?>

                                    <ul class="inner-su-menu"> 

                                    <?php $__currentLoopData = $effects_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$effects): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                     $effect_name = '';
                                     $effect_name = str_replace(' ','_',$effects['title']);
                                    ?>

                                     <li><a href="<?php echo e(url('/')); ?>/search?reported_effects=<?php echo e($effect_name); ?>"><?php echo e($effects['title']); ?></a></li> 

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     
                                    </ul>
                                <?php else: ?>
                                 <ul class="inner-su-menu"> 
                                   <li><a href="#">No Records Found</a></li>
                                 </ul>    
                                <?php endif; ?>

                             
                            </li> 

                            <li class="sub-menu-new"><a href="javascript:void(0);">Category</a>
                             
                                <?php if(isset($category_arr) && count($category_arr)>0): ?>

                                    <ul class="inner-su-menu"> 

                                    <?php $__currentLoopData = $category_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                     $category_name = '';

                                     $category_name = str_replace(' ','-',str_replace('&','and',$category['product_type']));

                                    ?>

                                     <li><a href="<?php echo e(url('/')); ?>/search?category_id=<?php echo e($category_name); ?>"><?php echo e(isset($category['product_type']) ? $category['product_type'] : ''); ?></a></li> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>

                                <?php else: ?>
                                 <ul class="inner-su-menu"> 
                                   <li><a href="#">No Records Found</a></li>
                                 </ul> 

                                <?php endif; ?>
                                                     
                             
                            </li> 

                            <li class="sub-menu-new"><a href="javascript:void(0);">Spectrum</a>

                              
                                <?php if(isset($spectrum_arr) && count($spectrum_arr)>0): ?>

                                  <ul class="inner-su-menu"> 

                                    <?php $__currentLoopData = $spectrum_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$spectrum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                    $spectrum_name = '';
                                    $spectrum_name = str_replace(' ','-',$spectrum['name']);
                                    ?>

                                     <li><a href="<?php echo e(url('/')); ?>/search?spectrum=<?php echo e($spectrum_name); ?>"><?php echo e($spectrum['name']); ?></a></li> 

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                  </ul>
                                <?php else: ?>
                                 <ul class="inner-su-menu"> 
                                   <li><a href="#">No Records Found</a></li>
                                 </ul>   
               
                                <?php endif; ?>

                              
                            </li> 

                            <li class="sub-menu-new"><a href="javascript:void(0);">Cannabinoids</a>
   
                                <?php if(isset($cannabinoids_arr) && count($cannabinoids_arr)>0): ?>

                                  <ul class="inner-su-menu"> 

                                    <?php $__currentLoopData = $cannabinoids_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$cannabinoids): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                    $cannabinoid_name = '';
                                    $cannabinoid_name = str_replace(' ','-',$cannabinoids['name']);
                                    ?>

                                    <li><a href="<?php echo e(url('/')); ?>/search?cannabinoids=<?php echo e($cannabinoid_name); ?>"><?php echo e($cannabinoids['name']); ?></a></li> 

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                  </ul>
                                <?php else: ?>
                                 <ul class="inner-su-menu"> 
                                   <li><a href="#">No Records Found</a></li>
                                 </ul>   
               
                                <?php endif; ?>
     
                            </li> 


                            <li class="noclicks"><a href="<?php echo e(url('/')); ?>/search?best_seller=true">Best Sellers</a>
                            </li>

                            <li class="sale-link noclicks"><a href="<?php echo e(url('/')); ?>/search?filterby_price_drop=true">SALE</a>
                            </li>

                      </ul>
                    </li>


              <li <?php  if(Request::segment(1) == 'search'  && Request::get('chows_choice')!==null){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/search?chows_choice=true">Chow's Choice</a></li>


             <li class="sale-link" <?php  if(Request::segment(1) == 'filterby_price_drop'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/search?filterby_price_drop=true">SALE</a></li> 


             <li <?php  if(Request::segment(1) == 'shopbrand'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/shopbrand">Brands</a></li> 
           
               <?php if(isset($cms_arr) && !empty($cms_arr)): ?>
                  <?php $__currentLoopData = $cms_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                      <?php
                               
                          if($cms->page_slug == "cashback")
                          {
                               
                              $href = strip_tags($cms->page_desc);
                              $href = str_replace('&nbsp;', '', $href);
             
                              ?>
                                <li <?php  if(Request::segment(1) == $cms->page_slug){ echo 'class="active"'; } ?>>
                                  <a href="<?php echo e(url('/')); ?>/cashback" target="_blank"><?php echo e($cms->page_title); ?></a>
                                </li>   
                              <?php
                          }
                      ?>

                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?> 

                <li <?php  if(Request::segment(1) == 'about-us'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/about-us">About Us</a></li>

                <li <?php  if(Request::segment(1) == 'helpcenter'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/helpcenter">Help Center</a></li>

              </ul>
            </div>
         <div class="clearfix"></div>       
      </div>
  
     </div>
    </div>
    <div class="clr"></div>
    <div class="blackdiv-for-header <?php if(isset($arr_announcements) && count($arr_announcements)> 0): ?> remove-strip <?php endif; ?>"></div>
<!--Header section end here-->


<?php
  $stateofuser='';
  $statenameofuser='';
  $countryofuser='';
  $useris='guestuser';
  $login_user = Sentinel::check();  


 if(isset($login_user) && $login_user==true && $login_user->inRole('seller') == true) 
 {
  $useris ="seller";
 }
 else if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true) {
  $useris ="buyer";
  $countryofuser  = $login_user->country;
  $stateofuser  = $login_user->state;
  
 }
else if(isset($login_user) && $login_user==true && $login_user->inRole('admin') == true) {
  $useris ="admin";
  $countryofuser  = '';
  $stateofuser  ='';
  
 }else{
    $countryofuser  = '';
    $stateofuser  ='';
 }



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
  $state =  Request::input('state');
  $city =  Request::input('city');
  $chows_choice =  Request::input('chows_choice');
  $chowchoice_filt_stat =  isset($chows_choice)?$chows_choice:'false';

  $best_seller =  Request::input('best_seller');
  $best_seller_filt_stat =  isset($best_seller)?$best_seller:'false';
  $spectrum =  Request::input('spectrum');
  $statelaw =  Request::input('statelaw');
  $reported_effects = Request::input('reported_effects');
  $cannabinoids = Request::input('cannabinoids');

  $featured = Request::input('featured');

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
<input type="hidden" id="state" value="<?php echo e($state); ?>" />
<input type="hidden" id="city" value="<?php echo e($city); ?>" />
<input type="hidden" id="spectrum" value="<?php echo e(isset($spectrum) ? $spectrum : ''); ?>" />
<input type="hidden" id="statelaw" value="<?php echo e(isset($statelaw) ? $statelaw : ''); ?>" />

<input type="hidden" id="best_sellerval" value="<?php echo e($best_seller_filt_stat); ?>" />
<input type="hidden" id="chows_choiceval" value="<?php echo e($chowchoice_filt_stat); ?>" />


<input type="hidden" id="reported_effectsval" name="reported_effects" value="<?php echo e(isset($reported_effects)?$reported_effects:''); ?>" />
<input type="hidden" id="cannabinoidsval" name="cannabinoids" value="<?php echo e(isset($cannabinoids)?$cannabinoids:''); ?>" />

<input type="hidden" id="featured_option" name="featured_option" value="<?php echo e(isset($featured)?$featured:''); ?>" />


<div id="myiploadModal" class="modal fade modalauto">
    <div class="modal-dialog dialogauto">
        <div class="modal-content">          
            <div class="modal-body">
              <div class="logohead-cw">
                <?php
                 //image resize
                    $resize_check_img = image_resize('/assets/front/images/chow-check1.png',320,183);
                ?>
               

                <img  class="lozad" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e($resize_check_img); ?>"  alt="Chow420" />

              </div>
              <div class="subscribe-title">Automated Compliance</div>           
              <span id="showiperr"></span>
                 <form id="modalform"> 
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group form-box">
                        <div class="select-style">
                           <select class="frm-select countryList"  name="country" id="countryList" data-parsley-required="true" data-parsley-required-message="Please select country" >
                               <option value="">Select country</option>
                                                         
                           </select> 
                        </div>
                           <div class="clearfix"></div>
                    </div>
                    <div class="form-group form-box">
                        <div class="select-style">
                           <select name="state" id="stateList"  data-parsley-required="true" class="frm-select stateList blocknone" data-parsley-required-message="Please select state">
                             <option value="">Select state</option>
                                                         
                           </select> 
                        </div>
                           <div class="clearfix"></div>
                    </div>
                    <div class="text-center">
                   
                    <a href="#" class="btn-md btn-theme next-right btnsubscribe"  id="Continue" >Continue</a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>


<!-------------------start of change password-------------------------->



<div id="mypasswordModal" class="modal fade modalauto">
    <div class="modal-dialog dialogauto">
        <div class="modal-content">          
            <div class="modal-body userdetaild-modal">
              
              <div class="subscribe-title">Change Password</div>
              <span id="showiperr"></span>
                 <form id="frm-change-password"> 
                   <span id="status_msg"></span>
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group form-box">
                       
                            <input type="password" id="current_password" name="current_password" class="input-text" placeholder="Old Password" data-parsley-required="true" data-parsley-required-message="Enter current password"
                                    data-parsley-remote="<?php echo e(url('/does_old_password_exist')); ?>"
                               data-parsley-remote-options='{ "type": "POST", "dataType": "jsonp", "data": { "_token": "<?php echo e(csrf_token()); ?>" } }'
                            data-parsley-remote-message="Please enter valid old password">
                        
                           <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group form-box">
                        
                          <input type="password" id="new_password" name="new_password" class="input-text" placeholder="New Password" data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-required-message="Enter new password" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}"  data-parsley-pattern-message="Password field must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters" data-parsley-minlength="8">
                       
                           <div class="clearfix"></div>
                     </div>
                     <div class="clearfix"></div>



                      <div class="form-group form-box">
                        
                          <input type="password" name="cnfm_new_password" id="cnfm_new_password" class="input-text" placeholder="Confirm Password" data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-required-message="Enter confirm password"  data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters" data-parsley-minlength="8" data-parsley-equalto="#new_password" data-parsley-equalto-message="Confirm password should be match with new password">
                       
                           <div class="clearfix"></div>
                     </div>
                     <div class="clearfix"></div>

                        
                    <div class="text-center">
                    <a href="#" class="btn-md btn-theme next-right btnsubscribe"  id="btn-change-password" >Change Password</a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>



<!------------------end of change password----------------------------------->

<?php 
 $showmodal = $showpasswordmodal = 0;
 if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true) 
 { 

      $is_checkout_signup = $login_user->is_checkout_signup;
      $is_guest_user = $login_user->is_guest_user;
      $show_passwordmodal_afterlogin = $login_user->show_passwordmodal_afterlogin;
      $is_password_changed = $login_user->is_password_changed;

      if(isset($is_checkout_signup) && $is_checkout_signup==1 && isset($is_guest_user) && $is_guest_user==1 && isset($show_passwordmodal_afterlogin) && $show_passwordmodal_afterlogin==1 && isset($is_password_changed) && $is_password_changed==0)
      {
        $showpasswordmodal = 1;
      }else
      {
         $showpasswordmodal = 0;
      }


 } //if isset login user
?>



<!----SCRIPT STARTS FROM HERE------------------->
<script >

var useris = "<?php echo e($useris); ?>";
var stateofuser = "<?php echo e($stateofuser); ?>";
var countryofuser = "<?php echo e($countryofuser); ?>";
var state = "<?php echo e($state); ?>";


$(document).ready(function() {

    shopByCategory(state);
    getShopBySpectrum();
    var showmodal = "<?php echo e(isset($showmodal) ? $showmodal : ''); ?>";
    var showpasswordmodal = "<?php echo e(isset($showpasswordmodal) ? $showpasswordmodal : ''); ?>";


    $.ajax({
        url: SITE_URL + '/checkipaddress',
        type: "GET",
        async: false,
        dataType: 'json',
        success: function(response) {
            if (typeof response == 'object') {
                if (response.status && response.status == "SUCCESS") {

                } else if (response.status == "ERROR") {


                    if (useris == "guestuser") {

                        getCountrymodal();
                        $("#stateList").show();
                        // $("#myiploadModal").modal('show');
                        // google_location();
                    }

                } //else if error
            } // if type object

        }
    });

    //checkipaddress(); 
}); //document ready function


//function get country and state of user through google api
function google_location() {
    $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?').done(function(location) {

        var country = location.country_name;
        var state = location.state;

        if (country && state) {

            //function to get country id
            $.ajax({
                url: SITE_URL + '/getCountryId/',
                data: {
                    'country': country
                },
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success: function(response) {
                    hideProcessingOverlay();
                    if (typeof(response) == 'object') {
                        if (response.status == 'SUCCESS') {

                            $('#countryList option[value=' + response.arr_country.id + ']').attr('selected', 'selected');

                            //function to get all states
                            $.ajax({
                                url: SITE_URL + '/get_statesmodal/' + response.arr_country.id,
                                method: 'GET',
                                dataType: 'json',
                                beforeSend: function() {
                                    showProcessingOverlay();
                                },
                                success: function(response) {
                                    hideProcessingOverlay();
                                    if (typeof(response) == 'object') {

                                        if (response.status == 'SUCCESS') {
                                            var option = '<option value="">Please Select States</option>';

                                            $(response.states_arr).each(function(index, state) {

                                                option += '<option value="' + state.id + '">' +
                                                    state.name + '</option>';
                                            });

                                            $(".stateList").html(option);
                                            $("#stateList").show();

                                            // function to get state id
                                            $.ajax({
                                                url: SITE_URL + '/getStateId/',
                                                data: {
                                                    'state': state
                                                },
                                                type: "GET",
                                                dataType: 'json',
                                                success: function(response) {

                                                    if (typeof(response) == 'object') {
                                                        if (response.status == 'SUCCESS') {

                                                            $('#stateList option[value=' + response.arr_state.id + ']').attr('selected', 'selected');
                                                        } else {
                                                            //$("#stateList").html('<option>Select Country</option>');
                                                        }
                                                    }
                                                }
                                            });
                                        } //if success
                                        else {
                                            $("#stateList").html('<option>States Not Found</option>');
                                        }
                                    }

                                }
                            });

                        } else {
                            //$("#countryList").html('<option>Select Country</option>');
                        }
                    } //if
                }
            });

        } //if country & state

    });
} //function google_location


//funciton for country modal
function getCountrymodal() {

    var statename = '';

    $.ajax({
        url: SITE_URL + '/getCountrymodal',
        type: "GET",
        async: false,
        success: function(response) {

            var query = '';
            // $("#category_list").empty();  
            if (response.arr_country != undefined && response.arr_country.length > 0) {
                $(response.arr_country).each((index, value) => {
                    $("#countryList").append("<option value='" + value.id + "'>" + value.name + "</option>");
                });
            }
        }
    });

} //country function

// function for get states of country
function getStatesmodal(countryofuser) {
    var statename = '';
    $.ajax({
        url: SITE_URL + '/get_statesmodal/' + countryofuser,
        type: "GET",
        dataType: 'json',
        success: function(response) {

            if (typeof(response) == 'object') {
                if (response.status == 'SUCCESS') {
                    var option = '<option value="">Please Select States</option>';

                    $(response.states_arr).each(function(index, state) {

                        option += '<option value="' + state.id + '">' +
                            state.name + '</option>';
                    });

                    $(".stateList").html(option);
                    if (useris == "buyer") {
                        $("#stateList").val(stateofuser);
                        $("#stateList").show();
                    }

                } else {
                    $(".stateList").html('<option>States Not Found</option>');
                }
            }
        }
    });

} //state function to get states of country

//function for get country list
$(".countryList").change(function() {

    var country = $(this).val();

    $.ajax({
        url: SITE_URL + '/get_statesmodal/' + country,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (typeof(response) == 'object') {

                if (response.status == 'SUCCESS') {
                    var option = '<option value="">Please Select States</option>';

                    $(response.states_arr).each(function(index, state) {

                        option += '<option value="' + state.id + '">' +
                            state.name + '</option>';
                    });

                    $(".stateList").html(option);
                    $("#stateList").show();
                } else {
                    $(".stateList").html('<option>States Not Found</option>');
                }
            }

        }
    });
}); //end of country function


//start function for change password
$('#btn-change-password').click(function() {

    if ($('#frm-change-password').parsley().validate() == false) return;

    $.ajax({
        url: SITE_URL + '/buyer/update_password',
        data: new FormData($('#frm-change-password')[0]),
        method: 'POST',
        contentType: false,
        processData: false,
        cache: false,
        dataType: 'json',
        beforeSend: function() {
            showProcessingOverlay();
            $('#btn-change-password').prop('disabled', true);
            $('#btn-change-password').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success: function(response) {

            hideProcessingOverlay();
            $('#btn-change-password').prop('disabled', false);
            $('#btn-change-password').html('SAVE');

            if (typeof response == 'object') {
                if (response.status && response.status == "SUCCESS") {
                    var success_HTML = '';
                    success_HTML += '<div class="alertm alert-dismissible">' + response.message + '</div>';

                    $('#status_msg').html(response.message);
                    $('#status_msg').css('color', 'green');
                    window.location.reload();
                } else {
                    var error_HTML = '';
                    error_HTML += '<div class="alert-d alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>' + response.message + '</div>';

                    $('#status_msg').html(response.message);
                    $('#status_msg').css('color', 'red');
                }
            }
        }
    });
});



//function for header search autocomplete list
function searchAutocomplete() {
    var search_item = $("#product_search").val();
    var link = '';
    var rating = $("#rating").val();
    var price = $("#price").val();
    var age_restrictions = $("#age_restrictions").val();
    var category = $("#category").val();
    var brands = $("#brands").val();
    var brand = $("#brand").val();
    var sellers = $("#sellers").val();
    var mg = $("#mg").val();

    if ($('#filterby_price_drop').is(":checked")) {
        var filterby_price_drop = true;
    } else {
        var filterby_price_drop = false;
    }
    var state = $("#state").val();
    var city = $("#city").val();

    var spectrum = $("#spectrum").val();
    var statelaw = $("#statelaw").val();

    if ($('#best_seller').is(":checked")) {
        var best_seller = true;
    } else {
        var best_seller = false;
    }

    if ($('#chows_choice').is(":checked")) {
        var chows_choice = true;
    } else {
        var chows_choice = false;
    }
    var reported_effects = $("#reported_effects").val();
    var cannabinoids = $("#cannabinoids").val();

    var featured_option = $("#featured_option").val();


    if (search_item != '') {
        var _token = "<?php echo e(csrf_token()); ?>";

        $.ajax({
            url: SITE_URL + '/get_suggestion_list',
            type: "GET",
            data: {
                search_item: search_item,
                _token: _token,
                sellers: sellers,
                rating: rating,
                category_id: category,
                age_restrictions: age_restrictions,
                price: price,
                mg: mg,
                filterby_price_drop: filterby_price_drop,
                state: state,
                city: city,
                chows_choice: chows_choice,
                best_seller: best_seller,
                brands: brands,
                brand: brand,
                statelaw: statelaw,
                reported_effects: reported_effects,
                cannabinoids: cannabinoids,
                featured: featured_option
            },
            dataType: 'json',
            success: function(data) {

                $('#productList').fadeIn();
                $('#productList').html(data);
            }

        });

    } else {

        $('#productList').fadeOut();
    }

} //state function to get states of country



$(document).on('click', '.liclick', function() {
    var id = $(this).attr('id');
    var title = $(this).attr('title');
    $('#productList').fadeOut();
    $("#branderr").html('');
});

//new function added for autosuggest of brand list
$(document).on('mouseleave', '#productList', function() {
    $('#productList').fadeOut();
});


var main = function() {
    $('.notification .showreferaldropdown').click(function() {
        $('.notification-menu').toggle();
    });

};

$(document).ready(main);


//datalayer push for google tag manager
var dataLayer = dataLayer || [];
dataLayer.push({
    'registrationCountry': 'United States'
});


</script>  

<!----SCRIPTS END HERE--------------------------->

<!-----COMMENTED CODE-STARTS----------------------->


  

    

   


 <!-- <div class="headersocailsknls">
  <ul>
    <li><a href="<?php echo e(isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:''); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
    <li class="borderleftrights"><a href="<?php echo e(isset($site_setting_arr['twitter_url'])?$site_setting_arr['twitter_url']:''); ?>"><i class="fa fa-twitter"></i></a></li>
    <li><a href="<?php echo e(isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:''); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
  </ul>
 </div> -->


<!-- Google Tag Manager (noscript) -->

<!-- End Google Tag Manager (noscript) -->


 <!-- old  mobile view code -->

   <!--<div class="sidenav mobileviewmenu">
          <ul class="min-menu">
            <li>
               <li <?php  if(Request::segment(1) == ''){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>">Home</a></li>
            </li>
            <li <?php  
                        if(Request::segment(1) == 'search' && Request::get('filterby_price_drop')!==null){

                        }
                        elseif(Request::segment(1) == 'search' && Request::get('best_seller')!==null){
                          
                        }
                        elseif(Request::segment(1) == 'search' && Request::get('chows_choice')!==null){
                          
                        }
                        elseif(Request::segment(1) == 'search')
                        { echo 'class="active"'; } 
                        ?>>
                         <a href="<?php echo e(url('/').'/search'); ?>">Shop</a>
            </li>

            <li class="sub-menu"><a href="#" class="sp-category">Shop by Category<i class="fa fa-angle-down"></i></a>
                <ul class="su-menu" id="category_list2">                       
                </ul>
            </li>

            <li class="sub-menu"><a href="#" class="sp-category">Shop by Spectrum<i class="fa fa-angle-down"></i></a>
                <ul class="su-menu" id="spectrum_list2">                       
                </ul>
            </li>

            <li <?php  if(Request::segment(1) == 'search'  && Request::get('best_seller')!== null){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/search?best_seller=true">Best Sellers</a></li>

            <li <?php  if(Request::segment(1) == 'search'  && Request::get('filterby_price_drop')!==null){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/search?filterby_price_drop=true">Today's Deals</a></li>
             <li <?php  if(Request::segment(1) == 'search'  && Request::get('chows_choice')!==null){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/search?chows_choice=true">Chow's Choice</a></li>

             
            <li <?php  if(Request::segment(1) == 'shopbrand'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/shopbrand">Shop by Brand</a></li> 

            <li <?php  if(Request::segment(1) == 'chowwatch'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/chowwatch">Chow Watch</a>
            </li>


           <?php if(isset($cms_arr) && !empty($cms_arr)): ?>
              <?php $__currentLoopData = $cms_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                    if($cms->page_slug=="services") {
                  ?>
                    <li <?php  if(Request::segment(1) == $cms->page_slug){ echo 'class="active"'; } ?>>
                      <a href="<?php echo e(url('/')); ?>/<?php echo e($cms->page_slug); ?>"><?php echo e($cms->page_title); ?></a>
                    </li>   
                  <?php
                    }

                 if($cms->page_slug=="chow-mission") {
                  ?>
                    <li <?php  if(Request::segment(1) == $cms->page_slug){ echo 'class="active"'; } ?>>
                      <a href="<?php echo e(strip_tags($cms->page_desc)); ?>" target="_blank"><?php echo e($cms->page_title); ?></a>
                    </li>   
                  <?php
                 } 
                   $staticms = '';
                  if($cms->page_slug=="chowcms") {
                    
                     $staticms = strip_tags($cms->page_desc);
                     $staticms = str_replace('&nbsp;', '', $staticms);
                     // dd($staticms);
                  ?>
                    <li <?php  if(Request::segment(1) == $cms->page_slug){ echo 'class="active"'; } ?>>
                      <a href="<?php echo e($staticms); ?>" target="_blank"><?php echo e($cms->page_title); ?></a>
                    </li>   
                  <?php

                 } 


                 $staticms = '';
                  if($cms->page_slug=="buy-again") {
                    
                     $staticms = strip_tags($cms->page_desc);
                     $staticms = str_replace('&nbsp;', '', $staticms);
                     // dd($staticms);
                  ?>

                    <?php if($login_user == false): ?>
                       <li <?php  if(Request::segment(1) == $cms->page_slug){ echo 'class="active"'; } ?>>
                          <a href="<?php echo e(url('/')); ?>/login/buy" target="_blank"><?php echo e($cms->page_title); ?></a>
                       </li>   
                    <?php else: ?>
                       <li <?php  if(Request::segment(1) == $cms->page_slug){ echo 'class="active"'; } ?>>
                         <a href="<?php echo e($staticms); ?>" target="_blank"><?php echo e($cms->page_title); ?></a>
                        </li>   
                    <?php endif; ?>
                  <?php

                 } 


                 
                 if($cms->page_slug=="forum") {
                  ?>
                    <li <?php  if(Request::segment(1) == $cms->page_slug){ echo 'class="active"'; } ?>>
                      <a href="<?php echo e(url('/')); ?>/<?php echo e(strip_tags($cms->page_slug)); ?>"><?php echo e($cms->page_title); ?></a>
                    </li>   
                  <?php
                 } 
              
                  ?>                  
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?> 

         
          </ul>
        </div> -->


        


   <!-- 
   <li <?php  if(Request::segment(1) == 'shopbrand'){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/shopbrand">Brand</a></li> 


     <li <?php  if(Request::segment(1) == 'search'  && Request::get('chows_choice')!==null){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/search?chows_choice=true">Chow's Choice</a></li>


    <li <?php  if(Request::segment(1) == 'about-us'  && Request::get('about-us')!==null){ echo 'class="active"'; } ?>><a href="<?php echo e(url('/')); ?>/about-us">About Us</a></li> -->


     
  

 

                           

 <?php

  //  $price =''; $prd_name='';$sellername='';
  // if(isset($get_aggregaterating) && !empty($get_aggregaterating))
  // {
  //   $average = isset($get_aggregaterating['Average'])?$get_aggregaterating['Average']:'';
  //   $reviewcount = isset($get_aggregaterating['Reviewcount'])?$get_aggregaterating['Reviewcount']:'';
  //   $productarr = isset($get_aggregaterating['Productarr'])?$get_aggregaterating['Productarr']:[];
  //   if(isset($productarr) && !empty($productarr))
  //   {
  //     $prd_name = isset($productarr['product_details']['product_name'])?$productarr['product_details']['product_name']:'';
  //     $pdescription = isset($productarr['product_details']['description'])?$productarr['product_details']['description']:'';
  //     $unit_price = isset($productarr['product_details']['unit_price'])?$productarr['product_details']['unit_price']:'';
  //     $price_drop_to = isset($productarr['product_details']['price_drop_to'])?$productarr['product_details']['price_drop_to']:'';
  //     if(isset($price_drop_to) && $price_drop_to>0){
  //       $price = $price_drop_to;
  //     }
  //     else{
  //       $price = $unit_price;
  //     }


  //     $brandname ='';
  //     if(isset($productarr['product_details']['get_brand_detail']) && !empty($productarr['product_details']['get_brand_detail']))
  //     {
  //        $brandname = $productarr['product_details']['get_brand_detail']['name']; 
  //     }else{
  //        $brandname ='';
  //     }

  //     if (isset($productarr['product_details']['sku']) && !empty($productarr['product_details']['sku'])) {
  //       $sku = $productarr['product_details']['sku'];
  //     }
  //     else {

  //       $sku = '';
  //     }

  //      $sellername ='Chow420';
  //     if(isset($productarr['user_details']) && !empty($productarr['user_details']))
  //     {
  //        $fname = isset($productarr['user_details']['first_name'])?$productarr['user_details']['first_name']:''; 
  //        $lname = isset($productarr['user_details']['last_name'])?$productarr['user_details']['last_name']:''; 

  //        if(isset($fname) || isset($lname))
  //        {
  //         $sellername = $fname.' '.$lname;
  //        }
  //        else
  //        {
  //         $sellername = isset($productarr['user_details']['email'])?$productarr['user_details']['email']:''; 
  //        }

  //     }else{
  //        $sellername ='Chow420';
  //     }//else

  //   }//isset product arr

  // }//isset aggregate rating

 ?>                          