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
            
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a> 
         </div>
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
                    <!--  <th>Product Name</th>
                     <th>Seller Name</th>
                     <th>Buyer Name</th> -->
                     <th>Comment</th>
                     <th>Answer</th>
                     <th width="10%">Action</th>
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
   
   function show_details(url)
   { 
      
       window.location.href = url;
   } 
   
   function confirm_delete(ref,event)
   {
      confirm_action(ref,event,'Are you sure to delete this record?');
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
        // d['column_filter[q_name]']        = $("input[name='q_name']").val()
        // d['column_filter[q_email]']       = $("input[name='q_email']").val()
        // d['column_filter[q_status]']       = $("select[name='q_status']").val()
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
      /*{data: 'product_name', "orderable": true, "searchable":false},
      {data: 'seller_name', "orderable": true, "searchable":false},        
      {data: 'buyer_name', "orderable": false, "searchable":false}, */   
      {data: 'comment', "orderable": false, "searchable":false},    
      {data: 'answer', "orderable": false, "searchable":false},    
      {data: 'build_action_btn', "orderable": false, "searchable":false}
      ]
   });
   
   $('input.column_filter').on( 'keyup click', function () 
   {
       filterData();
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

     

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td></td>
                    <td></td>                    
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
                   sweetAlert('Error','Something went wrong!','error');
                 }  
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
               beforeSend : function()
               { 
                 showProcessingOverlay();        
               },        
               success:function(response)
               {
                  hideProcessingOverlay();
                  
                  swal({
                    title: response.description,
                    type: response.status,
                    showCancelButton: false,
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