<?php

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/docs', function() {
    return response()->file('../docs/smapp.html');
});

Route::group(['prefix' => 'api/v1', 'middleware' => ['auth:api', 'cors']], function()
{
    // Products
    Route::get('products', 'ProductsController@index');
    Route::get('products/{id}', 'ProductsController@find');
    Route::post('products', 'ProductsController@store');
    Route::delete('products/{id}', 'ProductsController@delete');
    Route::get('products/{id}/purchaselines', 'ProductsController@purchaseLines');

    // Stocks
    Route::get('stocks', 'StocksController@index');
    Route::get('products/{id}/stock', 'ProductsController@getStock');
    Route::get('products/{id}/stocks', 'ProductsController@getStocks');
    Route::post('products/{id}/refill/{quantity}/{stockId?}', 'StocksController@refill');
    Route::post('products/{id}/remove/{quantity}/{stockId?}', 'StocksController@remove');

    // Categories
    Route::get('categories', 'CategoriesController@index');
    Route::get('categories/{id}', 'CategoriesController@find');
    Route::post('categories', 'CategoriesController@store');
    Route::delete('categories/{id}', 'CategoriesController@delete');

    // CategoryProducts
    Route::get('categories/{idCategory}/products', 'CategoriesController@products');
    Route::post('categories/{idCategory}/products', 'ProductsController@setCategory');

    // Tags
    Route::post('products/{idProduct}/tag', 'ProductsController@tag');
    Route::post('products/{idProduct}/untag', 'ProductsController@untag');
    Route::get('products/{idProduct}/tags', 'ProductsController@tags');
    Route::get('tags/{idTag}/products', 'TagsController@products');

    //Providers
    Route::get('providers', 'ProvidersController@index');
    Route::get('providers/{id}', 'ProvidersController@find');
    Route::post('providers', 'ProvidersController@store');
    Route::delete('providers/{id}', 'ProvidersController@delete');
    Route::get('providers/{id}/lines', 'ProvidersController@lines');

    //Customers
    Route::get('customers', 'CustomersController@index');
    Route::get('customers/{id}', 'CustomersController@find');
    Route::post('customers', 'CustomersController@store');
    Route::delete('customers/{id}', 'CustomersController@delete');
    Route::get('customers/{id}/orders', 'CustomersController@orders');

    //PurchaseOrders
    Route::get('purchaseorders', 'PurchaseOrdersController@index');
    Route::get('purchaseorders/{id}', 'PurchaseOrdersController@find');
    Route::post('purchaseorders', 'PurchaseOrdersController@store');
    Route::delete('purchaseorders/{id}', 'PurchaseOrdersController@delete');
    Route::post('purchaseorders/{id}/open', 'PurchaseOrdersController@open');
    Route::post('purchaseorders/{id}/close', 'PurchaseOrdersController@close');
    Route::get('purchaseorders/{id}/lines', 'PurchaseOrdersController@lines');

    //PurchaseLines
    Route::get('purchaselines/{id}', 'PurchaseLinesController@find');
    Route::post('purchaselines', 'PurchaseLinesController@store');
    Route::delete('purchaselines/{id}', 'PurchaseLinesController@delete');
    Route::post('purchaselines/{lineId}/assign/{orderId}', 'PurchaseLinesController@assign');
    Route::post('purchaselines/{id}/acknowledge', 'PurchaseLinesController@acknowledge');

    //SaleOrders
    Route::get('saleorders', 'SaleOrdersController@index');

    //SaleLines

    //Triggers

});

$this->get('login', 'Auth\AuthController@showLoginForm');
$this->post('login', 'Auth\AuthController@login');
$this->get('logout', 'Auth\AuthController@logout');

//Route::auth();

//Route::get('/home', 'HomeController@index');
