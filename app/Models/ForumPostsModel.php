<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class ForumPostsModel extends Model
{
    use Rememberable;

    protected $table      = "forum_posts";
    protected $primaryKey = 'id';
    protected $fillable   = ['container_id','user_id','user_type','title','description','is_active','is_featured','created_at','updated_at','deleted_at','image','video','post_type','link'];
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function container_details()
   	{
   	 	return $this->belongsTo('App\Models\TblContainerModel','container_id','id');
   	} 

   	public function user_details()
   	{
   	 	return $this->belongsTo('App\Models\UserModel','user_id','id');
   	} 


   	public function comments()
	{
	  	return $this->hasMany('App\Models\ForumCommentsModel', 'post_id','id');// id--from post
	}


      public function like_details()
    {
     return $this->belongsTo('App\Models\ForumLikeDislikeModel','post_id','id');
    } 
     public function get_comment_count()
    {
     return $this->hasMany('App\Models\ForumCommentsModel','post_id','id');
    } 

     public function get_like_count()
    {
     return $this->hasMany('App\Models\ForumLikeDislikeModel','post_id','id');
    } 
}


 


