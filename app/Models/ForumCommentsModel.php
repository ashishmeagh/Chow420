<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class ForumCommentsModel extends Model
{
    use Rememberable;

    protected $table      = "forum_comments";
    protected $primaryKey = 'id';
    protected $fillable   = ['parent_id','user_id','post_id','container_id','comment','created_at','updated_at','deleted_at','parent_comment_id'];
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function get_user_details()
   	{
   	 	return $this->belongsTo('App\Models\UserModel','user_id','id');
   	} 
}


 


