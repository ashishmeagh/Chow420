<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\FavoriteModel;
use App\Models\ProductImagesModel;
use App\Models\AgeRestrictionModel;
use App\Models\BrandModel;
use App\Models\ProductInventoryModel;
use App\Models\UserSubscriptionsModel; 
use App\Models\EventModel; 
use App\Models\ProductDimensionsModel;
use App\Models\DropShipperModel;
use App\Models\ReviewRatingsModel;
use App\Models\SpectrumModel;
use App\Models\MoneyBackModel;
use App\Models\BuyerWalletModel;

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
 
class MoneyBackRequestedProductsController extends Controller
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
                                ProductInventoryModel $ProductInventoryModel,
                                GeneralService $GeneralService,
                                UserSubscriptionsModel $UserSubscriptionsModel,
                                EventModel $EventModel,
                                ProductDimensionsModel $ProductDimensionsModel,
                                DropShipperModel $DropShipperModel,
                                UserService $UserService,
                                ReviewRatingsModel $ReviewRatingsModel,
                                SpectrumModel $SpectrumModel,
                                MoneyBackModel $MoneyBackModel,
                                BuyerWalletModel $BuyerWalletModel

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
        $this->MoneyBackModel               = $MoneyBackModel;
        $this->BuyerWalletModel             = $BuyerWalletModel;

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');
        $this->product_image_base_img_path  = base_path().config('app.project.img_path.product_images');
        $this->product_public_img_path      = url('/').config('app.project.img_path.product_images');
        $this->user_id_proof                = url('/').config('app.project.id_proof');
        $this->product_image_thumb_base_img_path = base_path().config('app.project.img_path.product_imagesthumb');

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/reported_issues_products");
        $this->product_imageurl_path         = url(config('app.project.product_images'));

        $this->module_title                 = "Reported Issues";
        $this->modyle_url_slug              = "Product Listing";
        $this->module_view_folder           = "admin.requested_products";
       
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
       
        $product_details        = $this->ProductModel->getTable();
        $prefix_product_detail  = DB::getTablePrefix().$this->ProductModel->getTable();
        $prefix_spectrum        = DB::getTablePrefix().$this->ProductModel->getTable();

        $productbrand        = $this->BrandModel->getTable();
        $prefiex_productbrand = DB::getTablePrefix().$this->BrandModel->getTable();

        $sellertable         = $this->SellerModel->getTable();
        $prefiex_sellertable =  DB::getTablePrefix().$this->SellerModel->getTable();

        $money_back_request_table         = $this->MoneyBackModel->getTable();
        $prefiex_money_back_request_table = DB::getTablePrefix().$this->MoneyBackModel->getTable();

        $user_details       = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();


/*        $product_obj = $this->MoneyBackModel->where('status','!=',1)
                             ->with(['product_details','product_details.get_seller_additional_details','product_details.get_brand_detail'])
                             ->orderBy('id','DESC'); */


        $obj_product = DB::table($money_back_request_table)
                          ->select(DB::raw($money_back_request_table.'.*,'.
                        
                        $prefix_product_detail.'.product_name,'.
                        $prefix_product_detail.'.id as p_id,'.
                        $prefix_product_detail.'.unit_price,'.
                        $prefix_product_detail.'.price_drop_to,'.
                        $prefiex_productbrand.'.name as brand_name,'.

                        $prefiex_sellertable.'.business_name as business_name,'.

                        "CONCAT(RL.first_name,' ',RL.last_name) as buyer_name,".
                              
                        "CONCAT(RR.first_name,' ',RR.last_name) as seller_name"
                          

                        /*"CONCAT(".$prefix_user_detail.".first_name,' ',"
                                .$prefix_user_detail.".last_name) as seller_name,".
*/

                        ))

                        ->leftjoin($prefix_product_detail,$prefix_product_detail.'.id','=',$money_back_request_table.'.product_id')

                        ->leftJoin($prefix_user_detail." AS RR", 'RR.id','=',$prefix_product_detail.'.user_id')

                        ->leftJoin($prefiex_productbrand,$prefiex_productbrand.'.id','=',$prefix_product_detail.'.brand')   

                        ->leftjoin($prefiex_sellertable,$prefiex_sellertable.'.user_id','=',$prefix_product_detail.'.user_id')


                        ->leftJoin($prefix_user_detail." AS RL", 'RL.id','=',$money_back_request_table.'.buyer_id')

                       // ->where($money_back_request_table.'.status','!=',1)
                        ->orderBy($money_back_request_table.'.id','DESC');  



        /*-------------------------Filter---------------------------------------*/                               

        $arr_search_column = $request->input('column_filter');

        if(isset($arr_search_column['q_product_name']) && $arr_search_column['q_product_name'] != '')
        {
              $search_name_term  = $arr_search_column['q_product_name'];
              $obj_product  = $obj_product->where($prefix_product_detail.'.product_name','LIKE', '%'.$search_name_term.'%');

        }
            
        if(isset($arr_search_column['q_brand']) && $arr_search_column['q_brand'] != '')
        {
            $search_brandname  = $arr_search_column['q_brand'];
            $obj_product  = $obj_product->where($productbrand.'.name','LIKE', '%'.$search_brandname.'%');

        }


        if(isset($arr_search_column['q_price']) && $arr_search_column['q_price'] != '')
        {
            $search_unit_price  = $arr_search_column['q_price'];
            $obj_product  = $obj_product->where($prefix_product_detail.'.unit_price','LIKE', '%'.$search_unit_price.'%')
                                      ->orwhere($prefix_product_detail.'.price_drop_to','LIKE', '%'.$search_unit_price.'%');

        }


        if(isset($arr_search_column['q_seller_name']) && $arr_search_column['q_seller_name'] != '')
        {
             $search_seller_term  = $arr_search_column['q_seller_name'];
             
              $obj_product  = $obj_product->where($prefiex_sellertable.'.business_name','LIKE', '%'.$search_seller_term.'%');

        }     



        if(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name'] != '')
        {
            $search_seller_term  = $arr_search_column['q_buyer_name'];
             
            $obj_product  = $obj_product->having('buyer_name','LIKE', '%'.$search_seller_term.'%');
            
        }                      
                   

  
        return $obj_product;

    }


    // FUNCTION TO SHOW RECORDS OF product listing

    public function get_records(Request $request)
    {
        $obj_user        = $this->get_productlist_details($request);

        $current_context = $this;
        $json_result     = Datatables::of($obj_user);
        $json_result     = $json_result->blacklist(['id']);        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->product_id);
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

                            ->editColumn('product_name',function($data) use ($current_context)
                            {
                                if(isset($data->product_name) && !empty($data->product_name))
                                {
                                 return $data->product_name;
                                }
                                else{
                                  return 'NA';
                                }
                            })   

                            ->editColumn('brand_name',function($data) use ($current_context)
                            {
                                if(isset($data->brand_name) && !empty($data->brand_name))
                                {
                                 return $data->brand_name;
                                }
                                else{
                                  return 'NA';
                                }
                            })     
  

                            ->editColumn('unit_price',function($data) use ($current_context)
                            {
                              if(isset($data->price_drop_to) && $data->price_drop_to!='' && $data->price_drop_to!= 0)
                              {
                                 $unit_price = '$'.num_format($data->price_drop_to);
                              }
                              else
                              {
                                 $unit_price = '$'.num_format($data->unit_price);
                              }
                               
                               return $unit_price;
                            }) 


                            ->editColumn('status',function($data) use ($current_context)
                            {
                              $status = '';

                              if(isset($data->status)  && $data->status == 0)
                              {
                                  $status ='<label class="status-dispatched">Reported</label>';
                              }
                              elseif(isset($data->status) && $data->status == 1)
                              {
                                 $status ='<label class="status-dispatched label-success-apv">Refunded to wallet</label>';
                              }
                              elseif(isset($data->status) && $data->status == 2)
                              {
                                $status ='<label class="status-shipped">Corrected</label>';
                              }
                               
                               return $status;
                            })


                            ->editColumn('buyer_note',function($data) use ($current_context)
                            {
                                $note = '';
                                $buyer_note = isset($data->reported_issue_note)?$data->reported_issue_note:'';

                                if(isset($buyer_note) && $buyer_note!='')
                                {
                                   $string = strip_tags($buyer_note);       
                                 
                                    if(strlen($string) > 50)
                                    {
                                       $stringCut = substr($string, 0,50);
                                       
                                       $note = $stringCut.'...'.'<a href="javascript:void(0);" id="buyer_note_read_more" name="buyer_note_read_more" note="'.$buyer_note.'" onclick="showNote($(this));">read more</a>';
                                    }
                                    else
                                    {
                                        $note = $buyer_note;
                                    }
                                }
                                else
                                {
                                   $note = '--';
                                }

                                return $note; 
                            })

                            ->editColumn('admin_note',function($data) use ($current_context)
                            {
                                $note = '';

                                $admin_note = isset($data->note)?$data->note:'';

                        
                                if(isset($admin_note) && $admin_note!='')
                                {
                                    $string = strip_tags($admin_note);       
                                
                                    if(strlen($string) > 50)
                                    {
                                       $stringCut = substr($string, 0,50);
                                       
                                       $note = $stringCut.'...'.'<a href="javascript:void(0);" id="admin_note_read_more" name="admin_note_read_more" note="'.$admin_note.'" onclick="showNote($(this));">read more</a>';
                                    }
                                    else
                                    {
                                        $note = $admin_note;
                                    }
                                }
                                else
                                {
                                   $note = '--';
                                }

                                return $note; 
                                  
                            })


                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   

                                $view_product_details_href = $btn_reject = $btn_approve = $build_action = '';

                                $view_product_details_href = url('/').'/book/product/view/'.base64_encode($data->product_id);

                                $view_product_details_href = '<a class="eye-actn" href="'.$view_product_details_href.'" title="View">View Product</a>';


                                $btn_reject = '<a class="eye-actn" data-type="reject" href="javascript:void(0);" id="btn_reject" data-enc-id="'.base64_encode($data->id).'" onclick="reject($(this));" title="Reject">Reject</a>';


                                $btn_approve = '<a class="eye-actn" data-type="approve" href="javascript:void(0);" id="btn_approve" data-enc-id="'.base64_encode($data->id).'" onclick="approve($(this));" title="Approve">Approve</a>';

                                
                                if($data->status == 0)
                                {
                                   $build_action = $view_product_details_href.' '.$btn_reject.' '.$btn_approve;
                                }

                                if($data->status == 1)
                                {
                                   $build_action = $view_product_details_href;
                                }

                                if($data->status == 2)
                                {
                                   $build_action =  $view_product_details_href.' '.$btn_approve;
                                }

                            
                                return $build_action;
                            })
                        
                            ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
    }

    public function request_confirmation(Request $request)
    { 
       $data = $response =  $wallet_data = $product_arr = [];
       $product_price = 0;
       $msg = $status = '';


       $form_data = $request->all();

       $request_id  = isset($form_data['enc_id'])?base64_decode($form_data['enc_id']):0;
       $request_id  = intval($request_id);
       
       if(isset($form_data['type']) && $form_data['type']!='' && $form_data['type'] == 'reject')
       {
          $data['status'] = 2;
          // $status = 'Rejected';
           $status = 'Corrected';
       }
       elseif(isset($form_data['type']) && $form_data['type']!='' && $form_data['type'] == 'approve')
       {
         $data['status'] = 1;
         // $status = 'Approved';
         $status = 'Refunded';
       }
       
       $data['note']   = isset($form_data['note'])?$form_data['note']:'';


       $result = $this->MoneyBackModel->where('id',$request_id)->update($data);

       if($result == 1)
       {
            //add product price into buyer wallet after approve request

            $product_details  = $this->MoneyBackModel
                                        ->where('id',$request_id)
                                        ->with(['product_details','user_details'])
                                        ->first();


            
            if($product_details)
            {
                $product_arr = $product_details->toArray();

                if(isset($product_arr['product_details']['price_drop_to']) && $product_arr['product_details']['price_drop_to']!='' && $product_arr['product_details']['price_drop_to']!= 0)
                {
                    $product_price = $product_arr['product_details']['price_drop_to'];
                }
                else
                {
                   $product_price = $product_arr['product_details']['unit_price'];
                }
            }

            $product_details_view_url = url('/').'/search/product_detail/'.base64_encode($product_arr['product_id']);

     
            if($data['status'] == 1)
            {
                 

                $wallet_data['user_id']    = isset($product_arr['buyer_id'])?$product_arr['buyer_id']:0;
                $wallet_data['type']       = 'Reported_Issue';
                $wallet_data['amount']     = '+'.$product_price;
                $wallet_data['typeid']     = $request_id;
                $wallet_data['status']     = 1;

                $qry = $this->BuyerWalletModel->create($wallet_data);

                if($qry)
                {
                     $response['status']      = 'success';
                     $response['description'] = "Admin has refunded amount to your chow wallet";

                     $msg = 'Admin has approved your reported issue request for product <a target="_blank" href="'.$product_details_view_url.'"><b>'.get_product_name($product_arr['product_id']).'</b></a> and  $'.num_format($product_price).' amount has refunded to your chow wallet';
                 }
                else
                {
                    $response['status']      = 'error';
                    $response['description'] = "Something went wrong,please try again";
                }

            }
            else
            {
                  $response['status']      = 'success';
                  $response['description'] = "Issue has been corrected for future purposes";

                  $msg = 'Admin has rejected your reported issue request for product <a target="_blank" href="'.$product_details_view_url.'"><b>'.get_product_name($product_arr['product_id']);
            }


            //send notification to the buyer after money back request confirmation

            $admin_role = Sentinel::findRoleBySlug('admin');        
            $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
            if($admin_obj)
            {
              $admin_id = $admin_obj->user_id;            
            }

            $arr_event                 = [];
            $arr_event['from_user_id'] = $admin_id;
            $arr_event['to_user_id']   = $product_arr['buyer_id'];
            $arr_event['description']  = $msg;
            $arr_event['type']         = '';
            $arr_event['title']        = 'Request Confirmation';

            $this->GeneralService->save_notification($arr_event);


            //send email for money back guarantee confirmation to the buyer

            $url = $user_name = '';

            $url = url('/').'/buyer/reported_issues';

            $first_name = isset($product_arr['user_details']['first_name'])?$product_arr['user_details']['first_name']:'';
            $last_name = isset($product_arr['user_details']['last_name'])?$product_arr['user_details']['last_name']:'';

            $user_name = $first_name.' '.$last_name; 
     
            $arr_built_content =  [
                                      
                                       'APP_NAME'       => config('app.project.name'),
                                       'PRODUCT_NAME'   => $product_arr['product_details']['product_name'],
                                       'USER_NAME'      => $user_name,
                                       'URL'            => $url,
                                       'STATUS'         => $status,
                                       'NOTE'          => isset($product_arr['note'])?$product_arr['note']:''
                                    ];

            $arr_mail_data['email_template_id']  = '152';
            $arr_mail_data['arr_built_content']  = $arr_built_content;
            $arr_mail_data['user']               = $product_arr['user_details']; 
             
      
            $this->EmailService->send_mail_section($arr_mail_data);

          
        }
        else
        {
           $response['status']      = 'error';
           $response['description'] = "Something went wrong,please try again";
        }

       return response()->json($response);
    }


}//end class
