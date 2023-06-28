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
.err{
    color: #e00000;
    font-size: 13px;
}
</style> 

<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/buyer/js/jquery.rating.js"></script>
<script src="{{url('/')}}/assets/buyer/js/star-rating.js" type="text/javascript"></script>
<link href="{{url('/')}}/assets/buyer/css/star-rating.css" rel="stylesheet" />


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
                    <li class="active">Add Review</li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
         
    <!-- .row -->  
                <div class="row">
                  
                    <div class="col-sm-12">
                     <h4> <span id="showerr"></span> </h4>
                        <div class="white-box">
                        @include('admin.layout._operation_status')
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="product_id" value="{{ isset($product_id)?$product_id:'' }}">


                                   <div class="form-group row rating-row">
                                    <label class="col-md-2 col-form-label" for="rating">Rating<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                      <div class="ratings-frms rating-space-top">
                                           <div class="starrr text-left">
                                             <input name="rating" id="rating" value="1"  class="star required" type="radio" 
                                             />
                                          </div>
                                      </div>
                                    </div>
                                      <span id="err_rating">{{ $errors->first('rating') }}</span>
                                  </div>




                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="user name">User Name<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter User Name" data-parsley-required ='true' data-parsley-required-message="Please enter user name" >
                                       <ul class="parsley-errors-list filled" id="parsley-id-5">
                                        <li  class="parsley-required" id="user_name_error"> </li>
                                      </ul>
                                    </div>
                                      <span>{{ $errors->first('user_name') }}</span>
                                  </div>

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="title">Title<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" data-parsley-required ='true' data-parsley-required-message="Please enter title" >
                                       <ul class="parsley-errors-list filled" id="parsley-id-5">
                                        <li  class="parsley-required" id="title_error"> </li>
                                      </ul>
                                    </div>
                                      <span>{{ $errors->first('title') }}</span>
                                  </div>

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="review">Write Comment<i class="red">*</i></label>
                                    <div class="col-md-10">                                       
                                <textarea name="review" id="review" class="form-control" placeholder="Enter Review" data-parsley-required ='true' data-parsley-required-message="Please enter review" ></textarea>
                                      
                                    </div>
                                      <span>{{ $errors->first('review') }}</span>
                                  </div>



                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="helpedwith">Helped With<i class="red"></i></label> 

                                  <div class="checkbox-dropdown">
                                      Helped with
                                      <ul class="checkbox-dropdown-list">
                                       
                                         @if(isset($get_reported_effects) && !empty($get_reported_effects))
                                             @foreach($get_reported_effects as  $k=>$v)
                                              <li>
                                               <div class="checkbox clearfix">
                                                  <div class="form-check checkbox-theme">
                                                      <input class="form-check-input" type="checkbox" value="{{ $v['id'] }}" id="rememberMe1{{ $v['id'] }}"  name="emoji[]">
                                                      <label class="form-check-label" for="rememberMe1{{ $v['id'] }}">
                                                        {{ $v['title'] or '' }}
                                                         @if(file_exists(base_path().'/uploads/reported_effects/'.$v['image']) && isset($v['image']) && !empty($v['image']))
                                                         <img src='{{ url('/') }}/uploads/reported_effects/{{ $v['image'] }}' width="32px" title="{{ $v['title'] }}" />
                                                         @endif 
                                                      </label>
                                                  </div>
                                                </div>
                                               </li>
                                               @endforeach
                                             @endif    
                                        
                                        
                                      </ul>
                                    </div>
                                  </div>


                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Add</button>
                                <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path.'/Reviews/'.base64_encode($product_id) }}"><i class="fa fa-arrow-left"></i> Back</a>
                                              
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

        var rating = $("#rating").val();
        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          return false; 
        }

        var formdata = new FormData($('#validation-form')[0]);
       // var ckeditor_description = CKEDITOR.instances['review'].getData();
       //  formdata = new FormData($('#validation-form')[0]);
       //  formdata.set('review',ckeditor_description); 
        var formdata   = $('#validation-form').serializeArray(); 
        formdata.push({name: 'rating', value: rating});

        // var csrf_token = "{{ csrf_token()}}";

        $.ajax({
                  
          url: module_url_path+'/savereview',
          data: formdata,
         // contentType:false,
         // processData:false,
          method:'POST',
         // cache: false,
          dataType:'json',
          beforeSend : function()
          { 
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

 
</script>
<script type="text/javascript">
  $(".checkbox-dropdown").click(function () {
    $(this).toggleClass("is-active");
});

$(".checkbox-dropdown ul").click(function(e) {
    e.stopPropagation();
});

</script>

<script type="text/javascript">
   
tinymce.remove('textarea');


</script>
@stop