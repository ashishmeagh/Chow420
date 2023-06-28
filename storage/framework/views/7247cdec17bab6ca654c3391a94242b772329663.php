                  
  <?php $__env->startSection('main_content'); ?>
  <style>
  .new_dispute{color:red;}
  </style>
  <!-- BEGIN Page Title -->
  <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
  .main-leftforms {
    position: relative;
}
.main-leftforms .form-lbls input {
    padding: 5px 10px;
    font-size: 14px;
    border: none;
    background-color: #f1f1f1;
}

.form-lbls input{padding: 5px 10px; font-size: 14px;}
  .lblforms{    display: block;
    margin-bottom: 0px;
    font-size: 14px;}
  .errors-frm{
    position: absolute;
    left: 0px;
    top: 41px;
    font-size: 13px;
    line-height: 14px;
  }
  .status-completed {
    background-color: #009930;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    /* font-family: 'open_sanssemibold'; */
    color: #fff;
}
.status-shipped{
    background-color: #e95151;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    /* font-family: 'open_sanssemibold'; */
    color: #fff;
}
.status-dispatched{
    background-color: #f3ba39;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    /* font-family: 'open_sanssemibold'; */
    color: #fff;
}
.status-shipping{
    background-color: #825c06;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    /* font-family: 'open_sanssemibold'; */
    color: #fff;
}

.space-right-padding{margin-right: 20px;}
.ui-widget.ui-widget-content{ z-index: 9999 !important;}
</style>




<!-- Page Content --> 
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    <?php
                      $user = Sentinel::check();
                    ?>

                    <?php if(isset($user) && $user->inRole('admin')): ?>
                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                    <?php endif; ?>
                      
                      <li class="active">Manage <?php echo e(isset($module_title) ? $module_title : ''); ?></li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
           
    <div class="row">
      <div class="col-sm-12">
          <div class="white-box">
                        <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                         <form class="form-horizontal" id="frm_manage" method="POST" action="<?php echo e(url($module_url_path.'/multi_action')); ?>">
                          <?php echo e(csrf_field()); ?>

                         <div class=" pl-left" >
                              
                             


                             <!------------------------------------------------>
                             <div class="main-leftforms">
                              <div class="order-date-dv-cls"><b>Order Date</b></div>
                                <div class="form-lbls">
                                  <input type="text" class="space-right-padding column_filter" id="from" name="from" placeholder="From Date">
                                  <span class="errors-frm" id="from_err"></span>
                                </div>
                                <div class="form-lbls">
                                    <input type="text" class="column_filter" id="to" name="to" placeholder="To Date">
                                    <span class="errors-frm" id="to_err"></span>
                                </div>
                                 <a href="javascript:void(0)" class="btn btn-info uploads-in searchbtn upld-buttons" title="Search">
                                    <img src="<?php echo e(url('/')); ?>/assets/images/search-icons.svg" onclick="filterrecords();filterData();" alt=""></a>

                              <a href="#" class="btn btn-info uploads-in upld-buttons" id="exportbtn" title="Export as xlsx">
                                <img src="<?php echo e(url('/')); ?>/assets/images/upload-icons.svg" alt="Export Excel">
                              </a>


                               <a href="#" class="btn btn-info uploads-in upld-buttons" id="exportbtncsv" title="Export as csv" 
                               >
                                <i style="font-size:19px;" class="fa fa-share-square-o" aria-hidden="true"></i>
                              </a>
                              

                               <div class=" pull-right">
                                <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
                              </div>
                              </div>

                             

                              <!------------------------------------------------>
                             
                              </div>

                             
                           <br>
                           <br>
                            <div class="table-responsive">
                            <input type="hidden" name="multi_action" value="" />
                                <table id="table_module" class="table table-striped">
                                    <thead>
                                        <tr>
                                        
 
                                            <th>Buyer Name</th>
                                            <th>Dispensary Name</th>
                                            <th>Amount($)</th>
                                            <th>Transaction Id</th>
                                            <th>Order No.</th>
                                            <th>Buyer Email</th>
                                            <th>Buyer Age</th>
                                            <th style="width:30% !important">Order Date</th>
                                            <th>Order Status</th>
                                            <th>Dispute Status</th>
                                            <th>Refund Status</th>
                                            <th>Is age restricted</th>
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
<!-- END Main Content -->

<script type="text/javascript">

  var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"; 

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
      'url':'<?php echo e($module_url_path.'/get_records'); ?>',
      'data': function(d)
        {
          d['column_filter[q_buyer_name]']      = $("input[name='q_buyer_name']").val()
          d['column_filter[q_total_amount]']    = $("input[name='q_total_amount']").val()
          d['column_filter[q_order_no]']        = $("input[name='q_order_no']").val()
          d['column_filter[q_order_status]']    = $("select[name='q_order_status']").val()
          d['column_filter[q_dispute_status]']  = $("select[name='q_dispute_status']").val()
          d['column_filter[q_from]']            = $("input[name='from']").val()
          d['column_filter[q_to]']              = $("input[name='to']").val()
          d['column_filter[q_buyer_age_restrictionflag]']  = $("select[name='q_buyer_age_restrictionflag']").val()
          d['column_filter[q_business_name]']    = $("input[name='q_business_name']").val()
          d['column_filter[q_email]']            = $("input[name='q_email']").val()



       } 
      },
      columns: [
      // {
       
      //   render : function(data, type, row, meta) 
      //   {
      //   return '<div class="checkbox checkbox-success"><input type="checkbox" '+
      //   ' name="checked_record[]" '+  
      //   ' value="'+row.enc_id+'" id="checkbox'+row.id+'" class="case checkboxInput"/><label for="checkbox'+row.id+'">  </label></div>';
      //   },
      //   "orderable": false,
      //   "searchable":false
      // },

      {data: 'buyername', "orderable": true, "searchable":false},
      {data: 'business_name', "orderable": true, "searchable":false},
      {data: 'total_amount', "orderable": true, "searchable":false},
      {data: 'transaction_id', "orderable": true, "searchable":false},
      {data: 'order_no', "orderable": true, "searchable":false},
      {data: 'email', "orderable": true, "searchable":false},
      {data: 'buyer_age', "orderable": true, "searchable":false},

      {data: 'created_at', "orderable": true, "searchable":false},
      {data: 'order_status', "orderable": true, "searchable":false},
      {data: 'dispute_status', "orderable": true, "searchable":false},
      
      {
        render : function(data, type, row, meta) 
        {
          // return 'NA';
          return row.btn_refund;
        }, 
        "orderable": false, "searchable":false
      },
      {data: 'buyer_age_restrictionflag', "orderable": true, "searchable":false},
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
    });



    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                     
                    <td><input type="text" id="q_buyer_name" name="q_buyer_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                    <td><input type="text" id="q_business_name" name="q_business_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                    <td><input type="text" id="q_total_amount" name="q_total_amount" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                    <td></td>
                    
                    <td><input type="text" id="q_order_no" name="q_order_no" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                    <td><input type="text" id="q_email" name="q_email" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                    <td></td>
                    <td></td>

                    <td>
                      <select class="search-block-new-table column_filter small-form-control" name="q_order_status" id="q_order_status" onchange="filterData();">
                          <option value="">All</option>
                          <option value="0">Cancelled</option>
                          <option value="1">Delivered</option>
                          <option value="2">Ongoing</option>
                           <option value="3">Shipped</option>
                         
                      </select>
                    </td>
                    <td>
                       <select class="search-block-new-table column_filter small-form-control" name="q_dispute_status" id="q_dispute_status" onchange="filterData();">
                          <option value="">All</option>
                          <option value="0">Pending</option>
                          <option value="1">Approved</option>
                          <option value="2">Rejected</option>
                      </select>  

                    </td>
                    <td></td>
                    <td>
                         <select class="search-block-new-table column_filter small-form-control" name="q_buyer_age_restrictionflag" id="q_buyer_age_restrictionflag" onchange="filterData();">
                          <option value="">All</option>
                          <option value="1">Yes</option>
                          <option value="0">No</option>                         
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

  function confirm_delete(ref,event)
  {
    var delete_param = "Product News";
    confirm_action(ref,event,'Are you sure want to delete this record?',delete_param);
  }

  $("input.checkboxInputAll").click(function()
  {
      if($('#checked_record_all').is(':checked'))
      {
         $("input.checkboxInput").prop('checked',true);
      }
      else
      {
        $("input.checkboxInput").prop('checked',false);
      }
  });


  function statusChange(data)
   {

     swal({
          title: 'Are you sure to update status of this product news?',
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



</script>





<div class="modal fade" id="raiseDispute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="order_id" id="order_id" value="">
    <input type="hidden" name="order_no" id="order_no" value="">
    <input type="hidden" name="dispute_id" id="dispute_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">View Dispute Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="dispute_body">
        <div class="mainbody-mdls">
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left">Order No    :</div>
             <div class="mainbody-mdls-fd-right" id="order_no"></div>
             <div class="clearfix"></div>
          </div>
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left">Buyer Name  :</div>
             <div class="mainbody-mdls-fd-right" id="buyer_name"></div>
             <div class="clearfix"></div>
          </div>
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left">Seller Name :</div>
             <div class="mainbody-mdls-fd-right" id="seller_name"></div>
             <div class="clearfix"></div>
          </div>
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left">Dispute Reason :</div>
             <div class="mainbody-mdls-fd-right" id="dispute_reason"></div>
             <div class="clearfix"></div>
          </div>
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success approvedispute" data-dismiss="modal">Approve</button>
        <button type="button" class="btn btn-danger rejectdispute">Reject</button>
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


        <div class="modal-body" style="height: 140px;"> 
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


 
<!-- Modal My-Review-Ratings-Add End -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

  var module_url_path = "<?php echo e($module_url_path); ?>"

     $(document).on("click",".raiseDispute",function() {

     
      var orderids = $(this).attr('orderids');
      var orderno = $(this).attr('orderno');
      if(orderno || orderids)
      {
          $("#raiseDispute").modal('show');

          $("#order_id").val(orderids);
          $("#order_no").val(orderno);


          $.ajax({
              url: module_url_path+'/disputedetail',
              type:"GET",
              data: {orderno:orderno,orderids:orderids},             
              dataType:'json',
              beforeSend: function(){            
              },
              success:function(response)
              {
                 if(response.status == 'SUCCESS')
                  {   

                     if(response.dispute['dispute_reason']!=undefined){
                     
                      $("#dispute_body #order_no").html(orderno);
                      $("#dispute_body #buyer_name").html(response.buyer_name);
                      $("#dispute_body #seller_name").html(response.seller_name);
                      $("#dispute_body #dispute_reason").html(response.dispute['dispute_reason']);
                      $("#dispute_id").val(response.dispute['id']);
                       $(".approvedispute").show();
                       $(".rejectdispute").show();
                    }else{
                       $("#dispute_body").html('<h3 align="center">No Dispute Raised For This Order.</h3>');
                       $(".approvedispute").hide();
                       $(".rejectdispute").hide();
                    }
                  }
                  else{
                       $("#dispute_body").html('<h3 align="center">No Dispute Raised For This Order.</h3>');
                       $(".approvedispute").hide();
                       $(".rejectdispute").hide();


                  }
              }  
           }); 

      }    
    });

     $(document).on("click",".approvedispute",function() {

      
      var orderno   = $("#order_no").val();
      var disputeid = $("#dispute_id").val();
      var order_id  = $("#order_id").val();
      if(orderno)
      { 
         swal({
          title: 'Do you really want to approve the dispute for this order?',
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


            $.ajax({
                url: module_url_path+'/approve',
                type:"GET",
                data: {orderno:orderno,disputeid:disputeid,order_id:order_id},             
                dataType:'json',
                beforeSend: function(){
                  showProcessingOverlay();            
                },
                success:function(response)
                { 
                    hideProcessingOverlay();
                    if(response.status == 'SUCCESS')
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
                              }

                            });
                    }
                    else
                    {                
                        swal('Error',response.description,'error');
                    }  
                }  
             }); // ajax close

           }
         })


      }// if orderno    
    });


     $(document).on("click",".rejectdispute",function() {
      var orderno = $("#order_no").val();
      var disputeid = $("#dispute_id").val();
      var order_id = $("#order_id").val();
      if(orderno)
      {

        swal({
          title: 'Do you really want to reject the dispute for this order?',
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

               $.ajax({
                    url: module_url_path+'/reject',
                    type:"GET",
                    data: {orderno:orderno,disputeid:disputeid,order_id:order_id},             
                    dataType:'json',
                    beforeSend: function(){   
                      showProcessingOverlay();           
                    },
                    success:function(response)
                    {
                       hideProcessingOverlay();
                          if(response.status == 'SUCCESS')
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
                                      }

                                    });
                              }
                              else
                              {                
                                swal('Error',response.description,'error');
                              }  
                    }  
                 }); // end of ajax

            }//is confirm box
          }) // end of swal confirm 



      }// if order    
    });

  function confirm_payment_refund(ref)
  {
      var order_no           = ref.attr('data-order_no');
      var order_payment_id   = ref.attr('data-order_payment_id');
      var order_total_amount = ref.attr('data-total_amount');
      var order_seller_id    = ref.attr('data-seller_id');
      var order_cardlastfour  = ref.attr('data-cardlastfour');
      var order_paymentgateway  = ref.attr('data-payment-gateway');


      if(order_no == null && order_no == undefined &&
         order_payment_id == null && order_payment_id == undefined &&
         order_total_amount == null && order_total_amount == undefined &&
         order_seller_id == null && order_seller_id == undefined)
      {
        return false;
      }

      swal({
          title: 'Do you really want to refund $'+order_total_amount+' amount for this order?',
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
            var token = '<?php echo e(csrf_token()); ?>';
            $.ajax({
                url: module_url_path+'/payment_refund', 
                type:"POST",
                data: {
                        _token: token,
                        order_no:order_no,
                        order_payment_id:order_payment_id,
                        order_total_amount:order_total_amount,
                        order_seller_id:order_seller_id,
                        order_cardlastfour:order_cardlastfour,
                        order_paymentgateway : order_paymentgateway
                      },             
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
                              }

                            });
                    }
                    else
                    {                
                        swal('Error',response.description,'error');
                    }  
                }  
             }); // ajax close

           }
         })
    
  }

</script>    


 

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <script>
    var j = jQuery.noConflict();
    j( function() {
        j( "#from" ).datepicker(

            { dateFormat: 'dd M yy' }
          );
    } );

     j( function() {
        j( "#to" ).datepicker(

            { dateFormat: 'dd M yy' }
          );
    } );


   function filterrecords(){

      var from = $("#from").val();
      var to = $("#to").val(); 
      if(from=="")
      {
        $("#from_err").html('Please select from date');
        $("#from_err").css('color','red');
        return false;
      }else{
        $("#from_err").html('');
      }
      if(to=="")
      {
        $("#to_err").html('Please select to date');
        $("#to_err").css('color','red');
        return false;
      }else{
        $("#to_err").html('');
      }
      if(from!="" && to!=""){
         var fromdate = moment(from).format('YYYY-MM-DD');
         var todate = moment(to).format('YYYY-MM-DD');

         if(fromdate>todate)
         {
          $("#from_err").html('From date should not be greater than to date');
          $("#from_err").css('color','red');
          return false;
         }



        return true;
      }else{
        return false;
      }
   }

   $(document).on('click','#exportbtn',function(){
      var from = $("#from").val();
      var to = $("#to").val(); 
      if(from && to)
      {
          var fromdate = moment(from).format('YYYY-MM-DD');
          var todate = moment(to).format('YYYY-MM-DD');
           if(fromdate>todate)
          {
            $("#from_err").html('From date should not be greater than to date');
            $("#from_err").css('color','red');
            return false;
          }else{
            window.location.href = module_url_path+'/export/'+from+'/'+to;
          }
       
      }
      else
      {
        filterrecords();
      }


      // if(from && to){
      //   window.location.href = module_url_path+'/export/'+from+'/'+to;
      // }else{
      //   filterrecords();
      // }
   });

     $(document).on('click','#exportbtncsv',function(){
      var from = $("#from").val();
      var to = $("#to").val(); 
      if(from && to)
      {
          var fromdate = moment(from).format('YYYY-MM-DD');
          var todate = moment(to).format('YYYY-MM-DD');
           if(fromdate>todate)
          {
            $("#from_err").html('From date should not be greater than to date');
            $("#from_err").css('color','red');
            return false;
          }else{
            window.location.href = module_url_path+'/exportcsv/'+from+'/'+to;
          }
       
      }
      else
      {
        filterrecords();
      }


      // if(from && to){
      //   window.location.href = module_url_path+'/export/'+from+'/'+to;
      // }else{
      //   filterrecords();
      // }
   });


</script>
 <script >
    
    function add_note_model(ref) {

      var order_note = $(ref).data('order_note');

      document.getElementById("order_note_show").innerHTML = order_note ? order_note : 'NA';

      $('#myModal').modal('show');
    } 

    function payment_pending_status()
  {
      swal({
          title:'Payment Processing',
          text: 'Payment for this order is still being processed. You will receive a notification as soon as the payment is settled',
         // type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            //window.location.reload();             
          }           
       });

      return false;
  }

  </script>


<?php $__env->stopSection(); ?>                    
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>