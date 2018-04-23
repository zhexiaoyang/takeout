<?php

namespace App\Models;

class Category extends Model
{
    protected $fillable = ['name', 'sort', 'shop_id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

}
