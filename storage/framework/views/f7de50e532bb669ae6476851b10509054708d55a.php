                  

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
                         <form class="form-horizontal" id="frm_manage" method="POST" action="<?php echo e(url($module_url_path.'/multi_action')); ?>">
                          <?php echo e(csrf_field()); ?>


                          <div class="pull-left"> 
           
                            <div class="form-group row">
                              <label for="categories" class="col-sm-6 col-form-label">Category</label>

                                <div class="col-sm-6 col-lg-6 controls">
                                  <select name="main_category" id="main_category" class="form-control column_filter" onchange="filterData()">
                                      <option value="" selected>All</option>

                                       <?php if(isset($arr_category) && sizeof($arr_category) >0): ?>
                                        <?php $__currentLoopData = $arr_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                          <option 
                                              value="<?php echo e(isset($category['id']) && $category['id'] !='' ?$category['id'] :''); ?>"><?php echo e(isset($category['product_type']) && $category['product_type'] !='' ? $category['product_type'] : ''); ?>


                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                           No Records Found
                                       <?php endif; ?>
                                    </select>
                                  </div>
                              </div>
                            </div>


                         <div class=" pull-right" >
                             <a href="<?php echo e(url($module_url_path.'/create')); ?>" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add More"><i class="fa fa-plus"></i> </a> 
                             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
                             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 

                            

                             <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
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
                                            <th>Category</th>
                                            <th>Sub Category</th> 
                                            <th>Unit</th> 
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
          /*send category id */
          d['category_id'] = $("#main_category").val();

          d['column_filter[q_category]']  = $("input[name='q_category']").val()
          d['column_filter[q_sec_level_category]'] = $("input[name='q_sec_level_category']").val()
          d['column_filter[q_is_visible_status]']  = $("select[name='q_is_visible_status']").val()
          d['column_filter[q_status]']    = $("select[name='q_status']").val()
          d['column_filter[q_unit]']      = $("input[name='q_unit']").val()

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

      {data: 'product_type', "orderable": true, "searchable":false},
      
      {data: 'name', "orderable": true, "searchable":false},

      {data: 'unit', "orderable": true, "searchable":false},

      

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


      $("input.is_visible").change(function(){
          
          statusIsVisible($(this));
       });  

       

    });



    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td><input type="text" id="q_category" name="q_category" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                   <td><input type="text" name="q_sec_level_category" id="q_sec_level_category" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                   <td><input type="text" name="q_unit" id="q_unit" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                   
                    <td>
                       <select class="search-block-new-table column_filter form-control" name="q_status" id="q_status" onchange="filterData();">
                        <option value="">Select Status</option>
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
    var delete_param = "Second Level Category";
    confirm_action(ref,event,'Are you sure want  to delete this record?',delete_param);
  }

 
  function statusChange(data)
  {
    var ref = data; 
    var type = ref.attr('data-type');
    var enc_id = ref.attr('data-enc_id');
    var id = ref.attr('data-id');

   
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
              swal('Success','Status activated successfully , you can activate the product of this category','success');

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','activate');
              swal('Success','Status deactivated successfully','success');
            }

          }
          else
          {
           // sweetAlert('Error','Something went wrong!','error');
             /* if(response.msg){
              sweetAlert('Error',response.msg,'error');
              setTimeout(function(){
                   window.location.reload();
              },2000);
              }*/

              swal({
                    title: response.msg,
                    type: "warning",
                    confirmButtonColor: "#873dc8",
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
      });  
  } 


  /*is visible*/
  function statusIsVisible(data)
  {
    var ref = data; 
    var type = ref.attr('data-type');
    var enc_id = ref.attr('data-enc_id');
    var id = ref.attr('data-id');

   
      $.ajax({
        url:module_url_path+'/'+type,
        type:'GET',
        data:{id:enc_id},
        dataType:'json',
        success: function(response)
        {
          if(response.status=='SUCCESS')
          {
            if(response.data=='VISIBLE')
            {
              $(ref)[0].checked = true;  
              $(ref).attr('data-type','deactivate');

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','activate');
            }

            swal('Success','Status change successfully','success');
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
          }  
        }
      });  
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