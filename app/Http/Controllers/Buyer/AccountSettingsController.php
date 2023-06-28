<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\BuyerModel;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\EmailTemplateModel;


use Validator;
use Flash;
use Sentinel;
use Hash;
use Session;
  
class AccountSettingsController extends Controller
{


    public function __construct(
                                
                                UserModel $user,
                                CountriesModel $CountriesModel,
                                StatesModel $StatesModel,
                                BuyerModel $BuyerModel,
                                ActivityLogsModel $activity_logs,
                                GeneralService $GeneralService,
                                EmailService $EmailService,
                                EmailTemplateModel $EmailTemplateModel
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;
        $this->ActivityLogsModel  = $activity_logs;
        $this->CountriesModel     = $CountriesModel;
        $this->StatesModel        = $StatesModel;
        $this->BuyerModel         = $BuyerModel;
        $this->GeneralService     = $GeneralService;
        $this->EmailService       = $EmailService;
        $this->EmailTemplateModel = $EmailTemplateModel;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        $this->profile_img_public_path = url('/').config('app.project.img_path.user_profile_image');
        $this->profile_img_base_path   = base_path().config('app.project.img_path.user_profile_image');

        $this->module_title       = "Account Settings";
        $this->module_view_folder = "buyer/profile";
        $this->module_age_verification = "buyer/age-verification";

        $this->id_proof_public_path = url('/').config('app.project.img_path.id_proof');
        $this->id_proof_base_path   = base_path().config('app.project.img_path.id_proof');
        
        $this->module_icon        = "fa-cogs";
    }

 
    public function index()
    {
        $buyer_arr = $seller_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();


        $buyer_obj = $this->BuyerModel->where('user_id',$user_details->id)->first();
        if($buyer_obj)
        {
            $buyer_arr = $buyer_obj->toArray();                 
            $user_details_arr['user_details']  = $buyer_arr; 
        }
        //commented below to show confirm password modal at 21 jan
        // if( ($user_details_arr['user_details']['approve_status'] == 1) && ($user_details_arr['approve_status']==1) ){

        //     return redirect(url('/').'/buyer/profile');

        // }else{

        $countries_obj = $this->CountriesModel->where('is_active',1)->get();
        if ($countries_obj) {
            $countries_arr = $countries_obj->toArray();

            $this->arr_view_data['countries_arr']         = $countries_arr;
        }


        //hide where country id condition 

        $states_obj = $this->StatesModel
                          // ->where('country_id', $user_details_arr['country'])
                           ->where('is_active',1)
                           ->get();
        if ($states_obj) {
            $states_arr = $states_obj->toArray();           
            $this->arr_view_data['states_arr']         = $states_arr;
        }
        $billing_states_obj = $this->StatesModel
                             // ->where('country_id', $user_details_arr['billing_country'])
                              ->where('is_active',1)
                              ->get();
        if ($billing_states_obj) 
        {
            $billing_states_arr = $billing_states_obj->toArray();            
            $this->arr_view_data['billing_states_arr']         = $billing_states_arr;
        }
       

        $this->arr_view_data['id_proof_path']        = $this->id_proof_public_path;
        $this->arr_view_data['profile_img_path']     = $this->profile_img_public_path;
        $this->arr_view_data['user_details_arr']     = $user_details_arr;
        $this->arr_view_data['page_title']           = 'Profile';
        
        return view($this->module_view_folder.'.my-profile',$this->arr_view_data);
       //}
    }
    /*-------------------Age Verification START---------------------------------*/
        public function age_verification()
        {
          
            Session::forget('buyer_age_verification_url');
            $buyer_arr = $seller_arr = [];

            $user_details = false;
            $user_details = Sentinel::getUser();        

            $user_details_arr = $user_details->toArray();

            $buyer_obj = $this->BuyerModel->with('age_restriction_details')->where('user_id',$user_details->id)->first();
            if($buyer_obj)
            {
                $buyer_arr = $buyer_obj->toArray();                 
                $user_details_arr['user_details']  = $buyer_arr;
            }

            $this->arr_view_data['id_proof_path']        = $this->id_proof_public_path;
            $this->arr_view_data['user_details_arr']     = $user_details_arr;
            $this->arr_view_data['page_title']           = 'Age verification';

            return view($this->module_age_verification.'.index',$this->arr_view_data);
        }
    /*-------------------Age Verification END---------------------------------*/

    public function update(Request $request)
    {

        $arr_rules = array();

        $current_timestamp = "";
       
        $obj_data  = Sentinel::getUser();

        $form_data = $request->all();

        $first_name = $obj_data->first_name;
        $last_name  = $obj_data->last_name;


       // $mobileno  = $form_data['mobile_no'];
        $firstname  = $form_data['first_name'];
        $lastname  = $form_data['last_name'];

             $arr_rules =  [

                'first_name'=>'required|min:3',
                'last_name'=>'required',
                'email'=>'required|email',
               // 'mobile_no'=>'required|numeric',
                'address'=>'required',
                'state'=>'required',
                'country'=>'required',
                'zipcode'=>'required',
                'city'=>'required',
                'billing_street_address'=>'required',
                'billing_state'=>'required',
                'billing_country'=>'required',
                'billing_zipcode'=>'required',
                'billing_city'=>'required',
                        ]; 

                  

        if(Validator::make($form_data,$arr_rules)->fails())
        {
            $response = [
                          'status' =>'error',
                          'msg'    =>'Please enter all mandatory fields'
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
                 $response['msg'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }

          }//if country obj

           $states_obj = $this->StatesModel->where('id', $request->input('state'))->first();
           if ($states_obj) {
            $states_arr = $states_obj->toArray();
             if( $states_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['msg'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }
          }//if state obj

           $countries_obj = $this->CountriesModel->where('id',$request->input('billing_country'))->first();
          if ($countries_obj) {
              $countries_arr = $countries_obj->toArray();
              if( $countries_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['msg'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }

          }//if country obj

           $states_obj = $this->StatesModel->where('id', $request->input('billing_state'))->first();
           if ($states_obj) {
            $states_arr = $states_obj->toArray();
             if( $states_arr['is_active']=="0")
              {
                 $response['status'] = 'error';
                 $response['msg'] = 'We  do not support your location at the moment';
                 return response()->json($response); 
              }
          }//if state obj
          
        /*************chk country**state*************************/



         if(!isset($firstname) || (isset($firstname) && $firstname == '') || (!preg_match("/^[a-zA-Z]+$/",$firstname)))
        {
           $arr_response['status'] = 'ERROR';
           $arr_response['msg']    = 'Provided first name should not be blank or invalid.';
            return response()->json($arr_response); 
        }  
        
        if(!isset($lastname) || (isset($lastname) && $lastname == '') || (!preg_match("/^[a-zA-Z]+$/",$lastname)))
        {
           $arr_response['status'] = 'ERROR';
           $arr_response['msg']    = 'Provided last name should not be blank or invalid.';
            return response()->json($arr_response); 
        }  

        /* if(!isset($mobileno) || (isset($mobileno) && $mobileno == '') || (!is_numeric($mobileno)) || (strlen($mobileno)<10) || (strlen($mobileno)>10) )
        {
           $arr_response['status'] = 'ERROR';
           $arr_response['msg']    = 'Provided mobile number should not be blank or invalid.';
            return response()->json($arr_response); 
        } */

        
        if($this->UserModel->where('email',$request->input('email'))
                           ->where('id','!=',$obj_data->id)
                           ->count()==1)
        {
           // Flash::error('This Email id already present in our system, please try another one');
            //return redirect()->back();

            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = 'This email id already present in our system, please try another one';
            return response()->json($arr_response);     

 
        }

        $file_name = "default.jpg";

     
        $arr_data['first_name']     = ucfirst($request->input('first_name'));
        $arr_data['last_name']      = ucfirst($request->input('last_name'));
        $arr_data['email']          = $request->input('email');
        $arr_data['phone']          = $request->input('mobile_no');
        $arr_data['street_address'] = $request->input('address');
        $arr_data['state']        = $request->input('state');
        $arr_data['country']        = $request->input('country');
        $arr_data['zipcode']        = $request->input('zipcode');
        $arr_data['city']           = $request->input('city');
        $arr_data['billing_street_address'] = $request->input('billing_street_address');
        $arr_data['billing_state']        = $request->input('billing_state');
        $arr_data['billing_country']        = $request->input('billing_country');
        $arr_data['billing_zipcode']        = $request->input('billing_zipcode');
        $arr_data['billing_city']        = $request->input('billing_city');
        $arr_data['date_of_birth']        = $request->input('date_of_birth');

        

        $arr_data['profile_image']  = $file_name;
   
 

       /* $update_id_proof            = $this->BuyerModel->where('user_id',$obj_data->id)->update(array('id_proof'=>$id_proof)); */ 
       $age_address = $request->input('age_address');
       $age_category = $request->input('age_category');

    

       $obj_data = Sentinel::update($obj_data, $arr_data);

    
        if($obj_data)
        {
                     


               $user_details = false;
               $user_details = Sentinel::getUser();   
               
               // if($user_details['first_name']!='' && $user_details['last_name']!='' && $user_details['email']!='' && $user_details['country']!='' &&  $user_details['phone']!='' &&  $user_details['street_address']!=''  && $user_details['state']!='' && $user_details['zipcode']!=''   && $user_details['city']!=''
               //  && $user_details['billing_street_address']!='' && $user_details['billing_state']!='' && $user_details['billing_country']!='' && $user_details['billing_zipcode']!='' 
               //  && $user_details['billing_city']!=''
               //  && ($user_details['approve_status'] == '0' || $user_details['approve_status'] == '2') )
               // {    

               if($user_details['first_name']!='' && $user_details['last_name']!='' && $user_details['email']!='' && $user_details['country']!=''  &&  $user_details['street_address']!=''  && $user_details['state']!='' && $user_details['zipcode']!=''   && $user_details['city']!=''
                && $user_details['billing_street_address']!='' && $user_details['billing_state']!='' && $user_details['billing_country']!='' && $user_details['billing_zipcode']!='' 
                && $user_details['billing_city']!=''
                && ($user_details['approve_status'] == '0' || $user_details['approve_status'] == '2') )
               {    




                  $update_status = $this->UserModel
                                        ->where('id',$user_details->id)
                                        ->update(['approve_status'=>'1']);

                    $url   = url(config('app.project.admin_panel_slug')."/buyers");    

                    $from_user_id = 0;
                    $admin_id     = 0;
                    $user_name    = "";

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        if($user_details->first_name=="" || $user_details->last_name=="")
                        {
                         $user_name    = $user_details->email;

                        }else{
                         $user_name    = $user_details->first_name.' '.$user_details->last_name;
                        }
                    }

                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    } 

                                        
                        
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('Buyer <a target="_blank" href="'.$url.'"><b>'.$user_name.'</b></a> has uploaded the profile .');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Profile Updated';
                    $this->GeneralService->save_notification($arr_event);

                /***************Send Profile Verfication Notification Mail to Buyer (START)**************************/
                    $to_user = Sentinel::findById($admin_id);

                    $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                    $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

                  //  $msg     = html_entity_decode('Buyer <b>'.$user_name.'</b> has uploaded the profile.');

                   // $subject = 'Profile Updated';
                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                        //'MESSAGE'       => $content,
                        'URL'           => $url,
                        'BUYER_NAME'     => $user_name,
                    ];

                    $arr_mail_data['email_template_id'] = '53';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);
                    $this->EmailService->send_mail_section($arr_mail_data);

                /*********************Send Profile Verfication  Notification Mail to Buyer (END)*****************/
               }

             $response = [
                          'status' =>'success',
                          'msg'    =>ucfirst(strtolower($this->module_title)).' updated successfully'
                        ];

            return response()->json($response);     
        }
        else
        {
            $response = [
                          'status' =>'error',
                          'msg'    =>'Problem occurred, while updating'.str_singular($this->module_title)
                        ];

            return response()->json($response);   
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

    //function for buyer update age proof 
    public function updateage(Request $request)
    {
       
        $arr_rules = array();
       
        $obj_data  = Sentinel::getUser();
        $form_data = $request->all();
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
                $response['msg']     = 'Please select valid front of id proof, only jpg,png and jpeg file are allowed';

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
                $response['msg']     = 'Please select valid back of id proof, only jpg,png and jpeg file are allowed';
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
                $response['msg']     = 'Please select valid selfie id proof, only jpg,png and jpeg file are allowed';
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
             
                   $request->file('address_proof')->move($this->id_proof_base_path,$address_proof);

                }
                else
                {

                     $request->file('address_proof')->move($this->id_proof_base_path, $address_proof);
                      $address_proof  = $address_proof;    

                      $unlink_old_addrproof_path    = $this->id_proof_base_path.'/'.$request->input('old_address_proof');
                      if(file_exists($unlink_old_addrproof_path))
                      {
                          @unlink($unlink_old_addrproof_path);  
                      }
                }//else of image

            }
             else
            {
                $response['status']  = 'ERROR';
                $response['msg']     = 'Please select valid address proof, only jpg,png,jpeg,pdf,doc,docx files are allowed';
                return response()->json($response);
            } 
            
        }
        else
        {
            $address_proof = $request->input('old_address_proof');            
        }
        /***********************end of address proof***********************/


 

       $age_address = $request->input('age_address');
       $age_category = $request->input('age_category');


      /* if($form_data['age_address']=="")
       {
            $response['status']  = 'ERROR';
            $response['msg']     = 'Please enter age address';
            return response()->json($response);
       }

        if($address_proof=="")
        {
             $response['status']  = 'ERROR';
             $response['msg'] = 'Please select address proof';
             return response()->json($response);
        } */



       $udpate_arr    = array('front_image'=>$front_image,
                            'back_image'=>$back_image,
                            'selfie_image'=>$selfie_image,
                             'address_proof'=>$address_proof,
                            'approve_status'=>'3'
                          );
       if($age_category)
       {
            $udpate_arr['age_category'] = $age_category;
       }
        //if($age_address)
       //{
            $udpate_arr['age_address'] = isset($age_address)?$age_address:'';
       //}
      
       $update_id_proof  = $this->BuyerModel->where('user_id',$obj_data->id)->update($udpate_arr);  


       if($update_id_proof)
       {
            $current_timestamp    = date('Y-m-d H:i:s');

            if(isset($current_timestamp) && !empty($current_timestamp))
            { 
              $update_sorting_order = $this->BuyerModel->where('user_id',$obj_data->id)->update(array('sorting_order_by'=>$current_timestamp));  
            } 
            //send notification to admin for age proof uploaded

                $url  = url(config('app.project.admin_panel_slug') . "/buyers");

                /****************send noti to admin for age verification****************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    if($user_details->first_name=="" || $user_details->last_name=="")
                    {
                      $user_name    = $user_details->email;
                    }else{
                      $user_name    = $user_details->first_name.' '.$user_details->last_name;
                    }
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }                 
                    
               /*****************send Age Verification noti to admin**************************/
                $arr_event                 = [];
                $arr_event['from_user_id'] = $from_user_id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['description']  = html_entity_decode('Buyer <a target="_blank" href="'.$url.'"><b>'.$user_name.'</b></a> has uploaded the age verification proof.');
                $arr_event['type']         = '';
                $arr_event['title']        = 'Age verification Request';
                $this->GeneralService->save_notification($arr_event);
               
              /******************end of send Age Verification noti to admin**************************/

            /***************Send Age Verfication Notification Mail to Buyer (START)**************************/
            $to_user = Sentinel::findById($admin_id);

            $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
            $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

           // $msg     = html_entity_decode('Buyer <b>'.$user_name.'</b> has uploaded the age proof for verification.');
           
           // $subject = 'Age Verification Request';

            $arr_built_content = [
                'USER_NAME'     => config('app.project.admin_name'),
                'APP_NAME'      => config('app.project.name'),
               // 'MESSAGE'       => $msg,
                'URL'           => $url,
                'BUYER_NAME'    => $user_name
            ];

            $arr_mail_data['email_template_id'] = '57';
            $arr_mail_data['arr_built_content'] = $arr_built_content;
            $arr_mail_data['arr_built_subject'] = '';
            $arr_mail_data['user']              = Sentinel::findById($admin_id);

            $this->EmailService->send_mail_section($arr_mail_data);

            /*********************Send Age Verfication  Notification Mail to Buyer (END)*****************/
       }

       if($update_id_proof)
        {
             $response = [
                          'status' =>'SUCCESS',
                          'msg'    =>'Age verification details updated successfully'
                        ];

            return response()->json($response);     
        }
        else
        {
            $response = [
                          'status' =>'ERROR',
                          'msg'    =>'Problem occurred, while updating'.str_singular($this->module_title)
                        ];

            return response()->json($response);   
        } 
      
    }








    public function view_profile()
    {
        $buyer_arr = $seller_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

       

        if($user_details->inRole('buyer'))
        {   
            $buyer_obj = $this->BuyerModel->with('user_details')->where('user_id',$user_details->id)->first();
            if($buyer_obj)
            {
                $buyer_arr    = $buyer_obj->toArray();

                $user_details_arr['user_details']  = $buyer_arr;
            }
            
            $get_countries_details = $this->CountriesModel->where('id',$user_details->country)->first();
            if($get_countries_details)
            {
                $get_countries_arr    = $get_countries_details->toArray();
                // dd($get_countries_arr);
                $user_details_arr['get_countries_arr']  = $get_countries_arr;
            }
            
            $get_states_details = $this->StatesModel->where('id',$user_details->state)->first();
            if($get_states_details)
            {
                $get_states_arr    = $get_states_details->toArray();
                // dd($get_states_arr);
                $user_details_arr['get_states_arr']  = $get_states_arr;
            }

            
            $get_billing_countries_details = $this->CountriesModel->where('id',$user_details->billing_country)->first();
            if($get_billing_countries_details)
            {
                $get_billing_countries_arr    = $get_billing_countries_details->toArray();
                // dd($get_countries_arr);
                $user_details_arr['get_billing_countries_arr']  = $get_billing_countries_arr;
            }
            
            $get_billing_states_details = $this->StatesModel->where('id',$user_details->billing_state)->first();
            if($get_billing_states_details)
            {
                $get_billing_states_arr    = $get_billing_states_details->toArray();
                // dd($get_states_arr);
                $user_details_arr['get_billing_states_arr']  = $get_billing_states_arr;
            }   
        }

       
        $this->arr_view_data['id_proof_path']        = $this->id_proof_public_path;
        $this->arr_view_data['profile_img_path']     = $this->profile_img_public_path;
        $this->arr_view_data['user_details_arr']     = $user_details_arr;
        $this->arr_view_data['page_title']           = 'Profile';
        
        return view($this->module_view_folder.'.view-profile',$this->arr_view_data);
    }//end of function

      public function process_modal_ofbuyer(Request $request)
    {
          $form_data = $request->all();
          $arr_response =[];

          $obj_data  = Sentinel::getUser();

            $arr_rules = [
                      
                        'date_of_birth'      => 'required',
                        'phone'      => 'required|min:10|max:12'
                    ];

            if(Validator::make($form_data,$arr_rules)->fails())
            {   
                $msg = Validator::make($form_data,$arr_rules)->errors()->first();

                $arr_response = [
                               'status' =>'ERROR',
                               'msg'    => $msg
                            ];
                return response()->json($arr_response);     
            }        

            $date_of_birth  = isset($form_data['date_of_birth'])?$form_data['date_of_birth']:'';
            $phone    = isset($form_data['phone'])?$form_data['phone']:'';

            if(!isset($date_of_birth) || $date_of_birth == '')
          {
             $arr_response['status'] = 'ERROR';
             $arr_response['msg']    = 'Please enter date of birth.';
              return response()->json($arr_response); 
          }  

            if(!isset($phone) || $phone == '')
          {
             $arr_response['status'] = 'ERROR';
             $arr_response['msg']    = 'Please enter phone number.';
              return response()->json($arr_response); 
          }  


        $arr_data['date_of_birth']= $request->input('date_of_birth');
        $arr_data['phone']        = $request->input('phone');

        $obj_data = Sentinel::update($obj_data, $arr_data);

        if($obj_data)
        {
          $arr_response = [
                          'status' =>'success',
                          'msg'    =>ucfirst(strtolower($this->module_title)).' updated successfully'
                        ];

            return response()->json($arr_response);     
        }
        else{
             $arr_response['status'] = 'ERROR';
             $arr_response['msg']    = 'Something went wrong.';
              return response()->json($arr_response); 
        }

          
        return $arr_response;
    }//process modal function for buyer date of birth and phone number




    //function added to match the password field when update profile
    function confirm_current_password(Request $request)
    {
       $arr_response =[];
       $current_password = $request->current_password;
       if(isset($current_password) && !empty($current_password))
       {
           $user = Sentinel::check();

           $credentials['password'] = $current_password;

          if(Sentinel::validateCredentials($user,$credentials)==true) 
          {
              $arr_response['status'] = 'success';
              $arr_response['description']    = 'Password matches successfully.';
              return response()->json($arr_response);            
          }
          else
          {
              $arr_response['status'] = 'ERROR';
              $arr_response['description']    = 'Please enter valid password';
              return response()->json($arr_response); 
          }

       }// current_password

    }// confirm_current_password

  //function added to get the country id
    public function get_countryid(Request $request)
    {
       $country_name = $request->input('countryname');
       if($country_name)
       {
          $country_id = CountriesModel::where('name',$country_name)->pluck('id')->first();
          return $country_id;
       }      
    }//end function get_countryid



}
