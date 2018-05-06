<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
//    推送订单URL
    $api->get('orderCreate', 'OrdersController@create')->name('api.order.create');
//    美团用户或客服取消URL
    $api->get('orderCancel/{order_id}', 'OrdersController@cancel')->name('api.order.cancel');
//    美团用户或客服退款流程操作URL
    $api->get('orderRefund', 'OrdersController@refund')->name('api.order.refund');
//    订单配送状态回调URL
    $api->post('orderStatus', 'OrdersController@status')->name('api.order.status');
//    已确认订单推送回调URL
    $api->post('orderConfirm', 'OrdersController@confirm')->name('api.order.confirm');
//    门店状态变更回调URL
    $api->post('shopStatus', 'ShopController@status')->name('api.order.status');
//    已完成订单推送回调URL
    $api->post('orderComplete', 'OrdersController@complete')->name('api.order.complete');
//    美团用户或客服部分退款流程操作URL
    $api->get('orderRebates', 'OrdersController@rebates')->name('api.order.rebates');
//    订单结算信息回调URL
    $api->post('orderClose', 'OrdersController@close')->name('api.order.close');
//    隐私号降级推送URL
    $api->post('orderPrivacy', 'OrdersController@privacy')->name('api.order.privacy');
//    催单推送URL
    $api->post('orderReminder', 'OrdersController@reminder')->name('api.order.reminder');
});