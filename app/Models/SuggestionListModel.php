<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestionListModel extends Model
{
   	protected $table      = "search_suggestion_title";
    
    protected $fillable   = [	
                                'title',
								'is_active',
								'search_suggestion_id',
                                'front_suggession_title',
                                'suggession_link',
                                'if_user_search_contains'
                            ];
                            
    public function suggestion_category()
    {
      return $this->hasMany('App\Models\SuggestionCategoryModel','search_suggestion_id','id');
    }
}


