<?php $__env->startSection('main_content'); ?>


<style type="text/css">
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
</style>
 <script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script>


<div class="my-profile-pgnm">
  Edit Forum Post
   <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="<?php echo e(url('/')); ?>/buyer/posts">Forum Posts</a></li> 
      <li><i class="fa fa-angle-right"></i></li>
      <li>Edit Forum Post</li>
    </ul>
</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper"> 
 
<div class="main-my-profile">
   <div class="innermain-my-profile add-product-inrs space-o" style="padding-top: 30px;">
    <form id="validation-form" onsubmit="return false">
        <?php echo e(csrf_field()); ?>

   <div class="profile-img-block">
      

        <input type="hidden" name="id" id="id" value="<?php echo e($arr_post['id']); ?>">
       <input type="hidden" name="old_img" id="old_img" value="<?php echo e(isset($arr_post['image'])? $arr_post['image']:''); ?>">

    </div> 
       <div class="row">
        

            <div class="col-md-12">
                 <div class="form-group">
                    <label for="container_id">Forum Container <span>*</span></label>
                    <div class="select-style">
                      
                        <select class="frm-select" name="container_id" id="container_id" data-parsley-required ='true'  data-parsley-required-message="Please select container">  
                            <option value="">Select container</option>
                            <?php $__currentLoopData = $arr_container; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $container): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e(isset($container['id']) ? $container['id'] : ''); ?>" <?php if($arr_post['container_id']==$container['id']): ?> selected <?php endif; ?>><?php echo e(isset($container['title']) ? $container['title'] : ''); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>

              <div class="col-md-12">
                  <div class="form-group">
                    <label for="product_name">Title <span>*</span></label>
                   
                   <textarea name="title" id="title" rows="4" cols="4" placeholder="Enter forum post title" data-parsley-required ='true' data-parsley-required-message="Please enter forum post title" ><?php echo $arr_post['title'] ?>
                   </textarea>
                    <script>
                        //CKEDITOR.replace( 'title' );
                         CKEDITOR.replace( 'title',
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
              </div>

         

         

             <div class="row"> 
               <div class="col-md-12">
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="product_video_source">Post Type </label>
                    <div class="select-style">
                        <select class="frm-select" name="post_type" id="post_type" onchange="changetypeStatus(this);" >
                            <option value="">Select Type</option>
                            <option value="image" <?php if($arr_post['post_type']=="image"): ?> selected <?php endif; ?>>Image</option>
                            <option value="video" <?php if($arr_post['post_type']=="video"): ?> selected <?php endif; ?>>Video</option>
                            <option value="link" <?php if($arr_post['post_type']=="link"): ?> selected <?php endif; ?>>Link</option>
                        </select>
                    </div>
                 </div>
               </div>
               <div class="col-md-6"></div>
             </div>
           </div>

            <div class="row">
               <div class="col-md-12">
                 <div class="col-md-8 post_image_div" <?php if($arr_post['post_type']=='image'): ?> style="display: block" data-parsley-required ='true' <?php else: ?> style="display: none" <?php endif; ?>>
                     <div class="form-group">
                        <label for="image">Upload Photo <span>* </span></label>
                        <div class="clone-divs none-padding-profile none-padding">
                            <input class="input-text" type="file" name="image" id="image" placeholder="Select Photo" <?php if($arr_post['post_type']=='image' && $arr_post['image']==""): ?> data-parsley-required ='true' data-parsley-required-message="Please select image" <?php endif; ?>  value="<?php echo e($arr_post['image']); ?>" >
                            </div>
                        
                       <span id="showerr"></span> 
                       
                       <?php if(isset($arr_post['post_type']) && $arr_post['post_type']=="image" && isset($arr_post['image']) && !empty($arr_post['image']) && file_exists(base_path().'/uploads/post/'.$arr_post['image'])): ?>    
                                        
                         <img src="<?php echo e(url('/')); ?>/uploads/post/<?php echo e($arr_post['image']); ?>" width="50" height="50">
                       <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8 post_video_div" <?php if($arr_post['post_type']=='video'): ?> style="display: block" data-parsley-required ='true' <?php else: ?> style="display: none" <?php endif; ?>>
                   <div class="form-group">
                      <label for="image"> Video <span>* </span></label>
                      <div class="select-style">
                          <input class="input-text" name="video" id="video" placeholder="Enter youtube video url" <?php if($arr_post['post_type']=='video' ): ?> data-parsley-required ='true' <?php endif; ?> data-parsley-required-message="Please enter video url" value="<?php echo e($arr_post['video']); ?>"  >
                      </div>
                       <span class="price-pdct-fnts">(Please enter youtube link https://www.youtube.com/watch?v=<b>3vauM7axnRs</b>)</span>
                       <span id="youtubeerr"></span>
                     
                  </div>
              </div>

               <div class="col-md-8 post_link_div"  <?php if($arr_post['post_type']=='link'): ?> style="display: block" data-parsley-required ='true' <?php else: ?> style="display: none" <?php endif; ?>>
                   <div class="form-group">
                      <label for="image"> Link <span> </span></label>
                      <div class="select-style">
                          <input class="input-text" name="link" id="link" placeholder="Enter url link"  value="<?php echo e($arr_post['link']); ?>"  <?php if($arr_post['post_type']=='link' ): ?> data-parsley-required ='true' <?php endif; ?>  data-parsley-type="url" data-parsley-type-message="Please enter valid url link">
                      </div>                    
                     
                  </div> 
              </div>
            </div>
          </div>

             <div class="col-md-12">
                 <div class="slr-prdt-mn">
                     <div class="check-box form-group">
                         <input type="checkbox" <?php if($arr_post['is_active']==1): ?> checked="checked" <?php endif; ?> class="css-checkbox is_active" id="checkbox5" name="is_active" value="<?php echo e($arr_post['is_active']); ?> " />
                         <label class="css-label radGroup2" for="checkbox5">Is Active <span></span></label>
                      </div>                     
                      <div class="clearfix"></div>
                 </div>
            </div>


            <div class="col-md-12">
                <div class="button-list-dts">
                    <button class="butn-def" id="btn_add" type="button">Update</button>
                    <a href="<?php echo e(url('/')); ?>/buyer/posts" class="butn-def cancelbtnss">Back</a>
                </div>
            </div>
       </div>
   </form>
   </div>
</div>
</div>


<script>


  /* $('#video').on('input', function(){ 

      var video = $("#video").val();
      if(video!=''){
      if(video.indexOf('youtube') > -1) {
      
           var vidarr = video.split("v=");
           var vid = vidarr[1];
        $("#youtubeerr").hide();
     }else{
     
         $("#youtubeerr").show();
        $("#youtubeerr").html('Please enter valid youtube video url');
        $("#youtubeerr").css('color','red');
        return false;

     }
    }//if video not empty
    else{
     $("#youtubeerr").hide();
    }  
});*/


  function changetypeStatus(type_object) {

    var type = $(type_object).val();
    // alert(video_type);
    if(type === "image")
    {
      $('.post_image_div').show();
      $('#image').attr('data-parsley-required',true);
      $('.post_video_div').hide();
      $('#video').removeAttr('data-parsley-required');
      $('#video').val('');
      $('.post_link_div').hide();
      $('#link').removeAttr('data-parsley-required');
      $('#link').val('');

    }
     else if(type === "video")
    {
      $('.post_video_div').show();
      $('#video').attr('data-parsley-required',true);

      $('.post_image_div').hide();
      $('#image').removeAttr('data-parsley-required');
      $('#image').val('');

      $('.post_link_div').hide();
      $('#link').removeAttr('data-parsley-required');
      $('#link').val('');

    }
     else if(type === "link")
    {
      $('.post_link_div').show();
      $('#link').attr('data-parsley-required',true);

      $('.post_video_div').hide();
      $('#video').removeAttr('data-parsley-required');
       $('#video').val('');

      $('.post_image_div').hide();
      $('#image').removeAttr('data-parsley-required');
      $('#image').val('');
    }
    else
    {
        $('.post_image_div').hide();
        $('#image').removeAttr('data-parsley-required');
        $('#image').val('');

        $('.post_video_div').hide();
        $('#video').removeAttr('data-parsley-required');
        $('#video').val('');

         $('.post_link_div').hide();
         $('#link').removeAttr('data-parsley-required');
         $('#link').val('');

    }

}

//Check image validation on upload file
$("#image").on("change", function(e) 
{
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                           "image/JPG", "image/JPEG", "image/PNG"];
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
      swal('Alert!','Please select valid image type. Only jpg, jpeg and png file is allowed.');

      $('#'+selectedID).val('');

      var previewImageID = selectedID+'_preview';
      $('#'+previewImageID+' + img').remove();
    }
    else
    {
      filePreview(this);
    }
});
</script>
<script type="text/javascript">
  var SITE_URL  = "<?php echo e(url('/')); ?>";

  $(document).ready(function()  
  {


    var csrf_token = $("input[name=_token]").val(); 


    $('#btn_add').click(function()
    {
        var flag=0;
        if($('#validation-form').parsley().validate()==false) return;

        if ($("#checkbox5").is(':checked')) {
          $(".is_active").val('1');
        }else{
             $(".is_active").val('0');
        }



        if(flag==0){


        var ckeditor_title = CKEDITOR.instances['title'].getData();
       
          formdata = new FormData($('#validation-form')[0]);
          formdata.set('title',ckeditor_title);  

    
        $.ajax({                  
          url: SITE_URL+'/buyer/posts/save',
         // data: new FormData($('#validation-form')[0]),
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
              }
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   
       }else{
         return false;
       }

    });

  });





</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>