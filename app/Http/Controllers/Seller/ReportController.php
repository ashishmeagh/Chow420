<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\CountriesModel;
use App\Models\SellerModel;

use Validator;
use Flash;
use Sentinel;
use Hash;
 
class ReportController extends Controller
{

    public function __construct(
                                
                                UserModel $user,
                                CountriesModel $CountriesModel,
                                SellerModel $SellerModel,
                                ActivityLogsModel $activity_logs
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;
        $this->ActivityLogsModel  = $activity_logs;
        $this->CountriesModel     = $CountriesModel;
        $this->SellerModel        = $SellerModel;
        
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        $this->profile_img_public_path = url('/').config('app.project.img_path.user_profile_image');
        $this->profile_img_base_path   = base_path().config('app.project.img_path.user_profile_image');

        $this->module_title       = "Notifications";
        $this->module_view_folder = "seller/report";

        $this->id_proof_public_path = url('/').config('app.project.id_proof');
        $this->id_proof_base_path   = base_path().config('app.project.id_proof');
        
        $this->module_icon        = "fa-cogs";
    }


    public function index()
    {
        $buyer_arr = $seller_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

        $countries_arr = $this->CountriesModel->get()->toArray();

        if($user_details->inRole('seller'))
        {
            $seller_obj = $this->SellerModel->where('user_id',$user_details->id)->first();

            if($seller_obj)
            {
                $seller_arr = $seller_obj->toArray();
                $user_details_arr['user_details']  = $seller_arr;
            }
        }

        $this->arr_view_data['id_proof_public_path'] = $this->id_proof_public_path;
        $this->arr_view_data['profile_img_path']     = $this->profile_img_public_path;
        $this->arr_view_data['user_details_arr']     = $user_details_arr;
        $this->arr_view_data['countries_arr']        = $countries_arr;
        $this->arr_view_data['page_title']           = 'Notifications';
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

}
