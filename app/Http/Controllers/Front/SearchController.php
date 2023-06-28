<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Common\Services\ProductService;
use App\Models\ProductModel;
use App\Models\FirstLevelCategoryModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\UserModel;
use App\Models\BuyerModel; 
use App\Models\SellerModel;
use App\Models\FavoriteModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\ProductCommentModel;
use App\Models\ReviewRatingsModel;
use App\Models\BrandModel;
use App\Models\ReplyModel;
use App\Models\SellerBannerImageModel;
use App\Models\ReportproductModel;
use App\Models\StatesModel;
use App\Models\FollowModel;
use App\Models\CountriesModel;
use App\Models\IpDataModel;
use App\Models\SpectrumModel;
use App\Models\BannerImagesModel;
use App\Models\TagsModel;
use App\Models\ShopByEffectModel;
use App\Models\BuyerViewProductModel;
use App\Models\MoneyBackModel;

use App\Models\SuggestionCategoryModel;
use App\Models\SuggestionListModel;
use App\Models\ShopBySpectrumModel;
use App\Models\CannabinoidsModel;
use App\Models\ProductCannabinoidsModel;
use App\Models\ReportedEffectsModel;

  


use App\Common\Services\EmailService;
use App\Common\Services\GeneralService;


use Validator;
use Sentinel;
use DB;
use Datatables;
use Flash; 
use Session; 

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function __construct( 
    								ProductModel $ProductModel,
    								FirstLevelCategoryModel $FirstLevelCategoryModel,
                                    SecondLevelCategoryModel $SecondLevelCategoryModel,
    								
    								
                                    UserModel $UserModel,
                                    BuyerModel $BuyerModel,
                                    SellerModel $SellerModel,
                                    ProductService $ProductService,
                                    EmailService $EmailService,
                                    GeneralService $GeneralService,
                                    //ProductService $ProductService,
                                
                                    FavoriteModel $FavoriteModel,
                                    ProductCommentModel $ProductCommentModel,
                                    OrderModel $OrderModel,
                                    OrderProductModel $OrderProductModel,
                                    ReviewRatingsModel $ReviewRatingsModel,
                                    BrandModel $BrandModel,
                                    ReplyModel $ReplyModel,
                                    SellerBannerImageModel $SellerBannerImageModel,
                                    ReportproductModel $ReportproductModel,
                                    StatesModel $StatesModel,
                                    FollowModel $FollowModel,
                                    CountriesModel $CountriesModel,
                                    IpDataModel $IpDataModel,
                                    SpectrumModel $SpectrumModel,
                                    BannerImagesModel $BannerImagesModel,
                                    TagsModel $TagsModel,
                                    ShopByEffectModel $ShopByEffectModel,
                                    BuyerViewProductModel $BuyerViewProductModel,
                                    MoneyBackModel $MoneyBackModel,
                                    SuggestionCategoryModel $SuggestionCategoryModel,
                                    SuggestionListModel $SuggestionListModel,
                                    ShopBySpectrumModel $ShopBySpectrumModel,
                                    CannabinoidsModel $CannabinoidsModel,
                                    ProductCannabinoidsModel $ProductCannabinoidsModel,
                                    ReportedEffectsModel $ReportedEffectsModel

    						   )
    {
	 
    	$this->ProductModel         	  = $ProductModel;
    	$this->FirstLevelCategoryModel    = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel   = $SecondLevelCategoryModel;
        $this->SuggestionListModel        =  $SuggestionListModel;
        $this->SuggestionCategoryModel    = $SuggestionCategoryModel;
    	
    	
    	$this->BaseModel                = $ProductModel;
        $this->UserModel                = $UserModel;
        $this->BuyerModel               = $BuyerModel;
        $this->SellerModel              = $SellerModel;

        $this->ProductService           = $ProductService;

        $this->FavoriteModel            = $FavoriteModel;
        $this->ProductCommentModel      = $ProductCommentModel;
        $this->OrderModel               = $OrderModel;
        $this->OrderProductModel        = $OrderProductModel;
        $this->ReviewRatingsModel       = $ReviewRatingsModel;
        $this->BrandModel               = $BrandModel;    
        $this->ReplyModel               = $ReplyModel;
        $this->ReportproductModel       = $ReportproductModel;

        $this->ProductService           = $ProductService;
        $this->MoneyBackModel            = $MoneyBackModel;

        $this->EmailService              = $EmailService;
        $this->GeneralService            = $GeneralService;

        $this->StatesModel               = $StatesModel;
        $this->FollowModel               = $FollowModel;

        $this->CountriesModel            = $CountriesModel;
        $this->StatesModel               = $StatesModel;
        $this->IpDataModel               = $IpDataModel;
        $this->SpectrumModel             = $SpectrumModel;
        $this->BannerImagesModel         = $BannerImagesModel;
        $this->TagsModel                 = $TagsModel;
        $this->ShopByEffectModel         = $ShopByEffectModel;
 
        $this->BuyerViewProductModel      = $BuyerViewProductModel;

        $this->ShopBySpectrumModel        = $ShopBySpectrumModel;
        $this->CannabinoidsModel          = $CannabinoidsModel;
        $this->ProductCannabinoidsModel        = $ProductCannabinoidsModel;
        $this->ReportedEffectsModel       = $ReportedEffectsModel;

        $this->module_view_folder         = 'front.product';
        $this->module_url_path            = url('/product');
        $this->back_path                  = url('/').'/product';

        $this->product_image_base_img_path   = base_path().config('app.project.img_path.product_images');
        $this->product_image_public_img_path = url('/').config('app.project.img_path.product_images');
        // $this->shipmentproofs_public_path = url('/').config('app.project.shipment_proofs');
        // $this->shipmentproofs_base_path   = base_path().config('app.project.shipment_proofs');
        $this->module_title               = 'Product';
        $this->arr_view_data              = [];
        $this->SellerBannerImageModel     = $SellerBannerImageModel;
    }
    public function get_rating_arr($rating)
    {
        $review_table        = $this->ReviewRatingsModel->getTable();
        $prefix_brand_table = DB::getTablePrefix().$this->ReviewRatingsModel->getTable(); 

        $res_productratings=[];
        if($rating){

            if($rating==1)
                $limit = 0.4;
            elseif($rating>1)
                $limit =$rating-1;

            $res_productratings = \DB::table($review_table)
                    ->select($review_table.'.product_id')
                    ->selectRaw('AVG(product_rating_review.rating) AS average_rating')
                   // ->whereBetween('AVG(product_rating_review.rating)',array($limit,$rating))
                    ->groupBy($review_table.'.product_id')
                   // ->havingRaw('AVG(product_rating_review.rating) <= ?', [$rating])
                     ->havingRaw('AVG(product_rating_review.rating) > ?', [$limit])
                     ->havingRaw('AVG(product_rating_review.rating) <= ?', [$rating])
                    ->pluck($review_table.'.product_id');
            
            return $res_productratings;
        }

    }// end of rating function 


    //this function for calculate admin and buyer rating
    public function get_buyer_admin_rating_arr($rating)
    { 
        $product_id_arr = $final_product_id_arr = [];
        $buyer_avg_rating = $final_avg = 0.0;

        $review_table        = $this->ReviewRatingsModel->getTable();
        $prefix_brand_table  = DB::getTablePrefix().$this->ReviewRatingsModel->getTable(); 


            if($rating==1)
                $limit = 0.4;
            elseif($rating>1)
                $limit =$rating-1;
            else 
                $limit = 1;


            $product_id_arr = \DB::table($review_table)
                                ->select($review_table.'.product_id')
                                ->selectRaw('AVG(product_rating_review.rating) AS average_rating')
                              
                                ->groupBy($review_table.'.product_id')
                               
                                ->havingRaw('AVG(product_rating_review.rating) > ?', [$limit])
                                ->havingRaw('AVG(product_rating_review.rating) <= ?', [$rating])
                                ->get()
                                ->toArray();

                       

  
        if(isset($product_id_arr) && count($product_id_arr)>0)
        {
            foreach ($product_id_arr as $key => $value)
            { 
                $admin_rating  = $this->ProductModel->where('id',$value->product_id)
                                                    ->pluck('avg_rating')
                                                    ->first();

             
                if(isset($admin_rating) && $admin_rating!=null && $admin_rating!='' &&
                    isset($value->average_rating) && $value->average_rating!=null && $value->average_rating!='')
                { 
                   $final_avg = (floatval($admin_rating)+floatval($value->average_rating))/2;

                   
                }
                elseif(!isset($admin_rating) && $admin_rating==null && $admin_rating=='' &&
                       isset($value->average_rating) && $value->average_rating!=null && $value->average_rating!=''
                      )
                {
                   $final_avg = floatval($value->average_rating);   
                }
                elseif(isset($admin_rating) && $admin_rating!=null && $admin_rating!='' &&
                       !isset($value->average_rating) && $value->average_rating==null && $value->average_rating=='')
                {
                    $final_avg = floatval($admin_rating);
                }

                $final_avg = round_rating_in_half($final_avg);

                //check rating

                if($final_avg >= '0.5' && $final_avg <= '1' && $rating >= '0.5' && $rating <= '1')
                {
                    $final_product_id_arr[] = $value->product_id;
                } 

                if($final_avg > '1' && $final_avg <= '2' && $rating > '1' && $rating <= '2')
                { 
                   $final_product_id_arr[] = $value->product_id;
                }

                if($final_avg > '2' && $final_avg <= '3' && $rating > '2' && $rating <= '3')
                {
                   $final_product_id_arr[] = $value->product_id;
                }

                if($final_avg > '3' && $final_avg <= '4' && $rating > '3' && $rating <= '4')
                {
                   $final_product_id_arr[] = $value->product_id;
                }

                if($final_avg > '4' && $final_avg <='5' && $rating > '4' && $rating <='5')
                {
                    $final_product_id_arr[] = $value->product_id;
                }

                if($final_avg  > '5' && $rating >'5')
                {
                   $final_product_id_arr[] = $value->product_id;
                }


            }
           
        }
        else
        {
             $final_product_id_arr = [];
        }


        return  $final_product_id_arr;
        
    }

  
    public function get_seller_info_arr($sellers)
    {
           $res_sellerinfo=[];
            $sellername = explode("-", $sellers);
            $seller_name = explode(" ", $sellers);
            if(!empty($sellername) && isset($sellername[0]) && isset($sellername[1])){ 
            $firstname = $sellername[0];
            $lastname  = $sellername[1];
            $res_sellerinfo = $this->UserModel->select('id')->where('first_name',$firstname)->where('last_name',$lastname)->first();
                //->toArray(); 
               if(!empty($res_sellerinfo)){
                $res_sellerinfo = $res_sellerinfo->toArray();
               }
            }
            elseif(!empty($seller_name) && isset($seller_name[0]) && isset($seller_name[1])){ 
             $firstname = $seller_name[0];
             $lastname  = $seller_name[1];
             $res_sellerinfo = $this->UserModel->select('id')->where('first_name',$firstname)
                 ->where('last_name',$lastname)->first();
                 //->toArray(); 
                  if(!empty($res_sellerinfo)){
                       $res_sellerinfo = $res_sellerinfo->toArray();
                       }       
            }
            elseif(!empty($sellers) && isset($sellers))  
            {    
               $res_sellerinfo = $this->UserModel->select('id')->where('first_name','like','%'.$sellers.'%')->orWhere('last_name','like','%'.$sellers.'%')->first();    
               if(!empty($res_sellerinfo)){
                $res_sellerinfo = $res_sellerinfo->toArray();
               }       
            }
            return $res_sellerinfo;
    }
 


     public function get_seller_business_arr($businessname)
    {
            $res_businessinfo=[];
            if(!empty($businessname) && isset($businessname)){ 
            $businessname = str_replace('-',' ',$businessname);  

            if($businessname)
            {

               $res_businessinfo = $this->SellerModel->select('*')->where('business_name','=',$businessname)
                ->first();


                if(empty($res_businessinfo))
                {
                  $res_businessinfo = $this->SellerModel->where('business_name','like',$businessname.'%')
                  ->first();
                }
            } 
   
            if(!empty($res_businessinfo)){
                $res_businessinfo = $res_businessinfo->toArray();
               }
            }
            return $res_businessinfo;
    }




    //new function added for search
    public function search(Request $request)
    {   
  
        $ProductCannabinoidsModel         = $this->ProductCannabinoidsModel->getTable();
        $prefix_ProductCannabinoidsModel = DB::getTablePrefix().$this->ProductCannabinoidsModel->getTable();

        $CannabinoidsModel         = $this->CannabinoidsModel->getTable();
        $prefix_CannabinoidsModel = DB::getTablePrefix().$this->CannabinoidsModel->getTable();

        $chows_choice   = $request->input('chows_choice');
        $best_seller    = $request->input('best_seller');
        $sellers    = $request->input('sellers');

        $this->arr_view_data['banner_images_type'] = "";

        if ((isset($chows_choice) && $chows_choice == "true") && (isset($best_seller) && $best_seller == "true") ) {

            $this->arr_view_data['banner_images_type'] = "both"; 
        }
        elseif (isset($chows_choice) && $chows_choice == "true") {

            $this->arr_view_data['banner_images_type'] = "chows_choice"; 

        }elseif (isset($best_seller) && $best_seller == "true") {

            $this->arr_view_data['banner_images_type'] = "best_seller"; 
        }
        elseif (isset($sellers) && !empty($sellers)) {

            $this->arr_view_data['banner_images_type'] = "sellers"; 
        }


         $get_banner_images = $this->BannerImagesModel->first();
       if(isset($get_banner_images) && !empty($get_banner_images))
       {
          $get_banner_images = $get_banner_images->toArray();
       }
        $this->arr_view_data['banner_images_data']  = isset($get_banner_images)?$get_banner_images:[];
        



         $arr_tags = $this->TagsModel->where('is_active','1')->get();
        if(isset($arr_tags) && !empty($arr_tags))
        {
            $arr_tags = $arr_tags->toArray();
        }
       $this->arr_view_data['arr_tags']  = isset($arr_tags)?$arr_tags:[];


        
        /*******************Restricted states seller id***********************************/

       $check_buyer_restricted_states =  get_buyer_restricted_sellers();
       $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];

        $allowed_state_sellers = [];
        if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids)){

              $allowed_state_sellers = [];
              foreach($restricted_state_user_ids as $sellers) {
                $allowed_state_sellers[] = $sellers['id'];
              }
           }
          // dd($allowed_state_sellers);

        $is_buyer_restricted_forstate = is_buyer_restricted_forstate();
       /********************Restricted states seller id***********************/

       /* $stateofuser = Session::get('stateofguestuser');
        $login_user = Sentinel::check();  
         if(isset($login_user) && $login_user==true && $login_user->inRole('seller') == true) 
         {
            Session::forget('stateofguestuser');

         }
         else if(isset($login_user) && $login_user==true && $login_user->inRole('admin') == true) {
            Session::forget('stateofguestuser');

         }
        else if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true)
         {
             Session::forget('stateofguestuser');
               $user_shipping_state  = $login_user->state;
               if(isset($user_shipping_state))
               {
                 $stateofuser = get_statedata($user_shipping_state);
               }else{
                   $stateofuser = '';
               }

         }*/

         /******************location***start***************************/   
         $checkuser_locationdata = checklocationdata(); 
         if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
         {
           $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
           $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
         } 
         /******************location*end*****************************/
        
      
        //By default page tite will be same as module title, but if user is searching according to seller business name it should show the business name as page title
        $this->arr_view_data['page_title']   = $this->module_title;

        $arr_product = $fav_product_arr = $apppend_data= [];
        $user_id = 0;   
        $user = sentinel::check();
        if(isset($user) && $user!=false)
        {
            $user_id = $user->id;

            $get_loginuserinfo = $this->UserModel->with('seller_detail')->where('id',$user_id)->first();
            if(isset($get_loginuserinfo) && !empty($get_loginuserinfo))
            {
                $get_loginuserinfo = $get_loginuserinfo->toArray();

            }


        }
        $obj_buyer_id_proof = $this->BuyerModel->where('user_id',$user_id)->first();
        if ($obj_buyer_id_proof) {
            $buyer_id_proof = $obj_buyer_id_proof->toArray();
        }
        $lowest_price = $this->ProductModel->where([['is_active','1'],['is_approve',1]])
                                            ->min('unit_price');
        $highest_price = $this->ProductModel->where([['is_active','1'],['is_approve',1]])
                                            ->max('unit_price');
         $highest_mg = $this->ProductModel->where([['is_active','1'],['is_approve',1]])
                                          ->max('per_product_quantity'); 
         $lowest_mg  = $this->ProductModel->where([['is_active','1'],['is_approve',1]])
                                          ->min('per_product_quantity');                                   
        $search_request = $request->all();
        $review_table        = $this->ReviewRatingsModel->getTable();
        $prefix_brand_table = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();  
 
         $obj_product = $this->ProductModel->with([
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
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                             ->whereHas('get_seller_details', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->where([['is_active',1],['is_approve',1]])
                                           // ->orderBy('id', 'DESC')
                                            ->inRandomOrder();





        if(isset($search_request['best_seller'])) 
        {             
          $productids = $avgproductids = [];

          $prodmodel           = $this->ProductModel->getTable();
          $prefix_productable  = DB::getTablePrefix().$this->ProductModel->getTable();

          $order_table         = $this->OrderModel->getTable();
          $prefix_order_detail = DB::getTablePrefix().$this->OrderModel->getTable();

          $order_product_table  = $this->OrderProductModel->getTable();
          $prefix_order_product = DB::getTablePrefix().$this->OrderProductModel->getTable();

          $reviewmodel         = $this->ReviewRatingsModel->getTable();
          $prefix_reviewtable  = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();

          /*
          $arr_trending_productids = DB::table($prefix_order_detail)
                                       ->select(DB::raw($prefix_order_detail.'.*,'
                                         .$prefix_order_product.'.product_id'
                                    ))
                                    ->leftJoin($prefix_order_product,$prefix_order_product.'.order_id','=',$prefix_order_detail.'.id')    
                                    ->where($prefix_order_detail.'.order_status','1')  
                                    ->get()
                                    ->toArray(); */

          $arr_trending_productids =  DB::table($prefix_order_detail)->select(DB::raw(
                                        $prefix_order_product.'.product_id,count('.$prefix_order_product.'.product_id) as mostsold'
                                    ))
                                  ->leftJoin($prefix_order_product,$prefix_order_product.'.order_id','=',$prefix_order_detail.'.id')    
                                 ->where($prefix_order_detail.'.order_status','1')  
                                 ->groupBy($prefix_order_product.'.product_id')
                                 ->orderBy('mostsold','desc')
                                 //->limit(50)
                                //->toSql();                    
                                ->get()->toArray(); 


          if(isset($arr_trending_productids) &&!empty($arr_trending_productids))
            {  
                 $productidssold   = array_column($arr_trending_productids, 'product_id');
                 $mostsold         = array_unique(array_column($arr_trending_productids, 'mostsold'));
                 $arr = []; $mostsolded ='';
                 foreach($mostsold as $v)
                 {
                    $arr[] = $v;
                 }
                 
                 $mostsolded = implode(",", $arr);

            }//if isset arr_mostsold_productids
                          
             if(isset($arr_trending_productids) && !empty($arr_trending_productids) && isset($mostsolded) &&  !empty($mostsolded))
            {
                $productids   = array_column($arr_trending_productids, 'product_id');

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
                                           /*->whereHas('review_details',function($q){
                                                $q->havingRaw('AVG(rating) >= ?', [4]);
                                                $q->havingRaw('AVG(rating) <= ?', [5]);
                                                $q->groupBy('product_id'); 
                                            })*/ 
                                            ->whereIn('id',$productids)    
                                            ->where([['is_active',1],['is_approve',1]])
                                           // ->orderByRaw('FIELD(id,'.$mostsolded.')')
                                            ->get();

                                            //->orderBy('created_at','desc')
                                           
                                           /* if(isset($state_user_ids) && !empty($state_user_ids))
                                             {
                                                $arr_eloq_todaysdeals_data = $arr_eloq_todaysdeals_data->whereIn('user_id',$state_user_ids);
                                             }  
                                            if(isset($catdata) && !empty($catdata))
                                            {
                                              $arr_eloq_todaysdeals_data = $arr_eloq_todaysdeals_data->whereNotIn('first_level_category_id',$catdata);
                                            }*/

               /* $arr_eloq_trending_data =  $this->ReviewRatingsModel
                                            ->with([
                                                'product_details',
                                                'product_details.age_restriction_detail',
                                                'product_details.get_brand_detail',
                                                'product_details.product_images_details',
                                            'product_details.get_seller_details.get_country_detail',
                                            'product_details.get_seller_details.get_state_detail'
                                            ])
                                            ->whereHas('product_details',function($q){
                                                     $q->where('is_active','1');
                                                     $q->where('is_approve','1');
                                                  
                                            })
                                            ->whereHas('product_details.get_seller_details',function($q){
                                                    $q->where('is_active','1');
                                            })

                                            ->whereHas('product_details.get_brand_detail',function($q){
                                                    $q->where('is_active','1');
                                            })
                                            ->whereHas('product_details.get_seller_details.get_country_detail',function($q){
                                                    $q->where('is_active','1');
                                            })
                                            ->whereHas('product_details.get_seller_details.get_state_detail',function($q){
                                                    $q->where('is_active','1');
                                            })
                                            ->addSelect(DB::raw('AVG(product_rating_review.rating) 
                                                          as avg_rating,product_id'
                                                        ))
                                             ->havingRaw('AVG(product_rating_review.rating) >= ?', [4])
                                            ->havingRaw('AVG(product_rating_review.rating) <= ?', [5])

                                            ->whereIn('product_id',$productids)      
                                            ->groupBy('product_rating_review.product_id')
                                            ->orderBy('avg_rating','desc')
                                            ->get();*/
 
                if(isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data))
                {
                    $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
                    $avgproductids   = array_column($arr_eloq_trending_data, 'id');
                    $obj_product->whereIn('id',$avgproductids);
                }                                    

            }//if not empty arr_trending_productids                        
            
            $best_seller = $search_request['best_seller'];            
            $apppend_data['best_seller'] = $best_seller;
        }// end of best seller  
                                          



        if (isset($search_request['chows_choice'])) 
        {             
            
            $chows_choice = $search_request['chows_choice']; 
            $obj_product->where('is_chows_choice','=','1');
            $apppend_data['chows_choice'] = $chows_choice;
        }// end of chowschoice                                       

        if (isset($search_request['filterby_price_drop'])) 
        {             
            
            $filterby_price_drop = $search_request['filterby_price_drop']; 
            $obj_product->where('price_drop_to','>','0');
            $apppend_data['filterby_price_drop'] = $filterby_price_drop;
        }// end of seller  
        
        if (isset($search_request['seller'])) 
        {
            
            $seller = $search_request['seller']; 
            $obj_product->where('user_id',base64_decode($seller));
            $apppend_data['seller'] = $seller;
        }// end of seller      
        if (isset($search_request['brand'])) 
        {
            
            $brand = $search_request['brand']; 
            $obj_product->where('brand',base64_decode($brand));
            $apppend_data['brand'] = $brand;
        }// end of click of seller on product details page       
        
     

        if (isset($search_request['sellers'])) 
        {
            $sellers = $search_request['sellers']; 
            $res_sellerinfo = $this->get_seller_business_arr($sellers);

             if(!empty($res_sellerinfo) && isset($res_sellerinfo)){ 
                $seller_id = $res_sellerinfo['user_id'];
                $obj_product->where('user_id',$seller_id);
             }else{
                 $obj_product->where('user_id','');
             }

            if(!empty($res_sellerinfo) && isset($res_sellerinfo)){  
                $seller_id = $res_sellerinfo['user_id'];
                $arr_seller_banner = [];
                $obj_seller_banner = $this->SellerBannerImageModel->where('seller_id',$seller_id)->first();
                if($obj_seller_banner)
                {
                    $arr_seller_banner = $obj_seller_banner->toArray();
                }
                $apppend_data['sellers'] = $sellers;     
             }

            $seller_business_name = isset($res_sellerinfo['business_name'])?$res_sellerinfo['business_name']:'';
            $this->arr_view_data['page_title']  = $seller_business_name;         
        }



        // end of search by sellers                    
        if (isset($search_request['brands'])) 
        {
             $brands = $search_request['brands'];  
             $brandname = str_replace('-',' ',$search_request['brands']);  
           
            if($brandname)
            {

                // $getbrand_id = $this->BrandModel->where('name','=',$brandname)->get()->toArray();

                // if(empty($getbrand_id))
                // {
                //   $getbrand_id = $this->BrandModel->where('name','like',$brandname.'%')->get()->toArray();

                // }

                // if(!empty($getbrand_id) && isset($getbrand_id))
                // {
                //    $brandid = isset($getbrand_id[0]['id'])?$getbrand_id[0]['id']:''; 
                //     if(isset($brandid)){
                //      $obj_product->where('brand',$brandid);
                //    }
                // }else{
                //    $obj_product->where('brand','');
                // }

                 $getbrand_id = $this->BrandModel->where('name','=',$brandname)->first();
                 if(empty($getbrand_id))
                 {
                     $getbrand_id = $this->BrandModel->where('name','like',$brandname.'%')->first();
                 }

                 if(isset($getbrand_id) && !empty($getbrand_id))
                 {
                    $getbrand_id = $getbrand_id->toArray();

                    $brandid = isset($getbrand_id['id'])?$getbrand_id['id']:'';
                     if(isset($brandid)){
                         $obj_product->where('brand',$brandid);
                     }else{
                        $obj_product->where('brand','');
                     }
                 }


            }
            $apppend_data['brands'] = $brands;

        }// end of search by brands

        if(isset($search_request['category_id'])) 
        {
            $categories = $search_request['category_id'];  
            $category_name = str_replace('-and-','-&-',$search_request['category_id']);             
            $category_name = str_replace('-',' ',$category_name); 
            

            if($category_name)
            {

                $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','=',$category_name)->get()->toArray();

                if(empty($getcategory_id))
                {
                  $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','like',$category_name.'%')->get()->toArray();

                }

                if(!empty($getcategory_id) && isset($getcategory_id))
                {
                   $categoryid = isset($getcategory_id[0]['id'])?$getcategory_id[0]['id']:''; 
                    if(isset($categoryid)){
                     $obj_product->where('first_level_category_id',$categoryid);
                   }
                }else{
                   $obj_product->where('first_level_category_id','');
                }
            }    
            $apppend_data['category_id'] = $categories;

            // $category_id = $search_request['category_id'];        
            // $obj_product->where([['first_level_category_id',base64_decode($category_id)]]);
            // $apppend_data['category_id'] = $category_id;
        } 

    
        if (isset($search_request['mg'])) 
        {
           
            $mg = explode('-',$search_request['mg']); 
            $min_mg = isset($mg[0])?$mg[0]:'';
            $max_mg = isset($mg[1])?$mg[1]:'';
            $obj_product->whereBetween('per_product_quantity', array($min_mg, $max_mg));
            $apppend_data['mg'] = $min_mg.'-'.$max_mg;
         
        }// end of search by mg
         if (isset($search_request['age_restrictions'])) 
        {
            
            $age_restrictions = base64_decode($search_request['age_restrictions']); 

            if(isset($age_restrictions) && ($age_restrictions=='1' || $age_restrictions=='2'))
            {

                 $obj_product->where('age_restriction',$age_restrictions);
                 $obj_product->where('is_age_limit',1);
                 $apppend_data['age_restrictions'] = base64_encode($age_restrictions);

            }else{
                 $obj_product->where('age_restriction','3');
                 $obj_product->where('is_age_limit','');
                 $apppend_data['age_restrictions'] = base64_encode($age_restrictions);
            }

                                                       
        }// end of age restriction

        if (isset($search_request['rating']))  
        {
            $rating1 = $search_request['rating']; 
            $rating = base64_decode($search_request['rating']); 

            if(isset($rating))
            {
                //$res_productratings = $this->get_rating_arr($rating);
                $res_productratings = $this->get_buyer_admin_rating_arr($rating);
            }
                   
            if(!empty($res_productratings))
            { 
               //$res_productratings = $res_productratings->toArray();
               /*$rating_product_ids =  array_values($res_productratings);//get product ids from array

               $product_id_arr = array_column($rating_product_ids,'product_id');*/

               $product_id_arr =  $res_productratings;

               $obj_product->whereIn('id',$product_id_arr);
                                       
            }
            else
            {
               $product_id_arr =  $res_productratings;
             
               $obj_product->whereIn('id',$product_id_arr);
            }

            $apppend_data['rating'] = base64_encode($rating);

        }// end of rating


  
        //commented at 15/feb/2021

        if(isset($search_request['product_search']))
        { 
            $reasult = [];

            $product_search = $search_request['product_search']; 

            /* For Cannobinoids */
            $prodcannabinoidsmodel           = $this->ProductCannabinoidsModel->getTable();
            $prefix_prodcannabinoids  = DB::getTablePrefix().$this->ProductCannabinoidsModel->getTable();

            $cannbinoids_table         = $this->CannabinoidsModel->getTable();
            $prefix_cannbinoids = DB::getTablePrefix().$this->CannabinoidsModel->getTable();

            $arr_get_product_id =  DB::table($prefix_prodcannabinoids)
                        ->select(DB::raw(
                            $prefix_prodcannabinoids.'.product_id'
                        ))
                        ->leftJoin($prefix_cannbinoids,$prefix_cannbinoids.'.id','=',$prefix_prodcannabinoids.'.cannabinoids_id')    
                        ->where($prefix_cannbinoids.'.is_active','1')
                        ->where($prefix_prodcannabinoids.'.percent','!=',0); 

                        $arr_get_product_id = $arr_get_product_id->where(function ($query) use ($product_search,$prefix_cannbinoids,$prefix_prodcannabinoids) {
                             $query->where($prefix_cannbinoids.'.name','like','%'.$product_search.'%')
                                    ->orwhere(DB::raw('CONCAT('.$prefix_cannbinoids.'.name, " ", '.$prefix_prodcannabinoids.'.percent, "%")'), 'like', '%'.$product_search.'%')
                                    ->orwhere(DB::raw('CONCAT('.$prefix_cannbinoids.'.name, " ", '.$prefix_prodcannabinoids.'.percent)'), 'like', '%'.$product_search.'%');
                                    });
                        $arr_get_product_id = $arr_get_product_id->get()->toArray(); 
            
            $arr_can_prod_id = [];
            foreach($arr_get_product_id as $v)
            {
                $arr_can_prod_id[] = $v->product_id;
            }

            /* Ends for Cannobinoids */



            /* For reported effects */
            $prod_review_rating_model           = $this->ReviewRatingsModel->getTable();
            $prefix_review_rating_model         = DB::getTablePrefix().$this->ReviewRatingsModel->getTable(); 

            $prod_reported_effects_model           = $this->ReportedEffectsModel->getTable();
            $prefix_reported_effects_model         = DB::getTablePrefix().$this->ReportedEffectsModel->getTable();


              $arr_get_rating_product_id =  DB::table($prefix_review_rating_model)
                        ->select(DB::raw(
                            $prefix_review_rating_model.'.product_id,reported_effects.title'
                        ))

                        ->leftjoin("reported_effects",\DB::raw("FIND_IN_SET(reported_effects.id,product_rating_review.emoji)"),">",\DB::raw("'0'"))
               
                        ->where($prefix_reported_effects_model.'.is_active','1')

                        ->where($prefix_reported_effects_model.'.title','like','%'.$product_search.'%')

                        ->groupBy($prefix_review_rating_model.'.product_id')     
                                           
                        ->get()->toArray();
                        $arr_rating_prod_id = [];
                        foreach($arr_get_rating_product_id as $v)
                        {
                            $arr_rating_prod_id[] = $v->product_id;
                        }

                      
             /* Ends reported effects */

                  /*****************if search by spectrum************************/
                    $spectrum_name = $search_request['product_search'];  
                    $spectrum = '';
          
                    if(isset($spectrum_name) && !empty($spectrum_name))
                    {
                        $get_spectrum = $this->SpectrumModel->where('name','LIKE','%'.$spectrum_name.'%')->get();

                        if(isset($get_spectrum) && (!empty($get_spectrum)))
                        {
                            $get_spectrum = $get_spectrum->toArray();

                            if(!empty($get_spectrum)){
                                $spectrum = $get_spectrum[0]['id'];

                              
                               $this->arr_view_data['category_details']   = isset($get_spectrum)?$get_spectrum:[];

                                    
                            }
                            else{
                                $spectrum = '';
                            }//else
                        }//if    
                         
                    }//if spectrum_name

                  /****************if search by spectrum*************************/

                  /*****************if search by category******************/

                    $cat_name = $search_request['product_search'];  
                    $category = '';
          
                    if(isset($cat_name) && !empty($cat_name))
                    {
                        $get_category = $this->FirstLevelCategoryModel->where('product_type','LIKE','%'.$cat_name.'%')->get();

                        if(isset($get_category) && (!empty($get_category)))
                        {
                            $get_category = $get_category->toArray();

                            if(!empty($get_category)){
                                $category = $get_category[0]['id'];

                              
                               $this->arr_view_data['category_details']   = isset($get_category)?$get_category:[];

                                    
                            }
                            else{
                                $category = '';
                            }//else
                        }//if    
                         
                    }//if categorysearch
 
                   /***************end search by category*************************/




            $obj_product = $obj_product->where(function ($query) use ($product_search,$arr_can_prod_id,$arr_rating_prod_id,$spectrum,$category) {


                $query->orWhere('product_name','like','%'.$product_search.'%');

                $query->orWhere('terpenes','like','%'.$product_search.'%');

                $query->orWhere('description','like','%'.$product_search.'%');

                if(isset($spectrum) && !empty($spectrum))
                {
                 $query->orWhere('spectrum','=',$spectrum);
                }
                 if(isset($category) && !empty($category))
                {
                 $query->orWhere('first_level_category_id','=',$category);
                }
                if(!empty($arr_can_prod_id))
                {                    
                  $query->orWhereIn('id',$arr_can_prod_id);
                }
                if(!empty($arr_rating_prod_id))
                {                    
                 $query->orWhereIn('id',$arr_rating_prod_id);
                }


            });

            $apppend_data['product_search'] = $product_search;

            $this->arr_view_data['page_title']  = $product_search;
              
        }//end of product search in header 



        if(isset($search_request['state']) && !isset($search_request['city']))
        {

              $state = $search_request['state']; 
              $statename = str_replace('-',' ',$search_request['state']); 

                /**************get*restricted*categoryids************************/
                $category_ids='';
                $get_categoryids = $this->StatesModel->where('name',$statename)->first();
                if(isset($get_categoryids) && !empty($get_categoryids))
                {
                    $get_categoryids = $get_categoryids->toArray();
                    $category_ids = $get_categoryids['category_ids'];
                }


                /***********end*get*restricted*categoryids*********************/



              $getstateid = $this->StatesModel->select('id')->where('name',$statename)->first();
              if(isset($getstateid))
              {
                $getstateid = $getstateid->toArray();

                $getusers_ofstate = $this->UserModel->select('id')->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                 if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                 {
                    $getusers_ofstate = $getusers_ofstate->toArray();
                    $state_user_ids =  array_values($getusers_ofstate);//get user ids from 
                       
                        $obj_product->whereIn('user_id',$state_user_ids);

                        /*****************if*isset*categoryids**********/
                        if(isset($category_ids) && !empty($category_ids)) 
                        {   
                            $catdata =[];
                            $category_ids = explode(",",$category_ids);
                             foreach ($category_ids as $ids) {
                                $catdata[] = $ids;
                             $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                            }
                          
                        }      
                        /**************end*isset*categoryids************/


                 }//if getusersofstate

              }//if getstateid

              $apppend_data['state'] = $state;
              $this->arr_view_data['page_title']  = $state;
              
        } // if state

          if(isset($search_request['state']) && isset($search_request['city']))
        {
               
            
              $checkuserids =[];
              $state = $search_request['state']; 
              $statename = str_replace('-',' ',$search_request['state']); 

              $getstateid = $this->StatesModel->select('id')->where('name',$statename)->first();
              if(isset($getstateid))
              {
                $getstateid = $getstateid->toArray();

                $getusers_ofstate = $this->UserModel->select('id')->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                 if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                 {
                      $getusers_ofstate = $getusers_ofstate->toArray();
                      $state_user_ids =  array_values($getusers_ofstate);//get user ids from arr 

                      /**************get*restricted*categoryids*of*state***********/
                        $category_ids='';
                        $get_categoryids = $this->StatesModel->where('name',$statename)->first();
                        if(isset($get_categoryids) && !empty($get_categoryids))
                        {
                            $get_categoryids = $get_categoryids->toArray();
                            $category_ids = $get_categoryids['category_ids'];
                        }

                      /****end*get*restricted*categoryids**of*state*********/



                       if(isset($search_request['city']))
                        {
                              $city = $search_request['city']; 
                              $cityname = str_replace('-',' ',$search_request['city']); 

                                 $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->whereIn('id',$state_user_ids)->get();
                                 if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                 {
                                    $getusers_ofcity = $getusers_ofcity->toArray();
                                    $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                 }//if getusersofcity

                             $apppend_data['city'] = $city;
                             $this->arr_view_data['page_title']  = $city;
                              
                        } // if city
                   

                       $obj_product->whereIn('user_id',$city_user_ids);

                       /*****************if*isset*categoryids**********/
                        if(isset($category_ids) && !empty($category_ids)) 
                        {   
                            $catdata =[];
                            $category_ids = explode(",",$category_ids);
                             foreach ($category_ids as $ids) {
                                $catdata[] = $ids;
                             $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                            }                          
                        }      
                        /**************end*isset*categoryids************/



                 }//if getusersofstate

              }//if getstateid

              $apppend_data['state'] = $state;
              $this->arr_view_data['page_title']  = $state;
              
        } // if state



          if(isset($search_request['city']) && !isset($search_request['state']))
        {
           
              $city = $search_request['city']; 
              $cityname = str_replace('-',' ',$search_request['city']); 

                 $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->get();
                 if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                 {
                    $getusers_ofcity = $getusers_ofcity->toArray();
                    $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                     // $obj_product->whereIn('user_id',['94','100']);
                      $obj_product->whereIn('user_id',$city_user_ids);
                 }//if getusersofcity

             $apppend_data['city'] = $city;
             $this->arr_view_data['page_title']  = $city;
              
        } // if city



        /***************stateoflocation****************************/

        /*  if(isset($stateofuser) && !empty($stateofuser))
        {

              $stateofuser = trim($stateofuser); 
              $statename = str_replace('-',' ',$stateofuser); 

                $category_ids='';
                $get_categoryids = $this->StatesModel->where('name',$statename)->first();
                if(isset($get_categoryids) && !empty($get_categoryids))
                {
                    $get_categoryids = $get_categoryids->toArray();
                    $category_ids = $get_categoryids['category_ids'];

                }

              $getstateid = $this->StatesModel->select('id')->where('name',$statename)->first();
              if(isset($getstateid))
              {
                $getstateid = $getstateid->toArray();

                $getusers_ofstate = $this->UserModel->select('id')->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                 if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                 {
                    $getusers_ofstate = $getusers_ofstate->toArray();
                    $state_user_ids =  array_values($getusers_ofstate);//get user ids from 

                       
                        $obj_product->whereIn('user_id',$state_user_ids);

                        if(isset($category_ids) && !empty($category_ids)) 
                        {   
                            $catdata =[];
                            $category_ids = explode(",",$category_ids);
                             foreach ($category_ids as $ids) {
                                $catdata[] = $ids;
                             $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                            }                          
                        }      
                 }//if getusersofstate
              }//if getstateid
              
        } // if stateofuser
        */


        /* if(isset($state_user_ids) && !empty($state_user_ids))
         {
           $obj_product = $obj_product->whereIn('user_id',$state_user_ids);
         }  
        if(isset($catdata) && !empty($catdata))
        {
          $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
        } */   




        /*************end of state of location******************/


        if (isset($search_request['spectrum'])) 
        {
             $spectrum = $search_request['spectrum'];  
             $spectrumname = str_replace('-',' ',$search_request['spectrum']);  
           
            if($spectrumname)
            {

                $getspectrum_id = $this->SpectrumModel->where('name','=',$spectrumname)->first();

                if(!empty($getspectrum_id) && isset($getspectrum_id))
                {
                    $getspectrum_id = $getspectrum_id->toArray();

                   $specid = isset($getspectrum_id['id'])?$getspectrum_id['id']:''; 
                    if(isset($specid)){
                     $obj_product->where('spectrum',$specid);
                   }
                }
                else{
                   $obj_product->where('spectrum','');
                }
            }
            $apppend_data['spectrum'] = $spectrum;

        }// end of search by spectrum



          if (isset($search_request['statelaw'])) 
        {
             $statelaw = $search_request['statelaw'];  
           
            if(isset($statelaw) && $statelaw=="Allowed")
            {   

                    if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                   {

                       //buyer restricted and state and category there
                      $obj_product->whereIn('user_id',$allowed_state_sellers);
                      $obj_product->whereNotIn('first_level_category_id',$catdata);
                   
                   }
                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                        && empty($catdata))
                   {
                        //buyer restricted but state there not category
                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                   }
                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                   {
                       //empty
                     //buyer restricted but category there not state
                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                        
                      $obj_product->whereNotIn('first_level_category_id',$catdata);
                   }

                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                   {
                       //empty
                       //buyer state is restricted but not any seller and not category
                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                      // $obj_product->whereNotIn('first_level_category_id',$catdata);

                   }


                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                   {
                       //buyer not restricted but category there and state
                        $obj_product->whereIn('user_id',$allowed_state_sellers);
                        $obj_product->whereNotIn('first_level_category_id',$catdata);
                   }
                   elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                   {
                     //buyer not restricted but category there and not state   
                     $obj_product->whereNotIn('first_level_category_id',$catdata);
                   }
                                     
                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                   {
                       //buyer state is not restricted but  seller for his state not category
                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                   }

                   elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && empty($catdata))
                   {
                       //buyer state is not restricted not seller for his state not category
                       $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                       $obj_product->whereNotIn('first_level_category_id',$catdata);

                   }
                  
                  
               
            }
             elseif(isset($statelaw) && $statelaw=="Restricted")
            {   
                
                    if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                   {
                      //buyer restricted and state and category there 
                      $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                      $obj_product->whereIn('first_level_category_id',$catdata);
                   
                   }
                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                        && empty($catdata))
                   {
                       //buyer restricted and state not category 
                       $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                   }

                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata)
                        && empty($allowed_state_sellers))
                   {
                       //buyer restricted and category not state
                        $obj_product->whereIn('first_level_category_id',$catdata);
                         $obj_product->whereNotIn('user_id',$allowed_state_sellers); //new
                   }
                     elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                   {

                       //buyer state is restricted but not any seller and not category
                       $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                      // $obj_product->whereNotIn('first_level_category_id',$catdata);

                   }
                 

                   elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                   {
                     //buyer not restricted but category and state    
                     $obj_product->whereIn('first_level_category_id',$catdata);
                      $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                   }
                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                   {
                     //buyer not restricted but state there not category    
                      $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                   }
                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                   {
                     //buyer not restricted but category there not state    
                      $obj_product->whereIn('first_level_category_id',$catdata);

                   }
                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers)&& empty($catdata))
                   {

                       //buyer state is restricted but not any seller and not category
                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                       $obj_product->whereIn('first_level_category_id',$catdata);

                   }
                                      
                 
               
            }
            $apppend_data['statelaw'] = $statelaw;

        }// end of search by statelaw



         /******************buyer restricted states**********************************/   
         /*if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids))
         {
           $obj_product = $obj_product->whereIn('user_id',$restricted_state_user_ids);
         } */ 
         /*****************end buyer restricted state condition**************/   


         /*****************search by reported effects**************************/
             if (isset($search_request['reported_effects'])) 
            {
                 $reported_effects = $search_request['reported_effects'];  

                 if(isset($reported_effects))
                 {
                    $effects = explode('-',$search_request['reported_effects']);  
                    $effects = array_filter($effects);

                   // dd($effects);

                    if(isset($effects))
                   {

                       $get_effects = $this->ReviewRatingsModel->select('product_id','emoji')->where('emoji','!=','')->get();
                       if(isset($get_effects) && !empty($get_effects))
                      {
                          $get_effects = $get_effects->toArray();
                        

                           $allemojiarr = $productids = [];
                        
                            foreach($get_effects as $kk=>$vv)
                            {
                               $pid = $vv['product_id']; 
                               $allemoji =  explode(",",$vv['emoji']);
                               if(isset($allemoji) && !empty($allemoji)){
                               

                                 foreach($allemoji as $k1=>$v1)
                                 {
                                    $effecttitle='';
                                    $get_reported_effects = get_effect_name($v1);
                                    if(isset($get_reported_effects) && !empty($get_reported_effects))
                                    {    
                                        $effecttitle = $get_reported_effects['title'];

                                    }
                                    foreach($effects as $mm)
                                    {
                                        
                                        $mm = str_replace("_", " ", $mm); 
                                       
                                        if($mm==$effecttitle)
                                        {

                                           $productids[] =  $pid;

                                        }
                                        $allemojiarr[] = $effecttitle;
                                    }//foreach
                                  }//foreach


                              }//isset all emoji

                            }//foreach get_effects
                              
                      }//if isset get effects
                     

                     if(isset($productids))
                     {
                          $obj_product->whereIn('id',$productids);
                     } 
                   }//if isset effects

                 } // if isset reported_effects
             
                
                $apppend_data['reported_effects'] = $reported_effects;

            }// end of search by reported_effects

        /*****************search by cannoniboids**************************/
                    if (isset($search_request['cannabinoids'])) 
                    {
                        $reported_effects = $search_request['cannabinoids'];  

                        if(isset($reported_effects))
                        {
                            $cannabinoids = explode('-',$search_request['cannabinoids']);  
                            $cannabinoids = array_filter($cannabinoids);

                            if(isset($cannabinoids))
                            {
                                $cannabinoids_name = isset($cannabinoids[0]) ? $cannabinoids[0] : "";
                                $arr_cannabinoids = DB::table($prefix_ProductCannabinoidsModel)
                                            ->select(DB::raw($prefix_ProductCannabinoidsModel.'.product_id,'
                                                            .$prefix_CannabinoidsModel.'.name'
                                            ))

                                            ->leftJoin($prefix_CannabinoidsModel,$prefix_CannabinoidsModel.'.id','=',$prefix_ProductCannabinoidsModel.'.cannabinoids_id')    
                                            ->where($prefix_CannabinoidsModel.'.name','like','%'.$cannabinoids_name.'%') 
                                            ->where($prefix_ProductCannabinoidsModel.'.percent','!=',0) 
                                            ->get();
                                if(isset($arr_cannabinoids) && !empty($arr_cannabinoids))
                                {
                                    $get_cannabinoids = $arr_cannabinoids->toArray();        
                                    $allcannabinoidarr = $productids_can = [];
                                    foreach($get_cannabinoids as $kk=>$vv)
                                    {                              
                                        $pid = $vv->product_id; 
                                        $productids_can[] =  $pid;                         

                                    }//foreach cannobinoids                              
                                }//if isset get cannobinoids


                                if(isset($productids_can))
                                {
                                    $obj_product->whereIn('id',$productids_can);
                                } 
                            }//if isset cannabinoids

                        } // if isset cannabinoids
                        $apppend_data['cannabinoids'] = $reported_effects;
                    }// end of search by cannabinoids

         /******************Ends search by cannabinoids************************/



         $result = $price_product_ids = $productids_unitpricearr = $productids_pricdroparr = [];

        if(isset($search_request['price'])) 
       {

            $price_range = explode('-',$search_request['price']);
            $min_price = isset($price_range[0])?$price_range[0]:'';
            $max_price = isset($price_range[1])?$price_range[1]:'';

            $get_unit_price_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                            //->where('unit_price','!=','') 
                            ->where('price_drop_to','=','') 
                            ->whereBetween('unit_price', array($min_price, $max_price))
                            ->get();

            if(isset($get_unit_price_arr) && !empty($get_unit_price_arr))
            {
                 $get_unit_price_arr = $get_unit_price_arr->toArray();
                 $productids_unitpricearr   = array_column($get_unit_price_arr, 'id');
               
            }// if productids_unitpricearr

            $get_price_drop_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                            //->where('price_drop_to','>','0') 
                            ->whereBetween('price_drop_to', array($min_price, $max_price))
                            //->whereNotIn('id',$productids_unitpricearr)
                            ->get();

            if(isset($get_price_drop_arr) && !empty($get_price_drop_arr))
            {
                 $get_price_drop_arr = $get_price_drop_arr->toArray();
                 $productids_pricdroparr   = array_column($get_price_drop_arr, 'id');
                 
            }//if get_price_drop_arr

            if(isset($productids_unitpricearr) && isset($productids_pricdroparr)){
                 $result = array_merge($productids_unitpricearr,$productids_pricdroparr);       
                 $price_product_ids= array_unique($result);
                 $obj_product->whereIn('id',$price_product_ids);
            }
            
              $apppend_data['price'] = $min_price.'-'.$max_price;
         
      }//if isset price filter  

        $obj_product = $obj_product->get();       

        if (isset($obj_product) && $obj_product != null ) {
           $arr_product = $obj_product->toArray();
        }

       
        /*******header search for brand filter*start*************************/

        // if search in the header then this code is used for brand filter
        if(empty($arr_product) && isset($search_request['product_search']))
        {   
            $brand = '';

            $product_search = $search_request['product_search']; 
              if($product_search!="") 
               {    

                    $brand_name = $search_request['product_search'];  
          
                    if(isset($brand_name) && !empty($brand_name))
                    {
                        //$brandname = str_replace('-',' ',$brand_name);

                        $get_brand = $this->BrandModel->where('name','LIKE','%'.$brand_name.'%')->get();

                        if(isset($get_brand) && (!empty($get_brand)))
                        {
                            $get_brand = $get_brand->toArray();

                            if(!empty($get_brand)){
                                $brand = $get_brand[0]['id'];

                               // $apppend_data['brands'] = $get_brand[0]['name'];
                                $this->arr_view_data['Product_search_by_brand'] =1;
                                 
                               $this->arr_view_data['brand_details']   = isset($get_brand)?$get_brand:[];

                                    
                            }
                            else{
                                $brand = '';
                            }//else
                        }//if    
                         
                    }//if brandname
 

                  

                   $obj_product = $this->ProductModel->with([
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
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_seller_details', function ($q) {
                                                $q->where('is_active', '1');
                                            })


                                            ->where([['is_active',1],['is_approve',1]])
                                            ->where('brand','=',$brand)
                                            ->inRandomOrder();


                                     if(isset($search_request['best_seller'])) 
                                    {             
                                      $productids = $avgproductids = [];

                                      $prodmodel           = $this->ProductModel->getTable();
                                      $prefix_productable  = DB::getTablePrefix().$this->ProductModel->getTable();

                                      $order_table         = $this->OrderModel->getTable();
                                      $prefix_order_detail = DB::getTablePrefix().$this->OrderModel->getTable();

                                      $order_product_table  = $this->OrderProductModel->getTable();
                                      $prefix_order_product = DB::getTablePrefix().$this->OrderProductModel->getTable();

                                      $reviewmodel         = $this->ReviewRatingsModel->getTable();
                                      $prefix_reviewtable  = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();

                                      $arr_trending_productids =  DB::table($prefix_order_detail)->select(DB::raw(
                                                                    $prefix_order_product.'.product_id,count('.$prefix_order_product.'.product_id) as mostsold'
                                          ))
                                      ->leftJoin($prefix_order_product,$prefix_order_product.'.order_id','=',$prefix_order_detail.'.id')    
                                      ->where($prefix_order_detail.'.order_status','1')  
                                      ->groupBy($prefix_order_product.'.product_id')
                                      ->orderBy('mostsold','desc')
                                      //->limit(50)
                                     //->toSql();                    
                                      ->get()->toArray(); 


                                    if(isset($arr_trending_productids) &&!empty($arr_trending_productids))
                                    {  
                                         $productidssold   = array_column($arr_trending_productids, 'product_id');
                                         $mostsold         = array_unique(array_column($arr_trending_productids, 'mostsold'));
                                         $arr = []; $mostsolded ='';
                                         foreach($mostsold as $v)
                                         {
                                            $arr[] = $v;
                                         }
                                         
                                         $mostsolded = implode(",", $arr);

                                    }//if isset arr_mostsold_productids
                          
                                  if(isset($arr_trending_productids) && !empty($arr_trending_productids) && isset($mostsolded) &&  !empty($mostsolded))
                                  {
                                      $productids   = array_column($arr_trending_productids, 'product_id');

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
                                        
                                            ->whereIn('id',$productids)    
                                            ->where([['is_active',1],['is_approve',1]])
                                           // ->orderByRaw('FIELD(id,'.$mostsolded.')')
                                            ->get();

                         
                                        if(isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data))
                                        {
                                            $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
                                            $avgproductids   = array_column($arr_eloq_trending_data, 'id');
                                            $obj_product->whereIn('id',$avgproductids);
                                        }                                    

                                      }//if not empty r_trending_productids                        
                                    
                                       $best_seller = $search_request['best_seller'];            
                                       $apppend_data['best_seller'] = $best_seller;
                                     }// end of best seller          


                                      if (isset($search_request['chows_choice'])) 
                                    {             
                                        
                                        $chows_choice = $search_request['chows_choice']; 
                                        $obj_product->where('is_chows_choice','=','1');
                                        $apppend_data['chows_choice'] = $chows_choice;
                                    }// end of seller          


                                   
                                    if (isset($search_request['age_restrictions'])) 
                                    {
                                        $age_restrictions = base64_decode($search_request['age_restrictions']); 
                                        $obj_product->where('age_restriction',$age_restrictions);
                                        $obj_product->where('is_age_limit',1);
                                        $apppend_data['age_restrictions'] = base64_encode($age_restrictions);
                                    }// end of age restriction
                                   
                                     if (isset($search_request['mg'])) 
                                    {
                                       
                                        $mg = explode('-',$search_request['mg']); 
                                        $min_mg = $mg[0];
                                        $max_mg = $mg[1];
                                        $obj_product->whereBetween('per_product_quantity', array($min_mg, $max_mg));
                                        $apppend_data['mg'] = $min_mg.'-'.$max_mg;
                                     
                                    }// end of search by mg
                                     if(isset($search_request['category_id'])) 
                                    {
                                        $categories = $search_request['category_id'];  
                                        $category_name = str_replace('-and-','-&-',$search_request['category_id']);             
                                        $category_name = str_replace('-',' ',$category_name); 

                                        if($category_name)
                                        {

                                            $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','=',$category_name)->get()->toArray();

                                            if(empty($getcategory_id))
                                            {
                                              $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','like',$category_name.'%')->get()->toArray();

                                            }

                                            if(!empty($getcategory_id) && isset($getcategory_id))
                                            {
                                               $categoryid = isset($getcategory_id[0]['id'])?$getcategory_id[0]['id']:''; 
                                                if(isset($categoryid)){
                                                 $obj_product->where('first_level_category_id',$categoryid);
                                               }
                                            }else{
                                               $obj_product->where('first_level_category_id','');
                                            }

                                        }   

                                        
                                        $apppend_data['category_id'] = $categories; 

                                    }  
                                     if (isset($search_request['rating']))  
                                    {

                                        $rating = base64_decode($search_request['rating']); 
                                        if(isset($rating)){
                                            //$res_productratings = $this->get_rating_arr($rating);
                                            $res_productratings = $this->get_buyer_admin_rating_arr($rating);
                                        }
                                               
                                        if(!empty($res_productratings))
                                        {
                                           //$res_productratings = $res_productratings->toArray();
                                          // $rating_product_ids =  array_values($res_productratings);//get product ids from array
                                           $product_id_arr =  $res_productratings;
                                           $obj_product->whereIn('id',$product_id_arr);
                                                                   
                                        }
                                        else
                                        {
                                           $product_id_arr =  $res_productratings;
                                         
                                           $obj_product->whereIn('id',$product_id_arr);
                                        }



                                        $apppend_data['rating'] = base64_encode($rating);
                                    }// end of rating
                                     if (isset($search_request['filterby_price_drop'])) 
                                    {             
                                        
                                        $filterby_price_drop = $search_request['filterby_price_drop']; 
                                        $obj_product->where('price_drop_to','>','0');
                                        $apppend_data['filterby_price_drop'] = $filterby_price_drop;
                                    }// end of seller  
                                  
                                    if (isset($search_request['sellers'])) 
                                    {
                                        $sellers = $search_request['sellers']; 
                                        $res_sellerinfo = $this->get_seller_business_arr($sellers);

                                         if(!empty($res_sellerinfo) && isset($res_sellerinfo)){ 
                                            $seller_id = $res_sellerinfo['user_id'];
                                            $obj_product->where('user_id',$seller_id);
                                         }else{
                                             $obj_product->where('user_id','');
                                         }

                                        if(!empty($res_sellerinfo) && isset($res_sellerinfo)){  
                                            $seller_id = $res_sellerinfo['user_id'];
                                            $arr_seller_banner = [];
                                            $obj_seller_banner = $this->SellerBannerImageModel->where('seller_id',$seller_id)->first();
                                            if($obj_seller_banner)
                                            {
                                                $arr_seller_banner = $obj_seller_banner->toArray();
                                            }
                                            $apppend_data['sellers'] = $sellers;     
                                         }

                                        $seller_business_name = isset($res_sellerinfo['business_name'])?$res_sellerinfo['business_name']:'';
                                        $this->arr_view_data['page_title']  = $seller_business_name;         
                                    }//if sellers
                                     if(isset($search_request['state']) && !isset($search_request['city']))
                                    {

                                          $state = $search_request['state']; 
                                          $state = str_replace('-',' ',$search_request['state']); 

                                          $getstateid = $this->StatesModel->select('id')->where('name',$state)->first();
                                          if(isset($getstateid))
                                          {
                                            $getstateid = $getstateid->toArray();

                                            $getusers_ofstate = $this->UserModel->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                                             if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                                             {
                                                $getusers_ofstate = $getusers_ofstate->toArray();
                                                  $state_user_ids =  array_values($getusers_ofstate);//get user ids from array
                                                  $obj_product->whereIn('user_id',$state_user_ids);

                                                  /***get*restricted*categoryids*of*state***/
                                                    $category_ids='';
                                                    $get_categoryids = $this->StatesModel->where('name',$state)->first();
                                                    if(isset($get_categoryids) && !empty($get_categoryids))
                                                    {
                                                        $get_categoryids = $get_categoryids->toArray();
                                                        $category_ids = $get_categoryids['category_ids'];
                                                    }

                                                  /**end*get*restricted*categoryidsofstate**/

                                                  /******if*isset*categoryids**********/
                                                    if(isset($category_ids) && !empty($category_ids)) 
                                                    {   
                                                        $catdata =[];
                                                        $category_ids = explode(",",$category_ids);
                                                         foreach ($category_ids as $ids) {
                                                            $catdata[] = $ids;
                                                         $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                        }                          
                                                    }      
                                                    /*****end*isset*categoryids********/


                                             }//if getusersofstate

                                          }//if getstateid

                                          $apppend_data['state'] = $state;
                                          
                                    } // if state

                                  if(isset($search_request['state']) && isset($search_request['city']))
                                    {
                                       
                                      $checkuserids =[];
                                      $state = $search_request['state']; 
                                      $statename = str_replace('-',' ',$search_request['state']); 

                                      $getstateid = $this->StatesModel->select('id')->where('name',$statename)->first();
                                      if(isset($getstateid))
                                      {
                                        $getstateid = $getstateid->toArray();

                                        $getusers_ofstate = $this->UserModel->select('id')->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                                         if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                                         {
                                              $getusers_ofstate = $getusers_ofstate->toArray();
                                              $state_user_ids =  array_values($getusers_ofstate);//get user ids from array
                                               if(isset($search_request['city']))
                                                {
                                                   $city = $search_request['city']; 
                                                   $cityname = str_replace('-',' ',$search_request['city']); 

                                                   $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->whereIn('id',$state_user_ids)->get();
                                                    if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                                    {
                                                            $getusers_ofcity = $getusers_ofcity->toArray();
                                                            $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                                    }//if getusersofcity

                                                    $apppend_data['city'] = $city;
                                                    $this->arr_view_data['page_title']  = $city;
                                                      
                                                } // if city                                           
                                             $obj_product->whereIn('user_id',$city_user_ids);

                                                 /***get*restricted*categoryids*of*state***/
                                                    $category_ids='';
                                                    $get_categoryids = $this->StatesModel->where('name',$statename)->first();
                                                    if(isset($get_categoryids) && !empty($get_categoryids))
                                                    {
                                                        $get_categoryids = $get_categoryids->toArray();
                                                        $category_ids = $get_categoryids['category_ids'];
                                                    }

                                                  /**end*get*restricted*categoryidsofstate**/
                                                  /******if*isset*categoryids**********/
                                                    if(isset($category_ids) && !empty($category_ids)) 
                                                    {   
                                                        $catdata =[];
                                                        $category_ids = explode(",",$category_ids);
                                                         foreach ($category_ids as $ids) {
                                                            $catdata[] = $ids;
                                                        
                                                         $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                        }                          
                                                    }      
                                                    /*****end*isset*categoryids********/


                                         }//if getusersofstate

                                      }//if getstateid

                                      $apppend_data['state'] = $state;

                                } // if state and city

                                if(isset($search_request['city']) && !isset($search_request['state']))
                                 {
                                          $city = $search_request['city']; 
                                          $cityname = str_replace('-',' ',$search_request['city']); 

                                          $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->get();
                                             if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                             {
                                                $getusers_ofcity = $getusers_ofcity->toArray();
                                                $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                                  $obj_product->whereIn('user_id',$city_user_ids);
                                             }//if getusersofstate

                                         $apppend_data['city'] = $city;
                                         $this->arr_view_data['page_title']  = $city;                                      
                                  } // if city


                                   if (isset($search_request['spectrum'])) 
                                    {
                                         $spectrum = $search_request['spectrum'];  
                                         $spectrumname = str_replace('-',' ',$search_request['spectrum']);  
                                       
                                        if($spectrumname)
                                        {

                                            $getspectrum_id = $this->SpectrumModel->where('name','=',$spectrumname)->first();

                                            if(!empty($getspectrum_id) && isset($getspectrum_id))
                                            {
                                                $getspectrum_id = $getspectrum_id->toArray();

                                               $specid = isset($getspectrum_id['id'])?$getspectrum_id['id']:''; 
                                                if(isset($specid)){
                                                 $obj_product->where('spectrum',$specid);
                                               }
                                            }else{
                                               $obj_product->where('spectrum','');
                                            }
                                        }
                                        $apppend_data['spectrum'] = $spectrum;

                                    }// end of search by spectrum

                                   
                                    if (isset($search_request['statelaw'])) 
                                    {
                                         $statelaw = $search_request['statelaw'];  
                                       
                                        if(isset($statelaw) && $statelaw=="Allowed")
                                        {   

                                                if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {

                                                   //buyer restricted and state and category there
                                                  $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                  $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                                                    && empty($catdata))
                                               {
                                                    //buyer restricted but state there not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                                               {
                                                   //empty
                                                 //buyer restricted but category there not state
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                    
                                                  $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }

                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                                               {
                                                   //empty
                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                  // $obj_product->whereNotIn('first_level_category_id',$catdata);

                                               }


                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                   //buyer not restricted but category there and state
                                                    $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                    $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }
                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                 //buyer not restricted but category there and not state   
                                                 $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }
                                                                 
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                   //buyer state is not restricted but  seller for his state not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                               }

                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                   //buyer state is not restricted not seller for his state not category
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                   $obj_product->whereNotIn('first_level_category_id',$catdata);

                                               }
                                              
                                              
                                           
                                        }
                                         elseif(isset($statelaw) && $statelaw=="Restricted")
                                        {   

                                                if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                  //buyer restricted and state and category there 
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                  $obj_product->whereIn('first_level_category_id',$catdata);
                                               
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                                                    && empty($catdata))
                                               {
                                                   //buyer restricted and state not category 
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                               }

                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata)
                                                    && empty($allowed_state_sellers))
                                               {
                                                   //buyer restricted and category not state
                                                    $obj_product->whereIn('first_level_category_id',$catdata);
                                                     $obj_product->whereNotIn('user_id',$allowed_state_sellers); //new
                                               }
                                                 elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                                               {

                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                               }
                                             

                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                 //buyer not restricted but category and state    
                                                 $obj_product->whereIn('first_level_category_id',$catdata);
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                 //buyer not restricted but state there not category    
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                                               {
                                                 //buyer not restricted but category there not state    
                                                  $obj_product->whereIn('first_level_category_id',$catdata);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers)&& empty($catdata))
                                               {

                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                   $obj_product->whereIn('first_level_category_id',$catdata);

                                               }
                                                                  
                                             
                                           
                                        }
                                        $apppend_data['statelaw'] = $statelaw;

                                    }// end of search by statelaw
                                        
                               

                                     if(isset($search_request['reported_effects'])) 
                                    {
                                         $reported_effects = $search_request['reported_effects'];  

                                         if(isset($reported_effects))
                                         {
                                            $effects = explode('-',$search_request['reported_effects']);  
                                            $effects = array_filter($effects);

                                            if(isset($effects))
                                           {

                                               $get_effects = $this->ReviewRatingsModel->select('product_id','emoji')->where('emoji','!=','')->get();
                                               if(isset($get_effects) && !empty($get_effects))
                                              {
                                                  $get_effects = $get_effects->toArray();
                                                

                                                   $allemojiarr = $productids = [];
                                                
                                                    foreach($get_effects as $kk=>$vv)
                                                    {
                                                       $pid = $vv['product_id']; 
                                                       $allemoji =  explode(",",$vv['emoji']);
                                                       if(isset($allemoji) && !empty($allemoji)){
                                                         

                                                         foreach($allemoji as $k1=>$v1)
                                                         {
                                                            $effecttitle='';
                                                            $get_reported_effects = get_effect_name($v1);
                                                            if(isset($get_reported_effects) && !empty($get_reported_effects))
                                                            {    
                                                                $effecttitle = $get_reported_effects['title'];

                                                            }
                                                            foreach($effects as $mm)
                                                            {
                                                                
                                                                $mm = str_replace("_", " ", $mm); 
                                                               
                                                                if($mm==$effecttitle)
                                                                {

                                                                   $productids[] =  $pid;

                                                                }
                                                                $allemojiarr[] = $effecttitle;
                                                            }//foreach
                                                          }//foreach


                                                      }//isset all emoji

                                                    }//foreach get_effects
                                                      
                                              }//if isset get effects
                                             

                                             if(isset($productids))
                                             {
                                                  $obj_product->whereIn('id',$productids);
                                             } 
                                           }//if isset effects

                                         } // if isset reported_effects
                                     
                                        
                                        $apppend_data['reported_effects'] = $reported_effects;

                                    }// end of search by reported_effects





                                    if (isset($search_request['cannabinoids'])) 
                                    {
                                        $reported_effects = $search_request['cannabinoids'];  

                                        if(isset($reported_effects))
                                        {
                                            $cannabinoids = explode('-',$search_request['cannabinoids']);  
                                            $cannabinoids = array_filter($cannabinoids);

                                            if(isset($cannabinoids))
                                            {
                                                $cannabinoids_name = isset($cannabinoids[0]) ? $cannabinoids[0] : "";
                                                $arr_cannabinoids = DB::table($prefix_ProductCannabinoidsModel)
                                                            ->select(DB::raw($prefix_ProductCannabinoidsModel.'.product_id,'
                                                                            .$prefix_CannabinoidsModel.'.name'
                                                            ))

                                                            ->leftJoin($prefix_CannabinoidsModel,$prefix_CannabinoidsModel.'.id','=',$prefix_ProductCannabinoidsModel.'.cannabinoids_id')    
                                                            ->where($prefix_CannabinoidsModel.'.name','like','%'.$cannabinoids_name.'%') 
                                                            ->where($prefix_ProductCannabinoidsModel.'.percent','!=',0) 
                                                            ->get();
                                                if(isset($arr_cannabinoids) && !empty($arr_cannabinoids))
                                                {
                                                    $get_cannabinoids = $arr_cannabinoids->toArray();        
                                                    $allcannabinoidarr = $productids_can = [];
                                                    foreach($get_cannabinoids as $kk=>$vv)
                                                    {                              
                                                        $pid = $vv->product_id; 
                                                        $productids_can[] =  $pid;                         

                                                    }//foreach cannobinoids                              
                                                }//if isset get cannobinoids


                                                if(isset($productids_can))
                                                {
                                                    $obj_product->whereIn('id',$productids_can);
                                                } 
                                            }//if isset cannabinoids

                                        } // if isset cannabinoids
                                        $apppend_data['cannabinoids'] = $reported_effects;
                                    }// end of search by cannabinoids


  

                                  $result = $price_product_ids = $productids_unitpricearr = $productids_pricdroparr = [];
                                 
                                  if(isset($search_request['price'])) 
                                 {

                                    $price_range = explode('-',$search_request['price']);
                                    $min_price = isset($price_range[0])?$price_range[0]:'';
                                    $max_price = isset($price_range[1])?$price_range[1]:'';

                                    $get_unit_price_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                                                    //->where('unit_price','!=','') 
                                                    ->where('price_drop_to','=','') 
                                                    ->whereBetween('unit_price', array($min_price, $max_price))
                                                    ->get();

                                    if(isset($get_unit_price_arr) && !empty($get_unit_price_arr))
                                    {
                                         $get_unit_price_arr = $get_unit_price_arr->toArray();
                                         $productids_unitpricearr   = array_column($get_unit_price_arr, 'id');
                                       
                                    }// if productids_unitpricearr

                                    $get_price_drop_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                                                    ->whereBetween('price_drop_to', array($min_price, $max_price))
                                                    ->get();

                                    if(isset($get_price_drop_arr) && !empty($get_price_drop_arr))
                                    {
                                         $get_price_drop_arr = $get_price_drop_arr->toArray();
                                         $productids_pricdroparr   = array_column($get_price_drop_arr, 'id');
                                    }//if get_price_drop_arr

                                    if(isset($productids_unitpricearr) && isset($productids_pricdroparr)){
                                         $result = array_merge($productids_unitpricearr,$productids_pricdroparr);       
                                         $price_product_ids= array_unique($result);
                                         $obj_product->whereIn('id',$price_product_ids);
                                    }
                                    
                                      $apppend_data['price'] = $min_price.'-'.$max_price;
                                 
                                  }//if isset price filter  


                                 $obj_product = $obj_product->get();

                                 if (isset($obj_product) && $obj_product != null ) 
                                 {
                                     $arr_product = $obj_product->toArray();
                                       
                                } // if desc search filter is set
                 
                    
               }// if product search not empty for brand filter
        }// if arr_product is empty and search filter is empty then use this for brand
     
       /*******header search for brand filter*end*************************/

      


        /****************code*added*for*category***************/


        $category_ids='';       
        if(isset($search_request['state']))
       //  if(isset($stateofuser))    
        {
            $statenam = str_replace('-',' ',$search_request['state']); 
         //   $statenam = str_replace('-',' ',trim($stateofuser)); 
           // $get_categoryids = $this->StatesModel->where('name',$search_request['state'])->first();
            $get_categoryids = $this->StatesModel->where('name',$statenam)->first();
            if(isset($get_categoryids) && !empty($get_categoryids))
            {
                $get_categoryids = $get_categoryids->toArray();
                $category_ids = $get_categoryids['category_ids'];
            }
        }


         /**************location*data****************************/
         $ipcountry  = '';
         $ipstate  = '';
         $ipdb  = '';
         $login_user = Sentinel::check();  
         if(isset($login_user) && $login_user==true && $login_user->inRole('seller') == true) 
         {

         }
         else if(isset($login_user) && $login_user==true && $login_user->inRole('admin') == true) {

         }
        else if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true)
         {
               $ipcountry  = $login_user->country;
               $ipstate    = $login_user->state;
              
         }//else if user is buyer
         else{
             $myip = $_SERVER['REMOTE_ADDR'];
             $get_ipdata = IpDataModel::where('ip',$myip)->first();
             if(isset($get_ipdata) && !empty($get_ipdata))
             {
               $get_ipdata = $get_ipdata->toArray(); 
               $ipcountry  = $get_ipdata['country'];
               $ipstate    = $get_ipdata['state'];
               $ipdb       = $get_ipdata['ip'];
             }
         }

        $category_ids='';       
        if(isset($ipstate))
        {
            $get_categoryids = $this->StatesModel->where('id',$ipstate)->first();
            if(isset($get_categoryids) && !empty($get_categoryids))
            {
                $get_categoryids = $get_categoryids->toArray();
                $category_ids = $get_categoryids['category_ids'];
            }
        }

       /****************end location data*****************/  




        $category_arr = [];
        $obj_category = $this->FirstLevelCategoryModel
                                ->where('is_active',1)
                                ->orderBy('product_type');

        $obj_category = $obj_category->get();

        if (isset($obj_category) && count($obj_category) > 0) {
            
            $category_arr = $obj_category->toArray();
        }
        
        /**********end****for getting category array*************************/


            
        /*-----------search by featured---(developer:priyaka)----------------------------*/
          
        if(isset($search_request['featured'])) 
        { 
            $featured = $search_request['featured']; 

            if($featured == 'hight_to_low')
            {

                $arr_product = array_map(
                    function($value)
                    {

                        $value['final_price']  = get_price($value['id']);
                        return $value;
                    },
                      $arr_product
                    );

                $product_keys = array_column($arr_product, 'final_price');             
                array_multisort($product_keys, SORT_DESC, $arr_product);

         
            }

            if($featured == 'low_to_high')
            { 
                $arr_product = array_map(
                    function($value)
                    {

                        $value['final_price']  = get_price($value['id']);
                        return $value;
                    },
                      $arr_product
                    );

                $product_keys = array_column($arr_product, 'final_price');             
                array_multisort($product_keys, SORT_ASC, $arr_product);


            }


            if($featured == 'avg_customer_review')
            {
                $arr_product = array_map(
                function($value)
                {

                    $value['product_total_review']  = get_total_reviews($value['id']);
                    return $value;
                },
                  $arr_product
                );

                $product_keys = array_column($arr_product, 'product_total_review');             
                array_multisort($product_keys, SORT_DESC, $arr_product);

                //dd($product_keys,$arr_product);
            }

            if($featured == 'new_arrivals')
            { 
                $arr_product = array_map(
                    function($value)
                    {

                        $value['created_at']  = $value['created_at'];
                        return $value;
                    },
                      $arr_product
                    );

                $product_keys = array_column($arr_product, 'created_at');             
                array_multisort($product_keys, SORT_DESC, $arr_product);

            }

             
            $featured = $search_request['featured'];            
            $apppend_data['featured'] = $featured;   
        
        } 

        /*-------------------------------------------------------------------------------------*/

        if($request->has('page'))
        {   
            $pageStart = $request->input('page'); 
        }
        else
        {
            $pageStart = 1; 
        }
        
        $total_results = count($arr_product);


        $paginator = $this->get_pagination_data($arr_product, $pageStart, 20 , $apppend_data);


        if($paginator)
        {
            $pagination_links    =  $paginator;  
            $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 
        }   

        if($paginator)
        {
            $obj_fav_product_arr = $this->FavoriteModel->where('buyer_id',$user_id)->select('product_id')->get();

            if ($obj_fav_product_arr) {
               
               $fav_product_arr = $obj_fav_product_arr->toArray();

            }

            $obj_follow_arr = $this->FollowModel->where('buyer_id',$user_id)->select('seller_id')->get();

            if ($obj_follow_arr) {
               
               $follow_seller_arr = $obj_follow_arr->toArray();

            }
            

            //if search data not found then show all products
            $msg = '';

            if(empty($arr_product) && count($arr_product) == 0)
            {  
               
                $request_data = [];
                $request_data =  $request->all();

                $search_request = '';

                $search_request .=isset($request_data['featured'])?$request_data['featured'].' & ':''; 
                $search_request .=isset($request_data['price'])?$request_data['price'].' & ':''; 
                $search_request .=isset($request_data['brands'])?$request_data['brands'].' & ':''; 
                $search_request .=isset($request_data['category_id'])?$request_data['category_id'].' & ':''; 
                $search_request .=isset($request_data['mg'])?$request_data['mg'].' & ':''; 
                $search_request .=isset($request_data['rating'])?$request_data['rating'].' & ':''; 
                $search_request .=isset($request_data['filterby_price_drop'])?$request_data['filterby_price_drop'].' & ':''; 
                $search_request .=isset($request_data['product_search'])?$request_data['product_search'].' & ':''; 
                $search_request .=isset($request_data['spectrum'])?$request_data['spectrum'].' & ':''; 
                $search_request .=isset($request_data['chows_choice'])?$request_data['chows_choice'].' & ':''; 
                $search_request .=isset($request_data['best_seller'])?$request_data['best_seller'].' & ':''; 
                $search_request .=isset($request_data['statelaw'])?$request_data['statelaw'].' & ':''; 
                $search_request .=isset($request_data['reported_effects'])?$request_data['reported_effects'].' & ':''; 
                $search_request .=isset($request_data['cannabinoids'])?$request_data['cannabinoids']:''; 
               
                $string = rtrim($search_request, " & ");

                $msg = "There seem to be no results for your search - '".$string."'. This may be because of FDA restrictions. Please try using our filters to find what you are looking for.";



                $obj_product = $this->ProductModel->with([
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
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                             ->whereHas('get_seller_details', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->where([['is_active',1],['is_approve',1]])
                                          
                                            ->inRandomOrder();

                $obj_product = $obj_product->get();

                if (isset($obj_product) && $obj_product != null ) 
                {
                     $arr_product = $obj_product->toArray();
                       
                } // if desc search filter is set
              
                $paginator = $this->get_pagination_data($arr_product, $pageStart, 20 , $apppend_data);


                if($paginator)
                {
                    $pagination_links    =  $paginator;  
                    $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 
                }   



            }


                    
            $arr_user_pagination            =  $paginator;  
            $arr_product                    =  $paginator->items();
            $arr_data                       =  $arr_product;
            $arr_view_data['arr_data']      =  $arr_data;
            

            $arr_view_data['total_results'] = $total_results;
            $arr_pagination                 = $paginator;
           
            $this->arr_view_data['arr_data']         =  $arr_data;
            $this->arr_view_data['error_msg']        =  isset($msg)?$msg:'';

            $this->arr_view_data['arr_pagination']  = $arr_pagination;
            $this->arr_view_data['total_results']   = $total_results;
            
            $this->arr_view_data['category_arr']    = $category_arr;
            $this->arr_view_data['lowest_price']    = isset($lowest_price)?$lowest_price:'0';
            $this->arr_view_data['highest_price']   = isset($highest_price)?$highest_price:'0';

            $this->arr_view_data['lowest_mg']    = isset($lowest_mg)?$lowest_mg:'0';
            $this->arr_view_data['highest_mg']   = isset($highest_mg)?$highest_mg:'0';


            $this->arr_view_data['fav_product_arr']     = $fav_product_arr;
            $this->arr_view_data['follow_seller_arr']   = $follow_seller_arr;

            $this->arr_view_data['fav_products_count']  = count($fav_product_arr);
            $this->arr_view_data['buyer_id_proof']      = isset($buyer_id_proof)?$buyer_id_proof:'';
         

            if(isset($search_request['category_search']))
                $this->arr_view_data['cat_id'] = $search_request['category_search'];
            else if(isset($search_request['category']))
                $this->arr_view_data['cat_id'] = $search_request['category'];
            
            $this->arr_view_data['age_restrictions']   = isset($age_restrictions)?$age_restrictions:'';
            $this->arr_view_data['rating']   = isset($rating)?$rating:'';
            $this->arr_view_data['seller']   = isset($seller)?$seller:'';
            $this->arr_view_data['brand']    = isset($brand)?$brand:'';
            $this->arr_view_data['sellers']  = isset($sellers)?$sellers:'';
            $this->arr_view_data['arr_seller_banner']  = isset($arr_seller_banner)?$arr_seller_banner:'';


            $this->arr_view_data['state_user_ids']  = isset($state_user_ids)?$state_user_ids:'';
            $this->arr_view_data['catdata']  = isset($catdata)?$catdata:[];



            if(isset($search_request['category_id']))
            {
                $categories = $search_request['category_id'];  
                $category_name = str_replace('-and-','-&-',$search_request['category_id']);             
                $category_name = str_replace('-',' ',$category_name); 


               $firstcatdetails =  $this->FirstLevelCategoryModel->where('product_type',$category_name)->get();
               if(!empty($firstcatdetails))
               {
                    $firstcatdetails = $firstcatdetails->toArray();
                    $this->arr_view_data['first_cat_details']   = isset($firstcatdetails)?$firstcatdetails:'';
               }

               // $search_request['category_id'];
               // $firstcatdetails =  $this->FirstLevelCategoryModel->where('id',base64_decode($search_request['category_id']))->get();
               // if(!empty($firstcatdetails))
               // {
               //      $firstcatdetails = $firstcatdetails->toArray();
               //      $this->arr_view_data['first_cat_details']   = isset($firstcatdetails)?$firstcatdetails:'';
               // }
            }

            // search by seller link on product detail page
           
            if(isset($search_request['seller']))
            {  
                $seller_id = $search_request['seller'];

                if($seller_id)
                {
                    $res_sellerinfo = $this->UserModel->where('id',base64_decode($seller_id))->get()->toArray();
                    if(!empty($res_sellerinfo) && isset($res_sellerinfo))
                    {

                      $get_seller_products = $this->ProductModel->where('user_id',$res_sellerinfo[0]['id'])->get()->toArray();  

                      

                       if(!empty($get_seller_products))
                       {
                            $product_ids =  array_column($get_seller_products, 'id');//get product ids from array
                             
                            $arr_reviews_products = $this->ReviewRatingsModel
                            ->whereIn('product_id',$product_ids)    
                            //->groupBy('product_id')
                            ->get()->toArray(); 

                             if(!empty($arr_reviews_products)){   
                               $review_count = count($arr_reviews_products);
                             }

                            $arr_ratingsum_products = $this->ReviewRatingsModel->whereIn('product_id',$product_ids)                     ->get()->toArray(); 
                           
                          
                            if(!empty($arr_ratingsum_products) && $review_count>0)
                            {  
                                 $sum = 0; $avg_rating = 0;
                                 foreach($arr_ratingsum_products as $v){
                                  $sum = $sum+$v['rating'];                                  
                                }
                                if($sum>0 && $review_count>0)
                                //$avg_rating     = ceil($sum/$review_count) ; 
                                $avg_rating  = floatval($sum)/floatval($review_count); 
                            } 




                            //get total sum of admin rating of all products
                            $admin_product_rating = $admin_product_review = 0;

                            $admin_product_rating  = $this->ProductModel->where('user_id',$res_sellerinfo[0]['id'])->sum('avg_rating');

                            $admin_product_review = $this->ProductModel->where('user_id',$res_sellerinfo[0]['id'])->sum('avg_review');


                            $product_count = $this->ProductModel->where('user_id',$res_sellerinfo[0]['id'])->whereNotNull('avg_rating')->where('avg_rating','<>','')->count();

                            

                            if((isset($admin_product_rating) && $admin_product_rating!=0) && (isset($product_count) && $product_count!=0))
                            {
                               $admin_product_rating = floatval($admin_product_rating)/floatval($product_count);
                            }



                       }  
                       
                      $this->arr_view_data['seller_details']         = isset($res_sellerinfo)?$res_sellerinfo:[];
                      $this->arr_view_data['arr_reviews_products']   = isset($arr_reviews_products)?$arr_reviews_products:[];
                      $this->arr_view_data['avg_rating']             = isset($avg_rating)?$avg_rating:'';
                      $this->arr_view_data['admin_product_rating']   = isset($admin_product_rating)?$admin_product_rating:'';
                      $this->arr_view_data['admin_product_review']   = isset($admin_product_review)?$admin_product_review:'';

                    }
                }
            }//if seller


           if (isset($search_request['brand'])) 
            {
                
                $brand = $search_request['brand']; 
                $getbrand_name = $this->BrandModel->where('id',base64_decode($brand))->get()->toArray();
                if(!empty($getbrand_name) && isset($getbrand_name))
                {
                    $this->arr_view_data['brand_details']   = isset($getbrand_name)?$getbrand_name:[];

                }
            }// end of brand
          

              // search by sellers  bisiness
            if(isset($search_request['sellers']))
            {
               $sellers = $search_request['sellers']; 

               $res_businessinfo = $this->get_seller_business_arr($sellers);
               if(!empty($res_businessinfo))
               {
                    $seller_id = $res_businessinfo['user_id'];

                    // $res_sellerinfo = $this->UserModel->select('*')->where('id',$seller_id)
                    //               ->first();   

                     $res_sellerinfo = $this->UserModel->with('get_state_detail')->select('*')->where('id',$seller_id)->first();       // with state added newly 2-match-20
                            


                    if(!empty($res_sellerinfo))
                    {
                       $res_sellerinfo = $res_sellerinfo->toArray();


                       $get_seller_products = $this->ProductModel->where('user_id',$res_sellerinfo['id'])
                       //->where('is_active',1)
                       //->where('is_approve',1)
                       ->get()->toArray(); 


                       if(!empty($get_seller_products))
                       {
                            $product_ids =  array_column($get_seller_products, 'id');//get product ids from array
                          
                            $arr_reviews_products = $this->ReviewRatingsModel
                            ->whereIn('product_id',$product_ids)    
                            ->get()->toArray(); 


                            $arr_ratingsum_products = $this->ReviewRatingsModel
                            ->whereIn('product_id',$product_ids)    
                            //->groupBy('product_id')
                            ->get()->toArray(); 
                            $review_count = count($arr_reviews_products);
                          
                            if(!empty($arr_ratingsum_products))
                            {  
                                 $sum = 0; $avg_rating = 0;
                                 foreach($arr_ratingsum_products as $v){
                                  $sum = floatval($sum)+floatval($v['rating']);                                  
                                }


                                if($sum>0 && $review_count>0)
                                $avg_rating  = floatval($sum)/floatval($review_count); 
                            }   

                            //get sum of admin rating of all products
                            $admin_product_rating = $admin_product_review = 0;

                            $admin_product_rating  = $this->ProductModel->where('user_id',$res_sellerinfo['id'])->whereIn('id',$product_ids)->sum('avg_rating');

                            $admin_product_review = $this->ProductModel->where('user_id',$res_sellerinfo['id'])->whereIn('id',$product_ids)->sum('avg_review');

                            $product_count = $this->ProductModel->where('user_id',$res_sellerinfo['id'])->whereIn('id',$product_ids)->whereNotNull('avg_rating')->where('avg_rating','<>','')->count();

                            
                            
                            if((isset($admin_product_rating) && $admin_product_rating!=0) && (isset($product_count) && $product_count!=0))
                            {  
                                 
                               $admin_product_rating = floatval($admin_product_rating)/floatval($product_count);


                            }
                            
                       }   
                  
                        $this->arr_view_data['seller_details']         = isset($res_sellerinfo)?$res_sellerinfo:[];
                        $this->arr_view_data['arr_reviews_products']   = isset($arr_reviews_products)?$arr_reviews_products:[];
                        $this->arr_view_data['avg_rating']             = isset($avg_rating)?$avg_rating:'';

                        $this->arr_view_data['admin_product_rating']   = isset($admin_product_rating)?$admin_product_rating:'';
                        $this->arr_view_data['admin_product_review']   = isset($admin_product_review)?$admin_product_review:0;

                    } 
                   $this->arr_view_data['business_details']   = isset($res_businessinfo)?$res_businessinfo:[];

               }//if not empty business name
              
            }// if isset sellers business name


            if (isset($search_request['brands'])) 
            {
                
                $brand = $search_request['brands']; 
                $brandname = str_replace('-',' ',$search_request['brands']); 

                $getbrand_name = $this->BrandModel->where('name',$brandname)->get()->toArray();
                 if(empty($getbrand_name))
                {

                   $getbrand_name = $this->BrandModel->where('name','like',$brandname.'%')->get()->toArray();

                }


                if(!empty($getbrand_name) && isset($getbrand_name))
                {
                    $this->arr_view_data['brand_details']   = isset($getbrand_name)?$getbrand_name:[];
                }
            }// end of brand


             if(isset($search_request['state']))
            {

                  $state = $search_request['state']; 
                  $state = str_replace('-',' ',$search_request['state']); 

                  $getstate_details = $this->StatesModel->where('name',$state)->first();
                  if(isset($getstate_details))
                  {
                    $getstate_details = $getstate_details->toArray();
                    $this->arr_view_data['state_details']   = isset($getstate_details)?$getstate_details:[];

                  }//if getstateid

            } // if state details


             if (isset($search_request['spectrum'])) 
            {
                    
                $spectrm = $search_request['spectrum']; 
                $spectrmname = str_replace('-',' ',$search_request['spectrum']); 



                $getspectrum_name = $this->SpectrumModel->where('name',$spectrmname)->first();
                 
                 if(isset($getspectrum_name) && !empty($getspectrum_name))
                {
                   
                    $getspectrum_name = $getspectrum_name->toArray();
                    $this->arr_view_data['spectrum_details']   = isset($getspectrum_name)?$getspectrum_name:[];
                }
              
            }// end of spectrum

            /*select all data from shop by effect table*/
             $arr_shop_by_effect = $this->ShopByEffectModel
                                    ->where('is_active','1')                
                                    ->get()->toArray(); 



            /*you may like product for feb dev phase*/

            $user = Sentinel::check();
            $login_flag = '';
            $you_may_like_arr = [];

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

            $you_may_like_arr =  $this->ProductModel->with([
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

                                                    // $q1->where('user_session_id',$session_id);
                                                    
                                                })
                                                
                                                ->where([['is_active',1],['is_approve',1]])
                                                ->orderBy('created_at','desc')
                                                ->limit('50');
                                           
                $you_may_like_arr = $you_may_like_arr->get();
                    

                if(!empty($you_may_like_arr))
                {
                    $you_may_like_arr = $you_may_like_arr->toArray();
                  
                }                         


            /*-------------end you may likes--------------------------------------------------------*/


          /*-----------------------shop by spectrum------------------------------------------------*/

            /*select all data from shop by spectrum table*/
            $arr_shop_by_spectrum = $this->ShopBySpectrumModel
                                    ->where('is_active','1')                
                                    ->get()->toArray();

          /*---------------------------------------------------------------------------------------*/

           //get reported effects 

             $get_reported_effects = $this->ReportedEffectsModel->where('is_active','1')->get(); 
             if(isset($get_reported_effects) && !empty($get_reported_effects))
             {
               $get_reported_effects = $get_reported_effects->toArray();
             }  
            $this->arr_view_data['get_reported_effects'] = isset($get_reported_effects)?$get_reported_effects:[];


            $this->arr_view_data['arr_shop_by_spectrum']   = isset($arr_shop_by_spectrum)?$arr_shop_by_spectrum:[];
            $this->arr_view_data['arr_eloq_trending_data'] = isset($you_may_like_arr)?$you_may_like_arr:[];

            $this->arr_view_data['arr_shop_by_effect']     = isset($arr_shop_by_effect)?$arr_shop_by_effect:[];
            
            $this->arr_view_data['get_loginuserinfo']      = isset($get_loginuserinfo)?$get_loginuserinfo:[];

            return view($this->module_view_folder.'.index',$this->arr_view_data);
        }
    }//end of search function

    public function checkbrandnameexists(request $request)
    {
        if (isset($request['query'])) 
        {
             $brandname = $request['query'];  
          
            if($brandname)
            {
               
                $getbrand = $this->BrandModel->where('name','like',$brandname.'%')->get();
                if(isset($getbrand) && (!empty($getbrand)))
                {
                    $getbrand = $getbrand->toArray();
                    if(!empty($getbrand))
                        return '1';
                    else
                        return '0';
                }    
                 
            }

        }// end of search by brands

    }  



    public function get_pagination_data($arr_data = [], $pageStart = 1, $per_page = 0, $apppend_data = [])
    {
        
        $perPage  = $per_page; /* Indicates how many to Record to paginate */
        $offSet   = ($pageStart * $perPage) - $perPage; /* Start displaying Records from this No.;*/        
        $count    = count($arr_data);
        /* Get only the Records you need using array_slice */
        $itemsForCurrentPage = array_slice($arr_data, $offSet, $perPage, true);

        /* Pagination to an Array() */
         $paginator =  new LengthAwarePaginator($itemsForCurrentPage, $count, $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));      
           

        $paginator->appends($apppend_data); /* Appends all input parameter to Links */
        
        return $paginator;
    }//end of get pagination data

    function isMobileDevice() {
        $is_mobile_device =  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        if($is_mobile_device)
        {   
            return 1;
        }else{
            return 0;
        }

    }
    public function product_details($enc_id = false, $title = false)
    {   
        

        /*******************Restricted states seller id***********************************/

       $check_buyer_restricted_states =  get_buyer_restricted_sellers();
       $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];


         /******************location***start***************************/   
         $checkuser_locationdata = checklocationdata(); 
         if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
         {
           $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
           $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
         } 
         /******************location*end*****************************/


        $currenturl = url('/').'/search/product_detail/'.$enc_id;
        $arr_product = $seller_products = []; 
        $user_id     = 0;
        $id   = base64_decode($enc_id);
        $user = Sentinel::check();
        if($user!=false)
        {
            $user_id          = $user->id;
            if($user->inRole('seller'))
            {    
               $seller_products  = $this->ProductModel->where('user_id',$user_id)->select('id')->get()->toArray();
            }   
        }

        $arr_product     = $this->ProductService->get_product_details($id);
        
        if(isset($arr_product) && count($arr_product)>0)
        {
          $url = isset($arr_product['product_video_url'])&&$arr_product['product_video_url']!=""?$arr_product['product_video_url']:false;
          // $url_http = $arr_product['product_video_url'];
          if(strpos($url,'http') === 0)
          {
            if($arr_product['product_video_source'] == "youtube")
            {
              if($url!=false)
              {
                $tmp_arr = explode("?v=", $url);
                $url_id = isset($tmp_arr[1])?$tmp_arr[1]:'';
                $arr_product['url_id'] = $url_id;
              }
            }
            else
            {
              if($url!=false)
              {
                $tmp_arr = explode("/", $url);
                $imgid = isset($tmp_arr[3])?$tmp_arr[3]:'';
                $hash = "";
                try
                {
                  $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                  $arr_product['url_id'] = $hash[0]['thumbnail_medium'];
                }catch(\Exception $e)
                {
                  $arr_product['url_id'] = "";
                }
              }
            }
          }
          else{
            if($arr_product['product_video_source'] == "youtube")
            {
              if($url!=false)
              {
                $url_id = isset($url)?$url:'';
                $arr_product['url_id'] = $url_id;
              }
            }
            else
            {
              if($url!=false)
              {
                $imgid = isset($url)?$url:'';
                $hash = "";
                try
                {
                  $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                  $arr_product['url_id'] = $hash[0]['thumbnail_medium'];
                }catch(\Exception $e)
                {
                  $arr_product['url_id'] = "";
                }
              }
            }
          }
          
        }
        
        
        if(!empty($arr_product))
        {
            
            if($arr_product['user_details']['get_country_detail']['is_active']==0)
            {
                return redirect('/');
            }
            if($arr_product['user_details']['get_state_detail']['is_active']==0)
            {
                return redirect('/');
            }
            if($arr_product['get_brand_detail']['is_active']==0)
            {
                return redirect('/');
            }
             if($arr_product['user_details']['is_active']==0)
            {
                return redirect('/');
            }
             if($arr_product['is_approve']==2)
            {
                return redirect('/');
            }



            $first_level_category_id = isset($arr_product['first_level_category_id'])?$arr_product['first_level_category_id']:'';

            /*you may likes products*/

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
      

        }  //not empty arr product


        $arr_comment     = $this->ProductCommentModel->orderBy('created_at','DESC')->take(5)->where('product_id',$id)->with('user_details','reply_details.user_details')->get()->toArray();
        $fav_product_arr = $this->FavoriteModel->where('buyer_id',$user_id)->select('product_id')->get()->toArray();
        $total_comments  = count($arr_comment);


        $obj_buyer_id_proof = $this->BuyerModel->where('user_id',$user_id)->first();

        if ($obj_buyer_id_proof) {
            
            $buyer_id_proof = $obj_buyer_id_proof->toArray();
        }

        $products = $product_purchased_by_user = $is_review_added = "";
        $order_ids = array();


        $order_ids   = $this->OrderModel->where('buyer_id',$user_id)->where('order_status','1')->select('id')->get()->toArray();
        if(isset($order_ids) && count($order_ids)>0)
        {    
            $product_ids    =  $this->OrderProductModel->whereIn('order_id',$order_ids)->select('product_id')->groupBy('product_id')->get()->toArray();
            $products       =   array_column($product_ids, 'product_id');

            if(in_array($id, $products))
            {
               $product_purchased_by_user =1; 
            }
            else
            {
               $product_purchased_by_user =0;  
            }
        }

        
        /*this query for checking product is best seller or not*/

        $is_best_seller = "";
    

        $prodmodel           = $this->ProductModel->getTable();
        $prefix_productable  = DB::getTablePrefix().$this->ProductModel->getTable();

        $order_table         = $this->OrderModel->getTable();
        $prefix_order_detail = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_table  = $this->OrderProductModel->getTable();
        $prefix_order_product = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $reviewmodel         = $this->ReviewRatingsModel->getTable();
        $prefix_reviewtable  = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();

            

         //new query added for best seller

         $is_best_seller = "";
         $productids = $avgproductids = [];
         $arr = []; $mostsolded ='';
            
         $arr_trending_productids =  DB::table($prefix_order_detail)->select(DB::raw(
                                        $prefix_order_product.'.product_id,count('.$prefix_order_product.'.product_id) as mostsold'
                                    ))
                                  ->leftJoin($prefix_order_product,$prefix_order_product.'.order_id','=',$prefix_order_detail.'.id')    
                                 ->where($prefix_order_detail.'.order_status','1')  
                                 ->groupBy($prefix_order_product.'.product_id')
                                 ->orderBy('mostsold','desc')
                                 //->limit(50)
                                 ->get()->toArray();  

           if(isset($arr_trending_productids) &&!empty($arr_trending_productids))
            {  
                 $productidssold   = array_column($arr_trending_productids, 'product_id');
                 $mostsold         = array_unique(array_column($arr_trending_productids, 'mostsold'));
                 $arr = []; $mostsolded ='';
                 foreach($mostsold as $v)
                 {
                    $arr[] = $v;
                 }
                 
                 $mostsolded = implode(",", $arr);

            }//if isset arr_mostsold_productids

             if(isset($arr_trending_productids) && !empty($arr_trending_productids) && isset($mostsolded) &&  !empty($mostsolded))
            {
                $productids   = array_column($arr_trending_productids, 'product_id');

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
                 
                    ->whereIn('id',$productids)    
                    ->where([['is_active',1],['is_approve',1]])
                   // ->orderByRaw('FIELD(id,'.$mostsolded.')')
                    ->get();

                                        
 
                if(isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data))
                {
                    $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
                    $avgproductids   = array_column($arr_eloq_trending_data, 'id');
                    if(in_array($id,$avgproductids))
                    {
                        $is_best_seller = "1";
                    }else
                    {
                        $is_best_seller = "";
                    }
                } //if isset arr_eloq_trending_data                                    

            } // if isset arr trending & most solded

    
        
        // $res_id_proof = $this->BuyerModel->where('user_id',$user_id)->get()->toArray();
        $is_review_added  = $this->ReviewRatingsModel->where('product_id',$id)->where('buyer_id',$user_id)->count();

        /*--buyer view product add this enttry into buyer view product table---------------*/
        
            $product_data = [];
            $loggedIn_Id = 0;

            
            $ip_address = $this->get_ip_address();
            $session_id = $this->get_session_id();
            $user       = $this->check_auth();

            if($user)
            {
              $loggedIn_Id = $user->id;  
            }

          
            if($loggedIn_Id == 0)
            {
                $product_data['product_id']      = $id;
                $product_data['buyer_id']        = 0;
                $product_data['user_session_id'] = $session_id;
                $product_data['ip_address']      = $ip_address;
               
               
                $count = $this->BuyerViewProductModel
                          ->where('buyer_id',0)
                          ->where('user_session_id',$session_id)
                          ->where('ip_address',$ip_address)
                          ->where('product_id',$id)
                          ->count();
 
                if($count == 0)
                {
                   $result = $this->BuyerViewProductModel->create($product_data);
                }

               
            }else{
               
                $product_data['product_id']      = $id;
                $product_data['buyer_id']        = $user_id;
                $product_data['user_session_id'] = $session_id;
                $product_data['ip_address']      = $ip_address;

                $count = $this->BuyerViewProductModel
                              ->where('buyer_id',$user_id)
                              ->where('user_session_id',$session_id)
                              ->where('ip_address',$ip_address)
                              ->where('product_id',$id)
                              ->count();
 
                if($count == 0)
                {
                   $result = $this->BuyerViewProductModel->create($product_data);
                }
            }


        /*--------------------------------------------------------------------------------*/


        /* check money back request send or not*/
          $request_status = '';

          $request_status = $this->MoneyBackModel->where('product_id',$id)
                                 ->where('buyer_id',$user_id)
                                 ->pluck('status')
                                 ->first();
        /*----------------------------------------------*/


         $get_reported_effects = $this->ReportedEffectsModel->where('is_active','1')->get(); 
         if(isset($get_reported_effects) && !empty($get_reported_effects))
         {
           $get_reported_effects = $get_reported_effects->toArray();
         }  
        $this->arr_view_data['get_reported_effects'] = isset($get_reported_effects)?$get_reported_effects:[];

        $this->arr_view_data['request_status']        = $request_status;
        $this->arr_view_data['back_path']        = $this->back_path;
        $this->arr_view_data['arr_product']      = isset($arr_product)?$arr_product:[];
        $this->arr_view_data['arr_comment']      = isset($arr_comment)?$arr_comment:[];
        $this->arr_view_data['seller_products']  = isset($seller_products)?$seller_products:[];
        $this->arr_view_data['total_comments']   = isset($total_comments)?$total_comments:0;
        $this->arr_view_data['fav_product_arr']  = $fav_product_arr;
        $this->arr_view_data['product_purchased_by_user']  = $product_purchased_by_user;
        $this->arr_view_data['is_review_added']  = $is_review_added;


        $this->arr_view_data['page_title']       = isset($arr_product['product_name'])? $arr_product['product_name']: 'Product Details';
        
        $this->arr_view_data['buyer_id_proof'] = isset($buyer_id_proof)?$buyer_id_proof:'';
        $this->arr_view_data['productid']  = $id;
        $this->arr_view_data['currenturl']  = isset($currenturl)?$currenturl:'';
        $this->arr_view_data['isMobileDevice'] = $this->isMobileDevice();
        $this->arr_view_data['state_user_ids']  = isset($state_user_ids)?$state_user_ids:'';
        $this->arr_view_data['catdata']  = isset($catdata)?$catdata:[];
        
        $this->arr_view_data['is_best_seller']  = $is_best_seller;

        $this->arr_view_data['first_level_category_id'] = $first_level_category_id;
        /*****************added to show reviews******************/

        $obj_product_reviews  = $this->ReviewRatingsModel
                          ->with([
                            'buyer_details',
                            'user_details',
                           ]) 
                          ->where('product_id',$id)
                          ->orderBy('created_at','desc')
                          ->limit(5)
                          ->get();                  

        if($obj_product_reviews)
        {
            $arr_product_reviws = $obj_product_reviews->toArray();
        }
        
        $this->arr_view_data['arr_product']['review_details']   = isset($arr_product_reviws)?$arr_product_reviws:[];

      /*******************end*********************************/

        return view($this->module_view_folder.'.view',$this->arr_view_data);

    }//end

    public function get_second_level_category(Request $request)
    {	
    	$arr_second_level_category   = [];
        $first_level_category_id     = $request->input('first_level_category_id');

        $arr_second_level_category   = $this->SecondLevelCategoryModel->where('first_level_category_id',$first_level_category_id)->where('is_active','1')
        							   ->get()
        							   ->toArray();

        $response['second_level_category'] = isset($arr_second_level_category)?$arr_second_level_category:[]; 
        return $response;
    }
    

      // function for search product in header 
   public function fetchproductlist(Request $request)
    {
     
      $html = '';
      $html .='<ul>';
      $formdata = $request->all();

      $query    = $formdata['query'];

      if($formdata['category']=="All")
      $category = $formdata['category'];
      else
      $category = base64_decode($formdata['category']);

      
          if($category=="All" && $query!="")
          {
              $res_product = $this->ProductModel->where('product_name','like','%'.$query.'%')->where('is_active','1')->where('is_approve','1')->get()->toArray(); 


                if(isset($res_product)){
                   if(!empty($res_product) && count($res_product)>0){
                    foreach($res_product as $product){
                      $product_name = $product['product_name'];
                      $product_id = base64_encode($product['id']);

                      $html .='<li><a href="'.url('search/product_detail/'.$product_id).'"> '.$product_name.'</a></li>';
                   }//foreach product
                  }//if not empty product
                }//isset product
          }
          else if($category!="All" && $query!="")
          {
           
              // $res_cat_arr = $this->FirstLevelCategoryModel->where('product_type',$category)->where('is_active','1')->get()->toArray();

               $res_cat_arr = $this->FirstLevelCategoryModel->where('id',$category)->where('is_active','1')->get()->toArray();

               if(!empty($res_cat_arr))
               {
                    $category_id = $res_cat_arr[0]['id'];
                    $category_name = $res_cat_arr[0]['product_type'];

                    $res_product = $this->ProductModel->where('product_name','like','%'.$query.'%')->where('is_active','1')->where('is_approve','1')->where('first_level_category_id',$category_id)->get()->toArray(); 

                      if(isset($res_product)){
                         if(!empty($res_product) && count($res_product)>0){

                            $url = url('/').'/search?category='.base64_encode($category_id).'&product='.$query;

                            $html .='<ul>';
                            $html .='<li> <a href="'.$url.'">'.$category_name.' </a> </li>';
                            $html .='</ul>';

                          foreach($res_product as $product){
                            $product_name = $product['product_name'];
                            $product_id = base64_encode($product['id']);
                           
                            $html .='<li> <a href="'.url('search/product_detail/'.$product_id).'"> '.$product_name.'</a> </li>';
                         }//foreach product
                        }//if not empty product
                      }//isset product


               }

             
          }
     
      $html .='</ul>';   
      echo  $html;    

    }// end of function 

    public function getShopByCategory(Request $request,$state=NULL)
    {   
        /* 
        $stateofuser = '';   
         $login_user = Sentinel::check();  
         if(isset($login_user) && $login_user==true && $login_user->inRole('seller') == true) 
         {
         
         }
        else if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true) {
              $user_shipping_state  = $login_user->state;
               if(isset($user_shipping_state))
               {
                 $stateofuser = get_statedata($user_shipping_state);
                 Session::forget('stateofguestuser'); 

               }else{
                   $stateofuser = '';
               }
            }
            else if(isset($login_user) && $login_user==true && $login_user->inRole('admin') == true)
            {

            } 
            else
            {
                $stateofuser = trim($state);
                Session::put('stateofguestuser', $stateofuser);
            }*/


         /**************location*data****************************/
         $ipcountry  = '';
         $ipstate  = '';
         $login_user = Sentinel::check();  
         if(isset($login_user) && $login_user==true && $login_user->inRole('seller') == true) 
         {

         }
         else if(isset($login_user) && $login_user==true && $login_user->inRole('admin') == true) {

         }
        else if(isset($login_user) && $login_user==true && $login_user->inRole('buyer') == true)
         {
               $ipcountry  = $login_user->country;
               $state  = get_statedata($login_user->state);
              
         }//else if user is buyer
         else{
             $myip = $_SERVER['REMOTE_ADDR'];
             $get_ipdata = IpDataModel::where('ip',$myip)->first();
             if(isset($get_ipdata) && !empty($get_ipdata))
             {
               $get_ipdata = $get_ipdata->toArray(); 
               $ipcountry  = $get_ipdata['country'];
               $state      = get_statedata($get_ipdata['state']);
               $ipdb       = $get_ipdata['ip'];
             }
         }

         /****************end location data*****************/   


        $category_ids='';
        $state = $state;
       //  $state = $stateofuser;
        if(isset($state))
        {
            $state = str_replace('-',' ',$state); 

            $get_categoryids = $this->StatesModel->where('name',trim($state))->first();
            if(isset($get_categoryids) && !empty($get_categoryids))
            {
                $get_categoryids = $get_categoryids->toArray();
               
                $category_ids = $get_categoryids['category_ids'];
            }
        }

       
        $arr_response = [];
        $arr_category = $this->FirstLevelCategoryModel
                        ->where('is_active','1')
                        ->select('product_type','id')
                        ->orderBy('product_type');
       
        $arr_category = $arr_category->get()->toArray();

        $arr_response['arr_category'] = $arr_category;
        
        return response()->json($arr_response);
    }

    // function for getting autosuggest list of search by brand 
     public function autosuggest(request $request)
    { 
           
      
         $sellers = $request->sellers;   
         $rating = $request->rating;
         $category_id = $request->category_id;
         $age_restrictions = $request->age_restrictions;
         $price = $request->price;
         $mg = $request->mg;
         $filterby_price_drop = $request->filterby_price_drop;
         $product_search = $request->product_search;
         $state = $request->state;
         $city = $request->city;
         $chows_choice = $request->chows_choice;
         $best_seller = $request->best_seller;
         $spectrum = $request->spectrum;
         $statelaw = $request->statelaw;

         $reported_effects = $request->reported_effects;
         $cannabinoids = $request->cannabinoids;

         $featured = $request->featured;


        if($request->query)
       {

            $brand_table        = $this->BrandModel->getTable();
            $prefix_brand_table = DB::getTablePrefix().$this->BrandModel->getTable();

            $query = $request['query']; 
            $data = DB::table($prefix_brand_table)
                    ->where('name', 'LIKE', "%{$query}%")
                    ->where('is_active','1')
                    ->get()->toArray();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if(isset($data) && !empty($data)){
                foreach($data as $row)
                {

                      $url = '';
                      if(isset($row->name)){
                      //  $url = url('search?brands='.base64_encode($row->name));
                        $brandname = str_replace(' ','-',$row->name);
                        $url = url('search?brands='.$brandname);
                      } 
                      if(isset($category_id)){
                         $url .= '&category_id='.$category_id;
                      }  
                      if(isset($mg)){
                         $url .= '&mg='.$mg;
                      }             
                      if(isset($sellers)){
                         $url .= '&sellers='.$sellers;
                      }
                      if(isset($price)){
                         $url .= '&price='.$price;
                      }
                      if(isset($rating)){
                         $url .= '&rating='.$rating;
                      }
                      if(isset($age_restrictions)){
                         $url .= '&age_restrictions='.$age_restrictions;
                      }                             

                       if(isset($filterby_price_drop) && $filterby_price_drop=='true'){
                         $url .= '&filterby_price_drop='.$filterby_price_drop;
                      }     
                      if(isset($product_search)){
                         $url .= '&product_search='.$product_search;
                      }       
                      if(isset($state)){
                         $url .= '&state='.$state;
                      } 
                       if(isset($city)){
                         $url .= '&city='.$city;
                      } 

                       if(isset($spectrum)){
                         $url .= '&spectrum='.$spectrum;
                      } 

                       if(isset($statelaw)){
                         $url .= '&statelaw='.$statelaw;
                      } 

                       if(isset($chows_choice) && $chows_choice=='true'){
                         $url .= '&chows_choice='.$chows_choice;
                      } 
                       if(isset($best_seller) && $best_seller=='true'){
                         $url .= '&best_seller='.$best_seller;
                      } 

                      if(isset($reported_effects)){
                         $url .= '&reported_effects='.$reported_effects;
                      }

                       if(isset($cannabinoids)){
                         $url .= '&cannabinoids='.$cannabinoids;
                      } 
                      if(isset($featured))
                      {
                        $url .= '&featured='.$featured;
                      }

                     $output .= '
                      <li class="liclick" id='.$row->id.'>
                      <a href="'.$url.'"> '.$row->name.'</a>
                      </li>';
                }
            }else{
              $output .='<li><a href="#">Not Found</a></li>';
            }
            $output .= '</ul>';
            echo $output;
       }
    } // end of function of autosuggest


    // function for autosuggest list of search by seller
     public function autosuggest_by_seller(request $request)
    { 

         $category_id = $request->category_id;
         $rating = $request->rating;
         $age_restrictions = $request->age_restrictions;
         $price = $request->price;
         $brands = $request->brands;
         $brand = $request->brand;
         $mg = $request->mg;

         $featured = $request->featured;


        if($request->query)
       {

            $user_table        = $this->UserModel->getTable();
            $prefix_user_table = DB::getTablePrefix().$this->UserModel->getTable();

            $query = $request['query']; 
            $data = DB::table($prefix_user_table)
                     ->where([['first_name', 'LIKE', "%{$query}%"],['is_active','1'],['is_trusted','1'],['user_type','=','seller']])
                     ->orWhere([['last_name', 'LIKE', "%{$query}%"],['is_active','1'],['is_trusted','1'],['user_type','=','seller']])
                  //   ->where([['is_active','1'],['is_trusted','1'],['user_type','=','seller']])
                     ->get()->toArray();


            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if(isset($data) && !empty($data)){
                foreach($data as $row)
                {

                     $first_name = $row->first_name;
                     $last_name = $row->last_name;
                     $full_name = $first_name.'-'.$last_name;


                      $url = '';
                      if(isset($full_name)){
                        $url = url('search?sellers='.$full_name);
                      } 
                      if(isset($category_id)){
                         $url .= '&category_id='.$category_id;
                      }  
                      if(isset($mg)){
                         $url .= '&mg='.$mg;
                      }   
                      if(isset($brand)){
                         $url .= '&brand='.$brand;
                      }             
                      if(isset($sellers)){
                         $url .= '&sellers='.$sellers;
                      }
                      if(isset($brands)){
                         $url .= '&brands='.$brands;
                      }  
                      if(isset($price)){
                         $url .= '&price='.$price;
                      }
                      if(isset($rating)){
                         $url .= '&rating='.$rating;
                      }
                      if(isset($age_restrictions)){
                         $url .= '&age_restrictions='.$age_restrictions;
                      }  

                      if(isset($featured))
                      {
                        $url .= '&featured='.$featured;
                      }


                     $output .= '
                      <li class="liclickseller" id='.$row->id.'>
                      <a href="'.$url.'"> '.$row->first_name.' '.$row->last_name.'</a>
                      </li>';
                }
            }else{
              $output .='<li><a href="#">Not Found</a></li>';
            }
            $output .= '</ul>';
            echo $output;
       }
    } // end of function of autosuggest of seller


    // autosuggest by business name


    // function for autosuggest list of search by seller
     public function autosuggest_by_business(request $request)
    { 

         $category_id = $request->category_id;
         $rating = $request->rating;
         $age_restrictions = $request->age_restrictions;
         $price = $request->price;
         $brands = $request->brands;
         $brand = $request->brand;
         $mg = $request->mg;
         $filterby_price_drop = $request->filterby_price_drop;
         $product_search = $request->product_search;
         $state = $request->state;
         $city = $request->city;
         $chows_choice = $request->chows_choice;
         $best_seller = $request->best_seller;
         $spectrum = $request->spectrum; 
         $statelaw = $request->statelaw; 
         $reported_effects = $request->reported_effects;
         $cannabinoids = $request->cannabinoids;

         $featured = $request->featured;



        if($request->query)
       {

            $user_table        = $this->UserModel->getTable();
            $prefix_user_table = DB::getTablePrefix().$this->UserModel->getTable();
           

            $seller_table        = $this->SellerModel->getTable();
            $prefix_seller_table = DB::getTablePrefix().$this->SellerModel->getTable();
            $query = $request['query']; 

           /* $data = DB::table($prefix_seller_table)
                     ->where([['business_name', 'LIKE', "%{$query}%"]])
                     ->get()->toArray();*/


            $data = DB::table($prefix_seller_table)
                     ->where([['business_name', 'LIKE', "%{$query}%"]])
                     ->where($prefix_user_table.'.is_active','1')
                     ->leftJoin($prefix_user_table,$prefix_user_table.'.id','=',$prefix_seller_table.'.user_id')
                     ->where('business_name','!=','')
                     ->get()->toArray();         


            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if(isset($data) && !empty($data)){
                foreach($data as $row)
                {

                     $businessname = $row->business_name;


                      $url = '';
                      if(isset($businessname))
                      {
                        $businessname = str_replace(' ','-',$businessname);
                        $url = url('search?sellers='.$businessname);
                      } 
                      if(isset($category_id)){
                         $url .= '&category_id='.$category_id;
                      }  
                      if(isset($mg)){
                         $url .= '&mg='.$mg;
                      }   
                      if(isset($brand)){
                         $url .= '&brand='.$brand;
                      }             
                      if(isset($sellers)){
                         $url .= '&sellers='.$sellers;
                      }
                      if(isset($brands)){
                         $url .= '&brands='.$brands;
                      }  
                      if(isset($price)){
                         $url .= '&price='.$price;
                      }
                      if(isset($rating)){
                         $url .= '&rating='.$rating;
                      }
                      if(isset($age_restrictions)){
                         $url .= '&age_restrictions='.$age_restrictions;
                      }     
                      if(isset($filterby_price_drop) && $filterby_price_drop=='true'){
                         $url .= '&filterby_price_drop='.$filterby_price_drop;
                      }
                       if(isset($product_search)){
                         $url .= '&product_search='.$product_search;
                      } 
                       if(isset($state)){
                         $url .= '&state='.$state;
                      }   
                       if(isset($city)){
                         $url .= '&city='.$city;
                      }   
                       if(isset($spectrum)){
                         $url .= '&spectrum='.$spectrum;
                      }   

                      if(isset($chows_choice) && $chows_choice=='true'){
                         $url .= '&chows_choice='.$chows_choice;
                      }  
                      if(isset($best_seller) && $best_seller=='true'){
                         $url .= '&best_seller='.$best_seller;
                      } 
                       if(isset($statelaw)){
                         $url .= '&statelaw='.$statelaw;
                      }   
                       
                       if(isset($reported_effects)){
                         $url .= '&reported_effects='.$reported_effects;
                      }  
                      if(isset($cannabinoids)){
                         $url .= '&cannabinoids='.$cannabinoids;
                      }          
               
                      if(isset($featured))
                      {
                        $url .= '&featured='.$featured;
                      }
                              

                     $output .= '
                      <li class="liclickseller" id='.$row->id.'>
                      <a href="'.$url.'"> '.$row->business_name.'</a>
                      </li>';
                }
            }else{
              $output .='<li><a href="#">Not Found</a></li>';
            }
            $output .= '</ul>';
            echo $output;
       }
    } // end of function of autosuggest of business name






    function showcomments(Request $request)
    {        
      $id = $request->product_id;
      if($id)
      {
         $arr_comment     = $this->ProductCommentModel->orderBy('created_at','DESC')
                            ->take(5)
                            ->where('product_id',$id)
                            ->with('user_details','reply_details.user_details') 
                             /*->whereHas('reply_details',function($q){
                                  $q->orderBy('id','DESC');
                             })*/
                            ->get()->toArray();


        // $arr_comment_count = $this->ProductCommentModel->orderBy('created_at','DESC')
        //                     ->where('product_id',$id)
        //                     ->with('user_details','reply_details.user_details')
        //                     ->get()->toArray();  

        $arr_comment_count = $this->ProductCommentModel->orderBy('created_at','DESC')
                            ->where('product_id',$id)
                            ->with('user_details','reply_details.user_details')
                            ->count();                   

        $user_id =0;                      
        $user = Sentinel::check();
        if($user!=false)
        {
            $user_id          = $user->id;
            if($user->inRole('seller'))
            {    
               $seller_products  = $this->ProductModel->where('user_id',$user_id)->select('id')->get()->toArray();
            }   
        }

        // if(isset($arr_comment_count) && !empty($arr_comment_count)){
        //      $total_comments  = count($arr_comment_count);
        //  }else{
        //       $total_comments  = 0;
        //  }
       
        $this->arr_view_data['arr_comment']      = isset($arr_comment)?$arr_comment:[];
        $this->arr_view_data['seller_products']  = isset($seller_products)?$seller_products:[];
        //$this->arr_view_data['total_comments']   = isset($total_comments)?$total_comments:0;
        $this->arr_view_data['total_comments']   = isset($arr_comment_count)?$arr_comment_count:0;
        $this->arr_view_data['productid']        = $id;   
        $this->arr_view_data['page_title']       = "Comments";   
        return view($this->module_view_folder.'.comments',$this->arr_view_data);

      }
    }

    // new function added for more comments
    public function showmorecomments($enc_id,Request $request)
    {
        $user_id =0;
        $product_id = base64_decode($enc_id); 
        if($product_id)
        {
            $arr_comment  = $this->ProductCommentModel->orderBy('created_at','DESC')
                            ->where('product_id',$product_id)
                            ->with('user_details','reply_details.user_details')
                            ->get()->toArray();


                $user = Sentinel::check();
                if($user!=false)
                {
                    $user_id          = $user->id;
                    if($user->inRole('seller'))
                    {    
                       $seller_products  = $this->ProductModel->where('user_id',$user_id)->select('id')->get()->toArray();
                    }   
                }  

        $arr_product     = $this->ProductService->get_product_details($product_id);

        if(!empty($arr_product))
        {
            
            if($arr_product['user_details']['get_country_detail']['is_active']==0)
            {
                return redirect('/');
            }
            if($arr_product['user_details']['get_state_detail']['is_active']==0)
            {
                return redirect('/');
            }
            if($arr_product['get_brand_detail']['is_active']==0)
            {
                return redirect('/');
            }
             if($arr_product['user_details']['is_active']==0)
            {
                return redirect('/');
            }
         }     


            $apppend_data = url()->current();

            if($request->has('page'))
            {   
                $pageStart = $request->input('page'); 
            }
            else
            {
                $pageStart = 1; 
            }

            $paginator = $this->get_pagination_data($arr_comment, $pageStart, 10 , $apppend_data);


            if($paginator)
            {
                $pagination_links    =  $paginator;  
                $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 

            }   

          if($paginator)
          {
              $arr_comments     =  $paginator->items();
              
              $arr_pagination  = $paginator; 
              $this->arr_view_data['arr_pagination'] = $arr_pagination;


              $fav_product_arr = $this->FavoriteModel->where('buyer_id',$user_id)->select('product_id')->get()->toArray();

              $this->arr_view_data['arr_product']      = isset($arr_product)?$arr_product:[];
              $this->arr_view_data['fav_product_arr']  = $fav_product_arr;
              $is_review_added  = $this->ReviewRatingsModel->where('product_id',$product_id)->where('buyer_id',$user_id)->count();
              $this->arr_view_data['is_review_added']  = $is_review_added;

             $this->arr_view_data['isMobileDevice'] = $this->isMobileDevice();


              $total_comments  = count($arr_comment);      
              $this->arr_view_data['total_comments']   = isset($total_comments)?$total_comments:0;
              $this->arr_view_data['seller_products']  = isset($seller_products)?$seller_products:[];
              $this->arr_view_data['arr_comment']      = isset($arr_comments)?$arr_comments:[];
              $this->arr_view_data['productid']        = $product_id;   
              $this->arr_view_data['page_title']       = isset($arr_product['product_name'])? $arr_product['product_name'].'| Comments': 'Product Details';


          }// If paginator
          return view($this->module_view_folder.'.view_comments',$this->arr_view_data);

        }//if


    }




     function showreviews(Request $request)
    {        
      $id = $request->product_id;
      if($id)
      {
       

       // $arr_product     = $this->ProductService->get_product_details($id);

        $arr_product = [];

       /* $obj_product  = $this->ProductModel
                          ->with([
                            'review_details.buyer_details',
                            'review_details.user_details',
                           ]) 
                          ->where('id',$id)
                          ->first();*/

         $obj_product  = $this->ReviewRatingsModel
                          ->with([
                            'buyer_details',
                            'user_details',
                           ]) 
                          ->where('product_id',$id)
                          ->orderBy('created_at','desc')
                          ->get();                  

        if($obj_product)
        {
            $arr_product = $obj_product->toArray();
        }
        
        $this->arr_view_data['arr_product']['review_details']   = isset($arr_product)?$arr_product:[];
        $this->arr_view_data['productid']        = $id;   
        return view($this->module_view_folder.'.reviews',$this->arr_view_data);

      }
    }

     function showrreply(Request $request)
    {        
      $id = $request->comment_id;
      if($id)
      {
       //$arr_product     = $this->ProductService->get_product_details($id);
        //$arr_comment     = $this->ProductCommentModel->orderBy('created_at','DESC')->take(5)->where('product_id',$id)->with('user_details','reply_details.user_details')->get()->toArray();
       // $this->arr_view_data['arr_comment']      = isset($arr_comment)?$arr_comment:[];
       // $this->arr_view_data['arr_product']      = isset($arr_product)?$arr_product:[];
        $this->arr_view_data['productid']        = $id;   

       // $arr_reply     = $this->ProductCommentModel->orderBy('created_at','DESC')->take(5)->where('id',$id)->with('user_details','reply_details.user_details')->get()->toArray();

         $arr_reply     = $this->ReplyModel
                           // ->orderBy('id','DESC')
                            ->with('user_details')
                            ->take(5)
                            ->where('comment_id',$id)
                            ->get()->toArray();
      
        $this->arr_view_data['comment']      = isset($arr_reply)?$arr_reply:[];

        return view($this->module_view_folder.'.reply',$this->arr_view_data);

      }
    }// end of function

    function send_reportproduct(Request $request)
    { 
        $product_id  = $request->product_id;
        $to_email    = $request->to;
        $to_id       = $request->to_id;
        $buyer_id    = $request->from;
        $buyer_email = $request->from_email;
        $message     = $request->message;
        $link        = $request->link;

        if($buyer_id && $to_email && $message && $link)
        {

            $data = array('product_id'=>$product_id,'buyer_id'=>$buyer_id,'link'=>$link,'message'=>$message);
            $insertdata = $this->ReportproductModel->create($data);
            if($insertdata->id)
            {

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;

                    if($user_details->first_name=="" || $user_details->last_name==""){
                         $user_name ='Buyer'; 
                    }else{
                         $user_name = $user_details->first_name.' '.$user_details->last_name;
                    }

                   
                }
                $productdata = $this->ProductModel->where('id',$product_id)->first();
       
                if(!empty($productdata))
                {
                    $productdata = $productdata->toArray();
                }

                
                /*****************Send Notification to Admin (START)**************************/
                    
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $buyer_id;
                    $arr_event['to_user_id']   = $to_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has reported the product <a target="_blank" href="'.$link.'"><b>'.$productdata['product_name'].'</b></a>. <br> <b>Report Reason: </b>'.$message);

                    $arr_event['type']         = '';
                    $arr_event['title']        = 'A product has been reported';
                    $this->GeneralService->save_notification($arr_event);


                /******************* Send Notification to Admin (END) *********************/
                // $arr_mail_data = $this->built_data($buyer_id,$to_id,$product_id);
                // $email_status  = $this->EmailService->send_mail($arr_mail_data);

                /*********************Send Mail Notification to Admin (START)*************************/
                    $to_user = Sentinel::findById($to_id);

                    $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                    $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

                   /* $msg     = html_entity_decode('<b>'.$user_name.'</b> has reported the product <b>' . $productdata['product_name'].'</b>. <br> <b>Report Reason: </b>'.$message);

                    $subject = 'A product has been reported';*/

                    $arr_built_content = [
                        'ADMIN_NAME'    => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                        'BUYER_NAME'    => $user_name,
                        'PRODUCT_NAME'  => $productdata['product_name'],
                        'REASON'        => $message,
                        //'MESSAGE'       => $msg,
                        'URL'           => $link
                    ];

                    $arr_mail_data['email_template_id'] = '40';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($to_id);

                    $this->EmailService->send_mail_section($arr_mail_data);
                    
                /********************Send Mail Notification to Admin (END)***************/
                

              $response['status']      = 'SUCCESS';
              $response['description'] = 'The product has been reported successfully.'; 
              return response()->json($response);   
            }else{
                  $response['status']      = 'ERROR';
                  $response['description'] = 'Problem occured while sending report'; 
                  return response()->json($response); 
            }

        }


    }// end of function

public function get_details($user_id)
  {

    $res_user = $this->UserModel->where('id',$user_id)->first();
    if(!empty($res_user))
    {
      return $res_user;
    }
    return FALSE;
  }

     public function built_data($buyer_id,$admin_id,$product_id)
  {

    $admin_arr =[];
    $admin_obj = UserModel::where('id',$admin_id)->first();
    if($admin_obj)
    {
      $admin_arr = $admin_obj->toArray();
    }

    $buyer_detail = $this->get_details($buyer_id);
    if($buyer_detail)
    {
        $arr_buyer = $buyer_detail->toArray();

        $productdata = $this->ProductModel->where('id',$product_id)->first();
       
        if(!empty($productdata))
        {
            $productdata = $productdata->toArray();
        }
        if(!empty($productdata)){

          $arr_built_content = [
                              'ADMIN_NAME'   => $admin_arr['first_name'].' '.$admin_arr['last_name'],  
                              'BUYER_NAME'   => $arr_buyer['first_name'].' '.$arr_buyer['last_name'],
                              'PRODUCT_NAME' =>$productdata['product_name'],
                              'EMAIL'        => $admin_arr['email'],
                              'SITE_URL'     => config('app.project.name')];

        $arr_mail_data                      = [];
        $arr_mail_data['email_template_id'] = '40';
        $arr_mail_data['arr_built_content'] = $arr_built_content;
        $arr_mail_data['user']              = $arr_buyer;
        return $arr_mail_data;
       } 
    }
    return FALSE;
  }//end function built data




    // function for autosuggest list of search by state
     public function autosuggest_by_state(request $request)
    { 

         $category_id = $request->category_id;
         $rating = $request->rating;
         $age_restrictions = $request->age_restrictions;
         $price = $request->price;
         $brands = $request->brands;
         $brand = $request->brand;
         $mg = $request->mg;
         $filterby_price_drop = $request->filterby_price_drop;
         $product_search = $request->product_search;
         $sellers = $request->sellers;
         $city = $request->city;
         $chows_choice = $request->chows_choice;
         $best_seller = $request->best_seller;
         $spectrum = $request->spectrum;
         $statelaw = $request->statelaw;
         $reported_effects = $request->reported_effects;
         $cannabinoids = $request->cannabinoids;

         $featured = $request->featured;

        if($request->query)
        {

            $state_table = $this->StatesModel->getTable();
            $prefix_state_table = DB::getTablePrefix().$state_table;

            $user_table        = $this->UserModel->getTable();
            $prefix_user_table = DB::getTablePrefix().$this->UserModel->getTable();
           

            
            $query = $request['query']; 
            $data = DB::table($prefix_state_table)
                     ->where([['name', 'LIKE', "%{$query}%"],['is_active','1'],['country_id','231']])
                     ->get()->toArray();


            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if(isset($data) && !empty($data)){
                foreach($data as $row)
                {

                     $statename = $row->name;


                      $url = '';
                      if(isset($statename))
                      {
                        $statename = str_replace(' ','-',$statename);
                        $url = url('search?state='.$statename);
                      } 
                      if(isset($category_id)){
                         $url .= '&category_id='.$category_id;
                      }  
                      if(isset($mg)){
                         $url .= '&mg='.$mg;
                      }   
                      if(isset($brand)){
                         $url .= '&brand='.$brand;
                      }             
                      if(isset($sellers)){
                         $url .= '&sellers='.$sellers;
                      }
                      if(isset($brands)){
                         $url .= '&brands='.$brands;
                      }  
                      if(isset($price)){
                         $url .= '&price='.$price;
                      }
                      if(isset($rating)){
                         $url .= '&rating='.$rating;
                      }
                      if(isset($age_restrictions)){
                         $url .= '&age_restrictions='.$age_restrictions;
                      }     
                      if(isset($filterby_price_drop) && $filterby_price_drop=='true'){
                         $url .= '&filterby_price_drop='.$filterby_price_drop;
                      }
                       if(isset($product_search)){
                         $url .= '&product_search='.$product_search;
                      }     
                       if(isset($city)){
                         $url .= '&city='.$city;
                      }   
                       if(isset($spectrum)){
                         $url .= '&spectrum='.$spectrum;
                      }   
                       if(isset($chows_choice) && $chows_choice=='true'){
                         $url .= '&chows_choice='.$chows_choice;
                      }  
                      if(isset($best_seller) && $best_seller=='true'){
                         $url .= '&best_seller='.$best_seller;
                      }                                
                       if(isset($statelaw)){
                         $url .= '&statelaw='.$statelaw;
                      }  

                       if(isset($reported_effects)){
                         $url .= '&reported_effects='.$reported_effects;
                      } 

                       if(isset($cannabinoids)){
                         $url .= '&cannabinoids='.$cannabinoids;
                      } 

                      if(isset($featured))
                      {
                        $url .= '&featured='.$featured;
                      }


                     $output .= '
                      <li class="liclickstate" id='.$row->id.'>
                      <a href="'.$url.'"> '.$row->name.'</a>
                      </li>';
                }
            }else{
              $output .='<li><a href="#">Not Found</a></li>';
            }
            $output .= '</ul>';
            echo $output;
       }
    } // end of function of autosuggest by state



     // function for autosuggest list of search by city
     public function autosuggest_by_city(request $request)
    { 

         $category_id = $request->category_id;
         $rating = $request->rating;
         $age_restrictions = $request->age_restrictions;
         $price = $request->price;
         $brands = $request->brands;
         $brand = $request->brand;
         $mg = $request->mg;
         $filterby_price_drop = $request->filterby_price_drop;
         $product_search = $request->product_search;
         $sellers = $request->sellers;
         $state = $request->state;
         $chows_choice = $request->chows_choice;
         $best_seller = $request->best_seller;
         $spectrum = $request->spectrum;
         $statelaw = $request->statelaw;
         $reported_effects = $request->reported_effects;
         $cannabinoids = $request->cannabinoids;

         $featured = $request->featured;



        if($request->query)
       {

         
            $user_table        = $this->UserModel->getTable();
            $prefix_user_table = DB::getTablePrefix().$this->UserModel->getTable();
           

            
            $query = $request['query']; 
            $data =  DB::table($prefix_user_table)                     
                     ->where($prefix_user_table.'.city', 'LIKE', "%{$query}%")
                     ->where('user_type','seller')
                     ->groupBy('city')               
                     ->get()->toArray();


            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if(isset($data) && !empty($data)){
                foreach($data as $row)
                {

                     $cityname = $row->city;


                      $url = '';
                      if(isset($cityname))
                      {
                        $cityname = str_replace(' ','-',$cityname);
                        $url = url('search?city='.$cityname);
                      } 
                      if(isset($category_id)){
                         $url .= '&category_id='.$category_id;
                      }  
                      if(isset($mg)){
                         $url .= '&mg='.$mg;
                      }   
                      if(isset($brand)){
                         $url .= '&brand='.$brand;
                      }             
                      if(isset($sellers)){
                         $url .= '&sellers='.$sellers;
                      }
                      if(isset($brands)){
                         $url .= '&brands='.$brands;
                      }  
                      if(isset($price)){
                         $url .= '&price='.$price;
                      }
                      if(isset($rating)){
                         $url .= '&rating='.$rating;
                      }
                      if(isset($age_restrictions)){
                         $url .= '&age_restrictions='.$age_restrictions;
                      }     
                      if(isset($filterby_price_drop) && $filterby_price_drop=='true'){
                         $url .= '&filterby_price_drop='.$filterby_price_drop;
                      }
                       if(isset($product_search)){
                         $url .= '&product_search='.$product_search;
                      }  

                      if(isset($state)){
                         $url .= '&state='.$state;
                      }  
                      if(isset($spectrum)){
                         $url .= '&spectrum='.$spectrum;
                      }  
                       if(isset($chows_choice) && $chows_choice=='true'){
                         $url .= '&chows_choice='.$chows_choice;
                      }   
                       if(isset($best_seller) && $best_seller=='true'){
                         $url .= '&best_seller='.$best_seller;
                      }                                 
                       if(isset($statelaw)){
                         $url .= '&statelaw='.$statelaw;
                      }  

                       if(isset($reported_effects)){
                         $url .= '&reported_effects='.$reported_effects;
                      }  

                      if(isset($cannabinoids)){
                         $url .= '&cannabinoids='.$cannabinoids;
                      } 

                      if(isset($featured))
                      {
                        $url .= '&featured='.$featured;
                      }
 


                     $output .= '
                      <li class="liclickcity" id='.$row->id.'>
                      <a href="'.$url.'"> '.$row->city.'</a>
                      </li>';
                }
            }else{
              $output .='<li><a href="#">Not Found</a></li>';
            }
            $output .= '</ul>';
            echo $output;
       }
    } // end of function of autosuggest by city


     public function getCountrymodal(Request $request,$state=NULL)
    {   
            
        $arr_response = [];
        $arr_country = $this->CountriesModel
                        ->where('is_active','1');

        if(isset($arr_country) && !empty($arr_country)) 
        {   
          $arr_country = $arr_country->get()->toArray();
        }               
        $arr_response['arr_country'] = $arr_country;
        
        return response()->json($arr_response);
    }//end function country

    public function get_statesmodal($country_id="")
    {
        if(isset($country_id) && !empty($country_id))
        {
             $states_arr = $this->StatesModel->where('country_id',$country_id)
                                            ->where('is_active','1')
                                            ->get()->toArray();

        }
        else{
             $states_arr = $this->StatesModel->where('is_active','1')
                                            ->get()->toArray();

        }
       
        if(count($states_arr)>0)
        {
            $response['status']     = 'SUCCESS';
            $response['states_arr'] = $states_arr;
        }
        else
        {
            $response['status']     = 'ERROR';
            $response['states_arr'] = [];    
        }
        return response()->json($response);
    }//end function states

    public function process_modal(Request $request)
    {
          $form_data = $request->all();
          $arr_response =[];

            $arr_rules = [
                      
                        'country'      => 'required',
                        'state'      => 'required'
                    ];

            if(Validator::make($form_data,$arr_rules)->fails())
            {   
                $msg = Validator::make($form_data,$arr_rules)->errors()->first();

                $response = [
                               'status' =>'ERROR',
                               'msg'    => $msg
                            ];
                return response()->json($response);     
            }        

            $country  = isset($form_data['country'])?$form_data['country']:'';
            $state    = isset($form_data['state'])?$form_data['state']:'';

             $get_ipdata = IpDataModel::where('ip',$_SERVER['REMOTE_ADDR'])->first();
             if(isset($get_ipdata) && !empty($get_ipdata))
             {
               $arr_response['status'] = 'ERROR';
               $arr_response['msg']    = 'Your ip address is already exists';
               return $arr_response;
             }
             else{
               $arr_ipdata['ip']      = $_SERVER['REMOTE_ADDR'];
               $arr_ipdata['country'] = $country;
               $arr_ipdata['state']   = $state;
                $store_ipdata = $this->IpDataModel->create($arr_ipdata);
                if($store_ipdata)
                {
                    $arr_response['status'] = 'SUCCESS';
                    $arr_response['msg']    = 'You can continue browsing.';
            
                }
                else{
                 $arr_response['status'] = 'ERROR';
                 $arr_response['msg']    = 'Error occured while doing user activation';
                 return $arr_response;
            
                }
             }//else
           
            
           
          
        return $arr_response;
    }//process modal function

    function checkipaddress(Request $request)
    {
        $arr_response =[];

       $myip = $_SERVER['REMOTE_ADDR'];

       $getipdata = $this->IpDataModel->where('ip',$myip)->first();
       if(isset($getipdata) && !empty($getipdata))
       {
         $getipdata = $getipdata->toArray();
         
          $country = $getipdata['country'];
          $state = $getipdata['state'];
          $dbip = $getipdata['ip'];

           $arr_response['status'] = 'SUCCESS';
           $arr_response['msg']    = 'You can continue browsing.';

       }else{
          $arr_response['status'] = 'ERROR';
          $arr_response['msg']    = 'Error occured while doing user activation';
          return $arr_response;
       }

       return $arr_response;
    }//end function checkipaddress


    function gettrackingproduct(Request $request)
    {
      $setarr = $res = $firstcatname = [];
      $firstcatname = $product_title_slug = $urlbrands_name = $sellername = $urlsellername = '';
      $allcategories = $allproducts = [];
      $latestproductname = $latestproductid = $latestproductprice = $latestproductqty = $latesturl = $latestproducturl = $url = '';

      $productid = $request->productid;
      $qty = $request->quantity;

       if(isset($productid) && isset($qty))
       {
            $getprodinfo = $this->ProductModel->with([
                                            'first_level_category_details',
                                            'second_level_category_details',
                                            'inventory_details',
                                            'product_images_details',
                                            'age_restriction_detail',
                                            'get_seller_details.get_country_detail', 
                                            'get_seller_details.get_state_detail', 
                                            'get_seller_additional_details',
                                            'get_brand_detail'
                                            ])->where('id',$productid)->first();

            if(isset($getprodinfo) && !empty($getprodinfo))
            {
                $getprodinfo = $getprodinfo->toArray();

                if(isset($getprodinfo['price_drop_to']) && $getprodinfo['price_drop_to']>0)
                {
                  $price = num_format($getprodinfo['price_drop_to']);
                }else{
                   $price = num_format($getprodinfo['unit_price']);
                }  
                

                 $product_title_slug = str_slug($getprodinfo['product_name']);
                 $setarr['ProductID'] = $getprodinfo['id'];
                 $setarr['ProductName'] = $getprodinfo['product_name'];
                 $setarr['Quantity'] = $qty;
                 $setarr['ItemPrice'] = $qty*$price;
                 $setarr['RowTotal'] = $qty*$price;
                 if(isset($getprodinfo['product_images_details'][0]['image']) && !empty($getprodinfo['product_images_details'][0]['image'])){
                    $url = url('/').'/uploads/product_images/'.$getprodinfo['product_images_details'][0]['image'];
                  }else{
                    $url ='';
                  }
                 $setarr['ImageURL'] = $url;
                 if(isset($getprodinfo['first_level_category_id']))
                 {
                   $firstcatname = get_first_levelcategorydata($getprodinfo['first_level_category_id']);
                 }
                 $setarr['ProductCategories'] = array($firstcatname);

                  $sellername = get_seller_details($getprodinfo['user_id']);
                 if(isset($sellername))
                 {
                  $urlsellername = str_slug($sellername);
                 }
                 $urlbrands_id = isset($getprodinfo['brand'])?$getprodinfo['brand']:'';

                 $urlbrands_name = isset($getprodinfo['brand'])?str_slug(get_brand_name($urlbrands_id)):'';

                 $producturl = url('/').'/search/product_detail/'.base64_encode($getprodinfo['id']).'/'.$product_title_slug.'/'.$urlbrands_name.'/'.$urlsellername;

                 $setarr['ProductURL'] = $producturl;
                

                 $allcategories[] = json_encode($firstcatname);
                 $allproducts[] =  json_encode($getprodinfo['product_name']);
                 
                 $latestproductname = $getprodinfo['product_name'];
                 $latestproductid = $getprodinfo['id'];
                 $latestproductprice = $price;
                 $latestproductqty = $qty;
                 
                  if(isset($getprodinfo['product_images_details'][0]['image']) && !empty($getprodinfo['product_images_details'][0]['image'])){
                    $latesturl = url('/').'/uploads/product_images/'.$getprodinfo['product_images_details'][0]['image'];
                  }else{
                    $latesturl ='';
                  }

                  $latestproducturl = url('/').'/search/product_detail/'.base64_encode($getprodinfo['id']).'/'.$product_title_slug.'/'.$urlbrands_name.'/'.$urlsellername;

                  $res['value'] = $qty*$price;
                  $res['AddedItemProductName'] = $getprodinfo['product_name'];
                  $res['AddedItemProductID'] = $getprodinfo['id'];
                  $res['AddedItemImageURL'] = $latesturl;
                  $res['AddedItemURL'] = $latestproducturl;
                  $res['AddedItemPrice'] = $price;
                  $res['AddedItemQuantity'] = $qty;
                  $res['CheckoutURL'] = url('/').'/checkout';
                  $res['AddedItemCategories'] = $allcategories;
                  $res['ItemNames'] = $allproducts;
                  $res['Brand'] = get_brand_name($urlbrands_id);
                  $res['Price'] = $qty*$price;
                  $res['CompareAtPrice'] = $qty*$getprodinfo['unit_price'];
                  $res['Dispensary'] = isset($sellername)?$sellername:'';
                 $res['items'] = json_encode($setarr);
                 $res['AddedItemCategory'] = isset($getprodinfo['first_level_category_id'])?get_first_levelcategorydata($getprodinfo['first_level_category_id']):'';
                 
                 return $res;

            }
       }//if isset productid
    }//end gettrackingproduct


     public function getCountryId(Request $request)
    {   
        $arr_response = [];
        $country = $request->country;
        if(isset($country) && !empty($country))
        {
            $arr_country = $this->CountriesModel
                        ->select('id')
                        ->where('name',$country)
                        ->where('is_active','1')
                        ->first();

            if(isset($arr_country) && !empty($arr_country)) 
            {   
              $arr_country = $arr_country->toArray();
            }               
            $arr_response['arr_country'] = $arr_country;
            $arr_response['status'] = 'SUCCESS';
            $arr_response['msg']    = 'Country get successfully.';


        }
        else{
          $arr_response['status'] = 'ERROR';
          $arr_response['msg']    = 'Something went wrong.';
       }
            
        return response()->json($arr_response);
    }//end function countryid

     public function getStateId(Request $request)
    {   
        $arr_response = [];
        $state = $request->state;
        if(isset($state) && !empty($state))
        {
            $arr_state = $this->StatesModel
                        ->select('id')
                        ->where('name',$state)
                        ->where('is_active','1')
                        ->first();

            if(isset($arr_state) && !empty($arr_state)) 
            {   
              $arr_state = $arr_state->toArray();
            }               
            $arr_response['arr_state'] = $arr_state;
            $arr_response['status'] = 'SUCCESS';
            $arr_response['msg']    = 'State get successfully.';


        }
        else{
          $arr_response['status'] = 'ERROR';
          $arr_response['msg']    = 'Something went wrong.';
       }
            
        return response()->json($arr_response);
    }//end function state



    // function for getting autosuggest list of search by spectrum 
     public function autosuggestspectrum(request $request)
    { 
           
      
         $sellers = $request->sellers;   
         $rating = $request->rating;
         $category_id = $request->category_id;
         $age_restrictions = $request->age_restrictions;
         $price = $request->price;
         $mg = $request->mg;
         $filterby_price_drop = $request->filterby_price_drop;
         $product_search = $request->product_search;
         $state = $request->state;
         $city = $request->city;
         $chows_choice = $request->chows_choice;
         $best_seller = $request->best_seller;
         $brands = $request->brands;
         $brand = $request->brand;
         $statelaw = $request->statelaw;
         $reported_effects = $request->reported_effects;
         $cannabinoids = $request->cannabinoids;

         $featured = $request->featured;

        if($request->query)
       {

            $spectrum_table        = $this->SpectrumModel->getTable();
            $prefix_spectrum_table = DB::getTablePrefix().$this->SpectrumModel->getTable();

            $query = $request['query']; 
            $data = DB::table($prefix_spectrum_table)
                    ->where('name', 'LIKE', "%{$query}%")
                    ->where('is_active','1')
                    ->get()->toArray();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if(isset($data) && !empty($data)){
                foreach($data as $row)
                {

                      $url = '';
                      if(isset($row->name)){
                      //  $url = url('search?brands='.base64_encode($row->name));
                        $spectrumname = str_replace(' ','-',$row->name);
                        $url = url('search?spectrum='.$spectrumname);
                      } 
                      if(isset($category_id)){
                         $url .= '&category_id='.$category_id;
                      }  
                      if(isset($mg)){
                         $url .= '&mg='.$mg;
                      }             

                       if(isset($brand)){
                         $url .= '&brand='.$brand;
                      }             
                      if(isset($brands)){
                         $url .= '&brands='.$brands;
                      }  


                      if(isset($sellers)){
                         $url .= '&sellers='.$sellers;
                      }
                      if(isset($price)){
                         $url .= '&price='.$price;
                      }
                      if(isset($rating)){
                         $url .= '&rating='.$rating;
                      }
                      if(isset($age_restrictions)){
                         $url .= '&age_restrictions='.$age_restrictions;
                      }                             

                       if(isset($filterby_price_drop) && $filterby_price_drop=='true'){
                         $url .= '&filterby_price_drop='.$filterby_price_drop;
                      }     
                      if(isset($product_search)){
                         $url .= '&product_search='.$product_search;
                      }       
                      if(isset($state)){
                         $url .= '&state='.$state;
                      } 
                       if(isset($city)){
                         $url .= '&city='.$city;
                      } 

                       if(isset($chows_choice) && $chows_choice=='true'){
                         $url .= '&chows_choice='.$chows_choice;
                      } 
                       if(isset($best_seller) && $best_seller=='true'){
                         $url .= '&best_seller='.$best_seller;
                      } 
                        if(isset($statelaw)){
                         $url .= '&statelaw='.$statelaw;
                      } 

                      if(isset($reported_effects))
                      {
                        $url .= '&reported_effects='.$reported_effects;
                      }

                      if(isset($cannabinoids))
                      {
                        $url .= '&cannabinoids='.$cannabinoids;
                      }

                      if(isset($featured))
                      {
                        $url .= '&featured='.$featured;
                      }


                     $output .= '
                      <li class="liclick" id='.$row->id.'>
                      <a href="'.$url.'"> '.$row->name.'</a>
                      </li>';
                }
            }else{
              $output .='<li><a href="#">Not Found</a></li>';
            }
            $output .= '</ul>';
            echo $output;
       }
    } // end of function of autosuggest spectrum
    



      public function getShopBySpectrum(Request $request)
    {   
            
        $arr_response = [];
        $arr_spectrum = get_spectrums();


        if(isset($arr_spectrum) && !empty($arr_spectrum))
        {
            foreach ($arr_spectrum as $key => $value) {
                
                if($value['name']=="Not Applicable")
                {
                    unset($arr_spectrum[$key]);
                }
            }
        }

        $arr_response['arr_spectrum'] = $arr_spectrum;
        
        return response()->json($arr_response);
    }//end shop by spectrum


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

    //this for getting the suggession list
    public function get_suggestion_list(Request $request)
    {
        $output = '';

        $sellers = $request->sellers;   
        $rating = $request->rating;
        $category_id = $request->category_id;
        $age_restrictions = $request->age_restrictions;
        $price = $request->price;
        $mg    = $request->mg;
        $filterby_price_drop = $request->filterby_price_drop;
        //$product_search = $request->product_search;
        $product_search = $request->search_item;

        $state        = $request->state;
        $city         = $request->city;
        $chows_choice = $request->chows_choice;
        $best_seller  = $request->best_seller;
        $spectrum     = $request->spectrum;
        $statelaw     = $request->statelaw;
        $reported_effects = $request->reported_effects;
        $cannabinoids = $request->cannabinoids;
        $brand        = $request->brands;
        $brands       = $request->brands;
        $featured     = $request->featured;

        
        if($request->search_item)
        {

           
                
            $search_input = explode(' ',$product_search);

            if(isset($search_input) && count($search_input)>0)
            {
                foreach($search_input as $key => $search_value)
                {
                    $search = isset($search_input[0])?$search_input[0]:'';
                 
                    $suggession_list = $this->SuggestionListModel
                                        ->select('id','front_suggession_title','suggession_link')
                                        ->where('if_user_search_contains','LIKE','%'.$search.'%')
                                        ->orwhere('if_user_search_contains','LIKE','%'.$search_value.'%')
                                        ->where('is_active','1')
                                        ->get()
                                        ->toArray();


                }
            }



                if(isset($suggession_list) && count($suggession_list)>0)
                {
                    $output = '<ul class="dropdown-menu" style="display:block; position:relative">';


                    foreach($suggession_list as $key => $suggession)
                    { 
                        //$url = '';
/*
                        if(isset($suggession['front_suggession_title']))
                        {
                           //$title = str_replace(' ','-',$suggession['title']); 
                           $url = url('search?product_search='.$suggession['front_suggession_title']);
                        } 

                        if(isset($brand)){
                          $url .= '&brand='.$brand;
                        }             
                        if(isset($brands)){
                          $url .= '&brands='.$brands;
                        } 
                        if(isset($category_id)){
                            $url .= '&category_id='.$category_id;
                        }  
                        if(isset($mg)){
                            $url .= '&mg='.$mg;
                        }             
                        if(isset($sellers)){
                            $url .= '&sellers='.$sellers;
                        }
                        if(isset($price)){
                            $url .= '&price='.$price;
                        }
                        if(isset($rating)){
                            $url .= '&rating='.$rating;
                        }
                        if(isset($age_restrictions)){
                            $url .= '&age_restrictions='.$age_restrictions;
                        }                             

                        if(isset($filterby_price_drop) && $filterby_price_drop=='true'){
                            $url .= '&filterby_price_drop='.$filterby_price_drop;
                        }     
                          
                        if(isset($state)){
                            $url .= '&state='.$state;
                        } 
                        if(isset($city)){
                            $url .= '&city='.$city;
                        } 

                        if(isset($spectrum)){
                            $url .= '&spectrum='.$spectrum;
                        } 

                        if(isset($statelaw)){
                            $url .= '&statelaw='.$statelaw;
                        } 

                        if(isset($chows_choice) && $chows_choice=='true'){
                            $url .= '&chows_choice='.$chows_choice;
                        } 
                        if(isset($best_seller) && $best_seller=='true'){
                            $url .= '&best_seller='.$best_seller;
                        } 

                        if(isset($reported_effects)){
                            $url .= '&reported_effects='.$reported_effects;
                        } 

                        if(isset($featured))
                        {
                            $url.= '&featured='.$featured;
                        }*/

                        $output .= '
                              <li class="liclick" id='.$suggession['id'].' title='.$suggession['front_suggession_title'].'>
                              <a href="'.$suggession['suggession_link'].'"> '.$suggession['front_suggession_title'].'</a>
                              </li>';

                    }

                  $output .= '</ul>';
                }
                /*else
                {
                    $output .='<li>Not Found</li>';
                }*/

                
                 
             return response()->json($output);  

        } 

    } //get_suggestion_list

    function insert_suggestion_list(Request $request)
    {
        $search_item = $request->search_item;   

        if(isset($search_item))
        {   
            $get_record_exists = $this->SuggestionListModel->where('title',$search_item)->get()->toArray();
            if(isset($get_record_exists) && !empty($get_record_exists))
            {
            }else
            {
                $arr                =[];
                $arr['title']       = $search_item;
                $arr['user_search'] = 1;
                $arr['is_active']   = '1';
                $id = $this->SuggestionListModel->create($arr);
            }
          
            
        }//isset search_item

    }//insert_suggestion_list


    public function show_all_review_list(Request $request,$productid)
    { 
            $user_id     = 0;
          $product_purchased_by_user= $is_review_added = ""; 
           $apppend_data = url()->current();

            $id = base64_decode($productid);
            $user = Sentinel::check();
            if($user!=false)
            {
                $user_id          = $user->id;
               
            }

            


          if($id)
          {
           

             $arr_product = [];
             $obj_product  = $this->ReviewRatingsModel
                              ->with([
                                'buyer_details',
                                'user_details',
                               ]) 
                              ->where('product_id',$id)
                              ->orderBy('created_at','desc')
                              ->get();               
                              

            if($obj_product)
            {
                $arr_product = $obj_product->toArray();
            }
            
            if($request->has('page'))
            {   
                $pageStart = $request->input('page'); 
            }
            else
            {
                $pageStart = 1; 
            }
            $total_results = count($arr_product);

         $get_reported_effects = $this->ReportedEffectsModel->where('is_active','1')->get(); 
         if(isset($get_reported_effects) && !empty($get_reported_effects))
         {
           $get_reported_effects = $get_reported_effects->toArray();
         }  


            $is_review_added  = $this->ReviewRatingsModel->where('product_id',$id)->where('buyer_id',$user_id)->count();



            $order_ids   = $this->OrderModel->where('buyer_id',$user_id)->where('order_status','1')->select('id')->get()->toArray();
            if(isset($order_ids) && count($order_ids)>0)
            {    
                $product_ids    =  $this->OrderProductModel->whereIn('order_id',$order_ids)->select('product_id')->groupBy('product_id')->get()->toArray();
                $products       =   array_column($product_ids, 'product_id');

                if(in_array($id, $products))
                {
                   $product_purchased_by_user =1; 
                }
                else
                {
                   $product_purchased_by_user =0;  
                }
            }//



            /* check money back request send or not*/
              $request_status = '';

              $request_status = $this->MoneyBackModel->where('product_id',$id)
                                     ->where('buyer_id',$user_id)
                                     ->pluck('status')
                                     ->first();
            /*----------------------------------------------*/


            $paginator = $this->GeneralService->get_pagination_data($arr_product, $pageStart, 5 , $apppend_data);
            if($paginator)
            {
                $pagination_links    =  $paginator;  
                $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 

            }   



            $this->arr_view_data['request_status']        = $request_status;

           $this->arr_view_data['product_purchased_by_user']  = $product_purchased_by_user;

           $this->arr_view_data['is_review_added']  = $is_review_added;
           $this->arr_view_data['show_reported_effects'] = isset($get_reported_effects)?$get_reported_effects:[]; 

           
            $this->arr_view_data['productid']        = $id;   
            $this->arr_view_data['page_title']  = 'Reviews';

            if($paginator)
           {
                $arr_user_pagination            =  $paginator;  
                $arr_product                    =  $paginator->items();
                $arr_view_data['total_results'] = $total_results;
                $arr_pagination = $paginator;            
                $this->arr_view_data['arr_pagination'] = $arr_pagination;
                $this->arr_view_data['total_results'] = $total_results;
                 $this->arr_view_data['arr_product']['review_details']   = isset($arr_product)?$arr_product:[];
          }

            return view($this->module_view_folder.'.show_all_review_list',$this->arr_view_data);

          }//if id
    }//show_all_review_list

    public function add_review_form($productid)
    {
          $product_purchased_by_user= $is_review_added = ""; 
          $order_ids = array();

            $id = base64_decode($productid);

            $user = Sentinel::check();
            if($user!=false)
            {
                $user_id          = $user->id;
               
            }

           $get_reported_effects = $this->ReportedEffectsModel->where('is_active','1')->get(); 
           if(isset($get_reported_effects) && !empty($get_reported_effects))
           {
              $get_reported_effects = $get_reported_effects->toArray();
           }  


           $is_review_added  = $this->ReviewRatingsModel->where('product_id',$id)->where('buyer_id',$user_id)->count();




            $order_ids   = $this->OrderModel->where('buyer_id',$user_id)->where('order_status','1')->select('id')->get()->toArray();
            if(isset($order_ids) && count($order_ids)>0)
            {    
                $product_ids    =  $this->OrderProductModel->whereIn('order_id',$order_ids)->select('product_id')->groupBy('product_id')->get()->toArray();
                $products       =   array_column($product_ids, 'product_id');

                if(in_array($id, $products))
                {
                   $product_purchased_by_user =1; 
                }
                else
                {
                   $product_purchased_by_user =0;  
                }
            }


            $this->arr_view_data['is_review_added']  = $is_review_added;
            $this->arr_view_data['product_purchased_by_user']  = $product_purchased_by_user;


            $this->arr_view_data['show_reported_effects'] = isset($get_reported_effects)?$get_reported_effects:[]; 

            $this->arr_view_data['arr_product']['review_details']   = isset($arr_product)?$arr_product:[];
            $this->arr_view_data['productid']        = $id;   
            $this->arr_view_data['page_title']  = 'Reviews';

            return view($this->module_view_folder.'.add_review',$this->arr_view_data);

        

    }//end add_review

    public function get_similar_products($first_level_category_id,$productid)
    {
        $arr_similar_product = [];

        $first_level_category_id = isset($first_level_category_id)?$first_level_category_id:'';
        
        if(isset($first_level_category_id) && isset($productid))
        {

            $arr_similar_product  = $this->ProductModel
                                      ->with('product_images_details',
                                             'age_restriction_detail',
                                             'get_brand_detail',
                                             'get_seller_details.get_country_detail', 
                                             'get_seller_details.get_state_detail',
                                             'get_seller_additional_details',
                                             'inventory_details'
                                            )
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
                                      ->where('first_level_category_id',$first_level_category_id)
                                      ->where('id','!=',$productid)
                                       ->where([['is_active',1],['is_approve',1]])
                                      ->inRandomOrder()
                                      ->limit('20');

                                     /*if(isset($state_user_ids) && !empty($state_user_ids))
                                     {
                                       $arr_similar_product = $arr_similar_product->whereIn('user_id',$state_user_ids);
                                     }  
                                     if(isset($catdata) && !empty($catdata))
                                     {
                                      $arr_similar_product = $arr_similar_product->whereNotIn('first_level_category_id',$catdata);
                                     }*/   


                                    /* if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids))
                                     {
                                      $arr_similar_product = $arr_similar_product
                                         ->whereIn('user_id',$restricted_state_user_ids);
                                     }  */

                                 $arr_similar_product = $arr_similar_product->get()->toArray();  
         }

         $this->arr_view_data['arr_similar_product'] = isset($arr_similar_product)?$arr_similar_product:[];
         return view($this->module_view_folder.'.similar_products',$this->arr_view_data);


    }//end similar product


    public function commented_code_shop_filters()
    {
           /***************spectrum search*start*************************************/
        // if search in the header then this code is used for spectrum filter

          /*
        if(empty($arr_product) && isset($search_request['product_search']))
        {   
            $spectrum = '';

            $product_search = $search_request['product_search']; 
              if($product_search!="") 
               {    

                    $spectrum_name = $search_request['product_search'];  
          
                    if(isset($spectrum_name) && !empty($spectrum_name))
                    {
                        $get_spectrum = $this->SpectrumModel->where('name','LIKE','%'.$spectrum_name.'%')->get();

                        if(isset($get_spectrum) && (!empty($get_spectrum)))
                        {
                            $get_spectrum = $get_spectrum->toArray();

                            if(!empty($get_spectrum)){
                                $spectrum = $get_spectrum[0]['id'];

                              
                               $this->arr_view_data['category_details']   = isset($get_spectrum)?$get_spectrum:[];

                                    
                            }
                            else{
                                $spectrum = '';
                            }//else
                        }//if    
                         
                    }//if spectrum_name
 

                  

                   $obj_product = $this->ProductModel->with([
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
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_seller_details', function ($q) {
                                                $q->where('is_active', '1');
                                            })


                                            ->where([['is_active',1],['is_approve',1]])
                                            ->where('spectrum','=',$spectrum)
                                            ->inRandomOrder();



                                     if(isset($search_request['best_seller'])) 
                                    {             
                                      $productids = $avgproductids = [];

                                      $prodmodel           = $this->ProductModel->getTable();
                                      $prefix_productable  = DB::getTablePrefix().$this->ProductModel->getTable();

                                      $order_table         = $this->OrderModel->getTable();
                                      $prefix_order_detail = DB::getTablePrefix().$this->OrderModel->getTable();

                                      $order_product_table  = $this->OrderProductModel->getTable();
                                      $prefix_order_product = DB::getTablePrefix().$this->OrderProductModel->getTable();

                                      $reviewmodel         = $this->ReviewRatingsModel->getTable();
                                      $prefix_reviewtable  = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();

                                      $arr_trending_productids =  DB::table($prefix_order_detail)->select(DB::raw(
                                                                    $prefix_order_product.'.product_id,count('.$prefix_order_product.'.product_id) as mostsold'
                                          ))
                                      ->leftJoin($prefix_order_product,$prefix_order_product.'.order_id','=',$prefix_order_detail.'.id')    
                                      ->where($prefix_order_detail.'.order_status','1')  
                                      ->groupBy($prefix_order_product.'.product_id')
                                      ->orderBy('mostsold','desc')
                                      //->limit(50)
                                     //->toSql();                    
                                      ->get()->toArray(); 


                                    if(isset($arr_trending_productids) &&!empty($arr_trending_productids))
                                    {  
                                         $productidssold   = array_column($arr_trending_productids, 'product_id');
                                         $mostsold         = array_unique(array_column($arr_trending_productids, 'mostsold'));
                                         $arr = []; $mostsolded ='';
                                         foreach($mostsold as $v)
                                         {
                                            $arr[] = $v;
                                         }
                                         
                                         $mostsolded = implode(",", $arr);

                                    }//if isset arr_mostsold_productids
                          
                                  if(isset($arr_trending_productids) && !empty($arr_trending_productids) && isset($mostsolded) &&  !empty($mostsolded))
                                  {
                                      $productids   = array_column($arr_trending_productids, 'product_id');

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
                                        
                                            ->whereIn('id',$productids)    
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->get();

                         
                                        if(isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data))
                                        {
                                            $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
                                            $avgproductids   = array_column($arr_eloq_trending_data, 'id');
                                            $obj_product->whereIn('id',$avgproductids);
                                        }                                    

                                      }//if not empty r_trending_productids                        
                                    
                                       $best_seller = $search_request['best_seller'];            
                                       $apppend_data['best_seller'] = $best_seller;
                                     }// end of best seller          


                                      if (isset($search_request['chows_choice'])) 
                                    {             
                                        
                                        $chows_choice = $search_request['chows_choice']; 
                                        $obj_product->where('is_chows_choice','=','1');
                                        $apppend_data['chows_choice'] = $chows_choice;
                                    }// end of seller          


                                   
                                    if (isset($search_request['age_restrictions'])) 
                                    {
                                        $age_restrictions = base64_decode($search_request['age_restrictions']); 
                                        $obj_product->where('age_restriction',$age_restrictions);
                                        $obj_product->where('is_age_limit',1);
                                        $apppend_data['age_restrictions'] = base64_encode($age_restrictions);
                                    }// end of age restriction
                                 
                                     if (isset($search_request['mg'])) 
                                    {
                                       
                                        $mg = explode('-',$search_request['mg']); 
                                        $min_mg = $mg[0];
                                        $max_mg = $mg[1];
                                        $obj_product->whereBetween('per_product_quantity', array($min_mg, $max_mg));
                                        $apppend_data['mg'] = $min_mg.'-'.$max_mg;
                                     
                                    }// end of search by mg
                                     if(isset($search_request['category_id'])) 
                                    {
                                        $categories = $search_request['category_id'];  
                                        $category_name = str_replace('-and-','-&-',$search_request['category_id']);             
                                        $category_name = str_replace('-',' ',$category_name); 

                                        if($category_name)
                                        {

                                            $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','=',$category_name)->get()->toArray();

                                            if(empty($getcategory_id))
                                            {
                                              $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','like',$category_name.'%')->get()->toArray();

                                            }

                                            if(!empty($getcategory_id) && isset($getcategory_id))
                                            {
                                               $categoryid = isset($getcategory_id[0]['id'])?$getcategory_id[0]['id']:''; 
                                                if(isset($categoryid)){
                                                 $obj_product->where('first_level_category_id',$categoryid);
                                               }
                                            }else{
                                               $obj_product->where('first_level_category_id','');
                                            }

                                        }   

                                        
                                        $apppend_data['category_id'] = $categories; 


                                     }  
                                     if (isset($search_request['rating']))  
                                    {

                                        $rating = base64_decode($search_request['rating']); 
                                        if(isset($rating)){
                                            $res_productratings = $this->get_buyer_admin_rating_arr($rating);
                                        }
                                               
                                        if(!empty($res_productratings))
                                        {
                                           $product_id_arr =  $res_productratings;
                                           $obj_product->whereIn('id',$product_id_arr);
                                                                   
                                        }
                                        else
                                        {
                                           $product_id_arr =  $res_productratings;
                                         
                                           $obj_product->whereIn('id',$product_id_arr);
                                        }


                                        $apppend_data['rating'] = base64_encode($rating);

                                    }// end of rating
                                     if (isset($search_request['filterby_price_drop'])) 
                                    {             
                                        
                                        $filterby_price_drop = $search_request['filterby_price_drop']; 
                                        $obj_product->where('price_drop_to','>','0');
                                        $apppend_data['filterby_price_drop'] = $filterby_price_drop;
                                    }// end of seller  
                                    // end of search by sellers                    
                                 
                                    if (isset($search_request['sellers'])) 
                                    {
                                        $sellers = $search_request['sellers']; 
                                        $res_sellerinfo = $this->get_seller_business_arr($sellers);

                                         if(!empty($res_sellerinfo) && isset($res_sellerinfo)){ 
                                            $seller_id = $res_sellerinfo['user_id'];
                                            $obj_product->where('user_id',$seller_id);
                                         }else{
                                             $obj_product->where('user_id','');
                                         }

                                        if(!empty($res_sellerinfo) && isset($res_sellerinfo)){  
                                            $seller_id = $res_sellerinfo['user_id'];
                                            $arr_seller_banner = [];
                                            $obj_seller_banner = $this->SellerBannerImageModel->where('seller_id',$seller_id)->first();
                                            if($obj_seller_banner)
                                            {
                                                $arr_seller_banner = $obj_seller_banner->toArray();
                                            }
                                            $apppend_data['sellers'] = $sellers;     
                                         }

                                        $seller_business_name = isset($res_sellerinfo['business_name'])?$res_sellerinfo['business_name']:'';
                                        $this->arr_view_data['page_title']  = $seller_business_name;         
                                    }//if sellers
                                     if(isset($search_request['state']) && !isset($search_request['city']))
                                    {

                                          $state = $search_request['state']; 
                                          $state = str_replace('-',' ',$search_request['state']); 

                                          $getstateid = $this->StatesModel->select('id')->where('name',$state)->first();
                                          if(isset($getstateid))
                                          {
                                            $getstateid = $getstateid->toArray();

                                            $getusers_ofstate = $this->UserModel->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                                             if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                                             {
                                                $getusers_ofstate = $getusers_ofstate->toArray();
                                                  $state_user_ids =  array_values($getusers_ofstate);//get user ids from array
                                                  $obj_product->whereIn('user_id',$state_user_ids);

                                                    $category_ids='';
                                                    $get_categoryids = $this->StatesModel->where('name',$state)->first();
                                                    if(isset($get_categoryids) && !empty($get_categoryids))
                                                    {
                                                        $get_categoryids = $get_categoryids->toArray();
                                                        $category_ids = $get_categoryids['category_ids'];
                                                    }


                                                    if(isset($category_ids) && !empty($category_ids)) 
                                                    {   
                                                        $catdata =[];
                                                        $category_ids = explode(",",$category_ids);
                                                         foreach ($category_ids as $ids) {
                                                            $catdata[] = $ids;
                                                         $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                        }                          
                                                    }      


                                             }//if getusersofstate

                                          }//if getstateid

                                          $apppend_data['state'] = $state;
                                          
                                    } // if state

                                  if(isset($search_request['state']) && isset($search_request['city']))
                                    {
                                       
                                      $checkuserids =[];
                                      $state = $search_request['state']; 
                                      $statename = str_replace('-',' ',$search_request['state']); 

                                      $getstateid = $this->StatesModel->select('id')->where('name',$statename)->first();
                                      if(isset($getstateid))
                                      {
                                        $getstateid = $getstateid->toArray();

                                        $getusers_ofstate = $this->UserModel->select('id')->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                                         if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                                         {
                                              $getusers_ofstate = $getusers_ofstate->toArray();
                                              $state_user_ids =  array_values($getusers_ofstate);//get user ids from array
                                               if(isset($search_request['city']))
                                                {
                                                   $city = $search_request['city']; 
                                                   $cityname = str_replace('-',' ',$search_request['city']); 

                                                   $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->whereIn('id',$state_user_ids)->get();
                                                    if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                                    {
                                                            $getusers_ofcity = $getusers_ofcity->toArray();
                                                            $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                                    }//if getusersofcity

                                                    $apppend_data['city'] = $city;
                                                    $this->arr_view_data['page_title']  = $city;
                                                      
                                                } // if city                                           
                                             $obj_product->whereIn('user_id',$city_user_ids);

                                                    $category_ids='';
                                                    $get_categoryids = $this->StatesModel->where('name',$statename)->first();
                                                    if(isset($get_categoryids) && !empty($get_categoryids))
                                                    {
                                                        $get_categoryids = $get_categoryids->toArray();
                                                        $category_ids = $get_categoryids['category_ids'];
                                                    }

                                                    if(isset($category_ids) && !empty($category_ids)) 
                                                    {   
                                                        $catdata =[];
                                                        $category_ids = explode(",",$category_ids);
                                                         foreach ($category_ids as $ids) {
                                                            $catdata[] = $ids;
                                                        
                                                         $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                        }                          
                                                    }      

                                         }//if getusersofstate

                                      }//if getstateid

                                      $apppend_data['state'] = $state;

                                } // if state and city

                                if(isset($search_request['city']) && !isset($search_request['state']))
                                 {
                                          $city = $search_request['city']; 
                                          $cityname = str_replace('-',' ',$search_request['city']); 

                                          $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->get();
                                             if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                             {
                                                $getusers_ofcity = $getusers_ofcity->toArray();
                                                $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                                  $obj_product->whereIn('user_id',$city_user_ids);
                                             }//if getusersofstate

                                         $apppend_data['city'] = $city;
                                         $this->arr_view_data['page_title']  = $city;                                      
                                  } // if city


                                   if (isset($search_request['spectrum'])) 
                                    {
                                         $spectrum = $search_request['spectrum'];  
                                         $spectrumname = str_replace('-',' ',$search_request['spectrum']);  
                                       
                                        if($spectrumname)
                                        {

                                            $getspectrum_id = $this->SpectrumModel->where('name','=',$spectrumname)->first();

                                            if(!empty($getspectrum_id) && isset($getspectrum_id))
                                            {
                                                $getspectrum_id = $getspectrum_id->toArray();

                                               $specid = isset($getspectrum_id['id'])?$getspectrum_id['id']:''; 
                                                if(isset($specid)){
                                                 $obj_product->where('spectrum',$specid);
                                               }
                                            }else{
                                               $obj_product->where('spectrum','');
                                            }
                                        }
                                        $apppend_data['spectrum'] = $spectrum;

                                    }// end of search by spectrum

                                 

                                      if (isset($search_request['statelaw'])) 
                                    {
                                         $statelaw = $search_request['statelaw'];  
                                       
                                        if(isset($statelaw) && $statelaw=="Allowed")
                                        {   

                                                if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {

                                                   //buyer restricted and state and category there
                                                  $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                  $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                                                    && empty($catdata))
                                               {
                                                    //buyer restricted but state there not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                                               {
                                                   //empty
                                                 //buyer restricted but category there not state
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                    
                                                  $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }

                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                                               {
                                                   //empty
                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                  // $obj_product->whereNotIn('first_level_category_id',$catdata);

                                               }


                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                   //buyer not restricted but category there and state
                                                    $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                    $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }
                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                 //buyer not restricted but category there and not state   
                                                 $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }
                                                                 
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                   //buyer state is not restricted but  seller for his state not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                               }

                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                   //buyer state is not restricted not seller for his state not category
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                   $obj_product->whereNotIn('first_level_category_id',$catdata);

                                               }
                                              
                                              
                                           
                                        }
                                         elseif(isset($statelaw) && $statelaw=="Restricted")
                                        {   

                                                if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                  //buyer restricted and state and category there 
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                  $obj_product->whereIn('first_level_category_id',$catdata);
                                               
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                                                    && empty($catdata))
                                               {
                                                   //buyer restricted and state not category 
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                               }

                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata)
                                                    && empty($allowed_state_sellers))
                                               {
                                                   //buyer restricted and category not state
                                                    $obj_product->whereIn('first_level_category_id',$catdata);
                                                     $obj_product->whereNotIn('user_id',$allowed_state_sellers); //new
                                               }
                                                 elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                                               {

                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                               }
                                             

                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                 //buyer not restricted but category and state    
                                                 $obj_product->whereIn('first_level_category_id',$catdata);
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                 //buyer not restricted but state there not category    
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                                               {
                                                 //buyer not restricted but category there not state    
                                                  $obj_product->whereIn('first_level_category_id',$catdata);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers)&& empty($catdata))
                                               {

                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                   $obj_product->whereIn('first_level_category_id',$catdata);

                                               }
                                                                  
                                             
                                           
                                        }
                                        $apppend_data['statelaw'] = $statelaw;

                                    }// end of search by statelaw
                                        
                                 

                                     if(isset($search_request['reported_effects'])) 
                                    {
                                         $reported_effects = $search_request['reported_effects'];  

                                         if(isset($reported_effects))
                                         {
                                            $effects = explode('-',$search_request['reported_effects']);  
                                            $effects = array_filter($effects);

                                            if(isset($effects))
                                           {

                                               $get_effects = $this->ReviewRatingsModel->select('product_id','emoji')->where('emoji','!=','')->get();
                                               if(isset($get_effects) && !empty($get_effects))
                                              {
                                                  $get_effects = $get_effects->toArray();
                                                

                                                   $allemojiarr = $productids = [];
                                                
                                                    foreach($get_effects as $kk=>$vv)
                                                    {
                                                       $pid = $vv['product_id']; 
                                                       $allemoji =  explode(",",$vv['emoji']);
                                                       if(isset($allemoji) && !empty($allemoji)){
                                                      
                                                         foreach($allemoji as $k1=>$v1)
                                                         {
                                                            $effecttitle='';
                                                            $get_reported_effects = get_effect_name($v1);
                                                            if(isset($get_reported_effects) && !empty($get_reported_effects))
                                                            {    
                                                                $effecttitle = $get_reported_effects['title'];

                                                            }
                                                            foreach($effects as $mm)
                                                            {
                                                                
                                                                $mm = str_replace("_", " ", $mm); 
                                                               
                                                                if($mm==$effecttitle)
                                                                {

                                                                   $productids[] =  $pid;

                                                                }
                                                                $allemojiarr[] = $effecttitle;
                                                            }//foreach
                                                          }//foreach


                                                      }//isset all emoji

                                                    }//foreach get_effects
                                                      
                                              }//if isset get effects
                                             

                                             if(isset($productids))
                                             {
                                                  $obj_product->whereIn('id',$productids);
                                             } 
                                           }//if isset effects

                                         } // if isset reported_effects
                                     
                                        
                                        $apppend_data['reported_effects'] = $reported_effects;

                                    }// end of search by reported_effects




                                    if (isset($search_request['cannabinoids'])) 
                                    {
                                        $reported_effects = $search_request['cannabinoids'];  

                                        if(isset($reported_effects))
                                        {
                                            $cannabinoids = explode('-',$search_request['cannabinoids']);  
                                            $cannabinoids = array_filter($cannabinoids);


                                            if(isset($cannabinoids))
                                            {
                                                $cannabinoids_name = isset($cannabinoids[0]) ? $cannabinoids[0] : "";
                                                $arr_cannabinoids = DB::table($prefix_ProductCannabinoidsModel)
                                                            ->select(DB::raw($prefix_ProductCannabinoidsModel.'.product_id,'
                                                                            .$prefix_CannabinoidsModel.'.name'
                                                            ))

                                                            ->leftJoin($prefix_CannabinoidsModel,$prefix_CannabinoidsModel.'.id','=',$prefix_ProductCannabinoidsModel.'.cannabinoids_id')    
                                                            ->where($prefix_CannabinoidsModel.'.name','like','%'.$cannabinoids_name.'%') 
                                                            ->where($prefix_ProductCannabinoidsModel.'.percent','!=',0)
                                                            ->get();
                                                if(isset($arr_cannabinoids) && !empty($arr_cannabinoids))
                                                {
                                                    $get_cannabinoids = $arr_cannabinoids->toArray();        
                                                    $allcannabinoidarr = $productids_can = [];
                                                    foreach($get_cannabinoids as $kk=>$vv)
                                                    {                              
                                                        $pid = $vv->product_id; 
                                                        $productids_can[] =  $pid;                         

                                                    }//foreach cannobinoids                              
                                                }//if isset get cannobinoids


                                                if(isset($productids_can))
                                                {
                                                    $obj_product->whereIn('id',$productids_can);
                                                } 
                                            }//if isset cannabinoids

                                        } // if isset cannabinoids
                                        $apppend_data['cannabinoids'] = $reported_effects;
                                    }// end of search by cannabinoids


                                  $result = $price_product_ids = $productids_unitpricearr = $productids_pricdroparr = [];
                                 
                                  if(isset($search_request['price'])) 
                                 {

                                    $price_range = explode('-',$search_request['price']);
                                    $min_price = isset($price_range[0])?$price_range[0]:'';
                                    $max_price = isset($price_range[1])?$price_range[1]:'';

                                    $get_unit_price_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                                                    ->where('price_drop_to','=','') 
                                                    ->whereBetween('unit_price', array($min_price, $max_price))
                                                    ->get();

                                    if(isset($get_unit_price_arr) && !empty($get_unit_price_arr))
                                    {
                                         $get_unit_price_arr = $get_unit_price_arr->toArray();
                                         $productids_unitpricearr   = array_column($get_unit_price_arr, 'id');
                                       
                                    }// if productids_unitpricearr

                                    $get_price_drop_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                                                    ->whereBetween('price_drop_to', array($min_price, $max_price))
                                                    ->get();

                                    if(isset($get_price_drop_arr) && !empty($get_price_drop_arr))
                                    {
                                         $get_price_drop_arr = $get_price_drop_arr->toArray();
                                         $productids_pricdroparr   = array_column($get_price_drop_arr, 'id');
                                         //dd($productids_pricdroparr);
                                    }//if get_price_drop_arr

                                    if(isset($productids_unitpricearr) && isset($productids_pricdroparr)){
                                         $result = array_merge($productids_unitpricearr,$productids_pricdroparr);       
                                         $price_product_ids= array_unique($result);
                                         $obj_product->whereIn('id',$price_product_ids);
                                    }
                                    
                                      $apppend_data['price'] = $min_price.'-'.$max_price;
                                 
                                  }//if isset price filter  


                                 $obj_product = $obj_product->get();

                                 if (isset($obj_product) && $obj_product != null ) 
                                 {
                                     $arr_product = $obj_product->toArray();
                                       
                                } // if category search filter is set
                 
                    
               }// if product search not empty for spectrum filter
        }// if arr_product is empty and search filter is empty then use this for spectrum

        */
        /*****************spectrum*filter*header search end***************************/    


          /***************category search*start*************************************/
        // if search in the header then this code is used for category filter
       /* if(empty($arr_product) && isset($search_request['product_search']))
        {   
            $category = '';

            $product_search = $search_request['product_search']; 
              if($product_search!="") 
               {    

                    $cat_name = $search_request['product_search'];  
          
                    if(isset($cat_name) && !empty($cat_name))
                    {
                        $get_category = $this->FirstLevelCategoryModel->where('product_type','LIKE','%'.$cat_name.'%')->get();

                        if(isset($get_category) && (!empty($get_category)))
                        {
                            $get_category = $get_category->toArray();

                            if(!empty($get_category)){
                                $category = $get_category[0]['id'];

                              
                               $this->arr_view_data['category_details']   = isset($get_category)?$get_category:[];

                                    
                            }
                            else{
                                $category = '';
                            }//else
                        }//if    
                         
                    }//if categorysearch
 

                  

                   $obj_product = $this->ProductModel->with([
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
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_seller_details', function ($q) {
                                                $q->where('is_active', '1');
                                            })


                                            ->where([['is_active',1],['is_approve',1]])
                                            ->where('first_level_category_id','=',$category)
                                            ->inRandomOrder();



                                     if(isset($search_request['best_seller'])) 
                                    {             
                                      $productids = $avgproductids = [];

                                      $prodmodel           = $this->ProductModel->getTable();
                                      $prefix_productable  = DB::getTablePrefix().$this->ProductModel->getTable();

                                      $order_table         = $this->OrderModel->getTable();
                                      $prefix_order_detail = DB::getTablePrefix().$this->OrderModel->getTable();

                                      $order_product_table  = $this->OrderProductModel->getTable();
                                      $prefix_order_product = DB::getTablePrefix().$this->OrderProductModel->getTable();

                                      $reviewmodel         = $this->ReviewRatingsModel->getTable();
                                      $prefix_reviewtable  = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();

                                      $arr_trending_productids =  DB::table($prefix_order_detail)->select(DB::raw(
                                                                    $prefix_order_product.'.product_id,count('.$prefix_order_product.'.product_id) as mostsold'
                                          ))
                                      ->leftJoin($prefix_order_product,$prefix_order_product.'.order_id','=',$prefix_order_detail.'.id')    
                                      ->where($prefix_order_detail.'.order_status','1')  
                                      ->groupBy($prefix_order_product.'.product_id')
                                      ->orderBy('mostsold','desc')
                                      ->get()->toArray(); 


                                    if(isset($arr_trending_productids) &&!empty($arr_trending_productids))
                                    {  
                                         $productidssold   = array_column($arr_trending_productids, 'product_id');
                                         $mostsold         = array_unique(array_column($arr_trending_productids, 'mostsold'));
                                         $arr = []; $mostsolded ='';
                                         foreach($mostsold as $v)
                                         {
                                            $arr[] = $v;
                                         }
                                         
                                         $mostsolded = implode(",", $arr);

                                    }//if isset arr_mostsold_productids
                          
                                  if(isset($arr_trending_productids) && !empty($arr_trending_productids) && isset($mostsolded) &&  !empty($mostsolded))
                                  {
                                      $productids   = array_column($arr_trending_productids, 'product_id');

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
                                        
                                            ->whereIn('id',$productids)    
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->get();

                         
                                        if(isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data))
                                        {
                                            $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
                                            $avgproductids   = array_column($arr_eloq_trending_data, 'id');
                                            $obj_product->whereIn('id',$avgproductids);
                                        }                                    

                                      }//if not empty r_trending_productids                        
                                    
                                       $best_seller = $search_request['best_seller'];            
                                       $apppend_data['best_seller'] = $best_seller;
                                     }// end of best seller          


                                      if (isset($search_request['chows_choice'])) 
                                    {             
                                        
                                        $chows_choice = $search_request['chows_choice']; 
                                        $obj_product->where('is_chows_choice','=','1');
                                        $apppend_data['chows_choice'] = $chows_choice;
                                    }// end of seller          


                                   
                                    if (isset($search_request['age_restrictions'])) 
                                    {
                                        $age_restrictions = base64_decode($search_request['age_restrictions']); 
                                        $obj_product->where('age_restriction',$age_restrictions);
                                        $obj_product->where('is_age_limit',1);
                                        $apppend_data['age_restrictions'] = base64_encode($age_restrictions);
                                    }// end of age restriction
                                 
                                     if (isset($search_request['mg'])) 
                                    {
                                       
                                        $mg = explode('-',$search_request['mg']); 
                                        $min_mg = $mg[0];
                                        $max_mg = $mg[1];
                                        $obj_product->whereBetween('per_product_quantity', array($min_mg, $max_mg));
                                        $apppend_data['mg'] = $min_mg.'-'.$max_mg;
                                     
                                    }// end of search by mg
                                     if(isset($search_request['category_id'])) 
                                    {
                                        $categories = $search_request['category_id'];  
                                        $category_name = str_replace('-and-','-&-',$search_request['category_id']);             
                                        $category_name = str_replace('-',' ',$category_name); 

                                        if($category_name)
                                        {

                                            $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','=',$category_name)->get()->toArray();

                                            if(empty($getcategory_id))
                                            {
                                              $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','like',$category_name.'%')->get()->toArray();

                                            }

                                            if(!empty($getcategory_id) && isset($getcategory_id))
                                            {
                                               $categoryid = isset($getcategory_id[0]['id'])?$getcategory_id[0]['id']:''; 
                                                if(isset($categoryid)){
                                                 $obj_product->where('first_level_category_id',$categoryid);
                                               }
                                            }else{
                                               $obj_product->where('first_level_category_id','');
                                            }

                                        }   

                                        
                                        $apppend_data['category_id'] = $categories; 


                                     }  
                                     if (isset($search_request['rating']))  
                                    {

                                        $rating = base64_decode($search_request['rating']); 
                                        if(isset($rating)){
                                            $res_productratings = $this->get_buyer_admin_rating_arr($rating);
                                        }
                                               
                                        if(!empty($res_productratings))
                                        {
                                          
                                           $product_id_arr =  $res_productratings;
                                           $obj_product->whereIn('id',$product_id_arr);
                                                                   
                                        }
                                        else
                                        {
                                           $product_id_arr =  $res_productratings;
                                         
                                           $obj_product->whereIn('id',$product_id_arr);
                                        }



                                        $apppend_data['rating'] = base64_encode($rating);
                                    }// end of rating
                                     if (isset($search_request['filterby_price_drop'])) 
                                    {             
                                        
                                        $filterby_price_drop = $search_request['filterby_price_drop']; 
                                        $obj_product->where('price_drop_to','>','0');
                                        $apppend_data['filterby_price_drop'] = $filterby_price_drop;
                                    }// end of seller  
                                    // end of search by sellers                    
                                 
                                    if (isset($search_request['sellers'])) 
                                    {
                                        $sellers = $search_request['sellers']; 
                                        $res_sellerinfo = $this->get_seller_business_arr($sellers);

                                         if(!empty($res_sellerinfo) && isset($res_sellerinfo)){ 
                                            $seller_id = $res_sellerinfo['user_id'];
                                            $obj_product->where('user_id',$seller_id);
                                         }else{
                                             $obj_product->where('user_id','');
                                         }

                                        if(!empty($res_sellerinfo) && isset($res_sellerinfo)){  
                                            $seller_id = $res_sellerinfo['user_id'];
                                            $arr_seller_banner = [];
                                            $obj_seller_banner = $this->SellerBannerImageModel->where('seller_id',$seller_id)->first();
                                            if($obj_seller_banner)
                                            {
                                                $arr_seller_banner = $obj_seller_banner->toArray();
                                            }
                                            $apppend_data['sellers'] = $sellers;     
                                         }

                                        $seller_business_name = isset($res_sellerinfo['business_name'])?$res_sellerinfo['business_name']:'';
                                        $this->arr_view_data['page_title']  = $seller_business_name;         
                                    }//if sellers
                                     if(isset($search_request['state']) && !isset($search_request['city']))
                                    {

                                          $state = $search_request['state']; 
                                          $state = str_replace('-',' ',$search_request['state']); 

                                          $getstateid = $this->StatesModel->select('id')->where('name',$state)->first();
                                          if(isset($getstateid))
                                          {
                                            $getstateid = $getstateid->toArray();

                                            $getusers_ofstate = $this->UserModel->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                                             if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                                             {
                                                $getusers_ofstate = $getusers_ofstate->toArray();
                                                  $state_user_ids =  array_values($getusers_ofstate);//get user ids from array
                                                  $obj_product->whereIn('user_id',$state_user_ids);

                                                    $category_ids='';
                                                    $get_categoryids = $this->StatesModel->where('name',$state)->first();
                                                    if(isset($get_categoryids) && !empty($get_categoryids))
                                                    {
                                                        $get_categoryids = $get_categoryids->toArray();
                                                        $category_ids = $get_categoryids['category_ids'];
                                                    }


                                                    if(isset($category_ids) && !empty($category_ids)) 
                                                    {   
                                                        $catdata =[];
                                                        $category_ids = explode(",",$category_ids);
                                                         foreach ($category_ids as $ids) {
                                                            $catdata[] = $ids;
                                                         $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                        }                          
                                                    }      


                                             }//if getusersofstate

                                          }//if getstateid

                                          $apppend_data['state'] = $state;
                                          
                                    } // if state

                                  if(isset($search_request['state']) && isset($search_request['city']))
                                    {
                                       
                                      $checkuserids =[];
                                      $state = $search_request['state']; 
                                      $statename = str_replace('-',' ',$search_request['state']); 

                                      $getstateid = $this->StatesModel->select('id')->where('name',$statename)->first();
                                      if(isset($getstateid))
                                      {
                                        $getstateid = $getstateid->toArray();

                                        $getusers_ofstate = $this->UserModel->select('id')->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                                         if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                                         {
                                              $getusers_ofstate = $getusers_ofstate->toArray();
                                              $state_user_ids =  array_values($getusers_ofstate);//get user ids from array
                                               if(isset($search_request['city']))
                                                {
                                                   $city = $search_request['city']; 
                                                   $cityname = str_replace('-',' ',$search_request['city']); 

                                                   $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->whereIn('id',$state_user_ids)->get();
                                                    if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                                    {
                                                            $getusers_ofcity = $getusers_ofcity->toArray();
                                                            $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                                    }//if getusersofcity

                                                    $apppend_data['city'] = $city;
                                                    $this->arr_view_data['page_title']  = $city;
                                                      
                                                } // if city                                           
                                             $obj_product->whereIn('user_id',$city_user_ids);

                                                    $category_ids='';
                                                    $get_categoryids = $this->StatesModel->where('name',$statename)->first();
                                                    if(isset($get_categoryids) && !empty($get_categoryids))
                                                    {
                                                        $get_categoryids = $get_categoryids->toArray();
                                                        $category_ids = $get_categoryids['category_ids'];
                                                    }

                                                    if(isset($category_ids) && !empty($category_ids)) 
                                                    {   
                                                        $catdata =[];
                                                        $category_ids = explode(",",$category_ids);
                                                         foreach ($category_ids as $ids) {
                                                            $catdata[] = $ids;
                                                        
                                                         $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                        }                          
                                                    }      

                                         }//if getusersofstate

                                      }//if getstateid

                                      $apppend_data['state'] = $state;

                                } // if state and city

                                if(isset($search_request['city']) && !isset($search_request['state']))
                                 {
                                          $city = $search_request['city']; 
                                          $cityname = str_replace('-',' ',$search_request['city']); 

                                          $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->get();
                                             if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                             {
                                                $getusers_ofcity = $getusers_ofcity->toArray();
                                                $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                                  $obj_product->whereIn('user_id',$city_user_ids);
                                             }//if getusersofstate

                                         $apppend_data['city'] = $city;
                                         $this->arr_view_data['page_title']  = $city;                                      
                                  } // if city


                                   if (isset($search_request['spectrum'])) 
                                    {
                                         $spectrum = $search_request['spectrum'];  
                                         $spectrumname = str_replace('-',' ',$search_request['spectrum']);  
                                       
                                        if($spectrumname)
                                        {

                                            $getspectrum_id = $this->SpectrumModel->where('name','=',$spectrumname)->first();

                                            if(!empty($getspectrum_id) && isset($getspectrum_id))
                                            {
                                                $getspectrum_id = $getspectrum_id->toArray();

                                               $specid = isset($getspectrum_id['id'])?$getspectrum_id['id']:''; 
                                                if(isset($specid)){
                                                 $obj_product->where('spectrum',$specid);
                                               }
                                            }else{
                                               $obj_product->where('spectrum','');
                                            }
                                        }
                                        $apppend_data['spectrum'] = $spectrum;

                                    }// end of search by spectrum

                                 

                                      if (isset($search_request['statelaw'])) 
                                    {
                                         $statelaw = $search_request['statelaw'];  
                                       
                                        if(isset($statelaw) && $statelaw=="Allowed")
                                        {   

                                                if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {

                                                   //buyer restricted and state and category there
                                                  $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                  $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                                                    && empty($catdata))
                                               {
                                                    //buyer restricted but state there not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                                               {
                                                   //empty
                                                 //buyer restricted but category there not state
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                    
                                                  $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }

                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                                               {
                                                   //empty
                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                  // $obj_product->whereNotIn('first_level_category_id',$catdata);

                                               }


                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                   //buyer not restricted but category there and state
                                                    $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                    $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }
                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                 //buyer not restricted but category there and not state   
                                                 $obj_product->whereNotIn('first_level_category_id',$catdata);
                                               }
                                                                 
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                   //buyer state is not restricted but  seller for his state not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                               }

                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                   //buyer state is not restricted not seller for his state not category
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                   $obj_product->whereNotIn('first_level_category_id',$catdata);

                                               }
                                              
                                              
                                           
                                        }
                                         elseif(isset($statelaw) && $statelaw=="Restricted")
                                        {   

                                                if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                  //buyer restricted and state and category there 
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                  $obj_product->whereIn('first_level_category_id',$catdata);
                                               
                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                                                    && empty($catdata))
                                               {
                                                   //buyer restricted and state not category 
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                               }

                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata)
                                                    && empty($allowed_state_sellers))
                                               {
                                                   //buyer restricted and category not state
                                                    $obj_product->whereIn('first_level_category_id',$catdata);
                                                     $obj_product->whereNotIn('user_id',$allowed_state_sellers); //new
                                               }
                                                 elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                                               {

                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                  // $obj_product->whereNotIn('first_level_category_id',$catdata);

                                               }
                                             

                                               elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                               {
                                                 //buyer not restricted but category and state    
                                                 $obj_product->whereIn('first_level_category_id',$catdata);
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                                               {
                                                 //buyer not restricted but state there not category    
                                                  $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                                               {
                                                 //buyer not restricted but category there not state    
                                                  $obj_product->whereIn('first_level_category_id',$catdata);

                                               }
                                                elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers)&& empty($catdata))
                                               {

                                                   //buyer state is restricted but not any seller and not category
                                                   $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                   $obj_product->whereIn('first_level_category_id',$catdata);

                                               }
                                                                  
                                             
                                           
                                        }
                                        $apppend_data['statelaw'] = $statelaw;

                                    }// end of search by statelaw
                                        
                                 

                                     if(isset($search_request['reported_effects'])) 
                                    {
                                         $reported_effects = $search_request['reported_effects'];  

                                         if(isset($reported_effects))
                                         {
                                            $effects = explode('-',$search_request['reported_effects']);  
                                            $effects = array_filter($effects);

                                            if(isset($effects))
                                           {

                                               $get_effects = $this->ReviewRatingsModel->select('product_id','emoji')->where('emoji','!=','')->get();
                                               if(isset($get_effects) && !empty($get_effects))
                                              {
                                                  $get_effects = $get_effects->toArray();
                                                

                                                   $allemojiarr = $productids = [];
                                                
                                                    foreach($get_effects as $kk=>$vv)
                                                    {
                                                       $pid = $vv['product_id']; 
                                                       $allemoji =  explode(",",$vv['emoji']);
                                                       if(isset($allemoji) && !empty($allemoji)){
                                                        

                                                         foreach($allemoji as $k1=>$v1)
                                                         {
                                                            $effecttitle='';
                                                            $get_reported_effects = get_effect_name($v1);
                                                            if(isset($get_reported_effects) && !empty($get_reported_effects))
                                                            {    
                                                                $effecttitle = $get_reported_effects['title'];

                                                            }
                                                            foreach($effects as $mm)
                                                            {
                                                                
                                                                $mm = str_replace("_", " ", $mm); 
                                                               
                                                                if($mm==$effecttitle)
                                                                {

                                                                   $productids[] =  $pid;

                                                                }
                                                                $allemojiarr[] = $effecttitle;
                                                            }//foreach
                                                          }//foreach
                                                        
                                                        
                                                      }//isset all emoji

                                                    }//foreach get_effects
                                                      
                                              }//if isset get effects
                                             

                                             if(isset($productids))
                                             {
                                                  $obj_product->whereIn('id',$productids);
                                             } 
                                           }//if isset effects

                                         } // if isset reported_effects
                                     
                                        
                                        $apppend_data['reported_effects'] = $reported_effects;

                                    }// end of search by reported_effects



                             
                                    if (isset($search_request['cannabinoids'])) 
                                    {
                                        $reported_effects = $search_request['cannabinoids'];  

                                        if(isset($reported_effects))
                                        {
                                            $cannabinoids = explode('-',$search_request['cannabinoids']);  
                                            $cannabinoids = array_filter($cannabinoids);

                                            if(isset($cannabinoids))
                                            {
                                                $cannabinoids_name = isset($cannabinoids[0]) ? $cannabinoids[0] : "";
                                                $arr_cannabinoids = DB::table($prefix_ProductCannabinoidsModel)
                                                            ->select(DB::raw($prefix_ProductCannabinoidsModel.'.product_id,'
                                                                            .$prefix_CannabinoidsModel.'.name'
                                                            ))

                                                            ->leftJoin($prefix_CannabinoidsModel,$prefix_CannabinoidsModel.'.id','=',$prefix_ProductCannabinoidsModel.'.cannabinoids_id')    
                                                            ->where($prefix_CannabinoidsModel.'.name','like','%'.$cannabinoids_name.'%') 
                                                            ->where($prefix_ProductCannabinoidsModel.'.percent','!=',0) 
                                                            ->get();
                                                if(isset($arr_cannabinoids) && !empty($arr_cannabinoids))
                                                {
                                                    $get_cannabinoids = $arr_cannabinoids->toArray();        
                                                    $allcannabinoidarr = $productids_can = [];
                                                    foreach($get_cannabinoids as $kk=>$vv)
                                                    {                              
                                                        $pid = $vv->product_id; 
                                                        $productids_can[] =  $pid;                         

                                                    }//foreach cannobinoids                              
                                                }//if isset get cannobinoids


                                                if(isset($productids_can))
                                                {
                                                    $obj_product->whereIn('id',$productids_can);
                                                } 
                                            }//if isset cannabinoids

                                        } // if isset cannabinoids
                                        $apppend_data['cannabinoids'] = $reported_effects;
                                    }// end of search by cannabinoids


                                  $result = $price_product_ids = $productids_unitpricearr = $productids_pricdroparr = [];
                                 
                                  if(isset($search_request['price'])) 
                                 {

                                    $price_range = explode('-',$search_request['price']);
                                    $min_price = isset($price_range[0])?$price_range[0]:'';
                                    $max_price = isset($price_range[1])?$price_range[1]:'';

                                    $get_unit_price_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                                                    ->where('price_drop_to','=','') 
                                                    ->whereBetween('unit_price', array($min_price, $max_price))
                                                    ->get();

                                    if(isset($get_unit_price_arr) && !empty($get_unit_price_arr))
                                    {
                                         $get_unit_price_arr = $get_unit_price_arr->toArray();
                                         $productids_unitpricearr   = array_column($get_unit_price_arr, 'id');
                                       
                                    }// if productids_unitpricearr

                                    $get_price_drop_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                                                    ->whereBetween('price_drop_to', array($min_price, $max_price))
                                                    ->get();

                                    if(isset($get_price_drop_arr) && !empty($get_price_drop_arr))
                                    {
                                         $get_price_drop_arr = $get_price_drop_arr->toArray();
                                         $productids_pricdroparr   = array_column($get_price_drop_arr, 'id');
                                    }//if get_price_drop_arr

                                    if(isset($productids_unitpricearr) && isset($productids_pricdroparr)){
                                         $result = array_merge($productids_unitpricearr,$productids_pricdroparr);       
                                         $price_product_ids= array_unique($result);
                                         $obj_product->whereIn('id',$price_product_ids);
                                    }
                                    
                                      $apppend_data['price'] = $min_price.'-'.$max_price;
                                 
                                  }//if isset price filter  


                                 $obj_product = $obj_product->get();

                                 if (isset($obj_product) && $obj_product != null ) 
                                 {
                                     $arr_product = $obj_product->toArray();
                                       
                                } // if category search filter is set
                 
                    
               }// if product search not empty for category filter
        }*/
        // if arr_product is empty and search filter is empty then use this for category


        /***************category search end***************************************/


       /******************description search**************************************/
        // if search in the header for description then this code is used
    /*    if(empty($arr_product) && isset($search_request['product_search']))
        { 
           
            $product_search = $search_request['product_search']; 
              if($product_search!="") 
               {    

                   $obj_product = $this->ProductModel->with([
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
                                            ->whereHas('get_seller_details.get_country_detail',function($q){
                                                $q->where('is_active','1');
                                            })
                                            ->whereHas('get_seller_details.get_state_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_brand_detail', function ($q) {
                                                $q->where('is_active', '1');
                                            })
                                            ->whereHas('get_seller_details', function ($q) {
                                                $q->where('is_active', '1');
                                            })


                                            ->where([['is_active',1],['is_approve',1]])
                                            ->where('description','like','%'.$product_search.'%')
                                            ->inRandomOrder();



                                     if(isset($search_request['best_seller'])) 
                                    {             
                                      $productids = $avgproductids = [];

                                      $prodmodel           = $this->ProductModel->getTable();
                                      $prefix_productable  = DB::getTablePrefix().$this->ProductModel->getTable();

                                      $order_table         = $this->OrderModel->getTable();
                                      $prefix_order_detail = DB::getTablePrefix().$this->OrderModel->getTable();

                                      $order_product_table  = $this->OrderProductModel->getTable();
                                      $prefix_order_product = DB::getTablePrefix().$this->OrderProductModel->getTable();

                                      $reviewmodel         = $this->ReviewRatingsModel->getTable();
                                      $prefix_reviewtable  = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();

                                      $arr_trending_productids =  DB::table($prefix_order_detail)->select(DB::raw(
                                                                    $prefix_order_product.'.product_id,count('.$prefix_order_product.'.product_id) as mostsold'
                                          ))
                                      ->leftJoin($prefix_order_product,$prefix_order_product.'.order_id','=',$prefix_order_detail.'.id')    
                                      ->where($prefix_order_detail.'.order_status','1')  
                                      ->groupBy($prefix_order_product.'.product_id')
                                      ->orderBy('mostsold','desc')
                                      ->get()->toArray(); 


                                    if(isset($arr_trending_productids) &&!empty($arr_trending_productids))
                                    {  
                                         $productidssold   = array_column($arr_trending_productids, 'product_id');
                                         $mostsold         = array_unique(array_column($arr_trending_productids, 'mostsold'));
                                         $arr = []; $mostsolded ='';
                                         foreach($mostsold as $v)
                                         {
                                            $arr[] = $v;
                                         }
                                         
                                         $mostsolded = implode(",", $arr);

                                    }//if isset arr_mostsold_productids
                          
                                  if(isset($arr_trending_productids) && !empty($arr_trending_productids) && isset($mostsolded) &&  !empty($mostsolded))
                                  {
                                      $productids   = array_column($arr_trending_productids, 'product_id');

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
                                        
                                            ->whereIn('id',$productids)    
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->get();

                         
                                        if(isset($arr_eloq_trending_data) && !empty($arr_eloq_trending_data))
                                        {
                                            $arr_eloq_trending_data = $arr_eloq_trending_data->toArray();
                                            $avgproductids   = array_column($arr_eloq_trending_data, 'id');
                                            $obj_product->whereIn('id',$avgproductids);
                                        }                                    

                                      }//if not empty r_trending_productids                        
                                    
                                       $best_seller = $search_request['best_seller'];            
                                       $apppend_data['best_seller'] = $best_seller;
                                     }// end of best seller      



                                      if (isset($search_request['chows_choice'])) 
                                    {             
                                        
                                        $chows_choice = $search_request['chows_choice']; 
                                        $obj_product->where('is_chows_choice','=','1');
                                        $apppend_data['chows_choice'] = $chows_choice;
                                    }// end of seller          


                                   
                                    if (isset($search_request['age_restrictions'])) 
                                    {
                                        $age_restrictions = base64_decode($search_request['age_restrictions']); 
                                        $obj_product->where('age_restriction',$age_restrictions);
                                        $obj_product->where('is_age_limit',1);
                                        $apppend_data['age_restrictions'] = base64_encode($age_restrictions);
                                    }// end of age restriction
                                  
                                     if (isset($search_request['mg'])) 
                                    {
                                       
                                        $mg = explode('-',$search_request['mg']); 
                                        $min_mg = $mg[0];
                                        $max_mg = $mg[1];
                                        $obj_product->whereBetween('per_product_quantity', array($min_mg, $max_mg));
                                        $apppend_data['mg'] = $min_mg.'-'.$max_mg;
                                     
                                    }// end of search by mg
                                     if(isset($search_request['category_id'])) 
                                    {
                                        $categories = $search_request['category_id'];  
                                        $category_name = str_replace('-and-','-&-',$search_request['category_id']);             
                                        $category_name = str_replace('-',' ',$category_name); 

                                        if($category_name)
                                        {

                                            $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','=',$category_name)->get()->toArray();

                                            if(empty($getcategory_id))
                                            {
                                              $getcategory_id = $this->FirstLevelCategoryModel->where('product_type','like',$category_name.'%')->get()->toArray();

                                            }

                                            if(!empty($getcategory_id) && isset($getcategory_id))
                                            {
                                               $categoryid = isset($getcategory_id[0]['id'])?$getcategory_id[0]['id']:''; 
                                                if(isset($categoryid)){
                                                 $obj_product->where('first_level_category_id',$categoryid);
                                               }
                                            }else{
                                               $obj_product->where('first_level_category_id','');
                                            }

                                        }   
                                        $apppend_data['category_id'] = $categories;
                                    }  
                                     if (isset($search_request['rating']))  
                                    {

                                        $rating = base64_decode($search_request['rating']); 
                                        if(isset($rating)){
                                            //$res_productratings = $this->get_rating_arr($rating);
                                            $res_productratings = $this->get_buyer_admin_rating_arr($rating);
                                        }
                                               
                                        if(!empty($res_productratings))
                                        {

                                           $product_id_arr =  $res_productratings;
                                            
                                           $obj_product->whereIn('id',$product_id_arr);
                                                                   
                                        }
                                        else
                                        {
                                           $product_id_arr =  $res_productratings;
                                         
                                           $obj_product->whereIn('id',$product_id_arr);
                                        }


                                        $apppend_data['rating'] = base64_encode($rating);
                                    }// end of rating
                                     if (isset($search_request['filterby_price_drop'])) 
                                    {             
                                        
                                        $filterby_price_drop = $search_request['filterby_price_drop']; 
                                        $obj_product->where('price_drop_to','>','0');
                                        $apppend_data['filterby_price_drop'] = $filterby_price_drop;
                                    }// end of seller  
                                    // end of search by sellers                    
                                    if (isset($search_request['brands'])) 
                                    {
                                         $brands = $search_request['brands'];  
                                         $brandname = str_replace('-',' ',$search_request['brands']);  
                                       
                                        if($brandname)
                                        {

                                            
                                             $getbrand_id = $this->BrandModel->where('name','=',$brandname)->first();
                                             if(empty($getbrand_id))
                                             {
                                                 $getbrand_id = $this->BrandModel->where('name','like',$brandname.'%')->first();
                                             }
                                            
                                             if(isset($getbrand_id) && !empty($getbrand_id))
                                             {
                                                $getbrand_id = $getbrand_id->toArray();

                                                $brandid = isset($getbrand_id['id'])?$getbrand_id['id']:'';
                                                 if(isset($brandid)){
                                                     $obj_product->where('brand',$brandid);
                                                 }else{
                                                    $obj_product->where('brand','');
                                                 }
                                             }



                                        }
                                        $apppend_data['brands'] = $brands;

                                    }// end of search by brands
                                    if (isset($search_request['sellers'])) 
                                    {
                                        $sellers = $search_request['sellers']; 
                                        $res_sellerinfo = $this->get_seller_business_arr($sellers);

                                         if(!empty($res_sellerinfo) && isset($res_sellerinfo)){ 
                                            $seller_id = $res_sellerinfo['user_id'];
                                            $obj_product->where('user_id',$seller_id);
                                         }else{
                                             $obj_product->where('user_id','');
                                         }

                                        if(!empty($res_sellerinfo) && isset($res_sellerinfo)){  
                                            $seller_id = $res_sellerinfo['user_id'];
                                            $arr_seller_banner = [];
                                            $obj_seller_banner = $this->SellerBannerImageModel->where('seller_id',$seller_id)->first();
                                            if($obj_seller_banner)
                                            {
                                                $arr_seller_banner = $obj_seller_banner->toArray();
                                            }
                                            $apppend_data['sellers'] = $sellers;     
                                         }

                                        $seller_business_name = isset($res_sellerinfo['business_name'])?$res_sellerinfo['business_name']:'';
                                        $this->arr_view_data['page_title']  = $seller_business_name;         
                                    }//if sellers
                                     if(isset($search_request['state']) && !isset($search_request['city']))
                                    {

                                          $state = $search_request['state']; 
                                          $state = str_replace('-',' ',$search_request['state']); 

                                          $getstateid = $this->StatesModel->select('id')->where('name',$state)->first();
                                          if(isset($getstateid))
                                          {
                                            $getstateid = $getstateid->toArray();

                                            $getusers_ofstate = $this->UserModel->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                                             if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                                             {
                                                $getusers_ofstate = $getusers_ofstate->toArray();
                                                  $state_user_ids =  array_values($getusers_ofstate);//get user ids from array
                                                  $obj_product->whereIn('user_id',$state_user_ids);

                                                    $category_ids='';
                                                    $get_categoryids = $this->StatesModel->where('name',$state)->first();
                                                    if(isset($get_categoryids) && !empty($get_categoryids))
                                                    {
                                                        $get_categoryids = $get_categoryids->toArray();
                                                        $category_ids = $get_categoryids['category_ids'];
                                                    }


                                                    if(isset($category_ids) && !empty($category_ids)) 
                                                    {   
                                                        $catdata =[];
                                                        $category_ids = explode(",",$category_ids);
                                                         foreach ($category_ids as $ids) {
                                                            $catdata[] = $ids;
                                                         $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                        }                          
                                                    }      


                                             }//if getusersofstate

                                          }//if getstateid

                                          $apppend_data['state'] = $state;
                                          
                                    } // if state

                                  if(isset($search_request['state']) && isset($search_request['city']))
                                    {
                                       
                                      $checkuserids =[];
                                      $state = $search_request['state']; 
                                      $statename = str_replace('-',' ',$search_request['state']); 

                                      $getstateid = $this->StatesModel->select('id')->where('name',$statename)->first();
                                      if(isset($getstateid))
                                      {
                                        $getstateid = $getstateid->toArray();

                                        $getusers_ofstate = $this->UserModel->select('id')->where('state',$getstateid)->where('user_type','seller')->where('is_active','1')->get();
                                         if(isset($getusers_ofstate) && !empty($getusers_ofstate))
                                         {
                                              $getusers_ofstate = $getusers_ofstate->toArray();
                                              $state_user_ids =  array_values($getusers_ofstate);//get user ids from array
                                               if(isset($search_request['city']))
                                                {
                                                   $city = $search_request['city']; 
                                                   $cityname = str_replace('-',' ',$search_request['city']); 

                                                   $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->whereIn('id',$state_user_ids)->get();
                                                    if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                                    {
                                                            $getusers_ofcity = $getusers_ofcity->toArray();
                                                            $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                                    }//if getusersofcity

                                                    $apppend_data['city'] = $city;
                                                    $this->arr_view_data['page_title']  = $city;
                                                      
                                                } // if city                                           
                                             $obj_product->whereIn('user_id',$city_user_ids);

                                                    $category_ids='';
                                                    $get_categoryids = $this->StatesModel->where('name',$statename)->first();
                                                    if(isset($get_categoryids) && !empty($get_categoryids))
                                                    {
                                                        $get_categoryids = $get_categoryids->toArray();
                                                        $category_ids = $get_categoryids['category_ids'];
                                                    }

                                                    if(isset($category_ids) && !empty($category_ids)) 
                                                    {   
                                                        $catdata =[];
                                                        $category_ids = explode(",",$category_ids);
                                                         foreach ($category_ids as $ids) {
                                                            $catdata[] = $ids;
                                                        
                                                         $obj_product = $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                        }                          
                                                    }      


                                         }//if getusersofstate

                                      }//if getstateid

                                      $apppend_data['state'] = $state;

                                } // if state and city

                                if(isset($search_request['city']) && !isset($search_request['state']))
                                 {
                                          $city = $search_request['city']; 
                                          $cityname = str_replace('-',' ',$search_request['city']); 

                                          $getusers_ofcity = $this->UserModel->select('id')->where('city',$cityname)->where('user_type','seller')->where('is_active','1')->get();
                                             if(isset($getusers_ofcity) && !empty($getusers_ofcity))
                                             {
                                                $getusers_ofcity = $getusers_ofcity->toArray();
                                                $city_user_ids =  array_values($getusers_ofcity);//get user ids from array
                                                  $obj_product->whereIn('user_id',$city_user_ids);
                                             }//if getusersofstate

                                         $apppend_data['city'] = $city;
                                         $this->arr_view_data['page_title']  = $city;                                      
                                  } // if city

                                 

                                    if (isset($search_request['spectrum'])) 
                                    {
                                         $spectrum = $search_request['spectrum'];  
                                         $spectrumname = str_replace('-',' ',$search_request['spectrum']);  
                                       
                                        if($spectrumname)
                                        {

                                            $getspectrum_id = $this->SpectrumModel->where('name','=',$spectrumname)->first();

                                            if(!empty($getspectrum_id) && isset($getspectrum_id))
                                            {
                                                $getspectrum_id = $getspectrum_id->toArray();

                                               $specid = isset($getspectrum_id['id'])?$getspectrum_id['id']:''; 
                                                if(isset($specid)){
                                                 $obj_product->where('spectrum',$specid);
                                               }
                                            }else{
                                               $obj_product->where('spectrum','');
                                            }
                                        }
                                        $apppend_data['spectrum'] = $spectrum;

                                    }// end of search by spectrum


                                       if (isset($search_request['statelaw'])) 
                                        {
                                             $statelaw = $search_request['statelaw'];  
                                           
                                            if(isset($statelaw) && $statelaw=="Allowed")
                                            {   

                                                    if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                                   {

                                                       //buyer restricted and state and category there
                                                      $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                      $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                   
                                                   }
                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                                                        && empty($catdata))
                                                   {
                                                        //buyer restricted but state there not category
                                                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                   }
                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                                                   {
                                                       //empty
                                                     //buyer restricted but category there not state
                                                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                        
                                                      $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                   }

                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                                                   {
                                                       $obj_product->whereIn('user_id',$allowed_state_sellers);

                                                   }


                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                                   {
                                                       //buyer not restricted but category there and state
                                                        $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                        $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                   }
                                                   elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                                   {
                                                     //buyer not restricted but category there and not state   
                                                     $obj_product->whereNotIn('first_level_category_id',$catdata);
                                                   }
                                                                     
                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                                                   {
                                                       //buyer state is not restricted but  seller for his state not category
                                                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                   }

                                                   elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers) && empty($catdata))
                                                   {
                                                       //buyer state is not restricted not seller for his state not category
                                                       $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                       $obj_product->whereNotIn('first_level_category_id',$catdata);

                                                   }
                                                  
                                                  
                                               
                                            }
                                             elseif(isset($statelaw) && $statelaw=="Restricted")
                                            {   

                                                    if(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                                   {
                                                      //buyer restricted and state and category there 
                                                      $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                      $obj_product->whereIn('first_level_category_id',$catdata);
                                                   
                                                   }
                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) 
                                                        && empty($catdata))
                                                   {
                                                       //buyer restricted and state not category 
                                                       $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                   }

                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && isset($catdata) && !empty($catdata)
                                                        && empty($allowed_state_sellers))
                                                   {
                                                       //buyer restricted and category not state
                                                        $obj_product->whereIn('first_level_category_id',$catdata);
                                                         $obj_product->whereNotIn('user_id',$allowed_state_sellers); //new
                                                   }
                                                     elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==1 && empty($allowed_state_sellers)&& empty($catdata))
                                                   {

                                                       //buyer state is restricted but not any seller and not category
                                                       $obj_product->whereNotIn('user_id',$allowed_state_sellers);
                                                      // $obj_product->whereNotIn('first_level_category_id',$catdata);

                                                   }
                                                 

                                                   elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && isset($catdata) && !empty($catdata))
                                                   {
                                                     //buyer not restricted but category and state    
                                                     $obj_product->whereIn('first_level_category_id',$catdata);
                                                      $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                                   }
                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($allowed_state_sellers) && !empty($allowed_state_sellers) && empty($catdata))
                                                   {
                                                     //buyer not restricted but state there not category    
                                                      $obj_product->whereNotIn('user_id',$allowed_state_sellers);

                                                   }
                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && isset($catdata) && !empty($catdata) && empty($allowed_state_sellers))
                                                   {
                                                     //buyer not restricted but category there not state    
                                                      $obj_product->whereIn('first_level_category_id',$catdata);

                                                   }
                                                    elseif(isset($is_buyer_restricted_forstate) && $is_buyer_restricted_forstate==0 && empty($allowed_state_sellers)&& empty($catdata))
                                                   {

                                                       //buyer state is restricted but not any seller and not category
                                                       $obj_product->whereIn('user_id',$allowed_state_sellers);
                                                       $obj_product->whereIn('first_level_category_id',$catdata);

                                                   }
                                                                      
                                                 
                                               
                                            }
                                            $apppend_data['statelaw'] = $statelaw;

                                        }// end of search by statelaw 



                                     if(isset($search_request['reported_effects'])) 
                                    {
                                         $reported_effects = $search_request['reported_effects'];  

                                         if(isset($reported_effects))
                                         {
                                            $effects = explode('-',$search_request['reported_effects']);  
                                            $effects = array_filter($effects);

                                            if(isset($effects))
                                           {

                                               $get_effects = $this->ReviewRatingsModel->select('product_id','emoji')->where('emoji','!=','')->get();
                                               if(isset($get_effects) && !empty($get_effects))
                                              {
                                                  $get_effects = $get_effects->toArray();
                                                

                                                   $allemojiarr = $productids = [];
                                                
                                                    foreach($get_effects as $kk=>$vv)
                                                    {
                                                       $pid = $vv['product_id']; 
                                                       $allemoji =  explode(",",$vv['emoji']);
                                                       if(isset($allemoji) && !empty($allemoji)){
                                                         

                                                           foreach($allemoji as $k1=>$v1)
                                                            {
                                                                $effecttitle='';
                                                                $get_reported_effects = get_effect_name($v1);
                                                                if(isset($get_reported_effects) && !empty($get_reported_effects))
                                                                {    
                                                                    $effecttitle = $get_reported_effects['title'];

                                                                }
                                                                foreach($effects as $mm)
                                                                {
                                                                    
                                                                    $mm = str_replace("_", " ", $mm); 
                                                                   
                                                                    if($mm==$effecttitle)
                                                                    {

                                                                       $productids[] =  $pid;

                                                                    }
                                                                    $allemojiarr[] = $effecttitle;
                                                                }//foreach
                                                            }//foreach

                                                      }//isset all emoji

                                                    }//foreach get_effects
                                                      
                                              }//if isset get effects
                                             

                                             if(isset($productids))
                                             {
                                                  $obj_product->whereIn('id',$productids);
                                             } 
                                           }//if isset effects

                                         } // if isset reported_effects
                                     
                                        
                                        $apppend_data['reported_effects'] = $reported_effects;

                                    }// end of search by reported_effects




                                    if (isset($search_request['cannabinoids'])) 
                                    {
                                        $reported_effects = $search_request['cannabinoids'];  

                                        if(isset($reported_effects))
                                        {
                                            $cannabinoids = explode('-',$search_request['cannabinoids']);  
                                            $cannabinoids = array_filter($cannabinoids);

                                            if(isset($cannabinoids))
                                            {
                                                $cannabinoids_name = isset($cannabinoids[0]) ? $cannabinoids[0] : "";
                                                $arr_cannabinoids = DB::table($prefix_ProductCannabinoidsModel)
                                                            ->select(DB::raw($prefix_ProductCannabinoidsModel.'.product_id,'
                                                                            .$prefix_CannabinoidsModel.'.name'
                                                            ))

                                                            ->leftJoin($prefix_CannabinoidsModel,$prefix_CannabinoidsModel.'.id','=',$prefix_ProductCannabinoidsModel.'.cannabinoids_id')    
                                                            ->where($prefix_CannabinoidsModel.'.name','like','%'.$cannabinoids_name.'%') 
                                                            ->where($prefix_ProductCannabinoidsModel.'.percent','!=',0) 
                                                            ->get();
                                                if(isset($arr_cannabinoids) && !empty($arr_cannabinoids))
                                                {
                                                    $get_cannabinoids = $arr_cannabinoids->toArray();        
                                                    $allcannabinoidarr = $productids_can = [];
                                                    foreach($get_cannabinoids as $kk=>$vv)
                                                    {                              
                                                        $pid = $vv->product_id; 
                                                        $productids_can[] =  $pid;                         

                                                    }//foreach cannobinoids                              
                                                }//if isset get cannobinoids


                                                if(isset($productids_can))
                                                {
                                                    $obj_product->whereIn('id',$productids_can);
                                                } 
                                            }//if isset cannabinoids

                                        } // if isset cannabinoids
                                        $apppend_data['cannabinoids'] = $reported_effects;
                                    }// end of search by cannabinoids



                                 $result = $price_product_ids = $productids_unitpricearr = $productids_pricdroparr = [];

                                 if(isset($search_request['price'])) 
                               {

                                    $price_range = explode('-',$search_request['price']);
                                    $min_price = isset($price_range[0])?$price_range[0]:'';
                                    $max_price = isset($price_range[1])?$price_range[1]:'';

                                    $get_unit_price_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                                                    //->where('unit_price','!=','') 
                                                    ->where('price_drop_to','=','') 
                                                    ->whereBetween('unit_price', array($min_price, $max_price))
                                                    ->get();

                                    if(isset($get_unit_price_arr) && !empty($get_unit_price_arr))
                                    {
                                         $get_unit_price_arr = $get_unit_price_arr->toArray();
                                         $productids_unitpricearr   = array_column($get_unit_price_arr, 'id');
                                       
                                    }// if productids_unitpricearr

                                    $get_price_drop_arr = $this->ProductModel->select('id','unit_price','price_drop_to')->where([['is_active',1],['is_approve',1]])
                                                    ->whereBetween('price_drop_to', array($min_price, $max_price))
                                                    ->get();

                                    if(isset($get_price_drop_arr) && !empty($get_price_drop_arr))
                                    {
                                         $get_price_drop_arr = $get_price_drop_arr->toArray();
                                         $productids_pricdroparr   = array_column($get_price_drop_arr, 'id');
                                         //dd($productids_pricdroparr);
                                    }//if get_price_drop_arr

                                    if(isset($productids_unitpricearr) && isset($productids_pricdroparr)){
                                         $result = array_merge($productids_unitpricearr,$productids_pricdroparr);       
                                         $price_product_ids= array_unique($result);
                                         $obj_product->whereIn('id',$price_product_ids);
                                    }
                                    
                                      $apppend_data['price'] = $min_price.'-'.$max_price;
                                 
                              }//if isset price filter  
  
                                 $obj_product = $obj_product->get();

                                 if (isset($obj_product) && $obj_product != null ) 
                                 {
                                     $arr_product = $obj_product->toArray();
                                       
                                } // if desc search filter is set
                 
                    
               }// if product search not empty
        } */ 
        // if arr_product is empty and search description filter is empty then use this

        /*****************description search header end************************************************/

    }//end commented code function

}//class
