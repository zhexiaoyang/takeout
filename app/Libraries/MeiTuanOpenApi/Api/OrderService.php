<?php

namespace MeiTuanOpenApi\Api;


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
            return true;
        }
        return false;
    }

    public function cancel($order_id)
    {
        $params = [
            "order_id" => $order_id,
            'reason' => '客服取消',
            'reason_code' => 1204,
        ];
        $result = $this->client->call("/order/cancel", $params, 'GET');
        if ($result && $result['data'] == 'ok')
        {
            return true;
        }
        return false;
    }

    public function delivering($order_id)
    {
        $params = [
            "order_id" => $order_id,
        ];
        $result = json_decode($this->client->call("/order/confirm", $params, 'GET'), true);
        if ($result && $result['data'] == 'ok')
        {
            return true;
        }
        return false;
    }

}