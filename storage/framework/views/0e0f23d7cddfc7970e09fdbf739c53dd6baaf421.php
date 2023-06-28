  <?php 
    $cannabinoids_arr = get_cannabinoids();
  ?>

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
      <input type="text" name="txt_percent[]" id="txt_percent<?php echo e($row_cnt); ?>" class="form-control txt_percent" placeholder="%" value="" data-parsley-trigger="keyup"   data-parsley-pattern="[0-9]*(.?[0-9]{1,3}$)"     min="0" max="100" data-parsley-required-message="Please enter percent" >
        <span style="color:red;" class="err_txt_percent" id="err_txt_percent_<?php echo e($row_cnt); ?>"></span>

    </div>


    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
    <img src="<?php echo e(url('/')); ?>/assets/images/popup-close-btn.png" alt="Delete Cannabinoid" onclick="remove_row(<?php echo e($row_cnt); ?>,'','',this)" />
    </div>

</div>