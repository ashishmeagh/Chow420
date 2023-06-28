<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\RoleUserModel;
use App\Models\UnitModel;
use App\Models\TransactionModel;
use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;

use DB;
use Datatables;

class TransactiondetailsController extends Controller
{
   public function __construct(UserModel $UserModel,
   							   RoleUserModel $RoleUserModel,
   							   UnitModel $UnitModel,
                  BuyerModel $BuyerModel,
                SellerModel $SellerModel,
                OrderModel $OrderModel,
                OrderProductModel $OrderProductModel,
                TransactionModel $TransactionModel) 
   {
   		$this->UserModel  = $UserModel;
   		$this->RoleUserModel = $RoleUserModel;
      $this->BuyerModel          = $BuyerModel;
      $this->SellerModel         = $SellerModel;
      $this->TransactionModel    = $TransactionModel;
      $this->OrderModel          = $OrderModel;
      $this->OrderProductModel   = $OrderProductModel;       

   		$this->UnitModel = $UnitModel;
      $this->module_view_folder = 'admin/transaction_details';
    	$this->module_url_path    = url(config('app.project.admin_panel_slug')."/transaction");
      $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
    	$this->module_title       = "Transaction Details";
    	$this->arr_view_data      = [];
   }

   public function index()
   {
   	  $this->arr_view_data['module_title']    = $this->module_title;
      $this->arr_view_data['module_url_path'] = $this->module_url_path;
   	  $this->arr_view_data['page_title']      = $this->module_title;

   	  return view($this->module_view_folder.'.index',$this->arr_view_data);
   }

   public function get_all_transactions(Request $request)
   {	
            $transaction_table = $this->TransactionModel->getTable();
            $prefixed_transaction_tbl = DB::getTablePrefix().$transaction_table;

            $user_tbl_name              = $this->UserModel->getTable();
            $prefixed_user_tbl          = DB::getTablePrefix().$this->UserModel->getTable();

            $order_tbl_name              = $this->OrderModel->getTable();
            $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

            $order_product_tbl_name      = $this->OrderProductModel->getTable();
            $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();

      
             /* $obj_transaction = DB::table($order_tbl_name)
                                 
                                    ->select(DB::raw($order_tbl_name.".*,".
                                                     $prefixed_transaction_tbl.".transaction_status,".
                                                     "CONCAT(".$prefixed_user_tbl.".first_name,' ',"
                                                     .$prefixed_user_tbl.".last_name) as buyer_name"
                                                    // $prefixed_user_tbl.'.first_name as seller_name'
                                                   ))
                                   // ->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_order_tbl.'.seller_id')

                                    ->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_order_tbl.'.buyer_id')
                                    //->leftjoin($prefixed_order_product_tbl,$prefixed_order_product_tbl.'.order_id','=',$prefixed_order_tbl.'.id')
                                    ->leftjoin($prefixed_transaction_tbl,$prefixed_transaction_tbl.'.order_no','=',$order_tbl_name.'.order_no')
                                   ->orderBy($order_tbl_name.".id",'DESC');
*/

                                 $obj_transaction = DB::table($transaction_table)
                                    ->select(DB::raw($transaction_table.".*,".
                                                     "CONCAT(".$prefixed_user_tbl.".first_name,' ',"
                                                     .$prefixed_user_tbl.".last_name) as buyer_name"
                                                   ))

                                  ->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_transaction_tbl.'.user_id')
                                  ->leftjoin($order_tbl_name,$order_tbl_name.'.order_no','=',$prefixed_transaction_tbl.'.order_no')
                                  ->groupBy($prefixed_order_tbl.'.order_no')
                                   ->orderBy($order_tbl_name.".id",'DESC');

            


        /* ---------------- Filtering Logic ----------------------------------*/                    

            $arr_search_column = $request->input('column_filter');
                  
            if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
            {
                $search_term_order      = $arr_search_column['q_order_no'];
                $obj_transaction = $obj_transaction->where($prefixed_transaction_tbl.'.order_no','LIKE', '%'.$search_term_order.'%');
            }
            /* if(isset($arr_search_column['q_seller_name']) && $arr_search_column['q_seller_name']!="")
            {
                $search_seller_term      = $arr_search_column['q_seller_name'];
                 $obj_transaction       = $obj_transaction->where($prefixed_user_tbl.'.first_name','LIKE', '%'.$search_seller_term.'%')->orWhere('last_name', 'LIKE', '%'.$search_seller_term.'%');
            }*/
             if(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name']!="")
            {
                $search_buyer_term      = $arr_search_column['q_buyer_name'];
                 $obj_transaction       = $obj_transaction->where($prefixed_user_tbl.'.first_name','LIKE', '%'.$search_buyer_term.'%')->orWhere('last_name', 'LIKE', '%'.$search_buyer_term.'%');
            }

            if(isset($arr_search_column['q_transaction_id']) && $arr_search_column['q_transaction_id']!="")
            {
                $search_term      = $arr_search_column['q_transaction_id'];
                $obj_transaction = $obj_transaction->where($prefixed_transaction_tbl.'.transaction_id','LIKE', '%'.$search_term.'%');
            }
           
            if(isset($arr_search_column['q_price']) && $arr_search_column['q_price']!="")
            {
                $search_term      = $arr_search_column['q_price'];
                $obj_transaction = $obj_transaction->where($prefixed_transaction_tbl.'.total_price','LIKE', '%'.$search_term.'%');
            }

            if(isset($arr_search_column['q_payment_status']) && $arr_search_column['q_payment_status']!="")
            {  
                

                $search_term = $arr_search_column['q_payment_status'];
                $obj_transaction = $obj_transaction->where($prefixed_transaction_tbl.'.transaction_status','LIKE', '%'.$search_term.'%');

            }


            if(isset($arr_search_column['q_order_date']) && $arr_search_column['q_order_date']!="")
            {
                $search_term      = $arr_search_column['q_order_date'];
                $search_term  = date('Y-m-d',strtotime($search_term));

                $obj_transaction = $obj_transaction->where($prefixed_transaction_tbl.'.created_at','LIKE', '%'.$search_term.'%');
            }    


 


        $json_result     = Datatables::of($obj_transaction); 
        $current_context = $this;
   		
   		 /* Modifying Columns */
        $json_result =  $json_result->editColumn('created_at',function($data) use ($current_context)
                        {
                           return date('d M Y H:i',strtotime($data->created_at));
                           // return us_date_format($data->created_at);
                        })
                          ->editColumn('order_no',function($data) use ($current_context)
                        {
                            $get_orderids = $this->OrderModel->select('id')
                                            ->where('order_no',$data->order_no)
                                            ->get()->toArray();

                             if(!empty($get_orderids) && count($get_orderids)>0){
                             $str=[];              
                             foreach($get_orderids as $v){
                                $str[] = base64_encode($v['id']);
                             }       
                             $ids = implode("@",$str);        
                             }else{
                                $ids = base64_encode($data->id);
                             }  


                           // $orderno_href =  url('/').'/admin/order/view/'.$ids;  

                            $orderno_href =  $this->admin_url_path.'/order/view/'.base64_encode($data->order_no);
                            $orderno_action = '<a target="_blank" href="'.$orderno_href.'" title="View Order Details">'.$data->order_no.'</a>';

                            return $orderno_action;

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
                        ->editColumn('full_amount',function($data) use ($current_context){

                           $total_amount =0;
                          if($data->total_price>0)
                          {
                              $total_amount = $data->total_price;

                              if($data->buyer_wallet_amount>0)
                              {
                                $total_amount = (float) $total_amount + (float) $data->buyer_wallet_amount;
                              }

                              $total_amount = '$'.num_format($total_amount); 
                          }
                          else
                          {
                            $total_amount = $data->total_price;
                          }
                          return $total_amount;
                        })
                        ->editColumn('cashback',function($data) use ($current_context){

                           $cashback =0;
                          if(isset($data->cashback) && $data->cashback>0)
                          {
                              $cashback = $data->cashback;         
                              $cashback = '$'.num_format($cashback);                    
                             

                              $cashback_status = '';
                              $getcashback_status = get_user_wallet_cashback($data->order_no,$data->user_id);
                               if(isset($getcashback_status) && !empty($getcashback_status) && $getcashback_status=='Cancel Cashback')
                                {
                                              
                                      $cashback_status = $cashback.'<b> (Credited)</b>';
                            
                                }//
                                else if(isset($getcashback_status) && !empty($getcashback_status) && $getcashback_status=='Cashback Cancelled')
                                {
                        
                                      $cashback_status = $cashback.' <b> (Cancelled)</b>';
                            
                                }

                                 $cashback = $cashback_status; 
                          }
                          else
                          {
                            $cashback = 'NA';
                          }
                          return $cashback;
                        })
                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {
                          $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);
                          $build_view_action = '<a class="eye-actn" href="'.$view_href.'" title="View">View</a>';
                          return $build_view_action;
                        })
                        ->make(true);

                      $build_result = $json_result->getData();
        
        			  return response()->json($build_result);

   }

 
    public function view($enc_id)
    {
        $transaction_id = base64_decode($enc_id);      

        $res_transaction = $this->TransactionModel->where('id',$transaction_id)->first()->toArray();
        if(!empty($res_transaction))
        {
          $order_no = $res_transaction['order_no'];
        }
        
        $obj_transaction = $this->TransactionModel->with('order_details.order_product_details.product_details',
                                                          'order_details.seller_details',
                                                          'order_details.seller_details.seller_detail',
                                                          'order_details.address_details','buyer_details',
                                                          'order_details.address_details.get_shippingcountrydetail',
                                                           'order_details.address_details.get_shippingstatedetail',
                                                           'order_details.address_details.get_billingcountrydetail',
                                                           'order_details.address_details.get_billingstatedetail'
                                                        )
                                ->where('id',$transaction_id)->get()->toArray();   
        $arr_transaction_detail = [];
        if($obj_transaction)
        {
           $arr_transaction_detail = $obj_transaction; 
        }
     //   dd($arr_transaction_detail);

        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['arr_transaction_detail']   = isset($arr_transaction_detail) ? $arr_transaction_detail : [];  
        $this->arr_view_data['page_title']               = $this->module_title;
        $this->arr_view_data['module_title']             = $this->module_title;
  
      return view($this->module_view_folder.'.view',$this->arr_view_data);   
    }

  
   
}
