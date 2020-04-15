<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_name', 'src', 'discount', 'price', 'rating'
    ];

    protected $table = 'products';
}
