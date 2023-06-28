                

<?php $__env->startSection('main_content'); ?>
<!-- Page Content --> 
 <script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script>  

  <style type="text/css">
   .red{
    color: #FF0000;
    font-size: 14px;
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
                      <li class="active">Edit <?php echo e(isset($module_title) ? $module_title : ''); ?></li>
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


                                    <input type="hidden" name="id" id="id" value="<?php echo e(isset($arr_membership['id']) ? $arr_membership['id'] : ''); ?>" />
                                      <input type="hidden" name="old_img" id="old_img" value="<?php echo e($arr_membership['image']); ?>">

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Plan Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="name" id="name" class="form-control" placeholder="Enter Plan Name" value="<?php echo e(isset($arr_membership['name'])?$arr_membership['name']:''); ?>" data-parsley-required="true" data-parsley-required-message="Please enter plan name"> 
                                    </div>
                                      
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Description<i class="red">*</i></label>
                                    <div class="col-md-10 rw-editor">                                       
                                       <textarea  name="description" id="description" rows="3" class="form-control" placeholder="Enter Description"><?php echo e(isset($arr_membership['description'])?$arr_membership['description']:''); ?></textarea> 

                                       <span class="red" id="error_title"></span> 
                                    </div>
                                      <script>
                                          //  CKEDITOR.replace( 'post_title' );
                                          CKEDITOR.replace( 'description',
                                          {
                                            toolbar :
                                            [
                                              // { name: 'basicstyles', items : [ 'Bold','Italic' ] },
                                              // { name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
                                              // { name: 'tools', items : [ 'Maximize','-','About' ] }
                                            // { name: 'document', items : [ 'NewPage','Preview' ] },
                                              { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
                                              { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
                                              // { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
                                              //             '/',
                                              { name: 'styles', items : [ 'Styles','Format' ] },
                                              { name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
                                              { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
                                              { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                                              { name: 'tools', items : [ 'Maximize','-','About' ] }
                                            ]
                                          });

                                        </script>
                                      

                                  </div>





                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Price ($)<i class="red">*</i></label>
                                    <div class="col-md-10">   
                                      <?php
                                

                                      ?>

                                       <input type="text" name="price" id="price" class="form-control" placeholder="Enter Price" 
                                       value="<?php echo e(isset($arr_membership['price'])?$arr_membership['price']:''); ?>"
                                        data-parsley-required="true" data-parsley-required-message="Please enter price" data-parsley-type="digits" data-parsley-type-message="Please enter valid integer value as a price" data-parsley-maxlength="10"> 
                                    </div>
                                      
                                  </div>

                                

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Product Count<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="product_count" id="product_count" class="form-control" placeholder="Enter Product Count" data-parsley-required="true" data-parsley-required-message="Please enter product count" data-parsley-type="digits" data-parsley-type-message="Please enter valid product count" value="<?php echo e(isset($arr_membership['product_count'])?$arr_membership['product_count']:''); ?>"  data-parsley-maxlength="8">
                                    </div>
                                  </div>



                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_image"> Product Image <i class="red">*</i></label>

                                    <div class="col-md-10">
                                      <div  id="dynamic_field">
                                      <div class="clone-divs none-margin">
                                   

                                    <input type="file" name="image" id="image"  data-max-file-size="2M" class="dropify" data-default-file="<?php echo e($membership_public_img_path); ?>/<?php echo e($arr_membership['image']); ?>">
                                    </div>
                                   <!----------------------------------------------------------->
                                    <span id="image_error"><?php echo e($errors->first('image')); ?></span>
                                    </div>
                                    </div>
                                  </div>      



                                
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="is_active" id="is_active"
                                         <?php if($arr_membership['is_active']=="0"): ?> value="0"
                                         <?php elseif($arr_membership['is_active']==1): ?> value="1" 
                                         <?php endif; ?> data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();"  <?php if($arr_membership['is_active'] =='1'): ?> checked="checked" <?php endif; ?> />
                                      </div>    
                                  </div>   

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Free</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="membership_type" id="membership_type"
                                         <?php if($arr_membership['membership_type']=="2"): ?> value="2"
                                         <?php elseif($arr_membership['membership_type']=="1"): ?> value="1" 
                                         <?php endif; ?> data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_membership_type_status();"  <?php if($arr_membership['membership_type'] =='1'): ?> checked="checked" <?php endif; ?> />
                                        

                                      </div>    
                                  </div>   


                               
                              

                                
                                                  
                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Update</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                                              
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
  $(document).ready(function()
  {
    var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

    var csrf_token = $("input[name=_token]").val(); 
 
    $('#btn_add').click(function()
    {
        var description = CKEDITOR.instances['description'].getData();

        if(description == '')
        { 
            $("#error_title").html("Please enter the description.");
            return;
        }

        if($('#validation-form').parsley().validate()==false) return;

       // $("#error_title").html("");
        

        var ckeditor_description = CKEDITOR.instances['description'].getData();
        formdata = new FormData($('#validation-form')[0]);
        formdata.set('description',ckeditor_description); 

        $.ajax({
                    
            url: module_url_path+'/store',
           // data: new FormData($('#validation-form')[0]),
            data:formdata,
            contentType:false,
            processData:false,
            method:'POST',
            cache: false,
            dataType:'json',
            beforeSend: function() {
                  showProcessingOverlay();
            },
            success:function(data)
            {

              hideProcessingOverlay(); 
               if('success' == data.status)
               {
                  $('#validation-form')[0].reset();

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
                            window.location = data.link;
                         }
                       });
                }else if(data.status=="ImageFAILURE")
                {
                  $("#image_error").html(data.description);
                  $("#image_error").css('color','red');
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
   
      var is_active = $('#is_active').val();
      if(is_active=='0')
      {
        $('#is_active').val('1');
      }
      else
      {
        $('#is_active').val('0');
      }
  }

    function toggle_membership_type_status()
  {
     //2 means paid and 1 means free
      var membership_type = $('#membership_type').val();

      if(membership_type=='2')
      {
        $('#membership_type').val('1');
      }
      else
      {
        $('#membership_type').val('2');
      }
  }


  function toggle_featured()
  {
      var is_featured = $('#is_featured').val();
      if(is_featured=='1')
      {
        $('#is_featured').val('0');
      }
      else if(is_featured=='0')
      {
        $('#is_featured').val('1');
      }
  } 

//Check image validation on upload file
//$(":file").on("change", function(e) 
$("#image").on("change", function(e) 
{   
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                           "image/JPG", "image/JPEG", "image/PNG"];
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
      swal('Alert!','Please select valid image type. Only jpg, jpeg, and png file is allowed.');

      $('#'+selectedID).val('');

      var previewImageID = selectedID+'_preview';
      $('#'+previewImageID+' + img').remove();
    }
    else
    {
      filePreview(this);
    }
});

function filePreview(input) {

    var selectedID      = $(input).attr('id');
    var previewImageID  = selectedID+'_preview';

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+previewImageID+' + img').remove();
            $('#'+previewImageID).after('<img src="'+e.target.result+'" width="100" height="100"/>');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>