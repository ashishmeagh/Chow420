<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerBannerImageModel extends Model
{
    protected $table      = "seller_banner_image";
    
    protected $fillable   = [	
    							'seller_id',
    							'image_name',
    							'image_medium',
    							'image_small',
    							'status'
    						];
}
