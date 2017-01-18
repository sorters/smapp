<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name', 'category_id', 'description',
    ];

    public function category()
    {
        return $this->hasOne('App\Category');
    }

    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function productOffers()
    {
        return $this->hasMany('App\ProductOffer');
    }

    public function purchaseLines()
    {
        return $this->hasMany('App\PurchaseLine');
    }

    public function saleLines()
    {
        return $this->hasMany('App\SaleLine');
    }

    public function offers()
    {
        return $this->hasMany('App\ProductOffer');
    }

    public function getStockAttribute()
    {
        $quantity = 0;

        foreach($this->stocks as $stock) {
            $quantity += $stock->quantity;
        }

        return $quantity;
    }

}