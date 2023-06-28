<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TagsModel;
use App\Models\EventModel;


use App\Common\Traits\MultiActionTrait;
use App\Common\Services\UserService;


use Validator;
use Image;
use DB;  
use Datatables;
use Flash; 
use Sentinel;

class TagsController extends Controller
{       
    use MultiActionTrait;

    public function __construct(TagsModel $TagsModel,
                                EventModel $EventModel,
                                UserService $UserService

                               ) 
    {
    	$this->BaseModel          = $TagsModel;
        $this->EventModel         = $EventModel;
        $this->UserService        = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->module_title       = "Tags";
        $this->module_view_folder = "admin.tags";
        $this->module_url_path    = $this->admin_url_path."/tags";
    } 
 

    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".$this->module_title;
        $this->arr_view_data['module_title']      = $this->module_title;
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$tags_table          = $this->BaseModel->getTable();
        $prefixed_tags_table = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_tags_table = DB::table($tags_table)                           
        							 ->orderBy($tags_table.'.created_at','DESC');

        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');    

          
            if(isset($arr_search_column['q_status']) && $arr_search_column['q_status'] != '')
            {
                $search_term            = $arr_search_column['q_status'];
                $obj_tags_table = $obj_tags_table->where('is_active','LIKE','%'.$search_term.'%');
            }
             if(isset($arr_search_column['q_name']) && $arr_search_column['q_name'] != '')
            {
                $search_title          = $arr_search_column['q_name'];
                $obj_tags_table = $obj_tags_table->where('title','LIKE','%'.$search_title.'%');
            }


    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_tags_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })
                      
                        ->editColumn('link',function($data) use ($current_context)

                        {
                          	if($data->link != "")
                          	{
	                          	return $data->link;
                          	}
                         	else
                          	{
                          	 	return "N/A";
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
                            
                            
                            return $build_action = $build_edit_action.' '.$build_delete_action;
                        })

                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }


    public function create()
    {
    	$this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = "Manage ".$this->module_title;
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
                            'title' => 'required',
                            'link'  =>'required'

                         ];
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $response['status']      = 'warning';
            $response['description'] = 'Form validation failed..please check all fields..';

            return response()->json($response);
        }
       
        if(isset($request->link) && $request->link!=""){

                if(!(starts_with($request->link, "http://") || starts_with($request->link, "https://"))) 
                {
                     $response['status'] ='warning';
                     $response['description']='Provided tag url should not be blank or invalid ';
                     return response()->json($response);
                }
         }



         $check_exists =[];
         if(isset($request->title) && !empty($request->title))
         {
            $check_exists = [];
            if($is_update_process == false)
            {
                 $check_exists = $this->BaseModel->where('title',$request->title)->first();
            }else
            {
                 $check_exists = $this->BaseModel->where('title',$request->title)->where('id','!=',$id)->first();
            }

            
             if($check_exists)
             {
                $response['status'] = 'warning';
                $response['description'] = 'Tag already exists.';
                return response()->json($response);
             }
         }

    	 
        
        /* Main Model Entry */
        $tags = $this->BaseModel->firstOrNew(['id' => $id]);

        $tags->link  = isset($form_data['link'])?$form_data['link']:'';
        $tags->title      =  isset($form_data['title'])?$form_data['title']:'';
        if($request->is_active!='' && !empty($request->is_active)){
          $is_active  =  isset($form_data['is_active'])?$form_data['is_active']:'';  
        }else{
            $is_active = '0';
        }
         $tags->is_active = $is_active;

 
        $tags->save();

        if($tags)
        {

            
            if($is_update_process == false)
            {
                /*if($product_news->id)
                {
                    $response['link'] =$this->module_url_path.'/edit/'.base64_encode($product_news->id);
                }*/
                $response['link'] = $this->module_url_path;

            }
            else
            {
                $response['link'] = $this->module_url_path.'/edit/'.base64_encode($id);
            }

            if($is_update_process == false)
            {

                 /***********Add Event data*for chowwatch****/
                    $admin   = Sentinel::check();
                    $user_name ='';
                    $loginuserid ='';
                    if(isset($admin))
                    {
                        $admin_fname = isset($admin->first_name)?$admin->first_name:'';
                        $admin_lname = isset($admin->last_name)?$admin->last_name:'';
                        $user_name  = $admin_fname.' '.$admin_lname;
                         $loginuserid =$admin->id;
                    }

                    $arr_eventdata             = [];
                    $arr_eventdata['user_id']  = $loginuserid;
                  
                     $arr_eventdata['message']  = '<div class="discription-marq">
                      <div class="mainmarqees-image">
                         <img src="'.url('/').'/assets/front/images/chow.png" alt="">
                       </div>Checkout the <b>'.$form_data['title'].'</b> on tags .<div class="clearfix"></div></div><a href="'.url('/').'/chowwatch" target="_blank" class="viewcls">View</a>';


                    $arr_eventdata['title']    = 'Tags';                        
                   // $this->EventModel->create($arr_eventdata);

                /*********end of add event****************************/
                 
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has added tag '.$tags->title.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

        
                /*----------------------------------------------------------------------*/ 

                $response['status']      = "success";
                $response['description'] = "Tag added successfully."; 

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated tag '.$tags->title.'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

        
                /*----------------------------------------------------------------------*/ 

                $response['status']      = "success";
                $response['description'] = "Tag updated successfully.";

            }

          
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding tag.";
        }

        return response()->json($response);
    }

    public function edit($enc_id)
    {       
        $id   = base64_decode($enc_id);
       
        $obj_data = $this->BaseModel->where('id', $id)->first();
    
        $arr_product_news = [];
        if($obj_data)
        {
           $arr_product_news = $obj_data->toArray(); 
        }
    
     // 	$this->arr_view_data['news_public_img_path']     = $this->news_public_img_path;
      	$this->arr_view_data['edit_mode']                = TRUE;
     	$this->arr_view_data['enc_id']                   = $enc_id;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_tag']   		 = isset($arr_product_news) ? $arr_product_news : [];  
      	$this->arr_view_data['page_title']               = "Edit ".str_singular($this->module_title);
      	$this->arr_view_data['module_title']             = "Manage ".$this->module_title;
  
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
                // Flash::success(str_plural($this->module_title).' Deleted Successfully'); 
                Flash::success('Tag deleted successfully'); 

            } 
            elseif($multi_action=="activate")
            {  
                $flag = "activate";
                 
                $this->perform_activate(base64_decode($record_id),$flag); 
                //Flash::success(str_plural($this->module_title).' Activated Successfully'); 
                Flash::success('Tag activated successfully'); 

            }
            elseif($multi_action=="deactivate")
            {
                $flag = "deactivate";

                $this->perform_deactivate(base64_decode($record_id),$flag);    
                //Flash::success(str_plural($this->module_title).' Blocked Successfully');  
                Flash::success(' Tag blocked successfully');  

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on tag.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple activate operation on tag.';

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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple deactivate operation on tag.';

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
          
           // Flash::success(str_singular($this->module_title).' Deleted Successfully');
             Flash::success(' Tag deleted successfully');

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
            $entity_arr = $entity->toArray();

            $this->BaseModel->where('id',$id)->delete();

            if($flag==false)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted tag '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
           

            //Flash::success(str_plural($this->module_title).' Deleted Successfully');
            Flash::success('Tag deleted successfully');

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
        }

        $arr_response['data'] = 'DEACTIVE';

        return response()->json($arr_response);
    }

    public function perform_activate($id,$flag = false)
    {
        $user = Sentinel::check();

        $entity = $this->BaseModel->where('id',$id)->first();
        
        if($entity)
        {
            $entity_arr = $entity->toArray();

            if($flag == false)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has activated tag '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
          

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
            $entity_arr = $entity->toArray();

            if($flag==false)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deactivated tag '.$entity_arr['title'].'.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }
           

            return $this->BaseModel->where('id',$id)->update(['is_active'=>'0']);

        }
        return FALSE;
    }//deactivate

}
