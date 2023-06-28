<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\TransactionModel;


use Sentinel;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentHistoryController extends Controller
{

    public function __construct(
                                
                UserModel $user,
                BuyerModel $BuyerModel,
                SellerModel $SellerModel,
                OrderModel $OrderModel,
                OrderProductModel $OrderProductModel,
                TransactionModel $TransactionModel
               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;

        $this->BuyerModel          = $BuyerModel;
        $this->SellerModel         = $SellerModel;
        $this->TransactionModel    = $TransactionModel;
        $this->OrderModel          = $OrderModel;
        $this->OrderProductModel   = $OrderProductModel;
        
        $this->arr_view_data       = [];

        $this->module_title       = "Payment History";
        $this->module_view_folder = "seller/payment-history";
        $this->module_url_path      = url('/')."/seller/payment-history";
        
        $this->module_icon        = "fa-cogs";
    }


    public function index()
    {
        $buyer_arr = $seller_arr = [];

        $user_details = false;
        $user_details = Sentinel::getUser();        

        $user_details_arr = $user_details->toArray();

        

        if($user_details->inRole('seller'))
        {
            $seller_obj = $this->SellerModel->where('user_id',$user_details->id)->first();

            if($seller_obj)
            {
                $seller_arr = $seller_obj->toArray();
                $user_details_arr['user_details']  = $seller_arr;
            }
        }

        
        $this->arr_view_data['user_details_arr']     = $user_details_arr;
       
        $this->arr_view_data['page_title']           = 'Payment History';
        $this->arr_view_data['module_url_path']           = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_payment_history(Request $request)
        {  
            $loggedInUserId = 0;
            $user = Sentinel::check();

            if($user)
            {
                $loggedInUserId = $user->id;
            }

           
            $transaction_table = $this->TransactionModel->getTable();
            $prefixed_transaction_tbl = DB::getTablePrefix().$transaction_table;

            $user_tbl_name              = $this->UserModel->getTable();
            $prefixed_user_tbl          = DB::getTablePrefix().$this->UserModel->getTable();

            $order_tbl_name              = $this->OrderModel->getTable();
            $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

            $order_product_tbl_name      = $this->OrderProductModel->getTable();
            $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();

            $obj_qutoes = DB::table($order_tbl_name)
                                 
                                    ->select(DB::raw($order_tbl_name.".*,".
                                                     $prefixed_transaction_tbl.".transaction_status"
                                                   ))
                                    //->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_order_tbl.'.seller_id')
                                    //->leftjoin($prefixed_order_product_tbl,$prefixed_order_product_tbl.'.order_id','=',$prefixed_order_tbl.'.id')
                                    ->leftjoin($prefixed_transaction_tbl,$prefixed_transaction_tbl.'.order_no','=',$order_tbl_name.'.order_no')
                                    ->where($order_tbl_name.'.seller_id',$loggedInUserId)
                                   ->orderBy($order_tbl_name.".id",'DESC');
            
            /* ---------------- Filtering Logic ----------------------------------*/                    
            $arr_search_column = $request->input('column_filter');

                  
            if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
            {
                $search_term      = $arr_search_column['q_order_no'];
                $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.order_no','LIKE', '%'.$search_term.'%');
            }

            if(isset($arr_search_column['q_transaction_id']) && $arr_search_column['q_transaction_id']!="")
            {
                $search_trans      = $arr_search_column['q_transaction_id'];
                $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.transaction_id','LIKE', '%'.$search_trans.'%');
            }
           
            if(isset($arr_search_column['q_price']) && $arr_search_column['q_price']!="")
            {
                $search_price      = $arr_search_column['q_price'];
                $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.total_amount','LIKE', '%'.$search_price.'%');
            }

            if(isset($arr_search_column['q_payment_status']) && $arr_search_column['q_payment_status']!="")
            {  
               
                $search_term = $arr_search_column['q_payment_status'];
                $obj_qutoes = $obj_qutoes->where($prefixed_transaction_tbl.'.transaction_status','LIKE', '%'.$search_term.'%');
            }

            if(isset($arr_search_column['q_order_date']) && $arr_search_column['q_order_date']!="")
            {
                $search_date  = $arr_search_column['q_order_date'];                
                $search_date  = date('Y-m-d',strtotime($search_date));
                //$search_date_column = date($order_tbl_name.'.created_at'); 
                // $obj_qutoes = $obj_qutoes->where($search_date_column,'LIKE', '%'.$search_date.'%');
                $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.created_at','LIKE', '%'.$search_date.'%');
            }    

           

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
                                    return 'Completed';
                                }
                                else{
                                    return 'Failed';
                                } 


                            })
                            ->editColumn('total_amount',function($data) use ($current_context)
                           {
                                $final_amount = $data->total_amount;

                                   if($final_amount>0)
                                    {

                                        if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!='' 
                                            && isset($data->seller_discount_amt) 
                                            && $data->seller_discount_amt!='')
                                        {
                                            $final_amount =  (float)$final_amount - (float)$data->seller_discount_amt; 
                                        }

                                        if (isset($data->delivery_option_id) && $data->delivery_option_id != null) {

                                            $final_amount = $final_amount + $data->delivery_cost;
                                        }

                                        if (isset($data->tax) && $data->tax != null) {

                                            $final_amount = $final_amount + $data->tax;
                                        }


                                        return $final_amount; 
                                       
                                    }else{
                                       return "-"; 
                                    }
 

                           })
                            ->editColumn('order_no',function($data) use ($current_context)
                            {

                               $user = Sentinel::check();
                                if($user)
                                {
                                    $loggedInUserId = $user->id;
                                } 

                                 $get_orderids = $this->OrderModel->select('id')
                                            ->where('order_no',$data->order_no)
                                            ->where('seller_id',$loggedInUserId)
                                            ->get()->toArray();

                                 if(!empty($get_orderids) && count($get_orderids)>0){
                                
                                    $id = base64_encode($get_orderids[0]['id']);
                                    $orderno_href =  url('/')."/seller/order".'/view/'.$id;

                                    $orderno_action = '<a target="_blank" href="'.$orderno_href.'" title="View Order Details">'.$data->order_no.'</a>';

                                    return $orderno_action;          
                                }else{
                                     return '-';   
                                }


                            })
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                            
                                
                                $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                                $build_view_action = '<a href="'.$view_href.'" class="eye-actn" title="View Payment Details">
                                View
                                </a>';

                               
                                return $build_action = $build_view_action;
                            });
            $build_result = $json_result->make(true)->getData();

            return response()->json($build_result);
        }

    public function view($enc_id="") {
        
        $product_arr = [];
        $order_id    = base64_decode($enc_id); 

        if ($order_id) {

            $obj_order_details = $this->OrderModel
                                        ->with(['order_product_details.product_details.product_images_details','buyer_details','address_details','transaction_details'])
                                        ->where('id',$order_id)
                                        ->first();
        }

        if($obj_order_details) {

            $product_arr = $obj_order_details->toArray();
        }

        $this->arr_view_data['product_arr'] = $product_arr;
        $this->arr_view_data['page_title']  = 'Product Details';

        return view($this->module_view_folder.'.view',$this->arr_view_data);
    }
}
