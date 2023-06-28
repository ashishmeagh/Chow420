@extends('admin.layout.master')                
@section('main_content')

 <link href="{{url('/')}}/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />

<style type="text/css">
  .myprofile-lefts {
    float: left;
    font-weight: 600;
    color: #333;
    max-width: 160px;
}
  .morecontent span {display: none;}
  .morelink {display: block;color: #887d7d;}
  .morelink:hover,.morelink:focus{color: #887d7d;}
  .morelink.less{color: #887d7d;}
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
         
        <li><a href="{{ url(config('app.project.admin_panel_slug').'/highlights') }}">Highlights</a></li>
        <li class="active">{{$page_title or ''}}</li>
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
          
         <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" ></label>
         </div>

            <div class="row">

                  <div class="col-sm-6">

              

                  <div class="myprofile-main">
                       <div class="myprofile-lefts"> Image</div>
                       <div class="myprofile-right">

                        @php
                        //dd($arr_data['hilight_image']);
                        @endphp
                          
                        @if(!empty($arr_data['hilight_image']) && $arr_data['hilight_image'] != '')

                              @if(file_exists(base_path().'/uploads/highlights/'.$arr_data['hilight_image']))

                              <div class="disv-zooms" id="lightgallery2">
                               <a href="" data-responsive="{{ $highlight_public_img_path}}/{{ $arr_data['hilight_image'] }}" data-src="{{ $highlight_public_img_path}}/{{ $arr_data['hilight_image'] }}">
                                <img src="{{$highlight_public_img_path}}/{{ $arr_data['hilight_image'] }}" alt="Product Image" width="100"> 
                               </a>
                             </div>
                              @else
                                NA
                              @endif
                        @endif

                       </div>
                       <div class="clearfix"></div>
                  </div>


                  @php
                  //dd($arr_data);
                  @endphp
                  <div class="myprofile-main">
                       <div class="myprofile-lefts"> Title</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['title']) && $arr_data['title']!="")
                          {{ $arr_data['title'] }}
                          @else
                           NA
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>


                   <div class="myprofile-main">
                       <div class="myprofile-lefts"> Description</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['description']) && $arr_data['description']!="")
                          {{ $arr_data['description'] }}
                          @else
                           NA
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>

                </div>

                <div class="col-sm-6">
                </div>

          
               </div><!--end of row--->
             
</div><!--end of class=white-box--->



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
          <textarea id="reason" name="reason" class="form-control" rows="5" maxlength="500"></textarea>
          <span id="reason_err"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectprodbtn" id="rejectprodbtn">Reject</button>
      </div>
    </div>
  </div> 
</div>




<!----------------videomodal-------------------------->

<div  class="modal fade" id="productVideoModal" tabindex="-1" role="dialog" aria-labelledby="productVideoModalTitle1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header borderbottom">
        <div class="video-modal-title" id="productVideoModalTitle"></div>
        {{-- <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5> --}}
        <button type="button" id="close_product_video" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="yt-player" style="height: 400px;">
        <iframe class="youtube-video" id="youtube-video" width="100%" height="100%" frameborder="0" allowfullscreen
            src="">
        </iframe>

      </div>
    </div>
  </div>
</div>
<!---------------end videomodal------------>


  <script>
    function openProductVideoModal(ref){

      let videoID = $(ref).attr('data-video-id');
      
      let video_source = $(ref).attr('data-video-source');

      let title = $(ref).attr('data-video-title');
      let videoUrl ='';
      if(video_source=="youtube")
      {
        videoUrl = 'https://www.youtube.com/embed/'+videoID/*+'?autoplay=1'*/;
      }
      if(video_source=="vimeo")
      {
        videoUrl = 'https://player.vimeo.com/video/'+videoID/*+'?autoplay=1'*/;
      }

      $("#yt-player iframe.youtube-video").attr("src",videoUrl);

      $(".modal-footer").html('');  
      $("#productVideoModalTitle").html(title);     

      $("#productVideoModal").modal();
    }

  </script>





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
                                    setTimeout(function(){
                                      window.location.reload();
                                     },5000); 
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
                         $("#reject_product_sectionmodal").hide();
                          setTimeout(function(){
                             window.location.reload();
                          },1000); 
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