<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Страница администратора';
        return view('admin.index', compact(['pageTitle']));
    }

    public function edit()
    {
        $admin = Auth::user();
        $pageTitle = 'Настройки профиля';
        return view('admin.edit', compact(['admin', 'pageTitle']));
    }

    public function update(StoreAdminRequest $request)
    {
    	// $response = dd($request->all());
    	// return response()->json($response);
        $admin =  Auth::user();
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->gender = $request->gender;
        if ($admin->email != $request->email) {
            $admin->email_verified_at = null;
        }
        $admin->email = $request->email;
        if($request->password) {
            $admin->password = Hash::make($request->password);
        }
        if ($request->avatar != null) {
            if($admin->avatar) {
                Storage::disk('uploaded_img')->delete($admin->avatar);
            }
            $admin->avatar = $request->avatar->store('img/common/avatars/admin', ['disk' => 'uploaded_img']);
        } else {
        	if($admin->avatar) {
                Storage::disk('uploaded_img')->delete($admin->avatar);
            }
            $admin->avatar = null;
        }
        $admin->save();
        return response()->json(null, 200);
    }

}