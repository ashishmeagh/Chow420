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
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                      <li><a href="{{$module_url_path or ''}}">{{$module_title or ''}}</a></li>
                      <li class="active">{{$page_title or ''}}</li>
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
                                    {!! Form::open([ 'url' => "{{ url(config('app.project.admin_panel_slug').'/general_settings/update') }}",
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal',
                                 'id'=>'validation-form' 

                                ]) !!} 

                                  <input type="hidden" name="id" id="id" value="{{$enc_id or ''}}" />

                                      <div class="form-group row">
                                          <label class="col-md-2 col-form-label" for="data_id"> Data ID <i class="red">*</i></label>
                                          <div class="col-10">
                                              <input type="text" name="data_id" class="form-control" value="{{$arr_general_settings['data_id'] or ''}}" disabled="">
                                          </div>
                                            <span>{{ $errors->first('data_id') }}</span>
                                      </div>

                                       <div class="form-group row">
                                          <label class="col-md-2 col-form-label" for="data_value"> Data Value <i class="red">*</i></label>
                                          <div class="col-md-10">
                                              <input type="text" name="data_value" class="form-control" data-parsley-required="true" placeholder="Enter Data Value" value="{{$arr_general_settings['data_value'] or ''}}">
                                          </div>
                                            <span>{{ $errors->first('data_value') }}</span>
                                      </div>

                                      <div class="form-group row">
                                          <label class="col-md-2 col-form-label" for="data_live"> Data Live </label>
                                          <div class="col-md-10">
                                              <input type="text" name="data_live" class="form-control" placeholder="Enter Data Live" value="{{$arr_general_settings['data_live'] or ''}}">
                                          </div>
                                            <span>{{ $errors->first('data_live') }}</span>
                                      </div>

                                      <div class="form-group row">
                                          <label class="col-md-2 col-form-label" for="data_sandbox"> Data Sandbox </label>
                                          <div class="col-md-10">
                                              <input type="text" name="data_sandbox" class="form-control" placeholder="Enter Data Sandbox" value="{{$arr_general_settings['data_sandbox'] or ''}}">
                                          </div>
                                            <span>{{ $errors->first('data_sandbox') }}</span>
                                      </div>
                                                                      
    
                                        <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_update">Update</button>
                                        <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path or ''}}"><i class="fa fa-arrow-left"></i> Back</a>
                                        <!-- form-group -->
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
  $(document).ready(function(){

  var module_url_path  = "{{ $module_url_path or ''}}";

  $('#btn_update').click(function(){

  if($('#validation-form').parsley().validate()==false) return;
   
      $.ajax({
                  
          url: module_url_path+'/update',
          data: new FormData($('#validation-form')[0]),
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
          success:function(data)
          {

              if('success' == data.status)
              {
                
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
                 swal('warning',data.description,data.status);
              }  
          }
          
        });   

      });


  });
</script>
@stop