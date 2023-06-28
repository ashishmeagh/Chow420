<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategoryModel extends Model
{
    protected $table 	= 'faq_category';
    protected $fillable = ['faq_category','is_active'];


    public function get_faq()
    {
      return $this->hasMany('App\Models\FaqModel','faq_category','id');
    }
}
