<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class SendNewsletterModel extends Model
{
	use Rememberable;
	
    protected $table = 'send_newsletter';
    
    protected $fillable = [	
    						'template_id',
    	                    'email',  
    	                    'subject',
    	                    'description', 
    						'status'
    						];
}
