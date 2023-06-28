<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempBagModel extends Model
{

    protected $table      = "temp_bag";
    // protected $primaryKey = "site_settting_id";

    protected $fillable   = [	
    							'buyer_id',
    							'product_data',
                                'ip_address',
                                'user_session_id'
    						];

    public function product_details()
	{
		return $this->belongsTo('App\Models\ProductModel','product_id','id');
	}						
}
