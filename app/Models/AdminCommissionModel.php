<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminCommissionModel extends Model
{
    //
    protected $table 	= 'admin_commission';

   	protected $fillable  = [
	                			'id',
				                'withdraw_request_id',
	   							'seller_id',
	   							'total_pay_amt',
	   							'admin_commission_amt',
	   							'seller_commission_amt',					
	   							'status'   							
						  	];
}
