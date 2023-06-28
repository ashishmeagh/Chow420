<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use Illuminate\Http\Request;
use Session;
use Validator;
use App\Common\Services\LanguageService;
use App\Common\Traits\MultiActionTrait;
use App\Common\Services\UserService;
use Flash;
use Sentinel;
 
class CityController extends Controller
{
    use MultiActionTrait;
    public function __construct(CountryModel $countries,
                                StateModel $state,
                                CityModel $city,
                                LanguageService $langauge,
                                UserService $UserService
                                )
    {
        $this->CountryModel       = $countries;
        $this->StateModel         = $state;
        $this->CityModel          = $city;
        $this->LanguageService    = $langauge;
        $this->UserService        = $UserService;
        
        $this->BaseModel          = $this->CityModel;

        $this->arr_view_data      = [];
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/cities");
        $this->module_title       = "Cities";
        $this->module_url_slug    = "cities";
        $this->module_view_folder = "admin.cities";
    }


    public function index ()
    {
        $this->arr_view_data['arr_data'] = array();
        $obj_data = $this->BaseModel->with(['country_details','state_details'])->get();
       
        $arr_lang =  $this->LanguageService->get_all_language();

        if(sizeof($obj_data)>0)
        {
            foreach ($obj_data as $key => $data) 
            {
                $arr_tmp = array();
                /* Check Language Wise Transalation Exists*/
                foreach ($arr_lang as $key => $lang) 
                {
                    
                    $arr_tmp[$key]['title'] = $lang['title'];
                    $arr_tmp[$key]['is_avail'] = $data->hasTranslation($lang['locale']);
                }    

                $data->arr_translation_status = $arr_tmp;

                /* Call to hasTranslation method of object is triggering translations so need to unset it */
                unset($data->translations);
            }   

            $this->arr_view_data['arr_data'] = $obj_data->toArray();
        }


        $this->arr_view_data['page_title']      = "Manage ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_lang']        = $arr_lang;
        
        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }

    public function show($enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_data = array();

        $obj_data = $this->BaseModel->where('id',$id)->with(['country_details','state_details'])->first();
        if( $obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['page_title']      = "Show ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.show', $this->arr_view_data);
    }


    
    public function create()
    {
        $arr_country = array();

        /* Build Country Module */
        $obj_country = $this->CountryModel->where('is_active',1)->get();

        if( $obj_country != FALSE)
        {
            $arr_country = $obj_country->toArray();
        }

        $arr_default = [0 => "Select"];

        $this->arr_view_data['arr_country'] = $this->build_select_options_array($arr_country,'id','country_name',$arr_default);

        /* Build State Module */
        $obj_state    = $this->StateModel->where('is_active',1)->get();
        if( $obj_state != FALSE)
        {
            $arr_state = $obj_state->toArray();
        }
       
        $this->arr_view_data['arr_state'] = $this->build_select_options_array($arr_state,'id','state_title',$arr_default);

        $this->arr_view_data['arr_lang']        = $this->LanguageService->get_all_language();
        $this->arr_view_data['page_title']      = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create', $this->arr_view_data);
    }

    // public function store(Request $request)
    // {  
    //     $form_data  = array();

    //     /*Check Validations*/
    //     $inputs = request()->validate([
    //         'country_id'=>'required',
    //         'state_id'=>'required',
    //         'city_title_en'=>'required'
    //         ]);

    //     $form_data = $request->all(); 

    //     $arr_data['public_key'] = str_random(7); 
    //     $arr_data['country_id'] = $request->input('country_id');       
    //     $arr_data['state_id']   = $request->input('state_id');

    //     $does_exists = $this->BaseModel->where('country_id', $request->input('country_id'))
    //                         ->where('state_id', $request->input('state_id'))
    //                         ->whereHas('translations',function($query) use($request)
    //                         {
    //                             $query->where('locale', 'en')
    //                                   ->where('city_title',$request->input('city_title_en'));
    //                         })
    //                         ->count();

    //     if($does_exists)
    //     {
    //         Flash::error(str_singular($this->module_title).' Already Exists.');
    //         return redirect()->back();
    //     }
    //     else
    //     {
    //         $entity = $this->BaseModel->create($arr_data);
    //         if($entity)            
    //         {  
    //             $arr_lang =  $this->LanguageService->get_all_language();
                                                             
    //             if(sizeof($arr_lang) > 0 )
    //             {
    //                 foreach ($arr_lang as $lang) 
    //                 {            
    //                     $arr_data = array();

    //                     $city_title = $request->input('city_title_'.$lang['locale']);
                       

    //                     if( isset($city_title) && $city_title != "")
    //                     { 
    //                         $translation = $entity->translateOrNew($lang['locale']);
    //                         $translation->city_id     = $entity->id;
    //                         $translation->city_title  = $city_title;
    //                         $translation->city_slug   = str_slug($city_title, "-");
    //                         $translation->save();

    //                         Flash::success(str_singular($this->module_title).' Created Successfully');
    //                     }
    //                 }//foreach
    //             } //if
    //             else
    //             {
    //                 Flash::error('Problem Occurred, While Creating '.str_singular($this->module_title));
    //             }
    //         }
    //         else
    //         {
    //             Flash::error('Problem Occurred, While Creating '.str_singular($this->module_title));
    //         }
    //     }
    //    return redirect()->back();
    // }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_data = array();

        $obj_data = $this->BaseModel
                           ->where('id',$id)
                           ->with(['country_details','state_details','translations'])
                           ->first();

        if($obj_data)
        {
           $arr_data = $obj_data->toArray();
           /* Arrange Locale Wise */
           $arr_data['translations'] = $this->arrange_locale_wise($arr_data['translations']);
        }
       
        $arr_lang =  $this->LanguageService->get_all_language();


        $this->arr_view_data['edit_mode']       = TRUE;
        $this->arr_view_data['enc_id']          = $enc_id;
        $this->arr_view_data['arr_lang']        = $this->LanguageService->get_all_language();
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['page_title']      = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.edit', $this->arr_view_data);    
    }

    // public function update(Request $request, $enc_id)
    // {
    //     $id = base64_decode($enc_id);

    //     /*Check Validations*/
    //     $inputs = request()->validate([
    //         'city_title_en'=>'required'
    //         ]);

    //     $form_data = array();
    //     $form_data = $request->all();    
        
    //     $arr_data = array();

    //     $arr_lang = $this->LanguageService->get_all_language();  
  
    //     $entity = $this->BaseModel->where('id',$id)->first();

    //     if(!$entity)
    //     {
    //         Flash::error('Problem Occured While Retriving '.str_singular($this->module_title));
    //         return redirect()->back();   
    //     }
    //     /* Check if category already exists with given translation */
    //     $does_exists = $this->BaseModel
    //                         ->where('id','<>',$id)
    //                         ->whereHas('translations',function($query) use($request)
    //                                     {
    //                                         $query->where('locale','en')
    //                                               ->where('city_title',$request->input('city_title_en'));      
    //                                     })
    //                         ->count();   
    //     if($does_exists)
    //     {
    //         Flash::error(str_singular($this->module_title).' Already Exists');
    //         return redirect()->back();
    //     }

    //     if(sizeof($arr_lang) > 0)
    //     { 
    //         foreach($arr_lang as $i => $lang)
    //         {
    //             $city_title = $request->input('city_title_'.$lang['locale']);

    //             if( isset($city_title) && $city_title!="")
    //             {
    //                 /* Get Existing Language Entry */
    //                 $translation = $entity->getTranslation($lang['locale']);    

    //                 if($translation)
    //                 {
    //                     $translation->city_title =  $city_title;
    //                     $translation->city_slug   = str_slug($city_title, "-");
    //                     $translation->save();    
    //                 }  
    //                 else
    //                 {
    //                     /* Create New Language Entry  */
    //                     $translation = $entity->getNewTranslation($lang['locale']);
                        
    //                     $translation->city_id    =  $id;
    //                     $translation->city_title =  $city_title;
    //                     $translation->city_slug  =  str_slug($city_title, "-");
    //                     $translation->save();    
    //                 } 
    //             }   
    //         }
    //     }    

    //     Flash::success(str_singular($this->module_title).' Updated Successfully');
    //     return redirect()->back(); 
    // }

    public function save(Request $request)
    {
        $user = Sentinel::check();


        $is_update = false;

        $city_id = base64_decode($request->input('city_id',false));

        if($request->has('city_id'))
        {
            $is_update = true;
        }

        $arr_rules= [
                        'country_id'=>'required',
                        'state_id'=>'required',
                        'city_title_en'=>'required'
                    ];

        $validator = Validator::make($request->all(),$arr_rules,[
                         'country_id.required'    =>  'Please Select Country.', 
                         'state_id.required'      =>  'Please Select State.', 
                         'city_title_en.required' =>  'Enter City Name.',
                      ]);

        $form_data = $request->all();

        $is_duplicate = $this->BaseModel->where('state_id', $request->input('state_id'))
                            ->whereHas('translations',function($query) use($request)
                            {
                                $query->where('locale', 'en')
                                      ->where('city_title',$request->input('city_title_en'));
                            });

       if($is_update)
        {
            $is_duplicate= $is_duplicate->where('id','<>',$city_id);
        }

        $does_exists = $is_duplicate->count();

        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists.');
            return redirect()->back()->withInput($request->all());
        }

        $city_data =  $this->CityModel->firstOrNew(['id' => $city_id]);

        $city_data->country_id   =  $form_data['country_id'];
        $city_data->state_id     =  $form_data['state_id'];
        $city_details            = $city_data->save();

        if($city_data)
         {  
            $arr_lang =  $this->LanguageService->get_all_language();

            if(sizeof($arr_lang) > 0 )
            {
                foreach ($arr_lang as $lang) 
                {   
                    $arr_data = array();

                    $city_title = $request->input('city_title_'.$lang['locale']);

                    if( isset($city_title) && $city_title != "")
                    { 
                       $translation = $city_data->translateOrNew($lang['locale']);
                       $translation->city_id     = $city_data->id;

                       if($is_update != false)
                       {
                         $translation = $city_data->getTranslation($lang['locale']);   
                       }

                        if($translation)
                        {
                            $translation->city_title   = $city_title;
                            $translation->city_slug   = str_slug($city_title, "-");
                            $translation->save();
                        }
                        else
                        {
                            /* Create New Language Entry  */
                            $translation = $city_data->getNewTranslation($lang['locale']);
                            
                            $translation->city_id    =  $city_id;
                            $translation->city_title =  $city_title;
                            $translation->city_slug  =  str_slug($city_title, "-");
                            $translation->save();    
                        } 

                        if($is_update == false)
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
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added city '.$translation->city_title.'.';

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
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated city '.$translation->city_title.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                              


                            /*----------------------------------------------------------------------*/ 
                        }

                        
                        
                        Flash::success(str_singular($this->module_title).' Save Successfully');  
                    }
                }//foreach
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated city.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated city.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted city.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

            /*----------------------------------------------------------------------*/

            Flash::success(str_singular($this->module_title).' Deleted Successfully');
        }
        else
        {
            Flash::error('Problem Occured While '.str_singular($this->module_title).' Deletion ');
        }

        return redirect()->back();
    }

    public function perform_delete($id)
    {
        $entity = $this->BaseModel->where('id',$id)->first();
        if($entity)
        {
            return $entity->delete();
        }

        return FALSE;
    }

    public function build_select_options_array(array $arr_data,$option_key,$option_value,array $arr_default)
    {

        $arr_options = [];
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on cities.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on cities.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on cities.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

               /*----------------------------------------------------------------------*/


               $this->perform_deactivate(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Blocked Successfully');  
            }
        }

        return redirect()->back();
    }
    
}
