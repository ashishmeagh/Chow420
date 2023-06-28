<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstLevelCategoryFaqModel extends Model
{
    protected $table    = 'first_level_category_faq';

    protected $fillable = ['category_id','question','answer']; 

}
