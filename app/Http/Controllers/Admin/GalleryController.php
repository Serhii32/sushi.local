<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gallery;
use App\Photo;
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

    public function store(StoreGalleryRequest $request)
    {
    	$gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->save();
        $last_insereted_id = $gallery->id;

        if ($request->photo != null) {
            $gallery->photo = $request->photo->store('img/galleries/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        } 
        
        $i = 0;
        while (true) {
            if ($request->{'photos_'.$i} != null) {
                $photo = new Photo();
                $photo->gallery_id = $last_insereted_id;
                $photo->url = $request->{'photos_'.$i}->store('img/galleries/'.$last_insereted_id.'/photos', ['disk' => 'uploaded_img']);
                $photo->save();
            } else {
                break;
            }
            $i++;
        }
        $gallery->save();
        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.galleries.edit', compact(['gallery']));
    }

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
