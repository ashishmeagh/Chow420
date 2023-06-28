<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecondLevelCategoryModel extends Model
{	
	use SoftDeletes;
	
    protected $table     = 'second_level_category';

    protected $fillable  =  [
                						  'first_level_category_id',
                						  'name',
                						  'slug',
                						  'description',
                						  'image',
                						  'is_active',
                              'unit_id',
                              'unit_price',
                              'minimum_quantity',
                              'trade_symbol',
                              'is_visible',
                              'is_crypto_category'
    					              ];

    public function subcategory_details()
    {
      return $this->hasMany('App\Models\ThirdLevelCategoryModel','second_level_category_id','id');
    }


    public function unit_details()
    {
         return $this->belongsTo('App\Models\UnitModel','unit_id','id');
    }

    public function trade_details()
    {
         return $this->hasMany('App\Models\TradeModel','second_level_category_id','id');
    }

    public function product_details()
    {
      return $this->belongsTo('App\Models\FirstLevelCategoryModel','first_level_category_id','id');
    }

}
