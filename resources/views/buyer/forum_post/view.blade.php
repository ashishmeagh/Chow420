@extends('buyer.layout.master')

@section('main_content')
 <link href="{{url('/')}}/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />

<style>
.list-order-list {
    padding: 20px;
}
.classordermain .productnames.prodct-nms-slr{color: #000}
.list-order-list-left {
    height: auto;
}
.order-id-main-left {
    float: none;
}
.list-order-list-right {
    margin-left: 140px;
}
.productnames {
    float: left;
}
.classordermain .ordr-id-nm{
    margin-left: 110px;
}
.classordermain{margin-bottom:20px;}
.classordermain .productnames{margin-top:6px; margin-right: 5px; color: #9b9b9b;}
.classordermain .productnames span{color: #000;}
.classordermain .price-order-my{ margin-left: 80px; margin-top:0px;}
.order-id-main-right.activeposin{
position: absolute; top:10px; right:10px;
}
.classordermain .ordr-id-nm{font-size: 16px;}
.classordermain .price-order-my{font-size: 23px;}
.morecontent span {
  display: none;
}
.morelink {
    display: block;
    color: red;
}
.morelink:hover,.morelink:focus{
  color: red;
}
.morelink.less
{
  color: red;
}
.whitecol{
  color:white!important;
}
.classordermain .productnames {
    margin-top: 0 !important; font-weight: 600 !important;
}
.classordermain .ordr-id-nm {
    margin-left: 170px !important;
}


@media (max-width: 650px){
.classordermain .productnames {
    margin-top: 0 !important; font-weight: 600 !important;
}
.classordermain .ordr-id-nm {
    margin-left: 0px !important;
}
.productnames {
    float: none !important;
}
}



</style> 
{{-- {{dd($arr_post_data)}} --}}
<div class="my-profile-pgnm">
{{$page_title}}
<ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}">Home</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/buyer/posts">Forum Posts</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>View Forum Post Details</li>
    </ul>
</div>
<div class="chow-homepg">Chow420 Home Page</div>
    <div class="new-wrapper">
        <div class="order-main-dvs">
            <div class="buyer-order-details ">
                <div class="order-id-main-right activeposin">
                @if($arr_post_data['is_active']==1)
                <div class="status-completed">Active</div>
                @else          
                <div class="status-shipped">Block</div>
                @endif
            </div>
        <div class="order-id-main">


           <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Forum Container :
                  @if($arr_post_data['get_container_detail']['title']) </div> <div class="ordr-id-nm">{{ $arr_post_data['get_container_detail']['title'] }} </div> 
                  @else
                  NA
                  @endif</span>
                </div> 
                <div class="clearfix"></div>
            </div>
 

            <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Post Title : </div>   
                 <div class="ordr-id-nm">
                    @if(isset($arr_post_data['title']) && !empty($arr_post_data['title']))
                     @php echo $arr_post_data['title'] @endphp
                    @else
                      NA
                    @endif
                 </div>
               
                <div class="clearfix"></div>
            </div>
            
          {{--   <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Post Description : </div>   
                 <div class="ordr-id-nm decs-p">{{$arr_post_data['description'] or 'NA'}}</div>
               
                <div class="clearfix"></div>
            </div> --}}
            
             <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Added On : </div>   
                <div class="ordr-id-nm"> 
                 {{--   {{ \Carbon\Carbon::parse($arr_post_data['created_at'])->diffForHumans() }} --}}
                    {{ date("M d Y H:i A",strtotime($arr_post_data['created_at'])) }} 
                </div>
               
                <div class="clearfix"></div>
            </div>

             <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Type : </div>   
                <div class="ordr-id-nm"> @if(isset($arr_post_data['post_type']) && !empty($arr_post_data['post_type'])) {{ $arr_post_data['post_type'] }} @else NA @endif</div>
                <div class="clearfix"></div>
            </div>


            @if(isset($arr_post_data['post_type']) && $arr_post_data['post_type']=="image")

             <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Image : </div>   
              @php 
               if(isset($arr_post_data['image']) && $arr_post_data['image'] != '' && file_exists(base_path().'/uploads/post/'.$arr_post_data['image'])){
              @endphp
           
                <div class="ordr-id-nm"> 
                   <a href="{{ url('/') }}/uploads/post/{{$arr_post_data['image']}}" target="_blank">
                     <img src="{{ url('/') }}/uploads/post/{{$arr_post_data['image']}}" alt="Image" width="100"> 
                   </a>
                </div>
                <div class="clearfix"></div>
           
             @php
            }else{ 
            @endphp  
             <div class="ordr-id-nm">  NA </div>
            @php } @endphp
            </div>
             @endif 



            @if(isset($arr_post_data['post_type']) && $arr_post_data['post_type']=="video")

             <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Video : </div>   
              @php 
               if(isset($arr_post_data['video']) && $arr_post_data['video'] != ''){
              @endphp
           
                <div class="ordr-id-nm"> 
                  
                   @php 
                       $video_arr = explode("v=",$arr_post_data['video']);
                       $video_id = $video_arr[1];
                   @endphp
                  <div class="forum-video">
                    <iframe src="https://www.youtube.com/embed/{{ $video_id }}"></iframe>
                  </div>
                </div>
                <div class="clearfix"></div>
           
             @php
            }else{ 
            @endphp  
             <div class="ordr-id-nm">  NA </div>
            @php } @endphp
            </div>
           @endif 

           @if(isset($arr_post_data['post_type']) && $arr_post_data['post_type']=="link")

             <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Link : </div>   
                <div class="ordr-id-nm"> 
                @if(isset($arr_post_data['link']) && $arr_post_data['link']!='') 
               <a href="{{ $arr_post_data['link'] }}" target="_blank"> {{ $arr_post_data['link'] }} </a>
                @else
                 NA
               @endif</div>
                <div class="clearfix"></div>
            </div>
                         
           @endif              


            <div class="clearfix"></div>

             <a href="{{ url('/') }}/buyer/posts" class="butn-def cancelbtnss pull-right">Back</a>
              <div class="clearfix"></div>
            
        </div> 
        
   
    {{--  <div class="button-subtotal">
        
       <div class="button-subtotal-right">
         <a href="{{ url('/') }}/buyer/posts" class="butn-def cancelbtnss">Back</a>
       </div>
    
       <div class="clearfix"></div>
     </div>
 --}}

     </div>
   </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 200;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";
    

    $('.decs-p').each(function() {
        var content = $(this).html().trim();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
  
   


    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
</script>



@endsection