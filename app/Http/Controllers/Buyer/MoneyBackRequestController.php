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
use App\Models\MoneyBackModel;
use App\Models\ProductModel;
use App\Models\BrandModel;
use App\Models\SellerModel;


use Sentinel;
use Datatables;  
use DB;


class MoneyBackRequestController extends Controller
{

    public function __construct(
                                
                                UserModel $user,
                                BuyerModel $BuyerModel,
                                OrderModel $OrderModel,
                                OrderProductModel $OrderProductModel,
                                BuyerRegisteredReferModel $BuyerRegisteredReferModel,
                                MoneyBackModel $MoneyBackModel,
                                ProductModel $ProductModel,
                                BrandModel $BrandModel,
                                SellerModel $SellerModel
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;

        $this->BuyerModel         = $BuyerModel;
        $this->OrderModel         = $OrderModel;
        $this->OrderProductModel  = $OrderProductModel;
        $this->BuyerRegisteredReferModel  = $BuyerRegisteredReferModel;
        $this->MoneyBackModel     = $MoneyBackModel;
        $this->ProductModel       = $ProductModel;
        $this->BrandModel         = $BrandModel;
        $this->SellerModel        = $SellerModel;
         
        $this->arr_view_data      = [];

        $this->module_title       = "Reported Issues";
        $this->module_view_folder = "buyer/money_back_request";
        $this->module_url_path = url('/').'/buyer/reported_issues';

    }


    public function index(Request $request)
    {
        $loggedInUserId = 0;
        $user = Sentinel::check();
        if($user)
        {
            $loggedInUserId = $user->id;
        }      
        $this->arr_view_data['page_title']           = 'Reported Issues';
        $this->arr_view_data['module_url_path']      = $this->module_url_path;
        return view($this->module_view_folder.'.index',$this->arr_view_data);

    }

    public function get_request(Request $request)
    {  
       
        $loggedInUserId = 0;
        $user = Sentinel::check();

        if($user)
        {
            $loggedInUserId = $user->id;
        }
   
   
        $product_details        = $this->ProductModel->getTable();
        $prefix_product_detail  = DB::getTablePrefix().$this->ProductModel->getTable();
        $prefix_spectrum        = DB::getTablePrefix().$this->ProductModel->getTable();

        $productbrand        = $this->BrandModel->getTable();
        $prefiex_productbrand = DB::getTablePrefix().$this->BrandModel->getTable();

        $sellertable         = $this->SellerModel->getTable();
        $prefiex_sellertable =  DB::getTablePrefix().$this->SellerModel->getTable();

        $money_back_request_table         = $this->MoneyBackModel->getTable();
        $prefiex_money_back_request_table = DB::getTablePrefix().$this->MoneyBackModel->getTable();

        $user_details       = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();


        $obj_product = DB::table($money_back_request_table)
                          ->select(DB::raw($money_back_request_table.'.*,'.
                        
                        $prefix_product_detail.'.product_name,'.
                        $prefix_product_detail.'.id as p_id,'.
                        $prefix_product_detail.'.unit_price,'.
                        $prefix_product_detail.'.price_drop_to,'.
                        $prefiex_productbrand.'.name as brand_name,'.
                          

                        "CONCAT(".$prefix_user_detail.".first_name,' ',"
                                .$prefix_user_detail.".last_name) as seller_name,".
                                $prefiex_sellertable.'.business_name as business_name'

                            ))

                        ->leftjoin($prefix_product_detail,$prefix_product_detail.'.id','=',$money_back_request_table.'.product_id')

                        ->leftjoin($prefix_user_detail,$prefix_user_detail.'.id','=',$prefix_product_detail.'.user_id')

                        ->leftJoin($prefiex_productbrand,$prefiex_productbrand.'.id','=',$prefix_product_detail.'.brand')   

                        ->leftjoin($prefiex_sellertable,$prefiex_sellertable.'.user_id','=',$prefix_product_detail.'.user_id')

                        ->where($money_back_request_table.'.buyer_id',$loggedInUserId)

                        ->orderBy($money_back_request_table.'.id','DESC');                 
       
         /*-------------------------Filter---------------------------------------*/                               

        $arr_search_column = $request->input('column_filter');

        if(isset($arr_search_column['q_product_name']) && $arr_search_column['q_product_name'] != '')
        {
              $search_name_term  = $arr_search_column['q_product_name'];
              $obj_product  = $obj_product->where($prefix_product_detail.'.product_name','LIKE', '%'.$search_name_term.'%');

        }
            
        if(isset($arr_search_column['q_brand']) && $arr_search_column['q_brand'] != '')
        {
            $search_brandname  = $arr_search_column['q_brand'];
            $obj_product  = $obj_product->where($productbrand.'.name','LIKE', '%'.$search_brandname.'%');

        }


        if(isset($arr_search_column['q_price']) && $arr_search_column['q_price'] != '')
        {
            $search_unit_price  = $arr_search_column['q_price'];
            $obj_product  = $obj_product->where($prefix_product_detail.'.unit_price','LIKE', '%'.$search_unit_price.'%')
                                ->orwhere($prefix_product_detail.'.price_drop_to','LIKE', '%'.$search_unit_price.'%');

        }


        if(isset($arr_search_column['q_seller_name']) && $arr_search_column['q_seller_name'] != '')
        {
             $search_seller_term  = $arr_search_column['q_seller_name'];
             
              $obj_product  = $obj_product->where($prefiex_sellertable.'.business_name','LIKE', '%'.$search_seller_term.'%');

        }                      
  
      
        $current_context = $this;

        $json_result     = Datatables::of($obj_product);
        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->product_id);
                            })

                            ->editColumn('business_name',function($data) use ($current_context)
                            {
                                if(isset($data->business_name) && !empty($data->business_name))
                                {
                                 return $data->business_name;
                                }
                                else{
                                  return 'NA';
                                }
                            })  

                            ->editColumn('product_name',function($data) use ($current_context)
                            {
                                if(isset($data->product_name) && !empty($data->product_name))
                                {
                                 return $data->product_name;
                                }
                                else{
                                  return 'NA';
                                }
                            })   

                            ->editColumn('brand_name',function($data) use ($current_context)
                            {
                                if(isset($data->brand_name) && !empty($data->brand_name))
                                {
                                 return $data->brand_name;
                                }
                                else{
                                  return 'NA';
                                }
                            })     
  

                            ->editColumn('unit_price',function($data) use ($current_context)
                            {
                              if(isset($data->price_drop_to) && $data->price_drop_to!='' && $data->price_drop_to!= 0)
                              {
                                 $unit_price = '$'.num_format($data->price_drop_to);
                              }
                              else
                              {
                                 $unit_price = '$'.num_format($data->unit_price);
                              }
                               
                               return $unit_price;
                            })

                            
                            ->editColumn('buyer_note',function($data) use ($current_context)
                            {
                                $note = '';
                                $buyer_note = isset($data->reported_issue_note)?$data->reported_issue_note:'';

                                if(isset($buyer_note) && $buyer_note!='')
                                {
                                   $string = strip_tags($buyer_note);       
                                 
                                    if(strlen($string) > 30)
                                    {
                                       $stringCut = substr($string, 0,30);
                                       
                                       $note = $stringCut.'...'.'<a href="javascript:void(0);" id="buyer_note_read_more" name="buyer_note_read_more" note="'.$buyer_note.'" onclick="showNote($(this));">read more</a>';
                                    }
                                    else
                                    {
                                        $note = $buyer_note;
                                    }
                                }
                                else
                                {
                                   $note = '--';
                                }

                                return $note; 
                            })

                            ->editColumn('admin_note',function($data) use ($current_context)
                            {
                                $note = '';

                                $admin_note = isset($data->note)?$data->note:'';

                        
                                if(isset($admin_note) && $admin_note!='')
                                {
                                    $string = strip_tags($admin_note);       
                                
                                    if(strlen($string) > 30)
                                    {
                                       $stringCut = substr($string, 0,30);
                                       
                                       $note = $stringCut.'...'.'<a href="javascript:void(0);" id="admin_note_read_more" name="admin_note_read_more" note="'.$admin_note.'" onclick="showNote($(this));">read more</a>';
                                    }
                                    else
                                    {
                                        $note = $admin_note;
                                    }
                                }
                                else
                                {
                                   $note = '--';
                                }

                                return $note; 
                                  
                            })


                            ->editColumn('status',function($data) use ($current_context)
                            {
                              $status = '';

                              if(isset($data->status)  && $data->status == 0)
                              {
                                  $status ='<label class="status-dispatched">Reported</label>';
                              }
                              elseif(isset($data->status) && $data->status == 1)
                              {
                                 $status ='<label class="status-dispatched label-success-apv">Refunded to wallet</label>';
                              }
                              elseif(isset($data->status) && $data->status == 2)
                              {
                                $status ='<label class="status-shipped">Corrected</label>';
                              }
                               
                               return $status;
                            })

                        
                        
                            ->make(true);

        $build_result = $json_result->getData();

        return response()->json($build_result);
    }

/*    public function view($enc_id="")
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

    }*/

}
