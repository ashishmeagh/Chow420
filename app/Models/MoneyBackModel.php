<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyBackModel extends Model
{
    protected $table 	= 'money_back_requested_products';
    protected $fillable = ['buyer_id','product_id','status','note','money_back_requested_products','reported_issue_note'];

   
    public function product_details() 
    {
    	return $this->belongsTo('App\Models\ProductModel','product_id','id');
    }

    public function user_details()
    {
    	return $this->belongsTo('App\Models\UserModel','buyer_id','id');
    }

}
