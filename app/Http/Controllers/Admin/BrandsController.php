<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

use App\Models\BrandModel;
use App\Models\ProductModel;
use App\Common\Services\UserService;
use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;


 
class BrandsController extends Controller
{       
    use MultiActionTrait;

    public function __construct(BrandModel $BrandModel,
                                ProductModel $ProductModel,
                                UserService $UserService
                               ) 
    {
    	$this->BaseModel          = $BrandModel;
        $this->ProductModel       = $ProductModel;  
        $this->UserService        = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->brand_base_img_path   = base_path().config('app.project.img_path.brands');
        $this->brand_public_img_path = url('/').config('app.project.img_path.brands');

        $this->module_title       = "Brands";
        $this->module_view_folder = "admin.brands";
        $this->module_url_path    = $this->admin_url_path."/brands";
    }


    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$product_brand_table          = $this->BaseModel->getTable();
        $prefixed_productbrand_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_brand_table = DB::table($product_brand_table)                           
        							 ->orderBy($product_brand_table.'.created_at','DESC');

        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');    
  
           if(isset($arr_search_column['q_name']) && $arr_search_column['q_name'] != '')
            {
                $search_name            = $arr_search_column['q_name'];
                $obj_brand_table        = $obj_brand_table->where('name','LIKE','%'.$search_name.'%');
            }

          	
            if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
            {
                $search_term            = $arr_search_column['q_status'];
                $obj_brand_table        = $obj_brand_table->where('is_active','LIKE','%'.$search_term.'%');
            }

            if(isset($arr_search_column['q_featured']) && $arr_search_column['q_featured'] != '')
            {
                $search_term_featured   = $arr_search_column['q_featured'];
                $obj_brand_table        = $obj_brand_table->where('is_featured','LIKE','%'.$search_term_featured.'%');
            }




    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_brand_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })
                        ->editColumn('image',function($data) use ($current_context)
                        {
                            if($data->image != "")
                            {
                               return '<img src="'.$this->brand_public_img_path.'/'.$data->image.'" alt="image" class="img-responsive" width="100px" height="100px"/> ';
                            }
                            else
                            {
                                return "N/A";
                            }
                        })
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

                            $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                            $confirm_delete = 'onclick="confirm_delete(this,event);"';

                            $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                            
                            
                            return $build_action = $build_edit_action.' '.$build_delete_action;
                        })

                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }


    public function create()
    {
    	$this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$form_data = $request->all();
    
        $is_update_process = false;

        $user = Sentinel::check();

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
        if($is_update_process == false)
        {
        	$arr_rules = [
                            'image'     => 'required',
                            'name'     => 'required',

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
    	
        
        /* Main Model Entry */
        $brands = $this->BaseModel->firstOrNew(['id' => $id]);

        $brands->name      =  isset($form_data['name'])?$form_data['name']:'';
        $brands->description      =  isset($form_data['description'])?$form_data['description']:'';

        if($request->is_active!='' && !empty($request->is_active)){
          $is_active  =  isset($form_data['is_active'])?$form_data['is_active']:'';  
        }else{
            $is_active =0;
        }

         if(isset($request->is_featured) && !empty($request->is_featured))
        {
           $is_featured = $request->is_featured;
        }
        else
        {
           $is_featured = '0';
        }   


         $brands->is_active = $is_active;
         $brands->is_featured = $is_featured;


        $file_name = '';
        if($request->hasFile('image'))
        {	
        	$file = $request->file('image');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
            $image1->resize(346,268);
            $image1->save($this->brand_base_img_path.'/'.$file_name);

            $unlink_old_img_path    = $this->brand_base_img_path.'/'.$request->input('old_img');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_name = $request->input('old_img');
        }

        $brands->image  = $file_name;      

        $brands->save();

        if($brands)
        {

           
  
            if($is_update_process == false)
            {
                /*if($product_news->id)
                {
                    $response['link'] =$this->module_url_path.'/edit/'.base64_encode($product_news->id);
                }*/
                $response['link'] = $this->module_url_path;

            }
            else
            {
                $response['link'] = $this->module_url_path.'/edit/'.base64_encode($id);
            }

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added brand '.$brands->name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['status']      = "success";
                $response['description'] = "Brands added successfully."; 


            }else
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated brand '.$brands->name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['status']      = "success";
                $response['description'] = "Brands updated successfully."; 
            }

          
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding brand.";
        }

        return response()->json($response);
    }

    public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_brands = [];
        if($obj_data)
        {
           $arr_brands = $obj_data->toArray(); 
        }
    
      	$this->arr_view_data['brand_public_img_path']     = $this->brand_public_img_path;
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_brands']   		     = isset($arr_brands) ? $arr_brands : [];  
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on brands.';

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on brands.';

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on brands.';

                        $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
        }


        return redirect()->back();
    }

    public function delete($enc_id = FALSE)
    {
        
        
        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {
           
            Flash::success(str_singular($this->module_title).' deleted Successfully');
        }
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }//single delete

    public function perform_delete($id,$flag = false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();

        if($entity)
        {
            $entity_arr = $entity->toArray();

            $unlink_old_img_path    = $this->brand_base_img_path.'/'.$entity->image;
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }

            $this->BaseModel->where('id',$id)->delete();

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted brand '.$entity_arr['name'].'.';

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
    }//delete function


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
            $arr_response['msg']   = 'Sorry, you can not deactivate this brand,this brand is having some products.';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }

    public function perform_activate($id,$flag = false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();
        
        if($entity)
        {
            $entity_arr = $entity->toArray();

            if($flag == false)
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated brand '.$entity_arr['name'].'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }


                /*----------------------------------------------------------------------*/  
            }
        
            return $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        } 

        return FALSE;
    }//activate

 
    public function perform_deactivate($id,$flag = false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();

        if($entity)
        {
            $entity_arr = $entity->toArray();

            $get_product = $this->ProductModel->where('brand',$id)->get();

            if(isset($get_product) && !empty($get_product))
            {
                $get_product = $get_product->toArray();

                if(isset($get_product) && !empty($get_product)){
                   return false;
                }
                else
                {
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
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated brand '.$entity_arr['name'].'.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }

                        /*----------------------------------------------------------------------*/
                    }
                 
                    return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);
                    
                }
            }



        }
        return FALSE;
    }//deactivate

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
                    $arr_event['action']       = 'Featured';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has featured brand '.$entity_arr['name'].'.';

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
        $user       = Sentinel::check();
        $category   = $this->BaseModel->where('id',$id)->update(['is_featured'=>'0']);

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
                    $arr_event['action']       = 'Unfeatured';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has unfeatured brand '.$entity_arr['name'].'.';

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


}
