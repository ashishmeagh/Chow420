<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerDocumentsModel extends Model
{
    protected $table     = 'seller_documents';

    protected $fillable  =  [
                				'seller_id',
                                'document_title',
                                'document'
    					    ];
    

    public function seller_details()
    {
        return $this->hasMany('App\Models\SellerModel','seller_id','id');
    }
}
