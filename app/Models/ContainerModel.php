<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerModel extends Model
{	
  //	use SoftDeletes;
	
    protected $table     = 'tbl_container';

    protected $fillable  =  [
    						  'title',
    						  'image',
    						  'is_active',
    					    ];

    
}
