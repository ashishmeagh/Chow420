<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerRegisteredReferModel extends Model
{
    protected $table 	= 'buyer_registered_refered';
    protected $fillable = ['user_id','code','email','referal_id','amount','user_refered_id','order_id','order_no','is_shipped'];

     

    // public function get_membership_details()
    // {
    // return $this->belongsTo('App\Models\MembershipModel','membership_id','id');

    // }


}
