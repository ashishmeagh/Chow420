<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Common\Traits\MultiActionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentModel extends Model
{

    protected $table = "product_comment";

    protected $fillable = ['user_id','product_id','comment'];


    function user_details()
    {
       return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    function reply_details()
    {
      return $this->hasMany('App\Models\ReplyModel','comment_id','id')
    }
}
