<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;


class UserModel extends CartalystUser
{
        use Billable;

    use SoftDeletes;
    // use Messagable;
	protected $fillable = [
		'email',
        'password',
        'google2fa_secret',
        'google2fa_status',
        'user_name',        
        'user_type',
        'last_name',
        'first_name',
        'date_of_birth',
        'permissions',
        'profile_image',
        'is_active',
        'is_trusted',
        'via_social',
        'zipcode',
        'country',
        'city',
        'state',
        'phone',
        'street_address',
        'billing_street_address',
        'billing_state',
        'billing_country',
        'billing_zipcode',
         'billing_city',
        'gender',
        'rut_number',
        'bank_acc_no',
        'bank_name',
        'bank_acc_type', 
        'bank_acc_email',
        'id_proof',
        'membership_id',
        'membership',
        'membership_amount',
        'membership_status',
        'membership_startdate',
        'membership_enddate',
        'payment_status',
        'stripe_id',
        'hear_about',
        'activationcode',
        'domain_source',
        'is_checkout_signup',
        'is_guest_user',
        'show_passwordmodal_afterlogin',
        'is_password_changed'
    ]; 

    protected $table = 'users';


    public function buyer_detail()
    {
        return $this->belongsTo('App\Models\BuyerModel','id','user_id');
    }

    public function seller_detail()
    {
        return $this->belongsTo('App\Models\SellerModel','id','user_id');
    }

    public function address_details()
    {
      return $this->belongsTo('App\Models\ShippingAddressModel','id','user_id');
    }

    public function traveller_profile()
    {
    	return $this->hasOne('App\Models\TravellerProfileModel','user_id','id');
    }

    public function owner_profile()
    {
    	return $this->hasOne('App\Models\OwnerProfileModel','user_id','id');	
    }

    public function favourite_properties()
    {
        return $this->belongsToMany('App\Models\PropertyModel','favourite_properties','user_id','property_id');
    }

    public function user_addresses()
    {
        return $this->hasOne('App\Models\UserAddressesModel','user_id','id');    
    }

    public function getproof_detail()
    {
        return $this->belongsTo('App\Models\BuyerModel','id','user_id');
    }

    public function get_buyer_detail()
    {
        return $this->belongsTo('App\Models\BuyerModel','id','user_id');
    }  
    
    public function get_country_detail()
    {
        return $this->belongsTo('App\Models\CountriesModel','country','id');
    }
    
    public function get_state_detail()
    {
        return $this->belongsTo('App\Models\StatesModel','state','id');
    }
    public function get_billing_country_detail()
    {
        return $this->belongsTo('App\Models\CountriesModel','billing_country','id');
    }
    
    public function get_billing_state_detail()
    {
        return $this->belongsTo('App\Models\StatesModel','billing_state','id');
    }
      public function get_sellerbanner_detail()
    {
        return $this->belongsTo('App\Models\SellerBannerImageModel','id','seller_id');
    }
    
}
