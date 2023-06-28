<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetailsModel extends Model
{
    protected $table 	= 'bank_details';
    protected $fillable = ['bank_name','user_id','account_no','account_holder_name','branch'];
}
