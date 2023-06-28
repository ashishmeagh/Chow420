<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerImagesModel extends Model
{
   	protected $table      = "banner_images";
    
    protected $fillable   = [	
    							'banner_image1_desktop',
    							'banner_image1_mobile',
    							'banner_image2_desktop',
    							'banner_image2_mobile',
    							'banner_image3_desktop',
    							'banner_image3_mobile',
    							'banner_image4_desktop',
    							'banner_image4_mobile',
    							'banner_image5_desktop',
    							'banner_image5_mobile',
    							'banner_image6_desktop',
    							'banner_image6_mobile',
    						];
}
