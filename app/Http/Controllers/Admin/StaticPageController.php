<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;

use App\Common\Services\LanguageService;  
use App\Models\StaticPageModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\StaticPageTranslationModel; 
use App\Common\Services\UserService;  

use Validator;
use Flash; 
Use Sentinel;
use DB; 
 
class StaticPageController extends Controller
{
    use MultiActionTrait;
    
    public $StaticPageModel; 
    
    public function __construct(StaticPageModel $static_page,
                                LanguageService $langauge,
                                ActivityLogsModel $activity_logs,
                                StaticPageTranslationModel $StaticPageTranslationModel,
                                 UserService $UserService

                              )
    {      
        $this->StaticPageModel   = $static_page;
        $this->BaseModel         = $this->StaticPageModel;
        $this->ActivityLogsModel = $activity_logs;
        $this->StaticPageTranslationModel = $StaticPageTranslationModel;
        $this->UserService        = $UserService;

        $this->LanguageService   = $langauge;
        $this->module_title      = "CMS";
        $this->module_url_slug   = "static_pages";
        $this->module_url_path   = url(config('app.project.admin_panel_slug')."/static_pages");
    }
     /*
    | Index  : Display listing of Static Pages
    | auther : Paras Kale 
    | Date   : 13/02/2015
    | @return \Illuminate\Http\Response
    */ 
 
    public function index()
    {
        $arr_lang   =  $this->LanguageService->get_all_language();  

        $staticpage_details           = $this->BaseModel->getTable();        
        $prefixed_staticpage_details  = DB::getTablePrefix().$this->BaseModel->getTable();

        $statictransalation_details   = $this->StaticPageTranslationModel->getTable();
        $prefixed_statictrans_details = DB::getTablePrefix().$this->StaticPageTranslationModel->getTable();

        $obj_static_page = DB::table($staticpage_details)
                            ->select(DB::raw($staticpage_details.'.*,'.$prefixed_statictrans_details.'.page_title'))
                            ->leftjoin($prefixed_statictrans_details,$prefixed_statictrans_details.'.static_page_id',"=",$prefixed_staticpage_details.'.id')
                            ->get();
        // dd($obj_static_page);                   

       // $obj_static_page = $this->BaseModel->orderBy('id','DESC')->get();

       /* if($obj_static_page != FALSE)
        {
            $arr_static_page = $obj_static_page->toArray();

        }*/
        // dd($arr_static_page);   
        $this->arr_view_data['arr_static_page'] = $obj_static_page; 
        $this->arr_view_data['page_title']      = "Manage ".$this->module_title;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

    //    dd($this->arr_view_data);

       return view('admin.static_page.index',$this->arr_view_data);
    }

    public function create()
    {
        $this->arr_view_data['arr_lang']        = $this->LanguageService->get_all_language();
        $this->arr_view_data['page_title']     = "Create ".$this->module_title;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
       
        return view('admin.static_page.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $form_data = array();

        $user = Sentinel::check();

        $inputs = request()->validate([
            'page_title_en' =>'required',
            'meta_keyword_en'=>'required',
            'meta_desc_en'=>'required',
            'page_desc_en'=>'required'
            ]);
        
        $form_data = $request->all();

        $arr_data = array();
        $arr_data['page_slug'] = str_slug($request->input('page_title_en'));
        $arr_data['is_active'] = 1;            
      
        
        $static_page    = $this->BaseModel->create($arr_data);

        $static_page_id = $static_page->id;

        /* Fetch All Languages*/
        $arr_lang =  $this->LanguageService->get_all_language();

        if(sizeof($arr_lang) > 0 )
        {
            foreach ($arr_lang as $lang) 
            {            
                $arr_data     = array();
                $page_title   = 'page_title_'.$lang['locale'];
                $meta_keyword = 'meta_keyword_'.$lang['locale'];
                $meta_desc    = 'meta_desc_'.$lang['locale'];
                $page_desc    = 'page_desc_'.$lang['locale'];

                if( isset($form_data[$page_title]) && $form_data[$page_title] != '')
                { 
                    $translation = $static_page->translateOrNew($lang['locale']);

                    $translation->page_title      = $form_data[$page_title];
                    $translation->meta_keyword    = $form_data[$meta_keyword];
                    $translation->meta_desc       = $form_data[$meta_desc];
                    $translation->page_desc       = $form_data[$page_desc];
                    $translation->static_page_id  = $static_page_id;

                    $translation->save();
                    
                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      /*  $arr_event                 = [];
                        $arr_event['ACTION']       = 'ADD';
                        $arr_event['MODULE_TITLE'] = $this->module_title;

                        $this->save_activity($arr_event);*/
                    /*----------------------------------------------------------------------*/


                   
                    Flash::success($this->module_title .' created successfully');
                }

            }//foreach

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added cms page.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

            /*----------------------------------------------------------------------*/


        } //if
        else
        {
            Flash::success('Problem occurred, while creating '.$this->module_title);
        }

        return redirect($this->module_url_path);
    }



    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        
        $arr_lang = $this->LanguageService->get_all_language();      

        $obj_static_page = $this->BaseModel->where('id', $id)->with(['translations'])->first();

        $arr_static_page = [];

        if($obj_static_page)
        {
           $arr_static_page = $obj_static_page->toArray(); 
           /* Arrange Locale Wise */
           $arr_static_page['translations'] = $this->arrange_locale_wise($arr_static_page['translations']);
        }



        $this->arr_view_data['edit_mode'] = TRUE;
        $this->arr_view_data['enc_id']    = $enc_id;
        $this->arr_view_data['arr_lang']  = $this->LanguageService->get_all_language();
        
        $this->arr_view_data['arr_static_page'] = $arr_static_page;
        $this->arr_view_data['page_title']      = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
       
        return view('admin.static_page.edit',$this->arr_view_data);  

    }

    public function update(Request $request, $enc_id)
    {
        $user = Sentinel::check();

        $id        = base64_decode($enc_id);
        /*Check validations*/
        
        $inputs = request()->validate([
            'page_title_en' => 'required',
            'meta_keyword_en' => 'required',
            'meta_desc_en' => 'required',
            'page_desc_en' => 'required'
            ]);

        $form_data = array();
        $form_data = $request->all(); 

        $pageslug = isset($form_data['pageslug'])?$form_data['pageslug']:'';
         //url validation added if menu is chowcms


         if($pageslug=="chowcms")
         {
             $arr_lang = $this->LanguageService->get_all_language();
             $pages = $this->BaseModel->where('id',$id)->first();
             if(sizeof($arr_lang) > 0)
            { 
                foreach($arr_lang as $i => $lang)
               {
                   $title = 'page_title_'.$lang['locale'];
                   $translation = $pages->getTranslation($lang['locale']); 

                      if (filter_var($form_data['page_desc_'.$lang['locale']], FILTER_VALIDATE_URL) === FALSE) 
                      {
                           Flash::error('Please enter valid page URL');
                           return redirect()->back();
                      }
               }
            }
         }//if chowcms
         /***********************************************/

         /* Get All Active Languages */ 
  
        $arr_lang = $this->LanguageService->get_all_language();

        $pages = $this->BaseModel->where('id',$id)->first();

       // $menuinfooter=0;
        
         /* Insert Multi Lang Fields */

        if(sizeof($arr_lang) > 0)
        { 
            foreach($arr_lang as $i => $lang)
            {
                $translate_data_ary = array();
                $title = 'page_title_'.$lang['locale'];

                if(isset($form_data[$title]) && $form_data[$title]!="")
                {
                    /* Get Existing Language Entry */
                    $translation = $pages->getTranslation($lang['locale']);

                    if($translation)
                    {
                        // if(isset($form_data['menuin_footer_'.$lang['locale']]) && $form_data['menuin_footer_'.$lang['locale']]==1)
                        // {
                        //     $menuinfooter =$form_data['menuin_footer_'.$lang['locale']];
                        // }else{
                        //     $menuinfooter=0;
                        // }

                        $translation->page_title    =  $form_data['page_title_'.$lang['locale']];
                        $translation->meta_keyword  =  $form_data['meta_keyword_'.$lang['locale']];
                        $translation->meta_desc     =  $form_data['meta_desc_'.$lang['locale']];
                        $translation->page_desc     =  $form_data['page_desc_'.$lang['locale']];

                        $t = time();
                        
                        $translation->updated_at     =  date("Y-m-d",$t);

                       // $translation->menuin_footer = $menuinfooter;
                        $translation->save();    
                    }  
                    else
                    {
                        //  if(isset($form_data['menuin_footer_'.$lang['locale']]) && $form_data['menuin_footer_'.$lang['locale']]==1)
                        // {
                        //     $menuinfooter =$form_data['menuin_footer_'.$lang['locale']];
                        // }else{
                        //     $menuinfooter=0;
                        // }
                        /* Create New Language Entry  */
                        $translation     = $pages->getNewTranslation($lang['locale']);

                        $translation->static_page_id =  $id;
                        $translation->page_title   =  $form_data['page_title_'.$lang['locale']];
                        $translation->meta_keyword =  $form_data['meta_keyword_'.$lang['locale']];
                        $translation->meta_desc =  $form_data['meta_desc_'.$lang['locale']];
                        $translation->page_desc =  $form_data['page_desc_'.$lang['locale']];
                       // $translation->menuin_footer = $menuinfooter;
                        $translation->save();
                    } 
                }   
            }
            
        }

        /*-------------------------------------------------------
        |   Activity log Event
        --------------------------------------------------------*/
           /* $arr_event                 = [];
            $arr_event['ACTION']       = 'EDIT';
            $arr_event['MODULE_TITLE'] = $this->module_title;

            $this->save_activity($arr_event);*/
        /*----------------------------------------------------------------------*/

         /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
            //save sub admin activity log 

            $page_title = $this->StaticPageTranslationModel->where('static_page_id',$id)->pluck('page_title')->first();

            if(isset($user) && $user->inRole('sub_admin'))
            {
                $arr_event                 = [];
                $arr_event['action']       = 'EDIT';
                $arr_event['title']        = $this->module_title;
                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated cms page '.$page_title.'.';

                $result = $this->UserService->save_activity($arr_event); 
            }

            /*----------------------------------------------------------------------*/

        Flash::success($this->module_title.' updated successfully');
      
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
     
    public function perform_activate($id,$flag = false)
    {
        $user = Sentinel::check();

        $cms = $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);

        if($cms)
        { 
            $page_title = $this->StaticPageTranslationModel->where('static_page_id',$id)->pluck('page_title')->first();

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated cms page '.$page_title.'.';

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

    public function perform_deactivate($id,$flag=false)
    {
        $user = Sentinel::check();

        $cms = $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);
        
        if($cms)
        {
            $page_title = $this->StaticPageTranslationModel->where('static_page_id',$id)->pluck('page_title')->first();

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated cms page '.$page_title.'.';

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

        $entity = $this->BaseModel->where('id',$id)->first();
    
        if($entity)
        {
            $page_title = $this->StaticPageTranslationModel->where('static_page_id',$id)->pluck('page_title')->first();
           

            $this->BaseModel->where('id',$id)->delete();
            $this->StaticPageTranslationModel->where('static_page_id',$id)->delete();

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted cms page '.$page_title.'.';

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
               Flash::success('CMS deleted successfully'); 
            }   
            else if($multi_action=="deactivate")
            {           
               $flag = "activate";
               $this->perform_deactivate(base64_decode($record_id),$flag);    
               Flash::success('CMS deactivated successfully'); 
            }    
             
            else if($multi_action=="activate")
            {
                $flag = "deactivate";

               $this->perform_activate(base64_decode($record_id),$flag);    
               Flash::success('CMS activated successfully'); 
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on cms pages.';

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on cms pages.';

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on cms pages.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                /*----------------------------------------------------------------------*/
        }
        return redirect()->back();
    }

}