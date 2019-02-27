<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Promotion;
use App\Http\Requests\StorePromotionRequest;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        return view('admin.promotions.index');
    }

    public function getPromotions() 
    {
    	$promotions = Promotion::paginate(12);
    	return response()->json($promotions);
    }

    public function store(StorePromotionRequest $request)
    {
    	$promotion = new Promotion();
        $promotion->title = $request->title;
        $promotion->description = $request->description;
        $promotion->titleSEO = $request->titleSEO;
        $promotion->descriptionSEO = $request->descriptionSEO;
        $promotion->keywordsSEO = $request->keywordsSEO;
        $promotion->save();
        $last_insereted_id = $promotion->id;
        if ($request->photo != null) {
            $promotion->photo = $request->photo->store('img/promotions/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        $promotion->save();
        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact(['promotion']));
    }

    public function update(StorePromotionRequest $request, int $id)
    {
    	$promotion = Promotion::findOrFail($id);
        $promotion->title = $request->title;
        $promotion->description = $request->description;
        $promotion->titleSEO = $request->titleSEO;
        $promotion->descriptionSEO = $request->descriptionSEO;
        $promotion->keywordsSEO = $request->keywordsSEO;
        $promotion->save();
        $last_insereted_id = $promotion->id;
        if ($request->photo != null) {
            if($promotion->photo) {
                Storage::disk('uploaded_img')->delete($promotion->photo);
            }
            $promotion->photo = $request->photo->store('img/promotions/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        
        $promotion->save();
        return response()->json(['newPhoto' => $promotion->photo], 200);
    }

    public function destroy(int $id)
    {
    	$promotion = Promotion::findOrFail($id);
        Storage::disk('uploaded_img')->deleteDirectory('img/promotions/' . $id);
        $promotion->delete();
        return response()->json(null, 200);
    }
}
