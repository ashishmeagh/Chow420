<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleSubAdminMappingModel extends Model
{
    protected $table = 'module_sub_admin_mapping';

    protected $fillable = ['user_id','module_id'];


    public function module_details()
    {
    	return $this->belongsTo('App\Models\ModulesModel','module_id','id');
    }
}
