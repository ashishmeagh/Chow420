<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReferedModel extends Model
{
    protected $table 	= 'user_refered';
    protected $fillable = ['user_id','code','email'];

     

    // public function get_membership_details()
    // {
    // return $this->belongsTo('App\Models\MembershipModel','membership_id','id');

    // }


}
