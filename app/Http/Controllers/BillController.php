<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Remits;
use App\Models\Shop;
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
        return redirect()->route('finance.hit')->with('alert', '打款成功');
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
            foreach ($orders as $order)
            {
                $sale_amount += $order['total'];
                $earnings += ($order['total'] - $order['shipping_fee']);
                $arr = json_decode(trim(urldecode($order['poi_receive_detail']),'"'), true);
                if (!empty($arr) && !empty($arr['actOrderChargeByMt']))
                {
                    foreach ($arr['actOrderChargeByMt'] as $mt) {
                        $sale_amount += $mt['moneyCent']/100;
                    }
                }
            }
        }
        $remits->coefficient = $coefficient;
        $remits->sale_amount = $sale_amount;
        $remits->earnings = $earnings;
        $remits->fine = 0;
        $remits->return = $sale_amount * (1 - $coefficient/100);
        $remits->status = $sale_amount?0:1;
        $remits->save();
        return redirect()->route('finance.hit')->with('alert', '重置成功');
    }

    public function makeBill($bill_id = '')
    {
        $this->setTime($bill_id);
        $shops = Shop::select('id','name')->where('id','>=', 100)->get()->toArray();
        $data = [];
        foreach ($shops as $shop) {
            $coefficient = $this->getCoefficient($shop['id']);
            $bill_id = date("Ymd",strtotime($this->start_time)).date("d",strtotime($this->end_time) - 3600*24).sprintf("%04d",$shop['id']);
            $orders = $this->getOrders($shop['id']);
            $sale_amount = 0;
            $earnings = 0;
            if (!empty($orders))
            {
                foreach ($orders as $order)
                {
                    $sale_amount += $order['total'];
                    $earnings += ($order['total'] - $order['shipping_fee']);
                    $arr = json_decode(trim(urldecode($order['poi_receive_detail']),'"'), true);
                    if (!empty($arr) && !empty($arr['actOrderChargeByMt']))
                    {
                        foreach ($arr['actOrderChargeByMt'] as $mt) {
                            $sale_amount += $mt['moneyCent']/100;
                        }
                    }
                }
            }
//            echo $bill_id.'   门店ID：'.$shop['id'].'   门店订单数：'.count($orders).'    总金额：'.$sale_amount.'   '.$shop['name']."\n";
            $arr['remit_id'] = $bill_id;
            $arr['shop_id'] = $shop['id'];
            $arr['shop_name'] = $shop['name'];
            $arr['coefficient'] = $coefficient;
            $arr['sale_amount'] = $sale_amount;
            $arr['earnings'] = $earnings;
            $arr['fine'] = 0;
            $arr['return'] = $sale_amount * (1 - $coefficient/100);
            $arr['status'] = $sale_amount?0:1;
            $arr['start_time'] = $this->start_time;
            $arr['end_time'] = date("Y-m-d", strtotime($this->end_time) - 3600*24);
            $arr['created_at'] = date("Y-m-d H:i:s");
            $arr['updated_at'] = date("Y-m-d H:i:s");
            $data[] = $arr;
        }
        Remits::insert($data);
    }

    public function getOrders($shop_id)
    {
        return Order::select('poi_receive_detail','shipping_fee','original_price', 'shipping_fee','total')->where('shop_id',$shop_id)->where('status','>',30)->where('created_at', '>=', $this->start_time)->where('created_at', '<', $this->end_time)->get()->toArray();
    }

    public function getCoefficient($shop_id)
    {
        if (0)
        {
            $coefficient = 0;
            return $coefficient;
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
