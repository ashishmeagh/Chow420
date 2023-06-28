tinymce.init({
       selector: 'textarea',
       relative_urls: false,
       remove_script_host:false,
       convert_urls:false,
       plugins: [
         'link',
         'fullscreen',
         'contextmenu '
       ],
       toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
       content_css: [
         // '//www.tinymce.com/css/codepen.min.css'
       ]
     });
