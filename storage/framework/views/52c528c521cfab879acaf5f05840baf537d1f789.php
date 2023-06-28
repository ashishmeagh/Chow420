                
<?php $__env->startSection('main_content'); ?>
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">View Payment History </h4>
      </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">

          <?php
            $user = Sentinel::check();
          ?>

          <?php if(isset($user) && $user->inRole('admin')): ?>
            <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
          <?php endif; ?>
            
          <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/buyers')); ?>">Buyers</a></li>
          <li class="active">View Payment History</li>
          
         </ol>
      </div>
   </div>
   <!-- BEGIN Main Content -->
   <div class="col-sm-12">
      <div class="white-box">
         <b>Buyer :  <a href="<?php echo e($module_url_path.'/view/'.base64_encode($buyer_id)); ?>"><?php echo e(isset($arr_user['first_name']) ? $arr_user['first_name'] : ''); ?> <?php echo e(isset($arr_user['last_name']) ? $arr_user['last_name'] : ''); ?></a></b>

         <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         <?php echo Form::open([ 'url' => $module_url_path.'/multi_action',
         'method'=>'POST',
         'enctype' =>'multipart/form-data',   
         'class'=>'form-horizontal', 
         'id'=>'frm_manage' 
         ]); ?>

         <?php echo e(csrf_field()); ?>

         <div class="pull-right">
            <!-- <a href="<?php echo e($module_url_path.'/create'); ?>" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add New <?php echo e(str_singular($module_title)); ?>"><i class="fa fa-plus"></i> </a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a>  -->
         </div>
         <br/>
         <div class="table-responsive" style="border:0">
          <input type="hidden" id="buyerid" name="buyerid" value="<?php echo e($buyer_id); ?>">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                     <th>Order No</th>
                     <th>Transaction Id</th>
                     <th>Date & Time</th>
                     <th>Price($)</th>     
                     <th>Wallet Amount Used ($)</th>               
                     <th width="10%">Status</th>
                  </tr>                
              </thead>
              <tbody>
              </tbody>
            </table>
         </div>
         <?php echo Form::close(); ?>

      </div>
   </div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "<?php echo e($module_url_path); ?>";
   
   function show_details(url)
   { 
      
       window.location.href = url;
   } 
   
   function confirm_delete(ref,event)
   {
      var delete_param = 'Buyer';
      confirm_action(ref,event,'Are you sure want to delete this record?',delete_param);
   }

   function confirm_approve(ref,event)
   {
      confirm_action(ref,event,'Are you sure want to approve this record?');
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
     'url':'<?php echo e($module_url_path.'/get_payment_details/'.$buyer_id); ?>',
     'data': function(d)
       {
         d['column_filter[q_order_no]']        = $("input[name='q_order_no']").val()
         d['column_filter[q_transaction_id]']  = $("input[name='q_transaction_id']").val()
         d['column_filter[q_transaction_status]'] = $("select[name='q_transaction_status']").val()
         d['column_filter[q_price]']    = $("input[name='q_price']").val()
        
       }
     },
     columns: [
    
     {data: 'order_no', "orderable": true, "searchable":false},
     {data: 'transaction_id', "orderable": true, "searchable":false},
     {data: 'created_at', "orderable": true, "searchable":false},
     {data: 'total_amount', "orderable": true, "searchable":false},
     {data: 'wallet_amount_used', "orderable": true, "searchable":false},
     {data: 'transaction_status', "orderable": true, "searchable":false},
    
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

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td><input type="text" name="q_order_no" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    <td><input type="text" name="q_transaction_id" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    <td></td>
                     <td><input type="text" name="q_price" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    <td></td>
                    <td>
                       <select class="search-block-new-table column_filter small-form-control" name="q_transaction_status" id="q_transaction_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="0">Pending</option>
                        <option value="1">Completed</option>
                        <option value="2">Failed</option>
                        </select>
                    </td>
                    

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>