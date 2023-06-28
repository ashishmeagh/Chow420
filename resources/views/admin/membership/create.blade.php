@extends('admin.layout.master')                

@section('main_content')  
<!-- Page Content -->
 <script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script> 

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
                        <div class="white-box">
                        @include('admin.layout._operation_status')
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    {{ csrf_field() }}

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Plan Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="name" id="name" class="form-control" placeholder="Enter Plan Name" data-parsley-required="true" data-parsley-required-message="Please enter plan name">
                                    </div>
                                     {{--  <span>{{ $errors->first('name') }}</span> --}}
                                  </div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Description<i class="red">*</i></label>

                                    <div class="col-md-10 rw-editor">                                       
                                      <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter Description"></textarea>  
                                       
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
                                       <span class="red" id="error_title"></span>
                                    </div>      

                                  </div>


                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Price ($)<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="price" id="price" class="form-control" placeholder="Enter Price" data-parsley-required="true" data-parsley-required-message="Please enter price"  data-parsley-type="digits" data-parsley-type-message="Please enter valid integer value as a price" data-parsley-maxlength="10">
                                    </div>
                                     {{--  <span>{{ $errors->first('name') }}</span> --}}
                                  </div> 

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Product Count<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="product_count" id="product_count" class="form-control" placeholder="Enter Product Count" data-parsley-required="true" data-parsley-required-message="Please enter product count" data-parsley-type="digits" data-parsley-type-message="Please enter valid product count" data-parsley-maxlength="8">
                                    </div>
                                  </div>
                              

                                    <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="image"> Image <i class="red">*</i></label>
                                    <div class="col-md-10">

                                      <div  id="dynamic_field">
                                           <div class="clone-divs none-margin">
                                              <input type="file" name="image" id="image"  data-max-file-size="2M" data-parsley-required="true" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" data-parsley-required-message="Please select image"> 
                                             
                                          </div>
                                          <span id="image_error">{{ $errors->first('image') }}</span>
                                        </div>
                                    </div>
                                  </div>      

                                 
                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="is_active" id="is_active" value="0" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
                                      </div>    
                                  </div>    

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Free</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="membership_type" id="membership_type" value="2" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_membership_type_status();" />
                                      </div>    
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
  $(document).ready(function()
  {
    var module_url_path  = "{{ $module_url_path or ''}}";

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


        //$("#error_title").html("");

        var ckeditor_description = CKEDITOR.instances['description'].getData();
        formdata = new FormData($('#validation-form')[0]);
        formdata.set('description',ckeditor_description); 
   
        $.ajax({
                  
          url: module_url_path+'/store',
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
              }
              else if('ImageFAILURE' == data.status){
                $("#showerr").html('Allowed only jpg,png,jpeg image file types');
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
@stop