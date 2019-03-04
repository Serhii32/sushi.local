<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discount;
use App\Http\Requests\StoreDiscountRequest;
use Carbon\Carbon;

class DiscountController extends Controller
{
    public function index()
    {
        $date = new Carbon();
        $date->setTimezone('Europe/Kiev');
        dd($date);
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
        $discount->status = $request->status;
        $discount->save();

        return response()->json(null, 200);
    }

    // public function edit(int $id)
    // {
    //     $component = Component::findOrFail($id);
    //     // $pageTitle = 'Редактировать ' . $category->title;
    //     return view('admin.components.edit', compact(['component']));
    // }

    // public function update(StoreComponentRequest $request, int $id)
    // {
    // 	$component = Component::findOrFail($id);
    //     $component->title = $request->title;
    //     $component->save();
    //     $last_insereted_id = $component->id;
    //     if ($request->photo != null) {
    //         if($component->photo) {
    //             Storage::disk('uploaded_img')->delete($component->photo);
    //         }
    //         $component->photo = $request->photo->store('img/components/'.$last_insereted_id, ['disk' => 'uploaded_img']);
    //     }
        
    //     $component->save();
    //     return response()->json(['newPhoto' => $component->photo], 200);
    // }

    // public function destroy(int $id)
    // {
    // 	$component = Component::findOrFail($id);
    //     Storage::disk('uploaded_img')->deleteDirectory('img/components/' . $id);
    //     $component->delete();
    //     return response()->json(null, 200);
    // }
}
