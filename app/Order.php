<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function products()
    {
        return $this->belongsToMany('App\Product', 'order_product', 'order_id', 'product_id')->withPivot('price', 'quantity')->withTimestamps();
    }
}
