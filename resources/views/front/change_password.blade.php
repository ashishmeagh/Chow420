@extends('front.layout.master')
@section('main_content')
<div class="min-heghts-change">
<div class="white-box-login signup-main ">
      <div id="status_msg"></div>
      <form id="frm-change-pwd">
        {{ csrf_field() }}
      <div class="row">       
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="form-int">
              <input type="password" placeholder="Enter Current Password" data-parsley-required="true" 
               data-parsley-remote="{{ url('/does_old_password_exist') }}"
               data-parsley-remote-options='{ "type": "POST", "dataType": "jsonp", "data": { "_token": "{{ csrf_token() }}" } }'
            data-parsley-remote-message="Please enter valid current password"
              name="current_password" id="current_password"  />
                
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
           <div class="form-int">
              <input type="password" placeholder="Enter New Password" data-parsley-required="true" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters" data-parsley-minlength="8" name="new_password" id="new_password"/>
          </div>
        </div>
       
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="form-int">
              <input type="password" placeholder="Confirm Password "  data-parsley-equalto="#new_password" data-parsley-error-message="Confirm password should be same as new password" data-parsley-required="true" name="cnfm_new_password" id="cnfm_new_password" />
            </div>
        </div>
       
      </div>
       <div class="clearfix"></div>
        <div class="text-center">
          <button type="button" class="button-login small-button" id="btn-change-pwd">Change password</button>
        </div>
  </div>
</div>
<script type="text/javascript">
  $('#btn-change-pwd').click(function(){

      if($('#frm-change-pwd').parsley().validate()==false) return;

      var form_data = $('#frm-change-pwd').serialize();
      $.ajax({
        url:SITE_URL+'/change_password',
        data:form_data,
        method:'POST',        
        dataType:'json',
        beforeSend : function()
        {      
            showProcessingOverlay();      
            $('#btn-change-pwd').prop('disabled',true);
            $('#btn-change-pwd').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn-change-pwd').prop('disabled',false);
          $('#btn-change-pwd').html('Change password');

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