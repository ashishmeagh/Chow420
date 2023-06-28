<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\UserModel;
use App\Models\SellerModel;
use App\Models\ProductModel;


use Validator;
use DB;
class ShopSellerController extends Controller
{
    	
    public function __construct(
                                UserModel $UserModel,
                                SellerModel $SellerModel,
                                ProductModel $ProductModel
                               )
    {
        $this->UserModel            = $UserModel;
        $this->SellerModel          = $SellerModel;
        $this->ProductModel         = $ProductModel;
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
        $arr_sellers  = [];
        $obj_sellers  = $this->UserModel->where('is_active','1')->get();
        if($obj_sellers)
        {
            $arr_sellers = $obj_sellers->toArray();
        }

        $user_table        = $this->UserModel->getTable();
        $prefix_user_table = DB::getTablePrefix().$this->UserModel->getTable();

        $seller_table        = $this->SellerModel->getTable();
        $prefix_seller_table = DB::getTablePrefix().$this->SellerModel->getTable();

        $product_table        = $this->ProductModel->getTable();
        $prefix_product_table = DB::getTablePrefix().$this->ProductModel->getTable();


        $range_arr = range("A","Z");

        if(!empty($range_arr))
        {
            $sellerarr = []; 
           
            foreach($range_arr as $alphabets){
                
            

                $getsellers = DB::table($prefix_seller_table)
                                        ->where('business_name', 'LIKE', "{$alphabets}%")
                                        ->where('approve_status','1')
                                        ->get()->toArray();


                /* new code commented
                $getsellers = $this->UserModel
                         ->with('seller_detail','get_sellerbanner_detail','seller_detail.get_products','seller_detail.get_products.get_brand_detail','get_country_detail','get_state_detail')
                         ->whereHas('seller_detail',function($q) use ($alphabets)
                          {
                             $q->where('business_name', 'LIKE', "{$alphabets}%");
                             $q->where('approve_status','1');
                          })
                         ->whereHas('get_sellerbanner_detail',function($q)
                          {
                            // $q->where('image_name','!=','');
                            // $q->orWhere('image_medium','!=','');
                            // $q->orWhere('image_small','!=','');
                          })
                         ->whereHas('seller_detail.get_products',function($q)
                          {
                             $q->where('is_active',1);
                             $q->where('is_approve',1);
                          })

                          ->whereHas('seller_detail.get_products.get_brand_detail',function($q)
                          {
                             $q->where('is_active',1);
                             
                          })

                          ->whereHas('get_country_detail',function($q)
                          {
                             $q->where('is_active',1);
                             
                          })

                          ->whereHas('get_state_detail',function($q)
                          {
                             $q->where('is_active',1);
                             
                          })

                        ->where('is_active','1')
                        ->get()->toArray();    */                                                        

                if(!empty($getsellers))
                {
                    $namearr =[];
                    foreach($getsellers as $v){

                      // $first_name = isset($v['seller_detail']['business_name'])?$v['seller_detail']['business_name']:''; 
                       $first_name = $v->business_name; 

                       $namearr[] = array('name'=>$first_name);
                    }
                    $sellerarr[] = array('char' =>$alphabets,'name'=>$namearr); 

                }//if
             
           }//if 
        }//if
        

        // get featured seller

        /* $get_featuredseller = $this->UserModel
                         ->with('seller_detail','get_sellerbanner_detail','seller_detail.get_products','seller_detail.get_products.get_brand_detail','get_country_detail','get_state_detail')
                         ->whereHas('seller_detail',function($q)
                          {
                             $q->where('business_name','!=','');
                          })

                          ->whereHas('seller_detail.get_products',function($q1)
                          {
                             $q1->where('is_active',1);
                             $q1->where('is_approve',1);
                          })


                         ->whereHas('get_sellerbanner_detail',function($q)
                          {
                            // $q->where('image_name','!=','');
                            // $q->orWhere('image_medium','!=','');
                            // $q->orWhere('image_small','!=','');
                          })
                          ->whereHas('seller_detail.get_products.get_brand_detail',function($q)
                          {
                             $q->where('is_active',1);
                             
                          })

                          ->whereHas('get_country_detail',function($q)
                          {
                             $q->where('is_active',1);
                             
                          })

                          ->whereHas('get_state_detail',function($q)
                          {
                             $q->where('is_active',1);
                             
                          })
                        ->where('is_featured','1')
                        ->where('is_active','1')
                        ->get();*/

         $get_featuredseller = $this->UserModel
                         ->with('seller_detail','get_sellerbanner_detail')
                         ->whereHas('seller_detail',function($q)
                          {
                             $q->where('business_name','!=','');
                          })
                         ->whereHas('get_sellerbanner_detail',function($q)
                          {
                            // $q->where('image_name','!=','');
                            // $q->orWhere('image_medium','!=','');
                            // $q->orWhere('image_small','!=','');
                          })
                        ->where('is_featured','1')
                        ->where('is_active','1')
                        ->get();               


                        
        if(isset($get_featuredseller) && !empty($get_featuredseller))
        {
            $get_featuredseller = $get_featuredseller->toArray();
          
        }  

        $this->arr_view_data['arr_featuredseller'] = isset($get_featuredseller)?$get_featuredseller:[];

        $this->arr_view_data['sellerarr'] = isset($sellerarr)?$sellerarr:[];
        $this->arr_view_data['isMobileDevice'] = $this->isMobileDevice();

		return view($this->module_view_folder.'.shopseller',$this->arr_view_data);
	}//end of function index
 
}//end of class
