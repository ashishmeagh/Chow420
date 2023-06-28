@extends('admin.layout.master')                

@section('main_content') 
<!-- Page Content -->
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
                <li class="active">{{ $page_title or ''}}</li>
                
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                @include('admin.layout._operation_status')
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                            {{ csrf_field() }}

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                    <input name="name" id="name" class="form-control" placeholder="Enter Name" data-parsley-required="true" data-parsley-required-message="Please enter name">
                                    </div>
                                    {{--  <span>{{ $errors->first('name') }}</span> --}}
                                </div>  

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                    <div class="col-sm-6 col-lg-8 controls">
                                       <input type="checkbox" name="is_active" id="is_active" value="0" data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
                                    </div>    
                                </div>

                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Add</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path or ''}}"><i class="fa fa-arrow-left"></i> Back</a>
                                
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
            
      var formdata = new FormData($('#validation-form')[0]);
    //   formdata.set('name'); 

      $.ajax({
                  
          url: module_url_path+'/store',
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
    if(is_active == 0)
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