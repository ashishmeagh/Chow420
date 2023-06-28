<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\GeneralSettingsModel;
use App\Common\Services\UserService;


use Validator;
use Session;
use Flash;
use File;
use Sentinel;
use DB;
use Datatables; 

class GeneralSettingsController extends Controller
{
    public function __construct(
    							GeneralSettingsModel $GeneralSettingsModel,
                                UserService $UserService
    						  )
    {	
    	$this->GeneralSettingsModel = $GeneralSettingsModel;
    	$this->BaseModel            = $this->GeneralSettingsModel;
        $this->UserService          = $UserService;

    	$this->arr_view_data      = [];
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/general_settings");
        $this->module_title       = "General Settings";
        $this->module_url_slug    = "general_settings";
        $this->module_view_folder = "admin.general_settings";
    }

    public function index()
    {
        $this->arr_view_data['page_title']       = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']     = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']  = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
        $obj_categories   = $this->get_general_settings_data($request);

        $current_context  = $this;

        $json_result      = Datatables::of($obj_categories);
 
        $json_result      = $json_result->blacklist(['id']);
        
        $json_result      = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                            ->editColumn('data_id',function($data) use ($current_context)
                            {
                               
                                if($data->data_id != "")
                                {
                                    return $data->data_id;
                                }
                                else
                                {
                                    return "N/A";
                                }
                            })
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a class="btn btn-outline btn-info btn-circle show-tooltip" href="'.$edit_href.'" title="Edit"><i class="ti-pencil-alt2" ></i></a>';
                                return $build_action = $build_edit_action;
                            })
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }


    function get_general_settings_data(Request $request)
    {
        $general_settings_table     = $this->BaseModel->getTable();
        $obj_general_settings       = DB::table($general_settings_table)
                                            ->orderBy($general_settings_table.'.created_at','DESC');
		
		/* ---------------- Filtering Logic ----------------------------------*/

        $arr_search_column = $request->input('column_filter');

        if(isset($arr_search_column['q_data_id']) && $arr_search_column['q_data_id']!="")
        {
            $search_term            = $arr_search_column['q_data_id'];
            $obj_general_settings   = $obj_general_settings->where($general_settings_table.'.data_id','LIKE', '%'.$search_term.'%');
        }

        return $obj_general_settings;
    }

    public function edit($enc_id)
    {
    	$id   = base64_decode($enc_id);
        $arr_general_settings = [];
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
        if($obj_data)
        {
           $arr_general_settings = $obj_data->toArray(); 
        }

        $this->arr_view_data['edit_mode']           = TRUE;
        $this->arr_view_data['enc_id']              = $enc_id;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;
        $this->arr_view_data['arr_general_settings']= isset($arr_general_settings)?$arr_general_settings :[];  
        $this->arr_view_data['page_title']          = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']        = $this->module_title;

        return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

    public function update(Request $request)
    {
        $user = Sentinel::check();

    	$form_data = $request->all();

    	$arr_rules = [
                       'data_value'   => 'required',
                       // 'data_live'    => 'required',
                       // 'data_sandbox' => 'required'
                     ];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form Validation Failed..Please Check All Fields..';

            return response()->json($response);
        }

    	$id           = isset($form_data['id'])?base64_decode($form_data['id']):'';
    	
    	$data_value   = isset($form_data['data_value'])?$form_data['data_value']:'';
    	$data_live    = isset($form_data['data_live'])?$form_data['data_live']:'';
    	$data_sandbox = isset($form_data['data_sandbox'])?$form_data['data_sandbox']:'';

    	$arr_data = [
    					'data_value'   => $data_value,
    					'data_live'    => $data_live,
    					'data_sandbox' => $data_sandbox,
    				];

    	$update = $this->GeneralSettingsModel->where('id',$id)->update($arr_data);

    	if($update)
    	{

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
            //save sub admin activity log 

            if(isset($user) && $user->inRole('sub_admin'))
            {
                $arr_event                 = [];
                $arr_event['action']       = 'EDIT';
                $arr_event['title']        = $this->module_title;
                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated general settings information.';

                $result = $this->UserService->save_activity($arr_event); 
            }

            /*----------------------------------------------------------------------*/

    		$response['status']      = 'success';
    		$response['description'] = 'Record updated successfully.';
    	}
    	else
    	{
    		$response['status']      = 'error';
    		$response['description'] = 'unable to update record.';
    	}

    	$response['link'] =$this->module_url_path.'/edit/'.base64_encode($id);

    	return response()->json($response);
    }
}
