                
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
         <!-- /.col-lg-12 -->
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div class="white-box">
               <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
               <?php echo Form::open([ 'url' => $module_url_path.'/multi_action',
               'method'=>'POST',
               'class'=>'form-horizontal', 
               'id'=>'frm_manage' 
               ]); ?>      
               <div class="pull-right">
                  <!-- <a href="<?php echo e(url($module_url_path.'/create')); ?>" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add CMS"><i class="fa fa-plus"></i> </a> -->
                  <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
                  <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 
                  <!-- <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a>  -->
                  <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a>
               </div>
               <br/>
               <br>

               <div class="table-responsive">
                 <input type="hidden" name="multi_action" value="" />
                 <table class="table table-advance"  id="table_module" >
                    <thead>
                       <tr>
                          <th>
                             <div class="checkbox checkbox-success">
                                <input class="checkboxInputAll" value="delete" id="checkbox0" type="checkbox">
                                <label for="checkbox0">  </label>
                             </div>
                          </th>
                          <th>Page Name</th>
                          <!-- <th>Page Title</th> -->
                          <th>Status</th>
                          <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                       <?php $__currentLoopData = $arr_static_page; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <tr>
                          <td>
                             <div class="checkbox checkbox-success"><input type="checkbox" name="checked_record[]" value="<?php echo e(base64_encode($page->id)); ?>" id="checkbox'<?php echo e($page->id); ?>'" class="case checkboxInput"/><label for="checkbox'<?php echo e($page->id); ?>'"> </label></div>
                          </td>
                          <td> <?php echo e($page->page_title); ?> </td> 
                          <!-- <td> <?php echo e($page->page_slug); ?> </td> -->
                          <td>
                             <?php if($page->is_active=='1'): ?>
                             <input type="checkbox" checked data-size="small"  data-enc_id="'<?php echo e(base64_encode($page->id)); ?>'"  id="status_'<?php echo e($page->id); ?>'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />
                             <?php else: ?>
                             <input type="checkbox" data-size="small" data-enc_id="'<?php echo e(base64_encode($page->id)); ?>'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />
                             <?php endif; ?>
                          </td>
                          <td> 
                             <a class="eye-actn" href="<?php echo e($module_url_path.'/edit/'.base64_encode($page->id)); ?>"  title="Edit">
                             Edit
                             </a>  
                             <!-- <a class="btn btn-circle btn-danger btn-outline show-tooltip" href="<?php echo e($module_url_path.'/delete/'.base64_encode($page->id)); ?>" 
                                onclick="confirm_action(this,event,'Are you sure want to delete this record?','CMS Page');"  title="Delete">
                             <i class="ti-trash" ></i>
                             </a>    -->
                          </td>
                       </tr>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                 </table>
               </div>
            </div>
            <?php echo Form::close(); ?>

         </div>
      </div>
   </div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "<?php echo e($module_url_path); ?>";
    $(document).ready(function() {
       $('#table_module').DataTable( {
           "aoColumns": [
           { "bSortable": false },
           { "bSortable": true },
           { "bSortable": true },
           { "bSortable": true },
           { "bSortable": false }
           ]
       });
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
                        sweetAlert('Success','Status activated successfully','success');
               
                     }else
                     {
                        $(ref)[0].checked = false;  
                        $(ref).attr('data-type','activate');
                        sweetAlert('Success','Status deactivated successfully','success');
                     }

                     
                     }
                     else
                     {
                     sweetAlert('Error','Something went wrong!','error');
                     }  
                  }
               }); 
            }
            else{            
               $(data).trigger('click');            
            } 
         }) 
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


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>