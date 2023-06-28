                
<?php $__env->startSection('main_content'); ?>

<style>
  .myprofile-lefts{text-align: left; width: 100%;}
  .profile-view-seller .myprofile-right{width: 100%; padding-left: 0px; word-break: break-all; }
  .profile-view-seller .myprofile-lefts{text-align: left; width: 100%; }
.profile-view-seller{margin: 0 auto 30px;}
.row{display: block;}
.title-profiles-slrs.fnt-size-large{font-size: 25px;}
.myprofile-main.myprofile-main-nw .myprofile-lefts{    font-weight: normal;}
.myprofile-main.myprofile-main-nw .myprofile-right {
    width: 100%;
    padding-left: 0px;
    font-weight: 600;
    color: #333;
    font-size: 13px;
    margin-top: 5px;
}
span.ans {
    text-transform: uppercase;
    color: #b833cc;
    margin-right: 8px;
    font-weight: normal; font-size: 15px;
}
</style>


<!-- Page Content -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4>
         </div>
         <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">

              <?php
                $user = Sentinel::check();
              ?>

              <?php if(isset($user) && $user->inRole('admin')): ?>
                <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
              <?php endif; ?>
               
               <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/sellers')); ?>">Dispensary</a></li>
               <li class="active"><?php echo e(isset($page_title) ? $page_title : ''); ?></li>
            </ol>
         </div>
         <!-- /.col-lg-12 -->
      </div>
      <!-- .row -->
      <div class="row">
         <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
               <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <div class="col-sm-12 col-xs-12">
                        <div style="font-size: 20px; font-weight: 600; color: #333;cursor: default;" 
                           class="text-" ondblclick="scrollToButtom()" title="Double click to Take Action" >
                        </div>
                  </div>
               <div class="form-group">
                  <div class="col-sm-12 col-lg-12 controls text-center">
                     <h4><b><?php echo e(isset($page_title) ? $page_title : ''); ?></b></h4>
                  </div>
               </div>
                  <div class="profile-view-seller shopsellerview-box">
                     


                     <div class="title-profiles-slrs"><?php echo e(isset($user_arr['first_name']) ? $user_arr['first_name'] : ''); ?> <?php echo e(isset($user_arr['last_name']) ? $user_arr['last_name'] : ''); ?></div>
                     <div class="main-prfl-conts">
                      
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Email</div>
                           <div class="myprofile-right">
                             <?php if(isset($user_arr['email']) && $user_arr['email']!=""): ?> 
                             <?php echo e($user_arr['email']); ?>

                             <?php else: ?>
                             NA
                             <?php endif; ?>
                           </div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Address</div>
                           <div class="myprofile-right">

                            <?php if($user_arr['street_address']=="" && $user_arr['city']=="" && $user_arr['get_state_detail']['name']=="" && $user_arr['get_country_detail']['name']=="" && $user_arr['zipcode']==""): ?>
                              NA
                            <?php else: ?>

                                 <?php if(isset($user_arr['street_address']) && $user_arr['street_address']!=""): ?>
                                 <?php echo e($user_arr['street_address']); ?>

                                 <?php endif; ?>
                                 <?php if(isset($user_arr['city']) && $user_arr['city']!=""): ?>
                                 ,<?php echo e($user_arr['city']); ?>

                                 <?php endif; ?>
                                 <?php if(isset($user_arr['get_state_detail']['name']) && $user_arr['get_state_detail']['name']!=""): ?>
                                 ,<?php echo e($user_arr['get_state_detail']['name']); ?>

                                 <?php endif; ?>
                                 <?php if(isset($user_arr['get_country_detail']['name']) && $user_arr['get_country_detail']['name']!=""): ?>
                                 ,<?php echo e($user_arr['get_country_detail']['name']); ?>

                                 <?php endif; ?>
                                 <?php if(isset($user_arr['zipcode']) && $user_arr['zipcode']!=""): ?>
                                 ,<?php echo e($user_arr['zipcode']); ?>

                                 <?php endif; ?>
                            <?php endif; ?>     
                           </div>
                           <div class="clearfix"></div>
                        </div>

                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Last Login Time</div>
                           <div class="myprofile-right"><?php echo e(isset($user_arr['last_login'])?date('d-M-Y H:i A',strtotime($user_arr['last_login'])):'Not Login Yet!'); ?></div>
                           <div class="clearfix"></div>
                        </div>

                         <div class="myprofile-main">
                           <div class="myprofile-lefts">How did you hear about us?</div>
                           <div class="myprofile-right">
                            <?php if(isset($user_arr['hear_about']) && $user_arr['hear_about']!=''): ?>
                                  <?php echo e($user_arr['hear_about']); ?>

                            <?php else: ?>
                               <?php echo e('NA'); ?>

                            <?php endif; ?>       
                           </div>
                           <div class="clearfix"></div>
                        </div>


                         <div class="myprofile-main">
                           <div class="myprofile-lefts">Domain</div>
                           <div class="myprofile-right">
                            <?php if(isset($user_arr['domain_source']) && $user_arr['domain_source']!=''): ?>
                                  <?php if($user_arr['domain_source']==1): ?>
                                    https://beta.chow420.com/
                                  <?php elseif($user_arr['domain_source']==2): ?>
                                   http://sellonchow.com/
                                  <?php else: ?>
                                    NA
                                  <?php endif; ?>
                            <?php else: ?>
                               <?php echo e('NA'); ?>

                            <?php endif; ?>       
                           </div>
                           <div class="clearfix"></div>
                        </div>




                     </div>
                  </div>
               
         </div>

         <?php if(isset($user_arr['seller_detail']['business_name']) && $user_arr['seller_detail']['business_name']!=""): ?>
         <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
               <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div style="font-size: 20px; font-weight: 600; color: #333; cursor: default;" 
                   class="text-" ondblclick="scrollToButtom()" title="Double click to Take Action" >
                </div>
              <div id="status_msg"></div>
               <div class="form-group">
                  <div class="col-sm-12 col-lg-12 controls text-center">
                     <h4><b>Business Details</b></h4>
                  </div>
               </div>


                  <div class="profile-view-seller shopsellerview-box">
                
                     <div class="main-prfl-conts">
                     <div class="myprofile-main">
                       <div class="myprofile-lefts">Business Name</div>
                       <div class="myprofile-right">
                           <?php if(isset($user_arr['seller_detail']['business_name']) && $user_arr['seller_detail']['business_name']!=""): ?>
                           <?php echo e($user_arr['seller_detail']['business_name']); ?>

                           <?php else: ?>
                           NA
                           <?php endif; ?>

                       </div>
                       <div class="clearfix"></div>
                    </div>
                    </div>


                  

                    
                      
                </div>
    
            </div>
           <?php endif; ?> 

           <!--------------------------bank details------------------------------------->
                   
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
               <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              
               <div class="form-group">
                  <div class="col-sm-12 col-lg-12 controls text-center">
                     <h4><b>Bank Details</b></h4>
                  </div>
               </div>
                  <div class="profile-view-seller shopsellerview-box">                    
                   
                     <div class="main-prfl-conts">
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Registered Name</div>
                            <?php
                             $registered_name = $user_arr['seller_detail']['registered_name'];
                             if($registered_name)
                              $registered_name = $registered_name;
                             else
                              $registered_name = 'NA';
                           ?>
                           <div class="myprofile-right"><?php echo e($registered_name); ?></div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Account Number</div>
                           <?php
                             $account_no = $user_arr['seller_detail']['account_no'];
                             if($account_no)
                              $account_no = $account_no;
                             else
                              $account_no = 'NA';
                           ?>
                           <div class="myprofile-right"><?php echo e($account_no); ?></div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Routing Number</div>
                           <?php
                           $routing_no = $user_arr['seller_detail']['routing_no'];
                           if($routing_no)
                            $routing_no = $routing_no;
                           else
                            $routing_no = 'NA';
                           ?>

                           <div class="myprofile-right"><?php echo e($routing_no); ?></div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Swift Number</div>
                           <?php
                           $switft_no = $user_arr['seller_detail']['switft_no'];
                           if($switft_no)
                            $switft_no = $switft_no;
                           else
                            $switft_no = 'NA';
                           ?>

                           <div class="myprofile-right"><?php echo e($switft_no); ?></div>
                           <div class="clearfix"></div>
                        </div>

                         <div class="myprofile-main">
                           <div class="myprofile-lefts">Paypal Email</div>
                           <?php

                           $paypalemail = $user_arr['seller_detail']['paypal_email'];
                           if($paypalemail)
                            $paypalemail = $paypalemail;
                           else
                            $paypalemail = 'NA';

                           ?>
                           <div class="myprofile-right"><?php echo e($paypalemail); ?></div>
                           <div class="clearfix"></div>
                        </div>
                       
                     </div>
                  </div>
         </div>




            <!-------------------------------------------------------------------->

        
         </div>
         <div class="clearfix"></div>
         <div class="row">
              
            <?php if($user_arr['seller_detail']['seller_question_answer']!=''): ?>
           <div class="col-sm-12">
               <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
               <?php
                  $seller_qa =  json_decode($user_arr['seller_detail']['seller_question_answer']);                 
               ?>
                  <div class="profile-view-seller full-profile-view-seller">
                     <div class="title-profiles-slrs fnt-size-large">Dispensary Questions & Answers</div>
                     <div class="main-prfl-conts">
                        <div class="myprofile-main myprofile-main-nw">
                           <div class="myprofile-lefts"><span>1.</span> <?php echo isset($seller_qa->seller_question1) ? $seller_qa->seller_question1 : ''; ?></div>
                           <div class="myprofile-right"><span class="ans">Ans:</span><?php echo e(isset($seller_qa->seller_answer1) ? $seller_qa->seller_answer1 : ''); ?></div>
                           <div class="clearfix"></div>
                        </div> 
                        <div class="myprofile-main myprofile-main-nw">
                           <div class="myprofile-lefts"><span>2.</span> <?php echo isset($seller_qa->seller_question2) ? $seller_qa->seller_question2 : ''; ?></div>
                           <div class="myprofile-right"><span class="ans">Ans:</span><?php echo e(isset($seller_qa->seller_answer2) ? $seller_qa->seller_answer2 : ''); ?></div>
                           <div class="clearfix"></div>
                        </div>    
                        <div class="myprofile-main myprofile-main-nw">
                           <div class="myprofile-lefts"><span>3.</span> <?php echo isset($seller_qa->seller_question3) ? $seller_qa->seller_question3 : ''; ?></div>
                           <div class="myprofile-right"><span class="ans">Ans:</span><?php echo e(isset($seller_qa->seller_answer3) ? $seller_qa->seller_answer3 : ''); ?></div>
                           <div class="clearfix"></div>
                        </div>                        
                     </div>
                  </div>
               <div class="form-group row">
                  <div class="col-12 text-center">
                     <a class="btn btn-inverse waves-effect waves-light show-btns" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                  </div>
               </div>
         </div>
         <?php endif; ?>
         </div>
      </div>
   </div>
</div>
<!-- END Main Content -->

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>