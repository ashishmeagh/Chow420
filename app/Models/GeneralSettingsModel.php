<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSettingsModel extends Model
{
    protected $table     = 'general_settings';

    protected $fillable  =  [
    						  'data_id',
    						  'data_value',
    						  'data_live',
    						  'data_sandbox'
    					    ];
}
