<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisputeModel extends Model
{
    protected $table = 'dispute';
    protected $fillable = ['user_id','order_id','order_no','is_dispute_finalized','dispute_reason','dispute_status','role'];


    public function user_detail()
    {
        return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    public function order_details()
    {
    	return $this->belongsTo('App\Models\OrderModel','order_id','id');
    }
}
