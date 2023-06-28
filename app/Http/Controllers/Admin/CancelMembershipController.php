<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\UserModel;
use App\Models\MembershipModel;
use App\Models\UserSubscriptionsModel;


use App\Common\Traits\MultiActionTrait;
 
use Validator;
use DB;  
use Datatables;
use Flash;
use Sentinel;
use Excel;
use Carbon\Carbon;
 
class CancelMembershipController extends Controller
{       
    use MultiActionTrait;

    public function __construct(
                                UserModel $UserModel,
                                MembershipModel $MembershipModel,
                                UserSubscriptionsModel $UserSubscriptionsModel) 
    {
    	
        $this->UserModel          = $UserModel;   
        $this->MembershipModel    = $MembershipModel; 
        $this->UserSubscriptionsModel = $UserSubscriptionsModel;  
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->news_base_img_path   = base_path().config('app.project.img_path.product_news');
        $this->news_public_img_path = url('/').config('app.project.img_path.product_news');

        $this->module_title       = "Cancelled Subscriptions";
        $this->module_view_folder = "admin.cancel_membership";
        $this->module_url_path    = $this->admin_url_path."/cancel_membership";
    }



    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	
        $user_subscription_table  = $this->UserSubscriptionsModel->getTable();
        $prefixed_user_subscription_table   = DB::getTablePrefix().$this->UserSubscriptionsModel->getTable();

        $membership_table         = $this->MembershipModel->getTable();
        $prefixed_membership_table   = DB::getTablePrefix().$this->MembershipModel->getTable();


        $user_table               = $this->UserModel->getTable();
        $prefixed_user_table      = DB::getTablePrefix().$this->UserModel->getTable();

        
        $obj_cancel_subscriptions = DB::table($user_subscription_table)
        ->select(DB::raw($prefixed_user_subscription_table.".id as id,".
                 $prefixed_user_subscription_table.".user_id as user_id,".
                 $prefixed_user_subscription_table.".membership_id as membership_id,".
                 $prefixed_user_subscription_table.".membership_amount  as membership_amount,".
                 $prefixed_user_subscription_table.".is_cancel  as is_cancel,".
                 $prefixed_user_subscription_table.".cancel_reason  as cancel_reason,".
                 $prefixed_user_subscription_table.".updated_at  as cancel_membership_date,".
                 $prefixed_membership_table.".name  as membership_name,".
                 $prefixed_membership_table.".membership_type   as membership_type,".

                 $prefixed_user_table.".first_name as first_name,".
                 $prefixed_user_table.".last_name as last_name,".
                 $prefixed_user_table.".email as email,".
                 "CONCAT(".$prefixed_user_table.".first_name,' ',"
                 .$prefixed_user_table.".last_name) as user_name"))
                ->leftjoin($prefixed_user_table,$prefixed_user_table.'.id','=',$prefixed_user_subscription_table.'.user_id')
                ->leftjoin($prefixed_membership_table,$prefixed_membership_table.'.id','=',$prefixed_user_subscription_table.'.membership_id')
                ->where($prefixed_user_subscription_table.'.is_cancel','=','1')
                ->where($prefixed_user_subscription_table.'.cancel_reason','!=',null)
                ->orderBy($prefixed_user_subscription_table.'.id','desc');
        /* ---------------- Filtering Logic ----------------------------------*/ 


          	$arr_search_column = $request->input('column_filter');    
 

                if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
                {
                    $search_term      = $arr_search_column['q_name'];
                    $obj_cancel_subscriptions         = $obj_cancel_subscriptions->where('first_name','LIKE', '%'.$search_term.'%')
                                         ->orWhere('last_name','LIKE', '%'.$search_term.'%');
                }

          	   if(isset($arr_search_column['q_membership_name']) && $arr_search_column['q_membership_name'] != '')
          	   {
             	 $search_term         = $arr_search_column['q_membership_name'];
                 $obj_cancel_subscriptions  = $obj_cancel_subscriptions->where('name','LIKE', '%'.$search_term.'%');
          	   }

               if(isset($arr_search_column['q_membership_type']) && $arr_search_column['q_membership_type'] != '')
               {
                 $search_term         = $arr_search_column['q_membership_type'];
                 if($search_term == 'Paid' || $search_term == 'paid')
                 $obj_cancel_subscriptions  = $obj_cancel_subscriptions->where('membership_type','=',2);
                 if($search_term == 'Free' || $search_term == 'free')
                 $obj_cancel_subscriptions  = $obj_cancel_subscriptions->where('membership_type','=',1);
               }

                if(isset($arr_search_column['q_membership_amount']) && $arr_search_column['q_membership_amount'] != '')
               {
                 $search_term         = $arr_search_column['q_membership_amount'];
                 $obj_cancel_subscriptions  = $obj_cancel_subscriptions->where('membership_amount','LIKE', '%'.$search_term.'%');
               }

            if(isset($arr_search_column['q_from']) && $arr_search_column['q_from']!="" && isset($arr_search_column['q_to']) && $arr_search_column['q_to']!="")
            {
                $search_from      = $arr_search_column['q_from'];
                $search_from      = date('Y-m-d',strtotime($search_from));

                $search_to      = $arr_search_column['q_to'];
                $search_to      = date('Y-m-d',strtotime($search_to));

                $search_from = $search_from.' 00:00:00';
                $search_to   = $search_to.' 23:59:59';


                $obj_cancel_subscriptions = $obj_cancel_subscriptions->whereBetween($prefixed_user_subscription_table.'.created_at',[ $search_from,$search_to ]);
            }  

    	/* --------------------------------------------------------------------*/
        $current_context = $this;

        $json_result = Datatables::of($obj_cancel_subscriptions);  
        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })
                            ->editColumn('user_name',function($data) use ($current_context)
                            {
                                
                                if(strlen($data->user_name)=='1')
                                {
                                 return $data->email;   
                                }
                                elseif(isset($data->user_name) && !empty($data->user_name))
                                {
                                    return $data->user_name;
                                } 
                            })
                            ->editColumn('cancel_membership_date',function($data) use ($current_context)
                            {
                                return date('d M yy',strtotime($data->cancel_membership_date));
                            })
                            ->editColumn('membership_type',function($data) use ($current_context)
                            {
                               if($data->membership_type==1) return "Free";else return "Paid";
                            })
                            ->editColumn('membership_amount',function($data) use ($current_context)
                            {
                                if($data->membership_amount==0) 
                                return "NA";
                                else
                                return "$".$data->membership_amount;    
                            })
                            ->editColumn('cancel_reason',function($data) use ($current_context)
                            {
                                if(strlen($data->cancel_reason)>30){
                               return '<p class="prod-desc">'.str_limit($data->cancel_reason,30).'..<a class="readmorebtn" reason="'.$data->cancel_reason.'" style="cursor:pointer"><b>Read more</b></a></p>';
                            }
                            else{
                                  return $data->cancel_reason;
                                }
                            })->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

    // export csv function added   
    function exportcsv($from_date,$to_date)
    {

        if($from_date && $to_date)
           {
           

            $from_date = date('Y-m-d',strtotime($from_date));
            $to_date = date('Y-m-d',strtotime($to_date));

            $from_date = $from_date.' 00:00:00';
            $to_date   = $to_date.' 23:59:59';

           $user_subscription_table  = $this->UserSubscriptionsModel->getTable();
            $prefixed_user_subscription_table   = DB::getTablePrefix().$this->UserSubscriptionsModel->getTable();

            $membership_table         = $this->MembershipModel->getTable();
            $prefixed_membership_table   = DB::getTablePrefix().$this->MembershipModel->getTable();


            $user_table               = $this->UserModel->getTable();
            $prefixed_user_table      = DB::getTablePrefix().$this->UserModel->getTable();

                 $obj_cancel_subscriptions = DB::table($user_subscription_table)
                 ->select(DB::raw($prefixed_user_subscription_table.".id as id,".
                 $prefixed_user_subscription_table.".user_id as user_id,".
                 $prefixed_user_subscription_table.".membership_id as membership_id,".
                 $prefixed_user_subscription_table.".membership_amount  as membership_amount,".
                 $prefixed_user_subscription_table.".is_cancel  as is_cancel,".
                 $prefixed_user_subscription_table.".cancel_reason  as cancel_reason,".
                 $prefixed_user_subscription_table.".updated_at  as cancel_membership_date,".
                 $prefixed_membership_table.".name  as membership_name,".
                 $prefixed_membership_table.".membership_type   as membership_type,".

                 $prefixed_user_table.".first_name as first_name,".
                 $prefixed_user_table.".last_name as last_name,".
                 $prefixed_user_table.".email as email,".
                 "CONCAT(".$prefixed_user_table.".first_name,' ',"
                 .$prefixed_user_table.".last_name) as user_name"))
                ->leftjoin($prefixed_user_table,$prefixed_user_table.'.id','=',$prefixed_user_subscription_table.'.user_id')
                ->leftjoin($prefixed_membership_table,$prefixed_membership_table.'.id','=',$prefixed_user_subscription_table.'.membership_id')
                ->where($prefixed_user_subscription_table.'.is_cancel','=','1')
                ->where($prefixed_user_subscription_table.'.cancel_reason','!=',null)
                ->whereBetween($prefixed_user_subscription_table.'.created_at',[ $from_date,$to_date ])
                ->orderBy($prefixed_user_subscription_table.'.id','desc');


                 $user_array[] = array( 'User Name.', 'Membership','Membership Type','Membership Amount','Cancel Reason','Cancelled On');
                 $user_name    = $membership_type = "";

                $obj_cancel_subscriptions = $obj_cancel_subscriptions->orderBy('id','desc')->get();

                 foreach($obj_cancel_subscriptions as $user)
                 {

                   if(strlen($user->user_name)>1)
                   {
                     $user_name = $user->user_name;
                   }
                   else
                   {
                     $user_name = $user->email;
                   }

                   if($user->membership_type!="" && $user->membership_type==1){$membership_type="Free";}
                   if($user->membership_type!="" && $user->membership_type==2){$membership_type="Paid";}

                  $user_array[] = array(
                   'User Name'    => $user_name ,
                   'Membership'   => !empty($user->membership_name)?$user->membership_name:'NA',
                   'Membership Type'=> $membership_type,
                   'Membership Amount'=> ($user->membership_amount!=0)?"$".$user->membership_amount:'NA',
                   'Cancel Reason'=> !empty($user->cancel_reason)?$user->cancel_reason:'NA',
                   'Cancelled On' => !empty($user->cancel_membership_date)?date('d M yy',strtotime($user->cancel_membership_date)):'NA',
                  );
                 }

                 //dd($user_array);

                 $set_sheetname = 'Why_are_you_cancelling_your_subscription';

                 Excel::create($set_sheetname, function($excel) use ($user_array)
                 {
                    $excel->setTitle('Why are you cancelling your subscription');
                    $excel->sheet('Cancel Subscription List', function($sheet) use ($user_array)
                    {
                       $sheet->fromArray($user_array, null, 'A1', false, false);
                       $sheet->getColumnDimension('F')->setAutoSize(true) ;
                    });

                 })->download('csv');

            }//if form date and to date    
    }// end of function



}
