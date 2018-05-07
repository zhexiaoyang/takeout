<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use MeiTuanOpenApi\Api\OrderService;
use MeiTuanOpenApi\Config\Config;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index(Request $request)
	{
        $keyword = $request->keyword;
        $orders = Order::allowShops()->select('id','order_id','shop_id','created_at', 'delivery_time', 'recipient_address','recipient_phone','recipient_name','total', 'status');
        if ($keyword)
        {
            $orders = $orders->where('order_id','like',"%{$keyword}%")->orWhere('recipient_name', 'like', "%{$keyword}%")->orWhere('recipient_phone', 'like', "%{$keyword}%");
        }
        $orders = $orders->orderBy('id', 'desc')->paginate(20);
		return view('orders.index', compact('orders','keyword'));
	}

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $server->cancel($order->order_id);
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
        $order->increment('is_print');
    }
}