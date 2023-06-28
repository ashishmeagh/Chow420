                
<?php $__env->startSection('main_content'); ?>
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
         <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
         <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/sub_admins')); ?>">Sub Admin</a></li>
         <li class="active"><?php echo e(isset($page_title) ? $page_title : ''); ?></li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>

<!-- .row -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box white-gray-bx-mn">
         <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <div class="row">
            <div class="col-sm-12 col-xs-12">
                 <h3>
                    <span 
                       class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action" >
                    </span>
                 </h3>
            </div>
          </div>
        


<div class="col-sm-12">
   <div class="white-box mgntop">

    <div class="main-prfl-conts">
     
     


             <div class="main-prfl-conts">
             
             <div class="row">
                  <div class="col-sm-6">
                    <div class="myprofile-main nm-show-txt">
                       <div class="myprofile-lefts">Name </div>
                       <div class="myprofile-right">
                        <?php echo e(isset($user_arr['first_name']) ? $user_arr['first_name'] : ''); ?> 
                        <?php echo e(isset($user_arr['last_name']) ? $user_arr['last_name'] : ''); ?>

                       </div>
                       <div class="clearfix"></div>
                  </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="myprofile-main  nm-show-txt">
                   <div class="myprofile-lefts">Email</div>
                   <div class="myprofile-right">
                       <?php
                        if($user_arr['email'])
                          $email = $user_arr['email'];
                        else
                          $email = 'NA';
                       ?>
                          <?php echo e($email); ?>

                   </div>
                   <div class="clearfix"></div>
              </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="myprofile-main  nm-show-txt">
                       <div class="myprofile-lefts">Address</div>
                       <div class="myprofile-right">
                           <?php
                            if($user_arr['street_address'])
                              $street_address = $user_arr['street_address'];
                            else
                              $street_address = 'NA';
                           ?>
                              <?php echo e($street_address); ?>

                       </div>
                       <div class="clearfix"></div>
                  </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="myprofile-main  nm-show-txt">
                       <div class="myprofile-lefts">City</div>
                       <div class="myprofile-right">
                           <?php

                            if($user_arr['city'])
                              $city = $user_arr['city'];
                            else
                              $city = 'NA';
                           ?>
                              <?php echo e($city); ?>

                       </div>
                       <div class="clearfix"></div>
                  </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="myprofile-main  nm-show-txt">
                         <div class="myprofile-lefts">State</div>
                         <div class="myprofile-right">
                             <?php
                              if($user_arr['get_state_detail']['name'])
                                $state = $user_arr['get_state_detail']['name'];
                              else
                                $state = 'NA';
                             ?>
                                <?php echo e($state); ?>

                         </div>
                         <div class="clearfix"></div>
                    </div>  
                  </div>
                  <div class="col-sm-6">
                    <div class="myprofile-main  nm-show-txt">
                         <div class="myprofile-lefts">Country</div>
                         <div class="myprofile-right">
                             <?php
                              if($user_arr['get_country_detail']['name'])
                                $country = $user_arr['get_country_detail']['name'];
                              else
                                $country = 'NA';
                             ?>
                                <?php echo e($country); ?>

                         </div>
                         <div class="clearfix"></div>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="myprofile-main  nm-show-txt">
                         <div class="myprofile-lefts">Zipcode</div>
                         <div class="myprofile-right">
                             <?php
                          
                              if($user_arr['zipcode'])
                                $zipcode = $user_arr['zipcode'];
                              else
                                $zipcode = 'NA';
                             ?>
                                <?php echo e($zipcode); ?>

                         </div>
                         <div class="clearfix"></div>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="myprofile-main  nm-show-txt">
                       <div class="myprofile-lefts">Last Login</div>
                       <div class="myprofile-right"><?php echo e(isset($user_arr['last_login'])?date('d-M-Y H:i A',strtotime($user_arr['last_login'])):'Not Login Yet!'); ?></div>
                       <div class="clearfix"></div>
                  </div>
                  </div>
              </div>

             </div>
          </div>

               
         </div>
         <div class="white-box mgntop">


          <div class="d-flex module-permission-ttl">
            <h4 class="m-0"><b>Modules Permission</b></h4>
            <div class="module-permission-btn">
              <a class="btn btn-inverse waves-effect waves-light show-btns m-0" id="btn_check_all">Check All</a>

              <a class="btn btn-inverse waves-effect waves-light show-btns m-0" id="btn_uncheck_all"> Uncheck All</a>
            </div>
          </div>
   

         <div class="row">
          <div class="row">
          
            

              <?php if(isset($module_arr) && count($module_arr)>0): ?>
  
               <?php $__currentLoopData = $module_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                 <div class="col-md-4">
 
                      <div class="checkbox chckboxlisthere clearfix">

                          <div class="form-check checkbox-theme">
                              <input class="form-check-input" type="checkbox" id="module_<?php echo e($module['id']); ?>" name="module[]" value="<?php echo e(isset($module['id']) ? $module['id'] : ''); ?>" <?php if(in_array($module['id'],$assigned_modules_arr)): ?> checked <?php endif; ?>>
                              <label class="form-check-label" for="module_<?php echo e($module['id']); ?>">
                                  <?php echo e(isset($module['module_name'])?$module['module_name']:''); ?>

                              </label>

                          </div>

                      </div> 

                  </div>          

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          <?php endif; ?>  
        

           </div>
         </div>

            <div class="pull-right">
              <a class="btn btn-inverse waves-effect waves-light show-btns" sub-admin-id="<?php echo e(isset($user_arr['id']) ? $user_arr['id'] : ''); ?>" onclick="return AssignModule(this);">Submit</a>
            
            </div>
            <div class="clearfix"></div>

         </div>

         <div class="form-group row">
            <div class="col-12 text-center">
               <a class="btn btn-inverse waves-effect waves-light show-btns" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
         </div>
         
      </div>
               </div>
            </div>
         </div>
      </div>
<!-- END Main Content -->

<script type="text/javascript">

  var module_url_path = '<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>';


  $("#btn_check_all").click(function(){
    
      $('input:checkbox').each(function(){
        $(this).prop('checked',true);
       })   
 
  });



  $("#btn_uncheck_all").click(function(){
    
      $('input:checkbox').each(function(){
        $(this).prop('checked',false);
       })   
 
  });




  function AssignModule(ref)
  {
      var module_arr = new Array();

      $.each($("input[name='module[]']:checked"), function() {

      module_arr.push($(this).val());

      });

   
      var sub_admin_id = $(ref).attr('sub-admin-id');

      if(module_arr.length == 0)
      {
          swal('Error',"Please assign the modules permission.","error");
          return false;
      }


      $.ajax({              
                url: module_url_path+'/asign_module',
                data: {sub_admin_id:sub_admin_id,module_arr:module_arr, _token:"<?php echo e(csrf_token()); ?>"},
                method:'POST',
                dataType:'json',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success:function(data)
                {   
                     
                    hideProcessingOverlay();

                    if( data.status == 'success')
                    {            
                        //swal('Success',data.description,data.status);

                        swal({
                         title:'Success',
                         text: data.description,
                         type: data.status,
                         confirmButtonText: "OK",
                         closeOnConfirm: false
                        },
                        function(isConfirm,tmp)
                        {
                          if(isConfirm==true)
                          {
                            window.location.reload();
                          }

                        });
                    }
                    else
                    {
                       swal('Error',data.description,data.status);
                       
                    }  
                }      
          });
 
 }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>