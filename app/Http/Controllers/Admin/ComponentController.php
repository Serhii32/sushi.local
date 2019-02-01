<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Component;
use App\Http\Requests\StoreComponentRequest;
use Illuminate\Support\Facades\Storage;

class ComponentController extends Controller
{
    public function index()
    {
        // $pageTitle = 'Категорії товарів';
        return view('admin.components.index');
    }

    public function getComponents() 
    {
    	$components = Component::paginate(12);
    	return response()->json($components);
    }

    public function store(StoreComponentRequest $request)
    {
    	$component = new Component();
        $component->title = $request->title;
        $component->save();
        $last_insereted_id = $component->id;
        if ($request->photo != null) {
            $component->photo = $request->photo->store('img/components/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        $component->save();
        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $component = Component::findOrFail($id);
        // $pageTitle = 'Редактировать ' . $category->title;
        return view('admin.components.edit', compact(['component']));
    }

    public function update(StoreComponentRequest $request, int $id)
    {
    	$component = Component::findOrFail($id);
        $component->title = $request->title;
        $component->save();
        $last_insereted_id = $component->id;
        if ($request->photo != null) {
            if($component->photo) {
                Storage::disk('uploaded_img')->delete($component->photo);
            }
            $component->photo = $request->photo->store('img/components/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        
        $component->save();
        return response()->json(['newPhoto' => $component->photo], 200);
    }

    public function destroy(int $id)
    {
    	$component = Component::findOrFail($id);
        Storage::disk('uploaded_img')->deleteDirectory('img/components/' . $id);
        $component->delete();
        return response()->json(null, 200);
    }
}
