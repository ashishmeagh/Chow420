<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model as Eloquent;

class AgeRestrictionModel extends Eloquent
{

    protected $table = 'age_restriction'; 
    protected $fillable           = ['age'];


}
