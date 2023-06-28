<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FirstLevelCategoryModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\ProductModel;
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

class FirstLevelCategoryController extends Controller
{	
	use MultiActionTrait;

    public function __construct(
    							FirstLevelCategoryModel $FirstLevelCategoryModel,
                                SecondLevelCategoryModel $SecondLevelCategoryModel,
                                ProductModel $ProductModel,
                                UserService $UserService
    						   )
    {
    	$this->FirstLevelCategoryModel = $FirstLevelCategoryModel;
    	$this->BaseModel               = $this->FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
        $this->ProductModel            = $ProductModel;
        $this->UserService             = $UserService;

    	$this->arr_view_data      = [];
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/first_level_categories");
        $this->cat_base_img_path   = base_path().config('app.project.img_path.first_category');
        $this->cat_public_img_path = url('/').config('app.project.img_path.first_category');

        
        $this->module_title       = "Category";
        $this->module_url_slug    = "first_level_categories";
        $this->module_view_folder = "admin.first_level_category";
    }

    public function index()
    {
    	$arr_category = [];
        $arr_category = $this->BaseModel->get()->toArray();

        $this->arr_view_data['arr_category']     = isset($arr_category)?$arr_category :[];
        $this->arr_view_data['page_title']       = "Manage ".$this->module_title;
        $this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
        $obj_categories   = $this->get_first_level_categories($request);

        $current_context  = $this;

        $json_result      = Datatables::of($obj_categories);
 
        $json_result      = $json_result->blacklist(['id']);
        
        $json_result      = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })

                            ->editColumn('product_type',function($data) use ($current_context)
                            {
                               
                                if($data->product_type != "")
                                {
                                    return $data->product_type;
                                }
                                else
                                {
                                    return "N/A";
                                }
                            })
                            ->editColumn('description',function($data) use ($current_context)
                            {
                               
                                if($data->description != "")
                                {
                                    return $data->description;
                                }
                                else
                                {
                                    return "N/A";
                                }
                            })
                            ->editColumn('is_age_limit',function($data) use ($current_context)
                            {
                               
                                if($data->is_age_limit == "1")
                                {
                                    return 'Yes';
                                }
                                else
                                {
                                    return "No";
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
                                $faq_href =  $this->module_url_path."/".base64_encode($data->id).'/faqs';
                                $build_faq_action = '<a class="eye-actn" href="'.$faq_href.'" title="View FAQ\'s">FAQ\'s</a>';

                                $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                                $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';

                                $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';


                                $product_detail_href =  $this->module_url_path."/".base64_encode($data->id).'/product_details';
                                $build_product_detail_action = '<a class="eye-actn" href="'.$product_detail_href.'" title="Product Detail View">Product Details View</a>';


                                return $build_action = $build_edit_action." ".$build_faq_action." ".$build_product_detail_action;
                            })
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

 
    function get_first_level_categories(Request $request)
    {
        $categories_table           = $this->BaseModel->getTable();
        $prefixed_categories_table  = DB::getTablePrefix().$this->BaseModel->getTable();
  
        $obj_categories             = DB::table($categories_table)
                                            ->select(DB::raw($prefixed_categories_table.".id,".
                                                             $prefixed_categories_table.".is_active,".
                                                         $prefixed_categories_table.".product_type,".
                                                         $prefixed_categories_table.".description,".
                                                         $prefixed_categories_table.".is_age_limit,".

                                                         $prefixed_categories_table.".is_featured"
                                                    ))

                                            ->whereNull($categories_table.'.deleted_at')
                                            ->orderBy($categories_table.'.created_at','DESC');
        
        /* ---------------- Filtering Logic ----------------------------------*/

        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_product_type']) && $arr_search_column['q_product_type']!="")
        {
            $search_term      = $arr_search_column['q_product_type'];
            $obj_categories   = $obj_categories->where($prefixed_categories_table.'.product_type','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status']!="")
        {
           $search_term       = $arr_search_column['q_status'];
            $obj_categories   = $obj_categories->where($prefixed_categories_table.'.is_active','LIKE', '%'.$search_term.'%');
        }
        if(isset($arr_search_column['q_featured']) && $arr_search_column['q_featured']!="")
        {
           $search_featured       = $arr_search_column['q_featured'];
           $obj_categories   = $obj_categories->where($prefixed_categories_table.'.is_featured','LIKE', '%'.$search_featured.'%');
        }
         if(isset($arr_search_column['q_is_age_limit']) && $arr_search_column['q_is_age_limit']!="")
        {
           $search_isagelimit       = $arr_search_column['q_is_age_limit'];
            $obj_categories   = $obj_categories->where($prefixed_categories_table.'.is_age_limit','LIKE', '%'.$search_isagelimit.'%');
        }




        return $obj_categories;
    }

    public function create()
    {	
    	$this->arr_view_data['page_title']      = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_singular($this->module_title);
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
                            'image' => 'required',
                            'is_age_limit'=>'required'

                         ];
        }             

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
    
        /* Duplication Check */
        $obj_dup_check = $this->BaseModel->where('product_type',$request->input('product_type'));
                           
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
        $category = $this->BaseModel->firstOrNew(['id' => $id]);

        $category->product_type = ucwords($request->input('product_type'));
        $category->description  = isset($form_data['description'])?$form_data['description']:'';

        if($is_update_process == false)
        {
        	$category->slug = str_slug($request->input('product_type'),"_"); 
        }
            
        if(isset($form_data['product_type_status']) && !empty($form_data['product_type_status']))
        {
           $product_type_status = $form_data['product_type_status'];
        }
        else
        {
           $product_type_status = '0';
        }   

         if(isset($form_data['is_featured']) && !empty($form_data['is_featured']))
        {
           $is_featured = $form_data['is_featured'];
        }
        else
        {
           $is_featured = '0';
        }   

        if ($request->hasFile('image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }


         $file_name = '';
        if($request->hasFile('image'))
        {   
            $file = $request->file('image');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
            $image1->resize(190,190);
            $image1->save($this->cat_base_img_path.$file_name);

            $unlink_old_img_path    = $this->cat_base_img_path.'/'.$request->input('old_img');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_name = $request->input('old_img');
        }


        $is_age_limit      = isset($form_data['is_age_limit'])?$form_data['is_age_limit']:'';
         if($is_age_limit=='1')
        {
            $category->age_restriction = '2';
        }else{
            $category->age_restriction ='';
        }

        $category->is_age_limit  = $is_age_limit;    
        $category->image  = $file_name;        
        $category->is_active = $product_type_status;
        $category->is_featured = $is_featured;

        $category->save();

        if($category)
        {
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
            /*if($is_update_process == true)
            {
                $arr_event                 = [];
                $arr_event['ACTION']       = 'EDIT';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);
            }
            elseif ($is_update_process != true) 
            {
                $arr_event                 = [];
                $arr_event['ACTION']       = 'ADD';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);
            }*/
            
           /*----------------------------------------------------------------------*/

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added category '.$category->product_type.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }
  
                /*----------------------------------------------------------------------*/

                $response['link']        = $this->module_url_path;
                $response['status']      = "success";
                $response['description'] = "Category saved successfully."; 

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated category '.$category->product_type.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['link']        = $this->module_url_path;
                $response['status']      = "success";
                $response['description'] = "Category updated successfully."; 

            }


        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding category.";
        }

        return response()->json($response);
    }

    public function edit($enc_id) 
    {
    	$id   = base64_decode($enc_id);
        $arr_category = [];
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
        if($obj_data)
        {
           $arr_category = $obj_data->toArray(); 
        }
        $this->arr_view_data['cat_public_img_path']   = $this->cat_public_img_path;
        $this->arr_view_data['edit_mode']       = TRUE;
        $this->arr_view_data['enc_id']          = $enc_id;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_category']    = isset($arr_category)?$arr_category :[];  
        $this->arr_view_data['page_title']      = "Edit ".$this->module_title;
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
                $flag= "del";

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on categories.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on categories.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on categories.';

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

            Flash::success(str_singular($this->module_title).' deleted successfully');
        }
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }
 
    public function perform_activate($id,$flag=false)
    {
        $user = Sentinel::check();

        $category = $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);

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

        if($category)
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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated category '.$entity_arr['product_type'].'.';

                $result = $this->UserService->save_activity($arr_event); 
            }

    
            /*----------------------------------------------------------------------*/
        }
           
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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has featured category '.$entity_arr['product_type'].'.';

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

        $category     = $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

        $entity = $this->BaseModel->where('id',$id)->first();

        /********************code added to deactivate the subcategory and product************************/

        if($category)
        {
            $entity_arr = $entity->toArray();

            $get_subcategoryes = $this->SecondLevelCategoryModel->where('first_level_category_id',$id)->get();
            if(!empty($get_subcategoryes)) 
            {
                $get_subcategoryes = $get_subcategoryes->toArray();
                if(!empty($get_subcategoryes))
                {
                    foreach($get_subcategoryes as $v)
                    {
                       $subcategory = $v['id'];
                       $update_subcat =  $this->SecondLevelCategoryModel->where('first_level_category_id',$id)->update(['is_active'=>'0']);


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
                                        ->update(['is_active'=>'0']);

                                 }//foreach product
                          } // not empty product              
                    } //foeach subcat
                }//if not empty subcat
            }//if not empty subcat
              

        if($flag == false)
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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated category '.$entity_arr['product_type'].'.';

                $result = $this->UserService->save_activity($arr_event); 
            }

    
            /*----------------------------------------------------------------------*/
        }      
            
              
            return TRUE;  
        }//if category
        else
        {
            return FALSE;
        }   

        /*******************end of code*********************************/
        /*if($category)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }*/
    } 
     
    public function perform_unfeatured($id)
    {
        $user         = Sentinel::check();
        $category     = $this->BaseModel->where('id',$id)->update(['is_featured'=>'0']);

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has unfeatured category '.$entity_arr['product_type'].'.';

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

        $entity  = $this->BaseModel->where('id',$id)->first();
        // $sec_lev_category = $this->SecondLevelCategoryModel->where('category_id',$id)->count()<=0;
        // if($entity && $sec_lev_category)
        if($entity)
        {
            $entity_arr = $entity->toArray();

            $this->BaseModel->where('id',$id)->delete();
            
            if($flag==false)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted category '.$entity_arr['product_type'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

        
                /*----------------------------------------------------------------------*/
                
            }    
           
            return true;
        }
        /*elseif($sec_lev_category==false)
        {
            Flash::error('You need to delete second level of categories first');
            return false;
        }*/
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
            return false;
        }
    }
}
