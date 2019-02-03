<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // $pageTitle = 'Категорії товарів';
        return view('admin.products.index');
    }

    public function getProducts() 
    {
    	$products = Product::paginate(12);
    	$categories = Category::pluck('title','id')->all();
    	$components = Component::pluck('title','id')->all();
    	$attributes = Attribute::plick('title','id')->all();
    	return response()->json(['products' => $products, 'categories' => $categories, 'components' => $components, 'attributes' => $attributes]);
    }

    // public function store(StoreProductRequest $request)
    // {
    // 	$category = new Category();
    //     $category->title = $request->title;
    //     $category->titleSEO = $request->titleSEO;
    //     $category->descriptionSEO = $request->descriptionSEO;
    //     $category->keywordsSEO = $request->keywordsSEO;
    //     $category->save();
    //     $last_insereted_id = $category->id;
    //     if ($request->photo != null) {
    //         $category->photo = $request->photo->store('img/categories/'.$last_insereted_id, ['disk' => 'uploaded_img']);
    //     }
    //     $category->save();
    //     return response()->json(null, 200);
    // }

    // public function edit(int $id)
    // {
    //     $category = Category::findOrFail($id);
    //     // $products = Product::where('category_id', $id)->paginate(12);
    //     // $pageTitle = 'Редактировать ' . $category->title;
    //     return view('admin.categories.edit', compact(['category']));
    // }

    // public function update(StoreCategoryRequest $request, int $id)
    // {
    // 	$category = Category::findOrFail($id);
    //     $category->title = $request->title;
    //     $category->titleSEO = $request->titleSEO;
    //     $category->descriptionSEO = $request->descriptionSEO;
    //     $category->keywordsSEO = $request->keywordsSEO;
    //     $category->save();
    //     $last_insereted_id = $category->id;
    //     if ($request->photo != null) {
    //         if($category->photo) {
    //             Storage::disk('uploaded_img')->delete($category->photo);
    //         }
    //         $category->photo = $request->photo->store('img/categories/'.$last_insereted_id, ['disk' => 'uploaded_img']);
    //     }
        
    //     $category->save();
    //     return response()->json(['newPhoto' => $category->photo], 200);
    // }

    // public function destroy(int $id)
    // {
    // 	$category = Category::findOrFail($id);
    //     Storage::disk('uploaded_img')->deleteDirectory('img/categories/' . $id);
    //     $category->delete();
    //     return response()->json(null, 200);
    // }
}
