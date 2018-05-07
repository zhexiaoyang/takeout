<?php

namespace App\Http\Controllers\Api;

use App\Jobs\CreateMtOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * 推送订单URL
     * @return mixed
     */
    public function create()
    {
        $result = ['data' => 'ok'];
        if (!empty($_POST))
        {
            $this->log->api = 'api/orderCreate';
            $this->log->response = json_encode($result, JSON_UNESCAPED_UNICODE);
            $this->log->save();
            dispatch(new CreateMtOrder($this->log));
        }
        return $this->response->array($result);
    }

    /**
     * 美团用户或客服取消URL
     * @return mixed
     */
    public function cancel(Request $request)
    {
        $order_id = $request->get('order_id');
        if ($order_id)
        {
            $order = Order::where('order_id', $order_id)->first();
            if ($order)
            {
                $order->status = 6;
                $order->save();
            }
        }
        return $this->response->array(['data' => 'ok']);
    }

    /**
     * 美团用户或客服退款流程操作URL
     * @return mixed
     */
    public function refund()
    {
        return $this->response->array(['data' => 'ok']);
    }

    /**
     * 订单配送状态回调URL
     * @return mixed
     */
    public function status()
    {
        return $this->response->array(['data' => 'ok']);
    }

    /**
     * 已确认订单推送回调URL
     * @return mixed
     */
    public function confirm()
    {
        return $this->response->array(['data' => 'ok']);
    }

    /**
     * 已完成订单推送回调URL
     * @return mixed
     */
    public function complete()
    {
        return $this->response->array(['data' => 'ok']);
    }

    /**
     * 美团用户或客服部分退款流程操作URL
     * @return mixed
     */
    public function rebates()
    {
        return $this->response->array(['data' => 'ok']);
    }

    /**
     * 订单结算信息回调URL
     * @return mixed
     */
    public function close()
    {
        return $this->response->array(['data' => 'ok']);
    }

    /**
     * 隐私号降级推送URL
     * @return mixed
     */
    public function privacy()
    {
        return $this->response->array(['data' => 'ok']);
    }

    /**
     * 催单推送URL
     * @return mixed
     */
    public function reminder()
    {
        return $this->response->array(['data' => 'ok']);
    }

}
