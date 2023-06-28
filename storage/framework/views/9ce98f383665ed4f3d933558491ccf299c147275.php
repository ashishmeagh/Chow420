<?php $__env->startSection('main_content'); ?>
<style type="text/css">
.sms-bank-details {
    color: #ab0d0d;
    background-color: #f9efef;
    padding: 10px;
    border-radius: 3px;
    margin-top: 20px;
    border: 1px solid #eac9c9;
    margin-bottom: 30px;
    box-shadow: 0px 2px 22px -8px #ffcece;
}

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

     td:nth-of-type(1):before { content: "User Name"; }
     td:nth-of-type(2):before { content: "Email"; }  
     td:nth-of-type(3):before { content: "Referal Code"; }
     td:nth-of-type(4):before { content: "Amount"; }
     td:nth-of-type(5):before { content: "Date"; }
     td:nth-of-type(6):before { content: "Status"; }
  }
</style>

<div class="my-profile-pgnm">
Refered Users
   <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Refered Users</li>
    </ul>
</div> 

 
      
  <div class="new-wrapper">
    <?php echo $__env->make('front.layout.flash_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="order-main-dvs table-order main-content-div">

     
  

      <div class="table-responsive">
        <table class="table seller-table" id="table_module">
          <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Referal Code</th>
                <th>Amount</th>    
                <th>Date</th>      
                <th>Status</th>          
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
      searching: false,

      ajax: {
      'url': module_url_path+'/get_user_details',
      'data': function(d)
       { 
          d['column_filter[q_email]']   = $("input[name='q_email']").val()
                  
        }
      },

      columns: [
      {
        render(data, type, row, meta)
        {
             return row.user_name;
        },
        "orderable": false, "searchable":false
      },                            
      {data: 'email', "orderable": false, "searchable":false},        
      {data: 'code', "orderable": false, "searchable":false},            
    
      {
        render(data, type, row, meta)
        {
             return '<i class="fa fa-dollar"></i>'+(+row.amount).toFixed(2);
        },
        "orderable": false, "searchable":false
      },  
      {data: 'created_at', "orderable": false, "searchable":false},    
      {
         data : 'withdraw_reqeust_status',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.withdraw_reqeust_status == '0')
           {            
             return `<div class="status-pendgt">In Wallet</div>`
           }
           else if(row.withdraw_reqeust_status == '1')
           {            
             return `<div class="status-dispatched">Requested</div>`
           }
           else if(row.withdraw_reqeust_status == '2')
           {
             return `<div class="status-completed">Withdrawn</div>`

           }          
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
 
  $("#table_module").find("thead").append(`<tr>          
          <td></td>
          <td></td>             
          <td></td>    
          <td></td>
          <td></td>
      
      </tr>`);

   // <td><input type="text" name="q_price" placeholder="Search" class="input-text column_filter" /></td>

  $('input.column_filter').on( 'keyup click', function () 
  {
       filterData();
  });
  });

  function filterData()
  {
    table_module.draw();
  }

  function withdraRequest(msg) {
    var msg = msg || false;

    var module_url_path = "<?php echo e($module_url_path); ?>";
    var wallet_amount = '<?php echo e(isset($wallet_amount) ? $wallet_amount : ''); ?>';
    var refund_balance_amount = '<?php echo e(isset($refund_balance_amount) ? $refund_balance_amount : ''); ?>';
    var seller_id = '<?php echo e(isset($seller_id) ? $seller_id : ''); ?>';
    var min_seller_amt = '<?php echo e(config('app.project.seller_min_withdraw_amount')); ?>';

    if(wallet_amount == '' || wallet_amount == '0')
    {
      swal('Alert!','Insufficient funds in your wallet.');
      return false;
    }
    // alert(wallet_amount)
    if((refund_balance_amount != '0') && parseFloat(refund_balance_amount)>parseFloat(wallet_amount))
    {
      rembal_uncleared = parseFloat(refund_balance_amount) - parseFloat(wallet_amount);
      swal('Alert!','You have $'+refund_balance_amount+' uncleared refund amount. Add $'+rembal_uncleared+' more to clear it first !');
      return false;
    }

    if(seller_id == '' || seller_id == '0')
    {
      swal('Alert!','Something went wrong');
      return false;
    }

    if(parseFloat(wallet_amount) <= parseFloat(min_seller_amt))
    {
      swal('Alert!','You can not withdraw less than $'+min_seller_amt);
      return false;
    }

    swal({
          title: msg,
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#5cc970",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            $.ajax({
              url:module_url_path+'/withdraw_request',
              type:'POST',
              data:{_token:'<?php echo e(csrf_token()); ?>',wallet_amount:wallet_amount,seller_id:seller_id},
              dataType:'json',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success: function(response)
              {
                hideProcessingOverlay();   
                if(response.status=='success'){
                  swal({
                       title: "Success!",
                       text: response.description,
                       type: response.status,
                       confirmButtonText: "OK",
                       closeOnConfirm: false
                    },
                   function(isConfirm,tmp)
                   {
                     if(isConfirm==true)
                     {
                        window.location = window.location.href;
                     }
                   });
                }
                else
                {
                  // sweetAlert('Error','Something went wrong!','error');
                  swal('error',response.description,'error');
                }  
              }
            });   
          }
        });

  }
  
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>