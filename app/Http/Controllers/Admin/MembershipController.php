<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

use App\Models\MembershipModel;
use App\Common\Services\UserService;

use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;
 
 
class MembershipController extends Controller
{       
    use MultiActionTrait;

    public function __construct( MembershipModel $MembershipModel,
                                 UserService $UserService
                               ) 
    {
    	$this->BaseModel          = $MembershipModel;
        $this->UserService        = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->membership_public_img_path      = url('/').config('app.project.img_path.membership');
        $this->membership_base_path   = base_path().config('app.project.img_path.membership');
        $this->membership_imageurl_path   = url(config('app.project.membership'));


        $this->module_title       = "Membership Plans";
        $this->module_view_folder = "admin.membership";
        $this->module_url_path    = $this->admin_url_path."/membership";
    }


    public function index()
    {
        $this->arr_view_data['membership_imageurl_path'] = $this->membership_imageurl_path;

        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$membership_table          = $this->BaseModel->getTable();
        $prefixed_productbrand_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_membership_table = DB::table($membership_table)                           
        							 ->orderBy($membership_table.'.created_at','DESC');

        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');    
  
           if(isset($arr_search_column['q_name']) && $arr_search_column['q_name'] != '')
            {
                $search_name            = $arr_search_column['q_name'];
                $obj_membership_table   = $obj_membership_table->where('name','LIKE','%'.$search_name.'%');
            }

             if(isset($arr_search_column['q_price']) && $arr_search_column['q_price'] != '')
            {
                $search_price           = $arr_search_column['q_price'];
                $obj_membership_table   = $obj_membership_table->where('price','LIKE','%'.$search_price.'%');
            }

           /*  if(isset($arr_search_column['q_count']) && $arr_search_column['q_count'] != '')
            {
                $search_pcount          = $arr_search_column['q_count'];
                $obj_membership_table   = $obj_membership_table->where('product_count','LIKE','%'.$search_pcount.'%');
            }*/
          	
            if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
            {
                $search_status            = $arr_search_column['q_status'];
                $obj_membership_table   = $obj_membership_table->where('is_active','LIKE','%'.$search_status.'%');
            }




 
    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_membership_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })->editColumn('price',function($data) use ($current_context)
                        {
                            // if($data->price>0)
                            // {
                            //    // return '$'.rtrim(rtrim(strval($data->price), "0"), ".");
                            //     return '$'.number_format($data->price);
                            // }else
                            // {
                            //     return "Free";

                            // }

                            if($data->membership_type=="2")
                            {
                                return '$'.number_format($data->price);
                            }else
                            {
                                return "Free";
                            }


                        })
                        ->editColumn('image',function($data) use ($current_context)
                        {
                            if(isset($data->image) && !empty($data->image) && file_exists(base_path().'/uploads/membership/'.$data->image))
                            {
                                return '<img src="'.url('/').'/uploads/membership/'.$data->image.'" width="100" height="100"/>';
                            }else
                            {
                                return "NA";
                            }
                        })
                           ->editColumn('description',function($data) use ($current_context)
                        {
                            if(strlen($data->description)>50){
                               return '<p class="prod-desc">'.str_limit($data->description,50).'..<a class="readmorebtn" description="'.$data->description.'" style="cursor:pointer"><b>Read more</b></a></p>';
                            }
                            else{
                                return $data->description;
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

                        

                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                            $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                            $build_edit_action = '<a class="eye-actn" href="'.$edit_href.'" title="Edit">Edit</a>';

                            $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                            $confirm_delete = 'onclick="confirm_delete(this,event);"';

                            $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';
                            
                            
                            return $build_action = $build_edit_action;
                        })

                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }


    public function create()
    {
    	$this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_singular($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$form_data = $request->all();
      
        $user = Sentinel::check();

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
                            'name'     => 'required',
                            'price'     => 'required',
                            //'description'   => 'required',
                            'product_count' => 'required',
                         ];
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }

          if ($request->hasFile('image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('image')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        } 
          
        $member_price = isset($form_data['price'])?$form_data['price']:'';
    	
        if(isset($member_price) && !is_numeric($member_price))
        {
             $response['status']       = 'warning';
             $response['description']  = 'Please enter valid integer value as a price';
             return response()->json($response);
        }   
         
        /* Main Model Entry */
        $membership = $this->BaseModel->firstOrNew(['id' => $id]);

        $membership->name   =  isset($form_data['name'])?$form_data['name']:'';
        $membership->description   =  isset($form_data['description'])?$form_data['description']:'';
        $membership->product_count   =  isset($form_data['product_count'])?$form_data['product_count']:'';
        $membership->price   =  isset($form_data['price'])?$form_data['price']:'';

        if($request->is_active!='' && !empty($request->is_active)){
          $is_active  =  isset($form_data['is_active'])?$form_data['is_active']:'';  
        }else{
            $is_active =0;
        }

        if($request->membership_type!='' && !empty($request->membership_type)){
          $membership_type  =  isset($form_data['membership_type'])?$form_data['membership_type']:'';  
           
        }
        else
        {
            $membership_type  = "2";
        }

       /* if(isset($form_data['price']) && $form_data['price']>0){
             $membership->membership_type = '2';
        }else{
              $membership->membership_type = '1';
        }*/
        $membership->membership_type = $membership_type;

        $membership->is_active = $is_active;



         $file_name = '';
        if($request->hasFile('image'))
        {   
            $file = $request->file('image');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
            $image1->resize(300,250);
            $image1->save($this->membership_base_path.'/'.$file_name);

            $unlink_old_img_path    = $this->membership_base_path.'/'.$request->input('old_img');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_name = $request->input('old_img');
        }
        $membership->image  = $file_name;      



        $membership->save();

        if($membership)
        {

            if($is_update_process == false)
            {
                $response['link'] = $this->module_url_path;
            }
            else
            {
                $response['link'] = $this->module_url_path;
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
                        $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added membership '.$membership->name.'.';

                        $result = $this->UserService->save_activity($arr_event); 
                    }


                    /*----------------------------------------------------------------------*/

                    $response['status']      = "success";
                    $response['description'] = "Membership plan added successfully."; 
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
                    $arr_event['action']       = 'EDIT';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated membership '.$membership->name.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/

                  $response['status']      = "success";
                  $response['description'] = "Membership plan updated successfully."; 
            }

          
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding brand.";
        }

        return response()->json($response);
    }

    public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_membership = [];
        if($obj_data)
        {
           $arr_membership = $obj_data->toArray(); 
        }

        $this->arr_view_data['membership_public_img_path']  = $this->membership_public_img_path;
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_membership']   		 = isset($arr_membership) ? $arr_membership : [];  
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
                $flag = "active";
                

                $this->perform_activate(base64_decode($record_id),$flag); 
                Flash::success(str_plural($this->module_title).' activated successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
                $flag = "deactive";
               

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on membership.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on membership.';

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
                $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on membership.';

                $result = $this->UserService->save_activity($arr_event); 
            }

            /*----------------------------------------------------------------------*/
        }






        return redirect()->back();
    }

    public function delete($enc_id = FALSE)
    {
        
        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {
            
            Flash::success(str_singular($this->module_title).' deleted Successfully');
        }
        else
        {
            Flash::error('Problem occurred while deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }//single delete

    public function perform_delete($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity  = $this->BaseModel->where('id',$id)->first();
    
        if($entity)
        {
            $this->BaseModel->where('id',$id)->delete();

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
            //save sub admin activity log 
            if($flag==false)
            {
                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'Delete';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted membership.';

                    $result = $this->UserService->save_activity($arr_event); 
                }
            }
            

            /*----------------------------------------------------------------------*/

            Flash::success(str_plural($this->module_title).' deleted successfully');
            return true; 
        }
        else
        {
          Flash::error('Problem occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }//delete function


    public function activate(Request $request)
    {
        $enc_id = $request->input('id');

        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_activate(base64_decode($enc_id)))
        {
             $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
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

        if($this->perform_deactivate(base64_decode($enc_id)))
        {
            $arr_response['status'] = 'SUCCESS';
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']   = 'Sorry, you can not deactivate this brand,this brand is having some products.';
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }

    public function perform_activate($id,$flag=false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();
      
        if($entity)
        {   
            $entity_arr =  $entity->toArray();

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
            //save sub admin activity log 
            if($flag == false)
            {  
                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'ACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated membership '.$entity_arr['name'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                } 

            }
          

            /*----------------------------------------------------------------------*/



            return $this->BaseModel->where('id',$id)->update(['is_active'=>'1']);
        } 

        return FALSE;
    }//activate

 
    public function perform_deactivate($id,$flag=false)
    {
        $user = Sentinel::check();


        $entity = $this->BaseModel->where('id',$id)->first();

        if($entity)
        {
            $entity_arr =  $entity->toArray();

            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
              
            //save sub admin activity log 
            if($flag==false)
            { 
                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'DEACTIVATE';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated membership '.$entity_arr['name'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }
            }
           
           

            /*----------------------------------------------------------------------*/

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

        }

        return FALSE;
    }//deactivate

    

   

}
