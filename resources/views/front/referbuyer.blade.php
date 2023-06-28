


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="{{ isset($site_setting_arr['meta_desc'])?$site_setting_arr['meta_desc']:'' }}" />
  
    <title>{{isset($page_title)?$page_title:""}} : {{ config('app.project.name') }}</title>
    <!-- ======================================================================== -->
    <!-- Bootstrap CSS -->
    <link href="{{url('/')}}/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="{{url('/')}}/assets/front/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!--font-awesome css-->
    <link href="{{url('/')}}/assets/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--project css-->
    <link href="{{url('/')}}/assets/front/css/welcome.css" rel="stylesheet" type="text/css" />
        {{-- <link href="{{url('/')}}/assets/front/css/chow.css" rel="stylesheet" type="text/css" /> --}}

    <link href="{{url('/')}}/assets/common/Parsley/dist/parsley.css" rel="stylesheet">

   <!--Main JS-->
    <script type="text/javascript" src="{{url('/')}}/assets/front/js/jquery-1.11.3.min.js"></script>

@php
    if(isset($site_setting_arr['referal_image']) && $site_setting_arr['referal_image']!='' && file_exists(base_path().'/uploads/referal/'.$site_setting_arr['referal_image'])){
    $referal_image = url('/').'/uploads/referal/'.$site_setting_arr['referal_image'];
    }else{
     $referal_image = url('/').'/images/infra2.jpg';
    } 

@endphp

<style>
.input_div {float:none; margin:0 auto; margin-bottom:15px;}
.input_div .parsley-errors-list {position:inherit;}
.add-cart {
    background-color: #873dc8;
    color: #fff;
    font-weight: 600;
    vertical-align: top;
    font-size: 12px;
    padding: 8px 28px;
    text-transform: uppercase;
    display: inline-block;
    border: 1px solid #873dc8;
    letter-spacing: 0.7px;
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
	background:url('{{ $referal_image  }}'); background-size:cover;background-position:center top;background-repeat:none; 
	height: 100vh;width: 100%;
	position: relative;
  display:flex;
}

@media screen and (max-width: 767px){
.banner-404 .bg-tra{    height: auto;padding: 29px 30px 20px; position: static; background: transparent;}
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
}
@media screen and (max-width: 600px){.error_type {font-size: 83px;}}
/*Thank you page and thank you page css end here*/

body {
    overflow: hidden;
}



</style>

 @php

    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }

 

@endphp   
@php 

$referalcode = $referalcode;

@endphp


 <div class="banner-404" style="">
       <div class="bg-tra">
        <div class="err-cont">

            <div class="alert alert-success alert-dismissible" id="succmsg" style="display: none">
                
            </div>

            {{-- <div id="message"></div> --}}

            <div class="alert alert-danger alert-dismissible" id="message" style="display: none">
                
            </div>

            <form id="refer-form">
             {{ csrf_field() }}
             
             <input type="hidden" name="referalcode" id="referalcode" value="{{ $referalcode or '' }}">

              <div class="text-center">
               <div class="logo-head"><a href="{{ url('/') }}"><img src="{{ $sitelogo }}" alt=""></a></div>
                <div class="error_type thak-u"></div>
                <p> {{ isset($site_setting_arr['referal_text'])?$site_setting_arr['referal_text']:'' }}</p>

                <div class="col-md-12">
                   <div class="col-md-6 input_div"> 
                   <input type="text" data-parsley-required="true"  data-parsley-required-message="Please enter email" data-parsley-type="email"  data-parsley-type-message="Please enter valid email " class="form-control" name="email" id="email" value="" placeholder="Invite with email">
                 </div>
               </div>
                 <div class="col-md-12">
                   <a class="btn add-cart submitemail" id="submitemail">Send Invitation</a>
                 </div>
               </div>

             </form>

            </div>
        </div>
    </div>


   <div class="copyright-block-welcom"> 
            <i class="fa fa-copyright"></i> {{ config('app.project.footer_link_year') }}   <a href="{{ url('/') }}">Chow420.com</a>, Inc.       
    </div> 
</div>


<script>
var SITE_URL ="{{ url('/') }}";

  $(document).on('click','#submitemail',function(){

    if($('#refer-form').parsley().validate()==false) return;

        var form_data = $('#refer-form').serialize();      

        if($('#refer-form').parsley().isValid() == true )
        {
                     
          var email = $("#email").val();
          var code = $("#referalcode").val();

          $.ajax({
            url:SITE_URL+'/process_buyerreferal_email',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            {
              showProcessingOverlay();
              $('#submitemail').prop('disabled',true);
              $('#submitemail').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
             
              hideProcessingOverlay();
              $('#submitemail').prop('disabled',false);
              $('#submitemail').html('Submit');

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                    $("#refer-form")[0].reset();
                    $("#succmsg").show();
                    $("#succmsg").html("Invitation send successfully, please check your inbox to register with the chow420");
                    setTimeout(function(){
                    window.location.href = SITE_URL+'/referbuyer?referalcode='+code+'';
                  },2000);

 
                }
                else if(response.status="ERROR")
                { 
                    if(response.msg!="")
                    {
                       // $('#message').css('color','red').html(response.msg);

                        $("#message").show();
                        $("#message").html(response.msg);


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



 <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loadingoverlay.min.js"></script>
   <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>


<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/bootstrap.min.js"></script>

</body>

</html>
