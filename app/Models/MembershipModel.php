<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipModel extends Model
{
    protected $table 	= 'tbl_membership';
    protected $fillable = ['title','description','product_count','price','image','plan_id','membership_type'];

     
}
