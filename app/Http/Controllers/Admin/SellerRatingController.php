<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TradeModel;
use App\Models\UserModel;
use App\Models\TradeRatingModel;

use Sentinel;
use DB;
use Datatables;

class SellerRatingController extends Controller
{
    /*
    | Author : Sagar B. Jadhav
	| Date   : 01 March 2019
    */

    public function __construct(TradeModel $TradeModel,    							
    							UserModel $UserModel,
    							TradeRatingModel $TradeRatingModel) 
    {	
    	$this->BaseModel                = $TradeRatingModel;    	
    	$this->UserModel                = $UserModel;
    	$this->TradeModel               = $TradeModel;    	

    	$this->arr_view_data = [];
        $this->module_title       = "Rating";
        $this->module_view_folder = "admin.seller_rating";
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/seller_rating");
    }

    public function index($enc_seller_id = false)
    {	
    	$seller_id = base64_decode($enc_seller_id);

    	$seller_details = Sentinel::findById($seller_id);
	
        $this->arr_view_data['seller_id']             	 = $seller_id;
        $this->arr_view_data['page_title']               = "Manage ".str_plural($this->module_title).' Of '.$seller_details->user_name;
        $this->arr_view_data['module_title']             = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']          = $this->module_url_path;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_seller_rating_records(Request $request)
    {
    	$seller_id = $request->seller_id;

    	$rating_tbl           = $this->BaseModel->getTable();
    	$prefixed_rating_tbl  = DB::getTablePrefix().$this->BaseModel->getTable();

    	$user_tbl           = $this->UserModel->getTable();
    	$prefixed_user_tbl  = DB::getTablePrefix().$this->UserModel->getTable();       

    	$trades_tbl           = $this->TradeModel->getTable();
    	$prefixed_trades_tbl  = DB::getTablePrefix().$this->TradeModel->getTable();

        $obj_rating = DB::table($rating_tbl)->select($prefixed_rating_tbl.'.*',
        										$prefixed_user_tbl.'.user_name',
        										$prefixed_trades_tbl.'.trade_ref'
    												)        									
        									->leftJoin($user_tbl,$prefixed_user_tbl.'.id',$prefixed_rating_tbl.'.buyer_user_id')

        									->leftJoin($trades_tbl,$prefixed_trades_tbl.'.id',$prefixed_rating_tbl.'.trade_id')
        									->whereNull($prefixed_rating_tbl.'.deleted_at')
			                                ->where($prefixed_rating_tbl.'.type',1)
			                                ->where($prefixed_rating_tbl.'.seller_user_id',$seller_id)
			                                ->orderBy($prefixed_rating_tbl.'.id','DESC');        
        /* ----------------Filtering----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name']!="")
        {
            $search_term  = $arr_search_column['q_buyer_name'];
            $obj_rating   = $obj_rating->having('user_name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_trade_ref']) && $arr_search_column['q_trade_ref']!="")
        {
            $search_term = $arr_search_column['q_trade_ref'];
            $obj_rating  = $obj_rating->where($prefixed_trades_tbl.'.trade_ref','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_rating']) && $arr_search_column['q_rating']!="")
        {
            $search_term = $arr_search_column['q_rating'];
            $obj_rating  = $obj_rating->where($prefixed_rating_tbl.'.points',$search_term);
        }

        if(isset($arr_search_column['q_trade_status']) && $arr_search_column['q_trade_status']!="")
        {
           $search_term   = $arr_search_column['q_trade_status'];
            $obj_rating   = $obj_rating->where($prefixed_rating_tbl.'.trade_status','LIKE', '%'.$search_term.'%');
        }

        $json_result     = Datatables::of($obj_rating)->make(true);
        
        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }
}
