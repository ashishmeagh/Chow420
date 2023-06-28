                  

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
                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
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
                             <a href="<?php echo e(url($module_url_path.'/create')); ?>" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add Country"><i class="fa fa-plus"></i> </a> 
                              <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 

                              <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 

                             

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
                                                <input class="checkboxInputAll" id="checkbox0" type="checkbox">
                                                <label for="checkbox0">  </label>
                                              </div>
                                          </th>    
                                           <th>Country Name</th>                                            
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
      'url':'<?php echo e($module_url_path.'/get_countries'); ?>',
      'data': function(d)
        {
          
          d['column_filter[q_name]']  = $("input[name='q_name']").val()
          d['column_filter[q_status]'] = $("select[name='q_status']").val()

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


      {data: 'name', "orderable": true, "searchable":true},
      

      

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
                    <td><input type="text" name="q_name" placeholder="Search" class="search-block-new-table column_filter form-control" />
                    </td>        
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
    confirm_action(ref,event,'Do you really want to delete this record?',delete_param);
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
             // $(ref).attr('data-type','deactivate');
              $(ref).attr('data-type','deactivate_country');
              swal('Success','Status activated successfully','success');

            }else
            {
              $(ref)[0].checked = false;  
            //  $(ref).attr('data-type','activate');
              $(ref).attr('data-type','activate_country');
              swal('Success','Status deactivated successfully','success');
            }

            
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
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
              $(ref).attr('data-type','deactivate_country');

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','activate_country');
            }

            swal('Success','Status changed successfully','success');
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
          }  
        }
      });  
  } 

// $("input.checkboxInputAll").click(function()
// {
//     if($('#checked_record_all').is(':checked'))
//     {
//        $("input.checkboxInput").prop('checked',true);
//     }
//     else
//     {
//       $("input.checkboxInput").prop('checked',false);
//     }
// });




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



</script>


<?php $__env->stopSection(); ?>                    



<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>