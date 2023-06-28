<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
 
use App\Common\Traits\MultiActionTrait;

use App\Models\UserModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
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
use App\Models\FavoriteModel;
use App\Models\ProductImagesModel;
use App\Models\AgeRestrictionModel;
use App\Models\KeywordsModel;
use App\Models\BrandModel;
use App\Models\ProductInventoryModel;
use App\Models\UserSubscriptionsModel; 
use App\Models\EventModel; 
use App\Models\ProductDimensionsModel;
use App\Models\DropShipperModel;
use App\Models\ReviewRatingsModel;
use App\Models\SpectrumModel;
use App\Models\ProductCannabinoidsModel;
use App\Models\ReportedEffectsModel;


 
  
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Common\Services\ProductService;
use App\Common\Services\UserService;

use Flash;
use Validator; 
use Sentinel;
use Activation;
use Reminder;
use DB;
use Image;
use Datatables;
 
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
                                FavoriteModel $FavoriteModel,
                                ProductImagesModel $ProductImagesModel,
                                AgeRestrictionModel $AgeRestrictionModel,
                                BrandModel $BrandModel,
                                KeywordsModel $KeywordsModel,
                                ProductInventoryModel $ProductInventoryModel,
                                GeneralService $GeneralService,
                                UserSubscriptionsModel $UserSubscriptionsModel,
                                EventModel $EventModel,
                                ProductDimensionsModel $ProductDimensionsModel,
                                DropShipperModel $DropShipperModel,
                                UserService $UserService,
                                ReviewRatingsModel $ReviewRatingsModel,
                                SpectrumModel $SpectrumModel,
                                StatesModel $states,
                                ProductCannabinoidsModel $ProductCannabinoidsModel,
                                ReportedEffectsModel $ReportedEffectsModel

                                )
    {
        $user = Sentinel::createModel();

        $this->EmailService                 = $EmailService;
        $this->UserModel                    = $user;
        $this->BaseModel                    = $this->UserModel;   // using sentinel for base model.
        $this->CountriesModel               = $country;
        $this->StatesModel                  = $states;
        $this->ActivityLogsModel            = $activity_logs;
        $this->BuyerModel                   = $buyerModel;
        $this->SellerModel                  = $sellerModel;
        $this->RoleUserModel                = $roleUserModel;
        $this->GeneralSettingsModel         = $GeneralSettingsModel;
        $this->TradeRatingModel             = $TradeRatingModel;
        $this->ShippingAddressModel         = $ShippingAddressModel;
        $this->ProductModel                 = $ProductModel;
        $this->KeywordsModel                 = $KeywordsModel;
        $this->ProductCommentModel          = $ProductCommentModel; 
        $this->FirstLevelCategoryModel      = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel     = $SecondLevelCategoryModel;
        $this->FavoriteModel                = $FavoriteModel;
        $this->ProductImagesModel           = $ProductImagesModel;
        $this->AgeRestrictionModel          = $AgeRestrictionModel;
        $this->BrandModel                   = $BrandModel;
        $this->ProductInventoryModel        = $ProductInventoryModel;

        $this->ProductService               = $ProductService;
        $this->GeneralService               = $GeneralService;   
        $this->UserSubscriptionsModel       = $UserSubscriptionsModel;
        $this->EventModel                   = $EventModel;
        $this->ProductDimensionsModel       = $ProductDimensionsModel;
        $this->DropShipperModel             = $DropShipperModel;
        $this->UserService                  = $UserService;
        $this->ReviewRatingsModel           = $ReviewRatingsModel; 
        $this->SpectrumModel                = $SpectrumModel;
        $this->ProductCannabinoidsModel     = $ProductCannabinoidsModel;
        $this->ReportedEffectsModel         = $ReportedEffectsModel;

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');
        $this->product_image_base_img_path  = base_path().config('app.project.img_path.product_images');
        $this->product_public_img_path      = url('/').config('app.project.img_path.product_images');
        $this->user_id_proof                = url('/').config('app.project.id_proof');
        $this->product_image_thumb_base_img_path = base_path().config('app.project.img_path.product_imagesthumb');

        $this->add_product_image_base_img_path = base_path().config('app.project.img_path.additional_product_image');
        $this->add_product_public_img_path  = url('/').config('app.project.img_path.additional_product_image');

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/product");
        $this->product_imageurl_path         = url(config('app.project.product_images'));

        $this->module_title                 = "Product";
        $this->modyle_url_slug              = "Product Listing";
        $this->module_view_folder           = "admin.product";
       
    }   

    public function index()
    {
        $this->arr_view_data['arr_data'] = array();
        
        $this->arr_view_data['page_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['product_imageurl_path'] = $this->product_imageurl_path;

        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }

    public function get_productlist_details(Request $request) 
    {
      
        $product_details    = $this->ProductModel->getTable();
        $prefix_product_detail  = DB::getTablePrefix().$this->ProductModel->getTable();
        $prefix_spectrum        = DB::getTablePrefix().$this->ProductModel->getTable();

        $user_details       = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $state_details       = $this->StatesModel->getTable();
        $prefix_state_detail = DB::getTablePrefix().$this->StatesModel->getTable();

        $firstlevel         = $this->FirstLevelCategoryModel->getTable();
        $prefix_firstlevel  = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

        $secondlevel        = $this->SecondLevelCategoryModel->getTable();
        $prefix_secondlevel = DB::getTablePrefix().$this->SecondLevelCategoryModel->getTable();

        $productimages = $this->ProductImagesModel->getTable();
        $prefiex_productimages = DB::getTablePrefix().$this->ProductImagesModel->getTable();

         $productbrand = $this->BrandModel->getTable();
        $prefiex_productbrand = DB::getTablePrefix().$this->BrandModel->getTable();

        $product_inventory = $this->ProductInventoryModel->getTable();
        $prefiex_product_inventory = DB::getTablePrefix().$this->ProductInventoryModel->getTable();

        $sellertable  = $this->SellerModel->getTable();
        $prefiex_sellertable =  DB::getTablePrefix().$this->SellerModel->getTable();




        $obj_product = DB::table($product_details)->select(DB::raw( $product_details.'.*,'.
                        $prefiex_productimages.'.image as image,'.
                         $prefiex_productbrand.'.name as name,'.
                        $prefix_firstlevel.'.product_type as firstlevelcategory,'.
                        $prefix_secondlevel.'.name as secondlevelcagtegory,'.
                        $prefix_spectrum.'.spectrum as spectrumm,'.
                         $prefiex_product_inventory.'.remaining_stock as remainingstock,'.
                          $prefix_user_detail.'.country as country,'.
                           $prefix_user_detail.'.state as state,'.
                           $prefix_state_detail.'.name as state_name,'.

                        "CONCAT(".$prefix_user_detail.".first_name,' ',"
                                .$prefix_user_detail.".last_name) as seller_name,".
                                $prefiex_sellertable.'.business_name as business_name'

                            ))
                        ->leftJoin($prefix_firstlevel,$prefix_firstlevel.'.id','=',$prefix_product_detail.'.first_level_category_id')
                        ->leftJoin($prefix_secondlevel,$prefix_secondlevel.'.id','=',$prefix_product_detail.'.second_level_category_id')
                         ->leftJoin($prefiex_productimages,$prefiex_productimages.'.product_id','=',$prefix_product_detail.'.id')
                        ->leftjoin($prefix_user_detail,$prefix_user_detail.'.id','=',$prefix_product_detail.'.user_id')
                        ->leftjoin($prefix_state_detail,$prefix_user_detail.'.state','=',$prefix_state_detail.'.id')
                         ->leftJoin($prefiex_productbrand,$prefiex_productbrand.'.id','=',$prefix_product_detail.'.brand')
                         ->leftJoin($prefiex_product_inventory,$prefiex_product_inventory.'.product_id','=',$prefix_product_detail.'.id')
                         ->leftjoin($prefiex_sellertable,$prefiex_sellertable.'.user_id','=',$prefix_product_detail.'.user_id')

                       ->groupBy($prefiex_productimages.'.product_id')  
                       ->orderBy($prefix_product_detail.'.is_approve','asc');  

                       //->orderBy($prefiex_productimages.'.product_id','desc');   
                       // ->get(); 
                    /* print_r($obj_product->toSql());
             dd();*/
                     
         /* ---------------- Filtering Logic ----------------------------------*/
         $arr_search_column = $request->input('column_filter');

         if(isset($arr_search_column['q_product_name']) && $arr_search_column['q_product_name'] != '')
          {
              $search_name_term  = $arr_search_column['q_product_name'];
              $obj_product  = $obj_product->where('product_name','LIKE', '%'.$search_name_term.'%');

          }
            if(isset($arr_search_column['q_brand']) && $arr_search_column['q_brand'] != '')
          {
              $search_brandname  = $arr_search_column['q_brand'];
              $obj_product  = $obj_product->where($productbrand.'.name','LIKE', '%'.$search_brandname.'%');

          }




          if(isset($arr_search_column['q_seller_name']) && $arr_search_column['q_seller_name'] != '')
          {
             $search_seller_term  = $arr_search_column['q_seller_name'];
              // $obj_product  = $obj_product->where($user_details.'.first_name','LIKE', '%'.$search_seller_term.'%')->orWhere('last_name', 'LIKE', '%'.$search_seller_term.'%');
              $obj_product  = $obj_product->where($prefiex_sellertable.'.business_name','LIKE', '%'.$search_seller_term.'%');

              

          }

          if(isset($arr_search_column['q_seller_state']) && $arr_search_column['q_seller_state'] != '')
          {
             $search_seller_term  = $arr_search_column['q_seller_state'];
              // $obj_product  = $obj_product->where($user_details.'.first_name','LIKE', '%'.$search_seller_term.'%')->orWhere('last_name', 'LIKE', '%'.$search_seller_term.'%');
              $obj_product  = $obj_product->where($prefix_state_detail.'.name','LIKE', '%'.$search_seller_term.'%');

              

          }
           if(isset($arr_search_column['q_first_level_cat']) && $arr_search_column['q_first_level_cat'] != '')
          {
              $search_name_term  = $arr_search_column['q_first_level_cat'];
              $obj_product  = $obj_product->where($prefix_firstlevel.'.product_type','LIKE', '%'.$search_name_term.'%');

          }
           if(isset($arr_search_column['q_second_level_cat']) && $arr_search_column['q_second_level_cat'] != '')
          {
              $search_secondcat_term  = $arr_search_column['q_second_level_cat'];
              $obj_product  = $obj_product->where($prefix_secondlevel.'.name','LIKE', '%'.$search_secondcat_term.'%');

          }
            if(isset($arr_search_column['q_product_stock']) && $arr_search_column['q_product_stock'] != '')
          {
              $search_stock_term  = $arr_search_column['q_product_stock'];
              $obj_product  = $obj_product->where($prefix_product_detail.'.unit_price','LIKE', '%'.$search_stock_term.'%');

          }

            if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
          {
              $search_status_term1  = $arr_search_column['q_status'];
              $obj_product  = $obj_product->where($prefix_product_detail.'.is_active','LIKE', '%'.$search_status_term1.'%');

          }
           if(isset($arr_search_column['q_approvedisapprove']) && $arr_search_column['q_approvedisapprove'] != '')
          {
              $search_status_term  = $arr_search_column['q_approvedisapprove'];
              $obj_product  = $obj_product->where($prefix_product_detail.'.is_approve','LIKE', '%'.$search_status_term.'%');

          }

          if(isset($arr_search_column['q_chowschoice']) && $arr_search_column['q_chowschoice'] != '')
          {
              $search_status_term1  = $arr_search_column['q_chowschoice'];
              $obj_product  = $obj_product->where($prefix_product_detail.'.is_chows_choice','LIKE', '%'.$search_status_term1.'%');

          }

           if(isset($arr_search_column['q_remainingstock']) && $arr_search_column['q_remainingstock'] != '')
          {
              $search_remainingstock_term  = $arr_search_column['q_remainingstock'];
             
              $obj_product  = $obj_product->where($prefiex_product_inventory.'.remaining_stock','LIKE', '%'.$search_remainingstock_term.'%');

          }
           if(isset($arr_search_column['spectrum']) && $arr_search_column['spectrum'] != '')
          {
              $search_spectrum  = $arr_search_column['spectrum'];
             
              $obj_product  = $obj_product->where($prefix_spectrum.'.spectrum',$search_spectrum);

          }

           if(isset($arr_search_column['q_outofstock']) && $arr_search_column['q_outofstock'] != '')
          {
              $search_status_outofstock  = $arr_search_column['q_outofstock'];
              $obj_product  = $obj_product->where($prefix_product_detail.'.is_outofstock','LIKE', '%'.$search_status_outofstock.'%');

          }
          
                                         
                   
         return $obj_product;
                                    
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
                            ->editColumn('business_name',function($data) use ($current_context)
                            {
                               if(isset($data->business_name) && !empty($data->business_name))
                               {
                                return $data->business_name;
                               }
                                else{
                                  return 'NA';
                                }
                            })    

                           /* ->editColumn('state_name',function($data) use ($current_context)
                            {
                               if(isset($data->state) && !empty($data->state))
                               {
                                return get_state($data->state);
                               }
                                else{
                                  return 'NA';
                                }
                            })       */
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
                            ->editColumn('build_chows_choice_btn',function($data) use ($current_context)
                            {

                                $build_chows_choice_btn ='';

                                if($data->is_chows_choice == 0)
                                {   

                                    $build_chows_choice_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleChowsChoice" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->is_chows_choice == 1)
                                {
                                   
                                    $build_chows_choice_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleChowsChoice" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_chows_choice_btn;
                            })  

                             ->editColumn('build_isoutofstock_btn',function($data) use ($current_context)
                            {

                                $build_isoutofstock_btn ='';

                                if($data->is_outofstock == 0)
                                {   

                                    $build_isoutofstock_btn = '<input type="checkbox" style="margin: 0 auto;display: block;" data-size="small" data-enc_id="'.base64_encode($data->id).'" onclick="stock_change(this)"  data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />'; // class for toggle - class="js-switch toggleOutofstock" 
                                }
                                elseif($data->is_outofstock == 1)
                                {
                                   
                                    $build_isoutofstock_btn = '<input type="checkbox" style="margin: 0 auto;display: block;" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'" onclick="stock_change(this)" id="status_'.$data->id.'"  data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />'; 

                                    // class for toggle - class="js-switch toggleOutofstock" 
                                }
                                return $build_isoutofstock_btn;
                            })  
                            



                             ->editColumn('spectrum',function($data) use ($current_context)
                            {

                              //dd($data->spectrum == 0);

                              /*if(isset($data->spectrum) && !empty($data->spectrum))*/
                              if(isset($data->spectrum))
                               {
                                  // if ($data->spectrum == 0) {

                                  //   return "Full Spectrum";
                                  // } 
                                  // elseif ($data->spectrum == 1) {

                                  //   return "Broad Spectrum";
                                  // }
                                  // elseif ($data->spectrum == 2) {

                                  //   return "Isolate";
                                  // }
                                  // else {

                                  //   return '-';
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
                               else {

                                  return 'NA';
                                }

                            }) 

                             ->editColumn('build_istrending_btn',function($data) use ($current_context)
                            {

                                $build_istrending_btn ='';

                                if($data->is_trending == 0)
                                {   

                                    $build_istrending_btn = '<input type="checkbox" style="margin: 0 auto;display: block;" data-size="small" data-enc_id="'.base64_encode($data->id).'" onclick="trending_change(this)"  data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />'; // class for toggle - class="js-switch toggleOutofstock" 
                                }
                                elseif($data->is_trending == 1)
                                {
                                   
                                    $build_istrending_btn = '<input type="checkbox" style="margin: 0 auto;display: block;" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'" onclick="trending_change(this)" id="status_'.$data->id.'"  data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />'; 

                                    // class for toggle - class="js-switch toggleOutofstock" 
                                }
                                return $build_istrending_btn;
                            })  



                            ->editColumn('unit_price',function($data) use ($current_context)
                            {
                               $unit_price = '$'.num_format($data->unit_price);
                               return $unit_price;
                            })                          
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                $dispensaryname = '';
                                if(isset($data->business_name) && !empty($data->business_name))
                               {
                                $dispensaryname =  $data->business_name;
                               }
                                else{
                                 $dispensaryname = 'NA';
                                }

                                $sellercountry = '';
                                $sellerstate ='';
                                $showchowchecklogo = '';
                                $restrictcatgorynames=''; 
                                 $catnamedata =[];

                                $sellercountry = $data->country;
                                $sellerstate = $data->state;
                                if(isset($sellercountry) && isset($sellerstate))
                                { 
                                    $admin_locationdata = admin_locationdata($sellercountry,$sellerstate);
                                    if(isset($admin_locationdata) && !empty($admin_locationdata))
                                    {
                                      $catdata = isset($admin_locationdata['catdata'])?$admin_locationdata['catdata']:[];

                                       if(isset($catdata) && !empty($catdata))
                                       {
                                            $catnamedata =[];
                                           foreach ($catdata as $catids) {
                                               $catname = get_first_levelcategorydata($catids);
                                               $catnamedata[] = $catname;                         
                                            }    
                                             $restrictcatgorynames=''; 
                                            if(isset($catnamedata) && !empty($catnamedata))
                                            {
                                              $restrictcatgorynames = implode(",", $catnamedata);
                                            }

                                          $countryname = get_countrydata($data->country);
                                          $statename = get_statedata($data->state);

                                          $img ='';
                                          $img = url('/').'/assets/front/images/chow-check.png';
                                          $showchowchecklogo = '<img src="'.$img.'" width="70"   class="showmodalofchowcheck" countryname="'.$countryname.'" statename="'.$statename.'"   dispensaryname="'.$dispensaryname.'" restrictcatgorynames="'.$restrictcatgorynames.'" style="cursor:pointer"/>';

                                       }//if isset admin location data 

                                    }//if isset admin location data
                                }//if isset country and state 





                                 $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                 $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                                $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                                $build_view_action = '<a class="eye-actn" href="'.$view_href.'" title="View">View</a>';

                                /*$delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';

                                $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';*/

                                $view_reviews_href =  $this->module_url_path.'/Reviews/'.base64_encode($data->id);

                                $build_reviews_action = '<a class="eye-actn" href="'.$view_reviews_href.'" title="View Reviews & Ratings">Reviews & Ratings</a>';
                                

                                $product_copy_href =  $this->module_url_path.'/product_copy/'.base64_encode($data->id);

                                $build_copy_product_action = '<a class="eye-actn" href="'.$product_copy_href.'" title="Duplicate Product">Duplicate</a>';

                                return $build_action = $build_edit_action.' '.$build_view_action.''.$build_reviews_action.' '.$build_copy_product_action.''.$showchowchecklogo;
                            })
                        
                            ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
    }

   
    public function create()
    {
        $arr_category  = $arr_unit = [];
        $this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

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
                          ->select(DB::raw($user_details.'.*,'.$prefix_seller_detail.'.business_name'))
                          ->leftjoin($prefix_seller_detail,$prefix_seller_detail.'.user_id','=',$prefix_user_detail.'.id')
                          ->where($user_details.'.user_type','seller')
                          ->get()->toArray();
                         


         $this->arr_view_data['sellerdropdown']   = $sellerdropdown;     
         $this->arr_view_data['age_restrictiondata']  = isset($res_age_Restriction)?$res_age_Restriction:[];        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
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
      
        $user = Sentinel::check();

        $form_data = $request->all();

        $sku      = isset($form_data['sku'])?$form_data['sku']:'';
      
        $is_age_limit        = isset($form_data['is_age_limit'])?$form_data['is_age_limit']:'';
        $age_restriction     = isset($form_data['age_restriction'])?$form_data['age_restriction']:'';
        $shipping_type       = isset($form_data['shipping_type'])?$form_data['shipping_type']:'';
        $shipping_charges    = isset($form_data['shipping_charges'])?$form_data['shipping_charges']:'';
        $shipping_duration   = isset($form_data['shipping_duration'])?$form_data['shipping_duration']:'';
        $description         = isset($form_data['description'])?$form_data['description']:'';
        $ingredients         = isset($form_data['ingredients'])?$form_data['ingredients']:'';
        $suggested_use       = isset($form_data['suggested_use'])?$form_data['suggested_use']:'';
        $amount_per_serving  = isset($form_data['amount_per_serving'])?$form_data['amount_per_serving']:'';

        $brand = isset($form_data['brand'])?$form_data['brand']:'';
        $unit_price = isset($form_data['unit_price'])?$form_data['unit_price']:'';
        $product_stock = isset($form_data['product_stock'])?$form_data['product_stock']:'';

        $concentration = isset($form_data['per_product_quantity'])?$form_data['per_product_quantity']:'';

         $first_level_category_id = isset($form_data['first_level_category_id'])?$form_data['first_level_category_id']:'';


         $spectrum = isset($form_data['spectrum'])?$form_data['spectrum']:'';
         $product_video_url = isset($form_data['product_video_url'])?$form_data['product_video_url']:'';
         
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

        $is_update_process = false; 

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }


        $arr_rules = [];
        if($is_update_process == false)
        {
            $arr_rules = [
                            'product_name' => 'required',
                            'first_level_category_id' => 'required',
                            'second_level_category_id' => 'required',
                            'description'=>'required',
                            /*'ingredients'=>'required',
                            'suggested_use'=>'required',
                            'amount_per_serving'=>'required',*/
                            'product_image'=>'required',                            
                            'unit_price'=>'required',
                            'shipping_type'=>'required',
                            'user_id'=>'required',
                            'product_stock'=>'required',
                           // 'per_product_quantity'=>'required',
                           // 'is_age_limit'=>'required',
                            'brand'=>'required'
                         ];
        } 


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all required fields..';

            return response()->json($response);
        }


       /* if( (strpos($form_data['product_name'], 'cbd') !== false) || (strpos($form_data['product_name'], 'CBD') !== false) || (strpos($form_data['product_name'], 'thc') !== false) || (strpos($form_data['product_name'], 'THC') !== false) )
        {
            $response['status']      = 'warning';
            $response['description'] = 'Remove the word "CBD", if your products contain any form of cannabinoids, please identify it in your certificate of analysis of your product(s)';

            return response()->json($response);
        }*/



       /* if($is_age_limit=='1' && $age_restriction=="")
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please select age restriction';

            return response()->json($response);
        }*/
        
        if($shipping_type=='1' && $shipping_charges=="")
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter shipping charges';

            return response()->json($response);
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
                                      //  ->where('keyword_name','LIKE','%'.$keyword.'%')
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

        if(isset($unit_price) && $unit_price<0)
        {
            $response['status']      = 'warning';
            $response['description'] = 'Unit price should not be less than 0';
            return response()->json($response);
        }
        if(isset($product_stock) && $product_stock<0)
        {
            $response['status']      = 'warning';
            $response['description'] = 'Product stock should not be less than 0';
            return response()->json($response);
        }

        if($description=="")
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter description.';
            return response()->json($response);
        }

        if($description!="" && strlen($description)<150)
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter description of atleast 150 characters.';
            return response()->json($response);
        }
 
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
       
          if ($request->hasFile('product_image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('product_image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
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
           //Validation for product image
           $file_extension = strtolower($request->file('product_certificate')->getClientOriginalExtension());
          // if(!in_array($file_extension,['jpg','png','jpeg','pdf']))
            if(!in_array($file_extension,['pdf']))
           {
                $response['status']       = 'CertificateFAILURE';
               // $response['description']  = 'Invalid image only jpg,png,jpeg,pdf extensions allowed.';
                $response['description']  = 'Invalid file only pdf extensions allowed.';

                return response()->json($response);
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


         if(isset($category_name) && !empty($category_name) && ($category_name=="Essential Oils" || $category_name=="Accessories") && $concentration==""){
         }elseif(isset($category_name) && !empty($category_name) && ($category_name!="Essential Oils" || $category_name!="Accessories" ) && $concentration=="")
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
                 $response['status'] = 'warning';
                 $response['description'] = 'Please enter concentration';
                 return response()->json($response);
              }
          
         }//if another category

       /* if(isset($category_name) && !empty($category_name) && ($category_name=="Edibles") && isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) &&  $age_restriction=="2"){
            $response['status'] = 'warning';
            $response['description'] = 'You can not select age 21+ For this category.';
            return response()->json($response);
         }*/


        // if($concentration=="")
        // {
        //     $response['status'] = 'warning';
        //     $response['description'] = 'Please enter concentration';
        //     return response()->json($response);
        // }


        if($is_update_process == false)
        {
           $check_product_title = $this->ProductModel->where('product_name',$form_data['product_name'])->first();

        }else{
            $check_product_title = $this->ProductModel
                              ->where('product_name',$form_data['product_name'])
                              ->where('id','!=',$form_data['id'])
                              ->first();

        }
        if($check_product_title)
        {   

          $response['status']      = "error";
          $response['description'] = "The product with the same name already exists, please use the different name";
          return response()->json($response);
        
        }


        /******************check sku exists************************/

         if(isset($form_data['sku']) && !empty($form_data['sku']))
        {
              if($is_update_process == false)
            {
               $check_sku = $this->ProductModel->where('sku',$form_data['sku'])->first();

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
          }

        /****************end*check*sku*exists***********************/


        /************start****check restricted categories for the seller********/

            $check_restricted_categories = get_seller_restricted_category_admin($form_data['user_id']);
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
                           $response['description'] = "Seller is not allowed to sell this item based on his state laws";
                           return response()->json($response);
                        }*/
                    }          
                } // if restricted_cat_ids     
            } // check_restricted_categories

      /********end***check restricted categories for the seller************/






        
        $productlist = $this->ProductService->save($form_data,$request);
     
        if($productlist)
        {
  
            if($is_update_process == false)
            {
                if($productlist->id)
                {
                    $response['link'] = $this->module_url_path;

                   // $response['link'] =$this->module_url_path.'/edit/'.base64_encode($productlist->id);
                }else{

                    $response['link'] = $this->module_url_path;

                }
            }
            else
            {
                $response['link'] = $this->module_url_path;
            }

            if($is_update_process==true)
            {
                  /*-------------------------------------------------------
                  |   Activity log Event
                  --------------------------------------------------------*/
                  
                  //save sub admin activity log 

                  if(isset($user) && $user->inRole('sub_admin'))
                  {
                      $arr_event                 = [];
                      $arr_event['action']       = 'EDIT';
                      $arr_event['title']        = $this->module_title;
                      $arr_event['user_id']      = isset($user->id)?$user->id:'';
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated product '.$form_data['product_name'].'.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }

                  /*----------------------------------------------------------------------*/

                  $response['status']      = "success";
                  $response['description'] = "Product updated successfully."; 

            }
            else
            {
                  /*-------------------------------------------------------
                  |   Activity log Event
                  --------------------------------------------------------*/
                  
                  //save sub admin activity log 

                  if(isset($user) && $user->inRole('sub_admin'))
                  {
                      $arr_event                 = [];
                      $arr_event['action']       = 'ADD';
                      $arr_event['title']        = $this->module_title;
                      $arr_event['user_id']      = isset($user->id)?$user->id:'';
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added product '.$form_data['product_name'].'.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }

                  /*----------------------------------------------------------------------*/

                  $response['status']      = "success";
                  $response['description'] = "Product added successfully."; 

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

        $product_dimensions  = $this->ProductDimensionsModel->where('product_id',$id)->get();  
        if(isset($product_dimensions))
        {
           $product_dimensions = $product_dimensions->toArray();
        }         
        $this->arr_view_data['product_dimensions'] = isset($product_dimensions)?$product_dimensions:[];    

          
        $product_inventory = $this->ProductInventoryModel->where('product_id',$id)->first();
        if(isset($product_inventory))
        {
          $product_inventory = $product_inventory->toArray();
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
                          //->select(DB::raw($user_details.'.*'))
                           ->select(DB::raw($user_details.'.*,'.$prefix_seller_detail.'.business_name'))
                          ->leftjoin($prefix_seller_detail,$prefix_seller_detail.'.user_id','=',$prefix_user_detail.'.id')->where($user_details.'.user_type','seller') 
                          ->get()->toArray();


         $this->arr_view_data['sellerdropdown']   = $sellerdropdown;     

      
        $this->arr_view_data['product_public_img_path']      = $this->product_public_img_path;
        $this->arr_view_data['add_product_public_img_path']  = $this->add_product_public_img_path;
        $this->arr_view_data['edit_mode']                    = TRUE;
        $this->arr_view_data['enc_id']                       = $enc_id;
        $this->arr_view_data['module_url_path']              = $this->module_url_path;
        $this->arr_view_data['arr_product']                  = isset($arr_product) ? $arr_product : []; 
        $this->arr_view_data['arr_product_image']            = isset($arr_product_image)?$arr_product_image:[]; 
        $this->arr_view_data['page_title']                   = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']                 = $this->module_title;
        $this->arr_view_data['age_restrictiondata']          = isset($res_age_Restriction)?$res_age_Restriction:[];        

        $this->arr_view_data['brandname']             = isset($brandname)?$brandname:[];    
        $this->arr_view_data['product_inventory']     = isset($product_inventory)?$product_inventory:[];  
        $this->arr_view_data['product_cannabinoid']   = isset($Product_cannabinoid)?$Product_cannabinoid:[];  
        $this->arr_view_data['drop_shipper']          = isset($drop_shipper)?$drop_shipper:[];         



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

    //  Product Copy admin
    public function product_copy($enc_id)
    {      
     // dd(1233);
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


         $Product_cannabinoid = $this->ProductCannabinoidsModel->where('product_id',$id)->get();
        if(isset($Product_cannabinoid))
        {
          $Product_cannabinoid = $Product_cannabinoid->toArray();
        }  


        $this->arr_view_data['product_dimensions'] = isset($product_dimensions)?$product_dimensions:[]; 

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

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();

        $res_age_Restriction = $this->AgeRestrictionModel->select('id','age')->get()->toArray();


        $sellerdropdown = DB::table($user_details)
                          //->select(DB::raw($user_details.'.*'))
                          ->select(DB::raw($user_details.'.*,'.$prefix_seller_detail.'.business_name'))
                          ->leftjoin($prefix_seller_detail,$prefix_seller_detail.'.user_id','=',$prefix_user_detail.'.id')->where($user_details.'.user_type','seller') 
                          ->get()->toArray();
                          

         $this->arr_view_data['sellerdropdown']   = $sellerdropdown;     


    
        $this->arr_view_data['product_public_img_path']  = $this->product_public_img_path;
        $this->arr_view_data['add_product_public_img_path']  = $this->add_product_public_img_path;
        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['arr_product']              = isset($arr_product) ? $arr_product : []; 
        $this->arr_view_data['arr_product_image']        = isset($arr_product_image)?$arr_product_image:[]; 
        $this->arr_view_data['page_title']               = "Duplicate ".$this->module_title;
        $this->arr_view_data['module_title']             = $this->module_title;
        $this->arr_view_data['age_restrictiondata']      = isset($res_age_Restriction)?$res_age_Restriction:[];        

        $this->arr_view_data['brandname']                = isset($brandname)?$brandname:[];    
        $this->arr_view_data['product_inventory']        = isset($product_inventory)?$product_inventory:[]; 
        $this->arr_view_data['product_cannabinoid']  = isset($Product_cannabinoid)?$Product_cannabinoid:[];           
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
    

      return view($this->module_view_folder.'.product_copy',$this->arr_view_data);   
    }


    // End of Product Copy admin
 
    //Product Copy Save admin

    public function copy_product_save(Request $request)
    {

        $user = Sentinel::check();

        $form_data = $request->all();
        
        $sku = isset($form_data['sku'])?$form_data['sku']:'';


        $is_age_limit = isset($form_data['is_age_limit'])?$form_data['is_age_limit']:'';
        $age_restriction = isset($form_data['age_restriction'])?$form_data['age_restriction']:'';
        $shipping_type = isset($form_data['shipping_type'])?$form_data['shipping_type']:'';
        $shipping_charges = isset($form_data['shipping_charges'])?$form_data['shipping_charges']:'';
        $shipping_duration = isset($form_data['shipping_duration'])?$form_data['shipping_duration']:'';
        $brand = isset($form_data['brand'])?$form_data['brand']:'';
        $unit_price = isset($form_data['unit_price'])?$form_data['unit_price']:'';
        $product_stock = isset($form_data['product_stock'])?$form_data['product_stock']:'';
        $description       = isset($form_data['description'])?$form_data['description']:'';

        $ingredients         = isset($form_data['ingredients'])?$form_data['ingredients']:'';
        $suggested_use       = isset($form_data['suggested_use'])?$form_data['suggested_use']:'';
        $amount_per_serving  = isset($form_data['amount_per_serving'])?$form_data['amount_per_serving']:'';

        $concentration = isset($form_data['per_product_quantity'])?$form_data['per_product_quantity']:'';
        
         $first_level_category_id = isset($form_data['first_level_category_id'])?$form_data['first_level_category_id']:'';


        $spectrum     = isset($form_data['spectrum'])?$form_data['spectrum']:'';
        $description  = isset($form_data['description'])?$form_data['description']:'';
        $product_video_url = isset($form_data['product_video_url'])?$form_data['product_video_url']:'';
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




        $arr_rules = [];
       
        $arr_rules = [
              'product_name' => 'required',
              'first_level_category_id' => 'required',
              'second_level_category_id' => 'required',
              'description'=>'required',
              // 'product_image'=>'required',                            
              'unit_price'=>'required',
              'shipping_type'=>'required',
              'user_id'=>'required',
              'product_stock'=>'required',
             // 'per_product_quantity'=>'required',
              // 'is_age_limit'=>'required',
              'brand'=>'required'
           ];
       


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all required fields..';

            return response()->json($response);
        }
        // dd(123);

        /*if( (strpos($form_data['product_name'], 'cbd') !== false) || (strpos($form_data['product_name'], 'CBD') !== false) || (strpos($form_data['product_name'], 'thc') !== false) || (strpos($form_data['product_name'], 'THC') !== false) )
        {
            $response['status']      = 'warning';
            $response['description'] = 'Remove the word "CBD", if your products contain any form of cannabinoids, please identify it in your certificate of analysis of your product(s)';

            return response()->json($response);
        }*/

       /* if($is_age_limit=='1' && $age_restriction=="")
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please select age restriction';

            return response()->json($response);
        }*/
        
        if($shipping_type=='1' && $shipping_charges=="")
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter shipping charges';

            return response()->json($response);
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

        if(isset($unit_price) && $unit_price<0)
        {
            $response['status']      = 'warning';
            $response['description'] = 'Unit price should not be less than 0';
            return response()->json($response);
        }
        if(isset($product_stock) && $product_stock<0)
        {
            $response['status']      = 'warning';
            $response['description'] = 'Product stock should not be less than 0';
            return response()->json($response);
        }

        if($description=="")
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter description.';
            return response()->json($response);
        }

        if($description!="" && strlen($description)<150)
        {
            $response['status']      = 'warning';
            $response['description'] = 'Please enter description of atleast 150 characters.';
            return response()->json($response);
        }
 
       
          if ($request->hasFile('product_image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('product_image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        } 
 
          if ($request->hasFile('product_certificate')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('product_certificate')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg','pdf']))
           {
                $response['status']       = 'CertificateFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg,pdf extensions allowed.';
                return response()->json($response);
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

         if(isset($category_name) && !empty($category_name) && ($category_name=="Essential Oils" || $category_name=="Accessories" ) && $concentration==""){

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
              }
              else
              {
                 $response['status']       = 'warning';
                 $response['description']  = 'Please enter concentration';
                 return response()->json($response);
              }
             
        }//if another category


        //  if(isset($category_name) && !empty($category_name) && ($category_name=="Edibles") && isset($is_age_limit) && $is_age_limit=="1" && isset($age_restriction) &&  $age_restriction=="2"){

        //      $response['status']       = 'warning';
        //      $response['description']  = 'You can not select age 21+ For this category.';
        //      return response()->json($response); 

        // }


        // if($concentration=="")
        // {
        //     $response['status'] = 'warning';
        //     $response['description'] = 'Please enter concentration';
        //     return response()->json($response);
        // }

        if(isset($form_data['sku']) && !empty($form_data['sku'])){
            $check_sku = $this->ProductModel->where('sku',$form_data['sku'])->first();
            if($check_sku)
            {   

              $response['status']      = "error";
              $response['description'] = "Product with the same SKU already exist, please add another product";
              return response()->json($response);
            }
        }

       




        $check_product_title = $this->ProductModel->where('product_name',$form_data['product_name'])->first();
        // dd($check_product_title);
        if($check_product_title)
        {   

          $response['status']      = "error";
          $response['description'] = "The product with the same name already exists, please use the different name";
        
        }else
        {

          /********Add code for if user not subscribed or free or cance subscription then can not duplicate products**26june20********/


             $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$form_data['user_id'])->where('membership_status','1')->get();
                             if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                             {
                              $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
                             }     


                $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                                ->where('user_id',$form_data['user_id'])
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
                                                      ->where('user_id',$form_data['user_id'])
                                                      ->get()->count();     


                  if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                  {
                     $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                      if($res_active_productcount==$product_limit)
                      {
                        $response['status']      = "error";
                        $response['description']         = "Dispensary has reached the product limit for this plan.";
                          return $response;
                      }
                      elseif($res_active_productcount<=$product_limit)
                      {

                      }

                  } 
                   else if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata) && empty($user_subscriptiontabledata))
                  {
                                 
                        $membershiptype = $get_cancelmembershipdata['membership'];
                        if($membershiptype=="1")
                        {
                            $response['status']      = "error";
                            $response['description']         = "Dispensary has reached the product limit for this plan.";
                            return $response;
                        }
                        else
                        {

                          //@25june added this
                            $response['status']      = "error";
                            $response['description'] = "Dispensary has reached the product limit for this plan.";
                            return $response;

                         }//else

                     } //elseif
                    else if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata) && $user_subscriptiontabledata[0]['membership']=="1")
                    { 
                        $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                        if($res_active_productcount==$product_limit)
                        {
                          $response['status']      = "error";
                          $response['description'] = "Dispensary has reached the product limit for this plan";
                          return $response;
                        }
                        elseif($res_active_productcount<=$product_limit)
                        {

                        }
                    }//else if free                                               

                                              
          /*********end duplicate in subscription***26june20****************/


          
        /************start****check restricted categories for the seller********/

            $check_restricted_categories = get_seller_restricted_category_admin($form_data['user_id']);
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
                           $response['description'] = "Seller is not allowed to sell this item based on his state laws";
                           return response()->json($response);
                        }*/
                    }          
                } // if restricted_cat_ids     
            } // check_restricted_categories

      /********end***check restricted categories for the seller************/




        
          $productlist = $this->ProductService->save($form_data,$request);
       
          if($productlist)
          {

              /*-------------------------------------------------------
              |   Activity log Event
              --------------------------------------------------------*/
                
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                      $arr_event                 = [];
                      $arr_event['action']       = 'ADD';
                      $arr_event['title']        = $this->module_title;
                      $arr_event['user_id']      = isset($user->id)?$user->id:'';
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has created copy of product '.$form_data['product_name'].'.';

                      $result = $this->UserService->save_activity($arr_event); 
                }

            
              /*----------------------------------------------------------------------*/

      
              $response['link'] = $this->module_url_path;
              
              $response['status']      = "success";
              $response['description'] = "Product duplicated successfully."; 
            
          }
          else
          {
              $response['status']      = "error";
              $response['description'] = "Error occurred while copying product.";
          }
        }

        return response()->json($response);
    }

// End of Product Copy Save

    public function multi_action(Request $request)
    {
        $user = Sentinel::check();
         
        $flag = "";

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
            Flash::error('Problem occurred, while doing multi action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {  
                $flag = "del";
               $this->perform_delete(base64_decode($record_id),$flag);    
               Flash::success(str_plural($this->module_title).' deleted successfully'); 

            } 
            elseif($multi_action=="activate")
            { 
                $flag = "activate";

               $this->perform_activate(base64_decode($record_id),$flag); 
               Flash::success(str_plural($this->module_title).' activated successfully');

            }
            elseif($multi_action=="deactivate")
            { 
                $flag = "deactivate";

               $this->perform_deactivate(base64_decode($record_id),$flag);    
               Flash::success(str_plural($this->module_title).' blocked successfully');  
            }
        }

        if($multi_action=="delete")
        {
          /*-------------------------------------------------------
                |   Activity log Event
                 --------------------------------------------------------*/
              
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'Delete';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on products.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

    
              /*----------------------------------------------------------------------*/
        }

        if($multi_action=="activate")
        {
           /*-------------------------------------------------------
                |   Activity log Event
                 --------------------------------------------------------*/
              
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on products.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

    
              /*----------------------------------------------------------------------*/
        }

        if($multi_action=="deactivate")
        {
            /*-------------------------------------------------------
                |   Activity log Event
                 --------------------------------------------------------*/
              
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DEACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on products.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

    
               /*----------------------------------------------------------------------*/
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
            $arr_response['msg']   = 'Please activate the category and subcatgory of this product';
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
            $arr_response['msg']   = 'Please activate the category and subcatgory of this product';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }


    public function perform_activate($id,$flag=false)
    {
        $user = Sentinel::check();

        $arr = [];  
        $entity = $this->ProductModel->where('id',$id)->first();
        
        if($entity)
        {
          $entity_arr = $entity->toArray();

           $get_product = $this->ProductModel->where('id',$id)->get()->toArray();
           

           if(!empty($get_product))
           {
                $first_cat = $get_product[0]['first_level_category_id'];
                $second_cat = $get_product[0]['second_level_category_id'];
                $seller_id = $get_product[0]['user_id'];

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


                       $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$seller_id)->where('membership_status','1')->get();
                             if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                             {
                              $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
                             }     

                        $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                                        ->where('user_id',$seller_id)
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
                                                              ->where('user_id',$seller_id)
                                                              ->get()->count();          

                       if(empty($check_firstcat_active) || empty($check_secondcat_active))
                       {
                          //return false;
                          $arr['status'] = "ERROR";
                          $arr['msg']    = 'Please activate the category and subcatgory of this product';
                          return $arr;
                       }
                       else
                       {
 
                             /**************subscripition****************/

                             if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
                              {
                                 $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                                  if($res_active_productcount==$product_limit)
                                  {
                                    $arr['status']      = "error";
                                    $arr['msg']         = "Dispensary has reached the product limit for this plan.";
                                      return $arr;
                                  }
                                  elseif($res_active_productcount<=$product_limit)
                                  {

                                  }

                              }  
                             /* else if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
                              {
                                 
                                   $product_limit = isset($get_cancelmembershipdata['product_limit'])?$get_cancelmembershipdata['product_limit']:'0';

                                   if($res_active_productcount==$product_limit)
                                  {
                                    $arr['status']      = "error";
                                    $arr['msg']         = "Seller has reached the product limit for this plan.";
                                     return $arr;
                                  }
                                  elseif($res_active_productcount<=$product_limit)
                                  {

                                  }

                              }*/
                                //new condition added at 24 june 20 for if subsc cancelled bothfreepaid
                                else if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata) && empty($user_subscriptiontabledata))
                              {
                                 
                                  $membershiptype = $get_cancelmembershipdata['membership'];
                                  if($membershiptype=="1")
                                  {
                                      $arr['status']      = "error";
                                          $arr['msg']     = "Dispensary has reached the product limit for this plan.";
                                           return $arr;
                                  }
                                  else
                                  {

                                    //@25june added this
                                      $arr['status']      = "error";
                                      $arr['msg']         = "Dispensary has reached the product limit for this plan.";
                                      return $arr;



                                       //if user cancel paid mem then he can not activate product 25junecommented

                                        /* $product_limit = isset($get_cancelmembershipdata['product_limit'])?$get_cancelmembershipdata['product_limit']:'0';

                                         if($res_active_productcount==$product_limit)
                                        {
                                          $arr['status']      = "error";
                                          $arr['msg']         = "Seller has reached the product limit for this plan.";
                                           return $arr;
                                        }
                                        elseif($res_active_productcount<=$product_limit)
                                        {

                                        }*/


                                  }//else

                              } //elseif
                              else if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata) && $user_subscriptiontabledata[0]['membership']=="1")
                              { 
                                  $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';

                                  if($res_active_productcount==$product_limit)
                                  {
                                    $arr['status']      = "error";
                                    $arr['msg'] = "Dispensary has reached the product limit for this plan";
                                    return $arr;
                                  }
                                  elseif($res_active_productcount<=$product_limit)
                                  {

                                  }
                              }//else if free     
                           /******************subscripition******************/

                         //return $this->ProductModel->where('id',$id)->update(['is_active'=>'1']);

                          $updated = $this->ProductModel->where('id',$id)->update(['is_active'=>'1']);
                          
                          if($updated)
                          {

                              if($flag==false)
                              {
                                /*-------------------------------------------------------
                                |   Activity log Event
                                --------------------------------------------------------*/
                                  
                                //save sub admin activity log 

                                if(isset($user) && $user->inRole('sub_admin'))
                                {
                                    $arr_event                 = [];
                                    $arr_event['action']       = 'ACTIVATE';
                                    $arr_event['title']        = $this->module_title;
                                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated product '.$entity_arr['product_name'].'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                                /*----------------------------------------------------------------------*/

                              }
                                
                                $arr['status'] = 'SUCCESS';
                                $arr['msg'] = '';
                                return $arr;
                          }

                       }//elseof check first and secondcat                  
                }//if 

           }//ifnot empty getproduct
          
        }// if entity

        return FALSE;
    }

 
    public function perform_deactivate($id,$flag =false)
    {
        $user = Sentinel::check();

        $entity = $this->ProductModel->where('id',$id)->first();

        if($entity)
        {
           $entity_arr = $entity->toArray();

           // return $this->ProductModel->where('id',$id)->update(['is_active'=>'0']);


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
                       } 
                       else
                       {

                          if($flag ==false)
                          {
                              /*-------------------------------------------------------
                              |   Activity log Event
                              --------------------------------------------------------*/
                                      
                              //save sub admin activity log 

                              if(isset($user) && $user->inRole('sub_admin'))
                              {
                                  $arr_event                 = [];
                                  $arr_event['action']       = 'DEACTIVATE';
                                  $arr_event['title']        = $this->module_title;
                                  $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated product '.$entity_arr['product_name'].'.';

                                  $result = $this->UserService->save_activity($arr_event); 
                              }

                              /*----------------------------------------------------------------------*/
                          }
                         

                          return $this->ProductModel->where('id',$id)->update(['is_active'=>'0']);
                       }                  
                } 

           }




        }// if entity
        return FALSE;
    }


    public function delete_images($id)
    {   
        $user = Sentinel::check();

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

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
              //save sub admin activity log 

              if(isset($user) && $user->inRole('sub_admin'))
              {
                  $arr_event                 = [];
                  $arr_event['action']       = 'Delete';
                  $arr_event['title']        = $this->module_title;
                  $arr_event['user_id']      = isset($user->id)?$user->id:'';
                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted image.';

                  $result = $this->UserService->save_activity($arr_event); 
              }


            /*----------------------------------------------------------------------*/  

              $arr_response['status']      = 'SUCCESS';
              $arr_response['description'] = 'Image deleted successfully';

            }else{
               $arr_response['status']      = 'ERROR';
               $arr_response['description'] = 'Problem occured while deleting';
            }
            
        }else{
            $arr_response['status']      = 'ERROR';
            $arr_response['description'] = 'Problem occured while deleting';

        }
        return $arr_response;
    }

    
    
   

    public function delete($enc_id = FALSE)
    {   
        

        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {   

            Flash::success(str_singular($this->module_title).' deleted successfully');
        }
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }

    public function perform_delete($id,$flag=false)
    {
        $user = Sentinel::check();

        $is_fav_prod     = "";
        $entity          = $this->ProductModel->where('id',$id)->first();
    
        if($entity)
        {
           $entity_arr = $entity->toArray();

           $product_images  = $this->ProductImagesModel->where('product_id',$id)->get()->toArray();
             foreach($product_images as $v)
            {
               $this->ProductImagesModel->where('product_id',$id)->delete();

                $unlink_old_img_path    = $this->product_image_base_img_path.$v['image'];
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

            $is_fav_prod = $this->FavoriteModel->where('product_id',$id)->count();
            
            if($is_fav_prod>0)
            {  
              $this->FavoriteModel->where('product_id',$id)->delete();
            }

            /*---------------------- Activity log Event--------------------------*/
              /*$arr_event                 = [];
              $arr_event['ACTION']       = 'REMOVED';
              $arr_event['MODULE_ID']    =  $id;
              $arr_event['MODULE_TITLE'] = $this->module_title;
              $arr_event['MODULE_DATA'] = json_encode(['id'=>$id,'status'=>'REMOVED']);

              $this->save_activity($arr_event);*/

            if($flag==false)
            {
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                  //save sub admin activity log 

                  if(isset($user) && $user->inRole('sub_admin'))
                  {
                      $arr_event                 = [];
                      $arr_event['action']       = 'Delete';
                      $arr_event['title']        = $this->module_title;
                      $arr_event['user_id']      = isset($user->id)?$user->id:'';
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted product '.$entity_arr['product_name'].'.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }

                  /*----------------------------------------------------------------------*/
            }    


              Flash::success(str_plural($this->module_title).' deleted successfully');
              return true; 

        }
        else
        {
          Flash::error('Problem occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }



    public function view($productid)
    {
       $productid = base64_decode($productid);

        $this->arr['arr_data'] = array();
        $obj_data    = $this->ProductService->get_product_details($productid);
        $arr_comment = $this->ProductCommentModel->where('product_id',$productid)->with('reply_details.user_details','user_details')->get()->toArray();

        $this->arr_view_data['page_title']      = "Product Details";
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $obj_data;  
        $this->arr_view_data['arr_comment']     = isset($arr_comment)?$arr_comment:[];      
        $this->arr_view_data['product_imageurl_path'] = $this->product_imageurl_path;
        $this->arr_view_data['add_product_public_img_path'] = $this->add_product_public_img_path;

        return view($this->module_view_folder.'.show', $this->arr_view_data);
    }
    public function Reviews($productid)
    {
        $productid = base64_decode($productid);
        $this->arr['arr_data'] = array();
        $obj_data    = $this->ProductService->get_product_details($productid);
       
        $this->arr_view_data['page_title']      = "Product Details"; 
        $this->arr_view_data['module_title']    = "Ratings & Reviews";
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $obj_data;  
        $this->arr_view_data['product_imageurl_path'] = $this->product_imageurl_path;
        $this->arr_view_data['product_id']      = $productid;
        return view($this->module_view_folder.'.ratingsreview', $this->arr_view_data); 
    } 

 
    public function get_reviews(Request $request,$productid)
    {
       
        $obj_ratings     = $this->ProductService->get_reviewsrating_details($request,$productid);

        $current_context = $this;
        $json_result     = Datatables::of($obj_ratings);
        $json_result     = $json_result->blacklist(['id']);        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })

                            ->editColumn('rating',function($data) use ($current_context)
                            {
                                $rating = $data->rating;

                                 // if($rating==1){$rating_1 = 'one';}
                                 // else if($rating==2){$rating_1 = 'two';}
                                 // else if($rating==3){$rating_1 = 'three';}
                                 // else if($rating==4){$rating_1 = 'four';}
                                 // else if($rating==5){$rating_1 = 'five';}
                                 // else if($rating==0.5){$rating_1 = 'zeropointfive';}
                                 // else if($rating==1.5){$rating_1 = 'onepointfive';}
                                 // else if($rating==2.5){$rating_1 = 'twopointfive';}
                                 // else if($rating==3.5){$rating_1 = 'threepointfive';}
                                 // else if($rating==4.5){$rating_1 = 'fourpointfive';}

                                  $rating_1 = isset($rating)?get_avg_rating_image($rating):'';


                                 if($rating>0)
                                 {
                                  $starvar = $rating_1; 
                                  // $src =url('/').'/assets/front/images/'.$starvar.'.png';
                                  $src =url('/').'/assets/front/images/star/'.$starvar.'.svg';
                                  $img = "<img src=".$src." title=".$rating." >";
                                  return $img;

                                }else{

                                  return '-';
                                }
                                return $img;
                            })
                            ->editColumn('rated_on',function($data) use ($current_context)
                            {
                              $rate_date = $data->updated_at;
                              $datetime = explode(" ", $rate_date); 
                              $ratedondate = us_date_format($datetime[0]);
                              $ratedontime = time_format($datetime[1]);
                              return $ratedondate.' '.$ratedontime;

                            })
                            ->editColumn('buyer_name',function($data) use ($current_context)
                            {
                                if($data->buyer_id==0)
                                {
                                   if(isset($data->user_name) && !empty($data->user_name))
                                    return $data->user_name;
                                  else
                                    return 'NA';
                                }else
                                {
                                  return $data->buyer_name;
                                }
                            })

                             ->editColumn('review',function($data) use ($current_context)
                            {
                                if(isset($data->review))
                                { 
                                  if(strlen($data->review)>20)
                                    return substr($data->review,0,20)."..<a 
                                    reviews='".$data->review."' class='showreview ' style='color:black'> View Review</a>";
                                  else
                                    return $data->review;

                                }else
                                {
                                  return "NA";
                                }
                            })
                            

                            ->editColumn('emoji',function($data) use ($current_context)
                            {

                                if(isset($data->emoji) && !empty($data->emoji))
                                {
                                  $emojihtml = '<div class="emojiiconsnew">';
                                  $exp_emoji = explode(",",$data->emoji);
                                  foreach($exp_emoji as $k=>$v)
                                  {
                                    // $emojihtml .= "<div class='emojiiconsnew'><img src=".url('/')."/assets/images/".$v." width='32px'/> " .ucwords(str_replace('.svg',' ',(str_replace('_',' ',$v))))." </div>";
                                      $get_reported_effects = get_effect_name($v);
                                      if(isset($get_reported_effects) && !empty($get_reported_effects))
                                      {
                                        $emojihtml .= "<div class='emojiiconsnew'>";
                                        if(file_exists(base_path().'/uploads/reported_effects/'.$get_reported_effects['image']) && isset($get_reported_effects['image']) && !empty($get_reported_effects['image']))
                                        {
                                          $emojihtml .="<img src=".url('/')."/uploads/reported_effects/".$get_reported_effects['image']." width='32px'/>";

                                          $emojihtml .= isset($get_reported_effects['title'])?$get_reported_effects['title']:'';
                                        }//if file exists
                                         $emojihtml .="</div>"; 
                                      }//if get_reported_effects


                                  }//foreach
                                  return $emojihtml; 
                                }//if
                            })
                             ->editColumn('build_action_btn',function($data) use ($current_context,$productid)
                            {   
                               
                                $edit_href =  $this->module_url_path.'/editreview/'.base64_encode($productid).'/'.base64_encode($data->id);
                                $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';
                            
                                return $build_action = $build_edit_action;
                            })
                           ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
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

     //   $product_id = base64_decode($request->product_id);
        $product_id = $request->product_id;

        $verification_status  = $request->status;

        $user = Sentinel::check();

        $is_available = $this->ProductModel->where('id',$product_id)->count()>0;

        
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
            else if($verification_status==2)
            {
                $update_field = 2;
            }


            $status = $this->ProductModel->where('id',$product_id)->update(['is_approve'=>$update_field]);

            if($status)
            {       
                
                $response['status']      = 'SUCCESS';
                
                if($verification_status==1)
                {

                      $url     = url('/').'/seller/product/view/'.base64_encode($product_id);

                      /********************send notification and email of product approve**********/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>approved</b> the product <a target="_blank" href="'.$url.'"><b>'.$product_name.'</b></a>.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product approved';
                            $this->GeneralService->save_notification($arr_event);


                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                           /* $msg     = html_entity_decode(config('app.project.admin_name').' has approved your product <b>'. ucfirst($product_name).' </b>');

                            
                            $subject = 'Product approved';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '100';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '' ;
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

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
                          $imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];
                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }




                      $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div> <b>'.$setname.'</b> just added a new product to chow. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($product_id).'" target="_blank" class="viewcls">View</a>');
                      $arr_eventdata['title']    = 'Product Approve By Admin';             
                      // $this->EventModel->create($arr_eventdata);
                      /***************end of eventdata**for newproduct*******/


                      /*-------------------------------------------------------
                      |   Activity log Event
                      --------------------------------------------------------*/
                        
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'APPROVE';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has approved product '.$product_name.'.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }


                      /*----------------------------------------------------------------------*/


                      $response['message'] = str_singular($this->module_title).' approved successfully';
                }
                else
                {

                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                      //save sub admin activity log 

                      if(isset($user) && $user->inRole('sub_admin'))
                      {
                          $arr_event                 = [];
                          $arr_event['action']       = 'DISAPPROVE';
                          $arr_event['title']        = $this->module_title;
                          $arr_event['user_id']      = isset($user->id)?$user->id:'';
                          $arr_event['message']      = $user->first_name.' '.$user->last_name.' has disapproved product '.$product_name.'.';

                          $result = $this->UserService->save_activity($arr_event); 
                      }

                    /*----------------------------------------------------------------------*/

                    $response['message'] = str_singular($this->module_title).' disapproved successfully';
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

    public function toggleChowsChoice(Request $request)
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


            $status = $this->ProductModel->where('id',$product_id)->update(['is_chows_choice'=>$update_field]);

            if($status)
            {       
                
                if($verification_status==1)
                {

                         $url     = url('/').'/seller/product/view/'.base64_encode($product_id);

                      /********************send notification and email of product approve**********/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>made</b> the product <b><a target="_blank" href="'.$url.'">'.$product_name.'</b></a> as chows choice');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product marked as chows choice';
                            $this->GeneralService->save_notification($arr_event);


                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                         /*   $msg     = html_entity_decode(config('app.project.admin_name').' has made your product <b>'.ucfirst($product_name).'</b> as chows choice.');

                            
                            $subject = 'Product marked as chows choice';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '101';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

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
                          $imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];
                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }




                      $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div> <b>'.$setname.'</b> just added a new product to chow. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($product_id).'" target="_blank" class="viewcls">View</a>');
                      $arr_eventdata['title']    = 'Product Marked as chows choice By Admin';             
                     // $this->EventModel->create($arr_eventdata);
                      /***************end of eventdata**for newproduct*******/


                      /*-------------------------------------------------------
                      |   Activity log Event
                      --------------------------------------------------------*/
                        
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'MARKED';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked product '.$product_name.' as a chow choice.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }

                      /*----------------------------------------------------------------------*/

                      $response['status']      = 'SUCCESS';
                      $response['message']     = str_singular($this->module_title).' marked as chows choice successfully';

                    $response['status']      = 'SUCCESS';
                    $response['message']     = str_singular($this->module_title)." marked as chow's choice successfully";

                }
                else
                {
                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'UNMARKED';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has removed product '.$product_name.' from chow choice.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                    /*----------------------------------------------------------------------*/

                    $response['message'] = str_singular($this->module_title)." removed from chow's choice successfully";
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

    public function autosuggest(request $request)
    { 
       // dd($request->all());     
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


    }// end of function of autosuggest



    public function rejectproduct(Request $request)
    {
        $user = Sentinel::check();

 //       $product_id = base64_decode($request->product_id);
        $product_id = $request->product_id;
 
        $reason    = $request->reason;

        if($product_id && $reason)
        {    
            $res_product = $this->ProductModel->select('*')
                            ->where('id',$product_id)  
                            ->get();


             if(!empty($res_product) && count($res_product)>0)
             {

                $res_product = $res_product->toArray();

                $approve_status = $res_product[0]['is_approve'];
                $seller_id      = $res_product[0]['user_id'];
                $product_name      = $res_product[0]['product_name'];

             
                //if($approve_status=='1')
               // {   
               
                    $res_status_update = $this->ProductModel
                                    ->where('id',$product_id)
                                    ->update(['is_approve'=>'2','reason'=>$reason]);   
                    if($res_status_update)
                    {



                            $url     = url('/').'/seller/product/view/'.base64_encode($product_id);
                        /*********************Send Notification to seller (START)********************/
                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>disapproved</b> the product <a target="_blank" href="'.$url.'"><b>'.$product_name.'</b></a>.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product disapproved';
                            $this->GeneralService->save_notification($arr_event);

                        /*******************Send Notification to seller (END)**************/


                         /***************Send Notification Mail to seller (START)************/
                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
/*
                            $msg     = html_entity_decode(config('app.project.admin_name').' has disapproved your product <b>'. ucfirst($product_name).' </b>. <br>
                                    <b>Reason:</b> '.$reason.'');

                            
                            $subject = 'Product disapproved';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '102';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*********************Send Notification Mail to seller (END)*****************/
                        

                          /*-------------------------------------------------------
                          |   Activity log Event
                          --------------------------------------------------------*/
                            
                            //save sub admin activity log 

                            if(isset($user) && $user->inRole('sub_admin'))
                            {
                                $arr_event                 = [];
                                $arr_event['action']       = 'REJECT';
                                $arr_event['title']        = $this->module_title;
                                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has rejected product '.$product_name.'.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }

                       
                          /*----------------------------------------------------------------------*/

                          $response['status']      = 'SUCCESS';
                          $response['description'] = 'Product disapproved successfully.'; 
                          return response()->json($response);   
                    }            


               /* }else if($approve_status==0){

                      $response['status']      = 'ERROR';
                      $response['description'] = 'Product already disapproved'; 
                      return response()->json($response);   
                }*/
             }
        }
   
    }//end of reject


    public function removeproduct(Request $request)
    {

        $user = Sentinel::check();

        $product_id = base64_decode($request->product_id);
 
        $reason     = $request->reason;

        if($product_id && $reason)
        {    
            $res_product = $this->ProductModel->select('*')
                            ->where('id',$product_id)  
                            ->get();


             if(!empty($res_product) && count($res_product)>0)
             {

                $res_product = $res_product->toArray();

                $approve_status = $res_product[0]['is_chows_choice'];
                $seller_id      = $res_product[0]['user_id'];
                $product_name   = $res_product[0]['product_name'];

             
                //if($approve_status=='1')
               // {   
               
                    $res_status_update = $this->ProductModel
                                    ->where('id',$product_id)
                                    ->update(['is_chows_choice'=>0,'reason_for_removal_from_chows_choice'=>$reason]);


                    if($res_status_update)
                    {

                            $url     = url('/').'/seller/product/view/'.base64_encode($product_id);
                        /*********************Send Notification to seller (START)********************/
                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>removed </b> the product <b><a target="_blank" href="'.$url.'">'.$product_name.'</b></a> from chows choice');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product removed from  chows choice';
                            $this->GeneralService->save_notification($arr_event);

                        /*******************Send Notification to seller (END)**************/


                         /***************Send Notification Mail to seller (START)************/
                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                            /*$msg     = html_entity_decode(config('app.project.admin_name').' has removed your product <b>'.ucfirst($product_name).'</b> from chows choice. <br><b>Reason:</b> '.$reason.'');

                            
                            $subject = 'Product removed from chows choice';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  =>  ucfirst($product_name),
                                                  'REASON'        => $reason,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '103';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*********************Send Notification Mail to seller (END)*****************/
                         
                          /*-------------------------------------------------------
                          |   Activity log Event
                          --------------------------------------------------------*/
                            
                            //save sub admin activity log 

                            if(isset($user) && $user->inRole('sub_admin'))
                            {
                                $arr_event                 = [];
                                $arr_event['action']       = 'REMOVE';
                                $arr_event['title']        = $this->module_title;
                                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has removed product '.$product_name.' from chow choice.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }

                       
                          /*----------------------------------------------------------------------*/


                          $response['status']      = 'SUCCESS';
                          $response['description'] = "Product removed from chow's choice successfully."; 
                          return response()->json($response);   
                    }            


               /* }else if($approve_status==0){

                      $response['status']      = 'ERROR';
                      $response['description'] = 'Product already disapproved'; 
                      return response()->json($response);   
                }*/
             }
        }
   
    }//end of reject


    public function autosuggest_dropshipper(request $request)
    { 
       // dd($request->all());     
        if($request->query)
       {
          
           $prefiex_dropshipper = DB::getTablePrefix().$this->DropShipperModel->getTable();

            $query     = $request['query']; 
            $seller_id = $request['seller_id'];
            $data = DB::table($prefiex_dropshipper)
              ->where('name', 'LIKE', "%{$query}%")
              ->where('seller_id',$seller_id)
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


    }// end of function of autosuggest

    public function get_dropshipper_details(request $request)
    {
        if($request->query)
       {
            $prefiex_dropshipper = DB::getTablePrefix().$this->DropShipperModel->getTable();

            $query     = $request['query']; 
            $seller_id = $request['seller_id'];

            $data = DB::table($prefiex_dropshipper)
                    ->where('name', 'LIKE', "%{$query}%")
                    ->where('seller_id',$seller_id)
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

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>made</b> the product <b><a target="_blank" href="'.$url.'">'.$product_name.'</b></a> as out of stock');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product marked as out of stock';
                            $this->GeneralService->save_notification($arr_event);


                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                         /*   $msg     = html_entity_decode(config('app.project.admin_name').' has made your product <b>'.ucfirst($product_name).'</b> as chows choice.');

                            
                            $subject = 'Product marked as chows choice';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '136';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

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
                          $imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];
                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }




                      $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div> <b>'.$setname.'</b> just added a new product to chow. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($product_id).'" target="_blank" class="viewcls">View</a>');
                      $arr_eventdata['title']    = 'Product Marked as out of stock By Admin';             
                      //$this->EventModel->create($arr_eventdata);
                      /***************end of eventdata**for newproduct*******/


                      /*-------------------------------------------------------
                      |   Activity log Event
                      --------------------------------------------------------*/
                        
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'MARKED';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked product '.$product_name.' as out of stock.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }

                      /*----------------------------------------------------------------------*/

                      $response['status']      = 'SUCCESS';
                      $response['message']     = str_singular($this->module_title).' marked as out of stock successfully';

                    $response['status']      = 'SUCCESS';
                    $response['message']     = str_singular($this->module_title)." marked as out of stock successfully";

                }
                else
                {
                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'UNMARKED';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has removed product '.$product_name.' from out of stock.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                    /*----------------------------------------------------------------------*/
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

      public function addreview($product_id=NULL)
    {
        $arr_category  = $arr_unit = [];
        $this->arr_view_data['page_title']      = "Add Review";
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['product_id'] = isset($product_id)?base64_decode($product_id):'';

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable(); 

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();


         $get_reported_effects = $this->ReportedEffectsModel->where('is_active','1')->get(); 
         if(isset($get_reported_effects) && !empty($get_reported_effects))
         {
           $get_reported_effects = $get_reported_effects->toArray();
         }  
         $this->arr_view_data['get_reported_effects'] = isset($get_reported_effects)?$get_reported_effects:[];


          
        return view($this->module_view_folder.'.addreview',$this->arr_view_data);
    }//addreview


    public function savereview(Request $request)
    { 
        $response = [];

        $user = Sentinel::check();

        $form_data = $request->all();

        $user_name  = isset($form_data['user_name'])?$form_data['user_name']:'';
        $title      = isset($form_data['title'])?$form_data['title']:'';
        $review     = isset($form_data['review'])?$form_data['review']:'';
        $emojiarr   = isset($form_data['emoji'])?$form_data['emoji']:'';
        $product_id  = isset($form_data['product_id'])?$form_data['product_id']:'';
        $rating      = isset($form_data['rating'])?$form_data['rating']:'';


        if(isset($emojiarr) && !empty($emojiarr))
        {
          $emojiarr = implode(",", $emojiarr);
        }


        $is_update_process = false; 

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }


        $arr_rules = [];
        if($is_update_process == false)
        {
            $arr_rules = [
                            'title' => 'required',
                      
                         ];
        } 
      
        if(isset($review) && !empty($review)){

        }else{  
            $response['status']      = 'warning';
            $response['description'] = 'Please enter review';
              return response()->json($response);
        }
        $validator = Validator::make($request->all(),$arr_rules);
       
       // dd($errors = $validator->errors());
        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all required fields..';

            return response()->json($response);
        }

          $product_review = $this->ReviewRatingsModel->firstOrNew(['id' => $id]);

        /*  $input_data = [
                        'product_id'     => $product_id,
                        'buyer_id'       => '',
                        //'rating'         => $rating,
                        'title'          => $title,
                        'review'         => $review,
                        'emoji'          => $emojiarr,
                        'user_name'      => $user_name
                        
                      ]; */
                      
       // $add_review = $this->ReviewRatingsModel->create($input_data);

         $product_review->product_id = $product_id;
         $product_review->title = $title;
         $product_review->review = $review;
         $product_review->emoji = $emojiarr;
         $product_review->user_name = $user_name;
         $product_review->rating = $rating;
         $product_review->save(); 
        if($product_review)
        {
  
            if($is_update_process == false)
            {
                if($product_review->id)
                {
                    $response['link'] = $this->module_url_path.'/Reviews/'.base64_encode($product_id);

                   // $response['link'] =$this->module_url_path.'/edit/'.base64_encode($productlist->id);
                }else{

                    $response['link'] = $this->module_url_path.'/Reviews/'.base64_encode($product_id);

                }
            }
            else
            {
                $response['link'] = $this->module_url_path.'/Reviews/'.base64_encode($product_id);
            }

            if($is_update_process==true)
            {
                  
                  $response['status']      = "success";
                  $response['description'] = "Review updated successfully."; 

            }
            else
            {
                  $response['status']      = "success";
                  $response['description'] = "Review added successfully."; 

            }
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding review.";
        }

        return response()->json($response);
    }//savereview


     public function editreview($product_id=NULL,$enc_id=NULL)
    {       

        $id   = base64_decode($enc_id);
       
        $obj_data = $this->ReviewRatingsModel->where('id', $id)->first();
    
        $arr_product_review = [];
        if($obj_data)
        {
           $arr_product_review = $obj_data->toArray(); 
        }
     

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();

         $get_reported_effects = $this->ReportedEffectsModel->where('is_active','1')->get(); 
         if(isset($get_reported_effects) && !empty($get_reported_effects))
         {
           $get_reported_effects = $get_reported_effects->toArray();
         }  
         $this->arr_view_data['get_reported_effects'] = isset($get_reported_effects)?$get_reported_effects:[];
        
        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['arr_product']              = isset($arr_product_review) ? $arr_product_review : []; 
        $this->arr_view_data['product_id'] = isset($product_id)?base64_decode($product_id):'';

        $this->arr_view_data['page_title']               = "Edit Review ";
        $this->arr_view_data['module_title']             = $this->module_title;
        return view($this->module_view_folder.'.editreview',$this->arr_view_data);   
    } //Edit review


    // function for is product trending 
     public function toggleTrending(Request $request)
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

              }//if
 
            if($verification_status==1)
            {
                $update_field = 1;
            }
            else if($verification_status==0)
            {
                $update_field = 0;
            }


            $status = $this->ProductModel->where('id',$product_id)->update(['is_trending'=>$update_field]);

            if($status)
            {       
                
                if($verification_status==1)
                {

                    $url     = url('/').'/seller/product/view/'.base64_encode($product_id);

                      /********send notification and email of product toggle**********/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>made</b> the product <b><a target="_blank" href="'.$url.'">'.$product_name.'</b></a> as trending');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product marked as trending';
                            $this->GeneralService->save_notification($arr_event);


                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                        

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '145';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                      /******end of send notification and email of product*trending********/

                     /***********start of eventdata**for newproduct*trending******/
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
                          $imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];
                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }




                      $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div> <b>'.$setname.'</b> just added a new product to chow as trending. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($product_id).'" target="_blank" class="viewcls">View</a>');
                      $arr_eventdata['title']    = 'Product Marked as trending By Admin';             
                      //$this->EventModel->create($arr_eventdata);
                      /***************end of eventdata**for newproduct*******/


                      /*-------------------------------------------------------
                      |   Activity log Event
                      --------------------------------------------------------*/
                        
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'MARKED';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked product '.$product_name.' as trending.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }

                      /*----------------------------------------------------------------------*/

                      $response['status']      = 'SUCCESS';
                      $response['message']     = str_singular($this->module_title).' marked as trending successfully';

                    $response['status']      = 'SUCCESS';
                    $response['message']     = str_singular($this->module_title)." marked as trending successfully";

                }//if verification_status is 1  
                else
                {
                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'UNMARKED';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has removed product '.$product_name.' from trending.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                    /*----------------------------------------------------------------------*/
                    $response['status']      = 'SUCCESS';
                    $response['message'] = str_singular($this->module_title)." removed from trending successfully";
                }

           
                
            }//if status
            else
            {
                $response['status']      = 'ERROR';
                $response['message']     = 'Problem occured while performing action';
            }//else of if status
            
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

}//end class
