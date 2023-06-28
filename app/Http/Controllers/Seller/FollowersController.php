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

use App\Models\FollowModel;



use Sentinel;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class FollowersController extends Controller
{

    public function __construct(
                                
                UserModel $user,
                BuyerModel $BuyerModel,
                SellerModel $SellerModel,
                UserSubscriptionsModel $UserSubscriptionsModel,
                MembershipModel $MembershipModel,
                FollowModel $FollowModel

               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;

        $this->BuyerModel          = $BuyerModel;
        $this->SellerModel         = $SellerModel;
        $this->UserSubscriptionsModel = $UserSubscriptionsModel;
        $this->MembershipModel    = $MembershipModel;
        $this->FollowModel        = $FollowModel;

        $this->arr_view_data       = [];

        $this->module_title       = "Followers";
        $this->module_view_folder = "seller/followers";
        $this->module_url_path      = url('/')."/seller/followers";
        
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
       
        $this->arr_view_data['page_title']           = 'Followers';
        $this->arr_view_data['module_url_path']      = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_followers(Request $request)
        {  


            $loggedInUserId = 0;
            $user = Sentinel::check();

            if($user)
            {
                $loggedInUserId = $user->id;
            }

           
            $follower_table = $this->FollowModel->getTable();
            $prefixed_follower_tbl = DB::getTablePrefix().$follower_table;

            $user_table = $this->UserModel->getTable();
            $prefixed_user_tbl = DB::getTablePrefix().$user_table;

            $obj_qutoes = DB::table($follower_table)
                                 
                                    ->select(DB::raw($follower_table.".*,".
                                     "CONCAT(".$prefixed_user_tbl.".first_name,' ',"
                                            .$prefixed_user_tbl.".last_name) as user_name,".
                                            $prefixed_user_tbl.".email"
                                                   ))                                  
                                     ->leftjoin($prefixed_user_tbl,$prefixed_user_tbl.'.id','=',$prefixed_follower_tbl.'.buyer_id')
                                    ->where($follower_table.'.seller_id',$loggedInUserId)
                                   ->orderBy($follower_table.".id",'DESC');

            
            /* ---------------- Filtering Logic ----------------------------------*/                    
            $arr_search_column = $request->input('column_filter');

             if(isset($arr_search_column['q_created_at']) && $arr_search_column['q_created_at']!="")
            {
                 $search_created_at_term = date("Y-m-d",strtotime($arr_search_column['q_created_at']));
                $obj_qutoes = $obj_qutoes->where($follower_table.'.created_at','LIKE', '%'.$search_created_at_term.'%');
            }
             
             if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
            {
                 $search = $arr_search_column['q_name'];
                 $obj_qutoes = $obj_qutoes->where($prefixed_user_tbl.'.first_name','LIKE', '%'.$search.'%')->orWhere($prefixed_user_tbl.'.last_name','LIKE', '%'.$search.'%');
            }  

             if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
            {
                 $search_email = $arr_search_column['q_email'];
                 $obj_qutoes = $obj_qutoes->where($prefixed_user_tbl.'.email','LIKE', '%'.$search_email.'%');
            }   
          
                
            

            $current_context = $this;

            $json_result  = Datatables::of($obj_qutoes);
            
            $json_result  = $json_result->editColumn('created_at',function($data) use ($current_context)
                            {
                                return us_date_format($data->created_at);


                            }) 
                            ->editColumn('user_name',function($data) use ($current_context){

                                 if(strlen($data->user_name)>1 && $data->user_name!='')
                                 {
                                    return $data->user_name;
                                 }
                                 else{
                                    return 'NA';
                                 }
                            })
                            ->editColumn('email',function($data) use ($current_context){

                                 if($data->email!='')
                                 {
                                    return $data->email;
                                 }
                                 else{
                                    return 'NA';
                                 }
                            });
                          
                         

            $build_result = $json_result->make(true)->getData();

            return response()->json($build_result);
        }//end

   

}
