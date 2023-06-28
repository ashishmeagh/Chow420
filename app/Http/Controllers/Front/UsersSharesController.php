<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\UsersSharesModel;

use Carbon\Carbon;
 


use App\Models\StaticPageTranslationModel;

use App\Common\Services\EmailService; 

use Sentinel;
use DB; 
use Datatables;
use Session;
use Activation;
 

use Illuminate\Support\Str;
 

class UsersSharesController extends Controller
{
     

    public function __construct(
                            UsersSharesModel $UsersSharesModel
                            
                        )
    {   
        $this->UsersSharesModel               = $UsersSharesModel;
       

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->slider_base_img_path   = base_path().config('app.project.img_path.slider_images');
        $this->slider_public_img_path = url('/').config('app.project.img_path.slider_images');
        $this->module_view_folder   = 'front.users_shares';  
        $this->arr_view_data        = [];
    }
   
           
    public function index()
    {


       
        return view($this->module_view_folder.'.index',$this->arr_view_data);
 
    }//end of function index 


    public function search_users_shares(Request $request)
    {
        $response['status'] = "warning";
        $response['description'] = "";
        $response['data'] = [];
        $form_data =  $request->all();

        $user_share_obj = $this->UsersSharesModel->select(
                                                    'email',
                                                    'first_name',
                                                    'shares_owned',
                                                    'price_per_share',
                                                    'percent_change',
                                                    'share_value',
                                                    'description'
                                                )
                                                ->where('email',$form_data['email'])
                                                ->first();

        if($user_share_obj !== null)
        {
            $arr_users_shares = $user_share_obj->toArray();  

            $response['status'] = "success";
            $response['description'] = "User shares found";
            $response['data'] = $arr_users_shares;
        }
        else
        {
            $response['status'] = "warning";
            $response['description'] = "Currently there are no shares information available for email <b>".$form_data['email']."</b>";

        }
        return response()->json($response);
        
        
    }//end of function index

    

}
