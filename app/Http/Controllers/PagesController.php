<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Cart;

class PagesController extends Controller
{
	private $categories;

	public function __construct()
	{
		$this->categories = Category::all();
	}

    public function index()
    {
    	return view('index-page', ['categories' => $this->categories]);
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

    public function menu()
    {
        return view('menu-page', ['categories' => $this->categories]);
    }

    public function category(int $id)
    {
    	$category = Category::findOrFail($id);
    	$products = $category->products()->get();
    	$tabs = [];
    	$checkboxes = [];
    	
    	foreach ($products as $product) {
    		$product->components = $product->components()->get();
    		if (count($product->attributes()->get())) {
    			$product->attributes = $product->attributes()->get();
    			foreach ($product->attributes()->get() as $attribute) {
    
    				if ($attribute->type == 1) {
    					$tabs[$attribute->id] = $attribute->title;
    				} elseif ($attribute->type == 2) {
    					$checkboxes[$attribute->id] = $attribute->title;
    				}

	    		}
    		}
    	}
    	$tabs = json_encode(array_unique($tabs));
    	$checkboxes = json_encode(array_unique($checkboxes));
    	return view('category-page', compact('category', 'tabs', 'checkboxes', 'products'), ['categories' => $this->categories]);
    }

    public function product(int $id)
    {
    	$product = Product::findOrFail($id);
    	return view('product-page', compact('product'), ['categories' => $this->categories]);
    }

    public function clients()
    {
    	return view('clients-page', ['categories' => $this->categories]);
    }

    public function delivery()
    {
    	return view('delivery-page', ['categories' => $this->categories]);
    }

    public function addToCart(Request $request)
    {
    	$product = Product::findOrFail($request->id);
    	Cart::add($product->id, $product->title, 1, $product->price, ['photo' => $product->photo]);
    	return response()->json(null, 200);
    }

    public function getCartContent()
    {
        $cart = Cart::content();
    	return response()->json(['cart' => $cart], 200); 
    }

}
