<?php

namespace MeiTuanOpenApi\Api;


use App\Models\OrderLog;
use Auth;

class OrderService extends RpcService
{

    public function confirm($order_id)
    {
        $params = [
            "order_id" => $order_id,
        ];
        $result = json_decode($this->client->call("/order/confirm", $params, 'GET'), true);
        if ($result && $result['data'] == 'ok')
        {
//            $log = new OrderLog();
//            $log->order_id = $order_id;
//            $log->message = '确认订单成功';
//            $log->operator = 'system';
//            $log->save();
            return true;
        }
        return isset($result['error']['msg'])?trim($result['error']['msg']):'请求确认接口错误';
    }

    public function cancel($order_id)
    {
        $params = [
            "order_id" => $order_id,
            'reason' => '客服取消',
            'reason_code' => 1204,
        ];
        $result = json_decode($this->client->call("/order/cancel", $params, 'GET'), true);
        if ($result && $result['data'] == 'ok')
        {
            $log = new OrderLog();
            $log->order_id = $order_id;
            $log->message = '取消订单成功';
            $log->operator = Auth()->user()->name;
            $log->save();
            return true;
        }
        return isset($result['error']['msg'])?$result['error']['msg']:'请求取消接口错误';
    }

    public function delivering($order_id)
    {
        $params = [
            "order_id" => $order_id,
        ];
        $result = json_decode($this->client->call("/order/delivering", $params, 'GET'), true);
        if ($result && $result['data'] == 'ok')
        {
//            $log = new OrderLog();
//            $log->order_id = $order_id;
//            $log->message = '配送订单成功';
//            $log->operator = 'system';
//            $log->save();
            return true;
        }
        return isset($result['error']['msg'])?$result['error']['msg']:'请求配送接口错误';
    }

}
