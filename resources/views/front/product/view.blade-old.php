@extends('front.layout.master')
@section('main_content')

 <script type="text/javascript"  src="{{url('/')}}/assets/front/js/xzoom.min.js"></script>
 <script src="{{url('/')}}/assets/front/js/setup.js"></script>
 <link href="{{url('/')}}/assets/front/css/xzoom.css" rel="stylesheet" type="text/css" />


 <!--tab css start-->
 <link href="{{url('/')}}/assets/front/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" />

<style>
  .deactive{
background-color: #ccc;
}
 .err_rating
 {
    font-size: 0.9em;
    line-height: 0.9em;
    color:red; 
 }

</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@php 
 $category_id = ""; 
 if(isset($arr_product['first_level_category_id']))
 {
   $category_id = base64_encode($arr_product['first_level_category_id']);
 }


$product_id = base64_decode(Request::segment(3));
$avg_rating  = get_avg_rating($product_id);
if(isset($avg_rating) && $avg_rating > 0)
{
  $img_avg_rating = "";
  if($avg_rating=='1') $img_avg_rating = "star-rate-one.png";
  else if($avg_rating=='2')  $img_avg_rating = "star-rate-two.png";
  else if($avg_rating=='3')  $img_avg_rating = "star-rate-three.png";
  else if($avg_rating=='4')  $img_avg_rating = "star-rate-four.png";
  else if($avg_rating=='5')  $img_avg_rating = "star-rate-five.png";
}
@endphp 

<div class="listing-page-main">
    <div class="container"> 
        <div class="row">
            <div class="col-md-9">
                <div class="top-breadcrum-list space-bottns">
                    <a href="{{url('/')}}">Home</a> <span>/</span> <a href="{{url('/')}}/search?category_id={{$category_id}}">{{isset($arr_product['first_level_category_details']['product_type'])?$arr_product['first_level_category_details']['product_type']:''}}</a> <span>/</span> <div class="breadcm-span">{{isset($arr_product['product_name'])? $arr_product['product_name']: ''}}</div>
                </div>
                @php
                          $login_user = Sentinel::check();
                          $fav_arr    = array();
                           if(count($fav_product_arr)>0)
                          {
                           foreach($fav_product_arr as $key=>$value)
                           {
                             $fav_arr[] = $value['product_id'];
                           }

                          }

                          /*if(isset($arr_product['product_image']) && $arr_product['product_image'] != '' && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_image']))
                          {
                            $product_img        = url('/uploads/product_images/'.$arr_product['product_image']);
                          }
                          else
                          {                  
                            $product_img        = url('/assets/images/no-product-img-found.jpg');
                          }*/

                          $product_id = 0;
                          $seller_product_ids = [];
                          if(Request::segment(3)!='')
                          {

                            $product_id = base64_decode(Request::segment(3));
                            if(count($seller_products)>0)
                            {
                               foreach($seller_products as $key=>$value)
                               {
                                 $seller_product_ids[] = $value['id']; 
                               }
                            }

                          }

                        @endphp


                <div class="img-demo-zoom">
                  {{--  @if($login_user == true)
                     @if($login_user->inRole('buyer')) 
                        @if(isset($fav_arr) && in_array($arr_product['id'],$fav_arr))
                           <a href="javascript:void(0)" class="favoirate" data-id="{{isset($arr_product['id'])?base64_encode($arr_product['id']):0}}" data-type="buyer" onclick="removeFromFavorite($(this));"><i class="fa fa-heart"></i></a>
                       @else
                          <a href="javascript:void(0)" class="favoirate deactive" data-id="{{isset($arr_product['id'])?base64_encode($arr_product['id']):0}}" data-type="buyer" onclick="addToFavorite($(this));">
                          <i class="fa fa-heart"></i>
                          </a>
                    @endif    

                    @endif
                    @else
                      <a href="javascript:void(0)" class="favoirate deactive" data-id="{{isset($arr_product['id'])?base64_encode($arr_product['id']):0}}" data-type="product" onclick="addToFavorite($(this));">
                            <i class="fa fa-heart"></i>
                        </a>
                    @endif --}}



                   <div class="xzoom-container">                  

                       @if(!empty($arr_product['product_images_details']) 
                           && count($arr_product['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_images_details'][0]['image']))

                            <img class="xzoom" id="xzoom-default"  src="{{url('/')}}/uploads/product_images/thumb/{{$arr_product['product_images_details'][0]['image'] }}"
                               xoriginal="{{url('/')}}/uploads/product_images/thumb/{{$arr_product['product_images_details'][0]['image'] }}" />
                            @else

                          <img class="xzoom" id="xzoom-default"  src="{{url('/')}}/assets/images/default-product-image.png"
                               xoriginal="{{url('/')}}/assets/images/default-product-image.png" />

                        @endif
                        @if(!empty($arr_product['product_images_details']) && count($arr_product['product_images_details']))
                            
                          <!-----------------------  thumb image code commented -------------------->
                           {{--  <div class="xzoom-thumbs">
                                @foreach($arr_product['product_images_details'] as $images)

                                @if(!empty($images['image']) && file_exists(base_path().'/uploads/product_images/'.$images['image']))
                                <a href="{{url('/')}}/uploads/product_images/thumb/{{$images['image'] }}">
                                  <img class="xzoom-gallery" width="80" src="{{url('/')}}/uploads/product_images/thumb/{{$images['image'] }}"  xpreview="{{url('/')}}/uploads/product_images/thumb/{{$images['image'] }}" ></a>
                                  @endif
                                 @endforeach
                            </div>     --}}
                          <!----------------------- end of thumb image code commented -------------------->


                         @endif

                    </div> 
                </div> <!---end of zoom div------>
                 @php 
                    $total_review = get_total_reviews($product_id);
                    $getavg_rating  = get_avg_rating($product_id);   
                 @endphp

                <div class="listing-details">
                    
                    <h1>{{isset($arr_product['product_name'])? $arr_product['product_name']: ''}}
                    </h1> 

                        <div class="stars"> 
                          <img src="{{url('/')}}/assets/front/images/{{isset($img_avg_rating)?$img_avg_rating:'star-rate-ziro.png'}}" alt=""> 
                           <span style=" color: #3e3e3e;">{{ isset($getavg_rating)?$getavg_rating:'' }}</span>
                         {{--  <a href="#" class="str-links">({{ $total_review }} Reviews)</a> --}}
                        </div>
                        <!----------------------------- seller name --------------------------------->
                         
                            @php
                            if( isset($arr_product['user_details']['first_name']) && $arr_product['user_details']['first_name']!="")
                              $firstname = $arr_product['user_details']['first_name'];
                            if(isset($arr_product['user_details']['last_name']) && $arr_product['user_details']['last_name']!="")
                              $lastname = $arr_product['user_details']['last_name'];  
                           @endphp
                            <span class="by-seller"> By </span>
                             <a class="by-sellernmlink" href="{{ url('/') }}/search?sellers={{ isset($arr_product['user_details']['id'])?base64_encode($arr_product['user_details']['id']):'' }}"> {{ $firstname }} {{ $lastname }}</a>


                      
                        <!--------------------------------------------------------------------------->

                        <div class="price-block prilbls">
                          <div class="pricevies">Price :</div>
                          <h2>${{isset($arr_product['unit_price'])?num_format($arr_product['unit_price']):'0'}}</h2>
                          {{-- <strike>$122</strike> --}}
                           
                          <div class="clearfix"></div>
                        </div>
                                             




                <div class="tag-details-pg">

                    
                    <div class="oil-category"> 
                    {{isset($arr_product['first_level_category_details']['product_type'])? $arr_product['first_level_category_details']['product_type']: ''}}</div>

                      @if(isset($arr_product['is_age_limit']) && $arr_product['is_age_limit'] == 1 && isset($arr_product['age_restriction']) && $arr_product['age_restriction'] != '')
                          <div class="age-img-plus">

                            @php
                                if(isset($arr_product['age_restriction_detail']['age']))
                                 $age_restrict = $arr_product['age_restriction_detail']['age'];
                               else
                                 $age_restrict = '';
                             @endphp

                             @if($age_restrict=="18+")
                              <div class="age-img-inline">
                                <img src="{{url('/')}}/assets/front/images/product-age-mini.png" alt=""> 
                              </div>
                              @endif

                              @if($age_restrict=="21+")
                                <div class="age-img-inline">
                                  <img src="{{url('/')}}/assets/front/images/product-age-max.png" alt=""> 
                                </div>
                              @endif

                         </div>
                        @endif

                       {{--  @if(isset($arr_product['is_age_limit']) && $arr_product['is_age_limit'] == 1 && isset($arr_product['age_restriction']) && $arr_product['age_restriction'] != '')

                           <div class="restricted pro-ag-rsted"> 
                           <div class="circle-pro-age">18+</div>
                           <div class="clearfix"></div>
                           <div class="age-lrms">Age Restricted Product </div>
                              <div class="age-rested-prds">
                                <i class="fa fa-info-circle" ></i>
                                <div class="info-age-vw">
                                      @php
                                        if(isset($arr_product['age_restriction_detail']['age']))
                                         $age_restrict = $arr_product['age_restriction_detail']['age'].' Age';
                                       else
                                         $age_restrict = '';
                                      @endphp
                                      {{ $age_restrict }}
                                </div>
                            </div> 
                          </div>
                        @endif --}}

                </div>

                        @php
                          $login_user = Sentinel::check();
                          $fav_arr    = array();
                           if(count($fav_product_arr)>0)
                          {
                           foreach($fav_product_arr as $key=>$value)
                           {
                             $fav_arr[] = $value['product_id'];
                           }

                          }

                          /*if(isset($arr_product['product_image']) && $arr_product['product_image'] != '' && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_image']))
                          {
                            $product_img        = url('/uploads/product_images/'.$arr_product['product_image']);
                          }
                          else
                          {                  
                            $product_img        = url('/assets/images/no-product-img-found.jpg');
                          }*/

                          $product_id = 0;
                          $seller_product_ids = [];
                          if(Request::segment(3)!='')
                          {

                            $product_id = base64_decode(Request::segment(3));
                            if(count($seller_products)>0)
                            {
                               foreach($seller_products as $key=>$value)
                               {
                                 $seller_product_ids[] = $value['id']; 
                               }
                            }

                          }

                         $remaining_stock = $product_availability = $brand = ""; 
                         $remaining_stock = $arr_product['inventory_details']['remaining_stock']; 
                         if(isset($remaining_stock) && $remaining_stock > 0) $product_availability = 'In Stock';
                         else $product_availability = 'Out Of Stock';

                         $brand = $arr_product['user_details']['seller_detail']['business_name'];

                        @endphp
                        

                      <div class="ext-deatails"> 
                          @if(isset($arr_product['per_product_quantity']) && $arr_product['per_product_quantity'] != 0)

                            <p>Quantity : <span>{{isset($arr_product['per_product_quantity'])?$arr_product['per_product_quantity']:'0'}} mg</span></p>
                            
                          @endif                       


                          <p>Brand : <span><a href="{{ url('/') }}/search?brand={{ isset($arr_product['brand'])?
                           base64_encode($arr_product['brand']):''}}">{{isset($arr_product['get_brand_detail']['name'])?$arr_product['get_brand_detail']['name']:''}}</a></span></p>
                           <p>Availability : <span>{{$product_availability}}</span></p>    


                           <!--------------Report Product link added------>
                             @if($login_user == true)
                              @if($login_user->inRole('buyer')) 
                                 <a href="javascript:void(0)" class="report-product">Report Product</a>
                              @endif
                             @endif 
                           <!------------------------------------------->



                           <div class="view-btns-pro-dls">
                            <div class="sre-product">

                                @if($login_user == true)
                                   @if($login_user->inRole('buyer')) 
                                      @if(isset($fav_arr) && in_array($arr_product['id'],$fav_arr))
                                         <a href="javascript:void(0)" class="shdebtns heart-o-actv" data-id="{{isset($arr_product['id'])?base64_encode($arr_product['id']):0}}" data-type="buyer" onclick="removeFromFavorite($(this));"><i class="fa fa-heart"></i>Favorite</a>
                                     @else
                                        <a href="javascript:void(0)" class="shdebtns deactive" data-id="{{isset($arr_product['id'])?base64_encode($arr_product['id']):0}}" data-type="buyer" onclick="addToFavorite($(this));">
                                        <i class="fa fa-heart-o"></i>Favorite
                                        </a>
                                  @endif    

                                  @endif
                                  @else
                                    <a href="javascript:void(0)" class="shdebtns deactive" data-id="{{isset($arr_product['id'])?base64_encode($arr_product['id']):0}}" data-type="product" onclick="addToFavorite($(this));">
                                         <i class="fa fa-heart-o"></i>Favorite
                                      </a>
                                  @endif

                              {{--   <a href="javascript::void(0)" class="shdebtns"><i class="fa fa-heart-o"></i> Favorite</a> --}}

                             </div>
                             <div class="sre-product">
                                <!-- <a href="javascript:void(0)" class="shdebtns"><i class="fa fa-share-alt-square"></i> Share</a> -->
                                <!-- <input type="hidden" value="" id="urlLink"> -->
                                <p id="urlLink" style="display: none;"></p>
                                <button class="shdebtns" onclick="shareLink('#urlLink')"><i class="fa fa-share-alt-square"></i> Share</button>
                                <div class="copeid-sms" id="copy_txt" style="display:none;"> copied</div>
                             </div> 
                              
                           </div>
                      </div>
                     
                      <div class="qty-block">
                          <label>Qty:</label>
                            <div class="select-style qty-select">
                                 <select name="item_qty" id="item_qty">
                                    @for($i=1; $i <= 12; $i++)
                                      <option value="{{$i}}">{{$i}}</option>
                                    @endfor 
                                 </select> 
                            </div>
                    

                          @if($arr_product['inventory_details']['remaining_stock'] > 0)

                            @if($login_user == true)
                                @if($login_user->inRole('seller') == true || $login_user->inRole('admin') == true)
                                    <a href="javascript::void(0)" class="add-cart" onclick="swal('Warning','Please login as a Buyer','warning')"> Add to cart
                                    </a>
                                @elseif($login_user->inRole('buyer') == true)



                                    <a href="javascript:void(0)" data-id="{{isset($product_id)?base64_encode($product_id):0}}" data-qty="1" 

                                    @if(isset($buyer_id_proof) && $buyer_id_proof != "") 


                                        @if(isset($buyer_id_proof) && $buyer_id_proof['front_image']=="" 
                                        && $buyer_id_proof['back_image']==""   && $buyer_id_proof['age_address']=="" && $buyer_id_proof['age_category']==0 
                                        && $buyer_id_proof['approve_status']==0 && $arr_product['is_age_limit'] == 1 && $arr_product['age_restriction']!="") 
                                          onclick="swal('Warning','Please Upload id proof','warning')" 

                                        @elseif(isset($buyer_id_proof) 
                                         && $buyer_id_proof['front_image']!=""  
                                         && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!=""
                                         && $buyer_id_proof['approve_status']==0 
                                          && $buyer_id_proof['age_category']==0 
                                         && $arr_product['is_age_limit'] == 1 && $arr_product['age_restriction']!="") 
                                          onclick="swal('Warning','Id proof not approved','warning')" 
                                      

                                       @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 && 
                                        $buyer_id_proof['age_category']==0
                                                                   && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $arr_product['is_age_limit'] == 1 && $arr_product['age_restriction']!="")      
                                                                    onclick="swal('Warning','Age category not assigend','warning')"

                                       @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 && $buyer_id_proof['age_category']!=$arr_product['age_restriction']
                                                                   && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $arr_product['is_age_limit'] == 1 && $arr_product['age_restriction']!="")      
                                                                    onclick="swal('Warning','You can not buy this product','warning')"

                                        @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==2 
                                                                   && $buyer_id_proof['front_image']!=""  && $buyer_id_proof['back_image']!="" && $buyer_id_proof['age_address']!="" && $arr_product['is_age_limit'] == 1 && $arr_product['age_restriction']!="")      
                                                                    onclick="swal('Warning','You can not buy this product age is not verified','warning')"   


                                          @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==0 && $arr_product['is_age_limit'] == 1 && $arr_product['age_restriction']!="")     
                                            onclick="swal('Warning','Please upload id proof','warning')"                           


                                        @elseif(isset($buyer_id_proof) && $buyer_id_proof['approve_status']==1 
                                          && $buyer_id_proof['age_category']>0   && $buyer_id_proof['age_category']==$arr_product['age_restriction'] 
                                        && $arr_product['is_age_limit'] == 1 && $arr_product['age_restriction']!="") 

                                            onclick="add_to_cart($(this))"
 
                                        @elseif(isset($buyer_id_proof) && $buyer_id_proof['id_proof']=="" && $arr_product['is_age_limit'] == 0 && $arr_product['age_restriction']=="") 

                                            onclick="add_to_cart($(this))"

                                        @else

                                            onclick="add_to_cart($(this))"  

                                        @endif
                                    @else

                                        onclick="add_to_cart($(this))"

                                     @endif
                                    class="add-cart"> Add to cart </a>                                             
                        @endif
                    @else
                        <a href="javascript::void(0)" class="add-cart guest_url_btn" > Add to cart</a>
                    @endif
                    @else
                         {{-- <span class="red-text guest_url_btn">Out of Stock</span> --}}   
                     <span class="red-text">Out of Stock</span>
                    @endif
                       
                      </div>
                     
                     
                  </div>
                  <div class="clearfix"></div>  

            </div>
           {{--  <div class="col-md-3">
                <div class="profile-main-dv">
                  <div class="bysellr">
                    <span>By</span> 
                      @php
                            if( isset($arr_product['user_details']['first_name']) && $arr_product['user_details']['first_name']!="")
                              $firstname = $arr_product['user_details']['first_name'];
                            if(isset($arr_product['user_details']['last_name']) && $arr_product['user_details']['last_name']!="")
                              $lastname = $arr_product['user_details']['last_name'];  
                        @endphp

                        {{ $firstname }} {{ $lastname }}

                  </div>
                </div>
            </div> --}}
            
  <!-- end of col-md-12------>

 </div> <!-----end of div class row----------->

<div class="col-md-12">          
{{-- Tab Section Start --}}
 <div class="tabbing_area">
   <div id="horizontalTab">
     <ul class="resp-tabs-list">
       <li id="descli">Description</li>
       <li id="commentsli">Comments</li>
       <li id="reviewsli">Reviews</li>
     </ul>
     <div class="resp-tabs-container">
         <!--tab-1 start-->
         <div id="showtabdesc">
             <h2>Description</h2>
             <div class="textdetailslist">{{isset($arr_product['description'])? $arr_product['description']: ''}}</div>
         </div>
         <!--tab-2 start-->
         <div id="showtabcomments">
               <!------------comments div------------>
               <div class="whitebox-list">
                  
                    <div class="titledetailslist pull-left">Comments ({{isset($total_comments)?$total_comments:0}})</div>
                    @if($total_comments > 5)
                    <a href="javascript:void(0)" class="viewallcomments pull-right">View All</a>
                    @endif
                    <div class="clearfix"></div>
                  

                     @if(isset($arr_comment) && sizeof($arr_comment)>0)
                      @foreach($arr_comment as $comment)
                        @php
                          $user_name = "";
                          if(isset($comment['user_details']['first_name']) && isset($comment['user_details']['last_name']))
                          {  
                            $user_name = $comment['user_details']['first_name']." ".$comment['user_details']['last_name']; 
                          }  

                         if(isset($comment['user_details']['profile_image']) && $comment['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$comment['user_details']['profile_image']))
                        {
                          $user_profile_img = url('/uploads/profile_image/'.$comment['user_details']['profile_image']);
                        }
                        else
                        {                  
                          $user_profile_img = url('/assets/images/user-no-image.png');
                        }

                         $comment_added_at     = ''; 
                         $comment_added_at     = us_date_format($comment['created_at']);
                       @endphp
                      <div class="comments-mains">
                          <div class="comments-mains-left">
                              <img src="{{$user_profile_img}}" alt="" />
                          </div>
                          <div class="comments-mains-right">
                              <div class="txt-commnts"><span>{{$user_name}}</span>   {{isset($comment['comment'])?$comment['comment']:''}}</div>
                              @if($login_user == true && $login_user->inRole('seller') && in_array($product_id,$seller_product_ids))
                               <a href="javascript:void(0)" class="reply-a reply" id="{{$comment['id']}}">Reply</a>
                              @endif
                              <div class="times">{{isset($comment['created_at'])?$comment_added_at:"-"}}</div>

                              <form id="frm-send-reply">
                                {{ csrf_field() }}
                                <div class="white-cmmoit reply-cmts reply_div" id="reply_div_for_{{isset($comment['id'])?$comment['id']:0}}">

                                  <input type="text" name="reply" id="reply" class="reply-for-{{isset($comment['id'])?$comment['id']:0}}" placeholder="Write your reply" data-parsley-required="true" data-parsley-minlength="8" data-parsley-maxlength="150" >
                                  <span id="err_reply_{{ $comment['id'] }}"></span>
                                  <button class="btn-comments btn_send_reply" id="btn_send_reply" comment_id="{{isset($comment['id'])?$comment['id']:0}}">Send</button>
                                </div>
                             </form> 
                          </div>
                          <div class="clearfix"></div>
                          @if(isset($comment['reply_details']) && sizeof($comment['reply_details'])>0)
                            @foreach($comment['reply_details'] as $reply)
                               @php 

                                $repleid_at = "";
                                $repleid_at = us_date_format($reply['created_at']);

                                 if(isset($reply['user_details']['profile_image']) && $reply['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$reply['user_details']['profile_image']))
                                 {
                                   $user_profile_img = url('/uploads/profile_image/'.$reply['user_details']['profile_image']);
                                 }
                                else
                                {                  
                                  $user_profile_img = url('/assets/images/user-no-image.png');
                                }  
                               @endphp
                             <div class="comments-mains sub-reply">
                                <div class="comments-mains-left">
                                    <img src="{{ $user_profile_img }}" alt="">
                                </div>
                                <div class="comments-mains-right">
                                    <div class="txt-commnts"><span>
                                    {{isset($reply['user_details']['first_name'])?$reply['user_details']['first_name'] :''}} {{isset($reply['user_details']['last_name'])?$reply['user_details']['last_name']:''}}</span> {{isset($reply['reply'])?$reply['reply'] :''}}</div>
                                    <div class="times">{{isset($reply['created_at'])?$repleid_at:'-'}}</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                          @endforeach
                         @endif   
                      </div>
                    @endforeach
                    @endif
                    
                     @php 
                
                     @endphp 

                    @if($login_user == true)
                      @if($login_user->inRole('buyer'))
                      <div class="white-cmmoit">
                          <form id="validation-form">
                              {{ csrf_field() }}
                          <input type="hidden" name="product_id" id="product_id" value="{{ $product_id }}">
                          <input type="text" name="comment" id="comment" placeholder="Write your comment" data-parsley-required="true" data-parsley-minlength="8" data-parsley-maxlength="150"/>
                          {{-- <a href="#" class="btn-comments">Send</a> --}}
                          <button type="button" class="btn-comments" id="btn_add_comment">Send</button>
                         </form>
                      </div>
                     @elseif($login_user->inRole('seller') && isset($seller_product_ids) && (!(in_array($product_id, $seller_product_ids))))
                     <form id="validation-form">
                      {{ csrf_field() }}
                      <div class="white-cmmoit">
                          <input type="hidden" name="product_id" id="product_id" value="{{ $product_id }}">
                          <input type="text" name="comment" id="comment" placeholder="Write your comment" data-parsley-required="true" data-parsley-minlength="8" data-parsley-maxlength="150"/>
                         <button type="button" class="btn-comments" id="btn_add_comment">Send</button>
                      </div>
                     </form>

                     @endif
                   @endif

                </div>
                <!------------end of comments div----------------->
         </div> 
        {{-- Tab 3 --}}
          <div>
                    @php 
                    $total_reviews = get_total_reviews($product_id);

                    $avg_rating  = get_avg_rating($product_id);
                    if(isset($avg_rating) && $avg_rating > 0)
                    {
                      $img_avg_rating = "";
                      if($avg_rating=='1') $img_avg_rating = "star-rate-one.png";
                      else if($avg_rating=='2')  $img_avg_rating = "star-rate-two.png";
                      else if($avg_rating=='3')  $img_avg_rating = "star-rate-three.png";
                      else if($avg_rating=='4')  $img_avg_rating = "star-rate-four.png";
                      else if($avg_rating=='5')  $img_avg_rating = "star-rate-five.png";
                    }

                    @endphp 

                    <div class="whitebox-list reviewboxs">
                        <div class="review-txts-sub-left">
                           {{--  <div class="review-txts-sub">
                                <div class="review-sub-head">{{isset($avg_rating)?$avg_rating:''}}</div>
                            </div> --}}
                            <div class="review-txts-stars">
                                {{-- <img src="{{ url('/') }}/assets/front/images/{{ $img_avg_rating }}" alt=""> --}}
                                @if($total_reviews > 0)
                                  <h2>{{isset($total_reviews)?$total_reviews:''}} Reviews</h2>
                                @else
                                  <h2>No Reviews</h2>
                                @endif
                            </div>
                        </div>
                        <div class="button-rev">
                             @if($login_user==true && $login_user->inRole('buyer') && $is_review_added==0 && $product_purchased_by_user==1)
                               <a href="#frm-add-review" class="butn-def">Write a Review</a>  
                             @endif    
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="comment-view-only">
                        @if(isset($arr_product['review_details']) && sizeof($arr_product['review_details']))
                        @foreach($arr_product['review_details'] as $review)
                          @php 

                                $review_at = "";
                                $review_at = date('h:i - M d, Y', strtotime($review['created_at']));

                                 if(isset($review['user_details']['profile_image']) && $review['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$review['user_details']['profile_image']))
                                 {
                                   $user_profile_img = url('/uploads/profile_image/'.$review['user_details']['profile_image']);
                                 }
                                 else
                                {                  
                                  $user_profile_img = url('/assets/images/no_image_available.jpg');
                                }  


                                if(isset($review['rating']) && $review['rating'] > 0)
                                {
                                  $img_rating = "";
                                  if($review['rating']=='1') $img_rating = "star-rate-one.png";
                                  else if($review['rating']=='2')  $img_rating = "star-rate-two.png";
                                  else if($review['rating']=='3')  $img_rating = "star-rate-three.png";
                                  else if($review['rating']=='4')  $img_rating = "star-rate-four.png";
                                  else $review['rating'] = $img_rating ="star-rate-five.png";
                                } 
                          @endphp
                        <div class="comment-view-only-white">
                            <div class="comment-view-only-white-left">
                                <img src="{{$user_profile_img}}" alt="" />
                            </div>
                            <div class="comment-view-only-white-right">
                                <div class="title-user-name"> {{isset($review['user_details']['first_name'])?$review['user_details']['first_name'] :''}} {{isset($review['user_details']['last_name'])?$review['user_details']['last_name']:''}}</div>
                                <div class="lisitng-detls-rate">
                                 {{--  <span>{{isset($review['rating'])?$review['rating']:''}}</span>  --}}
                                <img src="{{url('/')}}/assets/front/images/{{isset($img_rating)?$img_rating:'star-rate-ziro.png'}}" alt="">
                                 {{--  <img src="{{ url('/') }}/images/star-rate-four.png" alt="" /> --}}
                                </div>
                                <div class="datetimes">{{isset($review_at)?$review_at:''}}</div>
                                <p>{{isset($review['review'])?$review['review']:''}} </p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @endforeach
                        @endif
                        

                         @if($total_reviews > 6)
                                  <div class="load-more">
                                    <a href="#" class="loadmores">Load More...</a>
                                </div>
                                
                                @endif


                        
                    </div>


                    @if($login_user==true && $login_user->inRole('buyer') && $is_review_added==0 && $product_purchased_by_user==1)
                     <form id="frm-add-review">
                      {{ csrf_field() }}
                      <div class="whitebox-list">
                          <div class="titledetailslist">Rate This Product</div>

                          <input type="hidden" name="product_id" id="product_id" value="{{isset($product_id)?$product_id:''}}">

                          <div class='rating-stars'>
                              <ul id='stars'>
                                <li class='star' title='Poor' data-value='1'    data-parsley-required="true">
                                  <i class='fa fa-star fa-fw' value="1" ></i>
                                </li>
                                <li class='star' title='Fair' data-value='2'  data-parsley-required="true">
                                  <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Good' data-value='3'  data-parsley-required="true">
                                  <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Excellent' data-value='4'  data-parsley-required="true">
                                  <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='WOW!!!' data-value='5' data-parsley-required="true">
                                  <i class='fa fa-star fa-fw'></i>
                                </li>
                              </ul>
                              <div id="err_rating"></div>
                            </div>
                            <hr>

                            <input type="hidden" id="rating" name="rating">

                            <div class="titledetailslist">Comments</div>
                              <div class="form-group">
                                  <label for="">Title</label>
                                  <input type="text" name="title" id="title" class="input-text" placeholder="Title" data-parsley-required="true">
                              </div>
                              <div class="form-group">
                                  <label for="">Write Comment</label>
                                  <textarea class="input-text" placeholder="Write Comment" name="review" id="review" data-parsley-required="true" data-parsley-minlength='20'></textarea>
                              </div>
                              <div class="button-list-dts">
                                  <button class="butn-def" id="btn_send_review">Send Review</button>
                                  <a href="#" class="butn-def cancelbtnss">Cancel</a>
                              </div>
                      </div>
                     </form> 
                    @endif
          </div>
     </div>
   </div>
 </div>



{{-- Tab Section End --}}


        </div>


         <!---------------------start of similar product------------------------------>

             @if(isset($arr_similar_product) && !empty($arr_similar_product))
                {{--  @php 
                    $style ='display:none';  
                 @endphp
                  @foreach($arr_similar_product as $product)          

                      @php  
                       $avg_rating = get_avg_rating($product['id']);
                       if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}

                       if($avg_rating>0)
                         $style= "display:block";
                       else if($avg_rating<0)

                        $style= "display:none";
                      @endphp                      
                  @endforeach --}}


             {{--  <div class="col-md-12" style={{ $style }}> --}}         
              <div class="col-md-12" style="">
  
              <div class="border-home-brfands"></div>

               <div class="toprtd non-mgts">Similar Products</div>
                <div class="featuredbrands-flex">
                   <ul 
                   @if(isset($arr_similar_product) && count($arr_similar_product)<7)
                    class="similarproduct"
                   @elseif(isset($arr_similar_product) && count($arr_similar_product)>7)
                    id="flexiselDemo1" style="display: block"
                   @endif 
                   >      

                   {{-- <ul id="flexiselDemo1" style="display: block">       --}}
               
                    @foreach($arr_similar_product as $product)                     
                      @php  
                      $avg_rating = get_avg_rating($product['id']);
                       if($avg_rating==1){$rating = 'one';}else if($avg_rating==2){$rating = 'two';}else if($avg_rating==3){$rating = 'three';}else if($avg_rating==4){$rating = 'four';}else if($avg_rating==5){$rating = 'five';}

                      @endphp
                     {{--  @if($avg_rating>0) --}}
                      <li> 
                        <div class="top-rated-brands-list">
                            <a href="#" title="{{ $product['product_name'] }}">
                              <div class="img-rated-brands"> 
                                <div class="thumbnailss"> 
                                     @if(!empty($product['product_images_details']) 
                                     && count($product['product_images_details']))  

                                        @if(!empty($product['product_images_details']) 
                                         && count($product['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$product['product_images_details'][0]['image']))
                                              <img src="{{url('/')}}/uploads/product_images/{{ $product['product_images_details'][0]['image'] }}" class="portrait" alt="" />
                                        @else
                                             <img src="{{url('/')}}/assets/images/default-product-image.png" class="portrait" alt="" /> 
                                        @endif

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
                                    <div class="titlebrds"><a href="#" title="{{ $product['product_name'] }}">{{ $product['product_name']}}</a></div>                                    
                                </div>
                            </div>
                          </a>
                        <div class="clearfix"></div>
                        </div>
                    </li>     
                     {{-- @endif     --}}
                    @endforeach       
                         
                </ul>
              </div>
            </div> 
          @endif   
          <!-------------------end of similar product--------------------------------->


        
    </div>

</div>


<script>
    var productid = "{{ $productid }}";

  $(document).ready(function(){
   // var productid = "{{ $productid }}";
  //  showcomments(productid);
      $('#urlLink').html(window.location.href);
  });

  // on click ofcomment tab show comments html function
  /*$(document).on('click','#commentsli',function(){
    showcomments(productid);
    $("#showtabcomments").show();
    $("#showtabdesc").hide()
  });*/


  function showcomments(productid) {
    
    var id   = productid;
    var csrf_token = "{{ csrf_token()}}";

    $.ajax({
          url: SITE_URL+'/showcomments',
          type:"POST",
          data: {product_id:id,_token:csrf_token},             
         // dataType:'json',
          beforeSend: function(){            
          },
          success:function(response)
          {
            $("#showtabcomments").html(response);
          }  

      });


  }


  function add_to_cart(ref) {
    
    var id   = $(ref).attr('data-id');
    var quantity = $('#item_qty').val();
    var csrf_token = "{{ csrf_token()}}";

    $.ajax({
          url: SITE_URL+'/my_bag/add_item',
          type:"POST",
          data: {product_id:id,item_qty:quantity,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){            
          },
          success:function(response)
          {
            if(response.status == 'SUCCESS')
            { 
               swal({ 
                        title: "Added",
                         text: response.description,
                          type: "success" 
                        },
                        function(){
                          window.location.href = SITE_URL+'/my_bag';
                      });
            }
            else
            {                
              swal('Error',response.description,'error');
            }  
          }  

      });


  }
    $(".reply").click(function()
    {
        var comment_id = $(this).attr('id');
        $("#reply_div_for_"+comment_id).addClass('show-comment');
    }); 
    

      $('#btn_add_comment').click(function()
      { 
       if($('#validation-form').parsley().validate()==false) return;
     
         var productid = "{{ $productid }}";

         var csrf_token = "{{ csrf_token()}}";
         var product_id = $("#product_id").val();
         var comment    = $("#comment").val();

        $.ajax({
            url: SITE_URL+'/comment/store',
            type:"POST",
            data: {product_id:product_id,comment:comment,_token:csrf_token},             
            dataType:'json',
            beforeSend: function(){   
            showProcessingOverlay();
            $('#btn_add_comment').prop('disabled',true);
            $('#btn_add_comment').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');         
            },
            success:function(response)
            {
              hideProcessingOverlay();
              $('#btn_add_comment').prop('disabled',false);
              $('#btn_add_comment').html('Send');
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

                         /*showcomments(productid);                      
                         $("#commentsli").addClass('resp-tab-item resp-tab-active');
                         $("#descli").addClass("resp-tab-item");
                         $("#showtabcomments").addClass('resp-tab-content resp-tab-content-active');
                         $("#showtabdesc").addClass('resp-tab-content');*/

                        
                      }

                    });
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 
           return false;
       
     }); 

      $('.btn_send_reply').click(function()
      {   

        // if($('#frm-send-reply').parsley().validate()==false) return;
     

         var csrf_token = "{{ csrf_token()}}";
         var comment_id = $(this).attr('comment_id');
         var reply      = $(".reply-for-"+comment_id).val();

          if(reply.trim()==""){

            $("#err_reply_"+comment_id).html('Please enter comment');
            $("#err_reply_"+comment_id).css('color','red');
            return false;
         }else{
            $("#err_reply_"+comment_id).html(' ');

          $.ajax({
            url: SITE_URL+'/comment/send_reply',
            type:"POST",
            data: {comment_id:comment_id,reply:reply,_token:csrf_token},             
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
                        $(this).removeClass('show-comment');

                      }

                    });
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 

          } // else
           return false;
       
     }); 


      $('#stars li').click(function(){
         var rating = $(this).data('value'); 
         $("#err_rating").html("");
         $("#rating").val(rating);
      });


      $('#btn_send_review').click(function()
      { 
        var rating = $("#rating").val();
        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          return false; 
        }

        if($('#frm-add-review').parsley().validate()==false) return;

        var form_data   = $('#frm-add-review').serialize(); 
     
         var csrf_token = "{{ csrf_token()}}";
     
        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/store',
            type:"POST",
            data: form_data,             
            dataType:'json',
            beforeSend: function(){ 
             showProcessingOverlay();
             $('#btn_send_review').prop('disabled',true);
             $('#btn_send_review').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');

            },
            success:function(response)
            {
               hideProcessingOverlay();
              $('#btn_send_review').prop('disabled',false);
              $('#btn_send_review').html('Send Review');
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
           return false;
       
     }); 

        

 


  $(document).ready(function(){

  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    responseMessage(msg);
    
  });
  
  
});


function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
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
                    //guest_url_btn"
                    $(this).addClass('guest_url_btn');

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

function shareLink(element) 
{
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();

    // $('#copy_txt').display('block');
    $("#copy_txt").css("display", "block");
}

</script>
<<<<<<< HEAD


<script src="{{url('/')}}/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>
=======
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script src="{{url('/')}}/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>
>>>>>>> b75de2bb4e73fec32b52db644a97489b42f51e5c
<script>
         $('#horizontalTab').easyResponsiveTabs({
            
           type: 'default', //Types: default, vertical, accordion           
           width: 'auto', //auto or any width like 600px
           fit: true, // 100% fit in a container
           closed: 'accordion', // Start closed if in accordion view
           activate: function(event) { // Callback function if tab is switched
               var $tab = $(this);
               var $info = $('#tabInfo');
               var $name = $('span', $info);         
               $name.text($tab.text());         
               $info.show();
                 

           }
         });
</script>





 <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/jquery.flexisel.js"></script>
    <script type="text/javascript">
        
    $(window).load(function() {
    $("#flexiselDemo1").flexisel();
    $("#flexiselDemo2").flexisel({
    visibleItems: 7,
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
    itemsToScroll: 2
    },
    tablet: {
    changePoint:768,
    visibleItems: 7,
    itemsToScroll: 3
    },
    laptop: {
        changePoint: 1370,
        visibleItems: 6
    }
    }
    });

    
    });
    </script>
@endsection