<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubAdminActivityModel;
use App\Models\UserModel;

use Flash;
use Sentinel;
use DB;
use Datatables;

class SubAdminActivityController extends Controller
{
    
    public function __construct(UserModel               $UserModel,
								SubAdminActivityModel   $SubAdminActivityModel
							   )
    {
          
        $this->UserModel                    = $UserModel;
        $this->SubAdminActivityModel        = $SubAdminActivityModel;
        $this->BaseModel                    = $this->SubAdminActivityModel;
     
        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/sub_admin_activity");
        $this->module_title                 = "Activity Log";
        $this->module_url_slug              = "Activity Log";
        $this->module_view_folder           = "admin.users.sub_admin";


    }


    public function index()
    {

        $this->arr_view_data['page_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        

        return view($this->module_view_folder.'.sub_admin_activity_log', $this->arr_view_data);

    }

    public function get_log_details(Request $request)
    {
      
        $activity_log_table           = $this->BaseModel->getTable();
        
        $prefixed_activity_log_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $user_table            = $this->UserModel->getTable();
        $prefixed_user_table   = DB::getTablePrefix().$this->UserModel->getTable();


        DB::enableQueryLog(); 
        $obj_activity = DB::table($activity_log_table)
                                ->select(DB::raw($activity_log_table.".id as log_id,".
                                  
                                    $activity_log_table.".user_id, ".
                                    $activity_log_table.".title,".
                                    $activity_log_table.".message,".
                                     
                                    $activity_log_table.".action,".
                                    $prefixed_user_table.".id as uid, ".

                                    "CONCAT(".$prefixed_user_table.".first_name,' ',"
                                            .$prefixed_user_table.".last_name) as user_name"
                                ))

                                ->leftjoin($prefixed_user_table,$prefixed_user_table.'.id','=',$activity_log_table.'.user_id')
        
                                ->orderBy($activity_log_table.'.id','DESC');
 

        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
        {
            $search_term   = $arr_search_column['q_name'];
           
            $obj_activity  = $obj_activity->having('user_name','LIKE', '%'.$search_term.'%');
                                 

        }

        /*if(isset($arr_search_column['q_title']) && $arr_search_column['q_title']!="")
        {
            $search_term   = $arr_search_column['q_title'];
        
            $obj_activity  = $obj_activity->where($prefixed_activity_log_table.".title,",'LIKE', '%'.$search_term.'%');
                                 

        }*/
  

        return $obj_activity;
    }

    public function get_records(Request $request)
    {
        $obj_user     = $this->get_log_details($request);

        $current_context = $this;

        $json_result     = Datatables::of($obj_user);

        $json_result     = $json_result->blacklist(['id']);
        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->log_id);
                            })
                            ->editColumn('user_name',function($data) use ($current_context)
                            {
                                
                                if(strlen($data->user_name)=='1')
                                {
                                 return 'NA';   
                                }
                                elseif(isset($data->user_name) && !empty($data->user_name))
                                {
                                    return $data->user_name;
                                } 
                            })

                            ->editColumn('message',function($data) use ($current_context)
                            {
                                
                                if(strlen($data->message)>50)
                                {
                                   return '<p class="prod-desc">'.str_limit($data->message,50).'..<a class="readmorebtn" message="'.$data->message.'" style="cursor:pointer"><b>Read more</b></a></p>';
                                }
                                else
                                {
                                   return $data->message;
                                }  
                                 
                            })

                            
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

 
}
