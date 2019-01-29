<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', ['as' => 'page.index', 'uses' => 'PagesController@index']);

Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'isAdmin'], 'as' => 'admin.', 'prefix'=>'admin'], function () {
	Route::get('home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
	Route::get('home/edit', ['as' => 'home.edit', 'uses' => 'HomeController@edit']);
	// Route::match(['put', 'patch'], 'home/store', ['as' => 'home.update', 'uses' => 'HomeController@update']);
	Route::post('home/store', ['as' => 'home.update', 'uses' => 'HomeController@update']);

	Route::get('categories', ['as' => 'categories.index', 'uses' => 'CategoryController@index']);
	Route::post('categories', ['as' => 'categories.store', 'uses' => 'CategoryController@store']);

	Route::get('categories/getCategories', ['as' => 'categories.getCategories', 'uses' => 'CategoryController@getCategories']);


	Route::resource('products', 'ProductController')->except(['show']);
});

// Route::group(['namespace' => 'User', 'middleware' => ['auth', 'isUser'], 'as' => 'user.', 'prefix'=>'user'], function () {
// 	Route::get('home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
// 	Route::get('home/edit', ['as' => 'home.edit', 'uses' => 'HomeController@edit']);
// 	Route::match(['put', 'patch'], 'home/store', ['as' => 'home.update', 'uses' => 'HomeController@update']);
// 	Route::delete('home/destroy', ['as' => 'home.destroy', 'uses' => 'HomeController@destroy']);
// });



//Check that manage order can only user that create order by id with policies
//check method put in vue formdata


       // | DELETE    | admin/categories/{category}      | admin.categories.destroy | App\Http\Controllers\Admin\CategoryController@destroy                  | web,auth,isAdmin |
       // | PUT|PATCH | admin/categories/{category}      | admin.categories.update  | App\Http\Controllers\Admin\CategoryController@update                   | web,auth,isAdmin |