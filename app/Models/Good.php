<?php

namespace App\Models;

use Auth;

class Good extends Model
{
    protected $fillable = ['deopt_id', 'price', 'shop_id', 'category_id', 'sort', 'stock', 'online'];

    public function deopt()
    {
        return $this->belongsTo(Deopt::class);
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
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
