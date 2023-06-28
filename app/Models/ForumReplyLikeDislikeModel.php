<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReplyLikeDislikeModel extends Model
{
    protected $table     = 'forum_reply_likedislike';

    protected $fillable  =  [ 
                              'container_id',
                              'post_id',
                              'reply_id',
                						  'user_id',
                              'like_dislike',
                              'parent_comment_id'
                             
                         
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
