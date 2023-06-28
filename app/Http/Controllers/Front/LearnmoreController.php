<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ContactEnquiryModel;
use App\Models\SiteSettingModel;
use App\Models\ProductNewsModel;
use App\Common\Services\GeneralService;
use App\Models\BannerImagesModel;


use Validator;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class LearnmoreController extends Controller
{
    	
    public function __construct(
                                ProductNewsModel $ProductNewsModel,
                                GeneralService $GeneralService,
                                BannerImagesModel $BannerImagesModel
                               )
    {
        $this->ProductNewsModel  = $ProductNewsModel;
        $this->GeneralService    = $GeneralService;
        $this->BannerImagesModel = $BannerImagesModel;
        $this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }

	public function index_old(Request $request)
	{	
        $arr_news  = [];
        $apppend_data = url()->current();
        $obj_news  = $this->ProductNewsModel->where('is_active','1')->get();
        if($obj_news)
        {
            $arr_news = $obj_news->toArray();
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
        
        $total_results = count($arr_news);


       // $paginator = $this->GeneralService->get_pagination_data($order_arr, $pageStart, 9 , $apppend_data);
        $paginator = $this->GeneralService->get_pagination_data($arr_news, $pageStart, 2 , $apppend_data);


        if($paginator)
        {
            $pagination_links    =  $paginator;  
            $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 

        }   

        if($paginator)
        {
        
            $arr_user_pagination            =  $paginator;  
            $arr_product                    =  $paginator->items();
            $arr_data                       = $arr_news;
            $arr_view_data['arr_data']      = $arr_data;
            $arr_view_data['total_results'] = $total_results;
            $arr_pagination = $paginator;            
            $this->arr_view_data['news_arr'] =  $arr_data;
            $this->arr_view_data['arr_pagination'] = $arr_pagination;
            $this->arr_view_data['total_results'] = $total_results;
            return view($this->module_view_folder.'.learnmore',$this->arr_view_data);
            
        }
       
       // $this->arr_view_data['arr_news'] = isset($arr_news)?$arr_news:[];

		    return view($this->module_view_folder.'.learnmore',$this->arr_view_data);
	}
    


    public function index(Request $request)
    {
        $arr_data = [];

        $obj_news  = $this->ProductNewsModel->where('is_active','1')->orderBy('id','desc')->get();
        if($obj_news)
        {
            $arr_news = $obj_news->toArray();
        }

        if(isset($arr_news) && count($arr_news)>0){
            foreach ($arr_news as $key => $data) {
                $url = isset($data['video_url'])&&$data['video_url']!=""?$data['video_url']:false;

                if($url!=false){
                    $tmp_arr = explode("?v=", $url);
                    $url_id = isset($tmp_arr[1])?$tmp_arr[1]:'';

                    $arr_news[$key]['url_id'] = $url_id;
                }
            }
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
        
        $total_results = count($arr_news);


       // $paginator = $this->GeneralService->get_pagination_data($order_arr, $pageStart, 9 , $apppend_data);
        $paginator = $this->get_pagination_data($arr_news, $pageStart, 10 , $apppend_data);


        if($paginator)
        {
            $pagination_links    =  $paginator;  
            $arr_data            =  $paginator->items(); /* To Get Pagination Record */ 

        }   


        if(isset($arr_data) && count($arr_data)>0){
            foreach ($arr_data as $key => $data) {
                $url = isset($data['video_url'])&&$data['video_url']!=""?$data['video_url']:false;

                if($url!=false){
                    $tmp_arr = explode("?v=", $url);
                    $url_id = isset($tmp_arr[1])?$tmp_arr[1]:'';

                    $arr_data[$key]['url_id'] = $url_id;
                }
            }
        }

            

        $get_banner_images = $this->BannerImagesModel->first();
        if(isset($get_banner_images) && !empty($get_banner_images))
        {
          $get_banner_images = $get_banner_images->toArray();
        }
         $this->arr_view_data['banner_images_data']  = isset($get_banner_images)?$get_banner_images:[];





        if($paginator)
        {
        
            $arr_user_pagination            =  $paginator;  
            $arr_product                    =  $paginator->items();
            $arr_data                       = $arr_product;
            $arr_view_data['arr_data']      = $arr_data;
            $arr_view_data['total_results'] = $total_results;
            $arr_pagination = $paginator;            
            $this->arr_view_data['news_arr'] =  $arr_data;
            $this->arr_view_data['arr_pagination'] = $arr_pagination;
            $this->arr_view_data['total_results'] = $total_results;


            return view($this->module_view_folder.'.learnmore',$this->arr_view_data);
            
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
