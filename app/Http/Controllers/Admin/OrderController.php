<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }
    public function getOrders()
    {
    	$orders = Order::all();
        foreach ($orders as $order) {
    		$order->products = $order->products()->get();
    	}
    	return response()->json(['orders' => $orders], 200);
    }
    public function destroy(int $id)
    {
    	$order = Order::findOrFail($id);
        $order->products()->detach();
        $order->delete();
        return response()->json(null, 200);
    }
}
