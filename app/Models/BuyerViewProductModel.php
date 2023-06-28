<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerViewProductModel extends Model
{
    protected $table     = 'buyer_view_product';

    protected $fillable  =  ['buyer_id','product_id','ip_address','user_session_id'];



    public function product_details()
    {
       return $this->belongsTo('App\Models\ProductModel','product_id','id');	
    }
}

