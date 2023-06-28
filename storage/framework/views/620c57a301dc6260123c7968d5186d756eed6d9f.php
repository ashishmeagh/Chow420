<?php $__env->startSection('main_content'); ?>
 
 <style>
   /*#table_module_wrapper .row{margin-left: 0px; margin-right: 0px;}*/

   @media
    only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {

    /* Force table to not be like tables anymore */
    table, thead, tbody, th, td, tr {
      display: block;
    }

    /* Hide table headers (but not display: none;, for accessibility) */
    thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }

    tr {
         margin: 0 0 1rem 0;
         border: 1px solid #ddd;
         box-shadow: 0 1px 0 #ccc;
         border-radius: 3px;
      }
      
    tr:nth-child(odd) {
      background: #f9f9f9;border: 1px solid #ccc;
    }
    
    td {
      /* Behave  like a "row" */
      border: none;     font-size: 14px !important;
         border-bottom: 1px solid #ececec;
      position: relative;
      padding-left: 50%;     padding: 23px 18px 7px !important;
          border-top: none !important;
    }

    td:before {
      /* Now like a table header */
      position: absolute;
      /* Top/left values mimic padding */
      top: 4px;
      left: 17px;
      width: 45%;
      padding-right: 10px;
      white-space: nowrap; font-size: 14px;
    }

    td:nth-of-type(1):before { content: "Order No"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(2):before { content: "Transaction ID";  font-family: 'nunito_sansbold';}
    td:nth-of-type(3):before { content: "Date"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(4):before { content: "Price ($)"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(5):before { content: "Status";  font-family: 'nunito_sansbold';}
  }
 </style>
<div class="my-profile-pgnm">
  <?php echo e(isset($page_title)?$page_title:''); ?>

    <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Payment History</li>
    </ul>
</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">
    <div class="order-main-dvs table-order space-none-order-div">
      <div class="table-responsive">
            <table class="table seller-table" id="table_module">
              <thead>
                  <tr>
                      <th>Order No</th>
                      <th>Transaction ID</th>
                      <th width="200px">Date</th>
                      <th>Price ($)</th>
                      <th>Wallet Amount Used</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
          </table>
</div>
        <div class="pagination-chow pagination-bottom-space">
            
        </div>
    </div>
</div>

<script type="text/javascript"> var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";  </script>

<script type="text/javascript">
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
      'url': module_url_path+'/get_payment_history',
      'data': function(d)
       {        
          d['column_filter[q_order_no]']     = $("input[name='q_order_no']").val()         
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
      {data: 'transaction_id', "orderable": false, "searchable":false},         
      {data: 'created_at', "orderable": false, "searchable":false},
     
      {
        render(data, type, row, meta)
        {
             return '<i class="fa fa-dollar"></i>'+(+row.total_amount).toFixed(2);
        },
        "orderable": false, "searchable":false
      },             
      {data: 'buyer_wallet_amount', "orderable": false, "searchable":false},
     
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
     
      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData();
  });
  /*search box*/
  // <input type="text" name="q_order_date" placeholder="Search" onchange="filterData();" class="input-text datepicker" />
  


   $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_order_no" placeholder="Search" class="input-text column_filter" /></td>             
          <td><input type="text" name="q_transaction_id" placeholder="Search" class="input-text column_filter" /></td>   
         <td></td>     
        
          <td><input type="text" name="q_price" placeholder="Search" class="input-text column_filter" /></td>     
          <td></td>      
           <td>
           <div class="select-style">
            <select class="frm-select" name="q_payment_status" id="q_payment_status" onchange="filterData();">
                  <option value="">All</option>
                  <option value="0">Pending</option>
                  <option value="1">Completed</option>
                  <option value="2">Failed</option>
            </select>
            </div>
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
</script>
<style>
  .dataTables_empty{
    text-align: center;
  }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>