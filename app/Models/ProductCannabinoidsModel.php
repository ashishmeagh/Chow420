<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCannabinoidsModel extends Model
{
    protected $table 	= 'product_cannabinoids';
     protected $fillable   = [	
    							'product_id',    							
    							'id',      							
    							'cannabinoids_id',      							
    							'percent',      							
    							'created_at',
    							'updated_at',
    							'deleted_at'
    						];

    
  
}
