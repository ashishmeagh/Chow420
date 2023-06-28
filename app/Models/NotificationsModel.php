<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationsModel extends Model
{
    protected $table      = "notifications";
  
    protected $fillable   = [	
    							'from_user_id',
    							'to_user_id',
    							'message',				
                                'title',
    							'is_read'			
    						];

    public function sender_details()
    {
        return $this->belongsTo('App\Models\UserModel','from_user_id','id');
    }
}
