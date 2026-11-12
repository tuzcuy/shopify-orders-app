<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;

// Fetch orders from the Shopify Admin API and persist them
Route::get('/fetch-orders', [ShopifyController::class, 'fetchAndSaveOrders']);

// Render the Vue orders page
Route::get('/orders', function () {
    return view('orders.orders');
});

// Orders list as JSON for the Vue component
Route::get('/orders-list', [ShopifyController::class, 'getOrdersList']);

// Default landing page
Route::get('/', function () {
    return view('welcome');
});
