<?php $__env->startSection('main_content'); ?>

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

 <script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script>

 <div class="my-profile-pgnm">
  Add Product
 
     <ul class="breadcrumbs-my">
     <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="<?php echo e(url('/')); ?>/seller/product">Products</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Add Product</li>
    </ul>
</div>
<div class="new-wrapper">

<div class="main-my-profile"> 
   <div class="innermain-my-profile add-product-inrs space-o">
    <form id="validation-form">
        <?php echo e(csrf_field()); ?>

   
       <div class="row">  
         <h4> <span id="showerr"></span> </h4>

          <div class="col-md-12">
                 <div class="form-group">
                    <label for="product_name">Product Name <span>*</span></label>
                    <input type="text" name="product_name" id="product_name" class="input-text" placeholder="'Brand name' 'spectrum' 'CBD' 'product category' 'product flavor (if any)' 'product milligrams'" data-parsley-required-message="Please enter product name" data-parsley-required ='true' >
                  <ul class="parsley-errors-list filled" id="parsley-id-5">
                    <li  class="parsley-required" id="product_name_error"> </li>
                  </ul>

                </div>
          </div>

            <div class="col-md-12">
                 <div class="form-group">
                    <label for="sku">SKU <span></span></label>
                    <input type="text" name="sku" id="sku" class="input-text" placeholder="Enter Sku" data-parsley-required-message="Please enter sku">
                  <ul class="parsley-errors-list filled">
                    <li  class="parsley-required" id="sku_error"> </li>
                  </ul>

                </div>
          </div>


          <div class="col-md-12">
                 <div class="form-group">
                    <label for="brand">Brand <span>*</span></label>
                    <input type="text" name="brand" id="brand" class="input-text" placeholder=" Enter Brand Name" data-parsley-required ='true' data-parsley-required-message="Please enter brand name" autocomplete="off">
                    <div id="brandList">
                     </div>
                </div>
          </div>
         
           <div class="col-md-6">
                 <div class="form-group">
                    <label for="first_level_category_id">Category <span>*</span></label>
                    <div class="select-style">
                        <select class="frm-select" name="first_level_category_id" id="first_level_category_id" onchange="return get_second_level_category()" data-parsley-required ='true' data-parsley-required-message="Please select category">
                            <option value="">Select Category</option>
                            <?php $__currentLoopData = $arr_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e(isset($category['id']) ? $category['id'] : ''); ?>"><?php echo e(isset($category['product_type']) ? $category['product_type'] : ''); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="unit_price">Price ($)<span>*</span></label>
                <input type="text" name="unit_price" id="unit_price" class="input-text" placeholder="Enter Price" data-parsley-required="true" data-parsley-required-message="Please enter price" data-parsley-maxlength="10" data-parsley-min="1" data-parsley-type="number">
              </div>
            </div> 
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="price_drop_to">Price Drop to ($)</label>
                <input type="text" name="price_drop_to" id="price_drop_to" class="input-text" placeholder="Enter New Price Drop " data-parsley-pattern="^[0-9.]+$"
                  data-parsley-maxlength="10" oninput="check_price_drop()">
                  <span class="price-pdct-fnts">(Please fill this field only if you want to drop the price of product)</span><br>
                  <span id="price_drop_error" style="font-size:13px"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="" for="shipping_type"> Shipping Type <span class="red">*</span></label>                   
                  <div class="radio-btns radiobuttoninline">
                    <div class="radio-btn">                                  
                      <input type="radio" name="shipping_type" class="shipping_type" id="shipping_type" data-parsley-required="true" value="0" data-parsley-errors-container=".shipping_type_err" data-parsley-required-message="Please select any one shipping type" onchange="$('#shipping_charges_block').hide(); $('#shipping_charges').removeAttr('data-parsley-required').removeAttr('data-parsley-min');">
                      <label for="shipping_type">Free Shipping</label> 
                      <div class="check"></div>
                    </div>
                    <div class="radio-btn">
                      <input type="radio" name="shipping_type" class="shipping_type" id="shipping_type1" data-parsley-required="true" value="1" data-parsley-errors-container=".shipping_type_err" data-parsley-required-message="Please select any one shipping type" onchange="$('#shipping_charges_block').show(); $('#shipping_charges').attr('data-parsley-required',true).attr('data-parsley-min','1'); "> 
                      <label for="shipping_type1">Flat Shipping</label>
                      <div class="check"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="shipping_type_err"></div>
                  </div>                                                    
                <span><?php echo e($errors->first('shipping_type')); ?></span>
              </div> 
            </div>

            <div class="col-md-6" id="shipping_charges_block" style="display: none">
              <div class="form-group" >
                <label class="" for="shipping_charges">Shipping Charges  ($) <span >*</span></label>
                <input type="text" name="shipping_charges" id="shipping_charges" class="input-text" placeholder="Enter shipping charges" data-parsley-required ='true' data-parsley-required-message ="Please enter shipping charges" data-parsley-maxlength="10"  data-parsley-type="number" 

                 oninput="if(parseFloat($(this).val()) >= parseFloat($('#unit_price').val())){ $(this).val(''); $('#shipping_charges_err').html('Shipping charges should not be greater than unit price').css('color','red');}else{ $('#shipping_charges_err').html(''); }" 

                 >
                <span id="shipping_charges_err"><?php echo e($errors->first('shipping_charges')); ?></span>
              </div>
            </div> 

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="shipping_duration">Shipping Duration (Days) <span>*</span></label>
                    <input type="number" name="shipping_duration" id="shipping_duration" class="input-text decimal" placeholder="Enter Shipping Duration " data-parsley-required ='true'  data-parsley-type="number" data-parsley-min="0.5" data-parsley-max="31" step="0.5"data-parsley-required-message ='Please enter shipping duration' data-parsley-min-message="Shipping duration should be greater than or equal to 0" data-parsley-max-message="Shipping duration should be less than or equal to 31 days." data-parsley-type-message="Please enter valid shipping duration.">
                </div>
            </div>
                        
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="product_stock"> Quantity  <span>*</span></label>
                    <input type="number" name="product_stock" id="product_stock" class="input-text decimal" placeholder="Enter Total Quantity Available" data-parsley-required ='true' data-parsley-required-message="Please enter availiable quantity" data-parsley-min="1" min="1">
                </div>
            </div>

            <div class="col-md-6" id="concentration_div">
                 <div class="form-group">
                    <label for="per_product_quantity">Concentration (mg) <span>*</span></label>
                    <input type="number" name="per_product_quantity" id="per_product_quantity" class="input-text decimal" placeholder="Enter Concentration (mg)" data-parsley-min="1"
                     
                       data-parsley-required ='true' data-parsley-required-message ='Please enter concentration' data-parsley-min-message="This value should be greater than or equal to 1">
                </div>
            </div>

             <div class="col-md-6">
              <?php 
                $spectrumarr = get_spectrums();
                $cannabinoids_arr = get_cannabinoids_more();
              ?>
                 <div class="form-group">
                    <label for="spectrum">Spectrum Type <i class="red">*</i>  </label>
                    <div class="select-style">
                        <select class="frm-select" name="spectrum" id="spectrum" data-parsley-required="true" data-parsley-required-message="Please select Spectrum Type" onchange="return hidecoaforspectrum(this.value)">
                            <option value="">Select Spectrum</option>
                            <?php if(isset($spectrumarr) && !empty($spectrumarr)): ?>                      
                             <?php $__currentLoopData = $spectrumarr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spectrum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <option value="<?php echo e($spectrum['id']); ?>"><?php echo e($spectrum['name']); ?></option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>






              <div class="col-md-12" id="div_for_cannabinoids" style="display:none">

              <div class="form-group errorproduct-cannabinoid" id="div_append_cannabinoids">
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">Cannabinoids</div></div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">%</div></div>
                  <?php 
                  $row_cnt = 1;
                  ?>
                  <div class="" style="padding:10px;border: 1px solid #d1d1d1;">
                        <div class="col-xs-5 col-sm-6 col-md-6 col-lg-6">
                               <div class="select-style">
                                    <select name="sel_cannabinoids[]" id="sel_cannabinoids<?php echo e($row_cnt); ?>" class="form-control sel_cannabinoids frm-select"  data-parsley-required-message="Please select cannabinoids" onchange="check_duplicate_cannabinoids(this.id,this.value,<?php echo e($row_cnt); ?>)">
                                    <option value="">Select cannabinoids</option>                                
                                    <?php if(isset($cannabinoids_arr) && !empty($cannabinoids_arr)): ?>
                                      <?php $__currentLoopData = $cannabinoids_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cannabinoids): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($cannabinoids['id']); ?>"><?php echo e($cannabinoids['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                                <span style="color:red;" class="err_sel_cannabinoids" id="err_sel_cannabinoids_<?php echo e($row_cnt); ?>"></span>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <input type="text" name="txt_percent[]" id="txt_percent<?php echo e($row_cnt); ?>" class="form-control txt_percent" placeholder="%" min="0" max="100" 
                            data-parsley-pattern="[0-9]*(.?[0-9]{1,3}$)"  data-parsley-required-message="Please enter percent" >
                            <span style="color:red;" class="err_txt_percent" id="err_txt_percent_<?php echo e($row_cnt); ?>" ></span>
                        </div>

                        <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                          <img src="<?php echo e(url('/')); ?>/assets/images/plus-icon - Copy.png" alt="Add New Cannabinoids" onclick="add_new_row(<?php echo e($row_cnt); ?>)" height="20px" width= "20px"/>
                        </div>
                         <div class="clearfix"></div>
                  </div>
                </div>
       
              </div>
                    <div class="clearfix"></div>


          
         
           
            <div class="col-md-12">
                 <div class="form-group">
                    <label for="description">Product Description <span>*</span></label>
                    <textarea name="description" id="description" placeholder="Enter Product Description" data-parsley-required="true" data-parsley-required-message="Please enter product description"></textarea>
                    
                </div>
            </div> 



            <!-- Added 3 fields --> 

            <div class="col-md-12">
                 <div class="form-group">
                    <label for="ingredients">Ingredients</label> 
                   <textarea name="ingredients" id="ingredients" class="form-control" placeholder="Enter ingredients"  data-parsley-required-message="Please enter Ingredients"></textarea>                     
                </div>               
            </div> 


             <div class="col-md-12">
                 <div class="form-group">
                    <label for="ingredients">Suggested Use</label> 
                   <textarea name="suggested_use" id="suggested_use" class="form-control" placeholder="Enter suggested use"  data-parsley-required-message="Please enter suggested use"></textarea>                   
                </div>               
            </div> 


            <div class="col-md-12">
                  <div class="form-group">
                   <label for="ingredients">Amount per serving</label> 
                   <textarea name="amount_per_serving" id="amount_per_serving" class="form-control" placeholder="Enter amount per serving"  data-parsley-required-message="Please enter amount per serving"></textarea>
                  </div> 
            </div>

            <div class="col-md-12">
                <div class="form-group">
                  <label for="terpenes">Terpenes</label> 
                  <textarea name="terpenes" id="terpenes" class="form-control" placeholder="Enter terpenes"  ></textarea>
                </div> 
            </div>


            <div class="col-md-12">
               <div  id="dynamic_field" class="form-group">
                  <label for="image">Product Image (Image must have a white background)<span>* </span> </label>
                  <div class="clone-divs">

                    <input type="file" name="product_image" id="product_image"   data-parsley-required="true" data-parsley-required-message="Please upload file" placeholder="Image must have a white background">
                   
                  </div>
                  <div id="product_image_preview"></div>
                </div>
              
            </div> 


             <div class="col-md-12" id="coa_div">
               <div  id="dynamic_field" class="form-group">
                  <label for="image">Certificate Of Analysis <span>* </span> </label>
                  <div class="clone-divs">
                    <input type="file" name="product_certificate" id="product_certificate"   data-parsley-required="true" data-parsley-required-message="Please upload file">
                  </div>
                  <div id="product_certificate_preview"></div>
                </div>
                <span id="product_certificate_error"></span>  
            </div> 

            
             <div class="col-md-12" id="coa_link_div">
                 <div class="form-group">
                    <label for="coa_link">COA URL<span>* </span></label>
                    <div class="select-style">
                        <input class="input-text" data-parsley-type="url" name="coa_link" id="coa_link" placeholder="Enter COA Url" data-parsley-required-message="Please enter the coa url" data-parsley-required="true">
                    </div>                   
                </div>
            </div>





            <!-----------------start-product-dimension---------------------->
           
           <!---------------end-product-dimension------------------------>
         <hr>
           <div class="col-md-12">
            <div class="form-group">
             <label for="per_product_quantitydropship">Drop Shipping <i class="fa fa-question-circle" aria-hidden="true" title="Add your dropshipper or supplier information so we can forward your orders to their email automatically. You will be copied on all emails forwarded to your dropshipper"></i> </label>
            </div>
           </div> 
           <div class="col-md-4">
             <div class="form-group">
                <label for="drop_shipper_name"> DropShipper Name </label>
                <input type="text" name="drop_shipper_name" id="drop_shipper_name" class="input-text" placeholder="Enter DroppShipper Name"  autocomplete="off">
                <div id="DropShipperList"></div>
            </div>
          </div> 
          <div class="col-md-4">
             <div class="form-group">
                <label for="drop_shipper_email"> DropShipper Email   </label>
                <input type="email" name="drop_shipper_email" id="drop_shipper_email" class="input-text" placeholder="Enter DroppShipper Email" data-parsley-type="email">
                <span id="err_drop_shipper_email"></span>
            </div>
          </div> 
           <div class="col-md-4">
             <div class="form-group">
                <label for="drop_shipper_product_price"> DropShipper Price ($)</label>
                <input type="text" name="drop_shipper_product_price" id="drop_shipper_product_price" class="input-text decimal" placeholder="Enter DropShipper Price" data-parsley-type="number" data-parsley-maxlength="10" data-parsley-min="1">
            </div>
          </div> 

          <hr>


            <div class="col-md-6">
                 <div class="form-group">
                    <label for="product_video_source">Product Video Source </label>
                    <div class="select-style">
                        <select class="frm-select" name="product_video_source" id="product_video_source" onchange="changeVideoUrlStatus(this);" >
                            <option value="">Select Product Video Source</option>
                            <option value="youtube">Youtube</option>
                            <option value="vimeo">Vimeo</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 product_video_url_div" style="display: none;">
                 <div class="form-group">
                    <label for="product_video_url">Product Video URL Short Code <span>* </span></label>
                    <div class="select-style">
                        <input class="input-text" name="product_video_url" id="product_video_url" placeholder="Enter Product Video Url Short Code" data-parsley-required-message="Please enter the youtube/vimeo url short code" >
                    </div>
                    <span class="price-pdct-fnts">(For Ex: <b>3vauM7axnRs</b> is a short code of youtube link https://www.youtube.com/watch?v=<b>3vauM7axnRs</b>)</span>
                </div>
            </div>

          <!--<div class="col-md-12">
              <div  id="dynamic_field" class="form-group">
                  <label for="image">Additional Product Image</label>
                  <div class="clone-divs">

                    <input type="file" name="product_additional_image" id="product_additional_image">
                  
                  </div>
                  <div id="product_additional_image_preview"></div>
                </div>
           
            </div>  -->






            


            <input type="hidden" id="checkbox5" name="is_active" value="1" />
             <!-- <div class="col-md-12">
                 <div class="slr-prdt-mn">
                     <div class="check-box">
                         <input type="checkbox" checked="checked" class="css-checkbox is_active" id="checkbox5" name="is_active" value="1" />
                         <label class="css-label radGroup2" for="checkbox5">Is Active <span>*</span></label>
                      </div>                     
                      <div class="clearfix"></div>
                 </div>
            </div> -->
 
              <div class="col-md-12">
                 <div class="slr-prdt-mn">
                     <div class="check-box form-group">
                         <input type="checkbox" class="css-checkbox is_age_limit" id="checkbox6" name="terms" value="1" checked data-parsley-required="true" data-parsley-required-message="Please accept terms and conditions"/>
                         <label class="css-label radGroup2" for="checkbox6">I Accept &nbsp;<a href="<?php echo e(url('/')); ?>/terms-conditions" target="_blank">Terms and Conditions <span class="asteric_mark">*</span></a></label>
                      </div>
                      <div class="clearfix"></div>
                 </div>
              </div>
           
  

          
            <div class="col-md-12">
                <div class="button-list-dts">
                    <a href="javascript:void(0)" class="butn-def" id="btn_add">Add Product</a>
                    <a href="<?php echo e(url('/')); ?>/seller/product" class="butn-def cancelbtnss">Back</a>
                    
                </div>
            </div>
       </div>
   </form>
   </div>
</div>
</div>




<script type="text/javascript">
  var SITE_URL  = "<?php echo e(url('/')); ?>";
  var last_row  = ""; 
  var i = 1;
   $(".addMore").click(function(){


          var inputcount = $(".product_dimension_div").find('input .product_dimension_value').length;

          
             if(inputcount<10)
             { 
                   last_row_dim       = $('#product_dimension_'+i).val();
                   last_row_dim_value = $('#product_dimension_value_'+i).val();


                  if(last_row_dim==""){
                      $('#err_product_dimension_'+i).html('Please enter product dimension type.');
                      $('#product_dimension_'+i).focus();
                      return false;
                  } 
                  if(last_row_dim_value==""){
                      $('#err_product_dimension_value_'+i).html('Please enter product dimension value.');
                      $('#product_dimension_value_'+i).focus();
                      return false;
                  } 

                 i++; 
                 $('.product_dimension_div').append('<div id="row'+i+'"><div class="col-md-5"><div class="form-group"><label for="second_level_category_id">Product Dimension Type </label><input type="text" name="product_dimension[]" id="product_dimension_'+i+'" class="input-text" placeholder="Enter Product Dimension Type" onkeyup="clear_err_div_dim('+i+')"><span id="err_product_dimension_'+i+'" class="err"></span></div></div><div class="col-md-5"><div class="form-group"><label for="second_level_category_id">Product Dimension </label><input type="text" name="product_dimension_value[]" class="input-text product_dimension_value" placeholder="Enter Product Dimension" id="product_dimension_value_'+i+'" onkeyup="clear_err_dim_val('+i+')" class="err"><span id="err_product_dimension_value_'+i+'" class="err"></span></div></div><div class="col-md-2"><div class="form-group" style="margin-top:30px;"><a href="javascript:void(0)" class="remove" name="add_more_product_dimension" id="'+i+'"><i class="fa fa-minus"></i></a></div></div></div>');  
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

                 

  function check_price_drop() {
    
    var unit_price = parseFloat($('#unit_price').val());
    var price_drop_to =parseFloat($('#price_drop_to').val());
    
    if(price_drop_to >= unit_price){
        $('#price_drop_error').html('Price Drop should not be greater than or equal Unit Price').css('color','red');
        $('#btn_add').attr('disabled',true);

        
    }else{
        $('#price_drop_error').html('').css('color','black');
        $('#btn_add').attr('disabled',false);

    }
}
  $(document).ready(function()
  {
    
      var i=1;   

      $('#add_more').click(function(){  

        var inputcount = $("#dynamic_field").find('input').length;

        if(inputcount<5){

           i++;
           $('#dynamic_field').append('<div class="col-md-5"><div class="form-group"><label for="second_level_category_id">Product Dimension Type <span>*</span></label><input type="text" name="product_dimension[]" id="product_dimension" class="input-text" placeholder="Enter Product Dimension Type"></div><span class="err_duplicate_text"></span></div><div class="col-md-5"><div class="form-group"><label for="second_level_category_id">Product Dimension <span>*</span></label><input type="text" name="product_dimension_value[]"  class="input-text product_dimension_value" placeholder="Enter Product Dimension"></div><span class="err_duplicate_text"></span></div><div class="col-md-2"><a href="javascript:void(0)" class="addMore" name="add_more_product_dimension" id="add_more_product_dimension"><i class="fa fa-plus"></i></a></div>');  
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




     $(document).on('click', '#brandList .liclick', function(){  
        $('#brand').val($(this).text());  
        $('#brandList').fadeOut();  
    });  

     $(document).on('mouseleave', '#brandList', function(){  
        $('#brandList').fadeOut();  
    });  



    var csrf_token = $("input[name=_token]").val(); 


    $('#btn_add').click(function()
    {

   
        var product_name = document.getElementById("product_name").value.toLowerCase();

        var is_cbd_exist = product_name.split(/\s+|\./).includes('cbd');
        var is_thc_exist = product_name.split(/\s+|\./).includes('thc');

       /* if (is_cbd_exist == true || is_thc_exist == true ) {

          document.getElementById("product_name_error").innerHTML = "Remove the word 'CBD' or 'THC'. All cannabinoids should be displayed in the certificate of analysis of this product";

            event.preventDefault();

            return false;
        }
        else {

          document.getElementById("product_name_error").innerHTML = "";
        }*/



        var flag= 0;
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
              if($("#age_restriction").val()==""){
                flag=1;
                $("#age_restriction_err").html('Please select age restriction');
                $("#age_restriction_err").css('color','red');

            }else{
                 flag=0;
                 $("#age_restriction_err").html('');
            }
        }else{
             flag=0;
             $("#age_restriction_err").html('');
             $("#age_restriction").val('');
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

        if(flag==0 && flag2==0){
          //var ckeditor_description = CKEDITOR.instances['description'].getData();
          formdata = new FormData($('#validation-form')[0]);
          //formdata.set('description',ckeditor_description);
          // alert(ckeditor_description);
        $.ajax({                  
          url: SITE_URL+'/seller/product/save',
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
              else if('CertificateFAILURE' == data.status){
                $("#product_certificate_error").html('Only jpg,png,jpeg extenstions allowed');
                $("#product_certificate_error").css('color','red');
              }  
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
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

       if(spectrumval.trim()=="Hemp Seed")
      {

          $("#per_product_quantity").removeAttr('data-parsley-required');
          $("#product_certificate").removeAttr('data-parsley-required');
          $("#coa_div").hide();
          $("#coa_link_div").hide();
          $("#concentration_div").hide();
      }
      else{
         $("#per_product_quantity").attr('data-parsley-required',true);
         $("#product_certificate").attr('data-parsley-required',true);
          $("#coa_div").show();
          $("#coa_link_div").show();
          $("#concentration_div").show();
      }//spectrum val

       if(spectrumval.trim()=="Full Spectrum" || spectrumval.trim()=="Broad Spectrum" || spectrumval.trim()=="Isolate")
      {
          $("#div_for_cannabinoids").show();
          $(".sel_cannabinoids").attr('data-parsley-required',true);
          $(".txt_percent").attr('data-parsley-required',true);
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
       }
       else
       {
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
         $("#product_certificate").attr('data-parsley-required',true);
          $("#concentration_div").show();
          $("#coa_div").show();
          $("#coa_link_div").show();

      }//else



      if(fval.trim()=="Accessories")
      {
        $('#spectrum').val('5');
        //$('#spectrum').find('option:contains("Not Applicable")').attr('selected', 'selected');

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
    // var validImageTypes = ["image/jpg", "image/jpeg", "image/png","application/pdf",
    //                        "image/JPG", "image/JPEG", "image/PNG"];
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

    }

}

</script>


<script type="text/javascript">
  function product_name_check(ref) {

    var produvt_name = ref.value.toLowerCase();

      var is_cbd_exist = produvt_name.split(/\s+|\./).includes('cbd');
      var is_thc_exist = produvt_name.split(/\s+|\./).includes('thc');

      if (is_cbd_exist == true|| is_thc_exist == true) {

        document.getElementById("product_name_error").innerHTML = "Remove the word 'CBD' or 'THC'. All cannabinoids should be displayed in the certificate of analysis of this product";
      }
      else {

        document.getElementById("product_name_error").innerHTML = "";
      }
  }


/*  function add_new_row(row_id){
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
  }*/

    function add_new_row(row_id){

     // if($('#validation-form').parsley().validate()==false) return;
      var sel_can = $("#sel_cannabinoids"+row_id).val();
      var txt_percent = $("#txt_percent"+row_id).val();
      $("#parsley-id-34").hide();
      $("#parsley-id-36").hide();
   
      $(".filled").hide();      

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
              url:SITE_URL+'/seller/product/addnewrow',
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>