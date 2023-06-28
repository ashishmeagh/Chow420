<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FavoriteModel extends Model
{

	protected $table = 'favourite_product';

    protected $fillable = ['id','buyer_id','product_id'];
  
    public function get_product_details()
    {
        return $this->belongsTo('App\Models\ProductModel','product_id','id');

    } 
     public function get_buyer_details()
    {
        return $this->belongsTo('App\Models\UserModel','buyer_id','id');

    } 

}
