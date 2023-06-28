<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOptionsModel extends Model
{
    protected $table 	= 'delivery_options';

   protected $fillable  = [
                'seller_id',
                'title',
                'day',
                'cost',
                'status'
						  ];

  	/*public function sender_details()
    {
      return $this->belongsTo('App\Models\UserModel','sender_id','id');
    }

    public function receiver_details()
    {
      return $this->belongsTo('App\Models\UserModel','receiver_id','id');
    }

    public function seller_trade_details()
    {
       return $this->belongsTo('App\Models\TradeModel','seller_trade_id','id');
    }*/
}
