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

use App\Models\StaticPageTranslationModel;

use App\Common\Services\EmailService; 

use Sentinel;
use DB; 
use Datatables;
use Session;

class HomeControlleroldbk extends Controller
{
    /*
	|  	Author : Sagar B. Jadhav
    |  	Date   : 21 Feb 2019
    */

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
                                    
                                    EmailService $EmailService,
                                    TestimonialModel $TestimonialModel,
                                    BuyerModel $BuyerModel,
                                    ProductNewsModel $ProductNewsModel,
                                    ReviewRatingsModel $ReviewRatingsModel,
                                    ProductImagesModel $ProductImagesModel,
                                    OrderModel $OrderModel,
                                    OrderProductModel $OrderProductModel,
                                    BrandModel $BrandModel
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

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->slider_base_img_path   = base_path().config('app.project.img_path.slider_images');
        $this->slider_public_img_path = url('/').config('app.project.img_path.slider_images');
        $this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }


    /*
        recent_sell_arr = 1.Get Unit Details, Product Details, Category Details, Subcategory 
                            Details, User Details, buyer trade details
                          2.trade_type    => 1 (Sell)
                          3.trade_status  => 0 (Pending)
                          4 Limit         => 5
                          5.Order By Desc => Created At  
                          6. Seller should be active. If seller is blocked then do not those trade.
    */

    public function index()
    {
        $this->arr_view_data['page_title'] = 'Home';
        $arr_slider_images = $this->SliderImagesModel->get()->toArray();
        $arr_slider_images = array_chunk($arr_slider_images, 6);

        $this->arr_view_data['slider_public_img_path']  = $this->slider_public_img_path;        

        $this->arr_view_data['arr_slider_images']       = isset($arr_slider_images)?$arr_slider_images:[];

        //$arr_product = $this->ProductModel->where('is_active','1')->where('is_approve','1')->get()->toArray();      

       /* $arr_product       = $this->ReviewRatingsModel->with('product_details.product_images_details')
                                ->orderBy('rating','desc')
                                ->groupBy('product_id')                                
                                ->get()
                                ->toArray(); */



        
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



        // $pavgrating ="round(AVG(".$reviewmodel.".rating),0) as avg_rating";
        $pavgrating ="AVG(".$reviewmodel.".rating) as avg_rating";
        
        $arr_product = DB::table($reviewmodel)->select(DB::raw($prodmodel.'.*,'                                              .$prefix_product_images.'.image as image,'
                                                          .$pavgrating
                                                        ))                               
                                ->leftJoin($prodmodel,$prodmodel.'.id','=',$prefix_reviewtable.'.product_id')
                                ->leftJoin($prefix_product_images,$prefix_product_images.'.product_id','=',$prodmodel.'.id')
                                ->where($prefix_productable.'.is_active','1')
                                ->where($prefix_productable.'.is_approve','1')
                                ->groupBy($prefix_reviewtable.'.product_id') 
                               // ->havingRaw('AVG(product_rating_review.rating) = ?', [4.5])
                                 ->havingRaw('AVG(product_rating_review.rating) >= ?', [4])
                                 ->havingRaw('AVG(product_rating_review.rating) <= ?', [5])
                                 ->orderBy('avg_rating','desc')
                                ->get();
        if(!empty($arr_product))
        {
            $arr_product = $arr_product->toArray();
        }
                               


        $arr_fav_product  = DB::table($prodmodel)->select(DB::raw($prodmodel.'.*,'.$prefix_product_images.'.image as image'))
                            ->join($prefix_favtable,$prefix_favtable.'.product_id',$prefix_productable.'.id')
                            ->leftJoin($prefix_product_images,$prefix_product_images.'.product_id','=',$prefix_productable.'.id')
                            ->where($prefix_productable.'.is_active','1')
                            ->where($prefix_productable.'.is_approve','1')
                            ->get()->toArray();

        $arr_trending_productids =   DB::table($prefix_order_detail)->select(DB::raw($prefix_order_detail.'.*,'
                                        .$prefix_order_product.'.product_id'
                                    ))
                                    ->leftJoin($prefix_order_product,$prefix_order_product.'.order_id','=',$prefix_order_detail.'.id')    
                                    ->where($prefix_order_detail.'.order_status','1')  
                                   // ->groupBy($prefix_order_detail.'.order_no')                            
                                    ->get()->toArray();      



        if(!empty($arr_trending_productids))
        {
            $productids   = array_column($arr_trending_productids, 'product_id');
           /* $arr_trending = $this->ReviewRatingsModel
                            ->with('product_details.product_images_details')
                            ->whereIn('id',$productids)    
                            ->groupBy('product_id')
                            ->get()->toArray(); */

             $p_avgrating  ="AVG(".$reviewmodel.".rating) as avg_rating";        
             $arr_trending = DB::table($reviewmodel)->select(DB::raw($prodmodel.'.*,'                                              .$prefix_product_images.'.image as image,'
                                                          .$pavgrating
                                                        ))                               
                                ->leftJoin($prodmodel,$prodmodel.'.id','=',$prefix_reviewtable.'.product_id')
                                ->leftJoin($prefix_product_images,$prefix_product_images.'.product_id','=',$prodmodel.'.id')
                                ->where($prefix_productable.'.is_active','1')
                                ->where($prefix_productable.'.is_approve','1')
                                ->whereIn($prefix_reviewtable.'.product_id',$productids)    
                                ->groupBy($prefix_reviewtable.'.product_id') 
                                 ->havingRaw('AVG(product_rating_review.rating) >= ?', [4])
                                 ->havingRaw('AVG(product_rating_review.rating) <= ?', [5])
                                 ->orderBy('avg_rating','desc')
                                ->get();                 

        }                          

         $arr_product_news = $this->ProductNewsModel->where('is_active','1')
                                   // ->limit('3')
                                    ->orderBy('id','desc')
                                    ->get()->toArray();                   

         $arr_featured_category = $this->FirstLevelCategoryModel
                                    ->where('is_featured','1')
                                    ->where('is_active','1')
                                    ->limit('4')
                                    ->get()->toArray();

        /*select all featured Brands from brands table*/
        $arr_featured_brands = $this->BrandModel
                                    ->where('is_active','1')
                                    ->get()->toArray();
        /*end*/

        if(isset($arr_product_news) && count($arr_product_news)>0){
            foreach ($arr_product_news as $key => $data) {
                $url = isset($data['video_url'])&&$data['video_url']!=""?$data['video_url']:false;

                if($url!=false){
                    $tmp_arr = explode("?v=", $url);
                    $url_id = isset($tmp_arr[1])?$tmp_arr[1]:'';

                    $arr_product_news[$key]['url_id'] = $url_id;
                }
            }
        }

        // dd($arr_product_news);

        $this->arr_view_data['arr_product'] =  isset($arr_product)?$arr_product:[];
        $this->arr_view_data['arr_fav_product'] =  isset($arr_fav_product)?$arr_fav_product:[];
        $this->arr_view_data['arr_product_news'] = isset($arr_product_news)?$arr_product_news:[];
        $this->arr_view_data['arr_featured_category'] = isset($arr_featured_category)?$arr_featured_category:[];
        $this->arr_view_data['arr_trending'] = isset($arr_trending)?$arr_trending:[];
        $this->arr_view_data['arr_featured_brands'] = isset($arr_featured_brands)?$arr_featured_brands:[];

        // dd($this->arr_view_data);
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    private function getPercentageChange($oldNumber, $newNumber){
        $decreaseValue = $oldNumber - $newNumber;

        return ($decreaseValue / $oldNumber) * 100;
    }


    public function set_guest_url(Request $request)
    {


        $url = $request->get('guest_link');
        //dd($url);
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
    
    /*
        get_trade_detail() - When buyer click on buy button from index view then get the details of particular trade and pass data in json format
    */
    public function get_trade_detail(Request $request)
    {   
        $arr_trade = [];

        $id  = $request->input('trade_id');
        
        $obj_trade = $this->ProductModel->where('id',$id)
                          ->first();

        if($obj_trade)
        {
            $arr_trade = $obj_trade->toArray();
            //dd(floatval($arr_trade['minimum_quantity']));

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

                            //->where($prefixed_trade_table.'.trade_type','1')
                            //->where($prefixed_trade_table.'.order_status','!=','2')
                            //->where($prefixed_trade_table.'.trade_status','0')
                            //->where($prefixed_trade_table.'.is_crypto_trade','0')
                            //->where($prefixed_trade_table.'.is_active','1')
                            ->where($prefixed_second_level.'.is_active','1')
                            ->whereNull($prefixed_trade_table.'.deleted_at') 
                            ->orderBy($prefixed_trade_table.'.created_at','DESC'); 


            /****************************Filtering Logic START*****************************************/
                // dd($request->all());

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
                                                         // ->where('is_visible','1')
                                                         ->get()->toArray();

        $current_date   = date('Y-m-d');//curret date time        
        $yesterday_date = date('Y-m-d',strtotime('last day'));// 24 hours before date (1 day)
        $last_date      = date('Y-m-d',strtotime('-2 day'));// 2 days before date 
        
        // dd($current_date,$yesterday_date,$last_date);

        foreach ($slider_cat_arr as $outerkey => $category) 
        {
            $valume = 0;
            //calculate avarage sell quantity since 24 hours
            // $current_avarage_volume = $this->TradeModel->where('second_level_category_id',$category['id'])
            //                                 ->whereIn('trade_status',[3,4])//buyer completed trade or payment
            //                                 ->whereDate('updated_at','>=',$yesterday_date)
            //                                 ->where('trade_type','0')
            //                                 ->where('linked_to','!=',NULL)
            //                                 ->avg('quantity');
            $avarage_volume_arr = $this->ProductModel
                                            ->where('second_level_category_id',$category['id'])
                                            // ->whereIn('trade_status',[3,4])//buyer completed trade or payment
                                            //->where('trade_type','1')
                                            
                                            ->get()->toArray();


            $available_qty = [];
            // if(count($avarage_volume_arr)>0)
            // {
            //     foreach ($avarage_volume_arr as $key => $value) 
            //     {
            //         if($value['sold_out_qty']>0)
            //         {
            //             $available_qty[$key] = $value['quantity'] - $value['sold_out_qty'];
            //         }
            //         else
            //         {
            //             $available_qty[$key] = $value['quantity'];
            //         }
            //     }
            // }   


            $valume = array_sum($available_qty);

            //calculate current unit price since last 24 hour
             // $current_avg_unit_price = $this->TradeModel
             //                                ->where('second_level_category_id',$category['id'])
             //                                ->whereDate('updated_at','>=',$yesterday_date)
             //                                ->where('trade_type','0')
             //                                ->where('linked_to','!=',NULL)
             //                                ->avg('unit_price');
             $current_avg_unit_price = $this->ProductModel
                                            ->where('second_level_category_id',$category['id'])
                                            ->where('is_active','1')
                                            // ->whereNull('linked_to')
                                            // ->where('is_crypto_trade','0') 
                                            // ->where('trade_status',[0,1])                 
                                            ->avg('unit_price');

            $last_day_record_arr = [];
            // dd($current_avg_unit_price,$category['id']);
            // $last_day_record_obj = $this->TradeBuyHistoryModel->where('category_id',$category['id'])
            //                                               ->whereBetween('created_at',[$last_date, $yesterday_date])  
            //                                               ->first();
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
            // dd($last_day_avg_unit_price,$current_avg_unit_price);

            // $percentChange = (1 - $last_day_avg_unit_price / $current_avg_unit_price) * 100;
            // $percentChange = $this->percent_change($current_avg_unit_price,$last_day_avg_unit_price);
            
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
        
        // $this->arr_view_data['graph_data']      = json_encode($graph_data);
        
       
        //dd($this->arr_view_data);
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

                            // return floatval($data->minimum_quantity).' '.$data->unit;
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
                            // dd(isset($logged_in_user_type),$logged_in_user_type,$logged_in_user_id);

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

        // $rating_table           = $this->TradeRatingModel->getTable();
        // $prefixed_rating        =  DB::getTablePrefix().$this->TradeRatingModel->getTable();  

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
                            // $prefixed_rating.'.points'

                                  
                        ))

                        ->leftjoin($prefixed_first_level,$prefixed_first_level.'.id','=',$prefixed_trade_table.'.first_level_category_id')

                        ->leftjoin($prefixed_second_level,$prefixed_second_level.'.id','=',$prefixed_trade_table.'.second_level_category_id')
                        
                        ->leftjoin($prefixed_unit,$prefixed_unit.'.id','=',$prefixed_trade_table.'.unit_id')

                        ->leftjoin($prefixed_user,$prefixed_user.'.id','=',$prefixed_trade_table.'.user_id')

                        ->leftjoin($prefixed_user_location,$prefixed_user_location.'.user_id','=',$prefixed_trade_table.'.user_id')

                        // ->leftjoin($rating_table,$prefixed_rating.'.trade_id','=',$prefixed_trade_table.'.id')

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
                    // dd($logged_in_user_id);
                    /*Check is seller switch for first time*/

                    $get_isquestions_check = $this->UserModel->where('id',$logged_in_user_id)->first();

                    if(isset($get_isquestions_check) && $get_isquestions_check['is_check_seller_question'] == 0)
                    {
                        // dd(123131);

                        Session::put('seller_question_check',$logged_in_user_id);

                        // $this->arr_view_data['logged_in_user_id'] = $logged_in_user_id;
                        // return view($this->module_view_folder.'.seller.questions',$this->arr_view_data);
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
                                                         // ->where('is_visible','1')
                                                         ->get()->toArray();

        $current_date   = date('Y-m-d');//curret date time        
        $yesterday_date = date('Y-m-d',strtotime('last day'));// 24 hours before date (1 day)
        $last_date      = date('Y-m-d',strtotime('-2 day'));// 2 days before date 
        
        // dd($current_date,$yesterday_date,$last_date);

        foreach ($slider_cat_arr as $key => $category) 
        {
            //calculate avarage sell quantity since 24 hours
            $current_avarage_volume = $this->TradeModel
                                            ->where('second_level_category_id',$category['id'])
                                            ->whereIn('trade_status',[3,4])//buyer completed trade or payment
                                            // ->whereDate('updated_at','>=',$yesterday_date)
                                            ->where('trade_type','0')
                                            ->where('linked_to','!=',NULL)
                                            ->where('is_crypto_trade','0')
                                            ->limit(10)
                                            ->orderBy('id','DESC')
                                            ->avg('quantity');

            //calculate current unit price since last 24 hour
             $current_avg_unit_price = $this->TradeModel
                                            ->where('second_level_category_id',$category['id'])
                                            // ->whereDate('updated_at','>=',$yesterday_date)
                                            ->where('trade_type','0')
                                            ->where('linked_to','!=',NULL)
                                            ->where('is_crypto_trade','0')
                                            ->limit(10)
                                            ->orderBy('id','DESC')
                                            ->avg('unit_price');

            $last_day_record_arr = [];

            // $last_day_record_obj = $this->TradeBuyHistoryModel
            //                                             ->where('category_id',$category['id'])
            //                                             ->whereBetween('created_at',[$last_date, $yesterday_date])  
            //                                             ->first();
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
        
    }
}
