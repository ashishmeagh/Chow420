<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class TblContainerModel extends Model
{
    use Rememberable;

    protected $table      = "tbl_container";
    protected $primaryKey = 'id';
    protected $fillable   = ['title','is_active','created_at','updated_at','deleted_at'];
}


 


