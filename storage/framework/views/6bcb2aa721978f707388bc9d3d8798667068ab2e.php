                

<?php $__env->startSection('main_content'); ?> 
<!-- Page Content -->


<style type="text/css">
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
  .error
  {
    color:red;
  }
  .noteallowed{    font-size: 13px;
    color: #b833cc;
    letter-spacing: 0.5px;}
    .clone-divs.none-margin {
    margin-bottom: 0px;
}
</style> 


<link href="<?php echo e(url('/')); ?>/assets/admin/css/fSelect.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/admin/js/fSelect.js"></script>

<script>
(function($) {
    $(function() {
      $('.selectuser').fSelect({
        placeholder: 'Select dispensary',
        numDisplayed: 3,
        overflowText: '{n} selected',
        noResultsText: 'No results found',
        searchText: 'Search',
        showSearch: true,
        showSelectAll: true
    });

     $('.selectbuyer').fSelect({
        placeholder: 'Select buyer',
        numDisplayed: 3,
        overflowText: '{n} selected',
        noResultsText: 'No results found',
        searchText: 'Search',
        showSearch: true,
        showSelectAll: true
    });  

     $('.selectnewsletteremail').fSelect({
        placeholder: 'Select newsletter email',
        numDisplayed: 3,
        overflowText: '{n} selected',
        noResultsText: 'No results found',
        searchText: 'Search',
        showSearch: true,
        showSelectAll: true
    });   


 });
})(jQuery);

</script>



  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> </div>
              <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    <?php
                       $user = Sentinel::check();
                    ?>

                    <?php if(isset($user) && $user->inRole('admin')): ?>
                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                    <?php endif; ?>
                      
                      <li><a href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
                     
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
         
    <!-- .row -->  
                <div class="row">
                  
                    <div class="col-sm-12">
                     <h4> <span id="showerr"></span> </h4>
                        <div class="white-box">
                        <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    <?php echo e(csrf_field()); ?>




                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_name"> Newsletter Template<i class="red">*</i></label>
                                    <div class="col-md-6">                                       
                                     
                                       <select class="form-control" name="template_id" data-parsley-required ='true' data-parsley-required-message="Please select template">
                                          <option value="">Select</option>
                                          <?php if(isset($arr_newslettertemplate)): ?>
                                            <?php $__currentLoopData = $arr_newslettertemplate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsletter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($newsletter['id']); ?>"><?php echo e($newsletter['newsletter_name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php endif; ?>

                                       </select>
                                    </div>
                                      <span><?php echo e($errors->first('template_id')); ?></span>
                                  </div> 

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="seller_id"> Select User<i class="red">*</i></label>
                                    <div class="col-md-3">
                                      <select class="form-control selectuser" name="seller_id[]" data-parsley-required-message="Please select dispensary" multiple="multiple">
                                          <option value="">Select Dispensary</option>
                                          <?php if(isset($arr_seller)): ?>
                                            <?php $__currentLoopData = $arr_seller; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($seller['email']); ?>"><?php echo e($seller['email']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php endif; ?>

                                       </select>
                                        <span><?php echo e($errors->first('seller_id')); ?></span>
                                    </div>
                                     
                                    <div class="col-md-3">
                                      <select class="form-control selectbuyer" name="buyer_id[]" data-parsley-required-message="Please select buyer" multiple="multiple">
                                          <option value="">Select Buyer</option>
                                          <?php if(isset($arr_buyer)): ?>
                                            <?php $__currentLoopData = $arr_buyer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($buyer['email']); ?>"><?php echo e($buyer['email']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php endif; ?>

                                       </select>
                                        <span><?php echo e($errors->first('buyer_id')); ?></span>
                                    </div>
                                     

                                    <div class="col-md-3">
                                      <select class="form-control selectnewsletteremail" name="newsletteremail_id[]" data-parsley-required-message="Please select newsletter email" multiple="multiple">
                                          <option value="">Select Emails</option>
                                          <?php if(isset($arr_newsletter_email)): ?>
                                            <?php $__currentLoopData = $arr_newsletter_email; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsletteremail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($newsletteremail['email']); ?>"><?php echo e($newsletteremail['email']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php endif; ?>

                                       </select>
                                        <span><?php echo e($errors->first('newsletteremail_id')); ?></span>
                                    </div>


                                  </div>
                                  
                                  

                                     <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Send Newsletter</button>
                                
                                              
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


  var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

  $(document).ready(function() 
  {
    var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";
    var csrf_token = $("input[name=_token]").val(); 
 
     $('#btn_add').click(function()
    {
      if($('#validation-form').parsley().validate()==false) return;

       var seller_id = $("#seller_id").val();
       var buyer_id = $("#buyer_id").val();
       var newsletteremail_id = $("#newsletteremail_id").val();

   


      var formdata =  new FormData($('#validation-form')[0]);
     
      $.ajax({
                  
          url: module_url_path+'/save',
          data: formdata,
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
                         title: 'Success',
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
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   

    });

  });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>