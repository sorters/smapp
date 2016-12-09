<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $fillable = [
        'product_id', 'quantity',
    ];

    public function getQuantityAttribute($value)
    {
        return number_format($value, 2);
    }
}
