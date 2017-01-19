<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trigger extends Model
{
    protected $table = 'triggers';
    protected $fillable = [
        'threshold', 'offset', 'fill', 'enabled', 'product_id', 'product_offer_id'
    ];

    public function getEnabledAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    public function getFillAttribute($value)
    {
        return $value == 1 ? true : false;
    }

}
