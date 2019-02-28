<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Promotion;
use Cart;
use App\Http\Requests\StoreOrderRequest;
use App\Order;
use LiqPay;
use Auth;

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
        $userFavorites = Auth::user()->favorites()->get();
        $userFavoriteIds = [];
        foreach ($userFavorites as $userFavorite) {
            $userFavoriteIds[] = $userFavorite->id;
        }
    	foreach ($categories as $category) {
    		$category->products = $category->products()->get();
    		foreach ($category->products as $product) {
                $product->isFavorite = false;
                if (in_array($product->id, $userFavoriteIds)) {
                    $product->isFavorite = true;
                }
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

    public function promotions()
    {
    	$promotions = Promotion::paginate(12);
    	return view('promotions-page', compact('promotions'), ['categories' => $this->categories]);
    }

    public function promotion(int $id)
    {
    	$promotion = Promotion::findOrFail($id);
    	return view('promotion-page', compact('promotion'), ['categories' => $this->categories]);
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

    public function addToFavorites(Request $request)
    {
        $response = ['redirect'=>'/login'];
    	if(Auth::check()) {
    		$user = Auth::user();
    		$user->favorites()->attach($request->id);
            $response = null;
    	}
    	return response()->json($response, 200);
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
    	$order->totalSum = Cart::subtotal();
    	if($order->totalSum < 250) {
    		$order->totalSum+=25;
    	}
    	if(Auth::check()){
            $user = Auth::user();
            $order->user_id = $user->id;
            $user->save();
        }
        $order->save();
        $orderedProducts = Cart::content();
        foreach ($orderedProducts as $orderedProduct) {
            $order->products()->attach($orderedProduct->id, ['order_id' => $order->id, 'price' => $orderedProduct->price, 'quantity' => $orderedProduct->qty]);
        }

    	$response = null;

        if($request->payment==="0") {
			$public_key = 'i94485343771';
			$private_key= 'ib7ZU0Z7VbLWSxaXSm1KOaNH90waiEhMsziMJh5t';

			$liqpay = new LiqPay($public_key, $private_key);

			$params = [
                'public_key'=> $public_key,
				'version'=>'3',
				'action'=>'pay',
				'amount'=> strval(Cart::subtotal()), 
				'currency'=>'UAH',
				'order_id'=>strval($order->id),
				'language'=>'uk',
				'description'=>'Оплата замовлення',
				'result_url'=>'http://sushiwin.vn.ua/thank_you',
			];

			$data = base64_encode(json_encode($params));

			$signature = $liqpay->cnb_signature($params);

			$response = ['data' => $data, 'signature' => $signature];

			$order->public_key = $public_key;

			$order->save();

		} else {
            Cart::destroy();
        }
		
		return response()->json($response, 200);

    }

    public function thankYou(Request $request)
    {
    	$params=json_decode(base64_decode($request->data));
    	$order = Order::findOrFail($params->order_id);
    	if ($params->public_key == $order->public_key) {
    		$order->paid = 1;
    		$order->save();
    		Cart::destroy();
    		return view('thank-you-page', ['categories' => $this->categories]);
    	}
    	return abort(403);
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
