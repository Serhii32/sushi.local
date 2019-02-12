<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function getCategories() 
    {
    	$categories = Category::paginate(12);
    	return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
    	$category = new Category();
        $category->title = $request->title;
        $category->titleSEO = $request->titleSEO;
        $category->descriptionSEO = $request->descriptionSEO;
        $category->keywordsSEO = $request->keywordsSEO;
        $category->save();
        $last_insereted_id = $category->id;
        if ($request->photo != null) {
            $category->photo = $request->photo->store('img/categories/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        if ($request->icon != null) {
            $category->icon = $request->icon->store('img/categories/'.$last_insereted_id.'/icon', ['disk' => 'uploaded_img']);
        }
        $category->save();
        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $category = Category::findOrFail($id);
        // $products = Product::where('category_id', $id)->paginate(12);
        // $pageTitle = 'Редактировать ' . $category->title;
        return view('admin.categories.edit', compact(['category']));
    }

    public function update(StoreCategoryRequest $request, int $id)
    {
    	$category = Category::findOrFail($id);
        $category->title = $request->title;
        $category->titleSEO = $request->titleSEO;
        $category->descriptionSEO = $request->descriptionSEO;
        $category->keywordsSEO = $request->keywordsSEO;
        $category->save();
        $last_insereted_id = $category->id;
        if ($request->photo != null) {
            if($category->photo) {
                Storage::disk('uploaded_img')->delete($category->photo);
            }
            $category->photo = $request->photo->store('img/categories/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        if ($request->icon != null) {
            if($category->icon) {
                Storage::disk('uploaded_img')->delete($category->icon);
            }
            $category->icon = $request->icon->store('img/categories/'.$last_insereted_id.'/icon', ['disk' => 'uploaded_img']);
        }
        $category->save();
        return response()->json(['newPhoto' => $category->photo, 'newIcon' => $category->icon], 200);
    }

    public function destroy(int $id)
    {
    	$category = Category::findOrFail($id);
        Storage::disk('uploaded_img')->deleteDirectory('img/categories/' . $id);
        $category->delete();
        return response()->json(null, 200);
    }
}
