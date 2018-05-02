<?php

namespace App\Models;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'third_order_id', 'app_food_code', 'food_name', 'sku_id', 'quantity', 'price', 'box_num', 'box_price', 'unit', 'food_discount'];
}
