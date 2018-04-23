<?php

namespace App\Models;

class Shop extends Model
{
    protected $fillable = ['name', 'address', 'latitude', 'longitude', 'pic_url', 'phone', 'standby_tel', 'shipping_fee', 'shipping_time', 'promotion_info', 'open_level', 'is_online', 'invoice_support', 'invoice_min_price', 'invoice_description', 'pre_book', 'time_select', 'app_brand_code', 'mt_type_id'];
}
