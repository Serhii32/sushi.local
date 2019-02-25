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
        if($request->category = "0"){
            $product->category = null;
        } else {
            $product->category = $request->category;
        }
        $product->titleSEO = $request->titleSEO;
        $product->descriptionSEO = $request->descriptionSEO;
        $product->keywordsSEO = $request->keywordsSEO;
        $product->save();
        $last_insereted_id = $product->id;

        if ($request->photo != null) {
            $product->photo = $request->photo->store('img/products/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        if ($request->input('components')!=null && is_string($request->input('components'))) {
            $components = array_unique(explode(",", $request->input('components')));
            if(!in_array("0", $components)){
                foreach ($components as $component) {
                    $product->components()->attach($component);
                }
            }
        }
        if ($request->input('attributes')!=null && is_string($request->input('attributes'))) {
            $attributes = array_unique(explode(",", $request->input('attributes')));
            if(!in_array("0", $attributes)){
                foreach ($attributes as $attribute) {
                    $product->attributes()->attach($attribute);
                }
            }
        }
        $product->save();
        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $product = Product::findOrFail($id);
        // $pageTitle = 'Редактировать ' . $category->title;
        return view('admin.products.edit', compact('product'));
    }

    public function getProductDependencies(int $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::pluck('title','id')->all();
        $components = Component::pluck('title','id')->all();
        $attributes = Attribute::pluck('title','id')->all();

        $productComponents = $product->components()->get();
        $productAttributes = $product->attributes()->get();

        return response()->json(['categories' => $categories, 'components' => $components, 'attributes' => $attributes, 'productComponents' => $productComponents, 'productAttributes' => $productAttributes]);
    }

    public function update(StoreProductRequest $request, int $id)
    {
        $product = Product::findOrFail($id);
        $product->title = $request->title;
        $product->price = $request->price;
        $product->weight = $request->weight;
        if($request->category == "0"){
            $product->category = null;
        } else {
            $product->category = $request->category;
        }
        $product->titleSEO = $request->titleSEO;
        $product->descriptionSEO = $request->descriptionSEO;
        $product->keywordsSEO = $request->keywordsSEO;
        $product->save();
        $last_insereted_id = $product->id;
        if ($request->photo != null) {
            if($product->photo) {
                Storage::disk('uploaded_img')->delete($product->photo);
            }
            $product->photo = $request->photo->store('img/products/'.$last_insereted_id, ['disk' => 'uploaded_img']);
        }
        if ($request->input('components')!=null && is_string($request->input('components'))) {
            $product->components()->detach();
            $components = array_unique(explode(",", $request->input('components')));
            if(!in_array("0", $components)){
                foreach ($components as $component) {
                    $product->components()->attach($component);
                }
            }
        }
        if ($request->input('attributes')!=null && is_string($request->input('attributes'))) {
            $product->attributes()->detach();
            $attributes = array_unique(explode(",", $request->input('attributes')));
            if(!in_array("0", $attributes)){
                foreach ($attributes as $attribute) {
                    $product->attributes()->attach($attribute);
                }
            }
        }
        $product->save();
        return response()->json(['newPhoto' => $product->photo], 200);
    }

    public function destroy(int $id)
    {
    	$product = Product::findOrFail($id);
        $product->components()->detach();
        $product->attributes()->detach();
        Storage::disk('uploaded_img')->deleteDirectory('img/products/' . $id);
        $product->delete();
        return response()->json(null, 200);
    }
}
