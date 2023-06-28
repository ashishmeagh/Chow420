<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FaqCategoryModel;
use App\Models\FaqModel;


use Validator;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class FaqCategoryController extends Controller
{
    	
    public function __construct(
                                FaqCategoryModel $FaqCategoryModel,
                                FaqModel $FaqModel
                               )
    {
        $this->FaqCategoryModel     = $FaqCategoryModel;
        $this->FaqModel             = $FaqModel;
        $this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }


    public function index(Request $request)
    {
       $faq_category_arr = [];

       $faq_category_arr = $this->FaqCategoryModel
                                ->where('is_active',1)
                                ->with(['get_faq'=>function($q){
                                   return $q->where('is_active',1);
                                }])
                              
                                ->get()
                                ->toArray();

       
        $this->arr_view_data['faq_category_arr'] = $faq_category_arr;

        return view($this->module_view_folder.'.faq_category',$this->arr_view_data);
    }


    public function faq_details($faq_id)
    {
        $faq_arr = [];

        $faq_id = isset($faq_id)?base64_decode($faq_id):'';

        $faq_obj = $this->FaqModel
                        ->with(['get_faq_category'])
                        ->where('id',$faq_id)

                        ->first();

        if($faq_obj)
        {
            $faq_arr = $faq_obj->toArray();
        }

        $this->arr_view_data['faq_arr'] = $faq_arr;

        return view($this->module_view_folder.'.faq_details',$this->arr_view_data);
    }


    public function see_all($faq_category_id)
    {
        $faq_arr         = $category_arr = []; 
        $category_name   = '';

        $faq_category_id = isset($faq_category_id)?base64_decode($faq_category_id):'';


        $category_details = $this->FaqCategoryModel
                              ->where('id',$faq_category_id)
                              ->select('faq_category','id')
                              ->first();

        if(isset($category_details))
        {
            $category_arr = $category_details->toArray();
        }                      

        $faq_arr = $this->FaqModel
                        ->where('faq_category',$faq_category_id)
                        ->where('is_active',1)
                        ->get()
                        ->toArray();
        
        $this->arr_view_data['faq_arr']       = $faq_arr;
        $this->arr_view_data['category_name'] = $category_arr['faq_category'];
        $this->arr_view_data['category_id']   = $category_arr['id'];

        return view($this->module_view_folder.'.all_faq',$this->arr_view_data);
    }


    public function get_pagination_data($arr_data = [], $pageStart = 1, $per_page = 0, $apppend_data = [])
    {
        
        $perPage  = $per_page; /* Indicates how many to Record to paginate */
        $offSet   = ($pageStart * $perPage) - $perPage; /* Start displaying Records from this No.;*/        
        $count    = count($arr_data);
        /* Get only the Records you need using array_slice */
        $itemsForCurrentPage = array_slice($arr_data, $offSet, $perPage, true);

        /* Pagination to an Array() */
         $paginator =  new LengthAwarePaginator($itemsForCurrentPage, $count, $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));      
          

        $paginator->appends($apppend_data); /* Appends all input parameter to Links */
        
        return $paginator;
    }


}
