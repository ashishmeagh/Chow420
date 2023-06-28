<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopByEffectModel extends Model
{
   	protected $table      = "shop_by_effect";
    
    protected $fillable   = [	
    							'title',
    							'subtitle',
    							'link_url',
    							'is_active'
    						];
}
