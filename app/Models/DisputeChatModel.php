<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisputeChatModel extends Model
{
    protected $table = 'dispute_chat_history';
    protected $fillable = ['order_id','order_no','sender_id','receiver_id','message','role','attachment','is_viewed'];

    public function sender_details()
    {
        return $this->belongsTo('App\Models\UserModel','sender_id','id');
    }

    public function receiver_details()
    {
        return $this->belongsTo('App\Models\UserModel','receiver_id','id');
    }
}
