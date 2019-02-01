<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function components()
    {
    	return $this->belongsToMany('App\Component', 'component_product', 'product_id', 'component_id')->withTimestamps();
    }

    public function attributes()
    {
    	return $this->belongsToMany('App\Attribute', 'attribute_product', 'product_id', 'attribute_id')->withTimestamps();
    }
}
