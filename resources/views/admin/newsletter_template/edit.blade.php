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
<script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script>  
 
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    @php
                      $user = Sentinel::check();
                    @endphp

                    @if(isset($user) && $user->inRole('admin'))
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                    @endif
                      
                    <li><a href="{{$module_url_path or ''}}">{{$module_title or ''}}</a></li>
                    <li class="active">Edit {{$module_title or ''}}</li>
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

                                    <input type="hidden" name="id" id="id" value="{{ $arr_newsletter['id'] or '' }}" />

                                     
                             
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="newsletter_name"> Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="newsletter_name" id="newsletter_name" class="form-control" placeholder="Enter Title" value="{{ $arr_newsletter['newsletter_name'] }}" data-parsley-required ='true' data-parsley-required-message="Please enter newsletter name">
                                    </div>
                                      <span>{{ $errors->first('newsletter_name') }}</span>
                                  </div>

                                   
                             
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="newsletter_subject"> Subject<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="newsletter_subject" id="newsletter_subject" class="form-control" placeholder="Enter Subject" value="{{ $arr_newsletter['newsletter_subject'] }}" data-parsley-required ='true' data-parsley-required-message="Please enter newsletter subject">
                                    </div>
                                      <span>{{ $errors->first('newsletter_subject') }}</span>
                                  </div>

                               

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="newsletter_desc">Description<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <textarea name="newsletter_desc" id="newsletter_desc" class="form-control" placeholder="Enter Description" data-parsley-required-message="Please enter description"> 
                                      {{--  {{ $arr_newsletter['newsletter_desc'] }} --}}
                                      @php echo $arr_newsletter['newsletter_desc']  @endphp
                                     </textarea> 
                                    </div>
                                    <script>
                                        // CKEDITOR.replace( 'newsletter_desc' );
                                         var allowedContent = true; 
                                         CKEDITOR.replace( 'newsletter_desc', {
                                          height: 300,                                       
                                           filebrowserUploadUrl: "{{route('newsletter_template.uploadimage', ['_token' => csrf_token() ])}}",
                                           filebrowserUploadMethod: 'form',
                                            allowedContent

                                       } );
                                    </script> 
                                      <span>{{ $errors->first('newsletter_desc') }}</span>
                                  </div>
                     

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is Active</label>
                                      <div class="col-sm-6 col-lg-8 controls">
                                         <input type="checkbox" name="is_active" id="is_active"
                                         @if($arr_newsletter['is_active']=="0") value="0"
                                         @elseif($arr_newsletter['is_active']==1) value="1" 
                                         @endif data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();"  @if($arr_newsletter['is_active'] =='1') checked="checked" @endif />
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


  var module_url_path  = "{{ $module_url_path or ''}}";

  $(document).ready(function()
  {
    var module_url_path  = "{{ $module_url_path or ''}}";

    var csrf_token = $("input[name=_token]").val(); 



    $('#btn_add').click(function()
    {
      if($('#validation-form').parsley().validate()==false) return;
      var ckeditor_description = CKEDITOR.instances['newsletter_desc'].getData();
      formdata = new FormData($('#validation-form')[0]);
      formdata.set('newsletter_desc',ckeditor_description); 
      $.ajax({
                  
          url: module_url_path+'/save',
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
              }
              else{
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