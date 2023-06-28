    

<?php $__env->startSection('main_content'); ?>
<style type="text/css">
    .error{
        color: red;
    }
</style>

 
<!-- Page Content -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><?php echo e(isset($module_title) ? $module_title : ''); ?></h4>
         </div>
         <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
              
              <?php
                $user = Sentinel::check();
              ?>

              <?php if(isset($user) && $user->inRole('admin')): ?>
                <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
              <?php endif; ?>

              <li class="active"><?php echo e(isset($module_title) ? $module_title : ''); ?></li>

            </ol>
         </div>
         <!-- /.col-lg-12 --> 
      </div>
      <!-- BEGIN Main Content -->
      <div class="row"> 
         <div class="col-sm-12">
            <div class="white-box">
               <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <?php echo Form::open([ 'url' => $module_url_path.'/update/'.base64_encode($arr_data['site_setting_id']),
                     'method'=>'POST',   
                     'class'=>'form-horizontal', 
                     'id'=>'validation-form',
                     'enctype' =>'multipart/form-data'
                     ]); ?>

 

               <div class="row"> 
                  <div class="col-sm-12 col-xs-12">
                     <div class="box-title">
                        
                      
                        <div class="box-tool">
                        </div>
                     </div>
                    
                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="site_name">Website Name <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('site_name',isset($arr_data['site_name'])?$arr_data['site_name']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter website name','data-parsley-maxlength'=>'255','placeholder'=>'Website Name']); ?>

                           <span class='red'><?php echo e($errors->first('site_name')); ?></span>
                        </div>
                     </div>
                     <div class="form-group">
                        <input type="hidden" name="old_logo" value="<?php echo e(isset($arr_data['site_logo'])?$arr_data['site_logo']:''); ?>">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="ad_image">Site Logo<i class="red">*</i> </label>
                        <div class="col-sm-12 col-md-12 col-lg-10">

                           <input type="file" name="image" id="ad_image" class="dropify" data-default-file="<?php echo e(url('/')); ?>/uploads/profile_image/<?php echo e(isset($arr_data['site_logo'])?$arr_data['site_logo']:''); ?>"  data-parsley-fileextension='jpg'/>
                        </div>
                     </div>

                   
                      <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="meta_keyword">Site 
                        Short Description</label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <?php echo Form::textarea('site_short_description',isset($arr_data['site_short_description'])?$arr_data['site_short_description']:'',['class'=>'form-control','data-parsley-maxlength'=>'255' ,'data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter description','placeholder'=>'Site Description']); ?>

                          
                        </div>
                     </div>
   

                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="site_address">Address<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                           <?php echo Form::text('site_address',isset($arr_data['site_address'])?$arr_data['site_address']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter site address','data-parsley-maxlength'=>'255','placeholder'=>'Site Address']); ?>

                         
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="site_contact_number">Contact Number<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                           <?php echo Form::text('site_contact_number',isset($arr_data['site_contact_number'])?$arr_data['site_contact_number']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter contact number','data-parsley-maxlength'=>'10','data-parsley-minlength'=>'6', 'data-parsley-type'=>'digits','placeholder'=>'Contact Number']); ?>

                          
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="meta_title">Meta Title<i class="red"></i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                           <?php echo Form::text('meta_title',isset($arr_data['meta_title'])?$arr_data['meta_title']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter meta title','placeholder'=>'Meta Title']); ?>

                           
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="meta_keyword">Meta Keywords<i class="red"></i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                           <?php echo Form::text('meta_keyword',isset($arr_data['meta_keyword'])?$arr_data['meta_keyword']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter meta keywords','placeholder'=>'Meta Keywords']); ?>

                           
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="meta_desc">Meta Description<i class="red"></i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                           <?php echo Form::textarea('meta_desc',isset($arr_data['meta_desc'])?$arr_data['meta_desc']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter meta description','data-parsley-minlength'=>'150','placeholder'=>'Meta Description']); ?>

                           
                        </div>
                     </div>
                     
                    

                   
                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="site_email_address">Email<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <?php echo Form::text('site_email_address',isset($arr_data['site_email_address'])?$arr_data['site_email_address']:'',['class'=>'form-control', 'data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter email', 'data-parsley-type'=>'email', 'data-parsley-maxlength'=>'255','placeholder'=>'Email']); ?>

                          
                        </div>
                     </div>


                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="twitter_url">Facebook URL<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <?php echo Form::url('facebook_url',isset($arr_data['facebook_url'])?$arr_data['facebook_url']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter facebook url','data-parsley-type'=>'url', 'data-parsley-maxlength'=>'500','placeholder'=>'Facebook URL']); ?>

                        </div>
                     </div>
                     


                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="twitter_url">Twitter URL<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <?php echo Form::url('twitter_url',isset($arr_data['twitter_url'])?$arr_data['twitter_url']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter twitter url','data-parsley-type'=>'url', 'data-parsley-maxlength'=>'500','placeholder'=>'Twitter URL']); ?>

                           
                        </div>
                     </div>


                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="twitter_url">Google URL<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <?php echo Form::url('google_url',isset($arr_data['google_url'])?$arr_data['google_url']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter google url', 'data-parsley-type'=>'url', 'data-parsley-maxlength'=>'500','placeholder'=>'Google URL']); ?>

                           
                        </div>
                     </div>


                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="twitter_url">Instagram URL<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <?php echo Form::url('instagram_url',isset($arr_data['instagram_url'])?$arr_data['instagram_url']:'',['class'=>'form-control','data-parsley-required'=>'true', 'data-parsley-required-message'=>'Please enter instagram url','data-parsley-type'=>'url', 'data-parsley-maxlength'=>'500','placeholder'=>'Instagram URL']); ?>

                           
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="youtube_url">YouTube URL<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                           <?php echo Form::url('youtube_url',isset($arr_data['youtube_url'])?$arr_data['youtube_url']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter youtube url', 'data-parsley-type'=>'url', 'data-parsley-maxlength'=>'500','placeholder'=>'YouTube URL']); ?>

                           
                        </div>
                     </div>

                      <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="tiktok_url">TikTok URL<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                           <?php echo Form::url('tiktok_url',isset($arr_data['tiktok_url'])?$arr_data['tiktok_url']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter tiktok url', 'data-parsley-type'=>'url', 'data-parsley-maxlength'=>'500','placeholder'=>'Tiktok URL']); ?>

                           
                        </div>
                     </div>




                     


                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label">Site Status<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                         
                           <input type="checkbox" name="site_status" id="site_status" value="1" data-size="small" class="js-switch " <?php if($arr_data['site_status']=='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status(this);"  />
                        </div>
                     </div>
                    

                    
                 <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label">Event Status<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                         
                           <input type="checkbox" name="event_status" id="event_status" value="1" data-size="small" class="js-switch " <?php if($arr_data['event_status']=='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_eventstatus(this);"  />
                        </div>
                </div>

                   <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label"> Hide Events Date <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                         
                           <input type="checkbox" name="event_date_status" id="event_date_status" value="1" data-size="small" class="js-switch " <?php if($arr_data['event_date_status']=='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_event_datestatus(this);"  />
                        </div>
                   </div>


                   <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label"> Hide Trending Section <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">
                         
                           <input type="checkbox" name="trendingproduct_status" id="trendingproduct_status" value="1" data-size="small" class="js-switch " <?php if($arr_data['trendingproduct_status']=='1'): ?> checked="checked" <?php endif; ?> data-color="#99d683" data-secondary-color="#f96262"  />
                        </div>
                   </div>



                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="site_name">Welcome Title <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('welcome_title',isset($arr_data['welcome_title'])?$arr_data['welcome_title']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter welcome title','data-parsley-maxlength'=>'255','placeholder'=>'Welcome title']); ?>

                           <span class='red'><?php echo e($errors->first('welcome_title')); ?></span>
                        </div>
                     </div>

                     <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="admin_commission">Welcome Description<i class="red">*</i></label>
                      <div class="col-md-10">
                        <textarea name="welcome_desc" id="welcome_desc" class="form-control" required="" rows="5" cols="50" maxlength="500"><?php echo e(isset($arr_data['welcome_desc']) ? $arr_data['welcome_desc'] : ''); ?></textarea>    
                        <span><?php echo e($errors->first('welcome_desc')); ?></span>
                      </div>
                    </div>

                      <div class="form-group">
                        <input type="hidden" name="old_welcome" value="<?php echo e(isset($arr_data['welcome_image'])?$arr_data['welcome_image']:''); ?>">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="ad_image">Welcome Image<i class="red">*</i> </label>
                        <div class="col-sm-12 col-md-12 col-lg-10">

                           <input type="file" name="welcome_image" id="welcome_image" class="dropify" data-default-file="<?php echo e(url('/')); ?>/uploads/welcome/<?php echo e(isset($arr_data['welcome_image'])?$arr_data['welcome_image']:''); ?>"  
                           
                           data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#welcome_image" 
                           />
                        </div>
                     </div>


                     <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="referal_text">Referal Description<i class="red">*</i></label>
                      <div class="col-md-10">
                        <textarea name="referal_text" id="referal_text" class="form-control" rows="5" cols="50" maxlength="500" data-parsley-required="true" data-parsley-required-message="Please enter referal description"><?php echo e(isset($arr_data['referal_text']) ? $arr_data['referal_text'] : ''); ?>

                        </textarea>    
                        <span style="color:red"><?php echo e($errors->first('referal_text')); ?></span>
                      </div>
                    </div> 
                   
                     <div class="form-group">
                        <input type="hidden" name="old_referal" value="<?php echo e(isset($arr_data['referal_image'])?$arr_data['referal_image']:''); ?>">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="referal_image">Referal Image<i class="red">*</i> </label>
                        <div class="col-sm-12 col-md-12 col-lg-10">

                           <input type="file" name="referal_image" id="referal_image" class="dropify" data-default-file="<?php echo e(url('/')); ?>/uploads/referal/<?php echo e(isset($arr_data['referal_image'])?$arr_data['referal_image']:''); ?>"  
                           
                           data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#referal_image" 
                           />
                        </div>
                     </div>

                     <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="pixelcode">Google Analytics In Header<i class="red"></i></label>
                      <div class="col-md-10">
                        <textarea name="pixelcode" id="pixelcode" class="form-control" rows="5" cols="50" ><?php echo e(isset($arr_data['pixelcode']) ? $arr_data['pixelcode'] : ''); ?>

                        </textarea>    
                        <span style="color:red"><?php echo e($errors->first('pixelcode')); ?></span>
                      </div>
                    </div> 

                    <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="pixelcode2">Google Analytics In Footer<i class="red"></i></label>
                      <div class="col-md-10">
                        <textarea name="pixelcode2" id="pixelcode2" class="form-control" rows="5" cols="50" ><?php echo e(isset($arr_data['pixelcode2']) ? $arr_data['pixelcode2'] : ''); ?>

                        </textarea>    
                        <span style="color:red"><?php echo e($errors->first('pixelcode2')); ?></span>
                      </div>
                    </div>


                     <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="body_content">Body Content<i class="red"></i></label>
                      <div class="col-md-10">
                        <textarea name="body_content" id="body_content" class="form-control" rows="5" cols="50" ><?php echo e(isset($arr_data['body_content']) ? $arr_data['body_content'] : ''); ?>

                        </textarea>    
                        <span style="color:red"><?php echo e($errors->first('body_content')); ?></span>
                      </div>
                    </div>


                     <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="google_ads_script">Google Ads Script<i class="red"></i></label>
                      <div class="col-md-10">
                        <textarea name="google_ads_script" id="google_ads_script" class="form-control" rows="5" cols="50" ><?php echo e(isset($arr_data['google_ads_script']) ? $arr_data['google_ads_script'] : ''); ?></textarea>    
                        <span style="color:red"><?php echo e($errors->first('google_ads_script')); ?></span>
                      </div>
                    </div>

                    
                    
                  </div> <!------end of col-md-12--of site setting--------------->

                  <hr>

                  <div class="col-sm-12 col-xs-12">
                    <div class="box-title">
                      <h3>Tracking API Settings</h3>
                    </div>

                     <div class="form-group" id="show_sandbox_tracking_api_key">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_url">Tracking API Key <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_tracking_api_key',isset($arr_data['sandbox_tracking_api_key'])?$arr_data['sandbox_tracking_api_key']:'',['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter tracking api key','placeholder'=>'Sandbox tracking api secret key','id'=>'sandbox_tracking_api_key' ]); ?>

                           <span class='red' id="sandbox_tracking_api_key_err"><?php echo e($errors->first('sandbox_tracking_api_key')); ?></span>
                        </div>
                      </div>
                   </div>
                   
                   <hr>

                  <!-- START of COMMISSION --> 
                  <div class="col-sm-12 col-xs-12">
                    <div class="box-title">
                      <h3>Commission Settings</h3>
                    </div>

                  <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="admin_commission">Admin Commission (%)<i class="red">*</i></label>
                      <div class="col-md-10">
                        <input type="text" name="admin_commission" id="admin_commission" value="<?php echo e(isset($arr_data['admin_commission']) ? $arr_data['admin_commission'] : 0.00); ?>" class="form-control" 
                        data-parsley-minlength="1"
                        data-parsley-maxlength="100"
                        data-parsley-required="true" data-parsley-required-message="Please enter admin commision" data-parsley-type="number" data-parsley-min-message="Minimum commission value should be 1"  data-parsley-max-message="Maximum commission value should be 100" data-parsley-type-message="Please enter valid admin commission" data-parsley-trigger="keyup">

                        <span><?php echo e($errors->first('admin_commission')); ?></span>

                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="seller_commission">Dispensary Commission (%)<i class="red">*</i></label>
                      <div class="col-md-10">
                        <input type="text" name="seller_commission" id="seller_commission" value="<?php echo e(isset($arr_data['seller_commission']) ? $arr_data['seller_commission'] : 0.00); ?>" class="form-control"    data-parsley-minlength="1"
                        data-parsley-maxlength="100" data-parsley-required="true" data-parsley-required-message="Please enter dispensary commission" data-parsley-type="number" data-parsley-min-message="Minimum commission value should be 1"  data-parsley-max-message="Maximum commission value should be 100" data-parsley-type-message="Please enter valid dispensary commission" data-parsley-trigger="keyup">

                        <span><?php echo e($errors->first('seller_commission')); ?></span>

                      </div>
                    </div>
                </div>



                  <!-- END of COMMISSION -->



              <!-----start of col-md-12 of payment setting--------------------->

                <div class="col-sm-12 col-xs-12">
                    <div class="box-title">
                          <h3>Payment Settings</h3>
                    </div>



                      <div class="form-group row">
                          <label class="col-md-2 col-form-label" for="payment_gateway_switch"> Order Payment Switch Mode <i class="red">*</i></label>
                           <div class="col-md-10">  
                                <div class="radio-btns">
                                  <div class="radio-btn">
                                    <input type="radio" name="payment_gateway_switch" class="payment_mode" id="payment_gateway_switch" data-parsley-required="true" value="square"  data-parsley-required-message="Please select payment gateway" data-parsley-errors-container=".pay_switch_err"  <?php echo e($arr_data['payment_gateway_switch']=='square'?"checked":""); ?> >
                                    <label for="payment_gateway_switch">Square Payment</label>
                                    <div class="check"></div>
                                  </div>
                                  <div class="radio-btn">
                                    <input type="radio" name="payment_gateway_switch" class="payment_mode" id="payment_gateway_switch1" data-parsley-required="true" value="authorizenet" data-parsley-required-message="Please select payment gateway" data-parsley-errors-container=".pay_switch_err" <?php echo e($arr_data['payment_gateway_switch']=='authorizenet'?"checked":""); ?> > 
                                    <label for="payment_gateway_switch1">Authorize Net Payment</label>
                                    <div class="check"></div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="pay_switch_err"></div>
                            </div>
                                      
                         <span><?php echo e($errors->first('payment_gateway_switch')); ?></span>
                      </div> 




                      
                      <div class="form-group row">
                          <label class="col-md-2 col-form-label" for="product_stock"> Payment Mode <i class="red">*</i></label>
                           <div class="col-md-10">  
                                <div class="radio-btns">
                                  <div class="radio-btn">
                                    <input type="radio" name="payment_mode" class="payment_mode" id="payment_mode" data-parsley-required="true" value="0"  data-parsley-required-message="Please select payment mode" data-parsley-errors-container=".pay_err"  <?php echo e($arr_data['payment_mode']=='0'?"checked":""); ?> onchange="return paymode(this.value)">
                                    <label for="payment_mode">Sandbox</label>
                                    <div class="check"></div>
                                  </div>
                                  <div class="radio-btn">
                                    <input type="radio" name="payment_mode" class="payment_mode" id="payment_mode1" data-parsley-required="true" value="1" data-parsley-required-message="Please select payment mode" data-parsley-errors-container=".pay_err" <?php echo e($arr_data['payment_mode']=='1'?"checked":""); ?> onchange="return paymode(this.value)"> 
                                    <label for="payment_mode1">Live</label>
                                    <div class="check"></div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="pay_err"></div>
                            </div>
                                      
                         <span><?php echo e($errors->first('payment_mode')); ?></span>
                      </div> 



                     <div class="form-group" id="show_sandboxaccess">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_access_token">Sandbox Access Token <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_access_token',isset($arr_data['sandbox_access_token'])?$arr_data['sandbox_access_token']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter sandbox access token','placeholder'=>'Sandbox access token' ,'id'=>'sandbox_access_token'  ]); ?>

                           <span class='red' id="sandbox_access_token_err"><?php echo e($errors->first('sandbox_access_token')); ?></span>
                        </div>
                     </div>


                      <div class="form-group" id="show_sandboxlocation">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_location_id">Sandbox Location Id <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_location_id',isset($arr_data['sandbox_location_id'])?$arr_data['sandbox_location_id']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter sandbox location id','placeholder'=>'Sandbox location id' ,'id'=>'sandbox_location_id']); ?>

                           <span class='red' id="sandbox_location_id_err"><?php echo e($errors->first('sandbox_location_id')); ?></span>
                        </div>
                     </div>

                      <div class="form-group" id="show_sandboxapplication">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_application_id">Sandbox Application Id <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_application_id',isset($arr_data['sandbox_application_id'])?$arr_data['sandbox_application_id']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter sandbox application id','placeholder'=>'Sandbox application id' ,'id'=>'sandbox_application_id']); ?>

                           <span class='red' id="sandbox_application_id_err"><?php echo e($errors->first('sandbox_application_id')); ?></span>
                        </div>
                     </div>

                      <div class="form-group" id="show_sandboxjsurl">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_js_url">Sandbox Js Url <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_js_url',isset($arr_data['sandbox_js_url'])?$arr_data['sandbox_js_url']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter sandbox js url','placeholder'=>'Sandbox js url','id'=>'sandbox_js_url' ]); ?>

                           <span class='red' id="sandbox_js_url_err"><?php echo e($errors->first('sandbox_js_url')); ?></span>
                        </div>
                     </div>

                      <div class="form-group" id="show_sandboxurl">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_url">Sandbox Url <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_url',isset($arr_data['sandbox_url'])?$arr_data['sandbox_url']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter sandbox url','placeholder'=>'Sandbox url','id'=>'sandbox_url' ]); ?>

                           <span class='red' id="sandbox_url_err"><?php echo e($errors->first('sandbox_url')); ?></span>
                        </div>
                     </div>
                     
                      <div class="form-group" id="show_sandbox_stripe_public_key">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_url">Stripe Publish Key <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_stripe_public_key',isset($arr_data['sandbox_stripe_public_key'])?$arr_data['sandbox_stripe_public_key']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter stripe publish key','placeholder'=>'Sandbox stripe public key','id'=>'sandbox_stripe_public_key' ]); ?>

                           <span class='red' id="sandbox_stripe_public_key_url_err"><?php echo e($errors->first('sandbox_stripe_public_key')); ?></span>
                        </div>
                     </div>

                       <div class="form-group" id="show_sandbox_stripe_secret_key">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_url">Stripe Secret Key <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_stripe_secret_key',isset($arr_data['sandbox_stripe_secret_key'])?$arr_data['sandbox_stripe_secret_key']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter stripe secret key','placeholder'=>'Sandbox stripe secret key','id'=>'sandbox_stripe_secret_key' ]); ?>

                           <span class='red' id="sandbox_stripe_secret_key_url_err"><?php echo e($errors->first('sandbox_stripe_secret_key')); ?></span>
                        </div>
                       </div>


                      <div class="form-group" id="show_sandbox_api_loginid">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_sandbox_api_loginid">Sandbox Authorizenet API Login Id  <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_api_loginid',isset($arr_data['sandbox_api_loginid'])?$arr_data['sandbox_api_loginid']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter authorize net api login id','placeholder'=>'Sandbox authorize net api login id','id'=>'sandbox_api_loginid' ]); ?>

                           <span class='red' id="sandbox_api_loginid_url_err"><?php echo e($errors->first('sandbox_api_loginid')); ?></span>
                        </div>
                       </div> 


                       <div class="form-group" id="show_sandbox_transactionkey">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_transactionkey"> Sandbox Authorizenet API Transaction Key  <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('sandbox_transactionkey',isset($arr_data['sandbox_transactionkey'])?$arr_data['sandbox_transactionkey']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter authorize net transaction key','placeholder'=>'Sandbox authorize net transaction key','id'=>'sandbox_transactionkey' ]); ?>

                           <span class='red' id="sandbox_transactionkey_url_err"><?php echo e($errors->first('sandbox_transactionkey')); ?></span>
                        </div>
                       </div> 

                    <!-- tax settings -->
                      <div class="form-group" id="sandbox_tax_api_key">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Sandbox Tax Api Key<i class="red">*</i></label>
                          <div class="col-sm-12 col-md-12 col-lg-10"> 
                             
                            <input class="form-control parsley-success"  data-parsley-required-message="Please enter tax api key" placeholder="Enter sandbox tax api key" name="sand_tax_api_key" id="sand_tax_api_key" type="text" value="<?php echo e(isset($arr_data['sandbox_tax_api_key'])?$arr_data['sandbox_tax_api_key']:''); ?>">

                            <span class='red' id="sandbox_api_key_err"><?php echo e($errors->first('tax_api_key')); ?></span>

                          </div>
                      </div>

                      <div class="form-group" id="sandbox_tax_url">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Sandbox Tax Url<i class="red">*</i></label>
                            <div class="col-sm-12 col-md-12 col-lg-10"> 
                               
                              <input class="form-control parsley-success" data-parsley-required-message="Please enter tax url" placeholder="Enter sandbox tax url" name="sand_tax_url" id="sand_tax_url" type="url" value="<?php echo e(isset($arr_data['sandbox_tax_url'])?$arr_data['sandbox_tax_url']:''); ?>">

                              <span class='red' id="sandbox_tax_url_err"><?php echo e($errors->first('tax_url')); ?></span>

                            </div>
                      </div>



                     <div class="form-group" id="show_liveaccesstoken" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="live_access_token">Live Access Token <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_access_token',isset($arr_data['live_access_token'])?$arr_data['live_access_token']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter live access token','placeholder'=>'Live access token' ,'id'=>'live_access_token' ]); ?>

                           <span class='red' id="live_access_token_err"><?php echo e($errors->first('live_access_token')); ?></span>
                        </div>
                     </div>

                     <div class="form-group" id="show_livelocation" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_location_id">Live Location Id <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_location_id',isset($arr_data['live_location_id'])?$arr_data['live_location_id']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter live location id','placeholder'=>'Live location id','id'=>'live_location_id']); ?>

                           <span class='red' id="live_location_id_err"><?php echo e($errors->first('live_location_id')); ?></span>
                        </div>
                     </div>

                     <div class="form-group" id="show_liveapplication" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="live_application_id">Live Application Id <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_application_id',isset($arr_data['live_application_id'])?$arr_data['live_application_id']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter live application id','placeholder'=>'Live application id','id'=>'live_application_id']); ?>

                           <span class='red' id="live_application_id_err"><?php echo e($errors->first('live_application_id')); ?></span>
                        </div>
                     </div>

                      <div class="form-group" id="show_livejsurl" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="live_js_url">Live Js Url <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_js_url',isset($arr_data['live_js_url'])?$arr_data['live_js_url']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter live js url','placeholder'=>'Live js url','id'=>'live_js_url']); ?>

                           <span class='red' id="live_js_url_err"><?php echo e($errors->first('live_js_url')); ?></span>
                        </div>
                     </div>

                       <div class="form-group" id="show_liveurl" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="live_url">Live Url <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_url',isset($arr_data['live_url'])?$arr_data['live_url']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter live url','placeholder'=>'Live url','id'=>'live_url' ]); ?>

                           <span class='red' id="live_url_err"><?php echo e($errors->first('live_url')); ?></span>
                        </div>
                     </div>



                      <div class="form-group" id="show_live_stripe_public_key" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="live_stripe_public_key">Live Stripe Publish Key <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_stripe_public_key',isset($arr_data['live_stripe_public_key'])?$arr_data['live_stripe_public_key']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter live stripe publish key','placeholder'=>'Live stripe publish key','id'=>'live_stripe_public_key' ]); ?>

                           <span class='red' id="live_stripe_public_key_err"><?php echo e($errors->first('live_stripe_public_key')); ?></span>
                        </div>
                     </div>

                      <div class="form-group" id="show_live_stripe_secret_key" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="live_stripe_secret_key">Live Stripe Secret Key <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_stripe_secret_key',isset($arr_data['live_stripe_secret_key'])?$arr_data['live_stripe_secret_key']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter live stripe secret key','placeholder'=>'Live stripe secret key','id'=>'live_stripe_secret_key' ]); ?>

                           <span class='red' id="live_stripe_secret_key_err"><?php echo e($errors->first('live_stripe_secret_key')); ?></span>
                        </div>
                     </div>


                       <div class="form-group" id="show_live_api_loginid"  style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="sandbox_live_api_loginid">Live Authorizenet API Login Id  <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_api_loginid',isset($arr_data['live_api_loginid'])?$arr_data['live_api_loginid']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter authorize net api login id','placeholder'=>'Live authorize net api login id','id'=>'live_api_loginid' ]); ?>

                           <span class='red' id="live_api_loginid_url_err"><?php echo e($errors->first('live_api_loginid')); ?></span>
                        </div>
                       </div> 


                       <div class="form-group" id="show_live_transactionkey"  style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" for="live_transactionkey">Live Authorizenet API Transaction Key  <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10">                                   
                           <?php echo Form::text('live_transactionkey',isset($arr_data['live_transactionkey'])?$arr_data['live_transactionkey']:'',['class'=>'form-control','data-parsley-required-message'=>'Please enter authorize net transaction key','placeholder'=>'Live authorize net transaction key','id'=>'live_transactionkey' ]); ?>

                           <span class='red' id="live_transactionkey_url_err"><?php echo e($errors->first('live_transactionkey')); ?></span>
                        </div>
                       </div> 


                      <div class="form-group" id="live_tax_api_key" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Live Tax Api Key<i class="red">*</i></label>
                          <div class="col-sm-12 col-md-12 col-lg-10"> 
                             
                            <input class="form-control parsley-success" placeholder="Enter live tax api key" name="tax_api_key" id="tax_api_key" type="text" value="<?php echo e(isset($arr_data['live_tax_api_key'])?$arr_data['live_tax_api_key']:''); ?>" data-parsley-required-message="Please enter tax api key">

                            <span class='red' id="live_api_key_err"><?php echo e($errors->first('tax_api_key')); ?></span>

                          </div>
                      </div>

                      <div class="form-group" id="live_tax_url" style="display: none">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Live Tax Url<i class="red">*</i></label>
                            <div class="col-sm-12 col-md-12 col-lg-10"> 
                               
                              <input class="form-control parsley-success" placeholder="Enter live tax url" name="tax_url" id="tax_url" type="url" value="<?php echo e(isset($arr_data['live_tax_url'])?$arr_data['live_tax_url']:''); ?>" data-parsley-required-message="Please enter tax url">

                              <span class='red' id="live_tax_url_err"><?php echo e($errors->first('tax_url')); ?></span>

                            </div>
                      </div>




                    <div class="col-sm-12 col-xs-12">
                      <div class="box-title">
                            <h3>Twilio Credentials</h3>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Account SID<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <input class="form-control parsley-success" data-parsley-required="true" data-parsley-required-message="Please enter Account SID" placeholder="Account SID" name="twilio_account_sid" type="text" value="<?php echo e(isset($arr_data['twilio_account_sid'])?$arr_data['twilio_account_sid']:''); ?>" >
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Auth token<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <input class="form-control parsley-success" data-parsley-required="true" data-parsley-required-message="Please enter auth token" placeholder="Auth token" name="twilio_auth_token" type="text" value="<?php echo e(isset($arr_data['twilio_auth_token'])?$arr_data['twilio_auth_token']:''); ?>" >
                        </div>
                     </div>

                     <?php
                     //dd($arr_data);
                     ?>

                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >From Number <i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <input class="form-control parsley-success" data-parsley-required="true" data-parsley-required-message="Please enter from number "   placeholder="From Number" name="twilio_from_number" type="text" value="<?php echo e(isset($arr_data['twilio_from_number'])?$arr_data['twilio_from_number']:''); ?>" >
                        </div>
                     </div>
                    </div>



                    <div class="col-sm-12 col-xs-12">
                      <div class="box-title">
                            <h3>Buyer Referal Details</h3>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Referal Amount ($)<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <input class="form-control parsley-success" data-parsley-required="true" data-parsley-required-message="Please enter referal user amount" placeholder="Please enter referal user amount" name="buyer_referal_amount" type="text" value="<?php echo e(isset($arr_data['buyer_referal_amount'])?$arr_data['buyer_referal_amount']:''); ?>" >
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Refered Amount($)<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <input class="form-control parsley-success" data-parsley-required="true" data-parsley-required-message="Please enter refered user amount" placeholder="Please enter refered user amount" name="buyer_refered_amount" type="text" value="<?php echo e(isset($arr_data['buyer_refered_amount'])?$arr_data['buyer_refered_amount']:''); ?>" >
                        </div>
                     </div>

                      <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Review Amount($)<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <input class="form-control parsley-success" data-parsley-required="true" data-parsley-required-message="Please enter review amount" placeholder="Please enter review amount" name="buyer_review_amount" type="text" value="<?php echo e(isset($arr_data['buyer_review_amount'])?$arr_data['buyer_review_amount']:''); ?>" >
                        </div>
                     </div>
                    </div>

                   
           

                   <div class="col-sm-12 col-xs-12">
                      <div class="box-title">
                            <h3>Cashback Percentage</h3>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-12 col-md-4 col-lg-2 control-label" >Cashback (%)<i class="red">*</i></label>
                        <div class="col-sm-12 col-md-12 col-lg-10"> 
                           <input class="form-control parsley-success" data-parsley-required="true" data-parsley-required-message="Please enter cashback percentage" placeholder="Please enter cashback percentage" name="cashback_percentage" data-parsley-type="number" type="text" value="<?php echo e(isset($arr_data['cashback_percentage'])?$arr_data['cashback_percentage']:''); ?>" >
                        </div>
                     </div>                    
                    </div>




                    <div class="input-group">
                          <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" id="btn_update" value="Update">Update</button>
                     </div>
                     <?php echo Form::close(); ?>


                 </div><!-----end of col-md-12 of payment setting--------------------->





               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END Main Content --> 
    <script type="text/javascript">
    $(document).ready(function(){

      // window.Parsley.on('field:error', function() {
      // // This global callback will be called for any field that fails validation.
      // console.log('Validation failed for: ', this.$element);
      // });

      //no need to validate on page load
      if($('#validation-form').parsley().validate()==false){} return;


     });

      /*function toggle_status(ref)
      {
        var site_status = $('#site_status').val();


        if(site_status=='1')
        {
          $('#site_status').val('0');
        }
        else
        {
          $('#site_status').val('1');
        }
      }*/


      /*function toggle_eventstatus()
      {
        var event_status = $('#event_status').val();
        if(event_status=='1')
        {
          $('#event_status').val('1');
        }
        else
        {
          $('#event_status').val('0');
        }
      }*/


      
      /*function toggle_event_datestatus()
      {
        var event_date_status = $('#event_date_status').val();
        if(event_date_status=='1')
        {
          $('#event_date_status').val('1');
        }
        else
        {
          $('#event_date_status').val('0');
        }
      }*/

    </script>

<script>
$(document).ready(function(){ 

  var payment_mode = "<?php echo e($arr_data['payment_mode']); ?>";

  if(payment_mode=='1'){
      $("#show_liveaccesstoken").show();
      $("#show_livelocation").show();
      $("#show_liveapplication").show();
      $("#show_livejsurl").show();
      $("#show_liveurl").show();
      $("#show_live_stripe_public_key").show();
      $("#show_live_stripe_secret_key").show();
      $("#show_live_api_loginid").show();
      $("#show_live_transactionkey").show();
      $("#live_tax_api_key").show();
      $("#live_tax_url").show();



      $("#show_sandboxaccess").hide();
      $("#show_sandboxlocation").hide();
      $("#show_sandboxapplication").hide();
      $("#show_sandboxjsurl").hide();
      $("#show_sandboxurl").hide();
      $("#show_sandbox_stripe_public_key").hide();
      $("#show_sandbox_stripe_secret_key").hide();
      $("#show_sandbox_api_loginid").hide();
      $("#show_sandbox_transactionkey").hide();
      $("#sandbox_tax_api_key").hide();
      $("#sandbox_tax_url").hide();


  }
  if(payment_mode=='0')
  {
      $("#show_sandboxaccess").show();
      $("#show_sandboxlocation").show();
      $("#show_sandboxapplication").show();
      $("#show_sandboxjsurl").show();
      $("#show_sandboxurl").show();
      $("#show_sandbox_stripe_public_key").show();
      $("#show_sandbox_stripe_secret_key").show();
      $("#show_sandbox_api_loginid").show();
      $("#show_sandbox_transactionkey").show();
      $("#sandbox_tax_api_key").show();
      $("#sandbox_tax_url").show();

      $("#show_liveaccesstoken").hide();
      $("#show_livelocation").hide();
      $("#show_liveapplication").hide();
      $("#show_livejsurl").hide();
      $("#show_liveurl").hide();
      $("#show_live_stripe_public_key").hide();
      $("#show_live_stripe_secret_key").hide();
      $("#show_live_api_loginid").hide();
      $("#show_live_transactionkey").hide();
      $("#live_tax_api_key").hide();
      $("#live_tax_url").hide();

  } 
  paymode(payment_mode);

    /*$("input[name$='payment_mode']").click(function() {
        var payment_mode = $(this).val();
        if(payment_mode=='0')
        {
          $("#show_sandboxaccess").show();
          $("#show_sandboxlocation").show();
          $("#show_sandboxapplication").show();
          $("#show_sandboxjsurl").show();
          $("#show_sandboxurl").show();

          $("#show_liveaccesstoken").hide();
          $("#show_livelocation").hide();
          $("#show_liveapplication").hide();
          $("#show_livejsurl").hide();
          $("#show_liveurl").hide();

        }
        else if(payment_mode=='1')
        {
          $("#show_liveaccesstoken").show();
          $("#show_livelocation").show();
          $("#show_liveapplication").show();
          $("#show_livejsurl").show();
          $("#show_liveurl").show();

          $("#show_sandboxaccess").hide();
          $("#show_sandboxlocation").hide();
          $("#show_sandboxapplication").hide();
          $("#show_sandboxjsurl").hide();
          $("#show_sandboxurl").hide();
        }

      
    }); */
});


function paymode(payment_mode)
{

       if(payment_mode=='0')
        {
          $("#show_sandboxaccess").show();
          $("#show_sandboxlocation").show();
          $("#show_sandboxapplication").show();
          $("#show_sandboxjsurl").show();
          $("#show_sandboxurl").show();
          $("#show_sandbox_stripe_public_key").show();
          $("#show_sandbox_stripe_secret_key").show();
          $("#show_sandbox_api_loginid").show();
          $("#show_sandbox_transactionkey").show();
          $("#sandbox_tax_api_key").show();
          $("#sandbox_tax_url").show();



          $("#show_liveaccesstoken").hide();
          $("#show_livelocation").hide();
          $("#show_liveapplication").hide();
          $("#show_livejsurl").hide();
          $("#show_liveurl").hide();
          $("#show_live_stripe_public_key").hide();
          $("#show_live_stripe_secret_key").hide();
          $("#show_live_api_loginid").hide();
          $("#show_live_transactionkey").hide();
          $("#live_tax_api_key").hide();
          $("#live_tax_url").hide();


         $('#sandbox_access_token,#sandbox_location_id,#sandbox_application_id,#sandbox_js_url,#sandbox_url,#sandbox_stripe_public_key,#sandbox_stripe_secret_key,#sandbox_api_loginid,#sandbox_transactionkey,#sand_tax_api_key,#sand_tax_url').attr('data-parsley-required',true);

          $('#live_access_token,#live_location_id,#live_application_id,#live_js_url,#live_url,#live_stripe_public_key,#live_stripe_secret_key,#live_api_loginid,#live_transactionkey,#tax_api_key,#tax_url').removeAttr('data-parsley-required');


        }
        else if(payment_mode=='1')
        {
          $("#show_liveaccesstoken").show();
          $("#show_livelocation").show();
          $("#show_liveapplication").show();
          $("#show_livejsurl").show();
          $("#show_liveurl").show();
          $("#show_live_stripe_public_key").show();
          $("#show_live_stripe_secret_key").show();
          $("#show_live_api_loginid").show();
          $("#show_live_transactionkey").show();
          $("#live_tax_api_key").show();
          $("#live_tax_url").show();

          $("#show_sandboxaccess").hide();
          $("#show_sandboxlocation").hide();
          $("#show_sandboxapplication").hide();
          $("#show_sandboxjsurl").hide();
          $("#show_sandboxurl").hide();
          $("#show_sandbox_stripe_public_key").hide();
          $("#show_sandbox_stripe_secret_key").hide();
          $("#show_sandbox_api_loginid").hide();
          $("#show_sandbox_transactionkey").hide();
          $("#sandbox_tax_api_key").hide();
          $("#sandbox_tax_url").hide();


          $('#live_access_token,#live_location_id,#live_application_id,#live_js_url,#live_url,#live_stripe_public_key,#live_stripe_secret_key,#live_api_loginid,#live_transactionkey,#tax_api_key,#tax_url').attr('data-parsley-required',true);

          $('#sandbox_access_token,#sandbox_location_id,#sandbox_application_id,#sandbox_js_url,#sandbox_url,#sandbox_stripe_public_key,#sandbox_stripe_secret_key,#sandbox_api_loginid,#sandbox_transactionkey,#sand_tax_api_key,#sand_tax_url').removeAttr('data-parsley-required');

        }


}


/*

$(document).on('click','#btn_update',function(){
     var payment_mode = $('form input[type=radio]:checked').val();
  
     if(payment_mode=='0')
     {
        var sandbox_access_token = $("#sandbox_access_token").val();
        var sandbox_location_id = $("#sandbox_location_id").val();
        var sandbox_application_id = $("#sandbox_application_id").val();
        var sandbox_js_url = $("#sandbox_js_url").val();
        var sandbox_url = $("#sandbox_url").val();

        var live_access_token = $("#live_access_token").val();
        var live_location_id = $("#live_location_id").val();
        var live_application_id = $("#live_application_id").val();
        var live_js_url = $("#live_js_url").val();
        var live_url = $("#live_url").val();
        
        if(sandbox_access_token.trim()=="")
        {
         
          $("#sandbox_access_token_err").html('Please enter sandbox access token');
          var flag1=1;
        }else{
           $("#sandbox_access_token_err").html('');
            var flag1=0;
        }

         if(sandbox_location_id.trim()=="")
        {
         
          $("#sandbox_location_id_err").html('Please enter sandbox location id');
          var flag2=1;
        }else{
           $("#sandbox_location_id_err").html('');
            var flag2=0;
        }

          if(sandbox_application_id.trim()=="")
        {
         
          $("#sandbox_application_id_err").html('Please enter sandbox application id');
          var flag3=1;
        }else{
           $("#sandbox_application_id_err").html('');
            var flag3=0;
        }
           if(sandbox_js_url.trim()=="")
        {
         
          $("#sandbox_js_url_err").html('Please enter sandbox js url');
          var flag4=1;
        }else{
           $("#sandbox_js_url_err").html('');
            var flag4=0;
        }
        if(sandbox_url.trim()=="")
        {
         
          $("#sandbox_url_err").html('Please enter sandbox url');
          var flag5=1;
        }else{
           $("#sandbox_url_err").html('');
            var flag5=0;
        }


        if(flag1==0 && flag2==0 && flag3==0 && flag4==0 && flag5==0){
          return true;
        }else{
          return false;
        }
     }

     if(payment_mode=='1')
     {
     

        var live_access_token = $("#live_access_token").val();
        var live_location_id = $("#live_location_id").val();
        var live_application_id = $("#live_application_id").val();
        var live_js_url = $("#live_js_url").val();
        var live_url = $("#live_url").val();
        
       
         if(live_access_token.trim()=="")
        {
         
          $("#live_access_token_err").html('Please enter live access token');
          var flag6=1;
        }else{
           $("#live_access_token_err").html('');
            var flag6=0;
        }

         if(live_location_id.trim()=="")
        {
         
          $("#live_location_id_err").html('Please enter live location id');
          var flag7=1;
        }else{
           $("#live_location_id_err").html('');
            var flag7=0;
        }

          if(live_application_id.trim()=="")
        {
         
          $("#live_application_id_err").html('Please enter live application id');
          var flag8=1;
        }else{
           $("#live_application_id_err").html('');
            var flag8=0;
        }
           if(live_js_url.trim()=="")
        {
         
          $("#live_js_url_err").html('Please enter live js url');
          var flag9=1;
        }else{
           $("#live_js_url_err").html('');
            var flag9=0;
        }
        if(live_url.trim()=="")
        {
         
          $("#live_url_err").html('Please enter live url');
          var flag10=1;
        }else{
           $("#live_url_err").html('');
            var flag10=0;
        }

        if(flag6==0 && flag7==0 && flag8==0 && flag9==0 && flag10==0){
          return true;
        }else{
          return false;
        }
     }
});*/
 
</script>

<script type="text/javascript">

    function toggle_status(ref) {

        var _token          = "<?php echo e(csrf_token()); ?>";
        var module_url_path = "<?php echo e($module_url_path); ?>";
        var site_status     = <?php echo e($arr_data['site_status']); ?>;
        var site_status_id  = <?php echo e($arr_data['site_setting_id']); ?>;

        swal({
            title: "Do you really want to update Site Status?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#8d62d5",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: true
        },
        function(isConfirm,tmp) {
            
            if (isConfirm) {

                $.ajax({
                    method   : 'post',
                    dataType : 'JSON',
                    data     : {site_status:site_status , _token : _token ,site_status_id : site_status_id},
                    url      : module_url_path+'/change_site_status',
                    beforeSend: function() { 

                        showProcessingOverlay();           
                    },
                    success  : function(response) {

                        hideProcessingOverlay();

                        if (response.status == 'success') { 

                            swal({
                                title: response.message,
                                type: "success",
                                confirmButtonColor: "#8d62d5",
                                confirmButtonText: "OK!",
                                closeOnConfirm: true
                            },
                            function(isConfirm,tmp) {
                                
                                location.reload();
                            });
                        }
                        else {

                            swal({
                                title: response.message,
                                type: "info",
                                confirmButtonColor: "#8d62d5",
                                confirmButtonText: "Ok"
                            });
                        }
                    }
                });
            }
            else {
                $(ref).trigger('click');
            }
        });
    }

    function toggle_eventstatus(ref) {

        var _token          = "<?php echo e(csrf_token()); ?>";
        var module_url_path = "<?php echo e($module_url_path); ?>";
        var event_status    = <?php echo e($arr_data['event_status']); ?>;
        var site_status_id  = <?php echo e($arr_data['site_setting_id']); ?>;

        swal({
            title: "Do you really want to update Event Status?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#8d62d5",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: true
        },
        function(isConfirm,tmp) {
            
            if (isConfirm) {

                $.ajax({
                    method   : 'post',
                    dataType : 'JSON',
                    data     : {event_status:event_status , _token : _token ,site_status_id : site_status_id},
                    url      : module_url_path+'/change_event_status',
                    beforeSend: function() {

                        showProcessingOverlay();           
                    },
                    success  : function(response) {

                        hideProcessingOverlay();

                        if (response.status == 'success') { 

                            swal({
                                title: response.message,
                                type: "success",
                                confirmButtonColor: "#8d62d5",
                                confirmButtonText: "OK!",
                                closeOnConfirm: true
                            },
                            function(isConfirm,tmp) {

                                location.reload();
                            });
                        }
                        else {

                            swal({
                                title: response.message,
                                type: "info",
                                confirmButtonColor: "#8d62d5",
                                confirmButtonText: "Ok"
                            });
                        }
                    }
                });
            }
            else {
                $(ref).trigger('click');
            }
        });
    }

    function toggle_event_datestatus(ref) {

        var _token              = "<?php echo e(csrf_token()); ?>";
        var module_url_path     = "<?php echo e($module_url_path); ?>";
        var site_status_id      = <?php echo e($arr_data['site_setting_id']); ?>;
        var event_date_status   = <?php echo e($arr_data['event_date_status']); ?>;

        swal({
            title: "Do you really want to update Hide Events Date?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#8d62d5",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: true
        },
        function(isConfirm,tmp) {
            
            if (isConfirm) {

                $.ajax({
                    method   : 'post',
                    dataType : 'JSON',
                    data     : {event_date_status:event_date_status , _token : _token ,site_status_id : site_status_id},
                    url      : module_url_path+'/change_event_date_status',
                    beforeSend: function() {

                        showProcessingOverlay();           
                    },
                    success  : function(response) {

                        hideProcessingOverlay();

                        if (response.status == 'success') { 

                            swal({
                                title: response.message,
                                type: "success",
                                confirmButtonColor: "#8d62d5",
                                confirmButtonText: "OK!",
                                closeOnConfirm: true
                            },
                            function(isConfirm,tmp) {

                                location.reload();
                            });
                        }
                        else {

                            swal({
                                title: response.message,
                                type: "info",
                                confirmButtonColor: "#8d62d5",
                                confirmButtonText: "Ok"
                            });
                        }
                    }
                });
            }
            else {
                $(ref).trigger('click');
            }
        });
    } 
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>