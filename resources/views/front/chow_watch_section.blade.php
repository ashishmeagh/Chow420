 
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

                             <img src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$chow_watch_image}}" alt="{{ ucfirst($news['title'])  }}" class="lozad"/>

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

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">
 
  /*--global variable declaration--*/
  var screenWidth = window.screen.availWidth;

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();
  
      if(parseInt(screenWidth) < parseInt(768)){
        
        $("#flexiselDemo5").removeAttr('id');

        $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

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

</script>  