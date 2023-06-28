<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordsModel extends Model
{
   	protected $table      = "keywords";
    
    protected $fillable   = [	
								'keyword_name',
								'is_active'
    						];
}


