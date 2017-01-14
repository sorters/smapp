<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'name', 'description',
    ];

    public function orders()
    {
        return $this->hasMany('App\SaleOrder');
    }
}
