<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Common\Services\UserService;

use App\Models\FaqModel;
use App\Models\FaqCategoryModel;
use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;
 
class FaqController extends Controller
{       
    use MultiActionTrait;

    public function __construct(FaqModel $FaqModel,
                                UserService $UserService,
                                FaqCategoryModel $FaqCategoryModel
                               ) 
    {
    	$this->BaseModel          = $FaqModel;
        $this->UserService        = $UserService;
        $this->FaqCategoryModel   = $FaqCategoryModel;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->faq_base_img_path   = base_path().config('app.project.img_path.faq');
        $this->faq_public_img_path = url('/').config('app.project.img_path.faq');

        $this->module_title       = "Help Center";
        $this->module_view_folder = "admin.faq";
        $this->module_url_path    = $this->admin_url_path."/helpcenter";
    }


    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".str_singular($this->module_title);
        $this->arr_view_data['module_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$product_brand_table          = $this->BaseModel->getTable();
        $prefixed_productbrand_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $faq_category_table          = $this->FaqCategoryModel->getTable();
        $prefixed_faq_category_table = DB::getTablePrefix().$this->FaqCategoryModel->getTable();

        $obj_faq_table = DB::table($product_brand_table)  
                                 ->select(DB::raw(
                                    $product_brand_table.'.*,'.
                                    $faq_category_table.'.id as f_cat_id,'.
                                    $faq_category_table.'.faq_category as category_name'

                                   )) 
                                 ->leftjoin($faq_category_table,$faq_category_table.'.id','=',$product_brand_table.'.faq_category')                        
        						 ->orderBy($product_brand_table.'.created_at','DESC');

        $arr_search_column = $request->input('column_filter');    

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
        {
            $search_status    = $arr_search_column['q_status'];
            $obj_faq_table    = $obj_faq_table->where($product_brand_table.'.is_active','LIKE','%'.$search_status.'%');
        }

        if(isset($arr_search_column['q_category_name']) && $arr_search_column['q_category_name'] != '')
        {
            $search_status    = $arr_search_column['q_category_name'];
            $obj_faq_table    = $obj_faq_table->where($faq_category_table.'.faq_category','LIKE','%'.$search_status.'%');
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

                        ->editColumn('category_name',function($data) use ($current_context)
                        {
                            $category_name = isset($data->category_name)?$data->category_name:'--';

                            return $category_name;


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
        $faq_category_arr = [];

        $faq_category_arr = $this->FaqCategoryModel->where('is_active',1)->get()->toArray();

    	$this->arr_view_data['faq_category_arr'] = $faq_category_arr;
        $this->arr_view_data['page_title']       = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']     = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']  = $this->module_url_path;
        
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

        $arr_rules = [];
      //  if($is_update_process == false)
       // {
        	$arr_rules = [
                            'question'     => 'required',
                            'answer'       => 'required',
                            'category' => 'required'

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

        $faqs->question            =  isset($form_data['question'])?$form_data['question']:'';
        $faqs->answer              =  isset($form_data['answer'])?$form_data['answer']:'';
        $faqs->faq_category        =  isset($form_data['category'])?$form_data['category']:'';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added faq '.'"'.strip_tags($faqs->question).'"'.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                $response['status']      = "success";
                $response['description'] = "Help center added successfully."; 

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated faq '.'"'.strip_tags($faqs->question).'"'.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                $response['status']      = "success";
                $response['description'] = "Help center updated successfully."; 
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
        $faq_category_arr  = [];

        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_faqs = [];
        if($obj_data)
        {
           $arr_faqs = $obj_data->toArray(); 
        }
    
        $faq_category_arr = $this->FaqCategoryModel->where('is_active',1)->get()->toArray(); 


        $this->arr_view_data['faq_category_arr']         = $faq_category_arr;
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_faqs']   		         = isset($arr_faqs) ? $arr_faqs : [];  
      	$this->arr_view_data['page_title']               = "Edit ".$this->module_title;
      	$this->arr_view_data['module_title']             = str_plural($this->module_title);
  
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on help center.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on help center.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on help center.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted help center '.$entity_arr['question'].'.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated help center.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated help center.';

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has featured help center '.$entity_arr['question'].'.';

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has unfeatured help center '.$entity_arr['question'].'.';

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
