<?php

namespace App\Http\Controllers\Seller; 

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
 
use App\Common\Traits\MultiActionTrait;
 
use App\Models\UserModel;
use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Models\RoleUserModel; 
use App\Models\GeneralSettingsModel;

use App\Models\PostModel;
use App\Models\ContainerModel;


use App\Models\ForumCommentsModel;
use App\Models\ForumLikeDislikeModel;
use App\Models\ForumCommentLikeDislikeModel;
use App\Models\ForumReplyLikeDislikeModel;



use App\Common\Services\EmailService;
use App\Common\Services\PostService;

use Flash;
use Validator; 
use Sentinel;
use Activation;
use Reminder;
use DB;
use Image;
use Datatables;
use Excel;
use Illuminate\Support\Facades\Input;

class ForumPostController extends Controller
{
    use MultiActionTrait;

    public function __construct(UserModel $user,
                               
                                BuyerModel $buyerModel,
                                SellerModel $sellerModel,
                                RoleUserModel $roleUserModel,
                                EmailService $EmailService,
                                PostService $PostService,
                                GeneralSettingsModel $GeneralSettingsModel,
                                 PostModel $PostModel,
                                ContainerModel $ContainerModel,

                                 ForumCommentsModel $ForumCommentsModel,
                                ForumLikeDislikeModel $ForumLikeDislikeModel,
                                ForumCommentLikeDislikeModel $ForumCommentLikeDislikeModel,
                                ForumReplyLikeDislikeModel $ForumReplyLikeDislikeModel


                                
                                )
    {
        $user = Sentinel::createModel();

        $this->EmailService                 = $EmailService;
        $this->UserModel                    = $user;
        $this->BaseModel                    = $this->UserModel;   // using sentinel for base model.
        $this->BuyerModel                   = $buyerModel;
        $this->SellerModel                  = $sellerModel;
        $this->RoleUserModel                = $roleUserModel;
        $this->GeneralSettingsModel         = $GeneralSettingsModel;
        $this->PostService                  = $PostService;
          $this->PostModel                    = $PostModel; 
        $this->ContainerModel               = $ContainerModel;

         $this->ForumCommentsModel         = $ForumCommentsModel;
        $this->ForumLikeDislikeModel      = $ForumLikeDislikeModel;
        $this->ForumCommentLikeDislikeModel = $ForumCommentLikeDislikeModel;
        $this->ForumReplyLikeDislikeModel = $ForumReplyLikeDislikeModel;



        $this->arr_view_data                = [];
       // $this->module_url_path              = url(config('app.project.admin_panel_slug')."/productlist");
        $this->module_title                 = "Forum Posts";
        $this->modyle_url_slug              = "Posts";
        $this->module_view_folder           = "seller.forum_post";
       
    }   

    public function index()
    {
        $this->arr_view_data['arr_data'] = array();
        
        $this->arr_view_data['page_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);

        $seller_id = '';
        $arr_seller = [];
        $user = Sentinel::getUser();
        if(!empty($user))
        {
           $seller_id = $user->id;

          /* get seller detail */
            $obj_seller = $this->SellerModel->where('user_id',$seller_id)->first();
 
            if($obj_seller)
            {
                $arr_seller = $obj_seller->toArray();
            }
          /*end*/

            $user_arr = $user->toArray();
        }
 
        $res_post = $this->PostModel->with('get_container_detail')
                                          ->where('is_active','1')
                                          ->where('user_id',$seller_id)
                                          ->get()->toArray();

        $this->arr_view_data['arr_post'] = $res_post;
        $this->arr_view_data['arr_seller']  = $arr_seller;        
        $this->arr_view_data['user_arr'] = isset($user_arr)?$user_arr:[];

        return view($this->module_view_folder.'.my_posts', $this->arr_view_data);
    }

    // FUNCTION TO SHOW RECORDS OF product listing

    public function get_records(Request $request)
    {
         
        
        $obj_user     = $this->get_postlist_details($request);

        $current_context = $this;
        $json_result     = Datatables::of($obj_user);
        $json_result     = $json_result->blacklist(['id']);        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                           ->editColumn('container',function($data) use ($current_context)
                            {
                              if(isset($data->container))
                                return $data->container;
                              else 
                                return 'NA';
                            })

                            ->editColumn('title',function($data) use ($current_context)
                            {
                                   if(strlen($data->title)>100){
                                         return '<p class="prod-desc">'.str_limit($data->title,100).'..<a class="readmorebtnoftitle btn btn-default" title="'.strip_tags($data->title).'"  settitle="'.$data->title.'" style="cursor:pointer" >View Title</a></p>';
                                    }
                                    else{
                                        return $data->title;
                                    }
                            })

                            ->editColumn('post_type',function($data) use ($current_context)
                            {
                              if(isset($data->post_type) && !empty($data->post_type))
                                return $data->post_type;
                              else 
                                return 'NA';
                            })
                           
                           /* ->editColumn('description',function($data) use ($current_context)
                            {
                                if(strlen($data->description)>50){
                                   return '<p class="prod-desc">'.str_limit($data->description,50).'..<a class="readmorebtn" description="'.$data->description.'" style="cursor:pointer"><b>Read more</b></a></p>';
                                }
                                else{
                                    return $data->description;
                                }
                            })*/
                          
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                /*view*/
                                $view_href =  url('/').'/seller/posts/view/'.base64_encode($data->id);

                                $build_view_action = '<a href="'.$view_href.'" class="eye-actn" title="View Post">
                                View
                                </a>';


                                /*edit*/
                                $edit_href =  url('/').'/seller/posts/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a href="'.$edit_href.'" class="eye-actn" title="Edit Post"> Edit
                                </a>';
                                
                                /*delete*/
                                $delete_href =  url('/').'/seller/posts/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';

                                $build_delete_action = '<a class="eye-actn btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                             

                                return $build_action = $build_view_action.' '.$build_edit_action.' '.$build_delete_action;
                                // return $build_action = $build_edit_action.' '.$build_delete_action;
                            })
                        
                            ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
    }

    public function get_postlist_details(Request $request)
    {
      

        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;
        }
 

         $post_details    = $this->PostModel->getTable();
        $prefix_post_detail  = DB::getTablePrefix().$this->PostModel->getTable();

        $user_details       = $this->BaseModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->BaseModel->getTable();

        $container_details       = $this->ContainerModel->getTable();
        $prefix_container_detail = DB::getTablePrefix().$this->ContainerModel->getTable();
       
        $obj_post = DB::table($post_details)->select(DB::raw( $post_details.'.*,'.
                         $prefix_container_detail.'.title as container,'.

                        "CONCAT(".$prefix_user_detail.".first_name,' ',"
                                .$prefix_user_detail.".last_name) as user_name"
                            ))
                           ->leftJoin($prefix_container_detail,$prefix_container_detail.'.id','=',$post_details.'.container_id')
                            ->leftjoin($prefix_user_detail,$prefix_user_detail.'.id','=',$post_details.'.user_id')
                            ->where($post_details.'.user_id',$seller_id)
                            ->orderBy($post_details.'.id','desc');  

                            /******************** search conditions logic here ***************/

          $arr_search_column = $request->input('column_filter');


          if(isset($arr_search_column['q_title']) && $arr_search_column['q_title'] != '')
          {
              $search_name_term  = $arr_search_column['q_title'];
              $obj_post  = $obj_post->where($post_details.'.title','LIKE', '%'.$search_name_term.'%');

          }
        
           if(isset($arr_search_column['q_container']) && $arr_search_column['q_container'] != '')
          {
              $search_container_term  = $arr_search_column['q_container'];
              $obj_post  = $obj_post->where($prefix_container_detail.'.title','LIKE', '%'.$search_container_term.'%');

          }
         

            if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
          {
              $search_status  = $arr_search_column['q_status'];
              if($search_status=="-1"){}else{
              $obj_post  = $obj_post->where($prefix_post_detail.'.is_active','LIKE', '%'.$search_status.'%');
              }

          } 
                 
         return $obj_post;
                                    
    }
    
    public function create()
    {
        $arr_seller = [];
        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;

           /* get seller detail */
            $obj_seller = $this->SellerModel->where('user_id',$seller_id)->first();

            if($obj_seller)
            {
                $arr_seller = $obj_seller->toArray();
                   
            }
          /*end*/
        }


        $arr_category  = $arr_unit = [];
        $this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        //$this->arr_view_data['module_url_path'] = $this->module_url_path;

        $arr_container  = $this->ContainerModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_container']   = isset($arr_container) ?$arr_container:[];

    


        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable(); 

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();





         $this->arr_view_data['age_restrictiondata']  = isset($res_age_Restriction)?$res_age_Restriction:[];        
        
        return view($this->module_view_folder.'.add',$this->arr_view_data);
    }
  

   public function save(Request $request)
    {
        // dd(123);
        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;
        }

        $form_data = $request->all();

        $is_active = isset($form_data['is_active'])?$form_data['is_active']:0;


        $form_data['user_id'] = $seller_id;
        $form_data['user_type'] = 'Seller';
        $form_data['is_active'] = $is_active;

        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }


        $arr_rules = [];

        $arr_rules =    [
                           'title'             => 'required|max:400',
                           'container_id'      => 'required',
                        //   'description'              => 'required'
                        ];



         $validator = Validator::make($request->all(),$arr_rules);

         if($validator->fails())
         { 
            $description = Validator::make($request->all(),$arr_rules)->errors()->first();

            $response['status']      = 'warning';
            $response['description'] = $description;
            // $response['description'] = 'Form validation failed..Please check all fields..';

            return response()->json($response);
         }


         if ($request->hasFile('image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image. Only jpg, png, jpeg extensions are allowed.';
                return response()->json($response);
            }

        } 

          if(isset($form_data['video']))
        {
          if (strpos($form_data['video'], 'youtube') !== false) {

             if (strpos($form_data['video'], 'v=') !== false) {
             }else{
                $response['status']       = 'warning';
                $response['description']  = 'Please enter valid youtube link';
                return response()->json($response);
             }

          }else{
               $response['status']       = 'warning';
                $response['description']  = 'Please enter valid youtube link';
                return response()->json($response);
          }
        }//if formdata

                  
        $postlist = $this->PostService->save($form_data,$request);

        if($postlist)
        {
  
          if($is_update_process==true)
          {
            $response['status']      =  "success";
            $response['description'] =  "Forum post details updated successfully."; 
            $response['link']        =  url('/').'/seller/posts';
          }
          else
          {
            $response['status']      =  "success";
            $response['description'] =  "Forum post added successfully.";
            $response['link']        =  url('/').'/seller/posts'; 
          }
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding forum post.";
        }

        return response()->json($response);
    }     

     public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->PostModel->where('id', $id)->first();
    
        $arr_post = [];
        if($obj_data)
        {
           $arr_post = $obj_data->toArray(); 
        }       
   

         $arr_container  = $this->ContainerModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_container']     = isset($arr_container) ?$arr_container:[];
      

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();
       

    
        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
       // $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['arr_post']              = isset($arr_post) ? $arr_post : [];  
        $this->arr_view_data['page_title']               = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']             = $this->module_title;


  
      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

   

    public function multi_action(Request $request)
    {
        /*Check Validations*/
        $input = request()->validate([
                'multi_action' => 'required',
                'checked_record' => 'required'
            ], [
                'multi_action.required' => 'Please  select record required',
                'checked_record.required' => 'Please select record required'
            ]);

        $multi_action   = $request->input('multi_action');
        $checked_record = $request->input('checked_record');


        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Flash::error('Problem Occurred, While Doing Multi Action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
               $this->perform_delete(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Deleted Successfully'); 
            } 
            elseif($multi_action=="activate")
            {
               $this->perform_activate(base64_decode($record_id)); 
               Flash::success(str_plural($this->module_title).' Activated Successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $this->perform_deactivate(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Blocked Successfully');  
            }
        }

        return redirect()->back();
    }


    public function activate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_activate(base64_decode($enc_id)))
        {
             $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'ACTIVE';
        return response()->json($arr_response);
    }

    public function deactivate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_deactivate(base64_decode($enc_id)))
        {
            $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }


       public function perform_activate($id)
    {
        $entity = $this->PostModel->where('id',$id)->first();
        
        if($entity)
        {
            return $this->PostModel->where('id',$id)->update(['is_active'=>'1']);
        }

        return FALSE;
    }

 
      public function perform_deactivate($id)
    {

        $entity = $this->PostModel->where('id',$id)->first();
        if($entity)
        {
            return $this->PostModel->where('id',$id)->update(['is_active'=>'0']);
        }
        return FALSE;
    }

    
   

     public function delete($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {
            Flash::success(str_singular($this->module_title).' Deleted Successfully');
        }
        else
        {
            Flash::error('Problem Occurred While Deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }

     public function perform_delete($id)
    {
        $entity          = $this->PostModel->where('id',$id)->first();
    
        if($entity)
        {
          
              $this->PostModel->where('id',$id)->delete();
              $this->ForumCommentsModel->where('post_id',$id)->delete();
              $this->ForumLikeDislikeModel->where('post_id',$id)->delete();
              $this->ForumCommentLikeDislikeModel->where('post_id',$id)->delete();
              $this->ForumReplyLikeDislikeModel->where('post_id',$id)->delete();



        
              Flash::success(str_plural($this->module_title).' Deleted Successfully');
              return true; 
        }
        else
        {
          Flash::error('Problem Occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }



    public function view($postid)
    {
       $postid = base64_decode($postid);

        $this->arr['arr_data'] = array();
        $arr_post_data    = $this->PostService->get_post_details($postid);

       

        $this->arr_view_data['page_title']      = "Forum Post Details";
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        // $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_post_data']        = $arr_post_data;  
       
        return view($this->module_view_folder.'.view', $this->arr_view_data);
    }
       

    public function build_select_options_array(array $arr_data,$option_key,$option_value,array $arr_default)
    {

        $arr_options = [];
        if(sizeof($arr_default)>0)
        {
            $arr_options =  $arr_default;   
        } 

        if(sizeof($arr_data)>0)
        {
            foreach ($arr_data as $key => $data) 
            {
                if(isset($data[$option_key]) && isset($data[$option_value]))
                {
                    $arr_options[$data[$option_key]] = $data[$option_value];
                }
            }
        }

        return $arr_options;
    }




}
