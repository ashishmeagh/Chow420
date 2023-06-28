<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ContactEnquiryModel;
use App\Models\SiteSettingModel;
use App\Models\StaticPageModel;
use App\Models\StaticPageTranslationModel;
use App\Models\StatesModel;

use Validator;
use DB;

class AboutUsController extends Controller
{
    	
    public function __construct(
                                 ContactEnquiryModel $ContactEnquiryModel,
                                 SiteSettingModel $SiteSettingModel,
                                 StaticPageModel $StaticPageModel,
                                 StaticPageTranslationModel $StaticPageTranslationModel,
                                 StatesModel $StatesModel
                               )
    {
        $this->ContactEnquiryModel = $ContactEnquiryModel;
    	$this->SiteSettingModel    = $SiteSettingModel;
        $this->StaticPageModel     = $StaticPageModel;
        $this->StaticPageTranslationModel         = $StaticPageTranslationModel;
        $this->StatesModel         = $StatesModel;


    	$this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }

	public function index(Request $request)
	{	
        $view='';
        
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

        $states_obj = $this->StatesModel->where('country_id', 231)
            ->get();
        if ($states_obj) {
            $states_arr = $states_obj->toArray();

            $this->arr_view_data['states_arr']         = $states_arr;
        }

        if($page_slug=="about-us") 
        $view = '.aboutus';
        else if($page_slug=="contact-us")
        $view = '.contact_us';
        else if($page_slug=="terms-conditions")    
        $view = '.terms';
        else if($page_slug=="privacy-policy")    
        $view = '.privacy';     
        else if($page_slug=="services")    
        $view = '.services';  
        else if($page_slug=="seller-policy")    
        $view = '.sellerpolicy';     
        else if($page_slug=="refund-policy")    
        $view = '.cookiepolicy';
        else if($page_slug=="cbd-101")    
        $view = '.cbd101';
        else if($page_slug=="is-cbd-legal")  
        $view = '.is_cbd_legal';
        else if($page_slug=="cashback")    
        $view = '.cashback';
      


        // dd($this->arr_view_data);
		return view($this->module_view_folder.$view,$this->arr_view_data);
	}

  	
}
