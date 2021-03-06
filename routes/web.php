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
    Route::get('/', 'OrdersController@monitor')->name('index.index');

    Route::resource('users', 'UsersController', ['only' => ['index','create', 'update', 'edit', 'store', 'destroy']]);
    Route::post('users/{user}', 'UsersController@reset')->name('users.reset');
    Route::get('resets/{user}', 'UsersController@getReset')->name('user.getReset');
    Route::post('resets', 'UsersController@postReset')->name('user.postReset');

    Route::resource('deopts', 'DeoptsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

    Route::resource('shops', 'ShopsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
//    Route::get('shops/sync', 'ShopsController@sync')->name('shops.sync');
    Route::post('shops/syncMeituan', 'ShopsController@syncMeituan')->name('shops.syncMeituan');
    Route::get('shops/goods/{shop}', 'ShopsController@goods')->name('shops.goods');
    Route::get('shops/goodsOnline/{shop}', 'ShopsController@goodsOnline')->name('shops.goodsOnline');
    Route::post('shops/open/{shop}', 'ShopsController@open')->name('shops.open');
    Route::post('shops/close/{shop}', 'ShopsController@close')->name('shops.close');
    Route::post('shops/psmt/{shop}', 'ShopsController@psmt')->name('shops.psmt');
    Route::post('shops/psyd/{shop}', 'ShopsController@psyd')->name('shops.psyd');

    Route::resource('categories', 'CategoriesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
    Route::resource('goods', 'GoodsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
    Route::post('goods/file', 'GoodsController@file')->name('goods.file');
    Route::get('goods/deopt/{deopt}', 'GoodsController@deopt')->name('goods.deopt');

    Route::resource('orders', 'OrdersController', ['only' => ['index', 'show']]);
    Route::post('orders/confirm/{order}', 'OrdersController@confirm')->name('orders.confirm');
    Route::post('orders/cancel/{order}', 'OrdersController@cancel')->name('orders.cancel');
    Route::post('orders/agree/{order}', 'OrdersController@agree')->name('orders.agree');
    Route::post('orders/reject/{order}', 'OrdersController@reject')->name('orders.reject');
    Route::post('orders/arrived/{order}', 'OrdersController@arrived')->name('orders.arrived');
    Route::post('orders/delivering/{order}', 'OrdersController@delivering')->name('orders.delivering');
    Route::get('orders/print/{order}', 'OrdersController@printOrder')->name('orders.printOrder');
    Route::post('orders/printAdd/{order}', 'OrdersController@printAdd')->name('orders.printAdd');
    Route::resource('order_details', 'OrderDetailsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
    Route::resource('mt_logs', 'MtLogsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
    Route::get('download/excel', function() {
        return response()->download(storage_path('app/template.xls'), '上传商品模板.xls');
    })->name('download.excel');
    Route::get('download/detail', function() {
        return response()->download(storage_path('app/template2.xlsx'), '打款详情模板.xlsx');
    })->name('download.detail');

    Route::get('finance/hit', 'FinanceController@hit')->name('finance.hit');
    Route::get('finance/hitexport', 'FinanceController@hitExport')->name('finance.hitexport');
    Route::get('finance/sales', 'FinanceController@sales')->name('finance.sales');

    Route::post('bill/reset/{remits}', 'BillController@reset')->name('bill.reset');
    Route::post('bill/resetAll', 'BillController@resetAll')->name('bill.resetAll');
    Route::post('bill/status/{remits}', 'BillController@status')->name('bill.status');
    Route::post('bill/updates', 'BillController@updates')->name('bill.updates');

    Route::resource('shop_details', 'ShopDetailsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
    Route::get('ShopDetail/show/{shop_id}', 'ShopDetailsController@show')->name('shop_details.show');
    Route::get('ShopDetail/create/{shop_id}', 'ShopDetailsController@create')->name('shop_details.create');
    Route::get('ShopDetail/info/{shop_id?}', 'ShopDetailsController@info')->name('shop_details.info');
    Route::get('ShopDetail/createMany/{shop_ids?}', 'ShopDetailsController@createMany')->name('shop_details.create_many');
    Route::post('ShopDetail/storeMany', 'ShopDetailsController@saveMany')->name('shop_details.save_many');

    Route::post('shops/file', 'ShopsController@file')->name('shops.file');

});
