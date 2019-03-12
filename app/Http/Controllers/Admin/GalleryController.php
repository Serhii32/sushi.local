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

    public function getPhotos(int $id)
    {
    	$gallery = Gallery::findOrFail($id);
    	$photos = $gallery->photos()->get();
    	return response()->json($photos);
    }

    public function deletePhoto(int $id)
    {
    	$photo = Photo::findOrFail($id);
        Storage::disk('uploaded_img')->delete($photo->url);
        $photo->delete();
        return response()->json(null, 200);
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

    public function update(StoreGalleryRequest $request, int $id)
    {
    	$gallery = Gallery::findOrFail($id);
        $gallery->title = $request->title;
        $gallery->save();
        $last_insereted_id = $gallery->id;
        if ($request->photo != null) {
            if($gallery->photo) {
                Storage::disk('uploaded_img')->delete($gallery->photo);
            }
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
        return response()->json(['newPhoto' => $gallery->photo], 200);
    }

    public function destroy(int $id)
    {
    	$gallery = Gallery::findOrFail($id);
        Storage::disk('uploaded_img')->deleteDirectory('img/galleries/' . $id);
		$photos = $gallery->photos()->get();
		foreach ($photos as $photo) {
			 Storage::disk('uploaded_img')->delete($photo->url);
			 $photo->delete();
		}
        $gallery->delete();
        return response()->json(null, 200);
    }
}
