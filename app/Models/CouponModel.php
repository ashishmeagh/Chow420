<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponModel extends Model
{
    protected $table 	= 'coupon';
    protected $fillable = ['code','type','discount','start_date','end_date'];

    
    // public function get_products()
    // {
    // 	return $this->hasMany('App\Models\ProductModel','brand','id');
    // } 
}
