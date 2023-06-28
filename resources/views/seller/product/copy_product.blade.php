@extends('seller.layout.master')
@section('main_content')


<style type="text/css">
 
  .error-whitspace{
    display: block; white-space: nowrap; font-size: 14px;
  }

 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
  hr {
  border: 0;
  clear:both;
  display:block;
  width: 96%;               
  background-color:#717171;
  height: 1px;
}
.err{
    color: #e00000;
    font-size: 13px;
}
.readonly_div{ background-color: #eee;}
</style>
 <script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script>

 <div class="my-profile-pgnm">
  Duplicate Product
   <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/seller/product"> Products</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>{{ $page_title or '' }} </li>
    </ul>
</div>
<div class="new-wrapper">

  @php
    $remainingstock = 0;
    if(isset($product_inventory) && !empty($product_inventory))
    {
      $remainingstock = $product_inventory['remaining_stock'];
    } 
  @endphp

 
 
<div class="main-my-profile">
   <div class="innermain-my-profile add-product-inrs space-o">
    <form id="validation-form" onsubmit="return false">
        {{ csrf_field() }}
   <div class="profile-img-block">
       {{--  <div class="pro-img"> 
          @if(isset($arr_product['product_image']) && $arr_product['product_image']!="")
          <img src="{{url('/')}}/uploads/product_images/{{ $arr_product['product_image'] }}" class="img-responsive img-preview" alt=""/>
          @else
           <img src="{{url('/')}}/assets/images/default-product-image.png" class="img-responsive img-preview" alt=""/>
          @endif

        </div>        --}}                      
     {{--    <div class="update-pic-btns">
            <button class="up-btn"> <span><i class="fa fa-camera"></i></span></button>
            <input style="height: 100%; width: 100%; z-index: 99;" id="logo-id" name="product_image"  type="file" class="attachment_upload" >
           <input type="hidden" name="old_product_image" id="old_product_image" value="{{ $arr_product['product_image'] }}">
           
        </div> 
        <div class="upload-product-img">Upload Product Image</div>   --}}  

        <!-- <input type="hidden" name="id" id="id" value="{{ $arr_product['id'] }}"> -->
       {{--  <input type="hidden" name="old_product_stock" id="old_product_stock" value="{{ $arr_product['product_stock'] }}"> --}}
        <input type="hidden" name="old_product_stock" id="old_product_stock" value="{{ $remainingstock }}">

         <input type="hidden" name="old_price_drop" id="old_price_drop" value="{{ $arr_product['price_drop_to'] }}">

       <input type="hidden" name="old_img" id="old_img" value="{{ isset($arr_product_image[0]['image'])? $arr_product_image[0]['image']:''}}">

          <input type="hidden" name="old_product_certificate" id="old_product_certificate" value="{{isset($arr_product['product_certificate'])?$arr_product['product_certificate']:''}}">
          
          <input type="hidden" name="duplicate" id="duplicate" value="1">

    </div> 
       <div class="row">
        {{--   <h4> <span id="showerr"></span> </h4> --}}

              <div class="col-md-12">
                  <div class="form-group">
                    <label for="product_name">Product Name <span>*</span></label>
                    <input type="text" name="product_name" id="product_name" class="input-text" placeholder="'Brand name' 'spectrum' 'CBD' 'product category' 'product flavor (if any)' 'product milligrams'" data-parsley-required ='true' data-parsley-required-message="Please enter product name " value="{{ $arr_product['product_name'] }}" >
                     <ul class="parsley-errors-list filled" id="parsley-id-5">
                    <li  class="parsley-required" id="product_name_error"> </li>
                  </ul>
                  </div>
              </div>

               <div class="col-md-12">
                  <div class="form-group">
                    <label for="sku"> SKU <span></span></label>
                    <input type="text" name="sku" id="sku" class="input-text" placeholder="Enter Sku" data-parsley-required-message="Please enter sku " value="{{ $arr_product['sku'] }}" >
                     <ul class="parsley-errors-list filled">
                    <li  class="parsley-required" id="sku_error"> </li>
                  </ul>
                  </div>
              </div>


             <div class="col-md-12">
                 <div class="form-group">
                    <label for="brand">Brand <span>*</span></label>
                    <input type="text" name="brand" id="brand" class="input-text" placeholder="Enter Brand Name"  value="{{ isset($brandname['name'])?$brandname['name']:'' }}" autocomplete="off" data-parsley-required ='true' data-parsley-required-message="Please enter brand name">
                    <div id="brandList">
                     </div>
                </div>
            </div>

            
              <!-- <input type="hidden" name="id" id="id" value="{{ $arr_product['id'] or '' }}" /> -->
              <input type="hidden" name="old_product_image" value="{{isset($arr_product['product_image'])?$arr_product['product_image']:''}}">

              <input type="hidden" name="old_product_stock" value="{{ $remainingstock }}">
                                      
           <div class="col-md-6">
                 <div class="form-group">
                    <label for="first_level_category_id">Category <span>*</span></label>
                    <div class="select-style">
                        <select class="frm-select" name="first_level_category_id" id="first_level_category_id" onchange="return get_second_level_category()" data-parsley-required ='true' data-parsley-required-message="Please select category">
                            <option value="">Select Category</option>
                            @foreach($arr_category as $category)
                            <option value="{{ $category['id'] or ''}}" @if($arr_product['first_level_category_id']==$category['id']) selected @endif>{{ $category['product_type'] or '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="second_level_category_id">Sub Category <span>*</span></label>
                    <div class="select-style">

                        <select class="frm-select" name="second_level_category_id" id="second_level_category_id" data-parsley-required ='true' data-parsley-required-message="Please select sub-category">
                            <option value="">Select Subcategory</option> 

                              @foreach($arr_secondcategory as $cat)
                                <option value="{{ $cat['id'] or ''}}" 
                                @if($arr_product['second_level_category_id']==$cat['id']) selected @endif>{{ $cat['name'] or '' }}</option>
                             @endforeach 
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="unit_price">Price ($)<span>*</span></label>
                <input type="text" name="unit_price" id="unit_price" class="input-text" placeholder="Enter Product Price" data-parsley-required="true" data-parsley-required-message="Please enter price" data-parsley-type="number"                    data-parsley-maxlength="10" data-parsley-min="1" value="{{ num_format($arr_product['unit_price'],2) }}">
              </div>
            </div>

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="price_drop_to">Price Drop to ($)</label>
                    <input type="text" name="price_drop_to" id="price_drop_to" class="input-text" placeholder="Product Drop Price" oninput="check_price_drop()" data-parsley-pattern="^[0-9.]+$"
                      data-parsley-maxlength="10"  value="{{ number_format($arr_product['price_drop_to'],2) }}" >
                    <span class="price-pdct-fnts">(Please fill this field only if you want to drop the price of product)</span><br>
                    
                    <span id="price_drop_error"></span>
                </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="" for= "shipping_type"> Shipping Type <span class="red">*</span></label>                   
                  <div class="radio-btns radiobuttoninline">
                    <div class="radio-btn">                                  
                      <input type="radio" name="shipping_type" class="shipping_type" id="shipping_type" data-parsley-required="true" value="0" data-parsley-errors-container=".shipping_type_err" data-parsley-required-message="Please select any one shipping type" onchange="$('#shipping_charges_block').hide(); $('#shipping_charges').removeAttr('data-parsley-required').removeAttr('data-parsley-min');" @if($arr_product['shipping_type']==0) checked @endif>
                      <label for="shipping_type">Free Shipping</label> 
                      <div class="check"></div>
                    </div>
                    <div class="radio-btn">
                      <input type="radio" name="shipping_type" class="shipping_type" id="shipping_type1" data-parsley-required="true" value="1" data-parsley-errors-container=".shipping_type_err" data-parsley-required-message="Please select any one shipping type" onchange="$('#shipping_charges_block').show(); $('#shipping_charges').attr('data-parsley-required',true).attr('data-parsley-min','1');" @if($arr_product['shipping_type']==1) checked @endif> 
                      <label for="shipping_type1">Flat Shipping</label>
                      <div class="check"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="shipping_type_err"></div>
                  </div>                                                    
                <span>{{ $errors->first('shipping_type') }}</span>
              </div> 
            </div>

            <div class="col-md-6" id="shipping_charges_block" @if($arr_product['shipping_type']=='1') style="display: block" @elseif($arr_product['shipping_type']=='0') style="display: none" @endif>
              <div class="form-group" >
                <label class="" for="shipping_charges">Shipping Charges  ($) <span >*</span></label>
                <input type="text" name="shipping_charges" id="shipping_charges" class="input-text" placeholder="Enter shipping charges" data-parsley-maxlength="10" data-parsley-type="number"  data-parsley-required-message ="Please enter shipping charges"     value="{{ number_format($arr_product['shipping_charges'],2) }}" @if($arr_product['shipping_type']==1) data-parsley-required="true" 
                data-parsley-min="1" 
                @endif 

                 oninput="if(parseFloat($(this).val()) >= parseFloat($('#unit_price').val())){ $(this).val(''); $('#shipping_charges_err').html('Shipping charges should not be greater than unit price').css('color','red');}else{ $('#shipping_charges_err').html(''); }" 

                >
                <span id="shipping_charges_err">{{ $errors->first('shipping_charges') }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="shipping_duration">Shipping Duration (Days)<span>*</span></label>
                <input type="number" name="shipping_duration" id="shipping_duration" class="input-text decimal" placeholder="Enter Shipping Duration " data-parsley-required ='true'  data-parsley-type="number" data-parsley-min="0.5" data-parsley-max="31" step="0.5" data-parsley-required-message ='Please enter shipping duration' data-parsley-min-message="Shipping duration should be greater than 0." data-parsley-max-message="Shipping duration should be less than or equal to 31 days." data-parsley-type-message="Please enter valid shipping duration." value="{{isset($arr_product['shipping_duration'])?number_format($arr_product['shipping_duration'],1):'' }}">
              </div>
            </div>
          
            
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="product_stock"> Quantity <span>*</span>
                         {{-- <span class="remain-stock" style="color:#873dc8">
                            ( Remaining Stock :   
                                 @php 
                                 if(isset($remainingstock) && $remainingstock>0){
                                 @endphp                                   
                                   {{ $remainingstock }}
                                 @php 
                                    }else{ echo '0'; }
                                 @endphp
                            )
                         </span>  --}}


                    </label>
                   {{--  <input type="number" name="product_stock" id="product_stock" class="input-text decimal" placeholder="Enter Total Quantity Available" data-parsley-required ='true' data-parsley-required-message="Please enter available quantity" data-parsley-min="1" value="{{ $arr_product['product_stock'] }}" min="1"> --}}

                    <input type="number" name="product_stock" id="product_stock" class="input-text decimal" placeholder="Enter Total Quantity Available" data-parsley-required ='true' data-parsley-required-message="Please enter available quantity" data-parsley-min="1" value="{{ $remainingstock }}" min="1">

                </div>
            </div> 
            <div class="col-md-6" id="concentration_div" @if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories" )|| (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")) style="display: none" @else style="display: block" @endif>
                 <div class="form-group" >
                    <label for="per_product_quantity">Concentration (mg)<span>*</span></label>
                    <input type="number" name="per_product_quantity" id="per_product_quantity" class="input-text decimal" placeholder="Enter Concentration(mg)" 
                    @if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories")|| (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")) @else data-parsley-min="1" @endif
                    {{-- data-parsley-max="5000" --}}
                     value="{{ $arr_product['per_product_quantity'] }}"
                      @if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories")|| (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")) @else data-parsley-required ='true' @endif
                      data-parsley-required-message="P|| (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")lease enter concentration" data-parsley-min-message="This value should be greater than or equal to 1">
                </div> 
            </div>

            
             @php 
             $spectrumarr = get_spectrums();
             $cannabinoids_arr = get_cannabinoids_more();
             @endphp

             <div class="col-md-6">
                 <div class="form-group">
                    <label for="spectrum">Spectrum Type <i class="red">*</i> </label>
                    <div class="select-style">
                        <select class="frm-select" name="spectrum" id="spectrum" data-parsley-required="true" data-parsley-required-message="Please select Spectrum Type" onchange="return hidecoaforspectrum(this.value)">
                            <option value="">Select Spectrum</option>                         
                             @if(isset($spectrumarr) && !empty($spectrumarr))                         
                               @foreach($spectrumarr as $spectrum)
                                <option value="{{ $spectrum['id'] }}" @if($arr_product['spectrum']==$spectrum['id']) selected @endif>{{ $spectrum['name'] }}</option>
                              @endforeach
                             @endif
                             
                        </select>
                    </div>
                </div>
            </div>




            @php 
            $row_cnt = 1;
            @endphp

            @if(isset($product_cannabinoid) && count($product_cannabinoid) > 0)
            <div class="col-md-12" id="div_for_cannabinoids" @if(!isset($product_cannabinoid)) style="display:none" @endif>
                <div class="form-group errorproduct-cannabinoid" id="div_append_cannabinoids">
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">Cannabinoids</div></div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">%</div></div>

                    @if(isset($product_cannabinoid) && count($product_cannabinoid) > 0)
                    @foreach($product_cannabinoid as $key => $productCannabinoid)
                    <div class="" style="padding:10px;border: 1px solid #d1d1d1;" id="row_cannabinoids{{$row_cnt}}">
                        <div class="col-xs-5 col-sm-6 col-md-6 col-lg-6 " >
                              <div class="select-style">
                                <select name="sel_cannabinoids[]" id="sel_cannabinoids{{$row_cnt}}" class="form-control  sel_cannabinoids frm-select" data-parsley-required ='true' data-parsley-required-message="Please select cannabinoids" onchange="check_duplicate_cannabinoids(this.id,this.value,{{$row_cnt}})">
                                <option value="">Select cannabinoids</option>                                
                                @if(isset($cannabinoids_arr) && !empty($cannabinoids_arr))
                                  @foreach($cannabinoids_arr as $cannabinoids)
                                      <option value="{{ $cannabinoids['id'] }}" @if($productCannabinoid['cannabinoids_id'] == $cannabinoids['id']) selected="selected" @endif>{{ $cannabinoids['name'] }}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>
                              <span style="color:red;" id="err_sel_cannabinoids_{{$row_cnt}}"></span>
                              <input type="hidden" name="hid_product_can_id[]" value="{{ $productCannabinoid['id'] }}">
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <input type="text" name="txt_percent[]" id="txt_percent{{$row_cnt}}" class="form-control txt_percent" placeholder="%" value="{{$productCannabinoid['percent']}}" data-parsley-trigger="keyup"  data-parsley-required ='true'  {{--  data-parsley-type="digits" --}} data-parsley-pattern="[0-9]*(.?[0-9]{1,3}$)"   min="0" max="100" data-parsley-required-message="Please enter percent" >
                              <span style="color:red;" id="err_txt_percent_{{$row_cnt}}"></span>
                        </div>

                        @php
                        $cnt_rows = count($product_cannabinoid) - 1;
                        @endphp
                       {{--  @if($cnt_rows == $key) --}}
                        @if($key == 0)
                         <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                          <img src="{{url('/')}}/assets/images/plus-icon - Copy.png" alt="Add New Cannabinoids" onclick="add_new_row({{$row_cnt}})" style="height: 20px;width: 21px;" />
                        </div>

                        @else 
                         <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                          <img src="{{url('/')}}/assets/images/popup-close-btn.png" alt="Delete Cannabinoid" onclick="remove_row({{$row_cnt}},{{$productCannabinoid['id']}},{{ $arr_product['id']}},this)" />
                        </div>
                        @endif
                         <div class="clearfix"></div>
                    </div>
                    @php 
                    $row_cnt++;
                    @endphp
                    @endforeach
                    @endif
                    <div class="clearfix"></div>
              </div>
            <div class="col-md-4">
            </div>
            </div>


            @else

            <div class="col-md-12" id="div_for_cannabinoids" @if($arr_product['spectrum']=="1" || $arr_product['spectrum']=="2m" || $arr_product['spectrum']=="3") style="display: block" @else 
            style="display:none" @endif >

            <div class="form-group errorproduct-cannabinoid" id="div_append_cannabinoids">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">Cannabinoids</div></div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">%</div></div>
            <div class="" style="padding:10px;border: 1px solid #d1d1d1;" id="row_cannabinoids{{$row_cnt}}">




                <div class="col-xs-5 col-sm-6 col-md-6 col-lg-6">

                    <div class="select-style">
                      <select name="sel_cannabinoids[]" id="sel_cannabinoids{{$row_cnt}}" class="form-control sel_cannabinoids"  data-parsley-required-message="Please select cannabinoids" data-parsley-trigger="change" onchange="check_duplicate_cannabinoids(this.id,this.value,{{$row_cnt}})">
                      <option value="">Select cannabinoids</option>                                
                      @if(isset($cannabinoids_arr) && !empty($cannabinoids_arr))
                        @foreach($cannabinoids_arr as $cannabinoids)
                            <option value="{{ $cannabinoids['id'] }}" >{{ $cannabinoids['name'] }}</option>
                      @endforeach
                      @endif
                      </select>
                    </div>
                      <span style="color:red;" class="err_sel_cannabinoids" id="err_sel_cannabinoids_{{$row_cnt}}"></span>
                      <input type="hidden" name="hid_product_can_id[]" value="">
                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <input type="text" name="txt_percent[]" id="txt_percent{{$row_cnt}}" class="form-control txt_percent" placeholder="%" value="" data-parsley-trigger="keyup"    {{--  data-parsley-type="digits" --}} data-parsley-pattern="[0-9]*(.?[0-9]{1,3}$)"   min="0" max="100" data-parsley-required-message="Please enter percent">
                      <span style="color:red;" class="err_txt_percent" id="err_txt_percent_{{$row_cnt}}"></span>

                </div>

                 <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                  <img src="{{url('/')}}/assets/images/popup-close-btn.png" alt="Delete Cannabinoid" onclick="remove_row({{$row_cnt}},'',{{ $arr_product['id']}},this)" id="delete_row_{{$row_cnt}}" style="display: none" />
                </div>
                 <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                  <img src="{{url('/')}}/assets/images/plus-icon - Copy.png" alt="Add New Cannabinoids" onclick="add_new_row({{$row_cnt}})" style="height: 20px;width: 21px;" id="add_row_{{$row_cnt}}"  />
                </div>
                 <div class="clearfix"></div>
            </div>







            </div>
            <div class="col-md-4">
            </div>
            </div>

            @endif















                       

            <div class="col-md-12">
                 <div class="form-group">
                    <label for="description">Product Description <span>*</span></label> 
                    <textarea name="description" id="description" placeholder="Enter Product Description" data-parsley-required ='true' data-parsley-required-message="Please enter product description">{{ strip_tags($arr_product['description']) }}</textarea>
                    {{-- <script>
                        CKEDITOR.replace( 'description' );
                    </script> --}}
                </div>
            </div> 


             <!-- Added 3 fields --> 

            <div class="col-md-12">
                 <div class="form-group">
                    <label for="ingredients">Ingredients</label> 
                   <textarea name="ingredients" id="ingredients" class="form-control" placeholder="Enter ingredients" {{-- data-parsley-required="true" --}} data-parsley-required-message="Please enter Ingredients"> {{ $arr_product['ingredients'] }}</textarea>                     
                </div>               
            </div> 


             <div class="col-md-12">
                 <div class="form-group">
                    <label for="ingredients">Suggested Use</label> 
                   <textarea name="suggested_use" id="suggested_use" class="form-control" placeholder="Enter suggested use" {{-- data-parsley-required="true" --}} data-parsley-required-message="Please enter suggested use"> {{ $arr_product['suggested_use'] }}</textarea>                   
                </div>               
            </div> 


             <div class="col-md-12">
                 <div class="form-group">
                    <label for="ingredients">Amount per serving</label> 
                   <textarea name="amount_per_serving" id="amount_per_serving" class="form-control" placeholder="Enter amount per serving" {{-- data-parsley-required="true"  --}}data-parsley-required-message="Please enter amount per serving"> {{ $arr_product['amount_per_serving'] }}</textarea>                   
                </div>               
            </div> 


            <div class="col-md-12">
                <div class="form-group">
                  <label for="terpenes">Terpenes</label> 
                  <textarea name="terpenes" id="terpenes" class="form-control" placeholder="Enter terpenes"  >{{ $arr_product['terpenes'] }}</textarea>
                </div> 
            </div>



             <div class="col-md-12">
               <div  id="dynamic_field" class="form-group">
                  <label for="image">Product Image (Image must have a white background)<span>*</span></label>
                  <div class="clone-divs edt-chow-view">

                    <input type="file" name="product_image" id="product_image">
                   {{--  <a href="javascript:void(0)" class="btn-clone" name="add_more" id="add_more"><i class="fa fa-plus"></i></a> --}}
                  </div>
                  <div id="product_image_preview"></div>
                   <span id="showerr"></span> 
                 <!----------------------------code for showing multiple images-------------> 
                    @if(!empty($arr_product_image) && count($arr_product_image)>0)
                    @foreach($arr_product_image as $img)
                      <div class="clone-divs">
                        
                        @if($img['image']!="")
                        <img src="{{$product_public_img_path}}{{$img['image'] or ''}}" width="50" height="50" alt="Product Image"/>
                        @endif
                      </div>
                    @endforeach
                   @endif
                 <!-----------------------------------------------------------------------> 
                </div>
             </div>

              <input type="hidden" name="is_certificate_exists" id="is_certificate_exists" value="{{ isset($is_certificate_exists)?$is_certificate_exists:'' }}">

               <div class="col-md-12" id="coa_div" @if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories") || (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")) style="display: none" @else style="display: block" @endif>
               <div  id="dynamic_field" class="form-group">
                  <label for="image">Certificate Of Analysis <span>*</span></label>
                  <div class="clone-divs edt-chow-view">
                    <input type="file" name="product_certificate" id="product_certificate" 
                    @if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories") && (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")) 
                     @else 
                        @if(file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate']) && isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate']))
                        @else
                         data-parsley-required="true"
                        @endif

                     @endif>
                  </div>
                  <div id="product_certificate_preview"></div>
                   <span id="product_certificate_error"></span> 
                    @php

                        $ext = pathinfo($arr_product['product_certificate'], PATHINFO_EXTENSION);
                        if($ext=="pdf"){  @endphp

                         <a href="{{ url('/') }}/uploads/product_images/{{$arr_product['product_certificate']}}" target="_blank">
                                View certificate
                         </a>

                        @php   
                         }else{

                            if(file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate']) && isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate'])){
                          @endphp
                          <img src="{{$product_public_img_path}}{{$arr_product['product_certificate'] or ''}}" width="50" height="50" alt="Product Certificate"/>
                            @php 
                              }

                        }//else of image      
                      @endphp
                  
                </div>
             </div>



              <div class="col-md-12" id="coa_link_div"  @if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories") || (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")) style="display: none" @else style="display: block" @endif>
                 <div class="form-group">
                    <label for="coa_link">COA Link<span>* </span></label>
                    <div class="select-style">
                        <input class="input-text" data-parsley-type="url" name="coa_link" id="coa_link" placeholder="Enter COA Link" data-parsley-required-message="Please enter the coa link"  value="{{$arr_product['coa_link'] or ''}}"
                         @if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories") && (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")) 
                        @else  data-parsley-required="true" 
                        @endif>
                    </div>                   
                </div>
            </div> 



            <!-----------start-product-dimension------------------------------->  
            {{-- <hr>
            <div class="col-md-12">
                <div class="form-group">
                   <label for="product_dimension">Product Dimensions</label>
                </div>
            </div>

            @if(sizeof($product_dimensions)==0)
               <div class="product_dimension_div">
                <div  id="row1">
                  <div class="col-md-5">
                      <div class="form-group">
                         <label for="second_level_category_id">Product Dimension Type </label>
                         <input type="text" name="product_dimension[]" id="product_dimension_1" class="input-text" placeholder="Enter Product Dimension Type" onkeyup="clear_err_div_dim(1)">
                        <span id="err_product_dimension_1" class="err"></span>

                      </div>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group">
                         <label for="second_level_category_id">Product Dimension </label>
                         <input type="text" id="product_dimension_value_1" name="product_dimension_value[]" class="input-text product_dimension_value" placeholder="Enter Product Dimension" onkeyup="clear_err_dim_val(1)">
                        <span id="err_product_dimension_value_1" class="err"></span>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group" style="margin-top:30px;">
                  <a href="javascript:void(0)" class="editMore" name="add_more_product_dimension" id="add_more_product_dimension_1"><i class="fa fa-plus"></i></a>
                     </div>
                  </div>  
              </div> 
            </div>
           @endif         
           @if(isset($product_dimensions) && sizeof($product_dimensions)>0)
            @php $i=1; @endphp
            @foreach($product_dimensions as $product_dimension)
            <div id="row{{$i}}">
            <div class="col-md-5">
                <div class="form-group">
                   <label for="product_dimension">Product Dimension Type </label>
                   <input type="text" name="product_dimension[]" id="product_dimension_{{$i}}" class="input-text" value="{{isset($product_dimension['option_type'])?$product_dimension['option_type']:''}}" onkeyup="clear_err_div_dim({{$i}})">
                   <span id="err_product_dimension_{{$i}}" class="err"></span>
                </div>
            </div>
          
            <div class="col-md-5">
                <div class="form-group">
                   <label for="second_level_category_id">Product Dimensions </label>
                   <input type="text" name="product_dimension_value[]" id="product_dimension_value_{{$i}}"  class="input-text product_dimension_value" value="{{isset($product_dimension['option'])?$product_dimension['option']:''}}"  onkeyup="clear_err_dim_val({{$i}})">
                    <span id="err_product_dimension_value_{{$i}}" class="err"></span>
                </div>
            </div>

              @if($i==1)
              <div class="col-md-2">
                   <div class="form-group" style="margin:top:30px;">
                      <a href="javascript:void(0)" class="editMore" name="edit_more_product_dimension" id="edit_more_product_dimension_{{$i}}"><i class="fa fa-plus"></i></a>
                   </div>
              </div>  
              @else
              <div class="col-md-2">
                <div class="form-group" style="margin:top:30px;">
                  <a href="javascript:void(0)" class="remove" name="add_more_product_dimension" id="{{$i}}"><i class="fa fa-minus"></i></a>
                </div>  
              </div>
            @endif
            @php $i++; @endphp
          </div>
             @endforeach
          @endif  
          <div class="product_dimension_div_new"></div> --}}
          <!---------------end-product-dimension--------------------------->



          <hr>
           <div class="col-md-12">
            <div class="form-group">
             <label for="per_product_quantitydropship">Drop Shipping <i class="fa fa-question-circle" aria-hidden="true" title="Add your dropshipper or supplier information so we can forward your orders to their email automatically. You will be copied on all emails forwarded to your dropshipper"></i></label>
            </div>
           </div> 
           <div class="col-md-4">
             <div class="form-group">
                <label for="drop_shipper_name"> DroppShipper Name </label>
                <input type="text" name="drop_shipper_name" id="drop_shipper_name" class="input-text" placeholder="Enter DroppShipper Name" value="{{isset($drop_shipper['name']) ?$drop_shipper['name']:'' }}" autocomplete="off">
                <div id="DropShipperList"></div>
            </div>
          </div> 
          <div class="col-md-4">
             <div class="form-group">
                <label for="drop_shipper_email"> DropShipper Email </label>
                <input type="email" name="drop_shipper_email" id="drop_shipper_email" class="input-text readonly_div" placeholder="Enter DroppShipper Email" data-parsley-type="email"  value="{{isset($drop_shipper['email']) ?$drop_shipper['email']:'' }}" @if(isset($drop_shipper['email'])) readonly="readonly" @endif>
                <span id="err_drop_shipper_email"></span>
            </div>
          </div> 
           <div class="col-md-4">
             <div class="form-group">
                <label for="drop_shipper_product_price"> DropShipper Price ($)</label>
                {{-- <input type="text" name="drop_shipper_product_price" id="drop_shipper_product_price" class="input-text decimal readonly_div" placeholder="Enter Product Price" data-parsley-type="number" data-parsley-maxlength="10" data-parsley-min="1" value="{{isset($drop_shipper['product_price']) ?number_format($drop_shipper['product_price'],2):'' }}"  @if(isset($drop_shipper['product_price'])) readonly="readonly" @endif> --}}

                <input type="text" name="drop_shipper_product_price" id="drop_shipper_product_price" class="input-text decimal" placeholder="Enter Product Price" data-parsley-type="number" data-parsley-maxlength="10" data-parsley-min="1" value="{{isset($drop_shipper['product_price']) ?number_format($drop_shipper['product_price'],2):'' }}" >


            </div>
          </div> 
          <hr>
              {{-- {{dd($arr_product) }} --}}
             <div class="col-md-6">
                 <div class="form-group">
                    <label for="product_video_source">Product Video Source </label>
                    <div class="select-style">
                        <select class="frm-select" name="product_video_source" id="product_video_source" onchange="changeVideoUrlStatus(this);" >
                            <option value="">Select Product Video Source</option>
                            <option value="youtube" @if($arr_product['product_video_source']=="youtube") selected @endif>Youtube</option>
                            <option value="vimeo" @if($arr_product['product_video_source']=="vimeo") selected @endif>Vimeo</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 product_video_url_div" @if($arr_product['product_video_source']=='youtube' || $arr_product['product_video_source']=='vimeo') style="display: block" data-parsley-required ='true' @else style="display: none" @endif>
                 <div class="form-group">
                    <label for="product_video_url">Product Video URL Short Code <span>* </span></label>
                    <div class="select-style">
                        <input class="input-text" name="product_video_url" id="product_video_url" placeholder="Enter Product Video Url Short Code" @if($arr_product['product_video_source']=='youtube' || $arr_product['product_video_source']=='vimeo') data-parsley-required ='true' @endif data-parsley-required-message="Please enter the youtube/vimeo url short code" value="{{ $arr_product['product_video_url'] }}" >
                    </div>
                    <span class="price-pdct-fnts">(For Ex: <b>3vauM7axnRs</b> is a short code of youtube link https://www.youtube.com/watch?v=<b>3vauM7axnRs</b>)</span>
                </div>
            </div>


     <!--        <div class="col-md-12">
               <div  id="dynamic_field" class="form-group">
                  <label for="image">Additional Product Image<span>*</span></label>
                  <div class="clone-divs edt-chow-view">

                  <input type="file" name="product_additional_image" id="product_additional_image">

                  </div>
                  <div id="product_additional_image_preview"></div>

                   <span id="showerr1"></span> 
                     
                  <div class="clone-divs">
                    
                    @if($arr_product['additional_product_image']!="")
                    <img src="{{$additional_product_public_img_path}}{{$arr_product['additional_product_image'] or ''}}" width="50" height="50" alt="Additional Product Image"/>
                    @endif
                  </div>
               

                  <input type="hidden" name="old_additional_product_img" id="old_additional_product_img" value="{{$arr_product['additional_product_image'] or ''}}">
                  
                  <input type="hidden" name="additional_product_img_flag" id="additional_product_img_flag">

                
                </div>
             </div>
 -->





           {{--  <div class="col-md-12">
                 <div class="slr-prdt-mn">
                     <div class="check-box form-group">
                         <input type="checkbox" @if($arr_product['is_age_limit']==1) checked="checked" @endif class="css-checkbox is_age_limit" id="checkbox4" name="is_age_limit" value="{{ $arr_product['is_age_limit'] }}" />
                         <label class="css-label radGroup2" for="checkbox4">Age Limit <span></span></label>
                      </div>
                      <div class="seller-age-ck">
                        
                          <select name="age_restriction" id="age_restriction" class="form-control" >  
                            <option value="">Select </option>
                            @if(isset($age_restrictiondata) && count($age_restrictiondata)>0)
                                @foreach($age_restrictiondata as $v)
                                  <!-- we have to hide 18+ age option -->
                                  @if($v['id'] != 1)
                                    <option value="{{ $v['id'] }}"  
                                     @if($arr_product['age_restriction']==$v['id']) selected @endif>{{ $v['age'] }}</option>
                                  @endif
                                     
                                @endforeach
                              @endif
                           </select>

                         <span id="age_restriction_err" class="error-whitspace"></span>
                      </div>
                      <div class="clearfix"></div>
                 </div>
            </div> --}}

             <div class="col-md-12">
                 <div class="slr-prdt-mn">
                     <div class="check-box form-group">
                         <input type="checkbox" @if($arr_product['is_active']==1) checked="checked" @endif class="css-checkbox is_active" id="checkbox5" name="is_active" value="{{ $arr_product['is_active'] }} " />
                         <label class="css-label radGroup2" for="checkbox5">Is Active <span></span></label>
                      </div>                     
                      <div class="clearfix"></div>
                 </div>
            </div>

            <div class="col-md-12">
                 <div class="slr-prdt-mn">
                     <div class="check-box form-group">
                         <input type="checkbox" class="css-checkbox is_age_limit" id="checkbox6" name="terms" value="1" checked data-parsley-required="true" data-parsley-required-message="Please accept terms and conditions"/>
                         <label class="css-label radGroup2" for="checkbox6">I Accept &nbsp;<a href="{{ url('/') }}/terms-conditions" target="_blank">Terms and Conditions <span class="asteric_mark">*</span></a></label>
                      </div>
                      <div class="clearfix"></div>
                 </div>
            </div>
           






            <div class="col-md-12">
                <div class="button-list-dts">
                    <button class="butn-def" id="btn_add" type="button">Duplicate Product</button>
                    <a href="{{ url('/') }}/seller/product" class="butn-def cancelbtnss">Back</a>
                </div>
            </div>
       </div>
   </form>
   </div>
</div>
</div>

<div class="product_dimension_div_copy" style="display:none;">
<div class="col-md-5">
    <div class="form-group">
       <label for="product_dimension">Product Dimension Type <span>*</span></label>
       <input type="text" name="product_dimension[]" id="product_dimension" data-parsley-required="true" data-parsley-required-message="Please enter product dimension type." class="input-text">
    </div>
</div>
<div class="col-md-5">
    <div class="form-group">
       <label for="second_level_category_id">Product Dimensions <span>*</span></label>
       <input type="text" name="product_dimension_value[]" data-parsley-required="true" data-parsley-required-message="Please enter product dimension." class="input-text product_dimension_value" placeholder="Enter product dimension">
  </div>
</div>
<div class="col-md-2">
<a href="javascript:void(0)" class="remove" name="remove_more_product_dimension" id="remove_more_product_dimension"><i class="fa fa-minus"  onclick="javascript: removeRows(this);"></i></a>
</div>
</div>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

<script type="text/javascript">
  var SITE_URL  = "{{ url('/')}}";
  var inputcount = $(document).find('.product_dimension_value').length;
  var i=inputcount; 


  
    $(".editMore").click(function(){

             if(inputcount<10)
             { 
                  last_row_dim       = $('#product_dimension_'+i).val();
                  last_row_dim_value = $('#product_dimension_value_'+i).val();

                  if(last_row_dim ==""){
                      $('#err_product_dimension_'+i).html('Please enter product dimension type.');
                      return false;
                  } 
                 if(last_row_dim_value==""){
                      $('#err_product_dimension_value_'+i).html('Please enter product dimension value.');
                      return false;
                  } 
                 i++; 
                   $('.product_dimension_div_new').append('<div id="row'+i+'"><div class="col-md-5"><div class="form-group"><label for="second_level_category_id">Product Dimension Type </label><input type="text" name="product_dimension[]" id="product_dimension_'+i+'"  class="input-text" placeholder="Enter Product Dimension Type" onkeyup="clear_err_div_dim('+i+')"></div><span id="err_product_dimension_'+i+'" class="err"></span></div><div class="col-md-5"><div class="form-group"><label for="second_level_category_id">Product Dimension </label><input type="text" name="product_dimension_value[]" class="input-text product_dimension_value" placeholder="Enter Product Dimension" id="product_dimension_value_'+i+'" onkeyup="clear_err_dim_val('+i+')"></div><span id="err_product_dimension_value_'+i+'" class="err"></span></div><div class="col-md-2"><div class="form-group" style="margin-top:30px;"><a href="javascript:void(0)" class="remove" name="add_more_product_dimension" id="'+i+'"><i class="fa fa-minus"></i></a></div></div></div>');  
             } 
             else
             {
                  alert('You can not add more dimensions');
             }
    });

       $(document).on('click', '.remove', function(){  
           var button_id = $(this).attr("id"); 
           var dimension = $("#product_dimension_"+button_id).val();
           var dimension_value =  $("#product_dimension_value_"+button_id).val(); 

         if(dimension!="" && dimension_value!="")
         {
                swal({
                title: "Need Confirmation",
                text:  "Are you sure? Do you want to remove this row.",
                type:  "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "OK",
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
              },
              function(isConfirm) 
              {
                if (isConfirm) 
                {
                  $('#row'+button_id+'').remove();  
                }
               
              }); 
         }  

         else
         {
            $('#row'+button_id+'').remove(); 
         } 
      });  



  $(document).ready(function()  
  {

      var i=1;  
      $('#add_more').click(function(){  
         var inputcount = $("#dynamic_field").find('img').length;
         if(inputcount<5){
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'" class="clone-divs"><input type="file" name="product_image[]"  class="form-control name_list" data-parsley-required="true"/><a href="javascript:void(0)" name="remove" id="'+i+'" class="btn-clone-minus btn_remove"><i class="fa fa-minus"></i></a></div>');
         }else{
          alert('You can not select images');
         }
      });  




 $('#brand').keyup(function(){ 
        var query = $(this).val();

        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
           $.ajax({
            url:SITE_URL+'/seller/product/autosuggest',
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
             $('#brandList').fadeIn();  
             $('#brandList').html(data);
            }
           });
        }
    });  

 $('#drop_shipper_name').keyup(function(){ 
        var query = $(this).val();
       
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
           $.ajax({
            url:SITE_URL+'/seller/product/autosuggest_dropshipper',
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
              if(data.indexOf("Not Found") > -1)
              {
                $("#drop_shipper_email").removeAttr('readonly');  
                $("#drop_shipper_product_price").removeAttr('readonly');
                $('#drop_shipper_product_price').removeClass('readonly_div');
                $('#drop_shipper_email').removeClass('readonly_div');
                $("#drop_shipper_email").val('');
                $("#drop_shipper_product_price").val('');
              }

              $('#DropShipperList').fadeIn();  
              $('#DropShipperList').html(data);
            }
           });
        }

        else
        {
           $("#drop_shipper_email").removeAttr('readonly');  
           $("#drop_shipper_product_price").removeAttr('readonly');
           $('#drop_shipper_product_price').removeClass('readonly_div');
           $('#drop_shipper_email').removeClass('readonly_div');
           $("#drop_shipper_email").val('');
           $("#drop_shipper_product_price").val('');
        }
    }); 

     $(document).on('click', '#brandList .liclick', function(){  
        $('#brand').val($(this).text());  
        $('#brandList').fadeOut();  
    });  

      $(document).on('mouseleave', 'li', function(){  
        $('#brandList').fadeOut();  
    });  


    
      $(document).on('click', '#DropShipperList .liclick', function(){  
      $('#drop_shipper_name').val($(this).text()); 
      var query = $(this).text();
      
        var _token = $('input[name="_token"]').val();
         $.ajax({
          url:SITE_URL+'/seller/product/get_dropshipper_details',
          method:"POST",
          data:{query:query, _token:_token},
          dataType:'json',
          success:function(data){
           $('#drop_shipper_email').val(data[0].email);
           $('#drop_shipper_email').attr('readonly','true');
           $('#drop_shipper_product_price').val(Math.round(data[0].product_price).toFixed(2));
          // $('#drop_shipper_product_price').attr('readonly','true');
         //  $('#drop_shipper_product_price').addClass('readonly_div');
           $('#drop_shipper_email').addClass('readonly_div');
          }
         });
      $('#DropShipperList').fadeOut();  
     }); 


      $(document).on('mouseleave', '#DropShipperList', function(){  
        $('#DropShipperList').fadeOut();
    });      


      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
           if(button_id)
           {
                  $.ajax({
                  url: SITE_URL+'/seller/product/delete_images/'+button_id,
                  method:'GET',
                   beforeSend: function() {
                   showProcessingOverlay();
                   },
                  success:function(data)
                  {
                     hideProcessingOverlay(); 
                         if('success' == data.status)
                         {
                           window.location.reload();
                         }else{
                          //swal('warning',data.description,data.status);
                          window.location.reload();
                         }
                  }
                });
           }
      });  


    var csrf_token = $("input[name=_token]").val(); 


    $('#btn_add').click(function()
    {
        var product_name = document.getElementById("product_name").value.toLowerCase();

        var is_cbd_exist = product_name.split(/\s+|\./).includes('cbd');
        var is_thc_exist = product_name.split(/\s+|\./).includes('thc');

        /*if (is_cbd_exist == true || is_thc_exist == true ) {

          document.getElementById("product_name_error").innerHTML = "Remove the word 'CBD' or 'THC'. All cannabinoids should be displayed in the certificate of analysis of this product";

            event.preventDefault();

            return false;
        }
        else {

          document.getElementById("product_name_error").innerHTML = "";
        }*/

        var flag=0;
        var drop_shipper_name = $("#drop_shipper_name").val(); 
        var drop_shipper_email= $("#drop_shipper_email").val(); 
        var drop_shipper_product_price= $("#drop_shipper_product_price").val();

        var product_dimension        = $("input[name='product_dimension[]']")
              .map(function(){return $(this).val();}).get();
        var product_dimension_values = $("input[name='product_dimension_value[]']")
              .map(function(){return $(this).val();}).get();      


        if(product_dimension.length>0)
        {  
          for (var i = 1; i <= product_dimension.length; i++) {
              if($("#product_dimension_value_"+i).val()!="" && $("#product_dimension_"+i).val()=="")
              {
                 $("#err_product_dimension_"+i).html('Please enter product dimension type.'); 
                 $("#product_dimension_"+i).focus();
                 return false;
              }

             
          }
        }

        if(product_dimension_values.length>0)
        { 
          for (var i = 1; i <= product_dimension_values.length; i++) {
              if($("#product_dimension_"+i).val()!="" && $("#product_dimension_value_"+i).val()=="")
              {
                   
                 $("#err_product_dimension_value_"+i).html('Please enter product dimension value.'); 
                 $("#product_dimension_value_"+i).focus();
                 return false;
              }
          }
        }




         if(drop_shipper_name!="" && drop_shipper_email=="" && drop_shipper_product_price=="") 
          {
            $("#drop_shipper_email").attr("data-parsley-required","true");
            $("#drop_shipper_email").attr("data-parsley-required-message","Please enter dropshipper email");
            $("#drop_shipper_product_price").attr("data-parsley-required","true");
            $("#drop_shipper_product_price").attr("data-parsley-required-message","Please enter dropshipper price");

            flag=1;
          }

          else if(drop_shipper_name!="" && drop_shipper_email!="" && drop_shipper_product_price=="") 
          {
            $("#drop_shipper_product_price").attr("data-parsley-required","true");
            $("#drop_shipper_product_price").attr("data-parsley-required-message","Please enter dropshipper price");

            flag=1;
          }
          else if(drop_shipper_name!="" && drop_shipper_email=="" && drop_shipper_product_price!="") 
          {
            $("#drop_shipper_email").attr("data-parsley-required","true");
            $("#drop_shipper_email").attr("data-parsley-required-message","Please enter dropshipper email");

            flag=1;
          }
          else if(drop_shipper_name=="" && drop_shipper_email!="" && drop_shipper_product_price!="") 
          {
            $("#drop_shipper_name").attr("data-parsley-required","true");
            $("#drop_shipper_name").attr("data-parsley-required-message","Please enter dropshipper name");

            flag=1;
          }
        
         else if(drop_shipper_name=="" && drop_shipper_email!="" && drop_shipper_product_price=="")
         {
            $("#drop_shipper_name").attr("data-parsley-required","true");
            $("#drop_shipper_name").attr("data-parsley-required-message","Please enter dropshipper name");
            $("#drop_shipper_product_price").attr("data-parsley-required","true");
            $("#drop_shipper_product_price").attr("data-parsley-required-message","Please enter dropshipper price");

            flag=1;
         } 
         else if(drop_shipper_name=="" && drop_shipper_email=="" && drop_shipper_product_price!="")
         {
            $("#drop_shipper_name").attr("data-parsley-required","true");
            $("#drop_shipper_name").attr("data-parsley-required-message","Please enter dropshipper name");
            $("#drop_shipper_email").attr("data-parsley-required","true");
            $("#drop_shipper_email").attr("data-parsley-required-message","Please enter dropshipper email");

            flag=1;
         } 
         else
         {
           flag=0;
         }


       if ($("#checkbox4").is(':checked')) {
          
               $(".is_age_limit").val('1');
              if($("#age_restriction").val()==""){
                flag=1;
                $("#age_restriction_err").html('Please select age restriction');
                 $("#age_restriction_err").css('color','red');
                }else{
                     flag=0;
                     $("#age_restriction_err").html('');
                }
        }else{
          
             $(".is_age_limit").val('0');
             flag=0;
             $("#age_restriction_err").html('');
             $("#age_restriction").val('');
        }


        if ($("#checkbox5").is(':checked')) {
          $(".is_active").val('1');
        }else{
             $(".is_active").val('0');
        }


         // check age restriction 21+ not allowed for edible category  
       var first_level_category_id  = $('#first_level_category_id').val();
       var fval = $("#first_level_category_id option:selected").text();
       var flag2=0;
       var age_restriction = $("#age_restriction").val();  
       // if(fval.trim()=="Edibles")
       //  {
       //      if(age_restriction.trim()!='' && age_restriction=="2"){
       //          $("#age_restriction_err").html('You can not select 21+ age for this category');
       //          $("#age_restriction_err").css('color','red');
       //           flag2=1;
       //      }

       //  }
        //end check


        /* Validate cannobinoids*/
        $(".err_sel_cannabinoids").html("");
        $(".err_txt_percent").html("");

        var spectrumval = $("#spectrum option:selected").text();

        if(spectrumval.trim()=="Full Spectrum" || spectrumval.trim()=="Broad Spectrum" || spectrumval.trim()=="Isolate")
        {
          $(".sel_cannabinoids").attr('data-parsley-required','true');
          $(".txt_percent").attr('data-parsley-required','true');
        } else {
          $(".sel_cannabinoids").removeAttr('data-parsley-required');
          $(".txt_percent").removeAttr('data-parsley-required');
        }


        if($('#validation-form').parsley().validate()==false) return;
 
        if(flag==0){
          swal({
             title:'Warning',
             text: "Are you sure, you have changed your product name?",
             type: 'warning',
             confirmButtonText: "Yes, Do it!",
             showCancelButton: true,
             closeOnConfirm: false
          },
          function(isConfirm,tmp)
          {
            if(isConfirm==true)
            {   

              //var ckeditor_description = CKEDITOR.instances['description'].getData();
              formdata = new FormData($('#validation-form')[0]);
              //formdata.set('description',ckeditor_description); 
              $.ajax({                  
                url: SITE_URL+'/seller/product/copy_product_save',
                data: formdata,
                contentType:false,
                processData:false,
                method:'POST',
                cache: false,
                dataType:'json',
                beforeSend : function()
                { 
                  showProcessingOverlay();        
                },
                success:function(data)
                {
                   hideProcessingOverlay(); 
                   if('success' == data.status)
                   {
                    
                      $('#validation-form')[0].reset();

                        swal({
                               title:'Success',
                               text: data.description,
                               type: data.status,
                               confirmButtonText: "OK",
                               closeOnConfirm: false
                            },
                           function(isConfirm,tmp)
                           {
                             if(isConfirm==true)
                             {
                                window.location = data.link;
                             }
                           });
                    }else if('ImageFAILURE' == data.status){
                      $("#showerr").html('Only jpg,png,jpeg extenstions allowed');
                      $("#showerr").css('color','red');
                    }
                    else
                    {
                       swal('Alert!',data.description,data.status);
                    }  
                }
                
              });
            }
          });   
       }else{
         return false;
       }

    });

  });

$("#age_restriction").on("change", function(e) 
{   
    var first_level_category_id  = $('#first_level_category_id').val();
    var fval = $("#first_level_category_id option:selected").text();
       if(fval.trim()=="Edibles")
       {
          var ageval = $(this).val();
         // if(ageval.trim()!='' && ageval==1){
          if(ageval.trim()!='' && ageval==2){   
              $("#age_restriction_err").html('');
          }
         
       }
});

  
  function hidecoaforspectrum()
  {
       var spectrumid  = $('#spectrum').val();
       var spectrumval = $("#spectrum option:selected").text();
       var is_certificate_exists = $("#is_certificate_exists").val();


       if(spectrumval.trim()=="Hemp Seed")
      {
          $("#product_certificate").removeAttr('data-parsley-required');
          $("#coa_div").hide();
          $("#coa_link_div").hide();
          $("#per_product_quantity").removeAttr('data-parsley-required');
          $("#per_product_quantity").removeAttr('data-parsley-min');
          $("#concentration_div").hide();
      }
      else{
            if(is_certificate_exists==1)
          {
            $("#product_certificate").removeAttr('data-parsley-required');
            $("#coa_div").show();
            $("#coa_link_div").show();
          }
          else{
             $("#product_certificate").attr('data-parsley-required',true);
             $("#coa_div").show();
             $("#coa_link_div").show();
          }
           $("#per_product_quantity").attr('data-parsley-required',true);
            $("#per_product_quantity").attr('data-parsley-min',1);
           $("#concentration_div").show();

        
      }//spectrum val

      if(spectrumval.trim()=="Full Spectrum" || spectrumval.trim()=="Broad Spectrum" || spectrumval.trim()=="Isolate")
      {
          $("#div_for_cannabinoids").show();
          $(".sel_cannabinoids").attr('data-parsley-required','true');
          $(".txt_percent").attr('data-parsley-required','true');
      } else {
          $("#div_for_cannabinoids").hide();
          $(".sel_cannabinoids").removeAttr('data-parsley-required');
          $(".txt_percent").removeAttr('data-parsley-required');

      }


  }//hidecoaforspectrum


   function get_second_level_category()
  {
      var first_level_category_id  = $('#first_level_category_id').val();
      var fval = $("#first_level_category_id option:selected").text();

       //set default value of edible category to 18+
       var age_restriction = $("#age_restriction").val();  
       if(fval.trim()=="Edibles")
       {
          $('#checkbox4').prop('checked', true);
         // $("#age_restriction").val('1');
          $("#age_restriction").val('2'); 
       }else{
         $('#checkbox4').prop('checked', false);
         $("#age_restriction").val('');
       }




      if(fval.trim()=="Essential Oils" || fval.trim()=="Accessories")
      {
         $("#per_product_quantity").removeAttr('data-parsley-required');
         $("#product_certificate").removeAttr('data-parsley-required');
          $("#concentration_div").hide();
          $("#coa_div").hide();
          $("#coa_link_div").hide();
      }
      else{
         $("#per_product_quantity").attr('data-parsley-required',true);
        // $("#product_certificate").attr('data-parsley-required',true);
           $("#per_product_quantity").attr('data-parsley-min',1);
           $("#concentration_div").show();
           $("#coa_div").show();
           $("#coa_link_div").show();

           var old_product_certificate = $("#old_product_certificate").val();
           
       
           if(old_product_certificate=="" || old_product_certificate==undefined)
           {
            
             $("#product_certificate").attr('data-parsley-required',true);
           }else{
           
             $("#product_certificate").removeAttr('data-parsley-required');
           }
      }

      if(fval.trim()=="Accessories")
      {
       $('#spectrum').val('5');
       // $('#spectrum').find('option:contains("Not Applicable")').attr('selected', 'selected');

      }else{
        $('#spectrum').val('');
      }


      $.ajax({
              url:SITE_URL+'/seller/product/get_second_level_category',
              type:'GET',
              data:{
                      first_level_category_id:first_level_category_id,
                      _token:$("input[name=_token]").val()
                    },
              dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(response)
              { 
                  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select Subcategory</option>';
                   
                  for(var i=0; i < response.second_level_category.length; i++)
                  {
                    var obj_cat = response.second_level_category[i];
                    html+="<option value='"+obj_cat.id+"'>"+obj_cat.name+"</option>";
                  }
                  
                  $("#second_level_category_id").html(html);
              }
      });
  }

function check_price_drop() {
    var unit_price = parseFloat($('#unit_price').val());
    var price_drop_to =parseFloat($('#price_drop_to').val());
    if(price_drop_to >= unit_price){
        $('#price_drop_error').html('Price Drop should not be greater than Unit Price').css('color','red');
        $('#btn_add').attr('disabled',true);

        
    }else{
        $('#price_drop_error').html('').css('color','red');
        $('#btn_add').attr('disabled',false);

    }
}

$('.decimal').keyup(function()
{
  var val = $(this).val();
  if(isNaN(val)){
       val = val.replace(/[^0-9\.]/g,'');
       if(val.split('.').length>2) 
           val =val.replace(/\.+$/,"");
  }
  $(this).val(val); 
});

//Check image validation on upload file
$("#product_image").on("change", function(e) 
{
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                           "image/JPG", "image/JPEG", "image/PNG"];
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
      swal('Alert!','Please select valid image type. Only jpg, jpeg and png file is allowed.');

      $('#'+selectedID).val('');

      var previewImageID = selectedID+'_preview';
      $('#'+previewImageID+' + img').remove();
    }
    else
    {
      filePreview(this);
    }
});


//Check image validation on upload file
$("#product_additional_image").on("change", function(e) 
{   
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                           "image/JPG", "image/JPEG", "image/PNG"];
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
      swal('Alert!','Please select valid image type. Only jpg, jpeg and png file is allowed.');

      $('#'+selectedID).val('');

      var previewImageID = selectedID+'_preview';
      $('#'+previewImageID+' + img').remove();
    }
    else
    {
      filePreview(this);
    }
});

$("#product_certificate").on("change", function(e) 
{
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
   /* var validImageTypes = ["image/jpg", "image/jpeg", "image/png","application/pdf",
                           "image/JPG", "image/JPEG", "image/PNG"];*/

    var validImageTypes = ["application/pdf"];                       
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
    //  swal('Alert!','Please select valid image type. Only jpg, jpeg,png and pdf file is allowed.');
     swal('Alert!','Please select valid file. Only pdf file is allowed.');

      $('#'+selectedID).val('');

      var previewImageID = selectedID+'_preview';
      $('#'+previewImageID+' + img').remove();
    }
    else
    {
       if(fileType=="application/pdf"){
        
       }else{
        filePreview(this);
       }
       
    }
});

function filePreview(input) {

    var selectedID      = $(input).attr('id');
    var previewImageID  = selectedID+'_preview';

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+previewImageID+' + img').remove();
            $('#'+previewImageID).after('<img src="'+e.target.result+'" width="100" height="100"/>');
        };
        reader.readAsDataURL(input.files[0]);
    }
}



function changeVideoUrlStatus(video_type_object) {

    var video_type = $(video_type_object).val();
    // alert(video_type);
    if(video_type === "vimeo" || video_type === "youtube")
    {
      $('.product_video_url_div').show();
      $('#product_video_url').attr('data-parsley-required',true);
    }
    else
    {
      $('.product_video_url_div').hide();
      $('#product_video_url').removeAttr('data-parsley-required');
      $('#product_video_url').val('');

    }

}


   
   
     function clear_err_div_dim(i) 
     {
      
         var product_dimension        = $("#product_dimension_"+i).val();
         var product_dimension_value  = $("#product_dimension_value_"+i).val();
         
          if(product_dimension=="" && product_dimension_value!="")
          {
            $("#err_product_dimension_"+i).html('Please enter product dimension type.');
            return false;
          }  
          else if(product_dimension=="" && product_dimension_value=="")
          {
             $("#err_product_dimension_"+i).html('');
             $("#err_product_dimension_value_"+i).html('');
             if(i!=1)
             { 
               $('#row'+i+'').remove();  
             }
          }
          else if(product_dimension!="")
          {
              $("#err_product_dimension_"+i).html('');
          }
     }

    function clear_err_dim_val(i) 
     {
         var product_dimension        = $("#product_dimension_"+i).val();
         var product_dimension_value  = $("#product_dimension_value_"+i).val();

          if(product_dimension!=""  && product_dimension_value=="")
          {
            $("#err_product_dimension_value_"+i).html('Please enter product dimension value.');
            return false;
          }
          else if(product_dimension_value=="" && product_dimension=="")
          {     
            $("#err_product_dimension_value_"+i).html('');
            $("#err_product_dimension_"+i).html('');
            if(i!=1)
            {  
              $('#row'+i+'').remove();  
            }
          } 
          else if(product_dimension_value!="")
          {
              $("#err_product_dimension_value_"+i).html('');
          }

       }


</script>
<script type="text/javascript">
  function product_name_check(ref) {

    var produvt_name = ref.value.toLowerCase();

      var is_cbd_exist = produvt_name.split(/\s+|\./).includes('cbd');
      var is_thc_exist = produvt_name.split(/\s+|\./).includes('thc');

      if (is_cbd_exist == true || is_thc_exist == true) {

        document.getElementById("product_name_error").innerHTML = "Remove the word 'CBD' or 'THC'. All cannabinoids should be displayed in the certificate of analysis of this product";
      }
      else {

        document.getElementById("product_name_error").innerHTML = "";
      }
  }

    function add_new_row(row_id){
      var sel_can = $("#sel_cannabinoids"+row_id).val();
      var txt_percent = $("#txt_percent"+row_id).val();
   

      $(".filled").hide();
      $("#parsley-id-42").hide();
      $("#parsley-id-44").hide();
      if(sel_can == ""){
        $("#err_sel_cannabinoids_"+row_id).html("Please select cannabinoids");
        return false;
      } else {
        $("#err_sel_cannabinoids_"+row_id).html("");

      }

      if(txt_percent == ""){
        $("#err_txt_percent_"+row_id).html("Please enter percent");
        return false;
      } else {
        $("#err_txt_percent_"+row_id).html("");

      }

      $(".err_sel_cannabinoids").html("");
      $(".err_txt_percent").html("");
       var sel_cannabinoids_arr        = document.getElementsByName("sel_cannabinoids[]"); 
      var txt_percent_arr              = document.getElementsByName("txt_percent[]");

              // alert(sel_cannabinoids_arr.length);
      if(sel_cannabinoids_arr.length>0)
      { 
        for (var i = 0; i <= sel_cannabinoids_arr.length; i++) {
            if($("#sel_cannabinoids"+i).val()=="")
            {      
               $("#err_sel_cannabinoids_"+i).html('Please enter cannabinoids'); 
               $("#err_sel_cannabinoids_"+i).focus();
               // row_id = i;
               return false;
            }

            if($("#txt_percent"+i).val()=="")
            {                 
               $("#err_txt_percent_"+i).html('Please enter percent'); 
               $("#err_txt_percent_"+i).focus();
               return false;
            }

            row_id = i;
        }
      }


      $.ajax({
              url:SITE_URL+'/seller/product/addnewrow',
              type:'POST',
              data:{
                      row_id:row_id,
                      _token:$("input[name=_token]").val()
                    },
             
              success:function(response)
              { 
                  $("#div_append_cannabinoids").append(response);
                  $(".sel_cannabinoids").attr('data-parsley-required','true');
                  /*$("#delete_row_"+row_id).hide();
                  $("#add_row_"+row_id).show();*/
                  $(".txt_percent").attr('data-parsley-required','true');
              }
      });
  }

  function remove_row(row_id,prod_can_id,prod_id,data){  
           

         if(prod_can_id != '' || prod_id != ''){
             $.ajax({
               url:SITE_URL+'/seller/product/removerow',
               type:'POST',
               data:{prod_can_id:prod_can_id,prod_id : prod_id,_token:$("input[name=_token]").val()},
            
               success: function(response)
               {

                  // hideProcessingOverlay(); 
                  // location.reload();
                  $("#row_cannabinoids"+row_id).remove();
               }
             }); 
          } else {
             $("#row_cannabinoids"+row_id).remove();
          }
   
  }

  /* Function to check duplication of cannabinoids in a row*/
  function check_duplicate_cannabinoids(cannabinoid_id,cannabinoid_value,row_cnt){
            var inps = document.getElementsByName('sel_cannabinoids[]');
            for (var i = 0; i <inps.length; i++) {
              var new_value = inps[i].value;
              var new_id = inps[i].id;
              if (new_value == cannabinoid_value && new_id != cannabinoid_id)
              {               
                  swal('Alert!','Sorry! You can not select this cannabinoids. As this is already selected.');
                  $("#"+cannabinoid_id).val("");     
                  return false;
              }
        };
  }
</script>
@endsection