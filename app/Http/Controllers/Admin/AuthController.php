<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Services\EmailService;
use App\Common\Services\GeneralService;
use App\Common\Services\UserService;
use App\Models\ModuleSubAdminMappingModel;

use Validator;
use Flash;
use Sentinel;
use Reminder;
use URL;
use Mail;
use Session;
use App\Models\UserModel;



class AuthController extends Controller
{
  public function __construct(EmailService $mail_service,
                              UserModel $UserModel,
                              GeneralService $GeneralService,
                              UserService $UserService,
                              ModuleSubAdminMappingModel $ModuleSubAdminMappingModel
                            )
  {
    
    $this->arr_view_data      = [];
    $this->module_title       = "Admin";
    $this->module_view_folder = "admin.auth";
    $this->EmailService       = $mail_service;
    $this->UserModel          = $UserModel;
    $this->GeneralService     = $GeneralService;
    $this->UserService        = $UserService;
    $this->ModuleSubAdminMappingModel = $ModuleSubAdminMappingModel;
    $this->admin_panel_slug   = config('app.project.admin_panel_slug');
    $this->module_url_path    = url($this->admin_panel_slug);
  }
  
  public function login()
  {
    if($login_user = Sentinel::check()) {
      if($login_user->inRole('admin')){
        $panel_dashboard_url = url('/'.config('app.project.admin_panel_slug').'/dashboard');
        return redirect($panel_dashboard_url);
      }
      else{
        $this->arr_view_data['module_title']     = $this->module_title." Login";
           
           return view($this->module_view_folder.'.login',$this->arr_view_data);
      }
    }
    else{
      $this->arr_view_data['module_title']     = $this->module_title." Login";
         
         return view($this->module_view_folder.'.login',$this->arr_view_data);
    }
    
  }

  public function process_login(Request $request)
  {     
        try
        {
            /* Check Validations and display custom message*/
            request()->validate([
              'email'=>'required|email',
              'password'=>'required'
            ],
            [
              'email.required'=>'Please enter email',
              'password.required'=>'Please enter password'
            ]);

            $credentials = [
              'email'    => $request->input('email'),
              'password' => $request->input('password'),
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

                
                if($user->inRole('admin') || $user->inRole('sub_admin'))
                {

                    if($user->is_active == '1')
                    {
                       
                      $this->UserModel->where('email',$user->email)->update(['timeout'=>"",'login_attempt'=>'0']);

                      if($user->inRole('sub_admin'))
                      {
                          $modules_arr = [];
                          $modules_arr = $this->ModuleSubAdminMappingModel->with(['module_details'])->where('user_id',$user->id)->get()->toArray();

                          if(isset($modules_arr) && count($modules_arr)>0)
                          {
                            return redirect(config('app.project.admin_panel_slug').'/'.$modules_arr[0]['module_details']['module_slug']);
                          }
                          else
                          {
                            Sentinel::logout();
                            Session::flush();
                            Flash::error("You are not authorised person yet.");
                            return redirect('/book');
                          }
          
                      }
                      else
                      {
                         return redirect(config('app.project.admin_panel_slug').'/dashboard');
                      }
                      
                      
                    } 
                    elseif($user->is_active=='0' && $user->login_attempt=='4' && isset($user->timeout))
                    {   
                        Sentinel::logout();
                        Session::flush();
                        Flash::error('Your account is blocked, please try again after 10 minutes.');
                        return redirect()->back();
                    }
                    else
                    {   
                        Sentinel::logout();
                        Session::flush();
                        Flash::error('Your account is blocked.');
                         return redirect()->back();
                    }
                }
                else
                {
                  Flash::error('Not Sufficient Privileges');
                  Sentinel::logout();
                  return redirect()->back();
                }

            }
            else
            {
               // Flash::error('Email or Password is not valid. Please try again.');
                
                $this->incrementloginattempts($request->input('email'));
                return redirect()->back();
            }
        }
        catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e)
        {

            Flash::error($e->getMessage());
            return redirect()->back();
        }
        catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) 
        {
            Flash::error('Your account has not been activated yet');
            Sentinel::logout();
            return redirect()->back();
        }

  }
  function incrementloginattempts($email)
  {
   
    $get_user = $this->UserModel
                        ->where('email',$email)
                        ->first();
    if(!empty($get_user))
    {
      $get_user = $get_user->toArray();
      $dblogin_attempt = $get_user['login_attempt'];
      $timeout = $get_user['timeout'];

      
        if($get_user['login_attempt']>='4'){

           $this->UserModel->where('email',$email)->update(['is_active'=>'0','timeout'=>date("Y-m-d H:i:s")]);



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

              /*$msg     = html_entity_decode('Unauthorized activity occured on your acccount, please change your account password. <br/> If you are that user then please ignore this email.');*/

              
              //$subject = 'Suspicious login attempts ';

              $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                    'APP_NAME'      => config('app.project.name'),
                                    //'MESSAGE'     => $msg
                                   ];

              $arr_mail_data['email_template_id'] = '45';
              $arr_mail_data['arr_built_content'] = $arr_built_content;
              $arr_mail_data['arr_built_subject'] = '';
              $arr_mail_data['user']              = $get_user;

               $this->EmailService->send_mail_section($arr_mail_data);

            /*****************Send Mail Notification to User (END)*****************/


            return Flash::error('Too many unsuccessful attempts have been made your account is get blocked for 10 minutes.');




        }
        else
        {
         $this->UserModel->where('email',$email)->update(['login_attempt'=>$dblogin_attempt+1]);
          return Flash::error('Email or Password is not valid. Please try again.');
        }

    }else{
      return Flash::error('Email is not valid. Please try again.');
    }

  }//end of login attempt function

  public function change_password()
  { 
    $this->arr_view_data['page_title']      = $this->module_title." Change Password";
    $this->arr_view_data['module_title']    = $this->module_title." Change Password";
    $this->arr_view_data['module_url_path'] = $this->module_url_path.'/change_password';
    
    return view($this->module_view_folder.'.change_password',$this->arr_view_data);    
     
  }

  public function update_password(Request $request)
  { 
     $user = Sentinel::check();

    /*Check Validatons and display custom message*/
      $inputs = request()->validate([
        'current_password'=> 'required',
        'new_password' => 'required|min:8|max:16|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{8,}$/',
        'new_password_confirmation' => 'required|same:new_password'
        ],
        [
          'current_password.required'=>'Please enter current password',
          'new_password.required'=>'Please enter new password'
        ]);
      
      $user = Sentinel::check();

      $credentials = [];
      $credentials['password'] = $request->input('current_password');

      if (Sentinel::validateCredentials($user,$credentials)) 
      { 
        $new_credentials = [];
        $new_credentials['password'] = $request->input('new_password');

        if(Sentinel::update($user,$new_credentials))
        {
            
              /*-------------------------------------------------------
              |   Activity log Event
              --------------------------------------------------------*/
               

               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {  
                    $arr_event                 = [];
                    $arr_event['action']       = 'EDIT';
                    $arr_event['title']        = 'Change Password';
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has changed his password.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

              /*----------------------------------------------------------------------*/

              Flash::success('Password reset successfully, please login with a new password.');



        }
        else
        {
          Flash::error('Problem Occurred, While Changing Password');
        }
      } 
      else
      {
        Flash::error('Invalid Old Password');
      }       
      
      return redirect()->back(); 
  }

  public function process_forgot_password(Request $request)
  {
    /*Check Validations and display custom message*/
    $input = request()->validate([
               'email' => "required|email"
            ], [
                'email.required|email' => 'Email is required'
            ]);

    $email = $request->input('email');

    $user  = Sentinel::findByCredentials(['email' => $email]);

    if($user==null)
    {
      Flash::error("Invaild Email Id");
      return redirect()->back();
    }

    if($user->inRole('admin')==false && $user->inRole('sub_admin')==false)
    {
      Flash::error('We are unable to process this Email Id');
      return redirect()->back();
    }



    $reminder = Reminder::create($user);


    $arr_mail_data = $this->built_mail_data($email, $reminder->code); 
    $email_status  = $this->EmailService->send_mail_section($arr_mail_data);
    // if($email_status)
    // {
      Flash::success('Password reset link send successfully to your email id');
      return redirect()->back();
    // }
    // else
    // {
    //   Flash::success('Error while sending password reset link');
    //   return redirect()->back();
    // }
  }

  public function built_mail_data($email, $reminder_code)
  {
    $user = $this->get_user_details($email);
    if($user)
    {
        $arr_user = $user->toArray();

        $reminder_url = '<a target="_blank" style="background:#873dc8; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href="'.URL::to($this->admin_panel_slug.'/validate_admin_reset_password_link/'.base64_encode($arr_user['id']).'/'.base64_encode($reminder_code) ).'">Reset Password</a><br/>';

        $arr_built_content = ['FIRST_NAME'   => $arr_user['first_name'],
                              'EMAIL'        => $arr_user['email'],
                              'REMINDER_URL' => $reminder_url,
                              'SITE_URL'     => config('app.project.name')];


        $arr_mail_data                      = [];
        $arr_mail_data['email_template_id'] = '7';
        $arr_mail_data['arr_built_content'] = $arr_built_content;
         $arr_mail_data['arr_built_subject'] = '';
        $arr_mail_data['user']              = $arr_user;

        return $arr_mail_data;
    }
    return FALSE;
  }

  public function get_user_details($email)
  {
    $credentials = ['email' => $email];
    $user = Sentinel::findByCredentials($credentials); // check if user exists

    if($user)
    {
      return $user;
    }
    return FALSE;
  }


    public function validate_reset_password_link($enc_id, $enc_reminder_code)
    {

        $user_id       = base64_decode($enc_id);
        $reminder_code = base64_decode($enc_reminder_code);

        $user = Sentinel::findById($user_id);

        if(!$user)
        {
            Flash::error('Invalid User Request');
            return redirect()->back();
        }   
       // if($reminder = Reminder::exists($user)) // commented
        if($reminder = Reminder::exists($user,$reminder_code))
        {
            return view($this->module_view_folder.'.reset_password',compact('enc_id','enc_reminder_code'));
        }
        else
        {
            Flash::error('Reset password link expired');
            return redirect(url($this->admin_panel_slug));
            // return redirect()->back();
        }
    }

  public function reset_password(Request $request)
  {
    /*Check Validations*/
    $inputs = request()->validate([
        'password'=>'required',
        'confirm_password'=>'required',
        'enc_id'=>'required',
        'enc_reminder_code'=>'required'
      ],
      [
      'password.required'=>'Please enter password',
      'confirm_password.required'=>'Please enter confirm password'
      ]);

    $enc_id            = $request->input('enc_id');
    $enc_reminder_code = $request->input('enc_reminder_code');
    $password          = $request->input('password');
    $confirm_password  = $request->input('confirm_password');

    if($password  !=  $confirm_password )
    {
      Flash::error('Passwords Do Not Match.');
      return redirect()->back();
    }

    $user_id       = base64_decode($enc_id);
    $reminder_code = base64_decode($enc_reminder_code);

    $user = Sentinel::findById($user_id);

    if(!$user)
    {
      Flash::error('Invalid User Request');
      return redirect()->back();
    }

    if ($reminder = Reminder::complete($user, $reminder_code, $password))
    {

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has reset his password.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

      
            /*----------------------------------------------------------------------*/

          Flash::success('Password reset successfully');
          return redirect($this->admin_panel_slug.'/login');
    }
    else
    {
      Flash::error('Reset Password Link Expired');
      return redirect()->back();
    }

  }

  public function logout()
  {
    Sentinel::logout();
    Session::flush();
    return redirect(url($this->admin_panel_slug));
  }

}
