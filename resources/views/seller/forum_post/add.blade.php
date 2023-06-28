@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
</style> 


<div class="my-profile-pgnm">
  Add Forum Post

     <ul class="breadcrumbs-my">
     <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/seller/posts"> Forum Posts</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Add Forum Post</li>
    </ul> 
</div>
<div class="new-wrapper">

<div class="main-my-profile"> 
   <div class="innermain-my-profile add-product-inrs space-o">
    <form id="validation-form">
        {{ csrf_field() }}
   {{-- <div class="profile-img-block">
        <div class="pro-img"><img src="{{url('/')}}/assets/images/default-product-image.png" class="img-responsive img-preview" alt=""/></div>                            
        <div class="update-pic-btns">
            <button class="up-btn"> <span><i class="fa fa-camera"></i></span></button>
            <input style="height: 100%; width: 100%; z-index: 99;" id="logo-id" name="product_image"  type="file" class="attachment_upload" data-parsley-required=true data-parsley-required-message="Please Upload file">
        </div> 
        <div class="upload-product-img">Upload Product Image</div>                           
    </div>  --}}
       <div class="row">  
{{--          <h4> <span id="showerr"></span> </h4>
 --}}
            <div class="col-md-12">
                 <div class="form-group">
                    <label for="container_id">Forum Container <span>*</span></label>
                    <div class="select-style">
                        <select class="frm-select" name="container_id" id="container_id"  data-parsley-required ='true' data-parsley-required-message="Please select forum container">
                            <option value="">Select forum container</option>
                            @foreach($arr_container as $container)
                              <option value="{{ $container['id'] or ''}}">{{ $container['title'] or '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

          <div class="col-md-12">
                 <div class="form-group">
                    <label for="product_name">Title <span>*</span></label>
                    <input type="text" name="title" id="title" class="input-text" placeholder="Enter forum post title" data-parsley-required-message="Please enter forum post title" data-parsley-required ='true'>
                </div>
          </div>

        

           {{-- 
            <div class="col-md-12">
                 <div class="form-group">
                    <label for="description"> Description <span>*</span></label>
                    <textarea name="description" id="description" placeholder="Add forum post description" data-parsley-required ='true' data-parsley-required-message="Please enter forum post description"></textarea>
                </div>
            </div>  --}}
            <div class="col-md-12 post_link_div">
                 <div class="form-group">
                    <label for="image"> Link <span> </span></label>
                    <div class="select-style">
                        <input class="input-text" name="link" id="link" placeholder="Enter url link"  value="" data-parsley-type="url" data-parsley-type-message="Please enter valid url link">
                    </div>                    
                   
                </div> 
            </div>

           <div class="col-md-6">
                 <div class="form-group">
                    <label for="product_video_source">Post Type </label>
                    <div class="select-style">
                        <select class="frm-select" name="post_type" id="post_type" onchange="changetypeStatus(this);" >
                            <option value="">Select Type</option>
                            <option value="image" >Image</option>
                            <option value="video" >Video</option>
                        </select>
                    </div>
                </div>
            </div>

             <div class="col-md-6 post_image_div"  style="display: none" >
                 <div class="form-group">
                    <label for="image">Upload Photo <span>* </span></label>
                    <div class="select-style">
                        <input class="input-text" type="file" name="image" id="image" placeholder="Select Photo"  data-parsley-required-message="Please select image"  value="" >
                    </div>

                   <span id="showerr"></span> 
                </div>
            </div>
              <div class="col-md-6 post_video_div" style="display: none">
                 <div class="form-group">
                    <label for="image"> Video <span>* </span></label>
                    <div class="select-style">
                        <input class="input-text" name="video" id="video" placeholder="Enter youtube video url"  data-parsley-required-message="Please enter video url" value="" >
                    </div>
                     <span class="price-pdct-fnts">(Please enter youtube link https://www.youtube.com/watch?v=<b>3vauM7axnRs</b>)</span>
                   
                </div>
            </div>



           


            <input type="hidden" id="checkbox5" name="is_active" value="1" />
           
                  
            <div class="col-md-12">
                <div class="button-list-dts">
                    <a href="javascript:void(0)" class="butn-def" id="btn_add">Add</a>
                    <a href="{{ url('/') }}/seller/posts" class="butn-def cancelbtnss">Back</a>
                </div>
            </div>
       </div>
   </form>
   </div>
</div>
</div>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

<script type="text/javascript">
  var SITE_URL  = "{{ url('/')}}";

  $(document).ready(function()
  {
    
     

    var csrf_token = $("input[name=_token]").val(); 


    $('#btn_add').click(function()
    {
        var flag=0;
        if($('#validation-form').parsley().validate()==false) return;

        if(flag==0){
    
        $.ajax({                  
          url: SITE_URL+'/seller/posts/save',
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
              else if('ImageFAILURE' == data.status){
                $("#showerr").html('Only jpg,png,jpeg extenstions allowed');
                $("#showerr").css('color','red');
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

<script>
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
    }
     else if(type === "video")
    {
      $('.post_video_div').show();
      $('#video').attr('data-parsley-required',true);

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
@endsection