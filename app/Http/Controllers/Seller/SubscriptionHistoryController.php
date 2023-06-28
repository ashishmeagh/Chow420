<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Models\UserSubscriptionsModel;
use App\Models\MembershipModel;



use Sentinel;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionHistoryController extends Controller
{

    public function __construct(
                                
                UserModel $user,
                BuyerModel $BuyerModel,
                SellerModel $SellerModel,
                UserSubscriptionsModel $UserSubscriptionsModel,
                MembershipModel $MembershipModel
              
               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;

        $this->BuyerModel          = $BuyerModel;
        $this->SellerModel         = $SellerModel;
        $this->UserSubscriptionsModel = $UserSubscriptionsModel;
        $this->MembershipModel    = $MembershipModel;
      
        $this->arr_view_data       = [];

        $this->module_title       = "Membership History";
        $this->module_view_folder = "seller/subscription-history";
        $this->module_url_path      = url('/')."/seller/membership-history";
        
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
       
        $this->arr_view_data['page_title']           = 'Membership History';
        $this->arr_view_data['module_url_path']      = $this->module_url_path;
        
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

           
            $usersubscripiton_table = $this->UserSubscriptionsModel->getTable();
            $prefixed_subscription_tbl = DB::getTablePrefix().$usersubscripiton_table;

            $membership_tbl_name   = $this->MembershipModel->getTable();
            $prefixed_membership_tbl = DB::getTablePrefix().$this->MembershipModel->getTable();

            $obj_qutoes = DB::table($usersubscripiton_table)
                                 
                                    ->select(DB::raw($usersubscripiton_table.".*,".
                                                     $prefixed_membership_tbl.".name as membershipname"
                                                   ))                                  
                                    ->leftjoin($prefixed_membership_tbl,$prefixed_membership_tbl.'.id','=',$usersubscripiton_table.'.membership_id')
                                    ->where($usersubscripiton_table.'.user_id',$loggedInUserId)
                                   ->orderBy($usersubscripiton_table.".id",'DESC');

            
            /* ---------------- Filtering Logic ----------------------------------*/                    
            $arr_search_column = $request->input('column_filter');

             if(isset($arr_search_column['q_membership_name']) && $arr_search_column['q_membership_name']!="")
            {
                $search_membershipname      = $arr_search_column['q_membership_name'];
                $obj_qutoes = $obj_qutoes->where($prefixed_membership_tbl.'.name','LIKE', '%'.$search_membershipname.'%');
            }
   
           
            if(isset($arr_search_column['q_membership_amount']) && $arr_search_column['q_membership_amount']!="")
            {
                $search_membership_amount      = $arr_search_column['q_membership_amount'];
                $obj_qutoes = $obj_qutoes->where($usersubscripiton_table.'.membership_amount','LIKE', '%'.$search_membership_amount.'%');
            }

            if(isset($arr_search_column['q_membership']) && $arr_search_column['q_membership']!="")
            {  
               
                $search_membership_term = $arr_search_column['q_membership'];

                $obj_qutoes = $obj_qutoes->where($usersubscripiton_table.'.membership','LIKE', '%'.$search_membership_term.'%');
            }

             if(isset($arr_search_column['q_product_limit']) && $arr_search_column['q_product_limit']!="")
            {  
               
                $search_productlimit_term = $arr_search_column['q_product_limit'];

                $obj_qutoes = $obj_qutoes->where($usersubscripiton_table.'.product_limit','LIKE', '%'.$search_productlimit_term.'%');
            }
            if(isset($arr_search_column['q_membership_status']) && $arr_search_column['q_membership_status']!="")
            {  
               
                $search_membership_status_term = $arr_search_column['q_membership_status'];

                $obj_qutoes = $obj_qutoes->where($usersubscripiton_table.'.membership_status','LIKE', '%'.$search_membership_status_term.'%');
            }

            if(isset($arr_search_column['q_payment_status']) && $arr_search_column['q_payment_status']!="")
            {  
               
                $search_payment_status_term = $arr_search_column['q_payment_status'];
                $obj_qutoes = $obj_qutoes->where($usersubscripiton_table.'.payment_status','=', $search_payment_status_term);
            }
            
             if(isset($arr_search_column['q_created_at']) && $arr_search_column['q_created_at']!="")
            {  
               
                $search_created_at_term = date("Y-m-d",strtotime($arr_search_column['q_created_at']));

                $obj_qutoes = $obj_qutoes->where($usersubscripiton_table.'.created_at','LIKE', '%'.$search_created_at_term.'%');
            }


        
            

            $current_context = $this;

            $json_result  = Datatables::of($obj_qutoes);
            
            $json_result  = $json_result->editColumn('created_at',function($data) use ($current_context)
                            {
                                return us_date_format($data->created_at);


                            }) 
                            ->editColumn('membershipname',function($data) use ($current_context){

                                 if($data->membershipname!='')
                                 {
                                    return $data->membershipname;
                                 }
                                 else{
                                    return 'NA';
                                 }
                            })
                             ->editColumn('membership',function($data) use ($current_context)
                            {

                                if ($data->membership == 1) {
                                    return 'Free';
                                }
                                elseif ($data->membership == 2) {
                                    return 'Paid';
                                }                              
                            })       

                             ->editColumn('membership_amount',function($data) use ($current_context)
                            {

                                if ($data->membership_amount!='') {
                                    return '$'.$data->membership_amount;
                                }
                                else
                                {
                                    return $data->membership_amount;
                                }                              
                            })         


                            ->editColumn('membership_status',function($data) use ($current_context)
                            {

                                if ($data->membership_status == 0) {
                                    return 'Cancelled';
                                }
                                elseif ($data->membership_status == 1) {
                                    return 'Active';
                                }                              
                            })   
                             ->editColumn('cancel_reason',function($data) use ($current_context)
                            {
                                if(isset($data->cancel_reason) && strlen($data->cancel_reason)>20){
                                   return '<p class="prod-desc">'.str_limit($data->cancel_reason,20).'..<a class="readmorebtn" cancel_reason="'.$data->cancel_reason.'" style="cursor:pointer"><b>Read more</b></a></p>';
                                }
                                else{
                                    if($data->cancel_reason!=""){
                                         return $data->cancel_reason;
                                    }else{
                                        return '-';
                                    }//else
                                   
                                }//else
                            })
                             ->editColumn('payment_status',function($data) use ($current_context)
                            {
                               if($data->membership=="2")
                               { 
                                 //if membership if paid 
                                  if ($data->payment_status == 1) {
                                    return 'Completed';
                                  }
                                  else
                                  {
                                    return 'Failed';
                                  } 
                                }
                                else if($data->membership=="1")
                                {
                                    return 'Free';
                                }                             
                            });                            
                           /* ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                            
                                
                                $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                                $build_view_action = '<a href="'.$view_href.'" class="eye-actn" title="View Payment Details">
                                View
                                </a>';

                               
                                return $build_action = $build_view_action;
                            });*/

            $build_result = $json_result->make(true)->getData();

            return response()->json($build_result);
        }

    public function view($enc_id="")
    {
        
        $product_arr = [];
        $order_id = base64_decode($enc_id); 
        if ($order_id) {

            $obj_order_details = $this->OrderModel
                            ->with(['order_product_details.product_details.product_images_details','buyer_details','address_details','transaction_details'])
                            ->where('id',$order_id)
                            ->first();
        }

        if($obj_order_details)
        {
            $product_arr = $obj_order_details->toArray();
        }
      //  dd($product_arr);

        $this->arr_view_data['product_arr']          = $product_arr;
        $this->arr_view_data['page_title']           = 'Product Details';
        // dd($this->arr_view_data);
        return view($this->module_view_folder.'.view',$this->arr_view_data);

    }

}
