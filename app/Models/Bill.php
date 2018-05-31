<?php

namespace App\Models;

use Auth;

class Bill extends Model
{
    protected $fillable = ['remit_id', 'shop_name', 'coefficient', 'sale_amount', 'earnings', 'fine', 'return', 'start_time', 'end_time'];

}
