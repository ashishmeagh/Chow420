<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller; 
use App\Common\Traits\MultiActionTrait;

use App\Common\Services\GeneralService;
use App\Common\Services\UserService;
use App\Models\HighlightModel;

use DB;
use Flash;
use Image;
use Sentinel;
use Validator; 
use Datatables;
 
class HighlightsController extends Controller
{
    use MultiActionTrait;

    public function __construct(
                                GeneralService $GeneralService,
                                UserService $UserService,
                                HighlightModel $HighlightModel
                                )
    {
        $user = Sentinel::createModel();

        $this->GeneralService               = $GeneralService;   
        $this->UserService                  = $UserService;
        $this->HighlightModel               = $HighlightModel;

        $this->highlight_image_base_img_path  = base_path().config('app.project.img_path.highlights');
        $this->highlight_public_img_path      = url('/').config('app.project.img_path.highlights');        

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/highlights");
        $this->product_imageurl_path        = url(config('app.project.product_images'));

        $this->module_title                 = "Highlights";
        $this->module_view_folder           = "admin.highlights";
    }   

    public function index() {

        $this->arr_view_data['arr_data'] = array();

         $get_highlights = $this->HighlightModel->where('is_active','1')->get();
        if(isset($get_highlights) && !empty($get_highlights))
        {
          $get_highlights = $get_highlights->toArray();
        }
        $this->arr_view_data['get_highlights'] = isset($get_highlights)?$get_highlights:[];
        
        $this->arr_view_data['page_title']              = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']            = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']         = $this->module_url_path;
        $this->arr_view_data['product_imageurl_path']   = $this->product_imageurl_path;

        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }

    public function create() {

        $arr_category  = $arr_unit = [];


        $this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function save(Request $request) 
    {

     /* $highlight_obj = $this->HighlightModel->get();

      if ($highlight_obj) {

        $count = $highlight_obj->toArray();
        
        if (sizeof($count) >= 3) {

          $response['status']      = 'error';
          $response['description'] = 'Cannot add more than 3 Highlights.';

            return response()->json($response);
        }
      }*/


        $form_data = $request->all();
        $is_update_process = false; 
         $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];

        if($is_update_process == false) {

            $arr_rules = [
                            'title'         => 'required',
                            'description'   => 'required',
                            'hilight_image'         => 'required'
                         ];
        } 

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails()) {

            $response['status']      = 'error';
            $response['description'] = 'Form validation failed..please check all required fields..';

            return response()->json($response);
        }

        if ($request->hasFile('hilight_image')) {

           $file_extension = strtolower($request->file('hilight_image')->getClientOriginalExtension());

           if(!in_array($file_extension,['jpg','png','jpeg'])) {

                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';

                return response()->json($response);
            }
        } 



         /********************for highlight image*******************/
        $file_name = '';
        if($request->hasFile('hilight_image'))
        { 
          $file = $request->file('hilight_image');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
          //  $image1->resize(1920,600); // commented
            // $image1->resize(226,200);  //old
            $image1->save($this->highlight_image_base_img_path.'/'.$file_name);

            $unlink_old_img_path    = $this->highlight_image_base_img_path.'/'.$request->input('old_img');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_name = $request->input('old_img');
        }
        /********************for slider image***************************/




          /* Main Model Entry */
       $highlights = $this->HighlightModel->firstOrNew(['id' => $id]);
       $highlights->title  = isset($form_data['title'])?$form_data['title']:'';
       $highlights->description  = isset($form_data['description'])?$form_data['description']:'';
       $highlights->hilight_image  = isset($file_name)?$file_name:'';
       $highlights->save();

       if($highlights)
       {
             if($is_update_process == false)
            {
                 $response['link'] =$this->module_url_path;             
            }
            else
            {
                 $response['link'] =$this->module_url_path;              
            }


             if($is_update_process == false)
            {

                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
                   //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'ADD';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added highlights '.$highlights->title.'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                  


                /*----------------------------------------------------------------------*/

               $response['status']      = "success";
               $response['description'] = "Highlights added successfully."; 
            }else{

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated highlights '.$highlights->title.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
               $response['status']      = "success";
               $response['description'] = "Highlights updated successfully."; 
            }



       }
       else
       {
          $response['status']      = "error";
          $response['description'] = "Error occurred while adding highlights.";
       }
        return response()->json($response);
    }//save

    public function get_productlist_details(Request $request) 
    {      
        $highlight_details  = $this->HighlightModel->getTable();
        $prefix_highlight   = DB::getTablePrefix().$this->HighlightModel->getTable();

        $obj_product = DB::table($highlight_details)->select()
                       ->orderBy($prefix_highlight.'.id','asc');

         $arr_search_column = $request->input('column_filter');

         if(isset($arr_search_column['q_title']) && $arr_search_column['q_title'] != '') {

              $search_title  = $arr_search_column['q_title'];
              $obj_product   = $obj_product->where('title','LIKE', '%'.$search_title.'%');
          }

          if(isset($arr_search_column['q_description']) && $arr_search_column['q_description'] != '') {

              $search_description  = $arr_search_column['q_description'];
              $obj_product  = $obj_product->where('description','LIKE', '%'.$search_description.'%');
          }

          if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '') {

              $search_status_term1  = $arr_search_column['q_status'];
              $obj_product  = $obj_product->where('is_active','LIKE', '%'.$search_status_term1.'%');
          }
                             
         return $obj_product;
    }

    public function get_records(Request $request)
    {
             
        $obj_user         = $this->get_productlist_details($request);
        $current_context  = $this;
        $json_result      = Datatables::of($obj_user);
        $json_result      = $json_result->blacklist(['id']);        
        $json_result      = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                              ->editColumn('image',function($data) use ($current_context)
                            {
                               if(isset($data->hilight_image) && !empty($data->hilight_image)) {

                                   //$data->hilight_image;

                                  return "<div class='emojiiconsnew'><img src=".$this->highlight_public_img_path.'/'.$data->hilight_image." width='120px'/>  </div>"; 

                                 /*if (strlen($data->title) > 30){

                                  return substr($data->title, 0, 30) . '...'; 
                                }
                                else {

                                }
*/
                               }
                                else{

                                  return 'NA';
                                }
                            })

                            ->editColumn('title',function($data) use ($current_context)
                            {
                               if(isset($data->title) && !empty($data->title)) {

                                  return $data->title; 
                                 /*if (strlen($data->title) > 30){

                                  return substr($data->title, 0, 30) . '...'; 
                                }
                                else {

                                }
*/
                               }
                                else{

                                  return 'NA';
                                }
                            })
                            ->editColumn('description',function($data) use ($current_context)
                            {
                               if(isset($data->description) && !empty($data->description)) {

                                  return $data->description; 
                                /*if (strlen($data->description) > 30){

                                  return substr($data->description, 0, 30) . '...'; 
                                }
                                else {

                                }*/
                                
                               }
                                else{
                                  return 'NA';
                                }
                            })       
                            ->editColumn('build_status_btn',function($data) use ($current_context)
                            {
                                $build_status_btn ='';

                                if($data->is_active == '0')
                                {   

                                    $build_status_btn = '<input type="checkbox" data-size="small" data-enc_id="'.base64_encode($data->id).'"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                elseif($data->is_active == 1)
                                {
                                   
                                    $build_status_btn = '<input type="checkbox" checked data-size="small"  data-enc_id="'.base64_encode($data->id).'"  id="status_'.$data->id.'" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />';
                                }
                                return $build_status_btn;
                            }) 

                                                     
                            ->editColumn('build_action_btn',function($data) use ($current_context) {

                              $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                              $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                              $view_href =  $this->module_url_path.'/view/'.base64_encode($data->id);

                              $build_view_action = '<a class="eye-actn" href="'.$view_href.'" title="View">View</a>';

                              $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                              $confirm_delete = 'onclick="confirm_delete(this,event);"';

                              $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';

                              return $build_action = $build_edit_action.' '.$build_view_action.''.$build_delete_action;
                            })
                        
                            ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
    }

   public function get_second_level_category(Request $request)
    {   
        $arr_second_level_category   = [];
        $first_level_category_id     = $request->input('first_level_category_id');

        $arr_second_level_category   = $this->SecondLevelCategoryModel->where('first_level_category_id',$first_level_category_id)->where('is_active','1')
                                       ->get()
                                       ->toArray();

        $response['second_level_category'] = isset($arr_second_level_category)?$arr_second_level_category:[]; 
        return $response;
    }

     public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->HighlightModel->where('id', $id)->first();   

        $arr_product = [];

        if($obj_data) {

           $arr_highlight = $obj_data->toArray(); 
        }

        $this->arr_view_data['arr_highlight']            = isset($arr_highlight) ? $arr_highlight : []; 
        $this->arr_view_data['highlight_public_img_path']  = $this->highlight_public_img_path;
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['page_title']               = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']             = $this->module_title;

      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    } 
    

    public function multi_action(Request $request)
    {
        $user = Sentinel::check();
         
        $flag = "";

        /*Check Validations*/
        $input = request()->validate([
                'multi_action' => 'required',
                'checked_record' => 'required'
            ], [
                'multi_action.required' => 'Please  select record required',
                'checked_record.required' => 'Please select record required'
            ]);

        $multi_action   = $request->input('multi_action');
        $checked_record = $request->input('checked_record');


        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Flash::error('Problem occurred, while doing multi action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {  
                $flag = "del";
               $this->perform_delete(base64_decode($record_id),$flag);    
               Flash::success(str_plural($this->module_title).' deleted successfully'); 

            } 
            elseif($multi_action=="activate")
            { 
                $flag = "activate";

               $this->perform_activate(base64_decode($record_id),$flag); 
               Flash::success(str_plural($this->module_title).' activated successfully');

            }
            elseif($multi_action=="deactivate")
            { 
                $flag = "deactivate";

               $this->perform_deactivate(base64_decode($record_id),$flag);    
               Flash::success(str_plural($this->module_title).' blocked successfully');  
            }
        }

        if($multi_action=="delete")
        {
          /*-------------------------------------------------------
                |   Activity log Event
                 --------------------------------------------------------*/
              
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'Delete';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on products.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

    
              /*----------------------------------------------------------------------*/
        }

        if($multi_action=="activate")
        {
           /*-------------------------------------------------------
                |   Activity log Event
                 --------------------------------------------------------*/
              
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on products.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

    
              /*----------------------------------------------------------------------*/
        }

        if($multi_action=="deactivate")
        {
            /*-------------------------------------------------------
                |   Activity log Event
                 --------------------------------------------------------*/
              
                //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DEACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on products.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

    
               /*----------------------------------------------------------------------*/
        }

        return redirect()->back(); 
    }


    public function activate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        $arr = $this->perform_activate(base64_decode($enc_id));

         if($arr)
        {
           $arr_response['status'] = 'SUCCESS';
           $arr_response['msg'] = '' ;
            
        }   
        else
        {
          $arr_response['status'] = 'ERROR';
          $arr_response['msg'] = $msg ;
        }

        $arr_response['data'] = 'ACTIVE';
        return response()->json($arr_response);
    }

    public function deactivate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_deactivate(base64_decode($enc_id))) {

            $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']   = 'Please activate the category and subcatgory of this product';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }


    public function perform_activate($id,$flag=false)
    {
        $user = Sentinel::check();

        $arr = [];  
        $entity = $this->HighlightModel->where('id',$id)->first();
        
        if($entity)
        {

           return $this->HighlightModel->where('id',$id)->update(['is_active'=>'1']);
          
        }// if entity

        return FALSE;
    }

 
    public function perform_deactivate($id,$flag =false)
    {
        $entity = $this->HighlightModel->where('id',$id)->first();

        if($entity) {

          return $this->HighlightModel->where('id',$id)->update(['is_active'=>'0']);

        }
        return FALSE;
    }


    public function delete_images($id)
    {   
        $user = Sentinel::check();

        $entity = $this->ProductImagesModel->where('id',$id)->first();
        if($entity)
        {
            if($this->ProductImagesModel->where('id',$id)->delete())
            {

               $unlink_old_img_path    = $this->product_image_base_img_path.'/'.$entity->image;
                            
                if(file_exists($unlink_old_img_path))
                {
                    @unlink($unlink_old_img_path);  
                }

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
              //save sub admin activity log 

              if(isset($user) && $user->inRole('sub_admin'))
              {
                  $arr_event                 = [];
                  $arr_event['action']       = 'Delete';
                  $arr_event['title']        = $this->module_title;
                  $arr_event['user_id']      = isset($user->id)?$user->id:'';
                  $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted image.';

                  $result = $this->UserService->save_activity($arr_event); 
              }


            /*----------------------------------------------------------------------*/  

              $arr_response['status']      = 'SUCCESS';
              $arr_response['description'] = 'Image deleted successfully';

            }else{
               $arr_response['status']      = 'ERROR';
               $arr_response['description'] = 'Problem occured while deleting';
            }
            
        }else{
            $arr_response['status']      = 'ERROR';
            $arr_response['description'] = 'Problem occured while deleting';

        }
        return $arr_response;
    }

    
    
   

    public function delete($enc_id = FALSE)
    {   
        

        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {   

            //Flash::success(str_singular($this->module_title).' deleted successfully');
        }
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }

    public function perform_delete($id,$flag=false)
    {
        $user = Sentinel::check();

        $is_fav_prod     = "";
        $entity          = $this->HighlightModel->where('id',$id)->first();
    
        if($entity)
        {
            return $this->HighlightModel->where('id',$id)->delete();
        }
        return false;
    }



    public function view($productid)
    {
       $id = base64_decode($productid);

        $this->arr['arr_data'] = array();

        $obj_data = $this->HighlightModel->where('id' ,$id )->first();

        if ($obj_data) {
          $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['page_title']      = "Highlights Details";
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $arr_data; 
        $this->arr_view_data['highlight_public_img_path'] = $this->highlight_public_img_path;

        return view($this->module_view_folder.'.show', $this->arr_view_data);
    }
    public function Reviews($productid)
    {
        $productid = base64_decode($productid);
        $this->arr['arr_data'] = array();
        $obj_data    = $this->ProductService->get_product_details($productid);
       
        $this->arr_view_data['page_title']      = "Product Details"; 
        $this->arr_view_data['module_title']    = "Ratings & Reviews";
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $obj_data;  
        $this->arr_view_data['product_imageurl_path'] = $this->product_imageurl_path;
        $this->arr_view_data['product_id']      = $productid;
        return view($this->module_view_folder.'.ratingsreview', $this->arr_view_data); 
    } 

 
    public function get_reviews(Request $request,$productid)
    {
       
        $obj_ratings     = $this->ProductService->get_reviewsrating_details($request,$productid);

        $current_context = $this;
        $json_result     = Datatables::of($obj_ratings);
        $json_result     = $json_result->blacklist(['id']);        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })

                            ->editColumn('rating',function($data) use ($current_context)
                            {
                                $rating = $data->rating;
                                 if($rating==1){$rating_1 = 'one';}
                                 else if($rating==2){$rating_1 = 'two';}
                                 else if($rating==3){$rating_1 = 'three';}
                                 else if($rating==4){$rating_1 = 'four';}
                                 else if($rating==5){$rating_1 = 'five';}
                                 else if($rating==0.5){$rating_1 = 'zeropointfive';}
                                 else if($rating==1.5){$rating_1 = 'onepointfive';}
                                 else if($rating==2.5){$rating_1 = 'twopointfive';}
                                 else if($rating==3.5){$rating_1 = 'threepointfive';}
                                 else if($rating==4.5){$rating_1 = 'fourpointfive';}

                                 if($rating>0)
                                 {
                                  $starvar = "star-rate-".$rating_1.""; 
                                  $src =url('/').'/assets/front/images/'.$starvar.'.png';
                                  $img = "<img src=".$src." title=".$rating." >";
                                  return $img;

                                }else{

                                  return '-';
                                }
                                return $img;
                            })
                            ->editColumn('rated_on',function($data) use ($current_context)
                            {
                              $rate_date = $data->updated_at;
                              $datetime = explode(" ", $rate_date); 
                              $ratedondate = us_date_format($datetime[0]);
                              $ratedontime = time_format($datetime[1]);
                              return $ratedondate.' '.$ratedontime;

                            })
                            ->editColumn('buyer_name',function($data) use ($current_context)
                            {
                                if($data->buyer_id==0)
                                {
                                   if(isset($data->user_name) && !empty($data->user_name))
                                    return $data->user_name;
                                  else
                                    return 'NA';
                                }else
                                {
                                  return $data->buyer_name;
                                }
                            })

                             ->editColumn('review',function($data) use ($current_context)
                            {
                                if(isset($data->review))
                                { 
                                  if(strlen($data->review)>20)
                                    return substr($data->review,0,20)."..<a 
                                    reviews='".$data->review."' class='showreview ' style='color:black'> View Review</a>";
                                  else
                                    return $data->review;

                                }else
                                {
                                  return "NA";
                                }
                            })
                            

                            ->editColumn('emoji',function($data) use ($current_context)
                            {

                                if(isset($data->emoji) && !empty($data->emoji))
                                {
                                  $emojihtml = '<div class="emojiiconsnew">';
                                  $exp_emoji = explode(",",$data->emoji);
                                  foreach($exp_emoji as $k=>$v)
                                  {
                                    $emojihtml .= "<div class='emojiiconsnew'><img src=".url('/')."/assets/images/".$v." width='32px'/> " .ucfirst($v)." </div>";
                                  }//foreach
                                  return $emojihtml; 
                                }//if
                            })
                             ->editColumn('build_action_btn',function($data) use ($current_context,$productid)
                            {   
                               
                                $edit_href =  $this->module_url_path.'/editreview/'.base64_encode($productid).'/'.base64_encode($data->id);
                                $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';
                            
                                return $build_action = $build_edit_action;
                            })
                           ->make(true);

        $build_result = $json_result->getData();
        return response()->json($build_result);
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


    public function approvedisapprove(Request $request)
    {

     //   $product_id = base64_decode($request->product_id);
        $product_id = $request->product_id;

        $verification_status  = $request->status;

        $user = Sentinel::check();

        $is_available = $this->ProductModel->where('id',$product_id)->count()>0;

        
        if($is_available)
        {

              $res_product = $this->ProductModel->select('*')
                            ->where('id',$product_id)  
                            ->get();

              if(!empty($res_product) && count($res_product)>0)
              {
                $res_product    = $res_product->toArray();
                $seller_id      = $res_product[0]['user_id'];
                $product_name   = $res_product[0]['product_name'];

              }
 


            if($verification_status==1)
            {
                $update_field = 1;
            }
            else if($verification_status==2)
            {
                $update_field = 2;
            }


            $status = $this->ProductModel->where('id',$product_id)->update(['is_approve'=>$update_field]);

            if($status)
            {       
                
                $response['status']      = 'SUCCESS';
                
                if($verification_status==1)
                {

                      $url     = url('/').'/seller/product/view/'.base64_encode($product_id);

                      /********************send notification and email of product approve**********/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>approved</b> the product <a target="_blank" href="'.$url.'"><b>'.$product_name.'</b></a>.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product approved';
                            $this->GeneralService->save_notification($arr_event);


                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                           /* $msg     = html_entity_decode(config('app.project.admin_name').' has approved your product <b>'. ucfirst($product_name).' </b>');

                            
                            $subject = 'Product approved';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '100';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '' ;
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                      /******end of send notification and email of product*approve********/

                     /***************start of eventdata**for newproduct*approve******/
                      $setname=''; 
                      $get_seller_businessname = $this->SellerModel->where('user_id',$seller_id)->first();
                      if(isset($get_seller_businessname) && !empty($get_seller_businessname))
                      {
                        $get_seller_businessname = $get_seller_businessname->toArray();
                        $busineename = $get_seller_businessname['business_name'];
                        if($busineename=="")
                        {
                          $setname = $f_name.''.$l_name;
                        }
                        else
                        {
                           $setname = $busineename;
                        }
                      }  

                      $arr_eventdata             = [];
                      $arr_eventdata['user_id']  = $from_user_id;

                      $get_product_name = $this->ProductModel
                                        // ->select('product_name','user_id')
                                         ->with(['get_seller_details','product_images_details'])
                                         ->where('id',$product_id)
                                         ->first();

                      if(!empty($get_product_name) && isset($get_product_name))
                      {
                          $get_product_name = $get_product_name->toArray();
                      }
                 
                       if(!empty($get_product_name['product_images_details']) 
                                         && count($get_product_name['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image']) &&$get_product_name['product_images_details'][0]['image']!='')
                       {
                          $imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];
                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }




                      $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div> <b>'.$setname.'</b> just added a new product to chow. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($product_id).'" target="_blank" class="viewcls">View</a>');
                      $arr_eventdata['title']    = 'Product Approve By Admin';             
                      // $this->EventModel->create($arr_eventdata);
                      /***************end of eventdata**for newproduct*******/


                      /*-------------------------------------------------------
                      |   Activity log Event
                      --------------------------------------------------------*/
                        
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'APPROVE';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has approved product '.$product_name.'.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }


                      /*----------------------------------------------------------------------*/


                      $response['message'] = str_singular($this->module_title).' approved successfully';
                }
                else
                {

                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                      //save sub admin activity log 

                      if(isset($user) && $user->inRole('sub_admin'))
                      {
                          $arr_event                 = [];
                          $arr_event['action']       = 'DISAPPROVE';
                          $arr_event['title']        = $this->module_title;
                          $arr_event['user_id']      = isset($user->id)?$user->id:'';
                          $arr_event['message']      = $user->first_name.' '.$user->last_name.' has disapproved product '.$product_name.'.';

                          $result = $this->UserService->save_activity($arr_event); 
                      }

                    /*----------------------------------------------------------------------*/

                    $response['message'] = str_singular($this->module_title).' disapproved successfully';
                }
                
            }
            else
            {
                $response['status']      = 'ERROR';
                $response['message']     = 'Problem occured while performing action';
            }
            
            return response()->json($response);
        }
        else
        {   
            $response['status']      = 'message';
            $response['message']     ='Something went wrong Please try again later';
            return response()->json($response);
        }
    }

    public function toggleChowsChoice(Request $request)
    {
        $user = Sentinel::check();

        $product_id           = base64_decode($request->product_id);
        $verification_status  = $request->status;

        $is_available         = $this->ProductModel->where('id',$product_id)->count()>0;
        
        if($is_available)
        {

              $res_product = $this->ProductModel->select('*')
                            ->where('id',$product_id)  
                            ->get();

              if(!empty($res_product) && count($res_product)>0)
              {
                $res_product    = $res_product->toArray();
                $seller_id      = $res_product[0]['user_id'];
                $product_name   = $res_product[0]['product_name'];

              }
 


            if($verification_status==1)
            {
                $update_field = 1;
            }
            else if($verification_status==0)
            {
                $update_field = 0;
            }


            $status = $this->ProductModel->where('id',$product_id)->update(['is_chows_choice'=>$update_field]);

            if($status)
            {       
                
                if($verification_status==1)
                {

                         $url     = url('/').'/seller/product/view/'.base64_encode($product_id);

                      /********************send notification and email of product approve**********/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>made</b> the product <b><a target="_blank" href="'.$url.'">'.$product_name.'</b></a> as chows choice');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product marked as chows choice';
                            $this->GeneralService->save_notification($arr_event);


                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                         /*   $msg     = html_entity_decode(config('app.project.admin_name').' has made your product <b>'.ucfirst($product_name).'</b> as chows choice.');

                            
                            $subject = 'Product marked as chows choice';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '101';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                      /******end of send notification and email of product*approve********/

                     /***************start of eventdata**for newproduct*approve******/
                      $setname=''; 
                      $get_seller_businessname = $this->SellerModel->where('user_id',$seller_id)->first();
                      if(isset($get_seller_businessname) && !empty($get_seller_businessname))
                      {
                        $get_seller_businessname = $get_seller_businessname->toArray();
                        $busineename = $get_seller_businessname['business_name'];
                        if($busineename=="")
                        {
                          $setname = $f_name.''.$l_name;
                        }
                        else
                        {
                           $setname = $busineename;
                        }
                      }  

                      $arr_eventdata             = [];
                      $arr_eventdata['user_id']  = $from_user_id;

                      $get_product_name = $this->ProductModel
                                        // ->select('product_name','user_id')
                                         ->with(['get_seller_details','product_images_details'])
                                         ->where('id',$product_id)
                                         ->first();

                      if(!empty($get_product_name) && isset($get_product_name))
                      {
                          $get_product_name = $get_product_name->toArray();
                      }
                 
                       if(!empty($get_product_name['product_images_details']) 
                                         && count($get_product_name['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image']) &&$get_product_name['product_images_details'][0]['image']!='')
                       {
                          $imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];
                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }




                      $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div> <b>'.$setname.'</b> just added a new product to chow. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($product_id).'" target="_blank" class="viewcls">View</a>');
                      $arr_eventdata['title']    = 'Product Marked as chows choice By Admin';             
                     // $this->EventModel->create($arr_eventdata);
                      /***************end of eventdata**for newproduct*******/


                      /*-------------------------------------------------------
                      |   Activity log Event
                      --------------------------------------------------------*/
                        
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'MARKED';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked product '.$product_name.' as a chow choice.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }

                      /*----------------------------------------------------------------------*/

                      $response['status']      = 'SUCCESS';
                      $response['message']     = str_singular($this->module_title).' marked as chows choice successfully';

                    $response['status']      = 'SUCCESS';
                    $response['message']     = str_singular($this->module_title)." marked as chow's choice successfully";

                }
                else
                {
                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'UNMARKED';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has removed product '.$product_name.' from chow choice.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                    /*----------------------------------------------------------------------*/

                    $response['message'] = str_singular($this->module_title)." removed from chow's choice successfully";
                }

           
                
            }
            else
            {
                $response['status']      = 'ERROR';
                $response['message']     = 'Problem occured while performing action';
            }
            
            return response()->json($response);
        }
        else
        {   
            $response['status']      = 'message';
            $response['message']     ='Something went wrong Please try again later';
            return response()->json($response);
        }
    }

    public function autosuggest(request $request)
    { 
       // dd($request->all());     
        if($request->query)
       {
          
           $productbrand = $this->BrandModel->getTable();
           $prefiex_productbrand = DB::getTablePrefix().$this->BrandModel->getTable();

            $query = $request['query']; 
            $data = DB::table($prefiex_productbrand)
              ->where('name', 'LIKE', "%{$query}%")
              ->get()->toArray();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

          if(isset($data) && !empty($data)){
            foreach($data as $row)
            {
             $output .= '
             <li class="liclick"><a href="#" >'.$row->name.'</a></li>
             ';
            }
          }else{
              $output .='<li><a href="#">Not Found</a></li>';
          } 
            $output .= '</ul>';
            echo $output;
       }


    }// end of function of autosuggest



    public function rejectproduct(Request $request)
    {
        $user = Sentinel::check();

 //       $product_id = base64_decode($request->product_id);
        $product_id = $request->product_id;
 
        $reason    = $request->reason;

        if($product_id && $reason)
        {    
            $res_product = $this->ProductModel->select('*')
                            ->where('id',$product_id)  
                            ->get();


             if(!empty($res_product) && count($res_product)>0)
             {

                $res_product = $res_product->toArray();

                $approve_status = $res_product[0]['is_approve'];
                $seller_id      = $res_product[0]['user_id'];
                $product_name      = $res_product[0]['product_name'];

             
                //if($approve_status=='1')
               // {   
               
                    $res_status_update = $this->ProductModel
                                    ->where('id',$product_id)
                                    ->update(['is_approve'=>'2','reason'=>$reason]);   
                    if($res_status_update)
                    {



                            $url     = url('/').'/seller/product/view/'.base64_encode($product_id);
                        /*********************Send Notification to seller (START)********************/
                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>disapproved</b> the product <a target="_blank" href="'.$url.'"><b>'.$product_name.'</b></a>.');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product disapproved';
                            $this->GeneralService->save_notification($arr_event);

                        /*******************Send Notification to seller (END)**************/


                         /***************Send Notification Mail to seller (START)************/
                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';
/*
                            $msg     = html_entity_decode(config('app.project.admin_name').' has disapproved your product <b>'. ucfirst($product_name).' </b>. <br>
                                    <b>Reason:</b> '.$reason.'');

                            
                            $subject = 'Product disapproved';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'       => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '102';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*********************Send Notification Mail to seller (END)*****************/
                        

                          /*-------------------------------------------------------
                          |   Activity log Event
                          --------------------------------------------------------*/
                            
                            //save sub admin activity log 

                            if(isset($user) && $user->inRole('sub_admin'))
                            {
                                $arr_event                 = [];
                                $arr_event['action']       = 'REJECT';
                                $arr_event['title']        = $this->module_title;
                                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has rejected product '.$product_name.'.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }

                       
                          /*----------------------------------------------------------------------*/

                          $response['status']      = 'SUCCESS';
                          $response['description'] = 'Product disapproved successfully.'; 
                          return response()->json($response);   
                    }            


               /* }else if($approve_status==0){

                      $response['status']      = 'ERROR';
                      $response['description'] = 'Product already disapproved'; 
                      return response()->json($response);   
                }*/
             }
        }
   
    }//end of reject


    public function removeproduct(Request $request)
    {

        $user = Sentinel::check();

        $product_id = base64_decode($request->product_id);
 
        $reason     = $request->reason;

        if($product_id && $reason)
        {    
            $res_product = $this->ProductModel->select('*')
                            ->where('id',$product_id)  
                            ->get();


             if(!empty($res_product) && count($res_product)>0)
             {

                $res_product = $res_product->toArray();

                $approve_status = $res_product[0]['is_chows_choice'];
                $seller_id      = $res_product[0]['user_id'];
                $product_name   = $res_product[0]['product_name'];

             
                //if($approve_status=='1')
               // {   
               
                    $res_status_update = $this->ProductModel
                                    ->where('id',$product_id)
                                    ->update(['is_chows_choice'=>0,'reason_for_removal_from_chows_choice'=>$reason]);


                    if($res_status_update)
                    {

                            $url     = url('/').'/seller/product/view/'.base64_encode($product_id);
                        /*********************Send Notification to seller (START)********************/
                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>removed </b> the product <b><a target="_blank" href="'.$url.'">'.$product_name.'</b></a> from chows choice');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product removed from  chows choice';
                            $this->GeneralService->save_notification($arr_event);

                        /*******************Send Notification to seller (END)**************/


                         /***************Send Notification Mail to seller (START)************/
                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                            /*$msg     = html_entity_decode(config('app.project.admin_name').' has removed your product <b>'.ucfirst($product_name).'</b> from chows choice. <br><b>Reason:</b> '.$reason.'');

                            
                            $subject = 'Product removed from chows choice';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  //'MESSAGE'     => $msg,
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  =>  ucfirst($product_name),
                                                  'REASON'        => $reason,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '103';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);

                        /*********************Send Notification Mail to seller (END)*****************/
                         
                          /*-------------------------------------------------------
                          |   Activity log Event
                          --------------------------------------------------------*/
                            
                            //save sub admin activity log 

                            if(isset($user) && $user->inRole('sub_admin'))
                            {
                                $arr_event                 = [];
                                $arr_event['action']       = 'REMOVE';
                                $arr_event['title']        = $this->module_title;
                                $arr_event['user_id']      = isset($user->id)?$user->id:'';
                                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has removed product '.$product_name.' from chow choice.';

                                $result = $this->UserService->save_activity($arr_event); 
                            }

                       
                          /*----------------------------------------------------------------------*/


                          $response['status']      = 'SUCCESS';
                          $response['description'] = "Product removed from chow's choice successfully."; 
                          return response()->json($response);   
                    }            


               /* }else if($approve_status==0){

                      $response['status']      = 'ERROR';
                      $response['description'] = 'Product already disapproved'; 
                      return response()->json($response);   
                }*/
             }
        }
   
    }//end of reject


    public function autosuggest_dropshipper(request $request)
    { 
       // dd($request->all());     
        if($request->query)
       {
          
           $prefiex_dropshipper = DB::getTablePrefix().$this->DropShipperModel->getTable();

            $query     = $request['query']; 
            $seller_id = $request['seller_id'];
            $data = DB::table($prefiex_dropshipper)
              ->where('name', 'LIKE', "%{$query}%")
              ->where('seller_id',$seller_id)
              ->groupBy('name')
              ->get()->toArray();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

          if(isset($data) && !empty($data)){
            foreach($data as $row)
            {
             $output .= '
             <li class="liclick"><a href="#" >'.$row->name.'</a></li>
             ';
            }
          }else{
              $output .='<li><a href="#">Not Found</a></li>';
          } 
            $output .= '</ul>';
            echo $output;
       }


    }// end of function of autosuggest

    public function get_dropshipper_details(request $request)
    {
        if($request->query)
       {
            $prefiex_dropshipper = DB::getTablePrefix().$this->DropShipperModel->getTable();

            $query     = $request['query']; 
            $seller_id = $request['seller_id'];

            $data = DB::table($prefiex_dropshipper)
                    ->where('name', 'LIKE', "%{$query}%")
                    ->where('seller_id',$seller_id)
                    ->get()->toArray();



           return json_encode($data);
       }
    } 


    public function chk_dropshipper_email_duplication(request $request)
    {

        if($request->query)
       {
            $prefiex_dropshipper = DB::getTablePrefix().$this->DropShipperModel->getTable();

            $query= $request['query']; 
            $data = DB::table($prefiex_dropshipper)
                    ->where('email',$query)
                    ->get()->toArray();
            if(sizeof($data) > 0)
            {

               echo"exists";
            } 
            else
            {
              echo"not exists";
            }
       }
    }//end function

     public function toggleOutofstock(Request $request)
    {



        $user = Sentinel::check();

        $product_id           = base64_decode($request->product_id);
        $verification_status  = $request->status;

        $is_available         = $this->ProductModel->where('id',$product_id)->count()>0;
        
        if($is_available)
        {

              $res_product = $this->ProductModel->select('*')
                            ->where('id',$product_id)  
                            ->get();

              if(!empty($res_product) && count($res_product)>0)
              {
                $res_product    = $res_product->toArray();
                $seller_id      = $res_product[0]['user_id'];
                $product_name   = $res_product[0]['product_name'];

              }
 


            if($verification_status==1)
            {
                $update_field = 1;
            }
            else if($verification_status==0)
            {
                $update_field = 0;
            }


            $status = $this->ProductModel->where('id',$product_id)->update(['is_outofstock'=>$update_field]);

            if($status)
            {       
                
                if($verification_status==1)
                {

                         $url     = url('/').'/seller/product/view/'.base64_encode($product_id);

                      /********************send notification and email of product approve**********/

                            $from_user_id = 0;
                            $admin_id     = 0;
                            $user_name    = "";

                            if(Sentinel::check())
                            {
                                $admin_details = Sentinel::getUser();

                                $from_user_id  = $admin_details->id;
                                $admin_name    = $admin_details->first_name.' '.$admin_details->last_name;
                            }
                           
                            $arr_event                 = [];
                            $arr_event['from_user_id'] = $from_user_id;
                            $arr_event['to_user_id']   = $seller_id;
                            $arr_event['description']  = html_entity_decode( config('app.project.admin_name').' has <b>made</b> the product <b><a target="_blank" href="'.$url.'">'.$product_name.'</b></a> as out of stock');
                            $arr_event['type']         = '';
                            $arr_event['title']        = 'Product marked as out of stock';
                            $this->GeneralService->save_notification($arr_event);


                            $to_user = Sentinel::findById($seller_id);

                            $f_name  = isset($to_user->first_name)?$to_user->first_name:'';
                            $l_name  = isset($to_user->last_name)?$to_user->last_name:'';

                         /*   $msg     = html_entity_decode(config('app.project.admin_name').' has made your product <b>'.ucfirst($product_name).'</b> as chows choice.');

                            
                            $subject = 'Product marked as chows choice';*/

                            $arr_built_content = ['USER_NAME'     => $f_name.' '.$l_name,
                                                  'APP_NAME'      => config('app.project.name'),
                                                  'ADMIN_NAME'    => config('app.project.admin_name'),
                                                  'PRODUCT_NAME'  => ucfirst($product_name),
                                                  //'MESSAGE'       => $msg,
                                                  'URL'           => $url
                                                 ];

                            $arr_mail_data['email_template_id'] = '136';
                            $arr_mail_data['arr_built_content'] = $arr_built_content;
                            $arr_mail_data['arr_built_subject'] = '';
                            $arr_mail_data['user']              = Sentinel::findById($seller_id);

                            $this->EmailService->send_mail_section($arr_mail_data);


                      /******end of send notification and email of product*approve********/

                     /***************start of eventdata**for newproduct*approve******/
                      $setname=''; 
                      $get_seller_businessname = $this->SellerModel->where('user_id',$seller_id)->first();
                      if(isset($get_seller_businessname) && !empty($get_seller_businessname))
                      {
                        $get_seller_businessname = $get_seller_businessname->toArray();
                        $busineename = $get_seller_businessname['business_name'];
                        if($busineename=="")
                        {
                          $setname = $f_name.''.$l_name;
                        }
                        else
                        {
                           $setname = $busineename;
                        }
                      }  

                      $arr_eventdata             = [];
                      $arr_eventdata['user_id']  = $from_user_id;

                      $get_product_name = $this->ProductModel
                                        // ->select('product_name','user_id')
                                         ->with(['get_seller_details','product_images_details'])
                                         ->where('id',$product_id)
                                         ->first();

                      if(!empty($get_product_name) && isset($get_product_name))
                      {
                          $get_product_name = $get_product_name->toArray();
                      }
                 
                       if(!empty($get_product_name['product_images_details']) 
                                         && count($get_product_name['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image']) &&$get_product_name['product_images_details'][0]['image']!='')
                       {
                          $imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];
                       }else{
                        $imgsrc = url('/').'/assets/front/images/chow.png';
                       }




                      $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                       <div class="mainmarqees-image">
                        <img src="'.$imgsrc.'" alt="">
                      </div> <b>'.$setname.'</b> just added a new product to chow. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($product_id).'" target="_blank" class="viewcls">View</a>');
                      $arr_eventdata['title']    = 'Product Marked as out of stock By Admin';             
                      //$this->EventModel->create($arr_eventdata);
                      /***************end of eventdata**for newproduct*******/


                      /*-------------------------------------------------------
                      |   Activity log Event
                      --------------------------------------------------------*/
                        
                        //save sub admin activity log 

                        if(isset($user) && $user->inRole('sub_admin'))
                        {
                            $arr_event                 = [];
                            $arr_event['action']       = 'MARKED';
                            $arr_event['title']        = $this->module_title;
                            $arr_event['user_id']      = isset($user->id)?$user->id:'';
                            $arr_event['message']      = $user->first_name.' '.$user->last_name.' has marked product '.$product_name.' as out of stock.';

                            $result = $this->UserService->save_activity($arr_event); 
                        }

                      /*----------------------------------------------------------------------*/

                      $response['status']      = 'SUCCESS';
                      $response['message']     = str_singular($this->module_title).' marked as out of stock successfully';

                    $response['status']      = 'SUCCESS';
                    $response['message']     = str_singular($this->module_title)." marked as out of stock successfully";

                }
                else
                {
                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                      
                    //save sub admin activity log 

                    if(isset($user) && $user->inRole('sub_admin'))
                    {
                        $arr_event                 = [];
                        $arr_event['action']       = 'UNMARKED';
                        $arr_event['title']        = $this->module_title;
                        $arr_event['user_id']      = isset($user->id)?$user->id:'';
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has removed product '.$product_name.' from out of stock.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }

                    /*----------------------------------------------------------------------*/
                    $response['status']      = 'SUCCESS';
                    $response['message'] = str_singular($this->module_title)." removed from out of stock successfully";
                }

           
                
            }
            else
            {
                $response['status']      = 'ERROR';
                $response['message']     = 'Problem occured while performing action';
            }
            
            return response()->json($response);
        }
        else
        {   
            $response['status']      = 'ERROR';
            $response['message']     ='Something went wrong Please try again later';
            return response()->json($response);
        }
    }//end function out of stock

      public function addreview($product_id=NULL)
    {
        $arr_category  = $arr_unit = [];
        $this->arr_view_data['page_title']      = "Add Review";
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['product_id'] = isset($product_id)?base64_decode($product_id):'';

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable(); 

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();
          
        return view($this->module_view_folder.'.addreview',$this->arr_view_data);
    }//addreview


    public function savereview(Request $request)
    { 
        $response = [];

        $user = Sentinel::check();

        $form_data = $request->all();

        $user_name  = isset($form_data['user_name'])?$form_data['user_name']:'';
        $title      = isset($form_data['title'])?$form_data['title']:'';
        $review     = isset($form_data['review'])?$form_data['review']:'';
        $emojiarr   = isset($form_data['emoji'])?$form_data['emoji']:'';
        $product_id  = isset($form_data['product_id'])?$form_data['product_id']:'';
        $rating      = isset($form_data['rating'])?$form_data['rating']:'';


        if(isset($emojiarr) && !empty($emojiarr))
        {
          $emojiarr = implode(",", $emojiarr);
        }


        $is_update_process = false; 

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }


        $arr_rules = [];
        if($is_update_process == false)
        {
            $arr_rules = [
                            'title' => 'required',
                      
                         ];
        } 
      
        if(isset($review) && !empty($review)){

        }else{  
            $response['status']      = 'warning';
            $response['description'] = 'Please enter review';
              return response()->json($response);
        }
        $validator = Validator::make($request->all(),$arr_rules);
       
       // dd($errors = $validator->errors());
        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all required fields..';

            return response()->json($response);
        }

          $product_review = $this->ReviewRatingsModel->firstOrNew(['id' => $id]);

        /*  $input_data = [
                        'product_id'     => $product_id,
                        'buyer_id'       => '',
                        //'rating'         => $rating,
                        'title'          => $title,
                        'review'         => $review,
                        'emoji'          => $emojiarr,
                        'user_name'      => $user_name
                        
                      ]; */
                      
       // $add_review = $this->ReviewRatingsModel->create($input_data);

         $product_review->product_id = $product_id;
         $product_review->title = $title;
         $product_review->review = $review;
         $product_review->emoji = $emojiarr;
         $product_review->user_name = $user_name;
         $product_review->rating = $rating;
         $product_review->save(); 
        if($product_review)
        {
  
            if($is_update_process == false)
            {
                if($product_review->id)
                {
                    $response['link'] = $this->module_url_path.'/Reviews/'.base64_encode($product_id);

                   // $response['link'] =$this->module_url_path.'/edit/'.base64_encode($productlist->id);
                }else{

                    $response['link'] = $this->module_url_path.'/Reviews/'.base64_encode($product_id);

                }
            }
            else
            {
                $response['link'] = $this->module_url_path.'/Reviews/'.base64_encode($product_id);
            }

            if($is_update_process==true)
            {
                  
                  $response['status']      = "success";
                  $response['description'] = "Review updated successfully."; 

            }
            else
            {
                  $response['status']      = "success";
                  $response['description'] = "Review added successfully."; 

            }
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding review.";
        }

        return response()->json($response);
    }//savereview


     public function editreview($product_id=NULL,$enc_id=NULL)
    {       

        $id   = base64_decode($enc_id);
       
        $obj_data = $this->ReviewRatingsModel->where('id', $id)->first();
    
        $arr_product_review = [];
        if($obj_data)
        {
           $arr_product_review = $obj_data->toArray(); 
        }
     

        $user_details      = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $Seller_details      = $this->SellerModel->getTable();
        $prefix_seller_detail = DB::getTablePrefix().$this->SellerModel->getTable();

        
        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['arr_product']              = isset($arr_product_review) ? $arr_product_review : []; 
        $this->arr_view_data['product_id'] = isset($product_id)?base64_decode($product_id):'';

        $this->arr_view_data['page_title']               = "Edit Review ";
        $this->arr_view_data['module_title']             = $this->module_title;
        return view($this->module_view_folder.'.editreview',$this->arr_view_data);   
    } //Edit review


}//end class
