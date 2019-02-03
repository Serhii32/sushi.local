<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Attribute;
use App\Http\Requests\StoreAttributeRequest;

class AttributeController extends Controller
{
    public function index()
    {
        // $pageTitle = 'Категорії товарів';
        return view('admin.attributes.index');
    }

    public function getAttributes() 
    {
    	$attributes = Attribute::paginate(12);
    	return response()->json($attributes);
    }

    public function store(StoreAttributeRequest $request)
    {
    	$attribute = new Attribute();
        $attribute->title = $request->title;
        $attribute->type = $request->type;
        $attribute->save();
        return response()->json(null, 200);
    }

    public function edit(int $id)
    {
        $attribute = Attribute::findOrFail($id);
        // $pageTitle = 'Редактировать ' . $category->title;
        return view('admin.attributes.edit', compact(['attribute']));
    }

    public function update(StoreAttributeRequest $request, int $id)
    {
    	$attribute = Attribute::findOrFail($id);
        $attribute->title = $request->title;
        $attribute->type = $request->type;
        $attribute->save();
        return response()->json(null, 200);
    }

    public function destroy(int $id)
    {
    	$attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return response()->json(null, 200);
    }
}
