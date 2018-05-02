<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
    // 短信验证码
    $api->post('orderCreate', 'OrdersController@create')->name('api.order.create');
    $api->post('orderCancel', 'OrdersController@cancel')->name('api.order.cancel');
});