<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SiteSettingModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\UserModel;
use App\Models\ModuleSubAdminMappingModel;

use App\Models\GeneralSettingsModel;
use App\Common\Services\UserService;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
 
use Validator;
use Flash;
use Input;
use Sentinel; 
 
class SiteSettingController extends Controller
{
    
    public function __construct(SiteSettingModel $siteSetting,
                                ActivityLogsModel $activity_logs,
                                GeneralSettingsModel $GeneralSettingsModel,
                                UserService $UserService,
                                EmailService $EmailService,
                                GeneralService $GeneralService,
                                UserModel $UserModel,
                                ModuleSubAdminMappingModel $ModuleSubAdminMappingModel
                              )
    {
        $this->SiteSettingModel   = $siteSetting;
        $this->arr_view_data      = [];
        $this->BaseModel          = $this->SiteSettingModel;
        $this->ActivityLogsModel  = $activity_logs;
        $this->GeneralSettingsModel = $GeneralSettingsModel;
        $this->UserService        = $UserService;
        $this->GeneralService     = $GeneralService;
        $this->EmailService       = $EmailService;
        $this->UserModel          = $UserModel;
        $this->ModuleSubAdminMappingModel = $ModuleSubAdminMappingModel;



        $this->user_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->welcome_base_img_path   = base_path().config('app.project.img_path.welcome');
        $this->welcome_public_img_path = url('/').config('app.project.img_path.welcome');

        $this->referal_base_img_path   = base_path().config('app.project.img_path.referal');
        $this->referal_public_img_path = url('/').config('app.project.img_path.referal');

        $this->module_title       = "Site Settings";
        $this->module_view_folder = "admin.site_settings";
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/site_settings");
    }

 
    public function index()
    {
        $arr_data      = array();   
        $crypto_symbol = '';

        $obj_data =  $this->BaseModel->first();

        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();    
        }

        $crypto_symbol_obj = $this->GeneralSettingsModel->where('data_id','CRYPTO_SYMBOL')->first();

        if($crypto_symbol_obj)
        {
            $crypto_symbol = $crypto_symbol_obj->data_value; 
        }

        $this->arr_view_data['crypto_symbol']   = $crypto_symbol;

        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['page_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
 
    

    public function update(Request $request, $enc_id) {

        $id = base64_decode($enc_id);

        $user = Sentinel::check();

        /*Check Validations*/
        $inputes = request()->validate([
            'referal_text'              =>'required',
            'site_name'                 =>'required',
            'site_email_address'        =>'required|email',
            'site_contact_number'       =>'required|numeric',
            'site_address'              =>'required',
            'twitter_url'               =>'required',
            'youtube_url'               =>'required',
            'site_short_description'    =>'required',
            'twilio_account_sid'        =>'required',
            'twilio_auth_token'         =>'required',
            'twilio_from_number'        =>'required',
            'payment_gateway_switch'    =>'required', 
            'tax_api_key'               => 'required',
            'tax_url'                   => 'required',
            'tiktok_url'                => 'required',
            'cashback_percentage'       => 'required'
        ]);  

        $file_name = "default.jpg";

        $payment_mode = $request->payment_mode;

        if($payment_mode=='0' && $request->sandbox_stripe_public_key=="")
        {
             Flash::error('Please provide sandbox stripe publish key');      
             return redirect()->back();
        }
        if($payment_mode=='0' && $request->sandbox_stripe_secret_key=="")
        {
             Flash::error('Please provide sandbox stripe secret key');      
             return redirect()->back();
        }
        if($payment_mode=='1' && $request->live_stripe_public_key=="")
        {
             Flash::error('Please provide live stripe publish key');      
             return redirect()->back();
        }
        if($payment_mode=='1' && $request->live_stripe_secret_key=="")
        {
             Flash::error('Please provide live stripe secret key');      
             return redirect()->back();
        }


        /**************************************************/
        if($payment_mode=='0' && $request->sandbox_api_loginid=="")
        {
             Flash::error('Please provide sandbox authorizenet api login id');      
             return redirect()->back();
        }
        if($payment_mode=='0' && $request->sandbox_transactionkey=="")
        {
             Flash::error('Please provide sandbox authorizenet transaction key');      
             return redirect()->back();
        }

         if($payment_mode=='1' && $request->live_api_loginid=="")
        {
             Flash::error('Please provide live authorizenet api login id');      
             return redirect()->back();
        }
        if($payment_mode=='1' && $request->live_transactionkey=="")
        {
             Flash::error('Please provide live authorizenet transaction key');      
             return redirect()->back();
        }




        /***************************************************/


        $admin_commission = $request->admin_commission;
        $seller_commission = $request->seller_commission;

        if(isset($admin_commission) && ($admin_commission=='' || $admin_commission<=0))
        {
             Flash::error('Please provide valid admin commision');      
               return redirect()->back();
        }

        if(isset($seller_commission) && ($seller_commission=='' || $seller_commission<=0))
        {
             Flash::error('Please provide valid dispensary commision');      
               return redirect()->back();
        }


         if(isset($request->sandbox_js_url) && $request->sandbox_js_url!=''){ 
           if(!(starts_with($request->sandbox_js_url, "http://") || starts_with($request->sandbox_js_url, "https://"))) 
           {
               Flash::error('Please provide valid sandbox js url');      
               return redirect()->back();
           }
         }elseif($request->sandbox_js_url=="")
         {
             Flash::error('Please provide sandbox js url'); 
             return redirect()->back();
         }

         if(isset($request->sandbox_url) && $request->sandbox_url!=''){
           if(!(starts_with($request->sandbox_url, "http://") || starts_with($request->sandbox_url, "https://"))) 
          {
               Flash::error('Please provide valid sandbox url');      
               return redirect()->back();
          }
        }elseif($request->sandbox_url=="")
        {
             Flash::error('Please provide sandbox url');
             return redirect()->back();
        }   

          if(isset($request->live_js_url) && $request->live_js_url!=''){  
             if(!(starts_with($request->live_js_url, "http://") || starts_with($request->live_js_url, "https://"))) 
          {
               Flash::error('Please provide valid live js url');  
               return redirect()->back();    
          }
         }elseif($request->live_js_url=="")
         {
            Flash::error('Please provide live js url');   
            return redirect()->back();
         }

         if(isset($request->live_url) && $request->live_url!=''){ 
           if(!(starts_with($request->live_url, "http://") || starts_with($request->live_url, "https://"))) 
          {
               Flash::error('Please provide valid live url');      
               return redirect()->back();
          }
        }elseif($request->live_url=="")
        {
            Flash::error('Please provide url');  
            return redirect()->back();
        }

        
        if ($request->file('image')) 
        {
            $file_name = $request->file('image');
            $file_extension = strtolower($request->file('image')->getClientOriginalExtension()); 
             if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $file_name = sha1(uniqid().$file_name.uniqid()).'.'.$file_extension;
                $request->file('image')->move($this->user_base_img_path, $file_name);

                if ($request->input('old_logo')) {
                    $unlink_old_img_path    = $this->user_base_img_path.'/'.$request->input('old_logo');
                   if(file_exists($unlink_old_img_path))
                    {
                        @unlink($unlink_old_img_path);  
                    }
                }
                

            }
            else
            {
               Flash::error('This file type is invalid, Allowed only jpg, png, jpeg image file type.');
               return redirect()->back(); 
            }

 
        } 
        else
        {
            $file_name = $request->input('old_logo');
        }



        if($request->input('site_status')=='1')
        {
            $site_status = $request->input('site_status');
        }
        else
        {
            $site_status = '0';
        }



        if($request->input('event_status')=='1')
        {
            $event_status = $request->input('event_status');
        }
        else
        {
            $event_status = '0';
        }

        if($request->input('event_date_status')=='1')
        {
            $event_date_status = $request->input('event_date_status');
        }
        else
        {
            $event_date_status = '0';
        }

        if($request->input('trendingproduct_status')=='1')
        {
            $trendingproduct_status = $request->input('trendingproduct_status');
        }
        else
        {
            $trendingproduct_status = '0';
        }

        

        $file_name1 = "default.jpg";

          if ($request->file('welcome_image')) 
        {
            $file_name1 = $request->file('welcome_image');
            $file_extension = strtolower($request->file('welcome_image')->getClientOriginalExtension()); 
             if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $file_name1 = sha1(uniqid().$file_name1.uniqid()).'.'.$file_extension;
                $request->file('welcome_image')->move($this->welcome_base_img_path, $file_name1);

                if ($request->input('old_welcome')) {
                    $unlink_wold_img_path    = $this->welcome_base_img_path.'/'.$request->input('old_welcome');
                   if(file_exists($unlink_wold_img_path))
                    {
                        @unlink($unlink_wold_img_path);  
                    }
                }
            }
            else
            {
               Flash::error('This file type is invalid, Allowed only jpg, png, jpeg image file type.');
               return redirect()->back(); 
            }

 
        } 
        else
        {
            $file_name1 = $request->input('old_welcome');
        }


        $file_name2 = "default.jpg";

          if ($request->file('referal_image')) 
        {
            $file_name2 = $request->file('referal_image');
            $file_extension = strtolower($request->file('referal_image')->getClientOriginalExtension()); 
             if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
            {                           
                $file_name2 = sha1(uniqid().$file_name2.uniqid()).'.'.$file_extension;
                $request->file('referal_image')->move($this->referal_base_img_path, $file_name2);

                if ($request->input('old_referal')) {
                    $unlink_rold_img_path    = $this->referal_base_img_path.'/'.$request->input('old_referal');
                   if(file_exists($unlink_rold_img_path))
                    {
                        @unlink($unlink_rold_img_path);  
                    }
                }
                

            }
            else
            {
               Flash::error('This file type is invalid, Allowed only jpg, png, jpeg image file type.');
               return redirect()->back(); 
            }

 
        } 
        else
        {
            $file_name2 = $request->input('old_referal');
        }
        $total_commision=0;
        if(isset($admin_commission) && $admin_commission!='' && $admin_commission>0 && isset($seller_commission) && $seller_commission!='' && $seller_commission>0)
        {
             $total_commision = (float)$admin_commission+(float)$seller_commission;
             if($total_commision>100){
                Flash::error('Please provide valid commission for admin and dispensary it should be less than 100%');      
                return redirect()->back();
             }
             elseif($total_commision<100){
                Flash::error('Please provide valid commission for admin and dispensary it should not be less than 100%');      
                return redirect()->back();
             }
             
        }


        $arr_data['site_name']                     = $request->input('site_name');
        $arr_data['site_address']                  = $request->input('site_address');
        $arr_data['site_contact_number']           = $request->input('site_contact_number');
        $arr_data['meta_title']                    = $request->input('meta_title');
        $arr_data['meta_desc']                     = $request->input('meta_desc');
        $arr_data['meta_keyword']                  = $request->input('meta_keyword');
        $arr_data['site_email_address']            = $request->input('site_email_address');
        $arr_data['site_logo']                     = $file_name;
        $arr_data['twitter_url']                   = $request->input('twitter_url');
        $arr_data['youtube_url']                   = $request->input('youtube_url');
       // $arr_data['telegram_url']                  = $request->input('telegram_url');
       // $arr_data['buy_and_sell_commodities']      = $request->input('buy_and_sell_commodities');
       // $arr_data['home_background_image']         = $home_background_image;
       // $arr_data['home_background_image_title']   = $request->input('home_background_image_title');
       // $arr_data['home_background_image_content'] = $request->input('home_background_image_content');       
       // $arr_data['social_sharing_site_name']      = $request->input('social_sharing_site_name');
       // $arr_data['social_sharing_meta_title']     = $request->input('social_sharing_meta_title');
       // $arr_data['social_sharing_meta_desc']      = $request->input('social_sharing_meta_desc');
       // $arr_data['social_sharing_meta_desc']      = $request->input('social_sharing_meta_desc');

        
            
        $arr_data['site_status']                   = $site_status;
       // $arr_data['inner_site_logo']               = $inner_site_logo;
        $arr_data['google_url']                    = $request->input('google_url');
        $arr_data['facebook_url']                  = $request->input('facebook_url');
        $arr_data['instagram_url']                 = $request->input('instagram_url');
        $arr_data['site_short_description']        = $request->input('site_short_description'); 


        $arr_data['payment_mode']               = $request->input('payment_mode');
        $arr_data['sandbox_access_token']       = $request->input('sandbox_access_token');
        $arr_data['sandbox_location_id']        = $request->input('sandbox_location_id');
        $arr_data['sandbox_application_id']     = $request->input('sandbox_application_id');
        $arr_data['sandbox_js_url']             = $request->input('sandbox_js_url');
        $arr_data['sandbox_url']                = $request->input('sandbox_url');

        $arr_data['live_access_token']          = $request->input('live_access_token');
        $arr_data['live_location_id']           = $request->input('live_location_id');
        $arr_data['live_application_id']        = $request->input('live_application_id');
        $arr_data['live_js_url']                = $request->input('live_js_url');
        $arr_data['live_url']                   = $request->input('live_url');

        $arr_data['admin_commission']           = $request->input('admin_commission');
        $arr_data['seller_commission']          = $request->input('seller_commission');
        
        $arr_data['welcome_image']              = $file_name1;
        $arr_data['welcome_desc']               = $request->input('welcome_desc');
        $arr_data['welcome_title']              = $request->input('welcome_title');

        $arr_data['referal_image']              = $file_name2;
        $arr_data['referal_text']               = $request->input('referal_text');
        $arr_data['pixelcode']                  = $request->input('pixelcode');
        $arr_data['pixelcode2']                 = $request->input('pixelcode2');
        $arr_data['body_content']               = $request->input('body_content');
        $arr_data['google_ads_script']          = $request->input('google_ads_script');

        $arr_data['sandbox_stripe_public_key'] = $request->input('sandbox_stripe_public_key');
        $arr_data['sandbox_stripe_secret_key'] = $request->input('sandbox_stripe_secret_key');

        $arr_data['live_stripe_public_key']    = $request->input('live_stripe_public_key');
        $arr_data['live_stripe_secret_key']    = $request->input('live_stripe_secret_key');

        $arr_data['sandbox_tracking_api_key']  = $request->input('sandbox_tracking_api_key')?$request->input('sandbox_tracking_api_key'):'';

        $arr_data['event_status']              = $event_status;
        $arr_data['event_date_status']         = $event_date_status;
        $arr_data['trendingproduct_status'] = $trendingproduct_status;


        $arr_data['twilio_account_sid']     = $request->input('twilio_account_sid');
        $arr_data['twilio_auth_token']      = $request->input('twilio_auth_token');
        $arr_data['twilio_from_number']    = $request->input('twilio_from_number');



        $arr_data['sandbox_api_loginid'] = $request->input('sandbox_api_loginid');
        $arr_data['sandbox_transactionkey'] = $request->input('sandbox_transactionkey');

        $arr_data['live_api_loginid'] = $request->input('live_api_loginid');
        $arr_data['live_transactionkey'] = $request->input('live_transactionkey');
        $arr_data['payment_gateway_switch'] = $request->input('payment_gateway_switch');


        $arr_data['buyer_referal_amount']   = $request->input('buyer_referal_amount');
        $arr_data['buyer_refered_amount']   = $request->input('buyer_refered_amount');
        $arr_data['buyer_review_amount']    = $request->input('buyer_review_amount');
        


        $arr_data['live_tax_api_key']    = $request->input('tax_api_key');
        $arr_data['live_tax_url']        = $request->input('tax_url');

        $arr_data['sandbox_tax_api_key']    = $request->input('sand_tax_api_key');
        $arr_data['sandbox_tax_url']        = $request->input('sand_tax_url');
        $arr_data['tiktok_url']        = $request->input('tiktok_url');
        $arr_data['cashback_percentage'] = $request->input('cashback_percentage');




        $entity = $this->BaseModel->where('site_setting_id',$id)->update($arr_data);

        $from_user_id = $to_user_id = $from_user_name = $user_name = $updated_by = "";

        if($entity)
        {

          /*********************Send Notification to Admin and Subadmin for site setting updation (START)********************/

                            if(isset($user) && $user->inRole('sub_admin'))
                            {
                                $from_user_id   = $user->id;
                                $from_user_name = ucfirst($user->first_name ." ".$user->last_name); 
                                $to_user_id   = 1;  
                            }

                            if(isset($user) && $user->inRole('admin'))
                            {
                                $admin_details = Sentinel::getUser();
                                $from_user_id  = $admin_details->id;
                                $to_user_id    = $admin_details->id;
                                $from_user_name = ucfirst($admin_details->first_name.' '.$admin_details->last_name);
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $to_user_id;
                            $arr_event['description']  = 'Site Settings has been updated by '.html_entity_decode($from_user_name);
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Site Settings Updated';
                            $this->GeneralService->save_notification($arr_event);

            /*******************Send Notification to Admin and Subadmin for site setting updation (END) *****************************/

                          /*--------------START send email to admin and all subadmins---------------------------------------------*/

                            if(isset($user) && $user->inRole('sub_admin'))
                            {
                              //Send email to admin  
                              $user_details  = $this->UserModel->where('id',1)->first();
                              if(isset($user_details) && !empty($user_details))
                              {
                                $user_name   = ucfirst($user_details->first_name ." ".$user_details->last_name);
                                $to_user_id  = $user_details->id;
                              }

                                $updated_by    = $user->first_name ." ".$user->last_name;
                                $arr_built_content = ['USER_NAME' => $user_name, 
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'UPDATED_BY'    => $updated_by
                                                 ];

                                $arr_built_subject  = ['UPDATED_BY'   => $updated_by];                     

                                $arr_mail_data['email_template_id'] = '142';
                                $arr_mail_data['arr_built_content'] = $arr_built_content;
                                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                                $this->EmailService->send_mail_section_order($arr_mail_data);


                                //Send email to all subadmins
                                $obj_subadmins = $this->UserModel->where('user_type','sub_admin')->where('is_active','1')->get();
                                $subadmin_name = $updated_by = "";

                                if(isset($obj_subadmins) && !empty($obj_subadmins))
                                {
                                   $arr_subadmins = $obj_subadmins->toArray(); 
                                   if(isset($arr_subadmins) && !empty($arr_subadmins))
                                   {
                                      foreach($arr_subadmins as $subadmin)
                                      {
                                         $modules_arr = [];
                                         $modules_arr = $this->ModuleSubAdminMappingModel->where('user_id',$subadmin['id'])->get()->toArray();
                                         if(isset($modules_arr) && !empty($modules_arr))
                                        {    

                                         if(isset($subadmin['first_name']) && !empty($subadmin['first_name']) && isset($subadmin['last_name']) && !empty($subadmin['last_name']))
                                         {   
                                            $subadmin_name     =  $subadmin['first_name']." ".$subadmin['last_name'];
                                         }

                                            if(isset($subadmin['id']) && !empty($subadmin['id']) && $subadmin['id']==$user->id)
                                            {
                                               $updated_by    = "you";
                                            }

                                            else
                                            {    
                                               $updated_by     =  ucfirst($user->first_name.' '.$user->last_name);
                                            }
                                               
                                            $to_user_id        =  $subadmin['id'];  

                                            $arr_built_content = ['USER_NAME'     => $subadmin_name, 
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'UPDATED_BY'    => $updated_by
                                                 ];

                                            $arr_built_subject = ['UPDATED_BY'   => $updated_by];                     

                                            $arr_mail_data['email_template_id'] = '142';
                                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                            $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                                            $this->EmailService->send_mail_section_order($arr_mail_data);
                                        }//if modules arr
                                      }//end foreach  
                                   }//if arr_subadmins
                                }//if obj_subadmins
                            }

                        /*---------------START send email to admin and all subadmins---------------------------------------------*/


                        /*--------------START send email to all subadmins and admin itself------------------------------------- */
 
                          if(isset($user) && $user->inRole('admin'))
                            {
                                //Send email to admin itself
                                $admin_details     = Sentinel::getUser();
                                $to_user_id        = $admin_details->id;
                                $user_name         = ucfirst($admin_details->first_name.' '.$admin_details->last_name);
                                $updated_by        = 'you';
                                $arr_built_content = ['USER_NAME' => $user_name, 
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'UPDATED_BY'    => $updated_by
                                                 ];

                                $arr_built_subject = ['UPDATED_BY'   => $updated_by];                     

                                $arr_mail_data['email_template_id'] = '142';
                                $arr_mail_data['arr_built_content'] = $arr_built_content;
                                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                                $this->EmailService->send_mail_section_order($arr_mail_data);


                                //Send email to all subadmins
                                $obj_subadmins = $this->UserModel->where('user_type','sub_admin')->where('is_active','1')->get();
                                $subadmin_name = $updated_by = "";

                                if(isset($obj_subadmins) && !empty($obj_subadmins))
                                {
                                   $arr_subadmins = $obj_subadmins->toArray(); 
                                   if(isset($arr_subadmins) && !empty($arr_subadmins))
                                   {
                                      foreach($arr_subadmins as $subadmin)
                                      {
                                         $modules_arr = [];
                                         $modules_arr = $this->ModuleSubAdminMappingModel->where('user_id',$subadmin['id'])->get()->toArray();
                                         if(isset($modules_arr) && !empty($modules_arr))
                                        {    

                                         if(isset($subadmin['first_name']) && !empty($subadmin['first_name']) && isset($subadmin['last_name']) && !empty($subadmin['last_name']))
                                         {   
                                            $subadmin_name     =  $subadmin['first_name']." ".$subadmin['last_name'];
                                         }
                                            $updated_by        =  ucfirst($admin_details->first_name.' '.$admin_details->last_name);
                                            $to_user_id        =  $subadmin['id'];  

                                            $arr_built_content = ['USER_NAME'     => $subadmin_name, 
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'UPDATED_BY'    => $updated_by
                                                 ];

                                            $arr_built_subject = ['UPDATED_BY'   => $updated_by];                     

                                            $arr_mail_data['email_template_id'] = '142';
                                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                            $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                                            $this->EmailService->send_mail_section_order($arr_mail_data);
                                        }//if modules arr
                                      }//end foreach  
                                   }//if arr_subadmins
                                }//if obj_subadmins
                             }//if in role admin

                            /*--------------END send email to all subadmins------------------------------------- */


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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated site settings information.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

            /*----------------------------------------------------------------------*/

            Flash::success('Site settings updated successfully'); 
        }
        else
        {
            Flash::error('Problem cccured, while updating '.str_singular($this->module_title));  
        } 
      
        return redirect()->back()->withInput();
    }

    public function change_site_status(Request $request) {

        $id  = $request->input('site_status_id');

        $site_status = 1;

        if ($request->input('site_status') == '1') {

            $site_status = '0';
        }
        else {

            $site_status = '1';
        }

        $update = $this->SiteSettingModel
                        ->where('site_setting_id' , $id)
                        ->update(['site_status' => $site_status]);
        if ($update) {

            $response = [];
            $response['status']     = 'success';
            $response['message']    = 'Site status updated successfully!';
            $response['data']       = [];

            return json_encode($response);
        }
        else {

            $response = [];
            $response['status']     = 'failure';
            $response['message']    = 'Something went wrong!';
            $response['data']       = [];

            return json_encode($response);
        }
    }

    public function change_event_status(Request $request) {

        $id  = $request->input('site_status_id');

        $event_status = 1;

        if ($request->input('event_status') == '1') {

            $event_status = '0';
        }
        else {

            $event_status = '1';
        }

        $update = $this->SiteSettingModel
                        ->where('site_setting_id' , $id)
                        ->update(['event_status' => $event_status]);
        if ($update) {

            $response = [];
            $response['status']     = 'success';
            $response['message']    = 'Event status updated successfully!';
            $response['data']       = [];

            return json_encode($response);
        }
        else {

            $response = [];
            $response['status']     = 'failure';
            $response['message']    = 'Something went wrong!';
            $response['data']       = [];

            return json_encode($response);
        }
    }

    public function change_event_date_status(Request $request) {

        $id  = $request->input('site_status_id');

        $event_date_status = 1;

        if ($request->input('event_date_status') == '1') {

            $event_date_status = '0';
        }
        else {

            $event_date_status = '1';
        }

        $update = $this->SiteSettingModel
                        ->where('site_setting_id' , $id)
                        ->update(['event_date_status' => $event_date_status]);
        if ($update) {

            $response = [];
            $response['status']     = 'success';
            $response['message']    = 'Event date status updated successfully!';
            $response['data']       = [];

            return json_encode($response);
        }
        else {

            $response = [];
            $response['status']     = 'failure';
            $response['message']    = 'Something went wrong!';
            $response['data']       = [];

            return json_encode($response);
        }
    }
}
