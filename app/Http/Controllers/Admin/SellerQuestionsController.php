<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SellerQuestionsModel;
use App\Common\Services\UserService;

use Sentinel;
use DB;
use Datatables;
use Flash;

class SellerQuestionsController extends Controller
{
    /*
    | Author : Akshay Nair
	| Date   : 31 Dec 2019
    */

    public function __construct(
                                SellerQuestionsModel $SellerQuestionsModel,
                                UserService $UserService
                               ) 
    {
       
        $this->SellerQuestionsModel     = $SellerQuestionsModel;
        $this->UserService              = $UserService;
        

        $this->arr_view_data      = [];
        $this->module_title       = "Dispensary Questions";
        $this->module_view_folder = "admin.seller_questions";
        $this->module_url_path    = url(config('app.project.admin_panel_slug') . "/seller_questions");
    }

    public function index()
    {
        $arr_seller_quest = [];

        $arr_seller_quest  = $this->SellerQuestionsModel->get()->toArray();

        $this->arr_view_data['arr_seller_quests']      = isset($arr_seller_quest) ? $arr_seller_quest : [];
        $this->arr_view_data['page_title']        = "Manage " . str_plural($this->module_title);
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug');
        // dd($this->module_view_folder . '.index', $this->arr_view_data);
        return view($this->module_view_folder . '.index', $this->arr_view_data);
    }
    

    public function edit($enc_id)
    {
        $arr_data =[];
        $id = base64_decode($enc_id);

        $obj_user = $this->SellerQuestionsModel->where('id', $id)
            ->first();
        if ($obj_user) {
            $arr_data = $obj_user->toArray();
        }
        $this->arr_view_data['arr_data']          = isset($arr_data) ? $arr_data : [];
        $this->arr_view_data['page_title']        = "Manage " . str_plural($this->module_title);
        $this->arr_view_data['module_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug');
        // dd($this->module_view_folder . '.index', $this->arr_view_data);
        return view($this->module_view_folder . '.edit', $this->arr_view_data);
    }

    public function update(Request $request, $enc_id)
    {
        $user = Sentinel::check();

        $id = base64_decode($enc_id);

        $inputs = request()->validate([
            'question' => 'required'            
        ]);

        $arr_data      =   array(
            'question'            =>     $request->input('question')
            
        );

        $entity =     $this->SellerQuestionsModel->where('id', $id)->update($arr_data);

        if ($entity) {
            /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
            $arr_event                 = [];
            $arr_event['ACTION']       = 'EDIT';
            $arr_event['MODULE_TITLE'] = $this->module_title;

            $this->save_activity($arr_event);
            /*----------------------------------------------------------------------*/

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated dispensary question.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

            /*----------------------------------------------------------------------*/

             Flash::success('Dispensary questions updated successfully');
        } else {
            Flash::error('Problem occured, while updating ' . str_singular($this->module_title));
        }
        

        return redirect()->back();
    }

    
}
