

         <div class="copyright-block">
            <i class="fa fa-copyright"></i> <?php echo e(config('app.project.footer_link_year')); ?>   <a href="<?php echo e(url('/')); ?>"><?php echo e(config('app.project.footer_link')); ?></a>, Inc.  
       
    </div>
  

<!-- After Login Footer End -->


<script>
 // Header AfterLogin sticky Start
 $(document).ready(function() {
        var stickyNavTop = $('.header-afterlogin').offset().top;

        var stickyNav = function() {
            var scrollTop = $(window).scrollTop();

            if (scrollTop > stickyNavTop) {
                $('.header-afterlogin').addClass('sticky');
            } else {
                $('.header-afterlogin').removeClass('sticky');
            }
        };
        stickyNav();

        $(window).scroll(function() {
            stickyNav();
        });
    })
    // Header AfterLogin sticky End
</script>
    
<?php if(Sentinel::check()==true): ?>
    <script type="text/javascript">
      //get notification count
        setInterval(function()
        { 
            $.ajax({
                url:'<?php echo e(url('/')); ?>'+'/notifications/getNotifications',            
                dataType:'json',
                success:function(response)
                { 
                    if(typeof (response) == 'object')
                    {
                        if(response.status=='SUCCESS')
                        {             
                            $('#buyer_notify').html(response.notifications_arr_cnt); 
                        }
                        else
                        {
                            $('#buyer_notify').html(0); 
                        }
                    }   
                }  
            });
        },5000);
    </script>
<?php endif; ?>

<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.min.js"></script>

<!-- data table js-->
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/buyer/js/customjs.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/buyer/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/js/moment/moment.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157965708-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-157965708-1');
</script>
 -->
 <!---Google analytics-footer------>
<?php
if(isset($site_setting_arr['pixelcode2']) && !empty($site_setting_arr['pixelcode2'])) {
  echo $site_setting_arr['pixelcode2'];
}
?>



</body>
</html>