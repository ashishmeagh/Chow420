                
<?php $__env->startSection('main_content'); ?>
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title"><?php echo e(isset($module_title) ? $module_title : ''); ?>  
         <?php if(isset($arr_data['product_name'])): ?> of <?php echo e($arr_data['product_name']); ?>  <?php endif; ?> </h4>
      </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">

            <?php
              $user = Sentinel::check();

              $productid = isset($product_id)?$product_id:'';
            ?>

            <?php if(isset($user) && $user->inRole('admin')): ?>
            <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
            <?php endif; ?>
            
            <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/product')); ?>">Products</a></li>
            <li class="active"><?php echo e(isset($module_title) ? $module_title : ''); ?></li>
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

           <a href="<?php echo e(url($module_url_path.'/addreview/'.base64_encode($productid))); ?>" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add Review"><i class="fa fa-plus"></i> </a> 

          <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e($module_url_path); ?>"><i class="fa fa-arrow-left"></i> Back</a>
           
         </div>
         <br/>
         <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <input type="hidden" name="product_id" id="product_id" value="<?php echo e($product_id); ?>">
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>                    
                     <th>Buyer Name</th>
                     <th>Rated On</th>
                     <th>Rating</th>
                     <th>Review</th>   
                     <th>Emoji</th>     
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



<div class="modal fade" id="review_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="id" id="id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewdetails">
          <span id="showmessage"></span>
          
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
       <div class="modal-footer">      
        <button type="button" class="btn btn-default" id="closebtn" data-dismiss="modal" aria-label="Close">Close</button>
       </div>
    </div>
   </div> 
</div>



<!-- END Main Content -->
<script type="text/javascript"> 
   var module_url_path         = "<?php echo e($module_url_path); ?>";
   var product_imageurl_path = "<?php echo e($product_imageurl_path); ?>";
   var base_url = "<?php echo e(url('/')); ?>";

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
      
      bFilter: false ,
      ajax: {
      'url':'<?php echo e($module_url_path.'/get_reviews/'.$product_id); ?>',
      'data': function(d)
        {
          d['column_filter[q_buyer_name]']     = $("input[name='q_buyer_name']").val()
         
        }
      },
      columns: [     
      {data: 'buyer_name', "orderable": false, "searchable":false},
      {data: 'rated_on', "orderable": false, "searchable":false}, 
      {data: 'rating', "orderable": false, "searchable":false},    
      {data: 'review', "orderable": false, "searchable":false},   
      {data: 'emoji', "orderable": false, "searchable":false},    
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
    
    $("input.toggleSwitch").change(function(){
       statusChange($(this));
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

     $('input.toggleApprove').change(function(){

         if($(this).is(":checked"))
         {
           var status  = 1;
         }
         else
         {
          var status  = 0;
         }
         
         var product_id = $(this).attr('data-enc_id');  
        
         $.ajax({
             method   : 'GET',
             dataType : 'JSON',
             data     : {status:status,product_id:product_id},
             url      : module_url_path+'/approvedisapprove',
             success  : function(response)
             {                         
              if(typeof response == 'object' && response.status == 'SUCCESS')
              {
                swal('Done', response.message, 'success');
              }
              else
              {
                swal('Oops...', response.message, 'error');
              }               
             }
          });
      });     
    

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
        

    $(document).on('click','.showreview',function(){

     var review = $(this).attr('reviews');
     if(review)
     {
        $("#review_sectionmodal").modal('show');
        $("#showmessage").html(review);
     }

  });


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>