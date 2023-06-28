<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

class LabResultModel extends Eloquent
{
    use Rememberable;
    protected $table      = "lab_result";
    protected $primaryKey = "id";

    protected $fillable   = [	
    							'lab_result',
                                'id',
                                'is_active',
                                'created_at',
                                'updated_at',
                                'deleted_at'
    							
    						];
}
