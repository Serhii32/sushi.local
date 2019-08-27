<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Category;
use App\User;
use App\Order;

class HomeController extends Controller
{
	private $categories;

	public function __construct()
	{
		$this->categories = Category::all();
	}

    public function index()
    {
    	$user = Auth::user();
    	// $orders = Order::orderBy('status')->where('user_id', $user->id)->get();
    	$orders = $user->orders()->get();
    	foreach ($orders as $order) {
    		$order->products = $order->products()->get();
    	}
    	$favorites = $user->favorites()->get();
    	foreach ($favorites as $favorite) {
    		$favorite->components = $favorite->components()->get();
    	}
    	$user = $user->toJson();
    	$orders = $orders->toJson();
    	// dd($orders);
        return view('user.index', compact(['user', 'orders', 'favorites']), ['categories' => $this->categories]);
    }

    public function update(StoreUserRequest $request)
    {
        $user =  Auth::user();
        $user->name = $request->userName;
        $user->phone = $request->userPhone;
        $user->gender = $request->gender;

        $user->street = $request->userStreet;
        $user->building = $request->userBuilding;
        $user->entrance = $request->userEntrance;
        $user->house = $request->userHouse;
        $user->apartment = $request->userApartment;
        $user->floor = $request->userFloor;

        if ($user->email != $request->email) {
            $user->email_verified_at = null;
        }
        $user->email = $request->email;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->avatar != null) {
            if($user->avatar) {
                Storage::disk('uploaded_img')->delete($user->avatar);
            }
            $user->avatar = $request->avatar->store('img/avatars/users/'.$user->id, ['disk' => 'uploaded_img']);
        }
        $user->save();
        return response()->json(['newAvatar' => $user->avatar], 200);
    }
}
