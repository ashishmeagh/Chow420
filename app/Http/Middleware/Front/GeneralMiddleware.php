<?php

namespace App\Http\Middleware\Front;

use Closure;
use App\Models\SiteSettingModel;
use App\Models\GeneralSettingsModel;
use App\Models\StaticPageModel;

use App\Models\FavoriteModel;
use App\Models\TempBagModel;
use App\Models\SellerModel;
use App\Models\BuyerModel;

use App\Models\FirstLevelCategoryModel;
use App\Models\SpectrumModel;
use App\Models\ReportedEffectsModel;
use App\Models\BuyerWalletModel;
use App\Models\CannabinoidsModel;

use Session;
use Sentinel;
use Flash;

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
        $g_fa_data = [];

        $google2fa  = app('pragmarx.google2fa');
        $user       = \Sentinel::check();

        $site_setting_obj = SiteSettingModel::first();
        
        if($site_setting_obj)
        {
            $site_setting_arr = $site_setting_obj->toArray();            
        }

        //below cond commented
       /* if($site_setting_arr['site_status'] == '0')
        {
            return response(view('errors.503'));
        }*/


          /**************new*code*for*site*status****************/  
      
            $admin_path = config('app.project.admin_panel_slug');
            $arr_except[] =  $admin_path;
            $arr_except[] =  $admin_path.'/login';
            $arr_except[] =  $admin_path.'/process_login';
            $arr_except[] =  $admin_path.'/forgot_password';
            $arr_except[] =  $admin_path.'/process_forgot_password';
            $arr_except[] =  $admin_path.'/validate_admin_reset_password_link';
            $arr_except[] =  $admin_path.'/reset_password';
            $request_path = $request->route()->getCompiled()->getStaticPrefix();
            $request_path = substr($request_path,1,strlen($request_path));

          if(\Sentinel::check())
            {   
                 $user = \Sentinel::check();                  
                if($user->inRole('seller') == true)
                {
                    if($site_setting_arr['site_status'] == '0')
                    {
                        return response(view('errors.503'));
                    }
                }
                 if($user->inRole('buyer') == true)
                {
                    if($site_setting_arr['site_status'] == '0')
                    {
                        return response(view('errors.503'));
                    }
                }
                 if($user->inRole('admin') == true)
                {
                    if($site_setting_arr['site_status'] == '0')
                    {
                       // return response(view('errors.503'));
                    }
                }
            }else{
                if(!in_array($request_path, $arr_except))
                {
                   if($site_setting_arr['site_status'] == '0')
                    {
                        return response(view('errors.503'));
                    }
                }
            }

            /******************new*code*for*site*status********************/

        //get google API Key
        $general_setting_obj = GeneralSettingsModel::where('data_id','GOOGLE_API_KEY')->first();

        if($general_setting_obj)
        {
            $general_setting_arr = $general_setting_obj->toArray();
        }

        
        $cms_pages_arr = StaticPageModel::where('is_active','1')->get()->toArray();

        

        $general_settings_arr = GeneralSettingsModel::get()->toArray();   

       
        /************Switch User Role and Get Active User Role***********************/


        /**************check location data**************************/
         $checkuser_locationdata = checklocationdata(); 
         if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
         {
           $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
           $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
         } 

      /**************end check location data*********************/

      /*******************Restricted states seller id*********************/

       $check_buyer_restricted_states =  get_buyer_restricted_sellers();
       $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];


       /********************Restricted states seller id***********************/




            
        if(\Sentinel::check())
            {   
                $user = \Sentinel::check();
                $user_id = $user['id'];
                
               
                if($user->inRole('buyer') == true)
                {
                    
                   // $fav_product = FavoriteModel::where('buyer_id',$user_id)->get()->count();
                   
                    //new condition added for filter out the product according state and country
                    $fav_product = FavoriteModel::where('buyer_id',$user_id) 
                                                    // ->whereHas('get_product_details', function($q) use($state_user_ids,$catdata){

                                                    ->whereHas('get_product_details',function($q)use($restricted_state_user_ids) {    

                                                        $q->where('is_approve',1);
                                                        $q->where('is_active',1);

                                                          /*if(isset($state_user_ids) && !empty($state_user_ids))
                                                           {
                                                             $q->whereIn('user_id',$state_user_ids);
                                                           }  
                                                          if(isset($catdata) && !empty($catdata))
                                                          {
                                                            $q->whereNotIn('first_level_category_id',$catdata);
                                                          }  */

                                                         /* if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids))
                                                         {

                                                           $q->whereIn('user_id',$restricted_state_user_ids);
                                                         }  */

                                                      })->get()->count();

                 
                    $fav_product_count = isset($fav_product) ? $fav_product:'0';
                   
                    
                }

                if($user->inRole('seller')==true)
                {
                    $get_sellerinfo = SellerModel::where('user_id',$user_id)->get();
                    if(!empty($get_sellerinfo))
                    {
                        $get_sellerinfo = $get_sellerinfo->toArray();
                        
                    }
                }

            }   

         $fav_product_count = isset($fav_product_count) ? $fav_product_count:'0';
         
         $cart_item_count = get_bag_count();  

         //get cart product count quantity wise
         $cart_count     = get_cart_count();

         $sellerinfo_arr = isset($get_sellerinfo)?$get_sellerinfo:[];

        view()->share('fav_product_count',$fav_product_count);
        
        view()->share('cart_item_count',$cart_item_count);
        
        view()->share('cart_count',$cart_count);
            
         view()->share('seller_info_arr',$sellerinfo_arr);

        /*****************************************************************************/
       
        $category_arr = $spectrum_arr = $effects_arr = [];

        //get all effects

        $effects_arr = ReportedEffectsModel::where('is_active','1')->get()->toArray();
 
        //get all spectrum

        $spectrum_arr = SpectrumModel::where('is_active',1)->orderBy('name')->get()->toArray();

        //get all category

        $category_arr = FirstLevelCategoryModel::where('is_active',1)->orderBy('product_type')->get()->toArray();

        //get all cannabinoids

        $cannabinoids_arr = CannabinoidsModel::whereHas('get_products_canabinoids',function($q){

                                     })
                                    ->where('is_active',1)
                                    ->orderBy('name')
                                    ->get()->toArray();

                                    

        $user = Sentinel::check();
         
        if(isset($user))
        {
          $loggedin_user = isset($user->id)?$user->id:0; 
        }

        $remain_wallet_amount = BuyerWalletModel::where('user_id',$loggedin_user)->sum('amount');

        if(isset($remain_wallet_amount))
        {
            view()->share('remain_wallet_amount',num_format($remain_wallet_amount));
        }

       // view()->share('cart_item_count',$cart_item_count);
       
        view()->share('cannabinoids_arr',$cannabinoids_arr);
        view()->share('effects_arr',$effects_arr);
        view()->share('spectrum_arr',$spectrum_arr);
        view()->share('category_arr',$category_arr);

        view()->share('general_setting_arr',$general_setting_arr);
        view()->share('category_arr',$category_arr);
        view()->share('site_setting_arr',$site_setting_arr);
        view()->share('profile_img_path',url('/').config('app.project.img_path.user_profile_image'));
        view()->share('loggedin_user',$user);
        view()->share('g_fa_data',$g_fa_data);
        view()->share('cms_pages_arr',$cms_pages_arr);



        
            if(\Sentinel::check())
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
              view()->share('seller_arr',$get_seller_detail_arr);

        
              $response = $next($request);

              return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                  ->header('Pragma','no-cache')
                  ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
    }
}
