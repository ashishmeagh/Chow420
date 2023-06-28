<?php

namespace App\Common\Services;

use App\Models\SiteSettingModel;

use \Session;
use \Mail;

class CommisionService
{
	public function __construct(
					//SiteSettingModel $SiteSettingModel
				    )
	{
		//$this->SiteSettingModel  = $this->SiteSettingModel;
	}

	public function get_commision()
	{
		
        $site_setting_arr = [];
        $commision_arr = [];
        $site_setting_obj = SiteSettingModel::first();  
        if(isset($site_setting_obj))
        {
            $site_setting_arr = $site_setting_obj->toArray();  
            if(isset($site_setting_arr) && count($site_setting_arr)>0)
           {
                $admin_commission = $site_setting_arr['admin_commission'];
                $seller_commission = $site_setting_arr['seller_commission'];

                $commision_arr['admin_commission']  = isset($admin_commission)?$admin_commission:'13';
                $commision_arr['seller_commission'] = isset($seller_commission)?$seller_commission:'87';
                return $commision_arr;
                

           }else{
           	return false;
           }
        }else{
        	return false;
        }
	}//end of function of get commision 


}

?>