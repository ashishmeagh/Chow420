<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpectrumModel extends Model
{
    protected $table 	= 'spectrum';
    protected $fillable = ['name'];

    
    public function get_products()
    {
    	return $this->hasMany('App\Models\ProductModel','spectrum','id');
    } 
}
