<?php $__env->startSection('main_content'); ?>
<?php $ordermodel = app('App\Models\OrderModel'); ?> 

<style>
    .dispute_pending
    {
        color:red;
    }
    .dispute_approved
    {
       color:green; 
    }
.rtablehead.order-no-plc{
  
}
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

    td:nth-of-type(1):before { content: "Order ID"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(2):before { content: "Date";  font-family: 'nunito_sansbold';}
    td:nth-of-type(3):before { content: "Dispensary"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(4):before { content: "Price ($)"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(5):before { content: "Is Age Restricted";  font-family: 'nunito_sansbold';}
    td:nth-of-type(6):before { content: "Status"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(7):before { content: "Action";  font-family: 'nunito_sansbold';}
  }
a.eye-actn{
  margin-left: 0px;
}
</style>


<!-- Modal My-Review-Ratings-Add Start -->
<div id="raiseDispute" class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <form id="frm-raiseDispute">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo e(url('/')); ?>/assets/front/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">Add Dispute Details</div>

                <input type="hidden" name="order_id" id="order_id" value="">
                <input type="hidden" name="order_no" id="order_no" value="">
                <div class="form-group">
                    <label for="">Message</label>
                    <textarea name="message" id="message" placeholder="Enter Your Message" data-parsley-required="true" data-parsley-required-message="Please enter message." data-parsley-minlength="20"></textarea>
                </div>

            <div class="button-list-dts btn-order-cnls">
                <a class="butn-def" id="btn-raiseDispute">Submit</a>
            </div>
            <div class="clr"></div>
        </div>
       </form>  
    </div>
</div>
<!-- Modal My-Review-Ratings-Add End -->


<div class="my-profile-pgnm">
  <?php echo e(isset($page_title)?$page_title:''); ?>s 

  <ul class="breadcrumbs-my">
    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li> Orders</li>
  </ul>

</div>
<div class="chow-homepg">Chow420 Home Page</div>
<?php 
$enc_id=""; 
?>
 
<div class="new-wrapper">
    <div class="order-main-dvs table-order">
        <div class="table-responsive">
           <table class="table seller-table" id="table_module">
                 <thead>
                  <tr>

                    <th width="150px"><strong>Order ID</strong></th>
                    <th width="150px"><strong>Date</strong></th>
                    <th width="150px"><strong>Dispensary</strong></th>
                    <!-- <th width="150px"><strong>Time</strong></th> -->
                   
                    <th width="15%"><strong>Price ($)</strong></th>
                    <th width="150px"><strong>Is Age Restricted</strong></th>
                    <th width="150px"><strong>Status</strong></th>
                    <th width="220px"><strong>Action</strong></th> 
                </thead>
                <tbody>

                
          
             </tbody> 
        </table>
        </div>
       </div>

       
                          
    </div>
</div>


 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Order note:</h4>
      </div>
      
      <form class="signup-form" id="note_form"  >
        <?php echo e(csrf_field()); ?>


        <div class="modal-body" style="height: 130px;"> 
          <div class="md-form">
              
              <div id="order_note_show" > </div>
              <input type="hidden" name="order_id" class="modal_order_id" >
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>

    </div>
  </div>


    



</div>


<script type="text/javascript">
    function raiseDispute(ref)
    {
        var order_id = $(ref).attr('data-order_id');
        var order_no = $(ref).attr('data-order_no'); 
        $("#raiseDispute #order_id").val(order_id);
        $("#raiseDispute #order_no").val(order_no);
        $("#raiseDispute").modal('show');
    }
 
    
    $("#btn-raiseDispute").click(function()
    {
      if($('#frm-raiseDispute').parsley().validate()==false) return;
      var order_id   = $("#raiseDispute #order_id").val();
      var order_no   = $("#raiseDispute #order_no").val();

      var message    = $("#raiseDispute #message").val();
      var csrf_token = "<?php echo e(csrf_token()); ?>";

        $.ajax({
              url: SITE_URL+'/buyer/dispute/raise',
              type:"POST",
              data: {order_id:order_id,order_no:order_no,message:message,_token:csrf_token},             
              dataType:'json',
              beforeSend: function(){   
              showProcessingOverlay();         
              },
              success:function(response)
              {
                 hideProcessingOverlay();
                if(response.status == 'success')
                { 
                  swal({
                          title: 'Success',
                          text: response.description,
                          type: 'success',
                          confirmButtonText: "OK",
                          closeOnConfirm: true
                       },
                      function(isConfirm,tmp)
                      {                       
                        if(isConfirm==true)
                        {
                            window.location.reload();
                            $(this).removeClass('active');
                        }

                      });
                }
                else
                {                
                  swal('Error',response.description,'error');
                }  
              }  
      }); 

    }); 

</script> 


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
      'url': SITE_URL+'/buyer/order/get_myorders',
      'data': function(d)
       {        
          d['column_filter[q_order_no]']   = $("input[name='q_order_no']").val()     
          d['column_filter[q_order_date]']   = $("input[name='q_order_date']").val()         
    
         
          d['column_filter[q_price]']      = $("input[name='q_price']").val()
          
         // d['column_filter[q_payment_status]']  = $("select[name='q_payment_status']").val()
          d['column_filter[q_order_status]']  = $("select[name='q_order_status']").val()

          d['column_filter[q_order_date]']    = $("input[name='q_order_date']").val()
          d['column_filter[q_seller_name]']   = $("input[name='q_seller_name']").val()
          d['column_filter[q_buyerageflag]']  = $("select[name='q_buyerageflag']").val()
         
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
      {data: 'date', "orderable": false, "searchable":false},
      {data: 'seller_business_name', "orderable": false, "searchable":false},
    
      {
        render(data, type, row, meta)
        {
             return '<i class="fa fa-dollar"></i>'+(+row.total_amount).toFixed(2);
        },
        "orderable": false, "searchable":false
      },             
      {data: 'buyer_age_restrictionflag', "orderable": false, "searchable":false},
      {
         data : 'order_status',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.order_status == 'Ongoing')
           {
            
             return `<div class="status-dispatched">`+row.order_status+`</div>`

           }else if(row.order_status == 'Shipped' || row.order_status == 'Pending Age Verification')
           {
            
             return `<div class="status-dispatched">`+row.order_status+`</div>`

           }
           else if(row.order_status == 'Delivered')
           {
             return `<div class="status-completed">`+row.order_status+`</div>`

           }
           else if(row.order_status == 'Cancelled')
           {
             return `<div class="status-shipped">`+row.order_status+`</div>`
           }
           else if(row.order_status == 'Dispatched')
           {
             return `<div class="status-dispatched">`+row.order_status+`</div>`
           }
        
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
  // <input type="text" name="q_order_date" placeholder="Search" onchange="filterData();" class="input-text datepicker" />
  


   $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_order_no" placeholder="Search" class="input-text column_filter" /></td>             
          <td></td>  
          <td><input type="text" name="q_seller_name" placeholder="Search" class="input-text column_filter" /></td>      
        
          <td><input type="text" name="q_price" placeholder="Search" class="input-text column_filter" /></td>   
          <td>
               <div class="select-style">
                <select class="column_filter frm-select" name="q_buyerageflag" id="q_buyerageflag" onchange="filterData();">
                    <option value="">All</option>
                    <option value="1">Yes</option> 
                    <option value="0">No</option>                 
                </select>
               </div>
          </td>        
          <td>
            <div class="select-style">
              <select class="column_filter frm-select" name="q_order_status" id="q_order_status" onchange="filterData();">
                    <option value="">All</option>
                    <option value="0">Cancelled</option>
                    <option value="1">Delivered</option>
                    <option value="2">Ongoing</option>
                    <option value="3">Shipped</option>
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


 <script >
    
    function order_note(ref) {

      var order_note = $(ref).data('order_note');

      document.getElementById("order_note_show").innerHTML = order_note ? order_note : 'NA';

      $('#myModal').modal('show');
    } 
  </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>