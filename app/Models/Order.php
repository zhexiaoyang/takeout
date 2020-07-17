<?php

namespace App\Models;

use Auth;

class Order extends Model
{
    protected $fillable = ['order_id', 'wm_order_id_view', 'app_poi_code', 'wm_poi_name', 'wm_poi_address', 'wm_poi_phone', 'recipient_address', 'recipient_phone', 'recipient_name', 'shipping_fee', 'total', 'original_price', 'caution', 'shipper_phone', 'status', 'city_id', 'has_invoiced', 'invoice_title', 'taxpayer_id', 'ctime', 'utime', 'delivery_time', 'is_third_shipping', 'pay_type', 'pick_type', 'latitude', 'longitude', 'day_seq', 'is_favorites', 'is_poi_first_order', 'dinners_number', 'logistics_code', 'package_bag_money'];

    public function shop()
    {
        return $this->belongsTo(Shop::class)->withDefault([
            'id' => 0,
            'name' => '暂无药店'
        ]);
    }

    public function goods()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function logs()
    {
        return $this->hasMany(OrderLog::class,'order_id', 'order_id');
    }

    public function scopeAllowShops($query)
    {
        if (Auth::user()->hasPermissionTo('manage_users'))
        {
            return $query;
        }
        return $query->whereIn('shop_id', User::find(Auth::id())->shopIds());
    }

    public function earnings($order_id)
    {

        $earnings = 0;
        $order = $this->find($order_id)->toArray();
        $shop_id = isset($order['shop_id'])?$order['shop_id']:0;

        if (!$shop_id)
        {
            return 0;
        }

        $shop = Shop::where(['id' => $shop_id])->first();

        $arr = json_decode(trim(urldecode($order['poi_receive_detail']),'"'), true);

        if (!empty($arr) && !empty($arr['actOrderChargeByMt']))
        {
            foreach ($arr['actOrderChargeByMt'] as $mt) {
                $earnings += $mt['moneyCent']/100;
            }
        }

        if ($shop->dc) {
            $earnings += ($order['total'] - $order['refund_money'] - $order['package_bag_money']);
        }else{
            $earnings += ($order['total'] - $order['refund_money'] - $order['shipping_fee'] - $order['package_bag_money']);
        }

        return $earnings;
    }

    public function refunds($order_id)
    {
        $earnings = 0;
        $coefficient = 15;
        $order = $this->find($order_id)->toArray();
        $shop_id = isset($order['shop_id'])?$order['shop_id']:0;
        $returns = 0;

        if (!$shop_id)
        {
            return 0;
        }

        $shop = Shop::where(['id' => $shop_id])->first();

        $shop_detail = ShopDetail::where(['shop_id' => $shop_id])->first();

        if ($shop_detail && $shop_detail->coefficient)
        {
            $coefficient = $shop_detail->coefficient;
        }

        $arr = json_decode(trim(urldecode($order['poi_receive_detail']),'"'), true);

        if (!empty($arr) && !empty($arr['actOrderChargeByMt']))
        {
            foreach ($arr['actOrderChargeByMt'] as $mt) {
                $earnings += $mt['moneyCent']/100;
            }
        }

        if ($shop->dc) {
            $earnings += ($order['total'] - $order['refund_money'] - $order['package_bag_money']);
            $returns = $earnings * (1 - $coefficient/100);
        }else{
            $earnings += ($order['total'] - $order['refund_money'] - $order['shipping_fee'] - $order['package_bag_money']);

            if ( ($shop['id'] > 2494) || ($coefficient == 12) ) {
                if ( ($earnings * $coefficient / 100) >= 4 ) {
                    $returns = $earnings * (1 - $coefficient/100);
                } else {
                    $returns = $earnings - 4;
                }
            } else {
                $returns = $earnings * (1 - $coefficient/100);
            }
        }

        return $returns;
    }
}
