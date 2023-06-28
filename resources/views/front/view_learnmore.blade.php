@extends('front.layout.master',['page_title'=>'Learn More'])
@section('main_content')
<style>
    .watch-video-lrns{
        margin-bottom: 30px; width: 100%; text-align: left !important; vertical-align: top;
    }
    .video-idx-cw{max-width: 100%;}
.watch-main-cnts.txr-centr{ text-align: left !important;}
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
	<div class="titlteshopbrands tccentermobile">Watch and Learn</div>
	   <div class="brands-sections">
		 <div class="brands">
<div class="">
           @if(!empty($news_arr) && count($news_arr)>0)  
           
            <div class="featuredbrands-flex">
              <div class="rowwatch">
                 @foreach($news_arr as $news)
                 <div class="calwatch">
                   <a href="javascript:void(0)" onclick="openVideo(this);"  data-video-id="{{ $news['url_id'] or '' }}" data-video-autoplay="1" data-video-url="{{ $news['video_url'] }}">
                    <div class="watch-video-lrns mobileviewpg-video">
                        <div class="video-idx-cw">
                           
                            <img src="{{url('/')}}/uploads/product_news/{{ $news['image'] }}" alt="" />
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
</script>
		
@endsection