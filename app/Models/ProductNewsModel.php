<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductNewsModel extends Model
{
   	protected $table      = "product_news";
    
    protected $fillable   = [	
    							'title',
    							'subtitle',
    							'image',
    							'video_url'
    						];
}
