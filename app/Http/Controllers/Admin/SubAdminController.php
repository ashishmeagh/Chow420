<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;

use App\Models\UserModel;
use App\Models\CountriesModel;
use App\Events\ActivityLogEvent;  
use App\Models\ActivityLogsModel;
use App\Models\RoleUserModel; 
use App\Models\GeneralSettingsModel;
use App\Models\ShippingAddressModel;
use App\Models\StatesModel;
use App\Models\ActivationsModel;
use App\Models\ModulesModel;
use App\Models\ModuleSubAdminMappingModel;

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

class SubAdminController extends Controller
{
    use MultiActionTrait;

    public function __construct(UserModel            $UserModel,
								CountriesModel       $CountriesModel,
								
								ActivityLogsModel    $ActivityLogsModel,
								RoleUserModel        $RoleUserModel,
								GeneralSettingsModel $GeneralSettingsModel,
								ShippingAddressModel $ShippingAddressModel,
								StatesModel          $StatesModel,
								ActivationsModel     $ActivationsModel,
								GeneralService       $GeneralService,
								EmailService         $EmailService,
								UserService          $UserService,
								ModulesModel         $ModulesModel,
								ModuleSubAdminMappingModel $ModuleSubAdminMappingModel

                            )
    {
       
        //$user = Sentinel::createModel();

        $this->EmailService                 = $EmailService;
        $this->UserService                  = $UserService;
        $this->UserModel                    = $UserModel;
        $this->BaseModel                    = $this->UserModel;
        $this->CountriesModel               = $CountriesModel;
        $this->ActivityLogsModel            = $ActivityLogsModel;
        $this->RoleUserModel                = $RoleUserModel;
        $this->GeneralSettingsModel         = $GeneralSettingsModel;
        $this->GeneralService               = $GeneralService;    
        $this->StatesModel                  = $StatesModel;
        $this->ActivationsModel             = $ActivationsModel;
        $this->ModulesModel                 = $ModulesModel;
        $this->ModuleSubAdminMappingModel   = $ModuleSubAdminMappingModel;


        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->id_proof_base_path           = base_path().config('app.project.img_path.id_proof');

        $this->user_id_proof                = url('/').config('app.project.img_path.id_proof');

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/sub_admins");
        $this->module_title                 = "Sub Admin";
        $this->modyle_url_slug              = "Sub Admin";
        $this->module_view_folder           = "admin.users.sub_admin";


    }


    public function index()
    {
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

        $this->arr_view_data['page_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['user_id_proof']  = $this->user_id_proof;

        $this->arr_view_data['arr_data']        = $arr_data;
        

        return view($this->module_view_folder.'.index', $this->arr_view_data);

    }

    public function get_users_details(Request $request)
    {
      
        $user_details           = $this->BaseModel->getTable();
        
        $prefixed_user_details  = DB::getTablePrefix().$this->BaseModel->getTable();


        $country_details           = $this->CountriesModel->getTable();
        $prefixed_country_details  = DB::getTablePrefix().$this->CountriesModel->getTable();


        $state_details             = $this->StatesModel->getTable();
        $prefix_state_details      =  DB::getTablePrefix().$this->StatesModel->getTable();

        $activation_details        = $this->ActivationsModel->getTable();
        $prefix_activation_details =  DB::getTablePrefix().$this->ActivationsModel->getTable();


        DB::enableQueryLog(); 
        $obj_user = DB::table($user_details)
                                ->select(DB::raw($prefixed_user_details.".id as id,".
                                  
                                    $prefixed_user_details.".country as country, ".
                                    $prefixed_user_details.".email,".
                                    $prefixed_user_details.".state,".
                                     
                                    $prefixed_user_details.".is_active,".
                                    $prefixed_user_details.".user_type, ".

                                    $prefix_state_details.".id as state_id,".
                                    $prefix_state_details.".name as state_name,".

                                    $prefixed_country_details.".id as cid,".
                                    $prefixed_country_details.".name as country_name,".


                                    "CONCAT(".$prefixed_user_details.".first_name,' ',"
                                            .$prefixed_user_details.".last_name) as user_name"
                                ))

                                ->leftjoin($prefixed_country_details,$prefixed_country_details.'.id','=',$prefixed_user_details.'.country')

                                ->leftjoin($prefix_state_details,$prefix_state_details.'.id','=',$prefixed_user_details.'.state')

                                ->leftjoin($prefix_activation_details,$prefix_activation_details.'.user_id','=',$prefixed_user_details.'.id')
       
                                ->whereNull($user_details.'.deleted_at')
                                ->where($prefixed_user_details.'.user_type','=','sub_admin')
                                ->groupBy($prefixed_user_details.'.id')
                                ->orderBy($user_details.'.id','DESC');
 

        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
        {
            $search_term      = $arr_search_column['q_name'];
           // $obj_user = $obj_user->having('first_name','LIKE', '%'.$search_term.'%');
            $obj_user = $obj_user->having('user_name','LIKE', '%'.$search_term.'%');
                                 

        }

        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_term  = $arr_search_column['q_email'];
            $obj_user     = $obj_user->where($user_details.'.email','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_country']) && $arr_search_column['q_country']!="")
        {
            $search_term = $arr_search_column['q_country'];
            $obj_user    = $obj_user->having('country_name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_state']) && $arr_search_column['q_state']!="")
        {
            $search_term = $arr_search_column['q_state'];
            $obj_user    = $obj_user->having('state_name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status']!="")
        {
            $search_term = $arr_search_column['q_status'];
            $obj_user    = $obj_user->where($prefixed_user_details.'.is_active','LIKE', '%'.$search_term.'%');
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

                            ->editColumn('location',function($data) use ($current_context)
                            {
                                $country = $state = $location ='';

                                if(isset($data->state) && $data->country)
                                {
                                    $country = isset($data->country)?get_country($data->country):'';
                                    $state   = isset($data->state)?get_state($data->state):'';
                                }


                                return $location = '<b>Country: </b> '.$country.'<br>'.
                                                   '<b>State: </b> '.$state;
                                
                            })


                            ->editColumn('module_count',function($data) use ($current_context)
                            {
                                $count = $this->ModuleSubAdminMappingModel
                                              ->where('user_id',$data->id)
                                              ->count();

                                return $count;                
                                
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
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                                // $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);

                                // $confirm_delete = 'onclick="confirm_delete(this,event);"';
                                
                                // $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';

                                $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                                $build_view_action = '<a class="eye-actn" href="'.$view_href.'" title="View">View</a>';


                               /* $view_payhistory_href =  $this->module_url_path.'/viewpayhistory/'.base64_encode($data->id);

                                $build_payhistory_action = '<a class="eye-actn" href="'.$view_payhistory_href.'" title="View Payment History">Payment History</a>';
                            

                                 $view_order_href =  $this->module_url_path.'/vieworders/'.base64_encode($data->id);
                                 $build_orderview_action = '<a class="eye-actn" href="'.$view_order_href.'" title="View Orders">View Orders</a>';    

                             $build_idproof_action='';   */
                            
                            /*
                             $confirm_approve_status='onclick="approve_id_proof($(this))"';
                             $build_idproof_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" '.$confirm_approve_status.'  
                                 data-enc_id="'.base64_encode($data->id).'" title="Approve Id Proof"><i class="ti-receipt" style="color:#31b0d5"></i></a>';  */

                             //$build_deleteproof_action='';    

                              /*$delete_idproof='onclick="delete_id_proof($(this))"';
                              $build_deleteproof_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" '.$delete_idproof.'  
                                 data-enc_id="'.base64_encode($data->id).'" title="Delete Id Proof"><i class="ti-receipt" style="color:#31b0d5"></i></a>';  */
 
                                 /*******************************************************/
                                 /* $build_age_verify_action ='';
                                  $build_age_verify_action = '<a class="btns-approved view_age_section" front_image="'.$data->front_image.'" user_id="'.$data->buyer_user_id.'" back_image="'.$data->back_image.'" selfie_image="'.$data->selfie_image.'"  address_proof="'.$data->address_proof.'"  age_address="'.$data->age_address.'"   age_category="'.$data->age_category.'"  approve_status="'.$data->approve_status.'"  note="'.$data->note.'" 

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
                                  */

                                 /******************************************************/
 

                             /*$build_profile_verify_action ='';
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
                                       $build_activationemailresend_action = '<a class="btn btn-outline btn-info  show-tooltip  resendactivationemail eye-actn"  user_id="'.$data->buyer_user_id.'"  email="'.$data->email.'" completed="'.$data->completed.'"  code="'.$data->code.'"
                                       title="Resend Verification Email" >Resend Verification Email</a>'; 
                                 }*/
 
  

                                return $build_action = $build_edit_action.' '.$build_view_action;
                            })
                            
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
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

        $countries_obj = $this->CountriesModel->get();
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
        
        $module_arr = $this->ModulesModel->where('status',1)->get()->toArray();


        //get all assign module to the sub admin
        $assigned_modules_arr = [];
        $assigned_modules_arr = $this->ModuleSubAdminMappingModel->where('user_id',$user_id)->get()->toArray();

        $assigned_modules_data = array_column($assigned_modules_arr,'module_id');

        $this->arr_view_data['module_url_path']            = $this->module_url_path;
        $this->arr_view_data['module_arr']                 = $module_arr;
        $this->arr_view_data['user_arr']                   = $user_arr;
        $this->arr_view_data['page_title']                 = 'Sub Admin Details';
        $this->arr_view_data['user_id_proof_public_path']  = $this->user_id_proof;
        $this->arr_view_data['assigned_modules_arr']       = $assigned_modules_data;

        return view($this->module_view_folder.'.show', $this->arr_view_data);
    }


    public function edit($enc_id)
    {
        
        $arr_data  = $role_arr = $google_api_key_arr = $address_arr = [];   

        $id = base64_decode($enc_id);
       
        $obj_user = $this->UserModel->where('id',$id)
                                    ->first();
                                    
                                                
        if($obj_user)
        {
            $arr_data = $obj_user->toArray();
        }  

        $role_arr = Sentinel::getRoleRepository()->where('slug','sub_admin')
                                                 ->get()
                                                 ->toArray();
    
        $google_api_key_obj = $this->GeneralSettingsModel->where('data_id','GOOGLE_API_KEY')->first();

        if($google_api_key_obj)
        {
            $google_api_key_arr = $google_api_key_obj->toArray();
        }

      
        $countries_obj = $this->CountriesModel->get();

        if ($countries_obj)
        {
            $countries_arr = $countries_obj->toArray();

            $this->arr_view_data['countries_arr'] = $countries_arr;
        }

        $states_obj = $this->StatesModel->where('country_id', $arr_data['country'])->get();

        if ($states_obj)
        {
            $states_arr = $states_obj->toArray();
            $this->arr_view_data['states_arr'] = $states_arr;
        }

        
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

        $arr_states   = $this->StatesModel->where('country_id', $country_id)
            ->get()
            ->toArray();

        $response['arr_states'] = isset($arr_states) ? $arr_states : [];
        return $response;
    }
    
    public function save(Request $request)
    { 

        $form_data = $request->all();

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
                        'country'               => 'required',
                        'state'                 => 'required',
                        'city'                  => 'required',
                        'zipcode'               => 'required',
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
         

         /*************chk country*state**active************************/

         $countries_obj = $this->CountriesModel->where('id',$request->country)->first();

        if($countries_obj) 
        {
            $countries_arr = $countries_obj->toArray();

            if( $countries_arr['is_active']=="0")
            {
                $response['status']      = 'error';
                $response['description'] = 'We do not support your location at the moment';
                return response()->json($response);
            }

         }//if country obj

        $states_obj = $this->StatesModel->where('id', $request->state)->first();
        
        if($states_obj) 
        {
            $states_arr = $states_obj->toArray();

            if( $states_arr['is_active']=="0")
            {
                $response['status']      = 'error';
                $response['description'] = 'We  do not support your location at the moment';
                return response()->json($response);
            }

        }//if state obj



        /*************chk country*state*active************************/

        $user =  Sentinel::createModel()->firstOrNew(['id' => $user_id]);
      
        $user->first_name = ucfirst($request->input('first_name'));
        $user->last_name  = ucfirst($request->input('last_name'));
        $user->email      = $request->input('email');
        $user->user_type  = 'sub_admin';//buyer and seller
        $user->country    = $request->input('country');//country name store
        $user->state      = $request->input('state');//state name store
        $hasher           = Sentinel::getHasher();
        $password         = $request->input('new_password');
        $user->street_address = $request->input('street_address');
        $user->city      = $request->input('city');
        $user->zipcode   = $request->input('zipcode');
       

        if(isset($password) && !empty($password))
        {
            $user->password  = $hasher->hash($request->input('new_password'));
        }

     
        if($is_update == false)
        {
           $user->is_active = '1';	
        }
   
        $user->is_trusted  = '1';

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

        if($user_details)
        {   
            if($is_update == false)
            {
                //attach sub_admin role to user

                $role = 'sub_admin';
               
                $role_one_obj = Sentinel::findRoleBySlug($role);
                $role_one_obj->users()->attach($user);    

                 
                
            }
              
       
            if($is_update==true)
            {
                $response['link']         = $this->module_url_path.'/edit/'.base64_encode($user->id);
                $response['status']       = "success";
                $response['description']  = "Sub admin updated successfully."; 
            }else{
                  $response['link']        = $this->module_url_path;
                 $response['status']       = "success";
                 $response['description']  = "Sub admin added successfully."; 
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
               $this->perform_delete(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' deleted successfully'); 
            } 
            elseif($multi_action=="activate")
            {
               $this->perform_activate(base64_decode($record_id)); 
               Flash::success(str_plural($this->module_title).' activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $this->perform_deactivate(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' blocked successfully');  
            }
        }

        return redirect()->back();
    }

    public function perform_activate($id)
    {
        $entity = $this->BaseModel->where('id',$id)->first();
        

        if($entity)
        {   
            //Activate the user
            $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
  
            return TRUE;
        }

        return FALSE;
    }

    public function perform_deactivate($id)
    {

        $entity = $this->BaseModel->where('id',$id)->first();
        
        if($entity)
        {   
            //deactivate the user
            $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

            return TRUE;
        }
        return FALSE;
    }

    public function perform_delete($id)
    {
        $entity = $this->BaseModel->where('id',$id)->first();

        if($entity)
        {
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
           return $delete_success;
        }

        return FALSE;
    }


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
    }//end function unlink image



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

    // create mail structure
    public function built_mail_data($email,$password)
    {
      $user = $this->get_user_details($email);
      
      if($user)
      {
        $arr_user = $user->toArray();

        $login_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 3px; padding: 13px 16px; text-decoration: none;" href="'.url("/book").'">Login Now</a><br/>' ;


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
        $user        = Sentinel::findByCredentials($credentials); // check if user exists

        if($user)
        {
          return $user;
        }
        return FALSE;
    }


    public function assign_module_to_sub_admin(Request $request)
    {
        $form_data = $request->all();

        if(isset($form_data['module_arr']) && count($form_data['module_arr'])>0)
        {

            /*first delete all assign module data first then again store*/
            $this->ModuleSubAdminMappingModel->where('user_id',$form_data['sub_admin_id'])->delete();

        	foreach ($form_data['module_arr'] as $key => $module_id) 
        	{
        		$data = [];
        		$data['user_id']      = isset($form_data['sub_admin_id'])?$form_data['sub_admin_id']:'';
        		$data['module_id']    = isset($module_id)?$module_id:'';

        		$result = $this->ModuleSubAdminMappingModel->create($data);
        	}

        	if($result)
        	{
        		$response['status']      = "success";
        		$response['description'] = "Module assigned successfully.";
        		return response()->json($response);
        	}
            else
            {
                $response['status']      = "error";
        		$response['description'] = "Something went wrong,please try again.";
        		return response()->json($response);	
            }

        }
    }


    public function get_accessed_module(Request $request)
    {
        $all_accessed_module = [];
        $user_id = $request->input('user_id');

        $all_accessed_module = $this->ModuleSubAdminMappingModel
                                    ->where('user_id',$user_id)
                                    ->with(['module_details'])
                                   ->get()->toArray();


        return response()->json($all_accessed_module);

    }



}
