  $(document).ready(function() {
            $('.side-category h4').click(function() {
                $(this).next('.sub-menu').slideToggle('1000');
                $(this).find('.arrow i').toggleClass('fa-plus fa-minus')
            });
        });


        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            $("body").css({
                "margin-left": "250px",
                "overflow-x": "hidden",
                "transition": "margin-left .1s",
                "position": "fixed"
            });
            $("#main").addClass("overlay");


        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            $("body").css({
                "margin-left": "0px",
                "transition": "margin-left .1s",
                "position": "relative"
            });
            $("#main").removeClass("overlay");
        }
/*header script end*/



//    <!--form fild script start here-->

        $(document).ready(function () {
            $('input').each(function () {

                $(this).on('focus', function () {
                    $(this).parent('.form-group').addClass('active');
                });

                $(this).on('blur', function () {
                    if ($(this).val().length == 0) {
                        $(this).parent('.form-group').removeClass('active');
                    }
                });

                if ($(this).val() != '') $(this).parent('.form-group').addClass('active');

            });
        });

//    <!--form fild script end here-->