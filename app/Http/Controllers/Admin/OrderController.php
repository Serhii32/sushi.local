<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('status')->paginate(12);
        // return view('admin.orders.orders-index', compact(['orders']));
    }
}
