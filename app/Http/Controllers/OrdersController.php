<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use MeiTuanOpenApi\Api\OrderService;
use MeiTuanOpenApi\Config\Config;
use Auth;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function monitor(Request $request)
    {
        $status = $request->status;
        $keyword = $request->keyword;
        $orders = Order::allowShops()->with('shop')->select('id','order_id','shop_id','created_at', 'delivery_time', 'recipient_address','recipient_phone','recipient_name','caution','total', 'status', 'apply_cancel', 'apply_refund', 'refund_money', 'shipper_phone');
        if ($keyword)
        {
            $orders = $orders->where('order_id','like',"%{$keyword}%")->orWhere('recipient_name', 'like', "%{$keyword}%")->orWhere('recipient_phone', 'like', "%{$keyword}%");
        }
        if ($status)
        {
            if ($status == 3)
            {
                $orders->where(['is_print'=>0]);
            }else{
                $orders->where(['status'=>$status]);
            }
        }
        $orders = $orders->where('status', '<', 20)->orderBy('id', 'desc')->paginate(50);
        return view('orders.monitor', compact('orders','keyword', 'status'));
    }

    public function index(Request $request)
    {
        $status = $request->status;
        $keyword = $request->keyword;
        $stime = $request->stime;
        $etime = $request->etime;
        $shop_id = isset($request->shop_id)?$request->shop_id:0;
        $orders = Order::allowShops()->select('id','order_id','shop_id','created_at', 'delivery_time', 'recipient_address','recipient_phone','recipient_name','total', 'status', 'refund_money', 'package_bag_money');
        if ($keyword)
        {
            $orders = $orders->where('order_id','like',"%{$keyword}%")->orWhere('recipient_name', 'like', "%{$keyword}%")->orWhere('recipient_phone', 'like', "%{$keyword}%");
        }
        if ($status)
        {
            if ($status == 3)
            {
                $orders->where(['is_print'=>0]);
            }else{
                $orders->where(['status'=>$status]);
            }
        }
        if ($shop_id)
        {
            $orders = $orders-> where('shop_id', '=', "{$shop_id}");
        }
        if ($stime)
        {
            $orders = $orders-> where('created_at', '>=', "{$stime}");
        }
        if ($etime)
        {
            $end_time = date("Y-m-d H:i:s", strtotime($etime.' +1 day'));
            $orders = $orders->where('created_at', '<', "{$end_time}");
        }
        $orders = $orders->orderBy('id', 'desc')->paginate(20);
        $shops = Shop::allowShops()->select('id', 'name', 'meituan_id')->get();
        return view('orders.index', compact('orders','keyword', 'status', 'stime', 'etime', 'shops', 'shop_id'));
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        // $server->cancel($order->order_id);
        $res = $server->cancel($order->order_id);
        if ( $res === true )
        {
            $order->status = 25;
            $order->save();
            return redirect()->back()->with('alert', '取消成功！');
        }else{
            return back()->withErrors($res);
        }
    }

    public function reject(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $server->reject($order->order_id);
        if ( $res === true )
        {
            $order->status = 25;
            $order->save();
            return redirect()->back()->with('alert', '拒绝退款成功！');
        }else{
            $error = isset($res['error']['msg'])?$res['error']['msg']:'操作失败';
            return back()->withErrors($error);
        }
    }

    public function agree(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $server->agree($order->order_id);
        if ( $res === true )
        {
            $order->status = 25;
            $order->save();
            return redirect()->back()->with('alert', '同意退款成功！');
        }else{
            $error = isset($res['error']['msg'])?$res['error']['msg']:'操作失败';
            return back()->withErrors($error);
        }
    }

    public function arrived(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        // $server->cancel($order->order_id);
        $res = $server->viewstatus($order->order_id);
        if (!$res)
        {
            $order->status = 25;
            $order->save();
            return back()->withErrors('订单已取消');
        }

        $res = $server->arrived($order->order_id);

        if ( $res === true )
        {
            $order->status = 33;
            $order->save();
            return redirect()->back()->with('alert', '操作成功！');
        }else{
            return back()->withErrors($res);
        }
    }

    public function viewstatus(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        // $server->cancel($order->order_id);
        $res = $server->viewstatus($order->order_id);
        if ( $res === true )
        {
            $order->status = 33;
            $order->save();
            return redirect()->back()->with('alert', '操作成功！');
        }else{
            return back()->withErrors($res);
        }
    }

    public function confirm(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $server->confirm($order->order_id);
        if ( $res === true )
        {
            $order->status = 2;
            $order->save();
            return redirect()->back()->with('alert', '确认成功！');
        }else{
            return back()->withErrors($res);
        }
    }

    public function delivering(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $server->delivering($order->order_id);
        if ( $res === true )
        {
            $order->status = 8;
            $order->save();
            return redirect()->back()->with('alert', '配送成功！');
        }else{
            return back()->withErrors($res);
        }
    }

    public function printOrder(Order $order)
    {
        return view('orders.print', compact('order'));
    }

    public function printAdd(Order $order)
    {
        $log = new OrderLog;
        $log->order_id = $order->order_id;
        $log->message = '打印订单成功';
        $log->operator = Auth()->user()->name;
        $log->save();
        $order->increment('is_print');
    }
}
