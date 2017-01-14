<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    protected $table = 'saleorders';
    protected $fillable = [
        'state', 'comments', 'customer_id',
    ];

    public function lines()
    {
        return $this->hasMany('App\SaleLine');
    }

    public function provider()
    {
        return $this->hasOne('App\Provider');
    }

    public function getStateAttribute($value)
    {
        return $value == 1 ? true : false;
    }

}
