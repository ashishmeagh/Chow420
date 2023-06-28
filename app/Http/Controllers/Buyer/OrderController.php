<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\CountriesModel;
use App\Common\Services\GeneralService;
use App\Models\BuyerModel;
use App\Models\OrderModel;
use App\Models\ProductInventoryModel;
use App\Models\OrderProductModel;
use App\Models\DisputeModel;
use App\Models\TransactionModel;
use App\Models\SellerModel;
use App\Models\SiteSettingModel;



use App\Common\Services\EmailService;

use Datatables;

use Validator;
use Flash;
use Sentinel;
use Hash;
use DB;
use Carbon\Carbon;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
 
class OrderController extends Controller
{ 

    public function __construct(
                                
                                UserModel $user,
                                CountriesModel $CountriesModel,
                                BuyerModel $BuyerModel,
                                OrderModel $OrderModel,
                                GeneralService $GeneralService,
                                ActivityLogsModel $activity_logs,
                                ProductInventoryModel $ProductInventoryModel,
                                OrderProductModel $OrderProductModel,
                                DisputeModel $DisputeModel,
                                TransactionModel $TransactionModel,
                                EmailService $EmailService,
                                SellerModel $SellerModel,
                                SiteSettingModel $SiteSettingModel
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;
        $this->ActivityLogsModel  = $activity_logs;
        $this->CountriesModel     = $CountriesModel;
        $this->GeneralService     = $GeneralService;
        $this->BuyerModel         = $BuyerModel;
        $this->ProductInventoryModel = $ProductInventoryModel;  
        $this->OrderProductModel  = $OrderProductModel;  
        $this->OrderModel         = $OrderModel;  
        $this->DisputeModel       = $DisputeModel;  
        $this->TransactionModel   = $TransactionModel;
        $this->SiteSettingModel   = $SiteSettingModel;


        $this->EmailService       = $EmailService;
        $this->SellerModel        = $SellerModel;
        
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        $this->product_img_public_path = url('/').config('app.project.img_path.product_images');
        $this->product_img_base_path   = base_path().config('app.project.img_path.product_images');

        $this->module_title       = "Order";
        $this->module_view_folder = "buyer/order";

        $this->id_proof_public_path = url('/').config('app.project.id_proof');
        $this->id_proof_base_path   = base_path().config('app.project.id_proof');
        
        $this->module_icon        = "fa-cogs";
    }


    public function index(Request $request)
    {
        $buyer_arr = $seller_arr = []; 

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

       // $countries_arr   = $this->CountriesModel->get()->toArray();


        if($user_details->inRole('buyer'))
        {
            $order_obj = $this->OrderModel->with('address_details.state_details','transaction_details','dispute_details') 
                ->where('buyer_id',$user_details->id)                      
                ->get(); 
            if($order_obj)
            {
                $order_arr = $order_obj->toArray();
            }
        }

        $apppend_data = url()->current();

        if($request->has('page'))
        {   
            $pageStart = $request->input('page'); 
        }
        else
        {
            $pageStart = 1; 
        }
        
        $total_results = count($order_arr);


       // $paginator = $this->GeneralService->get_pagination_data($order_arr, $pageStart, 9 , $apppend_data);
        $paginator = $this->get_pagination_data($order_arr, $pageStart, 9 , $apppend_data);


        if($paginator)
        {
            $pagination_links    =  $paginator;  
            $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 

        }   

        if($paginator)
        {
        
            $arr_user_pagination            =  $paginator;  
            $arr_product                    =  $paginator->items();
            $arr_data                       = $arr_product;
            $arr_view_data['arr_data']      = $arr_data;
            $arr_view_data['total_results'] = $total_results;
            $arr_pagination = $paginator;            
            $this->arr_view_data['order_arr'] =  $arr_data;
            $this->arr_view_data['arr_pagination'] = $arr_pagination;
            $this->arr_view_data['total_results'] = $total_results;
            $this->arr_view_data['page_title'] = $this->module_title;            
            return view($this->module_view_folder.'.index',$this->arr_view_data);
            
        }
    }



    public function get_myorders(Request $request)
    {  
        $loggedInUserId = 0;
        $user = Sentinel::check();

        if($user)
        {
            $loggedInUserId = $user->id;
        }
       
       
        $transaction_table         = $this->TransactionModel->getTable();
        $prefixed_transaction_tbl  = DB::getTablePrefix().$this->TransactionModel->getTable();

        $user_tbl_name              = $this->UserModel->getTable();
        $prefixed_user_tbl          = DB::getTablePrefix().$this->UserModel->getTable();

        $order_tbl_name              = $this->OrderModel->getTable();
        $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_tbl_name      = $this->OrderProductModel->getTable();
        $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();


        $dispute_tbl_name      = $this->DisputeModel->getTable();
        $prefixed_dispute_tbl  = DB::getTablePrefix().$this->DisputeModel->getTable();


        $seller_tbl_name              = $this->SellerModel->getTable();
        $prefixed_seller_tbl          = DB::getTablePrefix().$this->SellerModel->getTable();

        $obj_qutoes = DB::table($order_tbl_name)
                                ->select(DB::raw($order_tbl_name.".*,"
                                                .$dispute_tbl_name.'.dispute_status,'
                                                .$dispute_tbl_name.'.dispute_reason,'
                                                .$dispute_tbl_name.'.is_dispute_finalized,'
                                                 .$prefixed_transaction_tbl.".transaction_status,"
                                                 .$prefixed_seller_tbl.".business_name as seller_business_name,"
                                                 ."CONCAT(".$prefixed_user_tbl.".first_name,' ',"
                                                    .$prefixed_user_tbl.".last_name) as seller_name"
                                               ))

                                ->leftJoin($prefixed_dispute_tbl,$prefixed_dispute_tbl.'.order_id',$prefixed_order_tbl.'.id')
                                ->leftjoin($prefixed_transaction_tbl,$prefixed_transaction_tbl.'.order_no','=',$order_tbl_name.'.order_no')

                                ->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$order_tbl_name.'.seller_id')
                                 ->leftjoin($prefixed_seller_tbl,$prefixed_seller_tbl.'.user_id','=',$order_tbl_name.'.seller_id')

                                ->where($order_tbl_name.'.buyer_id',$loggedInUserId)
                                ->orderBy($order_tbl_name.".id",'DESC');
                                //->get();


           /************************************* Search Conditions *************************************************/                     
           $arr_search_column = $request->input('column_filter');


             if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no'] != '')
            {
                $search_order_no   = $arr_search_column['q_order_no'];
                $obj_qutoes        = $obj_qutoes->where($prefixed_order_tbl.'.order_no','LIKE', '%'.$search_order_no.'%');
            }
             if(isset($arr_search_column['q_order_status']) && $arr_search_column['q_order_status'] != '')
            {
                $search_order_status   = $arr_search_column['q_order_status'];
                $obj_qutoes  = $obj_qutoes->where($prefixed_order_tbl.'.order_status','LIKE', '%'.$search_order_status.'%');
            }
           // if(isset($arr_search_column['q_order_date']) && $arr_search_column['q_order_date'] != '')
           //  {
           //      $search_order_date   = $arr_search_column['q_order_date'];
           //      $obj_qutoes  = $obj_qutoes->where($prefixed_order_tbl.'.date(created_at)','LIKE', '%'.$search_order_date.'%');
           //  }
             if(isset($arr_search_column['q_price']) && $arr_search_column['q_price'] != '')
            {
                $search_amount    = $arr_search_column['q_price'];
                $obj_qutoes  = $obj_qutoes->where($prefixed_order_tbl.'.total_amount','LIKE', '%'.$search_amount.'%');
            }

           if(isset($arr_search_column['q_seller_name']) && $arr_search_column['q_seller_name'] != '')
            {
                $search_sellername    = $arr_search_column['q_seller_name'];
                // $obj_qutoes  = $obj_qutoes->where([[$prefixed_user_tbl.'.first_name','LIKE', '%'.$search_sellername.'%'],[$order_tbl_name.'.buyer_id',$loggedInUserId]])
                //                           ->orWhere([[$prefixed_user_tbl.'.last_name','LIKE', '%'.$search_sellername.'%'],[$order_tbl_name.'.buyer_id',$loggedInUserId]]);
                  $obj_qutoes  = $obj_qutoes->where([[$prefixed_seller_tbl.'.business_name','LIKE', '%'.$search_sellername.'%'],[$order_tbl_name.'.buyer_id',$loggedInUserId]]);                          
            }
            if(isset($arr_search_column['q_buyerageflag']) && $arr_search_column['q_buyerageflag']!='')
            {
                 $search_buyerageflag = $arr_search_column['q_buyerageflag'];
                 $obj_qutoes  = $obj_qutoes->where($prefixed_order_tbl.'.buyer_age_restrictionflag','LIKE', '%'.$search_buyerageflag.'%');
            }

 
 

        $current_context = $this;

        $json_result  = Datatables::of($obj_qutoes);
        
        $json_result  = $json_result->editColumn('date',function($data) use ($current_context)
                        {
                          //  return us_date_format($data->created_at);
                            $created_at = explode(" ", $data->created_at);
                            $date = date("d M Y",strtotime($created_at[0]));
                            return $date;

                        })
                         ->editColumn('time',function($data) use ($current_context)
                        {
                          //  return us_date_format($data->created_at);
                            $created_at = explode(" ", $data->created_at);
                            $time = date('g:i A', strtotime($created_at[1]));
                            return $time;

                        }) 
                       
                        ->editColumn('order_no',function($data) use ($current_context)
                        {
                            $orderview_href =  url('/').'/buyer/order/view/'.base64_encode($data->id);

                            $build_orderview_action = '<a href="'.$orderview_href.'" class="btn-view" title="View order detail">
                             '.$data->order_no.'
                            </a>';
                            return $build_orderview_action;

                        })  
                        ->editColumn('order_status',function($data) use ($current_context)
                        {

                            if ($data->order_status == 0) {
                                return 'Cancelled';
                            }
                            elseif ($data->order_status == 1) {
                                return 'Delivered';
                            }
                            else if($data->order_status==2){

                                if($data->buyer_age_restrictionflag==1)
                                {
                                     return 'Pending Age Verification';
                                }
                                else
                                {
                                     return 'Ongoing';
                                }    

                               
                            }
                            else if($data->order_status==3){
                                return 'Shipped';
                            }
                            else if($data->order_status==4){
                                return 'Ongoing';
                            }


                        })
                         ->editColumn('buyer_age_restrictionflag',function($data) use ($current_context)
                        {
                            if($data->buyer_age_restrictionflag>0)
                            {
                               return "Yes"; 
                            }else{
                               return "No"; 
                            }
                        })
                        ->editColumn('total_amount',function($data) use ($current_context)
                        {
                            if($data->total_amount>0) {

                                $final_amount = $data->total_amount;

                                if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!=''  && isset($data->seller_discount_amt)  && $data->seller_discount_amt!='') {

                                    $final_amount = (float)$final_amount - (float)$data->seller_discount_amt; 
                                }

                                if (isset($data->delivery_cost) && $data->delivery_cost != null) {

                                    $final_amount = (float)$final_amount + (float)$data->delivery_cost;
                                }

                                 if (isset($data->tax) && $data->tax != null) {

                                    $final_amount = (float)$final_amount + (float)$data->tax;
                                }

                                return $final_amount;
     
                            }else{
                               return "-"; 
                            }
                        })

                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                        
                            
                            $view_href =  url('/').'/buyer/order/view/'.base64_encode($data->id);

                            $build_view_action = '<a href="'.$view_href.'" class="eye-actn btn-view"> View Order </a>'; 

                            $build_note_action = '<a href="javascript:void(0);" onclick="order_note(this)" data-order_note="'.$data->note.'" class="eye-actn btn-view">  View Order Note </a>'; 

                            $review_href = $build_review_action = "";

                               /*we did this for only showing products of current order for giving review */
                              //$review_href = url('/').'/buyer/review-ratings/'.base64_encode($data->id);

                              $review_href = url('/').'/buyer/review-ratings';
                              
                              if($data->order_status==1){
                                  $build_review_action = '<a href="'.$review_href.'" class="btns-approved"> Review Order</a>';
                              }

                            



/*                            $total_reviews_of_order = $total_questions_and_answers = 0;

                            $total_reviews_of_order      = get_total_reviews_of_order($data->id);
                            $total_questions_and_answers = get_total_ques_ans_of_order($data->id);

                            if(isset($total_reviews_of_order) && $total_reviews_of_order >0)
                            {    
                             $total_reviews_of_order = '<span class="badge badge-pill badge-secondary" title="Reviews">'.$total_reviews_of_order.'</span>';
                            }

                            if(isset($total_questions_and_answers) && $total_questions_and_answers >0)
                            {    
                             $total_questions_and_answers = '<span class="badge badge-pill badge-primary" title="Quetion and Answers">'.$total_questions_and_answers.'</span>';
                            }
*/
                            $build_viewdispute_action='';

                             // if(($data->dispute_reason==null || $data->dispute_reason=="") && $data->order_status==1)
                            if(($data->dispute_reason==null || $data->dispute_reason=="") && ($data->order_status==3 || $data->order_status==1))    
                             {
                                   
                               $build_viewdispute_action = '<a href="javascript:void(0)" onclick="raiseDispute($(this))" data-order_id = "'.$data->id.'"  data-order_no = "'.$data->order_no.'" class="btns-just-opend">Raise Dispute</a>';
                             }
                             elseif($data->dispute_status=='0' && $data->is_dispute_finalized=='0'){
                                   
                               $build_viewdispute_action = '<a href="javascript:void(0)" class="btns-pending">Dispute Pending</a>';
                             } 
                             elseif($data->dispute_status==1 && $data->dispute_reason!="" && $data->is_dispute_finalized=='0'){
                                    $url_dispute = url('/').'/buyer/dispute/'.base64_encode($data->id); 
                                    $build_viewdispute_action = '<a href="'.$url_dispute.'" class="btns-approved">Dispute Approved</a>';
                             }
                             elseif($data->dispute_status==1 && $data->dispute_reason!="" && $data->is_dispute_finalized==1){
                                    $url_dispute = url('/').'/buyer/dispute/'.base64_encode($data->id); 
                                    $build_viewdispute_action = '<a href="'.$url_dispute.'" class="btns-approved">Dispute Closed</a>';
                             }
                             elseif($data->dispute_status==2){
                                    $build_viewdispute_action = '<a href="#" class="btns-removes">Dispute Rejected</a>';
                             }

                           /* return $build_action = $build_view_action.' '.$build_viewdispute_action.' '.$total_reviews_of_order.' '.$total_questions_and_answers;*/
                            $build_action = $build_view_action.' '.$build_review_action.' '.$build_viewdispute_action;

                            if (isset($data->note) && $data->note != '') {
                                $build_action = $build_action.' '.$build_note_action;
                            }

                            return $build_action;
                        });
        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
    }



 public function get_pagination_data($arr_data = [], $pageStart = 1, $per_page = 0, $apppend_data = [])
    {
        
        $perPage  = $per_page; /* Indicates how many to Record to paginate */
        $offSet   = ($pageStart * $perPage) - $perPage; /* Start displaying Records from this No.;*/        
        $count    = count($arr_data);
        /* Get only the Records you need using array_slice */
        $itemsForCurrentPage = array_slice($arr_data, $offSet, $perPage, true);

        /* Pagination to an Array() */
         $paginator =  new LengthAwarePaginator($itemsForCurrentPage, $count, $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));      
    
       

        $paginator->appends($apppend_data); /* Appends all input parameter to Links */
        
        return $paginator;
    }
 
    public function view($order_id = '')
    {   

        $buyer_arr = $seller_arr = $tracking_info = $lable_info = [];
        $user_details = false;
        $user_details = Sentinel::getUser();        

        $order_id   = base64_decode($order_id); 

        if($user_details->inRole('buyer'))
        {
            // $order_obj = $this->OrderModel->with('buyer_details','seller_details','address_details.state_details','order_product_details.product_details.product_images_details','transaction_details')->where('id',$order_id)->groupBy('order_no')->get();

            // $order_obj = $this->OrderModel->with('buyer_details','seller_details','address_details.state_details','order_product_details.product_details.product_images_details','transaction_details')
            // ->where('order_no',$order_id)->get();


             $order_obj = $this->OrderModel->with('buyer_details','seller_details','address_details.state_details','address_details.country_details','address_details.billing_state_details','address_details.billing_country_details',
                'order_product_details.product_details.product_images_details','order_product_details.product_details.age_restriction_detail','transaction_details','seller_details.seller_detail',
                 'order_product_details.age_restriction_detail'
              )
            ->where('id',$order_id)->get();

            if($order_obj)
            {
                $order_details_arr    = $order_obj->toArray();
            }


             if(isset($order_details_arr[0]['tracking_no']) && $order_details_arr[0]['tracking_no']!=null && $order_details_arr[0]['shipping_company_name']!="" && ($order_details_arr[0]['order_status']== 3 || $order_details_arr[0]['order_status'] == 1))
            {
               $tracking_info = $this->track_order($order_details_arr[0]['tracking_no'],$order_details_arr[0]['shipping_company_name']);

                if($order_details_arr[0]['order_status'] == 1 && isset($tracking_info) && !empty($tracking_info) && isset($tracking_info['status_code']) && $tracking_info['status_code']=="DE" && isset($tracking_info['status_description']) && $tracking_info['status_description']=="Delivered")
                {
                   $lable_info   =  $this->generate_lable($order_details_arr);
                } //if delivered and tracking info then generate label 

            }//if company and tracking no and shipped or delivered 

            

        }

        $this->arr_view_data['id_proof_public_path'] = $this->id_proof_public_path;
        $this->arr_view_data['product_img_path']     = $this->product_img_public_path;
        $this->arr_view_data['order_details_arr']    = $order_details_arr;
        $this->arr_view_data['tracking_info']        = $tracking_info;
        $this->arr_view_data['lable_info']           = $lable_info;
        $this->arr_view_data['page_title']           = 'Order Details';
        
        return view($this->module_view_folder.'.view',$this->arr_view_data);
    }


    public function cancel(Request $request)
    {

        $user_id = 0;
        $result  = 1; 
        
        $form_data = $request->all();

        $user = Sentinel::check();


        if(isset($user))
        {
           $user_id = $user->id; 
        }

        $order_id       = $form_data['order_id'];
        $order_cancel_reason       = $form_data['order_cancel_reason'];

        $order_details  = $this->OrderModel->with('order_product_details')->where('id',$order_id)->first()->toArray();
        $product_ids    = array_column($order_details['order_product_details'], 'product_id');
         

        if(isset($product_ids) && count($product_ids)>0)
        {
            foreach($product_ids as $product_id)
            { 
                $order_product_quantity    = $this->OrderProductModel->where('product_id',$product_id)->where('order_id',$order_id)->select('quantity')->first()->toArray();

                $order_product_quantity    = $order_product_quantity['quantity'];

                $existing_product_quantity = $this->ProductInventoryModel->where('product_id',$product_id)->select('remaining_stock')->first()->toArray();

                $product_new_quantity      = $existing_product_quantity['remaining_stock'] + $order_product_quantity;


                $update_quantity           = $this->ProductInventoryModel->where('product_id',$product_id)->update(array('remaining_stock'=>$product_new_quantity));

            }
        }

        //  $result   = $this->OrderModel->where('order_no',$order_details['order_no'])->update(array('order_status' => '0'));
        $data =[];
        $cancel_date = Carbon::now();
        $cancel_date = $cancel_date->toDateTimeString();
        // dd($cancel_date);
        $data = array(
            'order_status' => "0",
            'refund_status' => "0",
            'order_cancel_reason' => $order_cancel_reason,
            'order_cancel_time' => $cancel_date
        );
        $result   = $this->OrderModel->where('id',$order_details['id'])->update($data);
        $cancel_cashack = cancel_cashback($order_details['order_no']);


        if($result && $update_quantity)
        { 
            /*******************Send Notification to Admin (START)*************************/
                $admin_panel_order_url = url('/').'/'.config('app.project.admin_panel_slug').'/order';

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    
                    $buyer_fname = isset($user_details->first_name)?$user_details->first_name:'';
                    $buyer_lname = isset($user_details->last_name)?$user_details->last_name:'';

                    $user_name   = $buyer_fname.' '.$buyer_lname;
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
                $arr_event['description']  = html_entity_decode('Buyer <b>'.$user_name.'</b> has cancelled the order with order no. : <a target="_blank" href="'.$admin_panel_order_url.'"><b>'. $order_details['order_no'].'</b></a>.'); 
                $arr_event['type']         = '';
                $arr_event['title']        = 'Order '. $order_details['order_no'].' Cancelled';

                $this->GeneralService->save_notification($arr_event);

            /*******************Send Notification to Admin (END)***************************/


            /*******************Send Mail Notification to Admin (START)****************************/
                $msg    = html_entity_decode('Buyer <b>'.$user_name.'</b> has cancelled the order with order no. : <b>'. $order_details['order_no'].'</b>.'); 
                       
                $subject     = 'Order '. $order_details['order_no'].' Cancelled';

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      'MESSAGE'       => $msg,
                                      'URL'           => $admin_panel_order_url
                                     ];

                $arr_mail_data['email_template_id'] = '31';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $subject;
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_notification_mail($arr_mail_data); 

            /*******************Send Mail Notification to Admin (END)******************************/


            /********************Send Notification to Seller (START)*************************/
              //  $arr_seller                = $this->OrderModel->select('seller_id')->where('order_no',$order_details['order_no'])->get()->toArray(); 

                $seller_panel_order_url = url('/').'/seller/order/view/'.base64_encode($order_details['id']);

                $arr_seller                = $this->OrderModel
                                                  ->select('seller_id')
                                                  ->with(['seller_details'])
                                                  ->where('id',$order_details['id'])
                                                  ->first();
                 
                if(!empty($arr_seller))
                {
                    $arr_seller = $arr_seller->toArray();
                }

                if(isset($arr_seller) && count($arr_seller)>0 && (!empty($arr_seller)))
                {   
                    $seller_id    = $arr_seller['seller_id'];
                    $seller_fname = isset($arr_seller['seller_details']['first_name'])?$arr_seller['seller_details']['first_name']:'';
                    $seller_lname = isset($arr_seller['seller_details']['last_name'])?$arr_seller['seller_details']['last_name']:'';

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $seller_id;
                    $arr_event['description']  = html_entity_decode('Buyer <b>'.$user_name.'</b> has cancelled the order with order no : <a target="_blank" href="'.$seller_panel_order_url.'"><b>'.$order_details['order_no'].'</b></a>.');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Order '.$order_details['order_no'].' Cancelled';
                   
                    $this->GeneralService->save_notification($arr_event);
                }

           
            /******************* Send Notification to Seller (END) ***************************/

            /***************Send Mail Notification to Seller (START)**************************/
                $msg    = html_entity_decode('Buyer <b>'.$user_name.'</b> has cancelled the order with order no : <b>'.$order_details['order_no'].'</b>.');
                       
                $subject     = 'Order '.$order_details['order_no'].' Cancelled';

                $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                      'APP_NAME'      => config('app.project.name'),
                                      'MESSAGE'       => $msg,
                                      'URL'           => $seller_panel_order_url
                                     ];

                $arr_mail_data['email_template_id'] = '31';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $subject;
                $arr_mail_data['user']              = Sentinel::findById($seller_id);

                $this->EmailService->send_notification_mail($arr_mail_data);  
            /***************Send Mail Notification to Seller (END)****************************/


            /******************* Send Notification to Buyer (START)  *************************/
                $buyer_panel_order_url = url('/').'/buyer/order/view/'.base64_encode($order_details['id']);

                $from_user_id = 0;
                $admin_id     = 0;
                // $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    // $user_name    = $user_details->user_name;
                    $to_user_id   = $user_details->id; 
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $from_user_id = $admin_obj->user_id;
                }


                $arr_event                 = [];
                $arr_event['from_user_id'] = $from_user_id;
                $arr_event['to_user_id']   = $to_user_id;
                $arr_event['description']  = html_entity_decode('Your order with order no. <a target="_blank" href="'.$buyer_panel_order_url.'"><b>'.$order_details['order_no'].'</b></a> has been successfully cancelled');
                $arr_event['type']         = '';
                $arr_event['title']        = 'Order Cancelled';

                $this->GeneralService->save_notification($arr_event);

            /*******************Send Notification to Buyer (END) ***************************/

            /*****************Send Mail Notification to Buyer(START)************************/
                $msg    = html_entity_decode('Your order with order no. <b>'.$order_details['order_no'].'</b> has been successfully cancelled');
                       
                $subject     = 'Order '.$order_details['order_no'].' Cancelled';

                $arr_built_content = ['USER_NAME'     => $user_name,
                                      'APP_NAME'      => config('app.project.name'),
                                      'MESSAGE'       => $msg,
                                      'URL'           => $buyer_panel_order_url
                                     ];

                $arr_mail_data['email_template_id'] = '31';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $subject;
                $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                $this->EmailService->send_notification_mail($arr_mail_data);  

            /*****************Send Mail Notification to Buyer(END)**************************/
       
            $response['status']      = 'SUCCESS';
            $response['description'] = 'Order cancelled successfully'; 
            return response()->json($response);
        }
   
    }

    public function track_order($tracking_no="",$shipping_company_name="")
    {
        $curl = curl_init();
        $api_key = "";
        $api_key_details = $this->SiteSettingModel->first()->sandbox_tracking_api_key; 
        if(!empty($api_key_details))
        {
         $api_key = $api_key_details;
        } 


        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.shipengine.com/v1/tracking?carrier_code=".$shipping_company_name."&tracking_number=".$tracking_no,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Host: api.shipengine.com",
            "API-Key: ".$api_key
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response,true);
    }

    public function generate_lable($order_arr="")
    {
       $buyer_details   = $seller_details = [];
       $api_key         = "";
       $api_key_details = $this->SiteSettingModel->first()->sandbox_tracking_api_key; 
       if(!empty($api_key_details))
       {
         $api_key       = $api_key_details;
       }


       if(isset($order_arr) && sizeof($order_arr)>0)
       { 
          $buyer_country_code = $this->CountriesModel->where('id',$order_arr[0]['buyer_details']['country'])->first()->sortname;
          $seller_country_code = $this->CountriesModel->where('id',$order_arr[0]['seller_details']['country'])->first()->sortname;
          $seller_business_name = $this->SellerModel->where('user_id',$order_arr[0]['seller_details']['id'])->first()->business_name;


          $buyer_details = array('name'=>$order_arr[0]['buyer_details']['first_name']." ".$order_arr[0]['buyer_details']['last_name'],'phone'=>$order_arr[0]['buyer_details']['phone'],'street_address'=>$order_arr[0]['buyer_details']['street_address'],'city'=>$order_arr[0]['buyer_details']['city'],'postal_code'=>$order_arr[0]['buyer_details']['zipcode'],'country_code'=>$buyer_country_code);

          $seller_details = array('name'=>$order_arr[0]['seller_details']['first_name']." ".$order_arr[0]['seller_details']['last_name'],'phone'=>$order_arr[0]['seller_details']['phone'],'street_address1'=>$order_arr[0]['seller_details']['street_address'],'street_address2'=>$order_arr[0]['seller_details']['billing_street_address'],'city'=>$order_arr[0]['seller_details']['city'],'postal_code'=>$order_arr[0]['seller_details']['zipcode'],'country_code'=>$seller_country_code,'business_name'=>$seller_business_name);

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.shipengine.com/v1/labels",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n  \"shipment\": {\n    \"service_code\": \"ups_ground\",\n    \"ship_to\": {\n      \"name\": \"".$buyer_details['name']."\",\n      \"address_line1\": \"".$buyer_details['street_address']."\",\n      \"city_locality\": \"".$buyer_details['city']."\",\n      \"state_province\": \"CA\",\n      \"postal_code\": \"95128\",\n      \"country_code\": \"US\",\n      \"address_residential_indicator\": \"yes\"\n    },\n    \"ship_from\": {\n      \"name\": \"".$seller_details['name']."\",\n      \"company_name\": \"".$seller_details['business_name']."\",\n      \"phone\": \"".$seller_details['phone']."\",\n      \"address_line1\": \"".$seller_details['street_address1']."\",\n      \"city_locality\": \"".$seller_details['city']."\",\n      \"state_province\": \"TX\",\n      \"postal_code\": \"78756\",\n      \"country_code\": \"US\",\n      \"address_residential_indicator\": \"no\"\n    },\n    \"packages\": [\n      {\n        \"weight\": {\n          \"value\": 20,\n          \"unit\": \"ounce\"\n        },\n        \"dimensions\": {\n          \"height\": 6,\n          \"width\": 12,\n          \"length\": 24,\n          \"unit\": \"inch\"\n        }\n      }\n    ]\n  }\n}",
            CURLOPT_HTTPHEADER => array(
              "Host: api.shipengine.com",
              "API-Key: ".$api_key,
              "Content-Type: application/json"
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);
         return json_decode($response,true);
         
       }
    }



}
