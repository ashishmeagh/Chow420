<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeRatingModel extends Model
{
    protected $table = 'trade_ratings';
    
    protected $fillable = ['trade_id','seller_user_id','buyer_user_id','points','type'];
    

}
