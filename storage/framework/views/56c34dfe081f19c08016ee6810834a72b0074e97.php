<?php $__env->startSection('main_content'); ?>
<!DOCTYPE html>
<link href="<?php echo e(url('/')); ?>/assets/front/css/sellersignup-css.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo e(url('/')); ?>/assets/front/css/plan-css.css" rel="stylesheet" type="text/css" />
    
 <script type="text/javascript">
          var SITE_URL = '<?php echo e(url('/')); ?>';
 </script>
<style type="text/css">
  .calcelled-membrship {
    font-size: 15px;
    margin-bottom: 40px;
    text-align: center;
}
.calcelled-membrship-innerr {
    font-weight: 600;
    display: inline-block;
}
.calcelled-membrship-right {
    display: inline-block;
    color: #AE47DD;
}
.main-count-product{display: block;font-size: 11px;margin-bottom: 12px;}
.left-counts-plan{float: left;}
.right-counts-plan{float: right;}
    
 
  .form-section.topspaceclr{
    margin-top: 30px
  }
.radio-sections .slidecontainer {
  width: 100%;
}
.priceslider-mns-div input.parsley-success{
border: none !important;
}
.radio-sections .slider { 
  -webkit-appearance: none;
  width: 100%;
  height: 6px;
  border-radius: 5px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.radio-sections .slider:hover {
  opacity: 1;
}

.radio-sections .slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background: #ce4cf1;
  cursor: pointer;
}

.radio-sections .slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #ce4cf1;
  cursor: pointer;
}
.login-20.mainsignupnewclass.membrsp-div-class .input-group-addon{
      position: absolute;
    right: 0;
    top: 0;
    height: 43px;
    width: 39px;
    line-height: 36px;
    padding: 4px;
    vertical-align: top;
    display: block;
}
@media (max-width: 991px){
  .mainwhite-plan ul li{ font-size: 12px; margin-bottom: 7px;}
}
@media (max-width: 767px)
{
  .innermain-my-profile.membership-plan-width{padding: 20px;}
  .radio-sections {
    margin: 0;
    display: block;
   }
  .login-20.mainsignupnewclass.membrsp-div-class .radio-sections .radio-btn 
  {
    width: 100%;
    max-width: 300px;
    float: none;
    display: inline-block; 
    margin: 0 auto 20px !important;
  }
}


.showprocessingvrly {
    max-width: 1030px;
}
.btn-info {
    color: #fff;
    background-color: #AE47DD;
    border-color: #AE47DD;
}
.btn-info:hover, .btn-info:focus {
    color: #fff;
    background-color: #AE47DD;
    border-color: #AE47DD;
}

.radio-sections {
    justify-content: center;
}
.form-section.paymentdetails-frms1 {
    border-radius: 7px;
    margin-top: 30px;
    max-width: 100%;
    -webkit-box-shadow: 0 0.1rem 0 0 rgba(0,0,0,.25);
    box-shadow: 0 0.1rem 0 0 rgba(0,0,0,.25);
    background: #fff;
}
</style>
 
</head>

<body>
 
<?php

 $user_subscribed = isset($user_subscribed)?$user_subscribed:'';
 $dbmembership_type ='';$dbmembership_id=''; $dbmembership_amount='';
 if(isset($get_membershipdata) && !empty($get_membershipdata))
 {
    $dbmembership_type = $get_membershipdata['membership'];
    $dbmembership_id = $get_membershipdata['membership_id'];
    $dbmembership_amount = $get_membershipdata['membership_amount'];

 }


$loginuserid ='';

if(isset($user_details_arr) && !empty($user_details_arr))
{
  $loginuserid = $user_details_arr['id'];
}

?>


 <?php

    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }

    $publik_key ='';
    if(isset($site_setting_arr) && count($site_setting_arr)>0)
    {
         $payment_mode = $site_setting_arr['payment_mode'];

         if($payment_mode=='0' && isset($site_setting_arr['sandbox_stripe_public_key']))
         {
            $publik_key = $site_setting_arr['sandbox_stripe_public_key'];

         }
         elseif($payment_mode=='1' && isset($site_setting_arr['live_stripe_public_key']))
         {
             $publik_key = $site_setting_arr['live_stripe_public_key'];
         }
    }

   // $publik_key = config('app.project.stripe_publish_key');

?>   




<div class="my-profile-pgnm">
 Update card

  <ul class="breadcrumbs-my">
    <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li> Update card </li>
  </ul>
</div>


<div class="new-wrapper main-my-profile">
<div class="innermain-my-profile membership-plan-width">
<div class="login-20 mainsignupnewclass membrsp-div-class">
        <div class="row">
                

        <div class="hidden-overflow">

            <form id="nonce-form">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="loginuserid" id="loginuserid" value="<?php echo e($loginuserid); ?>">
                <input type="hidden" name="dbmembership_type" id="dbmembership_type" value="<?php echo e($dbmembership_type); ?>">
                <input type="hidden" name="dbmembership_id" id="dbmembership_id" value="<?php echo e($dbmembership_id); ?>">

             <div class="col-xl-6 col-lg-6 col-md-6  bg-color-10">

                <div id="status_msg"></div>
                <div id="error_message"></div>
        

                <!-- step 3 Start -->
                <div class="sub-plan-section seller-signup-phase3"  id="step3">
                     
                                           
 
                      <!-------start of payment detail form---------------->
                      

                        <div class="clearfix"></div>


                      <div class="form-section paymentdetails-frms1" id="paydetailform"  <?php if(!empty($get_membershipdata) && $user_subscribed=='1'): ?>  style="display:block" <?php else: ?> style="display:block" <?php endif; ?>>   



                               <div class="login-inner-form">
                                <div class="title-p-details select-sub-pln">Card Details</div>
                                   <div class="row">
                                       <div class="card-errors"></div>

  
                                     <div class="col-md-6">
                                        <div class="form-group form-box">
                                             <input type="text" class="form-control stripeclass" id="name" name="name" autofocus="" placeholder="Card holder’s name"  required data-parsley-required-message="Please enter card holder name"
                                           />
                                              <span id='cardName_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div> 

                     

                                    <div class="col-md-6">
                                        <div class="form-group form-box">
                                            <input type="text" name="card_number" id="card_number" placeholder="1234 1234 1234 1234"  class="form-control input-text stripeclass"maxlength="16" autocomplete="off" data-parsley-required-message="Please enter card number" required>
                                            <span id='cardNumber_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group form-box">
                                            <input type="text" name="card_exp_month" id="card_exp_month" placeholder="MM" maxlength="2"  class="form-control stripeclass" data-parsley-required-message="Please enter card expiry month" required>                                           
                                             <span id='card_exp_month_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>


                                     <div class="col-md-3">
                                        <div class="form-group form-box">
                                            <input type="text" name="card_exp_year" id="card_exp_year" placeholder="YYYY" maxlength="4"  class="form-control stripeclass" data-parsley-required-message="Please enter year" required>                                           
                                             <span id='card_exp_year_error'></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group form-box">
                                            <input type="text" name="card_cvc" id="card_cvc" placeholder="CVC" maxlength="3" class="form-control input-text stripeclass" autocomplete="off" data-parsley-required-message="Please enter cvv" required>
                                           <span id='card_cvc_error'></span>       
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                 
                                <input type="hidden" id="card-nonce" name="nonce">


                                 <!----------start of -button div------------------------>
                                <div class="buttonsection-bottom">                                   
                                    <a href="javascript:void(0)" class="btn-md btn-theme next-right"  id="payBtn" onclick="onGetCardNonce(event)">Submit</a>
                                    <div class="clearfix"></div>
                                </div>
                                 <!-----------end of button div------------------------>


                            </div>
                       </div>
                    <!---end of card detail form------->
                   
                  </div>
                <!-- step 3 End -->
            </div>
        </div>
        </div>

</div>
</div>

        
</div>
 </form>

<script src="https://js.stripe.com/v2/"></script>




<!-- parsley validationjs-->
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/sweetalert/sweetalert.js"></script>

<!-- data table js-->
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>
    
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/bootstrap.min.js"></script>


<script>
function onGetCardNonce(event) 
{
   var subscription = $("#subscription").val();
   
   var name = $("#name").val();
   var card_number = $("#card_number").val();
   var card_exp_month = $("#card_exp_month").val();
   var card_exp_year = $("#card_exp_year").val();
   var card_cvc = $("#card_cvc").val();



   if(subscription=="")
   {
      swal('Warning!', 'Please select membership plan', 'warning');
   }else{

      
       $(".stripeclass").attr("data-parsley-required","true");
       if($('#nonce-form').parsley().validate()==false) return;

      // swal({
      //     title: 'Do you really want to purchase this membership plan?',
      //     type: "warning",
      //     showCancelButton: true,
      //   //   confirmButtonColor: "#DD6B55",
      //     confirmButtonColor: "#8d62d5",
      //     confirmButtonText: "Yes, do it!",
      //     closeOnConfirm: false
      //   },
      //   function(isConfirm,tmp)
      //   {
      //     if(isConfirm==true)
      //     { 

               event.preventDefault();

                 $('#payBtn').attr("disabled", "disabled");
        
                // Create single-use token to charge the user
                Stripe.createToken({
                    number: $('#card_number').val(),
                    exp_month: $('#card_exp_month').val(),
                    exp_year: $('#card_exp_year').val(),
                    cvc: $('#card_cvc').val()
                }, stripeResponseHandler);
                
                // Submit from callback
                return false;





               // Don't submit the form until SqPaymentForm returns with a nonce
              // event.preventDefault();
               // Request a nonce from the SqPaymentForm object
              // paymentForm.requestCardNonce();
       //   } 
       //    else{
              
       //    }
       // })
   }
}  //end of function 
 
</script>

<script>
   var loginuserid = "<?php echo e($loginuserid); ?>";

  var publickey = "<?php echo e($publik_key); ?>";
  console.log(publickey);
// Set your publishable key
Stripe.setPublishableKey(publickey);


// Callback to handle the response from stripe
function stripeResponseHandler(status, response) { 

    if (response.error) {
        // Enable the submit button
        $('#payBtn').removeAttr("disabled");

        // Display the errors on the form

        $(".card-errors").html('<p>'+response.error.message+'</p>');

    } else {
        var form$ = $("#nonce-form");
        // Get token id
        var token = response.id;
        // Insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // Submit form to the server
        //form$.get(0).submit();

        if(token && $("#card_number").val()!='' && $("#card_exp_month").val()!='' && $("#card_exp_year").val()!='' && $("#card_cvc").val()!='')
        {
          $(".card-errors").html('');

          swal({
          title: 'Confirm update?',
          type: "warning",
          showCancelButton: true,
        //   confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
          },
          function(isConfirm,tmp)
          {
            if(isConfirm==true)
            {

                  if($('#nonce-form').parsley().validate()==false) return;
           
                   $.ajax({
                    url:SITE_URL+'/seller/membership_updatecard',
                    data:new FormData($('#nonce-form')[0]),
                    processData: false,
                    method:'POST',
                    contentType: false,
                    dataType:'json',
                    beforeSend : function() 
                    {
                      showProcessingOverlay();
                      $('#btn-sign-up').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                    },
                    success:function(response)
                    {
                      console.log(response);
                      hideProcessingOverlay();
                   

                      if(typeof response =='object')
                      {
                        if(response.status && response.status=="SUCCESS")
                        {
                            $("#nonce-form")[0].reset();
                            $('#btn-sign-up').html('Submit');
                            swal('Success!', response.msg, 'success');
                            setTimeout(function(){
                               window.location.href=SITE_URL+'/seller/updatecard';

                            },1000);
                            
                        }
                        else if(response.status=="ERROR")
                        {
                          
                          //  swal.close() 
                            if(response.msg!="")
                            {
                                $('#error_message').css('color','red').html(response.msg);
                            }else{
                                $('#error_message').html('');
                            }

                            if(response.cardmsg!=""){
                               
                                 swal({
                                  title: 'Error',
                                  text: response.cardmsg,
                                  type: 'error',
                                  showCancelButton: false,
                                  showConfirmButton:false,
                                  closeOnConfirm: false,
                                  closeOnCancel: false
                                });

                                 setTimeout(function(){
                                   window.location.reload();
                                 },8000);


                            }else{
                                $('.card-errors').html('');
                            }  
                        
                        }//else if error
                       
                        
                      }// if type object
                    }//success
                  });

            } //confirmbox             
           })//if confirm box        
        }//if token
    }//end of else
}//end of stripe token handler







</script>



</body>

</html>


<?php $__env->stopSection(); ?>                  
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>