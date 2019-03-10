<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gallery;
use App\Http\Requests\StoreGalleryRequest;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        return view('admin.galleries.index');
    }

    public function getGalleries() 
    {
    	$galleries = Gallery::paginate(12);
    	return response()->json($galleries);
    }

    // public function store(StoreComponentRequest $request)
    // {
    // 	$component = new Component();
    //     $component->title = $request->title;
    //     $component->save();
    //     $last_insereted_id = $component->id;
    //     if ($request->photo != null) {
    //         $component->photo = $request->photo->store('img/components/'.$last_insereted_id, ['disk' => 'uploaded_img']);
    //     }
    //     $component->save();
    //     return response()->json(null, 200);
    // }

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
