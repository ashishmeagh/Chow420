<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportproductModel extends Model
{
    protected $table     = 'report_product';

    protected $fillable  =  [
    						  'product_id','buyer_id','link','message'
    					    ];


    public function buyer_details()
    {
       return $this->belongsTo('App\Models\UserModel','buyer_id','id');	
    }




}
