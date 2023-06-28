

@if(isset($arr_shop_by_spectrum) && count($arr_shop_by_spectrum)>0)
<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>
  <div class="toprtd viewall-btns-idx">Shop by Spectrum
    {{-- <span class="shopbyeffect-subheading">(Solely based of customer reviews)</span> --}}
  </div>
<div class="shop-by-effect-main-parnts">
      @foreach($arr_shop_by_spectrum as $shop_by_spectrum)
        <div class="shop-by-effect-cols shop-by-spectrum">

          <div class="shop-by-effect-main">
            <a href="{{ isset( $shop_by_spectrum['link_url'])?ucwords($shop_by_spectrum['link_url']):''}}" >
              <div class="shop-by-effect-img">
                @if(file_exists(base_path().'/uploads/shop_by_spectrum/'.$shop_by_spectrum['image']) && isset($shop_by_spectrum['image']))
                <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/shop_by_spectrum/{{$shop_by_spectrum['image']}}"
                alt="{{ isset( $shop_by_spectrum['title'])?ucwords($shop_by_spectrum['title']):''}}" />
                @endif

              </div>
              <div class="shop-by-effect-content">
                  <div class="titlebrds">{{ isset( $shop_by_spectrum['title'])?ucwords($shop_by_spectrum['title']):''}}</div>
                  <span>{{ isset( $shop_by_spectrum['subtitle'])?$shop_by_spectrum['subtitle']:''}}</span>
                </div>
            </a>
          </div>
        </div>
      @endforeach
    </div>
@endif


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();

      
  });

</script>