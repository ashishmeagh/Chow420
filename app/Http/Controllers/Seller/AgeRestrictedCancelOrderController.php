<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\UserModel;
use App\Common\Services\GeneralService;
use App\Models\SellerModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\ProductInventoryModel;
use App\Models\TransactionModel;
use App\Models\DisputeModel;
use App\Models\CountriesModel;
use App\Models\SiteSettingModel;


use App\Common\Services\EmailService;
use App\Common\Services\OrderService;


use Sentinel;
use Datatables;
use DB;
use Flash;
use Session;
use Carbon\Carbon;

class AgeRestrictedCancelOrderController extends Controller
{
    
    public function __construct ( 
	                                SellerModel $SellerModel,
	                                GeneralService $GeneralService,
	                                OrderModel $OrderModel,
	                                OrderProductModel $OrderProductModel,
	                                TransactionModel $TransactionModel,
	                                ProductInventoryModel $ProductInventoryModel,
	                                DisputeModel $DisputeModel,
	                                EmailService $EmailService,
	                                OrderService $OrderService,
	                                UserModel $UserModel,
	                                CountriesModel $CountriesModel,
	                                SiteSettingModel $SiteSettingModel
                                
                                )

    {
        
     
        $this->arr_view_data       = [];
        $this->module_title        = "Age Restricted Cancelled Orders";
        $this->module_view_folder  = "seller/order";
        $this->module_url_path     = url('/')."/seller/age_restricted_cancelled_order";

        $this->EmailService       = $EmailService;
        $this->SellerModel        = $SellerModel;
        $this->GeneralService     = $GeneralService;
        $this->TransactionModel    = $TransactionModel;
        $this->ProductInventoryModel = $ProductInventoryModel;
        $this->OrderModel          = $OrderModel;
        $this->OrderProductModel   = $OrderProductModel;
        $this->DisputeModel        = $DisputeModel; 
        $this->OrderService        = $OrderService; 
        $this->UserModel           = $UserModel;
        $this->CountriesModel      = $CountriesModel;
        $this->SiteSettingModel    = $SiteSettingModel;


    }

    public function index()
    {
        $this->arr_view_data['page_title']           = $this->module_title;
        $this->arr_view_data['module_url_path']      = $this->module_url_path;
        return view($this->module_view_folder.'.restricted_cancelled_order',$this->arr_view_data);
         
    }


    public function get_order_details(Request $request)
    {  
        $loggedInUserId = 0;
        $user = Sentinel::check();

        if($user)
        {
            $loggedInUserId = $user->id;
        }
       
        

        $order_tbl_name              = $this->OrderModel->getTable();
        $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_tbl_name      = $this->OrderProductModel->getTable();
        $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $dispute_tbl_name            = $this->DisputeModel->getTable();
        $prefixed_dispute_tbl        = DB::getTablePrefix().$this->DisputeModel->getTable();

        $user_table                  = $this->UserModel->getTable();
        $prefixed_user_table         = DB::getTablePrefix().$this->UserModel->getTable();

        $transaction_table           = $this->TransactionModel->getTable();
        $prefixed_transaction_tbl    = DB::getTablePrefix().$transaction_table;


        $obj_qutoes = DB::table($order_tbl_name)
                             
                        ->select(DB::raw($order_tbl_name.".*,".
                                        $prefixed_dispute_tbl.'.dispute_reason,'
                                        .$prefixed_dispute_tbl.'.dispute_status,'
                                        .$prefixed_dispute_tbl.'.is_dispute_finalized,'
                                        .$prefixed_transaction_tbl.".transaction_status,"
                                        ."CONCAT(".$prefixed_user_table.".first_name,' ',".$prefixed_user_table.".last_name) as buyername"
                                       ))
                        ->where($order_tbl_name.'.buyer_age_restrictionflag',1)

                        ->where($order_tbl_name.'.seller_id',$loggedInUserId)
                        
                        ->where($order_tbl_name.'.order_status','=','0')
                        
                        ->leftjoin($prefixed_user_table,$prefixed_user_table.'.id','=',$order_tbl_name.'.buyer_id')
 
                        ->leftjoin($prefixed_transaction_tbl,$prefixed_transaction_tbl.'.order_no','=',$order_tbl_name.'.order_no')

                        ->leftjoin($prefixed_dispute_tbl,$prefixed_dispute_tbl.'.order_id','=',$order_tbl_name.'.id');




                        /* ---------------- Filtering Logic --------------*/                    
                        $arr_search_column = $request->input('column_filter');
                   
                        if(isset($arr_search_column['q_transaction_id']) && $arr_search_column['q_transaction_id']!="")
                        {
                            $search_trans_term      = $arr_search_column['q_transaction_id'];
                            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.transaction_id','LIKE', '%'.$search_trans_term.'%');
                        }
                       
                        if(isset($arr_search_column['q_price']) && $arr_search_column['q_price']!="")
                        {
                            $search_term_price      = $arr_search_column['q_price'];
                            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.total_amount','LIKE', '%'.$search_term_price.'%');
                        }
    

                        if(isset($arr_search_column['q_order_status']) && $arr_search_column['q_order_status']!="")
                        {
                            
                            $search_term_ostatus = intval($arr_search_column['q_order_status']);
                            $obj_qutoes = $obj_qutoes->where($prefixed_transaction_tbl.'.order_status', $search_term_ostatus);
                            
                        }

                        if(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name']!="")
                        {
                            $search_buyername      = $arr_search_column['q_buyer_name'];
                           // $obj_user = $obj_user->having('first_name','LIKE', '%'.$search_term.'%');
                            $obj_qutoes = $obj_qutoes->where('first_name','LIKE', '%'.$search_buyername.'%')->orWhere('last_name','LIKE','%'.$search_buyername.'%');

                        }

                        if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
                        { 
                            $search_termno   = $arr_search_column['q_order_no'];
                            $obj_qutoes      = $obj_qutoes->where($order_tbl_name.'.order_no','LIKE', '%'.$search_termno.'%');
                        }

                        if(isset($arr_search_column['q_orderdate']) && $arr_search_column['q_orderdate']!="")
                        {
                           
                            $search_orderdate = $arr_search_column['q_orderdate'];
                            $search_orderdate = date('Y-m-d',strtotime($search_orderdate));
                             
                            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.created_at','LIKE', '%'.$search_orderdate.'%'); 
                  
                        }


                        if(isset($arr_search_column['q_payment_status']) && $arr_search_column['q_payment_status']!="")
                        {
                                    
                            $search_term = intval($arr_search_column['q_payment_status']);
                        
                            $obj_qutoes = $obj_qutoes->where($prefixed_transaction_tbl.'.transaction_status', $search_term);
                        }  


                        if(isset($arr_search_column['q_from']) && $arr_search_column['q_from']!="" && isset($arr_search_column['q_to']) && $arr_search_column['q_to']!="")
                        {
                            $search_from    = $arr_search_column['q_from'];
                            $search_from    = date('Y-m-d',strtotime($search_from));

                            $search_to      = $arr_search_column['q_to'];
                            $search_to      = date('Y-m-d',strtotime($search_to));

                             $search_from   = $search_from.' 00:00:00';
                             $search_to     = $search_to.' 23:59:59';

                            $obj_qutoes    = $obj_qutoes->whereBetween($order_tbl_name.'.created_at',[$search_from,$search_to]);
      
                        }            
                          
                        $obj_qutoes = $obj_qutoes->orderBy($order_tbl_name.".id",'DESC');
        


				        $current_context = $this;

				        $json_result  = Datatables::of($obj_qutoes);
				        
		       			$json_result  = $json_result->editColumn('created_at',function($data) use ($current_context)
                        {
                            return us_date_format($data->created_at);


                        })
                        ->editColumn('transaction_status',function($data) use ($current_context)
                        {

                            if ($data->transaction_status == 0) {
                                return 'Pending';
                            }
                            elseif ($data->transaction_status == 1) {
                                return 'Paid';
                            }
                            else{
                                return 'Failed';
                            }
 

                        })
                        ->editColumn('order_status',function($data) use ($current_context)
                        {

                            if ($data->order_status == 2) {
                                return 'Ongoing';
                            }
                            elseif ($data->order_status == 3) {
                                return 'Shipped';
                            }
                             elseif ($data->order_status == 4) {
                                return 'Ongoing';
                            }
                            elseif ($data->order_status == 1) {
                                return 'Delivered';
                            }else{
                                return 'Cancelled';
                            }

                        }) 
                        ->editColumn('order_no',function($data) use ($current_context)
                        {
                            $orderno_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                            $build_orderno_action = '<a target="_blank" href="'.$orderno_href.'" title="View Order Details">
                            '.$data->order_no.'</a>';
                            return $build_orderno_action;
                          
                        })
                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                            $tracking_no           = isset($data->tracking_no)?$data->tracking_no:'';
                            $shipping_company_name = isset($data->shipping_company_name)?$data->shipping_company_name:'';
                            $enc_id = isset($data->id)?base64_encode($data->id):'';


                            if($data->order_status==3) // if status is shipped
                            { 
                                $build_completeorder_action='';
                                $complete_href =  $this->module_url_path.'/delivered/'.base64_encode($data->id);

                            }

                            elseif($data->order_status==2) // if status is ongoing
                            { 
                                $shipped_href =  $this->module_url_path.'/shipped/'.base64_encode($data->id);

                                $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="'. $shipped_href.'" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="'.$tracking_no.'" data-shipping_company_name="'.$shipping_company_name.'" data-enc_id="'.$enc_id.'">Shipped</a>';     
                            }

                            elseif($data->order_status==4) // if status is dispatched
                            {

                                $shipped_href =  $this->module_url_path.'/shipped/'.base64_encode($data->id);

                                $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="'. $shipped_href.'" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="'.$tracking_no.'" data-shipping_company_name="'.$shipping_company_name.'" data-enc_id="'.$enc_id.'">Shipped</a>';  

                            }

                            else
                            {
                                $build_completeorder_action='';
                            }  
                            
                            $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                            $build_view_action = '<a href="'.$view_href.'" class="eye-actn" title="View Order Details">
                            View</a>';


                            $build_dispute_action='';
                            if(($data->order_status=='1' || $data->order_status=='3') && $data->dispute_status=='1' && $data->dispute_reason!="" && $data->is_dispute_finalized=='0'){ 
                               $url_dispute = url('/').'/seller/dispute/'.base64_encode($data->id);
                               $build_dispute_action = '<a href="'.$url_dispute.'" class="btns-approved">Dispute Raised</a>';
                            }
                            elseif(($data->order_status=='1' || $data->order_status=='3') && $data->dispute_status=='1' && $data->dispute_reason!="" && $data->is_dispute_finalized=='1'){ 
                               $url_dispute = url('/').'/seller/dispute/'.base64_encode($data->id);
                               $build_dispute_action = '<a href="'.$url_dispute.'" class="btns-approved">Dispute Closed</a>';
                            }

                           
                            /*return $build_action = $build_completeorder_action.' '.$build_view_action.' '.$build_dispute_action;*/

                            return $build_action = $build_view_action.' '.$build_dispute_action;

                        });


        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
    }

    public function view($enc_id="")
    { 

        if(request()->segment(3)!="")
        {
            $order_type = request()->segment(3);
        }
        
        $product_status = '';
        $product_arr = $tracking_info = $lable_info = [];
        $order_id = base64_decode($enc_id);
        if ($order_id) {

            $obj_order_details = $this->OrderModel
                            ->with(['order_product_details.product_details.product_images_details','buyer_details','address_details.state_details','address_details.country_details','address_details.billing_state_details','address_details.billing_country_details','transaction_details','seller_details',
                              'order_product_details.age_restriction_detail'
                              ])
                            ->where('id',$order_id)
                            ->first();
        }

        if($obj_order_details)
        {
            $product_arr = $obj_order_details->toArray();

            if ($product_arr['order_status'] == 2) {
                $product_status = 'ongoing';
            }
            elseif ($product_arr['order_status'] == 3) {
                $product_status = 'ongoing';
            }
            elseif ($product_arr['order_status'] == 1) {
                $product_status = 'delivered';
            }else{
                $product_status = 'Cancelled';
            }

        }

        if($product_arr['tracking_no']!=null && $product_arr['shipping_company_name']!="" && ($product_arr['order_status']== 3 || $product_arr['order_status'] == 1))
        {
           $tracking_info = $this->track_order($product_arr['tracking_no'],$product_arr['shipping_company_name']);
                          
            //dd($tracking_info);        
          // $view_tracking = $this->branding_page($tracking_info,$product_arr);

             if($product_arr['order_status'] == 1 && isset($tracking_info) && !empty($tracking_info) && isset($tracking_info['status_code']) && $tracking_info['status_code']=="DE" && isset($tracking_info['status_description']) && $tracking_info['status_description']=="Delivered")
            {
               $lable_info   =  $this->generate_lable($product_arr);
            }  


        }//if order status is shipped or delivered  and no and company also there 


      


        $this->arr_view_data['product_arr']          = $product_arr;
        $this->arr_view_data['tracking_info']        = $tracking_info;
        $this->arr_view_data['lable_info']           = $lable_info;
        $this->arr_view_data['page_title']           = 'Order Details';
        $this->arr_view_data['order_type']           = $order_type;
        $this->arr_view_data['product_status']       = $product_status;
        // dd($this->arr_view_data);
        return view($this->module_view_folder.'.view',$this->arr_view_data);
    }


       // export function added   
    function export($from_date,$to_date,$excelorderstatus)
    { 
        if($from_date && $to_date && $excelorderstatus)
        {

	        if(Sentinel::check())
	        {
	            $user_details = Sentinel::getUser();
	            $seller_user_id = $user_details->id;
	        }

            //pass buyer age restriction variable
            $buyer_age_restrictionflag = 1;
            $this->OrderService->export_orders($from_date,$to_date,$excelorderstatus,$seller_user_id,$buyer_age_restrictionflag);
       }
            
    }// end of function



    // export function added   
    function exportcsv($from_date,$to_date,$excelorderstatus)
    {  
        if($from_date && $to_date && $excelorderstatus)
        {

	        if(Sentinel::check())
	        {
	            $user_details = Sentinel::getUser();
	            $seller_user_id = $user_details->id;
	          
	        }

            //pass buyer age restriction variable
            $buyer_age_restrictionflag = 1;
            $this->OrderService->export_orders_csv($from_date,$to_date,$excelorderstatus,$seller_user_id,$buyer_age_restrictionflag);

       }
            
    }// end of function



}
