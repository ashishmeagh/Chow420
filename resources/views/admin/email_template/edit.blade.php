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
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email"> Template Name<i class="red">*</i> 
                  </label>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">       
                     {!! Form::text('template_name',$arr_data['template_name'],['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255', 'placeholder'=>'Email Template Name']) !!}  
                  </div>
                  <span class='red'> {{ $errors->first('template_name') }} </span>  
               </div>
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email"> From 
                  <i class="red">*</i> 
                  </label>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">      
                     {!! Form::text('template_from',$arr_data['template_from'],['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255', 'placeholder'=>'Email Template From']) !!}  
                  </div>
                  <span class='help-block'> {{ $errors->first('template_from') }} </span>  
               </div>
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email">  From Email 
                  <i class="red">*</i> 
                  </label>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">     
                     {!! Form::text('template_from_mail',$arr_data['template_from_mail'],['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','data-parsley-type'=>'email', 'placeholder'=>'Email Template From Email']) !!}  
                  </div>
                  <span class='help-block'> {{ $errors->first('template_from_mail') }} </span>  
               </div>
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email"> Subject 
                  <i class="red">*</i> 
                  </label>
                  @php
                      $readonly = false;

                     if($arr_data['id'] == '31')
                     {
                        $readonly = 'true';
                     }
                  @endphp

                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">      
                     {!! Form::text('template_subject',$arr_data['template_subject'],['class'=>'form-control','data-parsley-required'=>'true','readonly'=>$readonly,'data-parsley-maxlength'=>'255', 'placeholder'=>'Email Template Subject']) !!}  
                  </div>
                  <span class='help-block'> {{ $errors->first('template_subject') }} </span>  
               </div>
               <div class="form-group row">
                  <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label" for="email">  Body 
                  <i class="red">*</i> 
                  </label>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">   
                     {!! Form::textarea('template_html',$arr_data['template_html'],['class'=>'form-control', 'class'=>'form-control','id' => 'template_html', 'rows'=>'25', 'data-parsley-required'=>'true', 'placeholder'=>'Email Template Body']) !!}  
                     <span class='red'> {{ $errors->first('template_html') }} </span> 
                     <span class="text-info"> Variables </span>
                     
                     @if(sizeof($arr_variables)>0)
                     @foreach($arr_variables as $variable)
                     <br> <label> {{ $variable }} </label> 
                     @endforeach
                     @endif 
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                     <button type="submit" class="btn btn-success waves-effect waves-light" value="Update">Update</button>
                     <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                     <a class="btn btn-danger" target="_blank" href="{{ url(config('app.project.admin_panel_slug').'/email_template').'/view/'.base64_encode($arr_data['id']) }}"  title="Preview">Preview</a>
                     
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
<script type="text/javascript">
   $('#validation-form').submit(function(){
       //tinyMCE.triggerSave();
       tinymce.triggerSave();
    });
   
   $(document).ready(function()
   {
    $('#validation-form').parsley(); 

   });
</script>
{{-- <script type="text/javascript" src="{{url('/assets/admin/js/tinyMCE.js')}}"></script>
 --}}

{{--  <script>
    
   tinymce.init({
   selector: 'textarea',
   relative_urls: false,
   remove_script_host:false,
   convert_urls:false,
   plugins: [
     'link',
     'fullscreen',
     'contextmenu '
   ],
   toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
   content_css: [
     // '//www.tinymce.com/css/codepen.min.css'
   ]
 });

</script> --}}


 <script type="text/javascript" src="{{url('/assets/admin/js/tiny.js')}}"></script>


@stop