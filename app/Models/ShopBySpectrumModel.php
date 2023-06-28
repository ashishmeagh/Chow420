<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopBySpectrumModel extends Model
{
   	protected $table      = "shop_by_spectrum";
    
    protected $fillable   = [	
    							'title',
    							'subtitle',
    							'link_url',
    							'is_active'
    						];
}
