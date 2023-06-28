@extends('admin.layout.master')                
@section('main_content')
<!-- Page Content -->

<link href="{{ url('/') }}/assets/admin/css/fSelect.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ url('/') }}/assets/admin/js/fSelect.js"></script>

<script>
(function($) {
    $(function() {
      $('.selectcategory').fSelect({
        placeholder: 'Select Category',
        numDisplayed: 3,
        overflowText: '{n} selected',
        noResultsText: 'No results found',
        searchText: 'Search',
        showSearch: true,
        showSelectAll: true
    });

 });
})(jQuery);

</script>

  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                      <li><a href="{{$module_url_path or ''}}">{{$module_title or ''}}</a></li>
                      <li class="active">Edit State</li>
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
                              
                                    
                                
                                <input type="hidden" name="id" id="id" value="{{ $arr_data['id'] or '' }}" />
                                <input type="hidden" name="country_id" id="country_id" value="{{ $arr_data['country_id'] or '' }}" />
                                                               

                                 <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">State Name <i class="red">*</i></label>
                                    <div class="col-md-10">
                                       
                                       <input type="text" name="name" id="name" class="form-control" data-parsley-required="true" placeholder="Enter State Name" value="{{$arr_data['name'] or ''}}"  data-parsley-required-message="Please enter state name">                                   
                                     </div>
                                      <span>{{ $errors->first('name') }}</span>
                                  </div>


                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="shortname">Short Name (State Abbrevation) <i class="red">*</i></label>
                                    <div class="col-md-10">
                                       
                                       <input type="text" name="shortname" id="shortname" class="form-control" data-parsley-required="true" placeholder="Enter State short name" value="{{$arr_data['shortname'] or ''}}"  data-parsley-required-message="Please enter state shortname name">                                   
                                     </div>
                                      <span>{{ $errors->first('shortname') }}</span>
                                  </div> 

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Restrict Category</label> 
                                    <div class="col-md-10">
                                        <select class="form-control selectcategory" name="category_id[]"  multiple="multiple">
                                            <option value="">Select Category</option>
                                            @if(isset($arr_category) && sizeof($arr_category)>0)
                                              @foreach($arr_category as $category)
                                                <option value="{{isset($category['id'])?$category['id']:''}}" @php if(isset($arr_restrict_categories) && sizeof($arr_restrict_categories)>0 && in_array($category['id'],$arr_restrict_categories)) echo "selected"; @endphp>{{isset($category['product_type'])?ucfirst($category['product_type']):''}}</option>
                                              @endforeach
                                            @endif

                                         </select>
                                          <span>{{ $errors->first('category_id') }}</span>
                                    </div>
                                  </div>

                                    
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">State Law</label> 
                                    <div class="col-md-10">

                                         <textarea rows="5" name="state_restricted_text" id="state_restricted_text" class="form-control"  placeholder="Enter state law">{{isset($arr_data['text'])?$arr_data['text']:''}}</textarea>

                                        <span>{{ $errors->first('state_restricted_text') }}</span>

                                    </div>
                                  </div>


                                 {{--  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="name">Tax Percentage %</label>
                                    <div class="col-md-10">                                       
                                       <input type="text" name="tax_percentage" id="tax_percentage" class="form-control" placeholder="Enter Tax Percentage" data-parsley-type="number" data-parsley-min="0" data-parsley-max="100" data-parsley-maxlength="5" data-parsley-type-message="Please enter valid tax percentage." data-parsley-min-message="Please enter valid tax percentage." data-parsley-max-message="Please enter valid tax percentage." value="{{$arr_data['tax_percentage'] or ''}}"> 
                                    </div>
                                      <span>{{ $errors->first('tax_percentage') }}</span>
                                  </div> --}}

                                  
                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Is active</label>
                                      <div class="col-md-10">
                                          @php
                                            if(isset($arr_data['is_active'])&& $arr_data['is_active']!='')
                                            {
                                              $status = $arr_data['is_active'];
                                            } 
                                            else
                                            {
                                              $status = '';
                                            }
                
                                          @endphp
                                          <input type="checkbox" name="state_status" id="state_status" value="1" data-size="small" class="js-switch " @if($status =='1') checked="checked" @endif data-color="#99d683" data-secondary-color="#f96262" />
                                      </div>    
                                  </div> 

                                                    
                                    <button type="button" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_add">Update</button>
                                   <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path or ''}}/view_states/{{ base64_encode($arr_data['country_id']) }}"><i class="fa fa-arrow-left"></i> Back</a>
                                        
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
                  
          url: module_url_path+'/update_state',
          data: new FormData($('#validation-form')[0]),
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
          success:function(data)
          {
                console.log(data);

             if('success' == data.status)
             {
                $('#validation-form')[0].reset();

                  swal({
                         title: "Success",
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