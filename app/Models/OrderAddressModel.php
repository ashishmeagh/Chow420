<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAddressModel extends Model
{
    use SoftDeletes;
    use Rememberable;
    protected $table      = "order_addresses";
    // protected $primaryKey = "site_settting_id";

    protected $fillable   = [	
    							'user_id',
    							'order_id',
    							'shipping_first_name',
    							'shipping_last_name',
    							'shipping_email',
    							'shipping_mobile',
    							'shipping_address1',
    							'shipping_address2',
    							'shipping_city',
    							'shipping_state',
    							'shipping_country',
    							'shipping_zipcode',
    							'billing_company_name',
    							'billing_address1',
    							'billing_address2',
    							'billing_state',
    							'billing_city',
    							'billing_country',
    							'billing_zipcode',
    							'billing_phone',
    							'billing_email'
    							
    						];

    public function state_details()
    {
        return $this->belongsTo('App\Models\StatesModel','shipping_state','id');
    } 

    public function get_shippingcountrydetail()
    {
        return $this->belongsTo('App\Models\CountriesModel','shipping_country','id');
    }
     public function get_shippingstatedetail()
    {
        return $this->belongsTo('App\Models\StatesModel','shipping_state','id');
    }   

     public function get_billingcountrydetail()
    {
        return $this->belongsTo('App\Models\CountriesModel','billing_country','id');
    }
     public function get_billingstatedetail()
    {
        return $this->belongsTo('App\Models\StatesModel','billing_state','id');
    }                       

       
    public function country_details()
    {
        return $this->belongsTo('App\Models\CountriesModel','shipping_country','id');
    }  
    public function billing_state_details()
    {
        return $this->belongsTo('App\Models\StatesModel','billing_state','id');
    } 
    public function billing_country_details()
    {
        return $this->belongsTo('App\Models\CountriesModel','billing_country','id');
    }                         
}
