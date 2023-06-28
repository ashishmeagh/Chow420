@extends('admin.layout.master')                

    @section('main_content')
    <!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/data-tables/latest/dataTables.bootstrap.min.css">
    
<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$module_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                      <li class="active">{{$module_title or ''}}</li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
        
    <div class="row">

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
          
          <a href="{{ url($module_url_path.'/create') }}" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add More"><i class="fa fa-plus"></i> </a> 
          
          <a href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
          <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 
         <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 
         <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a>
          </div>
        
        <br/>
        <br>
        <div class="clearfix">
        </div>
        <div class="table-responsive" style="border:0">
          <input type="hidden" name="multi_action" value="" />
          <table class="table table-advance"  id="table1" >
            <thead>
              <tr>
                <th> 
                  <div class="checkbox checkbox-success">
                      <input class="checkboxInputAll" id="checkbox0" type="checkbox">
                      <label for="checkbox0">  </label>
                  </div>
                </th>
                <th>Country Name
                </th> 
                <th>Country Code
                </th> 
                <th>Status
                </th> 
                <th>Action
                </th>
              </tr>
            </thead>
            <tbody>
              @if(isset($arr_data) && sizeof($arr_data)>0)
              @foreach($arr_data as $data)
              <?php $show_url = $module_url_path.'/edit/'.base64_encode($data['id']); ?>
              <tr>
                <td> 
                 <div class="checkbox checkbox-success"><input type="checkbox" name="checked_record[]" value="{{base64_encode($data['id'])}}" id="checkbox{{$data['id']}}" class="case checkboxInput"/><label for="checkbox{{$data['id']}}"></label> </div>
                </td>
                <td onclick="show_details('{{ $show_url }}')"> {{ $data['country_name'] }} 
                </td> 
                <td onclick="show_details('{{ $show_url }}')"> {{ $data['country_code'] }} 
                </td> 
                <td>
                  @if($data['is_active']==1)
                 
                  <input type="checkbox" checked data-size="small"  data-enc_id="{{base64_encode($data['id'])}}"  id="status_{{$data['id']}}" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />
                  @else
                 
                  <input type="checkbox" data-size="small" data-enc_id="{{base64_encode($data['id'])}}"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />
                  @endif                     
                </td> 
                <td> 
                  <a class="btn btn-circle btn-success btn-outline show-tooltip" href="{{ $module_url_path.'/show/'.base64_encode($data['id']) }}" 
                     title="View" >
                    <i class="ti-eye" title="View" > 
                    </i>
                  </a>
                  <a class="btn btn-outline btn-info btn-circle show-tooltip"  title="Edit" href="{{ $module_url_path.'/edit/'.base64_encode($data['id']) }}">
                    <i class="ti-pencil">
                    </i>
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
  var module_url_path = '{{$module_url_path}}';
  $(document).ready(function(){
    $('#table1').DataTable([]);
  });
  $(function(){

   $("input.checkboxInputAll").click(function(){

      if($("input.checkboxInput:checkbox:checked").length <= 0){
          $("input.checkboxInput").prop('checked',true);
      }else{
          $("input.checkboxInput").prop('checked',false);
      }

     }); 
  });
  function show_details(url)
  {
    window.location.href = url;
  }
    
  function statusChange(data)
  {
    var ref = data; 
    var type = data.attr('data-type');
    var enc_id = data.attr('data-enc_id');
    var id = data.attr('data-id');

      $.ajax({
        url:module_url_path+'/'+type,
        type:'GET',
        data:{id:enc_id},
        dataType:'json',
        success: function(response)
        {
          if(response.status=='SUCCESS'){
            if(response.data=='ACTIVE')
            {
              $(ref)[0].checked = true;  
              $(ref).attr('data-type','deactivate');

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','activate');
            }
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
          }  
        }
      });  
  } 
  </script>
  <!--page specific plugin scripts-->
  @stop                    
