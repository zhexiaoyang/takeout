<?php

namespace App\Models;

use Auth;

class Category extends Model
{
    protected $fillable = ['name', 'sort', 'shop_id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class)->withDefault([
            'name' => '暂无药店',
	    'id'   => 0,
        ]);
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
