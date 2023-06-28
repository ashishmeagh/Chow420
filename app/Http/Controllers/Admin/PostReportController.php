<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

use App\Models\PostReportModel;
use App\Models\BuyerModel;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\ContainerModel;
use App\Common\Services\UserService;


 

use App\Common\Traits\MultiActionTrait;

use Validator;
use Image;
use DB;  
use Datatables;
use Flash;  
use Sentinel;
 
class PostReportController extends Controller
{       
    use MultiActionTrait;

    public function __construct(PostReportModel $PostReportModel,
                                BuyerModel $BuyerModel,
                                UserModel $UserModel,
                                PostModel $PostModel,
                                ContainerModel $ContainerModel,
                                UserService $UserService

                                ) 
    {
    	$this->BaseModel          = $PostReportModel;
        $this->BuyerModel         = $BuyerModel;
        $this->UserModel          = $UserModel;
        $this->PostModel          = $PostModel;
        $this->ContainerModel     = $ContainerModel;
        $this->UserService        = $UserService;
  
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));


        $this->module_title       = "Post Report";
        $this->module_view_folder = "admin.report_post";
        $this->module_url_path    = $this->admin_url_path."/report_post";
    }


    public function index()
    {

        $this->arr_view_data['page_title']        = "Manage ".str_plural($this->module_title);

        $this->arr_view_data['module_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['admin_panel_slug']  = config('app.project.admin_panel_slug'); 
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_records(Request $request)
    {
    	$post_report_table       = $this->BaseModel->getTable();
        $prefixed_postreport_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $buyer_details           = $this->BuyerModel->getTable();        
        $prefixed_buyer_details  = DB::getTablePrefix().$this->BuyerModel->getTable();

        $user_details           = $this->UserModel->getTable();        
        $prefixed_user_details  = DB::getTablePrefix().$this->UserModel->getTable();

        $post_details           = $this->PostModel->getTable();        
        $prefixed_post_details  = DB::getTablePrefix().$this->PostModel->getTable();

        $container_details           = $this->ContainerModel->getTable();        
        $prefixed_container_details  = DB::getTablePrefix().$this->ContainerModel->getTable();

        

        $obj_report_table = DB::table($prefixed_postreport_table)   


                                        ->select(DB::raw($prefixed_postreport_table.".id as id,".
                                            $prefixed_post_details.".title as title,".
                                              $prefixed_postreport_table.".post_id as post_id,".
                                            $prefixed_postreport_table.".message as message,".
                                            $prefixed_postreport_table.".link as link,".
                                            $prefixed_postreport_table.".created_at as created_at,".
                                             $prefixed_user_details.".email as email,".                                   
                                            "CONCAT(".$prefixed_user_details.".first_name,' ',"
                                            .$prefixed_user_details.".last_name) as user_name"
                                          ))
                                         ->leftjoin($prefixed_user_details,$prefixed_user_details.'.id','=',$prefixed_postreport_table.'.user_id')
                                           ->leftjoin($prefixed_post_details,$prefixed_post_details.'.id','=',$prefixed_postreport_table.'.post_id')


        							 ->orderBy($prefixed_postreport_table.'.id','DESC');

        /* ---------------- Filtering Logic ----------------------------------*/ 
          	$arr_search_column = $request->input('column_filter');    
  
           if(isset($arr_search_column['q_user_name']) && $arr_search_column['q_user_name'] != '')
            {

                $search_buyer_term       = $arr_search_column['q_user_name'];
                
                $obj_report_table  = $obj_report_table->where($prefixed_user_details.'.first_name','LIKE', '%'.$search_buyer_term.'%')->orWhere($prefixed_user_details.'.last_name', 'LIKE', '%'.$search_buyer_term.'%');
            }
            if(isset($arr_search_column['q_post_name']) && $arr_search_column['q_post_name'] != '')
            {
                $search_post_term   = $arr_search_column['q_post_name'];
                
                $obj_report_table  = $obj_report_table->where($prefixed_post_details.'.title','LIKE', '%'.$search_post_term.'%');
            }

            
          	
           
 

    	/* --------------------------------------------------------------------*/

        $current_context = $this;

        $json_result = Datatables::of($obj_report_table);  

        $json_result =   $json_result->editColumn('enc_id',function($data) use ($current_context)
                        {
                          return base64_encode($data->id);
                        })
                        ->editColumn('title',function($data) use ($current_context)
                        {
                           return '<a target="_blank" href="'.$data->link.'">'.$data->title.'</a>';

                        })
                          ->editColumn('user_name',function($data) use ($current_context)
                        {
                            if($data->user_name!="" && strlen($data->user_name)>1)
                            {
                                return $data->user_name;

                            }else{
                                return $data->email;

                            }   
                           
                        })



                         ->editColumn('container',function($data) use ($current_context)
                        {
                            $container ='';
                            $post_id = $data->post_id;
                            $get_post = $this->PostModel->where('id',$post_id)->first();
                           if(isset($get_post) && !empty($get_post))
                           {
                                $get_post = $get_post->toArray();                               
                                $container_id = isset($get_post['container_id'])?$get_post['container_id']:'';
                                if(isset($container_id) && !empty($container_id))
                                {
                                     $get_containername = $this->ContainerModel->where('id',$container_id)->first();
                                  if(isset($get_containername) && !empty($get_containername))
                                  {
                                     $get_containername = $get_containername->toArray();
                                     $container = isset($get_containername['title'])?$get_containername['title']:'';

                                     return $container;


                                  }//if

                                }//if
                           }//if

                        })
                        ->editColumn('created_at',function($data) use ($current_context)
                        {
                           return date('d M Y H:i',strtotime($data->created_at));

                        })
                         ->editColumn('message',function($data) use ($current_context)
                        {
                            if(strlen($data->message)>50){
                               return '<p class="prod-desc">'.str_limit($data->message,50).'..<a class="readmorebtn" message="'.$data->message.'" style="cursor:pointer" link="'.$data->link.'"><b>Read more</b></a></p>';
                            }
                            else{
                                return $data->message;
                            }
                        })

                        ->editColumn('build_action_btn',function($data) use ($current_context)
                        {   
                           
                            $build_delete_action ='';


                            $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                            $confirm_delete = 'onclick="confirm_delete(this,event);"';
                            $build_delete_action = '<a class="btns-removes" '.$confirm_delete.' href="'.$delete_href.'" title="Delete">Delete</a>';

                            return $build_action = $build_delete_action;
                        })
                        ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
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
                $this->perform_activate(base64_decode($record_id)); 
                Flash::success(str_plural($this->module_title).' activated successfully'); 

            }
            elseif($multi_action=="deactivate")
            {
                
                $this->perform_deactivate(base64_decode($record_id));    
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has performed multiple delete operation on post reports.';

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
            $entity_arr  = $entity->toArray();
            
            $this->BaseModel->where('id',$id)->delete();


            if($flag == false)
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
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has deleted forum post.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
            }

            

            Flash::success(str_singular($this->module_title).' deleted successfully');
            return true; 
        }
        else
        {
          Flash::error('Problem occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
        
    }//delete function


    

     

}
