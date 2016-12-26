<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';
    protected $fillable = [
        'name', 'description',
    ];

    public function lines()
    {
        return $this->hasMany('App\PurchaseLine');
    }

    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }

    public function productOffers()
    {
        return $this->hasMany('App\ProductOffer');
    }

}
