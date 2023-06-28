@extends('front.layout.master',['page_title'=>'Shop By Dispensary'])
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
 
 
 @php
    if($isMobileDevice==1){

        $device_count = 2;
    }
    else {
        $device_count = 5;
    }

@endphp

<style type="text/css">
	.top-rated-brands-list{
		min-height: 192px;
	}
</style>
<div class="shop-by-brand-main">
	<div class="container">
		{{-- <div class="titlteshopbrands">Shop By Dispensary</div> --}}
		<h1>Shop By Dispensary</h1>


		<!------------------featured brand section added here----------->

		  @php
	      if(isset($arr_featuredseller) && count($arr_featuredseller)<=$device_count)
	      $class = 'butn-def viewall-product';
	      else
	      $class = 'butn-def';  
	      @endphp

        
	      <div class="border-home-brfands"></div>
	        @if(isset($arr_featuredseller) && count($arr_featuredseller)>0)  
	        <div class="shopbrandlistmaindv">
	        <div class="toprtd viewall-btns-idx">Featured Dispensaries
	       {{--  <a href="{{ url('/') }}/shopbrand" class="{{ $class }}" title="View all">View All</a> --}}
	        <div class="clearfix"></div>
	        </div>
	        <div class="featuredbrands-flex smallsize-brand-img brand-imgsection-class seller-featured-c">

	       <ul 
	        @if(isset($arr_featuredseller) && count($arr_featuredseller)<=$device_count)
	        class="f-cat-below7" 
	        @elseif(isset($arr_featuredseller) && count($arr_featuredseller)>$device_count)
	        id="flexiselDemo3"
	        @endif
	        >          

	          @foreach($arr_featuredseller as $featured_seller)
               
	         {{--   @if(isset($featured_seller['seller_detail']['get_products']) && count($featured_seller['seller_detail']['get_products'])>0) --}}

	            <li>
	              <div class="top-rated-brands-list">
	                 @php
	                  $seller_name = isset($featured_seller['seller_detail']['business_name'])?$featured_seller['seller_detail']['business_name']:'';
	                  $businessname = str_replace(" ", "-", $seller_name);    

	                 @endphp 


	                <a href="{{ url('/') }}/search?sellers={{ isset($businessname)?
	                           $businessname:''}}" class="brands-citcles">
	                  <div class="img-rated-brands">
	                  	 <div class="images-vertcls">
                           @php 
                           $img_path_small= $img_path = $img_path_medium="";

                            if(isset($featured_seller['get_sellerbanner_detail']) && !empty($featured_seller['get_sellerbanner_detail']) && file_exists(base_path().'/uploads/seller_banner/'.$featured_seller['get_sellerbanner_detail']['image_name']) && $featured_seller['get_sellerbanner_detail']['image_name']!="")
				            {             

				               $img_path =url('/uploads/seller_banner/'.$featured_seller['get_sellerbanner_detail']['image_name']);
				            }
				          else if(isset($featured_seller['get_sellerbanner_detail']) && !empty($featured_seller['get_sellerbanner_detail']) && file_exists(base_path().'/uploads/seller_banner/'.$featured_seller['get_sellerbanner_detail']['image_medium']) && $featured_seller['get_sellerbanner_detail']['image_medium']!="")
				            {           


				              $img_path =url('/uploads/seller_banner/'.$featured_seller['get_sellerbanner_detail']['image_medium']);
				            }
				                   

				            else if(isset($featured_seller['get_sellerbanner_detail']) && !empty($featured_seller['get_sellerbanner_detail']) && file_exists(base_path().'/uploads/seller_banner/'.$featured_seller['get_sellerbanner_detail']['image_small']) && $featured_seller['get_sellerbanner_detail']['image_small']!="")
				            {             
				                        
				              $img_path =url('/uploads/seller_banner/'.$featured_seller['get_sellerbanner_detail']['image_small']);
				            } 
				            else
				            {
				              $img_path =url('/').'/assets/front/images/chow-bnr-img-small.jpg';
				            }

				          

                          @endphp

	                      @if(isset($img_path))
	                        <img src="{{ $img_path}}" alt="Dispensary" />
	                     {{--   @elseif(isset($img_path_medium))
	                        <img src="{{ $img_path_medium}}" alt="Dispensary" />  
	                       @elseif(isset($img_path_small))
	                        <img src="{{ $img_path_small}}" alt="Dispensary" />  --}}
	                      @endif
	                    </div>
	                    <div class="content-brands">                       
	                        <div class="titlebrds">{{ isset( $featured_seller['seller_detail']['business_name'])?ucwords($featured_seller['seller_detail']['business_name']):''}}

	                        </div>                           
	                    </div>
	                </div>
	              </a>
	            </li>  
	           {{--  @endif  --}}         
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

				
				 @if(isset($sellerarr) && !empty($sellerarr))
				 @foreach($sellerarr as $seller)
				    <li><a href="#brands-{{ $seller['char'] }}"  id="{{ $seller['char'] }}">{{ $seller['char'] }}</a>
				    </li>
				 @endforeach
				 @endif 

				
			</ul>
			<div class="brands-list">

				  @if(isset($sellerarr) && !empty($sellerarr))
				     @foreach($sellerarr as $range)
         				<div class="brand-list show" id="brands-{{ $range['char'] }}-page"> 
							<h2>{{ $range['char'] }}</h2>

							<ul id="sethtml_{{ $range['char'] }}" class="sethtml">

								@php
									
									if(!empty($range['name'])){
										foreach($range['name'] as $seller){
										
										 $seller_name = str_replace(" ", "-", $seller['name']);		
										 $url = url('search?sellers='.$seller_name); 			

									@endphp
									    <li><a href="{{ $url }}">{{ ucwords($seller['name']) }}</a></li>
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


<script>


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
<!-------------script added for featured brand section------------------------>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/jquery.flexisel.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        var screenWidth = window.screen.availWidth;
        if(parseInt(screenWidth) < parseInt(768)){
          $("#flexiselDemo3").removeAttr('id');
        }
    });
</script>


<script>
	 $(window).load(function() {
	 	 $("#flexiselDemo3").flexisel({
          visibleItems: 4,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: true,
          interval: 5000,
          pauseOnHover: true
      }
      });

	 });


</script>
<!-------------end of script added for featured brand section------------------------>



@endsection