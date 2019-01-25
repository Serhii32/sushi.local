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
    	return $this->belongsToMany('App\Component', 'create_component_product_table', 'product_id', 'component_id')->withTimestamps();
    }
}
