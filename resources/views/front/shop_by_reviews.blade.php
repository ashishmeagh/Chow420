
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


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();

      var screenWidth = window.screen.availWidth;
            
      if(parseInt(screenWidth) < parseInt(768)){

        $("#flexisel792").removeAttr('id');

        $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

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

</script>