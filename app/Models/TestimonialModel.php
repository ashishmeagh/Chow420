<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestimonialModel extends Model
{
    use SoftDeletes;

    protected $table = 'testimonial';
    protected $fillable =  ['name','description','is_active','profile_photo','social_name'];
}
