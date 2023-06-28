<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeModel extends Model
{
    protected $table     = 'product';

    protected $fillable  =  [
                						  'user_id',
                              'product_name',
                              'description',
                						  'first_level_category_id',
                						  'second_level_category_id',                						
                						  'unit_price',
                						  'age_restriction',
                						  'price_status',
                						  'minimum_quantity',
                                          'product_stock',                              
                              'is_active',
                         
    					    ];
    public function first_level_category_details()
    {
       return $this->belongsTo('App\Models\FirstLevelCategoryModel','first_level_category_id','id');
    }

    public function second_level_category_details()
    {
        return $this->belongsTo('App\Models\SecondLevelCategoryModel','second_level_category_id','id');
    }

    public function user_details()
    {
      return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    public function product_comment_details()
    {
        return $this->hasMany('App\Models\ProductCommentModel','product_id','id');
    }
    public function get_unit_details()
    {
        return $this->belongsTo('App\Models\UnitModel','unit_id','id');
    }


}
