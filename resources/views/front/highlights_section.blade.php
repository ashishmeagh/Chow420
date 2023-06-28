
@if(isset($arr_highlights) && count($arr_highlights) > 0)
<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>
@php
  $highlight_res_header='';
  $get_highlight_header = get_highlight_header();
  if(isset($get_highlight_header) && !empty($get_highlight_header))
  {
    $highlight_res_header = $get_highlight_header;
  }
@endphp

@if(isset($highlight_res_header) && !empty($highlight_res_header))
 <div class="header-txt-chow"> @php echo $highlight_res_header @endphp</div>
@endif
<!-------------end--highlight header-------------------------->

<!-------------start--highlight subheader------------------------>

@php
  $highlight_res_subheader='';
  $get_highlight_subheader = get_highlight_subheader();
  if(isset($get_highlight_subheader) && !empty($get_highlight_subheader))
  {
    $highlight_res_subheader = $get_highlight_subheader;
  }
@endphp

@if(isset($highlight_res_subheader) && !empty($highlight_res_subheader))
 <div class="subheader-txt-chow"> @php echo $highlight_res_subheader @endphp</div>
@endif

@endif
<!-------------end--highlight subheader-------------------------->

</div>
<!-------------start highlight------------------------------------>
@if(isset($arr_highlights) && count($arr_highlights) > 0)
<div class="boxhomepage-bnr highlight-sec">
  <div class="container">
    <div class="row">
      @foreach($arr_highlights as $highlight)
        <div class="col-xd-6 col-sm-4 col-md-4 col-lg-4">
          <div class="categry-main-topview">
            <div class="categry-main-topview-icon">
              @if(file_exists(base_path().'/uploads/highlights/'.$highlight['hilight_image']) && isset($highlight['hilight_image']))
                 
                @php
                  $highlight_image = '';
                  $highlight_image = image_resize('/uploads/highlights/'.$highlight['hilight_image'],100,100);
                @endphp

                {{--<img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/highlights/{{$highlight['hilight_image']}}"
                  alt="{{ isset( $highlight['title'])?ucwords($highlight['title']):''}}" /> --}}

                <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$highlight_image}}"
                  alt="{{ isset( $highlight['title'])?ucwords($highlight['title']):''}}" />  

              @endif

              {{-- <img src="{{url('/')}}/assets/front/images/thousands-of-items-icon.png" alt="" /> --}}
            </div>
            <div class="categry-main-topview-title">{{ isset( $highlight['title'])? ucwords($highlight['title']):''}}</div>
            <div class="categry-main-topview-contant">{{ isset( $highlight['description'])?$highlight['description']:''}}</div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endif