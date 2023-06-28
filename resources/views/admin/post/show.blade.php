@extends('admin.layout.master')                
@section('main_content')

 <link href="{{url('/')}}/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />

<style type="text/css">
  .morecontent span {display: none;}
  .morelink {display: block;color: red;}
  .morelink:hover,.morelink:focus{color: red;}
  .morelink.less{color: red;}
  .show-h3{margin-top: 0px;}
  .comments-mains.sub-reply{border-radius: 5px;}
  .txt-commnts{color: #888888;}
  .comments-mains-right.move-top-mrg {margin-top: 11px;}
</style>
<!-- Page Content -->
<div id="page-wrapper"> 
<div class="container-fluid"> 
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">{{$page_title or ''}}</h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">

          @php
            $user = Sentinel::check();
          @endphp

          @if(isset($user) && $user->inRole('admin'))
            <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
          @endif

         <li><a href="{{ url(config('app.project.admin_panel_slug').'/post') }}">Forum posts</a></li>
         <li class="active">Post Detail</li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>

<!-- .row -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box">


       


         @include('admin.layout._operation_status')
          <div class="row">
            <div class="col-sm-12 col-xs-12">
                 <h3>
                    <span 
                       class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action" >
                    </span>
                 </h3>
            </div>
          </div>
          
                  
            <div class="row">

              <div class="col-md-12">
                
                    <div class="myprofile-main">
                       <div class="myprofile-lefts">Post Name</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['title']) && $arr_data['title']!="")
                           @php echo $arr_data['title'] @endphp
                          @else
                           NA
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>  

              </div>


               <div class="col-sm-6">
                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Forum Container</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['get_container_detail']['title']) && $arr_data['get_container_detail']['title']!="")
                          {{ $arr_data['get_container_detail']['title'] }}
                          @else
                          NA
                          @endif
                        </div>
                       <div class="clearfix"></div>
                  </div>

{{-- 
                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Post Description</div>
                       <div class="myprofile-right prod-desc">
                        @if(isset($arr_data['description']) && $arr_data['description']!="")
                          {{ $arr_data['description'] }}
                          @else
                          NA
                          @endif
                        </div>
                       <div class="clearfix"></div>
                  </div> --}}

                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Added By</div>
                       <div class="myprofile-right">

                        @if((isset($arr_data['user_details']['first_name']) && $arr_data['user_details']['first_name']!="") && (isset($arr_data['user_details']['last_name']) && $arr_data['user_details']['last_name']!=""))

                           {{ $arr_data['user_details']['first_name'].' '.$arr_data['user_details']['last_name'] }} 
                        @else

                           {{isset($arr_data['user_details']['email'])?$arr_data['user_details']['email']:''}}

                        @endif 
       

                       </div>
                       <div class="clearfix"></div>
                  </div>

              </div>

              
                  
                
                  
                 <div class="col-sm-6">  
                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Added On</div>
                       <div class="myprofile-right">
                         {{ date("M d Y H:i A",strtotime($arr_data['created_at'])) }} 
                       </div>
                       <div class="clearfix"></div>
                  </div>
                </div>

                 <div class="col-sm-6">

                     <div class="myprofile-main">
                       <div class="myprofile-lefts">Post Type</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['post_type']) && !empty($arr_data['post_type'])) 
                          {{ $arr_data['post_type'] }}
                          @else
                            NA
                          @endif 
                       </div>
                       <div class="clearfix"></div>
                    </div>
                    
                    @if(isset($arr_data['post_type']) && $arr_data['post_type']=="image")
                     <div class="myprofile-main">
                       <div class="myprofile-lefts">Image</div>
                       <div class="myprofile-right">
                           @php 
                             if(isset($arr_data['image']) && $arr_data['image'] != '' && file_exists(base_path().'/uploads/post/'.$arr_data['image'])){
                            @endphp
                             <a href="{{ url('/') }}/uploads/post/{{$arr_data['image']}}" target="_blank">
                               <img src="{{ url('/') }}/uploads/post/{{$arr_data['image']}}" alt="Image" width="100"> 
                             </a>

                             @php
                            }else{ 
                            @endphp 
                             <div class="ordr-id-nm">  NA </div>
                            @php } @endphp

                       </div>
                       <div class="clearfix"></div>
                    </div>
                    @endif 

                 </div><!------end of col-md-6------->

                 <div class="col-sm-6">

                    @if(isset($arr_data['post_type']) && $arr_data['post_type']=="video")
                     <div class="myprofile-main">
                       <div class="myprofile-lefts">Video</div>
                       <div class="myprofile-right">
                            @php 
                               $video_arr = explode("v=",$arr_data['video']);
                               $video_id = $video_arr[1];
                            @endphp

                            <div class="forum-video">
                              <iframe src="https://www.youtube.com/embed/{{ $video_id }}" width="100" height="100"></iframe>
                            </div>

                       </div>
                       <div class="clearfix"></div>
                    </div>
                    @endif 


                   

                   
                 </div><!------end of col-md-6------->
                 <div class="col-sm-6">

                   @if(isset($arr_data['post_type']) && $arr_data['post_type']=="link")
                     <div class="myprofile-main">
                       <div class="myprofile-lefts">Link</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['link']) && (!empty($arr_data['link']))) 
                          <a href="{{ $arr_data['link'] }}" target="_blank"> {{ $arr_data['link'] }} </a>
                           @else 
                           NA 
                           @endif 
                       </div>
                       <div class="clearfix"></div>
                    </div>
                  @endif
                    
                 </div><!------end of col-md-6------->             

               </div><!------end of row------->
             

                     
</div>

  @if(isset($arr_comment) && sizeof($arr_comment)>0)

<div class="white-box">
       

<div cass="main-show-list-dtls">
  <h3 class="show-h3"><b>Comments</b></h3>

  @if(isset($arr_comment) && sizeof($arr_comment)>0)
  @foreach($arr_comment as $comment)
   @php
    if(isset($comment['user_details']['profile_image']) && $comment['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$comment['user_details']['profile_image']))
      {
          $user_profile_img = url('/uploads/profile_image/'.$comment['user_details']['profile_image']);
      }
      else
      {                  
        $user_profile_img = url('/assets/images/avatar.png');
       }
    @endphp 

      <div class="comments-mains">
          <div class="comments-mains-left">
              <img src="{{$user_profile_img}}" alt="" />
          </div>
          <div class="comments-mains-right move-top-mrg">
              <div class="txt-commnts"><span>{{isset($comment['user_details']['first_name'])?$comment['user_details']['first_name']:''}} {{isset($comment['user_details']['last_name'])?$comment['user_details']['last_name']:''}}</span>   {{isset($comment['comment'])?$comment['comment']:''}}</div>
              {{-- <div class="times">{{isset($reply['created_at'])?date('h:i - M d, Y', strtotime($reply['created_at'])):''}} <a href="#">Reply</a>
              </div> --}}
          </div>
          <div class="clearfix"></div>

              @if(isset($comment['reply_details']) && sizeof($comment['reply_details'])>0)
                @foreach($comment['reply_details'] as $reply)

                  @php

                    if(isset($reply['user_details']['profile_image']) && $reply['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$reply['user_details']['profile_image']))
                        {
                          $reply_user_profile_img = url('/uploads/profile_image/'.$reply['user_details']['profile_image']);
                        }
                    else
                        {                  
                          $reply_user_profile_img = url('/assets/images/avatar.png');
                        }

                  @endphp
          <div class="comments-mains sub-reply">
              <div class="comments-mains-left">
                  <img src="{{$reply_user_profile_img}}" alt="" />
              </div>
              <div class="comments-mains-right">

                  <div class="txt-commnts"><span>{{isset($reply['user_details']['first_name'])?$reply['user_details']['first_name']:''}} {{isset($reply['user_details']['last_name'])?$reply['user_details']['last_name']:''}}</span> {{isset($reply['reply'])?$reply['reply']:''}}
                  </div>

                 {{--  <div class="times"> 
                    {{isset($reply['created_at'])?date('h:i - M d, Y', strtotime($reply['created_at'])):''}}
                    <a href="#">Reply</a>
                  </div> --}}
              </div>
              <div class="clearfix"></div>
          </div>
           @endforeach
           @endif
      </div>

   @endforeach  
   @endif 
</div>

</div>
  @endif


  <div class="form-group row">
    <div class="col-10">
       <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  </div>

</div>
</div>      
</div>
</div>



<div class="modal fade" id="reject_product_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="hidden_product_id" id="hidden_product_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Reject Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason &nbsp;</div>
          <textarea id="reason" name="reason" class="form-control" rows="5"></textarea>
          <span id="reason_err"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectprodbtn" id="rejectprodbtn">Reject</button>
      </div>
    </div>
  </div> 
</div>




<script type="text/javascript">
  $(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 100;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";
    

    $('.prod-desc').each(function() {
        var content = $(this).html().trim();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });


     $('.reason-desc').each(function() {
        var content = $(this).html().trim();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });


 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
</script>

<script> 
  
  var module_url_path = "{{$module_url_path}}";

     $('.approve_disapprove').click(function(){

         var product_id = $(this).attr('productid');  
         var status = $(this).attr('productstatus'); 
         var dbstatus = $(this).attr('dbstatus'); 
         
         if(status=='0' || status=='2')
         {
          // var status  = 1;
           var status_app_disapp = 'Do you really want to disapprove status of this product?';
         }
         else if(status=='1')
         {
           //var status  = 2;
           var status_app_disapp = 'Do you really want to approve status of this product?';
         }

                           

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {

                    if(status=='2')
                    {

                        $("#reject_product_sectionmodal").modal('show');
                        $("#hidden_product_id").val(product_id);

                    }else{ 

                         $.ajax({
                             method   : 'GET',
                             dataType : 'JSON',
                             data     : {status:status,product_id:product_id},
                             url      : module_url_path+'/approvedisapprove',
                             beforeSend : function()
                             { 
                                showProcessingOverlay();        
                             },
                             success  : function(response)
                             {                         
                               hideProcessingOverlay(); 

                              if(typeof response == 'object' && response.status == 'SUCCESS')
                              {
                                swal('Done', response.message, 'success');
                                window.location.reload();
                              }
                              else
                              {
                                swal('Oops...', response.message, 'error');
                              }               
                             }
                          });
                       
                 }//else

               }
             });


      });    


  $(document).on("click",".rejectprodbtn",function() {
      
    var product_id = $("#hidden_product_id").val();
    
    var reason = $("#reason").val();
    if(reason=="")
    {
      $("#reason_err").html('Please enter the reason for rejection');
      $("#reason_err").css('color','red');
    }else{
       $("#reason_err").html('');
        if(product_id && reason)
        { 
      
 
            $.ajax({
                url: module_url_path+'/rejectproduct',
                type:"GET",
                data: {product_id:product_id,reason:reason},             
                dataType:'json',
                beforeSend: function(){    
                 showProcessingOverlay();           
                },
                success:function(response)
                {
                  hideProcessingOverlay(); 
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
                          window.location.reload();
                      }

                    });
                  }
                  else
                  {                
                    swal('Error',response.description,'error');
                  }  
                }  
             }); // end of ajax
      
        } //if user id and note
      } //else    
  });






</script>

<!-- END Main Content -->
@stop