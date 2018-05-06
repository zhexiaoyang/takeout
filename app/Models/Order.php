<?php

namespace App\Models;

use Auth;

class Order extends Model
{
    protected $fillable = ['order_id', 'wm_order_id_view', 'app_poi_code', 'wm_poi_name', 'wm_poi_address', 'wm_poi_phone', 'recipient_address', 'recipient_phone', 'recipient_name', 'shipping_fee', 'total', 'original_price', 'caution', 'shipper_phone', 'status', 'city_id', 'has_invoiced', 'invoice_title', 'taxpayer_id', 'ctime', 'utime', 'delivery_time', 'is_third_shipping', 'pay_type', 'pick_type', 'latitude', 'longitude', 'day_seq', 'is_favorites', 'is_poi_first_order', 'dinners_number', 'logistics_code'];

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

    public function scopeAllowShops($query)
    {
        if (Auth::user()->hasPermissionTo('manage_users'))
        {
            return $query;
        }
        return $query->whereIn('shop_id', User::find(Auth::id())->shopIds());
    }
}
