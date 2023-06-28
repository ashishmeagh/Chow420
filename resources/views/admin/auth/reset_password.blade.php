<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
{{--     <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/images/faviconnew.ico"> --}}
    <title>Reset Password - {{config('app.project.name')}}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{url('/')}}/assets/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/admin/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{url('/')}}/assets/admin/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('/')}}/assets/admin/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{url('/')}}/assets/admin/css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- Parsley css-->
    <link href="{{url('/')}}/assets/admin/js/Parsley/dist/parsley.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('/')}}/assets/admin/css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>


@php
    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }

@endphp 


<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>


    <section id="wrapper" class="login-register">

       

        <div class="login-box">
            <div class="white-box">
                 <div class="logo-chow text-center space-logo-margin">
                    <a href="{{url('/')}}"> <img src="{{$sitelogo or ''}}" alt="" /></a>
                   </div>
                {!! Form::open([ 'url' => $admin_panel_slug.'/reset_password',
                                 'method'=>'POST',
                                 'id'=>'form-reset_password'
                                ]) !!}
                                    
                    @include('admin.layout._operation_status')  
                 
                 {{ csrf_field() }}
                    <h3 class="box-title m-b-20 text-center">Reset Password</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            {!! Form::password('password',['class'=>'form-control','id'=>'new_password',
                                        'data-parsley-required'=>'true',
                                        'data-parsley-required-message'=>'Please enter new password',
                                        'data-parsley-minlength'=>'8',
                                        'data-parsley-pattern'=>"(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}",
                                        'data-parsley-pattern-message'=>"Password field must contain at least one number and one uppercase and lowercase letter one special character and at least 8 or more characters",
                                        'placeholder'=>'New password']) !!}
                            <span class="red">{{ $errors->first('password') }} </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                           {!! Form::password('confirm_password',['class'=>'form-control',
                                        'data-parsley-required'=>'true','data-rule-minlength'=>'8',
                                        'data-parsley-equalto'=>'#new_password',
                                        'data-parsley-error-message'=>"Confirm password should be same as new password",
                                        'placeholder'=>'Confirm Password']) !!}

                        <span class="red">{{ $errors->first('confirm_password') }} </span>
                        </div>
                    </div>
                    <input type="hidden" name="enc_id" value="{{ $enc_id or '' }}" />
                    <input type="hidden" name="enc_reminder_code"  value="{{ $enc_reminder_code or '' }}"/>
                    
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Change Password</button>
                        </div>
                    </div>

                </form>
                
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{url('/')}}/assets/admin/bootstrap/dist/js/tether.min.js"></script>
    <script src="{{url('/')}}/assets/admin/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="{{url('/')}}/assets/admin/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{url('/')}}/assets/admin/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{url('/')}}/assets/admin/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="{{url('/')}}/assets/admin/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!--Parsley js-->
    <script type="text/javascript" src="{{url('/')}}/assets/admin/js/Parsley/dist/parsley.min.js"></script>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function(){
    $('#form-reset_password').parsley();
  });
</script>