<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SiteSettingModel;
 
 
class HighlightHeadersController extends Controller
{
    
    public function __construct(SiteSettingModel $siteSetting )
    {
        $this->SiteSettingModel   = $siteSetting;
        $this->arr_view_data      = [];
        $this->BaseModel          = $this->SiteSettingModel;

        $this->user_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->welcome_base_img_path   = base_path().config('app.project.img_path.welcome');
        $this->welcome_public_img_path = url('/').config('app.project.img_path.welcome');

        $this->referal_base_img_path   = base_path().config('app.project.img_path.referal');
        $this->referal_public_img_path = url('/').config('app.project.img_path.referal');

        $this->module_title       = "Lab Result";
        $this->module_view_folder = "admin.highlights";
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/lab_result");
    }

 
    public function index_header()
    {
        $arr_data      = array();   
        $crypto_symbol = '';

        $obj_data =  $this->BaseModel->first();

        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();    
        }

            //dd($arr_data);
        $this->arr_view_data['arr_data']        = isset($arr_data) ? $arr_data : [];
        $this->module_title                     = 'Header';
        $this->arr_view_data['page_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = url(config('app.project.admin_panel_slug'));
        
        return view($this->module_view_folder.'.edit_header',$this->arr_view_data);
    }   

    public function update_header(Request $request, $enc_id) {
        // dd($request->all());

        $id = base64_decode($enc_id);


        /*Check Validations*/
        $inputes = request()->validate([
            'description'              =>'required',
           
        ]);      

        $arr_data['highlight_header']                     = $request->input('description');  


        if($enc_id != "0"){          
            $entity = $this->BaseModel->where('site_setting_id',$id)->update($arr_data);
        } /*else {

           // $product_review = $this->BaseModel->firstOrNew(['id' => $id]);
            $lab_result = $this->BaseModel->firstOrNew(['site_setting_id' => $id]);
            $lab_result->highlight_header = $request->input('description');
            $lab_result->save(); 
        }*/
          
        return redirect()->back()->withInput();
        
    }

    public function index_sub_header()
    {
        $arr_data      = array();   
        $crypto_symbol = '';

        $obj_data =  $this->BaseModel->first();

        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();    
        }
        
        $this->module_title                     = 'Sub-header';
        $this->arr_view_data['arr_data']        = isset($arr_data) ? $arr_data : [];
        $this->arr_view_data['page_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = url(config('app.project.admin_panel_slug'));
        
        return view($this->module_view_folder.'.edit_sub_header',$this->arr_view_data);
    }   

    public function update_sub_header(Request $request, $enc_id) {
       // dd($request->all());

        $id = base64_decode($enc_id);


        /*Check Validations*/
        $inputes = request()->validate([
            'description'              =>'required',
           
        ]);      

        $arr_data['highlight_sub_header']                     = $request->input('description');  


        if($enc_id != "0"){          
            $entity = $this->BaseModel->where('site_setting_id',$id)->update($arr_data);
        } /*else {

           // $product_review = $this->BaseModel->firstOrNew(['id' => $id]);
            $lab_result = $this->BaseModel->firstOrNew(['site_setting_id' => $id]);
            $lab_result->highlight_header = $request->input('description');
            $lab_result->save(); 
        }*/
          
        return redirect()->back()->withInput();
        
    }

   
}
