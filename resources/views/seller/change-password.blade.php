@extends('seller.layout.master')
@section('main_content')
<style>
  .parsley-errors-list{position: static;}
</style>
<div class="my-profile-pgnm">{{isset($page_title)?$page_title:''}}
   <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Change Password</li>
  </ul>
</div>
<div class="new-wrapper">

<div class="main-my-profile">
   <div class="innermain-my-profile">

   <div class="profile-img-block changepasswords">
         <img src="{{url('/')}}/assets/buyer/images/lock--change-password.png" alt="" />                     
    </div> 
    <div id="status_msg"></div>

       <form id="frm-change-password">
        {{ csrf_field()}}
       <div class="row">
           <div class="col-md-12">
                 <div class="form-group">
                    <label for="">Old Password</label>
                    <input type="password" id="current_password" name="current_password" class="input-text" placeholder="Old Password" data-parsley-required="true" data-parsley-required-message="Enter current password" data-parsley-remote="{{ url('/seller/does_old_password_exist') }}"
               data-parsley-remote-options='{ "type": "POST", "dataType": "jsonp", "data": { "_token": "{{ csrf_token() }}" } }'
            data-parsley-remote-message="Please enter valid old password">
                </div>
            </div>
            <div class="col-md-12">
                 <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="input-text" placeholder="New Password" data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-required-message="Enter new password" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Password field must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters" data-parsley-minlength="8">
                </div>
            </div>
            <div class="col-md-12">
                 <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" name="cnfm_new_password" id="cnfm_new_password" class="input-text" placeholder="Confirm Password" data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-required-message="Enter confirm password" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters" data-parsley-minlength="8" data-parsley-equalto="#new_password" data-parsley-equalto-message="Confirm password should be match with new password">
                </div>
            </div>
            <div class="col-md-12">
                <div class="button-list-dts">
                    <button class="butn-def" id="btn-change-password">Save</button>
                    {{-- <a href="#" class="butn-def cancelbtnss">Cancel</a> --}}
                </div>
            </div>
       </div>
     </form>
   </div>
</div>
</div>



  <script type="text/javascript">

    $('#btn-change-password').click(function(){

      //alert('clicked');
      
      /*Check all validation is true*/
      if($('#frm-change-password').parsley().validate()==false) return;

      $.ajax({
        url:SITE_URL+'/seller/update_password',
        data:new FormData($('#frm-change-password')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-change-password').prop('disabled',true);
          $('#btn-change-password').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {

          hideProcessingOverlay();
          $('#btn-change-password').prop('disabled',false);
          $('#btn-change-password').html('SAVE');

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
                    window.location.reload();
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

