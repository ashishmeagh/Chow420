<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerModel extends Model
{
    use SoftDeletes;
    use Rememberable;
    protected $table      = "seller";
    // protected $primaryKey = "site_settting_id";

    protected $fillable   = [	
    							'user_id',
                                'seller_question_answer',
                                'business_name',
                                'tax_id',
                                'id_proof',
                                'approve_status',
                                'sorting_order_by',
                                'documents_verification_status',
                                'note_doc_reject'			
    						];

    public function address_details()
    {
    	return $this->belongsTo('App\Models\ShippingAddressModel', 'user_id', 'user_id');
    }

     public function user_details()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id', 'id');
    }

    public function get_products()
    {
        return $this->hasMany('App\Models\ProductModel', 'user_id', 'user_id');
    }

    public function delivery_options() {

        return $this->hasMany('App\Models\DeliveryOptionsModel', 'seller_id' ,'user_id');
    }
}
