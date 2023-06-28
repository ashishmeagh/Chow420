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
      <li>Reported Issues</li>
    </ul>
</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">
    <div class="order-main-dvs table-order space-none-order-div">

     
      <div class="table-responsive">
            <table class="table seller-table" id="table_module">
              <thead>
                  <tr>
                      <th>Sr.No</th>
                      <th>Name</th>
                      <th>Brand</th>
                      <th>Dispensary Name</th>
                      <th>Unit Price($)</th>
                      <th>Admin Confirmation Note</th>
                      <th>Reported Issue Note</th>
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


<div class="modal fade" id="note_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog mypostmain-dialog" role="document">
  
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="noteModalLabel" align="center">Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="descriptionmdl-body" id="viewdetails">
          <span id="shownote"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
      
    </div>
   </div> 
</div>


<script type="text/javascript"> 
var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";  </script>


<script type="text/javascript">
    var table_module = false;

console.log(module_url_path+'/get_request');

    $(document).ready(function()
    {
      
      table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
      bFilter: false,
    
      ajax: {
      'url': module_url_path+'/get_request',
      'data': function(d)
       {        
          d['column_filter[q_product_name]']     = $("input[name='q_product_name']").val()
          d['column_filter[q_brand]']            = $("input[name='q_brand']").val()
          d['column_filter[q_seller_name]']      = $("input[name='q_seller_name']").val()
          d['column_filter[q_price]']            = $("input[name='q_price']").val()
       }
      },

      columns: [
      {
          render(data, type, row, meta)
          { 
            return '';
          },
           
      },                        
     
      {data: 'product_name', "orderable": false, "searchable":false}, 

      {data: 'brand_name', "orderable": false, "searchable":false}, 
       
      {data: 'business_name', "orderable": false, "searchable":false}, 

      {data: 'unit_price', "orderable": false, "searchable":false},  

      {data: 'admin_note', "orderable": false, "searchable":false},

      {data: 'buyer_note', "orderable": false, "searchable":false},

      {data: 'status', "orderable": false, "searchable":false}  
   
     
      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData();
  });

  /*this code for serial number with pagination*/
  table_module.on( 'draw.dt', function ()
  {
      var PageInfo = $('#table_module').DataTable().page.info();

      table_module.column(0, { page: 'current' }).nodes().each( function (cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;

      });
  });




   $("#table_module").find("thead").append(`<tr>          
                   <td></td>
                     
                    <td><input type="text" id="q_product_name" name="q_product_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                    <td><input type="text" id="q_brand" name="q_brand" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                   

                    <td><input type="text" id="q_seller_name" name="q_seller_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>


                    <td><input type="text" id="q_price" name="q_price" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

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


function showNote(ref)
{
    var note = $(ref).attr('note');
    
    if(note)
    {
          $("#note_sectionmodal").modal('show');
          $("#shownote").html(note);
    }

} 
   


</script>

<style>
  .dataTables_empty{
    text-align: center;
  }
</style>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>