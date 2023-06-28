@extends('admin.layout.master')                

@section('main_content') 

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{$page_title or ''}}</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    @php
                        $user = Sentinel::check();
                    @endphp
                    @if(isset($user) && $user->inRole('admin'))
                        <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                    @endif
                    <li><a href="{{$module_url_path or ''}}">{{$module_title or ''}}</a></li>
                    <li class="active">Create Highlight</li>
                </ol>
            </div>
        </div>
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
                                    <label class="col-md-2 col-form-label" for="title" >Title <i class="red">*</i></label>
                                    <div class="col-md-10">
                                        <input type="text" name="title" id="title" class="form-control" placeholder=" Enter Title " data-parsley-required ='true' autocomplete="off" data-parsley-required-message="Please enter title ">
                                        <div id="titleList">
                                        </div>
                                    </div>
                                    <span>{{ $errors->first('title') }}</span>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="description">Description<i class="red">*</i></label>
                                    <div class="col-md-10">
                                        <textarea name="description" data-parsley-maxlength="100" id="description" class="form-control" placeholder="Enter Description" data-parsley-required ='true' data-parsley-required-message="Please enter description"  ></textarea> 
                                    </div>
                                    <span>{{ $errors->first('description') }}</span>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="hilight_image" > Highlight Image <i class="red">*</i></label>
                                    <div class="col-md-10">
                                        <div  id="dynamic_field">
                                            <div class="clone-divs none-margin">
                                                <input type="file" name="hilight_image" id="hilight_image"  data-max-file-size="2M" data-parsley-required="true" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" data-parsley-required-message="Please select highlight image"> 
                                                <div class="noteallowed red">( Allowed only jpg,jpeg and png file formats.)</div>                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               

                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Save</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path or ''}}"><i class="fa fa-arrow-left"></i> Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script>  
<script type="text/javascript"> 

    $("#hilight_image").on("change", function(e) {

        var selectedID      = $(this).attr('id');
        var fileType        = this.files[0].type;
        var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                               "image/JPG", "image/JPEG", "image/PNG"];
      
        if($.inArray(fileType, validImageTypes) < 0) {

            swal('Alert!','Please select valid image type. Only jpg, jpeg, and png file is allowed.');

            $('#'+selectedID).val('');

            var previewImageID = selectedID+'_preview';

            $('#'+previewImageID+' + img').remove();
        }
        else {

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


    $('#btn_add').click(function() {
    
        if($('#validation-form').parsley().validate()==false) return;

        var formdata = new FormData($('#validation-form')[0]);

        var module_url_path     = "{{ $module_url_path or ''}}";

        var title           = $('#title').val();
        var description     = $('#description').val();
        var _token          =  "{{ csrf_token() }}";

        $.ajax({
            method   : 'POST',
            dataType : 'JSON',
            data     : formdata,
            url      : module_url_path+'/save',
            contentType : false,
            processData : false,
            beforeSend : function() {

                showProcessingOverlay();        
            },
            success:function(data) {

                hideProcessingOverlay(); 

                if('success' == data.status) {
              
                    $('#validation-form')[0].reset();

                    swal({
                        title: 'Success',
                        text: data.description,
                        type: data.status,
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    },
                    function(isConfirm,tmp) {

                        if(isConfirm==true) {

                          window.location = data.link;
                        }
                    });
                }
                else if(data.status=="ImageFAILURE")
                {
                     sweetAlert('Alert!',data.description,"error");
                }            
                else {
                    
                    swal('Alert!',data.description,data.status);
                }  
            }
        }); 
    });
</script>
@stop