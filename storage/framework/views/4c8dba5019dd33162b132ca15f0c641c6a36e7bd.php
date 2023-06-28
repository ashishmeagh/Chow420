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
      <li>Refered Users</li>
    </ul>
</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">
    <div class="order-main-dvs table-order space-none-order-div">

     
      <div class="table-responsive">
            <table class="table seller-table" id="table_module">
              <thead>
                  <tr>
                      <th>Code</th>
                      <th>Email</th>
                      <th>Order No</th>
                      <th>Amount($)</th>
                      
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

<script type="text/javascript"> 
var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";  </script>

<script type="text/javascript">
    var table_module = false;


    $(document).ready(function()
    {
      
      table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
      bFilter: false,
      //"order":[3,'Asc'],

      ajax: {
      'url': module_url_path+'/get_buyer_refered',
      'data': function(d)
       {        
          d['column_filter[q_code]']     = $("input[name='q_code']").val()      
          d['column_filter[q_email]']    = $("input[name='q_email']").val()       
          d['column_filter[q_amount]']   = $("input[name='q_amount']").val()
          d['column_filter[q_orderno]']  = $("input[name='q_orderno']").val()
       }
      },

      columns: [
      {
        render(data, type, row, meta)
        {
             return row.code;
        },
        "orderable": false, "searchable":false
      },     
       {
        render(data, type, row, meta)
        {
             return row.email;
        },
        "orderable": false, "searchable":false
      },                       
      {data: 'order_no', "orderable": false, "searchable":false},         
     
      {data: 'amount', "orderable": false, "searchable":false},         

      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData();
  });
  /*search box*/
  // <input type="text" name="q_order_date" placeholder="Search" onchange="filterData();" class="input-text datepicker" />
  


   $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_code" placeholder="Search" class="input-text column_filter" /></td>          
          <td><input type="text" name="q_email" placeholder="Search" class="input-text column_filter" /></td>          
         <td><input type="text" name="q_orderno" placeholder="Search" class="input-text column_filter" /></td>   
          <td><input type="text" name="q_amount" placeholder="Search" class="input-text column_filter" /></td>         
                

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