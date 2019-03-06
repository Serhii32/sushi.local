<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discount;
use App\Http\Requests\StoreDiscountRequest;
// use Carbon\Carbon;

class DiscountController extends Controller
{
    public function index()
    {
        // $date = new Carbon();
        // $date->setTimezone('Europe/Kiev');
        // dd(Carbon::createFromTimestamp(323223)->toDateTimeString());
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
            foreach ($discounts as $discount) {
                $discount->status = 0;
                $discount->save();
            }
        }
        $discount->status = $request->status;
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
        $discount->title = $request->title;
        $discount->percent = $request->percent;
        $discount->startDate = $request->startDate;
        $discount->startTime = $request->startTime;
        $discount->endDate = $request->endDate;
        $discount->endTime = $request->endTime;
        if($request->status)
        {
            $discounts = Discount::all();
            foreach ($discounts as $discount) {
                $discount->status = 0;
                $discount->save();
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
