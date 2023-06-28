<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FirstLevelCategoryModel extends Model
{	
	use SoftDeletes;
	
    protected $table     = 'first_level_category';

    protected $fillable  =  [
    						  'product_type',
    						  'slug',
    						  'is_active',
                              'is_crypto_category'
    					    ];

    public function category_details()
    {
      return $this->hasMany('App\Models\SecondLevelCategoryModel','first_level_category_id','id');
    }

      public function age_restriction_detail()
    {
        return $this->belongsTo('App\Models\AgeRestrictionModel','age_restriction','id');
    } 
}
