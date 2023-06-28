<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImagesModel extends Model
{
    protected $table     = 'product_images';

    protected $fillable  =  [
    						  'user_id',	
                			  'product_id',
                              'image'                            
                         
    					    ];
    

    public function product_details()
    {
        return $this->hasMany('App\Models\ProductModel','product_id','id');
    }
   


}
