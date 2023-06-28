<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

// use \Dimsav\Translatable\Translatable;

class CountriesModel extends Model
{
    // use Rememberable,Translatable,SoftDeletes;
	use Rememberable;

	// public $translationModel = 'App\Models\CountryTranslationModel';
 //    public $translationForeignKey = 'country_id';
 //    public $translatedAttributes = ['country_name','locale'];
	
    // protected $primaryKey = 'id';
    protected $table = 'countries';
    protected $fillable = ['name', 'state_id', 'is_active', 'created_at', 'updated_at'];

    public function states()
    {
        return $this->hasMany('App\Models\StateModel','country_id','id');
    }

   	// public function cities()
    // {
    //     return $this->hasMany('App\Models\CityModel','country_id','id');
    // }

    // public function delete()
    // {
    //     $this->translations()->delete();
    //     $this->states()->delete();
    //     $this->cities()->delete();
    //     return parent::delete();
    // }
}
