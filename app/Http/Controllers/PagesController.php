<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class PagesController extends Controller
{
    public function index()
    {
    	$categories = Category::all();
    	foreach ($categories as $category) {
    		$category->products = $category->products()->get();
    	}
    	return view('index-page');
    }

    public function getCategories()
    {
    	$categories = Category::all();
    	foreach ($categories as $category) {
    		$category->products = $category->products()->get();
    		foreach ($category->products as $product) {
    			$product->components = $product->components()->get();
    		}
    	}
    	return response()->json(['categories' => $categories], 200);
    }
}
