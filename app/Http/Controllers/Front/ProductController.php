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

use Validator;
use Sentinel;
use DB;
use Datatables;
use Flash;
use Session;

class ProductController extends Controller
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
                                    EmailService $EmailService
    						   )
    {		
    	$this->ProductModel         		= $ProductModel;
    	$this->FirstLevelCategoryModel  = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
    	
    	
    	  $this->BaseModel                = $ProductModel;
        $this->UserModel                = $UserModel;
        $this->BuyerModel               = $BuyerModel;
        $this->SellerModel              = $SellerModel;
        $this->FavoriteModel            = $FavoriteModel;
       // $this->ProductService           = $ProductService;
        $this->EmailService             = $EmailService;
        

        $this->module_view_folder         = 'front.product';
        $this->module_url_path            = url('/product');
        $this->back_path                  = url('/').'/product';

        $this->product_image_base_img_path   = base_path().config('app.project.img_path.product_images');
        $this->product_image_public_img_path = url('/').config('app.project.img_path.product_images');
        // $this->shipmentproofs_public_path = url('/').config('app.project.shipment_proofs');
        // $this->shipmentproofs_base_path   = base_path().config('app.project.shipment_proofs');
        $this->module_title               = 'All Products';
        $this->arr_view_data              = [];
    }

    public function index()
    {		
    	$user        = sentinel::check();
      $user_id     = $user->id; 
    	$obj_product = $this->ProductModel->with(['first_level_category_details',
                                            'second_level_category_details'])
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->get();
        if ($obj_product) {
           $arr_product = $obj_product->toArray();
        }


        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['product_arr']     = $arr_product;
    	  $this->arr_view_data['img_path']        = $this->product_image_base_img_path;
        $this->arr_view_data['fav_product_arr'] = $this->FavoriteModel->where('buyer_id',$user_id)->select('product_id')->get()->toArray();

        // dd($this->arr_view_data);
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
    // public function view($enc_id)
    // {   
    //     $arr_trade = [];
    //     $id = base64_decode($enc_id);

    //     $arr_trade = $this->ProductService->get_product_details($id);

    //     $this->arr_view_data['back_path'] = $this->back_path;
    //     $this->arr_view_data['arr_trade'] = isset($arr_trade)?$arr_trade:[];
    //     return view($this->module_view_folder.'.view',$this->arr_view_data);
    // }

    // public function get_second_level_category(Request $request)
    // {	
    // 	$arr_second_level_category   = [];
    //     $first_level_category_id     = $request->input('first_level_category_id');

    //     $arr_second_level_category   = $this->SecondLevelCategoryModel->where('first_level_category_id',$first_level_category_id)->where('is_active','1')
    //     							   ->get()
    //     							   ->toArray();

    //     $response['second_level_category'] = isset($arr_second_level_category)?$arr_second_level_category:[]; 
    //     return $response;
    // }



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
      if($user)
      {
        $user_id = $user->id;
      }

      $id   = base64_decode($form_data['id']);
      $type = $form_data['type'];

      /*check duplication*/

      if($type == 'buyer')
      {
         $count = $this->FavoriteModel->where('buyer_id',$user_id)->where('product_id',$id)->count();

         if($count > 0)
         {
             $response['status']      = 'ERROR';
             $response['description'] = 'Product was already in the Wishlist';
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
         
            $response['status']      = 'SUCCESS';
            $response['description'] = 'Product added successfully in the Wishlist'; 
         
            return response()->json($response);
      }
  
   }


   public function remove_from_favorite(Request $request)
  {
        $user_id = 0;
        
        $form_data = $request->all();

        $user = Sentinel::check();
       
        if(isset($user))
        {
           $user_id = $user->id; 
        }

        $id     = base64_decode($form_data['id']);
        $type   = $form_data['type'];

        
        if($type == 'buyer')
        {
           $result = $this->FavoriteModel->where('buyer_id',$user_id)->where('product_id',$id)->delete();
        }
       

        if($result)
        { 
            
          $response['status']      = 'SUCCESS';
          $response['description'] = 'Product removed successfully from Wishlist'; 
             
          return response()->json($response);
        }
   
  }

  // function for search product in header 
   public function fetchproductlist123(Request $request)
    {
      $html = '';
      $html .='<ul>';
      $formdata = $request->all();
      $query = $formdata['query'];
      if($query)
      {
          $res_cat = $this->FirstLevelCategoryModel->where('product_type','like','%'.$query.'%')->where('is_active','1')->get()->toArray();

         // dd($res_cat);
          if(isset($res_cat)){
            if(!empty($res_cat) && count($res_cat)>0){
              foreach($res_cat as $cat){
              $html .='<li>'.$cat['product_type'].'</li>';

                   $res_product = $this->ProductModel->where('product_name','like','%'.$query.'%')->where('is_active','1')->where('is_approve','1')->where('first_level_category_id',$cat['id'])->get()->toArray();
                    if(isset($res_product)){
                      if(!empty($res_product) && count($res_product)>0){
                        $html .='<ul>';
                        foreach($res_product as $product){
                        $html .='<li>'.$product['product_name'].'</li>';
                        }//foreach product
                         $html .='</ul>';
                     }//if not empty product
                   }//if isset product

              }//foreach rescat

            }//if not empty rescat
          }//if isset rescat


        $html .='</ul>';   

        echo  $html;       
      }

    }// end of function 



   

}
