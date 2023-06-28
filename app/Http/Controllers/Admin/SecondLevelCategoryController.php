<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FirstLevelCategoryModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\UnitModel;
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

class SecondLevelCategoryController extends Controller
{
    use MultiActionTrait;

	public function __construct(
    							             FirstLevelCategoryModel $FirstLevelCategoryModel,
    							             SecondLevelCategoryModel $SecondLevelCategoryModel,
                               UnitModel $UnitModel,
                               ProductModel $ProductModel,
                               UserService $UserService
    						   )
    {
    	$this->FirstLevelCategoryModel  = $FirstLevelCategoryModel;
    	$this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
    	$this->BaseModel                = $this->SecondLevelCategoryModel;
      $this->UserService              = $UserService;
      $this->ProductModel             = $ProductModel;

      $this->UnitModel                = $UnitModel;

    	$this->category_base_img_path   = base_path().config('app.project.img_path.categories');
      $this->category_public_img_path = url('/').config('app.project.img_path.categories');

    	$this->arr_view_data      = [];
      $this->module_url_path    = url(config('app.project.admin_panel_slug')."/second_level_categories");
      $this->module_title       = "Sub Category";
      $this->module_url_slug    = "sub_categories";
      $this->module_view_folder = "admin.second_level_category";
    }

    public function index()
    {
    	$arr_category = [];

    	$arr_category  = $this->FirstLevelCategoryModel->get()->toArray();

        $this->arr_view_data['arr_category']      = isset($arr_category) ? $arr_category :[];
        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$obj_second_level_categories = $this->get_second_level_category($request);
     

        $current_context = $this;

        $json_result = Datatables::of($obj_second_level_categories);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)

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
                      
                        ->editColumn('name',function($data) use ($current_context)
                       
                        {
                       	   if($data->name != "")
                       	   {
                              return $data->name;
                       	   }
                       	   else
                       	   {
                              return "N/A";
                       	   }
                       	
                        })

                        ->editColumn('unit',function($data) use ($current_context)
                       
                        {
                           if($data->unit != "")
                           {
                              return $data->unit;
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
                              elseif($data->is_active == '1')
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
                            
                            
                            return $build_action = $build_edit_action;
                        })

                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);

    }

    public function get_second_level_category(Request $request)
    {   
        $category_id = $request->input('category_id'); 

    	  $second_level_categories_table          = $this->BaseModel->getTable();
        $prefixed_second_level_categories_table = DB::getTablePrefix().$this->BaseModel->getTable();

        $unit_table          = $this->UnitModel->getTable();
        $prefixed_unit_table = DB::getTablePrefix().$this->UnitModel->getTable();

        $categories_table            = $this->FirstLevelCategoryModel->getTable();
        $prefixed_categories_table   = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

        $obj_second_level_categories = DB::table($second_level_categories_table)
                                        ->select(DB::raw(
                                                $prefixed_second_level_categories_table.'.id,'.
                                                $prefixed_second_level_categories_table.'.first_level_category_id,'.
                                                $prefixed_second_level_categories_table.'.	is_active,'.
                                                $prefixed_second_level_categories_table.'.name,'.
                                                $prefixed_unit_table.'.unit,'.

                                                 //$prefixed_categories_table.'.id as sec_id,'.
                                                $prefixed_categories_table.'.product_type'
    
                                            ))
                                        ->leftjoin($prefixed_categories_table,$prefixed_second_level_categories_table.'.first_level_category_id','=',$prefixed_categories_table.'.id')

                                        ->leftjoin($prefixed_unit_table,$prefixed_unit_table.'.id','=',$prefixed_second_level_categories_table.'.unit_id')

                                        ->whereNull($second_level_categories_table.'.deleted_at')
                                      
                                        ->orderBy($second_level_categories_table.'.created_at','DESC');
                                        

            if(isset($category_id) && $category_id !='')
            {
                $obj_second_level_categories =  $obj_second_level_categories->where($prefixed_categories_table.'.id',$category_id);
            }  

        /* ---------------- Filtering Logic ----------------------------------*/
        
          $arr_search_column = $request->input('column_filter');

          if(isset($arr_search_column['q_category']) && $arr_search_column['q_category'] != '')
          {
              $search_term  = $arr_search_column['q_category'];
              $obj_second_level_categories  = $obj_second_level_categories->where('product_type','LIKE', '%'.$search_term.'%');

          }

          if(isset($arr_search_column['q_sec_level_category']) && $arr_search_column['q_sec_level_category'] != '')
          {
             $search_term = $arr_search_column['q_sec_level_category'];
             $obj_second_level_categories = $obj_second_level_categories->where('name','LIKE','%'.$search_term.'%');
          }

          if(isset($arr_search_column['q_unit']) && $arr_search_column['q_unit']!="")
          {
             $search_term      = $arr_search_column['q_unit'];
            
             $obj_second_level_categories  = $obj_second_level_categories->where($prefixed_unit_table.'.unit','LIKE', '%'.$search_term.'%');
          }

          if(isset($arr_search_column['q_status']) && $arr_search_column['q_status']!="")
          {
             $search_term      = $arr_search_column['q_status'];
             $obj_second_level_categories  = $obj_second_level_categories->where($prefixed_second_level_categories_table.'.is_active','LIKE', '%'.$search_term.'%');
          }

        /* --------------------------------------------------------------------*/
         return  $obj_second_level_categories;                             
    }

    public function create()
    {
        /* get product type records*/
        $arr_category  = $arr_unit = [];
        $arr_category  = $this->FirstLevelCategoryModel->where('is_active','1')
        											   ->get()
        											   ->toArray(); 

        $arr_unit = $this->UnitModel->get()->toArray();

        $this->arr_view_data['page_title']      = "Create ".$this->module_title;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_category']    = isset($arr_category) ?$arr_category:[];
        $this->arr_view_data['arr_unit']        = isset($arr_unit)?$arr_unit:[];
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $user = Sentinel::check();

       	$form_data = $request->all();

        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [
                       'product_type'    => 'required',
                       'name'            => 'required'
                     ];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
    	
        /* Duplication Check */
        $obj_dup_check = $this->BaseModel->where('name',$request->input('name'));
                           
        if($is_update_process)
        {
            $obj_dup_check = $obj_dup_check->where('id','<>',$request->input("id"));
        }

        $does_exists = $obj_dup_check->count();

        if($does_exists)
        {
            $response['status']      = 'warning';
            $response['description'] = 'Sub category already exists.';

            return response()->json($response);
        }

        /* Main Model Entry */
        $sec_level_category = $this->BaseModel->firstOrNew(['id' => $id]);
        $sec_level_category->name                    = ucwords($request->input('name'));       
        $sec_level_category->first_level_category_id = $request->input('product_type');
        $sec_level_category->unit_id                 = 1;
        
    
        if($is_update_process == false)
        {
           $sec_level_category->slug = str_slug($request->input('name'),"_"); 
        }
        
        if(isset($form_data['category_status']) && !empty($form_data['category_status']))
        {
           $category_status = $form_data['category_status'];
        }
        else
        {
           $category_status = '0';
        }
    
        $sec_level_category->is_active = $category_status;
        
      
        $sec_level_category->save();

        if($sec_level_category)
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
                /*if($sec_level_category->id)
                {
                    $response['link'] =$this->module_url_path.'/edit/'.base64_encode($sec_level_category->id);

                }*/
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
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added second level category '.$sec_level_category->name.'.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }

                  /*----------------------------------------------------------------------*/

                 $response['link']        = $this->module_url_path;
                 $response['status']      = "success";
                 $response['description'] = "Subcategory saved successfully."; 

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
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated second level category '.$sec_level_category->name.'.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }

                /*----------------------------------------------------------------------*/

                $response['link']        = $this->module_url_path.'/edit/'.base64_encode($id);
                $response['status']      = "success";
                $response['description'] = "Subcategory updated successfully."; 
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
        /* get category*/
        $arr_category = $arr_unit = [];
        $arr_category = $this->FirstLevelCategoryModel->where('is_active','1')
      												->get()
      												->toArray();

        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_sec_level_category = [];
        if($obj_data)
        {
           $arr_sec_level_category = $obj_data->toArray(); 
        }

        $arr_unit = $this->UnitModel->get()->toArray();
    
      	$this->arr_view_data['category_public_img_path'] = $this->category_public_img_path;
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_sec_level_category']   = isset($arr_sec_level_category) ? $arr_sec_level_category : [];  
      	$this->arr_view_data['page_title']               = "Edit ".$this->module_title;
      	$this->arr_view_data['arr_category']             = isset($arr_category)?$arr_category :[];
        $this->arr_view_data['arr_unit']                 = isset($arr_unit)?$arr_unit:[];
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
            Flash::error('Problem Occurred, While Doing Multi Action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
                $flag = "del";

                $this->perform_delete(base64_decode($record_id),$flag);    
                Flash::success(ucfirst(strtolower($this->module_title)).' deleted Successfully'); 
            } 
            elseif($multi_action=="activate")
            {  
                $flag = "activate";

               

               $this->perform_activate(base64_decode($record_id),$flag); 
               Flash::success(ucfirst(strtolower($this->module_title)).' activated Successfully'); 
            }
            elseif($multi_action=="deactivate")
            {  
                
                $flag = "deactivate";

               $this->perform_deactivate(base64_decode($record_id),$flag);    
               Flash::success(ucfirst(strtolower($this->module_title)).' blocked Successfully');  
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on second level category.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on second level category.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on second level category.';

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
            $arr_response['msg']   = 'Please activate the category of this product';
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
            $arr_response['msg']   = 'Please activate the category of this product';
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

       // $category = $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        $get_firstcategory_id = $this->BaseModel->select('first_level_category_id')->where('id',$id)->get()->toArray();


           if(!empty($get_firstcategory_id))
           {
               $firstcatgory = $get_firstcategory_id[0]['first_level_category_id'];
               $check_firstcat_active = $this->FirstLevelCategoryModel
                                        ->where('id',$firstcatgory)
                                        ->where('is_active',1)
                                        ->get()->toArray();


                 if(empty($check_firstcat_active))
                 {
                      return false;
                 }else
                 {
                    $category = $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);

                    $entity =  $this->BaseModel->where('id',$id)->first();

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
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated second level category '.$entity_arr['name'].'.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }

                        /*----------------------------------------------------------------------*/
                    }
                  

                    return TRUE;   
                 }
           }




        /**********code for deactivate the products under this subcatogry*****/
          /*$get_firstcategory_id = $this->BaseModel->select('first_level_category_id')->where('id',$id)->get()->toArray();
           if(!empty($get_firstcategory_id))
           {
               $firstcatgory = $get_firstcategory_id[0]['first_level_category_id'];
               $check_firstcat_active = $this->FirstLevelCategoryModel
                                        ->where('id',$firstcatgory)
                                        ->where('is_active',1)
                                        ->get()->toArray();


                 if(empty($check_firstcat_active))
                 {
                      return false;
                 }else
                 {
                  
                     $category = $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);

                     $get_products = $this->ProductModel
                                        ->where('second_level_category_id',$id)
                                        ->get()->toArray();
                       if(!empty($get_products))
                       {
                         foreach($get_products as $product)
                         {

                             $update_products = $this->ProductModel                      
                                ->where('second_level_category_id',$id)
                                ->update(['is_active'=>'1']);

                         }
                       } 
                       return TRUE;                                     
                 }                     
           }*/


        /*******************************************************/

       /* if($category)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }*/
    }
 
  	public function perform_deactivate($id,$flag=false)
  	{
       $user = Sentinel::check();

      //	 $category = $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);
        /**********code for deactivate the products under this subcatogry*****/
          $get_firstcategory_id = $this->BaseModel->select('first_level_category_id')->where('id',$id)->get()->toArray();
           if(!empty($get_firstcategory_id))
           {
               $firstcatgory = $get_firstcategory_id[0]['first_level_category_id'];
               $check_firstcat_active = $this->FirstLevelCategoryModel
                                        ->where('id',$firstcatgory)
                                        ->where('is_active',1)
                                        ->get()->toArray();


                 if(empty($check_firstcat_active))
                 {
                     // Flash::error('You can not deactivate this category first activate the first level category');
                      return false;
                 }else
                 {
                     $category = $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

                     $entity =  $this->BaseModel->where('id',$id)->first();

                     $entity_arr = $entity->toArray();


                     $get_products = $this->ProductModel
                                        ->where('second_level_category_id',$id)
                                        ->get()->toArray();
                       if(!empty($get_products))
                       {
                         foreach($get_products as $product)
                         {

                             $update_products = $this->ProductModel                      
                                ->where('second_level_category_id',$id)
                                ->update(['is_active'=>'0']);

                         }//foreach product
                       } // not empty product 


                    if($flag == false)
                    {
                        /*-------------------------------------------------------
                      |   Activity log Event
                      --------------------------------------------------------*/
                        
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'DEACTIVE';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated second level category '.$entity_arr['name'].'.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }

                      /*----------------------------------------------------------------------*/
                    }
                      

                       return TRUE;                                   
                 }//else                       
           }


       
      	/*if($category)
      	{	
          	return TRUE;
      	}
      	else
      	{
         	return FALSE;
      	}*/
  	}


  	public function perform_delete($id,$flag = false)
  	{
        $user = Sentinel::check();

      	$entity  = $this->SecondLevelCategoryModel->where('id',$id)->first();

        $entity =  $this->BaseModel->where('id',$id)->first();

        
      	// $sec_lev_cat  = $this->ThirdLevelCategoryModel->where('second_level_category_id',$id)->count()<=0;
       
        // if($entity && $sec_lev_cat)
        if($entity)
        {
            $entity_arr = $entity->toArray();

            $this->SecondLevelCategoryModel->where('id',$id)->delete();


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
                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted second level category '.$entity_arr['name'].'.';

                  $result = $this->UserService->save_activity($arr_event); 
              }

            /*----------------------------------------------------------------------*/
          }

             


              Flash::success(str_plural($this->module_title).' deleted successfully');
              return true; 
        }
        /*elseif($sec_lev_cat ==false)
        {
          Flash::error('You need to delete third level of categories first');
          return false;
        }*/
        else
        {
          Flash::error('Problem occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }
}
