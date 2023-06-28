                
<?php $__env->startSection('main_content'); ?>
    <!-- BEGIN Page Title -->
<link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">

<style>
  table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after{display: none !important;}
</style>    
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
        <?php echo Form::open([ 'url' => $module_url_path.'/multi_action',
        'method'=>'POST',
        'enctype' =>'multipart/form-data',   
        'class'=>'form-horizontal', 
        'id'=>'frm_manage' 
        ]); ?> 
        <?php echo e(csrf_field()); ?>

        
        <!-- <div class="pull-right">
          
          <a href="<?php echo e(url($module_url_path.'/create')); ?>" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add More"><i class="fa fa-plus"></i> </a> 
          
          <a href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
          <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 
         <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 
         <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a>
          </div> -->
        
        <br/>
        <br>
        <div class="clearfix">
        </div>
        <div class="table-responsive" style="border:0">
          <input type="hidden" name="multi_action" value="" />
          <table class="table table-advance"  id="table_module" >
            <thead>
              <tr>
                <th>Dispensary Name</th> 
                <th>Dispensary Request Amount($)</th> 
                <th>Dispensary Previous Uncleared Amount($)</th> 
                <th>Dispensary Received Amount($)</th> 
                <th>Referal Amount($)</th> 
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
        <div>   
        </div>
        <?php echo Form::close(); ?>

      </div>
    </div>
  </div>
  <!-- END Main Content -->
  <script type="text/javascript">
  var module_url_path = '<?php echo e($module_url_path); ?>';

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
          d['column_filter[q_seller_name]']  = $("input[name='q_seller_name']").val()
          d['column_filter[q_request_amt]']  = $("input[name='q_request_amt']").val()
          d['column_filter[q_receive_amt]']  = $("input[name='q_receive_amt']").val()
          d['column_filter[q_status]']       = $("select[name='q_status']").val()
        }
      },
      columns: [
      
      {data: 'business_name', "orderable": false, "searchable":false},

      {
        render : function(data, type, row, meta) 
        {
          return row.request_amt;
        },
        "orderable": false, "searchable":false
      },
      {
        render : function(data, type, row, meta) 
        {
          return row.previous_uncleared_balance;
        },
        "orderable": false, "searchable":false
      },
      {
        render : function(data, type, row, meta) 
        {
          return row.received_amt;
        },
        "orderable": false, "searchable":false
      },
      {
        render : function(data, type, row, meta) 
        {
          return row.referal_amount;
        },
        "orderable": false, "searchable":false
      },
      {
        render : function(data, type, row, meta) 
        {
          return row.build_status_label;
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

    // $('#table_module').on('draw.dt',function(event)
    // {
    //   var oTable = $('#table_module').dataTable();
    //   var recordLength = oTable.fnGetData().length;
    //   $('#record_count').html(recordLength);

    //   var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    //     $('.js-switch').each(function() {
    //        new Switchery($(this)[0], $(this).data());
    //     });   

    // });



    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td><input type="text" name="q_seller_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                    <td><input type="text" name="q_request_amt" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td></td>
                    <td><input type="text" name="q_receive_amt" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td></td>
                    <td>
                       <select class="search-block-new-table column_filter form-control" name="q_status" id="q_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="0">Pending</option>
                        <option value="1">Completed</option>
                        <option value="2">Cancelled</option>
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
   
  </script>
  <!--page specific plugin scripts-->
  <?php $__env->stopSection(); ?>                    

<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>