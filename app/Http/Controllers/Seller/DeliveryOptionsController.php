<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\DeliveryOptionsModel;


use Sentinel;
use DB;
use Datatables;
use Validator;
use Flash;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class DeliveryOptionsController extends Controller
{

    public function __construct ( 
                                    UserModel $user,
                                    DeliveryOptionsModel $DeliveryOptionsModel
                                )
    {

        $this->UserModel          = $user;
        $this->BaseModel          = $DeliveryOptionsModel;

        $this->module_icon        = "fa-cogs";
        $this->module_title       = "Delivery Options";
        $this->module_view_folder = "seller/delivery_options";
        $this->module_url_path    = url('/')."/seller/delivery_options";
    }

    public function index() {
       
        $this->arr_view_data['page_title']           = 'Delivery Options';
        $this->arr_view_data['module_url_path']      = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create() {

        $this->arr_view_data['page_title']           = 'Add Delivery Options';
        $this->arr_view_data['module_url_path']      = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }
    public function store(Request $request) {

        $arr_rules = [];
        $arr_rules =    [
                           'title'  => 'required',
                           'day'    => 'required|numeric',
                           'cost'  => 'required'
                        ];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails()) {

            $description = Validator::make($request->all(),$arr_rules)->errors()->first();

            $response['status']      = 'warning';
            $response['description'] = $description;
           
            return response()->json($response);
        }

        $user_obj = Sentinel::getUser();        
        $user_arr = $user_obj->toArray();

        $data = [];

        $data['seller_id']  = $user_arr['id'];
        $data['title']      = $request->input('title');
        $data['day']        = $request->input('day');
        $data['cost']       = $request->input('cost');

        $create = $this->BaseModel->create($data);

        if ($create) {

            $response['status']         = 'success';
            $response['description']    = 'Delivery Option Added successfully!';
            $response['link']           = $this->module_url_path;
           
            return response()->json($response);
        }
        else  {

            $response['status']      = 'warning';
            $response['description'] = 'Somethinf went wrong!';
           
            return response()->json($response);
        }
    }

    public function get_records(Request $request) {

        $obj_user     = $this->get_delivery_options_details($request);

        $current_context = $this;
        $json_result     = Datatables::of($obj_user);

        $json_result     = $json_result->blacklist(['id']);        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context) {

                                return base64_encode($data->id);
                            })  
                            ->editColumn('title',function($data) use ($current_context) {

                                if(isset($data->title) && $data->title!="") {

                                    return $data->title;
                                }
                            })  
                            ->editColumn('day',function($data) use ($current_context)
                            { 
                               if ($data->day != "NULL" && $data->day!="") {

                                    return $data->day;
                                }                               
                            })  
                            ->editColumn('cost',function($data) use ($current_context) {

                                if(isset($data->cost) && $data->cost!="") {

                                    return "$ ".$data->cost;
                                } 
                            })                             
                            ->editColumn('build_status_btn',function($data) use ($current_context) {

                                $build_status_btn ='1';

                                if($data->status == '0') {

                                    $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->status == '1') {
                                   
                                    $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }

                                return $build_status_btn;
                            }) 
                            ->editColumn('build_action_btn',function($data) use ($current_context) {

                                $view_href =  url('/').'/seller/delivery_options/view/'.base64_encode($data->id);
                                $build_view_action = '<a href="'.$view_href.'" class="eye-actn" title="View Delivery Options"> View </a>';

                                $edit_href =  url('/').'/seller/delivery_options/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a href="'.$edit_href.'" class="eye-actn" title="Edit Delivery Options"> Edit </a>';
                                
                                $delete_href =  url('/').'/seller/delivery_options/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="confirm_delete(this,event);"';

                                $build_delete_action = '<a class="eye-actn btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                                
                                return $build_action = $build_view_action.' '.$build_edit_action.' '.$build_delete_action;
                            })
                            ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
    }

    public function get_delivery_options_details(Request $request) {

        $user = Sentinel::getUser();

        if(!empty($user)) {

          $seller_id = $user->id;
        } 

        $delivery_options_details      = $this->BaseModel->getTable();
        $prefix_delivery_options_detail  = DB::getTablePrefix().$this->BaseModel->getTable();
       
        $obj_delivery_options = DB::table($delivery_options_details)->select(DB::raw($delivery_options_details.'.*' ))
                                ->where($delivery_options_details.'.seller_id',$seller_id)
                                ->orderBy($delivery_options_details.'.id','asc');  

        $arr_search_column = $request->input('column_filter');

        if(isset($arr_search_column['q_title']) && $arr_search_column['q_title'] != '') {

            $search_name_term  = $arr_search_column['q_title'];
            $obj_delivery_options  = $obj_delivery_options->where('title','LIKE', '%'.$search_name_term.'%');
        }
        if(isset($arr_search_column['q_day']) && $arr_search_column['q_day'] != '') {

            $search_discount_term  = $arr_search_column['q_day'];
            $obj_delivery_options  = $obj_delivery_options->where('day','LIKE', '%'.$search_discount_term.'%');
        }
        if(isset($arr_search_column['q_cost']) && $arr_search_column['q_cost'] != '') {

            $search_type_term  = $arr_search_column['q_cost'];
            $obj_delivery_options  = $obj_delivery_options->where('cost','LIKE', '%'.$search_type_term.'%');
        }
        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '') {

            $search_active  = $arr_search_column['q_status'];
            $obj_delivery_options  = $obj_delivery_options->where($prefix_delivery_options_detail.'.status','LIKE', '%'.$search_active.'%');
        }
        return $obj_delivery_options;                            
    }

    public function activate(Request $request) {

        $id = base64_decode($request->input('id'));

        $update_ststus = $this->BaseModel
                                ->where('id',$id)
                                ->update(['status' => '1']);
        if ($update_ststus) {

            $arr_response['status'] = 'SUCCESS';
            $arr_response['data'] = 'ACTIVE';

            return response()->json($arr_response);
        }
    }

    public function deactivate(Request $request) {

        $id = base64_decode($request->input('id'));

        $update_ststus = $this->BaseModel
                                ->where('id',$id)
                                ->update(['status' => '0']);
        if ($update_ststus) {

            $arr_response['status'] = 'SUCCESS';
            $arr_response['data'] = 'DEACTIVE';

            return response()->json($arr_response);
        }
    }

    public function delete($enc_id = FALSE) {

        if(!$enc_id) {

            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id))) {

            Flash::success(str_singular($this->module_title).' Deleted Successfully');
        }
        else {

            Flash::error('Problem Occurred While Deleting '.str_singular($this->module_title));
        }
        return redirect()->back();
    }

    public function perform_delete($id) {


        $entity = $this->BaseModel->where('id',$id)->first();
    
        if($entity) {

           $this->BaseModel->where('id',$id)->delete();

           Flash::success(str_plural($this->module_title).' Deleted Successfully');
           return true; 
        }
        else {

            Flash::error('Problem Occurred while deleting '.str_singular($this->module_title)); 
            return FALSE;
        }
    }

    public function view($delivery_options) {

        $id = base64_decode($delivery_options);

        $delivery_options_obj = $this->BaseModel->where('id',$id)->first();

        if ($delivery_options_obj) {

            $delivery_options_arr = $delivery_options_obj->toArray();
        }

        $this->arr_view_data['page_title']      = "View ".$this->module_title;
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['delivery_options'] = isset($delivery_options_arr)?$delivery_options_arr:[];  
       
        return view($this->module_view_folder.'.view', $this->arr_view_data);
    }

    public function edit($delivery_options) {

        $id = base64_decode($delivery_options);

        $delivery_options_obj = $this->BaseModel->where('id',$id)->first();

        if ($delivery_options_obj) {

            $delivery_options_arr = $delivery_options_obj->toArray();
        }

        $this->arr_view_data['page_title']      = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['delivery_options'] = isset($delivery_options_arr)?$delivery_options_arr:[];  
       
        return view($this->module_view_folder.'.edit', $this->arr_view_data);
    }

    public function update(Request $request) {

        $arr_rules = [];
        $arr_rules =    [
                           'title'  => 'required',
                           'day'    => 'required|numeric',
                           'cost'  => 'required'
                        ];

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails()) {

            $description = Validator::make($request->all(),$arr_rules)->errors()->first();

            $response['status']      = 'warning';
            $response['description'] = $description;
           
            return response()->json($response);
        }

        $data = [];

        $id = $request->input('delivery_options_id');

        $data['title']  = $request->input('title');
        $data['day']    = $request->input('day');
        $data['cost']   = $request->input('cost');

        $create = $this->BaseModel
                        ->where('id' , $id)
                        ->update($data);

        if ($create) {

            $response['status']         = 'success';
            $response['description']    = 'Delivery Option updated successfully!';
            $response['link']           = $this->module_url_path;
           
            return response()->json($response);
        }
        else  {

            $response['status']      = 'warning';
            $response['description'] = 'Somethinf went wrong!';
           
            return response()->json($response);
        }
    }

}