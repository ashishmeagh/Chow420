<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstLevelCategoryProductDetailModel extends Model
{
    protected $table    = 'first_level_category_product_details';

    protected $fillable = ['category_id','image','description']; 

}
