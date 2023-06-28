<?php $__env->startSection('main_content'); ?>


<div class="padding-topbottom">

  
  

  
  

 <div class="main-div-faq-see-all">
    <div class="left-faq-see-all">
    	<div class="title-faq-see-basic"><?php echo e(isset($category_name) ? $category_name : ''); ?></div>
    	 <a href="<?php echo e(url('/')); ?>/helpcenter" class="backhomepage"><i class="fa fa-angle-left"></i> Back Home</a>
    </div>
    <div class="right-faq-see-all">
    


    <?php if(isset($faq_arr) && count($faq_arr)>0): ?>

	    <?php $__currentLoopData = $faq_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		    <div class="cbd-article-item-is">	
				<a href="<?php echo e(url('/helpcenter/helpcenter_details/').'/'.base64_encode($faq['id'])); ?>" class="link-all-faq-title">
					<span class="titlewhatis-cbd"><?php echo $faq['question']; ?></span>
					<span class="arrowwhatis-cbd"><i class="fa fa-angle-right" ></i></span>
			    </a>
			    <div class="description-article-itms"><?php echo $faq['answer']; ?></div>
			    <div class="updatelast-date"><?php echo e(isset($faq['created_at'])? date('d M Y',strtotime($faq['created_at'])):''); ?> | <?php echo e(isset($faq['created_at'])?date("g:i A",strtotime($faq['created_at'])):''); ?></div>
			</div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

    <?php endif; ?>
    

    </div>
    <div class="clearfix"></div>

 </div>


</div>




<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('front.layout.master',['page_title'=>'Help Center'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>