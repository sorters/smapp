<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    protected $table = 'productoffers';
    protected $fillable = [
        'unit_price', 'delivery', 'provider_id', 'product_id',
    ];

    public function product()
    {
        return $this->hasOne('App\Product');
    }

    public function provider()
    {
        return $this->hasMany('App\Provider');
    }

}
