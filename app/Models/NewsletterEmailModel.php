<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class NewsletterEmailModel extends Model
{
	use Rememberable;
	
    protected $table = 'newsletter_emails';
    
    protected $fillable = ['email', 
    						'is_active'
    						];
}
