<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class ActivationsModel extends Model
{
    use Rememberable;

    protected $table      = "activations";
    protected $primaryKey = 'id';
    protected $fillable   = ['user_id','code','completed','completed_at'];
}


 


