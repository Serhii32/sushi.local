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
	Route::get('categories/{category}/edit', ['as' => 'categories.edit', 'uses' => 'CategoryController@edit']);
	Route::post('categories/{category}', ['as' => 'categories.update', 'uses' => 'CategoryController@update']);
	Route::delete('categories/{category}', ['as' => 'categories.destroy', 'uses' => 'CategoryController@destroy']);
	Route::get('categories/getCategories', ['as' => 'categories.getCategories', 'uses' => 'CategoryController@getCategories']);

	Route::get('components', ['as' => 'components.index', 'uses' => 'ComponentController@index']);
	Route::post('components', ['as' => 'components.store', 'uses' => 'ComponentController@store']);
	Route::get('components/{component}/edit', ['as' => 'components.edit', 'uses' => 'ComponentController@edit']);
	Route::post('components/{component}', ['as' => 'components.update', 'uses' => 'ComponentController@update']);
	Route::delete('components/{component}', ['as' => 'components.destroy', 'uses' => 'ComponentController@destroy']);
	Route::get('components/getComponents', ['as' => 'components.getComponents', 'uses' => 'ComponentController@getComponents']);

	Route::get('attributes', ['as' => 'attributes.index', 'uses' => 'AttributeController@index']);
	Route::post('attributes', ['as' => 'attributes.store', 'uses' => 'AttributeController@store']);
	Route::get('attributes/{attribute}/edit', ['as' => 'attributes.edit', 'uses' => 'AttributeController@edit']);
	Route::post('attributes/{attribute}', ['as' => 'attributes.update', 'uses' => 'AttributeController@update']);
	Route::delete('attributes/{attribute}', ['as' => 'attributes.destroy', 'uses' => 'AttributeController@destroy']);
	Route::get('attributes/getAttributes', ['as' => 'attributes.getAttributes', 'uses' => 'AttributeController@getAttributes']);

	Route::get('products', ['as' => 'products.index', 'uses' => 'ProductController@index']);
	Route::post('products', ['as' => 'products.store', 'uses' => 'ProductController@store']);
	Route::get('products/{product}/edit', ['as' => 'products.edit', 'uses' => 'ProductController@edit']);
	Route::post('products/{product}', ['as' => 'products.update', 'uses' => 'ProductController@update']);
	Route::delete('products/{product}', ['as' => 'products.destroy', 'uses' => 'ProductController@destroy']);
	Route::get('products/getProducts', ['as' => 'products.getProducts', 'uses' => 'ProductController@getProducts']);

});

// Route::group(['namespace' => 'User', 'middleware' => ['auth', 'isUser'], 'as' => 'user.', 'prefix'=>'user'], function () {
// 	Route::get('home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
// 	Route::get('home/edit', ['as' => 'home.edit', 'uses' => 'HomeController@edit']);
// 	Route::match(['put', 'patch'], 'home/store', ['as' => 'home.update', 'uses' => 'HomeController@update']);
// 	Route::delete('home/destroy', ['as' => 'home.destroy', 'uses' => 'HomeController@destroy']);
// });



//Check that manage order can only user that create order by id with policies
//check method put in vue formdata
//add attributes type tabs and checkboxes not subcategories
//add products in categories in admin panel
//finish products