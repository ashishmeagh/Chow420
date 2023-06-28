<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProductNewsModel;
use App\Models\OrderModel;
use App\Models\SellerModel;
use App\Models\BuyerModel;
use App\Models\OrderProductModel;
use App\Models\UserModel;
use App\Models\DisputeModel;
use App\Models\TransactionModel;
use App\Models\AdminCommissionModel;
use App\Models\SiteSettingModel;
use App\Common\Services\GeneralService;
use App\Models\ProductInventoryModel;
use App\Models\WithdrawalBalanceModel;

use App\Common\Services\EmailService;
use App\Common\Services\CommisionService;
use App\Common\Services\OrderService;
use App\Common\Services\UserService;

use App\Models\BuyerWalletModel;


use App\Common\Traits\MultiActionTrait;
 
use Validator;
use Image;
use DB;  
use Datatables;
use Flash;
use Sentinel;
use Excel;
use Carbon\Carbon;
use Omnipay\Omnipay;
use App\Payment;
 
class OrderDetailController extends Controller
{       
    use MultiActionTrait;

    public function __construct(ProductNewsModel $ProductNewsModel,
                                OrderModel $OrderModel,
                                BuyerModel $BuyerModel,
                                SellerModel $SellerModel,
                                OrderProductModel $OrderProductModel,
                                UserModel $UserModel,
                                DisputeModel $DisputeModel, 
                                GeneralService $GeneralService,
                                TransactionModel $TransactionModel,
                                ProductInventoryModel $ProductInventoryModel,
                                AdminCommissionModel $AdminCommissionModel,
                                EmailService $EmailService,
                                SiteSettingModel $SiteSettingModel,
                                WithdrawalBalanceModel $WithdrawalBalanceModel,
                                CommisionService $CommisionService,
                                OrderService $OrderService,
                                UserService $UserService,
                                BuyerWalletModel $BuyerWalletModel
    ) 
    {
    	$this->BaseModel            = $ProductNewsModel;
        $this->OrderModel           = $OrderModel;  
        $this->SellerModel          = $SellerModel;
        $this->BuyerModel           = $BuyerModel; 
        $this->OrderProductModel    = $OrderProductModel;    
        $this->UserModel            = $UserModel;   
        $this->DisputeModel         = $DisputeModel;
        $this->TransactionModel     = $TransactionModel;
         $this->ProductInventoryModel = $ProductInventoryModel;
        $this->AdminCommissionModel = $AdminCommissionModel;
        $this->GeneralService       = $GeneralService;
        $this->UserService          = $UserService;

        $this->EmailService         = $EmailService;
        $this->CommisionService     = $CommisionService;
        $this->OrderService         = $OrderService;

        $this->SiteSettingModel     = $SiteSettingModel;
        $this->WithdrawalBalanceModel     = $WithdrawalBalanceModel;
        $this->BuyerWalletModel     = $BuyerWalletModel;
  

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->news_base_img_path   = base_path().config('app.project.img_path.product_news');
        $this->news_public_img_path = url('/').config('app.project.img_path.product_news');

        $this->module_title       = "Orders";
        $this->module_view_folder = "admin.order_detail";
        $this->module_url_path    = $this->admin_url_path."/order";
        $this->seller_percentage     = config('app.project.seller_commision');

        $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        // $this->gateway->setAuthName('4u83vQGH5');
        // $this->gateway->setTransactionKey('332t2CEmcNS54GpD');
       // $this->gateway->setAuthName('22EDggQ84mb');
       // $this->gateway->setTransactionKey('4Sv9AQcsp8A938zh');
       // $this->gateway->setTestMode(true); //comment this line when move to 'live'

      
 
    }




    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    { 
    	$order_detail_table         = $this->OrderModel->getTable();
        $prefixed_orderdetail_table = DB::getTablePrefix().$this->OrderModel->getTable();

        $buyer_table           = $this->BuyerModel->getTable();
        $prefixed_buyer_table  = DB::getTablePrefix().$this->BuyerModel->getTable();

        $seller_table          = $this->SellerModel->getTable();
        $prefixed_seller_table = DB::getTablePrefix().$this->SellerModel->getTable();


        $user_table            = $this->UserModel->getTable();
        $prefixed_user_table   = DB::getTablePrefix().$this->UserModel->getTable();

        $order_product_table   = $this->OrderProductModel->getTable();
        $prefixed_orderproduct_table = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $dispute_tbl_name      = $this->DisputeModel->getTable();
        $prefixed_dispute_tbl  = DB::getTablePrefix().$this->DisputeModel->getTable();
        
        $obj_orderdetail = DB::table($order_detail_table)
        ->select(DB::raw('transaction_id,order_status,
            total_amount as total_amount, 
            '.$order_detail_table.'.id as id,
            '.$order_detail_table.'.seller_id,
            '.$order_detail_table.'.refund_status,
            '.$order_detail_table.'.order_no as order_no,

             '.$order_detail_table.'.couponid as couponid,
             '.$order_detail_table.'.couponcode as couponcode,
             '.$order_detail_table.'.discount as discount,
             '.$order_detail_table.'.seller_discount_amt as seller_discount_amt,


              '.$order_detail_table.'.delivery_title as delivery_title,
             '.$order_detail_table.'.delivery_cost as delivery_cost,
             '.$order_detail_table.'.delivery_day as delivery_day,
             '.$order_detail_table.'.card_last_four,
             '.$order_detail_table.'.authorize_transaction_status,
             '.$order_detail_table.'.payment_gateway_used,
             '.$order_detail_table.'.tax,


            '.$order_detail_table.'.note as note,

            '.$order_detail_table.'.created_at as created_at,
            '.$order_detail_table.'.buyer_age_restrictionflag as buyer_age_restrictionflag,
            '.$prefixed_dispute_tbl.'.dispute_status,
            '.$prefixed_dispute_tbl.'.dispute_reason,
            '.$prefixed_dispute_tbl.'.is_dispute_finalized,
            '.$prefixed_seller_table.'.business_name,
            '.$prefixed_user_table.'.id as buyer_id,
            '.$prefixed_user_table.'.email,
            '.$prefixed_user_table.'.date_of_birth,
            '.$prefixed_user_table.'.first_name as buyername'))

         ->leftJoin($prefixed_dispute_tbl,$prefixed_dispute_tbl.'.order_id',$order_detail_table.'.id')
         ->leftJoin($prefixed_user_table,$prefixed_user_table.'.id',$order_detail_table.'.buyer_id')
        ->leftJoin($prefixed_seller_table, $prefixed_seller_table.'.user_id',$order_detail_table.'.seller_id') 
         ->orderBy('id','desc');
         //->get();
        // ->groupBy('order_no');

        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');    
 

             if(isset($arr_search_column['q_order_status']) && $arr_search_column['q_order_status'] != '')
            {
                $search_order_status   = $arr_search_column['q_order_status'];
                $obj_orderdetail  = $obj_orderdetail->where($prefixed_orderdetail_table.'.order_status','LIKE', '%'.$search_order_status.'%');
            }

          	if(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name'] != '')
          	{
             	$search_buyer_term  = $arr_search_column['q_buyer_name'];
                $obj_orderdetail  = $obj_orderdetail->where($prefixed_user_table.'.first_name','LIKE', '%'.$search_buyer_term.'%')->orWhere('last_name', 'LIKE', '%'.$search_buyer_term.'%');
          	}
            if(isset($arr_search_column['q_total_amount']) && $arr_search_column['q_total_amount'] != '')
            {
                $search_amount    = $arr_search_column['q_total_amount'];
                $obj_orderdetail  = $obj_orderdetail->where($prefixed_orderdetail_table.'.total_amount','=', $search_amount);
            }
             if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no'] != '')
            {
                $search_orderno   = $arr_search_column['q_order_no'];
                $obj_orderdetail  = $obj_orderdetail->where($prefixed_orderdetail_table.'.order_no','LIKE', '%'.$search_orderno.'%');
            }

            if(isset($arr_search_column['q_dispute_status']) && $arr_search_column['q_dispute_status'] != '')
            {
                $search_dispute_status   = $arr_search_column['q_dispute_status'];
                $obj_orderdetail  = $obj_orderdetail->where($prefixed_dispute_tbl.'.dispute_status','LIKE', '%'.$search_dispute_status.'%');
            }

            if(isset($arr_search_column['q_from']) && $arr_search_column['q_from']!="" && isset($arr_search_column['q_to']) && $arr_search_column['q_to']!="")
            {
                $search_from      = $arr_search_column['q_from'];
                $search_from      = date('Y-m-d',strtotime($search_from));

                $search_to      = $arr_search_column['q_to'];
                $search_to      = date('Y-m-d',strtotime($search_to));

                $search_from = $search_from.' 00:00:00';
                $search_to   = $search_to.' 23:59:59';


                $obj_orderdetail = $obj_orderdetail->whereBetween($prefixed_orderdetail_table.'.created_at',[ $search_from,$search_to ]);
            }  
            if(isset($arr_search_column['q_buyer_age_restrictionflag']) && $arr_search_column['q_buyer_age_restrictionflag'] != '')
            {
                $search_age_restrictedflag   = $arr_search_column['q_buyer_age_restrictionflag'];
                if($search_age_restrictedflag=="0")
                {
                    $obj_orderdetail  = $obj_orderdetail->where($order_detail_table.'.buyer_age_restrictionflag','LIKE', '%'.$search_age_restrictedflag.'%');
                }else{
                    $obj_orderdetail  = $obj_orderdetail->where($order_detail_table.'.buyer_age_restrictionflag','=',$search_age_restrictedflag);
                }
                
            }


            if(isset($arr_search_column['q_business_name']) && $arr_search_column['q_business_name'] != '')
            {
                $search_business_term  = $arr_search_column['q_business_name'];
                $obj_orderdetail  = $obj_orderdetail->where($prefixed_seller_table.'.business_name','LIKE', '%'.$search_business_term.'%');
            }


            if(isset($arr_search_column['q_email']) && $arr_search_column['q_email'] != '')
            {
                $search_business_term  = $arr_search_column['q_email'];
                $obj_orderdetail       = $obj_orderdetail->where($prefixed_user_table.'.email','LIKE', '%'.$search_business_term.'%');
            }



    	/* --------------------------------------------------------------------*/
        $current_context = $this;

        $json_result = Datatables::of($obj_orderdetail);  
        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })

                        ->editColumn('created_at',function($data) use ($current_context)
                        {
                           return date('d M Y H:i',strtotime($data->created_at));
                           // return us_date_format($data->created_at);
                        })

                         ->editColumn('business_name',function($data) use ($current_context)
                        {
                           if(isset($data->business_name) && !empty($data->business_name))
                           {
                            return $data->business_name;
                           }
                           else
                           {
                            return 'NA';
                           }
                           // return us_date_format($data->created_at);
                        })


                        ->editColumn('buyer_age',function($data) use ($current_context)
                        {
                            $age = $dob = '';

                            if (isset($data->date_of_birth) && $data->date_of_birth != "")
                            {
                                $dob = $data->date_of_birth;
                                $age = (date('Y') - date('Y',strtotime($dob))) . " Years";
                            }
                            else 
                            {
                                $age = "NA";
                            }

                            return $age;
                        })



                        ->editColumn('order_no',function($data) use ($current_context)
                        {

                           // $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id).'/'.base64_encode($data->order_no);
                            $view_href =  $this->module_url_path.'/view/'.base64_encode($data->order_no).'/'.base64_encode($data->id);
                            $order_no = '<a href="'.$view_href.'" title="View">'.$data->order_no.'</a>';
                            return $order_no;
                        })


                        ->editColumn('order_status',function($data) use ($current_context){
                            $orderstatus = $data->order_status;
                            if($orderstatus==0){
                                $order_status ="<span class='status-shipped'>Cancelled</span>";
                            }
                            if($orderstatus==1){
                                $order_status ="<span class='status-completed'>Delivered</span>";
                            }
                            if($orderstatus==2)
                            {
                                if(isset($data->buyer_age_restrictionflag) && $data->buyer_age_restrictionflag==1)
                                {
                                  $order_status ="<span class='status-dispatched'>Pending Age Verification</span>";

                                }else{
                                  $order_status ="<span class='status-dispatched'>Ongoing</span>";

                                } 
                            }
                            if($orderstatus==3){
                                $order_status ="<span class='status-shipping'>Shipped</span>";
                            }
                            if($orderstatus==4){
                                $order_status ="<span class='status-dispatched'>Ongoing</span>";
                            }
                            return $order_status; 
                        })

                        ->editColumn('dispute_status',function($data) use ($current_context){
                            $disputestatus = $data->dispute_status;

                            if($data->dispute_status==''){
                                $dispute_status = '-';
                            }

                            if($disputestatus=='0')
                                $dispute_status ="<span class='status-dispatched'>Pending</span>";
                            if($disputestatus=='1')
                                $dispute_status ="<span class='status-completed'>Approved</span>";
                            if($disputestatus=='2')
                                $dispute_status ="<span class='status-shipped'>Rejected</span>";
                           
                            return $dispute_status; 
                        })

                        ->editColumn('btn_refund',function($data) use ($current_context){
                            
                            $btn_refund='';
                            $orderstatus = $data->order_status;
                            $refund_href = $this->module_url_path.'/payment_refund/'.base64_encode($data->order_no).'/'.base64_encode($data->transaction_id);

                            if($orderstatus==0 && $data->refund_status == 0) //0-Cancelled
                            {   

 
                                /************couponcode********************************/
                                    if($data->total_amount>0){

                                        if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!='' 
                                            && isset($data->seller_discount_amt) 
                                            && $data->seller_discount_amt!='')
                                        {

                                          $total_amount = (float)$data->total_amount - (float)$data->seller_discount_amt;  
                                          
                                            if(isset($data->delivery_title) && isset($data->delivery_day) && $data->delivery_day!='' && isset($data->delivery_cost) && $data->delivery_cost!='' && $data->delivery_title!='')
                                            {
                                                  $total_amount = (float)$total_amount + (float)$data->delivery_cost;  
                                            }


                                             if(isset($data->tax) && $data->tax!='')
                                            {
                                              $total_amount = (float)$total_amount + (float)$data->tax;  
                                            }


                                           $total_amount = number_format($total_amount, 2, '.', ''); 
                                        }
                                        else
                                        {
                                          // $total_amount = number_format($data->total_amount, 2, '.', '');  

                                           $total_amount = $data->total_amount;

                                           if(isset($data->delivery_title) && isset($data->delivery_day) && $data->delivery_day!='' && isset($data->delivery_cost) && $data->delivery_cost!='' && $data->delivery_title!='')
                                            {
                                                  $total_amount = (float)$total_amount + (float)$data->delivery_cost;  
                                            }


                                            if(isset($data->tax) && $data->tax!='')
                                            {
                                              $total_amount = (float)$total_amount + (float)$data->tax;  
                                            }


                                          $total_amount = number_format($total_amount, 2, '.', '');  


                                        }//else
                                    }
                                    else{
                                        $total_amount = $data->total_amount;
                                    }


                                /**************couponcode******************************/


                               // $total_amount = number_format($data->total_amount, 2, '.', '');

                                if(isset($data->payment_gateway_used) && $data->payment_gateway_used=="authorizenet" && isset($data->authorize_transaction_status) && $data->authorize_transaction_status=="settledSuccessfully")
                                {
                                    $btn_refund = '<a class="eye-actn" title="Refund" onclick="confirm_payment_refund($(this))" data-order_no='.$data->order_no.' data-order_payment_id='.$data->transaction_id.' data-total_amount='.$total_amount.' data-seller_id='.$data->seller_id.'  data-cardlastfour='.
                                        $data->card_last_four.' data-payment-gateway='.$data->payment_gateway_used.'>Refund Now</a>'; 

                                }elseif(isset($data->payment_gateway_used) && $data->payment_gateway_used=="square")
                                {
                                    $btn_refund = '<a class="eye-actn" title="Refund" onclick="confirm_payment_refund($(this))" data-order_no='.$data->order_no.' data-order_payment_id='.$data->transaction_id.' data-total_amount='.$total_amount.' data-seller_id='.$data->seller_id.' data-payment-gateway='.$data->payment_gateway_used.'>Refund Now</a>';

                                }
                                else
                                {
                                    $btn_refund = '<a class="eye-actn" title="Payment for this order is still being processed. You will receive a notification as soon as the payment is settled" onclick="payment_pending_status()">Payment Pending</a>'; 
                                }//else authorize_transaction_status

                                  
 


                            }
                            elseif ($orderstatus==0 && $data->refund_status == 1) //1 -Partially Completed
                            {
                                $btn_refund ="<label class='label label-info'>In Process</label>";
                            }
                            elseif ($orderstatus==0 && $data->refund_status == 2) //2- Completed
                            {
                                $btn_refund ="<label class='label label-success'>Amount Refunded</label>";
                            }
                            else 
                            {
                                $btn_refund = '--';
                            }
                            return $btn_refund; 
                        })



                         ->editColumn('total_amount',function($data) use ($current_context)
                        { 
                            if($data->total_amount>0)
                            {

                                if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!='' 
                                    && isset($data->seller_discount_amt) 
                                    && $data->seller_discount_amt!='')
                                {

                                  $total_amount = (float)$data->total_amount - (float)$data->seller_discount_amt ;  

                                    if(isset($data->delivery_title) && isset($data->delivery_day) && $data->delivery_day!='' && isset($data->delivery_cost) && $data->delivery_cost!='' && $data->delivery_title!='')
                                    {
                                          $total_amount = (float)$total_amount + (float)$data->delivery_cost;  
                                    }


                                     if(isset($data->tax) && $data->tax!='')
                                    {
                                     $total_amount = (float)$total_amount + (float)$data->tax;  
                                    }


                                  $total_amount = '$'.num_format($total_amount); 
                                }else{

                                  $total_amount = $data->total_amount;

                                   if(isset($data->delivery_title) && isset($data->delivery_day) && $data->delivery_day!='' && isset($data->delivery_cost) && $data->delivery_cost!='' && $data->delivery_title!='')
                                    {
                                          $total_amount = (float)$total_amount + (float)$data->delivery_cost;  
                                    }

                                    if(isset($data->tax) && $data->tax!='')
                                    {
                                     $total_amount = (float)$total_amount + (float)$data->tax;  
                                    }

                                  // $total_amount = '$'.num_format($data->total_amount);  
                                   $total_amount = '$'.num_format($total_amount);  
                                } //else of total amount of coupon


                            }//if data of total amount
                            else{
                                $total_amount = $data->total_amount;
                            }
                              return $total_amount; 
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
                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                            $get_orderids = $this->OrderModel->select('id')
                                            ->where('order_no',$data->order_no)
                                            ->get()->toArray();
                             if(!empty($get_orderids) && count($get_orderids)>0){
                             $str=[];              
                             foreach($get_orderids as $v){
                                $str[] = base64_encode($v['id']);
                             }       
                             $ids = implode(",",$str);        
                             }else{
                                $ids = base64_encode($data->id);
                             }
                            
                              //commented for multiple order ids
                           //$view_href =  $this->module_url_path.'/view/'.$ids;
 
                             //commented for url id string
                              //  $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);
                            $view_href =  $this->module_url_path.'/view/'.base64_encode($data->order_no).'/'.base64_encode($data->id);
                         
                            $build_view_action = '<a class="eye-actn" href="'.$view_href.'" title="View">View</a>';
                            
                            if ($data->note != "") {

                             $build_note_action = '<a href="javascript:void(0)" title="View Order Note" class="eye-actn" id="ship-order"  data-id="ship" onclick="add_note_model($(this))"   data-order_id="'.base64_encode($data->id).'"  data-order_note="'.$data->note.'" >View Order Note</a>'; 
                            }

                            $dispute_btn_href = $this->module_url_path.'/Dispute/'.$ids;
                            $build_dispute_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip  raiseDispute" orderids="'.$ids.'" orderno="'.$data->order_no.'"  title="View Dispute Details" ><i class="ti-comments"></i></a>'; 
                            $build_dispute_action=''; 
                            if($data->dispute_status==0 && $data->dispute_reason!=""){

                            $dispute_btn_href = $this->module_url_path.'/Dispute/'.$data->id;
                            $build_dispute_action = '<a href="javascript:void(0)" class="raiseDispute btns-just-opend" orderids="'.$data->id.'" orderno="'.$data->order_no.'"  title="View Dispute Details" >Dispute Raised</a>';
                              }
 
                            $build_viewdispute_action='';

                            if($data->dispute_status==1 && $data->dispute_reason!="" && $data->is_dispute_finalized==0){
                            $url_dispute = $this->admin_url_path.'/dispute/'.base64_encode($data->id); 
                            $build_viewdispute_action = '<a href="'.$url_dispute.'" class="btns-approved" title="View Dispute Details">View Dispute</a>';
                             }

                             if($data->dispute_status==1 && $data->dispute_reason!="" && $data->is_dispute_finalized==1){
                            $url_dispute = $this->admin_url_path.'/dispute/'.base64_encode($data->id); 
                            $build_viewdispute_action = '<a href="'.$url_dispute.'" class="btns-pending" title="View Dispute Details">Dispute Closed</a>';
                             }

                            $build_action = $build_view_action.' '.$build_dispute_action.' '.$build_viewdispute_action;

                            if ($data->note != "") {

                                $build_action = $build_action.''.$build_note_action;
                            }

                            $build_cancel_cashback ='';
                            if(isset($data->order_no))
                            {
                                $getcashback_status = get_user_wallet_cashback($data->order_no,$data->buyer_id);
                                if(isset($getcashback_status) && !empty($getcashback_status) && $getcashback_status=='Cancel Cashback')
                                {
                                      $view_href =  $this->module_url_path.'/cancel_cashback/'.base64_encode($data->order_no).'/'.base64_encode($data->buyer_id);
                         
                                      $build_cancel_cashback = '<a class="eye-actn status-completed" href="'.$view_href.'" title="Cancel Cashback">'.$getcashback_status.'</a>';
                            
                                }//
                                else if(isset($getcashback_status) && !empty($getcashback_status) && $getcashback_status=='Cashback Cancelled')
                                {
                        
                                      $build_cancel_cashback = '<a class="eye-actn status-shipped" href="'.$view_href.'" title="Cancel Cashback">'.$getcashback_status.'</a>';
                            
                                }


                            }//if isset orderno

                            return $build_action." ".$build_cancel_cashback;
                        })

                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }


   
    public function view($orderno,$enc_id=NULL)
    {  

       /* $order_id = explode("@", $enc_id);   
        if(!empty($order_id))
        {
            $str=[];
           foreach($order_id as $v){
            $str[] = base64_decode($v); 
           }         
        }
        
        
        $obj_data = $this->OrderModel
                        ->with(['address_details','order_product_details.product_details','buyer_details','seller_details','transaction_details'])
                        ->whereIn('id', $str)
                        ->get();*/

        $order_id = base64_decode($enc_id); 
        $orderno  = base64_decode($orderno);    

         $obj_data = $this->OrderModel
                        ->with(['address_details','order_product_details.product_details','buyer_details','seller_details','transaction_details',
                            'address_details.get_shippingcountrydetail',
                            'address_details.get_shippingstatedetail',
                             'address_details.get_billingcountrydetail',
                            'address_details.get_billingstatedetail',
                            'seller_details.seller_detail'
                          ])
                        ->where('order_no', $orderno);

            if(isset($enc_id))      
            {
                $obj_data = $obj_data->where('id', $order_id);

            }      
            $obj_data = $obj_data->get();
                        
    
        $arr_order_detail = [];
        if($obj_data)
        {
           $arr_order_detail = $obj_data->toArray(); 
        }

        $transaction_data = $this->TransactionModel->select('cashback')->where('order_no',$orderno)->first();
        if(isset($transaction_data) && !empty($transaction_data))
        {
            $transaction_data = $transaction_data->toArray();
        }
        
      	$this->arr_view_data['news_public_img_path']     = $this->news_public_img_path;
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_order_detail']   		 = isset($arr_order_detail) ? $arr_order_detail : [];  
      	$this->arr_view_data['page_title']               = "View ".$this->module_title;
      	$this->arr_view_data['module_title']             = $this->module_title;

       $this->arr_view_data['orderno']             = isset($orderno)?$orderno:'';
       $this->arr_view_data['order_id']             = isset($order_id)?$order_id:'';
       $this->arr_view_data['transaction_data']  = isset($transaction_data)?$transaction_data:[];
      return view($this->module_view_folder.'.show',$this->arr_view_data);   
    }

    public function multi_action(Request $request)
    {
        /*Check Validations*/
        $input = request()->validate([
                'multi_action' => 'required',
                'checked_record' => 'required'
            ], [
                'multi_action.required' => 'Please  select record required',
                'checked_record.required' => 'Please select record required'
            ]);

        $multi_action   = $request->input('multi_action');
        $checked_record = $request->input('checked_record');


        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Flash::error('Problem Occurred, While Doing Multi Action');
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
            Flash::error('Problem Occurred While Deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }//single delete

    public function perform_delete($id)
    {
        $entity          = $this->BaseModel->where('id',$id)->first();
    
        if($entity)
        {
            $unlink_old_img_path    = $this->news_base_img_path.'/'.$entity->image;
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }

            $this->BaseModel->where('id',$id)->delete();

            /*---------------------- Activity log Event--------------------------*/
              /*$arr_event                 = [];
              $arr_event['ACTION']       = 'REMOVED';
              $arr_event['MODULE_ID']    =  $id;
              $arr_event['MODULE_TITLE'] = $this->module_title;
              $arr_event['MODULE_DATA'] = json_encode(['id'=>$id,'status'=>'REMOVED']);

              $this->save_activity($arr_event);*/

              Flash::success(str_plural($this->module_title).' Deleted Successfully');
              return true; 
        }
        else
        {
          Flash::error('Problem Occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }//delete function


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

     public function perform_activate($id)
    {
        $entity = $this->BaseModel->where('id',$id)->first();
        
        if($entity)
        {
            return $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        }

        return FALSE;
    }//activate

 
      public function perform_deactivate($id)
    {

        $entity = $this->BaseModel->where('id',$id)->first();
        if($entity)
        {
            return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);
        }
        return FALSE;
    }//deactivate

    public function disputedetail(Request $request)
    {
           
            $orderno = $request->orderno;
            $orderids = $request->orderids;
            $res_dispute     = $this->DisputeModel->select('*')
                            //->where('order_no',$orderno)  
                            ->where('order_id',$orderids)  
                            ->get();
            $order_details    = $this->OrderModel->where('id',$orderids)->with('buyer_details','seller_details')->first()->toArray();   
            $buyer_name       = $order_details['buyer_details']['first_name']." ".$order_details[
                'buyer_details']['last_name']; 
            $seller_name      = $order_details['seller_details']['first_name']." ".$order_details[
                'seller_details']['last_name'];                   
            if(!empty($res_dispute)){
                $res_dispute = $res_dispute->toArray();
                $arr_response['buyer_name']  = isset($buyer_name)?$buyer_name:[];
                $arr_response['seller_name'] = isset($seller_name)?$seller_name:[];
                $arr_response['dispute']     = isset($res_dispute[0])?$res_dispute[0]:[];
                $arr_response['status']      = 'SUCCESS';

            }else{
                $arr_response['dispute'] =[];
                $arr_response['status']      = 'ERROR';

            }   
                
            return response()->json($arr_response);;
    }
    public function approve(Request $request)
    {
        if(Sentinel::check())
        {
            $admin_details = Sentinel::getUser();
            $admin_id      = $admin_details->id;
        }
        $orderno   = $request->orderno;
        $disputeid = $request->disputeid;
        $order_id  = $request->order_id;

        if($orderno)
        {   
             $res_dispute = $this->DisputeModel->select('*')
                           // ->where('order_no',$orderno)  
                            ->where('order_id',$order_id)  
                            ->where('id',$disputeid)    
                            ->get();


             if(!empty($res_dispute) && count($res_dispute)>0)
             {
                $res_dispute    = $res_dispute->toArray();
                $dispute_status = $res_dispute[0]['dispute_status'];

                if($dispute_status==0 || $dispute_status==2)
                {
                  
                    $approve_dispute = $this->DisputeModel
                                            ->where('id',$disputeid)
                                            ->where('order_id',$order_id)
                                            ->where('order_no',$orderno)
                                            ->update(['dispute_status'=>'1']);  

                    if($approve_dispute)
                    {   
                        $user_role = isset($res_dispute[0]['role'])?$res_dispute[0]['role']:'';
                        $order_url = url('/');

                        if($user_role == 'buyer')
                        {
                            $order_url = url('/').'/buyer/order/view/'.base64_encode($order_id);
                        }
                        else if($user_role == 'seller')
                        {
                            $order_url = url('/').'/seller/order/view/'.base64_encode($order_id);
                        }
                        else
                        {
                            $order_url = url('/');
                        }

                        
                        /******************Send Notification to User (START)******************/
                                                   
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $admin_id;
                            $arr_event['to_user_id']   = $res_dispute[0]['user_id'];
                            $arr_event['description']  = html_entity_decode('Dispute has been approved for order no : <a target="_blank" href="'.$order_url.'">'. $orderno.'</a> by '.config('app.project.admin_name').'.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Dispute Approved';
             
                            $this->GeneralService->save_notification($arr_event);
                        /******************Send Notification to User (END)********************/

                        /*****************Send Mail Notification to User (START)***************/
                            $to_user = Sentinel::findById($res_dispute[0]['user_id']);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                           /* $msg     = html_entity_decode('Dispute has been approved for order no : '.$orderno.' by '.config('app.project.admin_name').'.');

                            
                            $subject = 'Dispute Approved';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'ORDER_NO'      => $orderno,
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $order_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '95';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($res_dispute[0]['user_id']);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*****************Send Mail Notification to User (END)*****************/

                        $response['status']      = 'SUCCESS';
                        $response['description'] = 'Dispute approved successfully'; 
                        return response()->json($response);   
                    }            

                }
                else if($dispute_status==1)
                {

                    $response['status']      = 'ERROR';
                    $response['description'] = 'Dispute already approved'; 
                    return response()->json($response);   
                }
             }
        }
    }//end of function


    public function reject(Request $request)
    {

        $orderno   = $request->orderno;
        $disputeid = $request->disputeid;
        $order_id  = $request->order_id;

        if(Sentinel::check())
        {
            $admin_details = Sentinel::getUser();
            $admin_id      = $admin_details->id;
        }

        if($orderno)
        {   
             $res_dispute = $this->DisputeModel->select('*')
                           // ->where('order_no',$orderno)  
                            ->where('order_id',$order_id)  
                            ->where('id',$disputeid)    
                            ->get();

             if(!empty($res_dispute) && count($res_dispute)>0)
             {
                $res_dispute    = $res_dispute->toArray();
                $dispute_status = $res_dispute[0]['dispute_status'];
                
                if($dispute_status==0 || $dispute_status==1)
                {
                  
                    $reject_dispute = $this->DisputeModel
                                    ->where('id',$disputeid)
                                    ->where('order_id',$order_id)
                                    ->where('order_no',$orderno)
                                    ->update(['dispute_status'=>'2']);   

                    if($reject_dispute)
                    {
                        $user_role = isset($res_dispute[0]['role'])?$res_dispute[0]['role']:'';
                        $order_url = url('/');

                        if($user_role == 'buyer')
                        {
                            $order_url = url('/').'/buyer/order/view/'.base64_encode($order_id);
                        }
                        else if($user_role == 'seller')
                        {
                            $order_url = url('/').'/seller/order/view/'.base64_encode($order_id);
                        }
                        else
                        {
                            $order_url = url('/');
                        }

                        /****************Send Notification to User(START)************************/

                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $admin_id;
                            $arr_event['to_user_id']   = $res_dispute[0]['user_id'];
                            $arr_event['description']  = html_entity_decode('Dispute has been rejected for order no : <a target="_blank" href="'.$order_url.'">'. $orderno.'</a> by '.config('app.project.admin_name').'.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Dispute Rejected';
             
                            $this->GeneralService->save_notification($arr_event); 

                        /****************Send Notification to User(END)************************/

                        /**************Send Mail Notification to User(START)*************/
                            $to_user = Sentinel::findById($res_dispute[0]['user_id']);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                           /* $msg     = html_entity_decode('Dispute has been rejected for order no : '.$orderno.' by '.config('app.project.admin_name').'.');

                            
                            $subject = 'Dispute Rejected';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ORDER_NO'      => $orderno,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $order_url
                                                 ];

                            $arr_mail_data['email_template_id'] = '96';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($res_dispute[0]['user_id']);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /**************Send Mail Notification to User(END)***************/


                          $response['status']      = 'SUCCESS';
                          $response['description'] = 'Dispute rejected successfully'; 
                          return response()->json($response);   
                    }            


                }
                else if($dispute_status==2)
                {

                    $response['status']      = 'ERROR';
                    $response['description'] = 'Dispute already rejected'; 
                    return response()->json($response);   
                }
             }
        }
   
    }//end of reject

    public function seller_invoice($enc_order_id,$enc_transaction_id)
    {   
 


        $arr_tx_details = $arr_order_detail =[];
        $tx_id = base64_decode($enc_transaction_id);

        /*tx detail*/
        if(isset($tx_id) && !empty($tx_id))
        {
            // dd($tx_id);
            $obj_tx_details = $this->TransactionModel->with(['order_details'])
                                ->where('id',$tx_id)->first();

            if($obj_tx_details)
            {
                $arr_tx_details = $obj_tx_details->toArray();
            }
        }
        /*end*/

        $order_id = explode(",", $enc_order_id);   
        if(!empty($order_id))
        {
            $str=[];
           foreach($order_id as $v){
            $str[] = base64_decode($v);
           }         
        }
       
        $obj_data = $this->OrderModel
                        ->with(['address_details','order_product_details.product_details','buyer_details','seller_details','transaction_details'])
                        ->whereIn('id', $str)
                        ->first();
        if($obj_data)
        {
           $arr_order_detail = $obj_data->toArray(); 
        }


        // dd($arr_tx_details,$arr_order_detail);

        /*admin commission*/
        $admin_comission_percent  = 100 - (float)$this->seller_percentage;


        $this->arr_view_data['page_title']          = "Seller Invoice";

        /****************seller and admin commision percentage*****/
        //$this->arr_view_data['admin_comission_percent']   = (float)$admin_comission_percent;
       // $this->arr_view_data['seller_percentage']   = $this->seller_percentage;

        $commision_arr = $this->CommisionService->get_commision();
        if(isset($commision_arr) && ($commision_arr!=false) && isset($commision_arr['admin_commission']) && (isset($commision_arr['seller_commission'])))
        {
             $this->arr_view_data['admin_comission_percent'] = (float)$commision_arr['admin_commission'];
             $this->arr_view_data['seller_percentage'] = (float)$commision_arr['seller_commission'];
        }

        /*********************************************************/

        $this->arr_view_data['arr_tx_details']      = $arr_tx_details;        
        $this->arr_view_data['arr_order_detail']    = $arr_order_detail;        
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

        return view($this->module_view_folder.'.seller_invoice',$this->arr_view_data);
        

       
        // dd($arr_order_detail);
    }


    public function store_admin_commission(Request $request)
    {
        $frm_data = $request->all();
        $arr_order_detail = $arr_response = [];

        if(isset($frm_data['order_table_id']) && !empty($frm_data['order_table_id']))
        {
            $obj_tx_data = $this->OrderModel                        
                        ->where('id', $frm_data['order_table_id'])
                        ->first();

            if($obj_tx_data) 
            {
               $arr_tx_detail = $obj_tx_data->toArray();
               // dd($arr_tx_detail);

               if(isset($arr_tx_detail) && count($arr_tx_detail) > 0)
               {
                    $total_amount = $arr_tx_detail['total_amount'];
                    
                    $admin_com_amt = num_format($total_amount * (10/100));

                    $seller_com_amt = num_format($total_amount - $admin_com_amt);

                    $arr_admin_commission = array(
                                            'order_id' =>$frm_data['order_table_id'],
                                            'order_no' =>$arr_tx_detail['order_no'],
                                            'seller_id'=>$arr_tx_detail['seller_id'],
                                            'total_pay_amt'=>$total_amount,
                                            'admin_commission_amt'=>$admin_com_amt,
                                            'seller_commission_amt'=>$seller_com_amt
                                                );
                    
                    $insert = $this->AdminCommissionModel->create($arr_admin_commission);
                    if($insert)
                    {                          
                        $arr_response['status'] = 'success';
                        $arr_response['arr_admin_commission'] = $arr_admin_commission;
        
                    }
                    else
                    {
                        $arr_response['status'] = 'error';
                    }
               }
               else
               {
                    $arr_response['status'] = 'error';
               }
            }
            else
            {
                $arr_response['status'] = 'error';
            }
        }
        else
        {
            $arr_response['status'] = 'error';
        }
        return response()->json($arr_response);
    }


    public function payment_refund_old18jan21_bk(Request $request)
    {
        $form_data = $request->all();


        $user = Sentinel::check();

        $order_no           = isset($form_data['order_no'])?$form_data['order_no']:'';
        $order_payment_id   = isset($form_data['order_payment_id'])?$form_data['order_payment_id']:'';
        // dd($form_data);
        $order_total_amount = isset($form_data['order_total_amount'])?$form_data['order_total_amount']:'';
        $order_seller_id    = isset($form_data['order_seller_id'])?$form_data['order_seller_id']:'';

       
        if($order_no != '' && $order_payment_id != '' && $order_total_amount != '' && $order_seller_id != '' && $order_cardlastfour!='')
        {
            

            $site_setting_arr = [];

            $site_setting_obj = SiteSettingModel::first();  

            if(isset($site_setting_obj))
            {
                $site_setting_arr = $site_setting_obj->toArray();            
            }   


            $payment_url = '';
            $access_token = '';

            if(isset($site_setting_arr) && count($site_setting_arr)>0)
            {       
                $payment_mode         = $site_setting_arr['payment_mode'];
                $sandbox_url          = $site_setting_arr['sandbox_url'];
                $live_url             = $site_setting_arr['live_url'];
                $sandbox_access_token = $site_setting_arr['sandbox_access_token'];
                $live_access_token    = $site_setting_arr['live_access_token'];
                $sandbox_location_id  = $site_setting_arr['sandbox_location_id'];
                $live_location_id     = $site_setting_arr['live_location_id'];

                if($payment_mode == 0) 
                {
                    $payment_url  = $sandbox_url;
                    $access_token = $sandbox_access_token;
                }
                else if($payment_mode == 1)
                {
                    $payment_url = $live_url;
                    $access_token = $live_access_token;
                }
            }

            // dd($payment_url,$order_total_amount);

           if($payment_url != '' && $access_token != '')
           {   
                $final_amt = $order_total_amount * 100;

                $rnd_no =rand();
                 // Get cURL resource
                $curl = curl_init();
                // Set some options - we are passing in a useragent too here
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $payment_url.'/v2/refunds',
                    CURLOPT_POSTFIELDS =>"{\n    \"idempotency_key\": \"$rnd_no\",\n    \"amount_money\": {\n      \"amount\": $final_amt,\n      \"currency\": \"USD\"\n    },\n    \"payment_id\": \"$order_payment_id\",\n    \"reason\": \"Order cancel refund\"\n  }",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "Square-Version: 2020-01-22",
                        "Authorization: Bearer $access_token"
                    )
                ));
                // Send the request & save response to $resp
                try
                {
                    $resp = curl_exec($curl);

                    if($resp)
                    {
                        $decoded_resp = json_decode($resp,true);
                        // dd($decoded_resp);

                        if(isset($decoded_resp['refund']['id']) && !empty($decoded_resp['refund']['id']))
                        {
                            $this->OrderModel->where('order_no',$order_no)
                                              ->where('transaction_id',$order_payment_id)
                                              ->where('seller_id',$order_seller_id)
                                              ->update([
                                                        'refund_status'=>1,
                                                        'refund_id'    =>$decoded_resp['refund']['id']
                                                    ]); //1 - Partially Completed
                            $order_det = $this->OrderModel->where('order_no',$order_no)
                                          ->where('transaction_id',$order_payment_id)
                                          ->where('seller_id',$order_seller_id)
                                          ->with(['buyer_details'])
                                          ->first();
                            if($order_det)
                            {
                                $order_det =$order_det->toArray();
                                         
                                if($order_det)
                                {
                                    if($order_det['withdraw_reqeust_status']==2 || $order_det['withdraw_reqeust_status']==1)
                                    {
                                        
                                        $balance_amount = floatval($site_setting_arr['seller_commission']) * floatval($order_det['total_amount']) /100;  
                                        $withdraw_bal_arr = [];
                                        $withdraw_bal_arr['seller_id']                  = $order_seller_id;
                                        $withdraw_bal_arr['to_user_id']                 = "1";
                                        $withdraw_bal_arr['order_id']                   = $order_det['id'];
                                        $withdraw_bal_arr['balance_amount']             = $balance_amount;
                                        $withdraw_bal_arr['refund_balance_status']      = "0";

                                        // dd($withdraw_bal_arr);
                                        $create_withdrawbal = $this->WithdrawalBalanceModel->create($withdraw_bal_arr);
                                    }
                                }
                            }

                            /*-------------------------------------------------------
                            |   Activity log Event
                            --------------------------------------------------------*/
                              
                               //save sub admin activity log 

                               $buyer_name = $order_det['buyer_details']['first_name'].' '.$order_det['buyer_details']['last_name'];

                                if(isset($user) && $user->inRole('sub_admin'))
                                {
                                    $arr_event                 = [];
                                    $arr_event['action']       = 'REFUND';
                                    $arr_event['title']        = $this->module_title;
                                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has refunded payment to the buyer '.$buyer_name.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                           

                            /*----------------------------------------------------------------------*/

                            $arr_response['status']      = 'success';
                            $arr_response['description'] = 'Refund is partially completed';
                            return response()->json($arr_response);
                        }
                        else
                        {
                            $arr_response['status']      = 'error';
                            $arr_response['description'] = 'Unable to get refund ID';
                            return response()->json($arr_response);
                        }       

                    }
                    else
                    {
                        $arr_response['status']      = 'error';
                        $arr_response['description'] = 'Invalid response';
                        return response()->json($arr_response);
                    }
                }
                catch(Exception $e)
                {
                    $arr_response['status']      = 'error';
                    $arr_response['description'] = $e->getMessage();
                    return response()->json($arr_response);  
                }

            }
            else
            {
                $arr_response['status']      = 'error';
                $arr_response['description'] = 'Payment URL is invalid';
                return response()->json($arr_response);
            }



//             $curl = curl_init();
// ​
//             curl_setopt_array($curl, array(
//               CURLOPT_URL => "https://connect.squareupsandbox.com/v2/refunds",
//               CURLOPT_RETURNTRANSFER => true,
//               CURLOPT_ENCODING => "",
//               CURLOPT_MAXREDIRS => 10,
//               CURLOPT_TIMEOUT => 0,
//               CURLOPT_FOLLOWLOCATION => true,
//               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//               CURLOPT_CUSTOMREQUEST => "POST",
//               CURLOPT_POSTFIELDS =>"{\n    \"idempotency_key\": \"123456777898410\",\n    \"amount_money\": {\n      \"amount\": 100,\n      \"currency\": \"USD\"\n    },\n    \"payment_id\": \"1wRnW0pQcelnjj7nbDg0yBuVuzcZY\",\n    \"reason\": \"demo refund\"\n  }",
//               CURLOPT_HTTPHEADER => array(
//                 "Content-Type: application/json",
//                 "Square-Version: 2020-01-22",
//                 "Authorization: Bearer EAAAEC63sYYCbZtNmOFxLRxn5AJQ6JerEvGellq5v-nYk3lTsQOTag2nV1VSu1Ct"
//               ),
//             ));
//             ​
//             $response = curl_exec($curl);
//             ​
//             curl_close($curl);
//             echo $response;


                
        }
        else
        {
            $arr_response['status']      = 'error';
            $arr_response['description'] = 'Order details are invalid.';
            return response()->json($arr_response);
        }

    }//end of function payment_refund 18jan21 bk




    public function payment_refund(Request $request)
    {
        $form_data = $request->all();


        $user = Sentinel::check();

        $order_no   = isset($form_data['order_no'])?$form_data['order_no']:'';
        $order_payment_id = isset($form_data['order_payment_id'])?$form_data['order_payment_id']:'';
        // dd($form_data);
        $order_total_amount = isset($form_data['order_total_amount'])?$form_data['order_total_amount']:'';
        $order_seller_id = isset($form_data['order_seller_id'])?$form_data['order_seller_id']:'';

        $order_cardlastfour = isset($form_data['order_cardlastfour'])?$form_data['order_cardlastfour']:'';

        $order_paymentgateway = isset($form_data['order_paymentgateway'])?$form_data['order_paymentgateway']:'';


        
        if($order_no != '' && $order_payment_id != '' && $order_total_amount != '' && $order_seller_id != '')
        {
            

            $site_setting_arr = [];

            $site_setting_obj = SiteSettingModel::first();  

            if(isset($site_setting_obj))
            {
                $site_setting_arr = $site_setting_obj->toArray();            
            }   


            $payment_url = '';
            $access_token = '';

            if(isset($site_setting_arr) && count($site_setting_arr)>0)
            {       
                $payment_mode         = $site_setting_arr['payment_mode'];
                $sandbox_url          = $site_setting_arr['sandbox_url'];
                $live_url             = $site_setting_arr['live_url'];
                $sandbox_access_token = $site_setting_arr['sandbox_access_token'];
                $live_access_token    = $site_setting_arr['live_access_token'];
                $sandbox_location_id  = $site_setting_arr['sandbox_location_id'];
                $live_location_id     = $site_setting_arr['live_location_id'];

                if($payment_mode == 0) 
                {
                    $payment_url  = $sandbox_url;
                    $access_token = $sandbox_access_token;
                }
                else if($payment_mode == 1)
                {
                    $payment_url = $live_url;
                    $access_token = $live_access_token;
                }


                 /*********authorizenet credentail*****************/
                  $sandbox_api_loginid = $site_setting_arr['sandbox_api_loginid'];
                  $sandbox_transactionkey = $site_setting_arr['sandbox_transactionkey'];

                  $live_api_loginid = $site_setting_arr['live_api_loginid'];
                  $live_transactionkey = $site_setting_arr['live_transactionkey'];


                   if(isset($sandbox_api_loginid) && $payment_mode=='0') 
                   {
                        $this->gateway->setAuthName($sandbox_api_loginid);
                   }
                    if(isset($sandbox_transactionkey) && $payment_mode=='0') 
                   {
                        $this->gateway->setTransactionKey($sandbox_transactionkey);
                   }
                    if(isset($live_api_loginid) && $payment_mode=='1') 
                   {
                        $this->gateway->setAuthName($live_api_loginid);
                   }
                    if(isset($live_transactionkey) && $payment_mode=='1') 
                   {
                        $this->gateway->setTransactionKey($live_transactionkey);
                   }

                   if($payment_mode=='0') 
                   {
                        $this->gateway->setTestMode(true);
                   }
           

             /*********authorizenet credentail*****************/
            }//if sitesetting


           if(isset($order_paymentgateway) && !empty($order_paymentgateway) && isset($order_cardlastfour) && $order_paymentgateway=="authorizenet")
           {

               
                $final_amt = $order_total_amount;
                try
                {
                    $newtransaction_id ='';
                    $transactionReference = $order_payment_id;
                    $response = $this->gateway->refund([
                        'amount' => $final_amt,
                        'currency' => 'USD',
                        'transactionReference' => $transactionReference,
                        'numberLastFour' => $order_cardlastfour,
                    ])->send();
                    
                   
                    if($response->isSuccessful())
                    {
                         $decoded_resp = $response->getTransactionReference();

                         //fetch the transaction responce
                          $getresponse = $this->gateway->fetchTransaction([
                                'transactionReference' => $decoded_resp,
                            ])->send();
                            $parsedata = $getresponse->getParsedData();


                            if(isset($parsedata) && !empty($parsedata)){
                              $newtransaction_id = isset( $parsedata->data['transaction']['transId'])?$parsedata->data['transaction']['transId']:'';
                            }//if parsedata
                           


                        if(isset($newtransaction_id) && !empty($newtransaction_id))
                        {
                            $this->OrderModel->where('order_no',$order_no)
                                              ->where('transaction_id',$order_payment_id)
                                              ->where('seller_id',$order_seller_id)
                                              ->update([
                                                        'refund_status'=>1,
                                                        'refund_id'    =>$newtransaction_id
                                                    ]); //1 - Partially Completed
                            $order_det = $this->OrderModel->where('order_no',$order_no)
                                          ->where('transaction_id',$order_payment_id)
                                          ->where('seller_id',$order_seller_id)
                                          ->with(['buyer_details'])
                                          ->first();
                            if($order_det)
                            {
                                $order_det =$order_det->toArray();
                                         
                                if($order_det)
                                {
                                    if($order_det['withdraw_reqeust_status']==2 || $order_det['withdraw_reqeust_status']==1)
                                    {
                                        
                                        $balance_amount = floatval($site_setting_arr['seller_commission']) * floatval($order_det['total_amount']) /100;  
                                        $withdraw_bal_arr = [];
                                        $withdraw_bal_arr['seller_id']  = $order_seller_id;
                                        $withdraw_bal_arr['to_user_id'] = "1";
                                        $withdraw_bal_arr['order_id']   = $order_det['id'];
                                        $withdraw_bal_arr['balance_amount']= $balance_amount;
                                        $withdraw_bal_arr['refund_balance_status'] = "0";

                                        // dd($withdraw_bal_arr);
                                        $create_withdrawbal = $this->WithdrawalBalanceModel->create($withdraw_bal_arr);
                                    }
                                }
                            }

                            /*-------------------------------------------------------
                            |   Activity log Event
                            --------------------------------------------------------*/
                              
                               //save sub admin activity log 

                               $buyer_name = $order_det['buyer_details']['first_name'].' '.$order_det['buyer_details']['last_name'];

                                if(isset($user) && $user->inRole('sub_admin'))
                                {
                                    $arr_event                 = [];
                                    $arr_event['action']       = 'REFUND';
                                    $arr_event['title']        = $this->module_title;
                                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has refunded payment to the buyer '.$buyer_name.'.';

                                    $result = $this->UserService->save_activity($arr_event); 
                                }

                            /*--------------------------------------------*/

                            $arr_response['status']      = 'success';
                            $arr_response['description'] = 'Refund is partially completed';
                            return response()->json($arr_response);
                        }
                        else
                        {
                            $arr_response['status']      = 'error';
                            $arr_response['description'] = 'Unable to get refund ID';
                            return response()->json($arr_response);
                        }       

                    }
                    else
                    {

                        $arr_response['status'] = "error";
                        $arr_response['description'] = $response->getMessage();
                        return response()->json($arr_response);
                    }
                }
                catch(Exception $e)
                {
                    $arr_response['status']      = 'error';
                    $arr_response['description'] = $e->getMessage();
                    return response()->json($arr_response);  
                }

            }//if order_paymentgateway is authorizenet
            else if(isset($order_paymentgateway) && $order_paymentgateway=="square")
            {


                if($payment_url != '' && $access_token != '')
                {   
                    $final_amt = $order_total_amount * 100;

                    $rnd_no =rand();
                     // Get cURL resource
                    $curl = curl_init();
                    // Set some options - we are passing in a useragent too here
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => $payment_url.'/v2/refunds',
                        CURLOPT_POSTFIELDS =>"{\n    \"idempotency_key\": \"$rnd_no\",\n    \"amount_money\": {\n      \"amount\": $final_amt,\n      \"currency\": \"USD\"\n    },\n    \"payment_id\": \"$order_payment_id\",\n    \"reason\": \"Order cancel refund\"\n  }",
                        CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/json",
                            "Square-Version: 2020-01-22",
                            "Authorization: Bearer $access_token"
                        )
                    ));
                    // Send the request & save response to $resp
                        try
                        {
                            $resp = curl_exec($curl);

                            if($resp)
                            {
                                $decoded_resp = json_decode($resp,true);
                                // dd($decoded_resp);

                                if(isset($decoded_resp['refund']['id']) && !empty($decoded_resp['refund']['id']))
                                {
                                    $this->OrderModel->where('order_no',$order_no)
                                                      ->where('transaction_id',$order_payment_id)
                                                      ->where('seller_id',$order_seller_id)
                                                      ->update([
                                                                'refund_status'=>1,
                                                                'refund_id'    =>$decoded_resp['refund']['id']
                                                            ]); //1 - Partially Completed
                                    $order_det = $this->OrderModel->where('order_no',$order_no)
                                                  ->where('transaction_id',$order_payment_id)
                                                  ->where('seller_id',$order_seller_id)
                                                  ->with(['buyer_details'])
                                                  ->first();
                                    if($order_det)
                                    {
                                        $order_det =$order_det->toArray();
                                                 
                                        if($order_det)
                                        {
                                            if($order_det['withdraw_reqeust_status']==2 || $order_det['withdraw_reqeust_status']==1)
                                            {
                                                
                                                $balance_amount = floatval($site_setting_arr['seller_commission']) * floatval($order_det['total_amount']) /100;  
                                                $withdraw_bal_arr = [];
                                                $withdraw_bal_arr['seller_id']= $order_seller_id;
                                                $withdraw_bal_arr['to_user_id'] = "1";
                                                $withdraw_bal_arr['order_id'] = $order_det['id'];
                                                $withdraw_bal_arr['balance_amount']             = $balance_amount;
                                                $withdraw_bal_arr['refund_balance_status'] = "0";

                                                // dd($withdraw_bal_arr);
                                                $create_withdrawbal = $this->WithdrawalBalanceModel->create($withdraw_bal_arr);
                                            }
                                        }
                                    }

                                    /*-------------------------------------------------------
                                    |   Activity log Event
                                    --------------------------------------------------------*/
                                      
                                       //save sub admin activity log 

                                       $buyer_name = $order_det['buyer_details']['first_name'].' '.$order_det['buyer_details']['last_name'];

                                        if(isset($user) && $user->inRole('sub_admin'))
                                        {
                                            $arr_event                 = [];
                                            $arr_event['action']       = 'REFUND';
                                            $arr_event['title']        = $this->module_title;
                                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has refunded payment to the buyer '.$buyer_name.'.';

                                            $result = $this->UserService->save_activity($arr_event); 
                                        }

                                   

                                    /*----------------------------------------------------------------------*/

                                    $arr_response['status']      = 'success';
                                    $arr_response['description'] = 'Refund is partially completed';
                                    return response()->json($arr_response);
                                }
                                else
                                {
                                    $arr_response['status']      = 'error';
                                    $arr_response['description'] = 'Unable to get refund ID';
                                    return response()->json($arr_response);
                                }       

                            }
                            else
                            {
                                $arr_response['status']      = 'error';
                                $arr_response['description'] = 'Invalid response';
                                return response()->json($arr_response);
                            }
                        }
                        catch(Exception $e)
                        {
                            $arr_response['status']      = 'error';
                            $arr_response['description'] = $e->getMessage();
                            return response()->json($arr_response);  
                        }

                }
                else
                {
                    $arr_response['status']      = 'error';
                    $arr_response['description'] = 'Payment URL is invalid';
                    return response()->json($arr_response);
                }


            }//else if order payment gateway is square

                          
        }
        else
        {
            $arr_response['status']      = 'error';
            $arr_response['description'] = 'Order details are invalid.';
            return response()->json($arr_response);
        }

    }//end of function payment_refund








    // export excel function added   
    function export($from_date,$to_date)
    {
        if($from_date && $to_date)
       {
        $completedflag = 0;
        $this->OrderService->export_orders($from_date,$to_date,$completedflag,NULL);
       }
            
    }// end of function



    // export csv function added   
    function exportcsv($from_date,$to_date)
    {
        if($from_date && $to_date)
       {
        $completedflag = 0;
        $this->OrderService->export_orders_csv($from_date,$to_date,$completedflag,NULL);
       }
            
    }// end of function





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
                $arr_event['description']  = html_entity_decode('You have cancelled the order with order no. : <a target="_blank" href="'.$admin_panel_order_url.'"><b>'. $order_details['order_no'].'</b></a>.'); 
                $arr_event['type']         = '';
                $arr_event['title']        = 'Order '. $order_details['order_no'].' Cancelled';

                $this->GeneralService->save_notification($arr_event);

            /*******************Send Notification to Admin (END)***************************/


            /*******************Send Mail Notification to Admin (START)****************************/
               /* $msg    = html_entity_decode('You have cancelled the order with order no. : <b>'. $order_details['order_no'].'</b>.'); 
                       
                $subject     = 'Order '. $order_details['order_no'].' Cancelled';*/

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      'ORDER_NO'      => $order_details['order_no'],
                                      //'MESSAGE'     => $msg,
                                      'URL'           => $admin_panel_order_url
                                     ];

                $arr_built_subject = [
                                      'ORDER_NO'      => $order_details['order_no']
                                     ];                          

                $arr_mail_data['email_template_id'] = '97';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section_order($arr_mail_data); 

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
                    $arr_event['description']  = html_entity_decode('Admin <b>'.$user_name.'</b> has cancelled the order with order no : <a target="_blank" href="'.$seller_panel_order_url.'"><b>'.$order_details['order_no'].'</b></a>.');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Order '.$order_details['order_no'].' Cancelled';
                   
                    $this->GeneralService->save_notification($arr_event);
                }

           
            /******************* Send Notification to Seller (END) ***************************/

            /***************Send Mail Notification to Seller (START)**************************/
               /* $msg    = html_entity_decode('Admin <b>'.$user_name.'</b> has cancelled the order with order no : <b>'.$order_details['order_no'].'</b>.');
                       
                $subject     = 'Order '.$order_details['order_no'].' Cancelled';*/

                $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'     => $msg,
                                      'ADMIN_NAME'    => $user_name,
                                      'ORDER_NO'      => $order_details['order_no'], 
                                      'URL'           => $seller_panel_order_url
                                     ];

                $arr_built_subject = [
                                      'ORDER_NO'      => $order_details['order_no']
                                     ];                      

                $arr_mail_data['email_template_id'] = '98';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($seller_id);

                $this->EmailService->send_mail_section_order($arr_mail_data);  
            /***************Send Mail Notification to Seller (END)****************************/


            /******************* Send Notification to Buyer (START)  *************************/
                $buyer_panel_order_url = url('/').'/buyer/order/view/'.base64_encode($order_details['id']);

                $from_user_id = 0;
                $admin_id     = 0;
                // $user_name    = "";
                $arr_buyer                = $this->OrderModel
                                                  ->select('buyer_id')
                                                  ->with(['buyer_details'])
                                                  ->where('id',$order_details['id'])
                                                  ->first();
                 
                if(!empty($arr_buyer))
                {
                    $arr_buyer = $arr_buyer->toArray();
                }

                if(isset($arr_buyer) && count($arr_buyer)>0 && (!empty($arr_buyer)))
                {   
                    $buyer_id    = $arr_buyer['buyer_id'];
                    $buyer_fname = isset($arr_buyer['buyer_details']['first_name'])?$arr_buyer['buyer_details']['first_name']:'';
                    $buyer_lname = isset($arr_buyer['buyer_details']['last_name'])?$arr_buyer['buyer_details']['last_name']:'';

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $buyer_id;
                    $arr_event['description']  = html_entity_decode('Admin <b>'.$user_name.'</b> has cancelled the order with order no : <a target="_blank" href="'.$buyer_panel_order_url.'"><b>'.$order_details['order_no'].'</b></a>.');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Order '.$order_details['order_no'].' Cancelled';
                   
                    $this->GeneralService->save_notification($arr_event);
                }

           
            /******************* Send Notification to Buyer (END) ***************************/

            /***************Send Mail Notification to Buyer (START)**************************/
               /* $msg    = html_entity_decode('Admin <b>'.$user_name.'</b> has cancelled the order with order no : <b>'.$order_details['order_no'].'</b>.');
                       
                $subject     = 'Order '.$order_details['order_no'].' Cancelled';*/

                $arr_built_content = ['USER_NAME'     => $buyer_fname.' '.$buyer_lname,
                                      'APP_NAME'      => config('app.project.name'),
                                      'ORDER_NO'      => $order_details['order_no'],
                                      'ADMIN_NAME'    => $user_name,
                                      //'MESSAGE'       => $msg,
                                      'URL'           => $buyer_panel_order_url
                                     ];

                $arr_built_subject = [
                                      'ORDER_NO'      => $order_details['order_no']
                                     ];                     

                $arr_mail_data['email_template_id'] = '98';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($buyer_id);

                $this->EmailService->send_mail_section_order($arr_mail_data);  

            /*****************Send Mail Notification to Buyer(END)**************************/


            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
            //save sub admin activity log 

            if(isset($user) && $user->inRole('sub_admin'))
            {
                $arr_event                 = [];
                $arr_event['action']       = 'CANCELLED';
                $arr_event['title']        = $this->module_title;
                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has cancelled the order of buyer '.$buyer_fname.' '.$buyer_lname.'.';

                $result = $this->UserService->save_activity($arr_event); 
            }

            /*----------------------------------------------------------------------*/


       
            $response['status']      = 'SUCCESS';
            $response['description'] = 'Order cancelled successfully'; 
            return response()->json($response);
        }
   
    }//end

   public function cancel_cashback($orderno,$buyerid)
   {

     if(isset($orderno) && isset($buyerid))
     {

        $check_wallet_exists = $this->BuyerWalletModel
                                   ->where('typeid',base64_decode($orderno))
                                   ->where('user_id',base64_decode($buyerid))
                                   ->where('status',1)
                                   ->where('type','Cashback')
                                   ->first();
        if(isset($check_wallet_exists) && !empty($check_wallet_exists))
        {
           $check_wallet_exists = $check_wallet_exists->toArray();

           $cashback_amount = str_replace("+","-",$check_wallet_exists['amount']);

           $insert_debited_entry = [];

           $insert_debited_entry['type'] = $check_wallet_exists['type'];
           $insert_debited_entry['typeid'] = $check_wallet_exists['typeid'];
           $insert_debited_entry['user_id'] = $check_wallet_exists['user_id'];
           $insert_debited_entry['status'] = 2; //withdrawn/debited
           $insert_debited_entry['amount'] = $cashback_amount;
           $insertid = $this->BuyerWalletModel->insert($insert_debited_entry);

             if($insertid)
            {
                $cashback_amount = str_replace("+"," ",$check_wallet_exists['amount']);


                $buyer_wallet_url = url('/').'/buyer/wallet';
                $admin_id = get_admin_id();

                $arr_event                 = [];
                $arr_event['from_user_id'] = $admin_id;
                $arr_event['to_user_id']   = $check_wallet_exists['user_id'];
                $arr_event['description']  = 'Your cashback of amount $'.number_format($cashback_amount,2).' get cancelled by admin for Order No : <a target="_blank" href="'.$buyer_wallet_url.'">'. $check_wallet_exists['typeid'].'</a>';
                $arr_event['title']        = 'Cashback';
                $arr_event['type']         = 'buyer';   
                $this->GeneralService->save_notification($arr_event);

                //send email


                $to_user = Sentinel::findById($check_wallet_exists['user_id']);
                $fname   = $l_name = ""; 

                if(isset($to_user) && !empty($to_user))
                {  
                 $first_name  = isset($to_user->first_name)?$to_user->first_name:'';
                 $last_name  = isset($to_user->last_name)?$to_user->last_name:'';
                }

                //SEND EMAIL TO USER
                $arr_built_content = 
                ['USER_NAME'     => $first_name.' '.$last_name,
                'APP_NAME'      => config('app.project.name'),
                //  'MESSAGE'       => $msg,
                'AGE_URL'       => $buyer_wallet_url,
                'ORDER_NO'      => $check_wallet_exists['typeid'],
                'CASHBACK_AMOUNT'=> '$'.number_format($cashback_amount,2)
                ];
                $arr_built_subject =  [
                'ORDER_NO'      => $check_wallet_exists['typeid']
                ];    

                $arr_mail_data['email_template_id'] = '158';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($check_wallet_exists['user_id']);
                $this->EmailService->send_mail_section_order($arr_mail_data);  

               Flash::success('Cashback cancelled successfully');


            }
            else
            {
                Flash::error('Problem occurred while canceling cashback');
            }
            return redirect()->back();


        }//isset checkwalletexists                           

     }//isset
   }//end cancel_cashback 
}//class
