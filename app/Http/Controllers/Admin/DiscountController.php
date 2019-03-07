<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discount;
use App\Http\Requests\StoreDiscountRequest;

class DiscountController extends Controller
{
    public function index()
    {
        return view('admin.discounts.index');
    }

    public function getDiscounts() 
    {
    	$discounts = Discount::all();
    	return response()->json($discounts);
    }

    public function store(StoreDiscountRequest $request)
    {
    	$discount = new Discount();
        $discount->title = $request->title;
        $discount->percent = $request->percent;
        $discount->startDate = $request->startDate;
        $discount->startTime = $request->startTime;
        $discount->endDate = $request->endDate;
        $discount->endTime = $request->endTime;
        if($request->status)
        {
            $discounts = Discount::all();
            foreach ($discounts as $iterableDiscount) {
                $iterableDiscount->status = 0;
                $iterableDiscount->save();
            }
        }
        $discount->status = $request->status;
        if ($request->input('dayOfWeek')!=null && is_string($request->input('components'))) {
            $components = array_unique(explode(",", $request->input('components')));
            if(!in_array("0", $components)){
                foreach ($components as $component) {
                    $product->components()->attach($component);
                }
            }
        }
        $discount->dayOfWeek = $request->dayOfWeek;
        $discount->save();

        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $discount = Discount::findOrFail($id);
        return view('admin.discounts.edit', compact(['discount']));
    }

    public function update(StoreDiscountRequest $request, int $id)
    {
    	$discount = Discount::findOrFail($id);
        // return dd($request);
        $discount->title = $request->title;
        $discount->percent = $request->percent;
        $discount->startDate = $request->startDate;
        $discount->startTime = $request->startTime;
        $discount->endDate = $request->endDate;
        $discount->endTime = $request->endTime;
        if($request->status)
        {
            $discounts = Discount::all();
            foreach ($discounts as $iterableDiscount) {
                $iterableDiscount->status = 0;
                $iterableDiscount->save();
            }
        }
        $discount->status = $request->status;
        $discount->dayOfWeek = $request->dayOfWeek;
        $discount->save();

       
        return response()->json(null, 200);
    }

    public function destroy(int $id)
    {
    	$discount = Discount::findOrFail($id);
        $discount->delete();
        return response()->json(null, 200);
    }
}
