                    

    <?php $__env->startSection('main_content'); ?>
    <!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">


 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <?php 
     if(isset($seller_id) && !empty($seller_id))
      $sellerid = $seller_id;
     else
      $sellerid = '';
 ?>
    
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
                                          <th>Date</th>   
                                          <th>Membership</th>
                                          <th>Type</th>
                                          <th>Amount</th>
                                          <th>Product Limit</th>
                                          <th>Status</th>
                                          <th>Cancel Reason</th>
                                          <th>Payment Status</th>
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


<!------------start modal-of cancel reason---------------->



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

  <script type="text/javascript">
    $(document).on('click','.readmorecancelbtn',function(){

     var reason = $(this).attr('cancel_reason');       
     if(reason)
     {
        $("#membership_cancel_sectionmodal").modal('show');
        $("#showmessage").html(reason);
     }
   });
  </script>
<!------------end modal-of cancel reason---------------->



<script type="text/javascript">

    var module_url_path         = "<?php echo e($module_url_path); ?>";
    var sellerid         = "<?php echo e($sellerid); ?>";

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
      'url': module_url_path+'/get_payment_history/'+sellerid,
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
      {data: 'created_at', "orderable": false, "searchable":false},
  
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
      {data: 'cancel_reason', "orderable": false, "searchable":false},

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
      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData();
  });
  /*search box*/
  $("#table_module").find("thead").append(`<tr>     
          <td><input type="text" name="q_created_at" id="datepicker" placeholder="Search" class="search-block-new-table column_filter form-control datepicker" onchange="filterData();"/>
          </td>
         <td><input type="text" name="q_membership_name" placeholder="Search" class="search-block-new-table column_filter form-control" />
         </td>             
         <td>
           <div class="select-style">
             <select class="search-block-new-table column_filter small-form-control" name="q_membership" id="q_membership" onchange="filterData();">
                  <option value="">All</option>
                  <option value="1">Free</option>
                  <option value="2">Paid</option>
              </select>
            </div>
         </td>   
         <td><input type="text" name="q_membership_amount" id="q_membership_amount" placeholder="Search" class="search-block-new-table column_filter form-control" />
         </td>     
        
         <td><input type="text" name="q_product_limit" placeholder="Search" class="search-block-new-table column_filter small-form-control" />
         </td>           
          <td width="12%">
            <div class="select-style">
             <select class="search-block-new-table column_filter small-form-control" name="q_membership_status" id="q_membership_status" onchange="filterData();">
                  <option value="">All</option>
                  <option value="0">Cancelled</option>
                  <option value="1">Active</option>
             </select>
            </div>
          </td>     
          <td></td>
          <td>
               <div class="select-style">
                   <select class="search-block-new-table column_filter small-form-control" name="q_payment_status" id="q_payment_status" onchange="filterData();">
                        <option value="">All</option>
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