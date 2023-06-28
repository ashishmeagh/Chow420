@extends('front.layout.master')
@section('main_content')
<link href="{{url('/')}}/assets/front/css/messenger.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/front/css/marquee.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/front/css/slick.css" rel="stylesheet" type="text/css" />
 <link href="{{url('/')}}/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />

<style>
   .rw-slide-li {position:relative;}
  .rw-slide-li .hover-img {opacity:0; position: absolute; bottom: -20px;
    right: 0;
    padding: 0px 6px;
    z-index: 99;
    left: 60px;}
    .rw-slide-li:hover .hover-img {opacity:1;}
    .header{border-bottom: none !important; }
</style>

 @php

  $login_user = Sentinel::check();

    $isMobileDevice=0;
    $isMobileDevice= isMobileDevice();

    if($isMobileDevice==1){

        $device_count = 2;
        $chowwatch_device_count = '';
    }
    else {
        $device_count = 4;
        $chowwatch_device_count = 3;
    }

  if(isset($arr_events) && !empty($arr_events))
  {
   // $arr_events = json_encode($arr_events);
  
  }

  //get state user ids and catdata
  $checkuser_locationdata = checklocationdata(); 

  if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
  {
     $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
     
     $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
  }


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


@endphp

@php


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

if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids))
{

      $restricted_state_sellers = [];
      foreach($restricted_state_user_ids as $sellers)
      {
        $restricted_state_sellers[] = $sellers['id'];
      }
}

$is_buyer_restricted_forstate = is_buyer_restricted_forstate();

/********************Restricted states seller id***********************/

  $slider_image_count =0;
  
  if(isset($arr_slider_images) && !empty($arr_slider_images) && count($arr_slider_images)>0)
  {
    $slider_image_count =  count($arr_slider_images[0]);
  }


  //get banners images data
  $banner_images_data = [];
  $banner_images_data = get_banner_images();

@endphp




<div class="homepage">

<!----------------------start sliders ------------------------------------------->

<div id="carousel-example-generic" class="@if(isset($slider_image_count) && $slider_image_count==1)carousel slide singlislider @else carousel slide @endif" data-ride="carousel" >

<!-- old code -->

  @php
      
    $slider_image_count =0;

    if(isset($arr_slider_images) && !empty($arr_slider_images) && count($arr_slider_images)>0){
      $slider_image_count =  count($arr_slider_images[0]);
    }

    if($slider_image_count>1){
  @endphp
  
    <!-- Indicators -->
    <ol class="carousel-indicators">
         @if(!empty($arr_slider_images) && count($arr_slider_images)>0)

           @foreach($arr_slider_images as $key1=>$slider)

                @foreach($slider as $key=>$slide)

                    @php
                        if($key==0)
                         $active = "active";
                        else
                        $active = '';
                    @endphp

                <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}" class="{{$active}}"></li>
            @endforeach
            @endforeach
        @endif

    </ol>

    @php
      }
    @endphp

    @php $i=0; @endphp

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        @if(!empty($arr_slider_images) && count($arr_slider_images)>0)
           @foreach($arr_slider_images as $slider)
                @foreach($slider as $k=>$slide)
                    @php
                        if($k=='0')
                         $active = 'item active';
                        else
                         $active = 'item';
                    @endphp

              
               <div class="{{ $active }}" style="background-position: center center; margin: 0px; padding: 0;">

           
              @if(isset($slide['slider_image']) && isset($slide['slider_medium']) && isset($slide['slider_small']))


                <figure class="cw-image__figure">
                   <picture>

                     @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_small']) && isset($slide['slider_small']))

                      @php
                       $slider_small = image_resize('/uploads/slider_images/'.$slide['slider_small'],375,152);
                      @endphp

                   
                      <source  type="image/png" src="{{$slider_small}}" media="(max-width: 621px)">

                     @endif

                     @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_medium']) && isset($slide['slider_medium']))

                     @php
                      $slider_medium = image_resize('/uploads/slider_images/'.$slide['slider_medium'],1358,548);
                     @endphp

                      
                      <source  type="image/png" src="{{$slider_medium}}" media="(min-width: 622px) ">  

                     @endif

                      @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_image']) && isset($slide['slider_image']))

                      @php

                        $slider_image = image_resize('/uploads/slider_images/'.$slide['slider_image'],1358,548);

                      @endphp

                    
                      <source  type="image/png" src="{{$slider_image}}" media="(min-width: 835px)"> 

                      @endif

                      @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_image']) && isset($slide['slider_image']))

                      @php

                        $default_slider_img = image_resize('/uploads/slider_images/'.$slide['slider_image'],1358,548);
                      @endphp

                     
                      <img  class="cw-image cw-image--loaded obj-fit-polyfill" alt="slider image" aria-hidden="false" src="{{$default_slider_img}}">

                      @endif

                    </picture>
                </figure>

              @endif


              <a href="{{ $slide['image_url'] }}" class="carousel-caption">
                <div class="container">
                  <div class="row">
                    <div class="col-md-7">
                        <div class="banner-text-block">
                           <div class="modarn-hm" @if(isset($slide['title_color']) && !empty($slide['title_color'])) style="color:{{ $slide['title_color']  }}" @endif >{{ isset($slide['title'])?$slide['title']:''}}</div>
                                @if($k==0)
                                <h1 @if(isset($slide['subtitle_color']) && !empty($slide['subtitle_color'])) style="color:{{ $slide['subtitle_color']  }}" @endif>
                                     {{ $slide['subtitle'] or '' }}
                                 </h1>
                                 @else
                                  <h2 @if(isset($slide['subtitle_color']) && !empty($slide['subtitle_color'])) style="color:{{ $slide['subtitle_color']  }}" @endif>
                                     {{ $slide['subtitle'] or '' }}
                                 </h2>
                                 @endif
                                <div class="button-rev homts">
                                  @if(isset($slide['slider_button']) && (!empty($slide['slider_button'])))
                                    <div class="butn-def" @if(isset($slide['button_color']) && !empty($slide['button_color'])) style="color:{{ $slide['button_color']  }}  @if(isset($slide['button_back_color']) && !empty($slide['button_back_color'])); background-color:{{ $slide['button_back_color']  }} @endif" @endif>{{ $slide['slider_button'] }}</div>
                                 @endif
                           </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                       <div id="wrapper-id">
                        <div class="chat">
                          <div class="chat-container">
                            <div class="chat-listcontainer">
                              <ul class="chat-message-list">
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </a>
          
        </div>

      @endforeach
    @endforeach
  @endif
</div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
  </a>



<!--ajax call-->

  <!-- loader -->
 <!--  <div class="" id="banner_images_loader" style="display: none;">

    <ul class="f-cat-below7">

        <li>
           <div class="top-rated-brands-list">
             <div class="ph-item">
                <div class="ph-col-12">
                    <div class="ph-picture"></div>
                  
                </div>
            </div>
          </div>
        </li>
    
   
    </ul>

  </div>

  <div class="" id="sliders_id" style="display: none;">
  
  </div> -->

</div>


<!---------------------------end of slider ---------------------------------------------------------->




<!----------------------------start of recently viewed------------------------>
<div class="container">

<div class="top-rated-brands-main homepagenewlistings trending-products-cls-home recently-viewed-space">

<!-- old code -->


@if(($login_user == true && $login_user->inRole('buyer')) || ($login_user == false))


  @if(isset($arr_eloq_trending_data) && count($arr_eloq_trending_data)>0)

   
        <div class="toprtd non-mgts viewall-btns-idx toprated-view">Recently Viewed

          @php
          if(isset($arr_eloq_trending_data) && count($arr_eloq_trending_data)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';
          @endphp

         <a href="{{ url('/') }}/search?best_seller=true" class="{{ $class }}" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>

        <div class="featuredbrands-flex trendingproducts-section">
          <ul @if(isset($arr_eloq_trending_data) && count($arr_eloq_trending_data)<=$device_count)
             class="f-cat-below7"
          
            @elseif(isset($arr_eloq_trending_data) && count($arr_eloq_trending_data)>$device_count)
              id="flexiselDemo2"
           @endif
         >

        @php

            $trend_branname ='';
            $trend_sellername ='';
            $is_besesellerbest ='';
            $total_rating = $total_product_rating = 0;
            $pageclick = [];
            $i=1;
            $checkfirstcat_flag = 0;
            $rating = $avg_rating = '';

        @endphp


          @foreach($arr_eloq_trending_data as $trend_product)

            @php

                        $avg_rating = get_avg_rating($trend_product['id']);

                        $rating = isset($avg_rating)? get_avg_rating_image($avg_rating):'';


                       $total_review = get_total_reviews($trend_product['id']);
                        if($total_review>0)
                          $total_review = $total_review;
                        else
                           $total_review = '';


                       $trend_branname = isset($trend_product['get_brand_detail']['name'])?str_slug($trend_product['get_brand_detail']['name']):'';

                       $trend_sellername = isset($trend_product['get_seller_details']['seller_detail']['business_name'])?str_slug($trend_product['get_seller_details']['seller_detail']['business_name']):'';

                       $is_besesellerbest = check_isbestseller($trend_product['id']);

                       $trend_bran_concentration  = isset($trend_product['per_product_quantity']) ? $trend_product['per_product_quantity'].'mg' : '' ;


                        $product_title = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                      $product_title_slug = str_slug($product_title);



                       $pageclick['name'] = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                       $pageclick['id'] = isset($trend_product['id']) ? $trend_product['id'] : '';
                       $pageclick['brand'] = isset($trend_product['brand']) ? get_brand_name($trend_product['brand']) : '';
                       $pageclick['category'] = isset($trend_product['first_level_category_id']) ? get_first_levelcategorydata($trend_product['first_level_category_id']) : '';


                       if(isset($trend_product['price_drop_to']))
                        {
                          if($trend_product['price_drop_to']>0)
                          {
                             $pageclick['price'] = isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '';
                          }else{
                             $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                          }

                        }else{
                          $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                        }



                      
                       $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug;

                    
                        $firstcat_id = isset($trend_product['first_level_category_id'])?$trend_product['first_level_category_id']:'';
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

                       $restrictseller_id   = isset($trend_product['user_id'])?$trend_product['user_id']:'';

                      
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

                      

                    $isblur =0;


              @endphp


             <li>

                


                   @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                        <div class="out-of-stock trending-left" >
                          <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                        </div>
                   @endif




                @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                
                       @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                           @if($checkfirstcat_flag==1)
                            @php $isblur=1; @endphp
                             

                           @endif
                      @else
                      

                            @if($checkfirstcat_flag==1)
                              @php $isblur=1; @endphp
                        
                            @else
                              @php $isblur=1; @endphp
                         
                            @endif

                       
                      @endif
                    

                  @else
                  

                        @if($checkfirstcat_flag==1)
                         @php $isblur=1; @endphp
                           
                        @else
                          @php $isblur=1; @endphp
                  
                        @endif

                  
                  @endif

                <div class="top-rated-brands-list">
                  
                     <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['id'])?base64_encode($trend_product['id']):'0'}}/{{ $product_title_slug }}" title="{{ ucfirst($trend_product['product_name']) }}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">


                      <div class="img-rated-brands">


                          <div  @if(isset($isblur) && $isblur==1) class="thumbnailss blurclass" @else class="thumbnailss" @endif>

                                 @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                                     @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                                         @if($checkfirstcat_flag==1)
                                            <div class="chow-outofstock-hm">Restricted</div>
                                         @endif
                                    @else

                                          @if($checkfirstcat_flag==1)
                                           <div class="chow-outofstock-hm">Restricted</div>
                                          @else
                                             <div class="chow-outofstock-hm">Out of stock</div>
                                          @endif

                                    @endif

                                 @else


                                      @if($checkfirstcat_flag==1)
                                          <div class="chow-outofstock-hm">Restricted</div>
                                      @else
                                        <div class="chow-outofstock-hm">Out of stock</div>
                                      @endif


                                @endif
                         

                                @if(isset($trend_product['product_images_details'][0]['image']) &&file_exists(base_path().'/uploads/product_images/'.$trend_product['product_images_details'][0]['image']))

                                @php
                                   
                                  $final_product_image = image_resize('/uploads/product_images/'.$trend_product['product_images_details'][0]['image'],190,190);

                                @endphp

                               {{--  <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_images_details'][0]['image']}}" class="portrait" alt="{{ $product_title }}" /> --}}

                         {{--        <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$final_product_image}}" class="portrait" alt="{{ $product_title }}" />
 --}}

                                <img src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_images_details'][0]['image']}}" class="portrait" alt="{{ $product_title }}" />

                                @else

                                  <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/assets/images/default-product-image.png')}}" class="portrait" alt="{{ $product_title }}" />



                                @endif
                            </div>
                        <div class="content-brands">

                           @php
                           
                              $connabinoids_name = get_product_cannabinoids($trend_product['id']);

                            @endphp
                            @if(isset($connabinoids_name) && count($connabinoids_name) > 0)
                                  <div class="inlineblock-view-cannabionoids">
                                     <span class="inline-trend-product">
                                          @php
                                            $i = 0;
                                            $numItems = count($connabinoids_name);
                                          @endphp
                                            @foreach($connabinoids_name as $cann)

                                                <span class="oil-category-cannabinoids"> {{$cann['name']}} {{floatval($cann['percent'])}}%</span>


                                            @endforeach
                                      </span>
                                  </div>
                            @endif
                            <div class="title-chw-list">
                              
                                  <span class="titlename-list">
                                  {{ isset($trend_product['id'])?get_product_name($trend_product['id']):''  }}
                                  </span>
                            </div>



                              <div class="price-listing pricestatick viewinlineblock">
                                    @if(isset($trend_product['price_drop_to']))
                                      @if($trend_product['price_drop_to']>0)
                                       @php
                                       if(isset($product['percent_price_drop']) && $product['percent_price_drop']=='0.000000')
                                       {
                                       $percent_price_drop = calculate_percentage_price_drop($trend_product['id'],$trend_product['unit_price'],$trend_product['price_drop_to']);
                                       $percent_price_drop = floor($percent_price_drop);
                                       }
                                       else
                                       {
                                        $percent_price_drop = floor($trend_product['percent_price_drop']);
                                       }
                                       @endphp
                                        <span class="unitpriceclass">${{isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '0'}} </span>
                                        <del class="pricevies inline-del">

                                        ${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}}
                                      </del>
                                     

                                      @else
                                        <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                        <del class="pricevies hidepricevies"></del>

                                      @endif
                                    @else
                                    <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                       <del class="pricevies hidepricevies"></del>


                                    @endif
                               </div>


                            
                                  @if(isset($trend_product['shipping_type']) && $trend_product['shipping_type']==0)
                                   @php
                                        $setshipping = "";
                                        if($trend_product['shipping_type']==0)
                                        { $setshipping = "Free Shipping";
                                        }
                                        else{
                                          $setshipping = "Flat Shipping";
                                        }
                                   @endphp
                                   <div class="freeshipping-class" title="{{ $setshipping }}">
                                       Free Shipping
                                  </div>
                                  @endif
                               


                            <div class="starthomlist "  @if($avg_rating>0) title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."
                           @endif>
                              @if($avg_rating>0 && isset($rating))

                                <img class="lozad" src="{{url('/')}}/assets/front/images/star/{{$rating}}.svg" alt="{{$rating}}.svg" title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."/>

                               
                                 <span class="str-links starcounts" title="@if($total_review==1){{$total_review}} Rating @elseif($total_review>1){{ $total_review }} Ratings @endif">
                                

                                  {{ isset($avg_rating)?$avg_rating:'' }}
                                  @if(isset($total_review)) ({{ $total_review }}) @endif


                                 </span>
                                
                              @endif
                            </div>


                          

                                @php

                                  $get_available_coupon = [];
                                  $get_available_coupon = get_coupon_details($trend_product['user_id']);
                                @endphp

                                @if(isset($get_available_coupon) && count($get_available_coupon)>0)

                                <div class="couponsavailable">Coupons Available</div>

                                @endif

                          
                            <div class="inlineblock-view">
                             

                                 
                                  @if(isset($trend_product['product_details']['shipping_type']) && $trend_product['product_details']['shipping_type']==0)
                                   @php
                                        $setshipping = "";
                                        if($trend_product['product_details']['shipping_type']==0)
                                        { $setshipping = "Free Shipping";
                                        }
                                        else{
                                          $setshipping = "Flat Shipping";
                                        }
                                   @endphp
                                   <div class="truck-icons" title="{{ $setshipping }}">
                                  <div class="freedrusd">Free Shipping </div> <img src="{{url('/')}}/assets/front/images/truck-icon.png" alt="Free Shipping">
                                  </div>
                                  @endif
                                  
                              </div>




                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li>

            @php
             $i++;
            @endphp

         @endforeach
          
        
        </ul>
    </div>


  @endif


@endif




<!--ajax call-->

<!-- loader -->
<!--<div class="" id="recently-view-loader" style="display: none;">

  <ul class="f-cat-below7">

    @for($i=0;$i<4;$i++)
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
      
    @endfor  
 
  </ul>

  </div>

 <div class="" id="recently_viewed_id" style="display: none;">

 </div> -->

</div>


<!------------end recently viewed----------------------->




<!-------------------start buy again-------------------------------------->

<div class="top-rated-brands-main homepagenewlistings trending-products-cls-home">
 


@if($login_user == true && $login_user->inRole('buyer'))

@if(isset($buy_again_product_arr) && count($buy_again_product_arr)>0)

<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>
        
  <div class="toprtd non-mgts viewall-btns-idx toprated-view">Buy Again

          @php
          if(isset($buy_again_product_arr) && count($buy_again_product_arr)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';
          @endphp

         <a href="{{ url('/') }}/buyer/review-ratings" class="{{ $class }}" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>

        <div class="featuredbrands-flex trendingproducts-section">
          <ul @if(isset($buy_again_product_arr) && count($buy_again_product_arr)<=$device_count)
             class="f-cat-below7"
           {{-- @elseif(isset($arr_trending) && $isMobileDevice==1 )

           @elseif(isset($arr_trending) && count($arr_trending)>$device_count  && $isMobileDevice==0 )
              id="flexiselDemo2"
           @endif --}}
            @elseif(isset($buy_again_product_arr) && count($buy_again_product_arr)>$device_count)
              id="flexiselDemo67"
           @endif
         >
            @php


              $trend_branname ='';
              $trend_sellername ='';
              $is_besesellerbest ='';
              $total_rating = $total_product_rating = 0;
              $pageclick = [];
              $i=1;
              $checkfirstcat_flag = 0;
              $rating = $avg_rating = '';
            @endphp
            @foreach($buy_again_product_arr as $trend_product)
               @php

                        $avg_rating = get_avg_rating($trend_product['id']);

                        $rating = isset($avg_rating)? get_avg_rating_image($avg_rating):'';


                       $total_review = get_total_reviews($trend_product['id']);
                        if($total_review>0)
                          $total_review = $total_review;
                        else
                           $total_review = '';


                       $trend_branname = isset($trend_product['get_brand_detail']['name'])?str_slug($trend_product['get_brand_detail']['name']):'';

                       $trend_sellername = isset($trend_product['get_seller_details']['seller_detail']['business_name'])?str_slug($trend_product['get_seller_details']['seller_detail']['business_name']):'';

                       $is_besesellerbest = check_isbestseller($trend_product['id']);

                       $trend_bran_concentration  = isset($trend_product['per_product_quantity']) ? $trend_product['per_product_quantity'].'mg' : '' ;


                        $product_title = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                      $product_title_slug = str_slug($product_title);



                       $pageclick['name'] = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                       $pageclick['id'] = isset($trend_product['id']) ? $trend_product['id'] : '';
                       $pageclick['brand'] = isset($trend_product['brand']) ? get_brand_name($trend_product['brand']) : '';
                       $pageclick['category'] = isset($trend_product['first_level_category_id']) ? get_first_levelcategorydata($trend_product['first_level_category_id']) : '';


                       if(isset($trend_product['price_drop_to']))
                        {
                          if($trend_product['price_drop_to']>0)
                          {
                             $pageclick['price'] = isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '';
                          }else{
                             $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                          }

                        }else{
                          $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                        }



                       //$pageclick['position'] = $i;
                       // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug.'/'.$trend_branname.'/'.$trend_sellername ;
                       $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug;

                       /****************for restriction and out of stock icon*********/

                        $firstcat_id = isset($trend_product['first_level_category_id'])?$trend_product['first_level_category_id']:'';
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

                       $restrictseller_id   = isset($trend_product['user_id'])?$trend_product['user_id']:'';

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

                       /***********for restriction and out of stock icon************/

                    $isblur =0;


              @endphp


             <li>

                  @if(isset($login_user) && $login_user == true && $login_user->inRole('buyer'))
                   @if($checkfirstcat_flag==0)
                    {{--  <div class="statelaw-label">
                     <i class="fa fa-check"></i> state law

                     </div> --}}
                   @endif
                  @else
                     {{-- <div class="statelaw-label">
                      <i class="fa fa-check"></i> state law
                     </div> --}}
                  @endif



                   @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                        <div class="out-of-stock trending-left" >
                          <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                        </div>
                   @endif




                @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                    <!--------------outofstock--------------->
                       @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                           @if($checkfirstcat_flag==1)
                            @php $isblur=1; @endphp
                              {{-- <div class="out-of-stock">
                               <span class="red-text">
                                 Restricted
                               </span>
                             </div> --}}

                           @endif
                      @else
                        {{-- <div class="out-of-stock">  --}}

                            @if($checkfirstcat_flag==1)
                              @php $isblur=1; @endphp
                            {{--  <span class="red-text">
                               Restricted
                             </span> --}}
                            @else
                              @php $isblur=1; @endphp
                              {{-- <span class="red-text">Out of stock</span> --}}
                            @endif

                        {{--  </div> --}}
                      @endif
                    <!---------------outofstock-------------->

                  @else
                    {{-- <div class="out-of-stock">  --}}

                        @if($checkfirstcat_flag==1)
                         @php $isblur=1; @endphp
                           {{-- <span class="red-text">
                             Restricted
                           </span> --}}
                        @else
                          @php $isblur=1; @endphp
                         {{--  <span class="red-text">Out of stock</span> --}}
                        @endif

                    {{-- </div> --}}
                  @endif

                <div class="top-rated-brands-list">

                     <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['id'])?base64_encode($trend_product['id']):'0'}}/{{ $product_title_slug }}" title="{{ ucfirst($trend_product['product_name']) }}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">


                      <div class="img-rated-brands">


                          <div  @if(isset($isblur) && $isblur==1) class="thumbnailss blurclass" @else class="thumbnailss" @endif>

                             <!----------Show out of stock on blur product------------------->
                                 @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                                     @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                                         @if($checkfirstcat_flag==1)
                                            <div class="chow-outofstock-hm">Restricted</div>
                                         @endif
                                    @else

                                          @if($checkfirstcat_flag==1)
                                           <div class="chow-outofstock-hm">Restricted</div>
                                          @else
                                             <div class="chow-outofstock-hm">Out of stock</div>
                                          @endif

                                    @endif

                                 @else


                                      @if($checkfirstcat_flag==1)
                                          <div class="chow-outofstock-hm">Restricted</div>
                                      @else
                                        <div class="chow-outofstock-hm">Out of stock</div>
                                      @endif


                                @endif
                             <!---------End out of stock on blur product-------------->





                                @if(isset($trend_product['product_images_details'][0]['image']) &&file_exists(base_path().'/uploads/product_images/'.$trend_product['product_images_details'][0]['image']))

                               @php
                                 $final_product_image = image_resize('/uploads/product_images/'.$trend_product['product_images_details'][0]['image'],190,190);

                               @endphp

                              {{--   <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_images_details'][0]['image']}}" class="portrait" alt="{{ $product_title }}" />
 --}}

                                <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$final_product_image}}" class="portrait" alt="{{ $product_title }}" />

                                @else
                                  <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/assets/images/default-product-image.png')}}" class="portrait" alt="{{ $product_title }}" />

                                @endif
                            </div>
                        <div class="content-brands">


                            <div class="title-chw-list">

                                  <span class="titlename-list">
                                  {{ isset($trend_product['id'])?get_product_name($trend_product['id']):''  }}
                                  </span>
                            </div>


                              <div class="price-listing pricestatick viewinlineblock">
                                    @if(isset($trend_product['price_drop_to']))
                                      @if($trend_product['price_drop_to']>0)
                                       @php
                                       if(isset($product['percent_price_drop']) && $product['percent_price_drop']=='0.000000')
                                       {
                                       $percent_price_drop = calculate_percentage_price_drop($trend_product['id'],$trend_product['unit_price'],$trend_product['price_drop_to']);
                                       $percent_price_drop = floor($percent_price_drop);
                                       }
                                       else
                                       {
                                        $percent_price_drop = floor($trend_product['percent_price_drop']);
                                       }
                                       @endphp
                                        <span class="unitpriceclass">${{isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '0'}} </span>
                                        <del class="pricevies inline-del">

                                        ${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}}
                                      </del>
                                      {{-- <div class="inlineoff-div">({{$percent_price_drop}}% off)</div> --}}


                                      @else
                                        <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                        <del class="pricevies hidepricevies"></del>

                                      @endif
                                    @else
                                    <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                       <del class="pricevies hidepricevies"></del>


                                    @endif
                               </div>
                                 <!-----------truck---------------->
                                  @if(isset($trend_product['shipping_type']) && $trend_product['shipping_type']==0)
                                   @php
                                        $setshipping = "";
                                        if($trend_product['shipping_type']==0)
                                        { $setshipping = "Free Shipping";
                                        }
                                        else{
                                          $setshipping = "Flat Shipping";
                                        }
                                   @endphp
                                   <div class="freeshipping-class" title="{{ $setshipping }}">
                                       Free Shipping
                                  </div>
                                  @endif
                                  <!----------truck----------------->

                            <div class="starthomlist "  @if($avg_rating>0) title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."
                           @endif>
                              @if($avg_rating>0 && isset($rating))

                                <img class="lozad" src="{{url('/')}}/assets/front/images/star/{{$rating}}.svg" alt="{{$rating}}.svg" title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."/>

                                 <!-------review------------>
                                 <span class="str-links starcounts" title="@if($total_review==1){{$total_review}} Rating @elseif($total_review>1){{ $total_review }} Ratings @endif">
                                  {{-- @if($total_review==1)  {{ $total_review }} Rating
                                  @elseif($total_review>1){{ $total_review }} Ratings
                                  @endif --}}

                                  {{ isset($avg_rating)?$avg_rating:'' }}
                                  @if(isset($total_review)) ({{ $total_review }}) @endif


                                 </span>
                                 <!--------review--------------->
                              @endif
                            </div><!--end div of rating--->


                             <!--coupon code text div-->
                                @php

                                  $get_available_coupon = [];
                                  $get_available_coupon = get_coupon_details($trend_product['user_id']);
                                @endphp

                                @if(isset($get_available_coupon) && count($get_available_coupon)>0)

                                <div class="couponsavailable">Coupons Available</div>

                                @endif
                            <!------------------------>

                            <div class="inlineblock-view">
                               {{-- @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                                  <div class="home_chow_choice chow_choice font-small circle-font-small-chow" style="margin-left: 0px">
                                    <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                                  </div>
                                @endif  --}}

                               {{--  @if(isset($is_besesellerbest) && $is_besesellerbest!="" && $is_besesellerbest==1)
                                  <div class="home_bestseller chow_choice-orange font-small circle-font-small" >
                                    <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow-arrow-icon-tag.png" alt=""> Best Seller</span>
                                  </div>
                                @endif --}}


                                  <!-----------truck---------------->
                                  @if(isset($trend_product['product_details']['shipping_type']) && $trend_product['product_details']['shipping_type']==0)
                                   @php
                                        $setshipping = "";
                                        if($trend_product['product_details']['shipping_type']==0)
                                        { $setshipping = "Free Shipping";
                                        }
                                        else{
                                          $setshipping = "Flat Shipping";
                                        }
                                   @endphp
                                   <div class="truck-icons" title="{{ $setshipping }}">
                                  <div class="freedrusd">Free Shipping </div> <img src="{{url('/')}}/assets/front/images/truck-icon.png" alt="Free Shipping">
                                  </div>
                                  @endif
                                  <!----------truck----------------->


                              </div>

                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li>

            @php
             $i++;
            @endphp

         @endforeach
        </ul>
    </div>


  @endif


@endif

<!-- 
<div class="" id="buy_again-loader" style="display: none;">

<ul class="f-cat-below7">

  @for($i=0;$i<4;$i++)
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
    
  @endfor  

</ul>

</div>

<div class="" id="buy_again_id" style="display: none;">

</div> -->

</div>

<!-------------------end buy again--------------------------------------->



<!-------------------start product you may like-------------------------------------->

<div class="top-rated-brands-main homepagenewlistings trending-products-cls-home">



{{-- @if($login_user == true && $login_user->inRole('buyer'))
 --}}

@if(isset($product_liked_arr) && count($product_liked_arr)>0)

<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>

  <div class="toprtd non-mgts viewall-btns-idx toprated-view">Products you may like

          @php
          if(isset($product_liked_arr) && count($product_liked_arr)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';
          @endphp

         <a href="{{ url('/') }}/search?best_seller=true" class="{{ $class }}" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>

        <div class="featuredbrands-flex trendingproducts-section">
          <ul @if(isset($product_liked_arr) && count($product_liked_arr)<=$device_count)
             class="f-cat-below7"
            @elseif(isset($product_liked_arr) && count($product_liked_arr)>$device_count)
              id="flexiselDemo68"
           @endif
         >
            @php


              $trend_branname ='';
              $trend_sellername ='';
              $is_besesellerbest ='';
              $total_rating = $total_product_rating = 0;
              $pageclick = [];
              $i=1;
              $checkfirstcat_flag = 0;
              $rating = $avg_rating = '';
            @endphp
            @foreach($product_liked_arr as $trend_product)
               @php

                        $avg_rating = get_avg_rating($trend_product['id']);

                        $rating = isset($avg_rating)? get_avg_rating_image($avg_rating):'';


                       $total_review = get_total_reviews($trend_product['id']);
                        if($total_review>0)
                          $total_review = $total_review;
                        else
                           $total_review = '';


                       $trend_branname = isset($trend_product['get_brand_detail']['name'])?str_slug($trend_product['get_brand_detail']['name']):'';

                       $trend_sellername = isset($trend_product['get_seller_details']['seller_detail']['business_name'])?str_slug($trend_product['get_seller_details']['seller_detail']['business_name']):'';

                       $is_besesellerbest = check_isbestseller($trend_product['id']);

                       $trend_bran_concentration  = isset($trend_product['per_product_quantity']) ? $trend_product['per_product_quantity'].'mg' : '' ;


                        $product_title = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                      $product_title_slug = str_slug($product_title);



                       $pageclick['name'] = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                       $pageclick['id'] = isset($trend_product['id']) ? $trend_product['id'] : '';
                       $pageclick['brand'] = isset($trend_product['brand']) ? get_brand_name($trend_product['brand']) : '';
                       $pageclick['category'] = isset($trend_product['first_level_category_id']) ? get_first_levelcategorydata($trend_product['first_level_category_id']) : '';


                       if(isset($trend_product['price_drop_to']))
                        {
                          if($trend_product['price_drop_to']>0)
                          {
                             $pageclick['price'] = isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '';
                          }else{
                             $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                          }

                        }else{
                          $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                        }



                       //$pageclick['position'] = $i;
                       // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug.'/'.$trend_branname.'/'.$trend_sellername ;
                       $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug;

                       /****************for restriction and out of stock icon*********/

                        $firstcat_id = isset($trend_product['first_level_category_id'])?$trend_product['first_level_category_id']:'';
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

                       $restrictseller_id   = isset($trend_product['user_id'])?$trend_product['user_id']:'';

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

                       /***********for restriction and out of stock icon************/

                    $isblur =0;


              @endphp


             <li>

                  @if(isset($login_user) && $login_user == true && $login_user->inRole('buyer'))
                   @if($checkfirstcat_flag==0)
                    {{--  <div class="statelaw-label">
                     <i class="fa fa-check"></i> state law

                     </div> --}}
                   @endif
                  @else
                     {{-- <div class="statelaw-label">
                      <i class="fa fa-check"></i> state law
                     </div> --}}
                  @endif



                   @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                        <div class="out-of-stock trending-left" >
                          <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                        </div>
                   @endif




                @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                    <!--------------outofstock--------------->
                       @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                           @if($checkfirstcat_flag==1)
                            @php $isblur=1; @endphp
                              {{-- <div class="out-of-stock">
                               <span class="red-text">
                                 Restricted
                               </span>
                             </div> --}}

                           @endif
                      @else
                        {{-- <div class="out-of-stock">  --}}

                            @if($checkfirstcat_flag==1)
                              @php $isblur=1; @endphp
                            {{--  <span class="red-text">
                               Restricted
                             </span> --}}
                            @else
                              @php $isblur=1; @endphp
                              {{-- <span class="red-text">Out of stock</span> --}}
                            @endif

                        {{--  </div> --}}
                      @endif
                    <!---------------outofstock-------------->

                  @else
                    {{-- <div class="out-of-stock">  --}}

                        @if($checkfirstcat_flag==1)
                         @php $isblur=1; @endphp
                           {{-- <span class="red-text">
                             Restricted
                           </span> --}}
                        @else
                          @php $isblur=1; @endphp
                         {{--  <span class="red-text">Out of stock</span> --}}
                        @endif

                    {{-- </div> --}}
                  @endif

                <div class="top-rated-brands-list">

                     <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['id'])?base64_encode($trend_product['id']):'0'}}/{{ $product_title_slug }}" title="{{ ucfirst($trend_product['product_name']) }}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">


                      <div class="img-rated-brands">


                          <div  @if(isset($isblur) && $isblur==1) class="thumbnailss blurclass" @else class="thumbnailss" @endif>

                             <!----------Show out of stock on blur product------------------->
                                 @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                                     @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                                         @if($checkfirstcat_flag==1)
                                            <div class="chow-outofstock-hm">Restricted</div>
                                         @endif
                                    @else

                                          @if($checkfirstcat_flag==1)
                                           <div class="chow-outofstock-hm">Restricted</div>
                                          @else
                                             <div class="chow-outofstock-hm">Out of stock</div>
                                          @endif

                                    @endif

                                 @else


                                      @if($checkfirstcat_flag==1)
                                          <div class="chow-outofstock-hm">Restricted</div>
                                      @else
                                        <div class="chow-outofstock-hm">Out of stock</div>
                                      @endif


                                @endif
                             <!---------End out of stock on blur product-------------->





                                @if(isset($trend_product['product_images_details'][0]['image']) &&file_exists(base_path().'/uploads/product_images/'.$trend_product['product_images_details'][0]['image']))

                                @php
                                  $final_product_image = image_resize('/uploads/product_images/'.$trend_product['product_images_details'][0]['image'],190,190);
                                @endphp

                             {{--    <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_images_details'][0]['image']}}" class="portrait" alt="{{ $product_title }}" /> --}}

                                <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$final_product_image}}" />

                                @else
                                  <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/assets/images/default-product-image.png')}}" class="portrait" alt="{{ $product_title }}" />

                                @endif
                            </div>
                        <div class="content-brands">
                             @php
                            // $connabinoids_name = get_product_cannabinoids_name($trend_product['id']);
                            $connabinoids_name = get_product_cannabinoids($trend_product['id']);
                            @endphp
                            @if(isset($connabinoids_name) && count($connabinoids_name) > 0)
                                  <div class="inlineblock-view-cannabionoids">
                                     <span class="inline-trend-product">
                                          @php
                                            $i = 0;
                                            //$numItems = count($connabinoids_name);
                                          @endphp
                                            @foreach($connabinoids_name as $cann)


                                            <span class="oil-category-cannabinoids"> {{$cann['name']}} {{floatval($cann['percent'])}}%</span>
                                              {{-- @if(++$i === $numItems)
                                                <span></span>
                                              @else
                                                <span class="dot-verticle">.</span>
                                              @endif --}}

                                            @endforeach
                                      </span>
                                  </div>
                            @endif


                            <div class="title-chw-list">

                                  <span class="titlename-list">
                                  {{ isset($trend_product['id'])?get_product_name($trend_product['id']):''  }}
                                  </span>
                            </div>


                              <div class="price-listing pricestatick viewinlineblock">
                                    @if(isset($trend_product['price_drop_to']))
                                      @if($trend_product['price_drop_to']>0)
                                       @php
                                       if(isset($product['percent_price_drop']) && $product['percent_price_drop']=='0.000000')
                                       {
                                       $percent_price_drop = calculate_percentage_price_drop($trend_product['id'],$trend_product['unit_price'],$trend_product['price_drop_to']);
                                       $percent_price_drop = floor($percent_price_drop);
                                       }
                                       else
                                       {
                                        $percent_price_drop = floor($trend_product['percent_price_drop']);
                                       }
                                       @endphp
                                        <span class="unitpriceclass">${{isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '0'}} </span>
                                        <del class="pricevies inline-del">

                                        ${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}}
                                      </del>
                                     {{--  <div class="inlineoff-div">({{$percent_price_drop}}% off)</div> --}}


                                      @else
                                        <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                        <del class="pricevies hidepricevies"></del>

                                      @endif
                                    @else
                                    <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                       <del class="pricevies hidepricevies"></del>


                                    @endif
                               </div>
                                 <!-----------truck---------------->
                                  @if(isset($trend_product['shipping_type']) && $trend_product['shipping_type']==0)
                                   @php
                                        $setshipping = "";
                                        if($trend_product['shipping_type']==0)
                                        { $setshipping = "Free Shipping";
                                        }
                                        else{
                                          $setshipping = "Flat Shipping";
                                        }
                                   @endphp
                                   <div class="freeshipping-class" title="{{ $setshipping }}">
                                       Free Shipping
                                  </div>
                                  @endif
                                  <!----------truck----------------->

                            <div class="starthomlist "  @if($avg_rating>0) title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."
                           @endif>
                              @if($avg_rating>0 && isset($rating))

                                <img class="lozad" src="{{url('/')}}/assets/front/images/star/{{$rating}}.svg" alt="{{$rating}}.svg" title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."/>

                                 <!-------review------------>
                                 <span class="str-links starcounts" title="@if($total_review==1){{$total_review}} Rating @elseif($total_review>1){{ $total_review }} Ratings @endif">
                                  {{-- @if($total_review==1)  {{ $total_review }} Rating
                                  @elseif($total_review>1){{ $total_review }} Ratings
                                  @endif --}}

                                  {{ isset($avg_rating)?$avg_rating:'' }}
                                  @if(isset($total_review)) ({{ $total_review }}) @endif


                                 </span>
                                 <!--------review--------------->
                              @endif
                            </div><!--end div of rating--->

                            <!--coupon code text div-->
                                @php

                                  $get_available_coupon = [];
                                  $get_available_coupon = get_coupon_details($trend_product['user_id']);
                                @endphp

                                @if(isset($get_available_coupon) && count($get_available_coupon)>0)

                                <div class="couponsavailable">Coupons Available</div>

                                @endif
                            <!------------------------>

                            <div class="inlineblock-view">
                               {{-- @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                                  <div class="home_chow_choice chow_choice font-small circle-font-small-chow" style="margin-left: 0px">
                                    <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                                  </div>
                                @endif  --}}

                               {{--  @if(isset($is_besesellerbest) && $is_besesellerbest!="" && $is_besesellerbest==1)
                                  <div class="home_bestseller chow_choice-orange font-small circle-font-small" >
                                    <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow-arrow-icon-tag.png" alt=""> Best Seller</span>
                                  </div>
                                @endif --}}


                                  <!-----------truck---------------->
                                  @if(isset($trend_product['product_details']['shipping_type']) && $trend_product['product_details']['shipping_type']==0)
                                   @php
                                        $setshipping = "";
                                        if($trend_product['product_details']['shipping_type']==0)
                                        { $setshipping = "Free Shipping";
                                        }
                                        else{
                                          $setshipping = "Flat Shipping";
                                        }
                                   @endphp
                                   <div class="truck-icons" title="{{ $setshipping }}">
                                  <div class="freedrusd">Free Shipping </div> <img src="{{url('/')}}/assets/front/images/truck-icon.png" alt="Free Shipping">
                                  </div>
                                  @endif
                                  <!----------truck----------------->


                              </div>

                             {{--  <div class="inlineblock-view-cannabionoids">
                                  @php
                                  $connabinoids_name = get_product_cannabinoids_name($trend_product['id']);
                                  @endphp
                                  <span class="inline-trend-product"> {{$connabinoids_name}}</span>
                              </div> --}}



                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li>

            @php
             $i++;
            @endphp

         @endforeach
        </ul>
    </div>


  @endif

<!-- 
     <div class="" id="you_may_likes_loader" style="display: none;">

        <ul class="f-cat-below7">
  
          @for($i=0;$i<4;$i++)
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
            
          @endfor  
       
        </ul>

      </div>

      <div class="" id="you_may_likes_id" style="display: none;"> 
        
      </div> -->

</div>
<!----------------end---product you may like---------------------------------->




<!----------------------trending on chow section from admin side--------------->

@php
 
if(isset($site_setting_arr) && !empty($site_setting_arr) && $site_setting_arr['trendingproduct_status']==1){
@endphp

 @if(isset($is_trending_product_arr) && count($is_trending_product_arr)>0)

<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>
<div class="">
<div class="top-rated-brands-main homepagenewlistings trending-products-cls-home">
{{--  @if(isset($is_trending_product_arr) && count($is_trending_product_arr)>0)
 --}}
 <div class="toprtd non-mgts viewall-btns-idx toprated-view">Trending on Chow

          @php
          if(isset($is_trending_product_arr) && count($is_trending_product_arr)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';
          @endphp

         <a href="{{ url('/') }}/search" class="{{ $class }}" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>
        <div class="featuredbrands-flex trendingproducts-section ">
          <ul @if(isset($is_trending_product_arr) && count($is_trending_product_arr)<=$device_count)
             class="f-cat-below7"

            @elseif(isset($is_trending_product_arr) && count($is_trending_product_arr)>$device_count)
              id="flexiselDemo44"
           @endif
         >
            @php

                $chows_brandname='';
                $chows_sellername ='';
                $is_besesellercc ='';
                $pageclick=[];
                $checkfirstcat_flag = 0;
                $avg_rating = $rating = '';


            @endphp
            @foreach($is_trending_product_arr as $trend_product)
               @php

                        $avg_rating = get_avg_rating($trend_product['id']);

                        // if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}else
                        // if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}

                        $rating = isset($avg_rating)? get_avg_rating_image($avg_rating):'';


                        $total_reviews = get_total_reviews($trend_product['id']);
                        if($total_reviews>0)
                          $total_reviews = $total_reviews;
                        else
                           $total_reviews = '';


                     $is_besesellercc = check_isbestseller($trend_product['id']);

                     $choice_prod_concentration  = isset($trend_product['per_product_quantity']) ? $trend_product['per_product_quantity']. 'mg' : '' ;



                     /****************for restriction and out of stock icon*********/

                        $firstcat_id = isset($trend_product['first_level_category_id'])?$trend_product['first_level_category_id']:'';
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

                       $restrictseller_id   = isset($trend_product['user_id'])?$trend_product['user_id']:'';

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

                       /***********for restriction and out of stock icon************/



              @endphp


             <li>


               <div class="out-of-stock trending-left">

                  <span class="red-text"><img src="{{url('/')}}/assets/front/images/trending-icon-chow.svg" alt=""> Trending</span>

                </div>

                  @php
                    $isblur =0;
                  @endphp

                  @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                       @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                           @if($checkfirstcat_flag==1)
                           {{--  <div class="out-of-stock">
                             <span class="red-text">
                               Restricted
                             </span>
                           </div> --}}
                           @php $isblur =1; @endphp

                           @endif
                      @else
                       {{--  <div class="out-of-stock">  --}}

                            @if($checkfirstcat_flag==1)
                             {{-- <span class="red-text">
                               Restricted
                             </span> --}}
                              @php $isblur =1; @endphp
                            @else
                              {{-- <span class="red-text">Out of stock</span> --}}
                               @php $isblur =1; @endphp
                            @endif

                        {{--  </div> --}}
                      @endif

                  @else
                    {{-- <div class="out-of-stock">  --}}

                        @if($checkfirstcat_flag==1)
                         {{-- <span class="red-text">
                           Restricted
                         </span> --}}
                          @php $isblur =1; @endphp
                        @else
                          {{-- <span class="red-text">Out of stock</span> --}}
                           @php $isblur =1; @endphp
                        @endif

                    {{-- </div> --}}
                  @endif

                <div class="top-rated-brands-list">
                   @php

                      $product_title = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                      $product_title_slug = str_slug($product_title);

                      $chows_brandname = isset($trend_product['get_brand_detail']['name'])?str_slug($trend_product['get_brand_detail']['name']):'';
                       $chows_sellername = isset($trend_product['get_seller_additional_details']['business_name'])?str_slug($trend_product['get_seller_additional_details']['business_name']):'';


                        $pageclick['name'] = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                       $pageclick['id'] = isset($trend_product['id']) ? $trend_product['id'] : '';
                       $pageclick['brand'] = isset($trend_product['brand']) ? get_brand_name($trend_product['brand']) : '';
                       $pageclick['category'] = isset($trend_product['first_level_category_id']) ? get_first_levelcategorydata($trend_product['first_level_category_id']) : '';

                       if(isset($trend_product['price_drop_to']))
                        {
                          if($trend_product['price_drop_to']>0)
                          {
                              $pageclick['price'] = isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '';
                          }else{
                             $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                          }

                        }else{
                          $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                        }


                      // $pageclick['position'] = $i;
                       $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug.'/'.$chows_brandname.'/'.$chows_sellername ;


                    @endphp

                   <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['id'])?base64_encode($trend_product['id']):'0'}}/{{ $product_title_slug }}/{{ $chows_brandname }}/{{ $chows_sellername }}" title="{{ ucfirst($trend_product['product_name']) }}"  onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">
                      <div class="img-rated-brands">


                        <div  @if(isset($isblur) && $isblur==1) class="thumbnailss blurclass" @else class="thumbnailss" @endif>

                            <!------show restricted and out of stock on blured product--------->
                               @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                                     @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                                         @if($checkfirstcat_flag==1)
                                           <div class="chow-outofstock-hm">Restricted</div>
                                         @endif
                                     @else

                                          @if($checkfirstcat_flag==1)
                                            <div class="chow-outofstock-hm">Restricted</div>
                                          @else
                                              <div class="chow-outofstock-hm">Out of stock</div>

                                          @endif

                                    @endif

                                @else

                                      @if($checkfirstcat_flag==1)
                                       <div class="chow-outofstock-hm">Restricted</div>
                                      @else
                                       <div class="chow-outofstock-hm">Out of stock</div>
                                      @endif

                                @endif

                            <!--end--show restricted and out of stock on blured product------>


                              @if(file_exists(base_path().'/uploads/product_images/'.$trend_product['product_images_details'][0]['image']) && isset($trend_product['product_images_details'][0]['image']))

                              @php
                               $final_product_image = image_resize('/uploads/product_images/'.$trend_product['product_images_details'][0]['image'],190,190);
                              @endphp

                              {{--   <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_images_details'][0]['image']}}" class="portrait" alt="{{ $product_title }}" /> --}}

                              <img class="lozad" src="{{$final_product_image}}" class="portrait" alt="{{ $product_title }}" />

                              @else

                                <img class="lozad"  src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/assets/images/default-product-image.png')}}" class="portrait" alt="{{ $product_title }}" />

                              @endif

                        </div>
                        <div class="content-brands">
                           @php
                            // $connabinoids_name = get_product_cannabinoids_name($trend_product['id']);

                            $connabinoids_name = get_product_cannabinoids($trend_product['id']);
                            @endphp
                            @if(isset($connabinoids_name) && count($connabinoids_name) > 0)
                                  <div class="inlineblock-view-cannabionoids">
                                     <span class="inline-trend-product">
                                          @php
                                            $i = 0;
                                            // $numItems = count($connabinoids_name);
                                          @endphp
                                            @foreach($connabinoids_name as $cann)

                                               <span class="oil-category-cannabinoids"> {{$cann['name']}} {{floatval($cann['percent'])}}%</span>

                                             {{--  @if(++$i === $numItems)
                                                <span></span>
                                              @else
                                                <span class="dot-verticle">.</span>
                                              @endif --}}

                                            @endforeach
                                      </span>
                                  </div>
                            @endif
                            <div class="title-chw-list">
                                <span class="titlename-list">
                                {{ isset($trend_product['id'])?get_product_name($trend_product['id']):''  }}
                                </span>
                            </div>



                              <div class="price-listing pricestatick viewinlineblock">
                                    @if(isset($trend_product['price_drop_to']))
                                      @if($trend_product['price_drop_to']>0)
                                         @php
                                           if(isset($trend_product['percent_price_drop']) && $trend_product['percent_price_drop']=='0.000000')
                                           {
                                           $percent_price_drop = calculate_percentage_price_drop($trend_product['id'],$trend_product['unit_price'],$trend_product['price_drop_to']);
                                           $percent_price_drop = floor($percent_price_drop);
                                           }
                                           else
                                           {
                                            $percent_price_drop = floor($trend_product['percent_price_drop']);
                                           }
                                       @endphp
                                       <span>${{isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '0'}} </span>
                                        <del class="pricevies inline-del">

                                        ${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}}
                                      </del>
                                      {{-- <div class="inlineoff-div"> ({{$percent_price_drop}}% off) </div> --}}


                                      @else
                                      <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                        <del class="pricevies hidepricevies"></del>

                                      @endif
                                    @else
                                    <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                       <del class="pricevies hidepricevies"></del>


                                    @endif
                               </div>
                               <!-----------truck---------------->
                                        @if(isset($trend_product['shipping_type']) && $trend_product['shipping_type']==0)
                                         @php
                                              $setshippingcc = "";
                                              if($trend_product['shipping_type']==0)
                                              { $setshippingcc = "Free Shipping";
                                              }
                                              else{
                                                $setshippingcc = "Flat Shipping";
                                              }
                                         @endphp
                                         <div class="freeshipping-class" title="{{ $setshippingcc }}">
                                          Free Shipping
                                        </div>
                                        @endif
                                      <!----------truck----------------->

                            <div class="starthomlist "  @if($avg_rating>0) title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."
                           @endif>
                              @if($avg_rating>0 && isset($rating))
                                {{-- <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.svg" alt="star-rate-{{$rating}}.svg"  title="This rating is a combination of all ratings on chow in addition to ratings on vendor site."/> --}}
                                <img class="lozad" src="{{url('/')}}/assets/front/images/star/{{$rating}}.svg" alt="{{$rating}}.svg"  title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."/>
                                 <!-------review------------>

                                 <span class="str-links starcounts" title="@if($total_reviews==1){{$total_reviews}} Rating @elseif($total_reviews>1){{ $total_reviews }} Ratings @endif">
                                  {{-- @if($total_reviews==1)  {{ $total_reviews }} Rating
                                  @elseif($total_reviews>1){{ $total_reviews }} Ratings
                                  @endif --}}
                                  {{ isset($avg_rating)?$avg_rating:'' }}
                                  @if(isset($total_reviews)) ({{ $total_reviews }}) @endif
                                 </span>
                                 <!--------review--------------->
                              @endif
                            </div><!--end div of rating--->


                            <!--coupon code text div-->

                                @php
                                 $get_available_coupon = [];
                                  $get_available_coupon = get_coupon_details($trend_product['user_id']);
                                @endphp

                                @if(isset($get_available_coupon) && count($get_available_coupon)>0)

                                <div class="couponsavailable">Coupons Available</div>

                                @endif
                            <!------------------------>

                            {{--  <div class="inlineblock-view-cannabionoids">
                                  @php
                                  $connabinoids_name = get_product_cannabinoids_name($trend_product['id']);
                                  @endphp
                                 <span class="inline-trend-product"> {{$connabinoids_name}}</span>
                              </div> --}}



                            <!--------------cc-and best seller------------------->
                                {{--  <div class="inlineblock-view">
                                    @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                                        <div class="home_chow_choice chow_choice font-small circle-font-small-chow" style="margin-left: 0px">
                                          <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                                        </div>
                                    @endif

                                    @if(isset($is_besesellercc) && $is_besesellercc!="" && $is_besesellercc==1)
                                      <div class="home_bestseller chow_choice-orange font-small circle-font-small">
                                       <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow-arrow-icon-tag.png" alt=""> Best Seller</span>
                                      </div>
                                    @endif

                                 </div>    --}}
                                <!-----------end cc and best seller--------------->

                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li>
         @endforeach
        </ul>
    </div>

</div>
</div>
@endif

@php
 }//if trendingproduct_status status
@endphp


<!--   <div class="" id="trending_chow_loader" style="display: none;">

        <ul class="f-cat-below7">
  
          @for($i=0;$i<4;$i++)
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
            
          @endfor  
       
        </ul>

    </div>


<div class="" id="trending_chow_id" style="display: none;">
  
</div> -->


 <!---------------end trending on chow  from admin side-------------------->




<!-------------start--highlight section------------------------>

<!--  <div class="" id="highlight_section_id"></div> -->


@if(isset($arr_highlights) && count($arr_highlights) > 0)
<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>
@php
  $highlight_res_header='';
  $get_highlight_header = get_highlight_header();
  if(isset($get_highlight_header) && !empty($get_highlight_header))
  {
    $highlight_res_header = $get_highlight_header;
  }
@endphp

@if(isset($highlight_res_header) && !empty($highlight_res_header))
 <div class="header-txt-chow"> @php echo $highlight_res_header @endphp</div>
@endif
<!-------------end--highlight header-------------------------->

<!-------------start--highlight subheader------------------------>

@php
  $highlight_res_subheader='';
  $get_highlight_subheader = get_highlight_subheader();
  if(isset($get_highlight_subheader) && !empty($get_highlight_subheader))
  {
    $highlight_res_subheader = $get_highlight_subheader;
  }
@endphp

@if(isset($highlight_res_subheader) && !empty($highlight_res_subheader))
 <div class="subheader-txt-chow"> @php echo $highlight_res_subheader @endphp</div>
@endif

@endif
<!-------------end--highlight subheader-------------------------->

</div>
<!-------------start highlight------------------------------------>
@if(isset($arr_highlights) && count($arr_highlights) > 0)
<div class="boxhomepage-bnr highlight-sec">
  <div class="container">
    <div class="row">
      @foreach($arr_highlights as $highlight)
        <div class="col-xd-6 col-sm-4 col-md-4 col-lg-4">
          <div class="categry-main-topview">
            <div class="categry-main-topview-icon">
              @if(file_exists(base_path().'/uploads/highlights/'.$highlight['hilight_image']) && isset($highlight['hilight_image']))
                 
                @php
                  $highlight_image = '';
                  $highlight_image = image_resize('/uploads/highlights/'.$highlight['hilight_image'],100,100);
                @endphp

                {{--<img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/highlights/{{$highlight['hilight_image']}}"
                  alt="{{ isset( $highlight['title'])?ucwords($highlight['title']):''}}" /> --}}

                <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$highlight_image}}"
                  alt="{{ isset( $highlight['title'])?ucwords($highlight['title']):''}}" />  

              @endif

              {{-- <img src="{{url('/')}}/assets/front/images/thousands-of-items-icon.png" alt="" /> --}}
            </div>
            <div class="categry-main-topview-title">{{ isset( $highlight['title'])? ucwords($highlight['title']):''}}</div>
            <div class="categry-main-topview-contant">{{ isset( $highlight['description'])?$highlight['description']:''}}</div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endif

<!-----------end highlight section-------------------------------------->




<!---------------------------shop by gategory section----------------------------------->


       <div class="adclass-maindiv newslider-updated-categories homepagecircles">
        <div class="container">

              <div class="promotions-updatepg featuredviewallbutton top-rated-brands-main">

              <div class="toprtd viewall-btns-idx">Shop by Category
                 <a href="{{ url('/') }}/search" class="butn-def" title="View all">View All</a>
              </div>


                @php

                  if(isset($arr_featured_category) && count($arr_featured_category)<=7)
                  $class = 'butn-def viewall-product';
                  else
                  $class = 'butn-def';
                  @endphp
                  <div class="featuredcategories-four">

                    <div class="featuredbrands-flex trendingproducts-section tprtd-procudt">
                      <ul id="flexiselDemo86">
                         @foreach($arr_featured_category as $featured_category)
                        <li>
                        <div class="categories-four-list">
                          @php
                            $category_name = isset($featured_category['product_type'])?$featured_category['product_type']:'';
                            $category_name = str_replace(" ", "-", $category_name);
                            $category_name = str_replace("-&-", "-and-", $category_name);

                            @endphp
                            <a href="{{ url('/') }}/search?category_id={{ $category_name }}" class="promotionslist whitefont">
                            {{-- <a href="{{ url('/') }}/search?category_id={{ base64_encode($featured_category['id']) }}" class="promotionslist whitefont"> --}}
                            <div class="image-queres-box">

                              @if(file_exists(base_path().'/uploads/first_category/'.$featured_category['image']) && isset($featured_category['image']))

                              @php
                               $shop_by_category_image = image_resize('/uploads/first_category/'.$featured_category['image'],238,238);
                              @endphp

                             {{--   <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/first_category/{{ $featured_category['image'] }}"  alt="{{ $featured_category['product_type'] }}" /> --}}

                            {{--   <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$shop_by_category_image}}"  alt="{{ $featured_category['product_type'] }}" /> --}}


                            <img  src="{{url('/')}}/uploads/first_category/{{ $featured_category['image'] }}"  alt="{{ $featured_category['product_type'] }}" />

                            @endif

                            </div>
                            <div class="promo-block--content-wrapper">

                          </div>
                          </a>
                          <div class="content-brands">
                                <div class="titlebrds"> {{ $featured_category['product_type'] }}</div>
                            </div>
                        </div>
                         </li>
                     @endforeach
                      </ul>
                    </div>

                    <div class="clearfix"></div>
                  
                  </div>

                

            <!--   <div class="" id="shop_bycategory_loader" style="display: none;">

                    <ul class="f-cat-below7">
              
                      @for($i=0;$i<4;$i++)
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
                        
                      @endfor  
                   
                    </ul>

                </div>

                <div class="" id="shop_bycategory_id" style="display: none;">
                  
                </div> -->

              </div>
            </div>
         </div> <!------newslider-updated-categories------------->




  <!----------------------------end shop by category----------------------------------------->



<div class="container">

   <!--Slider section start here-->
  <div class="top-rated-brands-main homepagenewlistings padding-bottom-spacing-none">

  <div class="homesliderlist" style="display: none;">
   <ul id="flexiselDemo55">
   @if(!empty($arr_slider_images) && count($arr_slider_images)>0)
      @foreach($arr_slider_images as $slider)
        @foreach($slider as $k=>$slide)
                <li>
                    <div class="top-rated-brands-list">
                        <div class="img-rated-brands">
                          <div class="content-brands">
                                <div class="titlebrds">{{ isset($slide['title'])?$slide['title']:''}}</div>
                            </div>
                            <div class="thumbnailss">
                                <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}" class="portrait" alt="Slider Image" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </li>
                    @endforeach
       @endforeach
    @endif

    </ul>

  </div>



   @if(isset($banner_images_data) && !empty($banner_images_data))

     @if(isset($banner_images_data['banner_image4_desktop']) && !empty($banner_images_data['banner_image4_desktop']) && isset($banner_images_data['banner_image4_mobile']) && !empty($banner_images_data['banner_image4_mobile']))
  	<div class="clearfix"></div>
  	<div class="space100"></div>
  	<div class="clearfix"></div>
      <div class="adclass-maindiv">
      
           <a  @if(isset($banner_images_data['banner_image4_link4']))  href="{{ $banner_images_data['banner_image4_link4'] }}" target="_blank" @else  href="#" @endif>
            <figure class="cw-image__figure">
               <picture>

                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image4_mobile']) && isset($banner_images_data['banner_image4_mobile']))

                 @php
                   $slider_mobile_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image4_mobile'],345,79);
                 @endphp


                  <source  type="image/png" src="{{$slider_mobile_img}}" media="(max-width: 621px)">

                  <source  type="image/jpg" src="{{$slider_mobile_img}}" media="(max-width: 621px)">

                  <source  type="image/jpeg" src="{{$slider_mobile_img}}" media="(max-width: 621px)">
                    
                 @endif

                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image4_desktop']) && isset($banner_images_data['banner_image4_desktop']))

              
                  @php
                    $slider_desktop_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image4_desktop'],1210,276);
                  @endphp  

  

                  <source  type="image/png" src="{{$slider_desktop_img}}" media="(min-width: 622px) ">

                  <source  type="image/jpg" src="{{$slider_desktop_img}}" media="(min-width: 622px) ">

                  <source  type="image/jpeg" src="{{$slider_desktop_img}}" media="(min-width: 622px) ">  

                 @endif

                  @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image4_desktop']) && isset($banner_images_data['banner_image4_desktop']))

                    @php
                       $slider_desktop_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image4_desktop'],1210,276);
                    @endphp

              
                     <img class="cw-image cw-image--loaded obj-fit-polyfill" alt="Banner image" aria-hidden="false"  src="{{$slider_desktop_img}}">

                     <div class="clearfix"></div>
              	<div class="space100"></div>
              	<div class="clearfix"></div>
                  @endif

                </picture>
            </figure>
          </a>
        </div>

     @endif
   @endif


  <!-------------end------between shop by category and shop by effect------------------>



	<!-- -------------start shop by reviews--------------------------------------- -->

	<div class="clearfix"></div>
	<div class="space100"></div>
	<div class="clearfix"></div>



@php

$login_user = Sentinel::check();

$isMobileDevice=0;
$isMobileDevice= isMobileDevice();

if($isMobileDevice==1){

    $device_count = 2;
    $chowwatch_device_count = '';
}
else {
    $device_count = 4;
    $chowwatch_device_count = 3;
}

@endphp



@if(isset($arr_shop_by_effect) && count($arr_shop_by_effect)>0)
<div class="top-rated-brands-main homepagenewlistings trending-products-cls-home shopbyreviewslider">
    <div class="toprtd non-mgts viewall-btns-idx toprated-view">Shop by Reviews
        <div class="clearfix"></div>
    </div>

    <div class="featuredbrands-flex trendingproducts-section">
      <div class="nbs-flexisel-container">
        <div class="nbs-flexisel-inner">
          <ul
            @if(isset($arr_shop_by_effect) && count($arr_shop_by_effect)<=$device_count)
             class="f-cat-below7"
            @elseif(isset($arr_shop_by_effect) && count($arr_shop_by_effect)>$device_count)
              id="flexisel792"
            @endif
            >
    @foreach($arr_shop_by_effect as $shop_by_effect)
            <li>
              <div class="shop-by-effect-main-parnts li-review-none">
                        <div class="shop-by-effect-main">
                          <a href="{{ isset( $shop_by_effect['link_url'])?ucwords($shop_by_effect['link_url']):''}}" >
                            <div class="shop-by-effect-img">
                              @if(file_exists(base_path().'/uploads/shop_by_effect/'.$shop_by_effect['image']) && isset($shop_by_effect['image']))

                              @php
                                   
                                $shop_by_reviews_image = image_resize('/uploads/shop_by_effect/'.$shop_by_effect['image'],283,220);

                              @endphp

                             {{--  <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/shop_by_effect/{{$shop_by_effect['image']}}"
                              alt="{{ isset( $shop_by_effect['title'])?$shop_by_effect['title']:''}}" /> --}}

                              <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$shop_by_reviews_image}}"
                              alt="{{ isset( $shop_by_effect['title'])?$shop_by_effect['title']:''}}" />

                              @endif

                            </div>
                            <div class="shop-by-effect-content">
                                <div class="titlebrds">{{ isset( $shop_by_effect['title'])?ucwords($shop_by_effect['title']):''}}</div>
                                <span>{{ isset( $shop_by_effect['subtitle'])?$shop_by_effect['subtitle']:''}}</span>
                              </div>
                          </a>
                        </div>
                  </div>
            </li>
             @endforeach
          </ul>
        </div>
      </div>
    </div>
</div>
@endif


 <!--    <div class="" id="shop_by_reviews_loader" style="display: none;">

    <ul class="f-cat-below7">

      @for($i=0;$i<4;$i++)
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
        
      @endfor  
   
    </ul>

  </div>

	<div class="" id="shop_by_reviews_id" style="display: none;">
	  
	</div>
 -->

	<!-----------------------------end shop by reviews---------------------------------------------->


	<!----------------start-shop by spectrum------------------------------->


@if(isset($arr_shop_by_spectrum) && count($arr_shop_by_spectrum)>0)
<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>
  <div class="toprtd viewall-btns-idx">Shop by Spectrum
    {{-- <span class="shopbyeffect-subheading">(Solely based of customer reviews)</span> --}}
  </div>
<div class="shop-by-effect-main-parnts">
      @foreach($arr_shop_by_spectrum as $shop_by_spectrum)
        <div class="shop-by-effect-cols shop-by-spectrum">

          <div class="shop-by-effect-main">
            <a href="{{ isset( $shop_by_spectrum['link_url'])?ucwords($shop_by_spectrum['link_url']):''}}" >
              <div class="shop-by-effect-img">
                @if(file_exists(base_path().'/uploads/shop_by_spectrum/'.$shop_by_spectrum['image']) && isset($shop_by_spectrum['image']))
                <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/shop_by_spectrum/{{$shop_by_spectrum['image']}}"
                alt="{{ isset( $shop_by_spectrum['title'])?ucwords($shop_by_spectrum['title']):''}}" />
                @endif

              </div>
              <div class="shop-by-effect-content">
                  <div class="titlebrds">{{ isset( $shop_by_spectrum['title'])?ucwords($shop_by_spectrum['title']):''}}</div>
                  <span>{{ isset( $shop_by_spectrum['subtitle'])?$shop_by_spectrum['subtitle']:''}}</span>
                </div>
            </a>
          </div>
        </div>
      @endforeach
    </div>
@endif

<!--   
  <div class="" id="shop_by_spectrum_loader" style="display: none;">

    <ul class="f-cat-below7">

      @for($i=0;$i<4;$i++)
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
        
      @endfor  
   
    </ul>

  </div>

	<div class="" id="shop_by_spectrum" style="display: none;">
	  
	</div> -->

	<!-----------------end of shop by spectrum------------------------------->


	<!-----------start---Above best seller banner------------------------->



   @if(isset($banner_images_data) && !empty($banner_images_data))

     @if(isset($banner_images_data['banner_image2_desktop']) && !empty($banner_images_data['banner_image2_desktop']) && isset($banner_images_data['banner_image2_mobile']) && !empty($banner_images_data['banner_image2_mobile']))
  
         <div class="adclass-maindiv">
           <a  @if(isset($banner_images_data['banner_image2_link2']))  href="{{ $banner_images_data['banner_image2_link2'] }}" target="_blank" @else  href="#" @endif>
            <figure class="cw-image__figure">
               <picture>

                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image2_mobile']) && isset($banner_images_data['banner_image2_mobile']))
                <div class="clearfix"></div>
                <div class="space100"></div>
                <div class="clearfix"></div>

                @php
                   $slider_mobile2_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image2_mobile'],345,88);
                 @endphp

     
                  <source  type="image/png" src="{{$slider_mobile2_img}}" media="(max-width: 621px)" >

                  <source type="image/jpg" src="{{$slider_mobile2_img}}" media="(max-width: 621px)" >

                  <source type="image/jpeg" src="{{$slider_mobile2_img}}" media="(max-width: 621px)">

                 @endif

                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image3_desktop']) && isset($banner_images_data['banner_image3_desktop']))
                     <div class="clearfix"></div>
                     <div class="space100"></div>
                    <div class="clearfix"></div>

                  
                   @php
                   $slider_image3_desktop_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image3_desktop'],1170,300);
                 @endphp
     

                  <source  type="image/png" src="{{$slider_image3_desktop_img}}" media="(min-width: 622px) ">

                  <source  type="image/jpg" src="{{$slider_image3_desktop_img}}" media="(min-width: 622px) ">

                  <source  type="image/jpeg" src="{{$slider_image3_desktop_img}}" media="(min-width: 622px) "> 

                 @endif


                  @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image2_desktop']) && isset($banner_images_data['banner_image2_desktop']))

                    @php
                   
                      $slider_default_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image2_desktop'],1170,300);
                    @endphp

            
                    <img  class="cw-image cw-image--loaded obj-fit-polyfill" alt="Banner image" aria-hidden="false" src="{{$slider_default_img}}">
                  @endif

                </picture>
            </figure>
          </a>
       </div>
       <div class="clearfix"></div>
       <div class="space100"></div>
        <div class="clearfix"></div>
     @endif
   @endif








	<!------------end--Above best seller banner------------------------->




	<!------------end of trending products---------------------------->
	 

	<!---------------------------recommended by chow choice------------------------------------>




 @if(isset($chow_choice_product_arr) && count($chow_choice_product_arr)>0)
      <div class="toprtd non-mgts viewall-btns-idx toprated-view">Chow's Choice

          @php
          if(isset($chow_choice_product_arr) && count($chow_choice_product_arr)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';
          @endphp

         <a href="{{ url('/') }}/search?chows_choice=true" class="{{ $class }}" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>

        <div class="featuredbrands-flex trendingproducts-section ">
          <ul @if(isset($chow_choice_product_arr) && count($chow_choice_product_arr)<=$device_count)
             class="f-cat-below7"

            @elseif(isset($chow_choice_product_arr) && count($chow_choice_product_arr)>$device_count)
              id="flexiselDemo4"
           @endif
         >
            @php

                $chows_brandname='';
                $chows_sellername ='';
                $is_besesellercc ='';
                $pageclick=[];
                $checkfirstcat_flag = 0;
                $avg_rating = $rating = '';


            @endphp
            @foreach($chow_choice_product_arr as $trend_product)
               @php

                        $avg_rating = get_avg_rating($trend_product['id']);

                        // if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}else
                        // if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}
                        $rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';


                        $total_reviews = get_total_reviews($trend_product['id']);
                        if($total_reviews>0)
                          $total_reviews = $total_reviews;
                        else
                           $total_reviews = '';


                     $is_besesellercc = check_isbestseller($trend_product['id']);

                     $choice_prod_concentration  = isset($trend_product['per_product_quantity']) ? $trend_product['per_product_quantity']. 'mg' : '' ;



                     /****************for restriction and out of stock icon*********/

                        $firstcat_id = isset($trend_product['first_level_category_id'])?$trend_product['first_level_category_id']:'';
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

                       $restrictseller_id   = isset($trend_product['user_id'])?$trend_product['user_id']:'';

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

                       /***********for restriction and out of stock icon************/

                     $isblur=0;

              @endphp


             <li>

               @if(isset($login_user) && $login_user == true && $login_user->inRole('buyer'))
                   @if($checkfirstcat_flag==0)
                  {{--  <div class="statelaw-label">
                    <i class="fa fa-check"></i> state law
                   </div> --}}
                   @endif
               @else
                   {{--  <div class="statelaw-label">
                      <i class="fa fa-check"></i> state law
                   </div> --}}
               @endif


                @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)

                        <div class="out-of-stock trending-left" >
                          <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                        </div>
                   @endif



               @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                       @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                           @if($checkfirstcat_flag==1)
                            @php $isblur=1; @endphp
                              {{-- <div class="out-of-stock">
                               <span class="red-text">
                                 Restricted
                               </span>
                             </div> --}}

                           @endif
                      @else
                        {{-- <div class="out-of-stock"> --}}

                            @if($checkfirstcat_flag==1)
                             @php $isblur=1; @endphp
                               {{-- <span class="red-text">
                                 Restricted
                               </span> --}}
                            @else
                              @php $isblur=1; @endphp
                              {{-- <span class="red-text">Out of stock</span> --}}
                            @endif

                         {{-- </div> --}}
                      @endif

                  @else
                    {{-- <div class="out-of-stock">  --}}

                        @if($checkfirstcat_flag==1)
                         @php $isblur=1; @endphp
                           {{-- <span class="red-text">
                             Restricted
                           </span> --}}
                        @else
                          @php $isblur=1; @endphp
                          {{-- <span class="red-text">Out of stock</span> --}}
                        @endif

                    {{-- </div> --}}
                  @endif

                <div class="top-rated-brands-list">
                   @php
                      $product_title = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                      $product_title_slug = str_slug($product_title);

                      $chows_brandname = isset($trend_product['get_brand_detail']['name'])?str_slug($trend_product['get_brand_detail']['name']):'';
                       $chows_sellername = isset($trend_product['get_seller_additional_details']['business_name'])?str_slug($trend_product['get_seller_additional_details']['business_name']):'';


                        $pageclick['name'] = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                       $pageclick['id'] = isset($trend_product['id']) ? $trend_product['id'] : '';
                       $pageclick['brand'] = isset($trend_product['brand']) ? get_brand_name($trend_product['brand']) : '';
                       $pageclick['category'] = isset($trend_product['first_level_category_id']) ? get_first_levelcategorydata($trend_product['first_level_category_id']) : '';

                       if(isset($trend_product['price_drop_to']))
                        {
                          if($trend_product['price_drop_to']>0)
                          {
                              $pageclick['price'] = isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '';
                          }else{
                             $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                          }

                        }else{
                          $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                        }


                      // $pageclick['position'] = $i;
                       // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug.'/'.$chows_brandname.'/'.$chows_sellername ;
                       $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug;


                    @endphp

                   {{-- <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['id'])?base64_encode($trend_product['id']):'0'}}/{{ $product_title_slug }}/{{ $chows_brandname }}/{{ $chows_sellername }}" title="{{ ucfirst($trend_product['product_name']) }}"  onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})"> --}}
                   <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['id'])?base64_encode($trend_product['id']):'0'}}/{{ $product_title_slug }}" title="{{ ucfirst($trend_product['product_name']) }}"  onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">
                      <div class="img-rated-brands">


                          {{--  @if(isset($trend_product['is_age_limit']) && $trend_product['is_age_limit'] == 1 && isset($trend_product['age_restriction']))
                            <div class="label-list">
                              @php
                                if(isset($trend_product['age_restriction_detail']['age']) && $trend_product['age_restriction_detail']['age']!='')
                               {
                              @endphp
                                 {{ $trend_product['age_restriction_detail']['age']}}
                              @php
                               }
                              @endphp
                             </div>
                            @endif --}}



                          <div @if(isset($isblur) && $isblur==1) class="thumbnailss blurclass" @else class="thumbnailss" @endif>

                              <!--------show restricted or out of stock for blur product------->

                                  @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                                       @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                                           @if($checkfirstcat_flag==1)
                                               <div class="chow-outofstock-hm">Restricted</div>
                                           @endif
                                      @else

                                            @if($checkfirstcat_flag==1)
                                               <div class="chow-outofstock-hm">Restricted</div>
                                            @else
                                               <div class="chow-outofstock-hm">Out of stock</div>
                                            @endif

                                      @endif

                                  @else

                                        @if($checkfirstcat_flag==1)
                                          <div class="chow-outofstock-hm">Restricted</div>
                                        @else
                                          <div class="chow-outofstock-hm">Out of stock</div>
                                        @endif

                                  @endif
                              <!-----show restricted or out of stock for blur product------>





                                @if(file_exists(base_path().'/uploads/product_images/'.$trend_product['product_images_details'][0]['image']) && isset($trend_product['product_images_details'][0]['image']))

                              @php
                              
                               $final_product_image = image_resize('/uploads/product_images/'.$trend_product['product_images_details'][0]['image'],190,190);
                              @endphp

                               {{--  <img src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_images_details'][0]['image']}}" class="portrait lozad" alt="{{ $product_title }}" />
 --}}
                              {{-- <img src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$final_product_image}}" class="portrait lozad" alt="{{ $product_title }}" /> --}}


                              <img src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_images_details'][0]['image']}}" class="portrait" alt="{{ $product_title }}" />


                              @else
                               {{--  <img src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/assets/images/default-product-image.png')}}" class="portrait lozad" alt="{{ $product_title }}" /> --}}


                                <img src="{{url('/assets/images/default-product-image.png')}}" class="portrait" alt="{{ $product_title }}" />

                              @endif

                            </div>
                        <div class="content-brands">
                           @php
                                  // $connabinoids_name = get_product_cannabinoids_name($trend_product['id']);
                                  $connabinoids_name = get_product_cannabinoids($trend_product['id']);

                                  @endphp
                                  @if(isset($connabinoids_name) && count($connabinoids_name) > 0)
                                        <div class="inlineblock-view-cannabionoids">
                                           <span class="inline-trend-product">
                                                @php
                                                  $i = 0;
                                                  // $numItems = count($connabinoids_name);
                                                @endphp
                                                  @foreach($connabinoids_name as $cann)
                                                        <span class="oil-category-cannabinoids"> {{$cann['name']}} {{floatval($cann['percent'])}}%</span>

                                                    {{-- @if(++$i === $numItems)
                                                      <span></span>
                                                    @else
                                                      <span class="dot-verticle">.</span>
                                                    @endif --}}

                                                  @endforeach
                                            </span>
                                        </div>
                                  @endif

                            <div class="title-chw-list">
                              {{-- {{ isset($trend_product['get_brand_detail']['name'])? ucwords($trend_product['get_brand_detail']['name']):''  }}
                               @if(isset($trend_product['spectrum']))

                                     {{--  @if($trend_product['spectrum']=="0")
                                       <span class="line-vertical"></span><span class="space-spetm">Full Spectrum </span>
                                      @elseif($trend_product['spectrum']=="1")
                                       <span class="line-vertical"></span><span class="space-spetm">Broad Spectrum </span>
                                      @elseif($trend_product['spectrum']=="2")
                                       <span class="line-vertical"></span><span class="space-spetm">Isolate</span>
                                       @endif --}}

                                    {{-- @php
                                     $get_spectrum_val = get_spectrum_val($trend_product['spectrum']);
                                    @endphp

                                    {{ isset($get_spectrum_val['name'])?$get_spectrum_val['name']:'' }}

                                <span class="cbdclass">CBD </span> <span class="titlename-list">{{ ucwords($trend_product['product_name'])  }}</span>  --}}

                                <span class="titlename-list" asas >
                                {{ isset($trend_product['id'])?get_product_name($trend_product['id']):''  }}
                                </span>

                            </div>



                            {{--  <div class="titlebrds spacetoptitlebrds">{{ ucwords($trend_product['product_name'])  }}</div>  --}}

                            {{--  <div class="titlebrds by-ttlbrn"> <span>{{ isset($trend_product['get_brand_detail']['name'])? ucwords($trend_product['get_brand_detail']['name']):''  }}</span>
                              </div>

                              <span class="pro-concentration">
                                @if($choice_prod_concentration != 0)
                                  {{$choice_prod_concentration}}
                                @endif
                              </span>

                               @if(isset($trend_product['spectrum']))
                              <div class="spectrumsection">
                                      @if($trend_product['spectrum']=="0")
                                       <span class="line-vertical"></span><span class="space-spetm">Full Spectrum </span>
                                      @elseif($trend_product['spectrum']=="1")
                                       <span class="line-vertical"></span><span class="space-spetm">Broad Spectrum </span>
                                      @elseif($trend_product['spectrum']=="2")
                                       <span class="line-vertical"></span><span class="space-spetm">Isolate </span>
                                       @endif
                             </div>
                              @endif --}}

                              <div class="price-listing pricestatick viewinlineblock">
                                    @if(isset($trend_product['price_drop_to']))
                                      @if($trend_product['price_drop_to']>0)
                                         @php
                                           if(isset($trend_product['percent_price_drop']) && $trend_product['percent_price_drop']=='0.000000')
                                           {
                                           $percent_price_drop = calculate_percentage_price_drop($trend_product['id'],$trend_product['unit_price'],$trend_product['price_drop_to']);
                                           $percent_price_drop = floor($percent_price_drop);
                                           }
                                           else
                                           {
                                            $percent_price_drop = floor($trend_product['percent_price_drop']);
                                           }
                                       @endphp
                                       <span>${{isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '0'}} </span>
                                        <del class="pricevies inline-del">

                                        ${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}}
                                      </del>
                                     {{--  <div class="inlineoff-div"> ({{$percent_price_drop}}% off) </div> --}}


                                      @else
                                      <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                        <del class="pricevies hidepricevies"></del>

                                      @endif
                                    @else
                                    <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                       <del class="pricevies hidepricevies"></del>


                                    @endif
                               </div>
                               <!-----------truck---------------->
                                        @if(isset($trend_product['shipping_type']) && $trend_product['shipping_type']==0)
                                         @php
                                              $setshippingcc = "";
                                              if($trend_product['shipping_type']==0)
                                              { $setshippingcc = "Free Shipping";
                                              }
                                              else{
                                                $setshippingcc = "Flat Shipping";
                                              }
                                         @endphp
                                         <div class="freeshipping-class" title="{{ $setshippingcc }}">
                                          Free Shipping
                                        </div>
                                        @endif
                                      <!----------truck----------------->

                            <div class="starthomlist "  @if($avg_rating>0) title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."
                           @endif>
                              @if($avg_rating>0 && isset($rating))
                               {{--  <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.svg" alt="star-rate-{{$rating}}.svg"  title="This rating is a combination of all ratings on chow in addition to ratings on vendor site."/> --}}

                                <img class="lozad" src="{{url('/')}}/assets/front/images/star/{{$rating}}.svg" alt="{{$rating}}.svg"  title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."/>

                                 <!-------review------------>

                                 <span class="str-links starcounts" title="@if($total_reviews==1){{$total_reviews}} Rating @elseif($total_reviews>1){{ $total_reviews }} Ratings @endif">
                                  {{-- @if($total_reviews==1)  {{ $total_reviews }} Rating
                                  @elseif($total_reviews>1){{ $total_reviews }} Ratings
                                  @endif --}}
                                  {{ $avg_rating }}
                                  @if(isset($total_reviews)) ({{ $total_reviews }}) @endif
                                 </span>
                                 <!--------review--------------->
                              @endif
                            </div><!--end div of rating--->


                            <!--coupon code text div-->

                                @php
                                  $get_available_coupon = [];
                                  $get_available_coupon = get_coupon_details($trend_product['user_id']);
                                @endphp

                                @if(isset($get_available_coupon) && count($get_available_coupon)>0)

                                <div class="couponsavailable">Coupons Available</div>

                                @endif


                            <!------------------------>




                            <!--------------cc-and best seller------------------->
                                 <div class="inlineblock-view">
                                   {{--  @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                                        <div class="home_chow_choice chow_choice font-small circle-font-small-chow" style="margin-left: 0px">
                                          <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                                        </div>
                                    @endif --}}

                                    {{-- @if(isset($is_besesellercc) && $is_besesellercc!="" && $is_besesellercc==1)
                                      <div class="home_bestseller chow_choice-orange font-small circle-font-small">
                                       <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow-arrow-icon-tag.png" alt=""> Best Seller</span>
                                      </div>
                                    @endif --}}


                                      <!-----------truck---------------->
                                       {{--  @if(isset($trend_product['shipping_type']) && $trend_product['shipping_type']==0)
                                         @php
                                              $setshippingcc = "";
                                              if($trend_product['shipping_type']==0)
                                              { $setshippingcc = "Free Shipping";
                                              }
                                              else{
                                                $setshippingcc = "Flat Shipping";
                                              }
                                         @endphp
                                         <div class="truck-icons" title="{{ $setshippingcc }}">
                                           <div class="freedrusd">Free Shipping </div> <img src="{{url('/')}}/assets/front/images/truck-icon.png" alt="Free Shipping">
                                        </div>
                                        @endif --}}
                                      <!----------truck----------------->

                                        <!-- Lab results available Start -->
                                       <!--  @if(isset($trend_product['product_certificate']) && !empty($trend_product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$trend_product['product_certificate']) )
                                          <div class="labresults-class" style="margin-left: 0px">
                                           <span class="b-class-hide">Lab Results Available</span>
                                          </div>
                                        @endif   -->
                                      <!-- Lab results available End -->



                                 </div>


                                <!-----------end cc and best seller--------------->

                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li>
         @endforeach
        </ul>
    </div>

{{-- <hr> --}}
@endif

 
<!--   <div class="" id="chow_choice_loader" style="display: none;">

    <ul class="f-cat-below7">

      @for($i=0;$i<4;$i++)
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
        
      @endfor  
   
    </ul>

  </div>

	<div class="" id="chow_choice_id" style="display: none;">
	  
	</div>
 -->



	<!-- -------------------------end chow choice----------------------------------------------- -->




  <div class="clearfix"></div>
  <div class="space100"></div>
  <div class="clearfix"></div>




   @if(isset($banner_images_data) && !empty($banner_images_data))
     @if(isset($banner_images_data['banner_image1_desktop']) && !empty($banner_images_data['banner_image1_desktop']) && isset($banner_images_data['banner_image1_mobile']) && !empty($banner_images_data['banner_image1_mobile']))

        <div class="adclass-maindiv">
               <a  @if(isset($banner_images_data['banner_image1_link1']))  href="{{ $banner_images_data['banner_image1_link1'] }}" target="_blank" @else  href="#" @endif>
                <figure class="cw-image__figure">
                   <picture>

                     @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image1_mobile']) && isset($banner_images_data['banner_image1_mobile']))

                      @php
                        $slider_image1_mobile_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image1_mobile'],345,64);
                      @endphp

                

                      <source  type="image/png" src="{{$slider_image1_mobile_img}}" media="(max-width: 621px)" >

                      <source  type="image/jpg" src="{{$slider_image1_mobile_img}}" media="(max-width: 621px)">

                      <source  type="image/jpeg" src="{{$slider_image1_mobile_img}}" media="(max-width: 621px)">

                     @endif

                     @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image1_desktop']) && isset($banner_images_data['banner_image1_desktop']))
                    
                       @php
                        $slider_image1_desktop_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image1_desktop'],1210,223);
                      @endphp

                 

                      <source  type="image/png" src="{{$slider_image1_desktop_img}}" media="(min-width: 622px)">

                      <source  type="image/jpg" src="{{$slider_image1_desktop_img}}" media="(min-width: 622px)" >

                      <source  type="image/jpeg" src="{{$slider_image1_desktop_img}}" media="(min-width: 622px)">

                     @endif

                    @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image1_desktop']) && isset($banner_images_data['banner_image1_desktop']))

                      @php
                        $slider_image1_desktop_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image1_desktop'],1210,223);
                      @endphp

                      <img class="cw-image cw-image--loaded obj-fit-polyfill" alt="slider image" aria-hidden="false"  src="{{$slider_image1_desktop_img}}">

                       <div class="clearfix"></div>
                       <div class="space100"></div>
                       <div class="clearfix"></div>

                     @endif

                   </picture>
                </figure>
                </a>
           </div>

     @endif
 @endif



<!-----------------featured brands  (top brands section)------------------------------->


      @php
      if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';
      @endphp


        @if(isset($arr_featured_brands) && count($arr_featured_brands)>0)
        <div class="toprtd viewall-btns-idx">Top Brands
          <a href="{{ url('/') }}/shopbrand" class="{{ $class }}" title="View all">View All</a>
          <div class="clearfix"></div>
        </div>
        <div class="featuredbrands-flex smallsize-brand-img brand-imgsection-class">

       <ul
        @if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count)
        class="f-cat-below7"
        {{-- @elseif(isset($arr_featured_brands) && $isMobileDevice==1)

         @elseif(isset($arr_featured_brands) && count($arr_featured_brands)>$device_count && $isMobileDevice==0)
        id="flexiselDemo3"
        @endif --}}
         @elseif(isset($arr_featured_brands) && count($arr_featured_brands)>$device_count)
        id="flexiselDemo3"
        @endif
        >

          @foreach($arr_featured_brands as $featured_brands)
            <li>

              <div class="top-rated-brands-list">
                 @php
                  $brand_name = isset($featured_brands['name'])?$featured_brands['name']:'';
                  $brandname = str_replace(" ", "-", $brand_name);

                 @endphp


                <a href="{{ url('/') }}/search?brands={{ isset($brandname)?
                           $brandname:''}}" class="brands-citcles">
                  <div class="img-rated-brands">
                      @if(file_exists(base_path().'/uploads/brands/'.$featured_brands['image']) && isset($featured_brands['image']))

                    @php
                     $top_brand_image = image_resize('/uploads/brands/'.$featured_brands['image'],294,182);
                    @endphp  

                    {{--<img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/brands/{{$featured_brands['image']}}"
                      alt="{{ isset($brandname)?$brandname:''}}" /> --}}

                   {{--   <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$top_brand_image}}"
                      alt="{{ isset($brandname)?$brandname:''}}" /> --}}


                     <img  src="{{url('/')}}/uploads/brands/{{$featured_brands['image']}}"
                      alt="{{ isset($brandname)?$brandname:''}}" />


                    @endif
                      
                    <div class="content-brands">
                       {{--  <div class="titlebrds">{{ isset( $featured_brands['name'])?ucwords($featured_brands['name']):''}}</div> --}}
                    </div>
                </div>
              </a>
            </li>
          @endforeach
        </ul>
    </div>


  @endif


<!--   <div class="" id="top_brands_loader" style="display: none;">

    <ul class="f-cat-below7">

      @for($i=0;$i<4;$i++)
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
        
      @endfor  
   
    </ul>

  </div>

 <div class="" id="top_brands_id" style="display: none;">
   
 </div> -->

<!-----------------end of featured brands- (top brands section)------------------------------>


<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>


<!------------------------tag section start------------------------------ -->

<!-- <div class="" id="tag_section_id">
  
</div> -->


@if(isset($arr_tags) && !empty($arr_tags))
  <div class="tags-section-index-div">
  <div class="tags-section-div">

    @php
    $tagtitle = $taglink ='';
     foreach($arr_tags as $k=>$v)
      {

        $tagtitle = isset($v['title'])?$v['title']:'';
        $taglink  = isset($v['link'])?$v['link']:'';
    @endphp

       <a href="{{ $taglink }}" target="_blank"> {{ $tagtitle }}</a>

     @php
       }//foreach
     @endphp

  </div>
</div>
@endif

<!---------------------------tag section end----------------------->



<!-----------------warch and learn section-------------------------------->




 @if(!empty($arr_product_news) && count($arr_product_news)>0)
    <div class="watch-and-learn-txt nonmrg eql-heightbox-main chowwatchtitleset">
        <div class="border-home-brfands"></div>
        <div class="toprtd viewall-btns-idx viewalls smallfonts chowwatchtitle">
           <span>Chow Watch</span>

              @php
              if(isset($arr_product_news) && count($arr_product_news)<=$chowwatch_device_count)
              $class = 'butn-def viewall-product';
              else
              $class = 'butn-def';
              @endphp

           <a href="{{ url('/') }}/chowwatch" class="{{ $class }}">View All </a>
         </div>



{{--   <div class="featuredbrands-flex" onclick="window.location.href='{{ url('/') }}/learnmore'">
 --}}
           <div class="featuredbrands-flex">

              <ul
                @if(isset($arr_product_news) && count($arr_product_news)<=$chowwatch_device_count)
                class="f-cat-below7 watch-four-div"
                {{--  @elseif(isset($arr_product_news) && $isMobileDevice==1)

                @elseif(isset($arr_product_news) && count($arr_product_news)>$device_count  && $isMobileDevice==0)
                id="flexiselDemo5"
                @endif --}}
                 @elseif(isset($arr_product_news) && count($arr_product_news)>$chowwatch_device_count)
                id="flexiselDemo5"
                @endif
              >

                  @foreach($arr_product_news as $news)
                      <li class="rw-slide-li">
                        <div class="hover-img">
                          <!-- <img src="http://img.youtube.com/vi/{{ $news['url_id'] }}/0.jpg"> -->
                        </div>
                       {{--  <img class="showpreviewimage" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="http://img.youtube.com/vi/{{ $news['url_id'] }}/0.jpg" id="showpreview_{{ $news['id'] }}"> --}}


                          <div class="watch-video-lrns updated-watch-v">
                              <div class="video-idx-cw" >

                        <a urlid="{{ $news['url_id'] }}" href="#" class="vides-idx preview" onclick="openVideo(this);" primaryid="{{ $news['id'] }}"
                         data-video-id="{{ $news['url_id'] or '' }}"
                         @if(isset($news['button_title']) && ($news['button_title']!=''))
                          data-video-btn_title="{{$news['button_title']}}"
                        @endif
                        @if(isset($news['button_url']) && ($news['button_url']!=''))
                         data-video-btn_url="{{ $news['button_url'] }}"
                        @endif

                        @if(isset($news['title']) && ($news['title']!=''))
                          data-video-title="{{$news['title']}}"
                        @endif

                        data-video-autoplay="1" data-video-url="{{ $news['video_url'] }}">
                        <i class="fa fa-play" aria-hidden="true"></i>

                        </a>

                        @php
                         
                         $chow_watch_image = image_resize('/uploads/product_news/'.$news['image'],290,220);

                        @endphp

                          {{--   <img src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/product_news/{{ $news['image'] }}" alt="{{ ucfirst($news['title'])  }}" class="lozad"/> --}}

                            {{--  <img src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$chow_watch_image}}" alt="{{ ucfirst($news['title'])  }}" class="lozad"/> --}}


                            <img src="{{url('/')}}/uploads/product_news/{{ $news['image'] }}" alt="{{ ucfirst($news['title'])  }}"/>

                              </div>
                              <div class="watch-main-cnts">
                                  <div class="title-vdo-wtch">{{ ucfirst($news['title'])  }}</div>
                                  <div class="shop-pharmacy-sub brandviodeodes">

                                    <p> {{strlen($news['subtitle'])>42 ? wordwrap(substr($news['subtitle'],0,130),26,"\n",TRUE)."..." : $news['subtitle']}}</p>

                                 </div>
                              </div>
                          </div>
                      </li>
                     @endforeach
                 </ul>
             </div>

        </div>
  @endif


<!-- 
  <div class="" id="chow_watch_loader" style="display: none;">

    <ul class="f-cat-below7">

      @for($i=0;$i<4;$i++)
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
        
      @endfor  
   
    </ul>

  </div>

 <div class="" id="chow_watch_id" style="display: none;">
   
 </div> -->

<!-------------end of watch and learn------------------------------------>


<!---------------------------------start events section---------------------------------------->
<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>

@php

if(isset($site_setting_arr) && !empty($site_setting_arr) && $site_setting_arr['event_status']==1){
 @endphp

@php


 if(isset($arr_events) && !empty($arr_events))
  {

@endphp


<div class="full-width-borders fr-marqee-main">
<div class="">
  {{--  <div class="toprtd non-mgts viewall-btns-idx toprated-view">Real Time<div class="clearfix"></div></div> --}}

<ul id="flexiselDemoTop">

     @php
       foreach($arr_events as $events)
        {
      @endphp

    <li>
        <div class="li-marqee-m">
          <div class="mainmarqees">
             {{--  <div class="mainmarqees-image">
                <img src="https://beta.chow420.com/uploads/brands/579495e3a189ff0fae.jpg" alt="" >
              </div> --}}
              <div class="mainmarqees-right">
                   {{--  <div class="discription-marq"> --}}
                         @php echo $events['msg']; @endphp
                    {{--  </div> --}}
                     <div class="clearfix"></div>

                    @if(isset($site_setting_arr['event_date_status']) && $site_setting_arr['event_date_status']==1)
                      <div class="time-ago-class">
                        @php
                         echo \Carbon\Carbon::parse($events['created_at'])->diffForHumans()
                        @endphp
                      </div>
                    @endif


              </div>
                 <div class="clearfix"></div>
            </div>
        </div>
    </li>

    @php
     } //foreach
   @endphp
  </ul>
  </div>
  </div>

 @php
  }//if isset
 @endphp


@php
}//if eventstatus is 1

@endphp

<!--   <div class="" id="events_section_loader" style="display: none;">

    <ul class="f-cat-below7">

      @for($i=0;$i<4;$i++)
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
        
      @endfor  
   
    </ul>

  </div>

<div class="" id="events_section_id" style="display: none;">
  
</div> -->

<!-- ------------------end events section---------------------------------------------------------------->

  </div>
  
</div>

<div  class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header borderbottom">
        <div class="video-modal-title" id="watchlearn_title"></div>
        {{-- <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5> --}}
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="yt-player" style="height: 400px;">

        <iframe class="youtube-video" width="100%" height="100%" frameborder="0" allowfullscreen
            src="">
        </iframe>
      </div>
      <div class="modal-footer">

      </div>
     

    </div>
  </div>
</div>

</div>



<div class="imgbanner-footer">
  <div class="container">
 @if(isset($banner_images_data) && !empty($banner_images_data))

     @if(isset($banner_images_data['banner_image3_desktop']) && !empty($banner_images_data['banner_image3_desktop']) && isset($banner_images_data['banner_image3_mobile']) && !empty($banner_images_data['banner_image3_mobile']))

         <div class="adclass-maindiv">
           <a  @if(isset($banner_images_data['banner_image3_link3']))  href="{{ $banner_images_data['banner_image3_link3'] }}" target="_blank" @else  href="#" @endif>
            <figure class="cw-image__figure">
               <picture>

                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image3_mobile']) && isset($banner_images_data['banner_image3_mobile']))

                 @php
                   $slider_image3_mobile_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image3_mobile'],345,74);
                 @endphp

            

                  <source  type="image/png" src="{{$slider_image3_mobile_img}}" media="(max-width: 621px)" >

                  <source  type="image/jpg" src="{{$slider_image3_mobile_img}}" media="(max-width: 621px)" >

                  <source  type="image/jpeg" src="{{$slider_image3_mobile_img}}}" media="(max-width: 621px)" >
                   
                 @endif

                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image3_desktop']) && isset($banner_images_data['banner_image3_desktop']))
                 
                  @php
                    $slider_image3_desktop_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image3_desktop'],1210,260);
                  @endphp

            

                  <source  type="image/png" src="{{$slider_image3_desktop_img}}" media="(min-width: 622px) ">

                  <source  type="image/jpg" src="{{$slider_image3_desktop_img}}" media="(min-width: 622px)">

                  <source  type="image/jpeg" src="{{$slider_image3_desktop_img}}" media="(min-width: 622px) ">  

                 @endif


                  @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image3_desktop']) && isset($banner_images_data['banner_image3_desktop']))
                  
                  @php
                    $slider_image3_desktop_img = image_resize('/uploads/banner_images/'.$banner_images_data['banner_image3_desktop'],1210,260);
                  @endphp

            
                    <img class="cw-image cw-image--loaded obj-fit-polyfill" alt="Banner image" aria-hidden="false"  src="{{$slider_image3_desktop_img}}">

                  @endif

                </picture>
            </figure>
          </a>
       </div>
       <div class="clearfix"></div>
       <div class="space100"></div>
        <div class="clearfix"></div>
     @endif
   @endif
  </div>
</div>



@endsection

<!--scripting part start -->
@section("page_script")

  <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/slick.js"></script>
<script type="text/javascript">
        $(document).on('ready', function() {
          $(".regular").slick({
            dots: false,
            infinite: true,
            slidesToShow: 4,
            autoplay: true,
            autoplaySpeed: 2000,
            slidesToScroll: 1,
             responsive: [
                  {
                    breakpoint: 1024,
                    settings: {
                      slidesToShow: 4,
                      slidesToScroll: 1,
                      infinite: true,
                      dots: false
                    }
                  },
                  {
                    breakpoint: 800,
                    settings: {
                      slidesToShow: 3,
                      slidesToScroll: 1
                    }
                  },
                  {
                    breakpoint: 600,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1
                    }
                  },
                  {
                    breakpoint: 480,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1
                    }
                  }
                ]
          });
         
        });



      const root = document.documentElement;
      const marqueeElementsDisplayed = getComputedStyle(root).getPropertyValue("--marquee-elements-displayed");
      const marqueeContent = document.querySelector("ul.marquee-content");

      root.style.setProperty("--marquee-elements", marqueeContent.children.length);

      for(let i=0; i<marqueeElementsDisplayed; i++) {
        marqueeContent.appendChild(marqueeContent.children[i].cloneNode(true));
      }

   /*Marquee Script End*/ 

 </script>


  <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/newjquery.flexisel.js"></script>
  <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>
  <!-- <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script> -->
  <script src="{{url('/')}}/assets/front/js/imagepreview.min.js" type="text/javascript"></script>


  
  <script type="text/javascript">


 /*global variable declaration*/

   var loggedinuser ="{{ $loggedinuser }}";
   var _learnq = _learnq || [];
   var _learnq = _learnq || [];
   var dataLayer = dataLayer || [];

        $(document).on('ready', function() {


          // $(".regular").slick({
          //   dots: false,
          //   infinite: true,
          //   slidesToShow: 4,
          //   autoplay: true,
          //   autoplaySpeed: 2000,
          //   slidesToScroll: 1,
          //    responsive: [
          //         {
          //           breakpoint: 1024,
          //           settings: {
          //             slidesToShow: 4,
          //             slidesToScroll: 1,
          //             infinite: true,
          //             dots: false
          //           }
          //         },
          //         {
          //           breakpoint: 800,
          //           settings: {
          //             slidesToShow: 3,
          //             slidesToScroll: 1
          //           }
          //         },
          //         {
          //           breakpoint: 600,
          //           settings: {
          //             slidesToShow: 2,
          //             slidesToScroll: 1
          //           }
          //         },
          //         {
          //           breakpoint: 480,
          //           settings: {
          //             slidesToShow: 1,
          //             slidesToScroll: 1
          //           }
          //         }
          //       ]
          // });

          
            /*code to stop video after modal closed*/
            $('#videoModal').on('hide.bs.modal', function(e) {
                var $if = $(e.delegateTarget).find('iframe');
                var src = $if.attr("src");
                $if.attr("src", '/empty.html');
                $if.attr("src", src);
            });
           /*var screenWidth = document.documentElement.clientWidth;*/
            var screenWidth = window.screen.availWidth;
            if(parseInt(screenWidth) < parseInt(768)){
              $("#flexiselDemo1,#flexiselDemo125,#flexiselDemo121,#flexiselDemo2,#flexiselDemo67,#flexiselDemo68,#flexiselDemo44,#flexiselDemo86,#flexisel792,#flexiselDemo4,#flexiselDemo3,#flexiselDemo5").removeAttr('id');

              $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

            }


            $('.lightgallery').lightGallery();


            //get slider images
            //getSliders();

            //get all reicently viewed
            //recentlyViewedProduct();
            
            //get buy again products
            //buyAgainProduct();

            //get trending on chow
            //trendingOnChow();

            //get highlights
            //getHighlights();

            //get shop by category
            //getShopByCategory();

            //you may likes products
            //getyoumayLikesProduct();

            //get shop by reviews
            //getShopByReviews();

            //get shop by spectrum
            //getshopBySpectrum();

            //get chow choice products
            //getchowChoiceProducts();

            //get tags
            //getTags();

            //get top brands products
            //gettopBrands();

            //get chow watch
            //getchowWatch();

            //get events
            //getEvents();



        });


        
        $(window).load(function() {
      
    $("#flexiselDemo1").flexisel();

    $("#flexiselDemo121").flexisel();
    
  $("#flexiselDemo86").flexisel({
    visibleItems: 4,
    itemsToScroll: 1,
    infinite: true,
    slide:true,
    animationSpeed: 200,
    autoPlay: {
    enable: false,
    interval: 5000,
    pauseOnHover: true
    },
    responsiveBreakpoints: {
    portrait: {
    changePoint:480,
    visibleItems: 2,
    itemsToScroll: 1
    },
    landscape: {
    changePoint:640,
    visibleItems: 2,
    itemsToScroll: 1
    },
    tablet: {
    changePoint:768,
    visibleItems: 3,
    itemsToScroll: 1
    },
   ipad: {
    changePoint:1024,
    visibleItems: 3,
    itemsToScroll: 1
    },
    ipadpro: {
    changePoint:1199,
    visibleItems: 4,
    itemsToScroll: 1
    },
  laptop: {
      changePoint: 1370,
      visibleItems: 4
  }
  }
});

    $("#flexiselDemo5").flexisel({
       visibleItems: 4,
       /*infinite: false,*/
       infinite: true,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      },

    });


    $("#flexiselDemo125").flexisel({
      visibleItems: 4,
      itemsToScroll: 1,
      /*infinite: false,*/
      infinite: true,
      animationSpeed: 200,
      autoPlay: {
      enable: false,
      interval: 5000,
      pauseOnHover: true
    }
    });


  $("#flexiselDemo3").flexisel({
    visibleItems: 4,
    itemsToScroll: 1,
    infinite: true,
    animationSpeed: 200,
    autoPlay: {
    enable: false,
    interval: 5000,
    pauseOnHover: true
}

});   
       
  
  $("#flexisel792").flexisel({
        visibleItems: 4,
        itemsToScroll: 1,
        infinite: false,
    
        animationSpeed: 200,
        autoPlay: {
        enable: false,
        interval: 5000,
        pauseOnHover: true
    }
  });


    $("#flexiselDemo4").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });


 

      $("#flexiselDemo68").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });


    $("#flexiselDemo44").flexisel({
    visibleItems: 4,
    itemsToScroll: 1, slide:false,
    animationSpeed: 200,
    /*infinite: false,*/
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
    visibleItems: 2,
    itemsToScroll: 1
    },
    landscape: {
    changePoint:640,
    visibleItems: 2,
    itemsToScroll: 1
    },
    tablet: {
    changePoint:768,
    visibleItems: 3,
    itemsToScroll: 1,
    },
     ipad: {
    changePoint:1024,
    visibleItems: 3,
    itemsToScroll: 1
    },
     ipadpro: {
    changePoint:1199,
    visibleItems: 4,
    itemsToScroll: 1
    }
    }
    });

      $("#flexiselDemo12").flexisel({
       visibleItems: 4,
     /*  infinite: false,*/
       infinite: true,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: true,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 3,
      itemsToScroll: 1
      },
      laptop: {
          changePoint: 1370,
          visibleItems: 4
      }
      }
      });


      $("#flexiselDemo2").flexisel({
        
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });



  $("#flexiselDemo67").flexisel({
  visibleItems: 4,
  itemsToScroll: 1, slide:false,
  animationSpeed: 200,
 /* infinite: false,*/
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
  visibleItems: 2,
  itemsToScroll: 1
  },
  landscape: {
  changePoint:640,
  visibleItems: 2,
  itemsToScroll: 1
  },
  tablet: {
  changePoint:768,
  visibleItems: 3,
  itemsToScroll: 1,
  },
   ipad: {
  changePoint:1024,
  visibleItems: 3,
  itemsToScroll: 1
  },
   ipadpro: {
  changePoint:1199,
  visibleItems: 4,
  itemsToScroll: 1
  }
  }
  });
     



  $("#flexiselDemo55").flexisel({
      visibleItems: 4,
      itemsToScroll: 1,
      // infinite: false,
      infinite: true,
      animationSpeed: 200,
      autoPlay: {
      enable: true,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 3,
      itemsToScroll: 1
      },
      laptop: {
          changePoint: 1370,
          visibleItems: 4
      }
      }
      });
      

    $("#flexiselDemoTop").flexisel({
      visibleItems: 4,
      itemsToScroll: 1,
      infinite: false,
     /* infinite: true,*/
      animationSpeed: 300,
      autoPlay: {
      enable: true,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 3,
      itemsToScroll: 1
      },
      laptop: {
          changePoint: 1370,
          visibleItems: 4,
          itemsToScroll: 1
      }
      }
    });


    });

 




    function openVideo(ref){
      let videoID = $(ref).attr('data-video-id');

      var btn_title = $(ref).attr('data-video-btn_title');
      var btn_url = $(ref).attr('data-video-btn_url');
      var title = $(ref).attr('data-video-title');

      let videoUrl = 'https://www.youtube.com/embed/'+videoID/*+'?autoplay=1'*/;

      $("#yt-player iframe.youtube-video").attr("src",videoUrl);

      $(".modal-footer").html('');
      $("#watchlearn_title").html(title);
      if((btn_title!='' && btn_title!=undefined) && (btn_url!='' && btn_url!=undefined))
      {

        var html = '<a class="btn btn-info morebtnslinksd" href="'+btn_url+'" target="_blank">'+btn_title+'</a>';
        $(".modal-footer").html(html);
      }

      $("#videoModal").modal();
    }

    
  
 

  function add_to_cart(ref) {
    var id   = $(ref).attr('data-id');
    var quantity = $(ref).attr('data-qty');
    var type  = $(ref).attr('data-type');

    var csrf_token = "{{ csrf_token()}}";
    var prdid = atob(id);

    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},
          dataType:'json',
          beforeSend: function(){
            $(ref).attr('disabled');
          
            $('#'+prdid).html('Added To Cart <i class="fa fa-spinner fa-pulse fa-fw"></i>');

          },
          success:function(cart_response)
          {
       
            $(".add_to_cart").html('Add to Cart');

            if(cart_response.status == 'SUCCESS')
            {

              $('#'+prdid).css('background-color','#18ca44');
              $('#'+prdid).css('border','#18ca44');
              $('#'+prdid).css('color','#fff');

               
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

                 $('#add_to_cart_pop_up').addClass('open-cart-box'); /*Show pop-up*/

                 var prod_name_div      = document.getElementById('prod_name');
                 var item_qty_div       = document.getElementById('prod_item_qty');
                 var price_div          = document.getElementById('prod_price');
            /*    var shipping           = document.getElementById('shipping');*/
                 var product_image_div  = document.getElementById('product_image');
                 var seller             = document.getElementById('seller');

                 prod_name_div.innerHTML      = product_name;
                 item_qty_div.innerHTML       = item_qty;
                /*shipping.innerHTML           = shipping_type;*/

                 if (is_price_drop) {

                  price_div.innerHTML = "$"+Number(price).toFixed(2)+" <del class='pricevies inline-del'> $"+Number(unit_price).toFixed(2)+"</del> <div class='inlineoff-div'>("+Number(percent_price_drop)+"% off)</div>";
                 }
                 else {

                  price_div.innerHTML = "$"+Number(price).toFixed(2);
                 }

                 product_image_div.innerHTML  = "<img src='"+product_image+"' id='add_cart_product' alt='Girl in a jacket' width='100' height='100'>";

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
            { 
                     swal('Alert!',cart_response.description);
                     
            }
            else
            {
              swal('Error',response.description,'error');
            }
          }

      });
  }


equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; /*empty the array*/
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).load(function() {
  equalheight('.eql-heightbox-main .nbs-flexisel-item');
});


$(window).resize(function(){
  equalheight('.eql-heightbox-main .nbs-flexisel-item');
});


function buyer_redirect_login()
{

   swal({
          title: "Alert!",
          text: "If you want to buy a product, then please login as a buyer",
        /* type: "warning",*/
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = SITE_URL+"/login";
          }
      });
}

$(window).scroll(function(){
    $(".opacityhidescroll").css("opacity", 1 - $(window).scrollTop() / 150);
  });





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
       var csrf_token = "{{ csrf_token()}}";
       var productid = atob(productid);

         $.ajax({
                url:SITE_URL+'/gettrackingproduct',
                method:'GET',
                data:{productid:productid,quantity:quantity},

                success:function(response)
                {

                
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
                             /*'variant': 'Gray',*/
                              'quantity': 1
                             }]
                          }
                        }
                      });



                }/*success*/
            });


    }/*if productid*/

  }/*end function*/





@php
$product_impression = [];
 if(isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data))
 {

   $product_impression_arr = $product_impression = [];
   $position =1;
   foreach ($arr_eloq_trending_data as $key => $value) {


     $product_impression_arr['name'] = $value['product_name'];
     $product_impression_arr['id'] = $value['id'];
     $product_impression_arr['brand'] = isset($value['brand'])?get_brand_name($value['brand']):'';
     $product_impression_arr['category'] = isset($value['first_level_category_id'])?get_first_levelcategorydata($value['first_level_category_id']):'';
     $product_impression_arr['position'] = $position;
     $product_impression_arr['list'] =  'Search Results';


      if(isset($value['price_drop_to']))
      {
         if($value['price_drop_to']>0)
         {
           $product_impression_arr['price'] = isset($value['price_drop_to']) ? num_format($value['price_drop_to']) : '';
         }else
         {
          $product_impression_arr['price'] = isset($value['unit_price']) ? num_format($value['unit_price']) : '';
         }
      }
      else
      {
        $product_impression_arr['price'] = isset($value['unit_price']) ? num_format($value['unit_price']) : '';
      }



     $product_impression[] = $product_impression_arr;
     $position++;
   }
 }


@endphp


dataLayer.push({
  'event':'Product Detail Impression',
  'ecommerce': {
    'currencyCode': 'USD',
    'impressions': <?php echo json_encode($product_impression) ?>

  }
});


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

/*function for get recently viewed product*/

function recentlyViewedProduct()
{
    $.ajax({
              url:SITE_URL+'/recently_viewed_products',
              method:'GET',
           //   dataType:'json',
              beforeSend: function(){
                //showProcessingOverlay();
                $("#recently-view-loader").show();
                $("#recently_viewed_id").hide();
              },
            
              success:function(response)
              {
                
                $("#recently-view-loader").hide();
                  $("#recently_viewed_id").show();
                 // hideProcessingOverlay();

                  $("#recently_viewed_id").html(response);

              }/*success*/
      });

}


/* get buy again products*/
function buyAgainProduct()
{
    $.ajax({
              url:SITE_URL+'/buy_again_products',
              method:'GET',
             //dataType:'json',
              beforeSend: function(){
                
                $("#buy_again-loader").show();
                $("#buy_again_id").hide();
              },
            
              success:function(response)
              {
                $("#buy_again-loader").hide();

                $("#buy_again_id").show();
         
                $("#buy_again_id").html(response);

              }/*success*/
    });

}

/* get trending on chow products*/
function trendingOnChow()
{
    $.ajax({
              url:SITE_URL+'/trending_onchow_products',
              method:'GET',
             //dataType:'json',
              beforeSend: function(){
                $("#trending_chow_loader").show();
                $("#trending_chow_id").hide();
              },
            
              success:function(response)
              {
                 $("#trending_chow_loader").hide();
                 $("#trending_chow_id").show();
                  $("#trending_chow_id").html(response);

              }/*success*/
    });
}


/*get shop by category*/

function getShopByCategory()
{
    $.ajax({
              url:SITE_URL+'/shop_by_category',
              method:'GET',
             //dataType:'json',
              beforeSend: function(){
               $("#shop_bycategory_loader").show();
               $("#shop_bycategory_id").hide();
              },
            
              success:function(response)
              {
                $("#shop_bycategory_loader").hide();

                 $("#shop_bycategory_id").show();
     
                  $("#shop_bycategory_id").html(response);

              }/*success*/
     });
}

//get you may likes products
function getyoumayLikesProduct()
{
  
    $.ajax({
              url:SITE_URL+'/you_may_likes_products',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
               
               $("#you_may_likes_loader").show();
               $("#you_may_likes_id").hide();

              },
            
              success:function(response)
              {
                
                $("#you_may_likes_loader").hide();
                
                $("#you_may_likes_id").show();
                $("#you_may_likes_id").html(response);

              }/*success*/
    });

}


//get shop by reviews products
function getShopByReviews()
{

    $.ajax({
              url:SITE_URL+'/shop_by_reviews',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
               $("#shop_by_reviews_loader").show();
               $("#shop_by_reviews_id").hide();
              },
            
              success:function(response)
              {
                 $("#shop_by_reviews_loader").hide();
                 $("#shop_by_reviews_id").show();

                 $("#shop_by_reviews_id").html(response);

              }/*success*/
    });

}

//get shop by spectrum 
function getshopBySpectrum()
{
    $.ajax({
              url:SITE_URL+'/shop_by_spectrum',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
                $("#shop_by_spectrum_loader").show();

                $("#shop_by_spectrum").hide();
              },
            
              success:function(response)
              {
                 $("#shop_by_spectrum_loader").hide();

                 $("#shop_by_spectrum").show();
                 $("#shop_by_spectrum").html(response);

              }/*success*/
  });

}

//get chow choice products
function getchowChoiceProducts()
{
  $.ajax({
              url:SITE_URL+'/chow_choice_products',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){

               $("#chow_choice_loader").show();
               $("#chow_choice_id").hide();
              },
            
              success:function(response)
              {
                $("#chow_choice_loader").hide();

                $("#chow_choice_id").show();
                $("#chow_choice_id").html(response);

              }/*success*/
  });
}

//get shop top brands 
function gettopBrands()
{
    $.ajax({
                url:SITE_URL+'/top_brands_products',
                method:'GET',
                //dataType:'json',
                beforeSend: function(){
                 $("#top_brands_loader").show();

                 $("#top_brands_id").hide();
                },
              
                success:function(response)
                {
                  $("#top_brands_loader").hide();

                  $("#top_brands_id").show();
                  $("#top_brands_id").html(response);

                }/*success*/
    });

}

//get chow watch video
function getchowWatch()
{
    $.ajax({
              url:SITE_URL+'/chow_watch',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
                $("#chow_watch_loader").show();

                $("#chow_watch_id").hide();
              },
            
              success:function(response)
              {
                $("#chow_watch_loader").hide();

                $("#chow_watch_id").show();
                $("#chow_watch_id").html(response);

              }/*success*/
    });

}

//get real time events
function getEvents()
{
    $.ajax({
              url:SITE_URL+'/events',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
                
               $("#events_section_loader").show();
               $("#events_section_id").hide();

              },
            
              success:function(response)
              {
                $("#events_section_loader").hide();
                $("#events_section_id").show();

                $("#events_section_id").html(response);

              }/*success*/
    });

}

//get slider images 
function getSliders()
{
  
    $.ajax({
              url:SITE_URL+'/get_slider_images',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
                $("#banner_images_loader").show();
                $("#sliders_id").hide();
              },
            
              success:function(response)
              {
                $("#sliders_id").show();
                $("#banner_images_loader").hide();
                $("#sliders_id").html(response);

              }/*success*/
    });

}


//get hightlights data

function getHighlights()
{
  
    $.ajax({
              url:SITE_URL+'/get_highlights',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
              
              },
            
              success:function(response)
              { 
                $("#highlight_section_id").html(response);

              }/*success*/
    });

}


function getTags()
{
    $.ajax({
              url:SITE_URL+'/get_tags',
              method:'GET',
              //dataType:'json',
              beforeSend: function(){
               
              },
            
              success:function(response)
              { 
                $("#tag_section_id").html(response);

              }/*success*/
    });
}

</script>
<script type="text/javascript"  src="{{url('/')}}/assets/front/js/lightgallery-all.min.js"></script>

@endsection

<!-- scripting part end -->









<!-- commented script -->



<!-- window.load  -->
{{-- 
    /*for a while commented code*/

   /*   $("#flexiselDemo2").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });*/


/*
      $("#flexiselDemo67").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });*/

      /*$("#flexiselDemo68").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });*/


    /*  $("#flexiselDemo4").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });*/
/*
      $("#flexiselDemo44").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });*/

     /* $("#flexisel792").flexisel({
          visibleItems: 4,
          itemsToScroll: 1,
          infinite: false,
     
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      }
      });*/


   /*   $("#flexiselDemo3").flexisel({
          visibleItems: 4,
          itemsToScroll: 1,

          infinite: true,
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      }
      });*/


      /*      $("#flexiselDemo86").flexisel({
        visibleItems: 4,
        itemsToScroll: 1,
        infinite: true,
        slide:true,
        animationSpeed: 200,
        autoPlay: {
        enable: false,
        interval: 5000,
        pauseOnHover: true
        },
        responsiveBreakpoints: {
        portrait: {
        changePoint:480,
        visibleItems: 2,
        itemsToScroll: 1
        },
        landscape: {
        changePoint:640,
        visibleItems: 2,
        itemsToScroll: 1
        },
        tablet: {
        changePoint:768,
        visibleItems: 3,
        itemsToScroll: 1
        },
       ipad: {
        changePoint:1024,
        visibleItems: 3,
        itemsToScroll: 1
        },
        ipadpro: {
        changePoint:1199,
        visibleItems: 4,
        itemsToScroll: 1
        },
      laptop: {
          changePoint: 1370,
          visibleItems: 4
      }
      }
      });*/



/*
      $("#flexiselDemo5").flexisel({
       visibleItems: 4,
      
       infinite: true,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      },

      });*/

      /* $("#flexiselDemo86").flexisel({
        visibleItems: 2,
        itemsToScroll: 1,
        slide:false,
        animationSpeed: 400,
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
        visibleItems: 1,
        itemsToScroll: 1
        },
        tablet: {
        changePoint:768,
        visibleItems: 2,
        itemsToScroll: 1
        },
        ipadpro: {
        changePoint:1199,
        visibleItems: 2,
        itemsToScroll: 1
        },
      laptop: {
          changePoint: 1370,
          visibleItems: 2
      }
      }
      });*/ --}}

   
{{-- // $(".rw-hover-img").on("mouseover", function () {

//     var urlid = $(this).attr('url_id');
//     var primaryid = $(this).attr('id');
//     var product_image_div  = document.getElementById('showpreview_'+primaryid);
//      product_image_div.innerHTML  = '<img src="http://img.youtube.com/vi/'+urlid+'/0.jpg" >';


// });

// $(".rw-hover-img").on("mouseout", function () {
//     var urlid = $(this).attr('url_id');
//     var primaryid = $(this).attr('id');
// });
 --}}

{{-- <script>
   showProcessingOverlay();
 //  $(window).load(function() {
 $(document).ready(function() {

     hideProcessingOverlay();
   });
</script> --}}


   {{--  <script>
      $(document).ready(function() {
        $("#carousel-example-generic").swiperight(function() {
          $(this).carousel('prev');
        });
        $("#carousel-example-generic").swipeleft(function() {
          $(this).carousel('next');
        });
      });
    </script>  --}}



