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
Route::get('menu', ['as' => 'page.menu', 'uses' => 'PagesController@menu']);
Route::get('delivery', ['as' => 'page.delivery', 'uses' => 'PagesController@delivery']);
Route::get('clients', ['as' => 'page.clients', 'uses' => 'PagesController@clients']);
Route::get('getCategories', ['as' => 'page.getCategories', 'uses' => 'PagesController@getCategories']);
Route::get('category/{id}', ['as' => 'page.category', 'uses' => 'PagesController@category']);
Route::get('product/{id}', ['as' => 'page.product', 'uses' => 'PagesController@product']);
Route::get('promotions', ['as' => 'page.promotions', 'uses' => 'PagesController@promotions']);
Route::get('promotion/{id}', ['as' => 'page.promotion', 'uses' => 'PagesController@promotion']);
Route::post('addToCart', ['as' => 'addToCart', 'uses' => 'PagesController@addToCart']);
Route::post('addToFavorites', ['as' => 'addToFavorites', 'uses' => 'PagesController@addToFavorites']);
Route::post('updateQTY', ['as' => 'updateQTY', 'uses' => 'PagesController@updateQTY']);
Route::get('getCartContent', ['as' => 'getCartContent', 'uses' => 'PagesController@getCartContent']);
Route::post('removeItemFromCart', ['as' => 'removeItemFromCart', 'uses' => 'PagesController@removeItemFromCart']);
Route::post('makeOrder', ['as' => 'makeOrder', 'uses' => 'PagesController@makeOrder']);
Route::post('thank_you', ['as' => 'page.thank_you', 'uses' => 'PagesController@thankYou']);

Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'isAdmin'], 'as' => 'admin.', 'prefix'=>'admin'], function () {
	Route::get('home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
	Route::get('home/edit', ['as' => 'home.edit', 'uses' => 'HomeController@edit']);
	Route::post('home/store', ['as' => 'home.update', 'uses' => 'HomeController@update']);

	Route::get('orders', ['as' => 'orders.index', 'uses' => 'OrderController@index']);
	Route::get('orders/getOrders', ['as' => 'orders.getOrders', 'uses' => 'OrderController@getOrders']);
	Route::post('orders/delete/{order}', ['as' => 'orders.destroy', 'uses' => 'OrderController@destroy']);

	Route::get('categories', ['as' => 'categories.index', 'uses' => 'CategoryController@index']);
	Route::post('categories', ['as' => 'categories.store', 'uses' => 'CategoryController@store']);
	Route::get('categories/{category}/edit', ['as' => 'categories.edit', 'uses' => 'CategoryController@edit']);
	Route::post('categories/{category}', ['as' => 'categories.update', 'uses' => 'CategoryController@update']);

	Route::post('categories/delete/{category}', ['as' => 'categories.destroy', 'uses' => 'CategoryController@destroy']);
	Route::get('categories/getCategories', ['as' => 'categories.getCategories', 'uses' => 'CategoryController@getCategories']);

	Route::get('discounts', ['as' => 'discounts.index', 'uses' => 'DiscountController@index']);
	Route::post('discounts', ['as' => 'discounts.store', 'uses' => 'DiscountController@store']);
	Route::get('discounts/{discount}/edit', ['as' => 'discounts.edit', 'uses' => 'DiscountController@edit']);
	Route::post('discounts/{discount}', ['as' => 'discounts.update', 'uses' => 'DiscountController@update']);

	Route::post('discounts/delete/{category}', ['as' => 'discounts.destroy', 'uses' => 'DiscountController@destroy']);
	Route::get('discounts/getDiscounts', ['as' => 'discounts.getCategories', 'uses' => 'DiscountController@getDiscounts']);

	Route::get('components', ['as' => 'components.index', 'uses' => 'ComponentController@index']);
	Route::post('components', ['as' => 'components.store', 'uses' => 'ComponentController@store']);
	Route::get('components/{component}/edit', ['as' => 'components.edit', 'uses' => 'ComponentController@edit']);
	Route::post('components/{component}', ['as' => 'components.update', 'uses' => 'ComponentController@update']);

	Route::post('components/delete/{component}', ['as' => 'components.destroy', 'uses' => 'ComponentController@destroy']);
	Route::get('components/getComponents', ['as' => 'components.getComponents', 'uses' => 'ComponentController@getComponents']);


	Route::get('attributes', ['as' => 'attributes.index', 'uses' => 'AttributeController@index']);
	Route::post('attributes', ['as' => 'attributes.store', 'uses' => 'AttributeController@store']);
	Route::get('attributes/{attribute}/edit', ['as' => 'attributes.edit', 'uses' => 'AttributeController@edit']);
	Route::post('attributes/{attribute}', ['as' => 'attributes.update', 'uses' => 'AttributeController@update']);

	Route::post('attributes/delete/{attribute}', ['as' => 'attributes.destroy', 'uses' => 'AttributeController@destroy']);
	Route::get('attributes/getAttributes', ['as' => 'attributes.getAttributes', 'uses' => 'AttributeController@getAttributes']);


	Route::get('products', ['as' => 'products.index', 'uses' => 'ProductController@index']);
	Route::post('products', ['as' => 'products.store', 'uses' => 'ProductController@store']);
	Route::get('products/{product}/edit', ['as' => 'products.edit', 'uses' => 'ProductController@edit']);
	Route::get('products/getProductDependencies/{product}', ['as' => 'products.getProductDependencies', 'uses' => 'ProductController@getProductDependencies']);
	Route::post('products/{product}', ['as' => 'products.update', 'uses' => 'ProductController@update']);

	Route::post('products/delete/{product}', ['as' => 'products.destroy', 'uses' => 'ProductController@destroy']);
	Route::get('products/getProducts', ['as' => 'products.getProducts', 'uses' => 'ProductController@getProducts']);

	Route::get('promotions', ['as' => 'promotions.index', 'uses' => 'PromotionController@index']);
	Route::post('promotions', ['as' => 'promotions.store', 'uses' => 'PromotionController@store']);
	Route::get('promotions/{promotion}/edit', ['as' => 'promotions.edit', 'uses' => 'PromotionController@edit']);
	Route::post('promotions/{promotion}', ['as' => 'promotions.update', 'uses' => 'PromotionController@update']);

	Route::post('promotions/delete/{promotion}', ['as' => 'promotions.destroy', 'uses' => 'PromotionController@destroy']);
	Route::get('promotions/getPromotions', ['as' => 'promotions.getPromotions', 'uses' => 'PromotionController@getPromotions']);
});

Route::group(['namespace' => 'User', 'middleware' => ['auth', 'isUser'], 'as' => 'user.', 'prefix'=>'user'], function () {

	Route::get('home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
	Route::post('home/store', ['as' => 'home.update', 'uses' => 'HomeController@update']);

	// Route::match(['put', 'patch'], 'home/store', ['as' => 'home.update', 'uses' => 'HomeController@update']);
	// Route::delete('home/destroy', ['as' => 'home.destroy', 'uses' => 'HomeController@destroy']);
});



//Check that manage order can only user that create order by id with policies
//add attributes checkboxes in categories
//add products in categories in admin panel
//delete menu in admin panel