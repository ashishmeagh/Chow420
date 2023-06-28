<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TblContainerModel;
use App\Models\ForumPostsModel;

use App\Models\ForumCommentsModel;

use App\Models\ForumLikeDislikeModel;
use App\Models\PostReportModel;
use App\Models\ForumCommentLikeDislikeModel;
use App\Models\ForumReplyLikeDislikeModel;
use App\Models\UserSubscriptionsModel;
use App\Models\EventModel;
use App\Models\SellerModel;
use App\Models\FollowModel;
use App\Models\UserModel;
use App\Models\BannerImagesModel;

use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Common\Services\UserService;

use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Sentinel;

class ForumController extends Controller
{
        
    public function __construct(
                                 TblContainerModel $TblContainerModel,
                                 ForumPostsModel $ForumPostsModel,
                                 ForumLikeDislikeModel $ForumLikeDislikeModel,
                                 PostReportModel $PostReportModel,
                                 GeneralService $GeneralService,
                                 EmailService $EmailService,

                                 ForumCommentsModel $ForumCommentsModel,
                                 ForumCommentLikeDislikeModel $ForumCommentLikeDislikeModel,
                                 ForumReplyLikeDislikeModel $ForumReplyLikeDislikeModel,UserSubscriptionsModel $UserSubscriptionsModel,
                                 EventModel $EventModel,
                                 SellerModel $SellerModel,
                                 FollowModel $FollowModel,
                                 UserModel $UserModel,
                                 UserService $UserService,
                                 BannerImagesModel $BannerImagesModel

                                // SiteSettingModel $SiteSettingModel
                               )
    {
        $this->TblContainerModel = $TblContainerModel;
        $this->ForumPostsModel = $ForumPostsModel;

        $this->ForumCommentsModel = $ForumCommentsModel;
        $this->ForumLikeDislikeModel = $ForumLikeDislikeModel;
        $this->PostReportModel = $PostReportModel;
        $this->GeneralService = $GeneralService;
        $this->EmailService = $EmailService;

        $this->ForumCommentLikeDislikeModel = $ForumCommentLikeDislikeModel;
        $this->ForumReplyLikeDislikeModel = $ForumReplyLikeDislikeModel;
        $this->UserSubscriptionsModel  =   $UserSubscriptionsModel;
        $this->EventModel      = $EventModel;
        $this->SellerModel     = $SellerModel;
        $this->FollowModel     = $FollowModel;
        $this->UserModel       = $UserModel;
        $this->UserService     = $UserService;
        $this->BannerImagesModel = $BannerImagesModel;
        
        $this->module_view_folder         = 'front';
        $this->module_url_path            = url('/forum');
        $this->back_path                  = url('/').'/forum';

        $this->module_title               = 'Forum';
        $this->arr_view_data              = [];
        $this->post_base_path   = base_path().config('app.project.img_path.post');

    }

    public function index(Request $request)
    {   
      
         $apppend_data= [];
         $containerid = base64_decode($request->containerid);

         $search = isset($request->search)?str_replace('-',' ',$request->search):'';

         $sellerid = base64_decode($request->seller);

        $this->module_title               = 'Forum';
        $this->arr_view_data['page_title'] = 'Forum';
        $this->arr_view_data['forum_containers'] = ''; 

        $arr_data = [];
        $forum_containers =  $this->TblContainerModel->where('is_active','1')->orderBy('id','DESC')->get(); 
        if($forum_containers)
        {
            $forum_containers= $forum_containers->toArray(); 
            $this->arr_view_data['forum_containers'] = $forum_containers;

        }
        $this->arr_view_data['forum_posts'] = ''; 

        if($containerid){ 
            $forum_posts =  $this->ForumPostsModel->with('user_details','user_details.seller_detail','container_details','like_details','get_like_count')
                                        //->withCount('comments')
                                        ->withCount(['comments' => function ($query) { 
                                           // $query->whereNull('parent_id'); 
                                          }])
                                        ->withCount(['get_like_count' => function ($query) { 
                                            $query->where('like_dislike','1'); 
                                          }])
                                        ->where('is_active','1')
                                        ->where('container_id',$containerid)
                                        // ->orderBy('comments_count','DESC');
                                         ->orderBy('id','DESC');
                                        //->get(); 

                // if isset search filter                         
                 if(isset($search) && !empty($search))
               {
                 $forum_posts->where('title','like','%'.$search.'%');
               }  

               //if isset seller id 
                 if(isset($sellerid) && !empty($sellerid))
               {
                 $forum_posts->where('user_id',$sellerid);
               }  

                $forum_posts =  $forum_posts->get();                                 

          }else{
            $forum_posts =  $this->ForumPostsModel->with('user_details','user_details.seller_detail','container_details','like_details','get_like_count')
                                        //->withCount('comments')
                                        ->withCount(['comments' => function ($query) { 
                                          //  $query->whereNull('parent_id'); 
                                          }])
                                        ->withCount(['get_like_count' => function ($query) { 
                                            $query->where('like_dislike','1'); 
                                          }])
                                        ->where('is_active','1')
                                        ->orderBy('id','DESC')
                                        ->orderBy('comments_count','DESC');
                                       // ->get(); 
            //if isset search                            
           if(isset($search) && !empty($search))
           {
             $forum_posts->where('title','like','%'.$search.'%');
           }   

           //if isset seller id 
             if(isset($sellerid) && !empty($sellerid))
           {
             $forum_posts->where('user_id',$sellerid);
           }                

          $forum_posts =  $forum_posts->get();                        

        }
        
        if($forum_posts)
        {
            $forum_posts= $forum_posts->toArray(); 
            
        } 

        if(isset($containerid)) 
        {
            $apppend_data['containerid'] =  $containerid;
        }
        if(isset($sellerid)) 
        {
            $apppend_data['sellerid'] =  $sellerid;
        }

        $apppend_data = url()->current();
        // dd($apppend_data);
        if($request->has('page'))
        {   
            $pageStart = $request->input('page'); 
        }
        else
        {
            $pageStart = 1; 
        }
        
        $total_results = count($forum_posts);


            

       // $paginator = $this->GeneralService->get_pagination_data($order_arr, $pageStart, 9 , $apppend_data);
        $paginator = $this->get_pagination_data($forum_posts, $pageStart, 100 , $apppend_data);

        if($paginator)
        {
            $user_sub_data=[];
            if(Sentinel::check())
            {
                $user_id = Sentinel::check()->id;  
                $login_user = Sentinel::getUser();
                $login_id = $login_user['id'];

                $user_sub_data =  $this->UserSubscriptionsModel->where
                            ('user_id',$login_id)
                            ->orderBy('id','desc')
                            ->first();

                if(isset($user_sub_data) && !empty($user_sub_data))
                {
                    $user_sub_data = $user_sub_data->toArray();
                }


            }



           $get_banner_images = $this->BannerImagesModel->first();
           if(isset($get_banner_images) && !empty($get_banner_images))
           {
              $get_banner_images = $get_banner_images->toArray();
           }
            $this->arr_view_data['banner_images_data']  = isset($get_banner_images)?$get_banner_images:[];
            
            $this->arr_view_data['user_subscribe_data']     = isset($user_sub_data)?$user_sub_data:[];

            $arr_user_pagination                    = $paginator; 
            $arr_data                               = $paginator->items();
            $arr_pagination                         = $paginator;  
            $this->arr_view_data['forum_posts']    = $arr_data;           
            $this->arr_view_data['arr_pagination']  = $arr_pagination;
            $this->arr_view_data['total_results']   = $total_results;
            $this->arr_view_data['containerid']     = $containerid;
            $this->arr_view_data['sellerid']     = $sellerid;

            return view($this->module_view_folder.'/forum/index',$this->arr_view_data);
            
        }    
    } 


    public function view_post($enc_id)
    {   
        
        $id = base64_decode($enc_id);

        $this->module_title               = 'Forum';
        $this->arr_view_data['page_title'] = 'Forum Comments';
        $this->arr_view_data['forum_containers'] = ''; 
        $forum_containers =  $this->TblContainerModel->where('is_active','1')->orderBy('id','DESC')->get(); 
        if($forum_containers)
        {
            $forum_containers= $forum_containers->toArray(); 
            $this->arr_view_data['forum_containers'] = $forum_containers;        
        }
        $this->arr_view_data['forum_posts'] = ''; 

        $forum_posts =  $this->ForumPostsModel->with('user_details','user_details.seller_detail','container_details','get_like_count')
                                            //->withCount('comments')
                                            ->withCount(['comments'=>function($query){
                                                   // $query->whereNull('parent_id'); 
                                             }])
                                            ->withCount(['get_like_count' => function ($query) { 
                                                $query->where('like_dislike','1'); 
                                             }])
                                            ->orderBy('comments_count','DESC')
                                            ->where('id',$id)
                                            ->where('is_active','1')
                                            ->get(); 

        if($forum_posts && (!empty($forum_posts)))
        {
            $forum_posts = $forum_posts->toArray(); 
      
            if($forum_posts)
            {

            } else{
              
                return redirect('/forum');

            }
            
        }
        else{
          
            return redirect('/forum');

        }

        $this->arr_view_data['forum_posts'] = isset($forum_posts)?$forum_posts:'';
        $this->arr_view_data['comment_count'] = isset($comment_count)?$comment_count:'';
        return view($this->module_view_folder.'/forum/view_post',$this->arr_view_data);
        
    }


    public function get_pagination_data($arr_data = [], $pageStart = 1, $per_page = 0, $apppend_data = [])
    {
        
        $perPage  = $per_page; /* Indicates how many to Record to paginate */
        $offSet   = ($pageStart * $perPage) - $perPage; /* Start displaying Records from this No.;*/        
        $count    = count($arr_data);
        /* Get only the Records you need using array_slice */
        $itemsForCurrentPage = array_slice($arr_data, $offSet, $perPage, true);

        /* Pagination to an Array() */
         $paginator =  new LengthAwarePaginator($itemsForCurrentPage, $count, $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));      
          

        $paginator->appends($apppend_data); /* Appends all input parameter to Links */
        
        return $paginator;
    }

    /*********************************************************/
        /*public function load_post(Request $request)
        {

            $response['posts'] ='';
            if(Sentinel::check())
            {
                $user_id = Sentinel::check()->id;  
                $login_user = Sentinel::getUser();
                $login_id = $login_user['id'];
            }
            if($request->ajax())
            {
                $containerid = $request->containerid;
                if($containerid)
                {
                         $forum_posts =  $this->ForumPostsModel->with('user_details','container_details','like_details')
                                        ->withCount('comments')
                                        ->where('is_active','1')
                                        ->where('container_id',$containerid)
                                        ->orderBy('id','DESC')
                                        ->get(); 
                            if($forum_posts)
                            {
                                $forum_posts= $forum_posts->toArray(); 
                              //  dd($forum_posts);

                                if($request->has('page'))
                                {   
                                    $pageStart = $request->input('page'); 
                                }
                                else
                                {
                                    $pageStart = 1; 
                                }
                                
                                $total_results = count($forum_posts);

                                $paginator = $this->get_pagination_data($forum_posts, $pageStart, 1 , $apppend_data);

                                    if($paginator)
                                    {
                                    
                                        $arr_user_pagination                    = $paginator; 
                                        $arr_data                               = $paginator->items();
                                        $arr_pagination                         = $paginator;  
                                        $this->arr_view_data['forum_posts']    = $arr_data;           
                                        $this->arr_view_data['arr_pagination']  = $arr_pagination;
                                        $this->arr_view_data['total_results']   = $total_results;
                                        return view($this->module_view_folder.'/forum/index',$this->arr_view_data);
                                        
                                    }    


                            } 
                }

                return response()->json($response);
            }
            else{

            }
        }*/

    /**********************************************************/



    public function load_post_comments(Request $request)
    {
         if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;  
            $login_user = Sentinel::getUser();
            $login_id = $login_user['id'];
        }
 

        if($request->ajax())
        {
            $response['comments'] ='';
            if($request->id > 0)
            {
                $post_comments = DB::table('forum_comments')
                    ->selectRaw('forum_comments.*,users.id as userid,users.first_name,users.last_name,users.email,users.user_type')
                    ->where('forum_comments.id', '<', $request->id)
                    ->leftjoin('users', 'forum_comments.user_id', '=', 'users.id')
                    ->where('forum_comments.post_id', '=', $request->post_id)
                    ->whereNull('forum_comments.parent_id')
                    ->orderBy('forum_comments.id', 'DESC')
                    ->limit(10)
                    ->get();
            }
            else
            {
                $post_comments = DB::table('forum_comments')
                    ->selectRaw('forum_comments.*,users.id as userid,users.first_name,users.last_name,users.email,users.user_type')
                    ->leftjoin('users', 'forum_comments.user_id', '=', 'users.id')              
                    ->where('forum_comments.post_id', '=', $request->post_id)  
                    ->whereNull('forum_comments.parent_id')

                    ->orderBy('forum_comments.id', 'DESC')
                    ->limit(10)
                    ->get();
            }
            $output = '';
            $last_id = '';
          //  $comment_count = $this->ForumCommentsModel->where('post_id',$request->post_id)->count();
            $comment_count = $this->ForumCommentsModel
                                                //->whereNull('parent_id')
                                                ->where('post_id',$request->post_id)->
                                                count();

           // $response['comment_count'] = $comment_count;
            $response['comment_count'] = number_format_short($comment_count);
            
            if(!$post_comments->isEmpty())
            {   
                
                $response['status'] = "success";
                
                foreach($post_comments as $comment)
                {
                    
                    $get_reply = $this->ForumCommentsModel->where('parent_id',$comment->id)->get()->toArray();
                    
                    $appendsellerhtml ='';
                    if($comment->user_type=="seller")
                    {
                        $appendsellerhtml ='<div class="sellertab-main">
                              <img src="'.url('/').'/assets/front/images/seller-tags.png" alt="">
                              </div>';
                    }
                    else if($comment->user_type=="admin")
                    {
                        $appendsellerhtml ='<div class="sellertab-main">
                              <img src="'.url('/').'/assets/front/images/admin-tag.png" alt="">
                              </div>';
                    }


                    $comment_date = Carbon::parse($comment->created_at)->diffForHumans();
                    $setcommentname ='';

                    if($comment->user_type=="seller"){
                        if($comment->first_name=="" || $comment->last_name=="")
                        {
                            $setcommentname = $comment->email;
                        }else{
                            $setcommentname = ucwords(get_seller_details($comment->userid));
                        }

                    }else{
                        if($comment->first_name=="" || $comment->last_name=="")
                        {
                            $setcommentname = $comment->email;
                        }else{
                            $setcommentname =  ucwords($comment->first_name." ".$comment->last_name);
                        }
                    }//else other user type

                  


                    $response['comments'] .= '
                    <div class="comments-post">
                        <div class="box">
                            <h4>'.$setcommentname.$appendsellerhtml.'</h4>
                            <small>'.$comment_date.'</small>
                            <p>'.$comment->comment.'</p>
                            <ul class="list-inline">                            
                                ';

                    /*************************************************/    
                    if(isset($login_user))
                    {
                        if($login_user == true)
                        { 
                            $dblike_dislike=0;
                            $color ='style=color:grey';  

                             $getlikecount = $this->ForumCommentLikeDislikeModel
                                            ->where('post_id',$comment->post_id)
                                            ->where('comment_id',$comment->id)
                                            ->where('like_dislike','1')
                                            ->count();    


                       
                            $getlikeofuser = $this->ForumCommentLikeDislikeModel
                                            ->where('post_id',$comment->post_id)
                                            ->where('comment_id',$comment->id)
                                            ->where('like_dislike','1')
                                            ->where('user_id',$login_id)->first();

                            if(isset($getlikeofuser) && !empty($getlikeofuser))
                            {
                                $getlikeofuser = $getlikeofuser->toArray();
                                $dblike_dislike = $getlikeofuser['like_dislike'];
                                if($dblike_dislike=='1')
                                    $color = 'style=color:#b833cb';
                                else
                                    $color ='style=color:grey';   

                            }            

                            $response['comments'] .= '<li><a id="reply_btn" class="reply_btn"  data-id="'.$comment->id.'" data-post_id="'.$comment->post_id.'"  data-container_id="'.$comment->container_id.'"    data-parent_id="'.$comment->id.'"   data-c_type="reply" href="javascript:void(0);"><i class="fa fa-reply"></i> Reply</a></li>
                            ';
                            $response['comments'] .= '<li><a href="javascript:void(0)" class="givelike_comment" '.$color.' postid="'.$comment->post_id.'"    containerid="'.$comment->container_id.'"            commentid="'.$comment->id.'" userid="'.$login_id.'"   dblikedislike="'.$dblike_dislike.'"><i class="fa fa-thumbs-up"></i> Like</a></li>';
                        }//if login user
                    }else{
                        $loginurl = url('/').'/login';

                        $response['comments'] .= '<li><a  href="'.$loginurl.'"><i class="fa fa-reply"></i> Reply</a></li>';
                        $response['comments'] .= '<li><a href="'.$loginurl.'"><i class="fa fa-thumbs-up"></i> Like</a></li>';
                    }

                             /*************************************************/


                          $response['comments'] .= '</ul> ';
                           //both buttons code added here
                           if(!empty($get_reply))
                            {
                                $html ='';
                                

                                  $html .= '<a href="javascript:void(0)" class="btn postbtn seereplybtn" id="seereplybtn_'.$comment->id.'_'.$comment->post_id.'" comment_id='.$comment->id.' comment_post_id='.$comment->post_id.'> See Reply </a>';

                                  $html .= ' <a href="javascript:void(0)" class="btn postbtn hidereplybtn" comment_id='.$comment->id.' comment_post_id='.$comment->post_id.'    id="hidereplybtn_'.$comment->id.'_'.$comment->post_id.'"   style="display:none"> Hide Reply </a>';

                                $html .= '<div class="ShowCommentReply" id="ShowCommentReply_'.$comment->id.'_'.$comment->post_id.'" comment_id='.$comment->id.' comment_post_id='.$comment->post_id.'></div>';

                                /******************uncommented************************/
                               $response['comments'] .= $html;
                            }


                     $response['comments'] .= '</div>';

                           

                    $response['comments'] .= '</div>';
                    $last_id = $comment->id;

                  


                }//foreach
                // dd(123);
                if(count($post_comments)>=10)
                {
                    // dd(123);
                    $response['comments'] .= '
                       <div id="load_more" class="load_more_div text-center">
                        <button type="button" name="load_more_button" class="btn form-control forum-load_more_button" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                       </div>
                   ';
               }
            }
            else
            {
                $response['status'] = "failed";
                $response['comments'] .= '';
            }
            return response()->json($response);
        }
        
    }

    function givelikedislike(request $request)
    {
       $containerid = $request->containerid;
       $postid = $request->postid;
       $dblikedislike = $request->dblikedislike;

       if($dblikedislike=="1")
        $settitle ="liked";
       elseif($dblikedislike=="2")
       $settitle ='disliked'; 


        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;  
             $user_details = Sentinel::getUser();
             $from_user_id = $user_details->id;

                if($user_details->user_type=="seller"){

                    if($user_details->first_name=="" || $user_details->last_name==""){
                     $user_name =$user_details->email; 
                    }else{
                         $user_name = get_seller_details($user_details->id);
                    }

                }//if user type is seller
                else{
                    if($user_details->first_name=="" || $user_details->last_name==""){
                     $user_name =$user_details->email; 
                    }else{
                         $user_name = $user_details->first_name.' '.$user_details->last_name;
                    }
                }//else of other type
               

        }

        if($user_id && $postid)
        {

            $get_likedata = $this->ForumLikeDislikeModel
                                    ->where('user_id',$user_id)
                                    ->where('post_id',$postid)
                                    ->where('container_id',$containerid)
                                   // ->where('like_dislike',$dblikedislike)
                                    ->first();

              $postdata = $this->ForumPostsModel->where('id',$postid)->first();
       
                if(!empty($postdata))
                {
                    $postdata = $postdata->toArray();
                }                      

                $link =  url('/').'/forum/view_post/'.base64_encode($postid);

            if(empty($get_likedata))
            {   
                $insertdata = [];
                $insertdata['user_id']= $user_id;
                $insertdata['post_id'] = $postid;
                 $insertdata['container_id'] = $containerid;
               // $insertdata['like_dislike'] = '1';
                $insertdata['like_dislike'] = $dblikedislike;


                $this->ForumLikeDislikeModel->create($insertdata);

                 $response['status']      = 'SUCCESS';
                 $response['description'] = 'Post '.$settitle.' successfully.';


                    /*****************send notification ************/
                    if($dblikedislike=="1"){

                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }



                    /********************noti to admin****************/

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has '.$settitle.' the post <a target="_blank" href="'.$link.'"><b>'.$postdata['title'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Post '.$settitle;
                    $this->GeneralService->save_notification($arr_event);

                    /*********************noti to post owner userid***********/

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $postdata['user_id'];
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has '.$settitle.' the post <a target="_blank" href="'.$link.'"><b>'.$postdata['title'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Post '.$settitle;
                    $this->GeneralService->save_notification($arr_event);

                    /************************************************/



                    // $msg     = html_entity_decode('<b>'.$user_name.'</b> has '.$settitle.' the post <b>' . $postdata['title'].'</b>');

                    //$subject = 'Post '.$settitle;

                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                        //'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'POST_TITLE'    => $postdata['title']
                    ];

                    $arr_mail_data['email_template_id'] = '90';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_mail_section($arr_mail_data);
                    

                    // notification to user
                    $msg     = html_entity_decode('<b>'.$user_name.'</b> has '.$settitle.' the post <b>' . $postdata['title'].'</b>');

                    $subject = 'Post '.$settitle;

                    $getreceiver = Sentinel::findById($postdata['user_id']);
                    // dd($getreceiver);
                    $recuser_name='';
                    if($getreceiver)
                    {
                        if($getreceiver->user_type=="seller"){
                              $recuser_name = get_seller_details($getreceiver->id);
                        }else{
                              $recuser_name = $getreceiver->first_name." ".$getreceiver->last_name;
                        }
                      
                    }
                    $arr_built_content = [
                        'USER_NAME'     => $recuser_name,
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'POST_TITLE'    => $postdata['title']

                    ];

                    $arr_mail_data['email_template_id'] = '90';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($postdata['user_id']);
                   // if($postdata['user_id']==$getreceiver->id){}else{
                     $this->EmailService->send_mail_section($arr_mail_data);
                   // }

                      /*****************send notification ************/
                }//if like then only send notification  


            }else{
                $updatedata = [];

              
                $updatedata['like_dislike'] = $dblikedislike;

                $update_status  = $this->ForumLikeDislikeModel
                                ->where('post_id',$postid)
                                ->where('user_id',$user_id)
                                ->where('container_id',$containerid)
                                ->update($updatedata);

                  if($update_status && $dblikedislike=='1')
                  {
                     $response['status']      = 'SUCCESS';
                    // $response['description'] = 'Post disliked successfully.';
                     $response['description'] = 'Post liked successfully.';


                       /*****************send notification ************/


                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                     /********************noti to admin****************/

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has '.$settitle.' the post <a target="_blank" href="'.$link.'"><b>'.$postdata['title'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Post '.$settitle;
                    $this->GeneralService->save_notification($arr_event);

                     /********************noti to post owner****************/

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $postdata['user_id'];
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has '.$settitle.' the post <a target="_blank" href="'.$link.'"><b>'.$postdata['title'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Post '.$settitle;
                    $this->GeneralService->save_notification($arr_event);



                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'POST_TITLE'    => $postdata['title']
                    ];

                    $arr_mail_data['email_template_id'] = '90';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_mail_section($arr_mail_data);


                     // notification to user
                    $msg     = html_entity_decode('<b>'.$user_name.'</b> has '.$settitle.' the post <b>' . $postdata['title'].'</b>');

                    $subject = 'Post '.$settitle;

                    $getreceiver = Sentinel::findById($postdata['user_id']);
                    // dd($getreceiver);
                    $recuser_name='';
                    if($getreceiver)
                    {   
                        if($getreceiver->user_type=="seller"){
                          $recuser_name = get_seller_details($getreceiver->id);
                        }
                        else
                        {
                          $recuser_name = $getreceiver->first_name." ".$getreceiver->last_name;
                        }
                    }
                    $arr_built_content = [
                        'USER_NAME'     => $recuser_name,
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'POST_TITLE'    => $postdata['title']
                    ];

                    $arr_mail_data['email_template_id'] = '90';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($postdata['user_id']);

                  //  if($postdata['user_id']==$getreceiver->id){}else{
                     $this->EmailService->send_mail_section($arr_mail_data);
                  //  }



                      /*****************send notification ************/





                  }else{
                     $response['status']      = 'SUCCESS';
                    // $response['description'] = 'Post liked successfully.';
                     $response['description'] = 'Post disliked successfully.';

                   
                 }             

           }                        
        
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to like post...Please try again.';
        }

        return response()->json($response);


    }// end of like dislike function



      function send_reportpost(Request $request)
    { 
        $post_id  = $request->postid;
        $user_id    = $request->from;
        $message     = $request->message;
        $link        = $request->link;

        if($user_id && $message && $link)
        {

            $data = array('post_id'=>$post_id,'user_id'=>$user_id,'link'=>$link,'message'=>$message);
            $insertdata = $this->PostReportModel->create($data);
            if($insertdata->id)
            {

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;

                    if($user_details->user_type=="seller")
                    {
                         if($user_details->first_name=="" || $user_details->last_name==""){
                         $user_name =$user_details->email; 
                        }else{
                             $user_name = get_seller_details($user_details->id);
                        }   
                    } //if seller user type
                    else
                    {
                         if($user_details->first_name=="" || $user_details->last_name==""){
                         $user_name =$user_details->email; 
                        }else{
                             $user_name = $user_details->first_name.' '.$user_details->last_name;
                        }   
                    }//else of other user type
                    

                   
                }
                $postdata = $this->ForumPostsModel->where('id',$post_id)->first();
       
                if(!empty($postdata))
                {
                    $postdata = $postdata->toArray();
                }

                
                /*****************Send Notification to Admin (START)**************************/

                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                    
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has reported the post <a target="_blank" href="'.$link.'"><b>'.$postdata['title'].'</b></a>. <br> <b>Report Reason: </b>'.$message);

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'A post has been reported';
                    $this->GeneralService->save_notification($arr_event);


              

                /*********************Send Mail Notification to Admin (START)*************************/

                    


                   

                    $msg     = html_entity_decode('<b>'.$user_name.'</b> has reported the post <b>' . $postdata['title'].'</b>. <br> <b>Report Reason: </b>'.$message);

                    $subject = 'A post has been reported';

                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'MSG'           => $message,
                        'POST_TITLE'    => $postdata['title']    
                    ];

                    $arr_mail_data['email_template_id'] = '104';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_notification_mail($arr_mail_data);
                    
                /********************Send Mail Notification to Admin (END)***************/
                

              $response['status']      = 'SUCCESS';
              $response['description'] = 'The post has been reported successfully.'; 
              return response()->json($response);   
            }else{
                  $response['status']      = 'ERROR';
                  $response['description'] = 'Problem occured while sending report'; 
                  return response()->json($response); 
            }

        }


    }// end of function
 

    public function forum_comment_store(Request $request)
    {

        $form_data = $request->all();
        
        $arr_rules = ['forum_comment_text' => 'required'];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'error';
            if($request->comment_type=='reply')
            {
                $response['description'] = 'Please type something in reply!';
            }
            else{
                $response['description'] = 'Please type something in comment!';
            }

            return response()->json($response);
        }

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;            
        }
        if($user_id)
        {


            $parent_id = isset($form_data['parent_id'])?$form_data['parent_id']: NULL;
            $post_id = isset($form_data['post_id'])?$form_data['post_id']: '';
            $comment = isset($form_data['forum_comment_text'])?$form_data['forum_comment_text']:'';
            $container_id = isset($form_data['container_id'])?$form_data['container_id']: '';
            $parent_comment_id = isset($form_data['parent_comment_id'])?$form_data['parent_comment_id']: '';


            $input_data = [
                            'user_id'        => $user_id,
                            'post_id'        => $post_id,
                            'comment'        => $comment,
                            'parent_id'      => $parent_id,
                            'container_id'   => $container_id,
                            'parent_comment_id'=>$parent_comment_id
                            
                          ];

            $add_comment = $this->ForumCommentsModel->create($input_data);
            // dd($add_comment->id);
            if($add_comment)
            {
                $post_detail = $this->ForumPostsModel->where('id',$post_id)->first();

                   /******************* Notification START* For addiing comment on product **************/

                    $from_user_id = 0;
                    $admin_id     = 0;
                    $user_name    = $seller_fname = $seller_lname = $eventuser= "";

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        $user_name    = $user_details->first_name.' '.$user_details->last_name;

                         $user_name ='';   
                         $eventuser = '';

                         if($user_details->user_type=="buyer")
                         {
                            if($user_details->first_name=="" || $user_details->last_name==""){
                                 $user_name =$user_details->email;
                                  $eventuser ='buyer';
                            }else{
                                 $user_name = $user_details->first_name.' '.$user_details->last_name;
                                 $eventuser = $user_details->first_name.' '.$user_details->last_name;
                            }
                         }
                         else if($user_details->user_type=="seller")
                         {
                            if($user_details->first_name=="" || $user_details->last_name==""){
                                 $user_name =$user_details->email;
                                  $eventuser ='dispensary';
                            }else{
                                 // $user_name = $user_details->first_name.' '.$user_details->last_name;
                                 // $eventuser = $user_details->first_name.' '.$user_details->last_name;
                                  $user_name = get_seller_details($user_details->id);
                                  $eventuser = get_seller_details($user_details->id);

                            }
                         }
                         else if($user_details->user_type=="admin")
                         {
                            if($user_details->first_name=="" || $user_details->last_name==""){
                                 $user_name =$user_details->email;
                                  $eventuser ='admin';
                            }else{
                                 $user_name = $user_details->first_name.' '.$user_details->last_name;
                                 $eventuser = $user_details->first_name.' '.$user_details->last_name;

                            }
                         }



                    }

                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                    $url = url('/')."/forum/view_post/".base64_encode($post_id);

                    

                    /********************Send Notification to Admin(START)***************************/
                        $arr_event                     = [];
                        $arr_event['from_user_id']     = $from_user_id;
                        $arr_event['to_user_id']       = $admin_id;
                        $arr_event['type']             = '';

                        if($request->comment_type=='reply')
                        {
                            $replied_to_comment = $this->ForumCommentsModel->where('id',$request->parent_id)->first();
                            $rep_user_name=' ';
                            // dd($replied_to_comment);
                            if($replied_to_comment)
                            {
                                $replied_user_details = Sentinel::findById($replied_to_comment->user_id);
                                // dd($replied_user_details);

                                if($replied_user_details['user_type']=="seller"){
                                    if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                                    {

                                     $rep_user_name= $replied_user_details->email;
                                    }else{
                                    $rep_user_name=get_seller_details($replied_user_details->id);
                                    }    

                                }//if user type is seller
                                else
                                {
                                     if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                                    {

                                      $rep_user_name= $replied_user_details->email;
                                    }else{

                                      $rep_user_name= $replied_user_details->first_name." ".$replied_user_details->last_name;
                                    }    
                                }//else other user type

                            }
                            $arr_event['description']      = html_entity_decode('<b>'.$user_name.'</b> has replied to comment of  "<b>'.$rep_user_name.'</b>" on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');
                            $arr_event['title']            = 'Reply on Post';
                        }
                        else
                        {
                            $arr_event['description']      = html_entity_decode('<b>'.$user_name.'</b> has added the comment "<b>'.$comment.'</b>" on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');
                            $arr_event['title']            = 'New Comment on Post';
                        }
                        $this->GeneralService->save_notification($arr_event);
                    /********************Send Notification to Admin(END)******************************/

                    /********************Send Mail Notification to Admin(START)***********************/

                    if($request->comment_type=='reply')
                    {
                        $replied_to_comment = $this->ForumCommentsModel->where('id',$request->parent_id)->first();
                        $rep_user_name=' ';
                        if($replied_to_comment)
                        {
                            $replied_user_details = Sentinel::findById($replied_to_comment->user_id);

                              if($replied_user_details['user_type']=="seller")
                              {
                                    if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                                    {
                                         $rep_user_name= $replied_user_details->email;
                                    }else{
                                         $rep_user_name= get_seller_details($replied_user_details->id);
                                    }
                              }//if reply user type seller
                              else
                              {
                                    if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                                    {
                                         $rep_user_name= $replied_user_details->email;
                                    }else{
                                         $rep_user_name= $replied_user_details->first_name." ".$replied_user_details->last_name;
                                    }
                              }//else


                           


                        }
                         $msg     = html_entity_decode('<b>'.$user_name.'</b> has replied to comment of  <b>'.$rep_user_name.'</b> on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');

                        //$subject  = 'Reply on Post';

                        $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                              'APP_NAME'      => config('app.project.name'),
                                             // 'MESSAGE'       => $msg,
                                              'URL'           => $url,
                                              'BUYER_NAME'   => $user_name,
                                              'POST_TITLE'   => $post_detail->title,
                                              'REPLIED_NAME'  => $rep_user_name
                                             ];

                        $arr_mail_data['email_template_id'] = '76';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($admin_id);

                        $this->EmailService->send_notification_mail($arr_mail_data);  


                    }
                    else
                    {
                        $msg    = html_entity_decode('<b>'.$user_name.'</b> has added the comment "<b>'.$comment.'</b>" on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');
                           
                        $subject     = 'New Comment on Post';

                         $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                              'APP_NAME'      => config('app.project.name'),
                                             // 'MESSAGE'       => $msg,
                                              'URL'           => $url,
                                              'BUYER_NAME'   => $user_name,
                                              'POST_TITLE'   => $post_detail->title,
                                              'COMMENT'      => $comment
                                             ];

                        $arr_mail_data['email_template_id'] = '74';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($admin_id);

                        $this->EmailService->send_notification_mail($arr_mail_data);  




                    }
                              
                    /********************Send Mail Notification to Admin(END)*************************/


                    /*****************Send Notification to Post Owner (START)**************************/
                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $from_user_id;
                        $arr_event['to_user_id']   = $post_detail->user_id;
                        $arr_event['type']         = '';

                        if($request->comment_type=='reply')
                        {
                            $replied_to_comment = $this->ForumCommentsModel->where('id',$request->parent_id)->first();
                            $rep_user_name=' ';
                            if($replied_to_comment)
                            {
                                $replied_user_details = Sentinel::findById($replied_to_comment->user_id);


                                 if($replied_user_details->user_type=="seller")
                               {
                                     if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                                    {
                                         $rep_user_name= $replied_user_details->email;
                                    }else{
                                         $rep_user_name= get_seller_details($replied_user_details->id);
                                    }    
                               }
                               else
                               {
                                     if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                                    {
                                         $rep_user_name= $replied_user_details->email;
                                    }else{
                                         $rep_user_name= $replied_user_details->first_name." ".$replied_user_details->last_name;
                                    }
                               }//else other user type

                               
                              

                            }
                            $arr_event['description']      = html_entity_decode('<b>'.$user_name.'</b> has replied to comment of  <b>'.$rep_user_name.'</b> on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');
                            $arr_event['title']            = 'Reply on Post';
                        }
                        else
                        {
                            $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the comment "<b>'.$comment.'</b>" on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');
                            $arr_event['title']        = 'New Comment on Post';
                        }
                        $this->GeneralService->save_notification($arr_event);
                    /*****************Send Notification to Post Owner (END)****************************/

                    /****************Send Mail Notification to Post Owner(START)************************/


                    $user_details = Sentinel::findById($post_detail->user_id);
                    if($user_details)
                    {
                        $fname= $user_details->first_name;
                        $lname= $user_details->last_name;
                    }



                    if($request->comment_type=='reply')
                    {
                        $replied_to_comment = $this->ForumCommentsModel->where('id',$request->parent_id)->first();
                        $rep_user_name=' ';
                        if($replied_to_comment)
                        {
                            $replied_user_details = Sentinel::findById($replied_to_comment->user_id);

                              if($replied_user_details->user_type=="seller")
                               {
                                     if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                                    {
                                        $rep_user_name= $replied_user_details->email;
                                    }else{
                                        $rep_user_name= get_seller_details($replied_user_details->id);
                                    }
                               }
                               else
                               {
                                    if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                                    {
                                        $rep_user_name= $replied_user_details->email;
                                    }else{
                                        $rep_user_name= $replied_user_details->first_name." ".$replied_user_details->last_name;
                                    }
                               }//else other user type


                            
                          

                        }
                         $msg     = html_entity_decode('<b>'.$user_name.'</b> has replied to comment of  <b>'.$rep_user_name.'</b> on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');

                        $subject  = 'Reply on Post';

                        $arr_built_content = ['USER_NAME'     => $fname.' '.$lname,
                                              'APP_NAME'      => config('app.project.name'),
                                             // 'MESSAGE'       => $msg,
                                              'URL'           => $url,
                                              'BUYER_NAME'   => $user_name,
                                              'POST_TITLE'   => $post_detail->title,
                                              'REPLIED_NAME'  => $rep_user_name

                                             ];

                        $arr_mail_data['email_template_id'] = '76';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($post_detail->user_id);

                        $this->EmailService->send_notification_mail($arr_mail_data); 



                    }
                    else
                    {
                        $msg    =  html_entity_decode('<b>'.$user_name.'</b> has added the comment "<b>'.$comment.'</b>" on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');
                        $subject     = 'New Comment on Post';

                        $arr_built_content = ['USER_NAME'     => $fname.' '.$lname,
                                              'APP_NAME'      => config('app.project.name'),
                                             // 'MESSAGE'       => $msg,
                                              'URL'           => $url,
                                              'BUYER_NAME'   => $user_name,
                                              'POST_TITLE'   => $post_detail->title,
                                              'COMMENT'      => $comment

                                             ];

                        $arr_mail_data['email_template_id'] = '74';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($post_detail->user_id);

                        $this->EmailService->send_notification_mail($arr_mail_data); 



                    }
                               
                        

                    /****************Send Mail Notification to Post Owner(END)*********/


                /*******************Notification END* for adding comment on product detail page***************/   

                    /******************Add Event data************/
                    if($request->comment_type=='reply')
                   {

                   }else{
                        $arr_eventdata              = [];
                        $arr_eventdata['user_id']   = $from_user_id;                     

                        $arr_eventdata['message']   =html_entity_decode('<div class="discription-marq">
                        <div class="mainmarqees-image">
                         <img src="'.url('/').'/assets/front/images/chow.png" alt="">
                         </div><b> Someone </b> just commented on a forum post. <div class="clearfix"></div></div><a href
                            ="'.url('/').'/forum/view_post/'.base64_encode($post_detail->id).'" target="_blank" class="viewcls">View</a>');
                        
                        $arr_eventdata['title']     = 'New Comment';

                        $login_user     = Sentinel::check(); 
                        if(isset($login_user) && $login_user == true && $login_user->inRole('seller') == true)
                        {

                        }else{                        
                           $this->EventModel->create($arr_eventdata);
                        }
                    }//else
                    /***************end of event******************/



                if($request->comment_type=='reply')
                {
                    $resl = $this->send_nested_comment_notification($add_comment,$add_comment->parent_id);
                  
                }


                $response['status']      = 'success';
                if($request->comment_type=='reply')
                {
                    $response['description'] = 'Reply posted successfully.';
                }
                else
                {
                    $response['description'] = 'Comment posted successfully.';
                }
            }
            else
            {
                $response['status']      = 'error';
                if($request->comment_type=='reply')
                {
                  $response['description'] = 'Unable to send reply, please try again later.';
                }
                else
                {
                  $response['description'] = 'Unable to send comment, please try again later.';
                }
            }
        }
        else
        {
            $response['status']      = 'error';
            $response['description'] = 'Please Sign In first to add comment!.';

        }

        return response()->json($response);

    }//end of function



    /********************send nested notification function*********************/

    public function send_nested_comment_notification($comment_details,$notification_receiver_id)
    {

        $post_detail = $this->ForumPostsModel->where('id',$comment_details->post_id)->first();

        $from_user_details = Sentinel::findById($comment_details->user_id);
        $from_user_name ='';
        if($from_user_details)
        {
            if($from_user_details->user_type=="seller")
            {   
                if($from_user_details->first_name=="" || $from_user_details->last_name=="")
                {
                      $from_user_name = $from_user_details->email;
                }else{
                      $from_user_name = get_seller_details($from_user_details->id);
                }

            }else{
                if($from_user_details->first_name=="" || $from_user_details->last_name=="")
                {
                      $from_user_name = $from_user_details->email;
                }else{
                      $from_user_name = $from_user_details->first_name." ".$from_user_details->last_name;
                }
            }//else other user type
            

            // $from_user_name = $from_user_details->first_name." ".$from_user_details->last_name;
        }

        $replied_to_comment = $this->ForumCommentsModel->where('id',$comment_details->parent_id)->first();


        $rep_user_name=' ';
        if($replied_to_comment)
        {
            $replied_user_details = Sentinel::findById($replied_to_comment->user_id);

            if($replied_user_details->user_type=="seller"){

                if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                {   
                     $rep_user_name= $replied_user_details->email;
                }else{
                     $rep_user_name= get_seller_details($replied_user_details->id);
                }

            }else{
               if($replied_user_details->first_name=="" || $replied_user_details->last_name=="")
                {   
                     $rep_user_name= $replied_user_details->email;
                }else{
                     $rep_user_name= $replied_user_details->first_name." ".$replied_user_details->last_name;
                }
            }//else for other user type

          

            // $rep_user_name= $replied_user_details->first_name." ".$replied_user_details->last_name;
        }

        $receiver_comment = $this->ForumCommentsModel->where('id',$notification_receiver_id)->first();


        $rec_user_name=' ';
        if($receiver_comment)
        {
            $rec_user_details = Sentinel::findById($receiver_comment->user_id);

             if($rec_user_details->user_type=="seller"){

                 if($rec_user_details->first_name=="" || $rec_user_details->last_name=="")
                 {
                    $rec_user_name= $rec_user_details->email;
                 }else{
                    $rec_user_name= get_seller_details($rec_user_details->id);
                 }   

             }else{
                if($rec_user_details->first_name=="" || $rec_user_details->last_name=="")
                 {
                    $rec_user_name= $rec_user_details->email;
                 }else{
                    $rec_user_name= $rec_user_details->first_name." ".$rec_user_details->last_name;
                 }   
             }//else other user type

             
        }

        /*****************Send Notification to Post Owner (START)****************************/

        $arr_event                 = [];
        $arr_event['from_user_id'] = $from_user_details->id;
        $arr_event['to_user_id']   = $rec_user_details->id;
        $arr_event['type']         = '';

        $url = url('/')."/forum/view_post/".base64_encode($comment_details->post_id);

        if($notification_receiver_id==$comment_details->parent_id)
        {   
           
            $arr_event['description']      = html_entity_decode('<b>'.$from_user_name.'</b> has replied to your comment on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');

        }
        else{           
           
            $arr_event['description']      = html_entity_decode('<b>'.$from_user_name.'</b> has replied to comment of  <b>'.$rep_user_name.'</b> on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');
        }
        

        $arr_event['title']            = 'Reply on Post';
       
        $this->GeneralService->save_notification($arr_event);
        /*****************Send Notification to Post Owner (END)****************************/

        /****************Send Mail Notification to Post Owner(START)************************/
        if($notification_receiver_id==$comment_details->parent_id)
        {

            $msg     = html_entity_decode('<b>'.$from_user_name.'</b> has replied to your comment on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');
        }
        else
        {            
            
             $msg     = html_entity_decode('<b>'.$from_user_name.'</b> has replied to comment of  <b>'.$rep_user_name.'</b> on post <a target="_blank" href="'.$url.'"><b>"'.$post_detail->title.'"</b></a>');

        }
        $subject  = 'Reply on Post';
    
        $arr_built_content = ['USER_NAME'     => $rec_user_name,
                              'APP_NAME'      => config('app.project.name'),
                            //  'MESSAGE'       => $msg,
                              'URL'           => $url,
                              'BUYER_NAME'   => $from_user_name,
                              'POST_TITLE'   => $post_detail->title,
                              'REPLIED_NAME'  => $rep_user_name
                             ];

        $arr_mail_data['email_template_id'] = '76';
        $arr_mail_data['arr_built_content'] = $arr_built_content;
        $arr_mail_data['arr_built_subject'] = '';
        $arr_mail_data['user']              = Sentinel::findById($rec_user_details->id);

        $this->EmailService->send_mail_section($arr_mail_data); 

        if($receiver_comment->parent_id!='' || $receiver_comment->parent_id!=NULL)
        {
            $resl = $this->send_nested_comment_notification($comment_details,$receiver_comment->parent_id);
        }

        /****************Send Mail Notification to Post Owner(END)**************************/
    }
    /********************give like to comment my function*********************/

    public function givelike_comment(request $request)
    {   
       $containerid = $request->containerid;
       $postid = $request->postid;
       $commentid = $request->commentid;
       $dblikedislike = $request->dblikedislike;

       

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;  
             $user_details = Sentinel::getUser();
             $from_user_id = $user_details->id;

                if($user_details->user_type=="seller")
                {   
                    if($user_details->first_name=="" || $user_details->last_name==""){
                     $user_name =$user_details->email; 
                    }else{
                         $user_name = get_seller_details($user_details->id);
                    }

                }else{
                    if($user_details->first_name=="" || $user_details->last_name==""){
                     $user_name =$user_details->email; 
                    }else{
                         $user_name = $user_details->first_name.' '.$user_details->last_name;
                    }
                }//else other type
               

        }

        if($user_id && $commentid)
        {

            $get_likedata = $this->ForumCommentLikeDislikeModel
                                    ->where('user_id',$user_id)
                                    ->where('comment_id',$commentid)
                                    ->where('post_id',$postid)
                                    ->where('container_id',$containerid)
                                    ->first();

               $postdata = $this->ForumPostsModel->where('id',$postid)->first();
       
                if(!empty($postdata))
                {
                    $postdata = $postdata->toArray();
                }      

                 $commentdata = $this->ForumCommentsModel->where('id',$commentid)->first();
       
                if(!empty($commentdata))
                {
                    $commentdata = $commentdata->toArray();
                }                  

                $link =  url('/').'/forum/view_post/'.base64_encode($postid);

            if(empty($get_likedata))
            {   
                $insertdata = [];
                $insertdata['user_id']= $user_id;
                $insertdata['post_id'] = $postid;
                 $insertdata['container_id'] = $containerid;
                $insertdata['comment_id'] = $commentid;
                $insertdata['like_dislike'] = '1';
                $this->ForumCommentLikeDislikeModel->create($insertdata);

                 $response['status']      = 'SUCCESS';
                 $response['description'] = 'Comment liked successfully.';


                    /*****************send notification ************/


                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                    /**************send noti to admin*****************************/
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has like the comment <a target="_blank" href="'.$link.'"><b>'.$commentdata['comment'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Comment liked';
                    $this->GeneralService->save_notification($arr_event);

                    /**************send noti to post owner*****************************/
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $postdata['user_id'];
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has like the comment <a target="_blank" href="'.$link.'"><b>'.$commentdata['comment'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Comment liked';
                    $this->GeneralService->save_notification($arr_event);



                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'COMMENT'       => $commentdata['comment']
                    ];

                    $arr_mail_data['email_template_id'] = '94';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_mail_section($arr_mail_data);


                    // notification to user
                   $msg     = html_entity_decode('<b>'.$user_name.'</b> has liked the comment <b>' . $commentdata['comment'].'</b>');

                    $subject = 'Comment liked';

                    $getreceiver = Sentinel::findById($postdata['user_id']);
                    // dd($getreceiver);
                    $recuser_name='';
                    if($getreceiver)
                    {   
                        if($getreceiver->user_type=="seller"){
                             $recuser_name = get_seller_details($getreceiver->id);
                        }else{
                             $recuser_name = $getreceiver->first_name." ".$getreceiver->last_name;
                        }
                       
                    }
                    $arr_built_content = [
                        'USER_NAME'     => $recuser_name,
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'COMMENT'       => $commentdata['comment']

                    ];

                    $arr_mail_data['email_template_id'] = '94';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($postdata['user_id']);
                    //if($user_id==$getreceiver->id){}else{
                        $this->EmailService->send_mail_section($arr_mail_data);
                    //}
                    /*****************send notification ************/



            }else{
                $updatedata = [];

                if($dblikedislike=='1')
                  $setval = '0';
                else
                   $setval = '1'; 


                $updatedata['like_dislike'] = $setval;
                $update_status  = $this->ForumCommentLikeDislikeModel
                                ->where('post_id',$postid)
                                ->where('container_id',$containerid)
                                ->where('comment_id',$commentid)
                                ->where('user_id',$user_id)
                                ->update($updatedata);

                  if($update_status && $dblikedislike=='1')
                  {
                     $response['status']      = 'SUCCESS';
                     $response['description'] = 'Comment disliked successfully.';
                  }else{
                     $response['status']      = 'SUCCESS';
                     $response['description'] = 'Comment liked successfully.';

                     /*****************send notification ************/


                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                    /****************send noti to admin****************/
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has like the comment <a target="_blank" href="'.$link.'"><b>'.$commentdata['comment'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Comment liked';
                    $this->GeneralService->save_notification($arr_event);

                    /****************send noti to post owner****************/

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $postdata['user_id'];
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has like the comment <a target="_blank" href="'.$link.'"><b>'.$commentdata['comment'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Comment liked';
                    $this->GeneralService->save_notification($arr_event);



                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                        //'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'COMMENT'       => $commentdata['comment']
                    ];

                    $arr_mail_data['email_template_id'] = '94';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_mail_section($arr_mail_data);


                     // notification to user
                    $msg     = html_entity_decode('<b>'.$user_name.'</b> has liked the comment <b>' . $commentdata['comment'].'</b>');

                    $subject = 'Comment liked';

                    $getreceiver = Sentinel::findById($postdata['user_id']);
                    // dd($getreceiver);
                    $recuser_name='';
                    if($getreceiver)
                    {   
                         if($getreceiver->user_type=="seller"){
                              $recuser_name = get_seller_details($getreceiver->id);
                         }else{
                              $recuser_name = $getreceiver->first_name." ".$getreceiver->last_name;
                         }
                      
                    }
                    $arr_built_content = [
                        'USER_NAME'     => $recuser_name,
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'COMMENT'       => $commentdata['comment']
                    ];

                    $arr_mail_data['email_template_id'] = '94';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($postdata['user_id']);
                    //if($user_id==$getreceiver->id){}else{
                     $this->EmailService->send_mail_section($arr_mail_data);
                    //}
                     /*****************send notification ************/

               }             

           }                        
        
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to like comment...Please try again.';
        }

        return response()->json($response);
    }

    /*********************end of give likes to comment function************/



    /************************start of get reply recursively***************************/
        function get_comment_reply($comment_id,$post_id)
        {
            if(Sentinel::check())
            {
                $user_id = Sentinel::check()->id;  
                $login_user = Sentinel::getUser();
                $login_id = $login_user['id'];
            }

            $post_comments = $this->ForumCommentsModel->with('get_user_details')
                                ->where('parent_id',$comment_id)
                                ->where('post_id',$post_id)
                                ->orderBy('id','desc')
                                ->limit(5)
                                ->get();

              // echo "<pre>";print_r($post_comments);                 

             $response ='';                   

            if(!empty($post_comments) && isset($post_comments))
            {
                $post_comments->toArray();
               
                 foreach ($post_comments as $comment)
                 {
                    $comment_date = Carbon::parse($comment['created_at'])->diffForHumans();

                    $set_username ='';   $appendusertypehtml ='';
                    if(isset($comment['get_user_details']) && !empty($comment['get_user_details']))
                    {   
                        $set_username='';

                         if($comment['get_user_details']['user_type']=="seller")
                         {
                            if($comment['get_user_details']['first_name']=="" || $comment['get_user_details']['last_name']=="")
                            {
                                $set_username = $comment['get_user_details']['email'];
                            }else{
                                $set_username = get_seller_details($comment['get_user_details']['id']);
                            }
                         }
                         else
                         {
                            if($comment['get_user_details']['first_name']=="" || $comment['get_user_details']['last_name']=="")
                            {
                                $set_username = $comment['get_user_details']['email'];
                            }else{
                                $set_username = $comment['get_user_details']['first_name'].' '.$comment['get_user_details']['last_name'];
                            }
                         }//else of other user type

                    

                        // $set_username = $comment['get_user_details']['first_name'].' '.$comment['get_user_details']['last_name'];
                    }

                     if($comment['get_user_details']['user_type']=="seller")
                    {
                        $appendusertypehtml ='<div class="sellertab-main">
                              <img src="'.url('/').'/assets/front/images/seller-tags.png" alt="">
                              </div>';
                    }
                    else if($comment['get_user_details']['user_type']=="admin")
                    {
                        $appendusertypehtml ='<div class="sellertab-main">
                              <img src="'.url('/').'/assets/front/images/admin-tag.png" alt="">
                              </div>';
                    }


                   $response .= '
                    <div class="box box2 replythreaddiv_'.$comment_id.'_'.$post_id.'" style="display:block">
                            <h4>'.$set_username. $appendusertypehtml.'</h4>
                            <small>'.$comment_date.'</small>
                            <p>'.$comment['comment'].'</p>
                            <ul class="list-inline">';
                               
 
                            /*************************************************/    
                             if(isset($login_user)){
                              if($login_user == true)
                              { 
                                        $dblike_dislike=0;
                                        $color ='style=color:grey';  

                                         $getlikecount = $this->ForumReplyLikeDislikeModel
                                                        ->where('post_id',$comment['post_id'])
                                                        ->where('reply_id',$comment['id'])
                                                        ->where('like_dislike','1')
                                                        ->count();    


                                   
                                        $getlikeofuser = $this->ForumReplyLikeDislikeModel
                                                        ->where('post_id',$comment['post_id'])
                                                        ->where('reply_id',$comment['id'])
                                                        ->where('like_dislike','1')
                                                        ->where('user_id',$login_id)->first();

                                        if(isset($getlikeofuser) && !empty($getlikeofuser))
                                        {
                                            $getlikeofuser = $getlikeofuser->toArray();
                                            $dblike_dislike = $getlikeofuser['like_dislike'];
                                            if($dblike_dislike=='1')
                                                $color = 'style=color:#b833cb';
                                            else
                                                $color ='style=color:grey';   

                                        }            

                                  
                                 $response .= '<li><a id="reply_btn" class="reply_btn"    data-id="'.$comment['id'].'" data-post_id="'.$comment['post_id'].'"   data-container_id="'.$comment['container_id'].'"   data-parent_id="'.$comment['parent_comment_id'].'"      data-c_type="reply" href="javascript:void(0);"><i class="fa fa-reply"></i> Reply</a></li>';
         

                                $response .= '<li><a href="javascript:void(0)" class="givelike_reply" '.$color.' postid="'.$comment['post_id'].'"    containerid="'.$comment['container_id'].'"    replyid="'.$comment['id'].'"  commentid="'.$comment['parent_id'].'"    userid="'.$login_id.'"   dblikedislike="'.$dblike_dislike.'"  data-parent_id="'.$comment['parent_comment_id'].'"><i class="fa fa-thumbs-up"></i> Like</a></li>';
                              }//if login user
                             }else{
                                $loginurl = url('/').'/login';

                                $response .= '<li><a  href="'.$loginurl.'"><i class="fa fa-reply"></i> Reply</a></li>';
                                
                                $response .= '<li><a href="'.$loginurl.'"><i class="fa fa-thumbs-up"></i> Like</a></li>';
                             }

                             /*************************************************/

                                $response .= '</ul>';                           
                                $html = $this->get_comment_reply($comment['id'],$post_id);
                                $response .= $html;
                          

                        

                     $response .= '</div>';
                  
                 }//foreach 
                   return  $response;
              }//if not empty post                 
        }//end of function
    /***********************end of get reply*****************************/




     /******************start of**give like to reply*********************/

    public function givelike_reply(request $request)
    {
       $containerid = $request->containerid;
       $postid = $request->postid;
       $commentid = $request->commentid;
       $replyid = $request->replyid;
       $dblikedislike = $request->dblikedislike;
       $parent_comment_id = $request->parent_comment_id;


        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;  
             $user_details = Sentinel::getUser();
             $from_user_id = $user_details->id;

                if($user_details->user_type=="seller")
                {

                       if($user_details->first_name=="" || $user_details->last_name==""){
                        $user_name =$user_details->email; 
                        }else{
                             $user_name = get_seller_details($user_details->id);
                        }

                }
                else
                {
                     if($user_details->first_name=="" || $user_details->last_name==""){
                     $user_name =$user_details->email; 
                    }else{
                         $user_name = $user_details->first_name.' '.$user_details->last_name;
                    }
                }//other user type
               

        }

        if($user_id && $commentid && $replyid)
        {

            $get_likedata = $this->ForumReplyLikeDislikeModel
                                    ->where('user_id',$user_id)
                                    ->where('reply_id',$replyid)
                                    ->where('post_id',$postid)
                                     ->where('container_id',$containerid)
                                    ->first();

               $postdata = $this->ForumPostsModel->where('id',$postid)->first();
       
                if(!empty($postdata))
                {
                    $postdata = $postdata->toArray();
                }      

                 $commentdata = $this->ForumCommentsModel->where('id',$commentid)->first();
       
                if(!empty($commentdata))
                {
                    $commentdata = $commentdata->toArray();
                }                  

                $link =  url('/').'/forum/view_post/'.base64_encode($postid);

            if(empty($get_likedata))
            {   
                $insertdata = [];
                $insertdata['user_id']= $user_id;
                $insertdata['container_id'] = $containerid;
                $insertdata['post_id'] = $postid;
                $insertdata['reply_id'] = $replyid;
                $insertdata['like_dislike'] = '1';
                $insertdata['parent_comment_id']=$parent_comment_id;
                $this->ForumReplyLikeDislikeModel->create($insertdata);

                 $response['status']      = 'SUCCESS';
                 $response['description'] = 'Reply liked successfully.';


                    /*****************send notification ************/
 

                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                    /**************send noti to admin******************/
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has like the reply <a target="_blank" href="'.$link.'"><b>'.$commentdata['comment'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Reply liked';
                    $this->GeneralService->save_notification($arr_event);

                    /**************send noti to post owner******************/

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $postdata['user_id'];
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has like the reply <a target="_blank" href="'.$link.'"><b>'.$commentdata['comment'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Reply liked';
                    $this->GeneralService->save_notification($arr_event);



                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'REPLY'         =>$commentdata['comment']        
                    ];

                    $arr_mail_data['email_template_id'] = '99';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_notification_mail($arr_mail_data);


                 

                    $getreceiver = Sentinel::findById($postdata['user_id']);
                    // dd($getreceiver);
                    $recuser_name='';
                    if($getreceiver)
                    {
                        if($getreceiver->user_type=="seller")
                        {
                          $recuser_name = get_seller_details($getreceiver->id);

                        }else{
                          $recuser_name = $getreceiver->first_name." ".$getreceiver->last_name;
                        }
                    }
                    $arr_built_content = [
                        'USER_NAME'     => $recuser_name,
                        'APP_NAME'      => config('app.project.name'),
                       // 'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'REPLY'         =>$commentdata['comment'] 
                    ];

                    $arr_mail_data['email_template_id'] = '99';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($postdata['user_id']);

                    $this->EmailService->send_notification_mail($arr_mail_data);
                    /*****************send notification ************/



            }else{
                $updatedata = [];

                if($dblikedislike=='1')
                  $setval = '0';
                else
                   $setval = '1'; 


                $updatedata['like_dislike'] = $setval;
                $update_status  = $this->ForumReplyLikeDislikeModel
                                ->where('post_id',$postid)
                                ->where('container_id',$containerid)
                                ->where('reply_id',$replyid)
                                ->where('user_id',$user_id)
                                ->update($updatedata);

                  if($update_status && $dblikedislike=='1')
                  {
                     $response['status']      = 'SUCCESS';
                     $response['description'] = 'Reply disliked successfully.';
                  }else{
                     $response['status']      = 'SUCCESS';
                     $response['description'] = 'Reply liked successfully.';

                     /*****************send notification ************/


                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                    /****************send noti to admin***************/
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has like the reply <a target="_blank" href="'.$link.'"><b>'.$commentdata['comment'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Reply liked';
                    $this->GeneralService->save_notification($arr_event);

                     /****************send noti to post owner***************/
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $user_id;
                    $arr_event['to_user_id']   = $postdata['user_id'];
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has like the reply <a target="_blank" href="'.$link.'"><b>'.$commentdata['comment'].'</b></a>.');

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Reply liked';
                    $this->GeneralService->save_notification($arr_event);


                 

                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                      //  'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'REPLY'         =>$commentdata['comment'] 
                    ];

                    $arr_mail_data['email_template_id'] = '99';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_notification_mail($arr_mail_data);

                  

                    $getreceiver = Sentinel::findById($postdata['user_id']);
                
                    $recuser_name='';
                    if($getreceiver)
                    {
                        if($getreceiver->user_type=="seller"){
                        $recuser_name = get_seller_details($getreceiver->id);

                        }else{
                        $recuser_name = $getreceiver->first_name." ".$getreceiver->last_name;

                        }
                    }
                    $arr_built_content = [
                        'USER_NAME'     => $recuser_name,
                        'APP_NAME'      => config('app.project.name'),
                        //'MESSAGE'       => $msg,
                        'URL'           => $link,
                        'BUYER_NAME'    => $user_name,
                        'REPLY'         =>$commentdata['comment'] 
                    ];

                    $arr_mail_data['email_template_id'] = '99';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($postdata['user_id']);
                    $this->EmailService->send_notification_mail($arr_mail_data);
                     /*****************send notification ************/

               }             

           }                        
        
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to like reply...Please try again.';
        }

        return response()->json($response);
    }

    /*********************end of give reply like function************/


    /*******************load post listing function************/

 
   public function load_post(Request $request)
    {
         if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;  
            $login_user = Sentinel::getUser();
            $login_id = $login_user['id'];
            $login_type = $login_user['user_type'];
        }
 

        if($request->ajax())
        {
            $response['posts'] ='';
            if($request->id > 0)
            {

                $forum_posts =  $this->ForumPostsModel->with('user_details','container_details','like_details','get_like_count')
                                        ->withCount(['comments' => function ($query) { 
                                           // $query->whereNull('parent_id'); 
                                          }])
                                        ->withCount(['get_like_count' => function ($query) { 
                                            $query->where('like_dislike','1'); 
                                          }])
                                        ->where('is_active','1')
                                        ->where('forum_posts.id', '<', $request->id)
                                       // ->orderBy('comments_count','DESC')
                                         ->limit(10)
                                         ->orderBy('forum_posts.id','DESC')
                                        ->get(); 
            }
            else
            {

                $forum_posts =  $this->ForumPostsModel->with('user_details','container_details','like_details','get_like_count')
                                        ->withCount(['comments' => function ($query) { 
                                          //  $query->whereNull('parent_id'); 
                                          }])
                                        ->withCount(['get_like_count' => function ($query) { 
                                            $query->where('like_dislike','1'); 
                                          }])
                                        ->where('is_active','1')
                                        ->orderBy('forum_posts.id','DESC')
                                      //  ->orderBy('comments_count','DESC')
                                        ->limit(10)
                                        ->get();
            }
            $output = '';
            $last_id = '';
         
            
            if(!$forum_posts->isEmpty())
            {   
                

                $response['status'] = "success";
                
                foreach($forum_posts as $post)
                {
                    
                    

                    $response['posts'] .= '
                        <div class="commentlist-box-main">
                            <div class="left-box-fum">
                              <div class="buttonlikesfrms">';
                            if(isset($login_user) && $login_user==true)
                            {

                                 $dblike_dislike=0;
                                 $color =''; 

                                 $getlikeofuser = $this->ForumLikeDislikeModel->where(['post_id' => $post->id])
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
                                 $response['posts'] .= ' <a href="javascript:void(0)" class="like-one  givelikedislike '. $color .'" 
                                     postid=" '.$post->id.'"  
                                     containerid="'. $post->container_id.'"  
                                     dblikedislike="1"  >
                                     <img src="'. url('/').'/assets/front/images/arrowup.png" /></a>';
                                
                            }//if login user true  
                            else{
                                 $response['posts'] .= '<a href="'. url('/').'/login" class="like-one " postid="'.$post->id.'" ><img src="'. url('/').'/assets/front/images/arrowup.png" /></a>';
                            }

                            $response['posts'] .=' <span> '.$post->get_like_count_count.'</span>';





                             if($login_user==true)
                            {

                                 $dblike_dislike=0;
                                  $color ='';  
                             
                                  $getlikeofuser = $this->ForumLikeDislikeModel->where(['post_id' => $post->id])
                                        ->where('user_id',$login_id)->first();

                                    if(isset($getlikeofuser) && !empty($getlikeofuser))
                                    {
                                        $getlikeofuser = $getlikeofuser->toArray();
                                        $dblike_dislike = $getlikeofuser['like_dislike'];
                                        if($dblike_dislike=='2')
                                            $color = 'activeclass';
                                        else
                                            $color ='';   

                                         $response['posts'] .= ' <a href="javascript:void(0)" class="dislike-one givelikedislike '. $color .' " postid="'. $post->id .'"  containerid="'.$post->container_id.'"  dblikedislike="2">
                                            <img src="'. url('/') .'/assets/front/images/arrowdn.png" /></a>';
                                    }else{
                                        $response['posts'] .= '<a href="'.url('/').'/login" class="dislike-one " postid="'.$post->id.'" >
                                           <img src="'. url('/').'/assets/front/images/arrowdn.png" /></a>';
                                    }

                            }
                            else{
                                $response['posts'] .=' <a href="'. url('/') .'/login" class="dislike-one " postid="'.$post->id.'" >
                                  <img src="'. url('/') .'/assets/front/images/arrowdn.png" /></a>';
                            }//else of login user true


              
                    $response['posts'] .= '</div>
                                          </div> ';


                     $response['posts'] .= '<div class="right-box-fum">
                                             <div class="commentheaders">
                                             <div class="postedby-div">
                                                <a href="#" class="nametexts-frm">'.ucfirst($post->container_details['title']).'
                                                </a>
                                             ';                      

                     if(isset($login_user))
                     {
                        if($login_user == true && $login_type==$post->user_details['user_type'])
                        {
                            $set_usernames='';
                            if($post->user_details['first_name']=="" || $post->user_details['last_name']=="")
                            {
                                $set_usernames = $post->user_details['email'];
                            }else{
                                $set_usernames = ucwords($post->user_details['first_name']." ".$post->user_details['last_name']);
                            }


                            $response['posts'] .='<a href="'.url('/').'/'. $login_type .'/profile" target="_blank">
                                      <span class="postbys-dv">
                                           '.$set_usernames.'</span> 
                                    </a>';
                        }
                        else
                          {

                            $set_usernames='';
                            if($post->user_details['first_name']=="" || $post->user_details['last_name']=="")
                            {
                                $set_usernames = $post->user_details['email'];
                            }else{
                                $set_usernames = ucwords($post->user_details['first_name']." ".$post->user_details['last_name']);
                            }

                            $response['posts'] .=' <span class="postbys-dv">
                                     '.$set_usernames.'</span> ';
                          }//else  
                     }else{

                            $set_usernames='';
                            if($post->user_details['first_name']=="" || $post->user_details['last_name']=="")
                            {
                                $set_usernames = $post->user_details['email'];
                            }else{
                                $set_usernames = ucwords($post->user_details['first_name']." ".$post->user_details['last_name']);
                            }

                            $response['posts'] .=' <span class="postbys-dv">
                                     '.$set_usernames.' </span> ';
                     }//else of if login user                         


                     if($post->user_details['user_type']=="seller")
                     {
                        $response['posts'] .='<div class="sellertab-main">
                                <img src="'.url('/').'/assets/front/images/seller-tags.png" alt="">
                              </div>';
                     }
                     if($post->user_details['user_type']=="admin")
                     {
                         $response['posts'] .='<div class="sellertab-main">
                                <img src="'.url('/').'/assets/front/images/admin-tag.png" >  </div>';
                     }

                     $response['posts'] .='</div>';

                     $response['posts'] .='<div class="commentlist-title">
                          <a href="'.url('/').'/forum/view_post/'.base64_encode($post->id).'">
                          '.ucfirst($post['title']).'</a> </div>';


                      $response['posts'] .='<a href="'.url('/').'/forum/view_post/'.base64_encode($post['id']).'" class="commentbuttons">Comment</a>';    
                       $response['posts'] .='</div>';

                       $response['posts'] .='<div class="footer-forum">';

                        $response['posts'] .=' <img src="'.url('/').'/assets/front/images/chat-forum.png" alt="" /> <span>'.$post->comments_count.'
                         Comments </span> ';


                         $response['posts'] .='<div class="sharebutton-forum">';

                          $response['posts'] .='<p id="item-desc-'. $post->id .'" style="display: none">'.url('/').'/forum/view_post/'.base64_encode($post->id).'</p>
                             <a href="javascript:void(0)" data-desc-ref="item-desc-'.$post->id .'" onclick="status(this,'. $post->id.')">
                              <img src="'.url('/').'/assets/front/images/chat-forum-share.png " alt="" />
                              Share 
                             </a>
                             <div class="copeid-sms copy_txt" id="copy_'.$post->id.'" idval="'.$post->id.'" style="display:none;"> Link Copied!</div>';
                         $response['posts'] .='</div>';

                         $response['posts'] .='<div class="savebutton-forum">';

                         if(isset($login_user))
                         {
                            if($login_user == true)
                            {
                                $response['posts'] .='<a href="javascript:void(0)" postid="'.$post->id.'"  class="reportmodal">
                                     <img src="'.url('/').'/assets/front/images/report-icons.png" alt="" />
                                     Report
                                    </a>';
                            }else{
                                 $response['posts'] .=' <a href="'. url('/') .'/login" postid="'. $post->id.'"  >
                                    <img src="'.url('/').'/assets/front/images/report-icons.png" alt="" />
                                    Report
                                  </a>';
                            }   
                         }else{
                            $response['posts'] .=' <a href="'. url('/') .'/login" postid="'.$post->id.'">
                                    
                                    <img src="'.url('/').'/assets/front/images/report-icons.png" alt="" />

                                    Report
                                  </a>    ';
                         }

                         $response['posts'] .='</div>';

                         $response['posts'] .=' </div>
                                            </div>
                                          <div class="clearfix"></div>
                                     </div>';

                    $last_id = $post->id;

                  


                }//foreach
              
                if(count($forum_posts)>=10)
                {
                    // dd(123);
                    $response['posts'] .= '
                       <div id="load_more" class="load_more_div text-center">
                        <button type="button" name="load_more_button" class="btn form-control forum-load_more_button" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                       </div>
                   ';
               }
            }
            else
            {
                $response['status'] = "failed";
                $response['posts'] .= '';
            }
            return response()->json($response);
        }
        
    }// end of function




    /*******************end of load post lising***************/

    /*************start*of*form post store**********************/



    public function forum_post_store(Request $request)
    {
        $user = Sentinel::check();

        $form_data = $request->all();
      //  echo "<pre>";print_r($form_data);
        
        $arr_rules = ['post_title' => 'required','container_id'=>'required'];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'error';
           
            $response['description'] = 'Please type something in text!';
            
            return response()->json($response);
        }

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;   
            $user_details = Sentinel::getUser();         
        }
        if($user_id)
        {


            $post_title = isset($form_data['post_title'])?$form_data['post_title']: '';
          //  $video = isset($form_data['video'])?$form_data['video']: '';

            $link = isset($form_data['link'])?$form_data['link']: '';
            $container_id = isset($form_data['container_id'])?$form_data['container_id']: '';



             $input_data = [
                            'user_id' => $user_id,
                            'title'   => $post_title,
                          //  'link'    => $link,
                            'container_id'=>$container_id,
                            'user_type'=>$user_details->user_type,
                           // 'video'   =>$video,
                           // 'image'   =>$image,
                            'is_active'=>'1'      
                            
                          ];



               $image = "";

                if($request->hasFile('image')) 
                {
                    $image = $request->input('image');
                    $file_extension = strtolower($request->file('image')->getClientOriginalExtension()); 
                     if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
                    {                           
                        $image = sha1(uniqid().$image.uniqid()).'.'.$file_extension;
                        $request->file('image')->move($this->post_base_path, $image);
                        $image  = $image;    

                        $input_data['image']= $image;
                        $input_data['post_type'] ='image';
                        $input_data['video']= '';
                        
                    }

                     else
                    {
                        $response['status']  = 'ERROR';
                        $response['description'] = 'Please select valid image, only jpg,png and jpeg file are allowed';

                        return response()->json($response);
                    } 
                    
                } 
                
                if(isset($form_data['video']) && !empty($form_data['video']))
                {
                     $input_data['video']= $form_data['video'];
                     $input_data['post_type'] ='video';
                     $input_data['image']= '';
                }

                 if(isset($form_data['link']) && !empty($form_data['link']))
                {
                     $input_data['link']= $form_data['link'];
                     $input_data['post_type'] ='link';
                     $input_data['image']= '';
                     $input_data['video']= '';
                }


           

            $add_post = $this->ForumPostsModel->create($input_data);
            // dd($add_post->id);
            if($add_post)
            {
                $post_detail = $this->ForumPostsModel->where('id',$add_post->id)->first();

                   


                   /******************* Notification START* For addiing comment on product **************/

                    $from_user_id = 0;
                    $admin_id     = 0;
                    $user_name    = $seller_fname = $seller_lname = $eventuser = "";

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        $user_name    = $user_details->first_name.' '.$user_details->last_name;

                         $user_name ='';   
                         $eventuser = '';

                         if($user_details->user_type=="buyer")
                         {
                            if($user_details->first_name=="" || $user_details->last_name==""){
                                 $user_name = $user_details->email;
                                 $eventuser = 'buyer';
                            }else{
                                 $user_name = $user_details->first_name.' '.$user_details->last_name;
                                 $eventuser = $user_details->first_name.' '.$user_details->last_name;
                            }
                         }
                         else if($user_details->user_type=="seller")
                         {
                            if($user_details->first_name=="" || $user_details->last_name==""){
                                 $user_name =$user_details->email;
                                 $eventuser ='dispensary';
                            }else{
                                 // $user_name = $user_details->first_name.' '.$user_details->last_name;
                                 // $eventuser = $user_details->first_name.' '.$user_details->last_name;
                                  $user_name = get_seller_details($user_details->id);
                                  $eventuser = get_seller_details($user_details->id);
                            }

                            // get followers of seller
                             $getfollowers = $this->FollowModel->where('seller_id',$user_details->id)->get();
                             if(isset($getfollowers) && !empty($getfollowers))
                             {
                                $getfollowers = $getfollowers->toArray();
                               $surl = url('/')."/forum/view_post/".base64_encode($add_post->id);

                                 foreach($getfollowers as $kk=>$vv)
                                 {

                                    $arr_event                     = [];
                                    $arr_event['from_user_id']     = $from_user_id;
                                    $arr_event['to_user_id']       = $vv['buyer_id'];
                                    $arr_event['type']             = '';                                   
                                    $arr_event['description']      = html_entity_decode('<b>'.$user_name.'</b>  added the post <a target="_blank" href="'.$surl.'"><b>'.$post_detail->title.'</b></a>');
                                    $arr_event['title']            = 'New Post';
                                    $this->GeneralService->save_notification($arr_event);

                                     //send email to follower start 
                                       $get_user_detail = $this->UserModel->where('id',$vv['buyer_id'])->first();
                                      if(isset($get_user_detail) && !empty($get_user_detail))
                                      {
                                          $get_user_detail = $get_user_detail->toArray();
                                          if(isset($get_user_detail))
                                          {
                                              $full_name = $get_user_detail['first_name'].' '.$get_user_detail['last_name'];
                                              //$subject     = 'Product Price Dropped';

                                            $arr_built_content = ['USER_NAME'     => $full_name,
                                                                  'APP_NAME'      => config('app.project.name'),
                                                                    //'MESSAGE'       => $msg,
                                                                    'URL'           => $surl,
                                                                    'USER'     => $user_name,
                                                                    'POST_TITLE'=>$post_detail->title
                                                                   ];

                                             $arr_mail_data['arr_built_subject'] = ['SELLER_NAME' => $user_name ];                       

                                              $arr_mail_data['email_template_id'] = '129';
                                              $arr_mail_data['arr_built_content'] = $arr_built_content;
                                             // $arr_mail_data['arr_built_subject'] = '';
                                              $arr_mail_data['user']              = Sentinel::findById($vv['buyer_id']);

                                              $this->EmailService->send_mail_section_order($arr_mail_data);
                                          }
                                      }//if get userdetail

                                    //send email to follower end


                                 }
                             }//if getfollowers



                         }//else if seller
                         else if($user_details->user_type=="admin")
                         {
                            if($user_details->first_name=="" || $user_details->last_name==""){
                                 $user_name = $user_details->email;
                                 $eventuser = 'admin';
                            }else{
                                 $user_name = $user_details->first_name.' '.$user_details->last_name;
                                 $eventuser = $user_details->first_name.' '.$user_details->last_name;

                            }
                         }//elseif admin



                    }

                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                    $url = url('/')."/forum/view_post/".base64_encode($add_post->id);

                    

                    /********************Send Notification to Admin(START)***************************/

                      if($from_user_id==$admin_id){

                      }else{

                        $arr_event                     = [];
                        $arr_event['from_user_id']     = $from_user_id;
                        $arr_event['to_user_id']       = $admin_id;
                        $arr_event['type']             = '';

                       
                        $arr_event['description']      = html_entity_decode('<b>'.$user_name.'</b>  added the post <a target="_blank" href="'.$url.'"><b>'.$post_detail->title.'</b></a>');
                        $arr_event['title']            = 'New Post';
                        
                        $this->GeneralService->save_notification($arr_event);
                    }
                    /********************Send Notification to Admin(END)******************************/

                    /********************Send Mail Notification to Admin(START)***********************/

                    if($from_user_id==$admin_id){}else{
                       
                           
                        $subject     = 'New Post';
                  
                        $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                              'APP_NAME'      => config('app.project.name'),
                                            //  'MESSAGE'       => $msg,
                                              'URL'           => $url,
                                              'BUYER_NAME'    => $user_name,
                                              'POST_TITLE'    => $post_detail->title 
                                             ];

                        $arr_mail_data['email_template_id'] = '72';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($admin_id);

                        $this->EmailService->send_notification_mail($arr_mail_data);
                    }//else of admin
                            
                    /********************Send Mail Notification to Admin(END)*************************/

                
                 /******************Add Event data************/
                        $arr_eventdata             = [];
                        $arr_eventdata['user_id']  = $from_user_id;
                     
                        $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                        <div class="mainmarqees-image">
                         <img src="'.url('/').'/assets/front/images/chow.png" alt="">
                         </div><b> Someone </b>  just shared a new post on chow. <div class="clearfix"></div></div><a href="'.url('/').'/forum/view_post/'.base64_encode($add_post->id).'" target="_blank" class="viewcls">View</a>');


                        $arr_eventdata['title']    = 'New Post';

                        $login_user     = Sentinel::check(); 

                        if(isset($login_user) && $login_user == true && $login_user->inRole('seller') == true)
                        {

                        }else{
                         $this->EventModel->create($arr_eventdata);
                        }
                        
                        
                    /***************end of event******************/

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ADD';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added forum post '.$post_title.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

          
            /*----------------------------------------------------------------------*/


                $response['status']      = 'success';
                
                $response['description'] = 'post added successfully.';
            }
            else
            {
                $response['status']      = 'error';
                
                $response['description'] = 'Unable to save post, please try again later.';
            }
        }
        else
        {
            $response['status']      = 'error';
            $response['description'] = 'Please Sign In first to add post!.';

        }

        return response()->json($response);

    }//end of function



    /***************end of forum post store****************/

}//end of class

