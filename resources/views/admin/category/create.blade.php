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
                      <li><a href="{{$module_url_path}}">{{$module_title or ''}}</a></li>
                      <li class="active">Create Category</li>
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
                                    {!! Form::open([ 'url' => {{ url(config('app.project.admin_panel_slug').'/categories/save') }},
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal', 
                                 'id'=>'validation-form' 
                                ]) !!} 
                                
                                        <div class="form-group row">
                                        <label class="col-2 col-form-label" for="category">Category <i class="red">*</i></label>
                                          <div class="col-10">
                                          {!! Form::select('parent', $arr_parent_category_options, $parent_id, ['class'=>'form-control','required'=>'true','id'=>'category']) !!}
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                           <label class="col-2 col-form-label" for="ad_image">Image <i class="red">*</i></label>
                                            <div class="col-10">
                                              <input type="file" name="image" id="ad_image" class="dropify" data-default-file="{{url('/')}}/uploads/default.jpeg" data-rule-required="true" />
                                            </div>
                                       </div>
                                        <span>{{ $errors->first('image') }}</span>
                                       
                                        <div class="form-group row">
                                          <label class="col-2 col-form-label" for="title_en"> Title <i class="red">*</i></label>
                                          <div class="col-10">
                                              {!! Form::text('title_en',old('title_en'),['class'=>'form-control','data-parsley-required'=>'true','placeholder'=>'Enter Title']) !!}
                                          </div>
                                        </div>
                                            <span>{{ $errors->first('title_en') }}</span>
                                        
                                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Save">Save</button>
                                              <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                                              
                                        <!-- form-group -->
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
}
}
<!-- END Main Content -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#validation-form').parsley();
  });
</script>
@stop