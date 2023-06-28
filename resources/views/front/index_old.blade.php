@extends('front.layout.master')
@section('main_content')


<style type="text/css">
    .carousel li {
    width: 10px;
    height: 10px;
} 
.carousel-indicators{margin-left: 0px;}
</style>
<!--Slider section start here-->

<div class="space-left-right-homepage">

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
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
               
                <div class="{{ $active }}" style="background: url({{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}) no-repeat ;background-position: center center; -webkit-background-size: cover;
                    -moz-background-size: cover; -o-background-size: cover; background-size: cover; margin: 0px;padding: 0;">
                    <div class="container">
                    <div class="carousel-caption">
                     <div class="banner-text-block">
                           <div class="modarn-hm">{{ isset($slide['title'])?$slide['title']:''}}</div>
                                <h1>{{ $slide['subtitle'] or '' }}</h1>
                                 <div class="button-rev pull-right">
                                    {{-- <a target="_blank" href="{{ isset($slide['image_url'])?$slide['image_url']:"" }}" class="butn-def">Shop Now</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
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

<!--Slider section start here-->
<div class="top-rated-brands-main">



<?php /* ?>
      @if(isset($arr_product) && count($arr_product)>0)
        <div class="toprtd non-mgts viewall-btns-idx">Top Rated Products  <a href="{{ url('/') }}/search" class="butn-def">View All</a></div>
       
        <div class="featuredbrands-flex">
         <ul id="flexiselDemo1">          
            @foreach($arr_product as $product)
              @php 
                       $avg_rating = get_avg_rating($product['product_details']['id']);
                       if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}
              @endphp

            <li>
                <div class="top-rated-brands-list">
                    <a href="{{url('/')}}/search/product_detail/{{isset($product['product_details']['id'])?base64_encode($product['product_details']['id']):'0'}}"  title="{{ $product['product_details']['product_name'] }}"><div class="img-rated-brands">
                        <div class="thumbnailss">
                        
                             @if(!empty($product['product_details']['product_images_details']) 
                             && count($product['product_details']['product_images_details']))  

                            <img src="{{url('/')}}/uploads/product_images/{{ $product['product_details']['product_images_details'][0]['image'] }}" class="portrait" alt="" />

                            @endif
                        </div>
                        <div class="content-brands">
                            <div class="starthomlist">
                              @if($avg_rating>0)
                                <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="" />
                              @else
                               <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" />
                              @endif  
                            </div>
                            <div class="titlebrds">{{ $product['product_details']['product_name'] }}</div>
                            
                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li>
         @endforeach        
        </ul>
    </div>
    @endif
<?php */ ?>

{{-- {{ dd($arr_product) }}
 --}}
@if(isset($arr_product) && count($arr_product)>0)
        <div class="toprtd non-mgts viewall-btns-idx">Top Rated 

          @php
          if(isset($arr_product) && count($arr_product)<=5)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';  
          @endphp

         <a href="{{ url('/') }}/search" class="{{ $class }}" title="View all">View All</a>
        </div>
       
        <div class="featuredbrands-flex">         
          <ul @if(isset($arr_product) && count($arr_product)<=5)    
             class="f-cat-below7"      
           @elseif(isset($arr_product) && count($arr_product)>5)
              id="flexiselDemo1"
           @endif
         >
       {{--   <ul id="flexiselDemo1">     --}}      
            @foreach($arr_product as $product)
              @php 
                       $avg_rating = $product->avg_rating;
                       $avg_rating  = round_rating_in_half($avg_rating);
                       if($avg_rating==1){$rating = 'one';}
                       else if($avg_rating==2){$rating = 'two';}
                       else if($avg_rating==3){$rating = 'three';}
                       else if($avg_rating==4){$rating = 'four';}
                       else if($avg_rating==5){$rating = 'five';}else
                       if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}
              @endphp

             <li>
                <div class="top-rated-brands-list">
                    <a href="{{url('/')}}/search/product_detail/{{isset($product->id)?base64_encode($product->id):'0'}}"  title="{{ $product->product_name }}"><div class="img-rated-brands">
                    <div class="thumbnailss">
                
                     @if(!empty($product->image) && file_exists(base_path().'/uploads/product_images/'.$product->image))

                            <img src="{{url('/')}}/uploads/product_images/{{ $product->image }}" class="portrait" alt="" />

                            @endif
                        </div>
                        <div class="content-brands">
                            <div class="starthomlist">
                              @if($avg_rating>0 && isset($rating))
                                <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="" />
                              @else
                               <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" />
                              @endif  
                            </div>
                            <div class="titlebrds">{{ ucwords($product->product_name)  }}</div> 
                            
                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li> 
         @endforeach        
        </ul> 
    </div>
    @endif


 <div class="border-home-brfands"></div>
      @php
      if(isset($arr_trending) && count($arr_trending)<=5)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';  
      @endphp

       @if(isset($arr_trending) && count($arr_trending)>0)  
       <div class="toprtd viewall-btns-idx">Trending 
        <a href="{{ url('/') }}/search" class="{{ $class }}">View All </a>
       </div>
       <div class="featuredbrands-flex">
       <ul 
        @if(isset($arr_trending) && count($arr_trending)<=5)
        class="f-cat-below7" 
        @elseif(isset($arr_trending) && count($arr_trending)>5)
        id="flexiselDemo2"
        @endif
        >
       {{-- <ul id="flexiselDemo2"> --}}
        @foreach($arr_trending as $trend_product)
             @php  
                       $avg_rating = $trend_product->avg_rating;
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
              @endphp

             {{-- <li>
                <div class="top-rated-brands-list">
                    <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['product_details']['id'])?base64_encode($trend_product['product_details']['id']):'0'}}" title="{{ $trend_product['product_details']['product_name'] }}">

                        <div class="img-rated-brands">
                            <div class="thumbnailss"> 
                                @if(file_exists(base_path().'/uploads/product_images/'.$trend_product['product_details']['product_images_details'][0]['image']) && isset($trend_product['product_details']['product_images_details'][0]['image']))
                                <img src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_details']['product_images_details'][0]['image'] }}" class="portrait" alt="" />
                                @endif
                            </div>
                            <div class="content-brands">
                                <div class="starthomlist">
                                  @if($avg_rating>0)
                                    <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="" />
                                  @else
                                   <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" />
                                  @endif  
                                </div>
                                <div class="titlebrds">{{ $trend_product['product_details']['product_name'] }}</div>                           
                            </div>
                        </div>
                    </a>
                </div>
             </li> --}}

             <li>
                <div class="top-rated-brands-list">
                    <a href="{{url('/')}}/search/product_detail/{{isset($trend_product->id)?base64_encode($trend_product->id):'0'}}" title="{{ $trend_product->product_name }}">

                        <div class="img-rated-brands">
                            <div class="thumbnailss"> 
                                @if(file_exists(base_path().'/uploads/product_images/'.$trend_product->image) && isset($trend_product->image))
                                <img src="{{url('/')}}/uploads/product_images/{{ $trend_product->image}}" class="portrait" alt="" />
                                @endif
                            </div>
                            <div class="content-brands">
                                <div class="starthomlist">
                                  @if($avg_rating>0)
                                    <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="" />
                                  @else
                                   <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" />
                                  @endif  
                                </div>
                                <div class="titlebrds">{{ ucwords($trend_product->product_name) }}</div>                           
                            </div>
                        </div>
                    </a>
                </div>
             </li>
        @endforeach
      </ul>
  </div>
 @endif

{{-- <div class="featuredcategory-mn-dv">
  <div class="leftfeaturedct">Lorem Aliquid quidem aperiam velit nostrum alias neque</div>
  <div class="rightfeaturedct">
    <img src="{{url('/')}}/assets/front/images/banner2.jpg" />
  </div>
  <div class="clearfix"></div>
</div> --}}


{{-- <div @if(isset($arr_featured_category) && count($arr_featured_category)<=5) 
     class="fav-catgry below-seven" 
     @elseif(isset($arr_featured_category) && count($arr_featured_category)>5) 
     class="fav-catgry" 
     @endif> --}}

<div  class="fav-catgry" 
{{-- @if(isset($arr_featured_category) && count($arr_featured_category)<=5) 
     class="fav-catgry below-seven" 
     @elseif(isset($arr_featured_category) && count($arr_featured_category)>5) 
     class="fav-catgry" 
     @endif --}}
     >



     <div class="border-home-brfands"></div>
          @php
          if(isset($arr_featured_category) && count($arr_featured_category)<=7)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';  
          @endphp


       @if(isset($arr_featured_category) && count($arr_featured_category)>0) 

         <div class="toprtd viewall-btns-idx"><div class="clearfix"></div>
          
        {{--   @if(isset($arr_featured_category) && count($arr_featured_category)<5)
          @elseif(isset($arr_featured_category) && count($arr_featured_category)>5)
          <a href="{{ url('/') }}/search" class="butn-def ftrleft-categories">View All</a>
          @endif --}}

           <a href="{{ url('/') }}/search" class="butn-def ftrleft-categories">View All</a>

         </div>



       <div class="featuredbrands-flex">
       {{-- <ul @if(isset($arr_featured_category) && count($arr_featured_category)<5)    
             class="f-cat-below7"      
           @elseif(isset($arr_featured_category) && count($arr_featured_category)>5)
              id="flexiselDemo12"
           @endif
        > --}}

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
</div>



      @php
      if(isset($arr_featured_brands) && count($arr_featured_brands)<=5)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';  
      @endphp

        
      <div class="border-home-brfands"></div>
        @if(isset($arr_featured_brands) && count($arr_featured_brands)>0)  
        <div class="toprtd viewall-btns-idx">Brands
        <a href="{{ url('/') }}/shopbrand" class="{{ $class }}">View All</a>
        </div>
        <div class="featuredbrands-flex smallsize-brand-img">

       <ul 
        @if(isset($arr_featured_brands) && count($arr_featured_brands)<=5)
        class="f-cat-below7" 
        @elseif(isset($arr_featured_brands) && count($arr_featured_brands)>5)
        id="flexiselDemo3"
        @endif
        >         
        <!-- <ul id="flexiselDemo3"> -->

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
                    <div class="thumbnailss"> 
                      @if(file_exists(base_path().'/uploads/brands/'.$featured_brands['image']) && isset($featured_brands['image']))
                      <img src="{{url('/')}}/uploads/brands/{{$featured_brands['image']}}" alt="" />
                      @endif
                    </div>
                    <div class="content-brands">                       
                        <div class="titlebrds">{{ isset( $featured_brands['name'])?ucwords($featured_brands['name']):''}}</div>                           
                    </div>
                </div>
              </a>
            </li>            
          @endforeach
        </ul> 
    </div>
   @endif



     



 
    <div class="watch-and-learn-txt">
            <div class="border-home-brfands"></div>
          
            {{-- <div class="main-div-watchs"> --}}
               {{--  <div class="toprtd viewall-btns-idx">Learn More<span>
                     <a href="{{ url('/') }}/learnmore" class="butn-def">View All</a>
                 </div> --}}
                {{-- <div class="p-watch-lrnt">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div> --}}
            {{-- </div> --}}


<div class="toprtd viewall-btns-idx">
   <span>Learn More</span> 

      @php 
      if(isset($arr_product_news) && count($arr_product_news)<=4)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';  
      @endphp

   <a href="{{ url('/') }}/learnmore" class="{{ $class }}">View All </a>
 </div>


   @if(!empty($arr_product_news) && count($arr_product_news)>0)  
       <div class="featuredbrands-flex">
          {{--  <ul id="flexiselDemo5">      --}}   

          <ul
            @if(isset($arr_product_news) && count($arr_product_news)<=4)
            class="f-cat-below7" 
            @elseif(isset($arr_product_news) && count($arr_product_news)>4)
            id="flexiselDemo5"
            @endif
          > 

              @foreach($arr_product_news as $news)
                <li>
                    <div class="watch-video-lrns">
                        <div class="video-idx-cw">
                            <a href="javascript:void(0)" onclick="openVideo(this);"  data-video-id="{{ $news['url_id'] or '' }}" data-video-autoplay="1" data-video-url="{{ $news['video_url'] }}" class="vides-idx"></a>
                            <img src="{{url('/')}}/uploads/product_news/{{ $news['image'] }}" alt="" />
                        </div>
                        <div class="watch-main-cnts">
                            <div class="title-vdo-wtch">{{ ucfirst($news['title'])  }}</div>
                            <div class="shop-pharmacy-sub">{{ ucfirst($news['subtitle']) }}</div>
                        </div>
                    </div>
                </li>
                 @endforeach
             </ul>
         </div>
            @endif    
    </div>
</div>
</div>

<div  class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
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
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>



{{-- <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/bootstrap.min.js"></script> --}}
    {{-- <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/customjs.js"></script> --}}
    <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/jquery.flexisel.js"></script>


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
    });  

    function openVideo(ref){
      let videoID = $(ref).attr('data-video-id');
      let videoUrl = 'https://www.youtube.com/embed/'+videoID/*+'?autoplay=1'*/;

      $("#yt-player iframe.youtube-video").attr("src",videoUrl);

      $("#videoModal").modal();
    }

    $(window).load(function() {
      $("#flexiselDemo1").flexisel(); 
      $("#flexiselDemo2").flexisel({
      visibleItems: 5,
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
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });
      $("#flexiselDemo3").flexisel({
          visibleItems: 5,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: true,
          interval: 5000,
          pauseOnHover: true
      }
      });
      $("#flexiselDemo5").flexisel({
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
    
    });
    </script>
@endsection