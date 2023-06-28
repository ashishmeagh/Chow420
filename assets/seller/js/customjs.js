
$(".flipdashboard").click(function(){
 $(".search-home-header").toggleClass("actv");
});

  // Footer Start
      $( function() {
    $( ".footer_heading" ).on( "click", function() {
      $(this).toggleClass( "active");
         $(this).next( ".menu_name" ).slideToggle("slow");
         $(this).parent(".abc").siblings().find(".menu_name").slideUp();   
        $(this).parent(".abc").siblings().children().removeClass("active");
    });    
  } );
      // Footer End
 // Header sticky Start
 $(document).ready(function() {
    var stickyNavTop = false;
    if( $('.header').offset() != undefined)
    {
      var stickyNavTop = $('.header').offset().top;
    }
        

    var stickyNav = function() {
        var scrollTop = $(window).scrollTop();

        if (scrollTop > stickyNavTop) {
            $('.header').addClass('sticky');
        } else {
            $('.header').removeClass('sticky');
        }
    };

    stickyNav();

    $(window).scroll(function() {
        stickyNav();
    });
  })
    // Header sticky End

  


      // Min Menu Start
        var doc_width = $(window).width();
    if (doc_width < 1180) {
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            $("body").css({
                "margin-left": "250px",
                "overflow-x": "hidden",
                "transition": "margin-left .5s",
                "position": "fixed"
            });
            $("#main").addClass("overlay");
        }
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            $("body").css({
                "margin-left": "0px",
                "transition": "margin-left .5s",
                "position": "relative"
            });
            $("#main").removeClass("overlay");
        }
    }
    $(".min-menu > li > .drop-block").click(function() {
        if (false == $(this).next().hasClass('menu-active')) {
            $('.sub-menu > ul').removeClass('menu-active');
        }
        $(this).next().toggleClass('menu-active');
        return false;
    });
    $("body").click(function() {
        $('.sub-menu > ul').removeClass('menu-active');
    });

        // Min Menu End
/*price range slider*/
         $(function() {
           if($("#slider-price-range").length > 0) 
           {
              $("#slider-price-range").slider({
               range: true,
               min: 0,
               max: 500,
               values: [75, 300],
               slide: function(event, ui) {
                   $("#slider_price_range_txt").html("<span class='slider_price_min'>$ " + ui.values[0] + "</span>  <span class='slider_price_max'>$ " + ui.values[1] + " </span>");
               }
           });
           $("#slider_price_range_txt").html("<span class='slider_price_min'> $ " + $("#slider-price-range").slider("values", 0) + "</span>  <span class='slider_price_max'>$ " + $("#slider-price-range").slider("values", 1) + "</span>"); 
           }
           
         });  
         

   $('.nav-toggle').click(function(e) {
      e.preventDefault();
      $("html").toggleClass("openNav");
      $(".nav-toggle").toggleClass("active");

    });


    $(document).ready(function() {
    var brand = document.getElementById('logo-id');
    brand.className = 'attachment_upload';
    brand.onchange = function() {
        document.getElementById('fakeUploadLogo').value = this.value.substring(12);
    };

    // Source: http://stackoverflow.com/a/4459419/6396981
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('.img-preview').attr('src', e.target.result);
              
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#logo-id").change(function() {
        readURL(this);
    });
       
});


function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "menu-after-logins") {
    x.className += " responsive";
  } else {
    x.className = "menu-after-logins";
  }
}




