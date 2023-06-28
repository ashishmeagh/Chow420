<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewRatingsModel extends Model
{
   protected $table 	= 'product_rating_review';

   protected $fillable  = [
                'id',
                'product_id',
                'buyer_id',
   							'rating',
   							'title',
   							'review',
                'emoji',
                'user_name'   							
						  ];

  	public function buyer_details()
    {
      return $this->belongsTo('App\Models\BuyerModel','buyer_id','id');
    }

    public function user_details()
    {
      return $this->belongsTo('App\Models\UserModel','buyer_id','id');
    }

    public function product_details()
    {
      return $this->belongsTo('App\Models\ProductModel','product_id','id');
    }

    /************************************************/

    
  

}
