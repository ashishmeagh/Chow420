@extends('front.layout.master',['page_title'=>'Chow Watch'])
@section('main_content')
 <meta name="description" content="Share your CBD story and experience with the world. Get featured on Chow watch and all our social channels. Your story deserves to be heard by the world." />
<style>
    .watch-video-lrns{
        width: 100%; text-align: left !important; vertical-align: top;
    }
    .video-idx-cw{max-width: 100%;}
.watch-main-cnts.txr-centr{ text-align: left !important;}
.spacrbtns {
    margin-bottom: 30px;
    padding-right: 7px !important;
    padding-left: 7px !important;
}
@media (max-width: 1199px){
  .row-flex {
    display: block;
    flex-wrap: initial;
    white-space: normal;
    overflow: auto; text-align: center;
}
.calwatch{width: 100% !important; max-width: 300px;}
.shop-pharmacy-sub{ min-height: 60px;}

}


h1 {
    font-size: 30px;
    text-align: left;
    font-weight: 600;
    margin-bottom: 30px;
    }


 .rw-slide-li {position:relative;}
 .rw-slide-li .hover-img {opacity:0; position: absolute; bottom: -20px;
  right: 0;
  padding: 0px 6px;
  z-index: 99;
  left: 60px;}
  .rw-slide-li:hover .hover-img {opacity:1;}

</style>
 {{-- <div class="breadcrums-lern-main">
      <div class="row">
        <div class="col-md-6"><div class="titlteshopbrands learnmr-left-txt">Learn More</div></div>
        <div class="col-md-6"><div class="breadcrums-lern-right"><span><a href="#">Home</a></span> <span>/</span> <span>Learn More</span> </div></div>
      </div>
    </div> --}}
<div class="shop-by-brand-main">
  
	<div class="space-left-right-homepage">
    <div class="container">

        

   @if(isset($banner_images_data) && !empty($banner_images_data))
     @if(isset($banner_images_data['banner_image8_desktop']) && !empty($banner_images_data['banner_image8_desktop']) && isset($banner_images_data['banner_image8_mobile']) && !empty($banner_images_data['banner_image8_mobile'])) 
        <div class="adclass-maindiv">

          <a @if(isset($banner_images_data['banner_image8_link8']))  href="{{ $banner_images_data['banner_image8_link8'] }}" target="_blank" 
                @else  href="#" @endif>

            <figure class="cw-image__figure">
               <picture>

                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image8_mobile']) && isset($banner_images_data['banner_image8_mobile'])) 
                  <source type="image/png" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image8_mobile']  }}" media="(max-width: 621px)">
                  <source type="image/jpg" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image8_mobile']  }}" media="(max-width: 621px)">
                   <source type="image/jpeg" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image8_mobile']  }}" media="(max-width: 621px)">   
                 @endif
                 
                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image8_desktop']) && isset($banner_images_data['banner_image8_desktop']))    
                  <source type="image/png" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image8_desktop']  }}" media="(min-width: 622px) and (max-width: 834px)">
                  <source type="image/jpg" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image8_desktop']  }}" media="(min-width: 622px) and (max-width: 834px)">
                  <source type="image/jpeg" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image8_desktop']  }}" media="(min-width: 622px) and (max-width: 834px)">
                 @endif

                  @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image8_desktop']) && isset($banner_images_data['banner_image8_desktop'])) 
                        <img class="cw-image cw-image--loaded obj-fit-polyfill" alt="slider image" aria-hidden="false" src="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image8_desktop']  }}">
                  @endif  

                </picture>
            </figure>
          </a>
        </div>    
     @endif    
   @endif  




	    <div class="titlteshopbrands"><h1>Chow Watch</h1></div>
	     <div class="brands-sections">
		    <div class="brands">
          <div class="">
           @if(!empty($news_arr) && count($news_arr)>0)  
           
            <div class="featuredbrands-flex">
              <div class="row-flex">
                 @foreach($news_arr as $news)
                 <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 spacrbtns rw-slide-li">
                 <div class="calwatch">
                   <div class="hover-img">
                          <!-- <img src="http://img.youtube.com/vi/{{ $news['url_id'] }}/0.jpg"> -->
                   </div>

                   <a href="javascript:void(0)" onclick="openVideo(this);"  data-video-id="{{ $news['url_id'] or '' }}" data-video-autoplay="1" data-video-url="{{ $news['video_url'] }}"
                        @if(isset($news['button_title']) && ($news['button_title']!=''))
                          data-video-btn_title="{{ $news['button_title'] }}" 
                        @endif   
                        @if(isset($news['button_url']) && ($news['button_url']!='')) 
                         data-video-btn_url="{{ $news['button_url'] }}"
                        @endif 

                   >
                    <div class="watch-video-lrns mobileviewpg-video">
                        <div class="video-idx-cw">
                           <a href="javascript:void(0)"  class="vides-idx text-center" onclick="openVideo(this);" 
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
                           <!-- <img src="{{url('/')}}/assets/front/images/video-camera-icons.svg" alt=""> -->
                           <i class="fa fa-play" aria-hidden="true"></i>
                        </a>
                            <img src="{{url('/')}}/uploads/product_news/{{ $news['image'] }}" alt="{{ ucfirst($news['title'])  }}" />
                        </div>
                        <div class="watch-main-cnts txr-centr">
                            <div class="title-vdo-wtch">{{ ucfirst($news['title'])  }}</div>
                            <div class="shop-pharmacy-sub min-height-mobile">
                           {{--  {{ ucfirst($news['subtitle']) }} --}}

                            <p> {{strlen($news['subtitle'])>42 ? wordwrap(substr($news['subtitle'],0,130),26,"\n",TRUE)."..." : $news['subtitle']}}</p>
                           
                            </div>
                        </div>
                    </div>
                    </a>
                     </div>
                     </div>
                 @endforeach
             
             </div>
           </div>
            @endif    
		     </div>
        </div>  
         <div class="pagination-chow"> 
			      @if(!empty($arr_pagination))
                {{$arr_pagination->render()}}    
            @endif 
        </div>
	  </div>

	</div> <!-------container---------------->
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
      <div class="modal-footer"></div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>

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
      var btn_title = $(ref).attr('data-video-btn_title');
      var btn_url = $(ref).attr('data-video-btn_url');
      let videoUrl = 'https://www.youtube.com/embed/'+videoID/*+'?autoplay=1'*/;
      var title = $(ref).attr('data-video-title');

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
</script>
<script src="{{url('/')}}/assets/front/js/imagepreview.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $('.preview').anarchytip();
</script>
@endsection