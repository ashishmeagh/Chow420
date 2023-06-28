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
use App\Models\ShippingAddressModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\StatesModel;
use App\Models\ActivationsModel;
use App\Models\OrderAddressModel;
use App\Models\SiteSettingModel;
use App\Models\DropShipperModel;
use App\Models\EmailTemplateModel;
use App\Models\BuyerWalletModel;


use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Common\Services\UserService;
use Flash;
use Validator;
use Sentinel;
use Activation;
use Reminder;
use DB;
use Datatables;
use PDF,Storage;
use Excel;
use Mail;



class BuyerController extends Controller
{
    use MultiActionTrait;

    public function __construct(UserModel $user,
                                CountriesModel $country,
                                ActivityLogsModel $activity_logs,
                                BuyerModel $buyerModel,
                                SellerModel $sellerModel,
                                RoleUserModel $roleUserModel,
                                EmailService $EmailService,
                                UserService $UserService,
                                GeneralSettingsModel $GeneralSettingsModel,
                                ShippingAddressModel $ShippingAddressModel,
                                TransactionModel $TransactionModel,
                                OrderModel $OrderModel,
                                OrderProductModel $OrderProductModel,
                                GeneralService $GeneralService,
                                StatesModel $StatesModel,
                                ActivationsModel $ActivationsModel,
                                OrderAddressModel $OrderAddressModel,
                                SiteSettingModel $SiteSettingModel,
                                DropShipperModel $DropShipperModel,
                                ProductModel $ProductModel,
                                EmailTemplateModel $EmailTemplateModel,
                                BuyerWalletModel $BuyerWalletModel
                                )
    {
        $user = Sentinel::createModel();

        $this->EmailService                 = $EmailService;
        $this->UserService                  = $UserService;
        $this->UserModel                    = $user;
        $this->BaseModel                    = $this->UserModel;   // using sentinel for base model.
        $this->CountriesModel               = $country;
        $this->ActivityLogsModel            = $activity_logs;
        $this->BuyerModel                   = $buyerModel;
        $this->SellerModel                  = $sellerModel;
        $this->RoleUserModel                = $roleUserModel;
        $this->GeneralSettingsModel         = $GeneralSettingsModel;
        $this->ShippingAddressModel         = $ShippingAddressModel; 
        //$this->TradeModel                   = $TradeModel;
        $this->TransactionModel             = $TransactionModel;
        $this->OrderModel                   = $OrderModel;
        $this->OrderProductModel            = $OrderProductModel;
        $this->GeneralService               = $GeneralService;    
        $this->StatesModel                  = $StatesModel;
        $this->ActivationsModel             = $ActivationsModel;
        $this->OrderAddressModel            = $OrderAddressModel; 
        $this->SiteSettingModel             = $SiteSettingModel;
        $this->DropShipperModel             = $DropShipperModel; 
        $this->ProductModel                 = $ProductModel;
        $this->EmailTemplateModel           = $EmailTemplateModel; 
        $this->BuyerWalletModel             = $BuyerWalletModel;

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->id_proof_base_path           = base_path().config('app.project.img_path.id_proof');

        $this->user_id_proof                = url('/').config('app.project.img_path.id_proof');

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/buyers");
        $this->module_title                 = "Buyers";
        $this->modyle_url_slug              = "Buyers";
        $this->module_view_folder           = "admin.users.buyer";
       
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

        $this->arr_view_data['page_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['user_id_proof'] = $this->user_id_proof;

        $this->arr_view_data['arr_data']        = $arr_data;
        

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


        DB::enableQueryLog(); 
        $obj_user = DB::table($user_details)
                                ->select(DB::raw($prefixed_user_details.".id as id,".
                                     $prefixed_user_details.".first_name as first_name, ".
                                      $prefixed_user_details.".last_name as last_name, ".
                                     // $prefixed_user_details.".country as country, ".
                                      $prefixed_user_details.".phone as phone, ".
                                      $prefixed_user_details.".street_address as street_address, ".
                                      $prefixed_user_details.".zipcode as zipcode, ".
                                      $prefixed_user_details.".city as city, ".
                                       $prefixed_user_details.".billing_city as billing_city, ".
                                       $prefixed_user_details.".billing_zipcode as billing_zipcode, ".
                                      $prefixed_user_details.".billing_street_address as billing_street_address, ".
                                      $prefixed_user_details.".approve_status as approve_profile_status, ".
                                   //   $prefixed_country_details.'.name as country,'.
                                    //  $prefix_state_details.'.name as state,'.

                                     'shipping_country.name as shipping_country,'.
                                     'billing_country.name as billing_country,'.

                                     'shipping_state.name as shipping_state,'.
                                     'billing_state.name as billing_state,'.



                                                 $prefixed_user_details.".email as email, ".
                                                 $prefixed_user_details.".date_of_birth as date_of_birth, ".
                                                 $prefixed_user_details.".is_active as is_active, ".
                                                 $prefixed_user_details.".user_type, ".
                                                 $prefixed_buyer_details.".user_id as buyer_user_id, ".
                                                 $prefixed_buyer_details.".front_image as front_image, ".
                                                 $prefixed_buyer_details.".back_image as back_image, ".
                                                 $prefixed_buyer_details.".selfie_image as selfie_image, ".
                                                 $prefixed_buyer_details.".age_address as age_address, ".

                                                  $prefixed_buyer_details.".address_proof as address_proof, ".

                                                 $prefixed_buyer_details.".approve_status as approve_status, ".
                                                 $prefixed_buyer_details.".sorting_order_by as sorting_order_by, ".
                                                 $prefixed_buyer_details.".age_category as age_category, ".
                                                 $prefixed_buyer_details.".note as note, ".

                                                 $prefixed_seller_details.".user_id as seller_user_id, ".
                                                 //$prefixed_user_details.".user_name as user_name, ".
                                                 $prefixed_user_details.".is_trusted,".
                                                 $prefixed_user_details.".activationcode as activationcode, ".
                                                  $prefix_activation_details.".completed,".
                                                  $prefix_activation_details.".code,".
                                                 "CONCAT(".$prefixed_user_details.".first_name,' ',"
                                                    .$prefixed_user_details.".last_name) as user_name"
                                             ))

                                ->leftjoin($prefixed_buyer_details,$prefixed_buyer_details.'.user_id','=',$prefixed_user_details.'.id')
                                ->leftjoin($prefixed_seller_details,$prefixed_seller_details.'.user_id','=',$prefixed_user_details.'.id')

                               // ->leftjoin($prefixed_country_details,$prefixed_country_details.'.id','=',$prefixed_user_details.'.country')

                                 ->leftjoin($prefixed_country_details.' as shipping_country','shipping_country.id','=',$prefixed_user_details.'.country')

                                ->leftjoin($prefixed_country_details.' as billing_country','billing_country.id','=',$prefixed_user_details.'.billing_country')


                               // ->leftjoin($prefix_state_details,$prefix_state_details.'.id','=',$prefixed_user_details.'.state')

                                ->leftjoin($prefix_state_details.' as shipping_state','shipping_state.id','=',$prefixed_user_details.'.state')

                                 ->leftjoin($prefix_state_details.' as billing_state','billing_state.id','=',$prefixed_user_details.'.billing_state')


                                 ->leftjoin($prefix_activation_details,$prefix_activation_details.'.user_id','=',$prefixed_user_details.'.id')

                                // ->leftjoin($rating_tbl,$prefixed_rating_tbl.'.seller_user_id','=',$prefixed_user_details.'.id')
                              
                                ->whereNull($user_details.'.deleted_at')
                                ->where($prefixed_user_details.'.user_type','=','buyer')
                                ->orderBy($prefixed_buyer_details.'.sorting_order_by','DESC')
                                 ->groupBy($prefixed_user_details.'.id');
                               /* ->orderBy($user_details.'.created_at','DESC')
                                ->orderBy($user_details.'.id','DESC');*/

                                // ->get();

        //$arr_user_details = $obj_user->get()->toArray();

           
            // dd($obj_user->toSql());

        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
        {
            $search_term      = $arr_search_column['q_name'];
           // $obj_user = $obj_user->having('first_name','LIKE', '%'.$search_term.'%');
            $obj_user = $obj_user->where('first_name','LIKE', '%'.$search_term.'%')
                                 ->orWhere('last_name','LIKE','%'.$search_term.'%');

        }

        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_term  = $arr_search_column['q_email'];
            $obj_user     = $obj_user->where($user_details.'.email','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_user_type']) && $arr_search_column['q_user_type']!="")
        {
            $search_term = $arr_search_column['q_user_type'];
            $obj_user    = $obj_user->where($prefixed_user_details.'.user_type','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status']!="")
        {
            $search_term = $arr_search_column['q_status'];
            $obj_user    = $obj_user->where($prefixed_user_details.'.is_active','LIKE', '%'.$search_term.'%');
        }
        
        if(isset($arr_search_column['q_vstatus']) && $arr_search_column['q_vstatus']!="")
        {
            $search_term = $arr_search_column['q_vstatus'];
            $obj_user    = $obj_user->where($prefixed_user_details.'.is_trusted','LIKE', '%'.$search_term.'%');
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


        if(isset($arr_search_column['q_age_verification_status']) && $arr_search_column['q_age_verification_status']!="")
        {
            $search_term = $arr_search_column['q_age_verification_status'];
            $obj_user    = $obj_user->where($prefixed_buyer_details.'.approve_status','LIKE', '%'.$search_term.'%');
        }

         if(isset($arr_search_column['q_profile_verification_status']) && $arr_search_column['q_profile_verification_status']!="")
        {
            $search_profilestatus = $arr_search_column['q_profile_verification_status'];
            $obj_user    = $obj_user->where($prefixed_user_details.'.approve_status','LIKE', '%'.$search_profilestatus.'%');
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

                             ->editColumn('total_wallet_amount',function($data) use ($current_context)
                            {
                                $total_wallet_amount =0;

                                $total_wallet_amount = $this->BuyerWalletModel->where('user_id',$data->id)->sum('amount');
                                if(isset($total_wallet_amount) && $total_wallet_amount>0)
                                {
                                  $total_wallet_amount = $total_wallet_amount;
                                }
                               
                                return '$'.$total_wallet_amount;
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


                                $view_payhistory_href =  $this->module_url_path.'/viewpayhistory/'.base64_encode($data->id);

                                $build_payhistory_action = '<a class="eye-actn" href="'.$view_payhistory_href.'" title="View Payment History">Payment History</a>';
                            

                                 $view_order_href =  $this->module_url_path.'/vieworders/'.base64_encode($data->id);

                                 $build_orderview_action = '<a class="eye-actn" href="'.$view_order_href.'" title="View Orders">View Orders</a>';    

                             $build_idproof_action='';   
                            
                            /*
                             $confirm_approve_status='onclick="approve_id_proof($(this))"';
                             $build_idproof_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" '.$confirm_approve_status.'  
                                 data-enc_id="'.base64_encode($data->id).'" title="Approve Id Proof"><i class="ti-receipt" style="color:#31b0d5"></i></a>';  */

                             $build_deleteproof_action='';    

                              /*$delete_idproof='onclick="delete_id_proof($(this))"';
                              $build_deleteproof_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" '.$delete_idproof.'  
                                 data-enc_id="'.base64_encode($data->id).'" title="Delete Id Proof"><i class="ti-receipt" style="color:#31b0d5"></i></a>';  */
 
                                 /*******************************************************/

                                  $build_age_verify_action ='';
                                  $build_age_verify_action = '<a class="btns-approved view_age_section" front_image="'.$data->front_image.'" phone="'.$data->phone.'" user_id="'.$data->buyer_user_id.'" back_image="'.$data->back_image.'" selfie_image="'.$data->selfie_image.'"  address_proof="'.$data->address_proof.'"  age_address="'.$data->age_address.'"  date_of_birth="'.$data->date_of_birth.'"   age_category="'.$data->age_category.'"  approve_status="'.$data->approve_status.'"  note="'.$data->note.'" 

                                    country="'.$data->shipping_country.'" 
                                    state="'.$data->shipping_state.'"  
                                    street_address="'.$data->street_address.'" 
                                    zipcode="'.$data->zipcode.'" 
                                    city="'.$data->city.'" 
                                    billing_country="'.$data->billing_country.'"  
                                    billing_state="'.$data->billing_state.'" 
                                    billing_zipcode="'.$data->billing_zipcode.'"
                                    billing_city="'.$data->billing_city.'"
                                    billing_street_address="'.$data->billing_street_address.'"

                                   title="View Age Verification Details" >Age Verification Details</a>';
                                  

                                 /******************************************************/
 

                             $build_profile_verify_action ='';
                             $build_profile_verify_action = '<a class="btn btn-outline btn-info  show-tooltip  view_profile_section eye-actn" first_name="'.$data->first_name.'" user_id="'.$data->buyer_user_id.'" last_name="'.$data->last_name.'"  email="'.$data->email.'"   phone="'.$data->phone.'"   country="'.$data->shipping_country.'"  state="'.$data->shipping_state.'"   street_address="'.$data->street_address.'" zipcode="'.$data->zipcode.'"  city="'.$data->city.'"   approve_profile_status="'.$data->approve_profile_status.'" 
                                  billing_country="'.$data->billing_country.'"  
                                  billing_state="'.$data->billing_state.'" 
                                  billing_zipcode="'.$data->billing_zipcode.'"
                                  billing_city="'.$data->billing_city.'"
                                  billing_street_address="'.$data->billing_street_address.'"
                                 title="View Profile Verification Details" >Profile Verification Details</a>';     

                                 $build_verifyuser_action ='';
                                 if($data->completed=="1"){
                                  
                                 }else{

                                      $build_verifyuser_action = '<a class="btn btn-outline btn-info  show-tooltip  verifyuserbtn eye-actn"  user_id="'.$data->buyer_user_id.'"  email="'.$data->email.'" completed="'.$data->completed.'"
                                     title="Verify User" >Verify User</a>';    
                                 }

                                 $build_activationemailresend_action ='';
                                 if($data->completed=="1"){

                                  }else{
                                       $build_activationemailresend_action = '<a class="btn btn-outline btn-info  show-tooltip  resendactivationemail eye-actn"  user_id="'.$data->buyer_user_id.'"  email="'.$data->email.'" completed="'.$data->completed.'"  code="'.$data->code.'"   activationcode="'.$data->activationcode.'"
                                       title="Resend Verification Email" >Resend Verification Email</a>'; 
                                 }

                                 $view_wallet_history_link = $this->module_url_path.'/buyer_wallet_history/'.base64_encode($data->id);

                                 $view_wallet_history_action = '<a class="eye-actn" href="'.$view_wallet_history_link.'" title="View wallet history">Wallet History</a>'; 
  

                                return $build_action = $build_edit_action.' '.$build_view_action.' '.$build_payhistory_action.' '.$build_orderview_action.' '.$build_idproof_action.' '.$build_deleteproof_action.' '.$build_age_verify_action.' '.$build_profile_verify_action.''.$build_verifyuser_action.''.$build_activationemailresend_action.''.$view_wallet_history_action;
                            })
                            
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }
    function approveidproof(Request $request)
    {

       // dd($request->all());
        $buyer_id = $request->enc_id;    
        $buyerid = base64_decode($buyer_id);
        if($buyerid)
        {   
            $res_id_proof = $this->BuyerModel->select('*')->where('user_id',$buyerid)->first()->toArray();    
           
            if(!empty($res_id_proof))
            {

               if($res_id_proof['approve_status']==0 && (!empty($res_id_proof['id_proof']))){

                 $approve_proof_details = $this->BuyerModel->where('user_id',$buyerid)->update(array('approve_status'=>'1'));
                   if($approve_proof_details)  
                   {

                     /* $approve_proof_details = $this->BuyerModel->where('user_id',$buyerid)->update(array('id_proof'=>''));

                      if(file_exists(base_path().'/uploads/id_proof/'.$res_id_proof['id_proof'])) 
                      {
                         @unlink($this->user_id_proof.'/'.$res_id_proof['id_proof']) ;

                      } */
                

                      $response['status']      = 'SUCCESS';
                      $response['message']     = 'Id proof approved successfully';
                      return response()->json($response);

                   }
                   else
                   {
                     $response['status']      = 'ERROR';
                     $response['message']     = 'Problem occured while approving details';
                     return response()->json($response);
                   }
               }
               else if($res_id_proof['approve_status']==0 && (empty($res_id_proof['id_proof'])))
                {
                        $response['status']    = 'ERROR';
                      $response['message']     = 'Id proof not uploaded';
                      return response()->json($response);
                }
               else if($res_id_proof['approve_status']==1){

                 $response['status']      = 'ERROR';
                 $response['message']     = 'Id proof already approved';
                 return response()->json($response);
               } 
            }else{
                 $response['status']      = 'ERROR';
                 $response['message']     = 'Problem occured while approving details';
                 return response()->json($response);
            }

        }
    }

    function deleteidproof(Request $request)
    {

       // dd($request->all());
        $buyer_id = $request->enc_id;    
        $buyerid = base64_decode($buyer_id);
        if($buyerid)
        {   
            $res_id_proof = $this->BuyerModel->select('*')->where('user_id',$buyerid)->first()->toArray();    
           
            if(!empty($res_id_proof))
            {

                if($res_id_proof['approve_status']==1 && (!empty($res_id_proof['id_proof'])))
                {
                  if(file_exists(base_path().'/uploads/id_proof/'.$res_id_proof['id_proof'])) 
                  {
                                    
                    // unlink($this->user_id_proof.$res_id_proof['id_proof']) ;
                     unlink(base_path().'/uploads/id_proof/'.$res_id_proof['id_proof']);

                  } 
                     $response['status']      = 'SUCCESS';
                     $response['message']     = 'Id proof deleted successfully';
                     return response()->json($response);
                    
                }
                elseif($res_id_proof['approve_status']==0 && (empty($res_id_proof['id_proof'])))
                {
                  
                     $response['status']      = 'ERROR';
                     $response['message']     = 'Id proof not uploaded';
                     return response()->json($response);
                    
                }
                elseif($res_id_proof['approve_status']==0 && (!empty($res_id_proof['id_proof'])))
                {
                  
                     $response['status']      = 'ERROR';
                     $response['message']     = 'Id proof not approved';
                     return response()->json($response);
                    
                }
                else{
                 $response['status']      = 'ERROR';
                 $response['message']     = 'Problem occured while deleting details';
                 return response()->json($response);
                }
                          
            }else{
                 $response['status']      = 'ERROR';
                 $response['message']     = 'Problem occured while deleting details';
                 return response()->json($response);
            }

        }
    }
 
    public function create()
    {
        //$countries_arr = $this->CountriesModel->get()->toArray();
       
        $google_api_key_obj = $this->GeneralSettingsModel->where('data_id','GOOGLE_API_KEY')->first();
        if($google_api_key_obj)
        {
            $google_api_key_arr = $google_api_key_obj->toArray();
        }

      //  $this->arr_view_data['countries_arr']      = $countries_arr;
        $this->arr_view_data['google_api_key_arr'] = $google_api_key_arr;
        
        $this->arr_view_data['page_title']         = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title']       = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']    = $this->module_url_path;

        $countries_obj = $this->CountriesModel->where('is_active',1)->get();
        if ($countries_obj) {
            $countries_arr = $countries_obj->toArray();

            $this->arr_view_data['countries_arr']  = $countries_arr;
        }

        
        
        return view($this->module_view_folder.'.create', $this->arr_view_data);
    }

    public function view($enc_user_id =false)
    {
        $address_arr = [];

        $user_id = base64_decode($enc_user_id);
  
        $user_obj = $this->UserModel->where('id',$user_id)->with('get_buyer_detail','get_country_detail','get_state_detail')->first();

        if($user_obj)
        {
            $user_arr = $user_obj->toArray();
        }
        

        // $address_obj = $this->ShippingAddressModel->with(['country_details'])->where('user_id',$user_id)->first();

        // if($address_obj)
        // {
        //    $address_arr = $address_obj->toArray();
        // }

        // $this->arr_view_data['address_arr']                = $address_arr;
        $this->arr_view_data['module_url_path']            = $this->module_url_path;
        $this->arr_view_data['user_arr']                   = $user_arr;
        $this->arr_view_data['page_title']                 = 'Buyer Details';
        $this->arr_view_data['user_id_proof_public_path']  = $this->user_id_proof;

        return view($this->module_view_folder.'.show', $this->arr_view_data);
    }
    // function for showing payment history of buyers

    public function viewpayhistory($buyerid)
    {
        $buyer_id = base64_decode($buyerid);
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

        /*---------Get user details---------------*/
        $arr_user = [];
        $obj_user = $this->BaseModel->where('id',$buyer_id)->first();
        if($obj_user){
            $arr_user = $obj_user->toArray();
        }
        /*----------------------------------------*/

        $this->arr_view_data['page_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['buyer_id']        = $buyer_id;
        $this->arr_view_data['arr_user']        = $arr_user;
                
        // dd($this->arr_view_data);

        return view($this->module_view_folder.'.showpayhistory', $this->arr_view_data);

    }
    // function for getting payment history of buyers

     public function get_payment_details(Request $request,$buyer_id)
    {  
       
        $transaction_table          = $this->TransactionModel->getTable();
        $prefixed_transaction_tbl   = DB::getTablePrefix().$transaction_table;

        $user_tbl_name              = $this->UserModel->getTable();
        $prefixed_user_tbl          = DB::getTablePrefix().$this->UserModel->getTable();

        $order_tbl_name              = $this->OrderModel->getTable();
        $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_tbl_name      = $this->OrderProductModel->getTable();
        $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $obj_qutoes = DB::table($order_tbl_name)
                             
                                ->select(DB::raw($order_tbl_name.".*,".
                                                 $prefixed_transaction_tbl.".transaction_status,"
                                                 .$prefixed_transaction_tbl.".buyer_wallet_amount"
                                               ))
                                ->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_order_tbl.'.buyer_id')                           
                                ->leftjoin($prefixed_transaction_tbl,$prefixed_transaction_tbl.'.order_no','=',$order_tbl_name.'.order_no')
                                ->where($order_tbl_name.'.buyer_id',$buyer_id)
                                ->orderBy($order_tbl_name.".id",'DESC');
                               //->get();
                             //  dd($obj_qutoes);
        
        
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
               
       if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
        {

            $search_orderno      = $arr_search_column['q_order_no'];
            $obj_qutoes = $obj_qutoes->where($prefixed_order_tbl.'.order_no','LIKE', '%'.$search_orderno.'%');
        }

        if(isset($arr_search_column['q_transaction_id']) && $arr_search_column['q_transaction_id']!="")
        {
            $search_transactionid   = $arr_search_column['q_transaction_id'];
            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.transaction_id','LIKE', '%'.$search_transactionid.'%');
        }
       
        if(isset($arr_search_column['q_price']) && $arr_search_column['q_price']!="")
        {
            $search_price      = $arr_search_column['q_price'];
            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.total_amount','LIKE', '%'.$search_price.'%');
        }

        if(isset($arr_search_column['q_transaction_status']) && $arr_search_column['q_transaction_status']!="")
        {  

               $search_paystatus = $arr_search_column['q_transaction_status'];
               $obj_qutoes = $obj_qutoes->where($prefixed_transaction_tbl.'.transaction_status','LIKE', '%'.$search_paystatus.'%');

        }
        //  if(isset($arr_search_column['q_order_date']) && $arr_search_column['q_order_date']!="")
        // {  

        //        $search_order_date = $arr_search_column['q_order_date'];
        //        $obj_qutoes = $obj_qutoes->where($prefixed_transaction_tbl.'.transaction_status','LIKE', '%'.$search_paystatus.'%');

        // }
        //         ->whereDate('exam_date', '>=', Carbon::now()->toDateString())

           

        $current_context = $this;

        $json_result  = Datatables::of($obj_qutoes);
        
        $json_result  = $json_result->editColumn('order_no',function($data) use ($current_context)
                        {
                           $order_no = isset($data->order_no)?$data->order_no:'';

                           // return '<a href="'.url(config('app.project.admin_panel_slug')).'/order/view/'.base64_encode($data->id).'" target="_blank">'.$order_no.'</a>';
                           return '<a href="'.url(config('app.project.admin_panel_slug')).'/order/view/'.
                           base64_encode($data->order_no).'/'.base64_encode($data->id).'" target="_blank">'.$order_no.'</a>';
                        })
                        ->editColumn('created_at',function($data) use ($current_context)
                        {
                            // return us_date_format($data->created_at);
                            return date('d M Y H:i',strtotime($data->created_at));
                        })
                       ->editColumn('total_amount',function($data) use ($current_context)
                        {
                           // return '$'.num_format($data->total_amount);
                            if($data->total_amount>0){

                                if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!='' 
                                    && isset($data->seller_discount_amt) 
                                    && $data->seller_discount_amt!='')
                                {

                                  $total_amount = (float)$data->total_amount - (float)$data->seller_discount_amt;  

                                   if(isset($data->delivery_title) && isset($data->delivery_day) && isset($data->delivery_cost) && $data->delivery_cost!='')
                                   {
                                      $total_amount = (float)$total_amount + (float)$data->delivery_cost;  
                                   }

                                   if(isset($data->tax) && $data->tax!='')
                                   {
                                      $total_amount = (float)$total_amount + (float)$data->tax;  
                                   } 


                                  $total_amount = '$'.num_format($total_amount); 
                                }
                                else
                                {
                                   $total_amount = $data->total_amount;  
                                   if(isset($data->delivery_title) && isset($data->delivery_day) && isset($data->delivery_cost) && $data->delivery_cost!='')
                                   {
                                      $total_amount = (float)$total_amount + (float)$data->delivery_cost;  
                                   }

                                   if(isset($data->tax) && $data->tax!='')
                                   {
                                      $total_amount = (float)$total_amount + (float)$data->tax;  
                                   }


                                  $total_amount = '$'.num_format($total_amount);  
                                }
                            }
                            else{
                                $total_amount = $data->total_amount;
                            }
                              return $total_amount; 


                        })

                         ->editColumn('wallet_amount_used',function($data) use ($current_context)
                        {
                            
                              $wallet_amount_used = '$'.$data->buyer_wallet_amount;
                             
                            
                             return $wallet_amount_used;
                        })


                        ->editColumn('transaction_status',function($data) use ($current_context)
                        {

                            if ($data->transaction_status == 0) 
                            {
                                return '<label class="label label-warning">Pending</label>';
                            }
                            elseif ($data->transaction_status == 1) 
                            {
                                return '<label class="label label-success">Completed</label>';
                            }
                            else
                            {
                                return '<label class="label label-danger">Failed</label>';
                            }

                        });
                       
        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
    }


    //view buyer wallet history

    public function view_buyer_wallet_history($buyer_id)
    {
       
        $buyer_id = base64_decode($buyer_id);

        $this->arr_view_data['arr_data'] = array();

        $obj_data = $this->BaseModel->whereHas('roles',function($query)
                                        {
                                            $query->where('slug','=','buyer');        
                                        })
                                    
                                    ->get();

        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }   

        /*---------Get user details---------------*/
        $arr_user = [];
        $obj_user = $this->BaseModel->where('id',$buyer_id)->first();
        
        if($obj_user)
        {
            $arr_user = $obj_user->toArray();
        }
        /*----------------------------------------*/

        $this->arr_view_data['page_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['buyer_id']        = $buyer_id;
        $this->arr_view_data['arr_user']        = $arr_user;
     
        return view($this->module_view_folder.'.wallet_history', $this->arr_view_data);
    }


   //get wallet history record
    public function get_buyer_wallet_history(Request $request,$buyer_id)
    {  
      // $buyer_id = isset($buyer_id)?base64_decode($buyer_id):'';

        $transaction_table = $this->TransactionModel->getTable();
        $prefixed_transaction_tbl = DB::getTablePrefix().$transaction_table;

        $user_tbl_name              = $this->UserModel->getTable();
        $prefixed_user_tbl          = DB::getTablePrefix().$this->UserModel->getTable();

        $order_tbl_name              = $this->OrderModel->getTable();
        $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_tbl_name      = $this->OrderProductModel->getTable();
        $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $buyer_Wallet               = $this->BuyerWalletModel->getTable();
        $prefixed_buyer_wallet_tbl  = DB::getTablePrefix().$this->BuyerWalletModel->getTable();
        

        $wallet_history_obj = DB::table($buyer_Wallet)
                             
                                ->select(DB::raw($prefixed_buyer_wallet_tbl.".*"
                                               ))
                               
                                ->where($buyer_Wallet.'.user_id',$buyer_id)
                                ->orderBy($buyer_Wallet.".id",'DESC');
        
                                   
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
          
        if(isset($arr_search_column['q_type']) && $arr_search_column['q_type']!="")
        {
            $search_term      = $arr_search_column['q_type'];
            $wallet_history_obj = $wallet_history_obj->where($buyer_Wallet.'.type','LIKE', '%'.$search_term.'%');
        }

       
        if(isset($arr_search_column['q_amount']) && $arr_search_column['q_amount']!="")
        {
            $search_amount_term   = $arr_search_column['q_amount'];
            $wallet_history_obj   = $wallet_history_obj->where($buyer_Wallet.'.amount','LIKE', '%'.$search_amount_term.'%');
        }
         if(isset($arr_search_column['q_orderno']) && $arr_search_column['q_orderno']!="")
        {
            $search_orderno_term      = $arr_search_column['q_orderno'];

            $wallet_history_obj = $wallet_history_obj->where($buyer_Wallet.'.typeid','LIKE', '%'.$search_orderno_term.'%')->where('type','OrderPlaced');
        }


           

        $current_context = $this;

        $json_result  = Datatables::of($wallet_history_obj);
        
        $json_result  = $json_result->editColumn('created_at',function($data) use ($current_context)
                        {
                            return us_date_format($data->created_at);

                        })

                        ->editColumn('amount',function($data) use ($current_context) {

                            $final_amount = $data->amount;

                               if($final_amount) 
                               {
                                    return str_replace('$-','-$','$'.num_format($final_amount)); 
                                }else{
                                   return "-"; 
                                }
 

                        })

                        ->editColumn('type',function($data) use ($current_context)
                        {
                           
                            return $type = isset($data->type)?$data->type:'N/A';
                        })
                         
                        ->editColumn('typeid',function($data) use ($current_context) {

                              $type = $data->type;
                                
                              if($type=="OrderPlaced")
                              {   
                                  if(isset($data->typeid)) 
                                  {
                                      return $data->typeid; 
                                  }
                                  else{
                                    return "-"; 
                                  }  
                              }//if OrderPlaced
                              else{
                                       
                                  return "-"; 
                              }                                
     
                         });
         
                       
        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
    }


    // function for showing orders of buyers

    public function vieworders($buyerid)
    {
        $buyer_id = base64_decode($buyerid);
       
        $obj_user = $this->UserModel->where('id',$buyer_id)
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
        // dd($arr_data);
        $this->arr_view_data['arr_data'] = $arr_data;    

        $this->arr_view_data['page_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['buyer_id']        = $buyer_id;
                

        return view($this->module_view_folder.'.showorders', $this->arr_view_data);
    }
 
    // function for showing orders of buyers
    public function get_order_details(Request $request,$buyer_id)
    {  

        $transaction_table          = $this->TransactionModel->getTable();
        $prefixed_transaction_tbl   = DB::getTablePrefix().$transaction_table;

        $user_tbl_name              = $this->UserModel->getTable();
        $prefixed_user_tbl          = DB::getTablePrefix().$this->UserModel->getTable();

        $order_tbl_name              = $this->OrderModel->getTable();
        $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_tbl_name      = $this->OrderProductModel->getTable();
        $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();




       $obj_qutoes = DB::table($order_tbl_name)
        ->select(DB::raw('SUM(total_amount) as total_amount,SUM(seller_discount_amt) as seller_discounted_amt,'.$prefixed_order_tbl.'.id as id,'.$prefixed_order_tbl.'.transaction_id,'.
            $prefixed_order_tbl.'.order_no,'.$prefixed_order_tbl.'.order_status,'.$prefixed_order_tbl.'.created_at,
              '.$prefixed_order_tbl.'.couponcode,
              '.$prefixed_order_tbl.'.seller_discount_amt,
              '.$prefixed_order_tbl.'.discount,
              '.$prefixed_order_tbl.'.delivery_title,
              '.$prefixed_order_tbl.'.delivery_cost,
               '.$prefixed_order_tbl.'.delivery_day,
               '.$prefixed_order_tbl.'.tax,
              '.$prefixed_order_tbl.'.couponid'
            ))
          ->leftjoin($prefixed_transaction_tbl,$prefixed_transaction_tbl.'.order_no','=',$prefixed_order_tbl.'.order_no')
         ->where($prefixed_order_tbl.'.buyer_id',$buyer_id)
         ->groupBy('order_no')
         ->orderBy('id','desc');
         // /->get();
        
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
               
       if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
        {

            $search_orderno      = $arr_search_column['q_order_no'];
            $obj_qutoes = $obj_qutoes->where($prefixed_order_tbl.'.order_no','LIKE', '%'.$search_orderno.'%');
        }

        if(isset($arr_search_column['q_transaction_id']) && $arr_search_column['q_transaction_id']!="")
        {
            $search_transactionid   = $arr_search_column['q_transaction_id'];
            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.transaction_id','LIKE', '%'.$search_transactionid.'%');
        }
       
        if(isset($arr_search_column['q_price']) && $arr_search_column['q_price']!="")
        {
            $search_price      = $arr_search_column['q_price'];
            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.total_amount','LIKE', '%'.$search_price.'%');
        }

        if(isset($arr_search_column['q_order_status']) && $arr_search_column['q_order_status']!="")
        {  

               $search_order_status = $arr_search_column['q_order_status'];
               $obj_qutoes = $obj_qutoes->where($prefixed_order_tbl.'.order_status','LIKE', '%'.$search_order_status.'%');

        }
       
          

        $current_context = $this;

        $json_result  = Datatables::of($obj_qutoes);
        
        $json_result  = $json_result->editColumn('created_at',function($data) use ($current_context)
                        {
                            return date('d M Y H:i',strtotime($data->created_at));

                            // return us_date_format($data->created_at);
                        })
                       ->editColumn('total_amount',function($data) use ($current_context)
                        {
                           // return '$'.num_format($data->total_amount);
                          $total_amt = 0;
                          if($data->total_amount>0)
                            {

                                if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!='' 
                                    && isset($data->seller_discounted_amt) 
                                    && $data->seller_discounted_amt!='')
                                {
                                    $total_amt =  (float)$data->total_amount - (float)$data->seller_discounted_amt; 


                                    if(isset($data->delivery_cost) && isset($data->delivery_day) && $data->delivery_day!='' && isset($data->delivery_title) && $data->delivery_cost!=''            
                                    && $data->delivery_title!='')
                                    {

                                        $deliverycost =  get_deliverycost_fromorderno($data->order_no);
                                        $total_amt =  (float)$total_amt + (float)$deliverycost; 
                                    }


                                    if(isset($data->tax) && $data->tax!='')
                                    {

                                        $taxcost =  get_taxcost_fromorderno($data->order_no);
                                        $total_amt =  (float)$total_amt + (float)$taxcost; 
                                    }



                                      return '$'.num_format($total_amt);
                                }else
                                {
                                    $total_amt = $data->total_amount;

                                    if(isset($data->delivery_cost) && isset($data->delivery_day) && $data->delivery_day!='' && isset($data->delivery_title) && $data->delivery_cost!=''            
                                    && $data->delivery_title!='')
                                    {
                                       // $total_amt =  (float)$total_amt + (float)$data->delivery_cost; 
                                       $deliverycost =  get_deliverycost_fromorderno($data->order_no);
                                       $total_amt =  (float)$total_amt + (float)$deliverycost;
                                    }


                                    if(isset($data->tax) && $data->tax!='')
                                    {
                                     
                                       $taxcost =  get_taxcost_fromorderno($data->order_no);
                                       $total_amt =  (float)$total_amt + (float)$taxcost;
                                    }


                                    return '$'.num_format($total_amt); 
                                }
                               
                            }else{
                               return "-"; 
                            }


                        })
                        ->editColumn('order_status',function($data) use ($current_context)
                        {

                            if ($data->order_status == 0) {
                                return '<label class="label label-danger">Cancelled</label>';
                            }
                            elseif ($data->order_status == 1) {
                                return '<label class="label label-success">Completed</label>';
                            }
                            else{
                                return '<label class="label label-warning">Ongoing</label>';
                            }
                        })
                         ->editColumn('order_no',function($data) use ($current_context)
                        {
                            /*$get_orderids = $this->OrderModel->select('id')
                                            ->where('order_no',$data->order_no)
                                            ->get()->toArray();

                             if(!empty($get_orderids) && count($get_orderids)>0){
                             $str=[];              
                             foreach($get_orderids as $v){
                                $str[] = base64_encode($v['id']);
                             }       
                             $ids = implode("@",$str);        
                             }else{
                                $ids = base64_encode($data->id);
                             }*/ 

                            //$orderno_href =  url('/').'/admin/order/view/'.$ids;


                            // $orderno_href =  url('/').'/admin/order/view/'.base64_encode($data->order_no);

                              $orderno_href =  url(config('app.project.admin_panel_slug')).'/order/view/'.base64_encode($data->order_no);

                            


                            $orderno_action = '<a target="_blank" href="'.$orderno_href.'" title="View Order Details">'.$data->order_no.'</a>';

                            return $orderno_action;

                        })
                         ->editColumn('build_action_btn',function($data) use ($current_context)
                        {


                            /*$get_orderids = $this->OrderModel->select('id')
                                            ->where('order_no',$data->order_no)
                                            ->get()->toArray();

                             if(!empty($get_orderids) && count($get_orderids)>0){
                             $str=[];              
                             foreach($get_orderids as $v){
                                $str[] = base64_encode($v['id']);
                             }       
                             $ids = implode("@",$str);        
                             }else{
                                $ids = base64_encode($data->id);
                             }*/
                            

                          //  $view_href =  url('/').'/admin/order/view/'.$ids;

                          // $view_href =  url('/').'/admin/order/view/'.base64_encode($data->order_no);

                           $view_href =  url(config('app.project.admin_panel_slug')).'/order/view/'.base64_encode($data->order_no);  
                            


                            $build_view_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" href="'.$view_href.'" title="View Order Details"><i class="ti-eye" ></i></a>';

                            return $build_view_action;


                        });

                        
                       
        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
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

        $role_arr = Sentinel::getRoleRepository()->where('slug','buyer')
                                            ->orWhere('slug','seller')
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

      //  $this->arr_view_data['countries_arr']                = $countries_arr;
        $this->arr_view_data['address_arr']                  = $address_arr;
        $this->arr_view_data['google_api_key_arr']           = $google_api_key_arr;
        $this->arr_view_data['page_title']                   = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title']                 = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']              = $this->module_url_path;
        $this->arr_view_data['arr_data']                     = $arr_data;
        $this->arr_view_data['role_arr']                     = $role_arr;
        $this->arr_view_data['user_profile_public_img_path'] = $this->user_profile_public_img_path;
        
        return view($this->module_view_folder.'.edit', $this->arr_view_data);
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
    
    public function save(Request $request)
    {
        $is_update         = false;
        $current_timestamp = "";

        $login_user = Sentinel::check();


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
                        'country'               => 'required',
                        'date_of_birth'         => 'required',
                        'phone'               => 'required',
                        'state'                 => 'required'
                     ];

        if($is_update == false)
        {
          //  $arr_rules['profile_image']    = 'required';
            $arr_rules['new_password']     = 'required';
            $arr_rules['confirm_password'] = 'required';
          
        }

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = "error";
            $response['description'] = "Form validation failed...please check all fields..";
            return response()->json($response);
        }

        /* Check for email duplication */
        $is_duplicate = $this->BaseModel->where('email','=',$request->input('email'));  
        
        if($is_update ==true)
        {
            $is_duplicate = $is_duplicate->where('id','<>',$user_id);
        }

        $does_exists = $is_duplicate->count();

        if($does_exists)
        {
            $response['status']      = "error";
            $response['description'] = "Email id already exists";
            return response()->json($response);
        }   


        /* Check for phone duplication */
        $is_duplicate = $this->BaseModel->where('phone','=',$request->input('phone'));  
        
        if($is_update ==true)
        {
            $is_duplicate = $is_duplicate->where('id','<>',$user_id);
        }

        $does_exists = $is_duplicate->count();

        if($does_exists)
        {
            $response['status']      = "error";
            $response['description'] = "Phone number id already exists";
            return response()->json($response);
        }
         

         /*************chk country*state**active************************/

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



        /*************chk country*state*active************************/



        $user =  Sentinel::createModel()->firstOrNew(['id' => $user_id]);
 
        
        $user->first_name       = ucfirst($request->input('first_name'));
        $user->last_name        = ucfirst($request->input('last_name'));
        $user->email            = $request->input('email');
        $user->phone            = $request->input('phone');
        $user->date_of_birth    = $request->input('date_of_birth');
        $user->user_type        = 'buyer';//buyer and seller
        $user->country          = $request->input('country');//country name store
        $user->state            = $request->input('state');//state name store
        $hasher                 = Sentinel::getHasher();
        $password               = $request->input('new_password');
        $user->street_address   = $request->input('street_address');
        $user->zipcode          = $request->input('zipcode');
        $user->city             = $request->input('city');
 
        if(isset($password) && !empty($password))
        {
            $user->password  = $hasher->hash($request->input('new_password'));
        }

     
        $user->is_active       = '1';
        $user->is_trusted      = '1';

       /* if($request->hasFile('profile_image'))
        {
            $file_extension = strtolower($request->file('profile_image')->getClientOriginalExtension());          

            if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $file_name = sha1(time().uniqid()).'.'.$file_extension;
                            
                $request->file('profile_image')->move($this->user_profile_base_img_path, $file_name);

                $user->profile_image  = $file_name;    
            }
            else
            {
                $response['status']  = 'error';
                $response['description'] = 'Please select valid profile image, only jpg,png and jpeg file are alowed';

                return response()->json($response);
            }            
            
            $obj_image = $this->BaseModel->where('id',$user_id)->first(['profile_image']);
            
            $old_img = '';

            if($obj_image)
            {
                $old_img = $obj_image->profile_image;
            }

            $unlink_old_img_path = $this->user_profile_base_img_path.'/'.$old_img;

            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } */

        if($request->hasFile('id_proof'))
        {
            $file_extension = strtolower($request->file('id_proof')->getClientOriginalExtension());          

            if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG','PDF','xlsx']))
            {                           
                $file_name = sha1(time().uniqid()).'.'.$file_extension;
                            
                $request->file('id_proof')->move($this->user_profile_base_img_path, $file_name);

                $user->id_proof  = $file_name;    
            }
            else
            {
                $response['status']      = 'error';
                $response['description'] = 'Please select valid profile image, only jpg,png and jpeg file are alowed';

                return response()->json($response);
            }            
            
            $obj_image = $this->BaseModel->where('id',$user_id)->first(['id_proof']);
            
            $old_img = '';

            if($obj_image)
            {
                $old_img = $obj_image->id_proof;
            }

            $unlink_old_img_path = $this->user_profile_base_img_path.'/'.$old_img;

            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }

        }

        $user_details     = $user->save();
        //return $user_details;

        $email            = $user->email;
        //return $email;
        
        if(isset($password) && !empty($password))
        {
            $arr_mail_data    = $this->built_mail_data($email,$password);   
            $email_status     = $this->EmailService->send_mail_section($arr_mail_data);
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

        // $profile_image = $request->file('profile_image');
        // $file_name      = "default.jpg";

        // if(isset($profile_image))
        // {
        //     /* User Proof upload */
        //     $file_extension = strtolower($request->file('profile_image')->getClientOriginalExtension()); 
        //     $file_name      = sha1(uniqid().$file_name.uniqid()).'.'.$file_extension;

        //     if($request->file('profile_image')->move($this->user_profile_base_img_path, $file_name)) 
        //     {
        //         if(isset($profile_image))
        //         {
        //             $user->profile_image  = $file_name;    
        //         }

        //         // /* Unlink the Existing file from the folder */
        //         $obj_image = $this->BaseModel->where('id',$user_id)->first(['profile_image']);
              
        //         if($obj_image)   
        //         {   
        //             $_arr = [];
        //             $_arr = $obj_image->toArray();
        //             if(isset($_arr['profile_image']) && $_arr['profile_image'] != "" )
        //             {
        //                 $unlink_path    = $this->user_profile_base_img_path.$_arr['profile_image'];
        //                 @unlink($unlink_path);
        //             }
        //         }    
        //     }
        // }

        if($user_details)
        {   
            if($is_update == false)
            {
                

                //attach buyer and seller both role to user
                $role = 'buyer';
               // $role_two = 'seller';

                //$arr_buyer['user_id']     = $user_details->id;
                
                
                

                $role_one_obj = Sentinel::findRoleBySlug($role);
                $role_one_obj->users()->attach($user);    

                 
                
            }
            // else
            // {
            //     if($request->input('user_role') == "buyer")
            //     {
            //         $arr_roles = 'buyer';
            //         $role = Sentinel::findRoleBySlug($arr_roles);

            //         $this->RoleUserModel->where('user_id',$user_id)->update(['role_id'=>$role->id]);
            //     }
            //     else if($request->input('user_role') == "seller")
            //     {
            //         $arr_roles = 'seller';
            //         $role = Sentinel::findRoleBySlug($arr_roles);

            //         $this->RoleUserModel->where('user_id',$user_id)->update(['role_id'=>$role->id]);
            //     }
            // }

            // $user->is_active      = '1';
            // if($request->input('user_role') == "buyer")
            // {
            //     $user->user_type      = 'buyer';
            // }
            // else if($request->input('user_role') == "seller")
            // {
            //     $user->user_type      = 'seller';  
            // }

            // $user->save();
                  
                    $current_timestamp =  date('Y-m-d H:i:s');
               
                    $buyer =  $this->BuyerModel->firstOrNew(['user_id' => $user->id,'sorting_order_by' => $current_timestamp]);
                    $buyer->user_id               = $user->id;
                   
                    $buyer->save();
                
                // else if($request->input('user_role') == "seller")
                // {
                    // $seller  =  $this->SellerModel->firstOrNew(['user_id' => $user_id]);
                    // $seller->user_id               = $user->id;                  
                    // $seller->save();
                // }
            
            $address_arr = [
                            'user_id'   => $user->id,
                            'street_address1' => $request->input('street_address'),
                           /* 'lat'       => $request->input('lat'),
                            'lng'       => $request->input('lng'), */
                            'post_code' => $request->input('post_code'),
                            'country_id'=> $request->input('country'),
                            'state'     => $request->input('state'),
                            'city'      => $request->input('city')
                            ];

            if($is_update==true)
            {
                $this->ShippingAddressModel->where('user_id',$user->id)->update($address_arr);                   
            }
            else
            {
                $this->ShippingAddressModel->create($address_arr);                
            }


            if($is_update==true)
            {
                
                  /*-------------------------------------------------------
                  |   Activity log Event
                  --------------------------------------------------------*/
                    
                    //save sub admin activity log 

                    if(isset($login_user) && $login_user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'EDIT';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($login_user->id)?$login_user->id:'';
                        $arr_event['message']      = $login_user->first_name.' '.$login_user->last_name.' has updated buyer '.$user->first_name.' '.$user->last_name.' .';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                  /*----------------------------------------------------------------------*/

                    $response['link']        = $this->module_url_path.'/edit/'.base64_encode($user->id);
                    $response['status']      = "success";
                    $response['description'] = "Buyer updated successfully."; 


            }else{

                  /*-------------------------------------------------------
                  |   Activity log Event
                  --------------------------------------------------------*/
                    
                  //save sub admin activity log 

                  if(isset($login_user) && $login_user->inRole('sub_admin'))
                  {
                        $arr_event                 = [];
                        $arr_event['action']       = 'ADD';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($login_user->id)?$login_user->id:'';
                        $arr_event['message']      = $login_user->first_name.' '.$login_user->last_name.' has added buyer '.$user->first_name.' '.$user->last_name.' .';

                        $result = $this->UserService->save_activity($arr_event); 
                  }

                  /*----------------------------------------------------------------------*/

                   $response['link']        = $this->module_url_path;
                   $response['status']      = "success";
                   $response['description'] = "Buyer added successfully."; 
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
            Flash::error('Please select '.str_plural($this->module_title) .' to perform multi actions');  
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem occured, while doing multi action');
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on buyers.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on buyers.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on buyers.';

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

            $buyer_name = $entity_arr['first_name'].' '.$entity_arr['last_name'];

            //Activate the user
            $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);

            //Activate the seller trade (Update is_active = 1 for seller trade)
            //$this->TradeModel->where('user_id',$id)->update(['is_active'=>'1']);

            //Get seller trades
            /*$arr_seller_trade = $this->TradeModel->where('user_id',$id)
                                      ->get()->toArray();
            $seller_trade_ids = array_column($arr_seller_trade, 'id');*/

            //Activate interested_buyers trades (update interested_buyers trade is_active = 1)
            /*$this->TradeModel->whereIn('linked_to',$seller_trade_ids)
                             ->update(['is_active'=>'1']);*/

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated buyers '.$buyer_name.'.';

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

            $buyer_name = $entity_arr['first_name'].' '.$entity_arr['last_name'];

            //deactivate the user
            $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

            //deactivate the seller trade (Update is_active = 0 for seller trade)
           /* $this->TradeModel->where('user_id',$id)->update(['is_active'=>'0']);*/

            //Get seller trades
           /* $arr_seller_trade = $this->TradeModel->where('user_id',$id)
                                      ->get()->toArray();
            $seller_trade_ids = array_column($arr_seller_trade, 'id');*/

            //deactivate interested_buyers trades (update interested_buyers trade is_active = 0)
            /*$this->TradeModel->whereIn('linked_to',$seller_trade_ids)
                             ->update(['is_active'=>'0']);*/

            if($flag==false)
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
                      $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated buyers '.$buyer_name.'.';

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

            $buyer_name = $entity_arr['first_name'].' '.$entity_arr['last_name'];

            $this->BuyerModel->where('user_id',$id)->delete();        
            $this->ShippingAddressModel->where('user_id',$id)->delete();
      
            /* Detaching Role from user Roles table */
            $user = Sentinel::findById($id);
            $role_owner     = Sentinel::findRoleBySlug('admin');
            $role_traveller = Sentinel::findRoleBySlug('buyer');
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted buyers '.$buyer_name.'.';

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

        $login_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url("/login").'">Login Now</a><br/>' ;


        $arr_built_content = [
                                'FIRST_NAME'   => $arr_user['first_name'],
                                'APP_URL'      => config('app.project.name'),
                                'LOGIN_URL'    => $login_url,
                                'EMAIL'        => $email,
                                'PASSWORD'     => $password
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
        $user = Sentinel::check();

        $user_id = base64_decode($request->user_id);
        $verification_status  = $request->status;
        
        $is_available = $this->BaseModel->where('id',$user_id)->count()>0;

        $buyer_obj = $this->BaseModel->where('id',$user_id)->first();

        $buyer_arr = $buyer_obj->toArray();

        $buyer_name = $buyer_arr['first_name'].' '.$buyer_arr['last_name'];

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
            // $status = $this->ActivationsModel->where('user_id',$user_id)->update(['completed'=>$update_field]);

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
                          $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked as trusted to the buyer '.$buyer_name.'.';

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
                          $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked as untrusted.';

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

    //start of age verification section


    public function approveage(Request $request)
    {
        $user = Sentinel::check();

        $user_id = $request->user_id;
        $age_category = $request->age_category; 
        $buyer_name = "";  

        $buyer_obj = $this->BaseModel->where('id',$user_id)->first();

        if(isset($buyer_obj))
        {
          $buyer_arr = $buyer_obj->toArray();

          $buyer_name = $buyer_arr['first_name'].' '.$buyer_arr['last_name'];
        }
        
        

        if($user_id && $age_category)
        {   
            $res_age = $this->BuyerModel->select('*')
                            ->where('user_id',$user_id)  
                            ->get();

            if(!empty($res_age) && count($res_age)>0)
            {
                $res_age = $res_age->toArray();
                  
                $approve_status = $res_age[0]['approve_status'];
                $age_address    = $res_age[0]['age_address'];
                $front_image    = $res_age[0]['front_image'];
                $back_image     = $res_age[0]['back_image'];
                $selfie_image   = $res_age[0]['selfie_image'];
                $note           = $res_age[0]['note'];
                $dbage_category = $res_age[0]['age_category'];
                $address_proof  = $res_age[0]['address_proof'];

            
                
                // if($front_image && $back_image && $age_address && $address_proof && $selfie_image)
                 if($front_image && $back_image && $selfie_image)
                {
                    if($approve_status==0 || $approve_status==3 || $approve_status==2)
                    {
                      
                        $update_data = array('age_category'=>$age_category,
                                            'approve_status'=>'1',
                                            'note'=>'',
                                            'sorting_order_by'=>NULL
                                            );
                        $res_age_update = $this->BuyerModel
                                                    ->where('user_id',$user_id)
                                                    ->update($update_data);   
                        if($res_age_update)
                        {

                            $seller_nameemail = $sellerurl ='';
                              
                            /**Send email and nofi to seller for ship age restricted orders******/
                              $get_age_orders = $this->OrderModel
                                                      ->where('buyer_id',$user_id)
                                                      ->where('buyer_age_restrictionflag','=','1')
                                                      ->where('order_status','!=','0')
                                                      ->get();

                               /*----Code for sending mail to dropshipper------------**/
                               $site_setting_arr    = [];
                               $site_setting_obj    = $this->SiteSettingModel->first();  
                               $dropshiparr         = []; 
                                if(isset($site_setting_obj))
                                {
                                    $site_setting_arr = $site_setting_obj->toArray();            
                                }

                          
                              if(isset($get_age_orders) && !empty($get_age_orders))
                              {
                                 $get_age_orders = $get_age_orders->toArray();
                                 foreach($get_age_orders as $age_orders)
                                 {
                                    /*------Start After age verification approval send mail to dropshipper----*/

                                    $address         = [];       
                                    $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$age_orders['order_no'])->first();

                                    if ($address_details) {

                                      $address['shipping']         = isset($address_details['shipping_address1'])?$address_details['shipping_address1']:'';
                                      $address['shipping_state']   = isset($address_details['state_details']['name'])?$address_details['state_details']['name']:'';
                                      $address['shipping_country'] = isset($address_details['country_details']['name'])?$address_details['country_details']['name']:'';
                                      $address['shipping_zipcode'] = isset($address_details['shipping_zipcode'])?$address_details['shipping_zipcode']:'';
                                        $address['shipping_city']  = isset($address_details['shipping_city'])?$address_details['shipping_city']:'';
                                      $address['billing']          = isset($address_details['billing_address1'])?$address_details['billing_address1']:'';
                                      $address['billing_state']    = isset($address_details['billing_state_details']['name'])?$address_details['billing_state_details']['name']:'';
                                      $address['billing_country']  = isset($address_details['billing_country_details']['name'])?$address_details['billing_country_details']['name']:'';
                                      $address['billing_zipcode']  = isset($address_details['billing_zipcode'])?$address_details['billing_zipcode']:'';
                                      $address['billing_city']     = isset($address_details['billing_city'])?$address_details['billing_city']:'';
                                    }//end if order details

                                    $product_details = $this->OrderProductModel->with('product_details')->where('order_id',$age_orders['id'])->get(); 
                                    $order_no        = $age_orders['order_no'];
                                    $userId          = $age_orders['seller_id'];



                                /*************send mail to dropshipper*********************/

                                    $setdrporderarr =[];
                                    $result = [];

                                if($product_details!=null)
                                    {
                                         $product_details = $product_details->toArray();
                                         if(isset($product_details) && !empty($product_details))
                                         {
                                              foreach($product_details as $pro)
                                              {
                                                 $is_dropshipped_product = $this->DropShipperModel->where('product_id',$pro['product_id'])->first();
                                                 if(isset($is_dropshipped_product) && !empty($is_dropshipped_product))
                                                 {  
                                                    $pro_id              =  $pro['product_id'];
                                                    $dropshipper_id      =  $is_dropshipped_product->id;

                                                    $product_data        = $this->ProductModel->where('id',$pro['product_id'])->first(); 
                                                    $product_data       = $product_data->toArray();
                                                    $setdrporderarr[$userId][$pro_id]['product_data'] = $this->ProductModel->with(['user_details','product_images_details'])->where('id',$pro['product_id'])->first();

                                              $product_name           = isset($product_data['product_name'])?$product_data['product_name']:'';
                                              $product_id            = $pro['product_id'];
                                              $setdrporderarr[$userId][$pro_id]['order_no']     = $order_no or '';
                                              $setdrporderarr[$userId][$pro_id]['product_name'] = $product_name;
                                              $setdrporderarr[$userId][$pro_id]['product_id']   = $product_id;
                                              $setdrporderarr[$userId][$pro_id]['item_qty']     = isset($pro['quantity'])?$pro['quantity']:0;
                                              $setdrporderarr[$userId][$pro_id]['seller_id']    = $userId;
                                              $setdrporderarr[$userId][$pro_id]['seller_name']  = get_seller_name($userId);
                                             
                                              $setdrporderarr[$userId][$pro_id]['unit_price']   = isset($pro['unit_price'])?$pro['unit_price']:'';
                                              $total_wholesale_price = $pro['unit_price']*$pro['quantity'];                                           
                                              $setdrporderarr[$userId][$pro_id]['total_wholesale_price']  = $total_wholesale_price;
                                              $setdrporderarr[$userId][$pro_id]['shipping_charges_sum']  = $pro['shipping_charges']; 
                                            }//end is dropshipped product 
                                          }//end foreach

                                          

                                      if(isset($setdrporderarr) && !empty($setdrporderarr))
                                     {
                                      $sn_no = 0;
                                         foreach($setdrporderarr as $key1=>$product_data)
                                         {

                                            $order = [];

                                              //$arr_email = Sentinel::findById($key1)->email;

                                             foreach($product_data as $key2=>$product)
                                             {
                                               $dropshipper_id = isset($product['product_data']['drop_shipper'])?$product['product_data']['drop_shipper']:'';  

                                               if(isset($dropshipper_id) && !empty($dropshipper_id))
                                                {

                                                  $product_name  = isset($product['product_data']['product_name'])?$product['product_data']['product_name']:'';

                                                  
                                                  $order[$key2]['order_no']     = isset($product['product_data']['order_no'])?$product['product_data']['order_no']:'';
                                                  $order[$key2]['product_name'] = $product_name;
                                                  $order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;


                                                  $order[$key2]['seller_name']  = get_seller_details($product['seller_id']);

                                                  $order[$key2]['seller_id']  = $product['seller_id'];
                                                 
                                                  $order[$key2]['shipping_charges']   = isset($product['shipping_charges'])?$product['shipping_charges']:0;

                                                  $dropinfo = get_dropshipper_info($product['product_data']['drop_shipper'],$product['product_data']['id']);
                                                    if(isset($dropinfo) && !empty($dropinfo))
                                                    {
                                                        
                                                        $order[$key2]['dropshipper']= isset($dropinfo['email'])?$dropinfo['email']:'';
                                                        $order[$key2]['dropshipperid']= isset($dropinfo['id'])?$dropinfo['id']:'';
                                                        $order[$key2]['unit_price']= $dropinfo['unit_price'];
                                                        $order[$key2]['total_wholesale_price'] = $dropinfo['unit_price']*$product['item_qty'];
                                                        $dropshiparr[] = $dropinfo['email'];

                                                   }//if dropshipinfo

                                               }
                                               else{
                                                    unset($order[$key1]);
                                               }
                                              
                                             }//foreach

                                            


                                                $seller_email = get_seller_email($age_orders['seller_id']);
                                                $sum = 0;
                                                $total_amount = 0;
                                                $shipping_charges_sum = 0;

                                              foreach ($order as $key => $order_data) 
                                              { 
                                                $sum += $order_data['total_wholesale_price'];
                                                $shipping_charges_sum += $order_data['shipping_charges'];
                                                
                                                $order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
                                              }//foreach orderarr


                                              if(isset($order) && !empty($order))
                                                {
                                                    
                                                    $sumamt = $shipping_charges_sumamt=0;
                                                    foreach($order as $key6 => $value6)
                                                    {
                                                        // $result[] = $value6;
                                                         if (in_array($value6['dropshipper'], $result))
                                                         {
                                                            $result[] = $value6;
                                                         }else{
                                                            $result[] = $value6;
                                                         }

                                                    }//foreach on order
                                                
                                                 }//if isset order array


                                                 if(isset($result) && !empty($result))
                                                 {  
                                                    $dropshipporderarr = [];
                                                    foreach($result as $k=>$v)
                                                    {
                                                        $dropshipporderarr[$v['dropshipper']][$k]['order_no'] = $v['order_no'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['product_name'] = $v['product_name'];
                                                        // $dropshipporderarr[$v['dropshipperid']][$k]['product_id'] = $v['product_id'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['item_qty'] = $v['item_qty'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['seller_name'] = $v['seller_name'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['seller_id'] = $v['seller_id'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['dropshipper'] = $v['dropshipper'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['unit_price'] = $v['unit_price'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['total_wholesale_price'] = $v['total_wholesale_price'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['shipping_charges'] = $v['shipping_charges'];


                                                    }//foreach $result
                                                 }//if isset result

                                                   if(isset($dropshipporderarr))
                                                    {   
                                                        
                                                        foreach($dropshipporderarr as $kk=>$vv)
                                                        {   
                                                            $ordsum = 0;$shipping_charges_sumord=0;
                                                            foreach($vv as $data){
                                                               
                                                                $ordsum += $data['total_wholesale_price'];
                                                                $shipping_charges_sumord += $data['shipping_charges'];  
                                                            }
                                                            
                                                        }
                                                    }  

                                                        $user =[];


                                                         if(isset($dropshipporderarr) && !empty($dropshipporderarr))
                                                        {   

                                                           foreach($dropshipporderarr as $k1=>$order)
                                                           {
                                                              $dropinfoarr = $this->DropShipperModel->where('email',$k1)->first();
                                                              if(isset($dropinfoarr) && !empty($dropinfoarr))
                                                              {
                                                                $dropinfoarr = $dropinfoarr->toArray();
                                                              }

                                                              $arr_email = $dropinfoarr['email'];
                                                              $dropship[$k1]['email_id'] = $dropinfoarr['email'];

                                                              $dropuser_info = $this->DropShipperModel->where('email',$dropship[$k1]['email_id'])->first();
                                                              if(isset($dropuser_info) && !empty($dropuser_info))
                                                              {
                                                                $dropuser_info = $dropuser_info->toArray();
                                                                $drop_sellerid = $dropuser_info['seller_id'];

                                                                $seluser_info = $this->UserModel->with('seller_detail')->where('id',$drop_sellerid)->first();
                                                                if(isset($seluser_info) && !empty($seluser_info))
                                                                {
                                                                    $seluser_info = $seluser_info->toArray();
                                                                }
                                                              } 

                                                                $user = $this->UserModel->where('id',$age_orders['buyer_id'])->first();
                                                                if(isset($user) && !empty($user))
                                                                {
                                                                    $user = $user;
                                                                }


                                                              $pdf = PDF::loadView('front/dropshipperemail_invoice',compact('order','order_no','sn_no','address','site_setting_arr','user','seluser_info'));
            

                                                               $currentDateTime = $order_no.date('H:i:s').'.pdf';
                                                            

                                                            Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
                                                            $pdfpath = Storage::url($currentDateTime);

                                                            $loggedInUserId = 0;
                                                            if ($userId = Sentinel::check()) {
                                                                
                                                                $loggedInUserId = $userId->id;
                                                            }

                                                            $dropperuser_id = $this->DropShipperModel->where('email',$dropship[$k1]['email_id'])->first();

                                                            $buyer_details = $this->UserModel->where('id',$age_orders['buyer_id'])->first();

                                                            $obj_email_template = $this->EmailTemplateModel->where('id','47')->first();

                                                            if($obj_email_template)
                                                            {
                                                                $arr_email_template = $obj_email_template->toArray();
                                                                $content = $arr_email_template['template_html'];
                                                            }
                                                            $content = str_replace("##DROPSHIPPER_NAME##",$dropperuser_id['name'],$content);
                                                            $content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
                                                            $content = str_replace("##APP_NAME##",config('app.project.name'),$content);
                                                        

                                                            $content = view('email.front_general',compact('content'))->render();
                                                            $content = html_entity_decode($content);

                                                            $file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

                                                            $to_mail_id = $dropship[$k1]['email_id'];

                                                            $send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
                                                            {

                                                                if(isset($arr_email_template) && count($arr_email_template) > 0)
                                                                {       
                                                                    $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                                                    $message->to($to_mail_id);

                                                                    $dynamicsubject = $arr_email_template['template_subject'];
                                                                    $dynamicsubject = str_replace("##order_no##",$order_no, $dynamicsubject);
                                                                   // $message->subject($arr_email_template['template_subject']);
                                                                    $message->subject($dynamicsubject);
                                                                    // $message->subject('Dropship Order');
                                                                }
                                                                else
                                                                {
                                                                    $admin_email = 'notify@chow420.com';

                                                                    $message->from($admin_email);
                                                                    $message->to($to_mail_id);
                                                                    $message->subject('Dropship Order');
                                                                }               
                                                                
                                                                $message->setBody($content, 'text/html');
                                                                $message->attach($file_to_path);
                                                                   
                                                            });
                                                            }//foreach of dropshipporderarrr
                                                         }//if isset dropshiporderarr    

                                              
                                             
                                         }//foeach orderarr

                                     }//if isset setorders
                                     
                                   }//if isset prodcut details

                                 }//product details not null  

                                /**********end of***send mail to dropshipper*********************/

                                    

                                /********send email to seller*for order place**********/

                                 $setorderarr = []; $user=[];

                                 $dbseller_id         = $age_orders['seller_id'];
                                  
                                   if(isset($product_details) && !empty($product_details))
                                   {

                                     foreach($product_details as $pro)
                                     {

                                        $dbproduct_id         = $pro['product_id'];

                                              $product_data      = $this->ProductModel->where('id',$pro['product_id'])->first(); 
                                              $product_data           = $product_data->toArray();

                                              $setorderarr[$dbseller_id][$dbproduct_id]['product_data'] = $this->ProductModel->with(['user_details','product_images_details'])->where('id',$pro['product_id'])->first();

                                              $product_name           = isset($product_data['product_name'])?$product_data['product_name']:'';
                                              $product_id            = $pro['product_id'];
                                              $setorderarr[$dbseller_id][$dbproduct_id]['order_no']     = $order_no or '';
                                              $setorderarr[$dbseller_id][$dbproduct_id]['product_name'] = $product_name;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['product_id']   = $product_id;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['item_qty']     = isset($pro['quantity'])?$pro['quantity']:0;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['seller_id']    = $user_id;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['seller_name']  = get_seller_name($user_id);
                                             
                                              $setorderarr[$dbseller_id][$dbproduct_id]['unit_price']   = isset($pro['unit_price'])?$pro['unit_price']:'';
                                              $total_wholesale_price = $pro['unit_price']*$pro['quantity'];                                           
                                              $setorderarr[$dbseller_id][$dbproduct_id]['total_wholesale_price']  = $total_wholesale_price;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['shipping_charges_sum']  = $pro['shipping_charges']; 


                                     }//foreach

                                     if(isset($setorderarr) && !empty($setorderarr))
                                     {
                                      $sn_no = 0;
                                         foreach($setorderarr as $key1=>$product_data)
                                         {

                                            $order = [];

                                              //$arr_email = Sentinel::findById($key1)->email;
                                              $arr_email = get_seller_email($key1);
                                            $seller[$key1]['seller_id'] = Sentinel::findById($key1);


                                             /***********************couponcode*start****************/
        
        $seller_couponcode = $seller_coupontype = '';
        $calculated_discountamt = $seller_ordertotal =$seller_totalall_amt =$seller_coupondiscount=0;
    
        $order_coupondata =  $order_deliveryoptiondata = $seller_taxarr = [];

        $get_orderdetailcoupondata = $this->OrderModel->where('order_no',$order_no)->where('seller_id',$key1)->first();   
      
      if(isset($get_orderdetailcoupondata) && !empty($get_orderdetailcoupondata))
      {
        $get_orderdetailcoupondata = $get_orderdetailcoupondata->toArray();

        $order_id = isset($get_orderdetailcoupondata['id'])?$get_orderdetailcoupondata['id']:'';

        $get_orderproducts = $this->OrderProductModel->where('order_id',$order_id)->sum('shipping_charges');

        $seller_couponcode = isset($get_orderdetailcoupondata['couponcode'])?$get_orderdetailcoupondata['couponcode']:'';
        $seller_coupondiscount = isset($get_orderdetailcoupondata['discount'])?$get_orderdetailcoupondata['discount']:'0';
        $seller_coupontype = isset($get_orderdetailcoupondata['coupontype'])?$get_orderdetailcoupondata['coupontype']:''; 


        // $seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']:'';

        if(isset($get_orderproducts) && !empty($get_orderproducts))
        {
          $seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']-$get_orderproducts:'';
        }
        else{
          $seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']:''; 
        }


        if(isset($seller_ordertotal) && $seller_ordertotal>0 && isset($seller_coupondiscount) && $seller_coupondiscount>0){
           $calculated_discountamt = $seller_ordertotal*$seller_coupondiscount/100;
        }


        if(isset($seller_couponcode) && isset($seller_coupondiscount) && isset($seller_coupontype) && isset($calculated_discountamt))
        {
            $order_coupondata[$key1]['couponcode'] = $seller_couponcode;
            $order_coupondata[$key1]['discount'] = $seller_coupondiscount;
            $order_coupondata[$key1]['seller_coupontype'] = $seller_coupontype;
            $order_coupondata[$key1]['seller_ordertotal'] = $seller_ordertotal;
            $order_coupondata[$key1]['seller_discount_amt'] = $calculated_discountamt;
            $order_coupondata[$key1]['sellername'] = get_seller_details($key1);
            $seller_totalall_amt += $order_coupondata[$key1]['seller_discount_amt'];
         }//if isseet


          // code for getting delivery option data

         $delivery_title   = isset($get_orderdetailcoupondata['delivery_title'])?$get_orderdetailcoupondata['delivery_title']:'';
           $delivery_cost    = isset($get_orderdetailcoupondata['delivery_cost'])?$get_orderdetailcoupondata['delivery_cost']:'';
         $delivery_day     = isset($get_orderdetailcoupondata['delivery_day'])?$get_orderdetailcoupondata['delivery_day']:'';
         $delivery_option_id = isset($get_orderdetailcoupondata['delivery_option_id'])?$get_orderdetailcoupondata['delivery_option_id']:'';

          $delivery_date = isset($get_orderdetailcoupondata['created_at'])?$get_orderdetailcoupondata['created_at']:'';


          if(isset($delivery_title) && isset($delivery_cost) && isset($delivery_day) && isset($delivery_option_id))
        {
          $order_deliveryoptiondata[$key1]['delivery_option_id'] = $delivery_option_id;
          $order_deliveryoptiondata[$key1]['delivery_day'] = $delivery_day;
          $order_deliveryoptiondata[$key1]['delivery_title'] = $delivery_title;
          $order_deliveryoptiondata[$key1]['delivery_cost'] = $delivery_cost;
          $order_deliveryoptiondata[$key1]['sellername'] = get_seller_details($key1);
          $order_deliveryoptiondata[$key1]['delivery_date'] = isset($delivery_date)?$delivery_date:'';


        }//if isset delivery_title

         // code for getting tax data

         $tax   = isset($get_orderdetailcoupondata['tax'])?$get_orderdetailcoupondata['tax']:'';
         if(isset($tax) && !empty($tax))
         {
           $seller_taxarr[$key1]['tax'] = $tax;
           $seller_taxarr[$key1]['sellername'] = get_seller_details($key1);
         }


         $get_wallet_data = $this->BuyerWalletModel->where('id',$get_orderdetailcoupondata['buyer_wallet_id'])->first();

         if(isset($get_wallet_data))
         {

           $get_wallet_data = $get_wallet_data->toArray();

           $wallet_amount_used = isset($get_wallet_data['amount'])?$get_wallet_data['amount']:'';
         }//get_wallet_data


        

      }// get orderdetail coupondata

      

      /*********************couponcode*end********************************/  






                                             foreach($product_data as $key2=>$product)
                                             {
                                                  $product_name  = isset($product['product_data']['product_name'])?$product['product_data']['product_name']:'';
                                                  $order[$key2]['order_no']     = isset($product['product_data']['order_no'])?$product['product_data']['order_no']:'';
                                                  $order[$key2]['product_name'] = $product_name;
                                                  $order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;

                                                  $order[$key2]['shipping_type']      = isset($product['shipping_type'])?$product['shipping_type']:0;
                                                  $order[$key2]['shipping_charges']   = isset($product['shipping_charges'])?$product['shipping_charges']:0;


                                                  $order[$key2]['seller_name']  = get_seller_name($product['seller_id']);

                                                  $dropinfo = $this->DropShipperModel->where('product_id',$product['product_id'])->first();
                                                  if($dropinfo!=null)
                                                  {

                                                      $dropinfo = $dropinfo->toArray();
                                                      if(isset($dropinfo) && !empty($dropinfo))
                                                      {  
                                                          $order[$key2]['dropshipper']= isset($dropinfo['email'])?$dropinfo['email']:'';
                                                          $order[$key2]['unit_price']= $dropinfo['product_price'];
                                                          $order[$key2]['total_wholesale_price'] = $dropinfo['product_price']*$product['item_qty'];
                                                          $dropshiparr[] = $dropinfo['email'];
                                                      }
                                                 }  

                                                 if($product['product_data']['shipping_type']==1)
                                                {
                                                  $order[$key2]['shipping_charges']   = isset($product['product_data']['shipping_charges'])?$product['product_data']['shipping_charges']:0;
                                                }else{

                                                  $order[$key2]['shipping_charges']   = 0;
                                                } 

                                                 
                                                  $order[$key2]['unit_price']= isset($product['unit_price'])?$product['unit_price']:0;

                                                  $order[$key2]['total_wholesale_price'] = $product['unit_price']*$product['item_qty'];
                                                    
                                              
                                                  // $order[$key2]['shipping_charges']   = isset($product['shipping_charges'])?$product['shipping_charges']:0;
                                             }//foreach

                                                $seller[$key1]['email_id'] = $arr_email;


                                                $sum = 0;
                                                $total_amount = 0;
                                                $shipping_charges_sum = 0;

                                              foreach ($order as $key => $order_data) 
                                              { 
                                                $sum += $order_data['total_wholesale_price'];
                                                $shipping_charges_sum += $order_data['shipping_charges'];
                                                
                                                $order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
                                              }//foreach orderarr

                                              $seluser_info = $this->UserModel->where('email',
                                                $arr_email)->with('seller_detail')->first();

                                              $user = $this->UserModel->where('id',$age_orders['buyer_id'])->first();
                                                                if(isset($user) && !empty($user))
                                                                {
                                                                    $user = $user;
                                                                }

                                              

                                               $pdf = PDF::loadView('front/seller_invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address','site_setting_arr','user','seluser_info','order_coupondata','seller_totalall_amt','order_deliveryoptiondata','wallet_amount_used','seller_taxarr'));

                                             
                                                  $currentDateTime = $order_no.date('H:i:s').'.pdf';
      

                                                  Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
                                                    $pdfpath = Storage::url($currentDateTime);

                                                   $selleruser = $this->UserModel->where('email',
                                                     $arr_email)->first();

                                                  $buyer_details = $this->UserModel->where('id',$age_orders['buyer_id'])->first();

                                                  $obj_email_template = $this->EmailTemplateModel->where('id','36')->first();

                                                   if($obj_email_template)
                                                  {
                                                    $arr_email_template = $obj_email_template->toArray();
                                                    $content = $arr_email_template['template_html'];
                                                  }
                                                   $content = str_replace("##SELLER_NAME##",
                                                    $selleruser['first_name'].' '.$selleruser['last_name'],$content);
                                                  $content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
                                                  $content = str_replace("##APP_NAME##",config('app.project.name'),$content);
                                                  

                                                   $content = view('email.front_general',compact('content'))->render();
                                                    $content = html_entity_decode($content);

                                                   $file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

                                                   $to_mail_id = get_seller_email($key1);
                                                   $send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
                                                    {
                                                        
                                                      if(isset($arr_email_template) && count($arr_email_template) > 0)
                                                      {   
                                                        $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                                          $message->to($to_mail_id);

                                                          $dynamicsubject = str_replace("##order_no##", $order_no, $arr_email_template['template_subject']);
                                                    $message->subject($dynamicsubject);
                                                       // $message->subject($arr_email_template['template_subject']);
                                                      }
                                                      else
                                                      {
                                                        $admin_email = 'notify@chow420.com';

                                                        $message->from($admin_email);
                                                          $message->to($to_mail_id);
                                                        $message->subject('New Order '.$order_no.' Placed');
                                                      }             
                                                        
                                                    $message->setBody($content, 'text/html');
                                                    $message->attach($file_to_path);
                                                       
                                                    });
                                         }//foeach

                                     }//if isset setorders

                                   }//if isset prodcut details

                                /****************end send email to seller******/

                                /********send email to dropship seller for order place**********/

                                 $setdrporderarr = []; $user=[];

                                 $dropseller_id         = $age_orders['seller_id'];
                                  
                                   if(isset($product_details) && !empty($product_details))
                                   {

                                     foreach($product_details as $pro)
                                     {

                                        $is_dropshipped_product = $this->DropShipperModel->where('product_id',$pro['product_id'])->first();

                                        if($is_dropshipped_product!=null)
                                        {
                                              $dropproduct_id      = $pro['product_id'];

                                              $product_data      = $this->ProductModel->where('id',$pro['product_id'])->first(); 
                                              $product_data           = $product_data->toArray();

                                              $setorderarr[$dropseller_id][$dropproduct_id]['product_data'] = $this->ProductModel->with(['user_details','product_images_details'])->where('id',$pro['product_id'])->first();

                                              $product_name           = isset($product_data['product_name'])?$product_data['product_name']:'';
                                              $product_id            = $pro['product_id'];
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['order_no']     = $order_no or '';
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['product_name'] = $product_name;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['product_id']   = $product_id;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['item_qty']     = isset($pro['quantity'])?$pro['quantity']:0;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['seller_id']    = $user_id;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['seller_name']  = get_seller_name($user_id);
                                             
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['unit_price']   = isset($pro['unit_price'])?$pro['unit_price']:'';
                                              $total_wholesale_price = $pro['unit_price']*$pro['quantity'];                                           
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['total_wholesale_price']  = $total_wholesale_price;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['shipping_charges_sum']  = $pro['shipping_charges']; 
                                        }//if dropshipped product     
                                     }//foreach

                                     if(isset($setdrporderarr) && !empty($setdrporderarr))
                                     {
                                      $sn_no = 0;
                                         foreach($setdrporderarr as $key1=>$product_data)
                                         {

                                            $order = [];

                                              //$arr_email = Sentinel::findById($key1)->email;
                                              $arr_seller_email = get_seller_email($key1);
                                            $seller[$key1]['seller_id'] = Sentinel::findById($key1);

                                             foreach($product_data as $key2=>$product)
                                             {
                                                  $product_name  = isset($product['product_name'])?$product['product_name']:'';
                                                  $order[$key2]['order_no']     = isset($product['product_data']['order_no'])?$product['product_data']['order_no']:'';
                                                  $order[$key2]['product_name'] = $product_name;
                                                  $order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;


                                                  $order[$key2]['seller_name']  = get_seller_name($product['seller_id']);

                                                 
                                                  $order[$key2]['unit_price']= isset($product['unit_price'])?$product['unit_price']:0;

                                                  $order[$key2]['total_wholesale_price'] = $product['unit_price']*$product['item_qty'];
                                                    
                                              
                                                  $order[$key2]['shipping_charges']   = isset($product['shipping_charges'])?$product['shipping_charges']:0;

                                                  $order[$key2]['shipping_type']      = isset($product['shipping_type'])?$product['shipping_type']:0;

                                                  $dropinfo = $this->DropShipperModel->where('product_id',$product['product_id'])->first();
                                                  if($dropinfo!=null)
                                                  {

                                                      $dropinfo = $dropinfo->toArray();
                                                      if(isset($dropinfo) && !empty($dropinfo))
                                                      {  
                                                          $order[$key2]['dropshipper']= isset($dropinfo['email'])?$dropinfo['email']:'';
                                                          $order[$key2]['unit_price']= $dropinfo['product_price'];
                                                          $order[$key2]['total_wholesale_price'] = $dropinfo['product_price']*$product['item_qty'];
                                                          $dropshiparr[] = $dropinfo['email'];
                                                      }
                                                 }  

                                                 if($order[$key2]['shipping_type']==1)
                                                {
                                                  $order[$key2]['shipping_charges']   = isset($product['product_data']['shipping_charges'])?$product['product_data']['shipping_charges']:0;
                                                }else{

                                                  $order[$key2]['shipping_charges']   = 0;
                                                } 

                                             }//foreach

                                                $seller[$key1]['email_id'] = $arr_seller_email;


                                                $sum = 0;
                                                $total_amount = 0;
                                                $shipping_charges_sum = 0;

                                              foreach ($order as $key => $order_data) 
                                              { 
                                                $sum += $order_data['total_wholesale_price'];
                                                $shipping_charges_sum += $order_data['shipping_charges'];
                                                
                                                $order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
                                              }//foreach orderarr

                                              $seluser_info = $this->UserModel->where('email',
                                                $arr_seller_email)->with('seller_detail')->first();

                                              $user = $this->UserModel->where('id',$age_orders['buyer_id'])->first();
                                                  if(isset($user) && !empty($user))
                                                  {
                                                      $user = $user;
                                                  }

                                              
                                                $pdf = PDF::loadView('front/dropship_invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address','site_setting_arr','user','seluser_info'));
                                                  $currentDateTime = $order_no.date('H:i:s').'.pdf';
      

                                                  Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
                                                    $pdfpath = Storage::url($currentDateTime);

                                                   $selleruser = $this->UserModel->where('email',
                                                     $arr_seller_email)->first();

                                                  $buyer_details = $this->UserModel->where('id',$age_orders['buyer_id'])->first();

                                                  $obj_email_template = $this->EmailTemplateModel->where('id','110')->first();

                                                   if($obj_email_template)
                                                  {
                                                    $arr_email_template = $obj_email_template->toArray();
                                                    $content = $arr_email_template['template_html'];
                                                  }
                                                   $content = str_replace("##SELLER_NAME##",
                                                    $selleruser['first_name'].' '.$selleruser['last_name'],$content);
                                                   $content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
                                                   $content = str_replace("##BUSINESS_NAME##",$seluser_info['seller_detail']['business_name'],$content);
                                                   $content = str_replace("##APP_NAME##",config('app.project.name'),$content);
                                                  

                                                   $content = view('email.front_general',compact('content'))->render();
                                                    $content = html_entity_decode($content);

                                                   $file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

                                                   $to_mail_id = get_seller_email($key1);
                                                   $send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
                                                    {
                                                        
                                                      if(isset($arr_email_template) && count($arr_email_template) > 0)
                                                      {   
                                                         $seluser_info = $this->UserModel->where('email',
                                                         $to_mail_id)->with('seller_detail')->first();

                                                        $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                                          $message->to($to_mail_id);

                                                          $dynamicsubject = str_replace("##order_no##", $order_no, $arr_email_template['template_subject']);
                                                          $dynamicsubject  = str_replace('##BUSINESS_NAME##',$seluser_info['seller_detail']['business_name'],$dynamicsubject);  
                                                    $message->subject($dynamicsubject);
                                                       // $message->subject($arr_email_template['template_subject']);
                                                      }
                                                      else
                                                      {
                                                        $admin_email = 'notify@chow420.com';

                                                        $message->from($admin_email);
                                                          $message->to($to_mail_id);
                                                        $message->subject('New Order '.$order_no.' Placed');
                                                      }             
                                                        
                                                    $message->setBody($content, 'text/html');
                                                    $message->attach($file_to_path);
                                                       
                                                    });
                                           
                                             
                                         }//foeach

                                     }//if isset setorders
                                     
                                   }//if isset prodcut details

                                /****************end send email to dropship seller******/


                                    $sellerid = $age_orders['seller_id'];
                                    $order_no = $age_orders['order_no'];
                                    $order_id = $age_orders['id'];
                                    $admin_id = get_admin_id();

                                    $seller_obj = $this->BaseModel->where('id',$sellerid)->first();

                                    if(isset($seller_obj))
                                    {
                                      $seller_arr = $seller_obj->toArray();

                                      $seller_nameemail = $seller_arr['first_name'].' '.$seller_arr['last_name'];
                                    }
                                    $sellerurl = url('/').'/seller/order/view/'.base64_encode($order_id);


                                    //send noti
                                    $arr_event                 = [];
                                    $arr_event['from_user_id'] = $admin_id;
                                    $arr_event['to_user_id']   = $sellerid;
                                    $arr_event['description']  = 'Customer age-verification has been approved, you can now ship order <a href='.$sellerurl.'>'.$order_no.' </a> . Please login and go to your ongoing orders to fulfill this order.';
                                    $arr_event['title']        = 'Ship order '.$order_no.'';
                                    $arr_event['type']         = 'admin';   

                                    $this->GeneralService->save_notification($arr_event);

                                    //send email
                                     $arr_built_content = [
                                        'USER_NAME'     => $seller_nameemail,
                                        'APP_NAME'      => config('app.project.name'),
                                       /* 'MESSAGE'       => $msg,*/
                                        'ORDER_NO'      => $order_no,
                                        'SELLER_URL'    => $sellerurl
                                    ];

                                    $arr_built_subject =  [
                                                           'ORDER_NO'      => $order_no
                                                        ];    

                                    $arr_mail_data['email_template_id'] = '135';
                                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                                    $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                    $arr_mail_data['user']              = Sentinel::findById($sellerid);
                                    $this->EmailService->send_mail_section_order($arr_mail_data);


                                 }//foreach
                              }//if get age orders                       
                            /**end Send email and nofi to seller for ship age restricted orders**/

                            /*************get age restricted orders*and update flag*****/
                              $get_agerestrictedorders = $this->OrderModel
                                                      ->where('buyer_id',$user_id)
                                                      ->where('buyer_age_restrictionflag','=','1')
                                                      ->get();
                              if(isset($get_agerestrictedorders) && !empty($get_agerestrictedorders))
                              {
                                $get_agerestrictedorders = $get_agerestrictedorders->toArray();
                                foreach($get_agerestrictedorders as $age_orders)
                                {
                                  $order_id = $age_orders['id'];

                                  $update_orderageflag = [];
                                  $update_orderageflag['buyer_age_restrictionflag'] = 0;
                                  $this->OrderModel->where('id',$order_id)
                                                   ->where('buyer_id',$user_id)
                                                   ->update($update_orderageflag);

                                }//foreach
                              } //if age restricted orders                        
                            /**********end of get age restricted orders*and update flag********/ 


                            /*Delete Age Proof Images (START)*/
                               
                            $front_image_file  = $this->id_proof_base_path.$front_image;
                            $back_image_file   = $this->id_proof_base_path.$back_image;
                            $selfie_image_file = $this->id_proof_base_path.$selfie_image;
                            $addrproof_file = $this->id_proof_base_path.$address_proof;
                            
                            if($front_image_file)
                            {
                              $this->unlink_image($front_image_file,$front_image);

                            }
                            if($back_image_file)
                            {
                              $this->unlink_image($back_image_file,$back_image);

                            }
                            if($selfie_image_file){
                                $this->unlink_image($selfie_image_file,$selfie_image);

                            }
                            if($addrproof_file){
                               $this->unlink_image($addrproof_file,$address_proof);

                            }


                            /*Delete Age Proof Images (END)*/



                            /*******send noti to admin for age verification******/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                            
                            $url   = url('/').'/buyer/age-verification';

                            /*****************Send Notification to Admin START****************/
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $from_user_id;
                                $arr_event['to_user_id']   = $user_id;
                                $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>approved</b> the id proof of <a target="_blank" href="'.$url.'"><b>age verification</b></a>.');
                                $arr_event['type']         = '';
                                $arr_event['title']        = 'Age verification details approved';
                                $this->GeneralService->save_notification($arr_event);
                            /***************Send Notification to Admin END*********************/   

                           
                            /*****************Mail to Buyer Start************************/
                            
                        
                            /***************Send Notification Mail to Buyer (START)**************************/
                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
                            $email   = isset($to_user->email)?$to_user->email:'';
                            $full_name = "";
                            if(isset($f_name) && !empty($f_name) && isset($l_name) && !empty($l_name))
                            {  
                              $full_name = $f_name.' '.$l_name;
                            }
                            else
                            {
                               $full_name = $email;
                            }

                           /* $msg     =  html_entity_decode( config('app.project.admin_name').' has approved the id proof of age verification.');*/

                            //$subject = 'Age verification details approved';

                            $arr_built_content = ['BUYER_NAME'    => $full_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '39';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                            /*********************Send Notification Mail to Buyer (END)*****************/

                           /********************Mail to Buyer End***********************/

                              /*-------------------------------------------------------
                              |   Activity log Event
                              --------------------------------------------------------*/
                                
                                //save sub admin activity log 

                                if(isset($user) && $user->inRole('sub_admin'))
                                {
                                    $arr_event                 = [];
                                    $arr_event['action']       = 'AGE VERIFY';
                                    $arr_event['title']        = $this->module_title;
                                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' age verification details has approved of buyer '.$buyer_name.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                              /*----------------------------------------------------------------------*/

                              $response['status']      = 'SUCCESS';
                              $response['description'] = 'Age verification details has approved.'; 
                              return response()->json($response);   
                        }            

                    }
                    else if($approve_status==1)
                    {

                        $response['status']      = 'ERROR';
                        $response['description'] = 'Age verification details already approved'; 
                        return response()->json($response);   
                    }

                }
                else
                {
                    $response['status']      = 'ERROR';
                    $response['description'] = 'Please upload front side,back side image and age address'; 
                } 

            }// if age data
        }
    }//end of function

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
                                  'ADMIN_NAME' => config('app.project.admin_name'),  
                                  'BUYER_NAME' => $arr_user['first_name'].' '.$arr_user['last_name'],
                                  'EMAIL'      => $arr_user['email'],
                                  'SITE_URL'   => config('app.project.name')];

            $arr_mail_data                      = [];
            $arr_mail_data['email_template_id'] = '39';
            $arr_mail_data['arr_built_content'] = $arr_built_content;
            $arr_mail_data['user']              = $arr_user;
            return $arr_mail_data;
        }
        return FALSE;
    }



    public function rejectage(Request $request)
    {
        $user = Sentinel::check();

        $user_id = $request->user_id;
        $note    = $request->note;
        $buyer_name = "";

        $buyer_obj = $this->BaseModel->where('id',$user_id)->first();

        if(isset($buyer_obj))
        {
          $buyer_arr = $buyer_obj->toArray();

          $buyer_name = $buyer_arr['first_name'].' '.$buyer_arr['last_name'];
        }
        


        if($user_id && $note)
        {    
            $res_age = $this->BuyerModel->select('*')
                            ->where('user_id',$user_id)  
                            ->get();

             if(!empty($res_age) && count($res_age)>0)
             {
                $res_age = $res_age->toArray();

                $approve_status = $res_age[0]['approve_status'];
                $age_address = $res_age[0]['age_address'];
                $front_image = $res_age[0]['front_image'];
                $back_image = $res_age[0]['back_image'];
               // $note =     $res_age[0]['note'];


                if($approve_status=='0' || $approve_status=='3' || $approve_status=='1')
                {   

                
                    $res_age_update = $this->BuyerModel
                                    ->where('user_id',$user_id)
                                    ->update(['approve_status'=>'2','note'=>$note,'sorting_order_by'=>NULL]);   
                    if($res_age_update)
                    {

                        $url     = url('/').'/buyer/age-verification';
                        /*********************Send Notification to Buyer (START)********************/
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
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>rejected</b> the id proof of <a target="_blank" href="'.$url.'"><b>age verification</b></a>.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Age verification rejected';
                            $this->GeneralService->save_notification($arr_event);

                        /*******************Send Notification to Buyer (END)****************************/

                        /***************Send Notification Mail to Buyer (START)**************************/
                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
                            $email   = isset($to_user->email)?$to_user->email:'';
                            $full_name = "";
                            if(isset($f_name) && !empty($f_name) && isset($l_name) && !empty($l_name))
                            {  
                              $full_name = $f_name.' '.$l_name;
                            }
                            else
                            {
                               $full_name = $email;
                            }

                          /*  $msg     = html_entity_decode(config('app.project.admin_name').' has rejected your age verification id proof. <br>
                                    <b>Reason:</b> '.$note.'');*/

                            
                            //$subject = 'Age Proof Verification Rejection';

                            $arr_built_content = ['BUYER_NAME'    => $full_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'REASON'        => $note,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '88';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*********************Send Notification Mail to Buyer (END)*****************/


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
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' age verification details has rejected of buyer '.$buyer_name.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

             
                            /*----------------------------------------------------------------------*/



                          $response['status']      = 'SUCCESS';
                          $response['description'] = 'Age verification details has rejected.'; 
                          return response()->json($response);   
                    }            


                }else if($approve_status==2){

                      $response['status']      = 'ERROR';
                      $response['description'] = 'Age verification already rejected'; 
                      return response()->json($response);   
                }
             }
        }
   
    }//end of reject



    public function savecategoryage(Request $request)
    {
        $user = Sentinel::check();

        $user_id = $request->user_id;
        $age_category = $request->age_category;
        if($user_id && $age_category)
        {    $res_age = $this->BuyerModel->select('*')
                            ->where('user_id',$user_id)  
                            ->get();

             if(!empty($res_age) && count($res_age)>0)
             {
                $res_age = $res_age->toArray();

                $approve_status = $res_age[0]['approve_status'];
                $age_address = $res_age[0]['age_address'];
                $front_image = $res_age[0]['front_image'];
                $back_image = $res_age[0]['back_image'];
                $note =     $res_age[0]['note'];
                $dbage_category = $res_age[0]['age_category'];
                $address_proof = $res_age[0]['address_proof'];


                // if($approve_status=='1' && $front_image && $back_image && $address_proof && $age_address!="")
                if($approve_status=='1' && $front_image && $back_image)
                {   

                    $update_data = array('age_category'=>$age_category);
                    $res_age_update = $this->BuyerModel
                                    ->where('user_id',$user_id)
                                    ->update($update_data);   


                    if($res_age_update)
                    {
                          

                          /*-------------------------------------------------------
                          |   Activity log Event
                          --------------------------------------------------------*/
                            
                             //save sub admin activity log 

                              if(isset($user) && $user->inRole('sub_admin'))
                              {
                                  $arr_event                 = [];
                                  $arr_event['action']       = 'SET';
                                  $arr_event['title']        = $this->module_title;
                                  $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has set age category.';

                                  $result = $this->UserService->save_activity($arr_event); 
                              }

                            


                          /*----------------------------------------------------------------------*/

                          $response['status']      = 'SUCCESS';
                          $response['description'] = 'Age category set successfully.'; 
                          return response()->json($response);   
                    }            


                }
                /*else if($approve_status=='1'){

                      $response['status']      = 'ERROR';
                      $response['description'] = 'Age category already set'; 
                      return response()->json($response);   
                }*/
             }
        }
   
    }//end of save



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
                                    $url     = url('/').'/buyer/profile';
                                    
                                    /*******Send Notification to User(START)***************/

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
                                        $arr_event['description']  = html_entity_decode(config('app.project.admin_name').' has <b>approved</b> your <a target="_blank" href="'.$url.'"><b>profile details</b></a>.');
                                        $arr_event['type']         = '';
                                        $arr_event['title']        = 'Profile Details Approval';
                                        $this->GeneralService->save_notification($arr_event);

                                    /************Send Notification to User(END)*****************/

                                    /*********Send Notification Mail to User (START)*****************/
                                        $to_user = Sentinel::findById($user_id);

                                        $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                                        $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
                                        $email   = isset($to_user->email)?$to_user->email:'';
                                        $full_name = "";
                                        if(isset($f_name) && !empty($f_name) && isset($l_name) && !empty($l_name))
                                        {  
                                          $full_name = $f_name.' '.$l_name;
                                        }
                                        else
                                        {
                                           $full_name = $email;
                                        }

                                        /*$msg     = html_entity_decode(config('app.project.admin_name').' has approved your profile details.');
                                       
                                        $subject = 'Profile Details Approval';*/

                                        $arr_built_content = ['BUYER_NAME'    => $full_name,
                                                              'APP_NAME'      => config('app.project.name'),
                                                              //'MESSAGE'       => $msg,
                                                              'ADMIN_NAME'    => config('app.project.admin_name'),
                                                              'URL'           => $url
                                                             ];

                                        $arr_mail_data['email_template_id'] = '89';
                                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                                        $arr_mail_data['arr_built_subject'] = '';
                                        $arr_mail_data['user']              = Sentinel::findById($user_id);

                                        $this->EmailService->send_mail_section($arr_mail_data);

                                    /**********Send Notification Mail to User (END)***************/

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
                                              $arr_event['message']      = $user->first_name.' '.$user->last_name.' has approved profile details of buyer '.$full_name.'.';

                                              $result = $this->UserService->save_activity($arr_event); 
                                          }

                                  
                                    /*----------------------------------------------------------------------*/


                                    $response['status']      = 'SUCCESS';
                                    $response['description'] = 'Profile details approved successfully'; 
                                    return response()->json($response);   
                                }            


                        }else if($approve_status==1){

                              $response['status']      = 'ERROR';
                              $response['description'] = 'Profile details already approved'; 
                              return response()->json($response);   
                        }

               

             }// if age data
        }
    }//end of function of approve profile



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
                        $url     = url('/').'/buyer/profile';
                        /*******Send Notification to Buyer (START)*********************/
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
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>rejected</b> your <a target="_blank" href="'.$url.'"><b>profile details</b></a>.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Profile Details Rejection';
                            $this->GeneralService->save_notification($arr_event);

                        /*****Send Notification to Buyer (END)*****************************/

                        /*****Send Notification to Buyer (START)*********************************/
                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
                            $email   = isset($to_user->email)?$to_user->email:'';
                            $full_name = "";
                            if(isset($f_name) && !empty($f_name) && isset($l_name) && !empty($l_name))
                            {  
                              $full_name = $f_name.' '.$l_name;
                            }
                            else
                            {
                               $full_name = $email;
                            }

                           /* $msg     = html_entity_decode(config('app.project.admin_name').' has rejected your profile details. <br> <b>Reason:</b> '.$note.'');

                            
                            $subject = 'Profile Details Rejection';*/

                            $arr_built_content = ['BUYER_NAME'    => $full_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'REASON'        => $note,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '91';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*****Send Notification to Buyer (END) **********************************/

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
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has rejected profile details of buyer '.$full_name.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                        
                          /*----------------------------------------------------------------------*/


                          $response['status']      = 'SUCCESS';
                          $response['description'] = 'Profile details rejected.'; 
                          return response()->json($response);   
                    }            


                }else if($approve_status==2){

                      $response['status']      = 'ERROR';
                      $response['description'] = 'Profile details already rejected'; 
                      return response()->json($response);   
                }
             }
        }
   
    }//end of reject profile


    public function unlink_image($image_file,$img)
    {   
      
        if($img && file_exists(base_path().'/uploads/id_proof/'.$img))
        {       
            chmod($image_file, 0777);          
            unlink($image_file);
            return true;
        }
        else
        {
            return false;
        }
    }//end function unlink image





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

                            $arr_built_content = ['BUYER_NAME'    => $fullname,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '92';
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
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has verified email of buyer '.$fullname.'.';

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
              // $response['status']      = 'ERROR';
              // $response['description'] = 'Activation record is not availiable.'; 
              // return response()->json($response); 
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

                        /*    $msg     = html_entity_decode(config('app.project.admin_name').' has varify your email you can make login.');
                            
                            $subject = 'Email Verified';*/

                            $arr_built_content = ['BUYER_NAME'    => $fullname,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '92';
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
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has verified email of buyer '.$fullname.'.';

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
                          'SELLER_NAME'    => $email_name, 
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
              $response['description'] = ' Verification email send successfully.'; 
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

          $activationcodeforemail = $activationcodeforemail;

         // $response['status']      = 'ERROR';
         // $response['description'] = 'Activation record of user does not exists.'; 
         // return response()->json($response); 
            $user = $this->get_user_details($email);
            if(isset($user) && !empty($user)){

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
                                 // 'USER_FNAME'   => $arr_user['first_name'],
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
                      $response['description'] = ' Verification email send successfully.'; 
                      return response()->json($response);  

                }//if activation record exists   

            }//if user
           
       }//else activation record not exists 
    }//end function of sendverification email


 
    public function approveage_coupon(Request $request)
    {
        $user = Sentinel::check();

        $user_id = $request->user_id;
        $age_category = $request->age_category; 
        $buyer_name = "";  

        $buyer_obj = $this->BaseModel->where('id',$user_id)->first();

        if(isset($buyer_obj))
        {
          $buyer_arr = $buyer_obj->toArray();

          $buyer_name = $buyer_arr['first_name'].' '.$buyer_arr['last_name'];
        }
        
        

        if($user_id && $age_category)
        {   
            $res_age = $this->BuyerModel->select('*')
                            ->where('user_id',$user_id)  
                            ->get();

            if(!empty($res_age) && count($res_age)>0)
            {
                $res_age = $res_age->toArray();
                  
                $approve_status = $res_age[0]['approve_status'];
                $age_address    = $res_age[0]['age_address'];
                $front_image    = $res_age[0]['front_image'];
                $back_image     = $res_age[0]['back_image'];
                $selfie_image   = $res_age[0]['selfie_image'];
                $note           = $res_age[0]['note'];
                $dbage_category = $res_age[0]['age_category'];
                $address_proof  = $res_age[0]['address_proof'];

            
                
                // if($front_image && $back_image && $age_address && $address_proof && $selfie_image)
                if($front_image && $back_image && $selfie_image)
                {
                    if($approve_status==0 || $approve_status==3 || $approve_status==2)
                    {
                      
                        $update_data = array('age_category'=>$age_category,
                                            'approve_status'=>'1',
                                            'note'=>'',
                                            'sorting_order_by'=>NULL
                                            );
                        $res_age_update = $this->BuyerModel
                                                    ->where('user_id',$user_id)
                                                    ->update($update_data);   
                        if($res_age_update)
                        {

                            $seller_nameemail = $sellerurl ='';
                              
                            /**Send email and nofi to seller for ship age restricted orders******/
                              $get_age_orders = $this->OrderModel
                                                      ->where('buyer_id',$user_id)
                                                      ->where('buyer_age_restrictionflag','=','1')
                                                      ->where('order_status','!=','0')
                                                      ->get();

                               /*----Code for sending mail to dropshipper------------**/
                               $site_setting_arr    = [];
                               $site_setting_obj    = $this->SiteSettingModel->first();  
                               $dropshiparr         = []; 
                                if(isset($site_setting_obj))
                                {
                                    $site_setting_arr = $site_setting_obj->toArray();            
                                }

                          
                              if(isset($get_age_orders) && !empty($get_age_orders))
                              {
                                 $get_age_orders = $get_age_orders->toArray();
                                 foreach($get_age_orders as $age_orders)
                                 {
                                    /*------Start After age verification approval send mail to dropshipper----*/

                                    $address         = [];       
                                    $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$age_orders['order_no'])->first();

                                    if ($address_details) {

                                      $address['shipping']         = isset($address_details['shipping_address1'])?$address_details['shipping_address1']:'';
                                      $address['shipping_state']   = isset($address_details['state_details']['name'])?$address_details['state_details']['name']:'';
                                      $address['shipping_country'] = isset($address_details['country_details']['name'])?$address_details['country_details']['name']:'';
                                      $address['shipping_zipcode'] = isset($address_details['shipping_zipcode'])?$address_details['shipping_zipcode']:'';
                                        $address['shipping_city']  = isset($address_details['shipping_city'])?$address_details['shipping_city']:'';
                                      $address['billing']          = isset($address_details['billing_address1'])?$address_details['billing_address1']:'';
                                      $address['billing_state']    = isset($address_details['billing_state_details']['name'])?$address_details['billing_state_details']['name']:'';
                                      $address['billing_country']  = isset($address_details['billing_country_details']['name'])?$address_details['billing_country_details']['name']:'';
                                      $address['billing_zipcode']  = isset($address_details['billing_zipcode'])?$address_details['billing_zipcode']:'';
                                      $address['billing_city']     = isset($address_details['billing_city'])?$address_details['billing_city']:'';
                                    }//end if order details

                                    $product_details = $this->OrderProductModel->with('product_details')->where('order_id',$age_orders['id'])->get(); 
                                    $order_no        = $age_orders['order_no'];
                                    $userId          = $age_orders['seller_id'];



                                /*************send mail to dropshipper*********************/

                                    $setdrporderarr =[];
                                    $result = [];

                                if($product_details!=null)
                                    {
                                         $product_details = $product_details->toArray();
                                         if(isset($product_details) && !empty($product_details))
                                         {
                                              foreach($product_details as $pro)
                                              {
                                                 $is_dropshipped_product = $this->DropShipperModel->where('product_id',$pro['product_id'])->first();
                                                 if(isset($is_dropshipped_product) && !empty($is_dropshipped_product))
                                                 {  
                                                    $pro_id              =  $pro['product_id'];
                                                    $dropshipper_id      =  $is_dropshipped_product->id;

                                                    $product_data        = $this->ProductModel->where('id',$pro['product_id'])->first(); 
                                                    $product_data       = $product_data->toArray();
                                                    $setdrporderarr[$userId][$pro_id]['product_data'] = $this->ProductModel->with(['user_details','product_images_details'])->where('id',$pro['product_id'])->first();

                                              $product_name           = isset($product_data['product_name'])?$product_data['product_name']:'';
                                              $product_id            = $pro['product_id'];
                                              $setdrporderarr[$userId][$pro_id]['order_no']     = $order_no or '';
                                              $setdrporderarr[$userId][$pro_id]['product_name'] = $product_name;
                                              $setdrporderarr[$userId][$pro_id]['product_id']   = $product_id;
                                              $setdrporderarr[$userId][$pro_id]['item_qty']     = isset($pro['quantity'])?$pro['quantity']:0;
                                              $setdrporderarr[$userId][$pro_id]['seller_id']    = $userId;
                                              $setdrporderarr[$userId][$pro_id]['seller_name']  = get_seller_name($userId);
                                             
                                              $setdrporderarr[$userId][$pro_id]['unit_price']   = isset($pro['unit_price'])?$pro['unit_price']:'';
                                              $total_wholesale_price = $pro['unit_price']*$pro['quantity'];                                           
                                              $setdrporderarr[$userId][$pro_id]['total_wholesale_price']  = $total_wholesale_price;
                                              $setdrporderarr[$userId][$pro_id]['shipping_charges_sum']  = $pro['shipping_charges']; 
                                            }//end is dropshipped product 
                                          }//end foreach

                                          

                                      if(isset($setdrporderarr) && !empty($setdrporderarr))
                                     {
                                      $sn_no = 0;
                                         foreach($setdrporderarr as $key1=>$product_data)
                                         {

                                            $order = [];

                                              //$arr_email = Sentinel::findById($key1)->email;

                                             foreach($product_data as $key2=>$product)
                                             {
                                               $dropshipper_id = isset($product['product_data']['drop_shipper'])?$product['product_data']['drop_shipper']:'';  

                                               if(isset($dropshipper_id) && !empty($dropshipper_id))
                                                {

                                                  $product_name  = isset($product['product_data']['product_name'])?$product['product_data']['product_name']:'';

                                                  
                                                  $order[$key2]['order_no']     = isset($product['product_data']['order_no'])?$product['product_data']['order_no']:'';
                                                  $order[$key2]['product_name'] = $product_name;
                                                  $order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;


                                                  $order[$key2]['seller_name']  = get_seller_details($product['seller_id']);

                                                  $order[$key2]['seller_id']  = $product['seller_id'];
                                                 
                                                  $order[$key2]['shipping_charges']   = isset($product['shipping_charges'])?$product['shipping_charges']:0;

                                                  $dropinfo = get_dropshipper_info($product['product_data']['drop_shipper'],$product['product_data']['id']);
                                                    if(isset($dropinfo) && !empty($dropinfo))
                                                    {
                                                        
                                                        $order[$key2]['dropshipper']= isset($dropinfo['email'])?$dropinfo['email']:'';
                                                        $order[$key2]['dropshipperid']= isset($dropinfo['id'])?$dropinfo['id']:'';
                                                        $order[$key2]['unit_price']= $dropinfo['unit_price'];
                                                        $order[$key2]['total_wholesale_price'] = $dropinfo['unit_price']*$product['item_qty'];
                                                        $dropshiparr[] = $dropinfo['email'];

                                                   }//if dropshipinfo

                                               }
                                               else{
                                                    unset($order[$key1]);
                                               }
                                              
                                             }//foreach

                                            


                                                $seller_email = get_seller_email($age_orders['seller_id']);
                                                $sum = 0;
                                                $total_amount = 0;
                                                $shipping_charges_sum = 0;

                                              foreach ($order as $key => $order_data) 
                                              { 
                                                $sum += $order_data['total_wholesale_price'];
                                                $shipping_charges_sum += $order_data['shipping_charges'];
                                                
                                                $order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
                                              }//foreach orderarr


                                              if(isset($order) && !empty($order))
                                                {
                                                    
                                                    $sumamt = $shipping_charges_sumamt=0;
                                                    foreach($order as $key6 => $value6)
                                                    {
                                                        // $result[] = $value6;
                                                         if (in_array($value6['dropshipper'], $result))
                                                         {
                                                            $result[] = $value6;
                                                         }else{
                                                            $result[] = $value6;
                                                         }

                                                    }//foreach on order
                                                
                                                 }//if isset order array


                                                 if(isset($result) && !empty($result))
                                                 {  
                                                    $dropshipporderarr = [];
                                                    foreach($result as $k=>$v)
                                                    {
                                                        $dropshipporderarr[$v['dropshipper']][$k]['order_no'] = $v['order_no'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['product_name'] = $v['product_name'];
                                                        // $dropshipporderarr[$v['dropshipperid']][$k]['product_id'] = $v['product_id'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['item_qty'] = $v['item_qty'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['seller_name'] = $v['seller_name'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['seller_id'] = $v['seller_id'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['dropshipper'] = $v['dropshipper'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['unit_price'] = $v['unit_price'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['total_wholesale_price'] = $v['total_wholesale_price'];
                                                        $dropshipporderarr[$v['dropshipper']][$k]['shipping_charges'] = $v['shipping_charges'];


                                                    }//foreach $result
                                                 }//if isset result

                                                   if(isset($dropshipporderarr))
                                                    {   
                                                        
                                                        foreach($dropshipporderarr as $kk=>$vv)
                                                        {   
                                                            $ordsum = 0;$shipping_charges_sumord=0;
                                                            foreach($vv as $data){
                                                               
                                                                $ordsum += $data['total_wholesale_price'];
                                                                $shipping_charges_sumord += $data['shipping_charges'];  
                                                            }
                                                            
                                                        }
                                                    }  

                                                        $user =[];


                                                         if(isset($dropshipporderarr) && !empty($dropshipporderarr))
                                                        {   

                                                           foreach($dropshipporderarr as $k1=>$order)
                                                           {
                                                              $dropinfoarr = $this->DropShipperModel->where('email',$k1)->first();
                                                              if(isset($dropinfoarr) && !empty($dropinfoarr))
                                                              {
                                                                $dropinfoarr = $dropinfoarr->toArray();
                                                              }

                                                              $arr_email = $dropinfoarr['email'];
                                                              $dropship[$k1]['email_id'] = $dropinfoarr['email'];

                                                              $dropuser_info = $this->DropShipperModel->where('email',$dropship[$k1]['email_id'])->first();
                                                              if(isset($dropuser_info) && !empty($dropuser_info))
                                                              {
                                                                $dropuser_info = $dropuser_info->toArray();
                                                                $drop_sellerid = $dropuser_info['seller_id'];

                                                                $seluser_info = $this->UserModel->with('seller_detail')->where('id',$drop_sellerid)->first();
                                                                if(isset($seluser_info) && !empty($seluser_info))
                                                                {
                                                                    $seluser_info = $seluser_info->toArray();
                                                                }
                                                              } 

                                                                $user = $this->UserModel->where('id',$age_orders['buyer_id'])->first();
                                                                if(isset($user) && !empty($user))
                                                                {
                                                                    $user = $user;
                                                                }


                                                              $pdf = PDF::loadView('front/dropshipperemail_invoice',compact('order','order_no','sn_no','address','site_setting_arr','user','seluser_info'));
            

                                                               $currentDateTime = $order_no.date('H:i:s').'.pdf';
                                                            

                                                            Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
                                                            $pdfpath = Storage::url($currentDateTime);

                                                            $loggedInUserId = 0;
                                                            if ($userId = Sentinel::check()) {
                                                                
                                                                $loggedInUserId = $userId->id;
                                                            }

                                                            $dropperuser_id = $this->DropShipperModel->where('email',$dropship[$k1]['email_id'])->first();

                                                            $buyer_details = $this->UserModel->where('id',$age_orders['buyer_id'])->first();

                                                            $obj_email_template = $this->EmailTemplateModel->where('id','47')->first();

                                                            if($obj_email_template)
                                                            {
                                                                $arr_email_template = $obj_email_template->toArray();
                                                                $content = $arr_email_template['template_html'];
                                                            }
                                                            $content = str_replace("##DROPSHIPPER_NAME##",$dropperuser_id['name'],$content);
                                                            $content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
                                                            $content = str_replace("##APP_NAME##",config('app.project.name'),$content);
                                                        

                                                            $content = view('email.front_general',compact('content'))->render();
                                                            $content = html_entity_decode($content);

                                                            $file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

                                                            $to_mail_id = $dropship[$k1]['email_id'];

                                                            $send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
                                                            {

                                                                if(isset($arr_email_template) && count($arr_email_template) > 0)
                                                                {       
                                                                    $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                                                    $message->to($to_mail_id);

                                                                    $dynamicsubject = $arr_email_template['template_subject'];
                                                                    $dynamicsubject = str_replace("##order_no##",$order_no, $dynamicsubject);
                                                                   // $message->subject($arr_email_template['template_subject']);
                                                                    $message->subject($dynamicsubject);
                                                                    // $message->subject('Dropship Order');
                                                                }
                                                                else
                                                                {
                                                                    $admin_email = 'notify@chow420.com';

                                                                    $message->from($admin_email);
                                                                    $message->to($to_mail_id);
                                                                    $message->subject('Dropship Order');
                                                                }               
                                                                
                                                                $message->setBody($content, 'text/html');
                                                                $message->attach($file_to_path);
                                                                   
                                                            });
                                                            }//foreach of dropshipporderarrr
                                                         }//if isset dropshiporderarr    

                                              
                                             
                                         }//foeach orderarr

                                     }//if isset setorders
                                     
                                   }//if isset prodcut details

                                 }//product details not null  

                                /**********end of***send mail to dropshipper*********************/

                                    

                                /********send email to seller*for order place**********/

                                 $setorderarr = []; $user=[];

                                 $dbseller_id         = $age_orders['seller_id'];
                                  
                                   if(isset($product_details) && !empty($product_details))
                                   {

                                     foreach($product_details as $pro)
                                     {

                                        $dbproduct_id         = $pro['product_id'];

                                              $product_data      = $this->ProductModel->where('id',$pro['product_id'])->first(); 
                                              $product_data           = $product_data->toArray();

                                              $setorderarr[$dbseller_id][$dbproduct_id]['product_data'] = $this->ProductModel->with(['user_details','product_images_details'])->where('id',$pro['product_id'])->first();

                                              $product_name           = isset($product_data['product_name'])?$product_data['product_name']:'';
                                              $product_id            = $pro['product_id'];
                                              $setorderarr[$dbseller_id][$dbproduct_id]['order_no']     = $order_no or '';
                                              $setorderarr[$dbseller_id][$dbproduct_id]['product_name'] = $product_name;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['product_id']   = $product_id;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['item_qty']     = isset($pro['quantity'])?$pro['quantity']:0;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['seller_id']    = $user_id;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['seller_name']  = get_seller_name($user_id);
                                             
                                              $setorderarr[$dbseller_id][$dbproduct_id]['unit_price']   = isset($pro['unit_price'])?$pro['unit_price']:'';
                                              $total_wholesale_price = $pro['unit_price']*$pro['quantity'];                                           
                                              $setorderarr[$dbseller_id][$dbproduct_id]['total_wholesale_price']  = $total_wholesale_price;
                                              $setorderarr[$dbseller_id][$dbproduct_id]['shipping_charges_sum']  = $pro['shipping_charges']; 


                                     }//foreach

                                     if(isset($setorderarr) && !empty($setorderarr))
                                     {
                                      $sn_no = 0;
                                         foreach($setorderarr as $key1=>$product_data)
                                         {

                                            $order = [];

                                              //$arr_email = Sentinel::findById($key1)->email;
                                              $arr_email = get_seller_email($key1);
                                            $seller[$key1]['seller_id'] = Sentinel::findById($key1);

                                            /***********************couponcode*start****************/
        
        $seller_couponcode = $seller_coupontype = '';
        $calculated_discountamt = $seller_ordertotal =$seller_totalall_amt =$seller_coupondiscount=0;
    
        $order_coupondata = [];

        $get_orderdetailcoupondata = $this->OrderModel->where('order_no',$order_no)->where('seller_id',$key1)->first();   
      
      if(isset($get_orderdetailcoupondata) && !empty($get_orderdetailcoupondata))
      {
        $get_orderdetailcoupondata = $get_orderdetailcoupondata->toArray();

        $order_id = isset($get_orderdetailcoupondata['id'])?$get_orderdetailcoupondata['id']:'';

        $get_orderproducts = $this->OrderProductModel->where('order_id',$order_id)->sum('shipping_charges');

        $seller_couponcode = isset($get_orderdetailcoupondata['couponcode'])?$get_orderdetailcoupondata['couponcode']:'';
        $seller_coupondiscount = isset($get_orderdetailcoupondata['discount'])?$get_orderdetailcoupondata['discount']:'0';
        $seller_coupontype = isset($get_orderdetailcoupondata['coupontype'])?$get_orderdetailcoupondata['coupontype']:'';


        // $seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']:'';

        if(isset($get_orderproducts) && !empty($get_orderproducts))
        {
          $seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']-$get_orderproducts:'';
        }
        else{
          $seller_ordertotal = isset($get_orderdetailcoupondata['total_amount'])?$get_orderdetailcoupondata['total_amount']:''; 
        }


        if(isset($seller_ordertotal) && $seller_ordertotal>0 && isset($seller_coupondiscount) && $seller_coupondiscount>0){
           $calculated_discountamt = $seller_ordertotal*$seller_coupondiscount/100;
        }


        if(isset($seller_couponcode) && isset($seller_coupondiscount) && isset($seller_coupontype) && isset($calculated_discountamt)){
        $order_coupondata[$key1]['couponcode'] = $seller_couponcode;
        $order_coupondata[$key1]['discount'] = $seller_coupondiscount;
        $order_coupondata[$key1]['seller_coupontype'] = $seller_coupontype;
        $order_coupondata[$key1]['seller_ordertotal'] = $seller_ordertotal;
        $order_coupondata[$key1]['seller_discount_amt'] = $calculated_discountamt;
        $order_coupondata[$key1]['sellername'] = get_seller_details($key1);
        $seller_totalall_amt += $order_coupondata[$key1]['seller_discount_amt'];
         }//if isseet

      }

      

      /*********************couponcode*end********************************/










                                             foreach($product_data as $key2=>$product)
                                             {
                                                  $product_name  = isset($product['product_data']['product_name'])?$product['product_data']['product_name']:'';
                                                  $order[$key2]['order_no']     = isset($product['product_data']['order_no'])?$product['product_data']['order_no']:'';
                                                  $order[$key2]['product_name'] = $product_name;
                                                  $order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;

                                                  $order[$key2]['shipping_type']      = isset($product['shipping_type'])?$product['shipping_type']:0;
                                                  $order[$key2]['shipping_charges']   = isset($product['shipping_charges'])?$product['shipping_charges']:0;


                                                  $order[$key2]['seller_name']  = get_seller_name($product['seller_id']);

                                                  $dropinfo = $this->DropShipperModel->where('product_id',$product['product_id'])->first();
                                                  if($dropinfo!=null)
                                                  {

                                                      $dropinfo = $dropinfo->toArray();
                                                      if(isset($dropinfo) && !empty($dropinfo))
                                                      {  
                                                          $order[$key2]['dropshipper']= isset($dropinfo['email'])?$dropinfo['email']:'';
                                                          $order[$key2]['unit_price']= $dropinfo['product_price'];
                                                          $order[$key2]['total_wholesale_price'] = $dropinfo['product_price']*$product['item_qty'];
                                                          $dropshiparr[] = $dropinfo['email'];
                                                      }
                                                 }  

                                                 if($product['product_data']['shipping_type']==1)
                                                {
                                                  $order[$key2]['shipping_charges']   = isset($product['product_data']['shipping_charges'])?$product['product_data']['shipping_charges']:0;
                                                }else{

                                                  $order[$key2]['shipping_charges']   = 0;
                                                } 

                                                 
                                                  $order[$key2]['unit_price']= isset($product['unit_price'])?$product['unit_price']:0;

                                                  $order[$key2]['total_wholesale_price'] = $product['unit_price']*$product['item_qty'];
                                                    
                                              
                                                  // $order[$key2]['shipping_charges']   = isset($product['shipping_charges'])?$product['shipping_charges']:0;
                                             }//foreach

                                                $seller[$key1]['email_id'] = $arr_email;


                                                $sum = 0;
                                                $total_amount = 0;
                                                $shipping_charges_sum = 0;


                                              foreach ($order as $key => $order_data) 
                                              { 
                                                $sum += $order_data['total_wholesale_price'];
                                                $shipping_charges_sum += $order_data['shipping_charges'];
                                                
                                                $order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
                                              }//foreach orderarr



                                              $seluser_info = $this->UserModel->where('email',
                                                $arr_email)->with('seller_detail')->first();

                                              $user = $this->UserModel->where('id',$age_orders['buyer_id'])->first();
                                                                if(isset($user) && !empty($user))
                                                                {
                                                                    $user = $user;
                                                                }

                                              
                                               $pdf = PDF::loadView('front/seller_invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address','site_setting_arr','user','seluser_info','order_coupondata','seller_totalall_amt'));
                                                  $currentDateTime = $order_no.date('H:i:s').'.pdf';
      

                                                  Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
                                                    $pdfpath = Storage::url($currentDateTime);

                                                   $selleruser = $this->UserModel->where('email',
                                                     $arr_email)->first();

                                                  $buyer_details = $this->UserModel->where('id',$age_orders['buyer_id'])->first();

                                                  $obj_email_template = $this->EmailTemplateModel->where('id','36')->first();

                                                   if($obj_email_template)
                                                  {
                                                    $arr_email_template = $obj_email_template->toArray();
                                                    $content = $arr_email_template['template_html'];
                                                  }
                                                   $content = str_replace("##SELLER_NAME##",
                                                    $selleruser['first_name'].' '.$selleruser['last_name'],$content);
                                                  $content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
                                                  $content = str_replace("##APP_NAME##",config('app.project.name'),$content);
                                                  

                                                   $content = view('email.front_general',compact('content'))->render();
                                                    $content = html_entity_decode($content);

                                                   $file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

                                                   $to_mail_id = get_seller_email($key1);
                                                   $send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
                                                    {
                                                        
                                                      if(isset($arr_email_template) && count($arr_email_template) > 0)
                                                      {   
                                                        $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                                          $message->to($to_mail_id);

                                                          $dynamicsubject = str_replace("##order_no##", $order_no, $arr_email_template['template_subject']);
                                                    $message->subject($dynamicsubject);
                                                       // $message->subject($arr_email_template['template_subject']);
                                                      }
                                                      else
                                                      {
                                                        $admin_email = 'notify@chow420.com';

                                                        $message->from($admin_email);
                                                          $message->to($to_mail_id);
                                                        $message->subject('New Order '.$order_no.' Placed');
                                                      }             
                                                        
                                                    $message->setBody($content, 'text/html');
                                                    $message->attach($file_to_path);
                                                       
                                                    });
                                         }//foeach

                                     }//if isset setorders

                                   }//if isset prodcut details

                                /****************end send email to seller******/

                                /********send email to dropship seller for order place**********/

                                 $setdrporderarr = []; $user=[];

                                 $dropseller_id         = $age_orders['seller_id'];
                                  
                                   if(isset($product_details) && !empty($product_details))
                                   {

                                     foreach($product_details as $pro)
                                     {

                                        $is_dropshipped_product = $this->DropShipperModel->where('product_id',$pro['product_id'])->first();

                                        if($is_dropshipped_product!=null)
                                        {
                                              $dropproduct_id      = $pro['product_id'];

                                              $product_data      = $this->ProductModel->where('id',$pro['product_id'])->first(); 
                                              $product_data           = $product_data->toArray();

                                              $setorderarr[$dropseller_id][$dropproduct_id]['product_data'] = $this->ProductModel->with(['user_details','product_images_details'])->where('id',$pro['product_id'])->first();

                                              $product_name           = isset($product_data['product_name'])?$product_data['product_name']:'';
                                              $product_id            = $pro['product_id'];
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['order_no']     = $order_no or '';
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['product_name'] = $product_name;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['product_id']   = $product_id;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['item_qty']     = isset($pro['quantity'])?$pro['quantity']:0;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['seller_id']    = $user_id;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['seller_name']  = get_seller_name($user_id);
                                             
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['unit_price']   = isset($pro['unit_price'])?$pro['unit_price']:'';
                                              $total_wholesale_price = $pro['unit_price']*$pro['quantity'];                                           
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['total_wholesale_price']  = $total_wholesale_price;
                                              $setdrporderarr[$dropseller_id][$dropproduct_id]['shipping_charges_sum']  = $pro['shipping_charges']; 
                                        }//if dropshipped product     
                                     }//foreach

                                     if(isset($setdrporderarr) && !empty($setdrporderarr))
                                     {
                                      $sn_no = 0;
                                         foreach($setdrporderarr as $key1=>$product_data)
                                         {

                                            $order = [];

                                              //$arr_email = Sentinel::findById($key1)->email;
                                              $arr_seller_email = get_seller_email($key1);
                                            $seller[$key1]['seller_id'] = Sentinel::findById($key1);

                                             foreach($product_data as $key2=>$product)
                                             {
                                                  $product_name  = isset($product['product_name'])?$product['product_name']:'';
                                                  $order[$key2]['order_no']     = isset($product['product_data']['order_no'])?$product['product_data']['order_no']:'';
                                                  $order[$key2]['product_name'] = $product_name;
                                                  $order[$key2]['item_qty']     = isset($product['item_qty'])?$product['item_qty']:0;


                                                  $order[$key2]['seller_name']  = get_seller_name($product['seller_id']);

                                                 
                                                  $order[$key2]['unit_price']= isset($product['unit_price'])?$product['unit_price']:0;

                                                  $order[$key2]['total_wholesale_price'] = $product['unit_price']*$product['item_qty'];
                                                    
                                              
                                                  $order[$key2]['shipping_charges']   = isset($product['shipping_charges'])?$product['shipping_charges']:0;

                                                  $order[$key2]['shipping_type']      = isset($product['shipping_type'])?$product['shipping_type']:0;

                                                  $dropinfo = $this->DropShipperModel->where('product_id',$product['product_id'])->first();
                                                  if($dropinfo!=null)
                                                  {

                                                      $dropinfo = $dropinfo->toArray();
                                                      if(isset($dropinfo) && !empty($dropinfo))
                                                      {  
                                                          $order[$key2]['dropshipper']= isset($dropinfo['email'])?$dropinfo['email']:'';
                                                          $order[$key2]['unit_price']= $dropinfo['product_price'];
                                                          $order[$key2]['total_wholesale_price'] = $dropinfo['product_price']*$product['item_qty'];
                                                          $dropshiparr[] = $dropinfo['email'];
                                                      }
                                                 }  

                                                 if($order[$key2]['shipping_type']==1)
                                                {
                                                  $order[$key2]['shipping_charges']   = isset($product['product_data']['shipping_charges'])?$product['product_data']['shipping_charges']:0;
                                                }else{

                                                  $order[$key2]['shipping_charges']   = 0;
                                                } 

                                             }//foreach

                                                $seller[$key1]['email_id'] = $arr_seller_email;


                                                $sum = 0;
                                                $total_amount = 0;
                                                $shipping_charges_sum = 0;

                                              foreach ($order as $key => $order_data) 
                                              { 
                                                $sum += $order_data['total_wholesale_price'];
                                                $shipping_charges_sum += $order_data['shipping_charges'];
                                                
                                                $order[$key]['unit_price']  = number_format($order_data['unit_price'], 2, '.', '');
                                              }//foreach orderarr

                                              $seluser_info = $this->UserModel->where('email',
                                                $arr_seller_email)->with('seller_detail')->first();

                                              $user = $this->UserModel->where('id',$age_orders['buyer_id'])->first();
                                                  if(isset($user) && !empty($user))
                                                  {
                                                      $user = $user;
                                                  }

                                              
                                                $pdf = PDF::loadView('front/dropship_invoice',compact('order','key','order_no','sn_no','shipping_charges_sum','sum','address','site_setting_arr','user','seluser_info'));
                                                  $currentDateTime = $order_no.date('H:i:s').'.pdf';
      

                                                  Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
                                                    $pdfpath = Storage::url($currentDateTime);

                                                   $selleruser = $this->UserModel->where('email',
                                                     $arr_seller_email)->first();

                                                  $buyer_details = $this->UserModel->where('id',$age_orders['buyer_id'])->first();

                                                  $obj_email_template = $this->EmailTemplateModel->where('id','110')->first();

                                                   if($obj_email_template)
                                                  {
                                                    $arr_email_template = $obj_email_template->toArray();
                                                    $content = $arr_email_template['template_html'];
                                                  }
                                                   $content = str_replace("##SELLER_NAME##",
                                                    $selleruser['first_name'].' '.$selleruser['last_name'],$content);
                                                   $content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
                                                   $content = str_replace("##BUSINESS_NAME##",$seluser_info['seller_detail']['business_name'],$content);
                                                   $content = str_replace("##APP_NAME##",config('app.project.name'),$content);
                                                  

                                                   $content = view('email.front_general',compact('content'))->render();
                                                    $content = html_entity_decode($content);

                                                   $file_to_path = url("/")."/storage/app/public/pdf/".$currentDateTime;

                                                   $to_mail_id = get_seller_email($key1);
                                                   $send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
                                                    {
                                                        
                                                      if(isset($arr_email_template) && count($arr_email_template) > 0)
                                                      {   
                                                         $seluser_info = $this->UserModel->where('email',
                                                         $to_mail_id)->with('seller_detail')->first();

                                                        $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                                          $message->to($to_mail_id);

                                                          $dynamicsubject = str_replace("##order_no##", $order_no, $arr_email_template['template_subject']);
                                                          $dynamicsubject  = str_replace('##BUSINESS_NAME##',$seluser_info['seller_detail']['business_name'],$dynamicsubject);  
                                                    $message->subject($dynamicsubject);
                                                       // $message->subject($arr_email_template['template_subject']);
                                                      }
                                                      else
                                                      {
                                                        $admin_email = 'notify@chow420.com';

                                                        $message->from($admin_email);
                                                          $message->to($to_mail_id);
                                                        $message->subject('New Order '.$order_no.' Placed');
                                                      }             
                                                        
                                                    $message->setBody($content, 'text/html');
                                                    $message->attach($file_to_path);
                                                       
                                                    });
                                           
                                             
                                         }//foeach

                                     }//if isset setorders
                                     
                                   }//if isset prodcut details

                                /****************end send email to dropship seller******/


                                    $sellerid = $age_orders['seller_id'];
                                    $order_no = $age_orders['order_no'];
                                    $order_id = $age_orders['id'];
                                    $admin_id = get_admin_id();

                                    $seller_obj = $this->BaseModel->where('id',$sellerid)->first();

                                    if(isset($seller_obj))
                                    {
                                      $seller_arr = $seller_obj->toArray();

                                      $seller_nameemail = $seller_arr['first_name'].' '.$seller_arr['last_name'];
                                    }
                                    $sellerurl = url('/').'/seller/order/view/'.base64_encode($order_id);


                                    //send noti
                                    $arr_event                 = [];
                                    $arr_event['from_user_id'] = $admin_id;
                                    $arr_event['to_user_id']   = $sellerid;
                                    $arr_event['description']  = 'Customer age-verification has been approved, you can now ship order <a href='.$sellerurl.'>'.$order_no.' </a> . Please login and go to your ongoing orders to fulfill this order.';
                                    $arr_event['title']        = 'Ship order '.$order_no.'';
                                    $arr_event['type']         = 'admin';   

                                    $this->GeneralService->save_notification($arr_event);

                                    //send email
                                     $arr_built_content = [
                                        'USER_NAME'     => $seller_nameemail,
                                        'APP_NAME'      => config('app.project.name'),
                                       /* 'MESSAGE'       => $msg,*/
                                        'ORDER_NO'      => $order_no,
                                        'SELLER_URL'    => $sellerurl
                                    ];

                                    $arr_built_subject =  [
                                                           'ORDER_NO'      => $order_no
                                                        ];    

                                    $arr_mail_data['email_template_id'] = '135';
                                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                                    $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                    $arr_mail_data['user']              = Sentinel::findById($sellerid);
                                    $this->EmailService->send_mail_section_order($arr_mail_data);


                                 }//foreach
                              }//if get age orders                       
                            /**end Send email and nofi to seller for ship age restricted orders**/

                            /*************get age restricted orders*and update flag*****/
                              $get_agerestrictedorders = $this->OrderModel
                                                      ->where('buyer_id',$user_id)
                                                      ->where('buyer_age_restrictionflag','=','1')
                                                      ->get();
                              if(isset($get_agerestrictedorders) && !empty($get_agerestrictedorders))
                              {
                                $get_agerestrictedorders = $get_agerestrictedorders->toArray();
                                foreach($get_agerestrictedorders as $age_orders)
                                {
                                  $order_id = $age_orders['id'];

                                  $update_orderageflag = [];
                                  $update_orderageflag['buyer_age_restrictionflag'] = 0;
                                  $this->OrderModel->where('id',$order_id)
                                                   ->where('buyer_id',$user_id)
                                                   ->update($update_orderageflag);

                                }//foreach
                              } //if age restricted orders                        
                            /**********end of get age restricted orders*and update flag********/ 


                            /*Delete Age Proof Images (START)*/
                               
                            $front_image_file  = $this->id_proof_base_path.$front_image;
                            $back_image_file   = $this->id_proof_base_path.$back_image;
                            $selfie_image_file = $this->id_proof_base_path.$selfie_image;
                            $addrproof_file = $this->id_proof_base_path.$address_proof;
                            
                            if($front_image_file)
                            {
                               $this->unlink_image($front_image_file,$front_image);

                            }
                            if($back_image_file)
                            {
                               $this->unlink_image($back_image_file,$back_image);

                            }
                            if($selfie_image_file)
                            {
                               $this->unlink_image($selfie_image_file,$selfie_image);
                            }
                           
                            if($addrproof_file)
                            {
                              $this->unlink_image($addrproof_file,$address_proof);

                            }


                            /*Delete Age Proof Images (END)*/



                            /*******send noti to admin for age verification******/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                            
                            $url   = url('/').'/buyer/age-verification';

                            /*****************Send Notification to Admin START****************/
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $from_user_id;
                                $arr_event['to_user_id']   = $user_id;
                                $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>approved</b> the id proof of <a target="_blank" href="'.$url.'"><b>age verification</b></a>.');
                                $arr_event['type']         = '';
                                $arr_event['title']        = 'Age verification details approved';
                                $this->GeneralService->save_notification($arr_event);
                            /***************Send Notification to Admin END*********************/   

                           
                            /*****************Mail to Buyer Start************************/
                            
                        
                            /***************Send Notification Mail to Buyer (START)**************************/
                            $to_user = Sentinel::findById($user_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
                            $email   = isset($to_user->email)?$to_user->email:'';
                            $full_name = "";
                            if(isset($f_name) && !empty($f_name) && isset($l_name) && !empty($l_name))
                            {  
                              $full_name = $f_name.' '.$l_name;
                            }
                            else
                            {
                               $full_name = $email;
                            }

                           /* $msg     =  html_entity_decode( config('app.project.admin_name').' has approved the id proof of age verification.');*/

                            //$subject = 'Age verification details approved';

                            $arr_built_content = ['BUYER_NAME'    => $full_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '39';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($user_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                            /*********************Send Notification Mail to Buyer (END)*****************/

                           /********************Mail to Buyer End***********************/

                              /*-------------------------------------------------------
                              |   Activity log Event
                              --------------------------------------------------------*/
                                
                                //save sub admin activity log 

                                if(isset($user) && $user->inRole('sub_admin'))
                                {
                                    $arr_event                 = [];
                                    $arr_event['action']       = 'AGE VERIFY';
                                    $arr_event['title']        = $this->module_title;
                                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' age verification details has approved of buyer '.$buyer_name.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                              /*----------------------------------------------------------------------*/

                              $response['status']      = 'SUCCESS';
                              $response['description'] = 'Age verification details has approved.'; 
                              return response()->json($response);   
                        }            

                    }
                    else if($approve_status==1)
                    {

                        $response['status']      = 'ERROR';
                        $response['description'] = 'Age verification details already approved'; 
                        return response()->json($response);   
                    }

                }
                else
                {
                    $response['status']      = 'ERROR';
                    $response['description'] = 'Please upload front side,back side image and age address'; 
                } 

            }// if age data
        }
    }//end of function




}//class
