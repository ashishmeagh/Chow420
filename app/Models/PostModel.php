<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table     = 'forum_posts';

    protected $fillable  =  [
                						  'user_id',
                              'title',
                              'description',
                						  'container_id',
                						  'user_type',
                              'is_active',
                              'post_type',
                              'image',
                              'video'
                         
    					    ];
   
    public function user_details()
    {
      return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    public function get_seller_details()
    {
         return $this->belongsTo('App\Models\UserModel','user_id','id');
    }
    public function get_seller_additional_details()
    {
         return $this->belongsTo('App\Models\SellerModel','user_id','user_id');
    }
     public function get_container_detail()
    {
         return $this->belongsTo('App\Models\ContainerModel','container_id','id');
    }


}
