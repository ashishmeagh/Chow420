<?php $__env->startSection('main_content'); ?>

<style type="text/css">
  .no-notification-there {
    text-align: center;
}
.notification-no {
    font-size: 30px;
    width: 100px;
    height: 100px;
    text-align: center;
    line-height: 100px;
    background-color: #f1f1f1;
    border-radius: 50%;
    margin: 0 auto 20px;
    color: #c3c3c3;
}
.no-notification-there p{
  font-size: 18px;color: #6b6b6b;
}
</style>

<div class="my-profile-pgnm">
  Notifications
  <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Notifications</li>
    </ul>

</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">

  <div class="notifications-main-pg">
    
<?php if(isset($notification_arr) && count($notification_arr) > 0): ?>
      <?php $__currentLoopData = $notification_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="notification-list-buyer">
         
          <div class="notification-list-buyer-content"><?php echo isset($notification['message'])?$notification['message']:'NA'; ?></div>
          <a href="javascript:void(0)" class="close-notification" data-id="<?php echo e(isset($notification['id'])?base64_encode($notification['id']):0); ?>" onclick="DeleteNotification($(this));"></a>
        </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <?php else: ?>
         <div class="no-notification-there">
            <div class="notification-no"><i class="fa fa-bell-slash-o"></i></div>
         <p>No Any Notification Avaliable</p>
       </div>

  <?php endif; ?>  
  <div class="pagination-chow pagination-center mg-space aftermargn-none">
    <?php if($arr_pagination != ""): ?>
      <?php echo e($arr_pagination->render()); ?> 
      <?php endif; ?>
  </div>
  <div class="clearfix"></div>
  </div>
 



</div>

<script type="text/javascript">

function DeleteNotification(ref)
{


  swal({
      title: 'Do you really want to delete this notification?',
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


            var id         = $(ref).attr('data-id');
            var csrf_token = "<?php echo e(csrf_token()); ?>";

            $.ajax({
                      url: SITE_URL+'/buyer/notifications/delete',
                      type:"POST",
                      data: {id:id,_token:csrf_token},             
                      dataType:'json',
                      beforeSend: function(){            
                      },
                      success:function(response)
                      {
                        if(response.status == 'SUCCESS')
                        { 
                          swal({
                                  title: 'Success',
                                  text: response.description,
                                  type: 'success',
                                  confirmButtonText: "OK",
                                  closeOnConfirm: true
                               },
                              function(isConfirm,tmp)
                              {                       
                                if(isConfirm==true)
                                {
                                    window.location.reload();
                                    $(this).removeClass('active');
                                }

                              });
                        }
                        else
                        {                
                          swal('Error',response.description,'error');
                        }  
                      }  
              }); 
      }
    })

}
  
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('buyer.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>