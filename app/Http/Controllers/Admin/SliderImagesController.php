<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SliderImagesModel;

use App\Common\Traits\MultiActionTrait;
use App\Common\Services\UserService;

use Validator;
use Image;
use DB;  
use Datatables; 
use Flash;
use Sentinel;

class SliderImagesController extends Controller
{       
    use MultiActionTrait;

    public function __construct(SliderImagesModel $SliderImagesModel,
                                UserService $UserService
                               ) 
    {
    	$this->BaseModel          = $SliderImagesModel;
        $this->UserService        = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->slider_base_img_path   = base_path().config('app.project.img_path.slider_images');
        $this->slider_public_img_path = url('/').config('app.project.img_path.slider_images');

        $this->module_title       = "Slider Images";
        $this->module_view_folder = "admin.slider_images";
        $this->module_url_path    = $this->admin_url_path."/slider_images";
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
    	$slider_image_table           = $this->BaseModel->getTable();
        $prefixed_slider_image_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_slider_image_table = DB::table($slider_image_table)                           
        							 ->orderBy($slider_image_table.'.created_at','DESC');

        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');        

          	if(isset($arr_search_column['q_image_url']) && $arr_search_column['q_image_url'] != '')
          	{
             	$search_term            = $arr_search_column['q_image_url'];
             	$obj_slider_image_table = $obj_slider_image_table->where('image_url','LIKE','%'.$search_term.'%');
          	}
    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_slider_image_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })
                        ->editColumn('slider_image',function($data) use ($current_context)
                        {
                            if($data->slider_image != "")
                            {
                               return '<img src="'.$this->slider_public_img_path.'/'.$data->slider_image.'" alt="image" class="img-responsive" width="50%" height="50%"/> ';
                            }
                            else
                            {
                                return "N/A";
                            }
                        })
                        ->editColumn('image_url',function($data) use ($current_context)

                        {
                          	if($data->image_url != "")
                          	{
	                          	return $data->image_url;
                          	}
                         	else
                          	{
                          	 	return "N/A";
                          	}
                        })
                         ->editColumn('slider_button',function($data) use ($current_context)

                        {
                            if($data->slider_button != "")
                            {
                                return $data->slider_button;
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
        $user = Sentinel::check();  


        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
        if($is_update_process == false)
        {
        	$arr_rules = [
                            'slider_image' => 'required',
                            'slider_medium' => 'required',
                            'slider_small' => 'required'

                         ];
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
           
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }

        if ($request->hasFile('slider_image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('slider_image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }

        if ($request->hasFile('slider_medium')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('slider_medium')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_medium';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }

         if ($request->hasFile('slider_small')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('slider_small')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_small';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }

 
    	
        
        /* Main Model Entry */
        $slider_image = $this->BaseModel->firstOrNew(['id' => $id]);

        $slider_image->image_url  = isset($form_data['image_url'])?$form_data['image_url']:'';

        $slider_image->title      =  isset($form_data['title'])?$form_data['title']:'';
        $slider_image->subtitle   =  isset($form_data['subtitle'])?$form_data['subtitle']:'';
        $slider_image->slider_button   =  isset($form_data['slider_button'])?$form_data['slider_button']:'';


         $slider_image->title_color    =  isset($form_data['title_color'])?$form_data['title_color']:'';
         $slider_image->subtitle_color =  isset($form_data['subtitle_color'])?$form_data['subtitle_color']:'';

         $slider_image->button_color =  isset($form_data['button_color'])?$form_data['button_color']:'';

        $slider_image->button_back_color =  isset($form_data['button_back_color'])?$form_data['button_back_color']:'';


        $slider_image->is_active   =  isset($form_data['is_active'])?$form_data['is_active']:'';

        /********************for slider image*******************/
        $file_name = '';
        if($request->hasFile('slider_image'))
        {	
        	$file = $request->file('slider_image');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
          //  $image1->resize(1920,600); // commented
            // $image1->resize(226,200);  //old
            $image1->save($this->slider_base_img_path.$file_name);

            $unlink_old_img_path    = $this->slider_base_img_path.'/'.$request->input('old_img');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_name = $request->input('old_img');
        }
        /********************for slider image***************************/


         /********************for slider medium image*******************/
        $file_medium_name = '';
        if($request->hasFile('slider_medium'))
        {   
            $file = $request->file('slider_medium');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_medium_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
          //  $image1->resize(1920,600); // commented
            // $image1->resize(226,200);  //old
            $image1->save($this->slider_base_img_path.$file_medium_name);

            $unlink_old_img_path    = $this->slider_base_img_path.'/'.$request->input('old_img_medium');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_medium_name = $request->input('old_img_medium');
        }
        /********************for slider medium image***************************/

          /********************for slider small image*******************/
        $file_small_name = '';
        if($request->hasFile('slider_small'))
        {   
            $file = $request->file('slider_small');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_small_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
          //  $image1->resize(1920,600); // commented
            // $image1->resize(226,200);  //old
            $image1->save($this->slider_base_img_path.$file_small_name);

            $unlink_old_img_path    = $this->slider_base_img_path.'/'.$request->input('old_img_small');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_small_name = $request->input('old_img_small');
        }
        /********************for slider small image***************************/




        $slider_image->slider_image   = $file_name;  
        $slider_image->slider_medium  = $file_medium_name;        
        $slider_image->slider_small   = $file_small_name;        

        $slider_image->save();

        if($slider_image)
        {

            if($is_update_process == false)
            {
                //if($slider_image->id)
               // {
                   // $response['link'] =$this->module_url_path.'/edit/'.base64_encode($slider_image->id);
                    $response['link'] =$this->module_url_path;
               // }
            }
            else
            {
                 $response['link'] =$this->module_url_path;
               // $response['link'] = $this->module_url_path.'/edit/'.base64_encode($slider_image->id);
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added slider image '.$slider_image->title.'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                  


                /*----------------------------------------------------------------------*/

               $response['status']      = "success";
               $response['description'] = "Slider image added successfully."; 
            }else{

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated slider image '.$slider_image->title.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
               $response['status']      = "success";
               $response['description'] = "Slider image updated successfully."; 
            }
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding slider image.";
        }

        return response()->json($response);
    }

    public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_slider_image = [];
        if($obj_data)
        {
           $arr_slider_image = $obj_data->toArray(); 
        }
    
      	$this->arr_view_data['slider_public_img_path']   = $this->slider_public_img_path;
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_slider_image']   		 = isset($arr_slider_image) ? $arr_slider_image : [];  
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
               $flag = "";

               $this->perform_delete(base64_decode($record_id),$flag);    
               Flash::success(ucfirst(strtolower($this->module_title)).' deleted successfully'); 
            } 
            elseif($multi_action=="activate")
            {  
                $flag = "activate";

               $this->perform_activate(base64_decode($record_id),$flag); 
               Flash::success(ucfirst(strtolower($this->module_title)).' activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            {  
                $flag = "deactivate";

               $this->perform_deactivate(base64_decode($record_id),$flag);    
               Flash::success(ucfirst(strtolower($this->module_title)).' blocked successfully');  
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on slider image.';

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on slider image.';

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on slider image.';

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
        $user = Sentinel::check();

        $entity  = $this->BaseModel->where('id',$id)->first();
    
        if($entity)
        {
            $entity_arr = $entity->toArray();

            $unlink_old_img_path    = $this->slider_base_img_path.'/'.$entity->slider_image;
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
       
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted slider image '.$entity_arr['title'].'.';

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
     
    public function perform_activate($id,$flag=false)
    {   
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();
        
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated slider image '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/  
            }
           

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        }

        return FALSE;
    }//activate

 
    public function perform_deactivate($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated slider image '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
           

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);
        }
        return FALSE;
    }//deactivate

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
}
