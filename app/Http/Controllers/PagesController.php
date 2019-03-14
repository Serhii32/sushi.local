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
use App\Gallery;

class PagesController extends Controller
{
	private $categories;

	public function __construct()
	{
		$this->categories = Category::all();
	}

    public function index()
    {
        $pageTitle = "Суші-бар Sushiwin | замовити смачні суші з доставкою у Вінниці ";
        $pageDescription = "Замовляйте суші, роли, сети в суші-барі Sushiwin сушивин з доставкою. Також можливий самовивіз";
        $pageKeywords = "суши, суші, сушивін, доставка суши винница, доставка суші вінниця";
    	return view('index-page', compact('pageTitle', 'pageDescription', 'pageKeywords'), ['categories' => $this->categories]);
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
        $pageTitle = "Меню суші-бар  Sushiwin | замовити суші смачні суші з доставкою у Вінниці";
        $pageDescription = "Меню Сушивін Sushiwin - роли, сети, нігірі, гункани, салати та напої з доставкою додому м.Вінниця або самовивіз";
        $pageKeywords = "меню суши, доставка суши, сушивін, сушивин, Sushiwin, суши бар Сушивін, Винница, суши в Виннице";
        return view('menu-page', compact('pageTitle', 'pageDescription', 'pageKeywords'), ['categories' => $this->categories]);
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

    public function gallery(int $id)
    {
        $gallery = Gallery::findOrFail($id);
        $photos = $gallery->photos()->get();

        return view('gallery-page', compact('gallery', 'photos'), ['categories' => $this->categories]);
    }

    public function promotions()
    {
    	$promotions = Promotion::paginate(12);
        $pageTitle = "Акції суші-бар  Sushiwin | замовити суші смачні суші з доставкою у Вінниці";
        $pageDescription = "Акції в суші барі Sushiwin  - сети, нігірі, гункани, салати та напої у м.Вінниця. зі знижкою Безкоштовна доставка від 250 грн";
        $pageKeywords = "Акції, суші зі знижками, клієнтам, доставка суші,  Sushiwin, сушівін, суші у вінниці з доставкою, суши купить с доставкой, постійні знижки на роли";
    	return view('promotions-page', compact('promotions', 'pageTitle', 'pageDescription', 'pageKeywords'), ['categories' => $this->categories]);
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
        $pageTitle = "Клієнтам суші-бар  Sushiwin | замовити суші смачні суші з доставкою у Вінниці";
        $pageDescription = "Клієнтам Sushiwin  - замовити роли сети, нігірі, гункани, салати та напої у м.Вінниця. Безкоштовна доставка від 250 грн";
        $pageKeywords = "клієнтам, доставка суші,  Sushiwin, сушівін, суші у вінниці з доставкою, суши купить с доставкой";
        $galleries = Gallery::all();
    	return view('clients-page', compact('galleries', 'pageTitle', 'pageDescription', 'pageKeywords'), ['categories' => $this->categories]);
    }

    public function agreement()
    {
        return view('agreement-page', ['categories' => $this->categories]);
    }

    public function delivery()
    {
        $pageTitle = "Доставка суші-бар  Sushiwin | замовити суші смачні суші з доставкою у Вінниці";
        $pageDescription = "Доставка суші від Sushiwin  - замовити роли сети, нігірі, гункани, салати та напої у м.Вінниця. Безкоштовна доставка від 250 грн";
        $pageKeywords = "доставка, суші, доставка Sushiwin, сушівін, суші у вінниці з доставкою, безкоштовна доставка суші";
    	return view('delivery-page', compact('pageTitle', 'pageDescription', 'pageKeywords'), ['categories' => $this->categories]);
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

        $date = new Carbon();
        $date->setTimezone('Europe/Kiev');

        $mailDiscount = null;

        foreach ($discounts as $discount) {
            if ($discount->status == 1) {

                $dayOfWeek = explode(",", $discount->dayOfWeek);

                if (in_array($date->dayOfWeekIso, $dayOfWeek)||in_array('0', $dayOfWeek)) {

                    $startDateChecker = Carbon::createFromFormat('Y-m-d', $discount->startDate, 'Europe/Kiev');
                    $endDateChecker = Carbon::createFromFormat('Y-m-d', $discount->endDate, 'Europe/Kiev');

                    $dateChecker = $discount->startDate==null || $discount->endDate==null || $startDateChecker <= $date->format('Y-m-d') && $endDateChecker >= $date->format('Y-m-d');

                    if ($dateChecker) {
                        // $startTimeChecker = Carbon::parse($date->format('Y-m-d'). ' ' .$discount->startTime);
                        // $endTimeChecker = Carbon::parse($date->format('Y-m-d'). ' ' .$discount->endTime); 

                        $startTimeChecker = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d'). ' ' .$discount->startTime, 'Europe/Kiev');
                        $endTimeChecker = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d'). ' ' .$discount->endTime, 'Europe/Kiev');

                        $timeChecker = $discount->startTime==null || $discount->endTime==null || $startTimeChecker <= $date && $endTimeChecker >= $date;
                        
                        if ($timeChecker) {

                            $mailDiscount = $discount->percent;
                            $discountSum = ($order->totalSum * $discount->percent)/100;
                            $order->totalSum -= $discountSum;
                            break;

                        }
                    }
                }
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
				'amount'=> $order->totalSum,
				'currency'=>'UAH',
				'order_id'=>strval($order->id),
				'language'=>'uk',
				'description'=>'Оплата замовлення',
				'result_url'=>'https://sushiwin.vn.ua/thank_you',
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
            $sentMailProducts .= "<h4>" . $orderedProduct->name . " Кількість: " . $orderedProduct->qty . "</h4>";
        }

        $messageAdmin = "Клієнт " . $order->name . " зробив замовлення на сайті sushiwin.vn.ua</h4>
        <h4>Номер замовлення: " . $order->id . "</h4>
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

        <h4>Діє знижка: " . ($mailDiscount ? $mailDiscount : "Ні") . "</h4>

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
            $messageAdmin = "Клієнт " . $order->name . " оплатив замовлення номер ". $order->id ."</h4>";
            $headersAdmin = "Content-type:text/html;charset=UTF-8";
            mail("sushiwin18@gmail.com ", "Замовлення було оплачено онлайн картою", $messageAdmin, $headersAdmin);
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

                $dayOfWeek = explode(",", $discount->dayOfWeek);

                if (in_array($date->dayOfWeekIso, $dayOfWeek)||in_array('0', $dayOfWeek)) {

                    $startDateChecker = Carbon::createFromFormat('Y-m-d', $discount->startDate, 'Europe/Kiev');
                    $endDateChecker = Carbon::createFromFormat('Y-m-d', $discount->endDate, 'Europe/Kiev');

                    $dateChecker = $discount->startDate==null || $discount->endDate==null || $startDateChecker <= $date->format('Y-m-d') && $endDateChecker >= $date->format('Y-m-d');

                    if ($dateChecker) {
                        // $startTimeChecker = Carbon::parse($date->format('Y-m-d'). ' ' .$discount->startTime);
                        // $endTimeChecker = Carbon::parse($date->format('Y-m-d'). ' ' .$discount->endTime); 

                        $startTimeChecker = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d'). ' ' .$discount->startTime, 'Europe/Kiev');
                        $endTimeChecker = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d'). ' ' .$discount->endTime, 'Europe/Kiev');

                        $timeChecker = $discount->startTime==null || $discount->endTime==null || $startTimeChecker <= $date && $endTimeChecker >= $date;

                        if ($timeChecker) {
                            $cartDiscount = $discount;
                            break;
                        }
                    }
                }
            }
        }
    	return response()->json(['cart' => $cart, 'messageModal' => $messageModal, 'cartDiscount' => $cartDiscount], 200); 
    }

    public function getCartContentNumber()
    {
        $counter = Cart::count();
        return response()->json(['counter' => $counter], 200);
    }

}
