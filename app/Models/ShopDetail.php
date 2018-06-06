<?php

namespace App\Models;

class ShopDetail extends Model
{
    protected $fillable = ['shop_id', 'opening_bank', 'username', 'account_number', 'is_invoice', 'type', 'name', 'number', 'coefficient'];
}
