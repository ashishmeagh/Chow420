@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">View Wallet History </h4>
      </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">

          @php
            $user = Sentinel::check();
          @endphp

          @if(isset($user) && $user->inRole('admin'))
            <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
          @endif
            
          <li><a href="{{ url(config('app.project.admin_panel_slug').'/buyers') }}">Buyers</a></li>
          <li class="active">View Wallet History</li>
          
         </ol>
      </div>
   </div>
   <!-- BEGIN Main Content -->
   <div class="col-sm-12">
      <div class="white-box">
         <b>Buyer :  <a href="{{$module_url_path.'/view/'.base64_encode($buyer_id)}}">{{ $arr_user['first_name'] or '' }} {{ $arr_user['last_name'] or '' }}</a></b>

         @include('admin.layout._operation_status')
         {!! Form::open([ 'url' => $module_url_path.'/multi_action',
         'method'=>'POST',
         'enctype' =>'multipart/form-data',   
         'class'=>'form-horizontal', 
         'id'=>'frm_manage' 
         ]) !!}
         {{ csrf_field() }}
         <div class="pull-right">
            
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a>

         </div>
         <br/>
         <div class="table-responsive" style="border:0">
          <input type="hidden" id="buyerid" name="buyerid" value="{{ $buyer_id }}">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                     <th>Type</th>
                     <th>Amount For</th>
                     <th>Amount</th>
                     
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
   var module_url_path         = "{{ $module_url_path or ''}}";
  
   
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
     'url':'{{ $module_url_path.'/get_buyer_wallet_history/'.$buyer_id}}',
     'data': function(d)
       {
         d['column_filter[q_type]']           = $("input[name='q_type']").val()
         d['column_filter[q_orderno]']        = $("input[name='q_orderno']").val()
         d['column_filter[q_amount]']         = $("input[name='q_amount']").val()
      
        
       }
     },
     columns: [
    
     {data: 'type', "orderable": true, "searchable":false},
     {data: 'typeid', "orderable": true, "searchable":false},
     {data: 'amount', "orderable": true, "searchable":false},
     
    
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
   
     /*var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
       $('.js-switch').each(function() {
          new Switchery($(this)[0], $(this).data());
       });
   
     $("input.toggleSwitch").change(function(){
         statusChange($(this));
      });

      $('input.toggleTrusted').change(function(){

         if($(this).is(":checked"))
         {
           var status  = 'trusted';
         }
         else
         {
          var status  = 'not-trusted';
         }
         
         var user_id = $(this).attr('data-enc_id');  
        
         $.ajax({
             method   : 'GET',
             dataType : 'JSON',
             data     : {status:status,user_id:user_id},
             url      : module_url_path+'/mark_as_trusted',
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
      }); 
*/
   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
               
              <td><input type="text" name="q_type" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>             
               
              <td><input type="text" name="q_orderno" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
          
              <td><input type="text" name="q_amount" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>     
                    

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