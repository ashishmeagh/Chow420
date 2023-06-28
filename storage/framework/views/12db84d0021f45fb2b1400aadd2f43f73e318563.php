<?php $__env->startSection('main_content'); ?>


<div class="padding-topbottom">



  <div class="title-details-faq"><b><?php echo e(isset($faq_arr['get_faq_category']['faq_category']) ? $faq_arr['get_faq_category']['faq_category'] : ''); ?></b></div>

  <div class="what-cbd-faq-details"><?php echo $faq_arr['question']; ?></div>
  <div class="update-date-faq"><?php echo e(isset($faq_arr['created_at'])? date('d M Y',strtotime($faq_arr['created_at'])):''); ?> | <?php echo e(isset($faq_arr['created_at'])?date("g:i A",strtotime($faq_arr['created_at'])):''); ?></div>

  <div class="description-text-content">
    <?php echo $faq_arr['answer']; ?>

  </div>

</div>




<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('front.layout.master',['page_title'=>'FAQ'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>