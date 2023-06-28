<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDimensionsModel extends Model
{
    protected $table     = 'product_dimnesions';

    protected $fillable  =  [
                				'product_id',
                                'option_type',
                                'option'
    					    ];
    

    public function product_details()
    {
        return $this->hasMany('App\Models\ProductModel','product_id','id');
    }
   


}
