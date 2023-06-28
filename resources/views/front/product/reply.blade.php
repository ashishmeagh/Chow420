{{--  

 @if(isset($comment[0]['reply_details']) && sizeof($comment[0]['reply_details'])>0)
                            @foreach($comment[0]['reply_details'] as $reply)
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


                             <div class="comments-mains sub-reply" id="showreplydiv">
                                <div class="comments-mains-left">
                                    <img src="{{ $user_profile_img }}" alt="">
                                </div>
                                <div class="comments-mains-right">
                                    <div class="txt-commnts"><span>
                                    {{isset($reply['user_details']['first_name'])?$reply['user_details']['first_name'] :''}} {{isset($reply['user_details']['last_name'])?$reply['user_details']['last_name']:''}}</span> {{isset($reply['reply'])?$reply['reply'] :''}}</div>
                                    <div class="times">{{isset($reply['created_at'])?$repleid_at:'-'}}</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                          @endforeach
                         @endif  
 --}}




                          @if(isset($comment) && sizeof($comment)>0)
                            @foreach($comment as $reply)
                               @php 

                                    $login_user = Sentinel::check();

                               
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


                             <div class="comments-mains sub-reply " id="showreplydiv_{{ $reply['comment_id'] }}">
                               {{--  <div class="comments-mains-left">
                                    <img src="{{ $user_profile_img }}" alt="">
                                </div> --}}
                                <div class="comments-mains-right">
                                    <div class="txt-commnts"><span>
                                    {{isset($reply['user_details']['first_name'])?$reply['user_details']['first_name'] :''}} {{isset($reply['user_details']['last_name'])?$reply['user_details']['last_name']:''}}</span>


                                     <!-------------start of reply edit functionality------------>

                                       <span id="spanreplyid_{{ $reply['id'] }}">{{isset($reply['reply'])?$reply['reply']:''}} </span>
                                       <div class="div-replaymain">
                                       <input type="text" name="editreply" class="form-control" id="replytext_{{ $reply['id'] }}" value="{{ $reply['reply'] }}" style="display: none" /> 

                                      @if($login_user == true && $reply['user_id']==$login_user->id)

                                            <a class="fa fa-edit editreply " id="editreply_{{ $reply['id'] }}" replyuser="{{ $reply['user_id'] }}"  replyid="{{ $reply['id'] }}" >
                                            </a>

                                            <a class="btn btn-info savereply replaybutton-usr" id="{{ $reply['id'] }}" replyuserid="{{ $reply['user_id'] }}" replycommentid="{{ $reply['comment_id'] }}" style="display: none">Save</a>
                                      @endif
                                    </div>

                                       <!----------end of reply functionality--------------->

{{--                                      {{isset($reply['reply'])?$reply['reply'] :''}}
 --}}

                                   </div>
                                    <div class="times">{{isset($reply['created_at'])?$repleid_at:'-'}}</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                          @endforeach
                         @endif  

<script>

    $(".reply").click(function()
    {
        var comment_id = $(this).attr('id');
        $("#reply_div_for_"+comment_id).addClass('show-comment');
    }); 
  </script>


  <script>
    

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

  </script>