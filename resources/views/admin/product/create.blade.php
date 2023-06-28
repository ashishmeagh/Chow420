@extends('admin.layout.master')                

@section('main_content') 
<!-- Page Content -->


<style type="text/css">
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
  .error
  {
    color:red;
  }
  .noteallowed{    font-size: 13px;
    color: #873dc8;
    letter-spacing: 0.5px;}
    .clone-divs.none-margin {
    margin-bottom: 0px;
}
.err{
    color: #e00000;
    font-size: 13px;
}
</style> 

@php
 $productid = Request::input();
@endphp


<script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script>  
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    @php
                     $user = Sentinel::check();
                    @endphp

                    @if(isset($user) && $user->inRole('admin'))
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                    @endif
                      
                    <li><a href="{{$module_url_path or ''}}">{{$module_title or ''}}</a></li>
                    <li class="active">Create Product</li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
         
    <!-- .row -->  
                <div class="row">
                  
                    <div class="col-sm-12">
                     <h4> <span id="showerr"></span> </h4>
                        <div class="white-box">
                        @include('admin.layout._operation_status')
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    {{ csrf_field() }}

                                 <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="brand">Brand <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="brand" id="brand" class="form-control" placeholder=" Enter Brand Name" data-parsley-required ='true' autocomplete="off" data-parsley-required-message="Please enter brand name">
                                       <div id="brandList">
                                       </div>
                                    </div>
                                      <span>{{ $errors->first('brand') }}</span>
                                  </div>   



                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_name">Product Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="product_name" id="product_name" class="form-control" placeholder="'Brand name' 'spectrum' 'CBD' 'product category' 'product flavor (if any)' 'product milligrams'" data-parsley-required ='true' data-parsley-required-message="Please enter product name" >
                                       <ul class="parsley-errors-list filled" id="parsley-id-5">
                                        <li  class="parsley-required" id="product_name_error"> </li>
                                      </ul>
                                    </div>
                                      <span>{{ $errors->first('product_name') }}</span>
                                  </div>


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="sku">SKU<i class="red"></i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="sku" id="sku" class="form-control" placeholder="Enter Sku" data-parsley-required-message="Please enter sku" >
                                       <ul class="parsley-errors-list filled" >
                                        <li  class="parsley-required" id="sku_error"> </li>
                                      </ul>
                                    </div>
                                      <span>{{ $errors->first('sku') }}</span>
                                  </div>



                                  <div class="form-group row">
                                      <label for="first_level_category_id" class="col-md-2 col-form-label"> Category<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select onchange="return get_second_level_category(this.value)" name="first_level_category_id" id="first_level_category_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select category">
                                            <option value="">Select category</option>
                                              @foreach($arr_category as $category)
                                                <option value="{{ $category['id'] or ''}}">{{ $category['product_type'] or '' }}</option>
                                              @endforeach
                                            </select>
                                         </div>
                                  </div>
                                   <div class="form-group row">
                                      <label for="second_level_category_id" class="col-md-2 col-form-label"> Sub Category<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select name="second_level_category_id" id="second_level_category_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select sub category">
                                            <option value="">Select sub category</option>
                                              @foreach($arr_secondcategory as $cat)
                                                <option value="{{ $cat['id'] or ''}}">{{ $cat['name'] or '' }}</option>
                                              @endforeach
                                            </select>
                                         </div>
                                  </div>


                                 @php 
                                    $spectrumarr = get_spectrums();
                                    $cannabinoids_arr = get_cannabinoids_more();
                                  @endphp

                                   <div class="form-group row">
                                     <label for="product_video_source" class="col-md-2 col-form-label"> Spectrum Type <i class="red">*</i> </label>
                                      <div class="col-md-10">
                                       <select name="spectrum" id="spectrum" class="form-control"data-parsley-required="true" data-parsley-required-message="Please select Spectrum Type" onchange="return hidecoaforspectrum(this.value)">
                                          <option value="">Select spectrum</option>                                
                                           @if(isset($spectrumarr) && !empty($spectrumarr))
                                             @foreach($spectrumarr as $spectrum)
                                               <option value="{{ $spectrum['id'] }}">{{ $spectrum['name'] }}</option>
                                             @endforeach
                                            @endif
                                        </select>
                                     </div>
                                  </div>

                       <div class="col-md-2"></div>         
                      <div class="col-md-10" id="div_for_cannabinoids" style="display:none">
                          <div class="form-group errorproduct-cannabinoid" id="div_append_cannabinoids">
                            <div class="col-md-12 flex-mobile" style="padding:10px;border: 1px solid #d1d1d1; border-bottom:none;">
                                                         <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" ><div class="cannabinoids-title">Cannabinoids</div></div>
                                                         <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">%</div></div>
                                                    </div>
                              @php 
                              $row_cnt = 0;
                              @endphp
                              <div class="col-md-12 flex-mobile" style="padding:10px;border: 1px solid #d1d1d1;" id="row_cannabinoids{{$row_cnt}}">
                                      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                          <select name="sel_cannabinoids[]" id="sel_cannabinoids{{$row_cnt}}" class="form-control sel_cannabinoids" data-parsley-required ='true'  data-parsley-required-message="Please select cannabinoids" 
                                          onchange="check_duplicate_cannabinoids(this.id,this.value,{{$row_cnt}})">
                                          <option value="">Select cannabinoids</option>                                
                                          @if(isset($cannabinoids_arr) && !empty($cannabinoids_arr))
                                            @foreach($cannabinoids_arr as $cannabinoids)
                                                <option value="{{ $cannabinoids['id'] }}" @>{{ $cannabinoids['name'] }}</option>
                                          @endforeach
                                          @endif
                                          </select>
                                          <span style="color:red;" class="err_sel_cannabinoids" id="err_sel_cannabinoids_{{$row_cnt}}"></span>
                                          <input type="hidden" name="hid_product_can_id[]" value="">
                                      </div>

                                      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <input type="text" name="txt_percent[]" id="txt_percent{{$row_cnt}}" class="form-control txt_percent" data-parsley-required ='true'  placeholder="%" value="" data-parsley-trigger="keyup"   {{--   data-parsley-type="digits" --}} 
                                        data-parsley-pattern="[0-9]*(.?[0-9]{1,3}$)"  
                                        min="0" max="100" data-parsley-required-message="Please enter percent" >
                                          <span style="color:red;" class="err_txt_percent" id="err_txt_percent_{{$row_cnt}}"></span>

                                      </div>


                                     <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                      <img src="{{url('/')}}/assets/images/plus-icon - Copy.png" alt="Add New Cannabinoids" onclick="add_new_row({{$row_cnt}})"     height="20px" width= "20px" />
                                  </div>

                                  </div>
                          </div>
                          
                      </div>
                         <div class="clearfix"></div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="description">Description<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <textarea name="description" id="description" class="form-control" placeholder="Enter Description"  data-parsley-required="true"  data-parsley-required-message="Please enter description"></textarea>
                                       {{-- <script>
                                          CKEDITOR.replace( 'description' );
                                      </script>  --}}
                                    </div>
                                      <span>{{ $errors->first('description') }}</span>
                                  </div>

                                    <!-- Added 3 fields -->

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="ingredients">Ingredients</label>
                                    <div class="col-md-10">                                       
                                       <textarea name="ingredients" id="ingredients" class="form-control" placeholder="Enter ingredients" {{-- data-parsley-required="true"  --}}data-parsley-required-message="Please enter Ingredients"></textarea> 
                                    </div>
                                    
                                      <span>{{ $errors->first('ingredients') }}</span>
                                  </div>


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="suggested_use">Suggested Use</label>
                                    <div class="col-md-10">                                       
                                       <textarea name="suggested_use" id="suggested_use" class="form-control" placeholder="Enter suggested use" {{-- data-parsley-required="true"  --}}data-parsley-required-message="Please enter suggested use"></textarea> 
                                    </div>
                                    
                                      <span>{{ $errors->first('suggested_use') }}</span>
                                  </div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="amount_per_serving">Amount per serving</label>
                                    <div class="col-md-10">                                       
                                       <textarea name="amount_per_serving" id="amount_per_serving" class="form-control" placeholder="Enter amount per serving" {{-- data-parsley-required="true" --}} data-parsley-required-message="Please enter amount per serving"></textarea> 
                                    </div>
                                    
                                      <span>{{ $errors->first('amount_per_serving') }}</span>
                                  </div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="terpenes">Terpenes</label>
                                    <div class="col-md-10">                                       
                                       
                                      <textarea name="terpenes" id="terpenes" class="form-control" placeholder="Enter terpenes"></textarea> 

                                    </div>
                                    
                                      <span>{{ $errors->first('terpenes') }}</span>
                                  </div>



                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_image"> Product Image (Image must have a white background)<i class="red">*</i></label>
                                    <div class="col-md-10">

                                      <div  id="dynamic_field">
                                           <div class="clone-divs none-margin">
                                              <input type="file" name="product_image" id="product_image"  data-max-file-size="2M" data-parsley-required="true" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" data-parsley-required-message="Please select product image"> 
                                              {{-- <a href="javascript:void(0)" class="btn-clone" name="add_more" id="add_more"><i class="fa fa-plus"></i></a> --}}
                                              {{-- <div class="noteallowed">( Allowed only jpg,jpeg and png file formats.)</div>  --}}
                                          </div>
                                          <span id="image_error">{{ $errors->first('product_image[]') }}</span>
                                        </div>
                                    </div>
                                  </div>       


                                  <div class="form-group row" id="coa_div">
                                    <label class="col-md-2 col-form-label" for="product_certificate"> Certificate Of Analysis <i class="red">*</i> </label>
                                    <div class="col-md-10">

                                      <div  id="dynamic_field">
                                           <div class="clone-divs none-margin">
                                              <input type="file" name="product_certificate" id="product_certificate"  data-max-file-size="2M" data-parsley-required="true" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#product_certificate_error" data-parsley-required-message="Please select certificate of analysis"> 
                                              {{--  <div class="noteallowed">( Allowed only jpg,jpeg and png file formats.)</div> --}} 
                                          </div>

                                          <span id="product_certificate_error">{{ $errors->first('product_certificate') }}</span>
                                        </div>
                                       
                                    </div>
                                  </div>       

                                 

                                    <div class="form-group row" id="coa_link_div">
                                    <label class="col-md-2 col-form-label" for="coa_link">COA Link<i class="red"></i></label>
                                    <div class="col-md-10">             
                                       <input type="text" data-parsley-type="url" name="coa_link" id="coa_link" class="form-control"placeholder="Enter COA Link"  data-parsley-required-message="Please enter the coa link"  value="">
                                       <span id="coa_link_url_err">{{ $errors->first('coa_link') }}</span>
                                    </div>                                      
                                  </div> 




                                  
                                  
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="unit_price">Unit Price ($)<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="unit_price" id="unit_price" class="form-control" placeholder="Enter Unit Price" data-parsley-required="true"  data-parsley-maxlength="10" data-parsley-min="1" data-parsley-type="number" data-parsley-required-message="Please enter unit price">
                                    </div>
                                      <span>{{ $errors->first('unit_price') }}</span>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="price_drop_to">Price Drop to ($)</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="price_drop_to" id="price_drop_to" class="form-control" placeholder="Enter New Unit Price (Please fill this field only if you want to drop the price of product)" data-parsley-maxlength="10" data-parsley-type="number" oninput="if(parseFloat($(this).val()) >= parseFloat($('#unit_price').val())){ $(this).val(''); $('.price_drop_er_msg').html('Price drop should not be greater than unit price').css('color','red');}else{ $('.price_drop_er_msg').html(''); }" >
                                      <span class="price_drop_er_msg">{{ $errors->first('price_drop_to') }}</span>  
                                    </div>
                                    
                                      <span>{{ $errors->first('price_drop_to') }}</span>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for= "shipping_type"> Shipping Type <i class="red">*</i></label>
                                    <div class="col-md-10">     
                                      <div class="radio-btns">
                                        <div class="radio-btn">                                  
                                          <input type="radio" name="shipping_type" class="shipping_type" id="shipping_type" data-parsley-required="true" value="0" data-parsley-errors-container=".shipping_type_err" data-parsley-required-message="Please select any one Shipping Type" onchange="$('#shipping_charges_block').hide(); $('#shipping_charges').removeAttr('data-parsley-required').removeAttr('data-parsley-min');">
                                          <label for="shipping_type">Free Shipping</label> 
                                          <div class="check"></div>
                                        </div>
                                        <div class="radio-btn">
                                          <input type="radio" name="shipping_type" class="shipping_type" id="shipping_type1" data-parsley-required="true" value="1" data-parsley-errors-container=".shipping_type_err" data-parsley-required-message="Please select any one Shipping Type" onchange="$('#shipping_charges_block').show(); $('#shipping_charges').attr('data-parsley-required',true).attr('data-parsley-min','1'); "> 
                                          <label for="shipping_type1">Flat Shipping</label>
                                          <div class="check"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="shipping_type_err"></div>
                                      </div>
                                    </div>                                      
                                    <span>{{ $errors->first('shipping_type') }}</span>
                                  </div> 


                                  <div class="form-group row" id="shipping_charges_block" style="display: none">
                                    <label class="col-md-2 col-form-label" for="shipping_charges">Shipping Charges  ($) <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="shipping_charges" id="shipping_charges" class="form-control" placeholder="Enter shipping charges" data-parsley-maxlength="10" data-parsley-type="number" 
                                        data-parsley-required-message ="Please enter shipping charges"

                                       oninput="if(parseFloat($(this).val()) >= parseFloat($('#unit_price').val())){ $(this).val(''); $('#shipping_charges_err').html('Shipping charges should not be greater than unit price').css('color','red');}else{ $('#shipping_charges_err').html(''); }"  
                                       >
                                       <span id="shipping_charges_err">{{ $errors->first('shipping_charges') }}</span>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="unit_price">Shipping Duration (Days) <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="number" name="shipping_duration" id="shipping_duration" class="form-control" placeholder="Enter Shipping Duration" data-parsley-required="true"  data-parsley-maxlength="10" data-parsley-min="0.5" data-parsley-max="31" data-parsley-type="number" step="0.5" data-parsley-required-message ='Please enter shipping duration' data-parsley-min-message="Shipping duration should be greater than 0." data-parsley-max-message="Shipping duration should be less than or equal to 31 days." data-parsley-type-message="Please enter valid shipping duration.">
                                    </div>
                                      <span>{{ $errors->first('shipping_duration') }}</span>

                                  </div>

 
        

                                   <div class="form-group row">
                                      <label for="user_id" class="col-md-2 col-form-label">Dispensary Name<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select  name="user_id" id="user_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select dispensary name">
                                            <option value="">Select dispensary</option>
                                              @foreach($sellerdropdown as $seller)
                                                <option value="{{ $seller->id or ''}}" >
                                                {{-- {{ $seller->first_name or '' }} {{ $seller->last_name or '' }} --}}
                                                {{ $seller->business_name }}
                                                </option>
                                              @endforeach
                                            </select>
                                         </div>                           
                                   </div> 
 
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_stock">  Quantity <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="number" name="product_stock" id="product_stock" class="form-control decimal" placeholder="Enter Total Quantity" data-parsley-required="true" data-parsley-min="1" 
                                       data-parsley-required-message="Provided quantity should not be blank or 0 or less than 0"
                                       {{--  oninput="if($(this).val() <= 0){ $('#product_stock_err').html('Quantity should not be 0 or less than 0').css('color','red');}else{ $('#product_stock_err').html(''); }" --}}  
                                        min="1" data-parsley-min-message=""
                                       >
                                        <span id="product_stock_err">{{ $errors->first('product_stock') }}</span>
                                    </div>
                                     
                                  </div>  

                                   <div class="form-group row" id="concentration_div">
                                    <label class="col-md-2 col-form-label" for="per_product_quantity"> Concentration (mg)<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="number" name="per_product_quantity" id="per_product_quantity" class="form-control decimal"  placeholder="Enter Concentration (mg)"  
                                       {{-- data-parsley-max="5000" --}}
                                        data-parsley-required-message="Please enter concentration" data-parsley-required="true" data-parsley-min-message="This value should be greater than or equal to 1" data-parsley-min="1"

                                        {{-- oninput="if($(this).val() <= 0){ $('#concentration_err').html('Concentration should not be less than 0').css('color','red');}else{ $('#concentration_err').html(''); }"  --}}
                                        
                                       >

                                        <span id="concentration_err">{{ $errors->first('per_product_quantity') }}</span>

                                    </div>
                                     
                                  </div>   

          <!------------start-product-dimension---------->                        
          {{--  <hr>                       
           <div class="form-group row">
              <label for="product_dimension"  class="col-md-2 col-form-label">Product Dimensions</label>   
           </div>                       

           <div class="product_dimension_div">
           <div class="row">
          
            <label for="product_dimension"  class="col-md-2 col-form-label">Product Dimension Type </label>
            <div class="col-md-3">
                <div class="form-group">
                   <input type="text" name="product_dimension[]" id="product_dimension_1" class="form-control" placeholder="Enter Product Dimension" onkeyup="clear_err_div_dim(1)">
                   <span id="err_product_dimension_1" class="err"></span>
                </div>
            </div>
               <label for="product_dimension"  class="col-md-2 col-form-label">Product Dimension </label>
            <div class="col-md-3">
                <div class="form-group">
                   <input type="text" name="product_dimension_value[]" id="product_dimension_value_1" class="form-control product_dimension_value" placeholder="Enter Product Dimension" onkeyup="clear_err_div_dim_value(1)">
                  <span id="err_product_dimension_value_1" class="err"></span>
                </div>
            </div>

            <div class="col-md-2">
            <a href="javascript:void(0)" class="addMore" name="add_more_product_dimension" id="add_more_product_dimension"><i class="fa fa-plus"></i></a>
            </div>  
           </div> 
         </div> --}}
         <!------------end-product-dimension---------->                        

                                    <hr>
                                    <div class="form-group row">
                                      <label class="col-md-2 col-form-label" for="product_stockdropship">  Drop Shipping <i class="fa fa-question-circle" aria-hidden="true" title="Add your dropshipper or supplier information so we can forward your orders to their email automatically. You will be copied on all emails forwarded to your dropshipper"></i> </label>
                                    </div>  

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="drop_shipper_name"> DropShipper Name</label>
                                    <div class="col-md-4">                                       
                                       <input type="text" name="drop_shipper_name" id="drop_shipper_name" class="form-control" placeholder="Enter DroppShipper Name" autocomplete="off">
                                        <span id="DropShipperList"></span> 
                                    </div>
                                  </div>   

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="drop_shipper_email">DropShipper Email</label>
                                    <div class="col-md-4">                                       
                                       <input type="email" name="drop_shipper_email" id="drop_shipper_email" class="form-control" placeholder="Enter DroppShipper Email" data-parsley-type="email">
                                       <span id="err_drop_shipper_email"></span>
                                    </div>
                                  </div>  


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="drop_shipper_product_price">DropShipper Price ($)</label>
                                    <div class="col-md-4">                                       
                                       <input type="text" name="drop_shipper_product_price" id="drop_shipper_product_price" class="form-control decimal" placeholder="Enter DropShipper Price" data-parsley-type="number" data-parsley-maxlength="10" data-parsley-min="1">
                                    </div>
                                      <span>{{ $errors->first('unit_price') }}</span>
                                  </div>                                
                                  <hr>
                                  
                                  <div class="form-group row">
                                      <label for="product_video_source" class="col-md-2 col-form-label"> Product Video Source</label>
                                      <div class="col-md-10">
                                        <select onchange="changeVideoUrlStatus(this);"  name="product_video_source" id="product_video_source" class="form-control" >
                                          <option value="">Select Product Video Source</option>
                                          <option value="youtube">Youtube</option>
                                          <option value="vimeo">Vimeo</option>
                                        </select>
                                     </div>
                                  </div>

                                  <div class="form-group row product_video_url_div" id="product_video_url_div" style="display: none">
                                    <label class="col-md-2 col-form-label" for="product_video_url">Product Video URL Short Code<i class="red">*</i></label>
                                    <div class="col-md-10">             
                                       <input type="text" name="product_video_url" id="product_video_url" class="form-control"placeholder="Enter Product Video URL Short Code" data-parsley-required-message="Please enter the youtube/vimeo url short code" >
                                       <span id="product_video_url_err">{{ $errors->first('product_video_url') }}</span>
                                       <span class="price-pdct-fnts">(For Ex: <b>3vauM7axnRs</b> is a short code of youtube link https://www.youtube.com/watch?v=<b>3vauM7axnRs</b>)</span>
                                    </div>
                                      
                                  </div>

                               
                                  <div class="form-group row">
                                      <label for="product_video_source" class="col-md-2 col-form-label">Rating</label>
                                      <div class="col-md-10">
                                         <input type="text" name="product_rating" id="product_rating" class="form-control" placeholder="You can enter rating between 1 to 5." type="range" data-parsley-range="[1,5]">

                                         <span style="color:red;" id="error_rating"></span>
                                     </div>

                                     
                                  </div>



                                  <div class="form-group row">
                                      <label for="product_video_source" class="col-md-2 col-form-label">Review</label>
                                      <div class="col-md-10">
                                        <input type="text" name="product_review" id="product_review" class="form-control"  placeholder="Enter Review" data-parsley-type="integer">
                                     </div>
                                  </div>


                          <!--         <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_additional_image">Additional Product Image </label>
                                    <div class="col-md-10">
                                        <div  id="">
                                           <div class="clone-divs none-margin">

                                              <input type="file" name="product_additional_image" id="product_additional_image"  data-max-file-size="2M"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" > 
                                             
                                          </div>
                                          <span id="additional_image_error">{{ $errors->first('product_additional_image') }}</span>
                                        </div>
                                    </div>
                                  </div>    
-->



                                 {{--  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_stock"> Is Age Restriction <i class="red">*</i></label>
                                    <div class="col-md-10">  
                                      <div class="radio-btns">
                                        <div class="radio-btn">
                                          <input type="radio" name="is_age_limit" class="is_age_limit" id="is_age_limit" data-parsley-required="true" value="1" data-parsley-errors-container=".age_restriction_err" data-parsley-required-message="Please check the age restriction">
                                          <label for="is_age_limit">Yes</label>
                                          <div class="check"></div>
                                        </div>
                                        <div class="radio-btn">
                                          <input type="radio" name="is_age_limit" class="is_age_limit" id="is_age_limit1" data-parsley-required="true" value="0" data-parsley-errors-container=".age_restriction_err" data-parsley-required-message="Please check the age restriction"> 
                                          <label for="is_age_limit1">No</label>
                                          <div class="check"></div>
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>
                                      <div class="age_restriction_err"></div>
                                    </div>
                                      
                                      <span>{{ $errors->first('is_age_limit') }}</span>
                                  </div>    --}}
                                  

{{-- 
                                  <div class="form-group row" id="age_restriction_block" style="display: none">
                                    <label class="col-md-2 col-form-label" for="age_restriction"> Age Restriction <i class="red">*</i></label>
                                    <div class="col-md-10">                                    
                                    
                                     <select name="age_restriction" id="age_restriction" class="form-control"  data-parsley-required-message="Please select age restriction" >
                                      <option value="">Select</option>
                                      
                                      @if(isset($age_restrictiondata) && count($age_restrictiondata)>0)

                                          @foreach($age_restrictiondata as $v)

                                          
                                            @if($v['id'] != 1)
                                              <option value="{{ $v['id'] }}">{{ $v['age'] }}</option>
                                            @endif
                                             
                                          @endforeach

                                      @endif
                                     </select>

                                       <span id="age_restriction_error">{{ $errors->first('age_restriction') }}</span>
                                     <div class="age_restriction"></div>
                                    </div>                                      
                                  </div>    --}}


                                  <!---------------terms and condition div added------->
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="terms"></label>
                                    <div class="col-md-10">   
                                    <div class="checkbx">                                    
                                      <input type="checkbox" class="css-checkbox" id="checkbox6" name="terms" value="1" checked="" data-parsley-required="true" data-parsley-required-message="Please accept terms and conditions"> <label class="css-label radGroup2" for="checkbox6">I Accept &nbsp;<a href="{{ url('/') }}/terms-conditions" target="_blank">Terms and Conditions <span class="asteric_mark">*</span></a></label>
                                      </div>
                                     </div>                                     
                                  </div>     
                                 <!---------------terms and condition div added------->



 



                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Add</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path or ''}}"><i class="fa fa-arrow-left"></i> Back</a>
                                              
                                        <!-- form-group -->
                                   </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div> 
</div>

<!-- END Main Content -->
<script type="text/javascript">
    var last_row  = ""; 
    var i = 1;


     $(".addMore").click(function(){

          var inputcount  = $(".product_dimension_div").find('input .product_dimension_value').length;

          if(inputcount<10)
          { 

                last_row_dim       = $('#product_dimension_'+i).val();
                last_row_dim_value = $('#product_dimension_value_'+i).val();

                   if(last_row_dim==""){
                      $('#err_product_dimension_'+i).html('Please enter product dimension.');
                      return false;
                  } 
                 if(last_row_dim_value==""){
                      $('#err_product_dimension_value_'+i).html('Please enter product dimension value.');
                      return false;
                  } 
              i++; 
                $('.product_dimension_div').append('<div id="row'+i+'" class="row"><label for="product_dimension"  class="col-md-2 col-form-label">Product Dimension Type </label><div class="col-md-3"><div class="form-group"><input type="text" name="product_dimension[]" id="product_dimension_'+i+'" class="form-control" placeholder="Enter Product Dimension Type" onkeyup="clear_err_div_dim('+i+')"><span id="err_product_dimension_'+i+'" class="err"></span> </div></div><label for="product_dimension"  class="col-md-2 col-form-label">Product Dimension </label><div class="col-md-3"><div class="form-group"><input type="text" name="product_dimension_value[]" class="form-control" placeholder="Enter Product Dimension Value" id="product_dimension_value_'+i+'" onkeyup="clear_err_dim_val('+i+')"><span id="err_product_dimension_value_'+i+'" class="err"></span></div></div><div class="col-md-2"><a href="javascript:void(0)" class="remove" name="add_more_product_dimension" id="'+i+'"><i class="fa fa-minus"></i></a></div></div>');


          }
          else
          {
             alert('You can not add more dimensions');
          }    
    });

      $(document).on('click', '.remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  


  

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
         


//Check image validation on upload file
//$(":file").on("change", function(e) 
$("#product_image").on("change", function(e) 
{   
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                           "image/JPG", "image/JPEG", "image/PNG"];
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
      swal('Alert!','Please select valid image type. Only jpg, jpeg, and png file is allowed.');

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
    /*var validImageTypes = ["image/jpg", "image/jpeg", "image/png","application/pdf",
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
        //filePreview(this);

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

  var module_url_path  = "{{ $module_url_path or ''}}";

  $(document).ready(function() 
  {
    var module_url_path  = "{{ $module_url_path or ''}}";
    var csrf_token = $("input[name=_token]").val(); 

      var i=1;  
      $('#add_more').click(function(){  
        var inputcount = $("#dynamic_field").find('input').length;
         if(inputcount<5){
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'" class="clone-divs"><input type="file" name="product_image[]"  class="form-control name_list" data-parsley-required="true" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error"/><a href="javascript:void(0)" name="remove" id="'+i+'" class="btn-clone-minus btn_remove"><i class="fa fa-minus"></i></a></div>');  
          }else{
            alert('You can not select more images');
          }
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

 
  

 $('#brand').keyup(function(){ 
        var query = $(this).val();
       
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
           $.ajax({
            url:module_url_path+'/autosuggest',
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
             $('#brandList').fadeIn();  
             $('#brandList').html(data);
            }
           });
        }
    });  

     $(document).on('click', '#brandList .liclick', function(){  
        $('#brand').val($(this).text());  
        $('#brandList').fadeOut();  
    });  

     $(document).on('mouseleave', '#brandList', function(){  
        $('#brandList').fadeOut();  
    });  
 


    $('#btn_add').click(function()
    {

        var product_name = document.getElementById("product_name").value.toLowerCase();

        var is_cbd_exist = product_name.split(/\s+|\./).includes('cbd');

        var is_thc_exist = product_name.split(/\s+|\./).includes('thc');

       /* if (is_cbd_exist == true  || is_thc_exist == true ) {

          document.getElementById("product_name_error").innerHTML = "Remove the word 'CBD' or 'THC'. All cannabinoids should be displayed in the certificate of analysis of this product";

            event.preventDefault();

            return false;
        }
        else {

          document.getElementById("product_name_error").innerHTML = "";
        }*/
        
        var flag = 0; 
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


       // check age restriction 21+ not allowed for edible category  
       var first_level_category_id  = $('#first_level_category_id').val();
       var fval = $("#first_level_category_id option:selected").text();
       var flag2=0;
       var age_restriction = $("#age_restriction").val();  
       
       // if(fval.trim()=="Edibles")
       //  {
        
       //      if(age_restriction.trim()!='' && age_restriction=="2"){
       //           $("#age_restriction_block").show();
       //          $("#age_restriction_error").html('You can not select 21+ age for this category');
       //          $("#age_restriction_error").css('color','red');
       //          flag2=1;
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

    /*check rating value is max 5 or not*/

      /*var rating_value = $("#product_rating").val();

      if(rating_value > 5)
      {
        $("#error_rating").html("Please enter rating between 1 to 5.");
        return false;
      }*/
    /*-------------------------------------------*/  

    if(flag==0 && flag2==0)
    {   
      // var ckeditor_description = CKEDITOR.instances['description'].getData();
      formdata = new FormData($('#validation-form')[0]);
      // formdata.set('description',ckeditor_description); 
      $.ajax({
                  
          url: module_url_path+'/save',
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
                         title: 'Success',
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
                $("#showerr").html('Allowed only jpg,png,jpeg image file types');
                $("#showerr").css('color','red');
              }else if('CertificateFAILURE' == data.status){
                $("#product_certificate_error").html('Allowed only jpg,png,jpeg image file types');
                $("#product_certificate_error").css('color','red');
              }              
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   
    } 

  });

});

  function hidecoaforspectrum()
  {
       var spectrumid  = $('#spectrum').val();
       var spectrumval = $("#spectrum option:selected").text();

       if(spectrumval.trim()=="Hemp Seed")
      {
         $("#product_certificate").removeAttr('data-parsley-required');
          $("#coa_div").hide();
          $("#coa_link_div").hide();
          $("#per_product_quantity").removeAttr('data-parsley-required');
          $("#concentration_div").hide();
      }
      else{
          $("#product_certificate").attr('data-parsley-required',true);
          $("#coa_div").show();
          $("#coa_link_div").show();
          $("#per_product_quantity").attr('data-parsley-required',true);
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

  }


   function get_second_level_category()
  {
      var first_level_category_id  = $('#first_level_category_id').val();
       var fval = $("#first_level_category_id option:selected").text();

        //set default value of edible category to 18+
       var age_restriction = $("#age_restriction").val();  
       if(fval.trim()=="Edibles")
       {
          $('input:radio[id=is_age_limit]').prop('checked', true);
          $("#age_restriction_block").show();
          // $("#age_restriction").val('1');
          $("#age_restriction").val('2');
       }
       else{
          $('input:radio[id=is_age_limit]').prop('checked', false);
           $("#age_restriction_block").hide();
          $("#age_restriction").val('');
       }

       //for Hemp Seed hide coa field

       

      
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
         $("#product_certificate").attr('data-parsley-required',true);
          $("#concentration_div").show();
          $("#coa_div").show();
          $("#coa_link_div").show();

      }//else

       if(fval.trim()=="Accessories")
      {
       // $('#spectrum').find('option:contains("Not Applicable")').attr('selected', 'selected');
        $('#spectrum').val('5');

      }else{
        $('#spectrum').val('');
      }



      $.ajax({
              url:module_url_path+'/get_second_level_category',
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

$(".is_age_limit").on('change',function(){
  var val = $(this).val();
  var age_restriction = $("#age_restriction").val();

  if(val=='1'){
    $("#age_restriction_block").show();
        if(age_restriction.trim()=="")
      {
         $("#age_restriction_error").html('Please select age restriction');
         $("#age_restriction_error").css('color','red');
      }else{
         $("#age_restriction_error").html('');
      } 


    //$("#age_restriction_error").html('Please select the age restriction');
   // $("#age_restriction_error").css('color','red');

  }else{
    $("#age_restriction_block").hide();
    $("#age_restriction_error").html('');

  }
});
 

 
  $("#age_restriction").on("change", function(e) 
{   
    var first_level_category_id  = $('#first_level_category_id').val();
    var fval = $("#first_level_category_id option:selected").text();
       if(fval.trim()=="Edibles")
       {
          var ageval = $(this).val();
         // if(ageval.trim()!='' && ageval==2){ 
          if(ageval.trim()!='' && ageval==2){
              $("#age_restriction_error").html('');
          }
         
       }
});
 

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
</script>

<script type="text/javascript">
  function product_name_check(ref) {

    var produvt_name = ref.value.toLowerCase();

      var is_cbd_exist = produvt_name.split(/\s+|\./).includes('cbd');

      var is_thc_exist = produvt_name.split(/\s+|\./).includes('thc');

      if (is_cbd_exist == true  || is_thc_exist == true  ) {

        document.getElementById("product_name_error").innerHTML = "Remove the word 'CBD' or 'THC'. All cannabinoids should be displayed in the certificate of analysis of this product";
      }
      else {

        document.getElementById("product_name_error").innerHTML = "";
      }
  }

  function add_new_row(row_id){
     $(".filled").hide();
      
     // if($('#validation-form').parsley().validate()==false) return;
      var sel_can = $("#sel_cannabinoids"+row_id).val();
      var txt_percent = $("#txt_percent"+row_id).val();
   
      if(sel_can == ""){
        $("#err_sel_cannabinoids_"+row_id).html("Please select cannabinoids");
        return false;
      } 

      if(txt_percent == ""){
        $("#err_txt_percent_"+row_id).html("Please enter percent");
        return false;
      }      
  

      $(".err_sel_cannabinoids").html("");
      $(".err_txt_percent").html("");
       var sel_cannabinoids_arr        =document.getElementsByName("sel_cannabinoids[]"); 
      var txt_percent_arr        = document.getElementsByName("txt_percent[]");

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
              url:module_url_path+'/addnewrow',
              type:'POST',
              data:{
                      row_id:row_id,
                      _token:$("input[name=_token]").val()
                    },
             
              success:function(response)
              { 
                  $("#div_append_cannabinoids").append(response);
              }
      });
  }


    function remove_row(row_id,prod_can_id,prod_id,data){  
           

         if(prod_can_id != '' || prod_id != ''){
             $.ajax({
               url:module_url_path+'/removerow',
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
@stop