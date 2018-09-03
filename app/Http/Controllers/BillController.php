<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Remits;
use App\Models\Shop;
use App\Models\ShopDetail;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

class BillController extends Controller
{

    protected $coefficient = 15;
    protected $start_time = '';
    protected $end_time = '';

    public function getBill($bill_id = '')
    {
        $this->makeBill($bill_id);
    }

    public function status(Remits $remits)
    {
        $remits->status = 1;
        $remits->save();
        return redirect()->back()->with('alert', '打款成功');
    }

    public function updates(Request $request)
    {
        $result['code'] = 1000;
        $bids = $request->bids;
        if (!empty($bids) && Remits::whereIn('id', $bids)->update(['status' => 1]))
        {
            $result['code'] = 0;
        }
        return response()->json($result);
    }

    public function reset(Remits $remits)
    {
//        dd($remits->remit_id);
        $this->setTime($remits->remit_id);
        $shop_id = $remits->shop_id;
        $coefficient = $this->getCoefficient($shop_id);
        $orders = $this->getOrders($shop_id);
        $sale_amount = 0;
        $earnings = 0;
        if (!empty($orders))
        {
            $shop = Shop::where(['id' => $shop_id])->first();
            $dc = $shop->dc;
            foreach ($orders as $order)
            {
                $sale_amount += ($order['total'] - $order['refund_money']);
                if ($dc)
                {
                    $earnings += ($order['total'] - $order['refund_money']);
                }else{
                    $earnings += ($order['total'] - $order['refund_money'] - $order['shipping_fee']);
                }
                $arr = json_decode(trim(urldecode($order['poi_receive_detail']),'"'), true);
                if (!empty($arr) && !empty($arr['actOrderChargeByMt']))
                {
                    foreach ($arr['actOrderChargeByMt'] as $mt) {
                        $earnings += $mt['moneyCent']/100;
                    }
                }
            }
        }
        $remits->coefficient = $coefficient;
        $remits->sale_amount = $sale_amount;
        $remits->earnings = $earnings;
        $remits->fine = 0;
        $remits->return = $earnings * (1 - $coefficient/100);
        $remits->status = $sale_amount?0:1;
        $remits->save();
        return redirect()->back()->with('alert', '重置成功');
    }

    public function makeBill($bill_id = '')
    {
        $this->setTime($bill_id);
        $shops = Shop::select('id', 'name', 'dc', 'refund_money')->where('id','>=', 100)->get()->toArray();
        $data = [];
        foreach ($shops as $shop) {
            $coefficient = $this->getCoefficient($shop['id']);
            $bill_id = date("Ymd",strtotime($this->start_time)).date("d",strtotime($this->end_time) - 3600*24).sprintf("%04d",$shop['id']);
            $orders = $this->getOrders($shop['id']);
            $dc = $shop['dc'];
            $sale_amount = 0;
            $earnings = 0;
            if (!empty($orders))
            {
                foreach ($orders as $order)
                {
                    $sale_amount += ($order['total'] - $order['refund_money']);
                    if ($dc)
                    {
                        $earnings += ($order['total'] - $order['refund_money']);
                    }else{
                        $earnings += ($order['total'] - $order['refund_money'] - $order['shipping_fee']);
                    }
                    $arr = json_decode(trim(urldecode($order['poi_receive_detail']),'"'), true);
                    if (!empty($arr) && !empty($arr['actOrderChargeByMt']))
                    {
                        foreach ($arr['actOrderChargeByMt'] as $mt) {
                            $earnings += $mt['moneyCent']/100;
                        }
                    }
                }
            }
//            echo $bill_id.'   门店ID：'.$shop['id'].'   门店订单数：'.count($orders).'    总金额：'.$sale_amount.'   '.$shop['name']."\n";
            $_arr['remit_id'] = $bill_id;
            $_arr['shop_id'] = $shop['id'];
            $_arr['shop_name'] = $shop['name'];
            $_arr['coefficient'] = $coefficient;
            $_arr['sale_amount'] = $sale_amount;
            $_arr['earnings'] = $earnings;
            $_arr['fine'] = 0;
            $_arr['return'] = $earnings * (1 - $coefficient/100);
            $_arr['status'] = $sale_amount?0:1;
            $_arr['start_time'] = $this->start_time;
            $_arr['end_time'] = date("Y-m-d", strtotime($this->end_time) - 3600*24);
            $_arr['created_at'] = date("Y-m-d H:i:s");
            $_arr['updated_at'] = date("Y-m-d H:i:s");
            $data[] = $_arr;
        }
        Remits::insert($data);
    }

    public function getOrders($shop_id)
    {
        return Order::select('poi_receive_detail','shipping_fee','original_price', 'shipping_fee','total', 'refund_money')->where('shop_id',$shop_id)->where('status','>',30)->where('created_at', '>=', $this->start_time)->where('created_at', '<', $this->end_time)->get()->toArray();
    }

    public function getCoefficient($shop_id)
    {
        $shop_detail = ShopDetail::where(['shop_id' => $shop_id])->first();
        if ($shop_detail && $shop_detail->coefficient)
        {
            return  $shop_detail->coefficient;
        }
        return $this->coefficient;
    }

    public function setTime($bill_id = '')
    {
        if ($bill_id)
        {
            $year = substr($bill_id, 0, 4);
            $month = substr($bill_id, 4, 2);
            $start_day = substr($bill_id, 6, 2);
            $end_day = substr($bill_id, 8, 2);
            $this->start_time = $year.'-'.$month.'-'.$start_day;
            $this->end_time = date("Y-m-d", strtotime($year.'-'.$month.'-'.$end_day) + 24 * 3600);
        }else{
            $year = date("Y");
            $month = date("m");
            $day = date("d");
            if ($day > 20)
            {
                $this->start_time = date("Y-m-11");
                $this->end_time = date("Y-m-21");
            }else if ($day > 10 && $day <=20){
                $this->start_time = date("Y-m-01");
                $this->end_time = date("Y-m-11");
            }else{
                $this->start_time = date('Y-m-21', strtotime('-1 month'));
                $this->end_time = date('Y-m-01');
            }
        }
    }
}
