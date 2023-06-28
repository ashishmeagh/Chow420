<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\UnitModel;

use DB;
use Datatables;
use Validator;

class UnitController extends Controller
{
    public function __construct(UnitModel $UnitModel)
    {
    	$this->BaseModel          = $UnitModel;

    	$this->module_title       = "Unit";
        $this->module_view_folder = "admin.unit";
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/unit");
        $this->arr_view_data      = [];
    }

    public function index()
    {
    	$this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$unit_table          = $this->BaseModel->getTable();
        $prefixed_unit_table = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_unit_table = DB::table($unit_table)                           
        						->orderBy($unit_table.'.created_at','DESC');

        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');        

          	if(isset($arr_search_column['q_unit']) && $arr_search_column['q_unit'] != '')
          	{
             	$search_term    = $arr_search_column['q_unit'];
             	$obj_unit_table = $obj_unit_table->where('unit','LIKE','%'.$search_term.'%');
          	}
    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_unit_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })
                        ->editColumn('unit',function($data) use ($current_context)
                        {
                            if($data->unit != "")
                            {
                               return $data->unit;
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
                            
                            return $build_edit_action;
                        })

                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

    public function create()
    {
    	$this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$form_data = $request->all();

        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
        if($is_update_process == false)
        {
        	$arr_rules = [
                            'unit' => 'required'
                         ];
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form Validation Failed..Please Check All Fields..';

            return response()->json($response);
        }
    	
        
        /* Main Model Entry */
        $unit = $this->BaseModel->firstOrNew(['id' => $id]);     
        $unit->unit    =  isset($form_data['unit'])?$form_data['unit']:'';
     
        $unit->save();

        if($unit)
        {
            if($is_update_process == false)
            {
                if($unit->id)
                {
                    $response['link'] =$this->module_url_path.'/edit/'.base64_encode($unit->id);
                }

                $response['status']      = "success";
            	$response['description'] = "Unit Added Successfully."; 
            }
            else
            {
                $response['link'] = $this->module_url_path.'/edit/'.base64_encode($id);

                $response['status']      = "success";
            	$response['description'] = "Unit Updated Successfully."; 
            }
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error Occurred While Updating Unit.";
        }

        return response()->json($response);
    }

    public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_unit = [];
        if($obj_data)
        {
           $arr_unit = $obj_data->toArray(); 
        }
    
      	$this->arr_view_data['edit_mode']        = TRUE;
     	$this->arr_view_data['enc_id']           = $enc_id;
      	$this->arr_view_data['module_url_path']  = $this->module_url_path;
      	$this->arr_view_data['arr_unit']   		 = isset($arr_unit)?$arr_unit:[];  
      	$this->arr_view_data['page_title']       = "Edit ".$this->module_title;
      	$this->arr_view_data['module_title']     = $this->module_title;
  
      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }

    
}

