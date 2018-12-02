<?php

namespace App\Models;

use Auth;

class Shop extends Model
{
    protected $fillable = ['meituan_id', 'name', 'address', 'latitude', 'longitude', 'pic_url', 'phone', 'standby_tel', 'shipping_fee', 'shipping_time', 'promotion_info', 'open_level', 'is_online', 'invoice_support', 'invoice_min_price', 'invoice_description', 'pre_book', 'time_select', 'app_brand_code', 'mt_type_id','dc'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function detail()
    {
        return $this->hasOne(ShopDetail::class)->withDefault([
            'coefficient' => 15,
        ]);
    }

    public function scopeAllowShops($query)
    {
        if (Auth::user()->hasPermissionTo('manage_users'))
        {
            return $query;
        }
        return $query->whereIn('id', User::find(Auth::id())->shopIds());
    }
}
