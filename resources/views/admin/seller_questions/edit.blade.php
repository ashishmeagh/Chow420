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

         @php
            $user = Sentinel::check();
         @endphp

         @if(isset($user) && $user->inRole('admin'))
            <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>

         @endif
         
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
            {!! Form::open([ 'url' => $module_url_path.'/update/'.base64_encode($arr_data['id']),
            'method'=>'POST',
            'enctype' =>'multipart/form-data',   
            'class'=>'form-horizontal', 
            'id'=>'validation-form' 
            ]) !!} 
            {{ csrf_field() }}
            <div class="tab-content">
               
               <div class="form-group row">
                  <label class="col-2 col-form-label" for="email">  Question 
                  <i class="red">*</i> 
                  </label>
                  <div class="col-10">   
                     {!! Form::textarea('question',$arr_data['question'],['class'=>'form-control' ,'rows'=>'10', 'data-parsley-required'=>'true', 'placeholder'=>'Enter Question']) !!}  
                     <span class='red'> {{ $errors->first('question') }} </span> 
                     
                     
                     
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-10">
                     <button type="submit" class="btn btn-success waves-effect waves-light" value="Update">Update</button>
                     <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                     
                  </div>
               </div>

               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<!-- END Main Content -->

@stop