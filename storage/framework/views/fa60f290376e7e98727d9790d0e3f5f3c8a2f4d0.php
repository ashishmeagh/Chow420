                
<?php $__env->startSection('main_content'); ?>
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">Manage <?php echo e(isset($module_title) ? $module_title : ''); ?></h4>
      </div>
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
   </div>
   <!-- BEGIN Main Content -->
   <div class="col-sm-12"> 
      <div class="white-box">
         <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         <?php echo Form::open([ 'url' => $module_url_path.'/multi_action',
         'method'=>'POST',
         'enctype' =>'multipart/form-data',   
         'class'=>'form-horizontal', 
         'id'=>'frm_manage'  
         ]); ?>

         <?php echo e(csrf_field()); ?> 
         <div class="pull-right">            
          
         
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
         </div>
         <br/>
         <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                  
                     
                    <th>Sr.No</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Buyer Name</th>
                    <th>Dispensary Name</th>
                    <th>Unit Price($)</th>
                    <th>Admin Confirmation Note</th>
                    <th>Reported Issue Note</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>                
              </thead>
              <tbody>
              </tbody>
            </table>
         </div>
         <?php echo Form::close(); ?>

      </div>
   </div>
</div>



<!------------------------------------confirmation note model------------------------------------->

<div class="modal fade" id="confirmation_model" tabindex="-1" role="dialog" aria-labelledby="SConfirmationModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <form id="confirmation-form">

    <?php echo e(csrf_field()); ?>


 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ConfirmationModalLabel" align="center">Confirmation Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body admin-modal-new">
          <div class="title-imgd">
            
             <label>Add Note</label>
             <textarea rows="5" name="note" id="note" class="form-control" data-parsley-required-message="Please enter note" data-parsley-required="true" placeholder="Enter note"></textarea>

          </div> 

          <input type="hidden" id="type" name="type" value="">
          <input type="hidden" name="enc_id" id="enc_id" value="">  
    
      <div class="clearfix"></div>

      <button type="button" class="btn btn-info" id="btn_note_add">Add</button>
    

    </div>
  </div>
  </form>
</div>
</div>

<!-- -------------------------------------------------------------------------------------------------------->

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





<!-- END Main Content -->
<script type="text/javascript">


   var module_url_path = "<?php echo e($module_url_path); ?>";
   
   var base_url = "<?php echo e(url('/')); ?>";

 
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

          
          d['column_filter[q_product_name]']     = $("input[name='q_product_name']").val()
          d['column_filter[q_brand]']            = $("input[name='q_brand']").val()
          d['column_filter[q_seller_name]']      = $("input[name='q_seller_name']").val()
          d['column_filter[q_buyer_name]']       = $("input[name='q_buyer_name']").val()
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
     
      {data: 'buyer_name', "orderable": false, "searchable":false}, 
       
      {data: 'business_name', "orderable": false, "searchable":false}, 

      {data: 'unit_price', "orderable": false, "searchable":false},  

      {data: 'admin_note', "orderable": false, "searchable":false},

      {data: 'buyer_note', "orderable": false, "searchable":false},

     

      {data: 'status', "orderable": false, "searchable":false},  
   
      {
         render : function(data, type, row, meta) 
         {
           return row.build_action_btn;
         },
         "orderable": false, "searchable":false
      }]

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


  $('#table_module').on('draw.dt',function(event)
  {
   var oTable = $('#table_module').dataTable();
   var recordLength = oTable.fnGetData().length;
   $('#record_count').html(recordLength);
 
  });

  /*search box*/
  $("#table_module").find("thead").append(`<tr>
                    <td></td>
                     <td><input type="text" id="q_product_name" name="q_product_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                    <td><input type="text" id="q_brand" name="q_brand" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                    <td><input type="text" id="q_buyer_name" name="q_buyer_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

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
  

 function reject(ref)
 {
    
    $("#confirmation_model").modal('show');

    $('#type').val($(ref).attr('data-type'));
    $('#enc_id').val($(ref).attr('data-enc-id'));

 
 }
 

function approve(ref)
{
    
    $("#confirmation_model").modal('show');

    $('#type').val($(ref).attr('data-type'));
    $('#enc_id').val($(ref).attr('data-enc-id'));

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
   



  //this function for approve of reject the request

  $('#btn_note_add').click(function()
  {
      var csrf_token = $("input[name=_token]").val(); 
  
      if($('#confirmation-form').parsley().validate()==false) return;

      //formdata = new FormData($('#confirmation-form')[0]);


      $.ajax({
                  
          url: module_url_path+'/request_confirmation',
          data: new FormData($('#confirmation-form')[0]),
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
          beforeSend: function() {
            showProcessingOverlay();
          },
          success:function(data)
          {
             hideProcessingOverlay(); 
             
              if('success' == data.status)
              {
                $("#confirmation_model").modal('hide');
               
                $('#confirmation-form')[0].reset();

                  swal({
                         title: 'Success',
                         text: data.description,
                         type: data.status,
                         confirmButtonText: "OK",
                         closeOnConfirm: false
                      },
                     function(isConfirm,tmp)
                     {
                         if(isConfirm==true)
                         {
                            location.reload();
                            
                         }
                     });
              }
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
          }
          
      });  

  /*    $.ajax({
                  
          url: module_url_path+'/request_confirmation',
          data:formdata,
          method:'POST',
          dataType:'json',
          beforeSend: function() {
            showProcessingOverlay();
          },
          success:function(data)
          {
            hideProcessingOverlay(); 

            if('success' == data.status)
            {
                $("#confirmation_model").modal('hide');
               
                $('#confirmation-form')[0].reset();

                  swal({
                         title: 'Success',
                         text: data.description,
                         type: data.status,
                         confirmButtonText: "OK",
                         closeOnConfirm: false
                      },
                     function(isConfirm,tmp)
                     {
                         if(isConfirm==true)
                         {
                            location.reload();
                            
                         }
                     });
            }
            else
            {
              swal('Alert!',data.description,data.status);
            }

          }
          
        }); */  

});



</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>