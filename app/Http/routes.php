<?php

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::group(['prefix' => 'api/v1', 'middleware' => ['auth:api']], function()
{
    // Products
    Route::get('products', 'ProductsController@index');
    Route::get('products/{id}', 'ProductsController@find');
    Route::post('products', 'ProductsController@store');
    Route::delete('products/{id}', 'ProductsController@delete');

    // Stocks
    Route::post('products/{id}/refill/{quantity}', 'StocksController@refill');
    Route::post('products/{id}/remove/{quantity}', 'StocksController@remove');

    // Categories
    Route::get('categories', 'CategoriesController@index');
    Route::get('categories/{id}', 'CategoriesController@find');
    Route::post('categories', 'CategoriesController@store');
    Route::delete('categories/{id}', 'CategoriesController@delete');

    // CategoryProducts
    Route::get('categories/{idCategory}/products', 'CategoriesController@products');
    Route::post('categories/{idCategory}/products', 'ProductsController@setCategory');
});

$this->get('login', 'Auth\AuthController@showLoginForm');
$this->post('login', 'Auth\AuthController@login');
$this->get('logout', 'Auth\AuthController@logout');

//Route::auth();

//Route::get('/home', 'HomeController@index');
