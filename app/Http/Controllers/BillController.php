<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Order;
use App\Models\Shop;
use Illuminate\Http\Request;

class BillController extends Controller
{

    protected $coefficient = 15;
    protected $start_time = '';
    protected $end_time = '';

    public function getBill($bid = '')
    {
        $this->makeBill($bid);
    }

    public function makeBill($bid = '',Bill $bill)
    {
        $this->setTime($bid);
        $shops = Shop::select('id','name')->where('id','>=', 100)->get()->toArray();
        foreach ($shops as $shop) {
            $orders = Order::select('poi_receive_detail','shipping_fee','original_price', 'shipping_fee')->where('shop_id',$shop['id']);
            $sale_amount = 0;
            if (!empty($orders))
            {
                foreach ($orders as $order)
                {
                    $sale_amount += ($order['total'] - $order['shipp_fee']);
                    $arr = json_decode(trim(urldecode($order->poi_receive_detail),'"'), true);
                    if (!empty($arr) && !empty($arr['actOrderChargeByMt']))
                    {
                        foreach ($arr['actOrderChargeByMt'] as $mt) {
                            $sale_amount += $mt['moneyCent']/100;
                        }
                    }
                }
            }

            $bill->remit_id = 1;
        }
    }

    public function setTime($bid = '')
    {
        if ($bid)
        {

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
