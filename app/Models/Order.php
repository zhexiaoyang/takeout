<?php

namespace App\Models;

class Order extends Model
{
    protected $fillable = ['order_id', 'wm_order_id_view', 'app_poi_code', 'wm_poi_name', 'wm_poi_address', 'wm_poi_phone', 'recipient_address', 'recipient_phone', 'recipient_name', 'shipping_fee', 'total', 'original_price', 'caution', 'shipper_phone', 'status', 'city_id', 'has_invoiced', 'invoice_title', 'taxpayer_id', 'ctime', 'utime', 'delivery_time', 'is_third_shipping', 'pay_type', 'pick_type', 'latitude', 'longitude', 'day_seq', 'is_favorites', 'is_poi_first_order', 'dinners_number', 'logistics_code'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
