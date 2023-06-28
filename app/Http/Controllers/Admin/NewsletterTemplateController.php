<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

use App\Models\NewsletterTemplateModel;
use App\Common\Services\UserService;

use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;


 
class NewsletterTemplateController extends Controller
{       
    use MultiActionTrait;

    public function __construct(NewsletterTemplateModel $NewsletterTemplateModel,
                                UserService $UserService
                               ) 
    {
    	$this->BaseModel          = $NewsletterTemplateModel;
        $this->UserService        = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->newsletter_base_img_path   = base_path().config('app.project.img_path.newsletter');
        $this->newsletter_public_img_path = url('/').config('app.project.img_path.newsletter');


        $this->module_title       = "Newsletter Template";
        $this->module_view_folder = "admin.newsletter_template";
        $this->module_url_path    = $this->admin_url_path."/newsletter_template";
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
  
           if(isset($arr_search_column['q_newsletter_name']) && $arr_search_column['q_newsletter_name'] != '')
            {
                $search_name            = $arr_search_column['q_newsletter_name'];
                $obj_brand_table        = $obj_brand_table->where('newsletter_name','LIKE','%'.$search_name.'%');
            }

          	  if(isset($arr_search_column['q_newsletter_subject']) && $arr_search_column['q_newsletter_subject'] != '')
            {
                $search_name            = $arr_search_column['q_newsletter_subject'];
                $obj_brand_table        = $obj_brand_table->where('newsletter_subject','LIKE','%'.$search_name.'%');
            }

            if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
            {
                $search_term            = $arr_search_column['q_status'];
                $obj_brand_table        = $obj_brand_table->where('is_active','LIKE','%'.$search_term.'%');
            }

           
    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_brand_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
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
                            'newsletter_name'     => 'required',
                            'newsletter_subject'     => 'required',
                            'newsletter_desc'     => 'required',

                         ];
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }

        if(empty($form_data['newsletter_desc']))
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter description';

            return response()->json($response);
        }
      
        /* Main Model Entry */
        $newsletter = $this->BaseModel->firstOrNew(['id' => $id]);

        $newsletter->newsletter_name      =  isset($form_data['newsletter_name'])?$form_data['newsletter_name']:'';

        $newsletter->newsletter_subject      =  isset($form_data['newsletter_subject'])?$form_data['newsletter_subject']:'';

        $newsletter->newsletter_desc      =  isset($form_data['newsletter_desc'])?$form_data['newsletter_desc']:'';

        if($request->is_active!='' && !empty($request->is_active)){
          $is_active  =  isset($form_data['is_active'])?$form_data['is_active']:'';  
        }else{
            $is_active =0;
        }   

         $newsletter->is_active = $is_active;
     
        $newsletter->save();

        if($newsletter)
        {

           
  
            if($is_update_process == false)
            {
               
                $response['link'] = $this->module_url_path;

            }
            else
            {
                $response['link'] = $this->module_url_path;
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added newsletter template '.$newsletter->newsletter_name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['status']      = "success";
                $response['description'] = "Newsletter template added successfully."; 

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated newsletter template '.$newsletter->newsletter_name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                $response['status']      = "success";
                $response['description'] = "Newsletter template updated successfully."; 
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
    
        $arr_newsletter = [];
        if($obj_data)
        {
           $arr_newsletter = $obj_data->toArray(); 
        }
    
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_newsletter']   		     = isset($arr_newsletter) ? $arr_newsletter : [];  
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on newsletter template.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on newsletter template.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on newsletter template.';

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

    public function perform_delete($id,$flag=false)
    {
        $user = Sentinel::check();
    
        $entity = $this->BaseModel->where('id',$id)->first();
    
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted newsletter template '.$entity_arr['newsletter_name'].'.';

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
            $arr_response['msg']   = 'Sorry, you can not deactivate.';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated newsletter template '.$entity_arr['newsletter_name'].'.';

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
            $get_newsletter = $this->BaseModel->where('id',$id)->get();

            if(isset($get_newsletter) && !empty($get_newsletter))
            {
                $get_newsletter = $get_newsletter->toArray();

                if(isset($get_newsletter) && !empty($get_newsletter))
                { 
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
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated newsletter template '.$entity_arr['newsletter_name'].'.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }

                        /*----------------------------------------------------------------------*/

                    }

                    return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

                }
                else
                { 
                    return false;
   
                }
            }

        }
        return FALSE;
    }//deactivate


    public function uploadimage(Request $request)
    {
        $file_name = '';
        if($request->hasFile('upload'))
        {   
            $file = $request->file('upload');
            $extension  = strtolower($file->getClientOriginalExtension());

             if(in_array($extension,['png','jpg','jpeg']))
             {
                 $size  = $file->getClientSize();
               
                $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

                $image1      = Image::make($file);
                $image1->resize(346,268);
                $image1->save($this->newsletter_base_img_path.'/'.$file_name);

                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $url = $this->newsletter_public_img_path.'/'.$file_name;
                $msg='';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                   
                @header('Content-type: text/html; charset=utf-8'); 
                echo $response;
            }else{
                $msg='Please select valid file only jpg,png and jpeg files allowed';                
                echo $msg;
            }

         
        }//if file request 
       
    }//end of function
   

}
