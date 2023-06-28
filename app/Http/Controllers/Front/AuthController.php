<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\SellerModel;
use App\Models\SellerQuestionsModel;
use App\Models\BuyerModel;
use App\Models\GeneralSettingsModel;
use App\Models\ShippingAddressModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\BankDetailsModel;
use App\Models\StaticPageModel;
use App\Models\MembershipModel;
use App\Models\UserSubscriptionsModel;
use App\Models\SiteSettingModel;
use App\Models\BuyerViewProductModel;


use App\Models\StripeProductsModel;
use App\Models\PlansModel;
use App\Models\TempBagModel;
use App\Models\UserReferWalletModel;

use App\Models\ProductModel;
use App\Models\BuyerRegisteredReferModel;


use App\Common\Services\EmailService;
use App\Common\Services\UserService;
use App\Common\Services\GeneralService;

use Validator;
use Sentinel;
use Session;
use Activation;
use Flash;
use Reminder;
use DB;
use DateTime;


//use Illuminate\Support\Facades\URL; // new added
use EmailValidation\EmailValidatorFactory;


class AuthController extends Controller
{
    /*
	|  	Author : Sagar B. Jadhav
    |  	Date   : 21 Feb 2019
    */
    public function __construct(UserModel $UserModel,
    							              BuyerModel $BuyerModel,
    							              SellerModel $SellerModel,
    							              SellerQuestionsModel $SellerQuestionsModel,
    							              GeneralSettingsModel $GeneralSettingsModel,
                                EmailService $EmailService,
                                UserService $UserService,
                                GeneralService $GeneralService,
                                ShippingAddressModel $ShippingAddressModel,
                                CountriesModel $CountriesModel,
                                StatesModel $StatesModel,
                                BankDetailsModel $BankDetailsModel,
                                MembershipModel $MembershipModel,
                                UserSubscriptionsModel $UserSubscriptionsModel,
                                SiteSettingModel $SiteSettingModel,
                                StripeProductsModel $StripeProductsModel,
                                PlansModel $PlansModel,
                                TempBagModel $TempBagModel,
                                StaticPageModel $StaticPageModel,
                                UserReferWalletModel $UserReferWalletModel,
                                BuyerViewProductModel $BuyerViewProductModel,
                                ProductModel $ProductModel,
                                BuyerRegisteredReferModel $BuyerRegisteredReferModel

                              )
    { 
      	$this->BaseModel            = $UserModel;
        $this->UserModel            = $UserModel;
      	$this->BuyerModel           = $BuyerModel;
      	$this->SellerModel          = $SellerModel;
      	$this->SellerQuestionsModel = $SellerQuestionsModel;
      	$this->GeneralSettingsModel = $GeneralSettingsModel;
        $this->EmailService         = $EmailService;
        $this->UserService          = $UserService;
        $this->GeneralService       = $GeneralService;
        $this->ShippingAddressModel = $ShippingAddressModel;
        $this->CountriesModel       = $CountriesModel;
        $this->StatesModel          = $StatesModel;
        $this->BankDetailsModel     = $BankDetailsModel;
        $this->StaticPageModel      = $StaticPageModel;
        $this->membershipmodel      = $MembershipModel;
        $this->UserSubscriptionsModel   = $UserSubscriptionsModel;
        $this->SiteSettingModel     = $SiteSettingModel;
        $this->StripeProductsModel  = $StripeProductsModel;
        $this->PlansModel           = $PlansModel;
        $this->TempBagModel         = $TempBagModel;
        $this->UserReferWalletModel = $UserReferWalletModel;
        $this->BuyerViewProductModel = $BuyerViewProductModel;
        $this->ProductModel         = $ProductModel;
        $this->BuyerRegisteredReferModel = $BuyerRegisteredReferModel;



        $this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
        $this->profile_img_public_path = url('/').config('app.project.img_path.user_profile_image');
        $this->profile_img_base_path   = base_path().config('app.project.img_path.user_profile_image');

        $this->id_proof_public_path = url('/').config('app.project.id_proof');
        $this->id_proof_base_path   = base_path().config('app.project.id_proof');
        
    }
    
     public function get_ip_address()
    {
         $ip_address = \Request::ip();
         return $ip_address;
    }
    public function get_session_id()
    {
         $session_id = session()->getId();
         return $session_id;
    }
    public function check_auth()
    {
        return \Sentinel::check();
    }


    public function signup($guest=null,$productid=NULL,$referalcode=NULL)
    {   
         //check if product id exists in the url
        if(isset($productid) && !empty($productid))
        { 

            $proid = base64_decode($productid); 
            $checkproductid = $this->ProductModel->where('id',$proid)->get()->toArray();
            if(isset($checkproductid) && !empty($checkproductid))
            {
                $sethiddenfield_productid = $productid;
            }else
            {
                $sethiddenfield_productid = '';
            }
        } //check if product id exists in the url


        //check for referal parameters
        if(isset($guest) && $guest=="buyer" && isset($productid) && empty(
            $sethiddenfield_productid) && isset($referalcode))
        {

            $refered_email = $productid;
            $referal_code = $referalcode;



             if(isset($refered_email) && !empty($refered_email) && isset($referal_code) && !empty($referal_code))
            {

                
                $is_exists = $this->BuyerRegisteredReferModel->where('email',base64_decode($refered_email))->where('code',$referal_code)->count();
                if($is_exists == 1)
                {
                  flash::error('Referal link has expired.');

                  return redirect('/login');
                }
                $this->arr_view_data['refered_email']  = $refered_email;
                $this->arr_view_data['referal_code']  = $referal_code;
               
            }
        }


       

        if($guest=="guest")
        {
            $msg = "Please sign up or <a class='login-pos' href='".url('/login')."'>login</a> if you're already a member.";
            
            Session::flash('message', $msg); 
        }
        //  $countries_arr = $this->CountriesModel->get()->toArray();
        // $this->arr_view_data['countries_arr']   = $countries_arr;
        $countries_obj = $this->CountriesModel->where('is_active',1)->get();
        if ($countries_obj) {
            $countries_arr = $countries_obj->toArray();

            $this->arr_view_data['countries_arr']         = $countries_arr;
        }

        //Get Data for terms and condition url
        $terms_condition_url = 'javascript:void(0)';
        $static_page_obj     =  $this->StaticPageModel
                                ->where('page_slug','terms-conditions')
                                ->where('is_active','1')
                                ->first();
        if($static_page_obj){
            $terms_condition_url = url('/').'/terms-conditions';
        }

        //Check whether user has logged in or not, if logged in then redirect to home page 
        if($login_user = Sentinel::check()) 
        {
            $panel_dashboard_url = url('/');
            return redirect($panel_dashboard_url);
        }
        else
        {
            $this->arr_view_data['terms_condition_url'] = $terms_condition_url;
            $this->arr_view_data['page_title']  = 'Create Buyer Account';
            $this->arr_view_data['productid']  = isset($sethiddenfield_productid)?$sethiddenfield_productid:'';


            return view($this->module_view_folder.'.signup',$this->arr_view_data);
        }
    }

    public function signup_seller($email=NULL,$referal_code=NULL)
    {

      //  echo "===".$email.'----'.$referal_code;

        $arr_seller_quests = [];

        $arr_seller_quests  = $this->SellerQuestionsModel->select('question')->get()->toArray();
        
        $this->arr_view_data['arr_seller_quests']  = isset($arr_seller_quests) ? $arr_seller_quests : [];

        $arr_membership = [];


        //check user has alredy refered or not

        if(isset($email) && !empty($email) && isset($referal_code) && !empty($referal_code))
        {
            $refered_email = base64_decode($email);
           
            $is_exists = $this->UserReferWalletModel->where('email',$refered_email)->where('code',$referal_code)->count();
           
            if($is_exists == 1)
            {
              flash::error('Referal link has expired.');

              return redirect('/login');
            }
           
        }

       if(isset($email) && !empty($email) && isset($referal_code) && !empty($referal_code))
       {
           $arr_membership = $this->membershipmodel->select('*')
                        ->where('is_active','1')
                         ->where('membership_type', '!=', '1')
                        ->orderBy('membership_type')
                        ->get()->toArray();
       }
       else
       {
           $arr_membership = $this->membershipmodel->select('*')
                        ->where('is_active','1')
                        ->orderBy('membership_type')
                        ->get()->toArray();
       }

       /* $arr_membership = $this->membershipmodel->select('*')
                        ->where('is_active','1')
                        ->orderBy('membership_type')
                        ->get()->toArray();*/

        $this->arr_view_data['arr_membership']  = isset($arr_membership) ? $arr_membership : [];



        $countries_obj = $this->CountriesModel->get();
        if ($countries_obj) {
            $countries_arr = $countries_obj->toArray();

            $this->arr_view_data['countries_arr']         = $countries_arr;
        }

         //Get Data for terms and condition url
        $terms_condition_url = 'javascript:void(0)';
        $static_page_obj     =  $this->StaticPageModel
                                ->where('page_slug','terms-conditions')
                                ->where('is_active','1')
                                ->first();
        if($static_page_obj){
            $terms_condition_url = url('/').'/terms-conditions';
        }

        $this->arr_view_data['terms_condition_url'] = $terms_condition_url;


        if($login_user = Sentinel::check()) {

            // if($login_user->inRole('buyer')){
              
            //   $panel_dashboard_url = url()->previous();
            // }
            // elseif($login_user->inRole('seller')){
              
            //   $panel_dashboard_url = url()->previous();
            // }
            
            // elseif($login_user->inRole('admin'))
            // {
            //   $this->arr_view_data['page_title'] = 'SignUp';
            //   return view($this->module_view_folder.'.signup_seller',$this->arr_view_data);
            // }

            $panel_dashboard_url = url('/');

            return redirect($panel_dashboard_url);
         }
         else
         {

            if(isset($email) && !empty($email) && isset($referal_code) && !empty($referal_code))
            {
              $this->arr_view_data['refered_email']  = $email;
              $this->arr_view_data['referal_code']  = $referal_code;
            }
             $this->arr_view_data['page_title']  = 'Create Dispensary Account';
             return view($this->module_view_folder.'.signup_seller',$this->arr_view_data); 
         }
       
    }

    public function get_states(Request $request)
    {
        
        $arr_states   = [];
        $country_id     = $request->input('country_id');

        $arr_states   = $this->StatesModel->where('country_id', $country_id)
           ->where('is_active', 1)
            ->get()
            ->toArray();

        $response['arr_states'] = isset($arr_states) ? $arr_states : [];
        return $response;
    }
    
    public function process_signup_old_20apr(Request $request)
    {

    	$status = false; 

        $form_data = $request->all();

        $user_role = isset($form_data['role'])?$form_data['role']:'';

        $arr_rules = [
                       // 'first_name'            => 'required|alpha',
                      //  'last_name'             => 'required|alpha',
                        'email'                 => 'required|email',
                       // 'password'              => 'required|min:8|max:16|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}$/',

                        'password'              => 'required|min:8|max:16',

                        'confirm_password'      => 'required|same:password',
                      //  'country'      => 'required',
                      //  'state'      => 'required'
                    ];
    
         if($user_role == 'buyer'){
          //  $arr_rules['first_name'] = 'required';
          //  $arr_rules['last_name']  = 'required';
            $arr_rules['country']    = 'required';
            $arr_rules['state']      = 'required';
         }           


        if($user_role == 'seller')
        {
           // $arr_rules['business_name']   =   'required';
            $arr_rules['seller_answer1']  =   'required';
            $arr_rules['seller_answer2']  =   'required';
            $arr_rules['seller_answer3']  =   'required';
        }
 
     

       if(isset($form_data['password'])){
           if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}$/', $form_data['password']))
           {
               $response['status'] = 'ERROR';
               $response['password_msg'] = 'Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character.';
               return response()->json($response); 
           }
      }

        
        if(Validator::make($form_data,$arr_rules)->fails())
        {   
            $msg = Validator::make($form_data,$arr_rules)->errors()->first();

            $response = [
                           'status' =>'ERROR',
                           'msg'    => $msg
                        ];
            //Flash::success(str_singular($this->module_title).' Saved Successfully');
            return response()->json($response);     
        }

        
        $response = $this->UserService->user_registration($form_data);
        
        return response()->json($response);
        
    }//end of process signup function



    public function process_signup(Request $request)
    {
        $status = false; 

        $form_data = $request->all();


        $user_role = isset($form_data['role'])?$form_data['role']:'';

        $arr_rules = [
                       // 'first_name'            => 'required|alpha',
                      //  'last_name'             => 'required|alpha',
                        'email'                 => 'required|email',
                       // 'password'              => 'required|min:8|max:16|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}$/',

                        'password'              => 'required|min:8|max:16',

                        'confirm_password'      => 'required|same:password',
                      //  'country'      => 'required',
                      //  'state'      => 'required'
                    ];
    
         if($user_role == 'buyer'){
          //  $arr_rules['first_name'] = 'required';
          //  $arr_rules['last_name']  = 'required';
            $arr_rules['country']       = 'required';
            $arr_rules['state']         = 'required';
            $arr_rules['hear_about']    = 'required';
            $arr_rules['date_of_birth'] = 'required';
         }           


        if($user_role == 'seller')
        {
            $arr_rules['business_name']   =   'required';
            $arr_rules['seller_answer1']  =   'required';
            $arr_rules['seller_answer2']  =   'required';
            $arr_rules['seller_answer3']  =   'required';
        }
 
         if($user_role == 'seller')
        {

               if(!isset($form_data['business_name']) || (isset($form_data['business_name']) && $form_data['business_name'] == '') || (!preg_match("/^([A-Za-z0-9]+ )+[A-Za-z0-9]+$|^[A-Za-z0-9]+$/",$form_data['business_name'])))
                  {
                    
                     $response['status'] = 'ERROR';
                     $response['businessmsg']    = 'Provided business name should not be blank or invalid.';
                    
                     return response()->json($response);   
                  }  


               if($form_data['business_name']!="")
                {

                   $businessname_already_exists  = $this->SellerModel->where('business_name',$form_data['business_name'])->get()->toArray();
                   if(!empty($businessname_already_exists))
                   {
                         $response['status'] = 'ERROR';
                         $response['businessmsg'] = 'This business name already exists.';
                        return response()->json($response); 
                   }
                }
        }


       if(isset($form_data['password'])){
           if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}$/', $form_data['password']))
           {
               $response['status'] = 'ERROR';
               $response['password_msg'] = 'Password field must contain minimum 8 characters, at least one number, one uppercase letter, one lowercase letter and one special character.';
               return response()->json($response); 
           }
      }

        /*AGE VALIDATION*/
        if(isset($form_data['date_of_birth'])){
            $date1 = date("m/d/Y");
            $date2 = $form_data['date_of_birth'];
            //$date2 = "10/17/2020";
             
            $diff = strtotime($date2) - strtotime($date1); 
                
            $difference_In_Days = abs(round($diff / 86400));

            if ($difference_In_Days < 7671) { // days in 21 years 

              $response['status'] = 'ERROR';
              //$response['age_msg'] = 'Age must be above 21 years for registration';
              $response['age_msg'] = 'You must be 21+ and above to use chow420';
              return response()->json($response);
            }
         }
        /*AGE VALIDATION*/


          /*************chk country*state**************************/

          $countries_obj = $this->CountriesModel->where('id',$request->country)->first();
          if ($countries_obj) {
              $countries_arr = $countries_obj->toArray();
              if( $countries_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['countrymsg'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }

          }//if country obj

           $states_obj = $this->StatesModel->where('id', $request->state)->first();
           if ($states_obj) {
            $states_arr = $states_obj->toArray();
             if( $states_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['statemsg'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }
          }//if state obj
        /*************chk country**state*************************/


        
        if(Validator::make($form_data,$arr_rules)->fails())
        {   
            $msg = Validator::make($form_data,$arr_rules)->errors()->first();

            $response = [
                           'status' =>'ERROR',
                           'msg'    => $msg
                        ];
            //Flash::success(str_singular($this->module_title).' Saved Successfully');
            return response()->json($response);     
        }

       if($user_role == 'seller')
       {  


          $stripe_secret_key ='';
          $site_setting_arr = [];

          $site_setting_obj = SiteSettingModel::first();  

          if(isset($site_setting_obj))
          {
              $site_setting_arr = $site_setting_obj->toArray();            
          }

          if(isset($site_setting_arr) && count($site_setting_arr)>0)
          {
               $payment_mode = $site_setting_arr['payment_mode'];
               $sandbox_stripe_public_key = $site_setting_arr['sandbox_stripe_public_key'];
               $sandbox_stripe_secret_key = $site_setting_arr['sandbox_stripe_secret_key'];
               $live_stripe_public_key = $site_setting_arr['live_stripe_public_key'];
               $live_stripe_secret_key = $site_setting_arr['live_stripe_secret_key'];

               if($payment_mode=='0' && isset($site_setting_arr['sandbox_stripe_secret_key']))
               {
                  $stripe_secret_key =  $site_setting_arr['sandbox_stripe_secret_key'];
               }
               else if($payment_mode=='1' && isset($site_setting_arr['live_stripe_secret_key']))
               {
                   $stripe_secret_key = $site_setting_arr['live_stripe_secret_key'];
               }

          }



        $stripeToken  = isset($form_data['stripeToken'])?$form_data['stripeToken']:'';
        $subscription = isset($form_data['subscription'])?$form_data['subscription']:'';
        $subscription = isset($form_data['subscription'])?$form_data['subscription']:'';
        $card_number =  isset($form_data['card_number'])?$form_data['card_number']:'';
        $card_exp_month = isset($form_data['card_exp_month'])?$form_data['card_exp_month']:'';
        $card_exp_year = isset($form_data['card_exp_year'])?$form_data['card_exp_year']:'';
        $card_cvc = isset($form_data['card_cvc'])?$form_data['card_cvc']:'';


        $get_membershipname = $this->membershipmodel->where('id',$subscription)->where('membership_type','2')->first();
        if(isset($get_membershipname) && !empty($get_membershipname))
        {
            $get_membershipname = $get_membershipname->toArray();
            $membership_name = $get_membershipname['name'];
            $membership_id = $get_membershipname['id'];
           if(isset($membership_name) && isset($membership_id))
           {

               $get_stripe_product =  $this->StripeProductsModel->where('membership_id',$membership_id)->first();

               if(isset($get_stripe_product) && (!empty($get_stripe_product)))
               {
                  $get_stripe_product = $get_stripe_product->toArray();
                  $stripe_product_id  = $get_stripe_product['pid'];
               }
               else
               {

                     try { 
                    \Stripe\Stripe::setApiKey($stripe_secret_key);
                    $stripe_create_product = \Stripe\Product::create([
                    'name' => $membership_name, 
                    'type' => 'service',
                    'metadata' => []
                    ]);
                    }catch(Exception $e) { 
                        $api_error = $e->getMessage(); 
                    } 
                    if(empty($api_error) && $stripe_create_product)
                    {
                        $stripe_create_productdata = $stripe_create_product->jsonSerialize(); 
                        $product_arr =[
                                         'pid'=>$stripe_create_productdata['id'],
                                         'name'=>$stripe_create_productdata['name'],
                                         'type'=>$stripe_create_productdata['type'],
                                         'membership_id'=>$membership_id
                                        ];    

                                   
                        $stripe_productinsert_id = $this->StripeProductsModel->create($product_arr);    
                        $stripe_product_id = $stripe_create_productdata['id'];
                   }
                 }//else of create stripe product


                 /***************if stripe productid**********/  

                 if($stripe_product_id)
                 {  
                        $get_stripe_plan =  $this->PlansModel->where('membership_id',$membership_id)->first();
                        if(isset($get_stripe_plan) && (!empty($get_stripe_plan)))
                           {
                              $get_stripe_plan = $get_stripe_plan->toArray();
                              $stripe_plan_id  = $get_stripe_plan['plan_id'];
                           }
                           else
                           {
                               try { 
                                \Stripe\Stripe::setApiKey($stripe_secret_key);
                                 $stripeplan = \Stripe\Plan::create([

                                'nickname' => $membership_name, 
                                'currency' => 'usd',
                                'interval' => 'month',
                                'product' => $stripe_product_id,
                                'amount'  => $form_data['amount']*100,
                                'metadata' => []
                                ]);
                                }catch(Exception $e) { 
                                    $api_error_plan = $e->getMessage(); 
                                } 

                                
                                   if(empty($api_error_plan) && $stripeplan)
                                    {
                                        $stripeplandata = $stripeplan->jsonSerialize(); 
                                        $plan_arr =[
                                                         'plan_id'=>$stripeplandata['id'],
                                                         'product_id'=>$stripe_product_id,
                                                         'membership_id'=>$membership_id,
                                                         'nickname'=>$membership_name
                                                        ];    
                                                   
                                        $stripe_planinsert_id = $this->PlansModel->create($plan_arr);    
                                        $stripe_plan_id = $stripeplandata['id'];

                                        $update_membership = $this->membershipmodel->where('id',$membership_id)->update(['plan_id'=>$stripe_plan_id]);

                                        $form_data['stripe_plan_id'] = $stripe_plan_id;

                                   }

                           }

                 }//if stripe productid   


           }//if membershipname name and id
        }//IF GETMEMBERSHIP NAME
      }//IF USER ROLE IS SELLER

       
        $response = $this->UserService->user_registration($form_data);
        
        return response()->json($response);
        
    }//end of process signup function





    /* public function does_businessname_exist(Request $request)
    {

        $user = Sentinel::check();

        $input['business_name'] = $request->input('business_name');

        $rules = array('business_name' => 'unique:business_name,business_name');

        $validator = Validator::make($input, $rules);

        if($validator->fails()) 
        {
            return response()->json(['exists'=>'true'],404);         
        }
        else
        {   
            return response()->json(['exists'=>'false']); 
            
        }
    }*/





    public function login($productid=NULL)
    {
     
      Session::forget('welcomeusertype'); 
      Session::forget('welcomeuseremail'); 

        if($login_user = Sentinel::check())
        {
            $panel_dashboard_url = "";
            if($login_user->inRole('buyer')){
              
              // $panel_dashboard_url = url()->previous();
              $panel_dashboard_url = url('/');
            }
            elseif($login_user->inRole('seller')){
              
              // $panel_dashboard_url = url()->previous();
              $panel_dashboard_url = url('/');
            }
            
            elseif($login_user->inRole('admin'))
            {
              $this->arr_view_data['page_title'] = 'SignIn';

              return view($this->module_view_folder.'.login',$this->arr_view_data);
            }
            
            return redirect($panel_dashboard_url);
        }
        else {

            $this->arr_view_data['page_title'] = 'SignIn';
            $this->arr_view_data['productid'] = isset($productid)?$productid:'';

            return view($this->module_view_folder.'.login',$this->arr_view_data);
        }	
    }

    public function process_login(Request $request)
    {   
       
        $form_data = $request->all();

        try
        {
          //check email present or not 
          $is_email_exist = $this->UserModel->where('email',$form_data['email'])->count();

          if($is_email_exist == 0)
          {
              $response = [
                              'status'  =>'ERROR',
                              'message' =>'User not exists in the system.'
                          ];

              return response()->json($response);     
          }



          /* Check Validations and display custom message*/
            $arr_rules = [
                            'email'    => 'required|email',
                            'password' => 'required'
                         ];

            if(Validator::make($request->all(),$arr_rules)->fails())
            {
                $response = [
                                'status'  =>'ERROR',
                                'message' =>'Form validation failed..Please check all fields'
                            ];

                return response()->json($response);     
            }


            //check valid otp 
            if(isset($form_data['otp']) && $form_data['otp']!='')
            {
               $request->email = $form_data['email'];
               $request->otp   = $form_data['otp'];

               $response = $this->otp_verification($request);

               if($response['status'] == 'ERROR')
               {
                    $response['status']  = 'ERROR';
                    $response['message'] = "Invalid OTP";
                                
                    return response()->json($response);
               }

            }


            /*if buyer/seller login after 90 days then send otp to him*/

                $registration_date = $phonecode ='';
                $user_arr = [];   
                $current_date    = date('Y-m-d');

                $user = $this->UserModel->where('email',$form_data['email'])->first();
                
                //$last_login_date = $this->UserModel->where('email',$form_data['email'])->pluck('last_login')->first();
                
                $user_details = $this->UserModel->where('email',$form_data['email'])->select('last_login','created_at')->first();

                if(isset($user_details))
                {
                   $user_arr = $user_details->toArray(); 
                }

                $last_login_date = isset($user_arr['last_login'])?date('Y-m-d', strtotime($user_arr['last_login'])):$user_arr['created_at'];

                $diff = strtotime($current_date) - strtotime($last_login_date); 
 
                $days = intval(abs(round($diff / 86400))); 


                if($days >=90)
                { 

                    $buyer_details_arr = $site_setting_arr = [];

                    //generate otp 

                    $otp = rand(1000,9999);

                    Session::put('otp',$otp);

                    $site_setting_obj = SiteSettingModel::first();  

                    if(isset($site_setting_obj))
                    {
                        $site_setting_arr = $site_setting_obj->toArray();            
                    }

                    if(isset($site_setting_arr) && count($site_setting_arr)>0)
                    {
                         $twilio_account_sid = isset($site_setting_arr['twilio_account_sid'])?$site_setting_arr['twilio_account_sid']:'';
                         $twilio_auth_token = isset($site_setting_arr['twilio_auth_token'])?$site_setting_arr['twilio_auth_token']:'';
                         $twilio_from_number = isset($site_setting_arr['twilio_from_number'])?$site_setting_arr['twilio_from_number']:'';

                    }//isset site setting arr


                    //send email for otp
                    $user_name = '';
                    $first_name = isset($user->first_name)?$user->first_name:'';
                    $last_name  = isset($user->last_name)?$user->last_name:'';

                    $user_name = $first_name.' '.$last_name;

                    $arr_built_content = [
                                   
                                           'FIRST_NAME'     => isset($user_name)?$user_name:'',
                                           'APP_NAME'       => config('app.project.name'),
                                           'OTP'            => $otp
                                        ];

                    $arr_mail_data['email_template_id'] = '148';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';

                    $user_details = $this->UserModel->where('email',$form_data['email'])->first();

                    if(isset($user_details))
                    {
                      $user_details_arr = $user_details->toArray();
                    }

                    $arr_mail_data['user'] = $user_details_arr;
                      

                    $this->EmailService->send_mail_section($arr_mail_data);


                    //send text notification
                    if(isset($user->phone) && $user->phone!='')
                    { 

                        $getbuyercountry = isset($user->country)? get_countryDetails($user->country):'';


                        if(isset($getbuyercountry) && !empty($getbuyercountry))
                        {
                            $phonecode = isset($getbuyercountry['phonecode'])?$getbuyercountry['phonecode']:'';

                            $account_sid = isset($twilio_account_sid)?$twilio_account_sid: config('app.project.account_sid');
                            $auth_token = isset($twilio_auth_token)?$twilio_auth_token:config('app.project.auth_token');

                            $url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/SMS/Messages";
                            $to = "+".$phonecode.$user->phone;

                            $from = isset($twilio_from_number)?$twilio_from_number:config('app.project.from'); // twilio trial 


                            // $body = "Please click here ".$buyer_profile_url." for order ".$order_no." to shipped.";

                            $body = "Please enter following Otp: ".$otp;

                            $data = array (
                                'From' => $from,
                                'To' => $to,
                                'Body' => $body,
                            );
                            $post = http_build_query($data);
                            $x = curl_init($url );
                            curl_setopt($x, CURLOPT_POST, true);
                            curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                            curl_setopt($x, CURLOPT_USERPWD, "$account_sid:$auth_token");
                            curl_setopt($x, CURLOPT_POSTFIELDS, $post);
                            $y = curl_exec($x);

                            curl_close($x);
                              

                        }//if getcountry




                        $response['status']  = 'Warning';
                        $response['message'] = $otp;
                                    
                        return response()->json($response);


            
                    }//if isset phone
      


                }

          
               /*--------------------------------------------------*/




            $obj_user = $this->BaseModel->where('email',$request->input('email'))->first();


            /****if user is from the guest page and enter seller email credetial for login then show error****/

            if($obj_user)
            {
                $usertype = isset($obj_user->user_type)?$obj_user->user_type:'';

                $guest_isbuyer = isset($request->guest_signup_buyer)?$request->guest_signup_buyer:'';

                if(isset($guest_isbuyer) && $guest_isbuyer==1 && isset($usertype) && $usertype!='buyer')
                {
                    $response = [
                                'status'  =>'ERROR',
                                'message' =>'Please login with the buyer'
                            ];

                   return response()->json($response);   
                }//if user is from the guest page and enter seller email credetial for login 

            }//if obj user

            


            
            $credentials =  [
                                'email'    => $request->input('email'),
                                'password' => $request->input('password')
                            ];

            $remember_me = $request->has('remember_me') ? true : false; 
          
            $check_authentication = Sentinel::authenticate($credentials,$remember_me);

            if($check_authentication)
            {
                if(isset($remember_me) && $remember_me == "true")
                {
                    setcookie("email",$request->input('email'),time()+ (10 * 365 * 24 * 60 * 60));
                    setcookie("password",$request->input('password'),time()+ (10 * 365 * 24 * 60 * 60));
                    setcookie("rememberd",'rememberd',time()+(10 * 365 * 24 * 60 * 60));
                }
                else 
                {
                  setcookie("email",'');
                  setcookie("password",'');
                  setcookie("rememberd",'');
                }

                $user = Sentinel::check();  
           
               

                
                if($user->inRole('buyer') || $user->inRole('seller') || $user->inRole('admin'))
                { 
                    if($user->is_active == '1')
                    {

                       // if($user->is_trusted == '1')
                        //{ 

                        
                                //if two factor verification enable then redirect user to opt verification page
                                if($user->inRole('seller'))
                                {   
                                    /*******make free entry in db***25-june20*********************/
                                      $get_subscriptiondata = $this->UserSubscriptionsModel
                                        ->where('user_id',$user->id)
                                        ->get()->toArray();   
                                      if(empty($get_subscriptiondata))
                                      {

                                         $get_free_subscription = $this->membershipmodel->where('membership_type','1')->where('is_active','1')->first();

                                           if(isset($get_free_subscription) && !empty($get_free_subscription))
                                           {

                                              $get_free_subscription = $get_free_subscription->toArray();
                                              $membership_id = $get_free_subscription['id'];
                                              $product_count = $get_free_subscription['product_count'];
                                              $mem_amount = $get_free_subscription['price'];
                                              $mem_type = $get_free_subscription['membership_type'];

                                          

                                              $arr_subscription = [];

                                              $arr_subscription['transaction_id'] = '';
                                              $arr_subscription['payment_status'] = '0';
                                              $arr_subscription['user_id']       = $user->id;
                                              $arr_subscription['membership_id'] = $membership_id ;
                                              $arr_subscription['membership'] = $mem_type;
                                              $arr_subscription['membership_amount'] = $mem_amount;
                                              $arr_subscription['membership_status'] = '1';
                                              $arr_subscription['product_limit'] = $product_count;

                                              $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);

                                          }//get free subscription

                                      }//if get subscription data

                                      /*********free**entry in db****25-june20**************/


                                   $check_usercode_exists = $this->BaseModel->where('id',$user->id)->first();
                                   
                                    if(isset($check_usercode_exists) && !empty($check_usercode_exists))
                                    {
                                      $check_usercode_exists = $check_usercode_exists->toArray();

                                      if(isset($check_usercode_exists['referal_code']) && !empty($check_usercode_exists['referal_code']))
                                      {

                                      }
                                      else
                                      {

                                          $create_referalcode = unique_code(8);
                                          $check_code_exists = $this->BaseModel->where('referal_code',$create_referalcode)->get();
                                          if(isset($check_code_exists) && !empty($check_code_exists))
                                          {
                                            $check_code_exists = $check_code_exists->toArray();
                                          }
                                          if(isset($check_code_exists) && !empty($check_code_exists))
                                          {
                                            $create_referalcode = unique_code(8);
                                          }else{
                                            $create_referalcode = $create_referalcode;
                                          }
                                          $update_referalcode =[];
                                          $update_referalcode['referal_code'] = $create_referalcode;

                                          $this->BaseModel->where('id',$user->id)->update($update_referalcode);
                                      }//else of user code exists
                                   }//if user code exists
                                   
                                   

                                    // get site setting array
                                    $site_setting_arr = [];
                                    $site_setting_obj = SiteSettingModel::first();  
                                    if(isset($site_setting_obj))
                                    {
                                        $site_setting_arr = $site_setting_obj->toArray();            
                                    }
                                    if(isset($site_setting_arr) && count($site_setting_arr)>0)
                                    {
                                         $payment_mode = $site_setting_arr['payment_mode'];
                                         $sandbox_url = $site_setting_arr['sandbox_url'];
                                         $live_url = $site_setting_arr['live_url'];
                                         $sandbox_access_token = $site_setting_arr['sandbox_access_token'];
                                         $live_access_token = $site_setting_arr['live_access_token'];
                                         $sandbox_location_id = $site_setting_arr['sandbox_location_id'];
                                         $live_location_id = $site_setting_arr['live_location_id'];
                                    }

                                    



                                /*  
                                
                                   // get subscription data
                                     $get_subscriptiondata = $this->UserSubscriptionsModel
                                        ->where('user_id',$user->id)
                                      //  ->where('membership','Free')
                                        ->where('membership_status','1')
                                        ->orderBy('id','desc')
                                        ->get()->toArray();   

                                  if(!empty($get_subscriptiondata) && (isset($get_subscriptiondata)))
                                  {    


                                    $user_sub_id = $get_subscriptiondata[0]['id'];    
                                    $membership_amount = $get_subscriptiondata[0]['membership_amount'];
                                    $membership_id = $get_subscriptiondata[0]['membership_id'];
                                    $payment_status = $get_subscriptiondata[0]['payment_status'];
                                    $transaction_id = $get_subscriptiondata[0]['transaction_id'];
                                    $currendate = date('Y-m-d'); 
                                    if(isset($transaction_id) && $membership_status=='1')
                                    {

                                    }// if customer id and customer card id
                                    else{

                                     Sentinel::logout();
                                     Session::flush();   
                                     $response['status']  = 'ERROR';
                                     $response['message'] = 'Sorry there is an problem with subscription.';
                                      return response()->json($response);
                                    }

                                 }//if subscription data
                                 */

                                   $response['status']           = 'SUCCESS';
                                   $response['message']          = 'You have logged in successfully';
                                      $this->BaseModel->where('email',$user->email)->update(['timeout'=>"",'login_attempt'=>'0']);
     

                                    $is_complete = $this->GeneralService->is_profile_complete($user);
                                    if ($is_complete == 'business_profile') {
                                        
                                       $response['user_redirection'] = url('/seller/profile');
                                      //  $response['user_redirection'] = url('/');
                                    }
                                    elseif($is_complete == 'account_setting'){
                                      $response['user_redirection'] = url('/seller/profile');
                                     //  $response['user_redirection'] = url('/');
                                    }
                                    else{
                                        $response['user_redirection'] = url('/seller/profile');
                                        // $response['user_redirection'] = url('/');
                                    }
                                    
                                    return response()->json($response); 

                                }//if role is seller 

                                if($user->inRole('buyer'))
                                {
                                   
                                    $update_modalarr = [];
                                    if($user->is_checkout_signup==1 && $user->is_guest_user==1 && $user->show_passwordmodal_afterlogin==0)
                                    {
                                        $update_modalarr['show_passwordmodal_afterlogin'] = 1;
                                       $modalupdated = $this->BaseModel->where('email',$user->email)->update($update_modalarr);
                                    }



                                   $session_id = $this->get_session_id();
                                   $ip_address = $this->get_ip_address();

                                   $checkcartdata_atlogin = [];

                                   $checkcartdata_atlogin = $this->checkcartdata_atlogin($session_id,$ip_address);

                                    if(isset($checkcartdata_atlogin) && !empty($checkcartdata_atlogin))
                                    {

                                      $update_cartdataat_login =  $this->update_cartdataat_login($checkcartdata_atlogin);

                                      
                                    }


                                    $update_user_id = $this->update_user_id_after_login();

                                     
                                    $bag_obj = $this->TempBagModel->where('buyer_id',$user->id)->first();

                                    if($bag_obj)
                                    {
                                        $response['redirect_checkout']  = 'redirect_checkout';

                                    }
                                    
                                     /********************************************/
                                            $check_usercode_exists = $this->BaseModel->where('id',$user->id)->first();

                                   
                                            if(isset($check_usercode_exists) && !empty($check_usercode_exists))
                                            {
                                              $check_usercode_exists = $check_usercode_exists->toArray();

                                              if(isset($check_usercode_exists['referal_code']) && !empty($check_usercode_exists['referal_code']))
                                              {

                                              }
                                              else
                                              {

                                                  $create_referalcode = unique_code(8);
                                                  $check_code_exists = $this->BaseModel->where('referal_code',$create_referalcode)->get();
                                                  if(isset($check_code_exists) && !empty($check_code_exists))
                                                  {
                                                    $check_code_exists = $check_code_exists->toArray();
                                                  }
                                                  if(isset($check_code_exists) && !empty($check_code_exists))
                                                  {
                                                    $create_referalcode = unique_code(8);
                                                  }else{
                                                    $create_referalcode = $create_referalcode;
                                                  }
                                                  $update_referalcode =[];
                                                  $update_referalcode['referal_code'] = $create_referalcode;

                                                  $this->BaseModel->where('id',$user->id)->update($update_referalcode);
                                              }//else of user code exists
                                           }//if user code exists

                                     /********************************************/




                                    $response['status']           = 'SUCCESS';
                                    $response['message']          = 'You have logged in successfully';
                                    $this->BaseModel->where('email',$user->email)->update(['timeout'=>"",'login_attempt'=>'0']);

                                    $is_complete = $this->GeneralService->is_profile_complete($user);
                                    if ($is_complete == 'true') 
                                    {
                                         
                                        //  $response['user_redirection'] = url('/'); // commented
                                        // $response['user_redirection'] = URL::previous(); 
                                        $response['user_redirection'] = '-1';
                                    }                        
                                    else{
                                            //$response['user_redirection'] = url('/').'/buyer/profile';
                                          //  $response['user_redirection'] = url('/'); // commented
                                            $response['user_redirection'] = '-2';
                                            //Session::flash('message','Please fill all the required  profile fields'); 
                                       
                                    }

                                    return response()->json($response);
                                }//if role is buyer
                                if($user->inRole('admin'))
                                {

                                    $response['status']           = 'SUCCESS';
                                    $response['message']          = 'You have logged in successfully';
                                    $this->BaseModel->where('email',$user->email)->update(['timeout'=>"",'login_attempt'=>'0']);

                                     $response['user_redirection'] = url('/');
                                     return response()->json($response);
                                }
                              
                                //check whether user upload ID proof or not if not uploaded then redirect to my profile page with message
                                 
                               /* if($user->id_proof =='')
                                {
                                    $response['status']           = 'SUCCESS';
                                    $response['message']          = 'You have logged in successfully, please upload your id proof first';
                                    $response['user_redirection'] = url('/profile');

                                    return response($response);    
                                }
                                
                              


                                if(Session::has('redirect_to'))
                                {
                                    $redirect_to = Session::get('redirect_to');
                                    
                                    Session::forget('redirect_to');
                                }
                                else
                                {
                                    $redirect_to = url('/');
                                }

                                $response['status']           = 'SUCCESS';
                                $response['message']          = 'You have logged in successfully';
                                $response['user_redirection'] = $redirect_to;

                                return response()->json($response);*/ // commented at 17-march-20

                   /* }
                    else 
                    {   
                        Sentinel::logout();
                        Session::flush();

                        $response['status']  = 'ERROR';
                        $response['message'] = 'Your account is not verified.';
                        return response()->json($response);
                    }*/
                    
                    }//if user active
                     elseif($user->is_active=='0' && $user->login_attempt=='4' && isset($user->timeout))
                    {   
                        Sentinel::logout();
                        Session::flush();

                        $response['status']  = 'ERROR';
                        $response['message'] = 'Your account is blocked, please try again after 10 minutes.';
                        return response()->json($response);
                    }
                    else
                    {   
                        Sentinel::logout();
                        Session::flush();

                        $response['status']  = 'ERROR';
                        $response['message'] = 'Your account is blocked by admin,please contact to admin for activating account.';
                        return response()->json($response);
                    }
                    
                }
                else
                {
                    Sentinel::logout();
                    Session::flush();

                    $response['status']  = 'ERROR';
                    $response['message'] = 'Not sufficient privileges';
                    return response()->json($response);
                }
                
            }
            else
            {

                // $response['status']  = 'ERROR';
                // $response['message'] = 'Email or password is not valid. please try again.';
                // return response()->json($response);

                $responcearr =  $this->incrementloginattempts($request->input('email'));
                return response()->json($responcearr);

            }

        }
        catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e)
        {   
            $response['status']  = 'ERROR';
            $response['message'] = $e->getMessage();
            return response()->json($response);
            
        }
        catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) 
        {   
            $response['status']  = 'ERROR';
            $response['message'] = 'Your email is not verified, please verify your email from an email account.';
            return response()->json($response);
        }
    }



    public function otp_verification(Request $request)
    {  
        $otp   = $request->input('otp');
        $email = $request->input('email');
       // $password = $request->input('password');

        $date = date('Y-m-d H:i:s');

        $exist_otp = Session::get('otp');

        if(intval($otp) == intval($exist_otp))
        {
            $data['last_login'] = $date;

            $result = $this->UserModel->where('email',$email)->update($data);

            Session::forget('otp');


         /*   $remember_me = false;

            $credentials = [
                'email'    => $email,
                'password' => $password,
            ];
            //check user details
            $user = Sentinel::findByCredentials($credentials);
            //make autologin
            $chk_auth = Sentinel::login($user);*/

            $response['status']   = 'SUCCESS';
            $response['message']  = 'You have logged in successfully';

           
          
        }
        else
        {
          $response['status']  = 'ERROR';
          $response['message'] = 'Please enter valid OTP';

        }

        return $response;


    }

  function incrementloginattempts($email)
  {
   
    $get_user = $this->BaseModel
                        ->where('email',$email)
                        ->first();
    if(!empty($get_user))
    {
      $get_user = $get_user->toArray();
      $dblogin_attempt = $get_user['login_attempt'];
      $timeout = $get_user['timeout'];

      /***************set business name*****/
         $setname ='';
         if($get_user['user_type']=="seller")
         {
             $get_seller_detail = SellerModel::where('user_id',$get_user['id'])->first();
             if(!empty($get_seller_detail)){
               $get_seller_detail = $get_seller_detail->toArray();
               if($get_user['first_name']=="" && $get_user['last_name']==""){
                 $setname =    $get_user['email']; 
               }else{
                 $setname = $get_user['first_name'];
               }
             }
         }
         else if($get_user['user_type']=='buyer')
         {
            if($get_user['first_name']==""){
                $setname = 'Buyer';
            }else{
                $setname = $get_user['first_name'];
            }
            
         }

      /************************************/


      
        if($get_user['login_attempt']>='4'){

           $this->BaseModel->where('email',$email)->update(['is_active'=>'0','timeout'=>date("Y-m-d H:i:s")]);

           /*****************Send Mail Notification to User (START)***************/

              $arr_event                 = [];
              $arr_event['from_user_id'] = 1;
              $arr_event['to_user_id']   = $get_user['id'];
              $arr_event['description']  = html_entity_decode('Too many unsuccessful attempts have been made on your account.');
              $arr_event['type']         = '';
              $arr_event['title']        = 'Suspicious login attempts';

              $this->GeneralService->save_notification($arr_event);

              $to_user = $get_user['id'];

              $f_name  = isset($get_user['first_name'])?$get_user['first_name']:'';
              $l_name  = isset($get_user['last_name'])?$get_user['last_name']:'';

            /*  $msg     = html_entity_decode('Unauthorized activity occured on your acccount, please change your account password. <br/> If you are that user then please ignore this email.');*/

              
              //$subject = 'Suspicious login attempts';

              $arr_built_content = [
                                   // 'USER_NAME'   => $f_name.' '.$l_name,
                                    'USER_NAME'     => $setname,
                                    'APP_NAME'      => config('app.project.name')
                                   ];

              $arr_mail_data['email_template_id'] = '45';
              $arr_mail_data['arr_built_content'] = $arr_built_content;
              $arr_mail_data['arr_built_subject'] = '';
              $arr_mail_data['user']     = $get_user;
              

               $this->EmailService->send_mail_section($arr_mail_data);

            /*****************Send Mail Notification to User (END)*****************/

             $response = [];

             $response['status']  = 'ERROR';
             $response['message'] = 'Too many unsuccessful attempts have been made, your account is get blocked for 10 minutes.';
            // return response()->json($response);
             return $response;

        }
        else
        {
          $this->BaseModel->where('email',$email)->update(['login_attempt'=>$dblogin_attempt+1]);
          $response = [];   
          $response['status']  = 'ERROR';
          $response['message'] = 'Email or Password is not valid. Please try again.';

         // return response()->json($response);
           return $response;

        }

    }
    else{

          $response = [];   
          $response['status']  = 'ERROR';
          $response['message'] = 'Email is not valid. Please try again.';
          return $response;
    }

  }//end of login attempt function




    public function otp_verify()
    {
        $user = Sentinel::check();
        if($user)
        {
            if($user->inRole('buyer') || $user->inRole('seller'))
            {
                return view($this->module_view_folder.'.verify_otp');                
            }else{
                return redirect('login');
            }
        }else{
            return redirect('login');
        }        
    }

    public function process_otp_verification(Request $request)
    {
        $user_model    = new UserModel();
        $user          = Sentinel::check();
        $secretkey     = $user->google2fa_secret;
        $currentcode   = $request->input('otp');
        $g_auth_status = $request->input('enable');

        include_once('library/rfc6238.php');

        if (\TokenAuth6238::verify($secretkey,$currentcode)) 
        {
           $request->session()->put('otp_verified', true);

            if($g_auth_status!=null)
            {
               $arr_data = [];
               $arr_data['google2fa_status'] = isset($g_auth_status)?$g_auth_status:0;

               $user_model->where('id',$user->id)->update($arr_data);
            }   

            if(Session::has('redirect_to'))
            {
                $redirect_to = Session::get('redirect_to');
                Session::forget('redirect_to');
            }
            else
            {
               $redirect_to = url('/');
            }

            $response['status']           = 'success';
            $response['description']      = 'OTP verified successfully';
            $response['user_redirection'] = $redirect_to;

           return response()->json($response);  
        }
        else
        {   
            $response['status']           = 'failure';
            $response['description']      = 'Invalid OTP';

            return response()->json($response);   
        }
    }

    public function activate_account($code = false,$hidden_productid=NULL)
    {

        if($code == false)
        {
            return redirect('/');
        }

        $activation = Activation::createModel()->where(['code' => $code])->first();

        if($activation == false)
        {
            return redirect('/');   
        }

        $user = Sentinel::findById($activation->user_id);

        if(Activation::completed($user) == true)
        {
            Flash::success('Your account is already verified, please login.');

            return redirect('/login');    
        }

        if (Activation::complete($user, $code))
        {           
            Flash::success('Your account has been activated successfully, Please Login.');
            // this code commented for product cart redirection condition and new condition added.
            //return redirect('/login');

            if(isset($hidden_productid))
            {
                return redirect('/login/'.$hidden_productid);
            }else{
                return redirect('/login');
            }
            
            
        }
    }

    public function my_profile()
    {
        $buyer_arr = $seller_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

        $countries_arr = $this->CountriesModel->get()->toArray();

        // dd($countries_arr);

        if($user_details->inRole('buyer'))
        {
            $buyer_obj = $this->BuyerModel->where('user_id',$user_details->id)->first();
            if($buyer_obj)
            {
                $buyer_arr = $buyer_obj->toArray();                 
                $user_details_arr['user_details']  = $buyer_arr;
            }
        }
        elseif($user_details->inRole('seller'))
        {
            $seller_obj = $this->SellerModel->where('user_id',$user_details->id)->first();

            if($seller_obj)
            {
                $seller_arr = $seller_obj->toArray();
                $user_details_arr['user_details']  = $seller_arr;
            }
        }

        $this->arr_view_data['id_proof_public_path'] = $this->id_proof_public_path;
        $this->arr_view_data['profile_img_path']     = $this->profile_img_public_path;
        $this->arr_view_data['user_details_arr']     = $user_details_arr;
        $this->arr_view_data['countries_arr']        = $countries_arr;
        $this->arr_view_data['page_title']           = 'My-Profile';

        // dd($this->arr_view_data);

        return view($this->module_view_folder.'.my-profile',$this->arr_view_data);
    }

    public function update_profile(Request $request)
    {
        $user_id = 0;

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;
        }
        
        $arr_rules = [
                        'user_name'      => 'required',
                       
                        
                        'contact_no'     => 'required|min:6|max:15',
                        
                        // 'location'       => 'required',
                        // 'lat'            => 'required',
                        // 'lng'            => 'required',
                      //'profile-image'  => 'required|image|mimes:jpeg,png,jpg',
                     ];
        
        if($request->present_id_proof=='')
        {
            $arr_rules['id_proof'] = 'required|mimes:jpeg,png,jpg,pdf';
        }

        if(Validator::make($request->all(),$arr_rules)->fails())
        {
            $response = [
                            'status'    =>'ERROR',
                            'message'   =>'Please enter all required fields'
                        ];

            return response()->json($response);     
        }

        $does_exists = $this->BaseModel->where('id','<>',$user_id)
                                       ->where('email',$request->input('email'))
                                       ->count()>0;  
    
        if($does_exists)
        {
            $response['status']      = 'warning';
            $response['message'] = 'This email already exists. Please try with diffrent email ID';

            return response()->json($response);
        }  

        if($request->hasFile('profile-image'))
        {
            $file_extension = strtolower($request->file('profile-image')->getClientOriginalExtension());          

            if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $file_name = time().uniqid().'.'.$file_extension;                    
                $request->file('profile-image')->move($this->profile_img_base_path, $file_name);
            }
            else
            {
                $response['status']  = 'ERROR';
                $response['message'] = 'Please select valid profile image, only jpg, png and jpeg file are allowed';

                return response()->json($response);
            }            
            
            $unlink_old_img_path = $this->profile_img_base_path.'/'.$request->input('old_profile_img');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
           $file_name = $request->input('old_profile_img');
        }

        $obj_user = $this->BaseModel->where('id',$user_id)->first();

        $arr_user = [];
        if($obj_user)
        {
            $arr_user = $obj_user->toArray();
        }

        $id_proof = $request->present_id_proof;
        if($request->hasFile('id_proof'))
        {
            $file                = $request->file('id_proof');
            $id_proof_extension  = strtolower($file->getClientOriginalExtension());
            // $size       = $file->getClientSize();

            // if($size>$proof_max_size) 
            // {
            //     $response['status']  = 'ERROR';
            //     $response['message'] = 'goods bill of ladding file size should be less than 2 mb';
            //     return response()->json($response);
            // }

            if(in_array($id_proof_extension,['jpg','png','jpeg','JPG','PNG','JPEG','pdf','PDF']))
            {                           
                $id_proof = time().uniqid().'.'.$id_proof_extension;                    

                //if file exist then delete it 
                if(file_exists($this->id_proof_base_path.$arr_user['id_proof']))
                {
                    @unlink($this->id_proof_base_path.$arr_user['id_proof']);  
                }

                //store new file
                $request->file('id_proof')->move($this->id_proof_base_path, $id_proof);
                $credentials['is_trusted']        =   1;

            }
            else
            {
                $response['status']  = 'ERROR';
                $response['message'] = 'Please select valid file for id Proof';

                return response()->json($response);
            } 
        }



        $credentials['user_name']       =   $request->input('user_name');
        $credentials['email']           =   $request->input('email');
        $credentials['phone']           =   $request->input('contact_no');
        $credentials['profile_image']   =   $file_name;
        $credentials['id_proof']        =   $id_proof;

        $user = Sentinel::findById($user_id);

        $user = Sentinel::update($user, $credentials);

        if($user) 
        {
           

            $response['status']  = 'SUCCESS';
            $response['message'] = 'Your profile updated successfully';

            return response()->json($response);
        }        
        else
        {
            $response['status']  = 'ERROR';
            $response['message'] = 'Problem ocured while updating profile please try again';

            return response()->json($response);
        }

    }


    public function change_password()
    {

        $user = Sentinel::getUser();
        if($user->inRole('buyer')){
            $module_view_folder  = 'buyer/profile';
        }
        else
        {
             $module_view_folder = 'seller';
        }
       
        $this->arr_view_data['page_title'] = 'Change Password';
        return view($module_view_folder.'.change-password',$this->arr_view_data);
    }

    public function update_password(Request $request)
    {
        $credentials = $new_credentials = [];

        $this->arr_view_data['page_title']   = 'Change-Password';
        
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(),[
            'current_password'  => 'required',
            'new_password'      => 'required|min:8|max:16|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}$/',
            'cnfm_new_password' => 'required|same:new_password'
            ]);

            if($validator->fails())
            {
                $response['status'] = 'FAILURE';
                $response['message']= 'Required fields are missing';

                return response()->json($response);
            }

            $curr_password = $request->input('current_password');
            $new_password  = $request->input('new_password');

            $user = Sentinel::check();
    
            $credentials['password'] = $curr_password;

            if(Sentinel::validateCredentials($user,$credentials)) 
            {                 
                $new_credentials['password'] = $new_password;

                if(isset($user->show_passwordmodal_afterlogin) && ($user->show_passwordmodal_afterlogin==1 || $user->show_passwordmodal_afterlogin==0))
                {
                    $new_credentials['show_passwordmodal_afterlogin'] = 0;
                    $new_credentials['is_password_changed'] = 1;
                }


                if(Sentinel::update($user,$new_credentials))
                {
                    $response['status']  = 'SUCCESS';
                    $response['message'] = 'Password updated successfully';
                    return response()->json($response);
                }
                else
                {
                    $response['status'] = 'FAILURE';
                    $response['message']= 'Error occured while changing password, Please try again later';                    
                    return response()->json($response);
                }
            } 
            else
            {
                return response()->json(['status' => 'FAILURE','message' => 'You have entered wrong current password']);
            }   
        }
        else
        {
            $module_view_folder = 'buyer/profile';
            return view($this->module_view_folder.'.change-password',$this->arr_view_data);
        }        
    }

    public function does_old_password_exist(Request $request)
    {
        $user = Sentinel::check();

        $credentials['password'] = $request->input('current_password');

        if(Sentinel::validateCredentials($user,$credentials)) 
        {
            return response()->json(['exists'=>'false']);            
        }
        else
        {
            return response()->json(['exists'=>'true'],404);
        }
    }

    public function does_emailid_exist(Request $request)
    {

        $user = Sentinel::check();

        // $credentials['email'] = $request->input('email');
        $input['email'] = $request->input('email');

        $rules = array('email' => 'unique:users,email');

        $validator = Validator::make($input, $rules);

        if($validator->fails()) 
        {
            return response()->json(['exists'=>'true'],404);         
        }
        else
        {   
            return response()->json(['exists'=>'false']); 
            
        }
    }

    public function forgot_password(Request $request)
    {



        if($request->isMethod('post'))
        {

            $credentials['email'] = $request->input('email');

            $user = Sentinel::findByCredentials($credentials);
            
            if($user)
            {
              

              /***************Email*valiation library code*******/
              $validator = EmailValidatorFactory::create($request->input('email'));
              $arrayResult = $validator->getValidationResults()->asArray();
              
             
              if(isset($arrayResult) && !empty($arrayResult))
              {
                $valid_format = isset($arrayResult['valid_format'])?$arrayResult['valid_format']:'';
                $valid_mx_records = isset($arrayResult['valid_mx_records'])?$arrayResult['valid_mx_records']:'';
                $possible_email_correction = isset($arrayResult['possible_email_correction'])?$arrayResult['possible_email_correction']:'';
                $free_email_provider = isset($arrayResult['free_email_provider'])?$arrayResult['free_email_provider']:'';
                $role_or_business_email = isset($arrayResult['role_or_business_email'])?$arrayResult['role_or_business_email']:'';
                $valid_host = isset($arrayResult['valid_host'])?$arrayResult['valid_host']:'';
                $disposable_email_provider = isset($arrayResult['disposable_email_provider'])?$arrayResult['disposable_email_provider']:'';
                 if($valid_format==true && $valid_mx_records==true && $disposable_email_provider==false)
                 {

                 }else{
                    $response['status'] = 'ERROR';
                    $response['message']    = 'Please use valid email this email is not supported.';
                    return response()->json($response);
                 }  

              }

            /***********Email validation library code*end****************/


                $setname ='';
                if($user->inRole('seller')==true)
                {
                     $get_seller_detail = SellerModel::where('user_id',$user->id)->first();
                     if(!empty($get_seller_detail)){
                       $get_seller_detail = $get_seller_detail->toArray();
                       if($user->first_name=="" && $user->last_name==""){
                         $setname =    $user->email; 
                       }else{
                         $setname = $user->first_name;
                       }
                     }
                }
                else if($user->inRole('buyer')==true)
                {
                    if($user->first_name=="" || $user->last_name==""){
                        $setname = "Buyer";
                    }else{
                         $setname = $user->first_name;
                    }
                }


                if ($user->inRole('admin') == false) {
                    $reminder = Reminder::create($user);

                    $password_reset_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url('/').'/reset_password/'.$reminder->code.'">Reset Password</a><br/>';
               
                    $arr_built_content = [
                                         // 'FIRST_NAME'     => $user->first_name,
                                          'FIRST_NAME'     => $setname,
                                          'REMINDER_URL'   => $password_reset_url,
                                          'EMAIL'          => $user->email,
                                          'SITE_URL'       => config('app.project.name')];

                    $arr_mail_data['email_template_id'] = '7';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = $user;

                    try{                
                        $is_mail_sent = $this->EmailService->send_mail_section($arr_mail_data);
                 
                    }catch(\Exception $e){
                        $response['status']   = 'ERROR';
                        $response['message']  = $e->getMessage();

                        return response()->json($response);
                    }

                    $response['status']  = 'SUCCESS';
                    $response['message'] = 'Email sent to '.$user->email.', please check your email account for further instructions.';

                    return response()->json($response);
                }
                else{

                    $response['status']   = 'ERROR';
                    $response['message']  = "Please enter user email id";

                    return response()->json($response);
                }


                
            }//if user
            else{

                $response['status']   = 'ERROR';
                $response['message']  = "Account does not exist with this <b>".$credentials['email']."</b>, please try another one.";

                return response()->json($response);
            }           
        }
        else
        {
            return view($this->module_view_folder.'.forgot_password',$this->arr_view_data);            
        }
    }

    public function reset_password($code = false)
    {
        $this->arr_view_data['page_title'] = 'Reset Password';

        if($code == false)
        {
            return redirect('/');
        }

        $reminder = Reminder::createModel()->where(['code' => $code])->first();

        if($reminder == false)
        {
            return redirect('/');   
        }

        $user = Sentinel::findById($reminder->user_id);

       // if(Reminder::exists($user) == true)   // commented at 25-feb-20
        if(Reminder::exists($user,$code) == $reminder)     
        {
            
            $this->arr_view_data['code'] = $reminder->code;

            return view($this->module_view_folder.'.reset_password',$this->arr_view_data);   
        }
        else
        {
           
            Flash::error('Reset password link is expired');
            return redirect('/');     // commented at 25-feb-20    
           
        }
    }

    public function process_reset_password(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code'             => 'required',
            'new_password'     => 'required|min:6|max:16',
            'cnfm_new_password'=> 'required|same:new_password'
        ]);

        if($validator->fails())
        {
          /*  $response['status'] = 'FAILURE';
            $response['message']= 'Required Fields Missing';

            return response()->json($response);*/

            // Flash::error('Please enter the required fields');
            return redirect()->back();   
        }




        $reminder = Reminder::createModel()->where(['code' => $request->input('code')])->first();

        if($reminder == false)
        {
            $response['status']  = 'ERROR';
            $response['message'] = 'Problem occurred while reseting password, please try again later';

            return response()->json($response);
        }

        $user = Sentinel::findById($reminder->user_id);

        if(Reminder::complete($user,$reminder->code,$request->input('new_password')) == true)
        {
            // $response['status']  = 'SUCCESS';
            // $response['message'] = 'Password resets successfully, please' . '"<a href="'.url('/login').'">click here</a>"' .'To Login';

            //$response['message'] = 'Your Account password reset successfully Please login with new password';


            Flash::success('Your account password reset successfully, please login with new password.');
            return redirect('/login');   


            // return response()->json($response);      
        }
        else
        {
           // $response['status']  = 'ERROR';
           // $response['message'] = 'Problem occurred while reseting password, Please try again later';
           // return response()->json($response);
            Flash::error('Problem occurred while reseting password,please try again later');
            return redirect()->back();   

        }
    }


    public function shipping_address(Request $request)
    {
        // dd($request->all());
        $addr_details_arr = [];

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;            
        }

        if($request->isMethod('post'))
        {
            $arr_rules = [
                        'country' => 'required',
                        'address' => 'required',
                        'state'   => 'required',
                        'city'    => 'required'
                     ];

            if(Validator::make($request->all(),$arr_rules)->fails())
            {
                $response = [
                                'status'    =>'ERROR',
                                'message'   =>'Please enter all required fields'
                            ];

                return response()->json($response);     
            }

            $address_details_arr['address']    = $request->input('address');
            $address_details_arr['lat']        = $request->input('lat');
            $address_details_arr['lng']        = $request->input('lng');
            $address_details_arr['post_code']  = $request->input('post_code');
            $address_details_arr['country_id'] = $request->input('country');
            $address_details_arr['state']      = $request->input('state');
            $address_details_arr['city']       = $request->input('city');

            $is_exist = $this->ShippingAddressModel->where('user_id',$user_id)->count()>0;

            if($is_exist)
            {
                $status = $this->ShippingAddressModel->where('user_id',$user_id)
                                                ->update($address_details_arr);
            }
            else
            {
                $address_details_arr['user_id'] = $user_id;

                $status = $this->ShippingAddressModel->create($address_details_arr);
            }
            

            if($status)
            {
                return response()->json(['status' => 'SUCCESS','message' => 'Shipping address updated successfully']);  
            }
            else
            {
                return response()->json(['status' => 'FAILURE','message' => 'Problem occured while updating shipping address']);  
            }
        }

        $countries_arr = $this->CountriesModel->get()->toArray();

        $addr_details_obj = $this->ShippingAddressModel->where('user_id',$user_id)->first();

        if($addr_details_obj)
        {
            $addr_details_arr = $addr_details_obj->toArray();
        }

        $this->arr_view_data['addr_details_arr']= $addr_details_arr;        
        $this->arr_view_data['countries_arr']   = $countries_arr;        
        $this->arr_view_data['page_title']      = 'Update Shipping Address';

        return view($this->module_view_folder.'.shipping-address',$this->arr_view_data);
    }

    public function bank_details(Request $request)
    {
        if(Session::get('active_user_role')!='seller')
        {
            return redirect('/');
        }

        $addr_details_arr = $bank_details_arr = [];
        $user_id = 0;

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;            
        }

        if($request->isMethod('post'))
        {
            $arr_rules = [
                        'bank_name'           => 'required',
                        'branch'              => 'required',
                        'account_no'          => 'required|numeric',
                        'account_holder_name' => 'required'
                     ];

            if(Validator::make($request->all(),$arr_rules)->fails())
            {
                $response = [
                                'status'    =>'ERROR',
                                'message'   =>'Please enter all required fields'
                            ];

                return response()->json($response);     
            }

            $bank_details_arr['bank_name']           = $request->input('bank_name');
            $bank_details_arr['branch']              = $request->input('branch');
            $bank_details_arr['account_no']          = $request->input('account_no');
            $bank_details_arr['account_holder_name'] = $request->input('account_holder_name');
           
            $is_exist = $this->BankDetailsModel->where('user_id',$user_id)->count()>0;

            if($is_exist)
            {
                $status = $this->BankDetailsModel->where('user_id',$user_id)
                                                 ->update($bank_details_arr);
            }
            else
            {
                $bank_details_arr['user_id'] = $user_id;

                $status = $this->BankDetailsModel->create($bank_details_arr);
            }
            

            if($status)
            {
                return response()->json(['status' => 'SUCCESS','message' => 'Bank details updated successfully']);  
            }
            else
            {
                return response()->json(['status' => 'FAILURE','message' => 'Problem occured while updating bank details']);  
            }
        }

        $bank_details_obj = $this->BankDetailsModel->where('user_id',$user_id)->first();

        if($bank_details_obj)
        {
            $bank_details_arr = $bank_details_obj->toArray();
        }

        $this->arr_view_data['bank_details_arr']    = $bank_details_arr;
        $this->arr_view_data['page_title']          = 'Update Bank Details';

        return view($this->module_view_folder.'.seller.bank_details',$this->arr_view_data);
    }

    public function save_session(Request $request)
    {
        Session::put('redirect_to',$request->redirect_to);
        
        return response()->json(['status'=>'SUCCESS']);
    }

    public function logout()
    {
        Session::forget('buyer_age_verification_url');
        Sentinel::logout();
        Session::flush();


        /*--------delete you may likes product after logout-----------------*/

        $session_id = $this->get_session_id();

        $this->BuyerViewProductModel->where('user_session_id',$session_id)->delete();

        /*-----------------------------------------*/
        
        return redirect('/login');


    }

    public function checkcartdata_atlogin($session_id="",$ip_address="")
    {

       $bag_obj=[];
       if(isset($session_id) && isset($ip_address)){
         $session_id = $session_id;
         $ip_address = $ip_address;
         $user = Sentinel::check();
         $loggedIn_Id = 0;

          if($user)
          {
            $loggedIn_Id = $user->id;  
          }

           $bag_obj = $this->TempBagModel->where('buyer_id',0)
               ->where('user_session_id',$session_id)
               ->where('ip_address',$ip_address)
               ->first();
           if(isset($bag_obj) && !empty($bag_obj))
           {
             $bag_obj = $bag_obj->toArray();
           }    
           
          return $bag_obj;
        }//isset session id and ip address

    }//end check cart data

    public function get_items()
    {
            
      $loginuser_id = 0;

      $user = Sentinel::check();

      if($user)
      {
        $loginuser_id = $user->id;
      }

      $ip_address = $this->get_ip_address();
      $session_id = $this->get_session_id();
        
        if($user)
        {
         $bag_obj =  $this->TempBagModel
                        ->where('user_session_id',$session_id)
                        ->where('ip_address',$ip_address)
                        ->where('buyer_id',0)
                        ->orderBy('id','desc')->first();
        }
       // }else{
       //    $bag_obj =  $this->TempBagModel
       //                ->where('buyer_id',$loginuser_id)
       //                ->orderBy('id','desc')->first();
       // }//else 


       return $bag_obj;

    }//get_items function


    public function get_both_items()
    {
            
      $loginuser_id = 0;

      $user = Sentinel::check();

      if($user)
      {
        $loginuser_id = $user->id;
      }

      $ip_address = $this->get_ip_address();
      $session_id = $this->get_session_id();
        
        if($loginuser_id==0)
        {
         $bag_obj =  $this->TempBagModel
                        ->where('user_session_id',$session_id)
                        ->where('ip_address',$ip_address)
                        ->where('buyer_id',$loginuser_id)
                        ->orderBy('id','desc')->first();
        
       }else{
          $bag_obj =  $this->TempBagModel
                      ->where('buyer_id',$loginuser_id)
                      ->orderBy('id','desc')->first();
       }//else 


       return $bag_obj;

    }//get_items function

    public function update_cartdataat_login($cartdataatlogin)
    { 

       //if(isset($cartdataatlogin) && !empty($cartdataatlogin))
       //{

            $user = Sentinel::check();

            if($user)
            {
              $user_id = $user->id;
            }

            $ip_address = $this->get_ip_address();
            $session_id = $this->get_session_id();

            $get_sessioncart_data = $this->get_items();
            $get_usercartdata    = $this->get_both_items();



            if(isset($get_usercartdata) && !empty($get_usercartdata)){

                      $get_usercartdata = $get_usercartdata->toArray();

                      $user_cart_json_data = [];            
                      $user_cart_json_decoded_data = json_decode($get_usercartdata['product_data'],true);
                
                      $get_sessioncart_data = $get_sessioncart_data->toArray();



                       $session_cart_json_data = [];            
                       $session_cart_json_decoded_data = json_decode($get_sessioncart_data['product_data'],true);
                      
                                         
                      $update_arr =  $new_arr = $seq = $final=[];
                      $update_arr =  array_merge($user_cart_json_decoded_data['product_id'],$session_cart_json_decoded_data['product_id']);


                      if(isset($update_arr) && !empty($update_arr))
                      {
                          foreach($update_arr as $kk=>$val)
                           {
                           
                              $new_arr['product_id'][$val['product_id']] = $val;
                              $seq[] = $val['product_id'];
                              $new_arr['sequence'] = $seq;
                           }
                         $final['product_data'] = json_encode($new_arr,true);     
                    }
                    
                    $is_updated = $this->update($final);

                    if($is_updated)
                    {
                      $delete_session_cart_data = $this->TempBagModel->where('user_session_id',$session_id)->where('id',$get_sessioncart_data['id'])->delete();
                    }
                    return true;
                  }
                  else
                  {
                      $update_arr = array(
                        'buyer_id'=> $user_id
                      );
                      $update_cart_data = $this->TempBagModel->where('user_session_id',$session_id)->where('id',$get_sessioncart_data['id'])->update($update_arr);

                      return true;
                  }


      // }
     
    }//end function update_cartdataat_login


    //this function for update user id  after login
    public function update_user_id_after_login()
    {
        $user_id = 0;

        $user = Sentinel::check();

        $ip_address = $this->get_ip_address();
        $session_id = $this->get_session_id();

        if($user)
        { 
            $user_id = $user->id;

            $result = $this->BuyerViewProductModel->where('user_session_id',$session_id)
                                        ->where('ip_address',$ip_address)
                                        ->update(['buyer_id'=>$user_id]);

            if($result == 1)
            {
                return true;
            }                            
        }

        return false;
    }

    public function update($prduct_arr)
    {
      $user_id = 0; $bag_obj=[];

      $user = Sentinel::check();

      if($user)
      {
        $user_id = $user->id;
      }

      $ip_address = $this->get_ip_address();
      $session_id = $this->get_session_id();

      $arr_criteria = [
        'buyer_id' => $user_id
      ];

      if($user_id == 0)
      {
        $arr_criteria['user_session_id'] = $session_id;
      }

      if(isset($prduct_arr) && !empty($prduct_arr))
      {
        return $bag_obj = $this->TempBagModel->where($arr_criteria)->update($prduct_arr);
      }else{
        return $bag_obj;
      }

    }//if update


}
