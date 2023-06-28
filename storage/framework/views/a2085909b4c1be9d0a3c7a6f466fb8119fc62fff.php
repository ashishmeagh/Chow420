                

<?php $__env->startSection('main_content'); ?>
<!-- Page Content -->

<link href="<?php echo e(url('/')); ?>/assets/admin/css/fSelect.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/admin/js/fSelect.js"></script>

<script>
(function($) {
    $(function() {
      $('.selectcategory').fSelect({
        placeholder: 'Select Category',
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
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                      <li><a href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><?php echo e(isset($module_title) ? $module_title : ''); ?></a></li>
                      <li class="active">Create State</li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
        
    <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                        <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="country_id" id="country_id" value="<?php echo e(isset($country_id) ? $country_id : ''); ?>" />    

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">State Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="name" id="name" class="form-control" data-parsley-required="true" placeholder="Enter State Name" data-parsley-required-message="Please enter state name"> 
                                    </div>
                                      <span><?php echo e($errors->first('name')); ?></span>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Restrict Category</label> 
                                    <div class="col-md-10">
                                        <select class="form-control selectcategory" name="category_id[]"  multiple="multiple">
                                            <option value="">Select Category</option>
                                            <?php if(isset($arr_category) && sizeof($arr_category)>0): ?>
                                              <?php $__currentLoopData = $arr_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e(isset($category['id'])?$category['id']:''); ?>"><?php echo e(isset($category['product_type'])?ucfirst($category['product_type']):''); ?></option>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                         </select>
                                          <span><?php echo e($errors->first('category_id')); ?></span>
                                    </div>
                                  </div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">State Law</label> 
                                    <div class="col-md-10">

                                         <textarea rows="5" name="state_restricted_text" id="state_restricted_text" class="form-control"  placeholder="Enter state law"></textarea>

                                        <span><?php echo e($errors->first('category_id')); ?></span>

                                    </div>
                                  </div>


                                     
                                       
                                 <div class="form-group row">
                                  <label class="col-md-2 col-form-label">Is Active</label>
                                    <div class="col-sm-6 col-lg-8 controls">
                                       <input type="checkbox" name="state_status" id="state_status" value="1" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262"  />
                                    </div>    
                                </div> 

                                        
                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Add</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>/view_states/<?php echo e(base64_encode($country_id)); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                                       
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
  $(document).ready(function(){

    //$('#validation-form').parsley();

    var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

    var csrf_token = $("input[name=_token]").val(); 
 
    $('#btn_add').click(function(){

      if($('#validation-form').parsley().validate()==false) return;
   
      

      $.ajax({
                  
          url: module_url_path+'/update_state',
          data: new FormData($('#validation-form')[0]),
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
          success:function(data)
          {
            console.log(data);
             if('success' == data.status)
             {
                
                $('#validation-form')[0].reset();

                  swal({
                         title: "Success",
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


  function toggle_status()
  {
      var category_status = $('#category_status').val();
      if(category_status=='1')
      {
        $('#category_status').val('1');
      }
      else
      {
        $('#category_status').val('0');
      }
  }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>