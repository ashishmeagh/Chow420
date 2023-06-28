<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FollowModel extends Model
{

	protected $table = 'tbl_followers';

    protected $fillable = ['id','buyer_id','seller_id'];
  
    public function get_product_details()
    {
        return $this->belongsTo('App\Models\ProductModel','product_id','id');

    } 
     public function get_buyer_details()
    {
        return $this->belongsTo('App\Models\UserModel','buyer_id','id');

    } 

}
