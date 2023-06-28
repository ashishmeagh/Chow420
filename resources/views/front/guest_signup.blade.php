@extends('front.layout.master')
@section('main_content') 

<style>
  @media (max-width: 650px){
  .headerchnagesmobile .logo-block.mobileviewlogo{
        width: 55vw;
  }
}
@media (max-width: 520px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 53vw;
}
}
@media (max-width: 450px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 45%;
}
}
@media (max-width: 414px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 35%;
}
}
@media (max-width: 350px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 30%;
}
.main-logo {
    width: 70px;
    margin-top: 11px !important;
}
}
</style>

<div class="guestsignup-main">
<div class="row">
 <div class="col-md-4 col-lg-offset-1 col-md-offset-1">
   <form id="login-form" onsubmit="return false;">
      {{ csrf_field() }}
        <div class="titleh3" id="exampleModalLabel">Returning customer</div>       
        
       <div id="status_msg_login"></div>  


       <input type="hidden" name="guest_signup_buyer" id="guest_signup_buyer" value="1">  
   
        <div class="mainbody-mdls">  
          <div class="mainbody-mdls-fd">
            <div class="row">            

              <div class="col-md-12">
                <div class="form-group">
                <label>Email <span>*</span></label>             
                <input type="email" id="email-input" class="form-control" name="email" placeholder="Enter email address" data-parsley-required="true" data-parsley-required-message="Email is required">
                {{-- <span id="address_msg_err"></span> --}}
                </div>
              </div> 

              <div class="col-md-12">
                <div class="form-group">
                <label>Password <span>*</span></label>             
                <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" data-parsley-required="true" data-parsley-required-message="Password is required">
                {{-- <span id="address_msg_err"></span> --}}
                </div>
              </div>
           
          
            </div>
             <div class="clearfix"></div>
             <div class="sre-product">       
              <img src="{{ url('/') }}/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" alt="Loader"/>
              <input type="submit" class="shdebtns" id="button_login" value="CONTINUE TO CHECKOUT">
              </div>
              <div class="forgotpasswordlink">
                <a href="#" data-toggle="modal" onclick="return showmodal()">Forgot your password?</a>
              </div>
          </div>

        </div>
      
        
   </form>
 </div>

  <div class="col-md-4 col-lg-offset-2 col-md-offset-2 new-customer-box">
    <div class="titleh3 spacemobileview50">New customer</div>   
    <form method="POST" id="signup-form">
       {{csrf_field()}} 
       <label>Email Address</label>
       <div class="flex-list-left-bn">
        
           
               <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" data-parsley-required="true" data-parsley-type="email" data-parsley-type-message="Please enter valid email address" data-parsley-required-message="Please enter email address" value="{{$email or ''}}" data-parsley-required-message="Please enter email" />
                <div id="user_exist_error_message"></div>
          
          
       </div>

       <label>Password</label>
       <div class="flex-list-left-bn error-large">
        
           <input type="password" name="password" class="form-control" placeholder="Password" data-parsley-errors-container=".passworderror"  data-parsley-trigger="blur" data-parsley-whitespace="trim" data-parsley-required="true" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}" data-parsley-pattern-message="Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character" data-parsley-minlength="8" data-parsley-maxlength="16" name="password" id="password" data-parsley-required-message="Please enter password" />
          <div class="passworderror" id="password_error_message"></div>
          
          
       </div>


        {{--  <label>Temporary password will be sent to your email</label> --}}
       <div class="flex-list-righ-ct">
         <a href="#" class="btn btn-default" id="btn-sign-up">REGISTER & CONTINUE</a>
       </div>
   </form>
 </div>
</div>
</div>




<!-- Forgot password Modal -->
<div class="modal" id="ForgotPasswordModal">
  <div class="modal-dialog forgot-small-modal"> 
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Forgot your password?</h4>
        <button type="button" class="close" id="closemodal" data-dismiss="modal" onclick="return closemodal();">
            <img src="{{url('/')}}/assets/front/images/closbtns.png" alt="Forgot Password" />
        </button>
      </div>
      <div id="forgot_status_msg"></div>
      <!-- Modal body -->
      <form id="frm-forgot-password" onsubmit="return false;">
      {{csrf_field()}}
        <div class="modal-body">
         <div class="form-group forgotpass-error">
              <label for="">Email Address <span class="asteric_mark">*</span></label>
              <input type="email" name="email" id="email" class="input-text" placeholder="Enter your email address" data-parsley-required="true" data-parsley-required-message="Please enter your email address" data-parsley-type-message="Email must be in a valid email format" data-parsley-errors-container="#wrong_email_error_div">
            <div id="wrong_email_error_div"></div>
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="butn-def" id="btn-forgot-password">Submit</button>
            
        </div>
      </form>
      
    </div>
  </div>
</div>

<!-------from here functions started to signup and login-------->


<script>

   function showmodal()
  {
    $("#forgot_status_msg").html('');
    $("#email").val('');
    $('#frm-forgot-password').parsley().destroy();

    $("#ForgotPasswordModal").modal('show');
  }
  function closemodal()
  {
    $("#email").val('');
    $('#frm-forgot-password').parsley().destroy();
  }
  
 $('#btn-sign-up').click(function(){

    if($('#signup-form').parsley().validate()==false) return;

        
        var form_data = $('#signup-form').serialize();      

        if($('#signup-form').parsley().isValid() == true )
        {
                     
          var email = $("#email").val();

          $.ajax({
            url:SITE_URL+'/process_signup_checkout',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            {
              showProcessingOverlay();
              $('#btn-login').prop('disabled',true);
              $('#btn-login').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
            
              hideProcessingOverlay();
              $('#btn-sign-up').prop('disabled',false);
              $('#btn-sign-up').html('REGISTER & CONTINUE');

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                   if(response.type=="loggedin"){
                        $("#signup-form")[0].reset();
                        $('#user_exist_error_message').html('');

                         
                         swal({
                              title: "",
                              type: "info",
                              text: "Account has been created, please check your email for account details. Click continue to complete order",
                              showCancelButton: true,
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "Continue",
                              cancelButtonText: "Cancel",
                              closeOnConfirm: false,
                              closeOnCancel: false
                            },
                            function(isConfirm) {
                              if (isConfirm) {
                               window.location.href=SITE_URL+"/checkout";
                              } else {
                                window.location.reload();
                              }
                            });


                   }//if type logged in
                    
                   
                 }
                else if(response.status="ERROR")
                {

                    if(response.password_msg!=""){
                        $('#password_error_message').css('color','red').html(response.password_msg);
                    }else{
                        $('#password_error_message').html('');
                    }   
                      
                    if(response.msg!=""){
                        $('#user_exist_error_message').css('color','red').html(response.msg);
                        setTimeout(function(){
                          $("#email").val('');
                          $('#user_exist_error_message').html('');  
                        },5000);
                    }else{
                        $('#user_exist_error_message').html('');    
                    }

                                    
                }//elseif                         

              }// end of if type object           
            }//end of success
          });
        }
  });//signup function end here



 //login function start here
  $('#button_login').click(function()
  {

      if($('#login-form').parsley().validate()==false) return;
        
      var form_data = $('#login-form').serialize();   

      if($('#login-form').parsley().isValid() == true )
      {         
         $.ajax({
            url:SITE_URL+'/process_login',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            { 
                showProcessingOverlay();
                $('#button_login').prop('disabled',true);
                $('#button_login').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {

              hideProcessingOverlay();
              $('#button_login').prop('disabled',false);
              $('#button_login').html('CONTINUE TO CHECKOUT');

               if(typeof response =='object')
               {

                  if(response.status && response.status=="SUCCESS")
                  {
                    $("#login-form")[0].reset();

                     var success_HTML = '';
                     success_HTML +='<div class="alert alert-success alert-dismissible">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>'+response.message+'</div>';

                     $('#status_msg_login').html(response.message);
                     $('#status_msg_login').css('color','green');

                     if(response.redirect_checkout=="redirect_checkout"){
                      window.location.href=SITE_URL+'/checkout';
                    }else{
                      window.location.href=SITE_URL;
                    }
                      
                       
                  }//if
                  else
                  {                      
                     
                      var error_HTML = '';   
                      if(response.message){
                         error_HTML+='<div class="alert alert-danger alert-dismissible">\
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>'+response.message+'</div>';
                         $('#status_msg_login').html(response.message);
                            $('#status_msg_login').css('color','red');

                     }// if err msg
                  }//else
               }
            }
         });
      }
  }); //end of login function




  // Forgot password
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

                      $('#forgot_status_msg').html(response.message);
                      $('#forgot_status_msg').css('color','green');
                      setTimeout(function(){
                        $('#ForgotPasswordModal').modal('hide');
                      },5000);
                      
              }
              else
              {                    
                  var error_HTML = '';   
                  error_HTML+='<div class="alert alert-danger alert-dismissible">\
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                      </button>'+response.message+'</div>';
                  $('#forgot_status_msg').html(response.message);
                  $('#forgot_status_msg').css('color','red');
                  setTimeout(function(){
                        $('#ForgotPasswordModal').modal('hide');
                   },10000);

              }
            }
          }
        });
    }); //forgot password


</script>


@endsection