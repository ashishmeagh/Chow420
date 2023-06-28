<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SiteSettingModel;

use Validator;
use DB;
use \Session;
class WelcomeController extends Controller
{
    	
    public function __construct()
    { 
    	$this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }

    public function index() 
    { 
       $usertype = Session::get('welcomeusertype');  // 1: buyer, 2 :seller
       $email =  Session::get('welcomeuseremail');


       $this->arr_view_data['usertype'] = $usertype;
       $this->arr_view_data['email'] = $email;

       $this->arr_view_data['page_title'] = 'Welcome';
       return view($this->module_view_folder.'.welcomepage',$this->arr_view_data);
            
   }


}
