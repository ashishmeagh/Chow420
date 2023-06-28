
<!DOCTYPE html>
<html lang="en"> 
@php
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
    $page_title        = "Is Cbd Legal";
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
 $seller_param =  app('request')->input('sellers'); 
 //dd($arr_seller_banner);
 $desc_privacy_policy = $desc_terms_conditions = $dec_signup_seller = $desc_login = "";

@endphp
<head>




@if(isset($currenturl) && !empty($currenturl))

  @php 
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


  @endphp


    @if(isset($mg) && !empty($mg) && isset($category_id) && !empty($category_id) && isset($price) && !empty($price) )
    <link rel="canonical" href="{{ url('/') }}/search?category_id={{ $category_id }}" /> 

    @elseif(isset($category_id) && !empty($category_id) && isset($price) && !empty($price) )
    <link rel="canonical" href="{{ url('/') }}/search?category_id={{ $category_id }}" /> 

    @elseif(isset($brands) && !empty($brands) && isset($price) && !empty($price) )
    <link rel="canonical" href="{{ url('/') }}/search?brands={{ $brands }}" />

    @elseif(isset($brands) && !empty($brands) && isset($category_id) && !empty($category_id) )
    <link rel="canonical" href="{{ url('/') }}/search?brands={{$brands}}&category_id={{ $category_id }}" />

     @elseif(isset($category_id) && !empty($category_id))
      @php 
          $cats_id='';
          $check_is_category_exists = check_is_category_exists($category_id);          
          if(isset($check_is_category_exists) && !empty($check_is_category_exists)){

            $cats_id = base64_encode($check_is_category_exists['id']);
      @endphp
           <link rel="canonical" href="{{ url('/') }}/search?category_id={{ $cats_id }}" /> 
      @php 
          }else{
      @endphp
       <link rel="canonical" href="{{ url('/') }}/search" /> 
      @php 
         }
      @endphp  

    @elseif(isset($price) && !empty($price))
    <link rel="canonical" href="{{ url('/') }}/search" />
     @elseif(isset($rating) && !empty($rating))
    <link rel="canonical" href="{{ url('/') }}/search" />
     @elseif(isset($mg) && !empty($mg))
    <link rel="canonical" href="{{ url('/') }}/search" />
     @elseif(isset($chows_choice) && !empty($chows_choice))
    <link rel="canonical" href="{{ url('/') }}/search" />
     @elseif(isset($filterby_price_drop) && !empty($filterby_price_drop))
    <link rel="canonical" href="{{ url('/') }}/search" />
     @elseif(isset($age_restrictions)  && !empty($age_restrictions))
    <link rel="canonical" href="{{ url('/') }}/search" />
    @elseif(isset($best_seller) && !empty($best_seller))
    <link rel="canonical" href="{{ url('/') }}/search" />    
    @else

      @php
          if( $controller_name=="search" && $method_name=="product_detail" )
          {      
                
            if(isset($arr_product['id']) && !empty($arr_product['id']) && isset($arr_product['product_name']) && !empty($arr_product['product_name']))
             {  
              
               $product_url = url('/')."/search/product_detail/".base64_encode($arr_product['id'])."/".str_slug($arr_product['product_name']);
             @endphp
               <link rel="canonical" href="{{ $product_url or ''}}" />
             @php  
             }
          }else{
      @endphp
       <link rel="canonical" href="{{ Request::fullUrl()}}" />
       @php } @endphp
    @endif


@endif








 <script>
 var dataLayer = dataLayer || [];
 dataLayer.push({
 'registrationCountry': 'United States'
 });
 </script>  


<!---Google analytics-header------>
@php
if(isset($site_setting_arr['pixelcode']) && !empty($site_setting_arr['pixelcode'])) {
  echo $site_setting_arr['pixelcode'];
}
@endphp
  
<!-- Google Tag Manager -->
{{-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KQJTL5N');</script> --}}
<!-- End Google Tag Manager -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      @php 
        if(isset($controller_name) && !empty($controller_name)){
       @endphp 
          @if($controller_name=="chowwatch")
            <meta name="title" content="Chow Watch | the compliant way to buy hemp-derived products" />
         
           @elseif($controller_name=="search" && Request::get('filterby_price_drop')==null)
            <meta name="title" content="Product | the compliant way to buy hemp-derived products" />

           @elseif($controller_name=="search" && Request::get('filterby_price_drop')!==null)
            <meta name="title" content="Product | the compliant way to buy hemp-derived products" />
           
          @elseif($controller_name=="forum")
             <meta name="title" content="Forum | the compliant way to buy hemp-derived products" />

          @elseif($controller_name=="signup_seller")
            {{--  <meta name="title" content="Sell your products on one of the best marketplaces for CBD" />  --}}
             <meta name="title" content="Partner with Chow" /> 
             

          @elseif($controller_name=="signup")
             <meta name="title" content="Start buying the best hemp CBD derived products right here" />  
             
          @elseif($controller_name=="login")
             <meta name="title" content="Sign in to your account and start buying and selling products" />      

            @else
             <meta name="title" content="{{ $meta_title or ''}}" />
          @endif

       @php
        }else{
       @endphp
        <meta name="title" content="Chow420 | {{ $meta_title or ''}}" />
       @php
          }
       @endphp 
{{--   <meta name="title" content="{{ $meta_title or ''}}" />
 --}}

    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <link rel="manifest" href="{{url('/')}}/manifest.json">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
{{--     <meta property="og:url" content="{{ url('/') }}">
 --}}   
  <meta property="fb:app_id" content="537697573532220" />
  {{--   <meta property="og:title" content='{{ ucfirst($meta_title) or "" }} - {{ $meta_project_name or "" }}'> --}}

       @php 
       $currenturl_path = Request::url();

        if(isset($controller_name) && !empty($controller_name)){
       @endphp 
            @if($controller_name=="chowwatch")
              @php
              $defaultchow =''; $defaultimage='';
              if(isset($news_arr) && !empty($news_arr)){
                  $defaultchow = isset($news_arr[0]['title'])?$news_arr[0]['title']:'';
                  $defaultimage = isset($news_arr[0]['image'])?$news_arr[0]['image']:'';
              }

              @endphp
              <meta property="og:url" content="{{ url('/') }}/chowwatch">
              <meta property="og:title" content='Chow Watch | the compliant way to buy hemp-derived products'>
            {{--  <meta property="og:title" content='Chow Watch | {{ ucfirst($defaultchow) }}'> --}}
            {{--   <meta property="og:description" content="{{ isset($news_arr[0]['subtitle'])? $news_arr[0]['subtitle']:'Chow Watch' }}">    --}}
             <meta property="og:description" content="Share your CBD story and experience with the world. Get featured on Chow watch and all our social channels. Your story deserves to be heard by the world.">

               <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg"> 
            @elseif($controller_name=="shopbrand")  
                @php
                $defaultchow =''; $defaultimage='';
                if(isset($arr_featured_brands) && !empty($arr_featured_brands)){
                    $defaultchow = isset($arr_featured_brands[0]['name'])?$arr_featured_brands[0]['name']:'';
                    $defaultimage = isset($arr_featured_brands[0]['image'])?$arr_featured_brands[0]['image']:'';
                }

              @endphp
               <meta property="og:url" content="{{ url('/') }}/shopbrand">
             {{--  <meta property="og:title" content='Shop By Brand | {{ $defaultchow }}'> --}}
              <meta property="og:title" content='Shop By Brand | the compliant way to buy hemp-derived products'> 
               <meta property="og:description" content="Chow420.com, Welcome to the marketplace for hemp-derived products, built to automate compliance for customers and brands. Choose your brand's products right here."> 
             {{--   @if(file_exists(base_path().'/uploads/brands/'.$arr_featured_brands[0]['image']) && isset($arr_featured_brands[0]['image']))  
                <meta property="og:image" content="{{url('/')}}/uploads/brands/{{$arr_featured_brands[0]['image'] }}">
               @else  --}}
                    <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">
              {{--  @endif --}}

            @elseif($controller_name=="shopdispensary")  
                @php
                $defaultchow =''; $defaultimage='';
                if(isset($arr_featuredseller) && !empty($arr_featuredseller)){
                    $defaultchow = isset($arr_featuredseller[0]['seller_detail']['business_name'])?$arr_featuredseller[0]['seller_detail']['business_name']:'';
                }

              @endphp
               <meta property="og:url" content="{{ url('/') }}/shopdispensary">
              {{--  <meta property="og:title" content='Shop By Dispensary | {{ $defaultchow }}'> --}}
              <meta property="og:title" content='Shop By Dispensary | the compliant way to buy hemp-derived products'>
               <meta property="og:description" content="Welcome to the marketplace for hemp-derived products, built to automate compliance for customers and dispensaries. Get the best of the products from your dispensary."> 
            
               <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">

            @elseif($controller_name=="forum")  
                @php
                $defaultchow =''; $defaultimage='';$defaultchowdesc='';
                $postedby ='';
                if(isset($forum_posts) && !empty($forum_posts)){
                    $defaultchow = isset($forum_posts[0]['title'])?$forum_posts[0]['title']:'Chow420';
                    $defaultchowdesc = isset($forum_posts[0]['description'])?$forum_posts[0]['description']:'Chow420';
                    if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                      $defaultchowdesc = strip_tags(substr($defaultchowdesc,0,165));
                    }

                    else if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)<=150)
                    {
                      $defaultchowdesc = strip_tags($defaultchowdesc);
                    }

                    $defaultimage = isset($forum_posts[0]['image'])?$forum_posts[0]['image']:'';


                    if(isset($forum_posts[0]['user_details']['first_name']) || isset($forum_posts[0]['user_details']['last_name'])){
                        $postedby = $forum_posts[0]['user_details']['first_name'].' '.$forum_posts[0]['user_details']['last_name'];
                      }
                    else{
                        $postedby = isset($forum_posts[0]['user_details']['email'])?$forum_posts[0]['user_details']['email']:'';
                    }
                  
                }//if isset forum post

              @endphp
               <meta property="og:url" content="{{ url('/') }}/forum">
             {{--  <meta property="og:title" content='Forum | {{ ucfirst($defaultchow) }} - {{ $postedby }} '> --}}
              <meta property="og:title" content='Forum | the compliant way to buy hemp-derived products'>
               <meta property="og:description" content="{{ $defaultchowdesc or '' }}">
               <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">


            @elseif($controller_name=="search" && Request::get('filterby_price_drop')!==null) 
              @php 
                  $defaultchow =''; $defaultimage='';$defaultchowdesc='';
                  if(isset($arr_data) && !empty($arr_data))
                   {
                     $defaultchow = isset($arr_data[0]['product_name'])?$arr_data[0]['product_name']:'Chow420';
                     $defaultchowdesc = isset($arr_data[0]['description'])?$arr_data[0]['description']:'Chow420';
                     if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                       $defaultchowdesc =  substr(strip_tags($defaultchowdesc),0,165);
                    }

                    else if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)<=150)
                    {
                      $defaultchowdesc = strip_tags($defaultchowdesc);
                    }
                  
                   } 
              @endphp

                  <meta property="og:url" content="{{ url('/') }}/search?filterby_price_drop=true">
                {{--   <meta property="og:title" content='Todays Deals | {{ ucfirst($defaultchow) }}'> --}}
                  <meta property="og:title" content='Todays Deals | the compliant way to buy hemp-derived products'>
                 
                  <meta property="og:description" 
                  content="@php echo str_replace('"','\'',$defaultchowdesc) @endphp">
                   {{-- @if(!empty($arr_data[0]['product_images_details'][0]['image']) && file_exists(base_path().'/uploads/product_images/'.$arr_data[0]['product_images_details'][0]['image'])))
                     <meta property="og:image" content="{{url('/')}}/uploads/product_images/thumb/{{$arr_data[0]['product_images_details'][0]['image'] }}"> 
                    @else  --}}
                    <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">
                  {{--  @endif --}}



            @elseif($controller_name=="search" && Request::get('chows_choice')!==null) 
              @php 
                  $defaultchow =''; $defaultimage='';$defaultchowdesc='';
                  if(isset($arr_data) && !empty($arr_data))
                   {
                     $defaultchow = isset($arr_data[0]['product_name'])?$arr_data[0]['product_name']:'Chow420';
                     $defaultchowdesc = isset($arr_data[0]['description'])?$arr_data[0]['description']:'Chow420';
                    if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                      $defaultchowdesc = strip_tags(substr($defaultchowdesc,0,165));
                    }

                    else if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)<=150)
                    {
                      $defaultchowdesc = strip_tags($defaultchowdesc);
                    }

                  
                   } 
              @endphp

                  <meta property="og:url" content="{{ url('/') }}/search?chows_choice=true">
                  {{--<meta property="og:title" content='Chows choice | {{ ucfirst($defaultchow) }}'> --}}
                  <meta property="og:title" content='Chows choice | the compliant way to buy hemp-derived products'>
                  <meta property="og:description" 
                  content="@php echo str_replace('"','\'',$defaultchowdesc) @endphp">
                  <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">
                 


             @elseif($controller_name=="search" && Request::get('age_restrictions')!==null) 
              @php 
                  $defaultchow =''; $defaultimage='';$defaultchowdesc='';$setage='';
                  if(isset($arr_data) && !empty($arr_data))
                   {
                     $defaultchow = isset($arr_data[0]['product_name'])?$arr_data[0]['product_name']:'Chow420';
                    $defaultchowdesc = isset($arr_data[0]['description'])?$arr_data[0]['description']:'Chow420';
                    if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                      $defaultchowdesc = strip_tags(html_entity_decode(substr($defaultchowdesc,0,165)));
                      $defaultchowdesc = str_replace("&nbsp"," ", $defaultchowdesc);
                      $defaultchowdesc = str_replace("&rsquo"," ", $defaultchowdesc);
                    }

                    else if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)<=150)
                    {
                      $defaultchowdesc = strip_tags(html_entity_decode($defaultchowdesc));
                    }

                     $ageid = base64_decode(Request::get('age_restrictions'));
                     if($ageid=='1')
                      $setage = 'Over 18';
                     elseif($ageid=='2')
                      $setage = 'Over 21';
                   } 
              @endphp
                  <meta property="og:title" content='Product | {{ $setage }} | {{ ucfirst($defaultchow) }}'>
                  <meta property="og:description" 
                  content="@php echo str_replace('"','\'',$defaultchowdesc) @endphp">
                 {{--  @if(!empty($arr_data[0]['product_images_details'][0]['image']) && file_exists(base_path().'/uploads/product_images/'.$arr_data[0]['product_images_details'][0]['image'])))
                   <meta property="og:image" content="{{url('/')}}/uploads/product_images/thumb/{{$arr_data[0]['product_images_details'][0]['image'] }}"> 

                   @else   --}}
                    <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">
                   {{-- @endif --}}

              @elseif($controller_name=="search" && Request::get('category_id')!==null) 
              @php 
                  $defaultchow =''; $defaultimage='';$defaultchowdesc='';
                  if(isset($arr_data) && !empty($arr_data))
                   {
                    $defaultchow     = isset($arr_data[0]['product_name'])?$arr_data[0]['product_name']:'Chow420';
                    $defaultchowdesc = isset($arr_data[0]['description'])?$arr_data[0]['description']:'Chow420';
                    if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)>160)
                    {
                      $defaultchowdesc = strip_tags(html_entity_decode(substr($defaultchowdesc,0,165)));
                    }

                    else if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)<=150)
                    {
                      $defaultchowdesc = strip_tags(html_entity_decode($defaultchowdesc));
                    }
                  
                   } 
              @endphp
                  <meta property="og:url" content="{{ url('/') }}/search?category_id={{Request::get('category_id')}}">         
                  {{-- <meta property="og:title" content='Shop By Category | {{ ucfirst($defaultchow) }}'> --}}
                  <meta property="og:title" content='Shop By Category | the compliant way to buy hemp-derived products'>
                  <meta property="og:description" 
                  content="@php echo str_replace('"','\'',$defaultchowdesc) @endphp">
                 {{--  @if(!empty($arr_data[0]['product_images_details'][0]['image']) && file_exists(base_path().'/uploads/product_images/'.$arr_data[0]['product_images_details'][0]['image'])))
                   <meta property="og:image" content="{{url('/')}}/uploads/product_images/thumb/{{$arr_data[0]['product_images_details'][0]['image'] }}"> 
                 @else  --}}
                    <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">
                {{--  @endif   --}}   



              @elseif( $controller_name=="search" && empty($seller_param) && $method_name!="product_detail" ) 
              @php 
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

                    else if(isset($defaultchowdesc) && !empty($defaultchowdesc) && strlen($defaultchowdesc)<=150)
                    {
                      $defaultchowdesc = strip_tags(html_entity_decode($defaultchowdesc));
                      $defaultchowdesc = str_replace("&nbsp;", '', $defaultchowdesc);
                      $defaultchowdesc = str_replace("&rsquo;", '', $defaultchowdesc);

                    }
                   } 

              @endphp
                  <meta property="og:url" content="{{ url('/') }}/search">              
                  <meta property="og:title" content='Shop | {{ ucfirst($defaultchow) }}'>
                  <meta property="og:description" 
                  content="@php echo str_replace('"','\'',$defaultchowdesc) @endphp">
                  {{-- @if(!empty($arr_data[0]['product_images_details'][0]['image']) && file_exists(base_path().'/uploads/product_images/'.$arr_data[0]['product_images_details'][0]['image'])))
                   <meta property="og:image" content="{{url('/')}}/uploads/product_images/thumb/{{$arr_data[0]['product_images_details'][0]['image'] }}"> 
                   @else --}}
                    <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">

                  {{--  @endif --}}

               @elseif( $controller_name=="search" && empty($seller_param) && $method_name=="product_detail" )      
                  @php 
                    if(isset($arr_product['id']) && !empty($arr_product['id']) && isset($arr_product['product_name']) && !empty($arr_product['product_name']) && isset($arr_product['get_brand_detail']['name']) && !empty($arr_product['get_brand_detail']['name']) && isset($arr_product['user_details']['seller_detail']['business_name']) && !empty($arr_product['user_details']['seller_detail']['business_name']))
                     {  

                     $str_seller = str_slug($arr_product['user_details']['seller_detail']['business_name']);
                     $product_url = "/search/product_detail/".base64_encode($arr_product['id'])."/".$arr_product['product_name']."/".$arr_product['get_brand_detail']['name']."/".$str_seller;
                     }
                     else
                     {
                       $product_url = ""; 
                     }

                  @endphp 

                     @if(!empty($arr_product['product_images_details']) 
                      && count($arr_product['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_images_details'][0]['image']))
                        <meta property="og:url" content="{{url('/')}}{{$product_url}}">
                        <meta property="og:title" content='Chow420'>
                       {{--  <meta property="og:image" content="{{url('/')}}/uploads/product_images/thumb/{{$arr_product['product_images_details'][0]['image'] }}">  --}}

                        @php 

                           $prod_descr=$match='';
                           if(isset($arr_product['description']) && !empty($arr_product['description']) && strlen($arr_product['description'])>160)
                           {
                             
                              $str_strip_tag = strip_tags(html_entity_decode($arr_product['description']));
                              $str_strip_tag = str_replace("&rsquo;", ' ', $str_strip_tag);
                              $str_strip_tag = str_replace("&nbsp;", ' ', $str_strip_tag);

                              //$product_desc  = substr($str_strip_tag, 0, 165);
                              preg_match('/^.{1,165}\b/s', $str_strip_tag, $match);
                              $product_desc  = $match[0];
                           }

                           else if(isset($arr_product['description']) && !empty($arr_product['description']) && strlen($arr_product['description'])<=150)
                           {
                              $product_desc = $arr_product['description'];
                              $product_desc = strip_tags(html_entity_decode($product_desc));
                              $product_desc = str_replace("&rsquo;", ' ', $product_desc);
                              $product_desc = str_replace("&nbsp;", ' ', $product_desc);
                           }

                           if(isset($product_desc))
                           {
                             $prod_descr = $product_desc;
                           }else
                           {
                               $prod_descr = '';
                           }

                        @endphp
{{--                     <meta property="og:description"  content="{{$prod_descr}}">
 --}}                    {{-- <meta name="og:description" content="@php echo str_replace('"','\'',$prod_descr) @endphp" /> --}}
                
                       @endif 
  
                   @elseif( $controller_name=="search" && isset($seller_param) && isset($arr_seller_banner) && $method_name!="product_detail" ) 
                       @php 
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

                           // $dec_signup_seller     = "Launch your online CBD dispensary or store in seconds. Get all the help you need for your online business. White labelling service, age-verification, and payment processing.";

                           $dec_signup_seller     = "Automate your compliance and more with Chow. Run your CBD business the right way!";

                           $dec_signup_seller     = substr($dec_signup_seller,0,165);

                           $desc_terms_conditions = "We offer a wide range of Services, and sometimes additional terms may apply. When you use any Chow Service you also will be subject to the guidelines, terms and agreements on this page. If these Conditions of Use are inconsistent with the Service Terms, those Service Terms will control.";
                           $desc_terms_conditions = substr($desc_terms_conditions,0,165);

                           $desc_privacy_policy   =  "We know that you care how information about you is used and shared, and we appreciate your trust that we will do so carefully and sensibly. This Privacy Notice describes how Chow collects and process your personal information through Chow's websites, devices, products, services, online and physical stores, and applications that reference this Privacy Notice. By using Chow, you are consenting to the practices described in this Privacy Notice.";
                           $desc_privacy_policy  = substr($desc_privacy_policy,0,165);

                           $desc_login           = "Sign in as a seller or buyer on Chow CBD Marketplace. Thanks for being part of the most trusted CBD community online. Please let us know if you have any questions or concerns.";
                           $desc_login           = substr($desc_login,0,165);



                       @endphp   
                      <meta property="og:title" content='{{ isset($business_details['business_name'])?$business_details['business_name']:'Chow420' }} | Explore Products'>   
                     <meta property="og:image" content="{{ $img_path }}">

               @elseif($controller_name=="signup_seller" ) 
                  <meta property="og:url" content="{{url('/')}}/signup_seller"> 
                 {{--  <meta property="og:title" content='Sell your products on one of the best marketplaces for CBD'> --}}
                  <meta property="og:title" content='Partner with Chow'>
                  
                  <meta property="og:description" content="{{$dec_signup_seller}}">   
                   <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">
               @elseif($controller_name=="signup" ) 
                  <meta property="og:url" content="{{url('/')}}/signup/buyer">  
                  <meta property="og:title" content='Start buying the best hemp CBD derived products right here'>
                  <meta property="og:description" content="Chow420.com, Welcome to the marketplace for hemp-derived products, built to automate compliance for customers and dispensaries. Register now for the best products">     
                  <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">   

               @elseif($controller_name=="login" ) 
                  <meta property="og:url" content="{{url('/')}}/login">   
                  <meta property="og:title" content='Sign in to your account and start buying and selling products'>
                  <meta property="og:description" content="{{$desc_login}}"> 
                   <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">

                @elseif($controller_name=="about-us" ) 
                  <meta property="og:url" content="{{url('/')}}/about-us"> 
                  <meta property="og:title" content='About | the compliant way to buy hemp-derived products'>
                  <meta property="og:description" content="Get to know more about chow420 products and services. We provide the best online services to the hemp CBD based industry following all the state laws and regulation."> 
                   <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg"> 

                @elseif($controller_name=="terms-conditions" ) 
                  <meta property="og:url" content="{{url('/')}}/terms-conditions">  
                  <meta property="og:title" content='Terms Of Use | the compliant way to buy hemp-derived products'>
                  <meta property="og:description" content="{{$desc_terms_conditions}}">
                   <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">

                 @elseif($controller_name=="privacy-policy" ) 
                  <meta property="og:url" content="{{url('/')}}/privacy-policy"> 
                  <meta property="og:title" content='Privacy Policy | the compliant way to buy hemp-derived products'>
                  <meta property="og:description" content="{{$desc_privacy_policy}}">  
                   <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">

                 @elseif($controller_name=="faq" )
                  @php 
                    $defaultchow =''; $defaultimage='';$defaultchowdesc=''; 
                    if(isset($faq_arr) && !empty($faq_arr))
                    {
                      $defaultchow = isset($faq_arr[0]['question'])?$faq_arr[0]['question']:'';
                       if(isset($defaultchow) && !empty($defaultchow) && strlen($defaultchow)>160)
                           {
                              $defaultchow = substr($defaultchow, 0, 165);
                              $defaultchow = strip_tags($defaultchow);
                           }

                           else if(isset($defaultchow) && !empty($defaultchow) && strlen($defaultchow)<=150)
                           {
                              $defaultchow = $defaultchow;
                              $defaultchow = strip_tags($defaultchow);
                           }
                    }
                  @endphp
                  <meta property="og:url" content="{{url('/')}}/faq"> 
                  <meta property="og:title" content='FAQ | the compliant way to buy hemp derived products'>
                  <meta property="og:description" content="{{ $defaultchow or 'Chow420:FAQ' }}">   
                   <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg">

                 @else
                  <meta property="og:url" content="{{url('/')}}"> 
                  <meta property="og:title" content='Product | the compliant way to buy hemp derived products'>
                  <meta property="og:description" content="Welcome to the number 1 CBD marketplace online Shop from the best quality and top-rated CBD products. Review the products you’ve used and share your thoughts.">  
                   <meta property="og:image" content="{{url('/')}}/assets/front/images/open-graph-image.jpg"> 
            @endif <!-----end of controller if else---------------->
        @php
        }
       @endphp 

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $meta_url or ''}}">
    <meta property="twitter:title" content='{{ $meta_title or ""}} | {{ $meta_project_name or "" }}'>        

    @if(!empty($arr_product['product_images_details']) 
           && count($arr_product['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_images_details'][0]['image']))

  {{--     <meta name="description" content="{{ $arr_product['description'] or '' }}" /> --}}

     {{--  <meta name="description" content=" {!! htmlspecialchars($arr_product['description']) !!}  " /> --}}
     

                        @php 

                           $prod_desc=$match='';

                           if(isset($arr_product['description']) && !empty($arr_product['description']) && strlen($arr_product['description'])>160)
                           {
                              $str_strip_tag = strip_tags(html_entity_decode($arr_product['description']));
                              $str_strip_tag = str_replace("&rsquo;", '', $str_strip_tag);
                              $str_strip_tag = str_replace("&nbsp;", '', $str_strip_tag);
                              //$product_desc  = substr($str_strip_tag, 0, 165);
                              preg_match('/^.{1,165}\b/s', $str_strip_tag, $match);
                              $product_desc  = $match[0];
                           }

                           else if(isset($arr_product['description']) && !empty($arr_product['description']) && strlen($arr_product['description'])<=150)
                           {
                              $product_desc = $arr_product['description'];
                              $product_desc = strip_tags(html_entity_decode($product_desc));
                              $product_desc = str_replace("&rsquo;", '', $product_desc);
                              $product_desc = str_replace("&nbsp;", '', $product_desc);
                           }


                           if(isset($product_desc))
                           {
                             $prod_desc = $product_desc;
                           }else
                           {
                               $prod_desc = '';
                           }

                           //dd($prod_desc);
                        @endphp

      <meta name="description" 
      content="@php echo str_replace('"','\'',$prod_desc) @endphp" />
    {{--   <meta name="description" content="{{$prod_desc}}" /> --}}
      <meta name="keywords" content="{{ meta_keywords_transform($meta_keywords_details)}}" />


      <meta property="og:image" content="{{url('/')}}/uploads/product_images/thumb/{{$arr_product['product_images_details'][0]['image'] }}"> 
{{-- 
      @php
         $prd_desc ='';
         if(isset($arr_product['description']) && !empty($arr_product['description']))
         {
          $prd_desc = $arr_product['description'];
         }else
         {
          $prd_desc = '';
         }
      @endphp
 --}}
      <meta property="og:description" content="@php echo str_replace('"','\'',$prod_desc) @endphp">

      {{-- <meta property="og:description" content="{!! htmlspecialchars($prd_desc) !!}"> --}}

      <meta property="twitter:image" content="{{url('/')}}/uploads/product_images/thumb/{{$arr_product['product_images_details'][0]['image'] }}">
      <meta property="twitter:description" content=" {!! htmlspecialchars($arr_product['description']) !!} ">

     
    @else

         
             @php 
              if(isset($controller_name) && !empty($controller_name)){

                $meta_desc_filter_price_drop = " ";

                 $meta_desc_filter_price_drop = substr("Welcome to the number 1 CBD marketplace online Shop from the best quality and top-rated CBD products. Review products you’ve used and share your thoughts with the community",0,165);

                 $meta_desc_search           = "Welcome to the number 1 CBD marketplace online Shop from the best quality and top-rated CBD products. Review the products you’ve used and share your thoughts.";

                  // $meta_desc_filter_price_drop = substr("Sell your products on one of the best marketplaces for CBD Launch your online CBD dispensary or store in seconds. Get all the help you need for your online business. White labelling service, age-verification",0,165);

                  // $meta_desc_search           = "Sell your products on one of the best marketplaces for CBD Launch your online CBD dispensary or store in seconds. Get all the help you need for your online business. White labelling service, age-verification.";

             @endphp 
                @if($controller_name=="chowwatch")
               
                 @elseif($controller_name=="search" && Request::get('filterby_price_drop')==null)
                  <meta name="description" content="{{$meta_desc_search}}" />
                 @elseif($controller_name=="search" && Request::get('filterby_price_drop')!==null)
                   <meta name="description" content="{{$meta_desc_filter_price_drop}}" />

                 
                @elseif($controller_name=="forum")
                  <meta name="description" content="Ask, Learn, Share, and Teach about CBD. Utilize our Forum to know more about CBD from experts, sellers, and consumers about their CBD experiences." />
                  @else
                   <meta name="description" content="@php echo $meta_desc @endphp" />
                @endif

             @php
              }//if controller name
              else
              {
             @endphp
                <meta name="description" content="@php echo $meta_desc @endphp" />
             @php
              }
             @endphp 
    
            <meta name="keywords" content="{{ meta_keywords_transform($meta_desc)}}" />

            <!-------if controller is search---------------->
             @if(isset($controller_name) && isset($seller_param) && $controller_name=="search" && isset($arr_seller_banner))
                  @php 
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

                 @endphp   
                <meta property="og:title" content='{{ isset($business_details['business_name'])?$business_details['business_name']:'Chow420' }} | Explore Products'>   
               <meta property="og:image" content="{{ $img_path }}">
                <!-------else of controller is search---------------->
               @else
           
                     @if(!empty($arr_slider_images) && count($arr_slider_images)>0)
                   
                              @if(isset($arr_slider_images[0][0]['slider_image']) && file_exists(base_path().'/uploads/slider_images/'.$arr_slider_images[0][0]['slider_image']) && isset($arr_slider_images[0][0]['slider_image'])) 
                          {{-- <meta property="og:title" content='Chow420 | CBD & Hemp Market'> --}}
                          <meta property="og:url" content="{{url('/')}}">

                          <meta property="og:title" content='Chow420 | The compliant way to buy hemp-derived products.'>
                         {{--  <meta property="og:description" content="Chow420"> --}}
                          <meta property="og:description" content="Welcome to the number 1 CBD marketplace online Shop from the best quality and top-rated CBD products. Review the products you’ve used and share your thoughts.">

                          <meta property="og:image" content="{{url('/')}}/uploads/slider_images/{{ $arr_slider_images[0][0]['slider_image']}}">
                     @else
                       <meta property="og:image" content="{{ url('/assets/front/images/open-graph-image.jpg') }}">
                     @endif

         
                @endif  

      @endif

{{-- 
      <meta property="og:description" content="{{ $meta_desc or '' }}">  --}}     
      <meta property="twitter:image"  content="{{ $logo }}">
    @endif  
   <!-- end -->
    <title>{{ $page_title or '' }} | {{ $meta_project_name or "" }}</title>
    <!-- Favicon -->

    <!--  Apple -->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="{{url('/')}}/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{url('/')}}/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{url('/')}}/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('/')}}/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{url('/')}}/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('/')}}/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('/')}}/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('/')}}/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/')}}/assets/favicon/apple-icon-180x180.png">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Chow420">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">

    <link rel="mask-icon" href="{{url('/')}}/assets/favicon/safari-pinned-tab.svg" color="#873dc8">

    <link href="{{url('/')}}/assets/splash/apple/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{url('/')}}/assets/splash/apple/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <!--  Generic -->
    <link rel="icon" type="image/png" sizes="192x192"  href="{{url('/')}}/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/')}}/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{url('/')}}/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/favicon/favicon-16x16.png">
    
    <!--  MS -->
    <meta name="msapplication-TileImage" content="{{url('/')}}/assets/favicon/ms-icon-144x144.png">
        
    <!-- Bootstrap CSS -->
    <link href="{{url('/')}}/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--font-awesome-css-start-here-->
    <link href="{{url('/')}}/assets/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> 
    <!--Custom Css-->

    <link href="{{url('/')}}/assets/front/css/flexslider.css" rel="stylesheet" type="text/css" />

    <link href="{{url('/')}}/assets/front/css/chow.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/')}}/assets/front/css/listing.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/')}}/assets/front/css/range-slider.css" rel="stylesheet" type="text/css" />
{{--     <link href="{{url('/')}}/assets/front/css/forum.css" rel="stylesheet" type="text/css" />
 --}}    <!-- parsley validation css -->
    <link href="{{url('/')}}/assets/common/Parsley/dist/parsley.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/common/sweetalert/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,900,900i" rel="stylesheet">

   <link href="{{url('/')}}/assets/front/css/front_header.css" rel="stylesheet" type="text/css" />
    @php
     $login_user = Sentinel::check();  
     if ( $login_user==true && $login_user->inRole('seller') == true) 
     {
    @endphp
    <link href="{{url('/')}}/assets/front/css/addtocart.css" rel="stylesheet">
    @php  
     }
    @endphp
{{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css"> --}}

    <!--Main JS-->
    <script type="text/javascript"  src="{{url('/')}}/assets/front/js/jquery-1.11.3.min.js"></script>
    <!--[if lt IE 9]>-->
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

    <!-- loader js -->
    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>
   {{--  <script src="https://cdn.lr-ingest.io/LogRocket.min.js" crossorigin="anonymous"></script>
 --}}

    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/owl.carousel.min.js"></script> --}}

   {{--  Log Rocket Currently Disabled
    <script>window.LogRocket && window.LogRocket.init('a4czv7/chow420');</script>
     
    @if(Sentinel::check())
      @php
        $user = Sentinel::getUser();
      @endphp
      <script type="text/javascript">
        LogRocket.identify('{{ $user->id or '--'}}', {
          name: '{{ $user->first_name or '--'}} {{ $user->last_name or '--'}}',
          email: '{{ $user->email or '--'}}',
          // Add your own custom user variables here, ie:
          subscriptionType: 'None'
        });
      </script>
    @endif --}}
     
<script type="text/javascript">
$(document).ready(function(){
    $("#myiploadModal").modal({
    show:false,
    backdrop:'static'
    });
});
</script>
<script type="text/javascript">
  /* Install Service Worker */
  var SITE_URL = '{{url('/')}}';
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
@php 

  $brandname ='';
  $average ='';
  $reviewcount ='';

  $get_aggregaterating = get_aggregaterating();
  //dd($get_aggregaterating);
   $price =''; $prd_name='';$sellername='';
  if(isset($get_aggregaterating) && !empty($get_aggregaterating))
  {
    $average = isset($get_aggregaterating['Average'])?$get_aggregaterating['Average']:'';
    $reviewcount = isset($get_aggregaterating['Reviewcount'])?$get_aggregaterating['Reviewcount']:'';
    $productarr = isset($get_aggregaterating['Productarr'])?$get_aggregaterating['Productarr']:[];
    if(isset($productarr) && !empty($productarr))
    {
      $prd_name = isset($productarr['product_details']['product_name'])?$productarr['product_details']['product_name']:'';
      $pdescription = isset($productarr['product_details']['description'])?$productarr['product_details']['description']:'';
      $unit_price = isset($productarr['product_details']['unit_price'])?$productarr['product_details']['unit_price']:'';
      $price_drop_to = isset($productarr['product_details']['price_drop_to'])?$productarr['product_details']['price_drop_to']:'';
      if(isset($price_drop_to) && $price_drop_to>0){
        $price = $price_drop_to;
      }
      else{
        $price = $unit_price;
      }


      $brandname ='';
      if(isset($productarr['product_details']['get_brand_detail']) && !empty($productarr['product_details']['get_brand_detail']))
      {
         $brandname = $productarr['product_details']['get_brand_detail']['name']; 
      }else{
         $brandname ='';
      }

       $sellername ='Chow420';
      if(isset($productarr['user_details']) && !empty($productarr['user_details']))
      {
         $fname = isset($productarr['user_details']['first_name'])?$productarr['user_details']['first_name']:''; 
         $lname = isset($productarr['user_details']['last_name'])?$productarr['user_details']['last_name']:''; 

         if(isset($fname) || isset($lname))
         {
          $sellername = $fname.' '.$lname;
         }
         else
         {
          $sellername = isset($productarr['user_details']['email'])?$productarr['user_details']['email']:''; 
         }

      }else{
         $sellername ='Chow420';
      }//else

    }//isset product arr

  }//isset aggregate rating


@endphp


 <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Product",
   "brand": {
        "@type": "Brand",
        "name": "{{$brandname }}"
      },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $average }}",
    "reviewCount": "{{ $reviewcount }}"
  },
  "description": "Chow420",
  "name": "{{ $prd_name }}",
  "image": "https://chow420.com/assets/front/images/open-graph-image.jpg",
  "sku": "9780241984758",
  "mpn": "925872",
  "offers": {
    "@type": "Offer",
    "availability": "http://schema.org/InStock",
    "price": "{{ $price }}",
    "priceCurrency": "USD",
     "url": "http://chow420.com",
     "priceValidUntil": "2020-11-05"
  },
  "review": [
    {
      "@type": "Review",
      "author": "{{ $sellername }}",
      "datePublished": "2011-04-01",
      "description": "Chow420",
      "reviewRating": {
        "@type": "Rating",
        "bestRating": "5",
        "ratingValue": "1",
        "worstRating": "1"
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





</head>
<body>


@php
if(isset($site_setting_arr['body_content']) && !empty($site_setting_arr['body_content'])) {
  echo $site_setting_arr['body_content'];
}
@endphp


<style>
/*css added for making title to h1*/	
h1 {
    font-size: 30px;
    font-weight: 600;
}	

.modal-full {
    min-width: 20%;
    margin-left: 80;
}

.modal-dialog {
    margin: 11px auto 0;
}
.modal-body {
    text-align: center;
}
.modal-body .add-cart{
    margin-top: 13px;
}
.modalbody-select {
    max-width: 360px;
    margin: 0 auto;
    padding: 30px 0;
}


</style>

  
<div class="terms-pg-section">
    <div class="container">

        <h1>{{ isset($res_cms[0]->page_title)?ucwords($res_cms[0]->page_title):'' }}</h1>
        <div class="last-txts">Last updated: {{ isset($res_cms[0]->updated_at)?date('d M Y',strtotime($res_cms[0]->updated_at)):'' }}</div>
        <div class="border-terms"></div>
        {!! isset($res_cms[0]->page_desc)?$res_cms[0]->page_desc:'' !!}
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4 state-holder" id="state-holder">
            <div class="modalbody-select">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="form-group form-box">
                            <label >Please select your state</label>
                            <div class="select-style">
                                 <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state" id="state" name="state">

                                    @if(isset($states_arr) && count($states_arr)>0)
                                    <option value="">Select State</option>
                                    @foreach($states_arr as $state)
                                        <option  value="{{$state['id']}}">{{isset($state['name'])?ucfirst(strtolower($state['name'])):'--' }}</option>                                        
                                    @endforeach
                                    @else
                                        <option>States Not Available</option>
                                    @endif
                                </select> 
                            </div>
                            
                             <div class="stateerror" id="state_error_message"></div>
                             <div class="clearfix"></div>
                        </div>
                        <div class="instructions">
                            <div>Your state laws have been applied to your experience on Chow</div>
                            <a href="{{ url('/') }}" class="add-cart">Explore Now</a>   
                        </div>               
                    
                    </div>
                
                </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
            </div> --}}
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
        $(".instructions").hide();

		$('#myModal').modal('show');

        $("#state").on('change', function(){
            if($(this).val() == "")
            {
                $(".instructions").hide();
            }
            else
            {
                $(".instructions").show();

            }
        })
	});
</script>

@include('front.layout._footer')  

