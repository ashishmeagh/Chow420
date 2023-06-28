                
<?php $__env->startSection('main_content'); ?>
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">View Wallet History </h4>
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
          <li class="active">View Wallet History</li>
          
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
            
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a>

         </div>
         <br/>
         <div class="table-responsive" style="border:0">
          <input type="hidden" id="buyerid" name="buyerid" value="<?php echo e($buyer_id); ?>">
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
         <?php echo Form::close(); ?>

      </div>
   </div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";
  
   
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
     'url':'<?php echo e($module_url_path.'/get_buyer_wallet_history/'.$buyer_id); ?>',
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>