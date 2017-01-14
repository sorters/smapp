<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleLine extends Model
{
    protected $table = 'salelines';
    protected $fillable = [
        'unit_price', 'units', 'state', 'sale_order_id', 'product_id',
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

    public function saleOrder()
    {
        return $this->hasOne('App\SaleOrder');
    }

    public function product()
    {
        return $this->hasOne('App\Product');
    }


}
