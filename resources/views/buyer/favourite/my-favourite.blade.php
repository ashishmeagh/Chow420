@extends('buyer.layout.master')
@section('main_content')

<style type="text/css">
  .top-rated-brands-list.favoiritelist{margin-bottom: 0px;}
  .imgcheck-chow {
    width: 60px;
    margin-left: 10px;
  }
  .pricevies.inline-del{display: inline-block;}
  .inlineoff-div{
    display: inline-block; color: #9b9b9b !important; font-size: 15px !important;
}
.spectrum {
    display: block;
}
.line-vertical{
    display: inline-block;
    font-weight: bold;
    /*padding: 0 10px;*/
    vertical-align: top;
    line-height: 17px
}
.sellernm-text-left {
    font-weight: normal;
    color: #222;
    display: block;
    float: left;
    margin-right: 4px;
}
.sellernm-text-right {
    color: #222;
}
.font-sizesmall{
  display:inline-block; font-size:12px;
}

h1{
    font-size: 18px;
    font-weight: 600;
    background-color: #f1f5f8;
    padding: 10px 10px 10px 70px;
    color: #222;
}
</style>

<div class="my-profile-pgnm">
  {{isset($page_title)?$page_title:''}}
     <ul class="breadcrumbs-my">
        <li><a href="{{url('/')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i></li>
        <li>Wishlist</li>
      </ul>
     
</div>
<div class="chow-homepg">Chow420 Home Page</div>

@php 

if(isset($catdata) && !empty($catdata))
{
  $catdata = $catdata;
}else{
  $catdata =[];
}

if(isset($state_user_ids) && !empty($state_user_ids))
{
  $state_user_ids = array_column($state_user_ids,'id');
 }else{
  $state_user_ids ='';
}



 /*******************Restricted states seller id*********************/

  $check_buyer_restricted_states =  get_buyer_restricted_sellers();
  $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];

  $restricted_state_sellers = [];
   if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids)){

      $restricted_state_sellers = [];
      foreach($restricted_state_user_ids as $sellers) {
        $restricted_state_sellers[] = isset($sellers['id'])?$sellers['id']:'';
      }
   }
    $is_buyer_restricted_forstate = is_buyer_restricted_forstate();
   
/********************Restricted states seller id***********************/



@endphp



<div class="new-wrapper favouritepgs">
<div class="row-flex">
    @php 
     // dd($arr_data);
    $pageclick=[];
    @endphp

        @if(isset($arr_data) && sizeof($arr_data)>0)
          @php
            $wishlist_brandname ='';
            $wishlist_sellername ='';
            $wishlist_productname ='';
          @endphp
         @foreach($arr_data as $fav_product)
            @php

            $login_user = Sentinel::check();

            if(isset($fav_product['get_product_details']['product_images_details'][0]['image']) && $fav_product['get_product_details']['product_images_details'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$fav_product['get_product_details']['product_images_details'][0]['image']))
            {
              $product_img = url('/uploads/product_images/'.$fav_product['get_product_details']['product_images_details'][0]['image']);
            } 
            else
            {                  
              $product_img = url('/assets/images/default-product-image.png');
            }


             $firstcat_id = $fav_product['get_product_details']['first_level_category_id'];
             $restrictseller_id   = $fav_product['get_product_details']['user_id']; 


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

             $checkseller_flag = 0;
             if(isset($state_user_ids) && !empty($state_user_ids))
             {
                if(in_array($restrictseller_id, $state_user_ids))
                { 

                  $checkseller_flag = 1;
                }
                else
                {
                  $checkseller_flag = 0;
                }
             }



           // condition added for buyer state restriction
              if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers) 
                && isset($restrictseller_id))
             {
                if(in_array($restrictseller_id,$restricted_state_sellers))
                { 
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



              //echo "==".$firstcat_id.'--'.$restrictseller_id.'--'.$checkfirstcat_flag.'--'.$checkseller_flag;

             $wishlist_brandname = isset($fav_product['get_product_details']['get_brand_detail']['name'])?str_slug($fav_product['get_product_details']['get_brand_detail']['name']):'';

             $wishlist_sellername = isset($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name'])?str_slug($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name']):'';

             $wishlist_productname = isset($fav_product['get_product_details']['product_name'])?str_slug($fav_product['get_product_details']['product_name']):'';

              $wishlist_product_title_slug = str_slug($wishlist_productname);


               $pageclick['name'] = isset($fav_product['get_product_details']['product_name']) ? $fav_product['get_product_details']['product_name'] : '';
               $pageclick['id'] = isset($fav_product['get_product_details']['id']) ? $fav_product['get_product_details']['id'] : '';
               $pageclick['brand'] = isset($fav_product['get_product_details']['brand']) ? get_brand_name($fav_product['get_product_details']['brand']) : '';
               $pageclick['category'] = isset($fav_product['get_product_details']['first_level_category_id']) ? get_first_levelcategorydata($fav_product['get_product_details']['first_level_category_id']) : '';

                if(isset($fav_product['get_product_details']['price_drop_to']))
                {
                   if($fav_product['get_product_details']['price_drop_to']>0)
                   {
                     $pageclick['price'] = isset($fav_product['get_product_details']['price_drop_to']) ? num_format($fav_product['get_product_details']['price_drop_to']) : '';
                   }else
                   {
                    $pageclick['price'] = isset($fav_product['get_product_details']['unit_price']) ? num_format($fav_product['get_product_details']['unit_price']) : '';
                   }
                 
                }
                else
                {
                  $pageclick['price'] = isset($fav_product['get_product_details']['unit_price']) ? num_format($fav_product['get_product_details']['unit_price']) : '';
                }

               //$pageclick['position'] = $i;
               // $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($fav_product['get_product_details']['id']).'/'.$wishlist_product_title_slug.'/'.$wishlist_brandname.'/'.$wishlist_sellername ; 
               $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($fav_product['get_product_details']['id']).'/'.$wishlist_product_title_slug; 







             @endphp     

            <div @if($checkfirstcat_flag==1) class="col-my-fav my-favourite-col-fav checkrestrictionclass" 
            @else class="col-my-fav my-favourite-col-fav" @endif>
             <div class="top-rated-brands-list favoiritelist">

               {{--  @if(isset($fav_product['get_product_details']['age_restriction']) && $fav_product['get_product_details']['age_restriction']!="")

                <div class="label-list">{{isset($fav_product['get_product_details']['age_restriction_detail']['age'])?$fav_product['get_product_details']['age_restriction_detail']['age']:''}}</div>

                @endif --}}

                 @if(isset($fav_product['get_product_details']['first_level_category_details']['age_restriction']) && $fav_product['get_product_details']['first_level_category_details']['age_restriction']!="")

                <div class="label-list">{{isset($fav_product['get_product_details']['first_level_category_details']['age_restriction_detail']['age'])?$fav_product['get_product_details']['first_level_category_details']['age_restriction_detail']['age']:''}}</div>

                @endif


                 @if($login_user == true && $login_user->inRole('buyer'))
                       <a href="javascript:void(0)" class="view-favoirite" data-id="{{isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):0}}" data-type="buyer" onclick="removeFromFavorite($(this));" title="Remove from wishlist"><i class="fa fa-trash-o"></i></a>

                        {{--  <a href="{{url('/')}}/search/product_detail/{{isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):''}}" class="view-favoirite-eye" title="View Product Detail"><i class="fa fa-eye" ></i></a>   --}}
                 @endif  



                <div class="img-rated-brands">
                    <div class="thumbnailssnew">
                        {{-- <a href="{{url('/')}}/search/product_detail/{{isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):''}}/{{ $wishlist_productname }}/{{ $wishlist_brandname }}/{{ $wishlist_sellername }}"  title="View Product Detail" target="_blank" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})"> --}}
                        <a href="{{url('/')}}/search/product_detail/{{isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):''}}/{{ $wishlist_productname }}"  title="View Product Detail" target="_blank" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">
                          <img src="{{$product_img}}" class="" alt="{{isset($fav_product['get_product_details']['product_name'])?ucwords($fav_product['get_product_details']['product_name']):''}}" />
                        </a>
                    </div>
                    <div class="content-brands">
                         @php

                                    
                              $total_review   = get_total_reviews($fav_product['product_id']);
                              $avg_rating     = get_avg_rating($fav_product['product_id']); 
                              $img_avg_rating = "";  
                              if(isset($avg_rating) && $avg_rating > 0)
                              {
                                $img_avg_rating = "";

                                // if($avg_rating=='1') $img_avg_rating = "star-rate-one.png";
                                // else if($avg_rating=='2')  $img_avg_rating = "star-rate-two.png";
                                // else if($avg_rating=='3')  $img_avg_rating = "star-rate-three.png";
                                // else if($avg_rating=='4')  $img_avg_rating = "star-rate-four.png";
                                // else if($avg_rating=='5')  $img_avg_rating = "star-rate-five.png";
                                // else if($avg_rating=='0.5') $img_avg_rating = "star-rate-zeropointfive.png";
                                // else if($avg_rating=='1.5')  $img_avg_rating = "star-rate-onepointfive.png";
                                // else if($avg_rating=='2.5')  $img_avg_rating = "star-rate-twopointfive.png";
                                // else if($avg_rating=='3.5')  $img_avg_rating = "star-rate-threepointfive.png";
                                // else if($avg_rating=='4.5')  $img_avg_rating = "star-rate-fourpointfive.png";
                                 $img_avg_rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';
                              }  

                            @endphp

                            @php
                                $busines_name = isset($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name'])?$fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name']:'';
                                if(isset($busines_name)){
                                  $busines_names = str_replace(' ','-',$busines_name); 
                                }
                            @endphp

                            @php
                                $brand_name = isset($fav_product['get_product_details']['get_brand_detail']['name'])?$fav_product['get_product_details']['get_brand_detail']['name']:'';
                                if(isset($brand_name)){
                                  $brandname = str_replace(' ','-',$brand_name); 
                                }
                            @endphp



                    
                        {{-- <div class="titlebrds srch-height">
                            <a href="{{url('/')}}/search/product_detail/{{isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):''}}/{{ $wishlist_productname }}/{{ $wishlist_brandname }}/{{ $wishlist_sellername }}" title="View Product Detail" target="blank">
                                {{isset($fav_product['get_product_details']['product_name'])?ucwords($fav_product['get_product_details']['product_name']):''}}
                              </a>
                        </div> --}}


                          <div class="title-chw-list">
                            {{-- <a href="{{url('/')}}/search/product_detail/{{isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):''}}/{{ $wishlist_productname }}/{{ $wishlist_brandname }}/{{ $wishlist_sellername }}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})"> --}}
                            <a href="{{url('/')}}/search/product_detail/{{isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):''}}/{{ $wishlist_productname }}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">
                            {{--  <a href="{{ url('/') }}/search?brands={{ $brandname }}" target="_blank">
                                  {{ isset($fav_product['get_product_details']['get_brand_detail']['name'])?$fav_product['get_product_details']['get_brand_detail']['name']:'' }} 
                             </a> --}}

                            {{--  {{ isset($fav_product['get_product_details']['get_brand_detail']['name'])?$fav_product['get_product_details']['get_brand_detail']['name']:'' }} 

                             @if(isset($fav_product['get_product_details']['spectrum']))
                                  
                                    <span class="inlineblock-details"><b>

                                   {{--  @if($fav_product['get_product_details']['spectrum']=="0")
                                     <span class="line-vertical"></span>Full Spectrum 
                                    @elseif($fav_product['get_product_details']['spectrum']=="1") 
                                     <span class="line-vertical"></span>Broad Spectrum 
                                    @elseif($fav_product['get_product_details']['spectrum']=="2") 
                                     <span class="line-vertical"></span>Isolate  
                                     @endif --}}
                                      {{-- @php 
                                      $get_spectrum_val = get_spectrum_val($fav_product['get_product_details']['spectrum']);
                                     @endphp   
                                     <span class="line-vertical"></span>  
                                      {{ isset($get_spectrum_val['name'])?$get_spectrum_val['name']:'' }} 
                                  </b></span>
                             
                             <span class="cbdclass">CBD </span>
                             <span class="titlename-list">
                               {{isset($fav_product['get_product_details']['product_name'])?ucwords($fav_product['get_product_details']['product_name']):''}}
                            </span> --}}

                              <span class="titlename-list">
                                 {{ isset($fav_product['product_id'])?get_product_name($fav_product['product_id']):''  }}
                              </span>
                           </a>
                          </div>


                          <!-------------------------- Start Extra Data------------------------->
                            
                           {{--  <div class="sellernm-text">
                              <div class="sellernm-text-left">Brand:</div>
                              <div class="sellernm-text-right">
                                <a href="{{ url('/') }}/search?brands={{ $brandname }}" target="_blank">
                                  {{ isset($fav_product['get_product_details']['get_brand_detail']['name'])?$fav_product['get_product_details']['get_brand_detail']['name']:'' }} 
                                </a>
                              </div>
                            </div> --}}


                            <div class="sellernm-text">
                              <div class="sellernm-text-left">By:</div>
                              <div class="sellernm-text-right">
                               {{-- <a class="by-sellernmlink" target="_blank" href="{{ url('/') }}/search?sellers={{isset($busines_names)?$busines_names:'' }}">  --}}
                                  {{ isset($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name'])?$fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name']:'' }} 
                                </a> 

                                <a class="by-sellernmlink" target="_blank" href="{{ url('/') }}/search?sellers={{isset($busines_names)?$busines_names:'' }}"> 
                                  {{ isset($fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name'])?$fav_product['get_product_details']['get_seller_details']['seller_detail']['business_name']:'' }} 
                                </a>
                              </div>
                            </div>



                            @if(isset($fav_product['get_product_details']['per_product_quantity']) && $fav_product['get_product_details']['per_product_quantity'] != 0)
                            <div class="sellernm-text">
                              <div class="sellernm-text-left">Concentration :</div>
                              <div class="sellernm-text-right">
                               {{isset($fav_product['get_product_details']['per_product_quantity'])?$fav_product['get_product_details']['per_product_quantity']:0}}mg
                                 

                              </div>

                               @if(isset($fav_product['get_product_details']['spectrum']))

                                  @php 
                                   $get_spectrum_val = get_spectrum_val($fav_product['get_product_details']['spectrum']);
                                  @endphp                                
                                 <div class="spectrum"> 
                                    <span class="inlineblock-details">
                                      <b>

                                    {{--  @if($fav_product['get_product_details']['spectrum']=="0")
                                     <span class="line-vertical"></span>Full Spectrum 
                                     @elseif($fav_product['get_product_details']['spectrum']=="1") 
                                     <span class="line-vertical"></span>Broad Spectrum 
                                     @elseif($fav_product['get_product_details']['spectrum']=="2") 
                                     <span class="line-vertical"></span>Isolate  
                                     @endif --}}

                                      {{ isset($get_spectrum_val['name'])?$get_spectrum_val['name']:'' }} 

                                     </b>
                                  </span>

                                  <a target='_blank'  class="font-sizesmall" href="https://chow420.com/forum/view_post/MTg=">What's this?</a>
                                  </div> 
                               @endif

                            </div>
                               @endif


                             @php

                             //dd();
                              $remaining_stock = $product_availability = ""; 
                              $remaining_stock = $fav_product['get_product_details']['inventory_details']['remaining_stock']; 
                              if(isset($remaining_stock) && $remaining_stock > 0) 
                              {
                                $product_availability = 'In Stock';
                              }
                              else
                              {
                                $product_availability = 'Out Of Stock';
                              }

                             // if($product_availability=='Out Of Stock'){
                              //dd($fav_product['get_product_details']['is_outofstock']);
                            @endphp

                              {{--   @if($product_availability=='Out Of Stock')
                                  <div class="sellernm-text">
                                   <div class="sellernm-text-left">Availability:</div>
                                   <div class="sellernm-text-right"> {{$product_availability}}</div>
                                  </div>
                               @endif --}}

                               @if(isset($fav_product['get_product_details']['is_outofstock']) && $fav_product['get_product_details']['is_outofstock'] == 0)
                                 @if($remaining_stock>0 && $checkfirstcat_flag==1)
                                     <div class="sellernm-text">
                                     <div class="sellernm-text-left">Availability:</div>
                                     <div class="sellernm-text-right"> 
                                       {{--  {{$product_availability}} --}}
                                        Restricted, This product is not allowed for you to purchase based on your location.
                                      </div>
                                    </div>
                                 @elseif($remaining_stock>0 && $checkfirstcat_flag==0)
                                     <div class="sellernm-text">
                                     <div class="sellernm-text-left">Availability:</div>
                                     <div class="sellernm-text-right"> 
                                        {{$product_availability}}
                                      </div>
                                    </div>
                                  @elseif($remaining_stock<=0 && $checkfirstcat_flag==1)
                                     <div class="sellernm-text">
                                     <div class="sellernm-text-left">Availability:</div>
                                     <div class="sellernm-text-right"> 
                                          Restricted, This product is not allowed for you to purchase based on your location.
                                      </div>
                                    </div>   
                                   @elseif($remaining_stock<=0 && $checkfirstcat_flag==0)
                                     <div class="sellernm-text">
                                     <div class="sellernm-text-left">Availability:</div>
                                     <div class="sellernm-text-right"> 
                                          {{$product_availability}}
                                      </div>
                                    </div>     

                                 @endif
                               @else
                                 <div class="sellernm-text">
                                 <div class="sellernm-text-left">Availability:</div>
                                 <div class="sellernm-text-right"> 
                                      Out Of Stock
                                  </div>
                                </div>     
                               @endif






                            @php
                             // }
                            @endphp

                            {{isset($fav_product['get_product_details']['first_level_category_details']['product_type'])?$fav_product['get_product_details']['first_level_category_details']['product_type']:''}}

                          <!-------------------------- End Extra Data------------------------->


                        <div class="price-listing">
                          @if(isset($fav_product['get_product_details']['price_drop_to']))
                            @if($fav_product['get_product_details']['price_drop_to']>0)
                             @php
                               if(isset($fav_product['get_product_details']['percent_price_drop']) && $fav_product['get_product_details']['percent_price_drop']=='0.000000') 
                               {
                               $percent_price_drop = calculate_percentage_price_drop($fav_product['get_product_details']['id'],$fav_product['get_product_details']['unit_price'],$fav_product['get_product_details']['price_drop_to']); 
                               $percent_price_drop = floor($percent_price_drop);
                               }
                               else
                               { 
                                $percent_price_drop = floor($fav_product['get_product_details']['percent_price_drop']);
                               }
                             @endphp
                              <del class="pricevies black-font-clr inline-del">${{isset($fav_product['get_product_details']['unit_price'])? num_format($fav_product['get_product_details']['unit_price']):'0'}}</del><div class="inlineoff-div"> ({{$percent_price_drop}}% off)</div><br>
                              <span>${{isset($fav_product['get_product_details']['price_drop_to']) ? num_format($fav_product['get_product_details']['price_drop_to']) : '0'}} </span>
                            @else
                            <span>${{isset($fav_product['get_product_details']['unit_price'])? num_format($fav_product['get_product_details']['unit_price']):'0'}}</span>
                            @endif
                          @else
                            <span>${{isset($fav_product['get_product_details']['unit_price'])? num_format($fav_product['get_product_details']['unit_price']):'0'}}</span>
                          @endif
                        </div>

                         <div class="title-sub-list subtitlewishlist">
                        
                            <!-----------------start of---rating div-------------->

                            @if(isset($avg_rating) && $avg_rating>0)
                            <div class="stars"> 
                               {{-- <img src="{{url('/')}}/assets/front/images/{{isset($img_avg_rating)?$img_avg_rating:''}}" alt="{{isset($img_avg_rating)?$img_avg_rating:''}}" title="This rating is a combination of all ratings on chow in addition to ratings on vendor site."> --}}

                               <img src="{{url('/')}}/assets/front/images/star/{{isset($img_avg_rating)?$img_avg_rating.'.svg':''}}" alt="{{isset($img_avg_rating)?$img_avg_rating:''}}" title="{{isset($avg_rating)?$avg_rating:''}} rating is a combination of all ratings on chow in addition to ratings on vendor site.">

                               <span style=" color: #3e3e3e;"> {{ isset($avg_rating)? $avg_rating:'' }}</span>
                               <span href="#" class="str-links">
                                  {{-- @if($total_review==1)
                                  ({{ $total_review }} Rating)
                                  @elseif($total_review>1)
                                  ({{ $total_review }} Ratings)
                                  @endif --}}

                                  
                                  @if(isset($total_review)) ({{ $total_review }}) @endif

                               </span>
                            </div>
                           @endif 
                           <!-----------------end of rating div----------------------->
                        </div>

                       {{--  {{ dd($fav_product) }} --}}

                      @if(isset($fav_product['get_product_details']['is_outofstock']) && $fav_product['get_product_details']['is_outofstock'] == 0)

                          @if(isset($fav_product['get_product_details']['inventory_details']['remaining_stock']) && ($fav_product['get_product_details']['inventory_details']['remaining_stock']>0))
                              
                              <a 
                                             @if($remaining_stock>0 && $checkfirstcat_flag==0)
                                             style="display: inline-block;"
                                             @elseif($remaining_stock>0 && $checkfirstcat_flag==1)
                                             style="display: none"
                                             @elseif($remaining_stock<=0 && $checkfirstcat_flag==1)
                                             style="display: none"
                                             @elseif($remaining_stock<=0 && $checkfirstcat_flag=0)
                                             style="display: none"
                                             @endif

                                            href="javascript:void(0)" data-type="buyer" data-id="{{isset($fav_product['product_id'])?base64_encode($fav_product['product_id']):0}}" data-qty="1" 
                                                        {{-- commented age restriction condition --}}
                                                                          {{-- 

                                                           @if(isset($fav_product['get_buyer_details']['getproof_detail']) && $fav_product['get_buyer_details']['getproof_detail'] != "") 

                                                            @if(isset($fav_product['get_buyer_details']['getproof_detail']) 
                                                               && $fav_product['get_buyer_details']['getproof_detail']['approve_status']==0  

                                                               && $fav_product['get_buyer_details']['getproof_detail']['front_image']==""      
                                                               && $fav_product['get_buyer_details']['getproof_detail']['back_image']=="" 
                                                               && $fav_product['get_buyer_details']['getproof_detail']['selfie_image']=="" 

                                                                && $fav_product['get_buyer_details']['getproof_detail']['address_proof']=="" 

                                                                && $fav_product['get_buyer_details']['getproof_detail']['age_address']==""  

                                                               && $fav_product['get_product_details']['is_age_limit'] == 1 
                                                               && $fav_product['get_product_details']['age_restriction']!="") 

                                                               @if($checkfirstcat_flag==1)
                                                               @else
                                                                onclick="return buyer_id_proof_warning()"
                                                               @endif  
                         

                                                            @elseif(isset($fav_product['get_buyer_details']['getproof_detail']) 
                                                                && ($fav_product['get_buyer_details']['getproof_detail']['approve_status']==0 || $fav_product['get_buyer_details']['getproof_detail']['approve_status']==3) 
                                                                && $fav_product['get_buyer_details']['getproof_detail']['front_image']!=""
                                                                && $fav_product['get_buyer_details']['getproof_detail']['back_image']!=""
                                                                && $fav_product['get_buyer_details']['getproof_detail']['selfie_image']!=""

                                                                && $fav_product['get_buyer_details']['getproof_detail']['address_proof']!=""

                                                                && $fav_product['get_buyer_details']['getproof_detail']['age_address']!=""

                                                              && $fav_product['get_product_details']['is_age_limit'] == 1
                                                              && $fav_product['get_product_details']['age_restriction']!="") 

                                                              @if($checkfirstcat_flag==1)
                                                              @else
                                                               onclick="swal('Alert!','Id proof not approved by admin')"  
                                                              @endif 



                                                            @elseif(isset($fav_product['get_buyer_details']['getproof_detail']) && $fav_product['get_buyer_details']['getproof_detail']['approve_status']==1 
                                                              && $fav_product['get_buyer_details']['getproof_detail']['age_category']==0
                                                              && $fav_product['get_buyer_details']['getproof_detail']['front_image']!="" 
                                                              && $fav_product['get_buyer_details']['getproof_detail']['back_image']!=""
                                                              && $fav_product['get_buyer_details']['getproof_detail']['selfie_image']!=""

                                                               && $fav_product['get_buyer_details']['getproof_detail']['address_proof']!=""

                                                              && $fav_product['get_buyer_details']['getproof_detail']['age_address']!="" 
                                                              && $fav_product['get_product_details']['is_age_limit'] == 1 && $fav_product['get_product_details']['age_restriction']!="")      

                                                            @if($checkfirstcat_flag==1)
                                                            @else  
                                                            onclick="swal('Alert!','Age category not assigned')"
                                                            @endif
                                      
                                                            @elseif(isset($buyer_id_proof) 
                                                              && $buyer_id_proof['approve_status']==1 
                                                              && $buyer_id_proof['age_category'] ==1 
                                                              && $buyer_id_proof['age_category']!=$fav_product['get_product_details']['age_restriction']
                                                            && $buyer_id_proof['front_image']!=""  
                                                            && $buyer_id_proof['back_image']!=""  
                                                            && $buyer_id_proof['selfie_image']!="" 
                                                             && $buyer_id_proof['address_proof']!="" 
                                                            && $buyer_id_proof['age_address']!="" 
                                                            && $fav_product['get_product_details']['is_age_limit'] == 1 
                                                            && $fav_product['get_product_details']['age_restriction']!="")      

                                                            @if($checkfirstcat_flag==1)
                                                            @else
                                                            onclick="swal('Sorry','To buy this product your age must be 21+','warning')"
                                                            @endif


                                                            @elseif(isset($fav_product['get_buyer_details']['getproof_detail']) && $fav_product['get_buyer_details']['getproof_detail']['approve_status']==2 
                                                             && $buyer_id_proof['front_image']!=""  
                                                             && $buyer_id_proof['back_image']!="" 
                                                             && $buyer_id_proof['selfie_image']!=""
                                                              && $buyer_id_proof['address_proof']!="" 
                                                             && $buyer_id_proof['age_address']!="" 
                                                             && $fav_product['get_product_details']['is_age_limit'] == 1 
                                                             && $fav_product['get_product_details']['age_restriction']!="")      
                                                            @if($checkfirstcat_flag==1)
                                                            @else 
                                                            onclick="swal('Alert!','You can not buy this product age is not verified')"    
                                                            @endif
                                                             

                                                            @elseif(isset($fav_product['get_buyer_details']['getproof_detail']) 
                                                                && $fav_product['get_buyer_details']['getproof_detail']['approve_status']==1 
                                                                && $fav_product['get_product_details']['is_age_limit']== 0 
                                                                && $fav_product['get_product_details']['age_restriction']=="") 

                                                                    @if($checkfirstcat_flag==1)
                                                                    @else
                                                                    onclick="add_to_cart($(this))" 
                                                                    @endif


                                                                 @else

                                                                     @if($checkfirstcat_flag==1)
                                                                     @else
                                                                     onclick="add_to_cart($(this))" 
                                                                     @endif 



                                                                @endif
                                                              @else --}}

                                                                @if($checkfirstcat_flag==1)
                                                                  
                                                                @else
                                                                   onclick="add_to_cart($(this))"
                                                                @endif


                                                               {{-- @endif --}}
                                                             {{--  onclick="add_to_cart($(this))" --}}
                                  >
                                    <div class="add_to_cart" id="{{isset($fav_product['product_id'])?$fav_product['product_id']:0}}"> 
                                       Add to cart
                                    </div>

                                  </a>

                                                    {{--  @if($checkfirstcat_flag==1)  

                                                       <div class="main-check-chow">
                                                          <div class="imgcheck-chow" title=" This product is not allowed for you to purchase based on your location."><img src="{{ url('/') }}/assets/front/images/chow-check.png"></div>
                                                          <div class="check-left">                                     
                                                          </div>
                                                        </div>                                 
                                                     @else       
                                                         <div class="main-check-chow">
                                                          <div class="imgcheck-chow"><img src="{{ url('/') }}/assets/front/images/chow-check-3.png"></div>
                                                          <div class="check-left">                                     
                                                          </div>
                                                        </div>                 

                                                     @endif    --}}


                             
                          @endif
                      @endif
                      
                              
                    </div><!-- end of content brand class----->
                    <div class="clearfix"></div>
                </div>
                <div><div class="clearfix"></div></div>
            </div>
        </div>
      @endforeach
      @else
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <div class="empty-product-main">
                         <div class="empty-prodct">
                             <img src="{{url('/')}}/assets/front/images/empty-product.jpg" alt="Product" />
                         </div>
                         <div class="empty-product-title">Empty Wishlist</div>
                         <span>You have no items in your wishlist. Start adding!</span>
                     </div>
                </div>

    @endif  

      <div class="col-md-12">
        <div class="pagination-chow">

             
          @if(!empty($arr_pagination))
            {{$arr_pagination->render()}}    
           @endif 

        </div>
      </div>
</div>
</div>

<script type="text/javascript">

    var _learnq = _learnq || [];


    function add_to_cart(ref) {

    
    var id   = $(ref).attr('data-id');
    var quantity = $(ref).attr('data-qty');
    var type  = $(ref).attr('data-type');

    var csrf_token = "{{ csrf_token()}}";

     var prdid = atob(id);

    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){     
            // $(ref).html('<div class="add_to_cart">Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i></div>');    
            //$(".add_to_cart").html('Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i>');   

            $(ref).html('<div class="add_to_cart" id="'+prdid+'">Added To Cart <i class="fa fa-spinner fa-pulse fa-fw"></i></div>');
          },
          success:function(cart_response)
          {
            if(cart_response.status == 'SUCCESS')
            { 
                {{--  $.ajax({
                url: SITE_URL+'/favorite/remove_from_favorite',
                type:"POST",
                data: {id:id,type:type,_token:csrf_token},             
                dataType:'json',
                beforeSend: function(){   
                         
                },
                success:function(response)
                {
                  if(response.status == 'SUCCESS')
                  {   --}} 
                  
                  
                   $(ref).html('<div class="add_to_cart" id="'+prdid+'">Add to cart</div>');

                   $('#'+prdid).css('background-color','#18ca44');
                   $('#'+prdid).css('border','#18ca44');
                   $('#'+prdid).css('color','#fff');
 

                  // window.location.href = SITE_URL+'/my_bag';
                  $( "#mybag_div" ).load(window.location.href + " #mybag_div" );

                  _learnq.push(["track", "Added to Cart",cart_response.klaviyo_addtocart]);
                    gettrackingproductidinfo(id,quantity);  



                  {{--  }
                  else
                  {   
                    $(ref).html('<div class="add_to_cart">Add to cart</div>');              
                    swal('Error',response.description,'error');
                  }  
                }  
                });   --}}


            }
            else if(cart_response.status=="FAILURE"){ // added new
              $(ref).html('<div class="add_to_cart">Add to cart</div>');
               swal('Alert!',cart_response.description);  
               //setTimeout(function(){ location.reload(); }, 1000);
                     
            }
            else
            {                
              swal('Error',response.description,'error');
            }  
          }  

      });

  }

function removeFromFavorite(ref)
{
  swal({
      title: 'Do you really want to remove this product from wishlist?',
      type: "warning",
      showCancelButton: true,
      // confirmButtonColor: "#DD6B55",
      confirmButtonColor: "#873dc8",
      confirmButtonText: "Yes, do it!",
      closeOnConfirm: false
    },
    function(isConfirm,tmp)
    {

       if(isConfirm==true)
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
                    showProcessingOverlay();          
                  },
                  success:function(response)
                  {
                    hideProcessingOverlay();
                    if(response.status == 'SUCCESS')
                    { 
                      swal({
                              title: 'Success',
                              text: response.description,
                              type: 'success',
                              confirmButtonText: "OK",
                              confirmButtonColor: "#873dc8",
                              iconColor: "#873dc8",
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
    });

}

function buyer_id_proof_warning()
{
    swal({
      title: "Alert!",
      text: "Your age verification process not completed yet, please upload your id proof documents.",
     // type: "warning",
      confirmButtonText: "OK"
    },
    function(isConfirm){
      if (isConfirm) {
        window.location.href = SITE_URL+"/buyer/age-verification";
      }
  }); 
}

</script>

<script>
  var _learnq = _learnq || [];
  window.dataLayer = window.dataLayer || [];

  function gettrackingproductidinfo(productid,quantity)
  {
     
    if(productid)
    {
       var csrf_token = "{{ csrf_token()}}";
       var productid = atob(productid);


         $.ajax({
                url:SITE_URL+'/gettrackingproduct',
                method:'GET',
                data:{productid:productid,quantity:quantity},
     
                success:function(response)
                {
               
                  /* _learnq.push(["track", "Added to Cart", {
                    "ProductName": response.AddedItemProductName,
                   "ProductID": response.AddedItemProductID,
                   "Categories": response.AddedItemCategories,
                   "ImageURL": response.AddedItemImageURL,
                   "URL": response.AddedItemURL,
                   "Brand": response.Brand,
                   "Price": response.Price,
                   "CompareAtPrice": response.CompareAtPrice,
                   "Dispensary": response.Dispensary
                   }]);
                   */

                    var item = {
                     "ProductName": response.AddedItemProductName,
                     "ProductID": response.AddedItemProductID,
                     "Categories":response.AddedItemCategories,
                     "ImageURL": response.AddedItemImageURL,
                     "URL": response.AddedItemURL,
                     "Brand": response.Brand,
                     "Price":response.Price,
                     "CompareAtPrice": response.CompareAtPrice,
                     "Dispensary": response.Dispensary
                   };

                 //  _learnq.push(["track", "Added to Cart",item]);


                     dataLayer.push({
                        'event': 'GA - Add To Cart',
                        'ecommerce': {
                          'currencyCode': 'USD',
                          'add': {                                
                            'products': [{                       
                              'name':  response.AddedItemProductName,
                              'id':  response.AddedItemProductID,
                              'price': response.Price,
                              'brand': response.Brand,
                              'category': response.AddedItemCategories,
                             // 'variant': 'Gray',
                              'quantity': 1
                             }]
                          }
                        }
                     }); 




                }//success
            });


    }//if productid
    
  }//end function
</script>


<script>

function productclick(productObj) {

  dataLayer.push({
    'event': 'Click',
    'ecommerce': {
      'click': {
        'actionField': {'list': 'Search Results'},      
        'products': [{
          'name': productObj.name,                      
          'id': productObj.id,
          'price': productObj.price,
          'brand': productObj.brand,
          'category': productObj.category,
          //'variant': productObj.variant,
          'position': productObj.position
         }]
       }
     },
     'eventCallback': function() {
       document.location = productObj.url
     }
  });
}
</script>



@endsection

