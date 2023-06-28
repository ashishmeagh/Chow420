@extends('front.layout.master',['page_title'=>'Forgot-Password'])
@section('main_content')
<div class="white-box-login">
	<div id="status_msg"></div>
	<form id="frm-forgot-password">
		{{csrf_field()}}
	  <div class="title-main-login">
	      <div class="login-title">Can't sign in?</div>
	      <div class="login-sub-title">Forget your password?</div>
	  </div>
	  <div class="form-int">
	      <input type="text" placeholder="Email" data-parsley-required="true" id="email" name="email" />
	  </div>
	  <button type="button" class="button-login" id="btn-forgot-password">Submit</button>
 	</form>
</div>
<script type="text/javascript">
	$('#btn-forgot-password').click(function(){

      if($('#frm-forgot-password').parsley().validate()==false) return;

      var form_data = $('#frm-forgot-password').serialize();
      $.ajax({
        url:SITE_URL+'/forgot_password',
        data:form_data,
        method:'POST',        
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-forgot-password').prop('disabled',true);
          $('#btn-forgot-password').html('Please Wait... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn-forgot-password').prop('disabled',false);
          $('#btn-forgot-password').html('Submit');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg').html(success_HTML);
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                
                $('#status_msg').html(error_HTML);
            }
          }
        }
      });
  });
</script>
@endsection
