<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'CatalogController@main');
Route::get('/checkout', "BasketController@checkout");
Route::get('/history', "CatalogController@history");

Route::prefix('api')->group(function () {
    Route::get('/products', "CatalogController@index");
    Route::get('/basket', "BasketController@index");
    Route::post('/basket/checkout', "BasketController@checkoutSubmit");
    Route::put('/basket/{id}', "BasketController@update");
    Route::delete('/basket/{id}', "BasketController@destroy");
    Route::get('/history', "CatalogController@historyData");
});

Auth::routes();

Route::fallback(function(){
    return view('404', ['title' => 'Main page']);
});