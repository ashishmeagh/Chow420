<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
 
use App\Common\Traits\MultiActionTrait;

use App\Models\UserModel;
use App\Models\CountriesModel;

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

 
  
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Common\Services\PostService;
 use App\Common\Services\UserService;

use Flash;
use Validator; 
use Sentinel;
use Activation;
use Reminder;
use DB;
use Image;
use Datatables;
 
class PostController extends Controller
{
    use MultiActionTrait;

    public function __construct(UserModel $user,
                                CountriesModel $country,                                
                                BuyerModel $buyerModel,
                                SellerModel $sellerModel,
                                RoleUserModel $roleUserModel,
                                EmailService $EmailService,
                                PostService $PostService,
                                GeneralSettingsModel $GeneralSettingsModel,
                                GeneralService $GeneralService,
                                PostModel $PostModel,
                                ContainerModel $ContainerModel,
                                ForumCommentsModel $ForumCommentsModel,
                                ForumLikeDislikeModel $ForumLikeDislikeModel,
                                ForumCommentLikeDislikeModel $ForumCommentLikeDislikeModel,
                                ForumReplyLikeDislikeModel $ForumReplyLikeDislikeModel,
                                UserService $UserService
                                )
    {
      
        $user = Sentinel::createModel();

        $this->EmailService                 = $EmailService;
        $this->UserModel                    = $user;
        $this->BaseModel                    = $this->UserModel;   // using sentinel for base model.
        $this->CountriesModel               = $country;
        $this->BuyerModel                   = $buyerModel;
        $this->SellerModel                  = $sellerModel;
        $this->RoleUserModel                = $roleUserModel;
        $this->GeneralSettingsModel         = $GeneralSettingsModel;

        $this->PostService                  = $PostService;
        $this->GeneralService               = $GeneralService;   
        $this->PostModel                    = $PostModel; 
        $this->ContainerModel               = $ContainerModel;


        $this->ForumCommentsModel           = $ForumCommentsModel;
        $this->ForumLikeDislikeModel        = $ForumLikeDislikeModel;
        $this->ForumCommentLikeDislikeModel = $ForumCommentLikeDislikeModel;
        $this->ForumReplyLikeDislikeModel   = $ForumReplyLikeDislikeModel;
        $this->UserService                  = $UserService;



        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/post");

        $this->module_title                 = "Forum Posts";
        $this->modyle_url_slug              = "Post Listing";
        $this->module_view_folder           = "admin.post";
        $this->post_public_img_path         = url('/').config('app.project.img_path.post');
    }   

    public function index()
    {
        $this->arr_view_data['arr_data'] = array();
        
        $this->arr_view_data['page_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }

    public function get_postlist_details(Request $request) 
    {
      
        $post_details    = $this->PostModel->getTable();
        $prefix_post_detail  = DB::getTablePrefix().$this->PostModel->getTable();

        $user_details       = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $container_details       = $this->ContainerModel->getTable();
        $prefix_container_detail = DB::getTablePrefix().$this->ContainerModel->getTable();


        $obj_post = DB::table($post_details)->select(DB::raw( $post_details.'.*,'.
                         $prefix_container_detail.'.title as container,'.
                          $prefix_user_detail.'.email as email,'.
                        "CONCAT(".$prefix_user_detail.".first_name,' ',"
                                .$prefix_user_detail.".last_name) as user_name"
                            ))
                        ->leftJoin($prefix_container_detail,$prefix_container_detail.'.id','=',$post_details.'.container_id')
                        ->leftjoin($prefix_user_detail,$prefix_user_detail.'.id','=',$post_details.'.user_id')
                        ->orderBy($post_details.'.id','desc');   
                       // ->get(); 
                     
         /* ---------------- Filtering Logic ----------------------------------*/
         $arr_search_column = $request->input('column_filter');

         if(isset($arr_search_column['q_title']) && $arr_search_column['q_title'] != '')
          {
              $search_name_term  = $arr_search_column['q_title'];
              $obj_post  = $obj_post->where($post_details.'.title','LIKE', '%'.$search_name_term.'%');

          }
          if(isset($arr_search_column['q_user_name']) && $arr_search_column['q_user_name'] != '')
          {
             $search_user_term  = $arr_search_column['q_user_name'];
             $obj_post  = $obj_post->where($user_details.'.first_name','LIKE', '%'.$search_user_term.'%')->orWhere('last_name', 'LIKE', '%'.$search_user_term.'%');

          }
           if(isset($arr_search_column['q_container']) && $arr_search_column['q_container'] != '')
          {
              $search_container_term  = $arr_search_column['q_container'];
              $obj_post  = $obj_post->where($prefix_container_detail.'.title','LIKE', '%'.$search_container_term.'%');

          }
         

            if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
          {
              $search_status  = $arr_search_column['q_status'];
              $obj_post  = $obj_post->where($prefix_post_detail.'.is_active','LIKE', '%'.$search_status.'%');

          }
        
                  
         return $obj_post;
                                    
    }

    // FUNCTION TO SHOW RECORDS OF post listing

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
                           ->editColumn('user_name',function($data) use ($current_context)
                            {

                              if(isset($data->user_name) && !empty($data->user_name) && strlen($data->user_name)>1)
                                return $data->user_name;
                              else 
                                return $data->email;
                            })

                            ->editColumn('title',function($data) use ($current_context)
                            {
                                /*   if(strlen($data->title)>100){
                                         return '<p class="prod-desc">'.str_limit($data->title,100).'..<a class="readmorebtnoftitle btn btn-default" title="'.strip_tags($data->title).'"  settitle="'.$data->title.'" style="cursor:pointer" >View Title</a></p>';
                                    }
                                    else{
                                        return $data->title;
                                    }*/

                                return '<p class="prod-desc"><a class="readmorebtnoftitle btn btn-default" title="'.strip_tags($data->title).'"  settitle="'.$data->title.'" style="cursor:pointer;color:#fff" >View Title</a></p>';  
                            })
  

                           ->editColumn('container',function($data) use ($current_context)
                            {
                              if(isset($data->container) && !empty($data->container))
                                return $data->container;
                              else 
                                return 'NA';
                            })
                            ->editColumn('post_type',function($data) use ($current_context)
                            {
                              if(isset($data->post_type))
                                return $data->post_type;
                              else 
                                return 'NA';
                            })
                           /*->editColumn('description',function($data) use ($current_context)
                            {
                                if(strlen($data->description)>50){
                                   return '<p class="prod-desc">'.str_limit($data->description,50).'..<a class="readmorebtn" description="'.$data->description.'" style="cursor:pointer"><b>Read more</b></a></p>';
                                }
                                else{
                                    return $data->description;
                                }
                            })*/
                            ->editColumn('build_status_btn',function($data) use ($current_context)
                            {

                                $build_status_btn ='';


                                if($data->is_active == '0')
                                {   

                                    $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->is_active == 1)
                                {
                                   
                                    $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_status_btn;
                            })  
                              ->editColumn('build_featured_btn',function($data) use ($current_context)
                            {
                                 $build_featured_btn = "";
                                if($data->is_featured == '0')
                                {
                                   $build_featured_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitchFeatured" data-type="featured" data-color="#99d683" data-secondary-color="#f96262" />';

                                }
                                else if($data->is_featured == '1')
                                {
                                    $build_featured_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitchFeatured" data-type="unfeatured" data-color="#99d683" data-secondary-color="#f96262"/>';
                                }

                                return $build_featured_btn;
                            })     

                                            
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                 $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                 $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                                $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                                $build_view_action = '<a class="eye-actn" href="'.$view_href.'" title="View">View</a>';

                                $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';

                                $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';

                             
                                return $build_action = $build_edit_action.' '.$build_view_action.' '.$build_delete_action;
                            })
                        
                            ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
    }

   
    public function create()
    {
        $arr_category  = $arr_unit = [];
        $this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_singular($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        $arr_container  = $this->ContainerModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_container']   = isset($arr_container) ?$arr_container:[];



        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable(); 

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }
   

    public function save(Request $request) 
    {
        $user = Sentinel::check();

        $form_data = $request->all();

        $product_stock = isset($form_data['product_stock'])?$form_data['product_stock']:'';


      
        $is_update_process = false; 

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }


        $arr_rules = [];
        //if($is_update_process == false)
       // {
            $arr_rules = [
                            'title' => 'required',
                            'container_id' => 'required',
                           // 'description'=>'required',
                           // 'user_id'=>'required',
                         ];

       // } 


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all required fields..';

            return response()->json($response);
        }

         if (isset($request->title)) 
        {

             if(strlen($request->title)>400){
                $response['status']       = 'warning';
                $response['description']  = 'The title may not be greater than 400 characters.';
                return response()->json($response);
              }
            
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
        }

     
           
        $postlist = $this->PostService->save($form_data,$request);
     
        if($postlist)
        {
  
            if($is_update_process == false)
            {
                if($postlist->id)
                {
                    $response['link'] = $this->module_url_path;

                }else{

                    $response['link'] = $this->module_url_path;

                }
            }
            else
            {
                $response['link'] = $this->module_url_path;
            }

            if($is_update_process==true)
            {
                
                  /*-------------------------------------------------------
                  |   Activity log Event
                  --------------------------------------------------------*/
                    
                  //save sub admin activity log 

                  if(isset($user) && $user->inRole('sub_admin'))
                  {
                        $arr_event                 = [];
                        $arr_event['action']       = 'EDIT';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated forum post '.$form_data['title'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                  }

                  /*----------------------------------------------------------------------*/
                  $response['status']      = "success";
                  $response['description'] = "Forum post updated successfully."; 

            }
            else
            {
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
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added forum post '.$form_data['title'].'.';

                      $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['status']      = "success";
                $response['description'] = "Forum post added successfully."; 

            }

        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding post.";
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
        $this->arr_view_data['arr_container']            = isset($arr_container) ?$arr_container:[];
       

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();


         $arr_user  = $this->UserModel
                                  ->where('is_active','1')
                                  ->where('is_trusted','1')
                                  ->get()
                                  ->toArray(); 
 
        $this->arr_view_data['arr_user']   = isset($arr_user) ?$arr_user:[];
        $this->arr_view_data['post_public_img_path']  = $this->post_public_img_path;

   
        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['arr_post']                 = isset($arr_post) ? $arr_post : []; 
        $this->arr_view_data['page_title']               = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']             = $this->module_title;


      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    } 

  
  

    public function multi_action(Request $request)
    {
        $user = Sentinel::check();
        $flag = "";

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
            Flash::error('Problem occurred, while doing multi action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
                $flag = "del";
                $this->perform_delete(base64_decode($record_id),$flag);    
                Flash::success(str_plural($this->module_title).' deleted successfully'); 
            } 
            elseif($multi_action=="activate")
            {
              
                $flag = "activate";

                $this->perform_activate(base64_decode($record_id),$flag); 
                Flash::success(str_plural($this->module_title).' activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
                
                $flag = "deactivate";

                $this->perform_deactivate(base64_decode($record_id),$flag);    
                Flash::success(str_plural($this->module_title).' blocked successfully');  
            }
        }

        if($multi_action=="delete")
        {
           /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'Delete';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on forum post.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

        }

        if($multi_action=="activate")
        {
             /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on forum post.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
        }


        if($multi_action=="deactivate")
        {
           /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DEACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on forum post.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
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
            $arr_response['msg']   = 'Something went wrong';
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
            $arr_response['msg']   = 'Something went wrong';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }


    public function perform_activate($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity = $this->PostModel->where('id',$id)->first();
        
        if($entity)
        {
            $entity_arr = $entity->toArray();


          if($flag==false)
          {
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
              //save sub admin activity log 

              if(isset($user) && $user->inRole('sub_admin'))
              {
                  $arr_event                 = [];
                  $arr_event['action']       = 'ACTIVATE';
                  $arr_event['title']        = $this->module_title;
                  $arr_event['user_id']      = isset($user->id)?$user->id:'';
                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated forum post '.$entity_arr['title'].'.';

                  $result = $this->UserService->save_activity($arr_event); 
              }

          
            /*----------------------------------------------------------------------*/
          }  
            

            return $this->PostModel->where('id',$id)->update(['is_active'=>'1']);
        }
        return FALSE;
        
    }

 
    public function perform_deactivate($id,$flag=false)
    { 
        $user = Sentinel::check();

        $entity = $this->PostModel->where('id',$id)->first();

        if($entity)
        {   
           $entity_arr = $entity->toArray();

          
          if($flag==false)
          {
              /*-------------------------------------------------------
              |   Activity log Event
              --------------------------------------------------------*/
                
              //save sub admin activity log 

              if(isset($user) && $user->inRole('sub_admin'))
              {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DEACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated forum post '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
              }
    
              /*----------------------------------------------------------------------*/
          }
            
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
           Flash::success(str_singular($this->module_title).' deleted successfully');
        }
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }

    public function perform_delete($id,$flag=false)
    {
        $user      = Sentinel::check();
        $entity    = $this->PostModel->where('id',$id)->first();
    
        if($entity)
        {
              $entity_arr = $entity->toArray();

              $this->PostModel->where('id',$id)->delete();
              $this->ForumCommentsModel->where('post_id',$id)->delete();
              $this->ForumLikeDislikeModel->where('post_id',$id)->delete();
              $this->ForumCommentLikeDislikeModel->where('post_id',$id)->delete();
              $this->ForumReplyLikeDislikeModel->where('post_id',$id)->delete();

            
             if($flag == false)
             {
                 /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                  //save sub admin activity log 

                  if(isset($user) && $user->inRole('sub_admin'))
                  {
                        $arr_event                 = [];
                        $arr_event['action']       = 'Delete';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted forum post '.$entity_arr['title'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                  }

                /*----------------------------------------------------------------------*/
             }
 

              Flash::success(str_plural($this->module_title).' deleted successfully');
              return true; 
        }
        else
        {
          Flash::error('Problem occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }



    public function view($postid)
    {
       $postid = base64_decode($postid);

        $this->arr['arr_data'] = array();
        $obj_data    = $this->PostService->get_post_details($postid);
        

        $this->arr_view_data['page_title']      = "Forum Post Details";
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $obj_data;  

        return view($this->module_view_folder.'.show', $this->arr_view_data);
    }
    
  
    public function featured(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        $arr_response = [];    
        if($this->perform_featured(base64_decode($enc_id)))
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

    public function unfeatured(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        $arr_response = []; 
        
        if($this->perform_unfeatured(base64_decode($enc_id)))
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

    public function perform_featured($id)
    {
        $user = Sentinel::check();

        $post = $this->PostModel->where('id',$id)->update(['is_featured'=>'1']);

        $post_obj = $this->PostModel->where('id',$id)->first(); 
       
        if($post)
        {
            $post_arr = $post_obj->toArray();
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
              //save sub admin activity log 

              if(isset($user) && $user->inRole('sub_admin'))
              {
                    $arr_event                 = [];
                    $arr_event['action']       = 'FEATURED';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has featured forum post '.$post_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
              }

            /*----------------------------------------------------------------------*/

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function perform_unfeatured($id)
    {
        $user = Sentinel::check();

        $post     = $this->PostModel->where('id',$id)->update(['is_featured'=>'0']);
         
        $post_obj = $this->PostModel->where('id',$id)->first(); 
       
        
        if($post)
        {
            $post_arr = $post_obj->toArray();

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
              //save sub admin activity log 

              if(isset($user) && $user->inRole('sub_admin'))
              {
                    $arr_event                 = [];
                    $arr_event['action']       = 'FEATURED';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has unfeatured forum post '.$post_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
              }

            /*----------------------------------------------------------------------*/

            return TRUE;
        }
        else
        {
            return FALSE;
        }
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
