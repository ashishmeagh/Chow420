<?php $__env->startSection('main_content'); ?>

<style type="text/css">
  
.faqsec .panel-title > a,.faqsec .panel-title > a:focus {
  display: block;
  position: relative;
  outline:none;
}
.faqsec .panel-title > a:after {
  content: "\f078"; /* fa-chevron-down */
  font-family: 'FontAwesome';
  position: absolute;
  right: 0;
  top:-6px;

  width: 30px;
  height: 30px;
  border-radius: 50%;
  text-align: center;
  line-height: 26px;
  border:1px solid #e6e5eb;
  color:#333;
}
.faqsec .panel-title > a[aria-expanded="true"]:after {
  content: "\f077"; /* fa-chevron-up */
  background-color:#b833cc;
  color:#fff;
}

.faqsec {margin-top:0px; margin-bottom: 30px;}
.faqsec .panel-group {box-shadow: 0px 2px 15px 0px rgba(0,0,0,0.1),0px 10px 30px 0px rgba(0,0,0,0.05);}
.faqsec .panel-group .panel {border:none; box-shadow:none;}
.faqsec .panel-heading {background:#fff; padding:15px; border-bottom:1px solid #e6e5eb}
.faqsec .panel-body {background-color:#f8f8fa; border-left:3px solid #b833cc; border-bottom:1px solid #e6e5eb; line-height:25px; font-weight:normal; font-size:14px;}
.faqsec .panel-default {margin-top:0px;}
.faqttl {font-weight:600;}

@media (max-width: 768px) { 
  .sfw-footer.contactpgsfw li.help-cont{font-size: 17px;}
}
@media (max-width:575px) {
  .faqsec .panel-title > a {line-height:26px; padding-right:50px;}
  .faqsec .panel-heading {padding:10px;}
 
}
.our-mission-abts
{
  margin-top: 40px;
}
/*css added for making title as h1*/
h1 {
    float: left;
    color: #fff;
    margin-top: 13px;
    font-size: 30px;
    padding-top: 0px;
}
</style>


 
 <div class="container">
   <div class="our-mission-abts">
    <ul class="sfw-footer contactpgsfw">
    
    <li style="margin-top: 0px">
        <h1>FAQ (Frequently Asked Questions)</h1>
    </li> 
      
    </ul>
    <div class="clearfix"></div>
</div>

</div>
<section class="faqsec">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  
                  <?php if(isset($faq_arr) && (!empty($faq_arr))): ?>
                      <?php
                        $i=0;
                      ?>
                      <?php $__currentLoopData = $faq_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="heading-<?php echo e($faq['id']); ?>">
                            <h4 class="panel-title">
                              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo e($faq['id']); ?>" <?php if($i==0): ?> aria-expanded="true" <?php else: ?> aria-expanded="false" <?php endif; ?> aria-controls="collapse-<?php echo e($faq['id']); ?>"   
                                 <?php if($i==0): ?> <?php else: ?> class="collapsed" <?php endif; ?>>
                                <span><?php echo  $faq['question']  ?></span>
                              </a>
                            </h4> 
                          </div>
                  
                          <div id="collapse-<?php echo e($faq['id']); ?>"  <?php if($i==0): ?> class="panel-collapse collapse in" <?php else: ?> class="panel-collapse collapse" <?php endif; ?>  role="tabpanel" aria-labelledby="heading-<?php echo e($faq['id']); ?>">
                            <div class="panel-body">
                             <?php echo  $faq['answer'] ?>
                            </div>
                          </div>
                        </div>

                       <?php
                        $i++;
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>




                 
            </div><!---Panel group end here----->
        </div> <!-----end of col-sm-12----------->
      </div>
         <div class="pagination-chow"> 
            <?php if(!empty($arr_pagination)): ?>
                <?php echo e($arr_pagination->render()); ?>    
            <?php endif; ?> 
        </div>

    </div> <!-----end of container----------->
</section>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('front.layout.master',['page_title'=>'FAQ'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>