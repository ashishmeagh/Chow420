<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddressModel extends Model
{
    protected $table = 'user_shipping_address';

    protected $fillable = [ 'user_id',
    						'address',
    						'lat',
    						'lng',
    						'post_code',
    						'country_id',
    						'state',
    						'city'];

    public function country_details()
    {
         return $this->belongsTo('App\Models\CountriesModel','country_id','id');
    }


}
