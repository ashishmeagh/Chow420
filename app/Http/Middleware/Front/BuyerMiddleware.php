<?php

namespace App\Http\Middleware\Front;

use Closure;
use Sentinel;
use Session;

use App\Models\SellerModel;
use App\Models\BuyerModel;
use App\Models\SiteSettingModel;


class BuyerMiddleware
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
        /***************new**cond added for site status****/
        $site_setting_obj = SiteSettingModel::first();
        
        if($site_setting_obj)
        {
            $site_setting_arr = $site_setting_obj->toArray();            
        }

        if($site_setting_arr['site_status'] == '0')
        {
            return response(view('errors.503'));
        }
        /****************************************/


        $user = Sentinel::check();

        if($user)
        {   
            if($user->inRole('buyer'))
            {
               
                    /*********************code for seller and buyer details**********/
                   /* if(\Sentinel::check())
                    {   
                            $user = \Sentinel::check();
                            $user_id = $user['id'];
                               
                          
                            if($user->inRole('seller') == true)
                            {
                               $get_seller_detail_arr =[];
                               $get_seller_detail = SellerModel::where('user_id',$user_id)->first();
                               if(!empty($get_seller_detail)){
                                $get_seller_detail = $get_seller_detail->toArray();
                               }
                            }
                            else if($user->inRole('buyer') == true)
                            {
                               $get_buyer_detail_arr = [];
                               $get_buyer_detail = BuyerModel::where('user_id',$user_id)->first();
                               if(!empty($get_buyer_detail) && isset($get_buyer_detail)){
                                $get_buyer_detail = $get_buyer_detail->toArray();
                               }
                            } 
                     }
                     $get_seller_detail_arr = isset($get_seller_detail)?$get_seller_detail:[];
                     $get_buyer_detail_arr = isset($get_buyer_detail)?$get_buyer_detail:[];

                     view()->share('buyer_arr',$get_buyer_detail_arr);
                      view()->share('seller_arr',$get_seller_detail_arr);*/

                    /******************end of*code for seller and buyer details**********/
  




                return $next($request);
               
                
            }
            else
            {
                return redirect('/');
            }

            
        }
        else
        {
            return redirect('/');
        }

    }
}
