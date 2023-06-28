<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\FirstLevelCategoryModel;
use App\Models\OrderModel;

class DashboardController extends Controller
{
	public function __construct(UserModel $user,
								ProductModel $ProductModel,
                                OrderModel $OrderModel,
								FirstLevelCategoryModel $FirstLevelCategoryModel)
	{
		$this->arr_view_data      = [];
		$this->module_title       = "Dashboard";
		$this->UserModel          = $user;
		$this->ProductModel         = $ProductModel;
		$this->FirstLevelCategoryModel = $FirstLevelCategoryModel;
         $this->OrderModel          = $OrderModel;
		$this->module_view_folder = "admin.dashboard";
		$this->admin_url_path     = url(config('app.project.admin_panel_slug'));
	}
   
  public function index()
  {
	 	  //get trade statistics

    	//get total trades
    	//$total_trades = $this->ProductModel->count();
    	
    	//get total users and categories
    	$total_categories = $this->FirstLevelCategoryModel->count();
        
        // $total_users      = $this->UserModel->where('user_type','<>','admin')->where('id','<>',1)->where('is_active','1')->count();

        $total_buyer      = $this->UserModel
                                ->with('buyer_detail')
                                //->where([['is_active','1'],['user_type','buyer']])
                                ->where([['user_type','buyer']])
                                ->get()->toArray();
        
        
        $total_seller      = $this->UserModel
                                ->with('seller_detail')
                               // ->where([['is_active','1'],['user_type','seller']])
                                ->where([['user_type','seller']])
                                ->get()->toArray();

        $counts_arr = [
            'total_buyer'  => sizeof($total_buyer),
            'total_seller'   => sizeof($total_seller), 
            'all_categories'=> $total_categories
        ];
        
      /*************start***get total sold price of all orders******************/
      $total_soldprice = 0;
      $obj_totalsum_completedorder = $this->OrderModel->where([['order_status','1']])->sum('total_amount');

      if (isset($obj_totalsum_completedorder)) {

          $total_soldprice = $obj_totalsum_completedorder;
      }
      /***************end**get total sold price of all orders**************/


      /*******************get*total*goods*avaliable*cost***********/
        $get_allproducts =  $this->ProductModel->get();
         if(isset($get_allproducts) && !empty($get_allproducts))
         {
            $get_allproducts = $get_allproducts->toArray();
            $totalproductsum = 0; $totalcostofproduct=0;
            foreach($get_allproducts as $prod)
            { 
                $unitprice = $prod['unit_price'];
                $price_drop_to = $prod['price_drop_to'];

                if(isset($price_drop_to) && !empty($price_drop_to) && $price_drop_to!='0.000000')
                {
                  $totalcostofproduct = $prod['price_drop_to'];
                }
                else
                {
                  $totalcostofproduct =  $prod['unit_price'];
                }

               $totalproductsum = $totalproductsum+$totalcostofproduct;
            }//foreach

         }//if get all products

      /********end*get*total*goods*availiable*cost*************/






    	//get graph data
    	//get year starting date to current date month array
     //    $year_start_date = date('Y-m-d',strtotime(date('Y-01-01')));
     //    $current_date	   = date('Y-m-d');

     //    $time   = strtotime($year_start_date);
     //    $last   = date('m-Y', strtotime($current_date));                               

     //    do 
     //    {
     //          $month = date('m-Y', $time);
              
     //          $month_arr[] = [
     //                              'month_year_show' => date('M Y', $time),
     //                              'month_name'      => date('F', $time),
     //                              'total_days'      => date('t', $time),
     //                              'year'            => date('Y', $time),
     //                              'month'           => date('m', $time)
     //                          ];

     //          $time = strtotime('+1 month', $time);

     //    }while ($month != $last);
    		
    	// foreach($month_arr as $key=>$month)
     //  {
     //        //in future may be graph will average quantity wise so only need to replace count with avg(quantity)
     //        $buy_count = $this->ProductModel->where('trade_type','0')
     //                                    ->where('trade_status','4')                 
     //                                    ->whereYear('created_at',$month['year'])
     //                                    ->whereMonth('created_at',$month['month'])
     //                                    ->count();
     //                                    // ->avg('quantity');                

     //        $sell_count = $this->ProductModel->where('trade_type','1')
     //                                    ->whereYear('created_at',$month['year'])
     //                                    ->whereMonth('created_at',$month['month'])
     //                                    ->count();
     //                                    // ->avg('quantity');

     //        if($buy_count)
     //        {
     //            $graph_data[$key]['average_buy']   = number_format($buy_count,2);
     //        }
     //        else
     //        {
     //            $graph_data[$key]['average_buy']   = 0;
                
     //        }

     //        if($sell_count)
     //        {
     //            $graph_data[$key]['average_sell']  = number_format($sell_count,2);
     //        }
     //        else
     //        {
     //            $graph_data[$key]['average_sell']  = 0;
     //        }
            
     //        $graph_data[$key]['date']          = $month['month_year_show'];
     //        $graph_data[$key]['year']          = $month['year'];

     //  }

    	// $this->arr_view_data['graph_data']     = json_encode($graph_data);
    	$this->arr_view_data['counts_arr']     = $counts_arr;
    	$this->arr_view_data['page_title']     = $this->module_title;
    	$this->arr_view_data['admin_url_path'] = $this->admin_url_path;
        $this->arr_view_data['total_soldprice'] = isset($total_soldprice)? number_format($total_soldprice,2):'0';
        $this->arr_view_data['total_productsum'] = isset($totalproductsum)? number_format($totalproductsum,2):'0';
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
  }

  //   public function built_dashboard_tiles()
  //   {
  //   	/*------------------------------------------------------------------------------
  //   	| Note: Directly Use icon name - like, fa fa-user and use directly - 'user'
  //   	------------------------------------------------------------------------------*/
					
		// $arr_final_tile[] = ['module_slug'  => 'account_settings',
		// 					  'css_class'   => 'cogs',
		// 					  'module_title'=> 'Account Settings'];
		
		// $arr_final_tile[] = ['module_slug'  => 'admin_users',
		// 					  'css_class'   => 'user-secret',
		// 					  'module_title'=> 'Admin Users'];	

		// $arr_final_tile[] = ['module_slug'  => 'contact_enquiry',
		// 					  'css_class'   => 'info-circle',
		// 					  'module_title'=> 'Contact Enquirys'];	

		// $arr_final_tile[] = ['module_slug'  => 'static_pages',
		// 					  'css_class'   => 'sitemap',
		// 					  'module_title'=> 'CMS'];

		// $arr_final_tile[] = ['module_slug'  => 'email_template',
		// 					  'css_class'   => 'envelope',
		// 					  'module_title'=> 'Email Templates'];

		// $arr_final_tile[] = ['module_slug'  => 'faq',
		// 					  'css_class'   => 'question-circle',
		// 					  'module_title'=> 'FAQ'];

		// $arr_final_tile[] = ['module_slug'  => 'site_settings',
		// 					  'css_class'   => 'wrench',
		// 					  'module_title'=> 'Site Settings'];

		// $arr_final_tile[] = ['module_slug'  => 'users',
		// 					  'css_class'   => 'users',
		// 					  'module_title'=> 'Users'];


		// $arr_final_tile[] = ['module_slug'  => 'categories',
		// 					  'css_class'   => 'list-alt',
		// 					  'module_title'=> 'Categories'];

		// $arr_final_tile[] = ['module_slug'  => 'states',
		// 					  'css_class'   => 'location-arrow',
		// 					  'module_title'=> 'States'];

		// $arr_final_tile[] = ['module_slug'  => 'cities',
		// 					  'css_class'   => 'map-marker',
		// 					  'module_title'=> 'Cities'];

		// $arr_final_tile[] = ['module_slug'  => 'countries',
		// 					  'css_class'   => 'globe',
		// 					  'module_title'=> 'Countries'];

		// $arr_final_tile[] = ['module_slug'  => 'keyword_translation',
		// 					  'css_class'   => 'language',
		// 					  'module_title'=> 'Keyword Translation'];					  

		// return 	$arr_final_tile;						  
  //   }

    

}

