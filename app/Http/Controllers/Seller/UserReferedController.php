<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\SellerModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;
use App\Models\UserReferedModel;
use App\Models\UserReferWalletModel;
use App\Models\UserModel;



use Sentinel;
use Datatables;
use DB;
 
class UserReferedController extends Controller
{

    public function __construct(
                                SellerModel $SellerModel,                        
                                GeneralService $GeneralService,
                                EmailService $EmailService,
                                UserReferedModel $UserReferedModel,
                                UserReferWalletModel $UserReferWalletModel,
                                UserModel $UserModel
                               ) 
    {

        $this->SellerModel          = $SellerModel;
        $this->arr_view_data        = [];

        $this->module_title         = "Refered Users";
        $this->module_view_folder   = "seller/user_refered";
        $this->module_url_path      = url('/')."/seller/userrefered";
        $this->GeneralService       = $GeneralService;
        $this->EmailService         = $EmailService;
        $this->UserReferedModel     = $UserReferedModel;
        $this->UserReferWalletModel = $UserReferWalletModel;
        $this->UserModel            = $UserModel;


    }

    // function for listing of wallet
    public function index(Request $request)
    {
        $arr_pending_wallet = $transaction_arr = [];

        $logginId = 0;
        $user = Sentinel::check();

        if ($user) {
            
            $logginId = $user->id;
        }

        $seller_details_arr = $this->SellerModel->where('user_id',$logginId)->first();
       
        if(!empty($seller_details_arr))
        {
            $seller_details = $seller_details_arr->toArray();
        }

        $this->arr_view_data['seller_id']  = $logginId;
        $this->arr_view_data['page_title']  = $this->module_title;
        $this->arr_view_data['module_url_path']      = $this->module_url_path;
        $this->arr_view_data['seller_details'] = isset($seller_details)?$seller_details:[];

        return view($this->module_view_folder.'.index',$this->arr_view_data);
            

    }
 
    // ajax function to get user details 

    public function get_user_details(Request $request)
    {  
        $loggedInUserId = 0;
        $user = Sentinel::check();

        if($user)
        {
            $loggedInUserId = $user->id;
        }
       
        $refered_tbl_name   = $this->UserReferWalletModel->getTable();
        $prefixed_refered_tbl = DB::getTablePrefix().$this->UserReferWalletModel->getTable();
        $user_tbl_name   = $this->UserModel->getTable();
        $prefixed_user_tbl = DB::getTablePrefix().$this->UserModel->getTable();


        $obj_qutoes = DB::table($refered_tbl_name)                             
                        ->select(DB::raw($refered_tbl_name.".*,".
                               $prefixed_user_tbl.".first_name as first_name, ".
                               $prefixed_user_tbl.".last_name as last_name, ".
                               $prefixed_user_tbl.".email as useremail, ".

                              "CONCAT(".$prefixed_user_tbl.".first_name,' ',"
                                    .$prefixed_user_tbl.".last_name) as user_name"

                            ))                         
                          ->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_refered_tbl.'.referal_id')                
                        ->where($refered_tbl_name.'.user_id',$loggedInUserId)
                      //  ->where($refered_tbl_name.'.withdraw_reqeust_status','0')
                        ->orderBy('id','desc')->get();
        
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
              
        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_termemail      = $arr_search_column['q_email'];

            $obj_qutoes = $obj_qutoes->where($prefixed_refered_tbl.'.email','LIKE', '%'.$search_termemail.'%');

           
        }

       
     
        $current_context = $this;

        $json_result  = Datatables::of($obj_qutoes);
        
        $json_result  = $json_result->editColumn('email',function($data) use ($current_context)
                        {
                            return $data->email;
                        })
                        ->editColumn('user_name',function($data) use ($current_context)
                        {
                            if(isset($data->user_name) && strlen($data->user_name)>1)
                            $user_name = $data->user_name;
                           else
                             $user_name = 'NA';

                            return $user_name;
                        })
                        ->editColumn('amount',function($data) use ($current_context)
                        {
                            $total_amount = $data->amount;
                           
                            return $total_amount;
                        })
                        ->editColumn('created_at',function($data) use ($current_context)
                        {
                            $created_at = date("d M Y",strtotime($data->created_at));
                           
                            return $created_at;
                        })
                        ;                     
                      
        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
    }

}
