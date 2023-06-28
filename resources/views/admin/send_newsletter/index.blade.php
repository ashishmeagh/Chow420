@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">Manage {{$module_title or ''}}</h4>
      </div>
      <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
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
          
            <a href="{{ url($module_url_path.'/create') }}" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add Product"><i class="fa fa-plus"></i> </a> 

             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Activate"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Block"><i class="ti-lock"></i> </a> 

             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 
                

            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
         </div>
         <br/>
         <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                    <th>
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" name="checked_record" id="checked_record_all" class="checkboxInputAll" type="checkbox"/><label for="checked_record_all"></label>
                        </div>
                    </th>
                     <th>Email</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>                
              </thead>
              <tbody>
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
   var base_url = "{{ url('/') }}";

   function show_details(url)
   { 
      
       window.location.href = url;
   } 
   
  
   
   /*Script to show table data*/
   
   var table_module = false;
   $(document).ready(function()
   {
   
     table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
      
      bFilter: false ,
      ajax: {
      'url':'{{ $module_url_path.'/get_records'}}',
      'data': function(d)
        {
          d['column_filter[q_email]']     = $("input[name='q_email']").val()
       
           d['column_filter[q_status]']           = $("select[name='q_status']").val()
      
        }
      },
      columns: [
       {
       
        render : function(data, type, row, meta) 
        {
        return '<div class="checkbox checkbox-success"><input type="checkbox" '+
        ' name="checked_record[]" '+  
        ' value="'+row.enc_id+'" id="checkbox'+row.id+'" class="case checkboxInput"/><label for="checkbox'+row.id+'">  </label></div>';
        },
        "orderable": false,
        "searchable":false
       },

      
      {data: 'email', "orderable": false, "searchable":false}, 

     
       {
       render : function(data, type, row, meta) 
       {
         return row.build_status_btn;
       },
       "orderable": false, "searchable":false
       },
         
     {
       render : function(data, type, row, meta) 
       {
         return row.build_action_btn;
       },
       "orderable": false, "searchable":false
     }
      ]
    });

    $('input.column_filter').on( 'keyup click', function () 
    {
        filterData();
    });
    
    $("input.toggleSwitch").change(function(){
       statusChange($(this));
    });

   
   $('#table_module').on('draw.dt',function(event)
   {
     var oTable = $('#table_module').dataTable();
     var recordLength = oTable.fnGetData().length;
     $('#record_count').html(recordLength);
   
     var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
       $('.js-switch').each(function() {
          new Switchery($(this)[0], $(this).data());
       });
   
     $("input.toggleSwitch").change(function(){
         statusChange($(this));
      });

     $('input.toggleApprove').change(function(){

         if($(this).is(":checked"))
         {
           var status  = 1;
           var status_app_disapp = 'Do you really want to approve status of this product?';
         }
         else
         {
           var status  = 0;
           var status_app_disapp = 'Do you really want to disapprove status of this product?';
         }
         
          var product_id = $(this).attr('data-enc_id');  
                  

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                     // star product approve , disapprove
                     //var product_id = $(this).attr('data-enc_id');  

                    if(status==0)
                    {
                        $("#reject_product_sectionmodal").modal('show');
                        $("#hidden_product_id").val(product_id);

                    }else{ 

                   
                     $.ajax({
                         method   : 'GET',
                         dataType : 'JSON',
                         data     : {status:status,product_id:product_id},
                         url      : module_url_path+'/approvedisapprove',
                         success  : function(response)
                         {                         
                          if(typeof response == 'object' && response.status == 'SUCCESS')
                          {
                            swal('Done', response.message, 'success');
                          }
                          else
                          {
                            swal('Oops...', response.message, 'error');
                          }               
                         }
                      });
                   // end product approve,disapprove  
                 }//else

               }
             });


      });     
    

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td><input type="text" id="q_email" name="q_email" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                  
                     <td>
                       <select class="search-block-new-table column_filter small-form-control" name="q_status" id="q_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                        </select>
                    </td> 
                   
                    <td></td>                 
                </tr>`);

       $('input.column_filter').on( 'keyup click', function () 
        {
             filterData();
        });
   });
   
   function filterData()
   {
   table_module.draw();
   }
  
 function confirm_delete(ref,event)
  {
    var delete_param = "Newsletter Email";
    confirm_action(ref,event,'Do you really want to delete this Newsletter email?',delete_param);
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

  $("input.toggleSwitch").change(function(){
       statusChange($(this));
  });

  function statusChange(data)
   {

     swal({
          title: 'Do you really want to update status of this newsletter email?',
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
           var ref     = data;  
           var type    = data.attr('data-type');
           var enc_id  = data.attr('data-enc_id');
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
                     sweetAlert('success','Status update successfully','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','activate');
                     sweetAlert('success','Status update successfully','success');
                     location.reload(true);
                   }
                 }
                 else
                 {
                    //sweetAlert('Error','Something went wrong!','error');
                         if(response.msg)
                         {
                                
                                 swal({
                                  title: response.msg,
                                  type: "warning",
                                  confirmButtonColor: "#873dc8",
                                  confirmButtonText: "Ok",
                                  closeOnConfirm: false
                                },
                                function(isConfirm,tmp)
                                {
                                  if(isConfirm==true)
                                  {  window.location.reload();
                                  }
                                })

                        }
                 }  
               }
             }); 
          } 
          else
          {
            $(data).trigger('click');
          }
       })
   } 
  
      
</script>



@stop