<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpDataModel extends Model
{
    protected $table 	= 'tbl_ipdata';
    protected $fillable = ['ip','country','state'];


    public function get_membership_details()
    {
    return $this->belongsTo('App\Models\MembershipModel','membership_id','id');

    }


}
