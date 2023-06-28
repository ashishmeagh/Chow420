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
use App\Models\SellerModel; 
use App\Models\BuyerModel;
use App\Models\RoleUserModel;
use App\Models\GeneralSettingsModel;
use App\Models\ShippingAddressModel;
use App\Models\ProductModel; 
use App\Common\Services\GeneralService;
use App\Models\StatesModel;
use App\Models\ActivationsModel;
use App\Models\UserSubscriptionsModel;
use App\Models\MembershipModel;
use App\Models\EventModel;
use App\Models\SellerDocumentsModel;

use App\Common\Services\UserService;
use App\Common\Services\EmailService;
use Flash;
use Validator;
use Sentinel;
use Activation; 
use Reminder;
use DB;
use Datatables; 

class SellerController extends Controller
{
    use MultiActionTrait;

    public function __construct(UserModel $user,
                                CountriesModel $country,
                                ActivityLogsModel $activity_logs,
                                BuyerModel $buyerModel,
                                SellerModel $sellerModel,
                                RoleUserModel $roleUserModel,
                                EmailService $EmailService,
                                GeneralSettingsModel $GeneralSettingsModel,
                                GeneralService $GeneralService,                            
                                ShippingAddressModel $ShippingAddressModel,
                                StatesModel $StatesModel,
                                ActivationsModel $ActivationsModel,
                                UserSubscriptionsModel $UserSubscriptionsModel,
                                MembershipModel $MembershipModel,
                                EventModel $EventModel,
                                SellerDocumentsModel $SellerDocumentsModel,
                                UserService $UserService
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
        $this->GeneralService               = $GeneralService;
       
        $this->ShippingAddressModel         = $ShippingAddressModel;
        //$this->TradeModel                   = $TradeModel;
        $this->StatesModel                  = $StatesModel;
        $this->ActivationsModel             = $ActivationsModel;
        $this->UserSubscriptionsModel       = $UserSubscriptionsModel;
        $this->MembershipModel              = $MembershipModel;
        $this->EventModel                   = $EventModel;
        $this->SellerDocumentsModel         = $SellerDocumentsModel; 
        $this->UserService                  = $UserService;
 

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->user_id_proof                = url('/').config('app.project.img_path.id_proof');
        $this->seller_id_proof              = url('/').config('app.project.img_path.seller_id_proof');
        $this->seller_id_proof_base_path    = base_path().config('app.project.img_path.seller_id_proof');
        $this->seller_document              = url('/').config('app.project.img_path.seller_documents');
        $this->seller_document_base_path    = base_path().config('app.project.img_path.seller_documents');


        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/sellers");
        $this->module_title                 = "Dispensaries";
        $this->modyle_url_slug              = "Dispensaries";
        $this->module_view_folder           = "admin.users.seller";
        $this->id_proof_base_path   = base_path().config('app.project.img_path.id_proof');
        $this->admin_url_path       = url(config('app.project.admin_panel_slug'));

        
    }   

    public function index() 
    {
        $this->arr_view_data['arr_data'] = array();
        $obj_data = $this->BaseModel->whereHas('roles',function($query)
                                        {
                                            $query->where('slug','=','buyer');        
                                        })
                                    //->with(['user'])
                                    ->get();

        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }   

        $res_membership = $this->MembershipModel->select('name')
                                       // ->where('is_active','1')
                                        ->get();
        if(isset($res_membership) && (!empty($res_membership)))
        {
           // $res_membership = $res_membership->toArray();
            $res_membership = $res_membership->toArray();
             $singleArray = array();
              foreach ($res_membership as $key => $value){
                    $singleArray[$key] = $value['name'];
                }

        }

        $this->arr_view_data['page_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['seller_id_proof'] = $this->seller_id_proof;
        $this->arr_view_data['seller_document'] = $this->seller_document;
        $this->arr_view_data['arr_membership']  = isset($singleArray)?$singleArray:[];

        

        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }

    function get_users_details(Request $request)
    {
        $user_details           = $this->BaseModel->getTable();
        
        $prefixed_user_details  = DB::getTablePrefix().$this->BaseModel->getTable();

        $buyer_details           = $this->BuyerModel->getTable();        
        $prefixed_buyer_details  = DB::getTablePrefix().$this->BuyerModel->getTable();

        $seller_details           = $this->SellerModel->getTable();        
        $prefixed_seller_details  = DB::getTablePrefix().$this->SellerModel->getTable();

        $country_details = $this->CountriesModel->getTable();
        $prefixed_country_details  = DB::getTablePrefix().$this->CountriesModel->getTable();


        $state_details = $this->StatesModel->getTable();
        $prefix_state_details =  DB::getTablePrefix().$this->StatesModel->getTable();

        $activation_details = $this->ActivationsModel->getTable();
        $prefix_activation_details =  DB::getTablePrefix().$this->ActivationsModel->getTable();

        $subscription_details = $this->UserSubscriptionsModel->getTable();
        $prefix_subscription_details =  DB::getTablePrefix().$this->UserSubscriptionsModel->getTable();
       

        $membership_details = $this->MembershipModel->getTable();
        $prefix_membership_details =  DB::getTablePrefix().$this->MembershipModel->getTable();

        $document_details = $this->SellerDocumentsModel->getTable();
        $prefix_document_details =  DB::getTablePrefix().$this->SellerDocumentsModel->getTable();



        DB::enableQueryLog();
        $obj_user = DB::table($user_details)
                                ->select(DB::raw($prefixed_user_details.".id as id,".
                                  $prefixed_user_details.".is_featured as is_featured,".
                                                 $prefixed_user_details.".email as email, ".
                                                  $prefixed_user_details.".phone as phone, ".
                                                   $prefixed_user_details.".street_address as street_address, ".
                                                //  $prefixed_user_details.".country as country, ".
                                                  $prefixed_user_details.".first_name as first_name, ".
                                                  $prefixed_user_details.".last_name as last_name, ".
                                                  $prefixed_user_details.".zipcode as zipcode, ".
                                                  $prefixed_user_details.".city as city, ".
                                                  $prefixed_user_details.".state as state_id, ".
                                                  $prefixed_user_details.".approve_status as approve_status, ".
                                                  $prefixed_country_details.'.name as country,'.
                                                  $prefix_state_details.'.name as state,'.

                                                 $prefixed_user_details.".is_active as is_active, ".
                                                 $prefixed_user_details.".user_type, ".
                                                  $prefixed_seller_details.".business_name as business_name, ".
                                                 $prefixed_seller_details.".front_image as front_image, ".
                                                 $prefixed_seller_details.".back_image as back_image, ".
                                                 $prefixed_seller_details.".selfie_image as selfie_image, ".

                                                 $prefixed_seller_details.".address_proof as address_proof, ".

                                                  $prefixed_seller_details.".age_address as age_address, ".

                                                  $prefixed_seller_details.".approve_status as business_approve_status, ".

                                                   $prefixed_seller_details.".documents_verification_status as documents_verification_status, ".

                                                  $prefixed_seller_details.".sorting_order_by as sorting_order_by, ".

                                                 $prefixed_seller_details.".approve_verification_status as approve_verification_status, ".
                                                   $prefixed_seller_details.".note as note, ".
                                                 
                                                 $prefixed_seller_details.".user_id as seller_user_id, ".
                                                //$prefixed_user_details.".user_name as user_name, ".
                                                 $prefixed_user_details.".is_trusted,".
                                                 $prefixed_user_details.".activationcode as activationcode, ".
                                                $prefix_activation_details.".completed,".
                                                $prefix_activation_details.".code,".
                                                $prefix_document_details.".document,".
                                                $prefix_document_details.".document_title,".
                                                $prefix_document_details.".seller_id,".

                                                 "CONCAT(".$prefixed_user_details.".first_name,' ',"
                                                    .$prefixed_user_details.".last_name) as user_name,".

                                                    $prefix_subscription_details.'.membership_id'

                                                 // "(SELECT AVG(internal_rating.points) 
                                                 //    FROM ".$rating_tbl." as internal_rating
                                                 //    INNER JOIN ".$user_details." as internal_user_details
                                                 //       ON internal_rating.seller_user_id = internal_user_details.id WHERE internal_rating.type='1') as avarage_rating"))
                                             ))  

                                ->leftjoin($prefix_subscription_details,$prefix_subscription_details.'.user_id','=',$prefixed_user_details.'.id')
                               // ->leftjoin($prefix_subscription_details,$prefix_subscription_details.'.membership_id','=',$prefix_membership_details.'.id')
                                ->leftjoin($prefixed_seller_details,$prefixed_seller_details.'.user_id','=',$prefixed_user_details.'.id')
                                // ->leftjoin($rating_tbl,$prefixed_rating_tbl.'.seller_user_id','=',$prefixed_user_details.'.id')

                                ->leftjoin($prefixed_country_details,$prefixed_country_details.'.id','=',$prefixed_user_details.'.country')

                                 ->leftjoin($prefix_state_details,$prefix_state_details.'.id','=',$prefixed_user_details.'.state')

                                 ->leftjoin($prefix_activation_details,$prefix_activation_details.'.user_id','=',$prefixed_user_details.'.id')

                                ->leftjoin($prefix_document_details,$prefix_document_details.'.seller_id','=',$prefixed_user_details.'.id')

                                ->whereNull($user_details.'.deleted_at')
                                ->where($user_details.'.user_type','=','seller')
                                 // ->where($prefix_subscription_details.'.membership_status','=','1')
                                //->orderBy($prefix_subscription_details.'.id','DESC')
                                ->orderBy($prefixed_seller_details.'.sorting_order_by','DESC')
                              /*  ->orderBy($user_details.'.id','DESC')*/
                                ->groupBy($user_details.'.id');

                                // ->get(); 

        // dd($obj_user);
           

            // dd($avg);
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
        {
            $search_term      = $arr_search_column['q_name'];
            $obj_user = $obj_user->where('first_name','LIKE', '%'.$search_term.'%')
                                 ->orWhere('last_name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_term      = $arr_search_column['q_email'];
            $obj_user = $obj_user->where($user_details.'.email','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_user_type']) && $arr_search_column['q_user_type']!="")
        {
           $search_term       = $arr_search_column['q_user_type'];
            $obj_user   = $obj_user->where($prefixed_user_details.'.user_type','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status']!="")
        {
           $search_term       = $arr_search_column['q_status'];
            $obj_user   = $obj_user->where($prefixed_user_details.'.is_active','LIKE', '%'.$search_term.'%');
        }
         if(isset($arr_search_column['q_vstatus']) && $arr_search_column['q_vstatus']!="")
        {
           $search_term       = $arr_search_column['q_vstatus'];
            $obj_user   = $obj_user->where($prefixed_user_details.'.is_trusted','LIKE', '%'.$search_term.'%');
        }


         if(isset($arr_search_column['q_email_verification_status']) && $arr_search_column['q_email_verification_status']!="")
        {
            $search_term = $arr_search_column['q_email_verification_status'];

            if($search_term == '1')
            {
                $obj_user  = $obj_user->where($prefix_activation_details.'.completed','=',1);
            }
            else if($search_term == '0')
            {
                $obj_user  = $obj_user->where($prefix_activation_details.'.completed','=',NULL)
                                      ->orWhere($prefix_activation_details.'.completed','=',0);
            }
        }
       

        if(isset($arr_search_column['q_id_verification_status']) && $arr_search_column['q_id_verification_status']!="")
        {
            $search_term = $arr_search_column['q_id_verification_status'];
            $obj_user    = $obj_user->where($prefixed_seller_details.'.approve_verification_status','LIKE', '%'.$search_term.'%');
        }

         if(isset($arr_search_column['q_profile_verification_status']) && $arr_search_column['q_profile_verification_status']!="")
        {
            $search_verify = $arr_search_column['q_profile_verification_status'];
            $obj_user    = $obj_user->where($prefixed_user_details.'.approve_status','LIKE', '%'.$search_verify.'%');
        }

         if(isset($arr_search_column['q_business_verification_status']) && $arr_search_column['q_business_verification_status']!="")
        {
            $search_business = $arr_search_column['q_business_verification_status'];
            $obj_user    = $obj_user->where($prefixed_seller_details.'.approve_status','LIKE', '%'.$search_business.'%');
        }

        if(isset($arr_search_column['q_documents_verification_status']) && $arr_search_column['q_documents_verification_status']!="")
        {
            $search_document = $arr_search_column['q_documents_verification_status'];
            $obj_user    = $obj_user->where($prefixed_seller_details.'.documents_verification_status','LIKE', '%'.$search_document.'%');
        }

          if(isset($arr_search_column['q_planname']) && $arr_search_column['q_planname']!="")
        {
            $search_planname = $arr_search_column['q_planname'];
            $get_membershipid = $this->MembershipModel->where('name',$search_planname)
                                                       // ->where('is_active','1')
                                                        ->first();
            if(isset($get_membershipid) && (!empty($get_membershipid)))
            {
               $get_membershipid = $get_membershipid->toArray();
               $membership_id = $get_membershipid['id']; 
                $obj_user    = $obj_user->where($prefix_subscription_details.'.membership_id','LIKE', '%'.$membership_id.'%');

            }
        }
         if(isset($arr_search_column['q_featured']) && $arr_search_column['q_featured']!="")
        {
           $search_featterm       = $arr_search_column['q_featured'];
            $obj_user   = $obj_user->where($prefixed_user_details.'.is_featured','LIKE', '%'.$search_featterm.'%');
        }

         if(isset($arr_search_column['q_business_name']) && $arr_search_column['q_business_name']!="")
        {
            $search_term_business      = $arr_search_column['q_business_name'];
            $obj_user = $obj_user->where('business_name','LIKE', '%'.$search_term_business.'%');
        }
        
        

        return $obj_user;
    }
 
    public function get_records(Request $request)
    {
        $obj_user     = $this->get_users_details($request);

        $current_context = $this;

        $json_result     = Datatables::of($obj_user);

        $json_result     = $json_result->blacklist(['id']);
        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                            ->editColumn('user_name',function($data) use ($current_context)
                            {
                                
                                if(strlen($data->user_name)=='1')
                                {
                                 return 'NA';   
                                }
                                elseif(isset($data->user_name) && !empty($data->user_name))
                                {
                                    return $data->user_name;
                                } 
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

                            ->editColumn('build_status_btn',function($data) use ($current_context)
                            {
                                $build_status_btn ='';
                                if($data->is_active != null && $data->is_active == '0')
                                {   
                                    $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->is_active != null && $data->is_active == '1')
                                {
                                    $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_status_btn;
                            }) 


                            ->editColumn('build_doc_status_btn',function($data) use ($current_context)
                            {
                                $build_doc_status_btn ='';
                                if($data->documents_verification_status != null && $data->documents_verification_status == '0')
                                {   
                                    $build_doc_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->documents_verification_status != null && $data->documents_verification_status == '1')
                                {
                                    $build_doc_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_doc_status_btn;
                            })       
                            ->editColumn('build_featured_btn',function($data) use ($current_context)
                            {
                                 $build_featured_btn = "";
                                if($data->is_featured == '0')
                                {
                                   $build_featured_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitchFeatured" data-type="featured" data-color="#99d683" data-secondary-color="#f96262" />';

                                }
                                else if($data->is_featured == '1')
                                {
                                    $build_featured_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitchFeatured" data-type="unfeatured" data-color="#99d683" data-secondary-color="#f96262"/>';
                                }

                                return $build_featured_btn;
                            })     
 
 
                              ->editColumn('build_subscriptionbtn',function($data) use ($current_context)
                            {
                                $build_subscriptionbtn ='NA';

                                $get_subscription = $this->UserSubscriptionsModel
                                       
                                       // ->where('membership_status','1')
                                       // ->where([['membership_status','1'],['is_cancel','0']])
                                      //  ->orwhere([['membership_status','0'],['is_cancel','1']])                
                                         ->where('user_id',$data->id)               
                                        ->orderBy('id','desc')
                                        ->get();
                                if(isset($get_subscription) && !empty($get_subscription)){
                                    $get_subscription = $get_subscription->toArray();
                                    if(isset($get_subscription) && !empty($get_subscription)){
                                     
                                    $membership_id = $get_subscription[0]['membership_id'];        


                                    $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();
                                    if(!empty($get_panname)){
                                        $get_panname = $get_panname->toArray();
                                        $plan_name = $get_panname['name'];

                                            $set_amount =0;    

                                            if($get_subscription[0]['membership_amount']>0){
                                                
                                              // $set_amount =  rtrim(rtrim(strval($get_subscription[0]['membership_amount']), "0"), ".");

                                               $set_amount =number_format($get_subscription[0]['membership_amount']);
                                            }else{
                                               $set_amount =number_format($get_subscription[0]['membership_amount']);
                                            }




                                       $build_subscriptionbtn = '<a class="btn btn-sm btn-primary planmodel" data-toggle="modal" data-target="#exampleModal" 
                                       membership = "'.$get_subscription[0]['membership'].'"  
                                    membership = "'.$get_subscription[0]['membership'].'"  
                                       startdate = "'.date("M d Y H:i",strtotime($get_subscription[0]['created_at'])).'" 
                                       transaction_id = "'.$get_subscription[0]['transaction_id'].'" 
                                        payment_status = "'.$get_subscription[0]['payment_status'].'" 
                                       amount = "'.$set_amount.'"
                                       planname = "'.$plan_name.'"
                                        is_cancel = "'.$get_subscription[0]['is_cancel'].'"
                                         >View Membership</a>';
                               
                                       // return $build_subscriptionbtn;
                                    }
                                 }// if subscription   
                               }// if subscription 
                               return $build_subscriptionbtn;
                                   
                            })    

                            ->editColumn('membership_plan',function($data) use ($current_context)
                            {   
                                $membership_plan = 'NA';
                               // if(isset($data->membership_id)){
                               //  $planname = $this->MembershipModel->where('id',$data->membership_id)->first();
                               //  if(isset($planname) && !empty($planname))
                               //  {
                               //     $planname = $planname->toArray();
                               //     $membership_plan = $planname['name'];  
                               //  }

                               // }else{
                               //   $membership_plan = 'NA';
                               // } 

                                 $get_subscription = $this->UserSubscriptionsModel
                               // ->where([['membership_status','1'],['is_cancel','0']])
                               // ->orwhere([['membership_status','0'],['is_cancel','1']])
                                ->where('user_id',$data->id)

                                ->orderBy('id','desc')
                                ->get();
                                if(isset($get_subscription) && !empty($get_subscription)){
                                    $get_subscription = $get_subscription->toArray();
                                    if(isset($get_subscription) && !empty($get_subscription))
                                    {
                                     
                                      $membership_id = $get_subscription[0]['membership_id'];        


                                      $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();
                                      if(!empty($get_panname)){
                                          $get_panname = $get_panname->toArray();
                                          $plan_name = $get_panname['name'];
                                          $membership_plan = $plan_name;  
                                    }//if planname
                                 }// if subscription   
                               }// if subscription 


                               return $membership_plan;
                              
                            }) 

                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                                // $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);

                                // $confirm_delete = 'onclick="confirm_delete(this,event);"';
                                
                                // $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';

                                $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                                $build_view_action = '<a class="eye-actn" href="'.$view_href.'" title="View">View</a>';

 
                         
                             /*$confirm_approve_business='onclick="confirm_approve_business($(this))"';

                             $build_business_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip approve_business" '.$confirm_approve_business.'  
                                 data-enc_id="'.base64_encode($data->id).'" title="Approve business details"><i class="ti-receipt" style="color:#31b0d5"></i></a>';  */
                             $build_business_action = '<a class="eye-actn show-tooltip approve_business"   
                                 data-enc_id="'.base64_encode($data->id).'" title="Approve business details" style="color:#31b0d5" >Business details</a>';       

                               
                            $build_age_verify_action ='';
                            $build_age_verify_action = '<a class="btns-approved view_age_section" front_image="'.$data->front_image.'" user_id="'.$data->seller_user_id.'" back_image="'.$data->back_image.'"  selfie_image="'.$data->selfie_image.'"   age_address="'.$data->age_address.'" address_proof="'.$data->address_proof.'"    approve_verification_status="'.$data->approve_verification_status.'" note="'.$data->note.'" 

                              country="'.$data->country.'" state="'.$data->state.'"   street_address="'.$data->street_address.'"  zipcode="'.$data->zipcode.'"  city="'.$data->city.'" 
                             title="View ID Proof Details" >ID Proof Details</a>';     


                             $build_profile_verify_action ='';
                             $build_profile_verify_action = '<a class="btn btn-outline btn-info view_profile_section eye-actn" first_name="'.$data->first_name.'" user_id="'.$data->seller_user_id.'" last_name="'.$data->last_name.'"  email="'.$data->email.'"   phone="'.$data->phone.'"   country="'.$data->country.'" state="'.$data->state.'"   street_address="'.$data->street_address.'"  zipcode="'.$data->zipcode.'"  city="'.$data->city.'"    approve_status="'.$data->approve_status.'"  title="View Profile Verification Details" >Profile Verification Details</a>'; 

                            $build_document_verify_action ='';
                            $is_restricted_state = '';
                            if($data->state_id!="")
                            {  
                                $is_restricted_state = $this->is_state_restricted($data->state_id);
                                if(isset($is_restricted_state) && $is_restricted_state==1)
                                {  
                                  $build_document_verify_action = '<a class="btns-approved view_document_section" seller_id="'.$data->id.'" verification_status="'.$data->documents_verification_status.'" title="View Documents" >View Documents</a>'; 
                                } 
                            }      


                              $view_subscriptions_href =  $this->admin_url_path.'/seller_membership_history/'.base64_encode($data->id);

                              $build_viewmembership_action = '<a class="eye-actn" href="'.$view_subscriptions_href.'" title="View Membership History" target="_blank">Membership History</a>';



                               $build_verifyuser_action ='';

                               if($data->completed=="1"){

                                 }else{
                                   $build_verifyuser_action = '<a class="btn btn-outline btn-info  show-tooltip  verifyuserbtn eye-actn"  user_id="'.$data->seller_user_id.'"  email="'.$data->email.'" completed="'.$data->completed.'"
                                     title="Verify User" >Verify User</a>';    
                                 } 


                                 $build_activationemailresend_action ='';
                                  if($data->completed=="1"){

                                  }else{
                                     $build_activationemailresend_action = '<a class="btn btn-outline btn-info  show-tooltip  resendactivationemail eye-actn"  user_id="'.$data->seller_user_id.'"  email="'.$data->email.'" completed="'.$data->completed.'"  code="'.$data->code.'" activationcode="'.$data->activationcode.'"
                                     title="Resend Verification Email" >Resend Verification Email</a>'; 
                                   }


                                return $build_action = $build_edit_action.' '.$build_view_action.' '.$build_business_action.' '.$build_age_verify_action.' '.$build_profile_verify_action.' '.$build_viewmembership_action.''.$build_verifyuser_action.''.$build_activationemailresend_action.''.$build_document_verify_action;
                            })




                           
                            ->make(true);

        $build_result = $json_result->getData();
         
        return response()->json($build_result);
    }

    public function is_state_restricted($state_id="")
    {
       $is_state_restricted = "";
       if($state_id!="")
       {
         $is_state_restricted = $this->StatesModel->where('id',$state_id)->select('is_documents_required')->first();
         if(!empty($is_state_restricted))
         {
            return $is_state_restricted = $is_state_restricted['is_documents_required'];
         }
       }
    }

    public function create()
    {
       // $countries_arr = $this->CountriesModel->get()->toArray();
       
        $google_api_key_obj = $this->GeneralSettingsModel->where('data_id','GOOGLE_API_KEY')->first();
        if($google_api_key_obj)
        {
            $google_api_key_arr = $google_api_key_obj->toArray();
        }
        $countries_obj = $this->CountriesModel->where('is_active',1)->get();
        if ($countries_obj) {
            $countries_arr = $countries_obj->toArray();

            $this->arr_view_data['countries_arr']  = $countries_arr;
        }
      //  $this->arr_view_data['countries_arr']      = $countries_arr;
        $this->arr_view_data['google_api_key_arr'] = $google_api_key_arr;
        
        $this->arr_view_data['page_title']         = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title']       = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']    = $this->module_url_path;
        
        
        return view($this->module_view_folder.'.create', $this->arr_view_data);
    }

    public function view($enc_user_id =false)
    {
        $address_arr = [];

        $user_id = base64_decode($enc_user_id);

        $user_obj = $this->UserModel->with('seller_detail','get_country_detail','get_state_detail')->where('id',$user_id)->first();

        if($user_obj)
        {
            $user_arr = $user_obj->toArray();
        }

        $address_obj = $this->ShippingAddressModel->with(['country_details'])->where('user_id',$user_id)->first();

        if($address_obj)
        {
           $address_arr = $address_obj->toArray();
        }
 
        $this->arr_view_data['address_arr']                = $address_arr;
        $this->arr_view_data['module_url_path']            = $this->module_url_path;
        $this->arr_view_data['user_arr']                   = $user_arr;
        $this->arr_view_data['page_title']                 = 'Dispensary Details';
        $this->arr_view_data['user_id_proof_public_path']  = $this->user_id_proof;
        $this->arr_view_data['seller_id_proof_public_path']  = $this->seller_id_proof;

        

        return view($this->module_view_folder.'.show', $this->arr_view_data);
    }

    public function get_states(Request $request)
    {
        $arr_states   = [];
        $country_id     = $request->input('country_id');

        $arr_states   = $this->StatesModel->where('country_id', $country_id)->where('is_active',1)
            ->get()
            ->toArray();

        $response['arr_states'] = isset($arr_states) ? $arr_states : [];
        return $response;
    }

     public function get_documents(Request $request)
    {
        $arr_documents  = [];
        $seller_id      = $request->input('seller_id');

        $arr_documents   = $this->SellerDocumentsModel->where('seller_id', $seller_id)
            ->get();
       if(!empty($arr_documents))
       {
          $arr_documents = $arr_documents->toArray();
       }     



        $response['arr_documents'] = isset($arr_documents) ? $arr_documents : [];
        return $response;
    }

    public function edit($enc_id)
    {
        $address_arr = [];

        $id = base64_decode($enc_id);
       
        $obj_user = $this->UserModel->where('id',$id)
                                    ->with(['buyer_detail','seller_detail'])
                                    // ->with(['buyer_detail'])
                                    // ->with('user_addresses')    
                                    ->first();
                                    // ->first(['id','email','user_type','user_name','first_name','last_name','profile_image','country','state','city','street_address','zipcode','phone']);
        $arr_data  = $role_arr = $google_api_key_arr = [];                                            
        if($obj_user)
        {
            $arr_data = $obj_user->toArray();
        }  

        $role_arr = Sentinel::getRoleRepository()->where('slug','seller')
                                            ->get()->toArray();
        // $role_arr = array(
        //             "0" => array (
        //                    "role_slug" => "buyer",
        //                    "role_value" => "Buyer",
                          
        //                 ),
                        
        //             "1" => array (
        //                    "role_slug" => "seller",                                  
        //                    "role_value" => "Seller",                                  
        //                 ),  
                
        //             );
        // $obj_country = $this->CountriesModel->where('is_active','=','1')->get(['id','country_code','country_name']);  
        
        // if($obj_country)
        // {
        //     $arr_country = $obj_country->toArray();                    
        // }  

        $google_api_key_obj = $this->GeneralSettingsModel->where('data_id','GOOGLE_API_KEY')->first();
        if($google_api_key_obj)
        {
            $google_api_key_arr = $google_api_key_obj->toArray();
        }

        $address_obj = $this->ShippingAddressModel->where('user_id',$id)->first();

        if($address_obj)
        {
            $address_arr = $address_obj->toArray();
        }

        $countries_obj = $this->CountriesModel->where('is_active',1)->get();
        if ($countries_obj) {
            $countries_arr = $countries_obj->toArray();

            $this->arr_view_data['countries_arr']         = $countries_arr;
        }

        $states_obj = $this->StatesModel->where('country_id', $arr_data['country'])->where('is_active',1)->get();
        if ($states_obj) {
            $states_arr = $states_obj->toArray();
            $this->arr_view_data['states_arr']         = $states_arr;
        }

        $this->arr_view_data['address_arr']                  = $address_arr;
        $this->arr_view_data['google_api_key_arr']           = $google_api_key_arr;
        $this->arr_view_data['page_title']                   = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title']                 = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']              = $this->module_url_path;
        $this->arr_view_data['arr_data']                     = $arr_data;
        $this->arr_view_data['role_arr']                     = $role_arr;
        //$this->arr_view_data['user_profile_public_img_path'] = $this->user_profile_public_img_path;
        $this->arr_view_data['user_id_proof']                = $this->user_id_proof;
        $this->arr_view_data['seller_id_proof']              = $this->seller_id_proof;

      //  dd($this->arr_view_data);
        return view($this->module_view_folder.'.edit', $this->arr_view_data);
    }

    
    public function save(Request $request)
    { 
        $login_user = Sentinel::check();

        $is_update         = false;
        $current_timestamp = "";
        $user_id = $request->input('user_id');
        if($request->has('user_id'))
        { 
           $is_update = true;
        }
        
        /*Check validations*/
        $arr_rules = [
                        // 'user_role'             => 'required',
                        'first_name'            => 'required',
                        'last_name'             => 'required',
                        'email'                 => 'required|email',
                        'street_address'        => 'required',
                        'business_name'         => 'required',
                        'country'               => 'required',
                        'state'                 => 'required',
                        'city'                  => 'required',
                        'zipcode'               => 'required',
                       // 'mobile_no'             => 'required',

                        'registered_name'       => 'required',
                        'account_no'            => 'required',
                        'routing_no'            => 'required',
                        'switft_no'             => 'required',
                        //'paypal_email'          => 'email'
                     ];  

      /*  if($is_update == false)
        {
            $arr_rules['tax_id']           = 'required';
        }*/

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = "error";
            $response['description'] = "Form validation failed...please check all fields..";
            return response()->json($response);
        }


        $registered_name = $request->registered_name;

          if(!isset($registered_name) || (isset($registered_name) && $registered_name == ''))
        {
          
           $response['status'] = 'error';
           $response['description']    = 'Provided registered name should not be blank or invalid.';          
           return response()->json($response);   
        }  


        /******************start of tax id validation****************************/    
       /*  if(isset($request->tax_id))
        {
           $tax_id = $request->input('tax_id');
           $is_already_exists  = $this->SellerModel->where('tax_id',$tax_id)->where('user_id','!=',$user_id)->get()->toArray();



           if(!empty($is_already_exists))
           {

                 $response['status'] = 'error';
                 $response['description'] = 'tax id already exists';
                 return response()->json($response); 
           }

            if(strlen($request->tax_id)>9 || strlen($request->tax_id)<9)
            {
                $response['status']  = 'error';
                $response['description'] = 'Provided tax id should be 9 characters .';
               return response()->json($response); 
            }


        }*/







        /******************end of taxid validation****************************/

         if(isset($request->business_name))
        {
           $businessname = $request->input('business_name');
           $businessname_already_exists  = $this->SellerModel->where('business_name',$businessname)->where('user_id','!=',$user_id)->get()->toArray();

           if(!empty($businessname_already_exists))
           {

                 $response['status'] = 'error';
                 $response['description'] = 'Business name already exists';
                 return response()->json($response); 
           }
        }
        /************************end of business name validation************/

          /*************chk country***************************/

          $countries_obj = $this->CountriesModel->where('id',$request->country)->first();
          if ($countries_obj) {
              $countries_arr = $countries_obj->toArray();
              if( $countries_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['description'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }

          }//if country obj

           $states_obj = $this->StatesModel->where('id', $request->state)->first();
           if ($states_obj) {
            $states_arr = $states_obj->toArray();
             if( $states_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['description'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }
          }//if state obj



        /*************chk country***************************/


        /* Check for email duplication */
        $is_duplicate = $this->BaseModel->where('email','=',$request->input('email'));  
        
        if($is_update)
        {
            $is_duplicate = $is_duplicate->where('id','<>',$user_id);
        }

        $does_exists = $is_duplicate->count(); 

        if($does_exists)
        {
            $response['status']      = "error";
            $response['description'] = "email id already exists";
            return response()->json($response);
        }   
         
        $user =  Sentinel::createModel()->firstOrNew(['id' => $user_id]);


        $user->first_name = ucfirst($request->input('first_name'));
        $user->last_name  = ucfirst($request->input('last_name'));
        $user->email      = $request->input('email');
        $user->user_type  = 'seller';
        $user->country    = $request->input('country');
        $user->state      = $request->input('state');

        $user->city      = $request->input('city');
        $user->zipcode   = $request->input('zipcode');
       // $user->phone     = $request->input('mobile_no');


        $hasher           = Sentinel::getHasher();
        $data             = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        $password         =  substr(str_shuffle($data), 0, 8);
        $user->street_address = $request->input('street_address');


        $business_name    = $request->input('business_name');
      //  $tax_id           = $request->input('tax_id');
        $registered_name  = $request->input('registered_name');
        $account_no       = $request->input('account_no');
        $routing_no       = $request->input('routing_no');
        $switft_no        = $request->input('switft_no');
        $paypal_email     = $request->input('paypal_email');


        
         if($is_update == false)
        {
            if(isset($password) && !empty($password))
            {
                $user->password  = $hasher->hash($password);
            }

           $user->approve_status  = '1'; // make auto approve user profile

            $user->is_active       = '1';
            $user->is_trusted      = '1';
        } 
     
       
        

          if(isset($request->is_featured) && !empty($request->is_featured))
        {
           $is_featured = $request->is_featured;
        }
        else
        {
           $is_featured = '0';
        }   
        $user->is_featured = $is_featured;
  

        $user_details     = $user->save();
        //return $user_details;

        $email            = $user->email;
        //return $email;
        
        if(isset($password) && !empty($password))
        {
             if($is_update == false)
            {
                $arr_mail_data    = $this->built_mail_data($email,$password);   
                $email_status     = $this->EmailService->send_mail_section($arr_mail_data);
            }
        }
        
        if($is_update == false)
        { 
            /* Activate User By Default */
            $activation = Activation::create($user);    

            if($activation)
            {
               Activation::complete($user,$activation->code);
            }
            
        }

     

        if($user_details)
        {   
            if($is_update == false)
            {
                //attach buyer and seller both role to user
                $role = 'seller';
               // $role_two = 'seller';

                //$arr_buyer['user_id']     = $user_details->id;
                               
                $role_one_obj = Sentinel::findRoleBySlug($role);
                $role_one_obj->users()->attach($user);    

                /*************add event for seller signup*****/
               /*   $arr_eventdata                 = [];
                  $arr_eventdata['user_id']      = $user->id;
                  $arr_eventdata['message']  = '<div class="discription-marq">
                    <div class="mainmarqees-image">
                    <img src="'.url('/').'/assets/front/images/chow.png" alt="">
                             </div>A new user has been registered successfully as a <b>seller</b>.<div class="clearfix"></div></div>';

                  $arr_eventdata['title']        = 'New User Seller Registration';
                  
                  $this->EventModel->create($arr_eventdata);*/

                /************end event seller signup**********/

            }

                        
                    // $seller =  $this->SellerModel->firstOrNew(['user_id' => $user->id,'business_name' => $business_name,'tax_id' => $tax_id, 'id_proof' => $file_name ]);

                    $current_timestamp =  date('Y-m-d H:i:s');


                    //commented below line because of double entry in seller table
                    //$seller =  $this->SellerModel->firstOrNew(['user_id' => $user->id,'sorting_order_by' => $current_timestamp ]);

                    $seller =  $this->SellerModel->firstOrNew(['user_id' => $user->id]);

                    $seller->user_id               = $user->id;
                    $seller->business_name         = $business_name;
                  //  $seller->tax_id                = $tax_id;
                    $seller->registered_name       = $registered_name;
                    $seller->account_no            = $account_no;
                    $seller->routing_no            = $routing_no;
                    $seller->switft_no             = $switft_no;
                    $seller->paypal_email          = isset($paypal_email)?$paypal_email:'';

                     if($is_update == false)
                     {                           
                        $seller->approve_status  = '1'; // make auto approved seller business profile.

                          /*********add event for business profile*********/

                           $businessname = str_replace(' ','-',$business_name);  

                             /*$arr_eventdata             = [];
                             $arr_eventdata['user_id']  = $user->id;
                             $arr_eventdata['message']  = '<div class="discription-marq">
                                  <div class="mainmarqees-image">
                                   <img src="'.url('/').'/assets/front/images/chow.png" alt="">
                                   </div>
                                <b>'.$request->input('business_name').'</b> just joined chow.<div class="clearfix"></div></div><a target="_blank" class="viewcls" href="search?sellers='.$businessname.'">View</a>';

                              $arr_eventdata['title']    = 'Business Name';                        
                              $this->EventModel->create($arr_eventdata);*/


                          /**********end event for business profile********/


                     }else{

                     }
                    $seller->save();

                    if($is_update==false)
                    {
                           $arr_subscription = [];
                           $get_free_subscription = $this->MembershipModel
                                        ->where('membership_type','1')
                                        ->where('is_active','1')
                                        ->first();

                               if(isset($get_free_subscription) && !empty($get_free_subscription))
                               {

                                  $get_free_subscription = $get_free_subscription->toArray();
                                  $membership_id = $get_free_subscription['id'];
                                  $membership_price = $get_free_subscription['price'];
                                  $membership_pcount = $get_free_subscription['product_count'];
                                    $arr_subscription = [];

                                    $arr_subscription['transaction_id'] = '';
                                    $arr_subscription['payment_status'] = '0';
                                    $arr_subscription['user_id']       = $user->id;
                                    $arr_subscription['membership_id'] = $membership_id ;
                                    $arr_subscription['membership'] = '1';
                                    $arr_subscription['membership_amount'] = $membership_price;
                                    $arr_subscription['membership_status'] = '1';
                                     $arr_subscription['product_limit'] = 
                                                 $membership_pcount;
                                    $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);

                               }//if free membership        
                    }

 

                     
            if($is_update==false)
            {

                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                 //save sub admin activity log 

     
                  $seller_name = $user->first_name.' '.$user->last_name;

                  if(isset($login_user) && $login_user->inRole('sub_admin'))
                  {
                      $arr_event                 = [];
                      $arr_event['action']       = 'ADD';
                      $arr_event['title']        = $this->module_title;
                      $arr_event['user_id']      = isset($login_user->id)?$login_user->id:'';
                      $arr_event['message']      = $login_user->first_name.' '.$login_user->last_name.' has added dispensary '.$seller_name.'.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }

                /*----------------------------------------------------------------------*/

                 $response['link']        = $this->module_url_path;
                 $response['status']      = "success";
                 $response['description'] = "Dispensary added successfully."; 

            }
            else{

               /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                 //save sub admin activity log 

     
                  $seller_name = $user->first_name.' '.$user->last_name;

                  if(isset($login_user) && $login_user->inRole('sub_admin'))
                  {
                      $arr_event                 = [];
                      $arr_event['action']       = 'EDIT';
                      $arr_event['title']        = $this->module_title;
                      $arr_event['user_id']      = isset($login_user->id)?$login_user->id:'';
                      $arr_event['message']      = $login_user->first_name.' '.$login_user->last_name.' has updated dispensary '.$seller_name.'.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }

                /*----------------------------------------------------------------------*/

               $response['link']        = $this->module_url_path.'/edit/'.base64_encode($user->id);
               $response['status']      = "success";
               $response['description'] = "Dispensary updated successfully."; 
            }    

           
        }
        else
        {
            // Flash::error('Problem Occured While Creating '.str_singular($this->module_title));
            $response['status']      = "error";
            $response['description'] = "Error occurred while save user.";
        }   
        // return redirect()->back();
         return response()->json($response);
    }

    public function activate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_activate(base64_decode($enc_id)))
        {
             $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
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
            Flash::error('Problem occured while '.str_singular($this->module_title).' deletion ');
        }

        return redirect()->back();
    }

     /*
    | multi_action() : mutiple actions like active/deactive/delete for multiple slected records
    | auther : Paras Kale 
    | Date : 01-02-2016    
    | @param  \Illuminate\Http\Request  $request
    */
    public function multi_action(Request $request)
    {   
        $user = Sentinel::check(); 

        $flag = "";

        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('Please Select '.str_plural($this->module_title) .' to perform multi actions');  
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','problem occured, while doing multi action');
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
              
               $flag = "deactive";

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on dispensaries.';

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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on dispensaries.';

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
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on dispensaries.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }
                /*----------------------------------------------------------------------*/
        }

        return redirect()->back();
    }

    public function perform_activate($id,$flag=false)
    {   
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();
        

        if($entity)
        {   
            $entity_arr = $entity->toArray();

            $seller_name = $entity_arr['first_name'].' '.$entity_arr['last_name'];

            //Activate the user
            $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);

            //Activate the seller trade (Update is_active = 1 for seller trade)
            //$this->TradeModel->where('user_id',$id)->update(['is_active'=>'1']);

            //Get seller trades
           // $arr_seller_trade = $this->TradeModel->where('user_id',$id)
                                     // ->get()->toArray();
            //$seller_trade_ids = array_column($arr_seller_trade, 'id');

            //Activate interested_buyers trades (update interested_buyers trade is_active = 1)
           // $this->TradeModel->whereIn('linked_to',$seller_trade_ids)->update(['is_active'=>'1']);

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
                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated dispensary '.$seller_name.'.';

                  $result = $this->UserService->save_activity($arr_event); 
              }

            /*----------------------------------------------------------------------*/
          }

         

            return TRUE;
        }

        return FALSE;
    }

    public function perform_deactivate($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();
        
        if($entity)
        {   
            $entity_arr = $entity->toArray();

            $seller_name = $entity_arr['first_name'].' '.$entity_arr['last_name'];

            //deactivate the user
            $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

            //deactivate the seller trade (Update is_active = 0 for seller trade)
           // $this->TradeModel->where('user_id',$id)->update(['is_active'=>'0']);

            //Get seller trades
            //$arr_seller_trade = $this->TradeModel->where('user_id',$id)
                                     // ->get()->toArray();
          //  $seller_trade_ids = array_column($arr_seller_trade, 'id');

            //deactivate interested_buyers trades (update interested_buyers trade is_active = 0)
           // $this->TradeModel->whereIn('linked_to',$seller_trade_ids)->update(['is_active'=>'0']);


          if($flag == false)
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
                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated dispensary '.$seller_name.'.';

                  $result = $this->UserService->save_activity($arr_event); 
              }

            /*----------------------------------------------------------------------*/
          }
            


            return TRUE;
        }
        return FALSE;
    }

    public function perform_delete($id,$flag=false)
    { 
        $user = Sentinel::check();
        $entity = $this->BaseModel->where('id',$id)->first();

        if($entity)
        {
            $entity_arr = $entity->toArray();

            $seller_name = $entity_arr['first_name'].' '.$entity_arr['last_name'];

            $this->SellerModel->where('user_id',$id)->delete();        
            $this->ShippingAddressModel->where('user_id',$id)->delete();
      
            /* Detaching Role from user Roles table */
            $user = Sentinel::findById($id);
            $role_owner     = Sentinel::findRoleBySlug('admin');
            $role_traveller = Sentinel::findRoleBySlug('seller');
            $user->roles()->detach($role_owner);
            $user->roles()->detach($role_traveller);

           $delete_success = $this->BaseModel->where('id',$id)->delete();
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
               /* $arr_event                 = [];
                $arr_event['ACTION']       = 'REMOVED';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);*/
            /*----------------------------------------------------------------------*/

            if($flag == false)
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
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted dispensary '.$seller_name.'.';

                      $result = $this->UserService->save_activity($arr_event); 
                  }

              /*----------------------------------------------------------------------*/

            }
           return $delete_success;
        }

        return FALSE;
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

     // create mail structure
    public function built_mail_data($email,$password)
    {
      $user = $this->get_user_details($email);
      
      if($user)
      {
        $arr_user = $user->toArray();

        $login_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url("/login").'">Login Now</a><br/>';


        $arr_built_content = [
                                'FIRST_NAME'  => $arr_user['first_name'],
                                'APP_URL'     => config('app.project.name'),
                                'LOGIN_URL'   => $login_url,
                                'EMAIL'       => $email,
                                'PASSWORD'    => $password
                             ];

        $arr_mail_data                      = [];
        $arr_mail_data['email_template_id'] = '34';
        $arr_mail_data['arr_built_content'] = $arr_built_content;
        $arr_mail_data['arr_built_subject'] = '';
        $arr_mail_data['user']              = $arr_user;

        return $arr_mail_data;
      }
      return FALSE;
    }

    public function  get_user_details($email)
    {

        $credentials = ['email' => $email];
        $user = Sentinel::findByCredentials($credentials); // check if user exists

        if($user)
        {
          return $user;
        }
        return FALSE;
    }

    public function mark_as_trusted(Request $request)
    {
        $user  = Sentinel::check();

        $user_id = base64_decode($request->user_id);
        $verification_status  = $request->status;
        
        $is_available = $this->BaseModel->where('id',$user_id)->count()>0;

        $seller_obj = $this->BaseModel->where('id',$user_id)->first();

        $seller_arr = $seller_obj->toArray();

        $seller_name = $seller_arr['first_name'].' '.$seller_arr['last_name'];

        
        if($is_available)
        {
            if($verification_status=='trusted')
            {
                $update_field = 1;
            }
            else
            {
                $update_field = 0;
            }

            $status = $this->BaseModel->where('id',$user_id)->update(['is_trusted'=>$update_field]);

            if($status)
            {       
                /***********Notification START*************************/
                    // $from_user_id = 0;
                    // $to_user_id   = 0;
                    // $user_name    = "";

                    // if(Sentinel::check())
                    // {
                    //     $user_details = Sentinel::getUser();
                    //     $from_user_id = $user_details->id;
                    // }

                    // $url = url('/').'/login';

                    // $arr_event                 = [];
                    // if($verification_status=='trusted')
                    // {
                    //     $arr_event['message']      = 'Checker '.$user_name.' Mark you as a verified user on '.config('app.project.name');
                    // }
                    // else
                    // {
                    //     $arr_event['message']      = 'Checker '.$user_name.' Mark you as a Unverified user on '.config('app.project.name');
                    // }
                    

                    // $arr_event['from_user_id'] = $from_user_id;
                    // $arr_event['to_user_id']   = $user_id;                    
                    // $arr_event['url']          = $url;
                    
                    // if($verification_status=='trusted')
                    // {
                    //     $arr_event['subject']      = 'Checker Mark You As a Verified User';
                    // }
                    // else
                    // {
                    //     $arr_event['subject']      = 'Checker Mark You As a Unverified User';
                    // }

                    // $this->save_notification($arr_event);

                /***********Notification END***************************/


                $response['status']      = 'SUCCESS';
                
                if($verification_status=='trusted')
                {

                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                      //save sub admin activity log 

                      if(isset($user) && $user->inRole('sub_admin'))
                      {
                          $arr_event                 = [];
                          $arr_event['action']       = 'MARK AS TRUSTED';
                          $arr_event['title']        = $this->module_title;
                          $arr_event['user_id']      = isset($user->id)?$user->id:'';
                          $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked as trusted to the seller '.$seller_name.'.';

                          $result = $this->UserService->save_activity($arr_event); 
                      }

                 
                    /*----------------------------------------------------------------------*/

                    $response['message'] = str_singular($this->module_title).' verified successfully';
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
                          $arr_event['action']       = 'MARK AS UNTRUSTED';
                          $arr_event['title']        = $this->module_title;
                          $arr_event['user_id']      = isset($user->id)?$user->id:'';
                          $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked as untrusted to the seller '.$seller_name.'.';

                          $result = $this->UserService->save_activity($arr_event); 
                      }

                 
                    /*----------------------------------------------------------------------*/

                    $response['message'] = str_singular($this->module_title).' unverified successfully';
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


    public function approve_business_details(Request $request)
    {
        $user = Sentinel::check();

        if(isset($request->seller_id) && $request->seller_id!="")
        {
            $seller_id  = base64_decode($request->seller_id);
            $status     = $request->status;


            $res_check_details = $this->SellerModel
                                      ->with(['user_details'])
                                      ->select('*')
                                      ->where('user_id',$seller_id)
                                      ->get()
                                      ->toArray();

            
            // if($res_check_details[0]['business_name']!='' && $res_check_details[0]['tax_id']!='' && $res_check_details[0]['id_proof']!='')
            
            $seller_fname = isset($res_check_details[0]['user_details']['first_name'])?$res_check_details[0]['user_details']['first_name']:'';
            $seller_lname = isset($res_check_details[0]['user_details']['last_name'])?$res_check_details[0]['user_details']['last_name']:'';

            $user_name = $seller_fname.' '.$seller_lname;

            $business_url = url('/').'/seller/business-profile';

           // if($res_check_details[0]['business_name']!='' && $res_check_details[0]['tax_id']!='')
            if($res_check_details[0]['business_name']!='')
            {   

                /****************Get Admin ID (START)*****************************/
                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }
                /****************Get Admin ID (END)*****************************/

                //if($res_check_details[0]['approve_status']=='0' && $status=='2')
                if($status=='2')    
                {
                    $approve_business_details = $this->SellerModel
                                                     ->where('user_id',$seller_id)
                                                     ->update(array('approve_status'=>'2'));
                    
                    if($approve_business_details)  
                    {   
                        
                        /***************Send Notification to Seller (START)***********************/
                            
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $admin_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['type']         = 'seller';
                            $arr_event['description']  = config('app.project.admin_name').' has rejected your <a target="_blank" href="'.$business_url.'"><b>business details</b></a>.';
                            $arr_event['title']        = 'Business Details Rejection';
                            
                            $this->GeneralService->save_notification($arr_event);

                        /***************Send Notification to Seller (END)*************************/

                        /*******************Send Mail Notification to Seller(START)***************/
                         /*   $msg     = config('app.project.admin_name').' has rejected your business details.';

                            $subject = 'Business Details Rejection';
*/
                            $arr_built_content = ['USER_NAME'     => $user_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'), 
                                                  'URL'           => $business_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '105';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*******************Send Mail Notification to Seller(END)*****************/

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
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has rejected business details.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }


                        /*----------------------------------------------------------------------*/


                        $response['status']  = 'SUCCESS';
                        $response['message'] = 'Business details rejected successfully';
                    }
                    else
                    {
                        $response['status']  = 'ERROR';
                        $response['message'] = 'Problem occured while rejecting details';
                    }

                }
               // elseif($res_check_details[0]['approve_status']=='0' && $status=='1')
                elseif($status=='1')

                {
                    $approve_business_details = $this->SellerModel
                                                     ->where('user_id',$seller_id)
                                                     ->update(array('approve_status'=>'1'));
                    
                    if($approve_business_details)  
                    {       
                           /***************Send Notification to Seller (START)***********************/
                            
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $admin_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['type']         = 'seller';
                            $arr_event['description']  = config('app.project.admin_name').' has approved your <a target="_blank" href="'.$business_url.'"><b>business details</b></a>.';
                            $arr_event['title']        = 'Business Details Approval';
                            
                            $this->GeneralService->save_notification($arr_event);

                        /***************Send Notification to Seller (END)*************************/

                        /*******************Send Mail Notification to Seller(START)***************/
                           /* $msg     = config('app.project.admin_name').' has approved your business details.';

                            $subject = 'Business Details Approval';
*/
                            $arr_built_content = ['USER_NAME'     => $user_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => $config('app.project.admin_name'),
                                                  'URL'           => $business_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '106';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*******************Send Mail Notification to Seller(END)*****************/

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
                              $arr_event['message']      = $user->first_name.' '.$user->last_name.' has approved business details.';

                              $result = $this->UserService->save_activity($arr_event); 
                          }

                        /*----------------------------------------------------------------------*/


                        $response['status']   = 'SUCCESS';
                        $response['message']  = 'Business details approved successfully';
                    }
                    else
                    {
                        $response['status']   = 'ERROR';
                        $response['message']  = 'Problem occured while approving details';
                    }
                }
                         
            }
            else
            {
                $response['status']   = 'ERROR';
                $response['message']  = 'Business details not exists';
            }
            return response()->json($response);
        }
    }
    public function get_business_details(Request $request)
    {
        if(isset($request->seller_id) && $request->seller_id!="")
        {
           $seller_id  = base64_decode($request->seller_id);
           $res_check_details = $this->SellerModel->select('*')->where('user_id',$seller_id)->get();
           if(!empty($res_check_details))
           {    
              $res_check_details = $res_check_details->toArray();


               // $arr_response['business_name']  = isset($res_check_details[0]['business_name'])?$res_check_details[0]['business_name']:'-';

               if(isset($res_check_details[0]['business_name']) && $res_check_details[0]['business_name']!=''){
                  $arr_response['business_name']  =$res_check_details[0]['business_name'];
               }else
               {
                $arr_response['business_name']  ='-';
               }


               $arr_response['tax_id']  = isset($res_check_details[0]['tax_id'])?$res_check_details[0]['tax_id']:'-';
              // $arr_response['id_proof']  = isset($res_check_details[0]['id_proof'])?$res_check_details[0]['id_proof']:'-';
               $arr_response['status']      = 'SUCCESS';
               $arr_response['approve_status']      = isset($res_check_details[0]['approve_status'])?$res_check_details[0]['approve_status']:'-';
             
           }else{
              $arr_response['status']      = 'ERROR';
           }
           return response()->json($arr_response);
        }    
    }//end of get business details

    public function approveage(Request $request)
    {
        $user = Sentinel::check();

        $user_id = $request->user_id;



        if($user_id)
        {   
            $res_age = $this->SellerModel->select('*')
                            ->where('user_id',$user_id)  
                            ->get();

            if(!empty($res_age) && count($res_age)>0)
            {
                $res_age = $res_age->toArray();
                  
                $approve_verification_status = $res_age[0]['approve_verification_status'];
                $front_image  = $res_age[0]['front_image'];
                $back_image   = $res_age[0]['back_image'];
                $selfie_image = $res_age[0]['selfie_image'];
                $address_proof = $res_age[0]['address_proof'];
 

                if($front_image && $back_image)
                {
                    if($approve_verification_status==0 || $approve_verification_status==3 || $approve_verification_status==2)
                    {
                           
                        $res_age_update = $this->SellerModel
                                                ->where('user_id',$user_id)
                                                ->update(['approve_verification_status'=>'1','note'=>'','sorting_order_by'=>NULL]);   
                        if($res_age_update)
                        {   
                            /************Delete Id Proof Image(START)******************/
                                $front_image_file  = $this->seller_id_proof_base_path.$front_image;
                                $back_image_file   = $this->seller_id_proof_base_path.$back_image;
                                $selfie_image_file = $this->seller_id_proof_base_path.$selfie_image;

                                $addressproof_image_file = $this->seller_id_proof_base_path.$address_proof;
                                $this->unlink_image($front_image_file);
                                $this->unlink_image($back_image_file);
                                $this->unlink_image($selfie_image_file);
                                $this->unlink_image($addressproof_image_file);

                            /**************Delete Id Proof Image(END)*********************/

                           // $url     = url('/').'/seller/id_verification';
                            $url     = url('/').'/seller/bank_detail';
                            /************Send Notification to Seller (START)****************/

                                $from_user_id = 0;
                                $admin_id     = 0;
                                $user_name    = "";

                                if(Sentinel::check())
                                {
                                    $admin_details = Sentinel::getUser();

                                    $from_user_id = $admin_details->id;
                                    $admin_name   = $admin_details->first_name.' '.$admin_details->last_name;
                                }
                               
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $from_user_id;
                                $arr_event['to_user_id']   = $user_id;
                                $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>approved</b> the <a target="_blank" href="'.$url.'"><b>id proof verification</b></a>.');
                                $arr_event['type']         = '';
                                $arr_event['title']        = 'Id Proof Verification Approval';
                                $this->GeneralService->save_notification($arr_event);

                            /*****************Send Notification to Seller (END)******************/


                            /*************Send Email Notification to Seller (START)**************/

                                $to_user = Sentinel::findById($user_id);

                                $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                                $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                               /* $msg     = html_entity_decode(config('app.project.admin_name').' has approved your id proof verification.');

                                $subject   = 'Id Proof Verification Approval';*/


                                $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                      'APP_NAME'      => config('app.project.name'),
                                                      //'MESSAGE'     => $msg,
                                                      'ADMIN_NAME'    => config('app.project.admin_name'),
                                                      'URL'           => $url
                                                     ];

                                $arr_mail_data['email_template_id'] = '107';
                                $arr_mail_data['arr_built_content'] = $arr_built_content;
                                $arr_mail_data['arr_built_subject'] = '';
                                $arr_mail_data['user']              = Sentinel::findById($user_id);

                                $this->EmailService->send_mail_section($arr_mail_data);

                            /*************Send Email Notification to Seller (END)****************/

                                /*-------------------------------------------------------
                                |   Activity log Event
                                --------------------------------------------------------*/
                                  
                               //save sub admin activity log 

                                if(isset($user) && $user->inRole('sub_admin'))
                                {
                                    $arr_event                 = [];
                                    $arr_event['action']       = 'VERIFY';
                                    $arr_event['title']        = $this->module_title;
                                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has verified id proof of dispensary '.$f_name.' '.$l_name.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                            /*----------------------------------------------------------------------*/

                            $response['status']      = 'SUCCESS';
                            $response['description'] = 'Id proof verified successfully'; 
                            return response()->json($response);   
                        }            

                    }
                    else if($approve_verification_status==1)
                    {
                        $response['status']      = 'ERROR';
                        $response['description'] = 'Id proof verification already approved'; 
                        return response()->json($response);   
                    }

                }
                else
                {
                    $response['status']      = 'ERROR';
                    $response['description'] = 'Please upload front side,back side image'; 
                } 

            }// if age data
        }
    }//end of function of approve age
 
  public function get_details($user_id)
  {

    $res_user = $this->UserModel->where('id',$user_id)->first();
    if(!empty($res_user))
    {
      return $res_user;
    }
    return FALSE;
  }
  public function built_data($user_id)
  {

    $admin_arr =[];
    $admin_obj = UserModel::where('user_type','admin')->first();
    if($admin_obj)
    {
      $admin_arr = $admin_obj->toArray();
    }

    $user = $this->get_details($user_id);
    if($user)
    {
        $arr_user = $user->toArray();

        $arr_built_content = [
                              'ADMIN_NAME'   => config('app.project.admin_name'),  
                              'SELLER_NAME'  => $arr_user['first_name'].' '.$arr_user['last_name'],
                              'EMAIL'        => $arr_user['email'],
                              'APP_NAME'     => config('app.project.name')];

        $arr_mail_data                      = [];
        $arr_mail_data['email_template_id'] = '38';
        $arr_mail_data['arr_built_content'] = $arr_built_content;
        $arr_mail_data['user']              = $arr_user;
        return $arr_mail_data;
    }
    return FALSE;
  }


    public function approveprofile(Request $request)
    {
        $user = Sentinel::check();

        $user_id = $request->user_id;

        if($user_id)
        {   
            $res_profile = $this->UserModel->select('*')
                            ->where('id',$user_id)  
                            ->get();

            if(!empty($res_profile) && count($res_profile)>0)
            {
                $res_profile = $res_profile->toArray();
                  
                $approve_status = $res_profile[0]['approve_status'];

                if($approve_status==0 || $approve_status==3 || $approve_status==2)
                {
                  
                    $res_profile_update = $this->UserModel
                                    ->where('id',$user_id)
                                    ->update(['approve_status'=>'1','note'=>'']);   
                    if($res_profile_update)
                    {
                        $url     = url('/').'/seller/profile';
                        /*************Send Notification to Seller (START)************/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id = $admin_details->id;
                                $admin_name   = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                          
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $user_id;
                            $arr_event['description']  = html_entity_decode(config('app.project.admin_name').' has <b>approved</b> your <a target="_blank" href="'.$url.'"><b>profile details.</b></a>');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Profile Details Approval';
                            $this->GeneralService->save_notification($arr_event);

                        /*******************Send Notification to Seller (END)********************/


                        /*******************Send Email Notification to Seller (START)********************/

                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                           /* $msg   = html_entity_decode(config('app.project.admin_name').' has approved your profile details.');

                            
                            $subject = 'Profile Details Approval';*/


                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '108';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                        /*******************Send Email Notification to Seller (END)********************/
                         
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
                                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has approved profile of dispensary '.$f_name.' '.$l_name.'.';

                                  $result = $this->UserService->save_activity($arr_event); 
                              }

                          /*----------------------------------------------------------------------*/
             

                        $response['status']      = 'SUCCESS';
                        $response['description'] = 'Profile details approved successfully'; 
                        return response()->json($response);   
                    }            
                }
                else if($approve_status==1)
                {

                    $response['status']      = 'ERROR';
                    $response['description'] = 'Profile details already approved'; 
                    return response()->json($response);   
                }   

            }// if age data
        }
    }//end of function of approve profile

    public function rejectage(Request $request)
    {
        $user = Sentinel::check();

        $user_id = $request->user_id;
        $note = $request->note;
        if($user_id && $note)
        {    $res_age = $this->SellerModel->select('*')
                            ->where('user_id',$user_id)  
                            ->get();

             if(!empty($res_age) && count($res_age)>0)
             {
                $res_age = $res_age->toArray();

                $approve_verification_status = $res_age[0]['approve_verification_status'];
                $front_image = $res_age[0]['front_image'];
                $back_image = $res_age[0]['back_image'];


                if($approve_verification_status=='0' || $approve_verification_status=='3' || $approve_verification_status=='1')
                {   

                
                    $res_age_update = $this->SellerModel
                                    ->where('user_id',$user_id)
                                    ->update(['approve_verification_status'=>'2','note'=>$note,'sorting_order_by'=>NULL]);   
                    if($res_age_update)
                    {   
                       // $url     = url('/').'/seller/id_verification';
                         $url     = url('/').'/seller/bank_detail';
                        /*******Send Notification to Seller (START)**************************/
                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $user_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>rejected</b> your <a target="_blank" href="'.$url.'"><b>id proof verification</b></a>.<br> <b>Reason: </b>'.$note);
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Id Proof Verification Rejection';
                            $this->GeneralService->save_notification($arr_event);

                        /************Send Notification to Seller (END)**************************/


                        /**********Send Email Notification to Seller (START)*********************/

                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                            /*$msg   = html_entity_decode(config('app.project.admin_name').' has rejected your id proof verification. <br> <b>Reason: </b>'.$note.'');

                            
                            $subject = 'Id Proof Verification Rejection';*/

                            $arr_built_content = ['SELLER_NAME'   => $f_name.' '.$l_name,
                                                  'USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                 // 'MESSAGE'       => $msg,
                                                  'URL'           => $url,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'REASON'        => $note
                                                 ]; 

                            $arr_mail_data['email_template_id'] = '109';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /**********Send Email Notification to Seller (END)**********************/


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
                                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has rejected id proof of dispensary '.$f_name.' '.$l_name.'.';

                                  $result = $this->UserService->save_activity($arr_event); 
                              }

                            
                          /*----------------------------------------------------------------------*/


                          $response['status']      = 'SUCCESS';
                          $response['description'] = 'Id proof verification rejected.'; 
                          return response()->json($response);   
                    }            


                }else if($approve_verification_status==2){

                      $response['status']      = 'ERROR';
                      $response['description'] = 'Id proof verification already rejected'; 
                      return response()->json($response);   
                }
             }
        }
   
    }//end of reject


    public function rejectprofile(Request $request)
    {
        $user = Sentinel::check();

        $user_id = $request->user_id;
        $note    = $request->note;

        if($user_id && $note)
        {   
            $res_profile = $this->UserModel->select('*')
                                ->where('id',$user_id)  
                                ->get();

            if(!empty($res_profile) && count($res_profile)>0)
            {
                $res_profile = $res_profile->toArray();

                $approve_status = $res_profile[0]['approve_status'];


                if($approve_status=='0' || $approve_status=='3' || $approve_status=='1')
                {   

                    $res_profile_update = $this->UserModel
                                               ->where('id',$user_id)
                                               ->update(['approve_status'=>'2','note'=>$note]);   

                    if($res_profile_update)
                    {   
                        $url     = url('/').'/seller/profile';
                        /*******Send Notification to Seller (START)*******************************/

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
                            $arr_event['to_user_id']   = $user_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>rejected</b> your <a target="_blank" href="'.$url.'"><b>profile details.</b></a><br> <b>Reason: </b>'.$note);
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Profile Details Rejection';
                            $this->GeneralService->save_notification($arr_event);

                        /***************Send Notification to Seller (END)*******************************/

                        /*********************Send Email Notification (START)***************************/
                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                            /*$msg     = html_entity_decode(config('app.project.admin_name').' has rejected your profile details. <br> <b>Reason:</b> '.$note);

                           
                            $subject = 'Profile Details Rejection';*/


                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'SELLER_NAME'   => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'REASON'        => $note,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '111';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                        /*********************Send Email Notification (END)************************/
                        


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
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has rejected profile details of dispensary '.$f_name.' '.$l_name.'.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }

                        /*----------------------------------------------------------------------*/

                        $response['status']      = 'SUCCESS';
                        $response['description'] = 'Profile details rejected.'; 
                        return response()->json($response);   
                    }            
                }
                else if($approve_status==2)
                {
                    $response['status']      = 'ERROR';
                    $response['description'] = 'Profile details already rejected'; 
                    return response()->json($response);   
                }
            }
        }
    }//end of reject profile

    public function approvedocument(Request $request)
    {
        $user_id = $request->user_id;

        if($user_id)
        {   
            $res_profile = $this->SellerModel->select('*')
                            ->where('user_id',$user_id)  
                            ->get();

            if(!empty($res_profile) && count($res_profile)>0)
            {
                $res_profile = $res_profile->toArray();
                  
                $approve_status = $res_profile[0]['documents_verification_status'];

                if($approve_status==0 || $approve_status==3 || $approve_status==2)
                {
                  
                    $res_profile_update = $this->SellerModel
                                    ->where('user_id',$user_id)
                                    ->update(['documents_verification_status'=>'1','note'=>'']);   
                    if($res_profile_update)
                    {
                        $url     = url('/').'/seller/profile';
                        /*************Send Notification to Seller (START)************/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id = $admin_details->id;
                                $admin_name   = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                          
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $user_id;
                            $arr_event['description']  = html_entity_decode(config('app.project.admin_name').' has <b>approved</b> your <a target="_blank" href="'.$url.'"><b> documents.</b></a>');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Documents Approval';
                            $this->GeneralService->save_notification($arr_event);

                        /*******************Send Notification to Seller (END)********************/


                        /*******************Send Email Notification to Seller (START)********************/

                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                           /* $msg   = html_entity_decode(config('app.project.admin_name').' has approved your profile details.');

                            
                            $subject = 'Profile Details Approval';*/


                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'SELLER_NAME'   => $f_name.' '.$l_name, 
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '130';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                        /*******************Send Email Notification to Seller (END)********************/


                        $response['status']      = 'SUCCESS';
                        $response['description'] = 'Documents approved successfully'; 
                        return response()->json($response);   
                    }            
                }
                else if($approve_status==1)
                {

                    $response['status']      = 'ERROR';
                    $response['description'] = 'Documents already approved'; 
                    return response()->json($response);   
                }   

            }// if age data
        }
    }//end of function of approve documents 

    public function rejectdocument(Request $request)
    {
        $user_id = $request->user_id;
        $note    = $request->note;

        if($user_id && $note)
        {   
            $res_profile = $this->SellerModel->select('*')
                                ->where('user_id',$user_id)  
                                ->get();

            if(!empty($res_profile) && count($res_profile)>0)
            {
                $res_profile = $res_profile->toArray();

                $approve_status = $res_profile[0]['documents_verification_status'];


                if($approve_status=='0' || $approve_status=='3' || $approve_status=='1')
                {   

                    $res_profile_update = $this->SellerModel
                                               ->where('user_id',$user_id)
                                               ->update(['documents_verification_status'=>'2','note_doc_reject'=>$note]);   

                    if($res_profile_update)
                    {   
                        $url     = url('/').'/seller/profile';
                        /*******Send Notification to Seller (START)*******************************/

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
                            $arr_event['to_user_id']   = $user_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>rejected</b> your <a target="_blank" href="'.$url.'"><b>documents.</b></a><br> <b>Reason: </b>'.$note);
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Documents Rejection';
                            $this->GeneralService->save_notification($arr_event);

                        /***************Send Notification to Seller (END)*******************************/

                        /*********************Send Email Notification (START)***************************/
                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                            /*$msg     = html_entity_decode(config('app.project.admin_name').' has rejected your profile details. <br> <b>Reason:</b> '.$note);

                           
                            $subject = 'Profile Details Rejection';*/


                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'SELLER_NAME'   => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'REASON'        => $note,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '131';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                        /*********************Send Email Notification (END)************************/

                        $response['status']      = 'SUCCESS';
                        $response['description'] = 'Documents rejected.'; 
                        return response()->json($response);   
                    }            
                }
                else if($approve_status==2)
                {
                    $response['status']      = 'ERROR';
                    $response['description'] = 'Dcouments already rejected'; 
                    return response()->json($response);   
                }
            }
        }
    }//end of reject documents


    public function unlink_image($image_file)
    {   
        if(file_exists($image_file))
        {       
            chmod($image_file, 0777);
            unlink($image_file);
            return true;
        }
        else
        {
            return false;
        }
    }// end of unlink img function

    // function added for previous sellers free membership entry in db 
    public function get_oldsellers()
    {
           
           $get_oldsellers =  \DB::table('users AS t1')
                            ->select('t1.id')
                            ->leftJoin('user_subscriptions AS t2','t2.user_id','=','t1.id')
                            ->whereNull('t2.id')
                            ->where('user_type','seller')
                            ->get()->toArray();
       
           //  dd($get_oldsellers);
                            
            if(isset($get_oldsellers))
            {   
                  foreach($get_oldsellers as $k=>$v){

                          $user_id = $v->id;

                           $arr_subscription = [];
                           $get_free_subscription = $this->MembershipModel
                                        ->where('membership_type','1')
                                        ->where('is_active','1')
                                        ->first();

                               if(isset($get_free_subscription) && !empty($get_free_subscription))
                               {

                                  $get_free_subscription = $get_free_subscription->toArray();
                                  $membership_id = $get_free_subscription['id'];

                                    $arr_subscription = [];

                                    $arr_subscription['transaction_id'] = '';
                                    $arr_subscription['payment_status'] = '0';
                                    $arr_subscription['user_id']       = $user_id;
                                    $arr_subscription['membership_id'] = $membership_id ;
                                    $arr_subscription['membership'] = '1';
                                    $arr_subscription['membership_amount'] = '0';
                                    $arr_subscription['membership_status'] = '1';
                                    
                                    $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);
                                    if($store_subscription_details)
                                    {
                                        echo "<pre>"."Inserted...".$user_id;
                                    }


                               }//if free membership        

                   }            

            }                

      }// end of function of old sellers

      public function featured(Request $request)
      {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        $arr_response = [];    
        if($this->perform_featured(base64_decode($enc_id)))
        {
            $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
        }

        $arr_response['data'] = 'ACTIVE';

        return response()->json($arr_response);
    }

    public function unfeatured(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        $arr_response = []; 
        
        if($this->perform_unfeatured(base64_decode($enc_id)))
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
    
    public function perform_featured($id)
    {
        $user = Sentinel::check();
        $seller_name = "";
        $seller = $this->BaseModel->where('id',$id)->update(['is_featured'=>'1']);
       
        $seller_details = $this->BaseModel->where('id',$id)->first();

        if(isset($seller_details))
        {
          $seller_arr = $seller_details->toArray();

          $seller_name = $seller_arr['first_name'].' '.$seller_arr['last_name'];
        }


        if($seller)
        {

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'FEATURED';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has featured dispensary '.$seller_name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }


            /*----------------------------------------------------------------------*/

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function perform_unfeatured($id)
    {
        $user = Sentinel::check();
        $seller_name = "";

        $seller     = $this->BaseModel->where('id',$id)->update(['is_featured'=>'0']);

        $seller_details = $this->BaseModel->where('id',$id)->first();

        if(isset($seller_details))
        {
          $seller_arr = $seller_details->toArray();

          $seller_name = $seller_arr['first_name'].' '.$seller_arr['last_name'];
        }



        if($seller)
        {

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
             //save sub admin activity log 

              if(isset($user) && $user->inRole('sub_admin'))
              {
                  $arr_event                 = [];
                  $arr_event['action']       = 'UNFEATURED';
                  $arr_event['title']        = $this->module_title;
                  $arr_event['user_id']      = isset($user->id)?$user->id:'';
                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has unfeatured dispensary '.$seller_name.'.';

                  $result = $this->UserService->save_activity($arr_event); 
              }

            /*----------------------------------------------------------------------*/

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }//end unfreatured function


    public function verifyuseremail(Request $request)
    {
        $user = Sentinel::check();

        $response =[];  
        $user_id = $request->user_id;
        $email    = $request->email;

        if($user_id && $email)
        {    

           $activationrec = Activation::createModel()->where(['user_id' => $user_id])->first();

  
            // $user = Sentinel::findById($activationrec->user_id);
             $user = Sentinel::findById($request->user_id);

            if($activation =Activation::completed($user) == true)
            {
                $response['status']      = 'WARNING';
                $response['description'] = 'Your account is already verified.'; 
                return response()->json($response);   

            }


            if(isset($activationrec))
            {
              $code = $activationrec->code;
               
              if(isset($activationrec) && isset($activationrec->code) && !empty($activationrec->code))
              {


                       if(Activation::complete($user, $code))
                       {      

                            $url     = url('/').'/login';
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
                            $arr_event['to_user_id']   = $user_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>varify your email</b> you can make login. <a target="_blank" href="'.$url.'"><b>age verification</b></a>.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Email Verified';
                            $this->GeneralService->save_notification($arr_event);



                            $to_user = Sentinel::findById($user_id);
                           // $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                           // $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
                            $fullname ='';
                            if((isset($to_user->first_name) && !empty($to_user->first_name) )|| (isset($to_user->first_name) && !empty($to_user->first_name)))
                            {

                              $fullname = $to_user->first_name.''.$to_user->last_name;
                            }
                            else
                            {
                               $fullname = $to_user->email;
                            }


                          /*  $msg     = html_entity_decode(config('app.project.admin_name').' has varify your email you can make login.');
                            
                            $subject = 'Email Verified';*/

                            $arr_built_content = ['SELLER_NAME'   => $fullname,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '112';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                            

                            /*-------------------------------------------------------
                            |   Activity log Event
                            --------------------------------------------------------*/
                              
                               //save sub admin activity log 

                                if(isset($user) && $user->inRole('sub_admin'))
                                {
                                    $arr_event                 = [];
                                    $arr_event['action']       = 'VERIFY';
                                    $arr_event['title']        = $this->module_title;
                                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has verified email of dispensary '.$fullname.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                        
                            /*----------------------------------------------------------------------*/


                            $response['status']      = 'SUCCESS';
                            $response['description'] = 'Email verified successfully.'; 
                            return response()->json($response);  

                       } //if activation complete
                       else
                       {
                           $response['status']      = 'ERROR';
                           $response['description'] = 'Something went wrong.'; 
                           return response()->json($response); 
                       }
             }//if isset activation rec and code not empty
             else
             {
                   $response['status']      = 'ERROR';
                   $response['description'] = 'Activation code is not availiable.'; 
                   return response()->json($response); 
             }//else if activationrec and code not empty


         }//if activationrec
         else
         {
             //  $response['status']      = 'ERROR';
             //  $response['description'] = 'Activation record is not availiable.'; 
            //   return response()->json($response); 
                $user = $this->get_user_details($email);
                if(isset($user) && !empty($user))
                {

                   $activation = Activation::create($user);
                   $activation_record = $this->ActivationsModel->where('user_id',$user_id)->first();
                    if(isset($activation_record) && !empty($activation_record))
                    {
                      $activation_record = $activation_record->toArray();
                       $arr_user = $user->toArray();

                        if(Activation::complete($user, $activation_record['code']))
                       {      

                            $url     = url('/').'/login';
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
                            $arr_event['to_user_id']   = $user_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>varify your email</b> you can make login. <a target="_blank" href="'.$url.'"><b>age verification</b></a>.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Email Verified';
                            $this->GeneralService->save_notification($arr_event);



                            $to_user = Sentinel::findById($user_id);                     
                            $fullname='';
                            if((isset($to_user->first_name) && !empty($to_user->first_name) )|| (isset($to_user->first_name) && !empty($to_user->first_name)))
                            {

                              $fullname = $to_user->first_name.''.$to_user->last_name;
                            }
                            else
                            {
                               $fullname = $to_user->email;
                            }

                           /* $msg     = html_entity_decode(config('app.project.admin_name').' has varify your email you can make login.');
                            
                            $subject = 'Email Verified';*/

                            $arr_built_content = ['USER_NAME'     => $fullname,
                                                  'SELLER_NAME'   => $fullname,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '112';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                           /*-------------------------------------------------------
                            |   Activity log Event
                            --------------------------------------------------------*/
                              
                               //save sub admin activity log 

                                if(isset($user) && $user->inRole('sub_admin'))
                                {
                                    $arr_event                 = [];
                                    $arr_event['action']       = 'VERIFY';
                                    $arr_event['title']        = $this->module_title;
                                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has verified email of dispensary '.$fullname.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                        
                            /*----------------------------------------------------------------------*/
                            

                            $response['status']      = 'SUCCESS';
                            $response['description'] = 'Email verified successfully.'; 
                            return response()->json($response);  

                       } //if activation complete
                       else
                       {
                           $response['status']      = 'ERROR';
                           $response['description'] = 'Something went wrong.'; 
                           return response()->json($response); 
                       }


                    }//if activation record exists
                 }//if user      






         }//else if activationrec and code not empty

        }//if user and email id
   
    }//end of verifyuseremail function


    public function sendverificationemail(Request $request)
    {
        $activationcodeforemail = '';
        $response =[];  
        $user_id = $request->user_id;
        $email    = $request->email;
        $completed    = $request->completed; 
        $activation_code    = $request->code;
        $activationcodeemail = isset($request->activationcode)?$request->activationcode:'';


          /****************check activation code*********/

             $check_user_exists = $this->UserModel->where('id',$user_id)->first();
                         
            if(isset($check_user_exists) && !empty($check_user_exists))
            {
              $check_user_exists = $check_user_exists->toArray();

              if(isset($check_user_exists['activationcode']) && !empty($check_user_exists['activationcode']))
              {
                $activationcodeforemail = $check_user_exists['activationcode'];
              }
              else
              {
                  $create_actcode = unique_code(8);;
                  $update_activationcode =[];
                  $update_activationcode['activationcode'] = $create_actcode;
                  $this->UserModel->where('id',$user_id)->update($update_activationcode);

                  $activationcodeforemail = $create_actcode;

              }//else of user activation code exists
           }//if user code exists   

          /***************check activation code******/





        $activation_record = $this->ActivationsModel->where('user_id',$user_id)->first();
        if(isset($activation_record) && !empty($activation_record))
        {
          $activation_record = $activation_record->toArray();
        
        

        if($email && $activation_code && $user_id && $activationcodeforemail)
        {

             $user = $this->get_user_details($email);
        
             if($user)
             {
                $arr_user = $user->toArray();
                // $activation_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url('/').'/activate_account/'.$activation_code.'">Activate Now</a><br/>' ;
                
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
                          'USER_FNAME'     => $email_name,
                          'SELLER_NAME'    => $email_name,
                          'ACTIVATION_URL' => $activation_url,
                          'APP_NAME'       => config('app.project.name')];

              $arr_mail_data                      = [];
              $arr_mail_data['email_template_id'] = '6';
              $arr_mail_data['arr_built_content'] = $arr_built_content;
               $arr_mail_data['arr_built_subject'] = '';
              $arr_mail_data['user']              = $arr_user;

              $email_status  = $this->EmailService->send_mail_section($arr_mail_data);

              $response['status']      = 'SUCCESS';
              $response['description'] = 'Verification email send successfully.'; 
              return response()->json($response);  

            }//if user
            else
            {
                  $response['status']      = 'ERROR';
                  $response['description'] = 'User does not exists.'; 
                  return response()->json($response); 
            }
        }//if email,userid,activationcode
        else
        {
          $response['status']      = 'ERROR';
          $response['description'] = 'Something went wrong.'; 
          return response()->json($response); 
        }

       }//if activation record exists
       else
       {
         // $response['status']      = 'ERROR';
        //  $response['description'] = 'Activation record of user does not exists.'; 
         // return response()->json($response); 

              $activationcodeforemail = $activationcodeforemail; 

              $user = $this->get_user_details($email);
              if(isset($user) && !empty($user))
              {

                  $activation = Activation::create($user);
                  $activation_record = $this->ActivationsModel->where('user_id',$user_id)->first();
                if(isset($activation_record) && !empty($activation_record))
                {
                      $activation_record = $activation_record->toArray();
                      $arr_user = $user->toArray();

                      // $activation_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url('/').'/activate_account/'.$activation_record['code'].'">Activate Now</a><br/>' ;
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
                                 //'USER_FNAME'    => $arr_user['first_name'],
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
                      $response['description'] = 'Verification email send successfully.'; 
                      return response()->json($response);  

                }//if activation record exists   

            }//if user

       }// else of activation record does not exists 
    }//end function of sendverification email


}
