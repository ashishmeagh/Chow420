                

<?php $__env->startSection('main_content'); ?>
<!-- Page Content -->

<style type="text/css">
 .banner-images .dropify-clear{
  display: none !important;
 }
  .size-img{
    display: block;text-align: left; font-size: 13px; color: #099c29;
  }
  .form-group.errorcread .error-img-size .parsley-errors-list{ 
  display: block; position: static;
  }
  .dropify-wrapper~.dropify-errors-container ul{margin-top: 0px  !important;margin-bottom: 0px  !important;}
  .dropify-wrapper~.dropify-errors-container ul li {
    margin-left: 0 !important;
    color: #F34141;
    font-weight: 100  !important;
    font-size: 15px;
} 
</style>

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
                    <li class="active">Edit Banner Image</li>
                    
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div> 
         
    <!-- .row --> 
                <div class="row">
                    <div class="col-sm-12"> 
                        <div class="white-box banner-images">
                        <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    <?php echo e(csrf_field()); ?>


                                    <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_banner_image['id']) ? $arr_banner_image['id'] : ''); ?>" />


                                     <div class="removeimgdiv"><a href="#" oldimagedesktop2="<?php echo e(isset($arr_banner_image['banner_image2_desktop'])?$arr_banner_image['banner_image2_desktop']:''); ?>" 
                                        oldimagemobile2="<?php echo e(isset($arr_banner_image['banner_image2_mobile'])?$arr_banner_image['banner_image2_mobile']:''); ?>"
                                       link2="<?php echo e(isset($arr_banner_image['banner_image2_link2'])?$arr_banner_image['banner_image2_link2']:''); ?>" class="removebannerimg">Remove</a>
                                     </div>  

                                   <div class="form-group row">                                
                                      <label class="col-md-2 col-form-label" for="">Between Shop by reviews and  Best sellers (Desktop)<i class="red"></i></label>

                                      <div class="col-md-10">
                                      <input type="hidden" name="old_banner_image2_desktop" id="old_banner_image2_desktop" value="<?php echo e(isset($arr_banner_image['banner_image2_desktop'])?$arr_banner_image['banner_image2_desktop']:''); ?>">
                                      <input type="file" name="banner_image2_desktop" id="banner_image2_desktop" class="dropify" 
                                      
                                       data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image2_desktop']) ? $arr_banner_image['banner_image2_desktop'] : ''); ?>">
                                      <span id="image_error_banner_image2_desktop" class="error-img-size"><?php echo e($errors->first('banner_image2_desktop')); ?></span>
                                       <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>
                                     
                                      </div>
                                  </div>  
                            


                                   <div class="form-group row">
                                    
                                    <label class="col-md-2 col-form-label" for="">Between Shop by reviews and  Best sellers (Mobile) <i class="red"></i></label>

                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image2_mobile" id="old_banner_image2_mobile" value="<?php echo e(isset($arr_banner_image['banner_image2_mobile'])?$arr_banner_image['banner_image2_mobile']:''); ?>">
                                    <input type="file" name="banner_image2_mobile" id="banner_image2_mobile" class="dropify" 
                                   
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image2_mobile']) ? $arr_banner_image['banner_image2_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image2_mobile" class="error-img-size"><?php echo e($errors->first('banner_image2_mobile')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>
                                    </div>
                                  </div>     


                                   <div class="form-group row">
                                   
                                    <label class="col-md-2 col-form-label" for="">Between Shop by reviews and  Best sellers Link <i class="red"></i></label>


                                    <div class="col-md-10">
                                    <input type="text" name="banner_image2_link2" id="banner_image2_link2" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image2_link2'])?$arr_banner_image['banner_image2_link2']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image2_link2" class="error-img-size"><?php echo e($errors->first('banner_image2_link2')); ?></span>
                                                                 
                                    </div>
                                  </div>  

                                  <!--------------end--------------------->

                                  <!--------------start--------------------->


                                     <div class="removeimgdiv"><a href="#" oldimagedesktop="<?php echo e(isset($arr_banner_image['banner_image1_desktop'])?$arr_banner_image['banner_image1_desktop']:''); ?>" 
                                    oldimagemobile="<?php echo e(isset($arr_banner_image['banner_image1_mobile'])?$arr_banner_image['banner_image1_mobile']:''); ?>"
                                    link1="<?php echo e(isset($arr_banner_image['banner_image1_link1'])?$arr_banner_image['banner_image1_link1']:''); ?>" class="removebannerimg">Remove</a></div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Between Chow's Choice and Top Brands (Desktop) <i class="red"></i></label>
                                    <div class="col-md-10">
                                                                     

                                    <input type="hidden" name="old_banner_image1_desktop" id="old_banner_image1_desktop" value="<?php echo e(isset($arr_banner_image['banner_image1_desktop'])?$arr_banner_image['banner_image1_desktop']:''); ?>">
                                    <input type="file" name="banner_image1_desktop" id="banner_image1_desktop" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image1_desktop']) ? $arr_banner_image['banner_image1_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image1_desktop" class="error-img-size"><?php echo e($errors->first('banner_image1_desktop')); ?></span>
                                    <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>
                                   
                                    </div>
                                  </div>  


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Between Chow's Choice and Top Brands (Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image1_mobile" id="old_banner_image1_mobile" value="<?php echo e(isset($arr_banner_image['banner_image1_mobile'])?$arr_banner_image['banner_image1_mobile']:''); ?>">
                                    <input type="file" name="banner_image1_mobile" id="banner_image1_mobile" class="dropify" 
                                   
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image1_mobile']) ? $arr_banner_image['banner_image1_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image1_mobile" class="error-img-size"><?php echo e($errors->first('banner_image1_mobile')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>
                                    
                                    </div>
                                  </div>     




                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Between Chow's Choice and Top Brands Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image1_link1" id="banner_image1_link1" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image1_link1'])?$arr_banner_image['banner_image1_link1']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image1_link1" class="error-img-size"><?php echo e($errors->first('banner_image1_link1')); ?></span>
                                                                 
                                    </div>
                                  </div>  
                                  <!--------------end--------------------->

                                  <!--------------start--------------------->

                                   

                                  <div class="removeimgdiv"><a href="#" oldimagedesktop3="<?php echo e(isset($arr_banner_image['banner_image3_desktop'])?$arr_banner_image['banner_image3_desktop']:''); ?>" 
                                    oldimagemobile3="<?php echo e(isset($arr_banner_image['banner_image3_mobile'])?$arr_banner_image['banner_image3_mobile']:''); ?>"
                                    link3="<?php echo e(isset($arr_banner_image['banner_image3_link3'])?$arr_banner_image['banner_image3_link3']:''); ?>" class="removebannerimg">Remove</a></div>





                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">After Real time section (Desktop)<i class="red"></i></label>
                                    <div class="col-md-10">



                                    <input type="hidden" name="old_banner_image3_desktop" id="old_banner_image3_desktop" value="<?php echo e(isset($arr_banner_image['banner_image3_desktop'])?$arr_banner_image['banner_image3_desktop']:''); ?>">
                                    <input type="file" name="banner_image3_desktop" id="banner_image3_desktop" class="dropify" 
                                  
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image3_desktop']) ? $arr_banner_image['banner_image3_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image3_desktop" class="error-img-size"><?php echo e($errors->first('banner_image3_desktop')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>
                                   
                                    </div>
                                  </div>  
                            
                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">After Real time section (Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image3_mobile" id="old_banner_image3_mobile" value="<?php echo e(isset($arr_banner_image['banner_image3_mobile'])?$arr_banner_image['banner_image3_mobile']:''); ?>">
                                    <input type="file" name="banner_image3_mobile" id="banner_image3_mobile" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image3_mobile']) ? $arr_banner_image['banner_image3_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image3_mobile" class="error-img-size"><?php echo e($errors->first('banner_image3_mobile')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>
                                    </div>
                                  </div>     


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">After Real time section Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image3_link3" id="banner_image3_link3" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image3_link3'])?$arr_banner_image['banner_image3_link3']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image3_link3" class="error-img-size"><?php echo e($errors->first('banner_image3_link3')); ?></span>
                                                                 
                                    </div>
                                  </div>  


                                   <!--------------end--------------------->


                                   <!--------------start--------------------->


                                    <div class="removeimgdiv"><a href="#" oldimagedesktop4="<?php echo e(isset($arr_banner_image['banner_image4_desktop'])?$arr_banner_image['banner_image4_desktop']:''); ?>" 
                                    oldimagemobile4="<?php echo e(isset($arr_banner_image['banner_image4_mobile'])?$arr_banner_image['banner_image4_mobile']:''); ?>"
                                    link4="<?php echo e(isset($arr_banner_image['banner_image4_link4'])?$arr_banner_image['banner_image4_link4']:''); ?>" class="removebannerimg">Remove</a></div> 
                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Between Shop by category and Shop by reviews (Desktop)<i class="red"></i></label>
                                    <div class="col-md-10">


                                    <input type="hidden" name="old_banner_image4_desktop" id="old_banner_image4_desktop" value="<?php echo e(isset($arr_banner_image['banner_image4_desktop'])?$arr_banner_image['banner_image4_desktop']:''); ?>">
                                    <input type="file" name="banner_image4_desktop" id="banner_image4_desktop" class="dropify" 
                                
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image4_desktop']) ? $arr_banner_image['banner_image4_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image4_desktop" class="error-img-size"><?php echo e($errors->first('banner_image4_desktop')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>
                                   
                                    </div>
                                  </div>  




                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Between Shop by category and Shop by reviews (Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image4_mobile" id="old_banner_image4_mobile" value="<?php echo e(isset($arr_banner_image['banner_image4_mobile'])?$arr_banner_image['banner_image4_mobile']:''); ?>">
                                    <input type="file" name="banner_image4_mobile" id="banner_image4_mobile" class="dropify" 
                                  
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image4_mobile']) ? $arr_banner_image['banner_image4_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image4_mobile" class="error-img-size"><?php echo e($errors->first('banner_image4_mobile')); ?></span>    
                                     <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>                                
                                    </div>
                                  </div>     


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Between Shop by category and Shop by reviews Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image4_link4" id="banner_image4_link4" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image4_link4'])?$arr_banner_image['banner_image4_link4']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image4_link4" class="error-img-size"><?php echo e($errors->first('banner_image4_link4')); ?></span>
                                                                 
                                    </div>
                                  </div>  

                                  <!--------------end--------------------->

                                  <!--------------start--------------------->




                                   <div class="removeimgdiv"><a href="#" oldimagedesktop5="<?php echo e(isset($arr_banner_image['banner_image5_desktop'])?$arr_banner_image['banner_image5_desktop']:''); ?>" 
                                    oldimagemobile5="<?php echo e(isset($arr_banner_image['banner_image5_mobile'])?$arr_banner_image['banner_image5_mobile']:''); ?>"
                                    link5="<?php echo e(isset($arr_banner_image['banner_image5_link5'])?$arr_banner_image['banner_image5_link5']:''); ?>" class="removebannerimg">Remove</a></div>


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Shop page (Desktop)<i class="red"></i></label>
                                    <div class="col-md-10">



                                    <input type="hidden" name="old_banner_image5_desktop" id="old_banner_image5_desktop" value="<?php echo e(isset($arr_banner_image['banner_image5_desktop'])?$arr_banner_image['banner_image5_desktop']:''); ?>">
                                    <input type="file" name="banner_image5_desktop" id="banner_image5_desktop" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image5_desktop']) ? $arr_banner_image['banner_image5_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image5_desktop" class="error-img-size"><?php echo e($errors->first('banner_image5_desktop')); ?></span>
                                     <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>
                                   
                                    </div>
                                  </div>  



                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Shop page(Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image5_mobile" id="old_banner_image5_mobile" value="<?php echo e(isset($arr_banner_image['banner_image5_mobile'])?$arr_banner_image['banner_image5_mobile']:''); ?>">
                                    <input type="file" name="banner_image5_mobile" id="banner_image5_mobile" class="dropify" 
                                   
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image5_mobile']) ? $arr_banner_image['banner_image5_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image5_mobile" class="error-img-size"><?php echo e($errors->first('banner_image5_mobile')); ?></span>   
                                        <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>                                  
                                    </div>
                                  </div>     


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Shop page Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image5_link5" id="banner_image5_link5" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image5_link5'])?$arr_banner_image['banner_image5_link5']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image5_link5" class="error-img-size"><?php echo e($errors->first('banner_image5_link5')); ?></span>
                                                                 
                                    </div>
                                  </div>  
            


                                    <div class="removeimgdiv"><a href="#" oldimagedesktop6="<?php echo e(isset($arr_banner_image['banner_image6_desktop'])?$arr_banner_image['banner_image6_desktop']:''); ?>" 
                                    oldimagemobile6="<?php echo e(isset($arr_banner_image['banner_image6_mobile'])?$arr_banner_image['banner_image6_mobile']:''); ?>"
                                    link6="<?php echo e(isset($arr_banner_image['banner_image6_link6'])?$arr_banner_image['banner_image6_link6']:''); ?>" class="removebannerimg">Remove</a></div>

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Forum page (Desktop)<i class="red"></i></label>
                                    <div class="col-md-10">

                                    <input type="hidden" name="old_banner_image6_desktop" id="old_banner_image6_desktop" value="<?php echo e(isset($arr_banner_image['banner_image6_desktop'])?$arr_banner_image['banner_image6_desktop']:''); ?>">
                                    <input type="file" name="banner_image6_desktop" id="banner_image6_desktop" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image6_desktop']) ? $arr_banner_image['banner_image6_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image6_desktop" class="error-img-size"><?php echo e($errors->first('banner_image6_desktop')); ?></span>       
                                     <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>                            
                                    </div>
                                  </div>  



                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Forum page(Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image6_mobile" id="old_banner_image6_mobile" value="<?php echo e(isset($arr_banner_image['banner_image6_mobile'])?$arr_banner_image['banner_image6_mobile']:''); ?>">
                                    <input type="file" name="banner_image6_mobile" id="banner_image6_mobile" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image6_mobile']) ? $arr_banner_image['banner_image6_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image6_mobile" class="error-img-size"><?php echo e($errors->first('banner_image6_mobile')); ?></span>      
                                      <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>                                 
                                    </div>
                                  </div>     


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Forum page Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image6_link6" id="banner_image6_link6" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image6_link6'])?$arr_banner_image['banner_image6_link6']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image6_link6" class="error-img-size"><?php echo e($errors->first('banner_image6_link6')); ?></span>
                                                                 
                                    </div>
                                  </div>  

                                   <div class="removeimgdiv"><a href="#" oldimagedesktop7="<?php echo e(isset($arr_banner_image['banner_image7_desktop'])?$arr_banner_image['banner_image7_desktop']:''); ?>" 
                                    oldimagemobile7="<?php echo e(isset($arr_banner_image['banner_image7_mobile'])?$arr_banner_image['banner_image7_mobile']:''); ?>"
                                    link7="<?php echo e(isset($arr_banner_image['banner_image7_link7'])?$arr_banner_image['banner_image7_link7']:''); ?>" class="removebannerimg">Remove</a></div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Shop by brand (Desktop) <i class="red"></i></label>
                                    <div class="col-md-10">

                                    <input type="hidden" name="old_banner_image7_desktop" id="old_banner_image7_desktop" value="<?php echo e(isset($arr_banner_image['banner_image7_desktop'])?$arr_banner_image['banner_image7_desktop']:''); ?>">
                                    <input type="file" name="banner_image7_desktop" id="banner_image7_desktop" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image7_desktop']) ? $arr_banner_image['banner_image7_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image7_desktop" class="error-img-size"><?php echo e($errors->first('banner_image7_desktop')); ?></span>       
                                     <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>                            
                                    </div>
                                  </div>      


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Shop by brand (Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image7_mobile" id="old_banner_image7_mobile" value="<?php echo e(isset($arr_banner_image['banner_image7_mobile'])?$arr_banner_image['banner_image7_mobile']:''); ?>">
                                    <input type="file" name="banner_image7_mobile" id="banner_image7_mobile" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image7_mobile']) ? $arr_banner_image['banner_image7_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image7_mobile" class="error-img-size"><?php echo e($errors->first('banner_image7_mobile')); ?></span>      
                                      <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>                                 
                                    </div>
                                  </div>     


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Shop by brand Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image7_link7" id="banner_image7_link7" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image7_link7'])?$arr_banner_image['banner_image7_link7']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image7_link7" class="error-img-size"><?php echo e($errors->first('banner_image7_link7')); ?></span>
                                                                 
                                    </div>
                                  </div>   


                                  <div class="removeimgdiv"><a href="#" oldimagedesktop8="<?php echo e(isset($arr_banner_image['banner_image8_desktop'])?$arr_banner_image['banner_image8_desktop']:''); ?>" 
                                    oldimagemobile8="<?php echo e(isset($arr_banner_image['banner_image8_mobile'])?$arr_banner_image['banner_image8_mobile']:''); ?>"
                                    link8="<?php echo e(isset($arr_banner_image['banner_image8_link8'])?$arr_banner_image['banner_image8_link8']:''); ?>" class="removebannerimg">Remove</a></div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Chow watch (Desktop) <i class="red"></i></label>
                                    <div class="col-md-10">

                                    <input type="hidden" name="old_banner_image8_desktop" id="old_banner_image8_desktop" value="<?php echo e(isset($arr_banner_image['banner_image8_desktop'])?$arr_banner_image['banner_image8_desktop']:''); ?>">
                                    <input type="file" name="banner_image8_desktop" id="banner_image8_desktop" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image8_desktop']) ? $arr_banner_image['banner_image8_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image8_desktop" class="error-img-size"><?php echo e($errors->first('banner_image8_desktop')); ?></span>       
                                     <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>                            
                                    </div>
                                  </div>      


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Chow watch (Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image8_mobile" id="old_banner_image8_mobile" value="<?php echo e(isset($arr_banner_image['banner_image8_mobile'])?$arr_banner_image['banner_image8_mobile']:''); ?>">
                                    <input type="file" name="banner_image8_mobile" id="banner_image8_mobile" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image8_mobile']) ? $arr_banner_image['banner_image8_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image8_mobile" class="error-img-size"><?php echo e($errors->first('banner_image8_mobile')); ?></span>      
                                      <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>                                 
                                    </div>
                                  </div>     


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Chow watch Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image8_link8" id="banner_image8_link8" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image8_link8'])?$arr_banner_image['banner_image8_link8']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image8_link8" class="error-img-size"><?php echo e($errors->first('banner_image8_link8')); ?></span>
                                                                 
                                    </div>
                                  </div> 
                                  


                                   <div class="removeimgdiv"><a href="#" oldimagedesktop9="<?php echo e(isset($arr_banner_image['banner_image9_desktop'])?$arr_banner_image['banner_image9_desktop']:''); ?>" 
                                    oldimagemobile9="<?php echo e(isset($arr_banner_image['banner_image9_mobile'])?$arr_banner_image['banner_image9_mobile']:''); ?>"
                                    link9="<?php echo e(isset($arr_banner_image['banner_image9_link9'])?$arr_banner_image['banner_image9_link9']:''); ?>" class="removebannerimg">Remove</a></div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Chow's Choice (Desktop) <i class="red"></i></label>
                                    <div class="col-md-10">

                                    <input type="hidden" name="old_banner_image9_desktop" id="old_banner_image9_desktop" value="<?php echo e(isset($arr_banner_image['banner_image9_desktop'])?$arr_banner_image['banner_image9_desktop']:''); ?>">
                                    <input type="file" name="banner_image9_desktop" id="banner_image9_desktop" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image9_desktop']) ? $arr_banner_image['banner_image9_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image9_desktop" class="error-img-size"><?php echo e($errors->first('banner_image9_desktop')); ?></span>       
                                     <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>                            
                                    </div>
                                  </div>      


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Chow's Choice (Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image9_mobile" id="old_banner_image9_mobile" value="<?php echo e(isset($arr_banner_image['banner_image9_mobile'])?$arr_banner_image['banner_image9_mobile']:''); ?>">
                                    <input type="file" name="banner_image9_mobile" id="banner_image9_mobile" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image9_mobile']) ? $arr_banner_image['banner_image9_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image9_mobile" class="error-img-size"><?php echo e($errors->first('banner_image9_mobile')); ?></span>      
                                      <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>                                 
                                    </div>
                                  </div>     


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Chow's Choice Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image9_link9" id="banner_image9_link9" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image9_link9'])?$arr_banner_image['banner_image9_link9']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image9_link9" class="error-img-size"><?php echo e($errors->first('banner_image9_link9')); ?></span>
                                                                 
                                    </div>
                                  </div>  
                                   


                                  


                                   <div class="removeimgdiv"><a href="#" oldimagedesktop10="<?php echo e(isset($arr_banner_image['banner_image10_desktop'])?$arr_banner_image['banner_image10_desktop']:''); ?>" 
                                    oldimagemobile10="<?php echo e(isset($arr_banner_image['banner_image10_mobile'])?$arr_banner_image['banner_image10_mobile']:''); ?>"
                                    link10="<?php echo e(isset($arr_banner_image['banner_image10_link10'])?$arr_banner_image['banner_image10_link10']:''); ?>" class="removebannerimg">Remove</a></div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Best Seller (Desktop) <i class="red"></i></label>
                                    <div class="col-md-10">

                                    <input type="hidden" name="old_banner_image10_desktop" id="old_banner_image10_desktop" value="<?php echo e(isset($arr_banner_image['banner_image10_desktop'])?$arr_banner_image['banner_image10_desktop']:''); ?>">
                                    <input type="file" name="banner_image10_desktop" id="banner_image10_desktop" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image10_desktop']) ? $arr_banner_image['banner_image10_desktop'] : ''); ?>">
                                    <span id="image_error_banner_image10_desktop" class="error-img-size"><?php echo e($errors->first('banner_image10_desktop')); ?></span>       
                                     <span class="size-img"> (<b>Suggested size:</b>  1170px X 300px )</span>                            
                                    </div>
                                  </div>      


                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Best Seller (Mobile) <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="hidden" name="old_banner_image10_mobile" id="old_banner_image10_mobile" value="<?php echo e(isset($arr_banner_image['banner_image10_mobile'])?$arr_banner_image['banner_image10_mobile']:''); ?>">
                                    <input type="file" name="banner_image10_mobile" id="banner_image10_mobile" class="dropify" 
                                    
                                     data-default-file="<?php echo e($banner_public_img_path); ?><?php echo e(isset($arr_banner_image['banner_image10_mobile']) ? $arr_banner_image['banner_image10_mobile'] : ''); ?>">
                                    <span id="image_error_banner_image10_mobile" class="error-img-size"><?php echo e($errors->first('banner_image10_mobile')); ?></span>      
                                      <span class="size-img"> (<b>Suggested size:</b>  650px X 300px )</span>                                 
                                    </div>
                                  </div>     


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="">Best Seller Link <i class="red"></i></label>
                                    <div class="col-md-10">
                                    <input type="text" name="banner_image10_link10" id="banner_image10_link10" class="form-control" value="<?php echo e(isset($arr_banner_image['banner_image10_link10'])?$arr_banner_image['banner_image10_link10']:''); ?>" placeholder="Link" data-parsley-type="url">
                                   
                                    <span id="err_banner_image10_link10" class="error-img-size"><?php echo e($errors->first('banner_image10_link10')); ?></span>
                                                                 
                                    </div>
                                  </div>  
                                   















                                                            
                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Update</button>
                                
                                              
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

   function toggle_status()
  {
      var is_active = $('#is_active').val();
      if(is_active=='1')
      {
        $('#is_active').val('0');
      }
      else
      {
        $('#is_active').val('1');
      }
  }


  $(document).ready(function()
  {
    var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

    var csrf_token = $("input[name=_token]").val(); 
 
    $('#btn_add').click(function()
    {
      if($('#validation-form').parsley().validate()==false) return;
   
      $.ajax({
                  
          url: module_url_path+'/store',
          data: new FormData($('#validation-form')[0]),
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
           beforeSend : function()
          {  
            showProcessingOverlay();        
          },
          success:function(data)
          {
             hideProcessingOverlay(); 
             if('success' == data.status)
             {
                $('#validation-form')[0].reset();

                  swal({
                         title: "Success!",
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
              else if(data.status =='ImageFAILURE_banner_image1_desktop')
              { 
                 $("#image_error_banner_image1_desktop").html(data.description);
                 $("#image_error_banner_image1_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image1_mobile')
              { 
                 $("#image_error_banner_image1_mobile").html(data.description);
                 $("#image_error_banner_image1_mobile").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image2_desktop')
              { 
                 $("#image_error_banner_image2_desktop").html(data.description);
                 $("#image_error_banner_image2_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image2_mobile')
              { 
                 $("#image_error_banner_image2_mobile").html(data.description);
                 $("#image_error_banner_image2_mobile").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image3_desktop')
              { 
                 $("#image_error_banner_image3_desktop").html(data.description);
                 $("#image_error_banner_image3_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image3_mobile')
              { 
                 $("#image_error_banner_image3_mobile").html(data.description);
                 $("#image_error_banner_image3_mobile").css('color','red');

              }
               else if(data.status =='ImageFAILURE_banner_image4_desktop')
              { 
                 $("#image_error_banner_image4_desktop").html(data.description);
                 $("#image_error_banner_image4_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image4_mobile')
              { 
                 $("#image_error_banner_image4_mobile").html(data.description);
                 $("#image_error_banner_image4_mobile").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image5_desktop')
              { 
                 $("#image_error_banner_image5_desktop").html(data.description);
                 $("#image_error_banner_image5_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image5_mobile')
              { 
                 $("#image_error_banner_image5_mobile").html(data.description);
                 $("#image_error_banner_image5_mobile").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image6_desktop')
              { 
                 $("#image_error_banner_image6_desktop").html(data.description);
                 $("#image_error_banner_image6_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image6_mobile')
              { 
                 $("#image_error_banner_image6_mobile").html(data.description);
                 $("#image_error_banner_image6_mobile").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image7_desktop')
              { 
                 $("#image_error_banner_image7_desktop").html(data.description);
                 $("#image_error_banner_image7_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image7_mobile')
              { 
                 $("#image_error_banner_image7_mobile").html(data.description);
                 $("#image_error_banner_image7_mobile").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image8_desktop')
              { 
                 $("#image_error_banner_image8_desktop").html(data.description);
                 $("#image_error_banner_image8_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image8_mobile')
              { 
                 $("#image_error_banner_image8_mobile").html(data.description);
                 $("#image_error_banner_image8_mobile").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image9_desktop')
              { 
                 $("#image_error_banner_image9_desktop").html(data.description);
                 $("#image_error_banner_image9_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image9_mobile')
              { 
                 $("#image_error_banner_image9_mobile").html(data.description);
                 $("#image_error_banner_image9_mobile").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image10_desktop')
              { 
                 $("#image_error_banner_image10_desktop").html(data.description);
                 $("#image_error_banner_image10_desktop").css('color','red');

              }
              else if(data.status =='ImageFAILURE_banner_image10_mobile')
              { 
                 $("#image_error_banner_image10_mobile").html(data.description);
                 $("#image_error_banner_image10_mobile").css('color','red');

              }
              else{
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   

    });

  });

   var module_url_path         = "<?php echo e($module_url_path); ?>";


  $(document).on('click','.removebannerimg',function(){

      var id  = $("#id").val();

      var oldimagedesktop1 = $(this).attr('oldimagedesktop');
      var oldimagemobile1 = $(this).attr('oldimagemobile');
      var link1          = $(this).attr('link1');  
      

       var oldimagedesktop2 = $(this).attr('oldimagedesktop2');
       var oldimagemobile2 = $(this).attr('oldimagemobile2');
       var link2          = $(this).attr('link2');  


       var oldimagedesktop3 = $(this).attr('oldimagedesktop3');
       var oldimagemobile3 = $(this).attr('oldimagemobile3');
       var link3          = $(this).attr('link3');  
    

       var oldimagedesktop4 = $(this).attr('oldimagedesktop4');
       var oldimagemobile4 = $(this).attr('oldimagemobile4');
       var link4          = $(this).attr('link4');  



       var oldimagedesktop5 = $(this).attr('oldimagedesktop5');
       var oldimagemobile5 = $(this).attr('oldimagemobile5');
       var link5          = $(this).attr('link5'); 


       var oldimagedesktop6 = $(this).attr('oldimagedesktop6');
       var oldimagemobile6 = $(this).attr('oldimagemobile6');
       var link6          = $(this).attr('link6'); 


       var oldimagedesktop7 = $(this).attr('oldimagedesktop7');
       var oldimagemobile7 = $(this).attr('oldimagemobile7');
       var link7          = $(this).attr('link7'); 


       var oldimagedesktop8 = $(this).attr('oldimagedesktop8');
       var oldimagemobile8 = $(this).attr('oldimagemobile8');
       var link8          = $(this).attr('link8');

       var oldimagedesktop9 = $(this).attr('oldimagedesktop9');
       var oldimagemobile9 = $(this).attr('oldimagemobile9');
       var link9          = $(this).attr('link9'); 

       var oldimagedesktop10 = $(this).attr('oldimagedesktop10');
       var oldimagemobile10 = $(this).attr('oldimagemobile10');
       var link10          = $(this).attr('link10'); 


       swal({
           title: "Do you really want to remove banner image?",
         //  text: data.description,
           type: 'warning',
           confirmButtonText: "OK",
           closeOnConfirm: false
        },
       function(isConfirm,tmp)
       {
         if(isConfirm==true)
         {



              if(oldimagedesktop1!='' || oldimagemobile1!='' || link1!='' || oldimagedesktop2 || oldimagemobile2 || link2 || oldimagedesktop3 || oldimagemobile3 || link3 || oldimagedesktop4 || oldimagemobile4 || link4 || oldimagedesktop5 || oldimagemobile5 || link5 || oldimagedesktop6 || oldimagemobile6 || link6 || oldimagedesktop7 || oldimagemobile7 || link7 || oldimagedesktop8 || oldimagemobile8 || link8 || oldimagedesktop9 || oldimagemobile9 || link9 || oldimagedesktop10 || oldimagemobile10 || link10)
              {

                  $.ajax({
                   method   : 'GET',
                   dataType : 'JSON',
                   data     : {id:id,oldimagedesktop1:oldimagedesktop1,oldimagemobile1:oldimagemobile1,link1:link1,oldimagedesktop2:oldimagedesktop2,oldimagemobile2:oldimagemobile2,link2:link2,oldimagedesktop3:oldimagedesktop3,oldimagemobile3:oldimagemobile3,link3:link3,oldimagedesktop4:oldimagedesktop4,oldimagemobile4:oldimagemobile4,link4:link4,oldimagedesktop5:oldimagedesktop5,oldimagemobile5:oldimagemobile5,link5:link5,oldimagedesktop6:oldimagedesktop6,oldimagemobile6:oldimagemobile6,link6:link6,oldimagedesktop7:oldimagedesktop7,oldimagemobile7:oldimagemobile7,link7:link7,oldimagedesktop8:oldimagedesktop8,oldimagemobile8:oldimagemobile8,link8:link8  ,oldimagedesktop9:oldimagedesktop9,oldimagemobile9:oldimagemobile9,link9:link9   ,oldimagedesktop10:oldimagedesktop10,oldimagemobile10:oldimagemobile10,link10:link10},
                   url      : module_url_path+'/delete_bannerimages',
                   beforeSend : function()
                  {  
                    showProcessingOverlay();        
                  },
                  success:function(data)
                  {
                      hideProcessingOverlay(); 
                     if('SUCCESS' == data.status)
                     {

                         window.location.reload();
                             
                      }                                   
                      else{
                         swal('Alert!',data.description,data.status);
                      }  
                  }
                  
                });   



              }//if
              else
              {
                 window.location.reload();
              }

     }
    });//swal
  }); 

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>