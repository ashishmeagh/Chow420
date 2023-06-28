<?php $__env->startSection('main_content'); ?>
<?php $likedislikemodel = app('App\Models\ForumLikeDislikeModel'); ?> 
<?php $ForumCommentsModel = app('App\Models\ForumCommentsModel'); ?> 
<style type="text/css">
  .buttonlikesfrms
   { text-align: center;
   }
    body {
    background-color: #fff;
   }
   .sellertab-main {
 display: inline-block;
 font-size: 12px;
 position: relative;
 width: 25px;
 padding-right: 10px;
 margin-left: 1px;
 color: #333;
 margin-top: 0px;
 vertical-align: top;
}

.frms-mandv{padding-top: 15px !important;}


.seereplybtn{
margin: 5px 0px;
padding: 5px 10px;
}

.seereplybtn:hover{
margin: 5px 0px;
padding: 5px 10px;
}

.hidereplybtn{
  margin: 5px 0px;
  padding: 5px 10px;
}
.hidereplybtn:hover{
  margin: 5px 0px;
  padding: 5px 10px;
}
.backlink {
    background-color: #DAE0E6;
    display: inline-block;
    padding: 10px 30px;
    border-radius: 3px;
    color: #222;
    margin-bottom: 30px;
}

/*css Added for making h1 tag*/
h1 {
    position: relative;
    z-index: 1;
    white-space: normal;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    margin-top: 48px;
    text-align: center;
    font-family: 'pf_dindisplay_proregular';
}
</style>  


<?php
if(Sentinel::check())
{
     $login_user = Sentinel::getUser();
     $login_id = $login_user['id'];
     $login_email = $login_user['email']; 
      $login_type = $login_user['user_type'];
}

?>
  

<div class="container">
   <div class="frms-mandv height-none"></div> 

    <?php

    if($forum_posts)
    {               
        $get_comment_count =0; 
      
        foreach($forum_posts as $forum_post)
        {
          
            
        ?>           


            <div class="commentlist-box-main">
                <div class="left-box-fum">
                    <div class="buttonlikesfrms">
                    <?php if(isset($login_user)): ?>
                        <?php if($login_user == true): ?>
                        <?php
                              $dblike_dislike=0;
                              $color ='';  
                          

                              $getlikeofuser = $likedislikemodel->where(['post_id' => $forum_post['id']])
                                    ->where('user_id',$login_id)->first();

                                if(isset($getlikeofuser) && !empty($getlikeofuser))
                                {
                                    $getlikeofuser = $getlikeofuser->toArray();
                                    $dblike_dislike = $getlikeofuser['like_dislike'];
                                    if($dblike_dislike=='1')
                                        $color = 'activeclass';
                                    else
                                        $color ='';   

                                }

                            ?>

                        <a href="javascript:void(0)" class="like-one  givelikedislike <?php echo e($color); ?>" postid="<?php echo e($forum_post['id']); ?>"   containerid="<?php echo e($forum_post['container_id']); ?>"   dblikedislike="1"   ><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowup.png" /></a>
                        <?php else: ?>
                          <a href="<?php echo e(url('/')); ?>/login" class="like-one " postid="<?php echo e($forum_post['id']); ?>" ><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowup.png" /></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(url('/')); ?>/login" class="like-one " postid="<?php echo e($forum_post['id']); ?>" ><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowup.png" /></a>
                    <?php endif; ?>
                        <span> 
                           
                             <?php echo e(isset($forum_post['get_like_count_count'])?$forum_post['get_like_count_count']:''); ?>

                         </span>
                       
                       <?php if(isset($login_user)): ?>
                        <?php if($login_user == true): ?>
                        <?php
                              $dblike_dislike=0;
                              $color ='';  

                               $getlikeofuser = $likedislikemodel->where(['post_id' => $forum_post['id']])
                                    ->where('user_id',$login_id)->first();

                                if(isset($getlikeofuser) && !empty($getlikeofuser))
                                {
                                    $getlikeofuser = $getlikeofuser->toArray();
                                    $dblike_dislike = $getlikeofuser['like_dislike'];
                                    if($dblike_dislike=='2')
                                        $color = 'activeclass';
                                    else
                                        $color ='';   

                                }

                            ?>

                        <a href="javascript:void(0)" class="dislike-one  givelikedislike <?php echo e($color); ?>" postid="<?php echo e($forum_post['id']); ?>"   containerid="<?php echo e($forum_post['container_id']); ?>"   dblikedislike="2"  ><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowdn.png" /></a>
                        <?php else: ?>
                          <a href="<?php echo e(url('/')); ?>/login" class="dislike-one " postid="<?php echo e($forum_post['id']); ?>" ><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowdn.png" /></a>
                        <?php endif; ?>
                       <?php else: ?>
                        <a href="<?php echo e(url('/')); ?>/login" class="dislike-one " postid="<?php echo e($forum_post['id']); ?>" ><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowdn.png" /></a>
                       <?php endif; ?>

                    </div>
                </div>
                <div class="right-box-fum">
                    <div class="commentheaders">
                      


                        <div class="postedby-div">
                           <?php if(isset($forum_post['container_details']['title'])): ?>     
                            <a href="#" class="nametexts-frm">
                            <?php echo e(ucfirst($forum_post['container_details']['title'])); ?>

                           </a>   
                           <?php endif; ?>

                            <span>Posted by:</span> 


                            <?php if(isset($login_user)): ?>

                                 <?php if($login_user == true && $login_type==$forum_post['user_details']['user_type']): ?>

                                  <?php 
                                      $setsellerurl=url('/').'/'.$login_type.'/'.'profile';;
                                     if($forum_post['user_details']['user_type']=="seller")
                                    {
                                        if(isset($forum_post['user_details']['seller_detail']))
                                        {
                                         $seller_business = str_replace(' ','-',$forum_post['user_details']['seller_detail']['business_name']);
                                          $setsellerurl =  url('/').'/search?sellers='.$seller_business;
                                        }//if isset seller detail
                                        else
                                        {
                                          $setsellerurl = url('/').'/'.$login_type.'/'.'profile';
                                        }

                                    } //if user type is seller
                                    elseif($forum_post['user_details']['user_type']=="buyer")
                                    {
                                        $setsellerurl = url('/').'/'.$login_type.'/'.'profile';
                                    }
                                     elseif($forum_post['user_details']['user_type']=="admin")
                                    {
                                       $setsellerurl = url('/').'/book/account_settings';
                                    }
                                  ?>



                                   <a href="<?php echo e($setsellerurl); ?>" target="_blank">
                                      <span class="postbys-dv">
                                         <?php 
                                          $postedname='';

                                          if($forum_post['user_details']['user_type']=="seller"){

                                             if(isset($forum_post['user_details']['seller_detail']))
                                            {
                                               $postedname = $forum_post['user_details']['seller_detail']['business_name'];
                                            }//if isset seller detail
                                            else
                                            {

                                               if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']=="")
                                               {
                                                $postedname = $forum_post['user_details']['email'];
                                               }//if
                                               else{
                                                $postedname = ucwords($forum_post['user_details']['first_name']);
                                              }//else
                                           }//else of seller detail not avaliable

                                          }//if usertype is seller 
                                          else
                                          {
                                            if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']=="")
                                              $postedname = $forum_post['user_details']['email'];
                                            else
                                              $postedname = ucwords($forum_post['user_details']['first_name']." ".$forum_post['user_details']['last_name']);

                                          }//else of other usertype

                                         ?>

                                         <?php echo e($postedname); ?>

                                       
                                       </span> 
                                    </a>
                                 <?php else: ?>
                                   
                                       <span class="postbys-dv">
                                         <?php 
                                          $postedname='';

                                          if($forum_post['user_details']['user_type']=="seller"){

                                             if(isset($forum_post['user_details']['seller_detail']))
                                            {
                                               $postedname = $forum_post['user_details']['seller_detail']['business_name'];
                                            }//if isset seller detail
                                            else
                                            {

                                               if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']=="")
                                               {
                                                $postedname = $forum_post['user_details']['email'];
                                               }//if
                                               else{
                                                $postedname = ucwords($forum_post['user_details']['first_name']);
                                              }//else
                                           }//else of seller detail not avaliable

                                          }//if usertype is seller 
                                          else
                                          {
                                            if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']=="")
                                              $postedname = $forum_post['user_details']['email'];
                                            else
                                              $postedname = ucwords($forum_post['user_details']['first_name']." ".$forum_post['user_details']['last_name']);

                                          }//else of other usertype

                                         ?>

                                         <?php echo e($postedname); ?>

                                       
                                       </span> 
                                 <?php endif; ?> 
                             <?php else: ?>
                               
                                   <span class="postbys-dv">
                                         <?php 
                                          $postedname='';

                                          if($forum_post['user_details']['user_type']=="seller"){

                                             if(isset($forum_post['user_details']['seller_detail']))
                                            {
                                               $postedname = $forum_post['user_details']['seller_detail']['business_name'];
                                            }//if isset seller detail
                                            else
                                            {

                                               if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']=="")
                                               {
                                                $postedname = $forum_post['user_details']['email'];
                                               }//if
                                               else{
                                                $postedname = ucwords($forum_post['user_details']['first_name']);
                                              }//else
                                           }//else of seller detail not avaliable

                                          }//if usertype is seller 
                                          else
                                          {
                                            if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']=="")
                                              $postedname = $forum_post['user_details']['email'];
                                            else
                                              $postedname = ucwords($forum_post['user_details']['first_name']." ".$forum_post['user_details']['last_name']);

                                          }//else of other usertype

                                         ?>

                                         <?php echo e($postedname); ?>

                                       
                                       </span> 
                             <?php endif; ?>

                         

                            <?php if($forum_post['user_details']['user_type']=="seller"): ?>
                            <div class="sellertab-main">
                              <img src="<?php echo e(url('/')); ?>/assets/front/images/seller-tags.png" alt="">
                              </div>

                            <?php elseif($forum_post['user_details']['user_type']=="admin"): ?>
                            <div class="sellertab-main">
                              <img src="<?php echo e(url('/')); ?>/assets/front/images/admin-tag.png" alt="">
                              </div>  

                            <?php endif; ?>    



                            <span class="hours-dv"><?php echo e(\Carbon\Carbon::parse($forum_post['created_at'])->diffForHumans()); ?></span>
                        </div>
 
                        <div class="commentlist-title">
                       
                         <?php 
                                 echo str_replace('"','\'',ucfirst($forum_post['title']));
                         ?>


                         <?php if(isset($forum_post['post_type']) && $forum_post['post_type']=="image" && isset($forum_post['image']) && file_exists(base_path().'/uploads/post/'.$forum_post['image']) && !empty($forum_post['image'])): ?>
                         <div class="forum-image">
                          <a href="<?php echo e(url('/')); ?>/uploads/post/<?php echo e($forum_post['image']); ?>" target="_blank">
                              <img src="<?php echo e(url('/')); ?>/uploads/post/<?php echo e($forum_post['image']); ?>" >
                           </a>
                         </div>
                          <?php elseif(isset($forum_post['video']) && !empty($forum_post['video'])): ?>
                           <?php 
                             $video_arr = explode("v=",$forum_post['video']);
                             $video_id = $video_arr[1];
                           ?>
                           <div class="forum-video">
                            <iframe src="https://www.youtube.com/embed/<?php echo e($video_id); ?>"></iframe>
                          </div>
                          <?php endif; ?>

                          <?php if(isset($forum_post['link']) && !empty($forum_post['link'])): ?>
                            
                            <div class="description-cooment-section">
                               <a href="<?php echo e($forum_post['link']); ?>" target="_blank" class="db-link"> <?php echo e($forum_post['link']); ?></a>
                               <div class="link-box-rights">
                                   <a href="<?php echo e($forum_post['link']); ?>" target="_blank" class="lnk-box-url"><i class="fa fa-link"></i>
                                     <span><i class="fa fa-external-link"></i></span>
                                   </a>
                               </div>
                               <div class="clearfix"></div>
                            </div>

                             
                           <?php endif; ?>  
                        </div>
                       
                    </div>
                   
                    <div class="footer-forum">
                        <img src="<?php echo e(url('/')); ?>/assets/front/images/chat-forum.png" alt="" /> <span><span class="comment_count_span">

                          <?php 
                          $commnt_count ='';                         
                          $commnt_count =   number_format_short($forum_post['comments_count']);
                          ?>

                          <?php echo e($commnt_count); ?> 

                          </span> Comments
                         
                          </span>

                   <!-- code for share link -->  

                      <?php 
                             
                        $forum_title_slug = str_slug($forum_post['title']);
                        // $word_cnt = str_word_count($forum_post['title']);
                        $word_cnt        = strlen($forum_post['title']);
                        $forum_title     = $forum_post['title'];
                        $forum_slug_url  = get_post_title($forum_post['title']);


                      ?>

                      <div class="sre-product">
                          <p id="urlLink" style="display: none;" ><?php echo e(url('/')); ?>/forum/view_post/<?php echo e(base64_encode($forum_post['id'])); ?></p>

                            <a href="javascript:void(0)" class="shdebtns" data-id="<?php echo e(isset($forum_post['id']) ? $forum_post['id'] : ''); ?>" url_link="<?php echo e(url('/')); ?>/forum/view_post/<?php echo e(base64_encode($forum_post['id'])); ?>/<?php echo $forum_slug_url ?>"

                                onclick="shareLink('#urlLink',this)" title="Share this forum post" >

                            <img src="<?php echo e(url('/')); ?>/assets/front/images/chat-forum-share.png " alt="" />
                              Share 
                          </a>
                        <div class="copeid-sms" id="copy_txt" style="display:none;"> Link Copied!</div>
                      </div>  

                      <!-- ---------------------------------------------- -->


                         <div class="savebutton-forum">
                             <?php if(isset($login_user)): ?>
                                <?php if($login_user == true): ?>
                                    <a href="javascript:void(0)" postid="<?php echo e($forum_post['id']); ?>"  class="reportmodal">
                                        <img src="<?php echo e(url('/')); ?>/assets/front/images/report-icons.png" alt="" />
                                        Report
                                    </a>
                                <?php else: ?>
                                   <a href="<?php echo e(url('/')); ?>/login" postid="<?php echo e($forum_post['id']); ?>"  >
                                     <img src="<?php echo e(url('/')); ?>/assets/front/images/report-icons.png" alt="" />   
                                    Report
                                </a>
                                <?php endif; ?>
                             <?php else: ?>
                                   <a href="<?php echo e(url('/')); ?>/login" postid="<?php echo e($forum_post['id']); ?>"  >
                                    <img src="<?php echo e(url('/')); ?>/assets/front/images/report-icons.png" alt="" />
                                    Report
                                </a>    
                            <?php endif; ?>
                         </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            
        <?php
            
        } 
    } 
    ?>  



    <form id="frm_forum_comment" onsubmit="return false">  
    <div class="row sec1">
        <div class="col-sm-12 comments">           
            <div class="form-group">
                    <input type="hidden" name="container_id" value="<?php echo e($forum_posts[0]['container_id']); ?>">
                    <input type="hidden" name="post_id" value="<?php echo e($forum_posts[0]['id']); ?>">
                    <input type="hidden" name="comment_type" value="comment">
                    <?php echo e(csrf_field()); ?>

                <?php if(Sentinel::check()): ?>
                    <input type="text" name="forum_comment_text" id="forum_comment_text" class="form-control" placeholder="Add a Comment" data-parsley-required="true" data-parsley-required-message="Please enter your comment" data-parsley-minlength="3" data-parsley-maxlength="150">
                    <button class="btn postbtn" id="forum_comment_post">Post</button>
                <?php else: ?>
                    <h4> To post your comment, you must login first! </h4> &nbsp;&nbsp;<a href="<?php echo e(url('/')); ?>/login" class="btn forum-loginbtn">Login</a>
                <?php endif; ?>
            </div>
        </div>        
    </div>
    </form>


    <div class="row sec2">           
        <div class="col-sm-12" id="comment_data">          
        </div>
    </div>
    <a href="<?php echo e(url('/')); ?>/forum" class="backlink">Back</a>
</div>




<!-----------------------my code started here for post like,share,report-------->

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

     <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="">
    <input type="hidden" name="hidden_post_id" id="hidden_post_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" align="center">Report</h3>
      </div>
      <div class="modal-body">
        
        <div class="mainbody-mdls">
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"><b> Link :</b></div>
             <div class="mainbody-mdls-fd-right link-http" id="links"></div>
             <div class="clearfix"></div>
          </div>

          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"> <b>Message :</b></div>
             <div class="mainbody-mdls-fd-right">
               <textarea id="message" rows="5" class="form-control" placeholder="Please enter your message here..." maxlength="300"></textarea>

               <div class="report-note">Note: Only 300 characters allowed.</div>  

               <span id="msg_err"></span>

             </div>
             <div class="clearfix"></div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
         <img src="<?php echo e(url('/')); ?>/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" />
        <a class="shdebtns sendbuttons btn btn-info viewpost-btn-forum" id="sendreport" >Send</a>
      </div>
    </div>

  </div>
</div>
<!--------end of modal---------------->


<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_script'); ?>

<link href="<?php echo e(url('/')); ?>/assets/front/css/forum.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/front/css/slick.css">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/front/css/slick-theme.css">
<script src="<?php echo e(url('/')); ?>/assets/front/js/slick.js" defer></script>

<script type="text/javascript">

var login_id = "<?php echo e(isset($login_id) ? $login_id : ''); ?>";


 $('#forum_comment_post').click(function(){
    var _token = $('input[name="_token"]').val();
    var post_id = $('input[name="post_id"]').val();
    var container_id = $('input[name="container_id"]').val();
    var SITE_URL = '<?php echo e(url('/')); ?>';
  
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

  /* function for share link */  
function shareLink(element,ref)
{
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();

      var postId = $(ref).attr('data-id');
      var link = $(ref).attr('url_link');

      copyToClipboard(link);
       
      $("#copy_txt").fadeIn(400);
      $("#copy_txt").fadeOut(2000);

} /* end  */


$(document).ready(function(){
 
 var _token = $('input[name="_token"]').val();
 var post_id = $('input[name="post_id"]').val();
 var SITE_URL = '<?php echo e(url('/')); ?>'; 
 load_data('', _token, post_id);


$(document).on('click', '#load_more_button', function(){
    var id = $(this).data('id');
    $('#load_more_button').html('<b>Loading...</b>');
    load_data(id, _token, post_id);
});


 
$("body").delegate('.reply_btn','click', function(){ 
    var parent_id = $(this).data('id');
    var post_id = $(this).data('post_id');
     var container_id = $(this).data('container_id');
    var comment_type = $(this).data('c_type');
    var parent_comment_id = $(this).data('parent_id');
    $("body").find('#forum_reply_box').remove();
    $("body").find('.reply_btn').removeClass('active');
    var reply_box ='';
    reply_box +='<form  id="forum_reply_box" onsubmit="return false">';
    reply_box +='<?php echo e(csrf_field()); ?>';
    reply_box +='<input type="hidden" name="parent_id" value="'+parent_id+'">';
    reply_box +='<input type="hidden" name="post_id" value="'+post_id+'">';
    reply_box +='<input type="hidden" name="comment_type" value="'+comment_type+'">';
    reply_box +='<input type="hidden" name="container_id" value="'+container_id+'">';
    reply_box +='<input type="hidden" name="parent_comment_id" value="'+parent_comment_id+'">';
    reply_box +='<div class="input-group" >';
    reply_box +='<input id="forum_comment_text" type="text" class="form-control" name="forum_comment_text" placeholder="Add a Reply" data-parsley-required="true" data-parsley-required-message="Please enter your reply" data-parsley-minlength="3" data-parsley-maxlength="150" >';

    reply_box +='<a href="javascript:void(0);" class="input-group-addon" id="forum_reply_post" data-id="'+parent_id+'" data-post_id="'+post_id+'" data-container_id="'+container_id+'"   data-c_type="'+comment_type+'">Post</a>';

    reply_box +='</div>';

    reply_box +='</form>';
    $(this).parent().parent().after(reply_box);
    $(this).addClass('active');
    $('#forum_reply_box').find('#forum_comment_text').focus();
  
});


$(document).on('click','.seereplybtn',function(){
      
    showProcessingOverlay();
    var comment_id = $(this).attr('comment_id');
    var comment_post_id = $(this).attr('comment_post_id');
    show_repliesdata(comment_id,comment_post_id);

});/* showreply */ 

$(document).on('click','.hidereplybtn',function(){
 var comment_id = $(this).attr('comment_id');
 var comment_post_id = $(this).attr('comment_post_id');
$("#ShowCommentReply_"+comment_id+'_'+comment_post_id).html('');
  $("#seereplybtn_"+comment_id+'_'+comment_post_id).show();
 $("#hidereplybtn_"+comment_id+'_'+comment_post_id).hide();

});


$('.regular').slick({
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
  ]
});


});/* end document ready */

$(document).on('click', '#forum_reply_post', function(){

    var _token = $('input[name="_token"]').val();
    var post_id = $('input[name="post_id"]').val();
    var container_id = $('input[name="container_id"]').val();
    var parent_comment_id = $('input[name="parent_comment_id"]').val();
    var SITE_URL = '<?php echo e(url('/')); ?>';
    if($('#forum_reply_box').parsley().validate()==false) return;
    
    var form_data = $('#forum_reply_box').serialize();      
    if($('#forum_reply_box').parsley().isValid() == true )
    {         
        $.ajax({
            url:SITE_URL+'/forum/view_post/forum_comment_store',
            data:form_data,
            method:'POST',     
            dataType:'json',       
            beforeSend : function()
            {
              showProcessingOverlay();
              $('#forum_reply_post').prop('disabled',true);
              $('#forum_reply_post').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
                hideProcessingOverlay();
                $('#forum_reply_post').prop('disabled',false);
                $('#forum_reply_post').html('Post');
                if(response.status=="success")
                {
                    $('#forum_comment_text').val('');
                    $('#comment_data').html('');
                    load_data('', _token, post_id);

                    show_repliesdata(parent_comment_id,post_id);
                    
                }else{
                    swal('Appologies!',response.description,'warning');
                }

            }
        });
    }
    
});


/* function to load data */
function load_data(id="", _token, post_id)
 {
    $.ajax({
        url:SITE_URL+"/forum/view_post/load_post_comments",
        method:"POST",
        data:{id:id, _token:_token, post_id:post_id},
        dataType:'json',
        beforeSend: function(){     
            
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
            $('.comment_count_span').html(comments_response.comment_count);
        }
    })
 }/* end */



/* function to show report modal */
 $(document).on('click','.reportmodal',function()
 { 

    $("#myModal").modal('show');

     $("#hidden_user_id").val('');
    $("#hidden_post_id").val('');
    $("#links").html('');


    var postid = $(this).attr('postid');
    var urllink = "<?php echo e(url('/')); ?>/forum/view_post/"+btoa(postid);

    $("#hidden_user_id").val(login_id);
    $("#hidden_post_id").val(postid);
    $("#links").html(urllink);
 });


/* function for sending report */
   $(document).on('click','#sendreport',function(){

    var link = $("#links").html();
    var from = $("#hidden_user_id").val();
    var message = $("#message").val();
    var postid = $("#hidden_post_id").val();
    if(message.trim()=="")
    {
      $("#msg_err").html('Please enter message');
      $('#msg_err').css('color','red');
      return false;
    }else{
      $("#msg_err").html('');
    }
    if(link && from && message && postid)
    {
       
         $.ajax({
              url: SITE_URL+'/forum/send_reportpost',
              type:"GET",
              data: {link:link,from:from,message:message,postid:postid},             
              dataType:'json',
              beforeSend: function(){    
              /* showProcessingOverlay(); */     
                $("#loaderimg").show();
                $("#sendreport").hide();
              },  
              success:function(response)
              {
                $("#loaderimg").hide();
                $("#sendreport").show();
                /* hideProcessingOverlay(); */ 
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
           }); 

    }else{
      return false;
    }  
    
  }); /* end send report  */


  $(document).on('click','.givelikedislike',function(){ 
    var postid = $(this).attr('postid');
    var containerid = $(this).attr('containerid');
    var dblikedislike = $(this).attr('dblikedislike');
    var csrf_token = "<?php echo e(csrf_token()); ?>";
      $.ajax({
            url: SITE_URL+'/forum/givelikedislike',
            type:"POST",
            data: {containerid:containerid,postid:postid,dblikedislike:dblikedislike,_token:csrf_token},             
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

       }); 
  }); 


/* funciton for copy   */
function copyToClipboard(text) 
{
  if (window.clipboardData && window.clipboardData.setData) {
    return clipboardData.setData("Text", text);

  } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
    var textarea = document.createElement("textarea");
    textarea.textContent = text;
    textarea.style.position = "fixed"; 
    document.body.appendChild(textarea);
    textarea.select();
    try {
      return document.execCommand("copy"); 
    } catch (ex) {
      console.warn("Link copied failed.", ex);
      return false;
    } finally {
      document.body.removeChild(textarea);
    }
  }
}


/* function for link copy */
function status(clickedBtn,id) 
{
    var postid = id;
   
    var text = document.getElementById(clickedBtn.dataset.descRef).innerText;

   copyToClipboard(text);

   swal('Success','Link Copied','success');

  clickedBtn.value = "Link Copied!";
  clickedBtn.disabled = true;
  clickedBtn.style.color = 'white';
  clickedBtn.style.background = 'gray';

} /* end */


/* function for comment like */
$(document).on('click','.givelike_comment',function(){ 
    var commentid = $(this).attr('commentid');
    var postid = $(this).attr('postid');
    var containerid = $(this).attr('containerid');
    var dblikedislike = $(this).attr('dblikedislike');
    var csrf_token = "<?php echo e(csrf_token()); ?>";
      $.ajax({
            url: SITE_URL+'/forum/givelike_comment',
            type:"POST",
            data: {containerid:containerid,commentid:commentid,postid:postid,dblikedislike:dblikedislike,_token:csrf_token},             
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

       }); 
  }); 

    

/* function for reply like */
$(document).on('click','.givelike_reply',function(){ 
    var commentid = $(this).attr('commentid');
    var postid = $(this).attr('postid');
    var containerid = $(this).attr('containerid');
    var replyid  =  $(this).attr('replyid');
    var dblikedislike = $(this).attr('dblikedislike');
    var csrf_token = "<?php echo e(csrf_token()); ?>";


     var parent_comment_id  =  $(this).attr('data-parent_id');
    
      $.ajax({
            url: SITE_URL+'/forum/givelike_reply',
            type:"POST",
            data: {containerid:containerid,replyid: replyid,commentid:commentid,postid:postid,dblikedislike:dblikedislike,_token:csrf_token,parent_comment_id:parent_comment_id},             
            dataType:'json',
            beforeSend: function(){        
            showProcessingOverlay();        
            },
            success:function(response)
            {
              hideProcessingOverlay();
              if(response.status == 'SUCCESS')
              { 
                 show_repliesdata(parent_comment_id,postid); 
                
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  
       }); 
  }); 

showProcessingOverlay();
$(window).load(function() 
 {       
     hideProcessingOverlay();
 });



$(window).scroll(function(){
    if ($(this).scrollTop() > 2) {
       $('body').addClass('newclassscroll');
    } else {
       $('body').removeClass('newclassscroll');
    }
});

/*  function for show reply data   */
function show_repliesdata(comment_id,comment_post_id)
  {
    if(comment_id && comment_post_id)
    {
       
        $.ajax({ 
        url:SITE_URL+"/forum/get_comment_reply/"+comment_id+'/'+comment_post_id,
        method:"GET",
        beforeSend: function(){     
                  
        },
        success:function(response)
        {
          hideProcessingOverlay();

          $("#ShowCommentReply_"+comment_id+'_'+comment_post_id).html(response);
          $("#hidereplybtn_"+comment_id+'_'+comment_post_id).show();
          $("#seereplybtn_"+comment_id+'_'+comment_post_id).hide();

        }
    
    });/* ajax */

    }/* if commentid and post id */
  }

</script>
<?php $__env->stopSection(); ?>


<!--------COMMENTED CODE STARTS------------------------>


   


                

  






 


  


<?php echo $__env->make('front.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>