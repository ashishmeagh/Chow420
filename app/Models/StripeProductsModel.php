<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeProductsModel extends Model
{
    protected $table 	= 'stripe_products';
    protected $fillable = ['name','type','membership_id','pid'];

     
}
