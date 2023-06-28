<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?php echo e(isset($site_setting_arr['meta_desc'])?$site_setting_arr['meta_desc']:''); ?>" />
  
    <title><?php echo e(isset($page_title)?$page_title:""); ?> : <?php echo e(config('app.project.name')); ?></title>
    <!-- ======================================================================== -->
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(url('/')); ?>/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo e(url('/')); ?>/assets/front/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!--font-awesome css-->
    <link href="<?php echo e(url('/')); ?>/assets/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--project css-->
    <link href="<?php echo e(url('/')); ?>/assets/front/css/welcome.css" rel="stylesheet" type="text/css" />
        

    <link href="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.css" rel="stylesheet">

   <!--Main JS-->
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/front/js/jquery-1.11.3.min.js"></script>

<?php
    if(isset($site_setting_arr['referal_image']) && $site_setting_arr['referal_image']!='' && file_exists(base_path().'/uploads/referal/'.$site_setting_arr['referal_image'])){
    $referal_image = url('/').'/uploads/referal/'.$site_setting_arr['referal_image'];
    }else{
     $referal_image = url('/').'/images/infra2.jpg';
    } 

?>

<style>
  .verifybutton-main-div {
    margin-top: 10px;
}
  .parsley-errors-list.filled {
    opacity: 1;
    text-align: left;
}
.input_div {float:none; margin:0 auto; margin-bottom:15px;}
.input_div .parsley-errors-list {position:inherit;}
.add-cart {
       background-color: #873dc8;
    color: #fff;
    font-weight: 600;
    vertical-align: top;
    font-size: 12px;
    padding: 7px 14px;
    text-transform: uppercase;
    display: inline-block;
    border: 1px solid #873dc8;
    letter-spacing: 0;
    border-radius: 3px;
}
.add-cart:hover {
    color: #873dc8;
    background-color: #fff;
    transition: 0.3s;
}
/*Thank you page and thank you page css start here*/
.add-favorites-btn.thnk-pagess{margin: 0 auto;}
.err-cls {color: #fff;font-size: 36px;letter-spacing: 3.8px;line-height: normal;text-shadow: 2px 1px 1px #888;text-transform: uppercase;}
.error_msg > p {color: #fff;}
/*.banner-404 {min-height: 879px;}*/
.err-cont {display: inline-block;width: 100%; background: rgba(255, 255, 255, 0.31); padding:30px;}
.banner-404 .bg-tra {
	      /*background: rgba(255, 255, 255, 0.31);*/
    height: 400px;
    margin: auto;
    padding: 29px 30px 130px;
    max-width: 752px;
    position: absolute;
    width: 100%;
    text-align: center;
    top: 0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
}
/*.err-cont h1 {margin:5px 0px !important;}*/
.err-cont h1 span {display:block;}
.err-cont .become-phot {padding: 11px 61px;margin-top: 4%;}
.error_type {color: #333;font-size: 129px;font-weight: 600;letter-spacing: 3.8px;line-height: normal;}
.seperator {width: 65%;}
.error_type.thak-u{
 font-size: 48px;
    margin: 22px 0;
    letter-spacing: 0;
}
.err-cls.thks {    color: #222;
    font-size: 18px;
    letter-spacing: normal;
    line-height: 27px;
    text-shadow: none;
    text-transform: capitalize;}
.err-cls.thks > a {color: #E91E63;}
.btn-favorite {
    color: #fff;
    background-color: #873dc8;
    display: inline-block;
    padding: 10px 20px;
    border-radius: 3px;
    margin-top: 20px;
}
.btn-favorite:hover{
	color: #fff;
    background-color: #222;
}


.copyright-block-welcom {
    position: absolute;
    bottom: 0px;
    left: 0px;
    padding: 10px;
    text-align: center;
    background-color: #fff;
    width: 100%;
}

.copyright-block-welcom  a{
	    color: #873dc8;
}
.copyright-block-welcom{
	position: absolute; bottom: 0px;left: 0px;
}

.banner-404{
	overflow: hidden;
	background:url('<?php echo e($referal_image); ?>'); background-size:cover;background-position:center top;background-repeat:none; 
	height: 100vh;width: 100%;
	position: relative;
  display:flex;
}
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
@media  screen and (max-width: 767px){
  .err-cont {
      padding: 10px;
  }
.banner-404 .bg-tra{height: auto; padding: 29px 20px 20px; position: static; background: transparent;}
.err-cls.thks {
    color: #222;
    font-size: 15px;
    letter-spacing: normal;
    line-height: 26px;
    text-shadow: none;
    text-transform: capitalize;
}
.error_type.thak-u {
    font-size: 35px;
    margin-top: 20px;
}
.add-cart{
  display: block;margin-top: 10px;
}
}
@media  screen and (max-width: 600px){.error_type {font-size: 83px;}}
/*Thank you page and thank you page css end here*/

body {
    overflow: hidden;
}

h1{ font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 14px;
    line-height: 1.42857143;
    color: #333;}


</style>

 <?php

    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }

 

?>   
<?php 

//$activationcode = $activationcode;

?>


 <div class="banner-404" style="">
       <div class="bg-tra">
        <div class="err-cont">

            <div class="alert alert-success alert-dismissible" id="succmsg" style="display: none">
                
            </div>

            <div id="message"></div>

            <form id="activation-form">
             <?php echo e(csrf_field()); ?>

             
         

             

              <div class="text-center">
               <div class="logo-head"><a href="<?php echo e(url('/')); ?>"><img src="<?php echo e($sitelogo); ?>" alt=""></a></div>
                <div class="error_type thak-u"></div>
                <h1> 
                  Verify your email address by entering activation code in email. 
                  <span>If you don't see an email in your inbox,please check your SPAM folder.</span>
                </h1>
                <div class="col-md-12">
                  <div class="row"> 
                   <div class="col-md-6 input_div"> 
                   <input type="text" data-parsley-required="true"  data-parsley-required-message="Please enter email" data-parsley-type="email" data-parsley-type-message="Please enter valid email " class="form-control" name="useremail" id="useremail" value="" placeholder="Please enter email">
                 </div>
               </div>
               </div>
               


                <div class="col-md-12" id="hideactivationcode">
                  <div class="row"> 
                   <div class="col-md-6 input_div"> 
                   <input type="text" data-parsley-required="true"  data-parsley-required-message="Please enter activation code" data-parsley-type-message="Please enter valid code " class="form-control" name="activationcode" id="activationcode" value="" placeholder="Please enter activation code">
                 </div>
                 </div>
               </div>

                 <div class="col-md-12">
                  <div class="verifybutton-main-div">
                      <a class="btn add-cart submitcode" id="submitcode">verify</a>
                     <a class="btn add-cart resendactivationcode" id="resendactivationcode">Resend Activation Code</a>
                  </div>
                 </div>
               </div>

             </form>

            </div>
        </div>
    </div>


   <div class="copyright-block-welcom"> 
            <i class="fa fa-copyright"></i> <?php echo e(config('app.project.footer_link_year')); ?>   <a href="<?php echo e(url('/')); ?>">Chow420.com</a>, Inc.       
    </div> 
</div>


<script>
var SITE_URL ="<?php echo e(url('/')); ?>";

  $(document).on('click','#submitcode',function(){
    $("#hideactivationcode").show();
    $("#activationcode").attr('data-parsley-required',"true");

    if($('#activation-form').parsley().validate()==false) return;

        var form_data = $('#activation-form').serialize();      

        if($('#activation-form').parsley().isValid() == true )
        {
                     
          var email = $("#email").val();
          var code = $("#activationcode").val();

          $.ajax({
            url:SITE_URL+'/process_activationcode',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            {
              showProcessingOverlay();
              $('#submitcode').prop('disabled',true);
              $('#submitcode').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
             
              hideProcessingOverlay();
              $('#submitcode').prop('disabled',false);
              $('#submitcode').html('Submit');

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                 
                    $("#activation-form")[0].reset();
                    $("#succmsg").show();
                    $("#succmsg").html(response.msg);
                    $('#message').html('');

                    if(response.usertype=="seller")
                    { 
                      
                        // window.location.href = SITE_URL+'/login';
                        window.location.href = SITE_URL+'/seller/profile';
                     
                     
                      
                    }else{
                        setTimeout(function(){
                         // window.location.href = SITE_URL+'/login';
                         window.location.href = SITE_URL+'/buyer/profile';
                        },2000);
                    }

                  
                }
                else if(response.status="ERROR")
                {
                    if(response.msg!=""){
                        $('#message').css('color','red').html(response.msg);
                    }else{
                        $('#message').html('');
                    }   
               
                }
               
              }// end of if type object           
            }//end of success
          });
        }//if validation true
  });


  $(document).on('click','#resendactivationcode',function(){ 

    $("#activationcode").removeAttr('data-parsley-required');
    $("#hideactivationcode").hide();

    if($('#activation-form').parsley().validate()==false) return;

        var form_data = $('#activation-form').serialize();      

        if($('#activation-form').parsley().isValid() == true )
        {
                     
          var email = $("#email").val();
         

          $.ajax({
            url:SITE_URL+'/resend_activationcode',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            {
              showProcessingOverlay();
              $('#resendactivationcode').prop('disabled',true);
              $('#resendactivationcode').html('Please Wait');
            },
            success:function(response)
            {
             
              hideProcessingOverlay();
              $('#resendactivationcode').prop('disabled',false);
              $('#resendactivationcode').html('Submit');

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                 
                    $("#activation-form")[0].reset();
                    $("#succmsg").show();
                    $("#succmsg").html(response.msg);
                    $('#message').html('');

                    if(response.usertype=="seller")
                    { 
                       if(response.already==1){
                           window.location.href = SITE_URL+'/login';
                       }else{
                          window.location.href = SITE_URL+'/welcome';
                       }
                      
                    }else{
                        setTimeout(function(){
                         window.location.href = SITE_URL+'/login';
                        },2000);
                    }

                  
                }
                else if(response.status="ERROR")
                {
                    if(response.msg!=""){
                        $('#message').css('color','red').html(response.msg);
                    }else{
                        $('#message').html('');
                    }   
               
                }
               
              }// end of if type object           
            }//end of success
          });
        }//if validation true
  });



</script>



 <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/loader/loadingoverlay.min.js"></script>
   <script type="text/javascript" src="<?php echo e(url('/')); ?>/assets/common/loader/loader.js"></script>


<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/bootstrap.min.js"></script>

</body>

</html>
