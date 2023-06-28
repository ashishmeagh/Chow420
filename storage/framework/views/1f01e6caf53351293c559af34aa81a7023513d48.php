                    

    <?php $__env->startSection('main_content'); ?>
    <!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    
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
                         <form class="form-horizontal" id="frm_manage" method="POST" action="<?php echo e(url($module_url_path.'/multi_action')); ?>">
                          <?php echo e(csrf_field()); ?>

                         <div class=" pull-right" >
                             <a href="<?php echo e(url($module_url_path.'/create')); ?>" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add More"><i class="fa fa-plus"></i> </a> 
                             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
                             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 

                             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 

                             <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a> 
                           </div>
                           <br>
                           <br>
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
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Status</th>
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

  /*function show_details(url)
  { 
      window.location.href = url;
  }*/ 

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
          d['column_filter[q_title]']  = $("input[name='q_title']").val()
          d['column_filter[q_status]']        = $("select[name='q_status']").val()

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
      {data: 'image', "orderable": true, "searchable":false},

      {data: 'title', "orderable": true, "searchable":false},
     
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

       $("input.toggleSwitchFeatured").change(function(){
          featured_category($(this));
       });   

    }); 



    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td></td>
                    <td><input type="text" name="q_title" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                    
                    <td>
                       <select class="search-block-new-table column_filter form-control" name="q_status" id="q_status" onchange="filterData();">
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
    var delete_param = "Forum container";
    confirm_action(ref,event,'Are you sure want to delete this record?',delete_param);
  }
  
  function statusChange(data)
  {


     swal( {
          title: 'Do you really want to update status of this forum container?',
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
                        if(response.status=='SUCCESS')
                        {
                          if(response.data=='ACTIVE')
                          {
                            $(ref)[0].checked = true;  
                            $(ref).attr('data-type','deactivate');
                            swal('Success!','Status activated successfully','success');

                          }else
                          {
                            $(ref)[0].checked = false;  
                            $(ref).attr('data-type','activate');
                            swal('Success!','Status deactivated successfully.','success');
                          }

                          
                        }
                        else
                        {
                          sweetAlert('Error','Something went wrong!','error');
                        }  
                      }
                    });  
               }else{
                 $(data).trigger('click');
               }
          })     

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

</script> 

<?php $__env->stopSection(); ?>                    



<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>