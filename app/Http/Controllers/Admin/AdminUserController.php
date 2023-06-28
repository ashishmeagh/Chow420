<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Activations\EloquentActivation;
use Validator;
use Session;
use Sentinel;
use Flash;
use Activation;


class AdminUserController extends Controller
{
    public function __construct(
                                UserModel $user,
                                ActivityLogsModel $activity_logs
                                ) 
    {
        $this->UserModel          = $user;
        $this->ActivityLogsModel  = $activity_logs;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->module_title       = "Admin Users";
        $this->module_view_folder = "admin.admin_users";
        $this->module_url_path    = $this->admin_url_path."/admin_users";
 
    }

    public function index()
    {

        $arr_users = array();
        $obj_users = Sentinel::createModel()->whereHas('roles',function($query)
                                                {
                                                   return $query->whereIn('slug',['admin']);
                                                })
                                                ->where('id','!=',1)
                                                ->get();
        
        
        $is_last_user = count($obj_users)==1?true:false;

        $this->arr_view_data['is_last_user']    = $is_last_user;
        $this->arr_view_data['obj_users']       = $obj_users;
        $this->arr_view_data['page_title']      = "Manage ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);

    }

    public function create()
    {
        $obj_role = Sentinel::getRoleRepository()->createModel()->whereIn('slug',['admin']);
        $obj_role = $obj_role->orderBy('id','desc')->get(); 

        if( $obj_role != FALSE)
        {
            $arr_roles = $obj_role->toArray();
        }

        $this->arr_view_data['arr_roles']       = $arr_roles;
        $this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    // public function store(Request $request)
    // {
    //     /*Valiation check*/
    //     $inputs = request()->validate([
    //             'first_name'=>'required',
    //             'last_name'=>'required',
    //             'email'=>'required|email',
    //             'password'=>'required|confirmed|min:6|max:16'
    //         ]);        

    // 	/* Duplication Check */
    // 	$is_duplicate = Sentinel::createModel()->where('email',$request->input('email'))->count();

    // 	if($is_duplicate>0)
    // 	{
    // 		Flash::error(str_singular($this->module_title).' Already Exists.');
    // 		return redirect()->back()->withInput($request->all());
    // 	}

    //     $arr_data               = [];
    //     $arr_data['first_name'] = $request->input('first_name');
    //     $arr_data['last_name']  = $request->input('last_name');
    //     $arr_data['email']      = $request->input('email');
    //     $arr_data['password']   = $request->input('password');
    	
    // 	$user = Sentinel::registerAndActivate($arr_data);
    	
    // 	$arr_roles = $request->input('roles');
    	
    // 	if(sizeof($arr_roles)>0)
    // 	{
    // 		foreach ($arr_roles as $key => $id) 
    // 		{
    // 			$role = Sentinel::findRoleById($id);
    // 			$role->users()->attach($user);
    // 		}
    // 	}
    	
    // 	if($user)
    // 	{
    //         /*-------------------------------------------------------
    //         |   Activity log Event
    //         --------------------------------------------------------*/
    //             $arr_event                 = [];
    //             $arr_event['ACTION']       = 'ADD';
    //             $arr_event['MODULE_TITLE'] = $this->module_title;

    //             $this->save_activity($arr_event);
    //         /*----------------------------------------------------------------------*/
    // 		Flash::success(str_singular($this->module_title).' Created Successfully');
    // 	}
    // 	else
    // 	{
    // 		Flash::error('Problem Occurred, While Creating '.str_singular($this->module_title));
    // 	}

    // 	return redirect()->back();
    // }

    public function edit($enc_id)
    {
    	$id = base64_decode($enc_id);

    	$obj_user = Sentinel::findById($id);
    	$obj_role = Sentinel::getRoleRepository()->createModel();
       	$obj_role = $obj_role->orderBy('id','desc')->get();	

        if( $obj_role != FALSE)
        {
            $arr_roles = $obj_role->toArray();
        }

    	$arr_user = [];
    	if($obj_user)
    	{
    		$arr_tmp = $obj_user->roles->toArray();
    		$arr_assigned_roles = array_column($arr_tmp,'id');
    	}

        $this->arr_view_data['edit_mode']          = TRUE;
        $this->arr_view_data['enc_id']             = $enc_id;
        $this->arr_view_data['arr_assigned_roles'] = $arr_assigned_roles;
        $this->arr_view_data['arr_roles']          = $arr_roles;
        $this->arr_view_data['obj_user']           = $obj_user;
        $this->arr_view_data['page_title']         = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title']       = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']    = $this->module_url_path;
       
        return view($this->module_view_folder.'.edit', $this->arr_view_data);    

    }

    public function save(Request $request)
    {
        $is_update = false;
        $user_id = base64_decode($request->input('enc_id',false));

        if($request->has('enc_id'))
        {
            $is_update = true;
        }

        $arr_rules = [
                    'first_name'        =>  'required',
                    'email'             =>  'required',
                    'last_name'         =>  'required',
                    'password'          =>  'min:6',
                    'password_confirmation'  =>  'required|same:new_password',
                ];

        $validator = Validator::make($request->all(),$arr_rules,[
                                    'first_name.required'   =>  'Enter First name',
                                    'last_name.required'    =>  'Enter last name',
                                    'email.required'        =>  'Enter Valid Email Id',
                                    'password.required'     =>  'Enter Password',
                                 ]);

     
        $form_data = $request->all();

        /* Duplication Check */

        $is_duplicate = $this->UserModel->where('email',$form_data['email']);

        if($is_update)
        {
            $is_duplicate = $is_duplicate->where('id','<>',$user_id);
        }

        $alredy_exist = $is_duplicate->count();

        if($alredy_exist > 0)
        {
          flash('Already Exists')->error();
          return redirect()->back()->withInput($request->all());
        }
    
        $user =  Sentinel::createModel()->firstOrNew(['id' => $user_id]);


        $user->first_name = $form_data['first_name'];
        $user->email      = $form_data['email'];
        $user->last_name  = $form_data['last_name'];
        
        if(isset($form_data['password']))
        {
            $hasher = Sentinel::getHasher();
            $user->password = $hasher->hash($form_data['password']);    
        }
        

        $user->save();

        if($is_update == false)
        {
            /* Activate User By Default */
            $activation = Activation::create($user);    

            if($activation)
            {
                Activation::complete($user,$activation->code);
            }
        }   
      
        if($user)
        {
            $arr_roles = $request->input('roles');
        
            if(sizeof($arr_roles)>0)
            {
                foreach ($arr_roles as $key => $id) 
                {
                    $role = Sentinel::findRoleById($id);

                    /* Check if Role is already */
                    if($role != false && $user->inRole($role->slug) == false)
                    {
                        $role->users()->attach($user);    
                    }
                }
            }
            
            if($user)
            {
                // -------------------------------------------------------
                // |   Activity log Event
                // --------------------------------------------------------
                    $arr_event                 = [];
                    $arr_event['ACTION']       = 'ADD';
                    $arr_event['MODULE_TITLE'] = $this->module_title;

                    $this->save_activity($arr_event);


                Flash::success(str_singular($this->module_title).' Saved Successfully');
                return redirect()->back();
            }       
            else
            {
                flash('Error Occurred Please Try Again.!')->error();
                return redirect()->back()->withInput($request->all());
            }
       
        }
    }

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

    public function delete($enc_id)
    {
        $id = base64_decode($enc_id);

        if($this->perform_delete($id))
        {
            event(new ActivityLogEvent([
                                        'module_title'=>$this->module_title,
                                        'module_action'=>'REMOVED'
                                        ]));

            Flash::success(str_singular($this->module_title).' Deleted Successfully');
        }
        else
        {
            Flash::error('Problem Occured While '.str_singular($this->module_title).' Deletion ');
        }

        return redirect()->back();
    }
    
    public function perform_activate($id)
    {
        $entity = $this->UserModel->where('id',$id)->first();
        

        if($entity)
        {
            return $this->UserModel->where('id',$id)->update(['is_active'=>'1']);
        }

        return FALSE;
    }

    public function perform_deactivate($id)
    {

        $entity = $this->UserModel->where('id',$id)->first();
        
        if($entity)
        {
            return $this->UserModel->where('id',$id)->update(['is_active'=>'0']);
        }
        return FALSE;
    }

    public function perform_delete($id)
    {
        $entity = $this->UserModel->where('id',$id)->first();
        
        if($entity)
        {
            $obj_user   = Sentinel::findById($id);
            $role_admin = Sentinel::findRoleBySlug('admin');
            $obj_user->roles()->detach($role_admin);

            $delete_success = $this->UserModel->where('id',$id)->delete();
             /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
                $arr_event                 = [];
                $arr_event['ACTION']       = 'REMOVED';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);
            /*----------------------------------------------------------------------*/
            
            return $delete_success;
  
        }
         return FALSE;
    }

   
}
