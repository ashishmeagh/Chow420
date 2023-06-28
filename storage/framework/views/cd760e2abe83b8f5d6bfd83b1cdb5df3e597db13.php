

         <div class="copyright-block">
            <i class="fa fa-copyright"></i> <?php echo e(config('app.project.footer_link_year')); ?>   <a href="<?php echo e(url('/')); ?>"><?php echo e(config('app.project.footer_link')); ?></a>, Inc.   
       
    </div>





  


<script>  
 // Header AfterLogin sticky Start
 $(document).ready(function() {
 
        var SITE_URL  = "<?php echo e(url('/')); ?>";
 
        var csrf_token = $("input[name=_token]").val(); 
        
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


         $('#drop_shipper_name').keyup(function(){ 
        var query = $(this).val();
       
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
           $.ajax({
            url:SITE_URL+'/seller/product/autosuggest_dropshipper',
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
              if(data.indexOf("Not Found") > -1)
              {
                $("#drop_shipper_email").removeAttr('readonly');  
                $("#drop_shipper_product_price").removeAttr('readonly');
                $('#drop_shipper_product_price').removeClass('readonly_div');
                $('#drop_shipper_email').removeClass('readonly_div');
                $("#drop_shipper_email").val('');
                $("#drop_shipper_product_price").val('');
              }

              $('#DropShipperList').fadeIn();  
              $('#DropShipperList').html(data);
            }
           });
        }

        else
        {
            $("#drop_shipper_email").removeAttr('readonly');  
            $("#drop_shipper_product_price").removeAttr('readonly');
            $('#drop_shipper_product_price').removeClass('readonly_div');
            $('#drop_shipper_email').removeClass('readonly_div');
            $("#drop_shipper_email").val('');
            $("#drop_shipper_product_price").val('');
        }
    });  


       $('#drop_shipper_email').on('keyup keypress blur change', function(e) {

          if($(this).attr("readonly") != "readonly")
          {  

          var query  = $(this).val();
        
          var _token = $('input[name="_token"]').val();
           $.ajax({
            url:SITE_URL+'/seller/product/chk_dropshipper_email_duplication',
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
             if(data=='exists')
             { 
              $('#err_drop_shipper_email').html('Email id already exists.');
              $('#err_drop_shipper_email').css('color','red');
              $("#drop_shipper_email").val('');
              return false;
             }
             else
             {
               $('#err_drop_shipper_email').html('');
             }
            }
           });
        } 
   });

        $(document).on('click', '#DropShipperList .liclick', function(){  
        $('#drop_shipper_name').val($(this).text()); 
        var query = $(this).text();
        
          var _token = $('input[name="_token"]').val();
           $.ajax({
            url:SITE_URL+'/seller/product/get_dropshipper_details',
            method:"POST",
            data:{query:query, _token:_token},
            dataType:'json',
            success:function(data){
             $('#drop_shipper_email').val(data[0].email);
             $('#drop_shipper_email').attr('readonly','true');
             $('#drop_shipper_product_price').val(Math.round(data[0].product_price).toFixed(2));
             // $('#drop_shipper_product_price').attr('readonly','true');
             $('#drop_shipper_name').focus();
            // $('#drop_shipper_product_price').addClass('readonly_div');
             $('#drop_shipper_email').addClass('readonly_div');
            }
           });
        $('#DropShipperList').fadeOut();  
    }); 

     $(document).on('mouseleave', '#DropShipperList', function(){  
        $('#DropShipperList').fadeOut();
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
                            $('#seller_notify').html(response.notifications_arr_cnt); 
                        }
                        else
                        {
                            $('#seller_notify').html(0); 
                        }
                    }   
                }  
            });
        },5000);
    </script>
<?php endif; ?>

    <script type="text/javascript" language="javascript" 
    src="<?php echo e(url('/')); ?>/assets/seller/js/customjs.js"></script>

    <script type="text/javascript" language="javascript" 
    src="<?php echo e(url('/')); ?>/assets/seller/js/bootstrap.min.js"></script> 
    <script type="text/javascript" language="javascript" 
    src="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.min.js"></script>
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert_msg.js"></script>
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.js"></script>

    <!-- data table js-->
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/js/moment/moment.js"></script>
     <!--Switechery js-->
    <script src="<?php echo e(url('/')); ?>/assets/admin/plugins/bower_components/switchery/dist/switchery.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
   <!--  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157965708-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-157965708-1');
    </script> -->

    <!---Google analytics-footer------>
<?php
if(isset($site_setting_arr['pixelcode2']) && !empty($site_setting_arr['pixelcode2'])) {
  echo $site_setting_arr['pixelcode2'];
}
?>




</body>

</html>