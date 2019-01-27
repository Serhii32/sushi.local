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
        // $this->authorize('manage', \App\ProductsCategory::class);
        // $parentCategories = ProductsCategory::where('parent_id', '=', 0)->get();
        // $allCategories = ProductsCategory::pluck('title','id')->all();
        // $pageTitle = 'Категорії товарів';
        $categories = Category::all();
        return view('admin.categories.index', compact(['categories']));
    }
}
