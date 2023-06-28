<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestionCategoryModel extends Model
{
   	protected $table      = "search_suggestion";
    
    protected $fillable   = [	
								'title',
								'is_active',
								'user_search'
    						];
}


