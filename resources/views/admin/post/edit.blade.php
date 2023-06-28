@extends('admin.layout.master')                

@section('main_content')
<!-- Page Content -->

 <script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script>

<style type="text/css">
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
  .remain-stock {
    color: #873dc8;
    font-size: 13px;
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
                      <li class="active">Edit {{ $module_title or ''}}</li>
                  </ol>
              </div> 
              <!-- /.col-lg-12 -->  
          </div> 
        
                
    <!-- .row -->
                <div class="row"> 
                    <div class="col-sm-12">
                         <h4><span id="showerr"></span></h4>
                        <div class="white-box">
                        @include('admin.layout._operation_status')
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="id" id="id" value="{{ $arr_post['id'] or '' }}" />
                                    <input type="hidden" name="old_img" id="old_img" value="{{ isset($arr_post['image'])? $arr_post['image']:''}}">

                                    


                                   <div class="form-group row">
                                      <label for="container_id" class="col-md-2 col-form-label">User<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select name="user_id" id="user_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select user" disabled="disabled">
                                            <option value="">Select user</option>
                                              @foreach($arr_user as $user)
                                                <option value="{{ $user['id'] or ''}}"  
                                                 @if ($arr_post['user_id'] == $user['id'])
                                                  selected="selected"
                                                @endif>
                          @if((!empty($user['first_name'])) && isset($user['first_name']) || (!empty($user['last_name'])) && isset($user['last_name']))
                                                   {{ $user['first_name'] or '' }} 
                                                   {{ $user['last_name'] or '' }}
                                                   @else
                                                    {{ $user['email'] or '' }}
                                                    @endif
                                               </option>
                                              @endforeach
                                            </select>
                                         </div>
                                  </div>      



                                  <div class="form-group row">
                                      <label for="container_id" class="col-md-2 col-form-label">Forum Container<i class="red">*</i></label>
                                      <div class="col-md-10">
                                        <select name="container_id" id="container_id" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select container" >
                                            <option value="">Select forum container</option>
                                              @foreach($arr_container as $container)
                                                <option value="{{ $container['id'] or ''}}"  
                                                 @if ($arr_post['container_id'] == $container['id'])
                                                  selected="selected"
                                                @endif>
                                               {{ $container['title'] or '' }}</option>
                                              @endforeach
                                            </select>
                                         </div>
                                  </div>   


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title"> Title<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       {{-- <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" value="{{ $arr_post['title'] }}" data-parsley-required ='true' data-parsley-required-message="Please enter post title"> --}}
                                       <textarea name="title" id="title" class="form-control" rows="3" cols="3" placeholder="Enter Title" data-parsley-required ='true' data-parsley-required-message="Please enter post title" >@php echo $arr_post['title'] @endphp</textarea>
                                        <script>
                                           // CKEDITOR.replace( 'title' );
                                            CKEDITOR.replace( 'title',
                                          {
                                            toolbar :
                                            [
                                              
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
                                      <span>{{ $errors->first('title') }}</span>
                                  </div>

                                 
                                
                               {{--    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="description">Description<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <textarea name="description" id="description" class="form-control" placeholder="Enter post description" data-parsley-required="true" data-parsley-required-message="Please enter post description"> {{ $arr_post['description'] }}</textarea> 
                                    </div>
                                      <span>{{ $errors->first('description') }}</span>
                                  </div> --}}

                                   <div class="form-group row">
                                      <label for="container_id" class="col-md-2 col-form-label">Post Type<i class="red"></i></label>
                                      <div class="col-md-10">
                                        <select class="form-control" name="post_type" id="post_type" onchange="changetypeStatus(this);" >
                                            <option value="">Select Type</option>
                                            <option value="image" @if($arr_post['post_type']=="image") selected @endif>Image</option>
                                            <option value="video" @if($arr_post['post_type']=="video") selected @endif>Video</option>
                                            <option value="link" @if($arr_post['post_type']=="link") selected @endif>Link</option>
                                        </select>
                                         </div>
                                  </div>   


                                   <div class="form-group row post_image_div" @if($arr_post['post_type']=='image') style="display: block" data-parsley-required ='true' @else style="display: none" @endif>
                                    <label class="col-md-2 col-form-label" for="image"> Image<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                      <input class="input-text" type="file" name="image" id="image" placeholder="Select Photo" @if($arr_post['post_type']=='image' && $arr_post['image']=="") data-parsley-required ='true' data-parsley-required-message="Please select image" @endif  value="{{ $arr_post['image'] }}"    data-default-file="{{$post_public_img_path}}/{{ $arr_post['image'] }}"  >
                                    </div>
                                      <span>{{ $errors->first('image') }}</span>
                                      <span id="showerr"></span> 

                                      <div class="col-md-2"></div>
                                      <div class="col-md-8"> <br/>
                                         @if(isset($arr_post['post_type']) && $arr_post['post_type']=="image" && isset($arr_post['image']) && !empty($arr_post['image']) && file_exists(base_path().'/uploads/post/'.$arr_post['image']))                    
                                           <img src="{{ url('/') }}/uploads/post/{{ $arr_post['image']}}" width="50" height="50">
                                         @endif
                                      </div>   


                                  </div> 

                                   <div class="form-group row post_video_div" @if($arr_post['post_type']=='video') style="display: block" data-parsley-required ='true' @else style="display: none" @endif>
                                    <label class="col-md-2 col-form-label" for="link"> Video<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="video" id="video" class="form-control" placeholder="Enter youtube video url" @if($arr_post['post_type']=='video' ) data-parsley-required ='true' @endif data-parsley-required-message="Please enter video url" value="{{ $arr_post['video'] }}" >
                                    </div>
                                      <span>{{ $errors->first('video') }}</span>
                                  </div>


                                    <div class="form-group row post_link_div"  @if($arr_post['post_type']=='link') style="display: block" data-parsley-required ='true' @else style="display: none" @endif>
                                    <label class="col-md-2 col-form-label" for="link"> Link<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="link" id="link" class="form-control" placeholder="Enter link" value="{{ $arr_post['link'] }}" data-parsley-type ='url' data-parsley-type-message="Please enter valid url link"  @if($arr_post['post_type']=='link' ) data-parsley-required ='true' @endif>
                                    </div>
                                      <span>{{ $errors->first('link') }}</span>
                                  </div> 

                                
                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Update</button>
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

       var ckeditor_title = CKEDITOR.instances['title'].getData();
       formdata = new FormData($('#validation-form')[0]);
       formdata.set('title',ckeditor_title);  
   
      $.ajax({
                  
          url: module_url_path+'/save',
         // data: new FormData($('#validation-form')[0]),
          data: formdata,
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
              else{
                swal('Alert!',data.description,data.status);
              }  
          }
          
        });   

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
      $('.post_video_div').hide();
      $('#video').removeAttr('data-parsley-required');
      $('#video').val('');

      $('.post_image_div').hide();
      $('#image').removeAttr('data-parsley-required');
      $('#image').val('');

       $('.post_link_div').show();
       $('#link').attr('data-parsley-required',true);

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
@stop