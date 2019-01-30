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
        // $pageTitle = 'Категорії товарів';
        return view('admin.categories.index');
    }

    public function getCategories() 
    {
    	$categories = Category::paginate(12);
    	return response()->json($categories);
    }

    public function edit(int $id)
    {
        $category = Category::findOrFail($id);
        // $products = Product::where('category_id', $id)->paginate(12);

        // $categories = Category::select('id','title','parent_id')->get();

		// $categories = $categories->reject(function($value, $key)use($id){
		// 	return $value->id == $id;
		// });
        // $categories = $categories->toJson();
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
        
        if ($request->photo != null) {
            if($category->photo) {
                Storage::disk('uploaded_img')->delete($category->photo);
            }
            $category->photo = $request->photo->store('img/avatars/admin', ['disk' => 'uploaded_img']);
        }
        
        $category->save();
        return response()->json(['newPhoto' => $category->photo], 200);
    }
}
