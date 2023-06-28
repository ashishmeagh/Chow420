<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulesModel extends Model
{
    protected $table    = "modules";

    protected $fillable = ['module_slug','status','module_name'];
}
