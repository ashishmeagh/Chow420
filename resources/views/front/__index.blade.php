@extends('front.layout.master')
@section('main_content')


<style type="text/css">
    .carousel li {
    width: 10px;
    height: 10px;
} 
.carousel-indicators{margin-left: 0px;}
.price-listing.pricestatick{position: static; text-align: left;padding-left: 0px;}
.price-listing.pricestatick span{
  display: block;
}
.promo-block--header {
    text-shadow: 1px 1px 1px #333;
}
.promotions-updatepg.noneidts{padding-top: 0px;}
.price-listing.pricestatick .pricevies{float: none;}
@media (max-width: 991px){
.closebtnslist.filternw { display: none !important; }
}

.toprtd.viewall-btns-idx.smallfonts.spacenonnn{padding-right: 0px;}

</style>
<!--Slider section start here-->

<!-- space-left-right-homepage -->

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
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
               
                <div class="{{ $active }}" style="background: url({{url('/')}}/uploads/slider_images/{{ $slide['slider_image']  }}) no-repeat ;background-position: center center; -webkit-background-size: 100% 100%;
                    -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%; margin: 0px;padding: 0; cursor: pointer" onclick="window.location.href='{{ isset($slide['image_url'])?$slide['image_url']:'' }}'">
                   
                        <div class="container">
                        <div class="carousel-caption">
                         <div class="banner-text-block">
                               <div class="modarn-hm">{{ isset($slide['title'])?$slide['title']:''}}</div>
                                    <h1>{{ $slide['subtitle'] or '' }}</h1>
                                     <div class="button-rev pull-right">
                                        {{-- <a target="_blank" href="{{ isset($slide['image_url'])?$slide['image_url']:"" }}" class="butn-def">Shop Now</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                 
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
</div>


<div class="container">

<!--Slider section start here-->
<div class="top-rated-brands-main homepagenewlistings">

 @if(isset($arr_product) && count($arr_product)>0)
        <div class="toprtd non-mgts viewall-btns-idx">Top Rated Products 

          @php
          if(isset($arr_product) && count($arr_product)<=5)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';  
          @endphp

         <a href="{{ url('/') }}/search" class="{{ $class }}" title="View all">View All</a>
        </div>
       
        <div class="featuredbrands-flex">         
          <ul @if(isset($arr_product) && count($arr_product)<=5)    
             class="f-cat-below7"      
           @elseif(isset($arr_product) && count($arr_product)>5)
              id="flexiselDemo1"
           @endif
         >
       
            @foreach($arr_product as $product)
              @php 
                       $avg_rating = $product->avg_rating;
                       $avg_rating  = round_rating_in_half($avg_rating);
                       if($avg_rating==1){$rating = 'one';}
                       else if($avg_rating==2){$rating = 'two';}
                       else if($avg_rating==3){$rating = 'three';}
                       else if($avg_rating==4){$rating = 'four';}
                       else if($avg_rating==5){$rating = 'five';}else
                       if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}
              @endphp

             <li>
                <div class="top-rated-brands-list">
                    @php
                      $product_title = isset($product->product_name) ? $product->product_name : '';
                      $product_title_slug = str_slug($product_title);
                    @endphp
                    <a href="{{url('/')}}/search/product_detail/{{isset($product->id)?base64_encode($product->id):'0'}}/{{ $product_title_slug }}"  title="{{ $product->product_name }}"><div class="img-rated-brands">
                    <div class="thumbnailss">
                
                     @if(!empty($product->image) && file_exists(base_path().'/uploads/product_images/'.$product->image))

                            <img src="{{url('/')}}/uploads/product_images/{{ $product->image }}" class="portrait" alt="" />

                            @endif
                        </div>
                        <div class="content-brands">
                            {{-- <div class="price-listing pricestatick"> <del class="pricevies">$18.91</del><span>$18.91 </span></div> --}}

                              <div class="price-listing pricestatick"> 
                                    @if(isset($product->price_drop_to))
                                      @if($product->price_drop_to>0)
                                        <del class="pricevies">

                                        ${{isset($product->unit_price) ? num_format($product->unit_price) : '0'}}

                                      </del>
                                        <span>${{isset($product->price_drop_to) ? num_format($product->price_drop_to) : '0'}} </span>
                                      @else

                                        <del class="pricevies"></del>
                                        <span>${{isset($product->unit_price) ? num_format($product->unit_price) : '0'}} </span>
                                      @endif
                                    @else
                                      <del class="pricevies"></del>

                                      <span>${{isset($product->unit_price) ? num_format($product->unit_price) : '0'}} </span>
                                    @endif  
                               </div>



                            <div class="titlebrds">{{ ucwords($product->product_name)  }}</div> 
                            <div class="starthomlist">
                              @if($avg_rating>0 && isset($rating))
                                <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="" />
                              @else
                               <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" />
                              @endif  
                            </div>
                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li> 
         @endforeach        
        </ul> 
    </div>
    @endif 

<!----------------------------start of trending products------------------------>
  {{-- <div class="border-home-brfands"></div>
      @php
      if(isset($arr_trending) && count($arr_trending)<=5)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';  
      @endphp

       @if(isset($arr_trending) && count($arr_trending)>0)  
       <div class="toprtd viewall-btns-idx">Trending 
        <a href="{{ url('/') }}/search" class="{{ $class }}" title="View all">View All </a>
       </div>
       <div class="featuredbrands-flex">
       <ul 
        @if(isset($arr_trending) && count($arr_trending)<=5)
        class="f-cat-below7" 
        @elseif(isset($arr_trending) && count($arr_trending)>5)
        id="flexiselDemo2"
        @endif
        >
        @foreach($arr_trending as $trend_product)
             @php  
                       $avg_rating = $trend_product->avg_rating;
                       $avg_rating  = round_rating_in_half($avg_rating);

                     //  $avg_rating = get_avg_rating($trend_product['product_details']['id']);
                       if($avg_rating==1){$rating = 'one';}
                       else if($avg_rating==2){$rating = 'two';}
                       else if($avg_rating==3){$rating = 'three';}
                       else if($avg_rating==4){$rating = 'four';}
                       else if($avg_rating==5){$rating = 'five';}
                       else if($avg_rating==0.5){$rating = 'zeropointfive';}
                       else if($avg_rating==1.5){$rating = 'onepointfive';}
                       else if($avg_rating==2.5){$rating = 'twopointfive';}
                       else if($avg_rating==3.5){$rating = 'threepointfive';}
                       else if($avg_rating==4.5){$rating = 'fourpointfive';}
              @endphp

             <li>
                <div class="top-rated-brands-list">
                    @php
                      $product_title = isset($trend_product->product_name) ? $trend_product->product_name : '';
                      $product_title_slug = str_slug($product_title);
                    @endphp

                    <a href="{{url('/')}}/search/product_detail/{{isset($trend_product->id)?base64_encode($trend_product->id):'0'}}" title="{{ $trend_product->product_name }}/{{ $product_title_slug }}">

                        <div class="img-rated-brands">
                            <div class="thumbnailss"> 
                                @if(file_exists(base_path().'/uploads/product_images/'.$trend_product->image) && isset($trend_product->image))
                                <img src="{{url('/')}}/uploads/product_images/{{ $trend_product->image}}" class="portrait" alt="" />
                                @endif
                            </div>
                            <div class="content-brands">
                                <div class="starthomlist">
                                  @if($avg_rating>0)
                                    <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="" />
                                  @else
                                   <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" />
                                  @endif  
                                </div>
                                <div class="titlebrds">{{ ucwords($trend_product->product_name) }}</div>                           
                            </div>
                        </div>
                    </a>
                </div>
             </li>
        @endforeach
      </ul>
  </div>
 @endif  --}}
<!-------------------end of trending products--------------------------->

<!----------------start of most recent------------------->
    
  {{-- <div class="border-home-brfands"></div>
      @php
      if(isset($arr_mostrecent_product) && count($arr_mostrecent_product)<=5)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';  
      @endphp

       @if(isset($arr_mostrecent_product) && count($arr_mostrecent_product)>0)  
       <div class="toprtd viewall-btns-idx">Most Recent Products
        <a href="{{ url('/') }}/search" class="{{ $class }}" title="View all">View All </a>
       </div>
       <div class="featuredbrands-flex">
       <ul 
        @if(isset($arr_mostrecent_product) && count($arr_mostrecent_product)<=5)
        class="f-cat-below7" 
        @elseif(isset($arr_mostrecent_product) && count($arr_mostrecent_product)>5)
        id="flexiselDemo2"
        @endif
        >
        @foreach($arr_mostrecent_product as $recent_product)
             @php  
                      // $avg_rating = $recent_product->avg_rating;
                      // $avg_rating  = round_rating_in_half($avg_rating);

                       $avg_rating = get_avg_rating($recent_product->id);
                       $avg_rating  = round_rating_in_half($avg_rating);

                       if($avg_rating==1){$rating = 'one';}
                       else if($avg_rating==2){$rating = 'two';}
                       else if($avg_rating==3){$rating = 'three';}
                       else if($avg_rating==4){$rating = 'four';}
                       else if($avg_rating==5){$rating = 'five';}
                       else if($avg_rating==0.5){$rating = 'zeropointfive';}
                       else if($avg_rating==1.5){$rating = 'onepointfive';}
                       else if($avg_rating==2.5){$rating = 'twopointfive';}
                       else if($avg_rating==3.5){$rating = 'threepointfive';}
                       else if($avg_rating==4.5){$rating = 'fourpointfive';}

                        $total_reviews = get_total_reviews($recent_product->id);

              @endphp 

             <li>
                <div class="top-rated-brands-list"> 
                    @php
                      $product_title = isset($recent_product->product_name) ? $recent_product->product_name : '';
                      $product_title_slug = str_slug($product_title);
                    @endphp

                    <a href="{{url('/')}}/search/product_detail/{{isset($recent_product->id)?base64_encode($recent_product->id):'0'}}/{{ $product_title_slug }}" title="{{ $recent_product->product_name }}">

                        <div class="img-rated-brands">
                            <div class="thumbnailss"> 
                                @if(file_exists(base_path().'/uploads/product_images/'.$recent_product->image) && isset($recent_product->image))
                                <img src="{{url('/')}}/uploads/product_images/{{ $recent_product->image}}" class="portrait" alt="" />
                                @else
                                  <img src="{{url('/')}}/assets/images/default-product-image.png" class="portrait" alt="" />
                                @endif
                            </div>
                            <div class="content-brands">
                                
                                <div class="titlebrds">{{ ucwords($recent_product->product_name) }}</div>
                                <div class="starthomlist">
                                  @if($avg_rating>0  && isset($rating))
                                    <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="" />
                                  @else
                                   <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" />
                                  @endif 

                                   @if($total_reviews > 0)
                                   <span href="#" class="str-links starcounts">{{ $total_reviews }}</span>
                                   @endif


                                </div>                           
                            </div>
                        </div>
                    </a>
                </div>
             </li>
        @endforeach
      </ul>
  </div>
 @endif 
 --}}


<hr>
        <!-- PRODUCT SHOW -->
        @if(isset($arr_search_product) && count($arr_search_product) > 0)          

              <div class="cborder-home-product">
                  <div class="main-selectslist non-paddingd">
                    <div class="toprtd viewall-btns-idx smallfonts spacenonnn"> 
                      Explore Products
                       <!-- <span>( 
                      {{ count($arr_search_product) }} of {{ $total_search_results }} results)</span> -->
                      <a href="{{ url('/') }}/search" class="{{ $class }} seeallproducts">See All Products</a>
                    </div>

                      <div class="closebtnslist filternw">
                        <span class="toggle-button">
                          <span class="filterbutton"><i class="fa fa-filter"></i> Filter</span>
                          <div class="menu-bar menu-bar-top"></div>
                          <div class="menu-bar menu-bar-middle"></div>
                          <div class="menu-bar menu-bar-bottom"></div>
                        </span>
                      </div> 

                     
                      <div class="clearfix"></div>
                  </div>
                     
                      
                  <div id="grid">
                      <div class="results-products nwhomepgresult nonw-idht newupdatedlsit">

                      @php
                        $login_user = Sentinel::check();
                        if(isset($fav_product_arr)){
                        $fav_arr    = array();
                         if(count($fav_product_arr)>0)
                        {
                         foreach($fav_product_arr as $key=>$value)
                         {
                           $fav_arr[] = $value['product_id'];
                         }

                        }
                      }

                      @endphp
                        
                      @foreach($arr_search_product as $product)

                           @php  
                                $avg_rating = get_avg_rating($product['id']);
                                if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}else
                                if($avg_rating==0.5){$rating = 'zeropointfive';}else if($avg_rating==1.5){$rating = 'onepointfive';}else if($avg_rating==2.5){$rating = 'twopointfive';}else if($avg_rating==3.5){$rating = 'threepointfive';}else if($avg_rating==4.5){$rating = 'fourpointfive';}


                                $total_review = get_total_reviews($product['id']);  
                                if($total_review>0)
                                  $total_review = $total_review;
                                else
                                   $total_review = '';

                            @endphp



                            <div class="product-holder-list product-search-list maindivnwhomepg">
                              <div class="reltv-div">
                                <div class="">

                                      @if($login_user == true)
                                      @if($login_user->inRole('buyer'))
                                           @if(isset($fav_arr) && in_array($product['id'],$fav_arr))
                                           
                                            <a href="javascript:void(0)" class="heart-icn active" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" onclick="removeFromFavorite($(this));">
                                               <i class="fa fa-heart"></i>
                                              </a>
                                          @else
                                              <a href="javascript:void(0)" class="heart-icn" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" onclick="addToFavorite($(this));">
                                                  <i class="fa fa-heart"></i>
                                              </a>
                                          @endif    
                                      @endif
                                      @else
                                        <a href="javascript:void(0)" class="heart-icn" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="product" onclick="addToFavorite($(this));">
                                              <i class="fa fa-heart"></i>
                                          </a>
                                      @endif
                               
                                    <div class="make3D">
                                        <div class="product-front">
                                            @php
                                              $product_title = isset($product['product_name']) ? $product['product_name'] : '';
                                              $product_title_slug = str_slug($product_title);
                                            @endphp
                                            <a href="{{url('/')}}/search/product_detail/{{isset($product['id'])?base64_encode($product['id']):''}}/{{ $product_title_slug }}" title="{{isset($product['product_name']) ? $product['product_name'] : ''}}">
                                             <div class="owl-carousel owl-theme">
                                          
                                             @if(isset($product['is_age_limit']) && $product['is_age_limit'] == 1 && isset($product['age_restriction']))
                                                <div class="label-list">{{$product['age_restriction_detail']['age']}}</div>

                                              @endif

                                              <div class="img-cntr item">
                                              @php
                                                 if(isset($product['product_images_details'][0]['image']) && $product['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_images_details'][0]['image']))
                                                        {
                                                          $product_img = url('/uploads/product_images/'.$product['product_images_details'][0]['image']);
                                                    }
                                                    else
                                                    {                  
                                                        $product_img = url('/assets/images/default-product-image.png');
                                                    }
                                           @endphp

                                                <img src="{{$product_img}}" class="portrait" alt="" />
                                                
                                            </div>
                                            </div>
                                             <div class="price-listing"> 
                                              @if(isset($product['price_drop_to']))
                                                @if($product['price_drop_to']>0)
                                                  <del class="pricevies">

                                                  ${{isset($product['unit_price']) ? num_format($product['unit_price']) : '0'}}

                                                </del>
                                                  <span>${{isset($product['price_drop_to']) ? num_format($product['price_drop_to']) : '0'}} </span>
                                                @else

                                                  <del class="pricevies"></del>
                                                  <span>${{isset($product['unit_price']) ? num_format($product['unit_price']) : '0'}} </span>
                                                @endif
                                              @else
                                                <del class="pricevies"></del>

                                                <span>${{isset($product['unit_price']) ? num_format($product['unit_price']) : '0'}} </span>
                                              @endif  
                                            </div>
                                            <div class="content-pro-img">
                                                <div class="stats" title="{{isset($product['product_name']) ? ucwords($product['product_name']) : ''}}">
                                                    <div class="stats-container">
                                                      
                                                        <span class="product_name">
                                                          @php
                                                          
                                                          $prod_name = isset($product['product_name']) ? ucwords($product['product_name']): '';   
                                                          $prod_desc = isset($product['description']) ? ucfirst($product['description']): '';   
                                                          
                                                          if(strlen($prod_name)>42)
                                                          {
                                                            echo substr($prod_name,0,35)."..." ;
                                                          }
                                                          else
                                                          {
                                                            echo $prod_name;
                                                          }
                                                          @endphp   
                                                          


                                                          <p> {{strlen($prod_desc)>42 ? wordwrap(substr($prod_desc,0,65),26,"\n",TRUE)."..." : $prod_desc}}</p>

                                                        </span>


                                                        

                                                    </div>
                                                </div>
                                                
                                            </div>
                                          
                                            </a>                                           
                                           
                                          
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                   
                                 
                                </div>
                                  @if($product['inventory_details']['remaining_stock'] > 0)

                                              @if($login_user == true)

                                                @if($login_user->inRole('seller') == true || $login_user->inRole('admin') == true)

                                                  <a href="javascript::void(0)">
                                                    <div class="add_to_cart"
                                                   
                                                     onclick="swal( 'Alert!','If you want to buy a product, then please login as a buyer')"
                                                     > 
                                                         Add to cart
                                                     </div>
                                                  </a>

                                              @elseif($login_user->inRole('buyer') == true)
                                             
                                                <a href="javascript:void(0)" data-type="buyer" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" data-qty="1" 

                                                      @if(isset($buyer_id_proof) && $buyer_id_proof != "") 


                                                          @if(isset($buyer_id_proof) && 
                                                          $buyer_id_proof['approve_status']==0 
                                                          && $buyer_id_proof['front_image']==""
                                                          && $buyer_id_proof['back_image']==""
                                                          && $buyer_id_proof['age_category']==0
                                                          && $product['is_age_limit'] == 1 && $product['age_restriction']!="") 

                                                             onclick="return buyer_id_proof_warning()" 

                                                            @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==0 && $buyer_id_proof['age_category']==0
                                                             && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                              onclick="swal('Warning','Id proof not approved','warning')"

                                                           @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 && $buyer_id_proof['age_category']==0
                                                             && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                              onclick="swal('Warning','Age category not assigned','warning')"
        
                                                          @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 && $buyer_id_proof['age_category']!=$product['age_restriction']
                                                             && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                              onclick="swal('Warning','You can not buy this product','warning')"

                                                         @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==2 
                                                             && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                              onclick="swal('Warning','You can not buy this product age is not verified','warning')"    

                                                          @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 && $buyer_id_proof['age_category']>0  && $buyer_id_proof['age_category']==$product['age_restriction']  && $product['is_age_limit'] == 1 && $product['age_restriction']!="") 

                                                              onclick="add_to_cart($(this))"      


                                                          @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==0 && $product['is_age_limit'] == 1 && $product['age_restriction']!="")     

                                                           onclick="return buyer_id_proof_warning()"  

                                                          @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==0 && $product['is_age_limit'] == 0 && $product['age_restriction']=="") 

                                                              onclick="add_to_cart($(this))"
                                                          @else
                                                              onclick="add_to_cart($(this))"  

                                                          @endif
                                                      @else
                                                          onclick="add_to_cart($(this))"
                                                      @endif>

                                                      <div class="add_to_cart">
                                                         Add to cart
                                                      </div>
                                                    </a>
                                                                                      
                                                @endif
                                                @else
                                                <a href="javascript::void(0)"><div class="add_to_cart guest_url_btn"> 
                                                   Add to cart
                                                </div></a>
                                              @endif
                                            @else
                                              <div class="out-of-stock"> 
                                                  <span class="red-text">Out of stock</span>
                                               </div>
                                            @endif  



                                 

                                    <div class="starthomlist posinbottoms" title="{{$avg_rating}} Avg. rating">
                                            @if($avg_rating>0)
                                              <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="" />
                                              <a href="#" class="str-links starcounts" title="{{$total_review}} Reviews">
                                              {{ $total_review }} review
                                            </a>
                                              @else
                                             <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" />
                                            @endif  
                                            
                                             
                                            @if(isset($product['get_seller_additional_details']['approve_verification_status']) && $product['get_seller_additional_details']['approve_verification_status']!=0)
                                          
                                            @endif
                                            
                                      </div>  
                                  </div>
                            </div>
                          @endforeach                   

                          <div class="col-md-12">
                            <div class="pagination-chow">                                       
                              @if(!empty($arr_pagination))
                                {{$arr_pagination->render()}}    
                               @endif 
 
                            </div>
                          </div>

                      </div>
                  </div>
              </div>
         
          @endif

<!---------------end of most recent----------------------->


<hr>
<!-----------------featured brands------------------------------->


       @php
      if(isset($arr_featured_brands) && count($arr_featured_brands)<=5)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';  
      @endphp

        
      <div class="border-home-brfands"></div>
        @if(isset($arr_featured_brands) && count($arr_featured_brands)>0)  
        <div class="toprtd viewall-btns-idx">Featured brands
        <a href="{{ url('/') }}/shopbrand" class="{{ $class }}" title="View all">View All</a>
        </div>
        <div class="featuredbrands-flex smallsize-brand-img">

       <ul 
        @if(isset($arr_featured_brands) && count($arr_featured_brands)<=5)
        class="f-cat-below7" 
        @elseif(isset($arr_featured_brands) && count($arr_featured_brands)>5)
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
                    <div class="thumbnailss"> 
                      @if(file_exists(base_path().'/uploads/brands/'.$featured_brands['image']) && isset($featured_brands['image']))
                      <img src="{{url('/')}}/uploads/brands/{{$featured_brands['image']}}" alt="" />
                      @endif
                    </div>
                    <div class="content-brands">                       
                        <div class="titlebrds">{{ isset( $featured_brands['name'])?ucwords($featured_brands['name']):''}}</div>                           
                    </div>
                </div>
              </a>
            </li>            
          @endforeach
        </ul> 
    </div>
   @endif 

<!-----------------end of featured brands------------------------------->




<!-----------------featured categories------------------------------->

 {{-- <div  class="fav-catgry">
     <div class="border-home-brfands"></div>
          @php
          if(isset($arr_featured_category) && count($arr_featured_category)<=7)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';  
          @endphp


       @if(isset($arr_featured_category) && count($arr_featured_category)>0) 

         <div class="toprtd viewall-btns-idx"><div class="clearfix"></div>
        

           <a href="{{ url('/') }}/search" class="butn-def ftrleft-categories" title="View all">View All</a>

         </div>



       <div class="featuredbrands-flex">

        <ul id="flexiselDemo12">
        @foreach($arr_featured_category as $featured_category)
             <li> 
                <div class="top-rated-brands-list featured-categoriestp-trd">
                    <a href="{{ url('/') }}/search?category_id={{ base64_encode($featured_category['id']) }}" title="{{ $featured_category['product_type'] }}">

                                @if(file_exists(base_path().'/uploads/first_category/'.$featured_category['image']) && isset($featured_category['image']))
                                <img src="{{url('/')}}/uploads/first_category/{{ $featured_category['image'] }}"  alt="" />
                                @endif
                    </a>
                </div>
             </li>
        @endforeach
      </ul>
  </div>
       @endif
</div> --}}

<hr>

<div class="promotions-updatepg noneidts">
  <div class="toprtd viewall-btns-idx viewalls smallfonts">
           <span>Featured Categories</span> 
</div>
  <div class="row">

      @php
      if(isset($arr_featured_category) && count($arr_featured_category)<=7)
      $class = 'butn-def viewall-product';
      else
      $class = 'butn-def';  
      @endphp

 @foreach($arr_featured_category as $featured_category)

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist whitefont">
        <div class="img-promo">
           @if(file_exists(base_path().'/uploads/first_category/'.$featured_category['image']) && isset($featured_category['image']))
             <img src="{{url('/')}}/uploads/first_category/{{ $featured_category['image'] }}"  alt="" />
                               
           @endif

         {{--  <img src="{{url('/')}}/assets/front/images/promo-img1.jpg" alt=""> --}}
        </div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header">
           {{ $featured_category['product_type'] }}
          </h2>
        
        {{--   <p class="promo-block--text">
            Shop the stuff that everybody and their neighbor is talking about.
          </p> --}}
         {{--  <span class="button-primary promo-block--button">
            Shop Now
          </span> --}}
      </div>
      </a>
    </div>

   @endforeach  
  {{--   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist whitefont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img2.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header"> Deal of the Day </h2>
        
          <p class="promo-block--text">
            Every day we pick a product at random and make it an incredible deal.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist blackfont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img3.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header">Take 60% off</h2>
        
          <p class="promo-block--text">
             A selection of already discounted indoor plants and gardening tools.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist blackfont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img4.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header"> Get $20 off </h2>
        
          <p class="promo-block--text">
           When you spend more than $100 in-store and online with code 'GET20'.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div> --}}
  </div>
</div>



<!-----------------end of featured categories------------------------------->
     
<hr>

<!-----------------warch and learn section-------------------------------->
    <div class="watch-and-learn-txt nonmrg">
        <div class="border-home-brfands"></div>
        <div class="toprtd viewall-btns-idx viewalls smallfonts">
           <span>Watch and Learn</span> 

              @php 
              if(isset($arr_product_news) && count($arr_product_news)<=4)
              $class = 'butn-def viewall-product';
              else
              $class = 'butn-def';  
              @endphp

           <a href="{{ url('/') }}/learnmore" class="{{ $class }}">View All </a>
         </div>


       @if(!empty($arr_product_news) && count($arr_product_news)>0)  
           <div class="featuredbrands-flex">

              <ul
                @if(isset($arr_product_news) && count($arr_product_news)<=4)
                class="f-cat-below7 watch-four-div" 
                @elseif(isset($arr_product_news) && count($arr_product_news)>4)
                id="flexiselDemo5"
                @endif
              > 

                  @foreach($arr_product_news as $news)
                    <li>
                      <a href="javascript:void(0)" onclick="openVideo(this);"  data-video-id="{{ $news['url_id'] or '' }}" data-video-autoplay="1" data-video-url="{{ $news['video_url'] }}" >
                        <div class="watch-video-lrns">
                            <div class="video-idx-cw">
                               
                                <img src="{{url('/')}}/uploads/product_news/{{ $news['image'] }}" alt="" />
                            </div>
                            <div class="watch-main-cnts">
                                <div class="title-vdo-wtch">{{ ucfirst($news['title'])  }}</div>
                                <div class="shop-pharmacy-sub">

                                  <p> {{strlen($news['subtitle'])>42 ? wordwrap(substr($news['subtitle'],0,130),26,"\n",TRUE)."..." : $news['subtitle']}}</p>


                               {{--  {{ ucfirst($news['subtitle']) }} --}}
                               </div>
                            </div>
                        </div>
                         </a>
                    </li>
                     @endforeach
                 </ul>
             </div>
                @endif    
        </div>
 <!-------------end of watch and learn------------------------------------>


{{-- 

<div class="promotions-updatepg">
  <div class="toprtd viewall-btns-idx viewalls smallfonts">
           <span>Featured Categories</span> 
</div>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist whitefont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img1.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header">
            Our Best Sellers
          </h2>
        
          <p class="promo-block--text">
            Shop the stuff that everybody and their neighbor is talking about.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist whitefont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img2.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header"> Deal of the Day </h2>
        
          <p class="promo-block--text">
            Every day we pick a product at random and make it an incredible deal.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist blackfont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img3.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header">Take 60% off</h2>
        
          <p class="promo-block--text">
             A selection of already discounted indoor plants and gardening tools.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
      <a href="#" class="promotionslist blackfont">
        <div class="img-promo"><img src="{{url('/')}}/assets/front/images/promo-img4.jpg" alt=""></div>
        <div class="promo-block--content-wrapper">
          <h2 class="promo-block--header"> Get $20 off </h2>
        
          <p class="promo-block--text">
           When you spend more than $100 in-store and online with code 'GET20'.
          </p>
          <span class="button-primary promo-block--button">
            Shop Now
          </span>
      </div>
      </a>
    </div>
  </div>
</div>
 --}}




       
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



{{-- <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/bootstrap.min.js"></script> --}}
    {{-- <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/customjs.js"></script> --}}
    <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/jquery.flexisel.js"></script>


    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>
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

    $(window).load(function() {
      $("#flexiselDemo1").flexisel(); 
      $("#flexiselDemo2").flexisel({
      visibleItems: 5,
      itemsToScroll: 1,
      animationSpeed: 200,
      infinite: true, 
      navigationTargetSelector: null,
      autoPlay: {
      enable: false,
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
      visibleItems: 3,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });
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
      $("#flexiselDemo5").flexisel({
       visibleItems: 4,
          itemsToScroll: 1, 
          animationSpeed: 200,
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
          visibleItems: 4
      }
      }
      });

      $("#flexiselDemo12").flexisel({
       visibleItems: 4,
          itemsToScroll: 1,
          animationSpeed: 200,
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
          visibleItems: 4
      }
      }
      });
    
    });
    </script>
    <script>
        
        
  function add_to_cart(ref) {
    var id   = $(ref).attr('data-id');
    var quantity = $(ref).attr('data-qty');
    var type  = $(ref).attr('data-type');

    var csrf_token = "{{ csrf_token()}}";

    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){     
            $(ref).attr('disabled');          
            $(ref).html('<div class="add_to_cart">Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i></div>');        
          },
          success:function(cart_response)
          {
            $(ref).html('<div class="add_to_cart">Add to cart</div>');        
            if(cart_response.status == 'SUCCESS')
            { 
              window.location.href = SITE_URL+'/my_bag';             

            }
            else if(cart_response.status=="FAILURE")
            { // added new
                     swal('warning',cart_response.description,'warning');  
                     {{-- setTimeout(function(){ location.reload(); }, 500); --}}                     
            }
            else
            {                
              swal('Error',response.description,'error');
            }  
          }  

      });

  }


    </script>
@endsection