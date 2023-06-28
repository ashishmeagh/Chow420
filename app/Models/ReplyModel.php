<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Common\Traits\MultiActionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReplyModel extends Model
{

    protected $table = "reply";

    protected $fillable = ['comment_id','user_id','reply'];


    function comment_details()
    {
       return $this->belongsTo('App\Models\ProductCommentModel','comment_id','id');
    }

    function user_details()
    {
      return $this->belongsTo('App\Models\UserModel','user_id','id');
    }
}
