@extends('front.layout.master')
@section('main_content')

  
<style type="text/css">
.carousel li {width: 10px;height: 10px;} 
.carousel-indicators{margin-left: 0px;}
.price-listing.pricestatick{position: static; text-align: left;padding-left: 0px;}
.price-listing.pricestatick span{display: block;}
.price-listing.pricestatick .pricevies{float: none;}
@media (max-width: 991px){
.closebtnslist.filternw { display: none !important; }
}
</style>

 @php
    $isMobileDevice=0;
    if($isMobileDevice==1){

        $device_count = 2;
        $chowwatch_device_count = '';
    }
    else {
        $device_count = 5;
        $chowwatch_device_count = 4;
    }
@endphp

{{-- @php
$class ='';
@endphp --}}

<!--Slider section start here-->

 <!--Slider Home Banner Start-->
{{-- <section class="homegallery">
  <div class="container">
    <div class="row">
      <div class="carousel-wrap">
  <div class="owl-carousel">

    
 @if(!empty($arr_slider_images) && count($arr_slider_images)>0)
      @foreach($arr_slider_images as $slider) 
        @foreach($slider as $k=>$slide) 
              <div class="item">
                <h3>{{ isset($slide['title'])?$slide['title']:''}}</h3>
                <img src="{{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}">
              </div>
         @endforeach  
       @endforeach   
  @endif

  

  </div>
</div>
    </div>
  </div>
</section> --}}
<!--Slider Home Banner End-->


<!-- space-left-right-homepage -->

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" >

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
               
               {{--  <div class="{{ $active }}" style="background: url({{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}) no-repeat ;background-position: center center; margin: 0px;padding: 0; cursor: pointer"> --}}
               <div class="{{ $active }}" style="background-position: center center; margin: 0px; padding: 0;">
             
               {{-- <img src="{{url('/')}}/assets/front/images/banner-l-size.jpg" alt="" /> --}}


              @if(isset($slide['slider_image']) && isset($slide['slider_medium']) && isset($slide['slider_small'])) 


                <figure class="cw-image__figure">
                   <picture>

                     @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_small']) && isset($slide['slider_small'])) 
                      <source type="image/png" srcset="{{url('/')}}/uploads/slider_images/{{ $slide['slider_small']  }}" media="(max-width: 621px)">
                     @endif
                     
                     @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_medium']) && isset($slide['slider_medium']))    
                      <source type="image/png" srcset="{{url('/')}}/uploads/slider_images/{{ $slide['slider_medium']  }}" media="(min-width: 622px) and (max-width: 834px)">
                     @endif

                      @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_image']) && isset($slide['slider_image']))
                      <source type="image/png" srcset="{{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}" media="(min-width: 835px)">
                      @endif  
                      @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_image']) && isset($slide['slider_image'])) 
                        <img class="cw-image cw-image--loaded obj-fit-polyfill" alt="" aria-hidden="false" src="{{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}">
                      @endif  

                    </picture>
                </figure>

              @endif  

               <!-----------commented code for slider at 18-fe-20----------------->     

              {{--  @if(file_exists(base_path().'/uploads/slider_images/'.$slide['slider_image']) && isset($slide['slider_image']))
                   <img src="{{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}" alt="" />
                @else
                   <img src="{{url('/')}}/assets/front/images/banner-l-size.jpg" alt="" />
                @endif --}}

                <!-----------commented code for slider at 18-fe-20----------------->     
                      
                          <div class="carousel-caption">
                            <div class="container">
                            <div class="banner-text-block">
                               <div class="modarn-hm">{{ isset($slide['title'])?$slide['title']:''}}</div>
                                    <h1>{{ $slide['subtitle'] or '' }}</h1>
                                    <div class="button-rev homts">
                                      @if(isset($slide['slider_button']) && (!empty($slide['slider_button'])))
                                        <a href="{{ $slide['image_url'] }}" class="butn-def">{{ $slide['slider_button'] }}</a>
                                     @endif
                               </div>
                            </div>
                          </div>
                        </div>

                  {{-- <div class="button-rev homts">
                      <a target="_blank" href="{{ url('/') }}/search" class="butn-def">Explore</a>
                  </div> --}}
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
</div>

<div class="container">


<!--Slider section start here-->
<div class="top-rated-brands-main homepagenewlistings">

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
                                <img src="{{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}" class="portrait" alt="" />
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
 
<!----------------------------start of trending products------------------------>

<div class="top-rated-brands-main homepagenewlistings trending-products-cls-home">


 @if(isset($arr_eloq_trending_data) && count($arr_eloq_trending_data)>0)
        <div class="toprtd non-mgts viewall-btns-idx toprated-view">Trending Products 

          @php
          if(isset($arr_eloq_trending_data) && count($arr_eloq_trending_data)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';  
          @endphp

         <a href="{{ url('/') }}/search" class="{{ $class }}" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>
       
        <div class="featuredbrands-flex trendingproducts-section">         
          <ul @if(isset($arr_eloq_trending_data) && count($arr_eloq_trending_data)<=$device_count)    
             class="f-cat-below7"      
           {{-- @elseif(isset($arr_trending) && $isMobileDevice==1 )
             
           @elseif(isset($arr_trending) && count($arr_trending)>$device_count  && $isMobileDevice==0 )
              id="flexiselDemo2"    
           @endif --}}
            @elseif(isset($arr_eloq_trending_data) && count($arr_eloq_trending_data)>$device_count)
              id="flexiselDemo2"    
           @endif
         >
       
            @foreach($arr_eloq_trending_data as $trend_product)
               @php  

                       $avg_rating = $trend_product['avg_rating'];
                       $avg_rating  = round_rating_in_half($avg_rating);

                     //  $avg_rating = get_avg_rating($trend_product['product_details']['id']);
                       if($avg_rating==1){$rating = 'one';}
                       else if($avg_rating==2){$rating = 'two';}
                       else if($avg_rating==3){$rating = 'three';}
                       else if($avg_rating==4){$rating = 'four';}
                       else if($avg_rating==5){$rating = 'five';}
                       else if($avg_rating==0.5){$rating = 'zeropointfive';}
                       else if($avg_rating==1.5){$rating = 'onepointfive';}
                       else if($avg_rating==2.5){$rating = 'twopointfive';}
                       else if($avg_rating==3.5){$rating = 'threepointfive';}
                       else if($avg_rating==4.5){$rating = 'fourpointfive';}

                       $total_review = get_total_reviews($trend_product['product_details']['id']);  
                        if($total_review>0)
                          $total_review = $total_review;
                        else
                           $total_review = '';

              @endphp
               

             <li>
                <div class="top-rated-brands-list">
                   @php
                      $product_title = isset($trend_product['product_details']['product_name']) ? $trend_product['product_details']['product_name'] : '';
                      $product_title_slug = str_slug($product_title);
                    @endphp

                   <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['product_details']['id'])?base64_encode($trend_product['product_details']['id']):'0'}}/{{ $product_title_slug }}" title="{{ ucfirst($trend_product['product_details']['product_name']) }}">
                      <div class="img-rated-brands">


                           @if(isset($trend_product['product_details']['is_age_limit']) && $trend_product['product_details']['is_age_limit'] == 1 && isset($trend_product['product_details']['age_restriction']))
                            <div class="label-list">
                              @php
                                if(isset($trend_product['product_details']['age_restriction_detail']['age']) && $trend_product['product_details']['age_restriction_detail']['age']!='')
                               {
                              @endphp
                                 {{ $trend_product['product_details']['age_restriction_detail']['age']}}
                              @php 
                               }
                              @endphp
                             </div>

                            @endif



                          <div class="thumbnailss"> 
                                @if(file_exists(base_path().'/uploads/product_images/'.$trend_product['product_details']['product_images_details'][0]['image']) && isset($trend_product['product_details']['product_images_details'][0]['image']))
                                <img src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_details']['product_images_details'][0]['image']}}" class="portrait" alt="{{ $product_title }}" />
                                @else
                                  <img src="{{url('/assets/images/default-product-image.png')}}" class="portrait" alt="{{ $product_title }}" />
                                                    
                                @endif
                            </div>
                        <div class="content-brands">
                            

                              <div class="price-listing pricestatick"> 
                                    @if(isset($trend_product->price_drop_to))
                                      @if($trend_product->price_drop_to>0)
                                        <del class="pricevies">

                                        ${{isset($trend_product['product_details']['unit_price']) ? num_format($trend_product['product_details']['unit_price']) : '0'}}

                                      </del>
                                        <span>${{isset($trend_product['product_details']['price_drop_to']) ? num_format($trend_product['product_details']['price_drop_to']) : '0'}} </span>
                                      @else

                                        <del class="pricevies"></del>
                                        <span>${{isset($trend_product['product_details']['unit_price']) ? num_format($trend_product['product_details']['unit_price']) : '0'}} </span>
                                      @endif
                                    @else
                                      <del class="pricevies"></del>

                                      <span>${{isset($trend_product['product_details']['unit_price']) ? num_format($trend_product['product_details']['unit_price']) : '0'}} </span>
                                    @endif  
                               </div>

                             <div class="titlebrds by-ttlbrn"> <span>{{ isset($trend_product['product_details']['get_brand_detail']['name'])? ucwords($trend_product['product_details']['get_brand_detail']['name']):''  }}</span></div> 
  

                            <div class="titlebrds spacetoptitlebrds">{{ ucwords($trend_product['product_details']['product_name'])  }}</div> 
                            <div class="starthomlist "  @if($avg_rating>0) title="{{$avg_rating}} Avg. rating"
                                    @endif>
                              @if($avg_rating>0 && isset($rating))
                                <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="star-rate-{{$rating}}.png"  title="{{$avg_rating}} Avg. rating"/>
                                 <span class="str-links starcounts" title="@if($total_review==1){{$total_review}} Review @elseif($total_review>1){{ $total_review }} Reviews @endif">
                                  @if($total_review==1)  {{ $total_review }} Review 
                                  @elseif($total_review>1){{ $total_review }} Reviews
                                  @endif
                                 </span>

                              @endif  
                            </div>
                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li> 
         @endforeach        
        </ul> 
    </div>

<hr>
@endif 
<!------------end of trending products---------------------------->




<!-----------------featured brands------------------------------->


       @php
      if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';  
      @endphp

        
      <div class="border-home-brfands"></div>
        @if(isset($arr_featured_brands) && count($arr_featured_brands)>0)  
        <div class="toprtd viewall-btns-idx">Featured Brands
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
                      <img src="{{url('/')}}/uploads/brands/{{$featured_brands['image']}}" 
                      alt="{{ isset($brandname)?$brandname:''}}" />
                      @endif
                    <div class="content-brands">                       
                        <div class="titlebrds">{{ isset( $featured_brands['name'])?ucwords($featured_brands['name']):''}}</div>                           
                    </div>
                </div>
              </a>
            </li>            
          @endforeach
        </ul> 
    </div>

  <hr>  
   @endif 

<!-----------------end of featured brands------------------------------->





<!-------------start of top rated products----------------------------------->

 @if(isset($arr_eloq_toprated_data) && count($arr_eloq_toprated_data)>0)
        <div class="toprtd non-mgts viewall-btns-idx toprated-view">Top Rated Products 

          @php
          if(isset($arr_eloq_toprated_data) && count($arr_eloq_toprated_data)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';  
          @endphp

         <a href="{{ url('/') }}/search" class="{{ $class }}" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>
       
        <div class="featuredbrands-flex trendingproducts-section tprtd-procudt">         
          <ul @if(isset($arr_eloq_toprated_data) && count($arr_eloq_toprated_data)<=$device_count)    
             class="f-cat-below7"      
           {{--  @elseif(isset($arr_product) && $isMobileDevice==1) --}}
                
          {{--  @elseif(isset($arr_product) && count($arr_product)>$device_count && $isMobileDevice==0)
              id="flexiselDemo1"
           @endif --}}
            @elseif(isset($arr_eloq_toprated_data) && count($arr_eloq_toprated_data)>$device_count)
              id="flexiselDemo1"
           @endif
         >
            
            @foreach($arr_eloq_toprated_data as $product)
              @php 
                       $avg_rating = $product['avg_rating'];
                       $avg_rating  = round_rating_in_half($avg_rating);
                       if($avg_rating==1){$rating = 'one';}
                       else if($avg_rating==2){$rating = 'two';}
                       else if($avg_rating==3){$rating = 'three';}
                       else if($avg_rating==4){$rating = 'four';}
                       else if($avg_rating==5){$rating = 'five';}else
                       if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}


                        $total_reviews = get_total_reviews($product['product_details']['id']);  
                        if($total_reviews>0)
                          $total_reviews = $total_reviews;
                        else
                           $total_reviews = '';


              @endphp

             <li>
                <div class="top-rated-brands-list">
                   @php
                      $product_title = isset($product['product_details']['product_name']) ? $product['product_details']['product_name'] : '';
                      $product_title_slug = str_slug($product_title);
                    @endphp
                    <a href="{{url('/')}}/search/product_detail/{{isset($product['product_details']['id'])?base64_encode($product['product_details']['id']):'0'}}/{{ $product_title_slug }}"  title="{{ ucfirst($product['product_details']['product_name']) }}"><div class="img-rated-brands">

                      <!------------start---age restriction div------------>

                        @if(isset($product['product_details']['is_age_limit']) && $product['product_details']['is_age_limit'] == 1 && isset($product['product_details']['age_restriction']))
                            <div class="label-list">
                              @php
                                if(isset($product['product_details']['age_restriction_detail']['age']) && $product['product_details']['age_restriction_detail']['age']!='')
                               {
                              @endphp
                                 {{ $product['product_details']['age_restriction_detail']['age']}}
                              @php 
                               }
                              @endphp
                             </div>
                        @endif




                      <!--------------end of age restriction div---------->


                      <div class="thumbnailss">
                
                            @if(!empty($product['product_details']['product_images_details'][0]['image']) && file_exists(base_path().'/uploads/product_images/'.$product['product_details']['product_images_details'][0]['image']))
                               <img src="{{url('/')}}/uploads/product_images/{{ $product['product_details']['product_images_details'][0]['image'] }}" class="portrait" alt="{{ ucfirst($product['product_details']['product_name']) }}" />
                            @else
                               <img src="{{url('/assets/images/default-product-image.png')}}" class="portrait" alt="{{ ucfirst($product['product_details']['product_name']) }}" />
                            @endif
                        </div>
                        <div class="content-brands">
                          

                              <div class="price-listing pricestatick"> 
                                    @if(isset($product['product_details']['price_drop_to']))
                                      @if($product['product_details']['price_drop_to']>0)
                                        <del class="pricevies">

                                        ${{isset($product['product_details']['unit_price']) ? num_format($product['product_details']['unit_price']) : '0'}}

                                      </del>
                                        <span>${{isset($product['product_details']['price_drop_to']) ? num_format($product['product_details']['price_drop_to']) : '0'}} </span>
                                      @else

                                        <del class="pricevies"></del>
                                        <span>${{isset($product['product_details']['unit_price']) ? num_format($product['product_details']['unit_price']) : '0'}} </span>
                                      @endif
                                    @else
                                      <del class="pricevies"></del>

                                      <span>${{isset($product['product_details']['unit_price']) ? num_format($product['product_details']['unit_price']) : '0'}} </span>
                                    @endif  
                               </div>

                              <div class="titlebrds by-ttlbrn"><span>{{ isset($product['product_details']['get_brand_detail']['name'])? ucwords($product['product_details']['get_brand_detail']['name']):''  }}</span></div>  

                            <div class="titlebrds spacetoptitlebrds">{{ ucwords($product['product_details']['product_name'])  }}</div> 
                            <div class="starthomlist"  @if($avg_rating>0) title="{{$avg_rating}} Avg. rating"
                             @endif>
                                @if($avg_rating>0 && isset($rating))
                                <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="star-rate-{{$rating}}.png" title="{{$avg_rating}} Avg. rating"/>

                                 <span class="str-links starcounts" title="@if($total_reviews==1){{$total_reviews}} Review @elseif($total_reviews>1){{ $total_reviews }} Reviews @endif">
                                  @if($total_reviews==1)  {{ $total_reviews }} Review 
                                  @elseif($total_reviews>1){{ $total_reviews }} Reviews
                                  @endif
                                 </span>
                              @endif  
                            </div>
                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li> 
         @endforeach        
        </ul> 
    </div>

<hr>
@endif 
<!-------------------end of top rated products------------------------------------------------>

<!-----------------featured categories------------------------------->

 {{-- <div  class="fav-catgry">
     <div class="border-home-brfands"></div>
          @php
          if(isset($arr_featured_category) && count($arr_featured_category)<=7)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';  
          @endphp


       @if(isset($arr_featured_category) && count($arr_featured_category)>0) 

         <div class="toprtd viewall-btns-idx"><div class="clearfix"></div>
        

           <a href="{{ url('/') }}/search" class="butn-def ftrleft-categories" title="View all">View All</a>

         </div>



       <div class="featuredbrands-flex">

        <ul id="flexiselDemo12">
        @foreach($arr_featured_category as $featured_category)
             <li> 
                <div class="top-rated-brands-list featured-categoriestp-trd">
                    <a href="{{ url('/') }}/search?category_id={{ base64_encode($featured_category['id']) }}" title="{{ $featured_category['product_type'] }}">

                                @if(file_exists(base_path().'/uploads/first_category/'.$featured_category['image']) && isset($featured_category['image']))
                                <img src="{{url('/')}}/uploads/first_category/{{ $featured_category['image'] }}"  alt="" />
                                @endif
                    </a>
                </div>
             </li>
        @endforeach
      </ul>
  </div>
       @endif
</div> --}}



<div class="promotions-updatepg">
  <div class="toprtd viewall-btns-idx viewalls smallfonts featuredcategories-space">
           <span>Featured Categories</span> 
</div>

  @php
  if(isset($arr_featured_category) && count($arr_featured_category)<=7)
  $class = 'butn-def viewall-product';
  else
  $class = 'butn-def';  
  @endphp



  <div class="featuredcategories-four">

    @foreach($arr_featured_category as $featured_category)
    <div class="categories-four-list">
      <a href="{{ url('/') }}/search?category_id={{ base64_encode($featured_category['id']) }}" class="promotionslist whitefont">
        <div class="img-promo">

          @if(file_exists(base_path().'/uploads/first_category/'.$featured_category['image']) && isset($featured_category['image']))

           <img src="{{url('/')}}/uploads/first_category/{{ $featured_category['image'] }}"  alt="{{ $featured_category['product_type'] }}" />
          @endif
        </div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header">
            {{ $featured_category['product_type'] }}
          </h2>
       
      </div>
      </a>
    </div>

 @endforeach

<div class="clearfix"></div>
  </div>
</div>

<!-----------------end of featured categories------------------------------->

<div style="display: none !important;">
<div class="title-most-populr-home"><span>Most Recent Products</span> <a href="{{ url('/') }}/search" class="seeproducts">View All</a></div>
<div class="most-recent-products-home-result">

       @if(isset($most_recent_home) && count($most_recent_home) > 0)    
        @foreach($most_recent_home as $key =>$product_arr)

        <div class="table-most-recent-products-home-result">
          @foreach($product_arr as $key =>$most_product)
            @php

              $product_name1 = isset($most_product['product_name'])?ucwords($most_product['product_name']):'';
               if(isset($most_product['product_images_details'][0]['image']) && $most_product['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$most_product['product_images_details'][0]['image']))
               {
                  $product_img1 = url('/uploads/product_images/'.$most_product['product_images_details'][0]['image']);
               }else
               {                  
                  $product_img1 = url('/assets/images/default-product-image.png');
               }


            @endphp
            <div class="table-cell-most-recent-products-home-result">
                <div class="table-cell-image">
                  <div class="img-most-recent">
                       <img src="{{$product_img1}}" class="portrait" alt="{{ $product_name1 }}" />
                  </div>
                </div>
                <div class="table-cell-content">
                  <div class="title-table-cell">
                    {{$product_name1}}
                  </div>
                </div>
              </div>
            @endforeach
        </div>

        @endforeach
      @endif


</div>
</div>


<!----------------start of most recent------------------->
    



        <!-- PRODUCT SHOW -->
   
        <hr>
        @if(isset($arr_search_product) && count($arr_search_product) > 0)          
            <div class="clearfix"></div>
              <div class="cborder-home-product">
                  <div class="main-selectslist non-paddingd">
                    <div class="toprtd viewall-btns-idx smallfonts allproducttextright most-recent-padn"> 
                      Most Recent Products
                       <!-- <span>( 
                      {{ count($arr_search_product) }} of {{ $total_search_results }} results)</span> -->
                      <a href="{{ url('/') }}/search" class="butn-def seeallproducts ">View All</a>
                      <div class="clearfix"></div>
                    </div>
                      <div class="clearfix"></div>
                      <div class="closebtnslist filternw">
                        <span class="toggle-button">
                          <span class="filterbutton"><i class="fa fa-filter"></i> Filter</span>
                          <div class="menu-bar menu-bar-top"></div>
                          <div class="menu-bar menu-bar-middle"></div>
                          <div class="menu-bar menu-bar-bottom"></div>
                        </span>
                      </div> 

                     
                      <div class="clearfix"></div>
                  </div>
                      <!-- <div class="inlg-list">
                          <img src="{{url('/')}}/assets/front/images/listing-pg-bnr.jpg" alt="" />
                      </div> -->
                      
                  <div id="grid">
                      <div class="results-products nwhomepgresult nonw-idht newupdatedlsit mobile-view-updated">

                      @php
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

                      @endphp
                        
                      @foreach($arr_search_product as $product)

                           @php  
                                $avg_rating = get_avg_rating($product['id']);
                                if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}else
                                if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}


                                $total_review = get_total_reviews($product['id']);  
                                if($total_review>0)
                                  $total_review = $total_review;
                                else
                                   $total_review = '';

                            @endphp



                            <div class="product-holder-list product-search-list maindivnwhomepg">
                              <div class="reltv-div">
                                {{-- <a href="#" class="quick-shop-btn">Quick Shop</a> --}}
                                <div class="">

                                      @if($login_user == true)
                                      @if($login_user->inRole('buyer'))
                                           @if(isset($fav_arr) && in_array($product['id'],$fav_arr))
                                           
                                            <a href="javascript:void(0)" class="heart-icn active" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" onclick="removeFromFavorite($(this));">
                                               <i class="fa fa-heart"></i>
                                              </a>
                                          @else
                                              <a href="javascript:void(0)" class="heart-icn" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" onclick="addToFavorite($(this));">
                                                  <i class="fa fa-heart"></i>
                                              </a>
                                          @endif    
                                      @endif
                                      @else
                                        <a href="javascript:void(0)" class="heart-icn" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="product" onclick="addToFavorite($(this));">
                                              <i class="fa fa-heart"></i>
                                          </a>
                                      @endif
                               
                                    <div class="make3D">
                                        <div class="product-front">
                                          @php
                                            $product_title = isset($product['product_name']) ? $product['product_name'] : '';
                                            $product_title_slug = str_slug($product_title);
                                          @endphp
                                            <a href="{{url('/')}}/search/product_detail/{{isset($product['id'])?base64_encode($product['id']):''}}/{{ $product_title_slug }}" title="{{isset($product['product_name']) ? ucfirst($product['product_name']) : ''}}">
                                             <div class="owl-carousel owl-theme">
                                          
                                             @if(isset($product['is_age_limit']) && $product['is_age_limit'] == 1 && isset($product['age_restriction']))
                                                <div class="label-list">{{$product['age_restriction_detail']['age']}}</div>

                                              @endif

                                              <div class="img-cntr item">
                                              @php
                                                 if(isset($product['product_images_details'][0]['image']) && $product['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_images_details'][0]['image']))
                                                        {
                                                          $product_img = url('/uploads/product_images/'.$product['product_images_details'][0]['image']);
                                                    }
                                                    else
                                                    {                  
                                                        $product_img = url('/assets/images/default-product-image.png');
                                                    }
                                           @endphp

                                                <img src="{{$product_img}}" class="portrait" alt="{{isset($product['product_name']) ? ucfirst($product['product_name']) : ''}}" />
                                                
                                            </div>
                                            </div>
                                            {{-- <div class="border-list"></div> --}}
                                             <div class="price-listing"> 
                                              @if(isset($product['price_drop_to']))
                                                @if($product['price_drop_to']>0)
                                                  <del class="pricevies">

                                                  ${{isset($product['unit_price']) ? num_format($product['unit_price']) : '0'}}

                                                </del>
                                                  <span>${{isset($product['price_drop_to']) ? num_format($product['price_drop_to']) : '0'}} </span>
                                                @else

                                                  <del class="pricevies"></del>
                                                  <span>${{isset($product['unit_price']) ? num_format($product['unit_price']) : '0'}} </span>
                                                @endif
                                              @else
                                                <del class="pricevies"></del>

                                                <span>${{isset($product['unit_price']) ? num_format($product['unit_price']) : '0'}} </span>
                                              @endif  
                                            </div>
                                            <!------------show brand  name------------------------>
                                             <div class="titlebrds by-ttlbrn leftright-padding"><span>{{ isset($product['get_brand_detail']['name'])? ucwords($product['get_brand_detail']['name']):''  }}</span></div>  
                                            <!-------------end of-show brand name---------------------->

                                            <div class="content-pro-img">
                                                <div class="stats" title="{{isset($product['product_name']) ? ucwords($product['product_name']) : ''}}">
                                                    <div class="stats-container">
                                                       {{--  <div class="title-sub-list">{{isset($product['first_level_category_details']['product_type'])?$product['first_level_category_details']['product_type']:''}}</div> --}}
                                                        <span class="product_name">
                                                          @php
                                                          
                                                          $prod_name = isset($product['product_name']) ? ucwords($product['product_name']): '';   
                                                          $prod_desc = isset($product['description']) ? ucfirst($product['description']): '';   
                                                          
                                                          // if(strlen($prod_name)>42)
                                                          // {
                                                          //   echo substr($prod_name,0,35)."..." ;
                                                          // }
                                                          // else
                                                          // {
                                                            echo $prod_name;
                                                          // }
                                                          @endphp   
                                                          


                                                          {{-- <p> {{strlen($prod_desc)>42 ? wordwrap(substr($prod_desc,0,65),26,"\n",TRUE)."..." : $prod_desc}}</p> --}}

                                                        </span>
                                                        <!--------------avg rating div added here--->


                                                        
                                                        <!---------------------------------->  

                                                    </div>
                                                </div>
                                                
                                            </div>
                                          
                                            </a>                                           
                                           
                                          
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                   
                                 
                                </div>
                                  @if($product['inventory_details']['remaining_stock'] > 0)

                                              @if($login_user == true)

                                                @if($login_user->inRole('seller') == true || $login_user->inRole('admin') == true)

                                                  {{-- <a href="javascript::void(0)">
                                                    <div class="add_to_cart"
                                                     onclick="swal( 'Alert!','If you want to buy a product, then please login as a buyer')"
                                                     > 
                                                         Add to cart
                                                     </div>
                                                  </a> --}}

                                                  <!-------if seller login-hide button------>

                                                   {{-- <a href="javascript::void(0)">
                                                    <div class="add_to_cart"
                                                     onclick="return buyer_redirect_login()"
                                                     >  Add to cart
                                                     </div>
                                                  </a> --}}
                                                  

                                              @elseif($login_user->inRole('buyer') == true)
                                             
                                                <a href="javascript:void(0)" data-type="buyer" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" data-qty="1" 

                                                      @if(isset($buyer_id_proof) && $buyer_id_proof != "") 


                                                          @if(isset($buyer_id_proof) && 
                                                          $buyer_id_proof['approve_status']==0 
                                                          && $buyer_id_proof['front_image']==""
                                                          && $buyer_id_proof['back_image']==""
                                                          && $buyer_id_proof['selfie_image']==""
                                                          && $buyer_id_proof['age_category']==0
                                                          && $product['is_age_limit'] == 1 && $product['age_restriction']!="") 

                                                             onclick="return buyer_id_proof_warning()" 

                                                            @elseif(isset($buyer_id_proof) 
                                                              && ($buyer_id_proof['approve_status']==0 || $buyer_id_proof['approve_status']==3) 
                                                             && $buyer_id_proof['age_category']==0
                                                             && $buyer_id_proof['front_image']!=""  
                                                             && $buyer_id_proof['back_image']!="" 
                                                             && $buyer_id_proof['selfie_image']!=""
                                                             && $buyer_id_proof['age_address']!="" 
                                                             && $product['is_age_limit'] == 1 
                                                             && $product['age_restriction']!="")      
                                                              onclick="swal('Alert!','Id proof not approved')"

                                                             @elseif(isset($buyer_id_proof) 
                                                              && ($buyer_id_proof['approve_status']==0 || $buyer_id_proof['approve_status']==3) 
                                                             && $buyer_id_proof['front_image']!=""  
                                                             && $buyer_id_proof['back_image']!="" 
                                                             && $buyer_id_proof['selfie_image']!=""
                                                             && $buyer_id_proof['age_address']!="" 
                                                             && $product['is_age_limit'] == 1 
                                                             && $product['age_restriction']!="")      
                                                              onclick="swal('Alert!','Id proof not approved')"  


                                                           @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 
                                                             && $buyer_id_proof['age_category']==0
                                                             && $buyer_id_proof['front_image']!="" 
                                                             && $buyer_id_proof['back_image']!="" 
                                                             && $buyer_id_proof['selfie_image']!="" 
                                                             && $buyer_id_proof['age_address']!="" 
                                                             && $product['is_age_limit'] == 1 
                                                             && $product['age_restriction']!="")      
                                                              onclick="swal('Alert!','Age category not assigned')"
        
                                                          @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 && $buyer_id_proof['age_category'] ==1 && $buyer_id_proof['age_category']!=$product['age_restriction']
                                                             && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                              onclick="swal('Sorry','To buy this product your age must be 21+','warning')"

                                                         @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==2 
                                                             && $buyer_id_proof['front_image']!="" 
                                                             && $buyer_id_proof['back_image']!="" 
                                                             && $buyer_id_proof['age_address']!="" 
                                                             && $product['is_age_limit'] == 1 
                                                             && $product['age_restriction']!="")      
                                                              onclick="swal('Alert!','You can not buy this product age is not verified')"    

                                                          @elseif(isset($buyer_id_proof) 
                                                            && $buyer_id_proof['approve_status']==1 
                                                            && $buyer_id_proof['age_category']>0  
                                                            && $buyer_id_proof['age_category']==$product['age_restriction']  && $product['is_age_limit'] == 1 && $product['age_restriction']!="") 

                                                              onclick="add_to_cart($(this))"      


                                                          @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==0 && $product['is_age_limit'] == 1 && $product['age_restriction']!="")     

                                                           onclick="return buyer_id_proof_warning()"  

                                                          @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==0 && $product['is_age_limit'] == 0 && $product['age_restriction']=="") 

                                                              onclick="add_to_cart($(this))"
                                                          @else
                                                              onclick="add_to_cart($(this))"  

                                                          @endif
                                                      @else
                                                          onclick="add_to_cart($(this))"
                                                      @endif>

                                                      <div class="add_to_cart">
                                                         Add to cart
                                                      </div>
                                                    </a>
                                                  {{-- <a href="{{url('/')}}/my_bag/add_item/{{isset($product['id'])?base64_encode($product['id']):0}}"><div class="add_to_cart"> 
                                                    <img src="{{url('/')}}/assets/front/images/cart-icon-list.png" alt="" /> Add to cart
                                                  </div></a> --}}                                            
                                                @endif
                                                @else
                                                   {{--  <a href="javascript::void(0)"><div class="add_to_cart guest_url_btn"> Add to cart </div></a> --}}

                                                    <a href="javascript::void(0)"><div class="add_to_cart" onclick="return buyer_redirect_login_product('{{isset($product['id'])?base64_encode($product['id']):0}}')"> Add to cart </div></a>

                                              @endif
                                            @else
                                              <div class="out-of-stock"> 
                                                  <span class="red-text">Out of stock</span>
                                               </div>
                                            @endif  



                                  

                                    <div @if($avg_rating>0) class="starthomlist posinbottoms" 
                                    title="{{$avg_rating}} Avg. rating"
                                    @endif
                                    >
                                            @if($avg_rating>0)
                                              <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="star-rate-{{$rating}}.png" />
                                              <span class="str-links starcounts" title="@if($total_review==1){{$total_review}} Review @elseif($total_review>1){{ $total_review }} Reviews @endif">
                                              

                                              @if($total_review==1)  {{ $total_review }} Review 
                                              @elseif($total_review>1){{ $total_review }} Reviews
                                              @endif

                                            </span>
                                              @else
                                             {{-- <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" /> --}}
                                            @endif  
                                            
                                             
                                            @if(isset($product['get_seller_additional_details']['approve_verification_status']) && $product['get_seller_additional_details']['approve_verification_status']!=0)
                                            {{-- <img class="tagsellrts" src="{{url('/')}}/assets/front/images/tag-sellers.png" alt="" /> --}}
                                            {{--  <span style="padding: 1px;background-color: green;color: white;border-radius: 4px;font-size: xx-small;"> Seller Verified</span>  --}}
                                            @endif
                                            {{-- <img class="tagsellrts" src="{{url('/')}}/assets/front/images/tag-sellers.png" alt="" /> --}}
                                      </div>  
                                  </div>
                            </div>
                          @endforeach                   

                         {{--  <div class="col-md-12">
                            <div class="pagination-chow">                                       
                              @if(!empty($arr_pagination))
                                {{$arr_pagination->render()}}    
                               @endif 
 
                            </div>
                          </div> --}}

                      </div>
                  </div>
              </div>
            
          @endif
        <!-- END -->

<!---------------end of most recent----------------------->






     


<!-----------------warch and learn section-------------------------------->
<hr>
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
        

       @if(!empty($arr_product_news) && count($arr_product_news)>0)  
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
                      <li> 
                          <div class="watch-video-lrns updated-watch-v">
                              <div class="video-idx-cw">
                                 <a href="javascript:void(0)" class="vides-idx" onclick="openVideo(this);" 
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

                        data-video-autoplay="1" data-video-url="{{ $news['video_url'] }}"></a>
                                  <img src="{{url('/')}}/uploads/product_news/{{ $news['image'] }}" alt="{{ ucfirst($news['title'])  }}" />
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
                @endif    
        </div>
 <!-------------end of watch and learn------------------------------------>


{{-- 

<div class="promotions-updatepg">
  <div class="toprtd viewall-btns-idx viewalls smallfonts">
           <span>Featured Categories</span> 
</div>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist whitefont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img1.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header">
            Our Best Sellers
          </h2>
        
          <p class="promo-block--text">
            Shop the stuff that everybody and their neighbor is talking about.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist whitefont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img2.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header"> Deal of the Day </h2>
        
          <p class="promo-block--text">
            Every day we pick a product at random and make it an incredible deal.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist blackfont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img3.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header">Take 60% off</h2>
        
          <p class="promo-block--text">
             A selection of already discounted indoor plants and gardening tools.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist blackfont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img4.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header"> Get $20 off </h2>
        
          <p class="promo-block--text">
           When you spend more than $100 in-store and online with code 'GET20'.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
  </div>
</div>
 --}}




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
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}

    </div>
  </div>
</div>

{{-- 
    <script>
      $(document).ready(function() {
        $("#carousel-example-generic").swiperight(function() {
          $(this).carousel('prev');
        });
        $("#carousel-example-generic").swipeleft(function() {
          $(this).carousel('next');
        });
      });
    </script> --}}

{{-- <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/bootstrap.min.js"></script> --}}
    {{-- <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/customjs.js"></script> --}}
    <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/newjquery.flexisel.js"></script>


    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>



    <script type="text/javascript">
    $(document).ready(function(){
      /*code to stop video after modal closed*/
        $('#videoModal').on('hide.bs.modal', function(e) {
            var $if = $(e.delegateTarget).find('iframe');
            var src = $if.attr("src");
            $if.attr("src", '/empty.html');
            $if.attr("src", src);
        });
       // var screenWidth = document.documentElement.clientWidth;
        var screenWidth = window.screen.availWidth;
        if(parseInt(screenWidth) < parseInt(768)){
          $("#flexiselDemo1, #flexiselDemo2, #flexiselDemo5, #flexiselDemo3").removeAttr('id');
         
          $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

        }
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

    $(window).load(function() {
      $("#flexiselDemo1").flexisel(); 
      $("#flexiselDemo2").flexisel({
      visibleItems: 5,
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
       ipadpro: {
      changePoint:1199,
      visibleItems: 3,
      itemsToScroll: 1
      }
      }
      });
      $("#flexiselDemo3").flexisel({
          visibleItems: 5,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      }
      });
      $("#flexiselDemo5").flexisel({
       visibleItems: 4,
          itemsToScroll: 1,  
          animationSpeed: 200,
          autoPlay: {
          enable: false,
          interval: 5000,
          pauseOnHover: true
      },

      


      });

      $("#flexiselDemo12").flexisel({
       visibleItems: 4,
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


       $("#flexiselDemo55").flexisel({
       visibleItems: 5,
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
          visibleItems: 5
      }
      }
      });
    
    });
    </script>

  <script>
  function add_to_cart(ref) {
    var id   = $(ref).attr('data-id');
    var quantity = $(ref).attr('data-qty');
    var type  = $(ref).attr('data-type');

    var csrf_token = "{{ csrf_token()}}";

    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){     
            $(ref).attr('disabled');          
            $(ref).html('<div class="add_to_cart">Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i></div>');        
          },
          success:function(cart_response)
          {
            $(ref).html('<div class="add_to_cart">Add to cart</div>');        
            if(cart_response.status == 'SUCCESS')
            { 
              window.location.href = SITE_URL+'/my_bag';             

            }
            else if(cart_response.status=="FAILURE")
            { // added new
                     swal('Alert!',cart_response.description);  
                     {{-- setTimeout(function(){ location.reload(); }, 500); --}}                     
            }
            else
            {                
              swal('Error',response.description,'error');
            }  
          }  

      });

  }


    </script>
<script>

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
     rowDivs.length = 0; // empty the array
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

</script>



<script>

function buyer_redirect_login()
{
  
   swal({
          title: "Alert!",
          text: "If you want to buy a product, then please login as a buyer",
         // type: "warning",
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = SITE_URL+"/login";
          }
      }); 
}

</script>
<script>
  
$(window).scroll(function(){
    $(".opacityhidescroll").css("opacity", 1 - $(window).scrollTop() / 150);
  });

</script>





<script>
function buyer_redirect_login_product(val)
{
  if(val){
      window.location.href = SITE_URL+"/login/"+val;

  }else{
      window.location.href = SITE_URL+"/login";

  }
}
</script>




@endsection