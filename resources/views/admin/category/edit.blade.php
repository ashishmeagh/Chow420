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
                                    {!! Form::open([ 'url' => {{ url(config('app.project.admin_panel_slug').'/categories/save') }},
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal',
                                 'id'=>'validation-form' 

                                ]) !!} 

                                  <input type="hidden" name="id" value="{{ $arr_category['id'] or false }}" />
                                  
                                @if(sizeof($arr_lang)>0)
                                      @foreach($arr_lang as $lang)
                                      <?php 
                                          /* Locale Variable */  
                                          $locale_category_title = "";

                                          if(isset($arr_category['translations'][$lang['locale']]))
                                          {
                                              $locale_category_title = $arr_category['translations'][$lang['locale']]['category_title'];
                                          }

                                      ?>
                                        @if($lang['locale']=='en')
                                        <div class="form-group row">
                                        <label class="col-2 col-form-label" for="state">Category <i class="red">*</i></label>
                                          <div class="col-10">
                                            {!! Form::select('parent', $arr_parent_category_options, $arr_category['parent'], ['class'=>'form-control','data-rule-required'=>'required']) !!} 
                                          </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                           <label class="col-2 col-form-label" for="state">Image <i class="red">*</i></label>
                                            <div class="col-10">
                                              <input type="file" name="image" id="ad_image" class="dropify" data-default-file="{{$category_public_img_path.''.$arr_category['image']}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                          <label class="col-2 col-form-label" for="state"> Title <i class="red">*</i></label>
                                          <div class="col-10">
                                              {!! Form::text('title_en',$locale_category_title,['class'=>'form-control','data-parsley-required'=>'true', 'placeholder'=>'Enter Title']) !!}
                                          </div>
                                        </div>
                                            <span>{{ $errors->first('title_en') }}</span>
                                        @endif
                                      @endforeach
                                      @endif
                                              <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Update">Update</button>
                                             <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                                        <!-- form-group -->
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- END Main Content -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#validation-form').parsley();
  });
</script>
@stop