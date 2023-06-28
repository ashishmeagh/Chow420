<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class NewsletterTemplateModel extends Model
{
	use Rememberable;
	
    protected $table = 'newsletter_template';
    
    protected $fillable = ['newsletter_name', 
    						'newsletter_subject',
    						'newsletter_desc',
    						'is_active'
    						];
}
