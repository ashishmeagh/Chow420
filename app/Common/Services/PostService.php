<?php

namespace App\Common\Services;

use App\Models\UserModel;
//use app\Models\ContainerModel;
use App\Models\PostModel;



use App\Common\Services\EmailService;

use Illuminate\Http\Request;
use Flash;   

use DB;
use Sentinel;
use Image;

use App\Common\Services\GeneralService;


class PostService
{
	public function __construct(
                                UserModel $UserModel,                                                        
                                GeneralService $GeneralService,
                                EmailService $EmailService,
                                PostModel $PostModel
                                //ContainerModel $ContainerModel
                            )
	{ 
        $this->UserModel                = $UserModel;
        $this->module_title             = "Manage Product";
        $this->GeneralService           = $GeneralService;
      //  $this->ContainerModel           = $ContainerModel;
        $this->EmailService             = $EmailService;
        $this->PostModel                = $PostModel;   
        $this->post_base_path   = base_path().config('app.project.img_path.post');


	}

    public function get_post_details($post_id)
    {
        $arr_post = [];

        $obj_post  = $this->PostModel
                          ->with([
                            'user_details',
                            'get_container_detail'
                                ]) 
                          ->where('id',$post_id)
                          ->first();
        if($obj_post)
        {
            $arr_post = $obj_post->toArray();
            
        }
       
        return $arr_post;
    }
   

    public function save($form_data, Request $request)
    {


        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

         /* Main Model Entry */
        $postlist = $this->PostModel->firstOrNew(['id' => $id]);

        if(!empty($postlist) && $postlist->error_message!='')
        {
           $postlist->error_message=''; 
        }


        $postlist->title             =  isset($form_data['title'])?$form_data['title']:'';
        $postlist->container_id  =  isset($form_data['container_id'])?$form_data['container_id']:'';
        $postlist->description    =  isset($form_data['description'])?$form_data['description']:'';
       // $postlist->user_id        =  isset($form_data['user_id'])?$form_data['user_id']:'';

         $post_type = isset($form_data['post_type'])?$form_data['post_type']:'';
         $video = isset($form_data['video'])?$form_data['video']:'';
         $link = isset($form_data['link'])?$form_data['link']:'';

         $is_active    = isset($form_data['is_active'])?$form_data['is_active']:0;

        $user = Sentinel::check();        
         $user_details = Sentinel::getUser();

        if ($is_update_process == false) {
            // if insert product
            if($user->inRole('admin')==true)
            {
               $postlist->is_active=1;
               $postlist->user_id = $user_details->id; 
               $postlist->user_type = $user_details->user_type;

            }
            else if($user->inRole('seller')==true){
               $postlist->is_active=$is_active;
               $postlist->user_id = $user_details->id;
               $postlist->user_type = $user_details->user_type;

            }
             else if($user->inRole('buyer')==true){

               $postlist->is_active=$is_active;
               $postlist->user_id = $user_details->id;
               $postlist->user_type = $user_details->user_type;


            }
       }
       else if($is_update_process==true)
       {    //if update product
            if($user->inRole('seller')==true)
            {
                $postlist->is_active=$is_active;
            }
            if($user->inRole('buyer')==true)
            {
                $postlist->is_active=$is_active;
            }
       }


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

                $unlink_old_img_path    = $this->post_base_path.'/'.$request->input('old_img');
               
            
                if(file_exists($unlink_old_img_path))
                {
                    @unlink($unlink_old_img_path);  
                } 
             }
               
           
         } else{
              $image = $request->input('old_img');
          }

         $postlist->post_type = $post_type;
         $postlist->image = $image;
         $postlist->video = $video;
         $postlist->link = $link;
      
        $postlist->save();

        if ($is_update_process == false) // add
        {            
           
             if($user->inRole('seller')==true){

               /******************* Notification START* For add product *************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                  
                    $f_name = isset($user_details->first_name)?$user_details->first_name:'';
                    $l_name = isset($user_details->last_name)?$user_details->last_name:'';

                    $user_name    = $f_name.' '.$l_name;
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                $url = url(config('app.project.admin_panel_slug')."/post/").base64_encode($from_user_id);

                $post_url     = url('/').'/'.config('app.project.admin_panel_slug').'/post/view/'.base64_encode($postlist->id);

                $arr_event                 = [];
                $arr_event['from_user_id'] = $from_user_id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['description']  = html_entity_decode('Seller <b>'.$user_name.'</b> has added new post <b><a target="_blank" href="'.$post_url.'">'.$postlist->title.'</a></b>');
               // $arr_event['url']        = $url;
                $arr_event['type']         = '';
                $arr_event['title']        = 'Post Added By Seller';

                $this->GeneralService->save_notification($arr_event);

            /*******************Notification END for add product***************************/ 

            /**************Send Mail Notification to Admin (START)*******************/
                $msg    = html_entity_decode('Seller <b>'.$user_name.'</b> has added new post <b>'.$postlist->title.'</b>.');

                $post_url     = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($postlist->id);
                $subject     = 'Post Added By Seller';

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      'MESSAGE'       => $msg,
                                      'URL'           => $post_url
                                     ];

                $arr_mail_data['email_template_id'] = '31';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $subject;
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_notification_mail($arr_mail_data);

            /**************Send Mail Notification to Admin (END)*********************/

             }//in role seller

             /***************************************************/
             if($user->inRole('buyer')==true){

               /******************* Notification START* For add post for buyer *************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                  
                    $f_name = isset($user_details->first_name)?$user_details->first_name:'';
                    $l_name = isset($user_details->last_name)?$user_details->last_name:'';

                    $user_name    = $f_name.' '.$l_name;
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                $url = url(config('app.project.admin_panel_slug')."/post/").base64_encode($from_user_id);

                $post_url     = url('/').'/'.config('app.project.admin_panel_slug').'/post/view/'.base64_encode($postlist->id);

                $arr_event                 = [];
                $arr_event['from_user_id'] = $from_user_id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['description']  = html_entity_decode('Buyer <b>'.$user_name.'</b> has added new post <b><a target="_blank" href="'.$post_url.'">'.$postlist->title.'</a></b>');
               // $arr_event['url']        = $url;
                $arr_event['type']         = '';
                $arr_event['title']        = 'Post Added By Buyer';

                $this->GeneralService->save_notification($arr_event);

            /*******************Notification END for add product***************************/ 

            /**************Send Mail Notification to Admin (START)*******************/
                $msg    = html_entity_decode('Buyer <b>'.$user_name.'</b> has added new post <b>'.$postlist->title.'</b>.');

                $post_url     = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($postlist->id);
                $subject     = 'Post Added By Buyer';

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      'MESSAGE'       => $msg,
                                      'URL'           => $post_url
                                     ];

                $arr_mail_data['email_template_id'] = '31';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $subject;
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_notification_mail($arr_mail_data);

            /**************Send Mail Notification to Admin (END)*********************/

             }//in role seller

             /*************************************************/
        }

        return $postlist;
    }

	

}

?>