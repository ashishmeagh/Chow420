<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementsModel extends Model
{
   	protected $table      = "announcements";
    
    protected $fillable   = [	
    							'title',
    							'title_color',
    							'background_color',
    							'title_url_color',
    							'background_url',
    							'is_active'
    						];
}
