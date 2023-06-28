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


<script type="text/javascript">
  

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

</script>