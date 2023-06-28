@extends('admin.layout.master')               
@section('main_content')
<style>.red{color:red;}  
   .chatonline img{height: 30px;}
   .btn-titless .my-profile-pgnm{float: left;}
   .btn-titless .closedispt {
    float: right;
    color: #e42828;
    text-decoration: underline;
    font-size: 14px;
    font-weight: normal;
}
.disputeis {
    float: right;
    color: #2a9c1c;
    font-size: 16px;
    font-weight: normal;
}
  .message-byuser{font-size: 12px;font-weight: bold;}
 </style>

<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                      <li class="active"><a href="{{ url(config('app.project.admin_panel_slug').'/order') }}">Manage Order</a></li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div> 
        <div class="btn-titless">
 
 @php 
 $dispute_finalised_status = ""; 
 $dispute_finalised_status = get_dispute_status($order_details['id']); 
 @endphp

<!-- <div class="my-profile-pgnm">Dispute Chat</div>
 --><div class="new-wrapper">
<!--   @if(isset($dispute_finalised_status) && $dispute_finalised_status==0)
  <a href="javascript:void(0)" class="btn btn-danger float-right" id="btn-close-dispute" onclick="return close_dispute('{{$order_details["id"]}}','{{$order_details["order_no"]}}')">Close Dispute</a>
  @else
  <h4 align="center" class="red">Dispute Closed!</h4>
  @endif

   <div class="order-main-dvs disputechat-main">
      <div class="message-main">
         <div class="dash-white-main">
            <div data-responsive-tabs class="verticalslide">
               <nav>
              <div class="search-member-block">
                     <input type="text" name="Search" placeholder="Search" />
                     <button type="submit"><img src="{{ url('/') }}/assets/images/message-search-icon.png" alt="" /> </button>
                  </div> 

                  <ul class="nav">
                     <li onclick="return getchatmessages('{{$order_details["buyer_details"]["id"] }}','buyer','{{$order_details["order_no"]}}','{{$order_details["id"]}}' )" id="buyer_li">
                        <a href="#tabone">
                        <span class="travles-img active">
                        <span class="travles-green">
                        </span>
                        @if(isset($order_details['buyer_details']['profile_image']) && $order_details['buyer_details']['profile_image']!='' && file_exists(base_path().'/uploads/profile_image/'.$order_details['buyer_details']['profile_image']))
                        <img src="{{$profile_img_path.'/'.$order_details['buyer_details']['profile_image']}}" alt="" width="50" height="50"/>
                        @else
                        <img src="{{url('/')}}/assets/images/avatar.png" alt="" width="50" height="50">
                        @endif
                        </span>
                        <span class="travles-name-blo">
                        <span class="travles-name-head"> {{isset($order_details['buyer_details']['first_name'])?$order_details['buyer_details']['first_name']:''}} {{isset($order_details['buyer_details']['last_name'])?$order_details['buyer_details']['last_name']:''}} </span>
                        <span class="travles-name-sub"> Buyer</span>
                        </span>
                        </a>
                     </li>
                 
                   
                     <li onclick="return getchatmessages({{$order_details['seller_details']['id'] }},'seller', '{{$order_details["order_no"]}}','{{$order_details["id"]}}')" id="seller_li">
                        <a href="#tabthree">
                        <span class="travles-img ">
                        <span class="travles-green"></span>
                        @if(isset($order_details['seller_details']['profile_image']) && $order_details['seller_details']['profile_image']!='' && file_exists(base_path().'/uploads/profile_image/'.$order_details['seller_details']['profile_image']))
                        <img src="{{$profile_img_path.'/'.$order_details['seller_details']['profile_image']}}" alt="" width="50" height="50"/>
                        @else
                        <img src="{{url('/')}}/assets/images/avatar.png" alt="" width="50" height="50">
                        @endif
                        </span>
                        <span class="travles-name-blo">
                        <span class="travles-name-head">{{isset($order_details['seller_details']['first_name'])?$order_details['seller_details']['first_name']:''}} {{isset($order_details['seller_details']['last_name'])?$order_details['seller_details']['last_name']:''}}</span>
                        <span class="travles-name-sub">Seller</span>
                        </span>
                        </a>
                     </li>
                  </ul>
               </nav>
               <div class="chat-travels-name">
                  Order No:  {{$order_details['order_no']}}
               </div>
               <div class="content">

               </div>
               <div class="clear"></div>
               <form id="chat-frm">
                  {{csrf_field()}}
                  <input type="hidden" name="receiver_id" id="receiver_id" value="{{ $order_details['buyer_details']['id'] }}">
                  <input type="hidden" name="order_id" id="order_id" value="{{$order_details['id'] or ''}}">    
                  <input type="hidden" name="order_no" id="order_no" value="{{$order_details['order_no'] or ''}}">
                  <input type="hidden" name="role" id="role" value="buyer">
                  @if(isset($dispute_finalised_status) && $dispute_finalised_status==0) 
                  <div class="write-message-block">
                     <input type="text" name="message" id="message" placeholder="Enter Message" data-parsley-required="true" data-parsley-required-message="Please enter message." />
                     <div class="disput-popup">
                        <div class="fileUpload">
                           <span><i class="fa fa-paperclip"></i></span>
                           <input type="file" class="upload" id="attachment" name="attachment"/>
                        </div>
                     </div>
                     <button class="send-message-btn" type="button" id="btn-send"  onclick="return sendMessage();"><i class="fa fa-paper-plane"></i></button>
                  </div>
                 @endif

               </form>
               <div class="clr"></div> -->

                 @if(isset($show_dispute_details['dispute_reason']) && !empty($show_dispute_details['dispute_reason']))
                   <span style="color: black;background-color: whitesmoke;"> Dispute Reason : {{ $show_dispute_details['dispute_reason'] }}</span> <br/> 
                 @endif



            @if(isset($dispute_finalised_status) && $dispute_finalised_status==0)
              <a href="javascript:void(0)" class="closedispt" id="btn-close-dispute" onclick="close_dispute('{{$order_details["id"]}}','{{$order_details["order_no"]}}')">Close Dispute</a>
            @elseif(isset($dispute_finalised_status) && $dispute_finalised_status==1)
             <div class="disputeis">Dispute Closed!</div>
            @endif 
         {{--   --}}
         
                 <div class="clearfix"></div>
                          <div class="chat-main-box">
                    <!-- .chat-left-panel -->
                    <div class="chat-left-aside">
                        <div class="open-panel"><i class="ti-angle-right"></i></div>
                        <div class="chat-left-inner">
                   <!--          <div class="form-material">
                                <input class="form-control p-20" type="text" placeholder="Search Contact"> </div> -->
                            <ul class="chatonline style-none ">
                                <li onclick="return getchatmessages('{{$order_details["buyer_details"]["id"] }}','buyer','{{$order_details["order_no"]}}','{{$order_details["id"]}}' )">
                                    <a href="javascript:void(0)" class="buyer_li"> </span>
                                      @if(isset($order_details['buyer_details']['profile_image']) && $order_details['buyer_details']['profile_image']!='' && file_exists(base_path().'/uploads/profile_image/'.$order_details['buyer_details']['profile_image']))
                                      {{-- <img src="{{$profile_img_path.'/'.$order_details['buyer_details']['profile_image']}}" alt="" width="50" height="50" class="img-circle" /> --}}

                                      @else
                                       {{-- <img src="{{url('/')}}/assets/images/avatar.png" alt="" width="50" height="50" class="img-circle"> --}}
                                      @endif 

                                    <span> {{isset($order_details['buyer_details']['first_name'])?$order_details['buyer_details']['first_name']:''}} {{isset($order_details['buyer_details']['last_name'])?$order_details['buyer_details']['last_name']:''}}
                                      <small class="text-success">Buyer</small></span></a>
                                </li>
                                <li onclick="return getchatmessages({{$order_details['seller_details']['id'] }},'seller', '{{$order_details["order_no"]}}','{{$order_details["id"]}}')">
                                    <a href="javascript:void(0)" class="seller_li"> 
                                    @if(isset($order_details['seller_details']['profile_image']) && $order_details['seller_details']['profile_image']!='' && file_exists(base_path().'/uploads/profile_image/'.$order_details['seller_details']['profile_image']))
                                       {{-- <img src="{{$profile_img_path.'/'.$order_details['seller_details']['profile_image']}}" alt="" width="50" height="50" class="img-circle" /> --}}
                                   @else
                                    {{-- <img src="{{url('/')}}/assets/images/avatar.png" alt="" width="50" height="50" class="img-circle"> --}}
                                   @endif
                                   {{-- {{dd($order_details)}} --}}
                                    <span>{{isset($order_details['seller_details']['seller_detail']['business_name'])?$order_details['seller_details']['seller_detail']['business_name']:''}} <small class="text-warning">Seller</small></span>
                                  </a>
                                </li>
                               
                                <li class="p-20"></li>
                            </ul>
                        </div>
                    </div>
                    <!-- .chat-left-panel -->
                        <!-- .chat-right-panel -->
                          <div class="chat-right-aside">
                              <div class="chat-main-header">
                                  <div class="p-20 b-b">
                                      <h3 class="box-title">Order No : {{isset($order_details['order_no'])?$order_details['order_no']:''}}</h3> </div>
                              </div>
                              <div class="chat-box">
                                    <div class="content chat-list slimscroll" >

                                   </div>
                              </div>

                                 <form id="chat-frm"  onsubmit="return false;">
                                  {{csrf_field()}}
                                  <input type="hidden" name="receiver_id" id="receiver_id" value="{{ $order_details['buyer_details']['id'] }}">
                                  <input type="hidden" name="order_id" id="order_id" value="{{$order_details['id'] or ''}}">    
                                  <input type="hidden" name="order_no" id="order_no" value="{{$order_details['order_no'] or ''}}">
                                  <input type="hidden" name="role" id="role" value="buyer">
                                            @if(isset($dispute_finalised_status) && $dispute_finalised_status==0) 
                                           <div class="write-message-block">
                                                <input type="text" placeholder="Enter Message..." id="message" name="message" data-parsley-required="true" data-parsley-required-message="Please enter message." onkeypress="HitEnter(event)"/>
                                                <div class="disput-popup">
                                                    <div class="fileUpload">
                                                        <span><i class="fa fa-paperclip"></i></span>
                                                        <input type="file" class="upload" id="attachment" name="attachment" />
                                                    </div>
                                                </div>
                                                <button class="send-message-btn" type="button" onclick="return sendMessage();"><i class="fa fa-paper-plane"></i></button>
                                            </div>
                                            @endif
                                   </form>         

                          </div>
                       <!-- .chat-right-panel -->
                </div>
            </div>
          </div>
                                      </div>






 <!-- .chat-row -->

                <!-- /.chat-row -->




</div></div>


 <script src="{{url('/')}}/assets/admin/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    {{-- <script src="{{url('/')}}/admin/js/waves.js"></script> --}}
    <!-- Custom Theme JavaScript -->
    <script src="{{url('/')}}/assets/admin/js/custom.min.js"></script>
    <script src="{{url('/')}}/assets/admin/js/chat.js"></script>

<script>
      var module_url_path  = "{{ $module_url_path or '' }}";
      var SITE_URL         = "{{ url('/') }}";

    $("#attachment").change(function() {
      readURL(this);

    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
              var current_date_time = moment(new Date()).utc().format("HH:mm A");

              var imagePreview = `<li class="odd">
              <div class="chat-image"> 
              // <img src="`+SITE_URL+`/assets/images/avatar.png" alt="" width="50" height="50"/>
              </div>
              <div class="chat-body">
                <div class="chat-text">
                  <p>
                    // <img src='`+e.target.result+`' width="200px;" height="200px;">
                  </p><b>`+current_date_time+`</b>
                 </div></div></li>`;
                
                $('.chat-list:last').append(imagePreview);
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
       var monthname   = monthNames[currentdate.getMonth()];
       var datetime    = currentdate.getDate() + "-"
               + (monthname)  + "-" 
               + currentdate.getFullYear() + " "  
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
       var html     = '';
       
       var usaTime = new Date().toLocaleString("en-US", {timeZone: "America/New_York"});
       usaTime = new Date(usaTime);
       var settimedate = moment(usaTime).format('DD-MMM-YYYY HH:mm a');
       
       //$('.chat-list').animate({scrollTop: $('.chat-list:last').prop("scrollHeight")}, 500);
   
       var latest_msg = `
          <li class="odd">
              <div class="chat-image"> 
             // <img src="`+SITE_URL+`/assets/images/avatar.png" alt="" width="50" height="50"/>
             </div>
               <div class="chat-body">
                  <div class="chat-text">
                  <p>
               `+message+`
                  </p><b>`+settimedate+`</b>
                 </div></div></li>
            `;


       

        

       var role =  $("#role").val();

       $.ajax({
           url: "{{ $module_url_path }}/SendMessage",            
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
             $("#message").val('');

              $(".chat-list").append(latest_msg);
              $('.chat-list:last').animate({scrollTop: $('.chat-list:last').prop("scrollHeight")}, 500);

               //$('.content:last').append(latest_msg);
              $('#no-msg-found').style.display='none';  
               var frm = $('#chat-frm')[0];
                frm.reset();
               


                if(role=="admin"){
                 $(".buyer_li").addClass("active");
                 $(".seller_li").removeClass("active");
                 }
                else{
                 $(".seller_li").addClass("active");
                 $(".buyer_li").removeClass("active");
                 
                }
               
           }    
       });        
   }

   function getchatmessages(id,role,orderno,orderid)
   {
       $("#receiver_id").val(id); 
       $("#role").val(role);
       var csrf_token = "{{ csrf_token()}}";
       var id         = $("#receiver_id").val();
 
        $.ajax({
           url:module_url_path+'/getchatmessages',            
           data:{id:id,role:role,orderno:orderno,orderid:orderid,_token:csrf_token},
           method:'POST',
           cache: false,         
           success:function(response){
            if(role=="buyer"){
             $('.content').addClass("buyerchatsection");
             $(".buyerchatsection").html(response);
             $(".buyer_li").addClass("active");
             $(".seller_li").removeClass("active");
             $(".content").removeClass("sellerchatsection");
             }
            else{
             $('.content').addClass("sellerchatsection");
             $(".sellerchatsection").html(response);
             $(".seller_li").addClass("active");
             $(".buyer_li").removeClass("active");
             $(".content").removeClass("buyerchatsection");
             
            } 

           }   
       });        
   }


   function close_dispute(order_id,order_no)
   {
      swal({
              title: 'Do you really want to close the dispute for this order?',
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: false
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                  var csrf_token = "{{ csrf_token()}}";

                  $.ajax({
                       url:module_url_path+'/close',            
                       data:{order_no:order_no,order_id:order_id,_token:csrf_token},
                       method:'POST',
                       cache: false,
                       beforeSend: function()
                        {      
                          showProcessingOverlay();
                        },         
                       success:function(response)
                       {
                          if(response.status == 'success')
                          { 
                             hideProcessingOverlay();

                             swal({
                                    title: 'Success',
                                    text: response.description,
                                    type: 'success',
                                    confirmButtonText: "OK",
                                    closeOnConfirm: true
                                 },
                                function(isConfirm,tmp)
                                {                       
                                    if(isConfirm==true)
                                    {
                                        window.location.reload();
                                    }
                                });
                          }
                          else
                          {                
                            swal('Error',response.description,'error');
                          }
                      }   
                  });   
              }
      });// end of confirm box        
   }
    $(document).ready(function() {
        var buyerid = "{{ $order_details['buyer_details']['id'] }}"
        var role    = 'buyer';
        var orderno = "{{ $order_details['order_no'] }}"
        var orderid = "{{ $order_details['id'] }}";


        getchatmessages(buyerid,role,orderno,orderid);

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

/********************* start of set interval of buyer************************************/
  
setInterval(function()
 {

        var buyerid = "{{ $order_details['buyer_details']['id'] }}"
        var role    = 'buyer';
        var orderno = "{{ $order_details['order_no'] }}"
        var orderid = "{{ $order_details['id'] }}";

        var csrf_token = "{{ csrf_token()}}";
        var id         = $("#receiver_id").val();


         $.ajax({
           url:module_url_path+'/getchatmessages',            
           data:{id:id,role:role,orderno:orderno,orderid:orderid,_token:csrf_token},
           method:'POST',
           cache: false,         
           success:function(response){
            if(role=="buyer"){               
               $('.content').addClass("buyerchatsection");
               $(".buyerchatsection").html(response);
               $(".buyer_li").addClass("active");
               $(".seller_li").removeClass("active");
             }
          
           } //responce   
       });        
 },5000);
 
/***************** end of buyer setinterval ******************************/

/******************start of seller set interval *********************/
/*
setInterval(function()
 {

        var sellerid = "{{ $order_details['seller_details']['id'] }}"
        var role    = 'seller';
        var orderno = "{{ $order_details['order_no'] }}"
        var orderid = "{{ $order_details['id'] }}";

        var csrf_token = "{{ csrf_token()}}";
        var id = sellerid;       

         $.ajax({
           url:module_url_path+'/getchatmessages',            
           data:{id:id,role:role,orderno:orderno,orderid:orderid,_token:csrf_token},
           method:'POST',
           cache: false,         
           success:function(response){
                  if(role=="seller"){
                   $('.content').addClass("sellerchatsection");
                   $(".sellerchatsection").html(response);
                   $(".seller_li").addClass("active");
                   $(".buyer_li").removeClass("active");
                 }
           
           }   
       });        
 },5000);*/

/*************** end of seller set inteval ********************************/

</script>

<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/customjs.js"></script>
@endsection

