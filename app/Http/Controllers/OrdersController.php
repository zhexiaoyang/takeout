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
        $orders = Order::select('id','order_id','shop_id','created_at','recipient_address','recipient_phone','recipient_name','total');
        if ($keyword)
        {
            $orders = $orders->where('name','like',"%{$keyword}%")->orWhere('phone', 'like', "%{$keyword}%");
        }
        $orders = $orders->paginate(10);
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
    }

    public function confirm(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $server->confirm($order->order_id);
    }

    public function delivering(Order $order)
    {
        $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $server->delivering($order->order_id);
    }
}