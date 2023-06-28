<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubAdminActivityModel extends Model
{
    protected $table = 'sub_admin_activity_log';

    protected $fillable = ['user_id','title','message','action'];


    public function user_details()
    {
    	return $this->belongsTo('App\Models\UserModel','user_id','id');
    }
}
