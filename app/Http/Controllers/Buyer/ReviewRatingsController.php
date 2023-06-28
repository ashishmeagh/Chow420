<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\CountriesModel;
use App\Models\BuyerModel;
use App\Models\ProductModel;
use App\Models\FavoriteModel;
use App\Models\ReviewRatingsModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\MoneyBackModel;

use App\Common\Services\GeneralService;

use App\Common\Services\EmailService;
use App\Models\EventModel;
use App\Models\BuyerWalletModel;
use App\Models\SiteSettingModel;
use App\Models\ReportedEffectsModel;



use Validator;
use Flash;
use Sentinel;
use Hash;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
 
class ReviewRatingsController extends Controller
{

    public function __construct(
                                ProductModel $ProductModel,
                                FavoriteModel $FavoriteModel,
                                UserModel $user,
                                CountriesModel $CountriesModel,
                                BuyerModel $BuyerModel,
                                ActivityLogsModel $activity_logs,
                                ReviewRatingsModel $review_ratings,
                                OrderModel $OrderModel,
                                OrderProductModel $OrderProductModel,
                                GeneralService $GeneralService,
                                EmailService $EmailService,
                                EventModel $EventModel,
                                MoneyBackModel $MoneyBackModel,
                                BuyerWalletModel $BuyerWalletModel,
                                SiteSettingModel $SiteSettingModel,
                                ReportedEffectsModel $ReportedEffectsModel

                               )
    {
        $this->ProductModel       = $ProductModel;   
        $this->FavoriteModel      = $FavoriteModel;
        $this->ReviewRatingsModel = $review_ratings;
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;
        $this->ActivityLogsModel  = $activity_logs;
        $this->CountriesModel     = $CountriesModel;
        $this->BuyerModel         = $BuyerModel;
        $this->OrderModel         = $OrderModel;
        $this->OrderProductModel  = $OrderProductModel;
        $this->GeneralService     = $GeneralService;
        $this->OrderProductModel  = $OrderProductModel;   
        $this->MoneyBackModel     = $MoneyBackModel;

        $this->EmailService       = $EmailService;
        $this->EventModel         = $EventModel;
        $this->BuyerWalletModel   = $BuyerWalletModel;
        $this->SiteSettingModel   = $SiteSettingModel;
        $this->ReportedEffectsModel = $ReportedEffectsModel;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        
        $this->product_image_base_img_path   = base_path().config('app.project.img_path.product_images');
        $this->product_image_public_img_path = url('/').config('app.project.img_path.product_images');

        $this->module_title       = "Review Ratings";
        $this->module_view_folder = "buyer/review-ratings";

        $this->id_proof_public_path = url('/').config('app.project.id_proof');
        $this->id_proof_base_path   = base_path().config('app.project.id_proof');
        
        $this->module_icon        = "fa-cogs";
        $this->age_Restriction_arr=[];
    }


    public function index(Request $request,$order_id="")
    {
      
     
      $user        = sentinel::check();
      $user_id     = "";
      if($user)
      {  
        $user_id   = $user->id; 
      }

      if($order_id!="")
      {
        $order_id    =  base64_decode($order_id);
        $products    =  $this->OrderProductModel->where('order_id',$order_id)->select('product_id')->groupBy('product_id')->get()->toArray();
        $product_arr = $this->ProductModel
                     ->whereIn('id',$products)
                     ->with('first_level_category_details',
                         'second_level_category_details',
                         'product_images_details',
                         'age_restriction_detail',
                         'get_brand_detail',
                         'get_seller_details.seller_detail',
                         'get_seller_details.get_country_detail', 
                         'get_seller_details.get_state_detail', 
                         'first_level_category_details',
                         'first_level_category_details.age_restriction_detail')

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
                     ->get()
                     ->toArray();
      }

      else
      {  
        $order_ids   = $this->OrderModel->where('buyer_id',$user_id)->where('order_status','1')->select('id')->get()->toArray();
        $products    =  $this->OrderProductModel->whereIn('order_id',$order_ids)->select('product_id')->groupBy('product_id')->get()->toArray();
        $product_arr = $this->ProductModel
                  ->whereIn('id',$products)
                  ->with('first_level_category_details',
                    'second_level_category_details',
                    'product_images_details',
                    'age_restriction_detail',
                    'get_brand_detail',
                    'get_seller_details.seller_detail',
                    'get_seller_details.get_country_detail', 
                    'get_seller_details.get_state_detail', 
                    'first_level_category_details',
                    'first_level_category_details.age_restriction_detail')
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
                   ->get()
                   ->toArray();
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

         $paginator = $this->get_pagination_data($product_arr, $pageStart, 8 , $apppend_data);

        if($paginator)
        {
            $pagination_links    =  $paginator;  
            $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 

        }//if


        //get reported effects 

         $get_reported_effects = $this->ReportedEffectsModel->where('is_active','1')->get(); 
         if(isset($get_reported_effects) && !empty($get_reported_effects))
         {
           $get_reported_effects = $get_reported_effects->toArray();
         }  

        $arr_pagination = $paginator; 
        $this->arr_view_data['arr_pagination'] = $arr_pagination;
        $this->arr_view_data['page_title']      = $this->module_title;
       // $this->arr_view_data['product_arr']     = $product_arr;
        $this->arr_view_data['product_arr']     = $arr_data;
        $this->arr_view_data['img_path']        = $this->product_image_base_img_path;
        $this->arr_view_data['fav_product_arr'] = $this->FavoriteModel->where('buyer_id',$user_id)->select('product_id')->get()->toArray();

        $this->arr_view_data['get_reported_effects'] = isset($get_reported_effects)?$get_reported_effects:[];
       return view($this->module_view_folder.'.index',$this->arr_view_data);

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
    }



    public function store(Request $request)
    {

        $form_data = $request->all();

        $arr_rules = [
                       'rating'    =>'required',
                       'title'     =>'required',
                       'review'    =>'required'
                     ];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Form validation failed..Please check all fields..';

            return response()->json($response);
        }

        $is_refered_buyer =0;

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;     

            $is_refered_buyer = Sentinel::check()->is_refered_buyer;       
        }

        $product_id = isset($form_data['product_id'])?$form_data['product_id']: '';


        $rating       = isset($form_data['rating'])?$form_data['rating']:'';
        $title        = isset($form_data['title'])?$form_data['title']:'';
        $review       = isset($form_data['review'])?$form_data['review']:'';
        $emojiarr     = isset($form_data['emoji'])?$form_data['emoji']:'';

        if(isset($emojiarr) && !empty($emojiarr))
        {
          $emojiarr = implode(",", $emojiarr);
        }


        $input_data = [
                        'product_id'     => $product_id,
                        'buyer_id'       => $user_id,
                        'rating'         => $rating,
                        'title'          => $title,
                        'review'         => $review,
                        'emoji'          => $emojiarr 
                        
                      ];
                      
        $add_review = $this->ReviewRatingsModel->create($input_data);

        $buyer_referal_review_amount =0;
        $site_setting_arr = [];
        $site_setting_obj = SiteSettingModel::first();  
        if(isset($site_setting_obj))
        {
          $site_setting_arr = $site_setting_obj->toArray();            
        }
        if(isset($site_setting_arr) && count($site_setting_arr)>0)
        {
           $buyer_referal_review_amount = isset($site_setting_arr['buyer_review_amount'])?$site_setting_arr['buyer_review_amount']:config('app.project.buyer_review_amount');

        } // if site_setting_arr       


        if($add_review)
        {




            /****************Send Notification (START)*****************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = $seller_fname = $seller_lname = $eventuser = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    if($user_details->first_name=="" || $user_details->last_name=="")
                    {
                     $user_name    = $user_details->email;
                     $eventuser    = $user_details->email;

                    }else{
                      $user_name    = $user_details->first_name.' '.$user_details->last_name;
                      $eventuser    = $user_details->first_name;

                    }
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);

                $get_product_name = $this->ProductModel
                                         //->select('product_name','user_id')
                                         ->with(['get_seller_details','product_images_details'])
                                         ->where('id',$product_id)
                                         ->first();


                if(!empty($get_product_name) && isset($get_product_name))
                {
                    $get_product_name = $get_product_name->toArray();
                    
                    $product_name = isset( $get_product_name['product_name'])?$get_product_name['product_name']:'';
                    $seller_id = isset( $get_product_name['user_id'])?$get_product_name['user_id']:'';

                    $seller_fname = isset($get_product_name['get_seller_details']['first_name'])?$get_product_name['get_seller_details']['first_name']:'';
                    $seller_lname = isset($get_product_name['get_seller_details']['last_name'])?$get_product_name['get_seller_details']['last_name']:'';
                    
                    $rating_review_url = url('/').'/'.config('app.project.admin_panel_slug').'/product/Reviews/'.base64_encode($product_id);

                    /**********Send Notification to Admin (START)****************/
                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $from_user_id;
                        $arr_event['to_user_id']   = $admin_id;
                        $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product <a target="_blank" href="'.$rating_review_url.'"><b>'.$product_name.'</b></a>');
                        $arr_event['type']         = '';
                        $arr_event['title']        = 'Product Ratings & Reviews';
                        $this->GeneralService->save_notification($arr_event);
                    /*************Send Notification to Admin (END)*****************/

                    /************Send Mail Notification to Admin (START)*************/
                       // $msg    = html_entity_decode('<b>'.$user_name.'</b> has added the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product <b>'.$product_name.'</b>');
                       
                       // $subject     = 'Product Ratings & Reviews';

                        $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                              'APP_NAME'      => config('app.project.name'),
                                             // 'MESSAGE'       => $msg,
                                              'URL'           => $rating_review_url,
                                              'BUYER_NAME'    => $user_name,
                                              'REVIEW'        => $review,
                                              'RATING'        => $rating,
                                              'PRODUCT_NAME'  => $product_name
                                             ];

                        $arr_mail_data['email_template_id'] = '58';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($admin_id);

                        $this->EmailService->send_mail_section($arr_mail_data);         

                    /************Send Mail Notification to Admin (END)***************/


                    $seller_rating_review_url = url('/').'/search/product_detail/'.base64_encode($product_id);

                    /************Send Notification to Seller(START)*****************/
                        $arr_event_seller          = [];
                        $arr_event_seller['from_user_id'] = $from_user_id;
                        $arr_event_seller['to_user_id']   = $seller_id;
                        $arr_event_seller['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product <a target="_blank" href="'.$seller_rating_review_url.'"><b>'.$product_name.'</b></a>');
                        $arr_event_seller['type']         = '';
                        $arr_event_seller['title']        = 'Product Ratings & Reviews';
                        $this->GeneralService->save_notification($arr_event_seller);
                    /**************Send Notification to Seller(END)******************/


                    /**********Send Mail Notification to Seller (START)****************/
                       // $msg    = html_entity_decode('<b>'.$user_name.'</b> has added the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product <b>'.$product_name.'</b>');
                       
                        $subject     = 'Product Ratings & Reviews';

                        $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                              'APP_NAME'      => config('app.project.name'),
                                              //'MESSAGE'       => $msg,
                                              'URL'           => $seller_rating_review_url,
                                              'BUYER_NAME'    => $user_name,
                                              'REVIEW'        => $review,
                                              'RATING'        => $rating,
                                              'PRODUCT_NAME'  => $product_name
                                             ];

                        $arr_mail_data['email_template_id'] = '58';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($seller_id);

                        $this->EmailService->send_mail_section($arr_mail_data);  

                    /**********Send Mail Notification to Seller (END)******************/

                         /***********Add Event data*for review****/
                          $arr_eventdata             = [];
                          $arr_eventdata['user_id']  = $from_user_id;
                          // $arr_eventdata['message']  = html_entity_decode('<b>'.$user_name.'</b> has added the review <b>'.$review.'</b> with rating <b>'.$rating.' stars</b> for the product <a target="_blank" href="'.$seller_rating_review_url.'"><b>'.$product_name.'</b></a>');
                           // $arr_eventdata['message']  = html_entity_decode('<b>'.$user_name.'</b> adds a new review on '.$product_name.'.<div class="clearfix"></div> <a target="_blank" href="'.$seller_rating_review_url.'" class="viewcls">View</a>');

                           if(!empty($get_product_name['product_images_details']) 
                                         && count($get_product_name['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image']) 
                                    && $get_product_name['product_images_details'][0]['image']!='')
                           {
                              /*$imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];*/

                              //image resize
                              $imgsrc = image_resize('/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'],35,35);

                           }else{
                            $imgsrc = url('/').'/assets/front/images/chow.png';
                           }



                           $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                              <div class="mainmarqees-image">
                                 <img src="'.$imgsrc.'" alt="Image">
                               </div><b> Someone </b> added a new review on '.$product_name.'.<div class="clearfix"></div></div> <a target="_blank" href="'.$seller_rating_review_url.'" class="viewcls">View</a>');

                          $arr_eventdata['title']    = 'Product Ratings & Reviews';                       
                          $this->EventModel->create($arr_eventdata);
                        /*********end of add event**for review*******************/



                }//if product name    
               
            /****************Send Notification (END)*****************************/



            //if(isset($is_refered_buyer) && $is_refered_buyer!=0)
            //{
                  $buyer_wallet_arr = [];
                  $buyer_wallet_arr['user_id'] = $from_user_id;
                  $buyer_wallet_arr['type'] = 'Review';
                  $buyer_wallet_arr['amount'] = '+'.$buyer_referal_review_amount;
                  $buyer_wallet_arr['typeid'] = $add_review->id;
                  $buyer_wallet_arr['status'] = 1;
                  $this->BuyerWalletModel->create($buyer_wallet_arr);

                /************Send Notification to referred Buyer(START)*****************/
                 $buyerwallet_url = url('/').'/buyer/buyer-wallet/';
                    $arr_event_seller          = [];
                    $arr_event_seller['from_user_id'] = $admin_id;
                    $arr_event_seller['to_user_id']   = $from_user_id;
                    $arr_event_seller['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product '.$product_name.'. '.$buyer_referal_review_amount.' amount is credited into your wallet. <a target="_blank" href="'.
                      $buyerwallet_url.'"><b>'.$product_name.'</b></a>');
                    $arr_event_seller['type']         = '';
                    $arr_event_seller['title']        = 'Product Ratings & Reviews Wallet Amount Credited';
                    $this->GeneralService->save_notification($arr_event_seller);

                /**************Send email to buyer(END)******************/
                     

                      $subject     = 'Product Ratings & Reviews Wallet Amount Credited';

                      $arr_built_content = ['USER_NAME'     => $user_name,
                                            'APP_NAME'      => config('app.project.name'),
                                            //'MESSAGE'       => $msg,
                                            'URL'           => $buyerwallet_url,
                                            'BUYER_NAME'    => $user_name,
                                            'REVIEW'        => $review,
                                            'RATING'        => $rating,
                                            'PRODUCT_NAME'  => $product_name,
                                            'REVIEW_WALLET_AMOUNT'=> '$'.$buyer_referal_review_amount
                                           ];

                      $arr_mail_data['email_template_id'] = '149';
                      $arr_mail_data['arr_built_content'] = $arr_built_content;
                      $arr_mail_data['arr_built_subject'] = '';
                      $arr_mail_data['user']              = Sentinel::findById($from_user_id);


                      $this->EmailService->send_mail_section($arr_mail_data);  


                    /************Send Notification to admin(START)*****************/
                    $arr_event_seller          = [];
                    $arr_event_seller['from_user_id'] = $from_user_id;
                    $arr_event_seller['to_user_id']   = $admin_id;
                    $arr_event_seller['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product'.$product_name.'. '.$buyer_referal_review_amount.' amount is credited to wallet.<b>'.$product_name.'</b></a>');
                    $arr_event_seller['type']         = '';
                    $arr_event_seller['title']        = 'Product Ratings & Reviews Wallet Amount Credited';
                    $this->GeneralService->save_notification($arr_event_seller);

                    /**************Send email to admin(END)******************/
                      $adminwallet_url = url('/').config('app.project.admin_panel_slug').'/buyers/';

                      $subject     = 'Product Ratings & Reviews Wallet Amount Credited';

                      $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                            'APP_NAME'      => config('app.project.name'),
                                            //'MESSAGE'       => $msg,
                                            'URL'           => $adminwallet_url,
                                            'BUYER_NAME'    => $user_name,
                                            'REVIEW'        => $review,
                                            'RATING'        => $rating,
                                            'PRODUCT_NAME'  => $product_name,
                                            'REVIEW_WALLET_AMOUNT'=> '$'.$buyer_referal_review_amount
                                           ];

                      $arr_mail_data['email_template_id'] = '150';
                      $arr_mail_data['arr_built_content'] = $arr_built_content;
                      $arr_mail_data['arr_built_subject'] = '';
                      $arr_mail_data['user']              = Sentinel::findById($admin_id);

                      $this->EmailService->send_mail_section($arr_mail_data);  




           // } // is_refered_buyer





            $response['status']      = 'SUCCESS';
            $response['description'] = 'Review added successfully.';
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to send review...Please try again.';
        }

        return response()->json($response);

    }


    public function get_review_details(Request $request)
    {

        $form_data = $request->all();
        $star="";
       
        // dd($form_data);

        $product_id = isset($form_data['product_id'])?$form_data['product_id']: '';

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;            

            $review_details = $this->ReviewRatingsModel->with('product_details.first_level_category_details','product_details.product_images_details')->where('product_id',$product_id)
            ->where('buyer_id',$user_id)
            ->first();

            if($review_details)
            {
              $review_details= $review_details->toArray();   
            } 
        }
        else
        {
            $review_details = $this->ReviewRatingsModel->with('product_details.first_level_category_details','product_details.product_images_details')->where('product_id',$product_id)
            ->first();

             if($review_details)
            {
              $review_details= $review_details->toArray();   
            } 
        }

        if(count($review_details)>0)
        {
            // if($review_details['rating']==1)
            // {$star = "one";}
            // else if($review_details['rating']==2)
            // {$star = "two";}
            // else if($review_details['rating']==3)
            // {$star = "three";}
            // else if($review_details['rating']==4)    
            // {$star = "four";}
            // else if($review_details['rating']==5)    
            // {$star = "five";}
            // else if($review_details['rating']==0.5)    
            // {$star = "zeropointfive";}
            // else if($review_details['rating']==1.5)    
            // {$star = "onepointfive";}
            // else if($review_details['rating']==2.5)    
            // {$star = "twopointfive";}
            // else if($review_details['rating']==3.5)    
            // {$star = "threepointfive";}
            // else if($review_details['rating']==4.5)    
            // {$star = "fourpointfive";} 

            $star = isset($review_details['rating'])?get_avg_rating_image($review_details['rating']):'';


            $response['rating']       = $star;
            $response['ratingval']    = $review_details['rating'];
            $response['review_id']    = $review_details['id'];
            $response['review']       = $review_details['review'];
            $response['title']        = $review_details['title'];
            $response['product_name'] = $review_details['product_details']['product_name'];
            $response['product_price']= $review_details['product_details']['unit_price'];
            $response['category_name']= $review_details['product_details']['first_level_category_details']['product_type'];
           // $response['product_image']= $review_details['product_details']['product_image'];

            $response['product_image']= isset($review_details['product_details']['product_images_details'][0]['image'])?$review_details['product_details']['product_images_details'][0]['image']:'';

          //  $response['emoji']    = isset($review_details['emoji'])?$review_details['emoji']:'';

            $effect_emoji ='';  $effect_emojiarr = [];
            if(isset($review_details['emoji']) && !empty($review_details['emoji']))
            {
              $exploded_effects = explode(",", $review_details['emoji']);
              foreach($exploded_effects as $k=>$v)
              {
                $get_reviewimge = $this->ReportedEffectsModel->where('id',$v)->first();
                if(isset($get_reviewimge) && !empty($get_reviewimge))
                {
                   $get_reviewimge = $get_reviewimge->toArray();
                   $effectimage = $get_reviewimge['image'];
                   $effect_emojiarr[$k]['image'] = $effectimage;
                   $effect_emojiarr[$k]['title'] = $get_reviewimge['title'];
                   $effect_emojiarr[$k]['id'] = $get_reviewimge['id'];

                }//isset($get_reviewimge)

              }//foreach
            }//isset($review_details['emoji']

            $effect_emoji = json_encode($effect_emojiarr);
            $response['emoji']    = isset($effect_emoji)?$effect_emoji:'';

            $response['status']      = 'SUCCESS';
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to view Review...Please try again.';
        }

        return response()->json($response);

    }



    //update review function
    public function update(Request $request)
    {

        $form_data = $request->all();
        
       // dd($form_data);    
        
        $arr_rules = [
        //               'rating_modal'    =>'required',
                       'title'     =>'required',
                       'review'    =>'required'
                     ];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Form validation failed..Please check all fields..';

            return response()->json($response);
        }

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;            
        }

        $product_id = isset($form_data['product_id_modal'])?$form_data['product_id_modal']: '';
        $rating       = isset($form_data['rating_modal'])?$form_data['rating_modal']:'';
        $title        = isset($form_data['title'])?$form_data['title']:'';
        $review       = isset($form_data['review'])?$form_data['review']:'';
        $review_id    = isset($form_data['review_id'])?$form_data['review_id']:'';

        $emojiarr     = isset($form_data['emoji'])?$form_data['emoji']:'';

        if(isset($emojiarr) && !empty($emojiarr))
        {
          $emojiarr = implode(",", $emojiarr);
        }

        $input_data = [
                       // 'product_id'     => $product_id,                     
                        'rating'         => $rating,
                        'title'          => $title,
                        'review'         => $review,
                        'emoji'          => $emojiarr
                        
                      ];



                      
        $update_review = $this->ReviewRatingsModel
                                ->where('id',$review_id)
                                ->where('product_id',$product_id)
                                ->where('buyer_id',$user_id)
                                ->update($input_data);

        if($update_review)
        {

            /****************Send Notification (START)*****************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = $seller_fname = $seller_lname = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;

                     $user_name ='';   

                     if($user_details->user_type=="buyer")
                     {
                        if($user_details->first_name=="" || $user_details->last_name==""){
                             $user_name ='Buyer';
                        }else{
                             $user_name = $user_details->first_name.' '.$user_details->last_name;
                        }
                     }
                     else if($user_details->user_type=="seller")
                     {
                        if($user_details->first_name=="" || $user_details->last_name==""){
                             $user_name ='Dispensary';
                        }else{
                             $user_name = $user_details->first_name.' '.$user_details->last_name;
                        }
                     }

                   // $user_name    = $user_details->first_name.' '.$user_details->last_name;
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);

                $get_product_name = $this->ProductModel
                                         ->select('product_name','user_id')
                                         ->with(['get_seller_details'])
                                         ->where('id',$product_id)
                                         ->first();

                if(!empty($get_product_name) && isset($get_product_name))
                {
                    $get_product_name = $get_product_name->toArray();
                    $product_name = isset( $get_product_name['product_name'])?$get_product_name['product_name']:'';
                    $seller_id = isset( $get_product_name['user_id'])?$get_product_name['user_id']:'';

                    $seller_fname = isset($get_product_name['get_seller_details']['first_name'])?$get_product_name['get_seller_details']['first_name']:'';
                    $seller_lname = isset($get_product_name['get_seller_details']['last_name'])?$get_product_name['get_seller_details']['last_name']:'';
                    
                    $rating_review_url = url('/').'/'.config('app.project.admin_panel_slug').'/product/Reviews/'.base64_encode($product_id);

                    /**********Send Notification to Admin (START)****************/
                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $from_user_id;
                        $arr_event['to_user_id']   = $admin_id;
                        $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has updated the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product <a target="_blank" href="'.$rating_review_url.'"><b>'.$product_name.'</b></a>');
                        $arr_event['type']         = '';
                        $arr_event['title']        = 'Product Ratings & Reviews Updated';
                        $this->GeneralService->save_notification($arr_event);
                    /*************Send Notification to Admin (END)*****************/

                    /************Send Mail Notification to Admin (START)*************/
                       // $msg    = html_entity_decode('<b>'.$user_name.'</b> has updated the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product <b>'.$product_name.'</b>');
                       
                       // $subject     = 'Product Ratings & Reviews Updated';

                        $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                              'APP_NAME'      => config('app.project.name'),
                                              //'MESSAGE'       => $msg,
                                              'URL'           => $rating_review_url,
                                              'BUYER_NAME'    => $user_name,
                                              'REVIEW'        => $review,
                                              'RATING'        => $rating,
                                              'PRODUCT_NAME'  => $product_name
                                             ];

                        $arr_mail_data['email_template_id'] = '60';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($admin_id);

                        $this->EmailService->send_mail_section($arr_mail_data);         

                    /************Send Mail Notification to Admin (END)***************/


                    $seller_rating_review_url = url('/').'/search/product_detail/'.base64_encode($product_id);

                    /************Send Notification to Seller(START)*****************/
                        $arr_event_seller          = [];
                        $arr_event_seller['from_user_id'] = $from_user_id;
                        $arr_event_seller['to_user_id']   = $seller_id;
                        $arr_event_seller['description']  = html_entity_decode('<b>'.$user_name.'</b> has updated the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product <a target="_blank" href="'.$seller_rating_review_url.'"><b>'.$product_name.'</b></a>');
                        $arr_event_seller['type']         = '';
                        $arr_event_seller['title']        = 'Product Ratings & Reviews Updated';
                        $this->GeneralService->save_notification($arr_event_seller);
                    /**************Send Notification to Seller(END)******************/


                    /**********Send Mail Notification to Seller (START)****************/
                      //  $msg    = html_entity_decode('<b>'.$user_name.'</b> has updated the review "<b>'.$review.'</b>" with rating <b>'.$rating.' stars</b> for the product <b>'.$product_name.'</b>');
                       
                      //  $subject     = 'Product Ratings & Reviews Updated';

                        $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                              'APP_NAME'      => config('app.project.name'),
                                             // 'MESSAGE'       => $msg,
                                              'URL'           => $seller_rating_review_url,
                                              'BUYER_NAME'    => $user_name,
                                              'REVIEW'        => $review,
                                              'RATING'        => $rating,
                                              'PRODUCT_NAME'  => $product_name

                                             ];

                        $arr_mail_data['email_template_id'] = '60';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($seller_id);

                        $this->EmailService->send_mail_section($arr_mail_data);  

                    /**********Send Mail Notification to Seller (END)******************/

                }    
               
            /****************Send Notification (END)*****************************/

            $response['status']      = 'SUCCESS';
            $response['description'] = 'Review Updated successfully.';
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to update review...Please try again.';
        }

        return response()->json($response);

    }


    /*send money back request to the admin*/
    
    public function send_money_back_request(Request $request)
    {

       $buyer_id = 0;
       $buyer_name = '';
       $requestd_data = $response = $product_arr = [];


       $user = Sentinel::check();

       if(isset($user))
       {
         $buyer_id   = $user->id; 
         $first_name = $user->first_name;
         $last_name  = $user->last_name;

         $user_name = $first_name.' '.$last_name;

       }

       $product_id            = $request->input('product_id');
       $reported_issue_note   = $request->input('note');

       $requestd_data['buyer_id']                      = $buyer_id;
       $requestd_data['product_id']                    = $product_id;
       $requestd_data['status']                        = 0;
       $requestd_data['note']                          = Null;
       $requestd_data['reported_issue_note']           = $reported_issue_note;

      /*check duplication*/


      $count = $this->MoneyBackModel->where('buyer_id',$buyer_id)
                                    ->where('product_id',$product_id)
                                    ->count();

      if($count > 0)
      {
         $update_arr = [];
         
         $update_arr['status'] = 0;
         $update_arr['note']   = Null;

         $result = $this->MoneyBackModel->where('buyer_id',$buyer_id)
                                        ->where('product_id',$product_id)
                                        ->update($update_arr);
      }
      else
      { 
        
         $result = $this->MoneyBackModel->create($requestd_data);
      }

    
      if($result)
      {
          //send notification to the admin after money back request send

          $admin_role = Sentinel::findRoleBySlug('admin');        
          $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
          if($admin_obj)
          {
              $admin_id = $admin_obj->user_id;            
          }

          $product_details_view_url = url('/').'/book/product/view/'.base64_encode($product_id);

          $arr_event                 = [];
          $arr_event['from_user_id'] = $buyer_id;
          $arr_event['to_user_id']   = $admin_id;
          /*  $arr_event['description']  = 'Buyer '.$user_name.' has sent money back guarantee request for product '.get_product_name($product_id);*/


          $arr_event['description']  = 'Buyer '.$user_name.' has reported issue for product <a target="_blank" href="'.$product_details_view_url.'"><b>'.get_product_name($product_id).'</b></a>';
          $arr_event['type']         = '';
          $arr_event['title']        = 'Report Issue';

          $this->GeneralService->save_notification($arr_event);
      

          //send email for money back request email to admin

          $url = '';

          $url = url('/').'/book/reported_issues_products';

       
          $admin_role = Sentinel::findRoleBySlug('admin');        
          $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
          
          if($admin_obj)
          {
              $admin_id = $admin_obj->user_id;            
          }


          $product_details = $this->MoneyBackModel
                                  ->where('product_id',$product_id)
                                  ->with(['product_details'])
                                  ->first();

          if(isset($product_details))
          {
            $product_arr = $product_details->toArray(); 
          }

          $arr_built_content = [
                                  
                                   'APP_NAME'       => config('app.project.name'),
                                   'PRODUCT_NAME'   => $product_arr['product_details']['product_name'],
                                   'BUYER_NAME'     => $user_name,
                                   'URL'            => $url,
                                   'Reported_Note'  => $reported_issue_note
                              ];

          $arr_mail_data['email_template_id']  = '151';
          $arr_mail_data['arr_built_content']  = $arr_built_content;
          $arr_mail_data['user']               = Sentinel::findById($admin_id);
         
  
          $this->EmailService->send_mail_section($arr_mail_data);


          /*--------------------------------------------------------------------------*/


          $response['status']      = 'success';
          $response['description'] = 'The issue has been reported';

       }
       else
       {
          $response['status']      = 'error';
          $response['description'] = 'Something went wrong,please try again';
       }

        return response()->json($response);
    }

    /*------------------------------------------*/

}
