
{{-- <div class="new-wrapper"> --}}
         <div class="copyright-block">
            <i class="fa fa-copyright"></i> {{ config('app.project.footer_link_year') }}   <a href="{{url('/')}}">{{ config('app.project.footer_link') }}</a>, Inc.  
       {{--  <ul class="social-footer">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
        </ul> --}}
    </div>
  
{{-- </div> --}}
<!-- After Login Footer End -->
{{-- 

    <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/buyer/js/bootstrap.min.js"></script> --}}

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
@endif

<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/common/Parsley/dist/parsley.min.js"></script>

<!-- data table js-->
<script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/buyer/js/customjs.js"></script>

<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/buyer/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/js/moment/moment.js"></script>
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
@php
if(isset($site_setting_arr['pixelcode2']) && !empty($site_setting_arr['pixelcode2'])) {
  echo $site_setting_arr['pixelcode2'];
}
@endphp

{{-- <script type="application/javascript" async
src="https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=R29ZVf"></script> --}}

</body>
</html>