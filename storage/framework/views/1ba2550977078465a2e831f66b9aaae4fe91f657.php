<!-- HEader -->        
<?php echo $__env->make('seller.layout._header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>    
<?php echo $__env->make('seller.layout._sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>    

<!-- BEGIN Content -->
<div id="main-content" class="main-content-div">
    <?php echo $__env->yieldContent('main_content'); ?>
</div>
    <!-- END Main Content -->

<!-- Footer -->        
<?php echo $__env->make('seller.layout._footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>   
              