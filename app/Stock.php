<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $fillable = [
        'product_id', 'provider_id', 'purchase_line_id', 'quantity',
    ];

    public function getQuantityAttribute($value)
    {
        return number_format($value, 2);
    }

    public function product()
    {
        return $this->hasOne('App\Product');
    }

    public function purchaseLine()
    {
        return $this->hasOne('App\PurchaseLine');
    }

    public function provider()
    {
        return $this->hasOne('App\Provider');
    }
}
