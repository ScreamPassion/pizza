<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $fillable = [
        'uid', 'session', 'address', 'name', 'email', 'ordered'
    ];

    protected $table = 'orders';

    public function items()
    {
        return $this->hasMany('App\BasketItems', 'order_id');
    }
}
