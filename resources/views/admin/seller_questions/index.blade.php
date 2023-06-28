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
         {{-- {{ dd($arr_seller_ques  ts)}} --}}
         <div class="table-responsive">
            <table class="table table-striped"  id="table_module" >
               <thead>
                  <tr>
                     <th>ID </th>
                     <th width="60%">Question </th>
                     <th>Last Updated</th>                     
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @if(sizeof($arr_seller_quests)>0)
                  @foreach($arr_seller_quests as $arr_seller_quest)
                  <tr>
                     <td> {{ $arr_seller_quest['id'] }} </td>
                     <td> {!! $arr_seller_quest['question'] !!}  </td>
                     <td> {{ date('d M Y H:i',strtotime($arr_seller_quest['updated_at'])) }} </td>
                     <td> 
                        
                        <a class="eye-actn" href="{{ $module_url_path.'/edit/'.base64_encode($arr_seller_quest['id']) }}"  title="Edit">
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
             { "bSortable": true }
             ]
         });
     });
   
</script>



@stop