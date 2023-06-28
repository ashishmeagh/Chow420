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
                      
                    <li><a href="{{$module_url_path}}">{{$module_title or ''}}</a></li>
                    <li class="active">Create CMS</li>
                    
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div> 
        
    <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                        @include('admin.layout._operation_status')

                 {!! Form::open([ 'url' => $module_url_path.'/store',
               'method'=>'POST',
               'enctype' =>'multipart/form-data',   
               'class'=>'form-horizontal', 
               'id'=>'validation-form' 
               ]) !!} 



               <ul  class="nav nav-tabs">
                @include('admin.layout._multi_lang_tab')
              </ul>                                
              <div id="myTabContent1" class="tab-content">

                @if(isset($arr_lang) && sizeof($arr_lang)>0)
                @foreach($arr_lang as $lang)

                <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}"
                id="{{ $lang['locale'] }}">

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="page_title">Page Title
                       @if($lang['locale'] == 'en') 
                          <i class="red">*</i>
                       @endif
                  </label>
                  <div class="col-md-10">

                    @if($lang['locale'] == 'en')        
                        {!! Form::text('page_title_'.$lang['locale'],old('page_title_'.$lang['locale']),['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Page Title']) !!}
                    @else
                        {!! Form::text('page_title_'.$lang['locale'],old('page_title_'.$lang['locale']),['class'=>'form-control','placeholder'=>'Page Title']) !!}
                    @endif    
                    {{-- <span class='red'>{{ $errors->first('page_name') }}</span> --}}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="meta_keyword">Meta Keyword
                       @if($lang['locale'] == 'en') 
                          <i class="red">*</i>
                       @endif
                  </label>
                  <div class="col-md-10">

                    @if($lang['locale'] == 'en')        
                        {!! Form::text('meta_keyword_'.$lang['locale'],old('meta_keyword_'.$lang['locale']),['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Meta Keyword']) !!}
                    @else
                        {!! Form::text('meta_keyword_'.$lang['locale'],old('meta_keyword_'.$lang['locale']),['class'=>'form-control','placeholder'=>'Meta Keyword']) !!}
                    @endif

                   {{--  <span class='red'>{{ $errors->first('meta_keyword_') }}</span> --}}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="meta_desc">Meta Description
                       @if($lang['locale'] == 'en') 
                          <i class="red">*</i>
                       @endif
                  </label>
                  <div class="col-md-10">

                    @if($lang['locale'] == 'en')        
                        {!! Form::textarea('meta_desc_'.$lang['locale'],old('meta_desc_'.$lang['locale']),['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Meta Description']) !!}
                    @else
                        {!! Form::textarea('meta_desc_'.$lang['locale'],old('meta_desc_'.$lang['locale']),['class'=>'form-control','placeholder'=>'Meta Description']) !!}
                    @endif


                  {{--   <span class='help-block'>{{ $errors->first('meta_desc_'.$lang['locale']) }}</span> --}}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label" for="page_desc">Page Content
                       @if($lang['locale'] == 'en') 
                          <i class="red">*</i>
                       @endif
                  </label>
                  <div class="col-md-10">
                    @if($lang['locale'] == 'en')        
                        {!! Form::textarea('page_desc_'.$lang['locale'],old('page_desc_'.$lang['locale']),['class'=>'form-control','data-parsley-required'=>'true','rows'=>'20','placeholder'=>'Page Content']) !!}
                    @else
                        {!! Form::textarea('page_desc_'.$lang['locale'],old('page_desc_'.$lang['locale']),['class'=>'form-control','placeholder'=>'Page Content']) !!}
                    @endif

                  {{--   <span class='red'>{{ $errors->first('page_desc_'.$lang['locale']) }}</span> --}}
                  </div>
                </div>
              </div>
              @endforeach
              @endif
            </div>
            <br>
            <div class="form-group row">
              <div class="col-md-10">
                <button class="btn btn-success waves-effect waves-light m-r-10" type="submit" name="Save" value="true" id="btn_add"> Save</button>
                  <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
              </div>
            </div>
            {!! Form::close() !!}
          </div>

        </div>
      </div>
    </div>
 
  <!-- END Main Content -->

  <script type="text/javascript">
    $(document).ready(function()
  {
     $('#btn_add').click(function()
    {
      tinyMCE.triggerSave();
      if($('#validation-form').parsley().validate()==false) return;
    });
  });  
   
  </script>
   <script type="text/javascript" src="{{url('/assets/admin/js/tinyMCE.js')}}"></script>

  @stop
