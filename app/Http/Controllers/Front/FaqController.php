<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FaqModel;

use Validator;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class FaqController extends Controller
{
    	
    public function __construct(
                                FaqModel $FaqModel
                               )
    {
        $this->FaqModel  = $FaqModel;
        $this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }


    public function index(Request $request)
    {
        $arr_data = [];

        $obj_faq  = $this->FaqModel->where('is_active','1')->orderBy('id','desc')->get();
        if($obj_faq)
        {
            $arr_faq = $obj_faq->toArray();
        }

        $apppend_data = url()->current();

        if($request->has('page'))
        {   
            $pageStart = $request->input('page'); 
        }
        else
        {
            $pageStart = 1; 
        }
        
        $total_results = count($arr_faq);

   
        $paginator = $this->get_pagination_data($arr_faq, $pageStart, 10 , $apppend_data);


        if($paginator)
        {
            $pagination_links    =  $paginator;  
            $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 

        }   

 
        if($paginator)
        {
        
            $arr_user_pagination            =  $paginator;  
            $arr_product                    =  $paginator->items();
            $arr_data                       = $arr_product;
            $arr_view_data['arr_data']      = $arr_data;
            $arr_view_data['total_results'] = $total_results;
            $arr_pagination = $paginator;            
            $this->arr_view_data['faq_arr'] =  $arr_data;
            $this->arr_view_data['arr_pagination'] = $arr_pagination;
            $this->arr_view_data['total_results'] = $total_results;

            return view($this->module_view_folder.'.faq',$this->arr_view_data);
            
        }
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
