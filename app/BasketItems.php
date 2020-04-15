<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasketItems extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_id', 'product_id', 'item_count', 'price'
    ];

    protected $table = 'order_items';

    public function itemProperty()
    {
        return $this->hasOne('App\Product', 'id','product_id');
    }
}
