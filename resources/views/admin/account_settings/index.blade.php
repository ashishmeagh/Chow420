@extends('admin.layout.master')    
@section('main_content')

<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">{{$module_title or ''}}</h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
       @php
         $user = Sentinel::check();
       @endphp

       @if(isset($user) && $user->inRole('admin'))
         <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
       @endif      
         <li class="active">{{$module_title or ''}}</li>
      </ol>
   </div> 
   <!-- /.col-lg-12 -->
</div>
<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12"> 
<div class="white-box">
   @include('admin.layout._operation_status')
   <div class="row">
      <div class="col-sm-12 col-xs-12">
         <div class="box-title">
          {{--   <h3><i class="ti-settings"></i> {{ isset($page_title)?$page_title:"" }}</h3> --}}
            <div class="box-tool">
            </div>
         </div>
        
         {!! Form::open([ 'url' => $module_url_path.'/update/'.base64_encode($arr_data['id']),
         'method'=>'POST',   
         'class'=>'form-horizontal',  
         'id'=>'validation-form',
         'enctype' =>'multipart/form-data'
         ]) !!}
         <input type="hidden" name="old_image" value="{{$arr_data['profile_image']}}">
         <div class="form-group row">
            <label for="first_name" class="col-2 col-form-label">First Name<i class="red">*</i></label>
            <div class="col-10">
               {!! Form::text('first_name',$arr_data['first_name'],['class'=>'form-control','data-parsley-required'=>'true', 'data-parsley-required-message'=>'Please enter first name','data-parsley-minlength'=>'3', 'data-parsley-minlength'=>'3', 'data-parsley-pattern'=>'^[a-zA-Z]+$','placeholder'=>'First Name','id'=>'first_name']) !!}
            </div>
               <span class='red'>{{ $errors->first('first_name') }}</span>
         </div>
         
         <div class="form-group row">
            <label for="last_name" class="col-2 col-form-label">Last Name<i class="red">*</i></label>
            <div class="col-10">
               {!! Form::text('last_name',$arr_data['last_name'],['class'=>'form-control','data-parsley-required'=>'true','data-parsley-required-message'=>'Please enter last name', 'data-parsley-maxlength'=>'20', 'data-parsley-pattern'=>'^[a-zA-Z]+$','placeholder'=>'Last Name','id'=>'last_name']) !!}
            </div>
               <span class='red'>{{ $errors->first('last_name') }}</span>
         </div>
         <div class="form-group row">
            <label for="email" class="col-2 col-form-label">Email<i class="red">*</i></label>
            <div class="col-10">
               {!! Form::text('email',$arr_data['email'],['class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-required-message'=>'Please enter email','data-parsley-type'=>'email', 'placeholder'=>'Email','id'=>'email']) !!}
            </div>
               <span class='red'>{{ $errors->first('email') }}</span>
         </div>
         <div class="form-group row">
             <label class="col-2 col-form-label" for="ad_image">Profile Image</label>
              <div class="col-10">
                <input type="file" name="image" id="ad_image" class="dropify" data-default-file="{{url('/')}}/uploads/profile_image/{{$arr_data['profile_image']}}" />
              </div>
         </div>
         <div class="form-group row">
            <div class="col-10">
              <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Update">Update</button>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>
</div>
</div>

<!-- END Main Content --> 
@endsection