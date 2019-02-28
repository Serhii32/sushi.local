<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
    		$order->products = $order->products()->get();
    	}
    	$orders = $orders->toJson();
        return view('admin.orders.index', compact(['orders']));
    }
}
