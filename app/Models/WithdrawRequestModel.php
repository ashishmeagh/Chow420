<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawRequestModel extends Model
{
    //
    use SoftDeletes;
    protected $table      = "withdraw_request";
    
    protected $fillable   = [	
    							'seller_id',
    							'request_amt',
                                'referal_amount',
    							'received_amt',
    							'status',
                                'registered_name',
                                'account_no',
                                'routing_no',
                                'switft_no',
                                'paypal_email',
                                'admin_commission',
                                'seller_commission'

    						];


    public function order_details() 
    {
    	return $this->hasMany('App\Models\OrderModel','withdraw_request_id','id');
    }

    public function seller_details() 
    {
    	return $this->belongsTo('App\Models\UserModel','seller_id','id');
    }

    public function seller_table_details() 
    {
        return $this->belongsTo('App\Models\SellerModel','seller_id','user_id');
    }
}
