<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;
use App\Common\Services\UserService;

use App\Models\CountryModel;
use Validator;
use Session;
use App\Common\Services\LanguageService;
use Flash;
use Sentinel;

 
class CountryController extends Controller
{
    use MultiActionTrait;
    
    public function __construct(CountryModel $countries, 
                                LanguageService $langauge,
                                UserService $UserService
                               )
    {
        $this->CountryModel    = $countries;
        $this->LanguageService = $langauge;

        $this->BaseModel     = $this->CountryModel;
        $this->UserService   = $UserService;
        $this->arr_view_data = [];
        
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/countries");
        $this->module_title       = "Countries";
        $this->module_url_slug    = "countries";
        $this->module_view_folder = "admin.countries";
    }   


     /*
    | Index : Display listing of countries
    | auther : Paras Kale
    | Date : 05/11/2016
    | @return \Illuminate\Http\Response
    */ 
 
    public function index()
    {
        $arr_lang = array();
        $arr_data = array();

        $obj_data = $this->BaseModel->get();
        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data'] = $arr_data;

        $this->arr_view_data['page_title']      = "Manage ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }


    /*
    | Show() : Display detail information regarding specific country
    | auther : Paras Kale
    | Date : 05/11/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */

    public function show($enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_data = array();

        $obj_data = $this->BaseModel->where('id',$id)->first();

        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data'] = $arr_data;

        $this->arr_view_data['page_title']      = "View ".str_singular($this->module_title);;
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.show',$this->arr_view_data);
    }

    /*
    | create() : Show the form for creating a new resource.
    | auther : Paras Kale 
    | Date : 05/11/2016    
    | @param  \Illuminate\Http\Request  $request
    */
    
    public function create()
    {
        $this->arr_view_data['arr_lang'] = $this->LanguageService->get_all_language();  

        $this->arr_view_data['page_title']      = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $user = Sentinel::check();

        $form_data = array();

        /* English Required */
        
        $form_data = $request->all();

        /*Check Validations*/
        $inputs = request()->validate([
            'country_code'=>'required',
            'country_name_en'=>'required'
            ]);

        /* Check if country already exists with given translation */
        $does_exists = $this->BaseModel
                            ->whereHas('translations',function($query) use($request)
                                {
                                    $query->where('locale','en')
                                          ->where('country_name',$request->input('country_name_en'));      
                                })
                            ->count();   
        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists.');
            return redirect()->back();
        }

        /* Insert into Country Table */

        $arr_data = array();
        $arr_data['country_code'] =  $form_data['country_code'];

        $entity = $this->BaseModel->create($arr_data);


        if($entity)      
        {
            $arr_lang =  $this->LanguageService->get_all_language();      
         
            /* insert record into translation table */
            if(sizeof($arr_lang) > 0 )
            {
                foreach ($arr_lang as $lang) 
                {        
                    $arr_data     = array();
                    $country_name = 'country_name_'.$lang['locale'];

                    if( isset($form_data[$country_name]) && $form_data[$country_name] != '')
                    { 
                        $translation = $entity->translateOrNew($lang['locale']);

                        $translation->country_id    = $entity->id;
                        $translation->country_name  = $form_data[$country_name];

                        $translation->save();

                        Flash::success(str_singular($this->module_title).' Created Successfully');
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added country.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

             
                /*----------------------------------------------------------------------*/


            } //if
            else
            {
                Flash::error('Problem Occurred, While Creating '.str_singular($this->module_title));
            }
        }
        else
        {
            Flash::error('Problem Occurred, While Creating '.str_singular($this->module_title));
        }

        return redirect()->back();
    }


     /*
    | Show() : Show the form for editing the specified page.
    | auther : Paras Kale
    | Date   : 05/11/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id); 

        $obj_data = $this->BaseModel->where('id', $id)->with(['translations'])->first();

        $arr_data = [];
        if($obj_data)
        {
           $arr_data = $obj_data->toArray(); 

           /* Arrange Locale Wise */
           $arr_data['translations'] = $this->arrange_locale_wise($arr_data['translations']);
        }

        $this->arr_view_data['edit_mode'] = TRUE;
        $this->arr_view_data['enc_id']    = $enc_id;
        $this->arr_view_data['arr_lang']  = $this->LanguageService->get_all_language();
        
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['page_title']      = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.edit',$this->arr_view_data);    
    }


    /*
    | update() : Update the specified resource/record
    | auther   : Paras Kale
    | Date     : 05/11/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */

    public function update(Request $request, $enc_id)
    {
        $id   = base64_decode($enc_id);
        $user = Sentinel::check();

        /*Check Validations*/
        $inputs =request()->validate([
            'country_name_en'=>'required',
            'country_code'=>'required'
            ]);

        $form_data = array();
        $form_data = $request->all();    

        /* Get All Active Languages */ 
  
        $arr_lang = $this->LanguageService->get_all_language();  

        /* Retrieve Existing Model*/
        $entity = $this->BaseModel->where('id',$id)->first();
        if(!$entity)
        {
            Flash::error('Problem Occured While Retriving '.str_singular($this->module_title));
            return redirect()->back();   
        }

        /* Check if category already exists with given translation */
        $does_exists = $this->BaseModel
                            ->where('id','<>',$id)
                            ->whereHas('translations',function($query) use($request)
                                        {
                                            $query->where('locale','en')
                                                  ->where('country_name',$request->input('country_name_en'));      
                                        })
                            ->count()>0;   
        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists');
            return redirect()->back();
        }
        
        $cloned_entity = clone $entity ;
        
        /* Update Country */   
        $arr_data = [];     
        $arr_data['country_code'] = $request->input('country_code');

        $cloned_entity->update($arr_data);

        /* Insert Multi Lang Fields */

        if(sizeof($arr_lang) > 0)
        { 
            foreach($arr_lang as $i => $lang)
            {
                $country_name = $request->input('country_name_'.$lang['locale']);
                if(isset($country_name) && $country_name!="")
                {
                    /* Get Existing Language Entry */
                    $translation = $entity->getTranslation($lang['locale']);    
                    if($translation)
                    {
                        $translation->country_name =  $country_name;
                        $translation->save();    
                    }  
                    else
                    {
                        /* Create New Language Entry  */
                        $translation = $entity->getNewTranslation($lang['locale']);
                        $translation->country_id =  $id;
                        $translation->country_name =  $request->input('country_name_'.$lang['locale']);
                        $translation->save();
                    } 
                }   
            }
            
        }

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
            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated country.';

            $result = $this->UserService->save_activity($arr_event); 
        }
   
        /*----------------------------------------------------------------------*/

        Flash::success(str_singular($this->module_title).' Updated Successfully');

        return redirect()->back(); 

    }

    public function multi_action(Request $request)
    {
        $user = Sentinel::check();

        $arr_rules = array();
        $arr_rules['multi_action']   = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
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
            if($multi_action == "delete")
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete on country.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate on country.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate on country.';

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

    public function perform_activate($id)
    {
        $user = Sentinel::check();

        $activate = $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        
        if($activate)
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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated country.';

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

        $deactivate     = $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);
        
        if($deactivate)
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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated country.';

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
    
}
