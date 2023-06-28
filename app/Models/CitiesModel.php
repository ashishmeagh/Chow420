<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

use \Dimsav\Translatable\Translatable;

class CitiesModel extends Model
{
    use Rememberable,Translatable;
        
	//use SoftDeletes;
    protected $table = 'cities';
    protected $fillable = ['name','state_id','is_active'];

    

    public function state_details()
    {
        return $this->belongsTo('App\Models\StatesModel','state_id','id');
    }
    
  
    

}
