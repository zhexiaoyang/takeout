<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Remits;
use App\Models\Shop;
use Illuminate\Http\Request;
use Excel;

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
//            $list = $list->where('remit_id', $keyword);
            $list = $list->whereHas('shop', function($query) use ($keyword){
                $query->whereHas('detail', function($query) use ($keyword){
                    $query->where('account_number', 'like', "%$keyword%")->orWhere('username', 'like', "%$keyword%");
                });
            });
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

    public function hitExport(Request $request)
    {
        $keyword = $request->keyword;
        $shop_id = $request->shop_id;
        $status = isset($request->status)?$request->status:'0';
        $stime = $request->stime;
        $etime = $request->etime;
        $shops = Shop::allowShops()->select('id', 'name', 'meituan_id')->get();
        $list = Remits::select('id','remit_id','shop_name','shop_id','coefficient','start_time','end_time','sale_amount','earnings','return','status');
        $shop_ids = array_pluck($shops->toArray(),'id');
        $data = [];

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
//            $list = $list->where('remit_id', $keyword);
            $list = $list->whereHas('shop', function($query) use ($keyword){
                $query->whereHas('detail', function($query) use ($keyword){
                    $query->where('account_number', 'like', "%$keyword%")->orWhere('username', 'like', "%$keyword%");
                });
            });
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
        $list = $list->whereIn('shop_id', $shop_ids)->orderBy('id', 'desc')->get();

        if (!empty($list))
        {
            foreach ($list as $k => $v) {
                $data[$k][] = $v->shop->detail->username?$v->shop->detail->username:'';
                $data[$k][] = $v->shop->detail->account_number?"'".$v->shop->detail->account_number:'';
                $data[$k][] = $v->shop_name;
                $data[$k][] = $v->coefficient."%";
                $data[$k][] = $v->start_time;
                $data[$k][] = $v->end_time;
                $data[$k][] = $v->sale_amount;
                $data[$k][] = $v->earnings;
                $data[$k][] = $v->return;
                $data[$k][] = $v->status?'已打款':'未打款';
            }
        }
        array_unshift($data, ["打款姓名","打款帐号","药店名称","提点","账单开始时间","账单结束时间","销售金额","药店收益","应返金额","状态"]);
        Excel::create('打款统计'.date("YmdHis"),function($excel) use ($data){
            $excel->sheet('score', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
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
