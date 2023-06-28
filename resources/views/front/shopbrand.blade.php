@extends('front.layout.master',['page_title'=>'Shop by Brand'])
@section('main_content')
<style>
/*css added for making title as h1*/
h1{
    font-size: 30px;
    text-align: left;
    font-weight: 600;
    margin-bottom: 30px;
}
</style>

@inject('brand','App\Models\BrandModel')
 
 
 @php
    if($isMobileDevice==1){

        $device_count = 2;
    }
    else {
        $device_count = 5;
    }

@endphp


<div class="shop-by-brand-main">
	<div class="container">




   @if(isset($banner_images_data) && !empty($banner_images_data))
     @if(isset($banner_images_data['banner_image7_desktop']) && !empty($banner_images_data['banner_image7_desktop']) && isset($banner_images_data['banner_image7_mobile']) && !empty($banner_images_data['banner_image7_mobile'])) 
        <div class="adclass-maindiv">
         <a @if(isset($banner_images_data['banner_image7_link7']))  href="{{ $banner_images_data['banner_image7_link7'] }}" target="_blank" 
                @else  href="#" @endif>
            <figure class="cw-image__figure">
               <picture>

                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image7_mobile']) && isset($banner_images_data['banner_image7_mobile'])) 
                  <source type="image/png" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image7_mobile']  }}" media="(max-width: 621px)">
                  <source type="image/jpg" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image7_mobile']  }}" media="(max-width: 621px)">
                   <source type="image/jpeg" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image7_mobile']  }}" media="(max-width: 621px)">   
                 @endif
                 
                 @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image7_desktop']) && isset($banner_images_data['banner_image7_desktop']))    
                  <source type="image/png" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image7_desktop']  }}" media="(min-width: 622px) and (max-width: 834px)">
                  <source type="image/jpg" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image7_desktop']  }}" media="(min-width: 622px) and (max-width: 834px)">
                  <source type="image/jpeg" srcset="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image7_desktop']  }}" media="(min-width: 622px) and (max-width: 834px)">
                 @endif

                  @if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image7_desktop']) && isset($banner_images_data['banner_image7_desktop'])) 
                        <img class="cw-image cw-image--loaded obj-fit-polyfill lozad" alt="slider image" aria-hidden="false" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/banner_images/{{ $banner_images_data['banner_image7_desktop']  }}">
                  @endif  

                </picture>
            </figure>
          </a>
        </div>    
     @endif    
   @endif  







		{{-- <div class="titlteshopbrands">Shop By Brand</div> --}}
		{{-- <h1>Shop By Brand</h1> --}}


		<!------------------featured brand section added here----------->

		  @php
	      if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count)
	      $class = 'butn-def viewall-product';
	      else
	      $class = 'butn-def';  
	      @endphp

        
	      <div class="border-home-brfands"></div>
	        @if(isset($arr_featured_brands) && count($arr_featured_brands)>0)  
	        <div class="shopbrandlistmaindv">
	        <div class="toprtd viewall-btns-idx">Top brands
	       {{--  <a href="{{ url('/') }}/shopbrand" class="{{ $class }}" title="View all">View All</a> --}}
	        <div class="clearfix"></div>
	        </div>
	        <div class="featuredbrands-flex smallsize-brand-img brand-imgsection-class">

	       <ul 
	        @if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count)
	        class="f-cat-below7" 
	        @elseif(isset($arr_featured_brands) && count($arr_featured_brands)>$device_count)
	        id="flexiselDemo3"
	        @endif
	        >          

	          @foreach($arr_featured_brands as $featured_brands)
	            <li>
	              <div class="top-rated-brands-list">
	                 @php
	                  $brand_name = isset($featured_brands['name'])?$featured_brands['name']:'';
	                  $brandname = str_replace(" ", "-", $brand_name);    

	                 @endphp 


	                <a href="{{ url('/') }}/search?brands={{ isset($brandname)?
	                           $brandname:''}}" class="brands-citcles">
	                  <div class="img-rated-brands">
	                      @if(file_exists(base_path().'/uploads/brands/'.$featured_brands['image']) && isset($featured_brands['image']))
	                      <img data-src="{{url('/')}}/uploads/brands/{{$featured_brands['image']}}" alt="{{ $brand_name }}" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" class="lozad"/>
	                      @endif
	                    <div class="content-brands">                       
	                        <div class="titlebrds">{{ isset( $featured_brands['name'])?ucwords($featured_brands['name']):''}}</div>                           
	                    </div>
	                </div>
	              </a>
	            </li>            
	          @endforeach
	        </ul> 
	      </div>
	      </div>
	     @endif 

	     <div class="clearfix"></div> <br/>
<hr>
		<!-----------------end of featured brand section----------------->

		
		<div class="brands-sections">
			<div class="brands">
			<ul class="letters">
				<li class="active"><a href="#viewall">All</a></li>
				@php 
				$range_arr = range("A","Z");
				@endphp

				<!--commented for showing only those records which has brand-->
				 {{-- @if(isset($range_arr) && !empty($range_arr))
				 @foreach($range_arr as $range)
				    <li><a href="#brands-{{ $range }}"  id="{{ $range }}">{{ $range }}</a>
				    </li>
				 @endforeach
				 @endif  --}}

				 @if(isset($brandarr) && !empty($brandarr))
				 @foreach($brandarr as $brand)
				    <li><a href="#brands-{{ $brand['char'] }}"  id="{{ $brand['char'] }}">{{ $brand['char'] }}</a>
				    </li>
				 @endforeach
				 @endif 

				
			</ul> 
			<div class="brands-list">

				  @if(isset($brandarr) && !empty($brandarr))
				     @foreach($brandarr as $range)
         				<div class="brand-list show" id="brands-{{ $range['char'] }}-page"> 
							<h2>{{ $range['char'] }}</h2>

							<ul id="sethtml_{{ $range['char'] }}" class="sethtml">

								@php
									$url = '';
									if(!empty($range['name'])){
										foreach($range['name'] as $brands){
										// $url = url('search?brands='.base64_encode($brands['name'])); 	
										 $brand_name = str_replace(" ", "-", $brands['name']);		
										 $url = url('search?brands='.$brand_name); 			

									@endphp
									    <li><a href="{{ $url }}">{{ $brands['name'] }}</a></li>
									@php
								        } //foreach
									 }//if not empty brandlist
									 else{
									 	echo "<li><a href='javascript:void(0)'>Not Availiable</a></li>"; 
									 }
								@endphp

							</ul>
							
							<div class="clearfix"></div>

     					</div>
					 @endforeach
				 @endif 
				
				
			</div>
			</div>
		</div>

	</div>
</div>



@endsection


<!-- page script start -->

@section("page_script")
  
<!-------------script added for featured brand section------------------------>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/jquery.flexisel.js"></script>


<script type="text/javascript">
	
    $(document).ready(function(){

        var screenWidth = window.screen.availWidth;
        if(parseInt(screenWidth) < parseInt(768)){
          $("#flexiselDemo3").removeAttr('id');
        }
    });


	 $(window).load(function() {
	 	 $("#flexiselDemo3").flexisel({
          visibleItems: 5,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: true,
          interval: 5000,
          pauseOnHover: true
      }
      });

	 });





$('.brands').on('click', '.letters li:not(.disabled) a', function(e) {
	e.preventDefault();
	$(this).closest("ul").find("li").each(function(e) {
		$(this).removeClass("active");
	});

	$(this).parent().addClass("active");
	var attr = $(this).attr("href");
	var range = $(this).attr("id");
	
	if(attr === "#viewall") {
		$(".brand-list").addClass("show");
	}
	else {
		$(".brand-list")
		  .removeClass("show")
	      .removeClass("active");
		$(attr + '-page').addClass("active");
	}


});

</script>

<!-------------end of script added for featured brand section------------------------>
@endsection