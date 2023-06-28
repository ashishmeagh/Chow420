<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCommentModel extends Model
{
    protected $table    = "product_comment";

    protected $fillable = ['user_id','product_id','comment'];


    public function user_details()
    {
       return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    public function product_detail()
    {
      return $this->belongsTo('App\Models\ProductModel','product_id','id');
    }

    public function seller_detail()
    {
     return $this->belongsTo('App\Models\UserModel','seller_id','id');
    }
    public function buyer_detail()
    {
     return $this->belongsTo('App\Models\UserModel','buyer_id','id'); 
    }
    function reply_details()
    {
      return $this->hasMany('App\Models\ReplyModel','comment_id','id');
    }
}