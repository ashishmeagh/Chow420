<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainTransactionModel extends Model
{
    protected $table 	= 'blockchain_transactions';
    protected $fillable = ['trans_hash','trade_id','action','user_id'];


	public function get_data_trade_details()
	{
	  return $this->belongsTo('App\Models\TradeModel','trade_id','id');
	}
}

