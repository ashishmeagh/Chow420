<?php

namespace App\Http\Middleware\Admin;

use App\Models\SiteSettingModel;
use App\Models\ModuleSubAdminMappingModel;
use Closure;
use Session;
use Sentinel;
use Request;

class GeneralMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        Session::put('locale','en');

        $user = Sentinel::check();
        $data_arr = [];
        if($user)
        {
            if($user->inRole('sub_admin'))
            {  
                $assigned_module_arr = ModuleSubAdminMappingModel::where('user_id',$user->id)
                                                                  ->with(['module_details'])
                                                                  ->get()->toArray();

               
                if(isset($assigned_module_arr) && count($assigned_module_arr)>0)
                {
                    
                    foreach($assigned_module_arr as $key => $value) 
                    {
                        $data_arr[$key] = trim($value['module_details']['module_slug']);                                                   
                    }  
                   
                } 

                //$assign_module = array_column($assigned_module_arr['module_details'],'module_slug');                                                   
            } 
        }
        
        /*-----------------check sub admin module permission-------------------------------------*/

        $segment = Request::segment(2);

        if(isset($user) && $user!=false && $user->inRole('sub_admin'))
        { 
            
            if(in_array("change_password",$data_arr) && $segment == "update_password") 
            {
               return $next($request); 
            }

            if(in_array("sellers",$data_arr) && $segment == "seller_membership_history")
            { 

                view()->share('admin_panel_slug',config('app.project.admin_panel_slug'));
                view()->share('assigned_module_arr',$data_arr);
                return $next($request);
            }

            if($segment == 'logout')
            {
                return $next($request); 
            }

            if(!in_array($segment,$data_arr))
            {
               return response(view('errors.403'));
            }
            
        }
       

         
        /*---------------------------------------------------------------------------------------*/

        view()->share('admin_panel_slug',config('app.project.admin_panel_slug'));
        view()->share('assigned_module_arr',$data_arr);

      
        
        
        return $next($request); 
    }
}
