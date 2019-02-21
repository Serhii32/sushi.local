<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Cart;
use App\Http\Requests\StoreOrderRequest;
use App\Order;
use LiqPay;
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
    		// if (count($product->attributes()->get())) {
    			$product->attributes = $product->attributes()->get();
    			foreach ($product->attributes()->get() as $attribute) {
    
    				if ($attribute->type == 1) {
    					$tabs[$attribute->id] = $attribute->title;
    				} elseif ($attribute->type == 2) {
    					$checkboxes[$attribute->id] = $attribute->title;
    				}

	    		}
    		// } 
    	}
    	$tabs = json_encode(array_unique($tabs));
    	$checkboxes = json_encode(array_unique($checkboxes));
    	return view('category-page', compact('category', 'tabs', 'checkboxes', 'products'), ['categories' => $this->categories]);
    }

    public function product(int $id)
    {
    	$product = Product::findOrFail($id);
    	$components = $product->components()->get();
    	return view('product-page', compact('product', 'components'), ['categories' => $this->categories]);
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

    public function makeOrder(StoreOrderRequest $request)
    {
    	$order = new Order();
    	$order->name = $request->name;
    	$order->phone = $request->phone;
    	$order->street = $request->street;
    	$order->building = $request->building;
    	$order->entrance = $request->entrance;
    	$order->house = $request->house;
    	$order->apartment = $request->apartment;
    	$order->floor = $request->floor;
    	$order->call = $request->call;
    	$order->date = $request->date;
    	$order->time = $request->time;
    	$order->payment = $request->payment;
    	$order->change = $request->change;
    	$order->persons = $request->persons;
    	$order->sticks = $request->sticks;
    	$order->comment = $request->comment;
    	$order->status = 1;
    	$order->totalSum = Cart::getSubTotal();
    	if(Auth::check()){
            $user = Auth::user();
            $order->user_id = $user->id;
            $user->save();
        }
        $order->save();
        $orderedProducts = Cart::getContent();
        foreach ($orderedProducts as $orderedProduct) {
            $order->products()->attach($orderedProduct->id, ['order_id' => $order->id, 'price' => $orderedProduct->price, 'quantity' => $orderedProduct->quantity]);
        }
        Cart::clear();
        return response()->json(null, 200);
    }

    public function updateQTY(Request $request)
    {
    	Cart::update($request->id, $request->qty);    	
    	return response()->json(null, 200); 
    }

    public function removeItemFromCart(Request $request)
    {
    	Cart::remove($request->id);
    	return response()->json(null, 200);
    }

    public function getCartContent()
    {
        $cart = Cart::content();
    	return response()->json(['cart' => $cart], 200); 
    }

}
