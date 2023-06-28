                
<?php $__env->startSection('main_content'); ?>
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">Manage <?php echo e(isset($module_title) ? $module_title : ''); ?></h4>
      </div>
      <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
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
          
            <a href="<?php echo e(url($module_url_path.'/create')); ?>" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add Template"><i class="fa fa-plus"></i> </a> 

             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Activate"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Block"><i class="ti-lock"></i> </a> 

             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 
                

            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
         </div>
         <br/>
         <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                    <th>
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" name="checked_record" id="checked_record_all" class="checkboxInputAll" type="checkbox"/><label for="checked_record_all"></label>
                        </div>
                    </th>
                     <th>Name</th>
                     <th>Subject</th>                   
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


<div class="modal fade" id="reject_product_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="hidden_product_id" id="hidden_product_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Reject Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason &nbsp;</div>
          <textarea id="reason" name="reason" class="form-control" rows="5"></textarea>
          <span id="reason_err"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectprodbtn" id="rejectprodbtn">Reject</button>
      </div>
    </div>
  </div> 
</div>





<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "<?php echo e($module_url_path); ?>";
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
      'url':'<?php echo e($module_url_path.'/get_records'); ?>',
      'data': function(d)
        {
          d['column_filter[q_newsletter_name]']     = $("input[name='q_newsletter_name']").val()
          d['column_filter[q_newsletter_subject]']   = $("input[name='q_newsletter_subject']").val()
           d['column_filter[q_status]']           = $("select[name='q_status']").val()
      
        }
      },
      columns: [
       {
       
        render : function(data, type, row, meta) 
        {
        return '<div class="checkbox checkbox-success"><input type="checkbox" '+
        ' name="checked_record[]" '+  
        ' value="'+row.enc_id+'" id="checkbox'+row.id+'" class="case checkboxInput"/><label for="checkbox'+row.id+'">  </label></div>';
        },
        "orderable": false,
        "searchable":false
       },

      
      {data: 'newsletter_name', "orderable": false, "searchable":false}, 

      {data: 'newsletter_subject', "orderable": false, "searchable":false}, 
     
       {
       render : function(data, type, row, meta) 
       {
         return row.build_status_btn;
       },
       "orderable": false, "searchable":false
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
           var status_app_disapp = 'Do you really want to approve status of this product?';
         }
         else
         {
           var status  = 0;
           var status_app_disapp = 'Do you really want to disapprove status of this product?';
         }
         
          var product_id = $(this).attr('data-enc_id');  
                  

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                     // star product approve , disapprove
                     //var product_id = $(this).attr('data-enc_id');  

                    if(status==0)
                    {
                        $("#reject_product_sectionmodal").modal('show');
                        $("#hidden_product_id").val(product_id);

                    }else{ 

                   
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
                   // end product approve,disapprove  
                 }//else

               }
             });


      });     
    

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td><input type="text" id="q_newsletter_name" name="q_newsletter_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td><input type="text" id="q_newsletter_subject" name="q_newsletter_subject" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                  
                     <td>
                       <select class="search-block-new-table column_filter small-form-control" name="q_status" id="q_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                        </select>
                    </td> 
                   
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
  
 function confirm_delete(ref,event)
  {
    var delete_param = "Newsletter";
    confirm_action(ref,event,'Do you really want to delete this Newsletter?',delete_param);
  }

  $(function(){
    $("input.checkboxInputAll").click(function(){
       var is_checked = $("input.checkboxInputAll").is(":checked");
      if(is_checked)
      {
         $("input.checkboxInput").prop('checked',true);
      }
      else
      {
        $("input.checkboxInput").prop('checked',false);
      }
     }); 
  });

  $("input.toggleSwitch").change(function(){
       statusChange($(this));
  });

  function statusChange(data)
   {

     swal({
          title: 'Do you really want to update status of this newsletter template?',
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
           var ref     = data;  
           var type    = data.attr('data-type');
           var enc_id  = data.attr('data-enc_id');
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
                    //sweetAlert('Error','Something went wrong!','error');
                         if(response.msg)
                         {
                                
                                 swal({
                                  title: response.msg,
                                  type: "warning",
                                  confirmButtonColor: "#b833cc",
                                  confirmButtonText: "Ok",
                                  closeOnConfirm: false
                                },
                                function(isConfirm,tmp)
                                {
                                  if(isConfirm==true)
                                  {  window.location.reload();
                                  }
                                })

                        }
                 }  
               }
             }); 
          } 
          else
          {
            $(data).trigger('click');
          }
       })
   } 
  
      
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>