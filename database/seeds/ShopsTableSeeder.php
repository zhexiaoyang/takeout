<?php

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopsTableSeeder extends Seeder
{
    public function run()
    {
        $shops = factory(Shop::class)->times(50)->make()->each(function ($shop, $index) {
            if ($index == 0) {
                // $shop->field = 'value';
            }
        });

        Shop::insert($shops->toArray());
    }

}

