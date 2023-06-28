@extends('admin.layout.master')                

@section('main_content')
<!-- Page Content -->
<script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script>
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
              <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                {{ csrf_field() }}

                <input type="hidden" name="id" id="id" value="{{ $arr_users_shares['id'] or '' }}" />

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">First name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="first_name" placeholder="Enter first name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" value="{{isset($arr_users_shares['first_name'])?$arr_users_shares['first_name']:''}}" data-parsley-required-message="Please enter first name" />
                     <span class="red">{{ $errors->first('first_name') }}</span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Last name<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="last_name" placeholder="Enter last name" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z]+$" value="{{isset($arr_users_shares['last_name'])?$arr_users_shares['last_name']:''}}" data-parsley-required-message="Please enter last name" />
                     <span class="red">{{ $errors->first('last_name') }}</span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Email<i class="red">*</i></label>
                  <div class="col-md-10">
                     <input type="text" class="form-control" name="email" placeholder="Enter Email" data-parsley-required="true" data-parsley-type="email" data-parsley-required-message="Please enter email" value="{{isset($arr_users_shares['email'])?$arr_users_shares['email']:''}}"  />
                     <span class="red">{{ $errors->first('email') }}</span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="shares_owned">Shares owned<i class="red">*</i></label>
                  <div class="col-md-10">                                       
                     <input type="text" name="shares_owned" id="shares_owned" class="form-control" placeholder="Enter shares owned" data-parsley-required="true"  data-parsley-maxlength="10" data-parsley-min="1" data-parsley-type="number" data-parsley-required-message="Please enter shares owned" value="{{isset($arr_users_shares['shares_owned'])?number_format($arr_users_shares['shares_owned']):''}}">
                  </div>
                    <span>{{ $errors->first('shares_owned') }}</span>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="price_per_share">Price per share<i class="red">*</i></label>
                  <div class="col-md-10">                                       
                     <input type="text" name="price_per_share" id="price_per_share" class="form-control" placeholder="Enter price per share" data-parsley-required="true"  data-parsley-maxlength="10" data-parsley-min="1" data-parsley-type="number" data-parsley-required-message="Please enter price per share" value="{{isset($arr_users_shares['price_per_share'])?$arr_users_shares['price_per_share']:''}}">
                  </div>
                    <span>{{ $errors->first('price_per_share') }}</span>
                </div>  

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="percent_change">Percent change<i class="red">*</i></label>
                  <div class="col-md-10">                                       
                     <input type="text" name="percent_change" id="percent_change" class="form-control" placeholder="Enter percent change" data-parsley-required="true"  data-parsley-maxlength="10" data-parsley-min="1" data-parsley-type="number" data-parsley-required-message="Please enter percent change" value="{{isset($arr_users_shares['percent_change'])?$arr_users_shares['percent_change']:''}}" >
                  </div>
                    <span>{{ $errors->first('percent_change') }}</span>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="share_value">Share value<i class="red">*</i></label>
                  <div class="col-md-10">                                       
                     <input type="text" name="share_value" id="share_value" class="form-control" placeholder="Enter share value" data-parsley-required="true"  data-parsley-maxlength="10" data-parsley-min="1" data-parsley-type="number" data-parsley-required-message="Please enter share value" value="{{isset($arr_users_shares['share_value'])?$arr_users_shares['share_value']:''}}" >
                  </div>
                  <span>{{ $errors->first('share_value') }}</span>
                </div>


                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="description">Description<i class="red">*</i></label>
                  <div class="col-md-10">                                       
                    <textarea name="description" id="description" class="form-control" placeholder="Enter Description"  required>{{isset($arr_users_shares['description'])?$arr_users_shares['description']:''}}</textarea>
                    <script>
                        CKEDITOR.replace( 'description' );
                    </script> 
                  </div>
                  <span>{{ $errors->first('description') }}</span>
                </div>  
                                   
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Is Active</label>
                  <div class="col-sm-6 col-lg-8 controls">
                    <input type="checkbox" name="is_active" id="is_active"
                     @if($arr_users_shares['is_active']=="0") value="0"
                     @elseif($arr_users_shares['is_active']==1) value="1" 
                     @endif data-size="small" class="js-switch " data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();"  @if($arr_users_shares['is_active'] =='1') checked="checked" @endif />
                  </div>    
                </div>   
                                        
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Update</button>
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

      var description = CKEDITOR.instances['description'].getData();
      var formdata = new FormData($('#validation-form')[0]);
      formdata.set('description',description); 
   
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
              }else if(data.status=="ImageFAILURE")
              {
                $("#image_error").html(data.description);
                $("#image_error").css('color','red');
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