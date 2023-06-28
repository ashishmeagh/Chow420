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
use App\Common\Services\EmailService;
use App\Common\Services\GeneralService;
use App\Models\EventModel;
use App\Models\FollowModel;


use Validator;
use Sentinel;
use DB;
use Datatables;
use Flash;
use Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class FavoriteProductController extends Controller
{
    public function __construct(
    								ProductModel $ProductModel,
    								FirstLevelCategoryModel $FirstLevelCategoryModel,
                                    SecondLevelCategoryModel $SecondLevelCategoryModel,
    								
    								
                                    UserModel $UserModel,
                                    BuyerModel $BuyerModel,
                                    SellerModel $SellerModel,
                                    FavoriteModel $FavoriteModel,
                                    //ProductService $ProductService,
                                    EmailService $EmailService,
                                    GeneralService $GeneralService,
                                    EventModel $EventModel,
                                    FollowModel $FollowModel
    						   )
    {		
    	  $this->ProductModel         		= $ProductModel;
    	  $this->FirstLevelCategoryModel  = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
        $this->EventModel              = $EventModel;  
    	  $this->FollowModel             = $FollowModel;  
    	
      	$this->BaseModel                = $ProductModel;
        $this->UserModel                = $UserModel;
        $this->BuyerModel               = $BuyerModel;
        $this->SellerModel              = $SellerModel;
        $this->FavoriteModel            = $FavoriteModel;
       // $this->ProductService           = $ProductService;
        $this->EmailService             = $EmailService;
        $this->GeneralService           = $GeneralService;

        $this->module_view_folder         = 'front.product';
        $this->module_url_path            = url('/product');
        $this->back_path                  = url('/').'/product';

        $this->product_image_base_img_path   = base_path().config('app.project.img_path.product_images');
        $this->product_image_public_img_path = url('/').config('app.project.img_path.product_images');
        // $this->shipmentproofs_public_path = url('/').config('app.project.shipment_proofs');
        // $this->shipmentproofs_base_path   = base_path().config('app.project.shipment_proofs');
        $this->module_title               = 'Product';
        $this->arr_view_data              = [];
    }

    public function index()
    {		
    	$user            = sentinel::check();
      $user_id         = $user->id; 
    	$obj_fav_product = $this->FavoriteModel->with('product_details')
                                            ->where('buyer_id',$user_id)
                                            ->get();
        if ($obj_fav_product) {
           $arr_fav_product = $obj_fav_product->toArray();
        }

        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['fav_product_arr'] = $arr_fav_product;
    	  $this->arr_view_data['img_path']        = $this->product_image_base_img_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function view(Request $request)
    {   

      /*******************Restricted states seller id*********************/

       $check_buyer_restricted_states =  get_buyer_restricted_sellers();
       $restricted_state_user_ids = isset($check_buyer_restricted_states['restricted_state_user_ids'])?$check_buyer_restricted_states['restricted_state_user_ids']:[];


       /********************Restricted states seller id***********************/



      /**************check location data**************************/
         $checkuser_locationdata = checklocationdata(); 
         if(isset($checkuser_locationdata) && !empty($checkuser_locationdata))
         {
           $state_user_ids = isset($checkuser_locationdata['state_user_ids'])?$checkuser_locationdata['state_user_ids']:'';
           $catdata =  isset($checkuser_locationdata['catdata'])?$checkuser_locationdata['catdata']:[];
         } 

      /**************end check location data*********************/






      $user        = sentinel::check();
      $user_id     = $user->id; 

      $apppend_data = url()->current();

      if($request->has('page'))
      {    
        $pageStart = $request->input('page'); 
      }
      else
      {
        $pageStart = 1; 
      }

      /*****************************Get Buyer Id Proof Array (START)*************************/
            
            $obj_buyer_id_proof = $this->BuyerModel->where('user_id',$user_id)->first();
            if ($obj_buyer_id_proof) {
                $buyer_id_proof = $obj_buyer_id_proof->toArray();
            }            
      /******************************Get Buyer Id Proof Array (END)**************************/

      /* $obj_fav_product = $this->FavoriteModel->where('buyer_id',$user_id)
                                              ->with('get_product_details.first_level_category_details','get_product_details.second_level_category_details','get_product_details.product_images_details',function($query{
                                                  $query->first();
                                              }))
                                              ->get();*/
 
        $obj_fav_product = $this->FavoriteModel->where('buyer_id',$user_id)
                                                ->with(
                                                        'get_product_details.first_level_category_details',
                                                        'get_product_details.second_level_category_details',
                                                        'get_product_details.product_images_details',
                                                        'get_product_details.get_seller_details.seller_detail',
                                                        'get_product_details.get_brand_detail',
                                                        'get_product_details.inventory_details',
                                                        'get_buyer_details.getproof_detail',
                                                        'get_product_details.age_restriction_detail',
                                                        'get_product_details.first_level_category_details.age_restriction_detail'
                                                      )
                                                      /*->whereHas('get_product_details', function($q){
                                                        $q->where('is_approve',1);
                                                        $q->where('is_active',1);
                                                      })*/
                                                      // ->whereHas('get_product_details', function($q) use($state_user_ids,$catdata){

                                                       ->whereHas('get_product_details', function($q)use($restricted_state_user_ids){ 

                                                        $q->where('is_approve',1);
                                                        $q->where('is_active',1);

                                                         /* if(isset($state_user_ids) && !empty($state_user_ids))
                                                           {
                                                             $q->whereIn('user_id',$state_user_ids);
                                                           }  
                                                          if(isset($catdata) && !empty($catdata))
                                                          {
                                                            $q->whereNotIn('first_level_category_id',$catdata);
                                                          } */ 


                                                          /*if(isset($restricted_state_user_ids) && !empty($restricted_state_user_ids))
                                                           {

                                                             $q->whereIn('user_id',$restricted_state_user_ids);
                                                           }  */

                                                      })  
                                                      ->get();
   

      if($obj_fav_product){

        $fav_product_arr = $obj_fav_product->toArray();
      }

      $total_results = count($fav_product_arr);


        $paginator = $this->get_pagination_data($fav_product_arr, $pageStart, 9 , $apppend_data);


        if($paginator)
        {
            $pagination_links    =  $paginator;  
            $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 
        }   

        if($paginator)
        {

          $arr_user_pagination   =  $paginator;  
          $arr_product           =  $paginator->items();
          $arr_data               = $arr_data;
          $arr_view_data['arr_data']=  $arr_data;
          $arr_view_data['total_results'] = $total_results;
          $arr_pagination = $paginator;

          $this->arr_view_data['arr_data'] =  $arr_data;
          $this->arr_view_data['arr_pagination'] = $arr_pagination;
          $this->arr_view_data['total_results'] = $total_results;
          $this->arr_view_data['page_title'] = "Wishlist";
          $this->arr_view_data['buyer_id_proof']  = isset($buyer_id_proof)?$buyer_id_proof:'';
          $this->arr_view_data['state_user_ids']  = isset($state_user_ids)?$state_user_ids:'';
          $this->arr_view_data['catdata']  = isset($catdata)?$catdata:[];

      
            return view('buyer.favourite.my-favourite',$this->arr_view_data);
        }
     
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


    public function add_to_favorite(Request $request)
   {
      $data = [];
      $user_id = 0;
      $form_data = $request->all();

      $user = Sentinel::check();
      if(isset($user))
      {
        $user_id = $user->id;
      }

      $id   = base64_decode($form_data['id']);
      $type = $form_data['type'];

      /*check duplication*/

      if($type!="" && $type == 'buyer')
      {
         $count = $this->FavoriteModel->where('buyer_id',$user_id)->where('product_id',$id)->count();

         if($count > 0)
         {
             $response['status']      = 'error';
             $response['description'] = 'This product was already in the Wishlist';
             return response()->json($response);
         }

         else
         {
            $data['buyer_id']    = $user_id;
            $data['product_id']  = $id;
            $result = $this->FavoriteModel->create($data);
         }

      }

        if($result)
        {  
            /*********************Notification (START)************************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = $seller_fname = $seller_lname = $someone = "" ;
                $product_nameslug = $brand_nameslug = $seller_nameslug ='';

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;

                    if($user_details->first_name=="" || $user_details->last_name==""){
                       $user_name = $user_details->email; 
                    }else{
                       $user_name    = $user_details->first_name.' '.$user_details->last_name;
                    }

                }

                // $admin_role = Sentinel::findRoleBySlug('admin');        
                // $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                // if($admin_obj)
                // {
                //     $admin_id = $admin_obj->user_id;            
                // }
                // $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);

                $get_product_name = $this->ProductModel
                                        // ->select('product_name','user_id')
                                         ->with(['get_seller_details','product_images_details','get_brand_detail','get_seller_additional_details'])
                                         ->where('id',$id)
                                         ->first();

                if(!empty($get_product_name) && isset($get_product_name))
                {
                    $get_product_name = $get_product_name->toArray();
                   
                    $product_name     = isset($get_product_name['product_name'])?$get_product_name['product_name']:'';
                    $seller_id        = isset($get_product_name['user_id'])?$get_product_name['user_id']:'';

                    $product_nameslug = isset($get_product_name['product_name'])?str_slug($get_product_name['product_name']):'';

                    $brand_nameslug = isset($get_product_name['get_brand_detail']['name'])?str_slug($get_product_name['get_brand_detail']['name']):'';

                    $seller_nameslug = isset($get_product_name['get_seller_additional_details']['business_name'])?str_slug($get_product_name['get_seller_additional_details']['business_name']):'';

                    $seller_fname = isset($get_product_name['get_seller_details']['first_name'])?$get_product_name['get_seller_details']['first_name']:'';
                    $seller_lname = isset($get_product_name['get_seller_details']['last_name'])?$get_product_name['get_seller_details']['last_name']:'';

                    $seller_product_url = url('/').'/search/product_detail/'.base64_encode($id).'/'.$product_nameslug.'/'.$brand_nameslug.'/'.$seller_nameslug;
                
                    /*****************Send Notification to Seller(START)*************/
                      $arr_event_seller          = [];
                      $arr_event_seller['from_user_id'] = $from_user_id;
                      $arr_event_seller['to_user_id']   = $seller_id;
                      $arr_event_seller['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the product <a target="_blank" href="'.$seller_product_url.'"><b>'.$product_name.'</b></a> in wishlist');
                      $arr_event_seller['type']         = '';
                      $arr_event_seller['title']        = 'Wishlist Product';
                      $this->GeneralService->save_notification($arr_event_seller);
                    /******************Send Notification to Seller(END)****************/

                    /*****************Send Mail Notification to Seller(START)*********/
                       // $msg       = html_entity_decode('<b>'.$user_name.'</b> has added the product <b>'.$product_name.'</b> in wishlist');
                       
                       // $subject   = 'Wishlist Product';

                        $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                              'APP_NAME'      => config('app.project.name'),
                                             // 'MESSAGE'       => $msg,
                                              'URL'           => $seller_product_url,
                                              'BUYER_NAME'    => $user_name,
                                              'PRODUCT_NAME'  => $product_name
                                             ];

                        $arr_mail_data['email_template_id'] = '65';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($seller_id);

                        $this->EmailService->send_notification_mail($arr_mail_data);  

                    /*****************Send Mail Notification to Seller(END)********/

                     /***********Add Event data*for wishlist****/
                      $arr_eventdata             = [];
                      $arr_eventdata['user_id']  = $from_user_id;
                      // $arr_eventdata['message']  =  html_entity_decode('<b>'.$user_name.'</b> adds '.$product_name.'  to their wishlist. <div class="clearfix"></div><a target="_blank" href="'.$seller_product_url.'" class="viewcls">View</a> ');


                        if(!empty($get_product_name['product_images_details']) 
                                         && count($get_product_name['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image']) && $get_product_name['product_images_details'][0]['image']!='')
                       {
                          /*$imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];*/

                          //image resize
                          $imgsrc = image_resize('/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'],35,35);

                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }


                      $arr_eventdata['message']  =  html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div><b>Someone</b> added '.$product_name.'  to their wishlist. <div class="clearfix"></div></div><a target="_blank" href="'.$seller_product_url.'" class="viewcls">View</a> ');
                      

                      $arr_eventdata['title']    = 'Wishlist Product';                       
                      $this->EventModel->create($arr_eventdata);
                    /*********end of add event**for wishlist*******************/




                }//if product name  

            /*****************************Notification (END)***************************/ 

            $response['status']      = 'SUCCESS';
            $response['description'] = 'Product added successfully in the Wishlist'; 
         
            return response()->json($response);
        }
   }


    public function remove_from_favorite(Request $request)
    {

        $user_id = 0;
        $result  = 1; 
        
        $form_data = $request->all();
        $user      = Sentinel::check();

        if(isset($user)){
           $user_id = $user->id; 
        }

        $id     = base64_decode($form_data['id']);
        $type   = $form_data['type'];
        
        if($type!="" && $type == 'buyer')
        {
            $is_favorite = $this->FavoriteModel
                                ->where('buyer_id',$user_id)
                                ->where('product_id',$id)
                                ->count();

            if($is_favorite)
            { 
                $result     =   $this->FavoriteModel
                                     ->where('buyer_id',$user_id)
                                     ->where('product_id',$id)
                                     ->delete();
            }  
        }

        if($result)
        { 

            /**************************Notification (START)*******************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";
                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    $user_name    = $user_details->first_name.' '.$user_details->last_name;
                }

                // $admin_role = Sentinel::findRoleBySlug('admin');        
                // $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                // if($admin_obj)
                // {
                //     $admin_id = $admin_obj->user_id;            
                // }
                // $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);

                $get_product_name = $this->ProductModel
                                         ->with(['get_seller_details'])
                                         ->select('product_name','user_id')
                                         ->where('id',$id)
                                         ->first();

                if(!empty($get_product_name) && isset($get_product_name))
                {
                    $get_product_name = $get_product_name->toArray();
                    $product_name     = isset( $get_product_name['product_name'])?$get_product_name['product_name']:'';
                    $seller_id        = isset( $get_product_name['user_id'])?$get_product_name['user_id']:'';
                
                    $seller_fname    = isset($get_product_name['get_seller_details']['first_name'])?$get_product_name['get_seller_details']['first_name']:'';
                    $seller_lname    = isset($get_product_name['get_seller_details']['last_name'])?$get_product_name['get_seller_details']['last_name']:'';

                    $seller_product_url = url('/').'/search/product_detail/'.base64_encode($id);
                    

                    /*****************Send Notification to Seller (START)**************************/
                       /* $arr_event_seller          = [];
                        $arr_event_seller['from_user_id'] = $from_user_id;
                        $arr_event_seller['to_user_id']   = $seller_id;
                        $arr_event_seller['description']  = html_entity_decode('<b>'.$user_name.'</b> has removed the product <a target="_blank" href="'.$seller_product_url.'"><b>'.$product_name.'</b></a> from wishlist.');
                        $arr_event_seller['type']         = '';
                        $arr_event_seller['title']        = 'Removed Wishlist Product';
                        $this->GeneralService->save_notification($arr_event_seller);*/
                    /******************Send Notification to Seller (END)**************************/

                    /*************Send Mail Notification to Seller(START)*************************/

                      /*  $msg       = html_entity_decode('<b>'.$user_name.'</b> has removed the product <b>'.$product_name.'</b> from wishlist.');
                       
                        $subject   = 'Removed Wishlist Product';

                        $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                              'APP_NAME'      => config('app.project.name'),
                                              'MESSAGE'       => $msg,
                                              'URL'           => $seller_product_url
                                             ];

                        $arr_mail_data['email_template_id'] = '31';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = $subject;
                        $arr_mail_data['user']              = Sentinel::findById($seller_id);

                        $this->EmailService->send_notification_mail($arr_mail_data);  */

                    /**************Send Mail Notification to Seller(END)**************************/

                }  


            /**************************Notification (END)*******************************/

            $response['status']      = 'SUCCESS';
            $response['description'] = 'Product removed successfully from the Wishlist'; 
             
            return response()->json($response);
        }
   
    }//end function
 

    public function add_to_follow(Request $request)
   {

      $data = [];
      $user_id = 0;
      $form_data = $request->all();

      $user = Sentinel::check();
      if(isset($user))
      {
        $user_id = $user->id;
      }

      $id   = base64_decode($form_data['id']);
      $type = $form_data['type'];
      $seller_id = base64_decode($form_data['sellerid']);

      /*check duplication*/

      if($type!="" && $type == 'buyer')
      {
         $count = $this->FollowModel->where('buyer_id',$user_id)->where('seller_id',$seller_id)->count();

         if($count > 0)
         {
             $response['status']      = 'error';
             $response['description'] = 'You are already following to this seller';
             return response()->json($response);
         }

         else
         {
            $data['buyer_id']    = $user_id;
            $data['seller_id']   = $seller_id;
            $result = $this->FollowModel->create($data);
         }

      }

        if($result)
        {  



            /*********************Notification (START)************************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = $seller_fname = $seller_lname = "";
                $seller_name = '';
                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;

                    if($user_details->first_name=="" || $user_details->last_name==""){
                       $user_name = $user_details->email; 
                    }else{
                       $user_name    = $user_details->first_name.' '.$user_details->last_name;
                    }

                }

                $getsellerinfo = $this->UserModel->where('id',$seller_id)->with('seller_detail')->first();
                if(isset($getsellerinfo) && !empty($getsellerinfo))
                {
                   $getsellerinfo = $getsellerinfo->toArray();
                   if($getsellerinfo['first_name']=="" || $getsellerinfo['last_name']=="")
                   {
                    $seller_name = $getsellerinfo['email'];
                   }
                   else
                   {
                    $seller_name = $getsellerinfo['first_name'].' '.$getsellerinfo['last_name'];
                   }

                //  $seller_name = isset($getsellerinfo['seller_detail']['business_name'])?$getsellerinfo['seller_detail']['business_name']:$getsellerinfo['email'];

                }

                                                   
                    /*****************Send Notification to Seller(START)*************/
                      $arr_event_seller          = [];
                      $arr_event_seller['from_user_id'] = $from_user_id;
                      $arr_event_seller['to_user_id']   = $seller_id;
                      $arr_event_seller['description']  = html_entity_decode('<b>'.$user_name.'</b> has started following you.');
                      $arr_event_seller['type']         = '';
                      $arr_event_seller['title']        = 'Followers';
                      $this->GeneralService->save_notification($arr_event_seller);
                    /******************Send Notification to Seller(END)****************/

                    /*****************Send Mail Notification to Seller(START)*********/
                        //$msg  = html_entity_decode('<b>'.$user_name.'</b> is following you.');
                       
                        $subject = '';

                        $arr_built_content = ['USER_NAME'     => $seller_name,
                                              'APP_NAME'      => config('app.project.name'),
                                              'BUYER_NAME'    => $user_name
                                             ];

                        $arr_mail_data['email_template_id'] = '51';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($seller_id);
                        
                        $this->EmailService->send_mail_section($arr_mail_data);  

                    /*****************Send Mail Notification to Seller(END)********/
                    /*********end of add event**for wishlist*******************/





            /*****************************Notification (END)***************************/ 

            $response['status']      = 'SUCCESS';
            $response['description'] = 'Buyer following you successfully'; 
         
            return response()->json($response);
        }
   }//end add to follow function


     public function unfollow(Request $request)
    {

        $user_id = 0;
        $result  = 1; 
        
        $form_data = $request->all();
        $user      = Sentinel::check();

        if(isset($user)){
           $user_id = $user->id; 
        }

        $id     = base64_decode($form_data['id']);
        $type   = $form_data['type'];
        $sellerid = base64_decode(($form_data['sellerid']));
        
        if($type!="" && $type == 'buyer')
        {
            $is_follow = $this->FollowModel
                                ->where('buyer_id',$user_id)
                                ->where('seller_id',$sellerid)
                                ->count();

            if($is_follow)
            { 
                $result     =   $this->FollowModel
                                     ->where('buyer_id',$user_id)
                                     ->where('seller_id',$sellerid)
                                     ->delete();
            }  
        }

        if($result)
        { 

            /**************************Notification (START)*******************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";
                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    $user_name    = $user_details->first_name.' '.$user_details->last_name;
                }
             


            /**************************Notification (END)*******************************/

            $response['status']      = 'SUCCESS';
            $response['description'] = 'Buyer unfollowing you.'; 
             
            return response()->json($response);
        }
   
    }//end function of unfollow
 



}
