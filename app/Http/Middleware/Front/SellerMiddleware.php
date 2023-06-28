<?php

namespace App\Http\Middleware\Front;

use Closure;
use Sentinel;
use Session;


use App\Models\SellerModel;
use App\Models\BuyerModel;
use App\Models\UserSubscriptionsModel;
use App\Models\SiteSettingModel;


class SellerMiddleware
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
            if($user->inRole('seller'))
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


                    /*******Code for check user subscription (subscribed or not )****/

                      $arr_except[] =  '';
                      $arr_except[] =  'seller/membership';
                      $arr_except[] =  'seller/membership_selection'; 
                      $request_path = $request->route()->getCompiled()->getStaticPrefix();
                        $request_path = substr($request_path,1,strlen($request_path));

                        if(!in_array($request_path, $arr_except))
                        {   
                            $currentdate = date('Y-m-d');

                            $user = \Sentinel::check();
                            $user_id = $user['id'];

                            $user_sub_data =  UserSubscriptionsModel::where
                            ('user_id',$user_id)->orderBy('id','desc')->first();

                            if(isset($user_sub_data) && !empty($user_sub_data))
                            {
                                $user_sub_data = $user_sub_data->toArray();
                            } 
                          //  dd($user_sub_data);

                                    // if ($request->user() && $request->user()->subscription('main')->cancelled() && isset($user_sub_data) && !empty($user_sub_data) && $user_sub_data['is_cancel']=='1' && $currentdate < $user_sub_data['current_period_enddate'] ) 

                                 if($user_sub_data['membership']=="1")
                                 {
                                       //  return $next($request); //commented

                                    /********added on 25 june 20**if no any membership then ******/
                                        if($user_sub_data['membership_status']=="0")
                                        {
                                             return redirect('seller/membership');
                                        }else
                                        {
                                            return $next($request);
                                        }
                                    /************end 25 june 20*****************/

                                 }//if free
                                 else
                                 {
                                    //if paid
                                   /* if ($request->user() && !$user->subscribed('main') && isset($user_sub_data) && !empty($user_sub_data) && $user_sub_data['is_cancel']=='1' && $currentdate <= $user_sub_data['current_period_enddate'] )     
                                    {*/
                                        //here remove condition of end date 
                                    if ($request->user() && !$user->subscribed('main') && isset($user_sub_data) && !empty($user_sub_data) && $user_sub_data['is_cancel']=='1')     
                                    {    

                                         // return $next($request); //commented on 25june20
                                         return redirect('seller/membership');
                                    }
                                    else
                                    {
                                       if ($request->user() && ! $request->user()->subscribed('main') && $currentdate>='2020-04-29') {
                                            return redirect('seller/membership');
                                        } 
                                        else
                                        {
                                             return $next($request);
                                        }
                                    }//else    
                                }//elseif paid type
                             
                                
                        }
                        else
                        {
                             return $next($request);
                        }


                    /*********end of check code********/




              //  return $next($request); //comment this line
               
                
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
