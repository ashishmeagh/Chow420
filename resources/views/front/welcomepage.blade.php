


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

   <!--Main JS-->
    <script type="text/javascript" src="{{url('/')}}/assets/front/js/jquery-1.11.3.min.js"></script>

@php
   if(isset($site_setting_arr['welcome_image']) && $site_setting_arr['welcome_image']!='' && file_exists(base_path().'/uploads/welcome/'.$site_setting_arr['welcome_image'])){
    $welcome_image = url('/').'/uploads/welcome/'.$site_setting_arr['welcome_image'];
    }else{
     $welcome_image = url('/').'/images/gaalery-video-3.jpg';
    } 

@endphp

<style>
/*Thank you page and thank you page css start here*/
.add-favorites-btn.thnk-pagess{margin: 0 auto;}
.err-cls {color: #fff;font-size: 36px;letter-spacing: 3.8px;line-height: normal;text-shadow: 2px 1px 1px #888;text-transform: uppercase;}
.error_msg > p {color: #fff;}
/*.banner-404 {min-height: 879px;}*/
.err-cont {display: inline-block;width: 100%;}
.banner-404 .bg-tra {
	  background: rgba(255, 255, 255, 0.31);
    height: auto;
    margin: 0px auto 0;
    padding: 29px 30px 30px;
    max-width: 752px;
    position: relative;
    width: 100%;
    text-align: center;
    top: 20px;
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
    font-size: 17px;
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
   /* position: absolute;
    bottom: 0px;
    left: 0px;*/
    padding: 10px;
    text-align: center;
    background-color: #fff;
    width: 100%;
    position: static;
    bottom: 0px;
    left: 0px;
    margin-top: 0px;
}
ul, li{list-style-type: none;}
ul{
  list-style-type: none;
    text-align: left;
    padding-left: 0;
}
.parsley-errors-list{color: #f90000;}
.copyright-block-welcom  a{
	    color: #873dc8;
}
/*.copyright-block-welcom{
	position: absolute; bottom: 0px;left: 0px;
}*/

.banner-404{
	/*overflow: auto;*/
	background:url('{{ $welcome_image  }}'); background-size:cover;background-position:center top;background-repeat:none; 
	height: 90vh;width: 100%;
	position: relative;
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

/*body {
    overflow: hidden;
}
*/


</style>

 @php

    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }



@endphp   
@php 

$usertype = $usertype;
$email = $email;

@endphp

{{-- @if(isset($usertype) && isset($email))
  <script type="text/javascript">
  	 setTimeout(function(){
  	 		window.location.href="{{ url('/') }}/login/{{ $usertype }}/{{ base64_encode($email) }}";
  	 		// window.location.href="{{ url('/') }}/login";
  	 },1500);
  </script>
@else
  <script type="text/javascript">
     setTimeout(function(){
          window.location.href="{{ url('/') }}/login";
     },1500);
  </script>
@endif --}}

 <div class="banner-404" style="">
       <div class="bg-tra">
        <div class="err-cont">
            <div class="text-center">
               <div class="logo-head"><a href="{{ url('/') }}"><img src="{{ $sitelogo }}" alt=""></a></div>
                <div class="error_type thak-u">{{ isset($site_setting_arr['welcome_title'])?$site_setting_arr['welcome_title']:'Welcome' }}</div>
               {{--  <p class="err-cls thks "> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet labore, facere in deserunt placeat ad provident repellat, consequuntur, obcaecati facilis maxime, dolorum illo excepturi cum! Labore quasi natus deserunt cum.</p> --}}
              <p class="err-cls thks ">{{ isset($site_setting_arr['welcome_desc'])?$site_setting_arr['welcome_desc']:'' }}</p>

              {{--   <hr class="seperator"> --}}
                   {{--  <div class="add-favorites-btn thnk-pagess"><a href="{{ url('/') }}" class="btn-favorite">Go Home</a></div> --}}

                   @if(isset($usertype) && isset($email))

                      @if($usertype=="1")
                             <div class="add-favorites-btn thnk-pagess">
                              <a href="{{ url('/') }}/login/{{ $usertype }}/{{ base64_encode($email) }}" class="btn-favorite">Continue</a>
                             </div>
                       @else
                          <!-------if it is seller----------->
                           <form  id="nonce-form">
                            {{ csrf_field() }}
                            <input type="hidden" name="selleremail" id="selleremail" value="{{ $email }}">

                              <input type="hidden" name="sellerusertype" id="sellerusertype" value="{{ $usertype }}">

                           {{--  <textarea name="hear_about" rows="4" cols="50" id="hear_about" class="form-control" placeholder="How did you hear about us" data-parsley-required="true" value="{{$hear_about or ''}}" data-parsley-required-message="Please enter how did you hear about us"></textarea> --}}

                           <select name="hear_about" id="hear_about"  class="form-control"  data-parsley-required="true" data-parsley-required-message="Please select how did you hear about us">
                                  <option value="">How did you hear about us</option>
                                   <option value="Search Engine">Search Engine</option>
                                   <option value="Social Media">Social Media</option>
                                   <option value="Press or News">Press or News</option>
                                   <option value="TV">TV</option>
                                   <option value="Podcast or Radio">Podcast or Radio</option>
                                   <option value="In the Mail">In the Mail</option>
                                    <option value="Other">Other</option>
                                </select>

                            <span id="error_message"></span>

                           {{--  <a href="{{ url('/') }}/login/{{ $usertype }}/{{ base64_encode($email) }}" class="btn-favorite">Continue</a> --}}

                            <a href="javascript:void(0)" class="btn-favorite" id="submithearabout" >Continue</a>
                          </form>  

                       @endif


                   @else
                     <div class="add-favorites-btn thnk-pagess">
                      <a href="{{ url('/') }}/login" class="btn-favorite">Continue</a>
                     </div>
                   @endif



            </div>
        </div>
    </div>


  
</div>

 <div class="copyright-block-welcom"> 
            <i class="fa fa-copyright"></i> {{ config('app.project.footer_link_year') }}   <a href="{{ url('/') }}">Chow420.com</a>, Inc.       
    </div> 


<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert.js"></script>

<script>
  var SITE_URL="{{ url('/') }}";
  var usertype = {{ $usertype }};
  var email = "{{ $email }}";
 $(document).on('click','#submithearabout',function(){
    
    if($('#nonce-form').parsley().validate()==false) return;
      var form_data = $('#nonce-form').serialize();   
            if($('#nonce-form').parsley().isValid() == true )
                  {
                    $.ajax({
                      url:SITE_URL+'/update_hearaboutus',
                      data:form_data,
                      method:'POST',
                      
                      beforeSend : function()
                      {
                       
                        $('#submithearabout').prop('disabled',true);
                        $('#submithearabout').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                      },
                      success:function(response)
                      {

                        if(typeof response =='object')
                        {
                          if(response.status && response.status=="SUCCESS")
                          {
                              // $("#nonce-form")[0].reset();
                              setTimeout(function(){
                                  window.location.href=SITE_URL+'/login/'+usertype+'/'+btoa(email);
                              },1000);
                              
                          }
                          else if(response.status=="ERROR"){
                              if(response.msg!=""){
                                  $('#error_message').css('color','red').html(response.msg);
                              }else{
                                  $('#error_message').html('');
                              }

                             
                          }
                        }// if type object
                      }//success
                    });
                  }//if validated



  });
</script>



</body>

</html>
