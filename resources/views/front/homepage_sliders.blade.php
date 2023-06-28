  
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
