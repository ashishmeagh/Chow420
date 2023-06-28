<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionsModel extends Model
{
    protected $table 	= 'user_subscriptions';
    protected $fillable = ['user_id','membership_id','membership','membership_amount','membership_status','membership_startdate','membership_enddate','payment_status','customer_id','customer_card_id','transaction_id','is_upgrade','is_cancel','subscribe_status','product_limit','cancel_reason'];

     

    public function get_membership_details()
    {
    return $this->belongsTo('App\Models\MembershipModel','membership_id','id');

    }


}
