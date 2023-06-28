<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlansModel extends Model
{
    protected $table 	= 'plans';
    protected $fillable = ['membership_id','plan_id','product_id','nickname'];

     
}
