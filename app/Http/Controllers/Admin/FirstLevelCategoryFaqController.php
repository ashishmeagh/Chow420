<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Common\Services\UserService;

use App\Models\FirstLevelCategoryModel;
use App\Models\FirstLevelCategoryFaqModel;

use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;
 
class FirstLevelCategoryFaqController extends Controller
{       
    use MultiActionTrait;

    public function __construct(
                                FirstLevelCategoryModel $FirstLevelCategoryModel,
                                FirstLevelCategoryFaqModel $FirstLevelCategoryFaqModel,
                                UserService $UserService
                               ) 
    {
    	$this->BaseModel                        = $FirstLevelCategoryFaqModel;
        $this->FirstLevelCategoryModel          = $FirstLevelCategoryModel;
        $this->UserService                      = $UserService;

        $this->arr_view_data                    = [];
        $this->admin_url_path                   = url(config('app.project.admin_panel_slug'));

        $this->faq_base_img_path                = base_path().config('app.project.img_path.first_level_category_faq');
        $this->faq_public_img_path              = url('/').config('app.project.img_path.first_level_category_faq');

        $this->module_title                     = "First Level Category Faq";
        $this->module_view_folder               = "admin.first_level_category_faq";
        
        $this->enc_category_id                  = '';
        $this->module_url_path                  = '';
        $this->module_url_path_parent              = $this->admin_url_path."/first_level_categories/";
    }


    public function index($enc_category_id)
    {
        $this->module_url_path                  = $this->admin_url_path."/first_level_categories/".$enc_category_id."/faqs";
        $this->enc_category_id = $enc_category_id;
        $category_id = base64_decode($this->enc_category_id);

        $arr_category = $this->FirstLevelCategoryModel->where('id', $category_id)->select(['id','product_type'])->first();

        $this->arr_view_data['arr_category']     = isset($arr_category)?$arr_category :[];

        $this->arr_view_data['page_title']        = "Manage ".str_singular($this->module_title);
        $this->arr_view_data['enc_category_id']   = $enc_category_id;
        $this->arr_view_data['module_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['module_url_path_parent']   = $this->module_url_path_parent;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records($enc_category_id,Request $request)
    {
        $category_id = base64_decode($enc_category_id);
        $this->module_url_path                  = $this->admin_url_path."/first_level_categories/".$enc_category_id."/faqs";
    	$product_brand_table          = $this->BaseModel->getTable();
        $prefixed_productbrand_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_faq_table = DB::table($product_brand_table)                           
        							 ->where($product_brand_table.'.category_id',$category_id)
                                     ->orderBy($product_brand_table.'.created_at','DESC');
          $arr_search_column = $request->input('column_filter');    
  
           if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
            {
                $search_status    = $arr_search_column['q_status'];
                $obj_faq_table    = $obj_faq_table->where('is_active','LIKE','%'.$search_status.'%');
            }

    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_faq_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })
                         ->editColumn('question',function($data) use ($current_context)
                        {

                             /*if(strlen($data->question)>100){
                               return '<p class="prod-desc">'.str_limit($data->question,100).'..<a class="readmorebtn" question="'.$data->question.'" style="cursor:pointer" ><b>Read more</b></a></p>';
                            }
                            else{*/
                             //   return $data->question;
                            //}


                             // return '<p class="prod-desc">
                             //     <a class="readmorebtn btn btn-default" question='.base64_encode($data->question).'  style="cursor:pointer">
                             //     <b>View Question</b></a></p>';

                             if (strpos($data->question, '<iframe') !== false || strpos($data->question, '<img') !== false) {
                                return '<p class="prod-desc">
                                 <a class="readmorebtndecode btn btn-default" question='.base64_encode($data->question).'  style="cursor:pointer">
                                 <b>View Question</b></a></p>';
                             }else{
                                    if(strlen($data->question)>40){
                                         return '<p class="prod-desc">'.str_limit($data->question,40).'..<a class="readmorebtn btn btn-default" question="'.$data->question.'" style="cursor:pointer" ><b>View Question</b></a></p>';
                                    }
                                    else{
                                        return $data->question;
                                    }
                             }//else not img or iframe tag    



                        })   
                          ->editColumn('answer',function($data) use ($current_context)
                        {

                             /*if(strlen($data->answer)>100){
                               return '<p class="prod-desc">'.str_limit($data->answer,100).'..<a class="readmorebtnanswer" answer="'.$data->answer.'" style="cursor:pointer" ><b>Read more</b></a></p>';
                            }
                            else{*/
                              //  return $data->answer;
                           // }

                          // return '<p class="prod-desc"><a class="readmorebtnanswer btn btn-default" answer="'.base64_encode($data->answer).'" style="cursor:pointer" ><b>View Answer</b></a></p>';

                            if (strpos($data->answer, '<iframe') !== false || strpos($data->answer, '<img') !== false) {
                                return '<p class="prod-desc"><a class="readmorebtnanswerdecode btn btn-default" answer="'.base64_encode($data->answer).'" style="cursor:pointer" ><b>View Answer</b></a></p>';
                            }else{
                                if(strlen($data->answer)>40){
                                    return '<p class="prod-desc">'.str_limit($data->answer,40).'..<a class="readmorebtnanswer btn btn-default" answer="'.$data->answer.'" style="cursor:pointer" ><b>View Answer</b></a></p>';
                                 }
                                 else{
                                    return $data->answer;
                                 }
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


    public function create($enc_category_id)
    {
        $this->module_url_path                  = $this->admin_url_path."/first_level_categories/".$enc_category_id."/faqs";
        $category_id = base64_decode($enc_category_id);
        
        $arr_category = $this->FirstLevelCategoryModel->where('id', $category_id)->select(['id','product_type'])->first()->toArray();


        $this->arr_view_data['arr_category']     = isset($arr_category)?$arr_category :[];
        $this->arr_view_data['enc_category_id']   = $enc_category_id;

    	$this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $user = Sentinel::check();
    	$form_data = $request->all();
        

        $this->module_url_path  = $this->admin_url_path."/first_level_categories/".$form_data['category_id']."/faqs";

        $category_id = base64_decode($form_data['category_id']);
        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
      //  if($is_update_process == false)
       // {
        	$arr_rules = [
                            'question'  => 'required',
                            'answer'    => 'required',

                         ];
      //  }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
       
    	
        
        /* Main Model Entry */
        $faqs = $this->BaseModel->firstOrNew(['id' => $id]);

        $faqs->category_id   =  isset($category_id)?$category_id:'';
        $faqs->question      =  isset($form_data['question'])?$form_data['question']:'';
        $faqs->answer        =  isset($form_data['answer'])?$form_data['answer']:'';

        if($request->is_active!='' && !empty($request->is_active)){
          $is_active  =  isset($form_data['is_active'])?$form_data['is_active']:'';  
        }else{
            $is_active =0;
        }
        $faqs->is_active = $is_active;
        $faqs->save();
        if($faqs)
        {

            if($is_update_process == false)
            {
                $response['link'] = $this->module_url_path;
            }
            else
            {
               // $response['link'] = $this->module_url_path.'/edit/'.base64_encode($id);
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added first level category faq '.'"'.strip_tags($faqs->question).'"'.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                $response['status']      = "success";
                $response['description'] = "Faq added successfully."; 

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated first level category faq '.'"'.strip_tags($faqs->question).'"'.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                $response['status']      = "success";
                $response['description'] = "Faq updated successfully."; 
            }

          
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding brand.";
        }

        return response()->json($response);
    }

    public function edit($enc_category_id,$enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_faqs = [];
        if($obj_data)
        {
           $arr_faqs = $obj_data->toArray(); 
        }
        $this->module_url_path  = $this->admin_url_path."/first_level_categories/".$enc_category_id."/faqs";
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_faqs']   		         = isset($arr_faqs) ? $arr_faqs : [];  
      	$this->arr_view_data['page_title']               = "Edit ".$this->module_title;
      	$this->arr_view_data['module_title']             = str_plural($this->module_title);
  
      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

    public function multi_action($enc_category_id,Request $request)
    {
        $this->module_url_path    = $this->admin_url_path."/first_level_categories/".$enc_category_id."/faqs";
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
               Flash::success(str_singular($this->module_title).' activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $flag = "deactivate";

               $this->perform_deactivate(base64_decode($record_id),$flag);    
               Flash::success(str_singular($this->module_title).' blocked successfully');  
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on faq.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on faq.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on faq.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

               /*----------------------------------------------------------------------*/
        } 
              

        return redirect()->back();
    }

    public function delete($enc_category_id,$enc_id = FALSE)
    {
        $this->module_url_path  = $this->admin_url_path."/first_level_categories/".$enc_category_id."/faqs";

        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete($enc_category_id,base64_decode($enc_id)))
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

        $entity  = $this->BaseModel->where('id',$id)->first();
    
        if($entity)
        {
            $entity_arr = $entity->toArray();

            $unlink_old_img_path    = $this->faq_base_img_path.'/'.$entity->image;
                            
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted faq '.$entity_arr['question'].'.';

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


    public function activate($enc_category_id,Request $request)
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

    public function deactivate($enc_category_id,Request $request)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated faq.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated faq.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
           

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

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
                $arr_event['action']       = 'FEATURED';
                $arr_event['title']        = $this->module_title;
                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has featured faq '.$entity_arr['question'].'.';

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

        $category = $this->BaseModel->where('id',$id)->update(['is_featured'=>'0']);

        $entity   = $this->BaseModel->where('id',$id)->first();

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has unfeatured faq '.$entity_arr['question'].'.';

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
    }//end of function

    public function uploadimage(Request $request)
    {
       /*if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move(public_path('images'), $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
          //  $url = asset('images/'.$fileName); 
            $url = public_path('images').'/'.$fileName;
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }*/

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
                $image1->save($this->faq_base_img_path.'/'.$file_name);

                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $url = $this->faq_public_img_path.'/'.$file_name;
                $msg='';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                   
                @header('Content-type: text/html; charset=utf-8'); 
                echo $response;
            }else{
                $msg='Please select valid file only jpg,png and jpeg files allowed';                
                echo $msg;
            }

         
        }//if file request 
       
    }//end


}
