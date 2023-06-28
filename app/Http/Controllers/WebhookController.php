<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SiteSettingModel;

use Validator;
use DB;
use \Session;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
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
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
      dd(123);
        // Handle the incoming event...
    }

}
