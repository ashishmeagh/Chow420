<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInventoryModel extends Model
{
    protected $table     = 'product_inventory';

    protected $fillable  =  [
                				'product_id',
                              'remaining_stock',
                             
                         
    					    ];
    

    public function product_details()
    {
        return $this->hasMany('App\Models\ProductModel','product_id','id');
    }
   


}
