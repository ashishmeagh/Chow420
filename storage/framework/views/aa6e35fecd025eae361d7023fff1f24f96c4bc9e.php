<?php $__env->startSection('main_content'); ?>


<style type="text/css">
  @media
    only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {
     table,  thead,  tbody,  th,  td,  tr {
      display: block;
    }
     thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }
     tr.searchinput-data{
      position: static;
    }
     tr.searchinput-data td{width: 93% !important; border: none;}
     tr.searchinput-data td input{width: 100%;}
     tr.searchinput-data .select-style{width: 100%;}
    .searchinput-data td:before{ display: none; }
     tr {
      margin: 0 0 1rem 0; 
      border: 1px solid #ddd;
      box-shadow: 0 1px 0 #ccc; border-radius: 3px;
    }
      .table > thead > tr > td.remove-border{ 
display: none;
      border-top: none !important; border-bottom: none !important;}
     td.dataTables_empty:before{ display: none; padding: 9px 18px 7px;}
      
     tr:nth-child(odd) {
      background: #f9f9f9;
    border: 1px solid #ccc;
    }
     .table > tbody > tr > td{ 
      padding: 23px 18px 7px;
      border-top: 1px solid #ececec;
    }
     td {
      border: none;
      border-bottom: none;
      position: relative;
      padding-left: 50%; font-size: 14px;
    }

     td:before {
      position: absolute;
      top: 4px;
      left: 17px;
      width: 45%;font-weight: 600;
      padding-right: 10px; font-size: 14px;
      white-space: nowrap;
    }
     .search-header{display: block;}

     td:nth-of-type(1):before { content: "Order No"; }
     td:nth-of-type(2):before { content: "Transaction ID"; }  
     td:nth-of-type(3):before { content: "Date"; }
     td:nth-of-type(4):before { content: "Price"; }
     td:nth-of-type(5):before { content: "Status"; }
     td:nth-of-type(6):before { content: "Action"; }
  }
</style>

<div class="my-profile-pgnm">
  Payment History
     <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Payment History</li>
    </ul>
</div>
    <div class="new-wrapper">
        <div class="order-main-dvs table-order">
            <div class="table-responsive">
                <table class="table seller-table" id="table_module">
                    <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Transaction ID</th>
                            <th>Date</th>
                            <th>Price</th>
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
      
      {data: 'build_action_btn', "orderable": false, "searchable":false},     
      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData(); 
  });
  /*search box*/
  $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_order_no" placeholder="Search" class="input-text column_filter" /></td>             
          <td><input type="text" name="q_transaction_id" placeholder="Search" class="input-text column_filter" /></td>   
         <td><input type="text" name="q_order_date" id="datepicker" placeholder="Search" onchange="filterData();" class="input-text datepicker column_filter" /></td>     
        
          <td><input type="text" name="q_price" placeholder="Search" class="input-text column_filter" /></td>           
           <td width="12%"><div class="select-style">
            <select class="frm-select column_filter" name="q_payment_status" id="q_payment_status" onchange="filterData();">
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
<link href="<?php echo e(url('/')); ?>/assets/seller/css/jquery-ui.css" rel="stylesheet" type="text/css" />
  
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker(
        { dateFormat: 'dd M yy' }
      );
  } );
  </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>