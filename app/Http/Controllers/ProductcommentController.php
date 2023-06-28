<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;

use App\Models\UserModel;
use App\Models\CountriesModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Models\RoleUserModel;
use App\Models\GeneralSettingsModel;
use App\Models\TradeRatingModel;
use App\Models\ShippingAddressModel;
use App\Models\ProductModel;
use App\Models\ProductCommentModel;


use App\Common\Services\EmailService;
use Flash;
use Validator;
use Sentinel;
use Activation;
use Reminder;
use DB;
use Datatables;

class ProductcommentController extends Controller
{
    use MultiActionTrait;

    public function __construct(UserModel $user,
                                CountriesModel $country,
                                ActivityLogsModel $activity_logs,
                                BuyerModel $buyerModel,
                                SellerModel $sellerModel,
                                RoleUserModel $roleUserModel,
                                EmailService $EmailService,
                                GeneralSettingsModel $GeneralSettingsModel,
                                TradeRatingModel $TradeRatingModel,
                                ShippingAddressModel $ShippingAddressModel,
                                ProductModel $ProductModel,
                                ProductCommentModel $ProductCommentModel
                                )
    {
        $user = Sentinel::createModel();

        $this->EmailService                 = $EmailService;
        $this->UserModel                    = $user;
        $this->BaseModel                    = $this->UserModel;   // using sentinel for base model.
        $this->CountriesModel               = $country;
        $this->ActivityLogsModel            = $activity_logs;
        $this->BuyerModel                   = $buyerModel;
        $this->SellerModel                  = $sellerModel;
        $this->RoleUserModel                = $roleUserModel;
        $this->GeneralSettingsModel         = $GeneralSettingsModel;
        $this->TradeRatingModel             = $TradeRatingModel;
        $this->ShippingAddressModel         = $ShippingAddressModel;
        $this->ProductModel                 = $ProductModel;
        $this->ProductCommentModel          = $ProductCommentModel;

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->user_id_proof                = url('/').config('app.project.id_proof');

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/comment");
        $this->module_title                 = "Product Comments";
        $this->modyle_url_slug              = "Product Comments";
        $this->module_view_folder           = "admin.productcomments";
       
    }   

    public function index()
    {
        $this->arr_view_data['arr_data'] = array();
        $obj_data = $this->BaseModel->whereHas('roles',function($query)
                                        {
                                            $query->where('slug','!=','admin');        
                                        })
                                    //->with(['user'])
                                    ->get();

        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }   

        $this->arr_view_data['page_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $arr_data;
        

        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }

    public function get_comment_details(Request $request)
    {
        $comment_details  = $this->ProductCommentModel->getTable();
        $prefixed_comment_details  = DB::getTablePrefix().$this->ProductCommentModel->getTable();

        $buyer_details           = $this->BuyerModel->getTable();        
        $prefixed_buyer_details  = DB::getTablePrefix().$this->BuyerModel->getTable();

        $seller_details          = $this->SellerModel->getTable();
        $prefixed_seller_details  = DB::getTablePrefix().$this->SellerModel->getTable();

        $product_details         = $this->ProductModel->getTable();
        $prefix_product_detail   = DB::getTablePrefix().$this->ProductModel->getTable();

        $user_details            = $this->UserModel->getTable();
        $prefix_user_detail   = DB::getTablePrefix().$this->UserModel->getTable();

         
              /*$obj_comment = DB::table($comment_details)->select(DB::raw( $comment_details.'*,'.$prefix_user_detail.".user_name as seller_name,".$prefix_product_detail.".product_name as product_name"))
              ->leftjoin($prefix_user_detail,$prefix_user_detail.".id","=",$prefixed_comment_details.".buyer_id")
              ->leftjoin($prefix_user_detail,$prefix_user_detail.".id","=",$prefixed_comment_details.".seller_id")
              ->leftjoin($prefix_product_detail,$prefix_product_detail.".id","=",$prefixed_comment_details.".product_id")->orderBy($comment_details.'.created_at','DESC')->toSql();*/

            $obj_comment = DB::table($comment_details)->select(DB::raw( $comment_details.'.*'))->get();
                   
      //  dd($obj_comment);
         return $obj_comment;
                                    
    }


    function get_users_details(Request $request)
    {
        $user_details           = $this->BaseModel->getTable();
        
        $prefixed_user_details  = DB::getTablePrefix().$this->BaseModel->getTable();

        $buyer_details           = $this->BuyerModel->getTable();        
        $prefixed_buyer_details  = DB::getTablePrefix().$this->BuyerModel->getTable();

        $seller_details           = $this->SellerModel->getTable();        
        $prefixed_seller_details  = DB::getTablePrefix().$this->SellerModel->getTable();

        $rating_tbl              = $this->TradeRatingModel->getTable();        
        $prefixed_rating_tbl     = DB::getTablePrefix().$this->TradeRatingModel->getTable();
        DB::enableQueryLog();
        $obj_user = DB::table($user_details)
                                ->select(DB::raw($prefixed_user_details.".id as id,".
                                                 $prefixed_user_details.".email as email, ".
                                                 $prefixed_user_details.".is_active as is_active, ".
                                                 $prefixed_user_details.".user_type, ".
                                                 $prefixed_user_details.".state, ".
                                                 $prefixed_buyer_details.".user_id as buyer_user_id, ".
                                                 // $prefixed_buyer_details.".crypto_symbol as buyer_crypto_symbol, ".
                                                 // $prefixed_buyer_details.".crypto_wallet_address as buyer_crypto_wallet_address, ".
                                                 // $prefixed_seller_details.".crypto_symbol as seller_crypto_symbol, ".
                                                 // $prefixed_seller_details.".crypto_wallet_address as seller_crypto_wallet_address, ".
                                                 $prefixed_seller_details.".user_id as seller_user_id, ".
                                                 $prefixed_user_details.".user_name as user_name, ".
                                                 $prefixed_user_details.".is_trusted"
                                                 // "(SELECT AVG(internal_rating.points) 
                                                 //    FROM ".$rating_tbl." as internal_rating
                                                 //    INNER JOIN ".$user_details." as internal_user_details
                                                 //       ON internal_rating.seller_user_id = internal_user_details.id WHERE internal_rating.type='1') as avarage_rating"))
                                             ))

                         ->leftjoin($prefixed_buyer_details,$prefixed_buyer_details.'.user_id','=',$prefixed_user_details.'.id')
                                ->leftjoin($prefixed_seller_details,$prefixed_seller_details.'.user_id','=',$prefixed_user_details.'.id')
                                // ->leftjoin($rating_tbl,$prefixed_rating_tbl.'.seller_user_id','=',$prefixed_user_details.'.id')
                                ->whereNull($user_details.'.deleted_at')
                                ->where($user_details.'.id','!=',1)
                                ->orderBy($user_details.'.created_at','DESC');
                                // ->get();

        // dd($obj_user);
           

            // dd($avg);
        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
        {
            $search_term      = $arr_search_column['q_name'];
            $obj_user = $obj_user->having('user_name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_term      = $arr_search_column['q_email'];
            $obj_user = $obj_user->where($user_details.'.email','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_user_type']) && $arr_search_column['q_user_type']!="")
        {
           $search_term       = $arr_search_column['q_user_type'];
            $obj_user   = $obj_user->where($prefixed_user_details.'.user_type','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_status']) && $arr_search_column['q_status']!="")
        {
           $search_term       = $arr_search_column['q_status'];
            $obj_user   = $obj_user->where($prefixed_user_details.'.is_active','LIKE', '%'.$search_term.'%');
        }

        return $obj_user;
    }

    // FUNCTION TO SHOW RECORDS OF COMMENT

    public function get_records(Request $request)
    {
        
       /* $obj_user = $this->ProductCommentModel->with(['seller_detail',
                                             'buyer_detail',
                                             'product_detail',
                                         ]);*/


        $obj_user     = $this->get_comment_details($request);

        $current_context = $this;

        $json_result     = Datatables::of($obj_user);

        $json_result     = $json_result->blacklist(['id']);
        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                

                                $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);

                                $confirm_delete = 'onclick="confirm_delete(this,event);"';
                                
                                $build_delete_action = '<a class="btn btn-circle btn-danger btn-outline show-tooltip" '.$confirm_delete.' href="'.$delete_href.'" title="Delete"><i class="ti-trash" ></i></a>';


                                return $build_action = $build_delete_action;
                            })
                        
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

    

    public function delete($enc_id)
    {

        $product_comment_id = isset($enc_id)?base64_decode($enc_id):false;

        if($product_comment_id)
        {
            $delete_success = $this->ProductCommentModel->where('id',$product_comment_id)->delete(); 
            
            if($delete_success)
            {
                Flash::success(str_singular($this->module_title).' Deleted Successfully');
            }
            else
            {
                Flash::error('Problem Occurred, While Deleting '.str_singular($this->module_title));    
            }
            return redirect()->back();
        }
        
    }

    
    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('Please Select '.str_plural($this->module_title) .' To Perform Multi Actions');  
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

       

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect()->back();

        }
        
        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
               $this->perform_delete(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Deleted Successfully'); 
            } 
          
        }

        return redirect()->back();
    }



    public function perform_delete($id)
    {
        $entity          = $this->ProductCommentModel->where('id',$id)->first();
    
        if($entity)
        {
           
              $this->ProductCommentModel->where('id',$id)->delete();     

              Flash::success(str_plural($this->module_title).' Deleted Successfully');
              return true; 
        }
        else
        {
          Flash::error('Problem Occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }
  

   

    public function build_select_options_array(array $arr_data,$option_key,$option_value,array $arr_default)
    {

        $arr_options = [];
        if(sizeof($arr_default)>0)
        {
            $arr_options =  $arr_default;   
        }

        if(sizeof($arr_data)>0)
        {
            foreach ($arr_data as $key => $data) 
            {
                if(isset($data[$option_key]) && isset($data[$option_value]))
                {
                    $arr_options[$data[$option_key]] = $data[$option_value];
                }
            }
        }

        return $arr_options;
    }

    
}
