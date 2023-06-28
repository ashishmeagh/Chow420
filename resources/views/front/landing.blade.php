<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <title>Basic Page</title>
    <!-- ======================================================================== -->
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <!-- Bootstrap CSS -->
    <link href="{{url('/')}}/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--Custom Css-->
    <link href="{{url('/')}}/assets/front/css/homepgcss.css" rel="stylesheet" type="text/css" />
    <!--Main JS-->

     <link href="{{url('/')}}/assets/common/Parsley/dist/parsley.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/common/sweetalert/sweetalert.css" rel="stylesheet">


    <script type="text/javascript" src="{{url('/')}}/assets/front/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/assets/common/loader/loader.js"></script>
    
    <script type="text/javascript">
          var SITE_URL = '{{url('/')}}';
    </script>
</head>

<body>
  
  @php
    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }
@endphp 

<div class="login-20">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5  bg-color-10">
                <div class="form-section">
                    <div class="logo clearfix">
                        <a href="#">
{{--      <img src="{{ url('/') }}/assets/front/images/chowlogos.png" alt="logo" />
 --}}           
                 <img src="{{ $sitelogo }}" alt="logo" />

              </a>
                    </div>
                    <h3>Sign into your account</h3>

                      <div id="status_msg"></div>
                       @include('front.layout.flash_messages')
                  
                    <div class="login-inner-form">
                        <form id="login-form" onsubmit="return false;">
                           {{ csrf_field() }}
                            <div class="form-group form-box">
                                <input type="email" name="email" class="input-text" placeholder="Email Address" data-parsley-required="true" data-parsley-required-message="Please enter email address" value="{{isset($_COOKIE["email"])?$_COOKIE["email"]:''}}">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group form-box">
                                <input type="password" name="password" class="input-text" placeholder="Password"  data-parsley-required="true" data-parsley-required-message="Please enter password" value="{{isset($_COOKIE['password'])?$_COOKIE['password']:''}}">
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn-md btn-theme btn-block" id="button_login">Login</button>
                            </div>
                        </form>
                    </div>
                    <p>Don't have an account? <a href="{{url('/').'/signup'}}" class="thembo">Sign Up</a></p>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7 bg-img ">
                <div class="info">
                    <h1>Welcome to Chow420</h1>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                     <div class="btnss-group">
                        <a href="{{ url('/') }}/signup_seller" class="btn-md btn-theme seller-btns">Seller Signup</button>
                        <a href="{{ url('/') }}/signup" class="btn-md btn-theme seller-btns">Buyer Signup</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  $('#button_login').click(function()
  {
    var urls = "{{ URL::previous() }}";
  
      

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
              $('#button_login').html('SIGN IN');

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

                        $('#status_msg').html(success_HTML);
                       
                       
                        if(response.user_redirection=='-1')
                        {
                          var segments = urls.split( '/' );
                          if(segments[2]!="" && segments[2]=="getnada.com"){
                             window.location.href="{{url('/')}}";
                          }else{
                             window.setTimeout(function(){ location.href = urls },1000);
                          }
                        }
                        else if(response.user_redirection=='-2')
                        {
                            window.setTimeout(function(){ location.href = "{{ url('/') }}/buyer/profile" },1000);
                        }
                        else
                        {
                          window.setTimeout(function(){ location.href = response.user_redirection },1000);
 
                        }
                   //  window.setTimeout(function(){ location.href = response.user_redirection },1000);



                  }
                  else
                  {                    
                      var error_HTML = '';   
                      if(response.message){
                         error_HTML+='<div class="alert alert-danger alert-dismissible">\
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>'+response.message+'</div>';
                        
                         $('#status_msg').html(error_HTML);
                         setInterval('autoRefresh()', 3000);
                     }// if msg
                  }
               }
            }
         });
      }
  });

    function autoRefresh()
    {
        window.location = window.location.href;
    }
   


</script>
    

<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert.js"></script>



<script type="text/javascript" language="javascript" src="{{ url('/') }}/assets/front/js/bootstrap.min.js"></script>

</body>

</html>

