
//show the full page loader
function showProcessingOverlay() {
	$.LoadingOverlay("show",{
      // text            : 'Please Wait...',
      // textResizeFactor: 0.3,
      // textColor		  : '#8d62d5',
      imageColor      : "#873dc8"      
   });
}

//hide the loader
function hideProcessingOverlay() {
	$.LoadingOverlay("hide",{     
   });
}	

//show single element loader
function showSingleElementLoader() {
	$(".loaderElement").LoadingOverlay("show",{      
      imageColor      : "#873dc8"      
   });
}

//hide single element laoder
function hideSingleElementLoader() {
	$(".loaderElement").LoadingOverlay("hide", true);
}


