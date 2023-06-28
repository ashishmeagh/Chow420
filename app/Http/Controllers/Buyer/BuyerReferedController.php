<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\BuyerModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\BuyerRegisteredReferModel;


use Sentinel;
use Datatables;  
use DB;


class BuyerReferedController extends Controller
{

    public function __construct(
                                
                                UserModel $user,
                                BuyerModel $BuyerModel,
                                OrderModel $OrderModel,
                                OrderProductModel $OrderProductModel,
                                BuyerRegisteredReferModel $BuyerRegisteredReferModel
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;

        $this->BuyerModel         = $BuyerModel;
        $this->OrderModel         = $OrderModel;
        $this->OrderProductModel  = $OrderProductModel;
        $this->BuyerRegisteredReferModel  = $BuyerRegisteredReferModel;
         
        $this->arr_view_data      = [];

        $this->module_title       = "Refered Users";
        $this->module_view_folder = "buyer/referedbuyer";
        $this->module_url_path = url('/').'/buyer/refered-users';

    }


    public function index(Request $request)
    {
        $loggedInUserId = 0;
        $user = Sentinel::check();
        if($user)
        {
            $loggedInUserId = $user->id;
        }      
        $this->arr_view_data['page_title']           = 'Refered Users';
        $this->arr_view_data['module_url_path']      = $this->module_url_path;
        return view($this->module_view_folder.'.index',$this->arr_view_data);

    }

    public function get_buyer_refered(Request $request)
    {  
       
        $loggedInUserId = 0;
        $user = Sentinel::check();

        if($user)
        {
            $loggedInUserId = $user->id;
        }
   
   
        $user_tbl_name              = $this->UserModel->getTable();
        $prefixed_user_tbl          = DB::getTablePrefix().$this->UserModel->getTable();

        $order_tbl_name              = $this->OrderModel->getTable();
        $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_tbl_name      = $this->OrderProductModel->getTable();
        $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $buyer_refered               = $this->BuyerRegisteredReferModel->getTable();
        $prefixed_buyer_refered_tbl  = DB::getTablePrefix().$this->BuyerRegisteredReferModel->getTable();
        

        $obj_qutoes = DB::table($buyer_refered)                             
                        ->select(DB::raw($prefixed_buyer_refered_tbl.".*" ))     
                        ->where($buyer_refered.'.user_id',$loggedInUserId)
                        ->orderBy($buyer_refered.".id",'DESC');
        
        
       // dd($obj_qutoes);
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
            //    dd($arr_search_column); 
        if(isset($arr_search_column['q_code']) && $arr_search_column['q_code']!="")
        {
            $search_term      = $arr_search_column['q_code'];
            $obj_qutoes = $obj_qutoes->where($buyer_refered.'.code','LIKE', '%'.$search_term.'%');
        }

       
        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_email_term      = $arr_search_column['q_email'];
            $obj_qutoes = $obj_qutoes->where($buyer_refered.'.email','LIKE', '%'.$search_email_term.'%');
        }

         if(isset($arr_search_column['q_amount']) && $arr_search_column['q_amount']!="")
        {
            $search_amount_term      = $arr_search_column['q_amount'];
            $obj_qutoes = $obj_qutoes->where($buyer_refered.'.amount','LIKE', '%'.$search_amount_term.'%');
        }

        if(isset($arr_search_column['q_orderno']) && $arr_search_column['q_orderno']!="")
        {
            $search_orderno_term      = $arr_search_column['q_orderno'];
            $obj_qutoes = $obj_qutoes->where($buyer_refered.'.order_no','LIKE', '%'.$search_orderno_term.'%');
        }

       

        $current_context = $this;

        $json_result  = Datatables::of($obj_qutoes);
        
        $json_result  = $json_result->editColumn('created_at',function($data) use ($current_context)
                        {
                            return us_date_format($data->created_at);

                        })
                         ->editColumn('order_no',function($data) use ($current_context) {

                               $order_no = ''; 
                                if(isset($data->order_no))
                                {
                                   $order_no = $data->order_no;  
                                }
                              
                               return $order_no;

                         })                     
                        ->editColumn('amount',function($data) use ($current_context) {

                               $final_amount = $data->amount;

                                if($final_amount>0) 
                                {
                                    return '$'.num_format($final_amount); 
                                }else{
                                   return "-"; 
                                }
 

                         })
                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                        
                            
                            $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                            $build_view_action = '<a href="'.$view_href.'" class="eye-actn"><i class="fa fa-eye"></i></a>';

                           
                            return $build_action = $build_view_action;
                        });
        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
    }

    public function view($enc_id="")
    {
       
        $product_arr = [];
        $order_id = base64_decode($enc_id);
        if ($order_id) {

            $obj_order_details = $this->OrderModel
                            ->with(['order_product_details.product_details','seller_details','address_details','transaction_details'])
                            ->where('id',$order_id)
                            ->first();
        }

        if($obj_order_details)
        {
            $product_arr = $obj_order_details->toArray();
        }
        

        $this->arr_view_data['product_arr']          = $product_arr;
        $this->arr_view_data['page_title']           = 'Product Details';
        // dd($this->arr_view_data);
        return view($this->module_view_folder.'.view',$this->arr_view_data);

    }

}
