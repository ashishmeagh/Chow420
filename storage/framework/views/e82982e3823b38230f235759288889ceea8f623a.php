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

     td:nth-of-type(1):before { content: "Membership"; }
     td:nth-of-type(2):before { content: "Type"; }  
     td:nth-of-type(3):before { content: "Amount"; }
     td:nth-of-type(4):before { content: "Product Limit"; }
     td:nth-of-type(5):before { content: "Status"; }
     td:nth-of-type(6):before { content: "Payment Status"; }
     td:nth-of-type(7):before { content: "Date"; }
     td:nth-of-type(8):before { content: "Cancellation Reason"; }

  }
</style>
<div class="my-profile-pgnm">
  Membership History
     <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Membership History</li>
    </ul>
</div>
    <div class="new-wrapper">
        <div class="order-main-dvs table-order">
            <div class="table-responsive">
                <table class="table seller-table" id="table_module">
                    <thead>
                        <tr>
                            <th>Membership</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Product Limit</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Date</th>
                            <th>Cancellation Reason</th>
                           
                        </tr> 
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
    </div>
</div>
<script type="text/javascript"> 

var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";  

</script>

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
         
          d['column_filter[q_membership_name]'] = $("input[name='q_membership_name']").val()
          d['column_filter[q_membership_amount]'] = $("input[name='q_membership_amount']").val()
          d['column_filter[q_membership]'] = $("select[name='q_membership']").val()
          d['column_filter[q_product_limit]'] = $("input[name='q_product_limit']").val()
          d['column_filter[q_membership_status]'] = $("select[name='q_membership_status']").val()
          d['column_filter[q_payment_status]'] = $("select[name='q_payment_status']").val()
          d['column_filter[q_created_at]']  = $("input[name='q_created_at']").val()

       }
      },

      columns: [
                   
      {data: 'membershipname', "orderable": false, "searchable":false},         
      {data: 'membership', "orderable": false, "searchable":false},
      {data: 'membership_amount', "orderable": false, "searchable":false},
      {data: 'product_limit', "orderable": false, "searchable":false},
      
      {
         data : 'membership_status',  
         render : function(data, type, row, meta) 
         { 
            if(row.membership_status == 'Active')
           {
             return `<div class="status-completed">`+row.membership_status+`</div>`

           }
           else if(row.membership_status == 'Cancelled')
           {
             return `<div class="status-shipped">`+row.membership_status+`</div>`
           }
           
         },
         "orderable": false,
         "searchable":false
       },

         {
         data : 'payment_status',  
         render : function(data, type, row, meta) 
         { 
            if(row.payment_status == 'Completed')
           {
             return `<div class="status-completed">`+row.payment_status+`</div>`

           }
           else if(row.payment_status == 'Failed')
           {
             return `<div class="status-shipped">`+row.payment_status+`</div>`
           }
           else if(row.payment_status == 'Free')
           {
             return '-';
           }
           
         },
         "orderable": false,
         "searchable":false
       },
      {data: 'created_at', "orderable": false, "searchable":false},
      {data: 'cancel_reason', "orderable": false, "searchable":false},

      // {data: 'build_action_btn', "orderable": false, "searchable":false},     
      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData(); 
  });
  /*search box*/
  $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_membership_name" placeholder="Search" class="input-text column_filter" /></td>             
          <td>
           <div class="select-style">
             <select class="frm-select column_filter" name="q_membership" id="q_membership" onchange="filterData();">
                  <option value="">All</option>
                  <option value="1">Free</option>
                  <option value="2">Paid</option>
              </select>
            </div>
         </td>   
         <td><input type="text" name="q_membership_amount" id="q_membership_amount" placeholder="Search" class="input-text column_filter" /></td>     
        
          <td><input type="text" name="q_product_limit" placeholder="Search" class="input-text column_filter" /></td>           
          <td width="12%">
            <div class="select-style">
             <select class="frm-select column_filter" name="q_membership_status" id="q_membership_status" onchange="filterData();">
                  <option value="">All</option>
                  <option value="0">Cancelled</option>
                  <option value="1">Active</option>
             </select>
            </div>
          </td>     
          <td>
               <div class="select-style">
                   <select class="frm-select column_filter" name="q_payment_status" id="q_payment_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="1">Completed</option>
                        <option value="2">Failed</option>
                   </select>
               </div>   
          </td>
          <td><input type="text" name="q_created_at" id="datepicker" placeholder="Search" class="input-text column_filter datepicker" onchange="filterData();"/></td>
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


<!------------start modal-of cancel reason---------------->

  <script type="text/javascript">
    $(document).on('click','.readmorebtn',function(){

     var reason = $(this).attr('cancel_reason');       
     if(reason)
     {
        $("#membership_cancel_sectionmodal").modal('show');
        $("#showmessage").html(reason);
     }
   });
  </script>

<div class="modal fade" id="membership_cancel_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel" align="center">Reason</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="" id="viewdetails">
          <span id="showmessage"></span>          
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
       <div class="modal-footer">      
        <button type="button" class="btn btn-default" id="closebtn" data-dismiss="modal" aria-label="Close">Close</button>
       </div>
    </div>
   </div> 
</div>
<!------------end modal-of cancel reason---------------->



<?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>