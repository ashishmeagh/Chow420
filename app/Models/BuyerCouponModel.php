<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerCouponModel extends Model
{
    protected $table 	= 'coupon_buyers';
    protected $fillable = ['code','type','seller_id','buyer_id'];

    
    // public function get_products()
    // {
    // 	return $this->hasMany('App\Models\ProductModel','brand','id');
    // } 
}
