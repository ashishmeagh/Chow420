
@extends('front.layout.master')
@section('main_content')
{{-- <link href="{{url('/')}}/assets/front/css/owl.carousel.min.css" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{url('/')}}/assets/front/css/owl.theme.default.min.css" rel="stylesheet" type="text/css" /> --}}
{{-- <script src="{{url('/')}}/assets/front/js/owl.carousel.js"></script> --}}

<style>
  .heart-icn{display: none;}
.product-holder-list .add_to_cart {
        left: auto;
    right: 20px;
    bottom: 20px;
    z-index: 9999;
    background-color: #444;
    padding: 5px;
    border-radius: 0;
    color: #fff;
}
.product-holder-list .add_to_cart img{
  filter: brightness(0) invert(1);
}
.img-cntr {
    margin: 0px auto 20px;
    display: block; padding: 16px 16px 0;
    text-align: center;
    position: relative;
    /*height: 180px;*/
    overflow: hidden;
}
.results-products .img-cntr {
  position: relative;
  max-width: 200px;
  /*height: 200px;*/
  overflow: hidden;
}
.results-products .img-cntr img {
  position: absolute;
  left: 50%;
  top: 50%;
  height: 100%;
  width: auto;
  -webkit-transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);
}
.results-products .img-cntr img.portrait {
     width: auto;
    height: 150px;
}

</style>
<script>
   showProcessingOverlay();
   $(window).load(function() {       
     hideProcessingOverlay();
   });
</script>
{{-- 
<script type="text/javascript"  src="{{url('/')}}/assets/front/js/theia-sticky-sidebar.js"></script>
 <script type="text/javascript">
      $(document).ready(function() {
        $('.leftSidebar, .content, .rightSidebar')
          .theiaStickySidebar({
            additionalMarginTop: 130,
            additionalMarginBottom: 150 
          });
      });
    </script>  --}}
@php
	$category_id     = Request::input('category_id');
	$price           = Request::input('price'); 
  $rating          = Request::input('rating');
  $age_restrictions  = Request::input('age_restrictions');
  $seller   = Request::input('seller');
  $brands   = Request::input('brands');
  $sellers  = Request::input('sellers');
  $brand = Request::input('brand');
  $mg    = Request::input('mg');
  $filterby_price_drop    = Request::input('filterby_price_drop');
  $pdrop_filt_stat =  isset($filterby_price_drop)?$filterby_price_drop:'false';
  $product_search =  Request::input('product_search');
 
 
@endphp
<input type="hidden" name="category" id="category" value="{{$category_id or ''}}">
<input type="hidden" name="price" id="price" value="{{$price or ''}}">
<input type="hidden" id="lowest_price" value="{{$lowest_price or 0}}" >
<input type="hidden" id="highest_price" value="{{$highest_price or 0}}" >
<input type="hidden" id="age_restrictions" placeholder="Age" value="{{$age_restrictions or ''}}" >
<input type="hidden" id="rating" placeholder="Rating" value="{{$rating or ''}}" >
<input type="hidden" id="seller" placeholder="Seller" value="{{$seller or ''}}" >
<input type="hidden" id="brand" placeholder="Brand" value="{{$brand or ''}}" >
<input type="hidden" id="brands" placeholder="Search Brand" value="{{$brands or ''}}" >
<input type="hidden" id="sellers" placeholder="Search By Seller" value="{{$sellers or ''}}" >
<input type="hidden" name="mg" id="mg" value="{{$mg or ''}}">
<input type="hidden" id="lowest_mg" value="{{$lowest_mg or 0}}" >
<input type="hidden" id="highest_mg" value="{{$highest_mg or 0}}" >
<input type="hidden" id="price_drop" value="{{ $pdrop_filt_stat }}" />
<input type="hidden" id="product_search" value="{{ $product_search }}" />

@php
@endphp


<div class="listing-page-main">
    <div class="container">
       @if(isset($sellers) || isset($seller))

      <div class="seller-banner-img-listpage">
        <div class="seller-banner-imgmains">
          @php
            if(isset($arr_seller_banner) && !empty($arr_seller_banner) && count($arr_seller_banner) > 0 && file_exists(base_path().'/uploads/seller_banner/'.$arr_seller_banner['image_name']))
            {             
              $banner_img = $arr_seller_banner['image_name'];              
              $img_path =url('/uploads/seller_banner/'.$arr_seller_banner['image_name']);
            }
            else
            {
              $banner_img = 'chow-bnr-img.png';
              $img_path =url('/').'/assets/front/images/chow-bnr-img.png';
            }

        @endphp
          <img src="{{$img_path}}" alt="Cover Image">
        </div>
        <div class="seller-body-content-text"> 
          @php
          $count =0;
          if(!empty($seller_details) && isset($seller_details)){
                 $fname = $seller_details['first_name']; 
                 $lname = $seller_details['last_name'];   
          }
           if(isset($arr_reviews_products) && isset($arr_reviews_products)){
                $count = count($arr_reviews_products);  
          }

          if(isset($avg_rating) && $avg_rating > 0)
          {
            $img_avg_rating = "";
            if($avg_rating=='1') $img_avg_rating = "star-rate-one.png";
            else if($avg_rating=='2')  $img_avg_rating = "star-rate-two.png";
            else if($avg_rating=='3')  $img_avg_rating = "star-rate-three.png";
            else if($avg_rating=='4')  $img_avg_rating = "star-rate-four.png";
            else if($avg_rating=='5')  $img_avg_rating = "star-rate-five.png";
            else if($avg_rating=='0.5')  $img_avg_rating = "star-rate-zeropointfive.png";
            else if($avg_rating=='1.5')  $img_avg_rating = "star-rate-onepointfive.png";
            else if($avg_rating=='2.5')  $img_avg_rating = "star-rate-twopointfive.png";
            else if($avg_rating=='3.5')  $img_avg_rating = "star-rate-threepointfive.png";
            else if($avg_rating=='4.5')  $img_avg_rating = "star-rate-fourpointfive.png";
          }
          
          @endphp
             <div class="title-slrtxtmns">{{ isset($business_details['business_name'])?$business_details['business_name']:'' }}</div>

          <div class="sbtitlreview">{{ isset($fname)?$fname:'' }} {{ isset($lname)?$lname:'' }}</div>
          <div class="reviewratingslr">
            
            @php
              if( isset($img_avg_rating)){
            @endphp
              <img @if($avg_rating>0) title="{{$avg_rating}} Avg. rating" @endif src="{{url('/')}}/assets/front/images/{{isset($img_avg_rating)?$img_avg_rating:'star-rate-ziro.png'}}" alt=""> 
             @php 
                }
            @endphp

            <!-- @php
              if( isset($avg_rating)){
            @endphp
            <span class="count-rw-seller">{{ isset($avg_rating)?$avg_rating:'' }}</span>
            @php 
                }
            @endphp -->
           


            @php
              if($count>0){
            @endphp
            <span @if($count>0) title="{{$count}} Reviews" @endif class="count-rw-seller">{{ isset($count)?$count:'0' }}</span>
            @php
              }
            @endphp

          </div>
        </div>        
      </div>
   @endif



        <div id="wrapper">
            <div class="">
                @include('front.product.front_sidebar')

                 <div class="closebtnslist filternw">
                              <span class="toggle-button">
                                <span class="filterbutton"><i class="fa fa-filter"></i> Filter</span>
                                <div class="menu-bar menu-bar-top"></div>
                                <div class="menu-bar menu-bar-middle"></div>
                                <div class="menu-bar menu-bar-bottom"></div>
                              </span>
                            </div> 

                @if(count($arr_data) > 0)  

                    <div class="col-9-list">
                        <div class="main-selectslist pd-o">
                          <div class="title-listingpages"> 
                            {{-- @if(isset($first_cat_details[0]['product_type']))
                             {{ $first_cat_details[0]['product_type'] }}                           
                            @elseif(isset($seller_details) && isset($seller))
                               {{ ($seller_details[0]['first_name']) }}  
                               {{ ($seller_details[0]['last_name']) }}    
                            @elseif(isset($brand_details))
                                {{ $brand_details[0]['name'] }} 
                            @elseif(isset($seller_details) && isset($sellers))
                               {{ ($seller_details['first_name']) }}  
                               {{ ($seller_details['last_name']) }}  
                            @else
                             Products
                            @endif  --}}
                            Products
                             <span>( 
                            {{ count($arr_data) }} of {{ $total_results }} results)</span>
                          </div>
        
                           

                           {{--  <div class="listingpages-selects">
                               <div class="laber-selcts"> Sort By</div>
                               <select class="frm-select">
                                  <option>Select</option>
                                  <option>Price : Low to High</option>
                                  <option>Price : High to Low</option>
                                </select>
                            </div>
                           --}}
                            <div class="clearfix"></div>
                        </div>
                            <!-- <div class="inlg-list">
                                <img src="{{url('/')}}/assets/front/images/listing-pg-bnr.jpg" alt="" />
                            </div> -->
                            
                        <div id="grid">
                            <div class="results-products prodtlist-update">

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

                             {{--  {{dd($arr_data)}} --}}
                            @foreach($arr_data as $product)

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



                                	<div class="product-holder-list">

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
                                			@if(isset($product['is_age_limit']) && $product['is_age_limit'] == 1 && isset($product['age_restriction']))
                                			
{{--     	                                		<div class="label-list">{{$product['age_restriction']}}+ Age</div>
 --}}
                                          <div class="label-list">{{$product['age_restriction_detail']['age']}}</div>

    	                                	@endif
    	                                    <div class="make3D">
    	                                        <div class="product-front">
                                                @php
                                                  $product_title = isset($product['product_name']) ? $product['product_name'] : '';
                                                  $product_title_slug = str_slug($product_title);
                                                @endphp
    	                                            <a href="{{url('/')}}/search/product_detail/{{isset($product['id'])?base64_encode($product['id']):''}}/{{ $product_title_slug }}" title="{{isset($product['product_name']) ? $product['product_name'] : ''}}">
                                                   <div class="owl-carousel owl-theme">
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

    	                                                <img src="{{$product_img}}" class="portrait" alt="{{isset($product['product_name']) ? $product['product_name'] : ''}}" />
    	                                                
    	                                            </div>
                                                  </div>
    	                                           
                                                   <div class="price-listing"> 
                                                      @if(isset($product['price_drop_to']))
                                                        @if($product['price_drop_to']>0)
                                                          <del class="pricevies">${{isset($product['unit_price']) ? num_format($product['unit_price']) : '0'}}</del>
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

                                                   <!---------------show brand name here------------------>
                                                    </a>  
                                                    <p class="bybrandbylink"> 
                                                      <span>
                                                     
                                                         @php
                                                          $brand_name = isset($product['get_brand_detail']['name'])?$product['get_brand_detail']['name']:'';
                                                          if(isset($brand_name)){
                                                            $brandname = str_replace(' ','-',$brand_name); 
                                                          }

                                                         @endphp

                                                         <a href="{{ url('/') }}/search?brands={{ $brandname }}">
                                                           {{isset($product['get_brand_detail']['name'])?$product['get_brand_detail']['name']:''}}
                                                        </a>
                                                      </span>
                                                    </p> 

                                                   <!-------------end of brand name----------------------->



                                                   <a href="{{url('/')}}/search/product_detail/{{isset($product['id'])?base64_encode($product['id']):''}}/{{ $product_title_slug }}" title="{{isset($product['product_name']) ? $product['product_name'] : ''}}">
    	                                            <div class="content-pro-img">
                                                    @php
                                                      $prod_name = isset($product['product_name']) ? ucwords($product['product_name']): '';   
                                                      $prod_desc = isset($product['description']) ? ucfirst($product['description']): '';   
                                                      
                                                      $prod_name_limited = str_limit($prod_name,42);
                                                      
                                                    @endphp 
    	                                                <div class="stats" 
                                                            title="{{ $prod_name or '' }}"
                                                            limit-title="{{ $prod_name_limited }}" >
    	                                                    <div class="stats-container">
    	                                                        {{-- <div class="title-sub-list">{{isset($product['first_level_category_details']['product_type'])?$product['first_level_category_details']['product_type']:''}}</div> --}}
    	                                                        <span class="product_name">
                                                                  {{ $prod_name or '' }}
                                                                {{-- <p> {{strlen($prod_desc)>42 ? wordwrap(substr($prod_desc,0,65),26,"\n",TRUE)."..." : $prod_desc}}</p> --}}
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

                                                       {{--  <a href="javascript::void(0)">
                                                          <div class="add_to_cart"
                                                           onclick="swal( 'Alert!','If you want to buy a product, then please login as a buyer')"
                                                           > 
                                                               Add to cart
                                                           </div>
                                                        </a> --}}

                                                        <!---------if seller login-hide button------->
                                                        {{--  <a href="javascript::void(0)">
                                                          <div class="add_to_cart"
                                                           onclick="return buyer_redirect_login()"
                                                           > 
                                                               Add to cart
                                                           </div>
                                                        </a> --}}

                                                        



                                                    @elseif($login_user->inRole('buyer') == true)
                                                   
                                                      <a href="javascript:void(0)" data-type="buyer" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" data-qty="1" 

                                                            @if(isset($buyer_id_proof) && $buyer_id_proof != "") 


                                                                @if(isset($buyer_id_proof) && 
                                                                $buyer_id_proof['approve_status']==0 
                                                                && $buyer_id_proof['front_image']==""
                                                                && $buyer_id_proof['back_image']==""
                                                                && $buyer_id_proof['selfie_image']==""
                                                                && $buyer_id_proof['age_category']==0
                                                                && $product['is_age_limit'] == 1 && $product['age_restriction']!="") 

                                                                   onclick="return buyer_id_proof_warning()" 

                                                                  @elseif(isset($buyer_id_proof) 
                                                                    && ($buyer_id_proof['approve_status']==0 || $buyer_id_proof['approve_status']==3 )
                                                                    && $buyer_id_proof['age_category']==0
                                                                   && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" 
                                                                   && $buyer_id_proof['selfie_image']!=""
                                                                   && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                                    onclick="swal('Warning','Id proof not approved','warning')"

                                                                  @elseif(isset($buyer_id_proof) 
                                                                    && ($buyer_id_proof['approve_status']==0 || $buyer_id_proof['approve_status']==3 )
                                                                   
                                                                   && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" 
                                                                   && $buyer_id_proof['selfie_image']!=""
                                                                   && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                                    onclick="swal('Warning','Id proof not approved','warning')"   
                                                                    

                                                                 @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 && $buyer_id_proof['age_category']==0
                                                                   && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                                    onclick="swal('Warning','Age category not assigned','warning')"
              
                                                                @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 && $buyer_id_proof['age_category'] ==1 && $buyer_id_proof['age_category']!=$product['age_restriction']
                                                                   && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $product['is_age_limit'] == 1 && $product['age_restriction']!="")      
                                                                    onclick="swal('Sorry','To buy this product your age must be 21+','warning')"

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
                                                        {{-- <a href="{{url('/')}}/my_bag/add_item/{{isset($product['id'])?base64_encode($product['id']):0}}"><div class="add_to_cart"> 
                                                          <img src="{{url('/')}}/assets/front/images/cart-icon-list.png" alt="" /> Add to cart
                                                        </div></a> --}}                                            
                                                      @endif
                                                      @else
                                                    {{--   <a href="javascript::void(0)"><div class="add_to_cart guest_url_btn"> 
                                                        Add to cart
                                                      </div></a> --}}

                                                      <a href="javascript::void(0)"><div class="add_to_cart" onclick="return buyer_redirect_login()"> 
                                                        Add to cart
                                                      </div></a>

                                                      


                                                    @endif
                                                  @else
                                                    <div class="out-of-stock"> 
                                                        <span class="red-text">Out of stock</span>
                                                     </div>
                                                  @endif  
 


                                         
                                          <div @if($avg_rating>0) class="starthomlist posinbottoms" 
                                              
                                                title="{{$avg_rating}} Avg. rating"
                                              @else
                                              
                                              @endif >
                                                   @if($avg_rating>0)      
                                                    <img src="{{url('/')}}/assets/front/images/star-rate-{{$rating}}.png" alt="star-rate-{{$rating}}.png" />
                                                    <a href="#" class="str-links starcounts" title="@if($total_review==1){{$total_review}} Review @elseif($total_review>1) {{$total_review}} Reviews @endif">

                                                    @if($total_review==1)  
                                                    {{ $total_review }} Review
                                                    @elseif($total_review>1)
                                                    {{ $total_review }} Reviews
                                                    @endif
                                                    </a>
                                                  
                                                  
                                                   
                                                  @if(isset($product['get_seller_additional_details']['approve_verification_status']) && $product['get_seller_additional_details']['approve_verification_status']!=0)
                                                  {{-- <img class="tagsellrts" src="{{url('/')}}/assets/front/images/tag-sellers.png" alt="" /> --}}
                                                  {{--  <span style="padding: 1px;background-color: green;color: white;border-radius: 4px;font-size: xx-small;"> Seller Verified</span>  --}}
                                                  @endif
                                                  {{-- <img class="tagsellrts" src="{{url('/')}}/assets/front/images/tag-sellers.png" alt="" /> --}}
                                              @else
                                                   {{-- <img src="{{url('/')}}/assets/front/images/star-rate-ziro.png" alt="" /> --}}
                                              @endif      
                                          </div>  
                                           
                                    </div>
                                    <div class="clearfix"></div>
                                	</div>
    		                        @endforeach  		              

                                  

                            </div>
                            <div class="col-md-12">
                                 <div class="pagination-chow">                                        
                                    @if(!empty($arr_pagination))
                                      {{$arr_pagination->render()}}    
                                     @endif 
                                  </div>
                           </div>
                        </div>

                    </div>

                @else
                <div class="col-md-9">
                     <div class="empty-product-main">
                         <div class="empty-prodct">
                             <img src="{{url('/')}}/assets/front/images/empty-product.jpg" alt="" />
                         </div>
                         <div class="empty-product-title">
                            @if(isset($product_search))
                              We could not find exact matches for "{{ $product_search }}"
                            @else
                               Sorry, no results found!
                            @endif
                            
                         </div>
                         <div class="spelling-searching">Please check the spelling or try searching for something else </div>
                     </div>
                </div>
                @endif
            </div>
        </div>        
    </div>
</div>
 {{-- <script>
            $(document).ready(function() {
              var owl = $('.owl-carousel');
              owl.owlCarousel({
                margin: 10,
                nav: true, 
                autoplay:true,autoPlay : 1000,
                loop: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 1
                  },
                  1000: {
                    items: 1
                  }
                }
              })
            }) 
  </script> --}}
<script type="text/javascript">
  var lowest_price = $('#lowest_price').val();
  var highest_price = $('#highest_price').val();
  var category = $('#category').val();
  var price = $('#price').val();
  var min_selected_price = price.split('-')[0] || lowest_price;
  var max_selected_price = price.split('-')[1] || highest_price;
  var age_restrictions = $("#age_restrictions").val();
  var brands = $("#brands").val();
  var sellers = $("#sellers").val();
  var rating = $("#rating").val();
  var brand = $("#brand").val();
  var mg = $("#mg").val();
  if ($('#filterby_price_drop').is(":checked"))
  {
    var filterby_price_drop = true;
  }
  else{
    var filterby_price_drop = false;
  } 

  var product_search = $("#product_search").val();

 /*price range slider*/
         $(function() {
           $("#slider-price-range").slider({
               range: true,
               min: 1,
              // min: parseInt(lowest_price),
               max: parseInt(highest_price),
               values: [parseInt(min_selected_price), parseInt(max_selected_price)],
               slide: function(event, ui) {
                   $("#slider_price_range_txt").html("<span class='slider_price_min'>$" + ui.values[0] + "</span>  <span class='slider_price_max'>$" + ui.values[1] + " </span>");
               },
                stop: function (event, ui) {
                // var curVal = ui.value;
                var min = ui.values[0];
                var max = ui.values[1];
                 var link ='';

                if(min!='' && max!=''){
                   link = SITE_URL+'/search?price='+min+'-'+max;
                  }       
                  if(brands)
                 {
                   link += '&brands='+brands;
                 }
                   if(sellers)
                 {
                   link += '&sellers='+sellers;
                 }
                  if(category)
                 {
                   link += '&category_id='+category;
                 }
                   if(mg)
                 {
                   link += '&mg='+mg;
                 }
                   if(age_restrictions)
                 {
                   link += '&age_restrictions='+age_restrictions;
                 }
                   if(rating)
                 {
                   link += '&rating='+rating;
                 }
                   if(filterby_price_drop)
                 {
                   link += '&filterby_price_drop='+filterby_price_drop;
                 }

                 if(product_search)
                 {
                   link += '&product_search='+product_search;
                 }

                 window.location.href = link;

             
                

               }//stop function

           });
           $("#slider_price_range_txt").html("<span class='slider_price_min'> $" + $("#slider-price-range").slider("values", 0) + "</span>  <span class='slider_price_max'>$" + $("#slider-price-range").slider("values", 1) + "</span>");
         }); 



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



 function addToFavorite(ref)
{   
    var guest_url = "{{url('/')}}";
    var guest_redirect_url = window.location.href;

    var id   = $(ref).attr('data-id');
    var type = $(ref).attr('data-type');
    var csrf_token = "{{ csrf_token()}}";

    var logged_in_user  = "{{Sentinel::check()}}";


    if(logged_in_user == '')
    {
        
         $.ajax({
                url:guest_url+'/set_guest_url',
                method:'GET',
                data:{guest_link:guest_redirect_url},
                dataType:'json',
           
                
                success:function(response)
                {
                  if(response.status=="success")
                  {

                    $(location).attr('href', guest_url+'/signup/guest')
                  }

                }
            });
    }
    else
    {      
        $.ajax({
            url: SITE_URL+'/favorite/add_to_favorite',
            type:"POST",
            data: {id:id,type:type,_token:csrf_token},             
            dataType:'json',
            beforeSend: function(){            
            },
            success:function(response)
            {
              if(response.status == 'SUCCESS')
              { 
                swal({
                        title: 'Success',
                        text: response.description,
                        type: 'success',
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                     },
                    function(isConfirm,tmp)
                    {                       
                      if(isConfirm==true)
                      {
                        window.location.reload();
                        $(this).addClass('active');

                      }

                    });
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

        }); 
  } 

}


function removeFromFavorite(ref)
{
    var id         = $(ref).attr('data-id');
    var type       = $(ref).attr('data-type');
    var csrf_token = "{{ csrf_token()}}";

    $.ajax({
              url: SITE_URL+'/favorite/remove_from_favorite',
              type:"POST",
              data: {id:id,type:type,_token:csrf_token},             
              dataType:'json',
              beforeSend: function(){            
              },
              success:function(response)
              {
                if(response.status == 'SUCCESS')
                { 
                  swal({
                          title: 'Success',
                          text: response.description,
                          type: 'success',
                          confirmButtonText: "OK",
                          closeOnConfirm: true
                       },
                      function(isConfirm,tmp)
                      {                       
                        if(isConfirm==true)
                        {
                            window.location.reload();
                            $(this).removeClass('active');
                        }

                      });
                }
                else
                {                
                  swal('Error',response.description,'error');
                }  
              }  


      }); 

}

</script>

<!-- Facebook Pixel Code -->
<script>
 !function(f,b,e,v,n,t,s)
 {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
 n.callMethod.apply(n,arguments):n.queue.push(arguments)};
 if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
 n.queue=[];t=b.createElement(e);t.async=!0;
 t.src=v;s=b.getElementsByTagName(e)[0];
 s.parentNode.insertBefore(t,s)}(window, document,'script',
 'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '572854193518164');
 fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
 src="https://www.facebook.com/tr?id=572854193518164&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

@endsection