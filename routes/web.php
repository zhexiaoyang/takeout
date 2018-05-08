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


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function ($router) {

//    Route::get('/', 'IndexController@index')->name('index.index');
    Route::get('/', 'OrdersController@index')->name('index.index');

    Route::resource('users', 'UsersController', ['only' => ['index','create', 'update', 'edit', 'store', 'destroy']]);
    Route::post('users/{user}', 'UsersController@reset')->name('users.reset');

});
Route::resource('deopts', 'DeoptsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('shops', 'ShopsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('categories', 'CategoriesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('goods', 'GoodsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::post('goods/file', 'GoodsController@file')->name('goods.file');
Route::get('goods/deopt/{deopt}', 'GoodsController@deopt')->name('goods.deopt');

Route::resource('orders', 'OrdersController', ['only' => ['index', 'show']]);
Route::post('orders/confirm/{order}', 'OrdersController@confirm')->name('orders.confirm');
Route::post('orders/cancel/{order}', 'OrdersController@cancel')->name('orders.cancel');
Route::post('orders/delivering/{order}', 'OrdersController@delivering')->name('orders.delivering');
Route::get('orders/print/{order}', 'OrdersController@printOrder')->name('orders.printOrder');
Route::post('orders/printAdd/{order}', 'OrdersController@printAdd')->name('orders.printAdd');
Route::resource('order_details', 'OrderDetailsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('mt_logs', 'MtLogsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);