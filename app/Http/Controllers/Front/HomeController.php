<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProductModel;
use App\Models\FirstLevelCategoryModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\UnitModel;
use App\Models\UserModel;
use App\Models\ShippingAddressModel;
use App\Models\TradeRatingModel;
use App\Models\SliderImagesModel;
use App\Models\StaticPageModel;
use App\Models\GeneralSettingsModel;
use App\Models\TestimonialModel;
use App\Models\BuyerModel;
use App\Models\FavoriteModel;
use App\Models\ProductNewsModel;
use App\Models\ReviewRatingsModel;
use App\Models\ProductImagesModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\BrandModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\UserReferedModel;
use App\Models\UserSubscriptionsModel; 
use App\Models\MembershipModel;
use App\Models\EventModel;
use App\Models\IpDataModel;
use App\Models\UserReferWalletModel;
use App\Models\BannerImagesModel;
use App\Models\TagsModel;
use App\Models\ShopByEffectModel;
use App\Models\ShopBySpectrumModel;
use App\Models\HighlightModel;
use App\Models\StaticPageTranslationModel;
use App\Models\BuyerReferedModel;
use App\Models\BuyerRegisteredReferModel;
use App\Models\ReportedEffectsModel;




use Carbon\Carbon;
use App\Common\Services\EmailService; 
use Sentinel;
use DB; 
use Datatables;
use Session;
use Activation;
use Illuminate\Support\Str;
 

class HomeController extends Controller
{
     

    public function __construct(
                                    ProductModel $ProductModel,
                                    FirstLevelCategoryModel $FirstLevelCategoryModel,
                                    SecondLevelCategoryModel $SecondLevelCategoryModel,
                                    UnitModel $UnitModel,
                                    UserModel $UserModel,
                                    ShippingAddressModel $ShippingAddressModel,
                                    TradeRatingModel $TradeRatingModel,
                                    SliderImagesModel $SliderImagesModel,
                                    StaticPageModel $StaticPageModel,
                                    GeneralSettingsModel $GeneralSettingsModel,
                                     CountriesModel $CountriesModel,
                                      StatesModel $StatesModel,
                                    
                                    EmailService $EmailService,
                                    TestimonialModel $TestimonialModel,
                                    BuyerModel $BuyerModel,
                                    ProductNewsModel $ProductNewsModel,
                                    ReviewRatingsModel $ReviewRatingsModel,
                                    ProductImagesModel $ProductImagesModel,
                                    OrderModel $OrderModel,
                                    OrderProductModel $OrderProductModel,
                                    BrandModel $BrandModel,
                                    UserReferedModel $UserReferedModel,
                                    UserSubscriptionsModel $UserSubscriptionsModel,
                                    MembershipModel $MembershipModel,
                                    EventModel $EventModel,
                                    IpDataModel $IpDataModel,
                                    UserReferWalletModel $UserReferWalletModel,
                                    BannerImagesModel $BannerImagesModel,
                                    TagsModel $TagsModel,
                                    ShopByEffectModel $ShopByEffectModel,
                                    ShopBySpectrumModel $ShopBySpectrumModel,
                                    HighlightModel $HighlightModel,
                                    BuyerReferedModel $BuyerReferedModel,
                                    BuyerRegisteredReferModel $BuyerRegisteredReferModel,
                                    ReportedEffectsModel $ReportedEffectsModel
                                )
    {   
        $this->ProductModel               = $ProductModel;
        $this->FirstLevelCategoryModel  = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
        $this->UnitModel                = $UnitModel;
        $this->UserModel                = $UserModel;
        $this->ShippingAddressModel     = $ShippingAddressModel; 
        $this->TradeRatingModel         = $TradeRatingModel;
        $this->SliderImagesModel        = $SliderImagesModel;
        $this->StaticPageModel          = $StaticPageModel;
        $this->GeneralSettingsModel     = $GeneralSettingsModel;
        
        $this->EmailService             = $EmailService;
        $this->TestimonialModel         = $TestimonialModel;
        $this->BuyerModel               = $BuyerModel;
        $this->BuyerModel               = $BuyerModel;
        $this->FavoriteModel            = new FavoriteModel();
        $this->ProductNewsModel         = $ProductNewsModel;
        $this->ReviewRatingsModel       = $ReviewRatingsModel;
        $this->ProductImagesModel       = $ProductImagesModel;
        $this->OrderModel               = $OrderModel;
        $this->OrderProductModel        = $OrderProductModel;
        $this->BrandModel               = $BrandModel;
        $this->UserReferWalletModel     = $UserReferWalletModel;

        $this->CountriesModel           = $CountriesModel;
        $this->StatesModel              = $StatesModel;
        $this->UserReferedModel         = $UserReferedModel;
        $this->UserSubscriptionsModel   = $UserSubscriptionsModel;
        $this->MembershipModel          = $MembershipModel;
        $this->EventModel               = $EventModel;
        $this->IpDataModel              = $IpDataModel;
        $this->BannerImagesModel        = $BannerImagesModel;
        $this->TagsModel                = $TagsModel;
        $this->ShopByEffectModel        = $ShopByEffectModel;
        $this->ShopBySpectrumModel      = $ShopBySpectrumModel;
        $this->HighlightModel           = $HighlightModel;
        $this->BuyerReferedModel        = $BuyerReferedModel;
        $this->BuyerRegisteredReferModel = $BuyerRegisteredReferModel;
        $this->ReportedEffectsModel     = $ReportedEffectsModel;

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->slider_base_img_path   = base_path().config('app.project.img_path.slider_images');
        $this->slider_public_img_path = url('/').config('app.project.img_path.slider_images');
        $this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }
   

    public function test_invoice()
    {
         
        $update_emoji=[];    
        $effects = ReviewRatingsModel::where('emoji','!=','')->get();
        if(isset($effects) && !empty($effects))
        {
             $update_emoji=[];
            $effects = $effects->toArray();
           
            foreach($effects as $k=>$v)
            {
                    $ids = [];  $imploded='';
                    if(isset($v['emoji']) && !empty($v['emoji']))
                    {
                        $exploded_images = explode(",",$v['emoji']);
                        foreach($exploded_images as $k1=>$v1)
                        {
                            $images = explode(".",$v1);
                            $get_emojiid = ReportedEffectsModel::where('title',$images[0])->select('id')->first();
                            if(isset($get_emojiid) && !empty($get_emojiid))
                             {
                                $get_emojiid =$get_emojiid->toArray();
                                
                                $ids[] = $get_emojiid['id']; 
                             }

                        }//foreach
                        $imploded = implode(",",$ids);

                        $update_emoji=[];
                        $update_emoji['emoji'] = $imploded;    
                        $this->ReviewRatingsModel->where('id',$v['id'])->update($update_emoji);
                               
                    } //effects['emoji']
            }
        
        } //effects   


        return view($this->module_view_folder.'.test_invoice',$this->arr_view_data);
        
    }  


    public function index()
    {
     
        // Added for when user comes from email link pending age verification
        $buyer_age_url = '';
        $buyer_age_url = url()->previous();

        if(isset($buyer_age_url) && !empty($buyer_age_url))
        {
           
            if (strpos($buyer_age_url, 'buyer') == true && strpos($buyer_age_url, 'age-verification') == true)
            { 
                        
                Session::put('buyer_age_verification_url',$buyer_age_url);
                return redirect('/login');
            } 
                
        }
        
        /*******************Restricted states seller id*********************/

       $check_buyer_restricted_states =  get_buyer_restricted_sellers();
       $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];

       /********************Restricted states seller id***********************/

         $checkuser_locationdata = checklocationdata(); 
         if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
         {
           $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
           $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
         } 

         /***************Start**slider**data******************************************/

         $arr_slider_images = [];

         $arr_slider_images = $this->SliderImagesModel->where('is_active','1')->get()->toArray();

         $arr_slider_images = array_chunk($arr_slider_images, 50);

         $this->arr_view_data['arr_slider_images'] = isset($arr_slider_images)?$arr_slider_images:[];

         /******************End slider data******************************************/

        $prodmodel         = $this->ProductModel->getTable();
        $prefix_productable  = DB::getTablePrefix().$this->ProductModel->getTable();

        $favmodel          = $this->FavoriteModel->getTable();
        $prefix_favtable   = DB::getTablePrefix().$this->FavoriteModel->getTable();

        $product_images = $this->ProductImagesModel->getTable();
        $prefix_product_images = DB::getTablePrefix().$this->ProductImagesModel->getTable();

        $order_table = $this->OrderModel->getTable();
        $prefix_order_detail = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_table = $this->OrderProductModel->getTable();
        $prefix_order_product = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $reviewmodel         = $this->ReviewRatingsModel->getTable();
        $prefix_reviewtable  = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();

        $brand_table         = $this->BrandModel->getTable();
        $prefix_brandtable  = DB::getTablePrefix().$this->BrandModel->getTable();

        $country_table        = $this->CountriesModel->getTable();
        $prefix_countrytable  = DB::getTablePrefix().$this->CountriesModel->getTable();

        $state_table        = $this->StatesModel->getTable();
        $prefix_statetable  = DB::getTablePrefix().$this->StatesModel->getTable();

        $user_table        = $this->UserModel->getTable();
        $prefix_usertable  = DB::getTablePrefix().$this->UserModel->getTable();

        $ip_address = $this->get_ip_address();
        $session_id = $this->get_session_id();
        $user = Sentinel::check();
       


        /***************start recently viewed product data***********************/

        if($user == false)
        {
          $login_flag = false;
        }
        else
        {
            $login_flag = true;
        }

        $arr_eloq_trending_data =  $this->ProductModel->with([
                                            'first_level_category_details',
                                            'second_level_category_details',
                                            'inventory_details',
                                            'product_images_details',
                                            'age_restriction_detail',
                                            'get_seller_details.get_country_detail', 
                                            'get_seller_details.get_state_detail', 
                                            'get_seller_additional_details',
                                            'get_brand_detail',
                                            'review_details',
                                            'get_view_products'
                                            ])
                                            ->whereHas('get_seller_details',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })


                                            ->whereHas('get_view_products', function ($q1)use($login_flag,$ip_address,$session_id,$user)
                                            {

                                                if($login_flag == false)
                                                {
                                                   $q1->where('ip_address',$ip_address);
                                                   $q1->where('user_session_id',$session_id);
                                                }
                                                else
                                                {
                                                   $q1->where('buyer_id',$user->id);
                                                }

                                                //$q1->where('user_session_id',$session_id);
                                                
                                            })
                                         
                                           // ->whereIn('id',$productidssold)    
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->orderBy('created_at','desc')
                                            ->limit('50');
                             
            $arr_eloq_trending_data = $arr_eloq_trending_data->get();
                

            if(!empty($arr_eloq_trending_data))
            {
                $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
              
            }                         

       

        $this->arr_view_data['arr_eloq_trending_data'] = isset($arr_eloq_trending_data)?$arr_eloq_trending_data:[];
         
        /***************End recently viewed product data***********************/



        /***************Start Buy Again section******************************/

            $loguser_id = 0;   
            $order_ids = $product_idsarr = $buy_again_product_arr = []; 

            $user = sentinel::check();

            if(isset($user) && $user!=false)
            {
                $loguser_id = $user->id;
            }

    
             $order_ids   = $this->OrderModel->where('buyer_id',$loguser_id)->where('order_status','1')->select('id')->get()->toArray();

              $product_idsarr    =  $this->OrderProductModel->whereIn('order_id',$order_ids)->select('product_id')->groupBy('product_id')->get()->toArray();

      

             if(isset($product_idsarr) && !empty($product_idsarr))
            {
                $buy_again_product_obj = $this->ProductModel
                                        ->with([
                                                    'first_level_category_details',
                                                    'second_level_category_details',
                                                    'inventory_details',
                                                    'product_images_details',
                                                    'age_restriction_detail',
                                                    'get_seller_details.get_country_detail', 
                                                    'get_seller_details.get_state_detail', 
                                                    'get_seller_additional_details',
                                                    'get_brand_detail',
                                                    'review_details'
                                            ])
                                        ->whereHas('get_seller_details',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->where([['is_active',1],['is_approve',1]])
                                         ->whereIn('id',$product_idsarr);
                                 
                                      
                 $buy_again_product_obj = $buy_again_product_obj->get();

         
                if(isset($buy_again_product_obj))
                {
                   $buy_again_product_arr = $buy_again_product_obj->toArray();
                   
                }

        }//isset product_idsarr
      
        $this->arr_view_data['buy_again_product_arr'] = isset($buy_again_product_arr)?$buy_again_product_arr:[];
       
       /*******************End of buy again section******************************/



       /*******************Start of product you may like section****************/

        /*from recently view product get you may like products*/       

           $recntly_category=[]; $recently_products=[];         

         if((isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data)))
        {  
            if(isset($arr_eloq_trending_data))
            {  
                $recntly_category = $recently_products = [];
                
                foreach($arr_eloq_trending_data as $key => $value) 
                {
                    $recntly_category[]  = $value['first_level_category_id'];
                    $recently_products[] = $value['id'];
                }

            }// if arr_eloq_trending_data


            $product_liked_arr = [];

            if(isset($recntly_category) && !empty($recntly_category) && isset($recently_products) && !empty($recently_products))
            {
      
                $product_liked_obj = $this->ProductModel
                                        ->with([
                                                    'first_level_category_details',
                                                    'second_level_category_details',
                                                    'inventory_details',
                                                    'product_images_details',
                                                    'age_restriction_detail',
                                                    'get_seller_details.get_country_detail', 
                                                    'get_seller_details.get_state_detail', 
                                                    'get_seller_additional_details',
                                                    'get_brand_detail',
                                                    'review_details'
                                            ])
                                        ->whereHas('get_seller_details',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->where([['is_active',1],['is_approve',1]])
                                        /*->orderByRaw('FIELD(first_level_category_id,'.$like_categoryids.')')*/
                                        ->whereIn('first_level_category_id',$recntly_category)
                                        ->whereNotIn('id',$recently_products);
                                       
                            $product_liked_obj = $product_liked_obj                                        
                                            ->limit(20)
                                            ->get();

                if(isset($product_liked_obj))
                {
                    $product_liked_arr = $product_liked_obj->toArray();
                           
                }//         
            }// isset recntly_category && recently_products                        

         }//isset arr_eloq_trending_data  

        $this->arr_view_data['product_liked_arr'] = isset($product_liked_arr)?$product_liked_arr:[]; 

       

       /*******************End of product you may like section*******************/


       /***************Start trending on chow*************************************/
            $is_trending_product_arr = [];
        
            $is_trending_product_obj = $this->ProductModel
                                            ->with([
                                                        'first_level_category_details',
                                                        'second_level_category_details',
                                                        'inventory_details',
                                                        'product_images_details',
                                                        'age_restriction_detail',
                                                        'get_seller_details.get_country_detail', 
                                                        'get_seller_details.get_state_detail', 
                                                        'get_seller_additional_details',
                                                        'get_brand_detail',
                                                        'review_details'
                                                ])
                                            ->whereHas('get_seller_details',function($q){
                                                    $q->where('is_active','1');
                                                })
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                    $q->where('is_active','1');
                                                })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                    $q->where('is_active', '1');
                                                })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                    $q->where('is_active', '1');
                                                })
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->where('is_trending',1);
                                                //->orderBy('id','DESC')

                 $is_trending_product_obj = $is_trending_product_obj
                                                    ->inRandomOrder()
                                                    ->limit(20)
                                                    ->get();
                
                if(isset($is_trending_product_obj))
                {
                   $is_trending_product_arr = $is_trending_product_obj->toArray();

                }//is_trending_product_obj

               $this->arr_view_data['is_trending_product_arr'] = isset($is_trending_product_arr)?$is_trending_product_arr:[];


       /***************End trending on chow****************************************/

       /***************Start heighlight section**************************/
         
          $arr_highlights = [];
          $arr_highlights = $this->HighlightModel
                           ->where('is_active','1')                
                           ->get()
                           ->toArray();
         $this->arr_view_data['arr_highlights'] = isset($arr_highlights)?$arr_highlights:[];


        /***************End heighlight section**************************/

        /*******************Start shop by category section*********************/

         $arr_featured_category = $this->FirstLevelCategoryModel
                                  ->where('is_featured','1')
                                  ->where('is_active','1')
                                  ->orderBy('product_type');     
                                                         
                                
         $arr_featured_category =  $arr_featured_category->get()->toArray();

         $this->arr_view_data['arr_featured_category'] = isset($arr_featured_category)?$arr_featured_category:[]; 

        /******************End of shop by category section******************/


        /*****************Start of shop by reviews***************************/
            $arr_shop_by_effect = $this->ShopByEffectModel->where('is_active','1')                
                                    ->get()->toArray(); 

    
           $this->arr_view_data['arr_shop_by_effect'] = isset($arr_shop_by_effect)?$arr_shop_by_effect:[]; 

        /******************End of shop by reviews*****************************/

        /******************Start of shop by spectrum*************************/

            $arr_shop_by_spectrum = $this->ShopBySpectrumModel
                                    ->where('is_active','1')                
                                    ->get()->toArray();

            $this->arr_view_data['arr_shop_by_spectrum'] = isset($arr_shop_by_spectrum)?$arr_shop_by_spectrum:[]; 

        /********************End of shop by spectrum**************************/

        /************Start of chows choice products****************************/
            $chow_choice_product_arr = [];
        
            $chow_choice_product_obj = $this->ProductModel
                                                ->with([
                                                            'first_level_category_details',
                                                            'second_level_category_details',
                                                            'inventory_details',
                                                            'product_images_details',
                                                            'age_restriction_detail',
                                                            'get_seller_details.get_country_detail', 
                                                            'get_seller_details.get_state_detail', 
                                                            'get_seller_additional_details',
                                                            'get_brand_detail',
                                                            'review_details'
                                                    ])
                                                ->whereHas('get_seller_details',function($q){
                                                        $q->where('is_active','1');
                                                    })
                                                ->whereHas('get_seller_details.get_country_detail',function($q){
                                                        $q->where('is_active','1');
                                                    })
                                                ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                        $q->where('is_active', '1');
                                                    })
                                                ->whereHas('get_brand_detail', function ($q) {
                                                        $q->where('is_active', '1');
                                                    })
                                                ->where([['is_active',1],['is_approve',1]])
                                                ->where('is_chows_choice',1);

                                           
                         $chow_choice_product_obj = $chow_choice_product_obj
                                                    ->inRandomOrder()
                                                    ->limit(20)
                                                    ->get();

                
                if(isset($chow_choice_product_obj))
                {
                   $chow_choice_product_arr = $chow_choice_product_obj->toArray();
                   
                }


            $this->arr_view_data['chow_choice_product_arr'] = isset($chow_choice_product_arr)?$chow_choice_product_arr:[];

        /************End of chows choice products********************************/


        /*****************Start of top brands**********************************/
            $arr_featured_brands = [];

            $arr_featured_brands = $this->BrandModel
                                ->where('is_active','1')
                                ->where('is_featured','1')
                                ->where('image','!=','')
                                ->inRandomOrder()
                                ->get()->toArray();


            $this->arr_view_data['arr_featured_brands'] = isset($arr_featured_brands)?$arr_featured_brands:[];

        /*****************End of top brands***********************************/


        /******************Start of tag section***********************************/
             $arr_tags = [];

            $arr_tags = $this->TagsModel->where('is_active','1')->get();
            
            if(isset($arr_tags) && !empty($arr_tags))
            {
                $arr_tags = $arr_tags->toArray();
            }
          
            $this->arr_view_data['arr_tags']  = isset($arr_tags)?$arr_tags:[];
 

        /*****************End of tag section**********************************/

        /*****************Start of chow watch section*************************/
              $arr_product_news = $this->ProductNewsModel
                                ->where('is_active','1') 
                                ->where('is_featured','1')                      
                                ->limit(20)
                                ->inRandomOrder()
                                ->get()
                                ->toArray(); 


                if(isset($arr_product_news) && count($arr_product_news)>0){

                    foreach ($arr_product_news as $key => $data) {
                        $url = isset($data['video_url'])&&$data['video_url']!=""?$data['video_url']:false;

                        if($url!=false)
                        {
                            $tmp_arr = explode("?v=", $url);
                            $url_id = isset($tmp_arr[1])?$tmp_arr[1]:'';
                            $arr_product_news[$key]['url_id'] = $url_id;

                        }
                    }
                }//if product news    


            $this->arr_view_data['arr_product_news'] = isset($arr_product_news)?$arr_product_news:[];

        /*****************End of chow watch section****************************/


        /*****************Start of event section*********************************/

               $arr_events = $this->EventModel->where('created_at','>=' , date('Y', strtotime('-1 year')))->orderBy('id','desc')->where('status','1')->limit(1000)->get()->toArray();


                if(isset($arr_events) && !empty($arr_events))
                {
                        $k=1;
                         foreach ($arr_events as $key1 => $data1) {
                        $url = isset($data1['message']) && $data1['message']!=""?$data1['message']:false;

                        if($url!=false)
                        {
                            $arr_events[$key1]['name'] = "ms".$k;
                            $arr_events[$key1]['msg'] = $data1['message'];
                            $arr_events[$key1]['delay'] = 1000;
                            if($k%2==0)
                            {
                                $arr_events[$key1]['align'] = "left";
                            }else
                            {
                                 $arr_events[$key1]['align'] = "right";
                            }
                             $arr_events[$key1]['showTime'] = true;
                             $arr_events[$key1]['time'] = date("d M Y H:i A",strtotime(date($data1['created_at'])));
                             unset($arr_events[$key1]['user_id']);
                             unset($arr_events[$key1]['updated_at']);
                             unset($arr_events[$key1]['message']);
                             unset($arr_events[$key1]['id']);
                            $k++;
                        }//urlnot false
                    }//foreach

                }//isset events 

               
                $this->arr_view_data['arr_events'] = isset($arr_events)?$arr_events:[];

        /*****************End of event section***********************************/
         
        $this->arr_view_data['page_title']              = 'Chow420';
        $this->arr_view_data['slider_public_img_path']  = $this->slider_public_img_path; 
        $this->arr_view_data['isMobileDevice']          = $this->isMobileDevice();
        $this->arr_view_data['state_user_ids']  = isset($state_user_ids)?$state_user_ids:'';
        $this->arr_view_data['catdata']  = isset($catdata)?$catdata:[];
   
        return view($this->module_view_folder.'.index',$this->arr_view_data);
 
    }





    function isMobileDevice() {

   
        $is_mobile_device = '';
       
       if(isset($_SERVER["HTTP_USER_AGENT"]) && !empty($_SERVER["HTTP_USER_AGENT"]))
       {
            $is_mobile_device =  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
            if($is_mobile_device)
            {   
                return 1;
            }else{
                return 0;
            }
       }else{
         return 0;
       }

    }

    private function getPercentageChange($oldNumber, $newNumber){
        $decreaseValue = $oldNumber - $newNumber;

        return ($decreaseValue / $oldNumber) * 100;
    }


    public function set_guest_url(Request $request)
    {


        $url = $request->get('guest_link');
     
        if(isset($url))
        {
            $response['status'] = 'success';
            $response['redirect_link'] = $url;
            
            Session::put('guest_back_url',$url);
            
            return $response; 
        }
        else{
            $response['status'] ='failiure';
            return $response;
        }

    }
    
  
    public function get_trade_detail(Request $request)
    {   
        $arr_trade = [];

        $id  = $request->input('trade_id');
        
        $obj_trade = $this->ProductModel->where('id',$id)
                          ->first();

        if($obj_trade)
        {
            $arr_trade = $obj_trade->toArray();
           

            $max_qty      = isset($arr_trade['product_stock'])?floatval($arr_trade['product_stock']):0;
            $min_qty      = isset($arr_trade['minimum_quantity'])?floatval($arr_trade['minimum_quantity']):0;
            $sold_out_qty = isset($arr_trade['sold_out_qty'])?floatval($arr_trade['sold_out_qty']):0;

            $remaining_qty = isset($arr_trade['remaiming_stock'])?floatval($arr_trade['remaiming_stock']):0;

            $remain_qty = $remaining_qty;
            if($remain_qty>$min_qty)
            {
                $remain_qty = $min_qty;
            }

            $response['status']    = 'success';          
            $response['arr_trade'] = [     
                                        'id'                =>isset($arr_trade['id'])?$arr_trade['id']:0,
                                        'trade_ref'         =>isset($arr_trade['trade_ref'])?$arr_trade['trade_ref']:0,
                                        'quantity'          =>isset($arr_trade['quantity'])?floatval($arr_trade['quantity']):0,
                                        'unit_price'        =>isset($arr_trade['unit_price'])?floatval($arr_trade['unit_price']):0,
                                        'minimum_quantity'  =>$remain_qty,
                                        'trade_status'      =>isset($arr_trade['trade_status'])?$arr_trade['trade_status']:'',
                                        'trade_type'        =>isset($arr_trade['trade_type'])?$arr_trade['trade_type']:'',
                                        'handling_charges'  =>isset($arr_trade['handling_charges'])?$arr_trade['handling_charges']:0,
                                        'unit'              =>isset($arr_trade['unit_data']['unit'])?$arr_trade['unit_data']['unit']:'',
                                        'remaining_qty'     => $remaining_qty,
                                        
                                    ];
        }
        else
        {
            $response['status'] = 'error';
        }
        
        return response()->json($response);

    }

    /*
        store_trade() - Buyer will apply the order when buyer enter quantity within min and max quantity. Stored Buyer order in trade table
    */
    public function store_trade(Request $request)
    {
        $form_data = $request->all();
        $user_id = 0;
        $user_name = "";


        if(Sentinel::check())
        {
            $user_details = Sentinel::getUser();
            $user_id      = $user_details->id;
            $user_name    = $user_details->user_name;
        }

        /* check if meta mask address and buyer wallet address in db are same or not if same then he can purchase or apply for trade*/
        
        $buyer_details = $this->BuyerModel->where('user_id',$user_id)->first();
 
        if(isset($buyer_details))
        {
            if(strtolower($buyer_details->crypto_wallet_address)!= strtolower($form_data['metamask_wallet_address']))
            {
               $response['status']      = 'warning';
               $response['description'] = 'Buyer wallet address and metamask wallet address are not same.';
                return response()->json($response);
            }    
        } 
      
        /*------------------------------------------------------------------------*/

        /*check apply trade quantity and meta mask usdc balance - if quantity is greater than usdc 
         balance then buyerr cannot purchase the trade */

        if(isset($form_data['buyer_entered_price']) && isset($form_data['metamask_balance']))
        {
            if($form_data['buyer_entered_price'] > $form_data['metamask_balance'])
            {

                $response['status']      = 'error';
                $response['description'] = 'Your USDC balance is less.';
                return response()->json($response);
            } 
        }
      
        /*-------------------------------------------------------------------------------*/


        $id = isset($form_data['trade_id'])?$form_data['trade_id']:'';

        $buyer_entered_qty   = isset($form_data['buyer_entered_qty'])?$form_data['buyer_entered_qty']:'';
        $buyer_entered_price = isset($form_data['buyer_entered_price'])?$form_data['buyer_entered_price']:'';

        $obj_trade = $this->TradeModel->where('id',$id)->first();
        
        if($obj_trade)
        {
            $arr_trade = $obj_trade->toArray();
              
            if($user_id == $arr_trade['user_id'])
            {   
                $response['status']      = 'warning';
                $response['description'] = 'Sorry, You are not eligible to apply for your own trade';
                return response()->json($response);
            }

            $remaining_qty = 0;
            $min_qty   = isset($arr_trade['minimum_quantity'])?floatval($arr_trade['minimum_quantity']):0;
            $max_qty   = isset($arr_trade['quantity'])?floatval($arr_trade['quantity']):0;
            $sold_out_qty = isset($arr_trade['sold_out_qty'])?floatval($arr_trade['sold_out_qty']):0;

            $remaining_qty = $max_qty - $sold_out_qty;  

            $current_minimum_quantity = $remaining_qty;

            if($current_minimum_quantity > $min_qty)
            {
                $current_minimum_quantity = $min_qty;
            }     

            if($buyer_entered_qty < $current_minimum_quantity)
            {
                $response['status']      = 'error';
                $response['description'] = 'Please enter correct quantity';

                return response()->json($response);
            }
            elseif ($buyer_entered_qty > $remaining_qty) 
            {
                $response['status']      = 'error';
                $response['description'] = 'Please enter correct quantity';
 
                return response()->json($response);
            }

            

            $insert_data['user_id']                  = $user_id;
            $insert_data['first_level_category_id']  = $arr_trade['first_level_category_id'];
            $insert_data['second_level_category_id'] = $arr_trade['second_level_category_id'];

            $insert_data['trade_ref']      = generate_trade_ref($user_id);

            $insert_data['quantity']       = $buyer_entered_qty;
            $insert_data['unit_price']     = $arr_trade['unit_price'];
            $insert_data['unit_id']        = $arr_trade['unit_id'];

            $insert_data['trade_status']   = '0'; //0 - Pending
            $insert_data['trade_type']     = '0'; //0 - buy

            $insert_data['is_active']      = '1';
            $insert_data['linked_to']      = $id;
            $insert_data['is_finalized']   = '0';
            $insert_data['is_crypto_trade']= $arr_trade['is_crypto_trade'] or 0;
            $insert_data['crypto_trade_status'] = '0';
            

            $insert = $this->TradeModel->create($insert_data);

            if($insert)
            {   
                /*********************Notification START***************************/

                $url     = '';
                $subject = '';

                if(isset($arr_trade['is_crypto_trade']) && $arr_trade['is_crypto_trade'] == '0')
                {
                    $url = url('/').'/seller/trade/interested-buyer-details/'.base64_encode($insert->id);
                    $subject = 'Buyer Apply for Market Trade';
                }
                else if(isset($arr_trade['is_crypto_trade']) && $arr_trade['is_crypto_trade'] == '1')
                {
                    $url = url('/').'/seller/CashMarkets/interested-buyer-details/'.base64_encode($insert->id);
                    $subject = 'Buyer Apply for Cash Trade';
                }

                $trade_ref = isset($insert->trade_ref)?$insert->trade_ref:'';

                $arr_event                 = [];
                $arr_event['from_user_id'] = $user_id;
                $arr_event['to_user_id']   = $arr_trade['user_id'];
                $arr_event['message']      = html_entity_decode('Buyer '.$user_name.' is applied for trade <b>'.$trade_ref.'</b>');
                $arr_event['url']          = $url;
                $arr_event['subject']      = $subject;

                $this->save_notification($arr_event);

                /*********************Notification END  ***************************/


                $response['status']      = 'success';
                $response['description'] = 'Applied Successfully';
            }
            else
            {
                $response['status']      = 'error';
                $response['description'] = 'Unable to applied';
            }
        }
        else
        {
            $response['status']      = 'error';
            $response['description'] = 'Trade not found..';
        }

        return response()->json($response);
    }

    /*
        listing() - show trades according to trade type
    */
    public function listing(Request $request)
    {   
        $arr_product = $category_arr = $graph_data = $slider_arr = [];
        
        $category = $request->category;
        $arr_product = $this->FirstLevelCategoryModel
                                        ->with(['category_details'=>function($q){
                                            return $q->where('is_active','1');
                                        }])
                                        ->get()->toArray();

        $category_obj =  $this->SecondLevelCategoryModel->where('name',$category)->first();

        if($category_obj)
        {
            $category_arr               = $category_obj->toArray();            
        }

        /*************************Get Trade Details START*******************************************/

            $page_no = 10;
            $final_trade_arr = [];

            $trade_table            = $this->ProductModel->getTable();
            $prefixed_trade_table   = DB::getTablePrefix().$this->ProductModel->getTable();

            $first_level_cat_table  = $this->FirstLevelCategoryModel->getTable();
            $prefixed_first_level   = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

            $second_level_cat_table = $this->SecondLevelCategoryModel->getTable();
            $prefixed_second_level  =  DB::getTablePrefix().$this->SecondLevelCategoryModel->getTable();

            $unit_table             = $this->UnitModel->getTable();
            $prefixed_unit          =  DB::getTablePrefix().$this->UnitModel->getTable(); 

            $user_table             = $this->UserModel->getTable();
            $prefixed_user          =  DB::getTablePrefix().$this->UserModel->getTable();  

            $user_location          = $this->ShippingAddressModel->getTable();
            $prefixed_user_location = DB::getTablePrefix().$this->ShippingAddressModel->getTable();
            

            $obj_trade  = DB::table($trade_table)
                            ->select(DB::raw(

                                $prefixed_trade_table.'.*,'.

                                $prefixed_first_level.'.id as first_category_id,'.
                                $prefixed_first_level.'.product_type,'.
                                $prefixed_first_level.'.id as product_id,'.
                                $prefixed_second_level.'.name as category,'.
                                $prefixed_second_level.'.slug as category_slug,'.
                                
                                $prefixed_second_level.'.is_active as category_is_active,'.
                               
                                $prefixed_user.'.user_name,'.
                                $prefixed_user.'.is_trusted,'.                                
                                $prefixed_user.'.profile_image,'.
                                $prefixed_user_location.'.address'
                                // $prefixed_rating.'.points'  
                            ))

                            ->leftjoin($prefixed_first_level,$prefixed_first_level.'.id','=',$prefixed_trade_table.'.first_level_category_id')

                            ->leftjoin($prefixed_second_level,$prefixed_second_level.'.id','=',$prefixed_trade_table.'.second_level_category_id')
                            
                            

                            ->leftjoin($prefixed_user,$prefixed_user.'.id','=',$prefixed_trade_table.'.user_id')

                            ->leftjoin($prefixed_user_location,$prefixed_user_location.'.user_id','=',$prefixed_trade_table.'.user_id')

                           
                            ->where($prefixed_second_level.'.is_active','1')
                            ->whereNull($prefixed_trade_table.'.deleted_at') 
                            ->orderBy($prefixed_trade_table.'.created_at','DESC'); 


            /****************************Filtering Logic START*****************************************/
              
                if(isset($request->product) && $request->product != '')
                {
                    $search_term = $request->product;
                    $obj_trade   = $obj_trade->where($prefixed_first_level.'.id',$search_term);
                }

                if(isset($request->category) && $request->category != '')
                {
                    $search_term = $request->category;
                    $obj_trade   = $obj_trade->where($prefixed_second_level.'.name','LIKE', '%'.$search_term.'%');
                }   

                if(isset($request->rating) && $request->rating !='')
                {
                    $search_term = $request->rating;

                    //get the trade ids that have rating selected by user
                    $rating_points_arr = $this->TradeRatingModel->where('points',$search_term)
                                                                ->get()->toArray();

                    $rating_sellers_ids =  array_column($rating_points_arr, 'seller_user_id');
                    $rating_sellers     = array_unique($rating_sellers_ids);
                                                    
                    $obj_trade      = $obj_trade->whereIn($prefixed_trade_table.'.user_id',$rating_sellers);
                }

                if(isset($request->price) && $request->price != '')
                {
                    $search_term = $request->price;
                    $price_arr   = explode("-", $search_term);
                    $min_price   = isset($price_arr[0])?$price_arr[0]:0;
                    $max_price   = isset($price_arr[1])?$price_arr[1]:0;

                    $obj_trade =  $obj_trade->whereBetween($prefixed_trade_table.'.unit_price',[$min_price,$max_price]);
                }

                if(isset($request->location) && $request->location != '')
                {
                    $search_term = $request->location;
                    $obj_trade   = $obj_trade->where($prefixed_user_location.'.address','LIKE', '%'.$search_term.'%');
                }

                if(isset($request->keyword) && $request->keyword != '')
                {          
                    $search_term = $request->keyword;
                    $obj_trade = $obj_trade->whereRaw(" ( ".$prefixed_first_level.".product_type LIKE  '%".$search_term."%' OR ".$prefixed_second_level.".name LIKE '%".$search_term."%' OR ".$prefixed_user_location.".address LIKE '%".$search_term."%' OR ".$prefixed_user.".user_name LIKE '%".$search_term."%')");
                  
                } 
            /*****************************Filtering Logic END********************************************/

            

            $trade_arr = $obj_trade->paginate($page_no);
           
            $total_trades_count = 0;
            $total_trades_count = $trade_arr->total();

            $logged_in_user_id   = 0;
            $logged_in_user_type = '';
            $loggedin_user       = false;

            if(Sentinel::check() == true)
            {
                $loggedin_user       = Sentinel::getUser();
                $logged_in_user_id   = $loggedin_user->id;
            }

            $active_user_role = "buyer";
            if(Session::has('active_user_role'))
            {
                $active_user_role = Session::get('active_user_role');
            }

            $crypto_symbol_arr  = [];
            $crypto_symbol      = "";
            $crypto_symbol_obj  = $this->GeneralSettingsModel->where('data_id','CRYPTO_SYMBOL')->first();
            if($crypto_symbol_obj)
            {
                $crypto_symbol = $crypto_symbol_obj->data_value;
            }


            foreach ($trade_arr as $key => $trade) 
            {
                $remaining_qty = 0;
                $max_qty       = isset($trade->quantity)?floatval($trade->quantity):0;
                $sold_out_qty  = isset($trade->sold_out_qty)?floatval($trade->sold_out_qty):0;

                $remaining_qty = $max_qty - $sold_out_qty;

                $unit_price = isset($trade->unit_price)?floatval($trade->unit_price):0;
                $unit       = isset($trade->unit)?$trade->unit:'';

                $final_trade_arr[$key]['user_name']    = isset($trade->user_name)?$trade->user_name:'';
                $final_trade_arr[$key]['product_type'] = isset($trade->product_type)?$trade->product_type:'';
                $final_trade_arr[$key]['category']     = isset($trade->category)?$trade->category:'';
                $final_trade_arr[$key]['address']      = isset($trade->address)?$trade->address:'';
                $final_trade_arr[$key]['quantity']     = isset($trade->product_stock)?$trade->product_stock:'';
                $final_trade_arr[$key]['unit_price']   = $unit_price.' '.$crypto_symbol;
                $final_trade_arr[$key]['is_trusted']   = $trade->is_trusted;
                $final_trade_arr[$key]['product_image']   = $trade->product_image;

                $category_image ='';
                if(isset($trade->category_image) && $trade->category_image != '' && file_exists(base_path().('/uploads/categories/').'/'.$trade->category_image))
                {
                    $category_image = url('/uploads/categories/').'/'.$trade->category_image;
                }
                else
                {
                    $category_image = url('/assets/images/no_image_available.jpg');
                }

                $final_trade_arr[$key]['category_image']   = $category_image;
                $final_trade_arr[$key]['id']     = $trade->id;

                
                $build_view_action = $build_chat_btn = "";
                if($loggedin_user != false && $active_user_role == 'buyer')
                {       
                    if(isset($logged_in_user_id) && $trade->user_id == $logged_in_user_id)
                    {       
                        $build_view_action = '<a href="javascript:void(0)" class="buy-button" onclick="swal(`warning`,`Sorry, You are not eligible to apply for your own Product`,`warning`)">
                            Buy
                        </a>';

                    }
                    else
                    {
                        $build_view_action = '<a href="javascript:void(0)" class="buy-button" data-toggle="modal" data-target="#InterestedBuyerDetails" data-trade_id="'.$trade->id.'" onclick="get_trade_detail($(this))">
                                Buy 
                            </a>';

                        $build_chat_btn = '<a class="chat-button" title="Chat With Seller" href="'.url('/buyer/chat/').'/'.base64_encode($trade->id).'">Chat</a>';
                    }
                }
                else
                {   
                    if($loggedin_user == false) 
                    {       
                       $build_view_action = '<a class="buy-button save-session" disabled> Buy </a>';
                       
                    }
                    else if($loggedin_user != false && $active_user_role == "seller")
                    {
                        if(isset($logged_in_user_id) && $trade->user_id==$logged_in_user_id)
                        {
                             $delete_href =  url('/seller/product/').'/delete/'.base64_encode($trade->id);
                             $confirm_delete = 'onclick="confirm_delete(this,event);"';

                             $edit_href = url('/seller/product/').'/edit/'.base64_encode(($trade->id));
                             $build_edit_button = '<a class="btn btn-circle btn-info btn-outline show-tooltip" href="'.$edit_href.'" title="Edit">Edit</a>';

                             $build_delete_action = '<a class="btn btn-circle btn-danger btn-outline show-tooltip" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                              $build_view_action = $build_edit_button.' '.$build_delete_action;
                        }else
                        {
                              $build_view_action = "";
                        }

                      
                    }
                }

                $final_trade_arr[$key]['buy_button']   = $build_view_action;
                $final_trade_arr[$key]['chat_button']   = $build_chat_btn;

            }   
            if($request->ajax()) 
            {     
                return response()->json(['trade_arr'=>$final_trade_arr]);
            }
            
            $lowest_price = $this->ProductModel->where('is_active','1')
                                             ->min('unit_price');

            $highest_price = $this->ProductModel->where('is_active','1')
                                             
                                             ->max('unit_price');

            $this->arr_view_data['total_trades_count'] = $total_trades_count;
            $this->arr_view_data['trade_arr']          = $final_trade_arr;

        /*************************Get Trade Details END*******************************************/
        
        //get slider data
        //get slider categories
        //get slider categories
        $slider_cat_arr = $this->SecondLevelCategoryModel->with(['unit_details'])
                                                         ->where('is_active','1')
                                                        
                                                         ->get()->toArray();

        $current_date   = date('Y-m-d');//curret date time        
        $yesterday_date = date('Y-m-d',strtotime('last day'));// 24 hours before date (1 day)
        $last_date      = date('Y-m-d',strtotime('-2 day'));// 2 days before date 
        
        // dd($current_date,$yesterday_date,$last_date);

        foreach ($slider_cat_arr as $outerkey => $category) 
        {
            $valume = 0;
            
            $avarage_volume_arr = $this->ProductModel
                                            ->where('second_level_category_id',$category['id'])
                                          
                                            
                                            ->get()->toArray();


            $available_qty = [];
        
            $valume = array_sum($available_qty);

            
             $current_avg_unit_price = $this->ProductModel
                                            ->where('second_level_category_id',$category['id'])
                                            ->where('is_active','1')
                                                           
                                            ->avg('unit_price');

            $last_day_record_arr = [];
         
            $last_day_record_obj = $this->TradeBuyHistoryModel
                                                        ->where('category_id',$category['id'])
                                                        ->whereBetween('created_at',[$yesterday_date, $current_date])  
                                                        ->first();
            if($last_day_record_obj)
            {
                $last_day_record_arr = $last_day_record_obj->toArray();
            }

            $last_day_avg_unit_price = 0;
            
            if(count($last_day_record_arr)>0)
            {
                $last_day_avg_unit_price = $last_day_record_arr['avg_unit_price'];
            }
            
             
            $percentChange = 0;
         
            
            if($last_day_avg_unit_price>$current_avg_unit_price && $last_day_avg_unit_price!=0 && $current_avg_unit_price!=0 )
            {
                $percentChange = (1 -  $current_avg_unit_price / $last_day_avg_unit_price) * 100;
            }
            else if($last_day_avg_unit_price!=0 && $current_avg_unit_price!=0 )
            {
             $percentChange = (1 - $last_day_avg_unit_price / $current_avg_unit_price ) * 100;   
            }
            else{
                $percentChange = 0;
            }
         
            $slider_arr[$outerkey]['category_name']        = $category['name'];
            $slider_arr[$outerkey]['unit']                 = $category['unit_details']['unit'];
            $slider_arr[$outerkey]['valume']               = $valume;
            $slider_arr[$outerkey]['current_unit_price']   = $current_avg_unit_price;
            $slider_arr[$outerkey]['last_day_unit_price']  = $last_day_avg_unit_price;
            $slider_arr[$outerkey]['percentChange']        = $percentChange;
        }   


       
        $this->arr_view_data['slider_arr']      = $slider_arr;
        $this->arr_view_data['lowest_price']    = $lowest_price;
        $this->arr_view_data['highest_price']   = $highest_price;
        $this->arr_view_data['arr_product']     = isset($arr_product)?$arr_product:[];
        $this->arr_view_data['category_arr']    = isset($category_arr)?$category_arr:[];
        
      
        return view($this->module_view_folder.'.listing',$this->arr_view_data);
        
    }


    public function get_trade_list_for_buyer(Request $request)
    {  
        $logged_in_user_id   = 0;
        $logged_in_user_type = '';
        $loggedin_user       = false;

        if(Sentinel::check() == true)
        {
            $loggedin_user       = Sentinel::getUser();
            $logged_in_user_id   = $loggedin_user->id;
            $logged_in_user_type = $loggedin_user->user_type;
        }

        $active_user_role = "buyer";
        if(Session::has('active_user_role'))
        {
            $active_user_role = Session::get('active_user_role');
        }

        $obj_trade =  $this->buyer_trade_list_details($request);

        $current_context = $this;

        $json_result = Datatables::of($obj_trade);  

        $json_result =  $json_result->editColumn('enc_id',function($data) use ($current_context)

                        {
                            return base64_encode($data->id);
                        })
                  
                        ->editColumn('product_type',function($data) use ($current_context)

                        {
                          if($data->product_type != "")
                          {
                             return $data->product_type;
                          }
                          else
                          {
                             return "N/A";
                          }
                         
                        })

                        ->editColumn('category',function($data) use ($current_context)
                       
                        {
                           if($data->category != "")
                           {
                              return $data->category;
                           }
                           else
                           {
                              return "N/A";
                           }
                        
                        })

                        ->editColumn('quantity',function($data) use ($current_context)
                        {
                           if($data->quantity != "")
                           {
                                $max_qty      = isset($data->quantity)?floatval($data->quantity):0;
                                $sold_out_qty = isset($data->sold_out_qty)?floatval($data->sold_out_qty):0;

                                $remaining_qty = $max_qty - $sold_out_qty;

                                return $remaining_qty.' '.$data->unit;
                           }
                           else
                           {
                                return "N/A";
                           }
                        
                        })

                        ->editColumn('unit_price',function($data) use ($current_context)
                        {
                           if($data->unit_price != "")
                           {    
                              return floatval($data->unit_price).' '.$data_crypto_symbol = get_crypto_symbol_details();
                               
                           }
                           else
                           {
                              return "N/A";
                           }
                        
                        })

                        ->editColumn('minimum_quantity',function($data) use ($current_context)
                        {   
                            $remaining_qty  = 0;
                            $max_qty        = isset($data->quantity)?floatval($data->quantity):0;
                            $min_qty        = isset($data->minimum_quantity)?floatval($data->minimum_quantity):0;
                            $sold_out_qty   = isset($data->sold_out_qty)?floatval($data->sold_out_qty):0;

                            $remaining_qty  = $max_qty - $sold_out_qty;

                            if($remaining_qty>$min_qty)
                            {
                                $remaining_qty = $min_qty;
                            }

                            return floatval($remaining_qty).' '.$data->unit;

                            
                        })

                        ->editColumn('user_name',function($data) use ($current_context)
                        {
                            if($data->user_name != "")
                            {    
                                return $data->user_name;
                            }
                            else
                            {
                                return "N/A";
                            }
                        })
                        ->editColumn('address',function($data) use ($current_context)
                        {
                            if($data->address != "")
                            {    
                                return $data->address;
                            }
                            else
                            {
                                return "N/A";
                            }
                        })

                        ->editColumn('build_action_btn',function($data) use ($current_context,$logged_in_user_type,$logged_in_user_id,$active_user_role,$loggedin_user)
                        {   
                            $build_view_action = '';
                          
                            if($loggedin_user != false && $active_user_role == 'buyer')
                            {       
                                if(isset($logged_in_user_id) && $data->user_id == $logged_in_user_id)
                                {       
                                    $build_view_action = '<a href="javascript:void(0)" class="buy-button" onclick="swal(`warning`,`Sorry, You are not eligible to apply for your own trade`,`warning`)">
                                        Buy
                                    </a>';
                                }
                                else
                                {
                                    $build_view_action = '<a href="javascript:void(0)" class="buy-button" data-toggle="modal" data-target="#InterestedBuyerDetails" data-trade_id="'.$data->id.'" onclick="get_trade_detail($(this))">
                                            Buy 
                                        </a>';
                                }
                                
                            }
                            else
                            {   
                                if($loggedin_user == false) 
                                {       
                                   $build_view_action = '<a href="javascript:void(0)" class="buy-button" disabled> Buy </a>';
                                   
                                }
                                else if($loggedin_user != false && $active_user_role == "seller")
                                {
                                    $build_view_action = "";
                                }
                            }
                            

                            return $build_action = $build_view_action;
                        })

                        ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

    public function buyer_trade_list_details(Request $request)
    {
        $trade_table            = $this->TradeModel->getTable();
        $prefixed_trade_table   = DB::getTablePrefix().$this->TradeModel->getTable();

        $first_level_cat_table  = $this->FirstLevelCategoryModel->getTable();
        $prefixed_first_level   = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

        $second_level_cat_table = $this->SecondLevelCategoryModel->getTable();
        $prefixed_second_level  =  DB::getTablePrefix().$this->SecondLevelCategoryModel->getTable();

        $unit_table             = $this->UnitModel->getTable();
        $prefixed_unit          =  DB::getTablePrefix().$this->UnitModel->getTable(); 

        $user_table             = $this->UserModel->getTable();
        $prefixed_user          =  DB::getTablePrefix().$this->UserModel->getTable();  

     
        $user_location          = $this->ShippingAddressModel->getTable();
        $prefixed_user_location = DB::getTablePrefix().$this->ShippingAddressModel->getTable();
        

        $obj_trade  = DB::table($trade_table)
                        ->select(DB::raw(

                            $prefixed_trade_table.'.*,'.

                            $prefixed_first_level.'.id as first_category_id,'.
                            $prefixed_first_level.'.product_type,'.
                            $prefixed_first_level.'.id as product_id,'.
                            $prefixed_second_level.'.name as category,'.
                            $prefixed_second_level.'.slug as category_slug,'.
                            $prefixed_unit.'.unit,'.
                            $prefixed_user.'.user_name,'.
                            $prefixed_user.'.profile_image,'.
                            $prefixed_user_location.'.address'
                          

                                  
                        ))

                        ->leftjoin($prefixed_first_level,$prefixed_first_level.'.id','=',$prefixed_trade_table.'.first_level_category_id')

                        ->leftjoin($prefixed_second_level,$prefixed_second_level.'.id','=',$prefixed_trade_table.'.second_level_category_id')
                        
                        ->leftjoin($prefixed_unit,$prefixed_unit.'.id','=',$prefixed_trade_table.'.unit_id')

                        ->leftjoin($prefixed_user,$prefixed_user.'.id','=',$prefixed_trade_table.'.user_id')

                        ->leftjoin($prefixed_user_location,$prefixed_user_location.'.user_id','=',$prefixed_trade_table.'.user_id')

                      
                        ->where($prefixed_trade_table.'.trade_type','1')
                        ->where($prefixed_trade_table.'.order_status','!=','2')
                        ->where($prefixed_trade_table.'.trade_status','0')
                        ->whereNull($prefixed_trade_table.'.deleted_at') 
                        ->orderBy($prefixed_trade_table.'.created_at','DESC'); 

       
        /* ---------------- Filtering Logic ----------------------------------*/
    
        $arr_search_column = $request->input('column_filter');

        if(isset($arr_search_column['q_trade_ref']) && $arr_search_column['q_trade_ref']!="")
        {
           $search_term  = $arr_search_column['q_trade_ref'];
           $obj_trade    = $obj_trade->where($prefixed_trade_table.'.trade_ref','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_product_type']) && $arr_search_column['q_product_type'] != '')
        {
            $search_term = $arr_search_column['q_product_type'];
            $obj_trade   = $obj_trade->having('product_type','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_category']) && $arr_search_column['q_category'] != '')
        {
            $search_term = $arr_search_column['q_category'];
            $obj_trade   = $obj_trade->having('category','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_product']) && $arr_search_column['q_product'] != '')
        {
            $search_term = $arr_search_column['q_product'];

            $obj_trade   = $obj_trade->having('product_id',$search_term);
        }

        if(isset($request->product) && $request->product != '')
        {
            $search_term = $request->product;

            $obj_trade   = $obj_trade->having('product_id',$search_term);
        }

        if(isset($request->category) && $request->category != '')
        {
            $search_term = $request->category;
            $obj_trade   = $obj_trade->having('category','LIKE', '%'.$search_term.'%');
        }

        if(isset($request->rating) && $request->rating !='')
        {
            $search_term = $request->rating;

            //get the trad ids that have rating selected by user
            $rating_points_arr = $this->TradeRatingModel->where('points',$search_term)
                                                        ->get()->toArray();

            $rating_sellers_ids =  array_column($rating_points_arr, 'seller_user_id');
            $rating_sellers     = array_unique($rating_sellers_ids);
                                            
            $obj_trade      = $obj_trade->whereIn($prefixed_trade_table.'.user_id',$rating_sellers);

        }
        /* --------------------------------------------------------------------*/

        return  $obj_trade; 

    }

    public function get_categories(Request $request)
    {
        $data           = [];
        $keywords       = $request->input('term');
        $category_id    = $request->input('product_id');
        
        if(isset($keywords) && $keywords!='')
        {        
            $categories_arr = $this->SecondLevelCategoryModel->where('first_level_category_id',$category_id)
                                                            ->where('name', 'LIKE', '%'.$keywords.'%')
                                                            ->get()->toArray();

        }

        if(count($categories_arr)>0)
        {
          foreach ($categories_arr as $key => $value)
          {
            $data[]  = $value['name'];
          }  
        }
        else
        {
            // $data[] = '';
        }

      return response()->json($data);    
    }

    public function cms_page($page_slug = false)
    {
        $cms_page_arr = [];

        $cms_page_obj = $this->StaticPageModel->where('page_slug',$page_slug)->first();

        if($cms_page_obj)
        {
            $cms_page_arr = $cms_page_obj->toArray();
        }
        else
        {
            return redirect()->back();
        }

        $this->arr_view_data['page_title']       = $page_slug;
        $this->arr_view_data['cms_page_arr']     = $cms_page_arr;
        $this->arr_view_data['meta_desc']        = $cms_page_arr['meta_desc'] or '';
        $this->arr_view_data['meta_keywords']    = $cms_page_arr['meta_keyword'] or '';

        return view($this->module_view_folder.'.cms_pages',$this->arr_view_data);
        
    }

    public function escrow_authorization()
    {
        $this->arr_view_data['page_title']       = 'Escrow Authorization';
        return view($this->module_view_folder.'.buyer.escrow_auth',$this->arr_view_data);
    }

    //Change user role from header
    public function switch_user($user_role = false)
    {   
        // dd($user_role);
        if(isset($user_role))
        {
            if($user_role == 'seller')
            {
                if(Sentinel::check())
                {
                    $logged_in_user_id = Sentinel::check()->id;
                  
                    /*Check is seller switch for first time*/

                    $get_isquestions_check = $this->UserModel->where('id',$logged_in_user_id)->first();

                    if(isset($get_isquestions_check) && $get_isquestions_check['is_check_seller_question'] == 0)
                    {
                       
                        Session::put('seller_question_check',$logged_in_user_id);

                       
                    }
                    Session::put('active_user_role',$user_role);    
                }
                
            }
            Session::put('active_user_role',$user_role);
        }
       return redirect()->back();
    }

    //get trade statistics to show  slider
    public function get_trade_statistics()
    {
         //get slider categories
        $slider_cat_arr = $this->SecondLevelCategoryModel->with(['unit_details'])
                                                         ->where('is_active','1')
                                                        
                                                         ->get()->toArray();

        $current_date   = date('Y-m-d');//curret date time        
        $yesterday_date = date('Y-m-d',strtotime('last day'));// 24 hours before date (1 day)
        $last_date      = date('Y-m-d',strtotime('-2 day'));// 2 days before date 
        
     

        foreach ($slider_cat_arr as $key => $category) 
        {
            //calculate avarage sell quantity since 24 hours
            $current_avarage_volume = $this->TradeModel
                                            ->where('second_level_category_id',$category['id'])
                                            ->whereIn('trade_status',[3,4])//buyer completed trade or payment
                                          
                                            ->where('trade_type','0')
                                            ->where('linked_to','!=',NULL)
                                            ->where('is_crypto_trade','0')
                                            ->limit(10)
                                            ->orderBy('id','DESC')
                                            ->avg('quantity');

            //calculate current unit price since last 24 hour
             $current_avg_unit_price = $this->TradeModel
                                            ->where('second_level_category_id',$category['id'])
                                           
                                            ->where('trade_type','0')
                                            ->where('linked_to','!=',NULL)
                                            ->where('is_crypto_trade','0')
                                            ->limit(10)
                                            ->orderBy('id','DESC')
                                            ->avg('unit_price');

            $last_day_record_arr = [];

       
            $last_day_record_obj = $this->TradeBuyHistoryModel
                                                        ->where('category_id',$category['id'])
                                                        ->whereBetween('created_at',[$yesterday_date, $current_date])  
                                                        ->first();

            if($last_day_record_obj)
            {
                $last_day_record_arr = $last_day_record_obj->toArray();
            }

            $last_day_avg_unit_price = 0;
            
            if(count($last_day_record_arr)>0)
            {
                $last_day_avg_unit_price = $last_day_record_arr['avg_unit_price'];
            }
            
            $percentChange = 0;
            
            if($last_day_avg_unit_price>$current_avg_unit_price && $last_day_avg_unit_price!=0 && $current_avg_unit_price!=0 )
            {
                $percentChange = (1 -  $current_avg_unit_price / $last_day_avg_unit_price) * 100;
            }
            else if($last_day_avg_unit_price!=0 && $current_avg_unit_price!=0 )
            {
             $percentChange = (1 - $last_day_avg_unit_price / $current_avg_unit_price ) * 100;   
            }
            else{
                $percentChange = 0;
            }
            
            $slider_arr[$key]['category_name']        = $category['name'];
            $slider_arr[$key]['unit']                 = $category['unit_details']['unit'];
            $slider_arr[$key]['valume']               = $current_avarage_volume;
            $slider_arr[$key]['current_unit_price']   = $current_avg_unit_price;
            $slider_arr[$key]['last_day_unit_price']  = $last_day_avg_unit_price;
            $slider_arr[$key]['percentChange']        = $percentChange;
        }

        $crypto_symbol_obj = $this->GeneralSettingsModel->where('data_id','CRYPTO_SYMBOL')->first();

        if($crypto_symbol_obj)
        {
            $crypto_symbol_arr = $crypto_symbol_obj->toArray();
        }
        
        
        $response['slider_arr']         = $slider_arr;
        $response['status']             = 'SUCCESS';
        $response['crypto_symbol_arr']  = $crypto_symbol_arr;

        return response()->json($response);
        
    }//end of function

    public function referalcode(Request $request)
    {   
       
        $this->arr_view_data=[];
        if(isset($request->referalcode))
        {
          
            $referalcode = $request->referalcode;

            $this->arr_view_data['referalcode'] =  $referalcode;
            $this->arr_view_data['page_title'] = 'Referal';
            return view($this->module_view_folder.'.refer',$this->arr_view_data);
           

        }//if isset code   
    }//end of function

    public function process_referal_email(Request $request)
    {       
       
        $response = [];
        $email = $request->email;
        $referalcode = $request->referalcode;
        if(isset($email) && isset($referalcode))
        {       
            $referearr =[];

            $getuser = $this->UserModel->where('referal_code',$referalcode)->where('is_active','1')->first();
            if(isset($getuser) && !empty($getuser))
            {
                $getuser = $getuser->toArray();
                $referearr['user_id'] = $getuser['id'];
            }

            //check email or referal code exist or not

            $user_exists = $this->UserReferWalletModel->where('email',$email)->count();

            if(isset($user_exists) && $user_exists == 1)
            {
                $response['status'] = "ERROR";
                $response['msg']    = "Reference link already sent to this email address, please try with a new one.";
                return $response;

            }


            $referearr['code'] = $referalcode;
            $referearr['email'] = $email;

            $this->UserReferedModel->create($referearr);
                      
           //send email to user
            $msg     = 'Please refer below url to signup with the <b> chow420 </b>.';

            $referurl = url('/').'/signup_seller/'.base64_encode($email).'/'.$referalcode;

            $subject = 'Referal For Chow';
            $arr_built_content = ['USER_NAME'     => $email,
                                  'APP_NAME'      => config('app.project.name'),
                                 // 'MESSAGE'       => $msg,
                                  'URL'           => $referurl
                                 ];

            $arr_mail_data2['email_template_id'] = '46';
            $arr_mail_data2['arr_built_content'] = $arr_built_content;
            $arr_mail_data2['arr_built_subject'] = '';
            $arr_mail_data2['user']              = $email;

            $this->EmailService->send_refer_mail($arr_mail_data2);
            $response['status'] = "SUCCESS";
            $response['msg']    = "Refer mail send successfully.";

            return $response;

        }//if isset email
        else
        {
             $response['status'] = "ERROR";
             $response['msg']    = "Something went wrong";  
             return $response;
        } 

        
    }//end of function of process

    public function update_product_limit()
    {
        $get_subscriptions = $this->UserSubscriptionsModel->orderBy('id','desc')->get();
        if(isset($get_subscriptions) && !empty($get_subscriptions))
        {
           $get_subscriptions = $get_subscriptions->toArray(); 
           foreach($get_subscriptions as $v)
           {
              $membership_id = $v['membership_id'];
              if($membership_id)
              {

                $get_productcount  = $this->MembershipModel->where('id',$membership_id)->first();
                
                if(!empty($get_productcount)){
                    $get_productcount = $get_productcount->toArray();
                    $product_count = $get_productcount['product_count'];

                    $updated = $this->UserSubscriptionsModel->where('membership_id',$membership_id)
                       ->update(array('product_limit'=>$product_count));
                       if($updated)
                       {
                        echo "Updated...";
                       }

                }//if getprdouctcount


              }//if membershipid

           }//foreach
        }//if subscription
    }//end of function


    public function update_hearaboutus(Request $request)
    {
        $response = [];
        $selleremail = $request->selleremail;
        $hear_about  = $request->hear_about;
        $sellerusertype = $request->sellerusertype;
         
         if(isset($selleremail) && isset($hear_about))
        { 

            $getuser = $this->UserModel->where('email',$selleremail)->first();
            if(isset($getuser) && !empty($getuser))
            {

                $getuser = $getuser->toArray();
                $user_id = $getuser['id'];

                $udpatedata = [];
                $udpatedata['hear_about'] = $hear_about;
                $this->UserModel->where('id',$user_id)->update($udpatedata);
                $response['status'] = "SUCCESS";
                $response['msg'] = "updated successfully.";
            }

            
        }
        else{
            $response['status'] = "ERROR";
            $response['msg'] = "Something went wrong";
        }    

        return $response;
    }//end function update_hearaboutus

    public function activationcode($email='')
    {   
      
            $this->arr_view_data=[];
      
            $this->arr_view_data['page_title'] = 'Activation';
            return view($this->module_view_folder.'.activationcode',$this->arr_view_data);
           

        
    }//end of function


     public function process_activationcode(Request $request)
    {       

        $response = [];
     
        $activationcode = $request->activationcode;
        $useremail = $request->useremail;
        if(isset($activationcode) && isset($useremail))
        {       


            $getuser = $this->UserModel->where(DB::raw('BINARY `activationcode`'),$activationcode)->where('email',$useremail)->first();
           

            if(isset($getuser) && !empty($getuser))
            {
                $getuser = $getuser->toArray();
                $user_id = $getuser['id'];
                $user_type = $getuser['user_type'];


                    $activation = Activation::createModel()->where(['user_id' => $user_id])->first();

                    if($activation == false)
                    {
                        $loguser = Sentinel::findById($getuser['id']);
                        $activation = Activation::create($loguser);
                       
                    }

                    $user = Sentinel::findById($activation->user_id);

                    if(Activation::completed($user) == true)
                    {
                           //check user details
                            $user = Sentinel::findById($getuser['id']);                           
                            //make autologin
                            $chk_auth = Sentinel::login($user);
                            if($chk_auth)
                            {

                             $response['status'] = "SUCCESS";
                             $response['msg'] = "Your account is already verified.";
                             $response['usertype'] = $user_type;
                             $response['already'] = 1;
                           }
                    }

                    if (Activation::complete($user, $activation->code))
                    {           
                       
                         
                            //check user details
                            $user = Sentinel::findById($getuser['id']);                           
                            //make autologin
                            $chk_auth = Sentinel::login($user);

                            if($chk_auth){
                                $response['status'] = "SUCCESS";
                                $response['msg'] = "Your account has been activated successfully.";
                                $response['usertype'] = $user_type;
                                $response['already'] = 0;
                            }

                    }//if activation complete

            }
            else{
                  $response['status'] = "ERROR";
                  $response['msg'] = "Activation code does not exists for this user.";  
            }
          
         

        }//if isset email
        else
        {
             $response['status'] = "ERROR";
             $response['msg'] = "Something went wrong";  
        } 
        return $response;
    }//end of function of process




     private function  get_user_details($email)
    {
        $credentials = ['email' => $email];
        $user = Sentinel::findByCredentials($credentials); // check if user exists

        if($user)
        {
          return $user;
        }
        return false;
    }//end

    public function resend_activationcode(Request $request)
    {       

        $response = [];
        $useremail = $request->useremail;
        if(isset($useremail) && !empty($useremail))
        {       


            $getuser = $this->UserModel->where('email',$useremail)->first();

            if(isset($getuser) && !empty($getuser))
            {
                $getuser = $getuser->toArray();
                $user_id = $getuser['id'];
                $user_type = $getuser['user_type'];
                $activationcode = $getuser['activationcode'];


                if(isset($getuser['activationcode']) && !empty($getuser['activationcode']))
              {
                $activationcodeforemail = $getuser['activationcode'];
              }
              else
              {
                  $create_actcode = unique_code(8);;
                  $update_activationcode =[];
                  $update_activationcode['activationcode'] = $create_actcode;
                  $this->UserModel->where('id',$getuser['id'])->update($update_activationcode);
                  $activationcodeforemail = $create_actcode;

              }//else of user activation code exists



                 if($useremail && $user_id && $activationcodeforemail)
                    {

                         $user = $this->get_user_details($useremail);
                    
                         if($user)
                         {
                            $arr_user = $user->toArray();
                            
                             $activation_url = '<span style="font-size:20px">'.$activationcodeforemail.'</span>';

                            $email_name ='';
                            if($arr_user['first_name']=="" || $arr_user['last_name']=="")
                            {
                              $email_name = $arr_user['email'];
                            }
                            else{
                               $email_name = $arr_user['first_name'].' '.$arr_user['last_name'];
                            }
                         


                          $arr_built_content = [
                                     // 'USER_FNAME'     => $arr_user['first_name'],
                                      'SELLER_NAME'    => $email_name, 
                                      'USER_FNAME'     => $email_name,
                                      'ACTIVATION_URL' => $activation_url,
                                      'APP_NAME'       => config('app.project.name')];

                          $arr_mail_data                      = [];
                          $arr_mail_data['email_template_id'] = '6';
                          $arr_mail_data['arr_built_content'] = $arr_built_content;
                           $arr_mail_data['arr_built_subject'] = '';
                          $arr_mail_data['user']              = $arr_user;

                          $email_status  = $this->EmailService->send_mail_section($arr_mail_data);

                          $response['status']      = 'SUCCESS';
                          $response['msg'] = ' Activation code send successfully.'; 
                          return response()->json($response);  

                        }//if user
                        else
                        {
                              $response['status']      = 'ERROR';
                              $response['msg'] = 'User does not exists.'; 
                              return response()->json($response); 
                        }
                    }//if email,userid,activationcode
                    else
                    {
                      $response['status']      = 'ERROR';
                      $response['msg'] = 'Something went wrong.'; 
                      return response()->json($response); 
                    }

            }
            else{
                  $response['status'] = "ERROR";
                  $response['msg'] = "User does not exists.";  
            }
          
                      
           
        }//if isset email
        else
        {
             $response['status'] = "ERROR";
             $response['msg'] = "Something went wrong";  
        } 
        return $response;
    }//end of function of resend activation code


    public function get_ip_address()
    {
        $ip_address = \Request::ip();
        return $ip_address;
    }
    public function get_session_id()
    {
         $session_id = session()->getId();
         return $session_id;
    }
    public function check_auth()
    {
        return \Sentinel::check();
    }


    public function buyerreferalcode(Request $request)
    {   
       // dd($request->referalcode);
        $this->arr_view_data=[];
        if(isset($request->referalcode))
        {
           
            $referalcode = $request->referalcode;

            $this->arr_view_data['referalcode'] =  $referalcode;
            $this->arr_view_data['page_title'] = 'Referal';
            return view($this->module_view_folder.'.referbuyer',$this->arr_view_data);
           

        }//if isset code   
    }//end of function buyerreferalcode



    public function process_buyerreferal_email(Request $request)
    {       
       
        $response = [];
        $email = $request->email;
        $referalcode = $request->referalcode;
        if(isset($email) && isset($referalcode))
        {       
            $referearr =[];

            $getuser = $this->UserModel->where('referal_code',$referalcode)->where('is_active','1')->first();
            if(isset($getuser) && !empty($getuser))
            {
                $getuser = $getuser->toArray();
                $referearr['user_id'] = $getuser['id'];
            }

              //check email or referal code exist or not

            $user_register_exists = $this->UserModel->where('email',$email)->count();

            if(isset($user_register_exists) && $user_register_exists == 1)
            {
                $response['status'] = "ERROR";
                $response['msg']    = "This email address alredy exists, please try with a new one.";
                return $response;

            }


            //check email or referal code exist or not

            $user_exists = $this->BuyerRegisteredReferModel->where('email',$email)->count();

            if(isset($user_exists) && $user_exists == 1)
            {
                $response['status'] = "ERROR";
                $response['msg']    = "Reference link already sent to this email address, please try with a new one.";
                return $response;

            }


            $referearr['code'] = $referalcode;
            $referearr['email'] = $email;

            $this->BuyerReferedModel->create($referearr);
                      
           //send email to user
            $msg     = 'Please refer below url to signup with the <b> chow420 </b>.';

            $referurl = url('/').'/signup/buyer/'.base64_encode($email).'/'.$referalcode;

            $subject = 'Referal For Chow';
            $arr_built_content = ['USER_NAME'     => $email,
                                  'APP_NAME'      => config('app.project.name'),
                                 // 'MESSAGE'       => $msg,
                                  'URL'           => $referurl
                                 ];

            $arr_mail_data2['email_template_id'] = '46';
            $arr_mail_data2['arr_built_content'] = $arr_built_content;
            $arr_mail_data2['arr_built_subject'] = '';
            $arr_mail_data2['user']              = $email;
            
                
            $this->EmailService->send_refer_mail($arr_mail_data2);
            $response['status'] = "SUCCESS";
            $response['msg']    = "Refer mail send successfully.";

            return $response;

        }//if isset email
        else
        {
             $response['status'] = "ERROR";
             $response['msg']    = "Something went wrong";  
             return $response;
        } 

        
    }//end of function of process


//get recently viewed products
public function get_recently_view_products(Request $request)
{
       //new name is recently viewed product

        $productid = isset($request->productid)?$request->productid:'';

        $user = Sentinel::check();
        $login_flag = '';

        $ip_address = $this->get_ip_address();
        $session_id = $this->get_session_id();

       
        if($user == false)
        {
          $login_flag = false;
        }
        else
        {
            $login_flag = true;
        }

        $arr_eloq_trending_data =  $this->ProductModel->with([
                                            'first_level_category_details',
                                            'second_level_category_details',
                                            'inventory_details',
                                            'product_images_details',
                                            'age_restriction_detail',
                                            'get_seller_details.get_country_detail', 
                                            'get_seller_details.get_state_detail', 
                                            'get_seller_additional_details',
                                            'get_brand_detail',
                                            'review_details',
                                            'get_view_products'
                                            ])
                                            ->whereHas('get_seller_details',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })


                                            ->whereHas('get_view_products', function ($q1)use($login_flag,$ip_address,$session_id,$user)
                                            {

                                                if($login_flag == false)
                                                {
                                                   $q1->where('ip_address',$ip_address);
                                                   $q1->where('user_session_id',$session_id);
                                                }
                                                else
                                                {
                                                   $q1->where('buyer_id',$user->id);
                                                }

                                                //$q1->where('user_session_id',$session_id);
                                                
                                            })
                                         
                                           // ->whereIn('id',$productidssold)    
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->orderBy('created_at','desc')
                                            ->limit('50');
            if(isset($productid) && !empty($productid))
            {
                $arr_eloq_trending_data = $arr_eloq_trending_data ->where('id','!=',$productid);
            }                                
                                       
            $arr_eloq_trending_data = $arr_eloq_trending_data->get();
                

            if(!empty($arr_eloq_trending_data))
            {
                $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
              
            }                         

       

        if(isset($productid) && !empty($productid))
        {
             $this->arr_view_data['you_may_like_similar_product'] = isset($arr_eloq_trending_data)?$arr_eloq_trending_data:[];
             return view($this->module_view_folder.'.recently_view_product_detail',$this->arr_view_data);

        }  
        else{
             $this->arr_view_data['arr_eloq_trending_data'] = isset($arr_eloq_trending_data)?$arr_eloq_trending_data:[];
            return view($this->module_view_folder.'.recently_view_product',$this->arr_view_data);
        } 


}

//get buy again products
public function get_buy_again_products(Request $request)
{
    $productid = isset($request->productid)?$request->productid:'';

    $loguser_id = 0;   
    $order_ids = $product_idsarr = $buy_again_product_arr = []; 

    $user = sentinel::check();

    if(isset($user) && $user!=false)
    {
        $loguser_id = $user->id;
    }

    
    $order_ids   = $this->OrderModel->where('buyer_id',$loguser_id)->where('order_status','1')->select('id')->get()->toArray();

    $product_idsarr    =  $this->OrderProductModel->whereIn('order_id',$order_ids)->select('product_id')->groupBy('product_id')->get()->toArray();

      

    if(isset($product_idsarr) && !empty($product_idsarr))
    {
          $buy_again_product_obj = $this->ProductModel
                                        ->with([
                                                    'first_level_category_details',
                                                    'second_level_category_details',
                                                    'inventory_details',
                                                    'product_images_details',
                                                    'age_restriction_detail',
                                                    'get_seller_details.get_country_detail', 
                                                    'get_seller_details.get_state_detail', 
                                                    'get_seller_additional_details',
                                                    'get_brand_detail',
                                                    'review_details'
                                            ])
                                        ->whereHas('get_seller_details',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->where([['is_active',1],['is_approve',1]])
                                         ->whereIn('id',$product_idsarr);
                                 
                                      
                 $buy_again_product_obj = $buy_again_product_obj
                                         
                                            ->get();

         
                if(isset($buy_again_product_obj))
                {
                   $buy_again_product_arr = $buy_again_product_obj->toArray();
                   
                }

        }//isset product_idsarr



      if(isset($productid) && !empty($productid))
        {
            $this->arr_view_data['buy_again_product_arr'] = isset($buy_again_product_arr)?$buy_again_product_arr:[];
             return view($this->module_view_folder.'.buy_again_product_detail',$this->arr_view_data);

        }  
        else{
            $this->arr_view_data['buy_again_product_arr'] = isset($buy_again_product_arr)?$buy_again_product_arr:[];
            return view($this->module_view_folder.'.buy_again',$this->arr_view_data);
        } 

}

//get trending on chow products
public function get_trending_on_chow(Request $request)
{
    $is_trending_product_arr = [];
        
    $is_trending_product_obj = $this->ProductModel
                                    ->with([
                                                'first_level_category_details',
                                                'second_level_category_details',
                                                'inventory_details',
                                                'product_images_details',
                                                'age_restriction_detail',
                                                'get_seller_details.get_country_detail', 
                                                'get_seller_details.get_state_detail', 
                                                'get_seller_additional_details',
                                                'get_brand_detail',
                                                'review_details'
                                        ])
                                    ->whereHas('get_seller_details',function($q){
                                            $q->where('is_active','1');
                                        })
                                    ->whereHas('get_seller_details.get_country_detail',function($q){
                                            $q->where('is_active','1');
                                        })
                                    ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                            $q->where('is_active', '1');
                                        })
                                    ->whereHas('get_brand_detail', function ($q) {
                                            $q->where('is_active', '1');
                                        })
                                    ->where([['is_active',1],['is_approve',1]])
                                    ->where('is_trending',1);
                                        //->orderBy('id','DESC')

         $is_trending_product_obj = $is_trending_product_obj
                                            ->inRandomOrder()
                                            ->limit(20)
                                            ->get();
        
        if(isset($is_trending_product_obj))
        {
           $is_trending_product_arr = $is_trending_product_obj->toArray();

        }//is_trending_product_obj

       $this->arr_view_data['is_trending_product_arr'] = isset($is_trending_product_arr)?$is_trending_product_arr:[];

       return view($this->module_view_folder.'.trending_onchow',$this->arr_view_data);    
}


//get shop by category 
public function get_shop_bycategory(Request $request)
{

    $arr_featured_category = $this->FirstLevelCategoryModel
                                  ->where('is_featured','1')
                                  ->where('is_active','1');     
                                                         
                                
    $arr_featured_category =  $arr_featured_category->inRandomOrder()->get()->toArray();

    $this->arr_view_data['arr_featured_category'] = isset($arr_featured_category)?$arr_featured_category:[]; 

    return view($this->module_view_folder.'.shop_by_category',$this->arr_view_data);

}

//get you may likes product
public function get_you_may_likes_products(Request $request)
{
       $productid = isset($request->productid)?$request->productid:'';

       $recntly_category=[]; $recently_products=[];

        $user = Sentinel::check();

        $login_flag = '';

        $ip_address = $this->get_ip_address();
        $session_id = $this->get_session_id();

       
        if($user == false)
        {
          $login_flag = false;
        }
        else
        {
            $login_flag = true;
        }



        /*get recently view products */

        $arr_eloq_trending_data =  $this->ProductModel->with([
                                            'first_level_category_details',
                                            'second_level_category_details',
                                            'inventory_details',
                                            'product_images_details',
                                            'age_restriction_detail',
                                            'get_seller_details.get_country_detail', 
                                            'get_seller_details.get_state_detail', 
                                            'get_seller_additional_details',
                                            'get_brand_detail',
                                            'review_details',
                                            'get_view_products'
                                            ])
                                            ->whereHas('get_seller_details',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })


                                            ->whereHas('get_view_products', function ($q1)use($login_flag,$ip_address,$session_id,$user)
                                            {

                                                if($login_flag == false)
                                                {
                                                   $q1->where('ip_address',$ip_address);
                                                   $q1->where('user_session_id',$session_id);
                                                }
                                                else
                                                {
                                                   $q1->where('buyer_id',$user->id);
                                                }

                                                
                                                
                                            })
                                         
                                           // ->whereIn('id',$productidssold)    
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->orderBy('created_at','desc')
                                            ->limit('50');
            if(isset($productid) && !empty($productid))
           {
             $arr_eloq_trending_data = $arr_eloq_trending_data->where('id','!=',$productid);
           }//if productid                           

            $arr_eloq_trending_data = $arr_eloq_trending_data->get();
                

            if(!empty($arr_eloq_trending_data))
            {
                $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
              
            }

     

     /*from recently view product get you may like products*/       

    if((isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data)))
    {  
            if(isset($arr_eloq_trending_data))
            {  
                $recntly_category = $recently_products = [];
                
                foreach($arr_eloq_trending_data as $key => $value) 
                {
                    $recntly_category[]  = $value['first_level_category_id'];
                    $recently_products[] = $value['id'];
                }

            }// if arr_eloq_trending_data


            $product_liked_arr = [];

            if(isset($recntly_category) && !empty($recntly_category) && isset($recently_products) && !empty($recently_products))
            {
      
                $product_liked_obj = $this->ProductModel
                                        ->with([
                                                    'first_level_category_details',
                                                    'second_level_category_details',
                                                    'inventory_details',
                                                    'product_images_details',
                                                    'age_restriction_detail',
                                                    'get_seller_details.get_country_detail', 
                                                    'get_seller_details.get_state_detail', 
                                                    'get_seller_additional_details',
                                                    'get_brand_detail',
                                                    'review_details'
                                            ])
                                        ->whereHas('get_seller_details',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->where([['is_active',1],['is_approve',1]])
                                        /*->orderByRaw('FIELD(first_level_category_id,'.$like_categoryids.')')*/
                                        ->whereIn('first_level_category_id',$recntly_category)
                                        ->whereNotIn('id',$recently_products);
                                       
                            $product_liked_obj = $product_liked_obj
                                        
                                            ->limit(20)
                                            ->get();

                if(isset($product_liked_obj))
                {
                    $product_liked_arr = $product_liked_obj->toArray();
                           
                }//         
            }// isset recntly_category && recently_products                        

    }//isset arr_eloq_trending_data  

        $this->arr_view_data['product_liked_arr'] = isset($product_liked_arr)?$product_liked_arr:[]; 

        if(isset($productid) && !empty($productid))
        {
            return view($this->module_view_folder.'.you_may_like_product_details',$this->arr_view_data);

        }
        else
        {
            return view($this->module_view_folder.'.you_may_like_products',$this->arr_view_data);

        }



}



//get shop by reviews
public function get_shop_by_reviews(Request $request)
{
    /*select all data from shop by effect table*/
        $arr_shop_by_effect = $this->ShopByEffectModel
                                    ->where('is_active','1')                
                                    ->get()->toArray(); 

    
    $this->arr_view_data['arr_shop_by_effect'] = isset($arr_shop_by_effect)?$arr_shop_by_effect:[];
     
    return view($this->module_view_folder.'.shop_by_reviews',$this->arr_view_data);                                
}


//get shop by spectrum
public function get_shop_by_spectrum(Request $request)
{
    $arr_shop_by_spectrum = $this->ShopBySpectrumModel
                                    ->where('is_active','1')                
                                    ->get()->toArray();

    $this->arr_view_data['arr_shop_by_spectrum'] = isset($arr_shop_by_spectrum)?$arr_shop_by_spectrum:[];       
    
    return view($this->module_view_folder.'.shop_by_spectrum',$this->arr_view_data);                         
}


//get chow choice product
public function get_chow_choice_products(Request $request)
{
    $chow_choice_product_arr = [];
        
    $chow_choice_product_obj = $this->ProductModel
                                        ->with([
                                                    'first_level_category_details',
                                                    'second_level_category_details',
                                                    'inventory_details',
                                                    'product_images_details',
                                                    'age_restriction_detail',
                                                    'get_seller_details.get_country_detail', 
                                                    'get_seller_details.get_state_detail', 
                                                    'get_seller_additional_details',
                                                    'get_brand_detail',
                                                    'review_details'
                                            ])
                                        ->whereHas('get_seller_details',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                        ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                        ->where([['is_active',1],['is_approve',1]])
                                        ->where('is_chows_choice',1);

                                   
                 $chow_choice_product_obj = $chow_choice_product_obj
                                            ->inRandomOrder()
                                            ->limit(20)
                                            ->get();

        
        if(isset($chow_choice_product_obj))
        {
           $chow_choice_product_arr = $chow_choice_product_obj->toArray();
           
        }


    $this->arr_view_data['chow_choice_product_arr'] = isset($chow_choice_product_arr)?$chow_choice_product_arr:[];

     return view($this->module_view_folder.'.chow_choice_products',$this->arr_view_data);

}

//get top brands product
public function get_top_brands_products(Request $request)
{
    /*select all featured Brands from brands table*/
    $arr_featured_brands = [];

    $arr_featured_brands = $this->BrandModel
                                ->where('is_active','1')
                                ->where('is_featured','1')
                                ->where('image','!=','')
                                ->inRandomOrder()
                                ->get()->toArray();


    $this->arr_view_data['arr_featured_brands'] = isset($arr_featured_brands)?$arr_featured_brands:[];

    return view($this->module_view_folder.'.top_brand_products',$this->arr_view_data);                                
}


//get chow wath data
public function get_chow_watch(Request $request)
{

        $arr_product_news = $this->ProductNewsModel
                                ->where('is_active','1') 
                                ->where('is_featured','1')                      
                                ->limit(20)
                                ->inRandomOrder()
                                ->get()
                                ->toArray(); 


        if(isset($arr_product_news) && count($arr_product_news)>0){

            foreach ($arr_product_news as $key => $data) {
                $url = isset($data['video_url'])&&$data['video_url']!=""?$data['video_url']:false;

                if($url!=false)
                {
                    $tmp_arr = explode("?v=", $url);
                    $url_id = isset($tmp_arr[1])?$tmp_arr[1]:'';
                    $arr_product_news[$key]['url_id'] = $url_id;

                }
            }
        }//if product news    


    $this->arr_view_data['arr_product_news'] = isset($arr_product_news)?$arr_product_news:[];
    
    return view($this->module_view_folder.'.chow_watch_section',$this->arr_view_data);                                 
}

//function for get real time events
public function get_events(Request $request)
{
    $arr_events = $this->EventModel->where('created_at','>=' , date('Y', strtotime('-1 year')))->orderBy('id','desc')->where('status','1')->limit(1000)->get()->toArray();


    if(isset($arr_events) && !empty($arr_events))
    {
            $k=1;
             foreach ($arr_events as $key1 => $data1) {
            $url = isset($data1['message']) && $data1['message']!=""?$data1['message']:false;

            if($url!=false)
            {
                $arr_events[$key1]['name'] = "ms".$k;
                $arr_events[$key1]['msg'] = $data1['message'];
                $arr_events[$key1]['delay'] = 1000;
                if($k%2==0)
                {
                    $arr_events[$key1]['align'] = "left";
                }else
                {
                     $arr_events[$key1]['align'] = "right";
                }
                 $arr_events[$key1]['showTime'] = true;
                 $arr_events[$key1]['time'] = date("d M Y H:i A",strtotime(date($data1['created_at'])));
                 unset($arr_events[$key1]['user_id']);
                 unset($arr_events[$key1]['updated_at']);
                 unset($arr_events[$key1]['message']);
                 unset($arr_events[$key1]['id']);
                $k++;
            }//urlnot false
        }//foreach

    }//isset events 

   
    $this->arr_view_data['arr_events'] = isset($arr_events)?$arr_events:[];

    return view($this->module_view_folder.'.events',$this->arr_view_data);

}


//get slider images data

function slider_images_data(Request $request)
{ 
    $arr_slider_images = [];

    $arr_slider_images = $this->SliderImagesModel->where('is_active','1')->get()->toArray();

    $arr_slider_images = array_chunk($arr_slider_images, 50);

    $this->arr_view_data['arr_slider_images'] = isset($arr_slider_images)?$arr_slider_images:[];


    return view($this->module_view_folder.'.homepage_sliders',$this->arr_view_data);
       
}


function get_highlights(Request $request)
{
    $arr_highlights = [];
    /*select all data from highlights table*/
    $arr_highlights = $this->HighlightModel
                           ->where('is_active','1')                
                           ->get()
                           ->toArray();


    $this->arr_view_data['arr_highlights'] = isset($arr_highlights)?$arr_highlights:[];                       
    return view($this->module_view_folder.'.highlights_section',$this->arr_view_data);
}


function get_tags(Request $request)
{
    $arr_tags = [];

    $arr_tags = $this->TagsModel->where('is_active','1')->get();
    
    if(isset($arr_tags) && !empty($arr_tags))
    {
        $arr_tags = $arr_tags->toArray();
    }
  
    $this->arr_view_data['arr_tags']  = isset($arr_tags)?$arr_tags:[];
 
    return view($this->module_view_folder.'.tag_section',$this->arr_view_data);
}





}//class

