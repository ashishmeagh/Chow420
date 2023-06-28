<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProductCommentModel;
use App\Models\ReplyModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\EventModel;

use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;

use Validator;
use Sentinel;

class CommentController extends Controller
{
    public function __construct(
                                 ProductCommentModel $ProductCommentModel,
                                 ProductModel $ProductModel,
                                 ReplyModel $ReplyModel,
                                 GeneralService $GeneralService,
                                 UserModel $UserModel,
                                 EmailService $EmailService,
                                 EventModel $EventModel
                               )
    {
        $this->ProductCommentModel    = $ProductCommentModel;
        $this->ReplyModel             = $ReplyModel;
    	  $this->ProductModel             = $ProductModel;
        $this->GeneralService         = $GeneralService; 
        $this->UserModel              = $UserModel; 

        $this->EmailService           = $EmailService;
        $this->EventModel             = $EventModel;

        $this->module_view_folder     = 'front.Comment';  
    	  $this->page_title               = 'Comment';
        $this->back_path              = url('/');  
        $this->arr_view_data          = [];
    }

    public function create($enc_id)
	{	
        $this->arr_view_data['product_id'] = isset($enc_id)? base64_decode($enc_id) : '';
        $this->arr_view_data['page_title'] = $this->page_title;
        $this->arr_view_data['back_path']  = $this->back_path;

		return view($this->module_view_folder.'.create',$this->arr_view_data);
	}

    //update comment
    public function update(Request $request)
    {
        $form_data = $request->all();
        
         if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;            
        }

        $product_id = isset($form_data['product_id'])?$form_data['product_id']: '';
        $comment       = isset($form_data['comment'])?$form_data['comment']:'';
        $commentid       = isset($form_data['commentid'])?$form_data['commentid']:'';
        $update_data =   ['comment'=> $comment];
        $update_comment = $this->ProductCommentModel->where('id',$commentid)->update($update_data);
        if($update_comment){



              /******************* Notification START* For addiing comment on product **************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = $seller_fname = $seller_lname = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    $user_name    = $user_details->first_name.' '.$user_details->last_name;

                     $user_name ='';   

                     if($user_details->user_type=="buyer")
                     {
                        if($user_details->first_name=="" || $user_details->last_name==""){
                             $user_name ='Buyer';
                        }else{
                             $user_name = $user_details->first_name.' '.$user_details->last_name;
                        }
                     }
                     else if($user_details->user_type=="seller")
                     {
                        if($user_details->first_name=="" || $user_details->last_name==""){
                             $user_name ='Dispensary';
                        }else{
                             $user_name = $user_details->first_name.' '.$user_details->last_name;
                        }
                     }



                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);

                $get_product_name = $this->ProductModel
                                        // ->select('product_name','user_id')
                                       //  ->with(['get_seller_details'])
                                        ->with(['get_seller_details','product_images_details','get_brand_detail','get_seller_additional_details'])  
                                         ->where('id',$product_id)
                                         ->first();


                if(!empty($get_product_name) && isset($get_product_name))
                {
                    $get_product_name = $get_product_name->toArray();
                    $product_name     = isset( $get_product_name['product_name'])?$get_product_name['product_name']:'';
                    $seller_id        = isset( $get_product_name['user_id'])?$get_product_name['user_id']:'';

                    $productname_slug = isset($get_product_name['product_name'])?str_slug($get_product_name['product_name']):'';

                    $productbrand_name_slug = isset($get_product_name['get_brand_detail']['name'])?str_slug($get_product_name['get_brand_detail']['name']):'';

                    $productseller_name_slug = isset($get_product_name['get_seller_additional_details']['business_name'])?str_slug($get_product_name['get_seller_additional_details']['business_name']):'';


                    $seller_fname = isset($get_product_name['get_seller_details']['first_name'])?$get_product_name['get_seller_details']['first_name']:'';
                    $seller_lname = isset($get_product_name['get_seller_details']['last_name'])?$get_product_name['get_seller_details']['last_name']:'';

                }

                $admin_product_view_url = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($product_id);

                /********************Send Notification to Admin(START)***************************/
                    $arr_event                     = [];
                    $arr_event['from_user_id']     = $from_user_id;
                    $arr_event['to_user_id']       = $admin_id;
                    $arr_event['description']      = html_entity_decode('<b>'.$user_name.'</b> has updated the question "<b>'.$comment.'</b>" for the product <a target="_blank" href="'.$admin_product_view_url.'"><b>'.$product_name.'</b></a>');
                    $arr_event['type']             = '';
                    $arr_event['title']            = 'Product Question Updated';

                    $this->GeneralService->save_notification($arr_event);
                /********************Send Notification to Admin(END)******************************/

                /********************Send Mail Notification to Admin(START)***********************/
                  /*  $msg    = html_entity_decode('<b>'.$user_name.'</b> has updated the question "<b>'.$comment.'</b>" for the product <b>'.$product_name.'</b>');
                       
                    $subject     = 'Product Question';*/

                    $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                          'APP_NAME'      => config('app.project.name'),
                                          'PRODUCT_NAME'  => $product_name,
                                          'COMMENT'       => $comment,
                                          'SELLER_NAME'   => $user_name,
                                          //'MESSAGE'       => $msg,
                                          'URL'           => $admin_product_view_url
                                         ];

                    $arr_mail_data['email_template_id'] = '120';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_mail_section($arr_mail_data);         
                /********************Send Mail Notification to Admin(END)*************************/

                $seller_product_view_url = url('/').'/search/product_detail/'.base64_encode($product_id).'/'.$productname_slug.'/'.$productbrand_name_slug.'/'.$productseller_name_slug;

                /*****************Send Notification to Seller (START)**************************/
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $seller_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has updated the question "<b>'.$comment.'</b>" for the product <a target="_blank" href="'.$seller_product_view_url.'"><b>'.$product_name.'</b></a>');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Product Question Updated';
                    $this->GeneralService->save_notification($arr_event);
                /*****************Send Notification to Seller (END)****************************/

                /****************Send Mail Notification to Seller(START)************************/
                   /* $msg    =  html_entity_decode('<b>'.$user_name.'</b> has updated the question "<b>'.$comment.'</b>" for the product <b>'.$product_name.'</b>');
                       
                    $subject     = 'Product Question Updated';*/

                    $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                          'APP_NAME'      => config('app.project.name'),
                                          'BUYER_NAME'    => $user_name,
                                          //'MESSAGE'       => $msg,
                                          'COMMENT'       => $comment,
                                          'PRODUCT_NAME'  => $product_name,
                                          'URL'           => $seller_product_view_url
                                         ];

                    $arr_mail_data['email_template_id'] = '121';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($seller_id);

                    $this->EmailService->send_mail_section($arr_mail_data); 

                /****************Send Mail Notification to Seller(END)**************************/


            /*******************Notification END* for adding comment on product detail page***************/   





            $response['status']      = 'SUCCESS';
            $response['description'] = 'Question udpated successfully.';
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to send question...Please try again.';
        }

        return response()->json($response);

    }


	public function store(Request $request)
	{

    
		$form_data = $request->all();


    


	    	$arr_rules = ['comment' => 'required'];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Form validation failed..Please check all fields..';

            return response()->json($response);
        }

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;   

        }

        $product_id = isset($form_data['product_id'])?$form_data['product_id']: '';
        $comment       = isset($form_data['comment'])?$form_data['comment']:'';


        /******************************************/

            $seller_products =[];
            $user = Sentinel::check();
            if($user!=false)
            {
                $loguser_id          = $user->id;
                if($user->inRole('seller'))
                {    
                   $seller_products  = $this->ProductModel->where('user_id',$loguser_id)->select('id')->get()->toArray();
                }   
            }  

               $seller_product_ids = [];
              if(isset($seller_products) && count($seller_products)>0)
              {
                 foreach($seller_products as $key=>$value)
                 {
                   $seller_product_ids[] = $value['id']; 
                 }
              }


        /******************************************/ 
          if(( $user->inRole('seller') && isset($seller_product_ids)  && (!(in_array($product_id, $seller_product_ids))) ) || $user->inRole('buyer') ) {


            $input_data = [
            				'user_id'        => $user_id,
            				'product_id' 	 => $product_id,
            				'comment' 	     => $comment
            				
        				  ];

                  
            $add_comment = $this->ProductCommentModel->create($input_data);


           if($add_comment)
          {

               /******************* Notification START* For addiing comment on product **************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = $seller_fname = $seller_lname = "";
                $productname_slug = $productbrand_name_slug = $productseller_name_slug='';

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    $user_name    = $user_details->first_name.' '.$user_details->last_name;

                     $user_name ='';   

                     if($user_details->user_type=="buyer")
                     {
                        if($user_details->first_name=="" || $user_details->last_name==""){
                             $user_name ='Buyer';
                        }else{
                             $user_name = $user_details->first_name.' '.$user_details->last_name;
                        }
                     }
                     else if($user_details->user_type=="seller")
                     {
                        if($user_details->first_name=="" || $user_details->last_name==""){
                             $user_name ='Dispensary';
                        }else{
                             $user_name = $user_details->first_name.' '.$user_details->last_name;
                        }
                     }



                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);

                $get_product_name = $this->ProductModel
                                        // ->select('product_name','user_id')
                                         ->with(['get_seller_details','product_images_details','get_brand_detail','get_seller_additional_details'])
                                         ->where('id',$product_id)
                                         ->first();



                if(!empty($get_product_name) && isset($get_product_name))
                {
                    $get_product_name = $get_product_name->toArray();

                    $productname_slug = isset($get_product_name['product_name'])?str_slug($get_product_name['product_name']):'';

                    $productbrand_name_slug = isset($get_product_name['get_brand_detail']['name'])?str_slug($get_product_name['get_brand_detail']['name']):'';

                    $productseller_name_slug = isset($get_product_name['get_seller_additional_details']['business_name'])?str_slug($get_product_name['get_seller_additional_details']['business_name']):'';

                    $product_name     = isset( $get_product_name['product_name'])?$get_product_name['product_name']:'';
                    $seller_id        = isset( $get_product_name['user_id'])?$get_product_name['user_id']:'';

                    $seller_fname = isset($get_product_name['get_seller_details']['first_name'])?$get_product_name['get_seller_details']['first_name']:'';
                    $seller_lname = isset($get_product_name['get_seller_details']['last_name'])?$get_product_name['get_seller_details']['last_name']:'';

                }

                $admin_product_view_url = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($product_id);

                /********************Send Notification to Admin(START)***************************/
                    $arr_event                     = [];
                    $arr_event['from_user_id']     = $from_user_id;
                    $arr_event['to_user_id']       = $admin_id;
                    $arr_event['description']      = html_entity_decode('<b>'.$user_name.'</b> has added the question "<b>'.$comment.'</b>" for the product <a target="_blank" href="'.$admin_product_view_url.'"><b>'.$product_name.'</b></a>');
                    $arr_event['type']             = '';
                    $arr_event['title']            = 'Product Question';

                    $this->GeneralService->save_notification($arr_event);
                /********************Send Notification to Admin(END)******************************/

                /********************Send Mail Notification to Admin(START)***********************/
                   /* $msg    = html_entity_decode('<b>'.$user_name.'</b> has added the question "<b>'.$comment.'</b>" for the product <b>'.$product_name.'</b>');
                       
                    $subject     = 'Product Question';*/

                    $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                          'APP_NAME'      => config('app.project.name'),
                                          'SELLER_NAME'   => $user_name,
                                          'COMMENT'       => $comment,
                                          'PRODUCT_NAME'  => $product_name,
                                          //'MESSAGE'       => $msg,
                                          'URL'           => $admin_product_view_url
                                         ];

                    $arr_mail_data['email_template_id'] = '123';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_notification_mail($arr_mail_data);         
                /********************Send Mail Notification to Admin(END)*************************/

                $seller_product_view_url = url('/').'/search/product_detail/'.base64_encode($product_id).'/'.$productname_slug.'/'.$productbrand_name_slug.'/'.$productseller_name_slug;

                /*****************Send Notification to Seller (START)**************************/
                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $seller_id;
                    $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the question "<b>'.$comment.'</b>" for the product <a target="_blank" href="'.$seller_product_view_url.'"><b>'.$product_name.'</b></a>');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Product Question';
                    $this->GeneralService->save_notification($arr_event);
                /*****************Send Notification to Seller (END)****************************/

                /****************Send Mail Notification to Seller(START)************************/
                   /* $msg    =  html_entity_decode('<b>'.$user_name.'</b> has added the question "<b>'.$comment.'</b>" for the product <b>'.$product_name.'</b>');
                       
                    $subject     = 'Product Question';
*/
                    $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                          'APP_NAME'      => config('app.project.name'),
                                          'COMMENT'       => $comment,
                                          'PRODUCT_NAME'  => $product_name,
                                          'BUYER_NAME'    => $user_name,
                                          'URL'           => $seller_product_view_url
                                         ];

                    $arr_mail_data['email_template_id'] = '122';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($seller_id);

                    $this->EmailService->send_mail_section($arr_mail_data); 

                /****************Send Mail Notification to Seller(END)**************************/


            /*******************Notification END* for adding comment on product detail page***************/   


                 /***********Add Event data*for comment****/
                    $arr_eventdata             = [];
                    $arr_eventdata['user_id']  = $from_user_id;

                    // $arr_eventdata['message']  =  html_entity_decode('<b>'.$user_name.'</b> just commented on the product '.$product_name.'. <div class="clearfix"></div><a target="_blank" href="'.$seller_product_view_url.'" class="viewcls">View</a>');

                       if(!empty($get_product_name['product_images_details']) 
                                         && count($get_product_name['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'])
                                       && $get_product_name['product_images_details'][0]['image']!=''
                                       )
                       {
                          /*$imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];*/

                          //image resize
                          $imgsrc = image_resize('/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'],35,35);


                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }



                     $arr_eventdata['message']  =  html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div><b> Someone </b> just added the question on product '.$product_name.'. <div class="clearfix"></div></div><a target="_blank" href="'.$seller_product_view_url.'" class="viewcls">View</a>');

                    $arr_eventdata['title']    = 'Product Question';       

                      $login_user     = Sentinel::check(); 
                      if(isset($login_user) && $login_user == true && $login_user->inRole('seller') == true)
                      {

                      }else{  

                        $this->EventModel->create($arr_eventdata);
                      }
                /*********end of add event**for comment*******************/





        	$response['status'] 	 = 'SUCCESS';
        	$response['description'] = 'Question added successfully.';
        }//if add comment
        else
        {
        	$response['status']      = 'ERROR';
        	$response['description'] = 'Unable to send question...Please try again.';
        }

      }//if seller or buyer
      else
      {
          $response['status']      = 'ERROR';
          $response['description'] = 'Unable to send question...Please try again later.';
      } 

        return response()->json($response);

	}


    public function update_reply(Request $request)
    {
        $form_data = $request->all();
         $arr_rules = ['reply' => 'required'];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Form validation failed..Please check all fields..';

            return response()->json($response);
        }

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;            
        }

        $comment_id  = isset($form_data['comment_id'])?$form_data['comment_id']: '';
        $reply       = isset($form_data['reply'])?$form_data['reply']:'';
        $replyid  = isset($form_data['replyid'])?$form_data['replyid']: '';

        $updatedata = ['reply'=>$reply];

        $update_reply  = $this->ReplyModel->where('comment_id',$comment_id)->where('id',$replyid)->update($updatedata);
        if($update_reply)
        {


            /******************* Notification START* For addiing reply on comment **************/
                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    $user_name ='';


                    if($user_details->user_type=="buyer"){
                        if($user_details->first_name=="" || $user_details->last_name==""){
                            $user_name = 'Buyer';
                        }else{
                            $user_name    = $user_details->first_name.' '.$user_details->last_name;
                        }
                    }
                    else if($user_details->user_type=="seller")
                    {
                        if($user_details->first_name=="" || $user_details->last_name==""){
                            $user_name = 'Dispensary';
                        }else{
                            $user_name    = $user_details->first_name.' '.$user_details->last_name;
                        }


                    }

                    
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }
                $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);


                $res_comment = $this->ProductCommentModel
                                    ->select('*')
                                    ->with(['user_details'])
                                    ->where('id',$comment_id)
                                    ->first()
                                    ->toArray();

                $buyer_fname = isset($res_comment['user_details']['first_name'])?$res_comment['user_details']['first_name']:'';
                $buyer_lname = isset($res_comment['user_details']['last_name'])?$res_comment['user_details']['last_name']:'';

                $set_buyerfull_name ='';
                if($buyer_fname=="" || $buyer_lname==""){
                     $set_buyerfull_name ='Buyer';
                  
                }else{
                     $set_buyerfull_name = $buyer_fname.' '.$buyer_lname;
                }




                if(!empty($res_comment)){    
                    $product_id = $res_comment['product_id'];

                     $get_product_name = $this->ProductModel
                                             // ->select('product_name','user_id')
                                              ->with(['get_brand_detail','get_seller_additional_details'])
                                              ->where('id',$product_id)
                                              ->first();

                    if(!empty($get_product_name) && isset($get_product_name))
                    {
                        $get_product_name = $get_product_name->toArray();

                        $product_name     = isset( $get_product_name['product_name'])?$get_product_name['product_name']:'';
                        $seller_id        = isset( $get_product_name['user_id'])?$get_product_name['user_id']:'';


                        $productname_slug =  isset( $get_product_name['product_name'])?str_slug($get_product_name['product_name']):'';

                        $brandname_slug =  isset( $get_product_name['get_brand_detail']['name'])?str_slug($get_product_name['get_brand_detail']['name']):'';

                        $sellername_slug =  isset( $get_product_name['get_seller_additional_details']['business_name'])?str_slug($get_product_name['get_seller_additional_details']['business_name']):'';


                     
                        $admin_product_view_url = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($product_id);
                         
                        /*****************Send Notification to Admin (START)**************************/
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $admin_id;
                            $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has updated the answer "<b>'.$reply.'</b>" on question "<b>'.$res_comment['comment'].'</b>" for the product <a target="_blank" href="'.$admin_product_view_url.'"><b>'.$product_name.'</b></a>');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product Question Answer Updated';
                            $this->GeneralService->save_notification($arr_event);
                        /*******************Send Notification to Admin (END)************************/

                        
                        /*****************Send Mail Notification to Admin (START)*********************/
                            /*$msg    = html_entity_decode('<b>'.$user_name.'</b> has updated the answer "<b>'.$reply.'</b>" on question "<b>'.$res_comment['comment'].'</b>" for the product <b>'.$product_name.'</b>');
                       
                            $subject     = 'Product Question Answer Updated';*/

                            $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'SELLER_NAME'   => $user_name,
                                                  'COMMENT'       => $res_comment['comment'],
                                                  'REPLY'         => $reply,
                                                  'PRODUCT_NAME'  => $product_name,
                                                  'URL'           => $admin_product_view_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '124';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($admin_id);

                            $this->EmailService->send_mail_section($arr_mail_data); 

                        /*****************Send Mail Notification to Admin (END)***********************/

                        $buyer_product_view_url = url('/').'/search/product_detail/'.base64_encode($product_id).'/'.$productname_slug.'/'.$brandname_slug.'/'.$sellername_slug;

                        /*****************Send Notification to Buyer (START)**************************/
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $res_comment['user_id'];
                            $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has updated the answer "<b>'.$reply.'</b>" on question "<b>'.$res_comment['comment'].'</b>" for the product <a target="_blank" href="'.$buyer_product_view_url.'"><b>'.$product_name.'</b></a>');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product Question Answer Updated';
                            $this->GeneralService->save_notification($arr_event);
                        /*****************Send Notification to Buyer (END)**************************/

                        /*****************Send Mail Notification to Buyer (START)*********************/
                           /* $msg    =  html_entity_decode('<b>'.$user_name.'</b> has updated the answer "<b>'.$reply.'</b>" on question "<b>'.$res_comment['comment'].'</b>" for the product <b>'.$product_name.'</b>');
                       
                            $subject     = 'Product Question Answer Updated';*/

                            $arr_built_content = [
                                                  //'USER_NAME'     => $buyer_fname.' '.$buyer_lname,
                                                  'USER_NAME'     => $set_buyerfull_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'SELLER_NAME'   => $user_name,
                                                  //'MESSAGE'       => $msg,
                                                  'COMMENT'       => $res_comment['comment'],
                                                  'REPLY'         => $reply,
                                                  'PRODUCT_NAME'  => $product_name, 
                                                  'URL'           => $buyer_product_view_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '125';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($res_comment['user_id']);


                            $this->EmailService->send_mail_section($arr_mail_data); 

                        /*****************Send Mail Notification to Buyer (END)***********************/


                    }    
               }
            /*******************Notification END* for adding reply on comment for product detail page*******/   






             $response['status']      = 'SUCCESS';
            $response['description'] = 'Answer updated successfully.';
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to update answer...Please try again.';
        }

        return response()->json($response);


        
    }



    public function send_reply(Request $request)
    {

        $form_data = $request->all();

        $arr_rules = ['reply' => 'required'];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Form validation failed..Please check all fields..';

            return response()->json($response);
        }

        if(Sentinel::check())
        {
            $user_id = Sentinel::check()->id;            
        }

        $comment_id  = isset($form_data['comment_id'])?$form_data['comment_id']: '';
        $reply       = isset($form_data['reply'])?$form_data['reply']:'';
        $input_data  = [
                        'user_id'        => $user_id,
                        'comment_id'     => $comment_id,
                        'reply'          => $reply
                      ];
        $send_reply  = $this->ReplyModel->create($input_data);

        if($send_reply)
        {
            /******************* Notification START* For addiing reply on comment **************/
                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    $user_name ='';


                    if($user_details->user_type=="buyer"){
                        if($user_details->first_name=="" || $user_details->last_name==""){
                            $user_name = 'Buyer';
                        }else{
                            $user_name    = $user_details->first_name.' '.$user_details->last_name;
                        }
                    }
                    else if($user_details->user_type=="seller")
                    {
                        if($user_details->first_name=="" || $user_details->last_name==""){
                            $user_name = 'Dispensary';
                        }else{
                            $user_name    = $user_details->first_name.' '.$user_details->last_name;
                        }


                    }

                    
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }
                $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);


                $res_comment = $this->ProductCommentModel
                                    ->select('*')
                                    ->with(['user_details'])
                                    ->where('id',$comment_id)
                                    ->first()
                                    ->toArray();

                $buyer_fname = isset($res_comment['user_details']['first_name'])?$res_comment['user_details']['first_name']:'';
                $buyer_lname = isset($res_comment['user_details']['last_name'])?$res_comment['user_details']['last_name']:'';

                $set_buyerfull_name ='';
                if($buyer_fname=="" || $buyer_lname==""){
                    $set_buyerfull_name ='Buyer';
                }else{
                    $set_buyerfull_name = $buyer_fname.' '.$buyer_lname;
                }




                if(!empty($res_comment)){    
                    $product_id = $res_comment['product_id'];

                     $get_product_name = $this->ProductModel
                                             // ->select('product_name','user_id')
                                              ->with(['get_brand_detail','get_seller_additional_details'])
                                              ->where('id',$product_id)
                                              ->first();

                    if(!empty($get_product_name) && isset($get_product_name))
                    {
                        $get_product_name = $get_product_name->toArray();
                       
                        $product_name     = isset( $get_product_name['product_name'])?$get_product_name['product_name']:'';
                        $seller_id        = isset( $get_product_name['user_id'])?$get_product_name['user_id']:'';

                        $productname_slug =  isset( $get_product_name['product_name'])?str_slug($get_product_name['product_name']):'';

                        $brandname_slug =  isset( $get_product_name['get_brand_detail']['name'])?str_slug($get_product_name['get_brand_detail']['name']):'';

                        $sellername_slug =  isset( $get_product_name['get_seller_additional_details']['business_name'])?str_slug($get_product_name['get_seller_additional_details']['business_name']):'';


                        /*if(isset($seller_id))
                        {
                            $get_seller_info = $this->UserModel->where('id',$seller_id)->first()->toArray();
                            if(!empty($get_seller_info))
                            {
                                $email = $get_seller_info['email'];
                            }
                        }*/

                        $admin_product_view_url = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($product_id);
                         
                        /*****************Send Notification to Admin (START)**************************/
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $admin_id;
                            $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the answer "<b>'.$reply.'</b>" on question "<b>'.$res_comment['comment'].'</b>" for the product <a target="_blank" href="'.$admin_product_view_url.'"><b>'.$product_name.'</b></a>');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product Question Answer';
                            $this->GeneralService->save_notification($arr_event);
                        /*******************Send Notification to Admin (END)************************/

                        
                        /*****************Send Mail Notification to Admin (START)*********************/
                           /* $msg    = html_entity_decode('<b>'.$user_name.'</b> has added the answer "<b>'.$reply.'</b>" on question "<b>'.$res_comment['comment'].'</b>" for the product <b>'.$product_name.'</b>');
                       
                            $subject     = 'Product Question Answer';*/

                            $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'SELLER_NAME'   => $user_name,
                                                  'COMMENT'       => $res_comment['comment'],
                                                  'REPLY'         => $reply,
                                                  'PRODUCT_NAME'  => $product_name, 
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $admin_product_view_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '126';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($admin_id);

                            $this->EmailService->send_mail_section($arr_mail_data); 

                        /*****************Send Mail Notification to Admin (END)***********************/

                        $buyer_product_view_url = url('/').'/search/product_detail/'.base64_encode($product_id).'/'.$productname_slug.'/'.$brandname_slug.'/'.$sellername_slug;

                        /*****************Send Notification to Buyer (START)**************************/
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $res_comment['user_id'];
                            $arr_event['description']  = html_entity_decode('<b>'.$user_name.'</b> has added the answer "<b>'.$reply.'</b>" on question "<b>'.$res_comment['comment'].'</b>" for the product <a target="_blank" href="'.$buyer_product_view_url.'"><b>'.$product_name.'</b></a>');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product Question Answer';
                            $this->GeneralService->save_notification($arr_event);
                        /*****************Send Notification to Buyer (END)**************************/

                        /*****************Send Mail Notification to Buyer (START)*********************/
                            /*$msg    =  html_entity_decode('<b>'.$user_name.'</b> has added the answer "<b>'.$reply.'</b>" on question "<b>'.$res_comment['comment'].'</b>" for the product <b>'.$product_name.'</b>');
                       
                            $subject     = 'Product Question Answer';*/

                            $arr_built_content = [
                                                  //'USER_NAME'     => $buyer_fname.' '.$buyer_lname,
                                                  'USER_NAME'     => $set_buyerfull_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'SELLER_NAME'   => $user_name,
                                                  'REPLY'         => $reply,
                                                  'COMMENT'       => $res_comment['comment'],
                                                  'PRODUCT_NAME'  => $product_name,
                                                  'URL'           => $buyer_product_view_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '127';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($res_comment['user_id']);


                            $this->EmailService->send_mail_section($arr_mail_data); 

                        /*****************Send Mail Notification to Buyer (END)***********************/



                         /***********Add Event data*for reply****/
                           /* $arr_eventdata             = [];
                            $arr_eventdata['user_id']  = $from_user_id;
                            $arr_eventdata['message']  =  html_entity_decode('<b>'.$user_name.'</b> has added the reply "<b>'.$reply.'</b>" on comment <b>'.$res_comment['comment'].'</b> for the product <a target="_blank" href="'.$buyer_product_view_url.'"><b>'.$product_name.'</b></a>');
                            $arr_eventdata['title']    = 'Product Comment Reply';                       
                            $this->EventModel->create($arr_eventdata);*/
                        /*********end of add event**for reply*******************/


                    }//if get product name    
               }//if res comment
            /*******************Notification END* for adding reply on comment for product detail page*******/   

            $response['status']      = 'SUCCESS';
            $response['description'] = 'Answer send successfully.';
        }
        else
        {
            $response['status']      = 'ERROR';
            $response['description'] = 'Unable to send answer...Please try again.';
        }

        return response()->json($response);
       
    }


}
