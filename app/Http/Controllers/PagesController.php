<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Promotion;
use Cart;
use App\Http\Requests\StoreOrderRequest;
use App\Order;
use App\Modal;
use App\Discount;
use LiqPay;
use Auth;
use Carbon\Carbon;
use DateTime;

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
        $userFavoriteIds = [];
        if (Auth::check()) {
            $userFavorites = Auth::user()->favorites()->get();
            foreach ($userFavorites as $userFavorite) {
                $userFavoriteIds[] = $userFavorite->id;
            }
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
    	
        $userFavoriteIds = [];
        if (Auth::check()) {
            $userFavorites = Auth::user()->favorites()->get();
            foreach ($userFavorites as $userFavorite) {
                $userFavoriteIds[] = $userFavorite->id;
            }
        }

    	foreach ($products as $product) {
            $product->isFavorite = false;
            if (in_array($product->id, $userFavoriteIds)) {
                $product->isFavorite = true;
            }
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

        $pageTitle = $category->titleSEO;
        $pageDescription = $category->descriptionSEO;
        $pageKeywords = $category->keywordsSEO;

    	return view('category-page', compact('category', 'tabs', 'checkboxes', 'products', 'pageTitle', 'pageDescription', 'pageKeywords'), ['categories' => $this->categories]);
    }

    public function promotions()
    {
    	$promotions = Promotion::paginate(12);
    	return view('promotions-page', compact('promotions'), ['categories' => $this->categories]);
    }

    public function promotion(int $id)
    {
    	$promotion = Promotion::findOrFail($id);
        $pageTitle = $promotion->titleSEO;
        $pageDescription = $promotion->descriptionSEO;
        $pageKeywords = $promotion->keywordsSEO;
    	return view('promotion-page', compact('promotion', 'pageTitle', 'pageDescription', 'pageKeywords'), ['categories' => $this->categories]);
    }

    public function product(int $id)
    {
        $userFavoriteIds = [];
        if (Auth::check()) {
            $userFavorites = Auth::user()->favorites()->get();
            foreach ($userFavorites as $userFavorite) {
                $userFavoriteIds[] = $userFavorite->id;
            }
        }
    	$product = Product::findOrFail($id);
        $product->isFavorite = false;
        if (in_array($product->id, $userFavoriteIds)) {
            $product->isFavorite = true;
        }
    	$components = $product->components()->get();

        $pageTitle = $product->titleSEO;
        $pageDescription = $product->descriptionSEO;
        $pageKeywords = $product->keywordsSEO;
    	return view('product-page', compact('product', 'components', 'pageTitle', 'pageDescription', 'pageKeywords'), ['categories' => $this->categories]);
    }

    public function clients()
    {
    	return view('clients-page', ['categories' => $this->categories]);
    }

    public function agreement()
    {
        return view('agreement-page', ['categories' => $this->categories]);
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
            if($user->favorites->contains($request->id))
            {
                $user->favorites()->detach($request->id);
            } else {
                $user->favorites()->attach($request->id);
            }
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

        $discounts = Discount::all();
        foreach ($discounts as $discount) {
            if ($discount->status == 1) {
                $discountSum = ($order->totalSum * $discount->percent)/100;
                $order->totalSum -= $discountSum;
                break;
            }
        }

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
        
        $sentMailProducts = "";

        foreach ($orderedProducts as $orderedProduct) {
            $sentMailProducts .= "<h4>" . $orderedProduct->name . "</h4>";
        }

        $messageAdmin = "Клієнт " . $order->name . " зробив замовлення на сайті sushiwin.vn.ua</h4>
        <h4>Вулиця: " . $order->street . "</h4>
        <h4>Будинок: " . $order->building . "</h4>
        <h4>Під'їзд: " . $order->entrance . "</h4>
        <h4>Корпус: " . $order->house . "</h4>
        <h4>Квартира: " . $order->apartment . "</h4>
        <h4>Поверх: " . $order->floor . "</h4>
        <h4>Дата: " . $order->date . "</h4>
        <h4>Час: " . $order->time . "</h4>
        <h4>Коментар: " . $order->comment . "</h4>
        <h4>Сума: " . $order->totalSum . "</h4>
        <h4>Дзвонити в двері: " . ($order->call ? "Так" : "Ні") . "</h4>
        <h4>Тип оплати: " . ($order->payment ? "Готівкою" : "Онлайн картою") . "</h4>
        <h4>Підготувати здачу з: " . $order->change . "</h4>
        <h4>Кількість персон: " . $order->persons . "</h4>
        <h4>Тип паличок: " . ($order->sticks ? "Звичайні" : "Навчальні") . "</h4>

        <h4>Замовлені продукти:</h4>". $sentMailProducts .

        "<h4>Телефон: " . $order->phone . "</h4>";
        $headersAdmin = "Content-type:text/html;charset=UTF-8";
        mail("sushiwin18@gmail.com ", "Зроблено нове замовлення на сайте sushiwin.vn.ua", $messageAdmin, $headersAdmin);

		return response()->json($response, 200);

    }

    public function thankYou(Request $request)
    {
    	$params=json_decode(base64_decode($request->data));
    	$order = Order::findOrFail($params->order_id);
    	if ($params->public_key == $order->public_key && $params->status != "failure") {
    		$order->paid = 1;
    		$order->save();
    		Cart::destroy();
    		return view('thank-you-page', ['categories' => $this->categories]);
    	} elseif ($params->public_key == $order->public_key) {
            $order->paid = 0;
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
        $messageModal = null;
        $cartDiscount = null;
        $modals = Modal::all();
        foreach ($modals as $modal) {
            if ($modal->status == 1) {
                $messageModal = $modal;
                break;
            }
        }
        $discounts = Discount::all();

        $date = new Carbon();
        $date->setTimezone('Europe/Kiev');

        foreach ($discounts as $discount) {
            if ($discount->status == 1) {

                $dateChecker = Carbon::parse($discount->startDate)->format('Y-m-d') >= $date->format('Y-m-d') && Carbon::parse($discount->endDate)->format('Y-m-d') <= $date->format('Y-m-d');

                if ($dateChecker) {
                    $timeChecker = Carbon::parse($discount->startTime)->format('H:i') >= $date->format('H:i') && Carbon::parse($discount->endTime)->format('H:i') <= $date->format('H:i');
                    if ($timeChecker) {
                        $cartDiscount = $discount;
                        break;
                    }
                }
                                
                return $date->format('Y-m-d');

                // return $date->dayOfWeek;
               
            }
        }
    	return response()->json(['cart' => $cart, 'messageModal' => $messageModal, 'cartDiscount' => $cartDiscount], 200); 
    }

}
