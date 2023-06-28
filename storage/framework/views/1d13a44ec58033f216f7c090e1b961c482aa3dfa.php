<?php $__env->startSection('main_content'); ?>
<style>
/*css added for making title to h1*/	
h1 {
    font-size: 30px;
    font-weight: 600;
}	
@media (max-width: 650px){
  .headerchnagesmobile .logo-block.mobileviewlogo{
        width: 55vw;
  }
}
@media (max-width: 520px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 53vw;
}
}
@media (max-width: 450px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 45%;
}
}
@media (max-width: 414px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 35%;
}
}
@media (max-width: 350px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 30%;
}
.main-logo {
    width: 70px;
    margin-top: 11px !important;
}
}
</style>

  
<div class="terms-pg-section">
    <div class="container">

       
        <?php echo isset($res_cms[0]->page_desc)?$res_cms[0]->page_desc:''; ?>



   </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.master',['page_title'=>$res_cms[0]->meta_keyword], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>