<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;

// Shopify siparişlerini API'den çekip kaydeden rota
Route::get('/fetch-orders', [ShopifyController::class, 'fetchAndSaveOrders']);

// Vue.js bileşenini render eden rota
Route::get('/orders', function () {
    return view('orders.orders'); // Doğru view dosyasını döndürdüğünüzden emin olun
});

// Sipariş listesini JSON olarak döndüren API endpoint
Route::get('/orders-list', [ShopifyController::class, 'getOrdersList']);

// Varsayılan ana sayfa
Route::get('/', function () {
    return view('welcome');
});
