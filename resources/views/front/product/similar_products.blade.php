
 @php

  $login_user = '';
  $login_user = Sentinel::check();

  $isMobileDevice=0;
  $isMobileDevice= isMobileDevice();
    if($isMobileDevice==1){

        $device_count = 2;
    }
    else {
        $device_count = 5;
    }
@endphp
         <!---------------------start of similar product------------------------------>

             @if(isset($arr_similar_product) && !empty($arr_similar_product))

             <hr>
              <div class="" style="">
  
              <div class="border-home-brfands"></div>
               <div class="toprtd viewall-btns-idx smallfonts allproducttextright similarproducts-view"><b>Similar Products</b></div>
               <div class="clearfix"></div>
                <div class="featuredbrands-flex sml-fnt-sldr">
                   <ul 
                   @if(isset($arr_similar_product) && count($arr_similar_product)<=$device_count)
                    class="similarproduct"
                   @elseif(isset($arr_similar_product) && count($arr_similar_product)>$device_count)
                    id="flexiselDemo1" style="display: block"
                   @endif 
                   >      

                   {{-- <ul id="flexiselDemo1" style="display: block">       --}}
                    @php
                      $similar_urlbrands_name ='';
                      $similar_urlseller_name ='';
                      $i=0;

                     // dd($arr_similar_product);
                    @endphp
                    @foreach($arr_similar_product as $product)                     
                      @php  


                        $avg_rating = get_avg_rating($product['id']);

                        $rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';

                       $similar_product_total_review = get_total_reviews($product['id']);

                        $similar_urlbrands_name = isset($product['get_brand_detail']['name'])?str_slug($product['get_brand_detail']['name']):'';

                        $similar_urlseller_name = isset($product['get_seller_additional_details']['business_name'])?str_slug($product['get_seller_additional_details']['business_name']):'';

                        $is_besesellersimilar = check_isbestseller($product['id']);
                        $firstcat_id = $product['first_level_category_id'];

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



                      @endphp

                       @php  $isblur =0; @endphp

                     @if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0 )

                               @if(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] > 0)   

                                   @if($checkfirstcat_flag==1)
                                   @php  $isblur =1; @endphp
                                     {{--  <div class="out-of-stock"> 
                                       <span class="red-text">
                                         Restricted
                                       </span>
                                     </div> --}}
                                                  
                                   @endif
                              @else
                                {{-- <div class="out-of-stock">  --}}

                                    @if($checkfirstcat_flag==1)
                                      @php  $isblur =1; @endphp
                                       {{-- <span class="red-text">
                                         Restricted
                                       </span> --}}
                                    @else
                                       @php  $isblur =1; @endphp
                                       {{-- <span class="red-text">Out of stock</span> --}}
                                    @endif

                                 {{-- </div> --}}
                              @endif  
                            
                      @else
                           {{--  <div class="out-of-stock">  --}}

                                @if($checkfirstcat_flag==1)
                                  @php  $isblur =1; @endphp
                                   {{-- <span class="red-text">
                                     Restricted
                                   </span> --}}
                                @else
                                   @php  $isblur =1; @endphp
                                 {{--  <span class="red-text">Out of stock</span> --}}
                                @endif

                           {{--  </div> --}}
                      @endif




                      <li> 
                         
                          @if(isset($login_user) && $login_user == true && $login_user->inRole('buyer'))
                             @if($checkfirstcat_flag==0) 
                               {{-- <div class="statelaw-label">
                                <i class="fa fa-check"></i> state law
                               </div> --}}
                             @endif
                          @else
                               {{-- <div class="statelaw-label">
                                <i class="fa fa-check"></i> state law
                               </div>   --}} 
                          @endif 


                         @if(isset($product['is_chows_choice']) && $product['is_chows_choice']==1)
                           <div class="out-of-stock trending-left" >
                              <span class="b-class-hide"><img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice </span>
                            </div>
                         @endif    



                        <div class="top-rated-brands-list">
                            @php
                              $product_title = isset($product['product_name']) ? $product['product_name'] : '';
                              $product_title_slug = str_slug($product_title);




                             $pageclick['name'] = isset($product['product_name']) ? $product['product_name'] : '';
                             $pageclick['id'] = isset($product['id']) ? $product['id'] : '';
                             $pageclick['brand'] = isset($product['brand']) ? get_brand_name($product['brand']) : '';
                             $pageclick['category'] = isset($product['first_level_category_id']) ? get_first_levelcategorydata($product['first_level_category_id']) : '';


                             if(isset($product['price_drop_to']))
                              {
                                if($product['price_drop_to']>0){
                                   $pageclick['price'] = isset($product['price_drop_to']) ? num_format($product['price_drop_to']) : '';
                                 }else{
                                   $pageclick['price'] = isset($product['unit_price']) ? num_format($product['unit_price']) : '';
                                 }
                               
                              }else{
                                $pageclick['price'] = isset($product['unit_price']) ? num_format($product['unit_price']) : '';
                              }
                             
                             //$pageclick['position'] = $i;
                             $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($product['id']).'/'.$product_title_slug.'/'.$similar_urlbrands_name.'/'.$similar_urlseller_name ;



                            @endphp
                          

                            <a href="{{url('/')}}/search/product_detail/{{isset($product['id'])?base64_encode($product['id']):''}}/{{ $product_title_slug }}/{{ $similar_urlbrands_name }}/{{ $similar_urlseller_name }}" title="{{ $product['product_name'] }}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">
                              <div class="img-rated-brands"> 

                           

                                <div @if(isset($isblur) && $isblur==1) class="thumbnailss blurclass" @else class="thumbnailss" @endif> 

                                <!---------show restricted or out of stock on blur---------->  
                                  
                                  @if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0 )

                                     @if(isset($product['inventory_details']['remaining_stock']) && $product['inventory_details']['remaining_stock'] > 0)   

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

                                  <!------show restricted or out of stock on blur--------->



                                     @if(!empty($product['product_images_details']) 
                                     && count($product['product_images_details']))  

                                        @if(!empty($product['product_images_details']) 
                                         && count($product['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$product['product_images_details'][0]['image']))

                                          @php

                                           $similar_product_image = image_resize('/uploads/product_images/'.$product['product_images_details'][0]['image'],190,190);

                                          @endphp

                                       {{--    <img data-src="{{url('/')}}/uploads/product_images/{{ $product['product_images_details'][0]['image'] }}" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" class="portrait lozad" alt="{{ $product['product_name'] }}" /> --}}

                                            <img data-src="{{$similar_product_image}}" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" class="portrait lozad" alt="{{ $product['product_name'] }}" />

                                        @else
                                             <img data-src="{{url('/')}}/assets/images/default-product-image.png" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" class="portrait lozad" alt="{{ $product['product_name'] }}" /> 
                                        @endif

                                    @endif
                                </div>


                                 </a>
                                 <!---------------show brand name here------------------------->
                                 @php
                                $brands_name = isset($product['get_brand_detail']['name'])?$product['get_brand_detail']['name']:'';
                                if(isset($brands_name)){
                                  $brandName = str_replace(' ','-',$brands_name); 
                                }

                               @endphp     


                                @php                                
                                    // $connabinoids_name = get_product_cannabinoids_name($product['id']);
                                    $connabinoids_name = get_product_cannabinoids($product['id']);
                                    @endphp
                                    @if(isset($connabinoids_name) && count($connabinoids_name) > 0)
                                          <div class="inlineblock-view-cannabionoids">
                                             <span class="inline-trend-product">
                                                  @php
                                                    $i = 0;
                                                    // $numItems = count($connabinoids_name);
                                                  @endphp
                                                    @foreach($connabinoids_name as $cann) 
                                                        <span class="oil-category-cannabinoids"> {{$cann['name']}} {{floatval($cann['percent'])}}%</span>
                                                     {{--  @if(++$i === $numItems)
                                                        <span></span>
                                                      @else 
                                                        <span class="dot-verticle">.</span>
                                                      @endif --}}
                                                    
                                                    @endforeach
                                              </span>
                                          </div>
                                    @endif

                               

                               <div class="title-chw-list nonottom-space">
                                <a href="{{url('/')}}/search/product_detail/{{isset($product['id'])?base64_encode($product['id']):''}}/{{ $product_title_slug }}/{{ $similar_urlbrands_name }}/{{ $similar_urlseller_name }}" title="{{ $product['product_name'] }}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">
                               
                                 <span class="titlename-list linebreak">
                                  {{ isset($product['id'])?get_product_name($product['id']):''  }}
                                 </span> <div class="clearfix"></div>
                               </a>

                              </div>


                                <div class="ext-deatails bortdernone-ext rw-ext-deatails none-space-cncentration none-flex viewinlineblock">
                                    

                                  @if(isset($product['price_drop_to']))
                                    @if($product['price_drop_to']>0)
                                    @php
                                     if(isset($product['percent_price_drop']) && $product['percent_price_drop']=='0.000000') 
                                     {
                                     $percent_price_drop = calculate_percentage_price_drop($product['id'],$product['unit_price'],$product['price_drop_to']); 
                                     $percent_price_drop = floor($percent_price_drop);
                                     }
                                     else
                                     { 
                                      $percent_price_drop = floor($product['percent_price_drop']);
                                     }
                                    @endphp
                                    <span class="unitpriceclass">${{isset($product['price_drop_to'])?num_format($product['price_drop_to']):'0'}} </span>
                                      <del class="pricevies inline-del">
                                        ${{isset($product['unit_price'])?num_format($product['unit_price']):'0'}}
                                      </del> <div class="inlineoff-div">({{$percent_price_drop}}% off)</div> 
                                      
                                    @else
                                     <div class="unitpriceclass">${{isset($product['unit_price'])?num_format($product['unit_price']):'0'}} </div>
                                      <del class="pricevies hidepricevies"></del>
                                     
                                    @endif
                                  @else
                                  <div class="unitpriceclass">${{isset($product['unit_price'])?num_format($product['unit_price']):'0'}} </div>
                                    <del class="pricevies hidepricevies"></del>
                                    
                                  @endif
                                </div>

                                 
                                 <!----------------end of show brand name here------------------------>
                                  <!-----------truck---------------->
                                    @if(isset($product['shipping_type']) && $product['shipping_type']==0)
                                     @php 
                                          $setshippingsimilar = "";
                                          if($product['shipping_type']==0)
                                          { $setshippingsimilar = "Free Shipping";
                                          }
                                          else{
                                            $setshippingsimilar = "Flat Shipping";
                                          }
                                     @endphp
                                     <div class="freeshipping-class" title="{{ $setshippingsimilar }}">Free Shipping 
                                    </div>
                                    @endif
                                  <!----------truck----------------->
                                 <a href="{{url('/')}}/search/product_detail/{{isset($product['id'])?base64_encode($product['id']):''}}/{{ $product_title_slug }}" title="{{ $product['product_name'] }}">
                                <div class="content-brands">
                                  
                                      <!-------------start-rating-div-------------------->
                                      <div class="starthomlist" @if($avg_rating>0) title="{{ isset($avg_rating)?$avg_rating:''}} Rating is a combination of all ratings on chow in addition to ratings on vendor site." @endif>
                                        @if(isset($rating) && $avg_rating>0)    
                                          {{-- <img src="{{url('/')}}/assets/front/images/star-rate-{{ $rating }}.svg" alt="star-rate-{{ $rating }}.svg" /> --}}

                                          <img src="{{url('/')}}/assets/front/images/star/{{ $rating }}.svg" alt="{{ $rating }}.svg" />

                                          @if($similar_product_total_review > 0)
                                              <span href="#" class="str-links starcounts" 
                                              title=" @if($similar_product_total_review==1)
                                               {{ $similar_product_total_review }} Rating 
                                               @elseif($similar_product_total_review>1)
                                               {{ $similar_product_total_review }} Ratings 
                                               @endif
                                                ">
                                           
                                              {{ $avg_rating }}
                                               @if(isset($similar_product_total_review)) ({{ $similar_product_total_review }}) @endif

                                              </span>
                                          @endif
                                        @else
                                         {{-- <img src="{{url('/')}}/assets/front/images/star-rate-ziro.svg" alt="" /> --}}
                                        @endif  
                                      </div>  
                                      <!------------end rating div-----------------------> 

                                      <!--coupon code text div-->
                                          @php

                                            $get_available_coupon = [];
                                            $get_available_coupon = get_coupon_details($product['user_id']);
                                          @endphp
                                           
                                          @if(isset($get_available_coupon) && count($get_available_coupon)>0)

                                          <div class="couponsavailable">Coupons Available</div>

                                          @endif

                                    <!------------------------>

                                      <!-------------cc and best seller---------------> 
                                      <div class="inlineblock-view">
                                     
                                        <!-- Lab results available Start -->
                                               <!--  @if(isset($product['product_certificate']) && !empty($product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$product['product_certificate']) )
                                                  <div class="labresults-class" style="margin-left: 0px">
                                                   <span class="b-class-hide">Lab Results Available</span>
                                                  </div>                                   
                                                @endif   -->
                                       <!-- Lab results available End -->  




                                      </div>  
                                   <!----------------ebd cc and best seller--------->

                               
                                 






                                </div>
                              </a>

                            </div>
                         
                        <div class="clearfix"></div>
                        </div>
                    </li>     
                     {{-- @endif     --}}
                     @php $i++; @endphp
                    @endforeach       
                         
                </ul>
              </div>
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
        
        $("#flexiselDemo1").removeAttr('id');

        $( "#carousel-example-generic" ).addClass( "opacityhidescroll" );

      }


  });


    $("#flexiselDemo1").flexisel({
        
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