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
use App\Models\UserSubscriptionsModel; 
use App\Models\ProductDimensionsModel;
use App\Models\DropShipperModel;
use App\Models\StatesModel;
use App\Models\EventModel;



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
use App\Models\CouponModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class CouponController extends Controller
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
                                CouponModel $CouponModel
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
        $this->BrandModel                   = $BrandModel;
        $this->UserSubscriptionsModel       = $UserSubscriptionsModel;
        $this->ProductDimensionsModel       = $ProductDimensionsModel;
        $this->DropShipperModel             = $DropShipperModel;
        $this->StatesModel                  = $StatesModel;
        $this->GeneralService               = $GeneralService;
        $this->EventModel                   = $EventModel;
        $this->CouponModel                  = $CouponModel;



  
        $this->product_image_base_img_path  = base_path().config('app.project.img_path.product_images');
        $this->product_public_img_path      = url('/').config('app.project.img_path.product_images');
        $this->user_id_proof                = url('/').config('app.project.id_proof');

        $this->arr_view_data                = [];
    
        $this->product_imageurl_path         = url(config('app.project.product_images'));
        $this->product_image_thumb_base_img_path = base_path().config('app.project.img_path.product_imagesthumb');

        $this->module_title                 = "Coupon";
        $this->modyle_url_slug              = "Coupon";
        $this->module_view_folder           = "seller.coupon";
        $this->module_url_path              = url('/')."/seller/coupon";

       
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
         $this->arr_view_data['module_url_path']  = $this->module_url_path;

        return view($this->module_view_folder.'.my_coupons', $this->arr_view_data);
    }

    // FUNCTION TO SHOW RECORDS OF coupon listing

    public function get_records(Request $request)
    {
         
        
        $obj_user     = $this->get_coupon_details($request);
        $current_context = $this;
        $json_result     = Datatables::of($obj_user);
        $json_result     = $json_result->blacklist(['id']);        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                             ->editColumn('code',function($data) use ($current_context)
                            { 
                                 $code =  $data->code;
                                 return $code;
                                 
                            })  
                             ->editColumn('type',function($data) use ($current_context)
                            { 
                              if(isset($data->type) && $data->type==1)
                              {
                                $type = 'Multiple Times';
                              }else{
                                 $type = 'One Time';
                              }
                                
                               return $type;
                                 
                            })  
                            ->editColumn('discount',function($data) use ($current_context)
                            { 
                               if ($data->discount != "NULL" && $data->discount!="") {
                                    return $data->discount." %";
                                } else {
                                    return "N/A";
                                }


                                                                
                            })  
                             ->editColumn('start_date',function($data) use ($current_context)
                            {   
                                  if(isset($data->start_date) && $data->start_date=='0000-00-00')
                                  {
                                    $start_date ='NA';
                                  }
                                  else{
                                    $start_date =  $data->start_date;
                                  }
                                 return $start_date;
                                 
                            })  
                             ->editColumn('end_date',function($data) use ($current_context)
                            { 
                                 if(isset($data->end_date) && $data->end_date=='0000-00-00')
                                  {
                                    $end_date ='NA';
                                  }
                                  else{
                                    $end_date =  $data->end_date;
                                  }
                                 return $end_date;
                                 
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


                            ->editColumn('build_coupon_availability_btn',function($data) use ($current_context)
                            {

                                $build_coupon_availability_btn ='';


                                if($data->coupon_availability_status == 0)
                                {   

                                    $build_coupon_availability_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch1" data-type="coupon_public" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->coupon_availability_status == 1)
                                {
                                   
                                    $build_coupon_availability_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch1" data-type="coupon_private" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_coupon_availability_btn;
                            }) 


                            

                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                /*view*/
                                $view_href =  url('/').'/seller/coupon/view/'.base64_encode($data->id);

                                $build_view_action = '<a href="'.$view_href.'" class="eye-actn" title="View Coupon">
                                View
                                </a>';


                                /*edit*/
                                $edit_href =  url('/').'/seller/coupon/edit/'.base64_encode($data->id);

                                // $build_edit_action = '<a class="delete-slrs btn-edit" href="'.$edit_href.'" title="Edit">Edit</a>';
                                $build_edit_action = '<a href="'.$edit_href.'" class="eye-actn" title="Edit Coupon"> Edit
                                </a>';


                                
                                /*delete*/
                                $delete_href =  url('/').'/seller/coupon/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';

                                // $build_delete_action = '<a class="delete-slrs btn-delete" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                                $build_delete_action = '<a class="eye-actn btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                                

                                return $build_action = $build_view_action.' '.$build_edit_action;
                                // return $build_action = $build_edit_action.' '.$build_delete_action;
                            })
                        
                            ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
    }


    public function get_coupon_details(Request $request)
    {
      

        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;
        }
 

        $coupon_details      = $this->CouponModel->getTable();
        $prefix_coupon_detail  = DB::getTablePrefix().$this->CouponModel->getTable();

       
       
        $obj_product = DB::table($coupon_details)->select(DB::raw($coupon_details.'.*'
                      ))
                          
                            ->where($coupon_details.'.user_id',$seller_id)
                            ->orderBy($coupon_details.'.id','asc');  
                           // ->get();  

                            /******************** search conditions logic here ***************/

                           $arr_search_column = $request->input('column_filter');

                         if(isset($arr_search_column['q_code']) && $arr_search_column['q_code'] != '')
                          {
                              $search_name_term  = $arr_search_column['q_code'];
                              $obj_product  = $obj_product->where('code','LIKE', '%'.$search_name_term.'%');

                          }

                          if(isset($arr_search_column['q_discount']) && $arr_search_column['q_discount'] != '')
                          {
                              $search_discount_term  = $arr_search_column['q_discount'];
                              $obj_product  = $obj_product->where('discount','LIKE', '%'.$search_discount_term.'%');

                          }
                          if(isset($arr_search_column['q_type']) && $arr_search_column['q_type'] != '')
                          {
                              $search_type_term  = $arr_search_column['q_type'];

                              if($search_type_term=='-1'){
                                
                              }else{

                              $obj_product  = $obj_product->where('type','LIKE', '%'.$search_type_term.'%');
                             }

                          }
                        

                          if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
                          {
                              $search_active  = $arr_search_column['q_status'];

                              if($search_active=='-1'){
                                
                              }else{
                                 $obj_product  = $obj_product->where($prefix_coupon_detail.'.is_active','LIKE', '%'.$search_active.'%');
                              }

                          }



                          if(isset($arr_search_column['q_availability_status']) && $arr_search_column['q_availability_status'] != '')
                          {
                              $search_active  = $arr_search_column['q_availability_status'];

                              if($search_active=='-1'){
                                
                              }else{
                                 $obj_product  = $obj_product->where($prefix_coupon_detail.'.coupon_availability_status','LIKE', '%'.$search_active.'%');
                              }

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

        

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable(); 

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();

       
        return view($this->module_view_folder.'.add',$this->arr_view_data);
    }
   

   public function save(Request $request)
    {
        
        $user = Sentinel::getUser();
        if(!empty($user))
        {
          $seller_id = $user->id;
        }

        $form_data = $request->all();



        $code = isset($form_data['code'])?$form_data['code']:0;

        $type = isset($form_data['type'])?$form_data['type']:'';
        $discount = isset($form_data['discount']) ? $form_data['discount'] : '';

        if(isset($form_data['is_active']))
        {
          $is_active = $form_data['is_active'];
        }

        $form_data['user_id'] = $seller_id;
        $form_data['is_active'] = $is_active;

        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }


        $arr_rules = [];

        $arr_rules =    [
                          
                           'code' => 'required',
                           'type'  => 'required',
                           'discount'  => 'required'
                         
                        ];

        

         $validator = Validator::make($request->all(),$arr_rules);

         if($validator->fails())
         { 
            $description = Validator::make($request->all(),$arr_rules)->errors()->first();

            $response['status']      = 'warning';
            $response['description'] = $description;
           
            return response()->json($response);
         }

        

     
        if($is_update_process==false){
           $check_coupon_code = $this->CouponModel
                                        ->where('code',$form_data['code'])
                                        ->first();
        }else{
           $check_coupon_code = $this->CouponModel
                                        ->where('code',$form_data['code'])
                                        ->where('id','!=',$form_data['id'])
                                        ->first();
        }
       
        // dd($check_product_title);
        if($check_coupon_code)
        {   

          $response['status']      = "error";
          $response['description'] = "The coupon code with the same name already exists, please use the different name";
          return response()->json($response);
        
        }

            $couponlist = $this->CouponModel->firstOrNew(['id' => $id]);
            $couponlist->code   =  isset($form_data['code'])?$form_data['code']:'';    
            $couponlist->type   =  isset($form_data['type'])?$form_data['type']:'';    
            $couponlist->discount   =  isset($form_data['discount'])?$form_data['discount']:'';    
            

            $couponlist->is_active   =  isset($form_data['is_active'])?$form_data['is_active']:''; 

            if(isset($type) && $type==0)
            {
             $couponlist->start_date   = '';
             $couponlist->end_date   = '';
            }
            else{
                $couponlist->start_date   =  isset($form_data['start_date'])? date("Y-m-d",strtotime($form_data['start_date'])):''; 
                $couponlist->end_date   =  isset($form_data['end_date'])? date("Y-m-d",strtotime($form_data['end_date'])):''; 
            }

            $couponlist->user_id   = $seller_id;




            $couponlist->save(); 
            if($couponlist)
            {
      
              if($is_update_process==true)
              {
                $response['status']      =  "success";
                $response['description'] =  "Coupon code updated successfully."; 
                $response['link']        =  url('/').'/seller/coupon';
              }
              else
              {
                $response['status']      =  "success";
                $response['description'] =  "Coupon code added successfully.";
                $response['link']        =  url('/').'/seller/coupon'; 
              }
            }
            else
            {
                $response['status']      = "error";
                $response['description'] = "Error occurred while adding coupon.";
            }
          
        return response()->json($response);
    }     

     public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->CouponModel->where('id', $id)->first();
    
        $arr_coupon = [];
        if($obj_data)
        {
           $arr_coupon = $obj_data->toArray(); 
        }
       
      
       

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();
        $res_age_Restriction = $this->AgeRestrictionModel->select('id','age')->get()->toArray(); 

   
        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
       // $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['arr_coupon']              = isset($arr_coupon) ? $arr_coupon : [];  
        $this->arr_view_data['page_title']               = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']             = $this->module_title;
        
 
      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

   
 

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
        $entity = $this->CouponModel->where('id',$id)->first();
        $user = Sentinel::check();      
        $arr = [];  
        
        if($entity)
        {


           $get_coupon = $this->CouponModel->where('id',$id)->get()->toArray();


           if(!empty($get_coupon))
           {

              $updated =  $this->CouponModel->where('id',$id)->update(['is_active'=>'1']);

                if($updated)
                {
                  $arr['status'] = 'SUCCESS';
                   $arr['msg'] = '';
                  return $arr;
                }

           }//if not empty product  
           
        }//if entity

       // return FALSE;
        return $arr;
    }

 
    public function perform_deactivate($id)
    {

        $entity = $this->CouponModel->where('id',$id)->first();
        if($entity)
        {
            return $this->CouponModel->where('id',$id)->update(['is_active'=>'0']);
        }
        return FALSE;
    }

    
    public function coupon_private(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_private(base64_decode($enc_id)))
        {
            $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'PRIVATE';

        return response()->json($arr_response);
    } 


    public function coupon_public(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        $arr = $this->perform_public(base64_decode($enc_id));
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

        $arr_response['data'] = 'PUBLIC';
        return response()->json($arr_response);
    }  


    public function perform_public($id)
    {
        $entity = $this->CouponModel->where('id',$id)->first();
        $user = Sentinel::check(); 


        $arr = $coupon_arr = [];  
        $public_coupon_count = 0;

        
        if($entity)
        {
            $get_coupon = $this->CouponModel->where('id',$id)->get()->toArray();

            if(!empty($get_coupon))
            {

              //check how many coupons are public

              $coupon_arr = get_coupon_details($user->id);
              $public_coupon_count = count($coupon_arr);

              if($public_coupon_count >= 3)
              {  
                  $arr['status'] = 'ERROR';
                  $arr['msg']    = 'You cannot make more than 3 coupons public at the same time';
                  return $arr;
              }
                
                $updated =  $this->CouponModel->where('id',$id)->update(['coupon_availability_status'=>1]);

                if($updated)
                {
                    //send email to admin
                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();

                    if($admin_obj)
                    {
                        $admin_details = Sentinel::findById($admin_obj->user_id); 
                        $admin_name = $admin_details->first_name.' '.$admin_details->last_name;        
                    }

                    $from_user = Sentinel::findById($user->id);
                    $f_name    = isset($from_user->first_name)?$from_user->first_name:'';
                    $l_name    = isset($from_user->last_name)?$from_user->last_name:'';

                    $setsellername ='';
                    if(isset($f_name) || isset($l_name))
                    {
                        $setsellername = $f_name.' '.$l_name;
                    }
                    else{
                        $setsellername = $from_user->email;
                    }

                   
                    $status = '';

                    $arr_built_content =  [  'ADMIN_NAME'     => $admin_name,
                                             'APP_NAME'       => config('app.project.name'),
                                             'SELLER_NAME'    => $setsellername,
                                             'COUPON_CODE'    => $get_coupon[0]['code'],
                                             'STATUS'         => 'Public'
                                           
                                          ];

                        $arr_mail_data['email_template_id'] = '154';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($admin_obj->user_id);


                        $this->EmailService->send_mail_section($arr_mail_data);


                   $arr['status'] = 'SUCCESS';
                   $arr['msg'] = '';
                  return $arr;
                }

             

            }//if not empty product  
           
        }//if entity

       // return FALSE;
        return $arr;
    }

    public function perform_private($id)
    {
        $entity = $this->CouponModel->where('id',$id)->first();

        $user = Sentinel::check();      
        $arr = []; 

        if($entity)
        {
            $get_coupon = $this->CouponModel->where('id',$id)->get()->toArray();

            if(!empty($get_coupon))
            {

                  $status = $this->CouponModel->where('id',$id)->update(['coupon_availability_status'=>0]);

                  if($status == 1)
                  {
                        //send email to the admin

                        $status = $setsellername = '';       

                        $admin_role = Sentinel::findRoleBySlug('admin');        
                        $admin_obj  = \DB::table('role_users')->where('role_id',$admin_role->id)->first();

                        if($admin_obj)
                        {
                            $admin_details = Sentinel::findById($admin_obj->user_id); 
                            $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;        
                        }

                        $from_user = Sentinel::findById($user->id);
                        $f_name    = isset($from_user->first_name)?$from_user->first_name:'';
                        $l_name    = isset($from_user->last_name)?$from_user->last_name:'';

                        
                        if(isset($f_name) || isset($l_name))
                        {
                            $setsellername = $f_name.' '.$l_name;
                        }
                        else{
                            $setsellername = $from_user->email;
                        }
            
                       
                        $arr_built_content =  [   'ADMIN_NAME'     => $admin_name,
                                                  'APP_NAME'       => config('app.project.name'),
                                                  'SELLER_NAME'    => $setsellername,
                                                  'COUPON_CODE'    => $get_coupon[0]['code'],
                                                  'STATUS'         => 'Private'
                                              ];

                        $arr_mail_data['email_template_id'] = '154';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($admin_obj->user_id);


                        $this->EmailService->send_mail_section($arr_mail_data);
                    
                        return TRUE;
                  }

          }  
           
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
        $entity          = $this->CouponModel->where('id',$id)->first();
    
        if($entity)
        {

           $this->CouponModel->where('id',$id)->delete();
           Flash::success(str_plural($this->module_title).' Deleted Successfully');
           return true; 
        }
        else
        {
          Flash::error('Problem Occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }



    public function view($couponid)
    {
       $couponid = base64_decode($couponid);

        $this->arr['arr_data'] = array();
        $arr_coupon_data    = $this->CouponModel->where('id',$couponid)->first();
        if(isset($arr_coupon_data) && !empty($arr_coupon_data))
        {
          $arr_coupon_data = $arr_coupon_data->toArray();
        }

        $this->arr_view_data['page_title']      = "Coupon Details";
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['arr_coupon_data'] = isset($arr_coupon_data)?$arr_coupon_data:[];  

       
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

}
