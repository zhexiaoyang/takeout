<?php

namespace App\Models;

use Auth;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'third_order_id', 'app_food_code', 'food_name', 'sku_id', 'quantity', 'price', 'box_num', 'box_price', 'unit', 'food_discount'];

    public function scopeAllowShops($query)
    {
        if (Auth::user()->hasPermissionTo('manage_users'))
        {
            return $query;
        }
        return $query->whereIn('shop_id', User::find(Auth::id())->shopIds());
    }

    public function goods()
    {
        return $this->belongsTo(Deopt::class,'goods_id')->withDefault([
            'id' => 0,
            'name' => '没有找到该药品',
            'upc' => '没有找到该药品'
        ]);
    }
}
