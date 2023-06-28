@php



  $login_user = '';

  $login_user = Sentinel::check();


  $isMobileDevice=0;
  $isMobileDevice= isMobileDevice();

  if($isMobileDevice==1){

      $device_count = 2;
      $chowwatch_device_count = '';
  }
  else {
      $device_count = 4;
      $chowwatch_device_count = 3;
  }

  //get state user ids and catdata
  $checkuser_locationdata = checklocationdata(); 

  if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
  {
     $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
     
     $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
  }
  
@endphp

{{-- @if($login_user == true && $login_user->inRole('buyer'))
 --}}

@if(isset($product_liked_arr) && count($product_liked_arr)>0)

<div class="clearfix"></div>
<div class="space100"></div>
<div class="clearfix"></div>

  <div class="toprtd non-mgts viewall-btns-idx toprated-view">Products you may like

          @php
          if(isset($product_liked_arr) && count($product_liked_arr)<=$device_count)
          $class = 'butn-def viewall-product';
          else
          $class = 'butn-def';
          @endphp

         <a href="{{ url('/') }}/search?best_seller=true" class="{{ $class }}" title="View all">View All</a>
         <div class="clearfix"></div>
        </div>

        <div class="featuredbrands-flex trendingproducts-section">
          <ul @if(isset($product_liked_arr) && count($product_liked_arr)<=$device_count)
             class="f-cat-below7"
            @elseif(isset($product_liked_arr) && count($product_liked_arr)>$device_count)
              id="flexiselDemo68"
           @endif
         >
            @php


              $trend_branname ='';
              $trend_sellername ='';
              $is_besesellerbest ='';
              $total_rating = $total_product_rating = 0;
              $pageclick = [];
              $i=1;
              $checkfirstcat_flag = 0;
              $rating = $avg_rating = '';
            @endphp
            @foreach($product_liked_arr as $trend_product)
               @php

                        $avg_rating = get_avg_rating($trend_product['id']);

                        $rating = isset($avg_rating)? get_avg_rating_image($avg_rating):'';


                       $total_review = get_total_reviews($trend_product['id']);
                        if($total_review>0)
                          $total_review = $total_review;
                        else
                           $total_review = '';


                       $trend_branname = isset($trend_product['get_brand_detail']['name'])?str_slug($trend_product['get_brand_detail']['name']):'';

                       $trend_sellername = isset($trend_product['get_seller_details']['seller_detail']['business_name'])?str_slug($trend_product['get_seller_details']['seller_detail']['business_name']):'';

                       $is_besesellerbest = check_isbestseller($trend_product['id']);

                       $trend_bran_concentration  = isset($trend_product['per_product_quantity']) ? $trend_product['per_product_quantity'].'mg' : '' ;


                        $product_title = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                      $product_title_slug = str_slug($product_title);



                       $pageclick['name'] = isset($trend_product['product_name']) ? $trend_product['product_name'] : '';
                       $pageclick['id'] = isset($trend_product['id']) ? $trend_product['id'] : '';
                       $pageclick['brand'] = isset($trend_product['brand']) ? get_brand_name($trend_product['brand']) : '';
                       $pageclick['category'] = isset($trend_product['first_level_category_id']) ? get_first_levelcategorydata($trend_product['first_level_category_id']) : '';


                       if(isset($trend_product['price_drop_to']))
                        {
                          if($trend_product['price_drop_to']>0)
                          {
                             $pageclick['price'] = isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '';
                          }else{
                             $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                          }

                        }else{
                          $pageclick['price'] = isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '';
                        }



                       //$pageclick['position'] = $i;
                       // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug.'/'.$trend_branname.'/'.$trend_sellername ;
                       $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($trend_product['id']).'/'.$product_title_slug;

                       /****************for restriction and out of stock icon*********/

                        $firstcat_id = isset($trend_product['first_level_category_id'])?$trend_product['first_level_category_id']:'';
                        $checkfirstcat_flag = 0;
                         if(isset($catdata) && !empty($catdata))
                         {
                            if(in_array($firstcat_id, $catdata))
                            {
                              $checkfirstcat_flag = 1;
                            }
                            else{
                              $checkfirstcat_flag = 0;
                            }
                         }

                       $restrictseller_id   = isset($trend_product['user_id'])?$trend_product['user_id']:'';

                       // condition added for buyer state restriction
                        if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers))
                       {
                          if(in_array($restrictseller_id,
                            $restricted_state_sellers))
                          {
                           //$checkfirstcat_flag = 0;
                          }
                          else
                          {
                            $checkfirstcat_flag = 1;
                          }
                       }
                       elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($restricted_state_sellers))
                       {
                         $checkfirstcat_flag = 1;
                       }
                       else
                       {
                         //$checkfirstcat_flag = 0;
                       }

                       /***********for restriction and out of stock icon************/

                    $isblur =0;


              @endphp


             <li>

                  @if(isset($login_user) && $login_user == true && $login_user->inRole('buyer'))
                   @if($checkfirstcat_flag==0)
                    {{--  <div class="statelaw-label">
                     <i class="fa fa-check"></i> state law

                     </div> --}}
                   @endif
                  @else
                     {{-- <div class="statelaw-label">
                      <i class="fa fa-check"></i> state law
                     </div> --}}
                  @endif



                   @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                        <div class="out-of-stock trending-left" >
                          <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                        </div>
                   @endif




                @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                    <!--------------outofstock--------------->
                       @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                           @if($checkfirstcat_flag==1)
                            @php $isblur=1; @endphp
                              {{-- <div class="out-of-stock">
                               <span class="red-text">
                                 Restricted
                               </span>
                             </div> --}}

                           @endif
                      @else
                        {{-- <div class="out-of-stock">  --}}

                            @if($checkfirstcat_flag==1)
                              @php $isblur=1; @endphp
                            {{--  <span class="red-text">
                               Restricted
                             </span> --}}
                            @else
                              @php $isblur=1; @endphp
                              {{-- <span class="red-text">Out of stock</span> --}}
                            @endif

                        {{--  </div> --}}
                      @endif
                    <!---------------outofstock-------------->

                  @else
                    {{-- <div class="out-of-stock">  --}}

                        @if($checkfirstcat_flag==1)
                         @php $isblur=1; @endphp
                           {{-- <span class="red-text">
                             Restricted
                           </span> --}}
                        @else
                          @php $isblur=1; @endphp
                         {{--  <span class="red-text">Out of stock</span> --}}
                        @endif

                    {{-- </div> --}}
                  @endif

                <div class="top-rated-brands-list">

                     <a href="{{url('/')}}/search/product_detail/{{isset($trend_product['id'])?base64_encode($trend_product['id']):'0'}}/{{ $product_title_slug }}" title="{{ ucfirst($trend_product['product_name']) }}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">


                      <div class="img-rated-brands">


                          <div  @if(isset($isblur) && $isblur==1) class="thumbnailss blurclass" @else class="thumbnailss" @endif>

                             <!----------Show out of stock on blur product------------------->
                                 @if(isset($trend_product['is_outofstock']) && $trend_product['is_outofstock'] == 0 )

                                     @if(isset($trend_product['inventory_details']['remaining_stock']) && $trend_product['inventory_details']['remaining_stock'] > 0)

                                         @if($checkfirstcat_flag==1)
                                            <div class="chow-outofstock-hm">Restricted</div>
                                         @endif
                                    @else

                                          @if($checkfirstcat_flag==1)
                                           <div class="chow-outofstock-hm">Restricted</div>
                                          @else
                                             <div class="chow-outofstock-hm">Out of stock</div>
                                          @endif

                                    @endif

                                 @else


                                      @if($checkfirstcat_flag==1)
                                          <div class="chow-outofstock-hm">Restricted</div>
                                      @else
                                        <div class="chow-outofstock-hm">Out of stock</div>
                                      @endif


                                @endif
                             <!---------End out of stock on blur product-------------->





                                @if(isset($trend_product['product_images_details'][0]['image']) &&file_exists(base_path().'/uploads/product_images/'.$trend_product['product_images_details'][0]['image']))

                                @php
                                  $final_product_image = image_resize('/uploads/product_images/'.$trend_product['product_images_details'][0]['image'],190,190);
                                @endphp

                             {{--    <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/')}}/uploads/product_images/{{ $trend_product['product_images_details'][0]['image']}}" class="portrait" alt="{{ $product_title }}" /> --}}

                                <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$final_product_image}}" />

                                @else
                                  <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{url('/assets/images/default-product-image.png')}}" class="portrait" alt="{{ $product_title }}" />

                                @endif
                            </div>
                        <div class="content-brands">
                             @php
                            // $connabinoids_name = get_product_cannabinoids_name($trend_product['id']);
                            $connabinoids_name = get_product_cannabinoids($trend_product['id']);
                            @endphp
                            @if(isset($connabinoids_name) && count($connabinoids_name) > 0)
                                  <div class="inlineblock-view-cannabionoids">
                                     <span class="inline-trend-product">
                                          @php
                                            $i = 0;
                                            //$numItems = count($connabinoids_name);
                                          @endphp
                                            @foreach($connabinoids_name as $cann)


                                            <span class="oil-category-cannabinoids"> {{$cann['name']}} {{floatval($cann['percent'])}}%</span>
                                              {{-- @if(++$i === $numItems)
                                                <span></span>
                                              @else
                                                <span class="dot-verticle">.</span>
                                              @endif --}}

                                            @endforeach
                                      </span>
                                  </div>
                            @endif


                            <div class="title-chw-list">

                                  <span class="titlename-list">
                                  {{ isset($trend_product['id'])?get_product_name($trend_product['id']):''  }}
                                  </span>
                            </div>


                              <div class="price-listing pricestatick viewinlineblock">
                                    @if(isset($trend_product['price_drop_to']))
                                      @if($trend_product['price_drop_to']>0)
                                       @php
                                       if(isset($product['percent_price_drop']) && $product['percent_price_drop']=='0.000000')
                                       {
                                       $percent_price_drop = calculate_percentage_price_drop($trend_product['id'],$trend_product['unit_price'],$trend_product['price_drop_to']);
                                       $percent_price_drop = floor($percent_price_drop);
                                       }
                                       else
                                       {
                                        $percent_price_drop = floor($trend_product['percent_price_drop']);
                                       }
                                       @endphp
                                        <span class="unitpriceclass">${{isset($trend_product['price_drop_to']) ? num_format($trend_product['price_drop_to']) : '0'}} </span>
                                        <del class="pricevies inline-del">

                                        ${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}}
                                      </del>
                                     {{--  <div class="inlineoff-div">({{$percent_price_drop}}% off)</div> --}}


                                      @else
                                        <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                        <del class="pricevies hidepricevies"></del>

                                      @endif
                                    @else
                                    <span>${{isset($trend_product['unit_price']) ? num_format($trend_product['unit_price']) : '0'}} </span>
                                       <del class="pricevies hidepricevies"></del>


                                    @endif
                               </div>
                                 <!-----------truck---------------->
                                  @if(isset($trend_product['shipping_type']) && $trend_product['shipping_type']==0)
                                   @php
                                        $setshipping = "";
                                        if($trend_product['shipping_type']==0)
                                        { $setshipping = "Free Shipping";
                                        }
                                        else{
                                          $setshipping = "Flat Shipping";
                                        }
                                   @endphp
                                   <div class="freeshipping-class" title="{{ $setshipping }}">
                                       Free Shipping
                                  </div>
                                  @endif
                                  <!----------truck----------------->

                            <div class="starthomlist "  @if($avg_rating>0) title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."
                           @endif>
                              @if($avg_rating>0 && isset($rating))

                                <img class="lozad" src="{{url('/')}}/assets/front/images/star/{{$rating}}.svg" alt="{{$rating}}.svg" title="{{ isset($avg_rating)?$avg_rating:'' }} Rating is a combination of all ratings on chow in addition to ratings on vendor site."/>

                                 <!-------review------------>
                                 <span class="str-links starcounts" title="@if($total_review==1){{$total_review}} Rating @elseif($total_review>1){{ $total_review }} Ratings @endif">
                                  {{-- @if($total_review==1)  {{ $total_review }} Rating
                                  @elseif($total_review>1){{ $total_review }} Ratings
                                  @endif --}}

                                  {{ isset($avg_rating)?$avg_rating:'' }}
                                  @if(isset($total_review)) ({{ $total_review }}) @endif


                                 </span>
                                 <!--------review--------------->
                              @endif
                            </div><!--end div of rating--->

                            <!--coupon code text div-->
                                @php

                                  $get_available_coupon = [];
                                  $get_available_coupon = get_coupon_details($trend_product['user_id']);
                                @endphp

                                @if(isset($get_available_coupon) && count($get_available_coupon)>0)

                                <div class="couponsavailable">Coupons Available</div>

                                @endif
                            <!------------------------>

                            <div class="inlineblock-view">
                               {{-- @if(isset($trend_product['is_chows_choice']) && $trend_product['is_chows_choice']==1)
                                  <div class="home_chow_choice chow_choice font-small circle-font-small-chow" style="margin-left: 0px">
                                    <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                                  </div>
                                @endif  --}}

                               {{--  @if(isset($is_besesellerbest) && $is_besesellerbest!="" && $is_besesellerbest==1)
                                  <div class="home_bestseller chow_choice-orange font-small circle-font-small" >
                                    <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow-arrow-icon-tag.png" alt=""> Best Seller</span>
                                  </div>
                                @endif --}}


                                  <!-----------truck---------------->
                                  @if(isset($trend_product['product_details']['shipping_type']) && $trend_product['product_details']['shipping_type']==0)
                                   @php
                                        $setshipping = "";
                                        if($trend_product['product_details']['shipping_type']==0)
                                        { $setshipping = "Free Shipping";
                                        }
                                        else{
                                          $setshipping = "Flat Shipping";
                                        }
                                   @endphp
                                   <div class="truck-icons" title="{{ $setshipping }}">
                                  <div class="freedrusd">Free Shipping </div> <img src="{{url('/')}}/assets/front/images/truck-icon.png" alt="Free Shipping">
                                  </div>
                                  @endif
                                  <!----------truck----------------->


                              </div>

                             {{--  <div class="inlineblock-view-cannabionoids">
                                  @php
                                  $connabinoids_name = get_product_cannabinoids_name($trend_product['id']);
                                  @endphp
                                  <span class="inline-trend-product"> {{$connabinoids_name}}</span>
                              </div> --}}



                        </div>
                    </div></a>
                    <div class="clearfix"></div>
                </div>
            </li>

            @php
             $i++;
            @endphp

         @endforeach
        </ul>
    </div>


  @endif

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script type="text/javascript">
 
  /*--global variable declaration--*/
  var screenWidth = window.screen.availWidth;

  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();
  
      if(parseInt(screenWidth) < parseInt(768)){
        
        $("#flexiselDemo68").removeAttr('id');

        $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

      }


  });

  $("#flexiselDemo68").flexisel({
      visibleItems: 4,
      itemsToScroll: 1, slide:false,
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
      visibleItems: 2,
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
      itemsToScroll: 1,
      },
       ipad: {
      changePoint:1024,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 4,
      itemsToScroll: 1
      }
      }
      });


</script>