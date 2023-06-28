<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ContainerModel;
use App\Models\PostModel;
use App\Models\ForumCommentsModel;
use App\Models\ForumLikeDislikeModel;
use App\Models\ForumCommentLikeDislikeModel;
use App\Models\ForumReplyLikeDislikeModel;

use App\Common\Services\UserService;
use App\Common\Traits\MultiActionTrait;

use Validator; 
use Session; 
use Flash;
use File;
use Sentinel;
use DB;
use Datatables;
use Image; 

class ContainerController extends Controller
{	
	use MultiActionTrait;

    public function __construct(
    							ContainerModel $ContainerModel,
                                PostModel $PostModel,
                                ForumCommentsModel $ForumCommentsModel,
                                ForumLikeDislikeModel $ForumLikeDislikeModel,
                                ForumCommentLikeDislikeModel $ForumCommentLikeDislikeModel,
                                ForumReplyLikeDislikeModel $ForumReplyLikeDislikeModel,
                                UserService $UserService
    						   )
    {
    	$this->ContainerModel = $ContainerModel;
    	$this->BaseModel               = $this->ContainerModel;
        $this->PostModel            = $PostModel;
        $this->ForumCommentsModel   = $ForumCommentsModel;
        $this->ForumLikeDislikeModel = $ForumLikeDislikeModel;
        $this->ForumCommentLikeDislikeModel = $ForumCommentLikeDislikeModel;
        $this->ForumReplyLikeDislikeModel = $ForumReplyLikeDislikeModel;
        $this->UserService        = $UserService;

    	$this->arr_view_data      = [];
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/container");
        $this->container_base_img_path   = base_path().config('app.project.img_path.container');
        $this->container_public_img_path = url('/').config('app.project.img_path.container');
 
        $this->module_title       = "Forum containers";
        $this->module_url_slug    = "container";
        $this->module_view_folder = "admin.container";

    }

    public function index()
    {
    	$arr_category = [];
        $arr_category = $this->BaseModel->get()->toArray();

        $this->arr_view_data['arr_category']     = isset($arr_category)?$arr_category :[];
        $this->arr_view_data['page_title']       = $this->module_title;
        $this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
        $obj_container   = $this->get_container($request);

        $current_context  = $this;

        $json_result      = Datatables::of($obj_container);
 
        $json_result      = $json_result->blacklist(['id']);
        
        $json_result      = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                             ->editColumn('image',function($data) use ($current_context)
                            {
                                if($data->image != "")
                                {
                                   return '<img src="'.$this->container_public_img_path.'/'.$data->image.'" alt="image" class="img-responsive" width="100px" height="100px"/> ';
                                }
                                else
                                {
                                    return "N/A";
                                }
                            })    
                            ->editColumn('title',function($data) use ($current_context)
                            {
                               
                                if($data->title != "")
                                {
                                    return $data->title;
                                }
                                else
                                {
                                    return "N/A";
                                }
                            })

                            ->editColumn('build_status_btn',function($data) use ($current_context)
                            {
                                 $build_status_btn = "";
                                if($data->is_active == '0')
                                {
                                   $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';

                                }
                                else if($data->is_active == '1')
                                {
                                    $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262"/>';
                                }

                                return $build_status_btn;
                            }) 
                           

                            

                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                                $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';
                                $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';

                                return $build_action = $build_edit_action.' '.$build_delete_action;
                            })
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

 
    function get_container(Request $request)
    {
        $categories_table           = $this->BaseModel->getTable();
        $prefixed_categories_table  = DB::getTablePrefix().$this->BaseModel->getTable();
  
        $obj_container             = DB::table($categories_table)
                                            ->select(DB::raw($prefixed_categories_table.".id,".
                                                             $prefixed_categories_table.".is_active,".
                                                         $prefixed_categories_table.".title,".
                                                         $prefixed_categories_table.".image"
                                                    ))

                                            ->whereNull($categories_table.'.deleted_at')
                                            ->orderBy($categories_table.'.id','DESC');
        
        /* ---------------- Filtering Logic ----------------------------------*/

        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_title']) && $arr_search_column['q_title']!="")
        {
            $search_term      = $arr_search_column['q_title'];
            $obj_container   = $obj_container->where($prefixed_categories_table.'.title','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status']!="")
        {
           $search_term       = $arr_search_column['q_status'];
            $obj_container   = $obj_container->where($prefixed_categories_table.'.is_active','LIKE', '%'.$search_term.'%');
        }
    
        return $obj_container;
    }

    public function create()
    {	
    	$this->arr_view_data['page_title']      = "Add ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

    	return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        /* Is Update/ Create Process */
       
        $user = Sentinel::check();

        $form_data         = $request->all();

        $is_update_process = false;
        $id                = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }
         $arr_rules = [];

       /* $arr_rules = [
                       'product_type' => 'required',
                     ];*/
        if($is_update_process == false)
        {
            $arr_rules = [
                            'title' => 'required',
                            'image'     => 'required'

                         ];
        }             

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }

        if($request->hasFile('image'))
        {
             //Validation for product news image
           $file_extension = strtolower($request->file('image')->getClientOriginalExtension());
           if(!in_array($file_extension,['png','jpg','jpeg']))
           {
                $response['status'] ='ImageFAILURE';
                $response['description']='Please select valid image only png,jpg,jpeg images allowed';
                return response()->json($response);
           }
        }
    
        /* Duplication Check */
        $obj_dup_check = $this->BaseModel->where('title',$request->input('title'));
                           
        if($is_update_process)
        {
            $obj_dup_check = $obj_dup_check->where('id','<>',$request->input("id"));
        }

        $does_exists = $obj_dup_check->count();

        if($does_exists)
        {
            $response['status']      = 'warning';
            $response['description'] = str_singular($this->module_title).' already exists.';

            return response()->json($response);
        }

        /* Main Model Entry */
        $container = $this->BaseModel->firstOrNew(['id' => $id]);

        $container->title = ucwords($request->input('title'));

        
            
        if(isset($form_data['is_active']) && !empty($form_data['is_active']))
        {
           $is_active = $form_data['is_active'];
        }
        else
        {
           $is_active = '0';
        }   
        $container->is_active = $is_active;


        $file_name = '';
        if($request->hasFile('image'))
        {   
            $file = $request->file('image');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
            $image1->resize(300,250);
            $image1->save($this->container_base_img_path.'/'.$file_name);

            $unlink_old_img_path    = $this->container_base_img_path.'/'.$request->input('old_img');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_name = $request->input('old_img');
        }
        $container->image  = $file_name;      

        $container->save();

        if($container)
        {

            if($is_update_process == false)
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added forum container '.$container->title.'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

              


               /*----------------------------------------------------------------------*/

               
                $response['link'] = $this->module_url_path;
                $response['status']      = "success";
                $response['description'] = "Forum container added successfully."; 

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
                        $arr_event['action']       = 'EDIT';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated forum container '.$container->title.'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

              


               /*----------------------------------------------------------------------*/

                $response['link'] = $this->module_url_path;
                $response['status']      = "success";
                $response['description'] = "Forum container updated successfully."; 

            }


        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding container.";
        }

        return response()->json($response);
    }

    public function edit($enc_id) 
    {
    	$id   = base64_decode($enc_id);
        $arr_container = [];
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
        if($obj_data)
        {
           $arr_container = $obj_data->toArray(); 
        }

        $this->arr_view_data['container_public_img_path']     = $this->container_public_img_path;
        $this->arr_view_data['edit_mode']       = TRUE;
        $this->arr_view_data['enc_id']          = $enc_id;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_container']    = isset($arr_container)?$arr_container :[];  
        $this->arr_view_data['page_title']      = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = $this->module_title;

        return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

    public function multi_action(Request $request)
    {
        $user = Sentinel::check();
        $flag = "";

        /*Check Validations*/
        $input = request()->validate([
                                        'multi_action'   => 'required',
                                        'checked_record' => 'required'
                                    ], 
                                    [
                                        'multi_action.required'   => 'Please  select record required',
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
               $flag = "active";
            
               $this->perform_activate(base64_decode($record_id),$flag); 
               Flash::success(str_plural($this->module_title).' activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
                $flag = "deactive";
          
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on forum container.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

               /*----------------------------------------------------------------------*/
        }

        if($multi_action=="activate")
        {
            /*---------------  ----------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
          
            //save sub admin activity log 

            if(isset($user) && $user->inRole('sub_admin'))
            {
                $arr_event                 = [];
                $arr_event['action']       = 'ACTIVATE';
                $arr_event['title']        = $this->module_title;
                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on forum container.';

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on forum container.';

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

        $arr_response = [];    
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

    public function deactivate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        $arr_response = []; 
        
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

    public function delete($enc_id = FALSE)
    {
        
        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {
           Flash::success(str_singular($this->module_title).' deleted successfully.');
        }
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }
 
    public function perform_activate($id)
    {
        $user = Sentinel::check();
        $container = $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);

        $entity = $this->BaseModel->where('id',$id)->first();

        /********************code added to activate the subcategory and product**********/
       /* if($category)
        {
            $get_subcategoryes = $this->SecondLevelCategoryModel->where('first_level_category_id',$id)->get();
            if(!empty($get_subcategoryes))
            {
                $get_subcategoryes = $get_subcategoryes->toArray();
                if(!empty($get_subcategoryes))
                {
                    foreach($get_subcategoryes as $v)
                    {
                       $subcategory = $v['id'];
                       $update_subcat =  $this->SecondLevelCategoryModel->where('first_level_category_id',$id)->update(['is_active'=>'1']);


                         $get_products = $this->ProductModel
                                        ->where('first_level_category_id',$id)
                                        ->where('second_level_category_id',$subcategory)
                                        ->get()->toArray();
                          if(!empty($get_products)){

                                 foreach($get_products as $product)
                                 {

                                     $update_products = $this->ProductModel
                                        ->where('first_level_category_id',$id)
                                        ->where('second_level_category_id',$subcategory)
                                        ->update(['is_active'=>'1']);

                                 }
                          }            
                    } 
                }
            }
              return TRUE;
        }
       else{
         return FALSE;
       }*/
        /***********************end of code***************************/

        if($container)
        { 
            $entity_arr = $entity->toArray();

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated forum container '.$entity_arr['title'].'.';

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

    public function perform_featured($id)
    {
        $user = Sentinel::check();
        $category = $this->BaseModel->where('id',$id)->update(['is_featured'=>'1']);
       
        $entity = $this->BaseModel->where('id',$id)->first();

        if($category)
        {
            $entity_arr = $entity->toArray();

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has featured forum container '.$entity_arr['title'].'.';

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

    public function perform_deactivate($id,$flag=false)
    {   
        $user = Sentinel::check();

        $container     = $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

        $entity = $this->BaseModel->where('id',$id)->first();

        if($container)
        {
            $entity_arr = $entity->toArray();

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated forum container '.$entity_arr['title'].'.';

                $result = $this->UserService->save_activity($arr_event); 
            }

            /*----------------------------------------------------------------------*/
              
          return TRUE;  
        }//if container
        else
         {
            return FALSE;
         }   
     
    } 
     
    public function perform_unfeatured($id)
    {
        $user = Sentinel::check();

        $category  = $this->BaseModel->where('id',$id)->update(['is_featured'=>'0']);

        $entity = $this->BaseModel->where('id',$id)->first();

        if($category)
        {
            $entity_arr = $entity->toArray();

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'UNFEATURED';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has unfeatured forum container '.$entity_arr['title'].'.';

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

    public function perform_delete($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity           = $this->BaseModel->where('id',$id)->first();
        if($entity)
        {
            $entity_arr = $entity->toArray();


            $this->BaseModel->where('id',$id)->delete();
            $this->PostModel->where('container_id',$id)->delete();
            $this->ForumCommentsModel->where('container_id',$id)->delete();
            $this->ForumLikeDislikeModel->where('container_id',$id)->delete();
            $this->ForumCommentLikeDislikeModel->where('container_id',$id)->delete();
            $this->ForumReplyLikeDislikeModel->where('container_id',$id)->delete();
            
             $unlink_old_img_path    = $this->container_base_img_path.'/'.$entity->image;
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }

           
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted forum container '.$entity_arr['title'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }



                /*----------------------------------------------------------------------*/

            }

            

          
            return true;
        }
       
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
            return false;
        }
    }
}
