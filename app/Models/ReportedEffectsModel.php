<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedEffectsModel extends Model
{
   	protected $table      = "reported_effects";
    
    protected $fillable   = [	
    							'title',
    							/*'subtitle',*/
    							'image',
    							'video_url',
    							'created_at',
    							'updated_at',
    							'deleted_at',
    							'id'
    						];
}
