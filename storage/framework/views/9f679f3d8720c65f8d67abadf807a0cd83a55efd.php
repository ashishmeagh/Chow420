                  

  <?php $__env->startSection('main_content'); ?>
  <!-- BEGIN Page Title -->
  <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    
<!-- Page Content --> 
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> 
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
        <!-- /.col-lg-12 -->
    </div>
    
    <div class="row">
      <div class="col-sm-12">
        <div class="white-box">
          <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <form class="form-horizontal" id="frm_manage" method="POST" action="<?php echo e(url($module_url_path.'/multi_action')); ?>">
            <?php echo e(csrf_field()); ?>

            <div class=" pull-right" >
            
              <a href="<?php echo e(url($module_url_path.'/create')); ?>" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add More"><i class="fa fa-plus"></i> </a> 
            
              <a data-toggle="modal"  href="#usersSharesBulkImportModal" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Import from excel"><i class="fa fa-file-excel-o"></i> </a> 
           
              <a href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Activate"><i class="ti-unlock"></i> </a> 

              <a href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Deactivate"><i class="ti-lock"></i> </a> 

              <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 

              <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
            </div>
             
            <div class="table-responsive">
              <input type="hidden" name="multi_action" value="" />
              <table id="table_module" class="table table-striped">
                <thead>
                  <tr>
                    <th>
                      <div class="checkbox checkbox-success">
                        <input type="checkbox" name="checked_record" id="checked_record_all" class="checkboxInputAll" type="checkbox"/><label for="checked_record_all"></label>
                      </div>
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Shares Owned</th>
                    <th>Price Per Share</th>
                    <th>Percent Change</th>
                    <th>Share Value</th>
                    <th>Is Active</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END Main Content -->



<form action="post" id="users-shares-bulk-upload-form" enctype="multipart/form-data">
  <div class="modal fade" id="usersSharesBulkImportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog maxwdths" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" align="center">Investor Tracker
 Bulk Import</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="age_body">
          <div id="viewagedetails">
            <div class="row">
              <div class="col-md-12">
                <label for="users_shares_excel_file">Only xlsx format is allowed</label>
                <input type="file" name="users_shares_excel_file" id="users_shares_excel_file" class="dropify"  data-allowed-file-extensions="xlsx" data-errors-position="outside" data-parsley-errors-container="#upload_error_msg" data-parsley-required="true" data-parsley-required-message="Please select the excel file to import" data-parsley-fileextension='xlsx' required />
              </div>
              <div id="upload_error_msg"></div>
            </div>   
          </div>  <!------row div end here------------->
        </div><!------body div end here------------->
        <div class="modal-footer">
          <?php echo e(csrf_field()); ?>


          <a href="<?php echo e($module_url_path); ?>/export_excel" class="btn btn-warning" id="download-excel-template-btn" >Download Template</a> 
          <button type="button" class="btn btn-success " id="import-btn" >Import</button> 
        </div>
      </div>
    </div>
  </div>
</form>


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
          d['column_filter[q_status]']  = $("select[name='q_status']").val()
          d['column_filter[q_full_name]']  = $("input[name='q_full_name']").val()
          d['column_filter[q_email]']  = $("input[name='q_email']").val()

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
      {data: 'full_name', "orderable": true, "searchable":false},      
      {data: 'email', "orderable": true, "searchable":false},      
      {data: 'shares_owned', "orderable": true, "searchable":false},      
      {data: 'price_per_share', "orderable": true, "searchable":false},      
      {data: 'percent_change', "orderable": true, "searchable":false},      
      {data: 'share_value', "orderable": true, "searchable":false},      
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

    $("#table_module").find("thead")
                      .append(`<tr>
                                <td></td>
                                <td><input type="text" name="q_full_name" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                                <td><input type="text" name="q_email" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                                <td></td>
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


    $('#import-btn').on( 'click', function()
    {
      if($('#users-shares-bulk-upload-form').parsley().validate()==false) return;
      
      var formdata = new FormData($('#users-shares-bulk-upload-form')[0]);
      $.ajax({
                  
          url: module_url_path+'/bulk_upload',
          data: formdata,
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
                $('#users-shares-bulk-upload-form')[0].reset();

                  swal({
                         title: data.status,
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

    });

  });

  function filterData()
  {
    table_module.draw();
  }

  function confirm_delete(ref,event)
  {
    var delete_param = " Users Shares";
    confirm_action(ref,event,'Do you really want to delete this record?',delete_param);
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
          title: 'Do you really want to update status of this record?',
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
                     swal('success','Status updated successfully','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','activate');
                     swal('success','Status updated successfully','success');
                     location.reload(true);
                   }
                 }
                 else
                 {
                   swal('Error','Something went wrong!','error');
                 }  
               }
             }); 
          }
          else{            
            $(data).trigger('click');            
          } 
       })
   } 
</script>

<?php $__env->stopSection(); ?>                    



<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>