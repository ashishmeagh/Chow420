     <!-- /.container-fluid -->
            <footer class="footer text-center"> {{config('app.project.footer_link_year')}} &copy; {{config('app.project.footer_link')}}, Inc.  </footer>
            
<!-- jQuery -->

    <script src="{{url('/')}}/assets/admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{url('/')}}/assets/admin/bootstrap/dist/js/tether.min.js"></script>
    <script src="{{url('/')}}/assets/admin/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="{{url('/')}}/assets/admin/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{url('/')}}/assets/admin/js/waves.js"></script>
    <!--Counter js -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/raphael/raphael-min.js"></script>
    {{-- <script src="{{url('/')}}/assets/admin/plugins/bower_components/morrisjs/morris.js"></script> --}}
    <!-- Custom Theme JavaScript -->
    <script src="{{url('/')}}/assets/admin/js/custom.min.js"></script>
    <script src="{{url('/')}}/assets/admin/js/dashboard1.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/toast-master/js/jquery.toast.js"></script>

    <!-- data table js-->
    <script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>
    
    <script type="text/javascript" src="{{ url('/') }}/assets/admin/js/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/admin/js/jquery-validation/dist/additional-methods.js"></script>
    <script src="{{ url('/') }}/assets/admin/js/validation.js"></script>

    <script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert_msg.js"></script>
    <script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert.js"></script>

    <script type="text/javascript" src="{{url('/')}}/assets/admin/js/Parsley/dist/parsley.min.js"></script>
    

    <script src="{{url('/')}}/assets/admin/plugins/bower_components/dropify/dist/js/dropify.min.js"></script>

    <!--Switechery js-->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/switchery/dist/switchery.min.js"></script>
    
      <!-- loader js -->
    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>

    <!-- Tinymce editor js-->
   {{--  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> --}}



    


    @if(Sentinel::check()==true)
        <script type="text/javascript">
          //get notification count
            setInterval(function()
            { 
                $.ajax({
                    url:'{{url('/')}}'+'/notifications/getNotifications',            
                    dataType:'json',
                    success:function(response)
                    { 
                        if(typeof (response) == 'object')
                        {
                            if(response.status=='SUCCESS')
                            {             
                                $('#admin_notify').html(response.notifications_arr_cnt); 
                            }
                            else
                            {
                                $('#admin_notify').html(0); 
                            }
                        }   
                    }  
                });
            },5000);
        </script>
    @endif

    <script>
    var SITE_URL  = "{{ url('/')}}";
    $(document).ready(function() {


     $("#user_id").change(function()
     {
        var drop_shipper_name  =  $("#drop_shipper_name").val();
        var drop_shipper_email =  $("#drop_shipper_email").val();
        var drop_shipper_product_price =  $("#drop_shipper_product_price").val();
        if(drop_shipper_name!="")
        {
           $("#drop_shipper_name").val('');
           $("#drop_shipper_email").val('');
           $("#drop_shipper_product_price").val('');
           $("#drop_shipper_email").removeAttr('readonly');  
           $("#drop_shipper_product_price").removeAttr('readonly');
        }
     });  

       $('#drop_shipper_name').keyup(function(){ 
        var query     = $(this).val();
        var seller_id = $("#user_id").val(); 
        if(query != '')
        {
           var _token = $('input[name="_token"]').val();
             $.ajax({
              url:SITE_URL+'/book/product/autosuggest_dropshipper',
              method:"POST",
              data:{query:query, _token:_token,seller_id:seller_id},
              success:function(data){
                if(data.indexOf("Not Found") > -1)
                {
                  $("#drop_shipper_email").removeAttr('readonly');  
                  $("#drop_shipper_product_price").removeAttr('readonly');
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
              url:SITE_URL+'/book/product/chk_dropshipper_email_duplication',
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
        var seller_id = $("#user_id").val(); 
        
          var _token = $('input[name="_token"]').val();
           $.ajax({
            url:SITE_URL+'/book/product/get_dropshipper_details',
            method:"POST",
            data:{query:query, _token:_token,seller_id:seller_id},
            dataType:'json',
            success:function(data){
             $('#drop_shipper_email').val(data[0].email);
             $('#drop_shipper_email').attr('readonly','true');
             $('#drop_shipper_product_price').val(Math.round(data[0].product_price).toFixed(2));
             $('#drop_shipper_name').focus();
            }
           });
        $('#DropShipperList').fadeOut();  
    }); 

     $(document).on('mouseleave', '#DropShipperList', function(){  
        $('#DropShipperList').fadeOut();
    });  

        // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });
        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        });

    });
    </script>
    
    <script type="text/javascript">
          $(document).ready(function(){
            $('#validation-form').validate();
            $('#validation-form').parsley();
            
          });

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
         new Switchery($(this)[0], $(this).data());
        });

        $("input.toggleSwitch").change(function(){
        statusChange($(this));
        });
        

        function readNotifications(ref)
        {
          var csrf_token = $("input[name=_token]").val();
          var notification_id  = $(ref).attr('attr_notification_id');
          var url  = $(ref).attr('attr_href');
          
          $.ajax({
                  headers: {'X-CSRF-TOKEN': csrf_token},
                  url:"{{url('/')}}/notifications/read_notification",
                  type:'GET',
                  data:{notification_id},
                  dataType:'json',
                  success:function(response)
                  {
                    console.log(response);
                    window.location.href = url; 
                  }
                });   
        }


        /* setInterval(function(){ 
            $.ajax({
              url:'{{url('/')}}'+'/check_queueemails/send_queueemails',            
              data:{
                checkstat:1,              
              },
              dataType:'json',
              success:function(response)
              { 
                  
              }  
            });
          }, 60000);  // 1 min  60000
        */

    </script> 

     <!--Style Switcher -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!--Style Switcher -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!--Parsley Js-->
    <script type="text/javascript" src="{{url('/')}}/assets/admin/js/Parsley/dist/parsley.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/js/moment/moment.js"></script>
     <script type="text/javascript">
    $(document).ready(function(){
        $('#lightgallery').lightGallery();        
        $('#lightgallery2').lightGallery();
    });
    </script>
    <script type="text/javascript"  src="{{url('/')}}/assets/front/js/lightgallery-all.min.js"></script>


    @yield('extra_js')
</body>

</html>