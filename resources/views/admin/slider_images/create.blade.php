@extends('admin.layout.master')                

<style type="text/css">
  .form-group.errorcread .parsley-errors-list{ 
        position: absolute;
    left: 6px;
    bottom: -5px;
  }
  .parsley-errors-list{ margin: 5px 0 3px;}
  .size-img{
    display: block;text-align: left; font-size: 13px; color: #099c29;
  }
  .form-group.errorcread .error-img-size .parsley-errors-list{ 
  display: block; position: static;
  }
  .dropify-wrapper~.dropify-errors-container ul{margin-top: 0px  !important;margin-bottom: 0px  !important;}
  .dropify-wrapper~.dropify-errors-container ul li {
    margin-left: 0 !important;
    color: #F34141;
    font-weight: 100  !important;
    font-size: 15px;
} 
</style>

@section('main_content') 
<!-- Page Content -->
 
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
                      <li class="active">Create Slider Image</li>
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
                                    <label class="col-md-2 col-form-label" for="title">Title</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title">
                                    </div>
                                     {{--  <span>{{ $errors->first('title') }}</span> --}}
                                  </div>


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Sub Title</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Enter Sub Title">
                                    </div>
                                      {{-- <span>{{ $errors->first('subtitle') }}</span> --}}
                                  </div> 

                                  <div class="form-group errorcread row">
                                    <label class="col-md-2 col-form-label" for=""> Image (Large Size) <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="file" name="slider_image" id="slider_image" class="dropify"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" data-parsley-required="true" data-parsley-required-message="Please select image">
                                      <span class="error-img-size" id="image_error">{{ $errors->first('slider_image') }}</span>
                                    <span class="size-img"> (<b>Suggested size:</b>  1920px X 775px )   </span>
                                    
                                    </div>
                                  </div>   

                                   <div class="form-group errorcread row">
                                    <label class="col-md-2 col-form-label" for=""> Image (Medium Size) <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="file" name="slider_medium" id="slider_medium" class="dropify"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error_medium" data-parsley-required="true" data-parsley-required-message="Please select image">
                                      <span class="error-img-size" id="image_error_medium">{{ $errors->first('slider_medium') }}</span>
                                    <span class="size-img"> (<b>Suggested size:</b> ( 700px X 400px )   </span>
                                     
                                    </div>
                                  </div>   
 


                                   <div class="form-group errorcread row">
                                    <label class="col-md-2 col-form-label" for=""> Image (Small Size) <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="file" name="slider_small" id="slider_small" class="dropify"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error_small" data-parsley-required="true" data-parsley-required-message="Please select image">
                                      <span class="error-img-size" id="image_error_small">{{ $errors->first('slider_small') }}</span>
                                    <span class="size-img"> (<b>Suggested size:</b> ( 621px X 300px )   </span>
                                    </div>
                                  </div>   

                                      
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="image_url"> Image URL  <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="image_url" id="image_url" class="form-control" placeholder="Enter Image URL" data-parsley-required="true" data-parsley-required-message="Image URL is required" data-parsley-type="url">
                                    </div>
                                      {{-- <span>{{ $errors->first('image_url') }}</span> --}}
                                  </div> 
                                  

                                 <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Button Title</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="slider_button" id="slider_button" class="form-control" placeholder="Enter button title">
                                    </div>
                                     {{--  <span>{{ $errors->first('title') }}</span> --}}
                                  </div> 


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Title Color</label>
                                    <div class="col-md-10">                                       
                                       <input type="color" name="title_color" id="title_color" class="form-control" placeholder="Select title color">
                                    </div>
                                     {{--  <span>{{ $errors->first('title') }}</span> --}}
                                  </div> 

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Subtitle Color</label>
                                    <div class="col-md-10">                                       
                                       <input type="color" name="subtitle_color" id="subtitle_color" class="form-control" placeholder="Select sub title color">
                                    </div>
                                     {{--  <span>{{ $errors->first('title') }}</span> --}}
                                  </div> 

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Button Text Color</label>
                                    <div class="col-md-10">                                       
                                       <input type="color" name="button_color" id="button_color" class="form-control" placeholder="Select button title color">
                                    </div>
                                     {{--  <span>{{ $errors->first('title') }}</span> --}}
                                  </div> 


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Button Background Color</label>
                                    <div class="col-md-10">                                       
                                       <input type="color" name="button_back_color" id="button_back_color" class="form-control" placeholder="Select button background color">
                                    </div>
                                     {{--  <span>{{ $errors->first('title') }}</span> --}}
                                  </div> 
 

                                  <div class="form-group row">
                                  <label class="col-md-2 col-form-label">Is Active</label>
                                    <div class="col-sm-6 col-lg-8 controls">
                                       <input type="checkbox" name="is_active" id="is_active" value="1" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
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


  function toggle_status()
  {
      var is_active = $('#is_active').val();
      if(is_active=='1')
      {
        $('#is_active').val('1');
      }
      else
      {
        $('#is_active').val('0');
      }
  }


  $(document).ready(function()
  {
    var module_url_path  = "{{ $module_url_path or ''}}";

    var csrf_token = $("input[name=_token]").val(); 
 
    $('#btn_add').click(function() 
    {
      if($('#validation-form').parsley().validate()==false) return;
   
      $.ajax({
                  
          url: module_url_path+'/store',
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

             if('success' == data.status)
             {
                 hideProcessingOverlay(); 
                $('#validation-form')[0].reset();

                  swal({
                         title: "Success!",
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
@stop