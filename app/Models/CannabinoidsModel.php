<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CannabinoidsModel extends Model
{
    protected $table 	= 'cannabinoids';
     protected $fillable   = [	
    							'name',    							
    							'id',    							
    							'created_at',
    							'updated_at',
    							'deleted_at'
    						];

    
     public function get_products_canabinoids()
    {
    	return $this->hasMany('App\Models\ProductCannabinoidsModel','cannabinoids_id','id');
    } 
}
