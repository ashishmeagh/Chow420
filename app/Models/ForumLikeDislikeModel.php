<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumLikeDislikeModel extends Model
{
    protected $table     = 'forumpost_like_dislike';

    protected $fillable  =  [ 
                              'container_id',
                              'post_id',
                						  'user_id',
                              'like_dislike'
                             
                         
    					    ];
   
    public function user_details()
    {
      return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    public function get_seller_details()
    {
         return $this->belongsTo('App\Models\UserModel','user_id','id');
    }
    public function get_seller_additional_details()
    {
         return $this->belongsTo('App\Models\SellerModel','user_id','user_id');
    }
   


}
