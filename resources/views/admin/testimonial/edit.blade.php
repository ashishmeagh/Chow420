@extends('admin.layout.master')                

@section('main_content')
<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$module_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                      <li><a href="{{$module_url_path}}">{{$module_title or ''}}</a></li>
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

         
            {!! Form::open([ 
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal',
                                 'id'=>'validation-form' 

                                ]) !!} 

           {!! Form::hidden('user_id',isset($arr_testimonial['id']) ? $arr_testimonial['id']: "")!!}


            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="user_name"> User Name <i class="red">*</i></label>
              <div class="col-md-10">                
                   <input type="text" class="form-control" name="user_name" placeholder="Enter User Name" data-parsley-required="true" value="{{ $arr_testimonial['name'] or ''}}" />
                     <span class="red">{{ $errors->first('user_name') }}</span>
              </div>                
            </div>

           <div class="form-group row">
               <label class="col-md-2 col-form-label" for="description"> Description <i class="red">*</i></label>
                <div class="col-md-10">
                  <textarea name="description" id="description" data-parsley-required="true" class="form-control" cols="10" rows="5" maxlength="200" data-parsley-maxlength="200"/>{{ $arr_testimonial['description'] or '' }}</textarea>
                </div>
            </div>
 

            <div class="form-group row">
               <label class="col-2 col-form-label" for="profile_image">Profile Image <i class="red">*</i></label>
               @php
                $profile_image = isset($arr_testimonial['profile_photo'])?$arr_testimonial['profile_photo']:'';

                $is_active = isset($arr_testimonial['is_active'])?$arr_testimonial['is_active']:'';
               @endphp
                <div class="col-md-10">
                  <input type="file" name="profile_image" id="profile_image" class="dropify" data-default-file="{{ $user_profile_public_img_path.$profile_image}}" />
                </div>
            </div>

            <div class="form-group row">
              <label class="col-2 col-form-label" for="social_name"> Twitter User Name <i class="red">*</i></label>
              <div class="col-10">  
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">@</span>
                    <input type="text" class="form-control" name="social_name" placeholder="Enter Twitter User Name" data-parsley-required="true" value="{{ $arr_testimonial['social_name'] or '' }}" />
                    <span class="red">{{ $errors->first('social_name') }}</span>
                  </div>             
              </div>                
            </div>
            
            <div class="form-group row">
                  <label class="col-md-2 col-form-label"> Status<i class="red">*</i></label>
                  <div class="col-md-10">
                      <input type="checkbox" name="is_active" id="is_active" value="1" data-size="small" class="js-switch " @if($is_active=='1') checked="checked" @endif data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
                  </div>
              </div>  


            <div class="form-group row">
              <div class="col-md-10">
                <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_add">Update</button>
                <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
              </div>
            </div>
           
          <input type="hidden" name="enc_id" id="enc_id" value="{{ isset($arr_testimonial['id'])?$arr_testimonial['id']:false }}">

          <input type="hidden" name="old_image" id="old_image" value="{{ isset($arr_testimonial['profile_photo'])?$arr_testimonial['profile_photo']:false }}">
    
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
 var module_url_path  = "{{ $module_url_path or ''}}";
   
$(document).ready(function(){
    
 $('#btn_add').click(function(){

  if($('#validation-form').parsley().validate()==false) return;
   
      $.ajax({
                  
          url: module_url_path+'/save',
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
                          // window.location = data.link;
                          location.reload(true);
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
