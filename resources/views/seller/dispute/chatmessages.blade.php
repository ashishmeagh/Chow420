
 						<div class="messages-section-main">
                        @if(isset($chat_arr) && count($chat_arr)>0)
                        @foreach($chat_arr as $chat)
                        @php
                        $message_date_create = date_create($chat['created_at']);
                        $current_date_create = date_create(date('Y-m-d H:i:s'));
                        $date_diff = date_diff($message_date_create,$current_date_create);
                        if($date_diff->days==0)
                        {
                        // $message_date = date('H:i A',strtotime($chat['created_at']));
                        $message_date = date('d-M-Y H:i A',strtotime($chat['created_at']));
                        }
                        else
                        {
                        $message_date = date('d-M-Y H:i A',strtotime($chat['created_at']));
                        }
                        @endphp
                        @if($chat['sender_id'] == $sender_id)
                         <div class="left-message-block right-message-block"><!-------for receiver id--------->
                           <div class="rights-message-profile">
                              <!-- <div class="left-message-profile">
                                
                              </div> --> 
                               {{-- <img src="{{url('/')}}/assets/images/avatar.png" alt=""> --}}
                           </div>
                           <div class="left-message-content">
                              {{-- <img src="{{url('/')}}/assets/buyer/images/message-arrow-right.png" alt="" class="arrow-message-right" /> --}}
                              <div class="actual-message">
                                 <div class="message-byuser">
                                    @if($chat['sender_details']['user_type']=="seller")
                                    {{$chat['sender_details']['seller_detail']['business_name']." (".$chat['sender_details']['user_type'].")" }}
                                    @else
                                    {{$chat['sender_details']['first_name']." ".$chat['sender_details']['last_name']." (".$chat['sender_details']['user_type'].")" }}
                                    @endif
                                 </div>
                                 @if(isset($chat['attachment']) && $chat['attachment'] != '' && file_exists($chat_attachment_img_base_path.$chat['attachment']))
                                 <a target="_blank" href="{{$attachment_img_public_path.$chat['attachment']}}"><img src="{{$attachment_img_public_path.$chat['attachment']}}" width="100px;" height="100px;"></a>
                                 @else
                                 {{$chat['message'] or ''}}
                                 @endif
                              </div>
                              <div class="message-time">
                                 {{ $message_date or '' }}
                              </div>
                           </div>
                        </div>
                        @endif
                        @if($chat['receiver_id'] == $sender_id && $chat['sender_id']==$receiver_id)  

                         <div class="left-message-block"> <!------------login user id- for sender------------->
                           <div class="left-message-profile-main">
                              <!-- <div class="left-message-profile">
                                 @if(isset($chat['sender_details']['profile_image']) && $chat['sender_details']['profile_image']!='' && file_exists(base_path().'/uploads/profile_image/'.$chat['sender_details']['profile_image']))
                                 <img src="{{$profile_img_path.'/'. $chat['sender_details']['profile_image']}}" alt=""/>
                                  @else
                                 <img src="{{url('/')}}/assets/images/avatar.png" alt="">
                                @endif
                              </div> -->
                               {{-- <img src="{{url('/')}}/assets/images/avatar.png" alt=""> --}}
                           </div>
                           <div class="left-message-content">
                              {{-- <img src="{{ url('/') }}/assets/images/message-arrow-left.png" alt="" class="arrow-message-left" /> --}}
                              <div class="actual-message">
                                 <div class="message-byuser">
                                    @if($chat['sender_details']['user_type']=="seller")
                                    {{$chat['sender_details']['seller_detail']['business_name']." (".$chat['sender_details']['user_type'].")" }}
                                    @else
                                    {{$chat['sender_details']['first_name']." ".$chat['sender_details']['last_name']." (".$chat['sender_details']['user_type'].")" }}
                                    @endif
                                 </div>
                                 @if(isset($chat['attachment']) && $chat['attachment'] != '' && file_exists($chat_attachment_img_base_path.$chat['attachment']))
                                 <a target="_blank" href="{{$attachment_img_public_path.$chat['attachment']}}"><img src="{{$attachment_img_public_path.$chat['attachment']}}" width="100px;" height="100px;"></a>
                                 @else
                                 {{$chat['message'] or ''}}
                                 @endif
                              </div>
                              <div class="message-time">
                                 {{ $message_date or '' }}
                              </div>
                           </div>
                        </div>
                        @endif
                        @endforeach     
                        @else
                       <div id="no-msg-found" class="alert alert-warning">No chat history found!</div>
                        @endif
                        <div class="chat_box"></div>
                     </div>