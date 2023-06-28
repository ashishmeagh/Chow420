@extends('admin.layout.master')                
@section('main_content')
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">{{$page_title or ''}}</h4>
      </div>
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
            <div class="tabbable">
               {!! Form::open([ 'url' => $module_url_path.'/store',
               'method'=>'POST',
               'enctype' =>'multipart/form-data',   
               'class'=>'form-horizontal', 
               'id'=>'validation-form' 
               ]) !!} 
               {{ csrf_field() }}
               <ul  class="nav nav-tabs">
                  @include('admin.layout._multi_lang_tab')
               </ul>
               <div  class="tab-content">
                  @if(isset($arr_lang) && sizeof($arr_lang)>0)
                  @foreach($arr_lang as $lang)
                  <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}" 
                     id="{{ $lang['locale'] }}">
                     @if($lang['locale']=="en")    
                     <div class="form-group row">
                        <label class="col-2 col-form-label" for="state"> Code 
                        <i class="red">*
                        </i>
                        </label>
                        <div class="col-10">
                           @if($lang['locale'] == 'en')        
                           {!! Form::text('country_code',old('country_code'),['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255', 'placeholder'=>'Code']) !!}
                           @endif    
                        </div>
                        <span class='red'>{{ $errors->first('country_code') }}
                        </span>  
                     </div>
                     @endif
                     <div class="form-group row">
                        <label class="col-2 col-form-label" for="state"> Name 
                        <i class="red">*
                        </i> 
                        </label>
                        <div class="col-10">
                           @if($lang['locale'] == 'en')        
                           {!! Form::text('country_name_'.$lang['locale'],old('country_name_'.$lang['locale']),['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255', 'placeholder'=>'Name']) !!}
                           @else
                           {!! Form::text('country_name_'.$lang['locale'],old('country_name_'.$lang['locale'])) !!}
                           @endif    
                        </div>
                        <span class='red'>{{ $errors->first('country_name_'.$lang['locale']) }}
                        </span>  
                     </div>
                  </div>
                  @endforeach
                  @endif
               </div>
               <br>
               <div class="form-group row">
                  <div class="col-10">  
                     <button class="btn btn-success waves-effect waves-light m-r-10" type="submit" name="Save" value="true"> Save</button>
                     <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                  </div>
               </div>
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
   })
</script>
@stop