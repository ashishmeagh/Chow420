<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Common\Services\GeneralService;
use App\Models\SellerModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\ProductInventoryModel;
use App\Models\TransactionModel;
use App\Models\DisputeModel;
use App\Models\CountriesModel;
use App\Models\SiteSettingModel;
use App\Models\DropShipperModel;
use App\Models\EmailTemplateModel;
use App\Models\OrderAddressModel;
use App\Models\ProductModel;
use App\Models\BuyerRegisteredReferModel;
use App\Models\BuyerWalletModel;



use App\Common\Services\EmailService;
use App\Common\Services\OrderService;

use Sentinel;
use Datatables;
use DB;
use Flash;
use Session;
use Mail;
use PDF,Storage;
use Carbon\Carbon;
  
class OrderController extends Controller
{

    public function __construct(
                                
                                SellerModel $SellerModel,
                                GeneralService $GeneralService,
                                OrderModel $OrderModel,
                                OrderProductModel $OrderProductModel,
                                TransactionModel $TransactionModel,
                                ProductInventoryModel $ProductInventoryModel,
                                DisputeModel $DisputeModel,
                                EmailService $EmailService,
                                OrderService $OrderService,
                                UserModel $UserModel,
                                CountriesModel $CountriesModel,
                                SiteSettingModel $SiteSettingModel,
                                DropShipperModel $DropShipperModel,
                                EmailTemplateModel $EmailTemplateModel,
                                OrderAddressModel $OrderAddressModel,
                                ProductModel $ProductModel,
                                BuyerRegisteredReferModel $BuyerRegisteredReferModel,
                                BuyerWalletModel $BuyerWalletModel
                               )
    {
        $this->EmailService       = $EmailService;
        $this->SellerModel        = $SellerModel;
        $this->GeneralService     = $GeneralService;
        $this->TransactionModel    = $TransactionModel;
        $this->ProductInventoryModel = $ProductInventoryModel;
        $this->OrderModel          = $OrderModel;
        $this->OrderProductModel   = $OrderProductModel;
        $this->DisputeModel        = $DisputeModel; 
        $this->OrderService        = $OrderService; 
        $this->UserModel           = $UserModel;
        $this->CountriesModel      = $CountriesModel;
        $this->SiteSettingModel    = $SiteSettingModel;
        $this->DropShipperModel    = $DropShipperModel;
        $this->EmailTemplateModel  = $EmailTemplateModel;
        $this->OrderAddressModel   = $OrderAddressModel;
        $this->ProductModel        = $ProductModel;
        $this->BuyerRegisteredReferModel = $BuyerRegisteredReferModel;
        $this->BuyerWalletModel    = $BuyerWalletModel;

        $this->arr_view_data      = [];

        $this->module_title       = "Orders";
        $this->module_view_folder = "seller/order";
        $this->module_url_path    = url('/')."/seller/order";


    }


    public function index()
    {

        if(request()->segment(3)!="")
        {
            $order_type = request()->segment(3);
        }

            $this->arr_view_data['page_title']           = ucfirst($order_type).' Orders';
            $this->arr_view_data['order_type']           = $order_type;
            $this->arr_view_data['module_url_path']      = $this->module_url_path;
        
            return view($this->module_view_folder.'.index',$this->arr_view_data);
            
        
    }
 
    public function get_order_details(Request $request)
    {   
        $loggedInUserId = 0;
        $user = Sentinel::check();

        if($user)
        {
            $loggedInUserId = $user->id;
        }
       
       
        $transaction_table = $this->TransactionModel->getTable();
        $prefixed_transaction_tbl = DB::getTablePrefix().$transaction_table;

        $order_tbl_name              = $this->OrderModel->getTable();
        $prefixed_order_tbl          = DB::getTablePrefix().$this->OrderModel->getTable();

        $order_product_tbl_name      = $this->OrderProductModel->getTable();
        $prefixed_order_product_tbl  = DB::getTablePrefix().$this->OrderProductModel->getTable();

        $dispute_tbl_name      = $this->DisputeModel->getTable();
        $prefixed_dispute_tbl  = DB::getTablePrefix().$this->DisputeModel->getTable();

        $user_table            = $this->UserModel->getTable();
        $prefixed_user_table   = DB::getTablePrefix().$this->UserModel->getTable();

        $obj_qutoes = DB::table($order_tbl_name)
                             
                        ->select(DB::raw($order_tbl_name.".*,".
                                        $prefixed_dispute_tbl.'.dispute_reason,'
                                        .$prefixed_dispute_tbl.'.dispute_status,'
                                        .$prefixed_dispute_tbl.'.is_dispute_finalized,'
                                        .$prefixed_transaction_tbl.".transaction_status,"
                                        ."CONCAT(".$prefixed_user_table.".first_name,' ',".$prefixed_user_table.".last_name) as buyername"
                                       ))
                        
                        ->leftjoin($prefixed_user_table,$prefixed_user_table.'.id','=',$order_tbl_name.'.buyer_id')

                        //->leftjoin($prefixed_order_product_tbl,$prefixed_order_product_tbl.'.order_id','=',$prefixed_order_tbl.'.id')
                        ->leftjoin($prefixed_transaction_tbl,$prefixed_transaction_tbl.'.order_no','=',$order_tbl_name.'.order_no')
                        ->leftjoin($prefixed_dispute_tbl,$prefixed_dispute_tbl.'.order_id','=',$order_tbl_name.'.id');


                       // ->where($order_tbl_name.'.seller_id',$loggedInUserId); //commented this condition

                         /* ---------------- Filtering Logic --------------*/                    
                        $arr_search_column = $request->input('column_filter');
                              
                         //commented order no on 6-june-20     
                       /* if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
                        {
                            $search_termno      = $arr_search_column['q_order_no'];
                            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.order_no','LIKE', '%'.$search_termno.'%');
                        }*/

                        if(isset($arr_search_column['q_transaction_id']) && $arr_search_column['q_transaction_id']!="")
                        {
                            $search_trans_term      = $arr_search_column['q_transaction_id'];
                            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.transaction_id','LIKE', '%'.$search_trans_term.'%');
                        }
                       
                        if(isset($arr_search_column['q_price']) && $arr_search_column['q_price']!="")
                        {
                            $search_term_price      = $arr_search_column['q_price'];
                            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.total_amount','LIKE', '%'.$search_term_price.'%');
                        }

                        //commented pay status on 6-june-20    
                       /* if(isset($arr_search_column['q_payment_status']) && $arr_search_column['q_payment_status']!="")
                        {
                            
                              $search_term = intval($arr_search_column['q_payment_status']);
                              $obj_qutoes = $obj_qutoes->where($prefixed_transaction_tbl.'.transaction_status', $search_term);
                            
                        }*/

                        if(isset($arr_search_column['q_order_status']) && $arr_search_column['q_order_status']!="")
                        {
                            
                              $search_term_ostatus = intval($arr_search_column['q_order_status']);
                              $obj_qutoes = $obj_qutoes->where($prefixed_transaction_tbl.'.order_status', $search_term_ostatus);
                            
                        }

                        /* if(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name']!="")
                        {
                            $search_buyername      = $arr_search_column['q_buyer_name'];
                          
                            $obj_qutoes = $obj_qutoes->where('first_name','LIKE', '%'.$search_buyername.'%')->orWhere('last_name','LIKE','%'.$search_buyername.'%');

                        }*/

                        /* if(isset($arr_search_column['q_orderdate']) && $arr_search_column['q_orderdate']!="")
                         {

                                $search_orderdate = $arr_search_column['q_orderdate'];
                                $search_orderdate = date('Y-m-d',strtotime($search_orderdate));
                              
                                 $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.created_at','LIKE', '%'.$search_orderdate.'%');
                          }  */


                        if (request()->segment(3)!="" && request()->segment(3) == 'delivered') 
                        {
                           // dd('123');
                             if(isset($arr_search_column['q_from']) && $arr_search_column['q_from']!="" && isset($arr_search_column['q_to']) && $arr_search_column['q_to']!="")
                            {
                                $search_from      = $arr_search_column['q_from'];
                                $search_from      = date('Y-m-d',strtotime($search_from));

                                $search_to      = $arr_search_column['q_to'];
                                $search_to      = date('Y-m-d',strtotime($search_to));

                                $search_from = $search_from.' 00:00:00';
                                $search_to   = $search_to.' 23:59:59';

                                $obj_qutoes = $obj_qutoes->whereBetween($order_tbl_name.'.created_at',[ $search_from,$search_to ]);
                                $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','1'],[$order_tbl_name.'.seller_id',$loggedInUserId]]);

                            }//if from and to  
                       }//if delivered

                       /**************14july20**for*search*export*records************/

                        /* if (request()->segment(3)!="" && request()->segment(3) == 'ongoing') 
                         {

                             if(isset($arr_search_column['q_from']) && $arr_search_column['q_from']!="" && isset($arr_search_column['q_to']) && $arr_search_column['q_to']!="")
                            {
                                $search_from      = $arr_search_column['q_from'];
                                $search_from      = date('Y-m-d',strtotime($search_from));

                                $search_to      = $arr_search_column['q_to'];
                                $search_to      = date('Y-m-d',strtotime($search_to));

                                $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','2'],[$order_tbl_name.'.seller_id',$loggedInUserId]])->whereBetween($order_tbl_name.'.created_at',[ $search_from,$search_to ]);

                                $obj_qutoes = $obj_qutoes->orwhere([[$order_tbl_name.'.order_status','3'],[$order_tbl_name.'.seller_id',$loggedInUserId]])->whereBetween($order_tbl_name.'.created_at',[ $search_from,$search_to ]);


                            }//if from and to  
                         }//if ongoing*/

                         if (request()->segment(3)!="" && request()->segment(3) == 'cancelled') 
                        {

                             if(isset($arr_search_column['q_from']) && $arr_search_column['q_from']!="" && isset($arr_search_column['q_to']) && $arr_search_column['q_to']!="")
                            {
                                $search_from      = $arr_search_column['q_from'];
                                $search_from      = date('Y-m-d',strtotime($search_from));

                                $search_to      = $arr_search_column['q_to'];
                                $search_to      = date('Y-m-d',strtotime($search_to));

                                 $search_from = $search_from.' 00:00:00';
                                 $search_to   = $search_to.' 23:59:59';

                                $obj_qutoes = $obj_qutoes->whereBetween($order_tbl_name.'.created_at',[ $search_from,$search_to ]);
                                $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','0'],[$order_tbl_name.'.seller_id',$loggedInUserId]]);

                            }//if from and to  
                       }//if cancelled



                       /***************14july20**for*search*export*records***********/


                        if (request()->segment(3)!="" && request()->segment(3) == 'ongoing') 
                        {
                            $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.buyer_age_restrictionflag',0);

                              // $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.order_status','2')
                            //                          ->orwhere($order_tbl_name.'.order_status','3');

                            /******************************************************/
                                //commneted below condtion at 6-june-20

                            /* $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.seller_id',$loggedInUserId],
                                [$order_tbl_name.'.order_status','2']]); // ongoing

                             $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                [$order_tbl_name.'.order_status','3']]); // shipped

                             $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                [$order_tbl_name.'.order_status','4']]); // dispatched
                                */


                             /******************************************************/

                             //new conditon for datepicker seach at 6june20
                               if(isset($arr_search_column['q_orderdate']) && $arr_search_column['q_orderdate']!="")
                               {

                                $search_orderdate = $arr_search_column['q_orderdate'];
                                $search_orderdate = date('Y-m-d',strtotime($search_orderdate));
                              
                              
                                  $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','2'],[$order_tbl_name.'.created_at','LIKE', '%'.$search_orderdate.'%']]); // ongoing

                                  $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','3'],[$order_tbl_name.'.created_at','LIKE', '%'.$search_orderdate.'%']]); // shipped

                                  $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','4'],[$order_tbl_name.'.created_at','LIKE', '%'.$search_orderdate.'%']]); // dispatched    

                                }       
                               else if(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
                                {
                                    $search_termno      = $arr_search_column['q_order_no'];
                                  //  $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.order_no','LIKE', '%'.$search_termno.'%');



                                  $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','2'],[$order_tbl_name.'.order_no','LIKE', '%'.$search_termno.'%']]); // ongoing

                                  $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','3'],[$order_tbl_name.'.order_no','LIKE', '%'.$search_termno.'%']]); // shipped

                                  $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','4'],[$order_tbl_name.'.order_no','LIKE', '%'.$search_termno.'%']]); // dispatched    



                                }
                                else if(isset($arr_search_column['q_payment_status']) && $arr_search_column['q_payment_status']!="")
                                {
                                    
                                      $search_term = intval($arr_search_column['q_payment_status']);
                                    //  $obj_qutoes = $obj_qutoes->where($prefixed_transaction_tbl.'.transaction_status', $search_term);

                                      $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','2'],[$prefixed_transaction_tbl.'.transaction_status', $search_term]]); // ongoing

                                   $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','3'],[$prefixed_transaction_tbl.'.transaction_status', $search_term]]); // shipped

                                   $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','4'],[$prefixed_transaction_tbl.'.transaction_status', $search_term]]); // dispatched    


                                    
                                }
                                 elseif(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name']!="")
                                {
                                  $search_buyername  = $arr_search_column['q_buyer_name'];                                
                                   $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','2'],[$order_tbl_name.'.seller_id',$loggedInUserId],['first_name','LIKE', '%'.$search_buyername.'%']]);

                                    $obj_qutoes = $obj_qutoes->orwhere([[$order_tbl_name.'.order_status','3'],[$order_tbl_name.'.seller_id',$loggedInUserId],['last_name','LIKE', '%'.$search_buyername.'%']]);
                                }

                                /**************15july20******************************/  
                                  elseif(isset($arr_search_column['q_from']) && $arr_search_column['q_from']!="" && isset($arr_search_column['q_to']) && $arr_search_column['q_to']!="")
                                {
                                    $search_from      = $arr_search_column['q_from'];
                                    $search_from      = date('Y-m-d',strtotime($search_from));

                                    $search_to      = $arr_search_column['q_to'];
                                    $search_to      = date('Y-m-d',strtotime($search_to));

                                     $search_from = $search_from.' 00:00:00';
                                     $search_to   = $search_to.' 23:59:59';

                                    $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','2'],[$order_tbl_name.'.seller_id',$loggedInUserId]])->whereBetween($order_tbl_name.'.created_at',[ $search_from,$search_to ]);

                                    $obj_qutoes = $obj_qutoes->orwhere([[$order_tbl_name.'.order_status','3'],[$order_tbl_name.'.seller_id',$loggedInUserId]])->whereBetween($order_tbl_name.'.created_at',[ $search_from,$search_to ]);


                                }//if from and to filter 
                                /************************************************/
                                else
                                {
                                   $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','2']]); // ongoing

                                   $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','3']]); // shipped

                                   $obj_qutoes = $obj_qutoes->orwhere([ [$order_tbl_name.'.seller_id',$loggedInUserId],
                                    [$order_tbl_name.'.order_status','4']]); // dispatched    
                                } 
                                /**************end new conditon at 6-june-20*****/

                        } //if ongoing
                        elseif (request()->segment(3)!="" && request()->segment(3) == 'delivered') {

                           $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.buyer_age_restrictionflag',0);


                             //Added below condition for search work at 6june20
                             if(isset($arr_search_column['q_orderdate']) && $arr_search_column['q_orderdate']!="")
                             {

                                    $search_orderdate = $arr_search_column['q_orderdate'];
                                    $search_orderdate = date('Y-m-d',strtotime($search_orderdate));
                                  
                                  $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.created_at','LIKE', '%'.$search_orderdate.'%')
                                     ->where([[$order_tbl_name.'.order_status','1'],[$order_tbl_name.'.seller_id',$loggedInUserId]])
                                       ;
                              }
                              elseif(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
                              {
                                  $search_termno      = $arr_search_column['q_order_no'];
                                
                                     $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','1'],[$order_tbl_name.'.seller_id',$loggedInUserId],[$order_tbl_name.'.order_no','LIKE', '%'.$search_termno.'%']]);

                              }
                              elseif(isset($arr_search_column['q_payment_status']) && $arr_search_column['q_payment_status']!="")
                             {
                                    
                                $search_term = intval($arr_search_column['q_payment_status']);

                                 $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','1'],[$order_tbl_name.'.seller_id',$loggedInUserId],[$prefixed_transaction_tbl.'.transaction_status', $search_term]]);

                             }
                              elseif(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name']!="")
                              {
                                  $search_buyername      = $arr_search_column['q_buyer_name'];                                
                                   $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','1'],[$order_tbl_name.'.seller_id',$loggedInUserId],['first_name','LIKE', '%'.$search_buyername.'%']]);

                                   $obj_qutoes = $obj_qutoes->orwhere([[$order_tbl_name.'.order_status','1'],[$order_tbl_name.'.seller_id',$loggedInUserId],['last_name','LIKE', '%'.$search_buyername.'%']]);

                              }
                             else
                             {
                                 $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','1'],[$order_tbl_name.'.seller_id',$loggedInUserId]]);
                              }  

                              //commented below condition for search work at 6june20
                           /* $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','1'],[$order_tbl_name.'.seller_id',$loggedInUserId]]);*/

                        }  // else if delivered
                        elseif (request()->segment(3)!="" && request()->segment(3) == 'cancelled') {

                           

                             //Added condtion for search work at 6june20
                            if(isset($arr_search_column['q_orderdate']) && $arr_search_column['q_orderdate']!="")
                             {

                                    $search_orderdate = $arr_search_column['q_orderdate'];
                                    $search_orderdate = date('Y-m-d',strtotime($search_orderdate));
                                  
                                     $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.created_at','LIKE', '%'.$search_orderdate.'%')
                                         ->where([[$order_tbl_name.'.order_status','0'],[$order_tbl_name.'.seller_id',$loggedInUserId]]);
                              }
                               elseif(isset($arr_search_column['q_order_no']) && $arr_search_column['q_order_no']!="")
                              {
                                  $search_termno      = $arr_search_column['q_order_no'];
                                   $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','0'],[$order_tbl_name.'.seller_id',$loggedInUserId],[$order_tbl_name.'.order_no','LIKE', '%'.$search_termno.'%']]);
                               }
                              elseif(isset($arr_search_column['q_payment_status']) && $arr_search_column['q_payment_status']!="")
                               {
                                    
                                $search_term = intval($arr_search_column['q_payment_status']);

                                  $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','0'],[$order_tbl_name.'.seller_id',$loggedInUserId],[$prefixed_transaction_tbl.'.transaction_status', $search_term]]);

                              }
                              elseif(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name']!="")
                              {
                                  $search_buyername      = $arr_search_column['q_buyer_name'];
                                
                                  //$obj_qutoes = $obj_qutoes
                                      //->where('first_name','LIKE', '%'.$search_buyername.'%')
                                     //->orWhere('last_name','LIKE','%'.$search_buyername.'%')
                                  $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','0'],[$order_tbl_name.'.seller_id',$loggedInUserId],['first_name','LIKE', '%'.$search_buyername.'%']]);

                                  $obj_qutoes = $obj_qutoes->orwhere([[$order_tbl_name.'.order_status','0'],[$order_tbl_name.'.seller_id',$loggedInUserId],['last_name','LIKE', '%'.$search_buyername.'%']]);

                              }
                              else
                              {
                                 $obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','0'],[$order_tbl_name.'.seller_id',$loggedInUserId]]);
                              }

                              //Commented below condition for serach datapicker work at 6june20

                              /*$obj_qutoes = $obj_qutoes->where([[$order_tbl_name.'.order_status','0'],[$order_tbl_name.'.seller_id',$loggedInUserId]]);*/


                        } //else if cancelled
                        

                       $obj_qutoes = $obj_qutoes->orderBy($order_tbl_name.".id",'DESC');
        
        

                   /* if(isset($arr_search_column['q_order_date']) && $arr_search_column['q_order_date']!="")
                    {
                        $search_term      = $arr_search_column['q_order_date'];
                        
                        $search_term  = date('Y-m-d',strtotime($search_term));

                        $obj_qutoes = $obj_qutoes->where($order_tbl_name.'.DATE(`created_at`)','LIKE', '%'.$search_term.'%');
                    }  */

       

        $current_context = $this;

        $json_result  = Datatables::of($obj_qutoes);
        
        $json_result  = $json_result->editColumn('created_at',function($data) use ($current_context)
                        {
                            return us_date_format($data->created_at);


                        })
                        ->editColumn('transaction_status',function($data) use ($current_context)
                        {

                            if ($data->transaction_status == 0) {
                                return 'Pending';
                            }
                            elseif ($data->transaction_status == 1) {
                                return 'Paid';
                            }
                            else{
                                return 'Failed';
                            }
 

                        })
                         ->editColumn('total_amount',function($data) use ($current_context)
                        {

                          $final_amount = $data->total_amount;

                           if($final_amount > 0)
                            {

                                if(isset($data->couponid) && isset($data->couponcode) && $data->couponcode!='' && isset($data->discount) && $data->discount!='' 
                                    && isset($data->seller_discount_amt) 
                                    && $data->seller_discount_amt!='')
                                {
                                    $final_amount =  (float)$final_amount - (float)$data->seller_discount_amt; 
                                }

                                if (isset($data->delivery_option_id) && $data->delivery_option_id != '' ) {

                                  $final_amount = (float)$final_amount +  (float)$data->delivery_cost;
                                }

                                 if (isset($data->tax) && $data->tax != '' ) {

                                  $final_amount = (float)$final_amount +  (float)$data->tax;
                                }

                                return $final_amount; 
                               
                            }else{
                               return "-"; 
                            }
 

                        })
                        ->editColumn('order_status',function($data) use ($current_context)
                        {

                            if ($data->order_status == 2) {
                                return 'Ongoing';
                            }
                            elseif ($data->order_status == 3) {
                                return 'Shipped';
                            }
                             elseif ($data->order_status == 4) {
                                return 'Ongoing';
                            }
                            elseif ($data->order_status == 1) {
                                return 'Delivered';
                            }else{
                                return 'Cancelled';
                            }

                        }) 
                        ->editColumn('order_no',function($data) use ($current_context)
                        {
                            $orderno_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                            $build_orderno_action = '<a target="_blank" href="'.$orderno_href.'" title="View Order Details">
                            '.$data->order_no.'</a>';
                            return $build_orderno_action;
                          
                        })
                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                            $tracking_no           = isset($data->tracking_no)?$data->tracking_no:'';
                            $shipping_company_name = isset($data->shipping_company_name)?$data->shipping_company_name:'';
                            $enc_id = isset($data->id)?base64_encode($data->id):'';


                            if($data->order_status==3) // if status is shipped
                            { 
                                $build_completeorder_action='';
                                    $complete_href =  $this->module_url_path.'/delivered/'.base64_encode($data->id);

                                    /**********commented delivered button***************/
                                   /* $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="deliver-order" data-href="' . $complete_href . '" data-id="deliver" onclick="confirm_order_status($(this))" data-tracking_no="'.$tracking_no.'" data-shipping_company_name="'.$shipping_company_name.'" data-enc_id="'.$enc_id.'">Delivered</a>';  */ 


                             }

                            /*  elseif($data->order_status==2) // ongoing
                            { 
                                $shipped_href =  $this->module_url_path.'/shipped/'.base64_encode($data->id);

                                $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="'. $shipped_href.'" data-id="ship" onclick="confirm_order_status($(this))">Ship Order</a>';   
                            }*/


                            elseif($data->order_status==2) // if status is ongoing
                            { 
                                // $dispatched_href =  $this->module_url_path.'/dispatched/'.base64_encode($data->id);

                                // $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="dispatched-order" data-href="'. $dispatched_href.'" data-id="dispatched" onclick="confirm_order_status($(this))" data-tracking_no="'.$tracking_no.'" data-shipping_company_name="'.$shipping_company_name.'" data-enc_id="'.$enc_id.'">Dispatch Order</a>';

                                $shipped_href =  $this->module_url_path.'/shipped/'.base64_encode($data->id);

                                // $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="'. $shipped_href.'" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="'.$tracking_no.'" data-shipping_company_name="'.$shipping_company_name.'" data-enc_id="'.$enc_id.'">Mark as Shipped</a>';   

                                //Added conditions for payment gateways
                                if(isset($data->payment_gateway_used) && $data->payment_gateway_used=="authorizenet" && isset($data->authorize_transaction_status) && $data->authorize_transaction_status=="settledSuccessfully")
                                {
                                   $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="'. $shipped_href.'" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="'.$tracking_no.'" data-shipping_company_name="'.$shipping_company_name.'" data-enc_id="'.$enc_id.'">Mark as Shipped</a>';     
                                }elseif(isset($data->payment_gateway_used) && $data->payment_gateway_used=="square")
                                {
                                    $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="'. $shipped_href.'" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="'.$tracking_no.'" data-shipping_company_name="'.$shipping_company_name.'" data-enc_id="'.$enc_id.'">Mark as Shipped</a>';     
                                }
                                else
                                {   
                                     $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" data-id="ship" title="Payment for this order is still being processed. You will receive a notification as soon as the payment is settled" onclick="payment_pending_status()">Payment pending</a>';     
                                }

                                




                            }
                            elseif($data->order_status==4) // if status is dispatched
                            {

                                $shipped_href =  $this->module_url_path.'/shipped/'.base64_encode($data->id);

                                $build_completeorder_action = '<a href="javascript:void(0)" class="btn btn-info" id="ship-order" data-href="'. $shipped_href.'" data-id="ship" onclick="confirm_order_status($(this))" data-tracking_no="'.$tracking_no.'" data-shipping_company_name="'.$shipping_company_name.'" data-enc_id="'.$enc_id.'">Shipped</a>';  

                            }

                            else
                            {
                                $build_completeorder_action='';
                            }  
                            
                            $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                            $build_view_action = '<a href="'.$view_href.'" class="eye-actn" title="View Order Details">
                            View</a>';

                            if ($data->note == "") {

                             $build_note_btn = '<a href="javascript:void(0)" title="View Order Note" class="eye-actn" id="ship-order"  data-id="ship" onclick="add_note_model($(this))"   data-order_id="'.base64_encode($data->id).'"  data-order_note="'.$data->note.'" data-buyers_id="'.base64_encode($data->buyer_id).'" >Add Order Note</a>'; 
                            }
                            else {

                              $build_note_btn = '<a href="javascript:void(0)" title="View Order Note" class="eye-actn" id="ship-order"  data-id="ship" onclick="add_note_model($(this))"   data-order_id="'.base64_encode($data->id).'"  data-order_note="'.$data->note.'" data-buyers_id="'.base64_encode($data->buyer_id).'" >View Order Note</a>';

                            }

                            $build_dispute_action='';
                            if(($data->order_status=='1' || $data->order_status=='3') && $data->dispute_status=='1' && $data->dispute_reason!="" && $data->is_dispute_finalized=='0'){ 
                               $url_dispute = url('/').'/seller/dispute/'.base64_encode($data->id);
                               $build_dispute_action = '<a href="'.$url_dispute.'" class="btns-approved">Dispute Raised</a>';
                            }
                            elseif(($data->order_status=='1' || $data->order_status=='3') && $data->dispute_status=='1' && $data->dispute_reason!="" && $data->is_dispute_finalized=='1'){ 
                               $url_dispute = url('/').'/seller/dispute/'.base64_encode($data->id);
                               $build_dispute_action = '<a href="'.$url_dispute.'" class="btns-approved">Dispute Closed</a>';
                            }

                           /*
                             $build_action = $build_completeorder_action.' '.$build_view_action.' '.$build_dispute_action ;

                            if ((request()->segment(3)!="" && request()->segment(3) == 'delivered')) {
                              $build_action = $build_action.' '.$build_note_btn; 
                            }*/

                            $build_action = $build_completeorder_action.' '.$build_view_action.' '.$build_dispute_action.' '.$build_note_btn ;

                            return $build_action;
                        })
                       /* ->editColumn('notes',function($data) use ($current_context)
                        {

                             $build_note_btn = '<a href="javascript:void(0)" class="btn btn-info" id="ship-order"  data-id="ship" onclick="add_note_model($(this))"   data-order_id="'.base64_encode($data->id).'"  data-order_note="'.$data->note.'"   >Order note</a>';  

                            return $build_note_btn;
                          
                        })*/;
        $build_result = $json_result->make(true)->getData();

        return response()->json($build_result);
    }

    public function view($enc_id="")
    { 
        
        if(request()->segment(3)!="")
        {
            $order_type = request()->segment(3);
        }
        
        $product_status = '';
        $product_arr = $tracking_info = $lable_info = [];
        $order_id = base64_decode($enc_id);
        if ($order_id) {

            $obj_order_details = $this->OrderModel
                            ->with(['order_product_details.product_details.product_images_details','buyer_details','address_details.state_details','address_details.country_details','address_details.billing_state_details','address_details.billing_country_details','transaction_details','seller_details',
                              'order_product_details.age_restriction_detail'
                              ])
                            ->where('id',$order_id)
                            ->first();
        }

        if($obj_order_details)
        {
            $product_arr = $obj_order_details->toArray();

            if ($product_arr['order_status'] == 2) {
                $product_status = 'ongoing';
            }
            elseif ($product_arr['order_status'] == 3) {
                $product_status = 'ongoing';
            }
            elseif ($product_arr['order_status'] == 1) {
                $product_status = 'delivered';
            }else{
                $product_status = 'cancelled';
            }

        }

        if($product_arr['tracking_no']!=null && $product_arr['shipping_company_name']!="" && ($product_arr['order_status']== 3 || $product_arr['order_status'] == 1))
        {
           $tracking_info = $this->track_order($product_arr['tracking_no'],$product_arr['shipping_company_name']);
                          
            //dd($tracking_info);        
          // $view_tracking = $this->branding_page($tracking_info,$product_arr);

             if($product_arr['order_status'] == 1 && isset($tracking_info) && !empty($tracking_info) && isset($tracking_info['status_code']) && $tracking_info['status_code']=="DE" && isset($tracking_info['status_description']) && $tracking_info['status_description']=="Delivered")
            {
               $lable_info   =  $this->generate_lable($product_arr);
            }  


        }//if order status is shipped or delivered  and no and company also there 


      


        $this->arr_view_data['product_arr']          = $product_arr;
        $this->arr_view_data['tracking_info']        = $tracking_info;
        $this->arr_view_data['lable_info']           = $lable_info;
        $this->arr_view_data['page_title']           = 'Order Details';
        $this->arr_view_data['order_type']           = $order_type;
        $this->arr_view_data['product_status']       = $product_status;
        // dd($this->arr_view_data);
        return view($this->module_view_folder.'.view',$this->arr_view_data);

    }

    public function shipped($enc_id="")
    {
       $order_id = base64_decode($enc_id);

        if($order_id)
        {
           $res_order = $this->OrderModel
                             ->with('buyer_details','seller_details','seller_details.seller_detail')
                             ->select('*')
                             ->where('id',$order_id)
                             ->get()->toArray();



           if(!empty($res_order) && count($res_order)>0)
           {
                $from_user_id = 0;
                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id; 
                }

                $update = $this->OrderModel
                             ->where('id',$order_id)
                             ->where('seller_id',$user_details->id)
                             ->update(['order_status'=>'3']);



                  $site_setting_arr = [];

                  $site_setting_obj = SiteSettingModel::first();  

                  if(isset($site_setting_obj))
                  {
                    $site_setting_arr = $site_setting_obj->toArray();            
                  }


                 if(isset($site_setting_arr) && count($site_setting_arr)>0)
                 {
                   $buyer_referal_amount = isset($site_setting_arr['buyer_referal_amount'])?$site_setting_arr['buyer_referal_amount']:config('app.project.buyer_referal');

                 } // if site_setting_arr        



                if($update)
                {

                    // check if users order is refered buyer order then at the time of shipping update amount column to $15 and make entry in the buyer wallet

                    if(isset($res_order[0]['buyer_details']['is_refered_buyer']) && $res_order[0]['buyer_details']['is_refered_buyer']==1 && isset($res_order[0]['buyer_details']['is_refered_buyer_order_placed']) && $res_order[0]['buyer_details']['is_refered_buyer_order_placed']==1)
                    {

                         $get_whom_referedid = $this->BuyerRegisteredReferModel->where('referal_id',$res_order[0]['buyer_details']['id'])->first();

                           if(isset($get_whom_referedid))
                           {
                              $get_whom_referedid = $get_whom_referedid->toArray();
                              if($get_whom_referedid['is_shipped']==1 && $get_whom_referedid['amount']!='')
                              {

                              }
                              else
                              {
                                  $arr_buyer_refered = [];
                                  $arr_buyer_refered['amount'] = $buyer_referal_amount;
                                  $arr_buyer_refered['is_shipped'] = 1;
                                  $this->BuyerRegisteredReferModel->where('referal_id',$res_order[0]['buyer_details']['id'])->update($arr_buyer_refered);

                                  //make entry in buyer wallet section for reffered user
                                  $buyer_regisered_pk = $get_whom_referedid['id'];
                                  $who_refer = $get_whom_referedid['user_id'];
                                  $referal_amount = $get_whom_referedid['amount'];
                                 

                                  // $buyer_wallet_arr = [];
                                  // $buyer_wallet_arr['user_id'] = $who_refer;
                                  // $buyer_wallet_arr['type'] = 'Referal';
                                  // $buyer_wallet_arr['amount'] = '+'.$buyer_referal_amount;
                                  // $buyer_wallet_arr['typeid'] = $buyer_regisered_pk;
                                  // $this->BuyerWalletModel->create($buyer_wallet_arr);

                                  $update_wallet_shippedarr = [];
                                  $update_wallet_shippedarr['status'] = 1; 
                                  $this->BuyerWalletModel
                                        ->where('user_id',$who_refer)
                                        ->where('typeid',$buyer_regisered_pk)
                                        ->update($update_wallet_shippedarr);


                                   /******* Notification START* For Buyer  wallet credited******/
                                    $buyer_wallet_url     = url('/').'/buyer/wallet/';

                                    $admin_id     = 0;
                                    $user_name    = "";

                                
                                    if(isset($res_order[0]['seller_details']['seller_detail']['business_name']))
                                    {
                                      $user_name  = $res_order[0]['seller_details']['seller_detail']['business_name'];
                                    }else{
                                      $user_name   = $res_order[0]['seller_details']['first_name'];
                                    }



                                    $arr_event                 = [];
                                    $arr_event['from_user_id'] = $from_user_id;
                                    $arr_event['to_user_id']   = $who_refer;
                                    $arr_event['description']  = html_entity_decode('Order with Order ID <b>'.$res_order[0]['order_no'].'</b> has been <b>shipped</b> successfully by <b>'.$user_name.'</b>. you get <a target="_blank" href="'.$buyer_wallet_url.'"> $'.$buyer_referal_amount.' </a> amount in your wallet.');
                                    $arr_event['type']        = '';
                                    $arr_event['title']       = 'Order '.$res_order[0]['order_no'].' Shipped';


                                     $this->GeneralService->save_notification($arr_event);



                                    $to_user = Sentinel::findById($who_refer);
                                    $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                                    $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';                              
                                        
                                    $arr_built_content = [
                                        'USER_NAME'     => $f_name.' '.$l_name,
                                        'APP_NAME'      => config('app.project.name'),
                                        'SELLER_NAME'   => $user_name,
                                        'ORDER_NO'      => $res_order[0]['order_no'],
                                        //'MESSAGE'       => $msg,
                                        'URL'           => $buyer_wallet_url,
                                        'REVIEW_WALLET_AMOUNT' => $buyer_referal_amount
                                    ];

                                    $arr_built_subject  = [
                                        
                                        'ORDER_NO'      => $res_order[0]['order_no']
                                    ];


                                    $arr_mail_data['email_template_id'] = '153';
                                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                                    $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                                    $arr_mail_data['user']              = Sentinel::findById($who_refer);


                                    $this->EmailService->send_mail_section_order($arr_mail_data);



                                    /****Notification & email END For**wallet**credited********/







                              }//once shipped then dont update or create wallet for other orders


                           }//if get_whom_referedid

                    }//if is_refered_buyer,is_refered_buyer_order_placed  




                    /******************* Notification START* For Buyer  *************************/
                        $buyer_order_url     = url('/').'/buyer/order/view/'.base64_encode($res_order[0]['id']);

                        $admin_id     = 0;
                        $user_name    = "";

                        $to_user_id       = $res_order[0]['buyer_id'];  
                        //$user_name        = $res_order[0]['seller_details']['first_name']." ".$res_order[0]['seller_details']['last_name'];  

                        if(isset($res_order[0]['seller_details']['seller_detail']['business_name']))
                        {
                          $user_name  = $res_order[0]['seller_details']['seller_detail']['business_name'];
                        }else{
                          $user_name   = $res_order[0]['seller_details']['first_name'];
                        }



                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $from_user_id;
                        $arr_event['to_user_id']   = $to_user_id;
                        $arr_event['description']  = html_entity_decode('Your order with Order ID <a target="_blank" href="'.$buyer_order_url.'"><b>'.$res_order[0]['order_no'].'</b></a> has been <b>shipped</b> successfully by <b>'.$user_name.'</b>.');
                        $arr_event['type']         = '';
                        $arr_event['title']        = 'Order '.$res_order[0]['order_no'].' Shipped';

                        $this->GeneralService->save_notification($arr_event);

                    /*******************Notification END For Buyer   ***************************/

                   
                    /******************* Notification START* For Buyer for tracking details *************************
                     $order_view_url   = url('/').'/'.config('app.project.buyer_panel_slug').'/order/view/'.base64_encode($res_order[0]['id']);
                            
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $to_user_id;
                            $arr_event['description']  = html_entity_decode('Tracking # of your order ID <b><a target="_blank" href="'.$order_view_url.'">'.$res_order[0]['order_no'].'</a></b> is '.$res_order[0]['tracking_no'].' and shipping company name is '.$res_order[0]['shipping_company_name'].'.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Order Tracking # & Shipping Comapny Name.';

                            $this->GeneralService->save_notification($arr_event); 


                    /*******************Notification END For Buyer for tracking details  ***************************/          



                    /***************Send Shipping Mail to Buyer (START)**************************/
                        $to_user = Sentinel::findById($to_user_id);

                        $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                        $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

                      /*  $msg     = html_entity_decode('Your order with order ID <b>'.$res_order[0]['order_no'].'</b>  has been shipped successfully by <b>'.$user_name.'</b>.');*/

                        
                        //$subject = 'Order '.$res_order[0]['order_no'].' Shipped';
                            
                        $arr_built_content = [
                            'USER_NAME'     => $f_name.' '.$l_name,
                            'APP_NAME'      => config('app.project.name'),
                            'SELLER_NAME'   => $user_name,
                            'ORDER_NO'      => $res_order[0]['order_no'],
                            //'MESSAGE'       => $msg,
                            'URL'           => $buyer_order_url
                        ];

                        $arr_built_subject  = [
                            
                            'ORDER_NO'      => $res_order[0]['order_no']
                        ];


                        $arr_mail_data['email_template_id'] = '73';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                        $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                        $this->EmailService->send_mail_section_order($arr_mail_data);

                    /*********************Send Shipping Mail to Buyer (END)*****************/


                    /***************Send order tracking details Mail to Buyer (START)**************************

                      $arr_built_content = [
                                'USER_NAME'     => $f_name.' '.$l_name,
                                'APP_NAME'      => config('app.project.name'),
                                //'MESSAGE'       => $msg,
                                'ORDER_ID'      => $order_id,
                                'TRACKING_NO'   => $res_order[0]['tracking_no'],
                                'SHIPPING_COMPANY'=> $res_order[0]['shipping_company_name'],
                                'URL'           => $buyer_order_url
                            ];

                             $arr_built_subject =  [
                                      'ORDER_NO' => $res_order[0]['order_no']
                                     ];   

                            $arr_mail_data['email_template_id'] = '80';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                            $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                            $this->EmailService->send_mail_section_order($arr_mail_data);


                    /*********************Send order tracking details Mail to Buyer (END)*****************/


                    /******************* Notification START* For Admin  *************************/
                        $admin_order_url     = url('/').'/'.config('app.project.admin_panel_slug').'/order/view/'.base64_encode($res_order[0]['order_no']).'/'.base64_encode($res_order[0]['id']);

                        $from_user_id = 0;
                        $admin_id     = 0;
                        $user_name    = "";

                        if(Sentinel::check())
                        {
                            $user_details = Sentinel::getUser();
                            $from_user_id = $user_details->id;
                           // $user_name    = $res_order[0]['seller_details']['first_name']." ".$res_order[0]['seller_details']['last_name'];  

                             if(isset($res_order[0]['seller_details']['seller_detail']['business_name']))
                            {
                              $user_name  = $res_order[0]['seller_details']['seller_detail']['business_name'];
                            }else{
                              $user_name   = $res_order[0]['seller_details']['first_name'];
                            }

                            
                        }

                        $admin_role = Sentinel::findRoleBySlug('admin');        
                        $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                        if($admin_obj)
                        {
                            $admin_id = $admin_obj->user_id;            
                        }


                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $from_user_id;
                        $arr_event['to_user_id']   = $admin_id;
                        $arr_event['description']  = html_entity_decode('Order with order ID <a target="_blank" href="'.$admin_order_url.'"><b>'.$res_order[0]['order_no'].'</b></a> has been shipped successfully by <b>'.$user_name.'</b>.');
                        $arr_event['type']         = '';
                        $arr_event['title']        = 'Order '.$res_order[0]['order_no'].' Shipped';

                        $this->GeneralService->save_notification($arr_event);

                    /*******************Notification END For Admin   ***************************/

                     /******************* Notification START* For Admin for tracking details  *************************
                         $arr_event_admin                 = [];
                         $arr_event_admin['from_user_id'] = $from_user_id;
                         $arr_event_admin['to_user_id']   = $admin_id;
                         $arr_event_admin['description']  = html_entity_decode('Tracking # of order ID <b><a target="_blank" href="'.$admin_order_url.'">'.$res_order[0]['order_no'].'</a></b> is '.$res_order[0]['tracking_no'].' and shipping company name is '.$res_order[0]['shipping_company_name'].'. ');
                         $arr_event_admin['type']         = '';
                         $arr_event_admin['title']        = 'Order Tracking # & Shipping Company Name';

                            $this->GeneralService->save_notification($arr_event_admin); 

                      
                     /*******************Notification END For Admin for tracking details   ***************************/
 




                    /***************Send Shipping Mail to Admin (START)**************************/
                        $to_user = Sentinel::findById($admin_id);

                        $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                        $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

                        //$msg     = html_entity_decode('Order with order ID <b>'.$res_order[0]['order_no'].'</b> has been shipped successfully by <b>'.$user_name.'</b>.');

                        
                        //$subject = 'Order '.$res_order[0]['order_no'].' Shipped';

                        $arr_built_content = [
                            'USER_NAME'     => config('app.project.admin_name'),
                            'APP_NAME'      => config('app.project.name'),
                            //'MESSAGE'       => $msg,
                            'SELLER_NAME'   => $user_name,
                            'ORDER_NO'      => $res_order[0]['order_no'],
                            'URL'           => $admin_order_url
                        ];

                       $arr_built_subject = [
                            'ORDER_NO'      =>  $res_order[0]['order_no']
                       ];

                        $arr_mail_data['email_template_id'] = '75';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                        $arr_mail_data['user']              = Sentinel::findById($admin_id);

                        $this->EmailService->send_mail_section_order($arr_mail_data);

                    /*********************Send Shipping Mail to Admin (END)*****************/


                    /***********Send Tracking mail to admin (START)************

                    $arr_built_content = $arr_built_subject = [];

                     $arr_built_content = [
                                'USER_NAME'     => config('app.project.admin_name'),
                                'APP_NAME'      => config('app.project.name'),
                                'ORDER_ID'      => $order_id,
                                'TRACKING_NO'   =>  $res_order[0]['tracking_no'],
                                'SHIPPING_COMPANY'=> $res_order[0]['shipping_company_name'],
                                //'MESSAGE'       => $msg,
                                'URL'           => $admin_order_url
                            ];

                             $arr_built_subject  =  [
                                      'ORDER_NO'      => $res_order[0]['order_no']
                                     ];   

                            $arr_mail_data['email_template_id'] = '81';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                            $arr_mail_data['user']              = Sentinel::findById($admin_id); 

                          
                            $this->EmailService->send_mail_section_order($arr_mail_data);

                    /***********Send Tracking mail to admin (END)**************/

                    //Get Dropshipper id 

                    
                    /* $dropshipper_details = [];
                     $site_setting_arr    = [];
                     $site_setting_obj    = SiteSettingModel::first();  
                     $dropshiparr         = []; 
                      if(isset($site_setting_obj))
                      {
                          $site_setting_arr = $site_setting_obj->toArray();            
                      }

                      $address = [];       
                      $address_details = $this->OrderAddressModel->with(['state_details','country_details','billing_state_details','billing_country_details'])->where('order_id',$res_order[0]['order_no'])->first();

                      if ($address_details) {

                        $address['shipping']         = isset($address_details['shipping_address1'])?$address_details['shipping_address1']:'';
                        $address['shipping_state']   = isset($address_details['state_details']['name'])?$address_details['state_details']['name']:'';
                        $address['shipping_country'] = isset($address_details['country_details']['name'])?$address_details['country_details']['name']:'';
                        $address['shipping_zipcode'] = isset($address_details['shipping_zipcode'])?$address_details['shipping_zipcode']:'';
                          $address['shipping_city']  = isset($address_details['shipping_city'])?$address_details['shipping_city']:'';
                        $address['billing']          = isset($address_details['billing_address1'])?$address_details['billing_address1']:'';
                        $address['billing_state']    = isset($address_details['billing_state_details']['name'])?$address_details['billing_state_details']['name']:'';
                        $address['billing_country']  = isset($address_details['billing_country_details']['name'])?$address_details['billing_country_details']['name']:'';
                        $address['billing_zipcode']  = isset($address_details['billing_zipcode'])?$address_details['billing_zipcode']:'';
                        $address['billing_city']     = isset($address_details['billing_city'])?$address_details['billing_city']:'';
                      }
  

                     if(Sentinel::check())
                     {
                        $user_details = Sentinel::getUser();
                        $user_id      = $user_details->id;
                     }


                     if(isset($res_order[0]['buyer_age_restrictionflag']) && $res_order[0]['buyer_age_restrictionflag']==0)
                     { 
                      $order_no       = $res_order[0]['order_no'];
                      $order['total_wholesale_price'] = 0;
                      $order['shipping_charges_sum']  = 0;    
                      $i              = 0;    

                     $product_details  = $this->OrderProductModel->with('product_details')->where('order_id',$res_order[0]['id'])->get();
                     if($product_details!=null)
                     {
                         $product_details = $product_details->toArray();
                         if(isset($product_details) && !empty($product_details))
                         {
                            foreach($product_details as $pro)
                            {
                               $is_dropshipped_product = $this->DropShipperModel->where('product_id',$pro['product_id'])->first();
                               if($is_dropshipped_product)
                               { 
                                 $dropshipper_arr[]    =  $is_dropshipped_product->email;
                               }


                               $product_data           = $this->ProductModel->where('id',$pro['product_id'])->first(); 
                               if($product_data!=null)
                               {
                                  $product_data = $product_data->toArray();
                               }

                               if($is_dropshipped_product!=null)
                               {
                                   
                                    $product_name          = isset($product_data['product_name'])?$product_data['product_name']:'';
                                    $product_id            = $pro['product_id'];
                                    $order['order_no']     = $order_no or '';
                                    $order['product_name'] = $product_name;
                                    $order['product_id']   = $product_id;
                                    $order['item_qty']     = isset($pro['quantity'])?$pro['quantity']:0;
                                    $order['seller_id']    = $user_id;
                                    $order['seller_name']  = get_seller_name($user_id);
                                    $order['dropshipper']  = isset($is_dropshipped_product->email)?$is_dropshipped_product->email:'';
                                    $order['dropshipperid']= isset($is_dropshipped_product->id)?$is_dropshipped_product->id:'';
                                    $order['unit_price']   = isset($is_dropshipped_product->product_price)?$is_dropshipped_product->product_price:'';
                                    $total_wholesale_price = $is_dropshipped_product->product_price*$pro['quantity'];
                                    $dropshiparr[]         = isset($is_dropshipped_product->email)?$is_dropshipped_product->email:'';
                                    $order['total_wholesale_price']     = $total_wholesale_price;
                                    $order['shipping_charges_sum']      = $pro['shipping_charges'];       

                                    $drop_sellerid         = $user_id;
                                    $seluser_info = $this->UserModel->with('seller_detail')->where('id',$drop_sellerid)->first();
                                    if(isset($seluser_info) && !empty($seluser_info))
                                    {
                                      $seluser_info = $seluser_info->toArray();
                                    }

                                     $user_id              = $this->DropShipperModel->where('email',$is_dropshipped_product->email)->first();

                                     $buyer_details       = $this->UserModel->where('id',$res_order[0]['buyer_id'])->first()->toArray();

                                     $obj_email_template  = $this->EmailTemplateModel->where('id','47')->first();

                                     $to_mail_id          = $is_dropshipped_product->email;  

                                  if($obj_email_template)
                                  {
                                    $arr_email_template = $obj_email_template->toArray();
                                    $content            = $arr_email_template['template_html'];
                                  }

                                  $content = str_replace("##DROPSHIPPER_NAME##",$user_id->name,$content);
                                  $content = str_replace("##BUYER_NAME##",$buyer_details['first_name'].' '.$buyer_details['last_name'],$content);
                                  $content = str_replace("##APP_NAME##",config('app.project.name'),$content);
                              

                                  $content = view('email.front_general',compact('content'))->render();
                                  $content = html_entity_decode($content);

                                  $sn_no   = 0;

                                

                                  $pdf = PDF::loadView('front/dropshipperemail_invoice_new',compact('order','order_no','sn_no','address','site_setting_arr','user','seluser_info'));

                                  $currentDateTime = $order_no.date('H:i:s').'.pdf';
                                  Storage::put('public/pdf/'.$currentDateTime, $pdf->output());
                                  $pdfpath         = Storage::url($currentDateTime);  
                                  $file_to_path    = url("/")."/storage/app/public/pdf/".$currentDateTime;

                                  $send_mail = Mail::send(array(),array(), function($message) use($content,$to_mail_id,$file_to_path,$arr_email_template,$order_no)
                                  {
                                      if(isset($arr_email_template) && count($arr_email_template) > 0)
                                      {   
                                        $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                          $message->to($to_mail_id);

                                          $dynamicsubject = $arr_email_template['template_subject'];
                                          $dynamicsubject = str_replace("##order_no##",$order_no, $dynamicsubject);
                                          $message->subject($dynamicsubject);
                                      }
                                      else
                                      {
                                        $admin_email = 'notify@chow420.com';

                                        $message->from($admin_email);
                                          $message->to($to_mail_id);
                                        $message->subject('Dropship Order');
                                      }             
                                        
                                    $message->setBody($content, 'text/html');
                                    $message->attach($file_to_path);
                         
                                  }); //end of sendmail
                            }// end if droshipper not null
                         }//end foreach 
                     }//end if product details not empty
                  }  //end if product details object not null 
                } //buyer age restriction */

                    

        /*              $package_shipped = [];
                      $package_carrier_code = $package_tracking_number = "";       

                      if(isset($order_details) && !empty($order_details))
                      {  
                         $package_shipped           = $this->ship_package($order_details);
                         if(isset($package_shipped) && !empty($package_shipped))
                         { 
                           $package_carrier_code    = $package_shipped['carrier_code'];
                           $package_tracking_number = $package_shipped['tracking_number'];
                           $update_tracking_details = $this->OrderModel
                               ->where('id',$order_id)
                               ->where('seller_id',$user_details->id)
                               ->update(['tracking_no'=>$package_tracking_number,'shipping_company_name'=>$package_carrier_code]);
                          }   

                      }
*/
                    Flash::success(str_singular($this->module_title).' shipped successfully');



                  /*  $tracking_no = $shipping_company_name = "";

                    $tracking_no            = $res_order[0]['tracking_no'];
                    $shipping_company_name  = $res_order[0]['shipping_company_name'];

                    $tracking_response      = $this->track_order($tracking_no,$shipping_company_name);

                    $arr = $tracking_response;
                    Session::push('tracking_info',$arr);
                    Flash::success('This order has been shipped!'); */

                }
                else
                {
                    Flash::error('Problem occured while updating the order status');
                }
            }
            else
            {
                Flash::error('Record does not exists');
            }
        }
        else
        {
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function track_order($tracking_no="",$shipping_company_name="")
    {
        $curl    = curl_init();
        $api_key = "";
        $api_key_details = $this->SiteSettingModel->first()->sandbox_tracking_api_key; 
        if(!empty($api_key_details))
        {
         $api_key = $api_key_details;
        } 

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.shipengine.com/v1/tracking?carrier_code=".$shipping_company_name."&tracking_number=".$tracking_no,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Host: api.shipengine.com",
            "API-Key: ".$api_key
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response,true);
    }


    public function branding_page($tracking_info="",$order_arr="")
    {

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.shipengine.com/v-beta/tracking_page",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n  \"tracking_pages\" :[\n  {\n    \"branded_tracking_theme_guid\"   : \"fc16e39d-9722-4514-aff5-75e1f24c5bbd\",\n    \"tracking_number\" : \"012345678910\",\n    \"carrier_code\" : \"ups\",\n    \"service_code\" : \"ups_ground\",\n    \"to_city_locality\" :\"austin\",\n    \"to_state_province\" : \"tx\",\n    \"to_postal_code\" : \"78756\",\n    \"to_country_code\" : \"US\",\n    \"from_city_locality\" :\"denver\",\n    \"from_state_province\" : \"CO\",\n      \"from_postal_code\" : \"80014\",\n    \"from_country_code\" : \"US\"\n\n  }\n  ]\n}",
        CURLOPT_HTTPHEADER => array(
          "Host: api.shipengine.com",
          "API-Key: TEST_GlDFwCkDvDzj+yQorN8qJrS+ig12vO8qO4vA2IHh7f0",
          "Content-Type: application/json"
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

        return json_decode($response);
    }


    public function generate_lable($order_arr="")
    {
       $buyer_details = $seller_details = [];
       $api_key = "";
       $api_key_details = $this->SiteSettingModel->first()->sandbox_tracking_api_key; 
       if(!empty($api_key_details))
       {
         $api_key = $api_key_details;
       } 


       if(isset($order_arr) && sizeof($order_arr)>0)
       { 
          $buyer_country_code = $this->CountriesModel->where('id',$order_arr['buyer_details']['country'])->first()->sortname;
          $seller_country_code = $this->CountriesModel->where('id',$order_arr['seller_details']['country'])->first()->sortname;
          $seller_business_name = $this->SellerModel->where('user_id',$order_arr['seller_details']['id'])->first()->business_name;


          $buyer_details = array('name'=>$order_arr['buyer_details']['first_name']." ".$order_arr['buyer_details']['last_name'],'phone'=>$order_arr['buyer_details']['phone'],'street_address'=>$order_arr['buyer_details']['street_address'],'city'=>$order_arr['buyer_details']['city'],'postal_code'=>$order_arr['buyer_details']['zipcode'],'country_code'=>$buyer_country_code);

          $seller_details = array('name'=>$order_arr['seller_details']['first_name']." ".$order_arr['seller_details']['last_name'],'phone'=>$order_arr['seller_details']['phone'],'street_address1'=>$order_arr['seller_details']['street_address'],'street_address2'=>$order_arr['seller_details']['billing_street_address'],'city'=>$order_arr['seller_details']['city'],'postal_code'=>$order_arr['seller_details']['zipcode'],'country_code'=>$seller_country_code,'business_name'=>$seller_business_name);

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.shipengine.com/v1/labels",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n  \"shipment\": {\n    \"service_code\": \"ups_ground\",\n    \"ship_to\": {\n      \"name\": \"".$buyer_details['name']."\",\n      \"address_line1\": \"".$buyer_details['street_address']."\",\n      \"city_locality\": \"".$buyer_details['city']."\",\n      \"state_province\": \"CA\",\n      \"postal_code\": \"95128\",\n      \"country_code\": \"US\",\n      \"address_residential_indicator\": \"yes\"\n    },\n    \"ship_from\": {\n      \"name\": \"".$seller_details['name']."\",\n      \"company_name\": \"".$seller_details['business_name']."\",\n      \"phone\": \"".$seller_details['phone']."\",\n      \"address_line1\": \"".$seller_details['street_address1']."\",\n      \"city_locality\": \"".$seller_details['city']."\",\n      \"state_province\": \"TX\",\n      \"postal_code\": \"78756\",\n      \"country_code\": \"US\",\n      \"address_residential_indicator\": \"no\"\n    },\n    \"packages\": [\n      {\n        \"weight\": {\n          \"value\": 20,\n          \"unit\": \"ounce\"\n        },\n        \"dimensions\": {\n          \"height\": 6,\n          \"width\": 12,\n          \"length\": 24,\n          \"unit\": \"inch\"\n        }\n      }\n    ]\n  }\n}",
            CURLOPT_HTTPHEADER => array(
              "Host: api.shipengine.com",
              "API-Key: ".$api_key,
              "Content-Type: application/json"
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);
         return json_decode($response,true);
         
       }
    }


    public function ship_package($order_arr = "")
   {
      $buyer_country_code = $seller_country_code = $seller_business_name = $ship_date = "";

      if(isset($order_arr) && !empty($order_arr))
      {
          $buyer_country_code   = $this->CountriesModel->where('id',$order_arr['buyer_details']['country'])->first()->sortname;
          $seller_country_code  = $this->CountriesModel->where('id',$order_arr['seller_details']['country'])->first()->sortname;
          $seller_business_name = $this->SellerModel->where('user_id',$order_arr['seller_details']['id'])->first()->business_name;

          $ship_date            = date('Y-m-d', strtotime($order_arr['updated_at']));


          $buyer_details        = array('name'=>$order_arr['buyer_details']['first_name']." ".$order_arr['buyer_details']['last_name'],'phone'=>$order_arr['buyer_details']['phone'],'street_address'=>$order_arr['buyer_details']['street_address'],'city'=>$order_arr['buyer_details']['city'],'postal_code'=>$order_arr['buyer_details']['zipcode'],'country_code'=>$buyer_country_code);

          $seller_details       = array('name'=>$order_arr['seller_details']['first_name']." ".$order_arr['seller_details']['last_name'],'phone'=>$order_arr['seller_details']['phone'],'street_address1'=>$order_arr['seller_details']['street_address'],'street_address2'=>$order_arr['seller_details']['billing_street_address'],'city'=>$order_arr['seller_details']['city'],'postal_code'=>$order_arr['seller_details']['zipcode'],'country_code'=>$seller_country_code,'business_name'=>$seller_business_name);

      }

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL            => "https://api.shipengine.com/v1/labels",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => "POST",
        CURLOPT_POSTFIELDS     =>"{\n  \"shipment\": {\n    \"service_code\": \"usps_priority_mail\",\n    \"ship_date\": \"".$ship_date."\",\n    \"ship_to\": {\n      \"name\": \"".$buyer_details['name']."\",\n      \"phone\": \"".$buyer_details['phone']."\",\n      \"address_line1\": \"".$buyer_details['street_address']."\",\n      \"city_locality\": \"".$buyer_details['city']."\",\n      \"state_province\": \"CA\",\n      \"postal_code\": \"95128\",\n      \"country_code\": \"US\",\n      \"address_residential_indicator\": \"yes\"\n    },\n    \"ship_from\": {\n      \"company_name\": \"".$seller_details['business_name']."\",\n      \"name\": \"".$seller_details['name']."\",\n      \"phone\": \"".$seller_details['phone']."\",\n      \"address_line1\": \"".$seller_details['street_address1']."\",\n      \"address_line2\": \"".$seller_details['street_address2']."\",\n      \"city_locality\": \"".$seller_details['city']."\",\n      \"state_province\": \"TX\",\n      \"postal_code\": \"78756\",\n      \"country_code\": \"US\",\n      \"address_residential_indicator\": \"no\"\n    },\n    \"packages\": [\n      {\n        \"weight\": {\n          \"value\": 1.0,\n          \"unit\": \"ounce\"\n        }\n      }\n    ]\n  }\n}",
        CURLOPT_HTTPHEADER      => array(
          "Host: api.shipengine.com",
          "API-Key: TEST_GlDFwCkDvDzj+yQorN8qJrS+ig12vO8qO4vA2IHh7f0",
          "Content-Type: application/json"
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return json_decode($response,true);
  }

    
    public function complete($enc_id="")
    {
       $order_id = base64_decode($enc_id);

       if($order_id)
       {
            $res_order = $this->OrderModel
                              ->with('buyer_details','seller_details','seller_details.seller_detail')
                              ->select('*')
                              ->where('id',$order_id)
                              ->get()->toArray();

            if(!empty($res_order) && count($res_order)>0)
            {
                $from_user_id = 0;
                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id; 
                }

              $update = $this->OrderModel
                             ->where('id',$order_id)
                             ->where('seller_id',$user_details->id)
                             ->update(['order_status'=>'1']);
              if($update)
              {

                /******************* Notification START* For Buyer  *************************/
                    $buyer_order_url   = url('/').'/buyer/order/view/'.base64_encode($res_order[0]['id']);

                    $admin_id     = 0;
                    $user_name    = "";

                    $to_user_id       = $res_order[0]['buyer_id'];  
                  //  $user_name        = $res_order[0]['seller_details']['first_name']." ".$res_order[0]['seller_details']['last_name'];  

                    if(isset($res_order[0]['seller_details']['seller_detail']['business_name']))
                    {
                      $user_name  = $res_order[0]['seller_details']['seller_detail']['business_name'];
                    }else{
                      $user_name   = $res_order[0]['seller_details']['first_name'];
                    }


                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $to_user_id;
                    $arr_event['description']  = html_entity_decode('Your order with order ID <a target="_blank" href="'.$buyer_order_url.'"><b>'.$res_order[0]['order_no'].'</a></b> has been <b>delivered</b> successfully by <b>'.$user_name.'</b>.');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Order '.$res_order[0]['order_no'].' Delivered';

                    $this->GeneralService->save_notification($arr_event);

                /*******************Notification END For Buyer   ***************************/

                /***************Send Shipping Mail to Buyer (START)**************************/
                    $to_user = Sentinel::findById($to_user_id);

                    $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                    $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                    //$msg     = html_entity_decode('Your order with order ID '.$res_order[0]['order_no'].' has been delivered successfully by <b>'.$user_name.'</b>.');

                    
                    //$subject = 'Order '.$res_order[0]['order_no'].' Delivered';

                    $arr_built_content = [
                        'USER_NAME'     => $f_name.' '.$l_name,
                        'APP_NAME'      => config('app.project.name'),
                        //'MESSAGE'       => $msg,
                        'SELLER_NAME'   => $user_name,
                        'ORDER_NO'      => $res_order[0]['order_no'],
                        'URL'           => $buyer_order_url
                    ];

                     $arr_built_subject = [
                        'ORDER_NO'      =>  $res_order[0]['order_no']
                    ];

                    $arr_mail_data['email_template_id'] = '77';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                    $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                    $this->EmailService->send_mail_section_order($arr_mail_data);

                /*********************Send Shipping Mail to Buyer (END)*****************/

                /******************* Notification START* For Admin  *************************/
                    $admin_order_url     = url('/').'/'.config('app.project.admin_panel_slug').'/order/view/'.base64_encode($res_order[0]['order_no']).'/'.base64_encode($res_order[0]['id']);

                    $from_user_id = 0;
                    $admin_id     = 0;
                    $user_name    = "";

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;
                        $user_name    = $res_order[0]['seller_details']['first_name']." ".$res_order[0]['seller_details']['last_name'];  
                    }

                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }


                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']  = html_entity_decode('Order with order ID <a target="_blank" href="'.$admin_order_url.'"><b>'.$res_order[0]['order_no'].'</b></a> has been delivered successfully by <b>'.$user_name.'</b>.');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Order '.$res_order[0]['order_no'].' Delivered';

                    $this->GeneralService->save_notification($arr_event);

                /*******************Notification END For Admin   ***************************/

         
                /***************Send Shipping Mail to Admin (START)**************************/
                    $to_user = Sentinel::findById($admin_id);

                    $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                    $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

                    //$msg     = html_entity_decode('Order with order ID <b>'.$res_order[0]['order_no'].'</b> has been delivered successfully by <b>'.$user_name.'</b>.');

                   
                    //$subject = 'Order '.$res_order[0]['order_no'].' Delivered';

                    $arr_built_content = [
                        'USER_NAME'     => config('app.project.admin_name'),
                        'APP_NAME'      => config('app.project.name'),
                        //'MESSAGE'       => $msg,
                        'ORDER_NO'      => $res_order[0]['order_no'],
                        'SELLER_NAME'   => $user_name,  
                        'URL'           => $admin_order_url
                    ];

                    $arr_built_subject =  [
                                      'ORDER_NO'      => $res_order[0]['order_no']
                                     ];   

                    $arr_mail_data['email_template_id'] = '78';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_mail_section_order($arr_mail_data);

                /*********************Send Shipping Mail to Admin (END)*****************/

                 $order_details = $this->OrderModel
                              ->with('buyer_details','seller_details')
                              ->select('*')
                              ->where('id',$order_id)
                              ->first()->toArray();
         
              //  $lable_info = $this->generate_lable($order_details); 

                Flash::success(str_singular($this->module_title).' delivered successfully');
              }
              else
              {
                Flash::error('Problem occured while updating the order status');

              }

           }
           else
           {
                Flash::error('Record does not exists');
           }
        }
        else
        {
            return redirect()->back();
        }

       return redirect()->back();

    }

    public function updateTracking(Request $request)
    {
        $arr_response = [];
        $frm_data = $request->all();
        
        if(Session::get('tracking_info')!="")
        {
          $_SESSION['tracking_info'] = "";
        }

        if(isset($frm_data) && count($frm_data) > 0 && isset($frm_data['tracking_no'])  && isset($frm_data['shipping_company_name']) && !empty($frm_data['shipping_company_name'])
          && !empty($frm_data['tracking_no']) && isset($frm_data['seller_id']) && !empty($frm_data['seller_id']) && isset($frm_data['order_id']) && !empty($frm_data['order_id']))
        {
            $arr_update = array('tracking_no'=>$frm_data['tracking_no'],
                                'shipping_company_name'=> $frm_data['shipping_company_name']);

            $update =   $this->OrderModel
                             ->where('seller_id',$frm_data['seller_id'])
                             ->where('order_no',$frm_data['order_id'])
                             ->update($arr_update);
            
            if($update)
            {
               
                $obj_order_details = $this->OrderModel
                                          ->with(['buyer_details'])
                                          ->where('seller_id',$frm_data['seller_id'])
                                          ->where('order_no',$frm_data['order_id'])
                                          ->first();

                if($obj_order_details)
                {
                    $arr_order_details = $obj_order_details->toArray();

                    if(isset($arr_order_details['buyer_details']['email']) && !empty($arr_order_details['buyer_details']['email']) && isset($arr_order_details['buyer_details']['id']) && !empty($arr_order_details['buyer_details']['id']))
                    {
                        /****************Send Notification to Buyer(START)***************************/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $user_details = Sentinel::getUser();
                                $from_user_id = $user_details->id;
                                $user_name    = $user_details->first_name.' '.$user_details->last_name;
                            }

                            $order_view_url   = url('/').'/'.config('app.project.buyer_panel_slug').'/order/view/'.base64_encode($arr_order_details['id']);
                            
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $arr_order_details['buyer_details']['id'];
                            $arr_event['description']  = html_entity_decode('Tracking # of your order ID <b><a target="_blank" href="'.$order_view_url.'">'.$frm_data['order_id'].'</a></b> is '.$frm_data['tracking_no'].' and shipping company name is '.$frm_data['shipping_company_name'].'.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Order Tracking # & Shipping Comapny Name.';

                            $this->GeneralService->save_notification($arr_event); 

                        /************Send Notification to Buyer(END)*************************/   

                        /**************Send Notification to admin (START)******************/   
                          
                           $admin_role = Sentinel::findRoleBySlug('admin');        
                            $admin_obj  = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                            if($admin_obj)
                            {
                                $admin_id = $admin_obj->user_id;            
                            }

                            $admin_order_view_url     = url('/').'/'.config('app.project.admin_panel_slug').'/order/view/'.base64_encode($arr_order_details['order_no']).'/'.base64_encode($arr_order_details['id']);

                            
                            $arr_event_admin                 = [];
                            $arr_event_admin['from_user_id'] = $from_user_id;
                            $arr_event_admin['to_user_id']   = $admin_id;
                            $arr_event_admin['description']  = html_entity_decode('Tracking # of order ID <b><a target="_blank" href="'.$admin_order_view_url.'">'.$frm_data['order_id'].'</a></b> is '.$frm_data['tracking_no'].' and shipping company name is '.$frm_data['shipping_company_name'].'. ');
                            $arr_event_admin['type']         = '';
                            $arr_event_admin['title']        = 'Order Tracking # & Shipping Company Name';

                            $this->GeneralService->save_notification($arr_event_admin); 

                        /*********************Send Notification to Admin (END)*********************/

                        /***************Send Tracking Mail to Buyer (START)*************************/
                           $to_user = Sentinel::findById($arr_order_details['buyer_details']['id']);

                            $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                            $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

                            $buyerorderemail_view_url  = url('/').'/'.config('app.project.buyer_panel_slug').'/order/view/'.base64_encode($arr_order_details['id']);

                            //$msg     = html_entity_decode('Tracking # of your order ID <b><a target="_blank" href="'.$buyerorderemail_view_url.'">'.$frm_data['order_id'].'</a></b> is '.$frm_data['tracking_no'].' and shipping company name is '.$frm_data['shipping_company_name'].'. ');
               
                            $subject = 'Tracking # and Shipping company name of your order '.$arr_order_details['order_no'];

                            $arr_built_content = [
                                'USER_NAME'     => $f_name.' '.$l_name,
                                'APP_NAME'      => config('app.project.name'),
                                //'MESSAGE'       => $msg,
                                'ORDER_ID'      => $frm_data['order_id'],
                                'TRACKING_NO'   => $frm_data['tracking_no'],
                                'SHIPPING_COMPANY'=> $frm_data['shipping_company_name'],
                                'URL'           => $buyerorderemail_view_url
                            ];

                             $arr_built_subject =  [
                                      'ORDER_NO' => $arr_order_details['order_no']
                                     ];   

                            $arr_mail_data['email_template_id'] = '80';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                            $arr_mail_data['user']              = Sentinel::findById($arr_order_details['buyer_details']['id']);

                            $this->EmailService->send_mail_section_order($arr_mail_data);

                        /*****************Send Tracking Mail to Buyer (END)*****************/

                        /******************Send Tracking Mail to Admin (START)*********************/

                            $admin_role = Sentinel::findRoleBySlug('admin');        
                            $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                            if($admin_obj)
                            {
                               $admin_id = $admin_obj->user_id;            
                            } 

                            $to_user = Sentinel::findById($admin_id); 
                           
                            $admin_order_view_url  = url('/').'/'.config('app.project.admin_panel_slug').'/order/view/'.base64_encode($arr_order_details['order_no']).'/'.base64_encode($arr_order_details['id']);


                            //$msg     = html_entity_decode('Tracking # of order ID <b><a target="_blank" href="'.$admin_order_view_url.'">'.$frm_data['order_id'].'</a></b> is '.$frm_data['tracking_no'].' and shipping company name is '.$frm_data['shipping_company_name'].'. ');

                            //$subject = 'shipping details updated for order '.$arr_order_details['order_no'];

                            $arr_built_content = [
                                'USER_NAME'     => config('app.project.admin_name'),
                                'APP_NAME'      => config('app.project.name'),
                                'ORDER_ID'      => $frm_data['order_id'],
                                'TRACKING_NO'   => $frm_data['tracking_no'],
                                'SHIPPING_COMPANY'=> $frm_data['shipping_company_name'],
                                //'MESSAGE'       => $msg,
                                'URL'           => $admin_order_view_url
                            ];

                             $arr_built_subject =  [
                                      'ORDER_NO'      => $arr_order_details['order_no']
                                     ];   

                            $arr_mail_data['email_template_id'] = '81';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                            $arr_mail_data['user']              = Sentinel::findById($admin_id); 

                          
                            $this->EmailService->send_mail_section_order($arr_mail_data);

                        /*******************Send Tracking Mail to Admin (END)*************************/

                    } 
                }

                $arr_response['status'] = 'success';
                $arr_response['description'] = 'Tracking # and shipping company name added successfully';
            }
            else
            {
                $arr_response['status'] = 'error';
                $arr_response['description'] = 'Unable to add tracking # and shipping company name';   
            }
        }
        else
        {
            $arr_response['status'] = 'error';
            $arr_response['description'] = 'Unable to add tracking # and shipping company name';   
        }

        return json_encode($arr_response);
    }// end of function 

    // function for dispatched order

    public function dispatched($enc_id="")
    {
       $order_id = base64_decode($enc_id);

        if($order_id)
        {
           $res_order = $this->OrderModel
                             ->with('buyer_details','seller_details')
                             ->select('*')
                             ->where('id',$order_id)
                             ->get()->toArray();



           if(!empty($res_order) && count($res_order)>0)
           {
                $from_user_id = 0;
                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id; 
                }

                $update = $this->OrderModel
                             ->where('id',$order_id)
                             ->where('seller_id',$user_details->id)
                             ->update(['order_status'=>'4']);

                if($update)
                {

                    /******************* Notification START* For Buyer  *************************/
                        $buyer_order_url     = url('/').'/buyer/order/view/'.base64_encode($res_order[0]['id']);

                        $admin_id     = 0;
                        $user_name    = "";

                        $to_user_id       = $res_order[0]['buyer_id'];  
                        $user_name        = $res_order[0]['seller_details']['first_name']." ".$res_order[0]['seller_details']['last_name'];  

                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $from_user_id;
                        $arr_event['to_user_id']   = $to_user_id;
                        $arr_event['description']  = html_entity_decode('Your order with Order ID <a target="_blank" href="'.$buyer_order_url.'"><b>'.$res_order[0]['order_no'].'</b></a> has been <b>dispatched</b> successfully by <b>'.$user_name.'</b>.');
                        $arr_event['type']         = '';
                        $arr_event['title']        = 'Order Dispatched';

                        $this->GeneralService->save_notification($arr_event);

                    /*******************Notification END For Buyer   ***************************/

                    /***************Send Shipping Mail to Buyer (START)**************************/
                        $to_user = Sentinel::findById($to_user_id);

                        $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                        $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

                        $msg     = html_entity_decode('Your order with order ID <b>'.$res_order[0]['order_no'].'</b>  has been dispatched successfully by <b>'.$user_name.'</b>.');

                        
                        $subject = 'Order Dispatched';
                            
                        $arr_built_content = [
                            'USER_NAME'     => $f_name.' '.$l_name,
                            'APP_NAME'      => config('app.project.name'),
                            'MESSAGE'       => $msg,
                            'URL'           => $buyer_order_url
                        ];

                        $arr_mail_data['email_template_id'] = '31';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = $subject;
                        $arr_mail_data['user']              = Sentinel::findById($to_user_id);

                        $this->EmailService->send_notification_mail($arr_mail_data);

                    /*********************Send Shipping Mail to Buyer (END)*****************/

                    /******************* Notification START* For Admin  *************************/
                        $admin_order_url     = url('/').'/'.config('app.project.admin_panel_slug').'/order/view/'.base64_encode($res_order[0]['order_no']).'/'.base64_encode($res_order[0]['id']);

                        $from_user_id = 0;
                        $admin_id     = 0;
                        $user_name    = "";

                        if(Sentinel::check())
                        {
                            $user_details = Sentinel::getUser();
                            $from_user_id = $user_details->id;
                            $user_name    = $res_order[0]['seller_details']['first_name']." ".$res_order[0]['seller_details']['last_name'];  
                        }

                        $admin_role = Sentinel::findRoleBySlug('admin');        
                        $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                        if($admin_obj)
                        {
                            $admin_id = $admin_obj->user_id;            
                        }


                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $from_user_id;
                        $arr_event['to_user_id']   = $admin_id;
                        $arr_event['description']  = html_entity_decode('Order with order ID <a target="_blank" href="'.$admin_order_url.'"><b>'.$res_order[0]['order_no'].'</b></a> has been dispatched successfully by <b>'.$user_name.'</b>.');
                        $arr_event['type']         = '';
                        $arr_event['title']        = 'Order Dispatched';

                        $this->GeneralService->save_notification($arr_event);

                    /*******************Notification END For Admin   ***************************/

                    /***************Send Shipping Mail to Admin (START)**************************/
                        $to_user = Sentinel::findById($admin_id);

                        $f_name  = isset($to_user->first_name) ? $to_user->first_name : '';
                        $l_name  = isset($to_user->last_name) ? $to_user->last_name : '';

                        $msg     = html_entity_decode('Order with order ID <b>'.$res_order[0]['order_no'].'</b> has been dispatched successfully by <b>'.$user_name.'</b>.');

                        
                        $subject = 'Order Dispatched';

                        $arr_built_content = [
                            'USER_NAME'     => config('app.project.admin_name'),
                            'APP_NAME'      => config('app.project.name'),
                            'MESSAGE'       => $msg,
                            'URL'           => $admin_order_url
                        ];

                        $arr_mail_data['email_template_id'] = '31';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = $subject;
                        $arr_mail_data['user']              = Sentinel::findById($admin_id);

                        $this->EmailService->send_notification_mail($arr_mail_data);

                    /*********************Send Shipping Mail to Admin (END)*****************/

                    Flash::success(str_singular($this->module_title).' dispatched successfully');
                }
                else
                {
                    Flash::error('Problem occured while updating the order status');
                }
            }
            else
            {
                Flash::error('Record does not exists');
            }
        }
        else
        {
            return redirect()->back();
        }

        return redirect()->back();
    }// end of function of dispatched

    // export function added   
    function export($from_date,$to_date,$excelorderstatus)
    {
        if($from_date && $to_date && $excelorderstatus)
       {

         if(Sentinel::check())
        {
            $user_details = Sentinel::getUser();
            $seller_user_id = $user_details->id;
          
        }

       // $completedflag = 1;
        $this->OrderService->export_orders($from_date,$to_date,$excelorderstatus,$seller_user_id);
       }
            
    }// end of function



    // export function added   
    function exportcsv($from_date,$to_date,$excelorderstatus)
    {
        if($from_date && $to_date && $excelorderstatus)
       {

         if(Sentinel::check())
        {
            $user_details = Sentinel::getUser();
            $seller_user_id = $user_details->id;
          
        }

       // $completedflag = 1;
        $this->OrderService->export_orders_csv($from_date,$to_date,$excelorderstatus,$seller_user_id);
       }
            
    }// end of function

    public function cancel(Request $request)
    {

        $user_id = 0;
        $result  = 1; 
        
        $form_data = $request->all();

        $user = Sentinel::check();


        if(isset($user))
        {
           $user_id = $user->id; 
        }

        $order_id       = $form_data['order_id'];
        $order_cancel_reason       = $form_data['order_cancel_reason'];

        $order_details  = $this->OrderModel->with('order_product_details')->where('id',$order_id)->first()->toArray();
        $product_ids    = array_column($order_details['order_product_details'], 'product_id');
         

        if(isset($product_ids) && count($product_ids)>0)
        {
            foreach($product_ids as $product_id)
            { 
                $order_product_quantity    = $this->OrderProductModel->where('product_id',$product_id)->where('order_id',$order_id)->select('quantity')->first()->toArray();

                $order_product_quantity    = $order_product_quantity['quantity'];

                $existing_product_quantity = $this->ProductInventoryModel->where('product_id',$product_id)->select('remaining_stock')->first()->toArray();

                $product_new_quantity      = $existing_product_quantity['remaining_stock'] + $order_product_quantity;


                $update_quantity           = $this->ProductInventoryModel->where('product_id',$product_id)->update(array('remaining_stock'=>$product_new_quantity));

            }
        }

        //  $result   = $this->OrderModel->where('order_no',$order_details['order_no'])->update(array('order_status' => '0'));
        $data =[];
         $cancel_date = Carbon::now();
        $cancel_date = $cancel_date->toDateTimeString();
        $data = array(
            'order_status' => "0",
            'refund_status' => "0",
            'order_cancel_reason' => $order_cancel_reason,
            'order_cancel_time' => $cancel_date
        );
        $result   = $this->OrderModel->where('id',$order_details['id'])->update($data);
        $cancel_cashack = cancel_cashback($order_details['order_no']);

        if($result && $update_quantity)
        { 
            /*******************Send Notification to Admin (START)*************************/
                //$admin_panel_order_url = url('/').'/'.config('app.project.admin_panel_slug').'/order/';

                $admin_panel_order_url     = url('/').'/'.config('app.project.admin_panel_slug').'/order/view/'.base64_encode($order_details['order_no']).'/'.base64_encode($order_details['id']);

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                    
                    $buyer_fname = isset($user_details->first_name)?$user_details->first_name:'';
                    $buyer_lname = isset($user_details->last_name)?$user_details->last_name:'';

                    $user_name   = $buyer_fname.' '.$buyer_lname;

                    $businessname  ='';
                    $seller_details = $this->UserModel->with(['seller_detail'])->where('id',$user_details->id)->first();
                    if(isset($seller_details) && !empty($seller_details))
                    {
                       $businessname = isset($seller_details['seller_detail']['business_name'])?$seller_details['seller_detail']['business_name']:''; 
                    }

                    if(isset($businessname) && !empty($businessname)){
                      $user_name = $businessname;
                    }else{
                      $user_name = $buyer_fname;
                    }


                }

                
                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }


                $arr_event                 = [];
                $arr_event['from_user_id'] = $from_user_id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['description']  = html_entity_decode('Dispensary <b>'.$user_name.'</b> has cancelled the order with order no. : <a target="_blank" href="'.$admin_panel_order_url.'"><b>'. $order_details['order_no'].'</b></a>.'); 
                $arr_event['type']         = '';
                $arr_event['title']        = 'Order '. $order_details['order_no'].' Cancelled';

                $this->GeneralService->save_notification($arr_event);

            /*******************Send Notification to Admin (END)***************************/


            /*******************Send Mail Notification to Admin (START)****************************/
                //$msg    = html_entity_decode('Dispensary <b>'.$user_name.'</b> has cancelled the order with order no. : <b>'. $order_details['order_no'].'</b>.'); 
                       
                //$subject     = 'Order '. $order_details['order_no'].' Cancelled';

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'       => $msg,
                                      'SELLER_NAME'   => $user_name,
                                      'ORDER_NO'      => $order_details['order_no'],
                                      'URL'           => $admin_panel_order_url
                                     ];

                $arr_built_subject =  [
                                      'ORDER_NO'      => $order_details['order_no']
                                     ];                           

                $arr_mail_data['email_template_id'] = '82';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section_order($arr_mail_data); 

            /*******************Send Mail Notification to Admin (END)******************************/


            /********************Send Notification to Seller (START)*************************/
              //  $arr_seller                = $this->OrderModel->select('seller_id')->where('order_no',$order_details['order_no'])->get()->toArray(); 

                $seller_panel_order_url = url('/').'/buyer/order/view/'.base64_encode($order_details['id']);

                $arr_seller                = $this->OrderModel
                                                  ->select('buyer_id')
                                                  ->with(['buyer_details'])
                                                  ->where('id',$order_details['id'])
                                                  ->first();
                 
                if(!empty($arr_seller))
                {
                    $arr_seller = $arr_seller->toArray();
                }

                if(isset($arr_seller) && count($arr_seller)>0 && (!empty($arr_seller)))
                {   
                    $seller_id    = $arr_seller['buyer_id'];
                    $seller_fname = isset($arr_seller['buyer_details']['first_name'])?$arr_seller['buyer_details']['first_name']:'';
                    $seller_lname = isset($arr_seller['buyer_details']['last_name'])?$arr_seller['buyer_details']['last_name']:'';

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $seller_id;
                    $arr_event['description']  = html_entity_decode('Dispensary <b>'.$user_name.'</b> has cancelled the order with order no : <a target="_blank" href="'.$seller_panel_order_url.'"><b>'.$order_details['order_no'].'</b></a>.');
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Order '. $order_details['order_no'].' Cancelled';
                   
                    $this->GeneralService->save_notification($arr_event);
                }

           
            /******************* Send Notification to Seller (END) ***************************/

            /***************Send Mail Notification to Seller (START)**************************/
               /* $msg    = html_entity_decode('Dispensary <b>'.$user_name.'</b> has cancelled the order with order no : <b>'.$order_details['order_no'].'</b>.');*/
                       
                //$subject     = 'Order '. $order_details['order_no'].' Cancelled';

                $arr_built_content = ['USER_NAME'     => $seller_fname.' '.$seller_lname,
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'       => $msg,
                                      'SELLER_NAME'   => $user_name,
                                      'ORDER_NO'      => $order_details['order_no'],
                                      'URL'           => $seller_panel_order_url
                                     ];

               $arr_built_subject =  [
                                      'ORDER_NO'      => $order_details['order_no']
                                     ];                   

                $arr_mail_data['email_template_id'] = '83';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = $arr_built_subject;
                $arr_mail_data['user']              = Sentinel::findById($seller_id);

                $this->EmailService->send_mail_section_order($arr_mail_data);  
            /***************Send Mail Notification to Seller (END)****************************/


            // /******************* Send Notification to Buyer (START)  *************************/
            //     $buyer_panel_order_url = url('/').'/buyer/order/view/'.base64_encode($order_details['id']);

            //     $from_user_id = 0;
            //     $admin_id     = 0;
            //     // $user_name    = "";

            //     if(Sentinel::check())
            //     {
            //         $user_details = Sentinel::getUser();
            //         // $user_name    = $user_details->user_name;
            //         $to_user_id   = $user_details->id; 
            //     }

            //     $admin_role = Sentinel::findRoleBySlug('admin');        
            //     $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
            //     if($admin_obj)
            //     {
            //         $from_user_id = $admin_obj->user_id;
            //     }


            //     $arr_event                 = [];
            //     $arr_event['from_user_id'] = $from_user_id;
            //     $arr_event['to_user_id']   = $to_user_id;
            //     $arr_event['description']  = html_entity_decode('Your order with order no. <a target="_blank" href="'.$buyer_panel_order_url.'"><b>'.$order_details['order_no'].'</b></a> has been successfully cancelled');
            //     $arr_event['type']         = '';
            //     $arr_event['title']        = 'Order Cancelled';

            //     $this->GeneralService->save_notification($arr_event);

            // /*******************Send Notification to Buyer (END) ***************************/

            // /*****************Send Mail Notification to Buyer(START)************************/
            //     $msg    = html_entity_decode('Your order with order no. <b>'.$order_details['order_no'].'</b> has been successfully cancelled');
                       
            //     $subject     = 'Order Cancelled';

            //     $arr_built_content = ['USER_NAME'     => $user_name,
            //                           'APP_NAME'      => config('app.project.name'),
            //                           'MESSAGE'       => $msg,
            //                           'URL'           => $buyer_panel_order_url
            //                          ];

            //     $arr_mail_data['email_template_id'] = '31';
            //     $arr_mail_data['arr_built_content'] = $arr_built_content;
            //     $arr_mail_data['arr_built_subject'] = $subject;
            //     $arr_mail_data['user']              = Sentinel::findById($to_user_id);

            //     $this->EmailService->send_notification_mail($arr_mail_data);  

            // /*****************Send Mail Notification to Buyer(END)**************************/
       
            $response['status']      = 'SUCCESS';
            $response['description'] = 'Order cancelled successfully'; 
            return response()->json($response);
        }
   
    }

    public function submit_order_note(Request $request) {

      $order_no   = 0;
      $order_note = $request->input('order_note');
      $order_id   = base64_decode($request->input('order_id'));
      $buyers_id  = base64_decode($request->input('buyers_id'));

      $note_update = $this->OrderModel
                          ->where('id' , $order_id )
                          ->update(['note'=> $order_note ]);

      if ($note_update) {

        $order_obj = $this->OrderModel
                            ->where('id' , $order_id )
                            ->first();
        if ($order_obj) {

          $order_no  = $order_obj->order_no;
        }

        $buyer_panel_order_url = url('/').'/buyer/order/view/'.base64_encode($order_id);
 
        $seller_obj = Sentinel::getUser();
        $buyers_obj = Sentinel::findById($buyers_id);

        /******************* Send Email to Buyer (START)  *************************/

          $arr_built_content = ['USER_NAME'     => $buyers_obj->first_name .' '.$buyers_obj->last_name,
                                'APP_NAME'      => config('app.project.name'),
                                'MESSAGE'       => 'A note has been added by dispensary '.$seller_obj->first_name.' to order no. '.$order_no,
                                'SELLER_NAME'   => $seller_obj->first_name .' '.$seller_obj->last_name,
                                'ORDER_NO'      => $order_no,
                                'URL'           => $buyer_panel_order_url
                               ];

          $arr_built_subject =  [
                                  'ORDER_NO'      => $order_no
                                ];                   

          $arr_mail_data['email_template_id'] = '141';
          $arr_mail_data['arr_built_content'] = $arr_built_content;
          $arr_mail_data['arr_built_subject'] = $arr_built_subject;
          $arr_mail_data['user']              = Sentinel::findById($buyers_id);
          $arr_mail_data['order_number']      = $order_no;

          $this->EmailService->send_mail_section_order($arr_mail_data);

        /******************* Send Email to Buyer (End)  *************************/

          $from_user_id = 0;
          $admin_id     = 0;

        /******************* Send Notification to Buyer (START)  *************************/

          if(Sentinel::check()) {

            $user_details = Sentinel::getUser();
            $from_user_id = $user_details->id; 
          }

          $arr_event                 = [];
          $arr_event['from_user_id'] = $from_user_id;
          $arr_event['to_user_id']   = $buyers_id;
          $arr_event['description']  = html_entity_decode('A note has been added by dispensary '.$seller_obj->first_name.' to order no. <a target="_blank" href="'.$buyer_panel_order_url.'"><b>'.$order_no.'</b></a>');
          $arr_event['type']         = '';
          $arr_event['title']        = 'A note has been added by dispensary '.$seller_obj->first_name.' for order '.$order_no.'.';

          $this->GeneralService->save_notification($arr_event);

        /******************* Send Notification to Buyer (END)  *************************/

        $admin_role = Sentinel::findRoleBySlug('admin');        
        $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();

        if($admin_obj) {

          $admin_id = $admin_obj->user_id;
        }

        $admin_detail_obj = Sentinel::findById($admin_id);

        $admin_panel_order_url = url('/').'/book/order/view/'.base64_encode($order_no).'/'.base64_encode($order_id);

        /******************* Send Email to Admin (START)  *************************/

          $arr_built_content = ['USER_NAME'     => $admin_detail_obj->first_name .' '.$admin_detail_obj->last_name,
                                'APP_NAME'      => config('app.project.name'),
                                'MESSAGE'       => 'A note has been added by dispensary '.$seller_obj->first_name.' to order no. '.$order_no,
                                'SELLER_NAME'   => $seller_obj->first_name .' '.$seller_obj->last_name,
                                'ORDER_NO'      => $order_no,
                                'URL'           => $admin_panel_order_url
                               ];

          $arr_built_subject =  [
                                  'ORDER_NO'      => $order_no
                                ];                   

          $arr_mail_data['email_template_id'] = '141';
          $arr_mail_data['arr_built_content'] = $arr_built_content;
          $arr_mail_data['arr_built_subject'] = $arr_built_subject;
          $arr_mail_data['user']              = Sentinel::findById($admin_role->id);
          $arr_mail_data['order_number']      = $order_no;

          $this->EmailService->send_mail_section_order($arr_mail_data); 

        /******************* Send Email to Admin (End)  *************************/

        /******************* Send Notification to Admin (START)  *************************/

          $arr_event                 = [];
          $arr_event['from_user_id'] = $from_user_id;
          $arr_event['to_user_id']   = $admin_id;
          $arr_event['description']  = html_entity_decode('A note has been added by dispensary '.$seller_obj->first_name.' to order no. <a target="_blank" href="'.$admin_panel_order_url.'"><b>'.$order_no.'</b></a>');
          $arr_event['type']         = '';
          $arr_event['title']        = 'A note has been added by dispensary '.$seller_obj->first_name.' for order '.$order_no.'.';

          $this->GeneralService->save_notification($arr_event);

        /******************* Send Notification to Admin (END)  *************************/

        $response['status']      = 'SUCCESS';
        $response['description'] = 'Note updated successfully'; 

        return response()->json($response);
      }
      else {

        $response['status']      = 'ERROR';
        $response['description'] = 'Error While Updating note'; 

        return response()->json($response);
      }
    }
}
 