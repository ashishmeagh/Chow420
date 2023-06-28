<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\SellerModel;
use App\Models\ShippingAddressModel;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\MembershipModel;
use App\Models\UserSubscriptionsModel;
use App\Models\SiteSettingModel;
use App\Models\StripeSubscriptionsModel;
use App\Models\StripeProductsModel;
use App\Models\PlansModel;
use App\Models\ForumPostsModel;
use App\Models\ProductModel;
use App\Models\EventModel;
use App\Models\EmailTemplateModel;
use App\Models\SellerDocumentsModel;



use Carbon\Carbon;

use Validator;
use Flash;
use Sentinel;
use Hash;
use DB;
  
class AccountSettingsController extends Controller
{

    public function __construct(
                                
                                UserModel $user,
                                CountriesModel $CountriesModel,
                                StatesModel $StatesModel,
                                SellerModel $SellerModel,
                                ShippingAddressModel $ShippingAddressModel,
                                ActivityLogsModel $activity_logs,
                                GeneralService $GeneralService,
                                UserSubscriptionsModel $UserSubscriptionsModel,
                                MembershipModel $MembershipModel,
                                EmailService $EmailService,
                                SiteSettingModel $SiteSettingModel,
                                StripeSubscriptionsModel $StripeSubscriptionsModel,
                                StripeProductsModel $StripeProductsModel,
                                PlansModel $PlansModel,
                                ForumPostsModel $ForumPostsModel,
                                ProductModel $ProductModel,
                                EventModel $EventModel,
                                EmailTemplateModel $EmailTemplateModel,
                                SellerDocumentsModel $SellerDocumentsModel
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;
        $this->ActivityLogsModel  = $activity_logs;
        $this->CountriesModel     = $CountriesModel;
        $this->StatesModel        = $StatesModel;
        $this->SellerModel        = $SellerModel;
        $this->ShippingAddressModel     = $ShippingAddressModel;
        $this->GeneralService     = $GeneralService;
        $this->EmailService       = $EmailService;
        $this->MembershipModel    = $MembershipModel;
        $this->UserSubscriptionsModel = $UserSubscriptionsModel;
        $this->SiteSettingModel   = $SiteSettingModel;
        $this->StripeSubscriptionsModel = $StripeSubscriptionsModel;
        $this->StripeProductsModel= $StripeProductsModel;
        $this->PlansModel         = $PlansModel;
        $this->ForumPostsModel    = $ForumPostsModel;
        $this->ProductModel       = $ProductModel;
        $this->EventModel         = $EventModel;
        $this->EmailTemplateModel = $EmailTemplateModel;
        $this->SellerDocumentsModel = $SellerDocumentsModel;
        
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        $this->profile_img_public_path = url('/').config('app.project.img_path.user_profile_image');
        $this->profile_img_base_path   = base_path().config('app.project.img_path.user_profile_image');
        
        $this->module_title       = "Account Settings";
        $this->module_view_folder = "seller/profile";
 
        $this->id_proof_public_path = url('/').config('app.project.img_path.seller_id_proof');
        $this->id_proof_base_path   = base_path().config('app.project.img_path.seller_id_proof');

        $this->document_public_path = url('/').config('app.project.img_path.seller_documents');
        $this->document_base_path   = base_path().config('app.project.img_path.seller_documents');


        
        $this->module_icon        = "fa-cogs";
    }


    public function index()
    { 
        $buyer_arr = $seller_arr = $restricted_states = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

       // $countries_arr = $this->CountriesModel->get()->toArray();

        $seller_obj    = $this->SellerModel->with(['address_details'])->where('user_id',$user_details->id)->first();

            if($seller_obj)
            {
                $seller_arr = $seller_obj->toArray();
                $user_details_arr['user_details']  = $seller_arr;
            }
        $get_countries_details = $this->CountriesModel->where('id', $user_details->country)->first();
        if ($get_countries_details) {
            $get_countries_arr    = $get_countries_details->toArray();
            // dd($get_countries_arr);
            $user_details_arr['get_countries_arr']  = $get_countries_arr;
        }

        $get_states_details = $this->StatesModel->where('id', $user_details->state)->first();
        if ($get_states_details) {
            $get_states_arr    = $get_states_details->toArray();
            // dd($get_states_arr);
            $user_details_arr['get_states_arr']  = $get_states_arr;
        }

      $obj_user_state = $this->UserModel->where('id',$user_details->id)->select('state')->first();
      if($obj_user_state)
      {
        $arr_user_state = $obj_user_state->toArray();
        $document_restrcited_states = $this->StatesModel->where('is_documents_required',1)->select('id')->get();

        if($document_restrcited_states)
        {
           $document_restrcited_states = $document_restrcited_states->toArray();
           foreach($document_restrcited_states as $res_state)
           {
              $restricted_states[]  = $res_state['id'];
           }


           if(isset($restricted_states) && !empty($restricted_states) && in_array($arr_user_state['state'], $restricted_states)==false)
           {
              $this->arr_view_data['str_document_required'] = "No additional documents required";
           }
           if(isset($restricted_states) && !empty($restricted_states) && in_array($arr_user_state['state'], $restricted_states)==true)
           {
             $list_of_documents_required = $this->StatesModel->where('id',$arr_user_state['state'])->select('required_documents')->first();
            if(isset($list_of_documents_required) && !empty($list_of_documents_required))
            { 
               $this->arr_view_data['list_document_required'] = $list_of_documents_required['required_documents'];
            }

             $this->arr_view_data['str_document_required']  = "Upload Documents";
           }

           if(empty($restricted_states)) {
            $this->arr_view_data['str_document_required'] = "No additional documents required"; }
         }
       } 
       else
       {
          $this->arr_view_data['str_document_required'] = "No additional documents required";             
       }

       $obj_documents = $this->SellerDocumentsModel->where('seller_id',$user_details->id)->get();
       if($obj_documents)
       {
          $this->arr_view_data['arr_documents']  = $obj_documents->toArray();
       }

        
        $this->arr_view_data['id_proof_path']        = $this->id_proof_public_path;
        $this->arr_view_data['id_proof_public_path'] = $this->id_proof_public_path;
        $this->arr_view_data['document_path']        = $this->document_public_path;
        $this->arr_view_data['document_public_path'] = $this->document_public_path;
        $this->arr_view_data['profile_img_path']     = $this->profile_img_public_path;
        $this->arr_view_data['user_details_arr']     = $user_details_arr;
      //  $this->arr_view_data['countries_arr']        = $countries_arr;
        $this->arr_view_data['page_title']           = 'My-Profile';
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }


    public function update(Request $request)
    {
        $arr_rules = array();
        // return response()->json($request);
        $obj_data  = Sentinel::getUser();
        $seller_id = $obj_data->id; 

        $first_name = $obj_data->first_name;
        $last_name  = $obj_data->last_name;
        $form_data = $request->all();



        $inputs = [
                'first_name'=>'required',
                'last_name'=>'required',
                'email'=>'required|email',
              //  'mobile_no'=>'required',
                'country'=>'required',
                'state'=>'required',
                'street_address'=>'required',
                'zipcode'=>'required',
                'city'=>'required',
                ];
        
         if(Validator::make($form_data,$inputs)->fails())
        {
            $response = [
                          'status' =>'error',
                          'message'    =>'Please enter all required fields'
                        ];

            return response()->json($response);     
        }        


           /*************chk country*state**************************/

          $countries_obj = $this->CountriesModel->where('id',$request->input('country'))->first();
          if ($countries_obj) {
              $countries_arr = $countries_obj->toArray();
              if( $countries_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['message'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }

          }//if country obj

           $states_obj = $this->StatesModel->where('id', $request->input('state'))->first();
           if ($states_obj) {
            $states_arr = $states_obj->toArray();
             if( $states_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['message'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }
          }//if state obj
        /*************chk country**state*************************/


         
        if($this->UserModel->where('email',$request->input('email'))
                           ->where('id','!=',$obj_data->id)
                           ->count()==1)
        {
             $arr_response['status'] = 'ERROR';
             $arr_response['message']    = 'This email id already present in our system, please try another one.';
             return response()->json($arr_response);   
        }

       // $mobileno  = $form_data['mobile_no'];
        $firstname = $form_data['first_name']; 
        $lastname  = $form_data['last_name'];
        $zipcode   = $form_data['zipcode'];
        $email     = $form_data['email'];
        $country   = $form_data['country'];
        $state     = $form_data['state'];
        $street_address = $form_data['street_address'];
        $city      = $form_data['city'];

       

          if(!isset($firstname) || (isset($firstname) && $firstname == '') || (!preg_match("/^[a-zA-Z]+$/",$firstname)))
        {
          
           $arr_response['status']     = 'ERROR';
           $arr_response['message']    = 'Provided first name should not be blank or invalid.';
          
           return response()->json($arr_response);   
        }  
         if(!isset($lastname) || (isset($lastname) && $lastname == '') || (!preg_match("/^[a-zA-Z]+$/",$lastname)))
        {
          
           $arr_response['status'] = 'ERROR';
           $arr_response['message']    = 'Provided last name should not be blank or invalid.';
          
           return response()->json($arr_response);   
        }  

        /*  if(!isset($mobileno) || (isset($mobileno) && $mobileno == '') || (!is_numeric($mobileno))  || (strlen($mobileno)<10) || (strlen($mobileno)>10))
        {
           $arr_response['status'] = 'ERROR';
           $arr_response['message']    = 'Provided mobile number should not be blank or invalid.';
           return response()->json($arr_response);   
        } */

          if(!isset($zipcode) || (isset($zipcode) && $zipcode == '') || (!is_numeric($zipcode)) )
        {
           $arr_response['status'] = 'ERROR';
           $arr_response['message']    = 'Provided zipcode should not be blank or invalid.';
          return response()->json($arr_response);   
        } 
     


        $file_name = "default.jpg";      
        $arr_data['first_name']   = ucfirst($request->input('first_name'));
        $arr_data['last_name']    = ucfirst($request->input('last_name'));
        $arr_data['email']        = $request->input('email');
      //  $arr_data['phone']        = $request->input('mobile_no');
        $arr_data['country']      = $request->input('country');
        $arr_data['state']      = $request->input('state');
        $arr_data['street_address'] = $request->input('street_address');
        $arr_data['zipcode']       = $request->input('zipcode');
        $arr_data['city']       = $request->input('city');

         
       // $arr_data['profile_image']= $file_name;

        $obj_data = $this->UserModel->where('id',$obj_data->id)->update($arr_data);

 
            
        if($obj_data)
        {

            
                $user_details = false;
               // $user_details = Sentinel::getUser();   
                
                
                  $user_details = Sentinel::getUser();
                  $loginid = $user_details->id;

                  $user_details = $this->UserModel->where('id',$loginid)->first();

                  

              
               // if($user_details['first_name']!='' && $user_details['last_name']!='' && $user_details['email']!='' && $user_details['country']!='' &&  $user_details['phone']!='' &&  $user_details['street_address']!='' && $user_details['zipcode']!=''
               //      && $user_details['city']!=''
               //      && $user_details['state']!='' && ($user_details['approve_status']=='0' || $user_details['approve_status']=='2'))
               // {     


                 if($user_details['first_name']!='' && $user_details['last_name']!='' && $user_details['email']!='' && $user_details['country']!='' &&  $user_details['street_address']!='' && $user_details['zipcode']!=''
                    && $user_details['city']!=''
                    && $user_details['state']!='' && ($user_details['approve_status']=='0' || $user_details['approve_status']=='2'))
               {      


                  

                     $update_status = $this->UserModel
                                        ->where('id',$user_details->id)
                                        ->update(['approve_status'=>'1']);   

                
                    $from_user_id = 0;
                    $admin_id     = 0;
                    $user_name    = "";

                /***************Send Profile Update Verification Notification to Admin (START)*****/
                        
                    $url  = url('/').'/'.config('app.project.admin_panel_slug').'/sellers';

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        $user_name    = $user_details->first_name.' '.$user_details->last_name;
                    }

                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }
                   
                    if($user_details->first_name=="" || $user_details->last_name==""){

                        $user_name = $request->input('first_name').' '.$request->input('last_name');
                    }


                        
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('Dispensary <a target="_blank" href="'.$url.'"><b>'.$user_name.'</b></a> has uploaded the profile for verification.');
                    $arr_event['type']         = '';
                   // $arr_event['title']        = 'Profile Update Verification';
                    $arr_event['title']        = 'Profile Updated';

                    $this->GeneralService->save_notification($arr_event);

                /***************Send Profile Update Verification Notification to Admin (END)*****/
                
                
                
                /***************Send Profile Update Verification Mail to Admin (START)*********/
                $to_user = Sentinel::findById($admin_id);

                $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

               // $msg     = html_entity_decode('Dispensary <b>'.$user_name.'</b> has uploaded the profile for verification.');

                
               // $subject = 'Profile Update Verification';
                //$subject = 'Profile Updated';

                $arr_built_content = [
                    'USER_NAME'     => config('app.project.admin_name'),
                    'APP_NAME'      => config('app.project.name'),
                   // 'MESSAGE'     => $msg,
                    'SELLER_NAME'   => $user_name,
                    'URL'           => $url
                ];

                $arr_mail_data['email_template_id'] = '52';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = '';
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section($arr_mail_data);
                

                /*********************Send Profile Update Verification Mail to Admin (END)*****************/
               
               
               
               
               
            }


            


            $response['status'] = 'SUCCESS';
           // $response['message'] = ucfirst(strtolower($this->module_title)).' updated successfully';
            $response['message'] = 'Personal details updated successfully';

            return response()->json($response);     
        }
        else
        {

            $response['status']  = 'ERROR';
            $response['message'] = 'Problem occurred, while updating '.str_singular($this->module_title);

            return response()->json($response); 
        } 
      
        return redirect()->back();
    }

    /****************************Check user verification and allow to Update profile****************/

    public function edit_profile_3_march_old()
    {
        
        $seller_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();
       
        $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();
        
      
        if($seller_obj)
        {
            $seller_arr = $seller_obj->toArray();
            $user_details_arr['user_details']            = $seller_arr;
        }
        
      
        if($user_details_arr['user_details']['approve_verification_status'] == 1 && $user_details_arr['approve_status']==1){

            return redirect(url('/').'/seller/profile');

        }else{

                $countries_obj = $this->CountriesModel->get();
                    if($countries_obj)
                {
                    $countries_arr = $countries_obj->toArray();
                    
                    $this->arr_view_data['countries_arr']         = $countries_arr;
                }
                
                $states_obj = $this->StatesModel->where('country_id', $user_details_arr['country'])->get();
                if($states_obj)
                {
                    $states_arr = $states_obj->toArray();
                   
                    $this->arr_view_data['states_arr']         = $states_arr;
                }

                $this->arr_view_data['user_details_arr']         = $user_details_arr;
                $this->arr_view_data['id_proof_path']        = $this->id_proof_public_path;

                $this->arr_view_data['profile_img_public_path']  = $this->profile_img_public_path;
                $this->arr_view_data['page_title']               = 'Business-Profile';
                
                return view($this->module_view_folder.'.edit',$this->arr_view_data);
        } 
    }


    public function get_states(Request $request)
    {
        $arr_states   = [];
        $country_id     = $request->input('country_id');

        $arr_states   = $this->StatesModel->where('country_id', $country_id)
            ->where('is_active',1)
            ->get()
            ->toArray();

        $response['arr_states'] = isset($arr_states) ? $arr_states : [];
        return $response;
    }
   
   //function added to get the country id
    public function get_countryid(Request $request)
    {
       $country_name = $request->input('countryname');
       if($country_name)
       {
          $country_id = CountriesModel::where('name',$country_name)->pluck('id')->first();
          return $country_id;
       }      
    }

    public function business_profile()
    {
        $user_details = Sentinel::getUser();  
        $user_id      = $user_details->id;      
  
        $this->arr_view_data['id_proof_public_path']     = $this->id_proof_public_path;
        $this->arr_view_data['business_details']         = $this->SellerModel->where('user_id',$user_id)->first()->toArray();
        $this->arr_view_data['page_title']               = 'Business-Profile';
        return view($this->module_view_folder.'.business-profile',$this->arr_view_data); 
    }
    public function id_verification()
    {   
        $seller_arr = [];
        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();
        $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();

        if($seller_obj)
        {
            $seller_arr = $seller_obj->toArray();
            $user_details_arr['user_details']            = $seller_arr;
        }


        $this->arr_view_data['user_details_arr']         = $user_details_arr;

        $this->arr_view_data['page_title']  = 'Id Proof Verification';
        $this->arr_view_data['id_proof_path']        = $this->id_proof_public_path;

        return view($this->module_view_folder.'.idproof',$this->arr_view_data); 

    }

    //update id proof verification


    public function update_idproof(Request $request)
    {

        $arr_rules = array();
        $current_timestamp = "";
       
        $obj_data  = Sentinel::getUser();
        $seller_id  = $obj_data->id; 

      
        $file_name = "default.jpg";

        /**********************front image*******************************/


        $front_image = "default.jpg";

        if ($request->hasFile('front_image')) 
        {
            $front_image = $request->input('front_image');
            $file_extension = strtolower($request->file('front_image')->getClientOriginalExtension()); 
             if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $front_image = sha1(uniqid().$front_image.uniqid()).'.'.$file_extension;
                $request->file('front_image')->move($this->id_proof_base_path, $front_image);
                $front_image  = $front_image;    
                $unlink_old_frontimg_path    = $this->id_proof_base_path.'/'.$request->input('old_front_image');
                if(file_exists($unlink_old_frontimg_path))
                {
                    @unlink($unlink_old_frontimg_path);  
                }
            }

             else
            {
                $response['status']  = 'ERROR';
                $response['message'] = 'Please select valid front of id proof, only jpg,png and jpeg file are allowed';

                return response()->json($response);
            } 
            
        } 
        else
        {
            $front_image = $request->input('old_front_image');            
        }


        /***********************end of front image***********************/
         /**********************back image*******************************/
        $back_image = "default.jpg";

        if ($request->hasFile('back_image')) 
        {
            $back_image = $request->file('back_image');
            $file_extension = strtolower($request->file('back_image')->getClientOriginalExtension()); 
             if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $back_image = sha1(uniqid().$back_image.uniqid()).'.'.$file_extension;
                $request->file('back_image')->move($this->id_proof_base_path, $back_image);
                $back_image  = $back_image;    

                $unlink_old_backimg_path    = $this->id_proof_base_path.'/'.$request->input('old_back_image');
                if(file_exists($unlink_old_backimg_path))
                {
                    @unlink($unlink_old_backimg_path);  
                }

            }
             else
            {
                $response['status']  = 'ERROR';
                $response['message']     = 'Please select valid back of id proof, only jpg,png and jpeg file are allowed';
                return response()->json($response);
            } 
            
        }
        else
        {
            $back_image = $request->input('old_back_image');            
        }
        /***********************end of back image***********************/

          /**********************selfie image*******************************/
        $selfie_image = "default.jpg";

        if ($request->hasFile('selfie_image')) 
        {
            $selfie_image = $request->file('selfie_image');
            $file_extension = strtolower($request->file('selfie_image')->getClientOriginalExtension()); 
             if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $selfie_image = sha1(uniqid().$selfie_image.uniqid()).'.'.$file_extension;
                $request->file('selfie_image')->move($this->id_proof_base_path, $selfie_image);
                $selfie_image  = $selfie_image;    

                $unlink_old_selfieimg_path    = $this->id_proof_base_path.'/'.$request->input('old_selfie_image');
                if(file_exists($unlink_old_selfieimg_path))
                {
                    @unlink($unlink_old_selfieimg_path);  
                }

            }
             else
            {
                $response['status']  = 'ERROR';
                $response['message']     = 'Please select valid selfie id proof, only jpg,png and jpeg file are allowed';
                return response()->json($response);
            } 
            
        }
        else
        {
            $selfie_image = $request->input('old_selfie_image');            
        }
        /***********************end of selfie image***********************/


      /**********************address proof*******************************/
        $address_proof = "default.jpg";

        if ($request->hasFile('address_proof'))  
        {
            $address_proof = $request->file('address_proof');
            $file_extension = strtolower($request->file('address_proof')->getClientOriginalExtension()); 

             if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG','doc','docx','pdf','PDF','DOC','DOCX']))
            {            
                 $address_proof = sha1(uniqid().$address_proof.uniqid()).'.'.$file_extension;
                 if($file_extension=="pdf" || $file_extension=="doc" || $file_extension=="docx")
                {
                 // $request->file('product_certificate')->move($this->product_image_base_img_path.$file_certificate_name);
                   $request->file('address_proof')->move($this->id_proof_base_path,$address_proof);

                }
                else
                {

                     
                      $request->file('address_proof')->move($this->id_proof_base_path, $address_proof);
                      $address_proof  = $address_proof;    

                      $unlink_old_addressproofimg_path    = $this->id_proof_base_path.'/'.$request->input('old_addressproof_image');
                      if(file_exists($unlink_old_addressproofimg_path))
                      {
                          @unlink($unlink_old_addressproofimg_path);  
                      }
                }

            }
             else
            {
                $response['status']  = 'ERROR';
                $response['message']     = 'Please select valid address proof, only jpg,png,jpeg,pdf,doc,docx files are allowed';
                return response()->json($response);
            } 
            
        }
        else
        {
            $address_proof = $request->input('old_addressproof_image');            
        }
        /***********************end of address proof***********************/





        $age_address = $request->input('age_address');
 
        if($front_image=="")
        {
             $response['status']  = 'ERROR';
             $response['message'] = 'Please select front of ID';
             return response()->json($response);
        }
         if($back_image=="")
        {
             $response['status']  = 'ERROR';
             $response['message'] = 'Please select back of ID';
             return response()->json($response);
        }
        if($selfie_image=="")
        {
             $response['status']  = 'ERROR';
             $response['message'] = 'Please select selfie';
             return response()->json($response);
        }

         if($age_address=="") 
        {
             $response['status']  = 'ERROR';
             $response['message'] = 'Please enter address';
             return response()->json($response);
        }

         if($address_proof=="")
        {
             $response['status']  = 'ERROR';
             $response['message'] = 'Please select address proof';
             return response()->json($response);
        }



         $udpate_arr = array('front_image'=>$front_image,
                            'back_image'=>$back_image,
                            'selfie_image'=>$selfie_image,
                            'address_proof'=>$address_proof,
                            'age_address'=>$age_address,
                            'approve_verification_status'=>'3'
                          );
         $update_age_proof       = $this->SellerModel->where('user_id',$seller_id)->update($udpate_arr);  

         if($update_age_proof)
         {
           $current_timestamp    = date('Y-m-d H:i:s');
 
            if(isset($current_timestamp) && !empty($current_timestamp))
            {  
              $update_sorting_order = $this->SellerModel->where('user_id',$obj_data->id)->update(array('sorting_order_by'=>$current_timestamp)); 
            }    
            /****************send noti to admin for ID Proof Verification verification****************************/
 
                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    $f_name = isset($user_details->first_name)?$user_details->first_name:'';
                    $l_name = isset($user_details->last_name)?$user_details->last_name:'';
                    $seller_email = isset($seller->email)?$seller->email:'';

                    if(isset($f_name) && !empty($f_name) && isset($l_name) && !empty($l_name))
                    {  
                      $user_name  = $f_name.' '.$l_name;
                    }
                    else
                    {
                      $user_name  = $seller_email;
                    }
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                 
                $url  = url(config('app.project.admin_panel_slug')."/sellers");
                    
               /*****************send noti to admin**************************/
                $arr_event                 = [];
                $arr_event['from_user_id'] = $from_user_id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['description']  = html_entity_decode('Dispensary <a target="_blank" href="'.$url.'"><b>'.$user_name.'</b></a> has uploaded the ID proof for verification.');
                $arr_event['type']         = '';
                $arr_event['title']        = 'ID Proof Verification Request';
                $this->GeneralService->save_notification($arr_event);
               /*******************************************/

            /******************end of send noti ID Proof Verification to admin**************************/



                /***************Send ID Proof Verification Mail to Admin (START)**************************/
                $to_user = Sentinel::findById($admin_id);

                $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                //$msg     = html_entity_decode('Dispensary <b>'.$user_name.'</b> has uploaded the ID proof for verification.');

                
                //$subject = 'ID Proof Verification Request';

                $arr_built_content = [
                    'USER_NAME'     => config('app.project.admin_name'),
                    'APP_NAME'      => config('app.project.name'),
                    //'MESSAGE'       => $msg,
                    'SELLER_NAME'   => $user_name,
                    'URL'           => $url
                ];

                $arr_mail_data['email_template_id'] = '55';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = '';
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section($arr_mail_data);


            /*********************Send ID Proof Verification Mail to Admin (END)*****************/
               
         } 

        if($update_age_proof)
        {

            $response['status'] = 'SUCCESS';
            $response['message'] = 'Id proof details updated successfully';

            return response()->json($response);     
        }
        else
        {

            $response['status']  = 'ERROR';
            $response['message'] = 'Problem occurred, while updating '.str_singular($this->module_title);

            return response()->json($response); 
        } 
      
        return redirect()->back();
    } 

     public function upload_documents2(Request $request)
    {
        dd($request->all());

        $arr_rules = array();
        $document_title = $update_documents = "";
        $is_update_process = false;
       
        $obj_data  = Sentinel::getUser();
        $seller_id  = $obj_data->id; 

        if($request->has('seller_id'))
        {
            $is_update_process = true; 
        }

        $form_data = $request->all();


       if($is_update_process == false) // add
      { 
        
          $i   =  0;
          foreach($request->file('document') as $doc) 
         {   
                /* if($request->hasFile('document'))
                 {
                   dd('yes');
                 } */
                if($request->hasFile('document'))
               {  
                  $front_image = $doc;
                  //dd($front_image);
                  $file_extension = strtolower($doc->getClientOriginalExtension()); 
                  if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG','doc','docx','pdf','PDF','DOC','DOCX']))
                  {                           
                      $front_image = sha1(uniqid().$front_image.uniqid()).'.'.$file_extension;
                      $doc->move($this->document_base_path, $front_image);
                      $front_image  = $front_image;    
                      /*$unlink_old_frontimg_path    = $this->document_base_path.'/'.$request->input('old_document');
                      if(file_exists($unlink_old_frontimg_path))
                      {
                          @unlink($unlink_old_frontimg_path);  
                      }*/
                  }

                   else
                  {
                      $response['status']  = 'ERROR';
                      $response['message'] = 'Please select valid document,only jpg,png,jpeg,pdf,doc,docx files are allowed';

                      return response()->json($response);
                  } 
                } 

                else
                {
                  $front_image = $form_data['old_document'][$i];
                } 

               if(isset($form_data['document_title']) && !empty($form_data['document_title']))
              {    //dd('both new');

                   //dd($request->all());  
                   $i=0;
                   $document_title_arr = $form_data['document_title'];
                   if(!empty($document_title_arr))
                   { 

                       $update_arr         = array('document_title'=>$document_title_arr[$i],
                                'document' =>$front_image,
                                'seller_id'=>$seller_id 
                              );
                       $update_documents = $this->SellerDocumentsModel->create($update_arr);  
                   }    
                  $i++;
             }
             elseif(empty($form_data['document_title']))
             {
                  $document_title_arr = $form_data['old_document_title'];
                   if(!empty($document_title_arr))
                   { 
                       $update_arr         = array('document_title'=>$document_title_arr[$i],
                                'document' =>$front_image,
                                'seller_id'=>$seller_id 
                              );
                       $update_documents = $this->SellerDocumentsModel->where('seller_id',$seller_id)->update($update_arr);  
                   }    
                  $i++;
             } 
      } 

  


    }//Add
    
    else //Update Process
    {
       $is_documents_exists = $this->SellerDocumentsModel->where('seller_id',$seller_id)->count(); 

       if($is_documents_exists >0)
       { 
        $delete_previous_records     = $this->SellerDocumentsModel->where('seller_id',$seller_id)->delete(); 
       } 

        if(isset($form_data['document']) && !empty($form_data['document']))
       {
        
          $i   =  0;
          foreach($request->file('document') as $doc) 
         {   
                 if($request->hasFile('document')) 
                {  
                  $front_image = $doc;
                  //dd($front_image);
                  $file_extension = strtolower($doc->getClientOriginalExtension()); 
                  if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG','doc','docx','pdf','PDF','DOC','DOCX']))
                  {                           
                      $front_image = sha1(uniqid().$front_image.uniqid()).'.'.$file_extension;
                      $doc->move($this->document_base_path, $front_image);
                      $front_image  = $front_image;    
                      /*$unlink_old_frontimg_path    = $this->document_base_path.'/'.$request->input('old_document');
                      if(file_exists($unlink_old_frontimg_path))
                      {
                          @unlink($unlink_old_frontimg_path);  
                      }*/
                  }

                   else
                  {
                      $response['status']  = 'ERROR';
                      $response['message'] = 'Please select valid document,only jpg,png,jpeg,pdf,doc,docx files are allowed';

                      return response()->json($response);
                  } 
                }
                
               else
                {
                  $front_image = $form_data['old_document'][$i];
                } 

                if(isset($form_data['document_title']) && !empty($form_data['document_title']))
                {    
                   //dd($request->all());  
                   $i=0;
                   $document_title_arr = $form_data['document_title'];
                   if(!empty($document_title_arr))
                   { 

                       $update_arr         = array('document_title'=>$document_title_arr[$i],
                                'document' =>$front_image,
                                'seller_id'=>$seller_id 
                              );
                       $update_documents = $this->SellerDocumentsModel->create($update_arr);  
                   }    
                  $i++;
                }

              }
        } 

        else //No file selected
        {

            if(isset($form_data['document_title']) && !empty($form_data['document_title']))
                {    //dd('both new');

                   //dd($request->all());  
                   $i=0;

                   $document_title_arr = $form_data['document_title'];
                   $old_document_arr   = $form_data['old_document'];
                   if(!empty($document_title_arr) && !empty($old_document_arr))
                   { 

                       $update_arr         = array('document_title'=>$document_title_arr[$i],
                                'document' =>$old_document_arr[$i],
                                'seller_id'=>$seller_id 
                              );
                       $update_documents = $this->SellerDocumentsModel->create($update_arr);  
                   }    
                  $i++;
                }
        }         
    }  


       /* if($front_image=="")
        {
             $response['status']  = 'ERROR';
             $response['message'] = 'Please select document';
             return response()->json($response);
        }

         if($document_title=="") 
        {
             $response['status']  = 'ERROR';
             $response['message'] = 'Please enter document title';
             return response()->json($response);
        }*/

        if($update_documents)
        {

            $response['status'] = 'SUCCESS';
            $response['message'] = 'Documents uploaded successfully';

            return response()->json($response);     
        }
        else
        {

            $response['status']  = 'ERROR';
            $response['message'] = 'Problem occurred, while uploading documents';

            return response()->json($response); 
        } 
      
        return redirect()->back();
    } 

    //end of id documents function

    public function upload_documents(Request $request)
    {
      $form_data         = $request->all();
      $obj_data          = Sentinel::getUser();
      $seller_id         = $obj_data->id; 
      $update_documents  = $update_doc_verification_status = "";
      $arr_seller        = array();
      $current_timestamp = "";


      //dd($request->all());

        if($request->has('seller_id'))
        {
            $is_update_process = true; 
        }

        if(isset($form_data['document']) && !empty($form_data['document']))
       {
        
          $i   =  0;
          foreach($request->file('document') as $doc) 
         {   
                 if($request->hasFile('document')) 
                {  
                  $front_image = $doc;
                  //dd($front_image);
                  $file_extension = strtolower($doc->getClientOriginalExtension()); 
                  if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG','doc','docx','pdf','PDF','DOC','DOCX','xlsx','xls']))
                  {                           
                      $front_image = sha1(uniqid().$front_image.uniqid()).'.'.$file_extension;
                      $doc->move($this->document_base_path, $front_image);
                      $front_image  = $front_image;    
                      /*$unlink_old_frontimg_path    = $this->document_base_path.'/'.$request->input('old_document');
                      if(file_exists($unlink_old_frontimg_path))
                      {
                          @unlink($unlink_old_frontimg_path);  
                      }*/
                  }

                   else
                  {
                      $response['status']  = 'ERROR';
                      $response['message'] = 'Please select valid document,only jpg,png,jpeg,pdf,doc,docx files are allowed';

                      return response()->json($response);
                  } 
                }
                
               else
                {
                  $front_image = $form_data['old_document'][$i];
                  $response['status']  = 'ERROR';
                  $response['message'] = 'Please upload document';

                  return response()->json($response);     
                } 

                if(isset($form_data['document_title']) && !empty($form_data['document_title']))
                {    
                  
                 
                   $document_title_arr = $form_data['document_title'];
                   if(!empty($document_title_arr) && isset($document_title_arr))
                   { 
                        if($document_title_arr[$i]=="" || $document_title_arr[$i]==null)
                        {
                          $response['status'] = 'ERROR';
                          $response['message'] = 'Please enter document title';
                          return response()->json($response);  
                        }


                       else
                       { 
                         $update_arr         = array('document_title'=>$document_title_arr[$i],
                                  'document' =>$front_image,
                                  'seller_id'=>$seller_id 
                                );
                         $update_documents = $this->SellerDocumentsModel->create($update_arr);  
                       }
                   }    
                  $i++;
                }

                else
                {
                    $response['status'] = 'ERROR';
                    $response['message']= 'Please enter document title';

                    return response()->json($response);  
                }

              }

          $current_timestamp    = date('Y-m-d H:i:s');
          $update_doc_verification_status = $this->SellerModel->where('user_id',$seller_id)->update(array('documents_verification_status'=>'3','sorting_order_by'=>$current_timestamp));  
       }

       if(empty($form_data['document']) && empty($form_data['document_title']))
       {

            $current_timestamp              = date('Y-m-d H:i:s');
            $update_doc_verification_status = $this->SellerModel->where('user_id',$seller_id)->update(array('documents_verification_status'=>'3','sorting_order_by'=>$current_timestamp));  

          /***************Send Documents Update Verification Notification to Admin (START)*****/
                        
              $url  = url('/').'/'.config('app.project.admin_panel_slug').'/sellers';

              if(Sentinel::check())
              {
                  $user_details = Sentinel::getUser();
                  $from_user_id = $user_details->id;
                  $user_name    = $user_details->first_name.' '.$user_details->last_name;
              }

              $admin_role = Sentinel::findRoleBySlug('admin');        
              $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
              if($admin_obj)
              {
                  $admin_id = $admin_obj->user_id;            
              }
             
              if($user_details->first_name=="" || $user_details->last_name==""){

                  $user_name = $request->input('first_name').' '.$request->input('last_name');
              }


                  
              $arr_event                 = [];
              $arr_event['from_user_id'] = $from_user_id;
              $arr_event['to_user_id']   = $admin_id;
              $arr_event['description']  = html_entity_decode('Dispensary <a target="_blank" href="'.$url.'"><b>'.$user_name.'</b></a> has uploaded profile documents for verification.');
              $arr_event['type']         = '';
             // $arr_event['title']        = 'Profile Update Verification';
              $arr_event['title']        = 'Profile Documents Uploaded';

              $this->GeneralService->save_notification($arr_event);

              /***************Send Documents Update Verification Notification to Admin (END)*****/ 

              /*******************Send Documents Update Mail Notification to Admin(START)*************/
               
                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'       => $msg,
                                      'SELLER_NAME'   => $user_name,
                                      'URL'           => $url
                                     ];

                $arr_mail_data['email_template_id'] = '132';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = '';
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section($arr_mail_data);

                $update_doc_verification_status = $this->SellerModel->where('user_id',$seller_id)->update(array('documents_verification_status'=>'3'));  
                $response['status'] = 'SUCCESS';
                $response['message'] = 'Documents uploaded successfully';
                return response()->json($response);   

              /*******************Send Mail Notification to Admin(END)***************/ 
       } 

      /* else
       {
           $response['status'] = 'ERROR';
           $response['message'] = 'Please upload document';

            return response()->json($response);     
       }*/


        else if($update_documents)
        {
            /***************Send Documents Update Verification Notification to Admin (START)*****/
                        
                    $url  = url('/').'/'.config('app.project.admin_panel_slug').'/sellers';

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        $user_name    = $user_details->first_name.' '.$user_details->last_name;
                    }

                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }
                   
                    if($user_details->first_name=="" || $user_details->last_name==""){

                        $user_name = $request->input('first_name').' '.$request->input('last_name');
                    }


                        
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('Dispensary <a target="_blank" href="'.$url.'"><b>'.$user_name.'</b></a> has uploaded profile documents for verification.');
                    $arr_event['type']         = '';
                   // $arr_event['title']        = 'Profile Update Verification';
                    $arr_event['title']        = 'Profile Documents Uploaded';

                    $this->GeneralService->save_notification($arr_event);

                /***************Send Documents Update Verification Notification to Admin (END)*****/ 


            /*******************Send Documents Update Mail Notification to Admin(START)*************/
               
                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'       => $msg,
                                      'SELLER_NAME'   => $user_name,
                                      'URL'           => $url
                                     ];

                $arr_mail_data['email_template_id'] = '132';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = '';
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section($arr_mail_data);

              /*******************Send Mail Notification to Admin(END)***************/

            $response['status'] = 'SUCCESS';
            $response['message'] = 'Documents uploaded successfully';

            return response()->json($response);     
        }
        else
        {

            $response['status']  = 'ERROR';
            $response['message'] = 'Problem occurred, while uploading documents';

            return response()->json($response); 
        } 
      
        return redirect()->back();  

    }//end function

    public function remove_uploaded_documents(Request $request)
    {
       $form_data = $request->all();
       if(isset($form_data['rec_id']) && !empty($form_data['rec_id']))
       {
          $delete_record = $this->SellerDocumentsModel->where('id',$form_data['rec_id'])->delete(); 
          if($delete_record)
          {
             $response['status']  = 'SUCCESS';
             return response()->json($response);
          }
          else
          {
             $response['status']  = 'ERROR';
             return response()->json($response);
          }
       } 
    }


    public function update_business_profile(Request $request)
    {
        $arr_rules = array();
       
        $obj_data  = Sentinel::getUser();
        $login_id  = $obj_data->id;


         if($request->business_name=="")
        {
            $response['status']  = 'ERROR';
            $response['message'] = 'Please enter business name.';
            return response()->json($response); 
        }
       /* if($request->tax_id=="")
        {
            $response['status']  = 'ERROR';
            $response['message'] = 'Please enter tax id.';
            return response()->json($response); 
        }
         if(strlen($request->tax_id)>9 || strlen($request->tax_id)<9)
        {
            $response['status']  = 'ERROR';
            $response['message'] = 'Provided tax id should be 9 characters .';
            return response()->json($response); 
        }


        if(isset($request->tax_id))
        {
            $user   = Sentinel::check();
            $tax_id = $request->input('tax_id');
            $is_already_exists  = $this->SellerModel->where('tax_id',$tax_id)->where('user_id','!=',$user->id)->get()->toArray();
            if(!empty($is_already_exists))
            {
                 $response['status'] = 'ERROR';
                 $response['message'] = 'Tax id already exists.';
                 return response()->json($response); 
            }
        } */  

        /*******check business name exists********/

        // if(!isset($request->business_name) || (isset($request->business_name) && $request->business_name == '') || (!preg_match("/^[a-zA-Z0-9 ]*$/",$request->business_name)))
         if(!isset($request->business_name) || (isset($request->business_name) && $request->business_name == '') || (!preg_match("/^([A-Za-z0-9]+ )+[A-Za-z0-9]+$|^[A-Za-z0-9]+$/",$request->business_name)))  
        {
          
           $response['status'] = 'ERROR';
           $response['message']= 'Please remove special characters from business name.';
          
           return response()->json($response);   
        }  

          if(isset($request->business_name))
        {
           $user   = Sentinel::check();
           $businessname = $request->input('business_name');
           $businessname_already_exists  = $this->SellerModel->where('business_name',$businessname)->where('user_id','!=',$user->id)->get()->toArray();
           if(!empty($businessname_already_exists))
           {
                 $response['status'] = 'ERROR';
                 $response['message'] = 'This business name already exists.';
                 return response()->json($response); 
           }
        }

        /***************************************/


        $arr_data['business_name']= $request->input('business_name');
      //  $arr_data['tax_id']       = $request->input('tax_id');
      //  $arr_data['id_proof']     = $file_name;
        $arr_data['approve_status']='1';

        /*************************Add event first time business name added***************/

         $getbusinessdb =  $this->SellerModel->select('business_name')->where('user_id',$login_id)->first();
        if(isset($getbusinessdb) && !empty($getbusinessdb))
        {

            $getbusinessdb = $getbusinessdb->toArray();
            $business_namedb = $getbusinessdb['business_name'];
            if($business_namedb==""){

                 $businessname = str_replace(' ','-',$request->input('business_name')); 

                   $arr_eventdata             = [];
                   $arr_eventdata['user_id']  = $login_id;
                   $arr_eventdata['message']  = '<div class="discription-marq">
                        <div class="mainmarqees-image">
                         <img src="'.url('/').'/assets/front/images/chow.png" alt="">
                         </div>
                      <b>'.$request->input('business_name').'</b> just joined chow.<div class="clearfix"></div></div><a target="_blank" class="viewcls" href="search?sellers='.$businessname.'">View</a>';

                    $arr_eventdata['title']    = 'Business Name';   

                   // $this->EventModel->create($arr_eventdata);
            }else{
                
            }
        }//if getbusinessdb
        /**********************Add event first time business name added****************/



        $obj_data = $this->SellerModel->where('user_id',$obj_data->id)->update($arr_data);
      

        if($obj_data)
        {       
                $seller   = Sentinel::check();

                $seller_fname = isset($seller->first_name)?$seller->first_name:'';
                $seller_lname = isset($seller->last_name)?$seller->last_name:'';
                $seller_email = isset($seller->email)?$seller->email:'';
                $user_name    = "";

                if(isset($seller_fname) && !empty($seller_fname) && isset($seller_lname) && !empty($seller_lname))
                {  
                  $user_name  = $seller_fname.' '.$seller_lname;
                }
                else
                {
                  $user_name = $seller_email;
                }

                $seller_url = url('/').'/'.config('app.project.admin_panel_slug').'/sellers';

            /***************Send Notification to Admin (START)********************/
                $admin_role = Sentinel::findRoleBySlug('admin');  

                $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                $admin_id   = 0;
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }
                
                $arr_event                 = [];
                $arr_event['from_user_id'] = $seller->id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['type']         = 'admin';
                $arr_event['description']  = 'Dispensary <a target="_blank" href="'.$seller_url.'"><b>'.$user_name.'</b></a> has updated business profile details.';
               // $arr_event['title']        = 'Verification Request For Business Profile';
                $arr_event['title']        = 'Business Profile Updated';
                
                $this->GeneralService->save_notification($arr_event);

            /***************Send Notification to Admin (END)**********************/

            /*******************Send Mail Notification to Admin(START)*************/

                //$msg     = 'Dispensary <b>'.$user_name.'</b> has updated business profile details.';

               // $subject = 'Verification Request For Business Profile';
                //$subject = 'Business Profile Updated';

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'       => $msg,
                                      'SELLER_NAME'   => $user_name,
                                      'URL'           => $seller_url
                                     ];

                $arr_mail_data['email_template_id'] = '54';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = '';
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section($arr_mail_data);
            /*******************Send Mail Notification to Admin(END)***************/

                /***********Add Event data*for update businessname****/
                    $businessname = str_replace(' ','-',$request->input('business_name'));  

                  /*  $arr_eventdata             = [];
                    $arr_eventdata['user_id']  = $seller->id;
                     $arr_eventdata['message']  = '<div class="discription-marq">
                        <div class="mainmarqees-image">
                         <img src="'.url('/').'/assets/front/images/chow.png" alt="">
                         </div>
                      <b>'.$request->input('business_name').'</b> just joined chow.<div class="clearfix"></div></div><a target="_blank" class="viewcls" href="search?sellers='.$businessname.'">View</a>';
                    $arr_eventdata['title']    = 'Business Name';                        
                    $this->EventModel->create($arr_eventdata);*/

                /*********end of add event****************************/

            $response['status'] = 'SUCCESS';
            $response['message'] = str_singular('Business details updated successfully.');
            return response()->json($response);     
        }
        else
        {

            $response['message'] = 'Problem occurred, while updating '.str_singular($this->module_title);
            return response()->json($response); 
        } 
      
        return redirect()->back();
    }
 

    public function does_tax_id_exist(Request $request)
    {
        $user   = Sentinel::check();

        $tax_id = $request->input('tax_id');

        $is_already_exists  = $this->SellerModel->where('tax_id',$tax_id)->where('user_id','!=',$user->id)->get()->toArray();
          
              

        if(isset($is_already_exists) && count($is_already_exists) > 0) 
        {
            return response()->json(['exists'=>'true'],404);
        }
        else
        {
            return response()->json(['exists'=>'false']);    
        }

    }// end of tax id exists function

     public function bank_detail()
    {   
        $seller_arr = [];
        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();
        $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();

        if($seller_obj)
        {
            $seller_arr = $seller_obj->toArray();
            $user_details_arr['user_details']            = $seller_arr;
        }


        $this->arr_view_data['user_details_arr']         = $user_details_arr;

        $this->arr_view_data['page_title']  = 'Bank Details';


        $this->arr_view_data['id_proof_path']        = $this->id_proof_public_path;

        return view($this->module_view_folder.'.bankdetail',$this->arr_view_data); 

    }// function to view bank detail form



    public function update_bankdetail(Request $request)
    {
        $arr_rules = array();
       
        $obj_data  = Sentinel::getUser();

        $form_data = $request->all();

        /* $inputs = [
                'registered_name'=>'required',
                'account_no'=>'required',
                'paypal_email'=>'required|email',
                'routing_no'=>'required',
                'switft_no'=>'required',
                ];
        
         if(Validator::make($form_data,$inputs)->fails())
        {
            $response = [
                          'status' =>'error',
                          'message'    =>'Please enter all required fields'
                        ];

            return response()->json($response);     
        }    */    

        /* if($request->registered_name=="")
        {
            $response['status'] = 'ERROR';
            $response['message'] = 'Please enter registered name.';
            return response()->json($response); 
        }*/

        if(!isset($request->registered_name) || (isset($request->registered_name) && $request->registered_name == ''))
        {
          
           $response['status'] = 'error';
           $response['message']    = 'Provided registered name should not be blank or invalid.';          
           return response()->json($response);   
        }  




        if($request->account_no=="")
        {
            $response['status']  = 'ERROR';
            $response['message'] = 'Please enter account number.';
            return response()->json($response); 
        }
        if($request->routing_no=="")
        {
            $response['status']  = 'ERROR';
            $response['message'] = 'Please enter routing number.';
            return response()->json($response); 
        }
         if($request->switft_no=="")
        {
            $response['status']  = 'ERROR';
            $response['message'] = 'Please enter switft number.';
            return response()->json($response); 
        }
        
      /*     if($request->paypal_email=="")
        {
            $response['status'] = 'ERROR';
            $response['message'] = 'Please enter paypal email.';
            return response()->json($response); 
        }*/

        if (isset($request->paypal_email) && !filter_var($request->paypal_email, FILTER_VALIDATE_EMAIL)) 
        {
            $response['status'] = 'ERROR';
            $response['message'] = 'Please enter valid paypal email.';
            return response()->json($response); 
        }

        /*if(isset($request->paypal_email))
        {
           $user   = Sentinel::check();
           $paypal_email = $request->input('paypal_email');
           $is_already_exists  = $this->SellerModel->where('paypal_email',$paypal_email)->where('user_id','!=',$user->id)->get()->toArray();
           if(!empty($is_already_exists))
           {
                 $response['status'] = 'ERROR';
                 $response['message'] = 'paypal email already exists.';
                 return response()->json($response); 
           }
        }*/

        $arr_data['registered_name'] = $request->input('registered_name');
        $arr_data['account_no']      = $request->input('account_no');
        $arr_data['routing_no']      = $request->input('routing_no');
        $arr_data['switft_no']       = $request->input('switft_no');
        $arr_data['paypal_email']    = $request->input('paypal_email');

        $obj_data = $this->SellerModel->where('user_id',$obj_data->id)->update($arr_data);


        if($obj_data)
        {
                $seller   = Sentinel::check();

                $seller_fname = isset($seller->first_name)?$seller->first_name:'';
                $seller_lname = isset($seller->last_name)?$seller->last_name:'';
                $seller_email = isset($seller->email)?$seller->email:'';
                $user_name    = "";
         
                if(isset($seller_fname) && !empty($seller_fname) && isset($seller_lname) && !empty($seller_lname))
                {  
                  $user_name  = $seller_fname.' '.$seller_lname;
                }  

                else
                {
                  $user_name  = $seller_email;
                }

                $seller_url = url('/').'/'.config('app.project.admin_panel_slug').'/sellers/view/'.base64_encode($seller->id);

            /***************Send Notification to Admin (START)********************/
                $admin_role = Sentinel::findRoleBySlug('admin');  

                $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                $admin_id   = 0;
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }
                
                $arr_event                 = [];
                $arr_event['from_user_id'] = $seller->id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['type']         = 'admin';
                $arr_event['description']  = 'Dispensary <a target="_blank" href="'.$seller_url.'"><b>'.$user_name.'</b></a> has updated bank details.';
                $arr_event['title']        = 'Bank Details Updation';
                
                $this->GeneralService->save_notification($arr_event);

            /***************Send Notification to Admin (END)**********************/

            /*******************Send Mail Notification to Admin(START)*************/

                //$msg     = 'Dispensary <b>'.$user_name.'</b> has updated bank details.';
                $msg       = "";

               // $subject = 'Bank Details Updation';

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'     => $msg,
                                      'URL'           => $seller_url,
                                      'SELLER_NAME'   => $user_name 
                                     ];

                $arr_mail_data['email_template_id'] = '56';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = '';
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section($arr_mail_data);
            /*******************Send Mail Notification to Admin(END)***************/


            $response['status'] = 'SUCCESS';
            $response['message'] = str_singular('Bank details updated successfully.');
            return response()->json($response);     
        }
        else
        {

            $response['message'] = 'Problem occurred, while updating bank details';
            return response()->json($response); 
        } 
      
        return redirect()->back();
    }// end of update function of bank details


    // new function added for seller profile sections at 3-march-20



    public function edit_profile()
    {
        
        $seller_arr = $restricted_states = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();
       
        $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();
        
      
        if($seller_obj)
        {
            $seller_arr = $seller_obj->toArray();
            $user_details_arr['user_details']    = $seller_arr;
        }
        
      
        /*if($user_details_arr['user_details']['approve_verification_status'] == 1 && $user_details_arr['approve_status']==1){

            return redirect(url('/').'/seller/profile');

        }
        else
        {*/

                $countries_obj = $this->CountriesModel->where('is_active',1)->get();
                    if($countries_obj)
                {
                    $countries_arr = $countries_obj->toArray();
                    
                    $this->arr_view_data['countries_arr']         = $countries_arr;
                }
                
                //commented country id condiiton here to set the state of search address
                $states_obj = $this->StatesModel
                              //->where('country_id', $user_details_arr['country'])
                              ->where('is_active',1)
                              ->get();
                if($states_obj)
                {
                    $states_arr    = $states_obj->toArray();
                    $obj_user_state = $this->UserModel->where('id',$user_details->id)->select('state')->first();
                    if($obj_user_state)
                    {
                      $arr_user_state = $obj_user_state->toArray();
                      $document_restrcited_states = $this->StatesModel->where('is_documents_required',1)->select('id')->get();
                      if($document_restrcited_states)
                      {
                         $document_restrcited_states = $document_restrcited_states->toArray();
                         foreach($document_restrcited_states as $res_state)
                         {
                            $restricted_states[]  = $res_state['id'];
                         }


                         if(in_array($arr_user_state['state'], $restricted_states)==false)
                         {
                            $this->arr_view_data['str_document_required'] = "No additional documents required";
                         }
                         if(in_array($arr_user_state['state'], $restricted_states)==true)
                         {
                           $this->arr_view_data['str_document_required'] = "";

                           $list_of_documents_required = $this->StatesModel->where('id',$arr_user_state['state'])->select('required_documents')->first();
                            if(isset($list_of_documents_required) && !empty($list_of_documents_required))
                            { 
                               $this->arr_view_data['list_document_required'] = $list_of_documents_required['required_documents'];
                            }
                         }
                      }
                    } 

                   


                    $this->arr_view_data['states_arr']         = $states_arr;
                }

                $documents_obj = $this->SellerDocumentsModel->where('seller_id', $user_details->id)->get();
               if ($documents_obj) 
               {
                  $documents_arr    = $documents_obj->toArray();
                  $this->arr_view_data['documents_arr']        = $documents_arr;
               }




  
                $this->arr_view_data['business_details']         = $this->SellerModel->where('user_id',$user_details->id)->first()->toArray();


                $this->arr_view_data['id_proof_public_path']     = $this->id_proof_public_path;
                $this->arr_view_data['document_public_path']     = $this->document_public_path;


                $this->arr_view_data['user_details_arr']         = $user_details_arr;
                $this->arr_view_data['id_proof_path']            = $this->id_proof_public_path;
                $this->arr_view_data['document_path']            = $this->document_public_path;


                $this->arr_view_data['profile_img_public_path']  = $this->profile_img_public_path;
                $this->arr_view_data['page_title']               = 'Business-Profile';
                
                return view($this->module_view_folder.'.edit',$this->arr_view_data);
       // } 
    }// end of edit profile sections

    public function membership_detail()
    {

        $seller_arr = [];
        $subscription_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();
       
        $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();
        
      
        if($seller_obj)
        {
            $seller_arr = $seller_obj->toArray();
            $user_details_arr['user_details']            = $seller_arr;
        }

        $get_subscription = $this->UserSubscriptionsModel->where('user_id',$user_details->id)->where('membership_status','1')->get();


          if(isset($get_subscription) && !empty($get_subscription))
          {

             $get_subscription = $get_subscription->toArray();


             if(isset($get_subscription) && !empty($get_subscription))
             {
                $membership_type = $get_subscription[0]['membership'];
                if($membership_type=='1') //if memebrship type is free 
                {
                   
                     return redirect('/seller/membership');
                }
                else
                {
                    return redirect('/seller/membership');
                    // if membership is paid then show details
                                     
                           /* $membership_id = $get_subscription[0]['membership_id'];        
                            $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();
                            if(!empty($get_panname)){
                              $get_panname = $get_panname->toArray();
                              $plan_name = $get_panname['name'];

                              $subscription_arr['subscription_arr'] = $get_subscription;
                              $subscription_arr['membership_arr'] = $get_panname;
                              $this->arr_view_data['user_subscription_details']         = $subscription_arr;
                            }*/


               }// else of if memebrship type is paid 




            }
            else
            {

               // if no subscription data then make entry in db

                return redirect('/seller/membership');
                
              /*   commented code to remove free subscripton temporary
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
                    $arr_subscription['user_id']       = $user_details_arr['id'];
                    $arr_subscription['membership_id'] = $membership_id ;
                    $arr_subscription['membership'] = '1';
                    $arr_subscription['membership_amount'] = '0';
                    $arr_subscription['membership_status'] = '1';

                    $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);

                    return redirect('/seller/membership');

               }  */                       
                       
                
             } // else of get subscription
          }// if get subscription object

      

        $this->arr_view_data['user_details_arr']   = $user_details_arr;
        $this->arr_view_data['page_title']         = 'Membership Details';
        return view($this->module_view_folder.'.membership_details',$this->arr_view_data);
    }

   

    public function membership()
    {   
        
        $seller_arr = [];
        $subscription_arr = [];
        $get_cancelmembershipdata=[];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

        if(isset($user_details_arr) && !empty($user_details_arr))
        {

            //get canceled memebrshipdata
            /****************************************/

               $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                        ->where('user_id',$user_details_arr['id'])
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


            $get_membershipdata = $this->UserSubscriptionsModel
                        ->where('user_id',$user_details_arr['id'])
                        ->where('membership_status','1')
                        ->first();

            if(isset($get_membershipdata) && (!empty($get_membershipdata)))
            {
               // return redirect('/seller/membership_detail');
            }
            else
            {

                    $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();
                    
                  
                    if($seller_obj)
                    {
                        $seller_arr = $seller_obj->toArray();
                        $user_details_arr['user_details']            = $seller_arr;
                    }
              
           }//else 


           $dbactive_membershipid='';

           if(isset($get_membershipdata) && (!empty($get_membershipdata)))
           {
                $get_membershipdata = $get_membershipdata->toArray();

                $dbactive_membershipid = $get_membershipdata['membership_id']; //added on 2 july
           } 

            $arr_membership = [];


            /*******cond*added if *seller purchase memnership and admin daeactive that membership then it shoude show on seller plan*****/

            if(isset($dbactive_membershipid) && !empty($dbactive_membershipid))
            {
               $arr_membership = $this->MembershipModel
                                ->select('*')
                                ->where('is_active','1')
                                ->orWhere('id',$dbactive_membershipid)
                                ->orderBy('membership_type')
                                ->get()
                                ->toArray();

            }
            else
            {
               $arr_membership = $this->MembershipModel
                                ->select('*')
                                ->where('is_active','1')
                                ->orderBy('membership_type')
                                ->get()
                                ->toArray();

            }
            /*********end condition***2july20**************************/

           /* $arr_membership = $this->MembershipModel
                                ->select('*')
                                ->where('is_active','1')
                                ->orderBy('membership_type')
                                ->get()
                                ->toArray();*/


            $this->arr_view_data['arr_membership']  = isset($arr_membership) ? $arr_membership : [];   
            $this->arr_view_data['user_details_arr']   = $user_details_arr;
            $this->arr_view_data['page_title']   = 'Membership Plan';
            $this->arr_view_data['get_membershipdata'] = isset($get_membershipdata)?$get_membershipdata:[];


            $user_subscried = 0;
            if ($user_details->subscribed('main')) {
                $user_subscried = 1;

            }else{
              $user_subscried =0;
            }
            $this->arr_view_data['user_subscribed'] = $user_subscried;



        }//if user detail data


        return view($this->module_view_folder.'.membership',$this->arr_view_data);
    }
    public function membership_selection_old_23_apr_20(Request $request)
    {
        $response = [];
        $seller_arr = [];
        $subscription_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

        $loginuserid = $user_details_arr['id'];

       
        $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();
        
      
        if($seller_obj)
        {
            $seller_arr = $seller_obj->toArray();
        }

                $form_data = $request->all();

                if($form_data)
                {



                    $membership_id = isset($form_data['subscription'])?$form_data['subscription']:'';
                    $membership_amount = isset($form_data['amount'])?$form_data['amount']:'';
                    $membership_type = isset($form_data['membership_type'])?$form_data['membership_type']:'';

                    if(isset($membership_amount) && isset($membership_type) && isset($membership_id)){

                        $plan_name ='';

                        $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();
                        
                        if(!empty($get_panname)){
                            $get_panname = $get_panname->toArray();
                            $plan_name = $get_panname['name'];
                        }


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

                        # setup authorization
                        $api_config = new \SquareConnect\Configuration();

                        if(isset($sandbox_url) && $payment_mode=='0') 
                            $api_config->setHost($sandbox_url);         
                        else if(isset($live_url) && $payment_mode=='1')  
                            $api_config->setHost($live_url);
            
                        if(isset($sandbox_access_token) && $payment_mode=='0')
                            $api_config->setAccessToken($sandbox_access_token);
                         elseif(isset($live_access_token) && $payment_mode=='1')
                            $api_config->setAccessToken($live_access_token);


                        $api_client = new \SquareConnect\ApiClient($api_config);

                        $payments_api = new \SquareConnect\Api\PaymentsApi($api_client);
                        

                        $nonce = $request['nonce'];

                        $body = new \SquareConnect\Model\CreatePaymentRequest();

                        $amountMoney = new \SquareConnect\Model\Money();
                        
                        $amountMoney->setAmount(100*ceil($membership_amount));
                        $amountMoney->setCurrency("USD");

                        $body->setSourceId($nonce);
                        $body->setAmountMoney($amountMoney);
                      //    $body->setBuyerEmailAddress($email);

                        if(isset($sandbox_location_id) && $payment_mode=='0')
                            $body->setLocationId($sandbox_location_id);
                        elseif(isset($live_location_id) && $payment_mode=='1')
                            $body->setLocationId($live_location_id);
                        $body->setIdempotencyKey(uniqid());


                        $arr_subscription =[];


                            $admin_role = Sentinel::findRoleBySlug('admin');  

                            $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                            $admin_id   = 0;
                            if($admin_obj)
                            {
                                $admin_id = $admin_obj->user_id;            
                            }


                        if($membership_type=="1") // if free membership
                        {

                            $arr_subscription['transaction_id'] = '';
                            $arr_subscription['payment_status'] = '0';
                            $arr_subscription['user_id']     = $loginuserid;
                            $arr_subscription['membership_id'] = $membership_id ;
                            $arr_subscription['membership'] = $membership_type;
                            $arr_subscription['membership_amount'] = $membership_amount;
                            $arr_subscription['membership_status'] = '1';
                            
                            $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);

                            $response['status'] = "SUCCESS";
                            $response['msg'] = "Membership plan activated successfully.";


                                 if($user_details_arr['first_name']=="" || $user_details_arr['last_name'])
                                {  
                                    $set_username = $user_details_arr['email']; 
                                   
                                }else{
                                    $set_username = $user_details_arr['first_name'].' '.$user_details_arr['last_name'];
                                }



                               // send noti to admin
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $loginuserid;
                                $arr_event['to_user_id']   = $admin_id;
                                $arr_event['type']         = 'admin';
                                $arr_event['description']  = $set_username.'  selected <b> '.$plan_name.' </b> membership plan .';
                                $arr_event['title']        = 'Membership Purchase';
                                
                                $this->GeneralService->save_notification($arr_event);

                                // send noti to user
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $admin_id;
                                $arr_event['to_user_id']   = $loginuserid;
                                $arr_event['type']         = 'Seller';

                                if($membership_type=='1'){
                                     $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan.';
                                }
                                else{
                                                                      
                                      $set_amount =  '$'.number_format($membership_amount);
                                 
                                      $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' amount.';

                                }
                               
                                $arr_event['title']        = 'Membership Purchase';
                                
                                $this->GeneralService->save_notification($arr_event);



                              


                                 //send email to admin
                                $msg     = $set_username.'  selected <b> '.$plan_name.' </b> membership plan .';

                                $user_membership_url = url('/').'/seller/membership_detail';

                                $subject = 'Membership Purchase';
                                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                      'APP_NAME'      => config('app.project.name'),
                                                      'MESSAGE'       => $msg,
                                                     // 'URL'           => $user_membership_url
                                                     ];

                                $arr_mail_data2['email_template_id'] = '31';
                                $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                $arr_mail_data2['arr_built_subject'] = $subject;
                                $arr_mail_data2['user']              = Sentinel::findById($admin_id);

                                $this->EmailService->send_notification_mail($arr_mail_data2);




                                //send email to user
                                $msg2     = ' You have successfully selected <b> '.$plan_name.' </b> membership plan .';

                                $user_membership_url = url('/').'/seller/membership_detail';

                                $subject2 = 'Membership Purchase';
                                $arr_built_content = ['USER_NAME'     => $set_username,
                                                      'APP_NAME'      => config('app.project.name'),
                                                      'MESSAGE'       => $msg2,
                                                      'URL'           => $user_membership_url
                                                     ];

                                $arr_mail_data2['email_template_id'] = '31';
                                $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                $arr_mail_data2['arr_built_subject'] = $subject2;
                                $arr_mail_data2['user']              = $user_details_arr;

                                $this->EmailService->send_notification_mail($arr_mail_data2);





                        }
                        else
                        {

                         try {
                                $result = $payments_api->createPayment($body);

                                if($result['payment']['id'])
                                {

                                    $get_db_usersubscription = $this->UserSubscriptionsModel->where('user_id',$loginuserid)->first();
                                    if(!isset($get_db_usersubscription) && empty($get_db_usersubscription))
                                    {
                                        $arr_subscription['transaction_id'] = $result['payment']['id'];
                                        $arr_subscription['payment_status'] = '1';
                                        $arr_subscription['user_id']     = $loginuserid;
                                        $arr_subscription['membership_id'] = $membership_id ;
                                        $arr_subscription['membership'] = $membership_type;
                                        $arr_subscription['membership_amount'] = $membership_amount;
                                        $arr_subscription['membership_status'] = '1';
                                        
                                        $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);
                                    }else{



                                    $arr_subscription['transaction_id'] = $result['payment']['id'];
                                    $arr_subscription['payment_status'] = '1';
                                    $arr_subscription['membership_amount'] = $membership_amount;
                                    $arr_subscription['membership'] = $membership_type;
                                    $arr_subscription['membership_id'] = $membership_id ;

                                     $store_subscription_details = $this->UserSubscriptionsModel->where('user_id',$loginuserid)->update($arr_subscription);

                                   }//else update

                                  /*  $arr_subscription['transaction_id'] = $result['payment']['id'];
                                    $arr_subscription['payment_status'] = '1';
                                    $arr_subscription['user_id']     = $loginuserid;
                                    $arr_subscription['membership_id'] = $membership_id ;
                                    $arr_subscription['membership'] = $membership_type;
                                    $arr_subscription['membership_amount'] = $membership_amount;
                                    $arr_subscription['membership_status'] = '1';
                                    
                                    $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);*/

                                 if($user_details_arr['first_name']=="" || $user_details_arr['last_name'])
                                {   
                                   $set_username = $user_details_arr['email'];
                                    
                                }else{
                                   $set_username = $user_details_arr['first_name'].' '.$user_details_arr['last_name'];
                                }


                                $set_amount =  '$'.number_format($membership_amount);

                                  // send noti to admin
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $loginuserid;
                                $arr_event['to_user_id']   = $admin_id;
                                $arr_event['type']         = 'admin';
                                $arr_event['description']  = $set_username.'  selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';
                                $arr_event['title']        = 'Membership Purchase';
                                
                                $this->GeneralService->save_notification($arr_event);

                                // send noti to user
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $admin_id;
                                $arr_event['to_user_id']   = $loginuserid;
                                $arr_event['type']         = 'Seller';

                                if($membership_type=='1'){
                                     $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan.';
                                }else{
                                     $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' amount.';
                                }
                               
                                $arr_event['title']        = 'Membership Purchase';
                                
                                $this->GeneralService->save_notification($arr_event);



                                 //send email to admin
                                $msg     = $set_username.'  selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';

                                $user_membership_url = url('/').'/seller/membership_detail';

                                $subject = 'Membership Purchase';
                                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                      'APP_NAME'      => config('app.project.name'),
                                                      'MESSAGE'       => $msg,
                                                     // 'URL'           => $user_membership_url
                                                     ];

                                $arr_mail_data2['email_template_id'] = '31';
                                $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                $arr_mail_data2['arr_built_subject'] = $subject;
                                $arr_mail_data2['user']              = Sentinel::findById($admin_id);

                                $this->EmailService->send_notification_mail($arr_mail_data2);




                                //send email to user
                                $msg2     = 'You have successfully selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';

                                $user_membership_url = url('/').'/seller/membership_detail';

                                $subject2 = 'Membership Purchase';
                                $arr_built_content = ['USER_NAME'     => $set_username,
                                                      'APP_NAME'      => config('app.project.name'),
                                                      'MESSAGE'       => $msg2,
                                                      'URL'           => $user_membership_url
                                                     ];

                                $arr_mail_data2['email_template_id'] = '31';
                                $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                $arr_mail_data2['arr_built_subject'] = $subject2;
                                $arr_mail_data2['user']              = $user_details_arr;

                                $this->EmailService->send_notification_mail($arr_mail_data2);


                                    $response['status'] = "SUCCESS";
                                    $response['msg'] = "Membership plan activated successfully.";
                                    $response['transaction_id'] = $result['payment']['id'];
                                    $response['result'] = $result;
                                }
                            } catch (\SquareConnect\ApiException $e) {
                                    $response['status'] = "ERROR";
                                    $response['msg'] = $e->getResponseBody();
                            }

                          }//else of membership type 2  


                        }//if membership id ,amount,type
                        else
                        {
                             $response['status'] = "ERROR";
                             $response['msg'] = 'Something went wrong.';
                        }    

                 }
                else{
                    $response['status'] = "ERROR";
                    $response['msg'] = 'Payment not processing';
                }
                return $response;


  
    }// old end of membership selection function

   public function membership_selection(Request $request)
    {
        $response = [];
        $seller_arr = [];
        $subscription_arr = [];
        $get_membershipdata=[];

        $user_details = false;
        $user_details = Sentinel::getUser();       
        $user_details_arr = $user_details->toArray();
        $loginuserid = $user_details_arr['id'];

        $user_subscribed = 0;
        if ($user_details->subscribed('main')) {
            $user_subscribed = 1;

        }else{
          $user_subscribed =0;
        }

       
        $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();
        
      
        if($seller_obj)
        {
            $seller_arr = $seller_obj->toArray();
        }

                $form_data = $request->all();

                if($form_data)
                {

                   $get_membershipdata = $this->UserSubscriptionsModel->where('user_id',$loginuserid)->where('membership_status','1')->first();
                  if(isset($get_membershipdata) && (!empty($get_membershipdata)))
                   {
                        $get_membershipdata = $get_membershipdata->toArray();

                   }

                    $membership_id = isset($form_data['subscription'])?$form_data['subscription']:'';
                    $membership_amount = isset($form_data['amount'])?$form_data['amount']:'';
                    $membership_type = isset($form_data['membership_type'])?$form_data['membership_type']:'';
                    $stripe_plan_id = isset($form_data['stripe_plan_id'])?$form_data['stripe_plan_id']:'';
                    $stripeToken = isset($form_data['stripeToken'])?$form_data['stripeToken']:'';
                    $card_number = isset($form_data['card_number'])?$form_data['card_number']:'';
                    $card_exp_month = isset($form_data['card_exp_month'])?$form_data['card_exp_month']:'';
                    $card_exp_year = isset($form_data['card_exp_year'])?$form_data['card_exp_year']:'';

                     $card_cvc = isset($form_data['card_cvc'])?$form_data['card_cvc']:'';

                     /*******************create stripe product if not exists******/
                      $stripe_product_plan_arr = $this->check_stripe_product_exists($membership_id);

                      if(isset($stripe_product_plan_arr) && !empty($stripe_product_plan_arr))
                      {
                         $stripe_product_id = $stripe_product_plan_arr['stripe_product_id'];
                         $stripe_plan_id = $stripe_product_plan_arr['stripe_plan_id'];
                      }
                      else
                      {
                        $stripe_plan_id = $stripe_plan_id;
                      }

               

                     /**************end of create stripe product**************/


                    if(isset($membership_amount) && isset($membership_type) && isset($membership_id)){

                        $plan_name ='';

                        $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();
                        
                        if(!empty($get_panname)){
                            $get_panname = $get_panname->toArray();
                            $plan_name = $get_panname['name'];
                        }


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

                     


                            $arr_subscription =[];

                            $admin_role = Sentinel::findRoleBySlug('admin');  

                            $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                            $admin_id   = 0;
                            if($admin_obj)
                            {
                                $admin_id = $admin_obj->user_id;            
                            }


                        if($membership_type=="1") // if free membership
                        {

                            /******23-june-20***25june****if already membership of strip in upgrade option want to switch to free plan then cancel his previous membership*******************/
                              $update_subscriptiondata = [];
                              $update_subscriptiondata['membership_status']=0;
                              $current_period_enddate ='';

                            if ($user_details->subscribed('main')) 
                            { 
                                //if membership type is 2
                                if($get_membershipdata['membership']=="2")
                                {

                                   $subscriptionobj = $user_details->asStripeCustomer()["subscriptions"] ;
                                 
                                      $current_period_startdate ='';
                                      $current_period_enddate ='';
                                       
                                     if($subscriptionobj){

                                       $current_period_startdate = Carbon::createFromTimestamp(
                                            $subscriptionobj['data'][0]['current_period_start']);


                                       $current_period_enddate = Carbon::createFromTimestamp(
                                                $subscriptionobj['data'][0]['current_period_end']);

                                        $update_subscriptiondata['current_period_enddate']=$current_period_enddate;
                                         $update_subscriptiondata['is_cancel']=1;
 

                                     }  
                                      $user_details->subscription('main')->cancelNow();

                                } //if memtype is 2
                             }//if user subscriebd already
                              


                            /****************23-june-20********************************/


                          /***********end newly added***for free plan*****@22-june-20********/
                            //update previous memebrship status to 0 
                           $update_subscription_status = 
                                                     $this->UserSubscriptionsModel
                                                    ->where('user_id',$loginuserid)
                                                    ->where('membership_id',$get_membershipdata['membership_id'])
                                                   // ->update(['membership_status'=>'0']);
                                                    ->update($update_subscriptiondata);

                                  $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();

                                   $product_count='';
                                  
                                  if(!empty($get_panname))
                                  {
                                      $get_panname = $get_panname->toArray();
                                      $product_count = $get_panname['product_count'];
                                  }
                      

                            /**if switch to free plan then set product status to inactive**for prev membership*/
                             /* $get_products = $this->ProductModel->where('user_id',$loginuserid)->get();                           
                              if(isset($get_products) && (!empty($get_products)))
                              {
                                   $get_products = $get_products->toArray(); 
                                   foreach($get_products as $products)
                                   {
                                        $productid = $products['id'];
                                        $this->ProductModel->where('id',$productid)->update(['is_active'=>0]);
                                   }

                               }//if  */


                               $setinactive =0; $activecount=0;
                               $get_active_products = $this->ProductModel->where('user_id',$loginuserid)->where('is_active','1')->get(); 

                                if(isset($get_active_products) && (!empty($get_active_products)))
                               {
                                   $get_active_products = $get_active_products->toArray();
                                   $activecount = count($get_active_products);
                                   if($activecount>0 && $activecount>$product_count)
                                   {
                                     $setinactive = $activecount-$product_count;
                                     for($i=0;$i<$setinactive;$i++)
                                     {
                                         $productid = $get_active_products[$i]['id'];
                                          $this->ProductModel->where('id',$productid)->update(['is_active'=>0]);
                                     }

                                   }//if activecount

                               }//if not empty active products

                               /************set proudct to deactive*************/     



                           /***********end newly added***for free plan********************/

                            $arr_subscription['product_limit'] = $product_count;
                            $arr_subscription['transaction_id'] = '';
                            $arr_subscription['payment_status'] = '0';
                            $arr_subscription['user_id']     = $loginuserid;
                            $arr_subscription['membership_id'] = $membership_id ;
                            $arr_subscription['membership'] = $membership_type;
                            $arr_subscription['membership_amount'] = $membership_amount;
                            $arr_subscription['membership_status'] = '1';
                            
                            $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);

                            $response['status'] = "SUCCESS";
                            $response['msg'] = "Membership plan activated successfully.";


                                 if($user_details_arr['first_name']=="" || $user_details_arr['last_name'])
                                {  
                                    $set_username = $user_details_arr['email']; 
                                   
                                }else{
                                    $set_username = $user_details_arr['first_name'].' '.$user_details_arr['last_name'];
                                }



                               // send noti to admin
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $loginuserid;
                                $arr_event['to_user_id']   = $admin_id;
                                $arr_event['type']         = 'admin';
                                $arr_event['description']  = $set_username.'  selected <b> '.$plan_name.' </b> membership plan .';
                                $arr_event['title']        = 'Membership Purchase';
                                
                                $this->GeneralService->save_notification($arr_event);

                                // send noti to user
                                $arr_event                 = [];
                                $arr_event['from_user_id'] = $admin_id;
                                $arr_event['to_user_id']   = $loginuserid;
                                $arr_event['type']         = 'Seller';

                                if($membership_type=='1'){
                                     $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan.';
                                }
                                else{
                                                                      
                                      $set_amount =  '$'.number_format($membership_amount);
                                 
                                      $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' amount.';

                                }
                               
                                $arr_event['title']        = 'Membership Purchase';
                                
                                $this->GeneralService->save_notification($arr_event);

                      

                                 //send email to admin
                                $msg     = $set_username.'  selected <b> '.$plan_name.' </b> membership plan .';

                                $user_membership_url = url('/').'/seller/membership_detail';

                                //$subject = 'Membership Purchase';
                                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                      'APP_NAME'      => config('app.project.name'),
                                                      //'MESSAGE'       => $msg,
                                                      'SELLER_NAME'   => $set_username,
                                                      'PLAN_NAME'     => $plan_name
                                                     // 'URL'           => $user_membership_url
                                                     ];

                                $arr_mail_data2['email_template_id'] = '59';
                                $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                $arr_mail_data2['arr_built_subject'] = '';
                                $arr_mail_data2['user']              = Sentinel::findById($admin_id);

                                $this->EmailService->send_mail_section($arr_mail_data2);




                                //send email to user
                              /*  $msg2     = ' You have successfully selected <b> '.$plan_name.' </b> membership plan .';*/

                                $user_membership_url = url('/').'/seller/membership_detail';

                                //$subject2 = 'Membership Purchase';
                                $arr_built_content = ['USER_NAME'     => $set_username,
                                                      'APP_NAME'      => config('app.project.name'),
                                                      //'MESSAGE'       => $msg2,
                                                      'PLAN_NAME'     => $plan_name,
                                                      'URL'           => $user_membership_url
                                                     ];

                                $arr_mail_data2['email_template_id'] = '61';
                                $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                $arr_mail_data2['arr_built_subject'] = '';
                                $arr_mail_data2['user']              = $user_details_arr;

                                $this->EmailService->send_mail_section($arr_mail_data2);

                        }//if type 1
                        else
                        {
                            //if type is 2

                                 if($user_details_arr['first_name']=="" || $user_details_arr['last_name'])
                                {   
                                   $set_username = $user_details_arr['email'];
                                    
                                }else{
                                   $set_username = $user_details_arr['first_name'].' '.$user_details_arr['last_name'];
                                }

                                $set_amount =  '$'.number_format($membership_amount);



                            //check whether user is subscribed to paid
                            if($user_subscribed=='1' && isset($get_membershipdata) && (!empty($get_membershipdata)))
                            {   
                                //upgrade plan here

                               $exists_carddata =  $this->checkcarddetail_exists($loginuserid);
                               
                               if($exists_carddata=='1' && isset($stripe_plan_id))
                               {

                                    $upgrade_plan = $user_details->subscription('main')->swap($stripe_plan_id); //swap plan



                                          /********update product limit*********/
                                             $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();

                                            $product_count='';
                                            
                                            if(!empty($get_panname))
                                            {
                                                $get_panname = $get_panname->toArray();
                                                $product_count = $get_panname['product_count'];

                                                $pcountarr = [];

                                                $getpreviouslimit = $this->UserModel->where('id',$loginuserid)->first();
                                                if(isset($getpreviouslimit) && !empty($getpreviouslimit))
                                                {

                                                   $getpreviouslimit = $getpreviouslimit->toArray();
                                                   
                                                   $db_prev_limit = $getpreviouslimit['product_limit']; 

                                                    $pcountarr['product_limit']= 
                                                    $db_prev_limit+
                                                       $product_count;

                                                 $this->UserModel->where('id',$loginuserid)->update($pcountarr);

                                                }//if
                                               
                                            }//if plan name
                                          

                                        /************************************/


                                           // make previous membership status inactive
                                           $update_subscription_status = 
                                                     $this->UserSubscriptionsModel
                                                    ->where('user_id',$loginuserid)
                                                    ->where('membership_id',$get_membershipdata['membership_id'])
                                                    ->update(['membership_status'=>'0']);


                                               /**if switch to other plan then set product status to inactive**for prev membership added on 26june20 upgrade option*/
                                               
                                                 /* $get_products = $this->ProductModel->where('user_id',$loginuserid)->get();
                                                  if(isset($get_products) && (!empty($get_products)))
                                                  {
                                                       $get_products = $get_products->toArray(); 
                                                       foreach($get_products as $products)
                                                       {
                                                            $productid = $products['id'];
                                                            $this->ProductModel->where('id',$productid)->update(['is_active'=>0]);
                                                       }

                                                   }//if  */ 


                                                 $setinactive =0; $activecount=0;
                                                 $get_active_products = $this->ProductModel->where('user_id',$loginuserid)->where('is_active','1')->get(); 
                                                
                                                  if(isset($get_active_products) && (!empty($get_active_products)))
                                                 {
                                                     $get_active_products = $get_active_products->toArray();
                                                     $activecount = count($get_active_products);
                                                     if($activecount>0 && $activecount>$product_count)
                                                     {
                                                       $setinactive = $activecount-$product_count;
                                                       for($i=0;$i<$setinactive;$i++)
                                                       {
                                                           $productid = $get_active_products[$i]['id'];
                                                            $this->ProductModel->where('id',$productid)->update(['is_active'=>0]);
                                                       }

                                                     }//if activecount

                                                 }//if not empty active products



                                           /************set proudct to deactive**26june20****/     


                                


                                      // $arr_subscription['transaction_id'] = $result['payment']['id'];
                                        $arr_subscription['payment_status'] = '1';
                                        $arr_subscription['user_id']     = $loginuserid;
                                        $arr_subscription['membership_id'] = $membership_id ;
                                        $arr_subscription['membership'] = $membership_type;
                                        $arr_subscription['membership_amount'] = $membership_amount;
                                        $arr_subscription['membership_status'] = '1';
                                        $arr_subscription['is_upgrade'] = '1';
                                        $arr_subscription['product_limit'] = $product_count;

                                        $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);  


                                        




                                        /**************send noti for upgrade**********/
                                                // send noti to admin
                                        $arr_event                 = [];
                                        $arr_event['from_user_id'] = $loginuserid;
                                        $arr_event['to_user_id']   = $admin_id;
                                        $arr_event['type']         = 'admin';
                                        $arr_event['description']  = $set_username.'  upgrade the <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';
                                        $arr_event['title']        = 'Membership Upgrade';
                                        
                                        $this->GeneralService->save_notification($arr_event);


                                        //send noti to user
                                        $arr_event                 = [];
                                        $arr_event['from_user_id'] = $admin_id;
                                        $arr_event['to_user_id']   = $loginuserid;
                                        $arr_event['type']         = 'Seller';

                                       
                                             $arr_event['description']  = 'You have successfully upgrade the <b> '.$plan_name.' </b> membership plan of '.$set_amount.' amount.';
                                      
                                        $arr_event['title']        = 'Membership Upgrade';
                                        
                                        $this->GeneralService->save_notification($arr_event);


                                             //send email to admin
                                      /*  $msg     = $set_username.'  upgraded <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';*/

                                        $user_membership_url = url('/').'/seller/membership_detail';

                                        //$subject = 'Membership Upgrade';
                                        $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                              'APP_NAME'      => config('app.project.name'),
                                                              //'MESSAGE'       => $msg,
                                                              'SELLER_NAME'   => $set_username,
                                                              'PLAN_NAME'     => $plan_name,
                                                              'AMOUNT'        => $set_amount  
                                                             // 'URL'           => $user_membership_url
                                                             ];

                                        $arr_mail_data2['email_template_id'] = '62';
                                        $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                        $arr_mail_data2['arr_built_subject'] = '';
                                        $arr_mail_data2['user']              = Sentinel::findById($admin_id);

                                        $this->EmailService->send_mail_section($arr_mail_data2);

                                        //send email to user
                                       // $msg2     = 'You have successfully upgraded to <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';

                                        $user_membership_url = url('/').'/seller/membership_detail';

                                        //$subject2 = 'Membership Upgrade';
                                        $arr_built_content = ['USER_NAME'     => $set_username,
                                                              'APP_NAME'      => config('app.project.name'),
                                                              //'MESSAGE'       => $msg2,
                                                              'PLAN_NAME'     => $plan_name,
                                                              'AMOUNT'        => $set_amount, 
                                                              'URL'           => $user_membership_url
                                                             ];

                                        $arr_mail_data2['email_template_id'] = '64';
                                        $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                        $arr_mail_data2['arr_built_subject'] = '';
                                        $arr_mail_data2['user']              = $user_details_arr;

                                        $this->EmailService->send_mail_section($arr_mail_data2); 



                                        /***********end of send noti for upgrade****/





                               }//if cardata exists and stripe plan id
                                else
                                {
                                     $response['status'] = "ERROR";
                                     $response['msg'] = 'Card details not exists or plan id not exists.';
                                }//else of card not exists    




                            }else if($user_subscribed=='0' && isset($get_membershipdata) && !empty($get_membershipdata))
                            {

                                 // user not subscribed to paid and  membership data exists then create new subscription plan of user
                                if($card_number && $card_exp_year && $card_exp_month && $card_cvc && $stripeToken && $stripe_plan_id)
                                {

                                    try { 
                                       
                                        $usersubscribe = UserModel::find($loginuserid);
                                        $subscriptiondata = $usersubscribe->newSubscription('main', $stripe_plan_id)->create($stripeToken, [
                                            'email' => $user_details_arr['email'],
                                        ]);

                                         if($subscriptiondata)
                                        {

                                           $subscriptiondata = $subscriptiondata->jsonSerialize();

                                            /**************check status of subscripiton*****************/ 
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

                                           $subscribe_status='';

                                            try
                                            {
                                                \Stripe\Stripe::setApiKey($stripe_secret_key);

                                                $subscibedata = \Stripe\Subscription::retrieve     (
                                                          $subscriptiondata['stripe_id']
                                                        );

                                                $subscribe_status = $subscibedata['status'];
                                               
                                            }
                                            catch(Exception $e)
                                            { 
                                               
                                                $arr_response['status'] = "failure";
                                                $arr_response['msg'] = $e->getMessage();
                                                return $arr_response;
                                            }   

                                        /***************************************/
                                           
                                           $subsrc_arr =[
                                                         'subscription_id'=>$subscriptiondata['stripe_id'],
                                                         'customer_id'=>$subscriptiondata['user_model_id'],
                                                         'plan_id'=>$subscriptiondata['stripe_plan'],
                                                         'membership_id'=>$membership_id,
                                                         'status'=>$subscribe_status
                                                        ];   
                                         $stripe_subscription_id = $subscriptiondata['id'];
              

                                                   
                                        $stripe_subscrinsert_id = $this->StripeSubscriptionsModel->create($subsrc_arr); 

                                        //update previous memebrship status to 0
                                         $update_subscription_status = 
                                                     $this->UserSubscriptionsModel
                                                    ->where('user_id',$loginuserid)
                                                    ->where('membership_id',$get_membershipdata['membership_id'])
                                                    ->update(['membership_status'=>'0']);
                                       

                                        /********update product limit*********/
                                             $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();

                                            $product_count='';
                                            
                                            if(!empty($get_panname))
                                            {
                                                $get_panname = $get_panname->toArray();
                                                $product_count = $get_panname['product_count'];

                                                $pcountarr = [];
                                                 $pcountarr['product_count']= 0;
                                                $pcountarr['product_limit']=$product_count;
                                            }
                                            $this->UserModel->where('id',$loginuserid)->update($pcountarr);

                                        /************************************/    


                                        /******26-june-20**set other product inactive ***********/
                                           $setinactive =0; $activecount=0;
                                           $get_active_products = $this->ProductModel->where('user_id',$loginuserid)->where('is_active','1')->get(); 
                                          
                                            if(isset($get_active_products) && (!empty($get_active_products)))
                                           {
                                               $get_active_products = $get_active_products->toArray();
                                               $activecount = count($get_active_products);
                                               if($activecount>0 && $activecount>$product_count)
                                               {
                                                 $setinactive = $activecount-$product_count;
                                                 for($i=0;$i<$setinactive;$i++)
                                                 {
                                                     $productid = $get_active_products[$i]['id'];
                                                      $this->ProductModel->where('id',$productid)->update(['is_active'=>0]);
                                                 }

                                               }//if activecount

                                           }//if not empty active products

                                        /******26-june20****setotherproductinactive*************/    


                                        //crete user subscription table entry
                                        $arr_subscription['payment_status'] = '1';
                                        $arr_subscription['user_id']     = $loginuserid;
                                        $arr_subscription['membership_id'] = $membership_id ;
                                        $arr_subscription['membership'] = $membership_type;
                                        $arr_subscription['membership_amount'] = $membership_amount;
                                        $arr_subscription['membership_status'] = '1';
                                        $arr_subscription['transaction_id'] = $stripe_subscription_id;    
                                        $arr_subscription['subscribe_status']=$subscribe_status;
                                        $arr_subscription['product_limit'] = 
                                                                $product_count;

                                        $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);     


                                        



                                        /******send noti and email*************/
                                           // send noti to admin
                                        $arr_event                 = [];
                                        $arr_event['from_user_id'] = $loginuserid;
                                        $arr_event['to_user_id']   = $admin_id;
                                        $arr_event['type']         = 'admin';
                                        $arr_event['description']  = $set_username.'  selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';
                                        $arr_event['title']        = 'Membership Purchase';
                                        
                                        $this->GeneralService->save_notification($arr_event);

                                        // send noti to user
                                        $arr_event                 = [];
                                        $arr_event['from_user_id'] = $admin_id;
                                        $arr_event['to_user_id']   = $loginuserid;
                                        $arr_event['type']         = 'Seller';

                                        if($membership_type=='1'){
                                             $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan.';
                                        }else{
                                             $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' amount.';
                                        }
                                       
                                        $arr_event['title']        = 'Membership Purchase';
                                        
                                        $this->GeneralService->save_notification($arr_event);


                                         //send email to admin
                                           /* $msg     = $set_username.'  selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';*/

                                            $user_membership_url = url('/').'/seller/membership_detail';

                                            //$subject = 'Membership Purchase';
                                            $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                                  'APP_NAME'      => config('app.project.name'),
                                                                  'SELLER_NAME'   => $set_username,
                                                                  'PLAN_NAME'     => $plan_name,
                                                                  'AMOUNT'        => $set_amount 
                                                                 // 'URL'           => $user_membership_url
                                                                 ];

                                            $arr_mail_data2['email_template_id'] = '62';
                                            $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data2['arr_built_subject'] = '';
                                            $arr_mail_data2['user']              = Sentinel::findById($admin_id);

                                            $this->EmailService->send_mail_section($arr_mail_data2);




                                            //send email to user
                                         /*   $msg2     = 'You have successfully selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';*/

                                            $user_membership_url = url('/').'/seller/membership_detail';

                                            //$subject2 = 'Membership Purchase';
                                            $arr_built_content = ['USER_NAME'     => $set_username,
                                                                  'APP_NAME'      => config('app.project.name'),
                                                                 // 'MESSAGE'       => $msg2,
                                                                  'PLAN_NAME'     => $plan_name,
                                                                  'AMOUNT'        => $set_amount,  
                                                                  'URL'           => $user_membership_url
                                                                 ];

                                            $arr_mail_data2['email_template_id'] = '64';
                                            $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data2['arr_built_subject'] = '';
                                            $arr_mail_data2['user']              = $user_details_arr;

                                            $this->EmailService->send_mail_section($arr_mail_data2);  


                                        /**********end of send noti and email*********/



                                        }//if subscripitondata                         

                                    }//try
                                    catch(\Stripe\Error\Card $e)
                                    {
                                        
                                        $arr_response['status'] = "ERROR";
                                        $arr_response['cardmsg'] = $e->getMessage();
                                        return $arr_response;
                                    } 
                                    catch (Exception $e)
                                    {
                                        $arr_response['status'] = "failure";
                                        $arr_response['msg'] = $e->getMessage();
                                        return $arr_response;
                                    
                                    }//catch
 

                                }//if card details and stripetoken
                                else{


                                     $response['status'] = "ERROR";
                                     $response['msg']    = 'Card details not avaliable or something went wrong with token or plan id.';

                                }



                            }
                            else if($user_subscribed=='0' && empty($get_membershipdata))
                            {
                                 // create new subscription plan of user if not any subscription entry in database

                                if($card_number && $card_exp_year && $card_exp_month && $card_cvc && $stripeToken && $stripe_plan_id)
                                {

                                    try { 
                                       
                                        $usersubscribe = UserModel::find($loginuserid);
                                        $subscriptiondata = $usersubscribe->newSubscription('main', $stripe_plan_id)->create($stripeToken, [
                                            'email' => $user_details_arr['email'],
                                        ]);

                                         if($subscriptiondata)
                                        {
                                           $subscriptiondata = $subscriptiondata->jsonSerialize(); 

                                           /**************check status of subscripiton*****************/ 
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

                                                $subscribe_status='';

                                                try
                                                {
                                                    \Stripe\Stripe::setApiKey($stripe_secret_key);

                                                    $subscibedata = \Stripe\Subscription::retrieve     (
                                                              $subscriptiondata['stripe_id']
                                                            );

                                                    $subscribe_status = $subscibedata['status'];
                                                   
                                                }
                                                catch(Exception $e)
                                                { 
                                                   
                                                    $arr_response['status'] = "failure";
                                                    $arr_response['msg'] = $e->getMessage();
                                                    return $arr_response;
                                                }   

                                             /***************************************/


                                           $subsrc_arr =[
                                                         'subscription_id'=>$subscriptiondata['stripe_id'],
                                                         'customer_id'=>$subscriptiondata['user_model_id'],
                                                         'plan_id'=>$subscriptiondata['stripe_plan'],
                                                         'membership_id'=>$membership_id,
                                                         'status'=>$subscribe_status
                                                        ];   
                                         $stripe_subscription_id = $subscriptiondata['id'];
             

                                                   
                                        $stripe_subscrinsert_id = $this->StripeSubscriptionsModel->create($subsrc_arr); 


                                         /********update product limit*********/
                                             $get_panname  = $this->MembershipModel->where('id',$membership_id)->first();

                                            $product_count='';
                                            
                                            if(!empty($get_panname))
                                            {
                                                $get_panname = $get_panname->toArray();
                                                $product_count = $get_panname['product_count'];

                                                $pcountarr = [];
                                                 $pcountarr['product_count']=0;
                                                $pcountarr['product_limit']=$product_count;
                                            }
                                            $this->UserModel->where('id',$loginuserid)->update($pcountarr);

                                        /************************************/
                                       
                                        //crete user subscription table entry
                                        $arr_subscription['payment_status'] = '1';
                                        $arr_subscription['user_id']     = $loginuserid;
                                        $arr_subscription['membership_id'] = $membership_id ;
                                        $arr_subscription['membership'] = $membership_type;
                                        $arr_subscription['membership_amount'] = $membership_amount;
                                        $arr_subscription['membership_status'] = '1';
                                        $arr_subscription['transaction_id'] = $stripe_subscription_id;    
                                        $arr_subscription['subscribe_status']=$subscribe_status;

                                         $arr_subscription['product_limit']=$product_count;

                                        $store_subscription_details = $this->UserSubscriptionsModel->create($arr_subscription);    


                                         



                                         /******send noti and email*************/
                                           // send noti to admin
                                        $arr_event                 = [];
                                        $arr_event['from_user_id'] = $loginuserid;
                                        $arr_event['to_user_id']   = $admin_id;
                                        $arr_event['type']         = 'admin';
                                        $arr_event['description']  = $set_username.'  selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';
                                        $arr_event['title']        = 'Membership Purchase';
                                        
                                        $this->GeneralService->save_notification($arr_event);

                                        // send noti to user
                                        $arr_event                 = [];
                                        $arr_event['from_user_id'] = $admin_id;
                                        $arr_event['to_user_id']   = $loginuserid;
                                        $arr_event['type']         = 'Seller';

                                        if($membership_type=='1'){
                                             $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan.';
                                        }else{
                                             $arr_event['description']  = 'You have successfully selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' amount.';
                                        }
                                       
                                        $arr_event['title']        = 'Membership Purchase';
                                        
                                        $this->GeneralService->save_notification($arr_event);


                                         //send email to admin
                                           /* $msg     = $set_username.'  selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';*/

                                            $user_membership_url = url('/').'/seller/membership_detail';

                                            //$subject = 'Membership Purchase';
                                            $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                                  'APP_NAME'      => config('app.project.name'),
                                                                  //'MESSAGE'       => $msg,
                                                                  'SELLER_NAME'   => $set_username,
                                                                  'PLAN_NAME'     => $plan_name,
                                                                  'AMOUNT'        => $set_amount  
                                                                 // 'URL'           => $user_membership_url
                                                                 ];

                                            $arr_mail_data2['email_template_id'] = '62';
                                            $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data2['arr_built_subject'] = '';
                                            $arr_mail_data2['user']              = Sentinel::findById($admin_id);

                                            $this->EmailService->send_mail_section($arr_mail_data2);




                                            //send email to user
                                           /* $msg2     = 'You have successfully selected <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';*/

                                            $user_membership_url = url('/').'/seller/membership_detail';

                                            //$subject2 = 'Membership Purchase';
                                            $arr_built_content = ['USER_NAME'     => $set_username,
                                                                  'APP_NAME'      => config('app.project.name'),
                                                                  //'MESSAGE'       => $msg2,
                                                                  'PLAN_NAME'     => $plan_name,
                                                                  'AMOUNT'        => $set_amount,
                                                                  'URL'           => $user_membership_url
                                                                 ];

                                            $arr_mail_data2['email_template_id'] = '64';
                                            $arr_mail_data2['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data2['arr_built_subject'] = '';
                                            $arr_mail_data2['user']              = $user_details_arr;

                                            $this->EmailService->send_mail_section($arr_mail_data2); 


                                        /**********end of send noti and email*********/


                                        }//if subscripitondata                         

 
                                    }//try 
                                   catch(\Stripe\Error\Card $e)
                                   {
                                        
                                        $arr_response['status'] = "ERROR";
                                        $arr_response['cardmsg'] = $e->getMessage();
                                        return $arr_response;
                                    }
                                    catch (Exception $e)
                                    {
                                        $arr_response['status'] = "failure";
                                        $arr_response['msg'] = $e->getMessage();
                                        return $arr_response;
                                    
                                    }//catch





                                }//if card details and token and planid
                                else
                                {
                                     $response['status'] = "ERROR";
                                     $response['msg'] = 'Card details not avaliable or something went wrong with token or plan id.'; 
                                }//else of card details and token


                            }//else of new subscription creation

                                           


                                    $response['status'] = "SUCCESS";
                                    $response['msg'] = "Membership plan activated successfully.";
                                  //  $response['transaction_id'] = $result['payment']['id'];
                                 //   $response['result'] = $result;
                            

                          }//else of membership type 2  


                        }//if membership id ,amount,type
                        else
                        {
                             $response['status'] = "ERROR";
                             $response['msg'] = 'Something went wrong.';
                        }    

                 }
                else{
                    $response['status'] = "ERROR";
                    $response['msg'] = 'Payment not processing';
                }
                return $response;


  
    }// end of membership selection function
   
    //function check card details exists
    public function checkcarddetail_exists($userid)
    {
        $carddataarr =[];
        if($userid)
        {
            $carddata = $this->UserModel
                                    ->where('id',$userid)
                                    ->where('card_brand','!=',null)
                                    ->where('card_last_four','!=',null)
                                    ->where('stripe_id','!=',null)
                                    ->first();
            if(isset($carddata) && !empty($carddata))
            {
                $carddataarr = $carddata->toArray();
            }                        

            if(isset($carddataarr) && !empty($carddataarr))
            {
                return '1';
            }else{
                return '0';
            }   

        }else{
           return '0'; 
        }
    }//end of checkcarddetail exists


    //check stripe product exists
    public function check_stripe_product_exists($membership_id)
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

       // $stripe_secret_key ='app.project.stripe_secret_key';



         $product_plan_arr = [];

         $get_membershipname = $this->MembershipModel->where('id',$membership_id)->where('membership_type','2')->first();
        if(isset($get_membershipname) && !empty($get_membershipname))
        {
            $get_membershipname = $get_membershipname->toArray();
            $membership_name = $get_membershipname['name'];
            $memberships_id = $get_membershipname['id'];
            $membership_price = $get_membershipname['price'];



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
                                'amount'  => $membership_price*100,
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

                                        $update_membership = $this->MembershipModel->where('id',$membership_id)->update(['plan_id'=>$stripe_plan_id]);

                                        $stripe_plan_id = $stripe_plan_id;

                                   }

                           }

                 }//if stripe productid   

             if($stripe_product_id && $stripe_plan_id){

             $product_plan_arr['stripe_product_id'] = $stripe_product_id;    
             $product_plan_arr['stripe_plan_id'] = $stripe_plan_id;    
             return $product_plan_arr;

             }




      }//if membership data 
    }//end ofcheck stripe product exists



    //function for cancel subscription
    public function membership_cancel(Request $request)
    {
        $response = [];
        $userid = $request->userid;
        $cancel_reason = $request->cancel_reason;
        if($userid)
        {
            $user_details = false;
            $user_details = Sentinel::getUser();       
            $user_details_arr = $user_details->toArray();
            $loginuserid = $user_details_arr['id'];


                   
             $get_membershipdata = $this->UserSubscriptionsModel
                            ->where('user_id',$loginuserid)
                            ->where('membership_status','1')
                            ->first();
              if(isset($get_membershipdata) && (!empty($get_membershipdata)))
               {
                    $get_membershipdata = $get_membershipdata->toArray();

               }



            //check if user is subscribed or having free memership
            if ($user_details->subscribed('main') || $get_membershipdata['membership']=="1" ) 
            { 

                //if membership type is 2
                if($get_membershipdata['membership']=="2")
                {

                      $subscriptionobj = $user_details->asStripeCustomer()["subscriptions"] ;
                      // dd($subscriptionobj->jsonSerialize());
                 
                      $current_period_startdate ='';
                      $current_period_enddate ='';
                       
                     if($subscriptionobj){

                       $current_period_startdate = Carbon::createFromTimestamp(
                            $subscriptionobj['data'][0]['current_period_start']);


                       $current_period_enddate = Carbon::createFromTimestamp(
                                $subscriptionobj['data'][0]['current_period_end']);

                     }  
                      //cancel immediately the subscription
                      $user_details->subscription('main')->cancelNow();

                      //cancel the subscription
                      // $user_details->subscription('main')->cancel();

                }//if membership type is 2
                elseif($get_membershipdata['membership']=="1")
                {
                 // $current_period_enddate = date("Y-m-d H:i:s");
                  $current_period_enddate = '';

                }


                $update_subscriptiondata = [];
                $update_subscriptiondata['membership_status']=0;
                $update_subscriptiondata['is_cancel']=1;
                $update_subscriptiondata['current_period_enddate']=$current_period_enddate;
                $update_subscriptiondata['cancel_reason']=$cancel_reason;
                //update user subscription table data cancel status
                $update = $this->UserSubscriptionsModel
                        ->where('id',$get_membershipdata['id'])
                        ->where('user_id',$loginuserid)
                        ->update($update_subscriptiondata);

                 if($update)
                 {
                    /****if cancel memebrship then set post of this user to inactive***/

                        $get_forum_posts =  $this->ForumPostsModel->where('user_id',$loginuserid)->get();
                        if(isset($get_forum_posts) && (!empty($get_forum_posts)))
                        {
                           $get_forum_posts = $get_forum_posts->toArray(); 

                           foreach($get_forum_posts as $posts)
                           {
                              $postid = $posts['id'];
                              $is_active = $posts['is_active'];
                              $update_post_status = [];
                              $update_post_status['is_active'] =0;
                              $this->ForumPostsModel->where('user_id',$loginuserid)->update($update_post_status);
                           }
                        }


                    /****end of post*inactive***********/
                    
                    /**if cancel then set product status to inactive***/
                      $get_products = $this->ProductModel->where('user_id',$loginuserid)->get();
                      if(isset($get_products) && (!empty($get_products)))
                      {
                           $get_products = $get_products->toArray(); 
                           foreach($get_products as $products)
                           {
                                $productid = $products['id'];
                                $this->ProductModel->where('id',$productid)->update(['is_active'=>0]);
                           }

                       }//if   

                    /************set proudct to deactive*************/
                     /********update product limit*********/
                        
                        $pcountarr = [];
                        $pcountarr['product_count']=0;
                        $pcountarr['product_limit']=0;
                        
                        $this->UserModel->where('id',$loginuserid)->update($pcountarr);

                    /************************************/





                    $admin_role = Sentinel::findRoleBySlug('admin');  

                    $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    $admin_id   = 0;
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }


                     if($user_details_arr['first_name']=="" || $user_details_arr['last_name'])
                    {  
                        $set_username = $user_details_arr['email']; 
                       
                    }else{
                        $set_username = $user_details_arr['first_name'].' '.$user_details_arr['last_name'];
                    }

                    $plan_name ='';

                    $get_panname  = $this->MembershipModel->where('id',$get_membershipdata['membership_id'])->first();
                    
                    if(!empty($get_panname)){
                        $get_panname = $get_panname->toArray();
                        $plan_name = $get_panname['name'];
                    }

                    $set_amount =  '$'.number_format($get_membershipdata['membership_amount']);

                     /******send noti and email*************/
                           // send noti to admin
                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $loginuserid;
                        $arr_event['to_user_id']   = $admin_id;
                        $arr_event['type']         = 'admin';
                        $arr_event['description']  = $set_username.'  canceled <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';
                        $arr_event['title']        = 'Membership Cancelled';
                        
                        $this->GeneralService->save_notification($arr_event);

                        // send noti to user
                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $admin_id;
                        $arr_event['to_user_id']   = $loginuserid;
                        $arr_event['type']         = 'Seller';

                       
                         $arr_event['description']  = 'You have successfully cancelled <b> '.$plan_name.' </b> membership plan of '.$set_amount.' amount.';
                      
                       
                        $arr_event['title']        = 'Membership Cancelled';
                        
                        $this->GeneralService->save_notification($arr_event);


                     //send email to admin
                       /* $msg     = $set_username.'  cancelled <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';*/

                        $user_membership_url = url('/').'/seller/membership_detail';

                        //$subject = 'Membership Cancelled';
                        $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                              'APP_NAME'      => config('app.project.name'),
                                              //'MESSAGE'       => $msg,
                                              'SELLER_NAME'   => $set_username,
                                              'PLAN_NAME'     => $plan_name,
                                              'AMOUNT'        => $set_amount 
                                             // 'URL'           => $user_membership_url
                                             ];

                        $arr_mail_data2['email_template_id'] = '66';
                        $arr_mail_data2['arr_built_content'] = $arr_built_content;
                        $arr_mail_data2['arr_built_subject'] = '';
                        $arr_mail_data2['user']              = Sentinel::findById($admin_id);

                        $this->EmailService->send_mail_section($arr_mail_data2);




                        //send email to user
                        $msg2     = 'You have successfully cancelled <b> '.$plan_name.' </b> membership plan of '.$set_amount.' .';

                        $user_membership_url = url('/').'/seller/membership_detail';

                        //$subject2 = 'Membership Cancelled';
                        $arr_built_content = ['USER_NAME'     => $set_username,
                                              'APP_NAME'      => config('app.project.name'),
                                              //'MESSAGE'       => $msg2,
                                              'PLAN_NAME'     => $plan_name,
                                              'AMOUNT'        => $set_amount, 
                                              'URL'           => $user_membership_url
                                             ];

                        $arr_mail_data2['email_template_id'] = '67';
                        $arr_mail_data2['arr_built_content'] = $arr_built_content;
                        $arr_mail_data2['arr_built_subject'] = '';
                        $arr_mail_data2['user']              = $user_details_arr;

                        $this->EmailService->send_mail_section($arr_mail_data2); 


                 /**********end of send noti and email*********/

                     $response['status'] = "SUCCESS";
                     $response['msg'] = "Membership plan cancelled successfully.";

                 }//if update status       


            }//if user subscribed
            else
            {               
              $response['status'] = "ERROR";
              $response['msg'] = "User subscription plan is not active";         
            }    


        }//ifuserid
        else
        {
             $response['status'] = "ERROR";
             $response['msg'] = "Something went wrong.";

        }//else of user id

        return $response;

    }//end of cancel subscripiton function


    public function wholesale()
    {
        $seller_arr = [];
        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();
        $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();

        if($seller_obj)
        {
            $seller_arr = $seller_obj->toArray();
            $user_details_arr['user_details']     = $seller_arr;
        }



        $user_subscribed = 0;
        if ($user_details->subscribed('main')) {
            $user_subscribed = 1;

        }else{
          $user_subscribed =0;
        }

         $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$user_details->id)->where('membership_status','1')->first();
         if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
         {
          $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
         }    

         if(isset($user_subscriptiontabledata) && $user_subscriptiontabledata['membership']=="2")
         {   

            $this->arr_view_data['user_details_arr']  = $user_details_arr;
            $this->arr_view_data['page_title']   = 'Wholesale Access';
            return view($this->module_view_folder.'.wholesale',$this->arr_view_data); 
         }//if paid
         else
         {
            return redirect('/seller/profile');
         }
        
    }//end of wholesale function

    // function for update card

    public function updatecard()
    {   
        

        $seller_arr = [];
        $subscription_arr = [];
        $get_cancelmembershipdata=[];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

        if(isset($user_details_arr) && !empty($user_details_arr))
        {

            //get canceled memebrshipdata
            /****************************************/

               $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                        ->where('user_id',$user_details_arr['id'])
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


            $get_membershipdata = $this->UserSubscriptionsModel
                        ->where('user_id',$user_details_arr['id'])
                        ->where('membership_status','1')
                        ->first();

            if(isset($get_membershipdata) && (!empty($get_membershipdata)))
            {
               // return redirect('/seller/membership_detail');
            }
            else
            {

                    $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();
                    
                  
                    if($seller_obj)
                    {
                        $seller_arr = $seller_obj->toArray();
                        $user_details_arr['user_details']            = $seller_arr;
                    }
              
           }//else 

           if(isset($get_membershipdata) && (!empty($get_membershipdata)))
           {
                $get_membershipdata = $get_membershipdata->toArray();
           } 

            $arr_membership = [];
            $arr_membership = $this->MembershipModel
                                ->select('*')
                                ->where('is_active','1')
                                ->orderBy('membership_type')
                                ->get()
                                ->toArray();


            $this->arr_view_data['arr_membership']  = isset($arr_membership) ? $arr_membership : [];   
            $this->arr_view_data['user_details_arr']   = $user_details_arr;
            $this->arr_view_data['page_title']   = 'Membership Plan';
            $this->arr_view_data['get_membershipdata'] = isset($get_membershipdata)?$get_membershipdata:[];


            $user_subscried = 0;
            if ($user_details->subscribed('main')) {
                $user_subscried = 1;

            }else{
              $user_subscried =0;
            }
            $this->arr_view_data['user_subscribed'] = $user_subscried;



        }//if user detail data

        return view($this->module_view_folder.'.updatecard',$this->arr_view_data);

    }//end of function updatecard

    // function process update card
    public function membership_updatecard(Request $request)
    {   
        $response = [];
        $user_details = false;
        $user_details = Sentinel::getUser();       
        $user_details_arr = $user_details->toArray();
        $loginuserid = $user_details_arr['id'];

        $user_subscribed = 0;
        if ($user_details->subscribed('main')) {
            $user_subscribed = 1;

        }else{
          $user_subscribed =0;
        }     

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
         $form_data = $request->all();

         if($form_data && isset($user_details))
         {
               $customer_stripeid = $user_details->stripe_id;


               $get_membershipdata = $this->UserSubscriptionsModel->where('user_id',$loginuserid)->where('membership_status','1')->first();
              if(isset($get_membershipdata) && (!empty($get_membershipdata)))
               {
                    $get_membershipdata = $get_membershipdata->toArray();

               }


            $stripeToken = isset($form_data['stripeToken'])?$form_data['stripeToken']:'';
            $card_number = isset($form_data['card_number'])?$form_data['card_number']:'';
            $card_exp_month = isset($form_data['card_exp_month'])?$form_data['card_exp_month']:'';
            $card_exp_year = isset($form_data['card_exp_year'])?$form_data['card_exp_year']:'';
            $card_cvc = isset($form_data['card_cvc'])?$form_data['card_cvc']:'';

            if(isset($customer_stripeid) && !empty($customer_stripeid))
            {
                  try
                 {
                    \Stripe\Stripe::setApiKey($stripe_secret_key);
                    $customerdata = \Stripe\Customer::retrieve($customer_stripeid);
                    $customerdata = $customerdata->jsonSerialize(); 
                    if(isset($customerdata))
                    {
                        $user = UserModel::find($user_details->id);
                        $user->updateCard($stripeToken);

                        $admin_role = Sentinel::findRoleBySlug('admin');  

                        $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                        $admin_id   = 0;
                        if($admin_obj)
                        {
                            $admin_id = $admin_obj->user_id;            
                        }

                        $set_username='';

                         if($user_details_arr['first_name']=="" || $user_details_arr['last_name'])
                        {  
                            $set_username = $user_details_arr['email']; 
                           
                        }else{
                            $set_username = $user_details_arr['first_name'].' '.$user_details_arr['last_name'];
                        }

                         // send noti to user
                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $admin_id;
                        $arr_event['to_user_id']   = $user_details->id;
                        $arr_event['type']         = 'Seller';
                        $arr_event['description']  = 'You have successfully updated card details';                                             
                        $arr_event['title']        = 'Card Updated';
                        
                        $this->GeneralService->save_notification($arr_event);


                        // send noti to admin
                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $user_details->id;
                        $arr_event['to_user_id']   = $admin_id;
                        $arr_event['type']         = 'admin';
                        $arr_event['description']  = $set_username.'  updated card details.';
                        $arr_event['title']        = 'Card Updated';
                        
                        $this->GeneralService->save_notification($arr_event);



                          //send email to user
                        $msg2     = ' You have successfully updated card details .';

                        $user_membership_url = url('/').'/seller/membership';

                        //$subject2 = 'Card Updated';
                        $arr_built_content = ['USER_NAME'     => $set_username,
                                              'APP_NAME'      => config('app.project.name'),
                                              //'MESSAGE'       => $msg2,
                                              'URL'           => $user_membership_url
                                             ];

                        $arr_mail_data2['email_template_id'] = '69';
                        $arr_mail_data2['arr_built_content'] = $arr_built_content;
                        $arr_mail_data2['arr_built_subject'] = '';
                        $arr_mail_data2['user']              = $user_details_arr;

                        $this->EmailService->send_mail_section($arr_mail_data2);


                          //send email to admin
                       // $msg     = $set_username.'  updated card details.';

                        $user_membership_url = url('/').'/seller/membership';

                        //$subject = 'Card Updated';
                        $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                              'APP_NAME'      => config('app.project.name'),
                                              'SELLER_NAME'   => $set_username,
                                              //'MESSAGE'       => $msg,
                                              'URL'           => $user_membership_url
                                             ];

                        $arr_mail_data['email_template_id'] = '68';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($admin_id);
                        $this->EmailService->send_mail_section($arr_mail_data);

                        
                        $response['status'] = "SUCCESS";
                        $response['msg'] = "Card updated successfully.";
                        return $response;


                            
                    }//if customerdata
                 }
                 catch(\Stripe\Error\Card $e)
                 {
                        
                        $arr_response['status'] = "ERROR";
                       // $arr_response['cardmsg'] = $e->getMessage();
                        $arr_response['cardmsg'] ="Something went wrong, please contact to your bank";
                        return $arr_response;
                 } 
                 catch(Exception $e)
                 { 
                   
                    $response['status'] = "failure";
                    $response['cardmsg'] = $e->getMessage();
                    return $response;
                 }   

            }//customer stripe id
            else{
                    $response['status'] = "ERROR";
                    $response['cardmsg'] = "Customer stripe card detail not exists";
                    return $response;
            }//else

         }//if form data
         return $response;
    }//end of updatecard function


}//end of class
