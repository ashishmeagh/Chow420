<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

class SiteSettingModel extends Eloquent
{
    use Rememberable;
    protected $table      = "site_settings";
    protected $primaryKey = "site_settting_id";

    protected $fillable   = [	
    							'site_name',
    							'site_email_address',
    							'site_contact_number',
    							'site_address',
                                'meta_title',
    							'meta_desc',
    							'meta_keyword',
                                'site_logo',
    							'fb_url',
                                'google_plus_url',
    							'youtube_url',
    							'twitter_url',
    							'rss_feed_url',
                                'instagram_url',
                                'coin_url',
                                'etherscan_url',
                                'social_sharing_site_name',
                                'social_sharing_meta_title',
                                'social_sharing_meta_desc',
                                'social_sharing_meta_keyword',
                                'social_sharing_image',
                                'twilio_account_sid',
                                'twilio_auth_token',
                                'twilio_from_number',
                                'live_tax_api_key',
                                'live_tax_url',
                                'sandbox_tax_api_key',
                                'sandbox_tax_url'
    						];
}
