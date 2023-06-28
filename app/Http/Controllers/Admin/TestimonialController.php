<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TestimonialModel;
use Datatables;
use Validator;
use Image;
use Flash;

 
class TestimonialController extends Controller
{
    public function __construct(TestimonialModel $TestimonialModel)
    {	
    	$this->base_table         = $TestimonialModel;
    	$this->admin_panel_slug   = config('app.project.admin_panel_slug');
    	$this->module_url_path    = url($this->admin_panel_slug.'/testimonial');
    	$this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');
    	$this->module_title       = 'Testimonial';
    	$this->module_view_folder = 'admin/testimonial';
    	$this->arr_view_data      = [];
    }

    public function index()
    {	
       $arr_testimonials = $this->base_table->get()->toArray();

       $this->arr_view_data['module_url_path'] = $this->module_url_path;
       $this->arr_view_data['module_title']    = $this->module_title;
       $this->arr_view_data['arr_testimonials'] = $arr_testimonials;
       return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create()
    {
        $this->arr_view_data['user_profile_public_img_path']=$this->user_profile_public_img_path;
    	$this->arr_view_data['module_url_path'] = $this->module_url_path;
    	$this->arr_view_data['module_title']    = $this->module_title;
    	$this->arr_view_data['page_title']      = 'Create'.$this->module_title;

    	return view($this->module_view_folder.'.edit',$this->arr_view_data);
    }

    public function edit($enc_id)
    {	
    	$arr_testimonial = [];

    	$id = isset($enc_id)?base64_decode($enc_id):false;
    	
    	$obj_testimonial = $this->base_table->where('id',$id)->first();

    	if($obj_testimonial)
    	{
    		$arr_testimonial = $obj_testimonial->toArray();
    	}

    	$this->arr_view_data['user_profile_public_img_path']=$this->user_profile_public_img_path;
    	$this->arr_view_data['arr_testimonial'] = $arr_testimonial;
    	$this->arr_view_data['module_url_path'] = $this->module_url_path;
    	$this->arr_view_data['module_title'] = $this->module_title;
    	$this->arr_view_data['page_title'] = 'Edit'.$this->module_title;

    	return view($this->module_view_folder.'.edit',$this->arr_view_data);
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
            Flash::error('Problem Occured While '.str_singular($this->module_title).' Deletion ');
        }

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $form_data = $request->all();

        $is_update_process = false;

        $client_id = $request->input('enc_id',false);

        $client_id = $client_id ==""  ? false : $client_id;

        if($client_id)
        {
            $is_update_process = true;
        }
        // dd($is_update_process);
        
       $arr_rules = [
                       'user_name'   => 'required',
                       'description' => 'required|max:500',
                       'social_name' => 'required'
                     ];
        
       
       $validator = Validator::make($request->all(),$arr_rules);

       if($validator->fails())
       {
          $response['status'] = 'warning';
          $response['description'] = 'Valiation Failed Please check The All Fields In Form.';

          return response()->json($response);
       }

      $file_name = '';
        if($request->hasFile('profile_image'))
        {	
        	$file = $request->file('profile_image');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
            $image1->resize(343,155);
            $image1->save($this->user_profile_base_img_path.$file_name);

            $unlink_old_img_path    = $this->user_profile_public_img_path.'/'.$request->input('old_image');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_name = $request->input('old_image');
            // dd($file_name);
        }

        if(isset($form_data['is_active']))
        {
            $status = '1';
        }
        else
        {
            $status = '0';
        }

   
        $client = $this->base_table->firstOrNew(['id' => $client_id]);

        $client->profile_photo     =  $file_name;
        
        $client->name              =  isset($form_data['user_name'])?$form_data['user_name']:'';
     
        $client->description       =  isset($form_data['description'])?$form_data['description']:'';

        $client->is_active         =  $status;

        $client->social_name       = isset($form_data['social_name'])?$form_data['social_name']:'';

        $client_details = $client->save();


        if($client)      
        {
             /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
                /*$arr_event                 = [];
                $arr_event['ACTION']       = 'ADD';

                if($is_update_process)
                {
                    $arr_event['ACTION']   = 'EDIT';
                }
                
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);*/

               $response['status']      = 'success';
               $response['description'] = $this->module_title.' Save Successfully';

               if($is_update_process == false)
               {
                if($client->id)
                {
                    $response['link'] = url($this->admin_panel_slug.'/testimonial/edit/'.base64_encode($client->id));
                }
               
               }

            /*----------------------------------------------------------------------*/
        }
        else
        {
               $response['status']      = 'error';
               $response['description'] = 'Error Occurred, While Save '.$this->module_title;
        }
        return response()->json($response);
    }

    public function change_status(Request $request)
    {
    	$id = $request->input('id');

    	$id = isset($id)?base64_decode($id):false;

    	$type = $request->input('type');

    	if($id && $type)
    	{
    		if($type=="activate")
            {
               $status = $this->perform_activate($id); 

               if($status)
               {
               	   $response['status'] = 'success';
                   $response['message'] = str_plural($this->module_title).' Activated Successfully';
				
			       return response()->json($response);
               }
               else
               {
               	  $response['status'] = 'error';
                  $response['message'] = 'Error Occurred While Activation Testimonial';
				
			    return response()->json($response);
               }
              

				
            }
            elseif($type=="deactivate")
            {
               $status = $this->perform_deactivate($id);

              
               if($status)
               {
               	   $response['status'] = 'success';
                   $response['message'] = str_plural($this->module_title).' Blocked Successfully';
				
			       return response()->json($response);
               }
               else
               {
               	  $response['status'] = 'error';
                  $response['message'] = 'Error Occurred While Blocked Testimonial';
				
			    return response()->json($response);
               }
              
            }
    	}
    }

    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('Please Select '.str_plural($this->module_title) .' To Perform Multi Actions');  
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect()->back();

        }
        
        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
               $this->perform_delete($record_id);    
               Flash::success(str_plural($this->module_title).' Deleted Successfully'); 
            } 
            elseif($multi_action=="activate")
            {
               $this->perform_activate($record_id); 
               Flash::success(str_plural($this->module_title).' Activated Successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $this->perform_deactivate($record_id);    
               Flash::success(str_plural($this->module_title).' Blocked Successfully');  
            }
        }

        return redirect()->back();
    }

    public function perform_activate($id)
    {
        $entity = $this->base_table->where('id',$id)->first();
        
        if($entity)
        {
            return $this->base_table->where('id',$id)->update(['is_active'=>'1']);
        }

        return FALSE;
    }

    public function perform_deactivate($id)
    {

        $entity = $this->base_table->where('id',$id)->first();
                if($entity)
        {
            return $this->base_table->where('id',$id)->update(['is_active'=>'0']);
        }
        return FALSE;
    }

    public function perform_delete($id)
    {
        $entity = $this->base_table->where('id',$id)->first();
        if($entity)
        {

            $this->base_table->where('id',$id)->delete();
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
               /* $arr_event                 = [];
                $arr_event['ACTION']       = 'REMOVED';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);*/
            /*----------------------------------------------------------------------*/
           return TRUE;
        }

        return FALSE;
    }


  
}
