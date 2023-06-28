<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderImagesModel extends Model
{
   	protected $table      = "slider_images";
    
    protected $fillable   = [	
    							'slider_image',
    							'image_url',
    							'title'
    						];
}
