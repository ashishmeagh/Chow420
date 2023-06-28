<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    protected $table = "transaction_details";

    protected $fillable = [
    						'order_no',
    						'transaction_id',
                            'user_id',
    						'transaction_status',
    						'total_price',
                            'buyer_wallet_amount',
                            'cashback',
                            'cashback_percentage'
						  ];


	public function order_details()
	{
		return $this->hasMany('\App\Models\OrderModel','order_no','order_no');
	}

    public function buyer_details()
    {
       return $this->belongsTo('App\Models\UserModel','user_id','id'); 
    }
 
}
