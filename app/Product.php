<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name', 'category_id', 'stock_id', 'description',
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
}
