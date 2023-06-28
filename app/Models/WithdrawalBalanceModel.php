<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalBalanceModel extends Model
{
    protected $table 	= 'withdrawal_balance';
    protected $fillable = [
                            'seller_id',
                            'to_user_id',
                            'order_id',
                            'balance_amount',
                            'withdrawal_balance_status',
                            'created_at',
                            'updated_at'
                        ];

    public function seller_details() 
    {
    	return $this->belongsTo('App\Models\UserModel','seller_id','id');
    }

}
