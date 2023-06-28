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
                                    {!! Form::open([ 'url' => "{{ url(config('app.project.admin_panel_slug').'/second_level_categories/store') }}",
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal',
                                 'id'=>'validation-form' 

                                ]) !!} 
                              
                                  
                                
                                  <input type="hidden" name="id" id="id" value="{{ $arr_sec_level_category['id'] or '' }}" />
                                
                                <div class="form-group row">
                                  <label for="product_type" class="col-md-2 col-form-label">Select Category<i class="red">*</i></label>
                                  <div class="col-md-10">
                                    <select name="product_type" id="product_type" class="form-control" data-parsley-required ='true' data-parsley-required-message="Please select category">
                                      <option value="">Select Category</option>
                                      @if(isset($arr_category) && sizeof($arr_category) >0)
                                        @foreach($arr_category as $category)
                                          <option 
                                            @if($category['id'] == $arr_sec_level_category['first_level_category_id']) selected="selected"  @endif 
                                            value="{{ $category['id'] or ''}}">{{ $category['product_type'] or ''}}
                                          </option>
                                        @endforeach
                                      @endif
                                    </select>
                                  </div>
                                </div>


                                 <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Sub Category <i class="red">*</i></label>
                                    <div class="col-md-10">
                                       
                                       <input type="text" name="name" id="name" class="form-control" data-parsley-required="true" placeholder="Enter Category Name" value="{{$arr_sec_level_category['name'] or ''}}" data-parsley-required-message="Please enter sub category name">
                                    </div>
                                      <span>{{ $errors->first('name') }}</span>
                                  </div>

                                  
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is active</label>
                                      <div class="col-md-10">
                                          @php
                                            if(isset($arr_sec_level_category['is_active'])&& $arr_sec_level_category['is_active']!='')
                                            {
                                              $status = $arr_sec_level_category['is_active'];
                                            } 
                                            else
                                            {
                                              $status = '';
                                            }
                
                                          @endphp
                                          <input type="checkbox" name="category_status" id="category_status" value="1" data-size="small" class="js-switch " @if($status =='1') checked="checked" @endif data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_status();" />
                                      </div>    
                                  </div> 

                                                      
                                    <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_add">Update</button>
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

    $('#btn_add').click(function(){

      if($('#validation-form').parsley().validate()==false) return;
   
      $.ajax({
                  
          url: module_url_path+'/store',
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
@stop