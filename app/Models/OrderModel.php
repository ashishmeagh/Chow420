<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table 	= 'order_details';
    protected $fillable = [
                            'seller_id',
                            'order_no',
                            'transaction_id',
                            'total_amount',
                            'buyer_id',
                            'withdraw_reqeust_status',
                            'withdraw_request_id',
                            'refund_status',
                            'refund_id',
                            'order_status',
                            'note',
                            'is_transfer',
                            'tracking_no',
                            'shipping_company_name',
                            'delivery_option_id',
                            'delivery_cost',
                            'delivery_title',
                            'delivery_day',
                            'withdraw_tx_unique_id',
                            'card_last_four',
                            'authorize_transaction_status',
                            'payment_gateway_used',
                            'buyer_wallet_id',
                            'tax'

                        ];

    public function seller_details() 
    {
    	return $this->belongsTo('App\Models\UserModel','seller_id','id');
    }

    public function buyer_details()
    {
       return $this->belongsTo('App\Models\UserModel','buyer_id','id');	
    }

    public function address_details()
    {
      return $this->belongsTo('App\Models\OrderAddressModel','order_no','order_id');
    }

    public function order_product_details()
    {
     return $this->hasMany('App\Models\OrderProductModel','order_id','id');	
    }

    public function transaction_details()
    {
      return $this->belongsTo('App\Models\TransactionModel','order_no','order_no');   
    }

    public function dispute_details()
    {
      return $this->belongsTo('App\Models\DisputeModel','id','order_id');  
    }
}
