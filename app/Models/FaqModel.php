<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqModel extends Model
{
    protected $table 	= 'faq';
    protected $fillable = ['question','answer','faq_category'];


    public function get_faq_category()
    {
      return $this->belongsTo('App\Models\FaqCategoryModel','faq_category','id');
    }
     
}
