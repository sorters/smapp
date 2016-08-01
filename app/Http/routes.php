<?php

Route::get('/', function () {
    return view('welcome');
});

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
});

//Route::auth();

//Route::get('/home', 'HomeController@index');
