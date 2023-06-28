                    

    <?php $__env->startSection('main_content'); ?>
    <!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">


 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    
<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($module_title) ? $module_title : ''); ?></h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    <?php
                       $user = Sentinel::check();
                    ?>

                    <?php if(isset($user) && $user->inRole('admin')): ?>
                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                    <?php endif; ?>
                      
                      <li class="active"><?php echo e(isset($module_title) ? $module_title : ''); ?></li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
        
    <div class="row">
 
                    <div class="col-sm-12">

                        <div class="white-box">
                        <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                         <form class="form-horizontal" id="frm_manage" method="POST" >
                          <?php echo e(csrf_field()); ?>

                           <br>
                           <br>
                            <div class="table-responsive">
                            <input type="hidden" name="multi_action" value="" />
                                <table id="table_module" class="table table-striped">
                                    <thead>
                                       <tr>
                                          <th>Order No</th>
                                          <th>Buyer Name</th>
                                          <th>Transaction ID</th>
                                          <th>Date & Time</th>
                                          <th>Price($)</th>
                                          <th>Wallet Amount Used($)</th>
                                          <th>Total Amount($)</th>
                                          <th>Cashback</th>
                                          <th>Status</th>
                                          <th>Action</th>  
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </form>
          </div>
        </div>
      </div>


<style>
  
  .status-completed {
    background-color: #009930;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    color: #fff;
}
.status-shipped{
    background-color: #e95151;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    color: #fff;
}
.status-dispatched{
    background-color: #f3ba39;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    color: #fff;
}


</style>
<!-- END Main Content -->



<script type="text/javascript">

    var module_url_path         = "<?php echo e($module_url_path); ?>";

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
      bFilter: false,
      "order":[4,'Asc'],

      ajax: {
      'url': module_url_path+'/get_all_transactions',
      'data': function(d)
       {        
          d['column_filter[q_order_no]']     = $("input[name='q_order_no']").val()         
          d['column_filter[q_buyer_name]']     = $("input[name='q_buyer_name']").val()   

          d['column_filter[q_transaction_id]']  = $("input[name='q_transaction_id']").val()
         
          d['column_filter[q_price]'] = $("input[name='q_price']").val()
          
          d['column_filter[q_payment_status]']  = $("select[name='q_payment_status']").val()
          d['column_filter[q_order_date]']    = $("input[name='q_order_date']").val()
          
       }
      },

      columns: [
      {
        render(data, type, row, meta)
        {
             return row.order_no;
        },
        "orderable": false, "searchable":false
      },                       
      {data: 'buyer_name', "orderable": false, "searchable":false}, 
     
      {data: 'transaction_id', "orderable": false, "searchable":false},         
      {data: 'created_at', "orderable": false, "searchable":false},
     
      {
        render(data, type, row, meta)
        {
             return '<i class="fa fa-dollar"></i>'+(+row.total_price).toFixed(2);
        },
        "orderable": false, "searchable":false
      },             
      {data: 'buyer_wallet_amount', "orderable": false, "searchable":false},         
      {data: 'full_amount', "orderable": false, "searchable":false},     
       {data: 'cashback', "orderable": false, "searchable":false},     

      {
         data : 'transaction_status',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.transaction_status == 'Pending')
           {
            
             return `<div class="status-dispatched">`+row.transaction_status+`</div>`

           }
           else if(row.transaction_status == 'Completed')
           {
             return `<div class="status-completed">`+row.transaction_status+`</div>`

           }
           else if(row.transaction_status == 'Failed')
           {
             return `<div class="status-shipped">`+row.transaction_status+`</div>`
           }
           // else
           // {
           //    return `<span class="label label-warning">Pending</span>`
           // }
         },
         "orderable": false,
         "searchable":false
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
  /*search box*/
  $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_order_no" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>             
          <td><input type="text" name="q_buyer_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>          
          <td><input type="text" name="q_transaction_id" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>   
         <td><input type="text" name="q_order_date" id="datepicker" placeholder="Select Date" readonly onchange="filterData();" class="search-block-new-table column_filter form-control datepicker" /></td>     
        
          <td><input type="text" name="q_price" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>  
          <td></td>
          <td></td>   
          <td></td>      
           <td>
            <select class="search-block-new-table column_filter small-form-control" name="q_payment_status" id="q_payment_status" onchange="filterData();">
                  <option value="">All</option>
                  <option value="0">Pending</option>
                  <option value="1">Completed</option>
                  <option value="2">Failed</option>
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
    confirm_action(ref,event,'Are you sure to delete this record?');
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

$(function(){

   $("input.checkboxInputAll").click(function(){

      if($("input.checkboxInput:checkbox:checked").length <= 0){
          $("input.checkboxInput").prop('checked',true);
      }else{
          $("input.checkboxInput").prop('checked',false);
      }

   }); 
});
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var j = jQuery.noConflict();
    j( function() {
        j( "#datepicker" ).datepicker(

            { dateFormat: 'dd M yy' }
          );
    } );

</script>
<?php $__env->stopSection(); ?>                    



<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>