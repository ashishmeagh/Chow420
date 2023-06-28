<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
   protected $table 	= 'trade_chat_history';

   protected $fillable  = [
                'buyer_trade_id',
                'seller_trade_id',
   							'trade_id',
   							'sender_id',
   							'receiver_id',   							
   							'message',
   							'is_viewed',
                'role',
                'attachment'
						  ];

  	public function sender_details()
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
    }

}
