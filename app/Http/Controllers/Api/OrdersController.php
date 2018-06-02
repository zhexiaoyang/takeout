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
            if ($order_id && $notify_type == 'apply')
            {
                $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $res = $server->reject($order_id);
                $log = new OrderLog();
                $log->order_id = $order_id;
                $log->operator = 'mt api refund';
                if ( $res === true )
                {
                    $log->message = '拒绝退款申请成功';
                }else{
                    $log->message = isset($server->mt_res['error']['msg'])?'拒绝退款申请失败('.$server->mt_res['error']['msg'].')':'拒绝退款申请失败';
                }
                $log->save();
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
            if ($status && $order_id)
            {
                $order = Order::where('order_id', $order_id)->first();
                if ($order)
                {
                    if ($status == 20)
                    {
                        $order->status = 8;
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
            if ($order_id && $notify_type == 'apply')
            {
                $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $res = $server->reject($order_id);
                $log = new OrderLog();
                $log->order_id = $order_id;
                $log->operator = 'mt api rebates';
                if ( $res === true )
                {
                    $log->message = '拒绝部分退款申请成功';
                }else{
                    $log->message = isset($server->mt_res['error']['msg'])?'拒绝部分退款申请失败('.$server->mt_res['error']['msg'].')':'拒绝部分退款申请失败';
                }
                $log->save();
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
