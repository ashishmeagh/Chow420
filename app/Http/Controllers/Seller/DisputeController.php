<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Common\Services\GeneralService;

use App\Models\DisputeModel;
use App\Models\BuyerModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\DisputeChatModel;
use App\Models\SellerModel;
use App\Common\Services\EmailService;




use Validator;
use Flash;
use Sentinel;
use Hash;
use Session;
 
class DisputeController extends Controller
{

    public function __construct(
                                DisputeModel $DisputeModel,
                                BuyerModel $BuyerModel,
                                OrderModel $OrderModel,
                                UserModel $UserModel,
                                DisputeChatModel $DisputeChatModel,
                                GeneralService $GeneralService,
                                SellerModel $SellerModel,
                                EmailService $EmailService

                               )
    {
        $this->BuyerModel         = $BuyerModel;
        $this->DisputeModel       = $DisputeModel;
        $this->OrderModel         = $OrderModel;
        $this->UserModel          = $UserModel; 
        $this->DisputeChatModel   = $DisputeChatModel; 
       $this->GeneralService     = $GeneralService;
       $this->SellerModel         = $SellerModel;
        $this->EmailService       = $EmailService;
        
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        $this->profile_img_public_path = url('/').config('app.project.img_path.user_profile_image');
        $this->profile_img_base_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->chat_attachment_img_base_path = base_path().config('app.project.chat_attachment');
        $this->attachment_img_public_path = url('/').config('app.project.chat_attachment');


        $this->module_title       = "Dispute";
        $this->module_view_folder = "seller/dispute";

        $this->id_proof_public_path = url('/').config('app.project.id_proof');
        $this->id_proof_base_path   = base_path().config('app.project.id_proof');
        
        $this->module_icon        = "fa-cogs";
    }


    public function index($order_id="")
    {

        $buyer_arr = $seller_arr = $chat_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

        if($order_id!="")
        {    
          $order_id         = base64_decode($order_id);
        }

     //  $order_details   = $this->OrderModel->with('seller_details')->where('id',$order_id)->first()->toArray(); 
        $order_details   = $this->OrderModel->with('buyer_details')->where('id',$order_id)->first(); 

        if(!empty($order_details))
        {
          $order_details = $order_details->toArray();
        }
        $order_no = $order_details['order_no'];

        //get Admin Details
        $admin_role       = Sentinel::findRoleBySlug('admin');        
        $admin_obj        = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
        $admin_details    = $this->UserModel->where('id',$admin_obj->user_id)->first()->toArray();


        // if login use is the buyer
        if($user_details->inRole('seller'))
        {
           //get buyer details
            $seller_obj = $this->SellerModel->with('user_details')->where('user_id',$user_details->id)->first();
            if($seller_obj)
            {
                $seller_details = $seller_obj->toArray(); 


                $sender_id     = $seller_details['user_id'];
                $receiver_id   = $order_details['seller_id'];
                $msg_id_arr    = [$admin_obj->user_id,$sender_id,$receiver_id];

        
      
                $chat_arr    = $this->DisputeChatModel->with(['sender_details','receiver_details'])
                                     // ->where('order_id',$order_id)
                                      ->where('order_no',$order_no)
                                      ->whereIn('receiver_id',$msg_id_arr)
                                      ->whereIn('sender_id',$msg_id_arr)
                                      ->get()->toArray();
                
            }
        }


        $this->arr_view_data['attachment_img_public_path'] = $this->attachment_img_public_path;
        $this->arr_view_data['profile_img_path']     = $this->profile_img_public_path;
        $this->arr_view_data['chat_attachment_img_base_path'] = $this->chat_attachment_img_base_path;
         $this->arr_view_data['sender_id']           = $sender_id;        
        $this->arr_view_data['receiver_id']          = $receiver_id;   
        $this->arr_view_data['seller_details']        = $seller_details;
        $this->arr_view_data['order_details']        = $order_details;
        $this->arr_view_data['admin_details']        = $admin_details;
        $this->arr_view_data['chat_arr']             = $chat_arr;
        $this->arr_view_data['page_title']           = 'Dispute';
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }


   public function raise(Request $request)
    {
        $sender_id = $admin_id = $receiver_id = 0;
        $file_name = Null;

        if(Sentinel::check()==true)
        {
            $sender_id = Sentinel::check()->id;         
        }

        //here sender is buyer and receiver is seller
        $order_id          = $request->input('order_id');
        $order_no          = $request->input('order_no');

        if($order_id!="")
        {
            $order_details   = $this->OrderModel->where('id',$order_id)->first()->toArray();
            $receiver_id     = $order_details['seller_id'];

        }
        $message           = $request->input('message');    

      //attachment upload        
      if($request->hasFile('attachment'))
      {
          $file_extension = strtolower($request->file('attachment')->getClientOriginalExtension());          

          if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
          {                           
              $file_name = time().uniqid().'.'.$file_extension;                    
              $request->file('attachment')->move($this->chat_attachment_img_base_path, $file_name);
          }
          else
          {
              $response['status']  = 'ERROR';
              $response['message'] = 'Please select valid profile image, only jpg,png and jpeg file are alowed';

              return response()->json($response);
          }            
      }

        $message_data['order_id']          = $order_id;
        $message_data['order_no']          = $order_no;
        $message_data['user_id']           = $sender_id;
        $message_data['dispute_reason']    = $message;
        $message_data['is_dispute_finalized'] = '0';
        $message_data['dispute_status']    = '0';
        $message_data['role']              = 'buyer';
        $message_data['attachment']        = $file_name or Null;

        $is_store = $this->DisputeModel->create($message_data);    

        if($is_store)
        {
            /******************* Notification START* For Admin  *************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $first_name    = "";
                $last_name    = "";
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    $first_name    = $user_details->first_name;
                    $last_name    = $user_details->last_name;
                    $user_name = $first_name . ' ' . $last_name; 
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
                $arr_event['description']  = html_entity_decode('Buyer '.$user_name.' has raised the dispute for order with Order No.: '. $order_details['order_no'].'.');
                $arr_event['type']         = '';
                $arr_event['title']        = 'Dispute Raised';
 
                $this->GeneralService->save_notification($arr_event);

         /*******************Notification END For Admin   ***************************/

            /***************Send Dispute Raise Mail to Admin (START)**************************/
            $to_user = Sentinel::findById($admin_id);

            $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
            $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

            //$msg     = html_entity_decode('Buyer ' . $user_name . ' has raised the dispute for order with Order No.: ' . $order_details['order_no'] . '.');

            $url     = url('/').'/'.config('app.project.admin_panel_slug').'/dispute/'.base64_encode($order_details['id']);
            //$subject = 'New Dispute Raised';

            $arr_built_content = [
                'USER_NAME'     => $f_name.' '.$l_name,
                'APP_NAME'      => config('app.project.name'),
                //'MESSAGE'       => $msg,
                'BUYER_NAME'   => $user_name,
                'ORDER_NO'     => $order_details['order_no'],
                'URL'           => $url
            ];

            $arr_mail_data['email_template_id'] = '70';
            $arr_mail_data['arr_built_content'] = $arr_built_content;
            $arr_mail_data['arr_built_subject'] = '';
            $arr_mail_data['user']              = Sentinel::findById($admin_id);
            
            $this->EmailService->send_mail_section($arr_mail_data);
            

            /*********************Send Dispute Raise Mail to Admin (END)*****************/

            return response()->json(['status'=>'success','description'=>'Dispute Raised Successfully.']);
        }
        else
        {
            return response()->json(['status'=>'error','description'=>'Problem Occured While Raising Dispute!']);
        }
    }
    public function getchatmessages(Request $request)
    {
      
        $receiverid  = $request->id;
        $role        = $request->role;
        $orderid     = $request->orderid;
        $orderno     = $request->orderno;

        if($receiverid && $role && $orderno)
        {

             $user_details = Sentinel::getUser();   
             if(!empty($user_details))
             {

                $senderid = $user_details->id;
             }

               if($role!="" && $role=='admin')
               {
                    /* $chat_arr    = $this->DisputeChatModel->with(['sender_details','receiver_details'])
                                     ->where('order_no',$orderno)
                                     ->where('order_id',$orderid)
                                     ->where('receiver_id',1)
                                     ->orWhere('sender_id',$senderid)
                                     ->where('receiver_id',$senderid)
                                     ->orWhere('sender_id',1)
                                     ->get()->toArray();*/

                      $chat_arr    = $this->DisputeChatModel->with(['sender_details.seller_detail','receiver_details.seller_detail'])
                                     //->where('order_no',$orderno)
                                    // ->where('order_id',$orderid)
                                     ->where([['receiver_id',1],['order_id',$orderid]])
                                     ->orWhere([['sender_id',$senderid],['order_id',$orderid]])
                                     ->where([['receiver_id',$senderid],['order_id',$orderid]])
                                     ->orWhere([['sender_id',1],['order_id',$orderid]])
                                     ->get()->toArray();               

               }

              else if($role!="" && $role=='buyer')
              {  

                    /*$chat_arr    = $this->DisputeChatModel->with(['sender_details','receiver_details'])
                                      ->where('order_no',$orderno)
                                      ->where('order_id',$orderid)
                                      ->where('receiver_id',$receiverid)
                                      ->where('sender_id',$senderid)
                                      ->orWhere('receiver_id',$senderid)
                                      ->orWhere('sender_id',$receiverid)
                                      ->get()->toArray();*/

                     $chat_arr    = $this->DisputeChatModel->with(['sender_details.seller_detail','receiver_details.seller_detail'])
                                    //  ->where('order_no',$orderno)
                                   //   ->where('order_id',$orderid)
                                      ->where([['receiver_id',$receiverid],['order_id',$orderid]])
                                      ->where([['sender_id',$senderid],['order_id',$orderid]])
                                      ->orWhere([['receiver_id',$senderid],['order_id',$orderid]])
                                      ->orWhere([['sender_id',$receiverid],['order_id',$orderid]])
                                      ->get()->toArray();


              }                        

              $this->arr_view_data['chat_arr']  = isset($chat_arr)?$chat_arr:[];       
              $this->arr_view_data['page_title'] = 'Dispute';
              $this->arr_view_data['sender_id']  = $senderid;        
              $this->arr_view_data['receiver_id']= $receiverid;  
              $this->arr_view_data['role']= $role;  
              $this->arr_view_data['attachment_img_public_path'] = $this->attachment_img_public_path;
              $this->arr_view_data['profile_img_path']     = $this->profile_img_public_path;
              $this->arr_view_data['chat_attachment_img_base_path'] = $this->chat_attachment_img_base_path;
                         
              return view($this->module_view_folder.'.chatmessages',$this->arr_view_data);



        }


    }

    public function send_message(Request $request)
    {
        $sender_id = $admin_id = $receiver_id = 0;
        $file_name = Null;

        if(Sentinel::check()==true)
        {
            $sender_id = Sentinel::check()->id;         
        }

        //here sender is buyer and receiver is seller
        $order_id          = $request->input('order_id');
        $order_no          = $request->input('order_no');
        $receiver_id       = $request->input('receiver_id');
        $message           = $request->input('message');    

      //attachment upload        
      if($request->hasFile('attachment'))
      {
          $file_extension = strtolower($request->file('attachment')->getClientOriginalExtension());          

          if(in_array($file_extension,['jpg','png','jpeg','JPG','PNG','JPEG']))
          {                           
              $file_name = time().uniqid().'.'.$file_extension;                    
              $request->file('attachment')->move($this->chat_attachment_img_base_path, $file_name);
          }
          else
          {
              $response['status']  = 'error';
              $response['description'] = 'Please select valid profile image, only jpg,png and jpeg file are alowed';

              return response()->json($response);
          }            
      }

        $message_data['order_id']          = $order_id;
        $message_data['order_no']          = $order_no;
        $message_data['receiver_id']       = $receiver_id;
        $message_data['sender_id']         = $sender_id;
        $message_data['message']           = $message;
        $message_data['is_viewed']         = '0';
        $message_data['role']              = 'Seller';
        $message_data['attachment']        = $file_name or Null;


        $is_store = $this->DisputeChatModel->create($message_data);    

        if($is_store)
        {
            $user_name = "";
         /*********************Send Email Notification START***********************/
            $obj_order = $this->OrderModel->where('id',$order_id)->first();
            if($obj_order)
            {
               $order_no = $obj_order->order_no;
            }

            $user      = Sentinel::findById($sender_id);
            $first_name = isset($user->first_name)?$user->first_name:'';
            $last_name  = isset($user->last_name)?$user->last_name:'';
            //$user_name  = $first_name." ".$last_name;    


             if($user->user_type=="seller")
             {
                   $user_name = get_seller_details($user->id);
             }
             else
             {
                   $user_name  = $first_name." ".$last_name; 
             }



            $chat_msg = '';

             if(isset($file_name) && $file_name != Null){
                $chat_msg = html_entity_decode('Buyer '.$user_name.' has uploaded file for order <b>'.$order_no.'</b>');
            }else{
                $chat_msg = html_entity_decode('Buyer '.$user_name.' sent message for order <b>'.$order_no.'</b><br> Message: '.$message);
            }

            $receiver_user  = Sentinel::findById($receiver_id);

            if($receiver_user)
            {

              if($receiver_user->user_type=="admin")
              {
                $dispute_url = url('/').'/'.config('app.project.admin_panel_slug').'/dispute/'.base64_encode($order_id);              
              }

              if($receiver_user->user_type=="seller")
              {
                $dispute_url = url('/').'/seller/dispute/'.base64_encode($order_id);              
              }

              if($receiver_user->user_type=="buyer")
              {
                $dispute_url = url('/').'/buyer/dispute/'.base64_encode($order_id);              
              }
              
            }
            

            $arr_event                 = [];
            $arr_event['from_user_id'] = $sender_id;
            $arr_event['to_user_id']   = $receiver_id;
            $arr_event['description']  = html_entity_decode('Dispensary '.$user_name.' has sent message on dispute chat for order no: <a target="_blank" href="'.$dispute_url.'">'. $obj_order->order_no.'</a>.');
            $arr_event['type']         = '';
            $arr_event['title']        = 'Chat';
            $this->GeneralService->save_notification($arr_event);


            /*******************send email********************************/

                $receiver_user = Sentinel::findById($receiver_id);
                $receiver_full_name=''; 

                if($receiver_user->user_type=="seller")
                {
                  $receiver_full_name = get_seller_details($receiver_user->id);
                }
                else
                {
                   $f1_name  = isset($receiver_user->first_name)?$receiver_user->first_name:'';
                   $l1_name  = isset($receiver_user->last_name)?$receiver_user->last_name:'';
                   $receiver_full_name = $f1_name.' '.$l1_name;
                }


                $arr_built_content = ['USER_NAME'     => $receiver_full_name,
                                      'USER'          => "Dispensary ".$user_name,
                                      'APP_NAME'      => config('app.project.name'),
                                      'ADMIN_NAME'    => config('app.project.admin_name'),
                                      'ORDER_NO'      => $obj_order->order_no,
                                      'URL'           => $dispute_url
                                     ];
                $arr_mail_data['email_template_id'] = '155';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = '';
                $arr_mail_data['user']              = Sentinel::findById($receiver_id);
                $this->EmailService->send_mail_section($arr_mail_data);



         /*********************Send Email Notification END*************************/

            return response()->json(['status'=>'success']);
        }
        else
        {
            return response()->json(['status'=>'error']);
        }
    }


}
