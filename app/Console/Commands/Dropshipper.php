<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Sentinel;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\UserModel;
use App\Models\OrderProductModel;
use App\Models\EmailTemplateModel;
use \Mail;
use App\Models\SiteSettingModel;


class Dropshipper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dropshipper:ongoingorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send dropshipper email for order is ongoing order not for pending age verification order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GeneralService $GeneralService,UserModel $UserModel,EmailService $EmailService,OrderProductModel $OrderProductModel,EmailTemplateModel $EmailTemplateModel,SiteSettingModel $SiteSettingModel)
    {
        parent::__construct();
        $this->GeneralService     = $GeneralService;
        $this->EmailService       = $EmailService;
        $this->UserModel          = $UserModel;
        $this->OrderProductModel  = $OrderProductModel;
        $this->EmailTemplateModel = $EmailTemplateModel;
        $this->SiteSettingModel   = $SiteSettingModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dropshiparr =[];

        $get_ongoing_orders =\DB::table('order_details')->where('order_status','2')->where('buyer_age_restrictionflag',0)->orderby('id','desc')->get();
        if(isset($get_ongoing_orders) && !empty($get_ongoing_orders))
        {
           $get_ongoing_orders = $get_ongoing_orders->toArray(); 

           foreach($get_ongoing_orders as $k=>$order)
           {
                $orderid = $order->id;
                $order_no = $order->order_no;

                //get order products

                   $order_products = $this->OrderProductModel
                                  ->where('order_id',$order->id)
                                  ->where('dropshipper_id','!=',0)
                                  ->get();



                    if(isset($order_products) && !empty($order_products))
                    {
                        $order_products = $order_products->toArray();

                        $dropshiparr =[];

                        foreach ($order_products as $key => $value) 
                        {

                            $dropinfo = get_dropshipper_info($value['dropshipper_id'],$value['product_id']);
                            if(isset($dropinfo) && !empty($dropinfo))
                            {
                                $dropshiparr[$dropinfo['email']]['dropshipperid'] = isset($dropinfo['id'])?$dropinfo['id']:'';
                                $dropshiparr[$dropinfo['email']]['name'] = isset($dropinfo['name'])?$dropinfo['name']:'';
                                $dropshiparr[$dropinfo['email']]['email'] = isset($dropinfo['email'])?$dropinfo['email']:'';
                                $dropshiparr[$dropinfo['email']]['orderid'] = $orderid;
                                $dropshiparr[$dropinfo['email']]['orderno'] = $order_no;

                           }//if dropshipinfo
                          
                        }// foreach order_products
                     }//if isset order products  


                    if(isset($dropshiparr) && !empty($dropshiparr))
                    {

                        foreach($dropshiparr as $kk=>$vv){


                   
                        $admin_role = Sentinel::findRoleBySlug('admin');  

                        $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                        $admin_id   = 0;
                        if($admin_obj)
                        {
                            $admin_id = $admin_obj->user_id;            
                        }
                        
                        $user_name='';

                       
                        if(isset($vv['name']) && !empty($vv['name']))
                        {
                           $user_name = $vv['name'];
                        }


                        // $arr_event                 = [];
                        // $arr_event['from_user_id'] = $admin_id;
                        // $arr_event['to_user_id']   = $order->seller_id;
                        // $arr_event['type']         = 'seller';
                        // $arr_event['description']  = 'Order number <b>'.$order->order_no.' </b> is still pending please ship this order.';                 
                        // $arr_event['title']        = 'Dropshipper Order '.$order->order_no.' Reminder';                    
                        // $this->GeneralService->save_notification($arr_event);


                  

                       
                        $arr_built_content = [
                            'USER_NAME'     => $user_name,
                            'APP_NAME'      => config('app.project.name'),
                            //'MESSAGE'       => $msg,
                           // 'URL'           => $url,
                            'ORDER_NO'      => $vv['orderno']
                        ];

                        $arr_built_subject = [                       
                            'ORDER_NO'      => $vv['orderno']
                        ];

                        $arr_mail_data['email_template_id'] = '147';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                        $arr_mail_data['user']              =  isset($vv['name'])?$vv['name']:'';
                        $arr_mail_data['user_email']        =  isset($vv['email'])?$vv['email']:'';

                        $this->send_mail_ongoing_order($arr_mail_data);
                    

                    /**************end send email**********************/

                  }//foreach dropshiparr

                }//if isset dropshiparr 

           }//foreach
        }//if isset  
        
    }//handle



    public function send_mail_ongoing_order($arr_mail_data = FALSE)
    { 
     
        if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
        {   

            $site_setting_arr = [];
            $site_setting_obj = SiteSettingModel::first();  
            if(isset($site_setting_obj))
            {
                $site_setting_arr = $site_setting_obj->toArray();            
            }


            $arr_email_template = [];
            $obj_email_template = $this->EmailTemplateModel->where('id',$arr_mail_data['email_template_id'])->first();
            
            if($obj_email_template)
            {
                $arr_email_template = $obj_email_template->toArray();
                $user               = $arr_mail_data['user'];
                $user_email         = $arr_mail_data['user_email'];

                $order_number = isset($arr_mail_data['ORDER_NO']) ? $arr_mail_data['ORDER_NO'] : '' ;
                

                //$content = $arr_mail_data['arr_built_content'];
                $content = $arr_email_template['template_html'];
                $subj = $arr_email_template['template_subject'] .' '. $order_number;
    
                if(isset($arr_mail_data['arr_built_content']) && sizeof($arr_mail_data['arr_built_content'])>0)
                {
                    foreach($arr_mail_data['arr_built_content'] as $key => $data)
                    {
                        $content = str_replace("##".$key."##",$data,$content);
                    }
                }
                $content = view('email.front_general',compact('content'))->render();
                $content = html_entity_decode($content);
                if(isset($arr_mail_data['arr_built_subject']) && sizeof($arr_mail_data['arr_built_subject'])>0)
                {
                    foreach($arr_mail_data['arr_built_subject'] as $key => $data)
                    {
                        $subj = str_replace("##".$key."##",$data,$subj);
                    }
                }
                $send_mail = Mail::send(array(),array(), function($message) use($user,$arr_email_template,$content,$arr_mail_data,$subj,$user_email)
                {
                    $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                    $message->to($user_email, $user)
                          ->subject($subj)
                          ->setBody($content, 'text/html');

                });                
       
                return $send_mail;
            }
            return FALSE;   
        }
        return FALSE;
    }//end function order

}
