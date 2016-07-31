<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name', 'category_id', 'description', 'buy_price', 'sell_price',
    ];

    public function category()
    {
        return $this->hasOne('App\Category');
    }
}
