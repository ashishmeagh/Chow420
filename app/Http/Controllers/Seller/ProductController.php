<?php

namespace App\Http\Controllers\Seller; 

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
 
use App\Common\Traits\MultiActionTrait;
 
use App\Models\UserModel;
use App\Models\CountriesModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel; 
use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Models\RoleUserModel; 
use App\Models\GeneralSettingsModel;
use App\Models\TradeRatingModel;
use App\Models\ShippingAddressModel;
use App\Models\ProductModel;
use App\Models\ProductCommentModel;
use App\Models\FirstLevelCategoryModel; 
use App\Models\SecondLevelCategoryModel;
use App\Models\ProductInventoryModel;
use App\Models\ProductImagesModel;
use App\Models\AgeRestrictionModel;   
use App\Models\BrandModel; 
use App\Models\KeywordsModel; 
use App\Models\UserSubscriptionsModel; 
use App\Models\ProductDimensionsModel;
use App\Models\DropShipperModel;
use App\Models\StatesModel;
use App\Models\EventModel;
use App\Models\SpectrumModel;
use App\Models\ProductCannabinoidsModel;
use App\Models\CannabinoidsModel;



use App\Common\Services\GeneralService;

use App\Common\Services\EmailService;
use App\Common\Services\ProductService; 

use Flash;
use Validator; 
use Sentinel;
use Activation;
use Reminder;
use DB;
use Image;
use Datatables;
use Excel;
use Illuminate\Support\Facades\Input;
use App\Models\UnitModel;

class ProductController extends Controller
{
    use MultiActionTrait;

    public function __construct(UserModel $user,
                                CountriesModel $country,
                                ActivityLogsModel $activity_logs,
                                BuyerModel $buyerModel,
                                SellerModel $sellerModel,
                                RoleUserModel $roleUserModel,
                                EmailService $EmailService,
                                ProductService $ProductService,
                                GeneralSettingsModel $GeneralSettingsModel,
                                TradeRatingModel $TradeRatingModel,
                                ShippingAddressModel $ShippingAddressModel,
                                ProductModel $ProductModel,
                                ProductCommentModel $ProductCommentModel,
                                FirstLevelCategoryModel $FirstLevelCategoryModel,
                                SecondLevelCategoryModel $SecondLevelCategoryModel,
                                UnitModel $UnitModel,
                                KeywordsModel $KeywordsModel,
                                ProductInventoryModel $ProductInventoryModel,
                                ProductImagesModel $ProductImagesModel,
                                AgeRestrictionModel $AgeRestrictionModel,
                                BrandModel $BrandModel,
                                UserSubscriptionsModel $UserSubscriptionsModel,
                                ProductDimensionsModel $ProductDimensionsModel,
                                DropShipperModel $DropShipperModel,
                                StatesModel $StatesModel,
                                GeneralService $GeneralService,
                                EventModel $EventModel,
                                SpectrumModel $SpectrumModel,
                                ProductCannabinoidsModel $ProductCannabinoidsModel,
                                CannabinoidsModel $CannabinoidsModel
                                )
    {
        $user = Sentinel::createModel();

        $this->EmailService                 = $EmailService;
        $this->UserModel                    = $user;
        $this->BaseModel                    = $this->UserModel;   // using sentinel for base model.
        $this->CountriesModel               = $country;
        $this->ActivityLogsModel            = $activity_logs;
        $this->BuyerModel                   = $buyerModel;
        $this->SellerModel                  = $sellerModel;
        $this->RoleUserModel                = $roleUserModel;
        $this->GeneralSettingsModel         = $GeneralSettingsModel;
        $this->TradeRatingModel             = $TradeRatingModel;
        $this->ShippingAddressModel         = $ShippingAddressModel;
        $this->ProductModel                 = $ProductModel;
        $this->ProductCommentModel          = $ProductCommentModel; 
        $this->FirstLevelCategoryModel      = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel     = $SecondLevelCategoryModel;
        $this->ProductService               = $ProductService;
        $this->UnitModel                    = $UnitModel;
        $this->ProductInventoryModel        = $ProductInventoryModel;
        $this->ProductImagesModel           = $ProductImagesModel;
        $this->AgeRestrictionModel          = $AgeRestrictionModel;    
        $this->KeywordsModel                = $KeywordsModel;    
        $this->BrandModel                   = $BrandModel;
        $this->UserSubscriptionsModel       = $UserSubscriptionsModel;
        $this->ProductDimensionsModel       = $ProductDimensionsModel;
        $this->DropShipperModel             = $DropShipperModel;
        $this->StatesModel                  = $StatesModel;
        $this->GeneralService               = $GeneralService;
        $this->EventModel                   = $EventModel;
        $this->SpectrumModel                = $SpectrumModel;
        $this->ProductCannabinoidsModel     = $ProductCannabinoidsModel;
        $this->CannabinoidsModel     = $CannabinoidsModel;



      //  $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
       // $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');
        $this->product_image_base_img_path  = base_path().config('app.project.img_path.product_images');
        $this->product_public_img_path      = url('/').config('app.project.img_path.product_images');
        $this->user_id_proof                = url('/').config('app.project.id_proof');

        $this->arr_view_data                = [];
       // $this->module_url_path              = url(config('app.project.admin_panel_slug')."/productlist");
        $this->product_imageurl_path         = url(config('app.project.product_images'));
        $this->product_image_thumb_base_img_path = base_path().config('app.project.img_path.product_imagesthumb');

        $this->module_title                 = "Product";
        $this->modyle_url_slug              = "Product";
        $this->module_view_folder           = "seller.product";

        $this->add_product_image_base_img_path     = base_path().config('app.project.img_path.additional_product_image');
        $this->add_product_public_img_path      = url('/').config('app.project.img_path.additional_product_image');
       
    }   

    public function index()
    {
        $this->arr_view_data['arr_data'] = array();
        
        $this->arr_view_data['page_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);

        $seller_id  = '';
        $arr_seller = [];
        $user       = Sentinel::getUser();
        if(!empty($user))
        {
           $seller_id = $user->id;

          /* get seller detail */
            $obj_seller = $this->SellerModel->where('user_id',$seller_id)->with('user_details')->first();
 
            if($obj_seller)
            {
                $arr_seller   = $obj_seller->toArray();
                if(isset($arr_seller['user_details']['state']) && !empty($arr_seller['user_details']['state']))
                {
                   $seller_state = $arr_seller['user_details']['state'];
                   $obj_state    = $this->StatesModel->where('id',$seller_state)->select('is_documents_required')->first();
                   if(isset($obj_state) && !empty($obj_state))
                   {
                     $documents_restriction = $obj_state['is_documents_required'];
                     if(isset($documents_restriction) && $documents_restriction=='1')
                     {
                       $seller_documents_verification_status = $arr_seller['documents_verification_status'];

                       if(isset($seller_documents_verification_status))
                       {
                         $this->arr_view_data['seller_documents_verification_status'] = $seller_documents_verification_status;
                       }
                     }
                     else
                     {
                        $this->arr_view_data['seller_documents_verification_status'] = 1;
                     }
                   }  

                   else
                     {
                        $this->arr_view_data['seller_documents_verification_status'] = 1;
                     }
                }


            }
          /*end*/

            $user_arr = $user->toArray();

             $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$user->id)->where('membership_status','1')->get();
             if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
             {
              $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
             }

        }
 
        $res_product = $this->ProductModel->with('first_level_category_details')
                                          ->where('is_active','1')
                                          ->where('is_approve','1')
                                          ->where('user_id',$seller_id)
                                          ->get()->toArray();

        $this->arr_view_data['arr_product'] = $res_product;
        $this->arr_view_data['arr_seller']  = $arr_seller;        
        $this->arr_view_data['product_imageurl_path'] = $this->product_imageurl_path;
        $this->arr_view_data['user_arr'] = isset($user_arr)?$user_arr:[];
        $this->arr_view_data['user_subscriptiontabledata'] = isset($user_subscriptiontabledata)?$user_subscriptiontabledata:[];


        //  if ($user->subscribedToPlan('monthly', 'main')) {
        //        echo "monthlyyyy";
        //     }
        //     elseif($user->subscribedToPlan('hourly_id', 'main')) {
        //         echo "hourly";
        //     }
        //     else{
        //         echo "not monthly..";
        //     }

        $user_subscried = 0;
        if ($user->subscribed('main')) {
            $user_subscried = 1;

        }else{
          $user_subscried =0;
        }
       $this->arr_view_data['user_subscribed'] = $user_subscried;

      //get canceled memebrshipdata
        /****************************************/

           $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                    ->where('user_id',$user->id)
                    ->where('membership_status','0')
                    ->where('is_cancel','1')
                    ->orderBy('id','desc')
                    ->first(); 
          if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
          {
            $get_cancelmembershipdata = $get_cancelmembershipdata->toArray();
             $this->arr_view_data['get_cancelmembershipdata'] = isset($get_cancelmembershipdata)?$get_cancelmembershipdata:[];
          }          

        /****************************************/

         $res_active_product = $this->ProductModel->with('first_level_category_details')
                                          ->where('is_active','1')
                                          ->where('user_id',$seller_id)
                                          ->get()->count();
            
          $this->arr_view_data['res_active_product'] = isset($res_active_product)?$res_active_product:[];                                

        return view($this->module_view_folder.'.my_products', $this->arr_view_data);
    }

    // FUNCTION TO SHOW RECORDS OF product listing

    public function get_records(Request $request)
    {    
        
        $obj_user     = $this->get_productlist_details($request);
        $current_context = $this;
        $json_result     = Datatables::of($obj_user);
        $json_result     = $json_result->blacklist(['id']);        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                             ->editColumn('unit_price',function($data) use ($current_context)
                            { 
                                 $unit_price =  num_format($data->unit_price);
                                 return "$".$unit_price;
                                 
                            })  
                             ->editColumn('product_name',function($data) use ($current_context)
                            { 
                                 $product_name =  $data->product_name;
                                 return "<div class='prodname'>".$product_name."</div>";
                                 
                            })  
                            ->editColumn('error_message',function($data) use ($current_context)
                            { 
                                 $error_message =  trim($data->error_message);
                                 if($error_message!=''){
                                 $str = explode(" , ", $error_message);
                                 $i=1;$st1='';
                                 foreach($str as $v){
                                    $st1 .= $i.') '.ltrim($v,",").'<br/>';    
                                    $i++;
                                 }
                                 // return $st1;
                                 return "<div class='prodname'>".$st1."</div>";
                               }else{      
                                   if($data->error_message!='')                             
                                   return "<div class='prodname'>".$data->error_message."</div>";
                                    else
                                   return "<div class='prodname'>NA</div>";
     
                               }
                            })
                                ->editColumn('build_status_btn',function($data) use ($current_context)
                            {

                                $build_status_btn ='';


                                if($data->is_active == '0')
                                {   

                                    $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->is_active == 1)
                                {
                                   
                                    $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_status_btn;
                            }) 

                              ->editColumn('build_outofstock_btn',function($data) use ($current_context)
                            {

                                $build_outofstock_btn ='';


                                if($data->is_outofstock == '0')
                                {   

                                    $build_outofstock_btn = '
                                    <div class="text-center">
                                    <input type="checkbox" onclick="stock_change(this)" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="toggleOutofstock" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" /> </div>';
                                }
                                elseif($data->is_outofstock == 1)
                                {
                                   
                                    $build_outofstock_btn = '
                                    <div class="text-center">
                                    <input type="checkbox" checked data-size="small" onclick="stock_change(this)"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="toggleOutofstock " data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" /></div>';
                                }
                                return $build_outofstock_btn;
                            })     

                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                /*view*/
                                $view_href =  url('/').'/seller/product/view/'.base64_encode($data->id);

                                $build_view_action = '<a href="'.$view_href.'" class="eye-actn" title="View Product">
                                View
                                </a>';


                                /*edit*/
                                $edit_href =  url('/').'/seller/product/edit/'.base64_encode($data->id);

                                // $build_edit_action = '<a class="delete-slrs btn-edit" href="'.$edit_href.'" title="Edit">Edit</a>';
                                $build_edit_action = '<a href="'.$edit_href.'" class="eye-actn" title="Edit Product"> Edit
                                </a>';


                                
                                /*delete*/
                                $delete_href =  url('/').'/seller/product/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';

                                // $build_delete_action = '<a class="delete-slrs btn-delete" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                                $build_delete_action = '<a class="eye-actn btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                                

                                $seller_documents_verification_status = is_documents_required($data->user_id);

                                if(isset($seller_documents_verification_status) && $seller_documents_verification_status==0) 
                               {   


                      $build_copy_product_action =  '<a href="#" class="eye-actn " data-toggle="modal" data-target="#documentsNotUploaded" data-backdrop="false">Duplicate</a>';
                               }


                   elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status==2) 

                         {

                        $build_copy_product_action = '<a href="#" class="eye-actn " data-toggle="modal" data-target="#documentsRejected" data-backdrop="false">Duplicate</a>';
                        }  

                      elseif(isset($seller_documents_verification_status)  && $seller_documents_verification_status==3) 

                       { 

                       $build_copy_product_action =  '<a href="#" class="eye-actn " data-toggle="modal" data-target="#documentsSubmitted" data-backdrop="false">Duplicate</a>';
                       } 

                        elseif(isset($seller_documents_verification_status) &&  $seller_documents_verification_status==1) 
                           {
                                /*copy the product*/
                                $copy_product_href =  url('/').'/seller/product/copy_product/'.base64_encode($data->id);


                                $build_copy_product_action = '<a class="eye-actn "  href="'.$copy_product_href.'" title="Duplicate Product">Duplicate</a>';
                           }     


                                return $build_action = $build_view_action.' '.$build_edit_action.' '.$build_copy_product_action;
                                // return $build_action = $build_edit_action.' '.$build_delete_action;
                            })
                             ->editColumn('spectrum',function($data) use ($current_context)
                            { 
                                 
                                if(isset($data->spectrum) && !empty($data->spectrum)) {

                                    // if ($data->spectrum == 0) {

                                    //   return "Full Spectrum";
                                    // }

                                    // if ($data->spectrum == 1) {

                                    //   return "Broad Spectrum";
                                    // }

                                    // if ($data->spectrum == 2) {

                                    //   return "Isolate";
                                    // }
                                  $get_spectrum_val = get_spectrum_val($data->spectrum);
                                  if(isset($get_spectrum_val) && !empty($get_spectrum_val))
                                  {
                                     return $get_spectrum_val['name'];
                                  }
                                  else
                                  {
                                    return "NA";
                                  }

                               }
                               
                               return "NA";
                            }) 
                        
                            ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
    }


    public function get_productlist_details(Request $request)
    { 
        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;
        }
 

        $product_details      = $this->ProductModel->getTable();
        $prefix_product_detail  = DB::getTablePrefix().$this->ProductModel->getTable();
        $prefix_spectrum        = DB::getTablePrefix().$this->ProductModel->getTable();

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $firstlevel         = $this->FirstLevelCategoryModel->getTable();
        $prefix_firstlevel  = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

        $secondlevel        = $this->SecondLevelCategoryModel->getTable();
        $prefix_secondlevel = DB::getTablePrefix().$this->SecondLevelCategoryModel->getTable();

        $product_images        = $this->ProductImagesModel->getTable();
        $prefix_product_images = DB::getTablePrefix().$this->ProductImagesModel->getTable();

        $age_restriction        = $this->AgeRestrictionModel->getTable();
        $prefix_age_restriction = DB::getTablePrefix().$this->AgeRestrictionModel->getTable();

        $productbrand = $this->BrandModel->getTable();
        $prefiex_productbrand = DB::getTablePrefix().$this->BrandModel->getTable();

       
        $obj_product = DB::table($product_details)->select(DB::raw( $product_details.'.*,'
                      .$prefix_product_images.'.image as image,'
                      .$prefiex_productbrand.'.name as bname,'
                      .$prefix_age_restriction.'.age as age,'
                      .$prefix_spectrum.'.spectrum as spectrum_field'
                  ))
                            ->leftjoin($prefix_product_images,$prefix_product_images.'.product_id','=',$prefix_product_detail.'.id') 
                            ->leftJoin($prefix_age_restriction,$prefix_age_restriction.'.id',$product_details.'.age_restriction')
                             ->leftJoin($prefiex_productbrand,$prefiex_productbrand.'.id','=',$prefix_product_detail.'.brand')
                            ->where($product_details.'.user_id',$seller_id)
                            // ->where($product_details.'.is_active',1)
                            ->groupBy($prefix_product_images.'.product_id')
                            ->orderBy($product_details.'.is_approve','asc');  
                           // ->get();  

                            /******************** search conditions logic here ***************/

                          $arr_search_column = $request->input('column_filter');

                         if(isset($arr_search_column['q_product_name']) && $arr_search_column['q_product_name'] != '')
                          {
                              $search_name_term  = $arr_search_column['q_product_name'];
                              $obj_product  = $obj_product->where('product_name','LIKE', '%'.$search_name_term.'%');

                          }
                           if(isset($arr_search_column['q_product_price']) && $arr_search_column['q_product_price'] != '')
                          {
                              $search_price  = $arr_search_column['q_product_price'];
                              $obj_product  = $obj_product->where('unit_price','LIKE', '%'.$search_price.'%');

                          }
                          if(isset($arr_search_column['q_product_age']) && $arr_search_column['q_product_age'] != '')
                          {
                              $search_age  = $arr_search_column['q_product_age'];
                              $obj_product  = $obj_product->where($prefix_age_restriction.'.age','LIKE', '%'.$search_age.'%');

                          }

                           if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
                          {
                              $search_active  = $arr_search_column['q_status'];

                             // $obj_product  = $obj_product->where($prefix_product_detail.'.is_active','LIKE', '%'.$search_active.'%');


                              if($search_active=='-1'){
                                
                              }else{
                                 $obj_product  = $obj_product->where($prefix_product_detail.'.is_active','LIKE', '%'.$search_active.'%');
                              }

                             

                          }
                           if(isset($arr_search_column['q_admin_status']) && $arr_search_column['q_admin_status'] != '')
                          {
                              $search_admin_status  = $arr_search_column['q_admin_status'];
                              if($search_admin_status=='-1')
                              {
                                

                              }else{
                                $obj_product  = $obj_product->where($prefix_product_detail.'.is_approve','LIKE', '%'.$search_admin_status.'%');
                              }
                              

                          }
                            if(isset($arr_search_column['q_brand_name']) && $arr_search_column['q_brand_name'] != '')
                          {
                              $search_brand_name  = $arr_search_column['q_brand_name'];
                              $obj_product  = $obj_product->where($prefiex_productbrand.'.name','LIKE', '%'.$search_brand_name.'%');

                          }
                          if(isset($arr_search_column['spectrum']) && $arr_search_column['spectrum'] != '')
                          {
                              $search_spectrum  = $arr_search_column['spectrum'];

                              $obj_product  = $obj_product->where($prefix_spectrum.'.spectrum',$search_spectrum);
                          }






                   
         return $obj_product;
                                    
    }
    
    public function create()
    {
        $arr_seller = [];
        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;

           /* get seller detail */
            $obj_seller = $this->SellerModel->where('user_id',$seller_id)->first();

            if($obj_seller)
            {
                $arr_seller = $obj_seller->toArray();
                // dd($arr_seller['approve_verification_status']);

                if(isset($arr_seller['approve_verification_status']) && $arr_seller['approve_verification_status'] != 1)
                {                    
                   // return redirect()->back();
                }                
            }
          /*end*/
        }


        $arr_category  = $arr_unit = [];
        $this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        //$this->arr_view_data['module_url_path'] = $this->module_url_path;

        $arr_category  = $this->FirstLevelCategoryModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_category']   = isset($arr_category) ?$arr_category:[];

        $arr_secondcategory  = $this->SecondLevelCategoryModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_secondcategory']   = isset($arr_secondcategory) ?$arr_secondcategory:[];


        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable(); 

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();

        $res_age_Restriction = $this->AgeRestrictionModel->select('id','age')->get()->toArray();


        $sellerdropdown = DB::table($user_details)
                          ->select(DB::raw($user_details.'.*'))
                          ->leftjoin($prefix_seller_detail,$prefix_seller_detail.'.user_id','=',$prefix_user_detail.'.id')
                          ->where($user_details.'.user_type','seller')
                          ->get()->toArray();
                          //dd($sellerdropdown);


         $this->arr_view_data['sellerdropdown']   = $sellerdropdown;      
         $this->arr_view_data['age_restrictiondata']  = isset($res_age_Restriction)?$res_age_Restriction:[];        
        
        return view($this->module_view_folder.'.add',$this->arr_view_data);
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


   public function save(Request $request)
    {

        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;
        }

        $form_data = $request->all();

        /*if( (strpos($form_data['product_name'], 'cbd') !== false) || (strpos($form_data['product_name'], 'CBD') !== false) || (strpos($form_data['product_name'], 'thc') !== false) || (strpos($form_data['product_name'], 'THC') !== false) )
        {
            $response['status']      = 'warning';
            $response['description'] = 'Remove the word "CBD", if your products contain any form of cannabinoids, please identify it in your certificate of analysis of your product(s)';

            return response()->json($response);
        }*/ 

        $is_age_limit = isset($form_data['is_age_limit'])?$form_data['is_age_limit']:0;
        $age_restriction = isset($form_data['age_restriction'])?$form_data['age_restriction']:'';
        $shipping_type = isset($form_data['shipping_type']) ? $form_data['shipping_type'] : '';
        $shipping_charges = isset($form_data['shipping_charges']) ? $form_data['shipping_charges'] : '';
        $is_active = isset($form_data['is_active'])?$form_data['is_active']:0;
        $brand = isset($form_data['brand'])?$form_data['brand']:'';

        $unit_price = isset($form_data['unit_price'])?$form_data['unit_price']:'';

        $concentration     = isset($form_data['per_product_quantity'])?$form_data['per_product_quantity']:'';
        $shipping_duration = isset($form_data['shipping_duration'])?$form_data['shipping_duration']:'';
        $product_video_source = isset($form_data['product_video_source'])?$form_data['product_video_source']:'';
        $product_video_url = isset($form_data['product_video_url'])?$form_data['product_video_url']:'';

        $first_level_category_id = isset($form_data['first_level_category_id'])?$form_data['first_level_category_id']:'';

        $product_dimension_arr         = isset($form_data['product_dimension'])?$form_data['product_dimension']:'';
    
        $product_dimension_value_arr   = isset($form_data['product_dimension_value'])?$form_data['product_dimension_value']:'';
        if(strpos($product_video_url,'http') === 0)
        {
          $response['status']      = 'warning';
          $response['description'] = 'Please enter valid Youtube/Vimeo url short code';
          return response()->json($response);
        }
        
         $get_first_cat =[]; $category_name='';
         $get_first_cat = $this->FirstLevelCategoryModel->where('id',$first_level_category_id)->first();
         if(isset($get_first_cat) && !empty($get_first_cat))
         {
           $get_first_cat = $get_first_cat->toArray();
           $category_name = $get_first_cat['product_type'];
         } 
        $description  = isset($form_data['description'])?$form_data['description']:'';

        $ingredients         = isset($form_data['ingredients'])?$form_data['ingredients']:'';
        $suggested_use       = isset($form_data['suggested_use'])?$form_data['suggested_use']:'';
        $amount_per_serving  = isset($form_data['amount_per_serving'])?$form_data['amount_per_serving']:'';



        // dd($description);
        $spectrum   = isset($form_data['spectrum'])?$form_data['spectrum']:'';
        $sku   = isset($form_data['sku'])?$form_data['sku']:'';


        $form_data['user_id'] = $seller_id;
        $form_data['is_age_limit'] = $is_age_limit;
        $form_data['age_restriction'] = $age_restriction;
        $form_data['is_active'] = $is_active;
        $form_data['spectrum'] = $spectrum;
        $form_data['sku'] = $sku;


        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }


        $arr_rules = [];

        $arr_rules =    [
                           'product_name'             => 'required',
                           'first_level_category_id'  => 'required',
                           'second_level_category_id' => 'required',
                           'description'              => 'required|min:150',
                           /*'ingredients'              => 'required',
                           'suggested_use'           =>  'required',
                           'amount_per_serving'      =>  'required',*/
                           'unit_price'               => 'required|numeric|min:1|not_in:0',
                           'shipping_type'            => 'required',
                           //'user_id'                => 'required',
                           'product_stock'            => 'required|numeric|min:1|not_in:0',
                           // 'per_product_quantity'  => 'required',
                           'brand'                    => 'required'
                           //'is_age_limit'           => 'required'
                        ];

         if($is_update_process == false) 
         {
            $arr_rules['product_image'] = 'required';
         }

         if($product_video_source == "youtube" || $product_video_source == "vimeo")
         {
            $arr_rules['product_video_source'] = 'required';
            $arr_rules['product_video_url'] = 'required';
         }


         $validator = Validator::make($request->all(),$arr_rules);

         if($validator->fails())
         { 
            $description = Validator::make($request->all(),$arr_rules)->errors()->first();

            $response['status']      = 'warning';
            $response['description'] = $description;
            // $response['description'] = 'Form validation failed..Please check all fields..';

            return response()->json($response);
         }

       /* if($is_age_limit=='1' && $age_restriction=="")
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter age restriction';

            return response()->json($response);
        }*/

        if ($shipping_type == '1' && $shipping_charges == "") {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter shipping charges';

            return response()->json($response);
        }
 
        // validation for shipping charges not greater than unit price.
        if($shipping_type=='1')
        {
           if(isset($unit_price) && isset($shipping_charges))
           {
               if($shipping_charges>$unit_price)
               {
                $response['status'] = 'warning';
                $response['description'] = 'Shipping charges should not be greater than unit price';
                 return response()->json($response);
               }
           }
        } 


        // start of remove keywords code
        if($description)
        {
          $string = strip_tags($description);
          $keywords = preg_replace('/[\s]+/', ' ', $string);
          $keywordsarr = explode(" ", str_replace("&nbsp;"," ",$keywords));
        
          $keyarr =[];
          foreach ($keywordsarr as $k1=>$keyword)
          {
              $check_description = $this->KeywordsModel
                                      // ->where('keyword_name','LIKE','%'.$keyword.'%')
                                      ->where('keyword_name',$keyword)
                                      ->where('is_active','1')
                                      ->count();
              if($check_description>0)
              {
                $keyarr[] = $keyword;
              }
           }//foreach


          if(isset($keyarr) && !empty($keyarr))
          {
            $keyarr = array_filter($keyarr);
            
            $excluded_keywords = implode(",", array_filter($keyarr));
            if(isset($excluded_keywords) && !empty($excluded_keywords))
            {
                  $response['status']      = 'warning';
                  // $response['description'] = 'Please do not enter '.$excluded_keywords.' in the description.';
                  $response['description'] = 'Remove all health claims from your product description';

                  return response()->json($response);
            }
              
          }
        }//if description end of remove keywords
       


        if ($request->hasFile('product_image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('product_image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image. Only jpg, png, jpeg extensions are allowed.';
                return response()->json($response);
            }

        } 


        if($request->hasFile('product_additional_image')) 
        {
            //Validation for product image
            $file_extension = strtolower($request->file('product_additional_image')->getClientOriginalExtension());

            if(!in_array($file_extension,['jpg','png','jpeg']))
            {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }



        if ($request->hasFile('product_certificate')) 
        {
           //Validation for product certificate image
           $file_extension = strtolower($request->file('product_certificate')->getClientOriginalExtension());
          // if(!in_array($file_extension,['jpg','png','jpeg','pdf']))
            if(!in_array($file_extension,['pdf']))
           {
                $response['status']       = 'CertificateFAILURE';
               // $response['description']  = 'Invalid image. Only jpg, png, jpeg extensions are allowed.';
                 $response['description']  = 'Invalid file. Only pdf extensions are allowed.';
                return response()->json($response);
            }
        } 

        if(isset($category_name) && !empty($category_name) && ($category_name=="Essential Oils" || $category_name=="Accessories") && $concentration==""){

        }elseif(isset($category_name) && !empty($category_name) && ($category_name!="Essential Oils" || $category_name!="Accessories") && $concentration=="")
        {

             if(isset($form_data['spectrum']) && !empty($form_data['spectrum']))
            {

                 $get_spectrum =[]; $spectrum_name='';
                 $get_spectrum = $this->SpectrumModel->where('id',$form_data['spectrum'])->first();
                 if(isset($get_spectrum) && !empty($get_spectrum))
                 {
                   $get_spectrum = $get_spectrum->toArray();
                   $spectrum_name = $get_spectrum['name'];

                   if($spectrum_name=="Hemp Seed" && $concentration=="")
                   {

                   }
                   else
                   {
                        $response['status']       = 'warning';
                        $response['description']  = 'Please enter concentration';
                        return response()->json($response);
                   }
                 } 

            }//isset spectrum
            else
            {
                 $response['status']       = 'warning';
                 $response['description']  = 'Please enter concentration';
                 return response()->json($response);
            }



               
        }


        // if(isset($category_name) && !empty($category_name) && ($category_name=="Edibles") && isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) &&  $age_restriction=="2"){

        //      $response['status']       = 'warning';
        //      $response['description']  = 'You can not select age 21+ For this category.';
        //      return response()->json($response); 

        // }




          // if($concentration=="")
          // {
          //     $response['status']       = 'warning';
          //     $response['description']  = 'Please enter concentration';
          //     return response()->json($response);
          // }


        /******************* Code for multiple images ***************************/
       /*  if ($request->hasFile('product_image')) 
        {
            foreach($request->file('product_image') as $image)
            {
                 //Validation for product image
                 $file_extension = strtolower(($image)->getClientOriginalExtension());
                 if(!in_array($file_extension,['jpg','png','jpeg']))
                 {
                      $response['status']       = 'ImageFAILURE';
                      $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                        return response()->json($response);
                  }
            }
           
        }*/
        /******************* end of code for multiple images ***************************/
        if($is_update_process==false){
           $check_product_title = $this->ProductModel
                                        ->where('product_name',$form_data['product_name'])
                                        ->first();
        }else{
           $check_product_title = $this->ProductModel
                                        ->where('product_name',$form_data['product_name'])
                                        ->where('id','!=',$form_data['id'])
                                        ->first();
        }
       
        // dd($check_product_title);
        if($check_product_title)
        {   

          $response['status']      = "error";
          $response['description'] = "The product with the same name already exists, please use the different name";
          return response()->json($response);
        
        }


           /******************subscripition*************************/
           /*  $user_subscried = 0;
              if ($user->subscribed('main')) {
                  $user_subscried = 1;

              }else{
                $user_subscried =0;
              }
              $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$user->id)->where('membership_status','1')->get();
               if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
               {
                $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
               }

                $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                          ->where('user_id',$user->id)
                          ->where('membership_status','0')
                          ->where('is_cancel','1')
                          ->orderBy('id','desc')
                          ->first(); 
                if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                {
                  $get_cancelmembershipdata = $get_cancelmembershipdata->toArray();
                  
                }          

                  $res_active_productcount = $this->ProductModel->with('first_level_category_details')
                                                ->where('is_active','1')
                                                ->where('user_id',$user->id)
                                                ->get()->count();


                if($form_data['is_active']=="1"){                                

                if($user_subscried=="1" && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                {
                   $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                    if($res_active_productcount==$product_limit)
                    {
                      $response['status']      = "error";
                      $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                       return response()->json($response);
                    }
                    elseif($res_active_productcount<=$product_limit)
                    {

                    }

                } 
                else if($user_subscried!='1' && isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                {
                   
                     $product_limit = isset($get_cancelmembershipdata['product_limit'])?$get_cancelmembershipdata['product_limit']:'0';

                     if($res_active_productcount==$product_limit)
                    {
                      $response['status']      = "error";
                      $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                       return response()->json($response);
                    }
                    elseif($res_active_productcount<=$product_limit)
                    {

                    }


                }else if($user_subscried!='1' && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata) && $user_subscriptiontabledata[0]['membership']=="1")
                { 
                    $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                    if($res_active_productcount==$product_limit)
                    {
                      $response['status']      = "error";
                      $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                       return response()->json($response);
                    }
                    elseif($res_active_productcount<=$product_limit)
                    {

                    }
                }//else if free     
              }//if is active is 1       */                    

       /******************subscripition**********************/

         /******************* end of code for multiple images ***************************/

           if(isset($form_data['sku']) && !empty($form_data['sku']))
           { 
                if($is_update_process==false){
                   $check_sku = $this->ProductModel
                                                ->where('sku',$form_data['sku'])
                                                ->first();
                }else{
                   $check_sku = $this->ProductModel
                                                ->where('sku',$form_data['sku'])
                                                ->where('id','!=',$form_data['id'])
                                                ->first();
                }
               
                if($check_sku)
                {   

                  $response['status']      = "error";
                  $response['description'] = "Product with the same SKU already exist, please add another product";
                  return response()->json($response);
                
                }
           } //if isset sku

           /************start****check restricted categories for the seller************/
            $restricted_cat_ids ='';
            $check_restricted_categories = get_seller_restricted_categories();
            if(isset($check_restricted_categories) && !empty($check_restricted_categories))
            {
                $restricted_cat_ids = isset($check_restricted_categories['restricted_state_category_ids'])?$check_restricted_categories['restricted_state_category_ids']:'';

                if(isset($restricted_cat_ids) && !empty($restricted_cat_ids))
                {
                    $catids = explode(",",$restricted_cat_ids);
                    if(isset($catids) && !empty($catids))
                    {
                        /* if(in_array($form_data['first_level_category_id'], $catids))
                        {
                           $response['status']      = "error";
                           $response['description'] = "You are not allowed to sell this item based on your state laws";
                           return response()->json($response);
                        }*/
                    }           
                }//if isset restricted_cat_ids      
            } // check_restricted_categories

            /********end***check restricted categories for the seller************/
          
              
            $productlist = $this->ProductService->save($form_data,$request);
            if($productlist)
            {
      
              if($is_update_process==true)
              {
                $response['status']      =  "success";
                $response['description'] =  "Product details updated successfully."; 
                $response['link']        =  url('/').'/seller/product';
              }
              else
              {
                $response['status']      =  "success";
                $response['description'] =  "Product added successfully.";
                $response['link']        =  url('/').'/seller/product'; 
              }
            }
            else
            {
                $response['status']      = "error";
                $response['description'] = "Error occurred while adding product.";
            }
          
        return response()->json($response);
    }     

     public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->ProductModel->where('id', $id)->first();
    
        $arr_product = [];
        if($obj_data)
        {
           $arr_product = $obj_data->toArray(); 
        }
        $brandname = $this->BrandModel->where('id',$arr_product['brand'])->first();
        if(!empty($brandname))
        {
          $brandname = $brandname->toArray();
        }

        $drop_shipper = $this->DropShipperModel->where('id',$arr_product['drop_shipper'])->first();
        if(!empty($drop_shipper))
        {
          $drop_shipper = $drop_shipper->toArray();
        }


        $Product_cannabinoid = $this->ProductCannabinoidsModel->where('product_id',$id)->get();
        if(isset($Product_cannabinoid))
        {
          $Product_cannabinoid = $Product_cannabinoid->toArray();
        } 

      
         $arr_product_image = $this->ProductImagesModel->where('product_id',$id)->get()->toArray();
        $arr_category  = $this->FirstLevelCategoryModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_category']            = isset($arr_category) ?$arr_category:[];
        $arr_secondcategory  = $this->SecondLevelCategoryModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_secondcategory']   = isset($arr_secondcategory) ?$arr_secondcategory:[];

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();
        $res_age_Restriction = $this->AgeRestrictionModel->select('id','age')->get()->toArray();


        $sellerdropdown = DB::table($user_details)
                          ->select(DB::raw($user_details.'.*'))
                          ->leftjoin($prefix_seller_detail,$prefix_seller_detail.'.user_id','=',$prefix_user_detail.'.id')->where($user_details.'.user_type','seller') 
                          ->get()->toArray();


        $product_inventory = $this->ProductInventoryModel->where('product_id',$id)->first();
        if(isset($product_inventory))
        {
          $product_inventory = $product_inventory->toArray();
        }

        $product_dimensions  = $this->ProductDimensionsModel->where('product_id',$id)->get();  
        if(isset($product_dimensions))
        {
           $product_dimensions = $product_dimensions->toArray();
        }                 
  
        $this->arr_view_data['product_inventory']  = isset($product_inventory)?$product_inventory:[];    

        $this->arr_view_data['product_dimensions'] = isset($product_dimensions)?$product_dimensions:[];    
        $this->arr_view_data['product_cannabinoid']  = isset($Product_cannabinoid)?$Product_cannabinoid:[];  

         $this->arr_view_data['sellerdropdown']    = $sellerdropdown;     
    
        $this->arr_view_data['product_public_img_path']  = $this->product_public_img_path;
        $this->arr_view_data['additional_product_public_img_path']  = $this->add_product_public_img_path;
        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
       // $this->arr_view_data['module_url_path']          = $this->module_url_path;
        
        $this->arr_view_data['arr_product']              = isset($arr_product) ? $arr_product : [];  
        $this->arr_view_data['page_title']               = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']             = $this->module_title;
        $this->arr_view_data['arr_product_image']        = isset($arr_product_image)?$arr_product_image:[];   
        $this->arr_view_data['age_restrictiondata']      = isset($res_age_Restriction)?$res_age_Restriction:[];        
        $this->arr_view_data['brandname']         = isset($brandname)?$brandname:[]; 
        $this->arr_view_data['drop_shipper']      = isset($drop_shipper)?$drop_shipper:[];         



        if(isset($arr_product['first_level_category_id']) && !empty($arr_product['first_level_category_id']))
        {

         $get_first_cat =[]; $category_name='';
         $get_first_cat = $this->FirstLevelCategoryModel->where('id',$arr_product['first_level_category_id'])->first();
         if(isset($get_first_cat) && !empty($get_first_cat))
         {
           $get_first_cat = $get_first_cat->toArray();
            $category_name = $get_first_cat['product_type'];
         } 

        }
        $this->arr_view_data['db_cat_name']  = isset($category_name)?$category_name:[];     

 
         if(isset($arr_product['spectrum']) && !empty($arr_product['spectrum']))
        {

         $get_spectrum =[]; $spectrum_name='';
         $get_spectrum = $this->SpectrumModel->where('id',$arr_product['spectrum'])->first();
         if(isset($get_spectrum) && !empty($get_spectrum))
         {
           $get_spectrum = $get_spectrum->toArray();
           $spectrum_name = $get_spectrum['name'];
         } 

        }
        $this->arr_view_data['db_spectrum_name']  = isset($spectrum_name)?$spectrum_name:[];     

         $is_certificate_exists = 0;
        if(file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate']) && isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate']))
        {
            $is_certificate_exists = 1;
        }
        $this->arr_view_data['is_certificate_exists']  = isset($is_certificate_exists)?$is_certificate_exists:0; 
  
      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

    // Copy the Product 
    public function copy_product($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->ProductModel->where('id', $id)->first();
    
        $arr_product = [];
        if($obj_data)
        {
           $arr_product = $obj_data->toArray(); 
        }
        $brandname = $this->BrandModel->where('id',$arr_product['brand'])->first();
        if(!empty($brandname))
        {
          $brandname = $brandname->toArray();
        }

        $drop_shipper = $this->DropShipperModel->where('id',$arr_product['drop_shipper'])->first();
        if(!empty($drop_shipper))
        {
          $drop_shipper = $drop_shipper->toArray();
        }

      

        $arr_product_image = $this->ProductImagesModel->where('product_id',$id)->get()->toArray();
        $arr_category  = $this->FirstLevelCategoryModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_category']            = isset($arr_category) ?$arr_category:[];
        $arr_secondcategory  = $this->SecondLevelCategoryModel->where('is_active','1')
                                                       ->get()
                                                       ->toArray(); 
        $this->arr_view_data['arr_secondcategory']   = isset($arr_secondcategory) ?$arr_secondcategory:[];

        $product_dimensions  = $this->ProductDimensionsModel->where('product_id',$id)->get();  
        if(isset($product_dimensions))
        {
           $product_dimensions = $product_dimensions->toArray();
        }        
        $this->arr_view_data['product_dimensions'] = isset($product_dimensions)?$product_dimensions:[];   

        $Product_cannabinoid = $this->ProductCannabinoidsModel->where('product_id',$id)->get();
        if(isset($Product_cannabinoid))
        {
          $Product_cannabinoid = $Product_cannabinoid->toArray();
        }  


        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();
        $res_age_Restriction = $this->AgeRestrictionModel->select('id','age')->get()->toArray();


        $sellerdropdown = DB::table($user_details)
                          ->select(DB::raw($user_details.'.*'))
                          ->leftjoin($prefix_seller_detail,$prefix_seller_detail.'.user_id','=',$prefix_user_detail.'.id')->where($user_details.'.user_type','seller') 
                          ->get()->toArray();


        $product_inventory = $this->ProductInventoryModel->where('product_id',$id)->first();
        if(isset($product_inventory))
        {
          $product_inventory = $product_inventory->toArray();
        }                   
  
        $this->arr_view_data['product_inventory']  = isset($product_inventory)?$product_inventory:[];    



         $this->arr_view_data['sellerdropdown']   = $sellerdropdown;     
    
        $this->arr_view_data['product_public_img_path']  = $this->product_public_img_path;
        $this->arr_view_data['additional_product_public_img_path']  = $this->add_product_public_img_path;
        
        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
       // $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['arr_product']              = isset($arr_product) ? $arr_product : [];  
        $this->arr_view_data['page_title']               = "Duplicate ".$this->module_title;
        $this->arr_view_data['module_title']             = $this->module_title;
        $this->arr_view_data['product_cannabinoid']  = isset($Product_cannabinoid)?$Product_cannabinoid:[];  
        
        $this->arr_view_data['arr_product_image']        = isset($arr_product_image)?$arr_product_image:[];   
        $this->arr_view_data['age_restrictiondata']      = isset($res_age_Restriction)?$res_age_Restriction:[];        
        $this->arr_view_data['brandname']                = isset($brandname)?$brandname:[];
        $this->arr_view_data['drop_shipper']             = isset($drop_shipper)?$drop_shipper:[];         
        

        if(isset($arr_product['first_level_category_id']) && !empty($arr_product['first_level_category_id']))
        {

         $get_first_cat =[]; $category_name='';
         $get_first_cat = $this->FirstLevelCategoryModel->where('id',$arr_product['first_level_category_id'])->first();
         if(isset($get_first_cat) && !empty($get_first_cat))
         {
           $get_first_cat = $get_first_cat->toArray();
            $category_name = $get_first_cat['product_type'];
         } 
        }
        $this->arr_view_data['db_cat_name']  = isset($category_name)?$category_name:[];    


          if(isset($arr_product['spectrum']) && !empty($arr_product['spectrum']))
        {

         $get_spectrum =[]; $spectrum_name='';
         $get_spectrum = $this->SpectrumModel->where('id',$arr_product['spectrum'])->first();
         if(isset($get_spectrum) && !empty($get_spectrum))
         {
           $get_spectrum = $get_spectrum->toArray();
           $spectrum_name = $get_spectrum['name'];
         } 

        }
        $this->arr_view_data['db_spectrum_name']  = isset($spectrum_name)?$spectrum_name:[]; 


          $is_certificate_exists = 0;
        if(file_exists(base_path().'/uploads/product_images/'.$arr_product['product_certificate']) && isset($arr_product['product_certificate']) && !empty($arr_product['product_certificate']))
        {
            $is_certificate_exists = 1;
        }
        $this->arr_view_data['is_certificate_exists']  = isset($is_certificate_exists)?$is_certificate_exists:0; 
         

  
      return view($this->module_view_folder.'.copy_product',$this->arr_view_data);   
    }

    // End of  Copy the Product 

    // Copy Product Save COntroller
    public function copy_product_save(Request $request)
    {
        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;
        }

        $form_data = $request->all();


        /*if( (strpos($form_data['product_name'], 'cbd') !== false) || (strpos($form_data['product_name'], 'CBD') !== false) || (strpos($form_data['product_name'], 'thc') !== false) || (strpos($form_data['product_name'], 'THC') !== false) )
        {
            $response['status']      = 'warning';
            $response['description'] = 'Remove the word "CBD", if your products contain any form of cannabinoids, please identify it in your certificate of analysis of your product(s)';

            return response()->json($response);
        }*/

          $sku  = isset($form_data['sku'])?$form_data['sku']:'';


        $is_age_limit      = isset($form_data['is_age_limit'])?$form_data['is_age_limit']:0;
        $age_restriction   = isset($form_data['age_restriction'])?$form_data['age_restriction']:'';
        $shipping_type     = isset($form_data['shipping_type']) ? $form_data['shipping_type'] : '';
        $shipping_charges  = isset($form_data['shipping_charges']) ? $form_data['shipping_charges'] : '';
        $shipping_duration = isset($form_data['shipping_duration'])?$form_data['shipping_duration']:'';

        $is_active = isset($form_data['is_active'])?$form_data['is_active']:0;
        $brand = isset($form_data['brand'])?$form_data['brand']:'';

        $unit_price = isset($form_data['unit_price'])?$form_data['unit_price']:'';

        $concentration = isset($form_data['per_product_quantity'])?$form_data['per_product_quantity']:'';
        $product_video_source = isset($form_data['product_video_source'])?$form_data['product_video_source']:'';
        $product_video_url = isset($form_data['product_video_url'])?$form_data['product_video_url']:'';

         $first_level_category_id = isset($form_data['first_level_category_id'])?$form_data['first_level_category_id']:'';
          
         $get_first_cat =[]; $category_name='';
         $get_first_cat = $this->FirstLevelCategoryModel->where('id',$first_level_category_id)->first();
         $description  = isset($form_data['description'])?$form_data['description']:'';
         if(strpos($product_video_url,'http') === 0)
          {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter valid Youtube/Vimeo url short code';
            return response()->json($response);
          }
         if(isset($get_first_cat) && !empty($get_first_cat))
         {
           $get_first_cat = $get_first_cat->toArray();
           $category_name = $get_first_cat['product_type'];
         } 
        // dd($form_data);

          $spectrum = isset($form_data['spectrum'])?$form_data['spectrum']:'';


        $form_data['user_id'] = $seller_id;
        $form_data['is_age_limit'] = $is_age_limit;
        $form_data['age_restriction'] = $age_restriction;
        $form_data['is_active'] = $is_active;
        $form_data['spectrum'] = $spectrum;
        $form_data['sku'] = $sku;


        $arr_rules = [];

        $arr_rules =    [
                           'product_name'             => 'required',
                           'first_level_category_id'  => 'required',
                           'second_level_category_id' => 'required',
                           'description'              => 'required|min:150',
                           'unit_price'               => 'required|numeric|min:1|not_in:0',
                           'shipping_type'            => 'required',
                           //'user_id'                => 'required',
                           'product_stock'            => 'required|numeric|min:1|not_in:0',
                           // 'per_product_quantity'  => 'required',
                           'brand'                    => 'required'
                           //'is_age_limit'           => 'required'
                        ];

         

         if($product_video_source == "youtube" || $product_video_source == "vimeo")
         {
            $arr_rules['product_video_source'] = 'required';
            $arr_rules['product_video_url'] = 'required';
         }


         $validator = Validator::make($request->all(),$arr_rules);

         if($validator->fails())
         { 
            $description = Validator::make($request->all(),$arr_rules)->errors()->first();

            $response['status']      = 'warning';
            $response['description'] = $description;
            // $response['description'] = 'Form validation failed..Please check all fields..';

            return response()->json($response);
         }

        /*if($is_age_limit=='1' && $age_restriction=="")
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter age restriction';

            return response()->json($response);
        }*/

        if ($shipping_type == '1' && $shipping_charges == "") {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter shipping charges';

            return response()->json($response);
        }
        if($description)
        {
          $string = strip_tags($description);
          $keywords = preg_replace('/[\s]+/', ' ', $string);
          $keywordsarr = explode(" ", str_replace("&nbsp;"," ",$keywords));
        
          $keyarr =[];
          foreach ($keywordsarr as $k1=>$keyword)
          {
              $check_description = $this->KeywordsModel
                                      // ->where('keyword_name','LIKE','%'.$keyword.'%')
                                      ->where('keyword_name',$keyword)
                                      ->where('is_active','1')
                                      ->count();
              if($check_description>0)
              {
                $keyarr[] = $keyword;
              }
           }//foreach


          if(isset($keyarr) && !empty($keyarr))
          {
            $keyarr = array_filter($keyarr);
            
            $excluded_keywords = implode(",", array_filter($keyarr));
            if(isset($excluded_keywords) && !empty($excluded_keywords))
            {
                  $response['status']      = 'warning';
                  // $response['description'] = 'Please do not enter '.$excluded_keywords.' in the description.';
                  $response['description'] = 'Remove all health claims from your product description';

                  return response()->json($response);
            }
              
          }
        }
        // validation for shipping charges not greater than unit price.
        if($shipping_type=='1')
        {
           if(isset($unit_price) && isset($shipping_charges))
           {
               if($shipping_charges>$unit_price)
               {
                $response['status'] = 'warning';
                $response['description'] = 'Shipping charges should not be greater than unit price';
                 return response()->json($response);
               }
           }
        } 



         if ($request->hasFile('product_image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('product_image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image. Only jpg, png, jpeg extensions are allowed.';
                return response()->json($response);
            }

        } 


        if ($request->hasFile('product_certificate')) 
        {
           //Validation for product certificate image
           $file_extension = strtolower($request->file('product_certificate')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg','pdf']))
           {
                $response['status']       = 'CertificateFAILURE';
                $response['description']  = 'Invalid image. Only jpg, png, jpeg extensions are allowed.';
                return response()->json($response);
            }
        } 

         if(isset($category_name) && !empty($category_name) && ($category_name=="Essential Oils" || $category_name=="Accessories") && $concentration==""){

        }elseif(isset($category_name) && !empty($category_name) && ($category_name!="Essential Oils" || $category_name!="Accessories") && $concentration=="")
        {

               if(isset($form_data['spectrum']) && !empty($form_data['spectrum']))
               {

                 $get_spectrum =[]; $spectrum_name='';
                 $get_spectrum = $this->SpectrumModel->where('id',$form_data['spectrum'])->first();
                 if(isset($get_spectrum) && !empty($get_spectrum))
                 {
                   $get_spectrum = $get_spectrum->toArray();
                   $spectrum_name = $get_spectrum['name'];

                   if($spectrum_name=="Hemp Seed" && $concentration=="")
                   {

                   }
                   else
                   {
                        $response['status']       = 'warning';
                        $response['description']  = 'Please enter concentration';
                        return response()->json($response);
                   }
                 } 
              }else
              {
                 $response['status']       = 'warning';
                 $response['description']  = 'Please enter concentration';
                 return response()->json($response);    
              }
               
        }//if another category

      


       // if(isset($category_name) && !empty($category_name) && ($category_name=="Edibles") && isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) &&  $age_restriction=="2"){

       //       $response['status']       = 'warning';
       //       $response['description']  = 'You can not select age 21+ For this category.';
       //       return response()->json($response); 

       //  }




        // if($concentration=="")
        // {
        //     $response['status']       = 'warning';
        //     $response['description']  = 'Please enter concentration';
        //     return response()->json($response);
        // }



        if(isset($form_data['sku']) && !empty($form_data['sku']))
        {

            $check_sku = $this->ProductModel->where('sku',$form_data['sku'])->first();
            if($check_sku)
            {   

              $response['status']      = "error";
              $response['description'] = "Product with the same SKU already exist, please add another product";
                return response()->json($response);
            } // if check_sku
        }//if isset sku




        $check_product_title = $this->ProductModel->where('product_name',$form_data['product_name'])->first();
        // dd($check_product_title);
        if($check_product_title)
        {   

          $response['status']      = "error";
          $response['description'] = "The product with the same name already exists, please use the different name";
        
        }else
        {




           /******************subscripition*************************/
              $user_subscried = 0;
              if ($user->subscribed('main')) {
                  $user_subscried = 1;

              }else{
                $user_subscried =0;
              }
              $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$user->id)->where('membership_status','1')->get();
               if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
               {
                $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
               }

                $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                          ->where('user_id',$user->id)
                          ->where('membership_status','0')
                          ->where('is_cancel','1')
                          ->orderBy('id','desc')
                          ->first(); 
                if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                {
                  $get_cancelmembershipdata = $get_cancelmembershipdata->toArray();
                  
                }          

                  $res_active_productcount = $this->ProductModel->with('first_level_category_details')
                                                ->where('is_active','1')
                                                ->where('user_id',$user->id)
                                                ->get()->count();


                if($form_data['is_active']=="1"){     



                if($user_subscried=="1" && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                {
                   $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                    if($res_active_productcount==$product_limit)
                    {
                      $response['status']      = "error";
                      $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                       return response()->json($response);
                    }
                    elseif($res_active_productcount<=$product_limit)
                    {

                    }

                } 

                else if($user_subscried!='1' && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata) && $user_subscriptiontabledata[0]['membership']=="1")
                { 
                  

                    $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                    if($res_active_productcount==$product_limit)
                    {
                      $response['status']      = "error";
                      $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                       return response()->json($response);
                    }
                    elseif($res_active_productcount<=$product_limit)
                    {

                    }
                }//else if free     
                else if($user_subscried!='1' && isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                {
                   
                     $product_limit = isset($get_cancelmembershipdata['product_limit'])?$get_cancelmembershipdata['product_limit']:'0';

                     if($res_active_productcount==$product_limit)
                    {
                      $response['status']      = "error";
                      $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                       return response()->json($response);
                    }
                    elseif($res_active_productcount<=$product_limit)
                    {

                    }
                }//elseif

              }//if is active is 1                          


       /******************subscripition**********************/

         /************start****check restricted categories for the seller********/

            $check_restricted_categories = get_seller_restricted_categories();
            if(isset($check_restricted_categories) && !empty($check_restricted_categories))
            {
                $restricted_cat_ids = isset($check_restricted_categories['restricted_state_category_ids'])?$check_restricted_categories['restricted_state_category_ids']:'';

                if(isset($restricted_cat_ids) && !empty($restricted_cat_ids))
                {
                    $catids = explode(",",$restricted_cat_ids);
                    if(isset($catids) && !empty($catids))
                    {
                        /* if(in_array($form_data['first_level_category_id'], $catids))
                        {
                           $response['status']      = "error";
                           $response['description'] = "You are not allowed to sell this item based on your state laws";
                           return response()->json($response);
                        }*/
                    }          
                } // if restricted_cat_ids     
            } // check_restricted_categories

      /********end***check restricted categories for the seller************/


        

          $productlist = $this->ProductService->save($form_data,$request);

          if($productlist)
          {
            $response['status']      =  "success";
            $response['description'] =  "Product duplicated successfully.";
            $response['link']        =  url('/').'/seller/product'; 
           
          } 
          else
          {
            $response['status']      = "warning";
            $response['description'] = "Error occurred while copying product.";
          }
        
        }
        return response()->json($response);
    }

    // End of Copy Product Save COntroller

    public function multi_action(Request $request)
    {
        /*Check Validations*/
        $input = request()->validate([
                'multi_action' => 'required',
                'checked_record' => 'required'
            ], [
                'multi_action.required' => 'Please  select record required',
                'checked_record.required' => 'Please select record required'
            ]);

        $multi_action   = $request->input('multi_action');
        $checked_record = $request->input('checked_record');


        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Flash::error('Problem Occurred, While Doing Multi Action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
               $this->perform_delete(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Deleted Successfully'); 
            } 
            elseif($multi_action=="activate")
            {
               $this->perform_activate(base64_decode($record_id)); 
               Flash::success(str_plural($this->module_title).' Activated Successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $this->perform_deactivate(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Blocked Successfully');  
            }
        }

        return redirect()->back();
    }


    public function activate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        /*if($this->perform_activate(base64_decode($enc_id)))
        {
             $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
        }*/

        $arr = $this->perform_activate(base64_decode($enc_id));
        if(isset($arr))
        {
            $status =    $arr['status'];
            $msg    =    $arr['msg'];

            if($status=="SUCCESS")
            {
               $arr_response['status'] = 'SUCCESS';
                $arr_response['msg'] = '' ;
            }
            else
            {
              $arr_response['status'] = 'ERROR';
              $arr_response['msg'] = $msg ;
            }
        }

        $arr_response['data'] = 'ACTIVE';
        return response()->json($arr_response);
    }

    public function deactivate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_deactivate(base64_decode($enc_id)))
        {
            $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }


       public function perform_activate($id)
    {
        $entity = $this->ProductModel->where('id',$id)->first();
        $user = Sentinel::check();      
        $arr = [];  
        
        if($entity)
        {


           $get_product = $this->ProductModel->where('id',$id)->get()->toArray();


           if(!empty($get_product))
           {
                $first_cat = $get_product[0]['first_level_category_id'];
                $second_cat = $get_product[0]['second_level_category_id'];

                if(isset($first_cat) && isset($second_cat))
                {

                      $check_firstcat_active = $this->FirstLevelCategoryModel
                                        ->where('id',$first_cat)
                                        ->where('is_active',1)
                                        ->get()->toArray();
                      $check_secondcat_active = $this->SecondLevelCategoryModel
                                        ->where('id',$second_cat)
                                        ->where('is_active',1)
                                        ->get()->toArray();        
                                        
                       if(empty($check_firstcat_active) || empty($check_secondcat_active))
                       {
                          return false;
                          $arr['status'] = "ERROR";
                          $arr['msg'] = 'Please activate the category and subcatgory of this product';
                          return $arr;
                       }
                       else
                       {


                          /******************subscripition*************************/
                           $user_subscried = 0;
                            if ($user->subscribed('main')) {
                                $user_subscried = 1;

                            }else{
                              $user_subscried =0;
                            }
                            $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$user->id)->where('membership_status','1')->get();
                             if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                             {
                              $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
                             }

                              $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                                        ->where('user_id',$user->id)
                                        ->where('membership_status','0')
                                        ->where('is_cancel','1')
                                        ->orderBy('id','desc')
                                        ->first(); 
                              if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                              {
                                $get_cancelmembershipdata = $get_cancelmembershipdata->toArray();
                                
                              }          

                                $res_active_productcount = $this->ProductModel->with('first_level_category_details')
                                                              ->where('is_active','1')
                                                              ->where('user_id',$user->id)
                                                              ->get()->count();

                             // if($user_subscried=="1" && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                              if($user_subscried=="1" && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata) || ( isset($user_subscriptiontabledata[0]['membership']) && $user_subscriptiontabledata[0]['membership']=="1" && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata)))  
                              {
                                 $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                                  if($res_active_productcount==$product_limit)
                                  {
                                    $arr['status']      = "error";
                                    $arr['msg']         = "You’ve reached the product limit for this plan, please upgrade.";
                                    //  return false;
                                      return $arr;

                                   //  return response()->json($response);
                                  }
                                  elseif($res_active_productcount<=$product_limit)
                                  {

                                  }

                              } 
                              // else if($user_subscried!='1' && isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                              else if($user_subscried!='1' && isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata) && empty($user_subscriptiontabledata))   
                              {

                                  $membershiptype = $get_cancelmembershipdata['membership'];
                                  if($membershiptype=="1")
                                  {

                                        $arr['status']      = "error";
                                        $arr['msg']     = "You’ve reached the product limit for this plan, please upgrade.";
                                        return $arr;

                                  }
                                  else
                                  {
                                        $arr['status']      = "error";
                                        $arr['msg']     = "You’ve reached the product limit for this plan, please upgrade.";
                                        return $arr;   

                                       /***@25june*if cancelledpaid mem then can not active product*/

                                         /* $product_limit = isset($get_cancelmembershipdata['product_limit'])?$get_cancelmembershipdata['product_limit']:'0';

                                           if($res_active_productcount==$product_limit)
                                          {
                                            $arr['status']      = "error";
                                            $arr['msg']         = "You’ve reached the product limit for this plan, please upgrade.";
                                             return $arr;
                                          }
                                          elseif($res_active_productcount<=$product_limit)
                                          {

                                          }//else if
                                          */
                                        /**********end*25june20**cond*********************/


                                  }//else of paid mem

                                  //commented below code at 22 june 2o 

                                  /* $product_limit = isset($get_cancelmembershipdata['product_limit'])?$get_cancelmembershipdata['product_limit']:'0';

                                   if($res_active_productcount==$product_limit)
                                  {
                                    $arr['status']      = "error";
                                    $arr['msg']         = "You’ve reached the product limit for this plan, please upgrade.";
                                     return $arr;
                                  }
                                  elseif($res_active_productcount<=$product_limit)
                                  {

                                  }*/


                              }else if($user_subscried!='1' && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata) && $user_subscriptiontabledata[0]['membership']=="1")
                              { 
                                  $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                                  if($res_active_productcount==$product_limit)
                                  {
                                    $arr['status']      = "error";
                                    $arr['msg'] = "You’ve reached the product limit for this plan, please upgrade.";
                                    return $arr;
                                   // return false;
                                    // return response()->json($response);
                                  }
                                  elseif($res_active_productcount<=$product_limit)
                                  {

                                  }
                              }//else if free     

                          /******************subscripition**********************/

                          $updated =  $this->ProductModel->where('id',$id)->update(['is_active'=>'1']);

                          if($updated)
                          {
                            $arr['status'] = 'SUCCESS';
                             $arr['msg'] = '';
                            return $arr;
                          }


                       }//else of update                  
                }//if firstcat and second 

           }//if not empty product  
           
        }//if entity

       // return FALSE;
        return $arr;
    }

 
      public function perform_deactivate($id)
    {

        $entity = $this->ProductModel->where('id',$id)->first();
        if($entity)
        {
            return $this->ProductModel->where('id',$id)->update(['is_active'=>'0']);
        }
        return FALSE;
    }

    
   

     public function delete($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {
            Flash::success(str_singular($this->module_title).' Deleted Successfully');
        }
        else
        {
            Flash::error('Problem Occurred While Deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }

     public function perform_delete($id)
    {
        $entity          = $this->ProductModel->where('id',$id)->first();
    
        if($entity)
        {
            $product_images  = $this->ProductImagesModel->where('product_id',$id)->get()->toArray();

            foreach($product_images as $v)
            {
               $this->ProductImagesModel->where('product_id',$id)->delete();
                $unlink_old_img_path    = $this->product_image_base_img_path.'/'.$v['image'];
                $unlink_old_img_thumb_path    = $this->product_image_thumb_base_img_path.$v['image'];

                            
                if(file_exists($unlink_old_img_path))
                {
                    @unlink($unlink_old_img_path);  
                }
                if(file_exists($unlink_old_img_thumb_path))
                {
                    @unlink($unlink_old_img_thumb_path);  
                }
            }
         

            $this->ProductModel->where('id',$id)->delete();

            /*---------------------- Activity log Event--------------------------*/
              /*$arr_event                 = [];
              $arr_event['ACTION']       = 'REMOVED';
              $arr_event['MODULE_ID']    =  $id;
              $arr_event['MODULE_TITLE'] = $this->module_title;
              $arr_event['MODULE_DATA'] = json_encode(['id'=>$id,'status'=>'REMOVED']);

              $this->save_activity($arr_event);*/

              Flash::success(str_plural($this->module_title).' Deleted Successfully');
              return true; 
        }
        else
        {
          Flash::error('Problem Occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }



    public function view($productid)
    {
       $productid = base64_decode($productid);

        $this->arr['arr_data'] = array();
        $arr_product_data    = $this->ProductService->get_product_details($productid);

        $arr_comment = $this->ProductCommentModel->where('product_id',$productid)->with('reply_details.user_details','user_details')->get()->toArray();

        $this->arr_view_data['page_title']      = "Product Details";
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        // $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_product_data']        = $arr_product_data;  
        $this->arr_view_data['arr_comment']     = isset($arr_comment)?$arr_comment:[];      
        $this->arr_view_data['product_imageurl_path'] = $this->product_imageurl_path;

       
        return view($this->module_view_folder.'.view', $this->arr_view_data);
    }
       

    public function build_select_options_array(array $arr_data,$option_key,$option_value,array $arr_default)
    {

        $arr_options = [];
        if(sizeof($arr_default)>0)
        {
            $arr_options =  $arr_default;   
        } 

        if(sizeof($arr_data)>0)
        {
            foreach ($arr_data as $key => $data) 
            {
                if(isset($data[$option_key]) && isset($data[$option_value]))
                {
                    $arr_options[$data[$option_key]] = $data[$option_value];
                }
            }
        }

        return $arr_options;
    }


    public function approvedisapprove(Request $request)
    {

        $product_id = base64_decode($request->product_id);
        $verification_status  = $request->status;
        
        $is_available = $this->ProductModel->where('id',$product_id)->count()>0;
        
        if($is_available)
        {
            if($verification_status==1)
            {
                $update_field = 1;
            }
            else
            {
                $update_field = 0;
            }

            $status = $this->ProductModel->where('id',$product_id)->update(['is_approve'=>$update_field]);

            if($status)
            {       
                
                $response['status']      = 'SUCCESS';
                
                if($verification_status==1)
                {
                    $response['message'] = str_singular($this->module_title).' Approved Successfully';
                }
                else
                {
                    $response['message'] = str_singular($this->module_title).' Disapproved Successfully';
                }
                
            }
            else
            {
                $response['status']      = 'ERROR';
                $response['message']     = 'Problem occured while performing action';
            }
            
            return response()->json($response);
        }
        else
        {   
            $response['status']      = 'message';
            $response['message']     ='Something went wrong Please try again later';
            return response()->json($response);
        }
    }

   /******************product import bulk upload functionality***************/

    public function importExcel(Request $request)
    {

        $request->validate([
            'import_file' => 'required'
        ]);

        $extension_array = ['xlsx'];

        $user = Sentinel::getUser();

        if($request->hasFile('import_file'))
        {           
            $path = $request->file('import_file')->getRealPath(); 
            $extenstion = $request->file('import_file')->getClientOriginalExtension();
            if(!in_array($extenstion,$extension_array)){

               $response['status'] = "warning";        
               $response['description'] ='Please select valid file,Allowed only xlsx file type'; 

            }else{

          //  $data = \Excel::load($path)->get(); 
              $data = Excel::selectSheetsByIndex(0)->load($path)->get();

               $successful_insertion_count = 0;

               $user_details = Sentinel::getUser();
               $loguser_id   = $user_details->id;
               $dbproduct_count =  $user_details->product_count;
               $dbproduct_limit =  $user_details->product_limit;

                /******************subscripition*************************/
                    $user_subscried = 0;
                    if ($user_details->subscribed('main')) {
                        $user_subscried = 1;

                    }else{
                      $user_subscried =0;
                    }
                    $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$user->id)->where('membership_status','1')->get();
                     if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                     {
                      $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
                     }

                      $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                                ->where('user_id',$user->id)
                                ->where('membership_status','0')
                                ->where('is_cancel','1')
                                ->orderBy('id','desc')
                                ->first(); 
                      if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                      {
                        $get_cancelmembershipdata = $get_cancelmembershipdata->toArray();
                        
                      }          




                      

                  /******************subscripition**********************/


            if($data->count()){
                $erromsg = [];
                $checkproductexists =0;


               if(!empty($data) && $data->count())
               {


                foreach ($data as $key => $value)
                {
                    $html ='';
                    $shipping_charges =0;

                    $firstlevel = $value->first_level_category; 
                    $secondlevel = $value->second_level_category;
                    $unit = $value->unit;
                    $product_name = $value->product_name;
                    $description = $value->description;
                   // $stock = $value->stock;  //renamed to total_quantity_avaliable
                    $stock = $value->total_quantity_avaliable;
                 
                   // $unit_price = $value->unit_price; //renamed to price
                    $unit_price = $value->price;
                   

                    // $is_age_limit = $value->is_age_limit;
                    // $age_restriction = $value->age_restriction;

                     $is_age_limit = '';
                     $age_restriction = '';



                    $brand = $value->brand;
                    $dropshipper_name = $value->dropshipper_name;

                 // $per_product_quantity = $value->per_product_quantity; // renamed to concentration
                    $per_product_quantity = $value->concentration;

                    $price_drop_to = $value->price_drop_to;
                    $shipping_type = $value->shipping_type;
                    $shipping_charges = $value->shipping_charges;
                    $product_video_source = $value->product_video_source;
                    $product_video_url = $value->product_video_url;


                    if($firstlevel=="")
                    {
                        $html .='First level category is required'; 
                    }else{
                        $html .='';
                    }

                    if($secondlevel=="")
                    {
                        $html .=' , Second level category is required';
                    }else{
                        $html .='';
                    }
                    if($unit=="")
                    {
                        $html .=', Unit is required';
                    }else{
                        $html .='';
                    }

                     if($product_name=="")
                    {
                        $html .=' , Product name is required';
                    }                    
                    else{
                        $html .='';
                    }
                     if($description=="")
                    {
                        $html .=' , Description is required';
                    }else{
                        $html .='';
                    }

                     if($stock=="")
                    {
                        $html .=' , Stock is required';
                    }
                    else if(!is_numeric($stock))
                    {
                       $html .=' , Stock should be numeric';
                    }
                    else if($stock<0)
                    {
                       $html .=' , Stock should not be less than 0';
                    }
                    else{
                        $html .='';
                    }
                    if($unit_price=="")
                    {
                        $html .=' , Please enter unit price';
                    }
                    else if($unit_price!="")
                    {
                        if (!is_float($unit_price)) { 
                            $html .=' , Unit price should be valid';
                        }
                        else if ($unit_price<0) { 
                            $html .=' , Unit price should not be less than 0';
                        }
                        else {
                            $html .='';

                        }
                      
                    }
                    else
                    {
                      $html .=''; 
                    }

                  /*  if(!is_numeric($is_age_limit) && isset($is_age_limit))
                    {
                        $html .=', Age limit should be numeric';
                    }else{
                        $html .='';
                    }

                    if($is_age_limit==1 && $age_restriction=="")
                    {
                        $html .=' , Please select age restriction';
                    }else{
                        $html .='';
                    }
                    */


                    if($brand=="")
                    {
                      $html .=" , Please enter brand";
                    }else{
                       $html .='';
                    }

                    /*if($per_product_quantity=="")
                    {
                      $html .=" , Please enter per product quantity";
                    }else{
                       $html .='';
                    }*/

                     if($shipping_type=="")
                    {
                      $html .=" , Please select shipping type";
                    }else{
                       $html .='';
                    }

                     if($price_drop_to<0)
                    {
                      $html .=" , Price drop value should not be less than 0";
                    }else{
                       $html .='';
                    }

                    if(preg_match("/[a-z]/i", $price_drop_to))
                    {
                       $html .=" , Please enter valid price drop value";
                    }else{
                       $html .='';
                    }

                     if( (preg_match("/[a-z]/i", $per_product_quantity)) || ($per_product_quantity=="") && isset($firstlevel) && ($firstlevel=="Essential Oils" || $firstlevel=="Accessories" ))
                    {
                       $html .='';
                    }
                    elseif((preg_match("/[a-z]/i", $per_product_quantity)) || ($per_product_quantity=="") && isset($firstlevel) && ($firstlevel!="Essential Oils" || $firstlevel!="Accessories" ))
                    {
                      $html .=" , Please enter valid concentration value";                      
                    }else{
                       $html .='';
                    }

                    if($per_product_quantity<0)
                    {
                      $html .=" , concentration value should not be less than 0";
                    }else{
                       $html .='';
                    }

                    if(isset($stock) && ($stock>0))
                    {
                      $stock = $stock;                      
                    }else{
                      $stock =0;
                    }  

                     if(isset($unit_price) && ($unit_price>0))
                    {
                      $unit_price = $unit_price;                      
                    }else{
                      $unit_price =0;
                    }  

                    if(isset($per_product_quantity) && $per_product_quantity>0)
                    {
                      $per_product_quantity = $per_product_quantity;
                    }else{
                      $per_product_quantity = 0;
                    }


                    if(isset($price_drop_to) && $price_drop_to>0)
                    {
                      $price_drop_to = $price_drop_to;
                    }else{
                      $price_drop_to = 0;
                    }


                    $first_level_category_arr = $this->FirstLevelCategoryModel->select('product_type','id')->where('is_active',1)->where('product_type',$firstlevel)->get()->toArray();
                    if(!empty($first_level_category_arr)){
                       $first_categoryid = $first_level_category_arr[0]['id'];
                    }
                    else{
                        $html .=' , First Level category does not exists';
                        $first_categoryid = 0;
                    }

                    if(!empty($first_level_category_arr)){

                       $second_level_category_arr = $this->SecondLevelCategoryModel->select('name','id')->where('is_active',1)->where('name',$secondlevel)->where('first_level_category_id',$first_categoryid)  
                           ->get()->toArray();   

                        if(!empty($second_level_category_arr))
                        {
                            $second_categoryid = $second_level_category_arr[0]['id'];
                        }else{
                            $html .=' , Second Level category does not exists';
                            $second_categoryid=0;
                            $first_categoryid = 0;
                        }  
                    }else{
                         $html .=' , Second Level category does not exists';
                         $second_categoryid=0;
                         $first_categoryid = 0;
                    }

                    if($unit && !empty($second_level_category_arr))
                    {
                      $unitarr = $this->UnitModel->select('id','unit')->where('unit',$unit)->get()->toArray();
                      if(!empty($unitarr))
                      {
                         $unit_id = $unitarr[0]['id'];
                         $chk_second_category_arr = $this->SecondLevelCategoryModel->select('name','id')->where('is_active',1)->where('unit_id',$unit_id)->where('id',$second_categoryid)->get()->toArray();  
                         if(!empty($chk_second_category_arr))
                         {
                             $unit_id = $unitarr[0]['id'];

                         }else{
                             $html .=' , unit does not exists for second level category';
                             $unit_id=0;
                         }
                      }else{
                          $html .=' , Unit does not exists';
                          $unit_id=0;
                      }                      
                    }
                    else
                    {
                       $html .=' , Unit does not exists';
                       $unit_id=0;
                    }
 
                    $brandid = '';

                    if($brand!='')
                    {
                        $res_brand = $this->BrandModel->select('*')->where('name',$brand)->first();
                        if(!empty($res_brand))
                        {
                            $res_brand = $res_brand->toArray();                           
                            $brandid = $res_brand['id'];

                        }
                        else
                        {
                           $brandid = DB::table('brands')-> insertGetId(array(
                              'name' => $brand,
                            ));  
                        }
                    }

                     /************dropshipper*************************/
                        $dropshipperid = '';
                        if(isset($dropshipper_name))
                        {
                            $res_dropshipper = $this->DropShipperModel->select('*')->where('name',$dropshipper_name)->first();
                            if(!empty($res_dropshipper))
                            {
                                $res_dropshipper = $res_dropshipper->toArray();                           
                                $dropshipperid = $res_dropshipper['id'];

                            }
                            // else
                            // {
                            //    $dropshipperid = DB::table('drop_shipper')-> insertGetId(array(
                            //       'name' => $dropshipper_name,
                            //     ));  
                            // }
                        }

                     /************dropshipper********************/

                       /* if($is_age_limit==""){
                            $is_age_limit=0;
                        }
                        else if(!is_numeric($is_age_limit))
                        {
                            $is_age_limit=0;
                            $age_restriction = '';
                        } */

                        if($stock==""){
                            $stock=0;
                        }

                        if($unit_price!="" && is_float($unit_price)){
                            $unit_price = $unit_price;    
                        }else{
                            $unit_price ='0.00';
                        }

                  
                        /* if($is_age_limit==1 && $age_restriction!=""){
                            $age_restriction = $value->age_restriction;

                            $res_age_Restriction = $this->AgeRestrictionModel->select('id')->where('age',$age_restriction)->first()->toArray();
                             if(!empty($res_age_Restriction)){
                               $age_restriction = $res_age_Restriction['id'];
                             }
                          }
                          else{
                          $age_restriction = ''; 
                          }  */ 



                            $shiptype = 0;
                            if($shipping_type=="Free Shipping")
                            {
                              $shiptype = 0;
                            }
                            elseif($shipping_type=="Flat Shipping"){
                              $shiptype = 1;
                            } 

                            $dbshippingcharges = '0.000000';

                            if($shiptype=="1" && isset($shipping_charges))
                            {
                              $dbshippingcharges = $shipping_charges;

                            }else if($shiptype=="1" && empty($shipping_charges))
                            {
                              $dbshippingcharges = $dbshippingcharges;
                              
                            }
                            elseif($shiptype=="0"){
                               $dbshippingcharges = $dbshippingcharges;
                            }
                         
                            if(isset($product_video_source) && (!empty($product_video_source)))
                            {
                               if($product_video_url=="")
                               {
                                  $html .=' , Please enter the youtube/vimeo url short code';
                               }else{
                                 $html .= '';
                               }
                            }



                           if($product_name!="")
                            {
                                $check_product_exists = $this->ProductModel
                                                        ->where('product_name',$product_name)
                                                        ->get()->toArray();


                                  if(isset($check_product_exists) && (!empty($check_product_exists)))
                                  {
                                    $html .=' , Product name already exists';
                                  }else{
                                    $html .= '';
                                  }           

                            
                                /*if(!empty($check_product_exists)){                                    
                                       $checkproductexists = 1;                                   
                                }else{
                                       $checkproductexists = 0; */ 

                                       

                                       $arr = [
                                          'first_level_category_id'=>$first_categoryid,
                                          'second_level_category_id'=>$second_categoryid, 
                                          'user_id'=> $user->id,
                                          'product_name' => $value->product_name, 
                                          'description' => $value->description,
                                          'product_stock'=>$stock,
                                          'unit_price'=>$unit_price,
                                          'is_age_limit'=>$is_age_limit,
                                          'age_restriction'=>$age_restriction,                              
                                          'unit_id'=>$unit_id,
                                          'is_bulk_upload'=>1,
                                          'is_active'=>1,
                                          'brand'=>$brandid,
                                          'drop_shipper'=>$dropshipperid,
                                          'per_product_quantity'=>$per_product_quantity,
                                           'price_drop_to'=>$price_drop_to,
                                           'shipping_type'=> $shiptype,
                                           'shipping_charges'=>$dbshippingcharges, 
                                           'product_video_source'=>$product_video_source, 
                                           'product_video_url'=>$product_video_url, 
                                          'error_message'=>$html
                                         ];       



  
                                         if(!empty($arr)){

                                               $dbproduct_count++;

                                              /*if($dbproduct_count>$dbproduct_limit)
                                              {
                                                break;
                                                $response['status'] = "warning";        
                                                $response['description'] ='You have reached the product limit for this plan,please ugrade.';
                                              }
                                              else
                                              {*/


                                              $res_active_productcount = $this->ProductModel->with('first_level_category_details')
                                                      ->where('is_active','1')
                                                      ->where('user_id',$user->id)
                                                      ->get()->count();

                                                if($user_subscried=="1" && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                                              {
                                                 $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                                                  if($res_active_productcount==$product_limit)
                                                  {
                                                     break;
                                                    $response['status']      = "error";
                                                    $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                                                  }
                                                  elseif($res_active_productcount<=$product_limit)
                                                  {

                                                  }

                                              } 
                                              else if($user_subscried!='1' && isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                                              {
                                                 

                                                   $product_limit = isset($get_cancelmembershipdata['product_limit'])?$get_cancelmembershipdata['product_limit']:'0';

                                                   if($res_active_productcount==$product_limit)
                                                  {
                                                     break;
                                                    $response['status']      = "error";
                                                    $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                                                  }
                                                  elseif($res_active_productcount<=$product_limit)
                                                  {

                                                  }


                                              }else if($user_subscried!='1' && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata) && $user_subscriptiontabledata[0]['membership']=="1")
                                              { 
                                                  $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                                                  if($res_active_productcount==$product_limit)
                                                  {
                                                     break;
                                                    $response['status']      = "error";
                                                    $response['description'] = "You’ve reached the product limit for this plan, please upgrade.";
                                                  }
                                                  elseif($res_active_productcount<=$product_limit)
                                                  {

                                                  }
                                              }//else if free     






                                                //DB::table('product')->insert($arr);  
                                                $id = DB::table('product')->insertGetId($arr);   
                                                if($id)
                                                {
                                                    if($stock!="" || $stock>0){
                                                    $product_inventory = $this->ProductInventoryModel->firstOrNew(['product_id'=> $id]);       
                                                    $product_inventory->product_id = $id;
                                                    // $product_inventory->remaining_stock = $value->stock;
                                                    $product_inventory->remaining_stock = $stock;
                                                    $product_inventory->save();
                                                   }

                                                    /*store product image*/   
                                                    $product_images = $this->ProductImagesModel->firstOrNew(['product_id'=> $id]);
                                                                                                        
                                                        $product_images->product_id= $id;
                                                        $product_images->user_id = $user->id;
                                                        $product_images->save();

                                                    $successful_insertion_count ++;   

                                                    /**********update product count value in user table***/

                                                   
                                                    $update_productcount_arr = [
                                                                  'product_count' => $dbproduct_count
                                                                    ];
                                                    $this->UserModel->where('id',$loguser_id)->update($update_productcount_arr);

                                                    /********************************/

                                                }//if insert id
                                             // }//else of product limit
                                            
                                            }//if not empty array



                                //}//else
                            }//if product name not empty
               
        
                    }//foreach
                }//if not empty data

                if(!empty($arr)){
                    $response['status'] = "success";   
                    $response['description'] = $successful_insertion_count.' Products uploaded successfully';        
                }
                else
                {
                    $response['status'] = "warning";        
                    $response['description'] ='Something went wrong in bulk import';     
  
                }

            }// if data count
          }


           return response()->json($response);

        }//if requested file 
    }
   



   public function exportExcel(Request $request){ 
       
         // $header =['First_Level_Category','Second_Level_Category','Unit','Product_Name','Description','Total_quantity_avaliable','Price','Is_age_limit','Age_Restriction','Brand','Concentration','price_drop_to','shipping_type','shipping_charges','product_video_source','product_video_url','Dropshipper Name'];

      $header =['First_Level_Category','Second_Level_Category','Unit','Product_Name','Description','Total_quantity_avaliable','Price','Brand','Concentration','price_drop_to','shipping_type','shipping_charges','product_video_source','product_video_url','Dropshipper Name'];


        $filename   = 'Product bulk upload Excel';
        \Excel::create($filename, function ($excel) use($header) {
            $excel->sheet('Bulk Upload', function ($sheet) use($header) {
                require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
                require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");
            // $sheet->fromArray(array($commonVarible), null, 'A1', false, false);
            // $sheet->getRowDimension(1)->setVisible(false);
            $data = $header;
            $sheet->fromArray(array($data), null, 'A1', false, false);
            $sheet->cells('A2:I2', function($cells) {
                 $cells->setBorder('none', 'thick', 'none', 'none');
                 $cells->setAlignment('left');
                 $cells->setFontWeight('bold');
            });

            
            $firstlevel = $this->FirstLevelCategoryModel->where('is_active',1)->pluck('product_type')->toArray();            
            $firstlevelList = implode(',', $firstlevel);
            $this->addDropdowninExcel('A',2,$firstlevelList,100,$sheet);

            $secondlevel = $this->SecondLevelCategoryModel->where('is_active',1)->pluck('name')->toArray();            
            $secondlevelList = implode(',', $secondlevel);
            $this->addDropdowninExcel('B',2,$secondlevelList,100,$sheet);

            $unitlevel = $this->UnitModel->pluck('unit')->toArray();            
            $unitlevelList = implode(',', $unitlevel);
            $this->addDropdowninExcel('C',2,$unitlevelList,100,$sheet);

           /*$age_limitype = array('0'=>'0','1'=>'1');
            $age_limitypelist = implode(",", $age_limitype);
            $this->addDropdowninExcel('H',2,$age_limitypelist,100,$sheet);

            $age_restriction = $this->AgeRestrictionModel->pluck('age')->toArray();
            $agelist = implode(",", $age_restriction);
            $this->addDropdowninExcel('I',2,$agelist,100,$sheet);*/


            $shipping_type = array('0'=>'Free Shipping','1'=>'Flat Shipping');
            $shippingtypelist = implode(",", $shipping_type);
            // $this->addDropdowninExcel('M',2,$shippingtypelist,100,$sheet);
            $this->addDropdowninExcel('K',2,$shippingtypelist,100,$sheet);

            // $brands = $this->BrandModel->pluck('name')->toArray();
            // $brandlist = implode(",", $brands);
            // $this->addDropdowninExcel('J',2,$brandlist,100,$sheet);

            $video_type = array('youtube'=>'youtube','vimeo'=>'vimeo');
            $videotypelist = implode(",", $video_type);
            // $this->addDropdowninExcel('O',2,$videotypelist,100,$sheet);
            $this->addDropdowninExcel('M',2,$videotypelist,100,$sheet);


            $dropshippers = $this->DropShipperModel->pluck('name')->toArray();            
            $dropshippersList = implode(',', $dropshippers);
            // $this->addDropdowninExcel('Q',2,$dropshippersList,100,$sheet);
             $this->addDropdowninExcel('o',2,$dropshippersList,100,$sheet);


        }); // end of first sheet

            /****************code for showing category and subcategory on second sheet*************/
            $cat_sub_cat_arr = $Category = [];

            $categories_arr = $this->FirstLevelCategoryModel->select('*')
                                                  ->with(['category_details'=>function($q1){

                                                  }])
                                                  ->whereHas('category_details',function($q){
                                                     $q->where('is_active',1);
                                                  })
                                                  ->where('is_active',1)
                                                  ->get()
                                                  ->toArray();
                                               // dd($categories_arr);  
               
            if(isset($categories_arr) && count($categories_arr)>0)
            {
                foreach ($categories_arr as $key => $category)
                {
                   foreach($category['category_details'] as $key => $subcategory) 
                   {
                      
                      $cat_sub_cat_arr[$category['product_type']][] =  $subcategory['name'];
                    
                   }
                }
    
            } 


            $final_arr = [];
            $cnt = 0;

           
              foreach ($cat_sub_cat_arr as $key => $subcategory) 
              {
                 
                  foreach ($subcategory as $key1 => $value) 
                  {
                     if($key1 >0)
                     {
                       $final_arr[$cnt]['first_level_category']    = '';

                     }
                     else
                     {
                       $final_arr[$cnt]['first_level_category']    = $key;

                     }
                     
                     $final_arr[$cnt]['Second_Level_Category'] = $value;

                    $cnt++;
                  }
              }

             /*-----------------------------------------------------------------------*/
            $excel->sheet('Category & Subcategory List', function($sheet) use ($final_arr)
              {  
                  $sheet->cell('A1', function ($cell)
                  {
                        $cell->sheet->getStyle('A1:A100')->applyFromArray([
                                      'font' =>[
                                                'bold' => true
                                               ]
                                  ]);
                      
                  });

                  $cell_count = count($final_arr)+1;

                  $sheet->cells('A1:B1',function($cells) 
                  {
                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                  });


                 /* $sheet->cells('A2:B'.$cell_count, function($cells) 
                  {
                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                  });*/

                  $sheet->fromArray($final_arr, null, 'A1', true, true);


                  $sheet->row(1, function($row)
                  {
                     $row->setFontWeight('bold');

                  });
     
     
              }); //end of second sheet    

            /**************************show brand list third sheet***************/

            $brand_arr = $this->BrandModel->select('name')
                                                  ->where('is_active',1)
                                                  ->get()
                                                  ->toArray();
            if(isset($brand_arr)){

                 $excel->sheet('Brand list', function($sheet) use ($brand_arr)
                  {  

                      $sheet->cell('A1', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A1')->applyFromArray([
                                          'font' =>[
                                                    'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('Brand List');
                          
                      }); 

                      $sheet->cell('A3', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A3')->applyFromArray([
                                          'font' =>[
                                                    'bold' => true
                                                   ]
                         ]);
                          
                      });


                     $sheet->fromArray($brand_arr, null, 'A3', true, true);


                      $sheet->row(3, function($row)
                      {
                        // $row->setFontWeight('bold');

                      });
         
         
                  }); //end of third sheet    
            }//if brand list not empty then show brand sheet

         /**********show shipping type list fourth sheet*************/

                $excel->sheet('Shipping Type', function($sheet) use ($brand_arr)
                  {  


                      $sheet->cell('A1', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A1')->applyFromArray([
                                          'font' =>[
                                                    'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('Shipping Type');
                          
                      });


                      $sheet->cell('A3', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A3')->applyFromArray([
                                          'font' =>[
                                                  //  'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('Free Shipping');
                          
                      });

                        $sheet->cell('A4', function ($cell)
                      {
                             $cell->sheet->getStyle('A4')->applyFromArray([
                                          'font' =>[
                                                //    'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('Flat Shipping');
                          
                      });

         
                  }); //end of fourth sheet    

    /*************************show age limit***************/  

                 $excel->sheet('Is_age_limit', function($sheet) use ($brand_arr)
                  {  


                      $sheet->cell('A1', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A1')->applyFromArray([
                                          'font' =>[
                                                    'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('Is_age_limit');
                          
                      });


                      $sheet->cell('A3', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A3')->applyFromArray([
                                          'font' =>[
                                                  //  'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('0');
                          
                      });

                        $sheet->cell('A4', function ($cell)
                      {
                             $cell->sheet->getStyle('A4')->applyFromArray([
                                          'font' =>[
                                                //    'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('1');
                          
                      });

         
                  }); //end of fifth sheet    


        /*************************show video source list***************/  

           $excel->sheet('Product video source', function($sheet) use ($brand_arr)
                  {  


                      $sheet->cell('A1', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A1')->applyFromArray([
                                          'font' =>[
                                                    'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('product_video_source');
                          
                      });


                      $sheet->cell('A3', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A3')->applyFromArray([
                                          'font' =>[
                                                  //  'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('youtube');
                          
                      });

                        $sheet->cell('A4', function ($cell)
                      {
                             $cell->sheet->getStyle('A4')->applyFromArray([
                                          'font' =>[
                                                //    'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('vimeo');
                          
                      });

         
                  }); //end of fourth sheet    


        /****************************************************************/

         /**************************show dropshipper list third sheet***************/

            $dropship_arr = $this->DropShipperModel->select('name','email','product_price')
                                                  ->get()
                                                  ->toArray();


            if(isset($dropship_arr)){
                  $res = [];
                 foreach($dropship_arr as $kk=>$vv)
                 {
                      $res['Dropshipper Name']  = $vv['name'];
                      $res['Dropshipper Email'] = $vv['email'];
                      $res['Dropshipper Price'] = $vv['product_price'];
                     
                 } 



                 $excel->sheet('Dropshipper list', function($sheet) use ($dropship_arr)
                  {  

                      $sheet->cell('A1', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A1')->applyFromArray([
                                          'font' =>[
                                                    'bold' => true
                                                   ]
                             ]);
                              $cell->setValue('Dropshipper List');
                          
                      }); 

                      $sheet->cell('A3', function ($cell)
                      {
                           // $cell->sheet->getStyle('A1:A100')->applyFromArray([
                             $cell->sheet->getStyle('A3')->applyFromArray([
                                          'font' =>[
                                                    'bold' => true
                                                   ]
                         ]);
                          
                      });


                     $sheet->fromArray($dropship_arr, null, 'A3', true, true);


                      $sheet->row(3, function($row)
                      {
                        // $row->setFontWeight('bold');

                      });
         
         
                  }); //end of third sheet    
            }//if brand list not empty then show brand sheet

          


      })->download('xlsx');
    } 
      


       public function addDropdowninExcel($col,$row,$json,$limit,$sheet){
        for($i=0;$i<=$limit;$i++)
        {
            $objValidation2 = $sheet->getCell($col.$row)->getDataValidation();
            $objValidation2->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation2->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
            $objValidation2->setAllowBlank(false);
            $objValidation2->setShowInputMessage(true);
            $objValidation2->setShowDropDown(true);
            $objValidation2->setPromptTitle('Pick from list');
            $objValidation2->setPrompt('Please pick a value from the drop-down list.');
            $objValidation2->setErrorTitle('Input error');
            $objValidation2->setError('Value is not in list');
            $objValidation2->setFormula1('"'.$json.'"');
            $row++;
        }
    }

    // function to delete product images in seller edit product
      public function delete_images($id)
    {
        $entity = $this->ProductImagesModel->where('id',$id)->first();
        if($entity)
        {
            if($this->ProductImagesModel->where('id',$id)->delete())
            {
               $unlink_old_img_path    = $this->product_image_base_img_path.'/'.$entity->image;
                            
                if(file_exists($unlink_old_img_path))
                {
                    @unlink($unlink_old_img_path);  
                }


              $arr_response['status'] = 'SUCCESS';
              $arr_response['description'] = 'Image Deleted Successfully';

            }else{
               $arr_response['status'] = 'ERROR';
               $arr_response['description'] = 'Problem occured while deleting';
            }
            
        }else{
            $arr_response['status'] = 'ERROR';
            $arr_response['description'] = 'Problem occured while deleting';

        }
        return $arr_response;
    }

     public function autosuggest(request $request)
    { 
        if($request->query)
       {

            $productbrand = $this->BrandModel->getTable();
            $prefiex_productbrand = DB::getTablePrefix().$this->BrandModel->getTable();

            $query = $request['query']; 
            $data = DB::table($prefiex_productbrand)
                    ->where('name', 'LIKE', "%{$query}%")
                    ->get()->toArray();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if(isset($data) && !empty($data)){
                foreach($data as $row)
                {
                 $output .= '
                 <li class="liclick"><a href="#" >'.$row->name.'</a></li>
                 ';
                }
            }else{
              $output .='<li><a href="#">Not Found</a></li>';
            }
            $output .= '</ul>';
            echo $output;
       }

    } 

    public function autosuggest_dropshipper(request $request)
    { 
        if($request->query)
       {

            $prefiex_dropshipper = DB::getTablePrefix().$this->DropShipperModel->getTable();
            $user_id = "";
            $user = Sentinel::check();
            if($user)
            {
               $user_id = $user->id;
            }

            $query= $request['query']; 
            $data = DB::table($prefiex_dropshipper)
                    ->where('name', 'LIKE', "%{$query}%")
                    ->where('seller_id',$user_id)
                    ->groupBy('name')
                    ->get()->toArray();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if(isset($data) && !empty($data)){
                foreach($data as $row)
                {
                 $output .= '
                 <li class="liclick"><a href="#" >'.$row->name.'</a></li>
                 ';
                }
            }else{
              $output .='<li><a href="#">Not Found</a></li>';
            }
            $output .= '</ul>';
            echo $output;
       }

    }  

    public function get_dropshipper_details(request $request)
    {
          if($request->query)
       {
            $prefiex_dropshipper = DB::getTablePrefix().$this->DropShipperModel->getTable();
            $user_id = "";
            $user = Sentinel::check();
            if($user)
            {
               $user_id = $user->id;
            }

            $query= $request['query']; 
            $data = DB::table($prefiex_dropshipper)
                    ->where('name', 'LIKE', "%{$query}%")
                    ->where('seller_id',$user_id)
                    ->get()->toArray();


           return json_encode($data);
       }
    } 


    public function chk_dropshipper_email_duplication(request $request)
    {

        if($request->query)
       {
            $prefiex_dropshipper = DB::getTablePrefix().$this->DropShipperModel->getTable();

            $query= $request['query']; 
            $data = DB::table($prefiex_dropshipper)
                    ->where('email',$query)
                    ->get()->toArray();
            if(sizeof($data) > 0)
            {

               echo"exists";
            } 
            else
            {
              echo"not exists";
            }
       }
    }//end function


    public function changed_drop_price(Request $request)
    {
        $product_id = $request->input('product_id');
        if(isset($product_id) && !empty($product_id))
        {    
          $price_drop_changed = $this->ProductModel->where('id',$product_id)->update(array('price_drop_changed'=>1));
          if($price_drop_changed)
          {
             return "true";
          }
        }
    }

    public function toggleOutofstock(Request $request)
    {



        $user = Sentinel::check();

        $product_id           = base64_decode($request->product_id);
        $verification_status  = $request->status;

        $is_available         = $this->ProductModel->where('id',$product_id)->count()>0;
        
        if($is_available)
        {

              $res_product = $this->ProductModel->select('*')
                            ->where('id',$product_id)  
                            ->get();

              if(!empty($res_product) && count($res_product)>0)
              {
                $res_product    = $res_product->toArray();
                $seller_id      = $res_product[0]['user_id'];
                $product_name   = $res_product[0]['product_name'];

              }
 


            if($verification_status==1)
            {
                $update_field = 1;
            }
            else if($verification_status==0)
            {
                $update_field = 0;
            }


            $status = $this->ProductModel->where('id',$product_id)->update(['is_outofstock'=>$update_field]);

            if($status)
            {       
                
                if($verification_status==1)
                {

                         $url     = url('/').'/seller/product/view/'.base64_encode($product_id);

                      /********************send notification and email of product approve**********/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";


                            $admin_role = Sentinel::findRoleBySlug('admin');        
                            $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();

                            if($admin_obj)
                            {
                                $admin_details = Sentinel::findById($admin_obj->user_id); 
                                $admin_name = $admin_details->first_name.' '.$admin_details->last_name;        
                            }


                            $to_user = Sentinel::findById($seller_id);
                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                            $setsellername ='';
                            if(isset($f_name) || isset($l_name))
                            {
                                $setsellername = $f_name.' '.$l_name;
                            }
                            else{
                                $setsellername = $to_user->email;
                            }


                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $seller_id;
                            $arr_event['to_user_id']   = $admin_obj->user_id;
                            $arr_event['description']  = html_entity_decode( $setsellername.' has <b>made</b> the product <b><a target="_blank" href="'.$url.'">'.$product_name.'</b></a> as out of stock');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product marked as out of stock';
                            $this->GeneralService->save_notification($arr_event);


                          
                    

                            $arr_built_content = ['USER_NAME'     => $admin_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'SELLER_NAME'    => $setsellername,
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '137';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($admin_obj->user_id);


                            $this->EmailService->send_mail_section($arr_mail_data);


                      /******end of send notification and email of product*approve********/

                     /***************start of eventdata**for newproduct*approve******/
                      $setname=''; 
                      $get_seller_businessname = $this->SellerModel->where('user_id',$seller_id)->first();
                      if(isset($get_seller_businessname) && !empty($get_seller_businessname))
                      {
                        $get_seller_businessname = $get_seller_businessname->toArray();
                        $busineename = $get_seller_businessname['business_name'];
                        if($busineename=="")
                        {
                          $setname = $f_name.''.$l_name;
                        }
                        else
                        {
                           $setname = $busineename;
                        }
                      }  

                      $arr_eventdata             = [];
                      $arr_eventdata['user_id']  = $from_user_id;

                      $get_product_name = $this->ProductModel
                                        // ->select('product_name','user_id')
                                         ->with(['get_seller_details','product_images_details'])
                                         ->where('id',$product_id)
                                         ->first();

                      if(!empty($get_product_name) && isset($get_product_name))
                      {
                          $get_product_name = $get_product_name->toArray();
                      }
                 
                       if(!empty($get_product_name['product_images_details']) 
                                         && count($get_product_name['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image']) &&$get_product_name['product_images_details'][0]['image']!='')
                       {
                         /* $imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];*/

                        //image resize
                        $imgsrc = image_resize('/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'],35,35);

                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }




                      $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div> <b>'.$setname.'</b> just added a new product to chow. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($product_id).'" target="_blank" class="viewcls">View</a>');
                      $arr_eventdata['title']    = 'Product Marked as out of stock By Admin';             
                     // $this->EventModel->create($arr_eventdata);


                      /***************end of eventdata**for newproduct*******/

                      $response['status']      = 'SUCCESS';
                      $response['message']     = str_singular($this->module_title).' marked as out of stock successfully';

                    $response['status']      = 'SUCCESS';
                    $response['message']     = str_singular($this->module_title)." marked as out of stock successfully";

                }
                else
                {
                    
                    $response['status']      = 'SUCCESS';
                    $response['message'] = str_singular($this->module_title)." removed from out of stock successfully";
                }

           
                
            }
            else
            {
                $response['status']      = 'ERROR';
                $response['message']     = 'Problem occured while performing action';
            }
            
            return response()->json($response);
        }
        else
        {   
            $response['status']      = 'ERROR';
            $response['message']     ='Something went wrong Please try again later';
            return response()->json($response);
        }
    }//end function out of stock



     // For adding new row
     public function addNewRow(Request $request)
    {
      $row_cnt = $request->row_id + 1;
      $this->arr_view_data['row_cnt']             = $row_cnt;
      return view($this->module_view_folder.'.addnewrow',$this->arr_view_data);   
    }

    public function removerow(Request $request){
        $prod_can_id = $request->prod_can_id;
        $prod_id     = $request->prod_id;

        $this->ProductCannabinoidsModel->where('id',$prod_can_id)->where('product_id',$prod_id)->delete();

         $response['status']      = 'success';
            $response['message']     ='Successfully deleted';
            return response()->json($response);
    }
}
