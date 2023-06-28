                    

    <?php $__env->startSection('main_content'); ?>
    <!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    
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
                         <form class="form-horizontal" id="frm_manage" method="POST" >
                          <?php echo e(csrf_field()); ?>

                           <br>
                           <br>
                            <div class="table-responsive">
                            <input type="hidden" name="multi_action" value="" />
                                <table id="table_module" class="table table-striped">
                                    <thead>
                                      <tr>
                                      
                                      </tr>
                                        <tr>
                                            <th>From User</th>
                                            <th>Notification</th>
                                            <th>Date & Time</th>
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

    var module_url_path         = "<?php echo e($module_url_path); ?>";

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
      searching: false,
      bFilter: false ,
      ajax: {
      'url':'<?php echo e($module_url_path.'/get_all_notification'); ?>',
      'data': function(d)
        {
          d['column_filter[q_user_name]']  = $("input[name='q_user_name']").val()
        }
      },
      columns: [
  
      {data: 'user_name', "orderable": false, "searchable":false},
      {data: 'message', "orderable": false, "searchable":false},
      {data: 'created_at', "orderable": true, "searchable":false},
      {data: 'build_action_btn', "orderable": false, "searchable":false}
     
      ]
    });


    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    
          <td><input type="text" name="q_user_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
          <td></td>
          <td></td>
          <td></td>
          

      </tr>`);
 


       $('input.column_filter').on( 'keyup click', function () 
        {
             filterData();
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

  }); 

  function filterData()
  {
    table_module.draw();
  }

  function confirm_delete(ref,event)
  {
    var delete_param = "Notification";
    confirm_action(ref,event,'Do you really want to delete this notification?',delete_param);
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

<?php $__env->stopSection(); ?>                    



<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>