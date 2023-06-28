@extends('admin.layout.master')                

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
                    <li class="active">{{ $page_title or ''}}</li>
                    
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
                                    <label class="col-md-2 col-form-label" for="title">Title<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" data-parsley-required="true" data-parsley-required-message="Please enter title">
                                    </div>
                                     {{--  <span>{{ $errors->first('title') }}</span> --}}
                                  </div>  


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Sub Title<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Enter subtitle" data-parsley-required="true" data-parsley-required-message="Please enter subtitle">
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="image">Image <i class="red">*</i></label>
                                    <div class="col-md-10">
                                    <input type="file" name="image" id="image" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" data-parsley-required="true"   data-parsley-required-message="Please select image">
                                    </div>
                                  </div>  
                                      
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="video_url"> Video URL <i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="url" name="video_url" id="video_url" class="form-control" placeholder="Enter video url" data-parsley-required="true" data-parsley-required-message="Please enter video url">
                                    </div>
                                  </div> 
                                  

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="button_title">Button Title</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="button_title" id="button_title" class="form-control" placeholder="Enter button title"  data-parsley-required-message="Please enter title">
                                    </div>
                                  </div>  


                                 <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="button_url"> Button URL</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="button_url" id="button_url" class="form-control" placeholder="Enter button url" data-parsley-required-message="Please enter button url" >
                                    </div>
                                  </div>


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="is_active" id="is_active" value="0" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
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
      if($('#validation-form').parsley().validate()==false) return;
   
      $.ajax({
                  
          url: module_url_path+'/store',
          data: new FormData($('#validation-form')[0]),
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
                         title: data.status,
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
   
      var is_active = $('#is_active').val();
      if(is_active==0)
      {
        $('#is_active').val('1');
      }
      else
      {
        $('#is_active').val('0');
      }
  }

</script>
@stop