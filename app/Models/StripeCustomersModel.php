<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeCustomersModel extends Model
{
    protected $table 	= 'stripe_customers';
    protected $fillable = ['customer_id','plan_id','membership_id','email'];

     
}
