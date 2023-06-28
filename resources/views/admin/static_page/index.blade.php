@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Manage {{$module_title or ''}}</h4>
         </div>
         <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">

              @php
                $user = Sentinel::check();
              @endphp
              
              @if(isset($user) && $user->inRole('admin'))
                <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
              @endif
               
               <li class="active">Manage {{$module_title or ''}}</li>
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
               'class'=>'form-horizontal', 
               'id'=>'frm_manage' 
               ]) !!}      
               <div class="pull-right">
                  <!-- <a href="{{ url($module_url_path.'/create') }}" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add CMS"><i class="fa fa-plus"></i> </a> -->
                  <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
                  <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 
                  <!-- <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a>  -->
                  <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a>
               </div>
               <br/>
               <br>

               <div class="table-responsive">
                 <input type="hidden" name="multi_action" value="" />
                 <table class="table table-advance"  id="table_module" >
                    <thead>
                       <tr>
                          <th>
                             <div class="checkbox checkbox-success">
                                <input class="checkboxInputAll" value="delete" id="checkbox0" type="checkbox">
                                <label for="checkbox0">  </label>
                             </div>
                          </th>
                          <th>Page Name</th>
                          <!-- <th>Page Title</th> -->
                          <th>Status</th>
                          <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                       @foreach($arr_static_page as $page)
                       <tr>
                          <td>
                             <div class="checkbox checkbox-success"><input type="checkbox" name="checked_record[]" value="{{ base64_encode($page->id) }}" id="checkbox'{{$page->id}}'" class="case checkboxInput"/><label for="checkbox'{{$page->id}}'"> </label></div>
                          </td>
                          <td> {{ $page->page_title }} </td> 
                          <!-- <td> {{ $page->page_slug }} </td> -->
                          <td>
                             @if($page->is_active=='1')
                             <input type="checkbox" checked data-size="small"  data-enc_id="'{{base64_encode($page->id)}}'"  id="status_'{{$page->id}}'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />
                             @else
                             <input type="checkbox" data-size="small" data-enc_id="'{{base64_encode($page->id)}}'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />
                             @endif
                          </td>
                          <td> 
                             <a class="eye-actn" href="{{ $module_url_path.'/edit/'.base64_encode($page->id) }}"  title="Edit">
                             Edit
                             </a>  
                             <!-- <a class="btn btn-circle btn-danger btn-outline show-tooltip" href="{{ $module_url_path.'/delete/'.base64_encode($page->id)}}" 
                                onclick="confirm_action(this,event,'Are you sure want to delete this record?','CMS Page');"  title="Delete">
                             <i class="ti-trash" ></i>
                             </a>    -->
                          </td>
                       </tr>
                       @endforeach
                    </tbody>
                 </table>
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
   var module_url_path         = "{{ $module_url_path }}";
    $(document).ready(function() {
       $('#table_module').DataTable( {
           "aoColumns": [
           { "bSortable": false },
           { "bSortable": true },
           { "bSortable": true },
           { "bSortable": true },
           { "bSortable": false }
           ]
       });
   });
   
   function statusChange(data)
   {
      swal({
          title: 'Do you really want to update status of this record?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          
            if(isConfirm==true)
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
                        sweetAlert('Success','Status activated successfully','success');
               
                     }else
                     {
                        $(ref)[0].checked = false;  
                        $(ref).attr('data-type','activate');
                        sweetAlert('Success','Status deactivated successfully','success');
                     }

                     
                     }
                     else
                     {
                     sweetAlert('Error','Something went wrong!','error');
                     }  
                  }
               }); 
            }
            else{            
               $(data).trigger('click');            
            } 
         }) 
   }
   
   $(function(){
   
   $("input.checkboxInputAll").click(function(){
      var is_checked = $("input.checkboxInputAll").is(":checked");
      if(is_checked)
      {
         $("input.checkboxInput").prop('checked',true);
      }
      else
      {
        $("input.checkboxInput").prop('checked',false);
      }
   });  
   });


</script>
@stop