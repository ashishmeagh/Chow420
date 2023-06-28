<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;

use App\Models\DropShipperModel;  
use App\Common\Services\LanguageService; 
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\ProductModel;


use Validator;
use Session;
use Flash;
use File;
use Sentinel;
use DB;
use Datatables;

class DropShipperController extends Controller
{
    use MultiActionTrait;
    
    public function __construct(
                                DropShipperModel $DropShipperModel,
                                LanguageService $langauge,
                                ActivityLogsModel $activity_logs,
                                ProductModel $ProductModel
                                )
    {
        $this->BaseModel                = $DropShipperModel;
        $this->LanguageService          = $langauge;
        $this->ActivityLogsModel        = $activity_logs;
        $this->ProductModel             = $ProductModel;

        $this->arr_view_data      = [];
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/drop_shipper");
        $this->module_title       = "Dropshipper";
        $this->module_url_slug    = "drop_shipper";
        $this->module_view_folder = "admin.drop_shipper";
        /*For activity log*/
        $this->obj_data =[];
        $this->obj_data    = Sentinel::getUser();
    }   
 
    public function index()
    {
        $arr_lang     = array();
        $arr_category = array();

        $obj_data = $this->BaseModel->get();

        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data']                 = $arr_data;
        $this->arr_view_data['page_title']               = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']             = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']         = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {

        $drop_shipper_table         = $this->BaseModel->getTable();
        $prefixed_dropshipper_table = DB::getTablePrefix().$this->BaseModel->getTable();

        $prod_table         = $this->ProductModel->getTable();
        $prefixed_prod_table = DB::getTablePrefix().$this->ProductModel->getTable();


        // $obj_dropshipper        = DB::table($drop_shipper_table)
        //                         ->select(DB::raw($prefixed_dropshipper_table.".id as id,".
        //                                          $prefixed_dropshipper_table.".name as name,".
        //                                          $prefixed_dropshipper_table.".email as email,".
        //                                          $prefixed_dropshipper_table.".product_price as price"
        //                                          ))
        //                         ->where($drop_shipper_table.'.deleted_at','0000-00-00 00:00:00')
        //                         ->orderBy($drop_shipper_table.'.created_at','DESC');


          $obj_dropshipper     = DB::table($prod_table)
                                ->select(DB::raw($prefixed_dropshipper_table.".id as id,".
                                                 $prefixed_dropshipper_table.".name as name,".
                                                 $prefixed_dropshipper_table.".email as email,".
                                                 $prefixed_dropshipper_table.".product_price as price,".
                                                 $prod_table.".product_name"
                                                 ))
                                ->leftJoin($prefixed_dropshipper_table,$prefixed_dropshipper_table.'.id',$prod_table.'.drop_shipper')
                                ->where($drop_shipper_table.'.deleted_at','0000-00-00 00:00:00')
                                ->orderBy($drop_shipper_table.'.created_at','DESC');



        /* ---------------- Filtering Logic ----------------------------------*/                    

        $arr_search_column = $request->input('column_filter');
        
         if(isset($arr_search_column['q_pname']) && $arr_search_column['q_pname']!="")
        {
            $search_q_pnameterm      = $arr_search_column['q_pname'];
            $obj_dropshipper  = $obj_dropshipper->where($prod_table.'.product_name','LIKE', '%'.$search_q_pnameterm.'%');
        }
        if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
        {
            $search_term      = $arr_search_column['q_name'];
            $obj_dropshipper  = $obj_dropshipper->where($drop_shipper_table.'.name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_term      = $arr_search_column['q_email'];
            $obj_dropshipper  = $obj_dropshipper->where($drop_shipper_table.'.email','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_price']) && $arr_search_column['q_price']!="")
        {
            $search_term      = $arr_search_column['q_price'];
            $obj_dropshipper  = $obj_dropshipper->where($drop_shipper_table.'.product_price','=',$search_term);
        }


        /* ---------------- Filtering Logic End----------------------------------*/                    


        $current_context      = $this;

        $json_result          = Datatables::of($obj_dropshipper)->
                                editColumn('price',function($data) use ($current_context)
                                {
                                   $price = '$'.num_format($data->price);
                                   return $price;
                                })->
                                editColumn('name',function($data) use ($current_context)
                                {
                                   $name = ucfirst($data->name);
                                   return $name;
                                })->make(true);
    
        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

}
