<?php $__env->startSection('main_content'); ?>
<?php $likedislikemodel = app('App\Models\ForumLikeDislikeModel'); ?> 
<?php $ForumCommentsModel = app('App\Models\ForumCommentsModel'); ?> 



 <link href="<?php echo e(url('/')); ?>/assets/front/css/forum.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/front/css/slick.css">
  <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/front/css/slick-theme.css">

   <script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script>

<style type="text/css">
  
  .buttonlikesfrms
   { text-align: center;
   } 
   body {
    background-color: #fff;
    }
/*.blackdiv-for-header {
    height: 146px !important;
}*/
section.forumpost-scents .maxtwidths textarea{
  margin-bottom: 0px !important;
}
.whatyourmind-textarea{position: relative; margin-bottom: 25px;}
.cke_contents.cke_reset {
    height: 120px !important;
}

.red{
  color: #FF0000;
}
/*css added for making one tag as h1*/
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

  $user_subscribed=0;

if(Sentinel::check())
{
     $login_user = Sentinel::getUser();
     $login_id = $login_user['id'];
     $login_email = $login_user['email']; 
     $login_type = $login_user['user_type'];

     if($login_user->subscribed('main'))
     {
       $user_subscribed = 1;
     }
     else
     {
      $user_subscribed =0;
     }

}
  $urlcontainerid =  Request::input('containerid');
  $urlcontainerid = isset($urlcontainerid)?$urlcontainerid:'';

  $urlcontainer_id ='';
  if(isset($urlcontainerid))
  {
      $urlcontainer_id = base64_decode($urlcontainerid);
  }

  $search =  Request::input('search');
  if(isset($search) && !empty($search)){
   $search = str_replace(' ','-',$search); 
  }
  else{
    $search ='';
  }


 $urlsellerid =  Request::input('seller');
 $urlsellerid = isset($urlsellerid)?$urlsellerid:'';

  $urlseller_id ='';
  if(isset($urlsellerid))
  {
      $urlseller_id = base64_decode($urlsellerid);
  }



?>
<div class="container">





   <?php if(isset($banner_images_data) && !empty($banner_images_data)): ?>

     <?php if(isset($banner_images_data['banner_image6_desktop']) && !empty($banner_images_data['banner_image6_desktop']) && isset($banner_images_data['banner_image6_mobile']) && !empty($banner_images_data['banner_image6_mobile'])): ?> 
        <div class="adclass-maindiv">
        
         <a <?php if(isset($banner_images_data['banner_image6_link6'])): ?>  href="<?php echo e($banner_images_data['banner_image6_link6']); ?>" target="_blank" 
                <?php else: ?>  href="#" <?php endif; ?>>
                
            <figure class="cw-image__figure">
               <picture>

                 <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image6_mobile']) && isset($banner_images_data['banner_image6_desktop'])): ?> 
                  <source type="image/png" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image6_mobile']); ?>" media="(max-width: 621px)">
                  <source type="image/jpg" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image6_mobile']); ?>" media="(max-width: 621px)">
                   <source type="image/jpeg" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image6_mobile']); ?>" media="(max-width: 621px)">   
                 <?php endif; ?>
                 
                 <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image6_desktop']) && isset($banner_images_data['banner_image6_desktop'])): ?>    
                  <source type="image/png" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image6_desktop']); ?>" media="(min-width: 622px) and (max-width: 834px)">
                  <source type="image/jpg" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image6_desktop']); ?>" media="(min-width: 622px) and (max-width: 834px)">
                  <source type="image/jpeg" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image6_desktop']); ?>" media="(min-width: 622px) and (max-width: 834px)">
                 <?php endif; ?>

                  <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image6_desktop']) && isset($banner_images_data['banner_image6_desktop'])): ?> 
                        <img class="cw-image cw-image--loaded obj-fit-polyfill lozad" alt="slider image" aria-hidden="false" data-src="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image6_desktop']); ?>" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>">
                  <?php endif; ?>  

                </picture>
            </figure>
          </a>
        </div>    
     <?php endif; ?>  
  
   <?php endif; ?>  




<div class="formunbox-mainsection forum-box-tags">
     <?php echo e(csrf_field()); ?>


           <?php if(isset($urlcontainer_id) && !empty($urlcontainer_id)): ?>
            <a href="<?php echo e(url('/')); ?>/forum" class="forum-colum-list">
               POPULAR
            </a>
            <?php else: ?>
              <a href="<?php echo e(url('/')); ?>/forum" class="forum-colum-list active-cotainers">
               POPULAR
              </a>
            <?php endif; ?>

        <?php

        if($forum_containers)
        {   
            $cnt =1;$activeclass='';
            $background_keys = ['one','two','three','four','five','six'];
           
            foreach($forum_containers as $forum_container)
            {
                $container_bag = $background_keys[$cnt-1];

                $containerid = $forum_container['id'];

                if($urlcontainer_id==$containerid){
                  $activeclass = 'active-cotainers';
                }else{
                  $activeclass ='';
                }
                

            ?>
            <a href="javascript:void(0)" class="forum-colum-list  getpostdata  boxforum-<?php echo e($container_bag); ?> <?php echo e($activeclass); ?>"   containerid="<?php echo e($forum_container['id']); ?>" onclick="getpostdata(<?php echo e($forum_container['id']); ?>)" >
                <?php echo e(strtoupper($forum_container['title'])); ?>

               
            </a>
            <?php
                $cnt++;
                if($cnt==7)
                {
                    $cnt=1;

                }
            }
        } 
      ?>     
</div>

<!-----------------start of new scroll--------------------------------->

<div class="frms-mandv height-none">

 <!----------code for clear filter------------------>



<!-----------end-of-code for clear filter-------------->



<div class="row-view-class">
     <div class="leftbutton-what">
        <?php if(isset($user_subscribed) && $user_subscribed=="1" && isset($user_subscribe_data) && !empty($user_subscribe_data)): ?>
        <a href="javascript:void(0)" class="whatyoumindclass" id="showcreatepostmodal"> What's on your mind <img src="<?php echo e(url('/')); ?>/assets/front/images/editicon-png.png" alt="What's on your mind" /></a>
        <?php elseif(isset($user_subscribe_data) && !empty($user_subscribe_data) && $user_subscribed=="0" && $user_subscribe_data['is_cancel']=="1"): ?>
         <a href="<?php echo e(url('/')); ?>/seller/membership" class="whatyoumindclass" > What's on your mind <img src="<?php echo e(url('/')); ?>/assets/front/images/editicon-png.png" alt="What's on your mind"/></a>
        <?php else: ?>
        <a href="javascript:void(0)" class="whatyoumindclass" id="showcreatepostmodal"> What's on your mind <img src="<?php echo e(url('/')); ?>/assets/front/images/editicon-png.png" alt="What's on your mind" /></a>
        <?php endif; ?>
      </div>


     


      <div class="clearfix"></div>     
</div>




  <?php echo e(csrf_field()); ?>


  


</div> <!--end of frms-mandv--->



<!-----------------end of new scroll--------------------------------->





<!-------------------start of post---------------------->

    <div id="tag_container"> 
    <?php

     if($forum_posts)
      {               
         $get_comment_count =0; 
        foreach($forum_posts as $forum_post)
        {
          /*$get_comment_count = $ForumCommentsModel
                                 ->where('post_id',$forum_post['id']) 
                                ->whereNull('parent_id')->count();*/
            
        ?>           


            <div class="commentlist-box-main" >
                <div class="left-box-fum">
                    <div class="buttonlikesfrms">

                        
                      <?php if(isset($login_user)): ?>
                        <?php if($login_user == true): ?>
                        <?php
                              $dblike_dislike=0;
                              $color ='';  

                             /* $getlikecount = $likedislikemodel->where(['post_id' => $forum_post['id'],['like_dislike','1']])
                                    ->count();*/

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

                        

                        <a href="javascript:void(0)" class="like-one  givelikedislike <?php echo e($color); ?>"  postid="<?php echo e($forum_post['id']); ?>"  containerid="<?php echo e($forum_post['container_id']); ?>"  
                        dblikedislike="1"  ><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowup.png" alt="Forum Post"/></a>


                        <?php else: ?>
                         
                          <a href="<?php echo e(url('/')); ?>/login" class="like-one " postid="<?php echo e($forum_post['id']); ?>" >
                            <img src="<?php echo e(url('/')); ?>/assets/front/images/arrowup.png" alt="Forum Post"/></a>
                        <?php endif; ?>
                    <?php else: ?>
                       
                        <a href="<?php echo e(url('/')); ?>/login" class="like-one " postid="<?php echo e($forum_post['id']); ?>" ><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowup.png" alt="Chow420"/></a>
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
                       <a href="javascript:void(0)" class="dislike-one givelikedislike <?php echo e($color); ?> " postid="<?php echo e($forum_post['id']); ?>"  containerid="<?php echo e($forum_post['container_id']); ?>"  dblikedislike="2"><img src="<?php echo e(url('/')); ?>/assets/front/images/arrowdn.png" alt="Forum" /></a>
                        <?php else: ?>
                         <a href="<?php echo e(url('/')); ?>/login" class="dislike-one " postid="<?php echo e($forum_post['id']); ?>" >
                            <img src="<?php echo e(url('/')); ?>/assets/front/images/arrowdn.png" alt="Forum"/></a>
                        <?php endif; ?>
                       <?php else: ?>
                         <a href="<?php echo e(url('/')); ?>/login" class="dislike-one " postid="<?php echo e($forum_post['id']); ?>" >
                            <img src="<?php echo e(url('/')); ?>/assets/front/images/arrowdn.png" alt="Forum"/></a>
                       <?php endif; ?>

                    </div>
                </div>
                <div class="right-box-fum">
                    <div class="commentheaders">

                      <?php 
                             
                        $forum_title_slug = str_slug($forum_post['title']);
                        // $word_cnt = str_word_count($forum_post['title']);
                        $word_cnt = strlen($forum_post['title']);
                        $forum_title    = $forum_post['title'];
                        $forum_slug_url = get_post_title($forum_post['title']);


                      ?>

                        
                        <div class="postedby-div" style="display: inline-block; text-decoration:">
                            <?php if(isset($forum_post['container_details']['title'])): ?>
                            <a href="<?php echo e(url('/')); ?>/forum/view_post/<?php echo e(base64_encode($forum_post['id'])); ?>/<?php echo $forum_slug_url ?>" class="nametexts-frm">
                              <?php echo e(ucfirst($forum_post['container_details']['title'])); ?>

                            </a>  
                            <?php endif; ?> 


                            <span>Posted by:</span>
                           
 
                             <?php if(isset($login_user)): ?>
                              
                                 <?php if($login_user == true && $login_type==$forum_post['user_details']['user_type']): ?>

                                   <?php
                                   $setsellerurl = url('/').'/'.$login_type.'/'.'profile';
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
                                      }elseif($forum_post['user_details']['user_type']=="buyer"){
                                        $setsellerurl = url('/').'/'.$login_type.'/'.'profile';
                                      }elseif($forum_post['user_details']['user_type']=="admin"){
                                        $setsellerurl = url('/').'/book/account_settings';
                                      }
                                   ?>
 

                                   <a href="<?php echo e($setsellerurl); ?>" target="_blank">
                                      <span class="postbys-dv">
                                        <?php 
                                          $postedname='';

                                          if($forum_post['user_details']['user_type']=="seller")
                                          {
                                            if(isset($forum_post['user_details']['seller_detail']))
                                            {
                                               $postedname = $forum_post['user_details']['seller_detail']['business_name'];
                                            }//if isset seller detail
                                            else{

                                               if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']==""){
                                                  $postedname = $forum_post['user_details']['email'];
                                                } 
                                                else{
                                                  $postedname = ucwords($forum_post['user_details']['first_name']);
                                                }//else
                                            }//else first and last name
                                          }//if user type is seller
                                          else{

                                           if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']==""){
                                              $postedname = $forum_post['user_details']['email'];
                                            } 
                                            else{
                                              $postedname = ucwords($forum_post['user_details']['first_name']." ".$forum_post['user_details']['last_name']);
                                            }//else
                                          }//else for other user type
                                       
                                        ?>
                                   
                                            <?php echo e($postedname); ?>

                                       </span> 
                                    </a>
                                 <?php else: ?>
                                      <span class="postbys-dv">
                                        <?php 
                                          $postedname='';

                                          if($forum_post['user_details']['user_type']=="seller")
                                          {


                                            if(isset($forum_post['user_details']['seller_detail']))
                                            {
                                               $postedname = $forum_post['user_details']['seller_detail']['business_name'];
                                            }//if isset seller detail
                                            else
                                            {


                                              if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']=="")
                                              {
                                                $postedname = $forum_post['user_details']['email'];
                                              }
                                              else
                                              {
                                                $postedname = ucwords($forum_post['user_details']['first_name']);
                                              }//else
                                            }//else of not businessname

                                          }//if user type seller
                                          else
                                          { 
                                               if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']=="")
                                                $postedname = $forum_post['user_details']['email'];
                                              else
                                                $postedname = ucwords($forum_post['user_details']['first_name']." ".$forum_post['user_details']['last_name']);

                                          }//else of user type seller
                                        ?>


                                         <?php echo e($postedname); ?>

                                   
                                     </span> 
                                 <?php endif; ?> 

                             <?php else: ?>
                                 <span class="postbys-dv">
                                  
                                          <?php 
                                          $postedname='';
                                           if($forum_post['user_details']['user_type']=="seller")
                                          {


                                            if(isset($forum_post['user_details']['seller_detail']))
                                            {
                                               $postedname = $forum_post['user_details']['seller_detail']['business_name'];
                                            }//if isset seller detail
                                            else{

                                              if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']==""){
                                                $postedname = $forum_post['user_details']['email'];
                                              }
                                              else{
                                                $postedname = ucwords($forum_post['user_details']['first_name']);
                                               }//else
                                             }//else
                                           }//if seller
                                           else
                                           {
                                               if($forum_post['user_details']['first_name']=="" || $forum_post['user_details']['last_name']==""){
                                                 $postedname = $forum_post['user_details']['email'];
                                                }
                                                else{
                                                  $postedname = ucwords($forum_post['user_details']['first_name']." ".$forum_post['user_details']['last_name']);
                                                 }//else
                                           }//other user type


                                         ?>

                                        <?php echo e($postedname); ?>

                                  
                                 </span> 
                             <?php endif; ?>
                                
 
                            
                           

                            <?php if($forum_post['user_details']['user_type']=="seller"): ?>
                              <div class="sellertab-main">
                                <img data-src="<?php echo e(url('/')); ?>/assets/front/images/seller-tags.png" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" alt="Forum" class="lozad">
                              </div>
                            <?php endif; ?>

                            <?php if($forum_post['user_details']['user_type']=="admin"): ?>
                              <div class="sellertab-main">
                                <img data-src="<?php echo e(url('/')); ?>/assets/front/images/admin-tag.png" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" alt="Forum" class="lozad">
                              </div>
                            <?php endif; ?>



                        </div>

                         <div class="commentlist-title">
                          
                         




<!--------start-title------------------->
                 <div class="content"> 
                    <div class="hidecontent" id="hidecontent_<?php echo e($forum_post['id']); ?>">
                      <?php if(strlen($forum_post['title'])>100): ?>
                      

                         <a href="<?php echo e(url('/')); ?>/forum/view_post/<?php echo e(base64_encode($forum_post['id'])); ?>/<?php echo $forum_slug_url ?>" 
                              title="<?php echo strip_tags(ucfirst($forum_post['title'])) ?>">
                                <?php echo ucfirst(substr($forum_post['title'],0,100)) ?>
                            </a> 

                        <span class="show-more" style="color:grey;cursor: pointer; display: inline-block; text-decoration: none; margin-left: 10px;" onclick="return showmore(<?php echo e($forum_post['id']); ?>)">Show more</span>
                    
                      <?php else: ?>
                         <?php echo $forum_post['title'] ?>
                      <?php endif; ?>
                    </div>

                       <span class="show-more-content" style="display: none" id="show-more-content_<?php echo e($forum_post['id']); ?>">
                        
                           <a href="<?php echo e(url('/')); ?>/forum/view_post/<?php echo e(base64_encode($forum_post['id'])); ?>/<?php echo $forum_slug_url ?>"  title="<?php echo strip_tags(ucfirst($forum_post['title'])) ?>">
                              <?php echo ucfirst($forum_post['title']) ?> 
                            </a>
                        <span class="show-less" style="color:grey;cursor: pointer;display: inline-block; text-decoration: none;" onclick="return showless(<?php echo e($forum_post['id']); ?>)"  id="show-less_<?php echo e($forum_post['id']); ?>">Show less</span>
                      </span>

                 </div>

<!-----------end title------------------>














                         

                         <?php if(isset($forum_post['post_type']) && $forum_post['post_type']=="image" && isset($forum_post['image']) && file_exists(base_path().'/uploads/post/'.$forum_post['image']) && !empty($forum_post['image'])): ?>
                         <div class="forum-image">
                          <a href="<?php echo e(url('/')); ?>/uploads/post/<?php echo e($forum_post['image']); ?>" target="_blank">
                              <img data-src="<?php echo e(url('/')); ?>/uploads/post/<?php echo e($forum_post['image']); ?>" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" alt="Forum Post" class="lozad">
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
                                   <a href="<?php echo e($forum_post['link']); ?>" target="_blank" class="lnk-box-url"><i class="fa fa-link" ></i>
                                     <span><i class="fa fa-external-link"></i></span>
                                   </a>
                               </div>
                               <div class="clearfix"></div>
                            </div>


                             
                           <?php endif; ?>  

                        </div>


                        


                        <a href="<?php echo e(url('/')); ?>/forum/view_post/<?php echo e(base64_encode($forum_post['id'])); ?>/<?php echo $forum_slug_url ?>" class="commentbuttons">Comment</a>
                    </div>

                   
                    

                    <div class="footer-forum">

                        <img src="<?php echo e(url('/')); ?>/assets/front/images/chat-forum.png" alt="Forum" /> 
                        <span> 

                          <?php 
                          $commnt_count ='';                         
                          $commnt_count =   number_format_short($forum_post['comments_count']);
                          ?>

                          <?php echo e($commnt_count); ?>

                         
                         
                         Comments
                         
                      </span>
                       

                       <!-- code for share link -->

                        <div class="sre-product">
                            <p id="urlLink" style="display: none;" ><?php echo e(url('/')); ?>/forum/view_post/<?php echo e(base64_encode($forum_post['id'])); ?></p>

                              <a href="javascript:void(0)" class="shdebtns" data-id="<?php echo e(isset($forum_post['id']) ? $forum_post['id'] : ''); ?>" url_link="<?php echo e(url('/')); ?>/forum/view_post/<?php echo e(base64_encode($forum_post['id'])); ?>/<?php echo $forum_slug_url ?>"

                                onclick="shareLink('#urlLink',this)" title="Share this forum post" >

                              <img src="<?php echo e(url('/')); ?>/assets/front/images/chat-forum-share.png " alt="Forum Post" />
                              Share 
                            </a>
                            <div class="copeid-sms" id="copy_txt_<?php echo e($forum_post['id']); ?>" style="display:none;"> Link Copied!</div>
                        </div>  
                        <!-- ------------------------------------------------ -->

                         <div class="savebutton-forum">
                             <?php if(isset($login_user)): ?>
                                <?php if($login_user == true): ?>
                                    <a href="javascript:void(0)" postid="<?php echo e($forum_post['id']); ?>"  class="reportmodal">
                                     <img src="<?php echo e(url('/')); ?>/assets/front/images/report-icons.png" alt="Report" />
                                     Report
                                    </a>
                                <?php else: ?>
                                   <a href="<?php echo e(url('/')); ?>/login" postid="<?php echo e($forum_post['id']); ?>"  >
                                    <img src="<?php echo e(url('/')); ?>/assets/front/images/report-icons.png" alt="Report" />
                                    Report
                                  </a>
                                <?php endif; ?>
                             <?php else: ?>
                                   <a href="<?php echo e(url('/')); ?>/login" postid="<?php echo e($forum_post['id']); ?>"  >
                                    
                                    <img src="<?php echo e(url('/')); ?>/assets/front/images/report-icons.png" alt="Report" />

                                    Report
                                  </a>    
                            <?php endif; ?>
                         </div>


                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php
            
        }//forecah
    } //if
    else
    {
      
      ?>
      <div class="commentlist-box-main">
      <h3 align="center">No Posts Availiable</h3>
      </div>
    <?php  
    }
    ?>  

  </div> <!--my div--->


    <div class="pagination-chow">                                        
       <ul class="pagination">
            <?php if(!empty($arr_pagination)): ?>
                    
                <?php echo $arr_pagination->appends(Request::capture()->except('page'))->render(); ?>

            <?php endif; ?> 
           
        </ul>
    </div>




</div><!------end of container------->
 







<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

     <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="">
    <input type="hidden" name="hidden_post_id" id="hidden_post_id" value="">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" align="center">Report</h4>
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
         <img src="<?php echo e(url('/')); ?>/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" alt="Loading"/>
        <a class="shdebtns sendbuttons btn btn-info" id="sendreport" >Send</a>
      </div>
    </div>

  </div>
</div>




<!-- Modal -->
<div id="createpostModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form id="save_post_form" onsubmit="return false;" >
      <?php echo e(csrf_field()); ?>

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Post</h4>
      </div>
      <div class="modal-body">
          <section class="forumpost-scents">
          <div class="text maxtwidths">
            <div class="selectbx-frms"><label for="">Container</label>
              <div class="select-style">
                <select class="frm-select" id="container_id" name="container_id" data-parsley-required="true" data-parsley-required-message="Please select container">
                  <option value="">Select Container</option>

                   <?php 
                    if($forum_containers)
                    {   
                     foreach($forum_containers as $forum_container)
                      {
                        $dbcontainerid = $forum_container['id'];
                   ?> 

                  <option value="<?php echo e($dbcontainerid); ?>"><?php echo e($forum_container['title']); ?></option>
                  <?php 
                     }
                   }
                  ?>
                </select>
              </div>
              </div>


            <div class="whatyourmind-textarea">
                  <textarea placeholder="What's on your mind?" name="post_title" id="post_title" data-parsley-maxlength="400"></textarea>


                  <span class="red" id="error_title"></span>
                 
                  <!-- ck editor -->


            </div>
            <div class="links-add-vids">
              <a href="#" id="photodiv"> <img src="<?php echo e(url('/')); ?>/assets/front/images/photo.png" alt="Photo">Photo</a>
               <a href="#" id="linkdiv"> <img src="<?php echo e(url('/')); ?>/assets/front/images/videoicon-lnk.jpg" alt="Video">Video</a>
              <a href="#" id="linkbtndiv"> <img src="<?php echo e(url('/')); ?>/assets/front/images/hyperlink.png" alt="Link">Link</a>
            
            </div>
              <div class="main-fulllink" >
                <div class="profile-img-block">
                  <div class="update-pic-btns">
                    <button href="#" class="up-btn">Upload Photo</button>
                    <input id="image" name="image"  type="file" class="attachment_upload">
                  </div>
                  <div class="pro-img"><img class="img-responsive img-preview" alt="Upload Photo"/></div>
               </div>

               <div class="clearfix"></div>

              <div class="video-inout-link"><span>Video</span> 
                  <input type="text" placeholder="Enter Video Link" id="video" name="video">
              </div>
                  <span id="youtubeerr"></span>
              </div>
               <div class="pro-video">
               </div>
            
            <div class="lnkss-inout-link linkbtndivfield" style="display: none"><span>Link</span>
              <div class="input-clssds">
                  <input type="text" data-parsley-type="url" data-parsley-type-message="Please enter valid link"  placeholder="Enter Link" id="link" name="link">
                  </div>
            </div>


          </div>

           


        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="savepost">Post</button>
      </div>
    </div>
  </form>
  </div>
</div>


 
<?php $__env->stopSection(); ?>

<!-- page script start -->
<?php $__env->startSection("page_script"); ?>

<script src="<?php echo e(url('/')); ?>/assets/front/js/slick.js"></script>

<script>

/*global variable declaration*/

var login_id = "<?php echo e(isset($login_id) ? $login_id : ''); ?>";
var SITE_URL = '<?php echo e(url('/')); ?>';
  

 $(document).ready(function(){
     

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

  
          var brand = document.getElementById('image');
          brand.className = 'attachment_upload';
          brand.onchange = function() {
              document.getElementById('fakeUploadLogo').value = this.value.substring(12);
          };
          function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  
                  reader.onload = function(e) {
                      $('.img-preview').attr('src', e.target.result);
                    
                  };
                  
                  reader.readAsDataURL(input.files[0]);
              }
          }

          $("#image").change(function() {
              readURL(this);
              $('#video').val('');
          });
     

    
 });
 

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


   
function getpostdata(containerid='')
{
  if(containerid){
      window.location.href="<?php echo e(url('/')); ?>/forum?containerid="+btoa(containerid);
  }else{
     window.location.href="<?php echo e(url('/')); ?>/forum";
  }
}


$(document).on('click','#searchpost',function(){
    var urlcontainer_id = "<?php echo e($urlcontainerid); ?>";
    var urlseller_id = "<?php echo e($urlsellerid); ?>";
  
    var search = $("#search").val();
    var search = search.replace(/\s+/g, "-");

    if(search.trim()!='' && urlcontainer_id.trim()!='' && urlseller_id.trim()!='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?seller="+urlseller_id+"&containerid="+urlcontainer_id+"&search="+search;
        }
        else if(search.trim()!='' && urlcontainer_id.trim()!='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?containerid="+urlcontainer_id+"&search="+search;
        }
         else if(search.trim()!='' && urlseller_id.trim()!='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?seller="+urlseller_id+"&search="+search;
        }
        else if(search.trim()!='' && urlcontainer_id.trim()=='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?search="+search;
        }
        else if(search.trim()!='' && urlseller_id.trim()=='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?search="+search;
        }
        else{
           window.location.href="<?php echo e(url('/')); ?>/forum";
         } 



});

$('#search').keypress(function (e) {
     var key = e.which;
     if(key == 13)  /*the enter key code*/
      {
         var urlcontainer_id = "<?php echo e($urlcontainerid); ?>";
          var urlseller_id = "<?php echo e($urlsellerid); ?>";
         var search = $("#search").val();
         var search = search.replace(/\s+/g, "-");


        if(search.trim()!='' && urlcontainer_id.trim()!='' && urlseller_id.trim()!='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?seller="+urlseller_id+"&containerid="+urlcontainer_id+"&search="+search;
        }
        else if(search.trim()!='' && urlcontainer_id.trim()!='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?containerid="+urlcontainer_id+"&search="+search;
        }
         else if(search.trim()!='' && urlseller_id.trim()!='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?seller="+urlseller_id+"&search="+search;
        }
        else if(search.trim()!='' && urlcontainer_id.trim()=='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?search="+search;
        }
        else if(search.trim()!='' && urlseller_id.trim()=='')
        {
          window.location.href="<?php echo e(url('/')); ?>/forum?search="+search;
        }
        else{
           window.location.href="<?php echo e(url('/')); ?>/forum";
         } 

   /*  var link = "<?php echo e(url('/')); ?>/forum?search="+search;
      
     if(urlcontainer_id)
     {
       link +="&containerid="+urlcontainer_id;
     }  
      if(urlseller_id)
     {
       link +="&seller="+urlseller_id;
     }  
      window.location.href = link;  
*/

      }/*if enter event*/
 })



 $(document).on('click','.reportmodal',function(){ 

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
                
                $("#loaderimg").show();
                $("#sendreport").hide();
              },  
              success:function(response)
              {
                $("#loaderimg").hide();
                $("#sendreport").show();
               
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
               }/*success*/  
           }); 



    }else{
      return false;
    }  
    
  });


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


function copyToClipboard(text) {
  if (window.clipboardData && window.clipboardData.setData) {
   /* IE specific code path to prevent textarea being shown while dialog is visible.*/
    return clipboardData.setData("Text", text);

  } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
    var textarea = document.createElement("textarea");
    textarea.textContent = text;
    textarea.style.position = "fixed"; /*Prevent scrolling to bottom of page in MS Edge.*/
    document.body.appendChild(textarea);
    textarea.select();
    try {
      return document.execCommand("copy"); /*Security exception may be thrown by some browsers.*/
    } catch (ex) {
      console.warn("Link copied failed.", ex);
      return false;
    } finally {
      document.body.removeChild(textarea);
    }
  }
}

function status(clickedBtn,id) {
  var postid = id;
   
  var text = document.getElementById(clickedBtn.dataset.descRef).innerText;

   copyToClipboard(text);

 /* document.getElementById("copy_"+postid).style.display = "block";//commented on 12 june20*/
   swal('Success','Link Copied','success');

  clickedBtn.value = "Link Copied!";
  clickedBtn.disabled = true;
  clickedBtn.style.color = 'white';
  clickedBtn.style.background = 'gray';

}


  
  function load_data(id)
 {
    $.ajax({ 
        url:SITE_URL+"/forum/load_post",
        method:"GET",
        data:{id:id},
        dataType:'json',
        beforeSend: function(){     
            /*$(ref).attr('disabled');          
            $(ref).html('<div class="add_to_cart">Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i></div>');*/        
        },
        success:function(response)
        {
            if(response.status=="success")
            {
                $('#load_more_button').remove();
                $('#post_data').append(response.posts);
            }
            else
            {
                $('#load_more_button').remove();                
                $('#post_data').append('');
            }
        }
    })
 }


//CKEDITOR INITIALISATON
CKEDITOR.replace( 'post_title',
{
  toolbar :
  [
    // { name: 'basicstyles', items : [ 'Bold','Italic' ] },
    // { name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
    // { name: 'tools', items : [ 'Maximize','-','About' ] }
  // { name: 'document', items : [ 'NewPage','Preview' ] },
    { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
    { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
    // { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
    //             '/',
    { name: 'styles', items : [ 'Styles','Format' ] },
    { name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
    { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
    { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
    { name: 'tools', items : [ 'Maximize','-','About' ] }
  ]
});
                 
  
 
  $(document).on('click','#showcreatepostmodal',function(){
     if(login_id==""){
       
       window.location.href="<?php echo e(url('/')); ?>/login/forum";
     }else{
      $('#save_post_form').parsley().reset();
       $("#youtubeerr").hide();
        $("#link").val('');
        $("#post_title").val('');

      $("#createpostModal").modal('show');
   
     $(".profile-img-block").hide();
     $(".video-inout-link").hide();
   }/*else*/
  });


  /*code for share link*/
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
       
      $("#copy_txt_"+postId).fadeIn(400);
      $("#copy_txt_"+postId).fadeOut(2000);

  } 



    $(document).on('click','#linkdiv',function(){ 
     
      $(".profile-img-block").hide();
       $(".video-inout-link").show();
       $(".pro-video").show();
       $("#youtubeerr").show();
       $(".linkbtndivfield").hide();
    });
     $(document).on('click','#photodiv', function(){ 
      $(".profile-img-block").show();
      $(".video-inout-link").hide();
      $(".pro-video").hide();
      $("#youtubeerr").hide();
      $(".linkbtndivfield").hide();

    });

     $(document).on('click','#linkbtndiv', function(){ 
       $(".pro-video").hide();
      $("#youtubeerr").html('');
      $(".profile-img-block").hide();
      $(".video-inout-link").hide();
      $("#video").val('');
      $(".pro-video").html('');
      $(".linkbtndivfield").show();
       $("#savepost").show();
    });
 

     



/*Check image validation on upload file*/
$("#image").on("change", function(e) 
{   
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                           "image/JPG", "image/JPEG", "image/PNG"];
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
      swal('Alert!','Please select valid image type. Only jpg, jpeg and png file is allowed.');

      $('#'+selectedID).val('');

      var previewImageID = selectedID+'_preview';
      $('#'+previewImageID+' + img').remove();
    }
    else
    {
      $(".video-inout-link").hide();
      $(".pro-video").hide();
      $("#youtubeerr").html('');
      $("#video").val('');
       $("#link").val('');
      $(".linkbtndivfield").hide();
       $("#savepost").show();
    }
});


   $('#video').on('input', function(){ 

      var video = $("#video").val();
      if(video!=''){
      if(video.indexOf('youtube') > -1) {
      
           var vidarr = video.split("v=");
           var vid = vidarr[1];
         $(".pro-video").show();
       
        $(".pro-video").html('<iframe width="100" height="100" src="https://www.youtube.com/embed/'+vid+'"></iframe>');
        $("#savepost").show();
        $("#youtubeerr").hide();
        $("#image").val('');
     }else{
     
        $("#savepost").hide();
         $("#youtubeerr").show();
        $("#youtubeerr").html('Please enter valid youtube video url');
        $("#youtubeerr").css('color','red');
        $(".pro-video").hide();

     }
    }/*if video not empty*/
    else{
     $("#youtubeerr").hide();
      $("#savepost").show();
    }  
});



$(document).on('click','#savepost',function(){

    var _token = $('input[name="_token"]').val();
    var SITE_URL = '<?php echo e(url('/')); ?>';

    var post_title = CKEDITOR.instances['post_title'].getData();


    if(post_title == '')
    { 
        $("#error_title").html("Please enter the title.");
    }

    if($('#save_post_form').parsley().validate()==false) return;

  

    formdata = new FormData($('#save_post_form')[0]);
    formdata.set('post_title',post_title);
    

    if($('#save_post_form').parsley().isValid() == true )
    {         
      var video = $("#video").val();
      var vidarr = video.split("v=");
      var vid = vidarr[1];


        $.ajax({
            url:SITE_URL+'/forum/forum_post_store',
           /*data:form_data,*/
            data:formdata,
            method:'POST',     
            dataType:'json', 
             contentType:false,
            processData:false,
            cache: false,      
            beforeSend : function()
            {
              showProcessingOverlay();
              $('#savepost').prop('disabled',true);
              $('#savepost').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
                hideProcessingOverlay();
                $('#savepost').prop('disabled',false);
                $('#savepost').html('Post');
                if(response.status=="success")
                {
                    $('#forum_comment_text').val('');
                    $('#comment_data').html('');
                    window.location.reload();
                    
                }else{
                    swal('Appologies!',response.description,'warning');
                }

            }
        });
        return false;
    }
});


  $(window).scroll(function(){
    if ($(this).scrollTop() > 2) {
       $('body').addClass('newclassscroll');
    } else {
       $('body').removeClass('newclassscroll');
    }
});
 

</script>

<?php $__env->stopSection(); ?>











 


<?php echo $__env->make('front.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>