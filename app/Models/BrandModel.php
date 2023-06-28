<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    protected $table 	= 'brands';
    protected $fillable = ['name'];

    
    public function get_products()
    {
    	return $this->hasMany('App\Models\ProductModel','brand','id');
    } 
}
