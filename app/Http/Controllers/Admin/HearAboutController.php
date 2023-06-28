<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProductNewsModel;
use App\Models\OrderModel;
use App\Models\SellerModel;
use App\Models\BuyerModel;
use App\Models\OrderProductModel;
use App\Models\UserModel;
use App\Models\DisputeModel;
use App\Models\TransactionModel;
use App\Models\AdminCommissionModel;
use App\Models\SiteSettingModel;
use App\Common\Services\GeneralService;
use App\Models\ProductInventoryModel;
use App\Models\WithdrawalBalanceModel;

use App\Common\Services\EmailService;
use App\Common\Services\CommisionService;
use App\Common\Services\OrderService;



use App\Common\Traits\MultiActionTrait;
 
use Validator;
use Image;
use DB;  
use Datatables;
use Flash;
use Sentinel;
use Excel;
use Carbon\Carbon;
 
class HearAboutController extends Controller
{       
    use MultiActionTrait;

    public function __construct(
                                UserModel $UserModel
    ) 
    {
    	
        $this->UserModel            = $UserModel;   
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->news_base_img_path   = base_path().config('app.project.img_path.product_news');
        $this->news_public_img_path = url('/').config('app.project.img_path.product_news');

        $this->module_title       = "Hear About Us";
        $this->module_view_folder = "admin.hear_about";
        $this->module_url_path    = $this->admin_url_path."/hear_about";
    }




    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".$this->module_title;
        $this->arr_view_data['module_title']      = $this->module_title;
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	
        $user_table            = $this->UserModel->getTable();
        $prefixed_user_table   = DB::getTablePrefix().$this->UserModel->getTable();

        
        $obj_user = DB::table($user_table)
        ->select(DB::raw($prefixed_user_table.".id as id,".
                 $prefixed_user_table.".first_name as first_name,".
                 $prefixed_user_table.".last_name as last_name,".
                 $prefixed_user_table.".email as email,".
                  $prefixed_user_table.".user_type as user_type,".
                 $prefixed_user_table.".hear_about as hear_about,".
                 $prefixed_user_table.".created_at as created_at,".
                 "CONCAT(".$prefixed_user_table.".first_name,' ',"
                 .$prefixed_user_table.".last_name) as user_name"))->orderBy('id','desc');
        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');    
 

                if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
                {
                    $search_term      = $arr_search_column['q_name'];
                    $obj_user         = $obj_user->where('first_name','LIKE', '%'.$search_term.'%')->orWhere('last_name','LIKE', '%'.$search_term.'%')->orWhere('email','LIKE', '%'.$search_term.'%');
                }
                 if(isset($arr_search_column['q_usertype']) && $arr_search_column['q_usertype']!="")
                {
                    $search_term  = $arr_search_column['q_usertype'];
                       
                    if($search_term=="buyer")
                    { 
                    $obj_user     = $obj_user->where('user_type','LIKE', '%'.$search_term.'%');
                    }
                    else{
                      $obj_user     = $obj_user->where('user_type','LIKE', 'seller');
                    }
                }

              	if(isset($arr_search_column['q_hear_about']) && $arr_search_column['q_hear_about'] != '')
              	{
                 	 $search_term         = $arr_search_column['q_hear_about'];
                        $obj_user         = $obj_user->where('hear_about','LIKE', '%'.$search_term.'%');
              	}

                if(isset($arr_search_column['q_from']) && $arr_search_column['q_from']!="" && isset($arr_search_column['q_to']) && $arr_search_column['q_to']!="")
                {
                    $search_from      = $arr_search_column['q_from'];
                    $search_from      = date('Y-m-d',strtotime($search_from));

                    $search_to      = $arr_search_column['q_to'];
                    $search_to      = date('Y-m-d',strtotime($search_to));

                    $search_from = $search_from.' 00:00:00';
                    $search_to   = $search_to.' 23:59:59';


                    $obj_user = $obj_user->whereBetween($prefixed_user_table.'.created_at',[ $search_from,$search_to ]);
                }  



    	/* --------------------------------------------------------------------*/
        $current_context = $this;

        $json_result = Datatables::of($obj_user);  
        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })->editColumn('user_name',function($data) use ($current_context)
                            {
                                
                                if(strlen($data->user_name)=='1')
                                {
                                 return $data->email;   
                                }
                                elseif(isset($data->user_name) && !empty($data->user_name))
                                {
                                    return $data->user_name;
                                } 
                            })->editColumn('hear_about',function($data) use ($current_context)
                            {
                                
                                if(strlen($data->hear_about)=='')
                                {
                                 return 'NA';   
                                }
                                elseif(isset($data->hear_about) && !empty($data->hear_about))
                                {
                                    return $data->hear_about;
                                } 
                              })->editColumn('user_type',function($data) use ($current_context)
                              {
                                if(isset($data->user_type) && !empty($data->user_type))
                                {
                                    $usertype = $data->user_type;
                                    if($usertype=="seller"){
                                        $usertype = "Dispensary";
                                        return $usertype;
                                    }
                                    else{
                                        return "Buyer";
                                    }
                                }    
                            })->editColumn('created_at',function($data) use ($current_context)
                            {
                                
                                  return date('d M yy',strtotime($data->created_at));
                            })->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }


    // export excel function added   
/*    function export($from_date,$to_date)
    {
        if($from_date && $to_date)
       {
        $completedflag = 0;
        $this->OrderService->export_orders($from_date,$to_date,$completedflag,NULL);
       }
            
    }// end of function*/



    // export csv function added   
    function exportcsv($from_date,$to_date)
    {

    if($from_date && $to_date)
       {
       

        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));

        $from_date = $from_date.' 00:00:00';
        $to_date   = $to_date.' 23:59:59';

        $user_table            = $this->UserModel->getTable();
        $prefixed_user_table   = DB::getTablePrefix().$this->UserModel->getTable();
      

          $obj_userdetail = DB::table($user_table)
           ->select(DB::raw('
            '.$user_table.'.id as id,
            '.$user_table.'.first_name,
            '.$user_table.'.last_name,
            '.$user_table.'.user_type,
            '.$user_table.'.email,
            '.$user_table.'.hear_about,
             '.$user_table.'.created_at as created_at,
             '."CONCAT(".$user_table.".first_name,' ',".$user_table.".last_name) as user_name"
             ))->whereBetween($user_table.'.created_at',[ $from_date,$to_date ]);



             $user_array[] = array( 'User Name','User Type','Hear About','Date');
             $user_name    = "";

            $obj_userdetail = $obj_userdetail->orderBy('id','desc')->get();

             foreach($obj_userdetail as $user)
             {

               if(strlen($user->user_name)>1)
               {
                 $user_name = $user->user_name;
               }
               else
               {
                 $user_name = $user->email;
               }

               if($user->user_type=="seller"){
                $usertype ="Dispensary";
               }else{
                $usertype="Buyer";
               }

              $user_array[] = array(
               'User Name'    => $user_name ,
               'User Type'    => $usertype ,
               'Hear About'   => !empty($user->hear_about)?$user->hear_about:'NA',
               'Date'         => date('d M yy',strtotime($user->created_at))
              );
             }

             //dd($user_array);

             $set_sheetname = 'How_did_you_hear_about_us';

             Excel::create($set_sheetname, function($excel) use ($user_array)
             {
                $excel->setTitle('How Did You Hear About Us');
                $excel->sheet('Hear About', function($sheet) use ($user_array)
                {
                   $sheet->fromArray($user_array, null, 'A1', false, false);

                });

             })->download('csv');

        }//if form date and to date    
    }// end of function



}
