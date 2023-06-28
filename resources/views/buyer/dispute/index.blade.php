@extends('buyer.layout.master')
@section('main_content')
<style>
  .red{color:red;}
  .message-byuser{font-size: 12px;font-weight: bold;}

</style>

 @php 
 $dispute_finalised_status = ""; 
 $dispute_finalised_status = get_dispute_status($order_details['id']); 
 @endphp
<div class="my-profile-pgnm">Dispute Chat </div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">
   @if(isset($dispute_finalised_status) && $dispute_finalised_status==1)
      <h4 align="center" class="red">Dispute Closed!</h4>
   @endif


   <div class="order-main-dvs disputechat-main">
      <div class="message-main">
         <div class="dash-white-main">
            <div data-responsive-tabs class="verticalslide">
               <nav>
<!--                   <div class="search-member-block">
                     <input type="text" name="Search" placeholder="Search" />
                     <button type="submit"><img src="{{ url('/') }}/assets/images/message-search-icon.png" alt="" /> </button>
                  </div> -->
                  <ul class="content-d">
                     <li onclick="return getchatmessages({{$admin_details['id'] }},'admin',' {{$order_details['order_no']}} ',' {{$order_details["id"]}} ' )" id="admin_li">
                        <a href="#tabone">
                        {{-- <span class="travles-img active"> --}}
                       {{--  <span class="travles-green">
                        </span> --}}
                        {{-- @if(isset($admin_details['profile_image']) && $admin_details['profile_image']!='' && file_exists(base_path().'/uploads/profile_image/'.$admin_details['profile_image'])) --}}
                        {{-- <img src="{{$profile_img_path.'/'.$admin_details['profile_image']}}" alt="" /> --}}
                        {{-- @else --}}
                        {{-- <img src="{{url('/')}}/assets/images/avatar.png" alt=""> --}}
                        {{-- @endif --}}
                        {{-- </span> --}}
                        <span class="travles-name-blo">
                        <span class="travles-name-head"> {{isset($admin_details['first_name'])?$admin_details['first_name']:''}} {{isset($admin_details['last_name'])?$admin_details['last_name']:''}} </span>
                        <span class="travles-name-sub"> Admin</span>
                        </span>
                        </a>
                     </li>
                      
                     <li onclick="return getchatmessages({{$order_details['seller_details']['id'] }},'seller', '{{$order_details["order_no"]}}','{{$order_details["id"]}}')" id="seller_li">
                        <a href="#tabthree">
                        <!-- <span class="travles-img ">
                        <span class="travles-green"></span>
                        {{-- @if(isset($order_details['seller_details']['profile_image']) && $order_details['seller_details']['profile_image']!='' && file_exists(base_path().'/uploads/profile_image/'.$order_details['seller_details']['profile_image'])) --}}
                        <img src="{{$profile_img_path.'/'.$order_details['seller_details']['profile_image']}}" alt="" />
                        {{-- @else --}}
                        <img src="{{url('/')}}/assets/images/avatar.png" alt="">
                        {{-- @endif --}}
                        </span> -->
                         {{-- <img class="avatar-profile-seller" src="{{url('/')}}/assets/images/avatar.png" alt=""> --}}
                        <span class="travles-name-blo">
                        <span class="travles-name-head">{{isset($order_details['seller_details']['seller_detail']['business_name'])?$order_details['seller_details']['seller_detail']['business_name']:''}} </span>
                        <span class="travles-name-sub">Seller</span>
                       </span>

                        </a>
                     </li>
                  </ul>
               </nav>
               <div class="chat-travels-name">
                  Order No :  {{$order_details['order_no']}}
               </div>
            
               <div class="content">
                  <section id="tabone" class="adminchatsection">
                       {{--  <script>
                             setInterval(function()
                             {
                                    var adminid = "{{ $admin_details['id'] }}"
                                    var role    = 'admin';
                                    var orderno = "{{ $order_details['order_no'] }}"
                                    var orderid = "{{ $order_details['id'] }}"

                                    var csrf_token = "{{ csrf_token()}}";
                                    var id = $("#receiver_id").val();
                                    

                                    $.ajax({
                                       url:SITE_URL+'/buyer/dispute/getchatmessages',            
                                       data:{id:id,role:role,orderno:orderno,orderid:orderid,_token:csrf_token},
                                       method:'POST',
                                       cache: false,         
                                       success:function(response){                                       
                                           $(".adminchatsection").html(response);
                                       }   
                                   });                                        
                             },1000);
                        </script> --}}
                  </section>
               
                  <section id="tabthree" class="sellerchatsection">

                   

                    
                  </section>
               
               </div>
               <div class="clear"></div>

               <form id="chat-frm" onsubmit="return false;">
                  {{csrf_field()}}
                  <input type="hidden" name="receiver_id" id="receiver_id" value="{{ $admin_details['id'] }}">
                  <input type="hidden" name="order_id" id="order_id" value="{{$order_details['id'] or ''}}">    
                  <input type="hidden" name="order_no" id="order_no" value="{{$order_details['order_no'] or ''}}">
                  <input type="hidden" name="role" id="role" value="admin">
    

                  @if(isset($dispute_finalised_status) && $dispute_finalised_status==0)
                  <div class="write-message-block">
                     <input type="text" name="message" id="message" placeholder="Enter Message..." data-parsley-required="true" data-parsley-required-message="Please enter message." onkeypress="HitEnter(event)" />
                     <div class="disput-popup">
                        <div class="fileUpload">
                           <span><i class="fa fa-paperclip"></i></span>
                           <input type="file" class="upload" id="attachment" name="attachment"/>
                        </div>
                     </div>
                     <button class="send-message-btn" type="button" id="btn-send"  onclick="sendMessage();"><i class="fa fa-paper-plane"></i></button>
                  </div>
                  @endif
               </form>

               <div class="clr"></div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>

       //upload attachment
    $("#attachment").change(function() {
      readURL(this);

    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
              var current_date_time = moment(new Date()).utc().format("HH:mm A");

              var imagePreview = `<div class="right-message-block left-message-block">    
                  <div class="rights-message-profile">
                  <img src="`+SITE_URL+`/assets/images/avatar.png" alt="" />

                 </div>                       
                  <div class="left-message-content">
                    <div class="actual-message">
                          <img src='`+e.target.result+`' width="200px;" height="200px;">
                        </div>
                        <div class="message-time">
                           `+current_date_time+`
                    </div>
                        
                  </div>
                </div>`;
                
                $('.chat_box:last').append(imagePreview);
                $('#no-msg-found').hide();   

                //call send message function to send attachment
                sendMessage('exFlage');          
               var s = $("div.messages-section");
               s.scrollTop(s[0].scrollHeight);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

   function HitEnter(event) {
     var x = event.which || event.keyCode;
     if(x==13){

      if($('#chat-frm').parsley().validate()==false) return ;
      sendMessage();
     }
    }  

   function sendMessage(exFlage = false)
   {

      const monthNames = ["Jan", "Feb", "March", "April", "May", "June",
                               "July", "Aug", "Sept", "Oct", "Nov", "Dec"
                              ];
       if($('#chat-frm').parsley().validate()==false) return;
       var currentdate = new Date(); 
       var monthname = monthNames[currentdate.getMonth()];
       var datetime = currentdate.getDate() + "-"
               + (monthname)  + "-" 
               + currentdate.getFullYear() + "  "  
               // + currentdate.getHours() + ":"  
               // + currentdate.getMinutes() + ":" 
               // + currentdate.getSeconds(); 
               + moment().format('hh:mm a')
   
       var message           = $('#message').val();
       var chatdata          = new FormData($('#chat-frm')[0]);
       var current_date_time = datetime;
       var buyer_profile_img = $('#buyer_img').attr('src');        
       var receiver_id       = $('#receiver_id').val();
       $('#attachment').val(''); 
        if(exFlage == false)
        {
          if($('#chat-frm').parsley().validate()==false) return;
        }
     
       var scrolled = 0;
       var html = '';
       
       
       //$('.chat_box:last').animate({scrollTop: $('.chat_box:last').prop("scrollHeight")}, 500);
   
       // var latest_msg = `<div class="right-message-block left-message-block">
       //    <div class="rights-message-profile">
       //      <img src="`+SITE_URL+`/assets/images/avatar.png" alt="" />
       //    </div>
       //    <div class="left-message-content">    
       //    <img src="`+SITE_URL+`/assets/images/message-arrow-left.png" alt="" class="arrow-message-left">          
       //       <div class="actual-message">
       //         `+message+`
       //       </div>
       //       <div class="message-time">
       //          `+current_date_time+`
       //       </div>
       //    </div>
       // </div>`;

        var latest_msg = `<div class="right-message-block left-message-block">
          <div class="rights-message-profile">
            // <img src="`+SITE_URL+`/assets/images/avatar.png" alt="Profile Image" />
          </div>
          <div class="left-message-content">    
          // <img src="`+SITE_URL+`/assets/buyer/images/message-arrow-right.png" alt="" class="arrow-message-right">          
             <div class="actual-message">
               `+message+`
             </div>
             <div class="message-time">
                `+current_date_time+`
             </div>
          </div>
       </div>`;


       var role =  $("#role").val();

       $.ajax({
           url:SITE_URL+'/buyer/dispute/SendMessage',            
           data:chatdata,
           method:'POST',
           dataType:'json',
           contentType:false,
           processData:false,
           cache: false,
           beforeSend: function() {
             showProcessingOverlay();
           },
           success:function(response){
             hideProcessingOverlay(); 
            if(exFlage==false) {

               $('.chat_box:last').append(latest_msg);
               $('#no-msg-found').hide(); 
               $('.chat_box:last').animate({scrollTop: $('.chat_box:last').prop("scrollHeight")}, 500);

            

             //  window.location.reload();              
             /*  var d = $("div.messages-section");
               d.scrollTop(d[0].scrollHeight);  */
               //clear the form
               var frm = $('#chat-frm')[0];
               frm.reset();
              } 

                if(role=="admin"){
                 $(".admin_li").addClass("active");
                 $(".seller_li").removeClass("active");
                 }
                else{
                 $(".seller_li").addClass("active");
                 $(".admin_li").removeClass("active");
                 
                }
               
           }   
       });        
   }

   function getchatmessages(id,role,orderno,orderid) 
   {
       $("#receiver_id").val(id); 

       var id = $("#receiver_id").val();

       $("#role").val(role);
       var csrf_token = "{{ csrf_token()}}";
 
        $.ajax({
           url:SITE_URL+'/buyer/dispute/getchatmessages',            
           data:{id:id,role:role,orderno:orderno,orderid:orderid,_token:csrf_token},
           method:'POST',
           cache: false,         
           success:function(response){
            if(role=="admin"){
             $(".adminchatsection").html(response);
             $(".admin_li").addClass("active");
             $(".seller_li").removeClass("active");
             }
            else{
             $(".sellerchatsection").html(response);
             $(".seller_li").addClass("active");
             $(".admin_li").removeClass("active");
             
            }

           }   
       });        
   }

 /************new set interval function added to get the admin msgs******/



    setInterval(function()
     {
            var adminid = "{{ $admin_details['id'] }}"
            var role    = 'admin';
            var orderno = "{{ $order_details['order_no'] }}"
            var orderid = "{{ $order_details['id'] }}"

            var csrf_token = "{{ csrf_token()}}";
            var id = $("#receiver_id").val();
            

            $.ajax({
               url:SITE_URL+'/buyer/dispute/getchatmessages',            
               data:{id:id,role:role,orderno:orderno,orderid:orderid,_token:csrf_token},
               method:'POST',
               cache: false,         
               success:function(response){
                if(role=="admin"){
                   $(".adminchatsection").html(response);
                   $(".admin_li").addClass("active");
                   $(".seller_li").removeClass("active");
                 }
               }   
           });        

               
     },5000);


                        
    setInterval(function()
     {
            var seller_id = "{{ $order_details['seller_details']['id'] }}"
            var role    = 'seller';
            var orderno = "{{ $order_details['order_no'] }}"
            var orderid = "{{ $order_details['id'] }}"

            var csrf_token = "{{ csrf_token()}}";
           // var id = $("#receiver_id").val();
            var id= seller_id;
            

            $.ajax({
               url:SITE_URL+'/buyer/dispute/getchatmessages',            
               data:{id:id,role:role,orderno:orderno,orderid:orderid,_token:csrf_token},
               method:'POST',
               cache: false,         
               success:function(response){           
                  if(role=="seller"){
                   $(".sellerchatsection").html(response);
                   $(".seller_li").addClass("active");
                   $(".admin_li").removeClass("active");
                  }
                 
                }   
           });        

               
     },5000);


/******************************************************/




   
   $(document).ready(function() {
        var receiver_id = $("#receiver_id").val();
        
   
        var adminid = "{{ $admin_details['id'] }}"
        var role    = 'admin';
        var orderno = "{{ $order_details['order_no'] }}"
        var orderid = "{{ $order_details['id'] }}"
        getchatmessages(receiver_id,role,orderno,orderid);

       var stickyNavTop = $('.header-afterlogin').offset().top;
   
       var stickyNav = function() {
           var scrollTop = $(window).scrollTop();
   
           if (scrollTop > stickyNavTop) {
               $('.header-afterlogin').addClass('sticky');
           } else {
               $('.header-afterlogin').removeClass('sticky');
           }
       };
       stickyNav();
   
       $(window).scroll(function() {
           stickyNav();
       });
   })
   // Header AfterLogin sticky End
</script>
<script>
   /*responsive tab start here*/
   $(document).ready(function () {
       $(document).on('responsive-tabs.initialised', function (event, el) {
           console.log(el);
       });
   
       $(document).on('responsive-tabs.change', function (event, el, newPanel) {
           console.log(el);
           console.log(newPanel);
       });
   
       $('[data-responsive-tabs]').responsivetabs({
           initialised: function () {
               console.log(this);
           },
   
           change: function (newPanel) {
               console.log(newPanel);
           }
       });
   });
</script>
<!-- custom scrollbar plugin -->
<script type="text/javascript" src="{{url('/')}}/assets/front/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript">
   /*scrollbar start*/
   (function ($) {
   
       $(window).on("load", function () {
   
           $.mCustomScrollbar.defaults.scrollButtons.enable = true; //enable scrolling buttons by default
           $.mCustomScrollbar.defaults.axis = "yx"; //enable 2 axis scrollbars by default
   
           $(".content-d, .messages-section-main").mCustomScrollbar({
               theme: "dark"
           });
       });
   })(jQuery);
</script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/customjs.js"></script>
@endsection

