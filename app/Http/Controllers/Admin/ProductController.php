<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Component;
use App\Attribute;
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
    	$attributes = Attribute::pluck('title','id')->all();
    	return response()->json(['products' => $products, 'categories' => $categories, 'components' => $components, 'attributes' => $attributes]);
    }

    public function store(StoreProductRequest $request)
    {
        
    	$product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->category = $request->category;
        $product->titleSEO = $request->titleSEO;
        $product->descriptionSEO = $request->descriptionSEO;
        $product->keywordsSEO = $request->keywordsSEO;
        $product->save();
        $last_insereted_id = $product->id;
        if ($request->photo != null) {
            $product->photo = $request->photo->store('img/products/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        if ($request->components && is_string($request->components)) {
            $components = explode(",", $request->components);
            foreach ($components as $component) {
                $product->components()->attach($component);
            }
        }
        if ($request->attributes && is_string($request->attributes)) {
            $attributes = explode(",", $request->attributes);
            foreach ($attributes as $attribute) {
                $product->attributes()->attach($attribute);
            }
        }
        $product->save();
        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $product = Product::findOrFail($id);

        $productCategories = $product->category()->first() ? $product->category()->first()->toJson(): null;
        $productComponents = count($product->components()->get()) > 0 ? $product->components()->get()->toJson(): null;
        $productAttributes = count($product->attributes()->get()) > 0 ? $product->attributes()->get()->toJson(): null;

        // $pageTitle = 'Редактировать ' . $category->title;
        return view('admin.products.edit', compact('product', 'productCategories', 'productComponents', 'productAttributes'));
    }

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
