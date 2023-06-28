// $( document ).ready(function() {
// $('#cssmenu ul ul li:odd').addClass('odd');
// $('#cssmenu ul ul li:even').addClass('even');
// $('#cssmenu > ul > li > a').click(function() {
//   $('#cssmenu li').removeClass('active');
//   $(this).closest('li').addClass('active');	
//   var checkElement = $(this).next();
//   if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
//     $(this).closest('li').removeClass('active');
//     checkElement.slideUp('normal');
//   }
//   if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
//     $('#cssmenu ul ul:visible').slideUp('normal');
//     checkElement.slideDown('normal');
//   }
//   if($(this).closest('li').find('ul').children().length == 0) {
//     return true;
//   } else {
//     return false;	
//   }		
// });




 // $(document).click(function() {
 //        $('#cssmenu ul ul').hide();
 //    });

  $(function() {
    $('#cssmenu').on('click', 'a[href="#"]', function() {
        var submenu = $(this).next('ul');
        // $('#cssmenu ul').not(submenu).hide();
        submenu.parentsUntil('#cssmenu', 'ul').show().end().toggle();
        return false;
    });

    $('.has-sub').click(function() {
    if($(this).hasClass('active')) {    
      $(this).removeClass('active');
    } else {
      $(this).addClass('active');
    }
  });
  });

  

   // $('.has-sub').click(
   //  function()
   //  { 
   //      if($(this).hasClass('active'))
   //      {
   //        $('.active').removeClass('active');
   //      }
   //      else
   //      {
   //          $('.active').removeClass('active');
   //          $(this).addClass('active');
   //      }
   //      return false;
   //  });