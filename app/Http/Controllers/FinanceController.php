<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Remits;
use App\Models\Shop;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function hit(Request $request)
    {
        $keyword = $request->keyword;
        $shop_id = $request->shop_id;
        $status = isset($request->status)?$request->status:'0';
        $stime = $request->stime;
        $etime = $request->etime;
        $shops = Shop::allowShops()->select('id', 'name', 'meituan_id')->get();
        $list = Remits::select('id','remit_id','shop_name','shop_id','coefficient','start_time','end_time','sale_amount','earnings','return','status');
        $shop_ids = array_pluck($shops->toArray(),'id');

        if ($shop_id)
        {
            $list = $list->where('shop_id', $shop_id);
        }
        if ($status != (-1))
        {
            $list = $list->where('status', $status);
        }
        if ($keyword)
        {
            $list = $list->where('remit_id', $keyword);
        }
        if ($stime)
        {
            $list = $list->where(function ($query) use ($stime) {
                $query->where('start_time', '>=', "{$stime}")->orWhere('end_time', '>=', "{$stime}");
            });
        }
        if ($etime)
        {
            $list = $list->where(function ($query) use ($etime) {
                $query->where('start_time', '<=', "{$etime}")->orWhere('end_time', '<=', "{$etime}");
            });
        }
        $list = $list->whereIn('shop_id', $shop_ids)->orderBy('id', 'desc')->paginate(15);

        return view('finance.hit', compact('keyword','status','shop_id','etime','stime','shops','list'));
    }

    public function sales(Request $request)
    {
        $keyword = $request->keyword;
        $shop_id = $request->shop_id;
        $shops = Shop::allowShops()->select('id', 'name', 'meituan_id')->get();
        if ($shop_id)
        {
            $list = OrderDetail::allowShops()->where('shop_id', $shop_id)->paginate(15);
        }else{
            $list = OrderDetail::allowShops()->paginate(15);
        }
        return view('finance.sales', compact('keyword','shop_id','shops','list'));
    }
}
