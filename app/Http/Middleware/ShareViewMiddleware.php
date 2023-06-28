<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\FavoriteModel;
use App\Models\TempBagModel;
use App\Models\StaticPageModel;
use App\Models\StaticPageTranslationModel;
use App\Models\SiteSettingModel;
use App\Models\FirstLevelCategoryModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\UserModel;

use App\Models\SellerModel;
use App\Models\BuyerModel;


use DB;

class ShareViewMiddleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    public function handle($request, Closure $next)
	{

                
            if(\Sentinel::check())
                {   
                    $user = \Sentinel::check();
                    $user_id = $user['id'];
                    
                   
                    if($user->inRole('buyer') == true)
                    {
                        
                        $fav_product = FavoriteModel::where('buyer_id',$user_id)->get()->count();
                        
                        $cart_item = TempBagModel::where('buyer_id',$user_id)->count();

                        $fav_product_count = isset($fav_product) ? $fav_product:'0';
                        $cart_item_count = isset($cart_item) ? $cart_item:'0';
                        
                    }

                } 


                $fav_product_count = isset($fav_product_count) ? $fav_product_count:'0';
                $cart_item_count = get_bag_count();  


        $staticmodel = new StaticPageModel();
        $staticpagemodel = new StaticPageTranslationModel();


          $FirstLevelCategoryModel         = new FirstLevelCategoryModel();
          $FirstLevelCategory_details      = $FirstLevelCategoryModel->getTable();        
          $prefixed_firstlevelcat_details  = DB::getTablePrefix().$FirstLevelCategoryModel->getTable();

          $obj_firstlevel   = DB::table($FirstLevelCategory_details)
                              ->select(DB::raw($FirstLevelCategory_details.'.*'))
                              ->where($FirstLevelCategory_details.'.is_active',1)
                              ->get(); 
          if(!empty($obj_firstlevel))
          {
            $obj_firstlevel = $obj_firstlevel->toArray();
          }  
          view()->share('firstlevelcat_arr',$obj_firstlevel);    


          $SecondlevelCategoryModel         = new SecondlevelCategoryModel();
          $secondLevelCategory_details      = $SecondlevelCategoryModel->getTable();        
          $prefixed_secondlevelcat_details  = DB::getTablePrefix().$SecondlevelCategoryModel->getTable();
          $obj_secondlevel   = DB::table($secondLevelCategory_details)
                              ->select(DB::raw($secondLevelCategory_details.'.*'))
                              ->leftjoin($prefixed_firstlevelcat_details,$prefixed_firstlevelcat_details.'.id',$secondLevelCategory_details.'.first_level_category_id')
                              ->where($secondLevelCategory_details.'.is_active',1)
                              ->get(); 


          if(!empty($obj_secondlevel))
          {
            $obj_secondlevel = $obj_secondlevel->toArray();
          }  



         /* $second =[]; $subcategory=[];
          foreach($obj_firstlevel as $v)
          {
              $catid = $v->id;
              $obj_secondlevelcat = DB::table($secondLevelCategory_details)
                              ->select(DB::raw($secondLevelCategory_details.'.*'))
                              ->leftjoin($prefixed_firstlevelcat_details,$prefixed_firstlevelcat_details.'.id',$secondLevelCategory_details.'.first_level_category_id')
                              ->where($secondLevelCategory_details.'.is_active',1)
                              ->where($prefixed_secondlevelcat_details.'.first_level_category_id',$catid)
                              ->get()->toArray(); 
               $second['images'][] = array( 'id'=>$catid,'subcat'=>$obj_secondlevelcat);


          } */
 
        
          
          view()->share('secondlevelcat_arr',$obj_secondlevel);    


       // $staticmodel->getTable(); // this will work

        

        /************************** code for static cms page content*******************************/
        $staticpage_details           = $staticmodel->getTable();        
        $prefixed_staticpage_details  = DB::getTablePrefix().$staticmodel->getTable();

        $statictransalation_details   = $staticpagemodel->getTable();
        $prefixed_statictrans_details = DB::getTablePrefix().$staticpagemodel->getTable();

        $obj_static_page = DB::table($staticpage_details)
                            ->select(DB::raw($staticpage_details.'.*,'.$prefixed_statictrans_details.'.page_title,'
                              .$prefixed_statictrans_details.'.page_desc'))
                            ->where($staticpage_details.'.is_active','1')
                            ->leftjoin($prefixed_statictrans_details,$prefixed_statictrans_details.'.static_page_id',"=",$prefixed_staticpage_details.'.id')
                            ->orderBy($staticpage_details.'.orderby')
                            ->get()->toArray();

                            
         view()->share('cms_arr',$obj_static_page);

         /**********************************************************************/    

               $site_setting_arr = [];

               $site_setting_obj = SiteSettingModel::first();        
                if($site_setting_obj)
                {
                    $site_setting_arr = $site_setting_obj->toArray();            
                }
               view()->share('site_setting_arr',$site_setting_arr);
         /**********************************************************************/    
                $admin_arr =[];
                $admin_obj = UserModel::where('user_type','admin')->first();
                if($admin_obj)
                {
                  $admin_arr = $admin_obj->toArray();
                }
                view()->share('admin_arr',$admin_arr);


          /********************************************************/

            view()->share('fav_product_count',$fav_product_count);
            view()->share('cart_item_count',$cart_item_count);


             $obj_about_contact_page = DB::table($staticpage_details)
                            ->select(DB::raw($staticpage_details.'.*,'.$prefixed_statictrans_details.'.page_title'))
                            ->where($staticpage_details.'.is_active','1')
                            ->whereIn($staticpage_details.'.page_slug',array('home','about-us','contact-us'))
                            ->leftjoin($prefixed_statictrans_details,$prefixed_statictrans_details.'.static_page_id',"=",$prefixed_staticpage_details.'.id')
                            ->get()->toArray();
              view()->share('cms_staticpages_arr',$obj_about_contact_page);


               $obj_terms_privacy_page = DB::table($staticpage_details)
                            ->select(DB::raw($staticpage_details.'.*,'
                              .$prefixed_statictrans_details.'.page_title,'
                              .$prefixed_statictrans_details.'.page_desc'))
                            ->where($staticpage_details.'.is_active','1')
                          
                             // ->whereIn($staticpage_details.'.page_slug',array('terms-conditions','privacy-policy','about-us','refund-policy' , 'cbd-101','is-cbd-legal','partner-with-chow'))

                             ->whereIn($staticpage_details.'.page_slug',array('terms-conditions','privacy-policy','refund-policy'))


                            ->leftjoin($prefixed_statictrans_details,$prefixed_statictrans_details.'.static_page_id',"=",$prefixed_staticpage_details.'.id')
                            ->orderBy('orderby', 'DESC')
                            ->get()->toArray();
                           
              view()->share('cms_terms_privacy_arr',$obj_terms_privacy_page);


              $obj_cbd_about_page = DB::table($staticpage_details)
                            ->select(DB::raw($staticpage_details.'.*,'
                              .$prefixed_statictrans_details.'.page_title,'
                              .$prefixed_statictrans_details.'.page_desc'))
                            ->where($staticpage_details.'.is_active','1')                          
                             ->whereIn($staticpage_details.'.page_slug',array('about-us', 'cbd-101'))                          
                            ->leftjoin($prefixed_statictrans_details,$prefixed_statictrans_details.'.static_page_id',"=",$prefixed_staticpage_details.'.id')
                            ->orderBy('orderby', 'DESC')
                            ->get()->toArray();

              view()->share('cms_about_cbd_arr',$obj_cbd_about_page);



               $obj_terms_referal_page = DB::table($staticpage_details)
                            ->select(DB::raw($staticpage_details.'.*,'
                              .$prefixed_statictrans_details.'.page_title,'
                              .$prefixed_statictrans_details.'.page_desc'))
                            ->where($staticpage_details.'.is_active','1')
                          
                             // ->whereIn($staticpage_details.'.page_slug',array('terms-conditions','privacy-policy','about-us','refund-policy' , 'cbd-101','is-cbd-legal','partner-with-chow'))

                             ->whereIn($staticpage_details.'.page_slug',array('earn-referal','sell-on-chow420','affiliate'))
                            ->leftjoin($prefixed_statictrans_details,$prefixed_statictrans_details.'.static_page_id',"=",$prefixed_staticpage_details.'.id')
                            ->orderBy('orderby', 'DESC')
                            ->get()->toArray();
                           
              view()->share('cms_terms_referal_arr',$obj_terms_referal_page);




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

             view()->share('domain_source',$request->getHttpHost());

                          
            return $next($request);
        }
}
