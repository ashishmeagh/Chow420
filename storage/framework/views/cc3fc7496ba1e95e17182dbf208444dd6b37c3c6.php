<?php $__env->startSection('main_content'); ?>

<style type="text/css">
    
.status-div-icon.innermain-my-profile{margin-bottom: 30px;}
.titleidproof{max-width: 850px; margin: 0 auto;}
.innermain-my-profile .myprofile-main{    border-bottom: none;}
.status-div-icon.innermain-my-profile{padding: 0px;}
.main-my-profile.spacenon{padding-top: 0px;}
.form-group.age-csp{margin-top: 20px;}
.font-eightr label{font-weight: 600 !important;}
.form-group.font-eightr.age-csp {
    margin-bottom: 0;
}
.age-class{
  width: 35px;
}

.myprofile-main.myprofileinxt .myprofile-lefts{
  float: none; display: inline-block;
}
.myprofile-main.myprofileinxt .myprofile-right{float: none; margin-left: 0px; display: inline-block; margin-left: 20px;}
/*.innermain-my-profile.imgdnones{padding-bottom: 0px;}*/



</style>

<link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/buyer/css/dropify.min.css">
 <script src="<?php echo e(url('/')); ?>/assets/buyer/js/dropify.min.js"></script>
        <script>
            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        </script>

<div class="my-profile-pgnm">
  Age Verification 
  <ul class="breadcrumbs-my">
    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Age Verification</li>
  </ul>

</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">

 

  <span class="manag-note byr-lgn-manag age-imp-note">Important: To ensure the privacy of our users, we do not store age-verification details after approval</span>

    <div class="titleidproof"><h3></h3></div>
   <?php if(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['front_image'] && $user_details_arr['user_details']['back_image']): ?>


        <div class="status-div-icon innermain-my-profile">
          <div class="myprofile-main myprofileinxt">
            <div class="myprofile-lefts">
              <?php if(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']==1): ?>
                <?php if(isset($user_details_arr['user_details']['age_restriction_details']['age']) && $user_details_arr['user_details']['age_restriction_details']['age']=="18+"): ?>
                  <div class="age-img-inline age-class" title="18+ Age restriction">
                    <img src="<?php echo e(url('/')); ?>/assets/front/images/product-age-mini.png" alt=""> 
                  </div>                
                <?php endif; ?> 
                
                <?php if(isset($user_details_arr['user_details']['age_restriction_details']['age']) && $user_details_arr['user_details']['age_restriction_details']['age']=="21+"): ?>
                  <div class="age-img-inline age-class" title="21+ Age restriction">
                    <img src="<?php echo e(url('/')); ?>/assets/front/images/product-age-max.png" alt=""> 
                  </div>
                <?php endif; ?>
                  
              <?php else: ?>
                Age Verification Status
              <?php endif; ?> 
            </div>
           
            <?php if(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']==1): ?>
              <div class="myprofile-right">
                <div class="status-completed">Approved</div>
              </div>

            <?php elseif(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']=='0'): ?>

              <div class="myprofile-right">
                <div class="status-dispatched">Pending</div>
              </div>  

            <?php elseif(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']=='3'): ?>

              <div class="myprofile-right">
                <div class="status-dispatched">Submitted</div>
              </div>    
              
             <?php elseif(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']==2): ?>

              <div class="myprofile-right">
                  <div class="status-shipped">Rejected</div>
              </div>
              <div class="main-rejects">
                <div class="myprofile-lefts">Reason</div>
                  <div class="myprofile-right"><?php echo e(isset($user_details_arr['user_details']['note'])?$user_details_arr['user_details']['note']:''); ?></div>
              </div>
             

            <?php endif; ?>
             <div class="clearfix"></div>
          </div>

        </div>

 <?php endif; ?>



<div class="main-my-profile spacenon">


    
   <?php echo $__env->make('front.layout.flash_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
       <form id="frm-profile">
        <?php echo e(csrf_field()); ?>


  

      
            <!----------------------------start of form of age verification------------->
            <div class="col-md-12">
               

                  <input type="hidden" name="old_front_image" id="old_front_image" value="<?php echo e(isset($user_details_arr['user_details']['front_image']) ? $user_details_arr['user_details']['front_image'] : ''); ?>"> 
                  <input type="hidden" name="old_back_image" id="old_back_image" value="<?php echo e(isset($user_details_arr['user_details']['back_image']) ? $user_details_arr['user_details']['back_image'] : ''); ?>">
                  <input type="hidden" name="old_selfie_image" id="old_selfie_image" value="<?php echo e(isset($user_details_arr['user_details']['selfie_image']) ? $user_details_arr['user_details']['selfie_image'] : ''); ?>">  

                    <input type="hidden" name="old_address_proof" id="old_address_proof" value="<?php echo e(isset($user_details_arr['user_details']['address_proof']) ? $user_details_arr['user_details']['address_proof'] : ''); ?>"> 
 
            </div>


             <?php if(isset($user_details_arr['user_details']['approve_status']) && $user_details_arr['user_details']['approve_status']==1): ?>
               <!------------------approved----------------------->
               <?php if(file_exists($id_proof_path.$user_details_arr['user_details']['front_image']) && file_exists($id_proof_path.$user_details_arr['user_details']['back_image']) && file_exists($id_proof_path.$user_details_arr['user_details']['selfie_image']) && file_exists($id_proof_path.$user_details_arr['user_details']['address_proof'])): ?>  
                <div class="innermain-my-profile imgdnones"> 
                <div id="status_msg"></div>
               <div class="row">
                 <div class="col-md-3">
                     <div class="form-group font-eightr fornts-img">
                        <label for="">Front Side Image</label>
                          <div class="yprofiles">                           
                             <div class="uplaod-edit-img">
                               <?php if(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!=''): ?>
                                    <img src="<?php echo e($id_proof_path.$user_details_arr['user_details']['front_image']); ?>" id="upload-f" class="profile" alt="Front Image" width="100" height="100">
                                    <?php else: ?>
                                    <img src="<?php echo e(url('/')); ?>/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="Front Image" width="100" height="100">
                               <?php endif; ?>
                            </div> 
                            
                        </div> 
                         <div class="clearfix"></div>
                    </div>
                 </div>
                  <div class="col-md-3">
                     <div class="form-group font-eightr fornts-img">
                      <label for="">Back Side Image</label>
                          <div class="yprofiles">

                              <div class="uplaod-edit-img">
                               <?php if(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!=''): ?>
                                    <img src="<?php echo e($id_proof_path.'/'.$user_details_arr['user_details']['back_image']); ?>" id="upload-f" class="profile" alt="Back Image" width="100" height="100">
                                    <?php else: ?>
                                    <img src="<?php echo e(url('/')); ?>/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="Back Image" width="100" height="100">
                               <?php endif; ?>
                              </div> 
                        </div>
                         <div class="clearfix"></div>
                    </div>
                  </div>

                  <div class="col-md-3">
                     <div class="form-group font-eightr fornts-img">
                      <label for="">Selfie Image</label>
                          <div class="yprofiles">

                              <div class="uplaod-edit-img">
                               <?php if(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!=''): ?>
                                    <img src="<?php echo e($id_proof_path.'/'.$user_details_arr['user_details']['selfie_image']); ?>" id="upload-f" class="profile" alt="Selfie Image" width="100" height="100">
                                    <?php else: ?>
                                    <img src="<?php echo e(url('/')); ?>/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="Selfie Image" width="100" height="100">
                               <?php endif; ?>
                              </div> 
                        </div>
                         <div class="clearfix"></div>
                    </div>
                  </div>



                  <div class="col-md-3">
                     <div class="form-group font-eightr fornts-img">
                      <label for="">Address Proof</label>
                          <div class="yprofiles">

                              <div class="uplaod-edit-img">
                               <?php if(isset($user_details_arr['user_details']['address_proof']) && $user_details_arr['user_details']['address_proof']!=''): ?>

                                    <?php
                                    $ext = pathinfo($user_details_arr['user_details']['address_proof'], PATHINFO_EXTENSION);

                                    if($ext=="pdf" || $ext=="doc" || $ext=="docx"){  
                                   ?>

                                     <a href="<?php echo e($id_proof_path.'/'.$user_details_arr['user_details']['address_proof']); ?>" id="upload-f" class="profile" alt="Address Proof" target="_blank">View Address Proof</a>
                                   <?php 
                                     }else{
                                   ?>

                                    <img src="<?php echo e($id_proof_path.'/'.$user_details_arr['user_details']['address_proof']); ?>" id="upload-f" class="profile" alt="Address Proof" width="100" height="100">

                                    <?php } ?>

                               <?php endif; ?>
                              </div> 
                        </div>
                         <div class="clearfix"></div>
                    </div>
                  </div>





                  <div class="col-md-3">
                     <div class="form-group font-eightr">
                         <div class="col-md-12"><label for="">Address</label></div>
                         <div class="col-md-12"><span><?php echo e(isset($user_details_arr['user_details']['age_address']) ? $user_details_arr['user_details']['age_address'] : ''); ?></span>
                         
                         </div>
                          <div class="clearfix"></div>
                      </div>
                     <?php if(isset($user_details_arr['user_details']['front_image']) && isset($user_details_arr['user_details']['back_image']) && (isset($user_details_arr['user_details']['approve_status'])==1) ): ?>

                        <div class="form-group font-eightr age-csp">
                         <div class="col-md-12"><label for="">Age Category</label></div>
                         <?php
                            $setage='';
                            $age = $user_details_arr['user_details']['age_category'];
                            if(isset($age))
                             {
                                if($age==1)
                                  $setage = '18+';
                                elseif($age==2)
                                  $setage ='21+';
                             } 
                         ?>
                         <div class="col-md-12">
                          <?php if($user_details_arr['user_details']['age_category']>0): ?>
                          <span><?php echo e(isset($setage)? $setage:''); ?></span>     
                          <?php else: ?>
                          <span>-</span> 
                          <?php endif; ?>             
                         </div>
                         <div class="clearfix"></div>
                      </div>
                     <?php endif; ?>
                  </div>
               </div>
                </div>
            <?php endif; ?>
               
          
            <br/> <br/>

            <?php else: ?>

                <!-------------else pending---------------------->
            <div class="innermain-my-profile imgdnones"> 
              <div id="status_msg"></div>
              <div class="form-group">
                <div class="row">
                <div class="col-md-3"><label for="">Front of ID <span>*</span></label></div>
                <div class="col-md-9">
                    <div class="yprofiles">
                        <div class="int-profiles">
                            
                            <input type="file" class="dropify" id="front_image" name="front_image" data-max-file-size="2M" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error"  
                             <?php if(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!='' && (file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['front_image']))): ?> 
                              <?php elseif(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!='' && (!file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['front_image']))): ?> 
                              data-parsley-required="true" data-parsley-required-message="Please select front of id"
                              <?php else: ?> 
                              data-parsley-required="true" data-parsley-required-message="Please select front of id"<?php endif; ?> data-default-file="<?php echo e($id_proof_path.$user_details_arr['user_details']['front_image']); ?>">

                            <span class="error-img-size" id="image_error_front_image"><?php echo e($errors->first('front_image')); ?></span>

                        </div>

                       
                        
                  </div>
              </div>
              </div>
              </div>

              <div class="form-group">
                <div class="row">
                <div class="col-md-3"><label for="">Back of ID <span>*</span></label></div>
                <div class="col-md-9">
                    <div class="yprofiles">
                            <div class="int-profiles">
                                <input type="file" class="dropify" id="back_image" name="back_image" data-max-file-size="2M" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error"
                                 <?php if(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!='' && (file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['back_image'])) ): ?> 
                                 <?php elseif(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!='' && (!file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['back_image']))): ?> 
                                 data-parsley-required="true" data-parsley-required-message="Please select back of id"
                                 <?php else: ?> 
                                 data-parsley-required="true" data-parsley-required-message="Please select back of id"
                                  <?php endif; ?> data-default-file="<?php echo e($id_proof_path.'/'.$user_details_arr['user_details']['back_image']); ?>">

                                <span class="error-img-size" id="image_error_back_image"><?php echo e($errors->first('back_image')); ?></span>
                            </div>

                        
                       
                  </div>
              </div>
            </div>
              </div>


              <div class="form-group">
                <div class="row">
                <div class="col-md-3"><label for="">Selfie <span>*</span></label></div>
                <div class="col-md-9">
                    <div class="yprofiles">
                            <div class="int-profiles">
                                <input type="file" class="dropify" id="selfie_image" name="selfie_image" data-max-file-size="2M" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" 
                                  <?php if(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!=''  && (file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['selfie_image'])) ): ?>

                                   <?php elseif(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!=''  && (!file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['selfie_image'])) ): ?>

                                  data-parsley-required="true" data-parsley-required-message="Please select selfie" 
                                  <?php else: ?>
                                  data-parsley-required="true" data-parsley-required-message="Please select selfie" 
                                  <?php endif; ?> data-default-file="<?php echo e($id_proof_path.'/'.$user_details_arr['user_details']['selfie_image']); ?>">

                                  <span class="error-img-size" id="image_error"><?php echo e($errors->first('selfie_image')); ?></span>
                            </div>

                       
                      
                       
                      </div>
                  </div> 
                </div>
                </div>



              <div class="form-group">
                <div class="row">
                <div class="col-md-3"><label for="">Address Proof <span></span></label></div>
                <div class="col-md-9">
                    <div class="yprofiles">
                            <div class="int-profiles">
                                <input type="file" class="dropify" id="address_proof" name="address_proof" data-max-file-size="2M" data-allowed-file-extensions="pdf png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" 
                                  <?php if(isset($user_details_arr['user_details']['address_proof']) && $user_details_arr['user_details']['address_proof']!=''  && (file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['address_proof'])) ): ?>

                                   <?php elseif(isset($user_details_arr['user_details']['address_proof']) && $user_details_arr['user_details']['address_proof']!=''  && (!file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['address_proof'])) ): ?>

                                 
                                  <?php else: ?>
                                  
                                  <?php endif; ?> data-default-file="<?php echo e($id_proof_path.'/'.$user_details_arr['user_details']['address_proof']); ?>">
                            </div>

                       
                         <?php if(isset($user_details_arr['user_details']['address_proof']) && $user_details_arr['user_details']['address_proof']!='' && file_exists(base_path().'/uploads/id_proof/'.$user_details_arr['user_details']['address_proof'])): ?>

                             <?php
                              $ext = pathinfo($user_details_arr['user_details']['address_proof'], PATHINFO_EXTENSION);

                              if($ext=="pdf" || $ext=="doc" || $ext=="docx" || $ext=="xls" || $ext=="xlsx"){  
                             ?>

                               <div class="">
                                  <a href="<?php echo e($id_proof_path.'/'.$user_details_arr['user_details']['address_proof']); ?>" id="upload-f" class="profile" alt="Address Proof" target="_blank">View Address Proof</a>                           
                              </div> 
                              <?php 
                                 }/*else{*/
                              ?>
                                

                         <?php endif; ?>
                        
                      </div>
                  </div> 
                </div>
                </div>



                 <div class="form-group">
                    <div class="row">
                     <div class="col-md-3"><label for="">Address <span></span></label></div>
                     <div class="col-md-9">
                      <div class="yprofiles">
                      <input type="text" id="age_address" name="age_address" value="<?php echo e(isset($user_details_arr['user_details']['age_address']) ? $user_details_arr['user_details']['age_address'] : ''); ?>"  data-parsley-required-message="Please enter full address" class="input-text" placeholder="Address">
                     
                     </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
           
        
              <!-----------------------------end of form of age verification-------------------->   
           
                <div class="button-list-dts">
                    <a class="butn-def" id="btn-profile">Submit</a>
                    <!-- <a href="javascript:window.history.go(-1)" class="butn-def cancelbtnss">Back</a> -->
                </div>
            <div class="clearfix"></div>
            </div>
            <?php endif; ?>


 
     </form>
   
</div>



  <script type="text/javascript">

    //Check image validation on upload file
   /* $(":file").on("change", function(e) 
    {
        var selectedID      = $(this).attr('id');

        var fileType        = this.files[0].type;
      

         var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                               "image/JPG", "image/JPEG", "image/PNG"];
                               
      
        if($.inArray(fileType, validImageTypes) < 0) 
        {
          swal('Alert!','Please select valid image type. Only jpg, jpeg and png file are allowed.');

          $('#'+selectedID).val('');
        }
    });*/


  /*  $("#address_proof").on("change", function(e) 
   {   
      var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                               "image/JPG", "image/JPEG", "image/PNG","application/pdf",
                               "application/msword","application/vnd.openxmlformats-officedocument.wordprocessing"];
      var selectedID      = $(this).attr('id');
      var fileType        = this.files[0].type;   
      var validImageTypes = ["application/pdf","image/jpg", "image/jpeg", "image/png",
                               "image/JPG", "image/JPEG", "image/PNG"];                       
  
        if($.inArray(fileType, validImageTypes) < 0) 
        {
      
          swal('Alert!','Please select valid file. Only jpg,png,jpeg,pdf file is allowed.');

          $('#'+selectedID).val('');

          var previewImageID = selectedID+'_preview';
          $('#'+previewImageID+' + img').remove();
        }
        
   });*/




    $('#btn-profile').click(function(){

      var admin_url = SITE_URL+'/book/buyers/age_proof_submitted';
      
      /*Check all validation is true*/
      //var admin = url(config('app.project.admin_panel_slug'));

      if($('#frm-profile').parsley().validate()==false) return;

      $.ajax({
        url:SITE_URL+'/buyer/age-verification/updateage',
        data:new FormData($('#frm-profile')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-profile').prop('disabled',true);
          $('#btn-profile').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
          //$('#btn-profile').hide();
        },
        success:function(response)
        {

          hideProcessingOverlay();
          $('#btn-profile').prop('disabled',false);
          $('#btn-profile').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
               
              swal('', response.msg, 'success');
             /* $.ajax({
                 url:admin_url,
                 data:{'submitted':'submitted'},
                 method:'POST', 
                 success:function(response)
                 {
                     
                 }
                  });*/
            
              window.location.reload();
            }
            else
            {                    
              swal('', response.msg, 'warning');
            }
          }else{
              swal('Appologies!', 'We cannot upload your age identification proof, please try after sometimes', 'warning');
          }
        }
      });
    });
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>