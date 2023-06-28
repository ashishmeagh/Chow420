<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    protected $table 	= 'events';
    protected $fillable = ['user_id','message','title'];

     
}
