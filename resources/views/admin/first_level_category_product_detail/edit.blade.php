@extends('admin.layout.master')                

@section('main_content')
<!-- Page Content -->  
 <script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script>  

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
                    <li class="active">{{ $page_title }}</li>
                    
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

                                    <input type="hidden" name="id" id="id" value="{{ $arr_category_productdetails['id'] or '' }}" />
                                    <input type="hidden" name="category_id" id="category_id" value="{{ base64_encode($arr_category_productdetails['category_id'])}}" />

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="image">Image <i class="red">*</i></label>
                                      <div class="col-md-10">
                                      <input type="hidden" name="old_img" value="{{isset($arr_category_productdetails['image'])?$arr_category_productdetails['image']:''}}">
                                      <input type="file" name="image" id="image" class="dropify" 
                                       data-default-file="{{$productdetail_public_img_path}}/{{$arr_category_productdetails['image'] or ''}}"  >
                                       <span id="image_error"></span>
                                      </div>
                                  </div>  
                                      
                                

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Description<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       
                                       <textarea rows="5" name="description" id="description" data-parsley-required="true" class="form-control" data-parsley-required-message="Please enter description">{{ $arr_category_productdetails['description'] }}</textarea>
                                     </div>
                                     <script>
                                      CKEDITOR.replace( 'description' );
                                     </script> 
                                  </div>


                                
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="is_active" id="is_active"
                                         @if($arr_category_productdetails['is_active']=="0") value="0"
                                         @elseif($arr_category_productdetails['is_active']==1) value="1" 
                                         @endif data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();"  @if($arr_category_productdetails['is_active'] =='1') checked="checked" @endif />
                                      </div>    
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
  $(document).ready(function()
  {
    var module_url_path  = "{{ $module_url_path or ''}}";

    var csrf_token = $("input[name=_token]").val(); 
 
    $('#btn_add').click(function()
    {

      if($('#validation-form').parsley().validate()==false) return;
     
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


</script>
@stop