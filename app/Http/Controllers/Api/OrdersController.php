<?php

namespace App\Http\Controllers\Api;

use App\Jobs\CreateMtOrder;
use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Http\Request;
use MeiTuanOpenApi\Api\OrderService;
use MeiTuanOpenApi\Config\Config;

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
        $result = ['data' => 'ok'];
        if (!empty($_GET))
        {
            $this->log->api = 'api/orderCancel';
            $this->log->response = json_encode($result, JSON_UNESCAPED_UNICODE);
            $this->log->save();
            $order_id = $request->get('order_id');
            if ($order_id)
            {
                $order = Order::where('order_id', $order_id)->first();
                if ($order)
                {
                    $order->status = 25;
                    $order->save();
                    $log = new OrderLog();
                    $log->order_id = $order_id;
                    $log->message = '取消订单成功';
                    $log->operator = 'mt api cancel';
                    $log->save();
                }
            }
        }
        return $this->response->array($result);
    }

    /**
     * 美团用户或客服退款流程操作URL
     * @return mixed
     */
    public function refund(Request $request)
    {
        $result = ['data' => 'ok'];
        if (!empty($_GET))
        {
            $this->log->api = 'api/order/refund';
            $this->log->response = json_encode($result, JSON_UNESCAPED_UNICODE);
            $this->log->save();
            $order_id = $request->get('order_id');
            $notify_type = $request->get('notify_type');
            $reason = $request->get('reason');
            if ($order_id)
            {
                $order = Order::where('order_id', $order_id)->first();
                if ($order && $notify_type == 'apply')
                {
                    $order->apply_refund = 1;
                    $order->refund_money = $order->total;
                    $order->refund_at = date("Y-m-d H:i:s");
                    $order->save();
                    $log = new OrderLog();
                    $log->order_id = $order_id;
                    $log->message = '客户申请退款。金额：'.$order->total.'原因：'.$reason;
                    $log->operator = 'mt api refund';
                    $log->save();
                }
                if ($order_id && $notify_type == 'cancelRefund')
                {
                    $order->apply_refund = 0;
                    $order->refund_money = 0;
                    $order->refund_at = null;
                    $order->save();
                    $log = new OrderLog();
                    $log->order_id = $order_id;
                    $log->message = '客户取消退款申请';
                    $log->operator = 'mt api refund';
                    $log->save();
                }
                if ($order_id && $notify_type == 'agree')
                {
                    $order->apply_refund = 0;
                    $order->refund_money = $order->total;
                    $order->refund_at = date("Y-m-d H:i:s");
                    $order->save();
                }
                if ($order_id && $notify_type == 'reject')
                {
                    $order->apply_refund = 0;
                    $order->refund_money = 0;
                    $order->refund_at = null;
                    $order->save();
                }
            }
        }
        return $this->response->array($result);
    }

    /**
     * 订单配送状态回调URL
     * @return mixed
     */
    public function status(Request $request)
    {
        $result = ['data' => 'ok'];
        if (!empty($_POST))
        {
            $this->log->api = 'api/orderStatus';
            $this->log->response = json_encode($result, JSON_UNESCAPED_UNICODE);
            $this->log->save();
            $order_id = $request->get('order_id');
            $status = $request->get('logistics_status');
            $dispatcher_name = urldecode($request->get('dispatcher_name'));
            $dispatcher_mobile = $request->get('dispatcher_mobile');
            if ($status && $order_id)
            {
                $order = Order::where('order_id', $order_id)->first();
                if ($order)
                {
                    if ($status == 10)
                    {
                        $order->status = 6;
                        $order->shipper_phone = $dispatcher_name . '(' .$dispatcher_mobile .')';
                        $order->save();
                        $log = new OrderLog();
                        $log->order_id = $order_id;
                        $log->message = '配送员正赶往商家';
                        $log->operator = 'mt api status';
                        $log->save();
                    }
                    if ($status == 15)
                    {
                        $order->status = 7;
                        $order->shipper_phone = $dispatcher_name . '(' .$dispatcher_mobile .')';
                        $order->save();
                        $log = new OrderLog();
                        $log->order_id = $order_id;
                        $log->message = '配送员已到店';
                        $log->operator = 'mt api status';
                        $log->save();
                    }
                    if ($status == 20)
                    {
                        $order->status = 8;
                        $order->shipper_phone = $dispatcher_name . '(' .$dispatcher_mobile .')';
                        $order->save();
                        $log = new OrderLog();
                        $log->order_id = $order_id;
                        $log->message = '订单配送中';
                        $log->operator = 'mt api status';
                        $log->save();
                    }
                    if ($status == 40)
                    {
                        $order->status = 33;
                        $order->shipper_phone = $dispatcher_name . '(' .$dispatcher_mobile .')';
                        $order->save();
                    $log = new OrderLog();
                    $log->order_id = $order_id;
                    $log->message = '订单配送完成';
                    $log->operator = 'mt api status';
                    $log->save();
                    }
                }
            }
        }
        return $this->response->array($result);
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
    public function complete(Request $request)
    {
        $result = ['data' => 'ok'];
        if (!empty($_GET))
        {
            $this->log->api = 'api/orderComplete';
            $this->log->response = json_encode($result, JSON_UNESCAPED_UNICODE);
            $this->log->save();
            $order_id = $request->get('order_id');
            if ($order_id)
            {
                $order = Order::where('order_id', $order_id)->first();
                if ($order)
                {
                    $order->status = 33;
                    $order->save();
                    $log = new OrderLog();
                    $log->order_id = $order_id;
                    $log->message = '订单完成';
                    $log->operator = 'mt api complete';
                    $log->save();
                }
            }
        }
        return $this->response->array($result);
    }

    /**
     * 美团用户或客服部分退款流程操作URL
     * @return mixed
     */
    public function rebates(Request $request)
    {
        $result = ['data' => 'ok'];
        if (!empty($_GET))
        {
            $this->log->api = 'api/order/rebates';
            $this->log->response = json_encode($result, JSON_UNESCAPED_UNICODE);
            $this->log->save();
            $order_id = $request->get('order_id');
            $notify_type = $request->get('notify_type');
            $reason = $request->get('reason');
            $money = $request->get('money', 0);
            $order = Order::where('order_id', $order_id)->first();
            if ($order_id)
            {
                if ($order && $notify_type == 'apply')
                {
                    $order->apply_refund = 1;
                    $order->refund_money = $money;
                    $order->refund_at =  date("Y-m-d H:i:s");
                    $order->save();
                    $log = new OrderLog();
                    $log->order_id = $order_id;
                    $log->message = '客户申请退款。金额：'.$money.'原因：'.$reason;
                    $log->operator = 'mt api rebates';
                    $log->save();
                }
                if ($order && $notify_type == 'cancelRefund')
                {
                    $order->apply_refund = 0;
                    $order->refund_at = null;
                    $order->save();
                    $log = new OrderLog();
                    $log->order_id = $order_id;
                    $log->message = '客户取消退款申请';
                    $log->operator = 'mt api rebates';
                    $log->save();
                }
                if ($order && $notify_type == 'agree')
                {
                    $order->apply_refund = 0;
                    $order->refund_money = $money;
                    $order->refund_at =  date("Y-m-d H:i:s");
                    $order->save();
                }
                if ($order && $notify_type == 'reject')
                {
                    $order->apply_refund = 0;
                    $order->refund_money = 0;
                    $order->refund_at = null;
                    $order->save();
                }
            }
        }
        return $this->response->array($result);
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
