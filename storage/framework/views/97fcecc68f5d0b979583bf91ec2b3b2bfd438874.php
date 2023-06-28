    
<?php $__env->startSection('main_content'); ?>
<style type="text/css">
  .div-icon{
      width: 16px;
    margin-right: 2px;
    margin-top: -3px;
}
.err{
    color: #e00000;
    font-size: 13px;
}
.myprofile-main .profile {
    margin-left: 125px;
    width: 100px;
}
.note-show-abtform.bgnone {
    background-color: transparent;
    padding: 0;
}
</style>
<div class="my-profile-pgnm">
 Profile

  <ul class="breadcrumbs-my">
    <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Profile</li>
  </ul>
</div>
<div class="new-wrapper">

<div class="main-my-profile">
   <div class="innermain-my-profile paddingnones">


<?php
 
$user_profile_status = isset($user_details_arr['approve_status'])?$user_details_arr['approve_status']:'';

?>
  
 

  

  <?php if(isset($user_profile_status) && $user_profile_status==1): ?>

    <div class="text-right">
      <a href="mailto:<?php echo e($admin_arr['email']); ?>" class="eye-actn" title="mailto:<?php echo e(isset($admin_arr['email'])?$admin_arr['email']:''); ?>">
        Request Change
      </a>
     </div>
   
    <?php else: ?>
       <a href="<?php echo e(url('/')); ?>/seller/profile/edit" class="editmyprofiles" title="Edit Personal Details">
        <img src="<?php echo e(url('/')); ?>/assets/seller/images/edit-profile.png" alt="" class="div-icon" /> Edit 
       </a> 
    <?php endif; ?>


                 <div class="myprofile-main">
                     <div class="myprofile-lefts">First Name</div>
                     <div class="myprofile-right">
                        <?php if(isset($user_details_arr['first_name']) && !empty($user_details_arr['first_name'])): ?>
                        <?php echo e($user_details_arr['first_name']); ?>

                        <?php else: ?>
                         NA
                        <?php endif; ?>
                     </div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Last Name</div>
                     <div class="myprofile-right">
                      <?php if(isset($user_details_arr['last_name']) && !empty($user_details_arr['last_name'])): ?>
                        <?php echo e($user_details_arr['last_name']); ?>

                        <?php else: ?>
                         NA
                        <?php endif; ?>

                     </div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Email Address</div>
                     <div class="myprofile-right"><?php echo e(isset($user_details_arr['email'])?$user_details_arr['email']:'NA'); ?></div>
                     <div class="clearfix"></div>
                 </div>
               

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">Address</div>
                     <div class="myprofile-right"><?php echo e(isset($user_details_arr['street_address'])?ucwords($user_details_arr['street_address']):'NA'); ?></div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">City</div>
                     <div class="myprofile-right"><?php echo e(isset($user_details_arr['city'])?ucwords($user_details_arr['city']):'NA'); ?></div>
                     <div class="clearfix"></div>
                 </div>

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">State</div>
                     <div class="myprofile-right"><?php echo e(isset($user_details_arr['get_states_arr']['name'])?$user_details_arr['get_states_arr']['name']:'NA'); ?></div>
                     <div class="clearfix"></div>
                 </div>

                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Country</div>
                     <div class="myprofile-right"><?php echo e(isset($user_details_arr['get_countries_arr']['name'])?$user_details_arr['get_countries_arr']['name']:'NA'); ?></div>
                     <div class="clearfix"></div>
                 </div>

                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Zip Code</div>
                     <div class="myprofile-right"><?php echo e(isset($user_details_arr['zipcode'])?$user_details_arr['zipcode']:'NA'); ?></div>
                     <div class="clearfix"></div>
                 </div>
               
                

               <!----------------------start of profile verification------------->
               


               <div class="myprofile-main">
                  <div class="myprofile-lefts">Profile Verification</div>

                     <?php if(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='0' && ($user_details_arr['first_name']=="" ||  $user_details_arr['last_name']=="" || $user_details_arr['email']=="" || $user_details_arr['street_address']=="" || $user_details_arr['country']=="" || $user_details_arr['state']=="" || $user_details_arr['zipcode']=="" || $user_details_arr['city']=="")): ?>

                      <div class="myprofile-right"><div class="status-dispatched">Profile details not uploaded</div></div>

                      <?php elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='0' && $user_details_arr['first_name']!="" &&  $user_details_arr['last_name']!="" &&  $user_details_arr['email']!="" && $user_details_arr['street_address']!="" &&  $user_details_arr['country']!="" &&  $user_details_arr['state']!="" &&  $user_details_arr['zipcode']!="" &&  $user_details_arr['city']!=""): ?>

                      <div class="myprofile-right">
                        <div class="status-dispatched">Pending</div>
                      </div>  

                       <?php elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='3' && $user_details_arr['first_name']!="" &&  $user_details_arr['last_name']!="" &&  $user_details_arr['email']!="" &&  $user_details_arr['street_address']!="" &&  $user_details_arr['country']!="" &&  $user_details_arr['state']!="" &&  $user_details_arr['zipcode']!="" &&  $user_details_arr['city']!=""): ?>

                      <div class="myprofile-right">
                        <div class="status-dispatched">Submitted</div>
                      </div>  
                      

                     <?php elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']==1): ?>
                      <div class="myprofile-right">
                        <div class="status-completed">Approved</div>
                      </div>

                     <?php elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']==2): ?>

                       
                      <div class="myprofile-right">
                          <div class="status-shipped">Rejected</div>
                      </div>
                      <div class="main-rejects">
                        <div class="myprofile-lefts">Reject Reason</div>
                          <div class="myprofile-right"><?php echo e(isset($user_details_arr['note'])?$user_details_arr['note']:''); ?></div>
                      </div>
                      <div class="clearfix"></div>
                   
                     <?php endif; ?>    
                  </div> <!---------end of profile verification status------>




               <!-----------------------start of id proof verification div------->

              

             <!-----------------------end of id proof verification div------->

             

              <div class="myprofile-main">
                <div class="myprofile-lefts">Business Verification</div>
                <?php 
                    if($user_details_arr['user_details']['approve_status']==0){
                      $status = 'Pending';
                      $cls = 'status-dispatched';
                    }
                    else if($user_details_arr['user_details']['approve_status']==1){
                      $status = 'Approved';
                      $cls = 'status-completed';
                    }
                    else if($user_details_arr['user_details']['approve_status']==2){
                      $status = 'Rejected';
                      $cls = 'status-shipped';
                    }
                    else if($user_details_arr['user_details']['approve_status']==3){
                      $status = 'Submitted';
                      $cls = 'status-dispatched';
                    }
                ?>
                  <div class="myprofile-right">
                    <div class="<?php echo e($cls); ?>"><?php echo e($status); ?> </div>
                     
                     <div class="approved-business-profile-buuton">
                       <a href="<?php echo e(url('/')); ?>/seller/profile/edit" class="" title="Edit Business Details">  <img src="<?php echo e(url('/')); ?>/assets/seller/images/edit-profile.png" class="div-icon" alt="" /> Edit </a>
                     </div>
                    
                  </div>  
              </div>   
             <!---------------end of business verification---->
        
   </div>


<br/>
<div class="maxwidthhere">

<?php if(isset($list_document_required) && !empty($list_document_required)): ?>
    <div class="note-show-abtform">
     Upload: <?php echo e($list_document_required); ?> <span>*</span>
     </div>
     <?php endif; ?>
   <div class="note-show-abtform <?php if(isset($str_document_required) && !empty($str_document_required) && $str_document_required!="No additional documents required") {echo"bgnone"; } ?>">
         <?php if(isset($str_document_required) && !empty($str_document_required) && $str_document_required=="Upload Documents"): ?>  

                 <?php if(isset($user_details_arr['user_details']['documents_verification_status']) && ($user_details_arr['user_details']['documents_verification_status']=='0' || $user_details_arr['user_details']['documents_verification_status']=='2' )): ?>


                 <a href="<?php echo e(url('/')); ?>/seller/profile/edit" class="editmyprofiles" title="Upload Documents">
                  <img src="<?php echo e(url('/')); ?>/assets/seller/images/edit-profile.png" alt="" class="div-icon" /> <?php echo e($str_document_required); ?>

                 </a> 

                 <?php else: ?>

                   <div class="maxwidthsss">
                    <a href="mailto:<?php echo e($admin_arr['email']); ?>" class="eye-actn pull-right" title="mailto:<?php echo e(isset($admin_arr['email'])?$admin_arr['email']:''); ?>">
                      Request Change
                    </a>
                  </div>


                 <?php endif; ?>


           <?php elseif((isset($str_document_required) && !empty($str_document_required) && $str_document_required=="No additional documents required")): ?>
          <?php echo e($str_document_required); ?>

      <?php endif; ?>
    </div>


    
            <!-----------------start-product-dimension---------------------->
           
           <!---------------end-product-dimension------------------------>


                   <?php if(isset($str_document_required) && !empty($str_document_required) && $str_document_required=="Upload Documents"): ?>    
                  <div class="myprofile-main">
                  <div class="myprofile-lefts">Documents Verification</div>

                     <?php if(isset($user_details_arr['user_details']['documents_verification_status']) && $user_details_arr['user_details']['documents_verification_status']=='0'): ?>

                      <div class="myprofile-right"><div class="status-dispatched">Documents not uploaded</div></div>

                      <?php elseif(isset($user_details_arr['user_details']['documents_verification_status']) && $user_details_arr['user_details']['documents_verification_status']=='3'): ?>

                      <div class="myprofile-right">
                        <div class="status-dispatched">Submitted</div>
                      </div>  


                     <?php elseif(isset($user_details_arr['user_details']['documents_verification_status']) && $user_details_arr['user_details']['documents_verification_status']=='1'): ?>
                      <div class="myprofile-right">
                        <div class="status-completed">Approved</div>
                      </div>

                     <?php elseif(isset($user_details_arr['user_details']['documents_verification_status']) && $user_details_arr['user_details']['documents_verification_status']=='2'): ?>
                       
                      <div class="myprofile-right">
                          <div class="status-shipped">Rejected</div>
                      </div>
                      <div class="main-rejects">
                        <div class="myprofile-lefts">Reject Reason</div>
                          <div class="myprofile-right"><?php echo e(isset($user_details_arr['user_details']['note_doc_reject'])?$user_details_arr['user_details']['note_doc_reject']:''); ?></div>
                      </div>
                      <div class="clearfix"></div>
                   
                     <?php endif; ?>    
                  </div> <!---------end of profile verification status------>
                <?php endif; ?>  


               <!-----------------------start of id proof verification div------->

              

             <!-----------------------end of id proof verification div------->
 
             <!---------------end of business verification---->

            
        
   </div>

</div>
</div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>