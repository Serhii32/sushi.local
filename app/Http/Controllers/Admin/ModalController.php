<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modal;
use App\Http\Requests\StoreModalRequest;

class ModalController extends Controller
{
    public function index()
    {
        return view('admin.modals.index');
    }

    public function getModals() 
    {
    	$modals = Modal::all();
    	return response()->json($modals);
    }

    public function store(StoreModalRequest $request)
    {
    	$modal = new Modal();
        $modal->title = $request->title;
        if($request->status)
        {
        	$modals = Modal::all();
        	foreach ($modals as $modal) {
        		$modal->status = 0;
        		$modal->save();
        	}
        }
        $modal->status = $request->status;
        $modal->description= $request->description;
        $modal->save();
        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $modal = Modal::findOrFail($id);
        return view('admin.modals.edit', compact(['modal']));
    }

    public function update(StoreModalRequest $request, int $id)
    {
    	$modal = Modal::findOrFail($id);
        $modal->title = $request->title;
        if($request->status)
        {
        	$modals = Modal::all();
        	foreach ($modals as $modal) {
        		$modal->status = 0;
        		$modal->save();
        	}
        }
        $modal->status = $request->status;
        $modal->description= $request->description;
        $modal->save();
        
        return response()->json(null, 200);
    }

    public function destroy(int $id)
    {
    	$modal = Modal::findOrFail($id);
        $modal->delete();
        return response()->json(null, 200);
    }
}
