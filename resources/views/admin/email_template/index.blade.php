@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
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
   </div>
   <!-- BEGIN Main Content -->
   <div class="col-sm-12">
      <div class="white-box">
         @include('admin.layout._operation_status')
         {!! Form::open([ 'url' => $module_url_path.'/multi_action',
         'method'=>'POST',
         'enctype' =>'multipart/form-data',   
         'class'=>'form-horizontal', 
         'id'=>'frm_manage' 
         ]) !!} 
         {{ csrf_field() }}
         <div class="pull-right">
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a>
         </div>
         <br>
         <br>
         <div class="table-responsive">
            <table class="table table-striped"  id="table_module" >
               <thead>
                  <tr>
                     <th>ID </th>
                     <th width="20%">Name </th>
                     <th>From </th>
                     <th width="10%">From Email </th>
                     <th width="20%">Subject</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @if(sizeof($arr_data)>0)
                  @foreach($arr_data as $email_template)
                  <tr>
                     <td> {{ $email_template['id'] }}</td>
                     <td> {{ $email_template['template_name'] }}  </td>
                     <td> {{ $email_template['template_from'] }} </td>
                     <td> {{ $email_template['template_from_mail'] }} </td>
                     <td> {{ $email_template['template_subject'] }}    </td>
                     <td> 
                        <a  class="eye-actn" target="_blank" href="{{ $module_url_path.'/view/'.base64_encode($email_template['id']) }}"  title="View">
                        View
                        </a> 
                        <a class="eye-actn" href="{{ $module_url_path.'/edit/'.base64_encode($email_template['id']) }}"  title="Edit">
                        Edit
                        </a>
                     </td>
                  </tr>
                  @endforeach
                  @endif
               </tbody>
            </table>
         </div>
         <div>   
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
   $(document).ready(function() {
         $('#table_module').DataTable( {
             "aoColumns": [
             { "bSortable": true },
             { "bSortable": true },
             { "bSortable": true },
             { "bSortable": true },
             { "bSortable": true },
             { "bSortable": false }
             ]
         });
     });
   
</script>
@stop