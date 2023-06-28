<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReportModel extends Model
{
    protected $table     = 'forumpost_report';

    protected $fillable  =  [
    						  'post_id','user_id','link','message'
    					    ];
}
