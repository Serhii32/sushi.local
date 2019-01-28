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
        $categories = Category::paginate(12)->toJson();
        return view('admin.categories.index', compact(['categories']));
    }
}
