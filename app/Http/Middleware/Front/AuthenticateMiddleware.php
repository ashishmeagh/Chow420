<?php

namespace App\Http\Middleware\Front;

use Closure;
use Sentinel;
use Session;

use App\Models\SellerModel;
use App\Models\BuyerModel;
use App\Models\SiteSettingModel;


class AuthenticateMiddleware
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

        
        $arr_except[] =  '';
        $arr_except[] =  'login';
        $arr_except[] =  'get_states';
        $arr_except[] =  'process_login';
        $arr_except[] =  'signup';
        $arr_except[] =  'set_guest_url';
        $arr_except[] =  'signup_seller';
        $arr_except[] =  'process_signup';
        $arr_except[] =  'activate_account';
        $arr_except[] =  'forgot_password';        
        $arr_except[] =  'reset_password';  
        $arr_except[] =  'process_reset_password';
        $arr_except[] =  'does_emailid_exist';
        //$arr_except[] =  'otp_verify';   
        $arr_except[] =  'listing';
        //$arr_except[] =  'get_trade_list_for_buyer';
        $arr_except[] =  'contact_us';
        //$arr_except[] =  'save_session';
        $arr_except[] =  'page';
        //$arr_except[] =  'CashMarkets';
        //$arr_except[] =  'CashMarkets/get_crypto_trades_records';
        //$arr_except[] =  'customize_request';
        //$arr_except[] =  'customize_request/store';
        //$arr_except[] =  'process_otp_verification';
        $arr_except[] =  'logout';
        $arr_except[] =  'forum';
        $arr_except[] =  'forum/view_post';
        $arr_except[] =  'forum/view_post/load_post_comments';
        $arr_except[] =  'refer';

        
        $request_path = $request->route()->getCompiled()->getStaticPrefix();
        $request_path = substr($request_path,1,strlen($request_path));

        if(!in_array($request_path, $arr_except))
        {
            $user = Sentinel::check();
            
            if($user && $user->is_active == '1')
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
                Sentinel::logout();
                \Session::flush();
                return redirect('/');
            }            
        }
        else
        {
            return $next($request); 
        }
    }
}
