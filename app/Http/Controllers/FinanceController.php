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
        $shops = Shop::allowShops()->select('id', 'name', 'meituan_id')->get();
        $list = Remits::select('id','remit_id','shop_name','coefficient','start_time','end_time','sale_amount','earnings','return','status');

        if ($shop_id)
        {
            $list = $list->where('shop_id', $shop_id);
        }
        if ($keyword)
        {
            $list = $list->where('remit_id', $keyword);
        }
        $list = $list->paginate(15);

        return view('finance.hit', compact('keyword','shop_id','shops','list'));
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
