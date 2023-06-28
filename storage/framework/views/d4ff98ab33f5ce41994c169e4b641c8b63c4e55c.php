                

<?php $__env->startSection('main_content'); ?>
<!-- Page Content -->


<style type="text/css">
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
  .remain-stock {
    color: #873dc8;
    font-size: 13px;
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
<script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script>  
 
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    <?php
                     $user = Sentinel::check();
                    ?>

                    <?php if(isset($user) && $user->inRole('admin')): ?>
                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                    <?php endif; ?>  
                      <li><a href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
                      <li class="active">Edit Product</li>
                  </ol>
              </div> 
              <!-- /.col-lg-12 -->  
          </div> 
        
          <?php
            $remainingstock = 0;
            if(isset($product_inventory) && !empty($product_inventory))
            {
              $remainingstock = $product_inventory['remaining_stock'];
            } 


          ?>

          <input type="hidden" name="remaining_stock" value="<?php echo e($remainingstock); ?>">
       
    <!-- .row -->
                <div class="row"> 
                    <div class="col-sm-12">
                         <h4><span id="showerr"></span></h4>
                        <div class="white-box">
                        <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">

                                  <?php if($arr_product['is_approve']=='2' && ($arr_product['reason']!='')): ?>
                                  <div class="myprofile-main">
                                         <div class="myprofile-lefts">Disapproved Reason</div>
                                         <div class="myprofile-right reason-desc" style="color:red"> 
                                          
                                           <?php echo e($arr_product['reason']); ?>

                                         
                                          
                                         </div>
                                         <div class="clearfix"></div>
                                    </div> <br/>
                                     <?php endif; ?> 

                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    <?php echo e(csrf_field()); ?>


                                    <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_product['id']) ? $arr_product['id'] : ''); ?>" />

                                     

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="brand">Brand <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="brand" id="brand" class="form-control" placeholder="Brands" data-parsley-required ='true' value="<?php echo e(isset($brandname['name'])?$brandname['name']:''); ?>" autocomplete="off">
                                       <div id="brandList">
                                       </div>
                                    </div>
                                      <span><?php echo e($errors->first('brand')); ?></span>
                                  </div>      


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_name"> Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter Title" value="<?php echo e($arr_product['product_name']); ?>" data-parsley-required ='true' data-parsley-required-message="Please enter product name" 
                                       >
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                          <li  class="parsley-required" id="product_name_error"> </li>
                                        </ul>
                                    </div>
                                      <span><?php echo e($errors->first('product_name')); ?></span>
                                  </div>

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="sku"> SKU<i class="red"></i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="sku" id="sku" class="form-control" placeholder="Enter Sku" value="<?php echo e($arr_product['sku']); ?>" data-parsley-required-message="Please enter sku" 
                                       >
                                        <ul class="parsley-errors-list filled">
                                          <li  class="parsley-required" id="sku_error"> </li>
                                        </ul>
                                    </div>
                                      <span><?php echo e($errors->first('sku')); ?></span>
                                  </div>



                                  <div class="form-group row">
                                      <label for="first_level_category_id" class="col-md-2 col-form-label">Category<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select onchange="return get_second_level_category(this.value)" name="first_level_category_id" id="first_level_category_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select category">
                                            <option value="">Select category</option>
                                              <?php $__currentLoopData = $arr_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e(isset($category['id']) ? $category['id'] : ''); ?>"  
                                                 <?php if($arr_product['first_level_category_id'] == $category['id']): ?>
                                                  selected="selected"
                                                <?php endif; ?>>
                                               <?php echo e(isset($category['product_type']) ? $category['product_type'] : ''); ?></option>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                         </div>
                                  </div>
                                   <div class="form-group row">
                                      <label for="second_level_category_id" class="col-md-2 col-form-label"> Sub Category<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select name="second_level_category_id" id="second_level_category_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select sub category">
                                            <option value="">Select sub category</option>
                                              <?php $__currentLoopData = $arr_secondcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e(isset($cat['id']) ? $cat['id'] : ''); ?>"  <?php if($arr_product['second_level_category_id'] == $cat['id']): ?>
                                                  selected="selected"
                                                <?php endif; ?>>
                                                <?php echo e(isset($cat['name']) ? $cat['name'] : ''); ?>

                                              </option>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                         </div>
                                  </div>



                                   <?php 
                                    $spectrumarr = get_spectrums();
                                    $cannabinoids_arr = get_cannabinoids();
                                   ?>

                                 <div class="form-group row">
                                  <label for="product_video_source" class="col-md-2 col-form-label">Spectrum Type <i class="red">*</i> </label>
                                   <div class="col-md-10">
                                    <select name="spectrum" id="spectrum" class="form-control" data-parsley-required="true" data-parsley-required-message="Please select Spectrum Type" onchange="return hidecoaforspectrum(this.value)">
                                      <option value="">Select Spectrum</option>
                                        <?php if(isset($spectrumarr) && !empty($spectrumarr)): ?>                      
                                         <?php $__currentLoopData = $spectrumarr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spectrum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($spectrum['id']); ?>" <?php if($arr_product['spectrum']==$spectrum['id']): ?> selected <?php endif; ?>><?php echo e($spectrum['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php endif; ?>
                                        </select>
                                     </div>
                                  </div>
                                 <?php 
                                    $row_cnt = 1;
                                    ?>

                                   <?php if(isset($product_cannabinoid) && count($product_cannabinoid) > 0): ?>
                                   <div class="form-group row" id="div_for_cannabinoids" <?php if(!isset($product_cannabinoid)): ?> style="display:none" <?php endif; ?>>
                                        <div class="col-md-2 "></div>

                                      <div class="col-md-10"  id="div_append_cannabinoids">
                                               <div class="col-md-12 flex-mobile" style="border: 1px solid #d1d1d1; ">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">Cannabinoids</div></div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="cannabinoids-title">%</div></div>

                                              </div>

                                                <?php if(isset($product_cannabinoid) && count($product_cannabinoid) > 0): ?>
                                                <?php $__currentLoopData = $product_cannabinoid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $productCannabinoid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-12 flex-mobile" style="padding:10px;border: 1px solid #d1d1d1;" id="row_cannabinoids<?php echo e($row_cnt); ?>">
                                                          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                <select name="sel_cannabinoids[]" id="sel_cannabinoids<?php echo e($row_cnt); ?>" class="form-control sel_cannabinoids"  data-parsley-required-message="Please select cannabinoids" onchange="check_duplicate_cannabinoids(this.id,this.value,<?php echo e($row_cnt); ?>)">
                                                                <option value="">Select cannabinoids</option>                                
                                                                <?php if(isset($cannabinoids_arr) && !empty($cannabinoids_arr)): ?>
                                                                  <?php $__currentLoopData = $cannabinoids_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cannabinoids): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                      <option value="<?php echo e($cannabinoids['id']); ?>" <?php if($productCannabinoid['cannabinoids_id'] == $cannabinoids['id']): ?> selected="selected" <?php endif; ?>><?php echo e($cannabinoids['name']); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>
                                                                </select>
                                                                <span style="color:red;" id="err_sel_cannabinoids_<?php echo e($row_cnt); ?>" class="err_sel_cannabinoids"></span>
                                                                <input type="hidden" name="hid_product_can_id[]" value="<?php echo e($productCannabinoid['id']); ?>">
                                                          </div>

                                                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                              <input type="text" name="txt_percent[]" id="txt_percent<?php echo e($row_cnt); ?>" class="form-control txt_percent" placeholder="%" value="<?php echo e($productCannabinoid['percent']); ?>" data-parsley-trigger="keyup"     min="0" max="100" data-parsley-pattern="[0-9]*(.?[0-9]{1,3}$)"  data-parsley-required-message="Please enter percent" >
                                                                <span style="color:red;"  class="err_txt_percent" id="err_txt_percent_<?php echo e($row_cnt); ?>"></span>

                                                          </div>

                                                          <?php
                                                          $cnt_rows = count($product_cannabinoid) - 1;
                                                          ?>

                                                         
                                                          <?php if($key == 0): ?>
                                                           <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                                            <img src="<?php echo e(url('/')); ?>/assets/images/plus-icon - Copy.png" alt="Add New Cannabinoids" onclick="add_new_row(<?php echo e($row_cnt); ?>)" style="height: 20px;width: 21px;" />
                                                          </div>

                                                          <?php else: ?> 
                                                           <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                                            <img src="<?php echo e(url('/')); ?>/assets/images/popup-close-btn.png" alt="Delete Cannabinoid" onclick="remove_row(<?php echo e($row_cnt); ?>,<?php echo e($productCannabinoid['id']); ?>,<?php echo e($arr_product['id']); ?>,this)" />
                                                          </div>
                                                          <?php endif; ?>
                                                    </div>
                                                <?php 
                                                $row_cnt++;
                                                ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>






                                       </div>
                                   
                                  </div>



                                      <?php else: ?>

                                    <div class="form-group row" id="div_for_cannabinoids" <?php if($arr_product['spectrum']=="1" || $arr_product['spectrum']=="2" || $arr_product['spectrum']=="3"): ?> style="display: block" <?php else: ?> 
                                    style="display:none" <?php endif; ?> >
                                       <div class="col-md-2 "></div>
                                      <div class="col-md-10" id="div_append_cannabinoids">
                                                
                                                    <div class="col-md-12 flex-mobile" style="padding:10px;border: 1px solid #d1d1d1;" id="row_cannabinoids<?php echo e($row_cnt); ?>">
                                                          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                              <select name="sel_cannabinoids[]" id="sel_cannabinoids<?php echo e($row_cnt); ?>" class="form-control sel_cannabinoids"  data-parsley-required-message="Please select cannabinoids" onchange="check_duplicate_cannabinoids(this.id,this.value,<?php echo e($row_cnt); ?>)">
                                                              <option value="">Select cannabinoids</option>                                
                                                              <?php if(isset($cannabinoids_arr) && !empty($cannabinoids_arr)): ?>
                                                                <?php $__currentLoopData = $cannabinoids_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cannabinoids): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($cannabinoids['id']); ?>" @><?php echo e($cannabinoids['name']); ?></option>
                                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                              <?php endif; ?>
                                                              </select>
                                                              <span style="color:red;" class="err_sel_cannabinoids" id="err_sel_cannabinoids_<?php echo e($row_cnt); ?>"></span>
                                                              <input type="hidden" name="hid_product_can_id[]" value="">
                                                          </div>

                                                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                            <input type="text" name="txt_percent[]" id="txt_percent<?php echo e($row_cnt); ?>" class="form-control txt_percent" placeholder="%" value="" data-parsley-trigger="keyup"   
                                                            data-parsley-pattern="[0-9]*(.?[0-9]{1,3}$)"  
                                                            min="0" max="100" data-parsley-required-message="Please enter percent" >
                                                              <span style="color:red;" class="err_txt_percent" id="err_txt_percent_<?php echo e($row_cnt); ?>"></span>

                                                          </div>


                                                         <div class="col-md-2">
                                                            <img src="<?php echo e(url('/')); ?>/assets/images/plus-icon - Copy.png" alt="Add New Cannabinoids" onclick="add_new_row(<?php echo e($row_cnt); ?>)" style="height: 20px;width: 21px;" id="add_row_<?php echo e($row_cnt); ?>"  />
                                                          </div>

                                                      </div>
                                                






                                       </div>
                                     <div class="col-md-4">
                                     </div>
                                  </div>

                              

                                  <?php endif; ?>



                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="description">Description<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <textarea name="description" id="description" class="form-control" placeholder="Enter Description" data-parsley-required="true" data-parsley-required-message="Please enter description"> <?php echo e(strip_tags($arr_product['description'])); ?></textarea> 
                                    </div>
                                   
                                      <span><?php echo e($errors->first('description')); ?></span>
                                  </div>


                                 


                                  <!-- Added 3 fields -->

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="ingredients">Ingredients</label>
                                    <div class="col-md-10">                                       
                                       <textarea name="ingredients" id="ingredients" class="form-control" placeholder="Enter ingredients" data-parsley-required-message="Please enter Ingredients"> <?php echo e($arr_product['ingredients']); ?></textarea> 
                                    </div>
                                    
                                      <span><?php echo e($errors->first('ingredients')); ?></span>
                                  </div>


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="suggested_use">Suggested Use</label>
                                    <div class="col-md-10">                                       
                                       <textarea name="suggested_use" id="suggested_use" class="form-control" placeholder="Enter suggested use" data-parsley-required-message="Please enter suggested use"> <?php echo e($arr_product['suggested_use']); ?></textarea> 
                                    </div>
                                    
                                      <span><?php echo e($errors->first('suggested_use')); ?></span>
                                  </div>


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="amount_per_serving">Amount per serving</label>
                                    <div class="col-md-10">                                       
                                       <textarea name="amount_per_serving" id="amount_per_serving" class="form-control" placeholder="Enter amount per serving"  data-parsley-required-message="Please enter amount per serving"> <?php echo e($arr_product['amount_per_serving']); ?></textarea> 
                                    </div>
                                    
                                      <span><?php echo e($errors->first('amount_per_serving')); ?></span>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="terpenes">Terpenes</label>
                                    <div class="col-md-10">                                       
                                       
                                      <textarea name="terpenes" id="terpenes" class="form-control" placeholder="Enter terpenes"><?php echo e(isset($arr_product['terpenes'])?$arr_product['terpenes']:''); ?></textarea> 

                                    </div>
                                    
                                      <span><?php echo e($errors->first('terpenes')); ?></span>
                                  </div>


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_image"> Product Image <i class="red">*</i></label>

                                    <div class="col-md-10">
                                      <div  id="dynamic_field">
                                      <div class="clone-divs none-margin">
                                    <input type="hidden" name="old_product_image" value="<?php echo e(isset($arr_product['product_image'])?$arr_product['product_image']:''); ?>">
                                      
                                  
                                    <input type="hidden" name="old_img" id="old_img" value="<?php echo e(isset($arr_product_image[0]['image'])?$arr_product_image[0]['image']:''); ?>">

                                    <input type="file" name="product_image" id="product_image"  data-max-file-size="2M" class="dropify" 
                                    <?php if(isset($arr_product_image[0]['image'])): ?> data-default-file="<?php echo e($product_public_img_path); ?><?php echo e($arr_product_image[0]['image']); ?>" 
                                    <?php else: ?> data-default-file=""  <?php endif; ?>">
                                  
                                     


                                    
                                    </div>


                                  <!-----------------------code for multiple images----------------------------> 

                                  

                                   <!----------------------------------------------------------->

                                    <span id="image_error"><?php echo e($errors->first('product_image')); ?></span>
                                    </div>
                                    </div>
                                  </div>  

                                  <?php 
                                   //echo "===".$is_certificate_exists; 
                                  ?>

                                  <input type="hidden" name="is_certificate_exists" id="is_certificate_exists" value="<?php echo e(isset($is_certificate_exists)?$is_certificate_exists:''); ?>">

                                  <div class="form-group row" id="coa_div" <?php if( (isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories")  || ( isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")): ?> style="display: none" <?php else: ?> style="display: block" <?php endif; ?>>
                                     <label class="col-md-2 col-form-label" for="product_certificate"> Certificate Of Analysis <i class="red">*</i></label>

                                    <div class="col-md-10">
                                      <div  id="dynamic_field">
                                      <div class="clone-divs none-margin">
                                       <input type="hidden" name="old_product_certificate" id="old_product_certificate"  value="<?php echo e(isset($arr_product['product_certificate'])?$arr_product['product_certificate']:''); ?>">
 
                                       <input type="file" name="product_certificate" id="product_certificate"  data-max-file-size="2M" class="dropify" data-default-file="<?php echo e($product_public_img_path); ?><?php echo e($arr_product['product_certificate']); ?>" 

                                        <?php if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories") || (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")): ?> 
                                       <?php else: ?> 
                                          <?php if(file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate']) && isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate'])): ?>
                                          <?php else: ?>
                                           data-parsley-required="true"
                                          <?php endif; ?>

                                       <?php endif; ?>
                                       >
                                        
                                    </div>

                                    <span id="product_certificate_error" style="color:red">
                                     
                                      <?php if(file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate']) && isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate'])): ?>
                                      <?php else: ?>
                                       Please select COA
                                      <?php endif; ?>
                                    </span>
                                    </div>
                                    </div>
                                  </div>  





                                  
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="unit_price">Unit Price ($)<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="unit_price" id="unit_price" class="form-control" placeholder="Enter Unit Price" data-parsley-required="true"  data-parsley-maxlength="10" data-parsley-min="1" data-parsley-type="number" data-parsley-required-message="Please enter unit price" value="<?php echo e(number_format($arr_product['unit_price'],2)); ?>">
                                    </div>
                                      <span><?php echo e($errors->first('unit_price')); ?></span>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="price_drop_to">Price Drop to ($)</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="price_drop_to" id="price_drop_to" class="form-control" placeholder="Enter New Unit Price (Please fill this field only if you want to drop the price of product)" data-parsley-maxlength="10" data-parsley-type="number" value="<?php echo e(number_format($arr_product['price_drop_to'],2)); ?>" oninput="if(parseFloat($(this).val()) >= parseFloat($('#unit_price').val())){ $(this).val(''); $('.price_drop_er_msg').html('Price drop should not be greater than unit price').css('color','red');}else{ $('.price_drop_er_msg').html(''); }" >
                                      <span class="price_drop_er_msg"></span>
                                      </div>
                                      <span><?php echo e($errors->first('price_drop_to')); ?></span>
                                  </div>
                                                       
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="shipping"> Shipping Type <i class="red">*</i></label>
                                    <div class="col-md-10">
                                      <div class="radio-btns">   
                                        <div class="radio-btn">                                    
                                          <input type="radio" name="shipping_type" class="shipping_type" id="shipping_type" data-parsley-required="true" value="0" data-parsley-errors-container=".shipping_type_err" data-parsley-required-message="Please select any one shipping type" onchange="$('#shipping_charges_block').hide(); $('#shipping_charges').removeAttr('data-parsley-required').removeAttr('data-parsley-min');" <?php if($arr_product['shipping_type']==0): ?> checked <?php endif; ?>>
                                          <label for="shipping_type">&nbsp;Free Shipping &nbsp;&nbsp;</label>
                                          <div class="check"></div>
                                        </div>
                                        <div class="radio-btn">                                    
                                          <input type="radio" name="shipping_type" class="shipping_type" id="shipping_type1" data-parsley-required="true" value="1" data-parsley-errors-container=".shipping_type_err" data-parsley-required-message="Please select any one shipping type" onchange="$('#shipping_charges_block').show(); $('#shipping_charges').attr('data-parsley-required',true).attr('data-parsley-min','1'); " <?php if($arr_product['shipping_type']==1): ?> checked <?php endif; ?>>
                                          <label for="shipping_type1">&nbsp;Flat Shipping &nbsp;&nbsp;</label>
                                          <div class="check"></div>
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>
                                      <div class="shipping_type_err"></div>
                                    </div>                                      
                                    <span><?php echo e($errors->first('shipping_type')); ?></span>
                                  </div> 

  
            

                                  
                                  <div class="form-group row" id="shipping_charges_block" <?php if($arr_product['shipping_type']=='1'): ?> style="display: block" <?php elseif($arr_product['shipping_type']=='0'): ?> style="display: none" <?php endif; ?>>
                                    <label class="col-md-2 col-form-label" for="shipping_charges">Shipping Charges  ($) <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="shipping_charges" id="shipping_charges" class="form-control" placeholder="Enter shipping charges" 
                                       data-parsley-required-message ="Please enter shipping charges"
                                       data-parsley-maxlength="10"  data-parsley-type="number" value="<?php echo e(number_format($arr_product['shipping_charges'],2)); ?>" <?php if($arr_product['shipping_type']==1): ?> data-parsley-required="true"  data-parsley-required-message ="Please enter shipping charges"data-parsley-min="1" <?php endif; ?>  

                                       oninput="if(parseFloat($(this).val()) >= parseFloat($('#unit_price').val())){ $(this).val(''); $('#shipping_charges_err').html('Shipping charges should not be greater than unit price').css('color','red');}else{ $('#shipping_charges_err').html(''); }"  
                                       >
                                       <span id="shipping_charges_err"><?php echo e($errors->first('shipping_charges')); ?></span>
                                    </div>
                                    
                                  </div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="unit_price">Shipping Duration  (Days) <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="number" name="shipping_duration" id="shipping_duration" class="form-control" placeholder="Enter Shipping Duration" data-parsley-required="true"  data-parsley-maxlength="10" data-parsley-min="0.5" data-parsley-max="31"  data-parsley-type="number" step="0.5"  data-parsley-required-message ='Please enter shipping duration' data-parsley-min-message="Shipping duration should be greater than or equal to 0." data-parsley-max-message="Shipping duration should be less than or equal to 31 days." data-parsley-type-message="Please enter valid shipping duration." value="<?php echo e(isset($arr_product['shipping_duration'])? number_format($arr_product['shipping_duration'],1):''); ?>">
                                    </div>
                                      <span><?php echo e($errors->first('shipping_duration')); ?></span>
                                  </div>

                                   <div class="form-group row">
                                      <label for="user_id" class="col-md-2 col-form-label">Dispensary Name<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select  name="user_id" id="user_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select dispensary name">
                                            <option value="">Select dispensary</option>
                                              <?php $__currentLoopData = $sellerdropdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e(isset($seller->id) ? $seller->id : ''); ?>" 
                                                  <?php if($arr_product['user_id'] == $seller->id): ?>
                                                  selected="selected"
                                                <?php endif; ?>>
                                               
                                                 <?php echo e($seller->business_name); ?>

                                                </option>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                         </div>                           
                                   </div>


                                

                                  <input type="hidden" name="old_product_stock" value="<?php echo e($remainingstock); ?>">

                                   <input type="hidden" name="old_price_drop" value="<?php echo e($arr_product['price_drop_to']); ?>">

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_stock">  Quantity <i class="red">*</i>
                                   

                                    </label>
                                    <div class="col-md-10">                                       
                                       

                                       <input type="number" name="product_stock" id="product_stock" 
                                        data-parsley-required-message="Provided quantity should not be blank or 0 or less than 0"

                                       class="form-control decimal" placeholder="Enter Total Quantity" data-parsley-required="true" value="<?php echo e($remainingstock); ?>"
                                         
                                        min="1" data-parsley-min-message="">


                                        <span id="product_stock_err">
                                          <?php echo e($errors->first('product_stock')); ?>

                                        </span>
                                    </div>                                     
                                  </div> 


                                  <div class="form-group row" id="concentration_div"  <?php if((isset($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories") || (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")): ?> style="display: none" <?php else: ?> style="display: block" <?php endif; ?>>
                                    <label class="col-md-2 col-form-label" for="per_product_quantity"> Concentration (mg)<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="number" name="per_product_quantity" id="per_product_quantity" class="form-control decimal" placeholder="Enter Concentration (mg)"  value="<?php echo e($arr_product['per_product_quantity']); ?>"   
                                       <?php if((isset($db_cat_name) && !empty($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories")|| (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")): ?> 
                                       <?php else: ?> data-parsley-min="1" <?php endif; ?>
                                         
                                        data-parsley-required-message="Please enter concentration" 
                                       <?php if((isset($db_cat_name) && !empty($db_cat_name) && $db_cat_name=="Essential Oils" || $db_cat_name=="Accessories")|| (isset($db_spectrum_name) && $db_spectrum_name=="Hemp Seed")): ?> 
                                       <?php else: ?> data-parsley-required="true" <?php endif; ?> data-parsley-min-message="This value should be greater than or equal to 1"

                                     
                                      
                                       >
                                       <span id="concentration_err"><?php echo e($errors->first('per_product_quantity')); ?></span>
                                    </div>
                                      
                                  </div>  

            <!---------start-product-dimension---------------------------------->                      
             
                 
                 <!-------------end-product-dimension------------------------>


                                   <hr>
                                   <div class="form-group row">
                                      <label class="col-md-2 col-form-label" for="product_stockdropship">  Drop Shipping <i class="fa fa-question-circle" aria-hidden="true" title="Add your dropshipper or supplier information so we can forward your orders to their email automatically. You will be copied on all emails forwarded to your dropshipper"></i></label>
                                    </div>  

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="drop_shipper_name"> DropShipper Name</label>
                                    <div class="col-md-4">                                       
                                       <input type="text" name="drop_shipper_name" id="drop_shipper_name" class="form-control" placeholder="Enter DroppShipper Name" value="<?php echo e(isset($drop_shipper['name']) ?$drop_shipper['name']:''); ?>" autocomplete="off">
                                      <span id="DropShipperList"></span>

                                    </div>
                                  </div>   

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="drop_shipper_email">DropShipper Email</label>
                                    <div class="col-md-4">                                       
                                       <input type="email" name="drop_shipper_email" id="drop_shipper_email" class="form-control" placeholder="Enter DroppShipper Email" data-parsley-type="email"  value="<?php echo e(isset($drop_shipper['email']) ?$drop_shipper['email']:''); ?>" readonly="readonly">
                                       <span id="err_drop_shipper_email"></span>
                                    </div>
                                  </div>  


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="drop_shipper_product_price">DropShipper Price ($)</label>
                                    <div class="col-md-4">                                       
                                       <input type="text" name="drop_shipper_product_price" id="drop_shipper_product_price" class="form-control decimal" placeholder="Enter DropShipper Price" data-parsley-type="number" data-parsley-maxlength="10" data-parsley-min="1"  value="<?php echo e(isset($drop_shipper['product_price']) ?number_format($drop_shipper['product_price'],2):''); ?>" >
                                       <span><?php echo e($errors->first('drop_shipper_product_price')); ?></span>
                                    </div>
                                  </div>                                
                                  <hr>



                                  
                                  <div class="form-group row">
                                      <label for="product_video_source" class="col-md-2 col-form-label"> Product Video Source</label>
                                      <div class="col-md-10">
                                        <select onchange="changeVideoUrlStatus(this);"  name="product_video_source" id="product_video_source" class="form-control" >
                                          <option value="">Select Product Video Source</option>
                                          <option value="youtube" <?php if($arr_product['product_video_source']=="youtube"): ?> selected <?php endif; ?>>Youtube</option>
                                          <option value="vimeo" <?php if($arr_product['product_video_source']=="vimeo"): ?> selected <?php endif; ?>>Vimeo</option>
                                        </select>
                                     </div>
                                  </div>

                                  <div class="form-group row product_video_url_div" id="product_video_url_div" <?php if($arr_product['product_video_source']=='youtube' || $arr_product['product_video_source']=='vimeo'): ?> style="display: block" data-parsley-required ='true' <?php else: ?> style="display: none" <?php endif; ?>>
                                    <label class="col-md-2 col-form-label" for="product_video_url">Product Video URL Short Code <i class="red">*</i></label>
                                    <div class="col-md-10">             
                                       <input type="text" name="product_video_url" id="product_video_url" class="form-control"placeholder="Enter Product Video URL Short Code" <?php if($arr_product['product_video_source']=='youtube' || $arr_product['product_video_source']=='vimeo'): ?> data-parsley-required ='true' <?php endif; ?> data-parsley-required-message="Please enter the youtube/vimeo url short code"  value="<?php echo e($arr_product['product_video_url']); ?>"  >
                                       <span id="product_video_url_err"><?php echo e($errors->first('product_video_url')); ?></span>
                                       <span class="price-pdct-fnts">(For Ex: <b>3vauM7axnRs</b> is a short code of youtube link https://www.youtube.com/watch?v=<b>3vauM7axnRs</b>)</span>
                                    </div>
                                      
                                  </div> 


                                  <div class="form-group row">
                                      <label for="product_video_source" class="col-md-2 col-form-label">Rating</label>
                                      <div class="col-md-10">
                                         <input type="text" name="product_rating" id="product_rating" class="form-control" placeholder="You can enter rating between 1 to 5." value="<?php echo e(isset($arr_product['avg_rating']) ? $arr_product['avg_rating'] : ''); ?>" type="range" data-parsley-range="[1,5]">

                                         <span style="color:red;" id="error_rating"></span>

                                     </div> 
                                  </div>

                                  <div class="form-group row">
                                      <label for="product_video_source" class="col-md-2 col-form-label">Review</label>
                                      <div class="col-md-10">
                                        <input type="text" name="product_review" id="product_review" class="form-control"  placeholder="Enter Review" value="<?php echo e(isset($arr_product['avg_review']) ? $arr_product['avg_review'] : ''); ?>" data-parsley-type="integer">
                                     </div>
                                  </div>


                           <!--        <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_image"> Additional Product Image</label>

                                    <div class="col-md-10">
                                      <div  id="dynamic_field">
                                      <div class="clone-divs none-margin">
                                   
                                    <input type="hidden" name="old_additional_product_img" id="old_additional_product_img" value="<?php echo e(isset($arr_product['additional_product_image'])?$arr_product['additional_product_image']:''); ?>">

                                    <input type="file" name="product_additional_image" id="product_additional_image"  data-max-file-size="2M" class="dropify" 
                                    <?php if(isset($arr_product['additional_product_image'])): ?> data-default-file="<?php echo e($add_product_public_img_path); ?><?php echo e($arr_product['additional_product_image']); ?>" 
                                    <?php else: ?> data-default-file=""  <?php endif; ?>">
                               
                                    </div>


                                    <span id="additional_image_error"><?php echo e($errors->first('product_additional_image')); ?></span>
                                    </div>
                                    </div>
                                  </div>   -->


                                 


                                  


                                  <!---------------terms and condition div added------->
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="terms"></label>
                                    <div class="col-md-10">  
                                    <div class="checkbx">                                      
                                      <input type="checkbox" class="css-checkbox" id="checkbox6" name="terms" value="1" checked="" data-parsley-required="true" data-parsley-required-message="Please accept terms and conditions"> <label class="css-label radGroup2" for="checkbox6">I Accept &nbsp;<a href="<?php echo e(url('/')); ?>/terms-conditions" target="_blank">Terms and Conditions <span class="asteric_mark">*</span></a></label>
                                    </div>
                                     </div>                                     
                                  </div>     
                                 <!---------------terms and condition div added------->
   




                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Update</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                                              
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
 var inputcount  = $(document).find('.product_dimension_value').length;
 i = inputcount;


   $(".editMore").click(function(){
           if(inputcount<10)
          { 

                last_row_dim       = $('#product_dimension_'+i).val();
                last_row_dim_value = $('#product_dimension_value_'+i).val();

                  if(last_row_dim==""){
                      $('#err_product_dimension_'+i).html('Please enter product dimension type.');
                      return false;
                  } 
                 if(last_row_dim_value==""){
                      $('#err_product_dimension_value_'+i).html('Please enter product dimension value.');
                      return false;
                  } 
              
              i++; 
                $('.product_dimension_div_new').append('<div id="row'+i+'" class="row"><label for="product_dimension"  class="col-md-2 col-form-label">Product Dimension Type </label><div class="col-md-3"><div class="form-group"><input type="text" name="product_dimension[]" id="product_dimension_'+i+'" class="form-control" placeholder="Enter Product Dimension Type" onkeyup="clear_err_div_dim('+i+')"><span id="err_product_dimension_'+i+'" class="err"></span> </div></div><label for="product_dimension"  class="col-md-2 col-form-label">Product Dimension </label><div class="col-md-3"><div class="form-group"><input type="text" name="product_dimension_value[]" class="form-control product_dimension_value" placeholder="Enter Product Dimension Value" id="product_dimension_value_'+i+'" onkeyup="clear_err_dim_val('+i+')"><span id="err_product_dimension_value_'+i+'" class="err"></span></div></div><div class="col-md-2"><a href="javascript:void(0)" class="remove" name="add_more_product_dimension" id="'+i+'"><i class="fa fa-minus"></i></a></div></div>');


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
       // filePreview(this);

         if(fileType=="application/pdf"){
        
           }else{
            filePreview(this);
           }


    }
});


  var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

  $(document).ready(function()
  {
    var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

    var csrf_token = $("input[name=_token]").val(); 

     var i=1;  

      $('#add_more').click(function(){ 

        var inputcount = $("#dynamic_field").find('img').length;
         if(inputcount<5){ 
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'" class="clone-divs"><input type="file" name="product_image[]"  class="form-control name_list" data-parsley-required="true"/><a href="javascript:void(0)" name="remove" id="'+i+'" class="btn-clone-minus btn_remove"><i class="fa fa-minus"></i></a></div>');
          }else{
            alert('You can not select more images');
          }
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


      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
           if(button_id)
           {
                  $.ajax({
                  url: module_url_path+'/delete_images/'+button_id,
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

       //          $("#age_restriction_block").show();
       //          $("#age_restriction_error").html('You can not select 21+ age for this category');
       //          $("#age_restriction_error").css('color','red');
       //          flag2=1;
       //      }
       //  }
        //end check      

      
    /*check rating value is max 5 or not*/

     /* var rating_value = $("#product_rating").val();

      if(rating_value > 5)
      { 
          $("#error_rating").html("Please enter rating between 1 to 5.");
          return false;
      }*/
    /*-------------------------------------------*/ 
  


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
          beforeSend: function() {
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
              }
              else if('ImageFAILURE'== data.status)
              { 
                //$("#image_error").html(data.description);
               // $("#image_error").css('color','red');
               $("#image_error").html('Allowed only jpg,png,jpeg image file types ');
                $("#image_error").css('color','red');


                $("#additional_image_error").html('Allowed only jpg,png,jpeg image file types ');
                $("#additional_image_error").css('color','red');

                
              }
              else if('CertificateFAILURE' == data.status){
                $("#product_certificate_error").html('Allowed only jpg,png,jpeg image file types ');
                $("#product_certificate_error").css('color','red');
              }  
              else{
                swal('Alert!',data.description,data.status);
              }  
          }
          
        });   
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
          //if(ageval.trim()!='' && ageval==1){
          if(ageval.trim()!='' && ageval==2){
              $("#age_restriction_error").html('');
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
           $("#per_product_quantity").removeAttr('data-parsley-required');
           $("#per_product_quantity").removeAttr('data-parsley-min');
           $("#concentration_div").hide();
      }
      else{
          //if other spectrum file exists when edit then validation should hide
          if(is_certificate_exists==1)
          {
              $("#product_certificate").removeAttr('data-parsley-required');
              $("#coa_div").show();
          }else{
              $("#product_certificate").attr('data-parsley-required',true);
              $("#coa_div").show();   
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


      if(fval.trim()=="Essential Oils" || fval.trim()=="Accessories")
      {
         $("#per_product_quantity").removeAttr('data-parsley-required');
         $("#product_certificate").removeAttr('data-parsley-required');
         $("#per_product_quantity").removeAttr('data-parsley-min');
          $("#concentration_div").hide();
          $("#coa_div").hide();
      }
      else{
         $("#per_product_quantity").attr('data-parsley-required',true);
      //   $("#product_certificate").attr('data-parsley-required',true);
         $("#per_product_quantity").attr('data-parsley-min',1);
         $("#concentration_div").show();
         $("#coa_div").show();
          var old_product_certificate = $("#old_product_certificate").val();
       
         if(old_product_certificate=="" || old_product_certificate==undefined)
         {
         
           $("#product_certificate").attr('data-parsley-required',true);
           $("#product_certificate_error").html('Please select COA');
           $("#product_certificate_error").css('color','red');

         }else{
         
           $("#product_certificate").removeAttr('data-parsley-required');
            $("#product_certificate_error").html('');
         }

      }


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

   

  }else{
    $("#age_restriction_block").hide();
    $("#age_restriction_error").html('');

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
      
        
      $("#parsley-id-79").hide();
      $("#parsley-id-77").hide();
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
              url:module_url_path+'/addnewrow',
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>