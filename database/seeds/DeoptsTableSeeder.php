<?php

use Illuminate\Database\Seeder;
use App\Models\Deopt;

class DeoptsTableSeeder extends Seeder
{
    public function run()
    {
        $deopts = factory(Deopt::class)->times(50)->make()->each(function ($deopt, $index) {
            if ($index == 0) {
                // $deopt->field = 'value';
            }
        });

        Deopt::insert($deopts->toArray());
    }

}

