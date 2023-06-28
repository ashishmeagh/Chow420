<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\SubAdminActivityModel;

use App\Common\Services\UserService;

use Validator;
use Flash;
use Sentinel;
use Hash;
 
class AccountSettingsController extends Controller
{

    public function __construct(
                                
                                UserModel $user,
                                ActivityLogsModel $activity_logs,
                                SubAdminActivityModel $SubAdminActivityModel,
                                UserService $UserService
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;
        $this->ActivityLogsModel  = $activity_logs;
        $this->SubAdminActivityModel = $SubAdminActivityModel;
        $this->UserService        = $UserService;
        
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        $this->user_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->module_title       = "Account Settings";
        $this->module_view_folder = "admin.account_settings";
        
        $this->module_icon        = "fa-cogs";
    }


    public function index()
    {
        $arr_account_settings = array();

        $arr_data  = [];
        
        $obj_data  = Sentinel::getUser();
        
        if($obj_data)
        {
           $arr_data = $obj_data->toArray();    
        }

        if(isset($arr_data) && sizeof($arr_data)<=0)
        {
            return redirect($this->admin_url_path.'/login');
        }

        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['page_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function update(Request $request)
    {
        $arr_rules = array();
       
        $obj_data  = Sentinel::getUser();

        $first_name = $obj_data->first_name;
        $last_name  = $obj_data->last_name;

        $inputs = request()->validate([
                'first_name'=>'required|min:3',
                'last_name'=>'required',
                'email'=>'required|email'
                ]);

        if ($request->hasFile('image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $arr_response['status']       = 'FAILURE';
                $arr_response['description']  = 'Invalid image..Please try again';

               Flash::error('This file type is invalid, Allowed only jpg, png, jpeg image file type.');
                return redirect()->back();
            }

        }

        
        if($this->UserModel->where('email',$request->input('email'))
                           ->where('id','!=',$obj_data->id)
                           ->count()==1)
        {
            Flash::error('This email id already present in our system, please try another one.');
            return redirect()->back();
        }

        $file_name = "default.jpg";

        



        if ($request->hasFile('image')) 
        {
            $file_name = $request->input('image');
            $file_extension = strtolower($request->file('image')->getClientOriginalExtension()); 

            $file_name = sha1(uniqid().$file_name.uniqid()).'.'.$file_extension;
            $request->file('image')->move($this->user_base_img_path, $file_name);  
        }
        else
        {
            $file_name = $request->input('old_image');            
        }


       



        $arr_data['first_name']   = $request->input('first_name');
        $arr_data['last_name']    = $request->input('last_name');
        $arr_data['email']        = $request->input('email');
        $arr_data['profile_image']= $file_name;

        $obj_data = Sentinel::update($obj_data, $arr_data);
 

        if($obj_data)
        {
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
               /* $arr_event                 = [];
                $arr_event['ACTION']       = 'EDIT';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);*/
            

               //save sub admin activity log 

                if(isset($obj_data) && $obj_data->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'EDIT';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($obj_data->id)?$obj_data->id:'';
                    $arr_event['message']      = $first_name.' '.$last_name.' has updated his account settings information.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

              


            /*----------------------------------------------------------------------*/
            Flash::success('Account settings updated successfully.'); 
        }
        else
        {
            Flash::error('Problem occurred, while updating '.str_singular($this->module_title));  
        } 
      
        return redirect()->back();
    }
}
