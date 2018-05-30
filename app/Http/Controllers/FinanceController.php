<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Shop;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function hit(Request $request)
    {
        $keyword = $request->keyword;
        $shop_id = $request->shop_id;
        $shops = Shop::allowShops()->select('id', 'name', 'meituan_id')->get();
        $list = [];
        return view('finance.hit', compact('keyword','shop_id','shops','list'));
    }

    public function sales(Request $request)
    {
        $keyword = $request->keyword;
        $shop_id = $request->shop_id;
        $shops = Shop::allowShops()->select('id', 'name', 'meituan_id')->get();
        $list = OrderDetail::allowShops()->paginate(15);
        return view('finance.sales', compact('keyword','shop_id','shops','list'));
    }
}
