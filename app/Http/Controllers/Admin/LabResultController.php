<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LabResultModel;
 
 
class LabResultController extends Controller
{
    
    public function __construct(LabResultModel $siteSetting )
    {
        $this->LabResultModel   = $siteSetting;
        $this->arr_view_data      = [];
        $this->BaseModel          = $this->LabResultModel;

        $this->user_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->welcome_base_img_path   = base_path().config('app.project.img_path.welcome');
        $this->welcome_public_img_path = url('/').config('app.project.img_path.welcome');

        $this->referal_base_img_path   = base_path().config('app.project.img_path.referal');
        $this->referal_public_img_path = url('/').config('app.project.img_path.referal');

        $this->module_title       = "Lab Result";
        $this->module_view_folder = "admin.lab_result";
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/lab_result");
    }

 
    public function index()
    {
        $arr_data      = array();   
        $crypto_symbol = '';

        $obj_data =  $this->BaseModel->first();

        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();    
        }
      
        $this->arr_view_data['arr_data']        = isset($arr_data) ? $arr_data : [];
        $this->arr_view_data['page_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
 
    

    public function update(Request $request, $enc_id) {
        //dd($request->all());
        $id = base64_decode($enc_id);


        /*Check Validations*/
        $inputes = request()->validate([
            'description'              =>'required',
           
        ]);      

        $arr_data['lab_result']                     = $request->input('description');  


        if($enc_id != 0){
            $entity = $this->BaseModel->where('id',$id)->update($arr_data);
        } else {
           // $product_review = $this->BaseModel->firstOrNew(['id' => $id]);
            $lab_result = $this->BaseModel->firstOrNew(['id' => $id]);
            $lab_result->lab_result = $request->input('description');
            $lab_result->save(); 
        }
          
        return redirect()->back()->withInput();
        
    }

   
}
