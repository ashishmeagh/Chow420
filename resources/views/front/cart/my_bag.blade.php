@extends('front.layout.master')
@section('main_content')
<style>

.mybaglists.list-checkout-item .list-serv-itms.mybag-listpage .itm-left-list{
        margin: 0 0 10px;
  }  
.age-img-plus.small-size-age {width: 30px;margin-bottom: 6px;}
.setbgcolor{
  color: #873dc8;
}
.shippingtype-div.showshippingdiv {
    display: inline-block;
    /*margin-left: 20px;*/
}
.sweet-alert h3 {
    color: #575757;
    font-size: 21px;
    text-align: center;
    font-weight: lighter;
    text-transform: none;
    position: relative;
    margin: 10px 0;
    padding: 0;
    line-height: 27px;
    display: block;
}
.shippingtype-div.showshippingdiv {
    display: inline-block;

    background-color: #873dc8;
    padding: 4px 10px;
    font-size: 12px;
    border-radius: 30px;
    color: #fff;
    font-weight: 600;
}
.age-img-plus.small-size-age {
    display: inline-block;
}
.inlineblock-view {
    display: inline-block;margin-left: 5px; padding-left: 0px;
}

h1 {
    display: block;
    vertical-align: top;
    font-size: 20px; font-weight: 500;
    margin-right: 40px;
}
@media (max-width: 650px){
  .headerchnagesmobile .logo-block.mobileviewlogo{
        width: 55vw;
  }
}
@media (max-width: 520px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 53vw;
}
}
@media (max-width: 450px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 45%;
}
}
@media (max-width: 414px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 35%;
}
}
@media (max-width: 350px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 30%;
}
.main-logo {
    width: 70px;
    margin-top: 11px !important;
}
}
</style>

@if(count($arr_final_data)>0) 
<div class="cart-section-block">
    <a href="{{url('/')}}/my_bag" class="cart-step-one">
        <div class="step-one step-active">
            <span class="num-step num-step-hide">1</span>
            <span class="step-tick"> </span>
            <span class="name-step-confirm">Shopping Cart</span>
        </div>
        <div class="clearfix"></div>
    </a>



    @if(count($arr_final_data) > 0)
        {{-- <a href="{{url('/')}}/checkout" class="cart-step-one"> --}}
        <a href="javascript:void(0)" class="cart-step-one">
    @else
        <a href="javascript:void(0)" class="cart-step-one">
    @endif 
        <div class="step-one">
          <span class="num-step font-style"> </span>
          <span class="name-step-confirm">Payment & Billing </span>
        </div>
        <div class="clearfix"></div>
    </a>
    <a href="javascript:void(0)" class="cart-step-one">
        <div class="step-one last-cart-step">
            <span class="num-step font-style"> </span>
            <span class="name-step-confirm">Order Placed</span>
        </div>
      <div class="clearfix"></div>
    </a>
    <div class="clearfix"></div>
</div>

@endif


@php 

 $checkuser_locationdata = checklocationdata(); 
 if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
 {
   $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
 } 

if(isset($catdata) && !empty($catdata))
{
  $catdata = $catdata;
}else{
  $catdata =[];
}

$login_user = Sentinel::check();  

 $buyer_approve_status =0;
 $buyerinfo = [];
if(isset($login_user) && !empty($login_user))
{
  $buyerinfo = get_buyer_details($login_user->id);
  if(isset($buyerinfo['buyer_detail']) && !empty($buyerinfo['buyer_detail']))
  {
    $buyer_approve_status = isset($buyerinfo['buyer_detail']['approve_status'])?$buyerinfo['buyer_detail']['approve_status']:'';
  }
}


 /*******************Restricted states seller id*********************/

  $check_buyer_restricted_states =  get_buyer_restricted_sellers();
  $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];

  $restricted_state_sellers = [];
   if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids)){

      $restricted_state_sellers = [];
      foreach($restricted_state_user_ids as $sellers) {
        $restricted_state_sellers[] = $sellers['id'];
      }
   }
   $is_buyer_restricted_forstate = is_buyer_restricted_forstate();
 
/********************Restricted states seller id***********************/


@endphp



  @php
  $check_flagoflocation = 0;
  $buyerage_flag = 0;
  $remainingstock = 0;
 @endphp

 @if(count($arr_final_data) > 0)                     
  @foreach($arr_final_data as $product_arr)                     
   @foreach($product_arr['product_details'] as $product)
     @php
       $firstcat_id = $product['first_level_category_id'];
       $remainingstock = get_remaining_stock($product['product_id']);

       $is_age_limit = isset($product['first_level_category_details']['is_age_limit'])?$product['first_level_category_details']['is_age_limit']:'';
       $age_restriction = isset($product['first_level_category_details']['age_restriction'])?$product['first_level_category_details']['age_restriction']:'';
       
       if(isset($catdata) && !empty($catdata))
       {
          if((in_array($firstcat_id, $catdata) && isset($remainingstock) && $remainingstock>0) || (in_array($firstcat_id, $catdata) && isset($remainingstock) && $remainingstock<=0))
          { 
            $check_flagoflocation++; 
          }
          else if(isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) && !empty($age_restriction) && 
            $buyer_approve_status!="1")
          {
           
             $buyerage_flag++; 
          }
          else{
            //$check_flagoflocation = 0;
          }
       }
       @endphp
   @endforeach
  @endforeach 
 @endif 



<div class="space-60">
<div class="container">
<div class="row">
            
@if(count($arr_final_data) > 0)
 <div class="col-md-8">
      <!-------------------------my bag page new html------------------------->
      <div class="review-itemsshipngs">
          <h1>Review items and shipping</h1>
      </div>

@php
  
   if(count($arr_final_data) > 0){
    $product_ids='';
    foreach($arr_final_data as $product_arr)
    {    
        $product_id_arr =[];
        foreach($product_arr['product_details'] as $product)
        {
              $product_id_arr[] =   $product['product_id'];
        }
    }
     
   $product_ids = implode(",", $product_id_arr);  
  }
 
@endphp 

<div class="listing-checkouts-prime">

  @include('front.layout.flash_messages')

     <input type="hidden" name="hidden_product_ids" id="hidden_product_ids" value="{{ isset($product_ids)?$product_ids:'' }}" />
     
          @php 
           $checkcouponcodeforseller = $checkcouponcodeforseller1 = $setproductids = $checkcouponproduct = $sessioncoupon_data = [];
           $get_total_amountofsellers = []; $totalpriceofseller = [];

           $sessiondeliveryoption_data = $totalpriceof_optionseller = [];

           $pageclick = [];
          @endphp
             
          @if(count($arr_final_data) > 0)
            @foreach($arr_final_data as $keys=>$product_arr)

               @php 


                  if(is_array(Session::get('sessioncoupon_data')) && !empty(Session::get('sessioncoupon_data')))
                  {
                    $sessioncoupon_data =  Session::get('sessioncoupon_data');
                  }

                  if(is_array(Session::get('sessiondeliveryoption_data')) && !empty(Session::get('sessiondeliveryoption_data')))
                  {
                    $sessiondeliveryoption_data =  Session::get('sessiondeliveryoption_data');
                   // dd($sessiondeliveryoption_data);
                  }

                  $checkseller_hascoupons = check_seller_couponcode($keys);

                  //$j=0;
                 // if(isset($checkseller_hascoupon) && $checkseller_hascoupon==1)
                 // {
                      if(!in_array($keys,$checkcouponcodeforseller1))
                      {
                         array_push($checkcouponcodeforseller1,$keys);
                         //$j++;
                      }
                //  }
                                           
              @endphp

              @if(in_array($keys,$checkcouponcodeforseller1))
              <div class="maincls no-couponcls" >                   

              @php
                $product_arr_key = 0;
              @endphp
              @foreach($product_arr['product_details'] as $product)

              @php


                $product_arr_key++;
              @endphp              

                 @if(isset($sessioncoupon_data[$keys]))
                  @php 

                        foreach($sessioncoupon_data as $ks=>$val){
                           if($ks==$product['user_id'])  {
                             // $totalpriceofseller[$ks][$product['product_id']]['total'] = $product['total_price']+$product['shipping_charges'];
                             $totalpriceofseller[$ks][$product['product_id']]['total'] = $product['total_price'];
                             $totalpriceofseller[$ks][$product['product_id']]['couponid'] = $val['couponcodeId'];
                             $totalpriceofseller[$ks][$product['product_id']]['productid'] = $product['product_id'];

                             $totalpriceofseller[$ks][$product['product_id']]['couponcode'] = $val['couponcode'];
                             $totalpriceofseller[$ks][$product['product_id']]['discount'] = $val['discount'];
                           
                           }//if userid
                        }//if sessiondata

                 
                  @endphp
                  @endif  


                   @if(isset($sessiondeliveryoption_data[$keys]))
                  @php 

                        foreach($sessiondeliveryoption_data as $ks1=>$val1){
                           if($ks1==$product['user_id'])  {
                              $totalpriceof_optionseller[$ks1][$product['product_id']]['total'] = $product['shipping_charges'];
                            // $totalpriceof_optionseller[$ks1][$product['product_id']]['total'] = $product['total_price'];
                             $totalpriceof_optionseller[$ks1][$product['product_id']]['id'] = $val1['delivery_option_id'];
                             $totalpriceof_optionseller[$ks1][$product['product_id']]['productid'] = $product['product_id'];

                             $totalpriceof_optionseller[$ks1][$product['product_id']]['day'] = $val1['day'];
                             $totalpriceof_optionseller[$ks1][$product['product_id']]['cost'] = $val1['cost'];
                             $totalpriceof_optionseller[$ks1][$product['product_id']]['title'] = $val1['title'];
                           }//if userid
                        }//if sessiondata

                 // dd($totalpriceof_optionseller);
                  @endphp
                  @endif  

                 <?php 
                 $str_delivery_duration =  $str_delivery_durationto = "";
                 $mybag_brandname=''; $mybag_sellername='';

              
                 if(isset($product['shipping_duration']) && $product['shipping_duration']!="")
                 { 
                   // $str_delivery_duration = get_shipping_duration_in_date($product['shipping_duration'],date('m-d-Y'));     // commented by Harshada
                   $str_delivery_duration = get_shipping_duration_in_date_new($product['shipping_duration'],date('m-d-Y')); 

                   // $str_delivery_durationto = date("D. M d",strtotime($str_delivery_duration.' +2 days'));   // commented by Harshada
                    $str_delivery_durationto = date("F d",strtotime($str_delivery_duration.' +2 days'));
                 }

                 ?>

                 @php


                  $remaining_stock =0;

                   $firstcat_id = $product['first_level_category_id'];
                  // $restrictseller_id   = $product['user_id'];
 
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



                     // condition added for buyer state restriction
                      if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers) && isset($product['user_id']))
                     {
                        if(in_array($product['user_id'],$restricted_state_sellers))
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




                     $remaining_stock = get_remaining_stock($product['product_id']);

                     $mybag_brandname = isset($product['product_brand_detail']['name'])?str_slug($product['product_brand_detail']['name']):'';

                     $mybag_sellername = isset($product['product_seller_detail']['seller_detail']['business_name'])?str_slug($product['product_seller_detail']['seller_detail']['business_name']):'';

                    $is_age_limit = isset($product['first_level_category_details']['is_age_limit'])?$product['first_level_category_details']['is_age_limit']:'';
                    $age_restriction = isset($product['first_level_category_details']['age_restriction'])?$product['first_level_category_details']['age_restriction']:''; 


                      $checkseller_hascoupon = check_seller_couponcode($product['user_id']);

                      $j=0;
                      if(isset($checkseller_hascoupon) && $checkseller_hascoupon==1)
                      {
                          if(!in_array($keys,$checkcouponcodeforseller))
                          {
                             array_push($checkcouponcodeforseller,$product['user_id']);
                             $j++;
                          }
                          $checkcouponproduct[] = $product['product_id'];
                      }
                        

                      if(isset($checkcouponcodeforseller) && !empty($checkcouponcodeforseller))
                      {
                        $checkcouponcodeforseller = array_unique($checkcouponcodeforseller);
                      }

                  
                      if(is_array(Session::get('sessioncoupon_data')) && !empty(Session::get('sessioncoupon_data')))
                      {
                       $sessioncoupon_data =  Session::get('sessioncoupon_data');
                      }


                                    
                  if(is_array(Session::get('sessioncoupon_data')) && Session::get('sessioncoupon_data') != "")
                  {

                   $session_coupon_data = Session::get('sessioncoupon_data');

                   $sessioncoupon_codeofseller = isset($session_coupon_data[$keys]['couponcode'])?$session_coupon_data[$keys]['couponcode']:'';

                   $sessioncoupon_idofseller = isset($session_coupon_data[$keys]['couponcodeId'])?$session_coupon_data[$keys]['couponcodeId']:'';


                   $sessioncouponseller_id = isset($session_coupon_data[$keys]['seller'])?$session_coupon_data[$keys]['seller']:'';


                     if($product['user_id'] == $sessioncouponseller_id){

                     }//if userid

                  }//if inarray sessiondata


                      $newarr = [];  $seller_totalall_amt =0;
                      if(isset($totalpriceofseller) && !empty($totalpriceofseller))
                      {
                      foreach($totalpriceofseller as $k2=>$v2)
                      {

                         $newarr[$k2]['seller'] = $k2;
                         $newarr[$k2]['sellername'] = get_seller_details($k2);

                          foreach($v2 as $prd=>$data)
                          {
                            $newarr[$k2]['discount'] = $data['discount'];
                            $newarr[$k2]['couponcode'] = $data['couponcode'];
                            $newarr[$k2]['couponid'] = $data['couponid'];
                            $newarr[$k2]['total'][] = $data['total'];
                         }

                         $newarr[$k2]['seller_total_amt'] = array_sum($newarr[$k2]['total']);

                         if(isset($newarr[$k2]['discount']))
                         {
                            $newarr[$k2]['seller_discount_amt'] = $newarr[$k2]['seller_total_amt']*$newarr[$k2]['discount']/100;

                             $seller_totalall_amt += $newarr[$k2]['seller_discount_amt'];
                         }

                      }//foreach                      
                     }//if totalpriceofseller


                    // echo "<pre>";print_r($totalpriceof_optionseller);

                      $newarr_options = [];  $seller_totalall_option_amt =0;
                      if(isset($totalpriceof_optionseller) && !empty($totalpriceof_optionseller))
                      {
                      foreach($totalpriceof_optionseller as $k22=>$v22)
                      {

                         $newarr_options[$k22]['seller'] = $k22;
                         $newarr_options[$k22]['sellername'] = get_seller_details($k22);

                          foreach($v22 as $prd=>$data)
                          {

                            $newarr_options[$k22]['id'] = $data['id'];
                            $newarr_options[$k22]['cost'] = $data['cost'];
                            $newarr_options[$k22]['title'] = $data['title'];
                            $newarr_options[$k22]['day'] = $data['day'];
                            //$newarr_options[$k22]['total'][] = $data['total'];
                           // $newarr_options[$k22]['total'][] = $data['total'];
                         }

                         // $newarr_options[$k22]['seller_total_option_amt'] = array_sum($newarr_options[$k22]['total']);

                         if(isset($newarr_options[$k22]['cost']))
                         {
                            $newarr_options[$k22]['seller_option_amt'] = $newarr_options[$k22]['cost'];

                            $seller_totalall_option_amt += $newarr_options[$k22]['cost'];
                         }

                      }//foreach                      
                     }//if totalpriceof_optionseller

                    @endphp

             
          

              <div class="mybaglistmain">  

                <div @if($checkfirstcat_flag==1) class="mybaglists checkrestrictionclass" @else class="mybaglists" @endif @if(in_array($product['user_id'],$checkcouponcodeforseller) && $j==1) style="" @endif>
                     <div class="list-serv-itms">
                         
                        <div class="clearfix"></div>


                        <div class="itm-left-list">
                          @php
                            if(isset($product['product_image'][0]['image']) && $product['product_image'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_image'][0]['image']))
                            {
                              $product_img = url('/uploads/product_images/'.$product['product_image'][0]['image']);
                            }
                            else
                            {                  
                              $product_img = url('/assets/images/default-product-image.png');
                            }
                          @endphp
                          @php
                            $product_title = isset($product['product_name']) ? $product['product_name'] : '';
                            $product_title_slug = str_slug($product_title);
                           $is_besesellersimilar = check_isbestseller($product['product_id']); 


                            $pageclick['name'] = isset($product['product_name']) ? $product['product_name'] : '';
                             $pageclick['id'] = isset($product['product_id']) ? $product['product_id'] : '';
                             $pageclick['brand'] = isset($product['product_brand_detail']['name']) ? $product['product_brand_detail']['name'] : '';
                             $pageclick['category'] = isset($product['first_level_category_id']) ? get_first_levelcategorydata($product['first_level_category_id']) : '';
                             
                            $pageclick['price'] = isset($product['total_price']) ? num_format($product['total_price']) : '';
                              
                             $pageclick['url'] = url('/').'/search/product_detail/'.base64_encode($product['product_id']).'/'.$product_title_slug;
                            




                          @endphp
                            <a href="{{url('/')}}/search/product_detail/{{isset($product['product_id'])?base64_encode($product['product_id']):''}}/{{ $product_title_slug }}"  title="{{isset($product['product_name'])?$product['product_name']:''}}">
                            
                              <img class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$product_img}}"  alt="{{isset($product['product_name'])?$product['product_name']:''}}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})"/></a>
                        </div>
                        <div class="itm-right-list">
                            @php
                                $prod_name = isset($product['product_name']) ? ucwords($product['product_name']): '';   
                                if(strlen($prod_name)>42)
                                {
                                   $prod_name= substr($prod_name,0,35)."..." ;
                                }
                                else
                                {
                                    $prod_name= $prod_name;
                                }    
                            @endphp




                              <div class="title-chw-list list-bagtitle">
                                <a href="{{url('/')}}/search/product_detail/{{isset($product['product_id'])?base64_encode($product['product_id']):''}}/{{ $product_title_slug }}"  title="{{isset($product['product_name'])?$product['product_name']:''}}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})">
                               

                                 <span class="titlename-list">
                                 {{ isset($product['product_id'])?get_product_name($product['product_id']):''  }}
                                 </span>

                                 </a>
                                 <div class="clearfix"></div>
                              </div>



                             <div class="soldby unitpricesold"><span>Unit Price:</span>
                              @php
                              $unit_price ='';
                               if($product['price_drop_to']>0){
                                $unit_price = $product['price_drop_to'];
                               }else
                               {
                                 $unit_price = $product['unit_price'];

                               } 
                              @endphp

                             ${{ num_format($unit_price,2) }} 
                            </div>

                             
                               @if(isset($product['first_level_category_details']['is_age_limit']) && $product['first_level_category_details']['is_age_limit']==1)
                                <div class="age-img-plus small-size-age">

                                  @php  

                                      if(isset($product['first_level_category_details']['age_restriction_detail']['age']))
                                       $age_restrict = $product['first_level_category_details']['age_restriction_detail']['age'];
                                     else
                                       $age_restrict = '';
                                   @endphp

                                   @if($age_restrict=="18+")
                                    <div class="age-img-inline" title="18+ Age restriction">
                                      <img src="{{url('/')}}/assets/front/images/product-age-mini.png" alt="18+ Age restriction"> 
                                    </div>
                                    @endif

                                    @if($age_restrict=="21+")
                                      <div class="age-img-inline" title="21+ Age restriction">
                                        <img src="{{url('/')}}/assets/front/images/product-age-max.png" alt="21+ Age restriction"> 
                                      </div>
                                    @endif

                               </div>
                              @endif



                               <!-------------cc and best seller---------------> 

                               

                                   @if( (isset($product['is_chows_choice']) && $product['is_chows_choice']==1))
                                   
                                      <div class="inlineblock-view ">


                                        @if(isset($product['is_chows_choice']) && $product['is_chows_choice']==1)
                                          
                                           {{-- <div class="chow_choice-orange best-sller-view trending-choice">  --}} 
                                            <span class="b-class-hide">
                                             <img src="{{url('/')}}/assets/front/images/chow_s-choice-icon-chow.svg" alt=""> Choice 
                                            </span>
                                            {{-- </div> --}}
                                        @endif  

                                      </div>  
                                   @endif   
                                   <!----------------ebd cc and best seller--------->



 
                            <div class="bundletotal"><span>Total:</span> ${{isset($product['total_price'])?num_format($product['total_price']):0}} {{-- <span>Item 1 of 2</span> --}}</div>

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
                                 <div class="freeshipping-class" title="{{ $setshippingsimilar }}">
                                  Free Shipping
                                </div>
                                @endif
                              <!----------truck----------------->
                          
                            <div class="soldby soldby-txt">Sold By: <span>{{isset($product_arr['seller_details']['first_name'])?$product_arr['seller_details']['seller_detail']['business_name']:""}}</span>
                            </div>

                            <div class="soldby soldby-txt"> 
                              Arrives
                              <span>
                                {{isset($str_delivery_duration)?$str_delivery_duration:''}} - {{ isset($str_delivery_durationto)?$str_delivery_durationto:'' }} 
                              </span>
                              

                            </div>


                            <div class="quantity-tx quantity-solds">
                              <span>Quantity:</span>
                           
                               <input type="text" name="item_qty" id="item_qty_{{ $product['product_id'] }}"   data-pro-id="{{base64_encode($product['product_id'])}}" class="item_qty form-control"  value="{{ $product['item_qty'] }}" product_id={{ $product['product_id'] }} onkeypress="return isNumberKey(event)"/>
                               


                             <a href="javascript:void(0)" product_id={{ $product['product_id'] }} class="updatecart_btn" data-pro-id="{{base64_encode($product['product_id'])}}" id="updatecart_btn_{{ $product['product_id'] }}">Update</a> 
                             <a onclick="confirm_remove($(this),event);" href="#" pid={{ $product['product_id'] }} data-pro-id="{{base64_encode($product['product_id'])}}"
                                class="removecart">Remove</a> 
                              <span class="error-qtys"  id="qtyerr_{{ $product['product_id'] }}"></span>
                           </div>   


                            <!--------------outofstock--Restricted-------------> 

                              @if(isset($product['is_outofstock']) && $product['is_outofstock'] == 0 )   

                                  @if(isset($remaining_stock) && $remaining_stock > 0)   
                                    
                                       @if($checkfirstcat_flag==1)
                                        <div class="out-of-stock static-stock"> 
                                         <span class="red-text">
                                           Restricted
                                         </span>
                                       </div>
                                        @else                                                         
                                       @endif
                                  @else

                                    <div class="out-of-stock static-stock"> 

                                        @if($checkfirstcat_flag==1)
                                         <span class="red-text">
                                           Restricted
                                         </span>
                                        @else

                                          <div class="chow_choice-hm-out-stock">Out of stock</div>
                                        @endif

                                     </div>
                                  @endif 

                              @else

                                  @if($checkfirstcat_flag==1)
                                    

                                      <div class="">Restricted</div>
                                  @else
                                     
                                       <div class="chow-hm-out-stock">Out of stock</div>

                                  @endif
                                    
                              @endif    
                            
                          <!---------------outofstock--Restricted------------>



                           <!-----------show age verification msg-------->
                            @if(isset($is_age_limit) && !empty($is_age_limit) && isset($age_restriction) && !empty($age_restriction) 
                            && $buyer_approve_status!=1)
                              
                                {{-- <a href="#" class="age-verificationbtns">Age-verification needed after checkout</a> --}}
                            @endif 

                           <!-----------end show age verification msg-->

                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </div> <!-----end of mybaglistmain--------->
              @endforeach 

             </div><!----maincls-------->
             @endif

            @endforeach 
          @endif           
        {{-- </div> --}} <!-----end of mybaglistmain--------->
      </div>
      <!------------------------- end of my bag page new html------------------------->
          <div class="totl-buttons-amout">
                <div class="totel-of-cart">

                     @php 
                    
                       if(isset($seller_totalall_amt) && !empty($seller_totalall_amt)){
                          $subtotal = $subtotal- $seller_totalall_amt;
                       }
                       else{
                          $subtotal = $subtotal;  
                       }


                       if(isset($seller_totalall_option_amt) && !empty($seller_totalall_option_amt))
                       {
                         $subtotal = $subtotal+ $seller_totalall_option_amt;
                       }else
                       {
                        $subtotal = $subtotal; 
                       }


                                
                   @endphp


                    <span>Total:</span> ${{isset($subtotal)?num_format($subtotal):'00'}}
                </div>


               
             

                <div class="button-rev buttn-mybag">
             
                     @php

                      $check_flag = 0;
                      $buyeragestatus_flag = 0;
                      $remaining_stock = 0;
                      $buyer_state_restricted_flag =0;
                     @endphp
                     @if(count($arr_final_data) > 0)                     
                      @foreach($arr_final_data as $product_arr)                     
                       @foreach($product_arr['product_details'] as $product)
                         @php

                           $seller_id   = isset($product['user_id'])?$product['user_id']:'';
                           $firstcat_id = $product['first_level_category_id'];
                           $remaining_stock = get_remaining_stock($product['product_id']);

                           $is_age_limit = isset($product['first_level_category_details']['is_age_limit'])?$product['first_level_category_details']['is_age_limit']:'';
                           $age_restriction = isset($product['first_level_category_details']['age_restriction'])?$product['first_level_category_details']['age_restriction']:'';

                           
                           if(isset($catdata) && !empty($catdata))
                           {
                              if((in_array($firstcat_id, $catdata) && isset($remaining_stock) && $remaining_stock>0) || (in_array($firstcat_id, $catdata) && isset($remaining_stock) && $remaining_stock<=0))
                              { 
                                $check_flag++; 
                                // echo "==".$check_flag;
                               // break;
                              }
                              else if(isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) && !empty($age_restriction) && 
                                $buyer_approve_status!="1")
                              {
                               
                                 $buyeragestatus_flag++; 
                              }
                              else{
                                //$check_flag = 0;
                              }
                           }//if catdata


                          // condition added for buyer state restriction
                            if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($restricted_state_sellers) && !empty($restricted_state_sellers) && isset($seller_id))
                           {
                              if(in_array($seller_id,$restricted_state_sellers))
                              { 
                              
                              }
                              else
                              {
                                $buyer_state_restricted_flag++; 
                              }
                           }
                           elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($restricted_state_sellers))
                           {
                            $buyer_state_restricted_flag++; 
                           }
                           else
                           {
                             //$checkfirstcat_flag = 0;
                           }



                           @endphp
                       @endforeach
                      @endforeach 
                     @endif 

                   


        @if(isset($login_user) && $login_user==true)
             
               @if($check_flag>0)
                <a href="#" class="butn-def" onclick="restrictcheckout()">Checkout</a>
               @elseif($buyer_state_restricted_flag>0)
                <a href="#" class="butn-def" onclick="restrict_buyerstate_checkout()">Checkout</a>  
              @else
                <a href="#" class="butn-def" id="checkout_btn">Checkout</a>
              @endif

        @else
        {{-- <a href="{{ url('/') }}/login" class="butn-def" >Checkout</a> --}}
        <a href="{{ url('/') }}/guest_signup" class="butn-def" >Checkout</a>
        @endif

        {{-- <a href="javascript:void(0)" class="butn-def" id="empty_cart">Empty Cart</a> --}}
    </div>
  <div class="clearfix"></div>
 </div>
</div> <!-------end of col-md-8------------>


<div class="col-md-4">            
  <div class="whitebox-sidebar bagmy-right">
                    
        @foreach($arr_final_data as $product_arr)
            @foreach($product_arr['product_details'] as $product)

                <div class="box-selectscarts">
                    <div class="prodct-left-cart">
                        <div class="counts-pro">{{isset($product['item_qty'])?$product['item_qty']:'0'}}
                        </div>

                    @php
                        if(isset($product['product_image'][0]['image']) && $product['product_image'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_image'][0]['image']))
                        {
                            $product_img = url('/uploads/product_images/'.$product['product_image'][0]['image']);
                        }
                        else
                        {                  
                            $product_img = url('/assets/images/default-product-image.png');
                        } 
                    @endphp
                     @php
                      $product_title = isset($product['product_name']) ? $product['product_name'] : '';
                      $product_title_slug = str_slug($product_title);

                      $bag_brandname = isset($product['product_brand_detail']['name'])?str_slug($product['product_brand_detail']['name']):'';


                      $bag_sellername = isset($product['product_seller_detail']['seller_detail']['business_name'])?str_slug($product['product_seller_detail']['seller_detail']['business_name']):'';  

                    @endphp
                    <a href="{{url('/')}}/search/product_detail/{{isset($product['product_id'])?base64_encode($product['product_id']):''}}/{{ $product_title_slug }}"  title="{{isset($product['product_name'])?$product['product_name']:''}}"><img src="{{$product_img}}" alt="{{isset($product['product_name'])?$product['product_name']:''}}" /></a>
                   

                    </div>
                    <div class="prodct-midal-cart">
                        @php
                            $prod_name = isset($product['product_name']) ? ucwords($product['product_name']): '';   
                            if(strlen($prod_name)>42)
                            {
                            $prod_name= substr($prod_name,0,35)."..." ;
                            }
                            else
                            {
                                $prod_name;
                            }    
                        @endphp
                        <div class="titlecartsmdls">
                          <a href="{{url('/')}}/search/product_detail/{{isset($product['product_id'])?base64_encode($product['product_id']):''}}/{{ $product_title_slug }}"  title="{{isset($product['product_name'])?$product['product_name']:''}}">{{ $prod_name }}</a>
                         
                        </div>
                        <div class="subpoints">{{isset($product_arr['seller_details']['first_name'])?$product_arr['seller_details']['first_name']:''}} {{isset($product_arr['seller_details']['last_name'])?$product_arr['seller_details']['last_name']:''}}</div>
                    </div>
                    <div class="prodct-right-cart">${{isset($product['total_price'])?num_format($product['total_price']):'0'}}</div>
                    <div class="clearfix"></div>
                </div>
            @endforeach                           
        @endforeach
                   
        <div class="border-sidebr"></div>
         <div class="ordersummary-txts">Order Summary</div>
        <div class="items-shippings-smry">
            <div class="items-lefttp">Subtotal</div>
            <div class="items-righttp">${{num_format($maintotal)}}</div>
            <div class="clearfix"></div>
        </div>
         <div class="border-tlts"></div>




        <div class="items-shippings-smry">
            <div class="items-lefttp">Shipping</div>
           
            {{-- <div class="subtotal-right">$ {{num_format(shipping_charges($subtotal))}}</div> --}}
            <div class="items-righttp">${{$shippingsubtotal}}</div>
            
            <div class="clearfix"></div>
        </div> 


        @php


        if(isset($newarr) && !empty($newarr))
          {
            foreach($newarr as $kk1=>$vv1)
            {

              @endphp
                 <div class="border-tlts"></div>
                 <div class="items-shippings-smry">
                    <div class="items-lefttp">
                          {{isset($vv1['sellername'])?$vv1['sellername']:''}} 
                         ({{isset($vv1['couponcode'])?$vv1['couponcode']:''}})
                    </div>       
                    <div> Discount : {{ isset($vv1['discount'])?$vv1['discount']:''}}%</div>   
                    <div> Total Amount : ${{ isset($vv1['seller_total_amt'])?$vv1['seller_total_amt']:''}}</div>                      
               
                    <div class="items-righttp">{{ isset($vv1['seller_discount_amt'])? '-$'.$vv1['seller_discount_amt']:''}}</div>
                    
                    <div class="clearfix"></div>
                </div> 


              @php

            }//foreach newarr
          }//if newarr 



         if(isset($newarr_options) && !empty($newarr_options))
        {
          foreach($newarr_options as $kk11=>$vv11)
          {

            @endphp
               <div class="border-tlts"></div>
               <div class="items-shippings-smry">
                  <div class="items-lefttp">
                        {{isset($vv11['sellername'])?$vv11['sellername']:''}} 
                       ({{isset($vv11['title'])?$vv11['title']:''}})
                  </div>       
                  <div> Cost : {{ isset($vv11['cost'])? '$'.$vv11['cost']:''}}</div>   
                 {{--  <div> Total Amount : ${{ isset($vv11['seller_total_option_amt'])?$vv11['seller_total_option_amt']:''}}</div> --}}                      
             
                  <div class="items-righttp">{{ isset($vv11['cost'])? '+$'.$vv11['cost']:''}}</div>
                  
                  <div class="clearfix"></div>
              </div> 


            @php

          }//foreach newarr_options
        }//if newarr_options 

                 
        @endphp
                   
        <div class="items-shippings-smry totls-amouttotal">
            <div class="items-lefttp">Total</div>
           
            <div class="items-righttp"><span>${{num_format($subtotal)}}</span></div>
            <div class="clearfix"></div>
        </div>

                
        <div class="subtotal">
           {{--  <a href="{{url('/')}}/checkout" class="butn-def">Checkout</a> //commented --}}
            {{-- <a href="javascript:void(0)" class="butn-def">Checkout</a> --}}
        </div>
    </div>
</div> <!---end of col-md-4-------->



@else
<div class="col-md-12">
<div class="empty-product-main">
    <div class="empty-prodct">
        <img class="cart-emtys" src="{{url('/')}}/assets/front/images/cart-emty.gif" alt="Cart" />
    </div>
     {{--  <div class="empty-product-title">Your Shopping Cart is empty</div> --}}
      <div class="empty-product-title">Your cart is empty!</div>
      <div class="empty-product-title">Add items to it now.</div>
      <div class="empty-product-title"><u><a href="{{ url('/') }}/search" class="setbgcolor">Continue Shopping</a></u></div>
    </div>
   </div>
@endif
 </div>
</div>
</div>






@php

if(count($arr_final_data) > 0)
{                     
    $value = 0; $encodedproducts = [];
    foreach($arr_final_data as $product_arr)
    {                     
     
      foreach($product_arr['product_details'] as $k=>$product)
      {
        $encodedproducts[] = $product;
        
        $value = $value + $product['total_price'];
       
      }
    }
}

  $setarr = $res = $firstcatname = [];
  $firstcatname = $product_title_slug = $urlbrands_name = $sellername = $urlsellername = '';
  $allcategories = $allproducts = [];
  $latestproductname = $latestproductid = $latestproductprice = $latestproductqty = $latesturl = $latestproducturl = $url = '';

if(isset($encodedproducts) && !empty($encodedproducts))
{
  $setarr = $res = $firstcatname = [];
  $firstcatname = $product_title_slug = $urlbrands_name = $sellername = $urlsellername = '';
  $allcategories = $allproducts = [];
  $latestproductname = $latestproductid = $latestproductprice = $latestproductqty = $latesturl = $latestproducturl ='';

   foreach($encodedproducts as $prd)
   {
    $product_title_slug = str_slug($prd['product_name']);
     $setarr['ProductID'] = $prd['product_id'];
     $setarr['ProductName'] = $prd['product_name'];
     $setarr['Quantity'] = $prd['item_qty'];
     $setarr['ItemPrice'] = $prd['total_price'];
     $setarr['RowTotal'] = $prd['total_price'];

     if(isset($prd['product_image'][0]['image']) && !empty($prd['product_image'][0]['image'])){
        $url = url('/').'/uploads/product_images/'.$prd['product_image'][0]['image'];
      }else{
        $url ='';
      }
     $setarr['ImageURL'] = $url;

     if(isset($prd['first_level_category_id']))
     {
       $firstcatname = get_first_levelcategorydata($prd['first_level_category_id']);
     }
     $setarr['ProductCategories'] = array($firstcatname);

     $urlbrands_name = isset($prd['product_brand_detail']['name'])?str_slug($prd['product_brand_detail']['name']):'';

     $sellername = get_seller_details($prd['user_id']);
     if(isset($sellername))
     {
      $urlsellername = str_slug($sellername);
     }

     $producturl = url('/').'/search/product_detail/'.$prd['product_id'].'/'.$product_title_slug.'/'.$urlbrands_name.'/'.$urlsellername;

     $setarr['ProductURL'] = $producturl;

     $allcategories[] = $firstcatname;
     $allproducts[] = $prd['product_name'];
     $res[] = $setarr;
     $latestproductname = $prd['product_name'];
     $latestproductid = $prd['product_id'];
     $latestproductprice = $prd['total_price'];
     $latestproductqty = $prd['item_qty'];
     
      if(isset($prd['product_image'][0]['image']) && !empty($prd['product_image'][0]['image'])){
        $latesturl = url('/').'/uploads/product_images/'.$prd['product_image'][0]['image'];
      }else{
        $latesturl ='';
      }

      $latestproducturl = url('/').'/search/product_detail/'.$prd['product_id'].'/'.$product_title_slug.'/'.$urlbrands_name.'/'.$urlsellername;

   }
}
@endphp


@php

  $shippingtotal  = 0;
  $total_amount   = 0;
  $fulltotal_amount   = 0;
  $category_array = [];
  $name           = [];
  $category_name = '';
  $product_array = $product_array_googleapi = $product_array_googleapi1 = [];
  $sellername ='';
  $producturl='';
  $imgurl='';
  $brand_name='';

/*build array for klavio tracking*/
  if(isset($arr_final_data) && count($arr_final_data))
  {
      foreach($arr_final_data as $key => $product) 
      { 

 
          if(isset($product['product_details']) && count($product['product_details'])>0)
          {

            foreach ($product['product_details'] as $key => $value)
            {
               
                $product_title_slug = str_slug($value['product_name']);
                $urlbrands_name = isset($value['product_brand_detail']['name'])?str_slug($value['product_brand_detail']['name']):'';

                $sellername = get_seller_details($value['user_id']);
                   
                if(isset($sellername))
                {
                    $urlsellername = str_slug($sellername);
                }

                $producturl = url('/').'/search/product_detail/'.$value['product_id'].'/'.$product_title_slug.'/'.$urlbrands_name.'/'.$urlsellername;

                if(isset($value['product_image'][0]['image']) && !empty($value['product_image'][0]['image']))
                {
                   $imgurl = url('/').'/uploads/product_images/'.$value['product_image'][0]['image'];
                }


                $product_array[$key]['ProductID']           = $value['product_id'];
                //$product_array['SKU'] = $value[''];
                $product_array[$key]['ProductName']         = $value['product_name'];
                $product_array[$key]['Quantity']            = $value['item_qty'];
                $product_array[$key]['ItemPrice']    = num_format($value['unit_price']);
                $product_array[$key]['RowTotal']            = $value['total_price'];
                $product_array[$key]['ProductURL']          = $producturl;
                $product_array[$key]['ImageURL']            = $imgurl;
                $product_array[$key]['ProductCategories']   = get_first_levelcategorydata($value['first_level_category_id']);

                $shippingtotal    += $value['shipping_charges'];
                $total_amount     += $value['total_price'];

                $fulltotal_amount  = $shippingtotal+$total_amount;

                $name[]           =  $value['product_name'];
                $category_name    =  get_first_levelcategorydata($value['first_level_category_id']);

                if(!in_array($category_name,$category_array))
                {
                  $category_array [] = $category_name;
                }//if


                
                $product_array_googleapi['id']    = $value['product_id'];
                $product_array_googleapi['name']  = $value['product_name'];
                $product_array_googleapi['quantity']     = $value['item_qty'];
                $product_array_googleapi['price']     = $value['total_price'];
                $product_array_googleapi['category']   = get_first_levelcategorydata($value['first_level_category_id']);

                if(isset($value['product_brand_detail']) && !empty($value['product_brand_detail']))
                {
                  $brand_name = isset($value['product_brand_detail']['name'])?$value['product_brand_detail']['name']:''; 
                }
                $product_array_googleapi['brand']     = $brand_name;

                $product_array_googleapi1[] = isset($product_array_googleapi)?$product_array_googleapi:[];

            }//foreach
           

          }//if product details

         
      }//foreach
      
  }//if final data

  $time = time();
 

$klaviyo_productarr = $klaviyo_arr = [];

if(isset($product_array) && !empty($product_array))
{
   $i=1;
  foreach($product_array as $kk1=>$vv1)
  {

        $klaviyo_productarr['ProductID']           = isset($vv1['ProductID'])?$vv1['ProductID']:'';
        $klaviyo_productarr['ProductName']         = isset($vv1['ProductName'])?$vv1['ProductName']:'';
        $klaviyo_productarr['Quantity']            = isset($vv1['Quantity'])?$vv1['Quantity']:'';
        $klaviyo_productarr['ItemPrice']           = isset($vv1['RowTotal'])?num_format($vv1['RowTotal']):'';
        $klaviyo_productarr['RowTotal']            = isset($vv1['RowTotal'])?num_format($vv1['RowTotal']):'';
        $klaviyo_productarr['ProductURL']          = isset($vv1['ProductURL'])?$vv1['ProductURL']:'';
        $klaviyo_productarr['ImageURL']            = isset($vv1['ImageURL'])?$vv1['ImageURL']:'';
        $klaviyo_productarr['ProductCategories']   = isset($vv1['ProductCategories'])?$vv1['ProductCategories']:'';

        $klaviyo_arr[] = $klaviyo_productarr;
         $i++;

  }
}

@endphp

@endsection





@section('page_script')

<script>

 var URL = "{{ url('/') }}";
 var item = <?php echo json_encode($klaviyo_arr);?> ;  
 var _learnq = _learnq || [];
 var dataLayer = dataLayer || []; 

/*funciton for restricing checkout of user based on state law */
function restrictcheckout()
{
    swal({
       
         title: 'You are not allowed to purchase a product or products in your cart based on your state laws. Please click continue to be in compliance',
        
        type: "warning",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonColor: "#873dc8",
        confirmButtonText: "Continue",
        closeOnConfirm: false,
        showCancelButton: true
    },
    function(isConfirm,tmp)
    {
        if(isConfirm==true)
        {
             $.ajax({
                url:'{{url('/')}}'+'/check_cart/removerestricted_products',            
                data:{
                  checkstat:1,              
                },
                dataType:'json',
                success:function(response)
                { 
                   //  alert(response);
                   if(response==true)
                   {
                      window.location.reload();
                   }else{
                     window.location.reload();
                   } 
                }  
              });
        }//if confirm
    });
}//end restrictcheckout



/* funciton for restrict buyer based on state law */
function restrict_buyerstate_checkout()
{
    swal({
     
         title: 'You are not allowed to buy a product or products in your cart based on your state. Please click continue to be in compliance',
        
        type: "warning",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonColor: "#873dc8",
        confirmButtonText: "Continue",
        closeOnConfirm: false,
        showCancelButton: true
    },
    function(isConfirm,tmp)
    {
        if(isConfirm==true)
        {
             $.ajax({
                url:'{{url('/')}}'+'/check_cart/remove_state_restricted_products',            
                data:{
                  checkstat:1,              
                },
                dataType:'json',
                success:function(response)
                { 
                   //  alert(response);
                   if(response==true)
                   {
                      window.location.reload();
                   }else{
                     window.location.reload();
                   } 
                }  
              });
        }//if confirm
    });
}/*end restrict_state_checkout */





/*restrict buyer based of age verification criteria */    
function restrictcheckoutforage()
{
    swal({
      
         title: 'Your age verification profile is still incomplete, If you want to purchase this product please fill your age verification detail',
        
        type: "warning",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonColor: "#873dc8",
        confirmButtonText: "Continue",
        closeOnConfirm: false,
        showCancelButton: true
    },
    function(isConfirm,tmp)
    {
        if(isConfirm==true)
        {
            window.location.href=SITE_URL+'/buyer/age-verification';
        }
    });
}/*end restrictcheckout */    


/*function for remove product */
function confirm_remove(ref,evt)
{
  var id = $(ref).attr('pid');
  var prodid = $(ref).attr('data-pro-id');
  var quantity = $("#item_qty_"+id).val();
  var url = '{{url('/')}}'+'/my_bag/remove_product_cart/'+btoa(id);
 

    evt.preventDefault();  
    
    swal({
        title: 'Do you really want to remove this item from the cart ?',
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

            $.ajax({
                url: url,
                data: {
                    id: id,
                },
                method: 'GET',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success: function(response) {
                    hideProcessingOverlay();
                    if (response.status == "SUCCESS") {
                        gettrackingproductidinfo(id,quantity); 
                        
                        
                    }else if(response.status=="FAILURE"){ // added new
                        swal('Sorry!',response.description,'warning');  
                        
                    }
                }
            });



        }
    });
}


  
/*function for number key */
  function isNumberKey(evt)
  {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
  }

$('input[name="item_qty"]').keyup(function(e)
{
  if (/\D/g.test(this.value))
  {
    this.value = this.value.replace(/\D/g, '');
  }
}); 
        


 /* FUNCITON FOR UPDATE CART */

$(".updatecart_btn").on('click',function(){
    
    
    var pro_id = $(this).attr("data-pro-id");
    var url = '{{url('/')}}/my_bag/update_qty';
    var product_id = $(this).attr('product_id');
    var qty = $('#item_qty_'+product_id).val();
    
    if(qty==""){
      $("#qtyerr_"+product_id).html('Please enter quantity');
      $("#qtyerr_"+product_id).css('color','red');   
      return false;
    }else if(qty<=0){
         $("#qtyerr_"+product_id).html('Quantity should be greater than 0');
         $("#qtyerr_"+product_id).css('color','red'); 
         return false;  
    }
    else if(qty>1000){
      $("#qtyerr_"+product_id).html('Maximum 1000 items are allowed.');
      $("#qtyerr_"+product_id).css('color','red'); 
      $('.item_qty_'+product_id).focus().val('1')  
      return false;
    }
    else{
        $("#qtyerr_"+product_id).html('');     
    
        
            $.ajax({
                url: url,
                data: {
                    pro_id: pro_id,
                    qty: qty,
                },
                method: 'GET',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success: function(response) {
                    hideProcessingOverlay();
                    if (response.status == "SUCCESS") {

                        location.reload();
                        
                    }else if(response.status=="FAILURE"){ // added new
                        swal('Sorry!',response.description,'warning');  
                        
                    }
                }
            });
        
        }
});     




  /*FUNCTION FOR EMPTY CART */ 
    $('#empty_cart').on('click', function() {

        var url = '{{url('/')}}/my_bag/empty_cart';

        swal({
                title: "Do you really want to remove all the items from cart?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes,do it!",
                closeOnConfirm: false
            },
            function() 
            {
              
                $.ajax({
                    url: url,
                    method: 'GET',

                    success: function(response) {
                        hideProcessingOverlay();
                        if (response.status == "success") {
                            window.location = response.next_url;                                
                        } 
                        else {
                            swal({
                                title: response.status,
                                text: "Please try again",
                                type: response.status,
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            },
                            function(isConfirm, tmp) 
                            {
                                if (isConfirm == true) 
                                {
                                    window.location = response.next_url;
                                }
                            });
                        }
                    }
                })

            });
    }); /* END */

 


/* FUCNTION FOR APPLY COUPON */
  $(".applycoupon").click(function(){
  
    var product_id = $(this).attr('product_id');
    var seller_id = $(this).attr('seller_id');

    var code = $('#code_'+product_id).val();

    var URL = "{{ url('/') }}";

    if(code==""){

      $("#codeerr_"+product_id).html('Please enter coupon code');
      $("#codeerr_"+product_id).css('color','red');   
      return false;
    }
    else
    {
        $("#codeerr_"+product_id).html(''); 

          $.ajax({
                url: URL+'/my_bag/applycouponcode',
                data: {
                    product_id: product_id,
                    code: code,
                    seller_id:seller_id

                },
                method: 'GET',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success: function(response) {
                    hideProcessingOverlay();
                    if (response.status == "SUCCESS") {

                        window.location.reload();
                        
                    }else if(response.status=="FAILURE"){ // added new
                        swal('Sorry!',response.description,'warning');  
                        $("#code_"+product_id).val(''); 
                        
                    }
                }
            });

    }

}); /* END */

/*FUNCTIO FOR CLEAR COUPON CODE */
  function clearCouponCode(seller_id)
  {
    if(seller_id){

         swal({
            title: "Need Confirmation",
            text: "Are you sure? Do you want to remove coupon code.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK",
            closeOnConfirm: false
        },
        function(isConfirm, tmp)
        {

          if (isConfirm == true) 
            {
          
             $.ajax({
                    url: URL+'/my_bag/clearcoupon_code',
                    data: {
                       seller_id:seller_id
                    },
                    method: 'GET',
                    beforeSend: function() {
                        showProcessingOverlay();
                    },
                    success: function(response) 
                    {
                        hideProcessingOverlay();
                            if (response.status == 'error') 
                          {

                              swal({
                                      title: "Error",
                                      text: response.description,
                                      type: response.status,
                                      confirmButtonText: "OK",
                                      closeOnConfirm: false
                                  },
                              function(isConfirm, tmp) 
                              {
                                  if (isConfirm == true) 
                                  {
                                      location.href = SITE_URL+'/my_bag';
                                  }
                              });
                             
                          }

                          if (response.status == 'success') 
                          {
                              swal({ 
                                  title: 'Success',
                                  text: response.description,
                                  type: 'success'
                              },
                                function(){
                                  location.href = SITE_URL+'/my_bag';
                              });
                             
                          }
                    }
                });
           }

       });
    }
}/*end clearcouponcode */


 


  $(document).on('click','#checkout_btn',function(){ 
    
    showProcessingOverlay();
    
    var hidden_product_ids = $("#hidden_product_ids").val();
    var productids = hidden_product_ids.split(",");
    var flag=0;
    for(var i=0;i<productids.length;i++){       
        var product_id = productids[i];
        var item_qty = '#item_qty_'+product_id;
        if($('#item_qty_'+product_id).val().trim()==""){
           var flag=1; 
           break;
          
        }
        else if($('#item_qty_'+product_id).val().trim()=="0"){
           var flag=1; 
           break;
          
        }
        else{
           var flag=0; 
        }
    }

     if(flag=='1'){
         swal('Alert!','Please enter valid quantity');  
      }else{


             _learnq.push(["track", "Started Checkout", {
             "$event_id": {{$time or ''}},
             "$value": {{$fulltotal_amount or ''}},
             "ItemNames": <?php echo json_encode($name); ?>,
             "CheckoutURL": SITE_URL+'/checkout',
             "Categories": <?php echo json_encode($category_array); ?>,
             "Items":  [<?php echo json_encode($klaviyo_arr);?>] 
              }]);
            

              dataLayer.push({
                'event': 'Checkout',
                'ecommerce': {
                  'checkout': {
                    'actionField': {'step': 1},
                    'products': <?php echo json_encode($product_array_googleapi1);?>
                 }
               },
               'eventCallback': function() {
                  document.location = SITE_URL+'/checkout';
               }
              });

        window.location.href=SITE_URL+'/checkout';
      }  
    return false;
});



/* FUNCITON FOR KLAVIYO TRACKING */
  function gettrackingproductidinfo(productid,quantity)
  {
     
    if(productid)
    {
       var csrf_token = "{{ csrf_token()}}";
         $.ajax({
                url:SITE_URL+'/gettrackingproduct',
                method:'GET',
                data:{productid:productid,quantity:quantity},
                beforeSend: function() {
                    showProcessingOverlay();
                },
     
                success:function(response)
                {
                   hideProcessingOverlay();

                      dataLayer.push({
                        'event': 'removeFromCart',
                        'ecommerce': {
                          'remove': {                               
                            'products': [{                          
                                'name': response.AddedItemProductName,
                                'id': response.AddedItemProductID,
                                'price':  response.Price,
                                'brand': response.Brand,
                                'category': response.AddedItemCategory,
                                'quantity': quantity
                            }]
                          }
                        }
                      });

                      window.location.reload();


                }
            });
    }
    
}/*end function */


/* FUNCITON FOR GOOGE TAG MANAGER CLICK */

function productclick(productObj) {

  var dataLayer = dataLayer || []; 

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
          'position': productObj.position
         }]
       }
     },
     'eventCallback': function() {
       document.location = productObj.url
     }
  });
}/* END */


/* FUNCITON FOR APPLY DEVLEIRY OPTION */
  function delivery_options_click(ref) {

    var URL     = "{{ url('/') }}";
    var _token  = "{{csrf_token()}}";

    var amount              = $(ref).attr('amount');
    var seller_id           = $(ref).attr('seller_id');
    var delivery_option_id  = $(ref).attr('id');

    $.ajax({
      url: URL+'/my_bag/apply_delivery_option',
      data: {
          _token:_token,
          amount:amount,
          seller_id:seller_id,
          delivery_option_id:delivery_option_id
      },
      method: 'POST',
      beforeSend: function() {

        /*showProcessingOverlay(); */
      },
      success: function(response) {

        hideProcessingOverlay();

        if (response.status == "SUCCESS") {

          window.location.reload();
            
        }else if(response.status=="FAILURE"){ 

          swal('Sorry!',response.description,'warning');  
        }
      }
    });
  }/* END */


/*FUNCTION FOR CLEAR DELIVERY OPTION */
  function clear_radio_button(ref) {

    var key           = $(ref).attr('key');
    var seller_id     = $(ref).attr('seller_id');
    var URL           = "{{ url('/') }}";
    var _token        = "{{csrf_token()}}";

    $.ajax({
      url: URL+'/my_bag/clear_delivery_option',
      data: {
          _token:_token,
          seller_id:seller_id
      },
      method: 'POST',
      beforeSend: function() {

        /*showProcessingOverlay(); */
      },
      success: function(response) {

        hideProcessingOverlay();

        if (response.status == "SUCCESS") {

          $("#"+key).attr('checked', false);

          window.location.reload();
            
        }else if(response.status=="FAILURE"){ 

          swal('Sorry!',response.description,'warning');  
        }
      }
    });
}
</script>
@endsection


<!----------COMMENTED CODE STARTS HERE-------------------->


   {{-- @if(isset($product_arr['seller_details']['seller_detail']['delivery_options']) && sizeof($product_arr['seller_details']['seller_detail']['delivery_options']) > 0)
    @if($product_arr_key == 1)

      <div class="prime-delivery-option-div">
        <div class="choose-prime-div">Choose your delivery option:</div>
          <div class="radio-btns">
            @foreach($product_arr['seller_details']['seller_detail']['delivery_options'] as $delivery_options_key => $delivery_options )
                <div class="radio-btn">
                    @php
                        $day = date('l jS \, F Y', strtotime('now + '.$delivery_options['day'].'day'));
                    @endphp

                    @if(isset($sessiondeliveryoption_data) && sizeof($sessiondeliveryoption_data) > 0)

                        <input type="radio" id="{{$delivery_options['id']}}"
                        @foreach($sessiondeliveryoption_data as $key => $deliveryOption_data)
                            @if($deliveryOption_data['delivery_option_id'] == $delivery_options['id'] )
                                checked="true"
                            @endif
                        @endforeach
                        seller_id="{{$product_arr['seller_details']['id']}}"  onclick="delivery_options_click(this);" value="{{$delivery_options['id']}}" amount="{{$delivery_options['cost']}}" delivery_option_id="{{$delivery_options['id']}}"   name="selector_{{$delivery_options['id']}}">
                        
                        <label for="{{$delivery_options['id']}}"> {{$day}}
                            @foreach($sessiondeliveryoption_data as $key => $deliveryOption_data)
                                @if($deliveryOption_data['delivery_option_id'] == $delivery_options['id'] )
                                 <a href="javascript:void(0)" class="clearbutton-a" key="{{$delivery_options['id']}}" seller_id="{{$product_arr['seller_details']['id']}}"   onclick="clear_radio_button(this)"  >Clear</a>
                                @endif
                            @endforeach
                        </label>

                        <div class="check"><div class="inside"></div></div>
                        <div class="free-text-p-semi">{{$delivery_options['title']}}</div>
                    @else

                    <input type="radio" id="{{$delivery_options['id']}}" seller_id="{{$product_arr['seller_details']['id']}}"  onclick="delivery_options_click(this);" value="{{$delivery_options['id']}}" amount="{{$delivery_options['cost']}}" delivery_option_id="{{$delivery_options['id']}}"   name="selector">
                    <label for="{{$delivery_options['id']}}"> {{$day}} </label> 
                    <div class="check"><div class="inside"></div></div>
                    <div class="free-text-p-semi">{{$delivery_options['title']}}</div>

                    @endif
                </div>
            @endforeach
          </div>
      </div>
    @endif
  @endif --}}



    {{-- @if(isset($product['product_age_detail']['age']))
        <div class="age-img-plus small-size-age">

          @php  

              if(isset($product['product_age_detail']['age']))
               $age_restrict = $product['product_age_detail']['age'];
             else
               $age_restrict = '';
           @endphp

           @if($age_restrict=="18+")
            <div class="age-img-inline" title="18+ Age restriction">
              <img src="{{url('/')}}/assets/front/images/product-age-mini.png" alt="18+ Age restriction"> 
            </div>
            @endif

            @if($age_restrict=="21+")
              <div class="age-img-inline" title="21+ Age restriction">
                <img src="{{url('/')}}/assets/front/images/product-age-max.png" alt="21+ Age restriction"> 
              </div>
            @endif

       </div>
      @endif --}}
               


 {{-- @if(in_array($product['user_id'],$checkcouponcodeforseller) && $j==1)
<div class="apply-coupon-div">

@if(isset($sessioncoupon_data[$keys]))


<input type="text" placeholder="Enter coupon Code" name="code" class="form-control" readonly="" value="{{ $sessioncoupon_data[$keys]['couponcode'] or ''}}"   product_id="{{ $product['product_id'] }}" seller_id="{{ $product['user_id'] }}"/>

    <a href="#" class="btn" id="apply_code_{{ $product['product_id'] }}" name="apply_code"  product_id="{{ $product['product_id'] }}" seller_id="{{ $product['user_id'] }}" onclick="clearCouponCode({{$keys}});"><i class="fa fa-times"> </i> Clear</a>

@else

@if(isset($login_user) && $login_user==true)
  <input type="text" class="form-control"  name="code" id="code_{{ $product['product_id'] }}" placeholder="Enter coupon code" data-pro-id="{{base64_encode($product['product_id'])}}"  product_id="{{ $product['product_id'] }}" seller_id="{{ $product['user_id'] }}">                                   
 <a href="#" class="btn applycoupon" id="apply_code_{{ $product['product_id'] }}" name="apply_code"  product_id="{{ $product['product_id'] }}" seller_id="{{ $product['user_id'] }}">Apply</a>
@endif
@endif   
<span class="errorcoupn" id="codeerr_{{$product['product_id']}}"></span>
</div>

@else                            
@endif --}}              


  {{-- <a href="{{url('/')}}/search/product_detail/{{isset($product['product_id'])?base64_encode($product['product_id']):''}}/{{ $product_title_slug }}/{{ $mybag_brandname }}/{{ $mybag_sellername }}"  title="{{isset($product['product_name'])?$product['product_name']:''}}" onclick="return productclick({{ isset($pageclick)?json_encode($pageclick):''}})"> --}}

 {{--  <span class="titlebrandname">
  {{isset($product['product_brand_detail']['name'])?$product['product_brand_detail']['name']:""}} 
  </span>
  <span class="spectrum-name-text">
    @if(isset($product['spectrum']))
      {{-- @if($product['spectrum']=="0")
       <span class="line-vertical"></span><span class="space-spetm">Full Spectrum </span>
      @elseif($product['spectrum']=="1") 
       <span class="lvertical"></span><span class="space-spetm">Broad Spectrum </span>
      @elseif($product['spectrum']=="2") 
       <span class="line-vertical"></span><span class="space-spetm">Isolate  </span>
       @endif        --}}    

       {{-- @php 
        $get_spectrum_val = get_spectrum_val($product['spectrum']);
       @endphp   
       <span class="space-spetm">
        {{ isset($get_spectrum_val['name'])?$get_spectrum_val['name']:'' }} 
       </span>   
    
  <span class="cbdclass">CBD </span>
   <span class="titlename-list">                                
    {{ $prod_name }}
   </span>  --}}                           



      {{--  @if(isset($is_besesellersimilar) && $is_besesellersimilar!="" && $is_besesellersimilar==1)
      <div class="home_bestseller chow_choice-orange font-small circle-font-small" >
         <span class="b-class-hide">Best Seller</span>
      </div>
    @endif --}}


      <!-- <div class="get-free-shipping-main">
                        <div class="get-free-shipping-main-left">
                            <img src="images/gift-shipping-img.jpg" alt="" />
                        </div>
                        <div class="get-free-shipping-main-right">
                            <div class="get-shipping-tlt">Get <span>Free</span> Shipping!</div>
                           <div class="shippingorder">Free shipping on every order over $42.00.</div>
                           <div class="check-get-ship">
                               <img src="images/arrow-check-shipping.png" alt="" />
                           </div>
                        </div>
                        <div class="clearfix"></div>
                    </div> -->  

   {{--  @if($buyeragestatus_flag>0)
                            <a href="#" class="butn-def" onclick="restrictcheckoutforage()">Checkout</a>  
                           @elseif($check_flag>0)
                            <a href="#" class="butn-def" onclick="restrictcheckout()">Checkout</a>   
                          @else
                            <a href="#" class="butn-def" id="checkout_btn">Checkout</a>
                          @endif --}}                  


   <!-----------truck---------------->
    {{-- @if(isset($product['shipping_type']) && $product['shipping_type']==0)
     @php 
          $setshippingsimilar = "";
          if($product['shipping_type']==0)
          { $setshippingsimilar = "Free Shipping";
          }
          else{
            $setshippingsimilar = "Flat Shipping";
          }
     @endphp
     <div class="truck-icons" title="{{ $setshippingsimilar }}">
      <div class="freedrusd">Free Shipping </div> <img src="{{url('/')}}/assets/front/images/truck-icon.png" alt="Free Shipping">
    </div>
    @endif --}}
  <!----------truck----------------->                       

 <!-- Lab results available Start -->
   <!--  @if(isset($product['product_certificate']) && !empty($product['product_certificate']) && file_exists(base_path().'/uploads/product_images/'.$product['product_certificate']) )
      <div class="labresults-class" style="margin-left: 0px">
       <span class="b-class-hide">Lab Results Available</span>
      </div>                                   
    @endif   -->
 <!-- Lab results available End -->  



 <!--  @php 
                   
    $setproids = '';
    if(isset($checkcouponproduct) && !empty($checkcouponproduct))
    {
      $setproids = implode(",",$checkcouponproduct);
    }
@endphp
 <div class="apply-coupon-div col-md-4" >

    <input type="text" class="form-control"  name="code" id="code" placeholder="Please enter coupon code" >

    <a href="javascript:void(0)" class="btn" id="apply_code" name="apply_code" productids="{{ $setproids}}">Apply</a> <br>
     <span id="codeerr"></span>
</div> -->

