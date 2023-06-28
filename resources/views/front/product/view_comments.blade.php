@extends('front.layout.master')
@section('main_content')

 <script type="text/javascript"  src="{{url('/')}}/assets/front/js/xzoom.min.js"></script>
 {{-- <script src="{{url('/')}}/assets/front/js/setup.js"></script> --}}
 <link href="{{url('/')}}/assets/front/css/xzoom.css" rel="stylesheet" type="text/css" />


 <!--tab css start-->
 <link href="{{url('/')}}/assets/front/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" />

 <!--for Rating half star -->
<!--rating demo-->
      <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/buyer/js/jquery.rating.js"></script>
      <script src="{{url('/')}}/assets/buyer/js/star-rating.js" type="text/javascript"></script>
<link href="{{url('/')}}/assets/buyer/css/star-rating.css" rel="stylesheet" />

<style>
.comments-mains{background-color: #f9f9f9;}
.comments-mains.profile-remove .comments-mains.sub-reply {
   background-color: #fff;
}
.times {color: #585858;}
.xzoom-container {
    width: 160px;
}
.reply-a.reply{
display: inline-block;
color: #873dc8;
font-size: 13px;
}
  .stars {
    margin: 0px 0 2px;
    display: inline-block;
}

.butn-def.btnsendreviw {
    background-color: #be43d0;
    padding: 8px 20px;
    border-radius: 2px;
    text-decoration: none;
    color: #fff; border:1px solid #be43d0;
}
.butn-def.btnsendreviw:hover{
    color: #be43d0 ; border:1px solid #be43d0;
    background-color: #fff;
}
.content-brands{text-align: left;}
  .nbs-flexisel-ul{
        overflow: hidden;
        height: 314px;
  } 
  .deactive{
background-color: #ccc;
}
 .err_rating
 {
    font-size: 0.9em;
    line-height: 0.9em;
    color:red; 
 }
.similarproduct li{
  display: inline-block;
  width: 221px;     vertical-align: top;
}
.ui-corner-all{margin-bottom: 50px; margin-top: 30px;}
.listing-details .price-block.prilbls h2 {
    margin-left: 0px !important;
    display: block;
    margin-top: 5px !important;
    float: none;
    position: static;
    font-weight: 600;
}

.price-block.prilbls {
    height: 40px;
}
.pricevies {
    float: left;
}


.price-listing.pricestatick{position: static; text-align: left;padding-left: 20px;}
.price-listing.pricestatick span{
  display: block;
}
.price-listing.pricestatick .pricevies{float: none;}
.morecontent span {
    display: none;
}
.morelink {
    display: block;
    color: red !important;
}
.morelink:hover,.morelink:focus{
  color: red !important;
}
.morelink.less
{
  color: red !important;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@php 
 $category_id = ""; 
 if(isset($arr_product['first_level_category_id']))
 {
   $category_id = base64_encode($arr_product['first_level_category_id']);
 }
if(isset($arr_product['is_active']) || isset($arr_product['is_approve']))
{
  if($arr_product['is_active']==0 || $arr_product['is_approve']==0)
  {
    echo "<script>window.location='".url('/')."';</script>";
  }

}

$product_id = base64_decode(Request::segment(3));
$avg_rating  = get_avg_rating($product_id);
if(isset($avg_rating) && $avg_rating > 0)
{
  $img_avg_rating = "";

  // if($avg_rating=='1') $img_avg_rating = "star-rate-one.svg";
  // else if($avg_rating=='2')  $img_avg_rating = "star-rate-two.svg";
  // else if($avg_rating=='3')  $img_avg_rating = "star-rate-three.svg";
  // else if($avg_rating=='4')  $img_avg_rating = "star-rate-four.svg";
  // else if($avg_rating=='5')  $img_avg_rating = "star-rate-five.svg";
  // else if($avg_rating=='0.5')  $img_avg_rating = "star-rate-zeropointfive.svg";
  // else if($avg_rating=='1.5')  $img_avg_rating = "star-rate-onepointfive.svg";
  // else if($avg_rating=='2.5')  $img_avg_rating = "star-rate-twopointfive.svg";
  // else if($avg_rating=='3.5')  $img_avg_rating = "star-rate-threepointfive.svg";
  // else if($avg_rating=='4.5')  $img_avg_rating = "star-rate-fourpointfive.svg";

    $img_avg_rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';

}

@endphp 
 

@php

 $login_user = Sentinel::getUser();
 $login_id = $login_user['id'];
 $login_email = $login_user['email']; 
@endphp

<!------------------start script for product report------------------->

<script>
@php
  $product_title = isset($arr_product['product_name']) ? $arr_product['product_name'] : '';
  $product_title_slug = str_slug($product_title);
@endphp  
var product_link = "{{url('/')}}/search/product_detail/{{isset($arr_product['id'])?base64_encode($arr_product['id']):''}}/{{ $product_title_slug }}";
var admin_email = "{{ isset($admin_arr['email']) ? $admin_arr['email']:'' }}";
var admin_id = "{{ isset($admin_arr['id']) ? $admin_arr['id']:'' }}";

var login_id = "{{ $login_id }}";
var login_email = "{{ $login_email }}";
var product_id = "{{ $arr_product['id'] }}";


  
</script>
<!------------------end script for product report------------------->


<div class="listing-page-main prodetailpage">
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
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
               
                   <div class="xzoom-container">


                       @if(!empty($arr_product['product_images_details']) 
                           && count($arr_product['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$arr_product['product_images_details'][0]['image']))

                            <img class="xzoom" id="xzoom-default"  src="{{url('/')}}/uploads/product_images/thumb/{{$arr_product['product_images_details'][0]['image'] }}"
                               xoriginal="{{url('/')}}/uploads/product_images/thumb/{{$arr_product['product_images_details'][0]['image'] }}" alt="{{ $arr_product['product_name'] }}"/>
                            @else

                          <img class="xzoom" id="xzoom-default"  src="{{url('/')}}/assets/images/default-product-image.png"
                               xoriginal="{{url('/')}}/assets/images/default-product-image.png" />

                        @endif
                        @if(!empty($arr_product['product_images_details']) && count($arr_product['product_images_details']))
                            
                        


                         @endif

                    </div> 
                </div> <!---end of zoom div------>
                 @php 
                    $total_review = get_total_reviews($product_id);
                    $getavg_rating  = get_avg_rating($product_id);   
                 @endphp
                {{-- {{ dd($arr_product) }} --}}
                <div class="listing-details">
                    
                    <h1>{{isset($arr_product['product_name'])? ucwords($arr_product['product_name']): ''}}
                    </h1> 
                    
                    
                        <!----------------------show by brand here--------------------->

                         <p class="bybrandlink-details"> By  
                            <span>
                           
                               @php
                                $brand_name = isset($arr_product['get_brand_detail']['name'])?$arr_product['get_brand_detail']['name']:'';
                                if(isset($brand_name)){
                                  $brandname = str_replace(' ','-',$brand_name); 
                                }
                               @endphp

                               <a href="{{ url('/') }}/search?brands={{ $brandname }}">
                                 {{isset($arr_product['get_brand_detail']['name'])?ucfirst($arr_product['get_brand_detail']['name']):''}}
                              </a>
                            </span>
                          </p> 

                        <!--------------------end of-show by brand here----------------->


                            @php
                            if( isset($arr_product['user_details']['first_name']) && $arr_product['user_details']['first_name']!="")
                              $firstname = $arr_product['user_details']['first_name'];
                            if(isset($arr_product['user_details']['last_name']) && $arr_product['user_details']['last_name']!="")
                              $lastname = $arr_product['user_details']['last_name'];  

                             $full_name = $firstname.'-'.$lastname;

                           @endphp
                            <span class="by-seller"> Seller:  </span> 
                              @php
                                $busines_name = isset($arr_product['user_details']['seller_detail']['business_name'])?$arr_product['user_details']['seller_detail']['business_name']:'';
                                if(isset($busines_name)){
                                  $busines_names = str_replace(' ','-',$busines_name); 
                                }

                               @endphp
                              <a class="by-sellernmlink" href="{{ url('/') }}/search?sellers={{isset($busines_names)?$busines_names:'' }}">{{ isset($arr_product['user_details']['seller_detail']['business_name'])?ucfirst($arr_product['user_details']['seller_detail']['business_name']):'' }} </a>
                              
 
                            @if(isset($arr_product['user_details']['seller_detail']['approve_verification_status']) && $arr_product['user_details']['seller_detail']['approve_verification_status']!=0)
                              <img class="tagsellrts productdtealsd" src="{{url('/')}}/assets/front/images/tag-sellers.png" alt="" />
                            {{--  <span style="padding: 1px;background-color: green;color: white;border-radius: 4px;font-size: xx-small;"> Seller Verified</span>  --}}
                            @endif

                        <!--------------------------------------------------------------------------->

                        <div class="price-block prilbls priceviewschow">
                          <div class="pricevies">Price:</div>
                          {{-- {{ dd($arr_product['mrp_price']) }} --}}
                          @if(isset($arr_product['price_drop_to']))
                            @if($arr_product['price_drop_to']>0)
                            <h2>${{isset($arr_product['price_drop_to']) ? num_format($arr_product['price_drop_to']) : '0'}} </h2>
                              <del class="pricevies">${{isset($arr_product['unit_price']) ? num_format($arr_product['unit_price']) : '0'}}</del>
                              
                            @else
                            <h2>${{isset($arr_product['unit_price']) ? num_format($arr_product['unit_price']) : '0'}} </h2>
                            @endif
                          @else
                            <h2>${{isset($arr_product['unit_price']) ? num_format($arr_product['unit_price']) : '0'}} </h2>
                          @endif 
                                                    
                          {{-- <strike>$122</strike> --}}
                          <div class="clearfix"></div>
                        </div>
                        <div class="ext-deatails bortdernone-ext">
                         @if(isset($arr_product['per_product_quantity']) && $arr_product['per_product_quantity'] != 0)
                            <p>Concentration:  <span>{{isset($arr_product['per_product_quantity'])?$arr_product['per_product_quantity']:'0'}} mg</span></p>
                          @endif
                        </div>
                         <!--Show Shipping charges if available-->
                          @if(isset($arr_product['shipping_type']) && $arr_product['shipping_type'] == 1)
                            <div class="shippingtype-div">
                             Shipping Charges: <b>${{isset($arr_product['shipping_charges'])?number_format($arr_product['shipping_charges'],2):'0'}}</b>
                            </div>
                          @elseif(isset($arr_product['shipping_type']) && $arr_product['shipping_type'] == 0)
                              <div class="shippingtype-div">
                                Free Shipping
                              </div>
                          @endif
                        
                                             
                            @if($avg_rating>0)
                              <div class="stars" @if($avg_rating>0) title="{{$avg_rating}} Avg. rating" @endif> 
                            
                                {{-- <img src="{{url('/')}}/assets/front/images/{{isset($img_avg_rating)?$img_avg_rating:''}}" alt="{{isset($img_avg_rating)?$img_avg_rating:''}}">  --}}

                                <img src="{{url('/')}}/assets/front/images/star/{{isset($img_avg_rating)?$img_avg_rating.'.svg':''}}" alt="{{isset($img_avg_rating)?$img_avg_rating:''}}"> 

                                 @if($total_review > 0)
                                 <span href="#" class="str-links starcounts" 
                                    title=" @if($total_review==1)  
                                            {{ $total_review }} Review 
                                            @elseif($total_review>1)  
                                            {{ $total_review }} Reviews 
                                            @endif
                                          ">
                                    {{ $total_review }}
                                  </span>
                                 @endif
                              </div>
                            @endif 

                


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
                              <div class="age-img-inline" title="18+ Age restriction">
                                <img src="{{url('/')}}/assets/front/images/product-age-mini.png" alt=""> 
                              </div>
                              @endif

                              @if($age_restrict=="21+")
                                <div class="age-img-inline" title="21+ Age restriction">
                                  <img src="{{url('/')}}/assets/front/images/product-age-max.png" alt=""> 
                                </div>
                              @endif

                         </div>
                        @endif

                      

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
 
                            <div @if($arr_product['inventory_details']['remaining_stock']>0) class="ext-deatails" @endif> 

                            @if($product_availability=="Out Of Stock") 
                              <p>
                                Availability: <span class='availability-outstock'>{{$product_availability}}</span>
                              </p>
                            @endif
                      </div>
                  </div>
                  <div class="clearfix"></div>  
            </div>
                    
  <!-- end of col-md-12------>

 </div> <!-----end of div class row----------->


 <link rel="stylesheet" href="{{ url('/') }}/assets/front/css/jquery-ui-tab.css">

<script>
  $( function() {
    $( "#tabs" ).tabs({
      event: "click"
    });
  } );
</script>
<body>
{{--  
<div id="tabs">
  <ul>
    <li><a href="#tabs-2">Comments</a></li>
  </ul> --}}
 
{{--   <div id="tabs-2" class="showtabcomments">
 --}}

  <div class="whitebox-list space-o-padding spacebottom-o">
    @php
     $login_user = Sentinel::check();
     $product_id = $productid;

     $seller_product_ids = [];
    if($product_id!='')
    {

      $product_id = $product_id;
      if(count($seller_products)>0)
      {
         foreach($seller_products as $key=>$value)
         {
           $seller_product_ids[] = $value['id']; 
         }
      }

    }


   @endphp
                                
                   
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
                      <div class="comments-mains profile-remove">
                          {{-- <div class="comments-mains-left">
                              <img src="{{$user_profile_img}}" alt="" />
                          </div> --}}
                          <div class="comments-mains-right">
                              <div class="txt-commnts"><span>{{$user_name}}</span>   {{isset($comment['comment'])?$comment['comment']:''}}</div>


                              @if($login_user == true && $login_user->inRole('seller') && in_array($product_id,$seller_product_ids)) 
                               <a href="javascript:void(0)" class="reply-a reply" id="{{$comment['id']}}">Answer</a>
                              @endif
                              <div class="times">{{isset($comment['created_at'])?$comment_added_at:"-"}}</div>


                              <form id="frm-send-reply" id="replyform">
                                {{ csrf_field() }}
                                <div class="white-cmmoit reply-cmts reply_div" id="reply_div_for_{{isset($comment['id'])?$comment['id']:0}}">

                                  <input type="text" name="reply" id="reply" class="reply-for-{{isset($comment['id'])?$comment['id']:0}}" placeholder="Write your answer" data-parsley-required="true" data-parsley-minlength="8" data-parsley-maxlength="150" >
                                  <span id="err_reply_{{ $comment['id'] }}"></span>
                                  <button class="btn-comments btn_send_reply" id="btn_send_reply" comment_id="{{isset($comment['id'])?$comment['id']:0}}">Send</button>
                                </div>
                             </form> 

                          </div>
                          <div class="clearfix"></div>
                          <!-------------------------start of showing reply-------------------------------------->
                         <div id="showreplydiv_{{$comment['id']}}">
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

                             <div class="comments-mains sub-reply" >
                             
                                <div class="comments-mains-right">
                                    <div class="txt-commnts"><span>
                                    {{isset($reply['user_details']['first_name'])?$reply['user_details']['first_name'] :''}} {{isset($reply['user_details']['last_name'])?$reply['user_details']['last_name']:''}}</span> {{isset($reply['reply'])?$reply['reply'] :''}}</div>
                                    <div class="times">{{isset($reply['created_at'])?$repleid_at:'-'}}</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                          {{-- </div>  --}}
 
                          @endforeach
                         @endif   
                        </div> 
                      </div>
                    @endforeach

                      <div class="pagination-chow">
                           @if(!empty($arr_pagination))
                            {{$arr_pagination->render()}}    
                           @endif
                         </div> 


                    @else
                       <div class="titledetailslist"> 
                        {{-- No Comments (0) --}}   
                        </div>
                    @endif

                </div>





   
 {{--  </div> --}}
 
{{-- </div> --}}
        
 </div>

</div>
</div>


<script>



var productid = "{{ $productid }}";

    $(".reply").click(function()
    {
      
        var comment_id = $(this).attr('id');
        $("#reply_div_for_"+comment_id).show();
        $(".reply-for-"+comment_id).val('');
        //$("#reply_div_for_"+comment_id).addClass('show-comment');
    }); 

    function showrreply(comment_id) {
    
    var id   = comment_id;
    var csrf_token = "{{ csrf_token()}}";

    $.ajax({
          url: SITE_URL+'/showrreply',
          type:"POST",
          data: {comment_id:id,_token:csrf_token},             
         // dataType:'json',
          beforeSend: function(){            
          },
          success:function(response)
          {
          //  updateDiv();
          //alert(response);
            $("#showreplydiv_"+id).html(response);
            $("#showreplydiv_"+id).show();
            $("#reply_div_for_"+id).hide();
          }  

      });
  }


      $('.btn_send_reply').click(function()
      {   

        // if($('#frm-send-reply').parsley().validate()==false) return;     

         var csrf_token = "{{ csrf_token()}}";
         var comment_id = $(this).attr('comment_id');
         var reply      = $(".reply-for-"+comment_id).val();
         var flag1=0;

          if(reply.trim()==""){

            $("#err_reply_"+comment_id).html('Please enter answer');
            $("#err_reply_"+comment_id).css('color','red');
            flag1 = 1;
            return false;
         }else{
            $("#err_reply_"+comment_id).html(' ');
            flag1 =0;
          }

              if(flag1==0){

                 $.ajax({
                  url: SITE_URL+'/comment/send_reply',
                  type:"POST",
                  data: {comment_id:comment_id,reply:reply,_token:csrf_token},             
                  dataType:'json',
                  beforeSend: function(){   
                    //showProcessingOverlay();    
                    $('.btn_send_reply').prop('disabled',true);
                    $('.btn_send_reply').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');      
                  },
                  success:function(response)
                  {
                   // hideProcessingOverlay();
                    $('.btn_send_reply').prop('disabled',false);
                    $('.btn_send_reply').html('Send');
                    
                    if(response.status == 'SUCCESS')
                    { 
                          showrreply(comment_id);
                          $("#reply_div_for_"+comment_id).hide();
                          $(this).removeClass('show-comment');
                    }
                    else
                    {                
                      swal('Error',response.description,'error');
                    }  
                  }  

                 }); // ajax function end
               }else{
                 return false;
               }

         // } // else
         return false;
       
     }); 





</script>



 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
 <script src="{{url('/')}}/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>
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


 <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/newjquery.flexisel.js"></script>
 

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