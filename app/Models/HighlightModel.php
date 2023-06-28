<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HighlightModel extends Model
{
    protected $table     = 'highlight';

    protected $fillable  =  [
                						  'title',
                              'description',
                              'is_active',
                              'hilight_image',
                						
    					    ];
}
