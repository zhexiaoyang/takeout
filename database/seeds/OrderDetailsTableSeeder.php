<?php

use Illuminate\Database\Seeder;
use App\Models\OrderDetail;

class OrderDetailsTableSeeder extends Seeder
{
    public function run()
    {
        $order_details = factory(OrderDetail::class)->times(50)->make()->each(function ($order_detail, $index) {
            if ($index == 0) {
                // $order_detail->field = 'value';
            }
        });

        OrderDetail::insert($order_details->toArray());
    }

}

