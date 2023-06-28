<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeBuyHistoryModel extends Model
{
    protected $table 		= 'trade_buy_history';
    protected $fillable		= ['category_id','avg_volume','avg_unit_price'];
}
