 <style type="text/css">
   .whitebox-list.space-o-padding{padding-top: 10px;}

   .reply-a.reply{
    display: inline-block;
    color: #873dc8;
    font-size: 13px;
   }

 </style>

  <div class="whitebox-list space-o-padding spacebottom-o">
    @php
     $login_user = Sentinel::check();
     $user_type='';
     if(isset($login_user) && !empty($login_user))
     {
       $user_type = $login_user->user_type;

     }


     $product_id = $productid;

     $seller_product_ids = [];
    if($product_id!='')
    {

      $product_id = $product_id;
      if(count($seller_products)>0)
      {
         foreach($seller_products as $key=>$value)
         {
           $seller_product_ids[] = $value['id']; 
         }
      }

    }

   // dd($arr_comment);

   @endphp
                  
               {{--      <div class="titledetailslist pull-left">Comments 
                     
                      ( {{ isset($total_comments)?$total_comments:0}})
                    </div> --}} 

                    @if($total_comments > 5)
                    <a href="{{ url('/') }}/search/showcomments/{{ base64_encode($product_id) }}" class="viewallcomments pull-right" target="_blank">View All</a>
                    @endif


                    <div class="clearfix"></div>
                  

                     @if(isset($arr_comment) && sizeof($arr_comment)>0)
                      @foreach($arr_comment as $comment)
                        @php
                          $user_name = "";
                          if((isset($comment['user_details']['first_name']) && !empty($comment['user_details']['first_name'])) 
                            && isset($comment['user_details']['last_name']) && !empty($comment['user_details']['last_name']))
                          {  
                            $user_name = $comment['user_details']['first_name']." ".$comment['user_details']['last_name']; 
                          }else{

                             $user = Sentinel::check(); 

                              // if($user &&  $user->inRole('seller'))
                              // {
                              //   $user_name ='Seller';
                              // }else if($user && $user->inRole('buyer'))
                              // {
                              //   $user_name ='Buyer';
                              // }

                             if(isset($comment['user_details']))
                             {
                                if(isset($comment['user_details']['user_type']) && $comment['user_details']['user_type']=="seller")
                                {
                                  $user_name ='Seller';
                                }
                                else if(isset($comment['user_details']['user_type']) && $comment['user_details']['user_type']=="buyer")
                                {
                                  $user_name ='Buyer';
                                }
                                else
                                {
                                  $user_name ='User';
                                }
                             }//isset comment['user_details']



                          }//else 
 
                         if(isset($comment['user_details']['profile_image']) && $comment['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$comment['user_details']['profile_image']))
                        {
                          $user_profile_img = url('/uploads/profile_image/'.$comment['user_details']['profile_image']);
                        }
                        else
                        {                  
                          $user_profile_img = url('/assets/images/user-no-image.png');
                        }

                         $comment_added_at     = ''; 
                         $comment_added_at     = us_date_format($comment['created_at']);
                       @endphp
                      <div class="comments-mains profile-remove">
                          {{-- <div class="comments-mains-left">
                              <img src="{{$user_profile_img}}" alt="" />
                          </div> --}}
                          <div class="comments-mains-right update-right-class">
                              <div class="txt-commnts">
                                <span>{{$user_name}}</span>  

                                <!--------------start of edit comment functionality-------->
                                 <span id="spancommentid_{{ $comment['id'] }}">

                                  {{-- {{isset($comment['comment'])?$comment['comment']:''}}  --}} 

                                  <div class="hidecontent" id="hidecontent_{{ $comment['id'] }}">
                                    @if(isset($comment['comment']) && strlen($comment['comment'])>100)
                                     @php echo substr($comment['comment'],0,100) @endphp
                                    <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore({{ isset($comment['id'])?$comment['id']:'' }})">See more</span>
                                    @else
                                       @php 
                                         if(isset($comment['comment']))
                                         echo $comment['comment']; 
                                         else
                                          echo '';
                                       @endphp
                                    @endif
                                  </div>
                                    <span class="show-more-content" style="display: none" id="show-more-content_{{ isset($comment['id'])?$comment['id']:'' }}">
                                      @php
                                        if(isset($comment['comment']))
                                         echo $comment['comment']; 
                                         else
                                          echo ''; 
                                      @endphp
                                      <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless({{ isset($comment['id'])?$comment['id']:'' }})"  id="show-less_{{ isset($comment['id'])?$comment['id']:'' }}">See less</span>
                                    </span>
<script>

  function showmore(id)
  {
    $('#show-more-content_'+id).show();
     $('#show-less_'+id).show();
     $("#hidecontent_"+id).hide();
  }

   function showless(id)
  {
     $('#show-more-content_'+id).hide();
     $('#show-less_'+id).hide();
     $("#hidecontent_"+id).show();
  }

</script>


                                 </span>
                                 <div class="div-replaymain editcommits-dvs">
	                                 <input type="text" name="editcomment" class="form-control editcommenttext" id="commenttext_{{ $comment['id'] }}" commentuserid="{{ $comment['user_id'] }}" commentproductid="{{ $comment['product_id'] }}" commentid="{{ $comment['id'] }}"
                                    value="{{ $comment['comment'] }}" style="display: none" /> 

	                                @if($login_user == true && $comment['user_id']==$login_user->id)

	                                      <a title="Edit Comment" class="fa fa-edit editcomment reply-bks" id="editcomment_{{ $comment['id'] }}" commentuser="{{ $comment['user_id'] }}"  commentid="{{ $comment['id'] }}"  productid="{{ $comment['product_id'] }}">
	                                      </a>

	                                      <a class="btn btn-info savecomment" id="{{ $comment['id'] }}" commentuserid="{{ $comment['user_id'] }}" commentproductid="{{ $comment['product_id'] }}" style="display: none">Save</a>
	                                @endif
	                            </div>
                                <!----------end of edit comment functionality-------------->
                              </div>



                              @if($login_user == true && $login_user->inRole('seller') && in_array($product_id,$seller_product_ids)) 
                               <a href="javascript:void(0)" class="reply-a reply" id="{{$comment['id']}}">Answer</a>
                              @endif
                              <div class="times">{{isset($comment['created_at'])?$comment_added_at:"-"}}</div>


                             {{--  <form id="frm-send-reply" id="replyform"> --}}
                               <form>
                                {{ csrf_field() }}
                                <div class="white-cmmoit reply-cmts reply_div" id="reply_div_for_{{isset($comment['id'])?$comment['id']:0}}">

                                  <input type="text" name="reply" id="reply{{isset($comment['id'])?$comment['id']:0}}" class="reply-for-{{isset($comment['id'])?$comment['id']:0}}" placeholder="Write your answer" data-parsley-required="true" data-parsley-minlength="8" data-parsley-maxlength="150" >
                                  <span id="err_reply_{{ $comment['id'] }}"></span>
                                  <button class="btn-comments btn_send_reply" id="btn_send_reply{{isset($comment['id'])?$comment['id']:0}}" comment_id="{{isset($comment['id'])?$comment['id']:0}}">Send</button>
                                </div>
                             </form> 

                          </div>
                          <div class="clearfix"></div>
                          <!-------------------------start of showing reply-------------------------------------->
                         <div id="showreplydiv_{{$comment['id']}}">
                           @if(isset($comment['reply_details']) && sizeof($comment['reply_details'])>0)
                            @foreach($comment['reply_details'] as $reply)
                               @php 

                                $repleid_at = "";
                                $repleid_at = us_date_format($reply['created_at']);

                                 if(isset($reply['user_details']['profile_image']) && $reply['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$reply['user_details']['profile_image']))
                                 {
                                   $user_profile_img = url('/uploads/profile_image/'.$reply['user_details']['profile_image']);
                                 }
                                else
                                {                  
                                  $user_profile_img = url('/assets/images/user-no-image.png');
                                }  
                               @endphp

                           {{-- <div id="showreplydiv_{{$comment['id']}}"> --}}
                             <div class="comments-mains sub-reply" >
                               {{--  <div class="comments-mains-left">
                                    <img src="{{ $user_profile_img }}" alt="">
                                </div> --}}
                                <div class="comments-mains-right update-right-class">
                                    <div class="txt-commnts">
                                      <span class="txtfont-weight">

                                        @php 
                                           $setname = '';
                                         if(isset($reply['user_details']) && ($reply['user_details']['first_name']=="" || $reply['user_details']['last_name']=="")) 
                                         {
                                            // $setname = $reply['user_details']['email'];

                                             if($reply['user_details']['user_type']=="seller")
                                             {
                                                $setname = "Seller";
                                             }
                                             else
                                             {
                                               $setname = "Buyer";
                                             }


                                         }
                                        else if(isset($reply['user_details']) && ($reply['user_details']['first_name']!="" || $reply['user_details']['last_name']!="")) 
                                        {
                                           $setname = $reply['user_details']['first_name']." ".$reply['user_details']['last_name'];
                                        }
                                        else
                                        {
                                          $setname = 'User';
                                        }

                                        @endphp



                                         {{--   {{isset($reply['user_details']['first_name'])?$reply['user_details']['first_name'] :''}} {{isset($reply['user_details']['last_name'])?$reply['user_details']['last_name']:''}} --}}

                                         {{ $setname }}

                                      </span> 
                                      <!-------------start of reply edit functionality------------>

                                       <span id="spanreplyid_{{ $reply['id'] }}">

                                        {{--  {{isset($reply['reply'])?$reply['reply']:''}}  --}}



                                  <div class="hidecontent" id="hide_replaycontent_{{ $reply['id'] }}">
                                    @if(isset($reply['reply']) && strlen($reply['reply'])>100)
                                     @php echo substr($reply['reply'],0,100) @endphp
                                    <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmorereply({{ isset($reply['id'])?$reply['id']:'' }})">See more</span>
                                    @else
                                       @php 
                                         if(isset($reply['reply']))
                                         echo $reply['reply']; 
                                         else
                                          echo '';
                                       @endphp
                                    @endif
                                  </div>
                                    <span class="show-more-content" style="display: none" id="show-more-reply_content_{{ isset($reply['id'])?$reply['id']:'' }}">
                                      @php
                                        if(isset($reply['reply']))
                                         echo $reply['reply']; 
                                         else
                                          echo ''; 
                                      @endphp
                                      <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showlessreply({{ isset($reply['id'])?$reply['id']:'' }})"  id="show-less_reply_{{ isset($reply['id'])?$reply['id']:'' }}">See less</span>
                                    </span>
<script>

  function showmorereply(id)
  {
    $('#show-more-reply_content_'+id).show();
     $('#show-less_reply_'+id).show();
     $("#hide_replaycontent_"+id).hide();
  }

   function showlessreply(id)
  {
     $('#show-more-reply_content_'+id).hide();
     $('#show-less_reply_'+id).hide();
     $("#hide_replaycontent_"+id).show();
  }

</script>




                                       </span>
                                       <div class="div-replaymain">
                                         <input type="text" name="editreply" class="form-control" id="replytext_{{ $reply['id'] }}" value="{{ $reply['reply'] }}" style="display: none" /> 

                                        @if($login_user == true && $reply['user_id']==$login_user->id)

                                              <a title="Edit Comment" class="fa fa-edit editreply " id="editreply_{{ $reply['id'] }}" replyuser="{{ $reply['user_id'] }}"  replyid="{{ $reply['id'] }}" >
                                              </a>

                                              <a class="btn btn-info savereply replaybutton-usr" id="{{ $reply['id'] }}" replyuserid="{{ $reply['user_id'] }}" replycommentid="{{ $reply['comment_id'] }}" style="display: none">Save</a>
                                        @endif

                                        </div>
                                     {{--   {{isset($reply['reply'])?$reply['reply'] :''}} --}}

                                       <!----------end of reply functionality--------------->

                                     </div>
                                    <div class="times">{{isset($reply['created_at'])?$repleid_at:'-'}}</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                          {{-- </div>  --}}
 
                          @endforeach
                         @endif   
                        </div> 
                        <!-------------------------end of showing reply-------------------------------------->

                      </div>
                    @endforeach
                    @else
                       <div class="titledetailslist">
                          {{-- No Comments (0) --}}   
                           {{-- ({{ isset($total_comments)?$total_comments:0}}) --}}
                        </div>
                    @endif
                    
                     @php 
                
                     @endphp 

                   {{--  @if($login_user == true) --}}
                    {{--   @if($login_user->inRole('buyer')) --}}
                      <div class="white-cmmoit">
                          <form id="validation-form" onsubmit="return false">
                              {{ csrf_field() }}
                          <input type="hidden" name="product_id" id="product_id" value="{{ $product_id }}">
                          <input type="text" name="comment" id="comment"  class="commentstextarea" placeholder="Write your question" data-parsley-required="true" data-parsley-required-message="Please enter your question" data-parsley-minlength="8" data-parsley-maxlength="150"/>
                          {{-- <a href="#" class="btn-comments">Send</a> --}}
                          <button type="button" class="btn-comments" id="btn_add_comment">Send</button>
                         </form>
                      </div>

                   {{--   @elseif($login_user->inRole('seller') && isset($seller_product_ids) && (!(in_array($product_id, $seller_product_ids))))


                     <form id="validation-form">
                      {{ csrf_field() }}
                      <div class="white-cmmoit">
                          <input type="hidden" name="product_id" id="product_id" value="{{ $product_id }}">
                          <input type="text" name="comment" class="commentstextarea" id="comment" placeholder="Write your comment" data-parsley-required="true" data-parsley-required-message="Please enter your comment" data-parsley-minlength="8" data-parsley-maxlength="150"/>
                         <button type="button" class="btn-comments" id="btn_add_comment">Send</button>
                      </div>
                     </form> --}}
                    {{--  @endif --}}                     
                  {{--  @endif  --}}

                </div>


  <script>



var productid = "{{ $productid }}";


  $(document).on('click','.editcomment',function(){

      var commentid = $(this).attr('commentid');
      var commentuser = $(this).attr('commentuser');
      var productid = $(this).attr('productid');
      document.getElementById('spancommentid_'+commentid).style.display="none";
      document.getElementById('commenttext_'+commentid).style.display="block";
      document.getElementById('editcomment_'+commentid).style.display="none";
      document.getElementById(commentid).style.display="block";
  }); 
 
$('.savecomment').click(function()
{
      var commentid = $(this).attr('id');
      var commentuserid=$(this).attr('commentuserid');
      var commentproductid = $(this).attr('commentproductid');
      var commenttext = $("#commenttext_"+commentid).val();
      var csrf_token = "{{ csrf_token()}}";

         $.ajax({
            url: SITE_URL+'/comment/update',
            type:"POST",
            data: {commentid:commentid,product_id:commentproductid,comment:commenttext,_token:csrf_token},             
            dataType:'json',
            beforeSend: function()
            {   
             // showProcessingOverlay();
              $('.savecomment').prop('disabled',true);
              $('.savecomment').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');         
            },
            success:function(response)
            {
             // hideProcessingOverlay();
              $('.savecomment').prop('disabled',false);
              $('.savecomment').html('Send');
              if(response.status == 'SUCCESS')
              { 
                   showcomments(commentproductid);
                   $(this).addClass('active');
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 
           return false;

});


//on enter event edit comment posted function
$( ".editcommenttext" ).keypress(function( event ) {
  if ( event.which == 13 ) 
  {
   
      var commentid = $(this).attr('commentid');
      var commentuserid=$(this).attr('commentuserid');
      var commentproductid = $(this).attr('commentproductid');
      var commenttext = $(this).val();
      var csrf_token = "{{ csrf_token()}}";


         $.ajax({
            url: SITE_URL+'/comment/update',
            type:"POST",
            data: {commentid:commentid,product_id:commentproductid,comment:commenttext,_token:csrf_token},             
            dataType:'json',
            beforeSend: function()
            {   
             // showProcessingOverlay();
              $('.savecomment').prop('disabled',true);
              $('.savecomment').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');         
            },
            success:function(response)
            {
             // hideProcessingOverlay();
              $('.savecomment').prop('disabled',false);
              $('.savecomment').html('Send');
              if(response.status == 'SUCCESS')
              { 
                   showcomments(commentproductid);
                   $(this).addClass('active');
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 
           return false;

  }//if 13
}) 


  

  $(document).on('click','.editreply',function(){

      var replyid = $(this).attr('replyid');
      var replyuser = $(this).attr('replyuser');
      document.getElementById('spanreplyid_'+replyid).style.display="none";
      document.getElementById('replytext_'+replyid).style.display="block";
      document.getElementById('editreply_'+replyid).style.display="none";
      document.getElementById(replyid).style.display="block";
  }); 

 $(".savereply").click(function(){


      var replyid = $(this).attr('id');
      var replyuser=$(this).attr('replyuserid');
      var replytext = $("#replytext_"+replyid).val();
      var replycommentid = $(this).attr('replycommentid');
      var csrf_token = "{{ csrf_token()}}";

           $.ajax({
                  url: SITE_URL+'/comment/update_reply',
                  type:"POST",
                  data: {replyid:replyid,comment_id:replycommentid,reply:replytext,_token:csrf_token},             
                  dataType:'json',
                  beforeSend: function(){   
                    //showProcessingOverlay();    
                    $('.savereply').prop('disabled',true);
                    $('.savereply').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');      
                  },
                  success:function(response)
                  {
                   // hideProcessingOverlay();
                    $('.savereplysavereply').prop('disabled',false);
                    $('.savereply').html('Send');
                    
                    if(response.status == 'SUCCESS')
                    { 
                          showrreply(replycommentid);
                          //$("#reply_div_for_"+replycommentid).hide();
                         // $(this).removeClass('show-comment');
                          $(".editreply"+replyid).show();
                    }
                    else
                    {                
                      swal('Error',response.description,'error');
                    }  
                  }  

                 }); // ajax function end


 });



   

      $('.commentstextarea').click(function(){
            var login_id = "{{ $login_user->id or '' }}";
            var user_type = "{{ $user_type or '' }}";

            if(login_id.trim()=='')
            {
              window.location.href="{{ url('/') }}/login";
            }
            

       });

      //on enter event comment posted function
      $( ".commentstextarea" ).keypress(function( event ) {
        if ( event.which == 13 ) 
        {

            if($('#validation-form').parsley().validate()==false) return;
     
             var productid = "{{ $productid }}";

             var csrf_token = "{{ csrf_token()}}";
             var product_id = $("#product_id").val();
             var comment    = $("#comment").val();

             var login_id = "{{ $login_user->id or '' }}";
             var user_type = "{{ $user_type or '' }}";

             if(login_id.trim()=='')
            {
              window.location.href="{{ url('/') }}/login";
            }
            else{
               $.ajax({
                    url: SITE_URL+'/comment/store',
                    type:"POST",
                    data: {product_id:product_id,comment:comment,_token:csrf_token},             
                    dataType:'json',
                    beforeSend: function()
                    {   
                     // showProcessingOverlay();
                      $('#btn_add_comment').prop('disabled',true);
                      $('#btn_add_comment').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');         
                    },
                    success:function(response)
                    {
                     // hideProcessingOverlay();
                      $('#btn_add_comment').prop('disabled',false);
                      $('#btn_add_comment').html('Send');
                      if(response.status == 'SUCCESS')
                      { 
                           showcomments(productid);
                           $(this).addClass('active');
                           $( "#ques_div" ).load(window.location.href + " #ques_div" );
                      }
                      else
                      {                
                        swal('Error',response.description,'error');
                        setTimeout(function(){
                            window.location.reload();
                        },3000);
                      }  
                    }  

                   }); 
                   return false;
              }//else of login        
        }//if 13
      });




     //function for add comment
     $('#btn_add_comment').click(function()
      { 

       if($('#validation-form').parsley().validate()==false) return;
     
         var productid = "{{ $productid }}";

         var csrf_token = "{{ csrf_token()}}";
         var product_id = $("#product_id").val();
         var comment    = $("#comment").val();

         var login_id = "{{ $login_user->id or '' }}";
         var user_type = "{{ $user_type or '' }}";

         if(login_id.trim()=='')
        {
          window.location.href="{{ url('/') }}/login";
        }
        else{
           $.ajax({
                url: SITE_URL+'/comment/store',
                type:"POST",
                data: {product_id:product_id,comment:comment,_token:csrf_token},             
                dataType:'json',
                beforeSend: function()
                {   
                 // showProcessingOverlay();
                  $('#btn_add_comment').prop('disabled',true);
                  $('#btn_add_comment').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');         
                },
                success:function(response)
                {
                 // hideProcessingOverlay();
                  $('#btn_add_comment').prop('disabled',false);
                  $('#btn_add_comment').html('Send');
                  if(response.status == 'SUCCESS')
                  { 
                       showcomments(productid);
                       $(this).addClass('active');
                       $( "#ques_div" ).load(window.location.href + " #ques_div" );
                     
                  }
                  else
                  {                
                    swal('Error',response.description,'error');
                    setTimeout(function(){
                        window.location.reload();
                    },3000);
                  }  
                }  

               }); 
               return false;
          }//else of login
       
     }); 
 



    $(".reply").click(function()
    {
      
        var comment_id = $(this).attr('id');
        $("#reply_div_for_"+comment_id).show();
        $(".reply-for-"+comment_id).val('');
        //$("#reply_div_for_"+comment_id).addClass('show-comment');
    }); 

  function showrreply(comment_id) {
    
    var id   = comment_id;
    var csrf_token = "{{ csrf_token()}}";

    $.ajax({
          url: SITE_URL+'/showrreply',
          type:"POST",
          data: {comment_id:id,_token:csrf_token},             
         // dataType:'json',
          beforeSend: function(){            
          },
          success:function(response)
          {
          //  updateDiv();
          //alert(response);
            $("#showreplydiv_"+id).html(response);
            $("#showreplydiv_"+id).show();
            $("#reply_div_for_"+id).hide();
          }  

      });
  }


//   function updateDiv()
// { 
//     $( ".showtabcomments" ).load(window.location.href + " #showtabcomments" );
// }


      $('.btn_send_reply').click(function()
      {   

        // if($('#frm-send-reply').parsley().validate()==false) return;     

         var csrf_token = "{{ csrf_token()}}";
         var comment_id = $(this).attr('comment_id');
         var reply      = $(".reply-for-"+comment_id).val();
         var flag1=0;

          if(reply.trim()==""){

            $("#err_reply_"+comment_id).html('Please enter answer');
            $("#err_reply_"+comment_id).css('color','red');
            flag1 = 1;
            return false;
         }else{
            $("#err_reply_"+comment_id).html(' ');
            flag1 =0;
          }

              if(flag1==0){

                 $.ajax({
                  url: SITE_URL+'/comment/send_reply',
                  type:"POST",
                  data: {comment_id:comment_id,reply:reply,_token:csrf_token},             
                  dataType:'json',
                  beforeSend: function(){   
                    //showProcessingOverlay();    
                    $('.btn_send_reply').prop('disabled',true);
                    $('.btn_send_reply').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');      
                  },
                  success:function(response)
                  {
                   // hideProcessingOverlay();
                    $('.btn_send_reply').prop('disabled',false);
                    $('.btn_send_reply').html('Send');
                    
                    if(response.status == 'SUCCESS')
                    { 
                          showrreply(comment_id);
                          $("#reply_div_for_"+comment_id).hide();
                          $(this).removeClass('show-comment');
                          $( "#ques_div" ).load(window.location.href + " #ques_div" );
                    }
                    else
                    {                
                      swal('Error',response.description,'error');
                    }  
                  }  

                 }); // ajax function end
               }else{
                 return false;
               }

         // } // else
         return false;
       
     }); 



      $('#stars li').click(function(){
         var rating = $(this).data('value'); 
         $("#err_rating").html("");
         $("#rating").val(rating);
      });

       $('.reviewtitle').click(function(){
            var login_id = "{{ $login_user->id or '' }}";
            var user_type = "{{ $user_type or '' }}";

            if(login_id.trim()=='')
            {
              window.location.href="{{ url('/') }}/login";
            }
            

        });
       $('.reviewdesc').click(function(){

           var login_id = "{{ $login_user->id or '' }}";
            var user_type = "{{ $user_type or '' }}";

            if(login_id.trim()=='')
            {
              window.location.href="{{ url('/') }}/login";
            }

        });

      

      // This is working function
      $('#btn_send_review').click(function()
      { 

         var flag1= 0; var flag2= 0;var flag3=0;
       // var rating = $("#rating").val();
        var rating = $("#rating_star").val();
        var title = $("#title").val();
        var review = $("#review").val();
        
        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          //return false; 
          flag1 =1;
        }else{
          $("#err_rating").html('');
          flag1 =0;
        }
        if(title=='')
        {
         $("#titleerr").html('Please enter title');
         $("#titleerr").css('color','red');
         flag2 =1;
         // return false; 
        }else{
          $("#titleerr").html('');
          flag2 =0;
        }     
        if(review=='')
        {
         $("#reviewerr").html('Please enter review');
         $("#reviewerr").css('color','red');
         flag3 = 1;
          //return false; 
        }else{
          $("#reviewerr").html('');
          flag3 =0;
        }
         

       // if($('#frm-add-review').parsley().validate()==false) return;
     if(flag1==0 && flag2==0 && flag3==0){

        // var form_data   = $('#frm-add-review').serialize(); 
        var form_data   = $('#frm-add-review').serializeArray(); 
        form_data.push({name: 'rating', value: rating});

        var csrf_token = "{{ csrf_token()}}";

        var login_id = "{{ $login_user->id or '' }}";
        var user_type = "{{ $user_type or '' }}";

        if(login_id.trim()=='')
        {
          window.location.href="{{ url('/') }}/login";
        }
        else if(login_id.trim()!='' && user_type!='' && user_type=="seller")
        {

          swal({
            title: 'Warning',
            text: "You can not add reviews!",
            type: 'warning',
            showConfirmButton:false,
            confirmButtonText: 'Yes, delete it!'
          })
          
            setTimeout(function(){
                        window.location.reload();

            },4000);
        
        }
        else
        {
     
        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/store',
            type:"POST",
            data: form_data,     
           // data:{ title:title,review:review,rating:rating,product_id:product_id },        
            dataType:'json',
            beforeSend: function(){ 
             //showProcessingOverlay();
             $('#btn_send_review').prop('disabled',true);
             $('#btn_send_review').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');

            },
            success:function(response)
            {
              // hideProcessingOverlay();
              $('#btn_send_review').prop('disabled',false);
              $('#btn_send_review').html('Send Review');
              if(response.status == 'SUCCESS')
              { 
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
                       // window.location.reload();
                       $("#reviewform").hide();
                       showreviews(productid);
                        $(this).addClass('active');
                        $( "#review_div" ).load(window.location.href + " #review_div" );

                      }

                    });
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); //ajax
          }//else of login conditions

          }else{
           return false;
          }
       
     }); 

        

 


  $(document).ready(function(){

  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    responseMessage(msg);
    
  });
  
  
});


function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}




</script>
{{--  <script src="{{url('/')}}/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>
<script>
         $('#horizontalTab').easyResponsiveTabs({
            
           type: 'default', //Types: default, vertical, accordion           
           width: 'auto', //auto or any width like 600px
           fit: true, // 100% fit in a container
           closed: 'accordion', // Start closed if in accordion view
           activate: function(event) { // Callback function if tab is switched
               var $tab = $(this);
               var $info = $('#tabInfo');
               var $name = $('span', $info);
         
               $name.text($tab.text());                    
               $info.show();

           }
         });
</script> --}}
 <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/jquery.flexisel.js"></script>
    <script type="text/javascript">
        
    $(window).load(function() {
    $("#flexiselDemo1").flexisel();
    $("#flexiselDemo2").flexisel({
    visibleItems: 7,
    itemsToScroll: 1,
    animationSpeed: 200,
    infinite: true,
    navigationTargetSelector: null,
    autoPlay: {
    enable: false,
    interval: 5000,
    pauseOnHover: true
    },
    
    responsiveBreakpoints: {
    portrait: {
    changePoint:480,
    visibleItems: 1,
    itemsToScroll: 1
    },
    landscape: {
    changePoint:640,
    visibleItems: 3,
    itemsToScroll: 2
    },
    tablet: {
    changePoint:768,
    visibleItems: 7,
    itemsToScroll: 3
    },
    laptop: {
        changePoint: 1370,
        visibleItems: 6
    }
    }
    });

    
    });

  </script>              

