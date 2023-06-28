<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerWalletModel extends Model
{
    protected $table 	= 'buyer_wallet';
    protected $fillable = ['user_id','type','amount','typeid','status'];

     

    // public function get_membership_details()
    // {
    // return $this->belongsTo('App\Models\MembershipModel','membership_id','id');

    // }


}
