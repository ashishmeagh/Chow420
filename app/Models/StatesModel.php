<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;
// use \Dimsav\Translatable\Translatable; 

class StatesModel extends Model
{
    use Rememberable;
    

	//use SoftDeletes;
    protected $table = 'states';
    protected $fillable = ['name','country_id','category_ids','tax_percentage','is_active','is_documents_required','required_documents','created_at','updated_at','text'];
  

    public function country_details()
    {
        return $this->belongsTo('App\Models\CountriesModel','country_id','id');
    }

    public function cities()
    {
        return $this->hasMany('App\Models\CitiesModel', 'country_id', 'id');
    }
    
}
