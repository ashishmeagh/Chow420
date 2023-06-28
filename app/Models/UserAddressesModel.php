<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddressesModel extends CartalystUser
{
    use SoftDeletes;
    // use Messagable;
	

    protected $table = 'user_shipping_address';

}
