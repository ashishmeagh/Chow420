<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductModel extends Model
{
    protected $table 	= 'order_product_details';
    protected $fillable = ['order_id','product_id','unit_price','quantity','shipping_charges','dropshipper_id','dropshipper_price','age_restriction'];


    public function product_details()
    {
    	return $this->belongsTo('App\Models\ProductModel','product_id','id');	 
    }
      public function age_restriction_detail()
    {
        return $this->belongsTo('App\Models\AgeRestrictionModel','age_restriction','id');
    } 
}
