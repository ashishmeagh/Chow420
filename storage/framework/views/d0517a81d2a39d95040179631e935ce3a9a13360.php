<?php $__env->startSection('main_content'); ?>
<style>
/*css added for making title to h1*/
h1{
    font-size: 30px;
    font-weight: 600;
}
</style>
  
<div class="terms-pg-section">
   <div class="container">
       
        <h1><?php echo e(isset($res_cms[0]->page_title)?ucwords($res_cms[0]->page_title):''); ?></h1>
        <div class="last-txts">Last updated: <?php echo e(isset($res_cms[0]->updated_at)?date('d M Y',strtotime($res_cms[0]->updated_at)):''); ?></div>
        <div class="border-terms"></div>
        <?php echo isset($res_cms[0]->page_desc)?$res_cms[0]->page_desc:''; ?>

   </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.master',['page_title'=>'Refund Policy'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>