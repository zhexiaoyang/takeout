<?php

use Illuminate\Database\Seeder;
use App\Models\ShopDetail;

class ShopDetailsTableSeeder extends Seeder
{
    public function run()
    {
        $shop_details = factory(ShopDetail::class)->times(50)->make()->each(function ($shop_detail, $index) {
            if ($index == 0) {
                // $shop_detail->field = 'value';
            }
        });

        ShopDetail::insert($shop_details->toArray());
    }

}

