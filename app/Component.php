<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function products()
    {
    	return $this->belongsToMany('App\Product', 'component_product', 'component_id', 'product_id')->withTimestamps();
    }
}
