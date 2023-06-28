<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
//use App\Http\Controllers\Admin\MailChimpFileController;

use App\Models\NewsletterEmailModel;
use App\Models\UserModel;
use App\Models\NewsletterTemplateModel;
use App\Common\Services\EmailService;
use App\Common\Services\GeneralService;
use App\Models\SendNewsletterModel;
use App\Common\Services\UserService;


use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use \Mail;
use Sentinel;

 use App\Mail\SendNewsletterEmail;

 
class SendNewsletterController extends Controller
{       
    use MultiActionTrait;

    public function __construct(NewsletterEmailModel $NewsletterEmailModel,UserModel $UserModel,NewsletterTemplateModel $NewsletterTemplateModel,
        EmailService $EmailService,GeneralService $GeneralService,
        SendNewsletterModel $SendNewsletterModel,
        UserService $UserService

       ) 
    {
    	$this->BaseModel          = $NewsletterEmailModel;
        $this->UserModel          = $UserModel;
        $this->NewsletterTemplateModel  = $NewsletterTemplateModel;
        $this->EmailService          = $EmailService;
        $this->GeneralService        = $GeneralService;
        $this->SendNewsletterModel   = $SendNewsletterModel;
        $this->UserService           = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

       
    

        $this->module_title       = "Send Newsletter";
        $this->module_view_folder = "admin.send_newsletter";
        $this->module_url_path    = $this->admin_url_path."/send_newsletter";
    }



   


    public function create()
    {
        $arr_newslettertemplate = [];

        $arr_newslettertemplate = $this->NewsletterTemplateModel->where('is_active','1')->get();
        if(isset($arr_newslettertemplate ) && !empty($arr_newslettertemplate ))
        {
            $arr_newslettertemplate  = $arr_newslettertemplate->toArray(); 
        }

        $arr_seller = $this->UserModel->where('user_type','seller')->where('is_active','1')->get();
         if(isset($arr_seller ) && !empty($arr_seller ))
        {
            $arr_seller  = $arr_seller->toArray(); 
        }
         $this->arr_view_data['arr_seller']      = isset($arr_seller)?$arr_seller:[];

         $arr_buyer = $this->UserModel->where('user_type','buyer')->where('is_active','1')->get();
         if(isset($arr_buyer ) && !empty($arr_buyer ))
        {
            $arr_buyer  = $arr_buyer->toArray(); 
        }
         $this->arr_view_data['arr_buyer']      = isset($arr_buyer)?$arr_buyer:[];


         $arr_newsletter_email = $this->BaseModel->where('is_active','1')->get();

         if(isset($arr_newsletter_email ) && !empty($arr_newsletter_email ))
        {
            $arr_newsletter_email  = $arr_newsletter_email->toArray(); 
        }
         $this->arr_view_data['arr_newsletter_email']      = isset($arr_newsletter_email)?$arr_newsletter_email:[];


        $this->arr_view_data['arr_newslettertemplate']      = isset($arr_newslettertemplate)?$arr_newslettertemplate:[];

    	$this->arr_view_data['page_title']      = str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function storeold(Request $request)
    {
    	$form_data = $request->all();

        $email_arr =[];

    
        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
        if($is_update_process == false)
        {
        	$arr_rules = [
                            'template_id'     => 'required',

                         ];
        } 


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
        
       
    	     

        $template_id  =  isset($form_data['template_id'])?$form_data['template_id']:'';

        $seller_id    =  isset($form_data['seller_id'])?$form_data['seller_id']:'';
        $buyer_id     =  isset($form_data['buyer_id'])?$form_data['buyer_id']:'';
        $newsletteremail_id  =  isset($form_data['newsletteremail_id'])?$form_data['newsletteremail_id']:'';


       /* if((empty($seller_id)) || (empty($buyer_id)) || (empty($newsletteremail_id)))
       {

         $response['status']      = 'warning';
         $response['description'] = 'Please select user';
         return response()->json($response);
       }*/

        $get_templateinfo = $this->NewsletterTemplateModel->where('id',$template_id)->first();
         if(isset($get_templateinfo) && !empty($get_templateinfo))
         {
            $get_templateinfo = $get_templateinfo->toArray();

            $newsletter_name = isset($get_templateinfo['newsletter_name'])?$get_templateinfo['newsletter_name']:'';
            $newsletter_subject = isset($get_templateinfo['newsletter_subject'])?$get_templateinfo['newsletter_subject']:'';
            $newsletter_desc = isset($get_templateinfo['newsletter_desc'])?$get_templateinfo['newsletter_desc']:'';


             if(isset($seller_id) && !empty($seller_id))
            {
                $seller_id= array_filter($seller_id);
                 $email_arr = $seller_id;
            } 
           

            if(isset($buyer_id) && !empty($buyer_id))
            {
                 $buyer_id= array_filter($buyer_id);

                foreach($buyer_id as $k=>$v)
                {

                 $email_arr[] = $v;
                }
            } 

            
            if(isset($newsletteremail_id) && !empty($newsletteremail_id))
            {
                $newsletteremail_id= array_filter($newsletteremail_id);

                foreach ($newsletteremail_id as $key => $value) {
                      $email_arr[] = $value;
                }
               
            }
            
           
            if(isset($email_arr) && !empty($email_arr))
            {

                $countemail = count($email_arr);
                $chunkarr = array_chunk($email_arr, 100);

               try
               {
                 
                     //commented new code
                    // $data = ['message' =>$newsletter_desc,'subject' => $newsletter_subject];
                   
                   // $send_mail = Mail::Bcc($email_arr)->send(new SendNewsletterEmail($data));
                  /*  $data['userarr'] = [];          
                    foreach($email_arr as $emails)
                    {
                         $getname = $this->UserModel->select('email','first_name','last_name')->where('email',$emails)->first();
                        if(isset($getname) && !empty($getname))
                         {
                           $getname = $getname->toArray(); 
                            $data['userarr'] = isset($getname)?$getname:[]; 
                         }


                         $send_mail = Mail::to($emails)->send(new SendNewsletterEmail($data));
                    }*/


                     $content=''; $fullname='';
                     foreach($email_arr as $emails)
                     {
                          $content = $newsletter_desc;   
                         $send_mail = Mail::send(array(),array(), function($message) use($emails,$newsletter_subject,$newsletter_desc,$content)
                        {
                            $fullname='';

                             $getname = $this->UserModel->select('email','first_name','last_name')->where('email',$emails)->first();
                            if(isset($getname) && !empty($getname))
                            {
                                   $getname = $getname->toArray(); 
                                   if(isset($getname['first_name']) && !empty($getname['first_name']) && isset($getname['last_name']) && !empty($getname['last_name']))
                                    {
                                        $fullname = $getname['first_name'].' '.$getname['last_name'];
                                        $content  = str_replace("##USER_NAME##",$fullname,$content);
                                       
                                    }
                                    else
                                    {
                                        
                                        $content  = str_replace("##USER_NAME##",'',$content);
                                        $content  = str_replace("Hello ,",'',$content);

                                    }
                           }
                           else
                           {

                            $content  = str_replace("##USER_NAME##",'',$content);
                            $content  = str_replace("Hello ,",'',$content);
                                         
                           }
                         
                            
                            $message->from('notify@chow420.com');
                            $message->to($emails)
                                  ->subject($newsletter_subject)
                                 // ->setBody($newsletter_desc, 'text/html');
                                  ->setBody($content, 'text/html');
                        });
                        
                    

                           /* $sendemaildbarr = [];
                            $sendemaildbarr['template_id'] = $get_templateinfo['id']; 
                            $sendemaildbarr['email'] = $emails; 
                            $sendemaildbarr['subject'] = $newsletter_subject; 
                            $sendemaildbarr['description'] = $newsletter_desc; 
                            $sendemaildbarr['status'] = 'queue'; 
                            $this->SendNewsletterModel->create($sendemaildbarr);*/
                                                    

                     }//foreach

                            
                    $response['link'] = $this->module_url_path;
                    $response['status']      = "success";
                    $response['description'] = "Newsletter send successfully.";
                    
                    return response()->json($response);



                }//try
                catch(\Swift_TransportException $transportExp){
                  $response['status']      = 'warning';
                  $response['description'] = $transportExp->getMessage();
                  return response()->json($response);
                }


            }//if isset
            else
            {
                  $response['status']      = 'warning';
                  $response['description'] = 'Please select user';
                  return response()->json($response);
            }  

         }//if get templateinfo
         else
            {
                  $response['status']      = 'warning';
                  $response['description'] = 'Something went wrong.';
                  return response()->json($response);
            }     
       
    }//end of function  

    //new function for send newsletter
    public function store(Request $request)
    {
        $form_data = $request->all();

        $email_arr =[];

        $user = Sentinel::check();
   
        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
        if($is_update_process == false)
        {
            $arr_rules = [
                            'template_id'     => 'required',

                         ];
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
        
       
             

        $template_id  =  isset($form_data['template_id'])?$form_data['template_id']:'';

        $seller_id    =  isset($form_data['seller_id'])?$form_data['seller_id']:'';
        $buyer_id     =  isset($form_data['buyer_id'])?$form_data['buyer_id']:'';
        $newsletteremail_id  =  isset($form_data['newsletteremail_id'])?$form_data['newsletteremail_id']:'';

         $get_templateinfo = $this->NewsletterTemplateModel->where('id',$template_id)->first();
         if(isset($get_templateinfo) && !empty($get_templateinfo))
         {
            $get_templateinfo = $get_templateinfo->toArray();

            $newsletter_name = isset($get_templateinfo['newsletter_name'])?$get_templateinfo['newsletter_name']:'';
            $newsletter_subject = isset($get_templateinfo['newsletter_subject'])?$get_templateinfo['newsletter_subject']:'';
            $newsletter_desc = isset($get_templateinfo['newsletter_desc'])?$get_templateinfo['newsletter_desc']:'';


             if(isset($seller_id) && !empty($seller_id))
            {
                $seller_id= array_filter($seller_id);
                 $email_arr = $seller_id;
            } 
           

            if(isset($buyer_id) && !empty($buyer_id))
            {
                 $buyer_id= array_filter($buyer_id);

                foreach($buyer_id as $k=>$v)
                {

                 $email_arr[] = $v;
                }
            } 

            
            if(isset($newsletteremail_id) && !empty($newsletteremail_id))
            {
                $newsletteremail_id= array_filter($newsletteremail_id);

                foreach ($newsletteremail_id as $key => $value) {
                      $email_arr[] = $value;
                }
               
            }
            
           
            if(isset($email_arr) && !empty($email_arr))
            {

                $countemail = count($email_arr);
                $chunkarr = array_chunk($email_arr, 100);

               try
               { 
                 
                    /* $content=''; $fullname='';
                     foreach($email_arr as $emails)
                     {
                          $content = $newsletter_desc;   
                         $send_mail = Mail::send(array(),array(), function($message) use($emails,$newsletter_subject,$newsletter_desc,$content)
                        {
                            $fullname='';

                             $getname = $this->UserModel->select('email','first_name','last_name')->where('email',$emails)->first();
                            if(isset($getname) && !empty($getname))
                            {
                                   $getname = $getname->toArray(); 
                                   if(isset($getname['first_name']) && !empty($getname['first_name']) && isset($getname['last_name']) && !empty($getname['last_name']))
                                    {
                                        $fullname = $getname['first_name'].' '.$getname['last_name'];
                                        $content  = str_replace("##USER_NAME##",$fullname,$content);
                                       
                                    }
                                    else
                                    {
                                        
                                        $content  = str_replace("##USER_NAME##",'',$content);
                                        $content  = str_replace("Hello ,",'',$content);

                                    }
                           }
                           else
                           {

                            $content  = str_replace("##USER_NAME##",'',$content);
                            $content  = str_replace("Hello ,",'',$content);
                                         
                           }
                         
                            
                            $message->from('notify@chow420.com');
                            $message->to($emails)
                                  ->subject($newsletter_subject)
                                 // ->setBody($newsletter_desc, 'text/html');
                                  ->setBody($content, 'text/html');
                        });
                        
                     }//foreach
                    */


                        require 'vendor/autoload.php'; 

                       // $from = new \SendGrid\Mail\From("notify@chow420.com", "Chow420");
                        $from = new \SendGrid\Mail\From("chownotify@vliso.com", "Chow420");
                        $tos =[];
                        $fullname=''; $setname='';
                        foreach($email_arr as $emails)
                        {
                            $getname = $this->UserModel->select('email','first_name','last_name')->where('email',$emails)->first();
                            if(isset($getname) && !empty($getname))
                            {
                                    $getname = $getname->toArray(); 
                                    if(isset($getname['first_name']) && !empty($getname['first_name']) && isset($getname['last_name']) && !empty($getname['last_name']))
                                    {
                                          $fullname = "Hello " .$getname['first_name'].' '.$getname['last_name'].", ";
                                          $setname = $getname['first_name'].' '.$getname['last_name'];
                                    }else{
                                          $fullname ='';
                                          $setname = '';
                                    }
                            }
                            else{
                                $fullname ='';
                                $setname = '';
                             }

                            $tos[] = new \SendGrid\Mail\To(
                                $emails,
                                $setname,
                                [
                                    '-name-' => $fullname
                                ]
                            );
                        }//foreach
                        $newsletter_desc  = str_replace("Hello ##USER_NAME##,",'',$newsletter_desc);
                        $globalSubstitutions = ['-desc-' => trim($newsletter_desc)];
                        $subject= $newsletter_subject;
                        $plainTextContent = new \SendGrid\Mail\PlainTextContent(
                            "-name- -desc-"
                        );
                        $htmlContent = new \SendGrid\Mail\HtmlContent(
                            "<strong>-name-</strong> -desc-"
                        );
                        $email = new \SendGrid\Mail\Mail(
                            $from,
                            $tos,
                            $subject, // or array of subjects, these take precendence
                            $plainTextContent,
                            $htmlContent,
                            $globalSubstitutions
                        );

                        // $sendgrid = new \SendGrid('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');
                          $sendgrid = new \SendGrid('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');

                        

                        try 
                        {
                            $responsedata = $sendgrid->send($email);
                            

                            /*-------------------------------------------------------
                            |   Activity log Event
                            --------------------------------------------------------*/
                              
                            //save sub admin activity log 
 
                            if(isset($user) && $user->inRole('sub_admin'))
                            {
                                $arr_event                 = [];
                                $arr_event['action']       = 'SEND';
                                $arr_event['title']        = $this->module_title;
                                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has sent newsletter '.$newsletter_name.'.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }


                            /*----------------------------------------------------------------------*/


                          $response['link']        = $this->module_url_path;
                          $response['status']      = "success";
                          $response['description'] = "Newsletter send successfully.";
                          return response()->json($response);



                        }catch(Exception $e){
                          $response['status']      = 'warning';
                          $response['description'] = $e->getMessage();
                          return response()->json($response);
                        }

                }//try
                catch(Exception $e){
                  $response['status']      = 'warning';
                  $response['description'] = $e->getMessage();
                  return response()->json($response);
                }


            }//if isset
            else
            {
                  $response['status']      = 'warning';
                  $response['description'] = 'Please select user';
                  return response()->json($response);
            }  

         }//if get templateinfo
         else
            {
                  $response['status']      = 'warning';
                  $response['description'] = 'Something went wrong.';
                  return response()->json($response);
            }     
       
    }//end of function

/*    public function store_new(Request $request)
    {
        $form_data = $request->all();

        $email_arr =[];

    
        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
        if($is_update_process == false)
        {
            $arr_rules = [
                            'template_id'     => 'required',

                         ];
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
        
       
             

        $template_id  =  isset($form_data['template_id'])?$form_data['template_id']:'';

        $seller_id    =  isset($form_data['seller_id'])?$form_data['seller_id']:'';
        $buyer_id     =  isset($form_data['buyer_id'])?$form_data['buyer_id']:'';
        $newsletteremail_id  =  isset($form_data['newsletteremail_id'])?$form_data['newsletteremail_id']:'';

         $get_templateinfo = $this->NewsletterTemplateModel->where('id',$template_id)->first();
         if(isset($get_templateinfo) && !empty($get_templateinfo))
         {
            $get_templateinfo = $get_templateinfo->toArray();

            $newsletter_name = isset($get_templateinfo['newsletter_name'])?$get_templateinfo['newsletter_name']:'';
            $newsletter_subject = isset($get_templateinfo['newsletter_subject'])?$get_templateinfo['newsletter_subject']:'';
            $newsletter_desc = isset($get_templateinfo['newsletter_desc'])?$get_templateinfo['newsletter_desc']:'';


             if(isset($seller_id) && !empty($seller_id))
            {
                $seller_id= array_filter($seller_id);
                 $email_arr = $seller_id;
            } 
           

            if(isset($buyer_id) && !empty($buyer_id))
            {
                 $buyer_id= array_filter($buyer_id);

                foreach($buyer_id as $k=>$v)
                {

                 $email_arr[] = $v;
                }
            } 

            
            if(isset($newsletteremail_id) && !empty($newsletteremail_id))
            {
                $newsletteremail_id= array_filter($newsletteremail_id);

                foreach ($newsletteremail_id as $key => $value) {
                      $email_arr[] = $value;
                }
               
            }
            
           
            if(isset($email_arr) && !empty($email_arr))
            {

                $countemail = count($email_arr);
                $chunkarr = array_chunk($email_arr, 100);

               try
               { 
                       // $from = new \SendGrid\Mail\From("notify@chow420.com", "Chow420");
                        $from = new \SendGrid\Mail\From("chownotify@vliso.com", "Chow420");
                        $tos =[];
                        $fullname=$fname=$lname='';
                        foreach($email_arr as $emails)
                        {
                          if(!empty($emails) && !filter_var($emails, FILTER_VALIDATE_EMAIL) === false){
                                        // MailChimp API credentials
                                        $apiKey = 'c0945de3555f07a50686cac5c853ba36-us17';
                                        $listID = 'c642ca6ce3';
                                        
                                        // MailChimp API URL
                                        $memberID   = md5(strtolower($emails));
                                        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
                                        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;

                                          $getname = $this->UserModel->select('email','first_name','last_name')->where('email',$emails)->first();
                                        if(isset($getname) && !empty($getname))
                                        {
                                                $getname = $getname->toArray(); 
                                                $fname   = $getname['first_name'];
                                                $lname   = $getname['last_name'];

                                        }       
                                  
                                         $json = json_encode([
                                            'email_address' => $emails,
                                            'status'        => 'subscribed',
                                            'merge_fields'  => [
                                                'FNAME'     => $fname,
                                                'LNAME'     => $lname
                                            ]
                                        ]);                   



                                        // send a HTTP POST request with curl
                                        $ch = curl_init($url);
                                        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
                                        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                        $result = curl_exec($ch);
                                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                        curl_close($ch);

                                         if ($httpCode == 200) 
                                         {
                                            $from      = "chownotify@getnada.com";
                                            $subject   = $newsletter_subject;
                                            $MailChimp = new MailChimpFileController('c0945de3555f07a50686cac5c853ba36-us17');
                                            $result    = $MailChimp->post("campaigns", [
                                                'type' => 'regular',
                                                'recipients' => ['list_id'      =>'c642ca6ce3'],
                                                'settings'   => ['subject_line' => $subject,
                                                                 'reply_to'     => 'ashwini.rwaltzsoftware@gmail.com',
                                                                 'from_name'    => 'chow420'
                                                                ]
                                                ]);

                                            $response    = $MailChimp->getLastResponse();
                                            $responseObj = json_decode($response['body']);  



                                          
                                            $result      = $MailChimp->put('campaigns/' . $responseObj->id . '/content', [
                                                  'template'   => ['id' => 10008690, 
                                                    'sections' => ['USER_NAME' => $fname." ".$lname,'SERVICE'=>s1uFa9e0vDU ]
                                                    ]
                                                  ]);


                                            $result     = $MailChimp->post('campaigns/' . $responseObj->id . '/actions/send');

                                            dd($result);

                                         }
                            }//if          

                        }//foreach
                    }//try
                    catch(Exception $e){
                          $response['status']      = 'warning';
                          $response['description'] = $e->getMessage();
                          return response()->json($response);
                        }

                   
                }//if    
            }//if        
                       
    }//end of function    */


}
