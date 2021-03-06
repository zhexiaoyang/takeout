<?php

namespace MeiTuanOpenApi\Api;


use App\Models\OrderLog;
use Auth;

class OrderService extends RpcService
{
    public $mt_res;

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

    public function arrived($order_id)
    {
        $params = [
            "order_id" => $order_id,
        ];
        $result = json_decode($this->client->call("/order/arrived", $params, 'GET'), true);
        if ($result && $result['data'] == 'ok')
        {
            $log = new OrderLog();
            $log->order_id = $order_id;
            $log->message = '订单配送完成';
            $log->operator = Auth()->user()->name;
            $log->save();
            return true;
        }
        return isset($result['error']['msg'])?$result['error']['msg']:'请求取消接口错误';
    }

    public function viewstatus($order_id)
    {
        $params = [
            "order_id" => $order_id,
        ];
        $result = json_decode($this->client->call("/order/viewstatus", $params, 'GET'), true);
        if (isset($result['data']['status']))
        {
            $log = new OrderLog();
            $log->order_id = $order_id;
            if ( isset($result['data']['status']) && $result['data']['status'] != 9 )
            {
                $log->message = '获取订单状态（'.isset($result['data']['status'])?$result['data']['status']:0;
                $log->operator = Auth()->user()->name;
                $log->save();
                return true;
            }else{
                $log->message = '订单已取消';
                $log->operator = Auth()->user()->name;
                $log->save();
                return false;
            }
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

    public function reject($order_id)
    {
        $params = [
            "order_id" => $order_id,
            'reason' => '请先联系商家，谢谢！',
        ];
        $result = json_decode($this->client->call("/order/refund/reject", $params, 'GET'), true);
        $this->mt_res = $result;
        if ($result && $result['data'] == 'ok')
        {
            $log = new OrderLog();
            $log->order_id = $order_id;
            $log->message = '拒绝退款申请';
            $log->operator = "system";
            $log->save();
            return true;
        }
        return $result;
    }

    public function agree($order_id)
    {
        $params = [
            "order_id" => $order_id,
            'reason' => '同意退款！',
        ];
        $result = json_decode($this->client->call("/order/refund/agree", $params, 'GET'), true);
        $this->mt_res = $result;
        if ($result && $result['data'] == 'ok')
        {
            $log = new OrderLog();
            $log->order_id = $order_id;
            $log->message = '同意申请退款';
            $log->operator = Auth()->user()->name;;
            $log->save();
            return true;
        }
        return false;
    }

}
