<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ContactEnquiryModel;
use App\Models\SiteSettingModel;
use App\Models\StaticPageModel;
use App\Models\StaticPageTranslationModel;

use Validator;
use DB;

class ContactUsController extends Controller
{
    	
    public function __construct(
                                 ContactEnquiryModel $ContactEnquiryModel,
                                 SiteSettingModel $SiteSettingModel
                               )
    {
        $this->ContactEnquiryModel = $ContactEnquiryModel;
    	$this->SiteSettingModel    = $SiteSettingModel;

    	$this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }

	public function index()
	{	
        $page_slug =  request()->segment(1); 
        $arr_site_settings  = [];
        $obj_site_settings  = $this->SiteSettingModel
                                   ->where('site_setting_id','1')
                                   ->first();

        if($obj_site_settings)
        {
            $arr_site_settings = $obj_site_settings->toArray();
        }
        
        $this->arr_view_data['arr_site_settings'] = isset($arr_site_settings)?$arr_site_settings:[];
        
        // return view($this->module_view_folder.'.contact_us',$this->arr_view_data);
         $staticmodel = new StaticPageModel();
        $staticpagemodel = new StaticPageTranslationModel();


        /************************** code for static cms page content*******************************/
        $staticpage_details           = $staticmodel->getTable();        
        $prefixed_staticpage_details  = DB::getTablePrefix().$staticmodel->getTable();

        $statictransalation_details   = $staticpagemodel->getTable();
        $prefixed_statictrans_details = DB::getTablePrefix().$staticpagemodel->getTable();

        $obj_static_page = DB::table($staticpage_details)
                            ->select(DB::raw($staticpage_details.'.*,'.$prefixed_statictrans_details.'.*'))
                            ->where($staticpage_details.'.is_active','1')
                             ->where($staticpage_details.'.page_slug',$page_slug)
                            ->leftjoin($prefixed_statictrans_details,$prefixed_statictrans_details.'.static_page_id',"=",$prefixed_staticpage_details.'.id')
                            ->get()->toArray();
        
        $this->arr_view_data['res_cms'] = isset($obj_static_page)?$obj_static_page:[];  

        if($page_slug=="about-us") 
        $view = '.aboutus';
        // else if($page_slug=="contact-us")
        // $view = '.contact_us';
        // else if($page_slug=="faqs")
        // $view = '.contact_us';
   
        else if($page_slug=="terms-conditions")    
        $view = '.terms';
        else if($page_slug=="privacy-policy")    
        $view = '.privacy';     
        else if($page_slug=="chowpods")    
        $view = '.chowpods';     

        // dd($this->arr_view_data);
		return view($this->module_view_folder.$view,$this->arr_view_data);

	}

	public function store(Request $request)
	{
		$form_data = $request->all();

		$arr_rules = [
                       'user_name' => 'required',
                       'phone' 	   => 'required',
                       'email'     => 'required',
                       'message'   => 'required',
                     ];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Form Validation Failed..Please Check All Fields..';

            return response()->json($response);
        }

        $user_name  = isset($form_data['user_name'])?$form_data['user_name']:'';
        $phone	    = isset($form_data['phone'])?$form_data['phone']:'';
        $email 		= isset($form_data['email'])?$form_data['email']:'';
        $message    = isset($form_data['message'])?$form_data['message']:'';

        $input_data = [
        				'user_name' => $user_name,
        				'phone' 	=> $phone,
        				'email' 	=> $email,
        				'comments' 	=> $message
    				  ];
        $send_enquiry = $this->ContactEnquiryModel->create($input_data);

        if($send_enquiry)
        {
        	$response['status'] 	 = 'SUCCESS';
        	$response['description'] = 'Contact enquiry send successfully.';
        }
        else
        {
        	$response['status']      = 'ERROR';
        	$response['description'] = 'Unable to send enquiry...Please try again.';
        }

        return response()->json($response);
	}

}
