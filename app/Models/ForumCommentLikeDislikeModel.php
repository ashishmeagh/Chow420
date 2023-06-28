<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumCommentLikeDislikeModel extends Model
{
    protected $table     = 'forum_comment_likedislike';

    protected $fillable  =  [ 
                              'container_id',
                              'post_id',
                              'comment_id',
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
