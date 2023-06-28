<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeSubscriptionsModel extends Model
{
    protected $table 	= 'stripe_subscriptions';
    protected $fillable = ['customer_id','plan_id','membership_id','subscription_id','status'];

     
}
