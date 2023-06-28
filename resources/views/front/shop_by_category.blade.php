
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

              <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$shop_by_category_image}}"  alt="{{ $featured_category['product_type'] }}" />

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


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();


      var screenWidth = window.screen.availWidth;
            
      if(parseInt(screenWidth) < parseInt(768)){
          $("#flexiselDemo86").removeAttr('id');

          $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

        }

     
  })


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


</script> 