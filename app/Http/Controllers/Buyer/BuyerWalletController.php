<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\BuyerModel;
use App\Models\TransactionModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\BuyerWalletModel;
use App\Models\BuyerRegisteredReferModel;
use App\Models\ReviewRatingsModel;
use App\Models\MoneyBackModel;


use Sentinel;
use Datatables;  
use DB;


class BuyerWalletController extends Controller
{

    public function __construct(
                                
                                UserModel $user,
                                BuyerModel $BuyerModel,
                                OrderModel $OrderModel,
                                OrderProductModel $OrderProductModel,
                                TransactionModel $TransactionModel,
                                BuyerWalletModel $BuyerWalletModel,
                                BuyerRegisteredReferModel $BuyerRegisteredReferModel,
                                ReviewRatingsModel $ReviewRatingsModel,
                                MoneyBackModel $MoneyBackModel
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;

        $this->BuyerModel         = $BuyerModel;
        $this->TransactionModel   = $TransactionModel;
        $this->OrderModel   = $OrderModel;
        $this->OrderProductModel   = $OrderProductModel;
        $this->BuyerWalletModel   = $BuyerWalletModel;
        $this->BuyerRegisteredReferModel   = $BuyerRegisteredReferModel;
        $this->ReviewRatingsModel  = $ReviewRatingsModel;
        $this->MoneyBackModel      = $MoneyBackModel;

        $this->arr_view_data      = [];

        $this->module_title       = "Wallet (Chowcash)";
        $this->module_view_folder = "buyer/buyer-wallet";
        $this->module_url_path = url('/').'/buyer/wallet';

    }


    public function index(Request $request)
    {
        $loggedInUserId = 0;
        $user = Sentinel::check();

        if($user)
        {
            $loggedInUserId = $user->id;
        }
        //get total wallet amount 

        $total_wallet_amount = $this->BuyerWalletModel->where('user_id',$loggedInUserId)
                                   ->where('status',1) 
                                   ->sum('amount');

        if(isset($total_wallet_amount))
        {
            $this->arr_view_data['total_wallet_amount'] = num_format($total_wallet_amount);
        }

        $used_wallet_amount = $this->BuyerWalletModel->where('user_id',$loggedInUserId)
                                   ->where('status',2) 
                                   ->sum('amount');

        if(isset($used_wallet_amount))
        {
            $this->arr_view_data['used_wallet_amount'] = num_format($used_wallet_amount);
        }


        $remain_wallet_amount = $this->BuyerWalletModel->where('user_id',$loggedInUserId)
                                ->where('status','!=',0) 
                                ->sum('amount');

        if(isset($remain_wallet_amount))
        {
            $this->arr_view_data['remain_wallet_amount'] = num_format($remain_wallet_amount);
        }



        $pending_wallet_amount = $this->BuyerWalletModel->where('user_id',$loggedInUserId)
                                   ->where('status',0) 
                                   ->sum('amount');
                                   
         if(isset($pending_wallet_amount))
        {
            $this->arr_view_data['pending_wallet_amount'] = num_format($pending_wallet_amount);
        }                          

        $this->arr_view_data['page_title']           = 'Wallet (Chowcash)';
        $this->arr_view_data['module_url_path']      = $this->module_url_path;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
            

    }

    public function get_buyer_wallet(Request $request)
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

        $buyer_Wallet               = $this->BuyerWalletModel->getTable();
        $prefixed_buyer_wallet_tbl  = DB::getTablePrefix().$this->BuyerWalletModel->getTable();
        

        $obj_qutoes = DB::table($buyer_Wallet)
                             
                                ->select(DB::raw($prefixed_buyer_wallet_tbl.".*"
                                               ))
                                //->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_order_tbl.'.seller_id')
                                ->where($buyer_Wallet.'.user_id',$loggedInUserId)
                                ->orderBy($buyer_Wallet.".id",'DESC');
        
        
       // dd($obj_qutoes);
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
            //    dd($arr_search_column); 
        if(isset($arr_search_column['q_type']) && $arr_search_column['q_type']!="")
        {
            $search_term      = $arr_search_column['q_type'];
            $obj_qutoes = $obj_qutoes->where($buyer_Wallet.'.type','LIKE', '%'.$search_term.'%');
        }

       
        if(isset($arr_search_column['q_amount']) && $arr_search_column['q_amount']!="")
        {
            $search_amount_term      = $arr_search_column['q_amount'];
            $obj_qutoes = $obj_qutoes->where($buyer_Wallet.'.amount','LIKE', '%'.$search_amount_term.'%');
        }
         if(isset($arr_search_column['q_orderno']) && $arr_search_column['q_orderno']!="")
        {
            $search_orderno_term      = $arr_search_column['q_orderno'];

            $obj_qutoes = $obj_qutoes->where($buyer_Wallet.'.typeid','LIKE', '%'.$search_orderno_term.'%')->where('type','OrderPlaced');
        }

      

       

        $current_context = $this;

        $json_result  = Datatables::of($obj_qutoes);
        
        $json_result  = $json_result->editColumn('created_at',function($data) use ($current_context)
                        {
                            return us_date_format($data->created_at);

                        })
                      
                      
                        ->editColumn('amount',function($data) use ($current_context) {

                            $final_amount = $data->amount;

                               if($final_amount) 
                               {
                                    return str_replace('$-','-$','$'.num_format($final_amount)); 
                                }else{
                                   return "-"; 
                                }
 

                         })
                        ->editColumn('type',function($data) use ($current_context) {

                            $type = $data->type;

                               if(isset($type) && $type=="Refered") 
                               {
                                  if(isset($data->typeid) && !empty($data->typeid))
                                  {
                                     $get_buyer_name = get_buyer_name($data->typeid);
                                     if(isset($get_buyer_name) && !empty($get_buyer_name))
                                     {
                                        $type = "Refered By ".$get_buyer_name;
                                    }else
                                    {
                                         $type = "Refered";
                                    }
                                   
                                  }     
                               }
                               elseif(isset($type) && $type=="Referal") 
                               {
                                  if(isset($data->typeid) && !empty($data->typeid))
                                  {

                                     $get_whom_referedid = $this->BuyerRegisteredReferModel->where('id',$data->typeid)->first();
                                     if(isset($get_whom_referedid) && !empty($get_whom_referedid))
                                     {
                                        //$get_buyer_name = get_buyer_name($get_whom_referedid->user_id);
                                        $type = "Refered to <a href='".url('/')."/buyer/refered-users'>".$get_whom_referedid->email."</a>";
                                    }else
                                    {
                                         $type = "Referal";
                                    }
                                   
                                  } else
                                   {
                                     $type = $data->type;
                                   }    
                               }
                                elseif(isset($type) && $type=="Review") 
                               {
                                  if(isset($data->typeid) && !empty($data->typeid))
                                  {

                                     $get_reviewdetails = $this->ReviewRatingsModel->with('product_details')->where('id',$data->typeid)->first();
                                     if(isset($get_reviewdetails) && !empty($get_reviewdetails))
                                     {
                                        if(isset($get_reviewdetails['product_details']['product_name']) && !empty($get_reviewdetails['product_details']['product_name']))
                                        {
                                           $type = "Review for the product <a href='".url('/')."/buyer/review-ratings'>".$get_reviewdetails['product_details']['product_name']."</a>";
                                        }
                                        
                                       
                                    }else
                                    {
                                         $type = "Review";
                                    }
                                   
                                  } 
                                  else
                                   {
                                     $type = $data->type;
                                   }    
                               }
                               elseif(isset($type) && $type=="Reported_Issue") 
                               {
                                  if(isset($data->typeid) && !empty($data->typeid))
                                  {

                                     $get_productdetails = $this->MoneyBackModel->with('product_details')->where('id',$data->typeid)->first();
                                     if(isset($get_productdetails) && !empty($get_productdetails))
                                     {
                                        if(isset($get_productdetails['product_details']['product_name']) && !empty($get_productdetails['product_details']['product_name']))
                                        {
                                           $type = "Reported Issue for the product <a href='".url('/')."/buyer/reported_issues'>".$get_productdetails['product_details']['product_name']."</a>";
                                        }
                                        
                                       
                                    }else
                                    {
                                         $type = "Review";
                                    }
                                   
                                  } 
                                  else
                                   {
                                     $type = $data->type;
                                   }    
                               }
                               else
                               {
                                 $type = $data->type;
                               }
 
                             return  $type;  
                         })

                          ->editColumn('typeid',function($data) use ($current_context) {

                            $type = $data->type;
                            if($type=="OrderPlaced")
                            {   
                                if(isset($data->typeid)) 
                                {
                                    return $data->typeid; 
                                }else{
                                   return "-"; 
                                }  
                            }//if OrderPlaced
                            else if($type=="Cashback")
                            {   
                                if(isset($data->typeid)) 
                                {
                                    return $data->typeid; 
                                }else{
                                   return "-"; 
                                }  
                            }//if OrderPlaced
                            else{
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
