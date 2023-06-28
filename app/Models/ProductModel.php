<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table     = 'product';

    protected $fillable  =  [
                						  'user_id',
                              'product_name',
                              'description',
                						  'first_level_category_id',
                						  'second_level_category_id',                						
                						  'unit_price',
                						  'age_restriction',
                						  'price_status',
                						  'minimum_quantity',
                               'product_stock',
                              'per_product_quantity', 
                              'reason_for_removal_from_chows_choice',                             
                              'is_active',
                              'is_chows_choice',
                              'brand',
                              'product_count',
                              'shipping_duration',
                              'drop_shipper_name',
                              'drop_shipper_email',
                              'drop_shipper_product_price',
                              'avg_rating',
                              'avg_review',
                              'spectrum',
                              'is_outofstock',
                              'price_drop_changed',
                              'percent_price_drop',
                              'terpenes',
                              'additional_product_image',
                              'coa_link'
                         
    					    ];
    public function first_level_category_details()
    {
       return $this->belongsTo('App\Models\FirstLevelCategoryModel','first_level_category_id','id');
    }

    public function second_level_category_details()
    {
        return $this->belongsTo('App\Models\SecondLevelCategoryModel','second_level_category_id','id');
    }

    public function user_details()
    {
      return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    public function product_comment_details()
    {
        return $this->hasMany('App\Models\ProductCommentModel','product_id','id');
    } 
    public function get_unit_details()
    {
        return $this->belongsTo('App\Models\UnitModel','unit_id','id');
    }
      public function get_favourite_details()
    {
        return $this->belongsTo('App\Models\FavoriteModel','id','product_id');
    }

    public function review_details()
    {
        return $this->hasMany('App\Models\ReviewRatingsModel','product_id','id');
    }

    public function inventory_details()
    {
        return $this->belongsTo('App\Models\ProductInventoryModel','id','product_id');
    } 
     public function product_images_details()
    {
      return $this->hasMany('App\Models\ProductImagesModel','product_id','id');
    }
    public function age_restriction_detail()
    {
        return $this->belongsTo('App\Models\AgeRestrictionModel','age_restriction','id');
    } 
    public function get_brand_detail()
    {
         return $this->belongsTo('App\Models\BrandModel','brand','id');
    }
     public function get_rating_detail()
    {
         return $this->belongsTo('App\Models\ReviewRatingsModel','id','product_id');
    }
    public function get_seller_details()
    {
         return $this->belongsTo('App\Models\UserModel','user_id','id');
    }
    public function get_seller_additional_details()
    {
         return $this->belongsTo('App\Models\SellerModel','user_id','user_id');
    }

    public function get_view_products()
    {
         return $this->belongsTo('App\Models\BuyerViewProductModel','id','product_id');
    }
    public function get_spectrum_details()
    {
       return $this->belongsTo('App\Models\SpectrumModel','spectrum','id');
    }
   
     public function get_category_detail()
    {
         return $this->belongsTo('App\Models\FirstLevelCategoryModel','first_level_category_id','id');
    }

}
