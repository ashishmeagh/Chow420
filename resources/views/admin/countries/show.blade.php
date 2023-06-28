@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
<link rel="stylesheet" type="text/css" href="{{url('/')}}/admin/assets/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">{{$module_title or ''}}</h4>
         </div>
         <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
               <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
               <li ><a href="{{$module_url_path}}">{{$module_title or ''}}</a></li>
               <li class="active"> {{$page_title or ''}}</li>
            </ol>
         </div>
         <!-- /.col-lg-12 -->
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div class="white-box">
               <p>
                  <span>Name:
                  </span>{{ isset($arr_data['country_name'])?$arr_data['country_name']:'' }}
               </p>
               <p>
                  <span>Code:
                  </span> {{ isset($arr_data['country_code'])?$arr_data['country_code']:'-' }}
               </p>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END Main Content -->
@stop