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
use App\Models\TradeModel;


use App\Common\Services\EmailService;
use Flash;
use Validator;
use Sentinel;
use Activation;
use Reminder;
use DB;
use Datatables;

class UserController extends Controller
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
                                TradeRatingModel $TradeRatingModel,
                                ShippingAddressModel $ShippingAddressModel,
                                TradeModel $TradeModel
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
        $this->TradeModel                   = $TradeModel;

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->user_id_proof                = url('/').config('app.project.id_proof');

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/users");
        $this->module_title                 = "Users";
        $this->modyle_url_slug              = "users";
        $this->module_view_folder           = "admin.users";
       
    }   

    public function index()
    {
        $this->arr_view_data['arr_data'] = array();
        $obj_data = $this->BaseModel->whereHas('roles',function($query)
                                        {
                                            $query->where('slug','!=','admin');        
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

        $rating_tbl              = $this->TradeRatingModel->getTable();        
        $prefixed_rating_tbl     = DB::getTablePrefix().$this->TradeRatingModel->getTable();
        DB::enableQueryLog();
        $obj_user = DB::table($user_details)
                                ->select(DB::raw($prefixed_user_details.".id as id,".
                                                 $prefixed_user_details.".email as email, ".
                                                 $prefixed_user_details.".is_active as is_active, ".
                                                 $prefixed_user_details.".user_type, ".
                                                 $prefixed_buyer_details.".user_id as buyer_user_id, ".
                                                 // $prefixed_buyer_details.".crypto_symbol as buyer_crypto_symbol, ".
                                                 // $prefixed_buyer_details.".crypto_wallet_address as buyer_crypto_wallet_address, ".
                                                 // $prefixed_seller_details.".crypto_symbol as seller_crypto_symbol, ".
                                                 // $prefixed_seller_details.".crypto_wallet_address as seller_crypto_wallet_address, ".
                                                 $prefixed_seller_details.".user_id as seller_user_id, ".
                                                 $prefixed_user_details.".user_name as user_name, ".
                                                 $prefixed_user_details.".is_trusted"
                                                 // "(SELECT AVG(internal_rating.points) 
                                                 //    FROM ".$rating_tbl." as internal_rating
                                                 //    INNER JOIN ".$user_details." as internal_user_details
                                                 //       ON internal_rating.seller_user_id = internal_user_details.id WHERE internal_rating.type='1') as avarage_rating"))
                                             ))

                                ->leftjoin($prefixed_buyer_details,$prefixed_buyer_details.'.user_id','=',$prefixed_user_details.'.id')
                                ->leftjoin($prefixed_seller_details,$prefixed_seller_details.'.user_id','=',$prefixed_user_details.'.id')
                                // ->leftjoin($rating_tbl,$prefixed_rating_tbl.'.seller_user_id','=',$prefixed_user_details.'.id')
                                ->whereNull($user_details.'.deleted_at')
                                ->where($user_details.'.id','!=',1)
                                ->orderBy($user_details.'.created_at','DESC');
                                // ->get();

        // dd($obj_user);
           

            // dd($avg);
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
        {
            $search_term      = $arr_search_column['q_name'];
            $obj_user = $obj_user->having('user_name','LIKE', '%'.$search_term.'%');
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
                                $build_edit_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" href="'.$edit_href.'" title="Edit"><i class="ti-pencil-alt2" ></i></a>';

                                $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);

                                $confirm_delete = 'onclick="confirm_delete(this,event);"';
                                
                                $build_delete_action = '<a class="btn btn-circle btn-danger btn-outline show-tooltip" '.$confirm_delete.' href="'.$delete_href.'" title="Delete"><i class="ti-trash" ></i></a>';

                                $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                                $build_view_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" href="'.$view_href.'" title="View"><i class="ti-eye" ></i></a>';

                                return $build_action = $build_edit_action.' '.$build_delete_action.' '.$build_view_action;
                            })
                            ->editColumn('avarage_rating',function($data) use ($current_context)
                            {
                                
                                $avarage_rating = $this->TradeRatingModel->where('seller_user_id',$data->id)
                                                            ->where('type','1')
                                                            ->avg('points');

                                return '<span class="badge badge-success">'.number_format($avarage_rating,2).'</span>'.'<br><a href="'.url(config('app.project.admin_panel_slug')."/seller_rating").'/'.base64_encode($data->id).'">view all</a>';
                                

                            })
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

    public function create()
    {
        // $obj_country = $this->CountriesModel->where('is_active','=','1')->get(['id','country_code','country_name']);  
        // if($obj_country)
        // {
        //     $arr_country = $obj_country->toArray();                    
        // }

        // $role_arr = array(
        //                 "0" => array (
        //                        "role_slug" => "buyer",
        //                        "role_value" => "Buyer",
                              
        //                     ),
                            
        //                 "1" => array (
        //                        "role_slug" => "seller",                                  
        //                        "role_value" => "Seller",                                  
        //                     ),  
                    
        //                 );

        $countries_arr = $this->CountriesModel->get()->toArray();

        $crypto_symbol_arr = $google_api_key_arr = $role_arr = [];
        $role_arr = Sentinel::getRoleRepository()->where('slug','buyer')
                                            ->orWhere('slug','seller')
                                            ->get()->toArray();

        $crypto_symbol_obj = $this->GeneralSettingsModel->where('data_id','CRYPTO_SYMBOL')->first();
        if($crypto_symbol_obj)
        {
            $crypto_symbol_arr = $crypto_symbol_obj->toArray();
        }

        $google_api_key_obj = $this->GeneralSettingsModel->where('data_id','GOOGLE_API_KEY')->first();
        if($google_api_key_obj)
        {
            $google_api_key_arr = $google_api_key_obj->toArray();
        }

        $this->arr_view_data['countries_arr']      = $countries_arr;
        $this->arr_view_data['google_api_key_arr'] = $google_api_key_arr;
        $this->arr_view_data['crypto_symbol_arr']  = $crypto_symbol_arr;
        $this->arr_view_data['page_title']         = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title']       = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']    = $this->module_url_path;
        $this->arr_view_data['role_arr']           = $role_arr;
        
        return view($this->module_view_folder.'.create', $this->arr_view_data);
    }

    public function view($enc_user_id =false)
    {
        $address_arr = [];

        $user_id = base64_decode($enc_user_id);

        $user_obj = $this->UserModel->where('id',$user_id)->first();

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
        $this->arr_view_data['page_title']                 = 'User Details';
        $this->arr_view_data['user_id_proof_public_path']  = $this->user_id_proof;

        return view($this->module_view_folder.'.show', $this->arr_view_data);
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

        $countries_arr = $this->CountriesModel->get()->toArray();

        $this->arr_view_data['countries_arr']                = $countries_arr;
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

    // public function update(Request $request)
    // {
    //     $inputes = request()->validate([
    //         'user_id'=>'required',
    //         'first_name'=>'required',
    //         'last_name'=>'required',
    //         'country'=>'required',
    //         'street_address'=>'required',
    //         'phone'=>'required|numeric'
    //         ]);

    //     /* Image Upload starts here */
    //     $is_new_file_uploaded = FALSE;

    //      if ($request->hasFile('profile_image')) 
    //      {
    //         $image_validation = Validator::make(array('file'=>$request->file('profile_image')),
    //                                             array('file'=>'mimes:jpg,jpeg,png'));
            
    //         if($request->file('profile_image')->isValid() && $image_validation->passes())
    //         {

    //         }
    //         else
    //         {
    //             Flash::error('Not valid image! Please Select Proper Image Format');
    //             return redirect()->back();
    //         }

    //         $arr_image_size = [];
    //         $arr_image_size = getimagesize($request->file('profile_image'));

    //         if(isset($arr_image_size) && $arr_image_size==false)
    //         {
    //             Flash::error('Please use valid image');
    //             return redirect()->back(); 
    //         }
    //         /*-----------------------------------------------------------------
    //             $arr_image_size[0] = width of image
    //             $arr_image_size[1] = height of image
    //         -------------------------------------------------------------------*/

    //         /* Check Resolution */
    //         $maxHeight = 140;
    //         $maxWidth  = 140;

    //         if(($arr_image_size[0] < $maxWidth) && ($arr_image_size[1] < $maxHeight))
    //         {
    //             Flash::error('Image resolution should not be less than 140 x 140 pixel and related dimensions');
    //             return redirect()->back();
    //         }  

    //         $excel_file_name = $request->input('profile_image');
    //         $fileExtension   = strtolower($request->file('profile_image')->getClientOriginalExtension()); 
    //         $file_name       = sha1(uniqid().$excel_file_name.uniqid()).'.'.$fileExtension;
    //         $request->file('profile_image')->move($this->user_profile_base_img_path,$file_name); 
            
    //         /* Unlink the Existing file from the folder */
    //         $obj_image = $this->BaseModel->where('id',$request->input('user_id'))->first(['profile_image']);
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

    //         $is_new_file_uploaded = TRUE;         
    //     }
    //     $arr_user_data = [];

    //     if($is_new_file_uploaded)
    //     {
    //         $arr_user_data['profile_image'] = $file_name;
    //     }
               
    //     $arr_user_data['first_name']     = $request->input('first_name');
    //     $arr_user_data['last_name']      = $request->input('last_name');
    //     $arr_user_data['country']        = $request->input('country');
    //     $arr_user_data['state']          = $request->input('state');
    //     $arr_user_data['city']           = $request->input('city');
    //     $arr_user_data['street_address'] = $request->input('street_address');
    //     $arr_user_data['zipcode']        = $request->input('zipcode');
    //     $arr_user_data['phone']          = $request->input('phone');
            
    //     $obj_user = $this->BaseModel->where('id','=', $request->input('user_id'))->update($arr_user_data);

    //     if($obj_user)
    //     {
    //         /*-------------------------------------------------------
    //         |   Activity log Event
    //         --------------------------------------------------------*/
    //             $arr_event                 = [];
    //             $arr_event['ACTION']       = 'EDIT';
    //             $arr_event['MODULE_TITLE'] = $this->module_title;

    //             $this->save_activity($arr_event);
    //         /*----------------------------------------------------------------------*/
    //         Flash::success(str_singular($this->module_title).' Updated Successfully');
    //     }
    //     else
    //     {
    //         Flash::error('Problem Occured While Updating '.str_singular($this->module_title));
    //     }   

    //     return redirect()->back();      
    // }

    public function save(Request $request)
    {  
        $is_update = false;
        $user_id = $request->input('user_id');
        if($request->has('user_id'))
        {
           $is_update = true;
        }

        /*Check validations*/
        $arr_rules = [
                        // 'user_role'             => 'required',
                        'user_name'             => 'required',
                        'email'                 => 'required|email',
                        'address'               => 'required'
                     ];

        if($is_update == false)
        {
            $arr_rules['profile_image']    = 'required';
            $arr_rules['new_password']     = 'required';
            $arr_rules['confirm_password'] = 'required';
          
        }

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = "error";
            $response['description'] = "Form validation failed...Please check all fields..";
            return response()->json($response);
        }

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
            $response['description'] = "Email Id Already Exists";
            return response()->json($response);
        }   
         
        $user =  Sentinel::createModel()->firstOrNew(['id' => $user_id]);

        $user->user_name  = $request->input('user_name');
        $user->email      = $request->input('email');
        $user->user_type  = 'both';//buyer and seller
        $hasher           = Sentinel::getHasher();
        $password         = $request->input('new_password');

        if(isset($password) && !empty($password))
        {
            $user->password  = $hasher->hash($request->input('new_password'));
        }   
    
        $user->is_active      = '1';
        // if($request->input('user_role') == "buyer")
        // {
        //     $user->user_type      = 'buyer';
        // }
        // else if($request->input('user_role') == "seller")
        // {
        //     $user->user_type      = 'seller';  
        // }

        if($request->hasFile('profile_image'))
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
        } 

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

        $email            = $request->input('email');
        
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
                // if($request->input('user_role') == "buyer")
                // {
                //     $arr_roles = 'buyer';

                //    $role = Sentinel::findRoleBySlug($arr_roles);
                //    $role->users()->attach($user);    
                // }
                // else if($request->input('user_role') == "seller")
                // {
                //     $arr_roles = 'seller';

                //    $role = Sentinel::findRoleBySlug($arr_roles);
                //    $role->users()->attach($user);    
                // }

                //attach buyer and seller both role to user
                $role_one = 'buyer';
                $role_two = 'seller';

                $role_one_obj = Sentinel::findRoleBySlug($role_one);
                $role_one_obj->users()->attach($user);    

                $role_two_obj = Sentinel::findRoleBySlug($role_two);
                $role_two_obj->users()->attach($user);    
                
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
            
                // if($request->input('user_role') == "buyer")
                // {
                    $buyer =  $this->BuyerModel->firstOrNew(['user_id' => $user_id]);
                    $buyer->user_id               = $user->id;
                   
                    $buyer->save();
                // }
                // else if($request->input('user_role') == "seller")
                // {
                    $seller  =  $this->SellerModel->firstOrNew(['user_id' => $user_id]);
                    $seller->user_id               = $user->id;                  
                    $seller->save();
                // }
            
            $address_arr = [
                            'user_id'   => $user->id,
                            'address'   => $request->input('address'),
                            'lat'       => $request->input('lat'),
                            'lng'       => $request->input('lng'), 
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

            $response['link']        = $this->module_url_path.'/edit/'.base64_encode($user->id);
            $response['status']      = "success";
            $response['description'] = "User Saved Successfully."; 
        }
        else
        {
            // Flash::error('Problem Occured While Creating '.str_singular($this->module_title));
            $response['status']      = "error";
            $response['description'] = "Error Occurred While Save User.";
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
            Flash::success(str_singular($this->module_title).' Deleted Successfully');
        }
        else
        {
            Flash::error('Problem Occured While '.str_singular($this->module_title).' Deletion ');
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
            Flash::error('Please Select '.str_plural($this->module_title) .' To Perform Multi Actions');  
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
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

    public function perform_activate($id)
    {
        $entity = $this->BaseModel->where('id',$id)->first();
        

        if($entity)
        {   
            //Activate the user
            $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);

            //Activate the seller trade (Update is_active = 1 for seller trade)
            $this->TradeModel->where('user_id',$id)->update(['is_active'=>'1']);

            //Get seller trades
            $arr_seller_trade = $this->TradeModel->where('user_id',$id)
                                      ->get()->toArray();
            $seller_trade_ids = array_column($arr_seller_trade, 'id');

            //Activate interested_buyers trades (update interested_buyers trade is_active = 1)
            $this->TradeModel->whereIn('linked_to',$seller_trade_ids)
                             ->update(['is_active'=>'1']);
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

            //deactivate the seller trade (Update is_active = 0 for seller trade)
            $this->TradeModel->where('user_id',$id)->update(['is_active'=>'0']);

            //Get seller trades
            $arr_seller_trade = $this->TradeModel->where('user_id',$id)
                                      ->get()->toArray();
            $seller_trade_ids = array_column($arr_seller_trade, 'id');

            //deactivate interested_buyers trades (update interested_buyers trade is_active = 0)
            $this->TradeModel->whereIn('linked_to',$seller_trade_ids)
                             ->update(['is_active'=>'0']);

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
            $this->SellerModel->where('user_id',$id)->delete();
      
            /* Detaching Role from user Roles table */
            // $user = Sentinel::findById($id);
            // $role_owner     = Sentinel::findRoleBySlug('owner');
            // $role_traveller = Sentinel::findRoleBySlug('traveller');
            // $user->roles()->detach($role_owner);
            // $user->roles()->detach($role_traveller);

           $delete_success = $this->BaseModel->where('id',$id)->delete();
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
                $arr_event                 = [];
                $arr_event['ACTION']       = 'REMOVED';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);
            /*----------------------------------------------------------------------*/
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

        $login_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.url("/loginNow").'">Login Now</a><br/>';


        $arr_built_content = [
                                'USER_FNAME' => $arr_user['first_name'],
                                'APP_NAME'     => config('app.project.name'),
                                'LOGIN_URL'    => $login_url,
                                'USER_EMAIL'   => $email,
                                'USER_PASSWORD'   => $password
                             ];

        $arr_mail_data                      = [];
        $arr_mail_data['email_template_id'] = '30';
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

        $user_id = base64_decode($request->user_id);
        $verification_status  = $request->status;
        
        $is_available = $this->BaseModel->where('id',$user_id)->count()>0;
        
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
                    $response['message'] = str_singular($this->module_title).' Verified Successfully';
                }
                else
                {
                    $response['message'] = str_singular($this->module_title).' Unverified Successfully';
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
}
