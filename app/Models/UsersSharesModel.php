<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSharesModel extends Model
{
   	protected $table      = "users_shares";
    
    protected $fillable   = [	
    							'email',
    							'first_name',
    							'last_name',
    							'shares_owned',
    							'price_per_share',
    							'percent_change',
    							'share_value',
    							'description',
    							'is_active'
    						];
}
