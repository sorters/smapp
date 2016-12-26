<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseLine extends Model
{
    protected $table = 'purchaselines';
    protected $fillable = [
        'unit_price', 'units', 'state', 'provider_id', 'purchase_order_id', 'product_id', 'stock_id',
    ];

    public function getUnitsAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getUnitPriceAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getStateAttribute($value)
    {
        return $value == 1 ? true : false;
    }


    public function stock()
    {
        return $this->hasOne('App\Stock');
    }

    public function provider()
    {
        return $this->hasOne('App\Provider');
    }

    public function purchaseOrder()
    {
        return $this->hasOne('App\PurchaseOrder');
    }

    public function product()
    {
        return $this->hasOne('App\Product');
    }


}
