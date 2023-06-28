<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;

use App\Models\CategoryModel;  
use App\Models\CategoryTranslationModel;
use App\Common\Services\LanguageService; 
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Common\Services\UserService;

use Validator;
use Session;
use Flash;
use File;
use Sentinel;
use DB;
use Datatables;

class CategoryController extends Controller
{
    use MultiActionTrait;
    
    public function __construct(
                                CategoryModel $category,
                                LanguageService $langauge,
                                CategoryTranslationModel $category_translation,
                                ActivityLogsModel $activity_logs,
                                UserService $UserService
                                )
    {
        $this->category_base_img_path   = base_path().config('app.project.img_path.category');
        $this->category_public_img_path = url('/').config('app.project.img_path.category');

        $this->CategoryModel            = $category;
        $this->BaseModel                = $this->CategoryModel;
        $this->LanguageService          = $langauge;
        $this->CategoryTranslationModel = $category_translation;
        $this->ActivityLogsModel  = $activity_logs;
        $this->UserService        = $UserService;
        $this->arr_view_data      = [];
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/categories");
        $this->module_title       = "Category/Sub-Category";
        $this->module_url_slug    = "categories";
        $this->module_view_folder = "admin.category";
        /*For activity log*/
        $this->obj_data =[];
        $this->obj_data    = Sentinel::getUser();
    }   
 
    public function index()
    {
        $arr_lang     = array();
        $arr_category = array();

        $obj_data = $this->BaseModel->where('parent',0)->get();

        if($obj_data != FALSE)
        {
            $arr_category = $obj_data->toArray();
        }

        $this->arr_view_data['category_public_img_path'] = $this->category_public_img_path;
        $this->arr_view_data['arr_category']             = $arr_category;
        $this->arr_view_data['page_title']               = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']             = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']         = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
        $obj_categories     = $this->get_categories($request);

        $current_context = $this;

        $json_result     = Datatables::of($obj_categories);

        $json_result     = $json_result->blacklist(['id']);
        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                            ->editColumn('build_view_sub_category',function($data) use ($current_context)
                            {
                                $view_href =  $this->module_url_path.'/sub_categories/'.base64_encode($data->id);
                                $build_view_sub_category = '<a class="btn btn-circle btn-info btn-outline show-tooltip" href="'.$view_href.'" title="View"><i class="fa fa-eye"></i></a>';
                                return $build_view_sub_category;
                            })
                            ->editColumn('build_status_btn',function($data) use ($current_context)
                            {
                                if($data->is_active != null && $data->is_active == '0')
                                {
                                    $msg = "'Are you sure to Activate this record?'";   

                                    $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';

                                }
                                elseif($data->is_active != null && $data->is_active == '1')
                                {
                                    $msg = "'Are you sure to Deactivate this record?'";

                                    $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_status_btn;
                            })    
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" href="'.$edit_href.'" title="Edit"><i class="ti-pencil-alt2" ></i></a>';

                                $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';
                                $build_delete_action = '<a class="btn btn-circle btn-danger btn-outline show-tooltip" '.$confirm_delete.' href="'.$delete_href.'" title="Delete"><i class="ti-trash" ></i></a>';

                                return $build_action = $build_edit_action.' '.$build_delete_action;
                            })
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

    public function get_locale()
    {
        $locale = '';
        if(Session::has('locale'))
        {
            $locale = Session::get('locale');
        }
        else
        {
            $locale = 'en';
        }
        return $locale;
    }

    function get_categories(Request $request)
    {
        $locale = $this->get_locale();

        $categories_table           = $this->BaseModel->getTable();
        $prefixed_categories_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $categories_trans_table     = $this->CategoryTranslationModel->getTable();
        $prefixed_categories_trans_table  = DB::getTablePrefix().$this->CategoryTranslationModel->getTable();

        $obj_categories = DB::table($categories_table)
                                ->select(DB::raw($prefixed_categories_table.".id as id,".
                                                 $prefixed_categories_table.".parent as parent,".
                                                 $prefixed_categories_table.".is_active as is_active,".
                                                 $prefixed_categories_trans_table.".category_title as category_title,".
                                                 $prefixed_categories_trans_table.".category_slug as category_slug,".
                                                 $prefixed_categories_trans_table.".locale as locale"
                                                 ))
                                ->where($categories_table.'.parent','=',0)
                                ->whereNull($categories_table.'.deleted_at')
                                ->whereNull($prefixed_categories_trans_table.'.deleted_at')
                                ->orderBy($categories_table.'.created_at','DESC')
                                ->where($categories_trans_table.'.locale', '=', $locale)
                                ->join($categories_trans_table,$categories_table.'.id' ,'=', $categories_trans_table.'.category_id');

        /* ---------------- Filtering Logic ----------------------------------*/                    

        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_category']) && $arr_search_column['q_category']!="")
        {
            $search_term      = $arr_search_column['q_category'];
            $obj_categories = $obj_categories->where($categories_trans_table.'.category_title','LIKE', '%'.$search_term.'%');
        }

        return $obj_categories;
    }


    public function index_sub_category($enc_id)
    {
        $parent_id = base64_decode($enc_id); 
        
        $arr_lang = array();
        $arr_category = array();

        /* Get Parent Category Info */
        $parent_category = $this->BaseModel->where('id',$parent_id)->first();

        if($parent_category)
        {
           $page_title = "Manage Sub-".str_singular($this->module_title)." for ".$parent_category->category_title;       
        }

        $res = $this->BaseModel->where('parent',$parent_id)->get();
        if($res != FALSE)
        {
            $arr_category = $res->toArray();
        }

        $category_public_img_path = $this->category_public_img_path;

        $this->arr_view_data['category_public_img_path'] = $this->category_public_img_path;
        $this->arr_view_data['arr_category']             = $arr_category;
        $this->arr_view_data['parent_id']                = $parent_id;
        $this->arr_view_data['page_title']               = "Manage Sub-".str_plural($this->module_title);
        $this->arr_view_data['module_title']             = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        return view($this->module_view_folder.'.index_sub_category',$this->arr_view_data);
    }    


    public function create($enc_parent_id=FALSE)
    {

        $parent_id = isset($enc_parent_id)?base64_decode($enc_parent_id):0;

        $arr_parent_category = $this->get_all_parent_category();


        $this->arr_view_data['arr_parent_category_options'] = $this->build_select_options_array($arr_parent_category,
                                'id',
                                        'category_title',
                                        ['0'=>'Main Category']    
                                        );


        $this->arr_view_data['parent_id']    = $parent_id;
        $this->arr_view_data['arr_lang']     = $this->LanguageService->get_all_language();
        $this->arr_view_data['page_title']   = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title'] = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }


    public function save(Request $request)
    {
        $user = Sentinel::check();

        /* Is Update/ Create Process */
        $is_update_process = false;
        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }


        $arr_rules = [
            'title_en' => 'required',
            'parent' => 'required',
        ];

        if($is_update_process == false)
        {
            $arr_rules['image'] = "required|image|mimes:jpg,jpeg,png";    
        }
        

        $validator = Validator::make($request->all(),$arr_rules,[
                'title_en.required' => 'Title is required',
                'image.required' => 'Image is required'
            ]);

        if($validator->fails())
        {
            return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors($validator);
        }

        

        /* Duplication Check */
        $obj_dup_check = $this->BaseModel
                            ->where('parent',$request->input('parent'))
                            ->whereHas('translations',function($query) use($request)
                                    {
                                        $query->where('locale','en')
                                              ->where('category_title',$request->input('title_en'));      
                                    });

        if($is_update_process)
        {
            $obj_dup_check = $obj_dup_check->where('id','<>',$request->input("id"));
        }

        $does_exists = $obj_dup_check->count();

        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists.');
            return redirect()->back()->withInput($request->all());
        }

        /* Main Model Entry */
        $category = CategoryModel::firstOrNew(['id' => $id]);

        /* Image Handling */

        $file_name = false;

        if($request->hasFile('image'))
        {
            $file_name = $request->input('image');
            $file_extension = strtolower($request->file('image')->getClientOriginalExtension()); 

            if($is_update_process)
            {
                $this->perform_category_image_unlink($category);    
            }

            $file_name = sha1(uniqid().$file_name.uniqid()).'.'.$file_extension;
            $request->file('image')->move($this->category_base_img_path, $file_name);  
        }


        $category->parent = $request->input('parent');

        if($is_update_process != false)
        {
            $category->is_active = '1';    
        }

        if($file_name != false)
        {
            $category->image = $file_name;    
        }

        $category->save();
        
        $form_data = $request->all();

        /* Multilingual Model Entry */

        /* Get All Active Languages */ 
  
        $arr_lang = $this->LanguageService->get_all_language();  


        if(sizeof($arr_lang) > 0)
        { 
            foreach($arr_lang as $i => $lang)
            {
                $translate_data_ary = array();
                $title = 'title_'.$lang['locale'];

                if(isset($form_data[$title]) && $form_data[$title]!="")
                {
                    /* Get Existing Language Entry */
                    $translation = $category->getTranslation($lang['locale']);    
                    if($translation)
                    {
                        $translation->category_title = $form_data['title_'.$lang['locale']];
                        $translation->category_slug  = str_slug($form_data['title_'.$lang['locale']], "-");
                        $translation->save();    
                    }  
                    else
                    {
                        /* Create New Language Entry  */
                        $translation                 = $category->getNewTranslation($lang['locale']);
                        $translation->category_id    = $category->id;
                        $translation->category_title = $form_data['title_'.$lang['locale']];
                        $translation->category_slug  = str_slug($form_data['title_'.$lang['locale']], "-");
                        $translation->save();
                    } 
                }   
            }
            
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added category '.$translation->category_title.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

            /*----------------------------------------------------------------------*/
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated category '.$translation->category_title.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

            /*----------------------------------------------------------------------*/
        }

        Flash::success(str_singular($this->module_title).' Saved Successfully');
        return redirect()->back();
    }

    

    public function edit($enc_id)
    {

        $id = base64_decode($enc_id);

        $data     = array();
        $arr_lang = $this->LanguageService->get_all_language();

        $category_image  = "default.jpg";
        $category_parent = "0";

        $obj_data = $this->BaseModel->where('id', $id)->with(['translations'])->first();

        $arr_category = [];
        if($obj_data)
        {
           $arr_category = $obj_data->toArray(); 

           /* Arrange Locale Wise */
           $arr_category['translations'] = $this->arrange_locale_wise($arr_category['translations']);
        }


        $category_public_img_path = $this->category_public_img_path;

        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
        $this->arr_view_data['arr_lang']                 = $this->LanguageService->get_all_language();
        $this->arr_view_data['category_public_img_path'] = $category_public_img_path;
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $arr_parent_category                             = $this->get_all_parent_category();

        $this->arr_view_data['arr_parent_category_options'] = $this->build_select_options_array($arr_parent_category,
                            'id',
                            'category_title',
                            ['0'=>'Main Category']    
                            );
        $this->arr_view_data['arr_category'] = $arr_category;  

        $this->arr_view_data['page_title']   = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title'] = str_singular($this->module_title);

        return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

    public function multi_action(Request $request)
    {
        $user = Sentinel::check();

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


               $this->perform_delete(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Deleted Successfully'); 

            } 
            elseif($multi_action=="activate")
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

               $this->perform_activate(base64_decode($record_id)); 
               Flash::success(str_plural($this->module_title).' Activated Successfully'); 

            }
            elseif($multi_action=="deactivate")
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


               $this->perform_deactivate(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Blocked Successfully');  
            }
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

    public function delete($enc_id = FALSE)
    {
        $user = Sentinel::check();

        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted category.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

               /*----------------------------------------------------------------------*/


              Flash::success(str_singular($this->module_title).' Deleted Successfully');
        }
        else
        {
            Flash::error('Problem Occurred While Deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }


    public function perform_activate($id)
    {
        $user = Sentinel::check();

        $category = $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        $sub_category = $this->BaseModel->where('parent',$id)->update(['is_active'=>'1']);

        if($category)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated category.';

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

    public function perform_deactivate($id)
    {
        $user = Sentinel::check();

        $category     = $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);
        $sub_category = $this->BaseModel->where('parent',$id)->update(['is_active'=>'0']);
        
        if($category)
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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated category.';

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

    public function perform_delete($id)
    {
        $category = $this->BaseModel->where('id',$id)    
                                    ->first();

        if($category)
        {
            if($category->parent == 0)
            {
                $category = $category->load(['child_category']);

                $is_delete = $this->perform_category_image_unlink($category);
            }
            else
            {
                $category = $category->load(['parent_category']);

                $is_delete = $this->perform_category_image_unlink($category);
            }
            
            if($is_delete == true)
            {

                $this->CategoryTranslationModel->where('category_id',$category->id)
                                               ->delete();

                return $category->delete();
            }
        }

        return FALSE;
    }
   
    public function perform_category_image_unlink($category)
    {   
        if($category)
        {
            if($category->parent_category)
            {
                if($category->image)
                {
                    if(File::exists($this->category_base_img_path.$category->image))
                    {
                        unlink($this->category_base_img_path.$category->image);
                    }

                    return true;
                }
            }
            else if($category->child_category)
            {
                if($category->child_category)
                {
                   foreach($category->child_category as $key => $data)
                   {
                        if($data->image)
                        {
                            if(File::exists($this->category_base_img_path.$data->image))
                            {
                                unlink($this->category_base_img_path.$data->image);
                            }

                        }

                        $this->CategoryTranslationModel->where('category_id',$data->id)
                                                       ->delete();
                        $data->delete();
                   } 

                }

                if($category->image)
                {
                    if(File::exists($this->category_base_img_path.$category->image))
                    {
                        unlink($this->category_base_img_path.$category->image);
                    }

                    return true;
                }
            }
        }
        else
        {
            return false;
        }

    }

  
    public function build_select_options_array(array $arr_data,$option_key,$option_value,array $arr_default)
    {

        $arr_options = [];
        /*--------------------------------------------------------------
        |   Array Default - Main Category Hide For Temporary
        ---------------------------------------------------------------*/

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


    public function arrange_locale_wise(array $arr_data)
    {
        if(sizeof($arr_data)>0)
        {
            foreach ($arr_data as $key => $data) 
            {
                $arr_tmp = $data;
                unset($arr_data[$key]);

                $arr_data[$data['locale']] = $data;                    
            }

            return $arr_data;
        }
        else
        {
            return [];
        }
    }

    /**
     * Fetch all parent category list 
     * 
     * @author: Paras Kale
     * @date   09-02-2016
     * @return array
     * 
     */
    public function  get_all_parent_category()
    {
        $arr_parent_category = array();
        $obj_data = $this->BaseModel->where('parent','0')->get();

        if($obj_data)
        {
           $arr_parent_category = $obj_data->toArray();

        }

        return $arr_parent_category;
    }

}
