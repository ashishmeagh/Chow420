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
            <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
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
            <a href="{{ $module_url_path.'/create'}}" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add New {{ str_singular($module_title) }}"><i class="fa fa-plus"></i> </a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a> 
         </div>
         <br/>
         <br/>
         <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                     <th>
                        <div class="checkbox checkbox-success">
                          <input class="checkboxInputAll" id="checkbox0" type="checkbox">
                          <label for="checkbox0">  </label>
                        </div>
                     </th>
                     <th>Name</th>
                     <th>description</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
              </thead>
              <tbody>
                  @if(isset($arr_testimonials) && count($arr_testimonials) > 0)
                    @foreach($arr_testimonials as $testimonial)
                    <tr>
                      <td>
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" name="checked_record[]" value="{{$testimonial['id']}}" id="checkbox{{$testimonial['id']}}" class="case checkboxInput"/><label for="checkbox{{$testimonial['id']}}">  </label></div>
                      </td>
                      <td>{{$testimonial['name'] }}</td>
                      <td>{{str_limit($testimonial['description'], 60,'.....') }}</td>
                      <td>
                        @if($testimonial['is_active'] == '0')

                              <input type="checkbox" data-size="small" data-enc_id="{{base64_encode($testimonial['id'])}}"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />

                         @elseif($testimonial['is_active'] != null && $testimonial['is_active'] == '1')
                                <input type="checkbox" checked data-size="small"  data-enc_id="{{base64_encode($testimonial['id'])}}"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />
                        @endif      

                      </td>
                      <td> 

                        <a class="btn btn-outline btn-info btn-circle show-tooltip" href="{{url($module_url_path)}}/edit/{{base64_encode($testimonial['id'])}}" title="Edit"><i class="ti-pencil-alt2" ></i></a>

                        <a class="btn btn-circle btn-danger btn-outline show-tooltip" onclick="confirm_delete(this,event);" href="{{url($module_url_path)}}/delete/{{base64_encode($testimonial['id'])}}" title="Delete"><i class="ti-trash" ></i></a>

                      </td>


                    </tr>
                    @endforeach
                  @endif
              </tbody>
            </table>
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "{{ $module_url_path }}";
     
   function confirm_delete(ref,event)
   {
      confirm_action(ref,event,'Are you sure to delete this record?');
   }

   function confirm_approve(ref,event)
   {
      confirm_action(ref,event,'Are you sure to approve this record?');
   }
   
   /*Script to show table data*/
   
   var table_module = false;
   $(document).ready(function()
   {
     table_module = $('#table_module').DataTable({});
   });
    
   
   function statusChange(data)
   {
     swal({
          title: 'Are you sure to update status of this user?',
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
               url:module_url_path+'/change_status',
               type:'GET',
               data:{id:enc_id,type:type},
               dataType:'json',
               success: function(response)
               {
                console.log(response);

                if(response.status == 'success')
                {
                  swal('success',response.message,'success');
                }
                else
                {
                  swal('error',response.message,'error');
                }
                 // if(response.status=='SUCCESS'){
                 //   if(response.data=='ACTIVE')
                 //   {
                 //     $(ref)[0].checked = true;  
                 //     $(ref).attr('data-type','deactivate');
                 //     sweetAlert('success','Status update successfully','success');
                 //     location.reload(true);
           
                 //   }else
                 //   {
                 //     $(ref)[0].checked = false;  
                 //     $(ref).attr('data-type','activate');
                 //     sweetAlert('success','Status update successfully','success');
                 //     location.reload(true);
                 //   }
                 // }
                 // else
                 // {
                 //   sweetAlert('Error','Something went wrong!','error');
                 // }  
               }
             }); 
          } 
       })
   } 


   function approve_user(ref)
   {  
      swal({
          title: 'Are you sure to approve this user?',
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
              var enc_id = ref.attr('data-enc_id');
              $.ajax({
               url:module_url_path+'/approve',
               type:'GET',
               data:{enc_id:enc_id},
               dataType:'json',
               success: function(response)
               {
                  swal({
                    title: response.description,
                    type: response.status,
                    showCancelButton: true,
                    confirmButtonColor: "#8d62d5",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                  },
                  function(isConfirm,tmp)
                  {
                    if(isConfirm==true)
                    {
                      location.reload();
                    }
                  });
               }
             });
          }
        });
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