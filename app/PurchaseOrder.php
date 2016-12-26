<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchaseorders';
    protected $fillable = [
        'state', 'comments',
    ];

    public function lines()
    {
        return $this->hasMany('App\PurchaseLine');
    }

    public function getStateAttribute($value)
    {
        return $value == 1 ? true : false;
    }

}
