<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ContactEnquiryModel;
use App\Models\SiteSettingModel;
use App\Models\BrandModel;
use App\Models\ProductModel;
use App\Models\SellerModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\UserModel;
use App\Models\BannerImagesModel;



use Validator;
use DB;
class ShopBrandController extends Controller
{
    	
    public function __construct(
                                 BrandModel $BrandModel,
                                 ProductModel $ProductModel,
                                 SellerModel $SellerModel,
                                 StatesModel $StatesModel,
                                 CountriesModel $CountriesModel,
                                 UserModel $UserModel,
                                 BannerImagesModel $BannerImagesModel
                               )
    {
        $this->BrandModel           = $BrandModel;
        $this->ProductModel         = $ProductModel;
        $this->SellerModel          = $SellerModel;
        $this->CountriesModel       = $CountriesModel;
        $this->StatesModel          = $StatesModel;
        $this->UserModel            = $UserModel;
        $this->BannerImagesModel    = $BannerImagesModel;
    	  $this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }
  
    function isMobileDevice() {
        $is_mobile_device =  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        if($is_mobile_device)
        {   
            return 1;
        }else{
            return 0;
        }

    }
	public function index()
	{	
        $arr_brands  = [];
        $obj_brands  = $this->BrandModel->where('is_active','1')->get();
        if($obj_brands)
        {
            $arr_brands = $obj_brands->toArray();
        }

        $brand_table        = $this->BrandModel->getTable();
        $prefix_brand_table = DB::getTablePrefix().$this->BrandModel->getTable();


        $product_table        = $this->ProductModel->getTable();
        $prefix_product_table = DB::getTablePrefix().$this->ProductModel->getTable(); 

        $seller_table         = $this->SellerModel->getTable();
        $prefix_seller_table  = DB::getTablePrefix().$this->SellerModel->getTable(); 


        $countries_table        = $this->CountriesModel->getTable();
        $prefix_countries_table = DB::getTablePrefix().$this->CountriesModel->getTable(); 


        $state_table        = $this->StatesModel->getTable();
        $prefix_state_table = DB::getTablePrefix().$this->StatesModel->getTable();  

        $user_table        = $this->UserModel->getTable();   
        $prefix_user_table = DB::getTablePrefix().$this->UserModel->getTable(); 

      


        $range_arr = range("A","Z");


        if(!empty($range_arr))
        {
            $brandarr = []; 
           
            foreach($range_arr as $alphabets){
                
              //commented below code to show those brands who has products
              /* $getbrands = DB::table($prefix_brand_table)
                                       
                                      ->where('name', 'LIKE', "{$alphabets}%")
                                      ->where('is_active','1')
                                      ->get()
                                      ->toArray(); */



              /*get all brands which has products */
                
               $getbrands =  $this->BrandModel->with(['get_products',
                                            'get_products.get_seller_details.get_country_detail',
                                            'get_products.get_seller_details.get_state_detail',
                                            'get_products.get_seller_details'
                                      ])

                                    ->whereHas('get_products.get_seller_details.get_country_detail',function($q){
                                        $q->where('is_active','1');
                                    })
                                            
                                    ->whereHas('get_products.get_seller_details.get_state_detail', function ($q) {
                                        $q->where('is_active', '1');
                                    })

                                    ->whereHas('get_products.get_seller_details', function ($q) {
                                        $q->where('is_active', '1');
                                    })

                                    ->whereHas('get_products',function($q){

                                      $q->where('is_active',1);
                                      $q->where('is_approve',1);
                                    })
                                    
                                    ->where('is_active','1')
                                    ->where('name', 'LIKE', "{$alphabets}%")
                                    ->groupBy('id')
                                    ->get()->toArray();           
                      

                  if(!empty($getbrands))
                  {
                      $namearr =[];

                      foreach($getbrands as $v)
                      {
                        // $name = $v->name; //commented to show only those products who has brands
                         $name = $v['name']; 

                         $namearr[] = array('name'=>$name);
                      }

                      $brandarr[] = array('char' =>$alphabets,'name'=>$namearr); 

                  }
     
                //commented for showing only those records which has brand
                /* else{
                     $namearr =[];   
                     $brandarr[] = array('char' =>$alphabets,'name'=>$namearr); 
                 }   */
           }//foreach rangearr 
        }//if not empty range_arr
 

        /*select all featured Brands from brands table*/

        //get only those brand who has products

        $brands_arr = [];
        $cnt = 0;

       // commented new code
        $arr_featured_brands = $this->BrandModel
                                    ->with(['get_products',
                                            'get_products.get_seller_details.get_country_detail',
                                            'get_products.get_seller_details.get_state_detail',
                                            'get_products.get_seller_details'
                                      ])

                                    ->whereHas('get_products.get_seller_details.get_country_detail',function($q){
                                        $q->where('is_active','1');
                                    })
                                            
                                    ->whereHas('get_products.get_seller_details.get_state_detail', function ($q) {
                                        $q->where('is_active', '1');
                                    })

                                    ->whereHas('get_products.get_seller_details', function ($q) {
                                        $q->where('is_active', '1');
                                    })

                                    ->whereHas('get_products',function($q){
                                      $q->where('is_active',1);
                                      $q->where('is_approve',1);
                                    })
                                    ->where('is_active','1')
                                    ->where('is_featured','1')
                                    ->where('image','!=','')
                                    ->orderBy('id','desc')
                                    ->get()->toArray();

    
        if(isset($arr_featured_brands) && count($arr_featured_brands)>0)
        {
           foreach($arr_featured_brands as $key => $brand) 
           {  
              if(isset($brand['get_products']) && count($brand['get_products'])>0)
              {  $cnt = $cnt+1;
                  $brands_arr[$cnt]['id']          = $brand['id'];
                  $brands_arr[$cnt]['name']        = $brand['name'];
                  $brands_arr[$cnt]['image']       = $brand['image'];
                  $brands_arr[$cnt]['is_active']   = $brand['is_active'];
                  $brands_arr[$cnt]['is_featured'] = $brand['is_featured'];
              }
           }
        }
         $this->arr_view_data['arr_featured_brands'] = isset($brands_arr)?$brands_arr:[];


        //commented below code to show products who has brands
        /* $arr_featured_brands = $this->BrandModel
                                    ->where('is_active','1')
                                    ->where('is_featured','1')
                                    ->where('image','!=','')
                                    ->orderBy('id','desc')
                                    ->get()->toArray();

        $this->arr_view_data['arr_featured_brands'] = isset($arr_featured_brands)?$arr_featured_brands:[]; */



        $get_banner_images = $this->BannerImagesModel->first();
        if(isset($get_banner_images) && !empty($get_banner_images))
        {
          $get_banner_images = $get_banner_images->toArray();
        }
         $this->arr_view_data['banner_images_data']  = isset($get_banner_images)?$get_banner_images:[];
        
      

        $this->arr_view_data['brandarr'] = isset($brandarr)?$brandarr:[];
        $this->arr_view_data['arr_brands'] = isset($arr_brands)?$arr_brands:[];
        $this->arr_view_data['isMobileDevice'] = $this->isMobileDevice();

		return view($this->module_view_folder.'.shopbrand',$this->arr_view_data);
	}
    public function getbrandlistoldajax(Request $request)
    {
         $brand_table        = $this->BrandModel->getTable();
         $prefix_brand_table = DB::getTablePrefix().$this->BrandModel->getTable();
            $query = $request['query']; 

            if($query=="All"){
               
                $range = range('A', 'Z');
                   if(isset($range)){
                        $output =''; 
                        foreach($range as $alphabets){
                             $output .='<div class="brand-list show brandList" id="brands-'.$alphabets.'-page">';
                              $output .= ' <h2>'.$alphabets.'</h2>';
                             $output .= '<ul>';

                             

                              $data = DB::table($prefix_brand_table)
                                        ->where('name', 'LIKE', "{$alphabets}%")
                                        ->where('is_active','1')
                                        ->get()->toArray();
                             if(isset($data) && !empty($data)){                               
                                foreach($data as $row)
                                {       
                                     $url = url('search?brands='.base64_encode($row->name)); 
                                     $output .= ' 
                                      <li id='.$row->id.'>
                                      <a href="'.$url.'"> '.$row->name.'</a>
                                      </li>';
                                }
                            } 
                            else{
                                    $output .='<li><a href="javascript:void(0)">Not Availiable</a></li>';
                            }
                            $output .= '</ul>';
                            $output .= '<div class="clearfix"></div>';
                            $output .= '</div>';
                        }//foreach

                   }//if isset range

            }else{

                $data = DB::table($prefix_brand_table)
                        ->where('name', 'LIKE', "{$query}%")
                        ->where('is_active','1')
                        ->get()->toArray();
                 $output ='';     
                 $output .='<div class="brand-list show brandList" id="brands-'.$query.'-page">';
                  $output .= ' <h2>'.$query.'</h2>';
                 $output .= '<ul>';
                
                 if(isset($data) && !empty($data)){
                    foreach($data as $row)
                    {       
                         $url = url('search?brands='.base64_encode($row->name));  
                         $output .= '<li id='.$row->id.'>
                          <a href="'.$url.'"> '.$row->name.'</a>
                          </li>';
                    }
                } 
                else{
                  $output .='<li><a href="javascript:void(0)">Not Availiable</a></li>';
                }
                $output .= '</ul>';
                $output .= '<div class="clearfix"></div>';
                $output .= '</div>';

            }
            echo $output;
    }

     public function getbrandlist(Request $request)
    {
         $brand_table        = $this->BrandModel->getTable();
         $prefix_brand_table = DB::getTablePrefix().$this->BrandModel->getTable();
         $query = $request['query']; 
         if($query=="All"){

                  $range = range('A', 'Z');
                   if(isset($range)){
                        
                        foreach($range as $alphabets){
                                                        
                              $data = DB::table($prefix_brand_table)
                                        ->where('name', 'LIKE', "{$alphabets}%")
                                        ->where('is_active','1')
                                        ->get()->toArray();
                              $output ='';           
                             if(isset($data) && !empty($data)){                               
                                foreach($data as $row)
                                {       
                                    $url = url('search?brands='.base64_encode($row->name)); 
                                    $output .= ' 
                                      <li id='.$row->id.'>
                                      <a href="'.$url.'"> '.$row->name.'</a>
                                      </li>';

                                    $output .= '***'.$alphabets;  
                                }
                            } 
                            else{
                                   $output .='<li><a href="javascript:void(0)">Not Availiable</a></li>';
                            }
                           
                         echo $output;   

                        }//foreach

                   }//if isset range
         }
         else{

                   $output ='';
                   $data = DB::table($prefix_brand_table)
                        ->where('name', 'LIKE', "{$query}%")
                        ->where('is_active','1')
                        ->get()->toArray();


                   if(isset($data) && !empty($data)){
                    foreach($data as $row)
                    { 
                         $url = url('search?brands='.base64_encode($row->name));  
                         echo $output .= '<li id='.$row->id.'>
                          <a href="'.$url.'"> '.$row->name.'</a>
                          </li>';
                    }                    
                  }// if not empty data
                  else{
                     echo $output .= '<li id='.$row->id.'>
                          <a href="javascript:void(0)">Not Availiable</a>
                          </li>';
                  }
         }//else
    }
	
    public function view($enc_id)
    {
        $learmoreid = base64_decode($enc_id);
    }

}
