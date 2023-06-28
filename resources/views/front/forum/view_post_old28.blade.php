
@extends('front.layout.master')
@section('main_content')


<style type="text/css">
  .buttonlikesfrms
   { text-align: center;
   }
 
</style>  
  
<div class="container">
    

    <div class="fourmla-box">
       @php
        if($forum_containers)
        {   
            $cnt =1;
            $background_keys = ['one','two','three','four','five','six'];
           
            foreach($forum_containers as $forum_container)
            {
                $container_bag = $background_keys[$cnt-1];
            @endphp
                <div class="boxlist-forum boxforum-{{$container_bag}}">{{strtoupper($forum_container['title'])}} </div>
            @php
                $cnt++;
                if($cnt==7)
                {
                    $cnt=1;

                }
            }
        } 
        @endphp 
    </div>
    
    @php
        
    if($forum_posts)
    {               
        foreach($forum_posts as $forum_post)
        {
            
        @endphp           


            <div class="commentlist-box-main">
                <div class="left-box-fum">
                    <div class="buttonlikesfrms">
                        <a href="#" class="like-one"><i class="fa fa-thumbs-up"></i></a>
                        <span>0</span>
                        <a href="#" class="dislike-one"><i class="fa fa-thumbs-down"></i></a>
                    </div>
                </div>
                <div class="right-box-fum">
                    <div class="commentheaders">
                        <div class="commentlist-title">{{ucfirst($forum_post['title'])}}</div>
                        <div class="postedby-div">
                            <a href="#" class="nametexts-frm">{{ucfirst($forum_post['container_details']['title'])}}</a>   
                            <span>Posted by:</span> 
                            <span class="postbys-dv">{{ucwords($forum_post['user_details']['first_name']." ".$forum_post['user_details']['last_name'])}}</span> 
                            <span class="hours-dv">{{ \Carbon\Carbon::parse($forum_post['created_at'])->diffForHumans() }}</span>
                        </div>
                        <a href="#" class="commentbuttons">Comment</a>
                    </div>
                    <div class="description-cooment-section">
                       {{ucfirst($forum_post['description'])}}
                    </div>
                    <div class="borderforums"></div>
                    <div class="footer-forum">
                        <img src="{{url('/')}}/assets/front/images/chat-forum.png" alt="" /> <span>{{$forum_post['comments_count']}}  Comments</span>
                        <div class="sharebutton-forum"><a href="#">Share <i class="fa fa-share-alt-square"></i></a></div>
                        <div class="savebutton-forum"><a href="#"><i class="fa fa-ellipsis-h"></i></a></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            
        @php
            
        }
    } 
    @endphp  

    <form id="frm_forum_comment" onsubmit="return false">  
    <div class="row sec1">
        <div class="col-sm-12 comments">
            <h2> {{$forum_posts[0]['comments_count']}} Comments</h2>
            <div class="form-group">
                    <input type="hidden" name="post_id" value="{{$forum_posts[0]['id']}}">
                    {{ csrf_field() }}
                @if(Sentinel::check())
                    <input type="text" name="forum_comment_text" id="forum_comment_text" class="form-control" placeholder="Add a Comment" data-parsley-required="true" data-parsley-required-message="Please enter your comment" data-parsley-minlength="3" data-parsley-maxlength="150">
                    <button class="btn postbtn" id="forum_comment_post">Post</button>
                @else
                    <h4> To post your comment, you must login first! </h4> &nbsp;&nbsp;<a href="{{url('/')}}/login" class="btn forum-loginbtn">Login</a>
                @endif
            </div>
        </div>        
    </div>
    </form>

    <div class="row sec2">
           
        <div class="col-sm-12" id="comment_data">
            {{-- <div class="comments-post">
                <div class="box">
                    <h4>Thomas E. Scott</h4>
                    <small>1 hour ago</small>
                    <p>Contrary to popular belief, Lorem Ipsum is not simple random text.</p>
                    <ul class="list-inline">
                        <li><a href="#"><i class="fa fa-reply"></i> Reply</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-up"></i> Like</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-down"></i> Dislike</a></li>
                    </ul>
                </div>
                <div class="box box2">
                    <h4>Heather J. Goodrich</h4>
                    <small>3 minutes ago</small>
                    <p>sit amet, vix in adipisci deseruisse. Ornatus phaedrum inimicus ius ex. Eu affert saperet deleniti ius, ea harum tractatos cum. Alia voluptatibus mel ut. Semper bonorum vix ne. sit amet, vix in adipisci deseruisse. Ornatus phaedrum inimicus ius ex. Eu affert saperet deleniti ius, ea harum tractatos cum. Alia voluptatibus mel ut. Semper bonorum vix ne.</p>
                    <ul class="list-inline">
                        <li><a class="active" href="#"><i class="fa fa-reply"></i> Reply</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-up"></i> Like</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-down"></i> Dislike</a></li>
                    </ul>

                    <div class="innerbox">
                        <h4>Pattie C. Taylor</h4>
                        <small>3 minutes ago</small>
                        <p>sit amet, vix in adipisci deseruisse. Ornatus phaedrum inimicus ius ex. Eu affert saperet deleniti ius, ea harum tractatos cum. Alia voluptatibus mel ut. Semper bonorum vix ne. sit amet, vix in adipisci deseruisse. Ornatus phaedrum inimicus ius ex. Eu affert saperet deleniti ius, ea harum tractatos cum. Alia voluptatibus mel ut. Semper bonorum vix ne.</p>
                        <ul class="list-inline">
                        <li><a class="active" href="#"><i class="fa fa-reply"></i> Reply</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-up"></i> Like</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-down"></i> Dislike</a></li>
                    </ul>
                        <div class="input-group">
                            <input id="msg" type="text" class="form-control" name="msg" placeholder="Add a Comment">
                            <span class="input-group-addon">Post</span>
                        </div>
                    </div>
                     <div class="innerbox">
                        <h4>Pattie C. Taylor</h4>
                        <small>3 minutes ago</small>
                        <p>sit amet, vix in adipisci deseruisse.    </p>
                        <ul class="list-inline">
                        <li><a class="active" href="#"><i class="fa fa-reply"></i> Reply</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-up"></i> Like</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-down"></i> Dislike</a></li>
                    </ul>
                    </div>
                </div>
            </div>
            <div class="comments-post">
                <div class="box">
                    <h4>Thomas E. Scott</h4>
                    <small>1 hour ago</small>
                    <p>Contrary to popular belief, Lorem Ipsum is not simple random text.</p>
                    <ul class="list-inline">
                        <li><a href="#"><i class="fa fa-reply"></i> Reply</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-up"></i> Like</a></li>
                        <li><a href="#"><i class="fa fa-thumbs-down"></i> Dislike</a></li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </div>


    <!-- <div class="pagination-chow">                                        
       <ul class="pagination">
            <li class="disabled"><a>«</a></li>
            <li><a class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><a href="#" rel="next">»</a></li>
        </ul>
    </div> -->

</div>




<script type="text/javascript">
    $('#forum_comment_post').click(function(){
        var _token = $('input[name="_token"]').val();
        var post_id = $('input[name="post_id"]').val();
        var SITE_URL = '{{url('/')}}';
        // alert(_token,post_id);
        // return false;
        if($('#frm_forum_comment').parsley().validate()==false) return;
        
        var form_data = $('#frm_forum_comment').serialize();      

        if($('#frm_forum_comment').parsley().isValid() == true )
        {         
            $.ajax({
                url:SITE_URL+'/forum/view_post/forum_comment_store',
                data:form_data,
                method:'POST',     
                dataType:'json',       
                beforeSend : function()
                {
                  showProcessingOverlay();
                  $('#forum_comment_post').prop('disabled',true);
                  $('#forum_comment_post').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
                },
                success:function(response)
                {
                    hideProcessingOverlay();
                    $('#forum_comment_post').prop('disabled',false);
                    $('#forum_comment_post').html('Post');
                    if(response.status=="success")
                    {
                        $('#forum_comment_text').val('');
                        $('#comment_data').html('');
                        load_data('', _token, post_id);
                        
                    }else{
                        swal('Appologies!',response.description,'warning');
                    }
  
                }
            });
        }
    });
</script>

<script>
$(document).ready(function(){
 
 var _token = $('input[name="_token"]').val();
 var post_id = $('input[name="post_id"]').val();
 var SITE_URL = '{{url('/')}}';
 // alert(SITE_URL);
 load_data('', _token, post_id);

 

$(document).on('click', '#load_more_button', function(){
    var id = $(this).data('id');
    $('#load_more_button').html('<b>Loading...</b>');
    load_data(id, _token, post_id);
});

});
function load_data(id="", _token, post_id)
 {
    $.ajax({
        url:SITE_URL+"/forum/view_post/load_post_comments",
        method:"POST",
        data:{id:id, _token:_token, post_id:post_id},
        dataType:'json',
        beforeSend: function(){     
            // $(ref).attr('disabled');          
            // $(ref).html('<div class="add_to_cart">Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i></div>');        
        },
        success:function(comments_response)
        {
            if(comments_response.status=="success")
            {
                $('#load_more_button').remove();
                $('#comment_data').append(comments_response.comments);
            }
            else
            {
                $('#load_more_button').remove();                
                $('#comment_data').append('');
            }
        }
    })
 }
</script>

@endsection