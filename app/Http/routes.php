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
    Route::get('products/{id}/salelines', 'ProductsController@saleLines');
    Route::get('products/{id}/offers', 'ProductsController@offers');

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

    // Providers
    Route::get('providers', 'ProvidersController@index');
    Route::get('providers/{id}', 'ProvidersController@find');
    Route::post('providers', 'ProvidersController@store');
    Route::delete('providers/{id}', 'ProvidersController@delete');
    Route::get('providers/{id}/lines', 'ProvidersController@lines');
    Route::get('providers/{id}/offers', 'ProvidersController@offers');

    // Customers
    Route::get('customers', 'CustomersController@index');
    Route::get('customers/{id}', 'CustomersController@find');
    Route::post('customers', 'CustomersController@store');
    Route::delete('customers/{id}', 'CustomersController@delete');
    Route::get('customers/{id}/orders', 'CustomersController@orders');

    // PurchaseOrders
    Route::get('purchaseorders', 'PurchaseOrdersController@index');
    Route::get('purchaseorders/{id}', 'PurchaseOrdersController@find');
    Route::post('purchaseorders', 'PurchaseOrdersController@store');
    Route::delete('purchaseorders/{id}', 'PurchaseOrdersController@delete');
    Route::post('purchaseorders/{id}/open', 'PurchaseOrdersController@open');
    Route::post('purchaseorders/{id}/close', 'PurchaseOrdersController@close');
    Route::get('purchaseorders/{id}/lines', 'PurchaseOrdersController@lines');

    // PurchaseLines
    Route::get('purchaselines/{id}', 'PurchaseLinesController@find');
    Route::post('purchaselines', 'PurchaseLinesController@store');
    Route::delete('purchaselines/{id}', 'PurchaseLinesController@delete');
    Route::post('purchaselines/{lineId}/assign/{orderId}', 'PurchaseLinesController@assign');
    Route::post('purchaselines/{id}/acknowledge', 'PurchaseLinesController@acknowledge');

    // SaleOrders
    Route::get('saleorders', 'SaleOrdersController@index');
    Route::get('saleorders/{id}', 'SaleOrdersController@find');
    Route::post('saleorders', 'SaleOrdersController@store');
    Route::delete('saleorders/{id}', 'SaleOrdersController@delete');
    Route::post('saleorders/{id}/open', 'SaleOrdersController@open');
    Route::post('saleorders/{id}/close', 'SaleOrdersController@close');
    Route::get('saleorders/{id}/lines', 'SaleOrdersController@lines');

    // SaleLines
    Route::get('salelines/{id}', 'SaleLinesController@find');
    Route::post('salelines', 'SaleLinesController@store');
    Route::delete('salelines/{id}', 'SaleLinesController@delete');
    Route::post('salelines/{lineId}/assign/{orderId}', 'SaleLinesController@assign');
    Route::post('salelines/{id}/acknowledge', 'SaleLinesController@acknowledge');

    // ProductOffers
    Route::get('productoffers', 'ProductOffersController@index');
    Route::post('productoffers', 'ProductOffersController@store');
    Route::get('productoffers/{id}', 'ProductOffersController@find');
    Route::delete('productoffers/{id}', 'ProductOffersController@delete');

    // Triggers

});

$this->get('login', 'Auth\AuthController@showLoginForm');
$this->post('login', 'Auth\AuthController@login');
$this->get('logout', 'Auth\AuthController@logout');

//Route::auth();

//Route::get('/home', 'HomeController@index');
