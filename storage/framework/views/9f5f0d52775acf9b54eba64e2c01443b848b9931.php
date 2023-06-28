                
<?php $__env->startSection('main_content'); ?>
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title"><?php echo e(isset($module_title) ? $module_title : ''); ?></h4>
      </div>
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
                     <th>User Name</th>
                     <th>Container</th>
                     <th>Title</th>
                   
                    <th>Type</th>
                     <th>Status</th>
                     <th>Is Featured</th>                     
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
         
          d['column_filter[q_container]']   = $("input[name='q_container']").val()
          d['column_filter[q_user_name]']   = $("input[name='q_user_name']").val()
          d['column_filter[q_title]']       = $("input[name='q_title']").val()
          d['column_filter[q_status]']      = $("select[name='q_status']").val()
          d['column_filter[q_featured]']    = $("select[name='q_featured']").val()

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

      {data: 'user_name', "orderable": false, "searchable":false},   
      {data: 'container', "orderable": false, "searchable":false},    
      {data: 'title', "orderable": false, "searchable":false}, 
      // {data: 'description', "orderable": false, "searchable":false}, 
            {data: 'post_type', "orderable": false, "searchable":false}, 
   
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
         return row.build_featured_btn;
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

      $("input.toggleSwitchFeatured").change(function(){
          featured_post($(this));
       });   

    

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td><input type="text" id="q_user_name" name="q_user_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                    <td><input type="text" id="q_container" name="q_container" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                    <td></td>

                    <td></td>

                    <td>
                       <select class="search-block-new-table column_filter small-form-control" name="q_status" id="q_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                        </select>
                    </td> 
                               
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
    var delete_param = "Forum post";
    confirm_action(ref,event,'Do you really want to delete this forum post?',delete_param);
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
          title: 'Do you really want to update status of this post?',
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
                     sweetAlert('Success','Status update successfully','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','activate');
                     sweetAlert('Success','Status update successfully','success');
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
               }
             }); 
          } 
          else
          {
            $(data).trigger('click');
          }
       })
   } 
  



  function featured_post(data)
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
              $(ref).attr('data-type','unfeatured');
              swal('Success!','Status changed to featured.','success');

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','featured');
              swal('Success!','Status changed to unfeatured.','success');

            }            
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
          }  
        }
      });  
  } 
      
</script>




<div class="modal fade" id="post_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="id" id="id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Post Description</h5>
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


<!-----------------------post title modal-------------------------->

<div class="modal fade" id="title_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog mypostmain-dialog" role="document">
    <input type="hidden" name="id" id="id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Post Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="descriptionmdl-body" id="viewdetails">
          <span id="showtitle"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
       <!-- <div class="modal-footer">      
        <button type="button" class="btn btn-default" id="closebtn" data-dismiss="modal" aria-label="Close">Close</button>
       </div> -->
    </div>
   </div> 
</div>
<!-----------------end post title modal--------------------------------->




<script type="text/javascript">
  
  $(document).on('click','.readmorebtn',function(){
     var desc = $(this).attr('description');
     if(desc)
     {
        $("#post_sectionmodal").modal('show');
        $("#showmessage").html(desc);
     }

  });


 
  $(document).on('click','.readmorebtnoftitle',function(){
     var title = $(this).attr('settitle');
     if(title)
     {
        $("#title_sectionmodal").modal('show');
        $("#showtitle").html(title);
     }

  }); 



</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>