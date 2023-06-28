@extends('admin.layout.master')                

@section('main_content') 
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
    color: #873dc8;
    letter-spacing: 0.5px;}
    .clone-divs.none-margin {
    margin-bottom: 0px;
}
</style> 
   
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    @php
                     $user = Sentinel::check();
                    @endphp

                    @if(isset($user) && $user->inRole('admin'))
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                    @endif
                      
                    <li><a href="{{$module_url_path or ''}}">{{$module_title or ''}}</a></li>
                    <li class="active">Create {{ $module_title or '' }}</li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
         
    <!-- .row -->  
                <div class="row">
                  
                    <div class="col-sm-12">
                     <h4> <span id="showerr"></span> </h4>
                        <div class="white-box">
                        @include('admin.layout._operation_status')
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    {{ csrf_field() }}


                                   <div class="form-group row">
                                      <label for="container_id" class="col-md-2 col-form-label"> Forum Container<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select name="container_id" id="container_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select forum container">
                                            <option value="">Select forum container</option>
                                              @foreach($arr_container as $container)
                                                <option value="{{ $container['id'] or ''}}">{{ $container['title'] or '' }}</option>
                                              @endforeach
                                            </select>
                                         </div>
                                  </div>
                                     


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_name">Title<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" data-parsley-required ='true' data-parsley-required-message="Please enter post title">
                                    </div>
                                      <span>{{ $errors->first('title') }}</span>
                                  </div>

                                 


                                 {{--  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="description">Description<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <textarea name="description" id="description" rows="4" class="form-control" placeholder="Enter post description" data-parsley-required="true" data-parsley-required-message="Please enter post description" ></textarea> 
                                    </div>
                                      <span>{{ $errors->first('description') }}</span>
                                  </div> --}}

                                  <div class="form-group row">
                                      <label for="container_id" class="col-md-2 col-form-label">Post Type<i class="red"></i></label>
                                      <div class="col-md-10">
                                        <select class="form-control" name="post_type" id="post_type" onchange="changetypeStatus(this);" >
                                            <option value="">Select Type</option>
                                            <option value="image">Image</option>
                                            <option value="video">Video</option>
                                            <option value="link">Link</option>
                                        </select>
                                         </div>
                                  </div>   


                                   <div class="form-group row post_image_div"  style="display: none" >
                                    <label class="col-md-2 col-form-label" for="image"> Image<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                      <input class="input-text" type="file" name="image" id="image" placeholder="Select Photo"  data-parsley-required-message="Please select image"  value="" >
                                    </div>
                                      <span>{{ $errors->first('image') }}</span>
                                       <span id="showerr"></span> 
                                  </div>

                                   <div class="form-group row post_video_div"  style="display: none" >
                                    <label class="col-md-2 col-form-label" for="link"> Video<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="video" id="video" class="form-control" placeholder="Enter youtube video url"  data-parsley-required-message="Please enter video url" value="" >
                                    </div>
                                      <span>{{ $errors->first('video') }}</span>
                                  </div>

                                   <div class="form-group row post_link_div" tyle="display: none" >
                                    <label class="col-md-2 col-form-label" for="link"> Link<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="link" id="link" class="form-control" placeholder="Enter link" value="" data-parsley-type ='url' data-parsley-type-message="Please enter valid url link">
                                    </div>
                                      <span>{{ $errors->first('link') }}</span>
                                  </div> 



                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Add</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path or ''}}"><i class="fa fa-arrow-left"></i> Back</a>
                                              
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

  var module_url_path  = "{{ $module_url_path or ''}}";

  $(document).ready(function() 
  {
    var module_url_path  = "{{ $module_url_path or ''}}";
    var csrf_token = $("input[name=_token]").val(); 

    
    $('#btn_add').click(function()
    {
      if($('#validation-form').parsley().validate()==false) return;
   
      $.ajax({
                  
          url: module_url_path+'/save',
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
              }else if('ImageFAILURE' == data.status){
                $("#showerr").html('Only jpg,png,jpeg extenstions allowed');
                $("#showerr").css('color','red');
              }
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   

    });

  });




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

      $('.post_image_div').hide();
      $('#image').removeAttr('data-parsley-required');
      $('#image').val('');

      $('.post_video_div').hide();
      $('#video').removeAttr('data-parsley-required');
      $("#video").val('');
      
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
@stop