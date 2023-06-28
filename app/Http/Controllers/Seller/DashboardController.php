<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\NotificationsModel;
use App\Models\TransactionModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\UserSubscriptionsModel; 

use Sentinel;
use DB;

class DashboardController extends Controller
{
    //
    public function __construct(
                                UserModel $user,
								ProductModel $ProductModel,
                                NotificationsModel $NotificationsModel,
                                TransactionModel $TransactionModel,
                                OrderModel $OrderModel,
                                OrderProductModel $OrderProductModel,
                                UserSubscriptionsModel $UserSubscriptionsModel

    ){
        $this->module_view_dashboard = "seller/dashboard";
        $this->arr_view_data      = [];
		$this->module_title       = "Dashboard";
		$this->UserModel          = $user;
		$this->ProductModel         = $ProductModel;
        $this->Notifications = $NotificationsModel;
        $this->TransactionModel    = $TransactionModel;
        $this->OrderModel          = $OrderModel;
        $this->OrderProductModel          = $OrderProductModel;
        $this->UserSubscriptionsModel       = $UserSubscriptionsModel;

		$this->module_view_folder = "admin.dashboard";
		$this->admin_url_path     = url(config('app.project.admin_panel_slug'));
    }

 public function dashboard()
{
    $arr_seller_details = $arr_payment_list = [];
    $user = Sentinel::getUser();
    $referalcode='';
    $user_subscried = 0;
    if(!empty($user))
    {
        $seller_id = $user->id;
        $referalcode = $user->referal_code;

       
        if ($user->subscribed('main')) {
            $user_subscried = 1;

        }else{
          $user_subscried =0;
        }

   }
  	$total_product = $this->ProductModel->where('user_id',$seller_id)->get()->count();
    
    $total_notification      = $this->Notifications->where('to_user_id',$seller_id)->get()->count();
    
    /* query for seller details */
    $obj_seller_details      = $this->UserModel->with('seller_detail')->where('id',$seller_id)->first();
    if($obj_seller_details)
    {
        $arr_seller_details = $obj_seller_details->toArray();
    }
    /* query for seller payment history */
    // $obj_payment_history = $this->TransactionModel->where('user_id',$seller_id)->get();
    // $obj_payment_history = $this->TransactionModel
    //                             ->with('order_details')
    //                             ->get();
    /* start */
    $transaction_table = $this->TransactionModel->getTable();
    $prefixed_transaction_tbl = DB::getTablePrefix().$transaction_table;

    $user_tbl_name              = $this->UserModel->getTable();
    $prefixed_user_tbl          = DB::getTablePrefix().$this->UserModel->getTable();

    $order_tbl_name              = $this->OrderModel->getTable();
    $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

    $order_product_tbl_name      = $this->OrderProductModel->getTable();
    $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();

    $arr_payment_list = DB::table($order_tbl_name)
                                 
    ->select(DB::raw($order_tbl_name.".*,".
                     $prefixed_transaction_tbl.".transaction_status"
                   ))
    //->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_order_tbl.'.seller_id')

    //->leftjoin($prefixed_order_product_tbl,$prefixed_order_product_tbl.'.order_id','=',$prefixed_order_tbl.'.id')
    ->leftjoin($prefixed_transaction_tbl,$prefixed_transaction_tbl.'.order_no','=',$order_tbl_name.'.order_no')
    ->where($order_tbl_name.'.seller_id',$seller_id)
   ->orderBy($order_tbl_name.".id",'DESC')
   ->limit(3)
   ->get()
   ->toArray();
    /* end */


     $user_arr = $user->toArray();

     $user_subscriptiondata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$seller_id)->where('membership_status','1')->get();
     if(isset($user_subscriptiondata) && !empty($user_subscriptiondata))
     {
      $user_subscriptiondata = $user_subscriptiondata->toArray();
     }


      //get total sold price of all orders
      $total_soldprice = 0;
      $obj_totalsum_completedorder = $this->OrderModel->where([['seller_id',$seller_id],['order_status','1']])->sum('total_amount');

      if (isset($obj_totalsum_completedorder)) {

          $total_soldprice = $obj_totalsum_completedorder;
      }
      

    //get total sum of all product cost unit price of orders completed  
    $totalsoldunitprice = 0;  
    $getunitprice = DB::table($order_tbl_name)
                                 
    ->select(DB::raw($order_tbl_name.".*,".
                     $prefixed_order_product_tbl.".unit_price"
                   ))
     ->leftjoin($prefixed_order_product_tbl,$prefixed_order_product_tbl.'.order_id','=',$prefixed_order_tbl.'.id')  
     ->where($order_tbl_name.'.seller_id',$seller_id)
     ->where($order_tbl_name.'.order_status','1')
     ->orderBy($order_tbl_name.".id",'DESC')->sum('unit_price');

     if(isset($getunitprice))
     {
       $totalsoldunitprice = $getunitprice;
     }

     $get_allproducts =  $this->ProductModel->where('user_id',$seller_id)->get();
     if(isset($get_allproducts) && !empty($get_allproducts))
     {
        $get_allproducts = $get_allproducts->toArray();
        $totalproductsum = 0; $totalcostofproduct=0;
        foreach($get_allproducts as $prod)
        { 
            $unitprice = $prod['unit_price'];
            $price_drop_to = $prod['price_drop_to'];

            if(isset($price_drop_to) && !empty($price_drop_to) && $price_drop_to!='0.000000')
            {
              $totalcostofproduct = $prod['price_drop_to'];
            }
            else
            {
              $totalcostofproduct =  $prod['unit_price'];
            }

           // echo "<pre>".$prod['id']."--".$prod['unit_price']."==".$prod['price_drop_to'];

            $totalproductsum = $totalproductsum+$totalcostofproduct;
        }//foreach

     }//if get all products

    
           

              
  	$this->arr_view_data['page_title']          = $this->module_title;
  	$this->arr_view_data['total_notification']  = $total_notification;
  	$this->arr_view_data['total_product']         = $total_product;
  	$this->arr_view_data['arr_seller_details']  = $arr_seller_details;
    $this->arr_view_data['admin_url_path']      = $this->admin_url_path;
    $this->arr_view_data['arr_payment_list']      = $arr_payment_list;
    $this->arr_view_data['referalcode']      = $referalcode;

    $this->arr_view_data['user_subscribed'] = $user_subscried;
    $this->arr_view_data['user_subscriptiondata'] = isset($user_subscriptiondata)?$user_subscriptiondata:[];

    $this->arr_view_data['total_soldprice'] = isset($total_soldprice)? number_format($total_soldprice,2):'0';
   
    $this->arr_view_data['total_productsum'] = isset($totalproductsum)? number_format($totalproductsum,2):'0';

    return view($this->module_view_dashboard.'.index',$this->arr_view_data);
  }//end of dashboard function
}
