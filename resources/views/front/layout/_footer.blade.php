
@php
   $currenturl = '';
   $currenturl =  Request::fullUrl();

  if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo'] != '' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo']))
  {
    $logo = url('/uploads/profile_image/'.$site_setting_arr['site_logo']);
  }
  else
  {
    $logo = url('/assets/front/images/chowlogos-white.png');
  }
@endphp

<div class="footer-main-block">
            <div class="footer-col-block">
                <div class="col-sm-md">
                    <div class=" footer-col-head">
                      @php
                        //image resize
                        $resize_white_logo = image_resize('/assets/front/images/chowlogos-white.jpg',186,64);
      
                      @endphp
                       
                        <img src="{{url('/')}}/assets/front/images/chowlogos-white.png"  alt="Logo" />

                        {{-- <img src="{{$resize_white_logo}}"  alt="Logo" /> --}}

                    </div>
                    <div class="copytxt-ftr">
                      <i class="fa fa-copyright"></i> 2018-2021 <a href="{{ url('/') }}">Chow420.com</a>
                    </div>
                    <div class="socail-chow">

                      @php
                         $resize_fb_img = image_resize('/assets/front/images/facebook-icon-n1.png',30,30);
                         $resize_youtube_img = image_resize('/assets/front/images/youtube-icon-n2.png',30,30);
                         $resize_twitter_img = image_resize('/assets/front/images/twitter-icon-n3.png',30,30);
                         $resize_instagram_img = image_resize('/assets/front/images/instagram-icon-n5.png',30,30);

                         $resize_tiktok_img = image_resize('/assets/front/images/tiktok-icon.png',30,30);


                      @endphp

                      <a href="{{ isset($site_setting_arr['facebook_url'])?$site_setting_arr['facebook_url']:'' }}" target="_blank">

                          <img  width="30px" src="{{url('/')}}/assets/front/images/facebook-icon-n1.png" alt=""/>

                         {{--  <img width="30px" class="lozad"  src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$resize_fb_img}}" alt=""/> --}}

                      </a>

                      <a href="{{ isset($site_setting_arr['youtube_url'])?$site_setting_arr['youtube_url']:'' }}" target="_blank">
                          <img  width="30px" src="{{url('/')}}/assets/front/images/youtube-icon-n2.png" alt=""/>

                      {{--     <img  width="30px" class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$resize_youtube_img}}" alt=""/> --}}
                      </a>
                      <a href="{{ isset($site_setting_arr['twitter_url'])?$site_setting_arr['twitter_url']:'' }}" target="_blank">
                          <img  width="30px" src="{{url('/')}}/assets/front/images/twitter-icon-n3.png" alt="" />

                          {{--  <img  width="30px" class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$resize_twitter_img}}" alt="" /> --}}
                      </a>

                      <a href="{{ isset($site_setting_arr['instagram_url'])?$site_setting_arr['instagram_url']:'' }}" target="_blank">
                        
                          <img  width="30px" src="{{url('/')}}/assets/front/images/instagram-icon-n5.png" alt=""/>
                          
                          {{-- <img  width="30px" class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$resize_instagram_img}}" alt=""/> --}}
                      </a>

                      @if(isset($site_setting_arr['tiktok_url']) && !empty($site_setting_arr['tiktok_url']))
                       <a href="{{ isset($site_setting_arr['tiktok_url'])?$site_setting_arr['tiktok_url']:'' }}" target="_blank">

                          <img  width="30px" src="{{url('/')}}/assets/front/images/tiktok-icon.png" alt=""/>
                         
                          {{-- <img  width="30px" class="lozad" src="{{url('/assets/images/Pulse-1s-200px.svg')}}" data-src="{{$resize_tiktok_img}}" alt=""/> --}}
                      </a>
                      @endif

                    </div>
                </div>

                 @php
                 $href='';
                 @endphp
                 @if(!empty($cms_about_cbd_arr) && count($cms_about_cbd_arr)>0)
                  <div class="col-sm-md abc">
                      <div class="footer_heading footer-col-head">
                          <span class="line-footer"></span> <span>Learn</span>
                      </div>
                      <div class="menu_name points-footer">
                          <ul>
                            @foreach($cms_about_cbd_arr as $cms_about_cbd_arrs)

                              @php
                               if($cms_about_cbd_arrs->page_slug=="cbd-101")
                                 $href = url('/').'/cbd-101';
                              else if($cms_about_cbd_arrs->page_slug=="about-us")
                                 $href = url('/').'/about-us';

                              @endphp
                              <li><a href="{{ $href }}" target="_blank">{{ $cms_about_cbd_arrs->page_title }}</a></li>
                            @endforeach
                              <li><a href="{{ url('/') }}/helpcenter" <?php if (Request::segment(1) == 'helpcenter') {echo 'class="terms-links active"';} else {echo 'class="terms-links"';}?> target="_blank">Help Center</a></li>
                          </ul>
                      </div>
                  </div>
                @endif


                 @php
                 $href='';
                 @endphp

                  @if(!empty($cms_terms_privacy_arr) && count($cms_terms_privacy_arr)>0)

                        <div class="col-sm-md abc">
                           <div class="footer_heading footer-col-head">
                                  <span class="line-footer"></span> <span>Company</span>
                              </div>
                              <div class="menu_name points-footer">
                                  <ul>
                                     @foreach($cms_terms_privacy_arr as $cms_terms_privacy)

                                     @php
                                      if($cms_terms_privacy->page_slug=="terms-conditions"){
                                        $href = url('/').'/terms-conditions';
                                      }
                                      else if($cms_terms_privacy->page_slug=="privacy-policy"){
                                         $href = url('/').'/privacy-policy';
                                      }
                                      else if($cms_terms_privacy->page_slug=="refund-policy"){
                                        $href = url('/').'/refund-policy';
                                      }



                                     @endphp

                                      <li><a href="{{ $href }}" target="_blank">{{ $cms_terms_privacy->page_title }}</a></li>


                                     @endforeach

                                  </ul>
                              </div>
                        </div>
                   @endif


                <div class="col-sm-md col-more-md abc">
                  <div class="row">

                    <div class="col-md-6">
                       <div class="footer_heading footer-col-head">
                        <span class="line-footer"></span> <span>Partner</span>
                    </div>
                    <div class="menu_name points-footer">
                        <ul>
                            @php
                             $href=$href1='';
                             @endphp

                            @if(!empty($cms_terms_referal_arr) && count($cms_terms_referal_arr)>0)
                              @foreach($cms_terms_referal_arr as $cms_terms_referal)
                              @php
                                 if($cms_terms_referal->page_slug=="earn-referal"){
                                      $href = strip_tags($cms_terms_referal->page_desc);
                                      $href = str_replace('&nbsp;', '', $href);
                                 }
                                 else if($cms_terms_referal->page_slug=="sell-on-chow420"){
                                      $href = strip_tags($cms_terms_referal->page_desc);
                                      $href = str_replace('&nbsp;', '', $href);
                                 }
                                 elseif ($cms_terms_referal->page_slug=="affiliate") {
                                      $href = strip_tags($cms_terms_referal->page_desc);
                                      $href = str_replace('&nbsp;', '', $href);
                                     }
                              @endphp

                              <li><a href="{{ $href }}" target="_blank">{{ $cms_terms_referal->page_title }}</a></li>

                              @endforeach
                            @endif
                        </ul>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="footer_heading footer-col-head">
                        <span class="line-footer"></span> <span>Conversations</span>
                    </div>
                    <div class="menu_name points-footer">
                        <ul>
                            <li><a href="{{ url('/') }}/forum">Chow420 Forum</a></li>
                            <li><a href="{{ url('/') }}/chowwatch">Chow Watch</a></li>
                        </ul>
                    </div>
                    </div>
                  </div>

                 
                  <div class="box-frametext">
                    *These statements have not been evaluated by the Food and Drug administration. These products are not intented to diagnose, treat, cure or prevent any disease.
                  </div>

                </div>

                <div class="clearfix"></div>

            </div>
</div>

<!-- Scription Inclusions Starts -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<!-- parsley validationjs-->
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/common/Parsley/dist/parsley.min.js"></script>

<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert_msg.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/sweetalert/sweetalert.js"></script>

<!-- data table js-->
<script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/listing.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/customjs.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<!---Google analytics-footer------>
@php
  if(isset($site_setting_arr['pixelcode2']) && !empty($site_setting_arr['pixelcode2'])) {
    echo $site_setting_arr['pixelcode2'];
  }

  $trackemail='';
  $login_user = Sentinel::check();

  if(isset($login_user) && $login_user==true)
  {
    if($login_user['user_type']=="buyer"){
      $trackemail = $login_user['email'];
    }else{
      $trackemail = '';
      }

  }
@endphp


<!-- <script type="application/javascript" async
src="https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=R29ZVf"></script>

<script>
 var _learnq = _learnq || [];
 if ('{{ $trackemail }}') {
   _learnq.push(['identify', {
       '$email' : '{{ $trackemail }}'
     }]);
  }
</script> -->

<!-- <script type='text/javascript' data-cfasync='false'>
window.purechatApi = {
    l: [], t: [], on: function ()
            {
                this.l.push(arguments);
            }
        };
        (function () {
        var done = false;
        var script = document.createElement('script');
        script.async = true;
        script.type = 'text/javascript';
        script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript';
        document.getElementsByTagName('HEAD').item(0).appendChild(script);
        script.onreadystatechange = script.onload = function (e)
            {
                if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete'))
                    {
                        var w = new PCWidget({c: 'ddb6b0fe-04be-4a1b-8c8d-03ea8ec5a668', f: true });
                        done = true;
                    }
                };
            })();

</script> -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157965708-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-157965708-1');
</script> -->



<!-- Scription Inclusions Ends -->



<script type="text/javascript">

  /* Gobal Declarations */
    var guest_url = "{{url('/')}}";
    var guest_redirect_url = window.location.href;
    var btn = $('#scroll-to-top');



  $(document).ready(function()
  {
      /*lazy load intialization*/
      const observer = lozad(); 
      observer.observe();


      $(".guest_url_btn").click(function(){


            $.ajax({
                    url:guest_url+'/set_guest_url',
                    method:'GET',
                    data:{guest_link:guest_redirect_url},
                    dataType:'json',

                    success:function(response)
                    {
                        
                      if(response.status=="success")
                      {
                        
                        $(location).attr('href', guest_url+'/signup/guest')


                      }

                    }
                });
          });


      $('.dropclick, #mySidenav').on('click', function (){
      if($(this).hasClass('openclass')){
        $(this).removeClass('openclass');
        $("#sign_in_dropdown").removeClass("openclass");
      }
      else{
       $(this).addClass('openclass');
      }

      });


  });





    $(".country").change(function(){

        var country = $(this).val();

              $.ajax({
                    url:guest_url+'/common/get_states/'+country,
                    method:'GET',
                    dataType:'json',
                    success:function(response)
                    {
                                 if(typeof(response)=='object') {

                                  if(response.status=='SUCCESS') {
                                      var option = '<option value="">Please Select States</option>';

                                      $(response.states_arr).each(function(index,state)
                                      {

                                        option+='<option value="'+state.id+'">'
                                                         +state.state_title+'</option>';
                                      });

                                      $(".state").html(option);
                                  }
                                  else
                                  {
                                   $(".state").html('<option>States Not Found</option>');
                                  }
                              }


                    }
                });
    });

    $(".state").change(function(){

        var country = $('.country').val();
        var state = $(this).val();

              $.ajax({
                    url:guest_url+'/common/get_cities/'+country+'/'+state,
                    method:'GET',
                    dataType:'json',
                    success:function(response)
                    {
                                 if(typeof(response)=='object') {

                                  if(response.status=='SUCCESS') {
                                      var option = '<option value="">Please Select city</option>';

                                      $(response.cities_arr).each(function(index,city)
                                      {

                                        option+='<option value="'+city.id+'">'
                                                         +city.city_title+'</option>';
                                      });

                                      $(".city").html(option);
                                  }
                                  else
                                  {
                                   $(".city").html('<option>City Not Found</option>');
                                  }
                              }


                    }
                });

    });/*end state function*/

    $(".country_billing").change(function(){

        var country = $(this).val();

              $.ajax({
                    url:guest_url+'/common/get_states/'+country,
                    method:'GET',
                    dataType:'json',
                    success:function(response)
                    {
                                 if(typeof(response)=='object') {

                                  if(response.status=='SUCCESS') {
                                      var option = '<option value="">Please Select States</option>';

                                      $(response.states_arr).each(function(index,state)
                                      {

                                        option+='<option value="'+state.id+'">'
                                                         +state.state_title+'</option>';
                                      });

                                      $(".state_billing").html(option);
                                  }
                                  else
                                  {
                                   $(".state_billing").html('<option>States Not Found</option>');
                                  }
                              }


                    }
                });
    });/*end of country function*/

    $(".state_billing").change(function(){

        var country = $('.country_billing').val();
        var state = $(this).val();

              $.ajax({
                    url:guest_url+'/common/get_cities/'+country+'/'+state,
                    method:'GET',
                    dataType:'json',
                    success:function(response)
                    {
                                 if(typeof(response)=='object') {

                                  if(response.status=='SUCCESS') {
                                      var option = '<option value="">Please Select city</option>';

                                      $(response.cities_arr).each(function(index,city)
                                      {

                                        option+='<option value="'+city.id+'">'
                                                         +city.city_title+'</option>';
                                      });

                                      $(".city_billing").html(option);
                                  }
                                  else
                                  {
                                   $(".city_billing").html('<option>City Not Found</option>');
                                  }
                              }


                    }
                });

    });/*end state function*/


    function buyer_id_proof_warning()
    {
        swal({
          title: "!",
        
           text: "Your age verification profile is still incomplete, please upload your proof of age and identity",

        
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = SITE_URL+"/buyer/age-verification";
          }
      });
    }


function buyer_redirect_login()
{
  window.location.href = SITE_URL+"/login";

}



$(window).scroll(function() {
if ($(window).scrollTop() > 300) {
    btn.addClass('show');
} else {
    btn.removeClass('show');
}
});

btn.on('click', function(e) {
e.preventDefault();
$('html, body').animate({scrollTop:0}, '300');
});




try {
     $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [
            "<i class='fa fa-caret-left'></i>",
            "<i class='fa fa-caret-right'></i>"
        ],
        autoplay: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
            items: 1
            },
            600: {
            items: 3
            },
            1000: {
            items: 5
            }
        }
        })
} catch (error) {
    console.log(error.message);
}


   $('#Continue').click(function(){

           if($('#modalform').parsley().validate()==false) return;

              var form_data = $('#modalform').serialize();

                  if($('#modalform').parsley().isValid() == true )
                  {

                    $.ajax({
                      url:SITE_URL+'/process_modal',
                      data:form_data,
                      method:'POST',

                      beforeSend : function()
                      {
                        /* showProcessingOverlay();*/
                        $('#Continue').prop('disabled',true);
                        $('#Continue').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                      },
                      success:function(response)
                      {

                        console.log(response);
                       /* hideProcessingOverlay();*/

                        if(typeof response =='object')
                        {
                          if(response.status && response.status=="SUCCESS")
                          {
                             window.location.href=SITE_URL;
                            
                          }
                          else if(response.status=="ERROR"){
                         /*   $("#showiperr").html(response.msg);
                            $("#showiperr").css('color','red');*/
                             window.location.href=SITE_URL;
                          }
                        }/*if type object*/
                      }/*success*/
                    });
                  }

  });/*end contirnue oclick function*/



  $('.navmega li a').hover(function (e) {
    e.preventDefault()
    $(this).tab('show');
});

$('.navmega li a').click(function (e) {
    return true;
});


function useCurrentlocation()
  {

     navigator.geolocation.getCurrentPosition(function(position) {

      var latlng = position.coords.latitude+ ","+position.coords.longitude;

      $.ajax({
      url: "https://maps.googleapis.com/maps/api/geocode/json",
      dataType: "json",
      data: {'latlng':latlng, 'sensor':true, 'key':"AIzaSyBYfeB69IwOlhuKbZ1pAOwcjEAz3SYkR-o"},
      type: "GET",
      success: function (data) {

         
          $.each(data.results[0].address_components, function( key, value ) {
            var short_names = value.short_name;

            switch(value.types[0])
            {
              case "postal_code": $("#postal_code").val(short_names);
                                  break;
              case "locality": $("#locality").val(short_names);
                                  break;
              case "administrative_area_level_1": $("#administrative_area_level_1").val(short_names);
                                  break;
              case "country": $("#country").val(short_names);
                                  break;
            }
          });
           if(data.plus_code.compound_code)
           {
            var addressarr = data.plus_code.compound_code.split(",");
            $("#autocompletestate").val(addressarr[1]);

              shopByCategory(addressarr[1]);
           }


        return false;
       },
      error: function (data) {
        $("#err_autocomplete").fadeIn(1000);
        $("#err_autocomplete").html("&#9888 Oops, Something went wrong!");
        return false;
      }
    });
    });
     return false;
  }


 /* on enter event call function */
    $('#product_search').keypress(function (e) {
     var key = e.which;
     if(key == 13)  /*  the enter key code */
      {

         var link ='';

         var query = $('#product_search').val();

            if(query)
            {

               var _token = "{{ csrf_token() }}";
                $.ajax({
                    url:SITE_URL+'/insert_suggestion_list',
                    type:"GET",
                    data:{search_item:query, _token:_token},
                   // dataType:'json',
                    success:function(data){

                    }

                });
            } //query



          var rating = $("#rating").val();
          var price = $("#price").val();
          var age_restrictions = $("#age_restrictions").val();
          var category = $("#category").val();
          var brands = $("#brands").val();
          var sellers = $("#sellers").val();
          var mg = $("#mg").val();
          if($('#filterby_price_drop').is(":checked"))
          {
            var filterby_price_drop = true;
          }
          else{
            var filterby_price_drop = false;
          }
          var state = $("#state").val();
          var city  = $("#city").val();
       
          var spectrum = $("#spectrum").val();
          var statelaw = $("#statelaw").val();

           if($('#best_seller').is(":checked"))
          {
            var best_seller = true;
          }
          else{
            var best_seller = false;
          }

            if($('#chows_choice').is(":checked"))
          {
            var chows_choice = true;
          }
          else{
            var chows_choice = false;
          }
          var reported_effects = $("#reported_effects").val();
          var cannabinoids = $("#cannabinoids").val();

          var featured_option = $("#featured_option").val();

                           if(query!='')
                            {
                                link = SITE_URL+'/search?product_search='+query+"&";
                            }else{
                               link += SITE_URL+'/search?';
                            }

                           if(age_restrictions!=''){
                             link += 'age_restrictions='+age_restrictions+"&";
                           }
                            if(brands)
                           {
                             link += 'brands='+brands+"&";
                           }
                             if(sellers)
                           {
                             link += 'sellers='+sellers+"&";
                           }
                            if(category)
                           {
                             link += 'category_id='+category+"&";
                           }
                             if(mg)
                           {
                             link += 'mg='+mg+"&";
                           }
                           if(price)
                           {
                             link += 'price='+price+"&";
                           }
                             if(rating)
                           {
                             link += 'rating='+rating+"&";
                           }
                           if(filterby_price_drop)
                           {
                             link += 'filterby_price_drop='+filterby_price_drop+"&" ;
                           }
                            if(state)
                           {
                             link += 'state='+state+"&";
                           }
                            if(city)
                           {
                             link += 'city='+city+"&";
                           }
                           if(spectrum)
                           {
                             link += 'spectrum='+spectrum+"&";
                           }
                            if(chows_choice)
                           {
                             link += 'chows_choice='+chows_choice+"&";
                           }

                           if(best_seller)
                           {
                             link += 'best_seller='+best_seller+"&";
                           }
                            if(statelaw)
                           {
                             link += 'statelaw='+statelaw+"&";
                           }
                           if(reported_effects)
                           {
                             link += '&reported_effects='+reported_effects;
                           }


                           if(cannabinoids)
                           {
                             link += '&cannabinoids='+cannabinoids;
                           }

                           if(featured_option)
                           {
                              link += '&featured='+featured_option;
                           }


                          window.location.href = link;



      }
    }); /*end of enter event*/


  /*function for btn search onclick*/
  $('#btn_search').click(function()
    {

       var link ='';
    
        var category = $('#category_search').val();
        var query = $('#product_search').val();

          if(query)
          {

             var _token = "{{ csrf_token() }}";
              $.ajax({
                  url:SITE_URL+'/insert_suggestion_list',
                  type:"GET",
                  data:{search_item:query, _token:_token},
                
                  success:function(data){
                  }

              });
          } 


        var rating = $("#rating").val();
        var price = $("#price").val();
        var age_restrictions = $("#age_restrictions").val();
        var category = $("#category").val();
        var brands = $("#brands").val();
        var sellers = $("#sellers").val();
        var mg = $("#mg").val();
        if($('#filterby_price_drop').is(":checked"))
        {
          var filterby_price_drop = true;
        }
        else{
          var filterby_price_drop = false;
        }
       var state = $("#state").val();
       var city = $("#city").val();
     
       var spectrum = $("#spectrum").val();
       var statelaw = $("#statelaw").val();

       var featured_option = $("#featured_option").val();

        if($('#best_seller').is(":checked"))
        {
          var best_seller = true;
        }
        else{
          var best_seller = false;
        }

         if($('#chows_choice').is(":checked"))
        {
          var chows_choice = true;
        }
        else{
          var chows_choice = false;
        }

        var reported_effects = $("#reported_effects").val();
        var cannabinoids = $("#cannabinoids").val();

                           if(query!='')
                            {
                                link = SITE_URL+'/search?product_search='+query+"&";
                            }else{
                               link += SITE_URL+'/search?';
                            }

                           if(age_restrictions!=''){
                             link += 'age_restrictions='+age_restrictions+"&";
                           }
                            if(brands)
                           {
                             link += 'brands='+brands+"&";
                           }
                             if(sellers)
                           {
                             link += 'sellers='+sellers+"&";
                           }
                            if(category)
                           {
                             link += 'category_id='+category+"&";
                           }
                             if(mg)
                           {
                             link += 'mg='+mg+"&";
                           }
                           if(price)
                           {
                             link += 'price='+price+"&";
                           }
                             if(rating)
                           {
                             link += 'rating='+rating+"&";
                           }
                           if(filterby_price_drop)
                           {
                             link += 'filterby_price_drop='+filterby_price_drop+"&" ;
                           }
                            if(state)
                           {
                             link += 'state='+state+"&";
                           }
                            if(city)
                           {
                             link += 'city='+city+"&";
                           }
                            if(spectrum)
                           {
                             link += 'spectrum='+spectrum+"&";
                           }
                            if(chows_choice)
                           {
                             link += 'chows_choice='+chows_choice+"&";
                           }
                           if(best_seller)
                           {
                             link += 'best_seller='+best_seller+"&";
                           }
                            if(statelaw)
                           {
                             link += 'statelaw='+statelaw+"&";
                           }
                           if(reported_effects)
                           {
                             link += '&reported_effects='+reported_effects;
                           }

                           if(cannabinoids)
                           {
                             link += '&cannabinoids='+cannabinoids;
                           }

                           if(featured_option)
                           {
                               link += '&featured='+featured_option;
                           }

                           window.location.href = link;


    });/*end*/



  function shopByCategory(state=NULL)
  {

    var statename ='';
    var url = SITE_URL+'/getShopByCategory';
    var state = state;
    if(state)
    {
      var statename = state;
       var url = SITE_URL+'/getShopByCategory/'+statename;
    }else{
      var statename ='';
       var url = SITE_URL+'/getShopByCategory';
    }

     $.ajax({
    
      url:url,
      type:"GET",
      async: false,
      success:function(response){
        var query = '';
       
        if(response.arr_category != undefined && response.arr_category.length > 0){
          $(response.arr_category).each((index,value)=>{
            var cat_name = ((value.product_type).replace(/ /g,'-')).replace('&','and');

            $("#category_list").append("<li><a href='"+SITE_URL+'/search?category_id='+cat_name+"'>"+value.product_type+"</a></li>");

            $("#category_list2").append("<li><a href='"+SITE_URL+'/search?category_id='+cat_name+"'>"+value.product_type+"</a></li>");

          });
        }
      }
     });

  }/*end*/

 function getShopBySpectrum()
 {
     $.ajax({
      url:SITE_URL+'/getShopBySpectrum',
      type:"GET",
      async: false,
      success:function(response){
        var query = '';

        if(response.arr_spectrum != undefined && response.arr_spectrum.length > 0){
          $(response.arr_spectrum).each((index,value)=>{

            var spectrumname = value.name.replace(/\s+/g, "-");

            $("#spectrum_list").append("<li><a href='"+SITE_URL+'/search?spectrum='+spectrumname+"'>"+value.name+"</a></li>");

            $("#spectrum_list2").append("<li><a href='"+SITE_URL+'/search?spectrum='+spectrumname+"'>"+value.name+"</a></li>");

          });
        }
      }
     });

 } /*end*/





  $('.linkhover').mouseenter(function(){
    $('body').addClass('linkoverlay');
  });

  $('.linkhover').mouseleave(function(){
    $('body').removeClass('linkoverlay');

  })

$('#mySidenav').on('click',function (){
    /*$("#sign_in_dropdown").toggleClass("openclass");*/
}); /*end*/


  var doc_width = $(window).width();
      
  if (doc_width > 1100) {
          $(document).ready(function(){
          $(".sub-menu").click(function(){
          $(".su-menu").toggleClass("shopcategory");
          });
          $(".sub-menu-new").click(function(){
          $(".su-menu").toggleClass("new");
          });
        });

        }
        var doc_width = $(window).width();
      if (doc_width < 1099) {

              $(".sub-menu").click(function(){
              $(".su-menu").toggleClass("active");
             });
               $(".sub-menu-new").click(function(event){
                event.stopPropagation();
                $(".sub-menu-new").removeClass("new");
                $(this).toggleClass("new");
             });


               $(".sub-menu").click(function(){
              $(".sub-menu").toggleClass("arrows");
             });
               $(".su-menu").click(function(event){
                event.stopPropagation();
             });

               $(".sub-menu-new").click(function(){
              $(this).toggleClass("showclicks");
             });
               $(".inner-su-menu").click(function(event){
                event.stopPropagation();
             });

          }


</script>


</body>
</html>







<!-- commented script -->

<!-- <script>
$(document).ready(function(){
  $(".sub-menu").click(function(){
    $(".sub-menu").toggleClass("shopcategory");
  });
});
</script> -->



{{-- <script>
    // $('#product_search').keypress(function (e) {
       //     var key = e.which;
       //     if(key == 13)  // the enter key code
       //      {
       //         var query = $('#product_search').val();

       //            if(query)
       //            {

       //               var _token = "{{ csrf_token() }}";
       //                $.ajax({
       //                    url:SITE_URL+'/insert_suggestion_list',
       //                    type:"GET",
       //                    data:{search_item:query, _token:_token},
       //                   // dataType:'json',
       //                    success:function(data){
       //                      alert(data);
       //                    }

       //                });
       //            } //query
       //      }
       //  });

/*function checkipaddress()
  {

     $.ajax({
      url:SITE_URL+'/checkipaddress',
      type:"GET",
      async: false,
       dataType:'json',
      success:function(response){
          if(typeof response =='object')
            {
              if(response.status && response.status=="SUCCESS")
              {
                 window.location.href=SITE_URL;
              }
              else if(response.status=="ERROR"){

              }
            }// if type object

      }
     });

  }//checkipaddress function
*/


</script> --}}



{{-- <script>
  // START Check Buyer Cart Product, Whether every possible status of the product is active or deactive

/*  setInterval(function(){
    $.ajax({
      url:'{{url('/')}}'+'/check_cart/verify_cart_products',
      data:{
        checkstat:1,
      },
      dataType:'json',
      success:function(response)
      {

      }
    });
  }, 5000);*/
  // END Check Buyer Cart Product, Whether every possible status of the product is active or deactive

/*
 setInterval(function(){
    $.ajax({
      url:'{{url('/')}}'+'/check_queueemails/send_queueemails',
      data:{
        checkstat:1,
      },
      dataType:'json',
      success:function(response)
      {

      }
    });
  }, 300000); // 5 min  300000
*/

</script> --}}