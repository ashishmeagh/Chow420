<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyerModel extends Model
{
    use SoftDeletes;
    use Rememberable;
    protected $table      = "buyer";
    // protected $primaryKey = "site_settting_id";

    protected $fillable   = [	
    							'user_id',
    							'crypto_symbol',
    							'crypto_wallet_address',
                  'sorting_order_by'
    						];

   public function user_details()
   {
   	 return $this->belongsTo('App\Models\UserModel','user_id','id');
   } 

   public function age_restriction_details()
   {
     return $this->belongsTo('App\Models\AgeRestrictionModel','age_category','id');
   } 
   
   
}
