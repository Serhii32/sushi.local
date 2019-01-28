<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    public function getCategories() 
    {
    	$categories = Category::paginate(12);
    	return response()->json($categories);
    }
}
