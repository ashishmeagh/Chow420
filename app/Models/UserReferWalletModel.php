<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReferWalletModel extends Model
{
    protected $table 	= 'user_refer_wallet';
    protected $fillable = ['user_id','code','email','referal_id','amount','user_refered_id','withdraw_reqeust_status','withdraw_request_id'];

     

    // public function get_membership_details()
    // {
    // return $this->belongsTo('App\Models\MembershipModel','membership_id','id');

    // }


}
